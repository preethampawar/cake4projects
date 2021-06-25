<?php

use App\Model\Table\ActivitiesTable;

?>

<div class="mb-3">
    <a href="/Activities/selectActivity/<?= $batchInfo->id?>" class="text-decoration-none"><i class="fa fa-arrow-circle-left"></i> Back</a>
</div>

<h5>Add New Activity</h5>

<?php
    echo $this->Form->create(null);
?>

<div class="small mt-3">
    <label class="small">Batch Name</label>
    <div class="mb-2 border rounded bg-light p-1"><?= $batchInfo->name ?></div>

    <label class="small">Activity</label>
    <div class="mb-2 border rounded bg-light p-1"><?= ActivitiesTable::ACTIVITY_TYPES[$selectedActivityType] ?></div>
</div>

<div class="mt-3">
    <?php
    $defaultDate = date('Y-m-d');
    $defaultTime = date('H:i');
    ?>
    <div class="d-flex">
        <div class="w-50">
            <?php
            echo $this->Form->control('activity_date',
                [
                    'label' => 'Date',
                    'type' => 'date',
                    'required' => true,
                    'class' => 'form-control form-control-sm mb-3',
                    'default' => $defaultDate
                ]);
            ?>
        </div>
        <div class="ms-3 w-50">
            <?php
            echo $this->Form->control('activity_time',
                [
                    'label' => 'Time *',
                    'type' => 'time',
                    'required' => true,
                    'class' => 'form-control form-control-sm mb-3',
                    'format' => 'H:i',
                    'default' => $defaultTime
                ]);
            ?>
        </div>
    </div>

    <input type="hidden" name="activity_type" value="<?= $selectedActivityType ?>">
    <?php
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

