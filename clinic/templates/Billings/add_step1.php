<nav aria-label="breadcrumb">
  <ol class="breadcrumb alert bg-light border">
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

<div class="alert bg-light border">
    <div class="row">
        <div class="col-12 col-sm-4 col-lg-3">
            <?php echo $this->Form->control('keyword', ['label' => 'Keyword', 'class' => 'form-control mb-3', 'placeholder' => "Enter Name (or) OPD No. (or) Phone No."]); ?>
        </div>

        <div class="col-12 col-sm-4 col-lg-3">
            <?php
            echo $this->Form->control('type', [
                'type' => 'select',
                'label' => 'Search By',
                'class' => 'form-control mb-3',
                'empty' => 'All',
                'options' => ['phone' => 'Phone No.', 'opd_no' => 'OPD No.', 'name' => 'Name'],
                'default' => '',

            ]);
            ?>

        </div>

        <div class="col-12 col-sm-4 col-lg-3">
            <br>
            <button type="submit" class="btn btn-primary w-100">Find</button>
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
    <table class="table table-sm small mt-3 table-hover">
        <thead>
        <tr>
            <th style="width:75px;" class="text-center">OPD No.</th>
            <th style="width:110px;">Registered On</th>
            <th>Name</th>
            <th>Age</th>
            <th>Sex</th>
            <th>Phone</th>
            <th></th>
        </tr>
        </thead>

        <tbody id="tableBody">
        <?php
        foreach ($result as $patient):
            ?>

            <tr>
                <td class="text-center">
                    <?= $patient->opd_no ?>
                </td>
                <td>
                    <?= $patient->join_date->format('d/m/Y') ?>
                </td>
                <td>
                    <a href="/billings/add/<?= $patient->id ?>" title="Select Patient: OPD No. <?= $patient->opd_no ?> - <?= $patient->name ?>" class=""><?= $patient->name ?></a>
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
                <td class="text-end">
                    <a href="/billings/add/<?= $patient->id ?>" title="OPD No. <?= $patient->opd_no ?> - <?= $patient->name ?>" class="btn btn-sm py-0 btn-primary">Select</a>
                </td>

            </tr>

        <?php
        endforeach;
        ?>
        </tbody>
    </table>

    <script type="text/javascript">
        var term = "<?= $this->getRequest()->getData('keyword') ?>";

        if (term.length > 0) {
            $('#tableBody').html(function () {
                return $(this).html().replace(new RegExp(term + "(?=[^>]*<)","ig"), "<span class='bg-ivory'>$&</span>");
            });
        }
    </script>
    <?php
} else {
    ?>
    <p class="mt-4">No records found.</p>

    <?php
}
