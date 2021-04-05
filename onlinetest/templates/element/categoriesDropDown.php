<?php
$data = null;
foreach($categories as $category) {
    $data[$category->id] = (string)$category->name;
}

echo $this->Form->control('categories', [
    'type' => 'select',
    'label' => false,
    'class' => 'form-control form-control-sm vh-100',
    'options' => $data,
    'escape' => false,
    'value' => $selected,
    'empty' => false,
    'multiple' => true
]);
?>
