<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>


<script>
    const baseurl = `<?= base_url('trusmi_resignation'); ?>`
    const roleUser = <?= json_encode($this->session->userdata('user_role_id')) ?>;
    const companyId = <?= json_encode($this->session->userdata('company_id')) ?>;
    $(document).ready(function() {

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
            dt_trusmi_resignation(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        }


        function cb2(start, end) {
            $('.reportrange2 input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start_report"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end_report"]').val(end.format('YYYY-MM-DD'));
            dt_report_detail(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        }

        $('.range').daterangepicker({
            startDate: start,
            endDate: end,
            "drops": "down",
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        $('.range2').daterangepicker({
            startDate: start,
            endDate: end,
            "drops": "down",
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb2);

        cb(start, end);
        // cb2(start, end);


        check_pengajuan();
        get_profil_user();
    });

    let selectReason = new SlimSelect({
        select: '#reason',
        settings: {
            placeholderText: 'Reason ?',
        }
    });

    let selectReason2 = new SlimSelect({
        select: '#reason_2',
        settings: {
            placeholderText: 'Reason ?',
        }
    });

    let selectDetailReason = new SlimSelect({
        select: '#detail_reason',
        settings: {
            placeholderText: 'Detail Reason ?',
        }
    });

    let selectDetailReason2 = new SlimSelect({
        select: '#detail_reason_2',
        settings: {
            placeholderText: 'Detail Reason ?',
        }
    });

    let selectCompany = new SlimSelect({
        select: '#company_id_2',
        settings: {
            placeholderText: 'Pilih Company',
        }
    });

    let selectDepartment = new SlimSelect({
        select: '#department_id_2',
        settings: {
            placeholderText: 'Pilih Department',
        }
    });

    let selectDesignation = new SlimSelect({
        select: '#designation_id_2',
        settings: {
            placeholderText: 'Pilih Designation',
        }
    });

    let selectEmployee = new SlimSelect({
        select: '#employee_id_2',
        settings: {
            placeholderText: 'Pilih Employee',
        }
    });

    // add by Ade
    let selectCategory = new SlimSelect({
        select: '#category',
        settings: {
            placeholderText: 'Category ?',
        }
    });

    let selectCategory2 = new SlimSelect({
        select: '#category_2',
        settings: {
            placeholderText: 'Category ?',
        }
    });

    function get_my_resignation() {
        window.open(`${baseurl}/detail_resignation?id=${id_resignation}`, '_blank');
    }

    function check_pengajuan() {
        user_id = "<?= $this->session->userdata("user_id"); ?>";
        $.ajax({
            url: `${baseurl}/check_pengajuan`,
            type: 'POST',
            dataType: 'json',
            data: {
                user_id: user_id
            },
            beforeSend: function() {

            },
            success: function(response) {
                let check_pengajuan = response.check_pengajuan == null ? '' : response.check_pengajuan;
                let id_resignation = response.data_pengajuan == null ? '' : response.data_pengajuan.resignation_id;
                console.log(check_pengajuan);
                console.log(id_resignation);
                if (check_pengajuan == true) {
                    $("#btn_my_resignation").show();
                    btn_my_resignation = `<a href="${baseurl}/detail_resignation?id=${id_resignation}" class="btn btn-md btn-outline-warning"><i class="bi bi-eye"></i> My Resignation</a>`;
                    $("#btn_my_resignation").empty();
                    $("#btn_my_resignation").append(btn_my_resignation);
                }
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    function list_waiting_resignation() {

        $('#modal-list-waiting-resignation').modal('show');
        user_id = "<?= $this->session->userdata("user_id"); ?>";
        user_role_id = "<?= $this->session->userdata("user_role_id"); ?>";
        $('#dt_trusmi_list_waiting_resignation').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "responsive": true,
            "dom": 'Bfrtip',
            "order": [
                [1, 'desc']
            ],
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    user_id: user_id
                },
                "url": `${baseurl}/list_waiting_resignation`,
            },
            "columns": [{
                    "data": "notice_date",
                },
                {
                    "data": "resignation_date",
                },
                {
                    "data": "employee_name",
                },
                {
                    "data": "company_name",
                },
                {
                    "data": "department_name",
                },
                {
                    "data": "designation_name",
                },
                {
                    "data": "status_resignation",
                    "render": function(data, type, row, meta) {
                        if (row['id_status_resignation'] == 0) {
                            if (user_role_id == 1 || user_id == 2063 || user_id == 61) {
                                send_wa_again = `<a href="javascript:void(0)"><span class="badge bg-primary" onclick="kirim_ulang('${row['resignation_id']}')";
                            ><i class="bi bi-whatsapp"></i> kirim ulang notif</span></a>`;
                            } else {
                                send_wa_again = '';
                            }
                            pic_approve = row['pic_approve'];
                            arr_pic = pic_approve.split(",");
                            if (arr_pic.includes(user_id)) {
                                detail = `<a href="${baseurl}/verify_resignation?id=${row['resignation_id']}"><span class="badge bg-danger data-resignation"> ${data}</span></a>`;
                            } else {
                                detail = `<a href="${baseurl}/detail_resignation?id=${row['resignation_id']}"><span class="badge bg-danger data-resignation"> ${data}</span></a>`;
                            }
                            return `${detail}${send_wa_again}`;
                        } else {
                            print = '';
                            if (user_role_id == 1 || user_id == 2063 || user_id == 61) {
                                print = `<a href="${baseurl}/print_paklaring/${row['resignation_id']}" target="_blank"><span class="badge bg-success data-resignation";
                            ><i class="bi bi-printer"></i></span></a>`;
                                send_wa_again = `<a href="javascript:void(0)"><span class="badge bg-primary" onclick="kirim_ulang('${row['resignation_id']}')";
                            ><i class="bi bi-whatsapp"></i></span></a>`;
                            }
                            // pic_approve = row['pic_approve'];
                            // arr_pic = pic_approve.split(",");
                            // if (arr_pic.includes(user_id)) {
                            //     detail = `<a href="<?= base_url() ?>trusmi_resignation/verify_resignation?id=${row['resignation_id']}"><span class="badge bg-success data-resignation"> ${data}</span></a>`;
                            // } else {
                            detail = `<a href="${baseurl}/verify_resignation?id=${row['resignation_id']}"><span class="badge bg-success data-resignation"> ${data}</span></a>`;
                            // }
                            return `${detail}
                            ${print}
                            `;
                        }
                    },
                },
            ],
        });
    }



    function dt_report_detail() {

        start_report = $('#start_report').val();
        end_report = $('#end_report').val();
        $('#dt_report_detail').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "responsive": false,
            "dom": 'Bfrtip',
            "order": [
                [1, 'desc']
            ],
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    start: start_report,
                    end: end_report
                },
                "url": `${baseurl}/get_report_detail`,
            },
            "columns": [{
                    "data": "created_at",
                },
                {
                    "data": "employee_name",
                },
                {
                    "data": "company_name",
                },
                {
                    "data": "department_name",
                },
                {
                    "data": "designation_name",
                },
                {
                    "data": "date_of_joining",
                },
                {
                    "data": "masa_kerja",
                },
                {
                    "data": "habis_kontrak",
                },
                {
                    "data": "last_attendance",
                },
                {
                    "data": "nama_mng",
                },
                {
                    "data": "head_employee_name",
                },
                {
                    "data": "nama_spv",
                },
                {
                    "data": "reason_atasan",
                },
                {
                    "data": "subclearance",
                },
                {
                    "data": "status_resignation",
                    "render": function(data, type, row, meta) {
                        if (row['status_resignation'] == 'Approve') {
                            return `<span class="badge bg-green text-white">${row['status_resignation']}</span>`;
                        } else {
                            return `<span class="badge bg-yellow text-white">${row['status_resignation']}</span>`;
                        }
                    },
                },
                {
                    "data": "diperiksa_oleh",
                },
                {
                    "data": "approved_at",
                },
                {
                    "data": "note",
                },
            ],
        });
    }

    function list_waiting_resignation_hrd() {

        $('#modal-list-waiting-resignation-hrd').modal('show');
        user_id = "<?= $this->session->userdata("user_id"); ?>";
        user_role_id = "<?= $this->session->userdata("user_role_id"); ?>";
        $('#dt_trusmi_list_waiting_resignation_hrd').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "responsive": true,
            "dom": 'Bfrtip',
            "order": [
                [1, 'desc']
            ],
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    user_id: user_id
                },
                "url": `${baseurl}/list_waiting_resignation_hrd`,
            },
            "columns": [{
                    "data": "notice_date",
                },
                {
                    "data": "resignation_date",
                },
                {
                    "data": "employee_name",
                },
                {
                    "data": "company_name",
                },
                {
                    "data": "department_name",
                },
                {
                    "data": "designation_name",
                },
                {
                    "data": "status_resignation",
                    "render": function(data, type, row, meta) {
                        if (row['id_status_resignation'] == 0) {
                            if (user_role_id == 1 || user_id == 2063 || user_id == 61 || user_id == 979) {
                                v_hrd = `<a href="${baseurl}/verify_hrd?id=${row['resignation_id']}"><span class="badge bg-danger data-resignation"> ${data}</span></a>`;
                            } else {
                                v_hrd = ``;
                            }
                            return `${v_hrd}`;
                        } else {
                            print = '';
                            if (user_role_id == 1 || user_id == 2063 || user_id == 61) {
                                print = `<a href="${baseurl}/print_paklaring/${row['resignation_id']}" target="_blank"><span class="badge bg-success data-resignation";
                            ><i class="bi bi-printer"></i></span></a>`;
                                send_wa_again = `<a href="javascript:void(0)"><span class="badge bg-primary" onclick="kirim_ulang('${row['resignation_id']}')";
                            ><i class="bi bi-whatsapp"></i></span></a>`;
                            }
                            // pic_approve = row['pic_approve'];
                            // arr_pic = pic_approve.split(",");
                            // if (arr_pic.includes(user_id)) {
                            //     detail = `<a href="<?= base_url() ?>trusmi_resignation/verify_resignation?id=${row['resignation_id']}"><span class="badge bg-success data-resignation"> ${data}</span></a>`;
                            // } else {
                            detail = `<a href="${baseurl}/verify_resignation?id=${row['resignation_id']}"><span class="badge bg-success data-resignation"> ${data}</span></a>`;
                            // }
                            return `${detail}
                            ${print}
                            `;
                        }
                    },
                },
            ],
        });
    }

    function get_profil_user() {
        user_id = "<?= $this->session->userdata("user_id"); ?>";
        $.ajax({
            url: `${baseurl}/get_profile`,
            type: 'POST',
            dataType: 'json',
            data: {
                user_id: user_id
            },
            beforeSend: function() {

            },
            success: function(response) {
                let company_id = response.company_id == null ? 'no-data' : response.company_id;
                let designation_id = response.designation_id == null ? 'no-data' : response.designation_id;
                let company_name = response.company_name == null ? 'no-data' : response.company_name;
                let department_name = response.department_name == null ? 'no-data' : response.department_name;
                let designation_name = response.designation_name == null ? 'no-data' : response.designation_name;
                $("#company_id").val(company_id);
                $("#designation_id").val(designation_id);
                $("#company_name").val(company_name);
                $("#department_name").val(department_name);
                $("#designation_name").val(designation_name);
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    function get_employee() {
        const roleUserId = parseInt(roleUser, 10)
        let id = null;


        if (![2, 3, 4, 5, 10].includes(roleUserId)) {
            id = null;
        } else {
            id = companyId;
        }

        // Melakukan AJAX untuk mendapatkan data
        $.ajax({
            type: "POST",
            url: `${baseurl}/get_data_company`,
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                selectCompany.setData(response);
            }
        });
    }

    $('#company_id_2').change(function() {
        const roleUserId = parseInt(roleUser, 10)
        let id = $(this).val();
        let id_department = null
        if ([2, 3, 4, 5, 10].includes(roleUserId)) {
            id_department = `<?= $this->session->userdata('department_id') ?>`
        } else {
            id_department = null
        }
        $.ajax({
            url: `${baseurl}/get_data_department`,
            type: 'POST',
            dataType: 'json',
            data: {
                id,
                id_department
            },
            success: function(response) {
                selectDepartment.setData(response);
            }
        });
    });

    $('#department_id_2').change(function() {
        id = $(this).val();
        $.ajax({
            url: `${baseurl}/get_data_designation`,
            type: 'POST',
            dataType: 'json',
            data: {
                id
            },
            success: function(response) {
                selectDesignation.setData(response);
            }
        });
    });

    $('#designation_id_2').change(function() {
        id = $(this).val();
        $.ajax({
            url: `${baseurl}/get_data_employee`,
            type: 'POST',
            dataType: 'json',
            data: {
                id
            },
            success: function(response) {
                selectEmployee.setData(response);
            }
        });
    });

    // let options = {
    //     searchable: true
    // }
    // let n_reasons = NiceSelect.bind(document.getElementById('reason'), options);

    //get_data_reason(); // add by Ade

    $('#category').change(function() {
        category_id = $(this).val();
        $.ajax({
            url: `${baseurl}/get_data_reason`,
            type: 'POST',
            dataType: 'json',
            data: {
                category_id: category_id
            },
            success: function(response) {
                selectReason.setData(response);
                // slc_employee.setData([{text: 'All Employees', value: '0'}])
            }
        });
    });

    $('#category_2').change(function() {
        category_id = $(this).val();
        $.ajax({
            url: `${baseurl}/get_data_reason`,
            type: 'POST',
            dataType: 'json',
            data: {
                category_id: category_id
            },
            success: function(response) {
                selectReason2.setData(response);
                // slc_employee.setData([{text: 'All Employees', value: '0'}])
            }
        });
    });

    $('#reason_2').change(function() {
        id_reason = $(this).val();
        $.ajax({
            url: `${baseurl}/get_data_detail_reason`,
            type: 'POST',
            dataType: 'json',
            data: {
                id_reason
            },
            success: function(response) {
                selectDetailReason2.setData(response);
            }
        });
    });

    $('#reason').change(function() {
        id_reason = $(this).val();
        $.ajax({
            url: `${baseurl}/get_data_detail_reason`,
            type: 'POST',
            dataType: 'json',
            data: {
                id_reason
            },
            success: function(response) {
                selectDetailReason.setData(response);
            }
        });
    });

    $('#detail_reason').change(function() {
        id = parseInt($(this).val(), 10)
        if ([6, 8, 20].includes(id)) {
            $('#note_detail').show();
        } else {
            $('#note_detail').hide();
        }
    });

    $('#detail_reason_2').change(function() {
        id = parseInt($(this).val(), 10)
        if ([6, 8, 20].includes(id)) {
            $('#note_detail_2').show();
        } else {
            $('#note_detail_2').hide();
        }
    });

    $('#resignation_date').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        autoclose: true
        // uiLibrary: 'bootstrap4'
    });

    $('#resignation_date_2').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        autoclose: true
        // uiLibrary: 'bootstrap4'
    });

    function dt_trusmi_resignation(start, end) {
        let user_id = "<?= $this->session->userdata("user_id"); ?>";
        let user_role_id = "<?= $this->session->userdata("user_role_id"); ?>";

        // var table = $('#dt_trusmi_resignation').DataTable();


        $('#dt_trusmi_resignation').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [1, 'desc']
            ],
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": `${baseurl}/dt_trusmi_resignation`,
                "data": {
                    start: start,
                    end: end,
                    user_id: user_id,
                    user_role_id: user_role_id
                }
            },
            "columns": [{
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                {
                    "data": "notice_date",
                },
                {
                    "data": "resignation_date",
                },
                {
                    "data": "date_of_joining",
                },
                {
                    "data": "employee_name",
                },
                {
                    "data": "company_name",
                },
                {
                    "data": "department_name",
                },
                {
                    "data": "designation_name",
                },
                // add by Ade
                {
                    "data": "category",
                },
                {
                    "data": "reason",
                },
                {
                    "data": "detail_reason",
                },
                {
                    "data": "status_resignation",
                    "render": function(data, type, row, meta) {
                        if (row['id_status_resignation'] == 0) {
                            if (user_role_id == 1 || user_id == 2063 || user_id == 61) {
                                send_wa_again = `<a href="javascript:void(0)"><span class="badge bg-primary" onclick="kirim_ulang('${row['resignation_id']}')";
                            ><i class="bi bi-whatsapp"></i> kirim ulang notif</span></a>`;
                            } else {
                                send_wa_again = '';
                            }
                            // pic_approve = row['pic_approve'];
                            // arr_pic = pic_approve.split(",");
                            // if (arr_pic.includes(user_id)) {
                            //     detail = `<a href="<?= base_url() ?>trusmi_resignation/verify_resignation?id=${row['resignation_id']}"><span class="badge bg-danger data-resignation"> ${data}</span></a>`;
                            // } else {
                            detail = `<a href="${baseurl}/detail_resignation?id=${row['resignation_id']}"><span class="badge bg-danger data-resignation"> ${data}</span></a>`;
                            // }
                            return `${detail}${send_wa_again}`;
                        } else {
                            print = '';
                            if (user_role_id == 1 || user_id == 2063 || user_id == 61) {
                                print = `<a href="${baseurl}/print_paklaring/${row['resignation_id']}" target="_blank"><span class="badge bg-success data-resignation";
                            ><i class="bi bi-printer"></i></span></a>`;
                                send_wa_again = `<a href="javascript:void(0)"><span class="badge bg-primary" onclick="kirim_ulang('${row['resignation_id']}')";
                            ><i class="bi bi-whatsapp"></i></span></a>`;
                            }
                            // pic_approve = row['pic_approve'];
                            // arr_pic = pic_approve.split(",");
                            // if (arr_pic.includes(user_id)) {
                            //     detail = `<a href="<?= base_url() ?>trusmi_resignation/verify_resignation?id=${row['resignation_id']}"><span class="badge bg-success data-resignation"> ${data}</span></a>`;
                            // } else {
                            detail = `<a href="${baseurl}/detail_resignation?id=${row['resignation_id']}"><span class="badge bg-success data-resignation"> ${data}</span></a>`;
                            // }
                            return `${detail}
                            ${print}
                            `;
                        }
                    },
                },
                {
                    "data": "nama_mng",
                    "className": "d-none"
                },
                {
                    "data": "nama_spv",
                    "className": "d-none"
                },
                {
                    "data": "detail_reason",
                    "className": "d-none"
                },
                {
                    "data": "reason_atasan",
                    "className": "d-none"
                },
                {
                    "data": "pernyataan_1",
                    "className": "d-none"
                },
                {
                    "data": "pernyataan_2",
                    "className": "d-none"
                },
                {
                    "data": "pernyataan_3",
                    "className": "d-none"
                },
                {
                    "data": "pernyataan_4",
                    "className": "d-none"
                },
                {
                    "data": "pernyataan_5",
                    "className": "d-none"
                },
                {
                    "data": "pernyataan_6",
                    "className": "d-none"
                },
                {
                    "data": "pernyataan_7",
                    "className": "d-none"
                },
                {
                    "data": "pernyataan_8",
                    "className": "d-none"
                },
                {
                    "data": "pernyataan_9",
                    "className": "d-none"
                },
                {
                    "data": "pernyataan_10",
                    "className": "d-none"
                },
                {
                    "data": "pernyataan_11",
                    "className": "d-none"
                },
                {
                    "data": "pernyataan_12",
                    "className": "d-none"
                },
                {
                    "data": "pernyataan_13",
                    "className": "d-none"
                },
                {
                    "data": "pernyataan_14",
                    "className": "d-none"
                },
                {
                    "data": "pernyataan_15",
                    "className": "d-none"
                },
                {
                    "data": "pernyataan_16",
                    "className": "d-none"
                },
                {
                    "data": "pernyataan_17",
                    "className": "d-none"
                },
                {
                    "data": "pernyataan_18",
                    "className": "d-none"
                }
            ],
        });
    }

    // Add event listener for opening and closing details
    $('#dt_trusmi_resignation tbody').on('click', 'td.dt-control', function() {
        var tr = $(this).closest('tr');
        var row = $('#dt_trusmi_resignation').DataTable().row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });

    function format(d) {
        // `d` is the original data object for the row
        return (
            `<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">
            <tr><td><b>Manager</b> : ${d.nama_mng}</td></tr>
            <tr><td><b>Spv</b> : ${d.nama_spv}</td></tr>
            <tr><td><b>Note</b> : ${d.note}</td></tr>
            <tr><td><b>Reason Atasan</b> : ${d.reason_atasan}</td></tr>
            <tr><td><b>Q1</b> : ${d.pernyataan_1}</td></tr>
            <tr><td><b>Q2</b> : ${d.pernyataan_2}</td></tr>
            <tr><td><b>Q3</b> : ${d.pernyataan_3}</td></tr>
            <tr><td><b>Q4</b> : ${d.pernyataan_4}</td></tr>
            <tr><td><b>Q5</b> : ${d.pernyataan_5}</td></tr>
            <tr><td><b>Q6</b> : ${d.pernyataan_6}</td></tr>
            <tr><td><b>Q7</b> : ${d.pernyataan_7}</td></tr>
            <tr><td><b>Q8</b> : ${d.pernyataan_8}</td></tr>
            <tr><td><b>Q9</b> : ${d.pernyataan_9}</td></tr>
            <tr><td><b>Q10</b> : ${d.pernyataan_10}</td></tr>
            <tr><td><b>Q11</b> : ${d.pernyataan_11}</td></tr>
            <tr><td><b>Q12</b> : ${d.pernyataan_12}</td></tr>
            <tr><td><b>Q13</b> : ${d.pernyataan_13}</td></tr>
            <tr><td><b>Q14</b> : ${d.pernyataan_14}</td></tr>
            <tr><td><b>Q15</b> : ${d.pernyataan_15}</td></tr>
            <tr><td><b>Q16</b> : ${d.pernyataan_16}</td></tr>
            <tr><td><b>Q17</b> : ${d.pernyataan_17}</td></tr>
            <tr><td><b>Q18</b> : ${d.pernyataan_18}</td></tr>
        </table>`
        );
    }

    // $(function() {
    //     $('[data-toggle="popover"]').popover();
    // })

    // var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    // var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
    //     return new bootstrap.Popover(popoverTriggerEl)
    // })

    $(document).ready(function() {
        // var table = $('#dt_trusmi_resignation').DataTable();
        // Add event listener for opening and closing details
        // $('#dt_trusmi_resignation tbody').on('click', 'td.dt-control', function() {
        //     var tr = $(this).closest('tr');
        //     var row = $('#dt_trusmi_resignation').DataTable().row(tr);

        //     if (row.child.isShown()) {
        //         // This row is already open - close it
        //         row.child.hide();
        //         tr.removeClass('shown');
        //     } else {
        //         // Open this row
        //         row.child(format(row.data())).show();
        //         tr.addClass('shown');
        //     }
        // });
    });

    function save() {
        if ($('#company_id').val() == '') {
            error_alert("Company anda tidak terdeteksi di sistem");
            $('#company_id').focus();
        } else if ($('#employee_id').val() == '') {
            error_alert("Employee Id anda tidak terdeteksi di sistem");
            $('#employee_id').focus();
        } else if ($('#notice_date').val() == '') {
            error_alert("Notice Date tidak boleh kosong");
            $('#notice_date').focus();
        } else if ($('#resignation_date').val() == '') {
            error_alert("Resignation Date tidak boleh kosong");
            $('#resignation_date').focus();
            // add by Ade
        } else if ($('#category').val() == '') {
            error_alert("Category tidak boleh kosong");
            $('#category').focus();
        } else if ($('#reason').val() == '') {
            error_alert("Reason tidak boleh kosong");
            $('#reason').focus();
        } else if ($('#note').val() == '') {
            error_alert("Note tidak boleh kosong");
            $('#note').focus();
        } else if (
            $('#pernyataan_1').val() == '' ||
            $('#pernyataan_2').val() == '' ||
            $('#pernyataan_3').val() == '' ||
            $('#pernyataan_4').val() == '' ||
            $('#pernyataan_5').val() == '' ||
            $('#pernyataan_6').val() == '' ||
            $('#pernyataan_7').val() == '' ||
            $('#pernyataan_8').val() == '' ||
            $('#pernyataan_9').val() == '' ||
            $('#pernyataan_10').val() == '' ||
            $('#pernyataan_11').val() == '' ||
            $('#pernyataan_12').val() == '' ||
            $('#pernyataan_13').val() == '' ||
            $('#pernyataan_14').val() == '' ||
            $('#pernyataan_15').val() == '' ||
            $('#pernyataan_16').val() == '' ||
            $('#pernyataan_17').val() == '' ||
            $('#pernyataan_18').val() == ''
        ) {
            error_alert("Anda belum menjawab semua pertanyaan");
        } else if ([6, 8, 20].includes(parseInt($('#detail_reason').val(), 10)) && $('#alasan_lain').val() == '') {
            error_alert("Alasan lainnya tidak boleh kosong");
            $('#alasan_lain').focus();
        } else {
            $("#modalAddConfirm").modal("show");
        }
    }

    function save_head() {
        if ($('#company_id_2').val() == '') {
            error_alert("Company anda tidak terdeteksi di sistem");
            $('#company_id_2').focus();
        } else if ($('#department_id_2').val() == '') {
            error_alert("Employee Id anda tidak terdeteksi di sistem");
            $('#department_id_2').focus();
        } else if ($('#designation_id_2').val() == '') {
            error_alert("Notice Date tidak boleh kosong");
            $('#designation_id_2').focus();
        } else if ($('#employee_id_2').val() == '') {
            error_alert("Employee Date tidak boleh kosong");
            $('#employee_id_2').focus();
            // add by Ade
        } else if ($('#resignation_date_2').val() == '') {
            error_alert("Resignation Date Date tidak boleh kosong");
            $('#resignation_date_2').focus();
            // add by Ade
        } else if ($('#category_2').val() == '') {
            error_alert("Category tidak boleh kosong");
            $('#category_2').focus();
        } else if ($('#reason_2').val() == '') {
            error_alert("Reason tidak boleh kosong");
            $('#reason_2').focus();
        } else if ($('#detail_reason_2').val() == '') {
            error_alert("Detail Reason tidak boleh kosong");
            $('#detail_reason_2').focus();
            // add by Ade
        } else if ($('#note_2').val() == '') {
            error_alert("Note tidak boleh kosong");
            $('#note_2').focus();
        } else if ([6, 8, 20].includes(parseInt($('#detail_reason_2').val(), 10)) && $('#alasan_lain_2').val() == '') {
            error_alert("Alasan lainnya tidak boleh kosong");
            $('#alasan_lain_2').focus();
        } else {
            $.ajax({
                type: "POST",
                url: `${baseurl}/get_pic_clearance`,
                data: {
                    id: $('#department_id_2').val()
                },
                dataType: "json",
                success: function(response) {
                    response.forEach(function(item) {
                        $('#list_pic').append(`<li>${item.pic}</li>`);
                    });
                }
            });
            $("#modalAddConfirmHead").modal("show");
        }
    }

    function store_resignation_head() {
        form = $('#form_add_head');

        // add by Ade
        let category_name = $('#category_2 option:selected').text();
        let reason_title = $('#reason_2 option:selected').text();
        let reason_detail = $('#detail_reason_2 option:selected').text();
        let alasan_lain = $('#alasan_lain_2').val();
        if (alasan_lain !== '') {
            reason_detail += ' ' + alasan_lain
        }

        let form_data = form.serialize() + '&category_name=' + category_name + '&reason_title=' + reason_title + '&reason_detail=' + reason_detail

        $.ajax({
            url: `${baseurl}/store_head`,
            type: 'POST',
            dataType: 'json',
            data: form_data, //edit by Ade
            beforeSend: function() {
                $('#btn_save_confirm_2').attr('disabled', true);
                $("#btn_save_confirm_2").html("Please wait...");
            },
            success: function(response) {
                if (response.status == 200) {
                    id_resignation = response.id_resignation;
                    contact_no = response.contact_no;
                    requested_by = response.nama;
                    requested_at = '<?= date("Y-m-d") ?>';
                    requested_hour = '<?= date("H:i:s") ?>';

                    nama_atasan = '';
                    for (let index = 0; index < contact_no.length; index++) {
                        array_contact = [];
                        array_contact.push(contact_no[index].contact_no);
                        pic = contact_no[index].pic;
                        company_name = contact_no[index].company_name;
                        department_name = contact_no[index].department_name;
                        designation_name = contact_no[index].designation_name;
                        if (contact_no[index].id_clearance == '1') {
                            nama_atasan = contact_no[index].employee_name;
                        }

                        msg = `📣 Alert!!!
*There is New Request Exit Clearance*

No. Resignation : ${id_resignation}
Subject : *Form Exit Clearance*
👤 Requested By : ${requested_by}
Company : *${company_name}*
Department : *${department_name}*
Designation : *${designation_name}*
Atasan  : *${nama_atasan}*
🕐 Requested At : ${requested_at} | ${requested_hour}

🌐 Link Approve : 
                    
https://trusmiverse.com/apps/login/verify_resignation?u=${pic}&id=${id_resignation}`;
                        // umam
                        send_wa(array_contact, msg);
                    }
                    // console.log(contact_no);
                    // console.log(contact_no[0].contact_no);
                    // console.log(array_contact);
                    success_alert('Resignation Added');
                    window.setTimeout(function() {
                        window.location = `${baseurl}/detail_resignation?id=${id_resignation}`;
                    }, 1500);
                } else if (response.status == 409) {
                    error_alert(response.msg);
                } else {
                    error_alert('Unrecognized Error');
                }
                form[0].reset();
                $("#modalAddHead").modal("hide");
                $("#modalAddConfirmHead").modal("hide");
                dt_trusmi_resignation(moment().startOf('month').format('YYYY-MM-DD'), moment().endOf('month').format('YYYY-MM-DD'));
                selectCategory2.setSelected();
                selectReason2.setSelected();
                selectDetailReason2.setSelected();
                selectCompany.setSelected();
                selectDepartment.setSelected();
                selectDesignation.setSelected();
                selectEmployee.setSelected();
            },
            error: function(xhr) { // if error occured
                error_alert('Failed, Error Occured');
            },
            complete: function() {
                $('#btn_save_confirm_2').attr('disabled', false);
                $("#btn_save_confirm_2").html("Yes, Save");
            },
        });
    }

    function store_resignation() {
        form = $('#form_add');

        // add by Ade
        var category_name = $('#category option:selected').text();
        var reason_title = $('#reason option:selected').text();
        var reason_detail = $('#detail_reason option:selected').text();
        let alasan_lain = $('#alasan_lain').val();
        if (alasan_lain !== '') {
            reason_detail += ' ' + alasan_lain
        }

        var form_data = form.serialize() + '&category_name=' + category_name + '&reason_title=' + reason_title + '&reason_detail=' + reason_detail

        $.ajax({
            url: `${baseurl}/store`,
            type: 'POST',
            dataType: 'json',
            data: form_data, //edit by Ade
            beforeSend: function() {
                $('#btn_save_confirm').attr('disabled', true);
                $("#btn_save_confirm").html("Please wait...");
            },
            success: function(response) {
                if (response.status == 200) {
                    id_resignation = response.id_resignation;
                    // username = '<?= $this->session->userdata('username'); ?>';
                    contact_no = response.contact_no;
                    requested_by = '<?= $this->session->userdata("nama"); ?>';
                    requested_at = '<?= date("Y-m-d") ?>';
                    requested_hour = '<?= date("H:i:s") ?>';

                    nama_atasan = '';
                    for (let index = 0; index < contact_no.length; index++) {
                        array_contact = [];
                        array_contact.push(contact_no[index].contact_no);
                        pic = contact_no[index].pic;
                        company_name = contact_no[index].company_name;
                        department_name = contact_no[index].department_name;
                        designation_name = contact_no[index].designation_name;
                        if (contact_no[index].id_clearance == '1') {
                            nama_atasan = contact_no[index].employee_name;
                        }

                        msg = `📣 Alert!!!
*There is New Request Exit Clearance*

No. Resignation : ${id_resignation}
Subject : *Form Exit Clearance*
👤 Requested By : ${requested_by}
Company : *${company_name}*
Department : *${department_name}*
Designation : *${designation_name}*
Atasan  : *${nama_atasan}*
🕐 Requested At : ${requested_at} | ${requested_hour}

🌐 Link Approve : 
                    
https://trusmiverse.com/apps/login/verify_resignation?u=${pic}&id=${id_resignation}`;
                        // umam send wa non aktif
                        send_wa(array_contact, msg);
                    }
                    // console.log(contact_no);
                    // console.log(contact_no[0].contact_no);
                    // console.log(array_contact);
                    success_alert('Resignation Added');
                    window.setTimeout(function() {
                        window.location = `${baseurl}/detail_resignation?id=${id_resignation}`;
                    }, 1500);
                } else if (response.status == 409) {
                    error_alert(response.msg);
                } else {
                    error_alert('Unrecognized Error');
                }
                form[0].reset();
                $("#modalAdd").modal("hide");
                $("#modalAddConfirm").modal("hide");
                dt_trusmi_resignation(moment().startOf('month').format('YYYY-MM-DD'), moment().endOf('month').format('YYYY-MM-DD'));
                selectCategory.setSelected();
                selectReason.setSelected();
                selectDetailReason.setSelected();
            },
            error: function(xhr) { // if error occured
                error_alert('Failed, Error Occured');
            },
            complete: function() {
                $('#btn_save_confirm').attr('disabled', false);
                $("#btn_save_confirm").html("Yes, Save");
            },
        });
    }


    function kirim_ulang(id_resignation) {
        $('#modal-confirm-resend-wa').modal('show');
        $('#id-resignation-confirm-resend-wa').val(id_resignation);
    }


    function resend_wa() {
        id_resignation = $('#id-resignation-confirm-resend-wa').val();
        $.ajax({
            url: `${baseurl}/send_wa_again`,
            type: 'POST',
            dataType: 'json',
            data: {
                id_resignation: id_resignation
            },
            success: function(response) {
                $('#modal-confirm-resend-wa').modal('hide');
                if (response.status == 200) {
                    id_resignation = response.id_resignation;
                    // username = '<?= $this->session->userdata('username'); ?>';
                    contact_no = response.contact_no;
                    requested_at = '<?= date("Y-m-d") ?>';
                    requested_hour = '<?= date("H:i:s") ?>';

                    nama_atasan = '';
                    for (let index = 0; index < contact_no.length; index++) {
                        array_contact = [];
                        array_contact.push(contact_no[index].contact_no);
                        requested_by = contact_no[index].nama_pengaju;
                        pic = contact_no[index].pic;
                        company_name = contact_no[index].company_name;
                        department_name = contact_no[index].department_name;
                        designation_name = contact_no[index].designation_name;
                        if (contact_no[index].id_clearance == '1') {
                            nama_atasan = contact_no[index].employee_name;
                        }

                        msg = `📣 Alert!!!
*There is New Request Exit Clearance*

No. Resignation : ${id_resignation}
Subject : *Form Exit Clearance*
👤 Requested By : ${requested_by}
Company : *${company_name}*
Department : *${department_name}*
Designation : *${designation_name}*
Atasan  : *${nama_atasan}*
🕐 Requested At : ${requested_at} | ${requested_hour}

🌐 Link Approve : 
                    
https://trusmiverse.com/apps/login/verify_resignation?u=${pic}&id=${id_resignation}`;
                        send_wa(array_contact, msg);
                    }
                } else if (response.status == 409) {
                    error_alert(response.msg);
                } else {
                    error_alert('Unrecognized Error');
                }
            },
            error: function(xhr) { // if error occured
                error_alert('Failed, Error Occured');
            },
        });
    }


    function success_alert(text) {
        textMsg = text == null ? '' : text;
        new PNotify({
            title: `Success`,
            text: `${textMsg}`,
            icon: 'icofont icofont-checked',
            type: 'success',
            delay: 3000,
        });
    }

    function error_alert(text) {
        new PNotify({
            title: `Oopss`,
            text: `${text}`,
            icon: 'icofont icofont-info-circle',
            type: 'error',
            delay: 3000,
        });
    }
</script>