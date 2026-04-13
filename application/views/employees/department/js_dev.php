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
    var working_location_select;
    $(document).ready(function() {
        employee_select = NiceSelect.bind(document.getElementById('department_head'), {
            searchable: true,
            isAjax: false,
        });

        working_location_select = NiceSelect.bind(document.getElementById('work_location'), {
            searchable: true,
            isAjax: false,
        });

        dt_department()
    })

    function dt_department() {
        $('#dt_department').DataTable({
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
                "url": "<?= base_url(); ?>employees_dev/dt_department",
            },
            "columns": [{
                    "data": "department_id",
                    "render": function(data, type, row, meta) {
                        return `<a class="badge bg-success text-black mb-1" style="cursor:pointer;" onclick="edit_department('${row['department_id']}','${row['department_name']}','${row['location_id']}','${row['company_id']}','${row['head_id']}','${row['break']}','${row['work_location_id']}')"><i class="bi bi-pencil-square"></i>edit</a>
                        <a class="badge bg-light-red text-black" onclick="delete_department('${row['department_id']}')" style="cursor:pointer;"><i class="bi bi-trash"></i>delete</a>`
                        // <a class="badge bg-light-blue text-black" onclick="modal_details('${row['company_id']}')" style="cursor:pointer;"><i class="bi bi-eye"></i>details</a>
                    },
                    "className": "text-center"
                },
                {
                    "data": "department_name"
                },
                {
                    "data": "working_location_name",
                    "render": function(data) {
                        return data ? data : '-';
                    }
                },
                {
                    "data": "location_name"
                },
                {
                    "data": "company_name",
                },
                {
                    "data": "total_emp",
                },
                {
                    "data": "head",
                }
            ]
        });
    }

    $('#btn_modal_add_department').on('click', function() {
        $('#modal_form_department').modal('show');
        $('#btn_save_department').removeClass('d-none');
        $('#btn_update_department').addClass('d-none');
        $('#title_form_department').text('Add Department')
    })

    $('#company').on('change', function() {
        get_location();
        get_employee();
    })

    function get_location(id = null, company = null) {
        if (company == null) {
            company = $('#company').val();
        }
        if (company != null) {
            $.ajax({
                url: "<?= base_url('employees_dev/get_location') ?>",
                method: "POST",
                data: {
                    company: company,
                    location: id
                },
                dataType: "JSON",
                success: function(res) {
                    locations = '<option value = "#" selected disabled>-- Choose Location s--</option>';
                    res.location.forEach(element => {
                        locations += `<option value = "${element['location_id']}" ${element['selected'] == 1 ? 'selected' : ''}> ${element['location_name']}</option>`;
                    });
                    $('#location').html('');
                    $('#location').append(locations);
                }
            })
        }
    }

    function get_employee(id = null, company = null) {
        if (company == null) {
            company = $('#company').val();
        }
        if (company != null) {
            $.ajax({
                url: "<?= base_url('employees_dev/get_employee') ?>",
                method: "POST",
                data: {
                    company_id: company,
                    id: id
                },
                dataType: "JSON",
                success: function(res) {
                    employee = '<option value = "#" selected disabled>-- Choose Head --</option>';
                    res.employee.forEach(element => {
                        employee += `<option value = "${element['user_id']}" ${element['selected'] == 1 ? 'selected' : ''}> ${element['employee_name']}</option>`;
                    });
                    $('#department_head').html('');
                    $('#department_head').append(employee);
                    employee_select.update();
                }
            })
        }
    }

    function save_department() {
        form = $('#form_add_department');
        if ($('#name').val() == '') {
            error_alert('Name is required')
        } else if ($('#company').val() == null) {
            error_alert('Company is required')
        } else if ($('#location').val() == null) {
            error_alert('Location is required')
        } else if ($('#work_location').val() == null || $('#work_location').val() == '') {
            error_alert('Working Location is required')

        } else if ($('#department_head').val() == null) {
            error_alert('Department Head is required')
        } else if ($('#break').val() == null) {
            error_alert('Break is required')
        } else {
            $.ajax({
                url: "<?= base_url('employees_dev/save_department') ?>",
                method: "POST",
                data: form.serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#btn_save_department').attr('disabled', true);
                },
                success: function(res) {
                    if (res.result == true) {
                        success_alert('Berhasil menambahkan data');
                        $('#modal_form_department').modal('hide');
                        $('#btn_save_department').removeAttr('disabled');
                        $('#dt_department').DataTable().ajax.reload();
                    } else {
                        error_alert('Gagal menambahkan data');
                        $('#btn_save_department').removeAttr('disabled');
                    }
                }
            })
        }
    }

    function edit_department(department_id, department_name, location_id, company_id, head_id, breaks, work_location_id) {

        $('#department_id').val(department_id);
        $('#location').val(location_id);
        $('#company').val(company_id);
        $('#name').val(department_name);
        $('#break').val(breaks);
        get_location(location_id, company_id);
        get_employee(head_id, company_id);
        $('#modal_form_department').modal('show');
        $('#btn_update_department').removeClass('d-none');
        $('#btn_save_department').addClass('d-none');
        $('#title_form_department').text('Edit Department')
        var val_work = (work_location_id === 'null' || work_location_id === null) ? '' : work_location_id;
        $('#work_location').val(val_work);

        if (typeof working_location_select !== 'undefined') {
            working_location_select.update();
        }
    }

    function update_department() {
        form = $('#form_add_department');
        if ($('#name').val() == '') {
            error_alert('Name is required')
        } else if ($('#work_location').val() == null || $('#work_location').val() == '') {
            error_alert('Working Location is required')
        } else if ($('#company').val() == null) {
            error_alert('Company is required')
        } else if ($('#location').val() == null) {
            error_alert('Location is required')
        } else if ($('#department_head').val() == null) {
            error_alert('Department Head is required')
        } else if ($('#break').val() == null) {
            error_alert('Break is required')
        } else {
            $.ajax({
                url: "<?= base_url('employees_dev/update_department') ?>",
                method: "POST",
                data: form.serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#btn_update_department').attr('disabled', true);
                },
                success: function(res) {
                    if (res.result == true) {
                        success_alert('Berhasil menambahkan data');
                        $('#modal_form_department').modal('hide');
                        $('#btn_update_department').removeAttr('disabled');
                        $('#dt_department').DataTable().ajax.reload();
                    } else {
                        error_alert('Gagal menambahkan data');
                        $('#btn_update_department').removeAttr('disabled');
                    }
                }
            })
        }
    }

    function delete_department(id) {
        $.confirm({
            title: 'Delete data',
            content: 'Data Department will be deleted',
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
                                    url: "<?= base_url('employees_dev/delete_department') ?>",
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
                                            $('#dt_department').DataTable().ajax.reload();
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
                                            $('#dt_department').DataTable().ajax.reload();
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

    // === TAMBAHAN FUNCTION ===

    function open_modal_new_location() {
        // Reset form sebelum dibuka
        $('#form_new_location')[0].reset();
        $('#modal_add_location').modal('show');
    }

    function save_new_location() {
        var location_name = $('#new_location_name').val();
        var is_public = $('#new_location_public').is(':checked') ? 1 : 0;

        if (location_name == '') {
            error_alert('Location Name is required');
            return;
        }

        $.ajax({
            url: "<?= base_url('employees_dev/save_working_location_ajax') ?>", // Endpoint baru
            method: "POST",
            dataType: "JSON",
            data: {
                lokasi: location_name,
                is_public: is_public
            },
            beforeSend: function() {
                // Opsional: disable tombol save agar tidak double click
            },
            success: function(res) {
                if (res.status == true) {
                    success_alert('Location added successfully');

                    // 1. Tutup Modal
                    $('#modal_add_location').modal('hide');

                    // 2. Tambahkan Option Baru ke Select Asli
                    var newOption = new Option(res.data.lokasi, res.data.id, true, true);
                    $('#work_location').append(newOption).trigger('change');

                    // 3. Refresh NiceSelect2 agar Option baru muncul di UI
                    if (typeof working_location_select !== 'undefined') {
                        working_location_select.update();
                    }

                } else {
                    error_alert(res.message);
                }
            },
            error: function() {
                error_alert('Error saving data');
            }
        });
    }
</script>