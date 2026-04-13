<!-- <script src="<?= base_url(); ?>assets/js/dashboard.js"></script> -->

<!-- fancybox JS -->
<script src="<?php echo base_url() ?>assets/fancybox/jquery.fancybox.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/selectize/selectize.min.js"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/font_awesome/js/all.min.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>

<!-- progress bar  -->
<script src="<?= base_url(); ?>assets/vendor/progressbar-js/progressbar.min.js" type="text/javascript"></script>
<!-- full calender  -->
<script src="<?= base_url(); ?>assets/vendor/fullCalendar/lib/main.min.js"></script>
<!-- full calendar css -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/fullCalendar/lib/main.min.css">


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // var calendarEl = document.getElementById('calendarNew');
        // var calendar = new FullCalendar.Calendar(calendarEl, {
        //   initialView: 'dayGridMonth'
        // });
        // calendar.render();
        var currentday = new Date();
        var thismonth = ("0" + (currentday.getMonth() + 1)).slice(-2);
        var thisyear = currentday.getFullYear();

        // console.log(currentday)
        // console.log(thismonth)
        // console.log(thisyear)
        user_id = "<?= $this->uri->segment(3); ?>";

        if (user_id == "") {
            user_id = "<?= $this->session->userdata('user_id'); ?>";
            console.log(user_id)
        }

        function generete_pic(profile_picture_pic, team_name) {
            avatar_pic = ``;
            avatar_pic_plus = ``;
            if (profile_picture_pic.indexOf(',') > -1) {
                array_pic = profile_picture_pic.split(',');
                for (let index = 0; index < array_pic.length; index++) {
                    if (index < 2) {
                        avatar_pic += `<div class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${array_pic[index]}&quot;);">
                                    <img src="http://trusmiverse.com/hr/uploads/profile/${array_pic[index]}" alt="" style="display: none;">
                                    </div>`;
                    }
                }
                if (array_pic.length > 2) {
                    avatar_pic_plus = `<div class="avatar avatar-30 bg-light-theme rounded-circle me-1">
                                        <p class="small">${parseInt(array_pic.length)-2}+</p>
                                    </div>`;
                } else {
                    avatar_pic_plus = '';
                }
            } else {
                avatar_pic += `<div class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${profile_picture_pic}&quot;);">
                                        <img src="http://trusmiverse.com/hr/uploads/profile/${profile_picture_pic}" alt="" style="display: none;">
                                    </div>`;
                avatar_pic_plus = '';
            }
            return `
                                <div class="d-flex justify-content-start" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${team_name}">
                                    ${avatar_pic}${avatar_pic_plus}  
                                </div>
                            `
        }

        $.ajax({
            url: '<?= base_url() ?>dashboard/ibr_pro_calendar',
            type: 'POST',
            dataType: 'json',
            data: {
                user_id: user_id
            },
            beforeSend: function() {

            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            // console.log(response)
            var calendarEl = document.getElementById('calendarNew');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                // customButtons: {
                //     myCustomButton: {
                //         text: 'Create Appointment',
                //         click: function () {
                //             alert('clicked the custom button!');
                //         }
                //     }
                // },
                displayEventTime: false,
                headerToolbar: {
                    // left: 'prev,next myCustomButton',
                    left: 'prev,next',
                    center: 'title',
                    right: 'today dayGridMonth,timeGridWeek,timeGridDay'
                },
                // resources: [{
                //         id: '1',
                //         title: 'Daily'
                //     },
                //     {
                //         id: '2',
                //         title: 'Weekly'
                //     },
                //     {
                //         id: '3',
                //         title: 'Monthly'
                //     },
                //     {
                //         id: '4',
                //         title: 'Twice'
                //     }
                // ],
                events: response,
                eventClick: function(info, response) {
                    // console.log(info.event.extendedProps.id_sub_task)
                    id_sub_task = info.event.extendedProps.id_sub_task;
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
                            show_log_history_sub_task(id_sub_task);
                            $.ajax({
                                url: `<?= base_url() ?>dashboard/ibr_pro_calendar_detail`,
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
                                // console.log(response.status)
                                // console.log(response.detail)

                                list_todo = '';
                                for (let index = 0; index < response.detail.length; index++) {
                                    if (response.detail[index].id_type == 1) {
                                        class_type = 'bg-light-green text-dark';
                                    } else {
                                        class_type = 'bg-light-yellow text-dark';
                                    }
                                    list_todo += `
                                    <div class="card border-0 mb-4">
                                        <div class="card-body">
                                            <div class="row align-items-center gx-2">
                                                <div class="col">
                                                    <h6 class="m-0">${response.detail[index].strategy}</h6>
                                                    <p class="text-secondary small mb-3">${response.detail[index].task}</p>
                                                    <span class="btn btn-sm btn-link ${class_type}">${response.detail[index].type}</span>
                                                    <span class="btn btn-sm btn-link bg-light-red text-dark">${response.detail[index].sub_type}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row align-items-center gx-2">
                                                <div class="col">
                                                    <div class="col-auto">
                                                        ${generete_pic(response.detail[index].profile_picture_pic,response.detail[index].team_name)}
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a target="_blank" href="<?= base_url() ?>ibr_update?id=${response.detail[index].id_sub_task}&u=<?= $this->session->userdata('user_id'); ?>" class="btn btn-link btn-sm bg-light-yellow text-yellow"><i class="bi bi-pencil-square"></i> Update</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                                }
                                $('#todo-list').empty().append(list_todo).hide().fadeIn()
                                if (response.status == true) {
                                    setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        // $('#detail_title_sub_task').text(response.detail.sub_task);
                                        $('#modal_detail_sub_task').modal('show');
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
                },
                // eventContent: function(info) {
                //     // console.log(info);
                //     // console.log(info.event);
                //     // console.log(info.event.title);
                //     // console.log(info.event.extendedProps.progress);
                //     if (info.event.title == 'yes') {
                //         return {
                //             html: `<i class="bi bi-check2-square text-white"></i>`
                //         };
                //     } else if (info.event.title == 'no') {
                //         return {
                //             html: `<i class="bi bi-x-square text-white"></i>`
                //         };
                //     } else {
                //         if (info.event.extendedProps.consistency <= 60) {
                //             consistency_style = 'bg-light-red text-dark'
                //         } else if (info.event.extendedProps.consistency <= 85 && info.event.extendedProps.consistency > 60) {
                //             consistency_style = 'bg-light-yellow text-dark'
                //         } else if (info.event.extendedProps.consistency > 85 && info.event.extendedProps.consistency < 100) {
                //             consistency_style = 'bg-light-blue text-dark'
                //         } else {
                //             consistency_style = 'bg-light-green text-dark'
                //         }

                //         if (info.event.extendedProps.progress <= 60) {
                //             progress_style = 'bg-light-red text-dark'
                //         } else if (info.event.extendedProps.progress <= 85 && info.event.extendedProps.progress > 60) {
                //             progress_style = 'bg-light-yellow text-dark'
                //         } else if (info.event.extendedProps.progress > 85 && info.event.extendedProps.progress < 100) {
                //             progress_style = 'bg-light-blue text-dark'
                //         } else {
                //             progress_style = 'bg-light-green text-dark'
                //         }

                //         if (info.event.extendedProps.type == 1) {
                //             t_style = `bg-light-cyan text-cyan`;
                //             title = `<p class="small"><span class="btn btn-sm btn-link ${t_style}"><small>D</small></span> <strong>${info.event.title}</strong></p>`
                //         } else if (info.event.extendedProps.type == 2) {
                //             t_style = `bg-light-yellow text-yellow`;
                //             title = `<p class="small"><span class="btn btn-sm btn-link ${t_style}"><small>W</small></span> <strong>${info.event.title}</strong></p>`
                //         } else if (info.event.extendedProps.type == 3) {
                //             t_style = `bg-light-red text-red`;
                //             title = `<p class="small"><span class="btn btn-sm btn-link ${t_style}"><small>M</small></span> <strong>${info.event.title}</strong></p>`
                //         } else if (info.event.extendedProps.type == 4) {
                //             t_style = `bg-light-purple text-purple`;
                //             title = `<p class="small"><span class="btn btn-sm btn-link ${t_style}"><small>M</small></span> <strong>${info.event.title}</strong></p>`
                //         } else {
                //             t_style = `bg-secondary text-white`;
                //             title = `<p class="small"><span class="btn btn-sm btn-link ${t_style}"><small>M</small></span> <strong>${info.event.title}</strong></p>`
                //         }


                //         if (info.event.extendedProps.type == 1) {
                //             t_sty = `bg-light-cyan text-dark`;
                //         } else if (info.event.extendedProps.type == 2) {
                //             t_sty = `bg-light-yellow text-dark`;
                //         } else if (info.event.extendedProps.type == 3) {
                //             t_sty = `bg-light-red text-dark`;
                //         } else if (info.event.extendedProps.type == 4) {
                //             t_sty = `bg-light-purple text-dark`;
                //         } else {
                //             t_sty = `bg-secondary text-dark`;
                //         }
                //         return {
                //             html: `<div class="row">
                //                         <div class="mb-1 col-12">
                //                             ${title}
                //                         </div>
                //                         <div class="mb-1 col-12 col-md-6">
                //                             <span class="badge ${t_sty}">Target : ${info.event.extendedProps.target}</span>
                //                         </div>
                //                         <div class="mb-1 col-12 col-md-6">
                //                             <span class="badge ${t_sty}">Actual : ${info.event.extendedProps.actual}</span>
                //                         </div>
                //                         <div class="mb-1 col-12 col-md-6">
                //                             <span class="badge ${progress_style}">Progress : ${info.event.extendedProps.progress}%</span>
                //                         </div>
                //                         <div class="mb-1 col-12 col-md-6">
                //                             <span class="badge ${consistency_style}">Consistency : ${info.event.extendedProps.consistency}%</span>
                //                         </div>
                //                     </div>
                //                     `
                //         };
                //     }
                // },
                eventDidMount: function(info) {
                    // console.log(info)
                    // element.find(".fc-title").prepend("<i class='bi bi-house'></i>");
                }
            });
            calendar.render();
            calendar.setOption('contentHeight', 650);

        }).fail(function(jqXhr, textStatus) {

        });

    });


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


    function convert_duedate(dateString) {
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

    // $(window).on('load', function () {
    //     $('taginput').tagsinput();

    //     /* calendar view */

    //     var currentday = new Date();
    //     var thismonth = ("0" + (currentday.getMonth() + 1)).slice(-2);
    //     var thisyear = currentday.getFullYear();


    //     var calendarEl = document.getElementById('calendarNew');
    //     var calendar = new FullCalendar.Calendar(calendarEl, {
    //         initialView: 'dayGridMonth',
    //         // customButtons: {
    //         //     myCustomButton: {
    //         //         text: 'Create Appointment',
    //         //         click: function () {
    //         //             alert('clicked the custom button!');
    //         //         }
    //         //     }
    //         // },
    //         headerToolbar: {
    //             // left: 'prev,next myCustomButton',
    //             left: 'prev,next',
    //             center: 'title',
    //             right: 'today dayGridMonth,timeGridWeek,timeGridDay'
    //         },
    //         events: [
    //             {
    //                 title: 'All Day Event',
    //                 className: 'regular-event',
    //                 start: thisyear + '-' + thismonth + '-01',
    //             },
    //             {
    //                 title: 'Long Event',
    //                 className: 'task-event',
    //                 start: thisyear + '-' + thismonth + '-07',
    //                 end: thisyear + '-' + thismonth + '-10'
    //             },
    //             {
    //                 groupId: 999,
    //                 className: 'reminder-event',
    //                 title: 'Repeating Event',
    //                 start: thisyear + '-' + thismonth + '-09T16:00:00'
    //             },
    //             {
    //                 groupId: 999,
    //                 title: 'Repeating Event',
    //                 className: 'reminder-event',
    //                 start: thisyear + '-' + thismonth + '-16T16:00:00'
    //             },
    //             {
    //                 title: 'Conference',
    //                 className: 'task-event',
    //                 start: thisyear + '-' + thismonth + '-11',
    //                 end: thisyear + '-' + thismonth + '-13'
    //             },
    //             {
    //                 title: 'Meeting',
    //                 className: 'meeting-event',
    //                 start: thisyear + '-' + thismonth + '-12T10:30:00',
    //                 end: thisyear + '-' + thismonth + '-10T12:30:00'
    //             },
    //             {
    //                 title: 'Lunch',
    //                 className: 'regular-event',
    //                 start: thisyear + '-' + thismonth + '-10T12:00:00'
    //             },
    //             {
    //                 title: 'Meeting',
    //                 className: 'meeting-event',
    //                 start: thisyear + '-' + thismonth + '-10T14:30:00'
    //             },
    //             {
    //                 title: 'Happy Hour',
    //                 className: 'freetime-event',
    //                 start: thisyear + '-' + thismonth + '-10T17:30:00'
    //             },
    //             {
    //                 title: 'Dinner',
    //                 className: 'regular-event',
    //                 start: thisyear + '-' + thismonth + '-10T20:00:00'
    //             },
    //             {
    //                 title: "John's Birthday",
    //                 className: 'birthday-event',
    //                 start: thisyear + '-' + thismonth + '-13T07:00:00'
    //             },
    //             {
    //                 title: 'Click for Google',
    //                 className: 'external-event',
    //                 url: 'http://google.com/',
    //                 start: thisyear + '-' + thismonth + '-28'
    //             }
    //         ]
    //     });
    //     calendar.render();

    //     $('.innersidebar-btn').on('click', function () {
    //         setTimeout(function () { calendar.render(); }, 500);
    //     })
    // });
</script>


<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     // var calendarEl = document.getElementById('calendarNew');
    //     // var calendar = new FullCalendar.Calendar(calendarEl, {
    //     //   initialView: 'dayGridMonth'
    //     // });
    //     // calendar.render();
    //     var currentday = new Date();
    //     var thismonth = ("0" + (currentday.getMonth() + 1)).slice(-2);
    //     var thisyear = currentday.getFullYear();


    //     var calendarEl = document.getElementById('calendarNew');
    //     var calendar = new FullCalendar.Calendar(calendarEl, {
    //         initialView: 'dayGridMonth',
    //         // customButtons: {
    //         //     myCustomButton: {
    //         //         text: 'Create Appointment',
    //         //         click: function () {
    //         //             alert('clicked the custom button!');
    //         //         }
    //         //     }
    //         // },
    //         headerToolbar: {
    //             // left: 'prev,next myCustomButton',
    //             left: 'prev,next',
    //             center: 'title',
    //             right: 'today dayGridMonth,timeGridWeek,timeGridDay'
    //         },
    //         events: [
    //             {
    //                 title: 'Lari 2 Km dari Plered',
    //                 className: 'regular-event',
    //                 start: thisyear + '-' + thismonth + '-01',
    //             },
    //             {
    //                 title: 'Baca Buku Investasi',
    //                 className: 'task-event',
    //                 start: thisyear + '-' + thismonth + '-07',
    //                 end: thisyear + '-' + thismonth + '-10'
    //             },
    //             {
    //                 groupId: 999,
    //                 className: 'reminder-event',
    //                 title: 'Baca Buku Strategi CEO',
    //                 start: thisyear + '-' + thismonth + '-09T16:00:00'
    //             },
    //             {
    //                 groupId: 999,
    //                 title: 'Baca Buku Strategi CEO',
    //                 className: 'reminder-event',
    //                 start: thisyear + '-' + thismonth + '-16T16:00:00'
    //             },
    //             {
    //                 title: 'Dengar Video Mario Teguh',
    //                 className: 'task-event',
    //                 start: thisyear + '-' + thismonth + '-11',
    //                 end: thisyear + '-' + thismonth + '-13'
    //             },
    //             {
    //                 title: 'Lari di kampung Arab',
    //                 className: 'meeting-event',
    //                 start: thisyear + '-' + thismonth + '-12T10:30:00',
    //                 end: thisyear + '-' + thismonth + '-10T12:30:00'
    //             },
    //             {
    //                 title: 'Dengar Video Mario Teguh',
    //                 className: 'regular-event',
    //                 start: thisyear + '-' + thismonth + '-10T12:00:00'
    //             },
    //             {
    //                 title: 'Lari di kampung Inggris',
    //                 className: 'meeting-event',
    //                 start: thisyear + '-' + thismonth + '-10T14:30:00'
    //             },
    //             {
    //                 title: 'Ketemu Mentor Investasi',
    //                 className: 'freetime-event',
    //                 start: thisyear + '-' + thismonth + '-10T17:30:00'
    //             },
    //             {
    //                 title: 'Lari 2 Km dari Alun2 Bandung',
    //                 className: 'regular-event',
    //                 start: thisyear + '-' + thismonth + '-10T20:00:00'
    //             },
    //             {
    //                 title: "Video Motivasi Tentang Usaha FBT",
    //                 className: 'birthday-event',
    //                 start: thisyear + '-' + thismonth + '-13T07:00:00'
    //             },
    //             {
    //                 title: 'Click for Google',
    //                 className: 'external-event',
    //                 url: 'http://google.com/',
    //                 start: thisyear + '-' + thismonth + '-28'
    //             }
    //         ]
    //     });
    //     calendar.render();
    // });
</script>

<script>
    $(document).ready(function() {
        user_id = "<?= $this->uri->segment(3); ?>";
        // console.log(user_id)
        // if (user_id == "") {
        //     user_id = "<?= $_SESSION['user_id'] ?>";
        // }
        // console.log(user_id)
        ibr_pro_profile(user_id);
    });

    function ibr_pro_profile(user_id = null) {

        if (user_id == null || user_id == "") {
            src = "https://trusmiverse.com/hr/uploads/profile/<?= $_SESSION['profile_picture']; ?>";
            $('#figure_photo_profile').css('background-image', src);
            $('#photo_profile').attr('src', src);
        }

        console.log(user_id);

        // console.info(`user_id ${user_id}`)
        $.ajax({
            url: '<?= base_url('dashboard/ibr_pro_profile') ?>',
            type: "POST",
            data: {
                user_id: user_id
            },
            dataType: "json",
            success: function(response) {
                // console.info(response)
                if (response.profile.user_id == '801' || response.profile.user_id == '803') {
                    $('#quotes').show();
                } else {
                    $('#quotes').hide();
                }
                $('#employee_name').html(response.profile.employee_name)
                $('#jabatan').html(response.profile.jabatan)
                $('#goal').html(response.profile.goal)
                $('#strategy').html(response.profile.strategy)

                src = "https://trusmiverse.com/hr/uploads/profile/" + response.profile.photo_profile;
                $('#figure_photo_profile').css('background-image', src);
                $('#photo_profile').attr('src', src);
                $('#task').html(response.profile.task);

                // console.log(response.goals);
                generate_strategy_card(response.goals);


                if (response.profile.goal == "0") {
                    $('#row_goals').hide();
                    $('#row_no_goals').show();
                } else {
                    $('#row_goals').show();
                    $('#row_no_goals').hide();
                }

            },
            complete: function() {
                total_consistency = $('.total_consistency');

                var sum = 0;
                $('.total_consistency').each(function() {
                    sum += parseFloat($(this).text().replace('%', ''));
                });

                consistency = (sum / total_consistency.length);

                intialize_progres_bar('consistency').animate(consistency / 100)
                $('#consistency_percent').html(`${consistency.toFixed()}%`)

                if (consistency < 1) {
                    $('#consistency_status').hide();
                    $('#row_consistency').hide();
                } else {
                    $('#consistency_status').show();
                    $('#row_consistency').show();
                }

                if (consistency > 84) {
                    src = `https://trusmiverse.com/apps/assets/img/consistent_green.png`;
                } else {
                    src = `https://trusmiverse.com/apps/assets/img/inconsistent_red.png`;
                }
                $('#consistency_status').attr('src', src)
            }
        })
    }

    function generate_strategy_card(goals) {
        goals_card = ``;
        goals.forEach((value, index) => {
            if (value.goal != null) {

                goal_consistency = 0;

                value.strategy.forEach((val, i) => {
                    goal_consistency += parseInt(val.consistency)
                });
                // console.info(value.strategy)

                goal_consistency = goal_consistency / value.strategy.length;
                if (goal_consistency.toString() == "NaN") {
                    goal_consistency = 0;
                }

                goals_card +=
                    `<div class="card mb-3">
                        <div class="card-body">
                            <div class="task-primary mb-3">
                                <div class="row mt-0">
                                    <div class="col mb-1">
                                        <h6>${value.goal}</h6>
                                    </div>
                                    <div class="col-auto mb-0">
                                        <p class="float-end badge badge-sm bg-green small total_consistency" id="concistency_${index}">${goal_consistency.toFixed()}%</p>
                                    </div>
                                </div>
                            </div>
                            
                            ${generate_list_strategy(value.strategy, index)}

                            <div class="task-evaluasi mb-2">
                                <div class="row mt-0">
                                    <div class="col mb-1">
                                        <p class="small">Evaluasi </p>
                                    </div>
                                </div>
                                <blockquote><q>${value.evaluasi}</q></blockquote>
                            </div>

                        </div>
                    </div>`;

            }

        });

        $('#goals_card').html(goals_card)

    }

    function generate_list_strategy(strategy, index) {

        consistency = 0;
        lists = ``;
        strategy.forEach((value, index) => {

            if (value.consistency > 80) {
                bg_color = 'bg-green';
            } else if (value.consistency > 45) {
                bg_color = 'bg-yellow';
            } else {
                bg_color = 'bg-red';
            }

            if (value.jml_progress > 80) {
                theme_color = 'theme-green';
            } else if (value.jml_progress > 45) {
                theme_color = 'theme-yellow';
            } else {
                theme_color = 'theme-red';
            }

            if(value.id_status_strategy == '1'){
                strategy_color = 'text-success';
            }else if(value.id_status_strategy == '2'){
                strategy_color = 'text-warning';
            }else if(value.id_status_strategy == '3'){
                strategy_color = 'text-danger';
            }else{
                strategy_color = 'text-muted';
            }

            lists += `<div class="card mb-3">
                        <div class="card-body">
                            <div class="task-daily">
                                <div class="row mt-0">
                                    <div class="col mb-1">
                                        <p class="small">${generate_type_badge(value.sub_type)} ${value.sub_task} </p>
                                    </div>
                                    <div class="col-auto mb-0">
                                        <p class="float-end badge badge-sm ${bg_color} small">${value.consistency}%</p>
                                    </div>
                                </div>
                                <div class="progress h-5 mb-1 bg-light-theme">
                                    <div class="progress-bar bg-theme ${theme_color}" role="progressbar" style="width: ${value.jml_progress}%" aria-valuenow="${value.jml_progress}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span>
                                    <span class="small text-secondary"><strong>Progress</strong>: <span>${value.jml_progress}%</span></span>
                                    <span>&nbsp;&nbsp;</span>
                                    <span>
                                        <p class="small text-secondary float-end"> ${calculate_time_history_log(value.max_date)}</p>
                                    </span>
                                </span>
                                <br>
                                <span>
                                    <span class="small text-secondary"><strong>Target</strong>: <span>${value.targetx}</span></span>
                                    <span>&nbsp;&nbsp;</span>
                                    <span class="small text-secondary"><strong>Actual</strong>: <span>${value.jml_input}</span></span>
                                    <span>&nbsp;&nbsp;</span>
                                    <span class="small text-secondary float-end"><strong>Deadline</strong>: <span>${value.end}</span></span>
                                </span>
                                <br>
                                <span class="small text-secondary float-end">
                                    <strong>Status</strong>: <span class="${strategy_color}">${value.status_strategy}</span>
                                </span>
                            </div>
                        </div>
                    </div>`;

            consistency += parseInt(value.consistency)
        });

        percent_consistency = consistency / strategy.length;

        // setTimeout(() => {
        //     $(`#concistency_${index}`).html(`${(consistency / strategy.length).toFixed()}%`)
        // }, 500);

        return lists;

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

    function calculate_time_history_log(time_string) {

        if (time_string != null || time_string != 'null' || time_string != '') {

            var targetDate = new Date(time_string);
            var currentDate = new Date();
            var timeDifference = currentDate - targetDate;
            var daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
            var hoursDifference = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var monthDifference = (currentDate.getMonth() + 1) - (targetDate.getMonth() + 1);
            var yearDifference = currentDate.getFullYear() - targetDate.getFullYear();

            if (yearDifference > 0) {
                // return `<i class="bi bi-clock"></i> ${yearDifference}y`
                return `<small><i class="bi bi-calendar"></i> ${convert_duedate(time_string)}</small>`
            } else if (monthDifference > 0) {
                // return `<i class="bi bi-clock"></i> ${monthDifference}m`
                return `<small><i class="bi bi-calendar"></i> ${convert_duedate(time_string)}</small>`
            } else if (daysDifference > 0) {
                // return `<i class="bi bi-clock"></i> ${daysDifference}d`
                return `<small><i class="bi bi-calendar"></i> ${convert_duedate(time_string)}</small>`
            } else if (hoursDifference > 0) {
                return `<i class="bi bi-clock"></i> ${hoursDifference}h`
                // return `<small>${convert_duedate(time_string)}</small>`
            } else {
                if (time_string == '') {
                    return '';
                } else {

                    if (time_string.length > 0) {

                        timeOnly = time_string.split(' ');
                        if (timeOnly.length > 1) {
                            timeOnly = timeOnly[1].substring(0, 5);
                            return convertTo12HourFormat(timeOnly);
                        } else {
                            return ''
                        }
                        // const hours = parseInt(timeOnly.split(':')[0]);
                        // let meridiem = 'am';
                        // if (hours >= 12) {
                        //     meridiem = 'pm';
                        // }
                        // return `${timeOnly} ${meridiem}`
                        // return convertTo12HourFormat(timeOnly);

                    } else {
                        return ''

                    }

                }
            }

        } else {
            return ''
        }

        // console.info(time_string);
        // console.info(time_string.split(' '));
        // // console.info(time_string.split(' ')[1].substring(0, 5));
        // return time_string
    }

    function convertTo12HourFormat(time24) {
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

    function convert_duedate(dateString) {
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

    function intialize_progres_bar(id) {


        return new ProgressBar.Circle(`#${id}`, {
            // color: '#91C300',
            // This has to be the same size as the maximum width to
            // prevent clipping
            strokeWidth: 10,
            trailWidth: 10,
            easing: 'easeInOut',
            trailColor: 'rgba(120, 195, 0, 0.15)',
            duration: 1400,
            text: {
                autoStyleContainer: false
            },
            from: {
                color: '#91C300',
                width: 10
            },
            to: {
                color: '#91C300',
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



    }
</script>