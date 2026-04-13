<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<!-- Datepicker -->
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/select2/js/select2.full.min.js"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>


<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>



<script>
    $(document).ready(function() {

        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;
        // Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="startdate"]').val(start.format('YYYY-MM-DD'));
            $('input[name="enddate"]').val(end.format('YYYY-MM-DD'));
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
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                    .endOf('month')
                ]
            }
        }, cb);

        cb(start, end);

        employee_select = NiceSelect.bind(document.getElementById('employee'), {
            searchable: true,
            isAjax: false,
        });
    })

    function show_warning_letter() {
        dt_warning_letter();
    }

    $('#employee').on('change', function() {
        if ($('#employee').val() != null && $('#employee').val() != '') {
            $('#warning_type').removeAttr('disabled');
        } else {
            $('#warning_type').attr('disabled', true);
        }
    })

    $('#company').on('change', function() {
        get_department();
    })

    function get_department() {
        company = $('#company').val();
        $.ajax({
            url: "<?= base_url('Warning_letter/get_department') ?>",
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

    $('#btn_modal_add_letter').on('click', function() {
        $('#form_add_warning')[0].reset();
        $('#modal_form_warning').modal('show');
        $('#title_form_warning').text('Add Warning Letter');
        $('#for_add').removeClass('d-none');
        $('#for_edit').addClass('d-none');
        $('#btn_save_warning').removeClass('d-none');
        $('#btn_update_warning').addClass('d-none');
        $('#corrective').removeAttr('readonly');
        $('#warning_type').removeAttr('readonly');
        $('#subject').removeAttr('readonly');
        $('#warning_date').removeAttr('readonly');
        $('#result_investigation').removeAttr('readonly');
        $('#another_note').removeAttr('readonly');
        $('#status').removeAttr('disabled');
        $('#attachment').removeAttr('disabled');
    });

    $('#company_form').on('change', function() {
        get_employees();
    })

    function get_employees(user_id = null) {
        company_id = $('#company_form').val();
        if (company_id != null && company_id != '') {
            $.ajax({
                url: "<?= base_url('warning_letter/get_employees') ?>",
                method: "POST",
                data: {
                    user_id: user_id,
                    company_id: company_id
                },
                dataType: "JSON",
                success: function(res) {
                    employee = '<option value = "#" selected disabled>-- Choose Employees --</option>';
                    res.employee.forEach(element => {
                        employee += `<option value = "${element['user_id']}" ${element['selected'] == 1 ? 'selected' : ''}> ${element['employee_id']} | ${element['employee_name']} | ${element['department_name']}</option>`;
                    });
                    $('#employee').html('');
                    $('#employee').append(employee);
                    employee_select.update();
                }
            })
        }
    }

    function save_warning() {
        if ($('#company_form').val() == null || $('#company_form').val() == '') {
            error_alert('Company is required!');
        } else if ($('#employee').val() == null) {
            error_alert('Employee is required');
        } else if ($('#warning_type').val() == null) {
            error_alert('Warning type is required!');
        } else if ($('#subject').val() == '') {
            error_alert('Subject is required!');
        } else if ($('#warning_date').val() == '') {
            error_alert('Warning date is required!');
        } else if ($('#status').val() == null) {
            error_alert('Status is required!');
        } else {
            let form = new FormData($('#form_add_warning')[0]);
            $.ajax({
                url: "<?= base_url('warning_letter/save_warning') ?>",
                method: "POST",
                data: form,
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#btn_save_warning').attr('disabled', true);
                },
                success: function(res) {
                    if (res.result == true) {
                        success_alert('Berhasil menambahkan data');
                        $('#modal_form_warning').modal('hide');
                        $('#btn_save_warning').removeAttr('disabled');
                        dt_warning_letter();
                    } else {
                        error_alert('Gagal menambahkan data');
                        $('#btn_save_warning').removeAttr('disabled');
                    }
                }
            })
        }
    }

    function dt_warning_letter() {
        company = $('#company').val();
        department = $('#department').val();
        start = $('#start').val();
        end = $('#end').val();
        sto = $('#level_sto').val();

        $('#dt_warning_letter').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip', // Add Buttons to the DOM
            "buttons": [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-success'
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    company: company,
                    department: department,
                    start: start,
                    end: end
                },
                "url": "<?= base_url(); ?>warning_letter/dt_warning_letter",
            },
            "columns": [{
                    "data": "warning_id",
                    "render": function(data, type, row, meta) {
                        if (sto >= 4) {
                            content = `<a class="badge bg-success text-black mb-1" style="cursor:pointer;" onclick="edit_warning('${data}')"><i class="bi bi-pencil-square"></i>edit</a>
                        <a class="badge bg-light-red text-black" onclick="delete_warning('${data}')" style="cursor:pointer;"><i class="bi bi-trash"></i>delete</a>`;
                        } else {
                            content = `<a class="badge bg-success text-black mb-1" style="cursor:pointer;" onclick="edit_warning('${data}')"><i class="bi bi-pencil-square"></i>edit</a>`;
                        }
                        return content;
                    },
                },
                {
                    "data": "employee_to"
                },
                {
                    "data": "warning_name"
                },
                {
                    "data": "status",
                    "render": function(data, type, row, meta) {
                        if (data == 0) {
                            sw = `<span class = "badge bg-warning">Pending</span>`;
                        } else if (data == 1) {
                            sw = `<span class = "badge bg-success">Accepted</span>`;
                        } else if (data == 2) {
                            sw = `<span class = "badge bg-danger">Rejected</span>`;
                        }
                        return sw;
                    }
                },
                {
                    "data": "company_name"
                },
                {
                    "data": "warning_date"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "subject"
                },
                {
                    "data": "employee_by"
                }
            ]
        });
    }

    function delete_warning(id) {
        $.confirm({
            title: 'Delete data',
            content: 'Data warning will be deleted',
            icon: 'fa fa-question',
            animation: 'scale',
            closeAnimation: 'scale',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Yes',
                    btnClass: 'btn-blue',
                    action: function() {
                        $.confirm({
                            icon: 'fa fa-spinner fa-spin',
                            title: 'Please Wait!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Loading...',
                            buttons: {
                                close: {
                                    isHidden: true,
                                    actions: function() {}
                                },
                            },
                            onOpen: function() {
                                $.ajax({
                                    url: "<?= base_url('warning_letter/delete_warning') ?>",
                                    method: "POST",
                                    data: {
                                        id: id
                                    },
                                    dataType: "JSON",
                                    success: function(response) {
                                        if (response.result) {
                                            setTimeout(() => {
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Success!',
                                                    buttons: {
                                                        close: function() {},
                                                    },
                                                });
                                            }, 250);
                                            $('#dt_warning_letter').DataTable().ajax.reload();
                                        } else {
                                            setTimeout(() => {
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Oops!',
                                                    theme: 'material',
                                                    type: 'red',
                                                    content: 'Failed!',
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                            $('#dt_warning_letter').DataTable().ajax.reload();
                                        }
                                    }
                                })
                            }
                        })
                    }
                }
            }
        })
    }

    function edit_warning(id) {
        $.ajax({
            url: "<?= base_url('warning_letter/get_detail_warning') ?>",
            method: "POST",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function(res) {
                $('#warning_id').val(res.warning.warning_id);
                $('#warning_to').val(res.warning.warning_to);
                $('#corrective').val(res.warning.tindakan_perbaikan);
                $('#warning_type').val(res.warning.warning_type_id);
                $('#subject').val(res.warning.subject);
                $('#warning_date').val(res.warning.warning_date);
                $('#result_investigation').val(res.warning.hasil_investigasi);
                $('#another_note').val(res.warning.catatan_lain);
                $('#chronological').val(res.warning.kronologis);
                $('#status').val(res.warning.status);
                $('#modal_form_warning').modal('show');
                $('#title_form_warning').text('Edit Warning Letter');
                $('#for_edit').removeClass('d-none');
                $('#for_add').addClass('d-none');
                $('#btn_save_warning').addClass('d-none');
                $('#btn_update_warning').removeClass('d-none');
                user_id = <?= $this->session->userdata('user_id') ?>;
                if (user_id == res.warning.warning_to) {
                    $('#corrective').attr('readonly', true);
                    $('#warning_type').attr('readonly', true);
                    $('#subject').attr('readonly', true);
                    $('#warning_date').attr('readonly', true);
                    $('#result_investigation').attr('readonly', true);
                    $('#another_note').attr('readonly', true);
                    $('#status').attr('disabled', true);
                    $('#attachment').attr('disabled', true);
                    $('#chronological').removeAttr('readonly');
                } else {
                    $('#chronological').attr('readonly', true);
                    $('#corrective').removeAttr('readonly');
                    $('#warning_type').removeAttr('disabled');
                    $('#subject').removeAttr('readonly');
                    $('#warning_date').removeAttr('readonly');
                    $('#result_investigation').removeAttr('readonly');
                    $('#another_note').removeAttr('readonly');
                    $('#status').removeAttr('disabled');
                    $('#attachment').removeAttr('disabled');
                }
            }
        })
    }

    function update_warning() {
        if ($('#warning_type').val() == null) {
            error_alert('Warning type is required!');
        } else if ($('#subject').val() == '') {
            error_alert('Subject is required!');
        } else if ($('#warning_date').val() == '') {
            error_alert('Warning date is required!');
        } else if ($('#status').val() == null) {
            error_alert('Status is required!');
        } else {
            let form = new FormData($('#form_add_warning')[0]);
            $.ajax({
                url: "<?= base_url('warning_letter/update_warning') ?>",
                method: "POST",
                data: form,
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#btn_update_warning').attr('disabled', true);
                },
                success: function(res) {
                    if (res.result == true) {
                        success_alert('Berhasil mengubah data');
                        $('#modal_form_warning').modal('hide');
                        $('#btn_update_warning').removeAttr('disabled');
                        dt_warning_letter()
                    } else {
                        error_alert('Gagal mengubah data');
                        $('#btn_update_warning').removeAttr('disabled');
                    }
                }
            })
        }
    }

    function dt_rekomendasi_warning() {
        company = $('#company').val();
        department = $('#department').val();
        start = $('#start').val();
        end = $('#end').val();

        $('#dt_rekomendasi_warning').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip', // Add Buttons to the DOM
            "buttons": [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-success'
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    company: company,
                    department: department,
                    start: start,
                    end: end
                },
                "url": "<?= base_url(); ?>warning_letter/dt_rekomendasi_warning",
            },
            "columns": [
                {
                    "data": "karyawan"
                },
                {
                    "data": "status",
                    "render": function(data, type, row, meta) {
                        return `<a class="badge bg-warning text-black mb-1" style="cursor:pointer;" onclick='open_rekomendasi(${JSON.stringify(row)})' data-bs-toggle="modal" data-bs-target="#modal_form_rekom_warning"><i class="bi bi-pencil-square"></i> Waiting</a>`;
                    }
                },
                {
                    "data": "company"
                },
                {
                    "data": "department"
                },
                {
                    "data": "designation"
                },
                {
                    "data": "date_of_joining"
                },
                {
                    "data": "tahun",
                    "render": function(data, type, row, meta) {
                        return `${data} Tahun ${row['bulan']} bulan`;
                    }
                },
                {
                    "data": "penalty"
                }
            ]
        });
    }

    $('#btn_rekomendasi_warning').on('click', function() {
        dt_rekomendasi_warning()
        $('#modal_list_rekomendasi').modal('show');
    });

    function open_rekomendasi(data) {
        $('#data_rekom').addClass('d-none');
        $('#div_reject_note').addClass('d-none');
        $('#btn_save_warning_rekom').addClass('d-none');
        $('#form_add_warning_rekom')[0].reset();
        $('#penalty_id').val(data.id);
        $('#company_form_name').val(data.company);
        $('#company_form_rekom').val(data.company_id);
        $('#employee_name').val(data.karyawan);
        $('#employee_rekom').val(data.user_id);
        $('#warning_type_rekom').val(data.tipe);
        $("#warning_type_rekom option:selected").attr('disabled','disabled')
        $('#result_investigation_rekom').val(data.penalty);


        $('#text_karyawan').text(data.karyawan);
        $('#text_company').text(data.company);
        $('#text_department').text(data.department);
        $('#text_designation').text(data.designation);
        $('#text_date_of_joining').text(data.date_of_joining);
        $('#text_masa_kerja').text(data.tahun + ' Tahun ' + data.bulan + ' Bulan');

        $('#profil').css('background-image', 'url("'+data.profil+'")');
        $('#img_profil').attr('src', data.profil);

        console.log('profil ' + data.profil)

    }

    $('#status_penalty_rekom').on('change', function() {
        if ($(this).val() == '1') {
            $('#data_rekom').removeClass('d-none');
            $('#div_reject_note').addClass('d-none');
            $('#btn_save_warning_rekom').removeClass('d-none');
        } else if ($(this).val() == '2') {
            $('#data_rekom').addClass('d-none');
            $('#div_reject_note').removeClass('d-none');
            $('#btn_save_warning_rekom').removeClass('d-none');
        } else {
            $('#data_rekom').addClass('d-none');
            $('#div_reject_note').addClass('d-none');
            $('#btn_save_warning_rekom').addClass('d-none');
        }
    });

    function save_warning_rekom() {
        let form = new FormData($('#form_add_warning_rekom')[0]);
            $.ajax({
                url: "<?= base_url('warning_letter/save_warning_rekom') ?>",
                method: "POST",
                data: form,
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#btn_save_warning_rekom').attr('disabled', true);
                },
                success: function(res) {
                    if (res.result == true) {
                        success_alert('Berhasil menambahkan data');
                        $('#modal_form_rekom_warning').modal('hide');
                        $('#btn_save_warning_rekom').removeAttr('disabled');
                        dt_warning_letter();
                    } else {
                        error_alert('Gagal menambahkan data');
                        $('#btn_save_warning_rekom').removeAttr('disabled');
                    }
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