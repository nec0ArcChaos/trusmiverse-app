<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<!-- <script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script> -->
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/clockpicker/jquery-clockpicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery.blockUI.js"></script>


<!-- Fomantic Or Semantic Ui -->
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/dropdown.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/transition.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/form.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/popup.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/toast.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/node_modules/compressorjs/dist/compressor.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    $(document).ready(function() {

        $('#workshop_type').dropdown_se({
            placeholder: 'Tipe Workshop',
            useLabels: false
        });

        $('#department_id').dropdown_se();
        $('#participant_plan').dropdown_se();
        $('#source').dropdown_se();
        $('#trainer_id').dropdown_se();
        $('#title_id').dropdown_se();

        $(".mask-date").mask('0000-00-00')

        $('.tanggal').datetimepicker({
            format: 'Y-m-d H:i',
            timepicker: true,
            scrollMonth: false,
            scrollInput: false,
        });

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
            filter_data()
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


    }); // END :: Ready Function

    function unblock_ui(id_elemenet) {
        $('#' + id_elemenet).unblock();
    }

    function block_ui(id_elemenet = 'card_spv_detail') {
        $('#' + id_elemenet).block({
            message: 'Loading...',
            overlayCSS: {
                backgroundColor: "#fff",
                opacity: 0.8,
                cursor: "wait",
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: "transparent",
            },
        });
    }

    function filter_data() {
        var start = $('#start').val();
        var end = $('#end').val();

        dt_workshop(start, end);
    }

    dt_workshop('<?= date("Y-m-01") ?>', '<?= date("Y-m-t") ?>');

    $('.button')
        .popup({
            inline: true
        });

    function dt_workshop(start, end) {
        $('#dt_workshop').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "responsive": false,
            "dom": 'Bfrtip',
            "order": [
                [1, 'desc']
            ],
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": "<?= base_url('workshop/dt_workshop'); ?>",
                "data": {
                    start: start,
                    end: end,
                }
            },
            "columns": [{
                    "data": "workshop_at",
                    "className": "text-nowrap",
                    // "render": function(data, type, row, meta) {
                    //     return `<div class="col px-0 align-self-center">
                    //                 <p class="mb-0"><i class="bi bi-calendar-date"></i> ${row['workshop_at']}</p>
                    //                 <hr class="m-0 p-0">
                    //                 <p class="mb-0 small"><i class="bi bi-clock"></i> ${row['workshop_time']} WIB</p>
                    //             </div>`
                    // }
                },
                {
                    "data": "workshop_time",
                    "className": "small"
                },
                {
                    "data": "title_name",
                    "className": "small"
                },
                {
                    "data": "status",
                    "className": "",
                    "render": function(data, type, row, meta) {
                        if (row['status'] == 'Plan') {
                            btn_status = `<a role="button" class="badge bg-yellow text-white" style="cursor:pointer;" onclick="modal_update_workshop('${row['workshop_id']}')">${row['status']}</a>`
                        } else {
                            btn_status = `<a role="button" class="badge bg-primary text-white" style="cursor:pointer;" onclick="modal_update_workshop('${row['workshop_id']}')">${row['status']}</a>`
                        }
                        return btn_status
                    }
                },
                {
                    "data": "type_name",
                    "render": function(data, type, row, meta) {
                        return `<span class="small text-muted"><i class="bi bi-tags"></i> ${row['type_name']}</span>`
                    }
                },
                {
                    "data": "trainer_name",
                    "className": "small",
                    "render": function(data, type, row, meta) {
                        return `${row['trainer_name']}<br>(${row['workshop_id']})`
                    }
                },
                {
                    "data": "department_name",
                    "className": "text-nowrap",
                    "render": function(data, type, row, meta) {
                        let arr_department = [];
                        arr_department = row['department_name'].split(',');
                        let department_content = '<ol style="padding-left:1rem;padding-right:1rem;">';
                        arr_department.forEach(function(item) {
                            department_content += `<li class="small">${item.trim()}</li>`;
                        });
                        department_content += '</ol>';
                        return department_content;
                    }
                },
                {
                    "data": "participant_plan_name",
                    "className": "",
                    "render": function(data, type, row, meta) {
                        let arr_participant = [];
                        arr_participant = row['participant_plan_name'].split(',');
                        let participant_content = '<ol style="padding-left:1rem;padding-right:1rem;">';
                        arr_participant.forEach(function(item) {
                            participant_content += `<li class="small">${item.trim()}</li>`;
                        });
                        participant_content += '</ol>';
                        return participant_content;
                    }
                },
                {
                    "data": "participant_actual",
                    "render": function(data, type, row, meta) {
                        if (row['participant_actual_name'].indexOf(',') !== -1) {
                            let arr_participant_actual = [];
                            arr_participant_actual = row['participant_actual_name'].split(',');
                            let participant_actual_content = '<ol style="padding-left:1rem;padding-right:1rem;">';
                            arr_participant_actual.forEach(function(item) {
                                participant_actual_content += `<li class="small">${item.trim()}</li>`;
                            });
                            participant_actual_content += '</ol>';
                            return participant_actual_content;
                        } else {
                            return `<ol style="padding-left:1rem;padding-right:1rem;">
                                        <li class="small">${row['participant_actual_name']}</li>
                                    </ol>`
                        }
                    }
                },

                {
                    "data": "commitment",
                    "className": "small"
                },
                {
                    "data": "documentation",
                    "render": function(data, type, row, meta) {
                        if (row['documentation'] != '') {
                            return `<a href="<?= base_url() ?>uploads/workshop/${row['documentation']}" data-fancybox data-caption="Single image">
                                <img src="<?= base_url() ?>uploads/workshop/${row['documentation']}" data-src="<?= base_url() ?>uploads/workshop/${row['documentation']}" width="30" height="30" loading="lazy">
                            </a>`
                        } else {
                            return '-'
                        }
                    }
                },
                {
                    "data": "created_at",
                    "className": "small"
                },
                {
                    "data": "created_by_name",
                    "className": "small"
                },
            ],
        });
    }

    // Add event listener for opening and closing details
    $('#dt_workshop tbody').on('click', 'td.dt-control', function() {
        // console.log('test')
        var tr = $(this).closest('tr');
        var row = $('#dt_workshop').DataTable().row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });

    function format(d) {
        // `d` is the original data object for the row
        let arr_participant = [];
        arr_participant = d.participant_plan_name.split(',');
        let participant_content = '<ol style="padding-left:1rem;padding-right:1rem;">';
        arr_participant.forEach(function(item) {
            participant_content += `<li class="small">${item.trim()}</li>`;
        });
        participant_content += '</ol>';

        let participant_actual_content = '';

        if (d.participant_actual_name.indexOf(',') !== -1) {
            let arr_participant_actual = [];
            arr_participant_actual = d.participant_actual_name.split(',');
            participant_actual_content += '<ol style="padding-left:1rem;padding-right:1rem;">';
            arr_participant_actual.forEach(function(item) {
                participant_actual_content += `<li class="small">${item.trim()}</li>`;
            });
            participant_actual_content += '</ol>';
        }
        return (

            `<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;widht:100%;">
                <tr><td><b>Tgl Workshop</b></td><td>${d.workshop_at}</td></tr>
                <tr><td><b>Status</b></td><td>${d.status}</td></tr>
                <tr><td><b>Type</b></td><td>${d.type_name}</td></tr>
                <tr><td><b>Title</b></td><td>${d.title_name}</td></tr>
                <tr><td><b>Trainer</b></td><td>${d.trainer_name}</td></tr>
                <tr><td><b>Company - Department</b></td><td>${d.department_name}</td></tr>
                <tr><td><b>Participant Plan</b></td><td>${participant_content}</td></tr>
                <tr><td><b>Participant Actual</b></td><td>${participant_actual_content}</td></tr>
                <tr><td><b>Commitment</b></td><td>${d.commitment}</td></tr>
                <tr><td><b>Documentation</b></td><td>${d.documentation}</td></tr>
                <tr><td><b>Created System</b></td><td>${d.created_at}</td></tr>
                <tr><td><b>Created By</b></td><td>${d.created_by_name}</td></tr>
        </table>`
        );
    }

    function modal_add_workshop() {
        $('#modal_add_workshop').modal('show');
        check_source_trainer();
        $('#workshop_at').val('');
        $('#workshop_end').val('');
        $("#workshop_type").val('');
        $("#workshop_type").dropdown_se('clear');
        $("#workshop_type").val('1');
        $("#workshop_type").dropdown_se('set selected', '1');
        $("#participant_plan :selected").val('');
        $("#participant_plan").dropdown_se('clear');
        $('#department_id').val('');
        $("#department_id").dropdown_se('clear');
        $('#participant_plan').val('');
        $('#title_id').val('');
        $('#title_id :selected').text('');
        $("#title_id").dropdown_se('clear');
        $('#source').val('Internal');
        $('#trainer_id').val('');
        $('#trainer_id').dropdown_se('clear');
        $('#trainer_name').val('');
        $('#workshop_place').val('');
    }

    function modal_update_workshop(workshop_id) {
        $('#e_workshop_id').val(workshop_id);
        $('#e_commitment').val('');
        $('#e_documentation').val('');
        $('#e_participant_actual').val('');
        $('#e_participant_actual').dropdown_se('clear');
        $.ajax({
            url: '<?= base_url() ?>workshop/get_detail_workshop',
            type: 'POST',
            dataType: 'json',
            data: {
                workshop_id: workshop_id
            },
            beforeSend: function() {
                block_ui('div_detail_workshop');
            },
            success: function(response) {},
            error: function(xhr) {},
            complete: function() {

            },
        }).done(function(response) {
            if (response.data.status == "Terlaksana") {
                $('#div_resend_notif').addClass('d-none');
                $('#div_form_update_workshop').addClass('d-none');
                $('#dialog_modal_update_workshop').removeClass('modal-xl').addClass('modal-lg');
            } else {
                $('#div_resend_notif').removeClass('d-none');
                $('#div_form_update_workshop').removeClass('d-none');
                $('#dialog_modal_update_workshop').removeClass('modal-lg').addClass('modal-xl');
            }

            $('#modal_update_workshop').modal('show');



            unblock_ui('div_detail_workshop');
            $('#p_workshop_at').text(response.data.workshop_at)
            $('#p_workshop_time').text(response.data.workshop_time + ' WIB')
            $('#p_title').text(response.data.title_name)
            $('#p_status').text(response.data.status)
            $('#p_type_name').text(response.data.type_name)
            $('#p_trainer_name').text(response.data.trainer_name)
            $('#p_department_name').text(response.data.department_name)
            console.log(response);

            avatar_pic = ``;
            avatar_pic_plus = ``;
            if (response.data.participant_plan_name != '') {
                let arr_participant = [];
                arr_participant = response.data.participant_plan_name.split(',');
                let p_participant = '<ol style="padding-left:1rem;padding-right:1rem;">';
                arr_participant.forEach(function(item) {
                    p_participant += `<li class="small">${item.trim()}</li>`;
                });
                p_participant += '</ol>';
                $('#p_participant').empty().append(p_participant);
            } else {
                $('#p_participant').empty().append('');
            }

            if (response.data.participant_actual_name != '') {
                let arr_participant_actual = [];
                arr_participant_actual = response.data.participant_actual_name.split(',');
                let p_participant_actual = '<ol style="padding-left:1rem;padding-right:1rem;">';
                arr_participant_actual.forEach(function(item) {
                    p_participant_actual += `<li class="small">${item.trim()}</li>`;
                });
                p_participant_actual += '</ol>';
                $('#p_participant_actual').empty().append(p_participant_actual);
            } else {
                $('#p_participant_actual').empty().append('');
            }

            if (response.data.documentation != '') {
                $('#p_documentation').empty().append(`<a href="<?= base_url() ?>uploads/workshop/${response.data.documentation}" data-fancybox data-caption="Single image">
                                <img src="<?= base_url() ?>uploads/workshop/${response.data.documentation}" data-src="<?= base_url() ?>uploads/workshop/${response.data.documentation}" width="30" height="30" loading="lazy">
                            </a>`)
            } else {
                $('#p_documentation').empty().append('-')
            }

            if (response.data.commitment != '') {
                $('#p_commitment').empty().append(response.data.commitment)
            } else {
                $('#p_commitment').empty().append('-')
            }

            department_string = response.data.department_id
            participant_plan_array = response.data.participant_plan.split(',');

            // console.log(participant_plan_array);
            $.ajax({
                url: '<?= base_url() ?>workshop/get_participant',
                type: 'POST',
                dataType: 'json',
                data: {
                    department_id: department_string
                },
                beforeSend: function() {

                },
                success: function(response) {

                },
                error: function(xhr) { // if error occured

                },
                complete: function() {

                },
            }).done(function(response_participant) {
                participant_list = '';
                $.each(response_participant, function(index, value) {
                    participant_list += `<option value="${value['participant_plan']}">${value['participant_name']}</option>`;
                });
                $("#e_participant_actual").empty().append(participant_list);
                $("#e_participant_actual").val(participant_plan_array);
                $('#e_participant_actual').dropdown_se('set selected', participant_plan_array);
            }).fail(function(jqXhr, textStatus) {

            });
        }).fail(function(jqXhr, textStatus) {

        });
    }

    get_workshop_type();

    function get_workshop_type() {
        url = "<?= base_url('workshop/get_workshop_type') ?>";
        $.getJSON(url, function(result) {
            workshop_type = '';
            $.each(result, function(index, value) {
                workshop_type += `<option value="${value['type_id']}">${value['type_name']}</option>`;
            });
            $("#workshop_type").empty().append(workshop_type)
        });

    }


    get_materi();

    function get_materi() {
        url = "<?= base_url('workshop/get_materi') ?>";
        $.getJSON(url, function(result) {
            materi_list = '<option value="">All</option>';
            $.each(result, function(index, value) {
                materi_list += `<option value="${value['title_id']}">${value['title_name']}</option>`;
            });
            $("#title_id").empty().append(materi_list)
        });

    }

    get_department();

    function get_department() {
        url = "<?= base_url('workshop/get_department') ?>";
        $.getJSON(url, function(result) {
            department_list = '<option value="all">All</option>';
            $.each(result, function(index, value) {
                department_list += `<option value="${value['department_id']}">${value['department_name']}</option>`;
            });
            $("#department_id").empty().append(department_list)
        });

    }


    get_trainer();

    function get_trainer() {
        $.ajax({
            url: '<?= base_url() ?>workshop/get_trainer',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            trainer_list = '<option value="">-</option>'
            $.each(response, function(index, value) {
                trainer_list += `<option value="${value['trainer_id']}" data-trainer_name="${value['trainer_name']}">${value['trainer']}</option>`;
            });
            $("#trainer_id").empty().append(trainer_list)
        }).fail(function(jqXhr, textStatus) {

        });
    }

    $('#trainer_id').on('change', function() {
        trainer_name = $('#trainer_id :selected').text();
        console.log(trainer_name);
        $('#trainer_name').val(trainer_name)
    });

    $('#department_id').on('change', function() {
        department_id = $('#department_id').val();
        if (department_id.length > 1) {
            for (let index = 0; index < department_id.length; index++) {
                console.log(department_id[index]);
                if (department_id[index] == 'all') {
                    $('#department_id').dropdown_se('restore defaults');
                    break;
                }
            }
        }
        $('#department_id not:selected').prop('disabled', false);
        department_string = $('#department_id').val().toString();
        if (department_string != '') {
            $.ajax({
                url: '<?= base_url() ?>workshop/get_participant',
                type: 'POST',
                dataType: 'json',
                data: {
                    department_id: department_string
                },
                beforeSend: function() {

                },
                success: function(response) {

                },
                error: function(xhr) { // if error occured

                },
                complete: function() {

                },
            }).done(function(response) {
                participant_list = '';
                $.each(response, function(index, value) {
                    participant_list += `<option value="${value['participant_plan']}">${value['participant_name']}</option>`;
                });
                $("#participant_plan").empty().append(participant_list)
            }).fail(function(jqXhr, textStatus) {

            });
        }
    });

    function check_source_trainer() {
        $('#div_trainer_select').removeClass('d-none');
        $('#div_trainer_name').removeClass('d-none');
        source = $('#source').val();
        console.log(source);
        if (source == "Internal") {
            $('#div_trainer_name').addClass('d-none');
            $('#div_trainer_select').removeClass('d-none');
            $('#trainer_id').val('');
            $('#trainer_id').dropdown_se('clear');
        } else {
            $('#div_trainer_select').addClass('d-none');
            $('#div_trainer_name').removeClass('d-none');
            $('#trainer_name').val('');
        }
    }

    function save_workshop() {
        workshop_at = $('#workshop_at').val();
        workshop_end = $('#workshop_end').val();
        workshop_type = $("#workshop_type :selected").val();
        console.log(workshop_type);
        participant_plan = $("#participant_plan :selected").val();
        department_id = $('#department_id').val();
        participant_plan = $('#participant_plan').val();
        title_id = $('#title_id').val();
        title_name = $('#title_id :selected').text();
        source = $('#source').val();
        trainer_id = $('#trainer_id').val();
        trainer_name = $('#trainer_name').val();
        workshop_place = $('#workshop_place').val();

        if (workshop_at == '') {
            error_alert("Tanggal Workshop tidak boleh kosong!");
            $('#workshop_at').focus();
        } else if (workshop_end == '') {
            error_alert("Tanggal End Workshop tidak boleh kosong!");
            $('#workshop_end').focus();
        } else if (workshop_type == '') {
            error_alert("Tipe Workshop tidak boleh kosong!");
        } else if (workshop_type == '') {
            error_alert("Tipe Workshop tidak boleh kosong!");
            $('#workshop_type').focus();
        } else if (department_id.toString() == '') {
            error_alert("Department tidak boleh kosong!");
            $('#department_id').focus();
        } else if (participant_plan.toString() == '') {
            error_alert("Peserta tidak boleh kosong!");
            $('#participant_plan').focus();
        } else if (title_id == '') {
            error_alert("Materi tidak boleh kosong!");
            $('#title_id').focus();
        } else if (source == '') {
            error_alert("Sumber Pemateri tidak boleh kosong!");
            $('#source').focus();
        } else if (trainer_id.toString() == '' && source == 'Internal') {
            error_alert("Pemateri tidak boleh kosong!");
            $('#trainer_id').focus();
        } else if (trainer_name == '') {
            error_alert("Pemateri tidak boleh kosong!");
            $('#trainer_name').focus();
        } else if (workshop_place == '') {
            error_alert("Tempat Workshop tidak boleh kosong!");
            $('#workshop_place').focus();
        } else {

            form = $('#form_add_workshop');
            $.confirm({
                title: 'Form Workshop',
                content: 'Simpan Workshop ?',
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
                                        url: `<?= base_url('workshop/save_workshop') ?>`,
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            workshop_at: workshop_at,
                                            workshop_end: workshop_end,
                                            workshop_type: workshop_type,
                                            participant_plan: participant_plan,
                                            department_id: department_id.toString(),
                                            participant_plan: participant_plan.toString(),
                                            title_id: title_id,
                                            title_name: title_name,
                                            source: source,
                                            trainer_id: trainer_id,
                                            trainer_name: trainer_name,
                                            workshop_place: workshop_place,
                                        },
                                        beforeSend: function() {},
                                        success: function(response) {},
                                        error: function(xhr) {},
                                        complete: function() {},
                                    }).done(function(response) {
                                        if (response.insert == true) {
                                            setTimeout(() => {
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Success!, mengirim notif ke peserta!',
                                                    buttons: {
                                                        close: function() {},
                                                    },
                                                });
                                                $('#modal_add_workshop').modal('hide');
                                                filter_data();

                                            }, 250);
                                        } else {
                                            setTimeout(() => {
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Oops!',
                                                    theme: 'material',
                                                    type: 'red',
                                                    content: response.message,
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
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
                    cancel: function() {},
                }
            });
        }
    }

    function update_workshop() {
        workshop_id = $('#e_workshop_id').val()
        participant_actual = $("#e_participant_actual").val();
        commitment = $('#e_commitment').val();
        file = document.getElementById('e_documentation').files;

        if (participant_actual.toString() == '') {
            error_alert("Participant Actual tidak boleh kosong!");
            $('#e_participant_actual').focus();
        } else if (commitment == '') {
            error_alert("Commitment tidak boleh kosong!");
            $('#e_commitment').focus();
        } else if (document.getElementById("e_documentation").files.length == 0) {
            error_alert("Dokumentasi tidak boleh kosong!");
            $('#e_documentation').focus();
        } else {

            form = $('#form_update_workshop');
            $.confirm({
                title: 'Form Workshop',
                content: 'Update Workshop ?',
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
                                    // Dapatkan elemen input file
                                    const fileInput = document.getElementById('e_documentation');

                                    // Dapatkan file yang dipilih langsung dari elemen input file
                                    const file = fileInput.files[0];
                                    new Compressor(file, {
                                        quality: 0.6,

                                        // The compression process is asynchronous,
                                        // which means you have to access the `result` in the `success` hook function.
                                        success(result) {
                                            console.log(result);
                                            const formData = new FormData();
                                            // The third parameter is required for server
                                            formData.append("participant_actual", participant_actual.toString());
                                            formData.append("workshop_id", workshop_id);
                                            formData.append("commitment", commitment);
                                            formData.append('documentation', result, result.name);


                                            $.ajax({
                                                url: `<?= base_url('workshop/update_workshop') ?>`,
                                                type: 'POST',
                                                dataType: 'json',
                                                data: formData,
                                                cache: false,
                                                contentType: false,
                                                processData: false,
                                                beforeSend: function() {

                                                },
                                                success: function(response) {},
                                                error: function(xhr) {},
                                                complete: function() {},
                                            }).done(function(response) {
                                                if (response.update == true) {
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
                                                        $('#modal_update_workshop').modal('hide');
                                                        filter_data();

                                                    }, 250);
                                                } else {
                                                    setTimeout(() => {
                                                        jconfirm.instances[0].close();
                                                        $.confirm({
                                                            icon: 'fa fa-xmark',
                                                            title: 'Oops!',
                                                            theme: 'material',
                                                            type: 'red',
                                                            content: response.message,
                                                            buttons: {
                                                                close: {
                                                                    actions: function() {}
                                                                },
                                                            },
                                                        });
                                                    }, 250);
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
                                        error(err) {
                                            $.confirm({
                                                icon: 'fa fa-check',
                                                title: 'Oops!',
                                                theme: 'material',
                                                type: 'red',
                                                content: err.message,
                                                buttons: {
                                                    close: {
                                                        actions: function() {}
                                                    },
                                                },
                                            });
                                            console.log(err.message);
                                        },
                                    });
                                },

                            });
                        }
                    },
                    cancel: function() {},
                }
            });
        }
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


    function sertifikat(id) {
        var divToPrint = document.getElementById(id);

        var htmlToPrint = `
            <style type="text/css">
                @page {
                    size: landscape;
                    margin: 0mm;  /* this affects the margin in the printer settings */
                }
                *{
                    -webkit-print-color-adjust: exact !important;   /* Chrome, Safari, Edge */
                    color-adjust: exact !important;                 /*Firefox*/
                }
                @media print {
                    html, body {
                        border: 1px solid white;
                        height: 99%;
                        page-break-after: avoid;
                        page-break-before: avoid;
                    }
                }
                .container {
                    position: relative;
                    text-align: center;
                }
            </style>;`
        // var htmlToPrint = '';

        let mywindow = window.open('', 'PRINT');

        htmlToPrint += divToPrint.outerHTML;
        // newWin = window.open("");
        mywindow.document.write(htmlToPrint);
        // setTimeout(function() {
        mywindow.print();
        mywindow.close();
        // }, 2000);
    }


    function resend_notif() {
        workshop_id = $('#e_workshop_id').val();
        $.confirm({
            title: 'Resend Notif!',
            content: 'Are you sure, you want to resend notification ?',
            theme: 'material',
            type: 'blue',
            buttons: {
                close: function() {},
                yes: {
                    theme: 'material',
                    type: 'blue',
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
                                    url: `https://trusmiverse.com/apps/workshop/send_notif_workshop_reminder`,
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        workshop_id: workshop_id,
                                    },
                                    beforeSend: function() {

                                    },
                                    success: function(response) {},
                                    error: function(xhr) {},
                                    complete: function() {},
                                }).done(function(response) {
                                    if (response.status === true) {
                                        setTimeout(() => {
                                            jconfirm.instances[0].close();
                                            console.log(response);
                                            if (response.participant.length > 0) {
                                                for (let index = 0; index < response.participant.length; index++) {
                                                    success_alert('success! mengirim notifikasi ke ' + response.participant[index].participant_name + ' (' + response.participant[index].contact_no + ')')
                                                }
                                            }
                                        }, 250);
                                    } else {
                                        setTimeout(() => {
                                            jconfirm.instances[0].close();
                                            error_alert('failed! mengirim notifikasi ke peserta, sudah melewati batas maksimal pengiriman')
                                        }, 250);
                                    }
                                }).fail(function(jqXHR, textStatus) {
                                    setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        error_alert('failed! mengirim notifikasi ke peserta')
                                    }, 250);
                                });
                            },
                        });
                    }
                },
            }
        });
    }
</script>