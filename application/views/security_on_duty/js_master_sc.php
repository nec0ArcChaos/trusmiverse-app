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
        console.log('document js ready..');

        /*Range*/
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
            // list_pph21(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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


    }); // END :: Ready Function

    function add_site() {

        id_project = $('#project').val();
        id_shift = $('#shift').val();
        
        if (id_project == '#') {

        } else if (id_shift == '#') {

        } else {
            $.ajax({
                url: '<?= base_url('security_on_duty/add_site') ?>',
                type: 'POST',
                dataType: 'json',
                cache: false,
                // contentType: false,
                // processData: false,
                // data: form_file,
                data: {
                    id_project: id_project,
                    id_shift: id_shift,
                },
                success: function(response) {
                    console.log(response);
                    success_alert('Berhasil update task item');
                    // location.reload();
                },
                error: function(xhr) { // if error occured
                    console.log(xhr);
    
                    error_alert('Failed, Error Occured');
                },
            });
        }

    }

    function get_data_shift($id_project) {
        $.ajax({
            url: '<?= base_url('security_on_duty/data_shift') ?>',
            type: 'POST',
            dataType: 'json',
            // data: form.serialize(),
            data: {
                id_project: id_project
            },
            beforeSend: function() {
                // $('#btn_save_confirm').attr('disabled', true);
                // $("#btn_save_confirm").html("Please wait...");
            },
            success: function(response) {
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
            error: function(xhr) { // if error occured
                error_alert('Failed, Error Occured');
            },
            complete: function() {
                // $('#btn_save_confirm').attr('disabled', false);
                // $("#btn_save_confirm").html("Yes, Save");
            },
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


        if (is_photo == 1 && old_photo == '' && photo == undefined) {
            error_alert('Foto wajib di isi');

        } else {

            if (old_photo != '' && photo == undefined) {
                form_file.append("old_photo", old_photo);
            }

            $.ajax({
                url: '<?= base_url('security_on_duty/update_task_item') ?>',
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
                    "render": function(data) {
                        return `<span class="badge bg-primary">${data}</span>`
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

</script>