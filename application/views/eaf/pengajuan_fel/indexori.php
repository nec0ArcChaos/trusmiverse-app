<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fancybox/jquery.fancybox.min.css" />

<style type="text/css">
	.lb-prev {
		display: none;
	}

	.lb-next {
		display: none;
	}

	.lb-details {
		display: none;
	}

	.fancybox-infobar {
		display: none;
	}

	.fancybox-toolbar {
		display: none;
	}

	.fancybox-navigation {
		display: none;
	}

	#fancybox-wrap {
		z-index: 1000000000;
	}
</style>

<!-- Spinner -->
<div class="modal fade bd-example-modal-lg" id="spinner" data-backdrop="static" data-keyboard="false" tabindex="-1">
	<div class="modal-dialog modal-sm">
		<div class="modal-content" style="width: 48px">
			<span class="fa fa-spinner fa-spin fa-3x"></span>
		</div>
	</div>
</div>
<!-- End Spinner -->

<div class="page-body">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-block">
					<h4 class="sub-title" style="font-size: 12pt;"><strong><?php echo $pageTitle ?></strong></h4>
					<div class="row" style="margin-bottom: 10px;">
						<div class="col-sm-4">
							<form method="POST" id="form_filter">
								<div class="row">
									<div class="col-sm-12">
										<div class="input-group input-group-button" id="reportrange">
											<input type="text" class="form-control" id="range" style="cursor: pointer;">
											<input type="hidden" name="datestart" value="" id="datestart" />
											<input type="hidden" name="dateend" value="" id="dateend" />
											<button type="button" class="btn btn-info btn-outline-info" id="btn_filter">
												<span class="">Filter</span>
											</button>
										</div>
									</div>
								</div>
							</form>
						</div>
						<div class="col-sm-5"></div>
						<div class="col-sm-3">
							<span id="btn_add_pengajuan" class="btn btn-primary btn-square" style="width: 100%"><i class="ti-plus"></i> Pengajuan EAF</span>
						</div>
					</div>

					<div class="dt-responsive table-responsive">
						<table id="dt_list_eaf" class="table table-striped table-bordered nowrap">
							<thead>
								<tr>
									<th>No Pengajuan</th>
									<th>Tanggal Input</th>
									<th>Status</th>
									<th>Nama Penerima</th>
									<th>Yg Mengajukan</th>
									<th>Kategori</th>
									<th>Keperluan</th>
									<th>Divisi</th>
									<th>Admin</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style type="text/css">
	@media (min-width: 800px) {
		.modal-xl {
			max-width: 90%; 
		}
	}
	.ss-main .ss-multi-selected .ss-values {
		flex-wrap: wrap-reverse !important;
	}
</style>

<div class="modal fade" id="modal_add_pengajuan" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Form Pengajuan EAF</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
				<form id="form_keperluan" autocomplete="off">
					<div class="form-group row">
						<div class="col-lg-4 col-sm-2">
							<label>Nama Penerima</label>
							<input type="text" id="nama_penerima" name="nama_penerima" class="form-control" placeholder="Nama Penerima"><br>
						</div>
						<div class="col-lg-4 col-sm-2">
							<label>Yang Mengajukan</label>
							<select name="pengaju" id="pengaju">
								<option data-placeholder="true">-- Pilih Yang Mengajukan --</option>
								<?php foreach($pengaju as $row):?>
									<option value="<?php echo $row->id_user; ?>" <?php echo ($row->id_user == $this->session->userdata('id_user')) ? "selected" : "" ; ?>><?php echo $row->employee_name;?></option>
								<?php endforeach;?>
							</select>
						</div>
						<div class="col-lg-4 col-sm-2">
							<label>Nama Kategori</label>
							<select class="form-control" name="kategori" id="kategori" required>
								<option value="">-- Pilih Kategori --</option>
								<?php foreach($kategori as $row):?>
									<?php if (in_array($this->session->userdata('id_user'), [1,61,495,747]) && $row->id_kategori == 20): ?>
										<option value="<?php echo $row->id_kategori;?>"><?php echo $row->nama_kategori;?></option>
									<?php else: ?>
										<option value="<?php echo $row->id_kategori;?>"><?php echo $row->nama_kategori;?></option>
									<?php endif ?>
								<?php endforeach;?>
							</select>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-lg-4 col-sm-2 col-xs-2">
							<label>Tipe Pembayaran</label>
							<select class="form-control" id="dd_tipe" name="tipe" required>
								<option value="">-- Tipe Pembayaran --</option>									
								<option value="Tunai">Tunai</option>
								<option value="Transfer Bank">Transfer Bank</option>
								<option value="Giro">Giro</option>
							</select>
						</div>
						<div class="col-lg-4 col-sm-2 col-xs-2">
							<label>Nama Bank:</label>
							<input class="form-control" id="txtbank" type="text" name="nama_bank" placeholder="Nama Bank" disabled>
						</div>
						<div class="col-lg-4 col-sm-2 col-xs-2">
							<label >Rekening:</label>
							<input class="form-control nomer" id="txtrek" type="number" placeholder="Nomor Rekening"name="rekening" disabled >
						</div>			
					</div>


					<label><strong>Detail Keperluan</strong></label>
					<hr>

					<div class="form-group row">
						<div class="col-lg-6 col-sm-2 col-xs-2">
							<label>Nama Keperluan</label>
							<select name="keperluan" id="keperluan">
								<option data-placeholder="true">-- Pilih Keperluan --</option>
								<?php foreach ($jenis_biaya as $row): ?>
									<option value="<?php echo $row->id_jenis.'|'.$row->id_biaya.'|'.$row->jenis.'|'.$row->id_user_approval.'|'.$row->id_tipe_biaya.'|'.$row->budget.'|'.$row->project.'|'.$row->blok.'|'.$row->id_user_verified.'|'.$row->ba ?>"><?php echo $row->jenis . ' (' . $row->employee . ')' ?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="col-lg-3 col-sm-2 col-xs-2">
							<label>Total</label>
							<input type="text" id="rupiah" onkeyup="nominal($(this).val(), '#rupiah')" class="form-control nominal" placeholder="Total" name="total">
							<input type="hidden" id="tipe_budget">
							<input type="hidden" id="sisa_budget">
							<input type="hidden" name="leave_id" id="leave_id">
						</div>
						<div class="col-lg-3 col-sm-2 col-xs-2">
							<label>Note</label>
							<textarea class="form-control" placeholder="Note" name="note" id="note"></textarea>
							<!-- <small class="text-secondary">*Dilarang pakai petik</small> -->
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-6 col-sm-2 col-xs-2" id="project_hide" style="display:none;">
							<label>Pilih Project</label>
							<select name="project" id="project">
								<option data-placeholder="true">-- Pilih Project --</option>
								<?php foreach ($project as $row):?>
									<option value="<?= $row->id_project ?>"><?= $row->project ?></option>
								<?php endforeach ?>
							</select>
							<small id="emailHelp" class="form-text text-muted">Jika bukan keperluan perumahan, pilih <b>Holding</b></small>
						</div>
						<div class="col-lg-6 col-sm-2 col-xs-2" id="pilihan_ba_hide" style="display:none;">
							<label>Pilih File/BA</label>
							<select class="form-control" name="pilihan_ba" id="pilihan_ba" style="height: 36px;">
								<option value="file">File</option>
								<option value="ba">BA</option>
							</select>
						</div>
						<input type="hidden" id="kondisi_pilihan_ba">
						<div class="col-lg-6 col-sm-2 col-xs-2" id="blok_hide" style="display:none;">
							<label>Pilih Blok</label>
							<select name="blok" multiple id="blok" style="height: 36px;">
								<option data-placeholder="true">-- Pilih Blok --</option>
							</select>
							<input type="hidden" id="type_blok" readonly>
							<input type="hidden" id="list_blok" name="list_blok" readonly>
							<input type="hidden" id="get_jenis" name="get_jenis" readonly>
						</div>
					</div>	

					<div class="row">						
						<div class="col-lg-2 col-sm-2 col-xs-2 pinjaman_karyawan" style="display:none;">
							<label>Jumlah Termin</label>
							<select class="form-control" name="jumlah_termin" id="jumlah_termin" style="height: 36px;" onchange="nominal_per_termin()">
								<option value="">-Pilih-</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
							</select>
						</div>
						<div class="col-lg-4 col-sm-2 col-xs-2 pinjaman_karyawan" style="display:none;">
							<label>Nominal per Termin</label>
							<input type="text" id="nominal_termin" class="form-control" placeholder="Nominal per Termin" name="nominal_termin" readonly>
						</div>
						<div class="col-lg-4 col-sm-2 col-xs-2 tgl_hide pilihan_ba_hide" style="display: none;">
							<label>Tanggal Nota</label>
							<input type="text" id="tanggal" class="form-control tanggal" placeholder="Tanggal" name="tgl_nota"><input type="hidden" width="20px" id="diff">
						</div>
						<div class="col col-sm pilihan_ba_hide">
							<label id="attch">Lampiran</label>
							<input style="padding: .4rem .75rem;" type="file" id="nota" class="form-control" onchange="compress('#nota', '#string', '.fa_wait', '.fa_done')" accept=".pdf,.jpg,.jpeg,.png">
							<small id="emailHelp" class="form-text text-muted">Diperbolehkan : .pdf, .jpg, .jpeg, .png (Jika lampiran lebih dari 1, gabungkan jadi 1 file pdf)</small>
							<input type="hidden" class="form-control" name="nota" id="string">
							<div class="fa_wait" style="display: none;"><i class="fa fa-spinner fa-pulse"></i> <label>Checking File ...</label></div>
							<div class="fa_done" style="display: none;"><i class="fa fa-check-circle" style="color: #689f38;"></i> <label>File Complete.</label></div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success" id="save_eaf">Save</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_detail_pengajuan" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Detail Pengajuan EAF</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="data_detail_pengajuan">
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Edit Blok & Note -->
<div class="modal fade" id="modal_edit_blok" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Blok</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form_edit_blok">
					<div class="row mb-3">
						<div class="col-12">
							<label for="id_aju">No. EAF</label>
							<input type="text" class="form-control" id="id_aju" name="id_aju" readonly>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-12">
							<label for="pro">Project</label>
							<input type="text" class="form-control" id="pro" name="pro" readonly>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-12">
							<label for="blok_old">Blok Sekarang</label>
							<textarea class="form-control" name="blok_old" id="blok_old" cols="30" rows="3" readonly></textarea>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-12">
							<label for="blok_new">Blok Edited</label>
							<select name="blok_new" id="blok_new" multiple onchange="pilih_blok()">
								<option data-placeholder="true">-Pilih Blok-</option>
							</select>
							<input type="hidden" id="list_blok_edit" name="list_blok_edit">
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<label for="note_pengajuan">Note Pengajuan</label>
							<textarea class="form-control" name="note_pengajuan" id="note_pengajuan" cols="30" rows="3"></textarea>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<div id="loading_edit_blok"><img src="<?= base_url('./assets/loading/loading.gif'); ?>" style="height:40.75px;width:auto;"></div>
				<!-- <div id="loading_edit_blok"><img src="https://miro.medium.com/v2/resize:fit:1400/1*CsJ05WEGfunYMLGfsT2sXA.gif" style="height:40.75px;width:auto;"></div> -->
				<button type="button" class="btn btn-primary" onclick="simpan_edit_blok()" id="btn_edit_blok">Save changes</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Edit Nota LPJ -->
<!-- <div class="modal fade" id="modal_edit_nota" tabindex="-1" role="dialog">
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
					<label for="no_eaf_nota">No. EAF</label>
					<input type="text" class="form-control" id="no_eaf_nota" name="no_eaf_nota" readonly>
				</div>
			</div>
		</form>
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary" onclick="simpan_edit_note()" id="btn_edit_nota">Save changes</button>
      </div>
    </div>
  </div>
</div> -->

<!-- js upload foto -->
<script type="text/javascript">
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
		if ($("#jumlah_termin").val().length > 0) {
			nominal_per_termin();
		}
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

			// function diff_date(start, end, ba, id){
			// 	var startn = new Date(start);
			// 	var endn   = new Date(end);
			// 								// selisih milliseconds
			// 	var diff = new Date(endn - startn);
			// 								// cari hari
			// 	var days = diff/1000/60/60/24;

			// 	if (days < 0) {
			// 		Swal.fire({
			// 			icon: "warning",
			// 			title: "Terlambat " + days + " hari!",
			// 			text: "Harus upload berita acara",
			// 			showConfirmButton: false,
			// 			timer: 2000,
			// 			timerProgressBar: true
			// 		});
			// 		$(ba).prop("disabled", false);
			// 		$(id).val(days);
			// 	}else{
			// 		$(ba).prop("disabled", true);
			// 		$(id).val(days);
			// 	}
			// }
</script>