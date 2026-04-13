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


		$('#company_id').change(function() {
			id = $(this).val();

			$.ajax({
				url: '<?php echo base_url() ?>od_designation/get_department/' + id,
				dataType: 'html',
				success: function(data) {
					$('#department_id').empty().append(data);
				}
			});

			$.ajax({
				url: '<?php echo base_url() ?>od_designation/get_designation/0',
				dataType: 'html',
				success: function(data) {
					$('#report_to').empty().append(data);
				}
			});
		});



		$('#btn_add').click(function() {

			company_id = $('#company_id');
			department_id = $('#department_id');
			designation_name = $('#designation_name');
			report_to = $('#report_to');

			if (company_id.val() == "") {
				company_id.select2('open');
			} else if (department_id.val() == "") {
				department_id.select2('open');
			} else if (designation_name.val() == "") {
				designation_name.focus();
			} else if (report_to.val() == "") {
				report_to.select2('open');
			} else {
				$.ajax({
					url: '<?php echo base_url() ?>od_designation/add_designation',
					type: 'POST',
					dataType: 'json',
					data: $('#form_designation').serialize(),
					success: function(response) {
						if (response.add == true) {
							swal("Success!", "Designation has been added", "success");
							$('#dt_designation').DataTable().ajax.reload();
							company_id.val('').trigger('change');
							department_id.val('').trigger('change');
							report_to.val('').trigger('change');
							$('#form_designation')[0].reset();
						}
					}
				});
			}
		});

		$('#btn_update').click(function() {

			company_id = $('#company_id');
			department_id = $('#department_id');
			report_to = $('#report_to');

			$.ajax({
				url: '<?php echo base_url() ?>od_designation/update_designation',
				type: 'POST',
				dataType: 'json',
				data: $('#form_designation').serialize(),
				success: function(response) {
					if (response.update == true) {
						swal("Success!", "Designation has been updated", "info");
						$('#dt_designation').DataTable().ajax.reload();
						company_id.val('').trigger('change');
						department_id.val('').trigger('change');
						report_to.val('').trigger('change');
						$('#form_designation')[0].reset();
						$('#btn_add').show();
						$('#btn_update').hide();
					}
				}
			});
		});

		$('#dt_designation').on('click', '.edit', function() {
			$('#btn_add').hide();
			$('#btn_update').show();
			$('#designation_id').val($(this).data('designation_id'));
			$('#designation_name').val($(this).data('designation_name'));
			$('#company_id').val($(this).data('company_id')).trigger('change');
			$.ajax({
				url: '<?php echo base_url() ?>od_designation/get_department/' + $(this).data('company_id') + '/' + $(this).data('department_id'),
				dataType: 'html',
				success: function(data) {
					$('#department_id').empty().append(data);
				}
			});
			$.ajax({
				url: '<?php echo base_url() ?>od_designation/get_designation/0/' + $(this).data('report_to'),
				dataType: 'html',
				success: function(data) {
					$('#report_to').empty().append(data);
				}
			});
		});

		$('#dt_designation').on('click', '.delete', function() {
			swal({
					title: "Attention!",
					text: "Are you sure to delete " + $(this).data('designation_name') + "?",
					icon: "error",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						$.ajax({
							url: '<?php echo base_url() ?>od_designation/delete_designation',
							type: 'POST',
							dataType: 'json',
							data: {
								designation_id: $(this).data('designation_id')
							},
							success: function(response) {
								if (response.delete == true) {
									swal("Success!", "Designation has been deleted", "success");
									$('#dt_designation').DataTable().ajax.reload();
								}
							}
						});
					}
				});
		});

		$('#dt_designation').DataTable({
			"lengthChange": false,
			"searching": true,
			"info": true,
			"paging": true,
			"autoWidth": false,
			"destroy": true,
			"dom": 'Bfrtip',
			"buttons": [{
				extend: 'excelHtml5',
				text: 'Export to Excel',
				filename: 'Designation List',
				footer: true
			}],

			"drawCallback": function() {
				$('.dt-buttons > .btn').addClass('btn btn-sm btn-info btn-sm');
			},
			"ajax": {
				'url': '<?php echo base_url() ?>od_designation/list_designation',
				'type': 'POST',
				'dataType': 'json',
			},
			"columns": [{
					'data': 'designation_id',
					'render': function(data, type, row) {
						edit = '<button style="cursor: pointer;" class="btn btn-md btn-outline-primary me-1 edit" data-designation_id="' + data + '" data-designation_name="' + row['designation_name'] + '" data-department_id="' + row['department_id'] + '" data-company_id="' + row['company_id'] + '" data-report_to="' + row['report_to'] + '"><i class="bi bi-pencil"></i> Edit</button>';

						return edit;
					}
				},
				{
					'data': 'designation_name',
					'render': function(data, type, row) {
						return data + '<br><span class="text-muted">Department: ' + row['department_name'] + '</span>'
					}
				},
				{
					'data': 'company_name'
				}
			]
		});
	});
</script>
