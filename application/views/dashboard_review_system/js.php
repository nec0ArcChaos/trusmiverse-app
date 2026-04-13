<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script>
    // Inisialisasi DataTable dengan tombol ekspor
    $(document).ready(function() {

        /*Range*/
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
            console.log('filter date: ', start.format('YYYY-MM'));
            // dt_tbl_resume_tiket(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            resume_traffic_system_overview(start.format('YYYY-MM'));
            resume_progress_review_system(start.format('YYYY-MM'));
            // cardsresume
            // load_card_resume(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        }

        // Buat daftar ranges per bulan secara otomatis
        let monthRanges = {};
        for (let i = 0; i < 12; i++) {
            let month = moment('2025-01', 'YYYY-MM').add(i, 'months');
            let label = month.format('YYYY-MM'); // contoh: 2025-01
            monthRanges[label] = [month.startOf('month'), month.endOf('month')];
        }

        $('.range').daterangepicker({
            startDate: moment().startOf('month'),
            endDate: moment().endOf('month'),
            "drops": "down",
            ranges: monthRanges,
            // ranges: {
            //     '2025-01': [moment('2025-01', 'YYYY-MM').startOf('month'), moment('2025-01', 'YYYY-MM').endOf('month')],
            //     '2025-02': [moment('2025-02', 'YYYY-MM').startOf('month'), moment('2025-02', 'YYYY-MM').endOf('month')],
            //     '2025-03': [moment('2025-03', 'YYYY-MM').startOf('month'), moment('2025-03', 'YYYY-MM').endOf('month')]
            // },
            locale: {
                format: 'YYYY-MM' // format tampilan
            }
        }, cb);

        cb(start, end);

        // datepicker month
        $("#periode").datepicker({
            format: "yyyy-mm",
            viewMode: "year",
            minViewMode: "months",
            autoclose: true,
            orientation: "bottom"
        });

        const periodeNow = '<?= date("Y-m"); ?>';
        resume_traffic_system_overview(periodeNow);
        dt_traffic_system_overview(periodeNow);
        dt_ticket_perdivisi(periodeNow);
        dt_resume_ticket_by_pic(periodeNow);
        get_pencapaian_progres_tiket(periodeNow);
        resume_progress_review_system(periodeNow);
        resume_tracking_system_error(periodeNow);
        get_list_ticket_error(periodeNow);
        // $('#dt_traffic_system').DataTable({
        //     dom: 'Bfrtip',
        //     buttons: [
        //         'copyHtml5',
        //         'excelHtml5',
        //         'csvHtml5',
        //         'pdfHtml5'
        //     ],
        //     scrollX: true,
        //     scrollCollapse: true,
        //     paging: false,
        //     searching: false,
        //     info: false
        // });
    });

    
    // Plugin untuk membuat background canvas transparan
    const transparentBackgroundPlugin = {
        id: 'transparentBackground',
        beforeDraw: (chart) => {
            const ctx = chart.canvas.getContext('2d');
            ctx.save();
            ctx.globalCompositeOperation = 'destination-over';
            ctx.fillStyle = 'transparent';
            ctx.fillRect(0, 0, chart.width, chart.height);
            ctx.restore();
        }
    };

    const baseUrl = '<?= base_url('dashboard_review_system') ?>';

    // Resume Traffic System Overview
    let trafficChart;

    function resume_traffic_system_overview(periode) {
        $.ajax({
            url: `${baseUrl}/resume_traffic_system_overview/${periode}`,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                // console.log(data[0]); // Cek data yang diterima dari server

                jumlahSistem = data[0].jumlah_sistem;
                jumlahSistemDigunakan = data[0].jumlah_sistem_digunakan;

                persentase = (jumlahSistemDigunakan / jumlahSistem) * 100;
                persentase = Math.round(persentase); // Bulatkan ke angka terdekat

                // Gauge Chart - Traffic System Overview 
                const ctxGauge = document.getElementById('gaugeChart').getContext('2d');

                // Plugin untuk teks + badge di tengah gauge2
                const gaugeTextPlugin = {
                    id: 'gaugeTextPlugin',
                    afterDraw(chart) {
                        const {
                            ctx,
                            chartArea: {
                                width,
                                height
                            }
                        } = chart;
                        const centerY = height - 70; // Naikkan posisi semua teks & badge

                        ctx.save();
                        ctx.textAlign = 'center';

                        // Badge hijau ▲ 2%
                        ctx.font = 'bold 12px Arial';
                        ctx.fillStyle = '#28a745';
                        ctx.beginPath();
                        ctx.roundRect(width / 2 - 20, centerY - 60, 40, 20, 10);
                        ctx.fill();
                        ctx.fillStyle = '#fff';
                        ctx.fillText('▲ 2%', width / 2, centerY - 45);

                        // Hitung lebar total untuk persentase + teks
                        ctx.font = 'bold 24px Arial';
                        const percentText = persentase + '%';
                        const percentWidth = ctx.measureText(percentText).width;

                        ctx.font = '12px Arial';
                        const subText = `(${jumlahSistemDigunakan}/${jumlahSistem})`;
                        const subWidth = ctx.measureText(subText).width;

                        const totalWidth = percentWidth + 6 + subWidth; // 6px jarak antar teks
                        let startX = (width / 2) - (totalWidth / 2);

                        // Gambar persentase
                        ctx.font = 'bold 24px Arial';
                        ctx.fillStyle = '#000';
                        ctx.fillText(percentText, startX + percentWidth / 2, centerY - 7);

                        // Gambar teks kecil
                        ctx.font = '12px Arial';
                        ctx.fillStyle = '#555';
                        ctx.fillText(subText, startX + percentWidth + 6 + subWidth / 2, centerY - 7);

                        ctx.restore();
                    }
                };

                // Gradient biru → hijau
                const gradient = ctxGauge.createLinearGradient(0, 0, 200, 0);
                gradient.addColorStop(0, '#007bff'); // biru
                gradient.addColorStop(1, '#28a745'); // hijau

                // kalau chart sudah ada, hapus dulu
                if (trafficChart) {
                    trafficChart.destroy();
                }

                trafficChart = new Chart(ctxGauge, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [persentase, 100 - persentase],
                            backgroundColor: [gradient, '#e9ecef'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        rotation: -90,
                        circumference: 180,
                        cutout: '75%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false
                            }
                        }
                    },
                    plugins: [gaugeTextPlugin]
                });
                
                // let sering = 0;
                // let jarang = 0;
                // let tidak_sama_sekali = 0;

                // data.forEach(item => {
                //     if (item.kategori_traffic === 'Sering') {
                //         sering++;
                //     } else if (item.kategori_traffic === 'Jarang') {
                //         jarang++;
                //     } else if (item.kategori_traffic === 'Tidak Sama Sekali') {
                //         tidak_sama_sekali++;
                //     }
                // });

                // // Update chart dengan data dari AJAX
                // trafficChart.data.datasets[0].data = [sering, jarang, tidak_sama_sekali];
                // trafficChart.update();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }   

    // List dt table Traffic System Overview
    function dt_traffic_system_overview(periode) {
        $('#dt_traffic_system').DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "pageLength": 9,
            "autoWidth": false,
            "destroy": true,
            // dom: 'Bfrtip',
            // buttons: [{
            //     extend: 'excelHtml5',
            //     title: 'Data List Problem Solving',
            //     text: '<i class="bi bi-download text-white"></i>',
            //     footer: true
            // }],
            "ajax": {
                "url": `${baseUrl}/dt_traffic_system`,
                "dataType": 'JSON',
                "type": "POST",
                "data": {
                    periode: periode,
                    // end: '2025-08-31'
                },
                // "success": function (res){
                //   console.log(res);
                // },
                // "error": function (jqXHR){
                //   console.log(jqXHR.responseText);
                // }
            },
            "columns": [{
                    'data': 'divisi',
                    'render': function(data, type, row) {
                        // res = data;
                        // res = `<a href="javascript:void(0);" class="badge bg-sm bg-primary" onclick="proses_resume('${data}')">${data}</a>`;
                        return `<strong>${data}</strong>`;
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'jumlah_sistem',
                    'render': function(data, type, row) {
                        return `<span class="text-blue">${row['jumlah_sistem_digunakan']}</span>/${data} sistem <br> <span class="badge-status badge-green">${row['p_traffic_sering']}% Sering</span>`;
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'jumlah_sistem_digunakan',
                    'render': function(data, type, row) {
                        return `70% <br><small>Cukup Puas</small>`;
                    },
                    // 'render': function(data, type, row) {
                    //     if (data == 1) {
                    //         color = 'bg-warning';
                    //         text = 'Waiting'
                    //     } else if (data == 2) {
                    //         color = 'bg-info';
                    //         text = 'Verified'
                    //     } else {
                    //         color = 'bg-success';
                    //         text = 'Paid'
                    //     }
                    //     return `<span class="badge bg-sm ${color}">${text}</span>`;
                    // }
                },
                {
                    'data': 'persen_sistem_digunakan',
                    'render': function(data, type, row) {
                        return `70% <br><small>Cukup Puas</small>`;
                    },
                },
                {
                    'data': 'jml_traffic_sering',
                    'render': function(data, type, row) {
                        return `70% <br><small>Cukup Puas</small>`;
                    },
                },
                {
                    'data': 'p_traffic_sering',
                    'render': function(data, type, row) {
                        return `<span class="badge-status badge-green">80%</span>`;
                    },
                },
            ]
        });
    }

    // Resume Progress Review System
    let progressChart;
    function resume_progress_review_system(periode) {
        $.ajax({
            url: `${baseUrl}/resume_progress_review_system/${periode}`,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                // console.log(data.persen_progress_review); // Cek data yang diterima dari server
                // return;
                // Progress review system
                const progressValue = data.persen_progres_review; // persen

                // Plugin untuk teks di tengah
                const centerText = {
                    id: 'centerText',
                    beforeDraw(chart) {
                        const {
                            ctx,
                            chartArea: {
                                width,
                                height
                            }
                        } = chart;
                        ctx.save();

                        // Teks persentase
                        ctx.font = 'bold 22px Arial';
                        ctx.fillStyle = '#000';
                        ctx.textBaseline = 'middle';
                        const text = progressValue + '%';
                        ctx.fillText(text, width / 2 - ctx.measureText(text).width / 2, height / 2 - 8);

                        // Teks bawah
                        ctx.font = '14px Arial';
                        ctx.fillStyle = '#555';
                        const subText = 'Progress Review';
                        ctx.fillText(subText, width / 2 - ctx.measureText(subText).width / 2, height / 2 + 10);

                        ctx.restore();
                    }
                };

                const ctx2 = document.getElementById('progressChart').getContext('2d');

                // Buat gradien biru
                const gradient3 = ctx2.createLinearGradient(0, 0, 0, 150);
                gradient3.addColorStop(0, '#4facfe'); // biru muda
                gradient3.addColorStop(1, '#00f2fe'); // biru kehijauan

                // kalau chart sudah ada, hapus dulu
                if (progressChart) {
                    progressChart.destroy();
                }

                progressChart = new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [progressValue, 100 - progressValue],
                            backgroundColor: [
                                gradient3, // pakai gradien
                                'rgba(230, 230, 230, 0.3)'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: false, // penting agar ukuran canvas dipakai
                        cutout: '80%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false
                            }
                        }
                    },
                    plugins: [centerText]
                });

                $('#p_kesesuaian').text(data.persen_sesuai);
                $('#p_kepuasan').text(data.persen_kepuasan);

                get_system_reviewed_notreviewed(periode);

                // $('#prs_jumlah_sistem').text(data.jumlah_sistem);
                // $('#prs_sudah_direview').text(data.jml_sistem_sudah_direview);
                // $('#prs_persen_progres_review').text(data.persen_progres_review + '%');

                // $('#prs_sudah_sesuai').text(data.sudah_sesuai);
                // $('#prs_tidak_sesuai').text(data.tidak_sesuai);
                // $('#prs_persen_sesuai').text(data.persen_sesuai + '%');

                // $('#prs_jml_sudah_puas').text(data.jml_sudah_puas);
                // $('#prs_persen_kepuasan').text(data.persen_kepuasan + '%');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    function get_system_reviewed_notreviewed(periode) {
        $.ajax({
            url: `${baseUrl}/get_system_reviewed_notreviewed/${periode}`,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                // console.log(data.reviewed);

                const limit = 3;

                // List reviewed system
                let strReviewed = data.reviewed
                .slice(0, limit)              // ambil 3 item pertama
                .map(item => item.menu)       // ambil value dari menu
                .join(" - ");                  // ubah jadi string

                // Tambahkan "..." kalau total item lebih dari limit
                // if (data.reviewed.length > limit) {
                //     strReviewed += "...";
                // }
                // console.log(strReviewed); // "Marketing, Perencana, Keuangan..."
                $('#list_reviewed').text(strReviewed);

                // List Not reviewed system
                let strNotReviewed = data.not_reviewed
                .slice(0, limit)
                .map(item => item.menu) 
                .join(" - ");                  

                // if (data.not_reviewed.length > limit) {
                //     strNotReviewed += "...";
                // }
                // console.log(strNotReviewed);
                $('#list_not_reviewed').text(strNotReviewed);

            }
        });
                
    }
            
    // Ticket Per Divisi
    function dt_ticket_perdivisi(periode) {
        // console.log('fungsi dt_ticket_perdivisi berjalan ', periode);
        
        $('#dt_ticket_perdivisi').DataTable({
            // "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            // "responsive": true,
            "ajax": {
                "url": `${baseUrl}/dt_ticket_perdivisi`,
                "dataType": 'JSON',
                "type": "POST",
                "data": {
                    periode: periode,
                },
            },
            columnDefs: [
                { width: "300px", targets: 0 }, // kolom Nama
            ],
            "autoWidth": false,
            "columns": [{
                    'data': 'divisi',
                    'render': function(data, type, row) {
                        return `<strong>${data}</strong>`;
                    },
                    // width: '400px'
                },
                {
                    'data': 'total_pengajuan',
                    'className': 'text-center'
                },
                {
                    'data': 'total_notstarted',
                    'className': 'text-center'
                },
                {
                    'data': 'total_progres',
                    'render': function(data, type, row) {
                        persen_progres = (data / row['total_pengajuan']) * 100;

                        return `<span class="text-primary">${data}</span>/<span class="text-muted">${row['total_pengajuan']}</span> On Progress
                                <div class="mt-1">
                                    <div class="progress-bar bg-info" style="heightx:6px; width: ${persen_progres}%; border-radiusx: 4px;"></div>
                                </div>`;
                    },
                    // 'className': 'text-center'
                },
                {
                    'data': 'total_uat',
                    'className': 'text-center'
                },
                {
                    'data': 'total_done',
                    'className': 'text-center'
                },
                {
                    'data': 'total_cancel',
                    'className': 'text-center'
                },
                {
                    'data': 'total_hold',
                    'className': 'text-center'
                },
                {
                    'data': 'total_waitinglist',
                    'className': 'text-center'
                },
            ]
        });
    }

    // resume ticket by pic
    function dt_resume_ticket_by_pic(periode) {

        $('#dt_resume_ticket_by_pic').DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "pageLength": 5,
            "autoWidth": false,
            "destroy": true,
            "responsive": true,
            "ajax": {
                "url": `${baseUrl}/get_resume_ticket_by_pic`,
                "dataType": 'JSON',
                "type": "POST",
                "data": {
                    periode: periode,
                },
            },
            "columns": [{
                    'data': 'pic',
                    'render': function(data, type, row) {
                        return `<strong>${data}</strong>`;
                    },
                },
                {
                    'data': 'total_ticket',
                    'className': 'text-center'
                },
                {
                    'data': 'ticket_done',
                    'className': 'text-center'
                },
                {
                    'data': 'persen_done',
                    'className': 'text-center'
                },
                {
                    'data': 'persen_done',
                    'render': function(data, type, row) {
                        kategori = '';
                        if (data == 100) {
                            kategori = 'Excellent';
                        } else if (data > 50) {
                            kategori = 'Good';
                        } else {
                            kategori = 'Not Good';
                        }
                        return `<span class="text-primary">${data}% ${kategori}</span>
                                <div class="progressx mt-1" style="height:6px;">
                                    <div class="progress-bar bg-success" style="width: ${data}%;"></div>
                                </div>`;
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'persen_leadtime',
                    'className': 'text-center'
                },
            ]
        });
    }

    // Statistik progres tiket
    function get_pencapaian_progres_tiket(periode) {
        $.ajax({
            url: `${baseUrl}/get_pencapaian_progres_tiket/${periode}`,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                // console.log(data); // Cek data yang diterima dari server

                // Statistik Progres Tiket
                const progressValuex = data.persen_done; // persen

                // Plugin untuk teks di tengah
                const centerTextx = {
                    id: 'centerText',
                    beforeDraw(chart) {
                        const {
                            ctx,
                            chartArea: {
                                width,
                                height
                            }
                        } = chart;
                        ctx.save();

                        // Teks persentase
                        ctx.font = 'bold 22px Arial';
                        ctx.fillStyle = '#000';
                        ctx.textBaseline = 'middle';
                        const text = progressValuex + '%';
                        ctx.fillText(text, width / 2 - ctx.measureText(text).width / 2, height / 2 - 8);

                        // Teks bawah
                        ctx.font = '14px Arial';
                        ctx.fillStyle = '#555';
                        const subText = 'Done';
                        ctx.fillText(subText, width / 2 - ctx.measureText(subText).width / 2, height / 2 + 10);

                        ctx.restore();
                    }
                };

                const ctx3 = document.getElementById('progressChartTicket').getContext('2d');

                // Buat gradien biru
                const gradientx = ctx3.createLinearGradient(0, 0, 0, 150);
                gradientx.addColorStop(0, '#4facfe'); // biru muda
                gradientx.addColorStop(1, '#00f2fe'); // biru kehijauan

                new Chart(ctx3, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [progressValuex, 100 - progressValuex],
                            backgroundColor: [
                                gradientx, // pakai gradien
                                'rgba(230, 230, 230, 0.3)'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: false, // penting agar ukuran canvas dipakai
                        cutout: '80%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false
                            }
                        }
                    },
                    plugins: [centerTextx]
                });

                $('#spt_total_tiket').text(data.total_tiket);
                // $('#spt_total_tiket_progres').text(data.tiket_on_progres);
                $('#spt_total_tiket_done').text(data.total_done);
                $('#spt_persen_done').text(data.persen_done);
                $('#spt_total_tiket_progres').text(data.total_onprogress);
                $('#spt_persen_progres').text(data.persen_onprogress);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    // Tracking System Error
    function resume_tracking_system_error(periode) {
        $.ajax({
            url: `${baseUrl}/get_tracking_system_error`,
            method: 'POST',
            dataType: 'json',
            data: {
                periode: periode
            },
            success: function(data) {
                // console.log(data); // Cek data yang diterima dari server

                $('#persen_solved').text(data.persen_solved);
                $('#total_solved').text(data.total_solved);
                $('#total_error').text(data.total);

                $('.progress-fill').css('width', parseInt(data.persen_solved, 10) + '%');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    // Tracking system error - List ticket error
    function get_list_ticket_error(periode) {
        $.ajax({
            url: `${baseUrl}/get_list_ticket_error`,
            method: 'POST',
            dataType: 'json',
            data: {
                periode: periode
            },
            success: function(data) {
                // console.log(data); // Cek data yang diterima dari server
                let list_error = ``;

                data.forEach(element => {
                    console.log(element.bug_error);

                    badge_priority = (element.priority == 'Critical' || element.priority == 'High') ? 'urgent' : 'normal';
                    badge_status = (element.status == 'Done' || element.status == 'Working On') ? 'normal' : 'urgent';

                    list_error = list_error + `<div class="error-item">
                                                    <div class="error-header">
                                                        <h5>${element.bug_error}</h5>
                                                        <span class="badge ${badge_priority}">${element.priority} Priority</span>
                                                    </div>
                                                    <p class="error-date">${element.created_at}</p>
                                                    <div class="error-meta two-column">
                                                        <div class="meta-row">
                                                            <span class="meta-label">👤 User:</span>
                                                            <span class="meta-value"><strong>${element.user}</strong></span>
                                                        </div>
                                                        <div class="meta-row">
                                                            <span class="meta-label">🧑‍💼 PIC:</span>
                                                            <span class="meta-value"><strong>${element.pic}</strong></span>
                                                        </div>
                                                        <div class="meta-row">
                                                            <span class="meta-label">⚡ Status:</span>
                                                            <span class="meta-value"><span class="badge ${badge_status}">${element.status}</span></span>
                                                        </div>
                                                    </div>
                                                </div>`;

                    $('.error-list').empty().append(list_error);
                    
                });

                // $('#persen_solved').text(data.persen_solved);
                // $('#total_solved').text(data.total_solved);
                // $('#total_error').text(data.total);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }
    

    // Line Chart
    const ctxTraffic = document.getElementById('trafficChart').getContext('2d');
    new Chart(ctxTraffic, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar'],
            datasets: [{
                    label: 'Sering',
                    data: [12, 19, 15],
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0,123,255,0.1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Jarang',
                    data: [10, 14, 12],
                    borderColor: '#6c757d',
                    backgroundColor: 'rgba(108,117,125,0.1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Tidak Sama Sekali',
                    data: [6, 9, 7],
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220,53,69,0.1)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
        plugins: [transparentBackgroundPlugin]
    });

    // Gauge Chart with gradient
    // const ctx = document.getElementById('progressGauge').getContext('2d');
    // const gradient2 = ctx.createLinearGradient(0, 0, 0, 200);
    // gradient2.addColorStop(0, '#4facfe'); // Biru muda
    // gradient2.addColorStop(1, '#005bea'); // Biru tua

    // new Chart(ctx, {
    //     type: 'doughnut',
    //     data: {
    //         datasets: [{
    //             data: [30, 70],
    //             backgroundColor: [gradient2, 'rgba(255,255,255,0.1)'],
    //             borderWidth: 0
    //         }]
    //     },
    //     options: {
    //         cutout: '80%',
    //         rotation: -90,
    //         circumference: 180,
    //         responsive: true,
    //         plugins: {
    //             legend: {
    //                 display: false
    //             },
    //             tooltip: {
    //                 enabled: false
    //             },
    //             beforeDraw: chart => {
    //                 const {
    //                     ctx,
    //                     chartArea: {
    //                         width,
    //                         height
    //                     }
    //                 } = chart;
    //                 ctx.save();
    //                 ctx.font = 'bold 24px Arial';
    //                 ctx.fillStyle = '#fff';
    //                 ctx.textAlign = 'center';
    //                 ctx.textBaseline = 'middle';
    //                 ctx.fillText('30%', width / 2, height / 2 - 10);
    //                 ctx.font = '14px Arial';
    //                 ctx.fillText('Done', width / 2, height / 2 + 10);
    //             }
    //         }
    //     },
    //     plugins: [{
    //         id: 'centerText',
    //         beforeDraw(chart) {
    //             const {
    //                 ctx,
    //                 chartArea: {
    //                     width,
    //                     height
    //                 }
    //             } = chart;
    //             ctx.save();
    //             ctx.font = 'bold 24px Arial';
    //             ctx.fillStyle = '#000';
    //             ctx.textAlign = 'center';
    //             ctx.textBaseline = 'middle';
    //             ctx.fillText('30%', width / 2, height / 2 - 10);
    //             ctx.font = '14px Arial';
    //             ctx.fillText('Done', width / 2, height / 2 + 10);
    //         }
    //     }]
    // });

    // Kepuasan Pengguna
    get_list_kepuasan_pengguna('2025-08');
    function get_list_kepuasan_pengguna(periode) {
        $.ajax({
            url: `${baseUrl}/list_kepuasan_pengguna`,
            method: 'POST',
            dataType: 'json',
            data: {
                periode: periode
            },
            success: function(data) {
                // console.log(data); // Cek data yang diterima dari server
                let list_kepuasan = ``;

                data.forEach(element => {
                    console.log(element.jenis_pertanyaan);

                    // badge_priority = (element.priority == 'Critical' || element.priority == 'High') ? 'urgent' : 'normal';
                    // badge_status = (element.status == 'Done' || element.status == 'Working On') ? 'normal' : 'urgent';

                    list_kepuasan = list_kepuasan + `<tr><td>${element.jenis_pertanyaan}</td><td>${element.rata_rata}</td></tr>`;

                    $('#list_kepuasan').empty().append(list_kepuasan);
                    
                });

            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    // Chart kepuasan
    const ctx = document.getElementById('kepuasanChart').getContext('2d');
    new Chart(ctx, {
    type: 'doughnut',
    data: {
        datasets: [{
        data: [3.94, 5 - 3.94],
        backgroundColor: ['#1E88E5', '#E0E0E0'],
        borderWidth: 0
        }]
    },
    options: {
        rotation: 200, // Sudut mulai
        circumference: 240, // Lebar arc
        cutout: '75%',
        responsive: true,
        plugins: {
        legend: { display: false },
        tooltip: { enabled: false }
        }
    }
    });
</script>