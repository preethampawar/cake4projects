<h1>Candidates</h1>

<div>
    <div>
        <b><?php echo $this->Paginator->counter(
                'Total: {{count}}'
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
    <table class="table small">
        <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Tests</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $k = 0;
        foreach ($users as $user):
            $k++;
            ?>

            <tr>
                <td>
                    <?= $k ?>.
                </td>
                <td>
                    <?= $user->username ?>
                </td>
                <td>
                    <?= $user->name ?>
                </td>
                <td>
                    <?= $user->phone ?>
                </td>
                <td>
                    <?= $stats[$user->id]['exams_attended'] ?? 0 ?>
                </td>
                <td class="text-end">
                    <a href="/UserExams/userAttendedExams/<?= $user->id ?>" class="btn btn-primary btn-sm py-0">
                        Results
                    </a>
                 </td>
            </tr>
        <?php
        endforeach;

        if (empty($users->toArray())) {
            ?>
            <tr><td colspan="4">No users found.</td></tr>
            <?php
        }

        ?>
        </tbody>
    </table>
</div>
