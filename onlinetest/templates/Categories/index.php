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
    <table class="table table-sm small mt-3">
        <thead>
        <tr>
            <th>#</th>
            <th>Category Name</th>
            <th>Actions</th>
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
                    <a href="/Categories/edit/<?= $category->id ?>" title="Edit Category details" class="btn btn-sm btn-primary py-0">Edit</a>

                    <?php
                    echo $this->Html->link('X',
                        [
                            'controller' => 'Categories',
                            'action' => 'delete',
                            $category->id
                        ],
                        [
                            'confirm' => $category->name . ' - Are you sure you want to delete this category?',
                            'class' => 'btn btn-sm btn-danger py-0 ms-2'
                        ]
                    );
                    ?>
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
