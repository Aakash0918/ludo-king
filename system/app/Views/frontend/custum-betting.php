<div class="dash-content">
    <div class="battles-pool">
        <h5>
            <span class="">Create Custom Prize Pool</span>
        </h5>
        <div class="choose-form">

            <div>
                Enter Amount ₹
            </div>
            <div>
                <input type="number" id="amount" placeholder="100" class="form-control" onchange="calculatePlatform($('#amount').val())" min="<?= $detail['min_amount'] ?? '100' ?>" max="<?= $detail['max_amount'] ?? '100' ?>">
            </div>
            <label for="" class="mb-2"><small>Platform: <?= $detail['charges'] ?>%, Min: ₹ <?= $detail['min_amount'] ?? '100' ?>, Max: ₹ <?= $detail['max_amount'] ?? '100'; ?> & Max Player: 2</small></label>
            <div id="calculationDiv" class="d-none">
                <p>
                    <b>Total Player: </b> 2 <br>
                    <b>Pool Prize: </b>₹ <span id="per_amount"></span><br>
                    <b>Platform charges(<?= $detail['charges'] ?>%): </b>₹ <span id="platform_amount"></span><br>
                    <b>Wining Prize: </b>₹ <span id="win_amount"></span><br>
                </p>
            </div>

            <div class="next">
                <button id="btnsubmit" class="form-control btn btn-primary" disabled onclick="betNow($('#amount').val())">Join Room</button>
            </div>

        </div>
    </div>
</div>
<script>
    var options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "1000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    function calculatePlatform(amount) {
        if (amount == '' || parseFloat('<?= $detail['min_amount'] ?? '100' ?>') > amount || parseFloat('<?= $detail['max_amount'] ?? '100' ?>') < amount) {
            toastr.options = options;
            toastr['error']("Amount is not sufficient to proceed.");
            $('#calculationDiv').addClass('d-none');
            $("#btnsubmit").prop('disabled', true);
            return;
        }
        let totalAmount = 2 * amount;
        let platformFees = totalAmount * (parseFloat(<?= $detail['charges'] ?>) / 100);
        $("#per_amount").html(parseFloat(totalAmount).toFixed(2));
        $("#platform_amount").html(parseFloat(platformFees).toFixed(2));
        $("#win_amount").html(parseFloat(totalAmount - platformFees).toFixed(2));
        $('#calculationDiv').removeClass('d-none');
        $("#btnsubmit").prop('disabled', false);
        return;

    }

    function betNow(amount) {
        if (amount == '' || parseFloat('<?= $detail['min_amount'] ?? '100' ?>') > amount || parseFloat('<?= $detail['max_amount'] ?? '100' ?>') < amount) {
            toastr.options = options;
            toastr['error']("Amount is not sufficient to proceed.");
            $('#calculationDiv').addClass('d-none');
            $("#btnsubmit").prop('disabled', true);
            return;
        } else {
            let formData = new FormData();
            formData.append('amount', amount);
            formData.append('<?= csrf_token(); ?>', '<?= csrf_hash(); ?>');
            $.ajax({
                "url": "<?= base_url('home/submit-bet-now') ?>",
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
                        $('#amount').val('');
                        window.location.href = response.redUrl;
                    } else {
                        if (response.redUrl) {
                            window.location.href = response.redUrl;
                        }
                        if (response.formErrors) {
                            $.each(response.formErrors, function(propName, propVal) {
                                $('<div id="' + propName + '-error" class="error text-danger" style="">' + propVal + '</div>').insertAfter('#' + propName)
                            });
                        } else {
                            alert(response.message)
                        }
                    }
                },
                error: function(response) {
                    alert(response.message)
                    location.reload();
                }
            });
        }
    }
</script>