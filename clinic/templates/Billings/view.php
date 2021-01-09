<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/billings/">Billings</a></li>
        <li class="breadcrumb-item active" aria-current="page">Bill Details</li>
    </ol>
</nav>


<div class="text-end">
    <a class="btn btn-sm btn-danger" href="/billings/">Back</a>
</div>

<h1>Bill Details - <?= h($billing->patient_name) ?></h1>

<table class="table table-sm small table-striped table-bordered mt-3">
	<tbody>

	<tr>
		<th class="w-25">OPD No.</th>
		<td>
			<?= $billing->opd_no ?>
		</td>
	</tr>
	<tr>
		<th>Patient Name</th>
        <td>
            <?= $billing->patient_name ?>
        </td>
	</tr>
	<tr>
		<th>Age</th>
		<td>
            <?= $billing->age ?>
        </td>
    </tr>
	<tr>
		<th>Sex</th>
		<td>
            <?= $billing->sex ?>
        </td>
    </tr>
	<tr>
		<th>Treatment</th>
		<td>
            <?= $billing->treatment ?>
        </td>
    </tr>
	<tr>
		<th>Amount</th>
		<td>
            <?= $billing->amount ?>
        </td>
    </tr>

	</tbody>
</table>

