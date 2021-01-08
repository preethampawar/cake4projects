<h1>Case Sheets</h1>

<table class="table mt-3">
	<thead>
    <tr>
        <th>#</th>
        <th>OPD No.</th>
        <th>Date</th>
        <th>Patient Name</th>
        <th>Age</th>
        <th>Sex</th>
        <th>Phone</th>
        <th></th>
    </tr>
	</thead>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

	<tbody>
    <?php
    $i = 0;
	foreach ($caseSheets as $caseSheet):
        $i++;
	?>

	<tr>
        <td><?= $i ?></td>
		<td>
			<?= $caseSheet->opd_no ?>
		</td>
        <td>
            <?= $caseSheet->date->format('d/m/Y') ?>
        </td>
        <td>
            <?= $this->Html->link($caseSheet->patient->name, ['action' => 'view', $caseSheet->id]) ?>
        </td>
        <td>
            <?= $caseSheet->patient->age ?>
        </td>
        <td>
            <?= $caseSheet->patient->sex ?>
        </td>
        <td>
            <?= $caseSheet->patient->phone ?>
        </td>
        <td>
            <a href="/case-sheets/view/<?= $caseSheet->id ?>" title="Details - <?= $caseSheet->patient->name ?>" class="">Details</a>
            &nbsp;|&nbsp;
            <a href="/case-sheets/edit/<?= $caseSheet->id ?>" title="Edit - <?= $caseSheet->patient->name ?>" class="">Edit</a>
        </td>

    </tr>

	<?php
	endforeach;
	?>
	</tbody>
</table>
