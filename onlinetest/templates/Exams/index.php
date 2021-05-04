<?php
$categoryList = null;
foreach($categories as $category) {
    $categoryList[$category->id] = (string)$category->name;
}
?>

<h1>Tests List</h1>

<div class="text-end">
    <a class="btn btn-primary btn-sm" href="/exams/add">+ New Test</a>
    <a class="btn btn-maroon btn-sm ms-2" href="/exams/">List View</a>
    <a class="btn btn-maroon btn-sm" href="/exams/groupView">Topics View</a>
</div>

<div class="mt-3 mb-3">
    <div class="alert bg-light">
        <label class="small ">Filter by Topic</label>
        <div id="examGroupsDivAddQuestionForm" class="d-flex justify-content-start">
            <?= $this->element('examGroupsDropDown', ['examGroups' => $examGroups, 'selected' => $examGroupId, 'empty' => true]) ?>
            <button type="button" class="btn btn-primary btn-sm ms-2" onclick="window.location = '/Exams/index/'+$('#exam-group-id').val()">Search</button>
        </div>
    </div>
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

<div class="">
    <table class="table table-sm mt-3">
        <thead>
        <tr>
            <th>#</th>
            <th>Test Name</th>
            <th></th>
        </tr>
        </thead>

        <!-- Here is where we iterate through our $articles query object, printing out article info -->

        <tbody>
        <?php
        $k = 0;
        foreach ($exams as $exam):
            // debug($exam);
            $k++;
            ?>

            <tr>
                <td>
                    <?= $k ?>.
                </td>
                <td>
                    <div class="">
                        <a href="/exams/edit/<?= $exam->id ?>" title="Edit Exam details" class=""><?= $exam->name ?></a>

                        <div class="">
                            <span class="text-muted small">
                                <?= count($exam->exam_questions) ?> questions,
                                <?= $exam->time ?> mins
                            </span>
                        </div>
                        <div>
                            <span class="text-muted">Topic: <a href="/Exams/index/<?= $exam->exam_group->id ?>"><?= $exam->exam_group->name ?></a></span>
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
                    <div class="dropdown">
                        <a class="fs-5" href="#" id="actionsDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-ellipsis-h"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="actionsDropdownMenuLink">
                            <li><a href="/exams/view/<?= $exam->id ?>" title="Show details" class="dropdown-item"><i class="fa fa-info-circle"></i> Preview</a></li>
                            <li><a href="/exams/edit/<?= $exam->id ?>" title="Show details" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a></li>
                            <li>
                                <?php
                                echo $this->Html->link(
                                    '<i class="fa fa-times-circle"></i> Delete',
                                    ['controller' => 'Exams', 'action' => 'delete', $exam->id],
                                    [
                                        'confirm' => 'Are you sure you want to delete this Test?',
                                        'class' => 'dropdown-item',
                                        'title' => $exam->name,
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

        if (empty($exams->toArray())) {
            ?>
            <tr><td colspan="4">No tests found.</td></tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
