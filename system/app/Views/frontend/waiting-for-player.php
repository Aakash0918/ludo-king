<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Play Games Online and Earn Money | Ludo, Cricket, Chess, Carrom &amp; Many More Game' ?></title>
    <meta name="description" content="<?= $page_meta ?? 'Ludo King brings to you exciting games like Carrom, Ludo, Cricket, Chess, Bubble Wipeout, and more. Play games online against thousands of players and win real cash. Withdraw cash instantly to Amazon Pay or to your bank account via UPI. Visit Ludo King and find more than 100+ games to earn money.' ?>">
    <meta name=”robots” content="index, follow">
    <link rel="stylesheet" href="<?= base_url('assets/font'); ?>/metarial.css">
    <link rel="stylesheet" href="<?= base_url('assets/css'); ?>/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url() ?>/adminassets/css/toastr.css">
    <style>
        h1 {
            padding: 3rem 1rem 0;
            text-align: center;
            line-height: 1.3;
            letter-spacing: 4px;
            font-size: 2em;
        }

        p {
            padding: 3rem 1rem 0;
            text-align: center;
            line-height: 1.3;
            letter-spacing: 4px;
            font-size: 1.125em;
        }

        /******************************
        * FLEXBOX STYLES
        * ******************************/
        .main-block {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
        }

        .dice {
            display: flex;
            justify-content: center;

        }

        .face {
            display: flex;
            width: 40px;
            height: 40px;
            margin: 0px 5px;
            padding: 5px;
            border-radius: 5px;
            opacity: 0;
        }

        .face .dot {
            width: 8px;
            height: 8px;
            background: #F44336;
            border-radius: 50%;
        }

        .face:nth-child(1) {
            border: 2px solid #F44336;
            -webkit-animation: waves 5s linear infinite;
            animation: waves 5s linear infinite;
        }

        .face:nth-child(1) .dot {
            background: #F44336;
        }

        .face:nth-child(2) {
            border: 2px solid #E91E63;
            -webkit-animation: waves 5s 0.2s linear infinite;
            animation: waves 5s 0.2s linear infinite;
        }

        .face:nth-child(2) .dot {
            background: #E91E63;
        }

        .face:nth-child(3) {
            border: 2px solid #9C27B0;
            -webkit-animation: waves 5s 0.4s linear infinite;
            animation: waves 5s 0.4s linear infinite;
        }

        .face:nth-child(3) .dot {
            background: #9C27B0;
        }

        .face:nth-child(4) {
            border: 2px solid #673AB7;
            -webkit-animation: waves 5s 0.6s linear infinite;
            animation: waves 5s 0.6s linear infinite;
        }

        .face:nth-child(4) .dot {
            background: #673AB7;
        }

        .face:nth-child(5) {
            border: 2px solid #3F51B5;
            -webkit-animation: waves 5s 0.8s linear infinite;
            animation: waves 5s 0.8s linear infinite;
        }

        .face:nth-child(5) .dot {
            background: #3F51B5;
        }

        .face:nth-child(6) {
            border: 2px solid #2196F3;
            -webkit-animation: waves 5s 1s linear infinite;
            animation: waves 5s 1s linear infinite;
        }

        .face:nth-child(6) .dot {
            background: #2196F3;
        }

        .first-face {
            justify-content: center;
            align-items: center;
        }

        .second-face {
            justify-content: space-between;
        }

        .second-face .dot:last-of-type {
            align-self: flex-end;
        }

        .third-face {
            justify-content: space-between;
        }

        .third-face .dot:nth-child(2) {
            align-self: center;
        }

        .third-face .dot:last-of-type {
            align-self: flex-end;
        }

        .fourth-face {
            justify-content: space-between;
        }

        .fourth-face .column1 {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .fifth-face {
            justify-content: space-between;
        }

        .fifth-face .column1 {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .fifth-face .column1:nth-child(2) {
            justify-content: center;
        }

        .sixth-face {
            justify-content: space-between;
        }

        .sixth-face .column1 {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /*******************************************************/
        @-webkit-keyframes waves {
            0% {
                transform: translateY(0);
                opacity: 0;
            }

            4% {
                transform: translateY(-25px);
                opacity: 1;
            }

            8% {
                transform: translateY(0);
                opacity: 1;
            }

            70% {
                opacity: 0;
            }
        }

        @keyframes waves {
            0% {
                transform: translateY(0);
                opacity: 0;
            }

            4% {
                transform: translateY(-25px);
                opacity: 1;
            }

            8% {
                transform: translateY(0);
                opacity: 1;
            }

            70% {
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <div class="main-block">
        <div class="dice d-flex align-content-center">

            <div class="face first-face">
                <div class="dot"></div>
            </div>

            <div class="face second-face">
                <div class="dot"></div>
                <div class="dot"></div>
            </div>

            <div class="face third-face">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>

            <div class="face fourth-face">
                <div class="column1">
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
                <div class="column1">
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
            </div>

            <div class="face fifth-face">
                <div class="column1">
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
                <div class="column1">
                    <div class="dot"></div>
                </div>
                <div class="column1">
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
            </div>

            <div class="face sixth-face">
                <div class="column1">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
                <div class="column1">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
            </div>
        </div>
        <p>Wait for your opponent...</p>

    </div>




    <script src="<?= base_url('assets/js'); ?>/jquery.js"></script>
    <script src="<?= base_url('assets/js'); ?>/bootstrap.js"></script>
    <script src="<?= base_url() ?>/adminassets/js/toastr.js"></script>

    <script>
        var conn = new WebSocket('ws://localhost:8080/?access_token=' + '<?= ($cipherText) ?>');
        conn.onopen = function(e) {
            console.log("Connection established!");
        };

        conn.onmessage = function(e) {
            console.log(e.data);
            let resp = JSON.parse(e.data)
            if (resp.reload) {
                alert(resp.message)
                location.reload();
                return;
            }
            if (resp.status) {
                if (resp.match) {
                    toastr['success'](resp.message)
                    setInterval(() => {
                        window.location.href = '<?= base_url('home/room-code') ?>/' + resp.data.room_id
                    }, 2000)
                } else {
                    toastr['success'](resp.message);
                }
            } else {
                if (resp.code == '401') {
                    location.reload();
                }
                conn.onclose = function(e) {
                    console.log(e, 'close socket');
                }
            }
        };

        conn.send("Msg")

        toastr.options = {
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
    </script>

    <?php if (session('toastr')) : ?>
        <script>
            <?php foreach (session('toastr') as $key => $value) : ?>
                toastr['<?= $key ?>']("<?= $value ?>");
            <?php endforeach; ?>
        </script>
    <?php endif; ?>
</body>

</html>