<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>


<script>
    $(".tgl").mask('0000-00-00')

    $('.tanggal').datetimepicker({
        format: 'Y-m-d',
        timepicker: false,
        scrollMonth: false,
        scrollInput: false
    });

    let options = {
        searchable: true
    }
    let n_company = NiceSelect.bind(document.getElementById('company_id'), options);
    let n_department = NiceSelect.bind(document.getElementById('department_id'), options);
    let n_employee = NiceSelect.bind(document.getElementById('employee_id'), options);
    let n_status_leave = NiceSelect.bind(document.getElementById('status_leave'), options);
    let n_month = NiceSelect.bind(document.getElementById('month-leave'), options);
    let n_year = NiceSelect.bind(document.getElementById('year-leave'), options);
    let kota = NiceSelect.bind(document.getElementById('kota'), options);
    let leave_type = NiceSelect.bind(document.getElementById('leave_type'), options);

    // add leave

    get_leave_type()

    function get_leave_type() {
        $.ajax({
            url: '<?= base_url() ?>leave/get_leave_type',
            dataType: 'json',
            method: 'POST',
        }).done(function(response) {
            opt_leave_type = '';
            // 5 Karyawan sakit 
            // 6 Pergantian shift
            // 7 Pergantian hari libur
            // 10 Izin pulang cepat
            // 11 Izin datang terlambat
            // 13 Dinas luar kota
            // 23 Dinas luar kota driver



            // 8 Istri bersalin (2 hari dalam 1 periode) 
            // 9 Kematian keluarga kandung (2 hari dalam 1 periode)

            date_now = '<?= strtotime(date("Y-m-d")) ?>'
            bali_cut_off = '<?= strtotime(date("Y-04-15")) ?>'
            crb_cut_off = '<?= strtotime(date("Y-04-20")) ?>'
            console.log((date_now));
            console.log((bali_cut_off));
            console.log((crb_cut_off));
            // tgl 15 dan 20 Maret  company  bali, 20
            array_change_remaining = ['8', '9'];
            array_hide_remaining = ['5', '6', '7', '10', '11', '13', '23'];
            for (let index = 0; index < response.leave_type.length; index++) {
                if (array_hide_remaining.includes(response.leave_type[index].leave_type_id)) {
                    remaining = '';
                } else {
                    if (array_change_remaining.includes(response.leave_type[index].leave_type_id)) {
                        remaining = `(2 hari dalam 1 periode)`;
                    } else {
                        remaining = `(${response.leave_type[index].sisa_izin} Remaining)`;
                    }
                }
                if (date_now > bali_cut_off && response.leave_type[index].leave_type_id == 19) {
                    console.log(response.leave_type[index].leave_type_id)
                } else {
                    opt_leave_type += `<option value="${response.leave_type[index].leave_type_id}" data-warning="${response.leave_type[index].warning}">${response.leave_type[index].type_name} ${remaining}</option>`
                }
            }
            $('#leave_type').empty().append(opt_leave_type);
            leave_type.update();
            opt_kota = '<option value="">Pilih Kota</option>';
            for (let index = 0; index < response.kota.length; index++) {
                opt_kota += `<option value="${response.kota[index].id}">${response.kota[index].city}, ${response.kota[index].state}</option>`
            }
            $('#kota').empty().append(opt_kota);
            kota.update();
        }).fail(function() {});
    }

    $('#div_tgl_ph').hide();
    $('#div_kota').hide();
    // Running Datepicker
    $('#leave_type').on('change', function() {
        let warning = $(this).find(':selected').data('warning');
        if (warning != "") {
            $.confirm({
                icon: 'fa fa-check',
                title: 'Alert!',
                theme: 'material',
                columnClass: 'col-12 col-md-8 col-lg-8',
                type: 'red',
                content: `<div class="col-md-12">
                                        <div class="alert alert-danger" role="alert">
                                            <h4 class="alert-heading">WARNING !!! Di baca terlebih dahulu sebelum mengisi.</h4>
                                            <p id="content_warning">${warning}</p>
                                            <hr>
                                            <p class="mb-0">Dokumen pendukung wajib dilampirkan dan diberikan kepada personalia maksimal tanggal 21.</p>
                                        </div>
                                    </div>`,
                buttons: {
                    text: 'Ok, I understand!',
                    close: function() {}
                }
            });
        }
        leave_type = $(this).val();
        if (leave_type == 7 || leave_type == 24) {
            $('#div_tgl_ph').fadeIn();
            $('#div_tgl_ph_end_date').hide();
            $('#label_start_date').html('Tgl Pengganti Libur');
            $('#start_date').on('change', function() {
                let start = $('#start_date').val()
                $('#end_date').val(start);
            });
        } else {
            $('#div_tgl_ph').hide();
            $('#div_tgl_ph_end_date').fadeIn();
            $('#label_start_date').html('Start Date');
        }

        if (leave_type == 13 || leave_type == 23) {
            $('.tanggal').datetimepicker({
                format: 'Y-m-d H:i',
                timepicker: true,
                scrollMonth: false,
                scrollInput: false
            });
            $('#div_kota').fadeIn();
        } else {
            $('.tanggal').datetimepicker({
                format: 'Y-m-d',
                timepicker: false,
                scrollMonth: false,
                scrollInput: false
            });
            $('#div_kota').hide();
        }
    });



    function add_leave() {
        $.confirm({
            title: 'Submit Request Leave',
            type: 'blue',
            theme: 'material',
            content: 'Apakah anda yakin ajukan request ini ?',
            buttons: {
                cancel: function() {
                    //close
                },
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function() {

                        let leave_type = $('#leave_type').val();
                        if (!leave_type) {
                            $.confirm({
                                icon: 'fa fa-close',
                                title: 'Oops!',
                                theme: 'material',
                                type: 'red',
                                content: 'Anda belum memilih leave type',
                                buttons: {
                                    close: {
                                        actions: function() {}
                                    },
                                },
                            });
                            return false;
                        }

                        let start_date = $('#start_date').val();
                        if (!start_date) {
                            $.confirm({
                                icon: 'fa fa-close',
                                title: 'Oops!',
                                theme: 'material',
                                type: 'red',
                                content: 'Anda belum memilih start date',
                                buttons: {
                                    close: {
                                        actions: function() {}
                                    },
                                },
                            });
                            return false;
                        }

                        let end_date = $('#end_date').val();
                        if (!end_date) {
                            $.confirm({
                                icon: 'fa fa-close',
                                title: 'Oops!',
                                theme: 'material',
                                type: 'red',
                                content: 'Anda belum memilih start date',
                                buttons: {
                                    close: {
                                        actions: function() {}
                                    },
                                },
                            });
                            return false;
                        }

                        let leave_reason = $('#leave_reason').val();
                        if (!leave_reason) {
                            $.confirm({
                                icon: 'fa fa-close',
                                title: 'Oops!',
                                theme: 'material',
                                type: 'red',
                                content: 'Anda belum memilih leave reason',
                                buttons: {
                                    close: {
                                        actions: function() {}
                                    },
                                },
                            });
                            return false;
                        }

                        let kota_val = $("#kota").val();
                        let tgl_ph = $("#tgl_ph").val();
                        let attachment = $("#attachment").prop("files")[0];

                        $.confirm({
                            icon: 'fa fa-spinner fa-spin',
                            title: 'Mohon Tunggu!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Sedang memproses...',
                            buttons: {
                                close: {
                                    isHidden: true,
                                    actions: function() {}
                                },
                            },
                            onOpen: function() {
                                let form_data = new FormData();
                                form_data.append("attachment", attachment);
                                form_data.append("tgl_ph", tgl_ph); // Adding extra parameters to form_data
                                form_data.append("start_date", start_date); // Adding extra parameters to form_data
                                form_data.append("end_date", end_date); // Adding extra parameters to form_data
                                form_data.append("leave_type", leave_type); // Adding extra parameters to form_data
                                form_data.append("reason", leave_reason); // Adding extra parameters to form_data
                                form_data.append("kota", kota_val); // Adding extra parameters to form_data
                                $.ajax({
                                    url: "<?= base_url() ?>leave/add_leave", // Upload Script
                                    dataType: 'json',
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    data: form_data, // Setting the data attribute of ajax with file_data
                                    type: 'post',
                                    beforeSend: function() {},
                                    success: function(data) {},
                                }).done(function(response) {
                                    // console.log(response);
                                    if (response.status == true) {
                                        setTimeout(() => {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-check',
                                                title: 'Done!',
                                                theme: 'material',
                                                type: 'blue',
                                                content: 'Berhasil mengajukan request leave!',
                                                buttons: {
                                                    close: function() {
                                                        location.reload()
                                                    },
                                                },
                                            });
                                        }, 250);
                                    } else {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-close',
                                            title: 'Oops!',
                                            theme: 'material',
                                            type: 'red',
                                            content: 'Gagal mengajukan request leave! <br>' + response.error,
                                            buttons: {
                                                close: {
                                                    actions: function() {}
                                                },
                                            },
                                        });
                                    }
                                }).fail(function(jqXHR, textStatus) {
                                    console.log(jqXHR)
                                    console.log(textStatus)
                                    setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-close',
                                            title: 'Oops!',
                                            theme: 'material',
                                            type: 'red',
                                            content: 'Gagal mengajukan request leave!' + textStatus,
                                            buttons: {
                                                close: {
                                                    actions: function() {}
                                                },
                                            },
                                        });
                                    }, 250);
                                });
                            },

                        });
                    }
                },
            },
        })
    }
    // end add leave


    $('#company_id').on('change', function() {
        $.ajax({
            url: '<?= base_url() ?>leave/get_department',
            type: 'POST',
            data: {
                company_id: $('#company_id').val()
            },
            dataType: 'json',
            beforeSend: function() {},
        }).done(function(response) {
            // console.log(response);
            list_department = ``
            list_department += `<option value="">Pilih Department</option>`
            list_department += `<option value="all">All Department</option>`
            for (let index = 0; index < response.length; index++) {
                list_department += `<option value="${response[index].department_id}">${response[index].department_name}</option>`
            }
            $('#department_id').empty().append(list_department);
            n_department.update();
        }).fail(function(jqXhr, textStatus) {

        });
    });

    $('#department_id').on('change', function() {
        department_id = $('#department_id').val();
        $.ajax({
            url: '<?= base_url() ?>leave/get_employee',
            type: 'POST',
            data: {
                department_id: department_id
            },
            dataType: 'json',
            beforeSend: function() {},
        }).done(function(response) {
            console.log(response);
            list_employee = ``
            list_employee += `<option value="">Pilih Employee</option>`
            list_employee += `<option value="all">All Employee</option>`
            for (let index = 0; index < response.length; index++) {
                list_employee += `<option value="${response[index].employee_id}">${response[index].employee_name}</option>`
            }
            $('#employee_id').empty().append(list_employee);
            n_employee.update();
        }).fail(function(jqXhr, textStatus) {

        });
    });

    get_available_leave()

    function get_available_leave() {
        $.ajax({
            url: '<?= base_url() ?>leave/available_leave',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {},
        }).done(function(response) {
            // console.log(response);
            list_available_leave = `<div class="collapse" id="collapse_available_leave">`
            list_available_leave += `<li class="list-group-item border-start-0 border-end-0">
                                        <div class="row">
                                            <div class="col align-self-center">
                                                <p  class="text-dinamis text-color-theme mb-0">Leave Type</p>
                                            </div>
                                            <div class="col-2 align-self-center text-end">
                                                <p  class="text-dinamis mb-0">Available</p>
                                            </div>
                                            <div class="col-2 align-self-center text-end">
                                                <p  class="text-dinamis mb-0">Taken</p>
                                            </div>
                                        </div>
                                    </li>`
            for (let index = 0; index < response.length; index++) {
                list_available_leave += `<li class="list-group-item border-start-0 border-end-0">
                                            <div class="row">
                                                <div class="col align-self-center">
                                                    <p  class="text-dinamis text-color-theme mb-0">${response[index].type_name}</p>
                                                </div>
                                                <div class="col-2 align-self-center text-end">
                                                    <p  class="text-dinamis mb-0">${response[index].sisa_izin}</p>
                                                </div>
                                                <div class="col-2 align-self-center text-end">
                                                    <p  class="text-dinamis mb-0">${response[index].jml_hari}</p>
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar ${response[index].style}" role="progressbar" aria-valuenow="${response[index].jml_hari}" style="width: ${response[index].persen}%;" aria-valuemin="0" aria-valuemax="${response[index].days_per_year}">${response[index].jml_hari}</div>
                                            </div>
                                        </li>`
            }

            list_available_leave += ` </div>`

            $('#available_leave').empty().append(list_available_leave);
        }).fail(function(jqXhr, textStatus) {

        });
    }

    get_applied_leave();

    function get_applied_leave() {
        let comp = $('#company_id').val();
        let dept = $('#department_id').val();
        let emp = $('#employee_id').val();
        let stat_leav = $('#status_leave').val();
        periode = $("#year-leave").val() + '-' + $("#month-leave").val();
        let txz = "<?= $txz ?>";
        let spv = "<?= $spv ?>";

        var table = $('#dt_applied_leave').DataTable({
            orderCellsTop: false,
            // fixedHeader: true,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "ordering": false,
            "autoWidth": false,
            "order": [
                [0, 'desc']
            ],
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="bi bi-file-earmark-arrow-down"></i> Excel',
                footer: true
            }],
            responsive: true,
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    periode: periode,
                    company_id: comp,
                    department_id: dept,
                    employee_id: emp,
                    status_leave: stat_leav,
                },
                "url": "<?= base_url(); ?>leave/applied_leave",
            },
            "columns": [{
                    className: 'dt-control align-self-center align-middle',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                {
                    "data": "applied_on_2",
                    "className": "align-middle text-dinamis d-none d-md-table-cell"
                },
                {
                    "data": "type_name",
                    "className": "align-middle",
                    "render": function(data, type, row, meta) {
                        return ` <div class="col">
                                    <p class="text-dinamis text-color-theme mb-0 d-block d-md-none" style="font-size:9pt;">${row['applied_on']}</p>
                                    <p class="text-dinamis text-color-theme mb-0 text-dinamis" >${row['type_name']}</p>
                                </div>`
                    },
                },
                {
                    "data": "company_name",
                    "className": "align-middle d-none text-dinamis"
                },
                {
                    "data": "department_name",
                    "className": "align-middle d-none d-md-table-cell text-dinamis"
                },
                {
                    "data": "employee_name",
                    "className": "align-middle d-none d-md-table-cell text-dinamis"
                },
                {
                    "data": "status",
                    "render": function(data, type, row, meta) {
                        if (txz == 1) {
                            ite_opt = `
                            <li><a class="dropdown-item text-primary" href="<?= base_url() ?>leave/detail/${row['leave_id']}"><i class="text-dinamis text-primary bi bi-arrow-right-square" ></i> Details</a></li>
                            <li><a class="dropdown-item text-warning" href="javascript:void(0)" onclick="edit_leave('${row['leave_id']}','${row['employee_id']}','${row['reason']}')"><i class="text-dinamis text-warning bi bi-pencil-square" ></i> Edit</a></li>
                            <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="delete_leave('${row['leave_id']}')"><i class="text-dinamis text-danger bi bi-trash" ></i> Delete</a></li>`
                        } else if (txz == 0 && spv == 1) {
                            if (row['id_status'] == 2) {
                                li_edit = ''
                            } else {
                                li_edit = `<li><a class="dropdown-item text-warning" href="javascript:void(0)" onclick="edit_leave('${row['leave_id']}','${row['employee_id']}','${row['reason']}')"><i class="text-dinamis text-warning bi bi-pencil-square" ></i> Edit</a></li>`
                            }
                            ite_opt = `
                            <li><a class="dropdown-item text-primary" href="<?= base_url() ?>leave/detail/${row['leave_id']}"><i class="text-dinamis text-primary bi bi-arrow-right-square" ></i> Details</a></li>
                            ${li_edit}
                            `
                        } else {
                            ite_opt = `<li><a class="dropdown-item text-warning" href="javascript:void(0)" onclick="edit_leave('${row['leave_id']}','${row['employee_id']}','${row['reason']}')"><i class="text-dinamis text-warning bi bi-pencil-square" ></i> Edit</a></li>`
                        }

                        appr = `
                                <a class="text-secondary dd-arrow-none" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                                    <span class="badge badge-sm small ${row['bg_status']} text-white">${row['status']}</span>
                                </a>`;
                        if (row['approved_at'] != "") {
                            appr = `
                                        <p class="mb-0 text-muted small">Aprv By : ${row['approved_by']}</p>
                                        <hr style="margin-top:3px;margin-bottom:3px;">
                                        <p class="mb-0 text-secondary small">Aprv At : ${row['tgl_approve']} | ${row['jam_approve']}</p>
                                        <hr style="margin-top:3px;margin-bottom:3px;">
                                        <a class="text-secondary dd-arrow-none" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                                            <span class="badge badge-sm small ${row['bg_status']} text-white">${row['status']}</span>
                                        </a>
                                `
                        }
                        return `
                                <div class="dropdown d-inline-block">
                                        ${appr}
                                    <ul class="dropdown-menu dropdown-menu-start">
                                       ${ite_opt}
                                    </ul>
                                </div>`
                    },
                },
                {
                    "data": "tgl_ph",
                    "className": "align-middle d-none text-dinamis"
                },
                {
                    "data": "from_date",
                    "className": "align-middle d-none text-dinamis",
                    "render": function(data, type, row, meta) {
                        return `${row['from_date']} s/d ${row['to_date']}`
                    },
                },
                {
                    "data": "total_day",
                    "className": "align-middle d-none text-dinamis"
                },
                {
                    "data": "approved_at",
                    "className": "align-middle d-none text-dinamis"
                },
                {
                    "data": "approved_by",
                    "className": "align-middle d-none text-dinamis"
                },
                {
                    "data": "kota",
                    "className": "align-middle d-none text-dinamis"
                },

            ],
        });
    }

    function get_pending_leave() {
        let comp = $('#company_id').val();
        let dept = $('#department_id').val();
        let emp = $('#employee_id').val();
        let stat_leav = $('#status_leave').val();
        periode = $("#year-leave").val() + '-' + $("#month-leave").val();
        let txz = "<?= $txz ?>";
        let spv = "<?= $spv ?>";

        var table = $('#dt_pending_leave').DataTable({
            orderCellsTop: false,
            // fixedHeader: true,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "ordering": false,
            "autoWidth": false,
            "order": [
                [0, 'desc']
            ],
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="bi bi-file-earmark-arrow-down"></i> Excel',
                footer: true
            }],
            responsive: true,
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    periode: periode,
                    company_id: comp,
                    department_id: dept,
                    employee_id: emp,
                    status_leave: 1,
                },
                "url": "<?= base_url(); ?>leave/pending_leave",
            },
            "columns": [{
                    className: 'dt-control align-self-center align-middle',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                {
                    "data": "applied_on_2",
                    "className": "align-middle text-dinamis d-none d-md-table-cell"
                },
                {
                    "data": "type_name",
                    "className": "align-middle",
                    "render": function(data, type, row, meta) {
                        return ` <div class="col">
                                    <p class="text-dinamis text-color-theme mb-0 d-block d-md-none" style="font-size:9pt;">${row['applied_on']}</p>
                                    <p class="text-dinamis text-color-theme mb-0 text-dinamis" >${row['type_name']}</p>
                                </div>`
                    },
                },
                {
                    "data": "company_name",
                    "className": "align-middle d-none text-dinamis"
                },
                {
                    "data": "department_name",
                    "className": "align-middle d-none d-md-table-cell text-dinamis"
                },
                {
                    "data": "employee_name",
                    "className": "align-middle d-none d-md-table-cell text-dinamis"
                },
                {
                    "data": "status",
                    "render": function(data, type, row, meta) {
                        if (txz == true && spv == true) {
                            ite_opt = `<li><a class="dropdown-item text-primary" href="<?= base_url() ?>leave/detail/${row['leave_id']}"><i class="text-dinamis text-primary bi bi-arrow-right-square" ></i> Details</a></li>
                                        <li><a class="dropdown-item text-warning" href="javascript:void(0)" onclick="edit_leave('${row['leave_id']}','${row['employee_id']}','${row['reason']}')"><i class="text-dinamis text-warning bi bi-pencil-square" ></i> Edit</a></li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="delete_leave('${row['leave_id']}')"><i class="text-dinamis text-danger bi bi-trash" ></i> Delete</a></li>`
                        } else if (txz == false && spv == true) {
                            if (row['id_status'] == 2) {
                                li_edit = ''
                            } else {
                                li_edit = `<li><a class="dropdown-item text-warning" href="javascript:void(0)" onclick="edit_leave('${row['leave_id']}','${row['employee_id']}','${row['reason']}')"><i class="text-dinamis text-warning bi bi-pencil-square" ></i> Edit</a></li>`
                            }
                            ite_opt = `<li>
                                            <a class="dropdown-item text-primary" href="<?= base_url() ?>leave/detail/${row['leave_id']}"><i class="text-dinamis text-primary bi bi-arrow-right-square" ></i> Details</a>
                                        </li>
                                        ${li_edit}`
                        } else {
                            ite_opt = `<li><a class="dropdown-item text-warning" href="javascript:void(0)" onclick="edit_leave('${row['leave_id']}','${row['employee_id']}','${row['reason']}')"><i class="text-dinamis text-warning bi bi-pencil-square" ></i> Edit</a></li>`
                        }
                        // <div class="dropdown d-inline-block">
                        //     <a class="text-secondary dd-arrow-none" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                        //         <span class="badge badge-sm small ${row['bg_status']} text-white">${row['status']}</span>
                        //     </a>
                        //     <ul class="dropdown-menu dropdown-menu-start">
                        //        ${ite_opt}
                        //     </ul>
                        // </div>
                        return `
                                <a class="text-secondary" role="button" href="<?= base_url() ?>leave/detail/${row['leave_id']}">
                                    <span class="badge badge-sm small ${row['bg_status']} text-white">${row['status']}</span>
                                </a>
                                `
                    },
                },
                {
                    "data": "tgl_ph",
                    "className": "align-middle d-none text-dinamis"
                },
                {
                    "data": "from_date",
                    "className": "align-middle d-none text-dinamis",
                    "render": function(data, type, row, meta) {
                        return `${row['from_date']} s/d ${row['to_date']}`
                    },
                },
                {
                    "data": "total_day",
                    "className": "align-middle d-none text-dinamis"
                },
                {
                    "data": "approved_at",
                    "className": "align-middle d-none text-dinamis"
                },
                {
                    "data": "approved_by",
                    "className": "align-middle d-none text-dinamis"
                },
            ],
        });
    }


    function edit_leave(leave_id, employee_id, reason) {
        $.confirm({
            title: 'Edit Leave Request!',
            type: 'blue',
            theme: 'material',
            columnClass: 'col-12 col-md-6',
            content: `
					<form action="" id="form-edit-leave" class="formName">
						<div class="mb-3 col-12">
                            <input type="hidden" name="e_leave_id" id="e_leave_id" value="${leave_id}" readonly>
                            <input type="hidden" name="e_employe_id" id="e_employe_id" value="${employee_id}" readonly>
                        </div>
						<div class="mb-3 col-12">
                            <label for="e_reason">Reason</label>
                            <textarea name="reason" id="e_reason" cols="30" rows="3" class="form-control border-custom">${reason}</textarea>
                        </div>
					</form>`,
            buttons: {
                cancel: function() {
                    //close
                },
                formSubmit: {
                    text: 'Update',
                    btnClass: 'btn-blue',
                    action: function() {
                        let remarks = this.$content.find('#e_remarks').val();
                        if (!remarks) {
                            $.alert('Anda belum mengisi remarks');
                            return false;
                        }
                        let reason = this.$content.find('#e_reason').val();
                        if (!reason) {
                            $.alert('Anda belum mengisi reason');
                            return false;
                        }

                        $.confirm({
                            icon: 'fa fa-spinner fa-spin',
                            title: 'Mohon Tunggu!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Sedang memproses...',
                            buttons: {
                                close: {
                                    isHidden: true,
                                    actions: function() {}
                                },
                            },
                            onOpen: function() {
                                $.ajax({
                                    url: '<?= base_url() ?>leave/update_leave',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        leave_id: leave_id,
                                        employee_id: employee_id,
                                        remarks: remarks,
                                        reason: reason,
                                    },
                                    beforeSend: function() {

                                    },
                                    success: function(response) {},
                                    error: function(xhr) {},
                                    complete: function() {},
                                }).done(function(response) {
                                    // console.log(response);
                                    if (response.status == true) {
                                        get_applied_leave();
                                        setTimeout(() => {
                                            $(".tab-content").height('100%');
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'bi bi-check-lg',
                                                title: 'Done!',
                                                theme: 'material',
                                                type: 'blue',
                                                content: 'Success!',
                                                buttons: {
                                                    close: {
                                                        actions: function() {}
                                                    },
                                                },
                                            });
                                        }, 250);
                                    } else {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'bi bi-x-square',
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
                                    }
                                }).fail(function(jqXHR, textStatus) {
                                    setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'bi bi-x-square',
                                            title: 'Oops!',
                                            theme: 'material',
                                            type: 'red',
                                            content: 'Failed!' + textStatus,
                                            buttons: {
                                                close: {
                                                    actions: function() {}
                                                },
                                            },
                                        });
                                    }, 250);
                                });
                            },

                        });
                    }
                },
            },
            onContentReady: function() {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function(e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }

    // Add event listener for opening and closing details
    $('#dt_applied_leave tbody').on('click', 'td.dt-control', function() {
        var tr = $(this).closest('tr');
        var row = $('#dt_applied_leave').DataTable().row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(detail_applied_leave(row.data())).show();
            tr.addClass('shown');
            $(".tab-content").height('100%');
        }
    });

    function detail_applied_leave(d) {

        if (d.leave_attachment != "") {
            link_attachment = `<a href="https://trusmiverse.com/hr/uploads/leave/${d.leave_attachment}" target="_blank" class="text-dinamis"><i class="bi bi-arrow-up-right-square"></i> Go to File</a>`
        } else {
            link_attachment = ''
        }
        // `d` is the original data object for the row
        return (
            `<table class="table table-sm">
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Leave Type</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.type_name}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Employee Name</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.employee_name}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Company</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.company_name}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Department</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.department_name}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Day Off</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.tgl_ph}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Request Date</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.from_date} s/d <b class="text-dinamis">${d.to_date} </b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Request Hour</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.start_time} s/d <b class="text-dinamis">${d.end_time}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Total Day</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.total_day} days</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Reason</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.reason}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Kota</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.kota}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Leave Attachment</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${link_attachment}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Remarks</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.remarks}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Approved At</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.approved_at}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Approved By</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.approved_by}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Verified At</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.verified_at}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Verified By</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.verified_by}</b></td>
                </tr>
            </table>`
        );
    }





    // Add event listener for opening and closing details
    $('#dt_pending_leave tbody').on('click', 'td.dt-control', function() {
        var tr = $(this).closest('tr');
        var row = $('#dt_pending_leave').DataTable().row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(detail_pending_leave(row.data())).show();
            tr.addClass('shown');
            $(".tab-content").height('100%');
        }
    });

    function detail_pending_leave(d) {

        if (d.leave_attachment != "") {
            link_attachment = `<a href="https://trusmiverse.com/hr/uploads/leave/${d.leave_attachment}" target="_blank" class="text-dinamis"><i class="bi bi-arrow-up-right-square"></i> Go to File</a>`
        } else {
            link_attachment = ''
        }
        // `d` is the original data object for the row
        return (
            `<table class="table table-sm">
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Leave Type</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.type_name}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Employee Name</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.employee_name}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Company</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.company_name}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Department</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.department_name}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Day Off</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.tgl_ph}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Request Date</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.from_date} s/d <b class="text-dinamis">${d.to_date} </b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Request Hour</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.start_time} s/d <b class="text-dinamis">${d.end_time}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Total Day</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.total_day} days</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Reason</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.reason}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Leave Attachment</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${link_attachment}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Remarks</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.remarks}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Approved At</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.approved_at}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Approved By</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.approved_by}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Verified At</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.verified_at}</b></td>
                </tr>
                <tr>
                    <td class"text-dinamis"><b class="text-dinamis">Verified By</b></td>
                    <td class"text-dinamis"><b class="text-dinamis">${d.verified_by}</b></td>
                </tr>
            </table>`
        );
    }

    // var table_search = $('#dt_applied_leave').DataTable();

    // // #myInput is a <input type="text"> element
    // $('#applied_filter').on('keyup', function() {
    //     table_search.search(this.value).draw();
    // });

    // function export_aset(index) {
    //     $("#dt_applied_leave").DataTable().button(index).trigger();
    // }


    function delete_leave(leave_id) {
        $.confirm({
            title: 'Alert!',
            type: 'red',
            theme: 'material',
            content: `Apakah anda yakin ingin hapus request leave ini ?`,
            buttons: {
                cancel: function() {
                    //close
                },
                formSubmit: {
                    text: 'Delete',
                    btnClass: 'btn-red',
                    action: function() {
                        $.confirm({
                            icon: `fa fa-spinner fa-spin`,
                            title: 'Mohon Tunggu!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Sedang memproses...',
                            buttons: {
                                close: {
                                    isHidden: true,
                                    actions: function() {}
                                },
                            },
                            onOpen: function() {
                                $.ajax({
                                    url: '<?= base_url() ?>leave/delete_leave',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        leave_id: leave_id,
                                    },
                                    beforeSend: function() {

                                    },
                                    success: function(response) {},
                                    error: function(xhr) {},
                                    complete: function() {},
                                }).done(function(response) {
                                    if (response.status == true) {
                                        setTimeout(() => {
                                            $(".tab-content").height('100%');
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-check',
                                                title: 'Request Deleted!',
                                                theme: 'material',
                                                type: 'blue',
                                                content: 'Success!',
                                                buttons: {
                                                    close: {
                                                        actions: function() {}
                                                    },
                                                },
                                            });
                                        }, 250);

                                        setTimeout(() => {
                                            get_applied_leave();
                                        }, 1000);
                                    } else {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-close',
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
                                    }
                                }).fail(function(jqXHR, textStatus) {
                                    setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-close',
                                            title: 'Oops!',
                                            theme: 'material',
                                            type: 'red',
                                            content: 'Failed!' + textStatus,
                                            buttons: {
                                                close: {
                                                    actions: function() {}
                                                },
                                            },
                                        });
                                    }, 250);
                                });
                            },

                        });
                    }
                },
            },
        });
    }
</script>