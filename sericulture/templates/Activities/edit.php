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

<h5><?= $activity->name ?></h5>
<div class="mt-3">
    <div class="d-flex">
        <div>
            <?php
            echo $this->Form->control('activity_date',
                [
                    'label' => 'Date',
                    'type' => 'date',
                    'required' => true,
                    'class' => 'form-control mb-3',
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
                ]);
            ?>
        </div>
    </div>

    <?php
    echo $this->Form->control('activity_type',
        [
            'type' => 'select',
            'label' => 'Select Activity *',
            'required' => true,
            'options' => ActivitiesTable::ACTIVITY_OPTIONS,
            'class' => 'form-select form-select-sm mb-3 select2dropdown',

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
        <?= $this->Form->button(__('Update Activity'), ['class' => 'btn btn-primary']) ?>
        <a class="btn btn-danger ms-3" href="/Activities/">Cancel</a>
    </div>
</div>

<?php
echo $this->Form->end();
?>













