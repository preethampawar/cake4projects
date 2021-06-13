<?php

namespace App\Controller;

use App\Model\Table\CategoriesTable;
use App\Model\Table\EducationLevelsTable;
use App\Model\Table\ExamCategoriesTable;
use App\Model\Table\ExamGroupsTable;
use App\Model\Table\ExamQuestionsTable;
use App\Model\Table\QuestionsTable;
use App\Model\Table\SubjectsTable;
use App\Model\Table\TagsTable;
use Cake\Cache\Cache;
use Cake\Event\EventInterface;
use Cake\ORM\Query;

class ExamsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        if ($this->request->getSession()->check('User.isAdmin')
            && $this->request->getSession()->read('User.isAdmin') == false) {
            $this->Flash->error('You are not authorized to access this page');
            return $this->redirect('/UserExams/list/');
        }
    }

    public function index($examGroupId = null, $categoryId = null)
    {
        $examGroupId = $examGroupId === 'null' ? null : $examGroupId;
        $categoryId = $categoryId === 'null' ? null : $categoryId;

        $this->loadComponent('Paginator');

        $conditions = ['Exams.deleted' => 0];

        if ($examGroupId) {
            $conditions[] = ['Exams.exam_group_id' => $examGroupId];
        }

        $query = $this->Exams->find('all')->contain(['ExamCategories', 'ExamQuestions', 'ExamGroups']);

        if ($categoryId) {
            $query = $query->matching('ExamCategories', function (Query $q) use ($categoryId) {
                return $q->where(['ExamCategories.category_id' => $categoryId]);
            });
        }

        $query = $query->where($conditions);

        $exams = $this->Paginator->paginate(
            $query,
            [
                'limit' => 50,
                'order' => [
                    'Exams.id' => 'desc'
                ]
            ]
        );

        $this->loadModel(CategoriesTable::class);
        $categories = $this->Categories->find('all')->select(['Categories.id', 'Categories.name'])->where(['Categories.deleted' => 0])->order('name asc')->all();

        $this->loadModel('ExamGroups');
        $examGroups = $this->ExamGroups->find('all')->select(['ExamGroups.id', 'ExamGroups.name'])->where(['ExamGroups.deleted' => 0])->order('name asc')->all();

        $this->set(compact('exams'));
        $this->set('categories', $categories);
        $this->set('examGroups', $examGroups);
        $this->set('examGroupId', $examGroupId);
        $this->set('categoryId', $categoryId);
    }

    public function groupView()
    {
        $this->loadComponent('Paginator');
        $this->loadModel('ExamGroups');

        $examGroupsQery = $this->ExamGroups->find();
        $examGroupsQery->select(['exams_count' => $examGroupsQery->func()->count('Exams.id'), 'exams_deleted' => 'Exams.deleted'])
            ->leftJoinWith('Exams')
            ->where(['ExamGroups.deleted' => 0])
            ->group(['ExamGroups.id', 'Exams.deleted'])
            ->enableAutoFields(true);

        $examGroups = $this->Paginator->paginate(
            $examGroupsQery,
            [
                'limit' => 50,
                'order' => [
                    'ExamGroups.id' => 'desc'
                ],
            ]
        );

        $this->set(compact('examGroups'));
    }

    public function view($id)
    {
        $exam = $this->Exams->findById($id)
            ->contain(['ExamQuestions.Questions.QuestionOptions'])
            ->firstOrFail();

        $this->set(compact('exam'));
    }

    public function add()
    {
        $exam = $this->Exams->newEmptyEntity();

        if ($this->request->is('post')) {
            $examData = $this->request->getData();
            $error = $this->validateExam($examData);

            if ($error) {
                $this->Flash->error(__($error));

                return;
            }

            $exam = $this->Exams->patchEntity($exam, $examData);

            if ($examInfo = $this->Exams->save($exam)) {
                $this->loadModel(ExamCategoriesTable::class);
                $categoryIds = $examData['categories'];

                if ($categoryIds) {
                    foreach ($categoryIds as $categoryId) {
                        $examCategory = $this->ExamCategories->newEmptyEntity();
                        $data = [];
                        $data['exam_id'] = $examInfo->id;
                        $data['category_id'] = $categoryId;

                        $examCategory = $this->ExamCategories->patchEntity($examCategory, $data);

                        $this->ExamCategories->save($examCategory);
                    }
                }

                $this->Flash->success(__('Test has been saved.'));

                return $this->redirect(['controller' => 'exams', 'action' => 'addQuestions', $examInfo->id]);
            }

            $this->Flash->error(__('Unable to create new test.'));
        }

        $this->loadModel(CategoriesTable::class);
        $categories = $this->Categories->find('all')->select(['Categories.id', 'Categories.name'])->where(['Categories.deleted' => 0])->order('name asc')->all();

        $this->loadModel(ExamGroupsTable::class);
        $examGroups = $this->ExamGroups->find('all')->select(['ExamGroups.id', 'ExamGroups.name'])->where(['ExamGroups.deleted' => 0])->order('name asc')->all();

        $this->set('exam', $exam);
        $this->set('categories', $categories);
        $this->set('examGroups', $examGroups);
    }

    public function addQuestions($examId)
    {
        $params = $this->request->getQueryParams();
        $selectedSubject = null;
        $selectedEducationLevel = null;
        $selectedDifficultyLevel = null;
        $selectedTags = null;

        if (isset($params['subject']) and !empty($params['subject'])) {
            $selectedSubject = $params['subject'];
        }
        if (isset($params['level']) and !empty($params['level'])) {
            $selectedEducationLevel = $params['level'];
        }
        if (isset($params['difficulty_level']) and !empty($params['difficulty_level'])) {
            $selectedDifficultyLevel = $params['difficulty_level'];
        }
        if (isset($params['tags']) and !empty($params['tags'])) {
            $selectedTags = $params['tags'];
        }

        $this->loadModel(QuestionsTable::class);
        $this->loadComponent('Paginator');

        $query = $this->Questions->find('all')
            ->where(['Questions.deleted' => 0])
            ->order('Questions.id desc');

        if ($selectedSubject) {
            $query->andWhere(['Questions.subject in' => $selectedSubject]);
        }
        if ($selectedEducationLevel) {
            $query->andWhere(['Questions.level in' => $selectedEducationLevel]);
        }
        if ($selectedDifficultyLevel) {
            $query->andWhere(['Questions.difficulty_level in' => $selectedDifficultyLevel]);
        }
        if ($selectedTags) {
            $likeTags = [];

            foreach ($selectedTags as $tag) {
                $likeTags[] = ['Questions.tags like ' => "%$tag%"];
            }

            $query->andWhere(['OR' => $likeTags]);
        }

        $questions = $this->Paginator->paginate(
            $query,
            [
                'limit' => 1000,
                'order' => [
                    'Questions.id' => 'desc'
                ]
            ]

        );

        $exam = $this->Exams->findById($examId)->contain(['ExamGroups'])->firstOrFail();


        $this->loadModel(SubjectsTable::class);
        $this->loadModel(EducationLevelsTable::class);
        $this->loadModel(TagsTable::class);

        $subjects = $this->Subjects->find('all')->select(['Subjects.name'])->order('name asc')->all();
        $educationLevels = $this->EducationLevels->find('all')->select(['EducationLevels.name'])->order('name asc')->all();
        $tags = $this->Tags->find('all')->select(['Tags.name'])->order('name asc')->all();

        $this->set('subjects', $subjects);
        $this->set('selectedSubject', $selectedSubject);
        $this->set('educationLevels', $educationLevels);
        $this->set('selectedEducationLevel', $selectedEducationLevel);
        $this->set('tags', $tags);
        $this->set('selectedTags', $selectedTags);
        $this->set('selectedDifficultyLevel', $selectedDifficultyLevel);

        $this->set(compact('questions'));
        $this->set(compact('exam'));
    }

    public function loadSelectedExamQuestions($examId)
    {
        $this->setLayout('ajax');

        $examQuestions = $this->getExamQuestions($examId);

        $exams = $this->Exams->find('all')
            ->select(['Exams.id', 'Exams.name'])
            ->where(['Exams.deleted' => 0])
            ->all();

        $this->set('examId', $examId);
        $this->set('examQuestions', $examQuestions);
        $this->set('exams', $exams);
    }

    public function addSelectedQuestion()
    {
        $this->layout = false;
        $data = $this->request->getData();
        $data['sort'] = time();

        $error = $this->checkDuplicateExamQuestion($data);

        if (!$error) {
            $error = $this->checkAddQuestionsLimit($data['exam_id']);
        }

        if (!$error) {
            $examQuestions = $this->Exams->newEmptyEntity();
            $examQuestions = $this->Exams->ExamQuestions->patchEntity($examQuestions, $data);

            $this->Exams->ExamQuestions->save($examQuestions);
        }

        $this->set('error', $error);
    }

    public function deleteSelectedExamQuestion()
    {
        $this->request->allowMethod(['post', 'delete']);

        $data = $this->request->getData();

        $examQuestion = $this->Exams->ExamQuestions->findById($data['examQuestionId'])->firstOrFail();

        $this->Exams->ExamQuestions->delete($examQuestion);
    }

    private function getExamQuestions($examId)
    {
        return $examQuestions = $this->Exams->ExamQuestions->find('all')
            ->select(['ExamQuestions.id', 'Questions.name', 'Questions.id'])
            ->where(['exam_id' => $examId])
            ->contain(['Questions'])
            ->all()
            ->toArray();
    }

    private function validateExam($data)
    {
        if (empty(trim($data['name']))) {
            return 'Please enter the test name.';
        }

        if (empty(trim($data['time']))) {
            return 'Please enter the test duration.';
        }

        if (empty($data['start_date'])) {
            return 'Please enter the start date.';
        }
        if (empty($data['end_date'])) {
            return 'Please enter the end date.';
        }
        if (empty($data['exam_group_id'])) {
            return 'Please select ExamGroup.';
        }

        return null;
    }

    private function checkDuplicateExamQuestion($data)
    {
        if (empty(trim($data['exam_id']))) {
            return 'Please select a test.';
        }

        if (empty(trim($data['question_id']))) {
            return 'Please select a question.';
        }

        $examQuestionsQuery = $this->Exams->ExamQuestions->find('all')
            ->where(['ExamQuestions.exam_id' => $data['exam_id'], 'ExamQuestions.question_id' => $data['question_id']]);
        $examQuestions = $examQuestionsQuery->all()->toArray();

        if (!empty($examQuestions)) {
            return 'This question is already selected for the test';
        }

        return null;
    }

    private function checkAddQuestionsLimit($examId)
    {
        $exam = $this->Exams->findById($examId)->first();
        $totalExamQuestions = (int)$exam->total_questions;

        $examQuestionsQuery = $this->Exams->ExamQuestions->find('all')
            ->where(['ExamQuestions.exam_id' => $examId]);
        $selectedQuestions = $examQuestionsQuery->count();

        if ($selectedQuestions >= $totalExamQuestions) {
            return 'You cannot add more that "' . $totalExamQuestions . '" questions';
        }

        return null;
    }

    private function checkIfAllQuestionsAreSelected($examId)
    {
        $exam = $this->Exams->findById($examId)->first();
        $totalExamQuestions = (int)$exam->total_questions;

        $examQuestionsQuery = $this->Exams->ExamQuestions->find('all')
            ->where(['ExamQuestions.exam_id' => $examId]);
        $selectedQuestions = $examQuestionsQuery->count();

        if ($selectedQuestions != $totalExamQuestions) {
            return 'To publish this test, you should select "' . $totalExamQuestions . '" questions';
        }

        return null;
    }

    public function edit($id)
    {
        $exam = $this->Exams
            ->findById($id)
            ->contain(['ExamCategories'])
            ->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $examData = $this->request->getData();


            if (empty($examData['pass_type']) || empty($examData['pass_value'])) {
                $examData['pass_type'] = '';
                $examData['pass_value'] = '';
            }

            $this->Exams->patchEntity($exam, $examData);

            if ($this->Exams->save($exam)) {
                $this->Exams->ExamCategories->deleteAll(['exam_id' => $id]);
                $categoryIds = $examData['categories'];

                if ($categoryIds) {
                    foreach ($categoryIds as $categoryId) {
                        $examCategory = $this->Exams->ExamCategories->newEmptyEntity();
                        $data = [];
                        $data['exam_id'] = $id;
                        $data['category_id'] = $categoryId;

                        $examCategory = $this->Exams->ExamCategories->patchEntity($examCategory, $data);

                        $this->Exams->ExamCategories->save($examCategory);
                    }
                }

                $this->Flash->success(__('Test details have been updated successfully.'));

                return $this->redirect(['controller' => 'Exams', 'action' => 'addQuestions', $exam->id]);
            }

            $this->Flash->error(__('Unable to update your test.'));
        }

        $this->loadModel(CategoriesTable::class);
        $categories = $this->Categories->find('all')->select(['Categories.id', 'Categories.name'])->where(['Categories.deleted' => 0])->order('name asc')->all();

        $this->loadModel(ExamGroupsTable::class);
        $examGroups = $this->ExamGroups->find('all')->select(['ExamGroups.id', 'ExamGroups.name'])->where(['ExamGroups.deleted' => 0])->order('name asc')->all();

        $this->set('exam', $exam);
        $this->set('categories', $categories);
        $this->set('examGroups', $examGroups);
    }

    public function publish($examId)
    {
        $error = $this->checkIfAllQuestionsAreSelected($examId);

        if ($error) {
            $this->Flash->error($error);

            return $this->redirect($this->referer());
        }

        $exam = $this->Exams
            ->findById($examId)
            ->firstOrFail();

        $examData['active'] = 1;
        $this->Exams->patchEntity($exam, $examData);

        if ($this->Exams->save($exam)) {
            $this->Flash->success(__('Test "' . $exam->name . '" has been published successfully.'));

            return $this->redirect('/Exams/');
        }

        $this->Flash->error(__('Unable to publish this test.'));

        return $this->redirect($this->referer());
    }

    public function delete($id)
    {
        $exam = $this->Exams->findById($id)->firstOrFail();

        $this->Exams->patchEntity($exam, ['deleted' => 1]);

        if ($this->Exams->save($exam)) {
            $this->Flash->success(__('Test has been deleted'));
        }

        $examCacheKey = $this->getExamCacheKey($exam->id);
        Cache::delete($examCacheKey);

        return $this->redirect(['controller' => 'exams', 'action' => 'index']);
    }

    public function bustCache($type = null, $typeId = null)
    {
        $this->allowAdmin();

        switch ($type) {
            case 'list':
                $examsCacheKey = $this->getExamsCacheKey($typeId);
                $allCategoriesCacheKey = $this->getAllCategoriesCacheKey();

                Cache::deleteMany([
                    $examsCacheKey,
                    $allCategoriesCacheKey
                ], 'vshort');
                break;
            case 'exam':
                $examCacheKey = $this->getExamCacheKey($typeId);
                Cache::delete($examCacheKey, 'vshort');
                break;
            case 'userExam':
                $userExamCacheKey = $this->getUserExamCacheKey($typeId);
                Cache::delete($userExamCacheKey);
                break;

            case 'userExamSelectedQA':
                $userExamSelectedQACacheKey = $this->getUserExamSelectedQACacheKey($typeId);
                Cache::delete($userExamSelectedQACacheKey);
                break;
            default:
                $this->Flash->set('List of commands: <br>/list/categoryId <br>/exam/examId <br>/userExam/userExamId <br>/userExamSelectedQA/userExamId', ['escape' => false]);
                break;
        }

        $this->redirect('/');
    }

    public function moveQuestion($questionId, $oldExamId, $newExamId)
    {
        $this->allowAdmin();
        $this->setLayout('ajax');
        $error = null;
        $success = null;

        $this->loadModel(ExamQuestionsTable::class);
        $examQuestionInfo = $this->ExamQuestions->find('all')
            ->where(['ExamQuestions.question_id' => $questionId, 'ExamQuestions.exam_id' => $newExamId])
            ->first();

        if ($examQuestionInfo) {
            $error = 'This question already exists in the selected Exam.';
        }

        if (!$error) {
            $data = [
                'question_id' => $questionId,
                'exam_id' => $newExamId,
                'sort' => time()
            ];
            $examQuestion = $this->ExamQuestions->newEmptyEntity();
            $examQuestion = $this->ExamQuestions->patchEntity($examQuestion, $data);

            if ($this->ExamQuestions->save($examQuestion)) {
                $this->ExamQuestions->deleteAll(['ExamQuestions.question_id' => $questionId, 'ExamQuestions.exam_id' => $oldExamId]);
                $success = 'Question has been moved successfully to the selected Test.';
            } else {
                $error = 'Question could not be moved to the selected Exam';
            }
        }

        $this->set('error', $error);
        $this->set('success', $success);

    }
}
