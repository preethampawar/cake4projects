
<h1 class="mb-3">Login</h1>
<div class="alert alert-secondary bg-light">
<?php
    echo $this->Form->create();
?>

<?php
	echo $this->Form->control('username', ['type' => 'text', 'label' => 'Username *', 'class' => 'form-control mb-3', 'required' => true]);
	echo $this->Form->control('kunji', ['type' => 'password', 'label' => 'Password *', 'class' => 'form-control mb-3', 'required' => true]);
?>

<div class="mb-3">
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-md btn-primary']) ?>
</div>

<?php
    echo $this->Form->end();
?>
</div>


<div class="mt-4 alert bg-aliceblue">
    Don't have an account?

    <p>
        <a href="/users/register" class="fw-bold mt-3">Click here to register</a>.
    </p>
</div>
