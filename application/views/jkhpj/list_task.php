<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="https://trusmiverse.com/apps/">Trusmiverse</a></li>
                    <li class="breadcrumb-item"><a href="https://trusmiverse.com/apps/jkhpj"><?= $pageTitle; ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Task</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="m-3 item-center">
        <div class="row">
            <?php foreach ($dt_list_task as $item) : ?>
                <div class="col-md-4">
                    <div class="card bg-theme <?= ($item->status == 0 ? 'theme-orange' : 'theme-green') ?> border-0 mb-4">
                        <div class="card-header bg-none">
                            <div class="row gx-2 align-items-center">
                                <div class="col-auto">
                                    <?php if ($item->status == 0) { ?>
                                        <i class="bi bi-exclamation-circle h5 me-1 avatar avatar-40 bg-light-white rounded me-2"></i>
                                    <?php } else { ?>
                                        <i class="bi bi-check-circle h5 me-1 avatar avatar-40 bg-light-white rounded me-2"></i>
                                    <?php } ?>
                                </div>
                                <div class="col">
                                    <h6 class="fw-medium mb-0"><?= $item->tasklist; ?></h6>
                                    <p class="text-muted small">Jadwal <strong><?= substr($item->time_start, 0, 5); ?> - <?= substr($item->time_end, 0, 5); ?></strong></p>
                                </div>
                                <div class="col-auto">
                                    <p class="small text-right">
                                        <?php if ($item->time_actual != null) { ?>
                                            <span>Waktu Cek <span id="waktu"><strong><?= substr($item->time_actual, 0, 5); ?></strong></span></span>
                                        <?php } else { ?>
                                            <span>Belum di Cek</span>
                                        <?php } ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body bg-none">
                            <h5 class="mb-3">
                                <span><?= $item->description; ?></span>
                            </h5>
                            <?php if($item->note != null || $item->note != '') { ?>
                            <hr>
                            <p class="mb-3">
                                <b>Catatan</b> : <span><?= $item->note; ?></span>
                            </p>
                            <?php } ?>
                        </div>
                        <div class="card-footer text-center" onclick="cek_detail_task('<?= $item->id; ?>')" style="cursor:pointer;">
                            <button type="button" class="btn btn-link">Check</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<!-- Modal DetailTask-->
<div class="modal fade" id="modal_detail_task" aria-labelledby="modal_input_dokumen" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_detail_task">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-person-workspace h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_input_dokumen">Detail Task</h6>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="dropdown d-inline-block">
                            <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="background-color: #f6fafd;">

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <input type="hidden" id="id_task_item" name="id_task_item" readonly>
                            <input type="hidden" id="id_task" name="id_task" readonly>
                            <label class="form-label-custom required small" for="department"><strong>Jadwal</strong></label>
                            <div class="input-group border-custom form-control">
                                <span id="det_time_start">08:00</span> - <span id="det_time_end">09:00</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom required small" for="company"><strong>Tasklist</strong></label>
                            <div class="input-group border-custom form-control">
                                <span id="det_tasklist">Tasklist</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3" style="background-color: #f6fafd;">
                            <label class="form-label-custom required small" for="department"><strong>Status</strong></label>
                            <!-- <div id="det_status"></div> -->
                            <div class="input-group border-custom">
                                <select name="status" id="status" class="form-control">
                                    <option value="#" disabled>- Pilih Status -</option>
                                    <option value="0">Belum</option>
                                    <option value="1">Sudah</option>
                                </select>
                            </div>
                            <input type="hidden" id="old_photo" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom required small" for="company"><strong>Deskripsi</strong></label>
                            <div class="input-group border-custom form-control">
                                <span id="det_description">Description</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 div-photo d-none">
                            <label class="form-label-custom required small" for="department"><strong>File</strong></label>
                            <br>
                            <img id="preview_photo" width="300px" alt="foto_sc">
                            <a id="file_jkhpj"></a>
                            <input type="hidden" id="is_file" readonly>
                            <div class="input-group border-custom mt-2">
                                <input type="file" name="photo" id="photo" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 pb-3" style="background-color: #f6fafd;">
                            <label class="form-label-custom required small" id="label-link"><strong>Link</strong></label>
                            <div class="input-group border-custom">
                                    <input type="text" name="link" id="link" class="form-control" placeholder="Link" required>
                            </div>
                        </div>
                        <div class="col-md-6 pb-3" style="background-color: #f6fafd;">
                            <label class="form-label-custom required small" for="department"><strong>Note</strong></label>
                            <div class="input-group border-custom">
                                <div class="form-floating">
                                    <textarea name="note" id="note" class="form-control border-start-0" cols="30" rows="5" style="min-height: 80px;" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-md btn-primary" id="btn_update_task_item" onclick="update_task_item()">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Modal Add -->