

<?php
$categoryList = null;
foreach($categories as $category) {
    $categoryList[$category->id] = (string)$category->name;
}
?>

<h1>Exams List</h1>

<div class="text-end">
    <a class="btn btn-primary btn-sm" href="/exams/add">+ New Exam</a>
</div>

<div>
    <div>
        <b><?php echo $this->Paginator->counter(
                'Total Tests: {{count}}'
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
            <th>Exam Name</th>
            <th></th>
        </tr>
        </thead>

        <!-- Here is where we iterate through our $articles query object, printing out article info -->

        <tbody>
        <?php
        $k = 0;
        foreach ($exams as $exam):
            $k++;
            ?>

            <tr>
                <td>
                    <?= $k ?>.
                </td>
                <td>
                    <div class="">
                        <a href="/exams/edit/<?= $exam->id ?>" title="Edit Exam details" class="">
                            <?= $exam->name ?>
                        </a>
                        <div class="">
                            <span class="text-muted small">
                                <?= count($exam->exam_questions) ?> questions,
                                <?= $exam->time ?> mins
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <?php
                        if ($categoryList && $exam->exam_categories) {
                            foreach($exam->exam_categories as $examCategory) {
                                $categoryName = $categoryList[$examCategory->category_id];
                                ?>
                                <button class="btn btn-ivory btn-sm border py-0 me-1 mt-1 active"><?= $categoryName ?></button>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </td>
                <td class="text-end">
                    <a href="/exams/edit/<?= $exam->id ?>" title="Show details" class="btn btn-primary btn-sm py-0">Edit</a>
                    <a href="/exams/view/<?= $exam->id ?>" title="Show details" class="btn btn-purple btn-sm py-0 ms-2">Preview</a>


                    <?php
                    echo $this->Html->link(
                        'X',
                        ['controller' => 'Exams', 'action' => 'delete', $exam->id],
                        [
                            'confirm' => 'Are you sure you want to delete this exam?',
                            'class' => 'btn btn-danger btn-sm py-0 ms-2',
                            'title' => $exam->name
                        ]
                    );
                    ?>
                </td>
            </tr>

        <?php
        endforeach;

        if (empty($exams->toArray())) {
            ?>
            <tr><td colspan="4">No exams found.</td></tr>
            <?php
        }

        ?>
        </tbody>
    </table>
</div>
