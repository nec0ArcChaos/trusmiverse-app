<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fancybox/jquery.fancybox.min.css" />

<!-- Datetime Picker -->
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/datetimepicker/datetimepicker.min.css" /> -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/datetimepicker/jquery.datetimepicker.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/css/bootstrap-datepicker.min.css">

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
									<th>Leadtime</th>
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
</style>

<div class="modal fade" id="modal_verified" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Detail Verified</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form_verified" autocomplete="off">
					<input type="hidden" id="id_pengajuan_hide" name="id_pengajuan_hide" class="form-control" readonly>
					<input type="hidden" id="id_approval_hide" name="id_approval_hide" class="form-control" readonly>
					<input type="hidden" id="id_user_approval_hide" name="id_user_approval_hide" class="form-control" readonly>
					<input type="hidden" id="get_sisa" name="get_sisa" class="form-control" readonly>
					<div class="form-group row">
						<div class="col">
							<input type="text" id="id_pengajuan" name="id_pengajuan" class="form-control" readonly>
						</div>
					</div>
					<div class="form-group row">
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

					<div class="form-group row">
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Kategori</label>
							<input type="text" id="kategori" name="kategori" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Tipe Pembayaran</label>
							<input type="text" id="tipe" name="tipe" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Penerima</label>
							<input type="text" id="penerima" name="penerima" class="form-control" readonly>
						</div>
					</div>

					<div class="form-group row hidden_dlk">
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Tanggal DLK</label>
							<input type="text" id="tgl_dlk" name="tgl_dlk" class="form-control" readonly>
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

					<div class="form-group row">
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

					<div class="form-group row">
						<div class="col-lg-4 col-sm-12" align="left">
							<label>Bukti Nota : </label>
							<span id="bukti"></span>
						</div>
						<div class="col-lg-4 col-sm-6" align="right"><label>Subtotal </label></div>
						<div class="col-lg-4 col-sm-6">
							<input type="text" id="rupiah" onkeyup="nominal($(this).val(), '#rupiah')" class="form-control nominal" placeholder="Total" name="total">
						</div>
					</div>

					<input type="hidden" name="id_kategori" id="id_kategori">
					<div class="form-group row pinjaman_karyawan" style="display:none;">
						<div class="col-lg-4 col-sm-12 col-xs-12 mb-2">
							<label>Jumlah Termin</label>
							<input type="number" id="jumlah_termin" class="form-control" placeholder="Jumlah Termin" name="jumlah_termin" onchange="nominal_per_termin()">
						</div>
						<div class="col-lg-4 col-sm-12 col-xs-12">
							<label>Nominal per Termin</label>
							<input type="text" id="nominal_termin" class="form-control" placeholder="Nominal per Termin" name="nominal_termin" readonly>
						</div>
						<div class="col-lg-4 col-sm-12 col-xs-12">
							<label>Periode Awal Termin</label>
							<input type="text" id="periode_termin" class="form-control" placeholder="Periode Awal Termin" name="periode_termin" value="<?= date('Y-m'); ?>" style="background-color:white;" readonly>
						</div>
					</div>

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

					<div class="form-group row">
						<div class="col">
							<label>Note</label>
							<textarea type="text" id="note_approval" name="note_approval" class="form-control" placeholder="Silahkan tambahkan catatan..."></textarea>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" style="position:absolute; left: 15px;">Close</button>
						<select name="status" id="status" class="form-control" style="width: 30%;">
							<option value="" selected disabled>-- Option Approval --</option>
							<option value="1">Approve</option>
							<option value="11">Reject</option>
							<option value="12">Revisi</option>
						</select>
						<button type="button" class="btn btn-success" id="btn_save" onclick="simpan_approve()">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_verified_lpj" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Detail Verified LPJ</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form_verified_lpj" autocomplete="off">
					<input type="hidden" id="id_pengajuan_lpj_hide" name="id_pengajuan_lpj_hide" class="form-control">
					<input type="hidden" id="id_user_approval_lpj_hide" name="id_user_approval_lpj_hide" class="form-control">
					<div class="form-group row">
						<div class="col">
							<input type="text" id="id_pengajuan_lpj" name="id_pengajuan_lpj" class="form-control" readonly>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Tanggal Input</label>
							<input type="text" id="tgl_input_lpj" name="tgl_input_lpj" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>User Pembuat</label>
							<input type="text" id="nama_pembuat_lpj" name="nama_pembuat_lpj" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Divisi</label>
							<input type="text" id="divisi_lpj" name="divisi_lpj" class="form-control" readonly>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Kategori</label>
							<input type="text" id="kategori_lpj" name="kategori_lpj" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Penerima</label>
							<input type="text" id="penerima_lpj" name="penerima_lpj" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Pengaju</label>
							<input type="text" id="pengaju_lpj" name="pengaju_lpj" class="form-control" readonly>
						</div>
					</div>

					<div class="form-group row">
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">						
							<label>Waktu Keberangkatan</label>
							<input type="text" id="tgl_awal" name="tgl_awal" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">						
							<label>Waktu Kedatangan</label>
							<input type="text" id="tgl_akhir" name="tgl_akhir" class="form-control" readonly>
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
					<div class="form-group row">
						<div class="col-sm-3">
							<label>Nominal LPJ</label>
							<input type="text" id="nominal_lpj_rev" name="nominal_lpj_rev" class="form-control" onkeyup="nominal($(this).val(), '#nominal_lpj_rev')"  placeholder="Nominal LPJ...">
						</div>
						<div class="col-sm-3">
							<label>Waktu Kedatangan</label>
							<input type="text" id="tgl_datang_rev" name="tgl_datang_rev" class="form-control tanggal" placeholder="Waktu Kedatangan...">
						</div>
						<div class="col-sm-6">
							<label>Note</label>
							<textarea type="text" id="note_approval_lpj" name="note_approval_lpj" class="form-control" placeholder="Silahkan tambahkan catatan..."></textarea>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" style="position:absolute; left: 15px;">Close</button>
						<select name="status_lpj" id="status_lpj" class="form-control" style="width: 30%;">
							<option value="" selected disabled>-- Option Approval --</option>
							<option value="6">Approve</option>
							<option value="4">Reject</option>
						</select>
						<button type="button" class="btn btn-success" id="btn_save_lpj" onclick="simpan_verified_lpj()">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- js nominal -->
<script type="text/javascript">
	function nominal(angka, id) {
		$(id).val(formatRupiah(angka, ''));
		if ($("#jumlah_termin").val().length > 0) {
			nominal_per_termin();
		}
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
</script>