<?php

use App\Model\Table\ActivitiesTable;

?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/Activities/">Activities</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= $batchInfo->name?></li>
  </ol>
</nav>

<h1>Add New Activity</h1>

<?php
    echo $this->Form->create(null);
?>

<label>Batch Name</label>
<input type="text" value="<?= $batchInfo->name ?>" class="form-control mb-3" disabled>


<div class="mt-3">
    <?php
    $defaultDate = $recentActivity ? $recentActivity->activity_date->format('Y-m-d') : date('Y-m-d');
    // $defaultDate = date('Y-m-d');
    $defaultTime = date('h:00 A');
    ?>
    <div class="d-flex">
        <div>
            <?php
            echo $this->Form->control('activity_date',
                [
                    'label' => 'Date',
                    'type' => 'date',
                    'required' => true,
                    'class' => 'form-control mb-3',
                    'default' => $defaultDate
                ]);
            ?>
        </div>
        <div class="ms-3">
            <?php
            echo $this->Form->control('activity_time',
                [
                    'label' => 'Time *',
                    'type' => 'time',
                    'required' => true,
                    'class' => 'form-control mb-3',
                    'format' => 'h:i',
                    'default' => $defaultTime
                ]);
            ?>
        </div>
    </div>

    <?php
    $defaultActivityType = $recentActivity ? $recentActivity->activity_type : null;
    echo $this->Form->control('activity_type',
        [
            'type' => 'select',
            'label' => 'Select New Activity *',
            'required' => true,
            'options' => ActivitiesTable::ACTIVITY_OPTIONS,
            'class' => 'form-select form-select-sm mb-3 select2dropdown',
            'default' => $defaultActivityType,
        ]);
    echo '<br>';
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

