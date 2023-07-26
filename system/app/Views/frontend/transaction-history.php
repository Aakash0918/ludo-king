<div class="dash-content">
    <div class="battles-pool">
        <h5>

            <span class="ms-2">Transaction History</span>

        </h5>
        <div class="pool-items">
            <?php foreach ($transactions as $trans) : ?>
                <a class="pool-item" href="#">
                    <div class="pool-box">
                        <div class="pool-price">
                            <div class="pool"><?= humanize($trans['transaction_type']) ?></div>
                            <div class="d-flex align-items-center">
                                <div class="icon">
                                    <img src="<?= base_url('assets/media') ?>/rupee.png" alt="">
                                </div>
                                <span class="ms-2"><?= $trans['amount'] ?></span>
                            </div>
                        </div>
                        <div class="pool-entry-price">

                            <div>
                                <button disabled class="btn btn-<?= $trans['amount_type'] == 'cr' ? 'success' : 'danger' ?>"><?= humanize($trans['amount_type']) ?></button>
                            </div>
                            <div class="pool py-1">
                                Closing Balance: <?= $trans['after_balance'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="pool-playing align-items-center d-flex justify-content-between">
                        <span><small style="font-size:11px"></small></span> <span><small style="font-size:11px">Date: <?= date('d/m/Y H:i:s', strtotime($trans['wallet_created_at'])) ?></small></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <div>
            <?= $pager->links(); ?>
        </div>
    </div>
</div>