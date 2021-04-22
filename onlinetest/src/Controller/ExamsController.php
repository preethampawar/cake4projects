<?php

namespace App\Controller;

use App\Model\Table\CategoriesTable;
use App\Model\Table\EducationLevelsTable;
use App\Model\Table\ExamCategoriesTable;
use App\Model\Table\QuestionOptionsTable;
use App\Model\Table\QuestionsTable;
use App\Model\Table\SubjectsTable;
use App\Model\Table\TagsTable;
use Cake\Cache\Cache;

class ExamsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent

        if ($this->request->getSession()->check('User.isAdmin')
            && $this->request->getSession()->read('User.isAdmin') == false) {
            $this->Flash->error('You are not authorized to access this page');
            $this->redirect('/UserExams/list/');
            return;
        }
    }

    public function index()
    {
        $this->loadComponent('Paginator');
        $exams = $this->Paginator->paginate(
            $this->Exams->find('all')
                ->contain(['ExamCategories', 'ExamQuestions'])
                ->where(['Exams.deleted' => 0]),
            [
                'limit' => 50,
                'order' => [
                    'Exams.id' => 'desc'
                ]
            ]
        );

        $this->loadModel(CategoriesTable::class);
        $categories = $this->Categories->find('all')->select(['Categories.id', 'Categories.name'])->where(['Categories.deleted' => 0])->order('name asc')->all();

        $this->set(compact('exams'));
        $this->set('categories', $categories);
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

                $this->Flash->success(__('Your exam has been saved.'));

                return $this->redirect(['controller' => 'exams', 'action' => 'addQuestions', $examInfo->id]);
            }

            $this->Flash->error(__('Unable to create new exam.'));
        }

        $this->loadModel(CategoriesTable::class);
        $categories = $this->Categories->find('all')->select(['Categories.id', 'Categories.name'])->where(['Categories.deleted' => 0])->order('name asc')->all();

        $this->set('exam', $exam);
        $this->set('categories', $categories);
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

        $exam = $this->Exams->findById($examId)->firstOrFail();


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

    public function loadSelectedExamQuestions($examId) {
        $this->setLayout('ajax');

        $examQuestions = $this->getExamQuestions($examId);

        $this->set('examId', $examId);
        $this->set('examQuestions', $examQuestions);
    }

    public function addSelectedQuestion()
    {
        $this->layout = false;
        $data = $this->request->getData();
        $data['sort'] = time();

        $error = $this->checkDuplicateExamQuestion($data);

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
            return 'Please enter the exam name.';
        }

        if (empty(trim($data['time']))) {
            return 'Please enter the exam duration.';
        }

        if (empty($data['start_date'])) {
            return 'Please enter the start date.';
        }
        if (empty($data['end_date'])) {
            return 'Please enter the end date.';
        }

        return null;
    }

    private function checkDuplicateExamQuestion($data)
    {
        if (empty(trim($data['exam_id']))) {
            return 'Please select an exam.';
        }

        if (empty(trim($data['question_id']))) {
            return 'Please select a question.';
        }

        $examQuestionsQuery = $this->Exams->ExamQuestions->find('all')
            ->where(['ExamQuestions.exam_id' => $data['exam_id'], 'ExamQuestions.question_id' => $data['question_id']]);
        $examQuestions = $examQuestionsQuery->all()->toArray();

        if (!empty($examQuestions)) {
            return 'This question is already selected for the exam';
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

                $this->Flash->success(__('Exam details have been updated successfully.'));

                return $this->redirect(['controller' => 'Exams', 'action' => 'addQuestions', $exam->id]);
            }

            $this->Flash->error(__('Unable to update your exam.'));
        }

        $this->loadModel(CategoriesTable::class);
        $categories = $this->Categories->find('all')->select(['Categories.id', 'Categories.name'])->where(['Categories.deleted' => 0])->order('name asc')->all();

        $this->set('exam', $exam);
        $this->set('categories', $categories);
    }

    public function delete($id)
    {
        $exam = $this->Exams->findById($id)->firstOrFail();

        $this->Exams->patchEntity($exam, ['deleted' => 1]);

        if ($this->Exams->save($exam)) {
            $this->Flash->success(__('Exam E.ID = ' . $exam->id . ' has been deleted'));
        }

        $examCacheKey = $this->getExamCacheKey($exam->id);
        Cache::delete($examCacheKey);

        $this->redirect(['controller' => 'exams', 'action' => 'index']);
        return;
    }
}
