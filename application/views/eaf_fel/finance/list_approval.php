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
                            <h6 class="fw-medium mb-0">List Approval Finance | EAF</h6>
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
									<a href="javascript:void(0);" class="btn btn-primary" id="btn_filter"><i class="ti-search"></i>Filter</a>
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
									<th>EAF Comp</th>
									<th>Tanggal Input</th>
									<th>Status</th>
									<th>Nama Penerima</th>
									<th>Yg Mengajukan</th>
									<th>Kategori</th>
									<th>Company</th>
									<th>Department</th>
									<th>Designation</th>
									<th>Keperluan</th>
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
				<input type="hidden" id="id_pengajuan_hide" name="id_pengajuan_hide" class="form-control">
					<input type="hidden" id="id_approval_hide" name="id_approval_hide" class="form-control">
					<div class="row">
						<div class="col-lg-6 col-sm-12" style="margin-top:.5rem;">
						<label>ID</label>
							<input type="text" id="id_pengajuan" name="id_pengajuan" class="form-control" readonly>
						</div>
						<div class="col-lg-6 col-sm-12" style="margin-top:.5rem;">
							<label>Tanggal Input</label>
							<input type="text" id="tgl_input" name="tgl_input" class="form-control" readonly>
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
							<input type="text" id="admin_dept_name" name="admin_dept_name" class="form-control" readonly>
						</div>
						<!-- <div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Divisi</label>
							<input type="text" id="divisi" name="divisi" class="form-control" readonly>
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
							<input type="hidden" id="id_biaya" name="id_biaya">
						</div>
					</div>
					<hr style="margin-top:0px;">

					<div class="row">
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Nama Keperluan</label>
							<!-- <input type="text" id="keperluan" name="keperluan" class="form-control" readonly> -->
							<textarea cols="30" rows="3" id="keperluan" name="keperluan" class="form-control" readonly></textarea>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Note</label>
							<!-- <input type="text" id="note" name="note" class="form-control" readonly> -->
							<textarea cols="30" rows="3" id="note" name="note" class="form-control" readonly></textarea>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Nominal Uang</label>
							<input type="text" id="nominal_old" name="nominal_old" class="form-control" align="right" readonly>
						</div>
					</div>

					<div class="row">
						<div class="col-4" align="left">
							<label>Bukti Nota : </label>
							<span id="bukti"></span>
						</div>
					</div>

					<div class="row" id="form_reject">
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Note Cancel</label>
							<textarea name="note_reject" id="note_reject" cols="30" rows="5" class="form-control" style="border: 1px solid #ccc"></textarea>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<button type="button" class="btn btn-outline-danger" onclick="reject()">Cancel Approval</button>
						</div>
					</div>

					<br>
					<label><strong>Tracking Approval</strong></label>
					<hr style="margin-top:0px;">

					<div class="dt-responsive table-responsive">
						<table id="dt_tracking" class="table table-striped table-bordered nowrap">
							<thead>
								<tr>
									<th>Nama</th>
									<th>Tanggal</th>
									<th>Status</th>
									<th>Note</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
                </div>
                <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>
                </div>
			</form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_approval_lpj" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
			<form id="form_approval_lpj" autocomplete="off">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Detail Approve LPJ</h6>
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
					<input type="hidden" id="id_pengajuan_lpj_hide" name="id_pengajuan_lpj_hide" class="form-control">
					<input type="hidden" id="id_approval_lpj_hide" name="id_approval_lpj_hide" class="form-control">
					<div class="row">
						<div class="col-lg-6 col-sm-12" style="margin-top:.5rem;">
							<input type="text" id="id_pengajuan_lpj" name="id_pengajuan_lpj" class="form-control" readonly>
						</div>
						<div class="col-lg-6 col-sm-12" style="margin-top:.5rem;">
							<label>Tanggal Input</label>
							<input type="text" id="tgl_input_lpj" name="tgl_input_lpj" class="form-control" readonly>
						</div>
					</div>
					<div class="row">
						
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>User Pembuat</label>
							<input type="text" id="nama_pembuat_lpj" name="nama_pembuat_lpj" class="form-control" readonly>
						</div>
						<!-- <div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Divisi</label>
							<input type="text" id="divisi_lpj" name="divisi_lpj" class="form-control" readonly>
						</div> -->
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Company</label>
							<input type="text" id="admin_company_name_lpj" name="admin_company_name_lpj" class="form-control" readonly>
						</div>
						<div class="col-lg-4 col-sm-12" style="margin-top:.5rem;">
							<label>Department</label>
							<input type="text" id="admin_dept_name_lpj" name="admin_dept_name_lpj" class="form-control" readonly>
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
					<label><strong>Tracking Approval</strong></label>
					<hr style="margin-top:0px;">

					<div class="dt-responsive table-responsive">
						<table id="dt_tracking_lpj" class="table table-striped table-bordered nowrap">
							<thead>
								<tr>
									<th>Nama</th>
									<th>Tanggal</th>
									<th>Status</th>
									<th>Note</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
                </div>
                <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>
                </div>
			</form>
        </div>
    </div>
</div>

<!-- js nominal -->
<script type="text/javascript">
	function nominal(angka, id) {
		$(id).val(formatRupiah(angka, ''));
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