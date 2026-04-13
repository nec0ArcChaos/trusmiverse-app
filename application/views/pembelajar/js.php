<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/clockpicker/jquery-clockpicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>




<script>
    $(document).ready(function() {

        $(".mask-date").mask('0000-00-00')

        $('.tanggal').datetimepicker({
            format: 'Y-m-d',
            timepicker: false,
            scrollMonth: false,
            scrollInput: false,
            beforeShowDay: function(date) {
                var day = date.getDay();
                const today = new Date();
                let get_today = today.getDate();
                let get_date = date.getDate();
                return [day == 1 || get_date == get_today, ""];
            }
        });

        youtubeLink = "https://youtu.be/hSqyT8GI6hk?si=tJ-pOeCjNu18z0vy";
        is_real = checkVideoExists(youtubeLink);
        console.info(is_real)

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        $('#request_date').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: "yyyy-mm-dd",
            "setDate": new Date(),
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


        $('#resignation_date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            // uiLibrary: 'bootstrap4'
        });

        $('#point').summernote({
            placeholder: 'Learned points',
            tabsize: 2,
            height: 120,
            toolbar: [
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
            ]
        });

        $('#impact').summernote({
            placeholder: 'Impact for company',
            tabsize: 2,
            height: 120,
            toolbar: [
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
            ]
        });

        filter_data()

    }); // END :: Ready Function


    function filter_data() {
        var start = $('#start').val();
        var end = $('#end').val();

        dt_pembelajar(start, end);
        generate_head_resume_v3()
        // dt_resume_pembelajar(start.substr(0, 7));
    }

    function dt_pembelajar(start, end, status = null) {
        $('#dt_pembelajar').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
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
                "url": "<?= base_url('pembelajar/dt_pembelajar'); ?>",
                "data": {
                    start: start,
                    end: end,
                }
            },
            "columns": [{
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                {
                    "data": "id",
                    "className": "d-none d-md-table-cell"
                },
                {
                    "data": "created_at",
                },
                {
                    "data": "created_by",
                },
                {
                    "data": "company_name",
                },
                {
                    "data": "soft_skill",
                },
                {
                    "data": "title",
                },
                {
                    "data": "author",
                    "className": "d-none"
                },
                {
                    "data": "link",
                    "render": function(data, type, row, meta) {
                        return `<a href="${row['link']}" target="_blank"><span><i class="bi bi-youtube text-red"></i></span> <span class="small">${row['link']}</span></a>`
                    },
                    "className": "d-none"
                },
                {
                    "data": "point",
                    "className": "d-none"
                },
                {
                    "data": "impact",
                    "className": "d-none"
                },
                {
                    "data": "created_at_system",
                },
            ],
        });
    }

    // Add event listener for opening and closing details
    $('#dt_pembelajar tbody').on('click', 'td.dt-control', function() {
        // console.log('test')
        var tr = $(this).closest('tr');
        var row = $('#dt_pembelajar').DataTable().row(tr);

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
        return (
            `<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">
                <tr><td><b>Title</b></td><td>${d.title}</td></tr>
                <tr><td><b>Author</b></td><td>${d.author}</td></tr>
                <tr><td><b>Link</b></td><td>${d.link}</td></tr>
                <tr><td><b>Point</b></td><td>${d.point}</td></tr>
                <tr><td><b>Impact</b></td><td>${d.impact}</td></tr>
                <tr><td><b>Tgl Upload</b></td><td>${d.created_at_system}</td></tr>
        </table>`
        );
    }


    function add_pembelajar() {

        let masa_kerja = "<?= $masa_kerja->masa_kerja ?? 0 ?>";
        console.log(masa_kerja);
        if (parseInt(masa_kerja) < 30) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: `Anda Belum Berhak Mengisi Pembelajar, Masa Join Anda (${masa_kerja}) dibawah 30 hari`,
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else {

            $('#modal_add_pembelajar').modal('show');
            get_soft_skill();
            get_author();

            $('#in_time').val('');
            $('#out_time').val('');
            $('#reason').val('');
            $('#reason').text('');
            $('#time_request_id').remove();
            $('#btn_save').show();
            $('#btn_update').hide();
        }



    }

    let soft_skill_select = NiceSelect.bind(document.getElementById('soft_skill'), {
        searchable: true
    });

    function get_soft_skill() {
        url = "<?= base_url('pembelajar/get_soft_skill') ?>";
        $.getJSON(url, function(result) {
            soft_skill = '<option value="" disabled selected>Choose a soft skill</option>';
            $.each(result, function(index, value) {
                soft_skill += `<option value="${value['id']}" ${ value['id'] == value['sudah'] ? '':''}>${value['soft_skill']}</option>`;
            })

            $("#soft_skill").html(soft_skill)
            soft_skill_select.update();
        });
    }


    function get_author() {
        authors = [
            'Si Kutu Buku',
            'Indrawan Nugroho',
            'Bicara Buku',
            'Agus LeoHalim',
            'Satu Persen',
            'Tom Mclife',
            'Vicario Reinaldo',
            'Merry Riana',
            'Kuliah Kehidupan',
            'Fellxandro Ruby',
            'Success Before 30',
            'Podluck Podcast Collective'
        ]
        opt_author = '<option value="" selected disabled>-Pilih Author-</option>';
        authors.forEach(function(author) {
            opt_author += `<option value="${author}">${author}</option>`
        });
        $("#author").html(opt_author)
    }


    function save_pembelajar() {
        soft_skill = $("#soft_skill :selected").val();
        author = $("#author :selected").val();
        if ($('#title').val() == '') {
            error_alert("Title is required!");
            $('#title').focus();
        } else if (author == '') {
            error_alert("Author is required!");
            $('#author').focus();
        } else if ($('#link').val() == '') {
            error_alert("YouTube Link is required!");
            $('#link').focus();
        } else if (soft_skill == '') {
            error_alert("Choose a soft skill");
            $('#soft_skill').focus();
        } else if ($('#point').val() == '') {
            error_alert("Point is required!");
            $('#point').focus();
        } else if ($('#impact').val() == '') {
            error_alert("Impact is required!");
            $('#impact').focus();
        } else if ($('#created_at').val() == '') {
            error_alert("Tgl Input is required!");
            $('#created_at').focus();
        } else {

            form = $('#form_add_pembelajar');

            $.confirm({
                title: 'Save Form',
                content: 'Pembelajar form will be saved',
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
                                        url: `<?= base_url('pembelajar/save_pembelajar') ?>`,
                                        type: 'POST',
                                        dataType: 'json',
                                        data: form.serialize(),
                                        beforeSend: function() {

                                        },
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
                                                    content: 'Success!',
                                                    buttons: {
                                                        close: function() {},
                                                    },
                                                });
                                                $('#modal_add_pembelajar').modal('hide');
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
                    cancel: function() {
                        // $.alert('you clicked on <strong>cancel</strong>');
                    },
                    // moreButtons: {
                    //     text: 'something else',
                    //     action: function(){
                    //         $.alert('you clicked on <strong>something else</strong>');
                    //     }
                    // },
                }
            });

        }
    }


    function dt_resume_pembelajar(periode) {
        $('#dt_resume_pembelajar').DataTable({
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
                "url": "<?= base_url('pembelajar/dt_resume_pembelajar'); ?>",
                "data": {
                    periode: periode,
                }
            },
            "columns": [{
                    "data": "employee_name",
                },
                {
                    "data": "jabatan",
                },
                {
                    "data": "w1_id",
                    render: function(data, type, row, meta) {
                        if (row['w1_id'] == '1') {
                            return `<span class="bi bi-check-lg text-green"></span> Yes`
                        } else {
                            return `<span class="bi bi-x text-red"></span> No`
                        }
                    }
                },
                {
                    "data": "w2_id",
                    render: function(data, type, row, meta) {
                        if (row['w2_id'] == '1') {
                            return `<span class="bi bi-check-lg text-green"></span> Yes`
                        } else {
                            return `<span class="bi bi-x text-red"></span> No`
                        }
                    }
                },
                {
                    "data": "w3_id",
                    render: function(data, type, row, meta) {
                        if (row['w3_id'] == '1') {
                            return `<span class="bi bi-check-lg text-green"></span> Yes`
                        } else {
                            return `<span class="bi bi-x text-red"></span> No`
                        }
                    }
                },
                {
                    "data": "w4_id",
                    render: function(data, type, row, meta) {
                        if (row['w4_id'] == '1') {
                            return `<span class="bi bi-check-lg text-green"></span> Yes`
                        } else {
                            return `<span class="bi bi-x text-red"></span> No`
                        }
                    }
                },
                {
                    "data": "w5_id",
                    render: function(data, type, row, meta) {
                        if (row['w5_id'] == '1') {
                            return `<span class="bi bi-check-lg text-green"></span> Yes`
                        } else {
                            return `<span class="bi bi-x text-red"></span> No`
                        }
                    }
                },

            ],
        });
    }












    function checkVideoExists(url) {
        // Extract the video ID from the URL
        const videoId = url.match(/^.*(?:youtu\.be\/|v\/|embed\/)([^?&\s]+).*$/)[1];

        // Send a HEAD request to the API endpoint
        // $.ajax({
        //     url: `https://gdata.youtube.com/feeds/api/videos/${videoId}`,
        //     "async": true,
        //     "crossDomain": true,
        //     "method": "GET",
        //         "headers": {
        //             "Accept": "*/*",
        //         },
        //     success: function () {
        //     // Video exists
        //         console.log("Video exists!");
        //         return true;
        //     },
        //     error: function (jqXHR, textStatus, errorThrown) {
        //     // Video doesn't exist or there's an error
        //         if (jqXHR.status === 404) {
        //             console.log("Video doesn't exist!");
        //         } else {
        //             console.error("Error checking video:", errorThrown);
        //         }
        //         return false;
        //     },
        // });
        return videoId
    }

    function save_request() {
        form = $('#form_add_request');
        $.ajax({
            url: '<?= base_url('pembelajar/save_request') ?>',
            type: 'POST',
            dataType: 'json',
            data: form.serialize(),
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
            url: "<?= base_url('pembelajar/dt_pembelajar') ?>",
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
            url: '<?= base_url('pembelajar/update_request') ?>',
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
            url: "<?= base_url('pembelajar/delete_request') ?>",
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

    function dt_pembelajar_list(status) {

        start = $('#start_list').val();
        end = $('#end_list').val();

        $('#dt_pembelajar_list').DataTable({
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
                "url": "<?= base_url(); ?>pembelajar/dt_pembelajar",
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

                                                <i class="text-secondary bi bi-clock"></i> ${row['in_time']} - ${row['out_time']}<br>
                                                <i class="text-secondary bi bi-hourglass-split"></i> ${row['total_hours']} <br><br>
                                                <i class="text-secondary bi bi-clipboard"></i> ${row['reason']}

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

    function approve_request(status, time_request_id, employee_name) {

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
                            url: "<?= base_url("pembelajar/approve_request") ?>",
                            type: "POST",
                            dataType: "json",
                            data: {
                                time_request_id: time_request_id,
                                status: status,
                            },
                            success: function(response) {
                                dt_pembelajar_list(1)
                                filter_date();
                            }
                        })
                    }
                },
                close: function() {}
            }
        });
    }

    // generate_head_resume();

    function generate_head_resume() {
        // let start = $('#start').val();
        // let end = $('#end').val();
        $.ajax({
            url: '<?= base_url() ?>pembelajar/generate_head_resume',
            type: 'POST',
            dataType: 'json',
            // data: {
            //     start: start,
            //     end: end
            // },
            beforeSend: function() {

            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            // console.log(response)
            thead = '';
            thead = `<tr>
                        <th>Nama</th>
                        <th>Jabatan</th>`;
            for (let index = 0; index < response.data.length; index++) {
                const element = response.data[index];
                thead += `<th class="small text-center">${response.data[index].week_number} <br><span class="small">${response.data[index].week_start_date}</span> s/d <span class="small">${response.data[index].week_end_date}</span></th>`;
            }
            thead += `</tr>`;

            tbody = '';
            for (let index = 0; index < response.body_resume.length; index++) {
                // console.log(response.data.length);
                tbody_td = '';
                if (response.data.length == 6) {
                    tbody_td = `<td>${response.body_resume[index].w1 == 0 ? '<span class="bi bi-x text-red"></span> No' : '<span class="bi bi-check-lg text-green"></span> Yes'}</td>
                            <td>${response.body_resume[index].w2 == 0 ? '<span class="bi bi-x text-red"></span> No' : '<span class="bi bi-check-lg text-green"></span> Yes'}</td>
                            <td>${response.body_resume[index].w3 == 0 ? '<span class="bi bi-x text-red"></span> No' : '<span class="bi bi-check-lg text-green"></span> Yes'}</td>
                            <td>${response.body_resume[index].w4 == 0 ? '<span class="bi bi-x text-red"></span> No' : '<span class="bi bi-check-lg text-green"></span> Yes'}</td>
                            <td>${response.body_resume[index].w5 == 0 ? '<span class="bi bi-x text-red"></span> No' : '<span class="bi bi-check-lg text-green"></span> Yes'}</td>
                            <td>${response.body_resume[index].w6 == 0 ? '<span class="bi bi-x text-red"></span> No' : '<span class="bi bi-check-lg text-green"></span> Yes'}</td>
                            `
                } else if (response.data.length == 5) {
                    tbody_td = `<td>${response.body_resume[index].w1 == 0 ? '<span class="bi bi-x text-red"></span> No' : '<span class="bi bi-check-lg text-green"></span> Yes'}</td>
                            <td>${response.body_resume[index].w2 == 0 ? '<span class="bi bi-x text-red"></span> No' : '<span class="bi bi-check-lg text-green"></span> Yes'}</td>
                            <td>${response.body_resume[index].w3 == 0 ? '<span class="bi bi-x text-red"></span> No' : '<span class="bi bi-check-lg text-green"></span> Yes'}</td>
                            <td>${response.body_resume[index].w4 == 0 ? '<span class="bi bi-x text-red"></span> No' : '<span class="bi bi-check-lg text-green"></span> Yes'}</td>
                            <td>${response.body_resume[index].w5 == 0 ? '<span class="bi bi-x text-red"></span> No' : '<span class="bi bi-check-lg text-green"></span> Yes'}</td>
                            `
                } else if (response.data.length == 4) {
                    tbody_td = `<td>${response.body_resume[index].w1 == 0 ? '<span class="bi bi-x text-red"></span> No' : '<span class="bi bi-check-lg text-green"></span> Yes'}</td>
                            <td>${response.body_resume[index].w2 == 0 ? '<span class="bi bi-x text-red"></span> No' : '<span class="bi bi-check-lg text-green"></span> Yes'}</td>
                            <td>${response.body_resume[index].w3 == 0 ? '<span class="bi bi-x text-red"></span> No' : '<span class="bi bi-check-lg text-green"></span> Yes'}</td>
                            <td>${response.body_resume[index].w4 == 0 ? '<span class="bi bi-x text-red"></span> No' : '<span class="bi bi-check-lg text-green"></span> Yes'}</td>
                            <td>${response.body_resume[index].w5 == 0 ? '<span class="bi bi-x text-red"></span> No' : '<span class="bi bi-check-lg text-green"></span> Yes'}</td>
                            `
                }
                tbody += `<tr>
                            <td>${response.body_resume[index].employee_name}</td>
                            <td>${response.body_resume[index].jabatan}</td>
                            ${tbody_td}
                        </tr>`
            }

            $('#dt_resume_pembelajar_2').empty().append(
                `<thead id="dt_resume_head"></thead>
                <tbody id="dt_resume_body"></tbody>`
            );
            $('#dt_resume_head').empty().append(thead);
            // $('#dt_resume_body').empty().append(tbody);
            setTimeout(() => {
                $('#dt_resume_pembelajar_2').DataTable({
                    "searching": true,
                    "info": true,
                    "paging": true,
                    "destroy": true,
                    "autoWidth": false,
                    "dom": 'Bfrtip',
                    buttons: [{
                        extend: 'excelHtml5',
                        text: 'Export to Excel',
                        footer: true
                    }],
                });
            }, 1000);
        }).fail(function(jqXhr, textStatus) {

        });
    }

    generate_head_resume_v3()

    function generate_head_resume_v3() {
        // let start = $('#start').val();
        // let end = $('#end').val();
        $.ajax({
            url: '<?= base_url() ?>pembelajar/generate_head_resume_v3',
            type: 'POST',
            dataType: 'json',
            // data: {
            //     start: start,
            //     end: end
            // },
            beforeSend: function() {

            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            // console.log(response)
            thead = '';
            thead = `<tr>
                        <th>Nama</th>
                        <th>Company</th>
                        <th>Jabatan</th>
                        `;
            for (let index = 0; index < response.data.length; index++) {
                const element = response.data[index];
                thead += `<th class="small text-center">${response.data[index].week_number} <br><span class="small">${response.data[index].f_tgl_awal}</span> s/d <span class="small">${response.data[index].f_tgl_akhir}</span></th>`;
            }
            thead += `</tr>`;

            tbody = '';
            for (let index = 0; index < response.body_resume.length; index++) {
                // console.log(response.data.length);
                tbody_td = '';
                if (response.data.length == 6) {
                    tbody_td = `<td>${response.body_resume[index].w1 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                            <td>${(response.body_resume[index].w2 > 0) ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                            <td>${response.body_resume[index].w3 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                            <td>${response.body_resume[index].w4 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                            <td>${response.body_resume[index].w5 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                            <td>${response.body_resume[index].w6 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                            `
                } else if (response.data.length == 5) {
                    tbody_td = `<td>${response.body_resume[index].w1 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                            <td>${(response.body_resume[index].w2 > 0) ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                            <td>${response.body_resume[index].w3 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                            <td>${response.body_resume[index].w4 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                            <td>${response.body_resume[index].w5 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                            `
                } else if (response.data.length == 4) {
                    tbody_td = `<td>${response.body_resume[index].w1 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                            <td>${(response.body_resume[index].w2 > 0) ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                            <td>${response.body_resume[index].w3 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                            <td>${response.body_resume[index].w4 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                            <td>${response.body_resume[index].w5 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                            `
                }
                tbody += `<tr>
                            <td>${response.body_resume[index].employee_name}</td>
                            <td>${response.body_resume[index].company_name}</td>
                            <td>${response.body_resume[index].jabatan}</td>
                            ${tbody_td}
                        </tr>`
            }

            $('#dt_resume_pembelajar_3').empty().append(
                `<thead id="dt_resume_head_3"></thead>
                <tbody id="dt_resume_body_3"></tbody>`
            );
            $('#dt_resume_head_3').empty().append(thead);
            $('#dt_resume_body_3').empty().append(tbody);
            setTimeout(() => {
                $('#dt_resume_pembelajar_3').DataTable({
                    "searching": true,
                    "info": true,
                    "paging": true,
                    "destroy": true,
                    "autoWidth": false,
                    "dom": 'Bfrtip',
                    buttons: [{
                        extend: 'excelHtml5',
                        text: 'Export to Excel',
                        footer: true
                    }],
                });
            }, 1000);
        }).fail(function(jqXhr, textStatus) {

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