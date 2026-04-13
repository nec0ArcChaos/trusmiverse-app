<main class="main mainheight">
    <style>
        .custom-btn {
            font-size: small;
            border: 0;
        }
    </style>
    <div class="container-fluid mb-4">
        <form action="<?= site_url('dashboard_mpp/index'); ?>">
            <div class="row align-items-center page-title">
                <div class="col col-md mb-2 mb-sm-0">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="input-group input-group-lg">
                            <?php //$accessable = array(1, 979, 323, 1161, 778, 2765, 2378, 5684, 5840); 
                            ?>
                            <?php //if (in_array($this->session->userdata('user_id'), $accessable)) { 
                            ?>
                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-building"></i></span>
                            <div class="form-floating">
                                <select name="company" id="company" class="form-control border-start-0">
                                    <option value="0">All Companies</option>
                                    <?php foreach ($get_company as $cmp) : ?>
                                        <option value="<?php echo $cmp->company_id ?>"><?php echo $cmp->company ?></option>
                                    <?php endforeach ?>
                                </select>
                                <label>Company</label>
                            </div>
                            <?php //} 
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col col-md mb-2 mb-sm-0">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="input-group input-group-lg">
                            <?php //if (in_array($this->session->userdata('user_id'), $accessable)) { 
                            ?>
                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-rolodex"></i></span>
                            <div class="form-floating">
                                <select name="department" id="department" class="form-control border-start-0">
                                    <option value="0">All Departments</option>
                                </select>
                                <label>Department</label>
                            </div>
                            <?php //} 
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col col-md mb-2 mb-sm-0">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="input-group input-group-lg">
                            <?php //if (in_array($this->session->userdata('user_id'), $accessable)) { 
                            ?>
                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-rolodex"></i></span>
                            <div class="form-floating">
                                
                                <label>Periode</label>
                            </div>
                            <?php //} 
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col col-md mb-2 mb-sm-0">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="input-group input-group-lg">
                            <?php //if (in_array($this->session->userdata('user_id'), $accessable)) { 
                            ?>
                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-rolodex"></i></span>
                            <div class="form-floating">
                                <select name="week" id="week" class="form-control border-start-0">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>

                                </select>
                                <label>Week</label>
                            </div>
                            <?php //} 
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1 col-md mb-2 mb-sm-0">
                    <button class="btn btn-primary" id="btn_filter" style="width: 100%;" data-toggle="tooltip" data-placement="top" title="Tooltip on top">Filter</button>
                    <!-- <span class="btn btn-primary" id="btn_filter" style="width: 100%;" data-toggle="tooltip" data-placement="top" title="Tooltip on top">Filter</span> -->
                </div>
                <div class="col-auto ps-0">

                </div>
            </div>

            <div class="row">
                <?php
                $accessable = array(5840);
                ?>
                <?php if (in_array($this->session->userdata('user_id'), $accessable)) { ?>
                    <div class="col-4">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-building"></i></span>
                                <div class="form-floating">
                                    <select name="company_test" id="company_test" class="form-control border-start-0">
                                        <option value="0">All Companies</option>
                                        <?php foreach ($get_company as $cmp) : ?>
                                            <option value="<?php echo $cmp->company_id ?>"><?php echo $cmp->company ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <label>Company</label>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </form>
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
                            <i class="bi bi-calendar4-range h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0"><?= $pageTitle; ?></h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="fw-medium mb-2 text-center"><?= $company_name ?> - <?= $department_name ?></h6>
                    <?php //var_dump($company->name); 
                    ?>
                    <div class="table-responsive" style="padding: 10px;" id="table_jumlah_karyawan">
                        <table id="dt_jumlah_karyawan" class="table table-md table-striped table-bordered nowrap text-center" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Jumlah</th>
                                    <th>%</th>
                                    <th>Jenis</th>
                                    <th>Jumlah</th>
                                    <th>%</th>
                                    <th>Kategori Level</th>
                                    <th>Jumlah</th>
                                    <th>%</th>
                                    <th>Level</th>
                                    <th>Jumlah</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <?php
                            $jumlah_all_cat_level = $leader_below_kartap + $leader_up_kartap + $leader_below_reguler_kontrak + $leader_up_reguler_kontrak + $leader_below_non_kontrak + $leader_up_non_kontrak + $leader_below_perjanjian + $leader_up_perjanjian;

                            $jumlah_all_level = $kartap_staff + $kartap_officer + $kartap_spv + $kartap_manager + $kartap_head + $kartap_direktur + $kontrak_helper + $kontrak_staff + $kontrak_officer + $kontrak_supervisor + $kontrak_manager + $kontrak_head + $kontrak_direktur + $non_kontrak_staff + $non_kontrak_helper + $non_kontrak_officer + $non_kontrak_supervisor + $non_kontrak_manager + $non_kontrak_head + $non_kontrak_direktur + $perjanjian_helper + $perjanjian_staff + $perjanjian_officer + $perjanjian_supervisor + $perjanjian_manager;

                            $company_id = 0;
                            $department_id = 0;
                            if (isset($_GET['company'])) {
                                $company_id = $_GET['company'];
                                $department_id = $_GET['department'];
                            }
                            ?>
                            <tbody>
                                <!-- KARTAP -->
                                <tr>
                                    <td>Karyawan Tetap</td>
                                    <td><button class="badge bg-green custom-btn" onclick="list_karyawan(1, '', '', <?= $company_id ?>, <?= $department_id ?>)"><?= $jumlah_kartap ?></button></td>
                                    <td><?= number_format($jumlah_kartap / ($jumlah_kartap + $jumlah_kontrak_all + $jumlah_non_kontrak + $jumlah_perjanjian) * 100, 2); ?></td>
                                    <td>Reguler</td>
                                    <td><button class="badge bg-green  custom-btn" onclick="list_karyawan(1, '', '', <?= $company_id ?>, <?= $department_id ?>)"><?= $jumlah_kartap ?></button></td>
                                    <td><?= number_format($jumlah_kartap / ($jumlah_kartap + $jumlah_kontrak_all + $jumlah_non_kontrak + $jumlah_perjanjian) * 100, 2); ?></td>
                                    <td>Leader Below</td>
                                    <td><button class="badge bg-green  custom-btn" onclick="list_karyawan(1, 'below', '', <?= $company_id ?>, <?= $department_id ?>)"><?= $leader_below_kartap; ?></button></td>
                                    <td><?= number_format($leader_below_kartap / ($jumlah_all_cat_level) * 100, 2); ?></td>
                                    <td>Staff</td>
                                    <td><button class="badge bg-green custom-btn" onclick="list_karyawan(1, '', 'Staff', <?= $company_id ?>, <?= $department_id ?>)"><?= $kartap_staff; ?></button></td>
                                    <td><?= number_format($kartap_staff / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="9"></td>
                                    <td>Officer</td>
                                    <td><button class="badge bg-green custom-btn" onclick="list_karyawan(1, '', 'Officer', <?= $company_id ?>, <?= $department_id ?>)"><?= $kartap_officer; ?></button></td>
                                    <td><?= number_format($kartap_officer / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="6"></td>
                                    <td>Leader Up</td>
                                    <td>
                                        <button class="badge bg-green  custom-btn" onclick="list_karyawan(1, 'up', '', <?= $company_id ?>, <?= $department_id ?>)"><?= $leader_up_kartap; ?></button>
                                    </td>
                                    <td><?= number_format($leader_up_kartap / ($jumlah_all_cat_level) * 100, 2); ?></td>
                                    <td>Supervisor</td>
                                    <td>
                                        <button class="badge bg-green  custom-btn" onclick="list_karyawan(1, '', 'Supervisor', <?= $company_id ?>, <?= $department_id ?>)"><?= $kartap_spv; ?></button>
                                    </td>
                                    <td><?= number_format($kartap_spv / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="9"></td>
                                    <td>Manager</td>
                                    <td>
                                        <button class="badge bg-green  custom-btn" onclick="list_karyawan(1, '', 'Manager', <?= $company_id ?>, <?= $department_id ?>)"><?= $kartap_manager; ?></button>
                                    </td>
                                    <td><?= number_format($kartap_manager / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="9"></td>
                                    <td>Head</td>
                                    <td>
                                        <button class="badge bg-green  custom-btn" onclick="list_karyawan(1, '', 'Head', <?= $company_id ?>, <?= $department_id ?>)"><?= $kartap_head; ?></button>
                                    </td>
                                    <td><?= number_format($kartap_head / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="9"></td>
                                    <td>Direktur</td>
                                    <td>
                                        <button class="badge bg-green  custom-btn" onclick="list_karyawan(1, '', 'Direktur', <?= $company_id ?>, <?= $department_id ?>)"><?= $kartap_direktur; ?></button>
                                    </td>
                                    <td><?= number_format($kartap_direktur / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <!-- END KARTAP -->

                                <!-- KONTRAK -->
                                <tr>
                                    <td>Kontrak</td>
                                    <td>
                                        <button class="badge bg-primary custom-btn" onclick="list_karyawan(2, '', '', <?= $company_id ?>, <?= $department_id ?>)"><?= $jumlah_kontrak_all ?></button>
                                    </td>
                                    <td><?= number_format($jumlah_kontrak_all / ($jumlah_kartap + $jumlah_kontrak_all + $jumlah_non_kontrak + $jumlah_perjanjian) * 100, 2); ?></td>
                                    <td>Reguler</td>
                                    <td>
                                        <button class="badge bg-primary custom-btn" onclick="list_karyawan(2, '', '', <?= $company_id ?>, <?= $department_id ?>)"><?= $jumlah_kontrak_all ?></button>
                                    </td>
                                    <td><?= number_format($jumlah_kontrak_all / ($jumlah_kartap + $jumlah_kontrak_all + $jumlah_non_kontrak + $jumlah_perjanjian) * 100, 2); ?></td>
                                    <td>Leader Below</td>
                                    <td>
                                        <button class="badge bg-primary custom-btn" onclick="list_karyawan(2, 'below', '', <?= $company_id ?>, <?= $department_id ?>)"><?= $leader_below_reguler_kontrak; ?></button>
                                    </td>
                                    <td><?= number_format($leader_below_reguler_kontrak / ($jumlah_all_cat_level) * 100, 2); ?></td>
                                    <td>Helper</td>
                                    <td>
                                        <button class="badge bg-primary custom-btn" onclick="list_karyawan(2, '', 'Helper', <?= $company_id ?>, <?= $department_id ?>)"><?= $kontrak_helper; ?></button>
                                    </td>
                                    <td><?= number_format($kontrak_helper / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="9"></td>
                                    <td>Staff</td>
                                    <td>
                                        <button class="badge bg-primary custom-btn" onclick="list_karyawan(2, '', 'Staff', <?= $company_id ?>, <?= $department_id ?>)"><?= $kontrak_staff; ?></button>
                                    </td>
                                    <td><?= number_format($kontrak_staff / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="9"></td>
                                    <td>Officer</td>
                                    <td>
                                        <button class="badge bg-primary custom-btn" onclick="list_karyawan(2, '', 'Officer', <?= $company_id ?>, <?= $department_id ?>)"><?= $kontrak_officer; ?></button>
                                    </td>
                                    <td><?= number_format($kontrak_officer / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="6"></td>
                                    <td>Leader Up</td>
                                    <td>
                                        <button class="badge bg-primary custom-btn" onclick="list_karyawan(2, 'up', '', <?= $company_id ?>, <?= $department_id ?>)"><?= $leader_up_reguler_kontrak; ?></button>
                                    </td>
                                    <td><?= number_format($leader_up_reguler_kontrak / ($jumlah_all_cat_level) * 100, 2); ?></td>
                                    <td>Supervisor</td>
                                    <td>
                                        <button class="badge bg-primary custom-btn" onclick="list_karyawan(2, '', 'Supervisor', <?= $company_id ?>, <?= $department_id ?>)"><?= $kontrak_supervisor; ?></button>
                                    </td>
                                    <td><?= number_format($kontrak_supervisor / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="9"></td>
                                    <td>Manager</td>
                                    <td>
                                        <button class="badge bg-primary custom-btn" onclick="list_karyawan(2, '', 'Manager', <?= $company_id ?>, <?= $department_id ?>)"><?= $kontrak_manager; ?></button>
                                    </td>
                                    <td><?= number_format($kontrak_manager / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="9"></td>
                                    <td>Head</td>
                                    <td>
                                        <button class="badge bg-primary custom-btn" onclick="list_karyawan(2, '', 'Head', <?= $company_id ?>, <?= $department_id ?>)"><?= $kontrak_head; ?></button>
                                    </td>
                                    <td><?= number_format($kontrak_head / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="9"></td>
                                    <td>Direktur</td>
                                    <td>
                                        <button class="badge bg-primary custom-btn" onclick="list_karyawan(2, '', 'Direktur', <?= $company_id ?>, <?= $department_id ?>)"><?= $kontrak_direktur; ?></button>
                                    </td>
                                    <td><?= number_format($kontrak_direktur / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <!-- END KONTRAK -->

                                <!-- NON KONTRAK -->
                                <tr>
                                    <td>Non Kontrak</td>
                                    <td>
                                        <button class="badge bg-warning custom-btn" onclick="list_karyawan(3, '', '', <?= $company_id ?>, <?= $department_id ?>)"><?= $jumlah_non_kontrak; ?></button>
                                    </td>
                                    <td><?= number_format($jumlah_non_kontrak / ($jumlah_kartap + $jumlah_kontrak_all + $jumlah_non_kontrak + $jumlah_perjanjian) * 100, 2); ?></td>
                                    <td>Non Reguler</td>
                                    <td>
                                        <button class="badge bg-warning custom-btn" onclick="list_karyawan(3, '', '', <?= $company_id ?>, <?= $department_id ?>)"><?= $jumlah_non_kontrak; ?></button>
                                    </td>
                                    <td><?= number_format($jumlah_non_kontrak / ($jumlah_kartap + $jumlah_kontrak_all + $jumlah_non_kontrak + $jumlah_perjanjian) * 100, 2); ?></td>
                                    <td>Leader Below</td>
                                    <td>
                                        <button class="badge bg-warning custom-btn" onclick="list_karyawan(3, 'below', '', <?= $company_id ?>, <?= $department_id ?>)"><?= $leader_below_non_kontrak; ?></button>
                                    </td>
                                    <td><?= number_format($leader_below_non_kontrak / ($jumlah_all_cat_level) * 100, 2); ?></td>
                                    <td>Helper</td>
                                    <td>
                                        <button class="badge bg-warning custom-btn" onclick="list_karyawan(3, '', 'Helper', <?= $company_id ?>, <?= $department_id ?>)"><?= $non_kontrak_helper; ?></button>
                                    </td>
                                    <td><?= number_format($non_kontrak_helper / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="9"></td>
                                    <td>Staff</td>
                                    <td>
                                        <button class="badge bg-warning custom-btn" onclick="list_karyawan(3, '', 'Staff', <?= $company_id ?>, <?= $department_id ?>)"><?= $non_kontrak_staff; ?></button>
                                    </td>
                                    <td><?= number_format($non_kontrak_staff / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="9"></td>
                                    <td>Officer</td>
                                    <td>
                                        <button class="badge bg-warning custom-btn" onclick="list_karyawan(3, '', 'Officer', <?= $company_id ?>, <?= $department_id ?>)"><?= $non_kontrak_officer; ?></button>
                                    </td>
                                    <td><?= number_format($non_kontrak_officer / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="6"></td>
                                    <td>Leader Up</td>
                                    <td>
                                        <button class="badge bg-warning custom-btn" onclick="list_karyawan(3, 'up', '', <?= $company_id ?>, <?= $department_id ?>)"><?= $leader_up_non_kontrak; ?></button>
                                    </td>
                                    <td><?= number_format($leader_up_non_kontrak / ($jumlah_all_cat_level) * 100, 2); ?></td>
                                    <td>Manager</td>
                                    <td>
                                        <button class="badge bg-warning custom-btn" onclick="list_karyawan(3, '', 'Manager', <?= $company_id ?>, <?= $department_id ?>)"><?= $non_kontrak_manager; ?></button>
                                    </td>
                                    <td><?= number_format($non_kontrak_manager / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="9"></td>
                                    <td>Head</td>
                                    <td>
                                        <button class="badge bg-warning custom-btn" onclick="list_karyawan(3, '', 'Head', <?= $company_id ?>, <?= $department_id ?>)"><?= $non_kontrak_head; ?></button>
                                    </td>
                                    <td><?= number_format($non_kontrak_head / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="9"></td>
                                    <td>Direktur</td>
                                    <td>
                                        <button class="badge bg-warning custom-btn" onclick="list_karyawan(3, '', 'Direktur', <?= $company_id ?>, <?= $department_id ?>)"><?= $non_kontrak_direktur; ?></button>
                                    </td>
                                    <td><?= number_format($non_kontrak_direktur / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>

                                <!-- PERJANJIAN -->
                                <tr>
                                    <td>Perjanjian</td>
                                    <td>
                                        <button class="badge bg-primary custom-btn" onclick="list_karyawan(4, '', '', <?= $company_id ?>, <?= $department_id ?>)"><?= $jumlah_perjanjian; ?></button>
                                    </td>
                                    <td><?= number_format($jumlah_perjanjian / ($jumlah_kartap + $jumlah_kontrak_all + $jumlah_non_kontrak + $jumlah_perjanjian) * 100, 2); ?></td>
                                    <td>Non Reguler</td>
                                    <td>
                                        <button class="badge bg-primary custom-btn" onclick="list_karyawan(4, '', '', <?= $company_id ?>, <?= $department_id ?>)"><?= $jumlah_perjanjian; ?></button>
                                    </td>
                                    <td><?= number_format($jumlah_perjanjian / ($jumlah_kartap + $jumlah_kontrak_all + $jumlah_non_kontrak + $jumlah_perjanjian) * 100, 2); ?></td>
                                    <td>Leader Below</td>
                                    <td>
                                        <button class="badge bg-primary custom-btn" onclick="list_karyawan(4, 'below', '', <?= $company_id ?>, <?= $department_id ?>)"><?= $leader_below_perjanjian; ?></button>
                                    </td>
                                    <td><?= number_format($leader_below_perjanjian / ($jumlah_all_cat_level) * 100, 2); ?></td>
                                    <td>Helper</td>
                                    <td>
                                        <button class="badge bg-primary custom-btn" onclick="list_karyawan(4, '', 'Helper', <?= $company_id ?>, <?= $department_id ?>)"><?= $perjanjian_helper; ?></button>
                                    </td>
                                    <td><?= number_format($perjanjian_helper / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="9"></td>
                                    <td>Staff</td>
                                    <td>
                                        <button class="badge bg-primary custom-btn" onclick="list_karyawan(4, '', 'Staff', <?= $company_id ?>, <?= $department_id ?>)"><?= $perjanjian_staff; ?></button>
                                    </td>
                                    <td><?= number_format($perjanjian_staff / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="9"></td>
                                    <td>Officer</td>
                                    <td>
                                        <button class="badge bg-primary custom-btn" onclick="list_karyawan(4, '', 'Officer', <?= $company_id ?>, <?= $department_id ?>)"><?= $perjanjian_officer; ?></button>
                                    </td>
                                    <td><?= number_format($perjanjian_officer / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="6"></td>
                                    <td>Leader Up</td>
                                    <td>
                                        <button class="badge bg-primary custom-btn" onclick="list_karyawan(4, 'up', '', <?= $company_id ?>, <?= $department_id ?>)"><?= (isset($leader_up_perjanjian) ? $leader_up_perjanjian : 0) ?></button>
                                    </td>
                                    <td><?= number_format($leader_up_perjanjian / ($jumlah_all_cat_level) * 100, 2); ?></td>
                                    <td>Supervisor</td>
                                    <td>
                                        <button class="badge bg-primary custom-btn" onclick="list_karyawan(4, '', 'Supervisor', <?= $company_id ?>, <?= $department_id ?>)"><?= $perjanjian_supervisor; ?></button>
                                    </td>
                                    <td><?= number_format($perjanjian_supervisor / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="9"></td>
                                    <td>Manager</td>
                                    <td>
                                        <button class="badge bg-primary custom-btn" onclick="list_karyawan(4, '', 'Manager', <?= $company_id ?>, <?= $department_id ?>)"><?= $perjanjian_manager; ?></button>
                                    </td>
                                    <td><?= number_format($perjanjian_manager / ($jumlah_all_level) * 100, 2); ?></td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total :</th>
                                    <th><?= $jumlah_kartap + $jumlah_kontrak_all + $jumlah_non_kontrak + $jumlah_perjanjian; ?></th>
                                    <th colspan="2"></th>
                                    <th><?= $jumlah_kartap + $jumlah_kontrak_all + $jumlah_non_kontrak + $jumlah_perjanjian; ?></th>
                                    <th colspan="2"></th>
                                    <th><?= $jumlah_all_cat_level; ?></th>
                                    <th colspan="2"></th>
                                    <th><?= $jumlah_all_level; ?></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modal_list_karyawan" tabindex="-1" aria-labelledby="modal_list_karyawanLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_list_absenLabel">List Employees</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="body_list_karyawan">
                    <div class="card mb-1 mt-1">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <table id="dt_karyawan" class="table table-md table-bordered table-striped" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Company</th>
                                                <th>Full Name</th>
                                                <th>Designation</th>
                                                <th>Gender</th>
                                                <th>Status</th>
                                                <th>Join Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
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