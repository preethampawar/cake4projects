<?php

namespace App\Controller;

use App\Model\Table\QuestionOptionsTable;
use App\Model\Table\SubjectsTable;
use App\Model\Table\EducationLevelsTable;
use App\Model\Table\TagsTable;
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
        $params = $this->request->getQueryParams();
        $selectedSubject = null;
        $selectedEducationLevel = null;
        $selectedDifficultyLevel = null;

        if (isset($params['subject']) and !empty($params['subject'])) {
            $selectedSubject = $params['subject'];
        }
        if (isset($params['level']) and !empty($params['level'])) {
            $selectedEducationLevel = $params['level'];
        }
        if (isset($params['difficulty_level']) and !empty($params['difficulty_level'])) {
            $selectedDifficultyLevel = $params['difficulty_level'];
        }

        $this->loadComponent('Paginator');

        $query = $this->Questions->find('all')
            ->where(['Questions.deleted' => 0])
            ->contain(['QuestionOptions'])
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

        $questions = $this->Paginator->paginate(
            $query,
            [
                'limit' => '100',
                'order' => [
                    'Questions.id' => 'desc'
                ]
            ]
        );

        $this->loadModel(SubjectsTable::class);
        $this->loadModel(EducationLevelsTable::class);

        $subjects = $this->Subjects->find('all')->select(['Subjects.name'])->order('name asc')->all();
        $educationLevels = $this->EducationLevels->find('all')->select(['EducationLevels.name'])->order('name asc')->all();

        $this->set('subjects', $subjects);
        $this->set('selectedSubject', $selectedSubject);
        $this->set('educationLevels', $educationLevels);
        $this->set('selectedEducationLevel', $selectedEducationLevel);
        $this->set('selectedDifficultyLevel', $selectedDifficultyLevel);

        $this->set(compact('questions'));
    }

    public function view($id)
    {
        $question = $this->Questions->findById($id)->firstOrFail();
        $this->set(compact('question'));
    }

    public function add($editorEnabled = 0)
    {
        $this->set('editorEnabled', $editorEnabled);
        $question = $this->Questions->newEmptyEntity();

        $selectedSubject = $this->request->getSession()->check('AddQuestions.selectedSubject')
                                ? $this->request->getSession()->read('AddQuestions.selectedSubject') : null;
        $selectedEducationLevel = $this->request->getSession()->check('AddQuestions.selectedEducationLevel')
                                ? $this->request->getSession()->read('AddQuestions.selectedEducationLevel') : null;
        $selectedDifficultyLevel = $this->request->getSession()->check('AddQuestions.selectedDifficultyLevel')
                                ? $this->request->getSession()->read('AddQuestions.selectedDifficultyLevel') : null;

        if ($this->request->is('post')) {
            $qData = $this->request->getData();
            $error = $this->validateQuestion($qData);

            $this->request->getSession()->write('AddQuestions.selectedSubject', $qData['subject']);
            $this->request->getSession()->write('AddQuestions.selectedEducationLevel', $qData['level']);
            $this->request->getSession()->write('AddQuestions.selectedDifficultyLevel', $qData['difficulty_level']);

            if ($error) {
                $this->Flash->error(__($error));

                return;
            }

            if (!empty($qData['tags'])) {
                $qData['tags'] = implode(',',$qData['tags']);
            }

            $question = $this->Questions->patchEntity($question, $qData);

            if ($questionInfo = $this->Questions->save($question)) {
                $this->loadModel(QuestionOptionsTable::class);
                $options = $question['options'];

                foreach ($options as $row) {
                    if (empty(trim($row['name']))) {
                        continue;
                    }

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

        $this->loadModel(SubjectsTable::class);
        $this->loadModel(EducationLevelsTable::class);
        $this->loadModel(TagsTable::class);

        $subjects = $this->Subjects->find('all')->select(['Subjects.name'])->order('name asc')->all();
        $educationLevels = $this->EducationLevels->find('all')->select(['EducationLevels.name'])->order('name asc')->all();
        $tags = $this->Tags->find('all')->select(['Tags.name'])->order('name asc')->all();

        $this->set('question', $question);
        $this->set('subjects', $subjects);
        $this->set('educationLevels', $educationLevels);
        $this->set('tags', $tags);
        $this->set('selectedSubject', $selectedSubject);
        $this->set('selectedEducationLevel', $selectedEducationLevel);
        $this->set('selectedDifficultyLevel', $selectedDifficultyLevel);
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
                    if ($index < 3 && empty(trim($row['name'])) || empty(trim($row['order']))) {
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

    public function edit($id, $editorEnabled = 0)
    {
        $this->set('editorEnabled', $editorEnabled);

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

        if ($this->request->is(['post', 'put'])) {
            $qData = $this->request->getData();

            if (!empty($qData['tags'])) {
                $qData['tags'] = implode(',',$qData['tags']);
            }

            $this->Questions->patchEntity($question, $qData);

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

        $this->loadModel(SubjectsTable::class);
        $this->loadModel(EducationLevelsTable::class);
        $this->loadModel(TagsTable::class);

        $subjects = $this->Subjects->find('all')->select(['Subjects.name'])->order('name asc')->all();
        $educationLevels = $this->EducationLevels->find('all')->select(['EducationLevels.name'])->order('name asc')->all();
        $tags = $this->Tags->find('all')->select(['Tags.name'])->order('name asc')->all();

        $this->set('id', $id);
        $this->set('question', $question);
        $this->set('options', $options);
        $this->set('subjects', $subjects);
        $this->set('educationLevels', $educationLevels);
        $this->set('tags', $tags);
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

    public function login()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $credentials = [
                'user' => 'admin',
                'password' => 'preetham2020'
            ];

            if (trim($data['user']) === $credentials['user'] &&
                trim($data['kunji']) === $credentials['password']
            ) {
                $this->request->getSession()->write('loggedIn', true);
                $this->redirect('/');
            } else {
                $this->Flash->error(__('Error! Invalid User or Password.'));
            }
        }
    }

    public function logout()
    {
        $this->request->getSession()->write('loggedIn', false);
        $this->request->getSession()->destroy();

        $this->redirect('/');
    }
}
