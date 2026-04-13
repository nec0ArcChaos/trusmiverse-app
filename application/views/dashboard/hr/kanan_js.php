<script>
    $(document).ready(function() {

        chart_kpi(70);
        chart_event();
        chart_displin();




    });

    

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



    function chart_event() {
        var options = {
            series: [50, 100, 100, 90],
            chart: {
                height: 390,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    offsetY: 0,
                    startAngle: 0,
                    endAngle: 270,
                    hollow: {
                        margin: 5,
                        size: '30%',
                        background: 'transparent',
                        image: undefined,
                    },
                    dataLabels: {
                        name: {
                            show: false,
                        },
                        value: {
                            show: true,
                            fontSize: '18pt',
                        }
                    },
                    barLabels: {
                        enabled: true,
                        useSeriesColors: true,
                        margin: 8,
                        fontSize: '16px',
                        formatter: function(seriesName, opts) {
                            return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
                        },
                    },
                }
            },
            colors: ['#1ab7ea', '#0084ff', '#39539E', '#393D4B'],
            labels: ['Meeting', 'Co&Co', 'Sharing Leader', 'Breafing'],
            responsive: [{
                breakpoint: 480,
                options: {
                    legend: {
                        show: false
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#event_chart"), options);
        chart.render();
    }

    function chart_displin() {
        var chart_disiplin = c3.generate({
            bindto: '#chart_disiplin',
            data: {
                columns: [
                    ['Disiplin', '93']
                ],
                type: 'gauge',
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
    }
</script>