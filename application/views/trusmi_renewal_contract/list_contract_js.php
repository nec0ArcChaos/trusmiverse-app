<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    $(document).ready(function() {

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
            // dt_trusmi_resignation(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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

        dt_contract_new();
    });


    function dt_contract_new() {
        $('#dt_contract_new').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [4, 'asc']
            ],
            responsive: true,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "GET",
                "url": "<?= base_url(); ?>trusmi_renewal_contract/dt_contract_new",
                // "data": {
                //     start: start,
                //     end: end,
                // }
            },
            "columns": [{
                    "data": "employee_name",
                    render: function(data, type, row, meta) {
                        user_id = '<?= $this->session->userdata('user_id'); ?>';
                        if (user_id == 1 || user_id == 979) {
                            resend_renewal = `<a href="javascript:void(0)" title="Kirim ulang renewal contract?" onclick="resend_renewal_contract(${row['id']})">
                                                <i class="bi bi-whatsapp text-success"></i>
                                            </a>`
                        } else {
                            resend_renewal = ``
                        }
                        return `${resend_renewal} ${data}`
                    }
                },
                {
                    "data": "department_name",
                    render: function(data, type, row, meta) {
                        return `<small>${data}</small> <br> <small>${row['designation_name']}</small>`
                    }
                },
                {
                    "data": "masa_kerja",
                    render: function(data, type, row, meta) {
                        masa_kerja = data.split(".");
                        if (masa_kerja[0] > 0) {
                            lama_tahun = `${masa_kerja[0]} Tahun`;
                        } else {
                            lama_tahun = "";
                        }

                        return `${lama_tahun} ${masa_kerja[1]} Bulan`
                    }
                },
                {
                    "data": "head_name",
                },
                {
                    "data": "contract_end",
                },
                {
                    "data": "status_perpanjang",
                },
                {
                    "data": "lama_perpanjang",
                },
                {
                    "data": "feedback",
                },
                {
                    "data": "perpanjang_oleh",
                },
                // addnew
                {
                    "data": "masih_sesuai", 
                },
                {
                    "data": "file_kpi",
                    render: function(data){
                        return `<a href="<?= base_url('uploads/trusmi_renewal/') ?>${data}">
                                    &nbsp;&nbsp;<i class="bi bi-download h5 text-theme mb-0"></i>
                                </a>`;
                    } 
                },
                {
                    "data": "proaktif_belajar", 
                },
                {
                    "data": "proaktif_adaptasi", 
                },
                {
                    "data": "proaktif_evaluasi", 
                },
                {
                    "data": "pembelajar_berani", 
                },
                {
                    "data": "pembelajar_berjuang", 
                },
                {
                    "data": "pembelajar_melakukan", 
                },
                {
                    "data": "energi_harmonis", 
                },
                {
                    "data": "energi_motivasi", 
                },
                {
                    "data": "energi_tauladan", 
                },
                {
                    "data": "internal_percepatan", 
                },
                {
                    "data": "internal_disiplin", 
                },
                {
                    "data": "feedback_at", 
                }

            ],
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