<div class="dash-content">
    <div class="battles-pool">
        <h5>
            <span class="">Choose amount to add</span>
        </h5>
        <div class="choose-form">

            <div>
                Enter Amount ₹
            </div>
            <div>
                <input type="number" id="amount" placeholder="100" class="form-control" min="<?= $min_amount ?? '10' ?>" max="<?= $max_amount ?>">
            </div>
            <label for="" class="mb-2"><small>Min: <?= $min_amount ?? '10' ?>, Max: <?= $max_amount ?></small></label>

            <style>
                .amount-part {
                    display: flex;
                    flex-flow: row wrap;
                    gap: 4%;
                    justify-content: space-between;

                }

                .amount-item {
                    flex: 0 0 auto;
                    width: 48%;
                    margin-bottom: 10px;
                }

                .amount-card {
                    border: 1px solid #c5c5c5;
                    padding: 20px 15px;
                    border-radius: 10px;
                    background: #ebebee;
                    cursor: pointer;
                }

                .amount-card .h4 {
                    font-size: 1.6rem;
                    font-weight: 600;
                }

                .amount-card p {
                    font-size: 12px;
                }

                .amount-card ul {
                    font-size: 12px;
                }

                .next .btn {
                    font-size: 1.2rem;
                    font-weight: 500;
                }
            </style>
            <div class="amount-part">
                <?php foreach ($frequentOption ?? [] as $k => $v) : ?>
                    <div class="amount-item">
                        <div class="amount-card" onclick="paymentNow('<?= $v ?>')">
                            <h4><small style="font-size: small;">₹</small> <?= $v ?></h4>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php /*
                <div class="amount-part">
                    <div class="amount-item" style="width: 100%;">
                        <div class="amount-card p-3">
                            <h5 class="text-success">CashBack Offer!</h5>
                            <p>Mobikwik Wallet (Upto Rs. 750)
                            </p>
                            <ul>
                                <li>
                                    Use Code: MBK750 On The MobiKwik Payment Page To Avail Per Offer
                                </li>
                                <li>
                                    Offer Valid Twice Per User In A Month
                                </li>
                                <li>Offer Valid On A Minimum Transaction Of Rs.1999</li>
                            </ul>
                        </div>
                    </div>
                </div>
                 */ ?>
            <div class="next">
                <button class="form-control btn btn-primary" onclick="paymentNow($('#amount').val())">Next</button>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript" src="https://sdk.cashfree.com/js/ui/2.0.0/cashfree.sandbox.js"></script>
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

    function paymentNow(amount) {
        if (amount == '' || '<?= $min_amount ?? '10' ?>' > amount) {
            toastr.options = options;
            toastr['error']("Amount is not sufficient to proceed.");
        } else {
            let formData = new FormData();
            formData.append('amount', amount);
            formData.append('<?= csrf_token(); ?>', '<?= csrf_hash(); ?>');
            $.ajax({
                "url": "<?= base_url('payment/create-order') ?>",
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
                        const cashfree = new Cashfree(response.data.payment_session_id);
                        return cashfree.redirect();
                    } else {
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