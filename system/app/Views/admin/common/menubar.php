
<div class="menubar" id="mySidenav">
    <div class="menu-sticky">
    <a href="<?= base_url('admin')?>" class=" text-center mb-3">
                    <div class="web-logo">Ludo King</div>
    </a>
    <div class="menu-items">
        <div class="menu-item">
            <a href="<?= base_url() ?>" class="menu-link">Dashboard</a>
        </div>
        
        <div class="menu-item has-collapsible">
            <a href="#" class="menu-link dropmenu">Battles</a>
            <div class="dropdown">
                <a href="<?= base_url('admin/battles') ?>" class="drop-item">All Battles</a>
                <a class="drop-item">Create Battle</a>
            </div>
        </div>
        <div class="menu-item">
            <a href="<?= base_url('admin/setting') ?>" class="menu-link">Settings</a>
        </div>
        <hr>
        <div class="menu-item">
            <a href="<?= base_url('admin') ?>/logout" class="menu-link">Log out</a>
        </div>
    </div>
    </div>
</div>