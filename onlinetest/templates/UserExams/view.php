<div class="row d-print-none">
    <div class="col-md-10">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/userexams/">Exams</a></li>
                <li class="breadcrumb-item active" aria-current="page">Online Test</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-2 text-end small">
        <a class="btn btn-sm btn-danger" href="/userexams/">Back</a>
    </div>
</div>

<h1><?= $exam->name ?></h1>


<p class="small">
    Total Questions:
    <?php
    echo $exam->exam_questions ? count($exam->exam_questions) : 0;
    ?>
    &nbsp;|&nbsp;
    Duration: <?= $exam->time ?> mins
</p>
<p class="small">
    End Date: <?= $exam->end_date->format('d/m/Y h:i A') ?>
</p>
<p>
    <?= $exam->description ?>
</p>

<?php
if ($userExamInfo) {
    ?>
    <div class="text-center mt-3">
        <p>Your test is in progress.</p>
        <p class="text-danger fw-bold">Remaining Time: <?= ($userExamInfo['duration'] - $userExamInfo['time']) ?> mins</p>

        <p>
            <a href="/userexams/startTest/<?= base64_encode($exam->id) ?>" class="btn btn-primary">
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
    <div class="text-center mt-5">
        <a href="/userexams/startTest/<?= base64_encode($exam->id) ?>" class="btn btn-primary">
            Start Online Test &raquo;
        </a>
    </div>
    <?php
}
?>



