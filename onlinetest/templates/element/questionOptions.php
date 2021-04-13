<?php
if ($questionOptions) {
    foreach ($questionOptions as $i => $questionOption) {
        $checked = null;
        $class = null;
        $questionOptionId = $questionOption->id;
        $questionId = $questionOption->question_id;
        $chars = range('a', 'z');
        $radioButtonId = 'answer-' . $examId . '-' . $questionId . '-' . ($i+1);

        if (isset($userSelectedQAs[$questionId]) && $userSelectedQAs[$questionId] == ($i+1)) {
            $checked = 'checked';
            $class = 'text-success fw-bold';
        }
        ?>

        <div
            id="examQuestion-<?= $questionId ?>-<?= ($i+1) ?>"
            class="ms-3 examQuestion-<?= $questionId ?> examQuestion-<?= $questionId ?>-<?= ($i+1) ?> <?= $class ?>"
        >
            <div class="form-check">
                <input
                    type="radio"
                    name="data[question][<?= $questionId ?>]"
                    id="<?= $radioButtonId ?>"
                    class="form-check-input"
                    value = "<?= ($i+1) ?>"
                    onclick = "userExam.updateAnswer(
                        '<?= base64_encode($userExamId) ?>',
                        '<?= base64_encode($questionId) ?>',
                        this.value,
                        '<?= base64_encode($examId) ?>',
                        )"
                    <?= $checked ?>
                >
                <label class="form-check-label2" for="<?= $radioButtonId ?>">
                    <span class="d-flex">
                        <span><?= $chars[$i] ?>)&nbsp;</span>
                        <span><?= $questionOption->name ?></span>
                    </span>
                </label>
            </div>
        </div>
        <?php
    }
}
?>
