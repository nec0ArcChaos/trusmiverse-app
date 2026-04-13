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

<!-- full calender  -->
<script src="<?= base_url(); ?>assets/vendor/fullCalendar/lib/main.min.js"></script>
<!-- full calendar css -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/fullCalendar/lib/main.min.css">

<!-- Footable table master css -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/footable/footable.bootstrap.min.css">
<!-- Footable table master script-->
<script src="<?= base_url(); ?>assets/vendor/footable/footable.min.js"></script>


<script>
    /* table data master */
    $('.footable').footable({
        "paging": {
            "enabled": true,
            "container": '#footable-pagination',
            "countFormat": "{CP} of {TP}",
            "limit": 3,
            "position": "right",
            "size": 5
        },
        "sorting": {
            "enabled": true
        },
    }, function(ft) {
        $('#footablestot').html($('.footable-pagination-wrapper .label').html())

        $('.footable-pagination-wrapper ul.pagination li').on('click', function() {
            setTimeout(function() {
                $('#footablestot').html($('.footable-pagination-wrapper .label').html());
            }, 200);
        });

    });

    /* semi doughnut chart js */
    // var semidoughnutchart = document.getElementById('semidoughnutchart').getContext('2d');
    // var semidata = {
    //     labels: ['Revenue Booking', 'Revenue Akad', 'Revenue SDM', 'Other'],
    //     datasets: [
    //         {
    //             label: 'Expense categories',
    //             data: [45, 40, 5, 5],
    //             backgroundColor: ['#ffbb00', '#91c300', '#f03d4f', '#becede'],
    //             borderWidth: 0,
    //         }
    //     ]
    // };
    // var mysemidoughnutchartCofig = {
    //     type: 'doughnut',
    //     data: semidata,
    //     options: {
    //         circumference: 180,
    //         rotation: -90,
    //         responsive: true,
    //         cutout: 80,
    //         tooltips: {
    //             position: 'nearest',
    //             yAlign: 'bottom'
    //         },
    //         plugins: {
    //             legend: {
    //                 display: false,
    //                 position: 'top',
    //             },
    //             title: {
    //                 display: false,
    //                 text: 'Chart.js Doughnut Chart'
    //             }
    //         },
    //         layout: {
    //             padding: 0,
    //         },
    //     },
    // };
    // var mysemidoughnutchart = new Chart(semidoughnutchart, mysemidoughnutchartCofig);





    document.addEventListener('DOMContentLoaded', function() {
        // var calendarEl = document.getElementById('calendarNew');
        // var calendar = new FullCalendar.Calendar(calendarEl, {
        //   initialView: 'dayGridMonth'
        // });
        // calendar.render();
        var currentday = new Date();
        var thismonth = ("0" + (currentday.getMonth() + 1)).slice(-2);
        var thisyear = currentday.getFullYear();

        console.log(currentday)
        console.log(thismonth)
        console.log(thisyear)


        $.ajax({
            url: '<?= base_url() ?>dashboard/ibr_pro_calendar',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            console.log(response)
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
                    console.log(info.event.extendedProps.id_sub_task)
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
                                console.log(response.status)
                                console.log(response.detail)
                                if (response.status == true) {
                                    setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        $('#detail_title_sub_task').text(response.detail.sub_task);
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



    $(function() {
        class GaugeChart {
            constructor(element, params) {
                this._element = element;
                this._initialValue = params.initialValue;
                this._higherValue = params.higherValue;
                this._title = params.title;
                this._subtitle = params.subtitle;
            }

            _buildConfig() {
                let element = this._element;

                return {
                    value: this._initialValue,
                    valueIndicator: {
                        color: "#fff"
                    },
                    geometry: {
                        startAngle: 180,
                        endAngle: 360
                    },
                    scale: {
                        startValue: 0,
                        endValue: this._higherValue,
                        customTicks: [0, 250, 500, 780, 1050, 1300, 1560],
                        tick: {
                            length: 8
                        },
                        label: {
                            font: {
                                color: "#87959f",
                                size: 9,
                                family: '"Open Sans", sans-serif'
                            }
                        }
                    },
                    title: {
                        verticalAlignment: "bottom",
                        text: this._title,
                        font: {
                            family: '"Open Sans", sans-serif',
                            color: "#fff",
                            size: 10
                        },
                        subtitle: {
                            text: this._subtitle,
                            font: {
                                family: '"Open Sans", sans-serif',
                                color: "#fff",
                                weight: 700,
                                size: 28
                            }
                        }
                    },
                    onInitialized: function() {
                        let currentGauge = $(element);
                        let circle = currentGauge.find(".dxg-spindle-hole").clone();
                        let border = currentGauge.find(".dxg-spindle-border").clone();

                        currentGauge.find(".dxg-title text").first().attr("y", 48);
                        currentGauge.find(".dxg-title text").last().attr("y", 28);
                        currentGauge.find(".dxg-value-indicator").append(border, circle);
                    }
                };
            }

            init() {
                $(this._element).dxCircularGauge(this._buildConfig());
            }
        }

        $(document).ready(function() {
            $(".gauge").each(function(index, item) {
                let params = {
                    initialValue: 780,
                    higherValue: 1560,
                    title: `Temperature ${index + 1}`,
                    subtitle: "780 ºC"
                };

                let gauge = new GaugeChart(item, params);
                gauge.init();
            });

            $("#random").click(function() {
                $(".gauge").each(function(index, item) {
                    let gauge = $(item).dxCircularGauge("instance");
                    let randomNum = Math.round(Math.random() * 1560);
                    let gaugeElement = $(gauge._$element[0]);

                    gaugeElement.find(".dxg-title text").last().html(`${randomNum} ºC`);
                    gauge.value(randomNum);
                });
            });
        });
    });
</script>