<script src="<?php echo base_url() ?>assets/js/daterangepicker.js"></script>
<script src="<?= base_url() ?>assets/vendor/ckeditor/ckeditor.js"></script>
<!-- Datepicker -->
<script src="<?php echo base_url(); ?>assets/datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/fancybox/jquery.fancybox.min.js"></script>
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/sweetalert/js/sweetalert.min.js"></script> -->


<!-- Datatable -->
<script src="<?php echo base_url() ?>assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/old/libs/datatables/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/old/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/old/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/old/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>

<script src="<?php echo base_url() ?>assets/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/moment/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/daterangepicker.js"></script>


<script type="text/javascript">
$(document).ready(function() {
    $('[data-toggle="popover"]').popover({
        html: true,
        sanitize: false,
    })

    $('.select2').select2();
    enable_ckeditor();

    // $(document).on('show.bs.modal', '.modal', function() {
    //     var zIndex = 1040 + (10 * $('.modal:visible').length);
    //     $(this).css('z-index', zIndex);
    //     setTimeout(function() {
    //         $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass(
    //             'modal-stack');
    //     }, 0);

    // });
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
                // console.log(data);

            }
        });
    });

    $('#type_department_req').change(function() {
        type = $(this).val();

        if (type == 1) {
            $('.single_department_req').show();
            $('.multi_department_req').hide();
        } else if (type == 2) {
            $('.single_department_req').hide();
            $('.multi_department_req').show();

            $("#select_department_multi_req > option").prop("selected", false);
            $("#select_department_multi_req").trigger("change");
        } else {
            $('.single_department_req').hide();
            $('.multi_department_req').show();

            $("#select_department_multi_req > option").prop("selected", true);
            $("#select_department_multi_req").trigger("change");
        }
    });
    $('#type_department').change(function() {
        type = $(this).val();

        if (type == 1) {
            $('.single_department').show();
            $('.multi_department').hide();
        } else if (type == 2) {
            $('.single_department').hide();
            $('.multi_department').show();

            $("#select_department_multi > option").prop("selected", false);
            $("#select_department_multi").trigger("change");
        } else {
            $('.single_department').hide();
            $('.multi_department').show();

            $("#select_department_multi > option").prop("selected", true);
            $("#select_department_multi").trigger("change");
        }
    });

    $('#type_department_edit').change(function() {
        type = $(this).val();

        if (type == 1) {
            $('.single_department_edit').show();
            $('.multi_department_edit').hide();
        } else if (type == 2) {
            $('.single_department_edit').hide();
            $('.multi_department_edit').show();

            $("#select_department_multi_edit > option").prop("selected", false);
            $("#select_department_multi_edit").trigger("change");
        } else {
            $('.single_department_edit').hide();
            $('.multi_department_edit').show();

            $("#select_department_multi_edit > option").prop("selected", true);
            $("#select_department_multi_edit").trigger("change");
        }
    });

    url = "<?= site_url('sop_dev/data_sop') ?>";
    $('#table_sop').DataTable({
        "destroy": true,
        "pageLength": 10,
        "searching": true,
        "ordering": true,
        "autoWidth": false,
        "info": true,
        "lengthChange": false,
        // "order": [[ 1, "desc"]],
        "dom": 'Bfrtip',
        buttons: [{
            extend: 'excelHtml5',
            text: 'Export to Excel',
            footer: true
        }],
        "ajax": {
            "dataType": 'json',
            "url": url,
        },
        "columns": [
            {
                "data": "id_sop",
                'render': function(data, type, row, meta) {
                    if(row['status_review'] == null){

                        return `<a href="javascript:void(0);" onclick="modal_review('${data}','${row['department']}')" class="btn btn-xs btn-warning sharp shadow">
                                <i class="fa fa-star"></i> </a> Waiting`;
                    }else{

                        return `<a href="javascript:void(0);" onclick="modal_review('${data}','${row['department']}')" class="btn btn-xs btn-warning sharp shadow">
                                <i class="fa fa-star"></i> </a> <span class="badge badge-default">${row['status_review']}</span>`;
                    }


                },
                "className": "text-center"
                
                
            },
            {
                "data": "company_name"
            },
            {
                "data": "department_name",
                "width": "20%",
            },
            {
                "data": "designation_name"

            },
            {
                "data": "jenis_doc"
            },
            {
                "data": "no_doc",
            },
            {
                "data": "tgl_terbit"
            },
            {
                "data": "tgl_update"
            },
            {
                "data": "nama_dokumen"
            },
            {
                "data": "file",
                "render": function(data) {
                    if (data == null || data == '') {
                        return '<span class="label label-danger">Waiting</span>';
                    } else {
                        return '<span class="label label-primary">Done</span>';
                    }
                }
            },
            {
                "data": "file",
                "render": function(data) {
                    if (data == null || data == '') {
                        return '';
                    } else {
                        return '<a data-fancybox="gallery" href="<?= base_url() ?>assets/files/' +
                            data +
                            '" class="label label-info gallery"><i class="ti-image"></i></a>'
                    }
                }
            },
            {
                "data": "word",
                "render": function(data) {
                    if (data == null) {
                        return '';
                    } else {
                        return '<a target="blank" href="<?= base_url() ?>assets/files/' + data +
                            '" class="label label-info"><i class="ti-file"></i></a>'
                    }
                }
            },
            {
                'data': 'penjelasan'
            },
            {
                'data': 'jadwal_diskusi'
            },
            {
                'data': 'draft',
                "render": function(data) {
                    if (data == null) {
                        return '';
                    } else {
                        return '<a target="blank" href="<?= base_url() ?>assets/files/' + data +
                            '" class="label label-info"><i class="ti-file"></i></a>'
                    }
                }
            },
            {
                "data": "created_by"
            },
            {
                "data": "id_parent",
                "render": function(data, type, row) {
                    if (data == null) {
                        return `<a class="del_sop label label-danger"` +
                            `data-id_sop="` + row['id_sop'] + `"` +
                            `href="javascript:void(0)"><i class="ti-trash"></i></a>` +

                            `<a class="edit_sop label label-warning"` +
                            `data-id_sop="` + row['id_sop'] + `"` +
                            `data-company_id="` + row['company_id'] + `"` +
                            `data-company_name="` + row['company_name'] + `"` +
                            `data-type_department="` + row['type_department'] + `"` +
                            `data-department_id="` + row['department_id'] + `"` +
                            `data-department_name="` + row['department_name'] + `"` +
                            `data-designation_id="` + row['designation_id'] + `"` +
                            `data-designation_name="` + row['designation_name'] + `"` +
                            `data-jenis_doc="` + row['jenis_doc'] + `"` +
                            `data-no_doc="` + row['no_doc'] + `"` +
                            `data-tgl_terbit="` + row['tgl_terbit'] + `"` +
                            `data-tgl_update="` + row['tgl_update'] + `"` +
                            `data-start_date="` + row['start_date'] + `"` +
                            `data-end_date="` + row['end_date'] + `"` +
                            `data-nama_dokumen="` + row['nama_dokumen'] + `"` +
                            `data-file="` + row['file'] + `"` +
                            `data-word="` + row['word'] + `"` +
                            `href="javascript:void(0)">Edit</a>` +

                            `<a class="add_link label label-success"` +
                            `data-id_sop="` + row['id_sop'] + `"` +
                            `data-nama_dokumen="` + row['nama_dokumen'] + `"` +
                            `href="javascript:void(0)">Relasi</a>`;
                    } else {
                        return `<a class="del_sop label label-danger"` +
                            `data-id_sop="` + row['id_sop'] + `"` +
                            `href="javascript:void(0)"><i class="ti-trash"></i></a>` +

                            `<a class="edit_sop label label-warning"` +
                            `data-id_sop="` + row['id_sop'] + `"` +
                            `data-company_id="` + row['company_id'] + `"` +
                            `data-company_name="` + row['company_name'] + `"` +
                            `data-type_department="` + row['type_department'] + `"` +
                            `data-department_id="` + row['department_id'] + `"` +
                            `data-department_name="` + row['department_name'] + `"` +
                            `data-designation_id="` + row['designation_id'] + `"` +
                            `data-designation_name="` + row['designation_name'] + `"` +
                            `data-jenis_doc="` + row['jenis_doc'] + `"` +
                            `data-no_doc="` + row['no_doc'] + `"` +
                            `data-tgl_terbit="` + row['tgl_terbit'] + `"` +
                            `data-tgl_update="` + row['tgl_update'] + `"` +
                            `data-start_date="` + row['start_date'] + `"` +
                            `data-end_date="` + row['end_date'] + `"` +
                            `data-nama_dokumen="` + row['nama_dokumen'] + `"` +
                            `data-id_pic="` + row['id_pic'] + `"` +
                            `data-no_hp="` + row['no_hp'] + `"` +
                            `data-word="` + row['word'] + `"` +
                            `href="javascript:void(0)">Edit</a>` +

                            `<a class="add_link label label-success"` +
                            `data-id_sop="` + row['id_sop'] + `"` +
                            `data-nama_dokumen="` + row['nama_dokumen'] + `"` +
                            `href="javascript:void(0)">Relasi</a>` +

                            `<a style="background-color: #79a3ff;" class="detail label label-success"` +
                            `data-id_sop="` + row['id_sop'] + `"` +
                            `href="javascript:void(0)">Detail</a>`;
                    }
                }
            }
        ]
    });
});

function enable_ckeditor() {
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
            "name": "insert",
            "groups": ["insert"]
        },
        {
            "name": "styles",
            "groups": ["styles"]
        },

    ];
    let editor_5 = CKEDITOR.instances['pengalaman'];
    if (editor_5) {
        editor_5.destroy(true);
    }
    editor_5 = CKEDITOR.replace('pengalaman', {

        height: '130px',
        toolbarGroups: toolbar_,
        removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
    });

    let editor_6 = CKEDITOR.instances['kompetensi'];
    if (editor_6) {
        editor_6.destroy(true);
    }
    editor_6 = CKEDITOR.replace('kompetensi', {
        height: '205px',
        toolbarGroups: toolbar_,
        removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
    });
    let editor_9 = CKEDITOR.instances['authority'];
    if (editor_9) {
        editor_9.destroy(true);
    }
    editor_9 = CKEDITOR.replace('authority', {
        toolbarGroups: toolbar_,
        removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord'
    });
}

function modal_history(id_review, nama) {
    $('#modal_history').modal('show');
    // $('#modal_review').add('show');
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
    console.log(id);

    $.ajax({
        url: '<?php echo base_url() ?>sop_dev/get_pic/',
        data: {
            id: id
        },
        type: 'POST',
        'dataType': 'JSON',
        success: function(data) {
            // console.log(data);

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

function modal_review(id_sop, department_id) {
    $('#modal_review').modal('show');
    $('#no_jp_rv').val(id_sop)
    $.ajax({
        url: '<?php echo base_url() ?>sop_dev/get_sop_review',
        type: 'POST',
        data: {
            'id_sop': id_sop
        },
        'dataType': 'JSON',
        success: function(response) {
            $('#no_jp').val(response[0].id_sop);
            $('#rv_desig').text(response[0].designation_name);
            $('#rv_no_jp').text(response[0].nama_dokumen);
            $('#rv_grade').text(response[0].jenis_doc);
            $('#rv_dept').text(response[0].department_name);
            $('#prepared_by').val(response[0].created_by)



        }
    });
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
            'url': '<?= base_url("sop_dev/get_review/") ?>' + id_sop,
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

$('#add_sop').on('click', function() {
    $('#modal_add').modal('show');
    $('.view_sub_divisi').hide();
    // $('.view_sub_sub_divisi').hide();
    $('#memo_add').hide();
});

$('#select_company').change(function() {
    var id = $(this).val();

    $.ajax({
        url: "<?php echo site_url('sop/get_departments'); ?>",
        method: "POST",
        data: {
            id: id
        },
        async: true,
        dataType: 'json',
        success: function(data) {

            var html = '';
            var html_multi = '';
            var i;
            html += '<option value="" disabled selected>-- Select Department --</option>';
            for (i = 0; i < data.length; i++) {
                html += '<option value=' + data[i].department_id + '>' + data[i].department_name +
                    '</option>';
                html_multi += '<option value=' + data[i].department_id + '>' + data[i]
                    .department_name + '</option>';
            }
            $('#select_department').html(html);
            $('#select_department_multi').html(html_multi);
            $('#tot_sd').val(data.length);
        }
    });
    return false;
});


$('#select_department').change(function() {
    var id = $(this).val();
    console.log(id);
    $.ajax({
        url: "<?php echo site_url('sop/get_designations'); ?>",
        method: "POST",
        data: {
            id: id
        },
        async: true,
        dataType: 'json',
        success: function(data1) {

            console.log(data1);

            var html1 = '';
            var i;
            html1 += '<option value="" disabled selected>-- Select Designations --</option>';
            for (i = 0; i < data1.length; i++) {
                html1 += '<option value=' + data1[i].designation_id + '>' + data1[i]
                    .designation_name + '</option>';
            }
            $('#select_designation').html(html1);
            $('#tot_ssd').val(data1.length);

        }
    });
});
$('#select_department_req').change(function() {
    var id = $(this).val();
    console.log(id);
    $.ajax({
        url: "<?php echo site_url('sop/get_designations'); ?>",
        method: "POST",
        data: {
            id: id
        },
        async: true,
        dataType: 'json',
        success: function(data1) {

            console.log(data1);

            var html1 = '';
            var i;
            html1 += '<option value="" disabled selected>-- Select Designations --</option>';
            for (i = 0; i < data1.length; i++) {
                html1 += '<option value=' + data1[i].designation_id + '>' + data1[i]
                    .designation_name + '</option>';
            }
            $('#select_designation_req').html(html1);
            $('#tot_ssd_req').val(data1.length);

        }
    });
});

$('#tbt').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true
});

$('#upd').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true
});

$('#tbt_e').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true
});

$('#upd_e').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true
});

$('#start_date').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true
});

$('#end_date').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true
});

$('#start_date_e').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true
});

$('#end_date_e').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true
});

$('#save_add').on('click', function() {

    tot_sd = $('#tot_sd').val();

    tot_ssd = $('#tot_ssd').val();

    company = $('select[name="company"]');
    department = $('select[name="department"]');
    designation = $('select[name="designation"]');
    jenis_doc = $('select[name="jenis_doc"]');
    no_doc = $('input[name="no_doc"]');
    tgl_terbit = $('input[name="tgl_terbit"]');
    tgl_update = $('input[name="tgl_update"]');
    start_date = $('input[name="start_date"]');
    end_date = $('input[name="end_date"]');
    nama_doc = $('input[name="nama_doc"]');
    file = $('input[name="file"]');
    word = $('input[name="word"]');

    if (company.val() == null) {
        company.addClass('is-invalid');
        company.focus();
    }
    //  else if (tot_sd > 1 && department.val() == null) {
    //     divisi.removeClass('is-invalid');

    //     department.addClass('is-invalid');
    //     department.focus();
    // } else if (tot_ssd > 1 && designation.val() == null) {
    //     department.removeClass('is-invalid');

    //     designation.addClass('is-invalid');
    //     designation.focus();
    // }
    else if (jenis_doc.val() == null) {
        designation.removeClass('is-invalid');

        jenis_doc.addClass('is-invalid');
        jenis_doc.focus();
    } else if (no_doc.val() == "") {
        jenis_doc.removeClass('is-invalid');

        no_doc.addClass('is-invalid');
        no_doc.focus();
    } else if (tgl_terbit.val() == "") {
        no_doc.removeClass('is-invalid');

        tgl_terbit.addClass('is-invalid');
        tgl_terbit.focus();
    } else if (tgl_update.val() == "") {
        tgl_terbit.removeClass('is-invalid');

        tgl_update.addClass('is-invalid');
        tgl_update.focus();
    } else if (jenis_doc.val() == "Memo" && start_date.val() == "") {
        tgl_update.removeClass('is-invalid');

        start_date.addClass('is-invalid');
        start_date.focus();
    } else if (jenis_doc.val() == "Memo" && end_date.val() == "") {
        start_date.removeClass('is-invalid');

        end_date.addClass('is-invalid');
        end_date.focus();
    } else if (nama_doc.val() == "") {
        end_date.removeClass('is-invalid');

        nama_doc.addClass('is-invalid');
        nama_doc.focus();
    } else if (file.val() == "") {
        nama_doc.removeClass('is-invalid');

        file.addClass('is-invalid');
        file.focus();
    } else {
        company.removeClass('is-invalid');
        jenis_doc.removeClass('is-invalid');
        no_doc.removeClass('is-invalid');
        tgl_terbit.removeClass('is-invalid');
        tgl_update.removeClass('is-invalid');
        start_date.removeClass('is-invalid');
        end_date.removeClass('is-invalid');
        nama_doc.removeClass('is-invalid');
        file.removeClass('is-invalid');

        $('#modal_progress').modal({
            backdrop: 'static',
            keyboard: false
        });

        var formdata = new FormData($('#form_sop')[0]);
        url = "<?php echo site_url('sop/insert') ?>";

        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressUpload, false);
        ajax.open("POST", url, true);
        ajax.send(formdata);
        ajax.onload = function() {
            console.log('DONE: ', ajax.status);
            if (ajax.status == 200) {
                $("#modal_add").modal('hide');
                $("#modal_progress").modal('hide');
                $("#form_sop")[0].reset();
                document.getElementById("bar_upload_1").style.width = '';
                document.getElementById("status_upload_1").innerHTML = '';
                $('#table_sop').DataTable().ajax.reload();
                Swal.fire({
                    title: "Success!",
                    text: "Data berhasil disimpan",
                    type: "success",
                    confirmButtonText: "Close"
                });
                // location.reload();
            }
        };
    }


});


$('#table_sop').on('click', '.del_sop', function() {
    id = $(this).data('id_sop');

    $.ajax({
        url: "<?= site_url('sop/delete_sop') ?>",
        type: 'POST',
        data: {
            id: id
        },
        success: function(result) {
            Swal.fire({
                title: "Success!",
                text: "Data berhasil dihapus",
                type: "success",
                confirmButtonText: "OK"
            });
            $('#table_sop').DataTable().ajax.reload();
        }
    });
});


$('#select_company_req').change(function() {
    var id = $(this).val();
    // console.log('ada perubahan com');

    $.ajax({
        url: "<?php echo site_url('sop/get_departments'); ?>",
        method: "POST",
        data: {
            id: id
        },
        async: true,
        dataType: 'json',
        success: function(data) {
            // console.log(data);

            var html = '';
            var html_multi = '';
            var i;
            html = '<option value="" selected disabled>-- Select Department --</option>';
            for (i = 0; i < data.length; i++) {
                html += '<option value=' + data[i].department_id + '>' + data[i].department_name +
                    '</option>';
                html_multi += '<option value=' + data[i].department_id + '>' + data[i]
                    .department_name + '</option>';
            }
            $('#select_department_req').html(html);
            $('#select_department_multi_req').html(html_multi);

        }
    });
    return false;
});
$('#select_company_edit').change(function() {
    var id = $(this).val();

    $.ajax({
        url: "<?php echo site_url('sop/get_departments'); ?>",
        method: "POST",
        data: {
            id: id
        },
        async: true,
        dataType: 'json',
        success: function(data) {

            var html = '';
            var html_multi = '';
            var i;
            for (i = 0; i < data.length; i++) {
                html += '<option value=' + data[i].department_id + '>' + data[i].department_name +
                    '</option>';
                html_multi += '<option value=' + data[i].department_id + '>' + data[i]
                    .department_name + '</option>';
            }
            $('#select_department_edit').html(html);
            $('#select_department_multi_edit').html(html_multi);

        }
    });
    return false;
});

$('#select_department_edit').change(function() {
    var id = $(this).val();
    var type_department = $('#type_department_edit').val()

    if (type_department == 1) {
        $.ajax({
            url: "<?php echo site_url('sop/get_designations'); ?>",
            method: "POST",
            data: {
                id: id
            },
            async: true,
            dataType: 'json',
            success: function(data1) {

                console.log(data1);

                var html1 = '';
                var i;
                html1 += '<option value="" disabled selected>-- Pilih Designation --</option>';
                for (i = 0; i < data1.length; i++) {
                    html1 += '<option value=' + data1[i].designation_id + '>' + data1[i]
                        .designation_name + '</option>';
                }
                $('#select_designation_edit').html(html1);

            }
        });
    }

    return false;
});

$('#table_sop').on('click', '.edit_sop', function() {
    $('#modal_edit').modal('show');

    id_sop = $(this).data('id_sop');
    company = $(this).data('company_id');
    type_department = $(this).data('type_department');
    department = $(this).data('department_id');
    designation = $(this).data('designation_id');
    jenis_doc = $(this).data('jenis_doc');
    tgl_terbit = $(this).data('tgl_terbit');
    tgl_update = $(this).data('tgl_update');
    nama_dokumen = $(this).data('nama_dokumen');
    file = $(this).data('file');
    word = $(this).data('word');
    if(file == null){
        file = 'Belum ada file';
    }
    if(word == null){
        word = 'Belum ada file';
    }
    no_doc = $(this).data('no_doc');
    start_date = $(this).data('start_date');
    end_date = $(this).data('end_date');
    created_by = $(this).data('created_by');
    $('[name="data_pic"]').val('<?= $user['user_id'] ?>' + ',' + '<?= $user['contact_no'] ?>' + ',' +
        '<?= $user['employee_name'] ?>')

    $('#select_company_edit').val(company).trigger('change');
    // $('#select_designation_edit').val(designation).trigger('change');
    $('#type_department_edit').val(type_department).trigger('change');

    setTimeout(function() {
        $('#select_department_edit').val(department).trigger('change');

        $('#select_department_multi_edit').val(department).trigger('change');
    }, 2000);

    $('#select_designation_edit').val(designation).trigger('change');
    $('#jenis_doc_edit').val(jenis_doc).trigger('change');




    $('#id_sop').val(id_sop);
    $('#tbt_e').val(tgl_terbit);
    $('#upd_e').val(tgl_update);
    $('#nama_doc').val(nama_dokumen);

    if (file == null || file == '') {
        status = 'Waiting';
    } else {
        status = 'Done';
    }
    $('#status').val(status);


    $('#no_doc').val(no_doc);

    if (jenis_doc == "Memo") {
        $('#memo_edit').show();
        $('#start_date_e').val(start_date);
        $('#end_date_e').val(end_date);
    } else {
        $('#memo_edit').hide();
    }
    $('#select_designation_edit').val(designation).trigger('change');
    $('#label_file').empty().append(file);
    $('#label_word').empty().append(word);
});

$('#save_request').on('click', function() {

    var pilih_dokumen = $('[name="pilih_dokumen"]').val();
    var company = $('[name="company_req"]').val();
    var no_doc_jp = $('[name="no_doc_jp"]').val();
    var doc_type_id = $('[name="doc_type_id"]').val();
    var div_id = $('[name="division"]').val();
    var type_department = $('[name="type_department_req"]').val();
    var department_multi = $('[name="department_multi_req[]"]').val();
    var department = $('[name="department_req"]').val();
    var department_name = $('[name="department_req"] option:selected').text();
    var designation = $('[name="designation_req"]').val();
    var designation_name = $('[name="designation_req"] option:selected').text();
    var nama_dokumen = $('[name="nama_dokumen"]').val();
    var jadwal_diskusi = $('[name="jadwal_diskusi"]').val();
    var penjelasan = $('[name="penjelasan"]').val();
    var draf = $('[name="draf"]').val();
    var tujuan = $('[name="tujuan"]').val();
    var jumlah_bawahan = $('[name="jumlah_bawahan"]').val();
    var area = $('[name="area"]').val();
    var pendidikan = $('[name="pendidikan"]').val();
    var grade = $('[name="grade"]').val();
    var pengalaman = CKEDITOR.instances['pengalaman'].getData();
    var kompetensi = CKEDITOR.instances['kompetensi'].getData();
    var authority = CKEDITOR.instances['authority'].getData();

    if (pilih_dokumen == 1) { ///sop
        var validate = [];
        validate.push(validation_input('#select_company_req', 'company_req', 'select'));
        validate.push(validation_input('#type_department_req', 'type_department_req', 'select'));
        validate.push(validation_input('#select_department_req', 'department_req', 'select'));
        validate.push(validation_input('#select_designation_req', 'designation_req', 'select'));
        validate.push(validation_input('#nama_dokumen', 'nama_dokumen', 'text'));
        validate.push(validation_input('#penjelasan', 'penjelasan', 'text'));
        validate.push(validation_input('#draf', 'draf', 'text'));
        if (containsAllFalse(validate) == true) {
            var fd = new FormData();
            var files = $('#draf')[0].files[0];
            fd.append('file', files);
            fd.append('pilih_dokumen', pilih_dokumen);
            fd.append('company', company);
            fd.append('type_department', type_department);
            fd.append('department', department);
            fd.append('department_multi', department_multi);
            fd.append('designation', designation);
            fd.append('nama_dokumen', nama_dokumen);
            fd.append('penjelasan', penjelasan);
            fd.append('jadwal_diskusi', jadwal_diskusi);

            $.ajax({
                url: '<?= base_url('sop_dev/save_request'); ?>',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response) {
                    reset_form_request();
                    $('#table_sop').DataTable().ajax.reload();
                    swal({
                        title: "Success!",
                        text: "Data berhasil di input",
                        type: "success",
                        confirmButtonText: "OK"
                    });

                    send_notifikasi_request(nama_dokumen, jadwal_diskusi, designation_name,
                        department_name, penjelasan);
                    $('#modal_request').modal('hide');
                },
            });
        } else {
            $('#modal_request .modal-body').animate({
                scrollTop: sectionOffset.top - 30
            }, "slow");
            $('#modal_request .modal-body').scrollTop(0);

            // console.log('ada yang belum ke input');

        }




    } else if (pilih_dokumen == 2) { //job profile
        var validate = [];

        validate.push(validation_input('#select_company_req', 'company_req', 'select'));
        validate.push(validation_input('#select_department_req', 'department_req', 'select'));
        validate.push(validation_input('#nama_dokumen', 'nama_dokumen', 'text'));
        validate.push(validation_input('#designation_req', 'designation_req', 'text'));
        validate.push(validation_input('#grade', 'grade', 'select'));
        validate.push(validation_input('#penjelasan', 'penjelasan', 'text'));
        validate.push(validation_input('#tujuan', 'tujuan', 'text'));
        validate.push(validation_input('#jumlah_bawahan', 'jumlah_bawahan', 'text'));
        validate.push(validation_input('#area', 'area', 'text'));
        validate.push(validation_input('#pendidikan', 'pendidikan', 'text'));
        if (containsAllFalse(validate) == true) {
            var fd = new FormData();
            fd.append('pilih_dokumen', pilih_dokumen);
            fd.append('no_jp', $('[name="no_jp"]').val());
            fd.append('company', company);
            fd.append('doc_type_id', doc_type_id);
            fd.append('div_id', div_id);
            fd.append('no_doc', no_doc_jp);
            fd.append('designation', designation);
            fd.append('type_department', type_department);
            fd.append('department', department);
            fd.append('department_multi', department_multi);
            fd.append('designation', designation);
            fd.append('grade', grade);
            fd.append('nama_dokumen', nama_dokumen);
            fd.append('penjelasan', penjelasan);
            fd.append('tujuan', tujuan);
            fd.append('jadwal_diskusi', jadwal_diskusi);
            fd.append('jumlah_bawahan', jumlah_bawahan);
            fd.append('area', area);
            fd.append('pendidikan', pendidikan);
            fd.append('pengalaman', pengalaman);
            fd.append('kompetensi', kompetensi);
            fd.append('authority', authority);

            $.ajax({
                url: '<?= base_url('sop_dev/save_request'); ?>',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response) {
                    reset_form_request();
                    $('#table_sop').DataTable().ajax.reload();
                    swal({
                        title: "Success!",
                        text: "Data berhasil di input",
                        type: "success",
                        confirmButtonText: "OK"
                    });
                    send_notifikasi_request(nama_dokumen, jadwal_diskusi, designation_name,
                        department_name, penjelasan);
                    $('#modal_request').modal('hide');
                },
            });
        } else {
            $('html, body').animate({
                scrollTop: $('#pilih_dokumen').offset().top
            }, 500);

        }

    } else { // intruksi kerja
        var validate = [];
        validate.push(validation_input('#select_company_req', 'company_req', 'select'));
        validate.push(validation_input('#type_department_req', 'type_department_req', 'select'));
        validate.push(validation_input('#select_department_req', 'department_req', 'select'));
        validate.push(validation_input('#select_designation_req', 'designation_req', 'select'));
        validate.push(validation_input('#nama_dokumen', 'nama_dokumen', 'text'));
        validate.push(validation_input('#penjelasan', 'penjelasan', 'text'));
        validate.push(validation_input('#draf', 'draf', 'text'));
        if (containsAllFalse(validate) == true) {
            var fd = new FormData();
            var files = $('#draf')[0].files[0];
            fd.append('file', files);
            fd.append('pilih_dokumen', pilih_dokumen);
            fd.append('company', company);
            fd.append('type_department', type_department);
            fd.append('department', department);
            fd.append('department_multi', department_multi);
            fd.append('designation', designation);
            fd.append('nama_dokumen', nama_dokumen);
            fd.append('penjelasan', penjelasan);
            fd.append('jadwal_diskusi', jadwal_diskusi);

            $.ajax({
                url: '<?= base_url('sop_dev/save_request'); ?>',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response) {
                    reset_form_request();
                    $('#table_sop').DataTable().ajax.reload();
                    swal({
                        title: "Success!",
                        text: "Data berhasil di input",
                        type: "success",
                        confirmButtonText: "OK"
                    });
                    send_notifikasi_request(nama_dokumen, jadwal_diskusi, designation_name,
                        department_name, penjelasan);
                    $('#modal_request').modal('hide');
                },
            });
        } else {
            // console.log('ada yang belum ke input');

        }
    }
});

function containsAllFalse(array) {
    for (let i = 0; i < array.length; i++) {
        if (array[i] !== false) {
            return false;
        }
    }
    return true;
}

function validation_input(id, input, type) {

    if (type == 'select') {
        if ($('[name="' + input + '"]').val() == null || $('[name="' + input + '"]').val() == '') {
            $(id).after(
                '<small class="text-danger ' + input +
                '-invalid"><li class="fa fa-info-circle"></li> Please provide a valid select.</small>'
            );
            $('.' + input + '-invalid').delay(4000);
            $('.' + input + '-invalid').fadeOut();

            return true;

        } else {
            $('.' + input + '-invalid').remove();
            return false;
        }

    } else if (type == 'text') {
        if ($('[name="' + input + '"]').val() == null || $('[name="' + input + '"]').val() == '') {
            $(id).after(
                '<small class="text-danger ' + input +
                '-invalid"><li class="fa fa-info-circle"></li> Please provide a valid input.</small>'
            ).fadeIn();
            $('.' + input + '-invalid').delay(4000);
            $('.' + input + '-invalid').fadeOut();

            return true;
        } else {
            $('.' + input + '-invalid').remove();
            return false;
        }
    } else if (type == 'edit') {
        if ($(id).val() == null || $(id).val() == '') {
            $(id).after(
                '<small class="text-danger " id="' + input +
                '-invalid"><li class="fa fa-info-circle"></li> Please provide a valid input.</small>'
            ).fadeIn();
            $('#' + input + '-invalid').delay(4000);
            $('#' + input + '-invalid').fadeOut();

            return true;
        } else {
            $('#' + input + '-invalid').remove();
            return false;
        }
    } else {
        return false;

    }
}
$("#doc_type_id").change(function() {
    //   $(this).css("background-color", "#FFFFFF");
    var pilih_dokumen = $('[name="pilih_dokumen"]').val();
    var doc_type = $('[name="doc_type_id"]').val();
    var division = $('[name="division"]').val();
    var company = $('[name="company_req"]').val();
    var department = $('[name="department_req"]').val();
    var designation = $('[name="designation_req"]').val();
    if (pilih_dokumen == '' || company == '' || department == '' || designation == '') {

    } else {
        $.ajax({
            type: "POST",
            url: "<?= base_url('job_profile/get_no_doc'); ?>",
            data: {
                doc_type_id: doc_type,
                div_id: division,
                company_id: company,
                department_id: department
            },
            dataType: "json",
            success: function(response) {
                $('[name="no_doc_jp"]').val(response)

            }
        });
    }

});

$('#save_edit').on('click', function() {

    if ($('#file').val() != '') {
        $('#modal_progress').modal({
            backdrop: 'static',
            keyboard: false
        });
    }
    var validate = [];
    validate.push(validation_input('#select_company_edit', 'select_company_edit', 'edit'));
    validate.push(validation_input('#select_department_edit', 'select_department_edit', 'edit'));
    validate.push(validation_input('#select_designation_edit', 'select_designation_edit', 'edit'));
    validate.push(validation_input('#jenis_doc_edit', 'jenis_doc_edit', 'edit'));
    validate.push(validation_input('#no_doc', 'no_doc', 'edit'));
    validate.push(validation_input('#tbt_e', 'tbt_e', 'edit'));
    validate.push(validation_input('#upd_e', 'upd_e', 'edit'));
    validate.push(validation_input('#nama_doc', 'nama_doc', 'edit'));
    if($('#label_file').text() != 'Belum ada file'){
        validate.push(validation_input('#word', 'word', 'edit'));
    }else{
        validate.push(validation_input('#word', 'word', 'edit'));
        validate.push(validation_input('#file', 'file', 'edit'));
    }
    if($('#label_word').text() != 'Belum ada file'){
        validate.push(validation_input('#file', 'file', 'edit'));
    }
    

    if (containsAllFalse(validate) == true) {
        var formdata = new FormData($('#form_edit_sop')[0]);
        url = "<?php echo site_url('sop_dev/update') ?>";
        var no_jp = $('[name="id_sop"]').val();
        formdata.append('file', $('#file').val());
        formdata.append('word', $('#word').val());
        var designation = $('#select_designation_edit option:selected').text();
        var no_doc = $('#nama_doc').val();
        var departement = $('#select_department_edit option:selected').text();
        var data_pic = $('[name="data_pic"]').val().split(",");
        var prepared = data_pic[2];
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressUpload, false);
        ajax.open("POST", url, true);
        ajax.send(formdata);
        ajax.onload = function() {
            console.log('DONE: ', ajax.status);
            if (ajax.status == 200) {
                $('#modal_edit').modal('hide');


                document.getElementById("bar_upload_1").style.width = '';
                document.getElementById("status_upload_1").innerHTML = '';
                $('#table_sop').DataTable().ajax.reload();
                $('#modal_progress').modal('hide');
                swal({
                    title: "Success!",
                    text: "Data berhasil diUpdate dan dikirim Review Ke PIC",
                    type: "success",
                    confirmButtonText: "OK"
                });
                $("#form_edit_sop")[0].reset();
                send_notifikasi_review(no_jp, designation, no_doc, departement, data_pic, prepared);
            }
        };
    } else {
        console.log('ga ada yang salah');

    }


});

function reset_form_request() {
    $('#form_request')[0].reset();
    $("#form_request").trigger("reset");
    CKEDITOR.instances['pengalaman'].setData('', function() {
        this.updateElement();
    });
    CKEDITOR.instances['kompetensi'].setData('', function() {
        this.updateElement();
    });
    CKEDITOR.instances['authority'].setData('', function() {
        this.updateElement();
    });
}



//Progress Bar
function progressUpload(event) {
    var percent = (event.loaded / event.total) * 100;
    document.getElementById("bar_upload_1").style.width = Math.round(percent) + '%';
    document.getElementById("status_upload_1").innerHTML = Math.round(percent) + "% completed";
}

$('#table_sop').on('click', '.add_link', function() {
    $('#modal_link').modal('show');

    i1 = $(this).data('id_sop');
    $('#id_sop_link').val(i1);

    i2 = $(this).data('nama_dokumen');
    $('#nk').val(i2);
});

$(document).ready(function() {
    $("#rd_1").select2({
        dropdownParent: $("#modal_link")
    });
});

$('#save_link').on('click', function() {

    rd = $('#rd').val();
    total_spo = $('#total_spo').val();
    var rd_ = [];
    for (i = 0; i < total_spo; i++) {
        rd_[i + 1] = $('#rd_' + (i + 1)).val();
        if (rd_[i + 1] == null) {
            $('#rd_' + (i + 1)).select2('open');
            $('#rd_' + (i + 1)).on('select2:select', function(e) {
                $('#rd_' + (i + 1)).removeAttr('id');
            });
        } else {
            if ((i + 1) == total_spo) {
                var formdata = new FormData($('#form_add_link')[0]);
                url = "<?php echo site_url('sop/add_link') ?>";

                var ajax = new XMLHttpRequest();
                ajax.upload.addEventListener("progress", progressUpload, false);
                ajax.open("POST", url, true);
                ajax.send(formdata);
                ajax.onload = function() {
                    console.log('DONE: ', ajax.status);
                    if (ajax.status == 200) {
                        window.location.reload();
                    }
                };
            }

        }
    }

});
// $('#jadwal_diskusi').datepicker({
//     // beforeShowDay: $.datepicker.noWeekends,
//     // controls: ['date', 'time'],
//     // minDate: moment().add(10, 'days').calendar(),
//     // format: 'dd-mm-yyyy',
//     // todayHighlight: true,
//     // autoclose: true

// });
$('#pilih_dokumen').on('change', function() {
    var pilih = $(this).val();
    $('#save_request').attr('disabled', false);
    if (pilih == 1) {
        $('.company, .designation, .nama_dokumen, .penjelasan, .draf, .type_dept, .row_dept, .single_department_req')
            .slideDown();
        $('.jobprofile, .multi_department_req, .grade').hide();
    } else if (pilih == 2) {
        $('.company, .nama_dokumen, .penjelasan, .jobprofile, .row_dept, .single_department_req, .grade, .designation')
            .slideDown();
        $(' .draf, .type_dept ').slideUp();
        // $('.single_department_req').show();
        $('.multi_department_req').hide();
    } else if (pilih == 3) {
        $('.company, .designation, .nama_dokumen, .penjelasan, .draf, .type_dept, .row_dept, .single_department_req')
            .slideDown();
        $(' .jobprofile, .grade').slideUp();
        $('.single_department_req').show();
        $('.multi_department_req').hide();

    }
});

$('#table_sop').on('click', '.detail', function() {
    $('#modal_detail').modal('show');

    id_sop = $(this).data('id_sop');

    url = "<?= site_url('sop/detail') ?>";
    $('#t_detail').DataTable({
        'destroy': true,
        'lengthChange': false,
        'searching': false,
        'info': false,
        'paging': false,
        "autoWidth": false,
        "ajax": {
            "dataType": 'json',
            "type": "POST",
            "url": url,
            "data": {
                id_sop: id_sop
            },
        },
        "columns": [{
                "width": "25%",
                "data": "no_doc"
            },
            {
                "width": "75%",
                "data": "nama_dokumen"
            },
            {
                "width": "5%",
                "data": "id_parent",
                "render": function(data, type, row) {
                    return '<a href="javascript:void(0)" data-idp="' + data + '" data-idc="' +
                        row['id_child'] +
                        '" class="label label-danger delete"><i class="ti-trash"></i></a>';
                }
            }
        ]
    });
});

$('#t_detail').on('click', '.delete', function() {
    idp = $(this).data('idp');
    idc = $(this).data('idc');

    $.ajax({
        url: "<?= site_url('sop/delete_relasi') ?>",
        type: 'POST',
        data: {
            idp: idp,
            idc: idc
        },
        success: function(result) {

            $('#modal_detail').modal('hide');

            swal({
                    title: "Success!",
                    text: "Data berhasil dihapus",
                    type: "success",
                    confirmButtonText: "OK"
                },
                function(isConfirm) {
                    if (isConfirm) {
                        window.location.reload();
                    }
                });

        }
    });

});
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
            send_notifikasi_review(no_jp, designation, no_doc, departement, data_pic, prepared);
        } else {
            // swal("Cancelled", "Your data is safe", "error");
        }
    });

}

function send_notifikasi_request(nama_dokumen, jadwal, designation, department, penjelasan) {
    tgl = '<?= date('Y-m-d') ?>';
    user = '<?= $user['employee_name'] ?>';
    // link = '🔗 <?= base_url('/review/sop/') ?>' + no_jp + '/' + data_pic[0];
    data_dokumen = ``;
    data_dokumen +=
        `\n📑Nama Dokumen : *${nama_dokumen}*\n🔑Departemen : *${department}*\n👔Job Position : *${designation}*\n💬Penjelasan : *${penjelasan}*\n🔴Jadwal Diskusi : *${jadwal}* \n\n`;

    msg =
        `📢There is a new request document! \n${data_dokumen}\nMohon Segera di Eksekusi Pembuatan Dokumen tersebut\n\n👤Requested By : ${user}\n🕐Requested At : ${tgl}`;

    list_phone = [
        '083824955357', // sidik
        '083148391529', // ari
        // data_pic[1], // data pic yang di pilih
    ];
    console.info(msg)

    //list phone it ke wa sendiri
    send_wa(list_phone, msg);
    // if (id_user != 1) {
    //     send_wa(list_phone, msg);
    // }



}

function send_notifikasi_review(no_jp, designation, no_doc, departement, data_pic, prepared) {
    tgl = '<?= date('Y-m-d') ?>';
    var today = new Date();
    today.setDate(today.getDate() + 2);
    // Mendapatkan tahun
    var year = today.getFullYear();
    var month = today.getMonth() + 1;
    month = month < 10 ? '0' + month : month; // Menambahkan nol di depan jika bulan kurang dari 10
    var day = today.getDate();
    day = day < 10 ? '0' + day : day; // Menambahkan nol di depan jika tanggal kurang dari 10
    var deadline = year + '-' + month + '-' + day;
    link = '🔗 <?= 'https://trusmicorp.com/od/review/sop/' ?>' + no_jp + '/' + data_pic[0];
    data_review = ``;
    data_review +=
        `\n📑Nama Dokumen : *${no_doc}*\n🔑Departemen : *${departement}*\n👔Job Position : *${designation}*\n💣Deadline Review : *${deadline}*\n`;

    msg =
        `📢 Alert!!! Please Review, make sure your feedback is helpful\n${data_review}${link}\nMohon untuk review dengan baik dan benar\n\n👤Prepared By : ${prepared}\n🕐Requested At : ${tgl}`;

    list_phone = [
        '083824955357', // sidik
        '083148391529', // ari
        // data_pic[1], // data pic yang di pilih
    ];
    // console.info(msg)

    //list phone it ke wa sendiri
    send_wa(list_phone, msg);
    // if (id_user != 1) {
    //     send_wa(list_phone, msg);
    // }



}


$('select[name="jenis_doc"]').on('change', function() {
    if ($('select[name="jenis_doc"]').val() == 'Memo') {
        $('#memo_add').show();
        $('select[name="divisi"]').removeClass('is-invalid');
        $('select[name="jenis_doc"]').removeClass('is-invalid');
        $('input[name="no_doc"]').removeClass('is-invalid');
        $('input[name="tgl_terbit"]').removeClass('is-invalid');
        $('input[name="tgl_update"]').removeClass('is-invalid');
        $('input[name="nama_doc"]').removeClass('is-invalid');
        $('input[name="file"]').removeClass('is-invalid');
    } else {
        $('#memo_add').hide();
        $('select[name="divisi"]').removeClass('is-invalid');
        $('select[name="jenis_doc"]').removeClass('is-invalid');
        $('input[name="no_doc"]').removeClass('is-invalid');
        $('input[name="tgl_terbit"]').removeClass('is-invalid');
        $('input[name="tgl_update"]').removeClass('is-invalid');
        $('input[name="start_date"]').removeClass('is-invalid');
        $('input[name="end_date"]').removeClass('is-invalid');
        $('input[name="nama_doc"]').removeClass('is-invalid');
        $('input[name="file"]').removeClass('is-invalid');
    }
});
</script>