

<?php
$userExamInfo = $this->request->getSession()->read('userExamInfo.' . $exam->id);
?>

<div class="card">
    <div class="card-header">
        <h5><?= $exam->name ?></h5>
        <div class="small">
            Duration: <?= $exam->time ?> mins
            <br>
            Questions: <?php echo (int)$this->Paginator->counter('{{count}}'); ?>
            &nbsp;|&nbsp;
            <b>Answered: <span class="badge rounded-pill bg-success"><?= count($selectedQAs) ?></span></b>
            <br>
            <div class="">
                Remaining Time: <span id="examTimeDisplay" class="badge rounded-pill bg-danger"></span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?php
        echo $this->Form->create();
        echo $this->Form->end();
        ?>

        <?php
        $k = $this->Paginator->counter('{{start}}');
        $examsQuestionsCount = count($examsQuestions);
        foreach ($examsQuestions as $row):
            $question = $row->question;
            $borderClass = ($examsQuestionsCount > ($k)) ? 'pb-3 mb-3 border-bottom' : null;
            ?>

            <div id = "addQuestionRow<?= $question->id ?>" class="<?= $borderClass ?>">

                <h6 class="card-title">
                    <div class="d-flex">
                        <div><?= $k ?>.</div>
                        <div class="ms-1"><?= $question->name ?></div>
                    </div>
                </h6>
                <div class="card-text">
                    <?php
                    echo $this->element('questionOptions', [
                        'examId' => $exam->id,
                        'userExamId' => $userExamId,
                        'questionOptions' => $question->question_options,
                        'userSelectedQAs' => $selectedQAs,
                    ]);
                    ?>
                </div>
            </div>

            <?php
            $k++;
        endforeach;

        if (empty($examsQuestions)) {
            ?>

                <p>No questions found.</p>

            <?php
        }
        ?>
    </div>
    <div class="card-footer">
        <?php
        $showNextLink = false;
        $showPrevLink = false;
        $showFinishLink = false;
        $currentQuestion = ($k - 1);
        $count = (int) $this->Paginator->counter('{{count}}');

        if ($count > $currentQuestion) {
            $showNextLink = true;
        }
        if ($currentQuestion > 1) {
            $showPrevLink = true;
        }
        if ($count == $currentQuestion) {
            $showFinishLink = true;
        }
        ?>

        <?php
        if($showFinishLink) {
            ?>
            <div class="text-danger text-center mb-3">This is your last Question. Click "<span class="fw-bold">Finish & Exit Test</span>" button to complete the test.</div>
            <?php
        }
        ?>

        <div class="d-flex justify-content-center pagination">
            <ul class="list-unstyled <?= $showPrevLink ? null : 'disabled' ?> btn btn-secondary m-0 p-0" title="Previous">
                <?= $this->Paginator->prev('« Previous') ?>
            </ul>

            <ul class="list-unstyled <?= $showNextLink ? null : 'disabled' ?> btn btn-primary m-0 p-0 ms-4" title="Next">
                <?= $this->Paginator->next('Next »') ?>
            </ul>
        </div>
    </div>
</div>





<div class="my-4 text-center">
    <?php
    echo $this->Html->link(
        'Finish & Exit Test',
        ['controller' => 'UserExams', 'action' => 'finishTest', base64_encode($exam->id)],
        [
            'confirm' => 'Are you sure you want to finish and exit this online exam?',
            'class' => 'btn btn-danger',
            'escape' => false
        ]
    );
    ?>
</div>
<hr>
<div class="row d-print-none mb-4">
    <div class="text-center small">
        <?php
        echo $this->Html->link(
            'Cancel Test',
            ['controller' => 'UserExams', 'action' => 'cancelTest', base64_encode($exam->id)],
            [
                'confirm' => 'Are you sure you want to cancel this online exam?',
                'class' => 'btn btn-sm btn-danger',
            ]
        );
        ?>
    </div>
</div>






<script>
    userExam.checkExamDuration('<?= $exam->id ?>');
</script>
