<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/fancybox/jquery.fancybox.min.js"></script> -->


<script>
    $(document).ready(function() {

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
            list_proses();
            list_done();
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
        list_proses();
        list_done();
    });

    function list_proses() {
        $.ajax({
            url: '<?= base_url('rsp_tasklist_helper_project_afs/data_proses') ?>',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {
                console.log(response);
                item_tasklist = '';
                no_urut = 1;
                if (response.data.length > 0) {
                    for (let index = 0; index < response.data.length; index++) {
                        bg_status = "bg-success"
                        if (response.data[index].id_status == 1) {
                            bg_status = "bg-warning";
                            bg_icon = "bg-light-yellow";
                        }
                        if (response.data[index].id_status == 2) {
                            bg_status = "bg-primary";
                            bg_icon = "bg-light-blue";
                        }
                        print_afs_pengajuan = '';
                        if (response.data[index].id_after_sales != null && response.data[index].id_after_sales != 'null' && response.data[index].id_after_sales != '') {
                            print_afs_pengajuan = `<a id="print_pengajuan" target="_blank" href="https://trusmicorp.com/rspproject/after_sales/print_pengajuan?id_afs=${response.data[index].id_after_sales}" class="badge badge-sm bg-primary"><i class="bi-printer"></i></a>`;
                        }
                        item_pekerjaan = '';
                        if (response.data[index].item != null && response.data[index].item != 'null' && response.data[index].item != '') {
                            item_pekerjaan = `(${response.data[index].item})`;
                        }
                        item_tasklist += `
                    <div class="card mb-1 mt-1">
                        <div class="card-body ">
                            <div class="row align-items-center">
                                <div class="col-auto d-none d-md-block">
                                    <div class="circle-small">
                                        <div id="circleprogressblue"></div>
                                        <div class="avatar h5 ${bg_icon} rounded-circle">
                                            <i class="bi bi-hourglass-split"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <p class="text-dark small mb-1 col-12 col-md-4">Tgl Pekerjaan: <span style="font-weight: bold;">${response.data[index].tanggal_pengerjaan}</span></p>
                                        <p class="text-dark small mb-1 col-12 col-md-4">No. Tasklist : <span style="font-weight: bold;">${response.data[index].no_ph}</span> ${print_afs_pengajuan} </p>
                                        <p class="text-dark small mb-1 col-12 col-md-4">Status : <span class="badge badge-sm ${bg_status}">${response.data[index].status}</span> </p>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-4">
                                            <p class="text-secondary small mb-1">Project :</p>
                                            <h5 class="fw-medium small">${response.data[index].project}<small> </small></h5>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-4">
                                            <p class="text-secondary small mb-1">Pekerjaan :</p>
                                            <h5 class="fw-medium small">${response.data[index].pekerjaan}<small> ${item_pekerjaan}</small></h5>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-4">
                                            <p class="text-secondary small mb-1">Detail Pekerjaan :</p>
                                            <h5 class="fw-medium small">${response.data[index].detail_pekerjaan}<small></small></h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                                            <p class="text-secondary small mb-1">Helper :</p>
                                            <h5 class="fw-medium small">${response.data[index].helper}<small> </small></h5>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                                            <p class="text-secondary small mb-1">Upload Progress :</p>
                                            <a role="button" class="btn btn-theme" onclick="proses('${response.data[index].no_ph}','${response.data[index].id_status}')"><i class="bi bi-upload" style="font-size:14pt;"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                    }
                } else {
                    item_tasklist = `
                    <div class="card mb-1 mt-1">
                        <div class="card-body ">
                            <div class="row align-items-center">
                                <div class="col-12 text-center">
                                    <p>No data available</p>
                                </div>
                            </div>
                        </div>
                    </div>`;
                }
                $("#my_tasklist").empty().append(item_tasklist);
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }


    function list_done() {
        start = $("#start").val();
        end = $("#end").val();

        var table = $('#dt_tasklist_done').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
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
                "url": "<?= base_url(); ?>rsp_tasklist_helper_project_afs/data_tasklist",
                "data": {
                    start: start,
                    end: end,
                }
            },
            "columns": [{
                    "data": "no_ph",
                },
                {
                    "data": "project",
                },
                {
                    "data": "pekerjaan",
                },
                {
                    "data": "detail_pekerjaan",
                },
                {
                    "data": "item",
                },
                {
                    "data": "tanggal_pengerjaan",
                },
                {
                    "data": "helper",
                },
                {
                    "data": "equipment",
                },
                {
                    "data": "foto_start",
                    "render": function(data, type, row) {
                        if (data != '' && data != null && data != 'null') {
                            return `<a href="https://trusmicorp.com/rspproject/assets/uploads/helper_project_afs/${data}" class="btn btn-sm btn-outline-success bi bi-image" data-fancybox></a>`
                        } else {
                            return ''
                        }
                    }
                },
                {
                    "data": "note_start",
                },
                {
                    "data": "foto_end",
                    "render": function(data, type, row) {
                        if (data != '' && data != null && data != 'null') {
                            return `<a href="https://trusmicorp.com/rspproject/assets/uploads/helper_project_afs/${data}" class="btn btn-sm btn-outline-success bi bi-image" data-fancybox></a>`
                        } else {
                            return ''
                        }
                    }
                },
                {
                    "data": "note_end",
                },
            ],
        });



        $.ajax({
            url: '<?= base_url('rsp_tasklist_helper_project_afs/data_tasklist') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                start: start,
                end: end,
            },
            beforeSend: function() {

            },
            success: function(response) {
                console.log(response);
                item_tasklist = '';
                no_urut = 1;
                if (response.data.length > 0) {
                    for (let index = 0; index < response.data.length; index++) {
                        bg_status = "bg-success";
                        bg_icon = "bg-light-green";
                        foto_start = '-';
                        foto_end = '-';
                        if (response.data[index].id_status == 1) {
                            bg_status = "bg-warning";
                            bg_icon = "bg-light-yellow";
                        }
                        if (response.data[index].id_status == 2) {
                            bg_status = "bg-primary";
                            bg_icon = "bg-light-blue";
                        }
                        if (response.data[index].foto_start != '' && response.data[index].foto_start != null) {
                            foto_start = `  <a href="https://trusmicorp.com/rspproject/assets/uploads/helper_project_afs/${response.data[index].foto_start}" id="foto_start" class="btn btn-sm btn-outline-success bi bi-image" data-fancybox></a>`;
                        }
                        if (response.data[index].foto_end != '' && response.data[index].foto_end != null) {
                            foto_end = `<a href="https://trusmicorp.com/rspproject/assets/uploads/helper_project_afs/${response.data[index].foto_end}" id="foto_end" class="btn btn-sm btn-outline-success bi bi-image" data-fancybox></a>`;
                        }
                        item_tasklist += `
                    <div class="card mb-1 mt-1">
                        <div class="card-body ">
                            <div class="row align-items-center">
                                <div class="col-auto d-none d-md-block">
                                    <div class="circle-small">
                                        <div id="circleprogressblue"></div>
                                        <div class="avatar h5 ${bg_icon} rounded-circle">
                                            <i class="bi bi-calendar-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <p class="text-dark small mb-1 col-12 col-md-4">Tgl Pekerjaan: <span style="font-weight: bold;">${response.data[index].tanggal_pengerjaan}</span></p>
                                        <p class="text-dark small mb-1 col-12 col-md-4">No. Tasklist : <span style="font-weight: bold;">${response.data[index].no_ph}</span> </p>
                                        <p class="text-dark small mb-1 col-12 col-md-4">Status : <span class="badge badge-sm ${bg_status}">${response.data[index].status}</span> </p>
                                    </div>
                                    <div class="row">
                                        <div class="mb-2 col-6 col-sm-6 col-md-6 col-lg-4">
                                            <p class="text-secondary small mb-1">Project :</p>
                                            <h5 class="fw-medium small">${response.data[index].project}<small> </small></h5>
                                        </div>
                                        <div class="mb-2 col-6 col-sm-6 col-md-6 col-lg-4">
                                            <p class="text-secondary small mb-1">Pekerjaan :</p>
                                            <h5 class="fw-medium small">${response.data[index].pekerjaan}<small> (${response.data[index].item})</small></h5>
                                        </div>
                                        <div class="mb-2 col-6 col-sm-6 col-md-6 col-lg-4">
                                            <p class="text-secondary small mb-1">Detail Pekerjaan :</p>
                                            <h5 class="fw-medium small">${response.data[index].detail_pekerjaan}<small></small></h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-2 col-12 col-sm-12 col-md-6 col-lg-4">
                                            <p class="text-secondary small mb-1">Helper :</p>
                                            <h5 class="fw-medium small">${response.data[index].helper}<small> </small></h5>
                                        </div>
                                        <div class="mb-2 col-12 col-sm-12 col-md-6 col-lg-4">
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="text-secondary small mb-1">Foto Start :</p>
                                                    ${foto_start}
                                                </div>
                                                <div class="col-6">
                                                    <p class="text-secondary small mb-1">Foto End :</p>
                                                    ${foto_end}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-2 col-12 col-sm-12 col-md-6 col-lg-4">
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="text-secondary small mb-1">Note Start :</p>
                                                    ${response.data[index].note_start ?? '-'}
                                                </div>
                                                <div class="col-6">
                                                    <p class="text-secondary small mb-1">Note End :</p>
                                                    ${response.data[index].note_end ?? '-'}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                    }
                } else {

                    item_tasklist = `
                    <div class="card mb-1 mt-1">
                        <div class="card-body ">
                            <div class="row align-items-center">
                                <div class="col-12 text-center">
                                    <p>No data available</p>
                                </div>
                            </div>
                        </div>
                    </div>`;
                }
                $("#my_tasklist_done").empty().append(item_tasklist);
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    $("#update_tasklist").click(function() {
        if ($("#foto_proses").val() == "") {
            $("#image_proses").addClass("is-invalid");
        } else if ($("#note_proses").val() == "") {
            $("#note_proses").addClass("is-invalid").focus();
        } else {
            $.ajax({
                url: "<?= base_url('rsp_tasklist_helper_project_afs/update_tasklist'); ?>",
                method: "POST",
                dataType: "JSON",
                data: $("#form_tasklist").serialize(),
                beforeSend: function(res) {
                    $("#update_tasklist").prop("disabled", true);
                },
                success: function(res) {
                    dt = res.send;
                    $("#modal_tasklist").modal("hide");
                    if (res.update == true) {
                        success_alert("Data has been saved !!");
                    } else {
                        error_alert("Oops, failed something wrong..")
                    }
                    $("#form_tasklist")[0].reset();
                    list_proses();
                    list_done();
                    $("#update_tasklist").prop("disabled", false);
                    $(".fa_done_proses").hide();
                    $("#foto_proses").val("");
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    });

    function proses(no_ph, id_status) {
        $("#no_ph_proses").val(no_ph);
        $.ajax({
            url: "<?= base_url('rsp_tasklist_helper_project_afs/data_proses_detail/') ?>" + no_ph,
            method: "GET",
            dataType: "JSON",
            success: function(res) {
                console.log(res);
                $("#project_proses").val(res.project);
                $("#pekerjaan_proses").val(res.pekerjaan);
                $("#detail_proses").val(res.detail_pekerjaan);
                $("#equipment_proses").val(res.equipment);
                $("#tanggal_proses").val(res.tanggal_pengerjaan);
                $("#foto_start_hidden").hide();
                if (id_status == "2") {
                    $("#foto_start_hidden").show();
                    $("#foto_start_proses").attr("href", `https://trusmicorp.com/rspproject/assets/uploads/helper_project_afs/${res.foto_start}`);
                }
                $("#helper_proses").val(res.helper);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
        $("#modal_tasklist").modal("show");
        $(".input").hide();
        $(".proses").show();
        $("#status").val(id_status);
        $("#save_tasklist").hide();
        $("#update_tasklist").show();
    }


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


    function compress(file_upload, string, submit, wait, done) {

        $(wait).show();
        $(done).hide();
        $(submit).prop('disabled', true);

        const file = document.querySelector(file_upload).files[0];

        extension = file.name.substr((file.name.lastIndexOf('.') + 1));

        if (!file) return;

        const reader = new FileReader();

        reader.readAsDataURL(file);

        reader.onload = function(event) {
            const imgElement = document.createElement("img");
            imgElement.src = event.target.result;

            if (extension == "jpg" || extension == "jpeg" || extension == "png" || extension == "gif") {

                extension = 'png,';

                imgElement.onload = function(e) {
                    const canvas = document.createElement("canvas");

                    if (e.target.width > e.target.height) {
                        const MAX_WIDTH = 600;
                        const scaleSize = MAX_WIDTH / e.target.width;
                        canvas.width = MAX_WIDTH;
                        canvas.height = e.target.height * scaleSize;
                    } else {
                        const MAX_HEIGHT = 600;
                        const scaleSize = MAX_HEIGHT / e.target.height;
                        canvas.height = MAX_HEIGHT;
                        canvas.width = e.target.width * scaleSize;
                    }

                    const ctx = canvas.getContext("2d");

                    ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);

                    const srcEncoded = ctx.canvas.toDataURL(e.target, "image/jpeg");

                    var g_string = extension + srcEncoded.substr(srcEncoded.indexOf(',') + 1);
                    upload_foto(string, g_string, submit, wait, done);
                }
            } else {
                var g_string = extension + ',' + event.target.result.substr(event.target.result.indexOf(',') + 1);
                upload_foto(string, g_string, submit, wait, done);
            }

        }
    }

    function upload_foto(string, file, submit, wait, done) {
        $.ajax({
                url: 'https://trusmicorp.com/rspproject/trusmiverse_tasklist_helper_project_afs/file_upload',
                type: 'POST',
                dataType: 'json',
                data: {
                    file: file
                },
            })
            .done(function(response) {
                console.log("success");
                $(string).val(response.file);
                $(wait).hide();
                $(done).show();
                $(submit).prop('disabled', false);
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });

    }
</script>