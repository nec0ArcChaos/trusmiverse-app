<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>
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

        // Datepicker
        var start = moment().startOf('week');
        var end = moment().endOf('week');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="startdate"]').val(start.format('YYYY-MM-DD'));
            $('input[name="enddate"]').val(end.format('YYYY-MM-DD'));
            get_candidates(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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
        $('#btn_filter').on('click', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            get_candidates(start, end);

        });
        $('.range').on('change', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            get_candidates(start, end);
        })
        // Job Desc Text_Area
        $('#job_desc').summernote({
            placeholder: 'Job Description',
            tabsize: 2,
            height: 217,
            width: 440,
            toolbar: [
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
            ]
        });
    });

    function get_candidates(start, end) {
        jc_job_id = $('#jc_job_id').val();
        $('#dt_jc').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
            ],
            buttons: [{
                title: 'List Job Candidates',
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "method": "POST",
                "url": "<?= base_url(); ?>recruitment/job_candidates/get_candidates",
                "data": {
                    start: start,
                    end: end,
                    id: jc_job_id
                }
            },
            "columns": [{
                    'data': 'application_id',
                    'render': function(data, type, row) {
                        download = `<a onclick="open_resume('` + row['job_resume'] + `','` + row['full_name'] + `')"><button type = "button" class = "btn btn-primary btn-sm m-b-0-0 waves-effect waves-light"> <i class = "bi bi-download" ></i></button > </a>`;
                        edit = `<a onclick="show_edit_modal(` + data + `,` + row['application_status'] + `)"><button type = "button" class = "btn btn-success btn-sm m-b-0-0 waves-effect waves-light"> <i class = "bi bi-pencil-square" style = "color:white;"></i></button > </a>`;
                        delete_xja = `<a onclick="delete_jc(` + data + `)"><button type = "button" class = "btn btn-danger btn-sm m-b-0-0 waves-effect waves-light"> <i class = "bi bi-trash3" style = "color:white;" ></i></button > </a>`;
                        if (row['application_status'] == 0 || row['application_status'] == 1 || row['application_status'] == 2 || row['application_status'] == 10) {
                            action = `${download} ${edit} ${delete_xja}`;
                        } else {
                            action = `${download} ${delete_xja}`;
                        }
                        return action;
                    }
                },
                {
                    'data': 'application_status',
                    'render': function(data, type, row) {
                        status = '';
                        if (data == 0) {
                            $status = '<span class="badge bg-yellow">Waiting</span>';
                        } else if (data == 1) {
                            $status = '<span class="badge bg-primary">Psikotes</span>';
                        } else if (data == 2) {
                            $status = '<span class="badge bg-danger">Lamaran Ditolak</span>';
                        } else if (data == 3) {
                            $status = '<span class="badge" style="background-color: #00BCD4;">Interview User</span>';
                        } else if (data == 4) {
                            $status = '<span class="badge" style="background-color: #FF5722;">Gagal Psikotes</span>';
                        } else if (data == 5) {
                            $status = '<span class="badge" style="background-color: #795548;">Administrasi</span>';
                        } else if (data == 6) {
                            $status = '<span class="badge" style="background-color: #4CAF50;">Gagal Interview</span>';
                        } else if (data == 7) {
                            $status = '<span class="badge" style="background-color: #7986CB;">Lengkap / Diterima</span>';
                        } else if (data == 8) {
                            $status = '<span class="badge" style="background-color: #E91E63;">Tidak Lengkap / Ditolak</span>';
                        } else if (data == 10) {
                            $status = '<span class="badge" style="background-color: #0086A2;">Interview HR</span>';
                        }
                        return $status
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'application_id',
                    'render': function(data, type, row) {
                        download = `<a onclick="cover_letter('` + data + `')"><button type = "button" class = "btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"> <i class = "bi bi-envelope-at-fill" ></i></button > </a>`;
                        return download;
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'company_name',
                },
                {
                    'data': 'category_name',
                },
                {
                    'data': 'job_title',
                },
                {
                    'data': 'role_name',
                },
                {
                    'data': 'full_name',

                },
                {
                    'data': 'gender',
                },
                {
                    'data': 'contact',
                },
                {
                    'data': 'email',
                },
                {
                    'data': 'age',
                },
                {
                    'data': 'domisili',
                },
                {
                    'data': 'pendidikan',
                },
                {
                    'data': 'jurusan',
                },
                {
                    'data': 'tempat_pendidikan',
                },
                {
                    'data': 'posisi_kerja_terakhir',
                },
                {
                    'data': 'tempat_kerja_terakhir',
                },
                {
                    'data': 'masa_kerja_terakhir',
                },
                {
                    'data': 'salary',
                },
                {
                    'data': 'informasi',
                },
                {
                    'data': 'question',
                },
                {
                    'data': 'created_at',
                }
            ],
        });
    }

    function cover_letter(id) {
        $.ajax({
            url: "<?= base_url('recruitment/job_candidates/cover_letter') ?>",
            method: "POST",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function(res) {
                console.log(res);
                $('#cover_leter_title').text('Cover Letter For ' + res.cover_letter['job_title']);
                $('#modal_cover_letter .modal-body').html(res.cover_letter['message']);
                $('#modal_cover_letter').modal('show');
            }
        })
    }

    function open_resume(url, name) {
        // console.log(url);
        window.open(url, '_blank');
        // $.confirm({
        //     icon: 'fa fa-spinner fa-spin',
        //     title: 'Please Wait!',
        //     theme: 'material',
        //     type: 'blue',
        //     content: 'Refresh the  page or download the CV, if there is a problem to view the CV',
        //     buttons: {
        //         close: {
        //             isHidden: true,
        //             actions: function() {}
        //         },
        //     },
        //     onOpen: function() {
        //         setTimeout(function() {
        //             // var randomString = Math.random().toString(36).substring(2, 15);
        //             // var proxyUrl = 'https://docs.google.com/viewer?url=' + encodeURIComponent(url) + '&embedded=true&rand=' + randomString;
        //             // window.open(proxyUrl);
        //             // var downloadLink = document.createElement('a');
        //             // downloadLink.href = url;
        //             // downloadLink.download = `CV_` + name + `.pdf`; // Optional: specify a filename if desired
        //             // document.body.appendChild(downloadLink);
        //             // downloadLink.click();
        //             // document.body.removeChild(downloadLink);
        //             // jconfirm.instances[0].close();
        //         }, 2000);
        //     }
        // });
    }

    function show_edit_modal(id, app_status) {
        $('#btn_save_status').removeAttr('disabled');
        let status = '';
        status = `<option value = "0">Waiting</option><option value = "10">Interview HR</option><option value = "2">Tolak Lamaran</option>`;
        $('#select_status').html(status);
        $('#select_status').val(app_status);
        select_status.update();
        $('#job_id').val(id);
        $('#modal_edit_status').modal('show');
    }

    function updateKeterangan() {
        $("#alasan").hide();
        
        if ($("#select_status").val() == 2 && <?= $_SESSION['user_id'] ?> == 1) {
            $("#alasan").show();
            console.log('Alasan WOOOY Gagan Join');
        }
    }

    function save_status() 
    {
        job_id = $('#job_id').val();
        status = $('#select_status').val();
        alasan = $('#select_alasan').val();

        $.ajax({
            url: "<?= base_url('recruitment/job_candidates/save_status') ?>",
            method: "POST",
            data: {
                alasan: alasan,
                status: status,
                id: job_id
            },
            dataType: "JSON",
            beforeSend: function() {
                $('#btn_save_status').attr('disabled', true);
            },
            success: function(res) {
                if (res.update == true) {
                    success_alert('Berhasil mengubah status');
                    $('#dt_jc').DataTable().ajax.reload();
                    $('#modal_edit_status').modal('hide');
                } else {
                    $('#btn_save_status').removeAttr('disabled');
                    error_alert('Gagal mengubah status');
                }
            },
            error: function(res) {
                console.log(res.responseText);
            }
        })
    }

    function delete_jc(id) {
        $.confirm({
            title: 'Delete Job Candidates',
            content: 'Job Candidates will be deleted',
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
                                    url: "<?= base_url('recruitment/job_candidates/delete_jc') ?>",
                                    method: "POST",
                                    data: {
                                        id: id
                                    },
                                    dataType: "JSON",
                                    beforeSend: function() {},
                                    success: function(response) {},
                                    error: function(xhr) {},
                                    complete: function() {},
                                }).done(function(response) {
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
                                    $('#dt_jc').DataTable().ajax.reload();
                                }).fail(function(jqXHR) {
                                    jconfirm.instances[0].close();
                                    $.confirm({
                                        icon: 'fa fa-close',
                                        title: 'Oops!',
                                        theme: 'material',
                                        type: 'red',
                                        content: 'Failed to delete job candidates',
                                        buttons: {
                                            close: {
                                                actions: function() {}
                                            },
                                        },
                                    });
                                });
                            },

                        });
                    }
                },
                cancel: function() {}
            }
        });
    }
    // Start Nice Select
    let select_status = NiceSelect.bind(document.getElementById('select_status'), {
        searchable: true,
        isAjax: false,
    });
    //End Nice Select 
    function error_alert(text) {
        new PNotify({
            title: `Oopss`,
            text: `${text}`,
            icon: 'icofont icofont-info-circle',
            type: 'error',
            delay: 1500,
        });
    }

    function success_alert(text) {
        textMsg = text == null ? '' : text;
        new PNotify({
            title: `Success`,
            text: `${textMsg}`,
            icon: 'icofont icofont-checked',
            type: 'success',
            delay: 2000,
        });
    }
</script>