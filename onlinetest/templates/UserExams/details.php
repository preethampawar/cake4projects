<h1>User Exam Details</h1>

<div class="table-responsive">
    <table class="table mt-3">
        <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>Exam</th>
            <th>Score</th>
            <th>Attended On</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $k = 0;
        foreach ($stats as $user):
            foreach($user['Exams'] as $exam):
                foreach($exam['UserExams'] as $userExam):
                    $k++;
            ?>

            <tr>
                <td>
                    <?= $k ?>.
                </td>
                <td>
                    <?= $user['username'] ?>
                </td>
                <td>
                    <b><?= $exam['name'] ?></b>
                    <div class="text-muted small">
                        <?= $exam['total_questions'] ?> Questions,
                        <?= $exam['duration'] ?> mins <br>
                        <span class="btn btn-success btn-sm py-0">Correct: <?= $userExam['correct'] ?></span>
                        <span class="btn btn-danger btn-sm py-0">Wrong: <?= $userExam['wrong'] ?></span>
                        <span class="btn btn-warning btn-sm py-0">Not Attempted: <?= $userExam['not_attempted'] ?></span>

                    </div>
                </td>
                <td>
                    <b><?= $userExam['score_percentage'] ?>%</b>
                </td>
                <td>
                    <?= date('d/m/Y H:i', strtotime($userExam['created'])) ?>
                </td>
                <td class="text-end">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-sm btn-primary py-0" data-bs-toggle="modal" data-bs-target="#UserModal<?= $user['id'] ?>">
                        Details
                    </button>

                    <!-- Modal -->
                    <div class="text-start modal fade" id="UserModal<?= $user['id'] ?>" tabindex="-1" aria-labelledby="UserModal<?= $user['id'] ?>Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div>
                                        <h5 class="modal-title" id="exampleModalLabel">Attended Exam Details</h5>
                                        <span class="text-muted">(<?= $user['username'] ?>)</span>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    if(isset($stats[$user['id']]) and !empty($stats[$user['id']]['Exams'])) {
                                        ?>
                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                   <th>#</th>
                                                   <th>Exam Name</th>
                                                   <th class="text-center">No. of Attempts</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $i=1;
                                                foreach($stats[$user['id']]['Exams'] as $exam) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $i ?>.</td>
                                                        <td><?= $exam['name'] ?></td>
                                                        <td class="text-center">
                                                            <?php
                                                            if ((int)$exam['attempts'] > 0) {
                                                            ?>
                                                            <a href="/UserExams/details/<?= $user['id'] ?>/<?= $exam['id'] ?>">
                                                                <?= $exam['attempts'] ?>
                                                            </a>
                                                            <?php
                                                            } else {
                                                                echo '-';
                                                            }
                                                            ?>

                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>

                                        <div class="text-center mb-3 mt-4">
                                            <a href="/UserExams/details/<?= $user['id'] ?>" class="btn btn-orange">
                                                Click for more details
                                            </a>
                                        </div>

                                        <?php
                                    } else {
                                        echo 'This user has not attended any exam';
                                    }
                                    ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php
                endforeach;
            endforeach;
        endforeach;

        if (empty($stats)) {
            ?>
            <tr><td colspan="4">No users found.</td></tr>
            <?php
        }

        ?>
        </tbody>
    </table>
</div>
