<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class SubjectsTable extends Table
{
    public function initialize(array $config): void
    {
//        $this->hasMany('Questions', [
//            'className' => 'Questions',
//            'sort' => 'Questions.sort desc'
//        ]);
    }
}
