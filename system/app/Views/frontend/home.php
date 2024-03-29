<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Play Games Online and Earn Money | Ludo, Cricket, Chess, Carrom &amp; Many More Game' ?></title>
    <meta name="description" content="<?= $page_meta ?? 'Ludo King brings to you exciting games like Carrom, Ludo, Cricket, Chess, Bubble Wipeout, and more. Play games online against thousands of players and win real cash. Withdraw cash instantly to Amazon Pay or to your bank account via UPI. Visit Ludo King and find more than 100+ games to earn money.' ?>">
    <meta name=”robots” content="index, follow">

    <link rel="stylesheet" href="<?= base_url('assets/css'); ?>/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url('assets/css'); ?>/style.css">
</head>

<body>
    <div class="main">
        <div class="game-container">
            <?php include('common/logout-menu.php') ?>
            <div class="d-flex flex-column h-100 justify-content-between">
                <div class="home-content">
                    <div class="youtube">
                        <button class="youtube-help">
                            <div class="icon">
                                <div>
                                    <svg viewBox="0 0 24 24" width="20" height="20" stroke="#f00" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                        <path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z">
                                        </path>
                                        <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>
                                    </svg>

                                </div>
                                <small>Video Help</small>
                            </div>
                            <div class="how-to">
                                How to win money?
                            </div>
                        </button>
                    </div>
                    <div class="games">
                        <h5>Our Games</h5>
                        <div class="game-types">
                            <img class="icon" src="<?= base_url('assets/media') ?>/swords.png" alt=""> is for Battles and
                            <img class="icon trophy" src="<?= base_url('assets/media') ?>/trophy.png" alt=""> is for
                            Tournaments. <b>Know more here.</b>
                        </div>
                        <div class="game-lists">
                            <div class="row">
                                <div class="col-6 col-lg-6">
                                    <a class="game-card" href="<?= base_url('home/battles') ?>">
                                        <div class="live-status blink"><span class="icon">◉</span><small> LIVE</small>
                                        </div>
                                        <div class="game-img">
                                            <img src="<?= base_url('assets/media') ?>/kb_ludo.jpeg" alt="">
                                        </div>
                                        <div class="game-name">
                                            <div class="type battle">
                                                <img class="icon" src="<?= base_url('assets/media') ?>/swords.png" alt="">
                                            </div>
                                            Premium Ludo
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 col-lg-6">
                                    <a class="game-card" href="<?= base_url('home/battles') ?>">
                                        <div class="live-status blink"><span class="icon">◉</span><small> LIVE</small>
                                        </div>
                                        <div class="game-img">
                                            <img src="<?= base_url('assets/media') ?>/kb_ludo.jpeg" alt="">
                                        </div>
                                        <div class="game-name">
                                            <div class="type tournament">
                                                <img class="icon" src="<?= base_url('assets/media') ?>/trophy.png" alt="">
                                            </div>
                                            Premium Ludo
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 col-lg-6">
                                    <a class="game-card" href="<?= base_url('home/battles') ?>">
                                        <div class="live-status blink"><span class="icon">◉</span><small> LIVE</small>
                                        </div>
                                        <div class="game-img">
                                            <img src="<?= base_url('assets/media') ?>/kb_ludo.jpeg" alt="">
                                        </div>
                                        <div class="game-name">
                                            <div class="type tournament">
                                                <img class="icon" src="<?= base_url('assets/media') ?>/trophy.png" alt="">
                                            </div>
                                            Premium Ludo
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 col-lg-6">
                                    <a class="game-card" href="<?= base_url('home/battles') ?>">
                                        <div class="live-status blink"><span class="icon">◉</span><small> LIVE</small>
                                        </div>
                                        <div class="game-img">
                                            <img src="<?= base_url('assets/media') ?>/kb_ludo.jpeg" alt="">
                                        </div>
                                        <div class="game-name">
                                            <div class="type tournament">
                                                <img class="icon" src="<?= base_url('assets/media') ?>/trophy.png" alt="">
                                            </div>
                                            Premium Ludo
                                        </div>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <?php include('common/footer-content.php') ?>
            </div>
        </div>
    </div>
    <!-- JavaScript -->
    <script src="<?= base_url('assets/js'); ?>/jquery.js"></script>
    <script src="<?= base_url('assets/js'); ?>/popper.js"></script>
    <script src="<?= base_url('assets/js'); ?>/bootstrap.js"></script>
    <script src="<?= base_url('assets/js'); ?>/main.js"></script>
</body>

</html>