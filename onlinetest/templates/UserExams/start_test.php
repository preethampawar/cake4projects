<?php
$userExamInfo = $this->request->getSession()->read('userExamInfo.' . $exam->id);
?>

<div class="">
    <div class="">
        <div class="">
            <h5 class="mb-0"><?= $exam->name ?></h5>
            <span class="small text-muted"><?php echo (int)$this->Paginator->counter('{{count}}'); ?> Questions, <?= $exam->time ?> mins</span>
        </div>

        <div class="small bg-aliceblue p-2 rounded mt-2">

            <div class="d-flex justify-content-between">
                <div class="text-center">
                    Remaining Time<br>
                    <span id="examTimeDisplay" class="badge rounded-pill bg-danger"></span>
                </div>
                <div class="text-center">
                    <b>Attempted</b><br>
                    <div class="badge rounded-pill bg-success">
                        <?= count($selectedQAs) ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
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
    <div class="mb-4 mt-3 bg-light py-2 rounded">
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

        <div class="d-flex justify-content-center pagination">
            <?php
            if($showPrevLink) {
            ?>
            <ul class="list-unstyled btn btn-secondary m-0 p-0 me-4" title="Previous">
                <?= $this->Paginator->prev('« Back') ?>
            </ul>
            <?php
            }
            ?>

            <?php
            if($showNextLink) {
                ?>
                <ul class="list-unstyled btn btn-primary m-0 p-0" title="Next">
                    <?= $this->Paginator->next('Next »') ?>
                </ul>
                <?php
            } else {
                ?>
                <div class="text-center">
                    <?php
                    echo $this->Html->link(
                        'Finish & Exit Test',
                        ['controller' => 'UserExams', 'action' => 'finishTest', base64_encode($exam->id)],
                        [
                            'confirm' => 'Are you sure you want to finish and exit this online exam?',
                            'class' => 'btn btn-orange btn-sm',
                            'escape' => false
                        ]
                    );
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php
if($showNextLink) {
?>
<div class="text-center mt-4">
    <?php
    echo $this->Html->link(
        'Finish & Exit Test',
        ['controller' => 'UserExams', 'action' => 'finishTest', base64_encode($exam->id)],
        [
            'confirm' => 'Are you sure you want to finish and exit this online exam?',
            'class' => 'btn btn-orange btn-sm',
            'escape' => false
        ]
    );
    ?>
</div>
<?php
}
?>
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






<script>
    userExam.checkExamDuration('<?= $exam->id ?>');
</script>
