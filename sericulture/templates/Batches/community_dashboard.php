<div class="alert alert-warning text-center mb-4">
    <span>Community Updates</span>
</div>

<div class="row">
<?php

use App\Model\Table\BatchesTable;
use App\Model\Table\ActivitiesTable;

if (! $batches->toArray()) {
    ?>
    <p>Oops! there are no batches created/active yet.</p>
    <p>Please create a <a href="/Batches/add">new batch</a> to see the updates here.</p>

    <?php
}

foreach($batches as $batch) {
?>
    <div class="col-sm-6">
        <div class="bg-white shadow rounded p-3 mb-5">
            <div class="text-start">
                <h4><?= $usersList[$batch->user_id] ?></h4>
            </div>
            <div class="rounded bg-light px-2 py-2 mb-2 mt-3">
                <span class="fs-6">Batch: <?= $batch->name ?></span>



                <?php
                $progressPercentage = 0;

                foreach($batch->activities as $activity) {
                    $activityType = $activity->activity_type;
                    $tmp = explode('_', $activityType);

                    if (isset($tmp[1])) {
                        $stageNo = (int)$tmp[1];

                        switch ($stageNo) {
                            case 1:
                                $progressPercentage = 15;
                                break;
                            case 2:
                                $progressPercentage = 30;
                                break;
                            case 3:
                                $progressPercentage = 45;
                                break;
                            case 4:
                                $progressPercentage = 60;
                                break;
                            case 5:
                                $progressPercentage = 75;
                                break;
                            case 6:
                                $progressPercentage = 85;

                                if ($activityType == 'STAGE_6_MARKETING_OF_COCOONS') {
                                    $progressPercentage = 100;
                                }
                                break;
                            default:
                                $progressPercentage = 0;
                                break;
                        }

                        break;
                    }
                }
                ?>


                <div class="progress mt-2">
                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: <?= $progressPercentage ?>%" aria-valuenow="<?= $progressPercentage ?>" aria-valuemin="0" aria-valuemax="100"><?= $progressPercentage ?>%</div>
                </div>
            </div>

            <div class="mt-2" style="max-height: 400px; overflow-y: scroll; overflow-x: hidden">
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

                        <td>
                            <div class="row">
                                <div class="col-sm-12 col-md-2">
                                    <div class="text-uppercase mb-3">
                                        <div class="small text-primary text-nowrap"><i class="fa fa-calendar-alt"></i> <?= $date ?></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-10">
                                    <?php
                                    foreach($dayActivities as $row) {
                                        ?>

                                        <div class="d-flex justify-content-start mb-3 small">
                                            <div>
                                                <span class="badge bg-orange-light rounded-pill">
                                                    <?= $row->activity_time->format('h:i A') ?>
                                                </span>
                                            </div>
                                            <div class="ms-2 flex-fill">
                                                <div class="text-dark"><?= $row->name ?></div>
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
                                </div>
                            </div>

                        </td>
                    </tr>
                    <?php
                }
                ?>
                    </tbody>
                </table>
                <div class="p-2 border rounded small text-muted bg-light mb-3 d-none">
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

            </div >
        </div >
    </div>
    <?php
}
?>

</div>
