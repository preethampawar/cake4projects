<div class="row d-print-none">
    <div class="col-md-10">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/UserExams/">Exams</a></li>
                <li class="breadcrumb-item"><?= $exam->name ?></li>
                <li class="breadcrumb-item active" aria-current="page">Start Test</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-2 text-end small">
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

<?php
$userExamInfo = $this->request->getSession()->read('userExamInfo.' . $exam->id);
?>






<div class="card mt-3">
    <div class="card-header">
        <h5><?= $exam->name ?></h5>
        <div class="small">
            Questions: <?php echo (int)$this->Paginator->counter('{{count}}'); ?> &nbsp;|&nbsp;
            Duration: <?= $exam->time ?> mins
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
                    if ($question->question_options) {
                        foreach ($question->question_options as $i => $row) {
                            $checked = null;
                            $class = null;
                            $chars = range('a', 'z');
                            $radioButtonId = 'answer-' . $exam->id . '-' . $question->id . '-' . ($i+1);

                            if (isset($selectedQAs[$question->id]) && $selectedQAs[$question->id] == ($i+1)) {
                                $checked = 'checked';
                                $class = 'text-success fw-bold';
                            }
                            ?>

                            <div
                                id="examQuestion-<?= $question->id ?>-<?= ($i+1) ?>"
                                class="ms-3 small examQuestion-<?= $question->id ?> examQuestion-<?= $question->id ?>-<?= ($i+1) ?> <?= $class ?>"
                            >

                                <div class="form-check">
                                    <span class="small text-secondary"><?= $chars[$i] ?>)</span>
                                    <input
                                        type="radio"
                                        name="data[question][<?= $question->id ?>]"
                                        id="<?= $radioButtonId ?>"
                                        class="form-check-input"
                                        value = "<?= ($i+1) ?>"
                                        onclick = "userExam.updateAnswer(
                                            '<?= base64_encode($userExamId) ?>',
                                            '<?= base64_encode($question->id) ?>',
                                            this.value,
                                            )"
                                        <?= $checked ?>
                                    >
                                    <label class="form-check-label2" for="<?= $radioButtonId ?>">
                                        <?= $row->name ?>
                                    </label>
                                </div>
                            </div>
                            <?php
                        }
                    }
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
        <div>
            <?php
            $showNextLink = false;
            $showPrevLink = false;
            $currentQuestion = ($k - 1);
            $count = (int) $this->Paginator->counter('{{count}}');

            if ($count > $currentQuestion) {
                $showNextLink = true;
            }

            if ($currentQuestion > 1) {
                $showPrevLink = true;
            }
            ?>
            <div class="d-flex justify-content-between mt-2">
                <div class="small">
                    Page: <?= $this->Paginator->counter() ?>
                </div>
                <div class="text-end d-flex pagination">
                    <ul class="list-unstyled <?= $showPrevLink ? null : 'd-none' ?> btn btn-secondary btn-sm" title="Previous">
                        <?= $this->Paginator->prev('« Previous') ?>
                    </ul>
                    <ul class="list-unstyled ms-5 <?= $showNextLink ? null : 'd-none' ?> btn btn-secondary btn-sm" title="Next">
                        <?= $this->Paginator->next('Next »') ?>
                    </ul>
                </div>
                <div class="">
                    <?php
                    echo $this->Html->link(
                        'Finish & Exit Test &raquo;',
                        ['controller' => 'UserExams', 'action' => 'finishTest', base64_encode($exam->id)],
                        [
                            'confirm' => 'Are you sure you want to finish and exit this online exam?',
                            'class' => 'btn btn-sm btn-warning',
                            'escape' => false
                        ]
                    );
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>



<div class="fixed-bottom bg-aliceblue py-3 border-top border-bottom border-2 border-secondary small">
    <div class="container">
        <div class="d-flex justify-content-between">
            <div class="fw-bold">
                Answered Questions: <span class="text-dark"><?= count($selectedQAs) ?></span>
                <span class="text-muted">/ <?php echo (int)$this->Paginator->counter('{{count}}'); ?></span>
            </div>
            <div class="text-danger fw-bold">
                <span id="examTimeDisplay"></span>
            </div>
        </div>
    </div>
</div>






<script>
    userExam.checkExamDuration('<?= $exam->id ?>');
</script>
