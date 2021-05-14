<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            My Clinic:
            <?= $this->fetch('title') ?>
        </title>

        <link rel="shortcut icon" type="image/png" href="/img/clinic-icon-5.jpg" />
        <?php echo $this->fetch('meta') ?>

        <link href="/vendor/bootstrap-5.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/site.css" rel="stylesheet">
        <link href="/vendor/fontawesome-free-5.15.3-web/css/all.min.css" rel="stylesheet">
        <script src="/vendor/jquery/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-purple">
            <div class="container-fluid">
                <a class="navbar-brand" href="/"><i class="fa fa-plus-circle"></i> SPSA Clinic</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <?php
                        $controller = $this->getRequest()->getParam('controller');
                        $action = $this->getRequest()->getParam('action');

                        $homeLinkActive = null;
                        $billingsLinkActive = null;
                        $billingsReportLinkActive = null;
                        $patientsLinkActive = null;
                        $patientsSearchLinkActive = null;
                        $patientsLoginLinkActive = null;

                        switch ($controller) {
                            case 'Billings':
                                if ($action == 'index') {
                                    $billingsLinkActive = 'active';
                                }
                                if ($action == 'report') {
                                    $billingsReportLinkActive = 'active';
                                }
                                break;
                            case 'Patients':
                                if ($action == 'index') {
                                    $patientsLinkActive = 'active';
                                }
                                if ($action == 'search') {
                                    $patientsSearchLinkActive = 'active';
                                }
                                if ($action == 'login') {
                                    $patientsLoginLinkActive = 'active';
                                }
                                break;
                            default:
                                $homeLinkActive = 'active';
                                break;
                        }

                        if ($this->getRequest()->getSession()->read('loggedIn') === true) {
                            ?>
                            <a class="nav-link px-1 me-1 <?= $homeLinkActive ?>" aria-current="page" href="/">Home</a>
                            <a class="nav-link px-1 me-1 <?= $patientsLinkActive ?>" href="/patients">Patients</a>
                            <a class="nav-link px-1 me-1 <?= $billingsLinkActive ?>" href="/billings">Billing</a>
                            <a class="nav-link px-1 me-1 <?= $billingsReportLinkActive ?>" href="/billings/report">Billing Report</a>
                            <a class="nav-link px-1 me-1 <?= $patientsSearchLinkActive ?>" href="/patients/search">Search</a>
                            <a class="nav-link px-1 me-1 " href="/patients/logout">Logout</a>
                            <?php
                        } else {
                            ?>
                            <a class="nav-link px-1 me-1 <?= $patientsLoginLinkActive ?>" href="/patients/login">Login</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </nav>

        <main class="main">
            <div class="container-fluid py-4">
                <?php
                $message = $this->Flash->render();

                if ($message) {
                    ?>

                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <?= $message ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php
                }
                ?>

                <?= $this->fetch('content') ?>
            </div>
        </main>

        <footer>
        </footer>

        <script src="/vendor/bootstrap-5.0.0-dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
