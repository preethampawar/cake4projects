<?php

use App\Model\Table\ActivitiesTable;

?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/Activities/">Activities</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $batchInfo->name?></li>
    </ol>
</nav>

<h1>Edit Activity</h1>

<?php
echo $this->Form->create($activity);
?>

<div class="text-end">
    <a class="btn btn-sm btn-danger" href="/Activities/">Cancel</a>
</div>

<h5><?= $activity->name ?></h5>
<div class="mt-3">
    <?php
    echo $this->Form->control('activity_type',
        [
            'type' => 'select',
            'label' => 'Select Activity *',
            'required' => true,
            'options' => ActivitiesTable::ACTIVITY_OPTIONS,
            'class' => 'form-control form-control-sm mb-3 select2dropdown'
        ]);
    echo '<br>';

    echo $this->Form->control('activity_date',
        [
            'label' => 'Date & time *',
            'type' => 'datetime',
            'required' => true,
            'class' => 'form-control mb-3',
            'default' => date('Y-m-d H:i:s')
        ]);

    echo $this->Form->control('notes',
        [
            'type' => 'textarea',
            'label' => 'Notes',
            'rows' => 2,
            'required' => false,
            'class' => 'form-control form-control-sm mb-3'
        ]);

    ?>


    <div class="my-4">
        <?= $this->Form->button(__('Update Activity'), ['class' => 'btn btn-primary']) ?>
        <a class="btn btn-danger ms-3" href="/Activities/">Cancel</a>
    </div>
</div>

<?php
echo $this->Form->end();
?>













