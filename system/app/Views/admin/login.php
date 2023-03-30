<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ludo King</title>
    <link rel="stylesheet" href="<?= base_url() ?>/adminassets/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url() ?>/adminassets/css/style.css">
    <style>
        .web-logo img{
            width: 120px;
        }
    </style>
</head>

<body>
    <main class="login-main">
        <div class="login-container">
            <div class="login-section">
                <a href="<?= base_url('admin/battles')?>" class=" text-center mb-3">
                    <div class="web-logo">Ludo King</div>
    </a>
                <form action="" method="post" class="login-form">
                    <div class="form-group mb-3">
                        <input type="tel" maxlength="10" minlength="10" value="" class="form-control" name="mobile" placeholder="Enter your mobile" required>
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" class="form-control" minlength="8" maxlength="32" name="password" placeholder="Enter your password" required>
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group mb-3">
                        <input type="submit" value="Login" class="form-control btn login" name="submit">
                    </div>

                </form>
            </div>
        </div>
    </main>
    <!-- script -->
    <script src="<?= base_url() ?>/adminassets/js/popper.js"></script>
    <script src="<?= base_url() ?>/adminassets/js/bootstrap.js"></script>
    <!-- end script -->
</body>

</html>