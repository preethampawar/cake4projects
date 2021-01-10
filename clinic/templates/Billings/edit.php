<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/billings/">Billings</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit bill for <?= $billing->patient_name ?></li>
    </ol>
</nav>

<h1>Edit Bill Details - <?= $billing->patient_name ?></h1>

<?php
echo $this->Form->create($billing);
?>

<div class="text-end">
    <a class="btn btn-sm btn-danger" href="/billings/">Cancel</a>
</div>

<?php
echo $this->Form->control('bill_date', ['label' => 'Bill Date *', 'type' => 'date', 'required' => true, 'class' => 'form-control mb-3', 'default' => date('Y-m-d')]);
echo $this->Form->control('opd_no', ['label' => 'OPD No. *', 'required' => true, 'class' => 'form-control mb-3', 'default' => $billing->opd_no]);
echo $this->Form->control('name', ['label' => 'Patient Name', 'class' => 'form-control mb-3', 'default' => $billing->patient_name]);
echo $this->Form->control('age', ['label' => 'Age', 'class' => 'form-control mb-3', 'default' => $billing->age]);
echo $this->Form->control('sex', ['label' => 'Sex', 'class' => 'form-control mb-3', 'default' => $billing->sex, 'list' => 'UserSex']);
echo $this->Form->control('treatment', ['rows' => '3', 'class' => 'form-control mb-3']);
echo $this->Form->control('treatment_type', [
    'type' => 'select',
    'label' => 'Treatment Type',
    'class' => 'form-control mb-3',
    'options' => ['clinic' => 'Clinic', 'home_visit' => 'Home Visit'],
    'default' => 'clinic',
]);
echo $this->Form->control('consultation_fee', ['label' => 'Consultation Fee', 'class' => 'form-control mb-3', 'required' => false]);
echo $this->Form->control('seatings', ['label' => 'Seatings *', 'class' => 'form-control mb-3', 'required' => true]);
echo $this->Form->control('amount', ['type' => 'number', 'required' => false, 'label' => 'Amount', 'class' => 'form-control mb-3']);
?>

<div class="mt-4">
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-sm']) ?>
    <a href="/billings/" class="btn btn-sm btn-danger mx-3">Cancel</a>
</div>

<datalist id="UserSex">
    <option value="M">
    <option value="F">
    <option value="Other">
</datalist>

<?php
echo $this->Form->end();
?>
