<?= $this->element('myTestsNav');?>


<h1>Online Exams</h1>

<div class="">
    <?php echo $this->Paginator->counter(
            'Total: {{count}}'
        ); ?>
</div>
<div class="table-responsive">
    <table class="table small mt-3 table-hover">
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
                    <?= $exam->name ?>
                    <div class="text-muted">
                        <?= $exam->time ?> mins
                    </div>
                </td>
                <td>
                    <a href="/UserExams/view/<?= base64_encode($exam->id) ?>" title="<?= $exam->name ?>" class="btn btn-sm btn-primary">Online Test</a>

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

        <?= $this->element('bottomPagination', ['paginator' => $this->Paginator]); ?>

</div>
