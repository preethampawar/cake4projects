<?php
$loggedIn = $this->getRequest()->getSession()->check('User.id');
$isAdmin = (bool) $this->getRequest()->getSession()->read('User.isAdmin');
$loggedInUser = $this->getRequest()->getSession()->read('User');
$controller = $this->request->getParam('controller');
$action = $this->request->getParam('action');
$batchesLinkActive = null;
$activitiesLinkActive = null;
$examsLinkActive = null;
$loginLinkActive = null;
$registerLinkActive = null;
$homeLinkActive = null;
$userDetailsLinkActive = null;
$batchesDashboardLinkActive = null;
$communityDashboardLinkActive = null;
$transactionsLinkActive = null;
$reportsLinkActive = null;


switch($controller) {
    case 'Batches':
        if ($action == 'dashboard') {
            $batchesDashboardLinkActive = 'active';
        } elseif ($action == 'communityDashboard') {
            $communityDashboardLinkActive = 'active';
        } else {
            $batchesLinkActive = 'active';
        }

        break;
    case 'Activities':
        $activitiesLinkActive = 'active';
        break;
    case 'Transactions':
        if ($action == 'financeReport') {
            $reportsLinkActive = 'active';
        } else {
            $transactionsLinkActive = 'active';
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
?>
<!doctype html>
<html lang="en">
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $this->fetch('title') ?></title>
        <link rel="shortcut icon" type="image/png" href="/img/silkworm.png" />

        <?php echo $this->fetch('meta') ?>

        <link href="/vendor/bootstrap-5.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="/vendor/fontawesome-free-5.15.3-web/css/all.min.css" rel="stylesheet">
        <link href="/vendor/select2-4.1/select2.min.css" rel="stylesheet">
        <link href="/css/site.css?v=1.0.2" rel="stylesheet">

        <script src="/vendor/jquery/jquery-3.6.0.min.js"></script>
        <script src="/js/common.js?v=1.0.1"></script>
        <script src="/vendor/select2-4.1/select2.min.js"></script>

    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-print-none bg-gradient p-0">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    <span class=""><img src="/img/2_silkworm_transparent.png" height="42" width="56" alt=""></span>
                </a>
                <a class="navbar-brand d-block d-md-none" href="/">
                    <span>Seri Tracker</span>
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
                            <a class="nav-link <?= $batchesDashboardLinkActive?> px-2 me-1 my-1" href="/Batches/dashboard"><i class="fa fa-home"></i> Home</a>
                            <a class="nav-link <?= $batchesLinkActive?> px-2 me-1 my-1" href="/Batches"><i class="fa fa-life-ring"></i> Batches</a>
                            <a class="nav-link <?= $activitiesLinkActive?> px-2 me-1 my-1" href="/Activities"><i class="fa fa-tasks"></i> Activities</a>
                            <a class="nav-link <?= $transactionsLinkActive?> px-2 me-1 my-1" href="/Transactions"><i class="fa fa-rupee-sign"></i> Finance</a>
                            <a class="nav-link <?= $communityDashboardLinkActive?> px-2 me-1 my-1" href="/Batches/communityDashboard"><i class="fa fa-users"></i> Community Updates</a>

                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle <?=$reportsLinkActive?> px-2 me-1 my-1" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-chart-pie"></i> Reports
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="reportsDropdown">
                                    <li><a class="dropdown-item" href="/Transactions/financeReport">Finance Report</a></li>
                                </ul>
                            </div>

                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle <?=$userDetailsLinkActive?> px-2 me-1 my-1" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-user-circle"></i> <?= ucwords($loggedInUser['name']) ?>
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
                            <a class="nav-link <?= $communityDashboardLinkActive?> px-2 me-1 my-1" href="/Batches/communityDashboard"><i class="fa fa-users"></i> Community Updates</a>
                            <a class="nav-link px-2 me-1 my-1" href="//expenses.simpleaccounting.in">Manage Finances</a>
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

            <!-- Select Transaction Menu -->
            <div class="offcanvas offcanvas-start" tabindex="-1" id="selectTransactionMenu" aria-labelledby="offcanvasTopLabel">
                <div class="offcanvas-header border-bottom border-4 border-warning">
                    <h5 id="offcanvasTopLabel">Select Transaction Type</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body" id="selectTransactionMenuBody">
                    <?php echo $this->element('transaction_select_menu'); ?>
                </div>
            </div>
        </main>

        <script src="/vendor/bootstrap-5.0.0-dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>


<script>
    $(document).ready(function () {
        $('.select2dropdown').select2({
            placeholder: '-',
        });
    });
</script>
