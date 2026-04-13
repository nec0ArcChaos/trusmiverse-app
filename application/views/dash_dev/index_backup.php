<main class="main mainheight">
    <!-- page title bar -->
    <div class="container-fluid">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0">My Dashboard</h5>
                <p class="text-secondary">This is your personal dashboard</p>
            </div>

        </div>
    </div>

    <!-- welcome bar -->
    <div class="container-fluid bg-gradient-theme-light mb-4">
        <div class="row">
            <div class="col-12 col-xxl-11 mx-auto">
                <div class="row align-items-center">
                    <!-- welcome message -->
                    <div class="col-12 col-md py-3 py-md-5">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <h2 class="fw-light mb-0 text-secondary" style="font-size: calc(1.1rem + 1.2vw);">Welcome,</h2>
                                <h1 class="display-3 username " style="font-size: calc(1.1rem + 1.2vw);"><?= $this->session->userdata('nama'); ?></h1>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <!-- Swiper daily quote -->
                                <div class="swiper dailyquote mt-4">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <i class="bi bi-quote h5 avatar avatar-40 rounded-circle bg-light-theme"></i>
                                                </div>
                                                <div class="col">
                                                    <img src="<?= base_url(); ?>assets/img/Pembelajar.png" alt="" style="max-height: 200px;">
                                                    <h5 class="fw-normal text-gradient">Semakin Tumbuh, Semakin Berilmu dan Sejahtera</h5>
                                                    <!-- <p class="fw-light">Semakin Tumbuh, Semakin Berilmu dan Sejahtera <cite title=" Source Title"></cite> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <i class="bi bi-quote h5 avatar avatar-40 rounded-circle bg-light-theme"></i>
                                                </div>
                                                <div class="col">
                                                    <img src="<?= base_url(); ?>assets/img/Proaktif.png" alt="" style="max-height: 200px;">
                                                    <h5 class="fw-normal text-gradient">Berani Berencana, Berani Aksi </h5>
                                                    <!-- <p class="fw-light">Berani Berencana, Berani Aksi <cite title=" Source Title"></cite> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <i class="bi bi-quote h5 avatar avatar-40 rounded-circle bg-light-theme"></i>
                                                </div>
                                                <div class="col">
                                                    <img src="<?= base_url(); ?>assets/img/Penebar-energi-positif.png" alt="" style="max-height: 200px;">
                                                    <h5 class="fw-normal text-gradient">Bermindset Positif, Berperilaku Positif</h5>
                                                    <!-- <p class="fw-light">Bermindset Positif, Berperilaku Positif <cite title=" Source Title"></cite> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- rank and progress -->
                    <div class="col-auto ml-auto py-3 py-md-5 align-self-center">
                        <div class="row mb-4">
                            <!-- <div class="col col-md col-lg-auto mnw-100 text-center">
                                <i class="bi bi-trophy h5 avatar avatar-50 bg-light-orange text-orange rounded-circle mb-2"></i>
                                <h3 class="increamentcount mb-0"></h3>
                                <p class="small text-secondary"></p>
                            </div>
                            <div class="col col-md col-lg-auto mnw-100 text-center">
                                <i class="bi bi-award h5 avatar avatar-50 bg-light-green text-green rounded-circle mb-2"></i>
                                <h3 class="increamentcount mb-0"></h3>
                                <p class="small text-secondary"></p>
                            </div>
                            <div class="col col-md col-lg-auto mnw-100 text-center">
                                <i class="bi bi-clipboard-check h5 avatar avatar-50 bg-light-blue text-blue rounded-circle mb-2"></i>
                                <h3 class="increamentcount mb-0"></h3>
                                <p class="small text-secondary"></p>
                            </div> -->
                        </div>
                        <div class="row align-items-center">
                            <!-- <div class="col-auto">
                                <i class="bi bi-star h5 avatar avatar-50 bg-warning text-white rounded-circle"></i>
                            </div>
                            <div class="col ps-0">
                                <p>Earn 500 points</p>
                                <div class="progress h-5 mb-1 bg-light-theme">
                                    <div class="progress-bar bg-theme" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="text-secondary small"><a href="#">Complete your profile</a></p>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mb-4 py-2">
            <div class="col text-center">
                <h4>The sort <span class="text-gradient">summary</span> may help you</h4>
                <p class="text-secondary">Keep yourself updated, No matter how much workload is.</p>
            </div>
        </div>
        <div class="row mb-5">

            <!-- summary blocks -->
            <div class="col-12 col-md-12 col-lg-12 col-xxl-12">
                <div class="card border-0 mb-4" id="card_lock_absen">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="circle-small">
                                    <div id="circleprogressblue"></div>
                                    <div class="avatar h5 bg-light-blue rounded-circle">
                                        <i class="" id="icon_lock_absen"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <p class="text-dark small mb-1" style="font-weight: bold;">Attendance Today</p>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <p class="text-secondary small mb-1" id="status_lock_basen">Unlocked</p>
                                        <h5 class="fw-medium" id="msg_lock_absen"><small></small></h5>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-auto">
                                <div class="dropdown d-inline-block">
                                    <a class="text-secondary dd-arrow-none" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="javascript:void(0)">Edit</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">Move</a></li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)">Delete</a></li>
                                    </ul>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-12 col-lg-12 col-xxl-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-3 col-lg-3 mr-1 ml-1 mb-1">
                                <?php $allowed_akses = ['2063', '1', '979'];
                                $user_id = $this->session->userdata("user_id");
                                if (in_array($user_id, $allowed_akses)) { ?>
                                    <div class="form-group position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-user"></i></span>
                                            <div class="form-floating">
                                                <select name="employee_id" id="employee_id" class="form-control">
                                                </select>
                                                <label>Karyawan</label>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3 mr-1 ml-1 mb-1">
                                <div class="form-group position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar"></i></span>
                                        <div class="form-floating">
                                            <select name="month" id="month" class="form-control">
                                                <option name="month" id="month" value="01" <?= date("m") == '01' ? 'selected' : ''; ?>>Januari</option>
                                                <option name="month" id="month" value="02" <?= date("m") == '02' ? 'selected' : ''; ?>>Februari</option>
                                                <option name="month" id="month" value="03" <?= date("m") == '03' ? 'selected' : ''; ?>>Maret</option>
                                                <option name="month" id="month" value="04" <?= date("m") == '04' ? 'selected' : ''; ?>>April</option>
                                                <option name="month" id="month" value="05" <?= date("m") == '05' ? 'selected' : ''; ?>>Mei</option>
                                                <option name="month" id="month" value="06" <?= date("m") == '06' ? 'selected' : ''; ?>>Juni</option>
                                                <option name="month" id="month" value="07" <?= date("m") == '07' ? 'selected' : ''; ?>>Juli</option>
                                                <option name="month" id="month" value="08" <?= date("m") == '08' ? 'selected' : ''; ?>>Agustus</option>
                                                <option name="month" id="month" value="09" <?= date("m") == '09' ? 'selected' : ''; ?>>September</option>
                                                <option name="month" id="month" value="10" <?= date("m") == '10' ? 'selected' : ''; ?>>Oktober</option>
                                                <option name="month" id="month" value="11" <?= date("m") == '11' ? 'selected' : ''; ?>>November</option>
                                                <option name="month" id="month" value="12" <?= date("m") == '12' ? 'selected' : ''; ?>>Desember</option>
                                            </select>
                                            <label>Bulan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3 mr-1 ml-1 mb-1">
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
                                    <button class="button-4" type="button" id="filter" onclick="filter_detail()" style="font-size: 12px;"><i class="fa fa-search"></i> Show</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-6 col-xxl-3">
                <div class="card border-0 mb-4">
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
                                <p class="text-dark small mb-1" style="font-weight: bold;">Resume Absensi</p>
                                <div class="row">
                                    <div class="col-4 col-sm-3 col-md-3 col-lg-3">
                                        <p class="text-secondary small mb-1">Harus Hadir</p>
                                        <h5 class="fw-medium" id="harus_hadir"></h5>
                                    </div>
                                    <div class="col-4 col-sm-3 col-md-3 col-lg-3">
                                        <p class="text-secondary small mb-1">Hadir</p>
                                        <h5 class="fw-medium" id="present">-</h5>
                                    </div>
                                    <div class="col-4 col-sm-3 col-md-3 col-lg-3">
                                        <p class="text-secondary small mb-1">Tidak Hadir</p>
                                        <h5 class="fw-medium" id="bolos"></h5>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-auto">
                                    <div class="dropdown d-inline-block">
                                        <a class="text-secondary dd-arrow-none" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="javascript:void(0)">Edit</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)">Move</a></li>
                                            <li><a class="dropdown-item text-danger" href="javascript:void(0)">Delete</a></li>
                                        </ul>
                                    </div>
                                </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6 col-xxl-3">
                <div class="card border-0 mb-4">
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
                                <p class="text-dark small mb-1" style="font-weight: bold;">Resume Izin</p>
                                <div class="row">
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                        <p class="text-secondary small mb-1">Leave</p>
                                        <h5 class="fw-medium" id="leave"><small></small></h5>
                                    </div>
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                        <p class="text-secondary small mb-1">Late (mnt)</p>
                                        <h5 class="fw-medium" id="late">-<small></small></h5>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-auto">
                                    <div class="dropdown d-inline-block">
                                        <a class="text-secondary dd-arrow-none" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="javascript:void(0)">Edit</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)">Move</a></li>
                                            <li><a class="dropdown-item text-danger" href="javascript:void(0)">Delete</a></li>
                                        </ul>
                                    </div>
                                </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6 col-xxl-3">
                <div class="card border-0 mb-4">
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
                                <p class="text-dark small mb-1" style="font-weight: bold;">History Lock Absen</p>
                                <div class="row">
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-4">
                                        <p class="text-secondary small mb-1">Video</p>
                                        <h5 class="fw-medium" id="lock_video">-<small></small></h5>
                                    </div>
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-4">
                                        <p class="text-secondary small mb-1">Tasklist</p>
                                        <h5 class="fw-medium" id="lock_tasklist">-<small></small></h5>
                                    </div>
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-4">
                                        <p class="text-secondary small mb-1">Eaf</p>
                                        <h5 class="fw-medium" id="lock_eaf">-<small></small></h5>
                                    </div>
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-4">
                                        <p class="text-secondary small mb-1">Training</p>
                                        <h5 class="fw-medium" id="lock_training">-<small></small></h5>
                                    </div>
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-4">
                                        <p class="text-secondary small mb-1">Lain-lain</p>
                                        <h5 class="fw-medium" id="lock_other">-<small></small></h5>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-auto">
                                    <div class="dropdown d-inline-block">
                                        <a class="text-secondary dd-arrow-none" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="javascript:void(0)">Edit</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)">Move</a></li>
                                            <li><a class="dropdown-item text-danger" href="javascript:void(0)">Delete</a></li>
                                        </ul>
                                    </div>
                                </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6 col-xxl-3" style="display: none;">
                <div class="card border-0 mb-4">
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p class="text-secondary small mb-1">Kehadiran</p>
                                <div class="circle-medium mx-auto mb-3">
                                    <div id="circleprogressblueKehadiran"></div>
                                    <div class="avatar h4 bg-light-blue rounded-circle">
                                        <i class="bi bi-person-bounding-box"></i>
                                    </div>
                                </div>
                                <h5 class="fw-medium" id="txt_kehadiran">0</h5>
                            </div>
                            <div class="col-12 col-sm-6"></div>
                        </div>
                    </div>
                    <div class="card-footer border-top">
                        <div class="row">
                            <div class="col-6">
                                <p class="text-secondary small mb-1">New Users</p>
                                <p>5 <small class="fs-12 fw-light text-secondary">This week</small></p>
                            </div>
                            <div class="col-6 border-left-dashed">
                                <p class="text-secondary small mb-1">Total Users</p>
                                <p>65826</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6 col-xxl-3">
                <div class="card border-0 mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="circle-small">
                                    <div id="circleprogressyellow"></div>
                                    <div class="avatar h5 bg-light-yellow text-yellow rounded-circle">
                                        <i class="bi bi-calendar2-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <!-- <p class="text-secondary small mb-1">Reward & Punishment</p> -->
                                <div class="row">
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                        <p class="text-secondary small mb-1">Kehadiran</p>
                                        <div class="circle-small">
                                            <div id="circleprogressblue1"></div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                        <p class="text-secondary small mb-1">Kedisiplinan</p>
                                        <div class="circle-small">
                                            <div id="circleprogressyellow1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-auto">
                                    <div class="dropdown d-inline-block">
                                        <a class="text-secondary dd-arrow-none" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="javascript:void(0)">Edit</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)">Move</a></li>
                                            <li><a class="dropdown-item text-danger" href="javascript:void(0)">Delete</a></li>
                                        </ul>
                                    </div>
                                </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <?php $department_id = $this->session->userdata('department_id'); ?>
            <?php $user_id = $this->session->userdata('user_id'); ?>
            <?php if ($department_id == 68) { ?>
            <?php } ?>

            <div class="col-12 col-md-6 col-lg-6 col-xxl-3">
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
                                <div class="dropdown d-inline-block">
                                    <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" id="btn-update-rekening" aria-expanded="false">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="swiper-container creditcards">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="card border-0 mb-2 theme-blue" style="width: 300px;">
                                        <div class="card-body">
                                            <div class="row align-items-center mb-4">
                                                <div class="col-auto align-self-center">
                                                    <!-- <img src="<?= base_url(); ?>assets/img/dashboards/visa.png" alt=""> -->
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
</main>

<main class="main mainheight">
    <div class="container-fluid">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <ul class="nav nav-WinDOORS">
                    <li class=" nav-item">
                        <span class="nav-link">Profiles: </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="profile.html">Professional</a>
                    </li>
                    <li class=" nav-item">
                        <a class="nav-link" href="profile-analytics.html">Analytic</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile-social.html">Social</a>
                    </li>
                </ul>
            </div>
            <div class="col col-sm-auto">
                <div class="input-group input-group-md">
                    <input type="text" class="form-control bg-none px-0" value="" id="titlecalendar" />
                    <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                </div>
            </div>
            <div class="col-auto ps-0">
                <div class="dropdown d-inline-block">
                    <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" href="profile.html#" role="button" id="filterintitle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        <i class="bi bi-filter"></i>
                    </a>
                    <div class="dropdown-menu w-300" aria-labelledby="filterintitle">
                        <div class="dropdown-item">
                            <div class="input-group input-group-md border rounded">
                                <span class="input-group-text text-theme"><i class="bi bi-box"></i></span>
                                <select class="form-control" id="titltfilterlist" multiple>
                                    <option value="San Francisco">San Francisco</option>
                                    <option value="New York">New York</option>
                                    <option value="London">London</option>
                                    <option value="Chicago">Chicago</option>
                                    <option value="India" selected>India</option>
                                    <option value="Sydney">Sydney</option>
                                    <option value="Seattle">Seattle</option>
                                    <option value="Los Angeles">Los Angeles</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="Los Angeles">Los Angeles</option>
                                    <option value="Chicago">Chicago</option>
                                    <option value="India">India</option>
                                </select>
                            </div>
                            <div class="invalid-feedback">You have already selected maximum option allowed. (This is Configurable)</div>
                        </div>
                        <div class="dropdown-item">
                            <h6 class="mb-0">Orders:</h6>
                            <p class="text-secondary small">1256 orders last week</p>
                        </div>
                        <ul class="list-group list-group-flush bg-none mb-2">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col">Online Orders</div>
                                    <div class="col-auto">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="titleswitch1">
                                            <label class="form-check-label" for="titleswitch1"></label>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col">Offline Orders</div>
                                    <div class="col-auto">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="titleswitch2" checked="">
                                            <label class="form-check-label" for="titleswitch2"></label>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="dropdown-item">
                            <div class="row">
                                <div class="col"><button class="btn btn-outline-secondary border">cancel</button></div>
                                <div class="col-auto">
                                    <button class="btn btn-theme">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="help-center.html" class="btn btn-link btn-square text-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Support">
                    <i class="bi bi-life-preserver"></i>
                </a>
                <a href="personalization.html" class="btn btn-link btn-square text-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Personalize">
                    <i class="bi bi-palette"></i>
                </a>
                <a href="app-pricing.html" class="btn btn-link btn-square text-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Buy this">
                    <span class="bi bi-basket position-relative">
                        <span class="position-absolute top-0 start-100 p-1 bg-danger border border-light rounded-circle">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                    </span>
                </a>
            </div>
        </div>
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home.html">WinDOORS</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
    </div>

    <figure class="coverimg w-100 h-300 mb-0 position-relative">
        <div class="position-absolute top-0 end-0 m-3">
            <button class="btn btn-light"><i class="bi bi-camera"></i> Change Cover</button>
        </div>
        <img src="https://getwindoors.com/html/assets/img/bg-13.jpg" class="mw-100" alt="" />
    </figure>
    <div class="container">
        <div class="row mb-4 align-items-start">
            <div class="col-auto position-relative">
                <figure class="avatar avatar-160 coverimg rounded-circle top-80 shadow-md border-3 border-light">
                    <img src="assets/img/user-1.jpg" alt="" />
                </figure>
                <div class="position-absolute bottom-0 end-0 z-index-1 me-3 mb-1 h-auto">
                    <button class="btn btn-theme btn-44 shadow-sm rounded-circle"><i class="bi bi-camera"></i></button>
                </div>
            </div>
            <div class="col-12 col-md pt-3">
                <h2 class="mb-3">Maxartkiller <span class="badge bg-green rounded vm fw-normal fs-12"><i class="bi bi-check-circle me-1"></i>Active</span></h2>
                <p><span class="text-secondary"><i class="bi bi-chat-right-text me-1"></i>Talks about:</span> #uxdesign, #creativity, #uidesigner, #uxdesigner, and #webdesigner</p>
                <p><span class=" text-secondary"><i class=" bi bi-geo-alt me-1"></i>Lives in:</span> D25, Amalika Empire, DD Street, San Jose, United States</p>
                <p><span class=" text-secondary"><i class=" bi bi-briefcase me-1"></i>Work Experience:</span> UX Designer at maxartkiller.com (2013 - Currently working)</p>
            </div>
            <div class="col-12 col-xl-auto py-3">
                <div>
                    <button class="btn btn-outline-theme me-2"><i class="bi bi-plus vm me-2"></i> Follow</button>
                    <button class="btn btn-theme"><i class="bi bi-person-plus vm me-2"></i> Add Connection</button>
                </div>
                <br>
                <p class="text-xl-end"><a href="profile.html">5860 Followers</a> <span class="text-muted">|</span> <a href="profile.html">4580 Connections</a></p>
            </div>
        </div>

        <div class="card border-0 mb-4 bg-gradient-theme-light theme-green">
            <div class="card-header">
                <h5 class="mb-1">Profile Overview</h5>
                <p class="text-secondary"><i class="bi bi-eye"></i> Visible to you only</p>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-0">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-people h4 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <h4 class="mb-1">36 <small>Profile views</small></h4>
                                <p class="text-secondary ">Findout who viewed your profile</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-0">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-bar-chart h4 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <h4 class="mb-1">54 <small>Posts interaction</small></h4>
                                <p class="text-secondary ">You are getting noticed and getting hits.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-0">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-search h4 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <h4 class="mb-1">144 <small>Search appearance</small></h4>
                                <p class="text-secondary ">People shown you in search result</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-5 col-xl-4">
                <!-- intro -->
                <div class="card border-0 mb-4">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-person-circle h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                            </div>
                            <div class="col ps-0">
                                <h6 class="fw-medium mb-0">About</h6>
                                <p class="text-secondary small">"Love the life, Spread and creativity"</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <p class="text-secondary">
                            WinDOORS is creative and multipurpose template. You can use it for CRM, Business application, Intranet Application, Portal service and Many more. It comes with unlimited possibilities and 10+ predefined styles which you can also mix up and create new style. Do support and spread a word for us.
                        </p>
                        <p><a href="profile.html">Read more</a></p>
                        <br>
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-telephone h5 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <p class="text-secondary small mb-1">Phone</p>
                                <p>+189625256A59863</p>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-envelope h5 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <p class="text-secondary small mb-1">Email Address</p>
                                <p>information@maxartkiller.com</p>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-calendar2-heart h5 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <p class="text-secondary small mb-1">Birthday</p>
                                <p>1 August 1992</p>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-gender-ambiguous h5 text-theme mb-0"></i>
                            </div>
                            <div class="col">
                                <p class="text-secondary small mb-1">Gender</p>
                                <p>Male</p>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- friends list -->
                <div class="card border-0 mb-4">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-people h5 me-1 avatar avatar-40 bg-light-green text-green rounded me-2"></i>
                            </div>
                            <div class="col ps-0">
                                <h6 class="fw-medium mb-0">Connection</h6>
                                <p class="text-secondary small">1256 Connections <small>(12 Common)</small></p>
                            </div>
                            <div class="col-auto">
                                <a href="profile.html" class="btn btn-sm btn-link">View all</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body gallery mnh-350 pb-0">
                        <div class="row">
                            <div class="col-4 mb-3">
                                <a href="profile.html">
                                    <div class="h-110 w-100 overflow-hidden rounded mb-2">
                                        <figure class="h-100 w-100 coverimg zoomout">
                                            <img src="https://getwindoors.com/html/assets/img/bg-6.jpg" alt="" />
                                        </figure>
                                    </div>
                                    <p class="text-truncate">Aditi Johnson</p>
                                </a>
                            </div>
                            <div class="col-4 mb-3">
                                <a href="profile.html">
                                    <div class="h-110 w-100 overflow-hidden rounded mb-2">
                                        <figure class="h-100 w-100 coverimg zoomout">
                                            <img src="assets/img/user-4.jpg" alt="" />
                                        </figure>
                                    </div>
                                    <p class="text-truncate">Steven Gill</p>
                                </a>
                            </div>
                            <div class="col-4 mb-3">
                                <a href="profile.html">
                                    <div class="h-110 w-100 overflow-hidden rounded mb-2">
                                        <figure class="h-100 w-100 coverimg zoomout">
                                            <img src="assets/img/user-3.jpg" alt="" />
                                        </figure>
                                    </div>
                                    <p class="text-truncate">Preeti Lucky</p>
                                </a>
                            </div>
                            <div class="col-4 mb-3">
                                <a href="profile.html">
                                    <div class="h-110 w-100 overflow-hidden rounded mb-2">
                                        <figure class="h-100 w-100 coverimg zoomout">
                                            <img src="assets/img/user-1.jpg" alt="" />
                                        </figure>
                                    </div>
                                    <p class="text-truncate">Max Doe</p>
                                </a>
                            </div>
                            <div class="col-4 mb-3">
                                <a href="profile.html">
                                    <div class="h-110 w-100 overflow-hidden rounded mb-2">
                                        <figure class="h-100 w-100 coverimg zoomout">
                                            <img src="assets/img/user-2.jpg" alt="" />
                                        </figure>
                                    </div>
                                    <p class="text-truncate">Aditi Johnson</p>
                                </a>
                            </div>
                            <div class="col-4 mb-3">
                                <a href="profile.html">
                                    <div class="h-110 w-100 overflow-hidden rounded mb-2">
                                        <figure class="h-100 w-100 coverimg zoomout">
                                            <img src="assets/img/bg-4.jpg" alt="" />
                                        </figure>
                                    </div>
                                    <p class="text-truncate">Steven Gill</p>
                                </a>
                            </div>
                            <div class="col-4 mb-3">
                                <a href="profile.html">
                                    <div class="h-110 w-100 overflow-hidden rounded mb-2">
                                        <figure class="h-100 w-100 coverimg zoomout">
                                            <img src="https://getwindoors.com/html/assets/img/bg-5.jpg" alt="" />
                                        </figure>
                                    </div>
                                    <p class="text-truncate">Max Doe</p>
                                </a>
                            </div>
                            <div class="col-4 mb-3">
                                <a href="profile.html">
                                    <div class="h-110 w-100 overflow-hidden rounded mb-2">
                                        <figure class="h-100 w-100 coverimg zoomout">
                                            <img src="assets/img/bg-3.jpg" alt="" />
                                        </figure>
                                    </div>
                                    <p class="text-truncate">Preeti Lucky</p>
                                </a>
                            </div>
                            <div class="col-4 mb-3">
                                <a href="profile.html">
                                    <div class="h-110 w-100 overflow-hidden rounded mb-2">
                                        <figure class="h-100 w-100 coverimg zoomout">
                                            <img src="assets/img/bg-1.jpg" alt="" class="w-100" />
                                        </figure>
                                    </div>
                                    <p class="text-truncate">Max Doe</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- subscription upgrade -->
                <div class="card border-0 bg-gradient-theme-light mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <figure class="avatar avatar-50 rounded-circle bg-yellow text-white">
                                    <i class="bi bi-star mb-1 vm"></i>
                                </figure>
                            </div>
                            <div class="col ps-0">
                                <h6 class="mb-0">Business </h6>
                                <p class="fw-normal">Annual Plan</p>
                            </div>
                            <div class="col-auto">
                                <h4 class="mb-0">$ 250</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class=" row align-items-center">
                            <div class="col-auto">
                                <p class="mb-0">22-June-2022</p>
                                <p class="small text-muted">Next Due</p>
                            </div>
                            <div class="col text-end">
                                <a href="subscription.html" class="btn btn-sm btn-theme">View Plan!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-7 col-xl-8">
                <!-- Experience -->
                <div class="card border-0 mb-4">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-briefcase h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                            </div>
                            <div class="col ps-0">
                                <h6 class="fw-medium mb-0">Experience</h6>
                                <p class="text-secondary small">Currently working</p>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-link btn-sm"><i class="bi bi-plus h4 vm me-2"></i><span>Add</span> <span class="d-none d-md-inline-block">New Role</span></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="row mb-4">
                            <div class="col-auto">
                                <figure class="avatar-40 avatar rounded coverimg">
                                    <img src="https://getwindoors.com/html/assets/img/maxartkiller.png" alt="" />
                                </figure>
                            </div>
                            <div class="col">
                                <h6>Creative UI/UX Designer at <a href="https://maxartkiller.com">Maxartkiller</a>, London, UK</h6>
                                <p class="text-secondary">July 2013 - Present, 9 years 2 months</p>
                                <p>We are working in good company with reputed online presence and there are multi-disciplinary designers are available to give creative works.</p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-auto">
                                <figure class="avatar-40 avatar rounded coverimg">
                                    <img src="assets/img/windows.png" alt="" />
                                </figure>
                            </div>
                            <div class="col">
                                <h6>Creative Designer at <a href="https://maxartkiller.com">Micro Window</a>, Tipura, IN</h6>
                                <p class="text-secondary">July 2012 - 2013, 1 years 1 month</p>
                                <p>We are working in good company with reputed online presence and there are multi-disciplinary designers are available to give creative works.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Education -->
                <div class="card border-0 mb-4">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-briefcase h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                            </div>
                            <div class="col ps-0">
                                <h6 class="fw-medium mb-0">Education</h6>
                                <p class="text-secondary small">Strong foundation</p>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-link btn-sm"><i class="bi bi-plus h4 vm me-2"></i><span>Add</span> <span class="d-none d-md-inline-block">New Education</span></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="row mb-4">
                            <div class="col-auto">
                                <figure class="avatar-40 avatar rounded coverimg">
                                    <img src="assets/img/favicon72.png" alt="" />
                                </figure>
                            </div>
                            <div class="col">
                                <h6>M.Tech from <a href="https://maxartkiller.com">London bridge University</a>, London, UK</h6>
                                <p class="text-secondary">July 2010 - July 2012, 3 years</p>
                                <p>This helped me a strong base to build my career and i always recommended to all people to must visit and study at University.</p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-auto">
                                <figure class="avatar-40 avatar rounded coverimg">
                                    <img src="assets/img/google.png" alt="" />
                                </figure>
                            </div>
                            <div class="col">
                                <h6>LifeTime Learning at <a href="https://maxartkiller.com">Google Search</a>, Online remote</h6>
                                <p class="text-secondary">July 2008 - Present, 24 years and counting</p>
                                <p>Its been pleasure to mention that every student learned many things from online and most helpful finger tip resource available at google search and we thank you for all of help and support and improvement provided for us. You should try this and hope to have great learning.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Courses -->
                <div class="card border-0 mb-4">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-patch-check h5 me-1 avatar avatar-40 bg-light-yellow text-yellow rounded me-2"></i>
                            </div>
                            <div class="col ps-0">
                                <h6 class="fw-medium mb-0">Courses</h6>
                                <p class="text-secondary small">Study makes me hungry</p>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-link btn-sm"><i class="bi bi-plus vm me-2"></i><span class="vm">Add</span> <span class="d-none d-md-inline-block vm">Course</span></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="row mb-4">
                            <div class="col">
                                <h6>User Experience Design<br><small class="fw-medium text-secondary">from Arenaas Graphics Academy</small></h6>
                                <p class="text-secondary">July 2011 - July 2012, 1 year</p>
                                <p>I have completed user experience design course of 12 months and achieved 80% in final exam. I have experienced with cab project to meet customer challenges and problem solving interface design activities.</p>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <h6>User Centered Design<br><small class="fw-medium text-secondary">from Interaction design foundations</small></h6>
                                <p class="text-secondary">July 2012 - July 2013, 1 year</p>
                                <p>I have completed user experience design course of 12 months and achieved 84% in final exam. I have experienced with cab project to meet customer challenges and problem solving interface design activities.</p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Recommendations -->
                <div class="card border-0 mb-4">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-balloon-heart h5 me-1 avatar avatar-40 bg-light-red text-red rounded me-2"></i>
                            </div>
                            <div class="col ps-0">
                                <h6 class="fw-medium mb-0">Recommendations</h6>
                                <p class="text-secondary small">People loves a lot</p>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-link btn-sm"><i class="bi bi-chat-right-dots vm me-2"></i><span class="vm">Request</span> <span class="d-none d-md-inline-block vm">Recommendation</span></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="row mb-4">
                            <div class="col-auto">
                                <figure class="avatar-60 avatar rounded-circle coverimg">
                                    <img src="assets/img/user-2.jpg" alt="" />
                                </figure>
                            </div>
                            <div class="col">
                                <h6 class="mb-1">Anamika Sehgal </h6>
                                <p class="text-secondary">Worked together with Maxartkller in 2021. Recommended on 26th January 2021</p>
                                <h5 class="fw-normal text-gradient">"This was one of the most fun pieces of starting a new business. I would highly recommend Maxartkiller for creative products and custom designs."</h5>
                            </div>
                        </div>
                        <br>
                        <div class="row mb-4">
                            <div class="col-auto">
                                <figure class="avatar-60 avatar rounded-circle coverimg">
                                    <img src="assets/img/user-4.jpg" alt="" />
                                </figure>
                            </div>
                            <div class="col">
                                <h6 class="mb-1">Thilakh Shivsainak </h6>
                                <p class="text-secondary">Customer of Products from Maxartkller in 2020-2022. Recommended on 12th December 2021</p>
                                <h5 class="fw-normal text-gradient">"completely overwhelmed by this service. We cant wait for my next project done!. Money well spent creating my business application, the whole users bunch and my team love it! well done!"</h5>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="container-fluid footer-page mt-4 py-5">
        <div class="row mb-5">
            <div class="col-12 col-xxl-11 mx-auto">
                <div class="row">
                    <div class="col-12 col-xxl-4 mb-5 mb-xxl-0">
                        <h2 class="mb-3"><span class="text-gradient">#1 Creative</span> &<br /><span class="text-gradient">Multipurpose</span> HTML Template</h2>
                        <h5 class="mb-4">Clean & Trending UI design with<br />a great user experience</h5>
                        <p class="text-secondary">WinDOORS is creative and multipurpose template. You can use it for CRM, Business application, Intranet Application, Portal service and Many more.
                            It comes with unlimited possibilities and 10+ predefined styles which you can also mix up and create new style. Do support and spread a word for us. </p>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-xxl-2 ms-xxl-auto mb-5 mb-md-0">
                        <h5 class="mb-3">Main <span class="text-gradient">Dashboards</span></h5>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link px-0" href="finance-dashboard.html">Finance</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-0" href="network-dashboard.html">Network</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-0" href="inventory-dashboard.html">Inventory</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-0" href="social-dashboard.html">Social</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-0" href="project-dashboard.html">Project</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-0" href="learning-dashboard.html">Learning</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-xxl-2 mb-5 mb-md-0">
                        <h5 class="mb-3">Creative <span class="text-gradient">Pages</span></h5>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link px-0" href="app-calendar.html">Calendar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-0" href="app-email.html">Email</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-0" href="app-explorer.html">Explorer</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-0" href="app-support.html">We need Support <i class="bi bi-heart-fill text-red"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-0" href="app-pricing.html" target="_blank">Buy Now <i class="bi bi-arrow-up-right-square"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-4 col-xxl-3">
                        <a class="navbar-brand d-block mb-3" href="../getwindoors_default.html" target="_blank">
                            <div class="row">
                                <div class="col-auto"><img src="assets/img/favicon48.png" class="mx-100" alt="" /></div>
                                <div class="col ps-0 align-self-center d-none d-sm-block">
                                    <h4 class="fw-normal text-dark mb-0">WinDOORS</h4>
                                    <p class="text-secondary">Admin App UI</p>
                                </div>
                            </div>
                        </a>

                        <p class="mb-2"><b>Main office:</b></p>
                        <p class="mb-1"><a href="../getwindoors_default.html" target="_blank">www.getWinDOORS.com</a></p>
                        <p class="mb-4 text-secondary">Test data 103909 Witamer CR, Niagara Falls, NY 14305, United States</p>

                        <div class="row align-items-center mb-3">
                            <div class="col-auto"><i class="bi bi-clock text-theme"></i></div>
                            <div class="col ps-0">0441-215-518625<br /><span class="text-secondary">Mon - Sat, 9:00 am - 10:00pm</span></div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-auto"><i class="bi bi-telephone text-theme"></i></div>
                            <div class="col ps-0">+1-000 000 100000</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-xxl-11 mx-auto">
                <div class="row align-items-center">
                    <div class="col-12 col-md-auto mb-4 mb-md-0">
                        <ul class="nav justify-content-center">
                            <li class="nav-item">
                                <a class="nav-link text-secondary" href="https://www.facebook.com/maxartkiller/" target="_blank">
                                    <i class="bi bi-facebook h5"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-secondary" href="https://twitter.com/maxartkiller" target="_blank">
                                    <i class="bi bi-twitter h5"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-secondary" href="https://linkedin.com/company/maxartkiller" target="_blank">
                                    <i class="bi bi-linkedin h5"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-secondary" href="https://www.instagram.com/maxartkiller/" target="_blank">
                                    <i class="bi bi-instagram h5"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-secondary" href="https://www.youtube.com/get-windoors/" target="_blank">
                                    <i class="bi bi-youtube h5"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-auto ms-auto">
                        <ul class="nav justify-content-center">
                            <li class="nav-item">
                                <a class="nav-link" href="profile.html#">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <i class="bi bi-microsoft h4 text-secondary"></i>
                                        </div>
                                        <div class="col ps-0">
                                            <p class="mb-0 small text-secondary">Get this on</p>
                                            <p>Microsoft Store</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="profile.html#">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <i class="bi bi-play-fill h3 text-secondary"></i>
                                        </div>
                                        <div class="col ps-0">
                                            <p class="mb-0 small text-secondary">Get this on</p>
                                            <p>Google Play</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="profile.html#">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <i class="bi bi-apple h4 text-secondary"></i>
                                        </div>
                                        <div class="col ps-0">
                                            <p class="mb-0 small text-secondary">Get this on</p>
                                            <p>App Store</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>