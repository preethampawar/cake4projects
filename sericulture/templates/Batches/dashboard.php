<?php

use App\Model\Table\BatchesTable;

if (! $batches->toArray()) {
    ?>
    <p>Oops! there are no batches created yet.</p>
    <p>Please create a <a href="/Batches/add">new batch</a> to see the updates here.</p>

    <?php
}

foreach($batches as $batch) {
?>
    <div class="bg-white shadow rounded border p-3 mb-5">
        <div class="text-end">
            <a href="/Activities/add/<?= $batch->id ?>" title="Add New Activity" class="btn btn-sm btn-orange rounded-pill">
                <i class="fa fa-plus-circle"></i>
                <span class="">NEW ACTIVITY</span>
            </a>
        </div>
        <h1 class="mt-3"><?= $batch->name ?></h1>



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
                                <span class="badge bg-orange-light rounded-pill">
                                    <?= $row->activity_date->format('h:i A') ?>
                                </span>
                            </div>
                            <div class="ms-2 p-1 flex-fill">
                                <div class="text-dark"><?= $row->name ?></div>
                                <div class="text-muted">
                                    <?= $row->notes ?>
                                </div>
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
        <div class="p-2 border rounded small text-muted bg-light mb-3">
            <table class="table table-sm table-borderless mb-0">
                <tbody>
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

    </div>
    <?php
}
?>


