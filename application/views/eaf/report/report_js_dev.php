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
		report_pembawaan(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
		
		$('#btn_filter').click(function() {
			report_pembawaan($('input[name="datestart"]').val(), $('input[name="dateend"]').val())
		});

		$("#periode").datepicker({
			format: "yyyy-mm",
			viewMode: "year",
			minViewMode: "months",
			autoclose: true,
			orientation: "bottom",

		});

		$('#periode').on('change', function() {
			$('input[name="period"]').attr('value', this.value)
		});
		//  end date picker month

		$('#status').on('change', function() {
		if ($(this).val() == '4') {
			$(this).css('border-color', 'green');
			$('#btn_save').removeClass();
			$('#btn_save').addClass('btn btn-success');
			$('#btn_save').text('Approve');
		} else if ($(this).val() == '6') {
			$(this).css('border-color', 'red');
			$('#btn_save').removeClass();
			$('#btn_save').addClass('btn btn-danger');
			$('#btn_save').text('Reject');
		} else if ($(this).val() == '13') {
			$(this).css('border-color', 'orange');
			$('#btn_save').removeClass();
			$('#btn_save').addClass('btn btn-warning');
			$('#btn_save').text('Revisi');
		}
		});
	});

	function formatNumber(num) {
      if (num == null) {
        return 0;
      } else {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      }
    }

	//   Report EAF
	function report_pembawaan(start, end) {

		cat = <?= $id_kategori ?>;
		tipe = <?= $tipe ?>;
		//  Tipe 1 =  sudah LPJ
		//  Tipe 2 =  Belum LPJ
		//  Tipe 3 =  Terlambat > 1 Hari LPJ

		if (cat == 17) {
			coll = [
				{
					"targets": [16, 17, 18, 19,20,21,22,23],
					"visible": false,
					"searchable": false
				},
				{
					"targets": [24],
					"visible": true,
					"searchable": true
				},
			];
			coll_export = { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,13,15,24] };
		} else {
			coll = [
				{
					"targets": [12, 13, 14, 15, 16, 17, 18, 19],
					"visible": true,
					"searchable": true
				},{
					"targets": [24],
					"visible": false,
					"searchable": false
				},
			];
			coll_export = { columns: ':visible' };
		}

		$('#dt_report').DataTable({
			'destroy': true,
			'lengthChange': false,
			'searching': true,
			'info': true,
			'paging': true,
			"autoWidth": false,
			"columnDefs": coll,
			"order": [
				[2, "desc"]
			],
			"dom": 'Bfrtip',
			buttons: [{
					extend: 'excelHtml5',
					exportOptions: coll_export,
					text: 'Export to Excel',
					title: "<?= $pageTitle ?>",
					footer: true,
					customize: function(xlsx) {
						var sheet = xlsx.xl.worksheets['sheet1.xml'];
						$('row:first c', sheet).attr('s', '2');
					}
				}
			],
			"drawCallback": function() {
				$('.dt-buttons > .btn').addClass('btn-outline-primary btn-sm');
			},
			"ajax": {
				"dataType": 'json',
				"type": "POST",
				"data": {
					datestart: start,
					dateend: end,
					id_kategori: cat,
					tipe: tipe
				},
				"url": "<?= base_url('eaf/report/data_report_eaf') ?>"
			},
			"columns": [
				{
					"data": "bud_company_name"
				},
				{
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
					"data": "pengaju"
				},
				{
					"data": "pengaju_comp_name"
				},
				{
					"data": "pengaju_dept_name"
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
					"data": "nominal_uang",
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
					"data": "status_lpj"
				},
				{
					"data": "tanggal_lpj"
				},
				{
					"data": "nominal_lpj",
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
					"data": "deviasi",
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
				{
					"data": "leadtime",
					render: function(data) {
						// return data + ' Hari'
						return data + ' Jam'
					}
				},
				{
					"data": "status_leadtime", 
					render: function(data) {
						if (data == 'Late') {
							return `<span class="badge bg-danger">${data}</span>`
						} else {
							return `<span class="badge bg-success">${data}</span>`
						}
					}
				},
				{
					"data": "tgl_nota"
				},
				{
					"data": "finance",
					className: "text-center"
				}
			]
		});

	}
</script>