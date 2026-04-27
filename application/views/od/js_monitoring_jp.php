<!-- third party js -->
<script src="<?= base_url() ?>assets/vendor/ckeditor/ckeditor.js"></script>
<!-- third party js ends -->

<!-- Datatable Buttons (core already loaded in main layout) -->
<script src="<?php echo base_url() ?>assets/data-table/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo base_url() ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/daterangepicker.js"></script>

<!-- Datepicker -->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        let start = moment().startOf('month');
        let end = moment().endOf('month');

        function cb(start, end) {
            $('#reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="datestart"]').attr('value', start.format('YYYY-MM-DD'));
            $('input[name="dateend"]').attr('value', end.format('YYYY-MM-DD'));
        }

        $('.select2').select2({
            height: '100%',
            dropdownParent: $('#modal_add_interview')
        });

        $('#sel_dept').select2({
            theme: 'bootstrap-5',
        });
        $('#pic_rev').select2({
            height: '100%',
        });

        $('#range').daterangepicker({
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

        cb(start, end);

        show_job_profile('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>', 0);

        $('#company_id').on('change', function() {
            let id = $(this).val();
            $.ajax({
                url: '<?php echo base_url() ?>od_monitoring_jp/get_departments/' + id,
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    let set_dat = '<option value="" disabled selected>Select Department</option>';
                    for (let i = 0; i < data.length; i++) {
                        set_dat += '<option value="' + data[i].department_id + '">' + data[i].department_name + '</option>';
                    }
                    $('#departement_id').html(set_dat);
                }
            });
        });

        $('#departement_id').on('change', function() {
            let id = $(this).val();
            $.ajax({
                url: '<?php echo base_url() ?>od_monitoring_jp/get_designations/' + id,
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    let set_dat = '';
                    for (let i = 0; i < data.length; i++) {
                        set_dat += '<option value="' + data[i].designation_id + '">' + data[i].designation_name + '</option>';
                    }
                    $('#designation_id').html(set_dat);
                    let doc_type_id = $('#doc_type_id').val();
                    let div_id = $('#div_id').val();
                    let company_id = $('#company_id option:selected').val();
                    let department_id = $('#departement_id option:selected').val();
                    if (doc_type_id != "" && div_id != "" && company_id != "" && department_id != "") {
                        get_no_doc(doc_type_id, div_id, company_id, department_id);
                    }
                }
            });
        });

        $('#doc_type_id').on('change', function() {
            let doc_type_id = $('#doc_type_id').val();
            let div_id = $('#div_id').val();
            let company_id = $('#company_id option:selected').val();
            let department_id = $('#departement_id option:selected').val();
            if (doc_type_id != "" && div_id != "" && company_id != "" && department_id != "") {
                get_no_doc(doc_type_id, div_id, company_id, department_id);
            }
        });

        $('#div_id').on('change', function() {
            let doc_type_id = $('#doc_type_id').val();
            let div_id = $('#div_id').val();
            let company_id = $('#company_id option:selected').val();
            let department_id = $('#departement_id option:selected').val();
            if (doc_type_id != "" && div_id != "" && company_id != "" && department_id != "") {
                get_no_doc(doc_type_id, div_id, company_id, department_id);
            }
        });

        $('#add_release_date').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            autoclose: true
        });
    });

    function show_data() {
        let sel_dept = $('#sel_dept').val();
        let start = $('#datestart').val();
        let end = $('#dateend').val();
        show_job_profile(start, end, sel_dept);
    }

    function get_no_doc(doc_type_id, div_id, company_id, department_id) {
        $.ajax({
            url: '<?php echo base_url() ?>od_monitoring_jp/get_no_doc/',
            type: 'POST',
            data: {
                doc_type_id: doc_type_id,
                div_id: div_id,
                company_id: company_id,
                department_id: department_id
            },
            dataType: 'JSON',
            success: function(data) {
                $('#no_doc').val(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
            }
        });
    }

    function save_interview() {
        let form = $('#form_add_interview');
        let doc_type_id = $('#doc_type_id option:selected').val();
        let div_id = $('#div_id option:selected').val();
        let company_id = $('#company_id option:selected').val();
        let departement_id = $('#departement_id option:selected').val();
        let designation_id = $('#designation_id option:selected').val();
        let add_golongan = $('#add_golongan option:selected').val();
        let add_report_to = $('#add_report_to option:selected').val();
        let add_prepared_by = $('#add_prepared_by option:selected').val();
        let add_release_date = $('#add_release_date').val();

        if (doc_type_id == '') {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please select document type' });
        } else if (div_id == '') {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please select division' });
        } else if (company_id == '') {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please select company' });
        } else if (departement_id == '') {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please select department' });
        } else if (designation_id == '') {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please select designation' });
        } else if (add_golongan == '') {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please select golongan' });
        } else if (add_report_to == '') {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please select report to' });
        } else if (add_prepared_by == '') {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please select prepared by' });
        } else if (add_release_date == '') {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please choose release date' });
        } else {
            Swal.fire({
                title: "Save Interview?",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Yes, save it!",
                cancelButtonText: "No, cancel!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo base_url() ?>od_monitoring_jp/insert_job_profile',
                        type: 'POST',
                        data: form.serialize(),
                        dataType: 'JSON',
                        success: function(response) {
                            $('#form_add_interview')[0].reset();
                            $('#modal_add_interview').modal('hide');
                            $('#company_id').trigger('change');
                            $('#departement_id').trigger('change');
                            $('#dt_job_profile').DataTable().ajax.reload();
                        }
                    });
                }
            });
        }
    }

    function show_job_profile(start, end, sel_dept) {
        $('#dt_job_profile').DataTable({
            searching: true,
            info: true,
            paging: true,
            autoWidth: false,
            destroy: true,
            order: [[7, "desc"]],
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-sm btn-success',
                filename: 'Interview Job Profile',
                footer: true
            }],
            drawCallback: function() {
                $('.dt-buttons > .btn').addClass('btn btn-sm btn-info btn-sm');
            },
            ajax: {
                url: '<?= base_url("od_monitoring_jp/data_jp/") ?>' + start + '/' + end + '/' + sel_dept,
                type: 'GET',
                dataType: 'json',
            },
            columns: [
                {
                    data: 'no_jp',
                    render: function(data, type, row) {
                        let print = '<?= base_url("od_monitoring_jp/print_/") ?>' + data + '/' + row.level_sto;
                        let uid = '<?php echo $this->session->userdata('user_id') ?>';
                        let allowed = ['2774', '2843', '2903', '1'];
                        if (allowed.includes(uid)) {
                            return `<a href="javascript:void(0);" onclick="delete_jp('${data}')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                    <a href="${print}" target="_blank" class="btn btn-info shadow btn-xs sharp"><i class="fa fa-print"></i></a>`;
                        } else {
                            return `<a href="${print}" target="_blank" class="btn btn-info shadow btn-xs sharp"><i class="fa fa-print"></i></a>`;
                        }
                    }
                },
                {
                    data: 'no_jp',
                    render: function(data, type, row) {
                        let uid = '<?php echo $this->session->userdata('user_id') ?>';
                        let allowed = ['2774', '2843', '2903', '1'];
                        if (allowed.includes(uid)) {
                            return `<a href="javascript:void(0);" onclick="edit_jp('${data}')" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>`;
                        }
                        return '';
                    },
                    className: 'text-center',
                },
                {
                    data: 'no_jp',
                    render: function(data, type, row) {
                        if (row['status_rv'] == null) {
                            return `<a href="javascript:void(0);" onclick="modal_review('${data}','${row['departement_id']}')" class="btn btn-xs btn-warning sharp shadow"><i class="fa fa-star"></i></a> Waiting`;
                        } else {
                            return `<a href="javascript:void(0);" onclick="modal_review('${data}','${row['departement_id']}')" class="btn btn-xs btn-warning sharp shadow"><i class="fa fa-star"></i></a> <span class="badge badge-default">${row['status_rv']}</span>`;
                        }
                    },
                    className: 'text-center',
                },
                { data: 'no_dok' },
                { data: 'jabatan' },
                {
                    data: 'posisi',
                    render: function(data, type, row) {
                        return `<span>${data} (Lvl: ${row.level_romawi})</span>`;
                    }
                },
                { data: 'department_name' },
                { data: 'report_to' },
                { data: 'preparedBy' },
                { data: 'created_at' },
                { data: 'release_date' },
                {
                    data: 'id_status',
                    render: function(data, type, row) {
                        if (data == '1') {
                            return `<span class="badge light badge-warning">${row.status}</span>`;
                        } else {
                            return `<span class="badge light badge-info">${row.status}</span>`;
                        }
                    },
                    className: 'text-center',
                },
                { data: 'note' },
                { data: 'jadwal_diskusi' },
                { data: 'penjelasan' },
            ],
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            }
        });
    }

    function delete_jp(no_jp) {
        Swal.fire({
            title: "Are you sure?",
            text: "You will not be able to recover this data!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url() ?>od_monitoring_jp/delete_jp',
                    type: 'POST',
                    data: { 'no_jp': no_jp },
                    dataType: 'JSON',
                    success: function(response) {
                        Swal.fire('Success', 'Interview has been deleted', 'success');
                        $('#dt_job_profile').DataTable().ajax.reload();
                    }
                });
            }
        });
    }

    function modal_review(no_jp, department_id) {
        $('#modal_review').modal('show');
        $('#no_jp_rv').val(no_jp);
        $('#label_review').text(no_jp);
        $.ajax({
            url: '<?php echo base_url() ?>od_monitoring_jp/get_jp',
            type: 'POST',
            data: { 'no_jp': no_jp },
            dataType: 'JSON',
            success: function(response) {
                $('#no_jp').val(response[0].no_jp);
                $('#prepared_by').val(response[0].preparedBy);
                $('#rv_desig').text(response[0].jabatan);
                $('#rv_no_jp').text(response[0].no_dok);
                $('#rv_grade').text(response[0].posisi + ' (Level: ' + response[0].level_romawi + ')');
                $('#rv_dept').text(response[0].department_name);
            }
        });

        get_pic(department_id);

        $('#dt_review').DataTable({
            searching: false,
            info: false,
            paging: true,
            autoWidth: false,
            destroy: true,
            lengthChange: false,
            buttons: [{ extend: 'excelHtml5', text: 'Export to Excel' }],
            ajax: {
                url: '<?= base_url("od_monitoring_jp/get_review/") ?>' + no_jp,
                type: 'GET',
                dataType: 'json',
            },
            columns: [
                {
                    data: 'status',
                    render: function(data) {
                        if (data == 'Sesuai') {
                            return `<span class="badge badge-primary">${data}</span>`;
                        } else {
                            return `<span class="badge badge-danger">${data}</span>`;
                        }
                    },
                    className: "text-center",
                },
                { data: 'employee' },
                { data: 'review_note', width: "25%" },
                { data: 'created_at', className: "text-center" },
                {
                    data: 'id_review',
                    render: function(data, type, row) {
                        return `<button class="btn btn-primary btn-xs" onclick="modal_history('${data}','${row['employee']}')"><i class="fa fa-history"></i> History</button>`;
                    },
                    className: "text-center",
                },
            ],
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            }
        });
    }

    function modal_history(id_review, nama) {
        $('#modal_history').modal('show');
        $('#label_history').text(nama);
        $('#dt_history').DataTable({
            searching: false,
            info: false,
            paging: true,
            autoWidth: false,
            destroy: true,
            lengthChange: false,
            buttons: [{ extend: 'excelHtml5', text: 'Export to Excel' }],
            ajax: {
                url: '<?= base_url("od_monitoring_jp/get_history/") ?>' + id_review,
                type: 'GET',
                dataType: 'json',
            },
            columns: [
                {
                    data: 'review',
                    render: function(data) {
                        if (data == 'Sesuai') {
                            return `<span class="badge badge-primary">${data}</span>`;
                        } else {
                            return `<span class="badge badge-danger">${data}</span>`;
                        }
                    },
                    className: "text-center",
                },
                { data: 'review_note', width: "25%" },
                { data: 'review_at', className: "text-center" },
            ],
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            }
        });
    }

    function get_pic(id) {
        $.ajax({
            url: '<?php echo base_url() ?>od_monitoring_jp/get_pic/' + id,
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                let set_dat = '<option disabled selected>Select PIC</option>';
                for (let i = 0; i < data.length; i++) {
                    set_dat += '<option value="' + data[i].user_id + ',' + data[i].contact_no + '">' + data[i].employee_name + '</option>';
                }
                $('#pic_rev').html(set_dat);
            }
        });
    }

    function edit_jp(no_jp) {
        $('#modal_add_berkas').modal('show');
        aktifkan_ckeditor();
        $.ajax({
            url: '<?php echo base_url() ?>od_monitoring_jp/get_jp',
            type: 'POST',
            data: { 'no_jp': no_jp },
            dataType: 'JSON',
            success: function(response) {
                $('#no_jp').val(response[0].no_jp);
                $('#designation_id_').val(response[0].designation_id);
                $('#input_report_to').val(response[0].report_to);
                $('#no_doc_e').text(response[0].no_dok);
                $('#jp_e').text(response[0].jabatan);
                $('#grade_e').text(response[0].posisi + ' (Level: ' + response[0].level_romawi + ')');
                $('#dept_e').text(response[0].department_name);
                $('#report_to').text(response[0].report_to);
                $('#tujuan').val(response[0].tujuan);
                $('#bawahan').val(response[0].bawahan);
                $('#area').val(response[0].area);
                $('#pendidikan').val(response[0].pendidikan);
                $('#pengalaman').html(response[0].pengalaman);
                $('#kompetensi').html(response[0].kompetensi);
                $('#authority').html(response[0].authority);
            }
        });
    }

    function aktifkan_ckeditor() {
        let toolbar_ = [
            { "name": "basicstyles", "groups": ["basicstyles"] },
            { "name": "links", "groups": ["links"] },
            { "name": "paragraph", "groups": ["list", "blocks"] },
            { "name": "document", "groups": ["mode"] },
            { "name": "insert", "groups": ["insert"] },
            { "name": "styles", "groups": ["styles"] },
            { "name": "about", "groups": ["about"] }
        ];

        let editor_5 = CKEDITOR.instances['pengalaman'];
        if (editor_5) { editor_5.destroy(true); }
        editor_5 = CKEDITOR.replace('pengalaman', {
            height: '50%',
            toolbarGroups: toolbar_,
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
        });

        let editor_6 = CKEDITOR.instances['kompetensi'];
        if (editor_6) { editor_6.destroy(true); }
        editor_6 = CKEDITOR.replace('kompetensi', {
            height: 240,
            toolbarGroups: toolbar_,
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
        });

        let editor_9 = CKEDITOR.instances['authority'];
        if (editor_9) { editor_9.destroy(true); }
        editor_9 = CKEDITOR.replace('authority', {
            height: '50%',
            toolbarGroups: toolbar_,
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
        });
    }

    function update_interview() {
        let pengalaman = CKEDITOR.instances['pengalaman'].getData();
        let kompetensi = CKEDITOR.instances['kompetensi'].getData();
        let authority = CKEDITOR.instances['authority'].getData();

        Swal.fire({
            title: "Save Draft?",
            icon: "info",
            showCancelButton: true,
            confirmButtonText: "Yes, save it!",
            cancelButtonText: "No, cancel!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url() ?>od_monitoring_jp/update_job_profile',
                    type: 'POST',
                    data: {
                        'no_jp': $('#no_jp').val(),
                        'report_to': $('#input_report_to').val(),
                        'tujuan': $('#tujuan').val(),
                        'bawahan': $('#bawahan').val(),
                        'area': $('#area').val(),
                        'pendidikan': $('#pendidikan').val(),
                        'pengalaman': pengalaman,
                        'kompetensi': kompetensi,
                        'authority': authority
                    },
                    success: function(response) {
                        $('#form_add_berkas')[0].reset();
                        $('#modal_add_berkas').modal('hide');
                        Swal.fire('Success', 'Interview has been updated', 'success');
                        $('#dt_job_profile').DataTable().ajax.reload();
                    }
                });
            }
        });
    }

    function add_job_task() {
        const no_jp = $('#no_jp').val();
        const designation_id = $('#designation_id_').val();
        $('#modal_add_resp').modal('show');
        $('#no_jp_resp').val(no_jp);
        $('#id_designation_resp').val(designation_id);
        $('#tugas').focus();
        let aktifitas_ck = CKEDITOR.instances['aktifitas'];
        if (aktifitas_ck) { aktifitas_ck.destroy(true); }
        aktifitas_ck = CKEDITOR.replace('aktifitas', {
            height: '50%',
            toolbarGroups: [
                { "name": "basicstyles", "groups": ["basicstyles"] },
                { "name": "links", "groups": ["links"] },
                { "name": "paragraph", "groups": ["list", "blocks"] },
                { "name": "document", "groups": ["mode"] },
                { "name": "insert", "groups": ["insert"] },
                { "name": "styles", "groups": ["styles"] },
                { "name": "about", "groups": ["about"] }
            ],
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
        });
    }

    function save_job_task() {
        let aktifitas = CKEDITOR.instances['aktifitas'].getData();
        if ($('#tugas').val() == '') {
            Swal.fire('Error', 'Tugas Harus diisi', 'error');
        } else if (aktifitas == '') {
            Swal.fire('Error', 'Aktifitas harus diisi', 'error');
        } else {
            Swal.fire({
                title: "Add Scope Responsibilty?",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Yes, save it!",
                cancelButtonText: "No, cancel!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo base_url() ?>od_monitoring_jp/add_responsibility',
                        type: 'POST',
                        data: {
                            'no_jp': $('#no_jp_resp').val(),
                            'designation_id': $('#id_designation_resp').val(),
                            'tugas': $('#tugas').val(),
                            'aktifitas': aktifitas
                        },
                        success: function(response) {
                            $('#form_add_resp')[0].reset();
                            $('#modal_add_resp').modal('hide');
                            Swal.fire('Success', 'Responsibility has been added', 'success');
                        }
                    });
                }
            });
        }
    }

    function view_job_task() {
        const no_jp = $('#no_jp').val();
        $('#modal_view_resp').modal('show');
        $('#dt_job_task').DataTable({
            searching: false,
            info: false,
            paging: true,
            autoWidth: false,
            destroy: true,
            pageLength: 2,
            lengthChange: false,
            ajax: {
                url: '<?= base_url("od_monitoring_jp/get_job_task/") ?>' + no_jp,
                type: 'GET',
                dataType: 'json',
            },
            columns: [
                {
                    data: 'id',
                    render: function(data) {
                        return `<a href="javascript:void(0);" onclick="delete_job_task('${data}')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>`;
                    },
                    width: "5%",
                    className: "text-center"
                },
                { data: 'tugas' },
                { data: 'aktifitas' },
            ],
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            }
        });
    }

    function delete_job_task(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You will not be able to recover this data!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url() ?>od_monitoring_jp/delete_job_task',
                    type: 'POST',
                    data: { 'id': id },
                    dataType: 'JSON',
                    success: function(response) {
                        Swal.fire('Success', 'Job Task has been deleted', 'success');
                        $('#dt_job_task').DataTable().ajax.reload();
                    }
                });
            }
        });
    }

    function add_kpi() {
        const no_jp = $('#no_jp').val();
        const designation_id = $('#designation_id_').val();
        $('#modal_add_kpi').modal('show');
        $('#no_jp_kpi').val(no_jp);
        $('#id_designation_kpi').val(designation_id);
        let nama_kpi_ck = CKEDITOR.instances['nama_kpi'];
        if (nama_kpi_ck) { nama_kpi_ck.destroy(true); }
        nama_kpi_ck = CKEDITOR.replace('nama_kpi', {
            height: '50%',
            toolbarGroups: [
                { "name": "basicstyles", "groups": ["basicstyles"] },
                { "name": "links", "groups": ["links"] },
                { "name": "paragraph", "groups": ["list", "blocks"] },
                { "name": "document", "groups": ["mode"] },
                { "name": "insert", "groups": ["insert"] },
                { "name": "styles", "groups": ["styles"] },
                { "name": "about", "groups": ["about"] }
            ],
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
        });
    }

    function save_kpi() {
        let nama_kpi = CKEDITOR.instances['nama_kpi'].getData();
        if ($('#bobot_kpi').val() == '') {
            Swal.fire('Error', 'Bobot harus diisi', 'error');
        } else if (nama_kpi == '') {
            Swal.fire('Error', 'Nama KPI harus diisi', 'error');
        } else {
            Swal.fire({
                title: "Add Scope of KPI?",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Yes, save it!",
                cancelButtonText: "No, cancel!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo base_url() ?>od_monitoring_jp/add_kpi',
                        type: 'POST',
                        data: {
                            'no_jp': $('#no_jp_kpi').val(),
                            'designation_id': $('#id_designation_kpi').val(),
                            'bobot_kpi': $('#bobot_kpi').val(),
                            'nama_kpi': nama_kpi
                        },
                        success: function(response) {
                            $('#form_add_kpi')[0].reset();
                            $('#modal_add_kpi').modal('hide');
                            Swal.fire('Success', 'KPI has been added', 'success');
                        }
                    });
                }
            });
        }
    }

    function view_kpi() {
        const no_jp = $('#no_jp').val();
        $('#modal_view_kpi').modal('show');
        $('#dt_kpi').DataTable({
            searching: false,
            info: false,
            paging: true,
            autoWidth: false,
            destroy: true,
            pageLength: 2,
            lengthChange: false,
            ajax: {
                url: '<?= base_url("od_monitoring_jp/get_kpi/") ?>' + no_jp,
                type: 'GET',
                dataType: 'json',
            },
            columns: [
                {
                    data: 'id',
                    render: function(data) {
                        return `<a href="javascript:void(0);" onclick="delete_kpi('${data}')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>`;
                    },
                    width: "5%",
                    className: "text-center"
                },
                { data: 'kpi' },
                { data: 'bobot' },
            ],
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            }
        });
    }

    function delete_kpi(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You will not be able to recover this data!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url() ?>od_monitoring_jp/delete_kpi',
                    type: 'POST',
                    data: { 'id': id },
                    dataType: 'JSON',
                    success: function(response) {
                        Swal.fire('Success', 'KPI has been deleted', 'success');
                        $('#dt_kpi').DataTable().ajax.reload();
                    }
                });
            }
        });
    }

    function add_internal() {
        const no_jp = $('#no_jp').val();
        const designation_id = $('#designation_id_').val();
        $('#modal_add_internal').modal('show');
        $('#no_jp_internal').val(no_jp);
        $('#id_designation_internal').val(designation_id);
        let tujuan_internal_ck = CKEDITOR.instances['tujuan_internal'];
        if (tujuan_internal_ck) { tujuan_internal_ck.destroy(true); }
        tujuan_internal_ck = CKEDITOR.replace('tujuan_internal', {
            height: '50%',
            toolbarGroups: [
                { "name": "basicstyles", "groups": ["basicstyles"] },
                { "name": "links", "groups": ["links"] },
                { "name": "paragraph", "groups": ["list", "blocks"] },
                { "name": "document", "groups": ["mode"] },
                { "name": "insert", "groups": ["insert"] },
                { "name": "styles", "groups": ["styles"] },
                { "name": "about", "groups": ["about"] }
            ],
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
        });
    }

    function save_internal() {
        let tujuan_internal = CKEDITOR.instances['tujuan_internal'].getData();
        if ($('#hubungan_internal').val() == '') {
            Swal.fire('Error', 'Hubungan internal harus diisi', 'error');
        } else if (tujuan_internal == '') {
            Swal.fire('Error', 'Tujuan internal harus diisi', 'error');
        } else {
            Swal.fire({
                title: "Add Scope of Relationship Internal?",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Yes, save it!",
                cancelButtonText: "No, cancel!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo base_url() ?>od_monitoring_jp/add_internal',
                        type: 'POST',
                        data: {
                            'no_jp': $('#no_jp_internal').val(),
                            'designation_id': $('#id_designation_internal').val(),
                            'hubungan_internal': $('#hubungan_internal').val(),
                            'tujuan_internal': tujuan_internal
                        },
                        success: function(response) {
                            $('#form_add_internal')[0].reset();
                            $('#modal_add_internal').modal('hide');
                            Swal.fire('Success', 'Relationship Internal has been added', 'success');
                        }
                    });
                }
            });
        }
    }

    function view_internal() {
        const no_jp = $('#no_jp').val();
        $('#modal_view_internal').modal('show');
        $('#dt_internal').DataTable({
            searching: false,
            info: false,
            paging: true,
            autoWidth: false,
            destroy: true,
            pageLength: 2,
            lengthChange: false,
            ajax: {
                url: '<?= base_url("od_monitoring_jp/get_internal/") ?>' + no_jp,
                type: 'GET',
                dataType: 'json',
            },
            columns: [
                {
                    data: 'id',
                    render: function(data) {
                        return `<a href="javascript:void(0);" onclick="delete_internal('${data}')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>`;
                    },
                    width: "5%",
                    className: "text-center"
                },
                { data: 'tugas' },
                { data: 'tujuan' },
            ],
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            }
        });
    }

    function delete_internal(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You will not be able to recover this data!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url() ?>od_monitoring_jp/delete_internal',
                    type: 'POST',
                    data: { 'id': id },
                    dataType: 'JSON',
                    success: function(response) {
                        Swal.fire('Success', 'Relationship internal has been deleted', 'success');
                        $('#dt_internal').DataTable().ajax.reload();
                    }
                });
            }
        });
    }

    function add_external() {
        const no_jp = $('#no_jp').val();
        const designation_id = $('#designation_id_').val();
        $('#modal_add_external').modal('show');
        $('#no_jp_external').val(no_jp);
        $('#id_designation_external').val(designation_id);
        let tujuan_external_ck = CKEDITOR.instances['tujuan_external'];
        if (tujuan_external_ck) { tujuan_external_ck.destroy(true); }
        tujuan_external_ck = CKEDITOR.replace('tujuan_external', {
            height: '50%',
            toolbarGroups: [
                { "name": "basicstyles", "groups": ["basicstyles"] },
                { "name": "links", "groups": ["links"] },
                { "name": "paragraph", "groups": ["list", "blocks"] },
                { "name": "document", "groups": ["mode"] },
                { "name": "insert", "groups": ["insert"] },
                { "name": "styles", "groups": ["styles"] },
                { "name": "about", "groups": ["about"] }
            ],
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
        });
    }

    function save_external() {
        let tujuan_external = CKEDITOR.instances['tujuan_external'].getData();
        if ($('#hubungan_external').val() == '') {
            Swal.fire('Error', 'Hubungan external harus diisi', 'error');
        } else if (tujuan_external == '') {
            Swal.fire('Error', 'Tujuan external harus diisi', 'error');
        } else {
            Swal.fire({
                title: "Add Scope of Relationship External?",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Yes, save it!",
                cancelButtonText: "No, cancel!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo base_url() ?>od_monitoring_jp/add_external',
                        type: 'POST',
                        data: {
                            'no_jp': $('#no_jp_external').val(),
                            'designation_id': $('#id_designation_external').val(),
                            'hubungan_external': $('#hubungan_external').val(),
                            'tujuan_external': tujuan_external
                        },
                        success: function(response) {
                            $('#form_add_external')[0].reset();
                            $('#modal_add_external').modal('hide');
                            Swal.fire('Success', 'Relationship External has been added', 'success');
                        }
                    });
                }
            });
        }
    }

    function view_external() {
        const no_jp = $('#no_jp').val();
        $('#modal_view_external').modal('show');
        $('#dt_external').DataTable({
            searching: false,
            info: false,
            paging: true,
            autoWidth: false,
            destroy: true,
            pageLength: 2,
            lengthChange: false,
            ajax: {
                url: '<?= base_url("od_monitoring_jp/get_external/") ?>' + no_jp,
                type: 'GET',
                dataType: 'json',
            },
            columns: [
                {
                    data: 'id',
                    render: function(data) {
                        return `<a href="javascript:void(0);" onclick="delete_external('${data}')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>`;
                    },
                    width: "5%",
                    className: "text-center"
                },
                { data: 'tugas' },
                { data: 'tujuan' },
            ],
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            }
        });
    }

    function delete_external(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You will not be able to recover this data!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url() ?>od_monitoring_jp/delete_external',
                    type: 'POST',
                    data: { 'id': id },
                    dataType: 'JSON',
                    success: function(response) {
                        Swal.fire('Success', 'Relationship External has been deleted', 'success');
                        $('#dt_external').DataTable().ajax.reload();
                    }
                });
            }
        });
    }

    $('#pic_rev').change(function() {
        $('#set_pic').attr('disabled', false);
    });
</script>
