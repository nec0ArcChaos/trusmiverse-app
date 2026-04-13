<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/clockpicker/jquery-clockpicker.min.js" type="text/javascript"></script>
<!-- sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const baseUrl = "<?= base_url('Update_attendance'); ?>"
    $(document).ready(function() {

        $('.timepicker').clockpicker({
            placement: 'bottom',
            align: 'left',
            autoclose: true,
            'default': 'now'
        });

        slc_company = new SlimSelect({
            select: '#company',
        });

        slc_department = new SlimSelect({
            select: '#department',
        });

        slc_employee = new SlimSelect({
            select: '#employee',
        });

        $('#company').change(function() {
            company_id = $(this).val();

            $.ajax({
                url: `${baseUrl}/get_department`,
                type: 'POST',
                dataType: 'json',
                data: {
                    company_id: company_id
                },
                success: function(response) {
                    slc_department.setData(response.data);
                }
            });
        });

        $('#department').change(function() {
            company_id = $('#company').val();
            department_id = $(this).val();

            $.ajax({
                url: `${baseUrl}/get_employees`,
                type: 'POST',
                dataType: 'json',
                data: {
                    company_id: company_id,
                    department_id: department_id
                },
                success: function(response) {
                    slc_employee.setData(response.data);
                }
            });
        });



    }); // END :: Ready Function


    function filter_attendance() {
        company = $('#company :selected').val();
        department = $('#department :selected').val();
        employee = $('#employee :selected').val();
        date = $('#date').val();

        $('#employee_id').val(employee);

        $('#btnAddAbsen').removeClass('d-none');

        dt_attendance(company, department, employee, date);
    }


    function dt_attendance(company_id, department_id, employee_id, date) {
        $('#dt_attendance').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [1, 'asc']
            ],
            responsive: true,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "url": `${baseUrl}/dt_attendance`,
                "type": "POST",
                "dataType": 'json',
                "data": {
                    company_id,
                    department_id,
                    employee_id,
                    date
                },
            },
            "columns": [{
                    data: 'time_attendance_id',
                    render: function(data, type, row) {
                        return `<button class="btn btn-sm btn-primary editAbsen" data-id="${data}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger deleteAbsen" data-id="${data}">
                                    <i class="bi bi-trash"></i>
                                </button>`
                    }
                },
                {
                    data: 'clock_in'
                },
                {
                    data: 'clock_out'
                },
                {
                    data: 'total_work'
                }
            ],
        });
    }




    // delete absen
    function hapusAbsen(id) {

        $.ajax({
            'url': `${baseUrl}/hapus`,
            'type': 'POST',
            'data': {
                time_attendance_id: id
            },
            'success': function(response) {
                $('#modalConfirm').modal('hide');
                success_alert('Berhasil menghapus absen!');
                filter_attendance();
            }
        });
    }

    // NOTIFY
    function success_alert(text) {
        textMsg = text == null ? '' : text;
        new PNotify({
            title: `Success`,
            text: `${textMsg}`,
            icon: 'icofont icofont-checked',
            type: 'success',
            delay: 1500,
        });
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

    function prosesAbsen() {
        const form = $('#formAbsen');

        const type = $('#type').val();
        let employee_id = $('#employee_id').val();
        let attendance_date = $('#attendance_date_e').val();
        let clock_in = $('#clock_in').val();

        if (type === 'add') {


            if (!employee_id || employee_id == '') {
                Swal.fire({
                    icon: 'warning',
                    text: 'Employee wajib diisi.',
                    title: 'Opps!',
                    showConfirmButton: false,
                    timer: 1500
                });
                return;
            }

            if (!attendance_date || attendance_date == '') {
                Swal.fire({
                    icon: 'warning',
                    text: 'Tanggal kehadiran wajib diisi.',
                    title: 'Opps!',
                    showConfirmButton: false,
                    timer: 1500
                });
                return;
            }

            if (!clock_in || clock_in == '') {
                Swal.fire({
                    icon: 'warning',
                    text: 'Jam masuk wajib diisi.',
                    title: 'Opps!',
                    showConfirmButton: false,
                    timer: 1500
                });
                return;
            }
        } else if (type == 'update') {

            if (!employee_id || employee_id == '') {
                Swal.fire({
                    icon: 'warning',
                    text: 'Employee wajib diisi.',
                    title: 'Opps!',
                    showConfirmButton: false,
                    timer: 1500
                });
                return;
            }

            if (!attendance_date || attendance_date == '') {
                Swal.fire({
                    icon: 'warning',
                    text: 'Tanggal kehadiran wajib diisi.',
                    title: 'Opps!',
                    showConfirmButton: false,
                    timer: 1500
                });
                return;
            }

            if (!clock_in || clock_in == '') {
                Swal.fire({
                    icon: 'warning',
                    text: 'Jam masuk wajib diisi.',
                    title: 'Opps!',
                    showConfirmButton: false,
                    timer: 1500
                });
                return;
            }
        }

        const formData = form.serialize();

        Swal.fire({
            title: 'Konfirmasi',
            text: 'Yakin simpan data?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: `${baseUrl}/update_attendance`,
                    data: formData,
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            icon: res.status ? 'success' : 'error',
                            title: res.status ? 'success' : 'error',
                            text: res.message,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        if (res.status) {
                            form[0].reset();
                            $('#modalForm').modal('hide');
                            $('#dt_attendance').DataTable().ajax.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan server.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            }
        });
    }



    function get_attendance_by_id(id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "POST",
                url: `${baseUrl}/get_attendance_by_id`,
                data: {
                    id
                },
                dataType: "json",
                success: function(response) {
                    if (response.status) {
                        resolve(response.data);
                    } else {
                        reject(response.message || "Data tidak ditemukan");
                    }
                },
                error: function(xhr, status, error) {
                    reject(error);
                }
            });
        });
    }


    $(document).on('click', '.editAbsen', function() {
        const id = $(this).data('id');
        get_attendance_by_id(id).then(data => {
            // Isi form sebelum tampilkan modal
            $('#type').val('update');
            $('#time_attendance_id').val(id);
            $('#attendance_date_e').val(data.attendance_date);
            $('#clock_in').val(data.clock_in);
            $('#clock_out').val(data.clock_out ?? '');

            $('#modalForm').modal('show');
        }).catch(err => {
            alert('Gagal mendapatkan data: ' + err);
        });
    });

    $(document).on('click', '.deleteAbsen', function() {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Yakin ingin menghapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(baseUrl + "/delete_attendance", {
                    id: id
                }, function(res) {
                    Swal.fire({
                        icon: res.status ? 'success' : 'error',
                        title: res.status ? 'success' : 'error',
                        text: res.message,
                        showConfirmButton: false,
                        timer: 1500
                    });

                    if (res.status) {
                        $('#dt_attendance').DataTable().ajax.reload();
                    }
                }, 'json').fail(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan pada server.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            }
        });
    });


    $('#btnAddAbsen').click(function() {
        $('#type').val('add');
    });
</script>