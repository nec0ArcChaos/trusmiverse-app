<script>
    $(".tanggal").mask('0000-00-00');

    url_kanban = "<?= $this->uri->segment(1); ?>"

    if (url_kanban != "kanban") {
        $('#sub_indicator').summernote({
            placeholder: 'Indicator',
            tabsize: 2,
            height: 150,
            toolbar: [
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
            ]
        });
    }


    function dt_detail_sub_task(id_task) {
        $('#dt_detail_sub_task').DataTable({
            "searching": false,
            "info": false,
            "paging": false,
            "destroy": true,
            "bSort": false,
            "order": [],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    id_task: id_task
                },
                "url": "<?= base_url(); ?>monday/dt_sub_task",
            },
            "columns": [{
                "data": "sub_task",
                "render": function(data, type, row, meta) {
                    if (row['id_type'] == 1) {
                        type_style = 'bg-light-blue text-dark'
                    } else if (row['id_type'] == 2) {
                        type_style = 'bg-light-yellow text-dark'
                    } else if (row['id_type'] == 2) {
                        type_style = 'bg-light-green text-dark'
                    } else if (row['id_type'] == 3) {
                        type_style = 'bg-light-red text-dark'
                    } else {
                        type_style = 'bg-light-purple text-dark'
                    }
                    if (row['jml_progress'] <= 60) {
                        progress_style = 'bg-red text-white'
                    } else if (row['jml_progress'] <= 85 && row['jml_progress'] > 60) {
                        progress_style = 'bg-yellow text-white'
                    } else if (row['jml_progress'] > 85 && row['jml_progress'] < 100) {
                        progress_style = 'bg-blue text-white'
                    } else {
                        progress_style = 'bg-green text-white'
                    }
                    if (row['consistency'] <= 60) {
                        consistency_style = 'bg-red text-white'
                    } else if (row['consistency'] <= 85 && row['consistency'] > 60) {
                        consistency_style = 'bg-yellow text-white'
                    } else if (row['consistency'] > 85 && row['consistency'] < 100) {
                        consistency_style = 'bg-blue text-white'
                    } else {
                        consistency_style = 'bg-green text-white'
                    }
                    if (row['id_status'] == 1) {
                        button_update_sub = `<a role="button" class="btn btn-sm btn-link bg-secondary text-white" disabled>${row['status']}</a>`
                    } else if (row['id_status'] == 3) {
                        button_update_sub = `<a role="button" class="btn btn-sm btn-link bg-green text-white" onclick="modal_update_sub_task('${row['id_sub_task']}','${row['id_task']}','${row['id_status']}')">${row['status']}</a>`
                    } else {
                        if (parseInt(row['sudah_update']) == 1) {
                            class_btn_update = 'bg-blue'
                        } else {
                            class_btn_update = 'bg-yellow'
                        }
                        button_update_sub = `<a role="button" class="btn btn-sm btn-link ${class_btn_update} text-white" onclick="modal_update_sub_task('${row['id_sub_task']}','${row['id_task']}','${row['id_status']}')">Update</a>`
                    }

                    component_day = ''
                    if (row['id_type'] == 2 || row['id_type'] == 3) {
                        if (row['day_per_week'].indexOf(',') > -1) {
                            array_day = row['day_per_week'].split(',');
                            for (let index = 0; index < array_day.length; index++) {
                                if (array_day[index] == 0) {
                                    component_day += `<span class="badge m-1 ${type_style}">Monday</span>`
                                }
                                if (array_day[index] == 1) {
                                    component_day += `<span class="badge m-1 ${type_style}">Tuesday</span>`
                                }
                                if (array_day[index] == 2) {
                                    component_day += `<span class="badge m-1 ${type_style}">Wednesday</span>`

                                }
                                if (array_day[index] == 3) {
                                    component_day += `<span class="badge m-1 ${type_style}">Thursday</span>`
                                }
                                if (array_day[index] == 4) {
                                    component_day += `<span class="badge m-1 ${type_style}">Friday</span>`
                                }
                                if (array_day[index] == 5) {
                                    component_day += `<span class="badge m-1 ${type_style}">Saturday</span>`
                                }
                                if (array_day[index] == 6) {
                                    component_day += `<span class="badge m-1 ${type_style}">Sunday</span>`
                                }

                            }
                        } else {
                            if (row['day_per_week'] == 0) {
                                component_day += `<span class="badge m-1 ${type_style}">Monday</span>`
                            }
                            if (row['day_per_week'] == 1) {
                                component_day += `<span class="badge m-1 ${type_style}">Tuesday</span>`
                            }
                            if (row['day_per_week'] == 2) {
                                component_day += `<span class="badge m-1 ${type_style}">Wednesday</span>`

                            }
                            if (row['day_per_week'] == 3) {
                                component_day += `<span class="badge m-1 ${type_style}">Thursday</span>`
                            }
                            if (row['day_per_week'] == 4) {
                                component_day += `<span class="badge m-1 ${type_style}">Friday</span>`
                            }
                            if (row['day_per_week'] == 5) {
                                component_day += `<span class="badge m-1 ${type_style}">Saturday</span>`
                            }
                            if (row['day_per_week'] == 6) {
                                component_day += `<span class="badge m-1 ${type_style}">Sunday</span>`
                            }

                        }
                    }

                    return `<div class="align-items-center">
                                <div class="col-auto ps-0">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <p class="mb-1"><b>${row['sub_task']}</b></p>
                                        </div>
                                        <div class="col-12 col-md-6 text-md-end">
                                            ${button_update_sub}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            ${row['indicator']}
                                        </div>
                                    </div>
                                    <hr style="margin-top:3px;margin-bottom:3px;">
                                    <div class="row">
                                        <div class="col-12 col-md-8">
                                            <span class="badge m-1 ${type_style}">${row['sub_type']}</span> <span class="badge ${progress_style}">Progress : ${row['jml_progress']}%</span> <span class="badge ${consistency_style}">Consistency : ${row['consistency']}%</span> <br> ${component_day}
                                        </div>
                                        <div class="col-12 col-md-4 text-md-end">
                                            <span class="badge m-1 ${type_style}">${row['periode']}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-md-end">
                                            <small class="text-muted">Status: <span>${row['status_strategy']}</span></small>
                                        </div>
                                    </div>
                                </div>
                            </div>`
                }
            }, ],
            "initComplete": function(settings, json) {
                console.log(json.data)
                if (json.data.length > 0) {
                    progress_sum = 0;
                    consistency_sum = 0;
                    jml_data = 0;
                    for (let index = 0; index < json.data.length; index++) {
                        progress_sum = progress_sum + parseInt(json.data[index].jml_progress);
                        consistency_sum = consistency_sum + parseInt(json.data[index].consistency);
                        jml_data = jml_data + parseInt(1);
                    }

                    // console.log(progress_sum);
                    // console.log(jml_data);
                    average_progress = (parseFloat(progress_sum) / parseFloat(jml_data));
                    average_consistency = (parseFloat(consistency_sum) / parseFloat(jml_data));
                    // console.log((parseFloat(progres_sum) / parseFloat(jml_data)));
                    // console.log(Math.round(average_progress));
                    percent_progres = Math.round(average_progress * 1) / 100;
                    percent_consistency = Math.round(average_consistency * 1) / 100;
                    // console.log(percent_progres);
                    $('#e_progress').val(Math.round(average_progress * 100) / 100);
                    $('#div_e_progress').empty().append(`
                            <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: ${Math.round(average_progress * 1) / 1}%;" aria-valuenow="${Math.round(average_progress * 1) / 1}" aria-valuemin="0" aria-valuemax="100">${Math.round(average_progress * 1) / 1}%</div>
                            </div>`);
                } else {
                    $('#e_progress').val(0)
                    percent_progres = 0;
                    percent_consistency = 0;
                }
                $('#progress_goals_strategy').empty();
                // console.log(percent_progres)
                setTimeout(() => {
                    intialize_progres_bar_table(`progress_goals_strategy`).animate(percent_consistency.toString());
                }, 250);

                $('#e_id_status').prop('disabled', false);
                // $('#e_id_status').val();
                e_sel_id_status.update();
                $('#text_e_id_status').addClass('d-none');
                $('#text_e_id_status').html('');


                for (let index = 0; index < json.data.length; index++) {
                    if (json.data[index].periode == '' || json.data[index].id_type == '') {
                        $('#e_id_status').prop('disabled', true);
                        e_sel_id_status.update();
                        $('#text_e_id_status').removeClass('d-none');
                        $('#text_e_id_status').html('<i class="small">The status cannot be changed because there are unfilled strategies</i>');
                    }
                }
                if (json.data.length < 1) {
                    $('#e_id_status').prop('disabled', true);
                    e_sel_id_status.update();
                    $('#text_e_id_status').removeClass('d-none');
                    $('#text_e_id_status').html('<i class="small">The status cannot be changed because there are unfilled strategies</i>');
                }
            }
        });
    }

    function intialize_progres_bar_table(id) {
        return new ProgressBar.Circle(`#${id}`, {
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
                    circle.setText('0');
                } else {
                    circle.setText(value + "<small>%<small>");
                }

            }
        });
        // progressCircles2.text.style.fontSize = '20px';

    }

    function modal_update_sub_task(id_sub_task, id_task, id_status) {
        if (id_status == 3) {
            $('#form-update-sub-task').addClass('d-none');
        } else {
            $('#form-update-sub-task').removeClass('d-none');
        }
        $('#modal_detail_task').modal('hide');
        show_log_history_sub_task(id_sub_task);
        $('#u_history_sub_note').val('');
        $('#u_history_link_sub').val('');
        $('#u_history_sub_evaluasi').val('');
        get_status_strategy();
        let u_id_task = "";
        let u_sub_id_task = "";
        $.confirm({
            icon: 'fa fa-spinner fa-spin',
            title: 'Please wait..',
            theme: 'material',
            type: 'blue',
            content: 'Loading...',
            buttons: {
                close: {
                    isHidden: true,
                    actions: function() {}
                },
            },
            onOpen: function() {
                $('#modal_detail_task').modal('hide');

                $.ajax({
                    url: `<?= base_url() ?>monday/get_detail_sub_task`,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id_sub_task: id_sub_task,
                    },
                    beforeSend: function() {},
                    success: function(response) {},
                    error: function(xhr) {},
                    complete: function() {},
                }).done(function(response) {
                    console.log(response.status);
                    console.log(response.detail);
                    if (response.status == true) {
                        setTimeout(() => {
                            jconfirm.instances[0].close();
                            $('#title_sub_task').text(response.detail.sub_task);
                            $('#u_id_sub_task').val(response.detail.id_sub_task);
                            $('#u_id_task').val(response.detail.id_task);
                            $('#u_history_progress').val(response.detail.progress);
                            $('#u_week_number').val(response.detail.week_number);
                            $('#u_week_start_date').val(response.detail.week_start_date);
                            $('#u_week_end_date').val(response.detail.week_end_date);
                            $('#u_jam_notif').val(response.detail.jam_notif);
                            sel_u_jam_notif.update()
                            $('#modal_update_sub_task').modal('show');

                            $('#id_type_goals').val(response.detail.id_type_goals);
                            if (response.detail.id_type_goals == 2) {
                                $('#div_u_history_sub_note').addClass('d-none')
                            } else {
                                $('#div_u_history_sub_note').removeClass('d-none')
                            }
                        }, 250);
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

    function get_status_strategy() {
        var option = `<option value="" selected disabled>-- Pilih Status --</option>`;
        $.ajax({
            url: '<?= base_url('ibr_update/get_status_strategy') ?>',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                response.forEach((value, index) => {
                    option += `<option value="${value.id}">${value.status}</option>`
                });
            },
            complete: function(setting, response) {
                $(".status_strategy").html(option);
            }
        })
    }

    function close_update_sub_task() {
        u_close_id_task = $('#u_id_task').val();
        $('#modal_update_sub_task').modal('hide');
        setTimeout(() => {
            detail_task(u_close_id_task);
        }, 250);
    }

    function save_update_sub_task() {
        let val_u_id_task = $('#u_id_task').val();
        let val_u_id_sub_task = $('#u_id_sub_task').val();
        let val_u_history_sub_note = $('#u_history_sub_note').val();
        let val_u_history_sub_evaluasi = $('#u_history_sub_evaluasi').val();
        let val_u_history_progress = $('#u_history_progress').val();
        let val_u_history_link_sub = $('#u_history_link_sub').val();
        let val_u_week_number = $('#u_week_number').val();
        let val_u_week_start_date = $('#u_week_start_date').val();
        let val_u_week_end_date = $('#u_week_end_date').val();
        let val_u_jam_notif = $('#u_jam_notif').val();

        let val_u_status = $('#status :selected').val();

        console.log(val_u_jam_notif);

        let val_id_type_goals = $('#id_type_goals').val();

        if (val_u_id_task == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, id task is not found',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_u_id_sub_task == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, id sub task must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_u_history_sub_note == "" && val_id_type_goals == 1) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, note must be choosed',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_u_history_sub_evaluasi == "" && val_id_type_goals == 2) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, evaluasi must be choosed',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });

        } else if (val_u_status == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Status must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });


        } else {

            let file_data = $("#u_history_file_sub").prop("files")[0];
            let form_data_sub = new FormData();
            form_data_sub.append("id_task", val_u_id_task);
            form_data_sub.append("id_sub_task", val_u_id_sub_task);
            form_data_sub.append("history_sub_note", val_u_history_sub_note);
            form_data_sub.append("history_sub_evaluasi", val_u_history_sub_evaluasi);
            form_data_sub.append("history_progress", val_u_history_progress);
            form_data_sub.append("week_number", val_u_week_number);
            form_data_sub.append("history_file_sub", file_data);
            form_data_sub.append("history_link_sub", val_u_history_link_sub);
            form_data_sub.append("week_start_date", val_u_week_start_date);
            form_data_sub.append("week_end_date", val_u_week_end_date);
            form_data_sub.append("jam_notif", val_u_jam_notif);
            form_data_sub.append("status", val_u_status);

            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please Wait!',
                theme: 'material',
                type: 'blue',
                content: 'Loading...',
                buttons: {
                    close: {
                        isHidden: true,
                        actions: function() {}
                    },
                },
                onOpen: function() {

                    $.ajax({
                        url: `<?= base_url() ?>monday/update_sub_task`,
                        type: 'POST',
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data_sub, // Setting the data attribute of ajax with file_data
                        type: 'post',
                        beforeSend: function() {

                        },
                        success: function(response) {},
                        error: function(xhr) {},
                        complete: function() {},
                    }).done(function(response) {
                        if (response.save_sub_task == true) {
                            jconfirm.instances[0].close();
                            $('#modal_update_sub_task').modal('hide');
                            setTimeout(() => {
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Success!',
                                    theme: 'material',
                                    type: 'blue',
                                    content: 'Strategy updated!',
                                    buttons: {
                                        close: {
                                            actions: function() {}
                                        },
                                    },
                                });
                                setTimeout(() => {
                                    jconfirm.instances[0].close();
                                    detail_task(response.id_task);
                                }, 250);
                            }, 250);
                        } else {
                            // modal_sub_task(id_task)
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-close',
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

    }

    function show_log_history_sub_task(id_sub_task) {
        body_log_hitory = '';
        base_url = "http://trusmiverse.com/hr/uploads/profile";
        $.ajax({
            url: "<?= base_url('monday/log_history_sub_task') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                id_sub_task: id_sub_task,
            },
            beforeSend: function() {
                $('#spinner_loading_sub_task').show();
            },
            success: function(response) {
                // console.info(response)
                if (response.log.length > 0) {
                    response.log.forEach((value, index) => {
                        if (value.type_history == 'file') {
                            ket_his = `<a href="<?= base_url() ?>/uploads/monday/history_sub_task/${value.keterangan}" target="_blank">${value.keterangan}</a>`
                        } else if (value.type_history == 'link') {
                            ket_his = `<a href="${value.keterangan}" target="_blank">Go To Link..</a>`
                        } else {
                            ket_his = value.keterangan;
                        }
                        body_log_hitory +=
                            `<tr>
                            <td><small>${calculate_time_history_log_sub_task(value.created_at)}</small></td>
                            <td>
                                <div class="avatar avatar-30 coverimg rounded-circle me-1"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="${value.pic}">
                                    <img src="${base_url}/${value.photo}" alt="">
                                </div>
                            </td>
                            <td><small>${get_jenis_log_sub_task(value.type_history)}</small></td>
                            <td><small>${ket_his}<small></td>
                        </tr>`
                    });
                } else {
                    body_log_hitory += `<tr>
                                         <td colspan="3" class="text-center">No Activity Log</td>
                                    </tr>`
                }
                $('#body_log_hitory_sub_task').html(body_log_hitory)
            },
            complete: function() {
                setTimeout(() => {
                    $('#spinner_loading_sub_task').hide();
                }, 500);
            }
        })
    }

    function calculate_time_history_log_sub_task(time_string) {
        var targetDate = new Date(time_string);
        var currentDate = new Date();
        var timeDifference = currentDate - targetDate;
        var daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
        var hoursDifference = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var monthDifference = (currentDate.getMonth() + 1) - (targetDate.getMonth() + 1);
        var yearDifference = currentDate.getFullYear() - targetDate.getFullYear();

        if (yearDifference > 0) {
            // return `<i class="bi bi-clock"></i> ${yearDifference}y`
            return `<small>${convert_duedate(time_string)}</small>`
        } else if (monthDifference > 0) {
            // return `<i class="bi bi-clock"></i> ${monthDifference}m`
            return `<small>${convert_duedate(time_string)}</small>`
        } else if (daysDifference > 0) {
            // return `<i class="bi bi-clock"></i> ${daysDifference}d`
            return `<small>${convert_duedate(time_string)}</small>`
        } else if (hoursDifference > 0) {
            return `<i class="bi bi-clock"></i> ${hoursDifference}h`
            // return `<small>${convert_duedate(time_string)}</small>`
        } else {
            timeOnly = time_string.split(' ')[1].substring(0, 5);
            // const hours = parseInt(timeOnly.split(':')[0]);
            // let meridiem = 'am';
            // if (hours >= 12) {
            //     meridiem = 'pm';
            // }
            // return `${timeOnly} ${meridiem}`
            return convertTo12HourFormat(timeOnly);
        }
    }

    function get_jenis_log_sub_task(jenis) {
        if (jenis == 'created') {
            jenis_log = `<i class="bi bi-pen"></i> Created`
        } else if (jenis == 'progress') {
            jenis_log = `<i class="bi bi-percent text-success"></i> Progress`
        } else if (jenis == 'status') {
            jenis_log = `<img class="status_img" src="<?= base_url() ?>/assets/img/color_status.png" style="max-width:8%; height:auto"> Status`
        } else if (jenis == 'evaluasi') {
            jenis_log = `<i class="bi bi-clipboard-data"></i> Evaluasi`
        } else if (jenis == 'note') {
            jenis_log = `<i class="bi bi-chat-right-text"></i> Note`
        } else if (jenis == 'file') {
            jenis_log = `<i class="bi bi-image"></i> File`
        } else if (jenis == 'link') {
            jenis_log = `<i class="bi bi-link-45deg"></i> Link`
        } else {
            jenis_log = ``
        }
        return jenis_log;
    }
</script>