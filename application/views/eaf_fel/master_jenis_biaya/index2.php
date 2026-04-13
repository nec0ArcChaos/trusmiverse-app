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
						<div class="col-sm-4"></div>
						<div class="col-sm-5"></div>
						<div class="col-sm-3">
						<?php if (in_array($this->session->userdata('id_user'), array(1,61,162,495,344))) { ?> 
							<span id="btn_add_jenis_biaya" class="btn btn-primary btn-square" style="width: 100%"><i class="ti-plus"></i> Jenis Biaya</span>
						<?php } ?>	
						</div>
					</div>

					<div class="dt-responsive table-responsive">
						<table id="dt_list_jenis_biaya" class="table table-striped table-bordered nowrap">
							<thead>
								<tr>
									<th>ID</th>
									<th>Nama Jenis</th>
									<th>Akun</th>
									<th>Budget</th>
									<th>Tipe Biaya</th>
									<th>User Approval</th>
									<th>User Verifikator</th>
									<th>Created By</th>
									<th>Option</th>
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

<div class="modal fade" id="modal_jenis_biaya" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Form Tambah Jenis Biaya | EAF</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form_jenis_biaya" autocomplete="off">
					<input type="hidden" id="id_jenis" name="id_jenis" class="form-control" readonly>
					<div class="form-group row" style="margin-bottom: 10px; margin-top: 10px;">
						<div class="col-lg-12 col-sm-12">
							<label>Nama Jenis Biaya</label>
							<input type="text" id="jenis_biaya" name="jenis_biaya" class="form-control" placeholder="Jenis Biaya">
						</div>
					</div>
					<div class="form-group row" style="margin-bottom: 10px; margin-top: 10px;">
						<div class="col-lg-12 col-sm-12">
							<label>Nama Akun</label>
							<select name="akun" id="akun">
								<option data-placeholder="true">-- Pilih Akun --</option>
								<?php foreach($akun as $row):?>
									<option value="<?php echo $row->id_akun; ?>"><?php echo $row->nama_akun;?></option>
								<?php endforeach;?>
							</select>
						</div>
						<div class="col-lg-9 col-sm-9" style="margin-top: 10px;">
							<label>Nama Budget</label>
							<select name="budget" id="budget" style="height: 40px;">
								<option data-placeholder="true">-- Pilih Budget --</option>
								<?php foreach($budget as $row):?>
									<option value="<?php echo $row->id_budget; ?>"><?php echo $row->budget;?></option>
								<?php endforeach;?>
							</select>
						</div>
						<div class="col-lg-3 col-sm-3" style="margin-bottom: 10px; margin-top: 10px;">
							<label style="color: white;">Nama Budget</label>
							<span id="btn_add_budget" class="btn btn-primary btn-square" style="width: 100%; padding-bottom: 5px;"><i class="ti-plus"></i> Budget</span>
						</div>
						<div class="col-lg-12 col-sm-12" style="margin-bottom: 10px;">
							<label>Tipe Biaya</label>
							<select name="tipe_biaya" id="tipe_biaya">
								<option data-placeholder="true">-- Pilih Tipe Biaya --</option>
							</select>
						</div>
						<div class="col-lg-12 col-sm-12" style="margin-bottom: 10px; margin-top: 10px;">
							<label>User Approval</label>
							<select name="user_approval" id="user_approval">
								<option data-placeholder="true">-- Pilih User Approval --</option>
								<?php foreach($user_approval as $row):?>
									<option value="<?php echo $row->id_user; ?>"><?php echo $row->employee_name;?></option>
								<?php endforeach;?>
							</select>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success" id="insert_jenis_biaya">Save</button>
				<button type="button" class="btn btn-success" id="update_jenis_biaya">Update</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_budget" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Form Tambah Nama Budget | EAF</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form_budget" autocomplete="off">
					<input type="hidden" id="id_budget" name="id_budget" class="form-control" readonly>
					<div class="form-group row" style="margin-bottom: 10px; margin-top: 10px;">
						<div class="col-lg-12 col-sm-12">
							<label>Nama Budget</label>
							<input type="text" id="add_budget" name="add_budget" class="form-control" placeholder="Nama Budget">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success" id="insert_budget">Save</button>
			</div>
		</div>
	</div>
</div>