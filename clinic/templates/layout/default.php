<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            My Clinic:
            <?= $this->fetch('title') ?>
        </title>
        <?= $this->Html->meta('icon') ?>

        <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">


        <?php // $this->Html->css(['normalize.min', 'milligram.min', 'cake']) ?>

        <?php echo $this->fetch('meta') ?>
        <?php // echo $this->fetch('css') ?>
        <?php // echo $this->fetch('script') ?>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">SPSA Clinic</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <?php
                        if ($this->getRequest()->getSession()->read('loggedIn') === true) {
                            ?>
                            <a class="nav-link active" aria-current="page" href="/">Home</a>
                            <a class="nav-link" href="/patients">Patients</a>
                            <a class="nav-link" href="/billings">Billing</a>
<!--                            <a class="nav-link" href="/billings/report">Billing Report</a>-->
                            <a class="nav-link" href="/patients/search">Search</a>
                            <a class="nav-link" href="/patients/logout">Logout</a>
                            <?php
                        } else {
                            ?>
                            <a class="nav-link" href="/patients/login">Login</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </nav>

        <main class="main">
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

        <footer>
        </footer>

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
                crossorigin="anonymous"></script>
    </body>
</html>
