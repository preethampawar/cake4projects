<h1>Register</h1>

<?php
    echo $this->Form->create(null);
?>

<div class="text-end">
    <a class="btn btn-sm btn-danger" href="/users/login">Cancel</a>
</div>

<div class="row gx-5">
    <div class="col-sm-6">
        <?php
        echo $this->Form->control('name',
            [
                'type' => 'text',
                'label' => 'Full Name *',
                'minlength' => 3,
                'maxlength' => 255,
                'required' => true,
                'class' => 'form-control form-control-sm mb-3',
            ]);
        echo $this->Form->control('username',
            [
                'type' => 'text',
                'label' => 'Username *',
                'minlength' => 3,
                'maxlength' => 55,
                'required' => true,
                'class' => 'form-control form-control-sm mb-3',
            ]);
        echo $this->Form->control('password',
            [
                'type' => 'password',
                'label' => 'Password *',
                'minlength' => 5,
                'maxlength' => 55,
                'required' => true,
                'class' => 'form-control form-control-sm mb-3',
            ]);
        echo $this->Form->control('confirm',
            [
                'type' => 'password',
                'label' => 'Confirm Password *',
                'minlength' => 5,
                'maxlength' => 55,
                'required' => true,
                'class' => 'form-control form-control-sm mb-3',
            ]);
        ?>
    </div>
    <div class="col-sm-6">
        <?php

        echo $this->Form->control('phone',
            [
                'type' => 'phone',
                'label' => 'Phone Number *',
                'minlength' => 10,
                'maxlength' => 255,
                'required' => true,
                'class' => 'form-control form-control-sm mb-3',
            ]);
        echo $this->Form->control('email',
            [
                'type' => 'email',
                'minlength' => 5,
                'maxlength' => 255,
                'label' => 'Email',
                'class' => 'form-control form-control-sm mb-3',
            ]);
        echo $this->Form->control('address',
            [
                'type' => 'textarea',
                'label' => 'Address',
                'rows' => 3,
                'class' => 'form-control form-control-sm mb-3',
            ]);
        ?>
    </div>
</div>

<div class="mt-4">
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
</div>

<?php
    echo $this->Form->end();
?>
