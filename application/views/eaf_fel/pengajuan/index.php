<main class="main mainheight">
	<div class="container-fluid mb-4">
		<div class="row">
			<nav aria-label="breadcrumb" class="breadcrumb-theme">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
					<li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
				</ol>
			</nav>
		</div>
	</div>
	<div class="container-fluid mb-4">

	</div>

	<div class="m-3">
		<div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
			<div class="card border-0">
				<div class="card-header">
					<div class="row">
						<div class="col-auto">
							<i class="bi bi-wallet h5 avatar avatar-40 bg-light-theme rounded"></i>
						</div>
						<div class="col-auto align-self-center">
							<h6 class="fw-medium mb-0">Pengajuan EAF</h6>
						</div>
						<div class="col-auto ms-auto ps-0">
							<button type="button" class="btn btn-md btn-outline-theme" id="btn_add_pengajuan"><i class="bi bi-plus"></i> Pengajuan EAF</button>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col col-sm-auto">
							<form method="POST" id="form_filter">
								<div class="input-group input-group-md reportrange">
									<span class="input-group-text text-secondary bg-none" style="border: 1px solid #ccc"><i class="bi bi-calendar-event"></i></span>
									<input type="text" class="form-control range bg-none px-0" style="cursor: pointer; border: 1px solid #ccc" id="range">
									<input type="hidden" name="datestart" value="" id="datestart" readonly />
									<input type="hidden" name="dateend" value="" id="dateend" readonly />
									<a href="javascript:void(0);" class="btn btn-primary" onclick="filter_report()" id="btn_filter"><i class="ti-search"></i>Filter</a>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive" style="padding: 10px;">
						<table id="dt_list_eaf" class="table table-striped table-bordered nowrap">
							<thead>
								<tr>
									<th>No Pengajuan</th>
									<th>Comp EAF</th>
									<th>Tanggal Input</th>
									<th>Status</th>
									<th>Nama Penerima</th>
									<th>Yg Mengajukan</th>
									<th>Kategori</th>
									<th>Keperluan</th>
									<th>Divisi</th>
									<th>Designation</th>
									<th>Department</th>
									<th>Company</th>
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
</main>

<!-- Modal Add -->
<div class="modal fade" id="modal_add_pengajuan" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<form id="form_keperluan" autocomplete="off">

				<div class="modal-header row align-items-center">
					<div class="col-auto">
						<i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
					</div>
					<div class="col">
						<h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
						<p class="text-secondary small">Form Pengajuan EAF</p>
					</div>
					<div class="col-auto ps-0">
						<div class="dropdown d-inline-block">
							<a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
								<i class="bi bi-x-lg"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-4 col-sm-2">
							<label>Nama Penerima</label>
							<input type="text" id="nama_penerima" name="nama_penerima" class="form-control" placeholder="Nama Penerima" style="border: 1px solid #ddd;"><br>
						</div>
						<div class="col-lg-4 col-sm-2">
							<label>Yang Mengajukan</label>
							<select name="pengaju" id="pengaju" style="border: 1px solid #ddd;">
								<option data-placeholder="true">-- Pilih Yang Mengajukan --</option>
								<?php foreach ($pengaju as $row): ?>
									<option value="<?php echo $row->id_user; ?>" data-company_id_user="<?php echo $row->company_id; ?>" data-company_name_user="<?php echo $row->company_name; ?>" <?php echo ($row->id_user == $this->session->userdata('id_user')) ? "selected" : ""; ?>><?php echo $row->employee_name; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-lg-4 col-sm-2">
							<label>Nama Kategori</label>
							<select class="form-control" name="kategori" id="kategori" required style="border: 1px solid #ddd;">
								<option value="">-- Pilih Kategori --</option>
								<?php foreach ($kategori as $row): ?>
									<?php if (in_array($this->session->userdata('id_user'), [1, 61, 495, 747]) && $row->id_kategori == 20): ?>
										<option value="<?php echo $row->id_kategori; ?>"><?php echo $row->nama_kategori; ?></option>
									<?php else: ?>
										<option value="<?php echo $row->id_kategori; ?>"><?php echo $row->nama_kategori; ?></option>
									<?php endif ?>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-4 col-sm-2 col-xs-2">
							<label>Tipe Pembayaran</label>
							<select class="form-control" id="dd_tipe" name="tipe" required style="border: 1px solid #ddd;">
								<option value="">-- Tipe Pembayaran --</option>
								<option value="Tunai">Tunai</option>
								<option value="Transfer Bank">Transfer Bank</option>
								<option value="Giro">Giro</option>
							</select>
						</div>
						<div class="col-lg-4 col-sm-2 col-xs-2">
							<label>Nama Bank:</label>
							<input class="form-control" id="txtbank" type="text" name="nama_bank" placeholder="Nama Bank" disabled style="border: 1px solid #ddd;">
						</div>
						<div class="col-lg-4 col-sm-2 col-xs-2">
							<label>Rekening:</label>
							<input class="form-control nomer" id="txtrek" type="number" placeholder="Nomor Rekening" name="rekening" disabled style="border: 1px solid #ddd;">
						</div>
					</div>
					<br>
					<label><strong>Detail Keperluan</strong></label>
					<hr>

					<div class="row d-flex">
						<div class="col-lg-2 col-md-2 col-sm-12 col-xs-2">
							<label>Total</label>
							<input type="text" id="rupiah" oninput="nominal($(this).val(), '#rupiah')" class="form-control nominal" placeholder="Total" name="total" style="border: 1px solid #ddd;">
							<!-- <input type="text" id="rupiah" class="form-control nominal" placeholder="Total" name="total" style="border: 1px solid #ddd;"> -->

							<span><small class="text-secondary"><span style="color:red">*</span> Untuk DLK input 0 terlebih dahulu.</small></span>
							<input type="hidden" id="tipe_budget">
							<input type="hidden" id="sisa_budget">
							<input type="hidden" name="leave_id" id="leave_id">
						</div>
						<div class="col-lg-3 col-md-3 col-sm-12 col-xs-2">
							<label>Company</label>
							<select name="company" id="company" onclick="check_nominal()" disabled>
								<option data-placeholder="true">-- Pilih Company --</option>
								<?php foreach ($company as $row): ?>
									<option value="<?php echo $row->company_id ?>"><?php echo $row->company_name ?></option>
								<?php endforeach ?>
							</select>
							<!-- <input type="hidden" id="company_id" name="company_id" class="form-control" style="border: 1px solid #ddd;" readonly><br> -->
						</div>
						<div class="col-lg-7 col-md-7 col-sm-12 col-xs-2">
							<label>Nama Keperluan</label>
							<select name="keperluan" id="keperluan" disabled>
								<option data-placeholder="true">-- Pilih Keperluan --</option>
								<!-- <?php foreach ($jenis_biaya as $row): ?>
									<option value="<?php echo $row->id_jenis . '|' . $row->id_biaya . '|' . $row->jenis . '|' . $row->id_user_approval . '|' . $row->id_tipe_biaya . '|' . $row->budget . '|' . $row->project . '|' . $row->blok . '|' . $row->id_user_verified . '|' . $row->ba ?>"><?php echo $row->jenis . ' (' . $row->employee . ')' ?></option>
								<?php endforeach ?> -->
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-2">
							<label>Note</label>
							<textarea class="form-control" placeholder="Note" name="note" id="note" style="border: 1px solid #ddd;"></textarea>
							<!-- <small class="text-secondary">*Dilarang pakai petik</small> -->
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-2" id="pilihan_ba_hide" style="display:none;">
							<label>Pilih File/BA</label>
							<select class="form-control" name="pilihan_ba" id="pilihan_ba" style="height: 36px;">
								<option value="file">File</option>
								<option value="ba">BA</option>
							</select>
						</div>
						<input type="hidden" id="kondisi_pilihan_ba">
					</div>

					<div class="row">
						<div class="col-lg-2 col-sm-2 col-xs-2 pinjaman_karyawan" style="display:none;">
							<label>Jumlah Termin</label>
							<!-- <input type="text" name="jumlah_termin" id="jumlah_termin" style="border: 1px solid #ddd;"> -->
							<input type="text" id="jumlah_termin" name="jumlah_termin" class="form-control" placeholder="0" style="border: 1px solid #ddd;" oninput="nominal_per_termin(this.value)">

							<!-- <select class="form-control" name="jumlah_termin" id="jumlah_termin" style="height: 36px;" onchange="nominal_per_termin()">
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
							</select> -->
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
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-md btn-outline-theme" id="save_eaf">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal Add -->

<div class="modal fade" id="modal_detail_pengajuan" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">

			<div class="modal-header row align-items-center">
				<div class="col-auto">
					<i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
				</div>
				<div class="col">
					<h6 class="fw-medium mb-0" id="modalAddLabel">Detail Pengajuan EAF</h6>
					<p class="text-secondary small"></p>
				</div>
				<div class="col-auto ps-0">
					<div class="dropdown d-inline-block">
						<a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
							<i class="bi bi-x-lg"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div id="data_detail_pengajuan">

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

			</div>
		</div>
	</div>
</div>

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

	// function nominal(angka, id) {
	// 	$(id).val(formatRupiah(angka, ''));
	// 	if ($("#jumlah_termin").val().length > 0) {
	// 		nominal_per_termin();
	// 	}
	// }

	function formatRupiah(angka, prefix) {
		var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split = number_string.split(','),
			sisa = split[0].length % 3,
			rupiah = split[0].substr(0, sisa),
			ribuan = split[0].substr(sisa).match(/\d{3}/gi);
		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}
		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
	}
</script>