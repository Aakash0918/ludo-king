<div class="dash-content">
    <div class="battles-pool">
        <h5>
            <span class="">Refer & Earn</span>
        </h5>

        <div class="refer">
            <img src="<?= base_url() ?>/assets/media/referral-user-welcome.png" alt="">
        </div>
        <div class="refer-content">
            <h4 class="text-center fw-bold">Earn now unlimited 🥳</h4>
            <p class="text-center mb-1">
                Refer your friends now!
            </p>
            <h6 class="text-center fw-bold">
                Your Refer Code: <?= session('referal_code') ?>
            </h6>
            <p class="text-center mb-1">
                Total Refers: 0
            </p>

        </div>
    </div>
    <div class="battles-pool refer-rule">
        <div class="">
            <h6 class="fw-bold mb-3">
                Refer & Earn Rules
            </h6>
            <div class="d-flex">
                <div class="re-img">
                    <img src="<?= base_url() ?>/assets/media/referral-signup-bonus-new.png" alt="">
                </div>
                <div class="re-content">
                    <p class="mb-1">When your friend signs up on lodo from your referral link,</p>
                    <p class="text-success">You get 1% Commission on your referral's winnings.</p>
                </div>
            </div>
            <div class="d-flex">
                <div class="re-img">
                    <img src="<?= base_url() ?>/assets/media/banner_illsutration.png" alt="">
                </div>
                <div class="re-content">
                    <p class="mb-1">Suppose your referral plays a battle for ₹10000 Cash,</p>
                    <p class="text-success">You get ₹100 Cash</p>
                </div>
            </div>
        </div>
    </div>
    <div class="battles-pool share-list">
        <h4 class="text-center fw-bold">SHARE IN LISTED CHANNELS:</h4>
        <div class="share-link d-flex justify-content-center">
            <a href="" class="share-item">
                <div>
                    <span class="whatsapp">
                        <img src="<?= base_url() ?>/assets/media/whatsapp.gif" alt="">
                    </span>
                </div>
            </a>
            <a href="" class="share-item">
                <div>
                    <span class="telegram">
                        <img src="<?= base_url() ?>/assets/media/telegram.gif" alt="">
                    </span>
                </div>
            </a>
            <a href="" class="share-item">

                <div>
                    <span class="twitter">
                        <img src="<?= base_url() ?>/assets/media/twitter.gif" alt="">
                    </span>
                </div>
            </a>
        </div>
        <div class="copy-link mt-4">
            <button onclick="copyContent('<?= base_url('login') ?>?refferal=<?= session('referal_code') ?>')" class="form-control btn bg-secondary refer-button ml-2 d-flex justify-content-center text-light gap-2">
                <span class="mr-2">Copy Refer Link</span>
                <svg focusable="false" viewBox="0 0 24 24" stroke="#ffffff" aria-hidden="true" width="25px" height="25px">
                    <path fill="#ffffff" d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm-1 4l6 6v10c0 1.1-.9 2-2 2H7.99C6.89 23 6 22.1 6 21l.01-14c0-1.1.89-2 1.99-2h7zm-1 7h5.5L14 6.5V12z">
                    </path>
                </svg></button>
        </div>
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