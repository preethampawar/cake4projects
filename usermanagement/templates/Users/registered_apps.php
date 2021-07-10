<h1>My Apps</h1>

<?php
if (!empty($apps)) {
    ?>
    <div class="border mt-3 p-1 rounded">
        <div class="list-group list-group-flush">
            <?php
            foreach ($apps as $appCode => $app):
                ?>
                <div class="list-group-item px-0 py-1">
                    <a
                        href="/Users/redirectToApp/<?= $appCode ?>"
                        title="Select <?= $app['name'] ?>"
                        id="App-<?= $appCode ?>"
                        class="nav-link d-flex justify-content-between link-primary fs-5">

                        <?= $app['name'] ?>

                        <i class="fa fa-chevron-right mt-1"></i>
                    </a>
                </div>
            <?php
            endforeach;
            ?>
        </div>
    </div>
    <?php
}
?>
