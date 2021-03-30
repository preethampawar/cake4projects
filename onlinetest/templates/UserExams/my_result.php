<?= $this->element('myTestsNav'); ?>

<h1>Exam Result</h1>


<?php
//debug($selectedQAs);
//debug($userExamInfo);

$correctQAs = [];
foreach ($userExamInfo->exam->exam_questions as $row) {
    $questionAnswer = $row->question->answer;
    $selectedAnswer = '';

    if (isset($selectedQAs[$row->question->id]) && $selectedQAs[$row->question->id] == $questionAnswer) {
        $correctQAs[$row->question->id] = $questionAnswer;
    }
}

$totalQuestions = count($userExamInfo->exam->exam_questions);
$correctQuestions = count($correctQAs);
$percentage = round($correctQuestions * 100 / $totalQuestions, 2);

$bgClass = "bg-danger";
if ($percentage >= 90) {
    $bgClass = "bg-success";
} elseif ($percentage >= 70) {
    $bgClass = "bg-warning";
}
?>
<h2 class="mt-4"><?= $userExamInfo->exam->name ?></h2>
<p class="small">
    Total Questions:
    <?php
    echo $userExamInfo->exam->exam_questions ? count($userExamInfo->exam->exam_questions) : 0;
    ?>
    &nbsp;|&nbsp;
    Duration: <?= $userExamInfo->exam->time ?> mins
</p>

<div class="mt-3">
    <div class="card">
        <div class="card-header">
            <div class="">
                <div>

                </div>
                <div class="d-flex justify-content-start small">
                    <div class="badge rounded-circle fs-6 <?= $bgClass ?> bg-gradient"
                         title="You got <?= $correctQuestions ?> answers correct out of <?= $totalQuestions ?>">
                        <table class="table text-center text-white m-0">
                            <tr>
                                <td style="width: 55px;">
                                    <?= $correctQuestions ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="border-bottom-0">
                                    <?= $totalQuestions ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="ms-3">
                        <h6 class="text-purple">You have scored - <b><?= $percentage ?>%</b></h6>
                        <div class="text-success">Correct: <?= $correctQuestions ?> </div>
                        <div class="text-danger">Wrong: <?= ($totalQuestions - $correctQuestions) ?></div>
                    </div>

                </div>
            </div>
        </div>
        <div class="card-body">
            <?php
            $k = 1;
            $correctQAs = [];
            foreach ($userExamInfo->exam->exam_questions as $row) {
                $questionAnswer = $row->question->answer;
                $selectedAnswer = '';
                $isSelectedAnswerCorrect = false;
                $questionOptions = $row->question->question_options;

                if (isset($selectedQAs[$row->question->id]) && $selectedQAs[$row->question->id] == $questionAnswer) {
                    $isSelectedAnswerCorrect = true;
                    $correctQAs[$row->question->id] = $questionAnswer;
                }
                ?>
                <div class="mb-3">
                    <div class="d-flex mt-3">
                        <div><?= $k ?>.</div>
                        <div class="ms-1"><?= $row->question->name ?></div>
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
                        $isSelectedAnswerCorrect
                            ? '<span class="text-success">Correct Answer</span>'
                            : '<span class="text-danger">Wrong Answer</span>'
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
