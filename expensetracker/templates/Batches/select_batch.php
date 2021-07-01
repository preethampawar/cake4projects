<div class="text-end">
    <a class="btn btn-orange btn-sm rounded-pill" href="/Batches/add"><i class="fa fa-plus-circle"></i> NEW ENTITY</a>
</div>

<?php
if (empty($batchInfo->toArray())) {
    ?>
    <div class="mb-4 mt-3">
        <p class="bg-light p-2 rounded">No entitites found.</p>
        <p class="px-2">Please create an entity to manage your expenses.</p>
        <p class="px-2">
            Entity names could be, for example:<br>
            <code>Shop, Agriculture, Home, Bike, Car, Tractor, Phone Recharge, etc.</code>
        </p>
    </div>
    <?php
}
?>

<?php
if (!empty($batchInfo->toArray())) {
?>
    <div class="border mt-3 p-1 rounded">
        <div class="p-2 bg-light rounded"><h5>Select Entity</h5></div>
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
