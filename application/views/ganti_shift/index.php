<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
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

    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Daftar Karyawan</h6>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_shift" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Shift</th>
                                    <th>Nama Karyawan</th>
                                    <th>Departemen</th>
                                    <th>Penunjukan</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
</main>
<!-- modal Update Shift -->
<div class="modal fade" id="modal_shift" aria-labelledby="modal_shiftLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modal_shiftLabel">Update Shift</h6>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form id="form_shift">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group">
                        <label>Shift</label>
                        <select class="form-control" name="shift" id="shift">
                            <?php foreach ($shift as $sh): ?>
                                <option value="<?= $sh->office_shift_id ?>"><?= $sh->shift_name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="gap:12px">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" id="simpan_shift">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal Update Shift -->