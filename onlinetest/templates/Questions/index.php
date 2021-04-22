<h1>Question Bank</h1>


<div class="text-end mt-3">
    <a class="btn btn-purple btn-sm" href="#" onclick="$('#FilterQuestionBank').toggleClass('d-none')">Filter</a>
    <a class="btn btn-primary btn-sm ms-3" href="/questions/add">+ Add Question</a>
</div>

<div id="FilterQuestionBank" class="alert alert-secondary bg-light mt-3 d-none">
    <?= $this->Form->create(null, ['method' => 'get']) ?>

    <div class="row">
        <div class="col-sm-4 col-md-4 mb-3">
            <div id="subjectDivAddQuestionForm">
                <div class="">
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
            </div>
        </div>
        <div class="col-sm-4 col-md-4 mb-3">
            <div class="">
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
        </div>
        <div class="col-sm-4 col-md-4 mb-3">
            <div class="">
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
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="">
                <label>Tags</label>
                <div id="tagsDivAddQuestionForm">
                    <?= $this->element('tagsDropDown', ['tags' => $tags, 'selected' => $selectedTags]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3 text-start">
        <button type="submit" class="btn btn-sm btn-primary">Filter Question Bank</button>
    </div>
    <?= $this->Form->end() ?>
</div>


<div class="mt-3">
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
                <td class="pt-2 text-end" style="width:100px;">
                    <a href="/questions/edit/<?= $question->id ?>" title="Edit Question" class="btn btn-sm btn-primary py-0">Edit</a>
                    <span class="btn btn-danger btn-sm py-0 ms-1" onclick="popup.confirm('/Questions/delete/<?= $question->id ?>', 'Delete Question', 'Are you sure you want to delete this question?', '')">X</span>

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


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
