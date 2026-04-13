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
                            <i class="bi bi-bookmark-check h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Approval User EAF</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col col-sm-auto">
							<form method="POST" id="form_filter">
								<div class="input-group input-group-md reportrange">
									<span class="input-group-text text-secondary bg-none"><i class="bi bi-calendar-event"></i></span>
									<input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="range">
									<input type="hidden" name="datestart" value="" id="datestart" readonly />
									<input type="hidden" name="dateend" value="" id="dateend" readonly />
									<a href="javascript:void(0);" class="btn btn-primary" id="btn_filter"><i class="bi-search"></i>Filter</a>
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
									<th>User Approval</th>
									<th>Total Pengajuan</th>
									<th>Nama Penerima</th>
									<th>Yg Mengajukan</th>
									<th>Company</th>
									<th>Department</th>
									<th>Designation</th>

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
</main>

<div class="modal fade" id="modal_approval" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
			<form id="form_approval" autocomplete="off">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Detail Approve</h6>
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
					<input type="hidden" id="id_pengajuan_hide" name="id_pengajuan_hide" class="form-control" readonly>
					<input type="hidden" id="id_approval_hide" name="id_approval_hide" class="form-control" readonly>
					<input type="hidden" id="get_sisa" name="get_sisa" class="form-control" readonly>
					<div class="row">
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>ID</label>
							<input type="text" id="id_pengajuan" name="id_pengajuan" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Tanggal Input</label>
							<input type="text" id="tgl_input" name="tgl_input" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem; display: none">
							<label>Divisi</label>
							<input type="text" id="divisi" name="divisi" class="form-control" readonly>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>User Pembuat</label>
							<input type="text" id="nama_pembuat" name="nama_pembuat" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Company</label>
							<input type="text" id="admin_company_name" name="admin_company_name" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Department</label>
							<input type="text" id="admin_department_name" name="admin_department_name" class="form-control" readonly>
						</div>
						<!-- <div class="col-lg-3 col-sm-12" style="margin-top:.5rem;">
							<label>Designation</label>
							<input type="text" id="admin_designation_name" name="admin_designation_name" class="form-control" readonly>
						</div> -->
						
					</div>

					<div class="row">
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
							<span id="bukti"></span>
						</div>
						<div class="col-lg-4 col-sm-6" align="right"><label>Subtotal </label></div>
						<div class="col-lg-4 col-sm-6">
							<input type="text" id="rupiah" onkeyup="nominal($(this).val(), '#rupiah')" class="form-control nominal" placeholder="Total" name="total" style="border: 1px solid #ddd;">
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

					<div class="row">
						<div class="col-lg-6 col-sm-12">
							<label>Note Verificator</label>
							<textarea type="text" id="note_verified" name="note_verified" class="form-control" readonly></textarea>
						</div>
						<div class="col-lg-6 col-sm-12">
							<label>Note</label>
							<textarea type="text" id="note_approval" name="note_approval" class="form-control" readonly></textarea>
						</div>
					</div>
                </div>
                <div class="modal-footer">
					<!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="position:absolute; left: 15px;">Close</button> -->
                </div>
			</form>
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