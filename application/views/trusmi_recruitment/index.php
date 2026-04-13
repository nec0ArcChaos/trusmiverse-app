<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Deskripsi Page</p>
            </div>
            <div class="col col-sm-auto">
                <form method="POST" id="form_filter">
                    <div class="input-group input-group-md reportrange">
                        <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                        <input type="hidden" name="start" value="" id="start" readonly/>
                        <input type="hidden" name="end" value="" id="end" readonly/>
                        <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </form>
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
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-person-bounding-box h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Dashboard Recruitment</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                            <button type="button" class="btn btn-md btn-outline-theme" data-bs-toggle="modal" data-bs-target="#modal_target_marketing"><i class="bi bi-plus"></i> Add Target Marketing</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_recruitment" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tittle Job</th>
                                    <th>Level</th>
                                    <th>Company</th>
                                    <th>Leadtime TGT</th>
                                    <th>PIC</th>
                                    <th>Applicant</th>
                                    <th>Psikotest</th>
                                    <th>Interview</th>
                                    <th>Administrasi</th>
                                    <th>Target SDM</th>
                                    <th>Employee</th>
                                    <th>Achiev Target <i class="bi bi-info-circle" title="Total Karyawan/Target SDM"></i></th>
                                    <th>Tgl Posting</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal Target Marketing -->
<div class="modal fade" id="modal_target_marketing" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_target_marketing">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Add Target Marketing</p>
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
                    <div class="col-12 col-lg-12 col-xl-12 mb-4">
                        <h6 class="title">Detail Target <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
                        <div class="row">
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-date"></i></span>
                                        <div class="form-floating">
                                            <select name="period" id="period" class="form-control">
                                                <option data-placeholder="true">-- Choose Period --</option>
                                                <?php if (date('m') != 12) { ?>
                                                <optgroup label="<?= date('Y') ?>">
                                                    <option value="<?= date('Y'); ?>-01">January</option>
                                                    <option value="<?= date('Y'); ?>-02">February</option>
                                                    <option value="<?= date('Y'); ?>-03">March</option>
                                                    <option value="<?= date('Y'); ?>-04">April</option>
                                                    <option value="<?= date('Y'); ?>-05">May</option>
                                                    <option value="<?= date('Y'); ?>-06">June</option>
                                                    <option value="<?= date('Y'); ?>-07">July</option>
                                                    <option value="<?= date('Y'); ?>-08">August</option>
                                                    <option value="<?= date('Y'); ?>-09">September</option>
                                                    <option value="<?= date('Y'); ?>-10">October</option>
                                                    <option value="<?= date('Y'); ?>-11">November</option>
                                                    <option value="<?= date('Y'); ?>-12">December</option>
                                                </optgroup>
                                                <?php } else if (date('m') == 12) { ?>
                                                    <optgroup label="<?= date('Y') ?>">
                                                        <option value="<?= date('Y') ?>-12">December</option>
                                                    </optgroup>
                                                    <optgroup label="<?= date('Y', strtotime('1 year')) ?>">
                                                        <option value="<?= date('Y', strtotime('1 year')); ?>-01">January</option>
                                                        <option value="<?= date('Y', strtotime('1 year')); ?>-02">February</option>
                                                        <option value="<?= date('Y', strtotime('1 year')); ?>-03">March</option>
                                                        <option value="<?= date('Y', strtotime('1 year')); ?>-04">April</option>
                                                        <option value="<?= date('Y', strtotime('1 year')); ?>-05">May</option>
                                                        <option value="<?= date('Y', strtotime('1 year')); ?>-06">June</option>
                                                        <option value="<?= date('Y', strtotime('1 year')); ?>-07">July</option>
                                                        <option value="<?= date('Y', strtotime('1 year')); ?>-08">August</option>
                                                        <option value="<?= date('Y', strtotime('1 year')); ?>-09">September</option>
                                                        <option value="<?= date('Y', strtotime('1 year')); ?>-10">October</option>
                                                        <option value="<?= date('Y', strtotime('1 year')); ?>-11">November</option>
                                                        <option value="<?= date('Y', strtotime('1 year')); ?>-12">December</option>
                                                    </optgroup>
                                                <?php } ?>
                                            </select>
                                            <label>*Period</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-up"></i></span>
                                        <div class="form-floating">
                                            <select name="pic" id="pic" class="form-control">
                                                <option data-placeholder="true">-- Choose Employee --</option>
                                                <?php foreach ($pic as $row) : ?>
                                                    <option value="<?= $row->user_id ?>"><?= $row->employee_name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>*PIC Recruitment</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                        <div class="form-floating">
                                            <input type="number" id="target" name="target" class="form-control" required>
                                            <label>*Target</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-up"></i></span>
                                        <div class="form-floating">
                                            <select name="jobs" id="jobs" class="form-control">
                                                <option data-placeholder="true">-- Choose Job --</option>
                                                <?php foreach ($jobs as $row) : ?>
                                                    <option value="<?= $row->job_id ?>"><?= $row->job_title ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>*Job</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save_target_marketing">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Target Marketing -->

<!-- Modal Edit PIC -->
<div class="modal fade" id="modal_pic" tabindex="-1" aria-labelledby="modalPicLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="form_pic">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalPicLabel">Form</h6>
                        <p class="text-secondary small">Update PIC</p>
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
                        <div class="col-12 col-md-12 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-up"></i></span>
                                    <div class="form-floating">
                                        <select name="e_pic" id="e_pic" class="form-control">
                                            <option data-placeholder="true">-- Choose Employee --</option>
                                            <?php foreach ($pic as $row) : ?>
                                                <option value="<?= $row->user_id ?>"><?= $row->employee_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label>*PIC Recruitment</label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="trusmi_request_id_pic" name="trusmi_request_id_pic" readonly>
                            <input type="hidden" id="job_id_pic" name="job_id_pic" readonly>
                            <input type="hidden" id="tipe_pic" name="tipe_pic" readonly>
                            <input type="hidden" name="id_target_mkt" value="" id="id_target_mkt" readonly>
                            <div class="invalid-feedback mb-3">Add valid data </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save_pic" onclick="update_pic()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Edit PIC -->

<!-- Applicant Details -->
<div class="modal fade" id="modal_lamar" tabindex="-1" role="dialog" aria-labelledby="modal_lamarLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal_lamarLabel">Applicant Details</h6>
                    <p class="text-secondary small">Apply Jobs</p>
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
				<div class="table-responsive">
					<table id="dt_lamar" class="table table-striped dt-responsive" style="width: 100%">
						<thead>
							<tr>
								<th>Name</th>
								<th>Contact</th>
								<th>Email</th>
								<th>Resume</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-md btn-outline-theme" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Psikotest Details -->
<div class="modal fade" id="modal_psikotes" tabindex="-1" role="dialog" aria-labelledby="modal_psikotesLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal_psikotesLabel">Psikotest Details</h6>
                    <p class="text-secondary small">Result</p>
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
				<div class="table-responsive">
					<table id="dt_psikotes" class="table table-striped dt-responsive" style="width: 100%">
						<thead>
							<tr>
								<th>Name</th>
								<th>IQ</th>
								<th>DISC</th>
								<th>Note</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-md btn-outline-theme" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Detail Interview -->
<div class="modal fade" id="modal_interview" tabindex="-1" role="dialog" aria-labelledby="modal_interviewLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal_interviewLabel">Interview Details</h6>
                    <p class="text-secondary small">Result</p>
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
				<div class="table-responsive">
					<table id="dt_interview" class="table table-striped dt-responsive" style="width: 100%">
						<thead>
							<tr>
								<th>Name</th>
								<th>Note</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-md btn-outline-theme" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Detail Administation -->
<div class="modal fade" id="modal_administrasi" tabindex="-1" role="dialog" aria-labelledby="modal_administrasiLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal_administrasiLabel">Administration Details</h6>
                    <p class="text-secondary small">Result</p>
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
				<div class="table-responsive">
					<table id="dt_administrasi" class="table table-striped dt-responsive" style="width: 100%">
						<thead>
							<tr>
								<th>Name</th>
								<th>Note</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-md btn-outline-theme" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Detail Employee -->
<div class="modal fade" id="modal_karyawan" tabindex="-1" role="dialog" aria-labelledby="modal_karyawanLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal_karyawanLabel">Employee Details</h6>
                    <p class="text-secondary small">Result</p>
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
				<div class="table-responsive">
					<table id="dt_karyawan" class="table table-striped dt-responsive" style="width: 100%">
						<thead>
							<tr>
								<th>Name</th>
								<th>Leadtime (hari)</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-md btn-outline-theme" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Update Target -->
<div class="modal fade" id="modal_target_sdm" tabindex="-1" role="dialog" aria-labelledby="modal_target_sdmLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
            <form id="form_target">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_target_sdmLabel">Form</h6>
                        <p class="text-secondary small">Update Target</p>
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
                        <div class="col">
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                        <div class="form-floating">
                                            <input type="number" id="target_sdm" name="target_sdm" class="form-control" required>
                                            <label>*Target</label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="target_job_id" name="target_job_id" readonly>
                                <input type="hidden" id="target_tipe" name="target_tipe" readonly>
                                <input type="hidden" name="e_id_target_mkt" value="" id="e_id_target_mkt" readonly>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-theme" style="margin-right:10px;" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-outline-success" id="btn_save_target" onclick="update_target()">Save</button>
			</div>
		</div>
	</div>
</div>