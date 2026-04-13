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
    $(document).ready(function() {
        department_select = NiceSelect.bind(document.getElementById('department'), {
            searchable: true,
            isAjax: false,
        });
        shift_select = NiceSelect.bind(document.getElementById('shift'), {
            searchable: true,
            isAjax: false,
        });
        dt_designation()
    })

    function dt_designation() {
        $('#dt_designation').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "dom": 'Bfrtip', // Add Buttons to the DOM
            "buttons": [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-success'
            }],
            "destroy": true,
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": "<?= base_url(); ?>employees_dev/dt_designation",
            },
            "columns": [{
                    "data": "designation_id",
                    "render": function(data, type, row, meta) {
                        return `<a class="badge bg-success text-black mb-1" style="cursor:pointer;" onclick="edit_designation('${row['designation_name']}','${row['designation_id']}','${row['department_id']}','${row['company_id']}','${row['trusmi_shift']}')"><i class="bi bi-pencil-square"></i>edit</a>
                        <a class="badge bg-light-red text-black" onclick="delete_designation('${row['designation_id']}')" style="cursor:pointer;"><i class="bi bi-trash"></i>delete</a>`
                        // <a class="badge bg-light-blue text-black" onclick="modal_details('${row['company_id']}')" style="cursor:pointer;"><i class="bi bi-eye"></i>details</a>
                    },
                    "className": "text-center"
                },
                {
                    "data": "designation_name"
                },
                {
                    "data": "department_name"
                },
                {
                    "data": "company_name",
                }
            ]
        });
    }

    $('#btn_modal_add_designation').on('click', function() {
        $('#modal_form_designation').modal('show');
        $('#btn_save_designation').removeClass('d-none');
        $('#btn_update_designation').addClass('d-none');
        $('#title_form_designation').text('Add Department')
    })

    $('#company').on('change', function() {
        get_department();
    })

    function get_department(id = null, company = null) {
        if (company == null) {
            company = $('#company').val();
        }
        if (company != null) {
            $.ajax({
                url: "<?= base_url('employees_dev/get_department') ?>",
                method: "POST",
                data: {
                    company: company,
                    id_department: id
                },
                dataType: "JSON",
                success: function(res) {
                    department = '<option value = "#" selected disabled>-- Choose Department--</option>';
                    res.department.forEach(element => {
                        department += `<option value = "${element['department_id']}" ${element['selected'] == 1 ? 'selected' : ''}> ${element['department_name']}</option>`;
                    });
                    $('#department').html('');
                    $('#department').append(department);
                    department_select.update();
                }
            })
        }
    }

    function save_designation() {
        form = $('#form_add_designation');
        if ($('#name').val() == '') {
            error_alert('Name is required')
        } else if ($('#company').val() == null) {
            error_alert('Company is required')
        } else if ($('#department').val() == null) {
            error_alert('Department is required')
        } else {
            $.ajax({
                url: "<?= base_url('employees_dev/save_designation') ?>",
                method: "POST",
                data: form.serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#btn_save_designation').attr('disabled', true);
                },
                success: function(res) {
                    if (res.result == true) {
                        success_alert('Berhasil menambahkan data');
                        $('#modal_form_designation').modal('hide');
                        $('#btn_save_designation').removeAttr('disabled');
                        $('#dt_designation').DataTable().ajax.reload();
                    } else {
                        error_alert('Gagal menambahkan data');
                        $('#btn_save_designation').removeAttr('disabled');
                    }
                }
            })
        }
    }

    function edit_designation(designation_name, designation_id, department_id, company_id, trusmi_shift) {
        $('#designation_id').val(designation_id);
        $('#shift').val(trusmi_shift);
        $('#company').val(company_id);
        $('#name').val(designation_name);
        get_department(department_id, company_id);
        shift_select.update();
        $('#modal_form_designation').modal('show');
        $('#btn_update_designation').removeClass('d-none');
        $('#btn_save_designation').addClass('d-none');
        $('#title_form_designation').text('Edit Designation')
    }

    function update_designation() {
        form = $('#form_add_designation');
        if ($('#name').val() == '') {
            error_alert('Name is required')
        } else if ($('#company').val() == null) {
            error_alert('Company is required')
        } else if ($('#department').val() == null) {
            error_alert('Department is required')
        } else {
            $.ajax({
                url: "<?= base_url('employees_dev/update_designation') ?>",
                method: "POST",
                data: form.serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#btn_update_designation').attr('disabled', true);
                },
                success: function(res) {
                    if (res.result == true) {
                        success_alert('Berhasil mengubah data');
                        $('#modal_form_designation').modal('hide');
                        $('#btn_update_designation').removeAttr('disabled');
                        $('#dt_designation').DataTable().ajax.reload();
                    } else {
                        error_alert('Gagal mengubah data');
                        $('#btn_update_designation').removeAttr('disabled');
                    }
                }
            })
        }
    }

    function delete_designation(id) {
        $.confirm({
            title: 'Delete data',
            content: 'Data Designation will be deleted',
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
                                    url: "<?= base_url('employees_dev/delete_designation') ?>",
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
                                            $('#dt_designation').DataTable().ajax.reload();
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
                                            $('#dt_designation').DataTable().ajax.reload();
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