<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/questions/">Question Bank</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add Question</li>
  </ol>
</nav>

<h1>Add Question</h1>

<?php
    echo $this->Form->create(null);
?>

<div class="text-end">
    <a class="btn btn-sm btn-danger" href="/questions/">Cancel</a>
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

echo $this->Form->control('name',
    [
        'type' => 'textarea',
        'rows' => 2,
        'label' => 'Question *',
        'class' => 'form-control form-control-sm mb-3',
        'contenteditable' => 'true',
        'default' => ' ',
    ]);
?>
<div>
    <table class="table table-sm small table-hover table-borderless">
        <tbody>
        <?php
        for ($i = 1; $i <= 4; $i++) {
        ?>
            <tr>
                <td style="width: 5rem;">
                    Option <?= $i ?>
                    <?= $this->Form->control("options[$i][order]", ['type' => 'hidden', 'value' => $i]) ?>
                </td>
                <td>
                    <?= $this->Form->control("options[$i][name]", [
                        'type' => 'textarea',
                        'rows' => 1,
                        'label' => false,
                        'class' => 'form-control form-control-sm mb-3',
                        'contenteditable' => 'true',
                        'default' => ' ',
                    ]) ?>
                </td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
</div>

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


<div class="my-4">
    <?= $this->Form->button(__('Save Question'), ['class' => 'btn btn-primary btn-sm mt-2']) ?>
</div>

<?php
    echo $this->element('ckeditorQuestions', ['maths' => true]);
    echo $this->Form->end();

?>
