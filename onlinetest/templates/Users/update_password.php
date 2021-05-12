<h1>Change Password</h1>

<?php
echo $this->Form->create();
?>


<div class="mt-4">
    <div class="">
        <div class="row row-cols-1">
            <div class="col">
                <div class="mb-3">
                    <label for="password">New Password</label>
                    <?php
                    echo $this->Form->password('password',
                        [
                            'id' => 'password',
                            'type' => 'password',
                            'label' => false,
                            'minlength' => 5,
                            'maxlength' => 55,
                            'required' => true,
                            'class' => 'form-control',
                            'placeholder' => 'Enter New Password'
                        ]);
                    ?>
                    <div class="invalid-feedback">
                        Password is required.
                    </div>
                </div>

            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="password">Confirm New Password</label>
                    <?php
                    echo $this->Form->password('confirm',
                        [
                            'id' => 'confirm',
                            'type' => 'password',
                            'label' => false,
                            'minlength' => 5,
                            'maxlength' => 55,
                            'required' => true,
                            'class' => 'form-control',
                            'placeholder' => 'Re-Enter New Password'
                        ]);
                    ?>
                    <div class="invalid-feedback">
                        This is required field.
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="text-center">
                    <?= $this->Form->button(__('Save Changes'), ['class' => 'btn btn-primary mb-3']) ?>
                    <a href="/Users/myProfile" class='btn-orange btn ms-3 mb-3'>Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
echo $this->Form->end();
?>
