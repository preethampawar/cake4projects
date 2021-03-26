<h1>Exams List</h1>

<div class="">
    <b><?php echo $this->Paginator->counter(
            'Total Exams: {{count}}'
        ); ?></b>
</div>
<div class="table-responsive">
    <table class="table table-sm small mt-3">
        <thead>
        <tr>
            <th style="width: 50px;">#</th>
            <th>Exam Name</th>
            <th>Duration</th>
            <th>End Date</th>
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
                    <?= $exam->name ?>
                </td>
                <td>
                    <?= $exam->time ?> mins
                </td>
                <td>
                    <?= $exam->end_date->format('d/m/Y h:i A') ?>
                </td>
                <td>
                    <a href="/userexams/view/<?= base64_encode($exam->id) ?>" title="<?= $exam->name ?>" class="">Take Online Test</a>

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



    <div class="d-flex mt-4">
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
