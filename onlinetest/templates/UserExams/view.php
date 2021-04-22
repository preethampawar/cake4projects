<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/UserExams/list">Tests</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $exam->name ?></li>
    </ol>
</nav>

<h1 class="mt-3 fw-bold"><?= $exam->name ?></h1>

<div class="text-muted">
    <?php
    echo $exam->exam_questions ? count($exam->exam_questions) : 0;
    ?> questions, <?= $exam->time ?> mins
</div>

<div class="text-center mt-4 mb-4">
    <a href="/UserExams/newTest/<?= base64_encode($exam->id) ?>" class="btn btn-primary">
        <i class="fas fa-play-circle"></i> Start Test
    </a>

    <a class="btn btn-danger ms-3" href="/UserExams/">
        <i class="fas fa-times"></i> Cancel
    </a>
</div>

<?php
/*
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
        <a href="/UserExams/newTest/<?= base64_encode($exam->id) ?>" class="btn btn-primary">
            Start Online Test &raquo;
        </a>
    </div>
    <?php
}

*/
?>


<script>
    $(document).ready(function () {
        userExam.clearUserExamSession('<?= $exam->id ?>')
    })
</script>



