<h1>Exams - Topics View</h1>

<div class="text-end">
    <a class="btn btn-primary btn-sm" href="/exams/add">+ New Exam</a>
    <a class="btn btn-maroon btn-sm ms-2" href="/exams/">List View</a>
    <a class="btn btn-maroon btn-sm" href="/exams/groupView">Topics View</a>
</div>

<div>
    <div>
        <b><?php echo $this->Paginator->counter(
                'Total Exam Topics: {{count}}'
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
            <th>Exam Group</th>
            <th class="text-end">Total Exams</th>
        </tr>
        </thead>

        <tbody>
        <?php
        $k = 0;
        foreach ($examGroups as $examGroup):
            if ($examGroup->exams_deleted == true) {
                continue;
            }

            $k++;
            ?>

            <tr>
                <td>
                    <?= $k ?>.
                </td>
                <td>
                    <div class="">
                        <a href="/Exams/index/<?= $examGroup->id ?>" title="Show all exams in this group" class=""><?= $examGroup->name ?></a>
                    </div>
                </td>
                <td class="text-end">
                    <?php if ($examGroup->exams_count > 0){ ?>
                    <a href="/Exams/index/<?= $examGroup->id ?>" title="Show all exams in this group" class=""><?= $examGroup->exams_count ?></a>
                    <?php } else { ?> 0 <?php } ?>
                </td>
            </tr>

        <?php
        endforeach;

        if (empty($examGroups->toArray())) {
            ?>
            <tr><td colspan="3">No exams found.</td></tr>
            <?php
        }

        ?>
        </tbody>
    </table>
</div>
