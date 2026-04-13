<!-- swiper js script -->
<script src="<?= base_url(); ?>assets/vendor/swiper-7.3.1/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>


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
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


<link href="<?= base_url(); ?>assets/vendor/c3-0.7.20/c3.css" rel="stylesheet">

<!-- Load d3.js and c3.js -->
<script src="<?= base_url(); ?>assets/vendor/c3-0.7.20/d3.js" charset="utf-8"></script>
<script src="<?= base_url(); ?>assets/vendor/c3-0.7.20/c3.js"></script>

<script src="https://code.jscharting.com/latest/jscharting.js"></script>
<script type="text/javascript" src="https://code.jscharting.com/latest/modules/types.js">

<script>
    'use strict'

    $(document).ready(function() {

        /* semi doughnut chart js */
        

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

<?php 
$this->load->view('dashboard/hr/kiri_js');
$this->load->view('dashboard/hr/kanan_js');
 ?>