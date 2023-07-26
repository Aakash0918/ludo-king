<header>
    <div class="navbar">
        <div class="menu" id="sidemenu">
            <button class="menu-toggle">
                <svg viewBox="0 0 24 24" width="32" height="32" stroke="#292E1E" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                    <line x1="3" y1="12" x2="15" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="12" y2="18"></line>
                </svg>
            </button>
        </div>
        <a class="brand-logo" href="<?= base_url('home/dashboard') ?>">
            <img src="<?= base_url('assets/media') ?>/ludo.png" alt="">
        </a>
        <a href="<?= base_url('home/my-wallet') ?>" class="cash">
            <div class="cash-icon">
                <img src="<?= base_url('assets/media') ?>/rupee.png" alt="">
            </div>
            <div class="cash-amount"><?= availableBalance(); ?></div>
            <div class="cash-add">
                <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
            </div>
        </a>

    </div>
    <div class="sidebar" id="Sidenav">
        <div class="sidepanel">
            <div class="panel-menus">
                <a href="<?= base_url('/home/profile') ?>" class="panel-link">
                    <div class="icon material-symbols-outlined">account_circle</div><span>Profile</span>
                    <div class="arrow material-symbols-outlined">
                        chevron_right
                    </div>
                </a>
                <a href="<?= base_url('home/battles') ?>" class="panel-link">
                    <div class="icon material-symbols-outlined">stadia_controller</div><span>Win Case</span>
                    <div class="arrow material-symbols-outlined">chevron_right</div>
                </a>
                <a href="<?= base_url('home/my-wallet') ?>" class="panel-link">
                    <div class="icon material-symbols-outlined">account_balance_wallet</div><span>My Wallet</span>
                    <div class="arrow material-symbols-outlined">chevron_right</div>
                </a>
                <a href="<?= base_url('home/game-history') ?>" class="panel-link">
                    <div class="icon material-symbols-outlined">history</div><span>Game History</span>
                    <div class="arrow material-symbols-outlined">chevron_right</div>
                </a>
                <a href="<?= base_url('home/transaction-history') ?>" class="panel-link">
                    <div class="icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg></div><span>Transaction History</span>
                    <div class="arrow material-symbols-outlined">chevron_right</div>
                </a>
                <a href="<?= base_url('home/refer-earn') ?>" class="panel-link">
                    <div class="icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg></div><span>Refer & Earn</span>
                    <div class="arrow material-symbols-outlined">chevron_right</div>
                </a>
                <a href="<?= base_url('home/notification') ?>" class="panel-link">
                    <div class="icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg></div><span>Notification</span>
                    <div class="arrow material-symbols-outlined">chevron_right</div>
                </a>
                <a href="<?= base_url('home/support') ?>" class="panel-link">
                    <div class="icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg></div><span>Support</span>
                    <div class="arrow material-symbols-outlined arrow material-symbols-outlined">chevron_right</div>
                </a>
            </div>
        </div>
    </div>
</header>