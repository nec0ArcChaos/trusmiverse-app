<!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->
<script>

    function get_resume_hr(project,year) {
        $.ajax({
            type: "post",
            url: base_url + `/get_resume_hr`,
            data: {
                project:project,
                year:year
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $('#jumlah_sales').text(response.rekrut.permintaan);
                $('#persen_sales').text(response.rekrut.achieve + '%');
                $('#persen_sales')
                    .removeClass(function(index, className) {
                        return (className.match(/(^|\s)bg-soft-\S+/g) || []).join(' '); // Menghapus semua class diawali "bg-soft-"
                    })
                    .addClass('badge bg-' + response.rekrut.warna);
                $('#pemenuhan_sales').text(response.rekrut.pemenuhan + '/' + response.rekrut.permintaan);
                $('#jumlah_training').text(response.training.jumlah);
                $('#rasio_training').text(response.training.rasio + '%');
                $('#rasio_training')
                    .removeClass(function(index, className) {
                        return (className.match(/(^|\s)bg-soft-\S+/g) || []).join(' '); // Menghapus semua class diawali "bg-soft-"
                    })
                    .addClass('badge bg-' + response.training.warna_rasio);

                recruit_pie();
                pretest_bar(response.training);
                var dep = ``;

                response.department.forEach(value => {
                    dep += `<div class="col">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar avatar-20 coverimg rounded-circle" data-division="${value.kode}" style="background-color: darkcyan; color: white; background-image: url(&quot;undefined&quot;);">
                                                ${value.kode}
                                            </div>
                                        </div>
                                        <div class="col-6">
                                        <small class="text-secondary" style="font-size: 10px;">${value.rasio}%</small>
                                        </div>
                                    </div>
                                </div>`;
                });
                $('#row_deparment').empty().append(dep);

                datatable_footer_hr(response.table);

            }
        });
    }

    function datatable_footer_hr(data) {
        $('#table_resume_hr').DataTable({
            "pageLength": 2,
            "lengthChange": false,
            "searching": false,
            "info": false,
            "paging": true,
            "autoWidth": false,
            "ordering": false,
            "destroy": true,
            "data": data,
            "columns": [{
                    "data": "training",
                    'className': 'small'
                },
                {
                    "data": "actual",
                    'className': 'small'
                },
                {
                    "data": "lulus",
                    'className': 'small'
                },
                {
                    "data": "pretest",
                    'className': 'small'
                },
                {
                    "data": "postest",
                    'className': 'small'
                },
                {
                    "data": "rasio",
                    'className': 'small'
                },
                // Tambahkan kolom lainnya sesuai kebutuhan
            ],
        });
    }

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
                    data: [20, 80],
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

    function pretest_bar(data) {
        console.log(data);

        var pretest = data.pretest;
        var postest = data.postest;
        var warna_pretest = data.warna_pretest;
        var warna_postest = data.warna_postest;
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
                labels: ["Pre", 'Post'],
                datasets: [{
                    label: 'Progress',
                    data: [pretest, postest],
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