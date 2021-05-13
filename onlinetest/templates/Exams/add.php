

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
        <label>Test Series</label>
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

echo $this->Form->hidden('active',
    [
        'type' => 'checkbox',
        'label' => ' Active (Publish)',
        'value' => '0',
        'default' => '0',
        'class' => 'form-check-input mb-3'
    ]);

echo $this->Form->control('total_questions',
    [
        'type' => 'number',
        'label' => 'Total Questions *',
        'default' => 1,
        'required' => true,
        'min' => 1,
        'max' => 1000,
        'class' => 'form-control form-control-sm mb-3'
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
?>

<div class="row">
    <div class="col">
        <?php
        echo $this->Form->control('pass_type',
            [
                'type' => 'select',
                'label' => 'Exam Pass Type',
                'required' => false,
                'empty' => 'Select',
                'options' => ['marks' => 'Marks', 'percentage' => 'Percentage (%)'],
                'class' => 'form-control form-control-sm mb-3'
            ]);
        ?>
    </div>
    <div class="col">
        <?php
        echo $this->Form->control('pass_value',
            [
                'type' => 'number',
                'label' => 'Passing Value',
                'placeholder' => 'Total Marks (or) %',
                'required' => false,
                'min' => 1,
                'max' => 1000,
                'class' => 'form-control form-control-sm mb-3'
            ]);
        ?>
    </div>

</div>

<?php
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
        <label>Test Categories</label>
        <div id="categoriesDivAddQuestionForm">
            <?= $this->element('categoriesDropDown', ['categories' => $categories, 'selected' => $selectedCategory]) ?>
        </div>
    </div>
</div>


<div class="mt-4 mb-3">
    <div class="form-check form-switch">
        <?php
        echo $this->Form->control('allow_guest',
            [
                'id' => 'flexSwitchCheckDefault',
                'type' => 'checkbox',
                'label' => false,
                'div' => false,
                'value' => 1,
                'class' => 'form-check-input'
            ]);
        ?>
        <label class="form-check-label" for="flexSwitchCheckDefault">Allow Guests <span class="small text-muted fst-italic">(Anyone can attempt this test without login)</span></label>
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
