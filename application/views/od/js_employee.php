<!-- Datatable -->
<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/data-table/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<!-- sweetalert -->
<script src="<?php echo base_url() ?>assets/js/sweetalert.min.js"></script>


<script type="text/javascript">
	$(document).ready(function() {

		$('.select2').select2();

		$('#dt_employee').DataTable({
			"lengthChange": false,
			"searching": true,
			"info": true,
			"paging": true,
			"autoWidth": false,
			"destroy": true,
			dom: 'Bfrtip',
			buttons: [{
				extend: 'excelHtml5',
				text: 'Export to Excel',
				filename: 'Report To',
				footer: true
			}],
			"drawCallback": function() {
				$('.dt-buttons > .btn').addClass('btn btn-sm btn-info btn-sm');
			},
			"ajax": {
				'url': '<?php echo base_url() ?>employee/list_employees',
				'type': 'POST',
				'dataType': 'json',
			},
			"columns": [
			{
				'data': 'username',
			},
			{
				'data': 'employee',
			},
			{
				'data': 'name',
			},
			{
				'data': 'department_name',
			},
			{
				'data': 'designation_name',
			},
			{
				'data': 'report_to',
				'render': function(data) {
					if (data === null) {
						return '<small><i>No Data</i></small>'
					} else {
						return data
					}
				}
			}
			]
		});

		$('#dt_employee').on('click', '.edit', function() {
			$('#modal_edit_emp').modal('show');
			$('#user_id').val($(this).data('user_id'));
			if ($(this).data('report_to') == null) {
				$('#report_to').val(0).trigger('change');
			} else {
				$('#report_to').val($(this).data('report_to')).trigger('change');
			}
		});

		$('#btn_update').click(function() {
			if ($('#report_to').val() == "0") {
				$('#report_to').select2('open');
			} else {
				$.ajax({
					url: '<?php echo base_url() ?>employee/update_report_to',
					type: 'POST',
					dataType: 'json',
					data: $('#form_report_to').serialize(),
					success: function(data) {
						swal("Success", "Data telah diupdate!", "success");
						$('#modal_edit_emp').modal('hide');
						$('#dt_employee').DataTable().ajax.reload();
						$('#report_to').val('0').trigger('change');
					}
				});
			}
		});
	});
</script>
