<h1 class="mb-0 fw-bold"><?= $exam->name ?></h1>
<div class="row">
    <div class="col-sm-12 col-md-7 mb-3">
        <div class="">
            <div class="text-center">
                <span class="small text-muted d-none"><?php echo (int)$this->Paginator->counter('{{count}}'); ?> Questions, <?= $exam->time ?> mins</span>
            </div>

            <div class="small bg-light pt-1 pb-2 px-1 shadow-sm rounded mt-3 border">
                <div class="d-flex justify-content-between">
                    <div class="text-center">
                        Remaining Time<br>
                        <div class="badge rounded-pill bg-danger"> <span id="examTimeDisplay"></span> mins</div>
                    </div>
                    <div class="text-center">
                        Test Duration<br>
                        <span class="badge rounded-pill bg-purple"><?= $exam->time ?> mins</span>
                    </div>
                </div>

            </div>
        </div>

        <div class="px-2 py-2 mt-2 shadow-sm rounded border">
        <div class="mt-3">
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
                            <div class="ms-1 fw-bold"><?= $question->name ?></div>
                        </div>
                    </h6>
                    <div class="card-text">
                        <?php
                        echo $this->element('questionOptions', [
                            'examId' => $exam->id,
                            'userExamId' => $userExamInfo->id,
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
        <div class="mt-4 px-2">
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

            <div class="d-flex justify-content-between pagination">
                <div>
                    <?php
                    if($showPrevLink) {
                        ?>
                        <ul class="list-unstyled btn btn-primary m-0 p-0 me-2 me-sm-4" title="Back">
                            <?= $this->Paginator->prev('<i class="fas fa-chevron-circle-left"></i><span class=""> Back</span>', ['escape' => false]) ?>
                        </ul>
                        <?php
                    }
                    ?>
                </div>

                <div class="text-center">
                    <?php
                    if($showNextLink) {
                        ?>
                        <ul class="list-unstyled btn btn-primary m-0 p-0" title="Next">
                            <?= $this->Paginator->next('<span class="">Next </span><i class="fas fa-chevron-circle-right"></i>', ['escape' => false]) ?>
                        </ul>
                        <?php
                    }
                    ?>
                </div>
            </div>

        </div>
        </div>

    </div>
    <div class="col-sm-12 col-md-5 mt-3">
        <div id="testInProgressDetails" class="small"></div>
    </div>
</div>



<div class="mt-4 alert bg-light">
    <div class="text-center">
        <button
            type="button"
            class="btn btn-orange"
            onclick="popup.confirm('/UserExams/finishTest/<?= base64_encode($exam->id) ?>', 'Exit the test?', 'Are you sure you want to finish and exit this online exam?', '')"
        >
            <i class="fas fa-external-link-alt"></i> Finish & Exit Test
        </button>
    </div>
</div>

<!--
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
-->





<?php
$questionNo = $this->request->getQuery('page', '1');
?>
<script>
    userExam.checkExamDuration('<?= $exam->id ?>');
    userExam.getUserExamQAInfo('<?= $exam->id ?>', '<?= $questionNo ?>');
</script>
