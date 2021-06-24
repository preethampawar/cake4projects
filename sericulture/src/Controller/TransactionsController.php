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
        $userId = $this->request->getSession()->read('User.id');

        if ($transaction->user_id != $userId) {
            $this->Flash->error(__('You are not authorized to delete this record.'));
        } elseif ($this->Transactions->delete($transaction)) {
            $this->Flash->success(__($transaction->name . ' has been deleted'));
        }

        return $this->redirect('/Transactions/');
    }

    public function financeReport()
    {
        $defaultFromDate = date('Y-m-') . '01';
        $defaultToDate = date('Y-m-d');
        $selectedTransactionType = '';
        $userId = $this->request->getSession()->read('User.id');
        $transactionsMonthWiseInfo = [];
        $transactionsInfo = [];

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            $defaultFromDate = $data['fromDate'];
            $defaultToDate = $data['toDate'];
            $selectedTransactionType = $data['transactionType'];

            //debug($data);


            $conditions = [
                'Transactions.transaction_date >= ' => $defaultFromDate,
                'Transactions.transaction_date <= ' => $defaultToDate,
                'Transactions.user_id' => $userId
            ];

            if ($selectedTransactionType) {
                $conditions['Transactions.transaction_type'] = $selectedTransactionType;
            }

            $transactions = $this->Transactions->find('all')
                ->select(['Transactions.id', 'Transactions.transaction_type', 'Transactions.transaction_date', 'Transactions.name', 'Transactions.transaction_amount'])
                ->where($conditions)
                ->order('Transactions.transaction_date asc')
                ->all();


            $transactionsInfo['income'] = 0;
            $transactionsInfo['expense'] = 0;

            foreach($transactions as $row) {
                $date = $row->transaction_date->format('M Y');

                if (!isset($transactionsMonthWiseInfo[$date]['income'])) {
                    $transactionsMonthWiseInfo[$date]['income'] = 0;
                }

                if (!isset($transactionsMonthWiseInfo[$date]['expense'])) {
                    $transactionsMonthWiseInfo[$date]['expense'] = 0;
                }

                if ($row->transaction_type == 'income') {
                    // month wise income
                    $transactionsMonthWiseInfo[$date]['income'] += (float)$row->transaction_amount;
                    // total income
                    $transactionsInfo['income'] += (float)$row->transaction_amount;
                } else {
                    // month wise expense
                    $transactionsMonthWiseInfo[$date]['expense'] += (float)$row->transaction_amount;
                    // total expense
                    $transactionsInfo['expense'] += (float)$row->transaction_amount;
                }
            }
        }

        $this->set('defaultFromDate', $defaultFromDate);
        $this->set('defaultToDate', $defaultToDate);
        $this->set('selectedTransactionType', $selectedTransactionType);
        $this->set('transactionsInfo', $transactionsInfo);
        $this->set('transactionsMonthWiseInfo', $transactionsMonthWiseInfo);
    }
}
