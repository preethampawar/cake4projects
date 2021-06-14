<h1>Activities List</h1>

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
    <table class="table table-sm mt-3 small table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Activity</th>
            <th>Batch</th>
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
                        <?= $activity->activity_date->format('d M') ?>,
                        <?= $activity->activity_date->format('h:i A') ?>
                    </div>
                </td>

                <td>
                    <div><?= $activity->name ?></div>
                    <div class="text-muted small">
                        <?= !empty(trim($activity->notes)) ? $activity->notes : '' ?>
                    </div>
                </td>
                <td><?= $activity->batch->name ?></td>
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
