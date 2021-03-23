<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ExamsTable extends Table
{
    public function initialize(array $config): void
    {
        $this->hasMany('ExamQuestions', [
            'className' => 'ExamQuestions',
            'sort' => 'ExamQuestions.sort asc'
        ]);

        $this->addBehavior('Timestamp');
    }
}
