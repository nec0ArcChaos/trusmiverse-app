<script src="<?= base_url(); ?>assets/js/dashboard.js"></script>

<!-- fancybox JS -->
<script src="<?php echo base_url() ?>assets/fancybox/jquery.fancybox.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/selectize/selectize.min.js"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/font_awesome/js/all.min.js"></script>

<script>
    var s_month = new SlimSelect({
        select: '#month'
    });

    var s_year = new SlimSelect({
        select: '#year'
    });

    get_employee_id();

    function get_employee_id() {
        $.ajax({
            url: '<?= base_url() ?>dashboard/get_employee_id',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {
                // console.log(response);
                list_employee = '';
                for (let index = 0; index < response.length; index++) {
                    list_employee += `<option value="${response[index].user_id}">${response[index].employee_name}</option>`;
                }

                $("#employee_id").empty().append(list_employee);
                var s_employee_id = new SlimSelect({
                    select: '#employee_id'
                });
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    get_rekening()

    function get_rekening() {
        $.ajax({
            url: '<?= base_url() ?>dashboard/get_rekening',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {
                $('#p_account_number').html(response.account_number);
                $('#p_account_title').html(response.account_title);
                $('#p_bank_name').html(response.bank_name);
                $('#p_created_at').html(response.created_at);
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }



    let no_access = '<?= $this->session->flashdata('no_access'); ?>'
    if (no_access == 1) {
        error_alert("Anda tidak memiliki akses ke halaman tersebut!");
    }

    $("a.foto_absen").fancybox({
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'speedIn': 600,
        'speedOut': 200,
        'overlayShow': false
    });

    function error_alert(text) {
        new PNotify({
            title: `Oopss`,
            text: `${text}`,
            icon: 'icofont icofont-info-circle',
            type: 'error',
            delay: 3000,
        });
    }

    function resume_absen(periode, employee_id) {
        $.ajax({
            url: '<?= base_url('dashboard/resume_absen') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                periode: periode,
                employee_id: employee_id
            },
            beforeSend: function() {

            },
            success: function(response) {
                // console.log(response);
                // console.log(response.test);
                // console.log(response.data.harus_hadir);
                // console.log(response.total_hadir.harus_hadir);
                present = `<a href="#" data-bs-toggle="modal" data-bs-target="#modal_detail_absen">${response.data.total_hadir}</a>`;
                $("#present").empty().append(present);
                $("#late").text(response.data.menit_telat);
                $("#harus_hadir").text(response.total_hadir.harus_hadir);
                $("#bolos").text(response.data.bolos);
                $("#lock_video").text(response.data.lock_video);
                $("#lock_tasklist").text(response.data.lock_tasklist);
                $("#lock_eaf").text(response.data.lock_eaf);
                $("#lock_training").text(response.data.lock_training);
                $("#lock_other").text(response.data.lock_other);
                $("#leave").text(
                    parseInt(response.data.total_cuti_khusus) +
                    parseInt(response.data.total_dinas) +
                    parseInt(response.data.total_sakit)
                );

                kehadiran = (response.total_hadir.harus_hadir < 1) ? 0 : Math.round((response.data.total_hadir / response.total_hadir.harus_hadir) * 100) / 100;
                kedisiplinan = (response.total_hadir.harus_hadir < 1) ? 0 : Math.round(((response.data.total_hadir - response.data.telat - response.data.bolos - response.data.total_izin_pc_dt - response.data.absen_sekali) / response.total_hadir.harus_hadir) * 100) / 100;
                // console.log(kehadiran);
                // console.log(kedisiplinan);
                /* circular progress */

                /* circular progress */
                var progressCircles1 = new ProgressBar.Circle(circleprogressblueKehadiran, {
                    color: '#015EC2',
                    // This has to be the same size as the maximum width to
                    // prevent clipping
                    strokeWidth: 10,
                    trailWidth: 10,
                    easing: 'easeInOut',
                    trailColor: 'rgba(66, 157, 255, 0.15)',
                    duration: 1400,
                    text: {
                        autoStyleContainer: false
                    },
                    from: {
                        color: '#015EC2',
                        width: 10
                    },
                    to: {
                        color: '#015EC2',
                        width: 10
                    },
                    // Set default step function for all animate calls
                    step: function(state, circle) {
                        circle.path.setAttribute('stroke', state.color);
                        circle.path.setAttribute('stroke-width', state.width);

                        var value = Math.round(circle.value() * 100);
                        if (value === 0) {
                            //  circle.setText('');
                        } else {
                            // circle.setText(value + "<small>%<small>");
                        }

                    }
                });

                progressCircles1.animate(kehadiran);
                $("#txt_kehadiran").empty().text((kehadiran * 100) + '%');
                $("#circleprogressblue1").empty();
                var progressCirclesblue1 = new ProgressBar.Circle(circleprogressblue1, {
                    color: '#015EC2',
                    // This has to be the same size as the maximum width to
                    // prevent clipping
                    strokeWidth: 10,
                    trailWidth: 10,
                    easing: 'easeInOut',
                    trailColor: 'rgba(66, 157, 255, 0.15)',
                    duration: 1400,
                    text: {
                        autoStyleContainer: false
                    },
                    from: {
                        color: '#015EC2',
                        width: 10
                    },
                    to: {
                        color: '#015EC2',
                        width: 10
                    },
                    // Set default step function for all animate calls
                    step: function(state, circle) {
                        circle.path.setAttribute('stroke', state.color);
                        circle.path.setAttribute('stroke-width', state.width);

                        var value = Math.round(circle.value() * 100);
                        if (value === 0) {
                            circle.setText('');
                        } else {
                            circle.setText(value + "<small>%<small>");
                        }

                    }
                });
                // progressCirclesblue1.text.style.fontSize = '20px';
                progressCirclesblue1.animate(kehadiran); // Number from 0.0 to 1.0
                // /* circular progress */
                // var progressCirclesgreen1 = new ProgressBar.Circle(circleprogressgreen1, {
                //     color: '#91C300',
                //     // This has to be the same size as the maximum width to
                //     // prevent clipping
                //     strokeWidth: 10,
                //     trailWidth: 10,
                //     easing: 'easeInOut',
                //     trailColor: '#eaf4d8',
                //     duration: 1400,
                //     text: {
                //         autoStyleContainer: false
                //     },
                //     from: {
                //         color: '#91C300',
                //         width: 10
                //     },
                //     to: {
                //         color: '#91C300',
                //         width: 10
                //     },
                //     // Set default step function for all animate calls
                //     step: function(state, circle) {
                //         circle.path.setAttribute('stroke', state.color);
                //         circle.path.setAttribute('stroke-width', state.width);

                //         var value = Math.round(circle.value() * 100);
                //         if (value === 0) {
                //             circle.setText('');
                //         } else {
                //             circle.setText(value + "<small>%<small>");
                //         }

                //     }
                // });
                // // progressCirclesgreen1.text.style.fontSize = '20px';
                // progressCirclesgreen1.animate(0.85); // Number from 0.0 to 1.0

                /* circular progress */
                $("#circleprogressyellow1").empty();
                var progressCirclesyellow1 = new ProgressBar.Circle(circleprogressyellow1, {
                    color: '#fdba00',
                    // This has to be the same size as the maximum width to
                    // prevent clipping
                    strokeWidth: 10,
                    trailWidth: 10,
                    easing: 'easeInOut',
                    trailColor: '#fff2ce',
                    duration: 1400,
                    text: {
                        autoStyleContainer: false
                    },
                    from: {
                        color: '#fdba00',
                        width: 10
                    },
                    to: {
                        color: '#fdba00',
                        width: 10
                    },
                    // Set default step function for all animate calls
                    step: function(state, circle) {
                        circle.path.setAttribute('stroke', state.color);
                        circle.path.setAttribute('stroke-width', state.width);

                        var value = Math.round(circle.value() * 100);
                        if (value === 0) {
                            circle.setText('');
                        } else {
                            circle.setText(value + "<small>%<small>");
                        }

                    }
                });
                // progressCirclesyellow1.text.style.fontSize = '20px';
                progressCirclesyellow1.animate(kedisiplinan); // Number from 0.0 to 1.0

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    // function resume_izin_leave() {
    //     $.ajax({
    //         url: '<?= base_url('dashboard/resume_izin_leave') ?>',
    //         type: 'POST',
    //         dataType: 'json',
    //         beforeSend: function() {

    //         },
    //         success: function(response) {
    //             // console.log(response);
    //             present = `<a href="#" data-bs-toggle="modal" data-bs-target="#">${response.jml_izin}</a>`;
    //             $("#leave").empty().append(present);
    //         },
    //         error: function(xhr) { // if error occured

    //         },
    //         complete: function() {

    //         },
    //     });
    // }

    function filter_detail() {
        periode = $("#year").val() + '-' + $("#month").val();
        employee_id = $("#employee_id").val();
        // console.log(periode);
        // console.log(employee_id);
        resume_absen(periode, employee_id)
        detail_absen(periode, employee_id)
    }

    function detail_absen(periode, employee_id) {
        $.ajax({
            url: '<?= base_url('dashboard/detail_absen') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                periode: periode,
                employee_id: employee_id
            },
            beforeSend: function() {

            },
            success: function(response) {
                // console.log(response);
                item_detail_absen = ``;
                for (let index = 0; index < response.data.length; index++) {

                    if (response.data[index].photo_in != null) {
                        photo_in = `<a data-fancybox="gallery" href="https://trusmiverse.com/hr_upload/${response.data[index].photo_in}">
                        <figure class="avatar avatar-20 rounded-circle coverimg vm" style="background-image: url(&quot;https://trusmiverse.com/hr_upload/${response.data[index].photo_in}&quot;);">
                            <img src="https://trusmiverse.com/hr_upload/${response.data[index].photo_in}" alt="" id="userphotoonboarding2" style="display: none;">
                        </figure></a>`;
                    } else {
                        photo_in = '<h5 class="fw-medium small">No Photo<small></small></h5>';
                    }
                    if (response.data[index].photo_out != null) {
                        photo_out = `<a data-fancybox="gallery" href="https://trusmiverse.com/hr_upload/${response.data[index].photo_out}">
                        <figure class="avatar avatar-20 rounded-circle coverimg vm" style="background-image: url(&quot;https://trusmiverse.com/hr_upload/${response.data[index].photo_out}&quot;);">
                            <img src="https://trusmiverse.com/hr_upload/${response.data[index].photo_out}" alt="" id="userphotoonboarding2" style="display: none;">
                        </figure></a>`;
                    } else {
                        photo_out = '<h5 class="fw-medium small">No Photo<small></small></h5>';
                    }

                    border_late = '';
                    if (response.data[index].diff_in > 0) {
                        border_late = 'border-late';
                    }
                    late = '';
                    if (response.data[index].diff_in > 0) {
                        late = `(Late ${response.data[index].diff_in} mnt)`;
                    }
                    pulang = '';
                    if (response.data[index].diff_out < 0) {
                        pulang = `(Early ${response.data[index].diff_out} mnt)`;
                    }
                    if (response.data[index].diff_out > 0) {
                        pulang = `(Over ${response.data[index].diff_out} mnt)`;
                    }
                    item_detail_absen += `
                        <div class="card mb-1 mt-1">
                            <div class="card-body ${border_late}">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="circle-small">
                                            <div id="circleprogressblue"></div>
                                            <div class="avatar h5 bg-light-blue rounded-circle">
                                                <i class="bi bi-calendar2-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="row">
                                            <p class="text-dark small mb-1 col-12 col-md-6" style="font-weight: bold;">Tgl : ${response.data[index].attendance_date}</p>
                                            <p class="text-dark small mb-1 col-12 col-md-6">Shift : <span>${response.data[index].shift_in}</span> s/d <span>${response.data[index].shift_out}</span> </p>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                                <p class="text-secondary small mb-1">Clock In</p>
                                                <h5 class="fw-medium small">${response.data[index].clock_in}<small> ${late}</small></h5>
                                            </div>
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                                <p class="text-secondary small mb-1">Photo In</p>
                                                ${photo_in}
                                            </div>
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                                <p class="text-secondary small mb-1">Clock Out</p>
                                                <h5 class="fw-medium small">${response.data[index].clock_out ?? '-'}<small> ${pulang}</small></h5>
                                            </div>
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                                <p class="text-secondary small mb-1">Photo Out</p>
                                                ${photo_out}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                }
                $("#body_detail_absen").empty().append(item_detail_absen);
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    function check_lock_absen() {
        let user_id = "<?= $this->session->userdata("user_id"); ?>";
        $.ajax({
            url: `<?= base_url() ?>dashboard/check_lock_absen`,
            type: 'POST',
            dataType: 'json',
            data: {
                user_id: user_id
            },
            beforeSend: function() {

            },
            success: function(response) {
                console.log(response);
                console.log(response.status);
                console.log(response);
                console.log(response.achieve);
                status_lock = response.achieve;
                console.log(status_lock);
                if (status_lock == true) {
                    $("#card_lock_absen").addClass("bg-success");
                    $("#icon_lock_absen").addClass("bi bi-unlock");
                    $("#status_lock_basen").text("Unlocked");
                    $("#msg_lock_absen").text(response.message);
                } else if (status_lock == false) {
                    $("#card_lock_absen").addClass("bg-danger");
                    $("#icon_lock_absen").addClass("bi bi-lock");
                    $("#status_lock_basen").text("Locked");
                    $("#msg_lock_absen").text(response.message);
                } else {
                    // $("#card_lock_absen").addClass("bg-warning");

                }
                // console.log(response);
                // present = `<a href="#" data-bs-toggle="modal" data-bs-target="#modal_detail_absen">${response.present}</a>`;
                // $("#present").empty().append(present);
                // $("#late").text(response.dt + ' mnt');
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }
    check_lock_absen();
    resume_absen('<?= date("Y-m") ?>', '<?= $this->session->userdata("user_id"); ?>');
    // resume_izin_leave();
    detail_absen('<?= date("Y-m") ?>', '<?= $this->session->userdata("user_id"); ?>');


    $('#btn-update-rekening').on('click', function() {
        v_account_title = $('#p_account_title').text();
        v_account_number = $('#p_account_number').text();
        v_bank_name = $('#p_bank_name').text();
        $.confirm({
            title: 'Form Update Rekening!',
            theme: 'supervan',
            content: `
                <form action="" class="formName">
                    <div class="mb-3">
                        <label class="form-label-custom" style="float:left;">Account Bank Name :</label>
                        <select id="bank_name" name="bank_name" class="select" placeholder="Pilih Bank...">
								<option value="">Pilih Bank...</option>
                                <option value="Bank Mandiri" ${v_bank_name == 'Bank Mandiri'? 'selected':''}>Bank Mandiri</option>
                                <option value="Bank Central Asia (BCA)" ${v_bank_name == 'Bank Central Asia (BCA)'? 'selected':''}>Bank Central Asia (BCA)</option>
                                <option value="Bank Rakyat Indonesia (BRI)" ${v_bank_name == 'Bank Rakyat Indonesia (BRI)'? 'selected':''}>Bank Rakyat Indonesia (BRI)</option>
                                <option value="Bank Negara Indonesia (BNI)" ${v_bank_name == 'Bank Negara Indonesia (BNI)'? 'selected':''}>Bank Negara Indonesia (BNI)</option>
                                <option value="Bank Danamon" ${v_bank_name == 'Bank Danamon'? 'selected':''}>Bank Danamon</option>
                                <option value="Bank CIMB Niaga" ${v_bank_name == 'Bank CIMB Niaga'? 'selected':''}>Bank CIMB Niaga</option>
                                <option value="Bank Tabungan Negara (BTN)" ${v_bank_name == 'Bank Tabungan Negara (BTN)'? 'selected':''}>Bank Tabungan Negara (BTN)</option>
                                <option value="Bank Permata" ${v_bank_name == 'Bank Permata'? 'selected':''}>Bank Permata</option>
                                <option value="Bank Mega" ${v_bank_name == 'Bank Mega'? 'selected':''}>Bank Mega</option>
                                <option value="Bank Panin" ${v_bank_name == 'Bank Panin'? 'selected':''}>Bank Panin</option>
                                <option value="Bank Bukopin" ${v_bank_name == 'Bank Bukopin'? 'selected':''}>Bank Bukopin</option>
                                <option value="Bank OCBC NISP" ${v_bank_name == 'Bank OCBC NISP'? 'selected':''}>Bank OCBC NISP</option>
                                <option value="Bank Maybank Indonesia" ${v_bank_name == 'Bank Maybank Indonesia'? 'selected':''}>Bank Maybank Indonesia</option>
                                <option value="Bank Victoria Internasional" ${v_bank_name == 'Bank Victoria Internasional'? 'selected':''}>Bank Victoria Internasional</option>
                                <option value="Bank JTrust Indonesia" ${v_bank_name == 'Bank JTrust Indonesia'? 'selected':''}>Bank JTrust Indonesia</option>
						</select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom" style="float:left;">Account Number :</label>
                        <input type="text" name="account_number" id="account_number" value="${v_account_number}" placeholder="Nomor Rekening Bank" class="name form-control" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom" style="float:left;">Account Name :</label>
                        <input type="text" name="account_title" id="account_title" value="${v_account_title}" placeholder="Rekening Atas Nama ?" class="name form-control" required />
                    </div>
                </form>`,
            buttons: {
                cancel: function() {
                    //close
                },
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function() {
                        var account_title = this.$content.find('#account_title').val();
                        var account_number = this.$content.find('#account_number').val();
                        var bank_name = this.$content.find('#bank_name').val();
                        if (!bank_name) {
                            $.alert('provide a valid bank name');
                            return false;
                        }
                        if (!account_number) {
                            $.alert('provide a valid account number');
                            return false;
                        }
                        if (!account_title) {
                            $.alert('provide a valid account name');
                            return false;
                        }

                        $.ajax({
                            url: '<?= base_url() ?>dashboard/update_rekening',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                account_title: account_title,
                                account_number: account_number,
                                bank_name: bank_name,
                            },
                            beforeSend: function() {
                                $.confirm({
                                    icon: 'fa fa-spinner fa-spin',
                                    title: 'Mohon Tunggu!',
                                    theme: 'supervan',
                                    content: 'Kami sedang memproses permintaan Anda!',
                                    buttons: {
                                        close: {
                                            isHidden: true,
                                            actions: function() {}
                                        },
                                    },
                                });
                            },
                            success: function(response) {
                                get_rekening();
                                setTimeout(() => {
                                    jconfirm.instances[0].close();
                                    if (response.status == true) {
                                        $.confirm({
                                            icon: 'fa fa-check',
                                            title: 'Done!',
                                            theme: 'supervan',
                                            content: 'Terima kasih sudah menunggu!',
                                            buttons: {
                                                close: {
                                                    actions: function() {}
                                                },
                                            },
                                        });
                                    } else {
                                        $.confirm({
                                            icon: 'fa fa-check',
                                            title: 'Gagal!',
                                            theme: 'supervan',
                                            content: 'Silahkan coba beberapa saat lagi!',
                                            buttons: {
                                                close: {
                                                    actions: function() {}
                                                },
                                            },
                                        });
                                    }
                                }, 250);
                            },
                            error: function(xhr) { // if error occured

                            },
                            complete: function() {

                            },
                        });
                    }
                },
            },
            onContentReady: function() {
                $('.select').selectize({
                    sortField: 'text'
                });
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function(e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    });
</script>