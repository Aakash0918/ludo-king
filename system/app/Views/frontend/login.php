<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= base_url('assets/css'); ?>/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url('assets/css'); ?>/style.css">
</head>

<body>
    <div class="main">
        <div class="game-container">
            <div class="d-flex flex-column h-100 justify-content-between">
                <div class="login-page">
                    <div class="brand-logo">
                        <img src="<?= base_url('assets/media/') ?>/ludo.png" alt="">
                    </div>
                    <h3 class="mb-4">Sign Up Or Login</h3>
                    <form action="" id="loginForm" method="post">
                        <?= csrf_field(); ?>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">+91</span>
                            <input type="number" class="form-control" placeholder="Mobile Number" aria-label="mobile" name="mobile" id="mobile" aria-describedby="basic-addon1">
                        </div>
                        <div class="">
                            <button class="form-control btn btn-success" type="submit">Continue</button>
                        </div>
                    </form>
                </div>
                <div class="privacy">
                    By proceeding, you agree to our <a href="Terms of Use">Terms of Use</a>, Privacy Policy and that you are 18 years or older. You
                    are not playing from Assam, Odisha, Nagaland, Sikkim, Meghalaya, Andhra Pradesh, or Telangana.
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript -->
    <script src="<?= base_url('assets/js'); ?>/jquery.js"></script>
    <script src="<?= base_url('assets/js'); ?>/jquery.validate.min.js"></script>
    <script src="<?= base_url('assets/js'); ?>/popper.js"></script>
    <script src="<?= base_url('assets/js'); ?>/bootstrap.js"></script>
    <script src="<?= base_url('assets/js'); ?>/main.js"></script>
    <script>
        $().ready(function() {
            // validate signup form on keyup and submit
            $("#loginForm").validate({
                rules: {
                    mobile: "required"
                },
                messages: {
                    firstname: "Please enter your firstname",
                    lastname: "Please enter your lastname",
                    username: {
                        required: "Please enter a username",
                        minlength: "Your username must consist of at least 2 characters"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long"
                    },
                    confirm_password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long",
                        equalTo: "Please enter the same password as above"
                    },
                    email: "Please enter a valid email address",
                    agree: "Please accept our policy",
                    topic: "Please select at least 2 topics"
                },
                submitHandler: function(form) {
                    let formData = new FormData(form);
                    $.ajax({
                        "url": "<?= base_url('login/send-otp') ?>",
                        "method": "POST",
                        "timeout": 0,
                        "processData": false,
                        "mimeType": "multipart/form-data",
                        "contentType": false,
                        "data": formData,
                        success: function(response) {

                        },
                        error: function(response) {

                        }
                    }).done(function(response) {
                        console.log(response);
                    });
                }
            });


        });
    </script>
</body>

</html>