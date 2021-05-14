<nav aria-label="breadcrumb">
  <ol class="breadcrumb alert bg-light border">
    <li class="breadcrumb-item"><a href="/patients/">Patients</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= h($patient->name) ?></li>
  </ol>
</nav>

<h1><?= h($patient->name) ?></h1>
<p><small>Join Date: <?= $patient->join_date->format('d-m-Y') ?></small></p>

<div class="text-end">
    <a class="btn btn-danger" href="/patients/">Back</a>
</div>

<table class="table mt-3">
	<tbody>

	<tr>
		<th>Id</th>
		<td>
			<?= $patient->id ?>
		</td>
	</tr>
	<tr>
		<th>OPD No.</th>
		<td>
			<?= $patient->opd_no ?>
		</td>
	</tr>
	<tr>
		<th>Name</th>
        <td>
            <?= $this->Html->link($patient->name, ['action' => 'view', $patient->id]) ?>
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

