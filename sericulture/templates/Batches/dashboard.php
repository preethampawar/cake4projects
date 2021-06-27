
<div class="text-center text-primary mb-3 fs-5">
    <i class="fa fa-asterisk"></i> MY UPDATES
</div>

<?php
if ($transactionsInfo) {
    ?>
    <div class="p-1 rounded shadow border">
        <div class="text-start bg-light p-2 border rounded">
            <span class="fs-5 text-purple-dark"><i class="fa fa-rupee-sign"></i> Finance</span>
        </div>
        <div class="text-center my-2">
            <a href="#" class="btn btn-sm btn-orange rounded-pill small py-1" data-bs-toggle="offcanvas" data-bs-target="#selectTransactionMenu">
                <i class="fa fa-plus-circle small"></i> <span class="small">NEW TRANSACTION</span>
            </a>
        </div>

        <div class="px-1"  style="max-height: 350px; overflow: auto">
            <table class="table table-sm text-center small">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th class="text-success">Income</th>
                        <th class="text-danger">Expense</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($transactionsInfo as $date => $row) {
                    ?>
                    <tr>
                        <td class="text-uppercase text-nowrap small"><?= date('M y', strtotime($date)) ?></td>
                        <td class="text-success small"><?= $row['income'] ?? 0 ?></td>
                        <td class="text-danger small"><?= $row['expense'] ?? 0 ?></td>
                        <td class="small">
                            <?php
                            $amount = (float)($row['income'] ?? 0) - (float)($row['expense'] ?? 0);

                            echo $amount > 0 ?
                                '<span class="text-success">'.$amount.'</span>' :
                                '<span class="text-danger">'.$amount.'</span>';

                            ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>

    </div>

    <?php
}
?>

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
    <div class="bg-white shadow rounded p-1 my-4 border">

        <div class="rounded bg-light border px-2 py-2 text-start">
            <span class="fs-5 text-purple-dark"><i class="fa fa-life-ring"></i> <?= $batch->name ?></span>
        </div>
        <div class="text-center my-2">
            <a href="/Activities/selectActivity/<?= $batch->id ?>" title="Add New Activity" class="btn btn-sm btn-orange rounded-pill">
                <i class="fa fa-plus-circle small"></i>
                <span class="small">NEW ACTIVITY</span>
            </a>
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

        <div class="text-muted fst-italic small mt-2">Progress</div>
        <div class="progress">
            <div class="progress-bar progress-bar-striped <?= $progressBg ?>" role="progressbar" style="width: <?= $progressPercentage ?>%" aria-valuenow="<?= $progressPercentage ?>" aria-valuemin="0" aria-valuemax="100"><?= $progressPercentage ?>%</div>
        </div>

        <?php
        $dateWiseActivities = [];
        foreach($batch->activities as $activity) {
            $activityDate = $activity->activity_date->format('d M');
            $dateWiseActivities[$activityDate][] = $activity;
        }
        ?>
        <div>
            <table class="table table-borderless">
                <tbody>
            <?php
            foreach($dateWiseActivities as $date => $dayActivities) {
                ?>
                <tr class="border-0 border-bottom">

                    <td>
                        <div class="row mt-3">
                            <div class="col-sm-12 col-md-2">
                                <div class="text-uppercase mb-3 d-flex justify-content-between">
                                    <div class="small text-primary text-nowrap fs-5"><i class="fa fa-calendar-alt"></i> <?= $date ?></div>
                                    <div class="small text-orange text-capitalize text-nowrap mt-1"><i class="fa fa-sun"></i> <?= date('l', strtotime($date)) ?></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-10">
                                <?php
                                foreach($dayActivities as $row) {
                                    ?>

                                    <div class="d-flex justify-content-start mb-3 small">
                                        <div class="py-1">
                                            <span class="text-nowrap text-danger small">
                                                <?= $row->activity_time->format('h:i A') ?>
                                            </span>
                                        </div>
                                        <div class="ms-1 p-1 flex-fill border-start border-2 border-grey bg-light">
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
        </div>

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

    </div>
    <?php
}
?>


