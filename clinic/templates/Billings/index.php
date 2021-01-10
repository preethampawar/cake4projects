<h1>Billing</h1>

<div class="text-end">
    <a class="btn btn-primary btn-sm" href="/billings/add-step1">+ Add New Bill</a>
</div>

<table class="table table-sm small mt-3">
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
        <td><?= $i ?></td>
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
        <td>
            <a href="/billings/view/<?= $billing->id ?>" title="Details - <?= $billing->patient_name ?>" class="">Details</a>
            &nbsp;|&nbsp;
            <a href="/billings/edit/<?= $billing->id ?>" title="Edit - <?= $billing->patient_name ?>" class="">Edit</a>
        </td>

    </tr>

	<?php
	endforeach;
	?>
	</tbody>
</table>
