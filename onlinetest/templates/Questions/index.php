<h1>Question Bank</h1>


<div class="text-end mt-3">
    <a class="btn btn-primary btn-sm ms-3" href="/questions/add">+ Add Question</a>
</div>

<?= $this->Form->create(null, ['method' => 'get']) ?>
<div class="mt-3 mb-3">
    <div class="alert alert-secondary">
        <label class="fw-bold">Filter</label>
        <div class="row mt-2">
            <div class="col-12 col-sm-4 col-md-4 col-lg-3 mb-2">
                <label>Subjects</label>
                <div id="subjectDivAddQuestionForm">
                    <?= $this->element('subjectsDropDown', [
                        'subjects' => $subjects,
                        'selectedSubject' => $selectedSubject,
                        'empty' => true,
                        'multiple' => true,
                    ])
                    ?>
                </div>
            </div>
            <div class="col-12 col-sm-4 col-md-4 col-lg-3 mb-2">
                <label>Education</label>
                <div id="educationLevelDivAddQuestionForm">
                    <?= $this->element('educationLevelsDropDown', [
                        'educationLevels' => $educationLevels,
                        'selected' => $selectedEducationLevel,
                        'empty' => true,
                        'multiple' => true
                    ]) ?>
                </div>
            </div>
            <div class="col-12 col-sm-4 col-md-4 col-lg-3 mb-2">
                <label>Difficulty</label>
                <?php
                echo $this->Form->control('difficulty_level', [
                    'label' => false,
                    'type' => 'select',
                    'class' => 'form-control form-control-sm',
                    'options' => [
                        '1' => 'Easy',
                        '2' => 'Medium',
                        '3' => 'Hard',
                    ],
                    'empty' => true,
                    'multiple' => true,
                    'default' => $selectedDifficultyLevel
                ]);
                ?>
            </div>
            <div class="col-12 col-sm-4 col-md-4 col-lg-3 mb-2">
                <label>Tags</label>
                <div id="tagsDivAddQuestionForm">
                    <?= $this->element('tagsDropDown', ['tags' => $tags, 'selected' => $selectedTags]) ?>
                </div>
            </div>
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-sm btn-primary">Filter Question Bank</button>
        </div>
    </div>
</div>
<?= $this->Form->end() ?>

<div class="mt-4">
    <div>
        <b><?php echo $this->Paginator->counter(
                'Total Questions: {{count}}'
            ); ?></b>
    </div>

    <div class="d-flex mt-3">
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
    <table class="table mt-3 table-sm">
        <thead>
        <tr>
            <th>#</th>
            <th>Question</th>
            <th></th>
        </tr>
        </thead>

        <!-- Here is where we iterate through our $articles query object, printing out article info -->

        <tbody>
        <?php
        $k = $this->Paginator->counter('{{start}}');
        foreach ($questions as $question):
            ?>

            <tr>
                <td class="pt-2">
                    <?= $k ?>.
                </td>
                <td class="pt-2">
                    <div class="mb-2">
                        <a href="/questions/edit/<?= $question->id ?>" title="Edit Question" class="">
                            <?= $question->name ?>
                        </a>
                    </div>


                    <div class="">
                        <?php
                        $chars = range('a', 'z');
                        if ($question->question_options) {
                            $i = 1;
                            foreach ($question->question_options as $row) {
                                $class = null;
                                $checked = null;
                                if ($i === (int)$question->answer) {
                                    $class = "fw-bold";
                                    $checked = "checked";
                                }
                                ?>
                                <div class="<?= $class ?>">
                                    <div class="form-check" title="<?= $checked ? 'Correct Answer' : '' ?>">

                                        <input class="form-check-input" type="radio" <?= $checked ?> disabled>
                                        <label class="form-check-label2">
                                            <span class="text-secondary d-flex">
                                                <span><?= $chars[$i - 1] ?>)&nbsp;</span>
                                                <span><?= $row->name ?></span>
                                            </span>
                                        </label>
                                    </div>

                                </div>

                                <?php

                                $i++;
                            }
                        }
                        ?>
                    </div>
                    <div class="mt-2 mb-3 small">
                        <?= $question->subject != '' ? '<span class="bg-orange me-1 px-1 rounded pb-1">'.$question->subject.'</span>' : null ?>

                        <?= $question->level != '' ? '<span class="bg-purple me-1 px-1 rounded pb-1">'.$question->level.'</span>' : null ?>

                        <?php
                        $difficulty = null;
                        switch ($question->difficulty_level) {
                            case 1:
                                $difficulty = 'Easy';
                                break;
                            case 2:
                                $difficulty = 'Medium';
                                break;
                            case 3:
                                $difficulty = 'Hard';
                                break;
                        }
                        ?>
                        <?= $difficulty ? '<span class="bg-maroon me-1 px-1 rounded pb-1">'.$difficulty.'</span>' : null ?>

                        <?php
                        if(!empty($question->tags)) {
                            ?>

                            <div class="mt-3">
                            <b>Tags: </b>
                            <?php
                            $tags = explode(',', $question->tags);
                            foreach($tags as $tag) {
                                ?>
                                <span class="bg-ivory me-1 px-1 border rounded pb-1">
                                    <?= $tag ?>
                                </span>
                                <?php
                            }
                            ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </td>
                <td class="text-end">

                    <div class="dropdown">
                        <a class="fs-5" href="#" id="actionsDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-ellipsis-h"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="actionsDropdownMenuLink">
                            <li><a href="/questions/edit/<?= $question->id ?>" title="Edit Question" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a></li>
                            <li>
                                <a href="#" class="dropdown-item" onclick="popup.confirm('/Questions/delete/<?= $question->id ?>', 'Delete Question', 'Are you sure you want to delete this question?', '')">
                                    <i class="fa fa-times-circle"></i> Delete
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>

            <?php
            $k++;
        endforeach;

        if (empty($questions->toArray())) {
            ?>
            <tr>
                <td colspan="3">No questions found.</td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>

    <?= $this->element('bottomPagination', ['paginator' => $this->Paginator]); ?>

</div>

<script>
    $(document).ready(function () {
        $('#subject').select2({
            placeholder: '-',
        });
        $('#level').select2({
            placeholder: '-',
        });
        $('#difficulty-level').select2({
            placeholder: '-',
        });
        $('#tags').select2({
            placeholder: '-',
        });
    })
</script>
