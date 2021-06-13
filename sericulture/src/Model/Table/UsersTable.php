<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
//        $this->hasMany('QuestionOptions', [
//            'className' => 'QuestionOptions',
//            'sort' => 'QuestionOptions.sort asc'
//        ]);

        $this->addBehavior('Timestamp');
    }
}
