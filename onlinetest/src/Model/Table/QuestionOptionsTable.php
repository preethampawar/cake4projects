<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class QuestionOptionsTable extends Table
{
    public function initialize(array $config): void
    {
        $this->belongsTo('Questions');
    }
}
