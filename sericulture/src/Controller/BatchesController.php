<?php

namespace App\Controller;

use Cake\Event\EventInterface;

class BatchesController extends AppController
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

        if (!$this->isLoggedIn()) {
            return $this->redirect('/Users/login');
        }
    }

    public function index()
    {
        $this->loadComponent('Paginator');

        $conditions = ['Batches.deleted' => 0];
        if ($this->request->getSession()->read('User.isAdmin') === false) {
            $conditions['Batches.user_id'] = $this->request->getSession()->read('User.id');
        }

        $batches = $this->Paginator->paginate(
            $this->Batches->find('all')
                ->where($conditions),
            [
                'limit' => 50,
                'order' => [
                    'Batches.id' => 'desc'
                ]
            ]
        );
        $this->set(compact('batches'));
    }

    public function add()
    {
        $batch = $this->Batches->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['user_id'] = $this->request->getSession()->read('User.id');
            $error = $this->validateBatch($data);

            if ($error) {
                $this->Flash->error(__($error));

                return;
            }

            $batch = $this->Batches->patchEntity($batch, $data);

            if ($batchInfo = $this->Batches->save($batch)) {

                $this->Flash->success(__('Batch has been saved.'));

                return $this->redirect('/Activities/add/'.$batchInfo->id);
            }

            $this->Flash->error(__('Unable to create new batch.'));
        }

        $this->set('batch', $batch);
    }

    private function validateBatch($data)
    {
        if (empty(trim($data['name']))) {
            return 'Please enter the batch name.';
        }

        return null;
    }

    public function edit($id)
    {
        $batch = $this->Batches
            ->findById($id)
            ->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $this->Batches->patchEntity($batch, $this->request->getData());

            if ($this->Batches->save($batch)) {
                $this->Flash->success(__('Batch details have been updated successfully.'));

                return $this->redirect(['controller' => 'Batches', 'action' => 'index']);
            }

            $this->Flash->error(__('Unable to update batch details.'));
        }

        $this->set('batch', $batch);
    }

    public function delete($id)
    {
        $batch = $this->Batches->findById($id)->firstOrFail();

        $this->Batches->patchEntity($batch, ['deleted' => 1]);

        if ($this->Batches->save($batch)) {
            $this->Flash->success(__($batch->name . ' has been deleted'));
        }

        return $this->redirect(['controller' => 'Batches', 'action' => 'index']);
    }

    public function details($batchId)
    {
        $batch = $this->Batches
            ->findById($batchId)
            ->contain(['ActivitiesAsc'])
            ->first();

        $this->set('batch', $batch);
    }

    public function dashboard()
    {
        $batches = $this->Batches
            ->find('all')
            ->contain(['Activities'])
            ->where(['Batches.status' => 1, 'Batches.user_id' => $this->request->getSession()->read('User.id')])
            ->all();

        $this->set('batches', $batches);
        $this->set('batches', $batches);
    }

    public function changeStatus($batchId, $status)
    {
        $batch = $this->Batches->findById($batchId)->firstOrFail();

        if ($status === 'active') {
            $this->Batches->patchEntity($batch, ['status' => 1]);

            if ($this->Batches->save($batch)) {
                $this->Flash->success(__($batch->name . ' has been activated'));
            }
        } else if ($status === 'inactive') {
            $this->Batches->patchEntity($batch, ['status' => 0]);

            if ($this->Batches->save($batch)) {
                $this->Flash->success(__($batch->name . ' has been closed'));
            }
        }

        return $this->redirect(['controller' => 'Batches', 'action' => 'index']);
    }
}
