<?php
$data = null;
$empty = isset($empty) ? $empty : null;
$multiple = isset($multiple) ? $multiple : false;

foreach($educationLevels as $educationLevel) {
    $data[$educationLevel->name] = $educationLevel->name;
}
echo $this->Form->control('level', [
    'type' => 'select',
    'label' => false,
    'class' => 'form-control form-control-sm',
    'options' => $data,
    'escape' => false,
    'default' => $selected,
    'empty' => $empty,
    'multiple' => $multiple,
]);
?>
