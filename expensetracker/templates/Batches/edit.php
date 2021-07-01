<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/Batches/">Manage Entities</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Details</li>
    </ol>
</nav>

<h1>Edit Entity</h1>

<?php

use App\Model\Table\BatchesTable;

echo $this->Form->create($batch);
?>

<?php
echo $this->Form->control('name',
    [
        'type' => 'text',
        'label' => 'Entity Name *',
        'required' => true,
        'class' => 'form-control form-control mb-3'
    ]);

echo $this->Form->control('active',
    [
        'type' => 'select',
        'label' => 'Entity Status',
        'options' => [1 => 'Active', 0 => 'Closed'],
        'class' => 'form-select form-select mb-3'
    ]
);

?>

<div class="my-4">
    <?= $this->Form->button(__('Update'), ['class' => 'btn btn-primary']) ?>
    <a class="btn btn-danger ms-3" href="/Batches/">Cancel</a>
</div>

<?php
echo $this->Form->end();
?>
