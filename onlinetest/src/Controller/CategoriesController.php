<?php

namespace App\Controller;

class CategoriesController extends AppController
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
        $categories = $this->Paginator->paginate(
            $this->Categories->find('all')
                ->where(['Categories.deleted' => 0]),
            [
                'limit' => 50,
                'order' => [
                    'Categories.id' => 'desc'
                ]
            ]
        );
        $this->set(compact('categories'));
    }

    public function add()
    {
        $category = $this->Categories->newEmptyEntity();

        if ($this->request->is('post')) {
            $error = $this->validateCategory($this->request->getData());

            if ($error) {
                $this->Flash->error(__($error));

                return;
            }

            $category = $this->Categories->patchEntity($category, $this->request->getData());

            if ($categoryInfo = $this->Categories->save($category)) {

                $this->Flash->success(__('Category has been saved.'));

                return $this->redirect(['controller' => 'categories', 'action' => 'index']);
            }

            $this->Flash->error(__('Unable to create new exam.'));
        }

        $this->set('category', $category);
    }

    private function validateCategory($data)
    {
        if (empty(trim($data['name']))) {
            return 'Please enter the category name.';
        }

        return null;
    }

    public function edit($id)
    {
        $category = $this->Categories
            ->findById($id)
            ->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $this->Categories->patchEntity($category, $this->request->getData());

            if ($this->Categories->save($category)) {
                $this->Flash->success(__('Category details have been updated successfully.'));

                return $this->redirect(['controller' => 'categories', 'action' => 'index']);
            }

            $this->Flash->error(__('Unable to update category details.'));
        }

        $this->set('category', $category);
    }

    public function delete($id)
    {
        $category = $this->Categories->findById($id)->firstOrFail();

        $this->Categories->patchEntity($category, ['deleted' => 1]);

        if ($this->Categories->save($category)) {
            $this->Flash->success(__($category->name . ' has been deleted'));
        }

        return $this->redirect(['controller' => 'categories', 'action' => 'index']);
    }
}
