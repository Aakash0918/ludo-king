<div class="main-content">
    <div class="main">
        <div class="row mx-0">
            <div class="col-lg-5 mb-3 mx-auto">
                <div class="">
                    <div class="register">
                        <div class="">
                            <h4 class="form-head mb-0">Custum Prize  Game Setting</h4>
                        </div>
                        <form action="" method="post" class="register-form">
                            <?= csrf_field(); ?>

                            <div class="form-group mb-3">
                                <label for="service_charge">Service Charges(%)</label>
                                <input type="number" name="service_charge" id="service_charge" value="<?= old('service_charge') ?? ($detail['charges'] ?? '0') ?>" required class="form-control" placeholder="Enter service charges e.g 5" autocomplete="off">
                                <span class="text-danger"><?= session('_ci_validation_errors')['service_charge'] ?? ''; ?></span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="min_amount">Minimum Amount</label>
                                <input type="number" name="min_amount" id="min_amount" value="<?= old('min_amount') ?? ($detail['min_amount'] ?? '0') ?>" required class="form-control" placeholder="Enter minimum amount" autocomplete="off">
                                <span class="text-danger"><?= session('_ci_validation_errors')['min_amount'] ?? ''; ?></span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="max_amount">Maximum Amount</label>
                                <input type="number" name="max_amount" id="max_amount" value="<?= old('max_amount') ?? ($detail['max_amount'] ?? '0') ?>" required class="form-control" placeholder="Enter maximum amount" autocomplete="off">
                                <span class="text-danger"><?= session('_ci_validation_errors')['max_amount'] ?? ''; ?></span>
                            </div>


                            <div class="form-group mb-3">
                                <input type="submit" name="submit" value="Create" id="submit" class="form-control btn login">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>