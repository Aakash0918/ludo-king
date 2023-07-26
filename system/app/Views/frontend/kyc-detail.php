<div class="profile-content">
    <div class="profile-view text-start">
        <h5 class="mb-3">
            <span class="">Complete Your KYC</span>
        </h5>
    </div>
    <div class="mb-3">
        <form action="" method="post">
            <?= csrf_field(); ?>
            <div class="my-wallet mb-2">
                <div class="icon material-symbols-outlined">
                    person
                </div>
                <div class="title">
                    <select type="email" class="form-control" name="type" id="type">
                        <option value="">--select KYC Type--</option>
                        <option value="aadhar_card">Aadhar Card</option>
                        <option value="pancard">Pan Card</option>
                    </select>
                </div>
            </div>
            <div class="my-wallet mb-2">
                <div class="icon material-symbols-outlined">
                    pin
                </div>
                <div class="title">
                    <input type="text" class="form-control" name="id_proof" id="id_proof" placeholder="Your ID Number">
                </div>
            </div>
            <div class="mb-2">
                <button class="form-control btn bg-primary text-light">Submit</button>
            </div>
        </form>
    </div>
</div>