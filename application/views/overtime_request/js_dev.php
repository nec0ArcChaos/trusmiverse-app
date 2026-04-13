<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/clockpicker/jquery-clockpicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js" type="text/javascript"></script>


<script>
    $(document).ready(function() {

        //Datepicker
        // var start = moment().startOf('month');
        var start = moment().subtract(1, 'months').startOf('month'); // Faisal | Filter date mundur 1 Bulan
        var end = moment().endOf('month');

        $('#request_date').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: "yyyy-mm-dd",
            "setDate": new Date(),
        });

        // Tambahkan ClockPicker ke setiap input waktu dalam DataTable by Ade
        $('#dt_overtime_request_list').on('draw.dt', function() {
            $('.clockpicker').clockpicker({
                donetext: 'Done',
                placement: 'bottom',
                autoclose: true,
                'default': '17:00'
            });
        });

        $('.clockpicker').clockpicker({
            donetext: 'Done',
            placement: 'bottom',
            autoclose: true,
            'default': '17:00'
        });

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
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
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

        let selectReason = new SlimSelect({
            select: '#reason',
            settings: {
                placeholderText: 'Reason ?',
            }
        });


        $('#resignation_date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            // uiLibrary: 'bootstrap4'
        });

        filter_date()

    }); // END :: Ready Function


    function filter_date() {
        var start = $('#start').val();
        var end = $('#end').val();

        dt_overtime_request(start, end);
    }


    function add_request() {

        $('#in_time').val('');
        $('#out_time').val('');
        $('#reason').val('');
        $('#reason').text('');
        $('#time_request_id').remove();
        $('#btn_save').show();
        $('#btn_update').hide();

    }


    function dt_overtime_request(start, end, status = null) {
        $('#dt_overtime_request').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "autoWidth": false,
            "dom": 'Bfrtip',
            "order": [
                [5, 'desc']
            ],
            responsive: true,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": "<?= base_url(); ?>overtime_request/dt_overtime_request",
                "data": {
                    start: start,
                    end: end,
                    status: status,
                }
            },
            "columns": [{
                    "data": "time_request_id",
                    render: function(data, type, row, meta) {
                        if (row['user_level'] == '2') { // 2 : staff

                            if (row['tr.is_approved'] == '1') {

                                return `<span href="" data-toggle="tooltip" data-placement="top" title="Edit" data-original-title="Edit">
                                            <button type="button" class="btn btn-sm btn-outline-success waves-effect waves-light edit-data" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modal_add_request" 
                                                onclick="edit_request('${data}')" >
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </span>
                                        
                                        <span data-toggle="tooltip" data-placement="top" title="Delete" data-original-title="Delete">
                                            <button type="button" class="btn btn-sm btn-outline-danger waves-effect waves-light delete" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalDeleteConfirm"
                                                onclick="delete_request('${data}')"
                                                >
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </span>`;

                            } else {
                                return ``
                            }

                        } else {

                            return ``

                        }

                    }
                },
                {
                    "data": "employee_name",
                },
                {
                    "data": "company_name",
                },
                {
                    "data": "department_name",
                },
                {
                    "data": "designation_name",
                },
                {
                    "data": "date",
                },
                {
                    "data": "in_time",
                },
                {
                    "data": "out_time",
                },
                {
                    "data": "total_hours",
                },
                {
                    "data": "status",
                    render: function(data, type, row, meta) {

                        var user_id = <?= $this->session->userdata('user_id') ?>;
                        // console.log('user_id: ', user_id);
                        if (row['is_approved'] == '1') {
                            return `<span class="badge badge-sm bg-warning">${data}</span>`
                        } else if (row['is_approved'] == '2') {
                            // edit by Ade
                            if (user_id == 1 || user_id == 778 || user_id == 979) {
                                return `<span href="">
                                        <button type="button" class="badge badge-sm bg-success" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modal_edit_request" 
                                            onclick="edit_request_new('${row['time_request_id']}')" >
                                            ${data}
                                        </button>
                                    </span>`;
                            } else {
                                return `<span class="badge badge-sm bg-success">${data}</span>`
                            }
                        } else if (row['is_approved'] == '3') {
                            return `<span class="badge badge-sm bg-danger">${data}</span>`
                        } else {
                            return data
                        }
                    }
                },
                {
                    "data": "reason",
                },
                 // devnew
                {
                    'data': 'dokumen',
                    'render': function (data, type, row) {
                        if (data && data !== "") {
                            // URL file
                            let url = "https://trusmiverse.com/apps/uploads/overtime_request/" + data;

                            return `
                                <a href="${url}" target="_blank" class="badge bg-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            `;
                        } else {
                            return `<span class="badge bg-secondary">No File</span>`;
                        }
                    },
                    'className': 'text-center'
                },
                {
                    "data": "created_at",
                },
                {
                    "data": "approve_gm",
                },
                {
                    "data": "approve_gm_date",
                },
            ],
        });
    }

    function save() {
        if ($('#request_date').val() == '') {
            error_alert("Date is required!");
            $('#request_date').focus();
        } else if ($('#in_time').val() == '') {
            error_alert("In Time is required!");
            $('#in_time').focus();
        } else if ($('#out_time').val() == '') {
            error_alert("Out Time is required!");
            $('#out_time').focus();
        } else if ($('#reason').val() == '') {
            error_alert("Reason is required!");
            $('#reason').focus();
        } else {
            $("#modalAddConfirm").modal("show");
        }
    }

    function save_request() {
        // form = $('#form_add_request');
        // devnew
        let formData = new FormData($("#form_add_request")[0]);

        $.ajax({
            url: '<?= base_url('overtime_request_dev/save_request') ?>',
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: formData,
            beforeSend: function() {
                $('#btn_save_confirm').attr('disabled', true);
                $("#btn_save_confirm").html("Please wait...");
            },
            success: function(response) {
                success_alert('Overtime Request Added');
                $("#modalAddConfirm").modal("hide");
                $("#modal_add_request").modal("hide");

                filter_date();

            },
            error: function(xhr) { // if error occured
                error_alert('Failed, Error Occured');
            },
            complete: function() {
                $('#btn_save_confirm').attr('disabled', false);
                $("#btn_save_confirm").html("Yes, Save");
            },
        });
    }


    function edit_request(time_request_id) {
        // console.info(time_request_id);
        $.ajax({
            url: "<?= base_url('overtime_request/dt_overtime_request') ?>",
            type: "POST",
            dataType: "json",
            data: {
                time_request_id: time_request_id
            },
            success: function(response) {
                $('#request_date').val(response.data[0].date);
                $('#in_time').val(response.data[0].clock_in);
                $('#out_time').val(response.data[0].clock_out);
                $('#reason').val(response.data[0].reason);


                $('#time_request_id').remove();
                time_request_id = `<input type="hidden" id="time_request_id" name="time_request_id" value="${time_request_id}">`
                $('#form_add_request').append(time_request_id);

                $('#btn_save').hide();
                $('#btn_update').show();
                filter_date();
            }
        })
    }

    // add edit_request_new for Personalia by Ade
    function edit_request_new(time_request_id) {
        // console.info(time_request_id);
        $.ajax({
            url: "<?= base_url('overtime_request_dev/get_overtime_request') ?>",
            type: "POST",
            dataType: "json",
            data: {
                time_request_id: time_request_id
            },
            success: function(response) {
                console.log(response);
                $('#edit_request_date').val(response.date);
                $('#edit_in_time').val(response.in_time);
                $('#edit_out_time').val(response.out_time);
                $('#edit_reason').val(response.reason);

                $('#edit_time_request_id').remove();
                edit_time_request_id = `<input type="hidden" id="edit_time_request_id" name="time_request_id" value="${time_request_id}">`;
                $('#form_edit_request').append(edit_time_request_id);

                $('#btn_save').hide();
                $('#btn_update').show();
                // filter_date();
            }
        })
    }

    // add by Ade
    function edit() {
        if ($('#edit_request_date').val() == '') {
            error_alert("Date is required!");
            $('#edit_request_date').focus();
        } else if ($('#edit_in_time').val() == '') {
            error_alert("In Time is required!");
            $('#edit_in_time').focus();
        } else if ($('#edit_out_time').val() == '') {
            error_alert("Out Time is required!");
            $('#edit_out_time').focus();
        } else if ($('#edit_reason').val() == '') {
            error_alert("Reason is required!");
            $('#edit_reason').focus();
        } else {
            $("#modalUpdateConfirmNew").modal("show");
        }
    }

    // confirm_update_request_new for personalia by Ade
    function confirm_update_request_new() {
        form = $('#form_edit_request');
        // console.log(form.serialize());
        // return;
        $.ajax({
            url: '<?= base_url('overtime_request_dev/update_request_new') ?>',
            type: 'POST',
            dataType: 'json',
            data: form.serialize(),
            beforeSend: function() {
                $('#btn_udpate_confirm_new').attr('disabled', true);
                $("#btn_udpate_confirm_new").html("Please wait...");
            },
            success: function(response) {
                success_alert('Overtime Request Updated');
                $("#modalUpdateConfirmNew").modal("hide");
                $("#modal_edit_request").modal("hide");

                filter_date();

            },
            error: function(xhr) { // if error occured
                error_alert('Failed, Error Occured');
            },
            complete: function() {
                $('#btn_udpate_confirm_new').attr('disabled', false);
                $("#btn_udpate_confirm_new").html("Yes, Update");
            },
        });
    }

    // end Ade

    function update_request() {
        if ($('#request_date').val() == '') {
            error_alert("Date is required!");
            $('#request_date').focus();
        } else if ($('#in_time').val() == '') {
            error_alert("In Time is required!");
            $('#in_time').focus();
        } else if ($('#out_time').val() == '') {
            error_alert("Out Time is required!");
            $('#out_time').focus();
        } else {
            $("#modalUpdateConfirm").modal("show");
        }

        console.info($('#request_date').val());
        console.info($('#in_time').val());
        console.info($('#out_time').val());

        // form = $('#form_add_request');
        // console.info(form.serialize());
    }

    function confirm_update_request() {
        form = $('#form_add_request');
        $.ajax({
            url: '<?= base_url('overtime_request/update_request') ?>',
            type: 'POST',
            dataType: 'json',
            data: form.serialize(),
            beforeSend: function() {
                $('#btn_udpate_confirm').attr('disabled', true);
                $("#btn_udpate_confirm").html("Please wait...");
            },
            success: function(response) {
                success_alert('Overtime Request Updated');
                $("#modalUpdateConfirm").modal("hide");
                $("#modal_add_request").modal("hide");

                filter_date();

            },
            error: function(xhr) { // if error occured
                error_alert('Failed, Error Occured');
            },
            complete: function() {
                $('#btn_udpate_confirm').attr('disabled', false);
                $("#btn_udpate_confirm").html("Yes, Update");
            },
        });
    }


    function delete_request(time_request_id) {
        $('#d_time_request_id').val(time_request_id);
    }

    function confirm_delete_request() {

        time_request_id = $('#d_time_request_id').val();

        $.ajax({
            url: "<?= base_url('overtime_request/delete_request') ?>",
            type: "POST",
            dataType: "json",
            data: {
                time_request_id: time_request_id
            },
            beforeSend: function() {
                $('#btn_delete_confirm').attr('disabled', true);
                $("#btn_delete_confirm").html("Please wait...");
            },
            success: function(response) {
                success_alert('Overtime Request Deleted');
                $("#modalDeleteConfirm").modal("hide");
                filter_date();
            },
            error: function(xhr) { // if error occured
                error_alert('Failed, Error Occured');
            },
            complete: function() {
                $('#btn_delete_confirm').attr('disabled', false);
                $("#btn_delete_confirm").html("Yes, Delete");
            },
        })


    }



    // APPROVAL
    function dt_overtime_request_list(status) {

        start = $('#start_list').val();
        end = $('#end_list').val();

        $('#dt_overtime_request_list').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "autoWidth": false,
            // "dom": 'Bfrtip',
            "ordering": false,
            // "order": [
            //     [5, 'desc']
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
                "url": "<?= base_url(); ?>overtime_request/dt_overtime_request",
                "data": {
                    start: start,
                    end: end,
                    status: status,
                }
            },
            "columns": [{
                'data': 'time_request_id',
                render: function(data, type, row, meta) {
                    return `<div class ="card"> 
                                    <div class ="card-header" style="background-color:cyan">
                                        <div class="float-end">
                                            <i class="bi bi-calendar-event"></i> ${row['converted_date']}
                                        </div>
                                    </div>
                                    <div class ="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <i class="text-secondary bi bi-person"></i></i> ${row['employee_name']} <br>
                                                <i class="text-secondary bi bi-pin-angle"></i> ${row['designation_name']} <br><br>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">

                                                <i class="text-secondary bi bi-clock"></i> ${row['clock_in']} - ${row['clock_out']} (Actual Clock (in-out))<br>
                                                <i class="text-secondary bi bi-clock"></i> ${row['shift_in']} - ${row['shift_out']} (Shift (in-out))<br>
                                                <i class="text-secondary bi bi-clock"></i> ${row['in_time']}x - ${row['out_time']}x (Request Clock (in-out))<br>
                                                <i class="text-secondary bi bi-hourglass-split"></i> ${row['total_hours']} <br><br>

                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="input-group input-group-lg">
                                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-clipboard"></i></span>
                                                        <div class="form-floating by ade">
                                                            <input type="text" name="reason" id="reason_${data}" class="form-control border-start-0" required value="${row['reason']}">
                                                            <label>Reason</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-2">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="input-group input-group-lg clockpicker">
                                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-hourglass-top"></i></span>
                                                        <div class="form-floating by ade">
                                                            <input type="text" name="in_time_edit" id="in_time_${data}" class="form-control border-start-0 time_edit" required placeholder="--:--">
                                                            <label>In Time</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback mb-3">Add valid data </div>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="input-group input-group-lg clockpicker">
                                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-hourglass-bottom"></i></span>
                                                        <div class="form-floating by ade">
                                                            <input type="text" name="out_time_edit" id="out_time_${data}" class="form-control border-start-0" required placeholder="--:--">
                                                            <label>Out Time</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="request_date_${data}" value="${row['date']}">
                                                <div class="invalid-feedback mb-3">Add valid data </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class ="card-header">
                                        <div class="float-end">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-outline-danger" onclick="approve_request(3, '${data}', '${row['employee_name'].split("'").join("")}')">
                                                <i class="bi bi-x"></i> Reject
                                            </a>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-outline-theme" onclick="approve_request(2, '${data}', '${row['employee_name'].split("'").join("")}')">
                                                <i class="bi bi-check"></i> Approve
                                            </a>
                                        </div>
                                    </div>

                                </div>`
                }
            }],

        });
    }

    // pin by Ade
    function approve_request(status, time_request_id, employee_name) {
        // add by Ade
        var request_date = $('#request_date_' + time_request_id).val();
        var in_time = $('#in_time_' + time_request_id).val();
        var out_time = $('#out_time_' + time_request_id).val();
        var reason = $('#reason_' + time_request_id).val();
        console.log(in_time);

        if (in_time == '') {
            error_alert("In time is required!");
            $('#in_time_' + time_request_id).focus();
            return;
        } else if (out_time == '') {
            error_alert("Out time is required!");
            $('#out_time_' + time_request_id).focus();
            return;
        }

        if (status == '2') { // 2: Approved
            title = 'Approve Request?';
            type = 'green';
            btnClass = 'btn-green';
            btnText = "Approve";
        } else {
            title = 'Reject Request?';
            type = 'red';
            btnClass = 'btn-red';
            btnText = "Reject";
        }

        $.confirm({
            title: title,
            content: employee_name,
            type: type,
            typeAnimated: true,
            buttons: {
                approve: {
                    text: btnText,
                    yes: 'Yes',
                    btnClass: btnClass,
                    action: function() {
                        $.ajax({
                            url: "<?= base_url("overtime_request_dev/approve_request") ?>",
                            type: "POST",
                            dataType: "json",
                            data: {
                                time_request_id: time_request_id,
                                status: status,
                                // add by Ade
                                request_date: request_date,
                                in_time: in_time,
                                out_time: out_time,
                                reason: reason
                            },
                            success: function(response) {
                                dt_overtime_request_list(1)
                                filter_date();
                            }
                        })
                    }
                },
                close: function() {}
            }
        });
    }


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
</script>