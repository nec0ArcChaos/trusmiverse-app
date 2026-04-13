<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <!-- <p class="text-secondary">Perintah Kerja di Hari Libur</p> -->
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
                <?php
                if (isset($job_id)) { ?>
                    <input type="hidden" value="<?= $job_id ?>" id="jc_job_id">
                <?php
                    }
                ?>
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
                            <i class="bi bi-person-workspace h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List <?= $pageTitle ?></h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_jc" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Status</th>
                                    <th>Cover Letter</th>
                                    <th>Company</th>
                                    <th>Job Category</th>
                                    <th>Job Title</th>
                                    <th>Role</th>
                                    <th>Candidate Name</th>
                                    <th>Gender</th>
                                    <th>No Telp</th>
                                    <th>Email</th>
                                    <th>Usia</th>
                                    <th>Domisili</th>
                                    <th>Edu</th>
                                    <th>Jurusan</th>
                                    <th>Tempat Pendidikan</th>
                                    <th>Kerja Terakhir</th>
                                    <th>Tempat Kerja</th>
                                    <th>Masa Kerja</th>
                                    <th>Gaji Diharapkan</th>
                                    <th>Informasi</th>
                                    <th>Bersedia</th>
                                    <th>Apply Date</th>
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
<!-- Modal Cover Letter -->
<div class="modal" id="modal_cover_letter" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cover_leter_title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class=" modal-footer">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Edit Status -->
<div class="modal" id="modal_edit_status" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="cover_leter_title">Edit Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="job_id" readonly>
                <div class="row">
                    <div class="col-4">
                        <label class="form-label required small" for="select_status">Status</label>
                        <div class="input-group mb-3">
                            <select id="select_status" onchange="updateKeterangan()" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;width:100% !important;">
                            </select>
                        </div>
                    </div>
                    <div class="col-8" id="alasan" style="display: none;">
                        <label class="form-label required small" for="select_alasan">Alasan</label>
                        <div class="input-group mb-3">
                            <select id="select_alasan" class="form-control" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;width:1000px;">
                                <option value="" selected disabled>- Alasan -</option>
                                <?php foreach ($alasan as $key => $value) { ?>
                                    <option value="<?= $value->id; ?>"><?= $value->reason; ?></option>
                                <?php } ?>
                            </select>                            
                        </div>
                    </div>
                </div>
                <!-- Interview HR Fields (visible when status = 10) -->
                <div id="interview_hr_fields" style="display: none;">
                    <hr class="my-2">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label required small">Pilih Tanggal</label>
                            <input type="date" id="date_interview_hr" class="form-control" min="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label required small">Jam Yang Tersedia</label>
                            <div id="time_slots" class="d-flex flex-wrap gap-2 mt-1">
                                <?php
                                $slots = ['10:00','10:30','11:00','11:30','13:00','13:30','14:00'];
                                foreach ($slots as $slot) { ?>
                                    <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 btn-time-slot" data-time="<?= $slot ?>"><?= $slot ?></button>
                                <?php } ?>
                            </div>
                            <input type="hidden" id="time_interview_hr">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="form-label required small" for="zoom_link">Zoom Link</label>
                            <input type="url" id="zoom_link" class="form-control" placeholder="https://zoom.us/j/...">
                        </div>
                    </div>
                </div>
            </div>
            <div class=" modal-footer">
                <button type="button" class="btn btn-primary me-2" onclick="save_status()" id="btn_save_status">Simpan</button>
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>