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
    var base_url = '<?= base_url('hr/refreshment'); ?>';
    var periode = '<?= date('Y-m') ?>';
    // $.ajaxSetup({
    //     url: "<?= base_url('hr/refreshment'); ?>", // Sets a default path
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

    $(document).ready(function () {
        $('body').addClass('menu-close');
        $('#periodeBtn').text(periode);
        load_all();


        // --- 1. SETUP FUNNEL CHART (Menggunakan Horizontal Bar) ---


    });

    function load_all() {
        resume();
        upcoming();
        data_monitoring();

    }

    function resume() {
        $.ajax({
            method: "POST",
            url: base_url + "/resume",
            data: {
                periode: periode,
            },
            dataType: "json",
            success: function (response) {
                $('#val-total-under').text(response.total_under);

                // 2. Set TNA Completed (Format: complete / total_under)
                $('#ratio-tna').text(`(${response.complete}/${response.total_under})`);
                $('#val-tna').text(response.complete);

                // 3. Set Materials Prepared (Format: prepare / jumlah_materi)
                $('#ratio-prepare').text(`(${response.prepare}/${response.jumlah_materi})`);
                $('#val-prepare').text(response.prepare);

                // 4. Set Materials Approved (Format: approved / jumlah_materi)
                $('#ratio-approved').text(`(${response.approved}/${response.jumlah_materi})`);
                $('#val-approved').text(response.approved);

                // 5. Set Training Implementations (Format: implement / jumlah_materi)
                $('#ratio-implement').text(`(${response.implement}/${response.jumlah_materi})`);
                $('#val-implement').text(response.implement);
            }
        });
    }
    function upcoming() {
        $.ajax({
            method: "POST",
            url: base_url + "/upcoming",
            data: {
                periode: periode,
            },
            dataType: "json",
            success: function (data) {
                let html = "";
                let container = $("#upcoming-container");

                // Bersihkan container sebelum diisi data baru
                container.empty();

                // Jika data kosong
                if (data.length === 0) {
                    container.html("<div class='text-center text-muted mt-3'>Tidak ada jadwal upcoming training.</div>");
                    return;
                }

                // Array gaya untuk warna dan ikon agar bervariasi seperti desain awalmu
                const styles = [
                    { iconBg: 'bg-primary text-primary', icon: 'bi-calendar-event', badge: 'bg-danger text-danger border-danger-subtle' },
                    { iconBg: 'bg-success text-success', icon: 'bi-journal-text', badge: 'bg-warning text-dark border-warning-subtle' },
                    { iconBg: 'bg-info text-info', icon: 'bi-easel', badge: 'bg-secondary text-secondary border-secondary-subtle' }
                ];

                // Looping data JSON
                $.each(data, function (index, item) {
                    // Pilih gaya berdasarkan urutan (index)
                    let style = styles[index % styles.length];

                    // --- PROSES TANGGAL ---
                    let targetDate = new Date(item.workshop_at);

                    // Format: "4 Maret 2026"
                    let formattedDate = targetDate.toLocaleDateString('id-ID', {
                        day: 'numeric', month: 'long', year: 'numeric'
                    });

                    // Hitung sisa hari
                    let today = new Date();
                    today.setHours(0, 0, 0, 0); // Reset jam hari ini
                    let targetDay = new Date(targetDate);
                    targetDay.setHours(0, 0, 0, 0); // Reset jam target

                    let diffDays = Math.ceil((targetDay - today) / (1000 * 60 * 60 * 24));

                    let daysText = "";
                    if (diffDays === 0) {
                        daysText = "Hari ini";
                    } else if (diffDays > 0) {
                        daysText = diffDays + " hari lagi";
                    } else {
                        daysText = Math.abs(diffDays) + " hari lalu"; // Jika sudah terlewat
                    }

                    // Hapus border bawah untuk item paling terakhir agar rapi
                    let borderClass = (index === data.length - 1) ? "" : "border-bottom pb-3 mb-3";

                    // --- INJEKSI HTML ---
                    html += `
                    <div class="d-flex align-items-center ${borderClass}">
                        <div class="p-3 ${style.iconBg} bg-opacity-10 rounded-4 me-3 d-flex align-items-center justify-content-center">
                            <i class="bi ${style.icon} fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold text-dark">${item.title_name}</h6>
                            <div class="small text-secondary d-flex align-items-center gap-3">
                                <span><i class="bi bi-calendar3 me-1"></i> ${formattedDate}</span>
                                <span><i class="bi bi-geo-alt me-1"></i> ${item.workshop_place}</span>
                            </div>
                        </div>
                        <div class="ms-2">
                            <span class="badge ${style.badge} bg-opacity-10 border rounded-pill px-3 py-2 fw-medium">
                                ${daysText}
                            </span>
                        </div>
                    </div>
                `;
                });

                // Tampilkan HTML ke layar
                container.html(html);
            },
            error: function (xhr, status, error) {
                console.error("Terjadi kesalahan AJAX:", error);
                $("#upcoming-container").html("<div class='text-center text-danger'>Gagal memuat data.</div>");
            }
        });
    }

    function data_monitoring() {
        $('#table-monitoring').DataTable({
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
                "type": "POST",
                "url": base_url + "/data_monitoring",
                "data": {
                    periode: periode,
                },
                'dataSrc': ''
            },
            "columns": [
                {
                    data: null,
                    render: function (data, type, row, meta) {
                        return meta.row + 1; // Auto-numbering
                    }
                },
                { data: 'status', defaultContent: "<span class='badge bg-secondary'>N/A</span>" }, // Status (TIDAK ADA DI QUERY)
                { data: null, defaultContent: "N/A" }, // Class Koordinator (TIDAK ADA DI QUERY)
                { data: "tipe", defaultContent: "-" }, // Training Program -> mapping ke "tipe"
                { data: "title_name", defaultContent: "-" }, // Training Name -> mapping ke "title_name"
                { data: null, defaultContent: "N/A" }, // Batch (TIDAK ADA DI QUERY)
                { data: "training", defaultContent: "-" }, // Materi / Modul -> mapping ke "training" dari trusmi_materi_training
                { data: "department_name", defaultContent: "-" }, // Divisi -> mapping ke department_name (Asumsi)
                { data: "department_name", defaultContent: "-" }, // Departemen -> mapping ke department_name
                { data: "designation", defaultContent: "-" }, // Participant Target -> mapping ke designation/role
                { data: "objective", defaultContent: "-" }, // Objective
                { data: "outline", defaultContent: "-" }, // Outline
                { data: 'metode_training', defaultContent: "N/A" }, // Metode Training (TIDAK ADA DI QUERY)
                { data: "trainer_name", defaultContent: "-" }, // Plan Trainer
                { data: "trainer", defaultContent: "-" }, // Actual Trainer -> mapping hasil join first_name
                { data: 'training_kategori', defaultContent: "N/A" }, // Kategori Trainer (TIDAK ADA DI QUERY)
                { data: "workshop_place", defaultContent: "-" }, // Tempat
                {
                    data: "workshop_at",
                    render: function (data) {
                        if (!data) return "-";
                        let date = new Date(data);
                        return date.toLocaleString('default', { month: 'long' }); // Ambil nama bulan
                    }
                }, // Month
                { data: null, defaultContent: "N/A" }, // Week (TIDAK ADA DI QUERY)
                {
                    data: "workshop_at",
                    render: function (data) {
                        if (!data) return "-";
                        return data.split(' ')[0]; // Ambil tanggalnya saja
                    }
                }, // Plan Start
                { data: 'workshop_end', defaultContent: "N/A" }, // Plan End (TIDAK ADA DI QUERY)
                { data: 'actual_workshop_at', defaultContent: "N/A" }, // Actual (TIDAK ADA DI QUERY)
                { data: "workshop_time", defaultContent: "-" }, // Jam Mulai
                { data: null, defaultContent: "N/A" }, // Jam Selesai Actual (TIDAK ADA DI QUERY)
                { data: "waktu", defaultContent: "-" }, // Learning Hours -> mapping ke "waktu" dari trusmi_materi_training
                // { data: null, defaultContent: "N/A" }, // Skala LH (TIDAK ADA DI QUERY)
                { data: "plan_peserta", defaultContent: "0" }, // Plan Peserta
                { data: "actual_peserta", defaultContent: "0" }, // Actual Peserta
                { data: null, defaultContent: "N/A" }, // Keterangan (TIDAK ADA DI QUERY)
                {
                    data: "documentation",
                    render: function (data, type, row) {
                        if (data && !data.endsWith('/')) { // Cek jika ada isinya selain URL base
                            return `<a href="${data}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-image"></i> Lihat</a>`;
                        }
                        return "-";
                    }
                }, // Foto Aktivitas
                {
                    data: "avg_pretest",
                    render: function (data) { return `<span class="badge bg-info text-dark">${data}</span>`; }
                }, // Avg Pre Learning
                {
                    data: "avg_posttest",
                    render: function (data) { return `<span class="badge bg-success">${data}</span>`; }
                }, // Avg Post Learning
                { data: "avg_rating_trusmi", defaultContent: "0" }, // Avg Feedback Trusmi
                { data: "avg_rating_workshop", defaultContent: "0" } // Avg Feedback Workshop
            ]
        });

    }





    function data_timeline() {
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
                "url": base_url + "/data_timeline",
                "data": {
                    periode: periode,
                },
                'dataSrc': ''
            },
            columns: [


            ]
        });
    }





    function append_with_animate(div, html) {
        if (html === '') {
            html = `<li class="mb-2"><i class="bi bi-info-circle text-muted me-2"></i><span class="text-muted fst-italic">Tidak ada data.</span></li>`;
        }
        $(div).fadeOut(300, function () {
            $(this)
                .empty()
                .append(html)
                .slideDown(500);
        });
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