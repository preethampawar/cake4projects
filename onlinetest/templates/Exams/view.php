<div class="row d-print-none">
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


<?php
//debug($exam);
?>


<h1><?= $exam->name ?></h1>

<p class="mt-2 small">
    Total Questions: <?= $exam->exam_questions ? count($exam->exam_questions) : 0 ?>
    <br>
    Duration: <?= $exam->time ?> mins
    <!--
    &nbsp;|&nbsp;
    Start Date: <?= $exam->start_date->format('d/m/Y h:i A') ?> &nbsp;|&nbsp;
    End Date: <?= $exam->end_date->format('d/m/Y h:i A') ?>
    -->
</p>

<hr>

<div class="">
    <table class="table table-hover table-sm mb-3">
        <thead>
        <tr>
            <th style="width: 25px;">#</th>
            <th>Question</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $k = 1;
        foreach ($exam->exam_questions as $row):
            $question = $row->question;
            // $questionOptions = $row->question_options;
            ?>

            <tr id = "addQuestionRow<?= $question->id ?>">
                <td class="py-2"><?= $k ?>.</td>
                <td class="py-2">
                    <?= $question->name ?>
                    <div class="">
                        <?php
                        if ($question->question_options) {
                            $i = 1;
                            foreach ($question->question_options as $row) {
                                ?>

                                <div class="">
                                    <?php
                                    $chars = range('a', 'z');
                                    $class = null;
                                    $checked = null;
                                    if ($i === (int)$question->answer) {
                                        $class = "fw-bold";
                                        $checked = "checked";
                                    }
                                    ?>
                                    <div class="<?= $class ?>">
                                        <div class="form-check" title="<?= $checked ? 'Correct Answer' : '' ?>">
                                            <input class="form-check-input" type="radio" <?= $checked ?> disabled>
                                            <label class="form-check-label2">
                                                <span class="text-secondary d-flex">
                                                    <span><?= $chars[$i - 1] ?>)&nbsp;</span>
                                                    <span><?= $row->name ?></span>
                                                </span>
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </div>
                </td>
            </tr>

            <?php
            $k++;
        endforeach;

        if (empty($exam->exam_questions)) {
            ?>
            <tr>
                <td colspan="2">No questions found.</td>
            </tr>
        <?php
        }
        ?>

        </tbody>
    </table>
</div>


