<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? APP_NAME ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/font'); ?>/metarial.css">
    <link rel="stylesheet" href="<?= base_url('assets/css'); ?>/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url('assets/css'); ?>/style.css">
</head>

<body>
    <div class="main">
        <div class="game-container">
            <?php include('common/menu.php') ?>
            <div class="page_blank">
                <?= $this->include($pagename); ?>
            </div>
            <?php include('common/footermenu.php') ?>
        </div>
    </div>
    <!-- JavaScript -->
    <script src="<?= base_url('assets/js'); ?>/jquery.js"></script>
    <script src="<?= base_url('assets/js'); ?>/popper.js"></script>
    <script src="<?= base_url('assets/js'); ?>/bootstrap.js"></script>
    <script src="<?= base_url('assets/js'); ?>/main.js"></script>
</body>

</html>