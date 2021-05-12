<?php

if ($isAdmin) {
    ?>

    <div class="">
        <h1>Welcome Admin</h1>
        <div class="mt-3">
            Use this platform to create Online Tests
        </div>
    </div>

    <?php
    return;
}

$this->assign('showSocialShare', true);
?>

<?php
$categoryList = null;
foreach($categories as $category) {
    $categoryList[$category->id] = (string)$category->name;
}

$topicList = null;
foreach($topics as $topic) {
    $topicList[$topic->id] = (string)$topic->name;
}
?>

<div class="mb-3">
    <?php
    if(!$this->request->getSession()->check('User.id')) {
        ?>
        <img id="heroImage" class="w-100 d-block mb-4" alt="" style="max-height: 400px" loading="lazy">
        <script>
            $(document).ready(function () {
                $('#heroImage').attr('src', '/img/learning.jpg');
            })
        </script>
        <?php
    }
    ?>
    <h5>Free online tests to practice for competitive and entrance exams.</h5>
</div>

<div class="mt-3">
    <div class="">
        <div class="mb-4 row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5  g-2 pt-1">
            <?php
            if ($categoryList) {
                if ($selectedCategoryId) {
                    ?>
                    <div class="col">
                        <div class="">
                            <a href="/UserExams/list" class="text-decoration-none">
                                <span class="btn btn-ivory border w-100 py-3 fs-5">
                                    <i class="fas fa-stream"></i> Show All
                                </span>
                            </a>
                        </div>

                        <!--
                        <div class="card h-100 bg-ivory" role="button">
                            <div class="card-body" onclick="window.location = '/UserExams/list/'">
                                <div class="text-center ">
                                    <i class="fas fa-stream"></i> Show All
                                </div>
                            </div>
                        </div>
                        -->
                    </div>
                    <?php
                }
                ?>

                <?php
                foreach($categoryList as $categoryId => $categoryName) {
                    $btnClass = 'btn btn-orange btn-sm';

                    if ($selectedCategoryId && $selectedCategoryId == $categoryId) {
                        $btnClass = 'btn btn-primary btn-sm';
                        $bgClass = 'bg-primary text-white';
                    }
                    ?>
                    <div class="col">

                        <div class="">
                            <a href="/UserExams/list/<?= $categoryId ?>" class="text-decoration-none">
                                <span class="<?= $btnClass ?> w-100 py-3 fs-5">
                                    <i class="fas fa-university"></i> <?= $categoryName ?>
                                </span>
                            </a>
                        </div>
                        <!--
                        <div class="card h-100  shadow-sm <?=$bgClass?>" role="button">
                            <div class="card-body" onclick="window.location = '/UserExams/list/<?= $categoryId ?>/<?= $categoryName ?>'">
                                <div class="text-center">

                                    <i class="fas fa-university"></i> <?= $categoryName ?>

                                </div>
                            </div>
                        </div>
                        -->
                    </div>
                    <?php
                }
            }
            ?>
        </div>

        <?php
        if ($selectedTopicId) {
            ?>
            <div class="bg-ivory p-2 rounded border mb-1">
                <b>Topic:</b> <span class="bg-ivory"><?= $topicList[$selectedTopicId] ?></span>
            </div>
            <?php
        }
        ?>

        <div class="row">
            <div class="col-sm-12 col-md-7 mb-3">
                <div class="px-2 py-2 mb-3 rounded bg-purple bg-gradient text-white">
                    <div class="fs-5">
                        <span class="badge rounded bg-orange"><?php echo count($exams) ?></span>
                        Practice Tests
                    </div>
                </div>



                <?php
                $k = 0;
                $examNames = [];
                $examCount = count($exams);
                foreach ($exams as $exam):
                    $k++;

                    $fullUrl = $this->Url->build("/UserExams/select/" . base64_encode($exam->id), [
                        'escape' => false,
                        'fullBase' => true,
                    ]);
                    // $fullUrl = urlencode($fullUrl);
        //            $title = urlencode($exam->name);
                    $title = $exam->name;
                    $examNames[] = $exam->name;
                    ?>
                    <div class="pb-2">
                        <div class="">
                            <div class="d-flex flex-grow-1">
                                <span class="fs-5 text-primary"><?= $k ?>.</span>
                                <div class="ms-1">
                                    <a href="/UserExams/select/<?= base64_encode($exam->id) ?>" title="<?= $exam->name ?>"
                                       class="fs-5 text-primary text-decoration-none">
                                        <?= $exam->name ?>
                                    </a>
                                    <br>
                                    <span class="small">
                                        <?= $exam->total_questions ?> questions,

                                        <?= $exam->time ?> mins
                                    </span>

                                    <div class="mt-2 text-left">
                                        <a href="/UserExams/select/<?= base64_encode($exam->id) ?>" title="<?= $exam->name ?>"
                                           class="btn btn-primary" title="Start Test">
                                            <i class="fas fa-play-circle"></i><span class=""> Start Test</span>
                                        </a>

                                        <span
                                            title="Share Test <?= $exam->name ?>"
                                            class="btn btn-success ms-3"
                                            role="button"
                                            onclick="social.shareDialog('modalExam<?= $exam->id ?>', '<?= $fullUrl ?>', '<?= $title ?>')">
                                            <i class="fas fa-share"></i><span class=""> Share</span>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="mt-3 mb-1">
                            <?php
                            if ($categoryList && $exam->exam_categories) {
                                foreach($exam->exam_categories as $examCategory) {
                                    $categoryName = $categoryList[$examCategory->category_id];
                                    $btnClass = 'btn-orange-light';

                                    if ($selectedCategoryId && $selectedCategoryId == $examCategory->category_id) {
                                        $btnClass = 'btn-primary-light';
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

                    <?= $examCount == $k ? null : '<hr>' ?>

                <?php
                endforeach;

                if (empty($exams->toArray())) {
                    ?>
                    <div class="">No exams found.</div>
                    <?php
                }
                ?>

            </div>
            <div class="col-sm-12 col-md-5 mb-3">
                <div class="px-2 py-2 mb-3 rounded bg-purple bg-gradient text-white">
                    <div class="fs-5">
                        <span class="badge rounded bg-orange"><?php echo count($topics) ?></span>
                        Topics
                    </div>
                </div>

                <div>
                    <div class="d-flex mb-2">
                        <div>1.&nbsp;</div>
                        <div>
                            <a href="/UserExams/list" class="text-decoration-none">
                                Show All
                            </a>
                        </div>
                    </div>
                    <?php
                    $k = 1;
                    foreach ($topics as $topic):
                        $k++;
                        $bgClass = null;

                        if ($selectedTopicId && $selectedTopicId == $topic->id) {
                            $bgClass = ' bg-ivory';
                        }
                    ?>

                        <div class="d-flex mb-2">
                            <div><?= $k?>.&nbsp;</div>
                            <div>
                                <a href="/UserExams/list/0/<?= $topic->id ?>" class="<?= $bgClass ?> text-decoration-none">
                                    <?= $topic->name ?>
                                </a>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>

            </div>
        </div>

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
