
<?php

use App\Model\Table\BatchesTable;


?>
<div class="text-end">
    <?php
    if ($batch->status == 1) {
    ?>
    <a href="/Activities/add/<?= $batch->id ?>" title="Add New Activity" class="btn btn-sm btn-orange">
        <i class="fa fa-plus-circle"></i>
        <span class="">NEW ACTIVITY</span>
    </a>
    <?php
    }
    ?>

    <a href="/Batches/" title="Add New Activity" class="btn btn-sm btn-secondary ms-3">
        <span class="">BACK</span>
    </a>
</div>

<h1 class="mt-3">Batch Details</h1>
<div class="p-2 border rounded small text-muted bg-light mt-3">
    <table class="table table-sm table-borderless mb-0">
        <tbody>
        <tr>
            <td>Batch Name:</td>
            <td><?= $batch->name ?></td>
        </tr>
        <tr>
            <td>Type:</td>
            <td><?= $batch->silkworm_type ?></td>
        </tr>
        <tr>
            <td>Dfls & Cost:</td>
            <td><?= $batch->dfls ?> dfls, Rs. <?= $batch->cost_of_chawki ?></td>
        </tr>
        <tr>
            <td>Hatching Date:</td>
            <td><?= $batch->hatching_date ? $batch->hatching_date->format('d M Y') : 'n/a' ?></td>
        </tr>
        <tr>
            <td>Chawki Center:</td>
            <td class="p-0">
                <table class="table table-borderless table-sm mb-0">
                    <tbody>
                    <tr>
                        <td>Contact:</td>
                        <td><?= $batch->chawki_center_contact_name ?></td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td><?= $batch->chawki_center_contact_no ?></td>
                    </tr>
                    <tr>
                        <td>Location:</td>
                        <td><?= $batch->chawki_center_place ?></td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<div class="mt-4">
    <h5>Activities:</h5>
    <?php
    $dateWiseActivities = [];
    foreach($batch->activities as $activity) {
        $activityDate = $activity->activity_date->format('d M');
        $dateWiseActivities[$activityDate][] = $activity;
    }
    ?>
    <table class="table table-borderless mt-3">
        <tbody>
    <?php
    foreach($dateWiseActivities as $date => $dayActivities) {
        ?>
        <tr class="border-0 border-bottom">
            <td style="width: 75px">
                <div class="text-primary text-center text-uppercase">
                    <span class="fs-4"><i class="fa fa-calendar-alt"></i></span><br>
                    <span class="small text-dark"><?= $date ?></span>
                </div>
            </td>
            <td>
                <?php
                foreach($dayActivities as $row) {
                    ?>

                    <div class="d-flex justify-content-start mb-3 small">
                        <div class="py-1">
                            <span class="text-nowrap px-2 py-1 bg-orange-light rounded-pill small">
                                <?= $row->activity_time->format('h:i A') ?>
                            </span>
                        </div>
                        <div class="ms-1 p-1 flex-fill">
                            <div class="text-dark">
                                <?= $row->name ?>
                                <a href="/Activities/edit/<?= $row->id ?> " class="text-primary ms-1"><i class="fa fa-pencil-alt"></i></a>
                            </div>
                            <?php
                            if (!empty(trim($row->notes))) {
                            ?>
                                <div class="mt-1">
                                    <code class="mb-1" style="white-space: pre-wrap;"><?= trim($row->notes) ?></code>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    <?php
                }
                ?>
            </td>
        </tr>
        <?php
    }
    ?>
        </tbody>
    </table>

</div>


