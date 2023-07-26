<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .refer img {
            display: block;
            width: 45%;
            margin-left: auto;
            margin-right: auto;
        }

        @media(max-width:648px) {

            .refer img {
                display: flex;
                height: auto;
                width: 100%;
                margin-left: auto;
                margin-right: auto;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translateX(-50%) translateY(-50%);
            }
        }
    </style>
</head>

<body>
    <div class="dash-content">
        <div class="battles-pool">

            <div class="refer">
                <img src="<?= base_url() ?>/assets/media/success.jpg" alt="">

            </div>

            <div class="text-center my-3">
                <h4><?= $order_id ?></h4>
                <h6><?= $message ?></h6>
            </div>


        </div>
    </div>
</body>

</html>