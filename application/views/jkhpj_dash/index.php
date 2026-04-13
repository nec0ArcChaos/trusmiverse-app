<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-8 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Deskripsi Page</p>
            </div>
            <div class="col-sm-12 col-md-3">
                <?php if ($is_head || $is_manager) : ?>
                    <select name="department_id" id="department_id" class="form-control">
                        <option value="0">Semua Departemen</option>
                        <?php foreach ($departments as $department) : ?>
                            <option value="<?= $department->department_id; ?>"><?= $department->nama; ?> - <?= $department->department_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </div>
            <div class="col col-sm-auto">
                <div class="input-group">
                    <input type="text" name="periode" id="periode" placeholder="bulan-tahun" class="form-control">
                    <div class="input-group-append">
                        <button class="btn btn-primary" onclick="filter()">Filter</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
                        </ol>
                    </div>

                </div>

            </nav>
        </div>
    </div>

    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12">
            <div class="card border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_dashboard" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Employees</th>
                                    <th rowspan="2">Department</th>
                                    <th rowspan="2">Designation</th>
                                    <th colspan="31" class="text-center">Date</th>
                                    <th rowspan="2">Avg Task Done</th>
                                    <th rowspan="2">Avg Task Approve Manager</th>
                                    <th rowspan="2">Avg Task Reject Manager</th>
                                </tr>
                                <tr>
                                    <?php for ($i = 1; $i < 32; $i++) {
                                        echo "<th>" . $i . "</th>";
                                    } ?>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>