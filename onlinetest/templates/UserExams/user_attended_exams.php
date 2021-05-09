<?php
$examId = $examId ?? null;
$userId = $userId ?? null;
?>
<h1>Results</h1>

<div class="mt-3">
    <div class="alert bg-light">
        <label class="small ">Filter</label>
        <div id="examGroupsDivAddQuestionForm" class="row justify-content-start">
            <div class="col-sm-12 col-md-3 mb-3">
                <?= $this->element('examsDropDown', ['exams' => $exams, 'selected' => $examId, 'empty' => 'Select Exam']) ?>
            </div>
            <div class="col-sm-12 col-md-3 mb-3">
                <?= $this->element('usersDropDown', ['users' => $users, 'selected' => $userId, 'empty' => 'Select User']) ?>
            </div>
            <div class="col-sm-12 col-md-3 mb-3">
                <button type="button" class="btn btn-primary btn-sm" onclick="searchUserAttendedExams()">Search</button>
            </div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table mt-3">
        <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <?php if (!$examId) { ?><th>Exam</th><?php } ?>
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
                <?php if (!$examId) { ?>
                <td>
                    <?= $exam['name'] ?>
                    <div class="text-muted small">
                        <?= $exam['total_questions'] ?> Questions,
                        <?= $exam['duration'] ?> mins

                    </div>
                </td>
                <?php } ?>
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
            <tr><td colspan="6">No users found.</td></tr>
            <?php
        }

        ?>
        </tbody>
    </table>
</div>
<script>
    function searchUserAttendedExams()
    {
        let userId = null
        if ($('#user-id').val() != '') {
            userId = $('#user-id').val()
        }

        let examId = null
        if ($('#exam-id').val() != '') {
            examId = $('#exam-id').val()
        }

        window.location = '/UserExams/userAttendedExams/' + userId + '/'+ examId;
    }
</script>
