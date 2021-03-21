<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class PatientsTable extends Table
{
    public function initialize(array $config): void
    {
        $this->hasMany('CaseSheets', [
            'className' => 'CaseSheets',
            'sort' => 'CaseSheets.date desc, CaseSheets.created desc'
        ]);
        $this->addBehavior('Timestamp');
    }
}
