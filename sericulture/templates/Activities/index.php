<h1><i class="fa fa-tasks"></i> Activities</h1>

<div class="text-end">
    <a class="btn btn-orange btn-sm rounded-pill" href="/Activities/selectBatch"><i class="fa fa-plus-circle"></i> NEW ACTIVITY</a>
</div>

<div>
    <div>
        <b><?php echo $this->Paginator->counter(
                'Total Records: {{count}}'
            ); ?></b>
    </div>

    <div class="d-flex mt-3">
        <div class="">
            Page:
            <?= $this->Paginator->counter() ?>
        </div>
        <div class="mx-3">|</div>
        <div class="text-end d-flex">

            <ul class="list-unstyled">
                <?= $this->Paginator->prev('« Previous') ?>
            </ul>

            <ul class="list-unstyled mx-3">
                <?= $this->Paginator->next('Next »') ?>
            </ul>
        </div>
    </div>
</div>

<div class="">
    <table class="table mt-3 small">
        <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Activity</th>
            <th></th>
        </tr>
        </thead>

        <!-- Here is where we iterate through our $articles query object, printing out article info -->

        <tbody>
        <?php
        $k = 0;
        foreach ($activities as $activity):
            $k++;
            ?>

            <tr>
                <td>
                    <?= $k ?>.
                </td>
                <td>
                    <div>
                        <span class="d-inline-block text-uppercase me-1"><?= $activity->activity_date->format('d M') ?></span>
                        <span class="badge bg-orange-light px-1 rounded-pill"><?= $activity->activity_time->format('h:i a') ?></span><br>
                        <span class="text-capitalize text-orange small text-nowrap d-block d-md-none"><i class="fa fa-sun"></i> <?= $activity->activity_date->format('D') ?></span>
                        <span class="text-capitalize text-orange small text-nowrap d-none d-md-block"><i class="fa fa-sun"></i> <?= $activity->activity_date->format('l') ?></span>
                    </div>
                </td>

                <td>
                    <div><?= $activity->name ?></div>

                    <?php
                    if (!empty(trim($activity->notes))) {
                        ?>
                        <div class="mt-1">
                            <code class="mb-1" style="white-space: pre-wrap;"><?= trim($activity->notes) ?></code>
                        </div>
                        <?php
                    }
                    ?>

                    <div>
                        <a href="/Batches/details/<?= $activity->batch_id ?>">
                            <?= $activity->batch->name ?>
                        </a>
                    </div>
                </td>
                <td class="text-end">
                    <div class="dropdown">
                        <a class="fs-5 p-1" href="#" id="actionsDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-ellipsis-v"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="actionsDropdownMenuLink">
                            <li><a href="/Activities/edit/<?= $activity->id ?>" title="Edit Activity details" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a></li>
                            <li>
                                <?php
                                echo $this->Html->link(
                                    '<i class="fa fa-times-circle"></i> Delete',
                                    ['controller' => 'Activities', 'action' => 'delete', $activity->id],
                                    [
                                        'confirm' => 'Are you sure you want to delete this Activity?',
                                        'class' => 'dropdown-item',
                                        'title' => $activity->name,
                                        'escape' => false
                                    ]
                                );
                                ?>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>

        <?php
        endforeach;

        if (empty($activities->toArray())) {
            ?>
            <tr><td colspan="4">No activities found.</td></tr>
            <?php
        }

        ?>
        </tbody>
    </table>
</div>
