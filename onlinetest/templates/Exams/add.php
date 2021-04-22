

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/exams/">Exams</a></li>
    <li class="breadcrumb-item active" aria-current="page">New Exam</li>
  </ol>
</nav>

<h1>Add Exam</h1>

<?php
    $selectedCategory = null;
    echo $this->Form->create(null);
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

echo $this->Form->hidden('start_date',
    [
        'label' => 'Start Date *',
        'type' => 'datetime',
        'required' => true,
        'class' => 'form-control mb-3',
        'default' => date('Y-m-d H:i:s')
    ]);

echo $this->Form->hidden('end_date',
    [
        'label' => 'End Date *',
        'type' => 'datetime',
        'required' => true,
        'class' => 'form-control mb-3',
        'default' => date('Y-m-d H:i:s', strtotime('+ 20 years'))
    ]);

?>

<div class="mt-3">
    <div class="">
        <label>Categories</label>
        <div id="categoriesDivAddQuestionForm">
            <?= $this->element('categoriesDropDown', ['categories' => $categories, 'selected' => $selectedCategory]) ?>
        </div>
    </div>
</div>


<div class="my-4">
    <?= $this->Form->button(__('Create Exam'), ['class' => 'btn btn-primary btn-sm mt-2']) ?>
</div>

<?php
    echo $this->Form->end();
?>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $('#categories').select2({
        });
    })
</script>
