<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= base_url('assets/css');?>/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url('assets/css');?>/style.css">
</head>

<body>
    <div class="main">
        <div class="game-container">
            <div class="d-flex flex-column h-100 justify-content-between">
                <div class="login-page">
                    <div class="brand-logo">
                        <img src="<?= base_url('assets/media/')?>/ludo.png" alt="">
                    </div>
                    <h3 class="mb-4">Sign Up Or Login</h3>
                    <form action="" method="post">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">+91</span>
                            <input type="text" class="form-control" placeholder="Mobile Number" aria-label="Username"
                                aria-describedby="basic-addon1">
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
    <script src="<?= base_url('assets/js');?>/jquery.js"></script>
    <script src="<?= base_url('assets/js');?>/popper.js"></script>
    <script src="<?= base_url('assets/js');?>/bootstrap.js"></script>
    <script src="<?= base_url('assets/js');?>/main.js"></script>
</body>

</html>