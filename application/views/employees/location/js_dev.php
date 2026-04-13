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

        dt_location()
    })

    function dt_location() {
        $('#dt_location').DataTable({
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
                "url": "<?= base_url(); ?>employees_dev/dt_location",
            },
            "columns": [{
                    "data": "location_id",
                    "render": function(data, type, row, meta) {
                        return `<a class="badge bg-success text-black mb-1" style="cursor:pointer;" onclick="edit_location('${row['location_id']}')"><i class="bi bi-pencil-square"></i>edit</a>
                        <a class="badge bg-light-red text-black" onclick="delete_location('${row['location_id']}')" style="cursor:pointer;"><i class="bi bi-trash"></i>delete</a>`
                        // <a class="badge bg-light-blue text-black" onclick="modal_details('${row['company_id']}')" style="cursor:pointer;"><i class="bi bi-eye"></i>details</a>
                    },
                    "className": "text-center"
                },
                {
                    "data": "location_name"
                },
                {
                    "data": "user_head"
                },
                {
                    "data": "city",
                    "className": "text-center"
                },
                {
                    "data": "country_name",
                    "className": "text-center"
                },
                {
                    "data": "user_added",
                    "className": "text-center"
                }
            ]
        });
    }

    $('#btn_modal_add_location').on('click', function() {
        $('#modal_form_location').modal('show');
        $('#btn_save_location').removeClass('d-none');
        $('#btn_update_location').addClass('d-none');
        $('#title_form_location').text('Add Location')
    })

    function save_location() {
        form = $('#form_add_location');
        if ($('#company').val() == null) {
            error_alert('Company is required')
        } else if ($('#location').val() == '') {
            error_alert('Location Name is required')
        } else if ($('#country').val() == null) {
            error_alert('Cuntry is required')
        } else if ($('#zip_code').val() == '') {
            error_alert('Zip Code is required')
        } else {
            $.ajax({
                url: "<?= base_url('employees_dev/save_location') ?>",
                method: "POST",
                data: form.serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#btn_save_location').attr('disabled', true);
                },
                success: function(res) {
                    if (res.result == true) {
                        success_alert('Berhasil menambahkan data');
                        $('#modal_form_location').modal('hide');
                        $('#btn_save_location').removeAttr('disabled');
                        $('#dt_location').DataTable().ajax.reload();
                    } else {
                        error_alert('Gagal menambahkan data');
                        $('#btn_save_location').removeAttr('disabled');
                    }
                }
            })
        }
    }

    function edit_location(id) {
        $.ajax({
            url: "<?= base_url('employees_dev/get_detail_location') ?>",
            method: "POST",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function(res) {
                $('#location_id').val(res.location.location_id);
                $('#company').val(res.location.company_id);
                $('#location_head').val(res.location.location_head);
                $('#location').val(res.location.location_name);
                $('#address_1').val(res.location.address_1);
                $('#address_2').val(res.location.address_2);
                $('#phone').val(res.location.phone);
                $('#email').val(res.location.email);
                $('#fax_number').val(res.location.fax);
                $('#city').val(res.location.city);
                $('#state').val(res.location.state);
                $('#zip_code').val(res.location.zipcode);
                $('#country').val(res.location.country);
                $('#modal_form_location').modal('show');
                $('#btn_update_location').removeClass('d-none');
                $('#btn_save_location').addClass('d-none');
                $('#title_form_location').text('Edit Location')
            }
        })
    }

    function update_location() {
        form = $('#form_add_location');
        if ($('#company').val() == null) {
            error_alert('Company is required')
        } else if ($('#location').val() == '') {
            error_alert('Location Name is required')
        } else if ($('#country').val() == null) {
            error_alert('Cuntry is required')
        } else if ($('#zip_code').val() == '') {
            error_alert('Zip Code is required')
        } else {
            $.ajax({
                url: "<?= base_url('employees_dev/update_location') ?>",
                method: "POST",
                data: form.serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#btn_update_location').attr('disabled', true);
                },
                success: function(res) {
                    if (res.result == true) {
                        success_alert('Berhasil menambahkan data');
                        $('#modal_form_location').modal('hide');
                        $('#btn_update_location').removeAttr('disabled');
                        $('#dt_location').DataTable().ajax.reload();
                    } else {
                        error_alert('Gagal menambahkan data');
                        $('#btn_update_location').removeAttr('disabled');
                    }
                }
            })
        }
    }

    function delete_location(id) {
        $.confirm({
            title: 'Delete data',
            content: 'Data Location will be deleted',
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
                                    url: "<?= base_url('employees_dev/delete_location') ?>",
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
                                            $('#dt_location').DataTable().ajax.reload();
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
                                            $('#dt_location').DataTable().ajax.reload();
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