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

        $('.select2').select2();

        url = "<?= site_url('sop_ade/data_sop') ?>";
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
            "columns": [{
                    "data": "id_sop",
                    'render': function(data, type, row, meta) {
                        if (row['status_review'] == null) {


                            if ("<?php echo $this->session->userdata('user_id') ?>" == 2774 || "<?php echo $this->session->userdata('user_id') ?>" == 2843 || "<?php echo $this->session->userdata('user_id') ?>" == 2903 || "<?php echo $this->session->userdata('user_id') ?>" == 1) {
                                return `<a href="javascript:void(0);" onclick="modal_review('${data}','${row['department']}')" class="btn btn-xs btn-warning sharp shadow">
                            <i class="fa fa-star"></i> </a> Waiting`;
                            } else {
                                return `Waiting`;
                            }
                        } else {
                            if ("<?php echo $this->session->userdata('user_id') ?>" == 2774 || "<?php echo $this->session->userdata('user_id') ?>" == 2843 || "<?php echo $this->session->userdata('user_id') ?>" == 2903 || "<?php echo $this->session->userdata('user_id') ?>" == 1) {
                                return `<a href="javascript:void(0);" onclick="modal_review('${data}','${row['department']}')" class="btn btn-xs btn-warning sharp shadow">
                            <i class="fa fa-star"></i> </a> <span class="badge badge-default">${row['status_review']}</span>`;
                            } else {
                                return `<span class="badge badge-default">${row['status_review']}</span>`;
                            }
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
                        if ("<?php echo $this->session->userdata('user_id') ?>" == 2774 || "<?php echo $this->session->userdata('user_id') ?>" == 2843 || "<?php echo $this->session->userdata('user_id') ?>" == 2903 || "<?php echo $this->session->userdata('user_id') ?>" == 1) {
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
                                    `href="javascript:void(0)">Editx</a>` +

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
                        } else {
                            return ``;
                        }

                    }
                }
            ]
        });
    });

    $('#table_sop').on('click', '.edit_sop', function() {

        $('.multi_department_edit').show();

        $('#modal_edit').modal('show');
        console.log('btn edit sop click..');

        id_sop = $(this).data('id_sop');
        company = $(this).data('company_id');
        type_department = $(this).data('type_department');
        department = $(this).data('department_id');
        designation = $(this).data('designation_id');

        $('#select_company_edit').val(company).trigger('change');
        // $('#type_department_edit').val(type_department).trigger('change');

        setTimeout(function() {
            $('#select_department_multi_edit').val(department).trigger('change');
        }, 2000);
    });

    $('#select_company_edit').change(function() {
        var id = $(this).val();
        console.log('sel comp edit triger change, id: ', id);

        $.ajax({
            url: "<?php echo site_url('sop_ade/get_departments'); ?>",
            method: "POST",
            data: {
                id: id
            },
            async: true,
            dataType: 'json',
            success: function(data) {

                var html_multi = '';
                var i;
                for (i = 0; i < data.length; i++) {
                    html_multi += '<option value=' + data[i].department_id + '>' + data[i]
                        .department_name + 'TEST</option>';
                }
                $('#select_department_multi_edit').html(html_multi);
                console.log(html_multi);
            }
        });
        // return false;
    });
</script>