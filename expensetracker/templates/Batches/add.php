<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/Batches/">Manage Entities</a></li>
    <li class="breadcrumb-item active" aria-current="page">New Entity</li>
  </ol>
</nav>

<h1>Create New Entity</h1>

<?php

use App\Model\Table\BatchesTable;

echo $this->Form->create(null);
?>

<?php
echo $this->Form->control('name',
    [
        'type' => 'text',
        'label' => 'Entity Name *',
        'required' => true,
        'class' => 'form-control mb-3'
    ]);
echo $this->Form->hidden('active', [
    'value' => '1'
]);
?>

<div class="my-4">
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
</div>

<?php
    echo $this->Form->end();
?>
