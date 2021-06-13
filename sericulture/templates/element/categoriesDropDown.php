<?php
$data = null;
foreach($categories as $category) {
    $data[$category->id] = (string)$category->name;
}

$multiple = $multiple ?? true;

if (isset($empty)) {
    if ($empty === true) {
        $empty = 'Show All';
    } elseif (empty($empty)) {
        $empty =false;
    }
} else {
    $empty = false;
}

echo $this->Form->control('categories', [
    'type' => 'select',
    'label' => false,
    'class' => 'form-control form-control-sm',
    'options' => $data,
    'escape' => false,
    'value' => $selected,
    'empty' => $empty,
    'multiple' => $multiple
]);
?>
