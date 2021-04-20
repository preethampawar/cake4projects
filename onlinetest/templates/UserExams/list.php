<?php
if ($this->request->getSession()->check('User.isAdmin')
    && $this->request->getSession()->read('User.isAdmin') == true) {
    ?>
    <div class="text-center">
        <h1>Welcome Admin</h1>
    </div>
    <?php
    return;
} else {
    $this->assign('showSocialShare', true);
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
        <img src="/img/learning.jpg" class="w-100 d-block mb-4" alt="..." style="max-height: 400px">
        <?php
    }
    ?>
    <h5 class="card-title">Free online tests to practice for competitive and entrance exams.</h5>
</div>

<div class="mt-3">

    <div class="">



        <div class="mb-3 row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5  g-2 pt-1">
            <!--            <p class="card-text"> Prepare for your exam online with our many free
                            tests.</p>-->
            <?php
            if ($categoryList) {
                if ($selectedCategoryId != null) {
                    ?>
                    <div class="col">
                        <div class="card h-100 bg-ivory" role="button">
                            <div class="card-body" onclick="window.location = '/UserExams/list/'">
                                <div class="text-center ">
                                    <i class="fas fa-stream"></i> Show All
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
                ?>

                <?php
                foreach($categoryList as $categoryId => $categoryName) {
                    $btnClass = 'btn btn-orange btn-sm';
                    $bgClass = 'bg-orange text-white';

                    if ($selectedCategoryId && $selectedCategoryId == $categoryId) {
                        $btnClass = 'btn btn-primary btn-sm';
                        $bgClass = 'bg-primary text-white';
                    }
                    ?>
                    <div class="col">
                        <div class="card h-100 <?=$bgClass?>" role="button">
                            <div class="card-body" onclick="window.location = '/UserExams/list/<?= $categoryId ?>/<?= $categoryName ?>'">
                                <div class="text-center">

                                    <i class="fas fa-university"></i> <?= $categoryName ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>

        <div class="px-2 py-2 mb-1 rounded bg-purple">
            <!-- <div class="fs-5"><span class="badge rounded rounded-circle bg-orange"><?php echo count($exams) ?></span> Tests </div> -->
            <div class="fs-5">
                <span class="badge rounded rounded-circle bg-orange"><?php echo count($exams) ?></span>
                Free Practice Tests
            </div>
        </div>

        <?php
        $k = 0;
        $examNames = [];
        foreach ($exams as $exam):
            $k++;

            $fullUrl = $this->Url->build("/UserExams/select/" . base64_encode($exam->id), [
                'escape' => false,
                'fullBase' => true,
            ]);
            $fullUrl = urlencode($fullUrl);
            $title = urlencode($exam->name);
            $examNames[] = $exam->name;
            ?>
            <div class="bg-light p-2 mb-3 rounded">
                <div class="d-flex justify-content-between">

                    <div class="d-flex">
                        <span class="text-muted"><?= $k ?>.</span>
                        <div class="ms-1">
                            <a href="/UserExams/select/<?= base64_encode($exam->id) ?>" title="<?= $exam->name ?>"
                               class="ms-0 text-primary">
                                <b><?= $exam->name ?></b>
                            </a>
                            <br>
                            <span class="text-muted small">
                                <?= count($exam->exam_questions) ?> questions,

                                <?= $exam->time ?> mins
                            </span>

                        </div>
                    </div>
                    <div class="ms-1 text-end w-25">

                            <a href="/UserExams/select/<?= base64_encode($exam->id) ?>" title="<?= $exam->name ?>"
                               class="btn btn-primary btn-sm mb-1" title="Start Test">
                                <i class="fas fa-play-circle"></i><span class="d-none d-sm-inline"> Start Test</span>
                            </a>

                            <span
                                title="Share Test <?= $exam->name ?>"
                                class="btn btn-success btn-sm ms-2 mb-1"
                                role="button"
                                onclick="social.shareDialog('modalExam<?= $exam->id ?>', '<?= $fullUrl ?>', '<?= $title ?>')">
                                <i class="fas fa-share"></i><span class="d-none d-md-inline"> Share</span>
                            </span>

                    </div>

                </div>

                <div class="mt-1 mb-0">
                    <?php
                    if ($categoryList && $exam->exam_categories) {
                        foreach($exam->exam_categories as $examCategory) {
                            $categoryName = $categoryList[$examCategory->category_id];
                            $btnClass = 'btn-orange';

                            if ($selectedCategoryId && $selectedCategoryId == $examCategory->category_id) {
                                $btnClass = 'btn-primary';
                            }
                            ?>
                            <a
                                href="/UserExams/list/<?= $examCategory->category_id ?>/<?= $categoryName ?>"
                                class="btn <?= $btnClass ?> btn-sm py-0 me-1 mt-1"
                            >
                                <i class="fas fa-university"></i> <?= $categoryName ?>
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
                                            <div>
                                                <button type="button" class="btn btn-md btn-orange py-0" onclick="copy.text('#copyExamLink<?= $exam->id ?>')">
                                                    <i class="fas fa-copy"></i> Copy
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="text-center mt-3">
                                    <a
                                        href="#"
                                        class="btn btn-success btn-md w-50 mt-3"
                                        onclick="social.share('whatsapp', '<?= $fullUrl ?>', '<?= $title ?>')">
                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                    </a>
                                    <a
                                        href="#"
                                        class="btn btn-primary btn-md w-50 mt-3"
                                        onclick="social.share('facebook', '<?= $fullUrl ?>', '<?= $title ?>')">
                                        <i class="fab fa-facebook-f"></i> Facebook
                                    </a>
                                    <a
                                        href="#"
                                        class="btn btn-info btn-md w-50 mt-3"
                                        onclick="social.share('twitter', '<?= $fullUrl ?>', '<?= $title ?>')">
                                        <i class="fab fa-twitter"></i> Twitter
                                    </a>
                                    <a
                                        href="#"
                                        class="btn btn-orange btn-md w-50 mt-3"
                                        onclick="social.share('email', '<?= $fullUrl ?>', '<?= $title ?>')">
                                        <i class="far fa-envelope"></i> Email
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

        <?php
        $this->Html->meta(
            'keywords',
            'online tests, '. implode(',', $examNames),
            ['block' => true]
        );
        $this->Html->meta(
            'description',
            'Free online tests. '. implode(',', $examNames),
            ['block' => true]
        );
        ?>


</div>
