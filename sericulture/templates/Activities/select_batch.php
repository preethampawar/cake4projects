<div class="mb-3">
    <a href="/Activities/" class="text-decoration-none"><i class="fa fa-arrow-circle-left"></i> Back</a>
</div>

<div class="border-bottom border-4 border-warning p-2 bg-light"><h5>Select Batch</h5></div>

<div class="list-group list-group-flush mt-1">
    <?php
    foreach ($batchInfo as $batch):
        if($batch->status == 1) {
            ?>
            <div class="list-group-item px-0 py-1">
                <a
                    href="/activities/selectActivity/<?= $batch->id ?>"
                    title="Select <?= $batch->name ?>"
                    id="<?= $batch->id ?>"
                    class="nav-link d-flex justify-content-between text-primary">

                    <?= $batch->name ?>


                    <i class="fa fa-chevron-right mt-1"></i>
                </a>
            </div>
            <?php
        } else {
            ?>

            <div class="list-group-item px-0 py-1">
                <a
                    href="#"
                    id="<?= $batch->id ?>"
                    class="nav-link d-flex justify-content-between text-secondary disabled" tabindex="-1" aria-disabled="true">

                    <?= $batch->name ?>


                    <i class="fa fa-chevron-right mt-1"></i>
                </a>
            </div>

            <?php
        }
    endforeach;
    ?>
</div>
