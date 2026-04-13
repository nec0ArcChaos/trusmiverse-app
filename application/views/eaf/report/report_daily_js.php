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
    id_user = <?= $this->session->userdata('user_id'); ?>;

    /*Range*/
    var start = moment().startOf('month');
    var end = moment().endOf('month');
    function cb(start, end) {
      $('#reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="datestart"]').val(start.format('YYYY-MM-DD'));
      $('input[name="dateend"]').val(end.format('YYYY-MM-DD'));
    }

    $('#range').daterangepicker({
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
    data_daily(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
	data_daily_item(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'), 17, 3);
	data_daily_item(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'), 18, 3);
	data_daily_item(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'), 19, 7);
	data_daily_resume(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));

    $('#btn_filter').click(function() {
        data_daily($('input[name="datestart"]').val(), $('input[name="dateend"]').val());
		data_daily_item($('input[name="datestart"]').val(), $('input[name="dateend"]').val(), 17, 3);
		data_daily_item($('input[name="datestart"]').val(), $('input[name="dateend"]').val(), 18, 3);
		data_daily_item($('input[name="datestart"]').val(), $('input[name="dateend"]').val(), 19, 7);
		data_daily_resume($('input[name="datestart"]').val(), $('input[name="dateend"]').val());

    });

	$('#dt_pembawaan, #dt_reimburs, #dt_lpj').on('click', '.detail', function () {
		data_detail_daily(2, $(this).data('kategori'), $(this).data('status'), 0, 0, $(this).data('tgl'), 0);
	})

    

    

});

    function formatNumber(num) {
        if (num == null) {
            return 0;
        } else {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        }
    }

    function data_daily(start, end) {
		$.ajax({
			url: '<?= base_url() ?>eaf/report/data_daily',
			type: 'post',
			dataType: 'html',
			data: {start: start, end : end},
			success: function (response) {
				$('#data_daily').empty();
				$('#data_daily').append(response);
			}
		});
	}

	function data_daily_item(start, end, kategori, status) {
		if (kategori == 18) {
			table = '#dt_pembawaan';
			datas = [{
				"data": "tgl"
			},
			{
				"data": "qty",
				"render" : function (data, type, row) {
					return '<span class="badge bg-primary detail" data-kategori="18" data-status="3" data-tgl="'+ row['tanggal'] +'" style="cursor : pointer;">' + data + '</span>'
				},
				"className" : "text-center"
			},
			{
				"data": "nominal",
				render: function (data) {
					return formatNumber(data)
				},
				"className" : "text-right"
			},
			];
		} else if (kategori == 17) {
			table = '#dt_reimburs';
			datas = [{
				"data": "tgl"
			},
			{
				"data": "qty",
				"render" : function (data, type, row) {
					return '<span class="badge bg-success detail" data-kategori="17" data-status="3" data-tgl="'+ row['tanggal'] +'" style="cursor : pointer;">' + data + '</span>'
				},
				"className" : "text-center"
			},
			{
				"data": "nominal",
				render: function (data) {
					return formatNumber(data)
				},
				"className" : "text-right"
			},
			];
		} else {
			table = '#dt_lpj';
			datas = [{
				"data": "tgl"
			},
			{
				"data": "qty",
				"render" : function (data, type, row) {
					return '<span class="badge bg-info detail" data-kategori="19" data-status="7" data-tgl="'+ row['tanggal'] +'" style="cursor : pointer;">' + data + '</span>'
				},
				"className" : "text-center"
			},
			{
				"data": "pembawaan",
				render: function (data) {
					return formatNumber(data)
				},
				"className" : "text-right"
			},
			{
				"data": "nominal",
				render: function (data) {
					return formatNumber(data)
				},
				"className" : "text-right"
			},
			{
				"data": "sisa",
				render: function (data) {
					return formatNumber(data)
				},
				"className" : "text-right"
			},
			];
		}

		$(table).DataTable({
			'destroy': true,
			'lengthChange': false,
			'searching': false,
			'info': true,
			'paging': true,
			"autoWidth": false,
			"dom": 'Bfrtip',
			buttons: [{
				extend: 'excelHtml5',
				text: 'Export to Excel',
				title: "<?= $pageTitle ?>",
				footer: true,
				customize: function(xlsx) {
					var sheet = xlsx.xl.worksheets['sheet1.xml'];
					$('row:first c', sheet).attr('s', '2');
				}
			},
			// {
			// 	extend: 'print',
			// 	title: "<?= $pageTitle ?>",
			// 	footer: true
			// }
			],
			"drawCallback": function() {
				$('.dt-buttons > .btn').addClass('btn-outline-primary btn-sm');
			},
			"ajax": {
				"dataType": 'json',
				"type": "POST",
				"data": {
					start 	: start,
					end 	: end,
					kategori: kategori,
					status	: status
				},
				"url": "<?php echo site_url(); ?>eaf/report/data_daily_item",
			},
			"columns": datas
		});
	}

	function data_daily_resume(start, end) {
		$('#dt_resume').DataTable({
			'destroy': true,
			'lengthChange': false,
			'searching': false,
			'info': true,
			'paging': false,
			"autoWidth": false,
			"dom": 'Bfrtip',
			buttons: [{
				extend: 'excelHtml5',
				text: 'Export to Excel',
				title: "<?= $pageTitle ?>",
				footer: true,
				customize: function(xlsx) {
					var sheet = xlsx.xl.worksheets['sheet1.xml'];
					$('row:first c', sheet).attr('s', '2');
				}
			},
			
			],
			"drawCallback": function() {
				$('.dt-buttons > .btn').addClass('btn-outline-primary btn-sm');
			},
			"ajax": {
				"dataType": 'json',
				"type": "POST",
				"data": {
					start 	: start,
					end 	: end
				},
				"url": "<?php echo site_url(); ?>eaf/report/data_daily_resume",
			},
			"columns": [{
				"data" : "company_kode"
			},
			{
				"data" : "qty_pembawaan",
				"render" : function (data, type, row) {
					return `<span class="badge bg-primary" onclick="data_detail_daily(3, 18, 3, '`+ start +`', '`+ end +`', 0, `+ row[`bud_company_id`] +`)" style="cursor : pointer;">` + data + `</span>`
				},
				"className" : "text-center"
			},
			{
				"data" : "total_pembawaan",
				render: function (data) {
					return formatNumber(data)
				},
				"className" : "text-right"
			},
			{
				"data" : "qty_reimburs",
				"render" : function (data, type, row) {
					return `<span class="badge bg-success" onclick="data_detail_daily(3, 17, 3, '`+ start +`', '`+ end +`', 0, `+ row[`bud_company_id`] +`)" style="cursor : pointer;">` + data + `</span>`
				},
				"className" : "text-center"
			},
			{
				"data" : "total_reimburs",
				render: function (data) {
					return formatNumber(data)
				},
				"className" : "text-right"
			},
			{
				"data" : "qty_lpj",
				"render" : function (data, type, row) {
					return `<span class="badge bg-info" onclick="data_detail_daily(3, 19, 7, '`+ start +`', '`+ end +`', 0, `+ row[`bud_company_id`] +`)" style="cursor : pointer;">` + data + `</span>`
				},
				"className" : "text-center"
			},
			{
				"data" : "total_lpj_pembawaan",
				render: function (data) {
					return formatNumber(data)
				},
				"className" : "text-right"
			},
			{
				"data" : "total_lpj",
				render: function (data) {
					return formatNumber(data)
				},
				"className" : "text-right"
			},
			{
				"data" : "sisa"
			},
			]
		});
	}

	function data_detail_daily(tipe, kategori, status, start, end, tgl, company) {
		$('#modal_detail_budget').modal('show');
		console.info("tipe "+tipe);

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
					tipe : tipe,
					kategori : kategori,
					status : status,
					start : start,
					end : end,
					tgl : tgl,
					company : company
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
				"data": "pengaju_comp_name"
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
				"className": 'text-right'
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
				"className": 'text-right'
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
				"className": 'text-right'
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
				"className": 'text-right'
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
	}
	


</script>