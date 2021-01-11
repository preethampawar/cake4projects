<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/patients/">Patients</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $caseSheet->patient->name ?></li>
    </ol>
</nav>

<div class="text-end">
    <a class="btn btn-sm btn-danger" href="/patients/view/<?= $caseSheet->patient->id ?>">Cancel</a>
</div>

<h1 class="mb-3">Edit Case Sheet</h1>

<div class="mb-3">
    OPD No:  <?= $caseSheet->patient->opd_no ?><br>
    Patient Name:  <?= $caseSheet->patient->name ?>
</div>

<?php
echo $this->Form->create($caseSheet);
?>

<?php
echo $this->Form->control('patient_id', ['type' => 'hidden', 'value' => $caseSheet->patient->id]);
echo $this->Form->control('date', ['type' => 'date', 'class' => 'form-control mb-3', 'default' => date('Y-m-d')]);
echo $this->Form->control('seatings', ['label' => 'Seatings *', 'class' => 'form-control mb-3', 'required' => true]);
echo $this->Form->control('past_history', ['rows' => '3', 'class' => 'form-control mb-3']);
echo $this->Form->control('present_history', ['rows' => '3', 'class' => 'form-control mb-3']);
echo $this->Form->control('diagnosis', ['rows' => '3', 'class' => 'form-control mb-3']);
echo $this->Form->control('treatment', ['label' => 'Treatment *', 'rows' => '3', 'class' => 'form-control mb-3', 'required' => true]);
?>

<div class="mt-4">
    <?= $this->Form->button(__('Save Changes'), ['class' => 'btn btn-sm btn-primary']) ?>
</div>

<?php
echo $this->Form->end();
?>
