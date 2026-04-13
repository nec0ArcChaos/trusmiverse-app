<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script type="text/javascript"
    src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
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
    var user_role_id = "<?= $this->session->userdata('user_id'); ?>"
    var user_id = "<?= $this->session->userdata('user_id'); ?>"
    $(window).on("load", function () {
        // global uri
        id_task = "<?= $id_task; ?>";

        // console.log(id_task);

        activateTab('complaints')

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

        $('#div_e_evidence').removeClass('d-none');
    });

    $('#e_id_type').dropdown_se();
    $('#e_id_category').dropdown_se();
    $('#e_id_object').dropdown_se();
    $('#e_id_priority').dropdown_se();
    $('#e_id_level').dropdown_se();
    $('#e_id_pic').dropdown_se();
    $('#e_id_status').dropdown_se();

</script>
<!-- /script state awal -->

<script>
    function timer(countDownDate, status) {
        var countDownDate = new Date(countDownDate).getTime();

        // Update the count down every 1 second
        var x = setInterval(function () {

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


<!-- Description Sumernote -->
<script>
    $('#description').summernote({
        placeholder: 'Complaints Description',
        tabsize: 2,
        height: 120,
        toolbar: [
            ['font', ['bold', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
        ]
    });

    let sum_e_comment = $('#e_comment').summernote({
        placeholder: 'Input here...',
        tabsize: 2,
        height: 100,
        toolbar: false
    });
    sum_e_comment.summernote('code', '');
</script>
<!-- /Description Sumernote -->





<!-- PIC Start -->
<script>
    function e_get_pic(e_id_category = '', e_id_pic = '') {
        $.ajax({
            url: '<?= base_url() ?>complaints/main/get_pic',
            type: 'POST',
            dataType: 'json',
            data: {
                id_category: e_id_category
            },
            beforeSend: function () {

            },
            success: function (response) {

            },
            error: function (xhr) { // if error occured

            },
            complete: function () {

            },
        }).done(function (response) {
            user_id = "<?= $this->session->userdata('user_id'); ?>"
            list_pic = '<option value="">Choose PIC</option>';
            if (response != null) {
                for (let index = 0; index < response.length; index++) {
                    if (response[index].ticket == 0) {
                        ticket_onprogress = '';
                    } else {
                        ticket_onprogress = '(' + response[index].ticket + ' complain)';

                    }
                    list_pic += `<option value="${response[index].id_pic}">${response[index].pic} ${ticket_onprogress}</option>`;
                }
            }
            $("#e_id_pic").empty().append(list_pic);
            $("#e_id_pic").dropdown_se('clear');
            if (e_id_pic != '') {
                $.each(e_id_pic.split(","), function (i, e) {
                    $("#e_id_pic option[value='" + e + "']").prop("selected", true);
                    $("#e_id_pic").dropdown_se('set selected', e);
                });
            }
        }).fail(function (jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }
</script>
<!-- PIC End -->



<!-- Priority Start -->
<script>
    function e_get_priority(id_priority = '') {
        $.ajax({
            url: '<?= base_url() ?>complaints/main/get_priority',
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {

            },
            success: function (response) {

            },
            error: function (xhr) { // if error occured

            },
            complete: function () {

            },
        }).done(function (response) {
            // console.log(response);
            list_priority = '<option value="">Choose Priority</option>';
            for (let index = 0; index < response.length; index++) {
                list_priority += `<option value="${response[index].id_priority}" ${response[index].id_priority == id_priority ? 'selected' : ''}>${response[index].priority}</option>`;
            }
            $("#e_id_priority").empty().append(list_priority)
            $('#e_id_priority').dropdown_se('set selected', id_priority);
        }).fail(function (jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }
</script>
<!-- Priority End -->


<!-- Level Start -->
<script>
    e_get_level()

    function e_get_level(id_level = '') {
        $.ajax({
            url: '<?= base_url() ?>complaints/main/get_level',
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {

            },
            success: function (response) {

            },
            error: function (xhr) { // if error occured

            },
            complete: function () {

            },
        }).done(function (response) {
            // console.log(response);
            list_level = '<option value="">Choose level</option>';
            for (let index = 0; index < response.length; index++) {
                list_level += `<option value="${response[index].id_level}" ${response[index].id_level == id_level ? 'selected' : ''}>${response[index].level}</option>`;
            }
            $("#e_id_level").empty().append(list_level)
            $('#e_id_level').dropdown_se('set selected', id_level);
        }).fail(function (jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }
</script>
<!-- Level End -->

<!-- Detail Task Start -->
<script>
    function e_get_status(id_status = '', reschedule = 0) {
        // console.log('id_status ' + id_status)
        $.ajax({
            url: '<?= base_url() ?>complaints/main/get_status',
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                $('#e_id_status').empty().append('<option value=""><i class="fa fa-spinner fa-spin"></i> Loading..</option>').prop('disabled', true);
            },
            success: function (response) {

            },
            error: function (xhr) { // if error occured

            },
            complete: function () {

            },
        }).done(function (response) {
            // console.log(response);
            $('#e_id_status').prop('disabled', false)
            e_list_status = '<option value="">Choose Object</option>';
            if (response != null) {
                for (let index = 0; index < response.length; index++) {
                    if (parseInt(id_status) == 1) {
                        if (parseInt(response[index].id_status) < 4) {
                            e_list_status += `<option value="${response[index].id_status}" ${response[index].id_status == id_status ? 'selected' : ''}>${response[index].status}</option>`;
                        }
                    } else if (parseInt(id_status) == 2) {
                        status_eskalasi = ['4', '5'];
                        if (status_eskalasi.includes(response[index].id_status)) {
                            e_list_status += `<option value="${response[index].id_status}" ${response[index].id_status == id_status ? 'selected' : ''}>${response[index].status}</option>`;
                        }
                    } else if (parseInt(id_status) == 4 || parseInt(id_status) == 8 || parseInt(id_status) == 9) {
                        if (reschedule == 0) {
                            status_eskalasi = ['4', '6', '7', '8'];
                        } else if (reschedule == 1) {
                            status_eskalasi = ['4', '6', '7', '9'];
                        } else {
                            status_eskalasi = ['4', '6', '7'];
                        }
                        if (status_eskalasi.includes(response[index].id_status)) {
                            e_list_status += `<option value="${response[index].id_status}" ${response[index].id_status == id_status ? 'selected' : ''}>${response[index].status}</option>`;
                        }
                    } else {
                        e_list_status += `<option value="${response[index].id_status}" ${response[index].id_status == id_status ? 'selected' : ''}>${response[index].status}</option>`;
                    }
                }
            }
            $("#e_id_status").empty().append(e_list_status);
            $('#e_id_status').val(id_status);
            $('#e_id_status').dropdown_se('set selected', id_status);
        }).fail(function (jqXhr, textStatus) {
            console.log("Failed Get Object")
        });
    }

    $('#e_due_date').on('change', function () {
        let due_date = $('#e_due_date').val();
        $('#e_end_timeline').val(due_date + ' 23:00:00');
    });


    let type_e_id_status = document.getElementById("e_id_status");
    type_e_id_status.addEventListener("change", function () {
        $('#div_e_evidence').addClass('d-none');
        if (type_e_id_status.value == "1" || type_e_id_status.value == "2") {
            // $('#e_progress').val(0)
            $('#div_e_evidence').addClass('d-none');
        } else if (type_e_id_status.value == "6") {
            $('#e_progress').val(100);
            $('#div_e_evidence').removeClass('d-none');
        } else if (type_e_id_status.value == "4") {
            $('#div_e_evidence').removeClass('d-none');
        } else if (type_e_id_status.value == "8" || type_e_id_status.value == "9") {
            $('#div_e_timeline').removeClass('d-none')
            $('#div_e_evidence').removeClass('d-none');
            console.log(type_e_id_status.value);
        } else {
            // $('#e_progress').val(0)
        }
    });

    function detail_task(id_task) {
        $('#div_e_evidence').removeClass('d-none');
        $('#id_task_new_strategy').val(id_task);
        $('#e_id_status').dropdown_se('clear');
        $('#e_id_level').dropdown_se('clear');
        $('#e_id_pic').dropdown_se('set selected', '');
        $('#e_pic_note').val('');
        $('#e_escalation_note').val('');
        $('#e_verified_note').val('');
        // $('#evidence').val('');
        // $('#evidence').reset();
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
                    actions: function () { }
                },
            },
            onOpen: function () {
                $.ajax({
                    url: `<?= base_url() ?>complaints/main/get_detail_task`,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id_task: id_task
                    },
                    beforeSend: function () {

                    },
                    success: function (response) { },
                    error: function (xhr) { },
                    complete: function () { },
                }).done(function (response) {
                    // console.log(response.status)
                    console.log(response.detail)
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


                        // Text Info
                        $('#e_object_text').text(response.detail.object);
                        $('#e_due_date_text').html(response.detail.due_date_2);
                        $('#e_timeline_text').text(response.detail.timeline);
                        $('#e_description_text').html(response.detail.description);
                        $('#e_type_text').html(response.detail.type).removeClass().addClass('badge bg-light-pink text-dark');
                        $('#e_category_second_title').html(response.detail.category);
                        $('#e_project_text').html(response.detail.project).removeClass().addClass('badge bg-light-yellow text-dark');
                        $('#e_blok_text').html(response.detail.blok).removeClass().addClass('badge bg-light-yellow text-dark');
                        $('#e_category_text').html(response.detail.category).removeClass().addClass('badge bg-light-yellow text-dark');
                        if (response.detail.tgl_aftersales != '-') {
                            $('#e_tgl_aftersales').html(`${response.detail.tgl_aftersales} (${response.detail.id_after_sales})`).removeClass().addClass('badge bg-light-yellow text-dark');
                        } else {
                            $('#e_tgl_aftersales').html(`${response.detail.tgl_aftersales}`).removeClass().addClass('badge bg-light-yellow text-dark');
                        }
                        $('#e_priority_text').html(response.detail.priority).removeClass().addClass('badge ' + response.detail.priority_color);
                        $('#e_level_text').html(response.detail.level).removeClass().addClass('badge ' + response.detail.level_color);
                        $('#e_status_text').html(response.detail.status).removeClass().addClass('badge ' + response.detail.status_color);
                        $('#e_requested_by_text').html(`<span class="badge bg-light-purple text-dark" style="margin-bottom: 3px;">${response.detail.requested_by}</span><br><span class="badge bg-light-yellow text-dark">${response.detail.requested_contact_no}</span> <a class="badge bg-light-green text-green" href="https://api.whatsapp.com/send?phone=${response.detail.requested_contact_no}" target="_blank"><i class="bi bi-whatsapp text-success"></i> Chat</a>`);
                        $('#e_requested_at_text').html(`<span class="badge bg-light-red text-dark">${response.detail.tgl_dibuat} | ${response.detail.jam_dibuat} WIB</span>`);

                        $('#e_verified_by_text').html(`<span class="badge bg-light-purple text-dark" style="margin-bottom: 3px;">${response.detail.verified_by}</span><br><span class="badge bg-light-yellow text-dark">${response.detail.verified_contact_no}</span> <a class="badge bg-light-green text-green" href="https://api.whatsapp.com/send?phone=${response.detail.verified_contact_no}" target="_blank"><i class="bi bi-whatsapp text-success"></i> Chat</a>`);

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
                        $('#e_escalation_by_text').html(`<span class="badge bg-light-purple text-dark" style="margin-bottom: 3px;">${response.detail.escalation_by}</span><br><span class="badge bg-light-yellow text-dark">${response.detail.escalation_contact_no}</span> <a class="badge bg-light-green text-green" href="https://api.whatsapp.com/send?phone=${response.detail.escalation_contact_no}" target="_blank"><i class="bi bi-whatsapp text-success"></i> Chat</a>`);

                        $('#e_requested_company_text').html(response.detail.requested_company);
                        $('#e_requested_department_text').html(response.detail.requested_department);
                        $('#e_requested_designation_text').html(response.detail.requested_designation);
                        $('#div_e_progress_text').empty().append(`
                            <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated ${response.detail.status_color}" role="progressbar" style="width: ${Math.round(response.detail.progress * 1) / 1}%;" aria-valuenow="${Math.round(response.detail.progress * 1) / 1}" aria-valuemin="0" aria-valuemax="100">${Math.round(response.detail.progress * 1) / 1}%</div>
                            </div>`);

                        // dt_detail_sub_task(id_task);
                        // get_timeline(id_task);

                        $('#detail_id_task').val(response.detail.id_task);
                        $('#modal_detail_task_label').text(response.detail.task);

                        $('#e_start_timeline').val(response.detail.start);
                        $('#e_end_timeline').val(response.detail.end);
                        $('#e_verified_note').val(response.detail.verified_note);
                        $('#e_escalation_note').val(response.detail.escalation_note);
                        $('#e_note').val('');
                        $('#e_progress').val(response.detail.progress);
                        // console.log(Math.round(response.detail.progress * 100) / 100);


                        $('#e_id_task').val(response.detail.id_task);
                        $('#e_task').val(response.detail.task);
                        $('#e_task_text').text(response.detail.task);

                        $('#e_description_div').html(response.detail.description);

                        if (response.detail.due_date != '') {
                            $('#e_due_date').val(response.detail.due_date);
                            $('#e_start_timeline').val(response.detail.start);
                            $('#e_end_timeline').val(response.detail.end);
                        }

                        e_get_priority(response.detail.id_priority);
                        e_get_pic(response.detail.id_category, response.detail.id_pic);

                        $('#e_pic_text').text(response.detail.team_name);

                        if (response.detail.id_status > 1) {
                            $('#e_id_status option[value="' + 1 + '"]').attr("disabled", true);
                        }

                        // console.log(response.detail.id_status);

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

                        e_get_status(response.detail.id_status, response.detail.reschedule);

                        user_id = '<?= $this->session->userdata('user_id'); ?>';



                        if (response.detail.id_status == 1 && user_id == response.detail.verified_user_id) {
                            console.log('kebuka');

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


                        } else if ((response.detail.id_status == 4 || response.detail.id_status == 8 || response.detail.id_status == 9) && response.detail.id_pic.includes(user_id)) {
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

                        get_attachment_detail_page(id_task);

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
                                        actions: function () { }
                                    },
                                },
                            });
                        }, 250);
                    }
                }).fail(function (jqXHR, textStatus) {
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
                                    actions: function () { }
                                },
                            },
                        });
                    }, 250);
                });
            },

        });
    }

    function activateTab(id) {
        id_task = $('#detail_id_task').val();
        $('.detail_pages').hide();
        var tabs = document.querySelectorAll('.nav-link');
        tabs.forEach(function (tab) {
            tab.classList.remove('active');
        });
        var clickedTab = document.querySelector(`#nav_${id}`);
        clickedTab.classList.add('active');

        $('.detail_pages').hide();
        $(`#${id}_page`).show();

        // console.log(id);
        // console.log(id_task);
        if (id == "complaints") {
            detail_task(id_task);
        } else if (id == "activity") {
            show_log_history(id_task);
        } else if (id == "comment") {
            show_get_comment(id_task);
        } else if (id == "files") {
            get_attachment(id_task);
        }
    }


    function show_log_history(id_task) {
        base_url = "http://trusmiverse.com/hr/uploads/profile";
        body_log_history = '';
        $('#body_log_history').html('');
        // $('#dt_log_history').paging('destroy');


        $.ajax({
            url: "<?= base_url('complaints/main/get_log_history') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                id_task: id_task,
            },
            beforeSend: function () {
                $('#spinner_loading').show();
                // $('#activity_page').hide();
                // $('#files_page').hide();
                $('#activity_page').fadeOut();

            },
            success: function (response) {
                // console.info(response)
                body_log_history = '';
                setTimeout(() => {
                    response.log.forEach((value, index) => {
                        body_log_history += `<tr>
                            <td><small><small>${calculate_time_history_log_detail(value.datetime)}</small></small></td>
                            <td>
                                <div class="avatar avatar-30 coverimg rounded-circle me-1"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="${value.employee}">
                                    <img src="${base_url}/${value.photo}" alt="">
                                </div>
                            </td>
                            <td><small>${get_jenis_log_detail(value.jenis)}</small></td>
                            <td><small>${generate_history_change_detail(value)}<small></td>
                        </tr>`
                    });
                }, 500);

            },
            complete: function () {
                setTimeout(() => {
                    $('#spinner_loading').fadeOut();
                    $('#activity_page').fadeIn();
                    $('#body_log_history').html(body_log_history);

                    // activate_footable();

                    body_log_history = '';
                }, 500);
            }
        })
    }

    function activate_footable() {
        $('.footable').footable({
            "paging": {
                "enabled": true,
                "container": '.footable-pagination',
                "countFormat": "{CP} of {TP}",
                "limit": 10,
                "position": "right",
                // "size": 4
            },
            "sorting": {
                "enabled": true
            },
        }, function (ft) {
            $('.footablestot').html($('.footable-pagination-wrapper .label').html())

            $('.footable-pagination-wrapper ul.pagination li').on('click', function () {
                setTimeout(function () {
                    $('.footablestot').html($('.footable-pagination-wrapper .label').html());
                }, 200);
            });

        });
    }

    function calculate_time_history_log_detail(time_string) {
        var targetDate = new Date(time_string);
        var currentDate = new Date();
        var timeDifference = currentDate - targetDate;
        var daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
        var hoursDifference = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var monthDifference = (currentDate.getMonth() + 1) - (targetDate.getMonth() + 1);
        var yearDifference = currentDate.getFullYear() - targetDate.getFullYear();

        if (yearDifference > 0) {
            // return `<i class="bi bi-clock"></i> ${yearDifference}y`
            return `<small>${convert_duedate_detail(time_string)}</small>`
        } else if (monthDifference > 0) {
            // return `<i class="bi bi-clock"></i> ${monthDifference}m`
            return `<small>${convert_duedate_detail(time_string)}</small>`
        } else if (daysDifference > 0) {
            // return `<i class="bi bi-clock"></i> ${daysDifference}d`
            return `<small>${convert_duedate_detail(time_string)}</small>`
        } else if (hoursDifference > 0) {
            return `<i class="bi bi-clock"></i> ${hoursDifference}h`
            // return `<small>${convert_duedate_detail(time_string)}</small>`
        } else {
            timeOnly = time_string.split(' ')[1].substring(0, 5);
            // const hours = parseInt(timeOnly.split(':')[0]);
            // let meridiem = 'am';
            // if (hours >= 12) {
            //     meridiem = 'pm';
            // }
            // return `${timeOnly} ${meridiem}`
            return convertTo12HourFormatDetail(timeOnly);
        }
    }

    function convertTo12HourFormatDetail(time24) {
        // Extract hours and minutes from the time string
        const [hours, minutes] = time24.split(':');

        // Convert hours to 12-hour format
        const hours12 = hours % 12 || 12; // If hours is 0, convert to 12

        // Determine if it's AM or PM
        const period = hours < 12 ? 'am' : 'pm';

        // Create the 12-hour time string
        const time12 = `${String(hours12).padStart(2, '0')}:${minutes} ${period}`;

        return time12;
    }

    function get_jenis_log_detail(jenis) {
        if (jenis == 'created') {
            jenis_log = `<small><i class="bi bi-pen"></i> Created</small>`
        } else if (jenis == 'progress') {
            jenis_log = `<small><i class="bi bi-percent text-success"></i> Progress</small>`
        } else if (jenis == 'status') {
            jenis_log = `<small><img class="status_img" src="<?= base_url() ?>/assets/img/color_status.png" style="max-width:8%; height:auto"> Status</small>`
        } else if (jenis == 'evaluasi') {
            jenis_log = `<small><i class="bi bi-clipboard-data"></i> Evaluasi</small>`
        } else if (jenis == 'note') {
            jenis_log = `<small><i class="bi bi-chat-right-text"></i> Note</small>`
        } else {
            jenis_log = ``
        }
        return jenis_log;
    }

    function generate_history_change_detail(value) {
        if (value.jenis == 'created') {
            history_change = `<small>${value.history}</small>`
        } else if (value.jenis == 'progress') {
            history_change = `<small>
                                <table>
                                    <tr>
                                        <td rowspan="2">${generate_type_badge(value.status.trim())}</td> 
                                        <td rowspan="2">${generate_progres_badge_log(value.progress, value.status.trim())}</td> 
                                        <td><i class="text-muted">strategy: </i>${value.history}</td>
                                    </tr> 
                                    <tr>
                                        <td><i class="text-muted">note: </i>${value.note}</td>
                                    </tr> 
                                </table>
                                </small>`
        } else if (value.jenis == 'status') {
            history_change = `<small>${generate_status_history(value.status_before)} <i class="bi bi-chevron-right text-muted" style="font-size:8pt"></i> ${generate_status_history(value.status)}<small>`
        } else if (value.jenis == 'evaluasi') {
            history_change = `<small>
                                <table>
                                    <tr>
                                        <td rowspan="2">${generate_type_badge(value.status.trim())}</td> 
                                        <td rowspan="2">${generate_progres_badge_log(value.progress, value.status.trim())}</td> 
                                        <td><i class="text-muted">strategy: </i>${value.sub_task}</td>
                                    </tr> 
                                    <tr>
                                        <td><i class="text-muted">Evaluasi: </i>${value.history}</td>
                                    </tr> 
                                </table>
                                </small>`
        } else if (value.jenis == 'note') {
            history_change = `<small>${value.history}</small>`
        } else {
            history_change = ``
        }
        return history_change;
    }

    function generate_type_badge(id) {
        if (id == '1' || id == 'Daily') { // 1: Daily
            return `<span class="btn btn-sm btn-link bg-light-theme theme-cyan"><small>D</small></span>`
        } else if (id == '2' || id == 'Weekly') { // 2: Weekly
            return `<span class="btn btn-sm btn-link bg-light-theme theme-yellow"><small>W</small></span>`
        } else if (id == '3' || id == 'Montly') { // 3: Montly
            return `<span class="btn btn-sm btn-link bg-light-theme theme-red"><small>M</small></span>`
        } else if (id == '4' || id == 'Twice') { // 4: Twice
            return `<span class="btn btn-sm btn-link bg-light-theme theme-green"><small>T</small></span>`
        } else {
            return ``
        }
    }

    function generate_progres_badge_log(progress, status = null) {

        if (status == '1' || status == 'Daily') { // 1: Daily
            return `<span class="btn btn-sm btn-link bg-light-theme theme-cyan"><small>${progress}%</small></span>`
        } else if (status == '2' || status == 'Weekly') { // 2: Weekly
            return `<span class="btn btn-sm btn-link bg-light-theme theme-yellow"><small>${progress}%</small></span>`
        } else if (status == '3' || status == 'Montly') { // 3: Montly
            return `<span class="btn btn-sm btn-link bg-light-theme theme-red"><small>${progress}%</small></span>`
        } else if (status == '4' || status == 'Twice') { // 4: Twice
            return `<span class="btn btn-sm btn-link bg-light-theme theme-green"><small>${progress}%</small></span>`
        } else {
            return ``
        }

        // if (progress >= 100) {
        //     return `<span class="btn btn-sm btn-link bg-light-green text-dark"><small>${progress}%</small></span>`
        // } else if (progress > 75) {
        //     return `<span class="btn btn-sm btn-link bg-light-cyan text-dark"><small>${progress}%</small></span>`
        // } else if (progress > 35) {
        //     return `<span class="btn btn-sm btn-link bg-light-blue text-dark"><small>${progress}%</small></span>`
        // } else if (progress >= 0) {
        //     return `<span class="btn btn-sm btn-link bg-light-red text-dark"><small>${progress}%</small></span>`
        // } else {
        //     return ``
        // }
    }

    function generate_status_history(status) {
        if (status == 'Not Started') {
            badge = `<span class="btn btn-link btn-sm bg-secondary text-white">${status}</span>`
        } else if (status == 'Working On') {
            badge = `<span class="btn btn-link btn-sm bg-yellow text-white">${status}</span>`
        } else if (status == 'Done') {
            badge = `<span class="btn btn-link btn-sm bg-green text-white">${status}</span>`
        } else if (status == 'Stuck') {
            badge = `<span class="btn btn-link btn-sm bg-red text-white">${status}</span>`
        } else {
            badge = ``
        }
        return badge;
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
            url: "<?= base_url('complaints/main/get_attachment') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                id_task: id_task,
            },
            beforeSend: function () {
                $('#spinner_loading').show();
                // $('#files_page').hide();
                // $('#body_files_page').empty();
                $('.detail_pages').hide();
                $('#nama_file').val('');
                $('#fileInput').val('');
                $('#file_string').val('');
            },
            success: function (response) {
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
                            `<div class="col-12 col-md-6 col-lg-6 col-xl-6 mb-4">
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
            complete: function () {
                setTimeout(() => {
                    $('#spinner_loading').hide();
                    $('.detail_pages').hide();
                    $('#files_page').show();
                }, 500);
            }
        })

    }



    function get_attachment_detail_page(id_task) {
        body_files_page = '';
        base_url = "https://trusmiverse.com/apps/uploads/complaints";
        $.ajax({
            url: "<?= base_url('complaints/main/get_attachment') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                id_task: id_task,
            },
            beforeSend: function () { },
            success: function (response) {
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
                            `<div class="col-12 col-md-3 col-lg-3 col-xl-3 mb-4">
                                    <div class="card border-0 overflow-hidden">
                                        ${img_file_div}
                                        <div class="card-footer bg-none">
                                            <div class="row gx-3 align-items-center">
                                                <div class="col-12 col-md-2">
                                                    <a href="<?= base_url() ?>uploads/complaints/${value.file}" target="_blank" class="avatar avatar-30 rounded text-red mr-3">
                                                        <i class="bi bi-download h5 vm"></i>
                                                    </a>
                                                </div>
                                                <div class="col-12 col-md-10 text-start">
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
                $('#body_files_page_detail').html(body_files_page)
            },
            complete: function () { }
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

    function addFileInput() {
        $('#fileInput').trigger('click');

    }

    function hide_upload_toast() {
        $('#liveToast').hide()
    }

    function file_selected() {
        var fileInput = document.getElementById('fileInput');
        var file = fileInput.files[0];
        $('#file_string').val(file.name);
        // console.info(`file.name ${file.name}`)

        document.getElementById('uploaded_preview').src = window.URL.createObjectURL(file);

    }

    function upload_file() {
        id_task = $('#detail_id_task').val();

        file_name = $('#nama_file').val();
        file_string = $('#file_string').val();

        if (file_name == '') {
            $('#nama_file').addClass('is-invalid')
        } else if (file_string == '') {
            $('#file_string').addClass('is-invalid')
        } else {

            var form = $('#fileForm')[0];
            var formData = new FormData(form);
            formData.append('id_task', id_task);

            $('#liveToast').show();
            $('#upload_check').hide();
            $('#spinner_upload').show();

            document.getElementById('myProgressBar').setAttribute('aria-valuenow', 0);
            document.getElementById('myProgressBar').style.width = 0 + '%';

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressUpload, false);
            ajax.open("POST", "<?= base_url('complaints/main/upload_file') ?>", true);
            ajax.send(formData);
            ajax.onload = function () {
                // console.log('DONE: ', ajax.status);
                // console.log(ajax.status);
                // console.info(JSON.parse(ajax.responseText));
                if (ajax.status == 200) {

                    response = JSON.parse(ajax.responseText);
                    // console.info(response)
                    get_attachment(id_task);

                    setTimeout(() => {
                        hide_upload_toast();
                        console.info('hide toast')
                    }, 5000);

                }
            }

        }

    }

    function remove_invalid(id) {
        $(`#${id}`).removeClass('is-invalid')
    }

    function progressUpload(event) {
        var percent = (event.loaded / event.total) * 100;
        // document.getElementsByClassName("progress_bar")[0].style.width = Math.round(percent) + '%';
        // document.getElementsByClassName("status_bar")[0].innerHTML = Math.round(percent) + "% completed";
        document.getElementById('myProgressBar').setAttribute('aria-valuenow', Math.round(percent));
        document.getElementById('myProgressBar').style.width = Math.round(percent) + '%';

        $('#btn_save_upload').hide();

        $("#uploaded_status").html('Uploading ...');
        var fileInput = document.getElementById('fileInput');
        var preview = document.getElementById('uploaded_preview');
        var file = fileInput.files[0];
        var reader = new FileReader();
        reader.onloadend = function () {
            preview.src = reader.result;
        }
        $('#uploaded_preview').attr('src',)
        nama_file = $('#nama_file').val();
        $('#uploaded_name').html(nama_file);
        current_datetime = "<?= date('Y-m-d H:i:s') ?>";
        $('#uploaded_date').html(current_datetime);

        if (Math.round(percent) == 100) {
            setTimeout(() => {
                $('#spinner_upload').hide();
                $('#upload_check').show();
                $("#uploaded_status").html('Upload Success');
                $('#btn_save_upload').show();
            }, 500);
        }
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

    // COMMENT
    function show_get_comment(id_task) {
        base_url = "http://trusmiverse.com/hr/uploads/profile";
        body_get_comment = '';
        $('#body_get_comment').html('');
        $.ajax({
            url: "<?= base_url('complaints/main/get_comment') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                id_task: id_task,
            },
            beforeSend: function () {
                $('#spinner_loading').show();
                $('#body_get_comment').fadeOut();
            },
            success: function (response) {
                // console.info(response)
                body_get_comment = '';
                setTimeout(() => {
                    response.comment.forEach((value_comment, index) => {
                        if (value_comment.reply_to == '') {
                            body_get_reply = '';
                            response.reply.forEach((value_reply, index) => {
                                if (value_reply.reply_to == value_comment.id_comment) {
                                    body_get_reply += `
                                            <div class="border-0 mb-2 mt-2">
                                                <div class="">
                                                    <div class="row">
                                                        <div class="col-auto">
                                                            <figure class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;${base_url}/${value_reply.profile_picture}&quot;);">
                                                                <img src="${base_url}/${value_reply.profile_picture}" alt="" style="display: none;">
                                                            </figure>
                                                        </div>
                                                        <div class="col align-self-center ps-1">
                                                            <div class="row g-0">
                                                                <div class="col-12">
                                                                    <p class="text-truncate mb-0 small">${value_reply.employee_name}</p>
                                                                    <div class="text-dark text-wrap m-0 mt-2 small" style="font-size: small !important;">${value_reply.comment}</div>
                                                                </div>
                                                                <div class="col-12 mt-1">
                                                                    <p class="text-secondary small mb-0">${value_reply.times}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>`
                                }
                            });
                            body_get_comment +=
                                `<div class="card border-0 mb-2">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto">
                                                <figure class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;${base_url}/${value_comment.profile_picture}&quot;);">
                                                    <img src="${base_url}/${value_comment.profile_picture}" alt="" style="display: none;">
                                                </figure>
                                            </div>
                                            <div class="col align-self-center ps-2 border-start">
                                                <div class="row g-0">
                                                    <div class="col-12">
                                                        <p class="text-truncate mb-0 small">${value_comment.employee_name}</p>
                                                        <div class="text-dark text-wrap m-0 mt-2 small" style="font-size: small !important;">${value_comment.comment}</div>
                                                    </div>
                                                    <div class="col-12 mt-1">
                                                        <p class="text-secondary small mb-0">${value_comment.times} | <a role="button" class="text-primary" onclick="create_comment_section('${value_comment.id_task}','${value_comment.id_comment}')">Reply</a></p>
                                                    </div>
                                                </div>
                                                <div class="row g-0">
                                                    <div id="reply_section_${value_comment.id_comment}" class="col-12"></div>
                                                    <div id="reply_content_${value_comment.id_comment}" class="col-12 mt-2">
                                                        ${body_get_reply}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`
                        }
                    });
                }, 500);

            },
            complete: function () {
                setTimeout(() => {
                    $('#spinner_loading').hide();
                    $('#body_get_comment').fadeIn();
                    $('#comment_page').show();
                    $('#body_get_comment').html(body_get_comment);
                    body_get_comment = '';
                    // activate_footable()
                }, 500);
            }
        })
    }


    // Create Reply Section
    function create_comment_section(id_task, id_comment) {
        $(`#reply_section_${id_comment}`).fadeOut()
        reply_content = `<div class="border-0 mb-2">
                            <div class="">
                                <div class="row">
                                    <div class="col-12 mt-2">
                                        <textarea name="e_reply_${id_comment}" id="e_reply_${id_comment}" cols="30" rows="5"></textarea>
                                    </div>
                                    <div class="col text-end mt-2">
                                        <button class="btn btn-sm btn-link" onclick="clear_comment_section('${id_task}','${id_comment}')"><i class="bi bi-close"></i> Cancel</button>
                                        <button class="btn btn-sm btn-theme" onclick="save_reply('${id_task}','${id_comment}')"><i class="bi bi-send"></i> Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>`
        setTimeout(() => {
            $(`#reply_section_${id_comment}`).empty().append($(reply_content).hide().fadeIn(1500)).fadeIn(1000);
            let sum_e_reply = $(`#e_reply_${id_comment}`).summernote({
                placeholder: 'Input here...',
                tabsize: 2,
                height: 100,
                toolbar: false
            });
            sum_e_reply.summernote('code', '');
        }, 250);
    }

    function save_reply(id_task, id_comment) {
        let val_e_id_task = $('#e_id_task').val();
        let val_e_reply = $(`#e_reply_${id_comment}`).val();
        if (val_e_reply == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, cannot send empty reply',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else {
            // $.confirm({
            //     icon: 'fa fa-spinner fa-spin',
            //     title: 'Please Wait!',
            //     theme: 'material',
            //     type: 'blue',
            //     content: 'Loading...',
            //     buttons: {
            //         close: {
            //             isHidden: true,
            //             actions: function() {}
            //         },
            //     },
            //     onOpen: function() {
            $.ajax({
                url: `<?= base_url() ?>complaints/main/save_reply`,
                type: 'POST',
                dataType: 'json',
                data: {
                    id_comment: id_comment,
                    id_task: val_e_id_task,
                    comment: val_e_reply
                },
                beforeSend: function () {

                },
                success: function (response) { },
                error: function (xhr) { },
                complete: function () { },
            }).done(function (response) {
                if (response == true) {
                    setTimeout(() => {
                        // $('#e_comment').text('');
                        sum_e_comment.summernote('code', '');
                        show_get_comment(val_e_id_task);
                        jconfirm.instances[0].close();
                        $.confirm({
                            icon: 'fa fa-check',
                            title: 'Done!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Success!',
                            buttons: {
                                close: {
                                    actions: function () { }
                                },
                            },
                        });
                    }, 250);
                } else {
                    setTimeout(() => {
                        jconfirm.instances[0].close();
                        show_get_comment(val_e_id_task);
                        $.confirm({
                            icon: 'fa fa-check',
                            title: 'Oops!',
                            theme: 'material',
                            type: 'red',
                            content: 'Server Busy, Try Again Later!',
                            buttons: {
                                close: {
                                    actions: function () { }
                                },
                            },
                        });
                    }, 250);
                }
            }).fail(function (jqXHR, textStatus) {
                setTimeout(() => {
                    show_get_comment(val_e_id_task);
                    jconfirm.instances[0].close();
                    $.confirm({
                        icon: 'fa fa-close',
                        title: 'Oops!',
                        theme: 'material',
                        type: 'red',
                        content: 'Failed!' + textStatus,
                        buttons: {
                            close: {
                                actions: function () { }
                            },
                        },
                    });
                }, 250);
            });
            //         },
            //     });
        }

    }
    // /Create Reply Section


    // Clear Reply Section
    function clear_comment_section(id_task, id_comment) {
        $(`#reply_section_${id_comment}`).fadeOut(1000).empty();
    }
    // /Clear Reply Section


    function hitung_lsa() {
        let lsa_id_pic = $("#e_id_pic").val();
        let lsa_id_sub_type = $("#e_id_category").find("option:selected").attr('data-id_sub_type');
        let lsa_id_priority = $("#e_id_priority").val();
        let lsa_id_level = $("#e_id_level").val();
        $.ajax({
            url: '<?= base_url() ?>complaints/main/check_lsa',
            type: 'POST',
            dataType: 'json',
            data: {
                id_pic: lsa_id_pic.toString(),
                id_sub_type: lsa_id_sub_type,
                id_priority: lsa_id_priority,
                id_level: lsa_id_level,
            },
            beforeSend: function () {
                $('#div_lsa').empty()
            },
            success: function (response) {

            },
            error: function (xhr) { // if error occured

            },
            complete: function () {

            },
        }).done(function (response) {
            // console.log(response)
            if (response.eskalasi_time != 0 && response.eksekusi_time != 0) {
                let eskalasi_convert_hour = SplitTime(response.eskalasi_time);
                let eksekusi_convert_hour = SplitTime(response.eksekusi_time);
                $('#div_lsa').empty().append(`
                                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                                        <div>
                                            <p>Eskalasi Time : ${eskalasi_convert_hour.Days + ' Hari ' + eskalasi_convert_hour.Hours + ' jam ' + eskalasi_convert_hour.Minutes + ' Menit'}</p>
                                            <p>Eksekusi Time : ${eksekusi_convert_hour.Days + ' Hari ' + eksekusi_convert_hour.Hours + ' jam ' + eksekusi_convert_hour.Minutes + ' Menit'}</p>
                                        </div>
                                    </div>`).hide().fadeIn();
                $('#e_due_date').val(response.due_date);
                $('#e_start_timeline').val(response.eksekusi_start);
                $('#e_end_timeline').val(response.eksekusi_end);
            }
        }).fail(function (jqXhr, textStatus) {

        });
    }

    function SplitTime(numberOfMinutes) {
        let Hours = numberOfMinutes % (24 * 60);
        let Days = Math.floor((numberOfMinutes / 60) / 24);
        let Minutes = numberOfMinutes % 60;
        return ({
            "Days": Days,
            "Hours": Hours,
            "Minutes": Minutes
        })
    }


    function update_verifikasi() {
        let val_e_id_task = $('#e_id_task').val();
        let val_e_id_status = $('#e_id_status').val();
        let val_e_id_priority = $('#e_id_priority').val();
        let val_e_verified_note = $('#e_verified_note').val();

        if (val_e_id_task == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, id task not found',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_id_status == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, status must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_id_priority == "" && val_e_id_status != '3') {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, priority must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_verified_note == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, note must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else {
            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please Wait!',
                theme: 'material',
                type: 'blue',
                content: 'Loading...',
                buttons: {
                    close: {
                        isHidden: true,
                        actions: function () { }
                    },
                },
                onOpen: function () {
                    $.ajax({
                        url: `<?= base_url() ?>complaints/main/update_verifikasi`,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id_task: val_e_id_task,
                            id_status: val_e_id_status,
                            id_priority: val_e_id_priority,
                            verified_note: val_e_verified_note,
                        },
                        beforeSend: function () {

                        },
                        success: function (response) { },
                        error: function (xhr) { },
                        complete: function () { },
                    }).done(function (response) {
                        if (response.update_verifikasi == true) {
                            jconfirm.instances[0].close();
                            detail_task(val_e_id_task);
                            if (response.status == 2) {
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan approve verifikasi ke <b>${response.requester_name}</b>`
                                });
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan eskalasi ke <b>${response.escalation_name}</b>`
                                });
                            }

                            if (response.status == 3) {
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan reject ke <b>${response.requester_name}</b>`
                                });
                            }
                        } else {
                            jconfirm.instances[0].close();
                            detail_task(val_e_id_task);
                            setTimeout(() => {
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Oops!',
                                    theme: 'material',
                                    type: 'red',
                                    content: 'Server Busy, Try Again Later!',
                                    buttons: {
                                        close: {
                                            actions: function () { }
                                        },
                                    },
                                });
                            }, 250);
                        }
                    }).fail(function (jqXHR, textStatus) {
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
                                        actions: function () { }
                                    },
                                },
                            });
                        }, 250);
                    });
                },
            });
        }

    }



    function update_task() {
        let val_e_id_task = $('#e_id_task').val();
        let val_e_id_status = $('#e_id_status').val();
        let val_e_id_priority = $('#e_id_priority').val();
        let val_e_id_level = $('#e_id_level').val();
        let val_e_id_pic = $('#e_id_pic').val();
        let val_e_progress = $('#e_progress').val();
        let val_e_note = $('#e_note').val();
        let val_e_due_date = $('#e_due_date').val();
        let val_e_start_timeline = $('#e_start_timeline').val();
        let val_e_end_timeline = $('#e_end_timeline').val();

        let val_e_id_type = '';
        let val_e_id_category = '';
        let val_e_id_object = '';
        // console.log('status ' + val_e_id_status);
        if (val_e_id_status == '1') {
            val_e_id_type = $('#e_id_type').val();
            val_e_id_category = $('#e_id_category').val();
            val_e_id_object = $('#e_id_object').val();
        }

        if (val_e_id_task == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, id task not found',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_due_date == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, due date must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_id_pic.toString() == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, pic must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_start_timeline == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, start timeline must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_end_timeline == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, end timeline must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_id_status == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, status must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_id_priority == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, priority must be choosen',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_id_level == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, level must be choosen',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
            // } else if (val_e_note == "") {
            //     $.confirm({
            //         icon: 'fa fa-close',
            //         title: 'Oops!',
            //         theme: 'material',
            //         type: 'red',
            //         content: 'Oops, note must be filled',
            //         buttons: {
            //             close: {
            //                 actions: function() {}
            //             },
            //         },
            //     });
        } else {
            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please Wait!',
                theme: 'material',
                type: 'blue',
                content: 'Loading...',
                buttons: {
                    close: {
                        isHidden: true,
                        actions: function () { }
                    },
                },
                onOpen: function () {
                    $.ajax({
                        url: `<?= base_url() ?>complaints/main/update_task`,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id_task: val_e_id_task,
                            id_type: val_e_id_type,
                            id_category: val_e_id_category,
                            id_object: val_e_id_object,
                            id_status: val_e_id_status,
                            id_priority: val_e_id_priority,
                            id_level: val_e_id_level,
                            id_pic: val_e_id_pic.toString(),
                            progress: val_e_progress,
                            note: val_e_note,
                            due_date: val_e_due_date,
                            start_timeline: val_e_start_timeline,
                            end_timeline: val_e_end_timeline,
                        },
                        beforeSend: function () {

                        },
                        success: function (response) { },
                        error: function (xhr) { },
                        complete: function () { },
                    }).done(function (response) {
                        if (response == true) {
                            $('#e_id_level').dropdown_se('set selected', '');
                            $('#e_id_priority').dropdown_se('set selected', '');
                            detail_task(val_e_id_task);
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Done!',
                                    theme: 'material',
                                    type: 'blue',
                                    content: 'Success!',
                                    buttons: {
                                        close: {
                                            actions: function () { }
                                        },
                                    },
                                });
                            }, 250);
                        } else {
                            detail_task(val_e_id_task);
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
                                            actions: function () { }
                                        },
                                    },
                                });
                            }, 250);
                        }
                    }).fail(function (jqXHR, textStatus) {
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
                                        actions: function () { }
                                    },
                                },
                            });
                        }, 250);
                    });
                },
            });
        }

    }




    function update_eskalasi() {
        let val_e_id_task = $('#e_id_task').val();
        let val_e_id_status = $('#e_id_status').val();
        let val_e_id_priority = $('#e_id_priority').val();
        let val_e_id_level = $('#e_id_level').val();
        let val_e_id_pic = $('#e_id_pic').val();
        let val_e_escalation_note = $('#e_escalation_note').val();
        let val_e_due_date = $('#e_due_date').val();
        let val_e_start_timeline = $('#e_start_timeline').val();
        let val_e_end_timeline = $('#e_end_timeline').val();

        if (val_e_id_task == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, id task must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_id_status == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, status must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_id_priority == "" && val_e_id_status != '5') {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, priority must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_id_level == "" && val_e_id_status != '5') {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, priority must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_id_pic.toString() == "" && val_e_id_status != '5') {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, pic must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_due_date == "" && val_e_id_status != '5') {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, due date must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_start_timeline == "" && val_e_id_status != '5') {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, start timeline must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_end_timeline == "" && val_e_id_status != '5') {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, end timeline must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_id_priority == "" && val_e_id_status != '5') {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, priority must be choosen',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_id_level == "" && val_e_id_status != '5') {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, level must be choosen',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_escalation_note == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Note Eskalasi must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else {
            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please Wait!',
                theme: 'material',
                type: 'blue',
                content: 'Loading...',
                buttons: {
                    close: {
                        isHidden: true,
                        actions: function () { }
                    },
                },
                onOpen: function () {
                    $.ajax({
                        url: `<?= base_url() ?>complaints/main/update_eskalasi`,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id_task: val_e_id_task,
                            id_status: val_e_id_status,
                            id_priority: val_e_id_priority,
                            id_level: val_e_id_level,
                            id_pic: val_e_id_pic.toString(),
                            escalation_note: val_e_escalation_note,
                            due_date: val_e_due_date,
                            start_timeline: val_e_start_timeline,
                            end_timeline: val_e_end_timeline,
                        },
                        beforeSend: function () {

                        },
                        success: function (response) { },
                        error: function (xhr) { },
                        complete: function () { },
                    }).done(function (response) {
                        if (response.update_eskalasi == true) {
                            jconfirm.instances[0].close();
                            detail_task(val_e_id_task);
                            if (response.status == 4) {
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan eskalasi ke <b>${response.requester_name}</b>`
                                });
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan eskalasi ke <b>${response.pic_name}</b>`
                                });
                            }

                            if (response.status == 5) {
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan reject ke <b>${response.requester_name}</b>`
                                });
                            }
                        } else {
                            jconfirm.instances[0].close();
                            detail_task(val_e_id_task);
                            setTimeout(() => {
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Oops!',
                                    theme: 'material',
                                    type: 'red',
                                    content: 'Server Busy, Try Again Later!',
                                    buttons: {
                                        close: {
                                            actions: function () { }
                                        },
                                    },
                                });
                            }, 250);
                        }
                    }).fail(function (jqXHR, textStatus) {
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
                                        actions: function () { }
                                    },
                                },
                            });
                        }, 250);
                    });
                },
            });
        }

    }


    function update_pengerjaan() {
        let val_e_id_task = $('#e_id_task').val();
        let val_e_id_status = $('#e_id_status').val();
        let val_e_progress = $('#e_progress').val();
        let val_e_pic_note = $('#e_pic_note').val();
        let val_evidence = $('#evidence')[0].files[0];
        let show_evidence = ['4', '6', '8'];

        let formData = new FormData();
        formData.append('id_task', val_e_id_task);
        formData.append('id_status', val_e_id_status); 
        formData.append('progress', val_e_progress);
        formData.append('pic_note', val_e_pic_note);

        if ($('#evidence').val() != "") {
            formData.append('evidence', val_evidence);
        }

        if (parseInt(val_e_id_status) == 8 || parseInt(val_e_id_status) == 9) {
            let val_e_due_date = $('#e_due_date').val();
            let val_e_start_timeline = $('#e_start_timeline').val(); 
            let val_e_end_timeline = $('#e_end_timeline').val();

            formData.append('due_date', val_e_due_date);
            formData.append('start_timeline', val_e_start_timeline);
            formData.append('end_timeline', val_e_end_timeline);
        }

        data_form = formData;

        // if ($('#evidence').val() != "") {
        //     formData.append('evidence', val_evidence);
        // }

        // console.log(val_e_progress);
        if (val_e_id_task == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, id task must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_id_status == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, status must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (val_e_progress == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, progress must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });

        } else if (val_e_pic_note == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, pic note must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else if (show_evidence.includes(val_e_id_status) == true && $('#evidence').val() == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Evidence must be filled',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else {
            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please Wait!',
                theme: 'material',
                type: 'blue',
                content: 'Loading...',
                buttons: {
                    close: {
                        isHidden: true,
                        actions: function () { }
                    },
                },
                onOpen: function () {
                    $.ajax({
                        url: `<?= base_url() ?>complaints/main/update_pengerjaan`,
                        type: 'POST',
                        dataType: 'json',
                        data: data_form,
                         contentType: false,
                        processData: false,
                        beforeSend: function () {

                        },
                        success: function (response) {
                            if (response.status == 'error') {
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Oops!',
                                    theme: 'material',
                                    type: 'red',
                                    content: response.message,
                                    buttons: {
                                        close: {
                                            actions: function () { }
                                        },
                                    },
                                });
                            }
                        },
                        error: function (xhr) {

                        },
                        complete: function () { },
                    }).done(function (response) {
                        if (response.update_eskalasi == true) {
                            jconfirm.instances[0].close();
                            detail_task(val_e_id_task);
                            if (response.status == 6) {
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan done ke <b>${response.requester_name}</b>`
                                });
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan done ke <b>${response.escalation_name}</b>`
                                });
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan done ke <b>${response.head_pic_name}</b>`
                                });
                            }

                            if (response.status == 4) {
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Berhasil Update Complaints`
                                });
                            }

                            if (response.status == 7) {
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan unsolved ke <b>${response.requester_name}</b>`
                                });
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan unsolved ke <b>${response.escalation_name}</b>`
                                });
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan unsolved ke <b>${response.head_pic_name}</b>`
                                });
                            }

                            if (response.status == 8 || response.status == 9) {
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan reschedule ke <b>${response.requester_name}</b>`
                                });
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan reschedule ke <b>${response.escalation_name}</b>`
                                });
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan reschedule ke <b>${response.head_pic_name}</b>`
                                });
                            }
                        } else {
                            jconfirm.instances[0].close();
                            detail_task(val_e_id_task);
                            setTimeout(() => {
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Oops!',
                                    theme: 'material',
                                    type: 'red',
                                    content: 'Server Busy, Try Again Later!',
                                    buttons: {
                                        close: {
                                            actions: function () { }
                                        },
                                    },
                                });
                            }, 250);
                        }
                    }).fail(function (jqXHR, textStatus) {
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
                                        actions: function () { }
                                    },
                                },
                            });
                        }, 250);
                    });
                },
            });
        }
    }



    function save_comment() {
        let val_e_id_task = $('#e_id_task').val();
        let val_e_comment = $('#e_comment').val();
        if (val_e_comment == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, cannot send empty comment',
                buttons: {
                    close: {
                        actions: function () { }
                    },
                },
            });
        } else {
            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please Wait!',
                theme: 'material',
                type: 'blue',
                content: 'Loading...',
                buttons: {
                    close: {
                        isHidden: true,
                        actions: function () { }
                    },
                },
                onOpen: function () {
                    $.ajax({
                        url: `<?= base_url() ?>complaints/main/save_comment`,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id_task: val_e_id_task,
                            comment: val_e_comment
                        },
                        beforeSend: function () {

                        },
                        success: function (response) { },
                        error: function (xhr) { },
                        complete: function () { },
                    }).done(function (response) {
                        if (response == true) {
                            setTimeout(() => {
                                // $('#e_comment').text('');
                                sum_e_comment.summernote('code', '');
                                show_get_comment(val_e_id_task);
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Done!',
                                    theme: 'material',
                                    type: 'blue',
                                    content: 'Success!',
                                    buttons: {
                                        close: {
                                            actions: function () { }
                                        },
                                    },
                                });
                            }, 250);
                        } else {
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                show_get_comment(val_e_id_task);
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Oops!',
                                    theme: 'material',
                                    type: 'red',
                                    content: 'Server Busy, Try Again Later!',
                                    buttons: {
                                        close: {
                                            actions: function () { }
                                        },
                                    },
                                });
                            }, 250);
                        }
                    }).fail(function (jqXHR, textStatus) {
                        setTimeout(() => {
                            show_get_comment(val_e_id_task);
                            jconfirm.instances[0].close();
                            $.confirm({
                                icon: 'fa fa-close',
                                title: 'Oops!',
                                theme: 'material',
                                type: 'red',
                                content: 'Failed!' + textStatus,
                                buttons: {
                                    close: {
                                        actions: function () { }
                                    },
                                },
                            });
                        }, 250);
                    });
                },
            });
        }

    }


    function resend_notif() {
        id_task = $('#e_id_task').val();
        $.confirm({
            title: 'Resend Notif!',
            content: 'Are you sure, you want to resend notification ?',
            theme: 'material',
            type: 'blue',
            buttons: {
                close: function () { },
                yes: {
                    theme: 'material',
                    type: 'blue',
                    btnClass: 'btn-blue',
                    action: function () {
                        $.confirm({
                            icon: 'fa fa-spinner fa-spin',
                            title: 'Please Wait!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Loading...',
                            buttons: {
                                close: {
                                    isHidden: true,
                                    actions: function () { }
                                },
                            },
                            onOpen: function () {
                                $.ajax({
                                    url: `<?= base_url() ?>complaints/main/resend_notif_request`,
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        id_task: id_task,
                                    },
                                    beforeSend: function () {

                                    },
                                    success: function (response) { },
                                    error: function (xhr) { },
                                    complete: function () { },
                                }).done(function (response) {
                                    setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-check',
                                            title: 'Done!',
                                            theme: 'material',
                                            type: 'blue',
                                            content: 'Success!',
                                            buttons: {
                                                close: {
                                                    actions: function () { }
                                                },
                                            },
                                        });
                                    }, 250);
                                }).fail(function (jqXHR, textStatus) {
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
                                                    actions: function () { }
                                                },
                                            },
                                        });
                                    }, 250);
                                });
                            },
                        });
                    }
                },
            }
        });
    }
</script>
<!-- /Detail Task Start -->