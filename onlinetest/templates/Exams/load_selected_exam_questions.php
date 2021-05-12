<?php
$examsList = null;
foreach($exams as $exam1) {
    $examsList[$exam1->id] = (string)$exam1->name;
}
?>

<table class="table table-hover table-sm small">
    <tbody>
    <?php
    if (!empty($examQuestions)) {
        $i = 1;
        foreach ($examQuestions as $row) {
            $examQuestionId = $row->id;
            $questionId = $row->question->id;
            $question = $row->question->name;
        ?>
        <tr>
            <td><?= $i ?>.</td>
            <td><?= $question ?></td>
            <td class="text-end px-2">

                <div class="dropdown">
                    <a class="text-decoration-none" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li>
                            <span class="dropdown-item small">
                                Move to Test
                                <?php
                                echo $this->Form->control('exam_id', [
                                    'type' => 'select',
                                    'label' => false,
                                    'class' => 'form-control form-control-sm',
                                    'options' => $examsList,
                                    'escape' => false,
                                    'empty' => false,
                                    'multiple' => false,
                                    'value' => $examId,
                                    'onchange' => 'exams.moveSelectedExamQuestion("'. $questionId.'", "' . $examId. '", this.value, this.selectedOptions[0].text)'
                                ]);
                                ?>
                            </span>
                        </li>
                        <li><a class="dropdown-item" href="#" onclick="exams.deleteSelectedExamQuestion('<?= $examId ?>', '<?= $examQuestionId ?>')">Delete</a></li>
                    </ul>
                </div>

                <script>
                    $( document ).ready(function() {
                        exams.disableAddButtonInQuestionBank("<?= $questionId ?>")
                    });
                </script>
            </td>
        </tr>
        <?php
            $i++;
        }
    } else {
        ?>
        <tr>
            <td colspan="3">Click "Add" button on the left pane to add questions</td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
<input type="hidden" id="totalExamQuestions" value="<?= $examQuestions ? count($examQuestions) : 0 ?>">

<script>
    $('.selectedQuestionsSpan').text('<?= $examQuestions ? count($examQuestions) : 0 ?>')
</script>
