<div class="row">
    <div class="">
        <h1>Login</h1>

        <div class="">
            <div class="mt-3">
                <?php
                echo $this->Form->create(null, ['class' => 'needs-validation', 'novalidate']);
                ?>
                <div class="">
                    <?php
                    echo $this->Form->text('username', [
                        'type' => 'text',
                        'label' => false,
                        'class' => 'form-control',
                        'required' => true,
                        'placeholder' => 'Username',
                    ]);
                    ?>
                    <div class="invalid-feedback">
                    Username is required
                    </div>
                </div>

                <div class="mt-3">
                    <?php
                    echo $this->Form->password('kunji', [
                        'type' => 'password',
                        'label' => false,
                        'class' => 'form-control',
                        'required' => true,
                        'placeholder' => 'Password',
                    ]);
                    ?>
                    <div class="invalid-feedback">
                        Password is required
                    </div>
                </div>

                <div class="mt-4 mb-3">
                    <?= $this->Form->button(__('Login'), ['class' => 'btn btn-md btn-primary']) ?>
                </div>

                <?php
                echo $this->Form->end();
                ?>
            </div>
        </div>
        <div class="mt-5 alert bg-light text-center mx-auto">
            Don't have an account? <br>
            <a href="/users/register" class="mt-2 btn btn-sm btn-orange">Click here to register</a>
        </div>
    </div>
</div>

<script>
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



