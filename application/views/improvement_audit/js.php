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
<!-- Datepicker -->
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<!-- slim select js -->
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
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
        get_dt_ia('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>');
        $('#btn_filter').on('click', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            get_dt_ia(start, end);
        });
        $('.range').on('change', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            get_dt_ia(start, end);
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
        $("#periode").datepicker({
            format: "yyyy-mm",
            startView: "months",
            minViewMode: "months",
            autoclose: true,
        });

        plan = new SlimSelect({
            select: "#plan"
        });
    });

    function get_plan() {
        plan = $('#plan').val();
        if (plan != null && plan != '#') {
            $.ajax({
            url: "<?= base_url('improvement_audit/get_plan') ?>",
            method: "POST",
            data: {
                plan: plan
            },
            dataType: "JSON",
            success: function(res) {
                $('#plan_periode').val(res.plan[0]['periode']);
                $('#company_id').val(res.plan[0]['company_id']);
                $('#company').val(res.plan[0]['company_name']);
                $('#department_id').val(res.plan[0]['department_id']);
                $('#department').val(res.plan[0]['department_name']);
            }
            })
        }
    }

    function get_dt_ia(start, end) {
        // status = $('#status_permintaan').val();
        // console.log(status);
        $('#dt_ia').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
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
                "url": "<?= base_url(); ?>improvement_audit/get_improvement_audit",
                "data": {
                    start: start,
                    end: end
                }
            },
            "columns": [
                {
                    'data': 'id_imp',
                    "render": function(data, type, row, meta) {
                        return `<div class="row">
                                    <div class="col-8">
                                        <div id="ellipsis-ex" class="d-inline-block text-truncate text-turncate-custom">
                                            <strong><span data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${data}">${data}&nbsp;&nbsp;</span></strong><br>
                                        </div>
                                    </div>
                                    <div class="col-4 text-md-end">
                                        <a href="<?= base_url(); ?>improvement_audit/print/${row['id_plan']}" target="_blank" role="button" class="badge bg-green" title="Print">
                                            <i class="bi bi-printer"></i>
                                        </a>     
                                    </div>
                                </div>`
                    }
                },
                {
                    'data': 'id_plan',
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    'data': 'periode',
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    'data': 'subject',
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    'data': 'tindak_lanjut',
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    'data': 'improvement',
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "attachment",
                    "render": function(data, type, row, meta) {
                        if (data != null) {
                        lampiran = data.replace(/ /g, '').split(',')[0];
                        files = ``;
                        base_url = '<?= base_url() ?>uploads/audit_temuan';
                        ext = lampiran.substr((lampiran.lastIndexOf('.') + 1));
                        if (ext == 'pdf') {
                        files += `<a data-fancybox="gallery" href="${base_url}/${lampiran}" class="gallery" title="Lihat PDF">
                                    <i class="bi bi-filetype-pdf"></i>
                                    </a>
                                    &nbsp;
                                    `
                        } else if (ext == 'xls' || ext == 'xlsx' || ext == 'csv') {
                        files += `<a href="${base_url}/${lampiran}" title="Lihat Excel">
                                    <i class="bi bi-filetype-xlsx"></i>
                                    </a>
                                    &nbsp;
                                    `
                        } else {
                        files += `<a data-fancybox="gallery" href="${base_url}/${lampiran}" class="gallery" title="Lihat Foto">
                                    <i class="bi bi-filetype-jpg"></i>
                                    </a>
                                    &nbsp;
                                    `
                        }

                        return files
                        } else {
                        return ''
                        }

                    }
                    },
                {
                    'data': 'created_at',
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    'data': 'created_by',
                    "className": "d-none d-md-table-cell text-left"
                }
            ],
        });
    }
    // Add event listener
    // for opening and closing details
    $('#dt_pa tbody').on('click', 'td.dt-control', function() {
        // console.log('test')
        var tr = $(this).closest('tr');
        var row = $('#dt_pa').DataTable().row(tr);

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
        </table>`
        );
    }

    function add_improvement() {
        // Auto Get Date Today
        curdate = (new Date()).toISOString().split('T')[0];
        $("#tanggal").val(curdate);

        plan.setSelected('');
        $('#plan').val('');
        $('#form_improvement')[0].reset();
        $('#plan_periode').val('');
        $('#company').val('');
        $('#department').val('');
        $('#attachment').val('');
        $('#tindak_lanjut').summernote('code', '');
        $('#improvement').summernote('code', '');
        $("#modal_add_improvement").modal("show");
    }


    function save_improvement() {
        if (is_valid()) {
            return;
        } else {
        form = $('#form_improvement');
        attachment = $('#attachment').prop('files')[0];
        datas = new FormData(form[0]);
        datas.append('file', attachment);

            $.confirm({
                title: 'Save Form',
                content: 'Improvement Audit akan di simpan',
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
                                title: 'Tunggu',
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
                                        url: "<?= base_url('improvement_audit/save_improvement') ?>",
                                        method: "POST",
                                        cache       : false,
                                        contentType : false,
                                        processData : false,
                                        data: datas,
                                        dataType: "JSON",
                                        beforeSend: function() {},
                                        success: function(response) {},
                                        error: function(xhr) {},
                                        complete: function() {},
                                    }).done(function(response) {
                                        if (response.insert_audit_improvement == true) {
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
                                                $('#modal_add_improvement').modal('hide');
                                                $('#dt_ia').DataTable().ajax.reload();
                                                // success_alert("Berhasil menambah Plan Audit!");
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

    function is_valid() {
        let isEmptyField = false;
        if ($('#plan').val() == '' || $('#plan').val() == null || $('#plan').val() == '-Pilih Plan-') {
            error_alert("Plan is required!");
            return true;
        }
        if ($('#tindak_lanjut').val() == '' || $('#tindak_lanjut').val() == null) {
            error_alert("Tindak Lanjut is required!");
            return true;
        } 
        if ($('#improvement').val() == '' || $('#improvement').val() == null) {
            error_alert("Improvement is required!");
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