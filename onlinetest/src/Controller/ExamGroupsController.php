<?php

namespace App\Controller;

use Cake\Event\EventInterface;

class ExamGroupsController extends AppController
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

    public function index()
    {
        $this->loadComponent('Paginator');
        $examGroups = $this->Paginator->paginate(
            $this->ExamGroups->find('all')
                ->where(['ExamGroups.deleted' => 0]),
            [
                'limit' => 50,
                'order' => [
                    'ExamGroups.id' => 'desc'
                ]
            ]
        );
        $this->set(compact('examGroups'));
    }

    public function add()
    {
        $examGroup = $this->ExamGroups->newEmptyEntity();

        if ($this->request->is('post')) {
            $error = $this->validateExamGroup($this->request->getData());

            if ($error) {
                $this->Flash->error(__($error));

                return;
            }

            $examGroup = $this->ExamGroups->patchEntity($examGroup, $this->request->getData());

            if ($examGroupInfo = $this->ExamGroups->save($examGroup)) {

                $this->Flash->success(__('Topic has been saved.'));

                return $this->redirect(['controller' => 'examGroups', 'action' => 'index']);
            }

            $this->Flash->error(__('Unable to create new Topic.'));
        }

        $this->set('examGroup', $examGroup);
    }

    private function validateExamGroup($data)
    {
        if (empty(trim($data['name']))) {
            return 'Please enter the Topic name.';
        }

        return null;
    }

    public function edit($id)
    {
        $examGroup = $this->ExamGroups
            ->findById($id)
            ->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $this->ExamGroups->patchEntity($examGroup, $this->request->getData());

            if ($this->ExamGroups->save($examGroup)) {
                $this->Flash->success(__('Topic details have been updated successfully.'));

                return $this->redirect(['controller' => 'examGroups', 'action' => 'index']);
            }

            $this->Flash->error(__('Unable to update Topic details.'));
        }

        $this->set('examGroup', $examGroup);
    }

    public function delete($id)
    {
        $examGroup = $this->ExamGroups->findById($id)->firstOrFail();

        $this->ExamGroups->patchEntity($examGroup, ['deleted' => 1]);

        if ($this->ExamGroups->save($examGroup)) {
            $this->Flash->success(__($examGroup->name . ' has been deleted'));
        }

        return $this->redirect(['controller' => 'examGroups', 'action' => 'index']);
    }
}
