<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/questions/">Question Bank</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Question</li>
    </ol>
</nav>

<h1>Edit Question</h1>

<?php
echo $this->Form->create($question);
?>

<div class="text-end mb-3">

    <?php
    if ($editorEnabled == '1') {
        ?>
        <a href="/Questions/edit/<?= $id ?>/0" class="btn btn-secondary btn-sm">Disable Editor</a>
        <?php
    } else {
        ?>
        <a href="/Questions/edit/<?= $id ?>/1" class="btn btn-info btn-sm">Enable Editor</a>
        <?php
    }
    ?>

    <a class="btn btn-sm btn-danger ms-3" href="/questions/">Cancel</a>
</div>
<?= $this->Form->control('type', ['type' => 'hidden', 'value' => 'MultipleChoice-SingleAnswer']) ?>

<?php
//echo $this->Form->control('type', [
//        'type' => 'select',
//        'label' => 'Question Type *',
//        'required' => true,
//        'class' => 'form-control form-control-sm mb-3',
//        'options' => ['MultipleChoice-SingleAnswer' => 'Multiple Choice - Single Answer', 'MultipleChoice-MultipleAnswers' => 'Multiple Choice - Multiple Answers'],
//        'default' => 'MultipleChoice-SingleAnswer',
//    ]);

$type = $editorEnabled ? 'textarea' : 'text';
// $required = $editorEnabled ? false : true;
$required = false;
$selectedSubject = null;
$selectedEducationLevel = null;
$selectedTags = !empty($question->tags) ? explode(',', $question->tags) : [];
?>

<div class="bg-light alert alert-light mt-4">
    <?php
    echo $this->Form->control('name',
        [
            'type' => $type,
            'rows' => 2,
            'label' => 'Question *',
            'default' => $editorEnabled ? ' ' : null,
            'required' => $required,
            'class' => 'form-control form-control-sm mb-3'
        ]);
    ?>
    <table class="table table-sm small table-hover table-borderless mb-0">
        <tbody>
        <?php
        for ($i = 1; $i <= 4; $i++) {
            ?>
            <tr>
                <td style="width: 6rem;">
                    Option <?= $i ?> :
                    <?= $this->Form->control("options[$i][order]", ['type' => 'hidden', 'value' => $i]) ?>
                </td>
                <td>
                    <?= $this->Form->control("options[$i][name]", [
                        'type' => $type,
                        'rows' => 2,
                        'label' => false,
                        'default' => isset($options[$i]['name']) ? $options[$i]['name'] : ($editorEnabled ? ' ' : null),
                        'required' => $required,
                        'class' => 'form-control form-control-sm mb-3'
                    ]) ?>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <?php
    echo $this->Form->control('answer', [
        'type' => 'select',
        'label' => 'Choose Correct Answer *',
        'class' => 'form-control form-control-sm',
        'options' => [
            '1' => 'Option 1',
            '2' => 'Option 2',
            '3' => 'Option 3',
            '4' => 'Option 4',
        ],
        'default' => 'MultipleChoice-SingleAnswer',
    ]);
    ?>
</div>

<div class="bg-light alert alert-light mt-4">

    <div class="row">
        <div class="col-sm-4">
            <div class="mt-3">
                <label>Subject (<a href="#" data-bs-toggle="modal" data-bs-target="#addSubject" class="small py-0">+Add New</a>)</label>
                <div id="subjectDivAddQuestionForm">
                    <?= $this->element('subjectsDropDown', ['subjects' => $subjects, 'selectedSubject' => $selectedSubject]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mt-3">
                <label>Education (<a href="#" data-bs-toggle="modal" data-bs-target="#addEducationLevel" class="small py-0">+Add New</a>)</label>
                <div id="educationLevelDivAddQuestionForm">
                    <?= $this->element('educationLevelsDropDown', ['educationLevels' => $educationLevels, 'selected' => $selectedEducationLevel]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mt-3">
                <?php
                echo $this->Form->control('difficulty_level', [
                    'type' => 'select',
                    'class' => 'form-control form-control-sm',
                    'options' => [
                        '1' => 'Easy',
                        '2' => 'Medium',
                        '3' => 'Hard',
                    ],
                ]);
                ?>
            </div>
        </div>

    </div>

    <div class="mt-3">
        <label>Tags (<a href="#" data-bs-toggle="modal" data-bs-target="#addTags" class="small py-0">+Add New</a>)</label>
        <div id="tagsDivAddQuestionForm">
            <?= $this->element('tagsDropDown', ['tags' => $tags, 'selected' => $selectedTags]) ?>
        </div>
    </div>
</div>

<div class="my-4 text-center">
    <?= $this->Form->button(__('Update'), ['class' => 'btn btn-primary btn-sm mt-2']) ?>
</div>

<?php
echo $this->Form->end();
?>

<?php
if ($editorEnabled) {
    echo $this->element('ckeditorQuestions', ['maths' => true]);
}
?>

<?php
echo $this->element('addSubjectPopup');
echo $this->element('addEducationLevelPopup');
echo $this->element('addTagsPopup');
?>
<script>
    $(document).ready(function () {
        $('#tags').select2({
        });
    })
</script>
