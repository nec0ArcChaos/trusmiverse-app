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
							<h6 class="fw-medium mb-0"><?php echo $pageTitle ?></h6>
						</div>
						<div class="col-auto ms-auto ps-0">
							<!-- <button type="button" class="btn btn-md btn-outline-theme" id="btn_add_pengajuan"><i class="bi bi-plus"></i> Pengajuan EAF</button> -->
						</div>
					</div>
					<div class="row mt-3">
						<div class="col col-sm-auto">
							<!-- <form method="POST" id="form_filter">
                            <div class="input-group input-group-md reportrange">
                                <span class="input-group-text text-secondary bg-none"><i class="bi bi-calendar-event"></i></span>
                                <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="range">
                                <input type="hidden" name="datestart" value="" id="datestart" readonly />
                                <input type="hidden" name="dateend" value="" id="dateend" readonly />
                                <a href="javascript:void(0);" class="btn btn-primary" onclick="filter_report()" id="btn_filter"><i class="ti-search"></i>Filter</a>
                            </div>
                            </form> -->
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive" style="padding: 10px;">
						<table id="dt_list_eaf" class="table table-striped table-bordered nowrap">
							<thead>
								<tr>
									<th>LPJ sebelumnya</th>
									<th>No Pengajuan</th>
									<th>EAF Comp</th>
									<th>Tanggal Input</th>
									<th>Tgl Approve User</th>
									<th>Status</th>
									<th>Nama Penerima</th>
									<th>Yg Mengajukan</th>
									<th>Kategori</th>
									<th>Total<br>Pengajuan</th>
									<th>Bukti Nota</th>
									<th>Pengaju<br>Company</th>
									<th>Pengaju<br>Department</th>
									<th>Pengaju<br>Designation</th>
									<th>Keperluan</th>
									<th>ADM<br>Company</th>
									<th>ADM<br>Department</th>
									<th>ADM<br>Designation</th>
									<!-- <th>Divisi</th> -->
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
<div class="modal fade" id="modal_approval" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<form id="form_approval" autocomplete="off">

				<div class="modal-header row align-items-center">
					<div class="col-auto">
						<i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
					</div>
					<div class="col">
						<h6 class="fw-medium mb-0" id="modalAddLabel"></h6>
						<p class="text-secondary small">Detail Approve EAF</p>
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
					<input type="hidden" id="id_pengajuan_hide" name="id_pengajuan_hide" class="form-control">
					<input type="hidden" id="id_approval_hide" name="id_approval_hide" class="form-control">
					<input type="hidden" id="get_nominal" name="get_nominal" class="form-control" readonly>
					<input type="hidden" id="get_id_biaya" name="get_id_biaya" class="form-control" readonly>
					<input type="hidden" id="get_id_budget" name="get_id_budget" class="form-control" readonly>
					<input type="hidden" id="get_id_subbiaya" name="get_id_subbiaya" class="form-control" readonly>
					<input type="hidden" id="id_project_eces" name="id_project_eces" class="form-control" readonly>
					<div class="row">
						<div class="col-lg-4 col-sm-12">
							<input type="text" id="id_pengajuan" name="id_pengajuan" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12">
							<input type="text" id="nama_approval" name="nama_approval" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12">
							<input type="text" id="company_code" name="company_code" class="form-control" readonly>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Tanggal Input</label>
							<input type="text" id="tgl_input" name="tgl_input" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>User Pembuat</label>
							<input type="text" id="nama_pembuat" name="nama_pembuat" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Divisi</label>
							<input type="text" id="divisi" name="divisi" class="form-control" readonly>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-sm-12" style="margin-top:.5rem;">
							<label>Kategori</label>
							<input type="text" id="kategori" name="kategori" class="form-control" readonly>
						</div>
						<div class="col-lg-2 col-sm-12" style="margin-top:.5rem;">
							<label>Tipe Pembayaran</label>
							<input type="text" id="tipe" name="tipe" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Penerima</label>
							<input type="text" id="penerima" name="penerima" class="form-control" readonly>
						</div>
						<div class="col-lg-3 col-sm-12" style="margin-top:.5rem;">
							<label>Nomor Rekening</label>
							<input type="text" id="norek_penerima" name="norek_penerima" class="form-control" readonly>
						</div>
					</div>

					<br>
					<hr style="margin-top:0px; margin-bottom:5px;">
					<div class="row">
						<div class="col-lg-8 col-sm-6">
							<label><strong>Detail Keperluan</strong></label>
						</div>
						<div class="col-lg-4 col-sm-6">
							<i id="akun_hide"><label id="akun"></label></i>
						</div>
					</div>
					<div class="row">
						<div class="col"></div>
						<div class="col-lg-4 col-sm-6">
							<strong id="sisa_hide"><label id="sisa"></label></strong>
						</div>
					</div>
					<hr style="margin-top:0px;">

					<div class="row">
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Nama Keperluan</label>
							<textarea id="keperluan" name="keperluan" class="form-control" readonly rows="4"></textarea>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Note</label>
							<textarea id="note" name="note" class="form-control" readonly rows="4"></textarea>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Nominal Uang</label>
							<input type="text" id="nominal_old" name="nominal_old" class="form-control" align="right" readonly>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-4 col-sm-12" align="left">
							<label>Bukti Nota : </label>
							<span id="bukti_nota"></span>
						</div>
						<div class="col-lg-4 col-sm-6 tgl_jtp_col" style="display: none;">
							<label>Tgl JTP </label>
							<input type="text" id="tgl_jtp" class="form-control" placeholder="tanggal" name="tgl_jtp" readonly style="border: 1px solid #ddd;">
						</div>
						<div class="col-lg-4 col-sm-6">
							<label>Subtotal </label>
							<input type="text" id="rupiah" onkeyup="nominal($(this).val(), '#rupiah')" class="form-control nominal" placeholder="Total" name="total" style="border: 1px solid #ddd;">
						</div>
					</div>

					<div class="row pinjaman_karyawan" style="display:none;">
						<div class="col-lg-4 col-sm-12 col-xs-12 mb-2">
							<label>Jumlah Termin</label>
							<input type="number" id="jumlah_termin" class="form-control" placeholder="Jumlah Termin" name="jumlah_termin" readonly>
						</div>
						<div class="col-lg-4 col-sm-12 col-xs-12">
							<label>Nominal per Termin</label>
							<input type="text" id="nominal_termin" class="form-control" placeholder="Nominal per Termin" name="nominal_termin" readonly>
						</div>
						<div class="col-lg-4 col-sm-12 col-xs-12">
							<label>Periode Awal Termin</label>
							<input type="text" id="periode_termin" class="form-control" placeholder="Periode Awal Termin" name="periode_termin" readonly>
						</div>
					</div>

					<div class="row">
						<!-- <div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Pilihan COA : </label>
							<select name="coa_id" id="coa_id">
								<option value="0" selected disabled>- Pilih COA -</option>
							</select>
						</div> -->
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Pilihan Biaya : </label>
							<select name="biaya" id="biaya_new">
								<option value="0" selected disabled>- Pilih Biaya -</option>
							</select>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top: 0.5rem;">
							<label>Pilihan Jenis Biaya : </label>
							<select name="subbiaya" id="subbiaya_new">
								<option value="0" selected disabled>- Pilih Jenis Biaya -</option>
								<?php foreach ($jenis as $row) : ?>
									<option value="<?= $row->id_jenis ?>"><?= $row->jenis ?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="col"></div>
					</div>

					<!-- <hr style="margin-top:0px; margin-bottom:5px;">
					<label><strong>Integrasi Eces</strong></label>
					</hr>

					<div class="row">
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Penerima Eces : </label>
							<select name="penerima_eces" id="penerima_eces">
								<option value="0" selected disabled>- Pilih Penerima -</option>
							</select>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Rekening Eces : </label>
							<select name="rek_eces" id="rek_eces">
								<option value="0" selected disabled>- Pilih Rekening -</option>
							</select>
						</div>
					</div> -->

					<hr style="margin-bottom:7px;">
					<label><strong>Riwayat Pengajuan</strong></label>
					<hr style="margin-top:0px;">

					<div class="dt-responsive table-responsive">
						<table id="dt_history" class="table table-striped table-bordered nowrap">
							<thead>
								<tr>
									<th>Id Pengajuan</th>
									<th>Nama Kategori</th>
									<th>Nama Penerima</th>
									<th>Nama Keperluan</th>
									<th>Tgl Approve</th>
									<th>Status LPJ</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>

					<br>
					<br>
					<div class="row">
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Budget</label>
							<input type="text" id="budget" name="budget" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:0.5rem">
							<label>Pengajuan</label>
							<input type="text" id="pengajuan" name="pengajuan" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:0.5rem">
							<label>Sisa</label>
							<input type="text" id="sisa_new" name="sisa_new" class="form-control" align="right" readonly>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-sm-12">
							<label>Note Verifikatur</label>
							<textarea type="text" id="note_verifikatur" name="note_verifikatur" class="form-control" cols="30" rows="5" readonly></textarea>
						</div>
						<div class="col-lg-3 col-sm-12">
							<label>Note User Approval</label>
							<textarea type="text" id="note_user_approval" name="note_user_approval" class="form-control" cols="30" rows="5" readonly></textarea>
						</div>
						<div class="col-lg-3 col-sm-12">
							<label>Note</label>
							<textarea type="text" id="note_approval" name="note_approval" class="form-control" cols="30" rows="5" placeholder="Silahkan tambahkan catatan..." style="border: 1px solid #ccc"></textarea>
						</div>
						<!-- <div class="col-lg-3 col-sm-12">
							<label>Note ECES</label>
							<textarea type="text" id="note_approval_eces" name="note_approval_eces" class="form-control" cols="30" rows="5" placeholder="Silahkan tambahkan catatan ECES..."></textarea>
						</div> -->
						<div class="col-lg-3 col-sm-12" id="bukti">
							<label>Upload Bukti Transfer :</label>
							<input style="padding: .4rem .75rem;" type="file" id="nota_1" class="form-control" onchange="compress('#nota_1', '#string', '.fa_wait', '.fa_done')">
							<input type="hidden" class="form-control" name="nota" id="string">
							<div class="fa_wait" style="display: none;"><i class="fa fa-spinner fa-pulse"></i> <label>Compressing File ...</label></div>
							<div class="fa_done" style="display: none;"><i class="fa fa-check-circle" style="color: #689f38;"></i> <label>Compressing Complete.</label></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">


					<?php if ($cek_akses_btn_save == 1) : ?>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="position:absolute; left: 15px;">Close</button>

						<select name="status" id="status" class="form-control" style="width: 30%;">
							<option value="" selected disabled>-- Option Approval --</option>
							<option value="3">Approve</option>
							<option value="5">Reject</option>
						</select>
						<button type="button" class="btn btn-success" id="btn_save" onclick="simpan_approve()">Save</button>
					<?php endif ?>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal Add -->

<div class="modal fade" id="modal_approval_lpj" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<form id="form_approval_lpj" autocomplete="off">

				<div class="modal-header row align-items-center">
					<div class="col-auto">
						<i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
					</div>
					<div class="col">
						<h6 class="fw-medium mb-0" id="modalAddLabel"></h6>
						<p class="text-secondary small">Detail Approve LPJ</p>
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
					<input type="hidden" id="id_pengajuan_lpj_hide" name="id_pengajuan_lpj_hide" class="form-control" readonly>
					<input type="hidden" id="id_approval_lpj_hide" name="id_approval_lpj_hide" class="form-control" readonly>
					<input type="text" id="get_id_tipe_biaya" name="get_id_tipe_biaya" class="form-control" readonly>
					<div class="row">
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>ID</label>
							<input type="text" id="id_pengajuan_lpj" name="id_pengajuan_lpj" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Tanggal Input</label>
							<input type="text" id="tgl_input_lpj" name="tgl_input_lpj" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Company Code</label>
							<input type="text" id="company_code_lpj" name="company_code_lpj" class="form-control" readonly>
						</div>
					</div>
					<div class="row">

						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>User Pembuat</label>
							<input type="text" id="nama_pembuat_lpj" name="nama_pembuat_lpj" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Company</label>
							<input type="text" id="admin_comp_name_lpj" name="admin_comp_name_lpj" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Department</label>
							<input type="text" id="admin_dept_name_lpj" name="admin_dept_name_lpj" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<!-- <label>Divisi</label>
							<input type="text" id="divisi_lpj" name="divisi_lpj" class="form-control" readonly> -->
						</div>
					</div>

					<div class="row">
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Kategori</label>
							<input type="text" id="kategori_lpj" name="kategori_lpj" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Penerima</label>
							<input type="text" id="penerima_lpj" name="penerima_lpj" class="form-control" readonly>
						</div>
					</div>

					<br>
					<label><strong>Detail LPJ</strong></label>
					<hr style="margin-top:0px;">
					<div class="dt-responsive table-responsive">
						<table id="dt_lpj" class="table table-striped table-bordered nowrap">
							<thead>
								<tr>
									<th>Id Pengajuan</th>
									<th>Nama LPJ</th>
									<th>Note</th>
									<th>Pengajuan</th>
									<th>LPJ</th>
									<th>Sisa</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2">Bukti Nota : <span id="bukti_lpj"></span></td>
									<td colspan="2" align="right">Subtotal</td>
									<td colspan="2">123</td>
								</tr>
							</tfoot>
						</table>
					</div>

					<br>
					<br>

					<div class="row">
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Nominal LPJ &nbsp;</label><small><i class="label label-success">New</i></small>
							<input type="text" id="budget_lpj" name="budget_lpj" class="form-control" onkeyup="change_nominal_lpj($(this).val(), '#budget_lpj')">
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Sisa Budget</label>
							<input type="text" id="sisa_lpj" name="sisa_lpj" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Total</label>
							<input type="text" id="total_lpj" name="total_lpj" class="form-control" readonly>
							<input type="hidden" id="total_kep" name="total_kep" class="form-control" readonly>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<label>Keterangan</label>
							<textarea name="keterangan" id="keterangan" cols="30" rows="3" class="form-control" readonly></textarea>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<label>Note</label>
							<textarea type="text" id="note_approval_lpj" name="note_approval_lpj" class="form-control" placeholder="Silahkan tambahkan catatan..."></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="position:absolute; left: 15px;">Close</button>
					<select name="status_lpj" id="status_lpj" class="form-control" style="width: 30%;">
						<option value="" selected disabled>-- Option Approval --</option>
						<option value="7">Approve</option>
						<option value="5">Reject</option>
						<!-- <option value="13">Waiting Konfirmasi</option> -->
					</select>
					<button type="button" class="btn btn-success" id="btn_save_lpj" onclick="simpan_approve_lpj()">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- js nominal -->
<script type="text/javascript">
	function change_nominal_lpj(angka, id) {
		$(id).val(formatRupiah(angka, ''));
		kep = $("#total_kep").val(); // Pengajuan
		lpj = $("#budget_lpj").val(); // LPJ
		sisa = $("#sisa_lpj").val(); // Sisa Budget

		nominal_aju = kep.split('.').join('');;
		nominal_lpj = lpj.split('.').join('');
		selisih = parseInt(nominal_aju) - parseInt(nominal_lpj);

		// $('#total_lpj_new').val(selisih);
		hasil = formatRupiah(selisih.toString(), '');
		if (selisih.toString().charAt(0) == '-') {
			hasil = `-${formatRupiah(selisih.toString(),'')}`;
		}
		// console.log(hasil);
		$('#total_lpj').val(hasil);

		// console.log($('#total_lpj_new').val(), typeof $('#total_lpj_new').val(), formatRupiah(selisih.toString(),''));
	}

	function nominal(angka, id) {
		$(id).val(formatRupiah(angka, ''));
		$('#get_nominal').val(angka.replace('.', '').toString());
	}

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

			if (extension == "jpg" || extension == "jpeg" || extension == "png" || extension == "gif") {

				extension = 'png,';

				imgElement.onload = function(e) {
					const canvas = document.createElement("canvas");

					if (e.target.width > e.target.height) {
						const MAX_WIDTH = 400;
						const scaleSize = MAX_WIDTH / e.target.width;
						canvas.width = MAX_WIDTH;
						canvas.height = e.target.height * scaleSize;
					} else {
						const MAX_HEIGHT = 400;
						const scaleSize = MAX_HEIGHT / e.target.height;
						canvas.height = MAX_HEIGHT;
						canvas.width = e.target.width * scaleSize;
					}

					const ctx = canvas.getContext("2d");

					ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);

					const srcEncoded = ctx.canvas.toDataURL(e.target, "image/jpeg");

					var g_string = extension + srcEncoded.substr(srcEncoded.indexOf(',') + 1);
					document.querySelector(string).value = g_string;
				}
			} else {
				var g_string = extension + ',' + event.target.result.substr(event.target.result.indexOf(',') + 1);
				document.querySelector(string).value = g_string;
			}
		}
	}
</script>