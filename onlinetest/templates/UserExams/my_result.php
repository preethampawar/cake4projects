<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/UserExams/myTests">Test Results</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $userExamInfo->exam->name ?></li>
    </ol>
</nav>

<?php
//debug($selectedQAs);
//debug($userExamInfo);

$correctQAs = [];
$notAttemptedQAs = [];
foreach ($userExamInfo->exam->exam_questions as $row) {
    $questionAnswer = $row->question->answer;
    $selectedAnswer = '';

    if (isset($selectedQAs[$row->question->id]) && $selectedQAs[$row->question->id] == $questionAnswer) {
        $correctQAs[$row->question->id] = $questionAnswer;
    }

    if (!isset($selectedQAs[$row->question->id]) ) {
        $notAttemptedQAs[$row->question->id] = $row->question->id;
    }
}

$totalQuestions = count($userExamInfo->exam->exam_questions);
$correctQuestions = count($correctQAs);
$notAttemptedQuestions = count($notAttemptedQAs);
$wrongQuestions = $totalQuestions - $correctQuestions - $notAttemptedQuestions;
$percentage = ($totalQuestions > 0) ? round($correctQuestions * 100 / $totalQuestions, 2) : 0;
$wrongPercentage = ($totalQuestions > 0) ? round($wrongQuestions * 100 / $totalQuestions, 2) : 0;
$skippedPercentage = ($totalQuestions > 0) ? round($notAttemptedQuestions * 100 / $totalQuestions, 2) : 0;

$bgClass = "bg-danger";
if ($percentage >= 90) {
    $bgClass = "bg-success";
} elseif ($percentage >= 70) {
    $bgClass = "bg-warning";
}
?>
<h1><?= $userExamInfo->exam->name ?> - Result</h1>

<div class="row">
    <div class="col-md-3">
        <div class="text-primary fs-4 fw-bold text-center">
            <div class="">Score - <?= $correctQuestions ?></div>
            <div class=""><?= $percentage ?>%</div>
        </div>
        <div class="text-center mb-2">
            [<?php
            echo $userExamInfo->exam->exam_questions ? count($userExamInfo->exam->exam_questions) : 0;
            ?>
            questions, <?= $userExamInfo->exam->time ?> mins]
        </div>
    </div>
    <div class="col">
        <div class="small mb-2 fw-bold alert bg-light">
            <div class="">
                <div class="text-success">Correct: <?= $correctQuestions ?> (<?= $percentage ?>%)</div>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?= $percentage ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="mt-2">
                <div class="text-danger">Wrong: <?= $wrongQuestions ?> (<?= $wrongPercentage ?>%)</div>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?= $wrongPercentage ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="mt-2">
                <div class="text-warning">Not Attempted: <?= $notAttemptedQuestions ?> (<?= $skippedPercentage ?>%)</div>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: <?= $skippedPercentage ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="mt-3">
    <div class="">

        <div class="">
            <h4>Question Answers</h4>
            <?php
            $k = 1;
            $correctQAs = [];
            $notAttemptedQAs = [];
            foreach ($userExamInfo->exam->exam_questions as $row) {
                $questionAnswer = $row->question->answer;
                $selectedAnswer = '';
                $isSelectedAnswerCorrect = false;
                $isSelectedAnswerNotAttempted = false;
                $questionOptions = $row->question->question_options;

                if (isset($selectedQAs[$row->question->id]) && $selectedQAs[$row->question->id] == $questionAnswer) {
                    $isSelectedAnswerCorrect = true;
                    $correctQAs[$row->question->id] = $questionAnswer;
                }

                if (!isset($selectedQAs[$row->question->id])) {
                    $isSelectedAnswerNotAttempted = true;
                    $notAttemptedQAs[$row->question->id] = $row->question->id;
                }
                ?>
                <div class="mb-3">
                    <div class="d-flex mt-3">
                        <div><?= $k ?>.</div>
                        <div class="ms-1 fw-bold"><?= $row->question->name ?></div>
                    </div>

                    <?php
                    $i = 1;

                    foreach ($questionOptions as $questionOption) {
                        $checked = null;
                        $class = null;
                        $chars = range('a', 'z');
                        $radioButtonId = 'answer-' . $userExamInfo->exam->id . '-' . $row->question->id . '-' . ($i + 1);

                        if (isset($selectedQAs[$row->question->id]) && $selectedQAs[$row->question->id] == $i) {
                            $checked = 'checked';
                            $class = 'fw-bold';


                            $class .= $isSelectedAnswerCorrect
                                ? ' text-success'
                                : ' text-danger';
                        }
                        ?>
                        <div
                            id="examQuestion-<?= $row->question->id ?>-<?= $i ?>"
                            class="ms-3 mt-1 small examQuestion-<?= $row->question->id ?> examQuestion-<?= $row->question->id ?>-<?= $i ?> <?= $class ?>"
                        >
                            <div class="form-check">
                                <input
                                    type="radio"
                                    name="data[question][<?= $row->question->id ?>]"
                                    id="<?= $radioButtonId ?>"
                                    class="form-check-input"
                                    <?= $checked ?>
                                    disabled
                                >
                                <label class="form-check-label2" for="<?= $radioButtonId ?>">
                                    <span class="d-flex">
                                        <span><?= $chars[$i-1] ?>)&nbsp;</span>
                                        <span><?= $questionOption->name ?></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <?php
                        $i++;
                    }
                    ?>
                    <div class="fw-bold small">
                        <?=
                        $isSelectedAnswerNotAttempted
                            ? '<span class="btn btn-warning btn-small py-0">Did not attempt</span>'
                            : ($isSelectedAnswerCorrect
                                ? '<span class="btn btn-success btn-small py-0">&check; Correct Answer</span>'
                                : '<span class="btn btn-danger btn-small py-0">&#10005; Wrong Answer</span>')
                        ?>
                    </div>
                    <hr/>
                </div>

                <?php
                $k++;
            }
            ?>

        </div>
    </div>
</div>
