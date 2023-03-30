<header>
    <div class="navbar">

        <a href="<?= session('isLogin') ? base_url('home/dashboard') : base_url('login') ?>" class="brand-logo">
            <img src="<?= base_url('assets/media') ?>/ludo.png" alt="">
        </a>
        <?php if (!session('isLogin')) : ?>
            <a class="login-btn" href="<?= base_url('login') ?>">
                Login
            </a>
        <?php else : ?>
            <a class="login-btn" href="<?= base_url() ?>home/logout">
                Logout
            </a>
        <?php endif; ?>

    </div>

</header>