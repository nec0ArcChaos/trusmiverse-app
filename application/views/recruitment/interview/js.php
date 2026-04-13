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

        function cb2(start, end) {
            $('.reportrange2 input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="startdate2"]').val(start.format('YYYY-MM-DD'));
            $('input[name="enddate2"]').val(end.format('YYYY-MM-DD'));
        }

        $('.range2').daterangepicker({
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
        }, cb2);

        cb2(start, end);

        get_candidates('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>', 5, 'dt_li');
        get_candidates('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>', 6, 'dt_gi');
        
        $('#btn_filter').on('click', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            get_candidates(start, end, 5, 'dt_li');
            get_candidates(start, end, 6, 'dt_gi');

        });
        $('.range').on('change', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            get_candidates(start, end, 5, 'dt_li');
            get_candidates(start, end, 6, 'dt_gi');
        });

        $('#btn_filter2').on('click', function() {
            start = $('input[name="startdate2"]').val();
            end = $('input[name="enddate2"]').val();
            get_candidates(start, end, 3, 'dt_di');

        });
        $('.range2').on('change', function() {
            start = $('input[name="startdate2"]').val();
            end = $('input[name="enddate2"]').val();
            get_candidates(start, end, 3, 'dt_di');
        });
        
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

    function get_candidates(start, end, status, table) {
        $('#' + table).DataTable({
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
                "url": "<?= base_url(); ?>recruitment/interview/get_candidates",
                "data": {
                    start: start,
                    end: end,
                    id: status
                }
            },
            "columns": [{
                    'data': 'application_id',
                    'render': function(data, type, row) {
                        edit = `<a onclick="show_edit_modal('${data}', '${row['application_status']}', '${row['job_id_before']}', '${row['category_name']}', '${row['job_title']}')" title="Edit Psikotes">
                            <button type="button" class="btn btn-info btn-sm m-b-0-0 waves-effect waves-light">
                                <i class="bi bi-pencil-square" style="color:white;"></i>
                            </button>
                        </a>`;

                        detail = `<a onclick="detail_psikotes(` + data + `,` + row['application_status'] + `)" title = "Detail Psikotes"><button type = "button" class = "btn btn-success btn-sm m-b-0-0 waves-effect waves-light"> <i class = "bi bi-eye" style = "color:white;" ></i></button > </a>`;
                        if (row['application_status'] == 3) {
                            action = `${edit}`;
                        } else {
                            action = `${edit} ${detail}`;
                        }
                        return action;
                    }
                },
                {
                    'data': 'application_id',
                    'render': function(data, type, row) {
                        if (row['category_name'] != null) {
                            position = `${row['job_title']}<br><span class = "text-muted fs-9">${row['category_name']}</span>`;
                        } else {
                            position = `${row['job_title']}`;
                        }
                        return position;
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'full_name',
                },
                {
                    'data': 'contact',
                },
                {
                    'data': 'email',
                },
                {
                    'data': 'application_status',
                    'render': function(data, type, row) {
                        status = '';
                        if (data == 3) {
                            status = '<span class="badge bg-primary">' + row['status_hasil'] + '</span>';
                        } else if (data == 6) {
                            status = '<span class="badge bg-danger">' + row['status_hasil'] + '</span>';
                        } else if (data == 5) {
                            status = '<span class="badge bg-warning">' + row['status_hasil'] + '</span>';
                        }
                        return status
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'created_at',
                },
                {
                    'data': 'status_interview',
                    'render': function(data, type, row) {
                        if (data == 1) {
                            return '<span class="badge bg-success">Approved</span>';
                        } else if (data == 0){
                            return '<span class="badge bg-danger">Rejected</span>';
                        } else {
                            return ''
                        }
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'tgl_interview',
                },
                {
                    'data': 'jam_interview',
                },
                {
                    'data': 'lokasi_interview',
                },
                {
                    'data': 'alasan_interview',
                },
                {
                    'data': 'is_lolos',
                    'render': function(data, type, row) {
                        if (data == 1) {
                            return '<span class="badge bg-success">Lolos</span>';
                        } else if (data == 0){
                            return '<span class="badge bg-danger">Gagal</span>';
                        } else {
                            return ''
                        }
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'hasil_interview',
                }
            ],
        });
    }

    function detail_psikotes(id, status_psi) {
        $.ajax({
            url: "<?= base_url('recruitment/psikotes/detail_psikotes') ?>",
            method: "POST",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function(res) {
                console.log(res);
                $('#modal_detail_peserta').modal('show');
                if (status_psi == 3) {
                    $('#modal_detail_peserta .modal-header').removeClass('bg-danger');
                    $('#modal_detail_peserta .modal-header').addClass('bg-primary');
                } else if (status_psi == 4) {
                    $('#modal_detail_peserta .modal-header').removeClass('bg-primary');
                    $('#modal_detail_peserta .modal-header').addClass('bg-danger');
                }
                $('#modal_detail_peserta #modal-title').text('Detail Peserta : ' + res.psikotes['full_name']);
                $('#detail_iq').text(res.psikotes['iq']);
                $('#detail_current').text(`(Current : ` + res.psikotes['disc1'] + `)`);
                $('#detail_presure').text(`(Presure : ` + res.psikotes['disc2'] + `)`);
                $('#detail_self').text(`(Self : ` + res.psikotes['disc3'] + `)`);
                $('#detail_ket').text(res.psikotes['keterangan']);

                $('#user_interview').text(res.psikotes['user_interview']);
                $('#keterangan_interview').text(res.psikotes['keterangan_interview']);
                // $('#cover_leter_title').text('Cover Letter For ' + res.cover_letter['job_title']);
                // $('#modal_cover_letter .modal-body').html(res.cover_letter['message']);
            }
        })
    }

    function open_resume(url) {
        var proxyUrl = 'https://docs.google.com/viewer?url=' + encodeURIComponent(url) + '&embedded=true';
        window.open(proxyUrl)
    }

    function show_edit_modal(id, app_status, job_id_before, category_name, job_title) {
        $('#modal_status').modal('show');

        $('input[name="application_id"]').val(id);
        $('input[name="job_id_before"]').val(job_id_before);
        $('input[name="application_status"]').val(app_status);

        status = app_status;

        get_loker(id, job_title);

        checkJobTitle(category_name, job_title);

        console.log('job title= '+job_title);

        if (category_name == 'Marketing' && job_title == 'Sales') {
            $('#cek_sales').val(1)
            $('#div_sales').show();
        } else {
            $('#cek_sales').val(0)
            $('#div_sales').hide();
        }
        $('select[name="job_id"]').val($(this).data('job_id')).trigger('change');
        
    }

    $('#modal_status').on('hidden.bs.modal', function() {
        $('input[name="application_id"]').val('');
        $('input[name="job_id_before"]').val('');
        $("#alasan").hide();
        $("#status").val('');
        $(this).trigger('reset');

        $('#cek_sales').val(0)
        $('#div_sales').hide();

        $('#type').val('#');
        $('#grade').val('#');
    });

    function get_loker(id, initialJobTitle) {
        $.ajax({
            url: "<?= base_url('recruitment/psikotes/get_loker') ?>",
            method: "POST",
            dataType: "JSON",
            success: function(res) {
                let loker = '<option value = "" disabled selected>--Pilih Loker--</option>';
                res.loker.forEach((value, index) => {
                    loker += `<option value="${value.job_id}" data-job-title="${value.job_title}">${value.loker}</option>`
                });
                $('#loker').html(loker);
                select_loker.update();
            },
            complete: function() {
                get_psikotes(id);

                // Check job title after populating the dropdown
                const selectedOption = $('#loker').find('option:selected');
                const jobTitle = selectedOption.data('job-title');
                handleJobTitleChange(initialJobTitle || jobTitle);
            }
        })

        // Add event listener for change event
        $('#loker').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const jobTitle = selectedOption.data('job-title');
            handleJobTitleChange(jobTitle);
        });
    }

    function checkJobTitle(category_name, job_title) {
        if (category_name === 'Marketing' && job_title === 'Sales') {
            $('#cek_sales').val(1);
            $('#div_sales').show();
        } else {
            $('#cek_sales').val(0);
            $('#div_sales').hide();
        }
    }

    function handleJobTitleChange(jobTitle) {
        if (jobTitle === 'Sales') {
            $('#cek_sales').val(1);
            $('#div_sales').show();
        } else {
            $('#cek_sales').val(0);
            $('#div_sales').hide();
        }
    }

    function get_psikotes(id) {
        $.ajax({
            url: "<?= base_url('recruitment/psikotes/get_psikotes') ?>",
            method: "POST",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function(res) {
                console.log(res);
                $('#app_id').val(res.psikotes['application_id']);
                $('#status_app').val(res.psikotes['application_status']);
                // $('#disc1').val(res.psikotes['disc1']);
                // $('#disc2').val(res.psikotes['disc2']);
                // $('#disc3').val(res.psikotes['disc3']);
                $('#loker').val(res.psikotes['job_id']);
                select_loker.update();
                $('#keterangan').text(res.psikotes['keterangan_interview']);
                $('#status').val(res.psikotes['application_status']);
                $('#user').val(res.psikotes['id_user_interview']);

                console.log('user int = ' + res.psikotes['id_user_interview']);
                $('#score').val(res.psikotes['iq']);
                $('#job_id_before').val(res.psikotes['job_id']);
                select_status.update();
                select_user.update();

            },
        })
    }

    function show_daftar_interview() {
        get_candidates('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>', 3, 'dt_di');
        $('#modal_daftar_interview').modal('show');
    }

    function save_status() {
        form = $('#form_status');
        var ket = $('#keterangan').val();
        var ket_length = ket.split(" ").length;
        if (ket_length < 10) {
            error_alert('Keterangan harus lebih dari 10 kata.');
            return;
        }

        if ( $("#status").val() == 6 && $("#select_alasan").val() == null) {
            error_alert('Alasan belum diisi!');
            return;
        }

        if ($('#cek_sales').val() == 1 && $('#type').val() == "#") {
            toastr["error"]("Type harap dipilih");
        } else if ($('#cek_sales').val() == 1 && $('#grade').val() == "#") {
            toastr["error"]("Grade harap dipilih");
        } else {
            $.confirm({
                title: 'Save changes',
                content: 'Changes will be saved',
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
                                        url: "<?= base_url('recruitment/interview/save_status') ?>",
                                        method: "POST",
                                        data: form.serialize(),
                                        // dataType: "json",
                                        success: function(response) {
                                            console.log('res= ' + response);

                                            $('#modal_status').modal('hide');
                                            $('#form_status')[0].reset();

                                            start = $('input[name="startdate"]').val();
                                            end = $('input[name="enddate"]').val();
                                            console.log(start, end);
                                            get_candidates(start, end, 5, 'dt_li');
                                            get_candidates(start, end, 6, 'dt_gi');
                                            get_candidates(start, end, 3, 'dt_di');
                                        },
                                        error: function(response, jqXHR, textStatus, errorThrown) {
                                            console.log(response.responseText);
                                            console.log('AJAX error: ', textStatus, errorThrown);
                                        }
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
                                    }).fail(function(jqXHR) {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-close',
                                            title: 'Oops!',
                                            theme: 'material',
                                            type: 'red',
                                            content: 'Failed to change status',
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
    }

    // Start Nice Select
    let select_loker = NiceSelect.bind(document.getElementById('loker'), {
        searchable: true,
        isAjax: false,
    });
    let select_status = NiceSelect.bind(document.getElementById('status'), {
        searchable: true,
        isAjax: false,
    });
    let select_user = NiceSelect.bind(document.getElementById('user'), {
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

    function updateKeterangan()
    {
        status = $("#status").val();
        $("#alasan").hide();

        if (status == 6) {
            $("#alasan").show();
            $("#select_alasan").val('');
        }
    }
</script>