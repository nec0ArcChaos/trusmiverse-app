<input type="hidden" id="start" value="<?= $start ?>">
<input type="hidden" id="end" value="<?= $end ?>">

<div class="col-md-12 col-xl-4">
    <div class="card last-week-card">
        <div class="card-block">
            <div class="row">
                <div class="col-3 text-left p-b-30">
                    <i class="icofont icofont-briefcase-alt-1 text-c-blue f-60"></i>
                </div>
                <div class="col-9 text-right">
                    <h3 class="text-c-blue"><?= number_format($daily['total_pembawaan'],0,',','.') ?></h3>
                    <p class="text-muted">Total Pembawaan</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 text-left">
                    <p class="text-muted m-0">Qty EAF</p>
                </div>
                <div class="col-sm-6 text-right">
                    <span class="label bg-c-blue value-badges detail_pembawaan" data-kategori="18" data-status="5" style="cursor: pointer;"><?= $daily['qty_pembawaan'] ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-xl-4">
    <div class="card last-week-card">
        <div class="card-block">
            <div class="row">
                <div class="col-3 text-left p-b-30">
                    <i class="icofont icofont-money text-c-green f-60"></i>
                </div>
                <div class="col-9 text-right">
                    <h3 class="text-c-green"><?= number_format($daily['total_reimburs'],0,',','.') ?></h3>
                    <p class="text-muted">Total Reimbursment</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 text-left">
                    <p class="text-muted m-0">Qty EAF</p>
                </div>
                <div class="col-sm-6 text-right">
                    <span class="label bg-c-green value-badges detail_pembawaan" data-kategori="17" data-status="5" style="cursor: pointer;"><?= $daily['qty_reimburs'] ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-xl-4">
    <div class="card last-week-card">
        <div class="card-block">
            <div class="row">
                <div class="col-3 text-left p-b-30">
                    <i class="icofont icofont-coins text-twiter f-60"></i>
                </div>
                <div class="col-9 text-right">
                    <h3 class="text-twiter"><?= number_format($daily['total_lpj'],0,',','.') ?></h3>
                    <p class="text-muted">Total LPJ</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 text-left">
                    <p class="text-muted m-0">Qty LPJ</p>
                </div>
                <div class="col-sm-6 text-right">
                    <span class="label bg-twiter value-badges detail_pembawaan" data-kategori="19" data-status="11" style="cursor: pointer;"><?= $daily['qty_lpj'] ?></span>
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
                "url": "<?= base_url() ?>finance/data_detail_daily",
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
                "data": "nama_divisi"
            },
            {
                "data": "nama_penerima"
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
                        return `<span class="badge badge-default">0</span>`
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

                col_8 = api
                .column(8, {
                    search: 'applied'
                })
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                $(api.column(8).footer()).html(
                    formatNumber(col_8)
                    );

                col_15 = api
                .column(15, {
                    search: 'applied'
                })
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                $(api.column(15).footer()).html(
                    formatNumber(col_15)
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
            },
        });
})
</script>