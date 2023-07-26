<div class="dash-content">
    <div class="battles-pool">
        <h5>
            <span class="">Wallet</span>
            <a href="#" class="ms-auto">Bal: <?= availableBalance() ?></a>
        </h5>
        <div class="pool-items">
            <div class="pb-3 border-bottom">
                <a href="<?= base_url('home/transaction-history') ?>" class="form-control d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined">
                        history
                    </span>
                    Wallet History
                    <span class="material-symbols-outlined ms-auto">
                        arrow_forward
                    </span>
                </a>
            </div>

            <a class="pool-item mt-3" href="<?= base_url('home/add-wallet') ?>">
                <div class="pool-box">
                    <div class="pool-price">
                        <div class="pool">
                            Deposit Cash
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="icon">
                                <img src="<?= base_url('assets/media') ?>/rupee.png" alt="">
                            </div>
                            <span class="ms-2">5</span>
                        </div>
                    </div>
                    <div class="pool-entry-price">

                        <div>
                            <button class="bg-primary">Add Cash</button>
                        </div>

                    </div>
                </div>
                <div class="pool-playing align-items-center d-flex justify-content-between" style=" line-height: 1; ">
                    <span><small style="font-size:11px; line-height: 1;">Can be used to play Tournaments & Battles.
                            Cannot be withdrawn to Paytm or Bank.</small></span>
                </div>
            </a>
            <a class="pool-item" href="<?= base_url('home/withdraw-wallet') ?>">
                <div class="pool-box">
                    <div class="pool-price">
                        <div class="pool">
                            Winning Cash
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="icon">
                                <img src="<?= base_url('assets/media') ?>/rupee.png" alt="">
                            </div>
                            <span class="ms-2">5</span>
                        </div>
                    </div>
                    <div class="pool-entry-price">

                        <div>
                            <button class="bg-info">Withdraw</button>
                        </div>

                    </div>
                </div>
                <div class="pool-playing align-items-center d-flex justify-content-between" style=" line-height: 1; ">
                    <span><small style="font-size:11px">Can be withdrawn to Paytm or Bank. Can be used to play Tournaments & Battles.</small></span>
                </div>
            </a>
        </div>
    </div>
</div>