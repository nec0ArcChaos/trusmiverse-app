<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<!-- <script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script> -->
 <!-- SlimSelect JS -->
<script src="https://cdn.jsdelivr.net/npm/slim-select@2.8.1/dist/slimselect.min.js"></script>

<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
<script>
    $(document).ready(function() {
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;
        // alert(maxDate);
        $('#tgl_masuk').attr('min', maxDate);

        $(document).on('keyup', '.key_list', function(e) {
            if (e.which == 13) { // Kode 13 adalah key code untuk tombol enter
                e.preventDefault(); // Mencegah form dari submit default
                tambah_list(); // Memanggil fungsi tambah_list
            }
        });

        // $("#karyawan").SlimSelect({ dropdownParent: "#modal_input" });

        // Datepicker
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


        dt_pk('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>');


        $('#btn_filter').on('click', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            dt_pk(start, end);

        });
        $('.range').on('change', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            dt_pk(start, end);
        })


    });

    function dt_pk(start, end) {

        $('#dt_pk').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
            ],
            buttons: [{
                title: 'Data Work on holiday ' + start,
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": "<?= base_url(); ?>work_on_holiday/get_data",
                "data": {
                    start: start,
                    end: end,
                }
            },
            "columns": [
                // {
                //     'data': 'user_id',

                // },
                {
                    'data': 'id_pk',
                    'render': function(data, type, row) {
                        let btnHapus = ``;   // ← ganti nama variabel pakai let/const
                        if (row.is_created == 1) {
                            btnHapus = `<span onclick="hapus('${row.id_pk}')" class="badge bg-danger" style='cursor:pointer'><i class="fa fa-trash"></i></span>`;
                        }
                        return `<a onclick="list_job('${data}')" style="cursor:pointer"><span class="badge bg-primary">${data}</span></a> ${btnHapus}`;
                    }
                },
                {
                    'data': 'company',
                },
                {
                    'data': 'department_name',
                },
                {
                    'data': 'designation_name',
                },
                {
                    'data': 'pic',
                },
                {
                    'data': 'tgl_masuk',
                },
                {
                    'data': null,
                    'render': function(data, type, row) {
                        var total    = parseInt(row.total_job)    || 0;
                        var progres  = parseInt(row.job_progres)  || 0;
                        var done     = parseInt(row.job_done)     || 0;
                        var verified = parseInt(row.job_verified) || 0;
                        var revisi   = parseInt(row.job_revisi)   || 0;

                        if (progres === 0 && done === 0) {
                            return '<span class="badge bg-secondary">Not Started</span>';
                        }
                        if (done === total && revisi === 0 && verified === total) {
                            return '<span class="badge bg-success">Complete</span>';
                        }
                        if (done === total && revisi === 0) {
                            return '<span class="badge bg-warning text-dark">Waiting</span>';
                        }
                        return '<span class="badge bg-warning text-dark">On-Going</span>';
                    }
                },
                {
                    'data': 'note',
                },
                {
                    'data': 'created_at',
                },
                {
                    'data': 'created_by',
                },
                {
                    'data': 'verified_at',
                    'render': function(data, type, row) {
                        return data ? data : '<span class="text-muted">-</span>';
                    }
                },

            ],
            // "createdRow": function(row, data, dataIndex) {
            //     // 
            // }
        });
    }

    function input_perintah() {

        $('#modal_input').modal('show');
        url = "<?= base_url('work_on_holiday/get_karyawan') ?>";
        $.getJSON(url, function(result) {
            res = '<option data-placeholder="true">-- Pilih Karyawan --</option>';

            $.each(result, function(index, value) {
                res +=
                    `<option value="${value['user_id']}" >${value['nama_karyawan']} | ${value['designation_name']}| ${value['company']}</option>`;
            })
            $("#karyawan").empty().html(res);
            slim_karyawan = new SlimSelect({
                select: "#karyawan",
                settings: {
                    allowDeselect: true
                }
            });
        });
    }

    function list_job(id) {
        $('#modal_list').modal('show');
        $('[name="id_pk_list"]').val(id)
        $('#modal_list_dokumen').text('List Job ' + id);
        get_job(id, 1)

    }

    function get_job(id, type) {
        url = "<?= base_url('work_on_holiday/get_list_job/') ?>" + id;
        if (type == 1) {

            $.getJSON(url, function(result) {
                card = '';
                var i = 1;
                $.each(result, function(index, value) {
                    if (value.verified_status == 0) {
                        var note_display = ``;
                    } else {
                        var note_display = `<div class="row mb-2">
                            <div class="col">
                                <p class="text-secondary small">${value.status_verif} | Note Owner : ${value.verified_note}</p>
                            </div>
                        </div>`;
                    }
                    card += `<div class="col-lg-4 mb-3" id="card_wrapper_${value.id}">
                                <div class="card p-3" style="background-color:${value.status == 1 ? '#FFF2C6' : '#E7F0ED'}">
                                    <div class="row mb-1">
                                        <div class="col">
                                            <h6 class="text-primary fw-bold"><span class="bi bi-card-checklist"></span> ${value.job}</h6>

                                        </div>
                                        </div>
                                    <div class="row ">
                                        <div class="col">
                                        <p class="text-secondary small">${value.status_desc}</p>
                                        </div>
                                        </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                        <p class="text-secondary small">${value.updated_at}</p>
                                        
                                        </div>
    
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <fieldset class="form-group border p-1 bg-light-yellow">
                                                <legend class="form-label-custom required small" for="status">Status <span class="text-danger">*</span></legend>
                                                <select name="status" id="status${value.id}" ${value.status == 3 ? 'disabled' : ''} class="form-control border-custom">
                                                    <option value="" disabled selected>-- Pilih Status --</option>
                                                    <option value="2">Progres</option>
                                                    <option value="3">Selesai</option>
                                                </select>
                                                <!-- </div> -->
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <fieldset class="form-group border p-1 bg-light-yellow">
                                                <legend class="form-label-custom required small">File</legend>
                                                <input type="file" class="form-control border-custom" ${value.status == 3 ? 'disabled' : ''} name="file" id="file${value.id}" onchange="display_upload('file${value.id}')" value="">
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <label class="form-label-custom required small">Note</label>
                                            <input type="text" class="form-control border-custom" ${value.status == 3 ? 'disabled' : ''} name="note" id="note${value.id}" value="${value.note}">
                                        </div>
                                    </div>
                                    ${note_display}
                                    
                                    <div class="row">
                                        <div class="col">
                                            <button type="button" class="btn btn-sm btn-primary" ${value.status == 3 ? 'disabled' : ''} id="btn_list_updt${value.id}" onclick="update_progress('${value.id}','${value.id_pk}')"><li class="fa fa-check"></li> Update</button>
                                        </div>
                                        <div class="col pl-0">
                                        <hr>
                                        </div>
                                    </div>
                                </div>
                            </div>`;

                })
                $('#joblist').empty().html(card);

            });
        } else {
            $.getJSON(url, function(result) {
                card = '';
                var i = 1;
                $.each(result, function(index, value) {
                    card += `<div class="col-lg-4 mb-3" id="card_wrapper_app_${value.id}">
                                <div class="card p-3" style="background-color:${value.status == 1 ? '#FFF2C6' : '#E7F0ED'}">
                                    <div class="row mb-1">
                                        <div class="col">
                                            <h6 class="text-primary fw-bold"><span class="bi bi-card-checklist"></span> ${value.job}</h6>

                                        </div>
                                        </div>
                                    <div class="row ">
                                        <div class="col">
                                        <span class="badge bg-primary">${value.status_desc}</span>
                                        <a href="<?= base_url('uploads/work_on_holiday/') ?>${value.file}" 
                                        ${value.file ? value.file.match(/\.(jpeg|jpg|gif|png)$/) ? `data-fancybox data-lightbox="1" data-caption=""` : '' : ''}
        >${value.file == null ? '<span class="badge bg-danger">' : '<span class="badge bg-primary" style="cursor:pointer">'}<i class="fa fa-file"></i> File</span></a>
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                        <p class="text-secondary small">${value.updated_at}</p>
                                        
                                        </div>
    
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <fieldset class="form-group border p-1 bg-light-yellow">
                                                <legend class="form-label-custom required small" for="status">Verify <span class="text-danger">*</span></legend>
                                                <select name="status" id="verif_status${value.id}" ${value.verified_status == 0 ? '' : 'disabled'} class="form-control border-custom">
                                                    <option value="" disabled selected>-- Pilih Status --</option>
                                                    <option value="1">Revisi</option>
                                                    <option value="2">Approve</option>
                                                </select>
                                                <!-- </div> -->
                                            </fieldset>
                                        </div>
                                    </div>
                                   
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label class="form-label-custom required small">Note</label>
                                            <input type="text" class="form-control border-custom" ${value.verified_status == 0 ? '' : 'disabled'} name="note" id="verif_note${value.id}" value="${value.verified_note}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <button type="button" class="btn btn-sm btn-primary" ${value.verified_status == 0 ? '' : 'disabled'} id="btn_list_approval${value.id}" onclick="update_verif('${value.id}','${value.id_pk}')"><li class="fa fa-check"></li> Update</button>
                                        </div>
                                        <div class="col pl-0">
                                        <hr>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                })
                $('#joblist_app').empty().html(card);

            });
        }
    }

    function refresh_single_card(id, id_pk) {
        var url = "<?= base_url('work_on_holiday/get_list_job/') ?>" + id_pk;
        $.getJSON(url, function(result) {
            var value = result.find(function(v) { return v.id == id; });
            if (!value) return;

            var note_display = ``;
            if (value.verified_status != 0) {
                note_display = `<div class="row mb-2">
                    <div class="col">
                        <p class="text-secondary small">${value.status_verif} | Note Owner : ${value.verified_note}</p>
                    </div>
                </div>`;
            }

            var card = `<div class="col-lg-4 mb-3" id="card_wrapper_${value.id}">
                            <div class="card p-3" style="background-color:${value.status == 1 ? '#FFF2C6' : '#E7F0ED'}">
                                <div class="row mb-1">
                                    <div class="col">
                                        <h6 class="text-primary fw-bold"><span class="bi bi-card-checklist"></span> ${value.job}</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <p class="text-secondary small">${value.status_desc}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <p class="text-secondary small">${value.updated_at}</p>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <fieldset class="form-group border p-1 bg-light-yellow">
                                            <legend class="form-label-custom required small" for="status">Status <span class="text-danger">*</span></legend>
                                            <select name="status" id="status${value.id}" ${value.status == 3 ? 'disabled' : ''} class="form-control border-custom">
                                                <option value="" disabled selected>-- Pilih Status --</option>
                                                <option value="2">Progres</option>
                                                <option value="3">Selesai</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <fieldset class="form-group border p-1 bg-light-yellow">
                                            <legend class="form-label-custom required small">File</legend>
                                            <input type="file" class="form-control border-custom" ${value.status == 3 ? 'disabled' : ''} name="file" id="file${value.id}" onchange="display_upload('file${value.id}')" value="">
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label class="form-label-custom required small">Note</label>
                                        <input type="text" class="form-control border-custom" ${value.status == 3 ? 'disabled' : ''} name="note" id="note${value.id}" value="${value.note}">
                                    </div>
                                </div>
                                ${note_display}
                                <div class="row">
                                    <div class="col">
                                        <button type="button" class="btn btn-sm btn-primary" ${value.status == 3 ? 'disabled' : ''} id="btn_list_updt${value.id}" onclick="update_progress('${value.id}','${value.id_pk}')"><li class="fa fa-check"></li> Update</button>
                                    </div>
                                    <div class="col pl-0"><hr></div>
                                </div>
                            </div>
                        </div>`;

            $('#card_wrapper_' + id).replaceWith(card);
        });
    }

    function refresh_single_card_app(id, id_pk) {
        var url = "<?= base_url('work_on_holiday/get_list_job/') ?>" + id_pk;
        $.getJSON(url, function(result) {
            var value = result.find(function(v) { return v.id == id; });
            if (!value) return;

            var card = `<div class="col-lg-4 mb-3" id="card_wrapper_app_${value.id}">
                            <div class="card p-3" style="background-color:${value.status == 1 ? '#FFF2C6' : '#E7F0ED'}">
                                <div class="row mb-1">
                                    <div class="col">
                                        <h6 class="text-primary fw-bold"><span class="bi bi-card-checklist"></span> ${value.job}</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <span class="badge bg-primary">${value.status_desc}</span>
                                        <a href="<?= base_url('uploads/work_on_holiday/') ?>${value.file}"
                                        ${value.file ? value.file.match(/\.(jpeg|jpg|gif|png)$/) ? `data-fancybox data-lightbox="1" data-caption=""` : '' : ''}
                                        >${value.file == null ? '<span class="badge bg-danger">' : '<span class="badge bg-primary" style="cursor:pointer">'}<i class="fa fa-file"></i> File</span></a>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <p class="text-secondary small">${value.updated_at}</p>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <fieldset class="form-group border p-1 bg-light-yellow">
                                            <legend class="form-label-custom required small" for="status">Verify <span class="text-danger">*</span></legend>
                                            <select name="status" id="verif_status${value.id}" ${value.verified_status == 0 ? '' : 'disabled'} class="form-control border-custom">
                                                <option value="" disabled selected>-- Pilih Status --</option>
                                                <option value="1">Revisi</option>
                                                <option value="2">Approve</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label-custom required small">Note</label>
                                        <input type="text" class="form-control border-custom" ${value.verified_status == 0 ? '' : 'disabled'} name="note" id="verif_note${value.id}" value="${value.verified_note}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <button type="button" class="btn btn-sm btn-primary" ${value.verified_status == 0 ? '' : 'disabled'} id="btn_list_approval${value.id}" onclick="update_verif('${value.id}','${value.id_pk}')"><li class="fa fa-check"></li> Update</button>
                                    </div>
                                    <div class="col pl-0"><hr></div>
                                </div>
                            </div>
                        </div>`;

            $('#card_wrapper_app_' + id).replaceWith(card);
        });
    }

    function hapus(id_pk) {
    $.confirm({
        icon: 'fa fa-trash',
        title: 'Konfirmasi Hapus',
        theme: 'material',
        type: 'red',
        content: 'Anda yakin ingin menghapus PK <b>' + id_pk + '</b>? Data pada pk_job dan pk_job_item akan ikut terhapus.',
        buttons: {
            confirm: {
                text: 'Hapus',
                btnClass: 'btn-danger',
                action: function() {
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('work_on_holiday/hapus_pk/'); ?>" + id_pk,
                        dataType: "json",
                        success: function(response) {
                            jconfirm.instances[0].close();
                            if (response.status == 'success') {
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Berhasil',
                                    theme: 'material',
                                    type: 'green',
                                    content: response.message,
                                    buttons: {
                                        close: { actions: function() {} }
                                    },
                                });
                                // Reload datatable
                                var start = $('input[name="startdate"]').val();
                                var end   = $('input[name="enddate"]').val();
                                dt_pk(start, end);
                            } else {
                                $.confirm({
                                    icon: 'fa fa-times',
                                    title: 'Gagal',
                                    theme: 'material',
                                    type: 'red',
                                    content: response.message,
                                    buttons: {
                                        close: { actions: function() {} }
                                    },
                                });
                            }
                        },
                        error: function() {
                            $.confirm({
                                icon: 'fa fa-times',
                                title: 'Error',
                                theme: 'material',
                                type: 'red',
                                content: 'Terjadi kesalahan, coba lagi.',
                                buttons: {
                                    close: { actions: function() {} }
                                },
                            });
                        }
                    });
                }
            },
            batal: {
                text: 'Batal',
                action: function() {}
            }
        },
    });
}




    function display_upload(id) {
        var upload_status = $('<small class="uploadStatus"><i class="fa fa-spinner fa-pulse"></i> Uploading...</small>');
        $('#' + id).after(upload_status);

        // Delay 2 detik sebelum menampilkan pesan sukses
        setTimeout(function() {
            // Menghapus teks 'Uploading...'
            // $('#' + id).remove();
            // Menampilkan pesan sukses
            upload_status.html('<i class="fa fa-check-circle text-success"></i> File has been Uploaded').delay(4000).fadeOut();
        }, 2000);
    }
    $('#file_input').change(function() {
        // Menampilkan teks 'Uploading...' setelah elemen input file

    });

    let note = $('#note').summernote({
        placeholder: 'Input here...',
        tabsize: 10,
        height: 100,
        toolbar: false
    });
    note.summernote('code', '');

    var jum_list = 1;

    function tambah_list() {
        jum_list++;
        $('#btn_hapus_list').attr('disabled', false);
        input = `<div class="row row_list" id="row_list${jum_list}">
    <div class="col"><div class="input-group border-custom mb-2">
                                <span class="input-group-text bi bi-card-checklist"></span>

                                <input type="text" class="form-control border-custom key_list" name="list_job[]" id="list_job${jum_list}"
                                    placeholder="List Pekerjaan ${jum_list}"
                                    >
                                    
                                    </div></div></div>`;
        $('#tempat_list').append(input);

        setTimeout(() => {
            $(`#list_job${jum_list}`).focus();
        }, 100);

    }

    function hapus_list() {
        if (jum_list == 1) {
            $('#btn_hapus_list').attr('disabled', true);
        } else {
            $('#btn_hapus_list').attr('disabled', false);
            $('#row_list' + jum_list).remove();
            jum_list--;
        }
    }
    var lastClickTime = 0;

    function save() {
        var karyawan = $('#karyawan').val();
        var validate = [];
        var list_job = [];
        var currentTime = new Date().getTime();
        if (currentTime - lastClickTime < 300) {
            alert('Anda menekan 2x tombol save, coba lagi');
            lastClickTime = currentTime; // Reset waktu klik terakhir setelah mendeteksi double click
            return; // Hentikan eksekusi lebih lanjut jika double click terdeteksi
        }
        lastClickTime = currentTime;
        $("input[name='list_job[]']").each(function() {
            var value = $(this).val();
            if (value) {
                list_job.push(value);
            }
        });
        if (karyawan == '-- Pilih Karyawan --'|| karyawan == '') {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Anda belum memilih karyawan!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        }

        validate.push(validation_input('#list_job', 'list_job', 'list'));
        // validate.push(validation_input('#karyawan', 'karyawan', 'select'));
        validate.push(validation_input('#tgl_masuk', 'tgl_masuk', 'text'));
        // validate.push(validation_input('#note','note','text'));
        if (containsAllFalse(validate) == true) {
            if (karyawan == '-- Pilih Karyawan --' || karyawan == '') {
                $.confirm({
                    icon: 'fa fa-close',
                    title: 'Warning',
                    theme: 'material',
                    type: 'red',
                    content: 'Anda belum memilih karyawan!',
                    buttons: {
                        close: {
                            actions: function() {}
                        },
                    },
                });
            } else {
                var id = $('#karyawan').val();
                var tgl = $('#tgl_masuk').val();
                var note = $('#note').val();
                var list_job = [];
                $("input[name='list_job[]']").each(function() {
                    var value = $(this).val();
                    if (value) {
                        list_job.push(value);
                    }
                });
                $.confirm({
                    icon: 'fa fa-check',
                    title: 'Warning',
                    theme: 'material',
                    type: 'blue',
                    content: 'Apakah data tersebut benar?',
                    buttons: {
                        confirm: function() {
                            $.ajax({
                                type: "POST",
                                url: "<?= base_url('work_on_holiday/save'); ?>",
                                data: {
                                    // id: id, // id_user
                                    list_karyawan: id, // id_user
                                    tgl: tgl,
                                    note: note,
                                    list_job: list_job
                                },
                                dataType: "json",
                                success: function(response) {
                                    for (var i = jum_list; i > 1; i--) {

                                        $('#row_list' + i).remove();
                                        jum_list--;
                                    }
                                    let note = $('#note').summernote({
                                        placeholder: 'Input here...',
                                        tabsize: 10,
                                        height: 100,
                                        toolbar: false
                                    });
                                    note.summernote('code', '');
                                    $('#karyawan').val('');
                                    $('[name="tgl_masuk"]').val('');
                                    $('[name="list_job"]').val('');
                                    $('#modal_input').modal('hide');
                                    $("#dt_pk").DataTable().ajax.reload();
                                    jconfirm.instances[0].close();
                                    $.confirm({
                                        icon: 'fa fa-check',
                                        title: 'Success',
                                        theme: 'material',
                                        type: 'green',
                                        content: 'Data has been saved!',
                                        buttons: {
                                            close: {
                                                actions: function() {}
                                            },
                                        },
                                    });
                                }
                            });
                        },
                        close: {
                            actions: function() {
                                // $('#modal_input').modal('hide');
                                // $("#dt-pk").DataTable().ajax.reload();
                                jconfirm.instances[0].close();
                            }
                        },
                    },

                });
            }




        }

    }

    function update_progress(id, id_pk) {
        var status = $('#status' + id).val();
        var note = $('#note' + id).val();
        var fileInput = document.getElementById('file' + id);
        var file = fileInput.files[0]; // Get the first file

        if (status == undefined) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Anda belum memilih status!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else {

            $.confirm({
                icon: 'fa fa-check',
                title: 'Warning',
                theme: 'material',
                type: 'blue',
                content: 'Apakah data tersebut benar?',
                buttons: {
                    confirm: function() {
                        $(`#btn_list_updt${id}`).html('<i class="fa fa-spinner fa-spin"></i> Loading');
                        var formData = new FormData();
                        formData.append('id', id);
                        formData.append('status', status);
                        formData.append('note', note);
                        formData.append('file', file);
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url('work_on_holiday/update_progres'); ?>",
                            data: formData,
                            contentType: false, // Not to set any content type header
                            processData: false, // Not to process data
                            dataType: "json",
                            success: function(response) {
                                console.log(response);
                                refresh_single_card(id, id_pk);
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Success',
                                    theme: 'material',
                                    type: 'green',
                                    content: 'Data has been saved!',
                                    buttons: {
                                        close: {
                                            actions: function() {}
                                        },
                                    },
                                });
                            }
                        });
                    },
                    close: {
                        actions: function() {
                            // $('#modal_input').modal('hide');
                            // $("#dt-pk").DataTable().ajax.reload();
                            jconfirm.instances[0].close();
                        }
                    },
                },

            });
        }
    }

    function update_verif(id, id_pk) {
        var status = $('#verif_status' + id).val();
        var note = $('#verif_note' + id).val();
        console.log(status);

        if (status == undefined) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Anda belum memilih status!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else {

            $.confirm({
                icon: 'fa fa-check',
                title: 'Warning',
                theme: 'material',
                type: 'blue',
                content: 'Apakah data tersebut benar?',
                buttons: {
                    confirm: function() {
                        $(`#btn_list_approval${id}`).html('<i class="fa fa-spinner fa-spin"></i> Loading');
                        var formData = new FormData();
                        formData.append('id', id);
                        formData.append('status', status);
                        formData.append('note', note);
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url('work_on_holiday/update_verif'); ?>",
                            data: formData,
                            contentType: false,
                            processData: false,
                            dataType: "json",
                            success: function(response) {
                                console.log(response);
                                refresh_single_card_app(id, id_pk);
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Success',
                                    theme: 'material',
                                    type: 'green',
                                    content: 'Data has been saved!',
                                    buttons: {
                                        close: {
                                            actions: function() {}
                                        },
                                    },
                                });
                            }
                        });
                    },
                    close: {
                        actions: function() {
                            jconfirm.instances[0].close();
                        }
                    },
                },

            });
        }
    }

    function approval() {
        start = $('input[name="startdate"]').val();
        end = $('input[name="enddate"]').val();
        $('#modal_approval').modal('show');
        $('#dt_approval').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
            ],
            buttons: [{
                title: 'Data Work on Holiday',
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": "<?= base_url(); ?>work_on_holiday/get_approval/"+start+"/"+end,

            },
            "columns": [

                {
                    'data': 'id_pk',
                },
                {
                    'data': 'pic',
                },
                {
                    'data': 'jumlah_job',
                },
                {
                    'data': 'jumlah_done',
                },

                {
                    'data': 'id_pk',
                    'render': function(data, type, row, meta) {
                        return `<a onclick="list_detail('${data}','${row['pic']}')"><span class="badge bg-primary" style="cursor:pointer"><li class="fa fa-eye"></li> List Job</span></a>`;
                    }
                }

            ],
            // "createdRow": function(row, data, dataIndex) {
            //     // 
            // }
        });
    }

    function list_detail(id_pk, pic) {
        $('#modal_approval').modal('hide');
        $('#modal_list_app').modal('show');
        $('#pic_app').text(pic);
        get_job(id_pk, 2);

    }

    function send_notif() {
        var id = $('[name="id_pk_list"]').val();
        $.confirm({
            icon: 'fa fa-check',
            title: 'Warning',
            theme: 'material',
            type: 'blue',
            content: 'Anda yakin akan melanjutkan proses?',
            buttons: {
                confirm: function() {
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('work_on_holiday/send_notif_approval/'); ?>" + id,
                        dataType: "json",
                        success: function(response) {
                            console.log(response);
                            get_job(id_pk);
                            $('#btn_save_notif').attr('disabled', true);
                            jconfirm.instances[0].close();
                            $.confirm({
                                icon: 'fa fa-check',
                                title: 'Success',
                                theme: 'material',
                                type: 'green',
                                content: 'Data has been saved!',
                                buttons: {
                                    close: {
                                        actions: function() {}
                                    },
                                },
                            });
                        }
                    });
                },
                close: {
                    actions: function() {
                        // $('#modal_input').modal('hide');
                        // $("#dt-pk").DataTable().ajax.reload();
                        jconfirm.instances[0].close();
                    }
                },
            },

        });
    }

    function handleClick() {
        var currentTime = new Date().getTime(); // Mendapatkan waktu saat ini
        var timeDiff = currentTime - lastClickTime; // Menghitung selisih waktu dari klik terakhir
        lastClickTime = currentTime; // Memperbarui waktu klik terakhir

        if (timeDiff < threshold) {
            return true; // Mengembalikan true jika terdeteksi double click
        } else {
            return false; // Mengembalikan false jika tidak terdeteksi double click
        }
    }



    function containsAllFalse(array) {
        for (let i = 0; i < array.length; i++) {
            if (array[i] !== false) {
                return false;
            }
        }
        return true;
    }

    function validation_input(id, input, type) {

        if (type == 'select') {
            if ($('[name="' + input + '"]').val() == null || $('[name="' + input + '"]').val() == '-- Pilih Karyawan --') {
                $(id).before(
                    '<small class="text-danger ' + input +
                    '-invalid"><li class="fa fa-info-circle"></li> Please provide a valid select.</small>'
                );
                $('.' + input + '-invalid').delay(4000);
                $('.' + input + '-invalid').fadeOut();

                return true;

            } else {
                $('.' + input + '-invalid').remove();
                return false;
            }

        } else if (type == 'text') {
            if ($('[name="' + input + '"]').val() == null || $('[name="' + input + '"]').val() == '') {
                $(id).after(
                    '<small class="text-danger ' + input +
                    '-invalid"><li class="fa fa-info-circle"></li> Please provide a valid input.</small>'
                ).fadeIn();
                $('.' + input + '-invalid').delay(4000);
                $('.' + input + '-invalid').fadeOut();

                return true;
            } else {
                $('.' + input + '-invalid').remove();
                return false;
            }
        } else if (type == 'list') {
            if ($(id).val() == null || $(id).val() == '') {
                $(id).after(
                    '<small class="text-danger ' + input +
                    '-invalid"><li class="fa fa-info-circle"></li> Please provide a valid input.</small>'
                ).fadeIn();
                $('.' + input + '-invalid').delay(4000);
                $('.' + input + '-invalid').fadeOut();

                return true;
            } else {
                $('.' + input + '-invalid').remove();
                return false;
            }
        } else if (type == 'file') {
            if ($('[name="' + input + '"]').val() == null || $('[name="' + input + '"]').val() == '' || $('[name="' +
                    input + '"]').val() < 1) {
                $(id).after(
                    '<small class="text-danger ' + input +
                    '-invalid"><li class="fa fa-info-circle"></li> Please provide a valid file.</small>'
                ).fadeIn();
                $('.' + input + '-invalid').delay(4000);
                $('.' + input + '-invalid').fadeOut();

                return true;
            } else {
                $('.' + input + '-invalid').remove();
                return false;
            }
        } else {
            return false;

        }
    }
</script>