<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>

<!-- view images -->
<!-- <script type="text/javascript" src="<?= base_url('assets/fancybox/jquery.fancybox.min.js') ?>"></script> -->

<!-- slim select js -->

<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>

<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>


<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<link href="<?= base_url(); ?>assets/jquery-timepicker/jquery.timepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/jquery-timepicker/jquery.timepicker.min.js" type="text/javascript"></script>

<!-- Datetimepicker Full -->
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript">
    // var table_ajax;

    $(document).ready(function() {
        var currentDate = new Date();

        // Extract the year and month, format as yyyy-mm
        var year = currentDate.getFullYear();
        var month = ("0" + (currentDate.getMonth() + 1)).slice(-2);
        var formattedDate = year + '-' + month;

        $(".range").datepicker({
            format: "yyyy-mm",
            startView: "months",
            minViewMode: "months",
            autoclose: true,
        });

        $(".range").datepicker('setDate', formattedDate);
        $('#btn_filter').on('click', function() {
            periode = $('#periode_range').val();
            tgl = periode.split("-");
            detailBudget(tgl[0], tgl[1]);
        })
        detailBudget(year, month);
    });

    function formatNumber(num) {
        if (num == null) {
            return 0;
        } else {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        }
    }

    function detailBudget(y, m) {
        $('#dt_detail_budget').DataTable({
            'destroy': true,
            'lengthChange': false,
            'searching': true,
            'info': true,
            'paging': true,
            "autoWidth": false,
            "order": [
                [0, "asc"]
            ],
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                title: "Detail Budget",
                footer: true,
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    $('row:first c', sheet).attr('s', '2');
                }
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                'data': {
                    year: y,
                    month: m,
                },
                "url": "<?php echo site_url(); ?>eaf/report_tkb/detail_budget",
            },
            "columns": [{
                    "data": "id_pengajuan",
                    "render": function(data, type, row, meta) {
                        return `<span class = "label label-primary">${data}</span>`;
                    }
                },
                {
                    "data": "username"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "tgl_approve"
                },
                {
                    "data": "nama_penerima"
                },
                {
                    "data": "pengaju"
                },
                {
                    "data": "department"
                },
                {
                    "data": "nama_kategori"
                },
                {
                    "data": "nama_tipe"
                },
                {
                    "data": "nominal_uang",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge bg-default">0</span>`
                        } else {
                            // return 'Rp. ' + formatNumber(data)
                            return data;
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "keperluan"
                },
                {
                    "data": "budget"
                },
                {
                    "data": "note_user"
                },
                {
                    "data": "note_fnc"
                },
                {
                    "data": "nama_status"
                },
                {
                    "data": "status_lpj"
                },
                {
                    "data": "tanggal_lpj"
                },
                {
                    "data": "nominal_lpj",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge bg-default">0</span>`
                        } else {
                            // return 'Rp. ' + formatNumber(data)
                            return data;
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "deviasi",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge bg-default">0</span>`
                        } else {
                            // return 'Rp. ' + formatNumber(data)
                            return data;
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "cash_out",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge bg-default">0</span>`
                        } else {
                            // return 'Rp. ' + formatNumber(data)
                            return data;
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "actual_budget",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge bg-default">0</span>`
                        } else {
                            // return 'Rp. ' + formatNumber(data)
                            return data;
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "approval_lpj"
                },
            ],
            'footerCallback': function(row, data, start, end, display) {
                var api = this.api(),
                    data;

                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\Rp.]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                col_9 = api
                    .column(9, {
                        search: 'applied'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                $(api.column(9).footer()).html(
                    formatNumber(col_9)
                );

                col_16 = api
                    .column(16, {
                        search: 'applied'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                $(api.column(16).footer()).html(
                    formatNumber(col_16)
                );

                col_17 = api
                    .column(17, {
                        search: 'applied'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                $(api.column(17).footer()).html(
                    formatNumber(col_17)
                );

                col_18 = api
                    .column(18, {
                        search: 'applied'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                $(api.column(18).footer()).html(
                    formatNumber(col_18)
                );

                col_19 = api
                    .column(19, {
                        search: 'applied'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                $(api.column(19).footer()).html(
                    formatNumber(col_19)
                );

            },
        });
    }
</script>