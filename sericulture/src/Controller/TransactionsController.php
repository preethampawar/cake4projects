<?php

namespace App\Controller;

use Cake\Event\EventInterface;

class TransactionsController extends AppController
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
    }

    public function index()
    {
        $this->loadComponent('Paginator');
        $batches = $this->Paginator->paginate(
            $this->Transactions->find('all'),
            [
                'limit' => 50,
                'order' => [
                    'Transactions.id' => 'desc'
                ]
            ]
        );
        $this->set(compact('batches'));
    }

    public function add()
    {
        $transaction = $this->Transactions->newEmptyEntity();

        if ($this->request->is('post')) {
            $error = $this->validateTransaction($this->request->getData());

            if ($error) {
                $this->Flash->error(__($error));

                return;
            }

            $transaction = $this->Transactions->patchEntity($transaction, $this->request->getData());

            if ($batchInfo = $this->Transactions->save($transaction)) {

                $this->Flash->success(__('Transaction has been saved.'));

                return $this->redirect(['controller' => 'Transactions', 'action' => 'index']);
            }

            $this->Flash->error(__('Unable to create new transaction.'));
        }

        $this->set('transaction', $transaction);
    }

    private function validateTransaction($data)
    {
        if (empty(trim($data['name']))) {
            return 'Please enter the transaction name.';
        }

        return null;
    }

    public function edit($id)
    {
        $transaction = $this->Transactions
            ->findById($id)
            ->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $this->Transactions->patchEntity($transaction, $this->request->getData());

            if ($this->Transactions->save($transaction)) {
                $this->Flash->success(__('Transaction details have been updated successfully.'));

                return $this->redirect(['controller' => 'Transactions', 'action' => 'index']);
            }

            $this->Flash->error(__('Unable to update transaction details.'));
        }

        $this->set('transaction', $transaction);
    }

    public function delete($id)
    {
        $transaction = $this->Transactions->findById($id)->firstOrFail();

        if ($this->Transactions->delete()) {
            $this->Flash->success(__($transaction->name . ' has been deleted'));
        }

        return $this->redirect(['controller' => 'Transactions', 'action' => 'index']);
    }
}
