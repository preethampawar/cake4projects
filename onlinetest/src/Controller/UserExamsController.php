<?php

namespace App\Controller;

use App\Model\Table\ExamsTable;
use App\Model\Table\UserExamQuestionAnswersTable;
use App\Model\Table\UserExamsTable;
use App\Model\Table\QuestionsTable;
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
        $examId = (int)base64_decode($examId);
        $error = $this->checkExamValidity($examId);

        if ($error) {
            $this->Flash->error(__($error));
            $this->redirect('/UserExams/');

            return;
        }

        $this->loadModel(ExamsTable::class);

        $exam = $this->Exams->findById($examId)
            ->contain(['ExamQuestions.Questions.QuestionOptions'])
            ->firstOrFail();

        $userExamInfo = $this->getUserExamDetails($examId);

        $this->set(compact('exam', 'userExamInfo'));
    }

    public function startTest($examId)
    {
        $examId = (int)base64_decode($examId);
        $error = $this->checkExamValidity($examId);

        if ($error) {
            $this->Flash->error(__($error));
            $this->redirect('/UserExams/');

            return;
        }

        $this->loadModel(ExamsTable::class);
        $this->loadModel(UserExamsTable::class);
        $this->loadModel(UserExamQuestionAnswersTable::class);

        $exam = $this->Exams->findById($examId)
            // ->contain(['ExamQuestions.Questions.QuestionOptions'])
            ->firstOrFail();

        $examDuration = (int)$exam->time;

        if (!$this->request->getSession()->check('writingUserExam.' . $exam->id)) {
            $data['exam_id'] = $exam->id;
            $data['user_id'] = $this->request->getSession()->read('User.id');
            $data['duration'] = $examDuration;

            $userExam = $this->UserExams->newEmptyEntity();
            $userExam = $this->UserExams->patchEntity($userExam, $data);

            if ($userExamInfo = $this->UserExams->save($userExam)) {
                $this->request->getSession()->write('writingUserExam.' . $exam->id, $userExam->id);
                $this->request->getSession()->write('userExamInfo.' . $exam->id, $userExamInfo);
                $this->Flash->success(__('Online test has started. You have ' . $examDuration . ' mins to finish it.'));
            }
        }

        $error = $this->checkUserExamValidity($examId);

        if ($error) {
            $this->cleanUpUserExamSession($examId);

            $this->Flash->error(__($error));
            $this->redirect('/UserExams/myResult/'. base64_encode($examId));

            return;
        }

        $userExamId = $this->request->getSession()->read('writingUserExam.' . $exam->id);
        $userExamQAs = $this->UserExamQuestionAnswers->findByUserExamId($userExamId)->all();

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

        $this->set(compact('exam', 'examsQuestions', 'userExamId', 'selectedQAs'));
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

    public function checkUserExamValidity($examId)
    {
        $userExamInfo = $this->request->getSession()->read('userExamInfo.' . $examId);
        $duration = (int)$userExamInfo->duration;

        $userExamElapsedTime = $this->getUserExamElapsedTime($examId);

        if ($userExamElapsedTime > $duration) {
            return 'Your exam time of ' . $duration . ' mins is over.';
        }

        return null;
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

    public function updateAnswer()
    {
        $this->layout = false;
        $data = $this->request->getData();

        $userExamQuestionAnswer['user_exam_id'] = base64_decode($data['userExamId']);
        $userExamQuestionAnswer['question_id'] = base64_decode($data['examQuestionId']);
        $userExamQuestionAnswer['answer'] = $data['selectedOption'];

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
    }

    public function getUserExamInfo($examId)
    {
        $data = $this->getUserExamDetails($examId);

        $this->set('data', $data);
    }

    private function getUserExamDetails($examId)
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

    private function checkExamValidity($examId)
    {
        $this->loadModel(ExamsTable::class);

        $examExpired = $this->Exams->find('all')
            ->where(['Exams.id' => $examId, 'Exams.deleted' => 0, 'Exams.end_date < ' => date('Y-m-d H:i:s')])
            ->first();

        if ($examExpired) {
            return 'This exam "' . $examExpired->name . '" is no longer active.';
        }

        return null;
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

        $userExamInfo = $this->getUserExamDetails($examId);
        $userExamId = $userExamInfo['id'];


        $this->cleanUpUserExamSession($examId);

        return $this->redirect('/UserExams/myResult/'.base64_encode($userExamId));
    }

    public function myResult($userExamId) {
        $userExamId = (int)base64_decode($userExamId);

        $this->loadModel(UserExamsTable::class);
        $this->loadModel(UserExamQuestionAnswersTable::class);
        $this->loadModel(QuestionsTable::class);

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

        $userExamQAs = $this->UserExamQuestionAnswers->findByUserExamId($userExamId)->all();

        $selectedQAs = [];
        foreach ($userExamQAs as $row) {
            $selectedQAs[$row->question_id] = $row->answer;
        }

        $this->set(compact('userExamInfo', 'selectedQAs'));
    }

    public function myTests()
    {
        $loggedInUserId = $this->getRequest()->getSession()->read('User.id');

        $this->loadModel(ExamsTable::class);
        $this->loadModel(UserExamsTable::class);
        $this->loadComponent('Paginator');

        $userExams = $this->Paginator->paginate(
            $userExamInfo = $this->UserExams->find('all')
                ->where(['UserExams.user_id' => $loggedInUserId])
                ->contain(['Exams']),
            [
                'limit' => '50',
                'order' => [
                    'UserExams.created' => 'desc'
                ]
            ]

        );

        $this->set(compact('userExams'));
    }

}
