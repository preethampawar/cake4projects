<?php

namespace App\Controller;

use App\Model\Table\CategoriesTable;
use App\Model\Table\ExamsTable;
use App\Model\Table\QuestionsTable;
use App\Model\Table\UserExamQuestionAnswersTable;
use App\Model\Table\UserExamsTable;
use App\Model\Table\UsersTable;
use Cake\Cache\Cache;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Query;
use DateTime;

class UserExamsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    public function index()
    {
        if ($this->request->getSession()->check('User.isAdmin')
            && $this->request->getSession()->read('User.isAdmin') == false) {
            return $this->redirect('/UserExams/list/');
        }

        $this->loadModel(ExamsTable::class);
        $this->loadComponent('Paginator');

        $exams = $this->Paginator->paginate(
            $this->Exams->find('all')
                ->where(['Exams.deleted' => 0, 'Exams.end_date > ' => date('Y-m-d H:i:s')])
                ->order('Exams.id desc'),
            [
                'limit' => '50',
                'order' => [
                    'Exams.id' => 'desc'
                ]
            ]
        );

        $this->set(compact('exams'));
    }

    public function view($examId)
    {
        if ($this->request->getSession()->check('selectedExamId')) {
            $this->request->getSession()->delete('selectedExamId');
        }

        $examId = (int)base64_decode($examId);
        $error = $this->checkExamValidity($examId);

        if ($error) {
            $this->Flash->error(__($error));
            return $this->redirect('/UserExams/');
        }

        $this->loadModel(ExamsTable::class);

        $exam = $this->Exams->findById($examId)
            ->contain(['ExamQuestions.Questions.QuestionOptions'])
            ->firstOrFail();

        $userExamInfo = $this->getUserExamTimeDetails($examId);

        $this->set(compact('exam', 'userExamInfo'));
    }

    private function checkExamValidity($examId)
    {
        $this->loadModel(ExamsTable::class);

        $examExpired = $this->Exams->find('all')
            ->where(['Exams.id' => $examId, 'Exams.deleted' => 0, 'Exams.active' => 1, 'Exams.end_date < ' => date('Y-m-d H:i:s')])
            ->first();

        if ($examExpired) {
            return 'This exam "' . $examExpired->name . '" is no longer active.';
        }

        return null;
    }

    private function getUserExamTimeDetails($examId)
    {
        $data = null;

        if ($this->request->getSession()->check('userExamInfo.' . $examId)) {
            $userExamInfo = $this->request->getSession()->read('userExamInfo.' . $examId);
            $data = $userExamInfo->toArray();
            $minutes = $this->getUserExamElapsedTime($examId);
            $data['time'] = (int)$minutes;
            $data['duration'] = (int)$userExamInfo->duration;
        }

        return $data;
    }

    private function getUserExamElapsedTime($examId)
    {
        $userExamInfo = $this->request->getSession()->read('userExamInfo.' . $examId);
        $examStartTime = new DateTime($userExamInfo->created);
        $now = new DateTime();
        $diff = $now->diff($examStartTime);
        $minutes = $diff->days * 24 * 60;
        $minutes += $diff->h * 60;
        $minutes += $diff->i;

        return (int)$minutes;
    }

    public function newTest($encodedExamId)
    {
        $examId = (int)base64_decode($encodedExamId);
        $userId = $this->request->getSession()->read('User.id');

        $this->deleteAllUserExamsByExamId($userId, $examId);

        if ($this->createUserExamSession($userId, $examId)) {
            $this->Flash->success(__('Online test has started.'));
            return $this->redirect('/UserExams/startTest/'.$encodedExamId);
        }

        $this->Flash->error(__('An error occurred while connecting to server. Please try again'));
        return $this->redirect($this->referer());
    }

    private function createUserExamSession($userId, $examId)
    {
        $error = $this->checkExamValidity($examId);

        if ($error) {
            $this->Flash->error(__($error));
            return $this->redirect('/UserExams/');
        }

        $this->loadModel(ExamsTable::class);
        $this->loadModel(UserExamsTable::class);
        $this->loadModel(UserExamQuestionAnswersTable::class);

        $examCacheKey = $this->getExamCacheKey($examId);
        $exam = Cache::read($examCacheKey);

        if ($exam === null) {
            $exam = $this->Exams->findById($examId)
                // ->contain(['ExamQuestions.Questions.QuestionOptions'])
                ->firstOrFail();
            Cache::write($examCacheKey, $exam, 'vshort');
        }

        $examDuration = (int)$exam->time;

        $data['exam_id'] = $examId;
        $data['user_id'] = $userId;
        $data['duration'] = $examDuration;

        $userExam = $this->UserExams->newEmptyEntity();
        $userExam = $this->UserExams->patchEntity($userExam, $data);

        if ($userExamInfo = $this->UserExams->save($userExam)) {
            $this->request->getSession()->write('writingUserExam.' . $examId, $userExamInfo->id);
            $this->request->getSession()->write('userExamInfo.' . $examId, $userExamInfo);

            return true;
        }

        return false;
    }

    private function deleteAllUserExamsByExamId($userId, $examId)
    {
        $this->loadModel(UserExamsTable::class);
        $this->loadModel(UserExamQuestionAnswersTable::class);

        $userExams = $this->UserExams->find('all')->where(['UserExams.user_id' => $userId, 'UserExams.exam_id' => $examId]);
        $userExamCacheKeys = [];

        foreach($userExams as $row) {
            $userExamCacheKeys[] = $this->getUserExamCacheKey($row->id);
            $userExamCacheKeys[] = $this->getUserExamSelectedQACacheKey($row->id);
        }

        Cache::deleteMany($userExamCacheKeys);

        $this->UserExams->deleteAll(['UserExams.user_id' => $userId, 'UserExams.exam_id' => $examId]);
        $this->UserExamQuestionAnswers->deleteAll(['UserExamQuestionAnswers.user_id' => $userId, 'UserExamQuestionAnswers.exam_id' => $examId]);
    }

    public function startTest($examId)
    {
        $examId = (int)base64_decode($examId);

        $error = $this->checkExamValidity($examId);
        if ($error) {
            $this->cleanUpUserExamSession($examId);
            $this->Flash->error(__($error));
            return $this->redirect('/UserExams/');
        }

        $error = $this->checkUserExamValidity($examId);
        if ($error) {
            $this->cleanUpUserExamSession($examId);

            //$this->Flash->error(__($error));
            // return $this->redirect('/UserExams/myResult/' . base64_encode($examId));
            return $this->redirect('/UserExams/myTests/');
        }

        $this->loadModel(ExamsTable::class);
        $this->loadModel(UserExamsTable::class);
        $this->loadModel(UserExamQuestionAnswersTable::class);

        $examCacheKey = $this->getExamCacheKey($examId);
        $exam = Cache::read($examCacheKey, 'vshort');

        if ($exam === null) {
            $exam = $this->Exams->findById($examId)
                // ->contain(['ExamQuestions.Questions.QuestionOptions'])
                ->firstOrFail();
            Cache::write($examCacheKey, $exam, 'vshort');
        }

        $userExamInfo = $this->request->getSession()->read('userExamInfo.' . $examId);
        $userExamQAs = $this->UserExamQuestionAnswers->findByUserExamId($userExamInfo->id)->all();

        $selectedQAs = [];
        foreach ($userExamQAs as $row) {
            $selectedQAs[$row->question_id] = $row->answer;
        }

        $examsQuestions = $this->Paginator->paginate(
            $this->Exams->ExamQuestions->findByExamId($examId)->contain(['Questions.QuestionOptions']),
            [
                'limit' => 1,
                'order' => [
                    'ExamQuestions.id' => 'asc'
                ]
            ]
        );

        $this->set(compact('exam', 'examsQuestions', 'userExamInfo', 'selectedQAs'));
    }

    public function checkUserExamValidity($examId)
    {
        if (!$this->request->getSession()->check('userExamInfo.' . $examId)) {
            return 'You have already finished this exam.';
        }
        $userExamInfo = $this->request->getSession()->read('userExamInfo.' . $examId);
        $duration = (int)$userExamInfo->duration;

        $userExamElapsedTime = $this->getUserExamElapsedTime($examId);

        if ($userExamElapsedTime > $duration) {
            return 'Your exam time of ' . $duration . ' mins is over.';
        }

        return null;
    }

    private function cleanUpUserExamSession($examId)
    {
        $this->request->getSession()->delete('writingUserExam.' . $examId);
        $this->request->getSession()->delete('userExamInfo.' . $examId);
    }

    public function clearUserExamSession($examId)
    {
        $this->cleanUpUserExamSession($examId);
    }

    public function updateAnswer()
    {
        $this->setLayout('ajax');
        $data = null;

        if ($this->isLoggedIn()) {
            $data = $this->request->getData();
            $userExamQuestionAnswer['user_exam_id'] = base64_decode($data['userExamId']);
            $userExamQuestionAnswer['question_id'] = base64_decode($data['examQuestionId']);
            $userExamQuestionAnswer['answer'] = $data['selectedOption'];
            $userExamQuestionAnswer['exam_id'] = base64_decode($data['examId']);
            $userExamQuestionAnswer['user_id'] = $this->request->getSession()->read('User.id');

            $this->loadModel(UserExamQuestionAnswersTable::class);
            $userExamQA = $this->UserExamQuestionAnswers->find('all')
                ->where([
                    'UserExamQuestionAnswers.user_exam_id' => $userExamQuestionAnswer['user_exam_id'],
                    'UserExamQuestionAnswers.question_id' => $userExamQuestionAnswer['question_id'],
                ])
                ->first();

            if ($userExamQA) {
                $userExamQA = $this->UserExamQuestionAnswers->patchEntity($userExamQA, $userExamQuestionAnswer);
            } else {
                $userExamQA = $this->UserExamQuestionAnswers->newEmptyEntity();
                $userExamQA = $this->UserExamQuestionAnswers->patchEntity($userExamQA, $userExamQuestionAnswer);
            }

            $this->UserExamQuestionAnswers->save($userExamQA);

            $data = $this->getUserExamTimeDetails($userExamQuestionAnswer['exam_id']);
        }

        $this->set('data', $data);
    }

    private function getUserExamQADetails($examId)
    {
        $userExamInfo = $this->request->getSession()->read('userExamInfo.' . $examId);

        $query = sprintf("SELECT
                    q.id, q.name, ueqa.question_id AS attempted_question_id
                FROM
                    user_exams ue
                        LEFT JOIN
                    exam_questions eq ON eq.exam_id = ue.exam_id
                        LEFT JOIN
                    questions q ON q.id = eq.question_id AND q.deleted = 0
                        LEFT JOIN
                    user_exam_question_answers ueqa ON ueqa.user_exam_id = ue.id
                        AND ueqa.question_id = q.id
                WHERE
                    ue.id = %s
                ORDER BY eq.id ASC", $userExamInfo->id);

        return $this->query($query);
    }

    public function getUserExamTimeInfo($examId)
    {
        $this->setLayout('ajax');
        $data = null;

        if ($this->isLoggedIn()) {
            $data = $this->getUserExamTimeDetails($examId);
        }

        $this->set('data', $data);
    }

    public function getUserExamQAInfo($examId, $selectedQuestionNo = null)
    {
        $this->setLayout('ajax');
        $examTimeDetails = null;
        $selectedQA = null;

        if (!$selectedQuestionNo) {
            $selectedQuestionNo = '1';
        }


        if ($this->isLoggedIn()) {
            $examTimeDetails = $this->getUserExamTimeDetails($examId);
            $selectedQA = $this->getUserExamQADetails($examId);
        }

        $this->set('examTimeDetails', $examTimeDetails);
        $this->set('selectedQA', $selectedQA);
        $this->set('selectedQuestionNo', $selectedQuestionNo);
        $this->set('examId', $examId);
    }

    public function cancelTest($examId)
    {
        $this->loadModel(UserExamsTable::class);
        $this->loadModel(UserExamQuestionAnswersTable::class);

        $examId = (int)base64_decode($examId);
        $userExamInfo = $this->request->getSession()->read('userExamInfo.' . $examId);

        if (!$userExamInfo) {
            $this->Flash->error(__('Session expired.'));

            return $this->redirect('/UserExams/');
        }

        $userExamId = $userExamInfo->id;

        $userExamDetails = $this->UserExams->findById($userExamId)->first();

        if ($userExamDetails) {
            // delete all questions related to this user attempted exam
            $this->UserExamQuestionAnswers->deleteAll(['UserExamQuestionAnswers.user_exam_id' => $userExamId]);

            $data['cancelled'] = true;
            $userExamDetails = $this->UserExams->patchEntity($userExamDetails, $data);

            $this->UserExams->save($userExamDetails);

            $this->cleanUpUserExamSession($examId);

            $this->Flash->error(__('You have cancelled the ongoing test.'));

            return $this->redirect('/UserExams/');
        }

        $this->Flash->error(__('Please try again.'));

        return $this->redirect($this->referer());
    }

    public function finishTest($examId)
    {
        $examId = (int)base64_decode($examId);

        $userExamInfo = $this->getUserExamTimeDetails($examId);
        $userExamId = $userExamInfo['id'];


        $this->cleanUpUserExamSession($examId);

        return $this->redirect('/UserExams/myResult/' . base64_encode($userExamId));
    }

    public function myResult($userExamId)
    {
        $userExamId = (int)base64_decode($userExamId);

        $this->loadModel(UserExamsTable::class);
        $this->loadModel(UserExamQuestionAnswersTable::class);
        $this->loadModel(QuestionsTable::class);

        $userExamCacheKey = $this->getUserExamCacheKey($userExamId);
        $userExamSelectedQACacheKey = $this->getUserExamSelectedQACacheKey($userExamId);
        $result = Cache::readMany([
            $userExamCacheKey,
            $userExamSelectedQACacheKey
        ] );
        $userExamInfo = $result[$userExamCacheKey];
        $selectedQAs = $result[$userExamSelectedQACacheKey];

        if ($userExamInfo === null) {
            $userExamInfo = $this->UserExams
                ->findById($userExamId)
                ->contain([
                    'Exams' => [
                        'ExamQuestions' => [
                            'Questions' => [
                                'QuestionOptions'
                            ]
                        ]
                    ]
                ])
                ->first();
            Cache::write($userExamCacheKey, $userExamInfo);
        }

        if ($selectedQAs === null) {
            $userExamQAs = $this->UserExamQuestionAnswers->findByUserExamId($userExamId)->all();

            $selectedQAs = [];
            foreach ($userExamQAs as $row) {
                $selectedQAs[$row->question_id] = $row->answer;
            }

            Cache::write($userExamSelectedQACacheKey, $selectedQAs);
        }

        if (empty($userExamInfo)) {
            $this->Flash->error('Page not found');

            return $this->redirect('/UserExams/myTests');
        }

        $this->set(compact('userExamInfo', 'selectedQAs'));
    }

    public function myTests()
    {
        $loggedInUserId = $this->getRequest()->getSession()->read('User.id');

        $this->loadModel(ExamsTable::class);
        $this->loadModel(UserExamsTable::class);
        $this->loadComponent('Paginator');
        $this->loadModel(UserExamQuestionAnswersTable::class);

        $userExams = $this->Paginator->paginate(
            $userExamInfo = $this->UserExams->find('all')
                ->where(['UserExams.user_id' => $loggedInUserId])
                ->contain([
                    'Exams' => [
                        'ExamQuestions' => [
                            'Questions' => [
                                'QuestionOptions'
                            ]
                        ]
                    ]
                ]),
            [
                'limit' => '50',
                'order' => [
                    'UserExams.created' => 'desc'
                ]
            ]

        );

        $userExamQuestionAnswersModel = $this->UserExamQuestionAnswers;

        $this->set(compact('userExams', 'userExamQuestionAnswersModel'));
    }

    public function list($categoryId = null)
    {
        if ($this->request->getSession()->check('selectedExamId')) {
            $this->request->getSession()->delete('selectedExamId');
        }

        $this->loadModel(ExamsTable::class);
        $this->loadComponent('Paginator');
        $examsCacheKey = $this->getExamsCacheKey($categoryId);
        $allCategoriesCacheKey = $this->getAllCategoriesCacheKey();
        $exams = Cache::read($examsCacheKey, 'vshort');
        $categories = Cache::read($allCategoriesCacheKey, 'vshort');

        if ($exams === null) {
            $conditions = ['Exams.deleted' => 0, 'Exams.active' => 1, 'Exams.end_date > ' => date('Y-m-d H:i:s')];
            $query = $this->Exams->find('all')->contain(['ExamCategories', 'ExamQuestions']);

            if ($categoryId) {
                $query = $query->matching('ExamCategories', function (Query $q) use ($categoryId){
                    return $q->where(['ExamCategories.category_id' => $categoryId]);
                });
            }

            $query = $query->where($conditions)->order('Exams.id desc');
            $exams = $query->all();
            Cache::write($examsCacheKey, $exams, 'vshort');
        }

        if ($categories === null) {
            $this->loadModel(CategoriesTable::class);
            $categories = $this->Categories->find('all')->select(['Categories.id', 'Categories.name'])->where(['Categories.deleted' => 0])->order('name asc')->all();
            Cache::write($allCategoriesCacheKey, $categories, 'vshort');
        }

        $this->set(compact('exams'));
        $this->set('categories', $categories);
        $this->set('selectedCategoryId', $categoryId);
        $this->set('isAdmin', $this->isAdmin());
    }

    public function select($examId)
    {
        $this->loadModel(ExamsTable::class);

        if($this->request->getSession()->check('User.id')) {
            return $this->redirect('/UserExams/view/' . $examId);
        }

        $examId = (int)base64_decode($examId);
        $exam = $this->Exams->findById($examId)
            ->contain(['ExamQuestions.Questions.QuestionOptions'])
            ->firstOrFail();

        $title = 'Select';
        $this->set(compact('exam', 'title'));
    }

    public function initiate($examId)
    {
        $this->request->getSession()->write('selectedExamId', $examId);

        if($this->request->getSession()->check('User.id')) {
            return $this->redirect('/UserExams/view/' . $examId);
        }

        return $this->redirect('/Users/login');
    }

    public function users()
    {
        $this->allowAdmin();

        $userIds = [];

        $this->loadModel(UsersTable::class);
        $this->loadComponent('Paginator');

        $users = $this->Paginator->paginate(
            $this->Users->find('all')
                ->where(['Users.deleted' => 0, 'Users.is_admin ' => 0]),
            [
                'limit' => '100',
                'order' => [
                    'Users.name' => 'asc'
                ]
            ]
        );

        $userIds = [];
        foreach($users as $user) {
            $userIds[] = $user->id;
        }

        $stats = $this->basicStats($userIds);

        $this->set(compact('users', 'stats'));
    }

    public function userAttendedExams($userId=null, $examId = null)
    {
        $userId = $userId === 'null' ? null : $userId;
        $examId = $examId === 'null' ? null : $examId;

        $this->allowAdmin();

        $this->loadModel(ExamsTable::class);
        $this->loadModel(UsersTable::class);

        $exams = $this->Exams->find()->where(['Exams.deleted' => 0])->order(['Exams.id desc'])->select(['Exams.id', 'Exams.name'])->all();
        $users = $this->Users->find()->where(['Users.deleted' => 0])->order(['Users.id desc'])->select(['Users.id', 'Users.name', 'Users.username'])->all();


        $stats = $this->allStats($userId, $examId);
        $this->set(compact('stats', 'exams', 'users', 'userId', 'examId'));
    }

    public function details($userId, $examId = null)
    {
        $this->allowAdmin();

        $stats = $this->allStats($userId);
        $this->set(compact('stats'));
    }

    public function allStats($userIds = null, $examId = null)
    {
        if ($userIds != null && !is_array($userIds)) {
            $userIds = [$userIds];
        }

        $query = $this->getAllStatsQuery($userIds, $examId);


        $results = $this->query($query);

        $formattedResults = [];
        if ($results) {
            foreach ($results as $row) {
                $formattedResults[$row['user_id']]['id'] = $row['user_id'];
                $formattedResults[$row['user_id']]['name'] = $row['name'];
                $formattedResults[$row['user_id']]['username'] = $row['username'];
                $formattedResults[$row['user_id']]['phone'] = $row['phone'];
                $formattedResults[$row['user_id']]['email'] = $row['email'];

                $formattedResults[$row['user_id']]['Exams'][$row['exam_id']]['id'] = $row['exam_id'];
                $formattedResults[$row['user_id']]['Exams'][$row['exam_id']]['name'] = $row['exam_name'];
                $formattedResults[$row['user_id']]['Exams'][$row['exam_id']]['duration'] = $row['duration'];

                $formattedResults[$row['user_id']]['Exams'][$row['exam_id']]['UserExams'][$row['ue_id']]['id']  = $row['ue_id'];
                $formattedResults[$row['user_id']]['Exams'][$row['exam_id']]['UserExams'][$row['ue_id']]['created']  = $row['ue_created'];

                $formattedResults[$row['user_id']]['Exams'][$row['exam_id']]['UserExams'][$row['ue_id']]['Questions'][$row['question_id']]['id']  = $row['question_id'];
                $formattedResults[$row['user_id']]['Exams'][$row['exam_id']]['UserExams'][$row['ue_id']]['Questions'][$row['question_id']]['name']  = $row['question_name'];
                $formattedResults[$row['user_id']]['Exams'][$row['exam_id']]['UserExams'][$row['ue_id']]['Questions'][$row['question_id']]['options']  = $row['question_options'];
                $formattedResults[$row['user_id']]['Exams'][$row['exam_id']]['UserExams'][$row['ue_id']]['Questions'][$row['question_id']]['default_answer']  = $row['question_answer'];
                $formattedResults[$row['user_id']]['Exams'][$row['exam_id']]['UserExams'][$row['ue_id']]['Questions'][$row['question_id']]['selected_answer']  = $row['selected_answer'];
                $formattedResults[$row['user_id']]['Exams'][$row['exam_id']]['UserExams'][$row['ue_id']]['Questions'][$row['question_id']]['selected_answer_status']  = $row['answer_status'];

            }

            foreach($formattedResults as &$user) {
                $user['exams_attended'] = isset($user['Exams']) ? count($user['Exams']) : 0;

                foreach($user['Exams'] as &$exam) {
                    $exam['attempts'] = 0;
                    if (isset($exam['UserExams'])) {
                        $attempts = isset($exam['UserExams']) ? count($exam['UserExams']) : 0;
                        $exam['attempts'] = $attempts;

                        foreach($exam['UserExams'] as &$userExam) {

                            if (isset($userExam['Questions'])) {
                                $exam['total_questions'] = $userExam['total_questions'] = count($userExam['Questions']);

                                $correct = 0;
                                $wrong = 0;
                                $not_attempted = 0;
                                foreach($userExam['Questions'] as $question) {
                                    switch($question['selected_answer_status']) {
                                        case '0':
                                            $wrong++;
                                            break;
                                        case '1':
                                            $correct++;
                                            break;
                                        default:
                                            $not_attempted++;
                                            break;
                                    }
                                }

                                $userExam['correct'] = $correct;
                                $userExam['wrong'] = $wrong;
                                $userExam['not_attempted'] = $not_attempted;
                                $percent = $userExam['total_questions'] > 0 ? (($correct*100) / $userExam['total_questions']) : 0;
                                $userExam['score_percentage'] = round($percent, 2);

                            }

                        }

                    }



                }

            }
        }

        return $formattedResults;
    }

    public function basicStats($userIds = null, $params = [])
    {
        if ($userIds != null && !is_array($userIds)) {
            $userIds = [$userIds];
        }

        $query = $this->getBasicStatsQuery($userIds);
        $results = $this->query($query);

        $formattedResults = [];

        if ($results) {
            foreach ($results as $row) {
                $formattedResults[$row['user_id']]['id'] = $row['user_id'];
                $formattedResults[$row['user_id']]['name'] = $row['name'];
                $formattedResults[$row['user_id']]['username'] = $row['username'];
                $formattedResults[$row['user_id']]['phone'] = $row['phone'];
                $formattedResults[$row['user_id']]['email'] = $row['email'];

                $formattedResults[$row['user_id']]['Exams'][$row['exam_id']]['id'] = $row['exam_id'];
                $formattedResults[$row['user_id']]['Exams'][$row['exam_id']]['name'] = $row['exam_name'];
                $formattedResults[$row['user_id']]['Exams'][$row['exam_id']]['duration'] = $row['duration'];

                $formattedResults[$row['user_id']]['Exams'][$row['exam_id']]['UserExams'][$row['ue_id']]['id']  = $row['ue_id'];
                $formattedResults[$row['user_id']]['Exams'][$row['exam_id']]['UserExams'][$row['ue_id']]['created']  = $row['ue_created'];
            }

            foreach($formattedResults as &$user) {
                $user['exams_attended'] = isset($user['Exams']) ? count($user['Exams']) : 0;

                foreach($user['Exams'] as &$exam) {
                    $exam['attempts'] = 0;
                    if (isset($exam['UserExams'])) {
                        $attempts = isset($exam['UserExams']) ? count($exam['UserExams']) : 0;
                        $exam['attempts'] = $attempts;
                    }
                }

            }
        }

        return $formattedResults;
    }

    public function getAllStatsQuery($userIds=[], $examId = null)
    {
        $userIdsCondition = '';
        if ($userIds) {
            $userIdsCondition = sprintf(' and u.id IN (%s) ', implode(',', $userIds));
        }

        $examIdCondition = '';
        if ($examId) {
            $examIdCondition = sprintf(' and e.id IN (%s) ', $examId);
        }

        return "
            select
                u.id user_id, u.name, u.username, u.phone, u.email,
                ue.id ue_id, ue.created ue_created,
                e.id exam_id, e.name exam_name, e.time duration,
                eq.id eq_id,
                q.id question_id, q.name question_name, q.answer question_answer,
                group_concat(qo.name) question_options,
                ueqa.id ueqa_id, ueqa.answer selected_answer,
                if(isnull(ueqa.answer), '-1', (if(q.answer = ueqa.answer, '1', '0'))) answer_status
            from users u
                left join user_exams ue on ue.user_id = u.id
                left join exams e on e.id = ue.exam_id
                left join exam_questions eq on eq.exam_id = e.id
                left join questions q on q.id = eq.question_id
                left join question_options qo on qo.question_id = q.id
                left join user_exam_question_answers ueqa on (ueqa.user_exam_id = ue.id and ueqa.question_id = q.id)
            where u.is_admin = 0 and ue.cancelled = 0 " . $userIdsCondition . $examIdCondition . "
            group by u.id, e.id, ue.id, q.id
            order by ue.created desc, eq.id asc, qo.sort asc
        ";
    }

    public function getBasicStatsQuery($userIds=[])
    {
        $userIdsCondition = '';
        if ($userIds) {
            $userIdsCondition = sprintf(' and u.id IN (%s) ', implode(',', $userIds));
        }

        return "
            select
                u.id user_id, u.name, u.username, u.phone, u.email,
                ue.id ue_id, ue.created ue_created,
                e.id exam_id, e.name exam_name, e.time duration

            from users u
                left join user_exams ue on ue.user_id = u.id
                left join exams e on e.id = ue.exam_id
            where u.is_admin = 0 and ue.cancelled = 0 " . $userIdsCondition . "
            group by u.id, e.id, ue.id
            order by u.id desc
        ";
    }

    private function deleteByUserExamId($userExamId)
    {
        $this->loadModel(UserExamsTable::class);
        $this->loadModel(UserExamQuestionAnswersTable::class);

        $this->UserExams->deleteAll(['UserExams.id' => $userExamId]);
        $this->UserExamQuestionAnswers->deleteAll(['UserExamQuestionAnswers.user_exam_id' => $userExamId]);

        $userExamCacheKey = $this->getUserExamCacheKey($userExamId);
        $userExamSelectedQACacheKey = $this->getUserExamSelectedQACacheKey($userExamId);
        $result = Cache::deleteMany([
            $userExamCacheKey,
            $userExamSelectedQACacheKey
        ]);
    }

    public function delete($userExamId) {
        $this->allowAdmin();
        $this->deleteByUserExamId($userExamId);
        $this->Flash->success("User exam deleted successfully.");

        return $this->redirect($this->referer());
    }
}
