<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/exams/">Exams</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Details</li>
    </ol>
</nav>

<h1>Edit Exam</h1>

<?php
echo $this->Form->create($exam);
?>

<div class="text-end">
    <a class="btn btn-sm btn-danger" href="/exams/">Cancel</a>
</div>

<?php
echo $this->Form->control('name',
    [
        'type' => 'text',
        'label' => 'Exam Name *',
        'required' => true,
        'class' => 'form-control form-control-sm mb-3'
    ]);

echo $this->Form->control('active',
    [
        'type' => 'checkbox',
        'label' => ' Active (Publish)',
        'value' => '1',
        'default' => '1',
        'class' => 'form-check-input mb-3'
    ]);

echo $this->Form->control('time',
    [
        'type' => 'number',
        'label' => 'Exam Duration (minutes) *',
        'default' => 60,
        'required' => true,
        'min' => 5,
        'max' => 300,
        'class' => 'form-control form-control-sm mb-3'
    ]);

//echo $this->Form->control('start_date',
//    [
//        'label' => 'Start Date *',
//        'type' => 'datetime',
//        'required' => true,
//        'class' => 'form-control mb-3',
//        'default' => date('Y-m-d')
//    ]);
//
//echo $this->Form->control('end_date',
//    [
//        'label' => 'End Date *',
//        'type' => 'datetime',
//        'required' => true,
//        'class' => 'form-control mb-3',
//        'default' => date('Y-m-d', strtotime('+ 1 day'))
//    ]);

?>

<div class="my-4">
    <?= $this->Form->button(__('Update Exam Details'), ['class' => 'btn btn-primary btn-sm mt-2']) ?>
</div>

<?php
echo $this->Form->end();
?>
