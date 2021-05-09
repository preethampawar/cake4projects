<?php
$data = null;
$selected = $selected ?? null;

if (isset($empty)) {
    if ($empty === true) {
        $empty = 'Show All';
    } elseif (empty($empty)) {
        $empty =false;
    }
} else {
    $empty = false;
}

foreach($exams as $exam) {
    $data[$exam->id] = (string)$exam->name;
}

echo $this->Form->control('exam_id', [
    'type' => 'select',
    'label' => false,
    'class' => 'form-control form-control-sm',
    'options' => $data,
    'escape' => false,
    'empty' => $empty,
    'multiple' => false,
    'value' => $selected
]);
?>
