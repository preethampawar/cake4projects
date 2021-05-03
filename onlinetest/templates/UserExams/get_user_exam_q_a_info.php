<?php
if (!empty($selectedQA)) {
    $totalQuestions = count($selectedQA);
    $answered = 0;
    $unanswered = 0;
    foreach ($selectedQA as $row) {
        $isAttempted = (bool)$row['attempted_question_id'];

        if ($isAttempted) {
            $answered++;
        }
    }
    $unanswered = $totalQuestions - $answered;
    ?>

    <div class="rounded border bg-light px-1 pt-2 pb-0">

        <div class="text-center">
            <span class="btn btn-sm btn-purple rounded-pill mt-1 px-3">Total Questions - <?= $totalQuestions ?></span>
            <div class="mt-2">
                <span class="btn btn-sm rounded-pill btn-success-light me-2 px-3">Answered - <?= $answered ?></span>
                <span class="btn btn-sm rounded-pill btn-danger-light px-3">Unanswered - <?= $unanswered ?></span>
            </div>
        </div>
        <hr class="m-3">

        <div class="text-center">
            <?php
            $i = 0;
            foreach ($selectedQA as $row) {
                $i++;
                $questionId = $row['id'];
                $questionName = $row['name'];
                $isAttempted = (bool)$row['attempted_question_id'];
                $bgClass = $isAttempted ? 'btn-success-light' : 'btn-danger-light';

                if ($selectedQuestionNo == $i) {
                    $bgClass = 'btn-primary';
                }
                ?>
                <a
                    href="/UserExams/startTest/<?= base64_encode($examId) ?>?page=<?= $i ?>"
                    class="btn btn-sm rounded-pill <?= $bgClass ?> me-1 mb-2" style="width:40px;"
                    title="<?= $i . '. ' . $questionName ?>">
                    <?= $i ?>
                </a>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
} else {
    ?>
    <script>
        popup.endSession()
    </script>
    <?php
}
?>
