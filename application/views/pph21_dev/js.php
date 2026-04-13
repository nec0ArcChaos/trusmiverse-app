<!-- Required Jquery -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery/js/jquery.min.js"></script> -->
<!-- Autocomplete -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/autocomplete.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap/js/bootstrap.min.js"></script> -->
<!-- jquery slimscroll js -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script> -->
<!-- data-table js -->
<!-- <script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script> -->
<!-- i18next.min.js -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/advance-elements/moment-with-locales.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script> -->
<!-- Date-range picker js -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap-daterangepicker/js/daterangepicker.js"></script>

<script src="<?php echo base_url(); ?>assets/js/pcoded.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/demo-12.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/script.js"></script> -->
<!-- Datatable Button -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script> -->

<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>

<!-- view images -->
<!-- <script type="text/javascript" src="<?= base_url('assets/fancybox/jquery.fancybox.min.js') ?>"></script> -->

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

        list_pph21('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');

        /*Range*/
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            console.log('call cb..');
            
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
            list_pph21(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));

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

        $('#deadline').datetimepicker({
            format: 'Y-m-d',
            timepicker: false,
            minDate: 0,
        });

        // $('#note').summernote({
        //     placeholder: '...',
        //     tabsize: 2,
        //     height: 100,
        //     toolbar: [
        //         ['font', ['bold', 'underline', 'clear']],
        //         ['para', ['ul', 'ol', 'paragraph']],
        //     ]
        // });

        $('#resume').summernote({
            placeholder: '...',
            tabsize: 2,
            height: 150,
            toolbar: [
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
            ]
        });

    });

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

    function list_pph21(start, end) {
        $('#dt_list_pph21').DataTable({
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
                "url": "<?= base_url('pph21/list_pph21') ?>",
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
                    'data': 'id_pajak',
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
                            color = 'bg-warning';
                            text = 'Waiting'
                        } else if (data == 2) {
                            color = 'bg-info';
                            text = 'Verified'
                        } else {
                            color = 'bg-success';
                            text = 'Paid'
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
                {
                    'data': 'verified_file',
                    'render': function(data, type, row) {
                        if (data != null) {
                            return `<a href="<?= base_url('uploads/pph21/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>`;
                        } else {
                            return ``;
                        }
                    },
                },
                {
                    'data': 'verified_at'
                },
                {
                    'data': 'verified_by',
                    'render': function(data, type, row) {
                        if (data != null) {
                            return `<span>${data}</span>`;
                        } else {
                            return '';
                        }
                        // return `<span>${data}</span><br>
                        // <hr style="margin-top:3px;margin-bottom:3px;">
                        // <p class="mb-0 text-muted small"><i class="bi bi-clock"></i> ${row['created_at']}</p>`;
                    },
                    'width': '20%'
                },
                {
                    'data': 'paid_file',
                    'render': function(data, type, row) {
                        if (data != null) {
                            return `<a href="<?= base_url('uploads/pph21/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>`;
                        } else {
                            return ``;
                        }
                    },
                },
                {
                    'data': 'paid_at'
                },
                {
                    'data': 'paid_by'
                }
            ]
        });
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

    function proses_verifikasi(id) {
        $("#modal_verifikasi").modal("show");
        $('#id_pajak').val(id);
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