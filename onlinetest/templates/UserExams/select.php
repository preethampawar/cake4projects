<?php
$this->assign('title', $exam->name);
$this->assign('showSocialShare', true);
?>
<?php
$this->Html->meta(
    'keywords',
    'online tests, '.$exam->name,
    ['block' => true]
);
$this->Html->meta(
    'description',
    'Free online tests to practice for competitive and entrance exams',
    ['block' => true]
);
?>
<h4>Test your knowledge</h4>
<p class="text-muted">You are about the attempt the following online test.</p>
<div class="alert bg-aliceblue border shadow mt-3">

    <h4 class=""><?= $exam->name ?></h4>

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



