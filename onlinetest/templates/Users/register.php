<h1>Register</h1>
<hr>
<div class="text-muted">Create your account. It's quick and easy.</div>

<?php
    echo $this->Form->create(null, ['class' => 'needs-validation', 'novalidate']);
?>


<div class="mt-4">
    <div class="alert bg-light border shadow">
        <div class="row mt-3">
            <div class="col-sm-6">
                <div class="mb-3">
                    <?php
                    echo $this->Form->text('name',
                        [
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

                <div class="mb-3">
                    <?php
                    echo $this->Form->text('username',
                        [
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

                <div class="mb-3">
                    <?php
                    echo $this->Form->password('password',
                        [
                            'type' => 'password',
                            'label' => false,
                            'minlength' => 5,
                            'maxlength' => 55,
                            'required' => true,
                            'class' => 'form-control',
                            'placeholder' => 'Password'
                        ]);
                    ?>
                    <div class="invalid-feedback">
                        Password is required.
                    </div>
                </div>

                <?php
        //        echo $this->Form->control('confirm',
        //            [
        //                'type' => 'password',
        //                'label' => 'Confirm Password *',
        //                'minlength' => 5,
        //                'maxlength' => 55,
        //                'required' => true,
        //                'class' => 'form-control mb-3',
        //            ]);
                ?>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <?php
                    echo $this->Form->text('phone',
                        [
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

                <div class="mb-3">
                    <?php
                    echo $this->Form->email('email',
                        [
                            'type' => 'email',
                            'minlength' => 5,
                            'maxlength' => 255,
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => 'Email (optional)'
                        ]);
                    ?>
                    <div class="invalid-feedback">
                        Invalid Email.
                    </div>
                </div>

                <?php
                echo $this->Form->control('address',
                    [
                        'type' => 'textarea',
                        'label' => false,
                        'rows' => 1,
                        'class' => 'form-control mb-3',
                        'placeholder' => 'Address (optional)'
                    ]);
                ?>
            </div>
        </div>
        <div class="row mt-2 mb-3">
            <div class="col-12">
                <div class="">
                    <?= $this->Form->button(__('Create Account'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>


    </div>
    <div class="mt-5 text-center">
        <a href="/users/login" class='btn-orange btn'>Cancel</a>
    </div>
</div>



<?php
    echo $this->Form->end();
?>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>


