<?php

namespace App\Controller;

class SubjectsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    public function add()
    {
        $subject = $this->Subjects->newEmptyEntity();
        $data = $this->request->getData();
        $data['name'] = trim($data['name']);
        $error = '';
        if ($this->request->is('post')) {
            $error = $this->validateSubject($this->request->getData());

            if (!$error) {
                $subject = $this->Subjects->patchEntity($subject, $data);
                $this->Subjects->save($subject);
            }
        }
        $subjects = $this->Subjects->find('all')->select(['Subjects.name'])->order('name asc')->all();

        $subjectsList = null;
        foreach($subjects as $subject) {
            $subjectsList[] = $subject->name;
        }

        $this->set('error', $error);
        $this->set('subjectsList', $subjectsList);
        $this->set('subjects', $subjects);
        $this->set('selectedSubject', $data['name']);
    }

    private function validateSubject($data)
    {
        if (empty(trim($data['name']))) {
            return 'Subject field cannot be empty.';
        }

        $subject = $this->Subjects->findByName(trim($data['name']))->select(['Subjects.name'])->first();

        if ($subject) {
            return 'Subject name "'.$data['name'].'" already exists.';
        }

        return null;
    }

    public function delete($name)
    {
        $subject = $this->Subjects->findByName($name)->firstOrFail();
        $this->Subjects->delete($subject);
        $this->Flash->success(__('Subject ' . $subject->name . ' has been deleted'));

        return $this->redirect(['controller' => 'Questions', 'action' => 'add']);
    }

}