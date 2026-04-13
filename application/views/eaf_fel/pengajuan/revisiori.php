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
						<div class="col-sm-3"></div>
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


<div class="modal fade" id="modal_detail_pengajuan" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" style="max-width: 80%;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Detail Pengajuan EAF</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="data_detail_revisi">
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="btn_save_revisi">Save</button>
			</div>
		</div>
	</div>
</div>