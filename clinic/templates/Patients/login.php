
<h1 class="my-4">Login</h1>

<?php
    echo $this->Form->create();
?>

<?php
	echo $this->Form->control('user', ['type' => 'text', 'label' => 'User *', 'class' => 'form-control mb-3', 'required' => true]);
	echo $this->Form->control('kunji', ['type' => 'password', 'label' => 'Password *', 'class' => 'form-control mb-3', 'required' => true]);
?>

<div class="mt-4">
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-md btn-primary']) ?>
</div>

<?php
    echo $this->Form->end();
?>
