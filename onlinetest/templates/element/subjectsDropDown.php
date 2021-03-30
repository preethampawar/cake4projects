<?php
$data = null;
$empty = isset($empty) ? $empty : null;
$multiple = isset($multiple) ? $multiple : false;

foreach($subjects as $subject) {
    $data[$subject->name] = $subject->name;
}
echo $this->Form->control('subject', [
    'type' => 'select',
    'label' => false,
    'class' => 'form-control form-control-sm',
    'options' => $data,
    'escape' => false,
    'default' => $selectedSubject,
    'multiple' => $multiple,
]);
?>
