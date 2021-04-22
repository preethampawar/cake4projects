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
<h1 class="">Online Test</h1>
<div class="text-center">

    <b class=""><?= $exam->name ?></b>

    <div class="text-muted">
        <div>
            <?php
            echo $exam->exam_questions ? count($exam->exam_questions) : 0;
            ?>
            questions, <?= $exam->time ?> mins
        </div>
    </div>

    <div class="mt-4">
        <a href="/UserExams/initiate/<?= base64_encode($exam->id) ?>" class="btn btn-primary">
            Continue <i class="fas fa-angle-right"></i>
        </a>
    </div>

</div>



