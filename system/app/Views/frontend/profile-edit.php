<div class="profile-content">
    <div class="profile-view text-start">
        <h5 class="mb-3">
            <span class="">Profile Edit</span>
        </h5>
    </div>
    <div class="mb-3">
        <form id="profile-form" action="" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="my-wallet mb-2">
                <div for="name" class="icon material-symbols-outlined">
                    person
                </div>
                <div class="title">
                    <input type="text" class="form-control" name="name" id="name" value="<?= session('name') ?>" placeholder="Enter name" required>
                </div>
            </div>
            <div class="my-wallet mb-2">
                <div for="email" class="icon material-symbols-outlined">
                    Mail
                </div>
                <div class="title">
                    <input type="email" class="form-control" name="email" id="email" value="<?= session('email') ?>" placeholder="Enter Mail" required>
                </div>
            </div>
            <div class="profile-pic mb-2">
                <img id="profile-image" src="<?= session('image') ?>" alt="">
            </div>
            <div class="my-wallet mb-2">

                <div for="image" class="icon material-symbols-outlined">
                    image
                </div>
                <div class="title">
                    <input type="file" class="form-control" name="image" id="image">
                </div>

            </div>


            <div class="mb-2">
                <button id="btnSbt" class="form-control btn bg-primary text-light">Submit</button>
            </div>
        </form>
    </div>
</div>
<script src="<?= base_url('assets/js'); ?>/jquery.validate.min.js"></script>
<script>
    $("#profile-form").validate({
        onfocusout: false,
        errorElement: 'div',
        errorClass: "text-danger error",
        rules: {
            name: {
                required: true
            },
            email: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Name is required.",
            },
            email: {
                required: "Please enter a valid mail id",
            }
        },
        submitHandler: function(form) {
            let formData = new FormData(form);
            var btn = $("#btnSbt");
            btn.prop('disabled', true);
            btn.text('Processing...');
            $.ajax({
                "url": "<?= base_url('home/submit-profile') ?>",
                "method": "POST",
                "timeout": 0,
                "processData": false,
                "mimeType": "multipart/form-data",
                "contentType": false,
                "data": formData,
                dataType: 'json',
                success: function(response) {
                    if (response.auth) {
                        window.location.href = response.redUrl;
                    }
                    btn.prop('disabled', false)
                    btn.text('Submit')
                    if (response.status == true) {
                        toastr['success'](response.message);
                        $('#profile-image').attr('src', response.image);
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
    })
</script>