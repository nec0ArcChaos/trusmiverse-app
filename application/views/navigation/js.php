<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="<?= base_url() ?>assets/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="<?= base_url() ?>assets/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/fancybox/jquery.fancybox.min.js"></script> -->


<script>
    $(document).ready(function() {

    });

    $("#add_navigation").on("click", function() {
        $("#modal_add_navigation").modal("show");
    });


    function edit_navigation(menu_id, parent_id, level, menu_nm, menu_url, menu_icon, role_id, company_id, department_id, designation_id, user_id, user_id_blocked) {
        $('#modal_edit_navigation').modal('show');
        $('#e_menu_id').val(menu_id);
        $('#e_menu_nm').val(menu_nm);
        console.log(menu_url);
        $('#e_menu_url').val(menu_url != 'null' ? menu_url : '');
        $('#e_menu_icon').val(menu_icon);
        $('#e_level').val(level);
        if (role_id.indexOf(',') > -1) {
            role_id = role_id.split(',');
        }
        if (company_id.indexOf(',') > -1) {
            company_id = company_id.split(',');
        }
        if (department_id.indexOf(',') > -1) {
            department_id = department_id.split(',');
        }
        if (designation_id.indexOf(',') > -1) {
            designation_id = designation_id.split(',');
        }
        if (user_id.indexOf(',') > -1) {
            user_id = user_id.split(',');
        }
        if (user_id_blocked.indexOf(',') > -1) {
            user_id_blocked = user_id_blocked.split(',');
        }
        e_get_parent(menu_id, parent_id);
        e_get_role(role_id);
        e_get_company(company_id);
        e_get_department(department_id);
        e_get_designation(designation_id);
        e_get_user(user_id);
        e_get_user_blocked(user_id_blocked);
    }

    function get_parent() {
        $.ajax({
            url: '<?= base_url() ?>navigation/get_parent',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {
                item_role = '<option data-placeholder="true"></option>';
                for (let index = 0; index < response.data.length; index++) {
                    item_role += `<option value="${response.data[index].menu_id}" data-level="${response.data[index].level}">${response.data[index].menu_nm}</option>`;
                }
                $("#parent_id").empty().append(item_role);
                var parent_id = new SlimSelect({
                    select: '#parent_id',
                    settings: {
                        allowDeselect: true,
                    },
                });
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    function e_get_parent(menu_id, parent_id) {
        $.ajax({
            url: '<?= base_url() ?>navigation/get_parent',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {
                item_role = '<option data-placeholder="true"></option>';
                for (let index = 0; index < response.data.length; index++) {
                    if (menu_id == response.data[index].menu_id) {
                        console.log(menu_id + ' sama ' + response.data[index].menu_id);
                    }
                    console.log(menu_id);
                    console.log(response.data[index].menu_id);
                    item_role += `<option value="${response.data[index].menu_id}" data-level="${response.data[index].level}">${response.data[index].menu_nm}</option>`;
                }
                $("#e_parent_id").empty().append(item_role);
                var e_parent_id = new SlimSelect({
                    select: '#e_parent_id',
                    settings: {
                        allowDeselect: true,
                    },
                });
                if (parent_id != 'null' && parent_id != null) {
                    e_parent_id.setSelected(parent_id)
                } else {
                    e_parent_id.setSelected('');
                }
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    $("#parent_id").on("change", function() {
        level = $(this).find(':selected').data('level');
        if (level == undefined) {
            $("#level").val(1);
        } else {
            $("#level").val(level + 1);
        }
    });

    $("#e_parent_id").on("change", function() {
        e_level = $(this).find(':selected').data('level');
        if (e_level == undefined) {
            $("#e_level").val(1);
            // $('#e_menu_url').attr("disabled", false);
        } else {
            $("#e_level").val(e_level + 1);
            // $('#e_menu_url').val('');
            // $('#e_menu_url').attr("disabled", true);
        }
    });

    function get_role() {
        $.ajax({
            url: '<?= base_url() ?>navigation/get_role',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {
                item_role = '';
                for (let index = 0; index < response.data.length; index++) {
                    item_role += `<option value="${response.data[index].role_id}">${response.data[index].role_nm}</option>`;
                }
                $("#role_id").empty().append(item_role);
                var role_id = new SlimSelect({
                    select: '#role_id'
                });
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }


    function e_get_role(role_id) {
        $.ajax({
            url: '<?= base_url() ?>navigation/get_role',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {
                item_role = '';
                for (let index = 0; index < response.data.length; index++) {
                    item_role += `<option value="${response.data[index].role_id}">${response.data[index].role_nm}</option>`;
                }
                $("#e_role_id").empty().append(item_role);
                var e_role_id = new SlimSelect({
                    select: '#e_role_id'
                });
                if (role_id != 'null' && role_id != null) {
                    e_role_id.setSelected(role_id);
                } else {
                    e_role_id.setSelected('');
                }
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    function get_company() {
        $.ajax({
            url: '<?= base_url() ?>navigation/get_company',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {
                item_company = '';
                for (let index = 0; index < response.data.length; index++) {
                    item_company += `<option value="${response.data[index].company_id}">${response.data[index].company_nm}</option>`;
                }
                $("#company_id").empty().append(item_company);
                var company_id = new SlimSelect({
                    select: '#company_id'
                });
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    function e_get_company(company_id) {
        console.log(company_id);
        $.ajax({
            url: '<?= base_url() ?>navigation/get_company',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {
                item_company = '';
                for (let index = 0; index < response.data.length; index++) {
                    item_company += `<option value="${response.data[index].company_id}">${response.data[index].company_nm}</option>`;
                }
                $("#e_company_id").empty().append(item_company);
                var e_company_id = new SlimSelect({
                    select: '#e_company_id'
                });
                if (company_id != 'null' && company_id != null) {
                    e_company_id.setSelected(company_id);
                } else {
                    e_company_id.setSelected('');
                }
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }


    function get_department() {
        $.ajax({
            url: '<?= base_url() ?>navigation/get_department',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {
                item_company = '';
                for (let index = 0; index < response.data.length; index++) {
                    item_company += `<option value="${response.data[index].department_id}">${response.data[index].department_nm}</option>`;
                }
                $("#department_id").empty().append(item_company);
                var department_id = new SlimSelect({
                    select: '#department_id'
                });
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    function e_get_department(department_id) {
        $.ajax({
            url: '<?= base_url() ?>navigation/get_department',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {
                item_company = '';
                for (let index = 0; index < response.data.length; index++) {
                    item_company += `<option value="${response.data[index].department_id}">${response.data[index].department_nm}</option>`;
                }
                $("#e_department_id").empty().append(item_company);
                var e_department_id = new SlimSelect({
                    select: '#e_department_id'
                });
                if (department_id != 'null' && department_id != null) {
                    e_department_id.setSelected(department_id);
                } else {
                    e_department_id.setSelected('');
                }
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    function get_designation() {
        $.ajax({
            url: '<?= base_url() ?>navigation/get_designation',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {
                item_company = '';
                for (let index = 0; index < response.data.length; index++) {
                    item_company += `<option value="${response.data[index].designation_id}">${response.data[index].designation_nm}</option>`;
                }
                $("#designation_id").empty().append(item_company);
                var designation_id = new SlimSelect({
                    select: '#designation_id'
                });
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    function e_get_designation(designation_id) {
        $.ajax({
            url: '<?= base_url() ?>navigation/get_designation',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {
                item_company = '';
                for (let index = 0; index < response.data.length; index++) {
                    item_company += `<option value="${response.data[index].designation_id}">${response.data[index].designation_nm}</option>`;
                }
                $("#e_designation_id").empty().append(item_company);
                var e_designation_id = new SlimSelect({
                    select: '#e_designation_id'
                });
                if (designation_id != 'null' && designation_id != null) {
                    e_designation_id.setSelected(designation_id);
                } else {
                    e_designation_id.setSelected('');
                }
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    function get_user() {
        $.ajax({
            url: '<?= base_url() ?>navigation/get_user',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {
                item_company = '';
                for (let index = 0; index < response.data.length; index++) {
                    item_company += `<option value="${response.data[index].user_id}">${response.data[index].user_nm}</option>`;
                }
                $("#user_id").empty().append(item_company);
                var user_id = new SlimSelect({
                    select: '#user_id'
                });
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    function e_get_user(user_id) {
        $.ajax({
            url: '<?= base_url() ?>navigation/get_user',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {
                item_company = '';
                for (let index = 0; index < response.data.length; index++) {
                    item_company += `<option value="${response.data[index].user_id}">${response.data[index].user_nm}</option>`;
                }
                $("#e_user_id").empty().append(item_company);
                var e_user_id = new SlimSelect({
                    select: '#e_user_id'
                });
                if (user_id != 'null' && user_id != null) {
                    e_user_id.setSelected(user_id);
                } else {
                    e_user_id.setSelected('');
                }
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    function get_user_blocked() {
        $.ajax({
            url: '<?= base_url() ?>navigation/get_user',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {
                item_company = '';
                for (let index = 0; index < response.data.length; index++) {
                    item_company += `<option value="${response.data[index].user_id}">${response.data[index].user_nm}</option>`;
                }
                $("#user_id_blocked").empty().append(item_company);
                var user_id_blocked = new SlimSelect({
                    select: '#user_id_blocked'
                });
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    function e_get_user_blocked(user_id_blocked) {
        $.ajax({
            url: '<?= base_url() ?>navigation/get_user',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {
                item_company = '';
                for (let index = 0; index < response.data.length; index++) {
                    item_company += `<option value="${response.data[index].user_id}">${response.data[index].user_nm}</option>`;
                }
                $("#e_user_id_blocked").empty().append(item_company);
                var e_user_id_blocked = new SlimSelect({
                    select: '#e_user_id_blocked'
                });
                if (user_id_blocked != 'null' && user_id_blocked != null) {
                    e_user_id_blocked.setSelected(user_id_blocked);
                } else {
                    e_user_id_blocked.setSelected('');
                }
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    get_parent();
    get_role();
    get_company();
    get_department();
    get_designation();
    get_user();
    get_user_blocked();
    dt_navigation();

    function dt_navigation() {
        url = "<?= base_url(); ?>navigation/dt_navigation";
        $('#dt_navigation').DataTable({
            "searching": true,
            "info": true,
            "paging": false,
            "destroy": true,
            "dom": 'Bfrtip',
            "responsive": false,
            "buttons": [{
                'extend': 'excelHtml5',
                'text': 'Export to Excel',
                'footer': true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": url,
            },
            "columns": [{
                    "data": "no_urut",
                    "render": function(data, type, row) {
                        return `<a role="button" class="badge bg-warning" style="cursor:pointer;" onclick="edit_navigation('${row['menu_id']}', '${row['parent_id']}', '${row['level']}', '${row['menu_nm']}', '${row['menu_url']}', '${row['menu_icon']}', '${row['role_id']}', '${row['company_id']}', '${row['department_id']}', '${row['designation_id']}', '${row['user_id']}','${row['user_id_blocked']}')"><i class="bi bi-pencil"></i> Edit</a>`;
                    },
                    "className": "text-center"
                },
                {
                    "data": "level",
                    "render": function(data, type, row) {
                        badge_color = '';
                        if (data == 1) {
                            badge_color = "bg-success";
                        }
                        if (data == 2) {
                            badge_color = "bg-primary";
                        }
                        if (data == 3) {
                            badge_color = "bg-danger";
                        }
                        return `<i class="badge ${badge_color}">Level ${row['level']}</i>`;
                    },
                },
                {
                    "data": "no_urut",
                    "render": function(data, type, row) {
                        return `<i>${data}</i>`;
                    },
                    "className": "text-center"
                },
                {
                    "data": "parent_nm",
                    "render": function(data, type, row) {
                        return `<b>${data}</b>`;
                    },
                    "className": "text-left"
                },
                {
                    "data": "menu_nm",
                    "render": function(data, type, row) {
                        return `${data}`;
                    },
                    "className": "text-left"
                },
                {
                    "data": "menu_url",
                    "render": function(data, type, row) {
                        if (data == null || data == "null") {
                            return 'Parent';
                        } else {
                            return `${data}`;
                        }
                    },
                    "className": "text-left"
                },
                {
                    "data": "menu_icon",
                    "render": function(data, type, row) {
                        return `<a role"button" class="badge badge-sm bg-primary" style="cursor:pointer;color:white;" onclick="edit_menu_icon('${row['menu_id']}')"><i class="${data}"></i> </a> ${data}`;
                    },
                    "className": "text-left"
                },
                {
                    "data": "role_id",
                    "render": function(data, type, row) {
                        label_role = ''
                        if (data != "" && data != null && data != 'null') {
                            array_role = row['role_name'].split(",");
                            array_role.sort();
                            for (let index = 0; index < array_role.length; index++) {
                                label_role += `- ${array_role[index]}`;
                            }
                        }
                        return `${label_role}`;
                    },
                    "className": "text-left font-size-10"
                },
                {
                    "data": "company_id",
                    "render": function(data, type, row) {
                        label_company = ''
                        if (data != "" && data != null && data != 'null') {
                            array_company = row['company_name'].split(",");
                            array_company.sort();
                            for (let index = 0; index < array_company.length; index++) {
                                label_company += `- ${array_company[index]}<br>`;
                            }
                        }
                        return `${label_company}`;
                    },
                    "className": "text-left font-size-10"
                },
                {
                    "data": "department_id",
                    "render": function(data, type, row) {
                        label_department = ''
                        if (data != "" && data != null && data != 'null') {
                            array_department = row['department_name'].split(",");
                            array_department.sort();
                            for (let index = 0; index < array_department.length; index++) {
                                label_department += `- ${array_department[index]}<br>`;
                            }
                        }
                        return `${label_department}`;
                    },
                    "className": "text-left font-size-10"
                },
                {
                    "data": "designation_id",
                    "render": function(data, type, row) {
                        label_designation = ''
                        if (data != "" && data != null && data != 'null') {
                            array_designation = row['designation_name'].split(",");
                            array_designation.sort();
                            for (let index = 0; index < array_designation.length; index++) {
                                label_designation += `- ${array_designation[index]}<br>`;
                            }
                        }
                        return `${label_designation}`;
                    },
                    "className": "text-left font-size-10"
                },
                {
                    "data": "user_id",
                    "render": function(data, type, row) {
                        label_user = ''
                        if (data != "" && data != null && data != 'null') {
                            array_user = row['user_name'].split(",");
                            array_user.sort();
                            for (let index = 0; index < array_user.length; index++) {
                                label_user += `- ${array_user[index]}<br>`;
                            }
                        }
                        return `${label_user}`;
                    },
                    "className": "text-left font-size-10"
                },
                {
                    "data": "user_id_blocked",
                    "render": function(data, type, row) {
                        label_user_blocked = ''
                        if (data != "" && data != null && data != 'null') {
                            array_user_blocked = row['user_blocked'].split(",");
                            array_user_blocked.sort();
                            for (let index = 0; index < array_user_blocked.length; index++) {
                                label_user_blocked += `- ${array_user_blocked[index]}<br>`;
                            }
                        }
                        return `${label_user_blocked}`;
                    },
                    "className": "text-left font-size-10"
                },
            ]
        });
    }

    $("#store_navigation").on("click", function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form = $('#form_navigation');
                console.log(form.serialize());
                $.ajax({
                    url: '<?= base_url() ?>navigation/store_navigation',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        // menu_id: $('#menu_id').val().toString() ?? null,
                        menu_nm: $('#menu_nm').val().toString() ?? null,
                        menu_url: $('#menu_url').val().toString() ?? null,
                        menu_icon: $('#menu_icon').val().toString() ?? null,
                        parent_id: $('#parent_id').val().toString() ?? null,
                        level: $('#level').val().toString() ?? null,
                        role_id: $('#role_id').val().toString() ?? null,
                        company_id: $('#company_id').val().toString() ?? null,
                        department_id: $('#department_id').val().toString() ?? null,
                        designation_id: $('#designation_id').val().toString() ?? null,
                        user_id: $('#user_id').val().toString() ?? null,
                        user_id_blocked: $('#user_id_blocked').val().toString() ?? null,
                    },
                    beforeSend: function() {

                    },
                    success: function(response) {
                        if (response == true || response == "true") {
                            success_alert("Berhasil Simpan Navigation");
                            get_parent();
                            get_role();
                            get_company();
                            get_department();
                            get_designation();
                            get_user();
                            get_user_blocked();
                            dt_navigation();
                            $('#form_navigation').trigger("reset");
                            $('#modal_add_navigation').modal("hide");
                        } else {
                            error_alert("Oops, Something Wrong");
                        }
                    },
                    error: function(xhr) { // if error occured

                    },
                    complete: function() {

                    },
                });
            }
        })

    });

    $("#e_store_navigation").on("click", function() {
        console.log($('#e_company_id').val());
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form = $('#e_form_navigation');
                $.ajax({
                    url: '<?= base_url() ?>navigation/e_store_navigation',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        menu_id: $('#e_menu_id').val().toString(),
                        menu_nm: $('#e_menu_nm').val().toString(),
                        menu_url: $('#e_menu_url').val().toString(),
                        menu_icon: $('#e_menu_icon').val().toString(),
                        parent_id: $('#e_parent_id').val().toString(),
                        level: $('#e_level').val().toString(),
                        role_id: $('#e_role_id').val().toString(),
                        company_id: $('#e_company_id').val().toString(),
                        department_id: $('#e_department_id').val().toString(),
                        designation_id: $('#e_designation_id').val().toString(),
                        user_id: $('#e_user_id').val().toString(),
                        user_id_blocked: $('#e_user_id_blocked').val().toString(),
                    },
                    beforeSend: function() {

                    },
                    success: function(response) {
                        console.log(response);
                        if (response == true || response == "true") {
                            success_alert("Berhasil Update Navigation");
                            get_parent();
                            get_role();
                            get_company();
                            get_department();
                            get_designation();
                            get_user();
                            get_user_blocked();
                            dt_navigation();
                            $('#e_form_navigation').trigger("reset");
                            $('#modal_edit_navigation').modal("hide");
                        } else {
                            error_alert("Oops, Something Wrong");
                        }
                    },
                    error: function(xhr) { // if error occured

                    },
                    complete: function() {

                    },
                });
            }
        })

    });

    function edit_menu_icon(menu_id) {
        $("#e_menu_id_icon").val(menu_id);
        $("#modal_edit_menu_icon").modal("show");
    }

    $("#update_menu_icon").on("click", function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!'
        }).then((result) => {
            menu_id = $("#e_menu_id_icon").val();
            menu_icon = $("#e_menu_icon").val();
            console.log(menu_id);
            console.log(menu_icon);
            $.ajax({
                url: '<?= base_url() ?>navigation/update_menu_icon',
                type: 'POST',
                dataType: 'json',
                data: {
                    menu_id: menu_id,
                    menu_icon: menu_icon,
                },
                beforeSend: function() {

                },
                success: function(response) {
                    if (response == true || response == "true") {
                        success_alert("Berhasil Update Icon");
                        get_parent();
                        get_role();
                        get_company();
                        get_department();
                        get_designation();
                        get_user();
                        get_user_blocked();
                        dt_navigation();
                        $('#modal_edit_menu_icon').modal("hide");
                    } else {
                        error_alert("Oops, Something Wrong");
                    }
                },
                error: function(xhr) { // if error occured
                    console.log(xhr);
                },
                complete: function() {

                },
            });
        });
    });

    function success_alert(text) {
        textMsg = text == null ? '' : text;
        new PNotify({
            title: `Success`,
            text: `${textMsg}`,
            icon: 'icofont icofont-checked',
            type: 'success',
            delay: 3000,
        });
    }

    function error_alert(text) {
        new PNotify({
            title: `Oopss`,
            text: `${text}`,
            icon: 'icofont icofont-info-circle',
            type: 'error',
            delay: 3000,
        });
    }
</script>