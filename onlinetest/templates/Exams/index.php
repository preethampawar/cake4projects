<h1>Exams List</h1>

<div class="text-end">
    <a class="btn btn-primary btn-sm" href="/exams/add">+ New Exam</a>
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
            <th>Exam Name</th>
            <th>Actions</th>
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
                    <div class="mb-2"><?= $exam->name ?></div>

                    <div class="row">
                        <?php
                        if ($exam->question_options) {
                            $i = 1;
                            foreach ($exam->question_options as $row) {
                                ?>

                                <div class="col-md-6">
                                    <?php
                                    $class = null;
                                    $checked = null;
                                    if ($i === (int)$exam->answer) {
                                        $class = "fw-bold";
                                        $checked = "checked";
                                    }
                                    ?>
                                    <span class="<?= $class ?>">
                                <div class="form-check" title="<?= $checked ? 'Correct Answer' : '' ?>">
                                    <input class="form-check-input" type="radio" <?= $checked ?> disabled>
                                    <label class="form-check-label2">
                                        <?= $row->name ?>
                                    </label>
                                </div>

                            </span>
                                </div>

                                <?php
                                if ($i % 2 == 0) {
                                    echo '</div><div class="row">';
                                }

                                $i++;
                            }
                        }
                        ?>
                    </div>
                </td>
                <td>
                    <a href="/exams/view/<?= $exam->id ?>" title="Show details" class="">Preview</a>
                    &nbsp;|&nbsp;
                    <a href="/exams/addQuestions/<?= $exam->id ?>" title="Add or Remove Questions" class="">Add/Remove Questions</a>
                    &nbsp;|&nbsp;
                    <a href="/exams/edit/<?= $exam->id ?>" title="Edit Exam details" class="">Edit Exam Details</a>
                    &nbsp;|&nbsp;
                    <?php
                    echo $this->Html->link(
                        'Delete',
                        ['controller' => 'Exams', 'action' => 'delete', $exam->id],
                        ['confirm' => 'E.ID.' . $exam->id . '. Are you sure you want to delete this exam?']
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
