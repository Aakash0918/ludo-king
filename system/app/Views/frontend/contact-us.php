<div class="p-4">
    <h2>Contact Us</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
        </ol>
    </nav>
    <divƒ class="row">
        <div class="col-12">
            <p>For any kind of queries, please contact us on the below mention details</p>
            <h4>CONTACT:</h4>
            <ul>
                <li>
                    <p><a href="<?= base_url() ?>"><span class="oi oi-globe"></span><abbr><?= $setting['site'] ?? '' ?></abbr></a></p>
                </li>
                <li>
                    <p><a href="mailto:<?= $setting['mail'] ?? '' ?>"><span class="oi oi-envelope-closed"></span><abbr><?= $setting['mail'] ?? '' ?></abbr></a></p>
                </li>
            </ul><br>
            <h4>Operational Address:</h4>
            <p class="decoration-none"><?= $setting['address'] ?></p><br>
            <h4>To submit your game write to us:</h4>
            <p class="decoration-none"><a href="mailto:business@ludoking.com"><span class="oi oi-envelope-closed"></span><abbr>business@ludoking.com</abbr></a></p><br><br><br><br>
        </div>
</div>
</div>