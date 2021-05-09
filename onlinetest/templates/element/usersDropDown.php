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

foreach($users as $user) {
    $username = $user->username ?? null;

    $data[$user->id] = (string)$user->name . ' ('. (string)$username . ')';
}

echo $this->Form->control('user_id', [
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
