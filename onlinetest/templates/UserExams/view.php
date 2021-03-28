<?= $this->element('myTestsNav');?>

<h1>Online Test</h1>

<div class="row d-print-none">
    <div class="text-end small">
        <a class="btn btn-sm btn-danger" href="/UserExams/">Cancel</a>
    </div>
</div>


<h2 class="mt-3"><?= $exam->name ?></h2>


<p class="small">
    Total Questions:
    <?php
    echo $exam->exam_questions ? count($exam->exam_questions) : 0;
    ?>
    &nbsp;|&nbsp;
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
    <div class="text-center mt-4">
        <a href="/UserExams/startTest/<?= base64_encode($exam->id) ?>" class="btn btn-primary">
            Start Online Test &raquo;
        </a>
    </div>
    <?php
}
?>

<p>
    <?= $exam->description ?>
</p>



