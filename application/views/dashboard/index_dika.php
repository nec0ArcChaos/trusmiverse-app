<main class="main mainheight">
    <div class="container-fluid">
        <div class="row bg-gradient-theme-light">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>">My Dashboard</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="w-100 py-1 py-md-1 py-lg-1 position-relative bg-theme z-index-0">
        <div class="coverimg w-100 h-100 position-absolute top-0 start-0 opacity-3 z-index-0" id="coverimg_div">
            <img src="<?= base_url(); ?>assets/img/<?= $personal_info->profile_background; ?>" class="" id="coverimg" />
        </div>
        <div class="text-end top-0 end-0 m-3">
            <a href="<?= base_url(); ?>theme" class="btn btn-light"><i class="bi bi-palette text-gradient btn-link"> </i> &nbsp;&nbsp;<span class="text-gradient">Theme</span></a>
            <button class="btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#modal_change_profile_background"><i class="bi bi-camera"> </i> &nbsp;&nbsp;Change Cover</button>
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
                        <div class="col-12 col-sm-9">
                            <div class="row mt-3">
                                <?php $allowed_akses = ['2063', '1', '979'];
                                $class_none = "d-none";
                                $col = "col-lg-3 col-md-3"; // addnew
                                $user_id = $this->session->userdata("user_id");
                                if (in_array($user_id, $allowed_akses)) {
                                    $class_none = "";
                                    $col = "col-lg-2 col-md-2"; // addnew
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
                                <div class="col-12 <?= $col ?> mr-1 ml-1 mb-1">
                                    <label>Year</label>
                                    <select name="year" id="year" class="wide mr-1 ml-1 text-dark" style="color: black;">
                                        <?php for ($i = date("Y") + 1; $i >= 2018; $i--) { ?>
                                            <option value="<?= $i ?>" <?= date("Y") ? (date("Y") == $i ? 'selected' : '') : '' ?>><?= $i ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <!-- addnew -->
                                <?php //if (in_array($user_id, $allowed_akses)) { ?> 
                                <div class="col-12 col-md-2 col-lg-2 mr-1 ml-1 mb-1 <?= $class_none; ?>">
                                    <label class="<?= $class_none; ?>">Cutoff</label>
                                    <select name="cutoff" id="cutoff" class="wide mr-1 ml-1 text-dark <?= $class_none; ?>" style="color: black;">
                                        <option value="1" <?= $this->session->userdata('cutoff') == '1' ? 'selected' : ''; ?>>21-20</option>
                                        <option value="2" <?= $this->session->userdata('cutoff') == '2' ? 'selected' : ''; ?>>16-15</option>
                                        <option value="3" <?= $this->session->userdata('cutoff') == '3' ? 'selected' : ''; ?>>01-<?= date("t") ?></option>
                                    </select>
                                </div>
                                <?php //} ?>

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
                    <div class="row text-center align-items-center mt-5 mb-5">
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
    <div class="container mt-4 mt-lg-0">
        <div class="row mb-4 align-items-start">
            <div class="col-auto position-relative">
                <figure class="avatar avatar-160 coverimg rounded-circle top-80 shadow-md border-3 border-light">
                    <img src="https://trusmiverse.com/hr/uploads/profile/<?= $personal_info->profile_picture; ?>" alt="" />
                </figure>
                <div class="text-end bottom-0 end-0 z-index-1 me-3 mb-1 h-auto">
                    <button class="btn btn-theme btn-44 shadow-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#modal_change_profile_picture"><i class="bi bi-camera"></i></button>
                </div>
            </div>
            <div class="col-12 col-md pt-2">
                <h2 class="mb-1"><?= $this->session->userdata("nama"); ?> <span class="badge bg-theme rounded vm fw-normal fs-12"><i class="bi bi-check-circle me-1"></i>Online</span></h2>
                <p><span class="text-secondary"><i class="bi bi-briefcase me-1"></i><?= $personal_info->department_name; ?>,</span> <?= $personal_info->company_name; ?></p>
                <span class="badge bg-light-theme text-theme">
                    <span class="avatar avatar-20 rounded-circle me-1 vm"><i class="bi bi-telephone"></i></span> <?= $personal_info->contact_no; ?>
                </span>
                <span class="badge bg-light-theme text-theme">
                    <span class="avatar avatar-20 rounded-circle me-1 vm"><i class="bi bi-envelope"></i></span> <?= $personal_info->email; ?>
                </span>
                <a role="button" class="badge bg-light-yellow text-dark" data-bs-toggle="modal" data-bs-target="#modal_change_ttd">
                    <span class="avatar avatar-20 rounded-circle me-1 vm"><i class="fa-solid fa-signature"></i></span> Upload Tanda Tangan
                </a>
            </div>
            <div class="col-12 col-xl-auto py-3">
                <div>
                    <!-- <button type="button" class="btn btn-outline-theme me-2 text-center d-none d-sm-inline-block" data-bs-toggle="popover" data-bs-title="Notification" data-bs-content="Sedang develop">
                        <span class="bi bi-bell-fill position-relative">
                            <span class="badge position-absolute top-0 start-100 translate-middle bg-danger textw-white rounded">
                                <span class="fs-10">3</span> <span class="visually-hidden">New alerts</span>
                            </span>
                        </span>
                    </button> -->

                    <a href="<?= base_url(); ?>hr/rekap_absen" class="btn btn-outline-theme me-2"><i class="bi bi-calendar vm me-2"></i> Rekap Absen</a>
                    <a href="<?= base_url(); ?>leave" class="btn btn-theme"><i class="bi bi-person-plus vm me-2"></i> Izin / Cuti</a>
                </div>
                <br>
            </div>
        </div>
        <!-- <div class="card rounded-0 border-0">
            <div class="card-body mt-5">
                <div class="container px-0">
                    <div class="row align-items-start">
                        <div class="col-sm-12 col-md-4 col-lg-2 position-relative">
                            <figure class="avatar avatar-160 coverimg rounded-circle top-80 shadow-md border-3 border-light">
                                <img src="https://trusmiverse.com/hr/uploads/profile/<?= $this->session->userdata('profile_picture'); ?>" alt="" />
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
        </div> -->
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





        <!-- left card -->
        <div class="row">
            <div class="col-12 col-md-12 col-lg-8 mb-2">
                <!-- personal info -->
                <div class="card border-0 mb-4 bg-gradient-theme-light">
                    <div class="card-header bg-gradient-theme-light">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-person-circle h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                            </div>
                            <div class="col ps-0">
                                <h6 class="fw-medium mb-0">Personal Info</h6>
                                <p class="text-secondary small">Tentang Anda</p>
                            </div>
                            <div class="col-auto">
                                <a href="javascrip:void(0)" class="btn btn-link btn-square text-secondary" data-bs-toggle="modal" data-bs-target="#modal_change_personal_info">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="javascrip:void(0)" class="btn btn-link btn-square text-secondary" data-bs-toggle="modal" data-bs-target="#modal_change_password">
                                    <i class="bi bi-person-lock"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-person-fill-check h5 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <p class="text-secondary small mb-1">NIK</p>
                                <p><?= $personal_info->employee_id; ?></p>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-telephone h5 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <p class="text-secondary small mb-1">Phone</p>
                                <p><?= $personal_info->contact_no; ?></p>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-envelope h5 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <p class="text-secondary small mb-1">Email Address</p>
                                <p><?= $personal_info->email; ?></p>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-calendar2-heart h5 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <p class="text-secondary small mb-1">Birthday</p>
                                <p><?= $personal_info->date_of_birth_text; ?></p>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-gender-ambiguous h5 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <p class="text-secondary small mb-1">Genders</p>
                                <p><?= $personal_info->gender; ?></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4 mb-2">
                <!-- divisi -->
                <div class="card border-0 bg-gradient-theme-light mb-4">
                    <div class="card-body bg-gradient-theme-light">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <figure class="avatar avatar-40 rounded-circle bg-light-theme text-theme">
                                    <i class="bi bi-star vm"></i>
                                </figure>
                            </div>
                            <div class="col ps-0">
                                <h6 class="mb-0"><?= $personal_info->department_name; ?> </h6>
                                <p class="fw-normal"><?= $personal_info->designation_name; ?> </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class=" row align-items-center">
                            <div class="col-auto">
                                <p class="mb-0"><?= $personal_info->date_of_joining; ?></p>
                            </div>
                            <div class="col text-end">
                                <p class="small text-muted"><?= $personal_info->masa_kerja; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- rekening section -->
                <div class="card bg-gradient-theme-light border-0 mb-4">
                    <div class="card-header bg-gradient-theme-light">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-cash h5 avatar avatar-40 bg-light-theme rounded"></i>
                            </div>
                            <div class="col">
                                <h6 class="fw-medium mb-0">Rekening Payroll</h6>
                                <p class="small text-secondary">Kartu Atm</p>
                            </div>
                            <div class="col-auto">
                                <a href="javascrip:void(0)" class="btn btn-link btn-square text-secondary" data-bs-toggle="modal" data-bs-target="#modal_change_rekening">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="javascrip:void(0)" class="btn btn-link btn-square text-secondary" data-bs-toggle="modal" data-bs-target="#modal_change_pin_slip">
                                    <i class="bi bi-person-lock"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div class="swiper-container creditcardsvertical swiper-cards swiper-3d swiper-initialized swiper-horizontal swiper-pointer-events">
                            <div class="swiper-wrapper" id="swiper-wrapper-a9fe8210cf8c8461" aria-live="polite" style="cursor: grab;">
                                <div class="swiper-slide swiper-slide-visible swiper-slide-active" role="group" aria-label="1 / 3" style="width: 300px; z-index: 3; transform: translate3d(0px, 0px, 0px) rotateZ(0deg) scale(1);">
                                    <div class="card border-0 mb-3" id="atm-card">
                                        <div class="card-body">
                                            <div class="row align-items-center mb-4">
                                                <div class="col-auto align-self-center">
                                                    <span>ATM</span>
                                                </div>
                                                <div class="col text-end">
                                                    <p class="size-12">
                                                        <span class="text-muted small" id="p_bank_name">Bank</span><br>
                                                        <!-- <span class="">Kartu ATM</span> -->
                                                    </p>
                                                </div>
                                            </div>
                                            <p class="fw-medium h6 mb-4" id="p_account_number">
                                                Belum mengisi rekening
                                            </p>
                                            <div class="row">
                                                <div class="col-auto size-12">
                                                    <p class="mb-0 text-muted small">Created At</p>
                                                    <p id="p_created_at">-</p>
                                                </div>
                                                <div class="col text-end size-12">
                                                    <p class="mb-0 text-muted small">Card Holder</p>
                                                    <p id="p_account_title">-</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide swiper-slide-next" role="group" aria-label="2 / 3" style="width: 300px; z-index: 2; transform: translate3d(calc(-300px + 7.25%), 0px, -100px) rotateZ(2deg) scale(1);">
                                    <div class="card border-0 mb-3" id="atm-card-2">
                                        <div class="card-body">
                                            <div class="row align-items-center mb-4">
                                                <div class="col-auto align-self-center">
                                                    <img src="<?= base_url(); ?>assets/img/visa.png" alt="">
                                                </div>
                                                <div class="col text-end">
                                                    <p class="size-12">
                                                        <span class="text-muted small">City Bank</span><br>
                                                        <span class="">Credit Card</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <p class="fw-medium h6 mb-4">
                                                000 0000
                                            </p>
                                            <div class="row">
                                                <div class="col-auto size-12">
                                                    <p class="mb-0 text-muted small">Expiry</p>
                                                    <p>09/023</p>
                                                </div>
                                                <div class="col text-end size-12">
                                                    <p class="mb-0 text-muted small">Card Holder</p>
                                                    <p>-</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide-shadow" style="opacity: 1;"></div>
                                </div>
                                <div class="swiper-slide" role="group" aria-label="3 / 3" style="width: 300px; z-index: 1; transform: translate3d(calc(-600px + 13%), 0px, -200px) rotateZ(4deg) scale(1);">
                                    <div class="card border-0 theme-yellow mb-1">
                                        <div class="card-body">
                                            <div class="row align-items-center mb-4">
                                                <div class="col-auto align-self-center">
                                                    <img src="<?= base_url(); ?>assets/img/visa.png" alt="">
                                                </div>
                                                <div class="col text-end">
                                                    <p class="size-12">
                                                        <span class="text-muted small">City Bank</span><br>
                                                        <span class="">Credit Card</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <p class="fw-medium h6 mb-4">
                                                000 0000
                                            </p>
                                            <div class="row">
                                                <div class="col-auto size-12">
                                                    <p class="mb-0 text-muted small">Expiry</p>
                                                    <p>09/023</p>
                                                </div>
                                                <div class="col text-end size-12">
                                                    <p class="mb-0 text-muted small">Card Holder</p>
                                                    <p>-</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide-shadow" style="opacity: 1;"></div>
                                </div>
                            </div>
                            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                        </div>
                    </div>
                </div>
                <!-- /rekening section -->
                <!-- <div class="card border-0 bg-gradient-theme-light theme-blue">
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
                </div> -->
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

<!-- Modal Profile Picture -->
<div class="modal fade" id="modal_change_profile_picture" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-image h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Form Profile Picture</h6>
                        <p class="small text-secondary">Ubah Foto Profil anda</p>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <h6 class="fw-medium mb-2"></h6>
                <div class="row mb-2">
                    <div class="col-12 col-md-12 mb-2">
                        <div class="input-group input-group-md border rounded">
                            <span class="input-group-text text-theme"><i class="bi bi-upload"></i></span>
                            <input class="form-control" type="file" id="u_profile_picture" name="u_profile_picture">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-theme w-100" id="btn_upload_profile_picture">Upload Foto</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal TTD -->
<div class="modal fade" id="modal_change_ttd" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-image h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Form TTD</h6>
                        <p class="small text-secondary">Ubah Tanda Tangan Digital</p>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <h6 class="fw-medium mb-2"></h6>
                <div class="row mb-2">
                    <div class="col-12 text-center">
                        <?php if ($personal_info->ttd != "") { ?>
                            <label for="">Ttd : </label>
                            <img style="height: 150px;" src="https://www.trusmiverse.com/apps/uploads/ttd/<?= $personal_info->ttd; ?>" alt="" srcset="">
                        <?php } else { ?>
                            <p>Belum Ada Ttd</p>
                        <?php } ?>
                    </div>
                    <div class="col-12 col-md-12 mb-2">
                        <div class="input-group input-group-md border rounded">
                            <span class="input-group-text text-theme"><i class="bi bi-upload"></i></span>
                            <input class="form-control" type="file" id="u_ttd" name="u_ttd">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-theme w-100" id="btn_upload_ttd">Upload Foto</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Cover Picture -->
<div class="modal fade" id="modal_change_profile_background" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-image h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Form Profile Background</h6>
                        <p class="small text-secondary">Ubah Foto Latar Belakang Profil</p>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row" id="profile-background">
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-1.jpg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-1.jpg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-1.jpg" alt="" class="w-100" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-2.jpg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-2.jpg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-2.jpg" alt="" class="w-100" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-3.jpg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-3.jpg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-3.jpg" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-4.jpg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-4.jpg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-4.jpg" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-5.jpg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-5.jpg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-5.jpg" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-6.jpg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-6.jpg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-6.jpg" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-7.jpg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-7.jpg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-7.jpg" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-8.jpg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-8.jpg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-8.jpg" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-9.jpg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-9.jpg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-9.jpg" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-10.jpg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-10.jpg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-10.jpg" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-11.jpg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-11.jpg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-11.jpg" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-12.jpg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-12.jpg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-12.jpg" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-13.jpg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-13.jpg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-13.jpg" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-14.jpg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-14.jpg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-14.jpg" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-15.jpg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-15.jpg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-15.jpg" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-16.jpg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-16.jpg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-16.jpg" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-17.jpg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-17.png&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-17.png" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-18.jpg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-18.jpg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-18.jpg" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-19.jpg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-19.jpg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-19.jpg" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-20.jpg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-20.jpg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-20.jpg" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bga-1.avif')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bga-1.avif&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bga-1.avif" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('batik.jpeg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/batik.jpeg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/batik.jpeg" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="select-box text-center mb-2" onclick="temporary_change_profile_background('bg-visi-misi.jpeg')">
                            <div class="avatar avatar-100">
                                <span class="avatar avatar-80 bg-blue coverimg" style="background-image: url(&quot;https://trusmiverse.com/apps/assets/img/bg-visi-misi.jpeg&quot;);">
                                    <img src="https://trusmiverse.com/apps/assets/img/bg-visi-misi.jpeg" alt="" style="display: none;">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-end">
                <input type="hidden" id="u_profile_background" name="u_profile_background" readonly>
                <button type="button" class="btn btn-theme" id="btn_update_profile_background">Terapkan</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal Personal Info -->
<div class="modal fade" id="modal_change_personal_info" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Form Personal Info</h6>
                        <p class="small text-secondary">Ubah Tentang Anda</p>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <h6 class="fw-medium mb-2"></h6>
                <div class="row mb-2">
                    <div class="col-12 col-md-12 mb-2">
                        <div class="input-group input-group-md border rounded">
                            <span class="input-group-text text-theme"><i class="bi bi-telephone"></i></span>
                            <input class="form-control" type="text" id="u_contact_no" name="u_contact_no" value="<?= $personal_info->contact_no; ?>" placeholder="Phone number">
                        </div>
                    </div>
                    <div class="col-12 col-md-12 mb-2">
                        <div class="input-group input-group-md border rounded">
                            <span class="input-group-text text-theme"><i class="bi bi-envelope"></i></span>
                            <input class="form-control" type="email" id="u_email" name="u_email" value="<?= $personal_info->email; ?>" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-12 col-md-12 mb-2">
                        <div class="input-group input-group-md border rounded">
                            <span class="input-group-text text-theme"><i class="bi bi-calendar2-heart"></i></span>
                            <input class="form-control tgl tanggal" type="text" id="u_date_of_birth" name="u_date_of_birth" value="<?= $personal_info->date_of_birth; ?>" placeholder="Birthday">
                        </div>
                    </div>
                    <div class="col-12 col-md-12 mb-2">
                        <div class="input-group input-group-md border rounded">
                            <span class="input-group-text text-theme"><i class="bi bi-gender-ambiguous"></i></span>
                            <select class="form-control simplechosen" id="u_gender" name="u_gender">
                                <option value="Male" <?= $personal_info->gender == "Male" ? "selected" : ""; ?>>Male</option>
                                <option value="Female" <?= $personal_info->gender == "Female" ? "selected" : ""; ?>>Female</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" id="btn_update_personal_info">Update</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Rekening -->
<div class="modal fade" id="modal_change_rekening" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Form Rekening</h6>
                        <p class="small text-secondary">Ubah Data Rekening</p>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <h6 class="fw-medium mb-2">Pilih Bank:</h6>
                <div class="row mb-2">
                    <div class="col-12 col-md-12 mb-2">
                        <div class="input-group input-group-md border rounded">
                            <span class="input-group-text text-theme"><i class="bi bi-cash"></i></span>
                            <select class="form-control simplechosen" id="bank_name">
                                <option value="Bank Mandiri">Bank Mandiri</option>
                                <option value="Bank Central Asia (BCA)">Bank Central Asia (BCA)</option>
                                <option value="Bank Rakyat Indonesia (BRI)">Bank Rakyat Indonesia (BRI)</option>
                                <option value="Bank Negara Indonesia (BNI)">Bank Negara Indonesia (BNI)</option>
                                <option value="Bank Danamon">Bank Danamon</option>
                                <option value="Bank CIMB Niaga">Bank CIMB Niaga</option>
                                <option value="Bank Tabungan Negara (BTN)">Bank Tabungan Negara (BTN)</option>
                                <option value="Bank Permata">Bank Permata</option>
                                <option value="Bank Mega">Bank Mega</option>
                                <option value="Bank Panin">Bank Panin</option>
                                <option value="Bank Bukopin">Bank Bukopin</option>
                                <option value="Bank OCBC NISP">Bank OCBC NISP</option>
                                <option value="Bank Maybank Indonesia">Bank Maybank Indonesia</option>
                                <option value="Bank Victoria Internasional">Bank Victoria Internasional</option>
                                <option value="Bank JTrust Indonesia">Bank JTrust Indonesia</option>
                            </select>
                        </div>
                    </div>
                </div>
                <h6 class="fw-medium mb-2">Account Bank:</h6>
                <div class="row align-items-center">
                    <div class="col-12 col-md-12 mb-2">
                        <div class="input-group input-group-md border rounded">
                            <span class="input-group-text text-theme"><i class="bi bi-bank"></i></span>
                            <input class="form-control" type="text" id="account_number" placeholder="Bank Account number">
                        </div>
                    </div>
                    <div class="col-12 col-md-12 mb-2">
                        <div class="input-group input-group-md border rounded">
                            <span class="input-group-text text-theme"><i class="bi bi-person"></i></span>
                            <input class="form-control" type="text" id="account_title" placeholder="Account holder name">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" id="btn-update-rekening">Update</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Change Pin Slip -->
<div class="modal fade" id="modal_change_pin_slip" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Form Pin Slip</h6>
                        <p class="small text-secondary">Ubah Pin Slip</p>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <h6 class="fw-medium mb-2"><?= $personal_info->ctm_pin_slip == "" ? "Pin Slip" : "Pin Lama"; ?>:</h6>
                <div class="row mb-2">
                    <div class="col-12 col-md-12 mb-2">
                        <div class="input-group input-group-md border rounded">
                            <span class="input-group-text text-theme"><i class="bi bi-key"></i></span>
                            <input class="form-control" type="password" id="old_ctm_pin_slip" placeholder="<?= $personal_info->ctm_pin_slip == "" ? "Pin Slip" : "Pin Lama"; ?>">
                        </div>
                        <small><i><span>Default PIN 1234</span></i></small>
                    </div>
                </div>
                <h6 class="fw-medium mb-2"><?= $personal_info->ctm_pin_slip == "" ? "Confirm New Pin Slip" : "Pin Baru"; ?>:</h6>
                <div class="row align-items-center">
                    <div class="col-12 col-md-12 mb-2">
                        <div class="input-group input-group-md border rounded">
                            <span class="input-group-text text-theme"><i class="bi bi-person-lock"></i></span>
                            <input class="form-control" type="password" id="new_ctm_pin_slip" placeholder="<?= $personal_info->ctm_pin_slip == "" ? "Confirm New Pin Slip" : "Pin Baru"; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" id="btn_update_ctm_pin_slip">Update</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal Change Password -->
<div class="modal fade" id="modal_change_password" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-block">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Form Change Password Account</h6>
                        <p class="small text-secondary">Ubah Kata Sandi Akun/Login</p>
                    </div>
                    <div class="col-auto">
                        <button type="button" id="btn_close_change_password" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <h6 class="fw-medium mb-2"><?= $personal_info->password == "" ? "Password" : "Current  Password"; ?>:</h6>
                <div class="row mb-2">
                    <div class="col-12 col-md-12 mb-2">
                        <div class="input-group input-group-md border rounded">
                            <span class="input-group-text text-theme"><i class="bi bi-key"></i></span>
                            <input class="form-control" type="password" id="old_password" placeholder="<?= $personal_info->password == "" ? "Password" : "Current  Password"; ?>">
                        </div>
                    </div>
                </div>
                <h6 class="fw-medium mb-2"><?= $personal_info->password == "" ? "Confirm Password" : "New Passowrd"; ?>:</h6>
                <div class="row align-items-center">
                    <div class="col-12 col-md-12 mb-2">
                        <div class="input-group input-group-md border rounded">
                            <span class="input-group-text text-theme"><i class="bi bi-person-lock"></i></span>
                            <input class="form-control" type="password" id="new_password" placeholder="<?= $personal_info->password == "" ? "Confirm Password" : "New Passowrd"; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" id="btn_update_password">Update</button>
            </div>
        </div>
    </div>
</div>


<?php //if(isset($_GET['test'])){ 
    ?>

    <!-- Modal Don't & Do's -->
    <style>
        /* Custom CSS for modal animation with swing effect */
        @keyframes swing {
            0% {
                transform: rotate(0deg);
            }

            20% {
                transform: rotate(15deg);
            }

            40% {
                transform: rotate(-10deg);
            }

            60% {
                transform: rotate(5deg);
            }

            80% {
                transform: rotate(-5deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        #modal_dont_dos {
            opacity: 0;
            transform: translateY(-50px);
            animation: swing 0.5s ease-out;
            transition: opacity 0.3s ease, transform 0.5s ease;
        }

        #modal_dont_dos.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Responsive styles for small screens */
    /* @media screen and (max-width: 480px) {
            body {
                --bs-modal-width: 450px !important;
            }
        } */

        @media screen and (min-width: 640px) and (min-height: 480px) {
            #modal_dont_dos {
                --bs-modal-width: 250px !important;
            }
            #modal_ultah {
                --bs-modal-width: 250px !important;
            }
        }

        @media screen and (min-width: 800px) and (min-height: 600px) {
            #modal_dont_dos {
                --bs-modal-width: 400px !important;
            }
            #modal_ultah {
                --bs-modal-width: 400px !important;
            }
        }

        @media screen and (min-width: 1024px) and (min-height: 768px) {
            #modal_dont_dos {
                --bs-modal-width: 450px !important;
            }
            #modal_ultah {
                --bs-modal-width: 450px !important;
            }
        }

        @media screen and (min-width: 1152px) and (min-height: 870px) {
            #modal_dont_dos {
                --bs-modal-width: 450px !important;
            }
            #modal_ultah {
                --bs-modal-width: 450px !important;
            }
        }

        @media screen and (min-width: 1280px) and (min-height: 1024px) {
            #modal_dont_dos {
                --bs-modal-width: 650px !important;
            }
            #modal_ultah {
                --bs-modal-width: 650px !important;
            }
        }

        @media screen and (min-width: 1600px) and (min-height: 1200px) {
            #modal_dont_dos {
                --bs-modal-width: 650px !important;
            }
            #modal_ultah {
                --bs-modal-width: 650px !important;
            }
        }
    </style>
    <div class="modal fade" id="modal_dont_dos" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" data-easein="swing">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h5 class="modal-title">Modal title</h5> -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col text-center">
                            <!-- <img id="info_banner" src="<?= base_url() ?>assets/img/dont_dos.jpg" alt="-"> -->
                            <img id="info_banner" src="" alt="-">
                            <input type="hidden" id="got_it_banner" value="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-end">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal" onclick="update_got_it()">Got it!</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal_reminder_change_password" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" data-easein="swing">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content alert alert-warning">
                <div class="modal-header">
                    <h5 class="modal-title">Reminder Change Password</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle" style="font-size: 24pt;"></i>
                        <div style="margin-left: 20px;">
                            <p>Password anda masih default, demi keamanan akun anda kami sarankan untuk segera ganti password!</p>
                        </div>
                    </div>

                </div>
                <div class="modal-footer text-end">
                    <!-- <button type="button" class="btn btn-secondary m-1" data-bs-dismiss="modal">Nanti saja</button> -->
                    <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#modal_change_password">Change Password</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_ultah" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" data-easein="swing">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Selamat Ulang Tahun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <img id="info_banner" src="<?= $personal_info->ultah_url_image; ?>" alt="-"><br>
                            <div>
                                <?php
                                $text = $personal_info->text_ultah;
                                $text = str_replace("[nama]", $personal_info->employee_name, $text);
                                $text = str_replace("[umur]", $personal_info->age, $text);
                                $text = str_replace("[masa_kerja]", $personal_info->masa_kerja, $text);
                                $text = str_replace("[emot1]", "🥳🎊", $text);
                                $text = str_replace("[emot2]", "🤗", $text);
                                $text = str_replace("[emot3]", "🥂✨", $text);
                                echo $text;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-end">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<?php //} 
?>