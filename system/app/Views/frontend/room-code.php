<div class="dash-content">
    <div class="battles-pool">
        <style>
            .room-code {
                border: 4px solid #fefefe;
                background: radial-gradient(#5f99f3, #1969ff);
                border-radius: 10px;
                padding: 15px 25px;
                text-align: center;
                font-size: 16px;
                font-weight: 600;
                box-shadow: 0 0 4px 1px #838383;
                color: #fff;
            }

            .room-codes {
                margin-top: 25px;
            }

            .room-codes p {
                font-size: 13px;
                font-weight: 400;
            }

            .r-code {
                border-radius: 10px;
                border: 1px solid #79a8fe;
                padding: 10px 15px;
                display: flex;
                width: min-content;
                margin-left: auto;
                margin-right: auto;
                font-size: 22px;
                margin-top: 10px;
                margin-bottom: 10px;
            }
        </style>
        <div class="room-code">
            Your Room id is
            <div class="room-codes">
                <button class="btn btn-primary r-code" onclick="copyContent('<?= $room_detail['room_id'] ?? '' ?>')">
                    <?= $room_detail['room_id'] ?? '' ?>
                    <span class="pl-1">
                        <svg focusable="false" viewBox="0 0 24 24" stroke="#ffffff" aria-hidden="true" width="25px" height="25px">
                            <path fill="#ffffff" d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm-1 4l6 6v10c0 1.1-.9 2-2 2H7.99C6.89 23 6 22.1 6 21l.01-14c0-1.1.89-2 1.99-2h7zm-1 7h5.5L14 6.5V12z">
                            </path>
                        </svg>
                    </span>

                </button>
            </div>
        </div>
        <?php if ($room_detail['user_image']) : ?>
            <div class="row my-2">
                <div class="col-lg-12 form-group mb-2">
                    <label for="image">Uploaded Screenshot</label>
                    <div class="preview my-2 text-center">
                        <img class="img-thumbnail" src="<?= base_url($room_detail['user_image']) ?>" style="width: auto;height: 200px;">
                    </div>
                </div>
            </div>
        <?php else : ?>
            <?php if ($room_detail['status'] != '2') : ?>
                <div class="row my-2">
                    <div class="col-lg-12 text-center">
                        <button class="btn btn-primary" id="btnshow" onclick="$('#divUpload').toggle();">Upload Screenshot</button>
                    </div>
                </div>
                <div id="divUpload" class="row mt-2 " style="display: none;">
                    <div class="col-lg-12">
                        <form id="image-form" action="" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <input type="hidden" name="room" id="room" value="<?= $room_detail['room_id'] ?? '' ?>">
                            <div class="form-group mb-2">
                                <label for="image">Upload Screenshot</label>
                                <input type="file" class="form-control" onchange="loadFile(event)" name="image" id="image" placeholder="Upload Screenshot" accept="image/png, image/jpg, image/jpeg" required>
                                <div class="preview my-2 text-center">
                                    <img id="output">
                                </div>
                            </div>
                            <div class="text-center mb-2">
                                <button type="submit" id="btnSbt" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($room_detail['status'] == '2') : ?>
            <div class="row my-2">
                <div class="col-lg-12 text-center">
                    Declared Winner
                </div>
            </div>
        <?php elseif ($room_detail['status'] == '3') : ?>
            <div class="row my-2">
                <div class="col-lg-12 text-center">
                    Result Hold due to conflict.
                </div>
            </div>
        <?php else : ?>
            <div class="row my-2">
                <div class="col-lg-12 text-center">
                    Waiting for declare winner.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php if ($room_detail['user_image']) : ?>
    <script src="<?= base_url('assets/js'); ?>/jquery.validate.min.js"></script>
<?php endif; ?>
<script>
    const copyContent = async (text) => {
        try {
            //await navigator.clipboard.writeText(text);
            // Navigator clipboard api needs a secure context (https)
            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(text);
            } else {
                // Use the 'out of viewport hidden text area' trick
                const textArea = document.createElement("textarea");
                textArea.value = text;

                // Move textarea out of the viewport so it's not visible
                textArea.style.position = "absolute";
                textArea.style.left = "-999999px";

                document.body.prepend(textArea);
                textArea.select();

                try {
                    document.execCommand('copy');
                } catch (error) {
                    console.error(error);
                } finally {
                    textArea.remove();
                }
            }
            toastr['info']('Copy Successfully.')
        } catch (err) {
            toastr['error']('Failed to copy');
        }
    }
    <?php if ($room_detail['user_image']) : ?>
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.style = "width: auto;height: 200px;";
            output.className = "img-thumbnail";
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };

        $("#image-form").validate({
            onfocusout: false,
            errorElement: 'div',
            errorClass: "text-danger error",
            rules: {
                image: {
                    required: true
                },
            },
            messages: {
                image: {
                    required: "Screenshot is required.",
                },
            },
            submitHandler: function(form) {
                let formData = new FormData(form);
                var btn = $("#btnSbt");
                btn.prop('disabled', true);
                btn.text('Processing...');
                $.ajax({
                    "url": "<?= base_url('home/submitScreenshot/' . $room_detail['room_id']) ?>",
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
                            $('#output').attr('src', response.image);
                            form.reset();
                            $("#image").hide();
                            btn.hide();
                            $("#btnshow").hide();
                        } else {
                            if (response.formErrors) {
                                $.each(response.formErrors, function(propName, propVal) {
                                    if (propName == 'room') {
                                        toastr['error'](propVal);
                                    } else {
                                        $('<div id="' + propName + '-error" class="error text-danger" style="">' + propVal + '</div>').insertAfter('#' + propName)
                                    }
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
    <?php endif; ?>
</script>