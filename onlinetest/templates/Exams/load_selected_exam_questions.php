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
            <td class="text-end">
                <button
                    class="btn btn-sm btn-danger py-0"
                    onclick="exams.deleteSelectedExamQuestion('<?= $examId ?>', '<?= $examQuestionId ?>')">
                    X
                </button>
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
