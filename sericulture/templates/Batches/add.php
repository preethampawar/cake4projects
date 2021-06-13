<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/Batches/">Batches</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add Batch</li>
  </ol>
</nav>

<h1>Add Batch</h1>

<?php

use App\Model\Table\BatchesTable;

echo $this->Form->create(null);
?>

<div class="text-end">
    <a class="btn btn-sm btn-danger" href="/Batches/">Cancel</a>
</div>

<?php
echo $this->Form->control('name',
    [
        'type' => 'text',
        'label' => 'Batch Name *',
        'required' => true,
        'class' => 'form-control form-control-sm mb-3'
    ]);

echo $this->Form->control('silkworm_type',
    [
        'type' => 'select',
        'label' => 'Batch Type',
        'options' => BatchesTable::SILKWORM_TYPES,
        'class' => 'form-control form-control-sm mb-3'
    ]
);

echo $this->Form->control('dfls',
    [
        'type' => 'number',
        'label' => 'No. of DFLs *',
        'required' => true,
        'min' => '50',
        'step' => '50',
        'max' => '10000',
        'default' => '100',
        'class' => 'form-control form-control-sm mb-3'
    ]);

echo $this->Form->control('cost_of_chawki',
    [
        'type' => 'text',
        'label' => 'Total Chawki Cost *',
        'required' => true,
        'class' => 'form-control form-control-sm mb-3'
    ]);

echo $this->Form->control('hatching_date',
    [
        'label' => 'Eggs Hatching Date',
        'type' => 'date',
        'class' => 'form-control mb-3',
        'default' => date('Y-m-d')
    ]);

echo $this->Form->control('chawki_center_contact_name',
    [
        'type' => 'text',
        'label' => 'Chawki Center Contact Name',
        'required' => false,
        'class' => 'form-control form-control-sm mb-3'
    ]);

echo $this->Form->control('chawki_center_contact_no',
    [
        'type' => 'text',
        'label' => 'Chawki Center Contact No.',
        'required' => false,
        'class' => 'form-control form-control-sm mb-3'
    ]);

echo $this->Form->control('chawki_center_place',
    [
        'type' => 'text',
        'label' => 'Chawki Center Location',
        'required' => false,
        'class' => 'form-control form-control-sm mb-3'
    ]);

echo $this->Form->control('status',
    [
        'type' => 'select',
        'label' => 'Batch Status',
        'options' => [1 => 'Active', 0 => 'Closed'],
        'class' => 'form-control form-control-sm mb-3'
    ]
);
?>

<div class="my-4">
    <?= $this->Form->button(__('Create Batch'), ['class' => 'btn btn-primary btn-sm mt-2']) ?>
</div>

<?php
    echo $this->Form->end();
?>
