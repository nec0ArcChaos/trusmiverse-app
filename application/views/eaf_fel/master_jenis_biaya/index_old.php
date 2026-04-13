<main class="main mainheight">
	<div class="container-fluid mb-4">
		<div class="row align-items-center page-title">
			<div class="col-12 col-md mb-2 mb-sm-0">
				<h5 class="mb-0"><?= $pageTitle; ?></h5>
			</div>
			<div class="col-auto ps-0">

			</div>
		</div>
		<div class="row">
			<nav aria-label="breadcrumb" class="breadcrumb-theme">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
					<li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
				</ol>
			</nav>
		</div>
	</div>

	<div class="m-3">
		<div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
			<div class="card border-0">
				<div class="card-body">
					<div class="row mb-2">
						<div class="col-12 col-md-12 col-lg-12 mb-2">
						</div>
						<div class="col col-sm-auto">

						</div>
						<div class="col text-end">
							<?php if (in_array($this->session->userdata('user_id'), array(1, 61, 162, 495, 344, 1161, 1709, 488, 4405))) { ?>
								<button type="button" class="btn btn-primary" onclick="mdl_add_jenis_biaya()" id="btn_add_jenis_biaya"><i class="bi bi-plus"></i> Jenis Biaya</button>
							<?php } ?>
						</div>
					</div>
					<br><label for="">
						<h5><?= $pageTitle; ?></h5>
					</label><br>

					<div class="table-responsive" style="padding: 10px;">

						<!-- <table id="tbl_goal_h" class="table table-sm table-striped" style="width:100%">                            
                        </table> -->
						<table id="dt_list_jenis_biaya" class="table table-striped dt-responsive" style="width:100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>Comp EAF</th>
									<th>Nama Jenis</th>
									<th>Akun</th>
									<th>Budget</th>
									<th>Tipe Biaya</th>
									<th>User Approval 1</th>
									<th>User Approval 2</th>
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
</main>


<div class="modal fade" id="modal_jenis_biaya" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
	<div class="modal-dialog modal-l" role="document">
		<div class="modal-content">

			<div class="modal-header row align-items-center">
				<div class="col-auto">
					<i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
				</div>
				<div class="col">
					<h6 class="fw-medium mb-0" id="modalAddLabel">Form Tambah Jenis Biaya | EAF</h6>
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
				<form id="form_jenis_biaya" autocomplete="off">
					<input type="hidden" id="id_jenis" name="id_jenis" class="form-control" readonly>
					<div class="form-group row">
						<div class="col-lg-12 col-sm-12">
							<label>Nama Jenis Biaya</label>
							<input type="text" id="jenis_biaya" name="jenis_biaya" class="form-control" placeholder="Jenis Biaya">
							<input type="hidden" id="tipe_crud" name="tipe_crud" class="form-control">
							<input type="hidden" id="company_id_hidden" name="company_id_hidden" class="form-control">
						</div>
						<div class="col-lg-12 col-sm-12" style="margin-top: 10px;">
							<label>Company Name</label>
							<select name="company_id" id="company_id">
								<option data-placeholder="true">-- Pilih Company --</option>
								<?php foreach ($company as $row): ?>
									<option value="<?php echo $row->company_id; ?>"><?php echo $row->name; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-lg-12 col-sm-12" style="margin-top: 10px; display:none" id="div_akun">
							<label>Nama Akun (ECES)</label>
							<select name="akun" id="akun">
								<option data-placeholder="true">-- Pilih Akun --</option>
								<?php foreach ($akun as $row): ?>
									<option value="<?php echo $row->id_akun; ?>"><?php echo $row->nama_akun; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-lg-9 col-sm-9" style="margin-top: 10px;">
							<label>Nama Budget</label>
							<select name="budget" id="budget">
								<option data-placeholder="true">-- Pilih Budget --</option>
							</select>
						</div>
						<div class="col-lg-3 col-sm-3" style="margin-bottom: 10px; margin-top: 10px;">
							<label style="color: white;">Nama Budget</label>
							<span id="btn_add_budget" class="btn btn-primary btn-square" style="width: 100%; padding-bottom: 5px;" onclick="mdl_tbh_budget()"><i class="bi bi-plus"></i> Budget</span>
						</div>
						<div class="col-lg-12 col-sm-12" style="margin-bottom: 10px;">
							<label>Tipe Biaya</label>
							<select name="tipe_biaya" id="tipe_biaya">
								<option data-placeholder="true">-- Pilih Tipe Biaya --</option>
								<?php foreach ($tipe_biaya as $row): ?>
									<option value="<?php echo $row->id_tipe_biaya; ?>"><?php echo $row->nama_tipe_biaya; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-lg-12 col-sm-12" style="margin-bottom: 10px; margin-top: 10px;">
							<label>User Approval 1</label>
							<select name="user_approval1" id="user_approval1" class="form-control">
								<option data-placeholder="true">-- Pilih User Approval 1 --</option>
								<?php foreach ($user_approval as $row): ?>
									<option value="<?php echo $row->id_user; ?>"><?php echo $row->employee_name; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-lg-12 col-sm-12" style="margin-bottom: 10px; margin-top: 10px;">
							<label>User Approval 2</label>
							<select name="user_approval2" id="user_approval2" class="form-control">
								<option data-placeholder="true">-- Pilih User Approval 2 --</option>
								<?php foreach ($user_approval as $row): ?>
									<option value="<?php echo $row->id_user; ?>"><?php echo $row->employee_name; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<!-- <div class="col-lg-12 col-sm-12" style="margin-bottom: 10px; margin-top: 10px;">
							<label>Max User Approval 1</label>
							<input type="number" class="form-control" id="max_nominal" name="max_nominal" onkeyup="updateRupiah('max_nominal')">
						</div> -->
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="margin-right: 10px;">Close</button>
				<button type="button" class="btn btn-success" id="insert_jenis_biaya" style="margin-right: 10px;" onclick="insert_jenis_biaya()">Save</button>
				<button type="button" class="btn btn-success" id="update_jenis_biaya">Update</button>

			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_budget" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
	<div class="modal-dialog modal-l" role="document">
		<div class="modal-content">

			<div class="modal-header row align-items-center">
				<div class="col-auto">
					<i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
				</div>
				<div class="col">
					<h6 class="fw-medium mb-0" id="modalAddLabel">Form Tambah Jenis Biaya | EAF</h6>
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
				<form id="form_budget" autocomplete="off">
					<input type="hidden" id="id_budget" name="id_budget" class="form-control" readonly>
					<div class="col-12">
						<label>Company Name</label>
						<input type="text" id="company_budget" name="company_budget" class="form-control" readonly>
						<input type="hidden" id="company_budgetid" name="company_budgetid" class="form-control" readonly>

					</div>
					<div class="col-12" style="margin-top: 10px; ">
						<label>Nama Budget</label>
						<input type="text" id="add_budget" name="add_budget" class="form-control" placeholder="Nama Budget">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="margin-right: 10px;">Close</button>
				<button type="button" class="btn btn-success" id="insert_budget" onclick="insert_budget()">Save</button>
			</div>
		</div>
	</div>
</div>