<?php

namespace App\Controller;

use App\Model\Table\QuestionOptionsTable;
use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query;

class QuestionsController extends AppController
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
        $questions = $this->Paginator->paginate(
            $this->Questions->find('all')
                ->where(['Questions.deleted' => 0])
                ->contain(['QuestionOptions'])
                ->order('Questions.id desc')
                ->limit(100));
        $this->set(compact('questions'));
    }

    public function view($id)
    {
        $question = $this->Questions->findById($id)->firstOrFail();
        $this->set(compact('question'));
    }

    public function add()
    {
        $question = $this->Questions->newEmptyEntity();

        if ($this->request->is('post')) {
            $error = $this->validateQuestion($this->request->getData());

            if ($error) {
                $this->Flash->error(__($error));

                return;
            }

            $question = $this->Questions->patchEntity($question, $this->request->getData());

            if ($questionInfo = $this->Questions->save($question)) {
                $this->loadModel(QuestionOptionsTable::class);
                $options = $question['options'];

                foreach ($options as $row) {
                    $questionOption = $this->QuestionOptions->newEmptyEntity();
                    $data = [];
                    $data['question_id'] = $questionInfo->id;
                    $data['name'] = $row['name'];
                    $data['sort'] = (int) $row['order'];

                    $questionOption = $this->QuestionOptions->patchEntity($questionOption, $data);

                    $this->QuestionOptions->save($questionOption);
                }

                $this->Flash->success(__('Your question has been saved.'));
                return $this->redirect(['controller' => 'questions', 'action' => 'index']);
            }

            $this->Flash->error(__('Unable to add new question.'));
        }

        $this->set('question', $question);
    }

    private function validateQuestion($data)
    {
        if (empty(trim($data['type']))) {
            return 'Please select the question type.';
        }

        if (empty(trim($data['name']))) {
            return 'Question field cannot be empty.';
        }

        if (empty($data['options'])) {
            return 'No options selected.';
        }

        $error = null;

        switch ($data['type']) {
            case 'MultipleChoice-SingleAnswer':
                foreach ($data['options'] as $index => $row) {
                    if (empty(trim($row['name'])) || empty(trim($row['order']))) {
                        $error = '"Option ' . $index . '" cannot be empty.';
                        break;
                    }
                }
                break;

            default:
                $error = 'Invalid question type.';
                break;
        }

        if ($error) {
            return $error;
        }

        if (empty($data['answer'])) {
            return 'Please select the answer.';
        }

        return null;
    }

    public function edit($id)
    {
        $question = $this->Questions
            ->findById($id)
            ->contain(['QuestionOptions'])
            ->firstOrFail();

        $options = [];
        if ($question) {
            $i = 1;
            foreach($question['question_options'] as $row) {
                $options[$i] = $row->toArray();
                $i++;
            }
        }

        //debug($options);

        if ($this->request->is(['post', 'put'])) {
            $this->Questions->patchEntity($question, $this->request->getData());

            if ($this->Questions->save($question)) {
                // $this->loadModel(QuestionOptionsTable::class);
                $options = $question['options'];

                $this->Questions->QuestionOptions->deleteAll(['question_id' =>$id]);

                foreach ($options as $row) {
                    $questionOption = $this->Questions->QuestionOptions->newEmptyEntity();
                    $data = [];
                    $data['question_id'] = $id;
                    $data['name'] = $row['name'];
                    $data['sort'] = (int) $row['order'];

                    $questionOption = $this->Questions->QuestionOptions->patchEntity($questionOption, $data);

                    $this->Questions->QuestionOptions->save($questionOption);
                }

                $this->Flash->success(__('Your question has been saved.'));

                return $this->redirect(['controller' => 'questions', 'action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your question.'));
        }

        $this->set('question', $question);
        $this->set('options', $options);
    }

    public function delete($id)
    {
        $question = $this->Questions->findById($id)->firstOrFail();

        $this->Questions->patchEntity($question, ['deleted' => 1]);

        if ($this->Questions->save($question)) {
            $this->Flash->success(__('Question ' . $question->id . ' has been deleted'));
        }

        return $this->redirect(['controller' => 'questions', 'action' => 'index']);
    }
}
