<div class="main-content">
    <div class="main">
        <div class="row mb-3 mx-0">
            <div class="col-lg-2_1 mb-3">
                <div class="category">
                    <div class="cat-name">Total Users</div>
                    <div class="total-ticket"> <?= array_sum(array_column($keyStats ?? [], 'total')) ?></div>
                </div>
            </div>
            <?php foreach ($keyStats ?? [] as $stats) : ?>
                <div class="col-lg-2_1 mb-3">
                    <div class="category">
                        <div class="cat-name"><?= $stats['status_name'] ?> Users</div>
                        <div class="total-ticket"><?= $stats['total'] ?? '0.00' ?></div>
                    </div>
                </div>
            <?php endforeach; ?>


        </div>
        <div class="row mx-0">
            <div class="col-lg-12 my-3 card">
                <form action="" method="get">
                    <div class="row">

                        <div class="col-lg-3 my-2">
                            <div class="form-group">
                                <lable for="mobile">Mobile No.</lable>
                                <input type="number" id="mobile" minlength="10" class="form-control" maxlength="10" name="mobile" value="<?= $_GET['mobile'] ?? '' ?>" placeholder="Mobile No." autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-3 my-2">
                            <div class="form-group">
                                <lable for="from">From Date.</lable>
                                <input type="date" id="from" name="from" class="form-control" value="<?= $_GET['from'] ?? '' ?>">
                            </div>
                        </div>
                        <div class="col-lg-3 my-2">
                            <div class="form-group">
                                <lable for="to">To Date.</lable>
                                <input type="date" id="to" name="to" class="form-control" value="<?= $_GET['to'] ?? '' ?>">
                            </div>
                        </div>


                        <div class="col-lg-3 my-2">
                            <div class="form-group">
                                <lable for="status">Checked Status</lable>
                                <select name="status" class="form-control" id="status">
                                    <option value="">Selected</option>
                                    <option value="1" <?= '1' == ($_GET['status'] ?? '') ? 'selected' : null ?>>Active</option>
                                    <option value="0" <?= '0' == ($_GET['status'] ?? '') ? 'selected' : null ?>>Dective</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 my-2">
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
            <div class="col-lg-12">
                <div class="today-registered">
                    <h4 class=" form-head mb-3">User list</h4>
                    <div class="data table-responsive">
                        <table class="table" id="myTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th class="text-center" scope="col">User Info</th>
                                    <th class="text-center" scope="col">Referal Code</th>
                                    <th class="text-center" scope="col">Available Balance</th>
                                    <th class="text-center" scope="col">Date</th>
                                    <th class="text-center" scope="col">Status</th>
                                    <!-- <th class="text-center" scope="col">Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1;
                                foreach ($users as $user) : ?>
                                    <tr>
                                        <th scope="row"><?= $count++; ?></th>
                                        <td>
                                            <?= $user['user_name'] ?? '' ?><br>
                                            <small>Mobile: <b><a href="tel:<?= $user['mobile'] ?>"><?= $user['mobile'] ?></a></b></small><br>
                                            <?= $user['email'] ? '<small>Email: <b><a href="mail:' . $user['email'] . '">' . $user['email'] . '</a></b></small>' : null ?>
                                        </td>
                                        <td class="text-center"><?= $user['referal_code'] ?></td>
                                        <td class="text-center"><?= $user['balance'] ?></td>
                                        <td class="text-center"><?= $user['user_status'] ? '<span class="p-1 btn-active">Active</span>' : '<span class="p-1 btn-deactive">Dective</span>'; ?></td>
                                        <td class="text-center"><?= date('l d M Y', strtotime($user['user_created_at'])) ?></td>
                                        <?php /* 
                                        <td class="text-center">
                                            
                                            <div class="p-1"><a href="<?= base_url('home/resend/' . $user['user_no'] . '/' . $ticket['unique_id']) ?>" class="action">Resend</a></div>
                                            
                                            
                                        </td>
                                        */ ?>
                                    </tr>
                                <?php endforeach; ?>


                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="col-lg-12">
                <?= $pager->links(); ?>
            </div>
        </div>
    </div>
</div>