<?php
if ($this->request->getSession()->check('User.isAdmin')
    && $this->request->getSession()->read('User.isAdmin') == true) {
    ?>
    <div class="text-center">
        <h1>Welcome Admin</h1>
    </div>
    <?php
    return;
}
?>

<?= $this->request->getSession()->check('User.id') ? $this->element('myTestsNav') : null;?>

<div class="mt-3 text-muted alert bg-aliceblue shadow border">
    Free online tests to practice for competitive and entrance exams. Prepare for your exam online with our many free tests.
</div>


<div class="alert shadow mt-3 border">
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <h5>Total <?php echo count($exams) ?> test(s)</h5>
        </li>
        <?php
        $k = 0;
        foreach ($exams as $exam):
            $k++;
            ?>
            <li class="list-group-item">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <?= $k ?>.
                        <a href="/UserExams/select/<?= base64_encode($exam->id) ?>" title="<?= $exam->name ?>" class="">
                            <?= $exam->name ?>
                        </a>
                    </div>
                    <div class="text-muted">
                        <?= $exam->time ?> mins
                    </div>

                </div>
            </li>

        <?php
        endforeach;

        if (empty($exams->toArray())) {
            ?>
            <li class="list-group-item">No exams found.</li>
            <?php
        }
        ?>


</div>
