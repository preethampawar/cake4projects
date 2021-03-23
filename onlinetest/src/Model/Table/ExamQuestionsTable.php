<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ExamQuestionsTable extends Table
{
    public function initialize(array $config): void
    {
        $this->belongsTo('Exams');
        $this->belongsTo('Questions');
    }
}
