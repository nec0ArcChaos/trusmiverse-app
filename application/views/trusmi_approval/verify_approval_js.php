<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<script>
    function is_eaf() {
        if ($('#kategori').val() === 'Eaf') {
            $('#field_nominal').removeClass('d-none');
        } else {
            $('#field_nominal').addClass('d-none');
        }
    }

    function reject() {
        $('#btn_reject').prop('disabled', true);
        $('#btn_approve').prop('disabled', true);
        $.ajax({
            url: '<?php echo base_url() ?>trusmi_approval/reject',
            type: 'POST',
            dataType: 'JSON',
            data: $('#formApprove').serialize(),
            success: function(response) {
                $('#formApprove')[0].reset();
                $('#btn_approve').prop('disabled', false);
                $('#btn_reject').prop('disabled', false);
                $('#modalApprove').modal('hide');
                approve_to = response.approve_to;
                requested_by = response.created_by;
                requested_at = response.created_at;
                requested_hour = response.created_hour;
                user_id_approve_to = response.user_id_approve_to;
                no_app = response.no_app;
                subject = response.subject;
                description = response.description;
                note = response.approve_note;
                nomorHp = response.created_by_contact;
                created_by_contact = [
                    nomorHp
                ];
                msg = `📣 Alert!!!
Your Request Has Been Reject ❌
📝 Approve To : ${approve_to}
👤 Requested By : ${requested_by}
🕐 Requested At : ${requested_at} | ${requested_hour}

No. App : ${no_app}
Subject : *${subject}*
Description : ${description}

Status : Rejected ❌
Note : ${note}

🌐 Anda Bisa Melakukan Pengajuan Ulang melalui link:    
https://trusmiverse.com/apps/login/verify?u=${requested_by}&id=${no_app}
`;
                send_wa(created_by_contact, msg);


                window.location.href = "<?= base_url(); ?>/trusmi_approval";

                new PNotify({
                    title: `Success`,
                    text: `Request Rejected`,
                    icon: 'icofont icofont-check',
                    type: 'success',
                    delay: 1500,
                });
            }
        });
    }

    function approve() {
        $('#btn_reject').prop('disabled', true);
        $('#btn_approve').prop('disabled', true);
        $.ajax({
            url: '<?php echo base_url() ?>trusmi_approval/approve',
            type: 'POST',
            dataType: 'JSON',
            data: $('#formApprove').serialize(),
            success: function(response) {
                $('#formApprove')[0].reset();
                $('#btn_approve').prop('disabled', false);
                $('#btn_reject').prop('disabled', false);
                $('#modalApprove').modal('hide');
                approve_to = response.approve_to;
                requested_by = response.created_by;
                requested_at = response.created_at;
                requested_hour = response.created_hour;
                user_id_approve_to = response.user_id_approve_to;
                no_app = response.no_app;
                subject = response.subject;
                description = response.description;
                note = response.approve_note;
                nomorHp = response.created_by_contact;
                kategori = response.kategori;
                nominal = response.nominal;
                created_by_contact = [
                    nomorHp
                ];
                if (kategori != 'Eaf') {
                    msg = `📣 Alert!!!
Your Request Has Been Processed
📝 Approve To : ${approve_to}
👤 Requested By : ${requested_by}
🕐 Requested At : ${requested_at} | ${requested_hour}

No. App : ${no_app}
Subject : *${subject}*
Description : ${description}

Status : Approved ✅
Note : ${note}`;
                } else {
                    msg = `📣 Alert!!!
Your Request Has Been Processed
📝 Approve To : ${approve_to}
👤 Requested By : ${requested_by}
🕐 Requested At : ${requested_at} | ${requested_hour}

No. App : ${no_app}
Subject : *${subject}*
Description : ${description}

Status : Approved ✅
Note : ${note}
🌐 Link EAF : 
                    
https://trusmiverse.com/apps/login/eaf?u=${requested_by}&id=${no_app}`;
                }
                send_wa(created_by_contact, msg);



                window.location.href = "<?= base_url(); ?>/trusmi_approval";

                new PNotify({
                    title: `Success`,
                    text: `Request Approved`,
                    icon: 'icofont icofont-check',
                    type: 'success',
                    delay: 1500
                });
            }
        });
    }
    $('#form_resubmit').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        $('#btn_resubmit').attr('disabled', true);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>trusmi_approval/resubmit",
            data: form.serialize(),
            dataType: "json",
            success: function(response) {
                new PNotify({
                    title: `Success`,
                    text: `Request Sent!`,
                    icon: 'icofont icofont-check',
                    type: 'success',
                    delay: 1500
                });
                no_app = response.no_app;
                contact = response.approve_to_contact;
                user_id_approve_to = response.user_id_approve_to;
                approve_to = response.approve_to;
                requested_by = "<?= $this->session->userdata('nama'); ?>";
                requested_at = response.created_at;
                requested_hour = response.created_hour;
                leadtime = response.leadtime;
                subject = response.subject;
                description = response.description;
                array_contact = [
                    contact
                ];

                if (user_id_approve_to == 803) { // jika approval ke pa i maka cc juga ke mba lintang
                    array_contact.push('62895422833253');

                }
                msg = `📣 Alert!!!
*There is New Request Approval Resubmit*
📝 Approve To : ${approve_to}
👤 Requested By : ${requested_by}
🕐 Requested At : ${requested_at} | ${requested_hour}

No. App : ${no_app}
Subject : *${subject}*
Description : ${description}
🌐 Link Approve : 
                    
https://trusmiverse.com/apps/login/verify?u=${user_id_approve_to}&id=${no_app}`;
                send_wa(array_contact, msg);
                window.location.href = "<?= base_url(); ?>/trusmi_approval";
            }
        });
    });

    function compress(file_upload, string, submit, wait, done) {

        $(wait).show();
        $(done).hide();
        $(submit).prop('disabled', true);

        const file = document.querySelector(file_upload).files[0];

        extension = file.name.substr((file.name.lastIndexOf('.') + 1));

        if (!file) return;

        const reader = new FileReader();

        reader.readAsDataURL(file);

        reader.onload = function(event) {
            const imgElement = document.createElement("img");
            imgElement.src = event.target.result;

            if (extension == "jpg" || extension == "jpeg" || extension == "png" || extension == "gif") {

                extension = 'png,';

                imgElement.onload = function(e) {
                    const canvas = document.createElement("canvas");

                    if (e.target.width > e.target.height) {
                        const MAX_WIDTH = 1024;
                        const scaleSize = MAX_WIDTH / e.target.width;
                        canvas.width = MAX_WIDTH;
                        canvas.height = e.target.height * scaleSize;
                    } else {
                        const MAX_HEIGHT = 1024;
                        const scaleSize = MAX_HEIGHT / e.target.height;
                        canvas.height = MAX_HEIGHT;
                        canvas.width = e.target.width * scaleSize;
                    }

                    const ctx = canvas.getContext("2d");

                    ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);

                    const srcEncoded = ctx.canvas.toDataURL(e.target, "image/jpeg");

                    var g_string = extension + srcEncoded.substr(srcEncoded.indexOf(',') + 1);
                    // document.querySelector(string).value = g_string;
                    saveFile(g_string, wait, done, string, submit);
                }
            } else {
                var g_string = extension + ',' + event.target.result.substr(event.target.result.indexOf(',') + 1);
                // document.querySelector(string).value = g_string;
                saveFile(g_string, wait, done, string, submit);
            }


        }

        function saveFile(string, wait, done, str, submit) {

            $.ajax({
                'url': '<?php echo base_url() ?>trusmi_approval/upload_file',
                'type': 'POST',
                'data': {
                    string: string
                },
                'success': function(response) {
                    document.querySelector(str).value = response;
                    $(submit).prop('disabled', false);
                    $(wait).hide();
                    $(done).show();
                }
            });
        }
    }
</script>

<script>
    let chunks = [];
    let mediaRecorder;
    const recordBtn = document.getElementById('startRecord');
    const clearBtn = document.getElementById('clearBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const status = document.getElementById('txt_speech');
    const text = document.getElementById('text');

    recordBtn.addEventListener('click', async () => {
        if (!mediaRecorder || mediaRecorder.state === 'inactive') {
            const stream = await navigator.mediaDevices.getUserMedia({
                audio: true
            });
            mediaRecorder = new MediaRecorder(stream);
            chunks = [];
            isCancelled = false;

            mediaRecorder.ondataavailable = (e) => chunks.push(e.data);

            mediaRecorder.onstop = async () => {
                cancelBtn.disabled = true;
                recordBtn.innerHTML = '<i class="bi bi-mic"></i>';

                if (isCancelled) {
                    status.textContent = 'Dibatalkan oleh pengguna.';
                    text.textContent = '';
                    chunks = [];
                    return;
                }

                const blob = new Blob(chunks, {
                    type: 'audio/webm'
                });

                if (blob.size < 1000) {
                    status.textContent = 'Tidak ada suara terdeteksi.';
                    text.textContent = '';
                    return;
                }

                const formData = new FormData();
                formData.append('audio', blob, 'audio.webm');

                status.textContent = 'Uploading...';

                try {
                    const response = await fetch('https://www.trusmiverse.com/apps/upload-speech', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (result.text) {
                        $('#approve_note').val(result.text);
                        status.textContent = 'Done';
                    } else {
                        status.textContent = 'Tidak ada teks dikenali.';
                    }
                } catch (err) {
                    status.textContent = 'Terjadi kesalahan saat upload.';
                    console.error(err);
                }

                status.textContent = 'Selesai';
                chunks = [];
            };

            mediaRecorder.start();
            toggleWaveAnimation(true);
            status.textContent = 'Merekam...';
            recordBtn.textContent = 'Selesai';
            cancelBtn.disabled = false;
        } else {
            mediaRecorder.stop();
            toggleWaveAnimation(false);
        }
    });

    cancelBtn.addEventListener('click', () => {
        if (mediaRecorder && mediaRecorder.state === 'recording') {
            isCancelled = true;
            mediaRecorder.stop();
            toggleWaveAnimation(false);
        }
    });

    clearBtn.addEventListener('click', () => {
        $('#approve_note').val('');
    });

    function toggleWaveAnimation(active) {
        if (active) {
            document.querySelectorAll('.sound-wave .bar-idle').forEach(el => {
                el.classList.remove('bar-idle');
                el.classList.add('bar');
            });
        } else {
            document.querySelectorAll('.sound-wave .bar').forEach(el => {
                el.classList.remove('bar');
                el.classList.add('bar-idle');
            });
        }
    }
</script>