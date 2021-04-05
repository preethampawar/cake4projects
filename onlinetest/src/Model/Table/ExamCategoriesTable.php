<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ExamCategoriesTable extends Table
{
    public function initialize(array $config): void
    {
        $this->belongsTo('Exams');

        //$this->addBehavior('Timestamp');
    }
}
