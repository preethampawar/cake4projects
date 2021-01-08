<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/patients/">Patients</a></li>
    <li class="breadcrumb-item active" aria-current="page">Register</li>
  </ol>
</nav>

<div class="text-end">
    <a class="btn btn-sm btn-danger" href="/patients/">Cancel</a>
</div>

<h1 class="mb-4">Register Patient</h1>

<?php
    echo $this->Form->create($patient);
?>

<?php
	echo $this->Form->control('opd_no', ['class' => 'form-control mb-3']);
	echo $this->Form->control('name', ['class' => 'form-control mb-3']);
	echo $this->Form->control('phone', ['class' => 'form-control mb-3']);
	echo $this->Form->control('age', ['class' => 'form-control mb-3']);
	echo $this->Form->control('sex', ['class' => 'form-control mb-3', 'list' => 'UserSex']);
	echo $this->Form->control('address', ['rows' => '3', 'class' => 'form-control mb-3']);
	echo $this->Form->control('blood_group', ['class' => 'form-control mb-3', 'list' => 'UserBloodGroup']);
	echo $this->Form->control('join_date', ['type' => 'date', 'class' => 'form-control mb-3', 'default' => date('Y-m-d')]);
?>

<div class="mt-4">
    <?= $this->Form->button(__('Save Details'), ['class' => 'btn btn-sm btn-primary']) ?>

    <a class="mx-3 btn btn-sm btn-danger" href="/patients/">Cancel</a>
</div>

<datalist id="UserSex">
  <option value="M">
  <option value="F">
  <option value="Other">
</datalist>

<datalist id="UserBloodGroup">
  <option value="A+">
  <option value="A-">
  <option value="B+">
  <option value="B-">
  <option value="O+">
  <option value="O-">
  <option value="AB+">
  <option value="AB-">
</datalist>

<?php
    echo $this->Form->end();
?>
