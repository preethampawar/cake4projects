<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/billings/">Billings</a></li>
    <li class="breadcrumb-item active" aria-current="page">Step1 - Select Patient</li>
  </ol>
</nav>

<div class="text-end">
    <a class="btn btn-sm btn-primary mx-3" href="/billings/add">Skip to Step-2</a>
    <a class="btn btn-sm btn-danger" href="/billings/">Cancel</a>
</div>

<h1 class="mb-3">Step1 - Select Patient</h1>

<?php
echo $this->Form->create();
?>
<div class="card">


    <div class="d-flex card-body">
        <div>
            <?php
            echo $this->Form->control('keyword', ['label' => 'Search Keyword', 'class' => 'form-control mb-3', 'placeholder' => 'Enter OPD no. (or) Phone (or ) Name']);
            ?>
        </div>
        <div class="mx-4">
            <?php
            echo $this->Form->control('type', [
                'type' => 'select',
                'label' => 'Search By',
                'class' => 'form-control mb-3',
                'empty' => false,
                'options' => ['opd_no' => 'OPD No.', 'phone' => 'Phone No.', 'name' => 'Name', 'id' => 'Id'],
                'default' => 'opd_no'
            ]);
            ?>
        </div>
        <div class="mt-4">
            <?= $this->Form->button(__('Search'), ['class' => 'btn btn-md btn-primary']) ?>
        </div>
    </div>
</div>

<?php
echo $this->Form->end();
?>


<?php
if ($result) {
    ?>
    <h4 class="mt-4"><?= count($result) ?> record(s) found:</h4>
    <table class="table table-sm small mt-3">
        <thead>
        <tr>
            <th style="width:30px;">Id</th>
            <th style="width:75px;">OPD No.</th>
            <th>Registered On</th>
            <th>Name</th>
            <th>Age</th>
            <th>Sex</th>
            <th>Phone</th>
            <th></th>
        </tr>
        </thead>

        <tbody>
        <?php
        foreach ($result as $patient):
            ?>

            <tr>
                <td class="text-center">
                    <?= $patient->id ?>
                </td>
                <td class="text-center">
                    <?= $patient->opd_no ?>
                </td>
                <td>
                    <?= $patient->join_date->format('d/m/Y') ?>
                </td>
                <td>
                    <?= $patient->name ?>
                </td>
                <td>
                    <?= $patient->age ?>
                </td>
                <td>
                    <?= $patient->sex ?>
                </td>
                <td>
                    <?= $patient->phone ?>
                </td>
                <td>
                    <a href="/billings/add/<?= $patient->id ?>" title="Select Patient: OPD No. <?= $patient->opd_no ?> - <?= $patient->name ?>" class="">Select</a>
                </td>

            </tr>

        <?php
        endforeach;
        ?>
        </tbody>
    </table>
    <?php
} else {
    ?>
    <p class="mt-4">No records found.</p>

    <?php
}
