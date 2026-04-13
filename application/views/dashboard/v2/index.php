<main class="main mainheight">
    <div class="w-100 py-1 py-md-1 py-lg-1 position-relative bg-theme z-index-0">
        <div class="coverimg w-100 h-100 position-absolute top-0 start-0 opacity-3 z-index-0">
            <img src="<?= base_url(); ?>assets/img/bg-10.jpg" class="" />
        </div>
        <div class="container py-1 py-lg-1 my-lg-5 z-index-1 position-relative">
            <div class="row gx-5 align-items-start">
                <div class="col-12 col-md-12 col-lg-12 position-relative my-4">
                    <div class="row align-items-center mb-4">
                        <div class="col-auto">
                            <i class="bi bi-calendar-event h5 avatar avatar-44 bg-green rounded"></i>
                        </div>
                        <div class="col">
                            <h6>Total Days</h6>
                            <p class="text-muted small">Total Working days & past</p>
                        </div>
                        <div class="col-12 col-sm-8">
                            <div class="row mt-3">
                                <?php $allowed_akses = ['2063', '1', '979'];
                                $class_none = "d-none";
                                $user_id = $this->session->userdata("user_id");
                                if (in_array($user_id, $allowed_akses)) {
                                    $class_none = "";
                                } ?>
                                <div class="col-12 col-md-3 col-lg-3 mr-1 ml-1 mb-1">
                                    <label class="<?= $class_none; ?>">Employee Name</label>
                                    <select name="employee_id" id="employee_id" class="wide text-dark <?= $class_none; ?>" style="color: black;">
                                    </select>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3 mr-1 ml-1 mb-1">
                                    <label>Month</label>
                                    <select name="month" id="month" class="wide text-dark" style="color: black;">
                                        <option value="01" <?= date("m") == '01' ? 'selected' : ''; ?>>Januari</option>
                                        <option value="02" <?= date("m") == '02' ? 'selected' : ''; ?>>Februari</option>
                                        <option value="03" <?= date("m") == '03' ? 'selected' : ''; ?>>Maret</option>
                                        <option value="04" <?= date("m") == '04' ? 'selected' : ''; ?>>April</option>
                                        <option value="05" <?= date("m") == '05' ? 'selected' : ''; ?>>Mei</option>
                                        <option value="06" <?= date("m") == '06' ? 'selected' : ''; ?>>Juni</option>
                                        <option value="07" <?= date("m") == '07' ? 'selected' : ''; ?>>Juli</option>
                                        <option value="08" <?= date("m") == '08' ? 'selected' : ''; ?>>Agustus</option>
                                        <option value="09" <?= date("m") == '09' ? 'selected' : ''; ?>>September</option>
                                        <option value="10" <?= date("m") == '10' ? 'selected' : ''; ?>>Oktober</option>
                                        <option value="11" <?= date("m") == '11' ? 'selected' : ''; ?>>November</option>
                                        <option value="12" <?= date("m") == '12' ? 'selected' : ''; ?>>Desember</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-3 col-lg-3 mr-1 ml-1 mb-1">
                                    <label>Year</label>
                                    <select name="year" id="year" class="wide mr-1 ml-1 text-dark" style="color: black;">
                                        <?php for ($i = date("Y"); $i >= 2018; $i--) { ?>
                                            <option value="<?= $i ?>" <?= $this->input->get('year') ? ($this->input->get('year') == $i ? 'selected' : '') : '' ?>><?= $i ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-12 col-md-2 col-lg-2 mr-1 ml-1 mb-1">
                                    <label>&nbsp;</label>
                                    <button class="button-4 w-100" type="button" id="filter" onclick="filter_detail()" style="height: 38px;"><i class="fa fa-search"></i> Show</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center align-items-center">
                        <div class="col-4 col-md">
                            <p class="text-muted small">Total</p>
                            <h3 class="mb-0" id="harus_hadir">-</h3>
                        </div>
                        <div class="col-4 col-md border-start">
                            <p class="text-muted small" data-bs-toggle="tooltip" data-bs-placement="top" title="Click here to see details...">Presence</p>
                            <a role="button" data-bs-toggle="modal" data-bs-target="#modal_detail_absen">
                                <u>
                                    <h3 class="mb-0" id="present">-</h3>
                                </u>
                            </a>
                        </div>
                        <div class="col-4 col-md border-start">
                            <p class="text-muted small">Absence</p>
                            <h3 class="mb-0" id="bolos">-</h3>
                        </div>
                        <div class="col-4 col-md border-start">
                            <p class="text-muted small">Leave</p>
                            <h3 class="mb-0" id="leave">-</h3>
                        </div>
                        <div class="col-4 col-md border-start">
                            <p class="text-muted small">Warning Lock</p>
                            <h3 class="mb-0" id="warning">-</h3>
                        </div>
                        <div class="col-4 col-md border-start">
                            <p class="text-muted small">Late</p>
                            <h3 class="mb-0" id="late">-</h3>
                        </div>
                    </div>
                    <div class="row text-center align-items-center mt-5">
                        <div class="col-4 col-md">
                            <p class="text-muted small">Kehadiran</p>
                            <h3 class="mb-0"><span id="kehadiran"></span>%</h3>
                        </div>
                        <div class="col-4 col-md border-start">
                            <p class="text-muted small">kedisiplinan</p>
                            <h3 class="mb-0"><span id="kedisiplinan"></span>%</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card rounded-0 border-0">
        <!-- <figure class="coverimg w-100 mb-0 position-relative bg-white" style="height: 50px;">
            <div class="position-absolute bottom-0 end-0 m-3">
                <button class="btn btn-light"><i class="bi bi-camera"></i> Change Cover</button>
            </div>
            <img src="<?= base_url(); ?>assets/img/trusmi-group-banner.jpg" class="img-fluid" alt="" />
        </figure> -->
        <div class="card-body mt-5">
            <div class="container px-0">
                <div class="row align-items-start">
                    <div class="col-sm-12 col-md-4 col-lg-2 position-relative">
                        <figure class="avatar avatar-160 coverimg rounded-circle top-80 shadow-md border-3 border-light">
                            <img src="http://trusmiverse.com/hr/uploads/profile/<?= $this->session->userdata('profile_picture'); ?>" alt="" />
                        </figure>
                        <div class="position-absolute bottom-0 end-0 z-index-1 me-3 mb-1 h-auto">
                            <button class="btn btn-theme btn-44 shadow-sm rounded-circle"><i class="bi bi-camera"></i></button>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 pt-3">
                        <p class="text-secondary mb-0"><i class="bi bi-buildings me-1"></i> <span id="d_company"></span> </p>
                        <h2 id="d_employee_name"> <span class="badge bg-green rounded vm fw-normal fs-12"><i class="bi bi-check-circle me-1"></i>Active</span></h2>
                        <p class="text-secondary mb-3"><i class="bi bi-geo-alt me-1"></i> <span id="d_jabatan"></span> </p>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-6 text-center text-lg-end py-3 align-self-center">
                        <a class="button-4 m-1" href="<?= base_url(); ?>hr/rekap_absen"><i class="bi bi-arrow-up-right-square vm me-2"></i> Attendance Sheet</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-2 mt-2">
        <div class="row mb-4 py-2">
            <div class="col text-center">
                <h4>The sort <span class="text-gradient">summary</span> may help you</h4>
                <p class="text-secondary">Keep yourself updated, No matter how much workload is.</p>
            </div>
        </div>
    </div>

    <div class="container mb-4 mt-2">
        <nav class="nav nav-pills flex-column flex-sm-row">
            <a class="flex-sm-fill text-sm-center nav-link active-4" aria-current="page" role="button" id="btn_personal_details">Personal Details</a>
            <!-- <a class="flex-sm-fill text-sm-center nav-link" role="button" id="btn_manage_leave">Manage Leave</a> -->
            <a class="flex-sm-fill text-sm-center nav-link" role="button" id="btn_history_warning">History Warning Lock</a>
            <a class="flex-sm-fill text-sm-center nav-link" role="button" id="btn_e_training">E - Training</a>
        </nav>
    </div>

    <div class="container mt-2" id="container_personal_details">
        <!-- intro -->
        <div class="row">
            <div class="col-12 col-md-12 col-lg-8 mb-2">
                <div class="card border-0">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-person-circle h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                            </div>
                            <div class="col ps-0">
                                <h6 class="fw-medium mb-0">Personal Details</h6>
                            </div>
                            <div class="col-auto">
                                <button class="button-4" id="btn_edit_personal_detail"><i class="bi bi-pencil me-1 vm"></i> <span class="d-inline">Edit</span> <span class="d-none d-md-inline">Profile</span></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body gallery pb-0">
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-person-badge h5 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <p class="text-secondary small mb-1">Full Name</p>
                                <p id="p_fullname">-</p>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-buildings h5 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <p class="text-secondary small mb-1">Company</p>
                                <p id="p_company_name">-</p>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-houses h5 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <p class="text-secondary small mb-1">Department</p>
                                <p id="p_department_name">-</p>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-person-workspace h5 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <p class="text-secondary small mb-1">Designation</p>
                                <p id="p_designation_name">-</p>
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-credit-card-2-front h5 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <p class="text-secondary small mb-1">Employee ID</p>
                                <p id="p_employee_id">-</p>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-person-lock h5 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <p class="text-secondary small mb-1">Username</p>
                                <p id="p_username">-</p>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-calendar-date h5 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <p class="text-secondary small mb-1">Date Of Joining</p>
                                <p id="p_date_of_joining">-</p>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-telephone h5 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <p class="text-secondary small mb-1">Phone</p>
                                <p id="p_contact_no">-</p>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-envelope h5 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <p class="text-secondary small mb-1">Email Address</p>
                                <p id="p_email">-</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4 mb-2">
                <div class="card border-0 bg-gradient-theme-light theme-blue">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="fw-medium">
                                    <i class="bi bi-cash h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                                    Rekening
                                </h6>
                            </div>
                            <div class="col-auto">
                                <button class="button-4" id="btn-update-rekening"><i class="bi bi-pencil me-1 vm"></i> <span class="d-inline">Edit</span> <span class="d-none d-md-inline">Rekening</span></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="swiper-container creditcards">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="card border-0 mb-2" style="width: 300px;" id="atm-card">
                                        <div class="card-body">
                                            <div class="row align-items-center mb-4">
                                                <div class="col-auto align-self-center">
                                                    <i>ATM</i>
                                                </div>
                                                <div class="col text-end">
                                                    <p class="size-12">
                                                        <span class="text-muted small">Bank</span><br>
                                                        <span class="" id="p_bank_name">Belum Registrasi</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <p class="fw-medium h6 mb-3" id="p_account_number">

                                            </p>
                                            <div class="row">
                                                <div class="col-auto size-12">
                                                    <p class="mb-0 text-muted small">Created At</p>
                                                    <p id="p_created_at">Belum Registrasi</p>
                                                </div>
                                                <div class="col text-end size-12">
                                                    <p class="mb-0 text-muted small">Atas Nama</p>
                                                    <p id="p_account_title">Belum Registrasi</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container mt-2" id="container_manage_leave">
        <div class="row d-none">
            <div class="col-12 col-md-4 col-lg-4 col-xxl-3 mb-2">
                <div class="card border-0 bg-gradient-theme-light theme-blue">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="fw-medium">
                                    <i class="bi bi-door-open h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                                    Leave Categories
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush bg-none" id="content_leave_categories">
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-8 col-xxl-9 mb-2">
                <div class="card border-0 bg-gradient-theme-light theme-blue">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-12 col-lg-3 mb-2">
                                <h6 class="fw-medium">
                                    <i class="bi bi-box-arrow-right h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                                    Leave
                                </h6>
                            </div>
                            <div class="col-12 col-md-4 col-lg-3 mr-1 ml-1 mb-1">
                                <label>Month</label>
                                <select name="month-leave" id="month-leave" class="wide text-dark">
                                    <option value="01" <?= date("m") == '01' ? 'selected' : ''; ?>>Januari</option>
                                    <option value="02" <?= date("m") == '02' ? 'selected' : ''; ?>>Februari</option>
                                    <option value="03" <?= date("m") == '03' ? 'selected' : ''; ?>>Maret</option>
                                    <option value="04" <?= date("m") == '04' ? 'selected' : ''; ?>>April</option>
                                    <option value="05" <?= date("m") == '05' ? 'selected' : ''; ?>>Mei</option>
                                    <option value="06" <?= date("m") == '06' ? 'selected' : ''; ?>>Juni</option>
                                    <option value="07" <?= date("m") == '07' ? 'selected' : ''; ?>>Juli</option>
                                    <option value="08" <?= date("m") == '08' ? 'selected' : ''; ?>>Agustus</option>
                                    <option value="09" <?= date("m") == '09' ? 'selected' : ''; ?>>September</option>
                                    <option value="10" <?= date("m") == '10' ? 'selected' : ''; ?>>Oktober</option>
                                    <option value="11" <?= date("m") == '11' ? 'selected' : ''; ?>>November</option>
                                    <option value="12" <?= date("m") == '12' ? 'selected' : ''; ?>>Desember</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4 col-lg-3 mr-1 ml-1 mb-1">
                                <label>Year</label>
                                <select name="year-leave" id="year-leave" class="wide mr-1 ml-1 text-dark">
                                    <?php for ($i = date("Y"); $i >= 2018; $i--) { ?>
                                        <option value="<?= $i ?>" <?= $this->input->get('year') ? ($this->input->get('year') == $i ? 'selected' : '') : '' ?>><?= $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-4 col-lg-3 mr-1 ml-1 mb-1">
                                <label>&nbsp;</label>
                                <div class="d-flex justify-content-around">
                                    <button class="button-4-icon col-5 ml-1 mr-1" type="button" id="filter-leave" onclick="filter_manage_leave()" style="height: 38px;"><i class="fa fa-search"></i></button>
                                    <button class="button-4-icon col-5 ml-1 mr-1" type="button" id="add-leave" onclick="add_manage_leave()" style="height: 38px;"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush bg-none" id="content_manage_leave">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container mt-2" id="container_history_warning">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 col-xxl-12 mb-2">
                <div class="card border-0 bg-gradient-theme-light theme-blue">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-12 col-lg-3 mb-2">
                                <h6 class="fw-medium">
                                    <i class="bi bi-exclamation-diamond-fill h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                                    History Warning Lock
                                </h6>
                            </div>
                            <div class="col-12 col-md-4 col-lg-3 mr-1 ml-1 mb-1">
                                <label>Bulan</label>
                                <select name="month-history" id="month-history" class="wide text-dark">
                                    <option value="01" <?= date("m") == '01' ? 'selected' : ''; ?>>Januari</option>
                                    <option value="02" <?= date("m") == '02' ? 'selected' : ''; ?>>Februari</option>
                                    <option value="03" <?= date("m") == '03' ? 'selected' : ''; ?>>Maret</option>
                                    <option value="04" <?= date("m") == '04' ? 'selected' : ''; ?>>April</option>
                                    <option value="05" <?= date("m") == '05' ? 'selected' : ''; ?>>Mei</option>
                                    <option value="06" <?= date("m") == '06' ? 'selected' : ''; ?>>Juni</option>
                                    <option value="07" <?= date("m") == '07' ? 'selected' : ''; ?>>Juli</option>
                                    <option value="08" <?= date("m") == '08' ? 'selected' : ''; ?>>Agustus</option>
                                    <option value="09" <?= date("m") == '09' ? 'selected' : ''; ?>>September</option>
                                    <option value="10" <?= date("m") == '10' ? 'selected' : ''; ?>>Oktober</option>
                                    <option value="11" <?= date("m") == '11' ? 'selected' : ''; ?>>November</option>
                                    <option value="12" <?= date("m") == '12' ? 'selected' : ''; ?>>Desember</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4 col-lg-3 mr-1 ml-1 mb-1">
                                <label>Tahun</label>
                                <select name="year-history" id="year-history" class="wide mr-1 ml-1 text-dark">
                                    <?php for ($i = date("Y"); $i >= 2018; $i--) { ?>
                                        <option value="<?= $i ?>" <?= $this->input->get('year') ? ($this->input->get('year') == $i ? 'selected' : '') : '' ?>><?= $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-4 col-lg-3 mr-1 ml-1 mb-1">
                                <label>&nbsp;</label>
                                <button class="button-4 w-100" type="button" id="filter-history" onclick="filter_history_warning()" style="height: 38px;"><i class="fa fa-search"></i> Filter</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush bg-none" id="content_history_warning">
                            <!-- content history warning -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container mt-2" id="container_e_training">
        <div class="row mb-4 py-2">
            <div class="col text-center">
                <h4>Learning is life, <span class="text-gradient">Explore more</span> lessons you have learn't</h4>
                <p class="text-secondary">You should learn and explore opportunities. If there is obstacles, try to remove it and improvise.</p>
            </div>
        </div>
        <div class="row" id="content_e_training">

        </div>
    </div>

    <?php $this->load->view('layout/_footer'); ?>
</main>

<!-- Modal -->
<div class="modal fade" id="modal_detail_absen" tabindex="-1" aria-labelledby="modal_detail_absenLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_detail_absenLabel">Detail Absen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 mr-1 ml-1 mb-1">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar"></i></span>
                                        <div class="form-floating">
                                            <select name="month" id="month" class="form-control">
                                                <option name="month" id="month" value="01">Januari</option>
                                                <option name="month" id="month" value="02">Februari</option>
                                                <option name="month" id="month" value="03">Maret</option>
                                                <option name="month" id="month" value="04">April</option>
                                                <option name="month" id="month" value="05">Mei</option>
                                                <option name="month" id="month" value="06">Juni</option>
                                                <option name="month" id="month" value="07">Juli</option>
                                                <option name="month" id="month" value="08">Agustus</option>
                                                <option name="month" id="month" value="09">September</option>
                                                <option name="month" id="month" value="10">Oktober</option>
                                                <option name="month" id="month" value="11">November</option>
                                                <option name="month" id="month" value="12">Desember</option>
                                            </select>
                                            <label>Bulan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4 mr-1 ml-1 mb-1">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar"></i></span>
                                        <div class="form-floating">
                                            <select name="year" id="year" class="form-control col-12 col-md-4 col-sm-4 mr-1 ml-1">
                                                <?php for ($i = date("Y"); $i >= 2018; $i--) { ?>
                                                    <option name="year" id="year" value="<?= $i ?>" <?= $this->input->get('year') ? ($this->input->get('year') == $i ? 'selected' : '') : '' ?>><?= $i ?></option>
                                                <?php } ?>
                                            </select>
                                            <label>Tahun</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-2 col-lg-2 mr-1 ml-1 mb-1">
                                <div style="display: flex;align-items: center;justify-content: center;height: 100%;width: 100%;">
                                    <button class="btn col-12 btn-primary" type="button" id="filter" onclick="filter_detail()" style="font-size: 12px;"><i class="fa fa-search"></i> Show</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div id="body_detail_absen">
                    <div class="card mb-1 mt-1">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="circle-small">
                                        <div id="circleprogressblue"></div>
                                        <div class="avatar h5 bg-light-blue rounded-circle">
                                            <i class="bi bi-calendar2-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <p class="text-dark small mb-1 col-12 col-md-6" style="font-weight: bold;">Tgl</p>
                                        <p class="text-dark small mb-1 col-12 col-md-6">Shift : <span>In</span> s/d <span>Out</span> </p>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                            <p class="text-secondary small mb-1">Photo In</p>
                                            <h5 class="fw-medium">-<small></small></h5>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                            <p class="text-secondary small mb-1">Clock In</p>
                                            <h5 class="fw-medium">-<small></small></h5>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                            <p class="text-secondary small mb-1">Photo Out</p>
                                            <h5 class="fw-medium">-<small></small></h5>
                                        </div>
                                        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                            <p class="text-secondary small mb-1">Clock Out</p>
                                            <h5 class="fw-medium">-<small></small></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>