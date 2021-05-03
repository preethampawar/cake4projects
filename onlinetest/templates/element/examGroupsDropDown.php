<?php
$data = null;
$selected = $selected ?? null;
$empty = isset($empty) && $empty === true ? 'Show All' : false;
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
