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
							<?php if (in_array($this->session->userdata('user_id'), array(1,61,162,495,344,1161,1709,488,4405))) { ?> 
    	                        <button type="button" class="btn btn-primary" onclick="open_mdl_akses_menu()" id="btn_add_akses_menu"><i class="bi bi-plus"></i> Akses Menu</button>
							<?php } ?>	
                        </div>
                    </div>
                    <br><label for=""><h5><?= $pageTitle; ?></h5></label><br>

                    <div class="table-responsive" style="padding: 10px;">

                        <!-- <table id="tbl_goal_h" class="table table-sm table-striped" style="width:100%">                            
                        </table> -->
						<table id="dt_menu" class="table table-striped dt-responsive" style="width:100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>Nama Menu</th>		
									<th>Employee</th>
									<!-- <th>Action</th>																		 -->
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
                    </div>
                </div>
            </div>
        </div>

		<div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                        </div>
                        <div class="col col-sm-auto">
                           
                        </div>
                        <div class="col text-end">                            
							<?php if (in_array($this->session->userdata('user_id'), array(1,61,162,495,344,1161,1709,488,4405))) { ?> 
    	                        <button type="button" class="btn btn-primary" onclick="open_mdl_akses_fitur()" id="btn_add_akses_fitur"><i class="bi bi-plus"></i> Akses Fitur</button>
							<?php } ?>	
                        </div>
                    </div>
                    <br><label for=""><h5>Parameter Fitur</h5></label><br>

                    <div class="table-responsive" style="padding: 10px;">

                        <!-- <table id="tbl_goal_h" class="table table-sm table-striped" style="width:100%">                            
                        </table> -->
						<table id="tbl_fitur" class="table table-striped dt-responsive" style="width:100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>Nama Fitur</th>		
									<th>Employee</th>
									<th>Keterangan</th>
									<!-- <th>Action</th>																		 -->
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


<div class="modal fade" id="mdl_add_akses" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-l" role="document">
        <div class="modal-content">

			<div class="modal-header row align-items-center">
				<div class="col-auto">
					<i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
				</div>
				<div class="col">
					<h6 class="fw-medium mb-0" id="modalAddLabel">Form Tambah Akses</h6>
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
				<form id="form_tambah_akses" autocomplete="off">
					<div class="form-group row" > 
						                     
                        <div class="col-lg-12 col-sm-12" style="margin-top: 10px;">
							<label>Pilih Menu</label>
							<select name="menu_id" id="menu_id">
								<option data-placeholder="true">-- Pilih Menu --</option>
								<?php foreach($list_menu as $row):?>
									<option value="<?php echo $row->menu_id; ?>"><?php echo $row->menu_nm;?></option>
								<?php endforeach;?>
							</select>
						</div>
						

						
						<div class="col-lg-12 col-sm-12" style="margin-bottom: 10px; margin-top: 10px;">
							<label>User</label>
							<select name="user" id="user">
								<option data-placeholder="true">-- Pilih User --</option>
								<?php foreach($list_karyawan as $row):?>
									<option value="<?php echo $row->id_user; ?>"><?php echo $row->employee_name;?></option>
								<?php endforeach;?>
							</select>
						</div>
					</div>
				</form>
            </div>
            <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="margin-right: 10px;">Close</button>
				<button type="button" class="btn btn-success" id="btn_add_akses_menu" onclick="add_akses_menu()">Save</button>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_add_akses_fitur" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-l" role="document">
        <div class="modal-content">

			<div class="modal-header row align-items-center">
				<div class="col-auto">
					<i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
				</div>
				<div class="col">
					<h6 class="fw-medium mb-0" id="modalAddLabel">Form Tambah Akses Fitur</h6>
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
				<form id="form_tambah_akses_fitur" autocomplete="off">
					<div class="form-group row" > 
						                     
                        <div class="col-lg-12 col-sm-12" style="margin-top: 10px;">
							<label>Pilih Fitur</label>
							<select name="fitur_id" id="fitur_id">
								<option data-placeholder="true">-- Pilih Menu --</option>
								<?php foreach($list_fitur as $row):?>
									<option value="<?php echo $row->id; ?>"><?php echo $row->access;?></option>
								<?php endforeach;?>
							</select>
						</div>
						

						
						<div class="col-lg-12 col-sm-12" style="margin-bottom: 10px; margin-top: 10px;">
							<label>User</label>
							<select name="user2" id="user2">
								<option data-placeholder="true">-- Pilih User --</option>
								<?php foreach($list_karyawan as $row):?>
									<option value="<?php echo $row->id_user; ?>"><?php echo $row->employee_name;?></option>
								<?php endforeach;?>
							</select>
						</div>
					</div>
				</form>
            </div>
            <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="margin-right: 10px;">Close</button>
				<button type="button" class="btn btn-success" id="btn_add_akses_fitur" onclick="add_akses_fitur()">Save</button>

            </div>
        </div>
    </div>
</div