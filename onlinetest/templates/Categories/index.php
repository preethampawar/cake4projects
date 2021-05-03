<h1>Categories List</h1>

<div class="text-end">
    <a class="btn btn-primary btn-sm" href="/Categories/add">+ New Category</a>
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

<div class="table-responsive">
    <table class="table table-sm mt-3">
        <thead>
        <tr>
            <th>#</th>
            <th>Category Name</th>
            <th></th>
        </tr>
        </thead>

        <!-- Here is where we iterate through our $articles query object, printing out article info -->

        <tbody>
        <?php
        $k = 0;
        foreach ($categories as $category):
            $k++;
            ?>

            <tr>
                <td>
                    <?= $k ?>.
                </td>
                <td>
                    <?= $category->active == 1 ? '<span class="">'.$category->name.'</span>' : '<span class="text-danger">'.$category->name.'</span>' ?>
                </td>
                <td class="text-end">
                    <div class="dropdown">
                        <a class="fs-5" href="#" id="actionsDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-ellipsis-h"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="actionsDropdownMenuLink">
                            <li><a href="/Categories/edit/<?= $category->id ?>" title="Edit Category details" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a></li>
                            <li>
                                <?php
                                echo $this->Html->link(
                                    '<i class="fa fa-times-circle"></i> Delete',
                                    ['controller' => 'Categories', 'action' => 'delete', $category->id],
                                    [
                                        'confirm' => 'Are you sure you want to delete this Category?',
                                        'class' => 'dropdown-item',
                                        'title' => $category->name,
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

        if (empty($categories->toArray())) {
            ?>
            <tr><td colspan="4">No categories found.</td></tr>
            <?php
        }

        ?>
        </tbody>
    </table>
</div>
