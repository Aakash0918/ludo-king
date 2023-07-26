<div class="main-content">
    <div class="main">
        <div class="row mx-0">
            <div class="col-lg-12 mb-3">
                <div class="today-registered">
                    <div class="form-head d-flex justify-content-between align-items-center">

                        <h4 class="mb-0">All Battles</h4>
                        <a href="<?= base_url('/admin/add-battle') ?>" class="adddesk btn-active py-2 px-3">Add New</a>
                    </div>

                    <div class="data table-responsive">
                        <table class="table" id="myTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Pool Price</th>
                                    <th scope="col">Winning Amount</th>
                                    <th scope="col">Capacity</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1;
                                foreach ($battles ?? [] as $battle) : ?>
                                    <tr>
                                        <th scope="row">
                                            <?= $count++; ?>
                                        </th>
                                        <td>
                                            <?= $battle['pool_price'];  ?>
                                        </td>
                                        <td>
                                            <?= $battle['winning_price'];  ?>
                                        </td>
                                        <td>
                                            <?= $battle['capacity'];  ?>
                                        </td>
                                        <td>
                                            <?= $battle['gp_status'] ? '<span class="p-1 btn-active">Active</span>' : '<span class="p-1 btn-deactive">Dective</span>'; ?>
                                        </td>
                                        <td>
                                            <?= date('d/m/Y', strtotime($battle['gp_created_at'])) ?>
                                        </td>
                                        <td>
                                            <div class="p-1"><a href="<?= base_url('admin/edit-battle/' . $battle['gp_id']) ?>" class="btn-active">Edit</a></div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <?= $pager->links(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>