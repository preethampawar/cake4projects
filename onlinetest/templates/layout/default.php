<!doctype html>
<html lang="en">
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>OnlineTest: <?= $this->fetch('title') ?></title>

        <link rel="shortcut icon" type="image/png" href="/images.png" />

        <?php
        //echo $this->Html->meta('icon')
        ?>
        <?php echo $this->fetch('meta') ?>
        <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <link href="/css/site.css" rel="stylesheet">

        <!-- JS math parsers -->
        <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
        <script id="MathJax-script" async
                src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js">
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="/js/common.js"></script>


        <?php
        if ($this->request->getParam('controller') == 'UserExams'
            && ($this->request->getParam('action') == 'startTest' || $this->request->getParam('action') == 'myResult')
        ) {
            ?>
            <script>
                window.history.forward();
            </script>
            <?php
        }
        ?>

    </head>
    <body class="bg-dark">
        <?php
        $loggedIn = $this->getRequest()->getSession()->check('User.id');
        $isAdmin = (bool) $this->getRequest()->getSession()->read('User.isAdmin');
        $loggedInUser = $this->getRequest()->getSession()->read('User');
        $controller = $this->request->getParam('controller');
        $questionsLinkActive = null;
        $examsLinkActive = null;
        $homeLinkActive = null;
        $userExamsLinkActive = null;
        $showSocialShare = $this->fetch('showSocialShare');

        switch($controller) {
            case 'Questions':
                $questionsLinkActive = 'active';
                break;
            case 'Exams':
                $examsLinkActive = 'active';
                break;
            case 'UserExams':
                $userExamsLinkActive = 'active';
                break;
            default:
                $homeLinkActive = 'active';
        }

        $navBarClass = 'd-block';
        if ($this->request->getParam('controller') == 'UserExams' && $this->request->getParam('action') == 'startTest') {
            $navBarClass = 'd-none';
        }
        ?>
        <nav class="navbar navbar-expand-sm navbar-dark bg-purple d-print-none bg-gradient <?= $navBarClass ?>">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Online Tests</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link <?= $homeLinkActive?>" aria-current="page" href="/">Home</a>
                        <?php
                        if ($loggedIn) {
                            ?>

                            <?php
                            if($isAdmin) {
                                ?>
                                <a class="nav-link <?= $questionsLinkActive?>" href="/Questions">Question Bank</a>
                                <a class="nav-link <?= $examsLinkActive?>" href="/Exams">Exams</a>
                                <a class="nav-link <?= $examsLinkActive?>" href="/Categories">Categories</a>
                                <a class="nav-link <?= $examsLinkActive?>" href="/UserExams/users">Users</a>
                                <?php
                            } else {
                                ?>
                                <a class="nav-link <?= $userExamsLinkActive?>" href="/UserExams/">Online Exams</a>
                                <?php
                            }
                            ?>

                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><?= ucwords($loggedInUser['username']) ?></a>

                            <a class="nav-link" href="/Users/logout">Logout</a>

                            <?php
                        } else {
                            ?>
                            <a class="nav-link" href="/Users/login">Login</a>
                            <a class="nav-link" href="/Users/register">Register</a>
                            <?php
                        }
                        ?>

                    </div>
                </div>
            </div>
        </nav>

        <main class="main">
            <div id="mainDiv" class="container mb-md-5 mt-md-3 bg-white pt-3 pb-3 rounded">
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
            <footer class="d-print-none"></footer>
        </main>

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
                    <div class="modal-footer mt-2 p-1">
                        <a href="#" class="actionLink btn btn-danger btn-sm me-2"><span class="ok">Ok</span></a>
                        <button type="button" class="actionLinkButton btn btn-danger btn-sm me-2" data-bs-dismiss="modal"><span
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
                    <div class="modal-footer mt-2 p-1">
                        <a href="#" class="actionLink btn btn-danger btn-sm me-2"><span class="ok">Ok</span></a>
                        <button type="button" class="actionLinkButton btn btn-danger btn-sm" data-bs-dismiss="modal"><span
                                class="ok">Ok</span></button>
                    </div>
                </div>
            </div>
        </div>



        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

        <?php
        if ($showSocialShare) {
            ?>
            <!-- inline share buttons - Go to www.addthis.com/dashboard to customize your tools -->
            <!-- <div class="addthis_inline_share_toolbox"></div><script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-60782f65edd7a313"></script> -->
            <!-- floating share buttons -->
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-60782f65edd7a313"></script>
            <?php
        }
        ?>
    </body>
</html>
