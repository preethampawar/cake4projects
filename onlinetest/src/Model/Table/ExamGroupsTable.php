<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ExamGroupsTable extends Table
{
    public function initialize(array $config): void
    {
        $this->hasMany('Exams', [
            'className' => 'Exams',
            'sort' => 'Exams.name asc',
            'where' => ['Exams.deleted' => 0, 'Exams.active' => 1]
        ]);

        $this->addBehavior('Timestamp');
    }
}
