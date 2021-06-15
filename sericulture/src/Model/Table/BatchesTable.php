<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class BatchesTable extends Table
{
    const SILKWORM_TYPES = [
        'BIVOLTINE' => 'BIVOLTINE',
        'CBGOLD' => 'CBGOLD'
    ];

    public function initialize(array $config): void
    {
        $this->hasMany('Activities', [
            'className' => 'Activities',
            'sort' => ['Activities.activity_date desc', 'Activities.activity_time desc']
        ]);

        $this->hasMany('ActivitiesAsc', [
            'className' => 'Activities',
            'sort' => ['ActivitiesAsc.activity_date asc', 'ActivitiesAsc.activity_time asc']
        ]);

        $this->addBehavior('Timestamp');
    }
}
