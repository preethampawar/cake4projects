<?php
$data = null;
foreach($tags as $tag) {
    $data[(string)$tag->name] = (string)$tag->name;
}

echo $this->Form->control('tags', [
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
