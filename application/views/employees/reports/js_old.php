<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/select2/js/select2.full.min.js"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<!-- Datepicker -->
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>


<script>
    function show_report() {
        dt_employees_report();
    }

    function dt_employees_report() {
        company = $('#company').val();
        department = $('#department').val();
        designation = $('#designation').val();
        $('#dt_employees_report').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip', // Add Buttons to the DOM
            "buttons": [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-success',
                exportOptions: {
                    columns: ':visible',
                    format: {
                        body: function(data, row, column, node) {
                            // Apply the formatting only to the first column (index 0)
                            if (column === 30 || column === 31) {
                                if (data != '' && data != null) {
                                    return "'" + data.toString() + "'"; // Treat as text for the first column
                                } else {
                                    return '';
                                }
                            }
                            return data; // Leave other columns as-is
                        }
                    }
                }
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    company: company,
                    department: department,
                    designation: designation
                },
                "url": "<?= base_url(); ?>employees_dev/dt_employees_report",
            },
            "columns": [{
                    "data": "NIP",
                },
                {
                    "data": "nama_karyawan"
                },
                {
                    "data": "nama_pengguna"
                },
                {
                    "data": "perusahaan",
                },
                {
                    "data": "departement",
                },
                {
                    "data": "penunjukan",
                },
                {
                    "data": "role_name_old",
                },
                {
                    "data": "role_name",
                },
                {
                    "data": "shift",
                },
                {
                    "data": "masa_kerja",
                },
                {
                    "data": "status",
                },
                {
                    "data": "marital_status",
                },
                {
                    "data": "email",
                },
                {
                    "data": "tgl_gabung",
                },
                {
                    "data": "attendance_date",
                },
                {
                    "data": "tgl_resign",
                },
                {
                    "data": "jenis_kelamin",
                },
                {
                    "data": "no_kontak",
                },
                {
                    "data": "alamat",
                },
                {
                    "data": "kota",
                },
                {
                    "data": "provinsi",
                },
                {
                    "data": "kodepos",
                },
                {
                    "data": "ctm_tempat_lahir",
                },
                {
                    "data": "date_of_birth",
                },
                {
                    "data": "ayah",
                },
                {
                    "data": "ibu",
                },
                {
                    "data": "suami",
                },
                {
                    "data": "istri",
                },
                {
                    "data": "banyak_anak",
                },
                {
                    "data": "nama_anak",
                },
                {
                    "data": "no_kk",
                    "render": function(data, type, row, meta) {
                        return data.toString()
                    }
                },
                {
                    "data": "no_ktp",
                    "render": function(data, type, row, meta) {
                        return data.toString()
                    }
                },
                {
                    "data": "agama",
                },
                {
                    "data": "no_jkn",
                },
                {
                    "data": "no_kpj",
                },
                {
                    "data": "npwp",
                },
                {
                    "data": "bank_account",
                },
                {
                    "data": "contract_1",
                },
                {
                    "data": "contract_2",
                },
                {
                    "data": "contract_3",
                },
                {
                    "data": "contract_4",
                },
                {
                    "data": "contract_5",
                },
                {
                    "data": "pendidikan_1",
                },
                {
                    "data": "pendidikan_2",
                },
                {
                    "data": "pendidikan_3",
                },
                {
                    "data": "pendidikan_4",
                },
                {
                    "data": "pendidikan_5",
                },
                {
                    "data": "wrk_1",
                },
                {
                    "data": "wrk_2",
                },
                {
                    "data": "wrk_3",
                },
                {
                    "data": "wrk_4",
                },
                {
                    "data": "wrk_5",
                },
                {
                    "data": "dokumen",
                },
                {
                    "data": "lokasi_karyawan",
                },
                {
                    "data": "nama_atasan",
                },
                {
                    "data": "mt",
                },
                {
                    "data": "iq",
                },
                {
                    "data": "disc",
                },
                {
                    "data": "attitude",
                },
                {
                    "data": "performance",
                },
                {
                    "data": "nama_pt"
                }
            ]
        });
    }

    $('#company').on('change', function() {
        get_department();
    })

    function get_department() {
        company = $('#company').val();
        $.ajax({
            url: "<?= base_url('employees_dev/get_department') ?>",
            method: "POST",
            data: {
                company: company,
                id_department: null
            },
            dataType: "JSON",
            success: function(res) {
                department = `<option value = "#" selected disabled>-- Pilih Departemen --</option>`;
                res.department.forEach(element => {
                    department += `<option value = "${element['department_id']}">${element['department_name']}</option>`
                });
                $('#department').html('');
                $('#department').append(department);
            }
        })
    }

    $('#department').on('change', function() {
        get_designation();
    })

    function get_designation() {
        company = $('#company').val();
        department = $('#department').val();
        $.ajax({
            url: "<?= base_url('employees_dev/get_designation') ?>",
            method: "POST",
            data: {
                company: company,
                department: department,
                designation: null,
            },
            dataType: "JSON",
            success: function(res) {
                designation = `<option value = "#" selected disabled>-- Pilih Designation --</option>`;
                res.designation.forEach(element => {
                    designation += `<option value = "${element['designation_id']}">${element['designation_name']}</option>`
                });
                $('#designation').html('');
                $('#designation').append(designation);
            }
        })
    }

    function error_alert(text) {
        new PNotify({
            title: `Oopss`,
            text: `${text}`,
            icon: 'icofont icofont-info-circle',
            type: 'error',
            delay: 1500,
        });
    }

    function success_alert(text) {
        textMsg = text == null ? '' : text;
        new PNotify({
            title: `Success`,
            text: `${textMsg}`,
            icon: 'icofont icofont-checked',
            type: 'success',
            delay: 2000,
        });
    }
</script>