<input type="hidden" id="start" value="<?= $start ?>">
<input type="hidden" id="end" value="<?= $end ?>">
<style>
        .last-week-card {
            border-radius: 10px;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .value-badges {
            padding: 5px 10px;
            border-radius: 20px;
            color: white;
        }
        .text-c-blue { color: #4e89ff; }
        .bg-c-blue { background-color: #4e89ff; }
        .text-c-green { color: #8bc34a; }
        .bg-c-green { background-color: #8bc34a; }
        .text-twiter { color: #5bc0de; }
        .bg-twiter { background-color: #5bc0de; }
        /* i { font-size: 50px; } */
    </style>

<div class="col-md-12 col-xl-4">
    <div class="card last-week-card">
        <div class="card-block">
            <div class="row">
                <div class="col-3 d-flex justify-content-start align-items-center" style="font-size: 50px;">
                    <i class="icofont icofont-briefcase-alt-1 text-c-blue f-60"></i>
                </div>
                <div class="col-9 d-flex flex-column align-items-end justify-content-center">
                    <h3 class="text-c-blue"><?= number_format($daily['total_pembawaan'],0,',','.') ?></h3>
                    <p class="text-muted">Total Pembawaan</p>
                </div>
            </div>
            <div class="row" style="margin-top:10px">
                <div class="col-sm-6 d-flex flex-column align-items-start justify-content-center">
                    <p class="text-muted m-0">
                        Qty EAF
                    </p>
                </div>
                <div class="col-sm-6 d-flex flex-column align-items-end justify-content-center">
                    <span class="label bg-c-blue value-badges detail_pembawaan" data-kategori="18" data-status="3" style="cursor: pointer;"><?= $daily['qty_pembawaan'] ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-xl-4">
    <div class="card last-week-card">
        <div class="card-block">
            <div class="row">
                <div class="col-3 d-flex justify-content-start align-items-center" style="font-size: 50px;">
                    <i class="icofont icofont-money text-c-green f-60"></i>
                </div>
                <div class="col-9 d-flex flex-column align-items-end justify-content-center">
                    <h3 class="text-c-green"><?= number_format($daily['total_reimburs'],0,',','.') ?></h3>
                    <p class="text-muted">Total Reimbursment</p>
                </div>
            </div>
            <div class="row" style="margin-top:10px">
                <div class="col-sm-6 d-flex flex-column align-items-start justify-content-center">
                    <p class="text-muted m-0">Qty EAF</p>
                </div>
                <div class="col-sm-6 d-flex flex-column align-items-end justify-content-center">
                    <span class="label bg-c-green value-badges detail_pembawaan" data-kategori="17" data-status="3" style="cursor: pointer;"><?= $daily['qty_reimburs'] ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-xl-4">
    <div class="card last-week-card">
        <div class="card-block">
            <div class="row">
                <div class="col-3 d-flex justify-content-start align-items-center" style="font-size: 50px;">
                    <i class="icofont icofont-coins text-twiter f-60"></i>
                </div>
                <div class="col-9 d-flex flex-column align-items-end justify-content-center">
                    <h3 class="text-twiter"><?= number_format($daily['total_lpj'],0,',','.') ?></h3>
                    <p class="text-muted">Total LPJ</p>
                </div>
            </div>
            <div class="row" style="margin-top:10px">
                <div class="col-sm-6 d-flex flex-column align-items-start justify-content-center">
                    <p class="text-muted m-0">Qty LPJ</p>
                </div>
                <div class="col-sm-6 d-flex flex-column align-items-end">
                    <span class="label bg-twiter value-badges detail_pembawaan" data-kategori="19" data-status="7" style="cursor: pointer;"><?= $daily['qty_lpj'] ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.detail_pembawaan').on('click', function () {
        $('#modal_detail_budget').modal('show');

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
                    tipe : 1,
                    kategori : $(this).data('kategori'),
                    status : $(this).data('status'),
                    start : $('#start').val(),
                    end : $('#end').val(),
                    tgl : 0,
                    divisi : 0
                },
                "url": "<?= base_url() ?>eaf/report/data_detail_daily",
            },
            "columns": [{
                "data": "id_pengajuan"
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
                "data": "pengaju_dept_name"
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
                        return `<span class="badge badge-default">0</span>`
                    } else {
                        return formatNumber(data)
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
                "data": "note"
            },
            {
				"data": "note_keperluan"
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
                        return `<span class="badge badge-default">0</span>`
                    } else {
                        return formatNumber(data)
                    }
                },
                className: 'text-right'
            },
            {
                "data": "deviasi",
                "render": function(data, type) {
                    if (data == null) {
                        return `<span class="badge badge-default">0</span>`
                    } else {
                        return formatNumber(data)
                    }
                },
                className: 'text-right'
            },
            {
                "data": "actual_budget",
                "render": function(data, type) {
                    if (data == null) {
                        return `<span class="badge bg-secondary">0</span>`
                    } else {
                        return formatNumber(data)
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
})
</script>