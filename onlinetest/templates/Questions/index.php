<h1>Questions List</h1>

<div class="text-end">
    <a class="btn btn-primary btn-sm" href="/questions/add">+ Add New Question</a>
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
            <th style="width: 50px;">#</th>
            <th style="width: 50px;">Q.ID</th>
            <th>Question</th>
            <th style="width: 8rem;">Actions</th>
        </tr>
        </thead>

        <!-- Here is where we iterate through our $articles query object, printing out article info -->

        <tbody>
        <?php
        $k = 0;
        foreach ($questions as $question):
            $k++;
            ?>

            <tr>
                <td>
                    <?= $k ?>.
                </td>
                <td>
                    <?= $question->id ?>
                </td>
                <td>
                    <div class="mb-2"><?= $question->name ?></div>

                    <div class="row">
                        <?php
                        if ($question->question_options) {
                            $i = 1;
                            foreach ($question->question_options as $row) {
                                ?>

                                <div class="col-md-6">
                                    <?php
                                    $class = null;
                                    $checked = null;
                                    if ($i === (int)$question->answer) {
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
                    <a href="/questions/edit/<?= $question->id ?>" title="Edit Question" class="">Edit</a>
                    &nbsp;|&nbsp;
                    <?php
                    echo $this->Html->link(
                        'Delete',
                        ['controller' => 'Questions', 'action' => 'delete', $question->id],
                        ['confirm' => 'Q.No.' . $question->id . '. Are you sure you want to delete this question?']
                    );
                    ?>
                </td>
            </tr>

        <?php
        endforeach;

        if (empty($questions->toArray())) {
            ?>
            <tr><td colspan="4">No questions found.</td></tr>
            <?php
        }

        ?>
        </tbody>
    </table>
</div>
