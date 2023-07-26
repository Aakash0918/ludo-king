<div class="main-content">
    <div class="main">
        <div class="row mx-0">
            <div class="col-lg-5 mb-3 mx-auto">
                <div class="">
                    <div class="register">
                        <div class="">
                            <h4 class="form-head mb-0">Create Battle</h4>
                        </div>
                        <form action="" method="post" class="register-form">
                            <?= csrf_field(); ?>
                            <div class="form-group mb-3">

                            </div>
                            <div class="form-group mb-3">
                                <label for="pool_price">Pool Price*</label>
                                <input type="number" name="pool_price" id="pool_price" value="<?= old('pool_price') ?? '' ?>" required class="form-control" placeholder="Enter pool price" autocomplete="off">
                                <span class="text-danger"><?= session('_ci_validation_errors')['pool_price'] ?? ''; ?></span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="winning_price">Winning Price*</label>
                                <input type="number" name="winning_price" id="winning_price" class="form-control" value="<?= old('winning_price') ?? '' ?>" required placeholder="Enter winning price" autocomplete="off">
                                <span class="text-danger"><?= session('_ci_validation_errors')['winning_price'] ?? ''; ?></span>
                            </div>
                            <input type="hidden" name="capacity" value="2">

                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" required class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="1" <?= (old('status') ?? '') == '1' ? 'selected' : null ?>>Active</option>
                                    <option value="0" <?= (old('status') ?? '') == '0' ? 'selected' : null ?>>Dective</option>
                                </select>
                                <span class="text-danger"><?= session('_ci_validation_errors')['status'] ?? ''; ?></span>
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