<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>

<!-- slim select js -->
<!-- <script src="<?php echo base_url(); ?>assets/js/slimselect.min.js"></script> -->

<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>

<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>

<!-- Datetimepicker Full -->
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<!-- Jquery Confirm -->
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>

<!-- Summer Note css/js -->
<link href="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.css" rel="stylesheet">
<script src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>

<script type="text/javascript">
    // var table_ajax;

    $(document).ready(function() {

        dt_tbl_resume_tiket('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');

        /*Range*/
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
            // console.log('filter datee');
            dt_tbl_resume_tiket(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            // cardsresume
            load_card_resume(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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

        ct = new SlimSelect({
            select: "#category"
        });

        pt = new SlimSelect({
            select: "#priority"
        });

        // $('#dt_tbl_resume_tiket').DataTable();

    });

    function dt_tbl_resume_tiket(start, end) {
        console.log('dt_tbl_resume_tiket..');
        $('#dt_tbl_resume_tiket').DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "autoWidth": false,
            "destroy": true,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                title: 'Data List Report Audit',
                text: '<i class="bi bi-download text-white"></i>',
                footer: true
            }],
            "ajax": {
                "url": "<?= base_url('resume_ticket/dt_tbl_resume_tiket') ?>",
                "dataType": 'JSON',
                "type": "POST",
                "data": {
                    start: start,
                    end: end,
                    group_pic: '62,64,1161,2041,2063,2070,2969,5203,5397,5840,7111,7651,8257,8259'
                },
                // "success": function (res){
                //   console.log(res);
                // },
                // "error": function (jqXHR){
                //   console.log(jqXHR.responseText);
                // }
            },
            "columns": [{
                    'data': 'employee_name',
                    'width': '25%',
                    // 'render': function(data, type, row) {
                    //     res = data;
                    //     res = `<a href="javascript:void(0);" class="badge bg-sm bg-primary" onclick="proses_resume('${data}')">${data}</a>`;
                    //     return res;
                    // },
                    'className': 'text-center'
                },
                {
                    'data': 'jabatan',
                    'width': '25%',
                    'className': 'text-center'
                },
                {
                    'data': 'total_target_komit',
                    // 'render': function(data, type, row) {
                    //     if (data == 1) {
                    //         color = 'bg-warning';
                    //         text = 'Waiting'
                    //     } else if (data == 2) {
                    //         color = 'bg-success';
                    //         text = 'Approved'
                    //     } else {
                    //         color = 'bg-danger';
                    //         text = 'Rejected'
                    //     }
                    //     return `<span class="badge bg-sm ${color}">${text}</span>`;
                    // }
                },
                {
                    'data': 'total_actual_komit'
                },
                {
                    'data': 'achievement_komit',
                    'render': function(data, type, row) {
                        return data + '%';
                    }
                },
                {
                    'data': 'total_dev_done'
                },
                {
                    'data': 'total_tiket_done'
                },
                {
                    'data': 'total_all_tiket_undone'
                    // 'width': '20%'
                },
            ]
        });
    }

    function load_card_resume(start, end) {
        // console.log('load_card_resume..');
        $.ajax({
            url: '<?= base_url('resume_ticket/load_card_resume') ?>',
            type: 'POST',
            dataType: 'html',
            data: {
                start: start,
                end: end
            },
            success: function(response) {
                // console.log(response);
                $('#div_cards_resume').html(response);
            }
        });
    }

    // ----------------- Report Audit ---------------------
    function dt_report_audit(start, end) {
        $('#dt_report_audit').DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "autoWidth": false,
            "destroy": true,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                title: 'Data List Report Audit',
                text: '<i class="bi bi-download text-white"></i>',
                footer: true
            }],
            "ajax": {
                "url": "<?= base_url('report_audit/dt_report') ?>",
                "dataType": 'JSON',
                "type": "POST",
                "data": {
                    start: start,
                    end: end
                },
                // "success": function (res){
                //   console.log(res);
                // },
                // "error": function (jqXHR){
                //   console.log(jqXHR.responseText);
                // }
            },
            "columns": [{
                    'data': 'id_report',
                    // 'render': function(data, type, row) {
                    //     res = data;
                    //     res = `<a href="javascript:void(0);" class="badge bg-sm bg-primary" onclick="proses_resume('${data}')">${data}</a>`;
                    //     return res;
                    // },
                    'className': 'text-center'
                },
                {
                    'data': 'attachment',
                    'render': function(data, type, row) {
                        if (data != null) {
                            return `<a href="<?= base_url('uploads/report_audit/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>
                            &nbsp&nbsp<a href="<?= base_url('uploads/report_audit/') ?>${data}" class="text-primary"><i class="bi bi-download"></i></a>`;
                        } else {
                            return ``;
                        }
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'status',
                    'render': function(data, type, row) {
                        if (data == 1) {
                            color = 'bg-warning';
                            text = 'Waiting'
                        } else if (data == 2) {
                            color = 'bg-success';
                            text = 'Approved'
                        } else {
                            color = 'bg-danger';
                            text = 'Rejected'
                        }
                        return `<span class="badge bg-sm ${color}">${text}</span>`;
                    }
                },
                {
                    'data': 'created_at'
                },
                {
                    'data': 'created_by'
                },
                {
                    'data': 'note'
                },
                // {
                //     'data': 'verified_file',
                //     'render': function(data, type, row) {
                //         if (data != null) {
                //             return `<a href="<?= base_url('uploads/pph21/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>`;
                //         } else {
                //             return ``;
                //         }
                //     },
                // },
                {
                    'data': 'approved_at'
                },
                {
                    'data': 'approved_by',
                    'render': function(data, type, row) {
                        if (data != null) {
                            return `<span>${data}</span>`;
                        } else {
                            return '';
                        }
                    },
                    'width': '20%'
                },
                {
                    'data': 'approved_note'
                }
            ]
        });
    }
</script>