<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registration</title>
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
                    <form action="" id="loginForm" name="loginForm" method="post">
                        <?= csrf_field(); ?>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">+91</span>
                            <input type="tel" class="form-control" placeholder="Mobile Number" aria-label="mobile" name="mobile" id="mobile" aria-describedby="basic-addon1">
                        </div>
                        <div class="">
                            <button class="form-control btn btn-success" type="submit">Continue</button>
                        </div>
                    </form>
                    <form action="" id="otpVerify" name="otpVerify" class="d-none" method="post">
                        <?= csrf_field(); ?>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2">+91</span>
                            <input type="number" class="form-control" placeholder="Mobile Number" aria-label="mobile" name="mobile" id="mobile-otp" aria-describedby="basic-addon2">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="otp-addon2">OTP</span>
                            <input type="number" class="form-control" placeholder="Enter Otp" aria-label="otp" name="otp" id="otp" aria-describedby="otp">
                        </div>
                        <div class="">
                            <button class="form-control btn btn-success mb-2" type="submit">Verify OTP</button>
                            <button class="form-control btn btn-success" onclick="resendOtpbtn()" disabled type="button" id="resendOtp">Resend OTP</button>
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
    <div id="jiosaavn-widget"></div>
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
                onfocusout: false,
                errorElement: 'div',
                errorClass: "text-danger error",
                rules: {
                    mobile: {
                        required: true,
                        minlength: 10,
                        maxlength: 10
                    }
                },
                messages: {
                    mobile: {
                        required: "Please enter a valid mobile number",
                        minlength: "Mobile number should be 10 digits",
                        maxlength: "Mobile number should be 10 digits",
                    },
                },
                submitHandler: function(form) {
                    let formData = new FormData(form);
                    formData.append('referal_code', '<?= $_GET['refferal'] ?? '' ?>')
                    $.ajax({
                        "url": "<?= base_url('login/send-otp') ?>",
                        "method": "POST",
                        "timeout": 0,
                        "processData": false,
                        "mimeType": "multipart/form-data",
                        "contentType": false,
                        "data": formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == true) {
                                $("#mobile-otp").val($('#mobile').val());
                                form.reset();
                                $("#loginForm").addClass('d-none');
                                $("#otpVerify").removeClass('d-none');
                                $('<div id="mobile-otp-error" class="error text-success" style="">' + response.message + '</div>').insertAfter('#mobile-otp');
                                timer(120);
                            } else {
                                if (response.formErrors) {
                                    $.each(response.formErrors, function(propName, propVal) {
                                        $('<div id="' + propName + '-error" class="error text-danger" style="">' + propVal + '</div>').insertAfter('#' + propName)
                                    });
                                } else {
                                    alert(response.message)
                                }
                            }
                        },
                        error: function(response) {
                            alert(response.message)
                            location.reload();
                        }
                    });
                }
            });

            $("#otpVerify").validate({
                onfocusout: false,
                errorElement: 'div',
                errorClass: "text-danger error",
                rules: {
                    mobile: {
                        required: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    otp: {
                        required: true,
                        minlength: 6,
                        maxlength: 6
                    }
                },
                messages: {
                    mobile: {
                        required: "Please enter a valid mobile number",
                        minlength: "Mobile number should be 10 digits",
                        maxlength: "Mobile number should be 10 digits",
                    },
                    otp: {
                        required: "Please enter otp",
                        minlength: "OTP should be 6 digits",
                        maxlength: "OTP should be 6 digits",
                    },

                },
                submitHandler: function(form) {
                    let formData = new FormData(form);
                    $.ajax({
                        "url": "<?= base_url('login/otp-verify') ?>",
                        "method": "POST",
                        "timeout": 0,
                        "processData": false,
                        "mimeType": "multipart/form-data",
                        "contentType": false,
                        "data": formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == true) {
                                <?php if (isset($_GET['redUrl'])) : ?>
                                    window.location.href = '<?= $_GET['redUrl'] ?>';
                                <?php else : ?>
                                    window.location.href = response.redUrl;
                                <?php endif; ?>
                            } else {
                                if (response.formErrors) {
                                    $.each(response.formErrors, function(propName, propVal) {
                                        $('<div id="' + propName + '-error" class="error text-danger" style="">' + propVal + '</div>').insertAfter('#' + propName)
                                    });
                                } else {
                                    alert(response.message)
                                }
                            }
                        },
                        error: function(response) {
                            alert(response.message)
                            location.reload();
                        }
                    });
                }
            });

        });

        function resendOtpbtn() {
            let formData = new FormData();
            formData.append('csrf_test_name', '<?= csrf_hash() ?>');
            formData.append('mobile', $("#mobile-otp").val())
            $.ajax({
                "url": "<?= base_url('login/send-otp') ?>",
                "method": "POST",
                "timeout": 0,
                "processData": false,
                "mimeType": "multipart/form-data",
                "contentType": false,
                "data": formData,
                async: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == true) {
                        $('<div id="mobile-otp-error" class="error text-success" style="">' + response.message + '</div>').insertAfter('#mobile-otp');
                        timer(120);
                    } else {
                        if (response.formErrors) {
                            $.each(response.formErrors, function(propName, propVal) {
                                $('<div id="' + propName + '-error" class="error text-danger" style="">' + propVal + '</div>').insertAfter('#' + propName)
                            });
                        } else {
                            alert(response.message)
                        }
                    }
                },
                error: function(response) {
                    alert(response.message)
                    location.reload();
                }
            });
            return;
        }

        let timerOn = true;

        function timer(remaining) {
            document.getElementById('resendOtp').disabled = true;
            var m = Math.floor(remaining / 60);
            var s = remaining % 60;

            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;
            document.getElementById('resendOtp').innerHTML = m + ':' + s;
            remaining -= 1;

            if (remaining >= 0 && timerOn) {
                setTimeout(function() {
                    timer(remaining);
                }, 1000);
                return;
            }

            if (!timerOn) {
                // Do validate stuff here
                return;
            }
            document.getElementById('resendOtp').innerHTML = 'Resend OTP';
            document.getElementById('resendOtp').disabled = false;
            // Do timeout stuff here

        }
    </script>
    <script id="jsw-init" src="https://www.jiosaavn.com/embed/_s/embed.js?ver=1676511020891"></script>
    <script>
        JioSaavnEmbedWidget.init({
            a: "1",
            q: "1",
            embed_src: "https://www.jiosaavn.com/embed/playlist/49",
            partner_id: "news18",
            dismiss: "1",
            dl: "0",
            dr: "0",
            db: "60",
            ml: "10",
            mr: "0",
            mb: "70"
        });
    </script>
</body>

</html>