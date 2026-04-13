<!-- swiper js script -->
<script src="<?= base_url(); ?>assets/vendor/swiper-7.3.1/swiper-bundle.min.js"></script>

<!-- tiny mce editor text -->
<script src="https://cdn.tiny.cloud/1/3tcgz5yib8w69zao6u0nx3v6yjfouaf328xn62qjle6aa5ur/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script src="<?= base_url(); ?>assets/js/calendar-schedule-resource.js"></script>

<!-- full calender  -->
<script src="<?= base_url(); ?>assets/vendor/fullCalendar/lib/main.min.js"></script>
<!-- full calendar css -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/fullCalendar/lib/main.min.css">




<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>


<link href="<?= base_url(); ?>assets/vendor/c3-0.7.20/c3.css" rel="stylesheet">

<!-- Load d3.js and c3.js -->
<script src="<?= base_url(); ?>assets/vendor/c3-0.7.20/d3.js" charset="utf-8"></script>
<script src="<?= base_url(); ?>assets/vendor/c3-0.7.20/c3.js"></script>




<script>
    'use strict'

    $(window).on('load', function() {
        /* datepicker with time */
        $('#scheduledatepicker').daterangepicker({
            "singleDatePicker": true,
            "startDate": "01/01/2022",
            "endDate": "01/07/2022",
            "drops": "up",
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function(start, end, label) {
            //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });
    });

    function updateClock() {
        var currentTime = new Date();
        // Operating System Clock Hours for 12h clock
        var currentHoursAP = currentTime.getHours();
        // Operating System Clock Hours for 24h clock
        var currentHours = currentTime.getHours();
        // Operating System Clock Minutes
        var currentMinutes = currentTime.getMinutes();
        // Operating System Clock Seconds
        var currentSeconds = currentTime.getSeconds();
        // Adding 0 if Minutes & Seconds is More or Less than 10
        currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
        currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;
        // Picking "AM" or "PM" 12h clock if time is more or less than 12
        var timeOfDay = (currentHours < 12) ? "AM" : "PM";
        // transform clock to 12h version if needed
        currentHoursAP = (currentHours > 12) ? currentHours - 12 : currentHours;
        // transform clock to 12h version after mid night
        currentHoursAP = (currentHoursAP == 0) ? 12 : currentHoursAP;
        // display first 24h clock and after line break 12h version
        var currentTimeString = "24h kello: " + currentHours + ":" + currentMinutes + ":" + currentSeconds + "" + "<br>" + "12h kello: " + currentHoursAP + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
        // print clock js in div #clock.
        document.getElementById("hrs").innerHTML = currentHours
        document.getElementById("min").innerHTML = currentMinutes
        document.getElementById("sec").innerHTML = currentSeconds
    }
    $(document).ready(function() {

        /* semi doughnut chart_rs js */
        var semidoughnutchart = document.getElementById('semidoughnutchart').getContext('2d');
        var semidata = {
            labels: ['Konsistensi'],
            datasets: [{
                label: 'Expense categories',
                data: [50],
                backgroundColor: ['#ffbb00'],
                borderWidth: 0,
            }]
        };
        var mysemidoughnutchartCofig = {
            type: 'doughnut',
            data: semidata,
            options: {
                circumference: 180,
                rotation: -90,
                responsive: true,
                cutout: 80,
                tooltips: {
                    position: 'nearest',
                    yAlign: 'bottom'
                },
                plugins: {
                    legend_rs: {
                        display: false,
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Chart.js Doughnut Chart'
                    }
                },
                layout: {
                    padding: 0,
                },
            },
        };
        var mysemidoughnutchart = new Chart(semidoughnutchart, mysemidoughnutchartCofig);


        // setInterval(updateClock, 1000);

        const date = new Date();
        let day = date.toString().substring(0, 15);
        $('#today').text(day);



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
</script>


<script src="<?= base_url(); ?>assets/canvas-gauges/gauge.min.js"></script>

<script>
    var gaugePS_kpi = new RadialGauge({
        renderTo: 'gauge-ps-kpi',
        width: 200,
        height: 200,
        units: 'KPI',
        minValue: 0,
        maxValue: 100,
        majorTicks: [
            '0',
            '10',
            '20',
            '30',
            '40',
            '50',
            '60',
            '70',
            '80',
            '90',
            '100'
        ],
        minorTicks: 2,
        ticksAngle: 190,
        startAngle: 45,
        strokeTicks: true,
        highlights: [{
                from: 0,
                to: 35,
                color: 'rgba(225, 7, 23, 0.75)'
            },
            {
                from: 35,
                to: 65,
                color: 'rgba(253, 185, 0.75)'
            },
            {
                from: 65,
                to: 100,
                color: 'rgba(73, 214, 156)'
            },
        ],
        valueInt: 1,
        valueDec: 0,
        colorPlate: "#fff",
        colorMajorTicks: "#686868",
        colorMinorTicks: "#686868",
        colorTitle: "#000",
        colorUnits: "#000",
        colorNumbers: "#686868",
        valueBox: true,
        colorValueText: "#000",
        colorValueBoxRect: "#fff",
        colorValueBoxRectEnd: "#fff",
        colorValueBoxBackground: "#fff",
        colorValueBoxShadow: false,
        colorValueTextShadow: false,
        colorNeedleShadowUp: true,
        colorNeedleShadowDown: false,
        colorNeedle: "rgba(200, 50, 50, .75)",
        colorNeedleEnd: "rgba(200, 50, 50, .75)",
        colorNeedleCircleOuter: "rgba(200, 200, 200, 1)",
        colorNeedleCircleOuterEnd: "rgba(200, 200, 200, 1)",
        borderShadowWidth: 0,
        borders: false,
        borderInnerWidth: 0,
        borderMiddleWidth: 0,
        borderOuterWidth: 5,
        colorBorderOuter: "#fafafa",
        colorBorderOuterEnd: "#cdcdcd",
        needleType: "arrow",
        needleWidth: 2,
        needleCircleSize: 7,
        needleCircleOuter: true,
        needleCircleInner: false,
        animationDuration: 1500,
        animationRule: "dequint",
        fontNumbers: "Verdana",
        fontTitle: "Verdana",
        fontUnits: "Verdana",
        fontValue: "Led",
        fontValueStyle: 'italic',
        fontNumbersSize: 20,
        fontNumbersStyle: 'italic',
        fontNumbersWeight: 'bold',
        fontTitleSize: 24,
        fontUnitsSize: 22,
        fontValueSize: 50,
        animatedValue: true
    });
    gaugePS_kpi.draw();
    gaugePS_kpi.value = "70";
</script>




<!-- STANDAR -->

<script>


    var chart_standar = c3.generate({
        bindto: '#chart_standar',
        data: {
            columns: [
                ['standar', '45']
            ],
            type: 'gauge',
            // onclick: function (d, i) { console.log("onclick", d, i); },
            // onmouseover: function (d, i) { console.log("onmouseover", d, i); },
            // onmouseout: function (d, i) { console.log("onmouseout", d, i); }
        },
        gauge: {
            label: {
                format: function(value, ratio) {
                    return `${value.toFixed()} %`;
                },
                show: false // to turn off the min/max labels.
            },
            min: 0, // 0 is default, //can handle negative min e.g. vacuum / voltage / current flow / rate of change
            max: 100, // 100 is default
            units: ' %',
            width: 39 // for adjusting arc thickness
        },
        color: {
            pattern: ['#FF0000', '#F97600', '#F6C600', '#60B044'], // the three color levels for the percentage values.
            threshold: {
    //            unit: 'value', // percentage is default
    //            max: 200, // 100 is default
                values: [30, 60, 90, 100]
            }
        },
        size: {
            height: 180
        }
    });

    // setTimeout(function () {
    //     chart_standar.load({
    //         columns: [['data', 10]]
    //     });
    // }, 1000);




















    am5.ready(function() {

    // Create root_rs element
    // https://www.amcharts.com/docs/v5/getting-started/#Root_element
    var root_rs = am5.Root.new("chart_rasio_leadtime");


    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root_rs.setThemes([
    am5themes_Animated.new(root_rs)
    ]);


    // Create chart_rs
    // https://www.amcharts.com/docs/v5/charts/xy-chart_rs/
    var chart_rs = root_rs.container.children.push(am5xy.XYChart.new(root_rs, {
    panX: false,
    panY: false,
    wheelX: "panX",
    wheelY: "zoomX",
    paddingLeft:0,
    layout: root_rs.verticalLayout
    }));


    // Add legend_rs
    // https://www.amcharts.com/docs/v5/charts/xy-chart_rs/legend_rs-xy-series/
    var legend_rs = chart_rs.children.push(am5.Legend.new(root_rs, {
        centerX: am5.p50,
        x: am5.p50
    }))


    // Data
    var data_rs = [
            {
                std: "Rasio Berkas Reject",
                target: 20,
                actual: 10
            }, 
            {
                std: "Leadtime Berkas",
                target: 95,
                actual: 80
            },
        ];


    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart_rs/axes/
    var yAxis_rs = chart_rs.yAxes.push(am5xy.CategoryAxis.new(root_rs, {
    categoryField: "std",
    renderer: am5xy.AxisRendererY.new(root_rs, {
        inversed: true,
        cellStartLocation: 0.1,
        cellEndLocation: 0.9,
        minorGridEnabled: true
    })
    }));

    yAxis_rs.data.setAll(data_rs);

    var xAxis_rs = chart_rs.xAxes.push(am5xy.ValueAxis.new(root_rs, {
    renderer: am5xy.AxisRendererX.new(root_rs, {
        strokeOpacity: 0.1,
        minGridDistance: 50
    }),
    min: 0
    }));


    // Add series
    // https://www.amcharts.com/docs/v5/charts/xy-chart_rs/series/
    function createSeries(field, name) {
    var series_rs = chart_rs.series.push(am5xy.ColumnSeries.new(root_rs, {
        name: name,
        xAxis: xAxis_rs,
        yAxis: yAxis_rs,
        valueXField: field,
        categoryYField: "std",
        sequencedInterpolation: true,
        tooltip: am5.Tooltip.new(root_rs, {
        pointerOrientation: "horizontal",
        labelText: "[bold]{name}[/]\n{categoryY}: {valueX}"
        })
    }));

    series_rs.columns.template.setAll({
        height: am5.p100,
        strokeOpacity: 0
    });


    series_rs.bullets.push(function () {
        return am5.Bullet.new(root_rs, {
        locationX: 1,
        locationY: 0.5,
        sprite: am5.Label.new(root_rs, {
            centerY: am5.p50,
            text: "{valueX} %",
            populateText: true
        })
        });
    });

    series_rs.bullets.push(function () {
        return am5.Bullet.new(root_rs, {
        locationX: 1,
        locationY: 0.5,
        sprite: am5.Label.new(root_rs, {
            centerX: am5.p100,
            centerY: am5.p50,
            text: "{name}",
            fill: am5.color(0xffffff),
            populateText: true
        })
        });
    });

    series_rs.data.setAll(data_rs);
    series_rs.appear();

    return series_rs;
    }

    createSeries("target", "Target");
    createSeries("actual", "Actual");


    // Add legend_rs
    // https://www.amcharts.com/docs/v5/charts/xy-chart_rs/legend_rs-xy-series/
    var legend_rs = chart_rs.children.push(am5.Legend.new(root_rs, {
    centerX: am5.p50,
    x: am5.p50
    }));

    legend_rs.data.setAll(chart_rs.series.values);


    // Add cursor
    // https://www.amcharts.com/docs/v5/charts/xy-chart_rs/cursor/
    var cursor_rs = chart_rs.set("cursor", am5xy.XYCursor.new(root_rs, {
    behavior: "zoomY"
    }));
    cursor_rs.lineY.set("forceHidden", true);
    cursor_rs.lineX.set("forceHidden", true);


    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    chart_rs.appear(1000, 100);

    }); // end am5.ready()
</script>


<!-- STANDAR -->

