<?php
$loggedIn = $this->getRequest()->getSession()->check('User.id');
$isAdmin = (bool) $this->getRequest()->getSession()->read('User.isAdmin');
$loggedInUser = $this->getRequest()->getSession()->read('User');
$controller = $this->request->getParam('controller');
$action = $this->request->getParam('action');
$questionsLinkActive = null;
$examsLinkActive = null;
$loginLinkActive = null;
$registerLinkActive = null;
$homeLinkActive = null;
$userExamsLinkActive = null;
$resultsLinkActive = null;
$userDetailsLinkActive = null;
$showSocialShare = $this->fetch('showSocialShare');

switch($controller) {
    case 'Questions':
        $questionsLinkActive = 'active';
        break;
    case 'Exams':
        $examsLinkActive = 'active';
        break;
    case 'UserExams':
        switch ($action) {
            case "list":
                $userExamsLinkActive = 'active';
                break;
            case "myTests":
            case "myResult":
                $resultsLinkActive = 'active';
                break;
            default:
                break;
        }
        break;
    case 'Users':
        if ($action == 'login') {
            $loginLinkActive = 'active';
        }
        if ($action == 'register') {
            $registerLinkActive = 'active';
        }
        if (in_array($action, ['myProfile', 'updateProfile', 'updatePassword'])) {
            $userDetailsLinkActive = 'active';
        }
        break;
    default:
        $homeLinkActive = 'active';
}

$navBarClass = 'd-block';
if ($this->request->getParam('controller') == 'UserExams' && $this->request->getParam('action') == 'startTest') {
    $navBarClass = 'd-none';
}

$showMathJaxScript = $showMathJaxScript ?? false;
$disableBrowserForward = false;

if ($this->request->getParam('controller') == 'UserExams'
    && ($this->request->getParam('action') == 'startTest' || $this->request->getParam('action') == 'myResult')
) {
    $disableBrowserForward = true;
}
?>
<!doctype html>
<html lang="en">
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $this->fetch('title') ?></title>
        <link rel="shortcut icon" type="image/png" href="/img/edu2.png" />

        <?php echo $this->fetch('meta') ?>

        <link href="/vendor/bootstrap-5.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/site.css" rel="stylesheet">
        <link href="/vendor/fontawesome-free-5.15.3-web/css/all.min.css" rel="stylesheet">

        <script src="/vendor/jquery/jquery-3.6.0.min.js"></script>
        <script src="/js/common.js?v=1.0.1"></script>

        <?php if ($showMathJaxScript): ?>
            <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
            <script src="/vendor/mathjax/tex-mml-chtml.js" async></script>
        <?php endif; ?>


    </head>
    <body class="bg-dark">
        <nav class="navbar navbar-expand-sm navbar-dark bg-purple-dark d-print-none bg-gradient <?= $navBarClass ?>">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    <i class="fa fa-book-open me-1"></i>Online Tests
                </a>

                <div class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fa fa-bars fs-5"></span>
                </div>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <?php
                        if ($loggedIn) {
                            ?>
                            <a class="nav-link <?= $userExamsLinkActive?> px-2 me-1" href="/UserExams/">Tests</a>
                            <a class="nav-link <?= $resultsLinkActive?> px-2 me-1" href="/UserExams/myTests">Results</a>

                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle <?=$userDetailsLinkActive?> px-2 me-1" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?= ucwords($loggedInUser['name']) ?> <i class="fa fa-user"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="/Users/myProfile">My Profile</a></li>
                                    <li><a class="dropdown-item" href="/Users/updateProfile">Update Profile</a></li>
                                    <li><a class="dropdown-item" href="/Users/updatePassword">Change Password</a></li>
                                    <li><a class="dropdown-item" href="/Users/logout">Logout</a></li>
                                </ul>
                            </div>
                            <?php
                        } else {
                            ?>
                            <a class="nav-link <?= $loginLinkActive ?> px-2 me-1" href="/Users/login">Login</a>
                            <a class="nav-link <?= $registerLinkActive ?> px-2" href="/Users/register">Register</a>
                            <?php
                        }
                        ?>
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
            <div id="mainDiv" class="container-xl mb-5 mt-xl-4 bg-white text-dark pt-2 pb-4 rounded">
<!--                <div class="d-flex justify-content-end bg-ivory-light rounded-top d-none">-->
<!--                    <div id="google_translate_element" class="d-flex"><b>Language Translator</b>&nbsp; </div>-->
<!--                </div>-->

                <?= $this->Flash->render(); ?>

                <?= $this->fetch('content') ?>
            </div>
            <footer class="d-print-none"></footer>

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
        </main>

        <?php
        if ($showSocialShare) {
            ?>
            <!-- inline share buttons - Go to www.addthis.com/dashboard to customize your tools -->
            <!-- <div class="addthis_inline_share_toolbox"></div><script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-60782f65edd7a313"></script> -->
            <!-- floating share buttons -->
            <!-- <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-60782f65edd7a313"></script>-->
            <?php
        }
        ?>

        <script src="/vendor/bootstrap-5.0.0-dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
