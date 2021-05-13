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

<div class="mb-3 shadow rounded p-2">
    <?php
    if(!$this->request->getSession()->check('User.id')) {
        ?>
        <img id="heroImage" src="/img/learning.jpg" class="w-100 d-none d-md-block mb-4 img-fluid" alt="" style="max-height: 400px" height="490" width="1010" loading="lazy">
        <img id="heroImage" src="/img/learning-mobile.jpg" class="w-100 d-block d-md-none mb-4 img-fluid" alt="" style="max-height: 300px" height="300" width="610"  loading="lazy">
        <script>
            $(document).ready(function () {
                //$('#heroImage').attr('src', '/img/learning.jpg');
            })
        </script>
        <?php
    }
    ?>
    <div class="px-2">
        <h5>Free online tests to practice for competitive and entrance exams.</h5>
    </div>
</div>

<div class="mt-4">
    <div class="">
        <?php
        if ($selectedTopicId || $selectedCategoryId) {
        ?>
        <div class="mt-4">
            <div class="alert alert-info shadow">
                <div class="d-flex justify-content-between">
                    <div class="fw-bold">
                        <?php
                        if ($selectedTopicId) {
                        ?>
                            <div class="d-inline">
                                <span class="me-2 d-inline-block"><i class="fas fa-list-ul mt-2 me-1 small text-orange"></i>Test Series</span>

                                <span class="d-inline-block">
                                    <i class="fas fa-caret-right mt-2 me-1 small text-orange"></i><?= $topicList[$selectedTopicId] ?>
                                </span>
                            </div>
                        <?php
                        }
                        ?>

                        <?php
                        if ($selectedCategoryId) {
                        ?>
                            <div class="d-inline">
                                <span class="me-2 d-inline-block"><i class="fas fa-university mt-2 me-1 small text-orange"></i>Category</span>

                                <span class="d-inline-block">
                                    <i class="fas fa-caret-right mt-2 me-1 small text-orange"></i><?= $categoryList[$selectedCategoryId] ?>
                                </span>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="ms-1">
                        <a class="text-decoration-none text-orange" href="/UserExams/list"><i class="fa fa-times"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>

        <div class="row mt-4">
            <div class="col-sm-12 col-md-7 mb-4">
                <div class="shadow p-2 rounded">
                    <div class="px-2 py-2 rounded bg-purple bg-gradient text-white">
                        <div class="fs-5 d-flex justify-content-start">
                            <div class="me-1">
                                <span class="badge rounded bg-orange"><?php echo count($exams) ?></span>
                            </div>
                            Practice Tests
                        </div>
                    </div>
                    <div class="mt-3">
                        <?php
                        $k = 0;
                        $examNames = [];
                        $examCount = count($exams);
                        foreach ($exams as $exam):
                            $k++;
                            $title = $exam->name;
                            $examNames[] = $exam->name;

                            $fullUrl = $this->Url->build("/UserExams/select/" . base64_encode($exam->id), [
                                'escape' => false,
                                'fullBase' => true,
                            ]);

                            $lastMonth = date('Y-m-d',  strtotime('-1 month'));
                            $examDate = $exam->start_date->format('Y-m-d');
                            $recentTest = false;

                            if ($examDate > $lastMonth) {
                                $recentTest = true;
                            }
                            ?>

                            <div class="my-3 p-1 hoverHighlight rounded">
                                <div class="row">
                                    <div class="col-12 col-sm-7 col-md-6 mb-3">
                                        <div class="d-flex justify-content-start fs-5 text-primary">
                                            <span><?= $k ?>.</span>
                                            <span class="ms-1">
                                                <a href="/UserExams/select/<?= base64_encode($exam->id) ?>" title="<?= $exam->name ?>"
                                                   class="text-primary text-decoration-none">
                                                    <?= $exam->name ?>
                                                </a>
                                            </span>
                                            <?php
                                            if($recentTest) {
                                            ?>
                                            <div class="spinner-grow text-warning text-center ms-1" role="status" style="width: 0rem; height: 2rem;" title="New Test">
                                                <span class="text-orange small"><i class="fa fa-bahai"></i></span> <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="text-muted">
                                            <span class="d-inline-block">
                                                <i class="fa fa-question-circle"></i> <?= $exam->total_questions ?> questions,
                                            </span>
                                            <span class="d-inline-block">
                                                <i class="fa fa-clock"></i> <?= $exam->time ?> mins
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-5 col-md-6 mb-3">
                                        <div class="text-start text-sm-end">
                                            <a href="/UserExams/select/<?= base64_encode($exam->id) ?>" title="<?= $exam->name ?>"
                                               class="btn btn-primary btn-sm" title="Start Test">
                                                <i class="fas fa-play-circle"></i><span class=""> Start Test</span>
                                            </a>

                                            <span
                                                title="Share Test <?= $exam->name ?>"
                                                class="btn btn-success btn-sm ms-2"
                                                role="button"
                                                onclick="social.shareDialog('modalExam<?= $exam->id ?>', '<?= $fullUrl ?>', '<?= $title ?>')">
                                                <i class="fas fa-share"></i><span class=""> Share</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <?php
                                        if ($categoryList && $exam->exam_categories) {
                                            foreach($exam->exam_categories as $examCategory) {
                                                $categoryName = $categoryList[$examCategory->category_id];
                                                $btnClass = 'btn-orange-light';
                                                $bgClass = '';

                                                if ($selectedCategoryId && $selectedCategoryId == $examCategory->category_id) {
                                                    $btnClass = 'btn-primary-light';
                                                    $bgClass = ' bg-orange px-2';
                                                }
                                                $btnClass = '';
                                                ?>
                                                <a
                                                    href="/UserExams/list/<?= $examCategory->category_id ?>"
                                                    class="<?= $bgClass ?> py-0 me-1 mb-1 text-decoration-none text-orange small"
                                                >
                                                    <i class="fas fa-university"></i> <?= $categoryName ?>
                                                </a>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
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

                            <?= $k == count($exams) ? '' : '<div class="px-2"><hr class="m-0"></div>' ?>

                        <?php
                        endforeach;

                        if (empty($exams->toArray())) {
                            ?>
                            <div class="">No exams found.</div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-5 mb-4">

                <div class="shadow p-2 rounded">
                    <div class="px-2 py-2 mb-2 rounded bg-purple bg-gradient text-white">
                        <div class="fs-5">
                            <span class="badge rounded bg-orange"><?php echo count($categoryList) ?></span>
                            Test Category
                        </div>
                    </div>

                    <div>
                        <?php
                        if ($categoryList) {
                            $k = 0;
                            foreach($categoryList as $categoryId => $categoryName) {
                                $k++;
                                $bgClass = null;

                                if ($selectedCategoryId && $selectedCategoryId == $categoryId) {
                                    $bgClass = 'bg-ivory rounded';
                                }
                                ?>
                                <div class="<?= $bgClass ?> px-2 py-2 my-1 hoverHighlight">
                                    <a href="/UserExams/list/<?= $categoryId ?>" class="text-decoration-none">
                                        <div class="d-flex justify-content-between">
                                            <span class="d-flex">
                                                <i class="fas fa-university mt-1 me-1"></i>
                                                <span><?= $categoryName ?></span>
                                            </span>
                                            <span>
                                                <i class="fa fa-chevron-right"></i>
                                            </span>
                                        </div>
                                    </a>
                                </div>

                                <?= $k == count($categoryList) ? '' : '<div class="px-2"><hr class="m-0"></div>' ?>

                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="shadow p-2 rounded mt-4">
                        <div class="px-2 py-2 mb-2 rounded bg-purple bg-gradient text-white">
                            <div class="fs-5">
                                <span class="badge rounded bg-orange"><?php echo count($topics) ?></span>
                                Test Series
                            </div>
                        </div>

                        <div>

                            <?php
                            $k = 0;
                            foreach ($topics as $topic):
                                $k++;
                                $bgClass = null;

                                if ($selectedTopicId && $selectedTopicId == $topic->id) {
                                    $bgClass = 'bg-ivory rounded';
                                }
                                ?>

                                <div class="<?= $bgClass ?> px-2 py-2 my-1 hoverHighlight">
                                    <a href="/UserExams/list/0/<?= $topic->id ?>" class="text-decoration-none">
                                        <div class="d-flex justify-content-between">
                                            <span class="d-flex">
                                                <i class="fas fa-list-ul mt-1 me-1"></i>
                                                <span><?= $topic->name ?></span>
                                            </span>
                                            <span>
                                                <i class="fa fa-chevron-right"></i>
                                            </span>
                                        </div>
                                    </a>
                                </div>

                                <?= $k == count($topics) ? '' : '<div class="px-2"><hr class="m-0"></div>' ?>
                            <?php
                            endforeach;
                            ?>
                        </div>

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
