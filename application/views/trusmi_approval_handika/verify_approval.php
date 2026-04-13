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
        <?php if ($data->id_status == 1 || $data->id_status == 4 || $data->id_status == 5 || $data->id_status == 6) { ?>
            <div class="m-3">
                <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
                    <div class="card border-0">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                                </div>
                                <div class="col-auto align-self-center">
                                    <h6 class="fw-medium mb-0">Detail Request</h6>
                                </div>
                                <div class="col-auto ms-auto ps-0">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-12 col-lg-12 col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-12 col-md-12 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-info-square"></i></span>
                                                <div class="form-floating">
                                                    <textarea name="subject" id="subject_a" class="form-control border-start-0" cols="30" rows="10" readonly style="min-height: 100px;"><?= $data->subject; ?></textarea>
                                                    <!-- <input type="text" placeholder="Subject" name="subject" id="subject_a" value="" required class="form-control border-start-0" readonly> -->
                                                    <label>Subject</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-down"></i></span>
                                                <div class="form-floating">
                                                    <input type="text" placeholder="Requested By" name="created_by" id="created_by_a" value="<?= $data->created_by; ?>" required class="form-control border-start-0" readonly>
                                                    <label>Requested By</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-up"></i></span>
                                                <div class="form-floating">
                                                    <input type="text" placeholder="Approve To" name="approve_to" id="approve_to_a" value="<?= $data->approve_to; ?>" required class="form-control border-start-0" readonly>
                                                    <label>Approve To</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-tag-fill"></i></span>
                                                <div class="form-floating">
                                                    <input type="text" placeholder="Kategori" name="kategori" id="kategori" value="<?= $data->kategori; ?>" required class="form-control border-start-0" readonly>
                                                    <label>Kategori</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                    <?php  if ($data->kategori == 'Eaf') : ?>
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-123"></i></span>
                                                <div class="form-floating">
                                                    <input type="text" placeholder="Nominal" name="nominal" id="nominal" value="<?= $data->nominal; ?>" required class="form-control border-start-0" readonly>
                                                    <label>Nominal</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="col-12 col-md-12 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                                <div class="form-floating">
                                                    <textarea name="description" id="description_a" class="form-control border-start-0" cols="30" rows="5" style="min-height: 80px;" required readonly><?= $data->description; ?></textarea>
                                                    <label>Description</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-4 col-lg-4">
                                        <h6 class="title">Related Documents</h6>
                                        <div id="file_a">
                                            <?php if ($data->file_1 != null || $data->file_1 != '') { ?>
                                                <?php $ext = pathinfo($data->file_1, PATHINFO_EXTENSION); ?>
                                                <?php if ($ext == 'docx' || $ext == 'doc') { ?>
                                                    <a href="<?= base_url('uploads/trusmi_approval/') . $data->file_1; ?>"> <span class="bi bi-file-earmark-word label label-primary" style="font-size:20pt;"></span></a>
                                                <?php } else if ($ext == 'xls' || $ext == 'xlsx') { ?>
                                                    <a href="<?= base_url('uploads/trusmi_approval/') . $data->file_1; ?>"> <span class="bi bi-file-earmark-excel label label-success" style="font-size:20pt;"></span></a>
                                                <?php } else { ?>
                                                    <a data-fancybox="gallery" href="<?= base_url('uploads/trusmi_approval/') . $data->file_1; ?>" class="gallery"> <span class="bi bi-image label label-primary" style="font-size:20pt;"></span></a>
                                                <?php } ?>
                                            <?php  } else { ?>
                                                <br>
                                            <?php    } ?>
                                            <?php if ($data->file_2 != null || $data->file_2 != '') { ?>
                                                <a data-fancybox="gallery" href="<?= base_url('uploads/trusmi_approval/') . $data->file_2; ?>" class="gallery"> <span class="bi bi-image label label-primary" style="font-size:20pt;"></span></a>
                                            <?php } else { ?>

                                            <?php  } ?>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-8 col-lg-8">
                                        <h6 class="title">Action</h6>
                                        <form action="" id="formApprove">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="input-group input-group-lg">
                                                    <input type="hidden" name="no_app" id="no_app_a" readonly>
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                                    <div class="form-floating">
                                                        <textarea name="approve_note" id="approve_note" class="form-control border-start-0" cols="30" rows="5" style="min-height: 100px;" required autofocus></textarea>
                                                        <label>Note Approve</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12" style="text-align: right;">
                                                <?php if (isset($_GET['id'])) { ?>
                                                    <input type="hidden" name="no_app" value="<?= $_GET['id']; ?>" readonly>
                                                <?php } else { ?>
                                                <?php } ?>
                                                <button type="button" class="btn btn-md text-white btn-danger" id="btn_reject" onclick="reject()">Reject</button>
                                                <button type="button" class="btn btn-md text-white btn-success" id="btn_approve" onclick="approve()">Approve</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else if ($data->id_status == 2) { ?>
            <div class="col-12 align-self-center py-4 text-center">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-7 col-xl-6 col-xxl-4">
                        <?php if ($data->id_status == 2) { ?>
                            <p class="h4 fw-light mb-4">Thank you.</p>
                            <h1 class="display-5">Already Approved</h1>
                            <i class="bi bi-check-square text-success" style="font-size: 100pt;"></i>
                        <?php } else if ($data->id_status == 7) { ?>
                            <h1 class="display-5">Already End</h1>
                            <i class="bi bi-emoji-smile-upside-down" style="font-size: 100pt;"></i>
                            <br>
                        <?php } ?>
                    </div>
                </div>
            </div>

        <?php } else if ($data->id_status == 7 || $data->id_status == 3) { ?> 
            <!-- section resubmit -->
            <div class="m-3">
                <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
                    <div class="card border-0">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                                </div>
                                <div class="col-auto align-self-center">
                                    <h6 class="fw-medium mb-0">Form Re-Submit Approval</h6>
                                </div>
                                <div class="col-auto ms-auto ps-0">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="form_resubmit">
                            <input type="hidden" name="old_no_app" value="<?= $data->no_app ?>">
                            
                            <div class="row">
                                <div class="col-2 col-xl-2 col-md-2 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-info-square"></i></span>
                                            <div class="form-floating">
                                                <textarea name="tipe" class="form-control border-start-0" cols="30" rows="10" style="min-height: 100px;" readonly>Resubmit</textarea>
                                                <label>Tipe</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                                <div class="col-10 col-xl-10 col-md-10 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-info-square"></i></span>
                                            <div class="form-floating">
                                                <textarea name="subject" class="form-control border-start-0" cols="30" rows="10" style="min-height: 100px;"><?= $data->subject; ?></textarea>
                                                <label>Subject</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                                <div class="col-12 col-md-6 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-down"></i></span>
                                            <div class="form-floating">
                                                <input type="text" placeholder="Requested By" name="created_by" value="<?= $data->created_by; ?>" required class="form-control border-start-0" readonly>
                                                <label>Requested By</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                                <div class="col-12 col-md-6 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-up"></i></span>
                                            <div class="form-floating">
                                                <input type="hidden" name="id_approve_to" value="<?= $data->user_id_approve_to ?>">
                                                <input type="text" placeholder="Approve To" name="approve_to" value="<?= $data->approve_to; ?>" id="approve_to_reject" class="form-control border-start-0" readonly>
                                                <label>Approve To</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                                <div class="col-12 col-md-6 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-tag-fill"></i></span>
                                            <div class="form-floating">
                                                <select name="kategori" id="kategori" class="form-control border-start-0" onchange="is_eaf()">
                                                    <option value="Approval" <?= $data->kategori == 'Approval' ? 'selected' : '' ?>>Approval</option>
                                                    <option value="Memo" <?= $data->kategori == 'Memo' ? 'selected' : '' ?>>Memo</option>
                                                    <option value="BA" <?= $data->kategori == 'BA' ? 'selected' : '' ?>>BA</option>
                                                    <option value="Eaf" <?= $data->kategori == 'Eaf' ? 'selected' : '' ?>>Eaf</option>
                                                    <option value="Other" <?= $data->kategori == 'Other' ? 'selected' : '' ?>>Other</option>
                                                </select>
                                                <label>Kategori</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                                <div class="col-12 col-md-6 mb-2">
                                    <div id="field_nominal" class="form-group mb-3 position-relative check-valid <?= $data->kategori == 'Eaf' ? '' : 'd-none' ?>">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-123"></i></span>
                                            <div class="form-floating">
                                                <input type="number" placeholder="Nominal" name="nominal" id="nominal" class="form-control border-start-0" value="<?= $data->nominal; ?>">
                                                <label>Nominal</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                                <div class="col-12 col-md-12 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                            <div class="form-floating">
                                                <textarea name="description" class="form-control border-start-0" cols="30" rows="5" style="min-height: 80px;"><?= $data->description; ?></textarea>
                                                <label>Description</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                            </div>


                            <h6 class="title">Related Documents <span class="text-secondary" style="font-size: 9pt;">(*Optional)</span></h6>
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="card border-0 mb-4">
                                        <div class="card-body">
                                            <div class="row gx-3 align-items-center">
                                                <div class="col-auto">
                                                    <!-- <div class="col-auto">
                                                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                                                </div> -->
                                                    <div class="avatar avatar-40 rounded bg-light-blue text-white">
                                                        <i class="bi bi-file-earmark-text h5 vm"></i>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <h6 class="fw-medium mb-1">Allowed File</h6>
                                                    <p class="text-secondary">.pdf, .jpg, .png, .jpeg</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-cloud-upload"></i></span>
                                            <div class="form-floating">
                                                <input type="file" placeholder="Related Documents 1" name="file_1" id="file_1" class="form-control" onchange="compress('#file_1', '#string_file_1', '#btn_save', '.fa_wait_1', '.fa_done_1')" accept="gambar/*" capture="">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="string_file_1" id="string_file_1">
                                    <div class="fa_wait_1" style="display: none;"><i class="fa fa-spinner fa-pulse"></i> <label>Copressing File ...</label></div>
                                    <div class="fa_done_1" style="display: none;"><i class="fa fa-check-circle" style="color: #689f38;"></i> <label>Copressing Complete.</label></div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                                <div class="col-12 col-md-6 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-cloud-upload"></i></span>
                                            <div class="form-floating">
                                                <input type="file" placeholder="Related Documents 1" name="file_2" id="file_2" class="form-control" onchange="compress('#file_2', '#string_file_2', '#btn_save', '.fa_wait_2', '.fa_done_2')" accept="gambar/*" capture="">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="string_file_2" id="string_file_2">
                                    <div class="fa_wait_2" style="display: none;"><i class="fa fa-spinner fa-pulse"></i> <label>Copressing File ...</label></div>
                                    <div class="fa_done_2" style="display: none;"><i class="fa fa-check-circle" style="color: #689f38;"></i> <label>Copressing Complete.</label></div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                                <div class="col-12" align="right">
                                    <button type="submit" id="btn_resubmit" class="btn btn-md text-white btn-primary">Resubmit</button>
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