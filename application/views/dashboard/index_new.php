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
    <div class="w-100 position-relative">
        <div class="coverimg w-100 h-300" style="background-image: url(&quot;<?= base_url(); ?>assets/img/bga-1.avif&quot;);">
            <div class="position-absolute top-0 end-0 m-3">
                <button class="btn btn-light"><i class="bi bi-palette"> </i> &nbsp;&nbsp;Tema</button>
                <button class="btn btn-light"><i class="bi bi-camera"> </i> &nbsp;&nbsp;Change Cover</button>
            </div>
            <img src="<?= base_url(); ?>assets/img/bga-1.avif" class="mw-100" alt="">
        </div>
        <!-- <figure class="coverimg w-100 h-300 mb-0 position-relative">
			<div class="position-absolute top-0 end-0 m-3">
				<button class="btn btn-light"><i class="bi bi-camera"></i> Change Cover</button>
			</div>
			<img src="<?= base_url(); ?>assets/img/bga-1.avif" class="mw-100" alt="" />
		</figure> -->
    </div>
    <div class="container">
        <div class="row mb-4 align-items-start">
            <div class="col-auto position-relative">
                <figure class="avatar avatar-160 coverimg rounded-circle top-80 shadow-md border-3 border-light">
                    <img src="https://trusmiverse.com/hr/uploads/profile/<?= $personal_info->profile_picture; ?>" alt="" />
                </figure>
                <div class="position-absolute bottom-0 end-0 z-index-1 me-3 mb-1 h-auto">
                    <button class="btn btn-theme btn-44 shadow-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#modal_change_profile_picture"><i class="bi bi-camera"></i></button>
                </div>
            </div>
            <div class="col-12 col-md pt-2">
                <h2 class="mb-1"><?= $this->session->userdata("nama"); ?> <span class="badge bg-theme rounded vm fw-normal fs-12"><i class="bi bi-check-circle me-1"></i>Online</span></h2>
                <p><span class="text-secondary"><i class="bi bi-briefcase me-1"></i><?= $personal_info->department_name; ?>,</span> <?= $personal_info->company_name; ?></p>
                <a href="#" class="badge bg-light-theme text-theme">
                    <span class="avatar avatar-20 rounded-circle me-1 vm"><i class="bi bi-telephone"></i></span> <?= $personal_info->contact_no; ?>
                </a>
                <a href="mailto:information@maxartkiller.com" class="badge bg-light-theme text-theme">
                    <span class="avatar avatar-20 rounded-circle me-1 vm"><i class="bi bi-envelope"></i></span> <?= $personal_info->email; ?>
                </a>
            </div>
            <div class="col-12 col-xl-auto py-3">
                <div>
                    <a href="<?= base_url(); ?>hr/rekap_absen" class="btn btn-outline-theme me-2"><i class="bi bi-calendar vm me-2"></i> Rekap Absen</a>
                    <a href="<?= base_url(); ?>leave" class="btn btn-theme"><i class="bi bi-person-plus vm me-2"></i> Izin / Cuti</a>
                </div>
                <br>
            </div>
        </div>

        <div class="card border-0 mb-4 bg-gradient-theme-light">
            <div class="card-header bg-gradient-theme-light">
                <h6 class="mb-0 p-0 title">Resume Absensi</h6>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-0">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="bi bi-calendar-date h5 me-1 avatar avatar-40 bg-light-theme rounded"></i>
                                </div>
                                <div class="col ps-0">
                                    <h5 class="mb-0"><span id="present"></span>/<span id="harus_hadir"></span></h5>
                                    <p class="text-secondary ">Total Hadir / Total Hari</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="smallchart65 mb-2">
                                <canvas id="areachartblue1"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-0">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="bi bi-calendar2-check h5 me-1 avatar avatar-40 bg-light-theme rounded"></i>
                                </div>
                                <div class="col ps-0">
                                    <h6 class="mb-0" id="kehadiran">100%</h6>
                                    <p class="text-secondary ">Kehadiran</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="smallchart65 mb-2">
                                <canvas id="areachartgreen1"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-0">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar h5 me-1 avatar avatar-40 bg-light-theme rounded">
                                        <span class="small" id="kedisiplinan">81</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <span id="kedisiplinan_star" class="m-0">

                                    </span>
                                    <p class="text-secondary ">Kedisiplinan</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="smallchart65 mb-2">
                                <canvas id="areachartyellow1"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-5 col-xl-4">
                <!-- subscription upgrade -->
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
                <!-- intro -->
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
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
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
                                <p><?= $personal_info->date_of_birth; ?></p>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-gender-ambiguous h5 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <p class="text-secondary small mb-1">Gender</p>
                                <p><?= $personal_info->gender; ?></p>
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
                                    <i class="bi bi-shield-lock"></i>
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

                <!-- friends list -->
                <div class="card bg-gradient-theme-light border-0 mb-4">
                    <div class="card-header bg-gradient-theme-light">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-people h5 me-1 avatar avatar-40 bg-light-theme text-theme rounded me-2"></i>
                            </div>
                            <div class="col ps-0">
                                <h6 class="fw-medium mb-0">Team</h6>
                                <p class="text-secondary small">Bussiness Improvement <small></small></p>
                            </div>
                            <div class="col-auto">
                                <a href="" class="btn btn-sm btn-link">View all</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body gallery mnh-350 pb-0">
                        <div class="row">
                            <?php foreach ($team_info as $team) { ?>
                                <div class="col-4 mb-3">
                                    <a href="javascript:void(0)">
                                        <div class="h-110 w-100 overflow-hidden rounded mb-2">
                                            <figure class="h-100 w-100 coverimg zoomout">
                                                <img src="https://trusmiverse.com/hr/uploads/profile/<?= $team->profile_picture; ?>" alt="" />
                                            </figure>
                                        </div>
                                        <p class="text-truncate"><?= $team->employee_name; ?></p>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-7 col-xl-8">
                <div class="col-12">
                    <div class="card bg-gradient-theme-light border-0 z-index-1 mb-3">
                        <div class="card-body bg-gradient-theme-light">
                            <ul class="nav nav-tabs nav-WinDOORS border-0" id="riwayat" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="absensi_div_pane-tab" data-bs-toggle="tab" data-bs-target="#absensi_div_pane" type="button" role="tab" aria-controls="absensi_div_pane" aria-selected="true">Absensi</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="warning_div_pane-tab" data-bs-toggle="tab" data-bs-target="#warning_div_pane" type="button" role="tab" aria-controls="warning_div_pane" aria-selected="false" tabindex="-1">Warning</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="leave_div_pane-tab" data-bs-toggle="tab" data-bs-target="#leave_div_pane" type="button" role="tab" aria-controls="leave_div_pane" aria-selected="false" tabindex="-1">Izin/Cuti</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content" id="riwayatContent">
                        <div class="tab-pane fade show active" id="absensi_div_pane" role="tabpanel" aria-labelledby="absensi_div_pane-tab">
                            <div class="row">
                                <div class="col-12 col-md-4 mb-3">
                                    <div class="card border-0">
                                        <div class="card-body bg-gradient-theme-light">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-30 rounded bg-light-theme">
                                                        <i class="bi bi-calendar2-x"></i>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <p class="text-secondary small mb-1">Tidak Hadir</p>
                                                    <h4 class="text-dark mb-0"><span class="increamentcount" id="bolos"></span> <small class="h6"></small></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <div class="card border-0">
                                        <div class="card-body bg-gradient-theme-light ">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-30 rounded bg-light-theme">
                                                        <i class="bi bi-file-earmark-medical"></i>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <p class="text-secondary small mb-1">Izin/Cuti</p>
                                                    <h4 class="text-dark mb-0"><span class="increamentcount" id="leave"></span> <small class="h6"></small></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <div class="card border-0">
                                        <div class="card-body bg-gradient-theme-light ">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-30 rounded bg-light-theme">
                                                        <i class="bi bi-clock-history"></i>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <p class="text-secondary small mb-1">Telat</p>
                                                    <h4 class="text-dark mb-0"><span class="increamentcount" id="late">0</span> <small class="h6"></small></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Absensi -->
                            <div class="card bg-gradient-theme-light border-0 mb-4">
                                <div class="card-body">
                                    <p class="title">Filter Absen</p>
                                </div>
                                <div class="card-header">
                                    <div class="row">
                                        <?php $allowed_akses = ['2063', '1', '979'];
                                        $class_none = "d-none";
                                        $user_id = $this->session->userdata("user_id");
                                        if (in_array($user_id, $allowed_akses)) {
                                            $class_none = "";
                                        } ?>
                                        <div class="col-12 <?= $class_none; ?>">
                                            <div class="form-group mb-3 position-relative">
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text text-theme bg-light-theme border-end-0"><i class="bi bi-people"></i></span>
                                                    <div class="form-floating">
                                                        <select name="employee_id" id="employee_id" class="form-select border-0 ui search dropdown bg-gradient-theme-light">
                                                        </select>
                                                        <label for="employee_id" class="float-label">Employee Name</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3 position-relative">
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text text-theme bg-light-theme border-end-0"><i class="bi bi-calendar-date"></i></span>
                                                    <div class="form-floating">
                                                        <select name="month" id="month" class="form-select border-0 ui search dropdown">
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
                                                        <label for="month" class="float-label">Month</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3 position-relative">
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text text-theme bg-light-theme border-end-0"><i class="bi bi-calendar-date"></i></span>
                                                    <div class="form-floating">
                                                        <select name="year" id="year" class="form-select border-0 ui search dropdown">
                                                            <?php for ($i = date("Y") + 1; $i >= 2018; $i--) { ?>
                                                                <option value="<?= $i ?>" <?= date("Y") ? (date("Y") == $i ? 'selected' : '') : '' ?>><?= $i ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <label for="year" class="float-label">Year</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-end">
                                            <button class="btn btn-theme" type="button" id="filter" onclick="filter_detail()"><i class="fa fa-search"></i> Filter</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="title">Riwayat Absen</p>
                                </div>
                                <div class="card-body pb-0" style="max-height: 1050px;overflow-y: scroll;">
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <div id="body_detail_absen">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="leave_div_pane" role="tabpanel" aria-labelledby="leave_div_pane-tab">
                            <div class="row justify-content-center">
                                <div class="h-300 d-flex align-items-center justify-content-center">
                                    <div class="col-12">
                                        <h4 class="text-center m-0 p-0">Please be patient, <span class="text-gradient">Coming Soon...</span></h4><br class="m-0 p-0">
                                        <p class="text-secondary m-0 p-0 text-center mb-4">we work hard, we do it creatively and we like to see you here!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="warning_div_pane" role="tabpanel" aria-labelledby="warning_div_pane-tab">
                            <div class="row justify-content-center">
                                <div class="h-300 d-flex align-items-center justify-content-center">
                                    <div class="col-12">
                                        <h4 class="text-center m-0 p-0">Please be patient, <span class="text-gradient">Coming Soon...</span></h4><br class="m-0 p-0">
                                        <p class="text-secondary m-0 p-0 text-center mb-4">we work hard, we do it creatively and we like to see you here!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contactus" role="tabpanel" aria-labelledby="contactus-tab">...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('layout/_footer'); ?>
</main>


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
                            <input class="form-control" type="file">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-theme w-100">Upload Foto</button>
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
                    <div class="col-12 col-md-6 mb-2">
                        <div class="input-group input-group-md border rounded">
                            <span class="input-group-text text-theme"><i class="bi bi-telephone"></i></span>
                            <input class="form-control" type="text" id="contact_no" placeholder="Phone number">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-2">
                        <div class="input-group input-group-md border rounded">
                            <span class="input-group-text text-theme"><i class="bi bi-envelope"></i></span>
                            <input class="form-control" type="text" id="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-2">
                        <div class="input-group input-group-md border rounded">
                            <span class="input-group-text text-theme"><i class="bi bi-calendar2-heart"></i></span>
                            <input class="form-control" type="text" id="date_of_birth" placeholder="Birthday">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-2">
                        <div class="input-group input-group-md border rounded">
                            <span class="input-group-text text-theme"><i class="bi bi-gender-ambiguous"></i></span>
                            <select class="form-control simplechosen" id="gender">
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-theme w-100">Simpan Perubahan</button>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-theme w-100" id="btn-update-rekening">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>