<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme py-4">
                <div class="col text-center">
                    <h4><span class="text-gradient">The sort summary may help you</span></h4>
                    <p class="text-secondary">Keep yourself updated, no matter how much workload is.</p>
                </div>
            </nav>
        </div>
        <div class="row mt-3">
            <div class="col-12 col-md-12 col-lg-4 col-xl column-set mb-2">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="avatar avatar-40 rounded bg-secondary text-white">
                                    <i class="bi bi-people h5"></i>
                                </div>
                            </div>
                            <div class="col">
                                <p class="small text-secondary mb-1">Total Karyawan Training Onboarding</p>
                                <h6 class="fw-medium mb-0">36 People</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-4 col-xl column-set mb-2">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="avatar avatar-40 rounded bg-yellow text-white">
                                    <i class="bi bi-clock h5"></i>
                                </div>
                            </div>
                            <div class="col">
                                <p class="small text-secondary mb-1">Karyawan Selesai Training Onboarding</p>
                                <h6 class="fw-medium mb-0">36 People</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-4 col-xl column-set mb-2">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="avatar avatar-40 rounded bg-green text-white">
                                    <i class="bi bi-check2-square h5"></i>
                                </div>
                            </div>
                            <div class="col">
                                <p class="small text-secondary mb-1">Butuh Validasi</p>
                                <h6 class="fw-medium mb-0">36 People</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-person-badge h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Karyawan Onboarding</h6>
                        </div>
                        
                        <div class="col-auto ms-auto ps-0">
                            <div class="d-flex justify-content-between">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle mb-2"
                                        data-bs-toggle="dropdown" aria-expanded="true">
                                        <i class="bi bi-at"></i> Divisi
                                    </button>
                                    <ul class="dropdown-menu"
                                        style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 47.7778px);"
                                        data-popper-placement="bottom-end">
                                        <li><button class="dropdown-item" onclick="load_data('comben')">Comben</button>
                                        </li>
                                        <li><button class="dropdown-item" onclick="load_data('hr')">HR</button></li>
                                        <li><button class="dropdown-item" onclick="load_data('ga')">GA</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex justify-content-between">
                                <div class="input-group input-group-md reportrange">
                                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;">
                                    <input type="hidden" name="startdate" value="" id="start" />
                                    <input type="hidden" name="enddate" value="" id="end" />
                                    <span class="input-group-text text-secondary bg-none" id="btn_filter"><i
                                            class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="data_onboarding" class="table nowrap table-striped" width="100%">
                            <thead>
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



<!-- Modal untuk pratinjau dokumen -->
<div class="modal fade" id="modal_validasi" aria-labelledby="previewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Validasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_validasi">
                <div class="modal-body">
                    <input type="hidden" name="divisi" value="">
                    <input type="hidden" name="id_item" value="">
                    <input type="hidden" name="user_id" value="">
                    <div class="form-group">
                        <label for="">Note</label>
                        <textarea name="note" class="form-control border-custom" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary mx-1"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-md btn-primary mx-1"><i class="fa fa-check-circle"></i>
                        Validasi
                    </button>
                </div>
            </form>
            <form id="form_validasi_ga" style="display:none">
                <div class="modal-body">
                    <input type="hidden" name="divisi" value="">
                    <input type="hidden" name="id_item" value="">
                    <input type="hidden" name="user_id" value="">
                    <div class="form-group mb-2">
                        <label for="">Status</label>
                        <select name="status" class="form-control border-custom">
                            <option value="">-- Pilih --</option>
                            <option value="1">Approve</option>
                            <option value="2">Reject</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Note</label>
                        <textarea name="note" class="form-control border-custom" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary mx-1"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-md btn-primary mx-1"><i class="fa fa-check-circle"></i>
                        Validasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_detail" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0">Detail Onboarding</h6>
                    <p class="text-secondary small" id="detail"></p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button"
                            aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card profile-card p-3">
                            <div class="card-body text-center">
                                <img src="https://i.ibb.co/6P2fmnn/profile-image.jpg" id="detail_foto_profile" alt="Profile Picture"
                                    class="rounded-circle profile-pic mb-3">
                                <h5 class="card-title mb-0" id="detail_nama">Fery Afriansyah</h5>
                                <p class="text-muted" id="detail_designation">UI/UX Designer</p>
                            </div>
                            <hr>
                            <div class="px-3">
                                <h6 class="text-muted">Informasi Hiring</h6>
                                <ul class="list-unstyled">
                                    <li class="d-flex align-items-center mb-2">
                                        <i class="bi bi-calendar-event me-3 fs-5 text-primary"></i>
                                        <div>
                                            <small class="text-muted d-block">Tanggal mulai bekerja</small>
                                            <strong id="detail_date_of_join">05-08-2025</strong>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center mb-2">
                                        <i class="bi bi-clipboard-check me-3 fs-5 text-primary"></i>
                                        <div>
                                            <small class="text-muted d-block">Status Onboarding</small>
                                            <strong id="detail_current_day">Day 1</strong>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center mb-3">
                                        <i class="bi bi-geo-alt-fill me-3 fs-5 text-primary"></i>
                                        <div>
                                            <small class="text-muted d-block">Tempat Kerja</small>
                                            <strong id="detail_location">JMP, Tuparev</strong>
                                        </div>
                                    </li>
                                </ul>

                                <h6 class="text-muted">Trainer</h6>
                                <div class="d-flex align-items-center">
                                    <img src="https://i.ibb.co/F803vL6/trainer-avatar.jpg" id="detail_pic_foto" alt="Trainer"
                                        class="rounded-circle" width="40" height="40">
                                    <div class="ms-2">
                                        <strong class="d-block" id="detail_pic_nama">Anggi Supratna</strong>
                                        <small class="text-muted">PIC Recruitment</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9 mt-4 mt-lg-0">
                        <div class="card content-card p-4">
                            <h4 class="mb-1">Onboarding Journey</h4>
                            <!-- <p class="text-muted">Tasklist Onboaring</p> -->

                            <!-- <div class="border rounded p-3 mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-0"><strong>Fery Afriansyah</strong></p>
                                        <small class="text-muted">UI/UX • Hari ke-47</small>
                                    </div>
                                    <div class="text-end">
                                        <div class="progress" style="width: 100px; height: 6px; display: inline-block;">
                                            <div class="progress-bar" role="progressbar" style="width: 75%;"
                                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small class="ms-2">75% On Track</small>
                                    </div>
                                </div>
                                <div class="stepper-wrapper my-4">
                                    <div class="step-item completed">
                                        <div class="step-circle"><i class="bi bi-check"></i></div>
                                        <div class="step-title">Day 1</div>
                                    </div>
                                    <div class="step-item active">
                                        <div class="step-circle"></div>
                                        <div class="step-title">Day 2</div>
                                    </div>
                                    <div class="step-item">
                                        <div class="step-circle"></div>
                                        <div class="step-title">Day 3</div>
                                    </div>
                                    <div class="step-item">
                                        <div class="step-circle"></div>
                                        <div class="step-title">Day 50</div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center text-muted">
                                    <small><i class="bi bi-flag-fill me-2 text-primary"></i>Milestone berikutnya:
                                        Peraturan Perusahaan</small>
                                    <small>3 Hari lagi</small>
                                </div>
                            </div> -->

                            <ul class="nav nav-tabs" id="onboardingTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="day1-tab" data-bs-toggle="tab"
                                        data-bs-target="#day1-pane" type="button" role="tab">Day 1</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="day2-tab" data-bs-toggle="tab"
                                        data-bs-target="#day2-pane" type="button" role="tab">Day 2</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="day3-tab" data-bs-toggle="tab"
                                        data-bs-target="#day3-pane" type="button" role="tab">Day 3</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="day50-tab" data-bs-toggle="tab"
                                        data-bs-target="#day50-pane" type="button" role="tab">Day 50</button>
                                </li>
                            </ul>

                            <div class="tab-content pt-4" id="onboardingTabContent">
                                <div class="tab-pane fade show active" id="day1-pane" role="tabpanel">
                                    <h5>Task Onboarding</h5>
                                    <div class="list-group list-group-flush">
                                        
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="day2-pane" role="tabpanel">
                                    <h5>Task Onboarding Day 2</h5>
                                    <div class="list-group list-group-flush">
                                        
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="day3-pane" role="tabpanel">
                                    <h5>Task Onboarding Day 3</h5>
                                    <div class="list-group list-group-flush">
                                        
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="day50-pane" role="tabpanel">
                                    <h5>Task Onboarding Day 50</h5>
                                    <div class="list-group list-group-flush">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;"
                    data-bs-dismiss="modal">Cancel</button>
                <!-- <button type="button" class="btn btn-md btn-primary" id="btn_save" onclick="save()">Update
                        <i class="bi bi-card-checklist"></i></button> -->
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
                <button type="button" class="btn btn-md btn-outline-secondary mx-1"
                    data-bs-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>