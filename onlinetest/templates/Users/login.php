

<div class="row">
    <div class="">
        <h1>Login</h1>
        <hr>
        <?php
        if ($examDetails) {
            ?>

            <div class="mb-4 mt-3 mb-3">
                <div>You need to login to attend this online test</div>
                <h5><?= $examDetails->name ?></h5>
                <div class="mt-3">Register yourself if you don't have an account. It's easy.</div>
            </div>
            <?php
        }
        ?>

        <div class="mt-4 alert shadow bg-light border">
            <div class="mt-3">
                <?php
                echo $this->Form->create(null, ['class' => 'needs-validation', 'novalidate']);
                ?>
                <div class="mb-3">
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

                <div class="mb-3">
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
                    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-md btn-primary']) ?>
                </div>

                <?php
                echo $this->Form->end();
                ?>
            </div>
        </div>
        <div class="mt-4 alert shadow bg-aliceblue border text-center">
            Don't have an account? <br>
            <a href="/users/register" class="mt-2 btn btn-orange">Click here to register</a>
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



