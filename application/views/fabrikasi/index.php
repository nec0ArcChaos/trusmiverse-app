<main class="main mainheight">
    <div class="container-fluid">
        <div class="row align-items-center page-title">
            <div class="col-8 col-md">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
            </div>
        </div>
        <div class="row breadcrumb-theme align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fabrikasi</li>
            </ol>
        </div>
    </div>

    <div class="m-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col">
                                <h6 class="title">Master Upah Helper</h6>
                            </div>
                            <div class="col-auto align-items-center align-self-center">
                                <button class="btn btn-outline-primary text-dinamis" type="button" data-bs-toggle="modal" data-bs-target="#modal_add_upah">Add Upah Helper</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dt_upah_helper" class="table table-striped text-nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Company</th>
                                        <th>Department</th>
                                        <th>Designation</th>
                                        <th>Gaji</th>
                                        <th>Lembur/jam</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row breadcrumb-theme mb-2 d-block d-md-none">
            <br>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modal_add_upah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card">
            <div class="modal-header card-header">
                <div class="col-12">
                    <div class="row">
                        <div class="col">
                            <h6 class="modal-title title">Add Upah Helper</h6>
                        </div>
                        <div class="col-auto d-flex align-items-center align-self-center">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body card-body">
                <form id="from_add_upah" class="formName" enctype="multipart/form-data">
                    <div class="row align-items-center m-1">
                        <div class="mb-3 col-12">
                            <label for="employee_id" class="form-label-custom required">Employee</label>
                            <select name="employee_id" id="employee_id" class="form-control">
                                <option value="">-- Pilih Employee --</option>
                                <?php foreach ($helper as $value) { ?>
                                    <option value="<?= $value->user_id; ?>"><?= $value->nama; ?> | <?= $value->designation_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3 col-12">
                            <label for="upah" class="form-label-custom required">Upah</label>
                            <input type="text" class="form-control" name="upah" id="upah" oninput="validasiUpah(this)">
                        </div>
                        <div class="mb-3 col-12">
                            <label for=" lembur" class="form-label-custom required">Lembur</label>
                            <input type="text" class="form-control" name="lembur" id="lembur" oninput="validasiUpah(this)">
                            <span class="small" style="font-size: 7pt;">*Bayaran lembur hitungan jam</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer card-footer">
                <button type="button" class="btn btn-outline-theme m-1" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-theme m-1" onclick="add_upah()" id="btn-addUpah">Submit</button>
            </div>
        </div>
    </div>
</div>