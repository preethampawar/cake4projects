<h1>Bills List</h1>

<div class="text-end">
    <a class="btn btn-primary btn-sm" href="/billings/add-step1">+ Add New Bill</a>
</div>

<div>
    <div>
        <b><?php echo $this->Paginator->counter(
                'Total Records: {{count}}'
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
    <table class="table table-sm small mt-3 table-hover">
	<thead>
    <tr>
        <th>#</th>
        <th>Date</th>
        <th>OPD No.</th>
        <th>Amount</th>
        <th>Patient Name</th>
        <th>Age</th>
        <th>Sex</th>
        <th>Treatment</th>
        <th></th>
    </tr>
	</thead>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

	<tbody>
    <?php
    $i = 0;
	foreach ($billings as $billing):
        $i++;
	?>

	<tr>
        <td>
            <a href="/billings/view/<?= $billing->id ?>" title="Details - <?= $billing->patient_name ?>" class=""><?= $i ?></a>
        </td>
		<td>
            <?= $billing->bill_date->format('d/m/Y') ?>
		</td>
        <td>
            <?= $billing->opd_no ?>
        </td>
        <td>
            <?= $billing->amount ?>
        </td>
        <td>
            <?= $billing->patient_name ?>
        </td>
        <td>
            <?= $billing->age ?>
        </td>
        <td>
            <?= $billing->sex ?>
        </td>
        <td>
            <?= $billing->treatment ?>
        </td>
        <td class="text-end">
            <a href="/billings/add/<?= $billing->patient_id ?>" title="Create New Bill - <?= $billing->patient_name ?>" class="btn btn-sm py-0 btn-primary">+New Bill</a>
            <a href="/billings/view/<?= $billing->id ?>" title="Details - <?= $billing->patient_name ?>" class="btn btn-sm py-0 btn-secondary ms-1">Details</a>

            <a href="/billings/edit/<?= $billing->id ?>" title="Edit - <?= $billing->patient_name ?>" class="btn btn-sm py-0 btn-secondary ms-1">Edit Bill</a>
        </td>

    </tr>

	<?php
	endforeach;
	?>
	</tbody>
</table>
</div>
