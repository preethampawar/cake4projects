<h1>Edit Profile</h1>

<?php
echo $this->Form->create($userInfo);
?>


<div class="mt-4">
    <div class="">
        <div class="row row-cols-1">

            <div class="col">
                <div class="mb-3">
                    <label for="username">Username <span class="text-muted small fst-italic">(Used for logging in)</span></label>
                    <?php
                    echo $this->Form->text('username',
                        [
                            'id' => 'username',
                            'type' => 'text',
                            'label' => false,
                            'text' => 'sss',
                            'minlength' => 3,
                            'maxlength' => 55,
                            'required' => true,
                            'class' => 'form-control',
                            'placeholder' => 'Username'
                        ]);
                    ?>
                    <div class="invalid-feedback">
                        Username is required.
                    </div>
                </div>

            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="name">Full Name</label>
                    <?php
                    echo $this->Form->text('name',
                        [
                            'id' => 'name',
                            'type' => 'text',
                            'label' => false,
                            'minlength' => 3,
                            'maxlength' => 255,
                            'required' => true,
                            'class' => 'form-control',
                            'placeholder' => 'Full Name'
                        ]);
                    ?>
                    <div class="invalid-feedback">
                        Full Name is required.
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="phone">Phone</label>
                    <?php
                    echo $this->Form->text('phone',
                        [
                            'id' => 'phone',
                            'type' => 'phone',
                            'label' => false,
                            'minlength' => 10,
                            'maxlength' => 255,
                            'required' => true,
                            'class' => 'form-control',
                            'placeholder' => 'Phone No.'
                        ]);
                    ?>
                    <div class="invalid-feedback">
                        Phone No. is required.
                    </div>
                </div>

            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="email">Email Address</label>
                    <?php
                    echo $this->Form->email('email',
                        [
                            'id' => 'email',
                            'type' => 'email',
                            'minlength' => 5,
                            'maxlength' => 255,
                            'label' => false,
                            'required' => true,
                            'class' => 'form-control',
                            'placeholder' => 'Email'
                        ]);
                    ?>
                    <div class="invalid-feedback">
                        Invalid Email.
                    </div>
                </div>

            </div>
            <div class="col">
                <label for="address">Address</label>
                <?php
                echo $this->Form->control('address',
                    [
                        'id' => 'address',
                        'type' => 'textarea',
                        'label' => false,
                        'rows' => 1,
                        'class' => 'form-control mb-3',
                        'placeholder' => 'Address (optional)'
                    ]);
                ?>
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
