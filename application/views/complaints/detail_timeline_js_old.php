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
    });
</script>
<!-- /script state awal -->

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
                            $('#e_tgl_aftersales').html(`${response.detail.tgl_aftersales} (${response.detail.id_after_sales})`).removeClass().addClass('badge bg-light-yellow text-dark');
                        } else {
                            $('#e_tgl_aftersales').html(`${response.detail.tgl_aftersales}`).removeClass().addClass('badge bg-light-yellow text-dark');
                        }
                        $('#e_priority_text').html(response.detail.priority).removeClass().addClass('badge ' + response.detail.priority_color);
                        $('#e_level_text').html(response.detail.level).removeClass().addClass('badge ' + response.detail.level_color);
                        $('#e_status_text').html(response.detail.status).removeClass().addClass('badge ' + response.detail.status_color);
                        $('#e_requested_by_text').html(`<span class="badge bg-light-purple text-dark" style="margin-bottom: 3px;">${response.detail.requested_by}</span>`);
                        $('#e_requested_at_text').html(`<span class="badge bg-light-red text-dark">${response.detail.tgl_dibuat} | ${response.detail.jam_dibuat} WIB</span>`);

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

    function activateTab(id) {
        id_task = $('#detail_id_task').val();
        $('.detail_pages').hide();
        var tabs = document.querySelectorAll('.nav-link');
        tabs.forEach(function(tab) {
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
        }
    }


    function show_log_history(id_task) {
        base_url = "http://trusmiverse.com/hr/uploads/profile";
        body_log_history = '';
        $('#body_log_history').html('');
        // $('#dt_log_history').paging('destroy');


        $.ajax({
            url: "<?= base_url('complaints/main/get_log_history_for_konsumen') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                id_task: id_task,
            },
            beforeSend: function() {
                $('#spinner_loading').show();
                // $('#activity_page').hide();
                // $('#files_page').hide();
                $('#activity_page').fadeOut();

            },
            success: function(response) {
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
            complete: function() {
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
        }, function(ft) {
            $('.footablestot').html($('.footable-pagination-wrapper .label').html())

            $('.footable-pagination-wrapper ul.pagination li').on('click', function() {
                setTimeout(function() {
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
        reader.onloadend = function() {
            preview.src = reader.result;
        }
        $('#uploaded_preview').attr('src', )
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
            beforeSend: function() {
                $('#spinner_loading').show();
                $('#body_get_comment').fadeOut();
            },
            success: function(response) {
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
            complete: function() {
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
                        actions: function() {}
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
                beforeSend: function() {

                },
                success: function(response) {},
                error: function(xhr) {},
                complete: function() {},
            }).done(function(response) {
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
                                    actions: function() {}
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
                                    actions: function() {}
                                },
                            },
                        });
                    }, 250);
                }
            }).fail(function(jqXHR, textStatus) {
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
                                actions: function() {}
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
</script>
<!-- /Detail Task Start -->