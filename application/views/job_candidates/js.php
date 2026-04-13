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
        get_candidates('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>');
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
        $.ajax({
            url: "<?= base_url('job_candidates/get_candidates') ?>",
            method: "POST",
            dataType: "JSON",
            data: {
                start: start,
                end: end
            },
            success: function(res) {
                console.log(res);
            }
        })
        // $('#dt_pk').DataTable({
        //     "searching": true,
        //     "info": true,
        //     "paging": true,
        //     "destroy": true,
        //     "dom": 'Bfrtip',
        //     "order": [
        //         [0, 'desc']
        //     ],
        //     buttons: [{
        //         title: 'List Job Candidates',
        //         extend: 'excelHtml5',
        //         text: 'Export to Excel',
        //         footer: true
        //     }],
        //     "ajax": {
        //         "dataType": 'json',
        //         "method": "POST",
        //         "url": "<?= base_url(); ?>job_candidates/get_candidates",
        //         "data": {
        //             start: start,
        //             end: end
        //         }
        //     },
        //     "columns": [{
        //             'data': 'job_id',
        //             'render': function(data, type, row) {
        //                 let button = `<a onclick = show_detail_modal(${row['job_id']}) target="_blank" class="btn btn-sm btn-primary me-1"><i class="bi bi-eye"></i></a>`;
        //                 if (row['id_status'] == 1 && edit == true) {
        //                     button += `<a onclick = show_edit_modal(${row['job_id']}) target="_blank" class="btn btn-sm btn-success"><i class="bi bi-arrow-right"></i></a>`;
        //                 }
        //                 return button
        //             }
        //         },
        //         {
        //             'data': 'job_title',
        //         },
        //         {
        //             'data': 'company',
        //         },
        //         {
        //             'data': 'department',
        //         },
        //         {
        //             'data': 'position',
        //         },
        //         {
        //             'data': 'job_vacancy',

        //         },
        //         {
        //             'data': 'status',
        //             'render': function(data, type, row, meta) {
        //                 let bgColor = 'bg-blue text-white';
        //                 if (row['id_status'] == 1) {
        //                     bgColor = 'bg-yellow text-white';
        //                 } else if (row['id_status'] == 2) {
        //                     bgColor = 'bg-blue text-white';
        //                 } else if (row['id_status'] == 3) {
        //                     bgColor = 'bg-red text-white';
        //                 } else if (row['id_status'] == 4) {
        //                     bgColor = 'bg-green text-white';
        //                 } else if (row['id_status'] == 5) {
        //                     bgColor = 'bg-pink text-white';
        //                 }
        //                 return `<a role="button" class="badge . ${bgColor}" style="cursor:default;">${row['status']}</a>`;
        //             }
        //         },
        //         {
        //             'data': 'pic',
        //         },
        //         {
        //             'data': 'alasan_reject',
        //         },
        //         {
        //             'data': 'created_at',
        //         },
        //         {
        //             'data': 'created',
        //         },
        //         {
        //             'data': 'verified_at',
        //         },
        //         {
        //             'data': 'verified',
        //         },
        //         {
        //             'data': 'lt_verif',
        //         },
        //         {
        //             'data': 'lt_approve',
        //         }
        //     ],
        // });
    }

    function get_department() {
        perusahaan = $('#perusahaan').val();
        if (perusahaan != null) {
            company = perusahaan.split('|');
            $.ajax({
                url: "<?= base_url('permintaan_karyawan/get_department') ?>",
                method: "POST",
                data: {
                    id: company[1]
                },
                dataType: "JSON",
                success: function(res) {
                    console.log(res);
                    let department = '<option selected disabled> --Pilih Department-- </option>';
                    res.department.forEach((value, index) => {
                        department += `<option value = "${value.department_id}"> ${value.department_name}</option>`;
                    })
                    $('#department').html(department);
                    department_select.update();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            })
        }
    }

    function edit_permintaan() {
        form = $('#form_add_permintaan');
        console.log(form.serialize())
        if (check_empty_field()) {
            return;
        } else {
            $.confirm({
                title: 'Save Form',
                content: 'Permintaan form will be saved',
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
                                        url: "<?= base_url('permintaan_karyawan/save_edit_permintaan') ?>",
                                        method: "POST",
                                        data: form.serialize(),
                                        dataType: "JSON",
                                        beforeSend: function() {},
                                        success: function(response) {},
                                        error: function(xhr) {},
                                        complete: function() {},
                                    }).done(function(response) {
                                        if (response.update_pk == true) {
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
                                                $('#modal_add_permintaan').modal('hide');
                                                $('#dt_pk').DataTable().ajax.reload();
                                                // success_alert('Berhasil memperbaharui data permintaan.')
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
                    cancel: function() {}
                }
            });
        }
    }
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