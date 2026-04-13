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
    var base_url = '<?= base_url('agentic/'); ?>';
    var periode = '<?= date('Y-m') ?>';
    var project = 42;
    $('#periode-list .dropdown-item').on('click', function () {
        var clickedItem = $(this);

        var selectedValue = clickedItem.val();   // Contoh: "2025-09"
        $('#periode-list .dropdown-item').removeClass('active');
        clickedItem.addClass('active');
        periode = selectedValue;
        $('#periodeBtn').text(selectedValue);
        load_all();
    });
    $('#project').change(function (e) { 
        e.preventDefault();
        var select_project = $(this).val();
        project = select_project;
        load_all();
    });
    $(document).ready(function () {
        $('body').addClass('menu-close');
        $('#periodeBtn').text(periode);
        load_all();
        initPic = new SlimSelect({
            select: "#pic",
        });
        initProject = new SlimSelect({
            select: "#project",
        });
    });
    function load_all() {
        header();
        data_kpi();
        data_kesehatan_kpi();
        data_4_analisa();
        data_analisa_sistem();
        data_governance_leadership();
        data_rule();
        data_reward();
        data_teknologi();
        data_timeline();
        data_summary();
    }
    $('#action').change(function (e) {
        e.preventDefault();
        var selectedAction = $(this).val();
        var takeRow = $('#row_take');
        var requiredFields = takeRow.find('input, select');
        if (selectedAction === '1') {
            takeRow.slideDown();
            requiredFields.prop('required', true);
        } else {
            takeRow.slideUp();
            requiredFields.prop('required', false);
        }

    });
    function update_kpi() {
        swal({
            title: "Harap Tunggu...",
            text: "Sedang memproses data.",
            icon: "info", // Anda bisa menggunakan ikon lain atau URL gambar
            buttons: false, // Menghilangkan semua tombol
            closeOnClickOutside: false, // Mencegah ditutup saat klik di luar
            closeOnEsc: false, // Mencegah ditutup dengan tombol Esc
        });
        $.ajax({
            type: "POST",
            url: base_url + "/cron_kpi_leadtime_housing",
            data:{
                periode:periode,
                project:project
            },
            dataType: "json",
            success: function (response) {
                swal.close();
                setTimeout(function () {
                    load_all();
                }, 500);
            }
        });
    }
    let loadingHTML = `
    <div class="d-flex justify-content-center align-items-center my-3 " style="font-size: 1.2rem;">
        <i class="bi bi-stars loading-icon-pulse text-warning"></i>
        <span class="text-muted small" style="margin-left: 5px;">Loading ...</span>
    </div>`;

    let kpi_chart = [];

    function header(){
        $.ajax({
            type: "post",
            url: base_url + '/header',
            data: {
                project:project
            },
            dataType: "json",
            success: function (response) {
                $('#label_project').text(response.project);
                $('#label_pic').text(response.pm_housing);
            }
        });
    }

    function data_kpi() {
        const div = $('#kpi');
        $(div).html(loadingHTML);
        $.ajax({
            type: "post",
            url: base_url + '/data_kpi',
            data: {
                periode: periode,
                project:project
            },
            dataType: "json",
            success: function (response) {
                kpi_chart.forEach(chart => {
                    chart.destroy();
                });
                kpi_chart = [];
                div.empty();
                let htmlContent = `<div class="row">`;
                if (response.length == 0) {
                    htmlContent = `<li class="mb-2"><i class="bi bi-info-circle text-muted me-2"></i><span class="text-muted fst-italic">Tidak ada data.</span></li>`;
                    div.append(htmlContent);
                    return;
                }

                response.forEach((item, index) => {
                    const canvasId = `kpiChart_${index}`;
                    htmlContent += `
                    <div class="col">
                            <h5>Corporate KPI</h5>
                            <p class="mb-2 text-muted">${item.corporate_kpi_name}</p>
                            <div class="d-flex justify-content-center mt-2">
                                <div class="text-center me-4">
                                    <i class="bi bi-stopwatch text-primary"></i> Leadtime
                                    <h4>> ${item.target_corporate}%</h4>
                                </div>
                                <div class="text-center">
                                    <i class="bi bi-activity text-danger"></i> Actual
                                    <h4>${item.actual_corporate}%</h4>
                                </div>
                            </div>
                        </div>

                <div class="col mb-3">
                    <div class="card border-1 broder-dark bg-none rounded-3 shadow-none">
                        <div class="card-body rounded-3">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-primary">${item.project_name}</h6>
                                    <p class="mb-2 text-muted">${item.note}</p>
                                </div>
                                <div class="col-auto">
                                    <div id="div_${canvasId}" style="width: 100px; height: 100px;">
                                        <canvas id="${canvasId}" width="100" height="100"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `;
                });

                htmlContent += `</div>`;
                div.append(htmlContent);

                response.forEach((item, index) => {
                    const canvasId = `kpiChart_${index}`;
                    // PENTING: Tangkap instance chart yang dikembalikan oleh fungsi
                    const chartInstance = generate_kpi_chart(canvasId, item);
                    // Simpan instance ke dalam array tracker
                    if (chartInstance) {
                        kpi_chart.push(chartInstance);
                    }
                });
            }
        });
    }
    function data_kesehatan_kpi() {
        var div = $('#kesehatan_kpi');
        $(div).html(loadingHTML);
        $.ajax({
            type: "post",
            url: base_url + '/data_kesehatan_kpi',
            data: {
                periode: periode,
                project:project
            },
            dataType: "json",
            success: function (response) {
                let html = ``;
                response.forEach(value => {
                    html += `<div class="row justify-content-between align-items-center">
                                    <div class="col">
                                        <p>${value.indicator_name}</p>
                                    </div>
                                    <div class="col-auto">
                                        <p>${value.actual_value + value.unit}</p>
                                    </div>
                                </div>
                                <div class="progress mb-3" style="height: 10px;">
                                    <div class="progress-bar bg-${bg_status(value.status)}" role="progressbar" style="width: ${value.actual_value}%;"
                                        aria-valuenow="${value.actual_value}" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-secondary" role="progressbar" style="width: 0%;"
                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>`;
                });
                append_with_animate(div, html)

            }
        });
    }
    function data_analisa_sistem() {
        var div = $('#analisa_sistem');
        $(div).html(loadingHTML);
        $.ajax({
            type: "post",
            url: base_url + '/data_analisa_sistem',
            data: {
                periode: periode,
                project:project
            },
            dataType: "json",
            success: function (response) {
                let html = ``;
                response.forEach(value => {
                    html += `<li class="mb-2">
                                            <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                                            <span class="text-dark">${value.issue_text}</span>
                                            <span class="badge ${bg_badge(value.severity)}">${value.severity.toUpperCase()}</span>
                                        </li>`;
                });
                append_with_animate(div, html)
            }
        });
    }
    function data_governance_leadership() {
        var div = $('#governance');
        $(div).html(loadingHTML);
        $.ajax({
            type: "post",
            url: base_url + '/data_governance_leadership',
            data: {
                periode: periode,
                project:project
            },
            dataType: "json",
            success: function (response) {
                let html = ``;
                response.forEach(value => {
                    html += `<div class=" card border-1 broder-dark bg-none rounded-3 shadow-none mb-2">
                                <div class="card-body rounded-3">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col">
                                            <p class="fw-bold d-inline me-2">${value.check_item}</p><span class="badge ${bg_badge(value.priority)}">${value.priority.toUpperCase()}</span>
                                        </div>
                                        <div class="col-auto">
                                            <p class="small">${value.status_desc}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                });
                append_with_animate(div, html)
            }
        });
    }
    function data_4_analisa() {
        const divTargets = [
            $('#4_machine'), // index 0
            $('#4_money'),   // index 1
            $('#4_man'),     // index 2
            $('#4_material') // index 3
        ];
        divTargets.forEach(div => div.html(loadingHTML));
        $.ajax({
            type: "post",
            url: base_url + '/data_4_analisa',
            data: {
                periode: periode,
                project:project
            },
            dataType: "json",
            success: function (response) {
                let htmlOutputs = ['', '', '', ''];

                response.forEach(value => {
                    const listItem = `<li class="mb-2">
                                      <i class="bi bi-circle text-muted me-2"></i>
                                      <span class="text-dark">${value.action_text}</span>
                                  </li>`;
                    if (value.category === 'Machine') {
                        htmlOutputs[0] += listItem;
                    } else if (value.category === 'Money') {
                        htmlOutputs[1] += listItem;
                    } else if (value.category === 'Man') {
                        htmlOutputs[2] += listItem;
                    } else if (value.category === 'Material') {
                        htmlOutputs[3] += listItem;
                    }
                });

                // PERUBAHAN 3: Panggil animasi menggunakan loop pada array divTargets
                divTargets.forEach((div, index) => {
                    append_with_animate(div, htmlOutputs[index]);
                });
            }
        });
    }
    function data_timeline() {
        $('#data_timeline').DataTable({
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
                    project:project,
                },
                'dataSrc': ''
            },
            columns: [
                {
                    data: 'description',
                    render: function (data, type, row) {
                        return `<strong>${data}</strong>`;
                    }
                },
                {
                    data: 'status_plan',
                    render: function (data, type, row) {
                        var click = "";
                        if (data == 'Waiting') {
                            click = `onclick="modal_take('${row.id}','${row.description}')" style='cursor:pointer'`;
                        }
                        return `<span class="badge ${status_plan(data)}" ${click}>${data}</span>`;
                    }
                },
                {
                    data: null, // Menggunakan render function untuk menggabungkan owner dan dueDate
                    render: function (data, type, row) {
                        return `
                            ${row.owner}
                            <div class="small text-muted">${row.due_date}</div>
                        `;
                    }
                },
                {
                    data:'pic'
                },

                {
                    data: 'status_actual',
                    render: function (data, type, row) {
                        var id_user = '<?= $this->session->userdata('user_id') ?>';
                        if (data == null) {
                            return `-`;
                        } else {
                            return ` <a href="<?= base_url('/'); ?>/ibr_update?id=${row['id_sub_task']}&u=${id_user}" target="_blank"><span class="badge bg-${row.status_color}" >${data}</span></a>`;
                        }

                    }
                },
                {
                    data: 'notes',
                    render: function (data, type, row) {
                        var tambahan = ""
                        if (row.tambahan_info != null) {
                            tambahan = row.tambahan_info
                        }
                        return data + ' <br><small class="text-muted">' + tambahan + '</small>'
                    }
                }
            ]
        });
    }
    function data_rule() {
        var div = $('#rule');
        $(div).html(loadingHTML);
        $.ajax({
            type: "post",
            url: base_url + '/data_rule',
            data: {
                periode: periode,
                project:project
            },
            dataType: "json",
            success: function (response) {
                let html = ``;
                response.forEach(value => {
                    html += `<li class="mb-2">
                                            <i class="bi bi-arrow-right-circle text-info me-2"></i>
                                            <span class="text-dark">${value.rule_text}</span>
                                        </li>`;
                });
                append_with_animate(div, html)
            }
        });
    }
    function data_reward() {
        var div = $('#reward');
        $(div).html(loadingHTML);
        $.ajax({
            type: "post",
            url: base_url + '/data_reward',
            data: {
                periode: periode,
                project:project
            },
            dataType: "json",
            success: function (response) {
                let html = ``;
                response.forEach(value => {
                    html += `<li class="mb-2">
                                            <i class="bi bi-arrow-right-circle text-warning me-2"></i>
                                            <span class="text-dark me-2">${value.reward_text}</span><span class="badge bg-secondary">${value.status}</span>
                                        </li>`;
                });
                append_with_animate(div, html)
            }
        });
    }
    function data_teknologi() {
        var div = $('#teknologi');
        $(div).html(loadingHTML);
        $.ajax({
            type: "post",
            url: base_url + '/data_teknologi',
            data: {
                periode: periode,
                project:project
            },
            dataType: "json",
            success: function (response) {
                let html = ``;
                response.forEach(value => {
                    html += `<li class="mb-2">
                                <i class="bi bi-arrow-right-circle text-danger me-2"></i>
                                <span class="text-dark me-2">${value.description}</span>
                            </li>`;
                });
                append_with_animate(div, html)
            }
        });
    }
    function data_summary() {
        var div = $('#teknologi');
        $(div).html(loadingHTML);
        const divTargets = [
            $('#summary_kpi'), // index 0
            $('#summary_risk'),   // index 1
            $('#summary_focus'),     // index 2
        ];
        divTargets.forEach(div => div.html(loadingHTML));
        $.ajax({
            type: "post",
            url: base_url + '/data_summary',
            data: {
                periode: periode,
                project:project
            },
            dataType: "json",
            success: function (response) {
                let html_1 = ``;
                response.kpi.forEach(value => {
                    html_1 += `<div class="card border-1 broder-dark bg-none rounded-3 shadow-none">
                                    <div class="card-body rounded-3">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col">
                                                <p>${value.status_kpi}</p>
                                            </div>
                                            <div class="col-auto">
                                                <p>${value.status_value}%</p>
                                            </div>
                                        </div>
                                        <div class="progress mb-3" style="height: 10px;">
                                            <div class="progress-bar bg-secondary" role="progressbar" style="width: ${value.status_value}%;"
                                                aria-valuenow="${value.status_value}" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-secondary" role="progressbar" style="width: 0%;"
                                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small>${value.status_note}</small>
                                    </div>
                                </div>`;
                });
                append_with_animate(divTargets[0], html_1)
                let html_2 = ``;
                response.risk.forEach(value => {
                    html_2 += `<li class="mb-2">
                                            <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                                            <span class="text-dark">${value.risk_description}</span>
                                        </li>`;
                });
                append_with_animate(divTargets[1], html_2)
                let html_3 = ``;
                response.focus.forEach(value => {
                    html_3 += `<li class="mb-2">
                                            <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                                            <span class="text-dark">${value.focus_description}</span>
                                        </li>`;
                });
                append_with_animate(divTargets[2], html_3)
            }
        });
    }

    function modal_take(id, rencana) {
        $('#id_task').val(id);
        $('.deskripsi').val(rencana);
        $('#modal_take_tasklist').modal('show');
    }
    $('#form_take').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        swal({
            title: "Confirm!",
            text: "Anda Yakin dengan perubahan ini?",
            icon: "info",
            buttons: true,
            dangerMode: false,
        })
            .then((simpan) => {
                if (simpan) {
                    $.ajax({
                        'url': base_url + "/save_task",
                        'type': "POST",
                        'data': form.serialize(),
                        'dataType': "JSON",
                        'success': function (response) {
                            swal('Success!', 'Data Berhasil di input!', 'success');
                            $('#modal_take_tasklist').modal('hide');
                            $('#data_timeline').DataTable().ajax.reload();

                        }
                    })
                }
            });
    });


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
    function generate_kpi_chart(canvasId, data) {
        const ctx = document.getElementById(canvasId);
        if (!ctx) return; // Hentikan jika canvas tidak ditemukan

        const remainingTarget = 100 - data.actual_value;
        const doughnutPointer = {
            id: 'doughnutPointer_' + canvasId, // Beri ID unik untuk plugin juga
            afterDatasetsDraw(chart, args, plugins) {
                const { ctx } = chart;
                ctx.save();

                const xCenter = chart.getDatasetMeta(0).data[0].x;
                const yCenter = chart.getDatasetMeta(0).data[0].y;

                // Teks di tengah chart, diambil dari data
                const lines = [{
                    text: `${data.actual_value}%`,
                    font: 'bold 20px sans-serif',
                    yOffset: -10,
                    color: '#000000'
                }, {
                    text: data.status,
                    font: '13px sans-serif',
                    yOffset: 10,
                    color: warna_kpi(data.status) // Warna dinamis
                }];

                lines.forEach(line => {
                    ctx.font = line.font;
                    ctx.fillStyle = line.color;
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText(line.text, xCenter, yCenter + line.yOffset);
                });
            }
        };

        const newChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Actual', 'Target'],
                datasets: [{
                    data: [data.actual_value, remainingTarget],
                    backgroundColor: ['#91C300', '#6C757D'],
                    borderRadius: 7,
                    borderWidth: 0,
                }]
            },
            options: {
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                return `${label}: ${value}%`;
                            }
                        }
                    }
                },
                cutout: '86%'
            },
            plugins: [doughnutPointer] // Gunakan plugin yang baru dibuat
        });
        return newChart;
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