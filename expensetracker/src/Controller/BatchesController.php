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

        if ($this->request->getSession()->check('User.id') === false) {
            if (! $this->request->is('ajax')) {
                return $this->redirect('/Users/login');
            }
        }
    }

    public function index()
    {
        $this->loadComponent('Paginator');
        $batchId = $this->getSelectedBatchId();

        $conditions = ['Batches.deleted' => 0];
        $conditions['Batches.user_id'] = $this->request->getSession()->read('User.id');


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

                $this->Flash->success(__('Entity has been saved.'));

                return $this->redirect('/Transactions/add/'.$batchInfo->id);
            }

            $this->Flash->error(__('Unable to create new entity.'));
        }

        $this->set('batch', $batch);
    }

    private function validateBatch($data)
    {
        if (empty(trim($data['name']))) {
            return 'Please enter the entity name.';
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
                $this->Flash->success(__('Entity details have been updated successfully.'));

                return $this->redirect(['controller' => 'Batches', 'action' => 'index']);
            }

            $this->Flash->error(__('Unable to update entity details.'));
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
            ->contain(['Transactions'])
            ->first();

        $this->set('batch', $batch);
    }

    protected function checkIfBatchSelected()
    {
        $controller = $this->request->getParam('controller');
        $action = $this->request->getParam('action');

        if (($controller != 'Batches' || $action == 'dashboard') && !$this->isBatchSelected()) {
            $this->Flash->set(__('Please select an Entity'));

            return $this->redirect('/Batches/selectBatch');
        }
    }

    public function dashboard()
    {
        if (!$this->isBatchSelected()) {
            $this->Flash->set(__('Please select an Entity'));

            return $this->redirect('/Batches/selectBatch');
        }

        $batchId = $this->getSelectedBatchId();

        $fromDate = date('Y-m-', strtotime('-11 month')) . '01';
        $toDate = date('Y-m-d');
        $conditions = [
            'Transactions.transaction_date >= ' => $fromDate,
            'Transactions.transaction_date <= ' => $toDate,
            'Transactions.user_id' => $this->request->getSession()->read('User.id'),
            'Transactions.batch_id' => $batchId
        ];

        $this->loadModel('Transactions');
        $transactions = $this->Transactions->find('all')
            ->select(['Transactions.id', 'Transactions.transaction_type', 'Transactions.transaction_date', 'Transactions.name', 'Transactions.transaction_amount'])
            ->where($conditions)
            ->order('Transactions.transaction_date asc')
            ->all();

        $transactionsDailyInfo = [];
        $transactionsMonthlyInfo = [];

        foreach($transactions as $row) {
            $date = $row->transaction_date->format('M Y');
            $day = $row->transaction_date->format('d');

            if ($row->transaction_type == 'income') {
                // capture monthly income
                if (isset($transactionsMonthlyInfo[$date]['income'])) {
                    $transactionsMonthlyInfo[$date]['income'] += (float)$row->transaction_amount;
                } else {
                    $transactionsMonthlyInfo[$date]['income'] = (float)$row->transaction_amount;
                }

                // capture daily income
                if (isset($transactionsDailyInfo[$date][$day]['income'])) {
                    $transactionsDailyInfo[$date][$day]['income'] += (float)$row->transaction_amount;
                } else {
                    $transactionsDailyInfo[$date][$day]['income'] = (float)$row->transaction_amount;
                }

            } else {
                // capture monthly expenses
                if (isset($transactionsMonthlyInfo[$date]['expense'])) {
                    $transactionsMonthlyInfo[$date]['expense'] += (float)$row->transaction_amount;
                } else {
                    $transactionsMonthlyInfo[$date]['expense'] = (float)$row->transaction_amount;
                }

                // capture daily expenses
                if (isset($transactionsDailyInfo[$date][$day]['expense'])) {
                    $transactionsDailyInfo[$date][$day]['expense'] += (float)$row->transaction_amount;
                } else {
                    $transactionsDailyInfo[$date][$day]['expense'] = (float)$row->transaction_amount;
                }
            }
        }

        $this->set('transactionsMonthlyInfo', $transactionsMonthlyInfo);
        $this->set('transactionsDailyInfo', $transactionsDailyInfo);
    }

    public function changeStatus($batchId, $status)
    {
        $batch = $this->Batches->findById($batchId)->firstOrFail();

        if ($status === 'active') {
            $this->Batches->patchEntity($batch, ['active' => 1]);

            if ($this->Batches->save($batch)) {
                $this->Flash->success(__($batch->name . ' has been activated'));
            }
        } else if ($status === 'inactive') {
            $this->Batches->patchEntity($batch, ['active' => 0]);

            if ($this->Batches->save($batch)) {
                $this->Flash->success(__($batch->name . ' has been closed'));
            }
        }

        return $this->redirect(['controller' => 'Batches', 'action' => 'index']);
    }

    public function selectBatch()
    {
        $this->request->getSession()->delete('Batch');

        $userId = $this->request->getSession()->read('User.id');

        $batchInfo = $this->Batches
            ->find('all')
            ->where(['Batches.user_id' => $userId, 'Batches.deleted' => 0])
            ->order(['Batches.active desc', 'Batches.created desc'])
            ->all();
        $this->set('batchInfo', $batchInfo);
    }

    public function changeEntity($batchId)
    {
        $this->request->getSession()->delete('Batch');
        $userId = $this->request->getSession()->read('User.id');
        $batch = $this->Batches->findById($batchId)->firstOrFail();

        if ($batch->user_id == $userId) {
            $batchInfo['id'] = $batch->id;
            $batchInfo['name'] = $batch->name;
            $batchInfo['active'] = $batch->active;
            $batchInfo['created'] = $batch->created;

            $this->request->getSession()->write('Batch', $batchInfo);
            return $this->redirect('/Batches/dashboard');
        }

        $this->Flash->error(__('You are not authorized to access this Entity - '.$batch->name));

        return $this->redirect('/Batches/selectBatch');
    }
}
