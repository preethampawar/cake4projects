<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class UserExamQuestionAnswersTable extends Table
{
    public function initialize(array $config): void
    {
        $this->belongsTo('Questions', [
            'className' => 'Questions',
        ]);

//        $this->addBehavior('Timestamp');
    }
}
