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
                            <h6 class="fw-medium mb-0">Reivisi Pengajuan | EAF</h6>
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
									<th>Tanggal Input</th>
									<th>Status</th>
									<th>Nama Penerima</th>
									<th>Yg Mengajukan</th>
									<th>Kategori</th>
									<th>Company</th>
									<th>Department</th>
									<th>Designation</th>
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
</main>

<div class="modal fade" id="modal_detail_pengajuan" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
			<form id="form_approval" autocomplete="off">
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
					<div id="data_detail_revisi">
					
					</div>
                </div>
                <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btn_save_revisi">Save</button>
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