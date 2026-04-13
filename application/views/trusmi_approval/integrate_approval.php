<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Deskripsi Page</p>
            </div>
            <div class="col col-sm-auto">
            </div>
            <div class="col-auto ps-0">

            </div>
        </div>
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <?php if (isset($_GET['id'])) { ?>
        <?php if ($data->created_at < '2025-04-23') { ?>
            <?php if ($data->id_status == 2) { ?>
                <!-- addnew section form memo -->
                <div class="m-3">
                    <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
                        <div class="card border-0">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-auto">
                                        <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <h6 class="fw-medium mb-0">Form Input Memo</h6>
                                    </div>
                                    <div class="col-auto ms-auto ps-0">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="form_input_memo">
                                    <input type="hidden" name="old_no_app" id="no_app" value="<?= $data->no_app ?>">
                                    <input type="hidden" id="user_id" value="<?= $data->created_by_id ?>">
                                    <input type="hidden" id="file_1" value="<?= $data->file_1 ?>">

                                    <div class="row">
                                        <div class="col-6 col-xl-6 col-md-2 mb-2">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-info-square"></i></span>
                                                    <div class="form-floating">
                                                        <!-- <textarea name="tipe" class="form-control border-start-0" cols="30" rows="10" style="min-height: 100px;" readonly>Resubmit</textarea> -->
                                                        <select name="tipe_memo" id="tipe_memo" class="form-control">
                                                            <option value="#" selected>--Pilih Tipe--</option>
                                                            <option value="BA" <?= ($data->kategori == 'BA') ? 'selected' : ''?>>BA</option>
                                                            <option value="Memo" <?= ($data->kategori == 'Memo') ? 'selected' : ''?>>Memo</option>
                                                            <option value="SK" <?= ($data->kategori == 'SK') ? 'selected' : ''?>>SK</option>
                                                        </select>
                                                        <label>Tipe</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback mb-3">Add valid data </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 col-xl-6 col-md-10 mb-2">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                                    <div class="form-floating">
                                                        <textarea name="note" id="note" class="form-control border-start-0" cols="30" rows="10" style="min-height: 100px;"><?= $data->subject; ?></textarea>
                                                        <label>Note</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback mb-3">Add valid data </div>
                                        </div>
                                    </div>
                                    <!-- <div class="row">
                                        <div class="col-12 col-md-6 mb-2">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-cloud-upload"></i></span>
                                                    <div class="form-floating">
                                                        <input type="file" placeholder="Related Documents 1" name="file_memo" id="file_memo" class="form-control" accept="application/pdf">
                                                        <label>File</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback mb-3">Add valid data </div>
                                        </div>
                                    </div> -->
                                    <div class="row">
                                        <div class="col-6 col-xl-6 col-md-2 mb-2">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-info-square"></i></span>
                                                    <div class="form-floating">
                                                        <!-- <textarea name="tipe" class="form-control border-start-0" cols="30" rows="10" style="min-height: 100px;" readonly>Resubmit</textarea> -->
                                                        <select id="divisi" class="form-control" multiple="">
                                                            <option value="">Pilih Divisi</option>
                                                        </select>
                                                        <label>Divisi</label>
                                                    </div>
                                                    <input type="text" readonly hidden id="divisi_hidden" name="divisi_hidden">
                                                </div>
                                            </div>
                                            <div class="invalid-feedback mb-3">Add valid data </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 col-xl-6 col-md-2 mb-2">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-info-square"></i></span>
                                                    <div class="form-floating">
                                                        <!-- <textarea name="tipe" class="form-control border-start-0" cols="30" rows="10" style="min-height: 100px;" readonly>Resubmit</textarea> -->
                                                        <select id="jabatan" class="form-control" multiple>
                                                        </select>
                                                        <label>Jabatan</label>
                                                    </div>
                                                    <input type="text" readonly hidden id="jabatan_hidden" name="jabatan_hidden">
                                                </div>
                                            </div>
                                            <div class="invalid-feedback mb-3">Add valid data </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6" align="right">
                                            <button type="button" id="btn_simpan_memo" class="btn btn-md text-white btn-primary" onclick="simpan_memo()">Save</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>

            <!-- addnew section form memo -->
            <div class="m-3">
                    <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
                        <div class="card border-0">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-auto">
                                        <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <h6 class="fw-medium mb-0">Form Input Memo</h6>
                                    </div>
                                    <div class="col-auto ms-auto ps-0">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="form_input_memo">
                                    <input type="hidden" name="old_no_app" id="no_app" value="<?= $data->no_app ?>">
                                    <input type="hidden" id="user_id" value="<?= $data->created_by_id ?>">
                                    <input type="hidden" id="file_1" value="<?= $data->file_1 ?>">

                                    <div class="row">
                                        <div class="col-6 col-xl-6 col-md-2 mb-2">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-info-square"></i></span>
                                                    <div class="form-floating">
                                                        <select name="tipe_memo" id="tipe_memo" class="form-control">
                                                            <option value="#">--Pilih Tipe--</option>
                                                            <option value="BA" <?= ($data->kategori == 'BA') ? 'selected' : ''?>>BA</option>
                                                            <option value="Memo" <?= ($data->kategori == 'Memo') ? 'selected' : ''?>>Memo</option>
                                                            <option value="SK" <?= ($data->kategori == 'SK') ? 'selected' : ''?>>SK</option>
                                                        </select>
                                                        <label>Tipe</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback mb-3">Add valid data </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 col-xl-6 col-md-10 mb-2">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                                    <div class="form-floating">
                                                        <textarea name="note" id="note" class="form-control border-start-0" cols="30" rows="10" style="min-height: 100px;"><?= $data->subject; ?></textarea>
                                                        <label>Note</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback mb-3">Add valid data </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-bounding-box"></i></span>
                                                    <div class="form-floating">
                                                        <select id="company_id" name="company_id" class="form-control" multiple onchange="get_department(this.value)" required>
                                                            <option value="#" selected disabled>--Choose Company--</option>
                                                            <?php foreach ($companies as $company) { ?>
                                                                <option value="<?= $company->company_id; ?>"><?= $company->name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <label>Company
                                                            <i class="text-danger">*</i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-bounding-box"></i></span>
                                                    <div class="form-floating">
                                                        <select id="department_id" name="department_id" class="form-control" multiple required>
                                                            
                                                        </select>
                                                        <label>Department
                                                            <i class="text-danger">*</i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-2">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-bounding-box"></i></span>
                                                    <div class="form-floating">
                                                        <select id="role_id" name="role_id" class="form-control" multiple required>
                                                            <option value="#" selected disabled>--Choose Role--</option>
                                                            <?php foreach ($roles as $role) { ?>
                                                                <option value="<?= $role->role_id; ?>"><?= $role->role_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <label>Role/Jabatan
                                                            <i class="text-danger">*</i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6" align="right">
                                            <button type="button" id="btn_simpan_memo" class="btn btn-md text-white btn-primary" onclick="simpan_memo()">Save</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

        <?php } ?>
    <?php } ?>
</main>