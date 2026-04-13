<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Deskripsi Page</p>
            </div>
            <div class="col col-sm-auto">
                <div class="input-group input-group-md reportrange">
                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                    <input type="hidden" name="start" value="" id="start" />
                    <input type="hidden" name="end" value="" id="end" />
                    <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                </div>
            </div>
            <div class="col-auto ps-0">

            </div>
        </div>
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
                        </ol>
                    </div>
                    <div class="col-12 col-md-6 text-end">
                        <?php if ($this->session->userdata('user_id') == '2063' || $this->session->userdata('user_id') == '61' || $this->session->userdata('role') == '1' || $this->session->userdata('user_id') == '1' || $this->session->userdata('user_id') == '979') { ?>
                            <button type="button" class="btn btn-md btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalReportDetail" onclick="dt_report_detail()" id="btn_report_detail"><i class="bi bi-file-earmark-text"></i> Report Detail</button>
                        <?php } ?>
                    </div>
                </div>

            </nav>
        </div>
    </div>

    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Resignation </h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                            <div style="display: flex;justify-content: space-between;">
                                <div id="btn_list_approval_pic" class="" style="padding: 5px;">
                                    <?php if ($this->session->userdata('user_id') == '2063' || $this->session->userdata('user_id') == '61' || $this->session->userdata('role') == '1' || $this->session->userdata('user_id') == '1' || $this->session->userdata('user_id') == '979') { ?>
                                        <a href="javascript:void(0)" onclick="list_waiting_resignation_hrd()" class="btn btn-md btn-outline-secondary"><i class="bi bi-eye"></i> List Approval HRD</a>
                                    <?php } ?>
                                    <a href="javascript:void(0)" onclick="list_waiting_resignation()" class="btn btn-md btn-outline-warning"><i class="bi bi-eye"></i> List Waiting Approval</a>
                                </div>
                                <div id="btn_my_resignation" class="hide" style="padding: 5px;">

                                </div>
                                <div style="padding: 5px;">
                                    <button type="button" class="btn btn-md btn-outline-theme" data-bs-toggle="modal" data-bs-target="#modalAdd" onclick="get_profil_user()" id="btn_add_resignation"><i class="bi bi-plus"></i> Resignation</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_trusmi_resignation" class="table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Notice Date</th>
                                    <th>Resignation Date</th>
                                    <th>Join Date</th>
                                    <th>Employee Name</th>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Category</th>
                                    <th>Reason</th>
                                    <th>Note</th>
                                    <th>Status</th>
                                    <th style="display: none;">Manager</th>
                                    <th style="display: none;">Spv</th>
                                    <th style="display: none;">Reason Atasan</th>
                                    <th style="display: none;">Q1</th>
                                    <th style="display: none;">Q2</th>
                                    <th style="display: none;">Q3</th>
                                    <th style="display: none;">Q4</th>
                                    <th style="display: none;">Q5</th>
                                    <th style="display: none;">Q6</th>
                                    <th style="display: none;">Q7</th>
                                    <th style="display: none;">Q8</th>
                                    <th style="display: none;">Q9</th>
                                    <th style="display: none;">Q10</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <p>Keterangan (Question) : </p>
                    <ul style="font-size: 10pt;text-align: justify;">
                        <li>Q1 : Apakah tugas dan tanggung jawab dalam pekerjaan anda sehari-hari sudah sesuai dengan yang anda harapkan ?</li>
                        <li>Q2 : Bagaimana pendapat anda mengenai kondisi kerja (suasana, peralatan dan lingkungan) ?</li>
                        <li>Q3 : Bagaimana pendapat anda mengenai tunjangan, fasilitas dan benefit dari perusahaan?</li>
                        <li>Q4 : Bagaimana pendapat anda mengenai perlakuan atasan terhadap anda selama ini (pembinaan masalah, menghadapi keluhan) ?</li>
                        <li>Q5 : Bagaimana pendapat anda mengenai semangat kerjasama dan team work dibagian / departemen anda ?</li>
                        <li>Q6 : Bagaimana pendapat anda mengenai kemauan manajemen untuk mendengarkan aspirasi, ide dan masukan dari karyawan serta mengadakan perubahan ?</li>
                        <li>Q7 : Yang menjadi alasan utama anda resign ?</li>
                        <li>Q8 : Apabila masih ada kesempatan, apa yang dapat dilakukan perusahaan untuk mempertahankan anda saat ini ?</li>
                        <li>Q9 : Menurut anda, apa yang harus terlebih dilakukan perusahaan ini agar dapat menjadi tempat berkerja / berkarir yang baik ?</li>
                        <li>Q10 : Informasi lain yang ingin anda sampaikan (bila perlu) ?</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal Add -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Submission of Resignation </p>
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
                        <h6 class="title">Detail User</h6>
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-info-square"></i></span>
                                        <div class="form-floating">
                                            <input type="hidden" placeholder="Company" name="company_id" id="company_id" required class="form-control border-start-0" readonly>
                                            <input type="hidden" placeholder="Designation" name="designation_id" id="designation_id" required class="form-control border-start-0" readonly>
                                            <input type="text" placeholder="Company" name="company_name" id="company_name" required class="form-control border-start-0" readonly>
                                            <label>Company</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-info-square"></i></span>
                                        <div class="form-floating">
                                            <input type="text" placeholder="Department" name="department_name" id="department_name" required class="form-control border-start-0" readonly>
                                            <label>Department</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-info-square"></i></span>
                                        <div class="form-floating">
                                            <input type="text" placeholder="Designation" name="designation_name" id="designation_name" required class="form-control border-start-0" readonly>
                                            <label>Designation</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-date"></i></span>
                                        <div class="form-floating">
                                            <input type="text" placeholder="Notice Date" name="notice_date" id="notice_date" required class="form-control border-start-0" value="<?= date("Y-m-d"); ?>" readonly>
                                            <label>Notice Date</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-date"></i></span>
                                        <div class="form-floating">
                                            <input type="text" placeholder="Resignation Date" name="resignation_date" id="resignation_date" required class="form-control border-start-0" readonly style="background-color: white;">
                                            <label>Resignation Date</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-list"></i></span>
                                        <div class="form-floating">
                                            <select name="category" id="category" class="form-control border-start-0">
                                                <option data-placeholder="true"></option>
                                                <option value="1">Habis Kontrak</option>
                                                <option value="2">Resign</option>
                                                <option value="3">Diputus Kontrak</option>
                                            </select>
                                            <label>Resignation Category</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-up"></i></span>
                                        <div class="form-floating">
                                            <select name="reason" id="reason" class="form-control border-start-0">
                                                <!-- <option data-placeholder="true"></option>
                                                <option value="Habis Kontrak">Habis Kontrak</option>
                                                <option value="Salary">Salary</option>
                                                <option value="Jam Kerja">Jam Kerja</option>
                                                <option value="Atasan">Atasan</option>
                                                <option value="Tidak Achive">Tidak Achive</option>
                                                <option value="Mendapat Pekerjaan Baru">Mendapat Pekerjaan Baru</option>
                                                <option value="Lainnya">Lainnya</option> -->
                                            </select>
                                            <label>Resignation Reason</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <textarea name="note" id="note" class="form-control border-start-0" cols="30" rows="5" style="min-height: 80px;" required></textarea>
                                            <label>Note</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>

                        <h6 class="title">Required Question</h6>
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="" style="text-align: justify;font-size: small;">Apakah tugas dan tanggung jawab dalam pekerjaan anda sehari-hari sudah sesuai dengan yang anda harapkan ?</label>
                                </div>
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                        <div class="form-floating">
                                            <textarea name="pernyataan_1" id="pernyataan_1" class="form-control border-start-0" cols="30" rows="5" style="min-height: 100px;" required></textarea>
                                            <label>Jawab : </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="" style="text-align: justify;font-size: small;">Bagaimana pendapat anda mengenai kondisi kerja (suasana, peralatan dan lingkungan) ?</label>
                                </div>
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                        <div class="form-floating">
                                            <textarea name="pernyataan_2" id="pernyataan_2" class="form-control border-start-0" cols="30" rows="5" style="min-height: 100px;" required></textarea>
                                            <label>Jawab : </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="" style="text-align: justify;font-size: small;">Bagaimana pendapat anda mengenai tunjangan, fasilitas dan benefit dari perusahaan?</label>
                                </div>
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                        <div class="form-floating">
                                            <textarea name="pernyataan_3" id="pernyataan_3" class="form-control border-start-0" cols="30" rows="5" style="min-height: 100px;" required></textarea>
                                            <label>Jawab : </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="" style="text-align: justify;font-size: small;">Bagaimana pendapat anda mengenai perlakuan atasan terhadap anda selama ini (pembinaan masalah, menghadapi keluhan) ?</label>
                                </div>
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                        <div class="form-floating">
                                            <textarea name="pernyataan_4" id="pernyataan_4" class="form-control border-start-0" cols="30" rows="5" style="min-height: 100px;" required></textarea>
                                            <label>Jawab : </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="" style="text-align: justify;font-size: small;">Bagaimana pendapat anda mengenai semangat kerjasama dan team work dibagian / departemen anda ?</label>
                                </div>
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                        <div class="form-floating">
                                            <textarea name="pernyataan_5" id="pernyataan_5" class="form-control border-start-0" cols="30" rows="5" style="min-height: 100px;" required></textarea>
                                            <label>Jawab : </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="" style="text-align: justify;font-size: small;">Bagaimana pendapat anda mengenai kemauan manajemen untuk mendengarkan aspirasi, ide dan masukan dari karyawan serta mengadakan perubahan ?</label>
                                </div>
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                        <div class="form-floating">
                                            <textarea name="pernyataan_6" id="pernyataan_6" class="form-control border-start-0" cols="30" rows="5" style="min-height: 100px;" required></textarea>
                                            <label>Jawab : </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="" style="text-align: justify;font-size: small;">Yang menjadi alasan utama anda resign ?</label>
                                </div>
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                        <div class="form-floating">
                                            <textarea name="pernyataan_7" id="pernyataan_7" class="form-control border-start-0" cols="30" rows="5" style="min-height: 100px;" required></textarea>
                                            <label>Jawab : </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="" style="text-align: justify;font-size: small;">Apabila masih ada kesempatan, apa yang dapat dilakukan perusahaan untuk mempertahankan anda saat ini ?</label>
                                </div>
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                        <div class="form-floating">
                                            <textarea name="pernyataan_8" id="pernyataan_8" class="form-control border-start-0" cols="30" rows="5" style="min-height: 100px;" required></textarea>
                                            <label>Jawab : </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="" style="text-align: justify;font-size: small;">Menurut anda, apa yang harus terlebih dilakukan perusahaan ini agar dapat menjadi tempat berkerja / berkarir yang baik ?</label>
                                </div>
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                        <div class="form-floating">
                                            <textarea name="pernyataan_9" id="pernyataan_9" class="form-control border-start-0" cols="30" rows="5" style="min-height: 100px;" required></textarea>
                                            <label>Jawab : </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="" style="text-align: justify;font-size: small;">Informasi lain yang ingin anda sampaikan (bila perlu) ?</label>
                                </div>
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                        <div class="form-floating">
                                            <textarea name="pernyataan_10" id="pernyataan_10" class="form-control border-start-0" cols="30" rows="5" style="min-height: 100px;" required></textarea>
                                            <label>Jawab : </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_save" onclick="save()">Save Resignation</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->

<!-- Modal Add Confirm-->
<div class="modal fade" id="modalAddConfirm" tabindex="-1" aria-labelledby="modalAddConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddConfirmLabel">Form</h6>
                    <p class="text-secondary small">Submission of Resignation </p>
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
                    <h6 class="title">Are you sure ?</h6>
                    <p style="text-align: justify;"><b>Note</b> : Jika anda menyetujui maka notifikasi akan dikirim ke pic terkait, <b>Form Exit Clearance</b> anda harus mendapat <b>approval</b> dari pic terkait sebelum anda bisa melanjutkan langkah selanjutnya.</p>
                    <p>PIC Exit Clearance :</p>
                    <ul>
                        <?php foreach ($pic as $key) { ?>
                            <li><?= $key->pic; ?></li>
                        <?php } ?>
                    </ul>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-outline-theme" id="btn_save_confirm" onclick="store_resignation()">Yes, Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add Confirm -->


<!-- Modal List Waiting-->
<div class="modal fade" id="modal-list-waiting-resignation" tabindex="-1" aria-labelledby="modal-list-waiting-resignationLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal-list-waiting-resignationLabel">Form</h6>
                    <p class="text-secondary small">Waiting Exit Clearance </p>
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
                <div class="table-responsive" style="padding: 10px;">
                    <table id="dt_trusmi_list_waiting_resignation" class="table table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Notice Date</th>
                                <th>Resignation Date</th>
                                <th>Employee Name</th>
                                <th>Company</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal List Waiting -->



<!-- Modal List Waiting HRD-->
<div class="modal fade" id="modal-list-waiting-resignation-hrd" tabindex="-1" aria-labelledby="modal-list-waiting-resignation-hrdLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal-list-waiting-resignation-hrdLabel">Form</h6>
                    <p class="text-secondary small">Waiting HRD - Exit Clearance </p>
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
                <div class="table-responsive" style="padding: 10px;">
                    <table id="dt_trusmi_list_waiting_resignation_hrd" class="table table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Notice Date</th>
                                <th>Resignation Date</th>
                                <th>Employee Name</th>
                                <th>Company</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal List Waiting HRD-->



<!-- Modal Report Detail-->
<div class="modal fade" id="modalReportDetail" tabindex="-1" aria-labelledby="modalReportDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalReportDetailLabel">Report</h6>
                    <p class="text-secondary small">Detail - Exit Clearance </p>
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
                <div class="col col-sm-auto">
                    <div class="input-group input-group-md reportrange2">
                        <input type="text" class="form-control range2 bg-none px-0" style="cursor: pointer;" id="titlecalendar2">
                        <input type="hidden" name="start_report" value="" id="start_report" />
                        <input type="hidden" name="end_report" value="" id="end_report" />
                        <span class="input-group-text text-secondary bg-none" id="titlecalandershow2"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </div>
                <div class="table-responsive" style="padding: 10px;">
                    <table id="dt_report_detail" class="table table-sm table-striped nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Created At</th>
                                <th>Employee Name</th>
                                <th>Company</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Date Of Joining</th>
                                <th>Masa Kerja</th>
                                <th>Habis Kontrak</th>
                                <th>Last Attendance</th>
                                <th>Manager</th>
                                <th>Head Department</th>
                                <th>SPV</th>
                                <th>Reason Atasan</th>
                                <th>Sub Clearance</th>
                                <th>Status</th>
                                <th>Diperiksa Oleh</th>
                                <th>Approve At</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Report Detail-->





<div class="modal fade" id="modal-confirm-resend-wa" tabindex="-1" aria-labelledby="modal-confirm-resend-waLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal-confirm-resend-waLabel">Alert</h6>
                    <p class="text-secondary small">Resend Whatsapp Notification </p>
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
                <h6>Apakah anda yakin ingin kirim ulang whatsapp notifikasi atas pengajuan exit clearance karyawan ini ?</h6>
                <input type="hidden" id="id-resignation-confirm-resend-wa" name="id_resignation_resend_wa" class="form-control" readonly>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-outline-theme" id="btn_save_confirm" onclick="resend_wa()">Yes, Resend Notif</button>
            </div>
        </div>
    </div>
</div>