<?php $this->assign('title', $exam->name) ?>
<h1>Test your knowledge</h1>
<p class="text-muted">You are about the attempt the following online test.</p>
<div class="alert bg-aliceblue border shadow mt-3">

    <h1 class=""><?= $exam->name ?></h1>

    <p class="text-muted">
        <p>Total Questions:
            <?php
            echo $exam->exam_questions ? count($exam->exam_questions) : 0;
            ?>
        </p>

        <p>Duration: <?= $exam->time ?> mins</p>
    </p>

    <div class="text-start mt-4">
        <a href="/UserExams/initiate/<?= base64_encode($exam->id) ?>" class="btn btn-primary">
            Continue &raquo;
        </a>
    </div>

</div>



