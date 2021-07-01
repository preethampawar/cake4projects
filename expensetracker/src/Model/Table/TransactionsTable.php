<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class TransactionsTable extends Table
{
    const TRANSACTION_TYPES = ['expense' => 'Expense', 'income' => 'Income'];

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }
}
