<?= $this->element('adminUsersNav') ?>

<h1>User Attended Exams</h1>

<div class="table-responsive">
    <table class="table mt-3">
        <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>Exam</th>
            <th>Score</th>
            <th>Date</th>
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
                    <?= $exam['name'] ?>
                    <div class="text-muted small">
                        <?= $exam['total_questions'] ?> Questions,
                        <?= $exam['duration'] ?> mins

                    </div>
                </td>
                <td>
                    <div class="d-flex">
                        <div class="pe-2">
                            <span class="fw-bold"><?= $userExam['score_percentage'] ?></span><span class="small">%</span>
                        </div>
                        <div class="ps-2 small border-start">
                            <span class="text-success"><?= $userExam['correct'] ?> - Correct</span><br>
                            <span class="text-danger"><?= $userExam['wrong'] ?> - Wrong</span><br>
                            <span class="text-warning"><?= $userExam['not_attempted'] ?> - Not Attempted</span>
                        </div>
                    </div>
                </td>
                <td>
                    <?= date('d/m/Y', strtotime($userExam['created'])) ?>
                </td>
                <td class="text-end">
                    <span
                        class="btn btn-sm btn-danger py-0"
                        onclick="popup.confirm('/UserExams/delete/<?= $userExam['id'] ?>', 'Delete User Exam', 'Are you sure you want to delete this exam <b><?= htmlentities($exam['name']) ?></b> for username <b><?= $user['username'] ?></b>', '')">
                        X
                    </span>
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
