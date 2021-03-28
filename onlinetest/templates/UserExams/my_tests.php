<?= $this->element('myTestsNav');?>


<h1>My Tests</h1>

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
            <th>Attempted Exams</th>
            <th>Date</th>
            <th></th>
        </tr>
        </thead>

        <!-- Here is where we iterate through our $articles query object, printing out article info -->

        <tbody>
        <?php
        $k = 0;
        foreach ($userExams as $userExam):
            $exam = $userExam->exam;
            $k++;
            ?>

            <tr>
                <td>
                    <?= $k ?>.
                </td>
                <td>
                    <?= $exam->name ?>
                    <span class="text-muted">(<?= $exam->time ?> mins)</span>
                </td>
                <td>
                    <?= $userExam->created->format('d/m/Y') ?>
                </td>
                <td>
                    <?php
                    if ($userExam->cancelled) {
                        ?>
                        <span class="text-danger">Cancelled</span>
                        <?php
                    } else {
                        ?>
                        <a href="/UserExams/myResult/<?= base64_encode($userExam->id) ?>" title="<?= $exam->name ?>" class="btn btn-sm btn-primary py-0">Show Result</a>
                        <?php
                    }
                    ?>
                </td>
            </tr>

        <?php
        endforeach;
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
