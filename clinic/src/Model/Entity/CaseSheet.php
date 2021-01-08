<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class CaseSheet extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
        // 'slug' => false, // columns that are updated by application
    ];
}
