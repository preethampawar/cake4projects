<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/exams/">Tests</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $exam->name ?></li>
    </ol>
</nav>
<div class="text-end">
    <a class="btn btn-sm btn-danger" href="/exams/">Cancel</a>
</div>

<h1>Edit Test - <?= $exam->name ?></h1>

<?php
echo $this->Form->create($exam);
?>


<div class="mt-3 mb-3">
    <div class="">
        <label>Topic</label>
        <div id="examGroupsDivAddQuestionForm">
            <?= $this->element('examGroupsDropDown', ['examGroups' => $examGroups, 'selected' => $exam->exam_group_id]) ?>
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
<div class="mt-3">
    <div class="">
        <label>Categories</label>
        <div id="categoriesDivAddQuestionForm">
            <?php
            $selectedCategories = null;
            if($exam->exam_categories) {
                foreach($exam->exam_categories as $category) {
                    $selectedCategories[] = $category->category_id;
                }
            }
            ?>

            <?= $this->element('categoriesDropDown', ['categories' => $categories, 'selected' => $selectedCategories]) ?>
        </div>
    </div>
</div>

<div class="my-4">
    <?= $this->Form->button(__('Save & Continue'), ['class' => 'btn btn-primary btn-sm mt-2']) ?>
</div>

<?php
echo $this->Form->end();
?>

<script>
    $(document).ready(function () {
        $('#categories').select2({
        });
    })
</script>
