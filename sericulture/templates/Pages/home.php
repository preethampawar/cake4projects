<div class="text-center">
    <h1>Track Silkworm Rearing</h1>
</div>

<?php
if ($this->request->getSession()->check('User.isAdmin') &&
    $this->request->getSession()->read('User.isAdmin') == true) {
    ?>
    <div class="row mt-5">

        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    Exams
                </div>
                <div class="card-body">
                    <p>
                        <a class="my-3" href="/exams/add">Add New Exam</a>
                    </p>
                    <p>
                        <a class="my-3" href="/exams/">Exams List</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    Questions
                </div>
                <div class="card-body">
                    <p>
                        <a class="my-3" href="/questions/add">Add New Question</a>
                    </p>
                    <p>
                        <a class="my-3" href="/questions/">Question Bank</a>
                    </p>
                </div>
            </div>
        </div>

    </div>

    <?php
} else {
    ?>
    <div class="row mt-5">

        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    Rearing Batches
                </div>
                <div class="card-body">
                    <p>
                        <a class="my-3" href="/Batches/add">Add New Batch</a>
                    </p>
                    <p>
                        <a class="my-3" href="/Batches/">Batch List</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    Activities
                </div>
                <div class="card-body">
                    <p>
                        <a class="my-3" href="/Activities/selectBatch">Add New Activity</a>
                    </p>
                    <p>
                        <a class="my-3" href="/Activities/">Show All Activities</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
    <?php
}
?>

