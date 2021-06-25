<?php

use App\Model\Table\ActivitiesTable;

?>
<div class="mb-3">
    <a href="/Activities/selectBatch/<?= $batchId ?>" class="text-decoration-none"><i class="fa fa-arrow-circle-left"></i> Back</a>
</div>


<h5>Select Activity - <?= $batchInfo->name ?></h5>





<?php
$recentActivityType = null;

if ($recentActivity) {
    $recentActivityType = $recentActivity->activity_type;
    ?>
    <div class="p-2 border border-warning rounded small mt-3 mb-3" role="button" onclick="focusOnRecentActivity()">
        <div class="fst-italic text-muted"><i class="fa fa-info-circle"></i> Recent Activity</div>

        <div class="mt-1">
            <i class="fa fa-calendar-alt text-primary"></i> <?= $recentActivity->activity_date->format('d M') ?>,
            <?= $recentActivity->activity_date->format('h:i A') ?>,
            <i class="fa fa-sun text-orange"></i> <?= $recentActivity->activity_date->format('D') ?>
        </div>

        <div class="mt-1"><?= $recentActivity->name ?></div>

    </div>
    <?php
}
?>


<div class="mt-3">
    <?php
    foreach (ActivitiesTable::ACTIVITY_OPTIONS as $index => $row):
        ?>
        <div class="mb-4 small">
            <div class="border-bottom border-4 border-warning p-2 bg-light"><h5><?= $index ?></h5></div>
            <div class="list-group list-group-flush">
                <?php
                foreach ($row as $activityType => $activity):
                    $activeClass = $activityType == $recentActivityType ? ' ' : null;
                    ?>
                    <div class="list-group-item px-0 py-1">
                        <a
                            href="/activities/add/<?= $batchId ?>/<?= $activityType ?>"
                            title="Select <?= $activity ?>"
                            id="<?= $activityType ?>"
                            class="nav-link d-flex justify-content-between text-primary <?= $activeClass ?>">
                            <div>
                                <?= $activity ?>
                                <?php
                                if ($activeClass) {
                                    ?>
                                    <div class="text-orange mt-2 rounded p-2 bg-light"><i
                                            class="fa fa-hand-point-up fs-5"></i> recent activity
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                            <i class="fa fa-chevron-right mt-1"></i>
                        </a>
                    </div>
                <?php
                endforeach;
                ?>
            </div>

        </div>
    <?php
    endforeach;
    ?>
</div>

<?php
if ($recentActivityType) {
    ?>
    <script>
        function focusOnRecentActivity() {
            $('#<?=$recentActivityType?>').focus()
        }

        //
        //$(document).ready(function () {
        //    $('#<?//=$recentActivityType?>//').focus()
        //})
    </script>
    <?php
}
?>

