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

        dt_report_audit('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');

        /*Range*/
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
            console.log('filter datee');
            dt_report_audit(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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

        // $('#deadline').datetimepicker({
        //     format: 'Y-m-d',
        //     timepicker: false,
        //     minDate: 0,
        // });

        // $('#note').summernote({
        //     placeholder: '...',
        //     tabsize: 2,
        //     height: 100,
        //     toolbar: [
        //         ['font', ['bold', 'underline', 'clear']],
        //         ['para', ['ul', 'ol', 'paragraph']],
        //     ]
        // });

        // $('#resume').summernote({
        //     placeholder: '...',
        //     tabsize: 2,
        //     height: 150,
        //     toolbar: [
        //         ['font', ['bold', 'underline', 'clear']],
        //         ['para', ['ul', 'ol', 'paragraph']],
        //     ]
        // });

    });

    function add_new_report() {
        $("#modal_add_report").modal("show");
    }

    function save_report() {
        var attachment = $("#attachment").val();
        var note = $("#note").val();
        console.log(attachment, note);

        if (attachment == "") {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Attachment is empty!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else {
            // add by Ade
            let attachment = $('#attachment').prop("files")[0];
            let form_file = new FormData();
            form_file.append("note", note);
            form_file.append("attachment", attachment);

            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please wait!',
                theme: 'material',
                type: 'blue',
                content: 'Processing...',
                buttons: {
                    close: {
                        isHidden: true,
                        actions: function() {}
                    },
                },
                onOpen: function() {
                    $.ajax({
                        method: "POST",
                        url: "<?= base_url("report_audit/save_report") ?>",
                        dataType: "JSON",
                        cache: false,
                        contentType: false,
                        processData: false,
                        // data: form_file,
                        data: form_file,
                        beforeSend: function(res) {
                            $("#btn_save").attr("disabled", true);
                        },
                        success: function(res) {
                            console.log(res);
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
                            $("#dt_report_audit").DataTable().ajax.reload();
                            $("#modal_add_report").modal("hide");
                            $("#form_add_report")[0].reset();
                            // ct.setSelected("#");
                            // pt.setSelected("#");
                            $("#btn_save").removeAttr("disabled");
                            // $('#problem').summernote('reset');
                            // $('#pembahasan_draft').summernote('code', dt.pembahasan);
                            jconfirm.instances[0].close();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR.responseText);
                            jconfirm.instances[0].close();
                        }
                    });
                }
            });
        }
    }

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

    function list_waiting_report() {
        $("#modal_list_waiting_report").modal("show");
        $('#dt_waiting_report').DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "autoWidth": false,
            "destroy": true,
            // dom: 'Bfrtip',
            // buttons: [{
            //     extend: 'excelHtml5',
            //     title: 'Data List Waiting Report',
            //     text: '<i class="bi bi-download text-white"></i>',
            //     footer: true
            // }],
            "ajax": {
                "url": "<?= base_url('report_audit/dt_waiting_report') ?>",
                "dataType": 'JSON',
                "type": "POST"
            },
            "columns": [{
                    'data': 'id_report',
                    'render': function(data, type, row) {
                        res = data;
                        res = `<a href="javascript:void(0);" class="badge bg-sm bg-primary" onclick="show_form_verifikasi('${data}')">${data}</a>`;
                        return res;
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'attachment',
                    'render': function(data, type, row) {
                        if (data != "") {
                            return `<a href="<?= base_url('uploads/report_audit/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>&nbsp&nbsp<a href="<?= base_url('uploads/report_audit/') ?>${data}" class="text-primary"><i class="bi bi-download"></i></a>`;
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
                            text = 'Waiting'
                        } else if (data == 2) {
                            text = 'Approved'
                        } else {
                            text = 'Rejected'
                        }
                        return `<span>${text}</span>`;
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
                }
            ]
        });
    }

    function show_form_verifikasi(id) {
        $("#modal_verifikasi").modal("show");
        $('#id_report').val(id);
    }

    function save_verif_report(status) {
        if ($("#note_verif").val() == "") {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Note wajib di isi!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else {
            var id_report = $('#id_report').val();
            var note_verif = $('#note_verif').val();
            // var file_verif = $('#file_verif').prop("files")[0];
            let form_verif = new FormData();
            form_verif.append("id_report", id_report);
            form_verif.append("note_verif", note_verif);
            form_verif.append("status", status); // 2 : approve, 2 : reject
            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please wait!',
                theme: 'material',
                type: 'blue',
                content: 'Processing...',
                buttons: {
                    close: {
                        isHidden: true,
                        actions: function() {}
                    },
                },
                onOpen: function() {
                    $.ajax({
                        method: "POST",
                        url: "<?= base_url("report_audit/save_verif_report") ?>",
                        dataType: "JSON",
                        cache: false,
                        contentType: false,
                        processData: false,
                        // data: form_verif,
                        data: form_verif,
                        beforeSend: function(res) {
                            $("#btn_approve").attr("disabled", true);
                            $("#btn_reject").attr("disabled", true);
                        },
                        success: function(res) {
                            console.log(res);
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
                            $("#dt_waiting_report").DataTable().ajax.reload();
                            $("#modal_verifikasi").modal("hide");

                            $("#dt_report_audit").DataTable().ajax.reload();
                            $("#form_verifikasi_report")[0].reset();
                            // ct.setSelected("#");
                            // pt.setSelected("#");
                            $("#btn_approve").removeAttr("disabled");
                            $("#btn_reject").removeAttr("disabled");
                            // $('#problem').summernote('reset');
                            // $('#pembahasan_draft').summernote('code', dt.pembahasan);
                            jconfirm.instances[0].close();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR.responseText);
                            jconfirm.instances[0].close();
                        }
                    });
                }
            });
        }
    }

    // ----------------------------------------------------------------------------------------------------------------------

    function add_pph21() {
        $("#modal_add_pph21").modal("show");
    }

    function save_pph21() {
        var attachment = $("#attachment").val();
        var note = $("#note").val();
        console.log(attachment, note);
        // priority = $("#priority").val();
        // deadline = $("#deadline").val();

        if (attachment == "") {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Attachment is empty!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        }
        // else if (note == "" || note == '<p><br></p>' || note == '<br>' || note == '<p>&nbsp;</p>') {
        //     $.confirm({
        //         icon: 'fa fa-times-circle',
        //         title: 'Warning',
        //         theme: 'material',
        //         type: 'red',
        //         content: 'Note is empty!',
        //         buttons: {
        //             close: {
        //                 actions: function() {}
        //             },
        //         },
        //     });
        // } 
        else {
            // add by Ade
            let attachment = $('#attachment').prop("files")[0];
            let form_file = new FormData();
            form_file.append("note", note);
            form_file.append("attachment", attachment);
            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please wait!',
                theme: 'material',
                type: 'blue',
                content: 'Processing...',
                buttons: {
                    close: {
                        isHidden: true,
                        actions: function() {}
                    },
                },
                onOpen: function() {
                    $.ajax({
                        method: "POST",
                        url: "<?= base_url("pph21/save_pph21") ?>",
                        dataType: "JSON",
                        cache: false,
                        contentType: false,
                        processData: false,
                        // data: form_file,
                        data: form_file,
                        beforeSend: function(res) {
                            $("#btn_save").attr("disabled", true);
                        },
                        success: function(res) {
                            console.log(res);
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
                            $("#dt_list_pph21").DataTable().ajax.reload();
                            $("#modal_add_pph21").modal("hide");
                            $("#form_input_pph21")[0].reset();
                            // ct.setSelected("#");
                            // pt.setSelected("#");
                            $("#btn_save").removeAttr("disabled");
                            // $('#problem').summernote('reset');
                            // $('#pembahasan_draft').summernote('code', dt.pembahasan);
                            jconfirm.instances[0].close();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR.responseText);
                            jconfirm.instances[0].close();
                        }
                    });
                }
            });
        }
    }


    function list_verif_pph21() {
        $("#modal_list_verif_pph21").modal("show");
        $('#dt_verif_pph21').DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "autoWidth": false,
            "destroy": true,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                title: 'Data List Problem Solving',
                text: '<i class="bi bi-download text-white"></i>',
                footer: true
            }],
            "ajax": {
                "url": "<?= base_url('pph21/dt_verif_pph21') ?>",
                "dataType": 'JSON',
                "type": "POST"
                // "data": {
                //     start: '<?= date("Y-m-01") ?>',
                //     end: '<?= date("Y-m-t") ?>'
                // },
            },
            "columns": [{
                    'data': 'id_pajak',
                    'render': function(data, type, row) {
                        res = data;
                        res = `<a href="javascript:void(0);" class="badge bg-sm bg-primary" onclick="proses_verifikasi('${data}')">${data}</a>`;
                        return res;
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'attachment',
                    'render': function(data, type, row) {
                        if (data != "") {
                            return `<a href="<?= base_url('uploads/pph21/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>`;
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
                            text = 'Waiting'
                        } else if (data == 2) {
                            text = 'Verified'
                        } else {
                            text = 'Paid'
                        }
                        return `<span>${text}</span>`;
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
                }
            ]
        });
    }

    function verif_pph21() {
        if ($("#file_verif").val() == "") {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Attachment is empty!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else {
            var id_pajak = $('#id_pajak').val();
            var file_verif = $('#file_verif').prop("files")[0];
            var note_verif = $('#note_verif').val();
            console.log(file_verif, note_verif);

            let form_file = new FormData();
            form_file.append("id_pajak", id_pajak);
            form_file.append("file_verif", file_verif);
            form_file.append("note_verif", note_verif);
            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please wait!',
                theme: 'material',
                type: 'blue',
                content: 'Processing...',
                buttons: {
                    close: {
                        isHidden: true,
                        actions: function() {}
                    },
                },
                onOpen: function() {
                    $.ajax({
                        method: "POST",
                        url: "<?= base_url("pph21/verif_pph21") ?>",
                        dataType: "JSON",
                        cache: false,
                        contentType: false,
                        processData: false,
                        // data: form_file,
                        data: form_file,
                        beforeSend: function(res) {
                            $("#btn_save").attr("disabled", true);
                        },
                        success: function(res) {
                            console.log(res);
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
                            $("#dt_verif_pph21").DataTable().ajax.reload();
                            $("#modal_verifikasi").modal("hide");

                            $("#dt_list_pph21").DataTable().ajax.reload();
                            $("#form_verifikasi_pph21")[0].reset();
                            // ct.setSelected("#");
                            // pt.setSelected("#");
                            $("#btn_save_verif").removeAttr("disabled");
                            // $('#problem').summernote('reset');
                            // $('#pembahasan_draft').summernote('code', dt.pembahasan);
                            jconfirm.instances[0].close();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR.responseText);
                            jconfirm.instances[0].close();
                        }
                    });
                }
            });
        }
    }

    function list_paid_pph21() {
        $("#modal_list_paid_pph21").modal("show");
        $('#dt_paid_pph21').DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "autoWidth": false,
            "destroy": true,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                title: 'Data List Problem Solving',
                text: '<i class="bi bi-download text-white"></i>',
                footer: true
            }],
            "ajax": {
                "url": "<?= base_url('pph21/dt_paid_pph21') ?>",
                "dataType": 'JSON',
                "type": "POST"
            },
            "columns": [{
                    'data': 'id_pajak',
                    'render': function(data, type, row) {
                        res = data;
                        res = `<a href="javascript:void(0);" class="badge bg-sm bg-primary" onclick="show_modal_paid('${data}')">${data}</a>`;
                        return res;
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'verified_file',
                    'render': function(data, type, row) {
                        if (data != "") {
                            return `<a href="<?= base_url('uploads/pph21/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>`;
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
                            text = 'Waiting'
                        } else if (data == 2) {
                            text = 'Verified'
                        } else {
                            text = 'Paid'
                        }
                        return `<span>${text}</span>`;
                    }
                },
                {
                    'data': 'verified_at'
                },
                {
                    'data': 'verified_by'
                },
                {
                    'data': 'note'
                }
            ]
        });
    }

    function show_modal_paid(id) {
        $("#modal_paid").modal("show");
        $('#id_pajak_paid').val(id);
    }

    function save_paid_pph21() {
        if ($("#file_paid").val() == "") {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Bukti kirim pajak kosong!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else {
            var id_pajak = $('#id_pajak_paid').val();
            var file_paid = $('#file_paid').prop("files")[0];
            var note_paid = $('#note_paid').val();
            // console.log(id_pajak, file_paid, note_paid);

            let form_file = new FormData();
            form_file.append("id_pajak_paid", id_pajak);
            form_file.append("file_paid", file_paid);
            form_file.append("note_paid", note_paid);
            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please wait!',
                theme: 'material',
                type: 'blue',
                content: 'Processing...',
                buttons: {
                    close: {
                        isHidden: true,
                        actions: function() {}
                    },
                },
                onOpen: function() {
                    $.ajax({
                        method: "POST",
                        url: "<?= base_url("pph21/save_paid_pph21") ?>",
                        dataType: "JSON",
                        cache: false,
                        contentType: false,
                        processData: false,
                        // data: form_file,
                        data: form_file,
                        beforeSend: function(res) {
                            $("#btn_save").attr("disabled", true);
                        },
                        success: function(res) {
                            console.log(res);
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
                            $("#dt_paid_pph21").DataTable().ajax.reload();
                            $("#modal_paid").modal("hide");

                            $("#dt_list_pph21").DataTable().ajax.reload();
                            $("#form_paid_pph21")[0].reset();
                            // ct.setSelected("#");
                            // pt.setSelected("#");
                            $("#btn_save_paid").removeAttr("disabled");
                            // $('#problem').summernote('reset');
                            // $('#pembahasan_draft').summernote('code', dt.pembahasan);
                            jconfirm.instances[0].close();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR.responseText);
                            jconfirm.instances[0].close();
                        }
                    });
                }
            });
        }
    }
</script>