<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>


<script>
    $(document).ready(function() {

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('#titlecalendar').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
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

        dt_list_masa_kerja(1, 0, 0);

    }); // END :: Ready Function

    function select_filter() {
        type = $('#filter_by :selected').val();
        if (type == '1') {
            $('.filter_bulan').show();
            $('.filter_date').hide();
        } else {
            $('.filter_bulan').hide();
            $('.filter_date').show();
        }
    }

    function show_filter() {
        type = $('#filter_by :selected').val();
        if (type == '1') {
            start = $('#bulan_start').val();
            end = $('#bulan_end').val();
        } else {
            start = $('#start').val();
            end = $('#end').val();
        }
        dt_list_masa_kerja(type, start, end)
    }


    function dt_list_masa_kerja(type, start, end) {
        $('#dt_list_masa_kerja').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'asc'],
                [1, 'asc']
            ],
            responsive: true,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": "<?= base_url(); ?>trusmi_masa_kerja_engangement/dt_list_masa_kerja",
                "data": {
                    type: type,
                    start: start,
                    end: end,
                }
            },
            "columns": [
                {
                    "data": "employee_id",
                    "render": function(data, type, row, meta) {
                        return (meta.row + 1)
                    },
                },
                {
                    "data": "employee_id",
                },
                {
                    "data": "nama",
                },
                {
                    "data": "company",
                },
                {
                    "data": "department",
                },
                {
                    "data": "designation",
                },
                {
                    "data": "status_kontrak",
                },
                {
                    "data": "head",
                },
                {
                    "data": "tgl_gabung",
                },
                {
                    "data": "habis_kontrak"
                },
                {
                    "data": "remaining",
                },
                {
                    "data": "masa_kerja",
                },
                {
                    "data": "status_renewal",
                    "render": function(data, type, row, meta) {
                        if (row['id_renewal'] != '' && data == '') {
                            url = `https://trusmiverse.com/apps/trusmi_renewal_contract/verify?id=${row['id_renewal']}`;
                            return `<a href="${url}" target="_blank" class="badge badge-sm bg-blue">
                                        <small>Feedback Renewal Contract</small> <i class="bi bi-pencil-square"></i>
                                    </a>`
                        } else {
                            if (row['hide_kontrak'] == "") {
                                return '';
                            } else {
                                if (data == '1') {
                                    return 'Perpanjang'
                                } else if (data == '2') {
                                    return 'Tidak Perpanjang'
                                } else {
                                    return '';
                                }
                            }
                        }
                    }
                },
                {
                    "data": "renewal",
                    "render": function(data,type,row) {
                        if (row['hide_kontrak'] == "") {
                            return '';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    "data": "feedback",
                    "render": function(data,type,row) {
                        if (row['hide_kontrak'] == "") {
                            return '';
                        } else {
                            return data;
                        }
                    }
                },

            ],
        });
    }

    function save() {
        if ($('#company_id').val() == '') {
            error_alert("Company anda tidak terdeteksi di sistem");
            $('#company_id').focus();
        } else if ($('#employee_id').val() == '') {
            error_alert("Employee Id anda tidak terdeteksi di sistem");
            $('#employee_id').focus();
        } else if ($('#notice_date').val() == '') {
            error_alert("Notice Date tidak boleh kosong");
            $('#notice_date').focus();
        } else if ($('#resignation_date').val() == '') {
            error_alert("Resignation Date tidak boleh kosong");
            $('#resignation_date').focus();
        } else if ($('#reason').val() == '') {
            error_alert("Reason tidak boleh kosong");
            $('#reason').focus();
        } else if ($('#note').val() == '') {
            error_alert("Note tidak boleh kosong");
            $('#note').focus();
        } else if (
            $('#pernyataan_1').val() == '' ||
            $('#pernyataan_2').val() == '' ||
            $('#pernyataan_3').val() == '' ||
            $('#pernyataan_4').val() == '' ||
            $('#pernyataan_5').val() == '' ||
            $('#pernyataan_6').val() == '' ||
            $('#pernyataan_7').val() == '' ||
            $('#pernyataan_8').val() == '' ||
            $('#pernyataan_9').val() == '' ||
            $('#pernyataan_10').val() == ''
        ) {
            error_alert("Anda belum menjawab semua pertanyaan");
        } else {
            $("#modalAddConfirm").modal("show");
        }
    }

    function store_resignation() {
        form = $('#form_add');
        $.ajax({
            url: '<?= base_url('trusmi_resignation/store') ?>',
            type: 'POST',
            dataType: 'json',
            data: form.serialize(),
            beforeSend: function() {
                $('#btn_save_confirm').attr('disabled', true);
                $("#btn_save_confirm").html("Please wait...");
            },
            success: function(response) {
                if (response.status == 200) {
                    success_alert('Resignation Added');
                    id_resignation = response.id_resignation;
                    requested_by = '<?= $this->session->userdata("nama"); ?>';
                    requested_at = '<?= date("Y-m-d") ?>';
                    requested_hour = '<?= date("H:i:s") ?>';
                    msg = `📣 Alert!!!
*There is New Request Exit Clearance*
👤 Requested By : ${requested_by}
🕐 Requested At : ${requested_at} | ${requested_hour}

No. Resignation : ${requested_by}
Subject : *Form Exit Clearance*

🌐 Link Approve : 
                    
https://trusmiverse.com/apps/login/verify_resignation?u=${username}&id=${id_resignation}`;
                    // send_wa(array_contact, msg);
                } else if (response.status == 409) {
                    error_alert('Failed');
                } else {
                    error_alert('Unrecognized Error');
                }
                form[0].reset();
                $("#modalAdd").modal("hide");
                $("#modalAddConfirm").modal("hide");
                dt_list_masa_kerja(moment().startOf('month').format('YYYY-MM-DD'), moment().endOf('month').format('YYYY-MM-DD'));
                selectReason.setSelected();
            },
            error: function(xhr) { // if error occured
                error_alert('Failed, Error Occured');
            },
            complete: function() {
                $('#btn_save_confirm').attr('disabled', false);
                $("#btn_save_confirm").html("Yes, Save");
            },
        });
    }


    function success_alert(text) {
        textMsg = text == null ? '' : text;
        new PNotify({
            title: `Success`,
            text: `${textMsg}`,
            icon: 'icofont icofont-checked',
            type: 'success',
            delay: 1500,
        });
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
</script>