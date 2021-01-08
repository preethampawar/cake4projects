<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class CaseSheetsTable extends Table
{
    public function initialize(array $config): void
    {
        $this->belongsTo('Patients');
        $this->addBehavior('Timestamp');
    }
}
