<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.1/viewer.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.1/viewer.min.js"></script>

<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip()
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="startdate"]').val(start.format('YYYY-MM-DD'));
            $('input[name="enddate"]').val(end.format('YYYY-MM-DD'));
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
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                    .endOf('month')
                ]
            }
        }, cb);

        cb(start, end);


        load_data('hr');

        $('#btn_filter').on('click', function () {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            load_data(currentDivisi);

        });






    });
    let currentDivisi = 'hr';

    let dataTableInstance = null;


    window.load_data = function (divisi) {
        currentDivisi = divisi;
        var start = $('input[name="startdate"]').val();
        var end = $('input[name="enddate"]').val();
        let columns = [];
        let data = [];
        let headers = '';

        // Menentukan kolom, data, dan header berdasarkan divisi yang dipilih
        switch (divisi) {
            case 'ga':
                headers = `
                <th>Company</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Nama</th>
                <th>Date Of Join</th>
                <th>Request</th>
                <th>Detail Request</th>
                <th>Lokasi Kantor</th>
                <th>Status</th>
                <th>Validate At</th>
                <th>Validated By</th>
                <th>Created At</th>
                <th>Created By</th>
            `;
                columns = [
                    { "data": "company_name" },
                    { "data": "department_name" },
                    { "data": "designation_name" },
                    { "data": "employee" },
                    { "data": "date_of_joining" },
                    { "data": "nama_request" },    // Mengambil dari kolom 'judul'
                    { "data": "detail_request" },    // Mengambil dari kolom 'judul'
                    { "data": "lokasi_kantor" },    // Mengambil dari kolom 'judul'
                    {
                        "data": "status", // Status juga berdasarkan 'validated_at'
                        "render": function (data,type,row) {
                            // Jika validated_at null, statusnya "Belum"
                            if (data == 0) {
                                return `<span class="badge bg-secondary" onclick="validasi('ga',${row.user_id},${row.id})" style='cursor:pointer'>Belum</span>`;
                            } else if(data ==1) {
                                // Jika validated_at memiliki isi, statusnya "Done"
                                return `<span class="badge bg-success">Approve</span>`;
                            }else{
                                return `<span class="badge bg-danger">Reject</span>`;
                            }
                        }
                    },
                   
                    {
                        "data": "validated_at", // Mengambil dari kolom 'validated_at'
                        "render": function (data) {
                            // Jika data null, tampilkan '-', jika tidak tampilkan datanya
                            return data ? data : '-';
                        }
                    },

                    { "data": "validated_by" },
                    { "data": "created_at" },
                    { "data": "created_by" },
                ];
                break;

            case 'comben':
                headers = `
                <th>Company</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Nama</th>
                <th>Penjelasan</th>
                <th>Date Of Join</th>
                <th>Status</th>
                <th>Validate At</th>
                <th>Validated By</th>
                <th>Validated Note</th>
            `;
                columns = [
                    { "data": "company_name" },
                    { "data": "department_name" },
                    { "data": "designation_name" },
                    { "data": "employee" },
                    { "data": "judul" },    // Mengambil dari kolom 'judul'
                    { "data": "date_of_joining" },
                    {
                        "data": "validated_at", // Status juga berdasarkan 'validated_at'
                        "render": function (data,type,row) {
                            // Jika validated_at null, statusnya "Belum"
                            if (data === null) {
                                return `<span class="badge bg-danger" onclick="validasi('comben',${row.user_id},${row.id})" style='cursor:pointer'>Belum</span>`;
                            } else {
                                // Jika validated_at memiliki isi, statusnya "Done"
                                return `<span class="badge bg-success">Done</span>`;
                            }
                        }
                    },
                    
                    {
                        "data": "validated_at", // Mengambil dari kolom 'validated_at'
                        "render": function (data) {
                            // Jika data null, tampilkan '-', jika tidak tampilkan datanya
                            return data ? data : '-';
                        }
                    },

                    { "data": "validated_by" },
                    { "data": "validated_note" },
                ];
                break;

            case 'hr':
            default:
                headers = `
                <th>Company</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Nama</th>
                <th>Date Of Join</th>
                <th>Status</th>
                <th>Validate At</th>
                <th>Validated By</th>
                <th>Validated Note</th>
            `;
                columns = [
                    { "data": "company_name" },
                    { "data": "department_name" },
                    { "data": "designation_name" },
                    { "data": "employee" },
                    { "data": "date_of_joining" },
                    {
                        "data": "status",
                        'render': function (data, type, row) {
                            if (data == 1) {
                                return `<span class="validation-validated"><i class="fas fa-check-circle me-2"></i>All Validated</span>`;
                            } else {
                                return `<span class="validation-pending" onclick="detail(${row.user_id})"><i class="fas fa-exclamation-circle me-2"></i>${row.waiting} Validation Pending</span>`;
                            }
                        }

                    },
                    {
                        "data": "validated_at", // Mengambil dari kolom 'validated_at'
                        "render": function (data) {
                            // Jika data null, tampilkan '-', jika tidak tampilkan datanya
                            return data ? data : '-';
                        }
                    },



                    { "data": "validated_by" },
                    { "data": "validated_note" },
                ];
                break;
        }

        // Hancurkan instance DataTable yang lama jika sudah ada
        if (dataTableInstance) {
            dataTableInstance.destroy();
        }

        // Ganti header tabel dan kosongkan body
        $('#data_onboarding thead').html(`<tr>${headers}</tr>`);
        $('#data_onboarding tbody').empty();

        dataTableInstance = $('#data_onboarding').DataTable({
            "columns": columns,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true, // Penting untuk re-inisialisasi
            "dom": 'Bfrtip',
            buttons: [{
                title: 'Data Onboarding ' + divisi.toUpperCase(),
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "processing": true, // Menampilkan pesan "Processing..." saat AJAX berjalan
            "ajax": {
                "url": "<?= base_url('Onboarding/load_data'); ?>", // URL endpoint di server Anda
                "type": "POST",
                "data": {
                    "divisi": divisi,
                    'start': start,
                    'end': end
                }, // Mengirim parameter divisi ke server
                "dataSrc": ""
            },
        });
    }

    function validasi(divisi, user_id, id_item) {
        if(divisi == 'ga'){
            $('#form_validasi_ga').show();
            $('#form_validasi').hide();
        }else{
            $('#form_validasi_ga').hide();
            $('#form_validasi').show();
        }
        var modal = '#modal_validasi';
        $(modal).css('z-index', 1060);
        // $('.modal-backdrop').last().css('z-index', 1055);
        $(modal).modal('show');
        $(modal).find('[name="user_id"]').val(user_id);
        $(modal).find('[name="id_item"]').val(id_item);
        $(modal).find('[name="divisi"]').val(divisi);
    }

    $('#form_validasi').submit(function (e) {
        e.preventDefault();
        var form = $(this)
        $.confirm({
            title: 'Alert!',
            content: 'Apakah anda yakin ?',
            type: 'blue',
            theme: 'material',
            typeAnimated: true,
            closeIcon: false, // explicitly show the close icon
            animation: 'opacity',
            buttons: {
                close: function () { },
                confirm: {
                    text: 'Yakin',
                    btnClass: 'btn-blue',
                    action: function () {
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url('Onboarding/insert_validasi'); ?>",
                            data: form.serialize(),
                            dataType: "json",
                            success: function (response) {
                                $('#modal_validasi').modal('hide');
                                load_data(currentDivisi);
                                let user_id = $('input[name="user_id"]').val();
                                let divisi = $('input[name="divisi"]').val();
                                if (user_id == true && divisi == 'hr') {
                                    detail(user_id);
                                }

                                $.alert({
                                    title: 'Success',
                                    content: 'Berhasil di update!',
                                    type: 'blue',
                                    theme: 'material',
                                    autoClose: 'ok|3000',
                                });

                            }
                        });
                        // $('#modal_preview').modal('hide');
                        // $("#dt_approval").DataTable().ajax.reload();
                        // $("#dt_fdk").DataTable().ajax.reload();
                    }
                },
            }
        });
    });
    $('#form_validasi_ga').submit(function (e) {
        e.preventDefault();
        var form = $(this)
        $.confirm({
            title: 'Alert!',
            content: 'Apakah anda yakin ?',
            type: 'blue',
            theme: 'material',
            typeAnimated: true,
            closeIcon: false, // explicitly show the close icon
            animation: 'opacity',
            buttons: {
                close: function () { },
                confirm: {
                    text: 'Yakin',
                    btnClass: 'btn-blue',
                    action: function () {
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url('Onboarding/insert_validasi'); ?>",
                            data: form.serialize(),
                            dataType: "json",
                            success: function (response) {
                                $('#modal_validasi').modal('hide')
                                load_data(currentDivisi);
                                $.alert({
                                    title: 'Success',
                                    content: 'Berhasil di update!',
                                    type: 'blue',
                                    theme: 'material',
                                    autoClose: 'ok|3000',
                                });

                            }
                        });
                        // $('#modal_preview').modal('hide');
                        // $("#dt_approval").DataTable().ajax.reload();
                        // $("#dt_fdk").DataTable().ajax.reload();
                    }
                },
            }
        });
    });


    function detail(user_id) {
        $('#modal_detail').modal('show');
        $.ajax({
            type: "POST",
            url: "<?= base_url('onboarding/detail'); ?>",
            data: {
                user_id: user_id
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                let emp = response.employee;
                $('#detail_foto_profile').attr('src', emp.foto_profile);
                $('#detail_nama').text(emp.employee);
                $('#detail_designation').first().text(emp.designation_name);
                $('#detail_date_of_join').text(emp.date_of_joining);
                $('#detail_current_day').text("Day " + emp.date_diff);
                $('#detail_location').text(emp.location_name);
                $('#detail_pic_foto').attr('src', emp.pic_foto);
                $('#detail_pic_nama').text(emp.pic_nama);


                let tasks = response.day_1;
                let htmlTasks = '';

                tasks.forEach(task => {
                    let iconClass = 'bi-circle text-muted'; // default icon
                    let badge = '';
                    let btn = '';

                    if (task.done == "1" && task.status_validated == "1") {
                        iconClass = 'bi-check-circle-fill text-success';
                        badge = `<span class="badge rounded-pill text-bg-success ms-2">Divalidasi</span>`;
                    } else if (task.done == "1" && task.status_validated == "0") {
                        iconClass = 'bi-exclamation-triangle-fill text-warning';
                        badge = `<span class="badge rounded-pill text-bg-warning ms-2">Menunggu Validasi</span>`;
                        btn = `
                <button class="btn btn-primary btn-sm me-2" onclick="validasi('hr',${task.user_id},${task.id})">Validasi</button>
                <button class="btn btn-outline-danger btn-sm" onclick="rejectTask(${task.id})">Reject</button>
            `;
                    } else {
                        btn = `<button class="btn btn-primary btn-sm" onclick="validasi('hr',${task.user_id},${task.id})">Validasi</button>`;
                    }

                    htmlTasks += `
            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                <div class="d-flex align-items-center">
                    <i class="bi ${iconClass} fs-4 me-3"></i>
                    <div>
                        <strong>${task.judul}</strong><br>
                        <small class="text-muted">${task.done == "1" ? "Konfirmasi oleh User" : "Belum dikerjakan"
                        }</small>
                        ${badge}
                    </div>
                </div>
                ${btn}
            </div>
        `;
                });

                $('#day1-pane .list-group').html(htmlTasks);

            }
        });
    }



    function update(type) {
        var user_id = $('.user_id').val();
        var dokumen = $('.dokumen').val();
        if (type == 1) { //approve
            $.confirm({
                title: 'Alert!',
                content: 'Apakah anda yakin ?',
                type: 'blue',
                theme: 'material',
                typeAnimated: true,
                closeIcon: false, // explicitly show the close icon
                animation: 'opacity',
                buttons: {
                    close: function () { },
                    confirm: {
                        text: 'Yakin',
                        btnClass: 'btn-blue',
                        action: function () {
                            update_dokumen(type, dokumen, user_id);

                            $.alert({
                                title: 'Success',
                                content: 'Berhasil di update!',
                                type: 'blue',
                                theme: 'material',
                                autoClose: 'ok|3000',
                            });
                            $('#modal_preview').modal('hide');
                            $("#dt_approval").DataTable().ajax.reload();
                            $("#dt_fdk").DataTable().ajax.reload();
                        }
                    },
                }
            });
        } else { //reject
            $.confirm({
                title: 'Alert!',
                content: 'Apakah anda yakin ?',
                type: 'red',
                theme: 'material',
                typeAnimated: true,
                closeIcon: false, // explicitly show the close icon
                animation: 'opacity',
                buttons: {
                    close: function () { },
                    confirm: {
                        text: 'Yakin',
                        btnClass: 'btn-red',
                        action: function () {
                            update_dokumen(type, dokumen, user_id);
                            $.alert({
                                title: 'Success',
                                content: 'Berhasil di update!',
                                type: 'blue',
                                theme: 'material',
                                autoClose: 'ok|3000',
                            });
                            $('#modal_preview').modal('hide');
                            $("#dt_approval").DataTable().ajax.reload();
                            $("#dt_fdk").DataTable().ajax.reload();
                        }
                    },
                }
            });
        }
    }

    function update_dokumen(type, dokumen, user_id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('fdk/update_dokumen'); ?>",
            data: {
                type: type,
                dokumen: dokumen,
                user_id: user_id,
            },
            dataType: "json",
            success: function (response) {

            }
        });
    }



    function uploadPhoto(directoryUrl, inputId) {
        var fileInput = document.getElementById(inputId);
        var file = fileInput.files[0];
        var fileName = file.name;
        var fileSize = file.size;

        // Set nama file ke input foto
        // $('#' + inputId).val(fileName);

        // Tambahkan tag small "Uploading..." setelah input foto
        var upload_status = $('<small class="uploadStatus"><i class="fa fa-spinner fa-pulse"></i> Uploading...</small>');
        $('#' + inputId).after(upload_status);
        var formData = new FormData();
        formData.append('photo', file);
        formData.append('url', directoryUrl);
        var controller = window.location.origin + '/ClassUpload/upload_file';
        // Kirim data gambar ke server menggunakan AJAX
        $.ajax({
            url: controller,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                var data = JSON.parse(res);
                $('#' + inputId + '_value').val(data.upload_data.file_name); //set ke input text file name
                upload_status.html('<i class="fa fa-check-circle text-success"></i> File has been Uploaded').delay(4000).fadeOut();
            },
            error: function (xhr, status, error) {
                // Proses unggah gagal
                console.error('Upload failed. Status:', status, 'Error:', error);
                upload_status.html('<i class="fa fa-times-circle text-danger"></i> Upload failed. Please try again.').delay(4000).fadeOut();
            }
        });
        // Kompress gambar dan lakukan unggah

    }

    function copy_link(user_id) {
        $.ajax({
            type: "GET",
            url: '<?= base_url('fdk/hashUser/'); ?>' + user_id,

            dataType: "json",
            success: function (response) {
                var link = '<?= base_url('fdk/form/'); ?>' + response;
                var tempInput = document.createElement('input');
                tempInput.value = link;
                document.body.appendChild(tempInput);
                tempInput.select();
                tempInput.setSelectionRange(0, 99999); // For mobile devices
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                $.alert({
                    title: 'Success',
                    content: 'Berhasil di copas! : <br>' + link,
                    type: 'blue',
                    theme: 'material',
                    autoClose: 'ok|3000',
                });
            }
        });
    }

    function lihat_contact(id) {
        $('#modal_lihat_contact').modal('show');
        $('#dt_contact').DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "order": [
                [0, "asc"]
            ],
            "destroy": true,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    id: id
                },
                "url": "<?= site_url('fdk/get_contact') ?>",
            },
            "columns": [{
                "data": "id",
                "render": function (data, type, row, meta) {
                    return meta.row + 1
                },
                'className': 'text-center'

            },
            {
                "data": "name",

            },
            {
                "data": "phone"
            },
            {
                "data": "email"
            },
            {
                "data": "contact"
            },
            {
                "data": "created_at"
            },
            ]
        });
    }

</script>