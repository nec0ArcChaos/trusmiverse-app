<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <!-- <p class="text-secondary">Deskripsi Page</p> -->
            </div>
            <div class="col col-sm-auto">
                <div class="input-group input-group-md reportrange">
                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;">
                    <input type="hidden" name="startdate" value="" id="start" />
                    <input type="hidden" name="enddate" value="" id="end" />
                    <span class="input-group-text text-secondary bg-none" id="btn_filter"><i class="bi bi-calendar-event"></i></span>
                </div>
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
                            <i class="bi bi-file-earmark-pdf h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List FDK</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                            <div style="display: flex;justify-content: space-between;">
                                <div style="padding: 5px;">
                                    <?php if ($this->session->userdata("user_role_id") == '1') { ?>
                                    <button type="button" class="btn btn-warning" onclick="list_approve()"><i class="fa-solid fa-person-circle-check"></i>
                                        Approve</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_fdk" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Lengkap</th>
                                    <th>Company</th>
                                    <th>Posisi</th>
                                    <th>Status FDK</th>
                                    <th>Date Join</th>
                                    <th>PIC Rec.</th>
                                    <th>Updtd.at</th>
                                    <th class="bg-light-yellow">KTP</th>
                                    <th class="bg-light-yellow">KK</th>
                                    <th class="bg-light-yellow">Surat Lamaran</th>
                                    <th class="bg-light-yellow">CV</th>
                                    <th class="bg-light-yellow">Ijazah</th>
                                    <th>Transkip</th>
                                    <th>NPWP</th>
                                    <th>Surat Lulus</th>
                                    <th>Paklaring</th>
                                    <th>Sertifikat</th>
                                    <th>Dokumen Lain</th>
                                    <th>Contact</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal Add -->
<div class="modal fade" id="modal_input" aria-labelledby="modal_input_dokumen" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add_pembelajar">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-file-earmark-pdf h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_input_dokumen">Input <?= $pageTitle ?></h6>
                        <p class="text-secondary small">Input Manual Dokumen Karyawan</p>
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
                        <div class="col-6">
                            <label class="form-label-custom required small" for="karyawan">Karyawan</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text bi bi-person-check-fill" style="background-color: #F5F5F5;border: 1px solid #ddd;"></span>
                                <select name="karyawan" id="karyawan" class="nice-select" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;width:100%;">
                                </select>
                                <input type="hidden" value="" id="id_employee">
                                <input type="hidden" value="" id="app_id">
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label class="form-label-custom required small" for="title">Nama Karyawan</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text bi bi-person-lines-fill" style="background-color: #F5F5F5;border: 1px solid #ddd;"></span>
                                <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Karyawan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" readonly>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label-custom required small" for="title">Posisi</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text bi bi-person-lines-fill" style="background-color: #F5F5F5;border: 1px solid #ddd;"></span>
                                <input type="text" class="form-control" name="posisi" id="posisi" placeholder="Posisi Karyawan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" readonly>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label-custom required small" for="title">Company</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text bi bi-person-lines-fill" style="background-color: #F5F5F5;border: 1px solid #ddd;"></span>
                                <input type="text" class="form-control" name="company" id="company" placeholder="Company" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" readonly>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <h6 class="fw-medium mb-0" id="modal_input_dokumen">Dokumen Wajib</h6>
                        <p class="text-secondary small">Berisi semua dokumen wajib yang harus di sertakan karyawan</p>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4">
                            <label class="form-label-custom required small" for="title">KTP</label>
                            <input type="file" class="form-control" name="ktp" id="ktp" placeholder="Nama Karyawan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" accept="image/*,.pdf" data-max-files="1" onchange="uploadPhoto('<?= base_url('/uploads/fdk/req/'); ?>','ktp')">
                        </div>
                        <div class="col-4">
                            <label class="form-label-custom required small" for="title">Kartu Keluarga</label>

                            <input type="file" class="form-control" name="kk" id="kk" placeholder="Posisi Karyawan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" accept="image/*,.pdf" data-max-files="1">
                        </div>
                        <div class="col-4">
                            <label class="form-label-custom required small" for="title">Surat Lamaran</label>

                            <input type="file" class="form-control" name="lamaran" id="lamaran" placeholder="Company" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" accept="image/*,.pdf" data-max-files="1">

                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4">
                            <label class="form-label-custom required small" for="title">CV</label>

                            <input type="file" class="form-control" name="cv" id="cv" placeholder="Nama Karyawan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" accept="image/*,.pdf" data-max-files="1">
                        </div>
                        <div class="col-4">
                            <label class="form-label-custom required small" for="title">Ijazah</label>

                            <input type="file" class="form-control" name="ijazah" id="ijazah" placeholder="Posisi Karyawan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" accept="image/*,.pdf" data-max-files="1">
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <h6 class="fw-medium mb-0" id="modal_input_dokumen">Dokumen Optional</h6>
                        <p class="text-secondary small">Berisi semua dokumen optinal karyawan</p>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4">
                            <label class="form-label-custom required small" for="title">Transkip</label>

                            <input type="file" class="form-control" name="transkip" id="transkip" placeholder="transkip Karyawan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" data-max-files="1">

                        </div>
                        <div class="col-4">
                            <label class="form-label-custom required small" for="title">NPWP</label>

                            <input type="file" class="form-control" name="npwp" id="npwp" placeholder="npwp Karyawan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" data-max-files="1">
                        </div>
                        <div class="col-4">
                            <label class="form-label-custom required small" for="title">Surat Lulus</label>

                            <input type="file" class="form-control" name="surat_lulus" id="surat_lulus" placeholder="surat_lulus" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" data-max-files="1">

                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4">
                            <label class="form-label-custom required small" for="title">Parklaring</label>

                            <input type="file" class="form-control" name="verklaring" id="verklaring" placeholder="verklaring Karyawan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" data-max-files="1">
                        </div>
                        <div class="col-4">
                            <label class="form-label-custom required small" for="title">Sertifikat</label>

                            <input type="file" class="form-control" name="sertifikat" id="sertifikat" placeholder="sertifikat Karyawan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" data-max-files="1">
                        </div>
                        <div class="col-4">
                            <label class="form-label-custom required small" for="title">Dokumen Lain</label>

                            <input type="file" class="form-control" name="dokumen_lain" id="dokumen_lain" placeholder="dokumen_lain Karyawan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" data-max-files="1">
                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-md btn-primary" id="btn_save" onclick="submit_dokumen()">Save
                        <i class="bi bi-file-earmark-pdf"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->

<div class="modal fade" id="modal_approval" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0">Approval Dokumen</h6>
                    <p class="text-secondary small" id="detail"></p>
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
                    <table id="dt_approval" class="table nowrap table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Company</th>
                                <th>Date Join</th>
                                <th>PIC Rec.</th>
                                <th class="bg-light-yellow">KTP</th>
                                <th class="bg-light-yellow">KK</th>
                                <th class="bg-light-yellow">Lamaran</th>
                                <th class="bg-light-yellow">CV</th>
                                <th class="bg-light-yellow">Ijazah</th>
                                <th>Transkip</th>
                                <th>NPWP</th>
                                <th>S. Lulus</th>
                                <th>Paklaring</th>
                                <th>Sertifikat</th>
                                <th>Lainnya</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <!-- <button type="button" class="btn btn-md btn-primary" id="btn_save" onclick="save()">Update
                        <i class="bi bi-card-checklist"></i></button> -->
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk pratinjau dokumen -->
<div class="modal fade" id="modal_preview" aria-labelledby="previewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewLabel">Preview & Approval Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <input type="hidden" class="user_id">
            <input type="hidden" class="dokumen">
            <div class="modal-body" id="preview_body">
                <!-- Konten pratinjau dokumen akan dimasukkan di sini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary mx-1" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-danger mx-1 text-white" onclick="update(2)"><i class="fa fa-close"></i> Reject
                </button>
                <button type="button" class="btn btn-md btn-primary mx-1" onclick="update(1)"><i class="fa fa-check-circle"></i> Approve
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_lihat_contact" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lihat Semua Kontak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-responsive table-striped w-100" id="dt_contact">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary mx-1" data-bs-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>