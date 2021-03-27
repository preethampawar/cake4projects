<!doctype html>
<html lang="en">
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            OnlineTests:
            <?= $this->fetch('title') ?>
        </title>
        <?= $this->Html->meta('icon') ?>

        <link href="/css/site.css" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

        <?php // $this->Html->css(['normalize.min', 'milligram.min', 'cake']) ?>

        <?php echo $this->fetch('meta') ?>
        <?php // echo $this->fetch('css') ?>
        <?php // echo $this->fetch('script') ?>

        <style type="text/css">
            .disabledElement {
                pointer-events: none;
                opacity: 0.4;
            }
        </style>

        <!-- JS math parsers -->
        <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
        <script id="MathJax-script" async
                src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js">
        </script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="/js/common.js"></script>
        <script>
            var token = '<?= $this->request->getParam('_csrfToken') ?>';
        </script>
    </head>
    <body>
        <?php
        $loggedIn = $this->getRequest()->getSession()->check('User.id');
        $isAdmin = (bool) $this->getRequest()->getSession()->read('User.isAdmin');
        $loggedInUser = $this->getRequest()->getSession()->read('User');
        $controller = $this->request->getParam('controller');
        $questionsLinkActive = null;
        $examsLinkActive = null;
        $homeLinkActive = null;
        $userExamsLinkActive = null;

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
        ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-purple d-print-none">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Online Tests</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <?php
                        if ($loggedIn) {
                            ?>
                            <a class="nav-link <?= $homeLinkActive?>" aria-current="page" href="/">Home</a>

                            <?php
                            if($isAdmin) {
                                ?>
                                <a class="nav-link <?= $questionsLinkActive?>" href="/questions">Question Bank</a>
                                <a class="nav-link <?= $examsLinkActive?>" href="/exams">Exams</a>
                                <?php
                            } else {
                                ?>
                                <a class="nav-link <?= $userExamsLinkActive?>" href="/UserExams/">Exams</a>
                                <?php
                            }
                            ?>

                            <a class="nav-link" href="/users/logout">Logout</a>

                            <?php
                        } else {
                            ?>
                            <a class="nav-link" href="/users/login">Login</a>
                            <a class="nav-link" href="/users/register">Register</a>
                            <?php
                        }
                        ?>

                    </div>
                </div>
                <?php if ($loggedIn) { ?>
                <div>
                    <?= ucwords($loggedInUser['username']) ?>
                </div>
                <?php } ?>
            </div>
        </nav>

        <main class="main mb-5">
            <div class="container py-4">
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

        <footer class="d-print-none">
        </footer>

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    </body>
</html>
