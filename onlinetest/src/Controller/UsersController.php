<?php

namespace App\Controller;

use App\Model\Table\ExamsTable;
use Cake\Mailer\Mailer;
use mysql_xdevapi\Exception;

class UsersController extends AppController
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
                ->order('Questions.id desc'),
            [
                'limit' => '50',
                'order' => [
                    'Questions.id' => 'desc'
                ]
            ]
        );

        $this->set(compact('questions'));
    }

    public function view($id)
    {
        $question = $this->Questions->findById($id)->firstOrFail();
        $this->set(compact('question'));
    }

    public function add()
    {
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $error = $this->validateUser($this->request->getData());

            if ($error) {
                $this->Flash->error(__($error));

                return;
            }

            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($userInfo = $this->Users->save($user)) {
                $this->Flash->success(__('Registration completed.'));

                return $this->redirect(['controller' => 'users', 'action' => 'login']);
            }

            $this->Flash->error(__('Unable to add new user.'));
        }

        $this->set('user', $user);
    }

    public function register()
    {
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $error = $this->validateUser($this->request->getData());

            if ($error) {
                $this->Flash->error(__($error));

                return;
            }

            $data = $this->request->getData();
            $originalPassword = $data['password'];
            $data['password'] = sha1($data['password']);

            $user = $this->Users->patchEntity($user, $data);

            if ($userInfo = $this->Users->save($user)) {
                $this->sendRegisterEmail($userInfo, $originalPassword);
                $this->saveUserToSession($userInfo);

                $this->Flash->success(__('Registration successful.'));
                return $this->redirect(['controller' => 'users', 'action' => 'login']);
            }

            $this->Flash->error(__('Unable to add new user.'));
        }

        $this->set('user', $user);
    }

    private function validateUser($data)
    {
        //debug($data);

        if (empty(trim($data['name']))) {
            return 'Full Name field cannot be empty.';
        }

        if (empty(trim($data['username']))) {
            return 'Username field cannot be empty.';
        }

        if (empty(trim($data['password']))) {
            return 'Password field cannot be empty.';
        }

//        if (empty(trim($data['confirm']))) {
//            return 'Confirm Password field cannot be empty.';
//        }

        if (empty(trim($data['phone']))) {
            return 'Phone Number field cannot be empty.';
        }

//        if (trim($data['password']) != trim($data['confirm'])) {
//            return 'Password and Confirm Password fields do not match.';
//        }

        $userInfo = $this->Users->findByUsername($data['username'])->first();

        if (!empty($userInfo)) {
            return 'Username already exits.';
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

    public function login()
    {
        if ($this->isLoggedIn()) {
            return $this->redirect('/');
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $userInfo = $this->Users->findByUsername($data['username'])->where(['Users.deleted' => 0])->first();

            if ($userInfo && $userInfo->password === sha1($data['kunji'])) {
                $user = $this->saveUserToSession($userInfo);

                if ($user['isAdmin'] == false) {
                    if ($this->request->getSession()->check('selectedExamId')) {
                        return $this->redirect('/UserExams/view/' . $this->request->getSession()->read('selectedExamId'));
                    }

                    return $this->redirect('/UserExams/list');
                }

                return $this->redirect('/Questions/');
            }

            $this->Flash->error(__('User not found.'));

        }

        $examDetails = null;
        if($this->request->getSession()->check('selectedExamId')) {
            $examId = base64_decode($this->request->getSession()->read('selectedExamId'));
            $this->loadModel(ExamsTable::class);
            $examDetails = $this->Exams->findById($examId)->first();
        }

        $this->set('examDetails', $examDetails);
    }

    private function saveUserToSession($userInfo)
    {
        $user['id'] = $userInfo->id;
        $user['username'] = $userInfo->username;
        $user['name'] = $userInfo->name;
        $user['email'] = $userInfo->email;
        $user['phone'] = $userInfo->phone;
        $user['address'] = $userInfo->address;
        $user['isAdmin'] = $userInfo->is_admin ?? false;

        $this->request->getSession()->write('User', $user);

        return $user;
    }

    public function logout()
    {
        $this->request->getSession()->delete('userInfo');
        $this->request->getSession()->destroy();

        return $this->redirect('/');
    }

    public function sendRegisterEmail($userInfo, $originalPassword)
    {
        $body = sprintf("
<p>Dear %s,</p>

<p>You are successfully enrolled on our platform. Find the below details which you have provided at the time of registration.</p>

<p>
<b>Login details:</b> <br>
Username: %s <br>
Password: %s <br>
</p>

<p>
<b>Profile Information:</b> <br>
Full Name: %s <br>
Email: %s <br>
Phone: %s <br>
</p>

<p>Note: This is an auto generated email. Please do not reply.</p>

        ", $userInfo->name, $userInfo->username, $originalPassword, $userInfo->name, $userInfo->email, $userInfo->phone);

        if(empty($userInfo->email)) {
            $userInfo->email = 'preetham.pawar@gmail.com';
        }

        try {
            $mailer = new Mailer('mailgun');
            $mailer->setFrom(['noreply@simpleaccounting.in' => 'OnlineTest'])
                ->setTo($userInfo->email)
                ->setBcc('preetham.pawar@gmail.com')
                ->setSubject('Congratulations! You are now registered with us.')
                ->setEmailFormat('html')
                ->deliver($body);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
