<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>


<script>
    var base_url = '<?= base_url('hr/onboarding'); ?>';
    var periode = '<?= date('Y-m') ?>';
    // $.ajaxSetup({
    //     url: "<?= base_url('hr/onboarding'); ?>", // Sets a default path
    //     global: false,
    // });

    $('#periode-list .dropdown-item').on('click', function () {
        var clickedItem = $(this);

        var selectedValue = clickedItem.val(); // Contoh: "2025-09"
        $('#periode-list .dropdown-item').removeClass('active');
        clickedItem.addClass('active');
        periode = selectedValue;
        $('#periodeBtn').text(selectedValue);
        load_all();
    });
    const barValuePlugin = {
        id: 'barValuePlugin',
        afterDatasetsDraw(chart) {
            const { ctx, data } = chart;
            ctx.save();
            // Atur font dan warna teks angka
            ctx.font = "bold 12px 'Nunito', sans-serif";
            ctx.fillStyle = "#333";
            ctx.textBaseline = "middle";

            // Looping setiap bar untuk mengambil koordinat dan nilainya
            chart.getDatasetMeta(0).data.forEach((bar, index) => {
                const value = data.datasets[0].data[index];
                // bar.x adalah koordinat ujung kanan bar, bar.y adalah titik tengah vertikal bar
                // + 8 digunakan untuk memberi jarak (margin) antara bar dan teks
                ctx.fillText(value, bar.x + 8, bar.y);
            });
            ctx.restore();
        }
    };

    $(document).ready(function () {
        $('body').addClass('menu-close');
        $('#periodeBtn').text(periode);
        load_all();


        // --- 1. SETUP FUNNEL CHART (Menggunakan Horizontal Bar) ---



        // --- 2. SETUP GAUGE CHART (Menggunakan Doughnut + Custom Jarum) ---
        // Custom Plugin untuk menggambar jarum (needle)


        const verticalTextPlugin = {
            id: 'verticalTextPlugin',
            afterDatasetsDraw(chart) {
                const { ctx, data } = chart;
                ctx.save();
                const dataset = data.datasets[0];
                const meta = chart.getDatasetMeta(0);

                meta.data.forEach((bar, index) => {
                    const value = dataset.data[index];
                    // const picText = dataset.picTexts[index];

                    // A. Gambar Angka (Value) di pucuk Bar
                    ctx.font = 'bold 14px "Segoe UI", sans-serif';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';

                    if (value === 0) {
                        // Jika nilai 0, angka ditaruh di luar/atas garis bawah
                        ctx.fillStyle = '#4285F4';
                        ctx.fillText(value, bar.x, bar.y - 10);
                    } else {
                        // Jika ada nilai, angka ditaruh di dalam bar (atas)
                        ctx.fillStyle = '#ffffff';
                        ctx.fillText(value, bar.x, bar.y + 15);
                    }

                    // B. Gambar Teks Vertikal (Nama Tim PIC)
                    ctx.save();
                    ctx.translate(bar.x, bar.base - 15); // Mulai dari dasar bar
                    ctx.rotate(-Math.PI / 2); // Putar 90 derajat ke atas tegak lurus

                    ctx.font = '12px "Segoe UI", sans-serif';
                    ctx.textAlign = 'left';
                    ctx.textBaseline = 'middle';

                    if (value === 0) {
                        ctx.fillStyle = '#999999'; // Teks abu-abu untuk yang bernilai 0
                        // ctx.fillText(picText, 25, 0); // Geser dikit ke atas agar tidak tabrakan dengan angka 0
                    } else {
                        ctx.fillStyle = 'rgba(255, 255, 255, 0.85)'; // Teks putih transparan dalam bar
                        // ctx.fillText(picText, 0, 0);
                    }
                    ctx.restore();
                });
                ctx.restore();
            }
        };

        // 2. INISIALISASI CHART
        const ctxSla = document.getElementById('slaChart').getContext('2d');
        new Chart(ctxSla, {
            type: 'bar',
            data: {
                // Gunakan array di dalam array agar teks label X turun ke baris baru
                labels: [
                    ['1. Menerima', 'list on boarding', 'dari rekrutment'],
                    ['2. Konfirmasi', 'list dari team', 'rekrutment'],
                    ['3. Pelaksanaan', 'training onboarding', 'in class'],
                    ['4. Assignment', 'peserta'],
                    ['4. Pemberian', 'dokumen', 'standar kerja'], // Mengikuti angka "4" ganda di gambar
                    ['5. Monitoring', 'form', 'orientasi'],
                    ['6. Office tour'],
                    ['7. Penyerahan', 'ke user']
                ],
                datasets: [{
                    label: 'SLA Activity',
                    data: [3, 3, 1, 1, 0, 1, 2, 3], // Angka sesuai gambar
                    // Properti custom ini ditangkap oleh Plugin di atas
                    // picTexts: [
                    //     'Tim Recruitment Sesuai PIC nya',
                    //     'Tim Recruitment Sesuai PIC nya',
                    //     'Tim Training sesuai PIC nya',
                    //     'Tim Training sesuai PIC nya',
                    //     'Tim Training sesuai PIC nya',
                    //     'Tim Training sesuai PIC nya',
                    //     'Tim Training sesuai PIC nya',
                    //     'Tim Training sesuai PIC nya'
                    // ],
                    backgroundColor: '#c50073', // Biru solid mirip gambar
                    barPercentage: 0.6, // Mengatur ketebalan bar
                    categoryPercentage: 0.8
                }]
            },
            plugins: [verticalTextPlugin], // Panggil plugin custom di sini
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: { top: 30 } // Beri jarak agar judul tidak mepet
                },
                plugins: {
                    legend: { display: false }, // Sembunyikan kotak legend
                    title: {
                        display: true,
                        // text: 'TOTAL ACTIVITY LEWAT SLA',
                        font: {
                            size: 20,
                            style: 'italic',
                            weight: 'bold',
                            family: '"Segoe UI", sans-serif'
                        },
                        color: '#666',
                        padding: { bottom: 20 }
                    },
                    tooltip: {
                        callbacks: {
                            // Custom tooltip agar memunculkan label Tim PIC-nya juga saat dihover
                            afterLabel: function (context) {
                                const index = context.dataIndex;
                                return context.dataset.picTexts[index];
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 11, weight: '500' },
                            color: '#333'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        border: { display: false },
                        ticks: {
                            stepSize: 1, // Agar Y axis tampil 0, 1, 2, 3 bulat
                            font: { size: 13 }
                        }
                    }
                }
            }
        });

    });

    function load_all() {
        resume();
        funnel();
        overall();
        onboarding_monitoring();
    }


    function resume() {
        $.ajax({
            'url': base_url + "/resume",
            'type': "POST",
            'data': {
                periode: periode
            },
            'dataType': "JSON",
            'success': function (response) {
                $('#total_karyawan').text(response.total_karyawan);

                // 2. Set Onboarding Completed
                $('#ratio_complete').text(`(${response.compelete}/${response.total_karyawan})`);
                $('#persen_complete').text(response.persen_complete + '%');

                // 3. Set Peserta InProgress (peserta)
                $('#ratio_inprogress').text(`(${response.peserta}/${response.total_karyawan})`);
                $('#peserta_count').text(response.peserta);

                // 4. Set Peserta Belum Mulai
                $('#ratio_not_started').text(`(${response.not_started}/${response.total_karyawan})`);
                $('#not_started').text(response.not_started);

                // 5. Set BA Serah Terima / Progres Visual
                $('#progres_val').text(response.compelete);
                $('#persen_progres').text(response.persen_complete + '%');
                $('#progress_bar').css('width', response.persen_complete + '%');
            }
        })
    }
    function funnel() {
        $.ajax({
            'url': base_url + "/funnel",
            'type': "POST",
            'data': {
                periode: periode
            },
            'dataType': "JSON",
            'success': function (response) {
                destroyChartIfExists('funnelChart'); // Hancurkan chart lama jika sudah ada
                const ctxFunnel = document.getElementById('funnelChart').getContext('2d');
                new Chart(ctxFunnel, {
                    type: 'bar',
                    data: {
                        labels: ['List dari Rekrutmen', 'Training Class', 'Assignment', 'Office Tour', 'Serah Terima'],
                        datasets: [{
                            label: 'Jumlah',
                            data: [response.total_karyawan, response.training_class, response.assignment, response.office_tour, response.serah_terima], // Data Dummy
                            backgroundColor: [
                                '#2962ff', // Biru tua
                                '#448aff',
                                '#64b5f6',
                                '#90caf9',
                                '#26c6da'  // Cyan terang
                            ],
                            borderRadius: 4,
                            // 2. Perbesar persentase ini untuk memperkecil jarak antar bar (maksimal 1.0)
                            barPercentage: 0.95,
                            categoryPercentage: 0.95
                        }]
                    },
                    // 3. Daftarkan plugin yang sudah dibuat di atas ke dalam chart ini
                    plugins: [barValuePlugin],
                    options: {
                        indexAxis: 'y', // Mengubah bar menjadi horizontal
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                // Beri ruang kosong di kanan agar angka (terutama yang paling panjang) tidak terpotong ujung kanvas
                                right: 30
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function (context) { return context.raw + ' Peserta'; }
                                }
                            }
                        },
                        scales: {
                            x: {
                                display: false,
                                beginAtZero: true
                            },
                            y: {
                                grid: { display: false },
                                border: { display: false },
                                ticks: { font: { size: 11, family: "'Nunito', sans-serif" } }
                            }
                        }
                    }
                });
            }
        })
    }
    function overall() {
        $.ajax({
            'url': base_url + "/overall",
            'type': "POST",
            'data': {
                periode: periode
            },
            'dataType': "JSON",
            'success': function (response) {
                $('#value_overall').text(response.overall + '%');
                $('#value_overall').removeClass('bg-success bg-warning bg-danger');
                if (response.overall > 75) {
                    $('#value_overall').addClass('bg-success');
                } else if (response.overall > 60 && response.overall <= 75) {
                    $('#value_overall').addClass('bg-warning');
                } else {
                    $('#value_overall').addClass('bg-danger');
                }
                const gaugeNeedle = {
                    id: 'gaugeNeedle',
                    afterDatasetDraw(chart, args, options) {
                        const { ctx, config, data } = chart;
                        const meta = chart.getDatasetMeta(0);
                        const cx = meta.data[0].x; // Center X koordinat chart
                        const cy = meta.data[0].y; // Center Y koordinat chart
                        const outerRadius = meta.data[0].outerRadius; // Jari-jari terluar chart

                        // Ambil persentase (Contoh: 60%)
                        const needleValue = data.datasets[0].needleValue;
                        // Konversi nilai persen ke sudut (Radian)
                        const angle = Math.PI + (needleValue / 100 * Math.PI);

                        ctx.save();
                        ctx.translate(cx, cy);
                        ctx.rotate(angle);

                        // Gambar batang jarum
                        ctx.beginPath();
                        ctx.moveTo(0, -4);
                        ctx.lineTo(outerRadius - 20, 0);
                        ctx.lineTo(0, 4);
                        ctx.fillStyle = '#333';
                        ctx.fill();

                        // Gambar lingkaran tengah jarum
                        ctx.rotate(-angle);
                        ctx.beginPath();
                        ctx.arc(0, 0, 8, 0, Math.PI * 2);
                        ctx.fillStyle = '#333';
                        ctx.fill();
                        ctx.restore();
                    }
                };

                destroyChartIfExists('gaugeChart'); // Hancurkan chart lama jika sudah ada
                const ctxGauge = document.getElementById('gaugeChart').getContext('2d');
                new Chart(ctxGauge, {
                    type: 'doughnut',
                    data: {
                        labels: ['Danger', 'Warning', 'Safe'],
                        datasets: [{
                            // Partisi warna (33% merah, 33% kuning, 34% hijau)
                            data: [33, 33, 34],
                            backgroundColor: ['#ff4d4d', '#ffdb4d', '#4caf50'],
                            borderWidth: 0,
                            needleValue: response.overall, // <-- GANTI ANGKA INI UNTUK MENGGESER JARUM (0-100)
                            cutout: '75%'    // Ketebalan donat
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        circumference: 180, // Membuat donat menjadi setengah lingkaran
                        rotation: -90,      // Memutar donat agar posisinya di atas
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: false }
                        }
                    },
                    plugins: [gaugeNeedle] // Mengaktifkan plugin jarum custom
                });
            }
        })
    }






    function onboarding_monitoring() {
        $('#data_proses').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            // "order": [
            //     [0, 'desc']
            // ],
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "method": "POST",
                "url": base_url + "/onboarding_monitoring",
                "data": {
                    periode: periode,
                },
                'dataSrc': ''
            },
            columns: [
                {
                    "data": null,
                    "className": "text-center",
                    "render": function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                // 1. Nama Karyawan
                { "data": "nama_karyawan" },
                // 2. Company
                { "data": "company" },
                // 3. Department
                { "data": "departement" },
                // 4. Join Date
                { "data": "date_of_joining", "className": "text-center" },
                { "data": "date_of_leaving", "className": "text-center" },
                // 5. Status Onboarding Keseluruhan
                { "data": "status", "className": "text-center" },

                // --- Training Class ---
                // 6. Status Training
                {
                    'data':"due_date_1"
                },
                {
                    "data": "status_ontime_training",
                    "className": "text-center",
                    "render": function (data, type, row) {
                        return formatBadge(data); // Fungsi opsional untuk mempercantik status (Lihat di bawah)
                    }
                },
                // 7. Date Training
                { "data": "actual_tgl_training", "className": "text-center", "defaultContent": "-" },

                // --- Assignment ---
                // 8. Status Assignment
                 {
                    'data':"due_date_2"
                },
                {
                    "data": "status_ontime_assignment",
                    "className": "text-center",
                    "render": function (data, type, row) { return formatBadge(data); }
                },
                // 9. Date Assignment
                { "data": "actual_tgl_assignment", "className": "text-center", "defaultContent": "-",
                    render: function (data, type, row) {
                        if(row.status_ontime_assignment == 'Tidak Lanjut') {
                            return '-';
                        }
                        return data; // Tampilkan tanggal jika ada
                    }
                 },

                // --- Office Tour ---
                // 10. Status Office Tour
                {
                    'data':"due_date_3"
                },
                {
                    "data": "status_ontime_tour",
                    "className": "text-center",
                    "render": function (data, type, row) { return formatBadge(data); }
                },
                // 11. Date Office Tour
                { "data": "actual_tgl_tour", "className": "text-center", "defaultContent": "-",
                    render: function (data, type, row) {
                        if(row.status_ontime_tour == 'Tidak Lanjut') {
                            return '-';
                        }
                        return data; // Tampilkan tanggal jika ada
                    }
                 },

                // --- BA Serah Terima ---
                // 12. Status BA Serah Terima
                {
                    'data':"due_date_4"
                },
                {
                    "data": "status_ontime_serah_terima",
                    "className": "text-center",
                    "render": function (data, type, row) { return formatBadge(data); }
                },
                // 13. Date BA Serah Terima
                { "data": "actual_tgl_serah_terima", "className": "text-center", "defaultContent": "-",
                     render: function (data, type, row) {
                        if(row.status_ontime_serah_terima == 'Tidak Lanjut') {
                            return '-';
                        }
                        return data; // Tampilkan tanggal jika ada
                    }
                 },

                // 14. Status Kelulusan
                {
                    "data": "status_test",
                    "className": "text-center fw-bold"
                },

                // 15. Action
                // {
                //     "data": "id",
                //     "className": "text-center",
                //     "orderable": false,
                //     "render": function (data, type, row) {
                //         // Tombol action, ganti URL atau function onClick sesuai kebutuhan Anda
                //         return `<button class="btn btn-sm btn-primary" onclick="viewDetail(${data})">
                //                 <i class="bi bi-eye"></i> Detail
                //             </button>`;
                //     }
                // }
            ]
        });
    }
    function formatBadge(statusText) {
        if (!statusText || statusText === '-') return '-';

        let colorClass = 'bg-secondary';
        if (statusText === 'Ontime') colorClass = 'bg-success';
        else if (statusText === 'Late') colorClass = 'bg-danger';
        else if (statusText === 'In Progress') colorClass = 'bg-warning text-dark';
        else if (statusText === 'Resign') colorClass = 'bg-dark';

        return `<span class="badge ${colorClass}">${statusText}</span>`;
    }



    function destroyChartIfExists(canvasId) {
        // Chart.getChart() akan mencari instance chart yang menempel pada ID tersebut
        let existingChart = Chart.getChart(canvasId);

        // Jika chart ditemukan, hancurkan
        if (existingChart) {
            existingChart.destroy();
        }
    }



    function warna_kpi(value) {
        if (value == 'not_achieved') {
            return '#F44336';
        } else {
            return '#91C300';
        }
    }

    function warna_by_status(value) {
        if (value == 'bad') {
            return '#F44336';
        } else if (value == 'warning') {
            return '#FFC107';
        } else {
            return '#91C300';
        }
    }

    function bg_status(value) {
        if (value == 'bad') {
            return 'danger';
        } else if (value == 'warning') {
            return 'warning';
        } else {
            return 'success';
        }
    }

    function bg_badge(value) {
        if (value == 'high') {
            return 'bg-light-red text-danger';
        } else if (value == 'medium') {
            return 'bg-light-yellow text-warning';
        } else {
            return 'bg-light-blue text-primary';
        }
    }

    function status_progres(value) {
        if (value == 'On Progress') {
            return 'bg-warning';
        } else if (value == 'In Progress') {
            return 'bg-primary';
        } else if (value == 'Stuck') {
            return 'bg-danger';
        } else {
            return 'bg-success';
        }
    }

    function status_plan(value) {
        if (value == 'Waiting') {
            return 'bg-secondary pe-auto';
        } else if (value == 'Take') {
            return 'bg-light-blue text-primary';
        } else {
            return 'bg-light-red text-danger';
        }
    }

    function get_warna(value) {
        if (value > 75) {
            return '#91C300';
        } else if (value > 60 && value <= 75) {
            return '#FFC107';
        } else {
            return '#F44336';
        }
    }


</script>