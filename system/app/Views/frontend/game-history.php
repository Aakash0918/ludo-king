<div class="dash-content">
    <div class="battles-pool">
        <h5>

            <span class="">Game History</span>

        </h5>
        <div class="pool-items">
            <?php /*
            <a class="pool-item" href="">
                <div class="pool-box">
                    <div class="pool-price">

                        <div class="pool">
                            Won against: <small>xyz person</small>
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
                            <button>Win</button>
                        </div>
                        <div class="pool py-1">
                            Closing Balance: 0
                        </div>
                    </div>
                </div>
                <div class="pool-playing align-items-center d-flex justify-content-between">
                    <span><small style="font-size:11px">Battle ID: 1659890206</small></span> <span><small style="font-size:11px">Date: 28/05/2023</small></span>
                </div>
            </a>
            */ ?>
            <?php foreach ($games as $game) : ?>
                <a class="pool-item lost" href="<?= base_url('home/room-code/' . $game['room_id']) ?>">
                    <div class="pool-box">
                        <div class="pool-price">
                            <div class="pool">
                                Status: <small><?= $lobby_status[$game['lobby_status']] ?></small>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="icon">
                                    <img src="<?= base_url('assets/media') ?>/rupee.png" alt="">
                                </div>
                                <span class="ms-2"><?= $game['lobby_status'] == 2 ? $game['wining_amt'] : $game['per_head_amt'] ?></span>
                            </div>
                        </div>
                        <div class="pool-entry-price">
                            <div>
                                <?php if ($game['lobby_status'] == 2) : ?>
                                    <button><?= $game['win_user'] == session('id') ? 'Win' : 'Lost' ?></button>
                                <?php else : ?>
                                    <button><?= $game['lobby_status'] == 3 ? 'On Hold' : 'Waiting' ?></button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="pool-playing align-items-center d-flex justify-content-between">
                        <span><small style="font-size:11px">Battle ID: <?= $game['room_id'] ?></small></span> <span><small style="font-size:11px">Date: <?= date('d/m/Y', strtotime($game['lobby_created_at'])) ?></small></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <div>
            <?= $pager->links(); ?>
        </div>
    </div>
</div>