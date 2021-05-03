<?php

namespace App\Controller;

use Cake\Event\EventInterface;

class TagsController extends AppController
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
        $tag = $this->Tags->newEmptyEntity();
        $data = $this->request->getData();
        $data['name'] = trim($data['name']);
        $error = '';
        if ($this->request->is('post')) {
            $error = $this->validateTag($this->request->getData());

            if (!$error) {
                $tag = $this->Tags->patchEntity($tag, $data);
                $this->Tags->save($tag);
            }
        }
        $tags = $this->Tags->find('all')->select(['Tags.name'])->order('name asc')->all();

        $tagsList = null;
        foreach($tags as $tag) {
            $tagsList[] = $tag->name;
        }

        $selectedTags = isset($data['selectedTags']) ? $data['selectedTags'] : [];
        $selectedTags[] = $data['name'];

        $this->set('error', $error);
        $this->set('tagsList', $tagsList);
        $this->set('tags', $tags);
        $this->set('selectedTags', $selectedTags);
    }

    private function validateTag($data)
    {
        if (empty(trim($data['name']))) {
            return 'Tag field cannot be empty.';
        }

        $tag = $this->Tags->findByName(trim($data['name']))->select(['Tags.name'])->first();

        if ($tag) {
            return 'Tag name "'.$data['name'].'" already exists.';
        }

        return null;
    }

    public function delete($name)
    {
        $tag = $this->Tags->findByName($name)->firstOrFail();
        $this->Tags->delete($tag);
        $this->Flash->success(__('Tag ' . $tag->name . ' has been deleted'));

        return $this->redirect(['controller' => 'Questions', 'action' => 'add']);
    }

}
