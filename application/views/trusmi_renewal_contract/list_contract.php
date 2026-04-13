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
                        <input type="hidden" name="start" value="" id="start" />
                        <input type="hidden" name="end" value="" id="end" />
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
                            <i class="bi bi-pen h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Contract New</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_contract_new" class="table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Department/Designation</th>
                                    <th>Masa Kerja</th>
                                    <th>Head Name</th>
                                    <th>Contract End</th>
                                    <th>Status</th>
                                    <th>Lama Perpanjang</th>
                                    <th>Feedback</th>
                                    <th>Feedback By</th>
                                    <!-- addnew -->
                                    <th>Posisi Masih Sesuai</th>
                                    <th>Performa Kerja Karyawan (KPI)</th>
                                    <th>P1</th>
                                    <th>P2</th>
                                    <th>P3</th>
                                    <th>P4</th>
                                    <th>P5</th>
                                    <th>P6</th>
                                    <th>P7</th>
                                    <th>P8</th>
                                    <th>P9</th>
                                    <th>P10</th>
                                    <th>P11</th>
                                    <th>Feedback At</th>
                                </tr>
                            </thead>
                            <tbody></tbody>

                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <p>Keterangan (Penilaian) : </p>
                    <ul style="font-size: 10pt;text-align: justify;">
                        <li>P1 : Memiliki Kemauan untuk terus belajar</li>
                        <li>P2 : Melakukan evaluasi dari setiap yang sudah dilakukan</li>
                        <li>P3 : Mampu beradaptasi dengan budaya perusahaan dan menunjukan performa kerja yang baik</li>
                        <li>P4 : Berani untuk mengambil suatu keputusan/tanggung jawab</li>
                        <li>P5 : Berjuang untuk menyelesaikan pekerjaan</li>
                        <li>P6 : Melakukan suatu hal baik tanpa perlu diminta</li>
                        <li>P7 : membangun iklim kerja yang harmonis</li>
                        <li>P8 : Memberikan motivasi kepada rekan kerja</li>
                        <li>P9 : Berusaha menjadi tauladan bagi karyawan lain</li>
                        <li>P10 : Sikap Percepatan</li>
                        <li>P11 : Sikap Disiplin</li>
                        <!-- <li>Q10 : Informasi lain yang ingin anda sampaikan (bila perlu) ?</li> -->
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
                                            <input type="text" placeholder="Resignation Date" name="resignation_date" id="resignation_date" required class="form-control border-start-0">
                                            <label>Resignation Date</label>
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
                                                <option data-placeholder="true"></option>
                                                <option value="Habis Kontrak">Habis Kontrak</option>
                                                <option value="Salary">Salary</option>
                                                <option value="Jam Kerja">Jam Kerja</option>
                                                <option value="Atasan">Atasan</option>
                                                <option value="Tidak Achive">Tidak Achive</option>
                                                <option value="Mendapat Pekerjaan Baru">Mendapat Pekerjaan Baru</option>
                                                <option value="Lainnya">Lainnya</option>
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
    <div class="modal-dialog modal-lg">
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