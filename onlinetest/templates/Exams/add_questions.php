<div class="row">
    <div class="col-md-10">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/exams/">Exams</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Exam Questions</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-2 text-end small">
        <a class="btn btn-sm btn-danger" href="/exams/">Back</a>
    </div>
</div>





<h1><?= $exam->name ?></h1>

<p class="mt-2 small">
    Duration: <?= $exam->time ?> mins &nbsp;|&nbsp;
    Start Date: <?= $exam->start_date->format('d/m/Y h:i A') ?> &nbsp;|&nbsp;
    End Date: <?= $exam->end_date->format('d/m/Y h:i A') ?>
</p>

<hr>

<?php
//debug($questions);
?>
<div class="row">
    <div class="col-sm-5 bg-light">
        <div class="text-center"><b>Selected questions for Exam</b></div>
        <hr>
        <div class="" id="examSelectedQuestions" style="height: 300px; overflow: auto;">
            Click "Add" button on the right pane to add questions
        </div>

    </div>
    <div class="col-sm-1"></div>
    <div class="col-sm-6 bg-light">
        <div class="text-center"><b>Question Bank</b></div>
        <hr>
        <div class=""  style="height: 300px; overflow: auto;">
            <table class="table table-sm table-hover small mb-3">

                <tbody>
                <?php
                $k = $this->Paginator->counter('{{start}}');
                foreach ($questions as $question):
                    ?>

                    <tr id = "addQuestionRow<?= $question->id ?>">
                        <td><?= $k ?>.</td>
                        <td>
                            <?= $question->name ?>
                        </td>
                        <td class="text-center">
                            <button
                                id = "addQuestionButton<?= $question->id ?>"
                                class="btn btn-sm btn-primary py-0"
                                onclick="exams.addExamQuestion('<?= $exam->id ?>', '<?= $question->id ?>')">
                                Add
                            </button>
                        </td>
                    </tr>

                <?php
                    $k++;
                endforeach;

                if (empty($questions->toArray())) {
                    ?>
                    <tr>
                        <td colspan="4">No questions found.</td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="text-center my-1 small">
            <div class="text-center">
                <ul class="list-unstyled mb-1">
                    <div class="d-inline-flex">
                        <?= $this->Paginator->prev('« Previous') ?>
                    </div>
                    &nbsp;&nbsp;
                    <div class="d-inline-flex">
                        <?= $this->Paginator->next('Next »') ?>
                    </div>
                </ul>
            </div>
            <div>
                Page: <?= $this->Paginator->counter() ?>
            </div>
        </div>
    </div>
</div>

<script>
    $( document ).ready(function() {
        exams.loadSelectedExamQuestions('<?= $exam->id ?>')
    });
</script>


<?php
echo $this->Form->create(null);
?>


<?php
echo $this->Form->end();
?>
