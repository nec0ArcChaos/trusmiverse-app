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
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/hierarchy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>


<link href="<?= base_url(); ?>assets/vendor/c3-0.7.20/c3.css" rel="stylesheet">

<!-- Load d3.js and c3.js -->
<script src="<?= base_url(); ?>assets/vendor/c3-0.7.20/d3.js" charset="utf-8"></script>
<script src="<?= base_url(); ?>assets/vendor/c3-0.7.20/c3.js"></script>

<script>
    'use strict'

    $(document).ready(function() {

        /* semi doughnut chart js */
        var semidoughnutchart = document.getElementById('semidoughnutchart').getContext('2d');
        var semidata = {
            labels: ['Strategy', 'Goals'],
            datasets: [{
                label: 'Expense categories',
                data: [8, 3],
                backgroundColor: ['#2E75B5', '#ffbb00'],
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
                    legend: {
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

        var user_id = '786'; // 786 : goffar
        // var user_id = '340'; // 340 : irfannudin
        var periode = '2024-02';

        key_performance_indicator(user_id, periode);

        ibr_pro_calendar();

    }); // End of Ready Function


    function key_performance_indicator(user_id, periode){

        var body_kpi = ``;

        $.ajax({
            url: "<?= base_url('kpi/marketing') ?>",
            type: "POST",
            dataType: "json",
            data: {
                user_id: user_id,
                periode: periode,
            },
            success: function(response){

                // PROFILE
                $('#profile_name').html(response.data[0].name);
                $('#profile_designation').html(response.data[0].designation);
                $('#profile_figure').css('background-image', `url(https://trusmiverse.com/hr/uploads/profile/${response.data[0].profile_picture})`);
                $('#profile_picture').attr('src', `https://trusmiverse.com/hr/uploads/profile/${response.data[0].profile_picture}`);


                // CHART KPI
                response.data.forEach((value, index) => {
                    body_kpi += `<tr>
                                    <td>${value['poin_kpi']}</td>
                                    <td class="text-end">${value['target']}</td>
                                    <td class="text-end">${value['aktual']}</td>
                                    <td class="text-end">${value['achieve']}%</td>
                                    <td class="text-end">${value['bobot']}</td>
                                    <td class="text-end">${value['nilai']}</td>
                                </tr>`;

                    $('#body_kpi').html(body_kpi);


                });

                console.log(response.data[0].nilai_kpi)

                var nilai_kpi = 0;

                if(response.count != 0){
                    var nilai_kpi = response.data[0].nilai_kpi;
                }
                $('#nilai_kpi').html(nilai_kpi);
                chart_kpi(nilai_kpi);
                

            }
        })

    }


    // CHART KPI
    function chart_kpi(value) {

        am5.ready(function() {

            // Create root element
            // https://www.amcharts.com/docs/v5/getting-started/#Root_element
            var root = am5.Root.new("chartdivKpi");


            // Set themes
            // https://www.amcharts.com/docs/v5/concepts/themes/
            root.setThemes([
                am5themes_Animated.new(root)
            ]);


            // Create chart
            // https://www.amcharts.com/docs/v5/charts/radar-chart/
            var chart = root.container.children.push(am5radar.RadarChart.new(root, {
                panX: false,
                panY: false,
                startAngle: 160,
                endAngle: 380
            }));


            // Create axis and its renderer
            // https://www.amcharts.com/docs/v5/charts/radar-chart/gauge-charts/#Axes
            var axisRenderer = am5radar.AxisRendererCircular.new(root, {
                innerRadius: -40
            });

            axisRenderer.grid.template.setAll({
                stroke: root.interfaceColors.get("background"),
                visible: true,
                strokeOpacity: 0.8
            });

            var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
                maxDeviation: 0,
                min: 0,
                max: 100,
                strictMinMax: true,
                renderer: axisRenderer
            }));


            // Add clock hand
            // https://www.amcharts.com/docs/v5/charts/radar-chart/gauge-charts/#Clock_hands
            var axisDataItem = xAxis.makeDataItem({});

            var clockHand = am5radar.ClockHand.new(root, {
                pinRadius: am5.percent(20),
                radius: am5.percent(100),
                bottomWidth: 40
            })

            var bullet = axisDataItem.set("bullet", am5xy.AxisBullet.new(root, {
                sprite: clockHand
            }));

            xAxis.createAxisRange(axisDataItem);

            var label = chart.radarContainer.children.push(am5.Label.new(root, {
                fill: am5.color(0xffffff),
                centerX: am5.percent(50),
                textAlign: "center",
                centerY: am5.percent(50),
                fontSize: "1.5em"
            }));

            // SET VALUE KPI
            axisDataItem.set("value", value);
            
            bullet.get("sprite").on("rotation", function() {
                var value = axisDataItem.get("value");
                var text = Math.round(axisDataItem.get("value")).toString();
                var fill = am5.color(0x000000);
                xAxis.axisRanges.each(function(axisRange) {
                    if (value >= axisRange.get("value") && value <= axisRange.get("endValue")) {
                        fill = axisRange.get("axisFill").get("fill");
                    }
                })

                label.set("text", Math.round(value).toString());

                clockHand.pin.animate({
                    key: "fill",
                    to: fill,
                    duration: 500,
                    easing: am5.ease.out(am5.ease.cubic)
                })
                clockHand.hand.animate({
                    key: "fill",
                    to: fill,
                    duration: 500,
                    easing: am5.ease.out(am5.ease.cubic)
                })
            });

            // setInterval(function() {
            //     axisDataItem.animate({
            //         key: "value",
            //         to: Math.round(Math.random() * 140 - 40),
            //         duration: 500,
            //         easing: am5.ease.out(am5.ease.cubic)
            //     });
            // }, 2000)

            chart.bulletsContainer.set("mask", undefined);


            // Create axis ranges bands
            // https://www.amcharts.com/docs/v5/charts/radar-chart/gauge-charts/#Bands
            var bandsData = [{
                title: "Deadwood",
                color: "#6c757d",
                lowScore: 0,
                highScore: 59
            }, {
                title: "Prblem",
                color: "#ee1f25",
                lowScore: 60,
                highScore: 69
            }, {
                title: "Prspctve",
                color: "#fac702",
                lowScore: 70,
                highScore: 84
            }, {
                title: "Star",
                color: "#0f9747",
                lowScore: 85,
                highScore: 100
            }];

            am5.array.each(bandsData, function(data) {
                var axisRange = xAxis.createAxisRange(xAxis.makeDataItem({}));

                axisRange.setAll({
                    value: data.lowScore,
                    endValue: data.highScore
                });

                axisRange.get("axisFill").setAll({
                    visible: true,
                    fill: am5.color(data.color),
                    fillOpacity: 0.8
                });

                axisRange.get("label").setAll({
                    text: data.title,
                    // inside: false,
                    radius: 15,
                    fontSize: "0.9em",
                    // fill: root.interfaceColors.get("background")
                    fill: '#000000'
                });
            });


            // Make stuff animate on load
            chart.appear(1000, 100);

        }); // end am5.ready()

    }



    function ibr_pro_calendar(){
        $.ajax({
            url: '<?= base_url() ?>dashboard/ibr_pro_calendar',
            type: 'GET',
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
    }

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
</script>


<script>
    // CHART EVENT
    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chartdivEvent");


        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);


        // Create wrapper container
        var container = root.container.children.push(am5.Container.new(root, {
            width: am5.percent(100),
            height: am5.percent(100),
            layout: root.verticalLayout
        }));


        // Create series
        // https://www.amcharts.com/docs/v5/charts/hierarchy/#Adding
        var series = container.children.push(am5hierarchy.ForceDirected.new(root, {
            singleBranchOnly: false,
            downDepth: 1,
            initialDepth: 2,
            valueField: "value",
            categoryField: "name",
            childDataField: "children",
            centerStrength: 0.5
        }));


        // Generate and set data
        // https://www.amcharts.com/docs/v5/charts/hierarchy/#Setting_data
        var maxLevels = 2;
        var maxNodes = 5;
        var maxValue = 5;

        var data = {
            name: "Event",
            value: 1,
            children: [{
                    name: 'MOM',
                    value: 10,
                    children: [{
                        name: 'Tasklist',
                        value: 10
                    }]
                },
                {
                    name: 'Co and Co',
                    value: 10
                },
                {
                    name: 'Briefing',
                    value: 10
                },
                {
                    name: 'Gemba',
                    value: 10
                }
            ]
        }


        // generateLevel(data, "", 0);

        series.data.setAll([data]);
        series.set("selectedDataItem", series.dataItems[0]);

        return data

        // function generateLevel(data, name, level) {
        //     for (var i = 0; i < Math.ceil(maxNodes * Math.random()) + 1; i++) {
        //         var nodeName = name + "ABCDEFGHIJKLMNOPQRSTUVWXYZ" [i];
        //         var child;
        //         if (level < maxLevels) {
        //             child = {
        //                 name: nodeName + level
        //             }

        //             if (level > 0 && Math.random() < 0.5) {
        //                 child.value = Math.round(Math.random() * maxValue);
        //             } else {
        //                 child.children = [];
        //                 generateLevel(child, nodeName + i, level + 1)
        //             }
        //         } else {
        //             child = {
        //                 name: name + i,
        //                 value: Math.round(Math.random() * maxValue)
        //             }
        //         }
        //         data.children.push(child);
        //     }

        //     level++;
        //     return data;
        // }


        // Make stuff animate on load
        series.appear(1000, 100);

    }); // end am5.ready()
</script>


<script>
    // CHART STARNDAR
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
            paddingLeft: 0,
            layout: root_rs.verticalLayout
        }));


        // Add legend_rs
        // https://www.amcharts.com/docs/v5/charts/xy-chart_rs/legend_rs-xy-series/
        var legend_rs = chart_rs.children.push(am5.Legend.new(root_rs, {
            centerX: am5.p50,
            x: am5.p50
        }))


        // Data
        var data_rs = [{
                std: "Rasio Berkas Reject",
                target: 10,
                actual: 20
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


            series_rs.bullets.push(function() {
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

            series_rs.bullets.push(function() {
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
