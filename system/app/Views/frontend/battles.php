<div class="dash-content">
    <div class="battles-pool">
        <h5>
            <div>
                <img src="<?= base_url('assets/media') ?>/swords.png" alt="">
            </div>
            <span class="ms-2">Battles</span>
            <a href="<?= base_url('game-rules') ?>" class="ms-auto">Rules
                <span>
                    <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                </span>
            </a>
        </h5>
        <div class="pool-items">
            <?php foreach ($battles ?? [] as $battle) : ?>
                <a class="pool-item" href="<?= base_url('home/waiting-for-player/' . $battle['unique_id']) ?>">
                    <div class="pool-box">
                        <div class="pool-price">
                            <div class="pool">Price Pool</div>
                            <div class="d-flex align-items-center">
                                <div class="icon">
                                    <img src="<?= base_url('assets/media') ?>/rupee.png" alt="">
                                </div>
                                <span class="ms-2">₹<?= $battle['winning_price'] ?></span>
                            </div>
                        </div>
                        <div class="pool-entry-price">
                            <div class="pool">
                                Entry Price
                            </div>
                            <div>
                                <small class="ms-2">₹</small>
                                <button><?= $battle['pool_price'] ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="pool-playing">
                        <?= $battle['live_users'] ?> Playing Now
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>