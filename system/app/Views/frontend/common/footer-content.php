<?php $setting = cache('support_setting'); ?>
<div class="footer-content">
    <div class="foot-menu">
        <div class="brand-logo">
            <img src="<?= base_url('assets/media') ?>/ludo.png" alt="">
        </div>
        <div class="foot-items">
            <div class="row">
                <div class="col-6 col-lg-6">
                    <a href="<?= base_url('/term-condition') ?>" class="foot-item">
                        Terms & Condition
                    </a>
                </div>
                <div class="col-6 col-lg-6">
                    <a href="<?= base_url('/privacy-policy') ?>" class="foot-item">
                        Privacy Policy
                    </a>
                </div>
                <div class="col-6 col-lg-6">
                    <a href="<?= base_url('/refund-policy') ?>" class="foot-item">
                        Refund/Cancellation Policy
                    </a>
                </div>
                <div class="col-6 col-lg-6">
                    <a href="<?= base_url('/contact-us') ?>" class="foot-item">
                        Contact Us
                    </a>
                </div>
                <div class="col-6 col-lg-6">
                    <a href="<?= base_url('/responsible-gaming') ?>" class="foot-item">
                        Responsible Gaming
                    </a>
                </div>
                <div class="col-6 col-lg-6">
                    <a href="<?= base_url('/platform-commission') ?>" class="foot-item">
                        Platform Commission
                    </a>
                </div>
                <div class="col-6 col-lg-6">
                    <a href="<?= base_url('/tds-policy') ?>" class="foot-item">
                        TDS Policy
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="foot-content">
        <h5>About Us</h5>
        <p>
            Ludo is a real-money gaming product owned and operated by Gazick Private Limited
            ("Ludo" or "We" or "Us" or "Our").
        </p>
        <h5>Our Business & Products</h5>

        <p>We are an HTML5 game-publishing company and our mission is to make accessing games fast and
            easy by removing the friction of app-installs.</p>

        <p>Ludo is a skill-based real-money gaming platform accessible only for our users in India.
            It is accessible on <a href="mailto:<?= $setting['mail'] ?? ''['mail'] ?? '' ?>"><?= $setting['mail'] ?? ''['mail'] ?? '' ?></a>. On Ludo, users can compete for real
            cash in
            Tournaments and Battles. They can encash their winnings via popular options such as Paytm
            Wallet, Amazon Pay, Bank Transfer, Mobile Recharges etc.</p>

        <h5>Our Games</h5>

        <p>Ludo has a wide-variety of high-quality, premium HTML5 games. Our games are especially
            compressed and optimised to work on low-end devices, uncommon browsers, and patchy internet
            speeds.</p>

        <p>We have games across several popular categories: Arcade, Action, Adventure, Sports & Racing,
            Strategy, Puzzle & Logic. We also have a strong portfolio of multiplayer games such as Ludo,
            Chess, 8 Ball Pool, Carrom, Tic Tac Toe, Archery, Quiz, Chinese Checkers and more! Some of
            our popular titles are: Escape Run, Bubble Wipeout, Tower Twist, Cricket Gunda, Ludo With
            Friends. If you have any suggestions around new games that we should add or if you are a
            game developer yourself and want to work with us, don't hesitate to drop in a line at
            <a href="mailto:<?= $setting['mail'] ?? ''['mail'] ?? '' ?>"><?= $setting['mail'] ?? ''['mail'] ?? '' ?></a>!
        </p>
    </div>
</div>