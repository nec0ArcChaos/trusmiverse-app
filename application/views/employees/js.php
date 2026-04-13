<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>


<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>



<script>
    dt_employees();

    function dt_employees() {
        $('#dt_employees').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            // "dom": 'Bfrtip',
            // "order": [
            //     [4, 'desc']
            // ],
            // responsive: true,
            // buttons: [{
            //     extend: 'excelHtml5',
            //     text: 'Export to Excel',
            //     footer: true
            // }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": "<?= base_url(); ?>employees/dt_employees",
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
                        // <div class="col-auto">
                        //     <a href="javascript:void(0);">
                        //         <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;https://trusmiverse.com/hr/uploads/profile/${row['profile_picture']}&quot;);">
                        //             <img src="https://trusmiverse.com/hr/uploads/profile/${row['profile_picture']}" alt="" style="display: none;">
                        //         </figure>
                        //     </a>
                        // </div>
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
                        if(row['ctm_grade'] != null){
                            grade = ' ('+row['ctm_grade']+')';
                        }else{
                            grade = '';
                        }
                        return `${row['company_name']}<br>
                        <small class="text-muted"><i>Location: ${row['location_name']}<i></i></i></small><br>
                        <small class="text-muted"><i>Head Department: ${row['head_name']}<i></i></i></small><br>
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

    function modal_form(menu, tipe) {
        reset_all_input('form_family');
        if (menu == 'family') {
            if (tipe == 1) {
                $('#title_form').text('Tambah Family');
                var id = $('#attr_' + menu).data('id');
                $('input[name="family_id"]').val(id);
                $('input[name="family_nama"]').val('');
                $('input[name="family_tempat_lahir"]').val('');
                $('input[name="family_pekerjaan"]').val('');
                $('select[name="family_status"]').val('');
                $('select[name="family_gender"]').val('');
                $('select[name="family_pendidikan"]').val('');

            } else {

                $('#title_form').text('Edit Family');
                var id = $('#attr_' + menu).data('id');
                var status = $('#attr_' + menu).data('status');
                var nama = $('#attr_' + menu).data('nama');
                var gender = $('#attr_' + menu).data('gender');
                var tempat_lahir = $('#attr_' + menu).data('tempat_lahir');
                var pendidikan = $('#attr_' + menu).data('pendidikan');
                var pekerjaan = $('#attr_' + menu).data('pekerjaan');
                $('input[name="family_id"]').val(id);
                $('input[name="family_nama"]').val(nama);
                $('input[name="family_tempat_lahir"]').val(tempat_lahir);
                $('input[name="family_pekerjaan"]').val(pekerjaan);
                $('select[name="family_status"]').val(status);
                $('select[name="family_gender"]').val(gender);
                $('select[name="family_pendidikan"]').val(pendidikan);
            }
        }
        $('#modal_form').modal('show');
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
                    modal_form('family', 1);
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
                    // modal_form('family', 1);
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
                    // modal_form('family', 1);
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
                    // modal_form('family', 1);
                }
            }]
        });
        $.ajax({
            type: "POST",
            url: "<?= base_url('employees/get_detail_employee'); ?>",
            data: {
                user_id: user_id
            },
            dataType: "json",
            success: function(response) {
                $.each(response.basic, function(index, value) {
                    $('#' + index).val(value);
                });

                t_family.clear();
                $.each(response.family, function(index, value) {
                    t_family.row.add([
                        `<span class="badge bg-light-yellow text-black" style='cursor:pointer' id="attr_family" data-id="${value.application_id}" data-status="${value.status}" data-nama="${value.nama}" data-gender="${value.jenis_kelamin}" data-tempat_lahir="${value.tempat_lahir}" data-pendidikan="${value.id_pendidikan}" data-pekerjaan="${value.pekerjaan}"><i class="bi bi-pen-fill"></i> Edit</span><span class="badge bg-light-red text-black" style='cursor:pointer'><i class="bi bi-trash-fill"></i> Del.</span>`,
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
                        `<span class="badge bg-light-yellow text-black" style='cursor:pointer' id="attr_family" data-id="${value.application_id}" data-status="${value.status}" data-nama="${value.nama}" data-gender="${value.jenis_kelamin}" data-tempat_lahir="${value.tempat_lahir}" data-pendidikan="${value.id_pendidikan}" data-pekerjaan="${value.pekerjaan}"><i class="bi bi-pen-fill"></i> Edit</span><span class="badge bg-light-red text-black" style='cursor:pointer'><i class="bi bi-trash-fill"></i> Del.</span>`,
                        value.level,
                        value.name,
                        value.from_year + ' - ' + value.to_year,
                    ]).draw(false);
                });
                table3.clear();

                $.each(response.contract, function(index, value) {
                    table3.row.add([
                        `<span class="badge bg-light-yellow text-black" style='cursor:pointer' id="attr_family" data-id="${value.application_id}" data-status="${value.status}" data-nama="${value.nama}" data-gender="${value.jenis_kelamin}" data-tempat_lahir="${value.tempat_lahir}" data-pendidikan="${value.id_pendidikan}" data-pekerjaan="${value.pekerjaan}"><i class="bi bi-pen-fill"></i> Edit</span><span class="badge bg-light-red text-black" style='cursor:pointer'><i class="bi bi-trash-fill"></i> Del.</span>`,
                        value.title,
                        value.description,
                        value.from_date + ' - ' + value.to_date,
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
        // $(form).get(0).reset();
        console.log(form);
        // form.find('input[type="text"], input[type="number"], input[type="password"], input[type="email"], input[type="tel"], input[type="url"], input[type="search"], input[type="range"]').val('');
        // form.find('select').prop('selectedIndex', 0);
        // form.find('textarea').val('');
        // form.find('input[type="checkbox"], input[type="radio"]').prop('checked', false);
        // form.find('input[type="file"]').val('');
        // form.find('input[type="color"]').val('#000000');
        // form.find('input[type="date"], input[type="month"], input[type="week"], input[type="time"], input[type="datetime-local"]').val('');
    }
</script>