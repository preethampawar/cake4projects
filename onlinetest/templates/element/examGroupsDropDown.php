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

foreach($examGroups as $examGroup) {
    $data[$examGroup->id] = (string)$examGroup->name;
}

echo $this->Form->control('exam_group_id', [
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
