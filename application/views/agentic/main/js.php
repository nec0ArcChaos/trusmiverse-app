<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
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
    var base_url = '<?= base_url('agentic/main'); ?>';
    var periode = '<?= date('Y-m') ?>';
    var tipe_agentic = '<?= $tipe_agentic ?>';
    var id = '';
    var initId;
    var week = <?= isset($week) && $week !== '' ? json_encode($week) : 'null' ?>;
    var p_status = <?= isset($status_plan) && $status_plan !== '' ? json_encode($status_plan) : 'null' ?>;

    loadWeek();


    const PROJECT_TYPES = [
        'plan_infra',
        'plan_housing',
        'project_infra',
        'crm',
        'purchasing',
        'aftersales',
        'qc',
        'perencana'
    ];

    const SALES_TYPES = [
        'booking',
        'sp3k',
        'akad',
        'drbm',
        'pemberkasan',
        'proses_bank'
    ];

    const PM_HOUSING_TYPES = [
        'project_housing',
        'project_housing_komersil',
    ];

    if (PROJECT_TYPES.includes(tipe_agentic)) {
        id = 42;
        if (tipe_agentic == 'qc' || tipe_agentic == 'aftersales') {
            $('#id').val('all').trigger('change');
            id = '0';
        }
        if (tipe_agentic == 'crm') load_id();
    } else if (SALES_TYPES.includes(tipe_agentic)) {
        id = 18;
    } else if (PM_HOUSING_TYPES.includes(tipe_agentic)) {
        id = 515;
        if (tipe_agentic == 'project_housing') {
            $('#project_tipe').change(function (e) {
                e.preventDefault();
                var project_tipe = $(this).val();
                if (project_tipe == 'subsidi') {
                    tipe_agentic = 'project_housing';
                } else if (project_tipe == 'komersil') {
                    tipe_agentic = 'project_housing_komersil';
                }
                load_all();
            });
        }
    }
    $('#periode-list .dropdown-item').on('click', function () {
        var clickedItem = $(this);

        var selectedValue = clickedItem.val(); // Contoh: "2025-09"
        $('#periode-list .dropdown-item').removeClass('active');
        clickedItem.addClass('active');
        periode = selectedValue;
        console.log(tipe_agentic);
        if (tipe_agentic == 'crm') load_id();
        $('#periodeBtn').text(selectedValue);
        load_all();
    });

    // 27-1-26 filter week
    function loadWeek() {

        $.ajax({
            url: base_url + '/data_week',
            type: 'GET',
            dataType: 'json',
            data: { periode },
            success: function (res) {

                let html = '';

                // ALL WEEK
                html += `
                    <li>
                        <button type="button"
                            class="dropdown-item active"
                            data-week="">
                            All Week
                        </button>
                    </li>`;

                if (res && res.weeks && res.weeks.length > 0) {

                    res.weeks.forEach(w => {
                        html += `
                            <li>
                                <button type="button"
                                    class="dropdown-item"
                                    data-week="${w.wk}">
                                    ${w.label}
                                </button>
                            </li>`;
                    });

                } else {
                    html += `<li><span class="dropdown-item text-muted">Tidak ada data</span></li>`;
                }

                $('#weekText').text('All Week');
                $('#week-list').html(html);
            }
        });
    }

    $(document).on('click', '#week-list .dropdown-item', function () {

        $('#week-list .dropdown-item').removeClass('active');
        $(this).addClass('active');

        let selectedWeek = $(this).data('week');

        if (selectedWeek === '' || selectedWeek === null) {
            week = null;
            $('#weekText').text('All Week');
            data_timeline(periode, 'all');   // ✅ PENTING
        } else {
            week = selectedWeek;
            $('#weekText').text($(this).text());
            data_timeline(periode, 'week');  // ✅ PENTING
        }

    });

    $(document).on('click', '#p_status-list .dropdown-item', function () {

        $('#p_status-list .dropdown-item').removeClass('active');
        $(this).addClass('active');

        let selectedStatus = $(this).data('status');

        if (selectedStatus === '' || selectedStatus === null) {
            p_status = null;
            $('#p_statusBtn').text('All Status');
            data_timeline(periode, 'all');        // ✅
        } else {
            p_status = selectedStatus;
            $('#p_statusBtn').text($(this).text());
            data_timeline(periode, 'p_status');   // ✅
        }

    });


    $('#id').change(function (e) {
        e.preventDefault();
        var select_id = $(this).val();
        id = select_id;
        load_all();
    });
    $('#tipe_agentic').change(function (e) {
        e.preventDefault();
        var select_tipe_agentic = $(this).val();
        tipe_agentic = select_tipe_agentic;
        window.location.href = `https://trusmiverse.com/apps/agentic/${tipe_agentic}`
    });

    function load_id() {
        $.ajax({
            type: "post",
            url: base_url + '/load_id',
            data: {
                tipe_agentic: tipe_agentic,
                periode: periode
            },
            dataType: "json",
            success: function (response) {
                // $('#id').empty();
                if (response.length > 0) {
                    id = (response.some(item => item.id_project == id) ? id : response[0].id_project);
                    data = []
                    response.forEach(item => {
                        // $('#id').append(`<option value="${item.id_project}" ${ (item.id_project == id) ? 'selected' : '' }>${ item.project }</option>`)
                        data.push({
                            text: item.project,
                            value: item.id_project,
                            selected: (item.id_project == id ? true : false)
                        });
                    })
                    if (initId) {
                        console.log(id);
                        initId.setData(data);
                        // initId.setSelected(`${id}`);
                    }
                } else {
                    id = 0;
                    if (initId) {
                        console.log(id);
                        initId.setData([{
                            text: "Tidak ada project dengan complaint pada periode ini",
                            value: 0,
                            selected: true
                        }]);
                        // initId.setSelected(`${id}`);
                    }
                }
            }
        });
    }
    const initEmp = [];
    $(document).ready(function () {
        $('body').addClass('menu-close');
        $('#periodeBtn').text(periode);
        load_all();
        initPic = new SlimSelect({
            select: "#pic",
        });
        initPicAdd = new SlimSelect({
            select: "#pic_add",
        });
        initId = new SlimSelect({
            select: "#id",
        });
        initTipeAgentic = new SlimSelect({
            select: "#tipe_agentic",
        });
        
        const allEmployeeSelects = document.querySelectorAll('.employee');
        allEmployeeSelects.forEach((selectElement) => {
            const slim = new SlimSelect({
                select: selectElement,
                settings: {
                    placeholderText: 'Pilih Karyawan',
                    searchPlaceholder: 'Cari Karyawan...',
                    allowDeselect: true
                }
            });
            initEmp.push(slim);
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

    $('.action_take').on('change', function () {
        var selectedAction = $(this).val();
        var targetRow = $(this).closest('.modal-body').find('.row_take');
        if (selectedAction == '1') {
            targetRow.slideDown();
        } else {
            targetRow.slideUp();
        }
    });

    function update_kpi() {
        const loadingContent = document.createElement('div');
        loadingContent.innerHTML = `
            <div class="d-flex justify-content-center align-items-center my-2">
                <i class="bi bi-stars loading-icon-pulse text-warning" style="font-size: 4.5rem;"></i>
            </div>
            <span class="text-muted mb-2">Sedang memproses data...</span>
            `;
        swal({
            title: "Harap Tunggu...",
            content: loadingContent,
            buttons: false, // Menghilangkan semua tombol
            closeOnClickOutside: false, // Mencegah ditutup saat klik di luar
            closeOnEsc: false, // Mencegah ditutup dengan tombol Esc
        });
        $.ajax({
            type: "POST",
            url: base_url + "/cron_kpi",
            data: {
                periode: periode,
                id: id,
                tipe_agentic: tipe_agentic
            },
            dataType: "json",
            success: function (response) {
                if (response == 'false' || response == false) {
                    setTimeout(function () {
                        if (tipe_agentic == 'project_infra' || tipe_agentic == 'project_housing') {
                            swal('Error!', 'Tidak ada SPK dalam periode ini!', 'error');
                        }

                        if (tipe_agentic == 'proses_bank') {
                            swal('Error!', 'Tidak ada Data dalam periode ini!', 'error');
                        }
                    }, 1000);
                }
                if (response == 'true' || response == true) {
                    swal.close();
                    setTimeout(function () {
                        load_all();
                    }, 1000);
                }

            },
            error: function () {
                swal.close();
                setTimeout(function () {
                    if (tipe_agentic == 'project_infra') {
                        swal('Error!', 'Tidak ada SPK dalam periode ini!', 'error');
                    }
                    load_all();
                }, 1000);
            }
        });
    }
    let loadingHTML = `
    <div class="d-flex justify-content-center align-items-center my-3 " style="font-size: 1.2rem;">
        <i class="bi bi-stars loading-icon-pulse text-warning"></i>
        <span class="text-muted small" style="margin-left: 5px;">Loading ...</span>
    </div>`;

    let kpi_chart = [];

    function header() {
        $.ajax({
            type: "post",
            url: base_url + '/header',
            data: {
                id: id,
                tipe_agentic: tipe_agentic
            },
            dataType: "json",
            success: function (response) {
                $('#label_project').text(response ? response.project || '' : '');
                // $('#label_pic').text(response ? response.id || '' : '');
                $('#label_pic').text(response.name);
            }
        });
    }

    function data_kpi() {
        const div = $('#kpi');
        $(div).html(loadingHTML);
        $('#last_updated').text('');
        $.ajax({
            type: "post",
            url: base_url + '/data_kpi',
            data: {
                periode: periode,
                id: id,
                tipe_agentic: tipe_agentic
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
                    $('#kpi_id').val('');
                    $('#btn_add_task').hide();
                    return;
                }
                $('#btn_add_task').show();
                $('#kpi_id').val(response[0].id);
                $('#last_updated').text(`Last Updated: ${response[0].updated_at || response[0].created_at}`);
                response.forEach((item, index) => {
                    const canvasId = `kpiChart_${index}`;
                    htmlContent += `
                    <div class="col">
                            <h5>Corporate KPI</h5>
                            <p class="mb-2 text-muted">${item.corporate_kpi_name}</p>
                            <div class="d-flex justify-content-center mt-2">
                                <div class="text-center me-4">
                                    <i class="bi bi-stopwatch text-primary"></i> Target
                                    <h4>${item.target_corporate}${item.unit_corporate}</h4>
                                </div>
                                <div class="text-center">
                                    <i class="bi bi-activity text-danger"></i> Actual
                                    <h4>${item.actual_corporate}${item.unit_corporate}</h4>
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
                id: id,
                tipe_agentic: tipe_agentic
            },
            dataType: "json",
            success: function (response) {
                let html = ``;
                response.forEach(value => {
                    console.log(value.note !== null || value.note !== '');

                    var detail = ``;
                    if (value.note !== null || value.note !== '') {
                        detail = `<span class="text-muted ms-2">${value.note}</span>`;
                    }
                    html += `<div class="row justify-content-between align-items-center">
                                    <div class="col">
                                        <p>${value.indicator_name} ${detail}</p>
                                    </div>
                                    <div class="col-auto">
                                        <p>${Math.round(value.actual_value)}%</p>
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

    function toggleKpiDetail() {
        let poin = $('#poin_kpi_add').val().trim();

        if (poin !== '') {
            $('#kpi_detail_wrapper').slideDown();
            $('#kpi_detail_wrapper textarea').attr('required', true);
        } else {
            $('#kpi_detail_wrapper').slideUp();
            $('#kpi_detail_wrapper textarea')
                .removeAttr('required')
                .val('');
        }
    }

    // default on load
    toggleKpiDetail();

    // ketika diketik
    $('#poin_kpi_add').on('keyup change', function () {
        toggleKpiDetail();
    });
    

    function data_analisa_sistem() {
        var div = $('#analisa_sistem');
        $(div).html(loadingHTML);
        $.ajax({
            type: "post",
            url: base_url + '/data_analisa_sistem',
            data: {
                periode: periode,
                id: id,
                tipe_agentic: tipe_agentic
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
                id: id,
                tipe_agentic: tipe_agentic
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
            $('#4_money'), // index 1
            $('#4_man'), // index 2
            $('#4_material') // index 3
        ];
        divTargets.forEach(div => div.html(loadingHTML));
        $.ajax({
            type: "post",
            url: base_url + '/data_4_analisa',
            data: {
                periode: periode,
                id: id,
                tipe_agentic: tipe_agentic
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
                    id: id,
                    tipe_agentic: tipe_agentic,
                    week: week,
                    p_status: p_status
                },
                'dataSrc': ''
            },
            columns: [
            {
                data: 'by',
                render: function (data, type, row) {
                    if (data == null || data == '') {
                        return `<span class="badge bg-info">AI</span>`;
                    } else {
                        return `<span class="badge bg-success">Head</span>`;
                    }
                    
                }
            },
            {
                data: 'rm',
            },
            {
                data: 'reason',
                render: function (data, type, row) {
                    return `<strong>${data}</strong>`;
                }
            },
            {
                data: 'description',
                render: function (data, type, row) {
                    return `<strong>${data}</strong>`;
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
                data: 'created_at', // Menggunakan render function untuk menggabungkan owner dan dueDate
            },
            {
                data: 'wk',
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
                data: 'pic'
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
                id: id,
                tipe_agentic: tipe_agentic
            },
            dataType: "json",
            success: function (response) {
                let html = ``;
                response.forEach(value => {
                    var click = "";
                    badge = 'bg-primary';
                    if (value.status_plan == 'Waiting' && value.rules == 'denda') {
                        badge = 'bg-light-blue text-primary';
                        click = `onclick="modal_take_denda_reward('${value.id}','${value.rule_text}','Denda')" style='cursor:pointer'`;
                    }
                    if (value.status_plan == 'Waiting' && value.rules == 'lock_absen') {
                        badge = 'bg-light-red text-danger';
                        click = `onclick="modal_take_lock('${value.id}','${value.rule_text}','Lock Absen')" style='cursor:pointer'`;
                    }
                    if (value.status_plan == 'Waiting' && value.rules == 'surat_teguran') {
                        badge = 'bg-light-yellow text-warning';
                        click = `onclick="modal_take_warning('${value.id}','${value.rule_text}','Warning Letter')" style='cursor:pointer'`;
                    }
                    html += `<li class="mb-2">
                                            <span class="badge ${badge}">${value.kategori}</span>
                                            <span class="text-dark">${value.rule_text} </span> <span class="badge ${status_plan(value.status_plan)}" ${click}>${value.status_plan}</span>
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
                id: id,
                tipe_agentic: tipe_agentic
            },
            dataType: "json",
            success: function (response) {
                let html = ``;
                response.forEach(value => {
                    var click = "";
                    if (value.status_plan == 'Waiting') {
                        click = `onclick="modal_take_denda_reward('${value.id}','${value.reward_text}','Reward')" style='cursor:pointer'`;
                    }
                    html += `<li class="mb-2">
                                            <i class="bi bi-arrow-right-circle text-warning me-2"></i>
                                            <span class="text-dark me-2">${value.reward_text}</span> <span class="badge ${status_plan(value.status_plan)}" ${click}>${value.status_plan}</span>
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
                id: id,
                tipe_agentic: tipe_agentic
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
            $('#summary_risk'), // index 1
            $('#summary_focus'), // index 2
        ];
        divTargets.forEach(div => div.html(loadingHTML));
        $.ajax({
            type: "post",
            url: base_url + '/data_summary',
            data: {
                periode: periode,
                id: id,
                tipe_agentic: tipe_agentic
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
        reset_take();
        $('#modal_take_tasklist').modal('show');
    }

    function add_task_head() {
        var kpi_id = $('#kpi_id').val(); 
        $('#kpi_id_add').val(kpi_id);
        $('#form_add_task')[0].reset();
        $('#modal_take_tasklist_add').modal('show');
    }

    function modal_take_denda_reward(id, deskripsi, tipe) {
        $('.id_db').val(id);
        reset_take();
        $('.deskripsi').val(deskripsi);
        $('.tipe_consequence').val(tipe);
        $('.deskripsi').val(deskripsi);
        $('#modal_take_denda_reward').modal('show');
    }

    function modal_take_warning(id, deskripsi, tipe) {
        reset_take();
        $('.id_db').val(id);
        $('.deskripsi').val(deskripsi);
        $('#modal_take_warning').modal('show');
    }

    function modal_take_lock(id, deskripsi, tipe) {
        reset_take();
        $('.id_db').val(id);
        $('.deskripsi').val(deskripsi);
        $('#modal_take_lock').modal('show');
    }

    function reset_take() {
        $('.action_take').val('');
        $('.row_take').hide();
        // allEmployeeSelects.forEach((select) => {
        //     // Use .set('') for single-select dropdowns
        //     // select.set('');

        //     // If you were using multi-select, you would use an empty array instead:
        //     select.set([]); 
        // });
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
    $('#form_add_task').submit(function (e) {
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
                        'url': base_url + "/save_add_task",
                        'type': "POST",
                        'data': form.serialize(),
                        'dataType': "JSON",
                        'success': function (response) {
                            swal('Success!', 'Data Berhasil di input!', 'success');
                            $('#modal_take_tasklist_add').modal('hide');
                            $('#data_timeline').DataTable().ajax.reload();

                        }
                    })
                }
            });
    });
    $('#form_take_denda_reward').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        validation_take(form);

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
                        'url': base_url + "/save_denda_reward",
                        'type': "POST",
                        'data': form.serialize(),
                        'dataType': "JSON",
                        'success': function (response) {
                            swal('Success!', 'Data Berhasil di input!', 'success');
                            $('#modal_take_denda_reward').modal('hide');
                            data_rule();
                            data_reward();
                        }
                    })
                }
            });
    });
    $('#form_take_warning').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        validation_take(form);

        swal({
            title: "Confirm!",
            text: "Anda Yakin dengan perubahan ini?",
            icon: "info",
            buttons: true,
            dangerMode: false,
        })
            .then((simpan) => {
                if (simpan) {
                    var selectedOption = form.find('select[name="employee"] option:selected').first();
                    var companyId = selectedOption.attr('data-company_id');
                    var postData = form.serialize() + '&company_id=' + companyId;
                    $.ajax({
                        'url': base_url + "/save_warning",
                        'type': "POST",
                        'data': postData,
                        'dataType': "JSON",
                        'success': function (response) {
                            swal('Success!', 'Data Berhasil di input!', 'success');
                            $('#modal_take_warning').modal('hide');
                            data_rule();

                        }
                    })
                }
            });
    });
    $('#form_take_lock').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        validation_take(form);

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
                        'url': base_url + "/save_lock",
                        'type': "POST",
                        'data': form.serialize(),
                        'dataType': "JSON",
                        'success': function (response) {
                            swal('Success!', 'Data Berhasil di input!', 'success');
                            $('#modal_take_lock').modal('hide');
                            data_rule();

                        }
                    })
                }
            });
    });


    function validation_take(form) {
        var actionValue = form.find('select[name="action"]').val();
        var standardFields = form.find('.row_take input, .row_take select:not(.employee), .row_take textarea');
        var slimSelectField = form.find('select.employee');
        standardFields.prop('required', false);
        // slimSelectField.next('.ss-main').css('border', '');


        // Jika action yang dipilih adalah '1' (Take)
        if (actionValue == '1') {
            standardFields.prop('required', true);
            if (form[0].checkValidity() === false) {
                form[0].reportValidity();
                return; // Hentikan jika input standar tidak valid
            }

            // 2. Validasi manual khusus untuk Slim Select
            var slimSelectValue = slimSelectField.val();
            if (!slimSelectValue || slimSelectValue.length === 0) {
                // Jika Slim Select kosong, tampilkan pesan error
                swal('Input Tidak Lengkap!', 'Kolom "Employee" wajib diisi.', 'warning');
                // slimSelectField.next('.ss-main').css('border', '1px solid red');
                return; // Hentikan eksekusi
            }
        }
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

    function generate_kpi_chart(canvasId, data) {
        const ctx = document.getElementById(canvasId);
        if (!ctx) return; // Hentikan jika canvas tidak ditemukan

        const remainingTarget = 100 - data.actual_value;
        const doughnutPointer = {
            id: 'doughnutPointer_' + canvasId, // Beri ID unik untuk plugin juga
            afterDatasetsDraw(chart, args, plugins) {
                const {
                    ctx
                } = chart;
                ctx.save();

                const xCenter = chart.getDatasetMeta(0).data[0].x;
                const yCenter = chart.getDatasetMeta(0).data[0].y;

                // Teks di tengah chart, diambil dari data
                const lines = [{
                    text: `${data.actual_value}%`,
                    font: 'bold 20px sans-serif',
                    yOffset: 0,
                    color: '#000000'
                },
                    // {
                    //     text: data.status,
                    //     font: '13px sans-serif',
                    //     yOffset: 10,
                    //     color: warna_kpi(data.status) // Warna dinamis
                    // }
                ];

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
                    backgroundColor: [warna_kpi(data.status), '#6C757D'],
                    borderRadius: 7,
                    borderWidth: 0,
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
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


<!-- 3-2-26 -->
<script>

    $(document).ready(function () {
        $('#kategori').on('change', function () {
            if ($(this).val() === '2') {
                $('#wrapper_rule_consequence').removeClass('d-none');
            } else {
                $('#wrapper_rule_consequence').addClass('d-none');
                $('#tipe_rule_consequence').val('');
            }
        });
    });

    // $('#kategori').on('change', function () {
    //     if ($(this).val() === '2') {
    //         $('#tipe_rule_consequence').attr('required', true);
    //     } else {
    //         $('#tipe_rule_consequence').removeAttr('required').val('');
    //     }
    // });

</script>
