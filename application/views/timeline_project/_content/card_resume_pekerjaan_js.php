<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    $(document).ready(function() {
        komplain_line();

    });

    function get_pekerjaan_status(project, year) {
        $.ajax({
            type: "POST",
            url: base_url + "/get_pekerjaan_data",
            data: {
                project: project,
                year: year
            },
            dataType: "json",
            success: function(response) {
                pekerjaan_pie(response.status);
                progress_bar(response.progres);
                leadtime_bar(response.leadtime);
                $('#p_leadtime').text(response.status.persen_ontime + '/'+response.status.persen_late);
                $('#p_ontime').css('width', response.status.persen_ontime + '%');
                $('#p_late').css('width', response.status.persen_late + '%');
                $('#t_all_progres').text(response.status.persen_done+'%');
                $('#d_status_done').text(response.status.done + ' (' + response.status.persen_done + '%)');
                $('#d_status_working_on').text(response.status.working_on + ' (' + response.status.persen_working_on + '%)');
                $('#d_status_waiting').text(response.status.waiting + ' (' + response.status.persen_waiting + '%)');
                $('#d_status_cancel').text(response.status.cancel + ' (' + response.status.persen_cancel + '%)');
            }
        });
    }

    function pekerjaan_pie(data_pekerjaan) {
        $('#div_pekerjaan_pie').empty().append(`
            <canvas id="pekerjaan_pie" style="width: 50px;"></canvas>`);
        const ctx = document.getElementById('pekerjaan_pie');

        const doughnutPointer = {
            id: 'doughnutPointer',
            afterDatasetsDraw(chart, args, plugins) {
                const {
                    ctx,
                    data
                } = chart;

                ctx.save();

                const xCenter = chart.getDatasetMeta(0).data[0].x;
                const yCenter = chart.getDatasetMeta(0).data[0].y;
                const innerRadius = chart.getDatasetMeta(0).data[0].innerRadius;
                const outerRadius = chart.getDatasetMeta(0).data[0].outerRadius;
                const doughnutThickness = outerRadius - innerRadius;
                const angle = Math.PI / 180;

                // achieve
                ctx.font = 'bold 20px sans-serif';
                ctx.fillStyle = '#8D8D8D';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(data_pekerjaan.jumlah, xCenter, yCenter - 5);

                ctx.font = 'bold 12px sans-serif';
                ctx.fillText('Total', xCenter, yCenter + 10);

            }
        }

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Done',
                    'Cancel',
                    'Working On',
                    'Not Start'
                ],
                datasets: [{
                        data: [
                            data_pekerjaan.done,
                            data_pekerjaan.cancel,
                            data_pekerjaan.working_on,
                            data_pekerjaan.waiting,

                        ],
                        borderColor: ['#C9EE8F', '#FD97A4', '#FFEC8F', '#F3F2F2'],
                        backgroundColor: ['#C9EE8F', '#FD97A4', '#FFEC8F', '#F3F2F2'],
                        cutout: '80%',
                    },

                ],
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                        position: 'bottom',
                    },
                    title: {
                        display: false,
                        text: ''
                    },
                    doughnutPointer: {
                        pointerColorText: 'white',
                        pointerRadius: 5
                    },
                    datalabels: {
                        color: 'white',
                        formatter: (value, ctx) => {
                            // return value + '%';
                            return value;
                        }
                    }
                },
            },
            // plugins: [doughnutPointer, ChartDataLabels]
            plugins: [doughnutPointer]
        });
    }
    // Variabel global untuk menyimpan instance chart
    let progressChartInstance = null;
    let leadtimeChartInstance = null;

    function progress_bar(data_progres) {
        var dep = data_progres.map((item) => item.kode_dep);
        var department_name = data_progres.map((item) => item.department_name);
        var progres = data_progres.map((item) => item.progres);

        var areachart = document.getElementById('div_progress').getContext('2d');

        // Destroy chart jika instance sudah ada
        if (progressChartInstance) {
            progressChartInstance.destroy();
        }

        var myareachart = {
            type: 'bar',
            data: {
                labels: dep,
                datasets: [{
                    label: 'Progress',
                    data: progres,
                    backgroundColor: function(context) {
                        var value = context.dataset.data[context.dataIndex];
                        return value < 60 ?
                            '#FD97A4' :
                            value >= 60 && value <= 75 ?
                            '#FFEC8F' :
                            '#C9EE8F';
                    },
                    borderRadius: {
                        bottomLeft: 8,
                        bottomRight: 8,
                    },
                    borderSkipped: false, // Ensure rounded corners appear
                }, ],
            },
            plugins: [ChartDataLabels],
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    datalabels: {
                        display: function(context) {
                            return context.datasetIndex === 0;
                        },
                        color: '#5A5A5C',
                        formatter: function(value) {
                            return Math.round(value);
                        },
                        anchor: 'bottom',
                        align: 'center',
                        clamp: true,
                        font: {
                            size: 10,
                        },
                    },
                },
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        },
                    },
                    y: {
                        display: false,
                        grid: {
                            display: false
                        },
                        stacked: true,
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            stepSize: 20,
                            font: {
                                size: 10
                            },
                            padding: 0
                        },
                    },
                },
            },
        };

        // Buat chart baru dan simpan instance-nya
        progressChartInstance = new Chart(areachart, myareachart);
    }

    function leadtime_bar(data_leadtime) {
        var dep = data_leadtime.map((item) => item.kode_dep);
        var department_name = data_leadtime.map((item) => item.department_name);
        var ontime = data_leadtime.map((item) => item.persen_ontime);
        var late = data_leadtime.map((item) => item.persen_late);

        var areachart = document.getElementById('div_leadtime').getContext('2d');

        // Destroy chart jika instance sudah ada
        if (leadtimeChartInstance) {
            leadtimeChartInstance.destroy();
        }

        var myareachart = {
            type: 'bar',
            data: {
                labels: dep,
                datasets: [{
                        label: 'Ontime',
                        data: ontime,
                        backgroundColor: '#C9EE8F', // Green for progress
                        borderRadius: {
                            bottomLeft: 8,
                            bottomRight: 8,
                        },
                        borderSkipped: false, // Ensure rounded corners appear
                    },
                    {
                        label: 'Late',
                        data: late,
                        backgroundColor: '#FD97A4', // Red for remaining
                        borderRadius: {
                            topLeft: 8,
                            topRight: 8,
                        },
                        borderSkipped: false, // Ensure rounded corners appear
                    },
                ],
            },
            plugins: [ChartDataLabels],
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false, // Display legend for clarity
                    },
                    datalabels: {
                        display: function(context) {
                            return context.datasetIndex === 0;
                        },
                        color: '#5A5A5C',
                        formatter: function(value) {
                            return value + '%';
                        },
                        anchor: 'end',
                        align: 'start',
                        clamp: true,
                        font: {
                            size: 10,
                        },
                    },
                },
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        },
                    },
                    y: {
                        display: false,
                        grid: {
                            display: false
                        },
                        stacked: true,
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            stepSize: 20,
                            font: {
                                size: 10
                            }
                        },
                    },
                },
            },
        };

        // Buat chart baru dan simpan instance-nya
        leadtimeChartInstance = new Chart(areachart, myareachart);
    }


    function komplain_line() {
        var options = {
            series: [{
                name: "Komplain",
                data: [40, 21, 75, 51, 70, ]
            }],
            chart: {
                height: 100,
                type: 'line',
                zoom: {
                    enabled: false
                },
                toolbar: {
                    show: false
                }
            },
            colors: ['#B46BF2'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'],
                    opacity: 0.5
                }
            },
            xaxis: {
                categories: ['LG', 'HR', 'IT', 'BR', 'SC']
            },
            legend: {
                labels: {
                    colors: '#5A5A5C'
                },
            }
        };

        var chart = new ApexCharts(document.getElementById('div_komplain'), options);
        chart.render();
    }
</script>