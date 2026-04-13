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
        get_dt_actual_audit('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>');
        $('#btn_filter').on('click', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            get_dt_actual_audit(start, end);
        });
        $('.range').on('change', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            get_dt_actual_audit(start, end);
        })
        // Text_Area
        $('textarea.input_permintaan').each(function() {
            $(this).summernote({
                tabsize: 2,
                height: 100,
                toolbar: [
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                ]
            });
        })
    });

    function get_dt_actual_audit(start, end) {
        $('#dt_actual').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [1, 'desc']
            ],
            buttons: [{
                title: 'List Plan Audit',
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "method": "POST",
                "url": "<?= base_url(); ?>actual_audit/get_actual_audit",
                "data": {
                    start: start,
                    end: end
                }
            },
            "columns": [{
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                    "data": "id_plan",
                    'render': function(data, type, row, meta) {
                        return `<span style="cursor:pointer" class="badge bg-primary dt-control">${data}</span>`
                    }
                },
                {
                    'data': 'auditor'
                },
                {
                    'data': 'no_dok'
                },
                {
                    'data': 'subject'
                },
                {
                    'data': 'object',
                },
                {
                    'data': 'tool',
                    "className": "d-none"
                },
                {
                    'data': 'pics',
                    'render': function(data, type, row, meta) {
                        avatar_pic = ``;
                        avatar_pic_plus = ``;
                        if (row['pp_pic'].indexOf(',') > -1) {
                            array_pic = row['pp_pic'].split(',');
                            for (let index = 0; index < array_pic.length; index++) {
                                if (index < 2) {
                                    avatar_pic += `<div class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${array_pic[index]}&quot;);">
                            <img src="http://trusmiverse.com/hr/uploads/profile/${array_pic[index]}" alt="" style="display: none;">
                            </div>`;
                                }
                            }
                            if (array_pic.length > 2) {
                                avatar_pic_plus = `<div class="avatar avatar-30 bg-light-theme rounded-circle me-1">
                                <p class="small">${parseInt(array_pic.length)-2}+</p>
                            </div>`;
                            } else {
                                avatar_pic_plus = '';
                            }
                            return `<div class="d-flex justify-content-center" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${row['pics']}">
                                ${avatar_pic}${avatar_pic_plus}  
                            </div>`;
                        } else {
                            return `
                            <div class="d-flex justify-content-center" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${row['pics']}">
                                <div class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${row['pp_pic']}&quot;);">
                            <img src="http://trusmiverse.com/hr/uploads/profile/${row['pp_pic']}" alt="" style="display: none;">
                            </div>  
                            </div>
                        `;
                        }
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    'data': 'company',
                },
                {
                    'data': 'department',
                },
                {
                    'data': 'designation',
                },
                {
                    'data': 'pemeriksaan',
                    "className": "d-none"
                },
                {
                    'data': 'output',
                    "className": "d-none"
                },
                {
                    'data': 'target',
                },
                {
                    'data': 'bobot',
                    'render': function(data, type, row) {
                        return `${data}%`;
                    }
                },
                // {
                //     'data': 'hasil',
                //     'render': function(data, type, row) {
                //         return `${data}%`;
                //     }
                // },
                {
                    'data': 'analisa',
                    "className": "d-none"
                },
                {
                    'data': 'konfirmasi',
                    "className": "d-none"
                },
                {
                    'data': 'pemeriksaan_rekomendasi',
                    "className": "d-none"
                },
                {
                    'data': 'improvement',
                    "className": "d-none"
                },
                {
                    'data': 'note',
                    "className": "d-none"
                },
                {
                    'data': 'pics',
                    "className": "d-none"
                }
            ],
        });
    }
    // Add event listener for opening and closing details
    $('#dt_actual tbody').on('click', 'td.dt-control', function() {
        // console.log('test')
        var tr = $(this).closest('tr');
        var row = $('#dt_actual').DataTable().row(tr);

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
                <tr><td><b>Tools</b></td><td>${d.tool}</td></tr>
                <tr><td><b>Pemeriksaan</b></td><td>${d.pemeriksaan}</td></tr>
                <tr><td><b>Output</b></td><td>${d.output}</td></tr>
                <tr><td><b>Analisa</b></td><td>${d.analisa}</td></tr>
                <tr><td><b>Konfirmasi</b></td><td>${d.konfirmasi}</td></tr>
                <tr><td><b>Hasil Pemeriksaan & Rekomendasi (30%)</b></td><td>${d.pemeriksaan_rekomendasi}</td></tr>
                <tr><td><b>Improvement</b></td><td>${d.improvement}</td></tr>
                <tr><td><b>Note</b></td><td>${d.note}</td></tr>
        </table>`
        );
    }

    function get_dt_plan_audit() {
        $('#dt_pa').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [1, 'desc']
            ],
            buttons: [{
                title: 'List Plan Audit',
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "method": "POST",
                "url": "<?= base_url(); ?>actual_audit/get_plan_audit"
            },
            "columns": [{
                    "data": "id_plan",
                    'render': function(data, type, row, meta) {
                        return `<a style="cursor:pointer" class="badge bg-primary update_plan" onclick="show_edit_modal('${data}')">${data}</a>`
                    }
                },
                {
                    'data': 'auditor'
                },
                {
                    'data': 'pics',
                },
                {
                    'data': 'target',
                },
                {
                    'data': 'no_dok'
                },
                {
                    'data': 'subject'
                },
                {
                    'data': 'object',
                }
            ],
        });
    }
    $('#btn_list_audit').on('click', function() {
        get_dt_plan_audit();
        $('#modal_list_audit').modal('show');
    })

    function show_edit_modal(id) {
        $('#id_plan').val(id);
        $('#modal_edit_audit').modal('show');
    }


    function save_audit() {
        form = $('#form_edit_audit');
        if (is_valid_audit()) {
            return;
        } else {
            // success_alert('Form is valid');
            $.confirm({
                title: 'Save Form',
                content: 'Plan Audit will be updated',
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
                                        url: "<?= base_url('actual_audit/save_audit') ?>",
                                        method: "POST",
                                        data: form.serialize(),
                                        dataType: "JSON",
                                        beforeSend: function() {},
                                        success: function(response) {},
                                        error: function(xhr) {},
                                        complete: function() {},
                                    }).done(function(response) {
                                        if (response.update == true) {
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
                                                $('#modal_edit_audit').modal('hide');
                                                $('#dt_actual').DataTable().ajax.reload();
                                                $('#dt_pa').DataTable().ajax.reload();
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

    function is_valid_audit() {
        let isEmptyField = false;
        if ($('#output').val() == '' || $('#output').val() == null) {
            error_alert("Output is required!");
            return true;
        }
        if ($('#analisa').val() == '' || $('#analisa').val() == null) {
            error_alert("Analisa is required!");
            return true;
        }
        if ($('#konfirmasi').val() == '' || $('#konfirmasi').val() == null) {
            error_alert("Konfirmasi is required!");
            return true;
        }
        if ($('#improvement').val() == '' || $('#improvement').val() == null) {
            error_alert("Improvement is required!");
            return true;
        }
        if ($('#rekomendasi').val() == '' || $('#rekomendasi').val() == null) {
            error_alert("Hasil Pemeriksaan dan rekomendasi is required!");
            return true;
        }
        if ($('#note').val() == '' || $('#note').val() == null) {
            error_alert("Note is required!");
            return true;
        }
        return false;
    }

    // Fungsi untuk mendekodekan entitas HTML
    function decodeHtmlEntities(str) {
        let textarea = document.createElement("textarea");
        textarea.innerHTML = str;
        return textarea.value;
    }
    // NiceSelect
    let company_select = NiceSelect.bind(document.getElementById('company'), {
        searchable: true,
        isAjax: false,
    });
    let department_select = NiceSelect.bind(document.getElementById('department'), {
        searchable: true,
        isAjax: false,
    });
    let posisi_select = NiceSelect.bind(document.getElementById('posisi'), {
        searchable: true,
        isAjax: false,
    });
    let dokumen_select = NiceSelect.bind(document.getElementById('dokumen'), {
        searchable: true,
        isAjax: false,
        placeholder: '--Pilih Dokumen--'
    });
    let auditor_select = NiceSelect.bind(document.getElementById('auditor'), {
        searchable: true,
        isAjax: false,
        placeholder: '--Pilih Auditor--'
    });
    let pic_select = NiceSelect.bind(document.getElementById('pic'), {
        searchable: true,
        isAjax: false,
        placeholder: '--Pilih PIC--'
    });
    let target_select = NiceSelect.bind(document.getElementById('target'), {
        searchable: true,
        isAjax: false
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