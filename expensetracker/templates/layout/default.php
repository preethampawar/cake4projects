<?php
$loggedIn = $this->getRequest()->getSession()->check('User.id');
$selectedBatch = $this->getRequest()->getSession()->check('Batch.id') ? $this->getRequest()->getSession()->read('Batch') : null;
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
        } elseif ($action == 'selectBatch') {
            $homeLinkActive = 'active';
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
        <link rel="shortcut icon" type="image/png" href="/img/rupee-sym.png" />

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

        <nav class="navbar navbar-expand-lg navbar-light bg-light d-print-none bg-gradient p-0 border-bottom border-4 border-warning">
            <div class="container-fluid">
                <a class="navbar-brand me-0" href="/Batches/selectBatch">
                    <span class=""><img src="/img/rupee-sym.png" height="42" width="42" alt=""></span>
                </a>
                <a class="navbar-brand d-block d-md-none" href="/Batches/selectBatch">
                    <span>Expense Tracker</span>
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

                            <?php
                            if (!$selectedBatch) {
                                ?>
                                <a class="nav-link <?= $batchesLinkActive?> px-2 me-1 my-1" href="/Batches"><i class="fa fa-hand-holding-usd"></i> Manage Accounts</a>
                                <?php
                            }
                            ?>

                            <?php
                            if ($selectedBatch) {
                                ?>
                                <a class="nav-link <?= $transactionsLinkActive?> px-2 me-1 my-1" href="/Transactions"><i class="fa fa-rupee-sign"></i> Transactions</a>

                                <div class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle <?=$reportsLinkActive?> px-2 me-1 my-1" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-chart-pie"></i> Reports
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="reportsDropdown">
                                        <li><a class="dropdown-item" href="/Transactions/financeReport">Transactions Report</a></li>
                                    </ul>
                                </div>
                                <?php
                            }
                            ?>

                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle <?=$userDetailsLinkActive?> px-2 me-1 my-1" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-user-circle"></i> <?= ucwords($loggedInUser['name']) ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="/Users/profile/myProfile">My Profile</a></li>
                                    <li><a class="dropdown-item" href="/Users/profile/updateProfile">Update Profile</a></li>
                                    <li><a class="dropdown-item" href="/Users/profile/updatePassword">Change Password</a></li>
                                    <li><a class="dropdown-item" href="/Users/appRequestLogout">Logout</a></li>
                                </ul>
                            </div>
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
        if ($selectedBatch) {
            ?>
            <nav class="navbar navbar-expand-lg navbar-dark bg-purple">
                <div class="container-fluid">
                    <a class="navbar-brand fs-6 py-0" href="/"><i class="fa fa-home"></i> <?= $selectedBatch['name'] ?> <?= !$selectedBatch['active'] ? '<span class="fst-italic small text-warning"> - closed*</span>' : null ?> </a>
                    <a class="btn btn-sm btn-outline-light small py-0" href="/Batches/selectBatch">Switch Account <i class="fa fa-chevron-circle-right"></i></a>
                </div>
            </nav>
            <?php
        }
        ?>

        <main class="main">
            <div id="mainDiv" class="container-xl mb-5 mt-3 mt-xl-4 bg-white text-dark pt-2 pb-4 rounded">
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
