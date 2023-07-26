<div class="profile-content">
    <div class="profile-view">
        <div class="profile-pic">
            <img src="<?= session('image') ?>" alt="">
        </div>
        <div class="profile-username">
            <div class="profile-name">
                <?= session('name') ?>
            </div>
            <a href="<?= base_url('home/profile-edit') ?>" class="profile-edit">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
            </a>
        </div>
    </div>
    <div class="mb-3">
        <a href="<?= base_url('home/my-wallet') ?>" class="my-wallet">
            <div class="icon material-symbols-outlined">
                wallet
            </div>
            <div class="title">My Wallet</div>
        </a>
    </div>
    <?php if (!session('kyc')) : ?>
        <div class="complete-profile mb-3">
            <h3>Complete Profile</h3>
            <a href="<?= base_url('home/complete-kyc') ?>" class="profile-active">
                <div class="icon material-symbols-outlined">
                    demography
                </div>
                <div class="title">Complete KYC</div>
            </a>
        </div>
    <?php endif; ?>

    <div class="mb-3">
        <div class="refer-code">
            <div class="icon material-symbols-outlined">
                share
            </div>
            <input type="text" class="form-control" readonly placeholder="My Refer Code" value="<?= session('referal_code') ?>">
            <button onclick="copyContent('<?= base_url('login') ?>?refferal=<?= session('referal_code') ?>')" class="enter btn btn-primary">
                <svg focusable="false" viewBox="0 0 24 24" stroke="#ffffff" aria-hidden="true" width="25px" height="25px">
                    <path fill="#ffffff" d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm-1 4l6 6v10c0 1.1-.9 2-2 2H7.99C6.89 23 6 22.1 6 21l.01-14c0-1.1.89-2 1.99-2h7zm-1 7h5.5L14 6.5V12z">
                    </path>
                </svg>
            </button>
        </div>
    </div>
    <div class="mb-3">
        <a href="<?= base_url('home/battles') ?>" class="cash-won">
            <div class="icon material-symbols-outlined">
                currency_rupee
            </div>
            <div class="title">Win Cash</div>
        </a>
    </div>
    <div class="mb-3">
        <a href="<?= base_url('home/game-history') ?>" class="battles-play">
            <div class="icon material-symbols-outlined">
                swords
            </div>
            <div class="title">
                <div class="bit">Played Battles</div>
            </div>

        </a>
    </div>
</div>
<script>
    const copyContent = async (text) => {
        try {
            //await navigator.clipboard.writeText(text);
            // Navigator clipboard api needs a secure context (https)
            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(text);
            } else {
                // Use the 'out of viewport hidden text area' trick
                const textArea = document.createElement("textarea");
                textArea.value = text;

                // Move textarea out of the viewport so it's not visible
                textArea.style.position = "absolute";
                textArea.style.left = "-999999px";

                document.body.prepend(textArea);
                textArea.select();

                try {
                    document.execCommand('copy');
                } catch (error) {
                    console.error(error);
                } finally {
                    textArea.remove();
                }
            }
            toastr['info']('Copy Successfully.')
        } catch (err) {
            toastr['error']('Failed to copy');
        }
    }
</script>