<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class BillingsTable extends Table
{
    public function initialize(array $config): void
    {
        $this->belongsTo('Patients');
        $this->addBehavior('Timestamp');
    }
}
