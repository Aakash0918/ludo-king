<div class="main-content">
    <div class="main">
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
                                <lable for="status">Game Status</lable>
                                <select name="status" class="form-control" id="status">
                                    <option value="">Selected</option>
                                    <option value="0" <?= '0' == ($_GET['status'] ?? '') ? 'selected' : null ?>>On Going</option>
                                    <option value="2" <?= '2' == ($_GET['status'] ?? '') ? 'selected' : null ?>>Winner Declared</option>
                                    <option value="3" <?= '3' == ($_GET['status'] ?? '') ? 'selected' : null ?>>Hold</option>

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
                                    <th class="text-center" scope="col">Room Id</th>
                                    <th class="text-center" scope="col">Per Head Amount</th>
                                    <th class="text-center" scope="col">Wining Amount</th>
                                    <th class="text-center" scope="col">Platform Charges</th>
                                    <th class="text-center" scope="col">Status</th>
                                    <th class="text-center" scope="col">Date</th>
                                    <th class="text-center" scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1;
                                $totalPlatformCharges = 0;
                                $totalWinningAmount = 0;
                                $totalPerheadAmount = 0;
                                foreach ($games as $game) : ?>
                                    <tr>
                                        <th scope="row"><?= $count++; ?></th>
                                        <td>
                                            <?= $game['room_id'] ?>
                                        </td>
                                        <td class="text-center">₹ <?php $totalPerheadAmount += $game['per_head_amt'];
                                                                    echo $game['per_head_amt'];  ?></td>
                                        <td class="text-center text-success">₹ <?php $totalWinningAmount += $game['wining_amt'];
                                                                                echo $game['wining_amt']; ?></td>
                                        <td class="text-center text-danger">₹ <?php
                                                                                $totalPlatformCharges += $game['service_amt'];
                                                                                echo $game['service_amt']; ?></td>
                                        <td class="text-center" id="room-<?= $game['room_id'] ?>"><?= $lobby_status[$game['lobby_status']] ?></td>
                                        <td class="text-center"><?= date('l d M Y', strtotime($game['lobby_created_at'])) ?></td>
                                        <td class="text-center" id="room-action-<?= $game['room_id'] ?>"><?= $game['lobby_status'] == 2 ? 'N/A' : '<button type="button" class="btn btn-sm btn-primary" onclick="showModal(\'' . $game['room_id'] . '\')" >Change Status</button>' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2" class="text-center">Total</th>
                                    <th class="text-center">₹ <?= number_format($totalPerheadAmount, 2) ?></th>
                                    <th class="text-center">₹ <?= number_format($totalWinningAmount, 2) ?></th>
                                    <th class="text-center">₹ <?= number_format($totalPlatformCharges, 2) ?></th>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                            </tfoot>
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
<!-- Modal -->
<div class="modal fade" id="changeStatusModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="changeStatusForm" name="changeStatusForm" action="" method="post">
                        <?= csrf_field(); ?>
                        <div class="col-lg-12">
                            <div class="row" id="imageDiv">

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="closeModel" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="btnSbt" form="changeStatusForm" class="btn btn-primary">Change Status</button>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js'); ?>/jquery.validate.min.js"></script>
<script>
    let lobby_status = <?= json_encode($lobby_status); ?>;

    function changeStatus(p, c) {
        //console.log(p)
        if (p == '') {
            alert('select an valid option');
            return;
        }
        if (p != c) {
            if (p == '2') {
                $('#winChooseDiv').removeClass('d-none')
            } else {
                $('#winChooseDiv').addClass('d-none')
            }
        }
        return;
    }

    function showModal(lobbyId = "") {
        if (lobbyId != '') {
            let formData = new FormData();
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            $.ajax({
                "url": "<?= base_url('admin/getDetail/') ?>/" + lobbyId,
                "method": "POST",
                "timeout": 0,
                "processData": false,
                "mimeType": "multipart/form-data",
                "contentType": false,
                "data": formData,
                dataType: 'json',
                async: false,
                success: function(response) {
                    if (response.status == true) {
                        let s = '';

                        if (response.data.players.length > 0) {
                            let players = response.data.players;
                            for (let index = 0; index < players.length; index++) {
                                const element = players[index];
                                s += `<div class="col-lg-6 text-center">
                                        <div>
                                            <a href="` + (element.lobby_image ? element.lobby_image : '#') + `" target="_blank">
                                                <img for="player` + (index + 1) + `" class="` + (element.lobby_image ? 'img-thumbnail' : '') + `" src="` + (element.lobby_image ? element.lobby_image : '') + `" alt="" style="height: 400px; width:auto;">
                                            </a>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="winner" id="player` + (index + 1) + `" value="` + element.user_id + `">
                                            <label class="form-check-label" for="player` + (index + 1) + `">Player ` + (index + 1) + `</label>
                                        </div>
                                        <div>
                                            <h5>` + (element.user_name ? element.user_name : 'N/A') + `</h5>
                                            <h6>` + element.mobile + `</h6>
                                        </div>
                                    </div>`;
                            }

                        }
                        $("#imageDiv").html(`
                            <div class="col-lg-12 text-center">
                                <h4>Room id: <span id="looby_id">` + response.data.room_id + `</span> </h4>
                            </div>
                            <div class="col-lg-12">
                                <lable for="ch_status">Game Status</lable>
                                <select name="ch_status" class="form-control" onchange="changeStatus(this.value, ` + response.data.lobby_status + `)" id="ch_status">
                                    <option value="">Selected</option>
                                    <option value="0" ` + (response.data.lobby_status == '0' ? 'selected' : '') + `>On Going</option>
                                    <option value="2" ` + (response.data.lobby_status == '2' ? 'selected' : '') + `>Winner Declared</option>
                                    <option value="3" ` + (response.data.lobby_status == '3' ? 'selected' : '') + `>Hold</option>

                                </select>
                            </div>
                            <div id="winChooseDiv" class="col-lg-12 text-center my-2 ` + (response.data.status == '2' ? '' : 'd-none') + ` row">
                        ` + s + `</div>`)
                        $("#changeStatusForm").attr('action', '<?= base_url('admin/changeRoomStatus') ?>/' + lobbyId);
                        var myModal = new bootstrap.Modal(document.getElementById('changeStatusModel'))
                        myModal.show();
                        toastr['success'](response.message);
                    } else {
                        if (response.formErrors) {
                            $.each(response.formErrors, function(propName, propVal) {
                                toastr['error'](propVal);
                            });
                        } else {
                            toastr['error'](response.message);
                        }
                    }
                },
                error: function(response) {
                    alert(response.message)
                    location.reload();
                }
            });
        } else {
            return;
        }

    }

    $("#changeStatusForm").validate({
        onfocusout: false,
        errorElement: 'div',
        errorClass: "text-danger error",
        rules: {
            ch_status: {
                required: true
            },
        },
        messages: {
            ch_status: {
                required: "Status is required.",
            },
        },
        submitHandler: function(form) {
            let formData = new FormData(form);
            var btn = $("#btnSbt");
            btn.prop('disabled', true);
            btn.text('Processing...');
            $.ajax({
                "url": $("#changeStatusForm").attr('action'),
                "method": "POST",
                "timeout": 0,
                "processData": false,
                "mimeType": "multipart/form-data",
                "contentType": false,
                "data": formData,
                dataType: 'json',
                success: function(response) {
                    btn.prop('disabled', false);
                    btn.text('Change Status');

                    if (response.auth) {
                        window.location.href = response.redUrl;
                    }
                    if (response.status) {
                        let lobby = $("#looby_id").text();
                        $("#room-" + lobby).html(lobby_status[response.data.ch_status])
                        if (response.data.ch_status == 2) {
                            $("#room-action-" + lobby).html("N/A")
                        }
                        toastr['success'](response.message);
                        $("#changeStatusForm")[0].reset();
                        $("#closeModel").click();
                        //location.reload();
                    } else {
                        if (response.formErrors) {
                            $.each(response.formErrors, function(propName, propVal) {
                                if (propName == 'winner') {
                                    toastr['error'](propVal);
                                } else {
                                    $('<div id="' + propName + '-error" class="error text-danger" style="">' + propVal + '</div>').insertAfter('#' + propName)
                                }
                            });
                        } else {
                            toastr['error'](response.message);
                        }
                    }
                },
                error: function(response) {
                    alert(response.message)
                    location.reload();
                }
            });
        }
    });
</script>