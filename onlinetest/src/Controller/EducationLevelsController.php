<?php

namespace App\Controller;

use Cake\Event\EventInterface;

class EducationLevelsController extends AppController
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

    public function add()
    {
        $educationLevel = $this->EducationLevels->newEmptyEntity();
        $data = $this->request->getData();
        $data['name'] = trim($data['name']);
        $error = '';
        if ($this->request->is('post')) {
            $error = $this->validateEducationLevel($this->request->getData());

            if (!$error) {
                $educationLevel = $this->EducationLevels->patchEntity($educationLevel, $data);
                $this->EducationLevels->save($educationLevel);
            }
        }
        $educationLevels = $this->EducationLevels->find('all')->select(['EducationLevels.name'])->order('name asc')->all();

        $educationLevelsList = null;
        foreach($educationLevels as $educationLevel) {
            $educationLevelsList[] = $educationLevel->name;
        }

        $this->set('error', $error);
        $this->set('educationLevelsList', $educationLevelsList);
        $this->set('educationLevels', $educationLevels);
        $this->set('selected', $data['name']);
    }

    private function validateEducationLevel($data)
    {
        if (empty(trim($data['name']))) {
            return 'Education Level field cannot be empty.';
        }

        $educationLevel = $this->EducationLevels->findByName(trim($data['name']))->select(['EducationLevels.name'])->first();

        if ($educationLevel) {
            return 'Education Level "'.$data['name'].'" already exists.';
        }

        return null;
    }

    public function delete($name)
    {
        $educationLevel = $this->EducationLevels->findByName($name)->firstOrFail();
        $this->EducationLevels->delete($educationLevel);
        $this->Flash->success(__('Education Level ' . $educationLevel->name . ' has been deleted'));

        return $this->redirect(['controller' => 'Questions', 'action' => 'add']);
    }

}
