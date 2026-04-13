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

        dt_employees();
        company_select = NiceSelect.bind(document.getElementById('company_edit'), {
            searchable: true,
            isAjax: false,
        });
        add_company_select = NiceSelect.bind(document.getElementById('add_company'), {
            searchable: true,
            isAjax: false,
        });
        add_posisi_select = NiceSelect.bind(document.getElementById('add_posisi'), {
            searchable: true,
            isAjax: false,
        });
        posisi_select = NiceSelect.bind(document.getElementById('posisi'), {
            searchable: true,
            isAjax: false,
        });
        location_select = NiceSelect.bind(document.getElementById('location_edit'), {
            searchable: true,
            isAjax: false,
        });
        add_location_select = NiceSelect.bind(document.getElementById('add_location'), {
            searchable: true,
            isAjax: false,
        });
        department_select = NiceSelect.bind(document.getElementById('department_edit'), {
            searchable: true,
            isAjax: false,
        });
        add_department_select = NiceSelect.bind(document.getElementById('add_department'), {
            searchable: true,
            isAjax: false,
        });
        designation_select = NiceSelect.bind(document.getElementById('designation_edit'), {
            searchable: true,
            isAjax: false,
        });
        add_designation_select = NiceSelect.bind(document.getElementById('add_designation'), {
            searchable: true,
            isAjax: false,
        });
        role_select = NiceSelect.bind(document.getElementById('role_edit'), {
            searchable: true,
            isAjax: false,
        });
        add_role_select = NiceSelect.bind(document.getElementById('add_role'), {
            searchable: true,
            isAjax: false,
        });
        office_shift_select = NiceSelect.bind(document.getElementById('office_shift'), {
            searchable: true,
            isAjax: false,
        });
        add_office_shift_select = NiceSelect.bind(document.getElementById('add_office_shift'), {
            searchable: true,
            isAjax: false,
        });
        affiliate_select = NiceSelect.bind(document.getElementById('affiliate_pt'), {
            searchable: true,
            isAjax: false,
        });
        add_affiliate_select = NiceSelect.bind(document.getElementById('add_affiliate_pt'), {
            searchable: true,
            isAjax: false,
        });

        // addnew
        // cutoff_select = NiceSelect.bind(document.getElementById('cutoff'), {
        //     searchable: true,
        //     isAjax: false,
        // });

        $(document).on('change', '#company_edit', function() {
            get_location(null, null, 'edit');
            get_department(null, null, 'edit');
        })
        $(document).on('change', '#department_edit', function() {
            get_designation(null, null, null, 'edit');
        })
    })

    function dt_employees() {
        $('#dt_employees').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',

            "responsive": true,
            "buttons": [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": "<?= base_url(); ?>employees_dev/dt_employees",
            },
            "columns": [{
                    "data": "user_id",
                    "render": function(data, type, row, meta) {
                        return `<a class="badge bg-light-yellow text-black mb-1" style="cursor:pointer;" onclick="modal_reset_password('${row['user_id']}')"><i class="bi bi-key-fill"></i> Reset Pass.</a>
                        <br>
                        <a class="badge bg-light-blue text-black" onclick="modal_details('${row['user_id']}')" style="cursor:pointer;"><i class="bi bi-eye"></i> Details</a>`
                    }
                },
                {
                    "data": "employee_name",
                    "render": function(data, type, row, meta) {
                        return `
                                <div class="row">
                                    <div class="col">
                                        ${row['employee_name']}<br>
                                        <small class="text-muted seanhr-text-info-margin"><i>ID: ${row['employee_id']}<i></i></i></small><br>
                                        <small class="text-muted seanhr-text-info-margin"><i>Shift: ${row['shift_name']}<i></i></i></small><br>
                                        <small class="text-muted seanhr-text-info-margin">
                                            <i><a target="_blank" href="https://trusmiverse.com/hr/admin/employees/download_profile/${row['user_id']}">Download Profile <i class="fa fa-arrow-circle-right"></i></a><i></i></i>
                                        </small>
                                    </div>
                                </div>
                                    `
                    }
                },
                {
                    "data": "company_name",
                    "render": function(data, type, row, meta) {
                        var grade = '';
                        if (row['ctm_grade'] != null) {
                            grade = ' (' + row['ctm_grade'] + ')';
                        } else {
                            grade = '';
                        }
                        return `${row['company_name']}<br>
                        <small class="text-muted"><i>Location: ${row['location_name']}<i></i></i></small><br>
                        <small class="text-muted"><i>Department: ${row['department_name']}<i></i></i></small><br>
                        <small class="text-muted"><i>Designation: ${row['designation_name']+''+grade}<i></i></i></small>`
                    }
                },
                {
                    "data": "contact_no",
                    "render": function(data, type, row, meta) {
                        return `<i class="fa fa-user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Username"></i> ${row['username']}<br>
                        <i class="fa fa-envelope" data-toggle="tooltip" data-placement="top" title="" data-original-title="Email"></i> ${row['email']}<br>
                        <i class="fa fa-phone" data-toggle="tooltip" data-placement="top" title="" data-original-title="Contact Number"></i> ${row['contact_no']}`
                    }

                },
                {
                    "data": "role_name",
                    "render": function(data, type, row, meta) {
                        if (row['is_active'] == 1) {
                            badge = `<span class="badge bg-green">Active</span>`
                        } else {
                            badge = `<span class="badge bg-red">Non Active</span>`
                        }
                        return `
                                ${row['role_name']}<br>
                                ${badge}<br>
                                <small>Updated : ${row['updated_at']}</small><br>
                                <small>By : ${row['updated_by']}</small>
                                `
                    }

                },
            ]
        });
    }

    function modal_reset_password(user_id) {
        $.confirm({
            icon: 'bi bi-exclamation-diamond',
            title: 'Alert',
            type: 'green',
            content: 'Apakah anda yakin ingin reset password user ini?',
            columnClass: 'col-12 col-md-6 col-lg-4',
            closeIcon: true,
            closeIconClass: 'mdi mdi-close-box',
            draggable: true,
            dragWindowGap: 10,
            theme: 'bootstrap',
            animateFromElement: false,
            buttons: {
                tutup: {
                    btnClass: 'btn btn-secondary',
                    action: function() {}
                },
                simpan: {
                    text: 'Ya, simpan!',
                    btnClass: 'btn btn-primary',
                    action: function() {
                        $.ajax({
                            url: '<?= base_url() ?>employees/reset_password',
                            type: 'POST',
                            data: {
                                user_id: user_id,
                            },
                            success: function(response) {
                                if (response == 'true') {

                                    $.alert({
                                        type: 'green',
                                        theme: 'bootstrap',
                                        animateFromElement: false,
                                        columnClass: 'col-12 col-md-6 col-lg-4',
                                        icon: 'bi bi-check-circle',
                                        title: 'Sukses!',
                                        content: 'Password User berhasil direset',
                                        buttons: {
                                            ok: function() {}
                                        }
                                    });
                                } else {
                                    $.alert({
                                        type: 'red',
                                        theme: 'bootstrap',
                                        animateFromElement: false,
                                        columnClass: 'col-12 col-md-6 col-lg-4',
                                        icon: 'bi bi-exclamation-octagon',
                                        title: 'Gagal!',
                                        content: 'Password User gagal direset, silahkan refresh dahulu dan coba lagi.',
                                        buttons: {
                                            ok: function() {}
                                        }
                                    });
                                }
                            },
                            error: function() {
                                $.alert({
                                    type: 'red',
                                    theme: 'bootstrap',
                                    animateFromElement: false,
                                    columnClass: 'col-12 col-md-6 col-lg-4',
                                    icon: 'bi bi-exclamation-octagon',
                                    title: 'Error!',
                                    content: 'Terjadi kesalahan saat reset akun user, coba lagi/ coba lagi nanti.',
                                });
                            }
                        });
                    }
                },
            }
        });
    }
    $('.tab-link').on('click', function(e) {
        e.preventDefault();
        var target2 = $(this).data('target2');

        $('.content-section').hide(); // Hide all sections
        $('#' + target2).show(); // Show the selected section
    });

    function modal_form(tipe) {
        if (tipe == 1) {
            reset_all_input('form_family');
            $('#title_form_family').text('Add Family');
            $('#btn_save_family').removeClass('d-none');
            $('#btn_update_family').addClass('d-none');
            $('input[name="family_nama"]').val('');
            $('input[name="family_tempat_lahir"]').val('');
            $('input[name="family_pekerjaan"]').val('');
            $('input[name="family_no_hp"]').val('');
            $('input[name="family_tgl_lahir"]').val('');
            $('select[name="family_status"]').val('');
            $('select[name="family_gender"]').val('');
            $('select[name="family_pendidikan"]').val('');
            $('#modal_form_family').modal('show');
        } else if (tipe == 2) {
            $('#modal_form_education').modal('show');
            $('#title_form_education').text('Add Education');
            $('#btn_save_education').removeClass('d-none');
            $('#btn_update_education').addClass('d-none');
        } else if (tipe == 3) {
            $('#modal_form_work').modal('show');
            $('#title_form_work').text('Add Work Experience');
            $('#btn_save_work').removeClass('d-none');
            $('#btn_update_work').addClass('d-none');
        } else if (tipe == 4) {
            $('#modal_form_contract').modal('show');
            $('#title_form_contract').text('Add Contract');
            $('#btn_save_contract').removeClass('d-none');
            $('#btn_update_contract').addClass('d-none');
        }
    }

    $('#form_basic_info').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        $.confirm({
            title: 'Anda Yakin!',
            type: 'blue',
            theme: 'material',
            content: 'Anda yakin ingin melakukan perubahan data?',
            buttons: {
                cancel: function() {
                    // close
                },
                formSubmit: {
                    text: 'Yes',
                    btnClass: 'btn-blue',
                    action: function() {
                        $.confirm({
                            icon: 'fa fa-spinner fa-spin',
                            title: 'Mohon Tunggu!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Sedang memproses...',
                            buttons: {
                                close: {
                                    isHidden: true,
                                    action: function() {}
                                },
                            },
                            onOpen: function() {
                                $.ajax({
                                    url: url,
                                    type: 'POST',
                                    data: form.serialize(),
                                    dataType: 'json',
                                    beforeSend: function() {},
                                    success: function(response) {},
                                    error: function(xhr) {},
                                    complete: function() {},
                                }).done(function(response) {
                                    $("#dt_employees").DataTable().ajax.reload();
                                    $("#modal_details").modal('hide');
                                    setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-check',
                                            title: 'Done!',
                                            theme: 'material',
                                            type: 'blue',
                                            content: 'Data berhasil di update!',
                                            autoClose: 'ok|3000',
                                        });
                                    }, 250);
                                }).fail(function(jqXHR, textStatus) {
                                    setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-close',
                                            title: 'Oops!',
                                            theme: 'material',
                                            type: 'red',
                                            content: 'Error! data gagal di update',
                                            autoClose: 'ok|3000',
                                        });
                                    }, 250);
                                });
                            },
                        });
                    }
                },
            },
        });
    });

    function modal_details(user_id) {

        $('#modal_details').modal('show');
        $('.user_id').val(user_id);
        var t_family = $('#data_family').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
            ],
            "buttons": [{
                text: '<i class="bi bi-plus-circle-dotted"></i> Add',
                className: 'badge bg-primary',
                action: function(e, dt, node, config) {
                    modal_form(1);
                }
            }]
        });
        var table = $('#data_qualify').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
            ],
            "buttons": [{
                text: '<i class="bi bi-plus-circle-dotted"></i> Add',
                className: 'badge bg-primary',
                action: function(e, dt, node, config) {
                    modal_form(2);
                }
            }]
        });
        var table2 = $('#data_work_exp').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
            ],
            "buttons": [{
                text: '<i class="bi bi-plus-circle-dotted"></i> Add',
                className: 'badge bg-primary',
                action: function(e, dt, node, config) {
                    modal_form(3);
                }
            }]
        });
        var table3 = $('#data_contract').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
            ],
            "buttons": [{
                text: '<i class="bi bi-plus-circle-dotted"></i> Add',
                className: 'badge bg-primary',
                action: function(e, dt, node, config) {
                    modal_form(4);
                }
            }]
        });
        $.ajax({
            type: "POST",
            url: "<?= base_url('employees_dev/get_detail_employee'); ?>",
            data: {
                user_id: user_id
            },
            dataType: "json",
            success: function(response) {
                $.each(response.basic, function(index, value) {
                    if (index == 'gender') {
                        $('#gender_edit').val(value);
                    } else if (index == 'status_active') {
                        $('#status_active').val(value);
                    } else if (index == 'company_id') {
                        get_company(value);
                    } else if (index == 'user_role_id') {
                        get_role(value);
                    } else if (index == 'office_shift_id') {
                        get_office_shift(value);
                    } else if (index == 'ctm_pt') {
                        get_affiliate_pt(value);
                    } else if (index == 'location_id') {
                        get_location(value, response.basic.company_id, 'edit');
                    } else if (index == 'department_id') {
                        get_department(value, response.basic.company_id, 'edit');
                    } else if (index == 'designation_id') {
                        get_designation(value, response.basic.department_id, response.basic.company_id, 'edit');
                    } else if (index == 'leave_categories') {
                        get_leave_category(value);
                    } else if (index == 'view_companies_id') {
                        get_company_data(value);
                    } else if (index == 'posisi') {
                        get_posisi(value);
                    } else if (index == 'ctm_cutoff') { // addnew
                        $('#cutoff').val(value);
                    } else {
                        $('#' + index).val(value);
                    }
                });

                t_family.clear();
                $.each(response.family, function(index, value) {
                    t_family.row.add([
                        `<span class="badge bg-light-yellow text-black edit_family" style='cursor:pointer' data-id="${value.id}" data-status="${value.status}" data-nama="${value.nama}" data-gender="${value.jenis_kelamin}" data-tempat_lahir="${value.tempat_lahir}" data-tgl_lahir="${value.tgl_lahir}" data-pendidikan="${value.id_pendidikan}" data-pekerjaan="${value.pekerjaan}" data-no_hp="${value.no_hp}"><i class="bi bi-pen-fill"></i> Edit</span><span class="badge bg-light-red text-black delete_family" style='cursor:pointer' data-id="${value.id}"><i class="bi bi-trash-fill"></i> Del.</span>`,
                        value.status,
                        value.nama,
                        value.jenis_kelamin,
                        value.tempat_lahir,
                        value.pendidikan,
                        value.pekerjaan,
                    ]).draw(false);
                });


                table.clear();

                $.each(response.qualifi, function(index, value) {
                    table.row.add([
                        `<span class="badge bg-light-yellow text-black edit_qualification" style='cursor:pointer' data-id="${value.qualification_id}" data-name="${value.name}" data-education_level_id="${value.education_level_id}" data-from_year="${value.from_year}" data-to_year="${value.to_year}" data-skill_id="${value.skill_id}" data-description="${value.description}" data-language_id="${value.language_id}"><i class="bi bi-pen-fill"></i> Edit</span><span class="badge bg-light-red text-black delete_qualification" style='cursor:pointer' data-id="${value.qualification_id}"><i class="bi bi-trash-fill"></i> Del.</span>`,
                        value.level,
                        value.name,
                        value.from_year + ' - ' + value.to_year,
                    ]).draw(false);
                });

                table2.clear();

                $.each(response.work_exp, function(index, value) {
                    table2.row.add([
                        `<span class="badge bg-light-yellow text-black edit_work_exp" style='cursor:pointer' data-id="${value.id}" data-nama_perusahaan="${value.nama_perusahaan}" data-salary_awal="${value.salary_awal}" data-salary_akhir="${value.salary_akhir}" data-alasan_keluar="${value.alasan_keluar}" data-lokasi="${value.lokasi}" data-posisi="${value.posisi}" data-tahun_masuk="${value.tahun_masuk}" data-tahun_keluar="${value.tahun_keluar}"><i class="bi bi-pen-fill"></i> Edit</span><span class="badge bg-light-red text-black delete_work_exp" style='cursor:pointer' data-id="${value.id}"><i class="bi bi-trash-fill"></i> Del.</span>`,
                        value.nama_perusahaan,
                        value.lokasi,
                        value.posisi,
                        value.tahun_masuk + ' - ' + value.tahun_keluar,
                    ]).draw(false);
                });

                table3.clear();

                $.each(response.contract, function(index, value) {
                    table3.row.add([
                        `<span class="badge bg-light-yellow text-black edit_contract" style='cursor:pointer' data-id="${value.contract_id}" data-status="${value.is_active}" data-contract_type_id="${value.contract_type_id}" data-title="${value.title}" data-from_date="${value.from_date}" data-to_date="${value.to_date}" data-description="${value.description}"><i class="bi bi-pen-fill"></i> Edit</span><span class="badge bg-light-red text-black delete_contract" data-id="${value.contract_id}" style='cursor:pointer'><i class="bi bi-trash-fill"></i> Del.</span>`,
                        value.title,
                        value.description,
                        value.from_date + ' s/d ' + value.to_date,
                        value.status,
                    ]).draw(false);
                });

            }
        });

        // Optional: Handle Save and Delete actions for the new rows
        $('#data_family tbody').on('click', '.bg-green', function() {
            var row = $(this).closest('tr');
            var data = t_family.row(row).data();
            var formData = {
                status: $('select[name="status_add"]').val(),
                nama: $('input[name="nama_add"]').val(),
                gender: $('select[name="gender_add"]').val(),
                tempat_lahir: $('input[name="tempat_lahir_add"]').val(),
                pendidikan: $('select[name="pendidikan_add"]').val(),
                pekerjaan: $('input[name="pekerjaan_add"]').val(),
            };
            $.ajax({
                type: "POST",
                url: "<?= base_url('employees/insert_family'); ?>",
                data: formData,
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $("#data_family").DataTable().ajax.reload();
                }
            });
            // row.find('form').remove();
        });

        $('#data_family tbody').on('click', '.bg-secondary', function() {
            t_family.row($(this).closest('tr')).remove().draw();
        });
    }

    function reset_all_input(formId) {
        var form = $('#' + formId).get();
        console.log(form);
    }

    function get_company(id_company = null) {
        if (id_company == null) {
            company = '<option value = "#" selected disabled>-- Choose Company --</option>'
        } else {
            company = '';
        }
        $.ajax({
            url: "<?= base_url('employees_dev/get_company') ?>",
            method: "POST",
            data: {
                id_company: id_company
            },
            dataType: "JSON",
            success: function(res) {
                res.company.forEach(element => {
                    company += `<option value = "${element['company_id']}" ${element['selected'] == 1 ? 'selected' : ''}>${element['name']}</option>`;
                });
                if (id_company == null) {
                    $('#add_company').html('');
                    $('#add_company').append(company);
                    add_company_select.update();
                } else {
                    $('#company_edit').html('');
                    $('#company_edit').append(company);
                    company_select.update();
                }
            }
        })
    }

    function get_posisi(id_posisi = null) {
        if (id_posisi == null) {
            posisi = '<option value = "#" selected disabled>-- Choose Position --</option>'
        } else {
            posisi = '';
        }
        $.ajax({
            url: "<?= base_url('employees_dev/get_posisi') ?>",
            method: "POST",
            data: {
                id_posisi: id_posisi
            },
            dataType: "JSON",
            success: function(res) {
                res.posisi.forEach(element => {
                    posisi += `<option value = "${element['role_name']}" ${element['selected'] == 1 ? 'selected' : ''}>${element['role_name']}</option>`;
                });
                if (id_posisi == null) {
                    $('#add_posisi').html('');
                    $('#add_posisi').append(posisi);
                    add_posisi_select.update();
                } else {
                    $('#posisi').html('');
                    $('#posisi').append(posisi);
                    posisi_select.update();
                }
            }
        })
    }

    function get_role(id_role = null) {
        if (id_role == null) {
            role = '<option value = "#" selected disabled>-- Choose Company --</option>'
        } else {
            role = '';
        }
        $.ajax({
            url: "<?= base_url('employees_dev/get_role') ?>",
            method: "POST",
            data: {
                id_role: id_role
            },
            dataType: "JSON",
            success: function(res) {
                res.role.forEach(element => {
                    role += `<option value = "${element['role_id']}" ${element['selected'] == 1 ? 'selected' : ''}>${element['role_name']}</option>`;
                });
                if (id_role == null) {
                    $('#add_role').html('');
                    $('#add_role').append(role);
                    add_role_select.update();
                } else {
                    $('#role_edit').html('');
                    $('#role_edit').append(role);
                    role_select.update();
                }
            }
        })
    }

    function get_location(id_location = null, id_company = null, ket = null) {
        if (ket == 'edit') {
            id_company2 = $('#company_edit').val();
        } else {
            id_company2 = $('#add_company').val();
        }
        if (id_location != null) {
            lokasi = '';
            company = id_company;
        } else {
            lokasi = '<option selected disabled value = "#">-- Choose Location --</option>';
            company = id_company2;
        }
        if (company != null && company != '') {
            $.ajax({
                url: "<?= base_url('employees_dev/get_location') ?>",
                method: "POST",
                data: {
                    company: company,
                    location: id_location
                },
                dataType: "JSON",
                success: function(res) {
                    res.location.forEach(element => {
                        lokasi += `<option value = "${element['location_id']}" ${element['selected'] == 1 ? 'selected' : ''}>${element['location_name']}</option>`;
                    });
                    if (ket == 'edit') {
                        $('#location_edit').html('');
                        $('#location_edit').append(lokasi);
                        location_select.update();
                    } else {
                        $('#add_location').html('');
                        $('#add_location').append(lokasi);
                        add_location_select.update();
                    }
                }
            })
        }
    }

    function get_office_shift(id_office_shift = null) {
        if (id_office_shift != null) {
            office = '';
        } else {
            office = '<option selected disabled value = "#">-- Choose Office Shift --</option>';
        }
        $.ajax({
            url: "<?= base_url('employees_dev/get_office_shift') ?>",
            method: "POST",
            data: {
                id_office_shift: id_office_shift
            },
            dataType: "JSON",
            success: function(res) {
                res.office.forEach(element => {
                    office += `<option value = "${element['office_shift_id']}" ${element['selected'] == 1 ? 'selected' : ''}>${element['shift_name']}</option>`;
                });
                if (id_office_shift == null) {
                    $('#add_office_shift').html('');
                    $('#add_office_shift').append(office);
                    add_office_shift_select.update();
                } else {
                    $('#office_shift').html('');
                    $('#office_shift').append(office);
                    office_shift_select.update();
                }
            }
        })
    }

    function get_department(id_department = null, id_company = null, ket = null) {
        if (ket == 'edit') {
            id_company2 = $('#company_edit').val();
        } else {
            id_company2 = $('#add_company').val();
        }
        if (id_department != null) {
            department = '';
            company = id_company;
        } else {
            department = '<option selected disabled value = "#">-- Choose Department --</option>';
            company = id_company2;
        }
        if (company != null && company != '') {
            $.ajax({
                url: "<?= base_url('employees_dev/get_department') ?>",
                method: "POST",
                data: {
                    company: company,
                    id_department: id_department
                },
                dataType: "JSON",
                success: function(res) {
                    res.department.forEach(element => {
                        department += `<option value = "${element['department_id']}" ${element['selected'] == 1 ? 'selected' : ''}>${element['department_name']}</option>`;
                    });
                    if (ket == 'edit') {
                        $('#department_edit').html('');
                        $('#department_edit').append(department);
                        department_select.update();
                    } else {
                        $('#add_department').html('');
                        $('#add_department').append(department);
                        add_department_select.update();
                    }
                }
            })
        }
    }

    function get_designation(id_designation = null, id_department = null, id_company = null, ket = null) {
        if (ket == 'edit') {
            id_company2 = $('#company_edit').val();
            id_department2 = $('#department_edit').val();
        } else {
            id_company2 = $('#add_company').val();
            id_department2 = $('#add_department').val();
        }
        if (id_designation != null) {
            designation = '';
            department = id_department;
            company = id_company;
        } else {
            designation = '<option selected disabled value = "#">-- Choose Designation --</option>';
            department = id_department2;
            company = id_company2;
        }
        if (company != null && company != '' && department != null && department != '') {
            $.ajax({
                url: "<?= base_url('employees_dev/get_designation') ?>",
                method: "POST",
                data: {
                    designation: id_designation,
                    company: company,
                    department: department
                },
                dataType: "JSON",
                success: function(res) {
                    res.designation.forEach(element => {
                        designation += `<option value = "${element['designation_id']}" ${element['selected'] == 1 ? 'selected' : ''}>${element['designation_name']}</option>`;
                    });
                    if (ket == 'edit') {
                        $('#designation_edit').html('');
                        $('#designation_edit').append(designation);
                        designation_select.update();
                    } else {
                        $('#add_designation').html('');
                        $('#add_designation').append(designation);
                        add_designation_select.update();
                    }
                }
            })
        }
    }
    $('#leave_category').on('change', function() {
        leave = $('#leave_category').val();
        leave_hidden = leave.join(',');
        $('#leave_category_hidden').val(leave_hidden);
    })
    $('#company_data').on('change', function() {
        company = $('#company_data').val();
        company_hidden = company.join(',');
        $('#company_data_hidden').val(company_hidden);
    })

    function get_leave_category(id_leave = null) {

        $.ajax({
            url: "<?= base_url('employees_dev/get_leave_category') ?>",
            method: "POST",
            data: {
                id_leave: id_leave
            },
            dataType: "JSON",
            success: function(res) {
                const leave = [];
                if (id_leave == null) {
                    res.leave.forEach(element => {
                        leave.push({
                            text: element['type_name'],
                            value: element['leave_type_id'],
                        })
                    });
                    add_leave_select = new SlimSelect({
                        select: '#add_leave_category',
                        data: leave
                    })
                } else {
                    res.leave.forEach(element => {
                        if (element['selected'] == 1) {
                            is_selected = true;
                        } else {
                            is_selected = false;
                        }
                        leave.push({
                            text: element['type_name'],
                            value: element['leave_type_id'],
                            selected: is_selected
                        })
                    });
                    leave_select = new SlimSelect({
                        select: '#leave_category',
                        data: leave
                    })
                }
            }
        })
    }

    function get_company_data(id_company = null) {
        $.ajax({
            url: "<?= base_url('employees_dev/get_company_data') ?>",
            method: "POST",
            data: {
                id_company: id_company
            },
            dataType: "JSON",
            success: function(res) {
                const company = [];
                res.company.forEach(element => {
                    if (element['selected'] == 1) {
                        is_selected = true;
                    } else {
                        is_selected = false;
                    }
                    company.push({
                        text: element['name'],
                        value: element['company_id'],
                        selected: is_selected
                    })
                });
                company_data_select = new SlimSelect({
                    select: '#company_data',
                    data: company
                })
            }
        })
    }

    function get_affiliate_pt(id_pt = null) {
        if (id_pt == null) {
            affiliate = '<option value = "#" selected disabled>-- Choose Affiliate PT --</option>'
        } else {
            affiliate = '';
        }
        $.ajax({
            url: "<?= base_url('employees_dev/get_affiliate_pt') ?>",
            method: "POST",
            data: {
                id_pt: id_pt
            },
            dataType: "JSON",
            success: function(res) {
                res.affiliate.forEach(element => {
                    affiliate += `<option value = "${element['id_pt']}" ${element['selected'] == 1 ? 'selected' : ''}>${element['nama_pt']}</option>`;
                });
                // if (id_pt == null) {
                    $('#add_affiliate_pt').html('');
                    $('#add_affiliate_pt').append(affiliate);
                    add_affiliate_select.update();
                // } else {
                    $('#affiliate_pt').html('');
                    $('#affiliate_pt').append(affiliate);
                    affiliate_select.update();
                // }
            }
        })
    }
    $('#btn_modal_add_employee').on('click', function() {
        $('#add_employee_form')[0].reset();
        $('#modal_add_employee').modal('show');
        get_posisi();
        get_company();
        get_office_shift();
        get_role();
        get_leave_category();
        get_affiliate_pt();
    })
    $('#add_company').on('change', function() {
        get_department();
        get_location();
    })
    $('#add_department').on('change', function() {
        get_designation();
    })

    async function check_valid_add_form() {
        if (($('#add_first_name').val()).trim() == '') {
            error_alert('First name is required!');
            return false;
        }
        // if (($('#add_employee_id').val()).trim() == '') {
        //     error_alert('Employee ID is required!');
        //     return false;
        // }
        // if (!await check_employee_id($('#add_employee_id').val())) {
        //     error_alert('Employee ID already exist!');
        //     return false;
        // }
        if ($('#add_company').val() == null) {
            error_alert('Company is required!');
            return false;
        }
        if ($('#add_joining').val() == '') {
            error_alert('Date of Joining required!');
            return false;
        }
        if ($('#add_department').val() == null) {
            error_alert('Department is required!');
            return false;
        }
        if ($('#add_designation').val() == null) {
            error_alert('Designation is required!');
            return false;
        }
        if ($('#add_username').val() == '') {
            error_alert('Username is required!');
            return false;
        }
        if ($('#add_office_shift').val() == null) {
            error_alert('Office shift is required!');
            return false;
        }
        if (!await check_employee_username($('#add_username').val())) {
            error_alert('Username already exist!');
            return false;
        }
        if ($('#add_date_birth').val() == '') {
            error_alert('Date of Birth is required!');
            return false;
        }
        if ($('#add_contact_number').val() == '') {
            error_alert('Contact Number is required!');
            return false;
        }
        if ($('#add_password').val() == '') {
            error_alert('Password is required!');
            return false;
        }
        if ($('#add_password').val().length < 6) {
            error_alert('Password length is at least 6!');
            return false;
        }

        if ($('#add_password').val() !== $('#add_confirm_password').val()) {
            error_alert('Password and Confirm Password is different!');
            return false;
        }
        if ($('#add_role').val() == null) {
            error_alert('Role is required!');
            return false;
        }
        if ($('#add_posisi').val() == null) {
            error_alert('Posisi is required!');
            return false;
        }
        if ($('#add_affiliate_pt').val() == null) {
            error_alert('Affiliate PT is required!');
            return false;
        }
        return true;
    }

    async function check_employee_id(employee_id, user_id = null) {
        if (employee_id && employee_id.trim() !== '') {
            try {
                const res = await $.ajax({
                    url: "<?= base_url('employees_dev/check_employee_id') ?>",
                    method: "POST",
                    data: {
                        employee_id: employee_id,
                        user_id: user_id
                    },
                    dataType: "JSON"
                });
                return res.valid == 1;
            } catch (error) {
                console.error("Error checking employee ID:", error);
                return false;
            }
        }
        return false;
    }

    async function check_employee_username(username, user_id = null) {
        if (username && username.trim() !== '') {
            try {
                const res = await $.ajax({
                    url: "<?= base_url('employees_dev/check_employee_username') ?>",
                    method: "POST",
                    data: {
                        username: username,
                        user_id: user_id
                    },
                    dataType: "JSON"
                });
                return res.valid == 1;
            } catch (error) {
                console.error("Error checking employee ID:", error);
                return false;
            }
        }
        return false;
    }

    async function save_employee() {
        if (await check_valid_add_form()) {
            success_alert('Form is valid');
            form = $('#add_employee_form');
            $.confirm({
                title: 'Save Form',
                content: 'Add Employee form will be saved',
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
                                        url: "<?= base_url('employees_dev/save_employee') ?>",
                                        method: "POST",
                                        data: form.serialize(),
                                        dataType: "JSON",
                                        beforeSend: function() {
                                            $('#btn_save_employee').attr('disabled', true);
                                        },
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
                                                $('#modal_add_employee').modal('hide');
                                                $("#dt_employees").DataTable().ajax.reload();
                                                $('#btn_save_employee').removeAttr('disabled');
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
                                                $('#btn_save_employee').removeAttr('disabled');

                                            }
                                        }
                                    })
                                }
                            })
                        }
                    }
                }
            })
        } else {
            error_alert('Form is invalid');
        }
    }

    async function check_valid_update_form() {
        user_id = $('#user_id').val();
        if (($('#first_name').val()).trim() == '') {
            error_alert('First name is required!');
            return false;
        }
        // if (($('#employee_id').val()).trim() == '') {
        //     error_alert('Employee ID is required!');
        //     return false;
        // }
        // if (!await check_employee_id($('#employee_id').val(), user_id)) {
        //     error_alert('Employee ID already exist!');
        //     return false;
        // }
        if ($('#company_edit').val() == null) {
            error_alert('Company is required!');
            return false;
        }
        if ($('#date_of_joining').val() == '') {
            error_alert('Date of Joining required!');
            return false;
        }
        if ($('#department_edit').val() == null) {
            error_alert('Department is required!');
            return false;
        }
        if ($('#designation_edit').val() == null) {
            error_alert('Designation is required!');
            return false;
        }
        if ($('#username').val() == '') {
            error_alert('Username is required!');
            return false;
        }
        if ($('#office_shift').val() == null) {
            error_alert('Office shift is required!');
            return false;
        }
        if (!await check_employee_username($('#username').val(), user_id)) {
            error_alert('Username already exist!');
            return false;
        }
        if ($('#date_of_birth').val() == '') {
            error_alert('Date of Birth is required!');
            return false;
        }
        if ($('#contact').val() == '') {
            error_alert('Contact Number is required!');
            return false;
        }
        if ($('#role_edit').val() == null) {
            error_alert('Role is required!');
            return false;
        }
        if ($('#posisi').val() == null) {
            error_alert('Posisi is required!');
            return false;
        }
        if ($('#affiliate_pt').val() == null) {
            error_alert('Affiliate PT is required!');
            return false;
        }
        return true;
    }

    $('#add_leave_category').on('change', function() {
        leave = $('#add_leave_category').val();
        leave_hidden = leave.join(',');
        $('#add_leave_category_hidden').val(leave_hidden);
    })

    async function update_employee() {
        if (await check_valid_update_form()) {
            success_alert('Form is valid');
            form = $('#update_employee_form');
            $.confirm({
                title: 'Save Form',
                content: 'Update Employee form will be saved',
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
                                        url: "<?= base_url('employees_dev/update_employee') ?>",
                                        method: "POST",
                                        data: form.serialize(),
                                        dataType: "JSON",
                                        beforeSend: function() {
                                            $('#btn_update_employee').attr('disabled', true);
                                        },
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
                                                $('#modal_details').modal('hide');
                                                $("#dt_employees").DataTable().ajax.reload();
                                                $('#btn_update_employee').removeAttr('disabled');
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
                                                $('#btn_update_employee').removeAttr('disabled');
                                            }
                                        }
                                    })
                                }
                            })
                        }
                    }
                }
            })
        } else {
            error_alert('Form is invalid');
        }
    }

    function save_family() {
        form = $('#form_add_family');
        if ($('#family_status').val() == null) {
            error_alert('Status is required!');
        } else if ($('#nama_family').val() == '') {
            error_alert('Nama is required!');
        } else if ($('#family_gender').val() == null) {
            error_alert('Jenis kelamin is required!');
        } else if ($('#family_pendidikan').val() == null) {
            error_alert('Pendidikan is required!');
        } else {
            $.confirm({
                title: 'Save Form',
                content: 'Family form will be saved',
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
                                        url: "<?= base_url('employees_dev/save_family') ?>",
                                        method: "POST",
                                        data: form.serialize(),
                                        dataType: "JSON",
                                        beforeSend: function() {
                                            $('#btn_save_family').attr('disabled', true);
                                        },
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
                                                $('#modal_form_family').modal('hide');
                                                modal_details($('#family_user_id').val());
                                                $('#btn_save_family').removeAttr('disabled');
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
                                                $('#btn_save_family').removeAttr('disabled');
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
    }

    function update_family() {
        form = $('#form_add_family');
        if ($('#family_status').val() == null) {
            error_alert('Status is required!');
        } else if ($('#nama_family').val() == '') {
            error_alert('Nama is required!');
        } else if ($('#family_gender').val() == null) {
            error_alert('Jenis kelamin is required!');
        } else if ($('#family_pendidikan').val() == null) {
            error_alert('Pendidikan is required!');
        } else {
            $.confirm({
                title: 'Save Form',
                content: 'Family form will be saved',
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
                                        url: "<?= base_url('employees_dev/update_family') ?>",
                                        method: "POST",
                                        data: form.serialize(),
                                        dataType: "JSON",
                                        beforeSend: function() {
                                            $('#btn_update_family').attr('disabled', true);
                                        },
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
                                                $('#modal_form_family').modal('hide');
                                                modal_details($('#family_user_id').val());
                                                $('#btn_update_family').removeAttr('disabled');
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
                                                $('#btn_update_family').removeAttr('disabled');
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
    }

    $('#data_family').on('click', '.edit_family', function() {
        $('#title_form_family').text('Edit Family');
        $('#btn_save_family').addClass('d-none');
        $('#btn_update_family').removeClass('d-none');
        $('#family_id').val($(this).data('id'));
        $('#family_status').val($(this).data('status'));
        $('#nama_family').val($(this).data('nama'));
        $('#family_gender').val($(this).data('gender'));
        $('#family_tempat_lahir').val($(this).data('tempat_lahir'));
        $('#family_pendidikan').val($(this).data('pendidikan'));
        $('#family_pekerjaan').val($(this).data('pekerjaan'));
        $('#family_tgl_lahir').val($(this).data('tgl_lahir'));
        $('#family_no_hp').val($(this).data('no_hp'));
        $('#modal_form_family').modal('show');
    })

    $('#data_family').on('click', '.delete_family', function() {
        fam_id = $(this).data('id');
        $.confirm({
            title: 'Delete data',
            content: 'Data family will be deleted',
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
                                    url: "<?= base_url('employees_dev/delete_family') ?>",
                                    method: "POST",
                                    data: {
                                        fam_id: fam_id
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
                                            modal_details($('#family_user_id').val());
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
                                        }
                                    }
                                })
                            }
                        })
                    }
                }
            }
        })
    })

    function save_education() {
        if (check_education_form()) {
            form = $('#form_add_education');
            $.ajax({
                url: "<?= base_url('employees_dev/save_education') ?>",
                method: "POST",
                data: form.serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#btn_save_education').attr('disabled', true);
                },
                success: function(res) {
                    if (res.result == true) {
                        success_alert('Berhasil menambahkan data');
                        $('#modal_form_education').modal('hide');
                        $('#btn_save_education').removeAttr('disabled');
                        modal_details($('#education_user_id').val());
                    } else {
                        error_alert('Gagal menambahkan data');
                        $('#btn_save_education').removeAttr('disabled');
                    }
                }
            })
        }
    }

    function update_education() {
        if (check_education_form()) {
            form = $('#form_add_education');
            $.ajax({
                url: "<?= base_url('employees_dev/update_education') ?>",
                method: "POST",
                data: form.serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#btn_update_education').attr('disabled', true);
                },
                success: function(res) {
                    if (res.result == true) {
                        success_alert('Berhasil menambahkan data');
                        $('#modal_form_education').modal('hide');
                        $('#btn_update_education').removeAttr('disabled');
                        modal_details($('#education_user_id').val());
                    } else {
                        error_alert('Gagal menambahkan data');
                        $('#btn_update_education').removeAttr('disabled');
                    }
                }
            })
        }
    }

    function check_education_form() {
        isValid = true;
        $('#form_add_education').find('input, select').each(function() {
            if (($(this).val()).trim() == '' || $(this).val() == null) {
                if ($(this).attr('id') != 'education_id') {
                    error_alert('There is an empty field');
                    isValid = false;
                    return false;
                }
            }
            if ($(this).attr('id') == 'education_masuk' && $(this).val().length != 4) {
                error_alert('Format tahun masuk salah!');
                isValid = false;
                return false;
            }
            if ($(this).attr('id') == 'education_lulus' && (($(this).val()).length != 4 || $(this).val() < $('#education_masuk').val())) {
                error_alert('Data tahun lulus tidak valid!');
                isValid = false;
                return false;
            }
        });
        return isValid;
    }

    $('#data_qualify').on('click', '.edit_qualification', function() {
        $('#title_form_education').text('Edit Pendidikan');
        $('#btn_save_education').addClass('d-none');
        $('#btn_update_education').removeClass('d-none');
        $('#modal_form_education').modal('show');
        $('#education_id').val($(this).data('id'));
        $('#nama_education').val($(this).data('name'));
        $('#level_education').val($(this).data('education_level_id'));
        $('#education_masuk').val($(this).data('from_year'));
        $('#education_lulus').val($(this).data('to_year'));
        $('#education_skill').val($(this).data('skill_id'));
        $('#education_language').val($(this).data('language_id'));
        $('#education_description').val($(this).data('description'));
        $('#modal_form_education').modal('show');
    })

    $('#data_qualify').on('click', '.delete_qualification', function() {
        edu_id = $(this).data('id');
        $.confirm({
            title: 'Delete data',
            content: 'Data qualification will be deleted',
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
                                    url: "<?= base_url('employees_dev/delete_education') ?>",
                                    method: "POST",
                                    data: {
                                        edu_id: edu_id
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
                                            modal_details($('#family_user_id').val());
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
                                        }
                                    }
                                })
                            }
                        })
                    }
                }
            }
        })
    })

    function check_work_form() {
        isValid = true;
        $('#form_add_work').find('input, select').each(function() {
            if (($(this).val()).trim() == '' || $(this).val() == null) {
                if ($(this).attr('id') != 'work_id') {
                    error_alert('There is an empty field');
                    isValid = false;
                    return false;
                }
            }
            if ($(this).attr('id') == 'masuk_work' && $(this).val().length != 4) {
                error_alert('Data tahun masuk salah!');
                isValid = false;
                return false;
            }
            if ($(this).attr('id') == 'keluar_work' && (($(this).val()).length != 4 || $(this).val() < $('#masuk_work').val())) {
                error_alert('Data tahun keluar tidak valid!');
                isValid = false;
                return false;
            }
        });
        return isValid;
    }

    function save_work() {
        if (check_work_form()) {
            form = $('#form_add_work');
            $.ajax({
                url: "<?= base_url('employees_dev/save_work') ?>",
                method: "POST",
                data: form.serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#btn_save_work').attr('disabled', true);
                },
                success: function(res) {
                    if (res.result == true) {
                        success_alert('Berhasil menambahkan data');
                        $('#modal_form_work').modal('hide');
                        $('#btn_save_work').removeAttr('disabled');
                        modal_details($('#work_user_id').val());
                    } else {
                        error_alert('Gagal menambahkan data');
                        $('#btn_save_work').removeAttr('disabled');
                    }
                }
            })
        }
    }

    $('#data_work_exp').on('click', '.edit_work_exp', function() {
        $('#title_form_work').text('Edit Work Experience');
        $('#btn_save_work').addClass('d-none');
        $('#btn_update_work').removeClass('d-none');
        $('#modal_form_work').modal('show');
        $('#work_id').val($(this).data('id'));
        $('#nama_work').val($(this).data('nama_perusahaan'));
        $('#lokasi_work').val($(this).data('lokasi'));
        $('#posisi_work').val($(this).data('posisi'));
        $('#masuk_work').val($(this).data('tahun_masuk'));
        $('#keluar_work').val($(this).data('tahun_keluar'));
        $('#salary_awal').val($(this).data('salary_awal'));
        $('#salary_akhir').val($(this).data('salary_akhir'));
        $('#a_resign_work').val($(this).data('alasan_keluar'));
    })

    function update_work() {
        if (check_work_form()) {
            form = $('#form_add_work');
            $.ajax({
                url: "<?= base_url('employees_dev/update_work') ?>",
                method: "POST",
                data: form.serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#btn_update_work').attr('disabled', true);
                },
                success: function(res) {
                    if (res.result == true) {
                        success_alert('Berhasil mengubah data');
                        $('#modal_form_work').modal('hide');
                        $('#btn_update_work').removeAttr('disabled');
                        modal_details($('#work_user_id').val());
                    } else {
                        error_alert('Gagal mengubah data');
                        $('#btn_update_work').removeAttr('disabled');
                    }
                }
            })
        }
    }

    $('#data_work_exp').on('click', '.delete_work_exp', function() {
        work_id = $(this).data('id');
        $.confirm({
            title: 'Delete data',
            content: 'Data work experience will be deleted',
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
                                    url: "<?= base_url('employees_dev/delete_work') ?>",
                                    method: "POST",
                                    data: {
                                        work_id: work_id
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
                                            modal_details($('#work_user_id').val());
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
                                        }
                                    }
                                })
                            }
                        })
                    }
                }
            }
        })
    })

    function check_contract_form() {
        isValid = true;
        $('#form_add_contract').find('input, select').each(function() {
            if (($(this).val()) == '' || $(this).val() == null) {
                if ($(this).attr('id') != 'contract_id' && !($(this).attr('id') == 'akhir_contract' && ($('#type_contract').val() == 1 || $('#type_contract').val() == 3))) {
                    error_alert('There is an empty field');
                    isValid = false;
                    return false;
                }
            }
        });
        return isValid;
    }

    function save_contract() {
        if (check_contract_form()) {
            form = $('#form_add_contract');
            $.ajax({
                url: "<?= base_url('employees_dev/save_contract') ?>",
                method: "POST",
                data: form.serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#btn_save_contract').attr('disabled', true);
                },
                success: function(res) {
                    if (res.result == true) {
                        success_alert('Berhasil menambahkan data');
                        $('#modal_form_contract').modal('hide');
                        $('#btn_save_contract').removeAttr('disabled');
                        modal_details($('#contract_user_id').val());
                    } else {
                        error_alert('Gagal menambahkan data');
                        $('#btn_save_contract').removeAttr('disabled');
                    }
                }
            })
        }
    }

    $('#data_contract').on('click', '.edit_contract', function() {
        $('#title_form_contract').text('Edit Contract');
        $('#btn_save_contract').addClass('d-none');
        $('#btn_update_contract').removeClass('d-none');
        $('#modal_form_contract').modal('show');
        $('#contract_id').val($(this).data('id'));
        $('#title_contract').val($(this).data('title'));
        $('#status_contract').val($(this).data('status'));
        $('#type_contract').val($(this).data('contract_type_id'));
        $('#awal_contract').val($(this).data('from_date'));
        $('#akhir_contract').val($(this).data('to_date'));
        $('#description_contract').val($(this).data('description'));
    })

    function update_contract() {
        if (check_contract_form()) {
            form = $('#form_add_contract');
            $.ajax({
                url: "<?= base_url('employees_dev/update_contract') ?>",
                method: "POST",
                data: form.serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#btn_update_contract').attr('disabled', true);
                },
                success: function(res) {
                    if (res.result == true) {
                        success_alert('Berhasil mengubah data');
                        $('#modal_form_contract').modal('hide');
                        $('#btn_update_contract').removeAttr('disabled');
                        modal_details($('#contract_user_id').val());
                    } else {
                        error_alert('Gagal mengubah data');
                        $('#btn_update_contract').removeAttr('disabled');
                    }
                }
            })
        }
    }

    $('#data_contract').on('click', '.delete_contract', function() {
        contract_id = $(this).data('id');
        $.confirm({
            title: 'Delete data',
            content: 'Data Contract will be deleted',
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
                                    url: "<?= base_url('employees_dev/delete_contract') ?>",
                                    method: "POST",
                                    data: {
                                        contract_id: contract_id
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
                                            modal_details($('#contract_user_id').val());
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
                                        }
                                    }
                                })
                            }
                        })
                    }
                }
            }
        })
    })

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