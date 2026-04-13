<!-- third party js -->
<!-- <script src="<?php echo base_url() ?>assets/vendor/diagram/diagram.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/orgchart/2.1.3/js/jquery.orgchart.min.js"></script> -->
<!-- third party js ends -->


<!-- Datatable -->
<script src="<?php echo base_url() ?>assets/vendor/datatables/js/jquery.dataTables.min.js"></script>

<script src="<?php echo base_url() ?>assets/vendor/moment/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/daterangepicker.js"></script>
<!-- sweetalert -->
<script src="<?php echo base_url() ?>assets/js/sweetalert.min.js"></script>


<script type="text/javascript">
	$(document).ready(function() {

		$('.select2').select2();

		$('#company_id').change(function() {
			id = $(this).val();

			$.ajax({
				url: '<?php echo base_url() ?>od_department/get_location/' + id,
				dataType: 'html',
				success: function(data) {
					$('#location_id').empty().append(data);
				}
			});
		});

		$('#btn_add').click(function() {

			department_name = $('#department_name');
			company_id = $('#company_id');
			location_id = $('#location_id');
			head_id = $('#head_id');
			breaked = $('#break');

			if (department_name.val() == "") {
				department_name.focus();
			} else if (company_id.val() == "") {
				company_id.select2('open');
			} else if (location_id.val() == "") {
				location_id.select2('open');
			} else if (head_id.val() == "") {
				head_id.select2('open');
			} else if (breaked.val() == "") {
				breaked.select2('open');
			} else {
				$.ajax({
					url: '<?php echo base_url() ?>od_department/add_department',
					type: 'POST',
					dataType: 'json',
					data: $('#form_department').serialize(),
					success: function(response) {
						if (response.add == true) {
							swal("Success!", "Department has been added", "success");
							$('#dt_department').DataTable().ajax.reload();
							company_id.val('').trigger('change');
							location_id.val('').trigger('change');
							head_id.val('').trigger('change');
							breaked.val('0').trigger('change');
							$('#form_department')[0].reset();
						}
					}
				});
			}
		});

		$('#btn_update').click(function() {

			department_name = $('#department_name');
			company_id = $('#company_id');
			location_id = $('#location_id');
			head_id = $('#head_id');
			breaked = $('#break');

			$.ajax({
				url: '<?php echo base_url() ?>od_department/update_department',
				type: 'POST',
				dataType: 'json',
				data: $('#form_department').serialize(),
				success: function(response) {
					if (response.update == true) {
						swal("Success!", "Department has been updated", "info");
						$('#dt_department').DataTable().ajax.reload();
						company_id.val('').trigger('change');
						location_id.val('').trigger('change');
						head_id.val('').trigger('change');
						breaked.val('0').trigger('change');
						$('#form_department')[0].reset();
						$('#btn_add').show();
						$('#btn_update').hide();
					}
				}
			});
		});

		$('#dt_department').on('click', '.edit', function() {
			$('#btn_add').hide();
			$('#btn_update').show();
			$('#department_id').val($(this).data('department_id'));
			$('#department_name').val($(this).data('department_name'));
			$('#company_id').val($(this).data('company_id')).trigger('change');
			$("#head_id").val($(this).data('head_id')).trigger('change');
			$("#break").val($(this).data('break')).trigger('change');
			$('#department_kode').val($(this).data('department_kode'));
			
			var location_id = $(this).data('location_id');
			var company_id = $(this).data('company_id');
			
			$.ajax({
				url: '<?php echo base_url() ?>od_department/get_location/' + company_id + '/' + location_id,
				dataType: 'html',
				success: function(data) {
					$('#location_id').empty().append(data);
					$('#location_id').val(location_id).trigger('change');
				}
			});
		});

		$('#dt_department').on('click', '.delete', function() {
			swal({
					title: "Attention!",
					text: "Are you sure to delete " + $(this).data('department_name') + "?",
					icon: "error",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						$.ajax({
							url: '<?php echo base_url() ?>od_department/delete_department',
							type: 'POST',
							dataType: 'json',
							data: {
								department_id: $(this).data('department_id')
							},
							success: function(response) {
								if (response.delete == true) {
									swal("Success!", "Department has been deleted", "success");
									$('#dt_department').DataTable().ajax.reload();
								}
							}
						});
					}
				});
		});

		$('#dt_department').DataTable({
			"lengthChange": false,
			"searching": true,
			"info": true,
			"paging": true,
			"autoWidth": false,
			"destroy": true,
			"pageLength": 5,
			"ajax": {
				'url': '<?php echo base_url() ?>od_department/list_department',
				'type': 'POST',
				'dataType': 'json',
			},
			"columns": [{
					'data': 'department_id',
					'render': function(data, type, row) {
						edit = '<button style="cursor: pointer;" class="btn btn-md btn-outline-primary me-1 edit" data-department_id="' + data + '" data-department_name="' + row['department_name'] + '" data-department_id="' + row['department_id'] + '" data-company_id="' + row['company_id'] + '" data-location_id="' + row['location_id'] + '" data-head_id="' + row['head_id'] + '" data-break="' + row['break'] + '" data-department_kode="' + row['department_kode'] + '"><i class="bi bi-pencil"></i> Edit</button>';

						return edit;
					}
				},
				{
					'data': 'department_name',
					'render': function(data, type, row) {
						return `${data} (${row['department_kode']})` + '<br><span class="text-muted">Department Head: ' + row['department_head'] + '</span><br><span class="text-muted">Break: ' + row['break_name'] + '</span>'
					}
				},
				{
					'data': 'company_name',
					'render': function (data, type, row) {
						return data + '<br><span class="text-muted">Location: ' + row['location_name'] + '</span>'
					}
				}
			]
		});
	});
</script>