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

<div class="mb-3">
    <?php
    if(!$this->request->getSession()->check('User.id')) {
        ?>
        <img src="/img/learning.jpg" class="w-100 mb-4" alt="..." style="max-height: 500px">
        <?php
    }
    ?>

    <div class="">
        <h5 class="card-title">Free online tests to practice for competitive and entrance exams.</h5>

        <div class="mt-3">
            <p class="card-text"> Prepare for your exam online with our many free
                tests.</p>
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
</div>

<hr>
<div class="mt-3">
    <div class="">
        <div class="px-2 py-2 mb-3 rounded bg-purple">
            <div class="fs-5"><span class="badge rounded rounded-circle bg-orange"><?php echo count($exams) ?></span> Tests </div>
        </div>
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
            <div class="bg-light p-2 mb-3 rounded">
                <div class="d-flex justify-content-between">
                    <div class="d-flex">
                        <span class="text-muted"><?= $k ?>.</span>
                        <div class="">
                            <a href="/UserExams/select/<?= base64_encode($exam->id) ?>" title="<?= $exam->name ?>"
                               class="ms-1 fw-bold text-purple">
                                <?= $exam->name ?>
                            </a>
                        </div>
                    </div>
                    <div>
                    <div
                        title="Share Test <?= $exam->name ?>"
                        class="btn btn-orange btn-sm py-0"
                        type="button"
                        onclick="social.shareDialog('modalExam<?= $exam->id ?>', '<?= $fullUrl ?>', '<?= $title ?>')">
                        Share
                    </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-1 pt-1">
                    <span class="text-muted small">
                        <?= count($exam->exam_questions) ?> questions,

                        <?= $exam->time ?> mins
                    </span>

                </div>
                <div class="mb-0">
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
                                <div class="text-start">
                                    <h5><?= $exam->name ?></h5>
                                    <div>
                                        <div class="d-flex justify-content-center bg-aliceblue py-2 rounded shadow">
                                            <div class="me-2 text-underline text-primary">
                                                <input
                                                    type="text"
                                                    id="copyExamLink<?= $exam->id ?>"
                                                    value="<?= urldecode($fullUrl) ?>"
                                                    class="form-control form-control-sm">
                                            </div>
                                            <div><button type="button" class="btn btn-md btn-orange py-0" onclick="copy.text('#copyExamLink<?= $exam->id ?>')">Copy Link</button></div>
                                        </div>

                                    </div>
                                </div>

                                <div class="text-center mt-3">
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
                                    <br>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        <?php
        endforeach;

        if (empty($exams->toArray())) {
            ?>
            <li class="list-group-item">No exams found.</li>
            <?php
        }
        ?>


</div>
