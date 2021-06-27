<?php

use App\Model\Table\ActivitiesTable;

?>
<div class="mb-3">
    <a href="/Activities/selectBatch/<?= $batchId ?>" class="text-decoration-none"><i class="fa fa-arrow-circle-left"></i> Back</a>
</div>


<h5><?= $batchInfo->name ?></h5>





<?php
$recentActivityType = null;

if ($recentActivity) {
    $recentActivityType = $recentActivity->activity_type;
    ?>
    <div class="p-2 border rounded bg-light small mt-3 mb-3" role="button" onclick="focusOnRecentActivity()">
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


<div class="accordion mt-4" id="accordionExample">
    <div class="accordion-item">
        <h5 class="accordion-header sticky-top" id="headingOne">
            <button class="accordion-button fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Select Activity
            </button>
        </h5>
        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body p-2">
                <?php
                foreach (ActivitiesTable::ACTIVITY_OPTIONS as $index => $row):
                    ?>
                    <div class="mb-2 small">
                        <div class="p-1 fw-bold"><span><?= $index ?></span></div>
                        <div class="list-group list-group-flush mt-0">
                            <?php
                            foreach ($row as $activityType => $activity):
                                $activeClass = $activityType == $recentActivityType ? ' border border-warning rounded bg-light ' : null;
                                ?>
                                <div class="list-group-item px-0 py-0">

                                    <a
                                        href="/activities/add/<?= $batchId ?>/<?= $activityType ?>"
                                        title="Select <?= $activity ?>"
                                        id="<?= $activityType ?>"
                                        class="nav-link d-flex justify-content-between text-primary <?= $activeClass ?>">
                                        <div>
                                            <div><i class="fa fa-check-circle small text-primary"></i> <?= $activity ?></div>
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

                                        <i class="fa fa-chevron-right mt-1 d-none"></i>
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
        </div>
    </div>
</div>

<?php
if ($recentActivityType) {
    ?>
    <script>
        function focusOnRecentActivity() {
            $('#<?=$recentActivityType?>').focus()
        }

        $(document).ready(function () {
            focusOnRecentActivity()
        })
    </script>
    <?php
}
?>

