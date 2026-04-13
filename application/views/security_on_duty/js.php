<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/clockpicker/jquery-clockpicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js" type="text/javascript"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->


<script>
    $(document).ready(function () {
        console.log('document js ready..');

        /*Range*/
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
            // list_pph21(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            dt_resume_tasklist(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            dt_list_detail_task(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));

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


        // SECURITY ON DUTY
        slim_project = new SlimSelect({
            select: "#project",
            settings: {
                // placeholderText: 'Pilih Project ?',
                allowDeselect: true
            }
        });

        slim_shift = new SlimSelect({
            select: "#shift",
            settings: {
                allowDeselect: true
            }
        });

        // slim_status = new SlimSelect({
        //     select: "#status",
        //     settings: {
        //         // allowDeselect: true
        //     }
        // });

        $('#project').on('change', function () {
            // console.log($(this).val());

            id_project = $(this).val();
            get_data_shift(id_project);
        });

        $('#shift').change(function () {
            // console.log('Shift: ', $(this).val());
            // $('#site').val($(this));
        });

        $('#dt_resume_tasklist').on('click', '.open-detail-modal', function () {
            $('#modalDetailTask').modal('show');
        })

    }); // END :: Ready Function


    // SECURITY ON DUTY

    function get_data_shift($id_project) {
        $.ajax({
            url: '<?= base_url('security_on_duty/data_shift') ?>',
            type: 'POST',
            dataType: 'json',
            // data: form.serialize(),
            data: {
                id_project: id_project
            },
            beforeSend: function () {
                // $('#btn_save_confirm').attr('disabled', true);
                // $("#btn_save_confirm").html("Please wait...");
            },
            success: function (response) {
                // console.log('data shift: ', response.data);

                html_opt = `<option value="#">-- Pilih Shift --</option>`;
                response.data.forEach((item, index) => {
                    html_opt = html_opt + `<option value="${item.id_shift}">${item.shift}</option>`;
                    // console.log(item, index);
                });

                $('#shift').empty().append(html_opt);

                if (slim_shift) {
                    slim_shift.destroy();
                }

                slim_shift = new SlimSelect({
                    select: "#shift",
                    settings: {
                        allowDeselect: true
                    }
                });

                // $("#modalAddConfirm").modal("hide");
                // $("#modal_add_request").modal("hide");
                // filter_date();
            },
            error: function (xhr) { // if error occured
                error_alert('Failed, Error Occured');
            },
            complete: function () {
                // $('#btn_save_confirm').attr('disabled', false);
                // $("#btn_save_confirm").html("Yes, Save");
            },
        });
    }

    // function cek_task() {
    //     id_project = $('#project').val();
    //     id_shift = $('#shift').val();
    //     console.log(id_project, id_shift);

    //     if (id_project == '#') {
    //         error_alert('Pilih project dulu');
    //     } else if (id_shift == '#') {
    //         error_alert('Pilih shift dulu');
    //     } else {
    //         $.ajax({
    //             url: '<?= base_url('security_on_duty/cek_task') ?>',
    //             type: 'POST',
    //             dataType: 'json',
    //             data: {
    //                 id_project: id_project,
    //                 id_shift: id_shift
    //             },
    //             beforeSend: function() {

    //             },
    //             success: function(response) {
    //                 console.log(response);

    //             },
    //             error: function(xhr) { // if error occured
    //                 error_alert('Failed, Error Occured');
    //             },
    //             complete: function() {

    //             },
    //         });
    //     }
    // }

    // Cek task dan insert ke sc_t_task
    function cek_insert_task() {

        id_project = $('#project').val();
        id_shift = $('#shift').val();
        // console.log(id_project, id_shift);

        if (id_project == '#') {
            error_alert('Pilih project dulu');
        } else if (id_shift == '#') {
            error_alert('Pilih shift dulu');
        } else {
            $.ajax({
                url: '<?= base_url('security_on_duty/cek_insert_task') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    id_project: id_project,
                    id_shift: id_shift
                },
                beforeSend: function () {

                },
                success: function (response) {
                    console.log(response);
                    success_alert('Berhasil cek dan insert site');
                    id_task = response.id_task;

                    location.href = '<?= site_url('security_on_duty/list_task?id_task=') ?>' + id_task;
                },
                error: function (xhr) { // if error occured
                    error_alert('Failed, Error Occured');
                },
                complete: function () {

                },
            });
        }
    }


    // DETAIL TASK
    function cek_detail_task(id_task_item) {
        console.log(id_task_item);

        $.ajax({
            url: '<?= base_url('security_on_duty/detail_task_item') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id_task_item: id_task_item
            },
            success: function (res) {
                console.log('detail task : ', res);
                $('#id_task_item').val(res.data.id);
                $('#id_task').val(res.data.id_task);
                $('#det_time_start').text(res.data.timestart);
                $('#det_time_end').text(res.data.timeend);
                $('#det_tasklist').text(res.data.tasklist);

                // txt_status = '';
                // if (res.data.status == 0) {
                //     txt_status = '<span class="badge bg-warning">Belum</span>';
                // } else {
                //     txt_status = '<span class="badge bg-green">Sudah</span>';
                // }
                // $('#det_status').html(txt_status);

                // $('#status').val(res.data.status);
                $('#status').val(1);
                $('#note').text(res.data.note);

                $('#is_photo').val(res.data.is_photo);
                $('#old_photo').val(res.data.photo);
                if (res.data.is_photo == 1) {
                    $('.div-photo').removeClass('d-none');
                } else {
                    $('.div-photo').addClass('d-none');
                }

                if (res.data.photo == null || res.data.photo == '') {
                    $('#preview_photo').attr('src', 'https://trusmiverse.com/files/security/no-image.png');
                    $('#preview_photo').attr('width', '100px');
                } else {
                    $('#preview_photo').attr('src', 'https://trusmiverse.com/files/security/' + res.data.photo);
                    $('#preview_photo').attr('width', '300px');
                }

                $('#modal_detail_task').modal('show');
            },
        });
    }

   function cek_detail_taskk(id_task_item) {
    $.ajax({
        url: '<?= base_url('security_on_duty/detail_task_item') ?>',
        type: 'POST',
        dataType: 'json',
        data: { id_task_item },
        success: function (res) {

            $('#id_task_item').val(res.data.id);
            $('#id_task').val(res.data.id_task);
            $('#det_time_start').text(res.data.timestart);
            $('#det_time_end').text(res.data.timeend);
            $('#det_tasklist').text(res.data.tasklist);
            $('#status').val(1);
            $('#note').text(res.data.note);

            if (res.data.is_photo == 1) {
                $('.div-photo').removeClass('d-none');
            } else {
                $('.div-photo').addClass('d-none');
            }

            $('#preview_photo').attr(
                'src',
                res.data.photo
                    ? 'https://trusmiverse.com/files/security/' + res.data.photo
                    : 'https://trusmiverse.com/files/security/no-image.png'
            );

            const modalEl = document.getElementById('modal_detail_taskk');

            // 🔥 PENTING: backdrop FALSE
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl, {
                backdrop: false,
                keyboard: false
            });

            modal.show();
        }
    });
}





    function update_task_item() {
        // console.log($('#form_detail_task').serialize());
        var id_task_item = $('#id_task_item').val();
        var id_task = $('#id_task').val();
        var status = $('#status').val();
        var note = $('#note').val();
        var is_photo = $('#is_photo').val();
        var old_photo = $('#old_photo').val();
        var photo = $('#photo').prop("files")[0];
        console.log('photo: ', photo);
        // return;
        let form_file = new FormData();
        form_file.append("id_task_item", id_task_item);
        form_file.append("id_task", id_task);
        form_file.append("status", status);
        form_file.append("note", note);
        form_file.append("photo", photo);
        console.log(form_file);

        // if (is_photo == 1 && old_photo == '' && photo == undefined) {
        //     error_alert('Foto wajib di isi');
        // } 
        
        // updev
        var photo_input = $('#photo_input').val();

        if (photo_input == '') {
            error_alert('Foto input wajib di isi');

        } else {

            form_file.append("photo_input", photo_input);

            if (old_photo != '' && photo == undefined) {
                form_file.append("old_photo", old_photo);
            }

            $.ajax({
                url: '<?= base_url('security_on_duty/update_task_item_new') ?>',
                type: 'POST',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_file,
                // data: {
                //     id_task_item: id_task_item,
                //     id_task: id_task,
                //     status: status,
                //     note: note,
                //     photo: photo
                // },
                success: function(response) {
                    console.log(response);
                    success_alert('Berhasil update task item');
                    location.reload();
                },
                error: function(xhr) { // if error occured
                    console.log(xhr);

                    error_alert('Failed, Error Occured');
                },
            });
        }
    }


    // updev
    function input_file(id) {
        console.info(id)
        compress_foto_progres(id);
        // preview_foto(id);
    }

    function compress_foto_progres(id, title) {

        // $('#modal_compress').modal({
        //     backdrop: 'static',
        //     keyboard: false
        // });

        // $('.btn_save').prop('disabled', true);

        // $('.upload_foto').prop('disabled', true);

        const file = document.querySelector(id).files[0];

        extension = file.name.substr((file.name.lastIndexOf('.') + 1));

        if (!file) return;

        const reader = new FileReader();

        reader.readAsDataURL(file);

        reader.onload = function (event) {
            const imgElement = document.createElement("img");
            imgElement.src = event.target.result;

            extension = 'png,';

            imgElement.onload = function (e) {
                const canvas = document.createElement("canvas");
                if (e.target.width > e.target.height) {
                    const MAX_HEIGHT = 400;
                    const scaleSize = MAX_HEIGHT / e.target.height;
                    canvas.height = MAX_HEIGHT;
                    canvas.width = e.target.width * scaleSize;
                } else {
                    const MAX_HEIGHT = 400;
                    const scaleSize = MAX_HEIGHT / e.target.height;
                    canvas.height = MAX_HEIGHT;
                    canvas.width = e.target.width * scaleSize;
                }

                const ctx = canvas.getContext("2d");

                ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);

                const srcEncoded = ctx.canvas.toDataURL(e.target, "image/jpeg");

                var g_string = extension + srcEncoded.substr(srcEncoded.indexOf(',') + 1);

                // console.log(id, g_string, title);
                upload_foto_progres(id, g_string, title);
            }
        }
    }

    function upload_foto_progres(id, g_string, title) {
        id_input = id + '_input';
        var formdata = new FormData();
        formdata.append('file', g_string);

        // console.log(id)

        url = "<?= base_url() . 'security_on_duty/upload_foto_task' ?>";

        var ajax = new XMLHttpRequest();
        // ajax.upload.addEventListener("progress", progressUpload, false);
        ajax.open("POST", url, true);
        ajax.send(formdata);
        ajax.onload = function (response) {
            $('#spinner').modal('hide');
            // console.log(ajax.responseText);
            console.log('DONE: ', ajax.status);
            console.log(ajax.responseText.replace(/\s/g, ""));
            if (ajax.status == 200) {
                setTimeout(() => {
                    if (ajax.responseText.replace(/\s/g, "").length > 17 || ajax.responseText.replace(/\s/g, "").length < 17) {
                        console.log('Error! gagal, harap pilih ulang foto.');
                        // $('.upload_foto').prop('disabled', false);
                        // $('.btn_save').prop('disabled', false);
                        // $('#modal_compress').modal('hide');
                    } else {
                        $(id_input).val(ajax.responseText.replace(/\s/g, ""));
                        // $('#modal_compress').modal('hide');
                        // $('.upload_foto').prop('disabled', false);
                        // $('.btn_save').prop('disabled', false);
                        // validate_input();
                    }
                }, 1000);
                // $(submit).prop('disabled', false);
            }
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

    // addnew resume tasklist
    function dt_resume_tasklist(start, end) {
        console.log(start, end);

        $('#dt_resume_tasklist').DataTable({
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
                "url": "<?= base_url('security_on_duty/dt_resume_tasklist') ?>",
                "data": {
                    start: start,
                    end: end
                }
            },
            "columns": [{
                "data": "id_task",
                "render": function (data) {
                    return `
            <span 
                class="badge bg-primary open-detail-modal" 
                data-id="${data}"
                style="cursor:pointer;">
                ${data}
            </span>
        `;
                }
            },
            {
                "data": "project",
            },
            {
                "data": "shift",
            },
            {
                "data": "achievement",
                "className": "text-center"
            },
            {
                "data": "average_rating",
            },
            {
                "data": "created_at",
            },
            {
                "data": "created_by",
                // render: function(data, type, row, meta) {

                //     var user_id = 1;
                //     if (row['is_approved'] == '1') {
                //         return `<span class="badge badge-sm bg-warning">${data}</span>`
                //     } else if (row['is_approved'] == '2') {
                //         if (user_id == 1 || user_id == 778 || user_id == 979) {
                //             return `<span href="">
                //                     <button type="button" class="badge badge-sm bg-success" 
                //                         data-bs-toggle="modal" 
                //                         data-bs-target="#modal_edit_request" 
                //                         onclick="edit_request_new('${row['time_request_id']}')" >
                //                         ${data}
                //                     </button>
                //                 </span>`;
                //         } else {
                //             return `<span class="badge badge-sm bg-success">${data}</span>`
                //         }
                //     } else if (row['is_approved'] == '3') {
                //         return `<span class="badge badge-sm bg-danger">${data}</span>`
                //     } else {
                //         return data
                //     }
                // }
            },
            ],
        });
    }

    // addnew
    function dt_list_detail_task(start, end) {
        $('#dt_list_detail_task').DataTable({
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
                "url": "<?= base_url('security_on_duty/dt_list_detail_task') ?>",
                "data": {
                    start: start,
                    end: end
                }
            },
            "columns": [{
                "data": "id_task",
            },
            {
                "data": "project",
            },
            {
                "data": "shift",
            },
            {
                "data": "tasklist",
                // "className": "text-center"
            },
            {
                "data": "time_start",
            },
            {
                "data": "time_end",
            },
            {
                "data": "time_actual",
            },
            {
                "data": "status",
                "render": function (data) {
                    if (data == 0) {
                        return `<span class="badge bg-warning">Belum</span>`
                    } else {
                        return `<span class="badge bg-success">Sudah</span>`
                    }
                }
            },
            {
                "data": "photo",
                "render": function (data, type, row, meta) {
                    foto_task = '';
                    if (data == null) {
                        foto_task = '<span style="font-size:10px;">No Photo</span>';
                    } else {
                        foto_task = `<a data-fancybox="gallery" href="https://trusmiverse.com/files/security/${data}"><i class="bi bi-image"></i></a>`;
                    }
                    return foto_task;
                },
                "className": "text-center"
            },
            {
                "data": "note",
            },
            {
                "data": "created_at",
            },
            {
                "data": "created_by",
            },
            ],
        });
    }
</script>

<script>
$(document).on("click", ".open-detail-modal", function () {
    let id_task = $(this).data("id");

    if ($.fn.DataTable.isDataTable('#tableDetailTask')) {
        $('#tableDetailTask').DataTable().clear().destroy();
    }

    $('#tableDetailTask tbody').html('');

    $.ajax({
        url: "<?= base_url('security_on_duty/detail_modal'); ?>",
        type: "POST",
        data: { id_task: id_task },
        dataType: "json",
        success: function (res) {

            let rows = "";
            res.data.forEach(function (d) {

                let safePhoto = "No Photo";
                if (d.photo && typeof d.photo === "string" && d.photo.match(/^[a-zA-Z0-9._-]+$/)) {
                    safePhoto = `<a data-fancybox="gallery" href="https://trusmiverse.com/files/security/${d.photo}"><i class="bi bi-image"></i></a>`
                }

                if (d.time_actual === null) {
                    time_actual = "";
                } else {
                    time_actual = d.time_actual;
                }

                rows += `
                    <tr>
                        <td>${d.tasklist}</td>
                        <td>${d.time_start}</td>
                        <td>${d.time_end}</td>
                        <td>${time_actual}</td>
                        <td>
    ${
        d.status == 1
        ? '<span class="badge bg-success">Sudah</span>'
        : `<span class="badge bg-warning"
                style="cursor:pointer"
                onclick="cek_detail_taskk('${d.id}')">
                Belum
           </span>`
    }
</td>

                        <td>${safePhoto}</td>
                        <td>${d.note ?? ''}</td>
                    </tr>`;
            });

            $("#tableDetailTask tbody").html(rows);

            let modalEl = document.getElementById('modalDetailTask');
            let modal = bootstrap.Modal.getOrCreateInstance(modalEl);

            $('.modal-backdrop').remove();
            modal.show();

            // 💡 Delay 200ms supaya modal sudah fully visible
            setTimeout(() => {

                if ($.fn.DataTable.isDataTable('#tableDetailTask')) {
                    $('#tableDetailTask').DataTable().clear().destroy();
                }

                $('#tableDetailTask').DataTable({
                    searching: true,
                    info: true,
                    paging: true,
                    pageLength: 5,
                    lengthChange: true,
                    autoWidth: true,
                    order: [[1, 'asc']],
                    responsive: true,
                    dom: 'Bfrtip',
                    buttons: [{
                        extend: 'excelHtml5',
                        text: 'Export to Excel',
                        footer: true
                    }],
                });

            }, 200); // delay aja biar DataTables detect size modal

        }
    });
});


// Hapus DataTables saat modal ditutup
$('#modalDetailTask').on('hidden.bs.modal', function () {
    if ($.fn.DataTable.isDataTable('#tableDetailTask')) {
        $('#tableDetailTask').DataTable().clear().destroy();
    }
    $("#tableDetailTask tbody").html("");
});

</script>



