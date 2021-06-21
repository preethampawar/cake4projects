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
        $transactions = $this->Paginator->paginate(
            $this->Transactions->find('all')->where(['Transactions.user_id' => $this->request->getSession()->read('User.id')]),
            [
                'limit' => 100,
                'order' => [
                    'Transactions.transaction_date' => 'desc',
                    'Transactions.created' => 'desc',
                ]
            ]
        );
        $this->set(compact('transactions'));
    }

    public function select()
    {

    }

    public function add($type)
    {
        $isExpense = $type != 'income';

        $transaction = $this->Transactions->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $error = $this->validateTransaction($data);

            if ($error) {
                $this->Flash->error(__($error));

                return;
            }

            $data['user_id'] = $this->request->getSession()->read('User.id');

            $transaction = $this->Transactions->patchEntity($transaction, $data);

            if ($transactionInfo = $this->Transactions->save($transaction)) {

                $this->Flash->success(__('Transaction has been saved.'));

                return $this->redirect(['controller' => 'Transactions', 'action' => 'index']);
            }

            $this->Flash->error(__('Unable to create new transaction.'));
        }

        $this->set('transaction', $transaction);
        $this->set('isExpense', $isExpense);
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
                $this->Flash->success(__('Transaction has been updated.'));

                return $this->redirect('/Transactions/');
            }

            $this->Flash->error(__('Unable to update transaction details.'));
        }

        $this->set('transaction', $transaction);
    }

    public function delete($id)
    {
        $transaction = $this->Transactions->findById($id)->firstOrFail();

        if ($this->Transactions->delete($transaction)) {
            $this->Flash->success(__($transaction->name . ' has been deleted'));
        }

        return $this->redirect('/Transactions/');
    }
}
