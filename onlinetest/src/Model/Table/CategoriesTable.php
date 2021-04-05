<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class CategoriesTable extends Table
{
    public function initialize(array $config): void
    {
        $this->hasMany('ExamCategories', [
            'className' => 'ExamCategories',
            // 'sort' => 'ExamCategories.sort asc'
        ]);

        // $this->addBehavior('Timestamp');
    }
}
