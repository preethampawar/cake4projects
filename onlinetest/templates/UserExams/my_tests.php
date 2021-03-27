<nav class="navbar navbar-light bg-light d-print-none sticky-top mb-3">
    <div class="container-fluid justify-content-start">
        <a class="nav-link" href="/UserExams/">All Online Exams</a>
        <a class="nav-link active" href="/UserExams/myTests">My Tests</a>
    </div>
</nav>


<h1>My Tests</h1>

<div class="">
    <?php echo $this->Paginator->counter(
            'Total: {{count}}'
        ); ?>
</div>
<div class="table-responsive">
    <table class="table table-sm small mt-3 table-hover">
        <thead>
        <tr>
            <th style="width: 50px;">#</th>
            <th>Attempted Exams</th>
            <th>Duration</th>
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
                </td>
                <td>
                    <?= $exam->time ?> mins
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
                        <a href="/UserExams/myResult/<?= base64_encode($userExam->id) ?>" title="<?= $exam->name ?>" class="btn btn-sm btn-primary py-0">My Result</a>
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
