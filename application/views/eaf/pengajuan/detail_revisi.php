 	<div class="row">
 		<div class="col-lg-5">
 			<div id="navigation">
 				<div class="row">
 					<div class="col-lg-12">
 						<div class="card version">
 							<div class="card-header">
 								<small>ID Pengajuan : </small><h5><?php echo $detail_pengajuan['id_pengajuan']; ?></h5>
 							</div>
 							<div class="card-block">
 								<ul class="nav navigation">
 									<li>
 										<a href="#v_1_5">Tanggal Input <span class="text-muted text-regular pull-right"><?php echo $detail_pengajuan['tgl_input']; ?></span></a>
 									</li>
 									<li>
 										<a href="#v_1_5">User Pembuat <span class="text-muted text-regular pull-right"><?php echo $detail_pengajuan['name']; ?></span></a>
 									</li>
 									<li>
 										<a href="#v_1_5">Divisi <span class="text-muted text-regular pull-right"><?php echo $detail_pengajuan['nama_divisi']; ?></span></a>
 									</li>
 									<li>
 										<a href="#v_1_5">Kategori <span class="text-muted text-regular pull-right"><?php echo $detail_pengajuan['nama_kategori']; ?></span></a>
 									</li>
 									<li>
 										<a href="#v_1_5">Tipe Pembayaran <span class="text-muted text-regular pull-right"><?php echo $detail_pengajuan['nama_tipe']; ?></span></a>
 									</li>
 									<li>
 										<a href="#v_1_5">Penerima <span class="text-muted text-regular pull-right"><?php echo $detail_pengajuan['nama_penerima']; ?></span></a>
 									</li>
									 <li>
										 <a href="#v_1_5">Bukti Nota 
											<?php if ($detail_pengajuan['photo_acc'] != '') { ?>
												<a data-fancybox="gallery" class=" pull-right" href="<?php echo base_url() ?>assets/uploads/eaf/<?php echo $detail_pengajuan['photo_acc'] ?>"> <i class="ti-image"></i></a>
												<input type="hidden" name="proses" value="update">
											<?php } else { ?>
												<input type="hidden" name="proses" value="insert">
											<?php } ?>
											<a href="javascript:void(0);" class="label label-warning edit_nota pull-right" data-id_pengajuan="<?= $detail_pengajuan['id_pengajuan']; ?>" data-photo="<?= $detail_pengajuan['photo_acc']; ?>" style="cursor:pointer;" title="Edit Lampiran"><i class="fa fa-pencil"></i></a>
										 </a>
									 </li>
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
 				<form id="form_revisi">
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
 									<td>
 										<textarea type="text" class="form-controll" name="note_revisi" id="note_revisi" value="<?php echo $detail_pengajuan['note']; ?>"><?php echo $detail_pengajuan['note']; ?></textarea>
									</td>
 									<td>
 										<input type="hidden" name="id_pengajuan" value="<?php echo $detail_pengajuan['id_pengajuan']; ?>">
 										<input type="text" class="form-controll" name="nominal_revisi" onkeyup="nominal($(this).val(), '#rupiah')" id="rupiah" value="<?php echo number_format($detail_pengajuan['nominal_uang'],0,',','.'); ?>">
 									</td>
 								</tr>
 							</tbody>
 						</table>
 					</div>
 				</form>
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
 											<span class="badge badge-success"><?php echo $row->status ?></span>								
 										<?php } else if ($row->status == "Reject") { ?>
 											<span class="badge badge-danger"><?php echo $row->status ?></span>
 										<?php } else if ($row->status == "Revisi") { ?>
 											<span class="badge badge-info"><?php echo $row->status ?></span>
 										<?php } else { ?>
 											<span class="badge badge-warning"><?php echo $row->status ?></span>
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
			<h5 class="modal-title">Edit Lampiran</h5>
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
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
				// console.log("Berhasil");
			});

			$('#btn_edit_nota').on('click', function() {
				if ($("#string_new").val() == "") {
				$("#nota_new").addClass('is-invalid');
				} else {
					$.ajax({
						url: '<?php echo base_url() ?>eaf/pengajuan/edit_nota',
						type: 'POST',
						dataType: 'JSON',
						data: {
							id_nota: $("#id_nota").val(),
							nota_new: $("#string_new").val(),
							proses: $('input[name="proses"]').val()
						},
						beforeSend: function(res){
							$('#btn_edit_nota').prop('disabled', true);
							// console.log("Waiting");
						},
						success: function(response) {
							swal("Success", "Nota berhasil di update!!", "success");
							// console.log("Berhasil");
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

 		function nominal(angka, id){
 			$(id).val(formatRupiah(angka, ''));
 		}

 		function formatRupiah(angka, prefix){
 			var number_string = angka.replace(/[^,\d]/g, '').toString(),
 			split       = number_string.split(','),
 			sisa        = split[0].length % 3,
 			rupiah        = split[0].substr(0, sisa),
 			ribuan        = split[0].substr(sisa).match(/\d{3}/gi);
 			if(ribuan){
 				separator = sisa ? '.' : '';
 				rupiah += separator + ribuan.join('.');
 			}
 			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
 			return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
 		}
 	</script>