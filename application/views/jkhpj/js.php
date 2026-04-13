<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/dragula/dragula.js"></script>


<script>
    $(document).ready(function() {

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

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
        dt_resume_tasklist('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>');
        $('.range').on('change', function() {
            start = $('input[name="start"]').val();
            end = $('input[name="end"]').val();
            dt_resume_tasklist(start, end);
        })
        // Text_Area
        $('textarea.input_permintaan').each(function() {
            $(this).summernote({
                tabsize: 2,
                height: 70,
                toolbar: [
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                ]
            });
        })

        initType = new SlimSelect({
            select: "#tipe_memo"
        });

        if ($('#kanban_id_task').length > 0) {
            // Panggil fungsi untuk memuat data kanban
            load_kanban_jkhpj();

            // Inisialisasi Dragula untuk 2 kolom kita
            var jkhpj_drag = dragula([
                document.getElementById('kolom_belum'),
                document.getElementById('kolom_sudah')
            ]);

            // Atur event listener untuk 'drop'
            jkhpj_drag.on('drop', function(el, target, source, sibling) {
                var id_task_item = $(el).data('id_task_item');
                var source_id = source.id;
                var target_id = target.id;

                // 1. Jika ditarik dari 'Belum' ke 'Sudah'
                if (source_id === 'kolom_belum' && target_id === 'kolom_sudah') {
                    // Panggil fungsi modal yang sudah ada
                    // Fungsi ini (berdasarkan kode Anda) akan otomatis set status ke '1'
                    cek_detail_task(id_task_item);
                }

                // 2. Jika ditarik kembali dari 'Sudah' ke 'Belum' (Revert)
                else if (source_id === 'kolom_sudah' && target_id === 'kolom_belum') {
                    // Tampilkan pesan error dan batalkan
                    swal("Oops!", "Anda tidak bisa mengembalikan status ke 'Belum'. Harap lakukan update manual jika perlu.", "warning");

                    // Muat ulang data kanban untuk mengembalikan kartu ke posisi semula
                    load_kanban_jkhpj();
                }
            });
        }
    });

    function dt_resume_tasklist(start, end, status) {
        $('#dt_resume_tasklist').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
            ],
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "method": "POST",
                "url": "<?= base_url(); ?>jkhpj/dt_resume_tasklist",
                "data": {
                    start: start,
                    end: end,
                    status: status
                }
            },
            "columns": [{
                    "data": "id_task",
                    "render": function(data, type, row, meta) {
                        return `<a class="badge text-bg-success" href="<?= base_url(); ?>jkhpj/list_task?id_task=${data}">${data}</a>`;
                    },
                },
                {
                    "data": 'created_by',
                },
                {
                    "data": 'designation_name'
                },
                {
                    "data": 'achievement',
                },
                // {
                // "data": 'average_rating',
                // },
                {
                    "data": 'created_at',
                },
                {
                    "data": 'feedback',
                },
                {
                    "data": 'file_feedback',
                    "render": function(data, type, row, meta) {
                        if (data != null) {
                            return `<a href="<?= base_url(); ?>files/jkhpj/${data}"><i class="bi bi-file-earmark-arrow-down"></i></a>`
                        } else {
                            return '';
                        }

                    }
                },
                {
                    "data": 'link_feedback',
                    "render": function(data, type, row, meta) {
                        if (data != null) {
                            return `<a href="${data}">Link</a>`
                        } else {
                            return '';
                        }

                    },
                },
                {
                    "data": 'status_feedback',
                },
            ],
        });
    }

    function dt_resume_tasklist_feedback(start, end, status) {
        $('#feedback_jkhpj').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
            ],
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "method": "POST",
                "url": "<?= base_url(); ?>jkhpj/dt_resume_tasklist_feedback",
                "data": {
                    start: start,
                    end: end,
                    status: status
                }
            },
            "columns": [{
                    "data": "id_task",
                    "render": function(data, type, row, meta) {
                        return `<a class="badge text-bg-success" onclick='add_feedback("${data}")' style="cursor:pointer;">${data}</a>`;

                    },
                },
                {
                    "data": 'created_by',
                },
                {
                    "data": 'designation_name'
                },
                {
                    "data": 'achievement',
                },
                // {
                // "data": 'average_rating',
                // },
                {
                    "data": 'created_at',
                },
                {
                    "data": 'feedback',
                },
                {
                    "data": 'file_feedback',
                    "render": function(data, type, row, meta) {
                        if (data != null) {
                            return `<a href="<?= base_url(); ?>files/jkhpj/${data}"><i class="bi bi-file-earmark-arrow-down"></i></a>`
                        } else {
                            return '';
                        }

                    }
                },
                {
                    "data": 'link_feedback',
                    "render": function(data, type, row, meta) {
                        if (data != null) {
                            return `<a href="${data}">Link</a>`
                        } else {
                            return '';
                        }

                    },
                },
                {
                    "data": 'status_feedback',
                },
            ],
        });
    }

    function add_task() {
        $.ajax({
            url: "<?= base_url(); ?>jkhpj/check_insert_task",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.message === "Success insert task") {
                    swal("Success", response.message, "success");
                    window.location.href = "<?= base_url(); ?>jkhpj/list_task?id_task=" + response.id_task;
                } else if (response.message === "Already, redirect") {
                    swal("Info", response.message, "info");
                    window.location.href = "<?= base_url(); ?>jkhpj/list_task?id_task=" + response.id_task;
                } else {
                    swal("Error", response.message, "error");
                }
            },
            error: function(xhr, status, error) {
                swal("Error", "An error occurred while processing the request.", "error");
            }
        });
    }

    function cek_detail_task(id_task_item) {

        $.ajax({
            url: '<?= base_url('jkhpj/detail_task_item') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id_task_item
            },
            success: function(res) {
                $('#modal_detail_task').modal('show');
                // console.log('detail task : ', res);
                $('#id_task_item').val(res.data.id);
                $('#id_task').val(res.data.id_task);
                $('#det_time_start').text(res.data.timestart);
                $('#det_time_end').text(res.data.timeend);
                $('#det_tasklist').text(res.data.tasklist);
                $('#det_description').html(res.data.description);

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
                $('#link').val(res.data.link);
                $('#is_file').val(res.data.is_file);
                $('#old_photo').val(res.data.photo);

                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); // Januari = 0
                var yyyy = today.getFullYear();
                var tanggalHariIni = yyyy + '-' + mm + '-' + dd;

                // 2. Dapatkan tanggal task (YYYY-MM-DD) dari data 'task_created_at' baru kita
                var tanggalTask = res.data.task_created_at.split(' ')[0];

                // 3. Bandingkan dan set Readonly/Disabled
                // if (tanggalTask != tanggalHariIni) {
                //     // Jika task BUKAN hari ini (kemarin atau lebih lama)
                //     $('#status').prop('disabled', true);
                //     $('#note').prop('readonly', true);
                //     $('#link').prop('readonly', true);
                //     $('#photo').prop('disabled', true);
                //     $('#btn_update_task_item').hide(); // Sembunyikan tombol update
                // } else {
                //     // Jika task HARI INI, pastikan form bisa diisi
                //     $('#status').prop('disabled', false);
                //     $('#note').prop('readonly', false);
                //     $('#link').prop('readonly', false);
                //     $('#photo').prop('disabled', false);
                //     $('#btn_update_task_item').show(); // Tampilkan tombol update
                // }


                if (res.data.is_file == 1) {
                    $('.div-photo').removeClass('d-none');
                    $('#label-link').html('<strong>Link (Opsional)</strong>');
                } else {
                    $('.div-photo').addClass('d-none');
                    $('#label-link').html('<strong>Link (Opsional)</strong>');
                }

                if (res.data.file == null || res.data.file == '') {
                    $('#preview_photo').attr('src', 'https://trusmiverse.com/files/security/no-image.png');
                    $('#preview_photo').attr('width', '100px');
                } else {
                    const fileExtension = res.data.file.split('.').pop().toLowerCase();
                    const imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];

                    if (imageExtensions.includes(fileExtension)) {
                        $('#preview_photo').attr('src', 'https://trusmiverse.com/files/jkhpj/' + res.data.file);
                        $('#preview_photo').attr('width', '300px').show();
                        $('#file_jkhpj').hide();
                    } else {
                        $('#preview_photo').hide();
                        $('#file_jkhpj').attr('href', 'https://trusmiverse.com/files/jkhpj/' + res.data.file).text(res.data.file).show();
                    }
                }

            },
        });
    }

    function update_task_item() {
        // console.log($('#form_detail_task').serialize());
        var id_task_item = $('#id_task_item').val();
        var id_task = $('#id_task').val();
        var status = $('#status').val();
        var note = $('#note').val();
        var link = $('#link').val();
        var is_file = $('#is_file').val();
        var old_photo = $('#old_photo').val();
        var photo = $('#photo').prop("files")[0];
        console.log('photo: ', photo);
        // return;
        let form_file = new FormData();
        form_file.append("id_task_item", id_task_item);
        form_file.append("id_task", id_task);
        form_file.append("status", status);
        form_file.append("note", note);
        form_file.append("link", link);
        form_file.append("file", photo);
        console.log(form_file);


        if (is_file == 1 && old_photo == '' && photo == undefined) {
            swal("Error", "File tidak boleh kosong", "error");
            return;
        } else {
            // if (is_file == 0 && link == '') {
            //     swal("Error", "Link tidak boleh kosong", "error");
            //     return;
            // }
            if (old_photo != '' && photo == undefined) {
                form_file.append("old_photo", old_photo);
            }

            $.ajax({
                url: '<?= base_url('jkhpj/update_task_item') ?>',
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
                    swal("Success", 'Berhasil update task item', "success");
                    location.reload();
                },
                error: function(xhr) { // if error occured
                    console.log(xhr);
                    swal("Error", "Gagal update task item", "error");
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

    function compress_file_progres(id, title) {

        const file = document.querySelector(id).files[0];

        if (!file) return;

        const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (validImageTypes.includes(file.type)) {

            extension = file.name.substr((file.name.lastIndexOf('.') + 1));

            const reader = new FileReader();

            reader.readAsDataURL(file);

            reader.onload = function(event) {
                const imgElement = document.createElement("img");
                imgElement.src = event.target.result;

                extension = 'png,';

                imgElement.onload = function(e) {
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

                    upload_file_progress(id, g_string, title);
                }
            }
        } else {
            upload_file_progress(id, g_string, title);
        }

    }

    function upload_file_progress(id, g_string, title) {
        id_input = id + '_input';
        var formdata = new FormData();
        formdata.append('file', g_string);

        // console.log(id)

        url = "<?= base_url() . 'jkhpj/upload_foto_task' ?>";

        var ajax = new XMLHttpRequest();
        // ajax.upload.addEventListener("progress", progressUpload, false);
        ajax.open("POST", url, true);
        ajax.send(formdata);
        ajax.onload = function(response) {
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

    function list_feedback() {
        $('#modal_feedback_jkhpj').modal('show');
        dt_resume_tasklist_feedback(null, null, 'feedback');
    }

    function add_feedback(id) {
        $('#id_task_feedback').val(id);
        $('#feedback').summernote('code', '');
        $('#form_feedback')[0].reset();
        $('#modal_add_feedback').modal('show');
        $.ajax({
            url: "<?= base_url('jkhpj/dt_list_detail_task') ?>",
            method: "POST",
            data: {
                id: id
            },
            dataType: "JSON",
            beforeSend: function() {
                $('#list_tasklist').html('')
            },
            success: function(res) {
                var data = res.data
                var history = ``;
                $.each(data, function(i, val) {
                    history += `<tr>
                        <td>
                            ${val.tasklist}
                        </td>
                        <td>
                            ${val.description}
                        </td>
                        <td>
                            ${val.time_start} - ${val.time_end}
                        </td>
                        <td>${val.status == 0 ? `<span class="badge text-bg-warning">Belum dicek</span>` : `<span class="badge text-bg-success">Sudah dicek</span>`}</td>
                        <td>${val.link != null ? `<a href="${val.link}" target="_blank">Go to Link</a>` : ''}</td>
                        <td>${val.file != null ? `<a href="https://trusmiverse.com/files/jkhpj/${val.file}" target="_blank">Download File</a>` : ''}</td>
                        
                        <td>${val.note || ''}</td>
                    </tr>`
                })
                $('#list_tasklist').html(history)
            }
        })
    }

    function simpan_feedback() {
        let form_data = new FormData();
        id = $('#id_task_feedback').val();
        feedback = $('#feedback').val();
        file_feedback = $('#file_feedback').val();
        files = $("#file_feedback").prop("files")[0];
        link_feedback = $('#link_feedback').val();
        status_feedback = $('#status_feedback').val();

        form_data.append("files", file_feedback != '' ? files : null);
        form_data.append("id", id);
        form_data.append("feedback", feedback);
        form_data.append("link_feedback", link_feedback);
        form_data.append("status_feedback", status_feedback);
        if (feedback == '') {
            swal('Warning!', 'Harap mengisi feedback', 'error');
        } else if (status_feedback == null) {
            swal('Warning!', 'Harap memilih Status', 'error');
        }
        // else if (file_feedback == '' && link_feedback == '') {
        // swal('Warning!', 'Harap Upload File atau mengisi Link', 'error');
        // } 
        else {
            swal({
                    title: "Simpan Feedback?",
                    icon: "info",
                    buttons: true,
                    dangerMode: false,
                })
                .then((simpan) => {
                    if (simpan) {
                        $.ajax({
                            'url': "<?= base_url('jkhpj/feedback_jkhpj') ?>",
                            'type': "POST",
                            'data': form_data,
                            'dataType': "JSON",
                            'processData': false, // Prevent jQuery from processing the data
                            'contentType': false, // Prevent jQuery from setting the content type
                            'beforeSend': function() {
                                // $('#spinner').modal('show');
                                $("#btn_save_feedback").attr("disabled", true);
                            },
                            'success': function(response) {
                                console.log(response);
                                if (response.update) {
                                    // $('#spinner').modal('hide');
                                    $('#modal_add_feedback').modal('hide');
                                    $("#btn_save_feedback").removeAttr("disabled");
                                    $('#feedback_jkhpj').DataTable().ajax.reload();
                                    swal('Success!', 'Berhasil menambah feedback', 'success');
                                } else {
                                    $("#btn_save_feedback").removeAttr("disabled");
                                    swal('Warning!', 'Gagal menambah feedback ', 'error');
                                }

                            }
                        })
                    }
                });
        }
    }

    function load_kanban_jkhpj() {
        var id_task = $('#kanban_id_task').val();

        $.ajax({
            url: "<?= base_url(); ?>jkhpj/get_list_task_kanban",
            type: "POST",
            dataType: "json",
            data: {
                id_task: id_task
            },
            beforeSend: function() {
                // Kosongkan kolom sebelum memuat
                $('#kolom_belum').html('<p class="text-center">Memuat...</p>');
                $('#kolom_sudah').html('<p class="text-center">Memuat...</p>');
            },
            success: function(response) {
                var html_belum = '';
                var html_sudah = '';

                if (response.data && response.data.length > 0) {
                    response.data.forEach(function(item) {

                        // Tentukan tema kartu berdasarkan status
                        var card_theme = (item.status == 0 ? 'theme-orange' : 'theme-green');
                        var icon = (item.status == 0 ? 'bi-exclamation-circle' : 'bi-check-circle');
                        var time_actual_html = '';

                        if (item.time_actual != null) {
                            time_actual_html = '<span>Waktu Cek <strong>' + item.time_actual.substring(0, 5) + '</strong></span>';
                        } else {
                            time_actual_html = '<span>Belum di Cek</span>';
                        }

                        var note_html = '';
                        if (item.note != null && item.note != '') {
                            note_html = '<hr><p class="mb-3"><b>Catatan</b> : <span>' + item.note + '</span></p>';
                        }

                        // Kita rakit ulang HTML kartu dari list_task.php Anda
                        // KITA TAMBAHKAN data-id_task_item PENTING UNTUK DRAGULA
                        var card_html = `
                        <div class="card bg-theme ${card_theme} border-0 mb-4" data-id_task_item="${item.id}" style="cursor: grab;">
                            <div class="card-header bg-none">
                                <div class="row gx-2 align-items-center">
                                    <div class="col-auto">
                                        <i class="bi ${icon} h5 me-1 avatar avatar-40 bg-light-white rounded me-2"></i>
                                    </div>
                                    <div class="col">
                                        <h6 class="fw-medium mb-0">${item.tasklist}</h6>
                                        <p class="text-muted small">Jadwal <strong>${item.time_start.substring(0, 5)} - ${item.time_end.substring(0, 5)}</strong></p>
                                    </div>
                                    <div class="col-auto">
                                        <p class="small text-right">
                                            ${time_actual_html}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body bg-none">
                                <h5 class="mb-3">
                                    <span>${item.description}</span>
                                </h5>
                                ${note_html}
                            </div>
                            <div class="card-footer text-center" onclick="cek_detail_task('${item.id}')" style="cursor:pointer;">
                                <button type-="button" class="btn btn-link">Check</button>
                            </div>
                        </div>
                        `;

                        // Pisahkan kartu berdasarkan status
                        if (item.status == 0) {
                            html_belum += card_html;
                        } else {
                            html_sudah += card_html;
                        }
                    });
                } else {
                    html_belum = '<p class="text-center text-muted">Tidak ada task.</p>';
                    html_sudah = '<p class="text-center text-muted">Tidak ada task.</p>';
                }

                // Masukkan kartu-kartu ke kolom yang sesuai
                $('#kolom_belum').html(html_belum || '<p class="text-center text-muted">Tidak ada task.</p>');
                $('#kolom_sudah').html(html_sudah || '<p class="text-center text-muted">Tidak ada task.</p>');
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                swal("Error", "Gagal memuat data task. Silakan coba lagi.", "error");
            }
        });
    }
</script>