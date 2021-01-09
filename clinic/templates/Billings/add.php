<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/billings/">Billings</a></li>
    <li class="breadcrumb-item"><a href="/billings/add-step1">Step1</a></li>
    <li class="breadcrumb-item active" aria-current="page">Step2 - Add bill for <?= $patient->name ?></li>
  </ol>
</nav>

<h1>Add Bill - <?= $patient->name ?: 'Unknown Patient' ?></h1>

<?php
    echo $this->Form->create($billing);
?>

<div class="text-end">
    <a class="btn btn-sm btn-danger" href="/billings/">Cancel</a>
</div>

<?php
echo $this->Form->control('patient_id', ['type' => 'hidden', 'value' => $patient->id]);
echo $this->Form->control('bill_date', ['label' => 'Bill Date *', 'type' => 'date', 'required' => true, 'class' => 'form-control mb-3', 'default' => date('Y-m-d')]);
echo $this->Form->control('opd_no', ['label' => 'OPD No. *', 'required' => true, 'class' => 'form-control mb-3', 'default' => $patient->opd_no]);
echo $this->Form->control('patient_name', ['label' => 'Patient Name', 'class' => 'form-control mb-3', 'default' => $patient->name]);
echo $this->Form->control('age', ['label' => 'Age', 'class' => 'form-control mb-3', 'default' => $patient->age]);
echo $this->Form->control('sex', ['label' => 'Sex', 'class' => 'form-control mb-3', 'default' => $patient->sex, 'list' => 'UserSex']);
echo $this->Form->control('treatment', ['rows' => '3', 'class' => 'form-control mb-3']);
echo $this->Form->control('amount', ['type' => 'number', 'required' => true, 'label' => 'Amount *', 'class' => 'form-control mb-3']);
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
