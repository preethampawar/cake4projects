<div class="row">
    <div class="col-md-10">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/exams/">Exams</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Exam Questions</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-2 text-end small">
        <a class="btn btn-sm btn-danger" href="/exams/">Back</a>
    </div>
</div>

<h1><?= $exam->name ?></h1>

<p class="mt-2 small">
    Total Questions: <span class="selectedQuestionsSpan">0</span>
    <br>
    Duration: <?= $exam->time ?> mins
    <!--
    &nbsp;|&nbsp;
    Start Date: <?= $exam->start_date->format('d/m/Y h:i A') ?> &nbsp;|&nbsp;
    End Date: <?= $exam->end_date->format('d/m/Y h:i A') ?>
    -->
</p>

<hr>
<div class="text-end mt-3">
    <a class="btn btn-purple btn-sm py-0" href="#" onclick="$('#FilterQuestionBank').toggleClass('d-none')">Filter</a>
</div>
<div id="FilterQuestionBank" class="alert alert-secondary bg-light d-none mt-3">
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
                            'multiple' => true
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
                    'type' => 'select',
                    'label' => false,
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


<div class="row mt-3">


    <div class="col-sm-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="fw-bold">Question Bank</div>

                <div class="text-end small">
                    <div class="d-inline-flex">Page: <?= $this->Paginator->counter() ?></div>
                    <div class="text-center d-inline-flex ms-3">
                        <ul class="list-unstyled mb-1">
                            <div class="d-inline-flex">
                                <?= $this->Paginator->prev('« Previous') ?>
                            </div>
                            &nbsp;&nbsp;
                            <div class="d-inline-flex">
                                <?= $this->Paginator->next('Next »') ?>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class=""  style="height: 300px; overflow: auto;">
                    <table class="table table-sm table-hover small mb-3">

                        <tbody>
                        <?php
                        $k = $this->Paginator->counter('{{start}}');
                        foreach ($questions as $question):
                            ?>

                            <tr id = "addQuestionRow<?= $question->id ?>">
                                <td><?= $k ?>.</td>
                                <td>
                                    <?= $question->name ?>
                                </td>
                                <td class="text-end">
                                    <button
                                        id = "addQuestionButton<?= $question->id ?>"
                                        class="btn btn-sm btn-primary py-0"
                                        onclick="exams.addExamQuestion('<?= $exam->id ?>', '<?= $question->id ?>')">
                                        Add
                                    </button>
                                </td>
                            </tr>

                            <?php
                            $k++;
                        endforeach;

                        if (empty($questions->toArray())) {
                            ?>
                            <tr>
                                <td colspan="4">No questions found.</td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>

    <div class="col-sm-6">
        <div class="card">
            <div class="card-header fw-bold">
                Selected - <span class="selectedQuestionsSpan">0</span>
            </div>
            <div class="card-body">
                <div class="" id="examSelectedQuestions" style="height: 300px; overflow: auto;">
                    Click "Add" button on the left pane to add questions
                </div>
            </div>
        </div>

    </div>



</div>


<script>
    $( document ).ready(function() {
        exams.loadSelectedExamQuestions('<?= $exam->id ?>')
    });
</script>


<?php
echo $this->Form->create(null);
?>


<?php
echo $this->Form->end();
?>


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
