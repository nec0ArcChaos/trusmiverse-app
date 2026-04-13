<main class="main mainheight">
  <!-- Breadcrumb -->
  <div class="container-fluid">
    <div class="row">
      <nav aria-label="breadcrumb" class="py-2">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>">My Dashboard</a></li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- Toolbar Filter (tanpa background) -->
  <div class="container">
    <div class="card border-0 shadow-sm mt-3">
      <div class="card-body">
        <div class="row g-3 align-items-end">
          <?php
            $allowed_akses = ['2063','1','979'];
            $class_none = "d-none";
            $col = "col-lg-2 col-md-3";
            $user_id = $this->session->userdata("user_id");
            if (in_array($user_id,$allowed_akses)) { $class_none=""; $col="col-lg-2 col-md-3"; }
          ?>
          <div class="col-12 col-md-3 <?= $class_none; ?>">
            <label class="form-label <?= $class_none; ?>">Employee Name</label>
            <select id="employee_id" name="employee_id" class="wide text-dark <?= $class_none; ?>"></select>
          </div>

          <div class="col-6 col-md-3">
            <label class="form-label">Month</label>
            <select id="month" name="month" class="wide text-dark">
              <option value="01" <?= date("m")=='01'?'selected':''; ?>>Januari</option>
              <option value="02" <?= date("m")=='02'?'selected':''; ?>>Februari</option>
              <option value="03" <?= date("m")=='03'?'selected':''; ?>>Maret</option>
              <option value="04" <?= date("m")=='04'?'selected':''; ?>>April</option>
              <option value="05" <?= date("m")=='05'?'selected':''; ?>>Mei</option>
              <option value="06" <?= date("m")=='06'?'selected':''; ?>>Juni</option>
              <option value="07" <?= date("m")=='07'?'selected':''; ?>>Juli</option>
              <option value="08" <?= date("m")=='08'?'selected':''; ?>>Agustus</option>
              <option value="09" <?= date("m")=='09'?'selected':''; ?>>September</option>
              <option value="10" <?= date("m")=='10'?'selected':''; ?>>Oktober</option>
              <option value="11" <?= date("m")=='11'?'selected':''; ?>>November</option>
              <option value="12" <?= date("m")=='12'?'selected':''; ?>>Desember</option>
            </select>
          </div>

          <div class="col-6 <?= $col ?>">
            <label class="form-label">Year</label>
            <select id="year" name="year" class="wide text-dark">
              <?php for($i=date("Y")+1;$i>=2018;$i--){ ?>
                <option value="<?= $i ?>" <?= date("Y")==$i?'selected':''; ?>><?= $i ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="col-6 col-md-2 <?= $class_none; ?>">
            <label class="form-label <?= $class_none; ?>">Cutoff</label>
            <select id="cutoff" name="cutoff" class="wide text-dark <?= $class_none; ?>">
              <option value="1" <?= $this->session->userdata('cutoff')=='1'?'selected':''; ?>>21-20</option>
              <option value="2" <?= $this->session->userdata('cutoff')=='2'?'selected':''; ?>>16-15</option>
              <option value="3" <?= $this->session->userdata('cutoff')=='3'?'selected':''; ?>>01-<?= date("t") ?></option>
            </select>
          </div>

          <div class="col-6 col-md-2">
            <label class="form-label d-block">&nbsp;</label>
            <button id="filter" onclick="filter_detail()" class="button-4 w-100" type="button">
              <i class="fa fa-search"></i> Show
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- KPI Cards -->
  <div class="container mt-3">
    <div class="row g-3 text-center">
      <div class="col-6 col-md-4 col-lg-2">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body">
            <p class="text-muted small mb-1">Total</p>
            <h3 id="harus_hadir" class="mb-0">-</h3>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body">
            <p class="text-muted small mb-1">Presence</p>
            <a role="button" data-bs-toggle="modal" data-bs-target="#modal_detail_absen">
              <u><h3 id="present" class="mb-0">-</h3></u>
            </a>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body">
            <p class="text-muted small mb-1">Absence</p>
            <h3 id="bolos" class="mb-0">-</h3>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body">
            <p class="text-muted small mb-1">Leave</p>
            <h3 id="leave" class="mb-0">-</h3>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body">
            <p class="text-muted small mb-1">Warning Lock</p>
            <h3 id="warning" class="mb-0">-</h3>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body">
            <p class="text-muted small mb-1">Late</p>
            <h3 id="late" class="mb-0">-</h3>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-3 mt-1">
      <div class="col-6 col-lg-3">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body text-center">
            <p class="text-muted small mb-1">Kehadiran</p>
            <h3 class="mb-0"><span id="kehadiran"></span>%</h3>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body text-center">
            <p class="text-muted small mb-1">Kedisiplinan</p>
            <h3 class="mb-0"><span id="kedisiplinan"></span>%</h3>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-6 d-flex align-items-center justify-content-end">
        <div class="btn-group">
          <a href="<?= base_url(); ?>hr/rekap_absen" class="btn btn-outline-secondary">
            <i class="bi bi-calendar vm me-1"></i> Rekap Absen
          </a>
          <a href="<?= base_url(); ?>leave" class="btn btn-primary">
            <i class="bi bi-person-plus vm me-1"></i> Izin / Cuti
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Profile + Detail (layout baru 2 kolom) -->
  <div class="container mt-4">
    <div class="row g-4">
      <!-- LEFT: Profile/Divisi/Rekening -->
      <div class="col-12 col-lg-4">
        <!-- Profile card -->
        <div class="card border-0 shadow-sm mb-3">
          <div class="card-body d-flex align-items-center">
            <figure class="avatar avatar-100 rounded-circle me-3 border">
              <img src="https://trusmiverse.com/hr/uploads/profile/<?= $personal_info->profile_picture; ?>" alt="" />
            </figure>
            <div>
              <h5 class="mb-1">
                <?= $this->session->userdata("nama"); ?>
                <span class="badge bg-success-subtle text-success ms-1 fs-12">
                  <i class="bi bi-check-circle me-1"></i>Online
                </span>
              </h5>
              <p class="mb-2 text-muted small">
                <i class="bi bi-briefcase me-1"></i><?= $personal_info->department_name; ?>, <?= $personal_info->company_name; ?>
              </p>
              <div class="d-flex flex-wrap gap-2">
                <span class="badge bg-light text-dark"><i class="bi bi-telephone me-1"></i><?= $personal_info->contact_no; ?></span>
                <span class="badge bg-light text-dark"><i class="bi bi-envelope me-1"></i><?= $personal_info->email; ?></span>
                <a role="button" class="badge bg-warning text-dark" data-bs-toggle="modal" data-bs-target="#modal_ttd">
                  <i class="fa-solid fa-signature me-1"></i> Upload Tanda Tangan
                </a>
              </div>
            </div>
            <button class="btn btn-outline-secondary btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#modal_change_profile_picture">
              <i class="bi bi-camera"></i>
            </button>
          </div>
        </div>

        <!-- Divisi -->
        <div class="card border-0 shadow-sm mb-3">
          <div class="card-body">
            <div class="d-flex">
              <figure class="avatar avatar-40 rounded-circle bg-light text-secondary me-2">
                <i class="bi bi-star vm"></i>
              </figure>
              <div class="flex-grow-1">
                <h6 class="mb-0"><?= $personal_info->department_name; ?></h6>
                <p class="mb-2 text-muted small"><?= $personal_info->designation_name; ?></p>
                <div class="d-flex justify-content-between">
                  <span class="small"><?= $personal_info->date_of_joining; ?></span>
                  <span class="small text-muted"><?= $personal_info->masa_kerja; ?></span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Rekening -->
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white">
            <div class="d-flex align-items-center">
              <i class="bi bi-cash h5 me-2"></i>
              <div class="flex-grow-1">
                <h6 class="mb-0">Rekening Payroll</h6>
                <p class="small text-secondary mb-0">Kartu ATM</p>
              </div>
              <a class="btn btn-link text-secondary" data-bs-toggle="modal" data-bs-target="#modal_change_rekening"><i class="bi bi-pencil-square"></i></a>
              <a class="btn btn-link text-secondary" data-bs-toggle="modal" data-bs-target="#modal_change_pin_slip"><i class="bi bi-person-lock"></i></a>
            </div>
          </div>
          <div class="card-body">
            <!-- pakai konten swiper asli agar JS tetap jalan -->
            <div class="swiper-container creditcardsvertical swiper-cards">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <div class="card border-0 shadow-sm" id="atm-card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between mb-3">
                        <span>ATM</span>
                        <p class="size-12 mb-0 text-end">
                          <span class="text-muted small" id="p_bank_name">Bank</span>
                        </p>
                      </div>
                      <p class="fw-medium h6 mb-3" id="p_account_number">Belum mengisi rekening</p>
                      <div class="d-flex justify-content-between">
                        <div class="size-12">
                          <p class="mb-0 text-muted small">Created At</p>
                          <p id="p_created_at">-</p>
                        </div>
                        <div class="text-end size-12">
                          <p class="mb-0 text-muted small">Card Holder</p>
                          <p id="p_account_title">-</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- slide dummy lain tetap bisa ditambahkan bila perlu -->
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT: Personal Details + Tabs -->
      <div class="col-12 col-lg-8">
        <!-- Tabs -->
        <div class="card border-0 shadow-sm mb-3">
          <div class="card-body">
            <nav class="nav nav-pills">
              <a class="nav-link active-4" role="button" id="btn_personal_details">Personal Details</a>
              <a class="nav-link" role="button" id="btn_history_warning">History Warning Lock</a>
              <a class="nav-link" role="button" id="btn_e_training">E - Training</a>
            </nav>
          </div>
        </div>

        <!-- Personal Details Card -->
        <div class="card border-0 shadow-sm" id="container_personal_details">
          <div class="card-header bg-white">
            <div class="d-flex align-items-center">
              <i class="bi bi-person-circle h5 me-2"></i>
              <div class="flex-grow-1">
                <h6 class="mb-0">Personal Info</h6>
                <p class="text-secondary small mb-0">Tentang Anda</p>
              </div>
              <a class="btn btn-link text-secondary" data-bs-toggle="modal" data-bs-target="#modal_change_personal_info"><i class="bi bi-pencil-square"></i></a>
              <a class="btn btn-link text-secondary" data-bs-toggle="modal" data-bs-target="#modal_change_password"><i class="bi bi-person-lock"></i></a>
            </div>
          </div>
          <div class="card-body">
            <div class="row gy-3">
              <div class="col-12 col-md-6 d-flex">
                <i class="bi bi-person-fill-check h5 me-3 text-secondary"></i>
                <div>
                  <p class="text-secondary small mb-1">NIK</p>
                  <p class="mb-0"><?= $personal_info->employee_id; ?></p>
                </div>
              </div>
              <div class="col-12 col-md-6 d-flex">
                <i class="bi bi-telephone h5 me-3 text-secondary"></i>
                <div>
                  <p class="text-secondary small mb-1">Phone</p>
                  <p class="mb-0"><?= $personal_info->contact_no; ?></p>
                </div>
              </div>
              <div class="col-12 col-md-6 d-flex">
                <i class="bi bi-whatsapp h5 me-3 text-secondary"></i>
                <div>
                  <p class="text-secondary small mb-1">Whatsapp Notification</p>
                  <?php if ($personal_info->registered == 0) { ?>
                    <a class="badge bg-success text-white" target="_blank" href="https://api.whatsapp.com/send/?phone=6288971936684&amp;text=/TG">Register Notif Whatsapp <i class="bi bi-whatsapp"></i></a>
                  <?php } else { ?>
                    <span class="badge bg-success text-white">Registered</span>
                  <?php } ?>
                </div>
              </div>
              <div class="col-12 col-md-6 d-flex">
                <i class="bi bi-envelope h5 me-3 text-secondary"></i>
                <div>
                  <p class="text-secondary small mb-1">Email Address</p>
                  <p class="mb-0"><?= $personal_info->email; ?></p>
                </div>
              </div>
              <div class="col-12 col-md-6 d-flex">
                <i class="bi bi-envelope-check h5 me-3 text-secondary"></i>
                <div>
                  <p class="text-secondary small mb-1">Email Corporate</p>
                  <p class="mb-0"><?= $personal_info->email_corporate; ?></p>
                </div>
              </div>
              <div class="col-12 col-md-6 d-flex">
                <i class="bi bi-calendar2-heart h5 me-3 text-secondary"></i>
                <div>
                  <p class="text-secondary small mb-1">Birthday</p>
                  <p class="mb-0"><?= $personal_info->date_of_birth_text; ?></p>
                </div>
              </div>
              <div class="col-12 col-md-6 d-flex">
                <i class="bi bi-gender-ambiguous h5 me-3 text-secondary"></i>
                <div>
                  <p class="text-secondary small mb-1">Genders</p>
                  <p class="mb-0"><?= $personal_info->gender; ?></p>
                </div>
              </div>
              <div class="col-12 col-md-6 d-flex">
                <i class="bi bi-pen h5 me-3 text-secondary"></i>
                <div>
                  <p class="text-secondary small mb-1">Tanda Tangan digital</p>
                  <a href="#" data-bs-toggle="modal" data-bs-target="#modal_ttd">Assign Ttd</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Section kontainer lain tetap dipakai id aslinya -->
        <div class="mt-3" id="container_manage_leave"></div>
        <div class="mt-3" id="container_history_warning"></div>
        <div class="mt-3" id="container_e_training"></div>
      </div>
    </div>
  </div>

  <?php $this->load->view('layout/_footer'); ?>
</main>
