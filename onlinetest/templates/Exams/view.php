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
    Duration: <?= $exam->time ?> mins &nbsp;|&nbsp;
    Start Date: <?= $exam->start_date->format('d/m/Y h:i A') ?> &nbsp;|&nbsp;
    End Date: <?= $exam->end_date->format('d/m/Y h:i A') ?>
</p>

<hr>

<div class="">
    <table class="table table-sm table-hover small mb-3">
        <thead>
        <tr>
            <th style="width: 50px;">#</th>
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
                <td><?= $k ?>.</td>
                <td>
                    <?= $question->name ?>
                    <div class="row">
                        <?php
                        if ($question->question_options) {
                            $i = 1;
                            foreach ($question->question_options as $row) {
                                ?>

                                <div class="col-6">
                                    <?php
                                    $class = null;
                                    $checked = null;
                                    if ($i === (int)$question->answer) {
                                        $class = "fw-bold";
                                        $checked = "checked";
                                    }
                                    ?>
                                    <div class="<?= $class ?>">
                                        <div class="form-check" title="<?= $checked ? 'Correct Answer' : '' ?>">
                                            <span class="small text-secondary"><?= $i ?>.</span>
                                            <input class="form-check-input" type="radio" <?= $checked ?> disabled>
                                            <label class="form-check-label2">
                                                <?= $row->name ?>
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <?php
                                if ($i % 2 == 0) {
                                    echo '</div><div class="row">';
                                }

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


