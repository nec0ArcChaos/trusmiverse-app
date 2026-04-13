<!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->
<script>
    $(document).ready(function() {
        recruit_pie();
        pretest_bar();
    });

    function recruit_pie() {
        $('#div_recruit_pie').empty().append('<canvas id="recruit_pie" style="display: block; box-sizing: border-box; width: 100%; margin-top:0px"></canvas>');
        const ctxPie0 = document.getElementById('recruit_pie');
        // $('#div_myChartPie1_label').removeClass('d-none');
        new Chart(ctxPie0, {
            type: 'pie',
            data: {
                labels: ['Late', 'Ontime'],
                datasets: [{
                    label: '%',
                    data: [20,80],
                    borderWidth: 0,
                    backgroundColor: ['#F03D4F', '#C9EE8F'],
                }]
            },
            // plugins: [ChartDataLabels], // Assuming ChartDataLabels is imported
            options: {
                plugins: {
                    legend: {
                        display: false,
                        position: 'bottom'
                    },
                    datalabels: {
                        display: false,
                        color: '#fff',
                        anchor: 'top',
                        align: 'end',
                        clamp: true,
                        offset: 1,
                        font: {
                            size: 9,
                            weight: 'bold'
                        },
                        padding: {
                            bottom: 0
                        },
                        formatter: (value, ctx) => {
                            return value + "%";
                        }
                    }
                },
                maintainAspectRatio: false,
                responsive: true,
                height: 80
            }
        });
    }

    function pretest_bar() {
        // var dep = data_progres.map((item) => item.kode_dep);
        // var department_name = data_progres.map((item) => item.department_name);
        // var progres = data_progres.map((item) => item.progres);

        var areachart = document.getElementById('training_pretest').getContext('2d');

        // Destroy chart jika instance sudah ada
        if (progressChartInstance) {
            progressChartInstance.destroy();
        }

        var myareachart = {
            type: 'bar',
            data: {
                labels: ["Pre",'Post'],
                datasets: [{
                    label: 'Progress',
                    data: [50,60],
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
</script>