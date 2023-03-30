<footer class="footer-menu">
    <a class="profile" href="<?= base_url('home/profile') ?>">
        <div class="profile-icon">
            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
        </div>
        <small>Profile</small>
    </a>
    <div class="battles">
        <a class="battles-click" href="<?= base_url('home/battles') ?>">
            <div class="battles-icon">
                <img src="<?= base_url('assets/media') ?>/swords.png" alt="">
            </div>
            <small>Battles</small>
        </a>
    </div>
    <a class="log-out" href="<?= base_url('home/logout') ?>">
        <div>
            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
        </div>
        <small>Log Out</small>
    </a>
</footer>