<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Play Games Online and Earn Money | Ludo, Cricket, Chess, Carrom &amp; Many More Game' ?></title>
    <meta name="description" content="<?= $page_meta ?? 'Ludo King brings to you exciting games like Carrom, Ludo, Cricket, Chess, Bubble Wipeout, and more. Play games online against thousands of players and win real cash. Withdraw cash instantly to Amazon Pay or to your bank account via UPI. Visit Ludo King and find more than 100+ games to earn money.' ?>">
    <meta name=”robots” content="index, follow">

    <link rel="stylesheet" href="<?= base_url('assets/font'); ?>/metarial.css">
    <link rel="stylesheet" href="<?= base_url('assets/css'); ?>/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url('assets/css'); ?>/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>/adminassets/css/toastr.css">
    <script src="<?= base_url('assets/js'); ?>/jquery.js"></script>
</head>

<body>
    <div class="main">
        <div class="game-container">
            <?php include('common/menu.php') ?>
            <div class="page_blank">
                <div class="d-flex flex-column h-100 justify-content-between">
                    <?= $this->include($pagename); ?>
                    <?php include('common/footer-content.php') ?>
                </div>
                <?php include('common/footermenu.php') ?>
            </div>

        </div>
    </div>
    <!-- JavaScript -->

    <script src="<?= base_url('assets/js'); ?>/popper.js"></script>
    <script src="<?= base_url('assets/js'); ?>/bootstrap.js"></script>
    <script src="<?= base_url('assets/js'); ?>/main.js"></script>
    <script src="<?= base_url() ?>/adminassets/js/toastr.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "1000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    </script>
    <?php if (session('toastr')) : ?>
        <script>
            <?php foreach (session('toastr') as $key => $value) : ?>
                toastr['<?= $key ?>']("<?= $value ?>");
            <?php endforeach; ?>
        </script>
    <?php endif; ?>
</body>

</html>