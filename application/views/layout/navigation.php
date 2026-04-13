<div class="row mb-4">
    <div class="col-12 px-0">
        <ul class="nav nav-pills">
            <!-- <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?= base_url('dashboard'); ?>">
                    <div class="avatar avatar-40 icon"><i class="bi bi-house-door"></i></div>
                    <div class="col">Dashboard</div>
                    <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                </a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?= base_url('dashboard'); ?>">
                    <div class="avatar avatar-40 icon"><i class="bi bi-house"></i></div>
                    <div class="col">Dashboard</div>
                    <!-- <div class="arrow"><i class="bi bi-chevron-right"></i></div> -->
                </a>
            </li>
            <?php if ($this->session->userdata("designation_id") == 907 || in_array($this->session->userdata('user_id'), array(1, 323, 979, 78, 1139, 61, 62, 63, 64, 1161, 2041, 2063, 2070, 68, 321, 2735, 2307))) { ?>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?= base_url('rsp_tasklist_helper_project_afs'); ?>">
                        <div class="avatar avatar-40 icon"><i class="bi bi-hammer"></i></div>
                        <div class="col">Tasklist Aftersales</div>
                    </a>
                </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?= base_url('trusmi_approval'); ?>">
                    <div class="avatar avatar-40 icon"><i class="bi bi-clock-history"></i></div>
                    <div class="col">T-Approval</div>
                    <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                </a>
            </li>
            <li class="nav-item">
                <?php if (in_array($this->session->userdata('user_id'), array(1, 323, 979, 78, 1139, 61, 62, 63, 64, 1161, 2041, 2063, 2070, 68, 321, 2735, 2307, 8635, 341, 847, 767, 3013))) { ?>
                    <a class="nav-link active" aria-current="page" href="<?= base_url('trusmi_lock'); ?>">
                        <div class="avatar avatar-40 icon"><i class="bi bi-key"></i></div>
                        <div class="col">T-Lock</div>
                        <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>
                <?php } ?>
            </li>
            <!-- User IT -->
            <!-- 61 Anggi -->
            <!-- 62 Lutfi -->
            <!-- 63 Said -->
            <!-- 64 Lutfiedadi -->
            <!-- 1161 Fujiyanto -->
            <!-- 2041 Faisal -->
            <!-- 2063 Aris -->
            <!-- 2070 Kania -->
            <!-- 2969 Ari Fadzri -->
            <?php $user_it = array(1, 61, 62, 323, 979, 63, 64, 1161, 2041, 2063, 2969, 2969, 2070, 2903); ?>
            <?php $level = array(1, 2, 3, 4, 5, 10); ?>
            <?php if (in_array($this->session->userdata('user_id'), $user_it)) { ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= base_url('trusmi_history'); ?>">
                        <div class="avatar avatar-40 icon"><i class="bi bi-journal-bookmark-fill"></i></div>
                        <div class="col">T-History</div>
                        <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>
                </li>

            <?php } ?>

            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?= base_url('trusmi_resignation'); ?>">
                    <div class="avatar avatar-40 icon"><i class="bi bi-box-arrow-right"></i></div>
                    <div class="col">T-Resignation</div>
                    <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?= base_url('trusmi_masa_kerja'); ?>">
                    <div class="avatar avatar-40 icon"><i class="bi bi-hourglass-split"></i></div>
                    <div class="col">T-Masa Kerja</div>
                    <!-- <div class="arrow"><i class="bi bi-chevron-right"></i></div> -->
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?= base_url('hr/rekap_absen'); ?>">
                    <div class="avatar avatar-40 icon"><i class="bi bi-calendar4-range"></i></div>
                    <div class="col">Monthly Timesheet</div>
                    <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                </a>
            </li>
            <?php if (in_array($this->session->userdata('user_id'), $user_it)) { ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= base_url('hr/resume_izin'); ?>">
                        <div class="avatar avatar-40 icon"><i class="bi bi-calendar-event"></i></div>
                        <div class="col">Resume Izin</div>
                        <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>
                </li>

            <?php } ?>
            <?php if (in_array($this->session->userdata('user_id'), $user_it) || in_array($this->session->userdata('user_role_id'), $level)) { ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= base_url('hr/promotion'); ?>">
                        <div class="avatar avatar-40 icon"><i class="bi bi-capslock-fill"></i></div>
                        <div class="col">Perubahan Jabatan</div>
                        <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                    </a>
                </li>
            <?php } ?>

            <!-- User Role Super Admin & Rekrutmen -->
            <!-- <?php $role = array(1, 11); ?> -->
            <!-- Department HR RSP, HR Batik dan HR RSP Kendal -->
            <?php $department = array(72, 73, 156); ?>
            <?php if (in_array($this->session->userdata('user_id'), $user_it) || in_array($this->session->userdata('department_id'), $department)) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="false" data-bs-display="static" href="javascript:void(0)" role="button" aria-expanded="false">
                        <div class="avatar avatar-40 icon"><i class="bi bi-person-add"></i></div>
                        <div class="col">T-Recruitment</div>
                        <div class="arrow"><i class="bi bi-chevron-down plus"></i> <i class="bi bi-chevron-up minus"></i>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item nav-link" href="<?= base_url('trusmi_recruitment'); ?>">
                                <div class="avatar avatar-40 icon"><i class="bi bi-speedometer2"></i>
                                </div>
                                <div class="col align-self-center">Dashboard Recruitment</div>
                                <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                            </a>
                        </li>
                    </ul>
                </li>

                <?php if (in_array($this->session->userdata('department_id'), $role)) { ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= base_url('trusmi_blast'); ?>">
                            <div class="avatar avatar-40 icon"><i class="bi bi-whatsapp"></i></div>
                            <div class="col">WhatsApp Blast</div>
                            <!-- <div class="arrow"><i class="bi bi-chevron-right"></i></div> -->
                        </a>
                    </li>
                <?php } ?>



            <?php } ?>

            <!-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="false" data-bs-display="static" href="home.html#" role="button" aria-expanded="false">
                    <div class="avatar avatar-40 icon"><i class="bi bi-coin"></i></div>
                    <div class="col">Finance</div>
                    <div class="arrow"><i class="bi bi-chevron-down plus"></i> <i class="bi bi-chevron-up minus"></i>
                    </div>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item nav-link" href="finance-dashboard.html">
                            <div class="avatar avatar-40 icon"><i class="bi bi-speedometer2"></i>
                            </div>
                            <div class="col align-self-center">Finance Dashboard</div>
                            <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item nav-link" href="finance-crypto.html">
                            <div class="avatar avatar-40 icon"><i class="bi bi-currency-bitcoin"></i>
                            </div>
                            <div class="col align-self-center">Crypto</div>
                            <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item nav-link" href="finance-banks.html">
                            <div class="avatar avatar-40 icon"><i class="bi bi-bank"></i>
                            </div>
                            <div class="col align-self-center">Banks</div>
                            <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item nav-link" href="finance-wallet.html">
                            <div class="avatar avatar-40 icon"><i class="bi bi-wallet2"></i>
                            </div>
                            <div class="col align-self-center">Wallet</div>
                            <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item nav-link" href="finance-rewards.html">
                            <div class="avatar avatar-40 icon"><i class="bi bi-award"></i>
                            </div>
                            <div class="col align-self-center">Rewards</div>
                            <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                        </a>
                    </li>
                </ul>
            </li> -->
        </ul>
    </div>
</div>