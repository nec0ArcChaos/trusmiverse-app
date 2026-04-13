<!-- third party js -->
<script src="<?= base_url() ?>assets/vendor/ckeditor/ckeditor.js"></script>
<!-- <script src="<?= base_url() ?>assets/vendor/ckeditor/plugin.js"></script> -->
<!-- third party js ends -->

<!-- Datatable -->
<script src="<?php echo base_url() ?>assets/vendor/datatables/js/jquery.dataTables.min.js"></script>

<script src="<?php echo base_url() ?>assets/old/libs/datatables/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/old/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/old/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/old/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>

<script src="<?php echo base_url() ?>assets/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/moment/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/daterangepicker.js"></script>

<!-- Datepicker -->
<script src="<?php echo base_url(); ?>assets/datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/fancybox/jquery.fancybox.min.js"></script>


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
        height: '100%',
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
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                .endOf('month')
            ]
        }
    }, cb);

    cb(start, end);

    show_job_profile('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>', 0)

    $('#company_id').on('change', function() {
        let id = $(this).val();
        $.ajax({
            url: '<?php echo base_url() ?>job_profile/get_departments/' + id,
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                set_dat = '  <option value="" disabled selected>Select Department</option>';
                for (i = 0; i < data.length; i++) {
                    set_dat += '<option value="' + data[i].id + '">' + data[i]
                        .department_name + '</option>';
                }
                $('#departement_id').html(set_dat);
                console.log(data);

            }
        });
    });

    $('#departement_id').on('change', function() {
        let id = $(this).val();
        $.ajax({
            url: '<?php echo base_url() ?>job_profile/get_designations/' + id,
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                set_dat = '';
                for (i = 0; i < data.length; i++) {
                    set_dat += '<option value="' + data[i].designation_id + '">' + data[i]
                        .designation_name + '</option>';
                }
                $('#designation_id').html(set_dat);
                doc_type_id = $('#doc_type_id').val();
                div_id = $('#div_id').val();
                company_id = $('#company_id option:selected').val();
                department_id = $('#departement_id option:selected').val();
                if (doc_type_id != "" && div_id != "" && company_id != "" &&
                    department_id != "") {
                    get_no_doc(doc_type_id, div_id, company_id, department_id);
                }
                // get_no_doc(company_id, department_id);
            }
        });
    });

    $('#doc_type_id').on('change', function() {
        doc_type_id = $('#doc_type_id').val();
        div_id = $('#div_id').val();
        company_id = $('#company_id option:selected').val();
        department_id = $('#departement_id option:selected').val();
        if (doc_type_id != "" && div_id != "" && company_id != "" && department_id != "") {
            get_no_doc(doc_type_id, div_id, company_id, department_id);
        }
    });

    $('#div_id').on('change', function() {
        doc_type_id = $('#doc_type_id').val();
        div_id = $('#div_id').val();
        company_id = $('#company_id option:selected').val();
        department_id = $('#departement_id option:selected').val();
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
    sel_dept = $('#sel_dept').val();
    start = $('#datestart').val();
    end = $('#dateend').val();
    show_job_profile(start, end, sel_dept);
}

// function get_no_doc(company_id, department_id) {
function get_no_doc(doc_type_id, div_id, company_id, department_id) {
    $.ajax({
        // url: '<?php echo base_url() ?>job_profile/get_no_doc/' + doc_type_id + '/' + div_id + '/' + company_id + '/' + department_id,
        url: '<?php echo base_url() ?>job_profile/get_no_doc/',
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
    form = $('#form_add_interview');
    doc_type_id = $('#doc_type_id option:selected').val();
    div_id = $('#div_id option:selected').val();
    company_id = $('#company_id option:selected').val();
    departement_id = $('#departement_id option:selected').val();
    designation_id = $('#designation_id option:selected').val();

    add_golongan = $('#add_golongan option:selected').val();
    add_report_to = $('#add_report_to option:selected').val();
    add_prepared_by = $('#add_prepared_by option:selected').val();
    add_release_date = $('#add_release_date').val();
    // employee = $('#employee option:selected').val();

    if (doc_type_id == '') {
        swal({
            type: 'error',
            title: 'Oops...',
            text: 'Please select document type',
        });
    } else if (div_id == '') {
        swal({
            type: 'error',
            title: 'Oops...',
            text: 'Please select division',
        });
    } else if (company_id == '') {
        swal({
            type: 'error',
            title: 'Oops...',
            text: 'Please select company',
        });
    } else if (departement_id == '') {
        swal({
            type: 'error',
            title: 'Oops...',
            text: 'Please select department',
        });
    } else if (designation_id == '') {
        swal({
            type: 'error',
            title: 'Oops...',
            text: 'Please select designation',
        });
    } else if (add_golongan == '') {
        swal({
            type: 'error',
            title: 'Oops...',
            text: 'Please select golongan',
        });
    } else if (add_report_to == '') {
        swal({
            type: 'error',
            title: 'Oops...',
            text: 'Please select report to',
        });
    } else if (add_prepared_by == '') {
        swal({
            type: 'error',
            title: 'Oops...',
            text: 'Please select prepared by',
        });
    } else if (add_release_date == '') {
        swal({
            type: 'error',
            title: 'Oops...',
            text: 'Please choose release date',
        });
    } else {
        swal({
            title: "Save Interview?",
            // text: "",
            type: "info",
            showCancelButton: true,
            // confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, save it!",
            cancelButtonText: "No, cancel!",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?php echo base_url() ?>job_profile/insert_job_profile',
                    type: 'POST',
                    data: form.serialize(),
                    'dataType': 'JSON',
                    success: function(response) {
                        $('#form_add_interview')[0].reset();
                        $('#modal_add_interview').modal('hide');
                        $('#company_id').trigger('change');
                        $('#departement_id').trigger('change');
                        $('#dt_job_profile').DataTable().ajax.reload();
                    }
                });
            } else {
                // swal("Cancelled", "Your data is safe", "error");
            }
        });
    }


}

function show_job_profile(start, end, sel_dept) {

    $('#dt_job_profile').DataTable({
        "searching": true,
        "info": true,
        "paging": true,
        "autoWidth": false,
        "destroy": true,
        "order": [
            [7, "desc"]
        ],
        dom: 'Bfrtip',
        buttons: [{
            extend: 'excelHtml5',
            text: 'Export to Excel',
            filename: 'Interview Job Profile',
            footer: true
        }],

        "drawCallback": function() {
            $('.dt-buttons > .btn').addClass('btn btn-sm btn-info btn-sm');
        },
        "ajax": {
            'url': '<?= base_url("job_profile_dev/data_jp/") ?>' + start + '/' + end + '/' + sel_dept,
            'type': 'GET',
            'dataType': 'json',
        },
        "columns": [{
                'data': 'no_jp',
                render: function(data, type, row, meta) {
                    let print = `<?= base_url('job_profile/print_/') ?>` + data + '/' + row.level_sto;
                    return `  <a href="javascript:void(0);" onclick="delete_jp('${data}')" class="btn btn-danger shadow btn-xs sharp">
										<i class="fa fa-trash"></i></a>
										<a href="${print}" target="_blank" class="btn btn-info shadow btn-xs sharp">
										<i class="fa fa-print"></i></a>`
                }
            },
            {
                'data': 'no_jp',
                render: function(data, type, row, meta) {
                    return `<a href="javascript:void(0);" onclick="edit_jp('${data}')" class="btn btn-primary shadow btn-xs sharp me-1">
										<i class="fas fa-pencil-alt"></i></a> `
                },
                className: 'text-center',
            },
            {
                'data': 'no_jp',
                render: function(data, type, row, meta) {
                    if (row['id_status'] == 1) {
                        return `-`

                    } else {
                        return `<a href="javascript:void(0);" onclick="modal_review('${data}','${row['departement_id']}')" class="btn btn-warning shadow btn-xs sharp me-1">
							<i class="fa fa-star"></i> </a>`
                    }

                },
                className: 'text-center',
            },
            {
                'data': 'no_dok',
            },
            {
                'data': 'jabatan',
            },
            {
                'data': 'posisi',
                render: function(data, type, row, meta) {
                    return `<span> ${data} (Lvl: ${row.level_romawi})</span>`
                }
            },
            {
                'data': 'department_name',
            },
            {
                'data': 'report_to',
            },
            {
                'data': 'preparedBy',
            },
            {
                'data': 'created_at',
            },
            {
                'data': 'release_date',
            },
            {
                'data': 'status_doc',
                render: function(data, type, row, meta) {
                    return `<span class="badge badge-success">${data}</span>`;
                },
                className: 'text-center',
            },
            {
                'data': 'id_status',
                render: function(data, type, row, meta) {
                    if (data == '1') {
                        return `<span class="badge light badge-warning">${row.status}</span>`;
                    } else {
                        return `<span class="badge light badge-info">${row.status}</span>`;
                    }
                },
                className: 'text-center',
            },
            {
                'data': 'note',
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

function delete_jp(no_jp) {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '<?php echo base_url() ?>job_profile/delete_jp',
                type: 'POST',
                data: {
                    'no_jp': no_jp
                },
                'dataType': 'JSON',
                success: function(response) {
                    swal({
                        type: "Success",
                        title: "Success",
                        text: "Interview has been deleted",
                        icon: "success",
                        button: "Ok",
                    });
                    $('#dt_job_profile').DataTable().ajax.reload();
                }
            });
        } else {
            // swal("Cancelled", "Your data is safe", "error");
        }
    });
}

function modal_review(no_jp, department_id) {
    $('#modal_review').modal('show');
    $('#no_jp_rv').val(no_jp);
    $('#label_review').text(no_jp);
    $.ajax({
        url: '<?php echo base_url() ?>job_profile_dev/get_jp',
        type: 'POST',
        data: {
            'no_jp': no_jp
        },
        'dataType': 'JSON',
        success: function(response) {

            $('#no_jp').val(response[0].no_jp);
            $('#prepared_by').val(response[0].preparedBy);
            $('#rv_desig').text(response[0].jabatan);
            $('#rv_no_jp').text(response[0].no_dok);
            $('#rv_grade').text(response[0].posisi + ' (Level: ' + response[0].level_romawi + ')');
            $('#rv_dept').text(response[0].department_name);

        }
    });
    console.log(department_id);

    get_pic(department_id);

    $('#dt_review').DataTable({
        "searching": false,
        "info": false,
        "paging": true,
        "autoWidth": false,
        "destroy": true,
        // "pageLength": 2,
        "lengthChange": false,
        "order": [
            // 	// [7, "desc"]
        ],
        // dom: 'Bfrtip',
        buttons: [{
            extend: 'excelHtml5',
            text: 'Export to Excel',
            // footer: true
        }],
        "ajax": {
            'url': '<?= base_url("job_profile_dev/get_review/") ?>' + no_jp,
            'type': 'GET',
            'dataType': 'json',
        },
        "columns": [{
                'data': 'status',
                render: function(data, type, row, meta) {
                    if (data == 'Sesuai') {

                        return `  <span class="badge badge-primary">${data}
										</span>`
                    } else {
                        return `  <span class="badge badge-danger">${data}
										</span>`
                    }
                },
                className: "text-center",

            },
            {
                'data': 'employee',
            },
            {
                'data': 'review_note',
                "width": "25%",

            },
            {
                'data': 'created_at',
                className: "text-center",
            },
            {
                'data': 'id_review',
                render: function(data, type, row, meta) {
                    return `<button class="btn btn-primary btn-xs" onclick="modal_history('${data}','${row['employee']}')"><li class="fa fa-history"></li> History</button>`;
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
    $('#modal_review').add('show');
    $('#label_history').text(nama);
    // $('#modal_review').addClass('blur');
    $('#dt_history').DataTable({
        "searching": false,
        "info": false,
        "paging": true,
        "autoWidth": false,
        "destroy": true,
        // "pageLength": 2,
        "lengthChange": false,
        "order": [
            // 	// [7, "desc"]
        ],
        // dom: 'Bfrtip',
        buttons: [{
            extend: 'excelHtml5',
            text: 'Export to Excel',
            // footer: true
        }],
        "ajax": {
            'url': '<?= base_url("review/get_history/") ?>' + id_review,
            'type': 'GET',
            'dataType': 'json',
        },
        "columns": [{
                'data': 'review',
                render: function(data, type, row, meta) {
                    if (data == 'Sesuai') {

                        return `  <span class="badge badge-primary">${data}
										</span>`
                    } else {
                        return `  <span class="badge badge-danger">${data}
										</span>`
                    }
                },
                className: "text-center",

            },
            {
                'data': 'review_note',
                "width": "25%",

            },
            {
                'data': 'review_at',
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

function get_pic(id) {
    $.ajax({
        url: '<?php echo base_url() ?>job_profile_dev/get_pic/' + id,
        type: 'GET',
        'dataType': 'JSON',
        success: function(data) {
            console.log(data);

            set_dat = '';
            set_dat += '<option disabled selected>Select PIC</option>';
            for (i = 0; i < data.length; i++) {

                set_dat += '<option value="' + data[i].user_id + ',' + data[i].contact_no + '">' + data[i]
                    .employee_name + '</option>';
            }
            $('#pic_rev').html(set_dat);
        }
    });
}

function edit_jp(no_jp) {
    $('#modal_add_berkas').modal('show');
    aktifkan_ckeditor();
    $.ajax({
        url: '<?php echo base_url() ?>job_profile/get_jp',
        type: 'POST',
        data: {
            'no_jp': no_jp
        },
        'dataType': 'JSON',
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
            // $('#capex').val(response[0].capex);
            // $('#opex').val(response[0].opex);
            $('#bawahan').val(response[0].bawahan);
            $('#area').val(response[0].area);
            // $('#internal_relation').html(response[0].internal_relation);
            // $('#external_relation').html(response[0].external_relation);
            // $('#tujuan_internal').html(response[0].tujuan_internal);
            // $('#tujuan_external').html(response[0].tujuan_external);
            $('#pendidikan').val(response[0].pendidikan);
            $('#pengalaman').html(response[0].pengalaman);
            $('#kompetensi').html(response[0].kompetensi);
            // $('#softkompetensi').html(response[0].softkompetensi);
            // $('#teknikalkompetensi').html(response[0].teknikalkompetensi);
            $('#kpi').html(response[0].kpi);
            $('#authority').html(response[0].authority);
        }
    });

}

function aktifkan_ckeditor() {

    let toolbar_ = [{
            "name": "basicstyles",
            "groups": ["basicstyles"]
        },
        {
            "name": "links",
            "groups": ["links"]
        },
        {
            "name": "paragraph",
            "groups": ["list", "blocks"]
        },
        {
            "name": "document",
            "groups": ["mode"]
        },
        {
            "name": "insert",
            "groups": ["insert"]
        },
        {
            "name": "styles",
            "groups": ["styles"]
        },
        {
            "name": "about",
            "groups": ["about"]
        }
    ];

    // let editor_1 = CKEDITOR.instances['internal_relation'];
    // if (editor_1) {
    // 	editor_1.destroy(true);
    // }
    // editor_1 = CKEDITOR.replace('internal_relation', {
    // 	height: '50%',
    // 	toolbarGroups: toolbar_,
    // 	removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
    // });

    // let editor_2 = CKEDITOR.instances['external_relation'];
    // if (editor_2) {
    // 	editor_2.destroy(true);
    // }
    // editor_2 = CKEDITOR.replace('external_relation', {
    // 	height: '50%',
    // 	toolbarGroups: toolbar_,
    // 	removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
    // });

    // let editor_3 = CKEDITOR.instances['tujuan_internal'];
    // if (editor_3) {
    // 	editor_3.destroy(true);
    // }
    // editor = CKEDITOR.replace('tujuan_internal', {
    // 	height: '50%',
    // 	toolbarGroups: toolbar_,
    // 	removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
    // });

    // let editor_4 = CKEDITOR.instances['tujuan_external'];
    // if (editor_4) {
    // 	editor_4.destroy(true);
    // }
    // editor_4 = CKEDITOR.replace('tujuan_external', {
    // 	height: '50%',
    // 	toolbarGroups: toolbar_,
    // 	removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
    // });

    let editor_5 = CKEDITOR.instances['pengalaman'];
    if (editor_5) {
        editor_5.destroy(true);
    }
    editor_5 = CKEDITOR.replace('pengalaman', {
        height: '50%',
        toolbarGroups: toolbar_,
        removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
    });

    let editor_6 = CKEDITOR.instances['kompetensi'];
    if (editor_6) {
        editor_6.destroy(true);
    }
    editor_6 = CKEDITOR.replace('kompetensi', {
        height: 240,
        toolbarGroups: toolbar_,
        removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
    });

    // let editor_7 = CKEDITOR.instances['softkompetensi'];
    // if (editor_7) {
    // 	editor_7.destroy(true);
    // }
    // editor_7 = CKEDITOR.replace('softkompetensi', {
    // 	height: '50%',
    // 	toolbarGroups: toolbar_,
    // 	removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
    // });

    // let editor_8 = CKEDITOR.instances['teknikalkompetensi'];
    // if (editor_8) {
    // 	editor_8.destroy(true);
    // }
    // editor_8 = CKEDITOR.replace('teknikalkompetensi', {
    // 	height: '50%',
    // 	toolbarGroups: toolbar_,
    // 	removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
    // });

    let editor_9 = CKEDITOR.instances['authority'];
    if (editor_9) {
        editor_9.destroy(true);
    }
    editor_9 = CKEDITOR.replace('authority', {
        height: '50%',
        toolbarGroups: toolbar_,
        removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
    });

    // let editor_10 = CKEDITOR.instances['kpi'];
    // if (editor_10) {
    // 	editor_10.destroy(true);
    // }
    // editor_10 = CKEDITOR.replace('kpi', {
    // 	height: '50%',
    // 	toolbarGroups: toolbar_,
    // 	removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
    // });

}

function update_interview() {
    // internal_relation = CKEDITOR.instances['internal_relation'].getData();
    // external_relation = CKEDITOR.instances['external_relation'].getData();
    // tujuan_internal = CKEDITOR.instances['tujuan_internal'].getData();
    // tujuan_external = CKEDITOR.instances['tujuan_external'].getData();
    pengalaman = CKEDITOR.instances['pengalaman'].getData();
    kompetensi = CKEDITOR.instances['kompetensi'].getData();
    // softkompetensi = CKEDITOR.instances['softkompetensi'].getData();
    // teknikalkompetensi = CKEDITOR.instances['teknikalkompetensi'].getData();
    // kpi 		= CKEDITOR.instances['kpi'].getData();
    authority = CKEDITOR.instances['authority'].getData();


    swal({
        title: "Save Draft?",
        // text: "",
        type: "info",
        showCancelButton: true,
        // confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, save it!",
        cancelButtonText: "No, cancel!",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '<?php echo base_url() ?>job_profile/update_job_profile',
                type: 'POST',
                // data: $('#form_add_berkas').serialize(),
                data: {
                    'no_jp': $('#no_jp').val(),
                    'report_to': $('#input_report_to').val(),
                    'tujuan': $('#tujuan').val(),
                    // 'capex': $('#capex').val(),
                    // 'opex': $('#opex').val(),
                    'bawahan': $('#bawahan').val(),
                    'area': $('#area').val(),
                    'pendidikan': $('#pendidikan').val(),
                    // 'internal_relation': internal_relation,
                    // 'external_relation': external_relation,
                    // 'tujuan_internal': tujuan_internal,
                    // 'tujuan_external': tujuan_external,
                    'pengalaman': pengalaman,
                    'kompetensi': kompetensi,
                    // 'softkompetensi': softkompetensi,
                    // 'teknikalkompetensi': teknikalkompetensi,
                    // 'kpi': kpi,
                    'authority': authority
                },
                success: function(response) {
                    $('#form_add_berkas')[0].reset();
                    $('#modal_add_berkas').modal('hide');
                    swal("Success", "Interview has been updated", "success")
                    $('#dt_job_profile').DataTable().ajax.reload();
                }
            });
        } else {
            // swal("Cancelled", "Your data is safe", "error");
        }
    });
}

function add_job_task() {
    const no_jp = $('#no_jp').val();
    const designation_id = $('#designation_id_').val();
    $('#modal_add_resp').modal('show');

    $('#no_jp_resp').val(no_jp);
    $('#id_designation_resp').val(designation_id);
    $('#tugas').focus()
    let aktifitas_ck = CKEDITOR.instances['aktifitas'];
    if (aktifitas_ck) {
        aktifitas_ck.destroy(true);
    }
    aktifitas_ck = CKEDITOR.replace('aktifitas', {
        height: '50%',
        toolbarGroups: [{
                "name": "basicstyles",
                "groups": ["basicstyles"]
            },
            {
                "name": "links",
                "groups": ["links"]
            },
            {
                "name": "paragraph",
                "groups": ["list", "blocks"]
            },
            {
                "name": "document",
                "groups": ["mode"]
            },
            {
                "name": "insert",
                "groups": ["insert"]
            },
            {
                "name": "styles",
                "groups": ["styles"]
            },
            {
                "name": "about",
                "groups": ["about"]
            }
        ],
        removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
    });
}

function save_job_task() {
    aktifitas = CKEDITOR.instances['aktifitas'].getData();
    if ($('#tugas').val() == '') {
        swal("Error", "Tugas Harus diisi", "error")
    } else if (aktifitas == '') {
        swal("Error", "Aktifitas diisi", "error")
    } else {
        swal({
            title: "Add Scope Responsibilty?",
            // text: "",
            type: "info",
            showCancelButton: true,
            // confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, save it!",
            cancelButtonText: "No, cancel!",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?php echo base_url() ?>job_profile/add_responsibility',
                    type: 'POST',
                    // data: $('#form_add_berkas').serialize(),
                    data: {
                        'no_jp': $('#no_jp_resp').val(),
                        'designation_id': $('#id_designation_resp').val(),
                        'tugas': $('#tugas').val(),
                        'aktifitas': aktifitas
                    },
                    success: function(response) {
                        $('#form_add_resp')[0].reset();
                        $('#modal_add_resp').modal('hide');
                        swal("Success", "Responsibility has been added", "success")
                    }
                });
            } else {
                // swal("Cancelled", "Your data is safe", "error");
            }
        });
    }

}

function view_job_task() {
    const no_jp = $('#no_jp').val();
    $('#modal_view_resp').modal('show');

    $('#dt_job_task').DataTable({
        "searching": false,
        "info": false,
        "paging": true,
        "autoWidth": false,
        "destroy": true,
        "pageLength": 2,
        "lengthChange": false,
        "order": [
            // [7, "desc"]
        ],
        // dom: 'Bfrtip',
        // buttons: [{
        //     extend: 'excelHtml5',
        //     text: 'Export to Excel',
        //     footer: true
        // }],
        "ajax": {
            'url': '<?= base_url("job_profile/get_job_task/") ?>' + no_jp,
            'type': 'GET',
            'dataType': 'json',
        },
        "columns": [{
                'data': 'id',
                render: function(data, type, row, meta) {
                    return `  <a href="javascript:void(0);" onclick="delete_job_task('${data}')" class="btn btn-danger shadow btn-xs sharp">
										<i class="fa fa-trash"></i></a>`
                },
                "width": "5%",
                className: "text-center"
            },

            {
                'data': 'tugas',
            },
            {
                'data': 'aktifitas',
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

function delete_job_task(id) {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '<?php echo base_url() ?>job_profile/delete_job_task',
                type: 'POST',
                data: {
                    'id': id
                },
                'dataType': 'JSON',
                success: function(response) {
                    swal({
                        type: "Success",
                        title: "Success",
                        text: "Job Task has been deleted",
                        icon: "success",
                        button: "Ok",
                    });
                    $('#dt_job_task').DataTable().ajax.reload();
                }
            });
        } else {
            // swal("Cancelled", "Your data is safe", "error");
        }
    });
}

function add_kpi() {
    const no_jp = $('#no_jp').val();
    const designation_id = $('#designation_id_').val();
    $('#modal_add_kpi').modal('show');

    $('#no_jp_kpi').val(no_jp);
    $('#id_designation_kpi').val(designation_id);
    $('#tugas').focus()
    let nama_kpi_ck = CKEDITOR.instances['nama_kpi'];
    if (nama_kpi_ck) {
        nama_kpi_ck.destroy(true);
    }
    nama_kpi_ck = CKEDITOR.replace('nama_kpi', {
        height: '50%',
        toolbarGroups: [{
                "name": "basicstyles",
                "groups": ["basicstyles"]
            },
            {
                "name": "links",
                "groups": ["links"]
            },
            {
                "name": "paragraph",
                "groups": ["list", "blocks"]
            },
            {
                "name": "document",
                "groups": ["mode"]
            },
            {
                "name": "insert",
                "groups": ["insert"]
            },
            {
                "name": "styles",
                "groups": ["styles"]
            },
            {
                "name": "about",
                "groups": ["about"]
            }
        ],
        removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
    });
}

function save_kpi() {
    nama_kpi = CKEDITOR.instances['nama_kpi'].getData();
    if ($('#bobot_kpi').val() == '') {
        swal("Error", "Bobot harus diisi", "error")
    } else if (nama_kpi == '') {
        swal("Error", "Nama KPI harus diisi", "error")
    } else {
        swal({
            title: "Add Scope of KPI?",
            // text: "",
            type: "info",
            showCancelButton: true,
            // confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, save it!",
            cancelButtonText: "No, cancel!",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?php echo base_url() ?>job_profile/add_kpi',
                    type: 'POST',
                    // data: $('#form_add_berkas').serialize(),
                    data: {
                        'no_jp': $('#no_jp_kpi').val(),
                        'designation_id': $('#id_designation_kpi').val(),
                        'bobot_kpi': $('#bobot_kpi').val(),
                        'nama_kpi': nama_kpi
                    },
                    success: function(response) {
                        $('#form_add_kpi')[0].reset();
                        $('#modal_add_kpi').modal('hide');
                        swal("Success", "KPI has been added", "success")
                    }
                });
            } else {
                // swal("Cancelled", "Your data is safe", "error");
            }
        });
    }

}

function view_kpi() {
    const no_jp = $('#no_jp').val();
    $('#modal_view_kpi').modal('show');

    $('#dt_kpi').DataTable({
        "searching": false,
        "info": false,
        "paging": true,
        "autoWidth": false,
        "destroy": true,
        "pageLength": 2,
        "lengthChange": false,
        "order": [
            // [7, "desc"]
        ],
        // dom: 'Bfrtip',
        // buttons: [{
        //     extend: 'excelHtml5',
        //     text: 'Export to Excel',
        //     footer: true
        // }],
        "ajax": {
            'url': '<?= base_url("job_profile/get_kpi/") ?>' + no_jp,
            'type': 'GET',
            'dataType': 'json',
        },
        "columns": [{
                'data': 'id',
                render: function(data, type, row, meta) {
                    return `  <a href="javascript:void(0);" onclick="delete_kpi('${data}')" class="btn btn-danger shadow btn-xs sharp">
										<i class="fa fa-trash"></i></a>`
                },
                "width": "5%",
                className: "text-center"
            },

            {
                'data': 'kpi',
            },
            {
                'data': 'bobot',
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

function delete_kpi(id) {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '<?php echo base_url() ?>job_profile/delete_kpi',
                type: 'POST',
                data: {
                    'id': id
                },
                'dataType': 'JSON',
                success: function(response) {
                    swal({
                        type: "Success",
                        title: "Success",
                        text: "KPI has been deleted",
                        icon: "success",
                        button: "Ok",
                    });
                    $('#dt_kpi').DataTable().ajax.reload();
                }
            });
        } else {
            // swal("Cancelled", "Your data is safe", "error");
        }
    });
}

function add_internal() {
    const no_jp = $('#no_jp').val();
    const designation_id = $('#designation_id_').val();
    $('#modal_add_internal').modal('show');

    $('#no_jp_internal').val(no_jp);
    $('#id_designation_internal').val(designation_id);
    $('#tugas').focus();
    let tujuan_internal_ck = CKEDITOR.instances['tujuan_internal'];
    if (tujuan_internal_ck) {
        tujuan_internal_ck.destroy(true);
    }
    tujuan_internal_ck = CKEDITOR.replace('tujuan_internal', {
        height: '50%',
        toolbarGroups: [{
                "name": "basicstyles",
                "groups": ["basicstyles"]
            },
            {
                "name": "links",
                "groups": ["links"]
            },
            {
                "name": "paragraph",
                "groups": ["list", "blocks"]
            },
            {
                "name": "document",
                "groups": ["mode"]
            },
            {
                "name": "insert",
                "groups": ["insert"]
            },
            {
                "name": "styles",
                "groups": ["styles"]
            },
            {
                "name": "about",
                "groups": ["about"]
            }
        ],
        removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
    });
}

function save_internal() {
    tujuan_internal = CKEDITOR.instances['tujuan_internal'].getData();
    if ($('#hubungan_internal').val() == '') {
        swal("Error", "Hubungan internal harus diisi", "error")
    } else if (tujuan_internal == '') {
        swal("Error", "Tujuan internal harus diisi", "error")
    } else {
        swal({
            title: "Add Scope of Relationship Internal?",
            // text: "",
            type: "info",
            showCancelButton: true,
            // confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, save it!",
            cancelButtonText: "No, cancel!",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?php echo base_url() ?>job_profile/add_internal',
                    type: 'POST',
                    // data: $('#form_add_berkas').serialize(),
                    data: {
                        'no_jp': $('#no_jp_internal').val(),
                        'designation_id': $('#id_designation_internal').val(),
                        'hubungan_internal': $('#hubungan_internal').val(),
                        'tujuan_internal': tujuan_internal
                    },
                    success: function(response) {
                        $('#form_add_internal')[0].reset();
                        $('#modal_add_internal').modal('hide');
                        swal("Success", "Relationship Internal has been added", "success")
                    }
                });
            } else {
                // swal("Cancelled", "Your data is safe", "error");
            }
        });
    }

}

function view_internal() {
    const no_jp = $('#no_jp').val();
    $('#modal_view_internal').modal('show');

    $('#dt_internal').DataTable({
        "searching": false,
        "info": false,
        "paging": true,
        "autoWidth": false,
        "destroy": true,
        "pageLength": 2,
        "lengthChange": false,
        "order": [
            // [7, "desc"]
        ],
        // dom: 'Bfrtip',
        // buttons: [{
        //     extend: 'excelHtml5',
        //     text: 'Export to Excel',
        //     footer: true
        // }],
        "ajax": {
            'url': '<?= base_url("job_profile/get_internal/") ?>' + no_jp,
            'type': 'GET',
            'dataType': 'json',
        },
        "columns": [{
                'data': 'id',
                render: function(data, type, row, meta) {
                    return `  <a href="javascript:void(0);" onclick="delete_internal('${data}')" class="btn btn-danger shadow btn-xs sharp">
										<i class="fa fa-trash"></i></a>`
                },
                "width": "5%",
                className: "text-center"
            },

            {
                'data': 'tugas',
            },
            {
                'data': 'tujuan',
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

function delete_internal(id) {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '<?php echo base_url() ?>job_profile/delete_internal',
                type: 'POST',
                data: {
                    'id': id
                },
                'dataType': 'JSON',
                success: function(response) {
                    swal({
                        type: "Success",
                        title: "Success",
                        text: "Relationship internal has been deleted",
                        icon: "success",
                        button: "Ok",
                    });
                    $('#dt_internal').DataTable().ajax.reload();
                }
            });
        } else {
            // swal("Cancelled", "Your data is safe", "error");
        }
    });
}

function add_external() {
    const no_jp = $('#no_jp').val();
    const designation_id = $('#designation_id_').val();
    $('#modal_add_external').modal('show');

    $('#no_jp_external').val(no_jp);
    $('#id_designation_external').val(designation_id);
    $('#tugas').focus();
    let tujuan_external_ck = CKEDITOR.instances['tujuan_external'];
    if (tujuan_external_ck) {
        tujuan_external_ck.destroy(true);
    }
    tujuan_external_ck = CKEDITOR.replace('tujuan_external', {
        height: '50%',
        toolbarGroups: [{
                "name": "basicstyles",
                "groups": ["basicstyles"]
            },
            {
                "name": "links",
                "groups": ["links"]
            },
            {
                "name": "paragraph",
                "groups": ["list", "blocks"]
            },
            {
                "name": "document",
                "groups": ["mode"]
            },
            {
                "name": "insert",
                "groups": ["insert"]
            },
            {
                "name": "styles",
                "groups": ["styles"]
            },
            {
                "name": "about",
                "groups": ["about"]
            }
        ],
        removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
    });
}

function save_external() {
    tujuan_external = CKEDITOR.instances['tujuan_external'].getData();
    if ($('#hubungan_external').val() == '') {
        swal("Error", "Hubungan external harus diisi", "error")
    } else if (tujuan_external == '') {
        swal("Error", "Tujuan external harus diisi", "error")
    } else {
        swal({
            title: "Add Scope of Relationship External?",
            // text: "",
            type: "info",
            showCancelButton: true,
            // confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, save it!",
            cancelButtonText: "No, cancel!",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?php echo base_url() ?>job_profile/add_external',
                    type: 'POST',
                    // data: $('#form_add_berkas').serialize(),
                    data: {
                        'no_jp': $('#no_jp_external').val(),
                        'designation_id': $('#id_designation_external').val(),
                        'hubungan_external': $('#hubungan_external').val(),
                        'tujuan_external': tujuan_external
                    },
                    success: function(response) {
                        $('#form_add_external')[0].reset();
                        $('#modal_add_external').modal('hide');
                        swal("Success", "Relationship External has been added", "success")
                    }
                });
            } else {
                // swal("Cancelled", "Your data is safe", "error");
            }
        });
    }

}

function view_external() {
    const no_jp = $('#no_jp').val();
    $('#modal_view_external').modal('show');

    $('#dt_external').DataTable({
        "searching": false,
        "info": false,
        "paging": true,
        "autoWidth": false,
        "destroy": true,
        "pageLength": 2,
        "lengthChange": false,
        "order": [
            // [7, "desc"]
        ],
        // dom: 'Bfrtip',
        // buttons: [{
        //     extend: 'excelHtml5',
        //     text: 'Export to Excel',
        //     footer: true
        // }],
        "ajax": {
            'url': '<?= base_url("job_profile/get_external/") ?>' + no_jp,
            'type': 'GET',
            'dataType': 'json',
        },
        "columns": [{
                'data': 'id',
                render: function(data, type, row, meta) {
                    return `  <a href="javascript:void(0);" onclick="delete_external('${data}')" class="btn btn-danger shadow btn-xs sharp">
										<i class="fa fa-trash"></i></a>`
                },
                "width": "5%",
                className: "text-center"
            },

            {
                'data': 'tugas',
            },
            {
                'data': 'tujuan',
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

function delete_external(id) {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '<?php echo base_url() ?>job_profile/delete_external',
                type: 'POST',
                data: {
                    'id': id
                },
                'dataType': 'JSON',
                success: function(response) {
                    swal({
                        type: "Success",
                        title: "Success",
                        text: "Relationship External has been deleted",
                        icon: "success",
                        button: "Ok",
                    });
                    $('#dt_external').DataTable().ajax.reload();
                }
            });
        } else {
            // swal("Cancelled", "Your data is safe", "error");
        }
    });
}
$('#pic_rev').change(function() {
    $('#set_pic').attr('disabled', false);
});

function set_pic() {
    var designation = $('#rv_desig').text();
    var departement = $('#rv_dept').text();
    var no_doc = $('#rv_no_jp').text();
    var dept = $('#rv_dept').text();
    var no_hp = $("#pic_rev").val();
    var data_pic = $('#pic_rev').val().split(",");
    // console.log(option);    
    var no_jp = $("#no_jp_rv").val();
    var nama = $("#pic_rev option:selected").text();
    var prepared = $('#prepared_by').val();
    swal({
        title: "Set dan kirim Notifikasi ke " + `${nama}` + "?",
        type: "info",
        showCancelButton: true,
        // confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No, cancel!",
        closeOnConfirm: false,
        closeOnCancel: false
    }).then((result) => {
        if (result.value) {
            send_notifikasi_review(no_jp, designation, no_doc, dept, no_hp, departement, data_pic, prepared);
        } else {
            // swal("Cancelled", "Your data is safe", "error");
        }
    });

}

function send_notifikasi_review(no_jp, designation, no_doc, dept, no_hp, departement, data_pic, prepared) {
    tgl = '<?= date('Y-m-d') ?>';
    link = '🔗 <?= base_url('/review/index/') ?>' + no_jp + '/' + data_pic[0];
    data_review = ``;
    data_review +=
        `\n📑No Doc : *${no_doc}*\n🔑Departemen : *${departement}*\n👔Job Position : *${designation}*\n\n`;

    msg =
        `📢 Alert!!! Please Review, make sure your feedback is helpful\n\n${data_review}${link}\nMohon untuk review dengan baik dan benar\n\n👤Prepared By : ${prepared}\n🕐Requested At : ${tgl}`;

    list_phone = [
        '083824955357', // sidik
        // data_pic[1], // data pic yang di pilih
    ];
    // console.info(msg)

    //list phone it ke wa sendiri
    send_wa(list_phone, msg);
    // if (id_user != 1) {
    //     send_wa(list_phone, msg);
    // }



}
</script>