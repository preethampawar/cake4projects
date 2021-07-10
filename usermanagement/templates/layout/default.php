<?php

use Cake\Core\Configure;

$loggedIn = $this->getRequest()->getSession()->check('User.id');
$isAdmin = (bool) $this->getRequest()->getSession()->read('User.isAdmin');
$loggedInUser = $this->getRequest()->getSession()->read('User');
$controller = $this->request->getParam('controller');
$action = $this->request->getParam('action');
$loginLinkActive = null;
$registerLinkActive = null;
$homeLinkActive = null;
$userDetailsLinkActive = null;

switch($controller) {
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
?>
<!doctype html>
<html lang="en">
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $this->fetch('title') ?></title>
        <link rel="shortcut icon" type="image/png" href="/img/user-group-16x16.png" />

        <?php echo $this->fetch('meta') ?>

        <link href="/vendor/bootstrap-5.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="/vendor/fontawesome-free-5.15.3-web/css/all.min.css" rel="stylesheet">
        <link href="/css/site.css?v=1.0.2" rel="stylesheet">

        <script src="/vendor/jquery/jquery-3.6.0.min.js"></script>
        <script src="/js/common.js?v=1.0.0"></script>

    </head>
    <body>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-print-none bg-gradient p-0 border-bottom border-4 border-warning">
            <div class="container-fluid">
                <a class="navbar-brand me-3 text-warning" href="/">
                    <span class="fs-1"><i class="fa fa-user-circle"></i></span>
                </a>

                <div class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fa fa-bars fs-4"></span>
                </div>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <?php
                        if ($loggedIn) {
                            ?>
                            <a class="nav-link <?= $homeLinkActive?> px-2 me-1 my-1" href="/"><i class="fa fa-home"></i> Home</a>
                            <a class="nav-link px-2 me-1 my-1" href="/Users/registeredApps">My Apps</a>
                            <a class="nav-link px-2 me-1 my-1" href="/Users/myProfile">My Profile</a>
                            <a class="nav-link px-2 me-1 my-1" href="/Users/updateProfile">Update Profile</a>
                            <a class="nav-link px-2 me-1 my-1" href="/Users/updatePassword">Change Password</a>
                            <a class="nav-link px-2 me-1 my-1 disabled" href="#"><i class="fa fa-user-circle"></i> <?= ucwords($loggedInUser['name']) ?></a>
                            <?php
                        } else {
                            ?>
                            <a class="nav-link <?= $loginLinkActive ?> px-2 me-1 my-1" href="/Users/login">Login</a>
                            <a class="nav-link <?= $registerLinkActive ?> px-2 my-1" href="/Users/register">Register</a>
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

        <?php
        if ($this->request->getSession()->check('appRequest.name') && $action != 'login') {
            $requestAppCode = $this->request->getSession()->read('appRequest.appCode');
            $apps = Configure::consume('Apps');
            $appUrl = '/';

            if (isset($apps[$requestAppCode])) {
                $appUrl = $apps[$requestAppCode]['url'];
            }
            ?>
            <nav class="navbar sticky-top navbar-light bg-ivory">
                <div class="container-fluid justify-content-center text-center">
                    <a class="navbar-brand p-1" href="<?= $appUrl ?>">
                        <span class="small"><span class="small"><span class="small">Switch App</span></span></span><br>
                        <?= $this->request->getSession()->read('appRequest.name') ?> <i class="fa fa-chevron-circle-right"></i>
                    </a>
                </div>
            </nav>
            <?php
        }
        ?>

        <main class="main">
            <div id="mainDiv" class="container-xl mb-5 mt-3 mt-xl-4 bg-white text-dark pt-2 pb-4 rounded">
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

            <!-- Connected Apps Menu -->
            <div class="offcanvas offcanvas-start" tabindex="-1" id="selectAppMenu" aria-labelledby="offcanvasTopLabel">
                <div class="offcanvas-header border-bottom border-4 border-warning">
                    <h5 id="offcanvasTopLabel">Select App</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body" id="selectAppMenuBody">
                    <?php echo $this->element('apps_select_menu'); ?>
                </div>
            </div>
        </main>

        <script src="/vendor/bootstrap-5.0.0-dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
