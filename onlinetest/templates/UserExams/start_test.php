<?php
$userExamInfo = $this->request->getSession()->read('userExamInfo.' . $exam->id);
?>

<div class="">
    <div class="">
        <div class="text-center">
            <h1 class="mb-0 fw-bold text-primary"><?= $exam->name ?></h1>
            <span class="small text-muted d-none"><?php echo (int)$this->Paginator->counter('{{count}}'); ?> Questions, <?= $exam->time ?> mins</span>
        </div>

        <div class="small bg-light pt-1 pb-2 px-1 rounded mt-2 border">
            <div class="d-flex justify-content-between">
                <div class="text-center">
                    Remaining Time<br>
                    <span id="examTimeDisplay" class="badge rounded-pill bg-danger"></span>
                     /
                    <span class="badge rounded-pill bg-info"><?= $exam->time ?> mins</span>
                </div>
                <div class="text-center">
                    Attempted<br>
                    <span class="badge rounded-pill bg-danger">
                        <?= count($selectedQAs) ?>
                    </span> /
                    <span class="badge rounded-pill bg-info">
                        <?php echo (int)$this->Paginator->counter('{{count}}'); ?>
                    </span>
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
    <div class="mb-4 mt-4 bg-light py-2 px-1 rounded">
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

            <div class="text-center">
                <button
                    type="button"
                    class="btn btn-orange btn-sm"
                    onclick="popup.confirm('/UserExams/finishTest/<?= base64_encode($exam->id) ?>', 'Exit the test?', 'Are you sure you want to finish and exit this online exam?', '')"
                >
                    <i class="fas fa-external-link-alt"></i> Finish & Exit
                </button>
            </div>

        </div>
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






<script>
    userExam.checkExamDuration('<?= $exam->id ?>');
</script>
