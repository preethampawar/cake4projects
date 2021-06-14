<?php

use App\Model\Table\ActivitiesTable;

?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/Activities/">Activities</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= $batchInfo->name?></li>
  </ol>
</nav>

<h1>Add Activity</h1>

<?php
    echo $this->Form->create(null);
?>



<h5><?= $batchInfo->name ?></h5>
<div class="mt-3">
    <?php


    $defaultDate = $recentActivity ? $recentActivity->activity_date->format('Y-m-d') : date('Y-m-d');
    echo $this->Form->control('activity_date',
        [
            'label' => 'Date & Time *',
            'type' => 'datetime',
            'required' => true,
            'class' => 'form-control mb-3',
            'default' => $defaultDate
        ]);

    $defaultActivityType = $recentActivity ? $recentActivity->activity_type : null;
    echo $this->Form->control('activity_type',
        [
            'type' => 'select',
            'label' => 'Select New Activity *',
            'required' => true,
            'options' => ActivitiesTable::ACTIVITY_OPTIONS,
            'class' => 'form-select form-select-sm mb-3 select2dropdown',
            'default' => $defaultActivityType,
            'size' => 10
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
        <?= $this->Form->button(__('Save Activity'), ['class' => 'btn btn-primary']) ?>
        <a class="btn btn-danger ms-3" href="/Activities/">Cancel</a>
    </div>

</div>

<?php
    echo $this->Form->end();
?>

