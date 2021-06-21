<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/Activities/">Activities</a></li>
        <li class="breadcrumb-item active" aria-current="page">Select Batch</li>
    </ol>
</nav>

<h1>Select Batch</h1>

<div class="">
    <table class="table mt-3 small ">
        <thead>
        <tr>
            <th>#</th>
            <th>Batch</th>
            <th></th>
        </tr>
        </thead>

        <!-- Here is where we iterate through our $articles query object, printing out article info -->

        <tbody>
        <?php
        $k = 0;
        foreach ($batchInfo as $batch):
            $k++;
            ?>

            <tr>
                <td>
                    <?= $k ?>.
                </td>
                <td>
                    <?php
                    if($batch->status == 1) {
                        ?>
                        <span class="text-success small"><i class="fa fa-circle"></i> </span>

                        <a href="/activities/add/<?= $batch->id ?>" title="Select <?= $batch->name ?>" class=""><?= $batch->name ?></a>
                        <?php
                    } else {
                        ?>
                        <span class="text-danger small"><i class="fa fa-circle"></i> </span>
                        <span class="text-danger"><?= $batch->name ?></span>
                        <?php
                    }
                    ?>
                </td>
                <td class="text-end">
                    <?php
                    if($batch->status == 1) {
                        ?>
                        <a href="/activities/add/<?= $batch->id ?>" title="Select <?= $batch->name ?>" class="btn btn-sm btn-primary py-0">Select</a>
                        <?php
                    } else {
                        ?>
                        <span class="text-muted">Closed</span>
                        <?php
                    }
                    ?>
                </td>
            </tr>

        <?php
        endforeach;

        if (empty($batchInfo->toArray())) {
            ?>
            <tr><td colspan="4">No batches found.</td></tr>
            <?php
        }

        ?>
        </tbody>
    </table>
</div>
