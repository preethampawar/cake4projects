<h1>Test Series</h1>

<div class="text-end">
    <a class="btn btn-primary btn-sm" href="/ExamGroups/add">+ New Test Series</a>
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
    <table class="table table-sm mt-3">
        <thead>
        <tr>
            <th>#</th>
            <th>Test Series</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $k = 0;
        foreach ($examGroups as $examGroup):
            $k++;
            ?>

            <tr>
                <td>
                    <?= $k ?>.
                </td>
                <td>
                    <?= $examGroup->active == 1 ? '<span class="">'.$examGroup->name.'</span>' : '<span class="text-danger">'.$examGroup->name.'</span>' ?>
                </td>
                <td class="text-end">
                    <div class="dropdown">
                        <a class="fs-5" href="#" id="actionsDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-ellipsis-h"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="actionsDropdownMenuLink">
                            <li><a href="/ExamGroups/edit/<?= $examGroup->id ?>" title="Edit Test Series details" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a></li>
                            <li>
                                <?php
                                echo $this->Html->link(
                                    '<i class="fa fa-times-circle"></i> Delete',
                                    ['controller' => 'ExamGroups', 'action' => 'delete', $examGroup->id],
                                    [
                                        'confirm' => 'Are you sure you want to delete this Test Series?',
                                        'class' => 'dropdown-item',
                                        'title' => $examGroup->name,
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

        if (empty($examGroups->toArray())) {
            ?>
            <tr><td colspan="4">No Test Series found.</td></tr>
            <?php
        }

        ?>
        </tbody>
    </table>
</div>
