<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/patients/">Patients</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= h($patient->name) ?></li>
  </ol>
</nav>

<div class="text-end">
    <a class="btn btn-primary btn-sm" href="/case-sheets/add/<?= $patient->id ?>">+ Add New Case Sheet</a>
    &nbsp;
    <a class="btn btn-secondary btn-sm" href="/patients/">Back</a>
</div>

<h1><?= h($patient->name) ?></h1>
<p><small>Join Date: <?= $patient->join_date->format('d-m-Y') ?></small></p>


<div class="bg-light p-2 rounded">
    <table class="table table-sm small">
        <tbody>

        <tr>
            <th class="w-25">Id</th>
            <td>
                <?= $patient->id ?>
            </td>
        </tr>
        <tr>
            <th class="w-25">OPD No.</th>
            <td>
                <?= $patient->opd_no ?>
            </td>
        </tr>
        <tr>
            <th>Name</th>
            <td>
                <?= $patient->name ?> (<?= $this->Html->link('Edit', ['action' => 'edit', $patient->id]) ?>)
            </td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>
                <?= $patient->phone ?>
            </td>
        </tr>
        <tr>
            <th>Age</th>
            <td>
                <?= $patient->age ?>
            </td>
        </tr>
        <tr>
            <th>Sex</th>
            <td>
                <?= $patient->sex ?>
            </td>
        </tr>
        <tr>
            <th>Address</th>
            <td>
                <?= $patient->address ?>
            </td>
        </tr>
        <tr>
            <th>Blood Group</th>
            <td>
                <?= $patient->blood_group ?>
            </td>
        </tr>
        <tr>
            <th>Join Date</th>
            <td>
                <?= $patient->join_date->format('d/m/Y') ?>
            </td>
        </tr>
        <tr>
            <th>Referred By</th>
            <td>
                <?= $patient->referred_by ?>
            </td>
        </tr>

        </tbody>
    </table>
</div>

<h4 class="mt-5">Case Sheet </h4>

<?php
if ($patient->case_sheets) {
?>
    <?php
    $i = 0;
    $count = count($patient->case_sheets);
    foreach ($patient->case_sheets as $caseSheet):
        $i++;
        ?>
        <div class="bg-light rounded mb-3 p-2">
            <div class="text-end">
                &nbsp;&nbsp;
                <a href="/case-sheets/edit/<?= $caseSheet->id ?>" class="btn btn-sm btn-primary">Edit</a>
                &nbsp;&nbsp;
                <?= $this->Form->postLink(
                    'Delete',
                    ['controller' => 'case-sheets', 'action' => 'delete', $caseSheet->id],
                    ['confirm' => 'Are you sure?', 'class' => 'btn btn-sm btn-danger'])
                ?>

            </div>

            <table class="table small table-sm">
                <tbody>
                <tr>
                    <th>No.</th>
                    <td><b>#<?= $count ?></b></td>
                </tr>
                <tr>
                    <th class="w-25">Date</th>
                    <td>
                        <?= $caseSheet->date->format('d/m/Y') ?>
                    </td>
                </tr>
                <tr>
                    <th>Seatings</th>
                    <td>
                        <?= $caseSheet->seatings ?>
                    </td>
                </tr>
                <tr>
                    <th>Past History</th>
                    <td><?= $caseSheet->past_history ?></td>
                </tr>
                <tr>
                    <th>Present History</th>
                    <td><?= $caseSheet->present_history ?></td>
                </tr>
                <tr>
                    <th>Diagnosis</th>
                    <td><?= $caseSheet->diagnosis ?></td>
                </tr>
                <tr>
                    <th>Treatment</th>
                    <td><?= $caseSheet->treatment ?></td>
                </tr>
                </tbody>
            </table>
        </div>

    <?php
        $count--;
    endforeach;
    ?>
<?php
}




