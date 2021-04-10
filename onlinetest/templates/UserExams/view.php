<?= $this->element('myTestsNav');?>

<h1 class="mt-3">Online Test: <?= $exam->name ?></h1>

<p class="text-muted">
    Total Questions:
    <?php
    echo $exam->exam_questions ? count($exam->exam_questions) : 0;
    ?>
    <br>
    Duration: <?= $exam->time ?> mins
</p>


<?php
if ($userExamInfo) {
    ?>
    <div class="text-center mt-3">
        <p>Your test is in progress.</p>
        <p class="text-danger fw-bold">Remaining Time: <?= ($userExamInfo['duration'] - $userExamInfo['time']) ?> mins</p>

        <p>
            <a href="/UserExams/startTest/<?= base64_encode($exam->id) ?>" class="btn btn-primary">
                Continue Online Test &raquo;
            </a>
        </p>
        <p class="mt-5">
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
        </p>
    </div>
    <?php
    if (($userExamInfo['duration'] - $userExamInfo['time']) < 0) {
        ?>
        <script>
            userExam.clearUserExamSession('<?= $exam->id ?>')
        </script>
        <?php
    }
    ?>



    <?php
} else {
    ?>
    <div class="text-center mt-3">
        <a href="/UserExams/startTest/<?= base64_encode($exam->id) ?>" class="btn btn-primary">
            Start Online Test &raquo;
        </a>
    </div>
    <?php
}
?>
<div class="row d-print-none mt-4">
    <div class="text-center">
        <a class="btn btn-danger btn-sm" href="/UserExams/">Cancel</a>
    </div>
</div>

<p>
    <?= $exam->description ?>
</p>



