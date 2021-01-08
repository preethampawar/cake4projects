<h1>Patients</h1>

<div class="text-end">
	<a class="btn btn-primary btn-sm" href="/patients/add">Register Patient</a>
</div>

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

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

	<tbody>
    <?php
	foreach ($patients as $patient):
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
