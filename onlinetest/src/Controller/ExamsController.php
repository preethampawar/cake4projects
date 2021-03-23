<?php

namespace App\Controller;

use App\Model\Table\QuestionsTable;

class ExamsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    public function index()
    {
        $this->loadComponent('Paginator');
        $exams = $this->Paginator->paginate(
            $this->Exams->find('all')
                ->where(['Exams.deleted' => 0]),
            [
                'limit' => 50,
                'order' => [
                    'Exams.id' => 'desc'
                ]
            ]
        );
        $this->set(compact('exams'));
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
            $error = $this->validateExam($this->request->getData());

            if ($error) {
                $this->Flash->error(__($error));

                return;
            }

            $exam = $this->Exams->patchEntity($exam, $this->request->getData());

            if ($examInfo = $this->Exams->save($exam)) {

                $this->Flash->success(__('Your exam has been saved.'));

                return $this->redirect(['controller' => 'exams', 'action' => 'addQuestions', $examInfo->id]);
            }

            $this->Flash->error(__('Unable to create new exam.'));
        }

        $this->set('exam', $exam);
    }

    public function addQuestions($examId)
    {
        $this->loadModel(QuestionsTable::class);
        $this->loadComponent('Paginator');

        $questions = $this->Paginator->paginate(
            $this->Questions->find('all')
                ->where(['Questions.deleted' => 0])
                ->order('Questions.id desc')
            ,
            [
                'limit' => 50,
                'order' => [
                    'Questions.id' => 'desc'
                ]
            ]
        );

        $exam = $this->Exams->findById($examId)->firstOrFail();

        $this->set(compact('questions'));
        $this->set(compact('exam'));
    }

    public function loadSelectedExamQuestions($examId) {
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
            ->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $this->Exams->patchEntity($exam, $this->request->getData());

            if ($this->Exams->save($exam)) {
                $this->Flash->success(__('Exam details have been updated successfully.'));

                return $this->redirect(['controller' => 'exams', 'action' => 'index']);
            }

            $this->Flash->error(__('Unable to update your exam.'));
        }

        $this->set('exam', $exam);
    }

    public function delete($id)
    {
        $exam = $this->Exams->findById($id)->firstOrFail();

        $this->Exams->patchEntity($exam, ['deleted' => 1]);

        if ($this->Exams->save($exam)) {
            $this->Flash->success(__('Exam E.ID = ' . $exam->id . ' has been deleted'));
        }

        return $this->redirect(['controller' => 'exams', 'action' => 'index']);
    }
}
