<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/patients/">Patients</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= $patient->name ?></li>
  </ol>
</nav>

<h1>Add Case Sheet - <?= $patient->name ?></h1>

<?php
    echo $this->Form->create($caseSheet);
?>

<div class="text-end">
    <a class="btn btn-sm btn-danger" href="/patients/view/<?= $patient->id ?>">Cancel</a>
</div>

<?php
echo $this->Form->control('patient_id', ['type' => 'hidden', 'value' => $patient->id]);
echo $this->Form->control('date', ['type' => 'date', 'class' => 'form-control mb-3', 'default' => date('Y-m-d')]);
echo $this->Form->control('seatings', ['label' => 'Seatings *', 'class' => 'form-control mb-3', 'required' => true]);
echo $this->Form->control('past_history', ['rows' => '3', 'class' => 'form-control mb-3']);
echo $this->Form->control('present_history', ['rows' => '3', 'class' => 'form-control mb-3']);
echo $this->Form->control('diagnosis', ['rows' => '3', 'class' => 'form-control mb-3']);
echo $this->Form->control('treatment', ['label' => 'Treatment *', 'rows' => '3', 'class' => 'form-control mb-3', 'required' => true]);
?>

<div class="mt-4">
    <?= $this->Form->button(__('+ Add Case Sheet'), ['class' => 'btn btn-primary']) ?>
</div>

<?php
    echo $this->Form->end();
?>
