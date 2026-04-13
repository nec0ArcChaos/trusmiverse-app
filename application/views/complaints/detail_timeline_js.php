<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/dragula/dragula.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/dropzone5-9-3/dropzone.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/paging.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/progressbar-js/progressbar.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/slimselect/slimselect.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>



<!-- Fomantic Or Semantic Ui -->
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/dropdown.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/transition.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/form.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/popup.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/toast.js"></script>

<!-- script state awal -->
<script>
    var user_role_id = "5428"
    var user_id = "5428"
    $(window).on("load", function() {
        // global uri
        id_task = "<?= $id_task; ?>";
        activateTab()

        $('.tanggal').datetimepicker({
            format: 'Y-m-d',
            timepicker: false,
            scrollMonth: false,
            scrollInput: false,
            minDate: 0

        });

        $('.tanggal-menit').datetimepicker({
            format: 'Y-m-d H:i:s',
            timepicker: true,
            scrollMonth: false,
            scrollInput: false,
            minDate: 0

        });

        $(".tanggal").mask('0000-00-00');
    });
</script>
<!-- /script state awal -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const emojis = document.querySelectorAll(".emoji-rating-respons");
        const ratingInput = document.getElementById("selected-rating-respons");

        emojis.forEach(emoji => {
            emoji.addEventListener("click", function() {
                emojis.forEach(e => e.classList.remove("active-icon"));
                this.classList.add("active-icon");
                ratingInput.value = this.getAttribute("data-value");
            });
        });
    });
    // document.addEventListener("DOMContentLoaded", function() {
    //     const emojis = document.querySelectorAll(".emoji-rating-pelayanan");
    //     const ratingInput = document.getElementById("selected-rating-pelayanan");

    //     emojis.forEach(emoji => {
    //         emoji.addEventListener("click", function() {
    //             emojis.forEach(e => e.classList.remove("active-icon"));
    //             this.classList.add("active-icon");
    //             ratingInput.value = this.getAttribute("data-value");
    //         });
    //     });
    // });
    document.addEventListener("DOMContentLoaded", function() {
        const emojis = document.querySelectorAll(".emoji-rating-kualitas");
        const ratingInput = document.getElementById("selected-rating-kualitas");

        emojis.forEach(emoji => {
            emoji.addEventListener("click", function() {
                emojis.forEach(e => e.classList.remove("active-icon"));
                this.classList.add("active-icon");
                ratingInput.value = this.getAttribute("data-value");
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const emojis = document.querySelectorAll(".emoji-rating-rekomendasi");
        const ratingInput = document.getElementById("selected-rating-rekomendasi");

        emojis.forEach(emoji => {
            emoji.addEventListener("click", function() {
                emojis.forEach(e => e.classList.remove("active-icon"));
                this.classList.add("active-icon");
                ratingInput.value = this.getAttribute("data-value");
            });
        });
    });

    document.getElementById("btn-send-feedback").addEventListener("click", function() {
        // Show loader
        $("#btn-send-feedback").empty().append("<i class='fa fa-spinner fa-spin'></i> Mengirim...").prop("disabled", true);


        id_task = "<?= $id_task; ?>";
        respons = $('#selected-rating-respons').val();
        // pelayanan = $('#selected-rating-pelayanan').val();
        kualitas = $('#selected-rating-kualitas').val();
        rekomendasi = $('#selected-rating-rekomendasi').val();
        feedback = $('#feedback').val();

        if ((respons < 5 || kualitas < 5 || rekomendasi < 5) && feedback == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Maaf!',
                theme: 'material',
                type: 'red',
                content: 'Mohon pastikan kritik dan saran diisi dengan lengkap.<br><br>Masukan anda sangat berarti untuk kami dalam<br>Meningkatkan kualitas pelayanan. <br> Terimakasih',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
            $("#btn-send-feedback").empty().append("Kirim Feedback").prop("disabled", false);
            return;
        }

        // Prepare AJAX request
        $.ajax({
            url: "<?= base_url('complaints/detail/send_feedback') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                id_task: id_task,
                respons: respons,
                pelayanan: 0,
                kualitas: kualitas,
                rekomendasi: rekomendasi,
                feedback: feedback,
            },
            success: function(response) {
                $("#btn-send-feedback").empty().append("Kirim Feedback").prop("disabled", false);
                // Handle success response
                if (response.status) {
                    // Optionally handle response
                    $.confirm({
                        icon: 'fa fa-check',
                        title: 'Success!',
                        theme: 'material',
                        type: 'green',
                        content: 'Feedback Berhasil disimpan!',
                        buttons: {
                            close: {
                                action: function() {
                                    detail_task(id_task);
                                }
                            },
                        },
                    });
                } else {
                    $.confirm({
                        icon: 'fa fa-check',
                        title: 'Oops!',
                        theme: 'material',
                        type: 'green',
                        content: response.message,
                        buttons: {
                            close: {
                                actions: function() {}
                            },
                        },
                    });
                }
            },
            error: function() {
                // Handle error
                // alert("An error occurred. Please try again later.");
            },
            complete: function() {}
        });
    });
</script>

<script>
    function timer(countDownDate, status) {
        var countDownDate = new Date(countDownDate).getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById("days").innerHTML = days;
            document.getElementById("hrs").innerHTML = hours
            document.getElementById("min").innerHTML = minutes
            document.getElementById("sec").innerHTML = seconds

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("timer").innerHTML = "Complaints is Overdue.";
            }
        }, 1000);
    }
</script>


<!-- Detail Task Start -->
<script>
    function detail_task(id_task) {
        $('#id_task_new_strategy').val(id_task);
        $('#e_id_status').dropdown_se('clear');
        $('#e_id_level').dropdown_se('clear');
        $('#e_id_pic').dropdown_se('set selected', '');
        $.confirm({
            icon: 'fa fa-spinner fa-spin',
            title: 'Please wait..',
            theme: 'material',
            type: 'blue',
            content: 'Loading...',
            animateFromElement: false,
            animation: 'RotateXR',
            closeAnimation: 'RotateXR',
            buttons: {
                close: {
                    isHidden: true,
                    actions: function() {}
                },
            },
            onOpen: function() {
                $.ajax({
                    url: `<?= base_url() ?>complaints/detail/get_detail_task`,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id_task: id_task
                    },
                    beforeSend: function() {

                    },
                    success: function(response) {},
                    error: function(xhr) {},
                    complete: function() {},
                }).done(function(response) {
                    if (response.status == true) {
                        jconfirm.instances[0].close();

                        if (response.detail.id_status == 3 || response.detail.id_status == 4) {
                            $('#div_resend_notif').addClass('d-none');
                        } else {
                            $('#div_resend_notif').removeClass('d-none');
                        }

                        if (response.detail.id_status > 1) {
                            $('#div_not_started').addClass('d-none');
                        } else {
                            $('#div_not_started').removeClass('d-none');
                        }

                        if (response.detail.id_rating != '') {
                            $('#div_form_rating').addClass('d-none');
                            $('#div_done_rating').removeClass('d-none');
                            $('#e_rating_kualitas_text').html("<i class='bi bi-star-fill text-warning'></i> ".repeat(response.detail.kualitas) + "<i class='bi bi-star text-muted'></i> ".repeat(5 - response.detail.kualitas));
                            $('#e_rating_respon_text').html("<i class='bi bi-star-fill text-warning'></i> ".repeat(response.detail.respons) + "<i class='bi bi-star text-muted'></i> ".repeat(5 - response.detail.respons));
                            $('#e_rating_rekomendasi_text').html("<i class='bi bi-star-fill text-warning'></i> ".repeat(response.detail.rekomendasi) + "<i class='bi bi-star text-muted'></i> ".repeat(5 - response.detail.rekomendasi));
                            $('#e_rating_avg_rating_text').html(response.detail.avg_rating);
                            $('#e_rating_feedback_text').text(response.detail.feedback);
                        } else if (response.detail.id_rating == '' && response.detail.id_status == 6) {
                            $('#div_form_rating').removeClass('d-none');
                            $('#div_done_rating').addClass('d-none');
                        } else {
                            $('#div_form_rating').addClass('d-none');
                            $('#div_done_rating').addClass('d-none');
                        }

                        $('#e_tgl_kunci_text').html(response.detail.tgl_kunci).removeClass().addClass('badge bg-light-yellow text-dark');
                        $('#e_tgl_kwh_text').html(response.detail.tgl_pemasangan_kwh).removeClass().addClass('badge bg-light-yellow text-dark');
                        $('#e_tgl_selesai_qc_text').html(response.detail.tgl_selesai_qc).removeClass().addClass('badge bg-light-yellow text-dark');
                        $('#e_umur_bangunan_text').html(response.detail.usia_bangunan+' Hari').removeClass().addClass('badge bg-light-yellow text-dark');
                        $('#e_nama_vendor_text').html(response.detail.nama_vendor).removeClass().addClass('badge bg-light-purple text-dark');

                        // Text Info
                        $('#e_object_text').text(response.detail.category);
                        $('#e_due_date_text').html(response.detail.due_date_2);
                        $('#e_timeline_text').text(response.detail.timeline);
                        $('#e_description_text').html(response.detail.description);
                        $('#e_type_text').html(response.detail.type).removeClass().addClass('badge bg-light-pink text-dark');
                        $('#e_category_second_title').html(response.detail.category);
                        $('#e_project_text').html(response.detail.project).removeClass().addClass('badge bg-light-yellow text-dark');
                        $('#e_blok_text').html(response.detail.blok).removeClass().addClass('badge bg-light-yellow text-dark');
                        $('#e_category_text').html(response.detail.category).removeClass().addClass('badge bg-light-yellow text-dark');
                        if (response.detail.tgl_aftersales != '-') {
                            $('#e_tgl_aftersales').html(`${response.detail.tgl_aftersales} (${response.detail.id_after_sales})`).removeClass().addClass('');
                        } else {
                            $('#e_tgl_aftersales').html(`${response.detail.tgl_aftersales}`).removeClass().addClass('');
                        }
                        $('#e_priority_text').html(response.detail.priority).removeClass().addClass('badge ' + response.detail.priority_color);
                        $('#e_level_text').html(response.detail.level).removeClass().addClass('badge ' + response.detail.level_color);
                        $('#e_status_text').html(response.detail.status).removeClass().addClass('badge ' + response.detail.status_color);
                        $('#e_requested_by_text').html(`${response.detail.requested_by}`);
                        $('#e_requested_at_text').html(`${response.detail.tgl_dibuat} | ${response.detail.jam_dibuat} WIB`);

                        $('#e_verified_by_text').html(`<span class="badge bg-light-purple text-dark" style="margin-bottom: 3px;">${response.detail.verified_by}</span>`);

                        if (response.detail.tgl_verified != '') {
                            $('#e_verified_at_text').html(`<span class="badge bg-light-red text-dark" style="margin-bottom: 3px;">${response.detail.tgl_verified} | ${response.detail.jam_verified} WIB</span>`);
                        } else {
                            $('#e_verified_at_text').html('<span class="badge bg-light-yellow text-dark">waiting</span>');
                        }
                        if (response.detail.tgl_escalation != '') {
                            $('#e_escalation_at_text').html(`<span class="badge bg-light-red text-dark">${response.detail.tgl_escalation} | ${response.detail.jam_escalation} WIB</span>`);
                        } else {
                            $('#e_escalation_at_text').html('<span class="badge bg-light-yellow text-dark">waiting</span>');
                        }
                        $('#e_escalation_by_text').html(`<span class="badge bg-light-purple text-dark" style="margin-bottom: 3px;">${response.detail.escalation_by}</span>`);

                        $('#e_requested_company_text').html(response.detail.requested_company);
                        $('#e_requested_department_text').html(response.detail.requested_department);
                        $('#e_requested_designation_text').html(response.detail.requested_designation);
                        $('#div_e_progress_text').empty().append(`
                            <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated ${response.detail.status_color}" role="progressbar" style="width: ${Math.round(response.detail.progress * 1) / 1}%;" aria-valuenow="${Math.round(response.detail.progress * 1) / 1}" aria-valuemin="0" aria-valuemax="100">${Math.round(response.detail.progress * 1) / 1}%</div>
                            </div>`);


                        $('#detail_id_task').val(response.detail.id_task);
                        $('#modal_detail_task_label').text(response.detail.task);

                        $('#e_start_timeline').val(response.detail.start);
                        $('#e_end_timeline').val(response.detail.end);
                        $('#e_verified_note').val(response.detail.verified_note);
                        $('#e_escalation_note').val(response.detail.escalation_note);
                        $('#e_note').val('');
                        $('#e_progress').val(response.detail.progress);


                        $('#e_id_task').val(response.detail.id_task);
                        $('#e_task').val(response.detail.task);
                        $('#e_task_text').text(response.detail.task);

                        $('#e_description_div').html(response.detail.description);

                        if (response.detail.due_date != '') {
                            $('#e_due_date').val(response.detail.due_date);
                            $('#e_start_timeline').val(response.detail.start);
                            $('#e_end_timeline').val(response.detail.end);
                        }

                        $('#e_pic_text').text(response.detail.team_name);

                        if (response.detail.id_status > 1) {
                            $('#e_id_status option[value="' + 1 + '"]').attr("disabled", true);
                        }

                        page_uri = "<?= $this->uri->segment(4); ?>";
                        if (page_uri == "kanban") {
                            detail_status_after = $('#detail_status_after').val();
                            if (detail_status_after != "") {
                                $('#e_id_status').val(detail_status_after);
                                if (detail_status_after > 1) {
                                    $('#e_id_status option[value="' + 1 + '"]').attr("disabled", true);
                                }
                            }
                        }

                        user_id = '5428'
                        if (response.detail.id_status == 1 && user_id == response.detail.verified_user_id) {
                            $('#footer-update').removeClass('d-none')
                            $('#title_update').empty().text('Verifikasi')
                            $('#div_e_verified_note').removeClass('d-none')
                            $('#btn_update_task').removeAttr('onclick');
                            $('#btn_update_task').attr('onclick', 'update_verifikasi()');
                            $('#btn_update_task').text('Save Verifikasi');
                            $('#div_e_level').addClass('d-none')
                            $('#div_e_id_pic').addClass('d-none')
                            $('#div_e_timeline').addClass('d-none')
                            $('#div_e_escalation_note').addClass('d-none')
                            $('#div_e_progress').addClass('d-none')
                            $('#div_e_pic_note').addClass('d-none')

                        } else if (response.detail.id_status == 2 && user_id == response.detail.escalation_user_id) {
                            $('#footer-update').removeClass('d-none')
                            $('#title_update').empty().text('Eskalasi')
                            $('#btn_update_task').removeAttr('onclick');
                            $('#btn_update_task').attr('onclick', 'update_eskalasi()');
                            $('#btn_update_task').text('Save Eskalasi');
                            $('#div_e_level').removeClass('d-none')
                            $('#div_e_id_pic').removeClass('d-none')
                            $('#div_e_timeline').removeClass('d-none')
                            $('#div_e_verified_note').addClass('d-none')
                            $('#div_e_escalation_note').removeClass('d-none')
                            $('#e_verified_note').attr('readonly', 'readonly')
                            $('#div_e_progress').addClass('d-none')
                            $('#div_e_pic_note').addClass('d-none')


                        } else if (response.detail.id_status == 4 && response.detail.id_pic.includes(user_id)) {
                            $('#footer-update').removeClass('d-none')
                            $('#title_update').empty().text('Pengerjaan')
                            $('#btn_update_task').removeAttr('onclick');
                            $('#btn_update_task').attr('onclick', 'update_pengerjaan()');
                            $('#btn_update_task').text('Save');
                            $('#div_e_id_priority').addClass('d-none')
                            $('#div_e_level').addClass('d-none')
                            $('#div_e_id_pic').addClass('d-none')
                            $('#div_e_timeline').addClass('d-none')
                            $('#div_e_verified_note').addClass('d-none')
                            $('#div_e_escalation_note').addClass('d-none')
                            $('#e_verified_note').attr('readonly', 'readonly')
                            $('#e_escalation_note').attr('readonly', 'readonly')
                            $('#div_e_progress').removeClass('d-none')
                            $('#div_e_id_status').removeClass('d-none')
                            $('#div_e_pic_note').removeClass('d-none')
                        } else {
                            $('#footer-update').addClass('d-none')
                            $('#div_e_id_status').addClass('d-none')
                            $('#div_e_id_priority').addClass('d-none')
                            $('#div_e_progress').addClass('d-none')
                            $('#div_e_level').addClass('d-none')
                            $('#div_e_id_pic').addClass('d-none')
                            $('#div_e_timeline').addClass('d-none')
                            $('#div_e_verified_note').addClass('d-none')
                            $('#div_e_escalation_note').addClass('d-none')
                            $('#div_e_pic_note').addClass('d-none')
                        }

                        document.getElementById("timer").innerHTML = response.detail.status;
                        if (response.detail.id_status == 4) {
                            timer(response.detail.due_date)
                        } else {
                            $('#div_timer').addClass('d-none');
                        }

                        get_attachment(id_task);

                    } else {
                        setTimeout(() => {
                            jconfirm.instances[0].close();
                            $.confirm({
                                icon: 'fa fa-check',
                                title: 'Oops!',
                                theme: 'material',
                                type: 'red',
                                content: 'Server Busy, Try Again Later!',
                                buttons: {
                                    close: {
                                        actions: function() {}
                                    },
                                },
                            });
                        }, 250);
                    }
                }).fail(function(jqXHR, textStatus) {
                    setTimeout(() => {
                        jconfirm.instances[0].close();
                        $.confirm({
                            icon: 'fa fa-close',
                            title: 'Oops!',
                            theme: 'material',
                            type: 'red',
                            content: 'Failed!' + textStatus,
                            buttons: {
                                close: {
                                    actions: function() {}
                                },
                            },
                        });
                    }, 250);
                });
            },

        });
    }

    function activateTab() {
        id_task = $('#detail_id_task').val();

        detail_task(id_task);
        show_log_timeline(id_task);
    }


    function show_log_timeline(id_task) {
        $.ajax({
            url: "<?= base_url('complaints/detail/get_log_history_timeline') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                id_task: id_task,
            },
            beforeSend: function() {
                $('#spinner_loading').show();
            },
            success: function(response) {
                body_timeline_history = '';
                setTimeout(() => {
                    response.log.forEach((value, index) => {
                        if (value.status == 'Request Rejected' || value.status == 'Unsolved') {
                            _theme = 'theme-red'
                        } else if (value.status == 'Request Approved' || value.status == 'Done') {
                            _theme = 'theme-green'
                        } else if (value.status == 'Waiting Approval' || value.status == 'On Scheduled' || value.status == 'On Process') {
                            _theme = 'theme-orange'
                        } else {
                            _theme = 'theme-blue'
                        }

                        if (value.status != value.status_before) {
                            _sbadge = `<div class="col-12">
                                            <span style="cursor:unset;font" class="btn btn-link btn-sm mb-1 mt-1 ${value.status_before_color}">${value.status_before}</span> 
                                                <i class="bi bi-chevron-right text-muted" style="font-size:12pt"></i> 
                                            <span style="cursor:unset;font" class="btn btn-link btn-sm mb-1 mt-1 ${value.status_color}">${value.status}</span>
                                        </div>`
                        } else {
                            _sbadge = ''
                        }

                        if (value.photo.includes(',')) {
                            const photos = value.photo.split(',');
                            _avatar_profile = `<div class="col-auto avatar-group">`
                            photos.forEach(photo => {
                                _avatar_profile += `<figure class="avatar avatar-30 rounded-circle coverimg overlay-ms-15" data-bs-toggle="tooltip" data-bs-placement="top" style="background-image: url(&quot;${photo.trim()}&quot;);">
                                                        <img src="${photo.trim()}" alt="" style="display: none;">
                                                    </figure>`
                            });
                            _avatar_profile += `</div>`
                        } else {
                            _avatar_profile = `<div class="col-auto">
                                                    <div class="avatar avatar-30 bg-light-theme text-theme rounded-circle">
                                                        <img src="${value.photo}" alt="">
                                                    </div>
                                                </div>`
                        }

                        body_timeline_history += `
                                <li class="${_theme} left-timeline">
                                    <div class="card border-0 mb-4 mb-lg-5">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                ${_avatar_profile}
                                                <div class="col ps-0 ms-0">
                                                    <p class="text-theme mb-0">${value.jenis}</p>
                                                    <p class="mb-0 small">${value.tgl_history}</p>
                                                </div>
                                            </div>
                                            <hr class="m-1">
                                            <div class="col">
                                                <p class="mb-2 small">PIC : ${value.employee}</p>
                                                ${_sbadge}
                                                <p class="mb-2 mt-2 small">Note :<br>${value.note}</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>`
                    });
                }, 500);
            },
            complete: function() {
                setTimeout(() => {
                    $('#spinner_loading').fadeOut();
                    $('#body_timeline_history').html(body_timeline_history);

                    // activate_footable();

                    body_timeline_history = '';
                }, 500);
            }
        })
    }

    function truncateString(str, maxLength) {
        if (str == null) {
            str = '';
        }
        if (str.length > maxLength) {
            return str.substring(0, maxLength - 3) + '...';
        } else {
            return str;
        }
    }

    function get_attachment(id_task) {
        body_files_page = '';
        base_url = "https://trusmiverse.com/apps/uploads/complaints";
        $.ajax({
            url: "<?= base_url('complaints/detail/get_attachment') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                id_task: id_task,
            },
            beforeSend: function() {
                $('#nama_file').val('');
                $('#fileInput').val('');
                $('#file_string').val('');
            },
            success: function(response) {
                // console.info(response)
                if (response.attachment.length > 0) {
                    response.attachment.forEach((value, index) => {

                        // ${generate_file_attachment(base_url, value.file)}
                        imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
                        if (value.type_file == 'pdf') {
                            img_file_div = `<div class="h-150 bg-red text-white d-flex align-items-center">
                                            <h1 class="col-12 text-center"><i class="bi bi-file-earmark-pdf"></i> PDF</h1>
                                        </div>`
                        } else if (value.type_file == 'xls' || value.type_file == "xlsx") {
                            img_file_div = `<div class="h-150 bg-green text-white d-flex align-items-center">
                                            <h1 class="col-12 text-center"><i class="bi bi-file-earmark-spreadsheet"></i> EXCEL</h1>
                                        </div>`
                        } else if (value.type_file == 'doc' || value.type_file == "docx") {
                            img_file_div = `<div class="h-150 bg-blue text-white d-flex align-items-center">
                                            <h1 class="col-12 text-center"><i class="bi bi-file-earmark-word"></i> WORD</h1>
                                        </div>`
                        } else if (value.type_file == 'ppt' || value.type_file == "pptx") {
                            img_file_div = `<div class="h-150 bg-yellow text-white d-flex align-items-center">
                                            <h1 class="col-12 text-center"><i class="bi bi-filetype-ppt"></i> PPT</h1>
                                        </div>`
                        } else if (imageExtensions.includes(value.type_file)) {
                            img_file_div = `<div class="h-150 coverimg" style="background-image: url(&quot;<?= base_url() ?>uploads/complaints/${value.file}&quot;);">
                                        </div>`
                        } else {
                            img_file_div = `<div class="h-150">
                                        </div>`
                        }
                        body_files_page +=
                            `<div class="col-12 col-md-4 col-lg-4 col-xl-3 mb-4">
                                    <div class="card border-0 overflow-hidden">
                                        ${img_file_div}
                                        <div class="card-footer bg-none">
                                            <div class="row gx-3 align-items-center">
                                                <div class="col-12 col-md-2">
                                                    <a href="<?= base_url() ?>uploads/complaints/${value.file}" target="_blank" class="avatar avatar-30 rounded text-red mr-3">
                                                        <i class="bi bi-download h5 vm"></i>
                                                    </a>
                                                </div>
                                                <div class="col-12 col-md-10">
                                                    <p class="mb-0 small">${value.created_by}</p>
                                                    <p style="font-size:8pt;" class="text-secondary">${value.times}</p>
                                                    <p style="font-size:8pt;" class="text-secondary text-turncate">${value.filename}</p>
                                                </div>
                                                <div class="col-12">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                    });
                } else {
                    body_files_page = `
                                <div class="col-12">
                                    <div class="card border-0 overflow-hidden">
                                        <div class="card-footer bg-none">
                                            <div class="row gx-3 align-items-center">
                                                <div class="col-12 col-md-10">
                                                    <p class="mb-0 small">No Files</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    `;
                }
                $('#body_files_page').html(body_files_page)
            },
            complete: function() {}
        })

    }

    function generate_file_attachment(base_url, filename) {
        ext = filename.split('.').pop();

        imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
        if (imageExtensions.includes(ext)) {
            return `<img src="${base_url}/${filename}" class="h-150" alt="" />`
        } else if (ext == "pdf") {
            return `<center><a href="${base_url}/${filename}" target="_blank" class="avatar avatar-100 rounded bg-red text-white">
                        <i class="bi bi-file-earmark-pdf vm" style="font-size: 50px"></i>
                    </a></center>`
        } else if (ext == "ppt" || ext == "pptx") {
            return `<center><a href="${base_url}/${filename}" target="_blank" class="avatar avatar-100 rounded bg-red text-white">
                        <i class="bi bi-filetype-ppt vm" style="font-size: 50px"></i>
                    </a></center>`
        } else if (ext == "doc" || ext == "docx") {
            return `<center><a href="${base_url}/${filename}" target="_blank" class="avatar avatar-100 rounded bg-red text-white">
                        <i class="bi bi-file-earmark-word-fill vm" style="font-size: 50px"></i>
                    </a></center>`
        } else if (ext == "xls" || ext == "xlsx") {
            return `<center><a href="${base_url}/${filename}" target="_blank" class="avatar avatar-100 rounded bg-red text-white">
                        <i class="bi bi-file-earmark-x-fill vm" style="font-size: 50px"></i>
                    </a></center>`
        } else {
            return `<img src="${base_url}/${filename}" class="h-150" alt="" />`
        }

        // return ''
    }

    function remove_invalid(id) {
        $(`#${id}`).removeClass('is-invalid')
    }

    function convert_duedate_detail(dateString) {
        var dateObject = new Date(dateString);
        var monthNames = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];
        var day = dateObject.getDate();
        var month = monthNames[dateObject.getMonth()];
        var formattedDate = day + ' ' + month;
        return formattedDate;
    }
</script>
<!-- /Detail Task Start -->