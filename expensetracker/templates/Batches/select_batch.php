<div class="text-center">
    <a href="/Batches"><i class="fa fa-hand-holding-usd"></i> Manage Accounts</a>
</div>


<div class="text-end mt-3">
    <a class="btn btn-orange btn-sm rounded-pill" href="/Batches/add"><i class="fa fa-plus-circle"></i> NEW ACCOUNT</a>
</div>

<?php
if (empty($batchInfo->toArray())) {
    ?>
    <div class="mb-4 mt-3">
        <p class="bg-light p-2 rounded">No accounts found.</p>
        <p class="px-2">Please create an Account to manage your expenses.</p>
        <p class="px-2">
            Examples for Account names:<br>
            <code>Agriculture, Bike, Car, Home, Mobile, Natasha, Robert, School, Shop, Tractor, etc.</code>
        </p>
    </div>
    <?php
}
?>

<?php
if (!empty($batchInfo->toArray())) {
?>
    <div class="border mt-3 p-1 rounded">
        <div class="p-2 bg-light rounded"><h5>Select Account</h5></div>
        <div class="list-group list-group-flush mt-2">
            <?php
            foreach ($batchInfo as $batch):
                $linkClass = 'link-primary';

                if($batch->active == 0) {
                    $linkClass = 'link-secondary';
                }
                ?>
                <div class="list-group-item px-0 py-1">
                    <a
                        href="/Batches/changeEntity/<?= $batch->id ?>"
                        title="Select <?= $batch->name ?>"
                        id="<?= $batch->id ?>"
                        class="nav-link d-flex justify-content-between <?= $linkClass  ?> fs-5">

                        <?= $batch->name ?>

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
