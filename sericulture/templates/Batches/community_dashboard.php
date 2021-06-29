
<?php
if (!$this->getRequest()->getSession()->read('User.id')) {
    ?>
    <div class="text-end">
        <a href="/Users/login" class="btn btn-sm btn-orange">Login</a>
    </div>
    <?php
}
?>

<div class="text-center text-primary my-3 fs-5">
    <i class="fa fa-users"></i> COMMUNITY UPDATES
</div>

<div class="row mt-3">
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
        <div class="bg-white shadow rounded p-2 mb-4 border border-2">
            <div class="mt-1">
                <div class="d-flex justify-content-between border-bottom border-4 border-warning pb-2">
                    <div class="text-secondary small">Farmer</div>
                    <h5><i class="fa fa-user-circle"></i> <?= $usersList[$batch->user_id] ?></h5>
                </div>
            </div>
            <div class="rounded pb-2 mb-2 mt-3">


                <div class="d-flex justify-content-between">
                    <div class="text-secondary small">Batch</div>
                    <div class="fs-6 text-start"><i class="fa fa-life-ring text-primary"></i> <?= $batch->name ?> </div>
                </div>

                <?php
                $progressPercentage = 0;

                foreach($batch->activities as $activity) {
                    $activityType = $activity->activity_type;
                    $tmp = explode('_', $activityType);

                    if (isset($tmp[1]) && $tmp[0] == 'STAGE') {
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

                $progressBg = 'bg-primary';
                if ($progressPercentage == 100) {
                    $progressBg = 'bg-success';
                }
                ?>

                <div class="progress mt-2">
                    <div class="progress-bar progress-bar-striped <?= $progressBg ?>" role="progressbar" style="width: <?= $progressPercentage ?>%" aria-valuenow="<?= $progressPercentage ?>" aria-valuemin="0" aria-valuemax="100"><?= $progressPercentage ?>%</div>
                </div>
            </div>

            <div class="mt-1 p-1" style="max-height: 350px; overflow: auto">
                <?php
                $dateWiseActivities = [];
                foreach($batch->activities as $activity) {
                    $activityDate = $activity->activity_date->format('d M');
                    $dateWiseActivities[$activityDate][] = $activity;
                }
                ?>
                <table class="table table-borderless">
                    <tbody>
                <?php
                foreach($dateWiseActivities as $date => $dayActivities) {
                    ?>
                    <tr class="border-0 border-bottom">

                        <td>
                            <div class="row">
                                <div class="col-sm-12 col-md-2">
                                    <div class="text-uppercase mb-3">
                                        <div class="small text-primary text-nowrap d-flex justify-content-between">
                                            <div><i class="fa fa-calendar-alt"></i> <?= $date ?></div>
                                            <span class="d-md-none"><span class="small text-orange text-capitalize text-nowrap mt-1"><i class="fa fa-sun"></i> <?= date('D', strtotime($date)) ?></span></span>
                                        </div>
                                        <div class="d-none d-md-block small text-orange text-capitalize text-nowrap mt-1"><i class="fa fa-sun"></i> <?= date('D', strtotime($date)) ?></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-10">
                                    <?php
                                    foreach($dayActivities as $row) {
                                        ?>

                                        <div class="d-flex justify-content-start mb-3 small">
                                            <div>
                                                <span class="text-nowrap text-danger small">
                                                    <?= $row->activity_time->format('h:i A') ?>
                                                </span>
                                            </div>
                                            <div class="ms-2 p-1 flex-fill border-start border-3 border-grey bg-light">
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

                <div class="p-2 border rounded small text-muted alert alert-primary mb-3">
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

        </div>
    </div>
    <?php
}
?>

</div>
