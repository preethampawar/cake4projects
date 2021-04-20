<?= $this->element('myTestsNav');?>


<h4>My Completed Tests</h4>


<div class="">
    <?php echo $this->Paginator->counter(
            'Total: {{count}}'
        ); ?>
</div>
<div class="table-responsive">
    <table class="table small mt-3 table-hover">
        <thead>
        <tr>
            <th style="width:25px;">#</th>
            <th>Attempted Exams</th>
            <th>Score</th>
            <th>Date</th>
            <th></th>
        </tr>
        </thead>

        <!-- Here is where we iterate through our $articles query object, printing out article info -->

        <tbody>
        <?php
        $k = 0;
        foreach ($userExams as $userExam):
            $exam = $userExam->exam;
            $k++;

            $userExamQAs = $userExamQuestionAnswersModel->findByUserExamId($userExam->id)->all();
            $selectedQAs = [];
            foreach ($userExamQAs as $row2) {
                $selectedQAs[$row2->question_id] = $row2->answer;
            }

            $correctQAs = [];
            $notAttemptedQAs = [];
            foreach ($exam->exam_questions as $row3) {
                $questionAnswer = $row3->question->answer;
                $selectedAnswer = '';

                if (isset($selectedQAs[$row3->question->id]) && $selectedQAs[$row3->question->id] == $questionAnswer) {
                    $correctQAs[$row3->question->id] = $questionAnswer;
                }

                if (!isset($selectedQAs[$row3->question->id]) ) {
                    $notAttemptedQAs[$row3->question->id] = $row3->question->id;
                }
            }

            $totalQuestions = count($exam->exam_questions);
            $correctQuestions = count($correctQAs);
            $notAttemptedQuestions = count($notAttemptedQAs);
            $wrongQuestions = $totalQuestions - $correctQuestions - $notAttemptedQuestions;
            $percentage = ($totalQuestions > 0) ? round($correctQuestions * 100 / $totalQuestions, 2) : 0;

            ?>

            <tr>
                <td>
                    <?= $k ?>.
                </td>
                <td>
                    <?= $exam->name ?>
                    <div class="text-muted ">
                        <?= count($exam->exam_questions) ?> questions,
                        <?= $exam->time ?> mins
                    </div>
<!--
                    <div class="ms-3">
                        <h6 class="text-purple">You have scored - <b><?= $percentage ?>%</b></h6>
                        <div class="text-success">Correct: <?= $correctQuestions ?> </div>
                        <div class="text-danger">Wrong: <?= $wrongQuestions ?></div>
                        <div class="text-danger">Not Attempted: <?= $notAttemptedQuestions ?></div>
                    </div>
                    -->
                </td>
                <td>
                    <span class="text-dark"><?= $percentage ?>%</span>
                </td>
                <td>
                    <?= $userExam->created->format('d/m/Y') ?>
                </td>
                <td class="text-end">
                    <?php
                    if ($userExam->cancelled) {
                        ?>
                        <span class="text-danger">Cancelled</span>
                        <?php
                    } else {
                        ?>
                        <a href="/UserExams/myResult/<?= base64_encode($userExam->id) ?>" title="<?= $exam->name ?>" class="btn btn-sm btn-primary">
                            Result <i class="fas fa-angle-double-right"></i>
                        </a>
                        <?php
                    }
                    ?>
                </td>
            </tr>

        <?php
        endforeach;
        ?>
        </tbody>
    </table>

    <?= $this->element('bottomPagination', ['paginator' => $this->Paginator]); ?>

</div>
