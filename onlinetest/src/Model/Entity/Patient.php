<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Patient extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
        // 'slug' => false, // columns that are updated by application
    ];
}
