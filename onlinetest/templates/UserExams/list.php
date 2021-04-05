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

<?php
$categoryList = null;
foreach($categories as $category) {
    $categoryList[$category->id] = (string)$category->name;
}
?>

<?= $this->request->getSession()->check('User.id') ? $this->element('myTestsNav') : null; ?>

<div class="mt-3 text-muted alert bg-aliceblue shadow border">
    Free online tests to practice for competitive and entrance exams. Prepare for your exam online with our many free
    tests.

    <div class="mt-3">
        <?php
        if ($categoryList) {
            if ($selectedCategoryId != null) {
                ?>
                <a
                    href="/UserExams/list/"
                    class="btn btn-sm border py-0 me-1 mt-1 btn-ivory"
                >Show All</a>
                <?php
            }
            ?>

            <?php
            foreach($categoryList as $categoryId => $categoryName) {
                $btnClass = 'btn-ivory';

                if ($selectedCategoryId && $selectedCategoryId == $categoryId) {
                    $btnClass = 'btn-orange';
                }
                ?>
                <a
                    href="/UserExams/list/<?= $categoryId ?>/<?= $categoryName ?>"
                    class="btn btn-sm border py-0 me-1 mt-1 <?= $btnClass ?>"
                >
                    <?= $categoryName ?>
                </a>
                <?php
            }
        }
        ?>
    </div>
</div>


<div class="alert shadow mt-3 border">
    <ul class="list-group list-group-flush">
        <li class="list-group-item px-0">
            <h5>Total <?php echo count($exams) ?> test(s)</h5>
        </li>
        <?php
        $k = 0;
        foreach ($exams as $exam):
            $k++;

            $fullUrl = $this->Url->build("/UserExams/select/" . base64_encode($exam->id), [
                'escape' => false,
                'fullBase' => true,
            ]);
            $fullUrl = urlencode($fullUrl);
            $title = urlencode($exam->name);
            ?>
            <li class="list-group-item px-0">
                <div class="d-flex justify-content-between">
                    <div class="d-flex">
                        <span><?= $k ?>. </span>
                        <div class="">
                            <a href="/UserExams/select/<?= base64_encode($exam->id) ?>" title="<?= $exam->name ?>"
                               class="ms-1">
                                <?= $exam->name ?>
                            </a>


                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <div class="text-muted">
                        (<?= $exam->time ?> mins)
                    </div>

                    <div
                        title="Share Test <?= $exam->name ?>"
                        class="border border-secondary shadow px-2 py-0 rounded  bg-light small fw-bold text-secondary"
                        type="button"
                        onclick="social.shareDialog('modalExam<?= $exam->id ?>', '<?= $fullUrl ?>', '<?= $title ?>')">
                        Share
                        <img
                            src="/img/share2.png"
                            style="width: 15px;"
                            class=""
                            type="button"
                        >
                    </div>
                </div>
                <div class="mb-3">
                    <?php
                    if ($categoryList && $exam->exam_categories) {
                        foreach($exam->exam_categories as $examCategory) {
                            $categoryName = $categoryList[$examCategory->category_id];
                            ?>
                            <a
                                href="/UserExams/list/<?= $examCategory->category_id ?>/<?= $categoryName ?>"
                                class="btn btn-ivory btn-sm border py-0 me-1 mt-1"
                            >
                                <?= $categoryName ?>
                            </a>
                            <?php
                        }
                    }
                    ?>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modalExam<?= $exam->id ?>" tabindex="-1" aria-labelledby="modalExam<?= $exam->id ?>Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalExam<?= $exam->id ?>Label">Share Online Test</h5>

                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center">
                                    <h5><?= $exam->name ?></h5>
                                    <hr>
                                </div>

                                <div class="text-center">
                                    <a
                                        href="#"
                                        class="btn btn-success btn-md w-50 mt-3"
                                        onclick="social.share('whatsapp', '<?= $fullUrl ?>', '<?= $title ?>')">
                                        WhatsApp
                                    </a>
                                    <a
                                        href="#"
                                        class="btn btn-primary btn-md w-50 mt-3"
                                        onclick="social.share('facebook', '<?= $fullUrl ?>', '<?= $title ?>')">
                                        Facebook
                                    </a>
                                    <a
                                        href="#"
                                        class="btn btn-info btn-md w-50 mt-3"
                                        onclick="social.share('twitter', '<?= $fullUrl ?>', '<?= $title ?>')">
                                        Twitter
                                    </a>
                                    <a
                                        href="#"
                                        class="btn btn-orange btn-md w-50 mt-3"
                                        onclick="social.share('email', '<?= $fullUrl ?>', '<?= $title ?>')">
                                        Email
                                    </a>
                                    <br><br>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
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
