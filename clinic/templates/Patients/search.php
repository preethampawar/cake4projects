<nav aria-label="breadcrumb">
  <ol class="breadcrumb alert bg-light border">
    <li class="breadcrumb-item"><a href="/patients/">Patients</a></li>
    <li class="breadcrumb-item active" aria-current="page">Search</li>
  </ol>
</nav>

<div class="text-end">
    <a class="btn btn-sm btn-danger" href="/patients/">Cancel</a>
</div>

<h1 class="mb-4">Search</h1>

<?php
    echo $this->Form->create();
?>

<div class="alert bg-light border">
    <div class="row">
        <div class="col-12 col-sm-4 col-lg-3">
            <?php echo $this->Form->control('keyword', ['label' => 'Keyword', 'class' => 'form-control mb-3']); ?>
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
    <h4 class="mt-5"><?= count($result) ?> record(s) found:</h4>
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

        <tbody id="tableBody">
        <?php
        foreach ($result as $patient) :
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
                    <?= $this->Html->link($patient->name, ['action' => 'view', $patient->id]) ?>
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
                    <a href="/patients/view/<?= $patient->id ?>" title="Details - <?= $patient->name ?>" class="">Details</a>
                    &nbsp;|&nbsp;
                    <a href="/patients/edit/<?= $patient->id ?>" title="Edit - <?= $patient->name ?>" class="">Edit</a>
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
}
