<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ludo King</title>
    <link rel="stylesheet" href="<?= base_url() ?>/adminassets/css/toastr.css">
    <link rel="stylesheet" href="<?= base_url() ?>/adminassets/css/datatables.css">
    <link rel="stylesheet" href="<?= base_url() ?>/adminassets/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url() ?>/adminassets/css/style.css">
    <script src="<?= base_url() ?>/adminassets/js/jquery.js"></script>
    <style>
        .web-logo {
            margin-bottom: 15px;
        }

        .web-logo img {
            width: 130px;

        }

        @media(max-width:992px) {
            .web-logo {
                margin-bottom: 0px;
            }

            .web-logo img {
                width: 90px;

            }
        }
    </style>
</head>

<body>

    <!-- mob-header -->
    <div class="mob-header">
        <div class="header-view">
            <div class="d-flex align-items-center">
                <div class="menu-btn" onclick="openNav()">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <line x1="17" y1="10" x2="3" y2="10"></line>
                        <line x1="21" y1="6" x2="3" y2="6"></line>
                        <line x1="21" y1="14" x2="3" y2="14"></line>
                        <line x1="17" y1="18" x2="3" y2="18"></line>
                    </svg>
                </div>
                <div class="logo">
                    <a href="<?= base_url() ?>" class="web-logo">
                        <img src="<?= base_url() ?>/adminassets/uploads/logo.png" />
                    </a>
                </div>
                <div class="mob-scan ms-auto">
                    <a href="<?= base_url('admin/scan') ?>" class="btn-scan">Scan QR</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end mob header -->
    <div class="web-apge" id="webmain">