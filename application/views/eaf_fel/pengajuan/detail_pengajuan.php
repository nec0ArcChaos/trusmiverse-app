<div class="row">
	<div class="col-lg-5">
		<div id="navigation">
			<div class="row">
				<div class="col-lg-12">
					<div class="card version">
						<div class="card-header">
							<small>ID Pengajuan : </small>
							<h5 class="mb-0"><?php echo $detail_pengajuan['id_pengajuan']; ?></h5>
						</div>
						<div class="card-body">
							<ul class="nav flex-column">
								<li class="nav-item">
									<a class="nav-link text-dark" href="#v_1_5">Tanggal Input 
										<span class="text-muted float-end"><?php echo $detail_pengajuan['tgl_input']; ?></span>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link text-dark" href="#v_1_5">User Pembuat 
										<span class="text-muted float-end"><?php echo $detail_pengajuan['name']; ?></span>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link text-dark" href="#v_1_5">Divisi 
										<span class="text-muted float-end"><?php echo $detail_pengajuan['nama_divisi']; ?></span>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link text-dark" href="#v_1_5">Kategori 
										<span class="text-muted float-end"><?php echo $detail_pengajuan['nama_kategori']; ?></span>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link text-dark" href="#v_1_5">Tipe Pembayaran 
										<span class="text-muted float-end"><?php echo $detail_pengajuan['nama_tipe']; ?></span>
									</a>
								</li>
								<?php if ($detail_pengajuan['no_rek'] != ""): ?>
									<li class="nav-item">
										<a class="nav-link text-dark" href="#v_1_5">No Rekening 
											<span class="text-muted float-end"><?php echo $detail_pengajuan['no_rek']; ?> (<?php echo $detail_pengajuan['nama_bank']; ?>)</span>
										</a>
									</li>
								<?php endif; ?>
								<li class="nav-item">
									<a class="nav-link text-dark" href="#v_1_5">Penerima 
										<span class="text-muted float-end"><?php echo $detail_pengajuan['nama_penerima']; ?></span>
									</a>
								</li>
								<?php if ($detail_pengajuan['photo_acc'] == 'ba') { ?>
									<li class="nav-item">
										<a class="nav-link text-dark" href="#v_1_5">BA Reimbursement 
											<a href="<?php echo base_url() ?>eaf/finance/print_ba_reimburse?id=<?= $detail_pengajuan['id_pengajuan'] ?>" class="float-end" target="_blank" title="Print BA"><i class="bi-printer"></i></a>
										</a>
									</li>
								<?php } else if ($detail_pengajuan['photo_acc'] != "") { ?>
									<li class="nav-item">
										<div class="d-flex justify-content-between align-items-center">
											<a class="nav-link text-dark" href="#v_1_5">Bukti Nota</a>
											<span class="d-flex align-items-center">
												<a data-fancybox="gallery" href="<?php echo base_url() ?>uploads/eaf/<?php echo $detail_pengajuan['photo_acc'] ?>" class="me-2">
													<i class="bi-image"></i>
												</a>
												<?php if ($detail_pengajuan['edit_nota'] == 'edit') { ?>
													<a href="javascript:void(0);" class="badge bg-warning edit_nota" data-id_pengajuan="<?= $detail_pengajuan['id_pengajuan']; ?>" data-photo="<?= $detail_pengajuan['photo_acc']; ?>" style="cursor:pointer;" title="Edit Nota LPJ">
														<i class="bi bi-pencil"></i>
													</a>
												<?php } ?>
											</span>
										</div>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-7">
		<div class="card card-border-primary">
			<div class="card-header">
				<h5>Detail Keperluan</h5>
			</div>
			<div class="dt-responsive table-responsive">
				<table id="" class="table table-striped table-bordered nowrap">
					<thead>
						<tr>
							<th width="40%">Keperluan</th>
							<th width="30%">Note</th>
							<th width="30%">Nominal</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $detail_pengajuan['nama_keperluan']; ?></td>
							<td><?php echo $detail_pengajuan['note']; ?></td>
							<td><?php echo "Rp " . number_format($detail_pengajuan['nominal_uang'],0,',','.'); ?></td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="2"><span class="pull-right">Total</span></th>
							<th><?php echo "Rp " . number_format($detail_pengajuan['nominal_uang'],0,',','.'); ?></th>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="card-footer">
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-lg-12">
		<div class="card card-border-success">
			<div class="card-header">
				<h5>Tracking Approval</h5>
			</div>
			<div class="dt-responsive table-responsive">
				<table id="" class="table table-striped table-bordered nowrap">
					<thead>
						<tr>
							<th>User Approval</th>
							<th>Tanggal Approve</th>
							<th>Status</th>
							<th>Note</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($tracking_approval as $row): ?>
							<tr>
								<td><?php echo $row->employee_name ?></td>
								<td><?php echo $row->update_approve ?></td>
								<td>
									<?php if ($row->status == "Approve") { ?>
										<span class="badge bg-success"><?php echo $row->status ?></span>								
									<?php } else if ($row->status == "Reject") { ?>
										<span class="badge bg-danger"><?php echo $row->status ?></span>
									<?php } else if ($row->status == "Revisi") { ?>
										<span class="badge bg-info"><?php echo $row->status ?></span>
									<?php } else { ?>
										<span class="badge bg-warning"><?php echo $row->status ?></span>
									<?php } ?>
								</td>
								<td><?php echo $row->note_approve ?></td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
			<div class="card-footer">
			</div>
		</div>
	</div>
</div>

<!-- Modal Edit Nota LPJ -->
<div class="modal fade" id="modal_edit_nota" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Nota</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form id="form_edit_nota">
			<div class="row mb-3">
				<div class="col-12">
					<label for="id_nota">Id. Pengajuan</label>
					<input type="text" class="form-control" id="id_nota" name="id_nota" readonly>
					<input type="hidden" name="proses" value="update">
				</div>				
			</div>
			<div class="row">
				<div class="col-12">
					<label id="attch">Lampiran</label>
					<input style="padding: .4rem .75rem;" type="file" id="nota_new" class="form-control" onchange="compress('#nota_new', '#string_new', '.fa_wait_new', '.fa_done_new')" accept=".pdf,.jpg,.jpeg,.png">
					<small id="emailHelp" class="form-text text-muted">Diperbolehkan : .pdf, .jpg, .jpeg, .png (Jika lampiran lebih dari 1, gabungkan jadi 1 file pdf)</small>
					<input type="hidden" class="form-control" name="nota_new" id="string_new">
					<div class="fa_wait_new" style="display: none;"><i class="fa fa-spinner fa-pulse"></i> <label>Uploading File ...</label></div>
					<div class="fa_done_new" style="display: none;"><i class="fa fa-check-circle" style="color: #689f38;"></i> <label>Upload Complete.</label></div>
				</div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary" id="btn_edit_nota">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function() 
	{
		$('.edit_nota').on('click', function() {
			$("#modal_edit_nota").modal("show");
			$("#id_nota").val($(this).data("id_pengajuan"));
			console.log("Berhasil");
		});

		$('#btn_edit_nota').on('click', function() {
			if ($("#string_new").val() == "") {
			  $("#nota_new").addClass('is-invalid');
			} else {
				$.ajax({
			        url: '<?php echo base_url() ?>eaf/pengajuan/edit_nota',
			        type: 'post',
			        dataType: 'json',
			        data: $('#form_edit_nota').serialize(),
					beforeSend: function(res){
						$('#btn_edit_nota').prop('disabled', true);
						console.log("Waiting");
					},
			        success: function(response) {
						swal("Success", "Nota berhasil di update!!", "success");
						console.log("Berhasil");
						$('#btn_edit_nota').prop('disabled', false);
						$('#dt_list_eaf').DataTable().ajax.reload();
						$('#modal_detail_pengajuan').modal('hide');
						$('#modal_edit_nota').modal('hide');
						$('#form_edit_nota')[0].reset();
			        },
					error: function(xhr){
						console.log(xhr.responseText);
					}
				});
			}
		});

		$("#nota_new").change(function(e) {
          $("#nota_new").removeClass('is-invalid');
        });
	});

	function compress(file_upload, string, submit, wait, done) {

		$(wait).show();
		$(done).hide();
		$(submit).prop('disabled', true);

		const file = document.querySelector(file_upload).files[0];

		extension = file.name.substr((file.name.lastIndexOf('.') + 1));

		if (!file) return;

		const reader = new FileReader();

		reader.readAsDataURL(file);

		reader.onload = function(event) {
			const imgElement = document.createElement("img");
			imgElement.src = event.target.result;

			// if (extension == "jpg" || extension == "jpeg" || extension == "png" || extension == "gif") {

			// 	extension = 'png,';

			// 	imgElement.onload = function(e) {
			// 		const canvas = document.createElement("canvas");

			// 		if (e.target.width > e.target.height) {
			// 			const MAX_WIDTH = 600;
			// 			const scaleSize = MAX_WIDTH / e.target.width;
			// 			canvas.width = MAX_WIDTH;
			// 			canvas.height = e.target.height * scaleSize;
			// 		} else {
			// 			const MAX_HEIGHT = 600;
			// 			const scaleSize = MAX_HEIGHT / e.target.height;
			// 			canvas.height = MAX_HEIGHT;
			// 			canvas.width = e.target.width * scaleSize;
			// 		}

			// 		const ctx = canvas.getContext("2d");

			// 		ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);

			// 		const srcEncoded = ctx.canvas.toDataURL(e.target, "image/jpeg");

			// 		var g_string = extension + srcEncoded.substr(srcEncoded.indexOf(',') + 1);
			// 		document.querySelector(string).value = g_string;
			// 	}
			// } else {
				var g_string = extension + ',' + event.target.result.substr(event.target.result.indexOf(',') + 1);
				document.querySelector(string).value = g_string;
			// }

		}
	}



</script>