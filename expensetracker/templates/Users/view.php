<div class="text-end">
    <a class="btn btn-sm btn-secondary" href="/billings/">Back</a>
</div>

<h4>Bill Details</h4>

<table class="table table-bordered table-sm small mt-3">
	<tbody>

	<tr>
		<th class="w-25">Date</th>
		<td>
			<?= $billing->bill_date->format('d/m/Y') ?>
		</td>
	</tr>
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
		<th>Treatment Type</th>
		<td>
            <?= $billing->treatment_type === 'clinic' ? 'Clinic' : 'Home Visit' ?>
        </td>
    </tr>
	<tr>
		<th>Consultation Fee</th>
		<td>
            <?= $billing->consultation_fee ?>
        </td>
    </tr>
	<tr>
		<th>Seatings</th>
		<td>
            <?= $billing->seatings ?>
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

