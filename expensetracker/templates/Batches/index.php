<h1><i class="fa fa-hand-holding-usd"></i> Manage Entities</h1>

<div class="text-end">
    <a class="btn btn-orange btn-sm rounded-pill" href="/Batches/add"><i class="fa fa-plus-circle"></i> NEW ENTITY</a>
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
    <table class="table mt-3">
        <thead>
        <tr>
            <th>#</th>
            <th>Entity</th>
            <th></th>
        </tr>
        </thead>

        <!-- Here is where we iterate through our $articles query object, printing out article info -->

        <tbody>
        <?php
        $k = 0;
        foreach ($batches as $batch):
            $k++;
            ?>

            <tr>
                <td>
                    <?= $k ?>.
                </td>
                <td>
                    <?= $batch->active == 1 ?
                        '<span class="text-success small"><i class="fa fa-circle"></i> </span>' :
                        '<span class="text-danger small"><i class="fa fa-circle"></i> </span>'
                    ?>

                    <?php
                    if ($batch->active == 1) {
                        ?>
                        <a href="/Batches/changeEntity/<?= $batch->id ?>">
                            <?= $batch->name ?>
                        </a>
                        <?php
                    } else {
                        ?>
                        <a href="/Batches/changeEntity/<?= $batch->id ?>" class="link-danger">
                            <?= $batch->name ?>
                        </a>
                        <?php
                    }
                    ?>
                </td>
                <td class="text-end">
                    <div class="dropdown">
                        <a class="fs-5 p-2" href="#" id="actionsDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-ellipsis-v"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="actionsDropdownMenuLink">
                            <li><a href="/Batches/edit/<?= $batch->id ?>" title="Edit Batch details" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a></li>
                            <li>
                                <?php
                                if ($batch->active == 1) {
                                    echo $this->Html->link(
                                        '<i class="fa fa-times-circle"></i> Mark As Closed',
                                        ['controller' => 'Batches', 'action' => 'changeStatus', $batch->id, 'inactive'],
                                        [
                                            'confirm' => 'Are you sure you want to Close this Entity?',
                                            'class' => 'dropdown-item',
                                            'title' => $batch->name,
                                            'escape' => false
                                        ]
                                    );
                                } else {
                                    echo $this->Html->link(
                                        '<i class="fa fa-check-circle"></i> Mark As Active',
                                        ['controller' => 'Batches', 'action' => 'changeStatus', $batch->id, 'active'],
                                        [
                                            'confirm' => 'Are you sure you want to Activate this Entity?',
                                            'class' => 'dropdown-item',
                                            'title' => $batch->name,
                                            'escape' => false
                                        ]
                                    );
                                }
                                ?>
                            </li>
                            <li>
                                <?php
                                echo $this->Html->link(
                                    '<i class="fa fa-times-circle"></i> Delete',
                                    ['controller' => 'Batches', 'action' => 'delete', $batch->id],
                                    [
                                        'confirm' => 'Are you sure you want to delete this Entity?',
                                        'class' => 'dropdown-item',
                                        'title' => $batch->name,
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

        if (empty($batches->toArray())) {
            ?>
            <tr><td colspan="4">No entities found.</td></tr>
            <?php
        }

        ?>
        </tbody>
    </table>
</div>
