<h1>Select Batch</h1>

<div class="text-end">
    <a class="btn btn-danger btn-sm" href="/Activities/">Cancel</a>
</div>

<div class="">
    <table class="table table-sm mt-3 small">
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
                    <?= $batch->name ?>
                </td>
                <td class="text-end">
                    <a href="/activities/add/<?= $batch->id ?>" title="Select <?= $batch->name ?>">Select</a>
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
