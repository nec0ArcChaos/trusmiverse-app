<!-- Required Jquery -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap/js/bootstrap.min.js"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<!-- data-table js -->
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- i18next.min.js -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/advance-elements/moment-with-locales.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- Date-range picker js -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap-daterangepicker/js/daterangepicker.js"></script>
<!-- Datepicker -->
<script src="<?php echo base_url(); ?>assets/datepicker/js/bootstrap-datepicker.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/pcoded.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/demo-12.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/script.js"></script>

<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/dataTables.fixedColumns.min.js"></script>


<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/sweetalert/sweetalert.min.js"></script>

<!-- ckeditor -->
<script src="<?php echo base_url(); ?>assets/pages/ckeditor/ckeditor.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/pages/wysiwyg-editor/wysiwyg-editor.js"></script> -->

<script type="text/javascript" src="<?= base_url('assets/fancybox/jquery.fancybox.min.js') ?>"></script>

<!-- jspdf -->
<script src="<?php echo base_url(); ?>assets/jspdf/jspdf.umd.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jspdf/html2canvas.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jspdf/jspdf.plugin.autotable.js"></script>

<!-- slim select js -->
<script src="<?php echo base_url(); ?>assets/js/slimselect.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {

    //Datepicker
		var start = moment().startOf('month');
		var end = moment().endOf('month');

    function cb(start, end) {
      $('#reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="datestart"]').val(start.format('YYYY-MM-DD'));
      $('input[name="dateend"]').val(end.format('YYYY-MM-DD'));
      // data_report_budget(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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

	start = $('#datestart').val();
	end = $('#dateend').val();

	start_now = '<?= date('Y-m-d') ?>';
	end_now = '<?= date('Y-m-d') ?>';

	report_pembawaan(start, end);
	// daily_report(start_now, end_now);

		$('#filter_date').on('click', function() {
			datestart = $('#datestart').val();
			dateend = $('#dateend').val();

			// untuk export excel berdasarkan filter date
			// $('#datestart').val(datestart);
			// $('#dateend').val(dateend);

			report_pembawaan(datestart, dateend);
			// daily_report(datestart, dateend);

		});

    		// datepicker month
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

        year = '<?= date('Y') ?>';
        month = '<?= date('m') ?>';

        // data_report_budget(year, month);

        // $('#filter_period').on('click', function() {

        //   period = $('#period').val();
        //   // untuk export excel berdasarkan filter date
        //   // $('#datestart').val(datestart);
        //   // $('#dateend').val(dateend);

        //   year = period.substr(0, 4);
        //   month = period.substr(5, 2);

        //   data_report_budget(year, month);

        //   });

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
					"targets": [13, 14, 15, 16, 17, 18, 19,20],
					"visible": false,
					"searchable": false
				},
				{
					"targets": [21],
					"visible": true,
					"searchable": true
				},
			];
			coll_export = { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,21,22] };
		} else {
			coll = [
				{
					"targets": [12, 13, 14, 15, 16, 17, 18, 19],
					"visible": true,
					"searchable": true
				},{
					"targets": [21],
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
					"data": "pengaju"
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
							return `<span class="badge badge-default">0</span>`
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
							return `<span class="badge badge-danger">${data}</span>`
						} else {
							return `<span class="badge badge-success">${data}</span>`
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

//   Data daily
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

// Data daily item
	function data_daily_item(start, end, kategori, status) {
		if (kategori == 18) {
			table = '#dt_pembawaan';
			datas = [{
				"data": "tgl"
			},
			{
				"data": "qty",
				"render" : function (data, type, row) {
					return '<span class="label label-primary detail" data-kategori="18" data-status="5" data-tgl="'+ row['tanggal'] +'" style="cursor : pointer;">' + data + '</span>'
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
					return '<span class="label label-success detail" data-kategori="17" data-status="5" data-tgl="'+ row['tanggal'] +'" style="cursor : pointer;">' + data + '</span>'
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
					return '<span class="label label-info detail" data-kategori="19" data-status="11" data-tgl="'+ row['tanggal'] +'" style="cursor : pointer;">' + data + '</span>'
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
			}
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
  
</script>