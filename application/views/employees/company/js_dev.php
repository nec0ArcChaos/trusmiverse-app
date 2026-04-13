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
        dt_company()
    })

    function dt_company() {
        $('#dt_company').DataTable({
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
                "url": "<?= base_url(); ?>employees_dev/dt_company",
            },
            "columns": [{
                    "data": "company_id",
                    "render": function(data, type, row, meta) {
                        return `<a class="badge bg-success text-black mb-1" style="cursor:pointer;" onclick="edit_company('${row['company_id']}')"><i class="bi bi-pencil-square"></i>edit</a>
                        <a class="badge bg-light-red text-black" onclick="delete_company('${row['company_id']}')" style="cursor:pointer;"><i class="bi bi-trash"></i>delete</a>`
                        // <a class="badge bg-light-blue text-black" onclick="modal_details('${row['company_id']}')" style="cursor:pointer;"><i class="bi bi-eye"></i>details</a>
                    },
                    "className": "text-center"
                },
                {
                    "data": "name"
                },
                {
                    "data": "email",
                    "render": function(data, type, row, meta) {
                        return `<span style = "font-style :italic;">${data}</span>`
                    }
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

    $('#btn_modal_add_company').on('click', function() {
        $('#modal_form_company').modal('show');
        $('#btn_save_company').removeClass('d-none');
        $('#btn_update_company').addClass('d-none');
        $('#title_form_company').text('Add Company')
    })

    // function check_contract_form() {
    //     isValid = true;
    //     $('#form_add_contract').find('input, select').each(function() {
    //         if (($(this).val()) == '' || $(this).val() == null) {
    //             if ($(this).attr('id') != 'contract_id') {
    //                 error_alert('There is an empty field');
    //                 isValid = false;
    //                 return false;
    //             }
    //         }
    //     });
    //     return isValid;
    // }

    function save_company() {

        if ($('#company_name').val() == '') {
            error_alert('Company Name is required')
        } else if ($('#username').val() == '') {
            error_alert('Username is required')
        } else if ($('#password').val() == '') {
            error_alert('Password is required')
        } else if ($('#company_logo').val() == '') {
            error_alert('Company logo is required')
        } else {
            let form = new FormData($('#form_add_company')[0]);
            $.ajax({
                url: "<?= base_url('employees_dev/save_company') ?>",
                method: "POST",
                data: form,
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#btn_save_company').attr('disabled', true);
                },
                success: function(res) {
                    if (res.result == true) {
                        success_alert('Berhasil menambahkan data');
                        $('#modal_form_company').modal('hide');
                        $('#btn_save_company').removeAttr('disabled');
                        $('#dt_company').DataTable().ajax.reload();
                    } else {
                        error_alert('Gagal menambahkan data');
                        $('#btn_save_company').removeAttr('disabled');
                    }
                }
            })
        }
    }

    function edit_company(id) {
        $.ajax({
            url: "<?= base_url('employees_dev/get_detail_company') ?>",
            method: "POST",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function(res) {
                $('#company_id').val(res.company.company_id);
                $('#company_name').val(res.company.name);
                $('#tax_number').val(res.company.government_tax);
                $('#company_type').val(res.company.type_id);
                $('#legal').val(res.company.trading_name);
                $('#address_1').val(res.company.address_1);
                $('#registration_number').val(res.company.registration_no);
                $('#contact').val(res.company.contact_number);
                $('#address_2').val(res.company.address_2);
                $('#email').val(res.company.email);
                $('#website').val(res.company.website_url);
                $('#city').val(res.company.city);
                $('#state').val(res.company.state);
                $('#zipcode').val(res.company.zipcode);
                $('#country').val(res.company.country);
                $('#username').val(res.company.username);
                $('#password').val(res.company.password);
                $('#modal_form_company').modal('show');
                $('#btn_update_company').removeClass('d-none');
                $('#btn_save_company').addClass('d-none');
                $('#title_form_company').text('Edit Company')
            }
        })
    }

    function update_company() {

        if ($('#company_name').val() == '') {
            error_alert('Company Name is required')
        } else if ($('#username').val() == '') {
            error_alert('Username is required')
        } else if ($('#password').val() == '') {
            error_alert('Password is required')
        } else {
            let form = new FormData($('#form_add_company')[0]);
            $.ajax({
                url: "<?= base_url('employees_dev/update_company') ?>",
                method: "POST",
                data: form,
                dataType: "JSON",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#btn_update_company').attr('disabled', true);
                },
                success: function(res) {
                    if (res.result == true) {
                        success_alert('Berhasil mengubah data');
                        $('#modal_form_company').modal('hide');
                        $('#btn_update_company').removeAttr('disabled');
                        $('#dt_company').DataTable().ajax.reload();
                    } else {
                        error_alert('Gagal mengubah data');
                        $('#btn_update_company').removeAttr('disabled');
                    }
                }
            })
        }
    }

    function delete_company(id) {
        $.confirm({
            title: 'Delete data',
            content: 'Data Company will be deleted',
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
                                    url: "<?= base_url('employees_dev/delete_company') ?>",
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
                                            $('#dt_company').DataTable().ajax.reload();
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
                                            $('#dt_company').DataTable().ajax.reload();
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