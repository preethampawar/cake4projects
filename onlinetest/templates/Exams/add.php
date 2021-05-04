

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/exams/">Tests</a></li>
    <li class="breadcrumb-item active" aria-current="page">New Test</li>
  </ol>
</nav>

<h1>New Test</h1>

<?php
    $selectedCategory = null;
    echo $this->Form->create(null);
?>

<div class="text-end">
    <a class="btn btn-sm btn-danger" href="/exams/">Cancel</a>
</div>


<div class="mt-3 mb-3">
    <div class="">
        <label>Topic</label>
        <div id="examGroupsDivAddQuestionForm">
            <?= $this->element('examGroupsDropDown', ['categories' => $examGroups]) ?>
        </div>
    </div>
</div>

<?php
echo $this->Form->control('name',
    [
        'type' => 'text',
        'label' => 'Test Name *',
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
        'label' => 'Test Duration (minutes) *',
        'default' => 60,
        'required' => true,
        'min' => 5,
        'max' => 300,
        'class' => 'form-control form-control-sm mb-3'
    ]);

echo $this->Form->control('attempts',
    [
        'type' => 'number',
        'label' => 'No of Attempts *',
        'default' => 5,
        'required' => true,
        'min' => 1,
        'max' => 100,
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
    <?= $this->Form->button(__('Create Test'), ['class' => 'btn btn-primary btn-sm mt-2']) ?>
</div>

<?php
    echo $this->Form->end();
?>

<script>
    $(document).ready(function () {
        $('#categories').select2({
        });
        $('#exam-group-id').select2({
        });
    })
</script>
