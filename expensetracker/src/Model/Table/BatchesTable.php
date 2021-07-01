<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class BatchesTable extends Table
{
    public function initialize(array $config): void
    {
        $this->hasMany('Transactions', [
            'className' => 'Transactions',
            'sort' => ['Transactions.transaction_date desc', 'Transactions.created desc']
        ]);

        $this->addBehavior('Timestamp');
    }
}
