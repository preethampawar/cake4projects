<?php
$loggedIn = $this->getRequest()->getSession()->check('User.id');
$isAdmin = (bool) $this->getRequest()->getSession()->read('User.isAdmin');
$loggedInUser = $this->getRequest()->getSession()->read('User');
$controller = $this->request->getParam('controller');
$action = $this->request->getParam('action');
$questionsLinkActive = null;
$examsLinkActive = null;
$homeLinkActive = null;
$userExamsLinkActive = null;

switch($controller) {
    case 'Questions':
        $questionsLinkActive = 'active';
        break;
    case 'Exams':
    case 'Categories':
    case 'ExamGroups':
        $examsLinkActive = 'active';
        break;
    case 'UserExams' && $action !== 'list':
        $userExamsLinkActive = 'active';
        break;
    default:
        $homeLinkActive = 'active';
}
?>
<!doctype html>
<html lang="en">
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>OnlineTest: <?= $this->fetch('title') ?></title>
        <link rel="shortcut icon" type="image/png" href="/img/edu2.png" />
        <?php echo $this->fetch('meta') ?>

        <link href="/vendor/bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/site.css" rel="stylesheet">
        <link href="/vendor/fontawesome-free-5.15.3-web/css/all.min.css" rel="stylesheet">
        <link href="/vendor/select2-4.1/select2.min.css" rel="stylesheet">

        <script src="/vendor/jquery/jquery-3.6.0.min.js"></script>
        <script src="/js/common.js?v=1.0"></script>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
        <script src="/vendor/mathjax/tex-mml-chtml.js"></script>
        <script src="/vendor/select2-4.1/select2.min.js"></script>
    </head>
    <body class="bg-dark">

        <nav class="navbar navbar-expand-md navbar-dark bg-purple-dark d-print-none bg-gradient">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    Online Tests Admin
                </a>

                <div class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fa fa-bars fs-5"></span>
                </div>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link <?= $homeLinkActive?> px-2 me-1" aria-current="page" href="/">Home</a>
                        <a class="nav-link <?= $questionsLinkActive?> px-2 me-1" href="/Questions">Question Bank</a>

                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?=$examsLinkActive?> px-2 me-1" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Tests
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/Exams/add">+ Add New Test</a></li>
                                <li><a class="dropdown-item" href="/Exams">Show All Tests</a></li>
                                <li><a class="dropdown-item" href="/Categories">Test Categories</a></li>
                                <li><a class="dropdown-item" href="/ExamGroups">Test Topics</a></li>
                            </ul>
                        </div>

                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?=$userExamsLinkActive?> px-2 me-1" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Candidates
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/UserExams/users">Show All Candidates</a></li>
                                <li><a class="dropdown-item" href="/UserExams/userAttendedExams">Results</a></li>
                            </ul>
                        </div>
                        <a class="nav-link disabled px-2 me-1" href="#" tabindex="-1" aria-disabled="true"><?= ucwords($loggedInUser['username']) ?></a>

                        <a class="nav-link px-2 me-1" href="/Users/logout">Logout</a>


                        <hr class="mb-2">
                        <div class="navbar-toggler border-0 text-center" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                             aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fa fa-chevron-up fs-4"></span>
                        </div>

                    </div>
                </div>
            </div>
        </nav>

        <main class="main">
            <div id="mainDiv" class="container-fluid mb-5 bg-white pt-2 pb-4 rounded  min-vh-100">
                <?= $this->Flash->render(); ?>

                <?= $this->fetch('content') ?>
            </div>

            <div class="modal fade" id="confirmPopup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModal"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="content">Are you sure?</div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="actionLink btn btn-danger btn-sm me-2 px-4"><span class="ok">Ok</span></a>
                            <button type="button" class="actionLinkButton btn btn-danger btn-sm me-2 px-4" data-bs-dismiss="modal"><span
                                    class="ok">Ok</span></button>
                            <button type="button" class="btn btn-outline-secondary btn-sm cancelButton" data-bs-dismiss="modal">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="alertPopup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModal"></h5>
                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <div class="content">...</div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="actionLink btn btn-danger btn-sm me-2 px-4"><span class="ok">Ok</span></a>
                            <button type="button" class="actionLinkButton btn btn-danger btn-sm px-4" data-bs-dismiss="modal"><span
                                    class="ok">Ok</span></button>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="d-print-none"></footer>
        </main>

        <script src="/vendor/bootstrap-5.0.0-beta3-dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
