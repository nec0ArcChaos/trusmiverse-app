<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="m-3 item-center">
        <!-- <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">

                </div>

                <div class="card-body">
                    
                </div>
            </div>
        </div> -->

        <?php foreach ($dt_list_task as $item) : ?>
            <div class="card mt-2">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <span>Jadwal <span id="jadwal"><strong><?= substr($item->time_start, 0, 5); ?> - <?= substr($item->time_end, 0, 5); ?></strong></span></span>
                        </div>
                        <div class="col text-end">
                            <?php if ($item->time_actual != null) { ?>
                                <span>Waktu Cek <span id="waktu"><strong><?= substr($item->time_actual, 0, 5); ?></strong></span></span>
                            <?php } else { ?>
                                <span>Belum di Cek</span>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <p><?= $item->tasklist; ?></p>
                    <p><b>Catatan</b> : <span><?= $item->note; ?></span></p>
                    <!-- <div>
                    <img src="https://trusmiverse.com/apps/assets/img/logo_trusmiverse.png" alt="foto_sc">
                </div> -->
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col">
                            <?php if ($item->status == 0) { ?>
                                <span class="badge bg-warning">Belum</span>
                            <?php } else { ?>
                                <span class="badge bg-green">Sudah</span>
                            <?php } ?>
                        </div>
                        <div class="col text-end">
                            <button class="btn btn-sm btn-primary btn_cek" onclick="cek_detail_task('<?= $item->id; ?>')">Check</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- <div class="card mt-2">
            <div class="card-header">
                Jadwal
            </div>

            <div class="card-body">
                Pengecekan Rumah
            </div>
        </div> -->

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
                        <h6 class="fw-medium mb-0" id="modal_input_dokumen">Detail Task Security</h6>
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
                            <div class="input-group border-custom">
                                <span id="det_time_start">08:00</span> - <span id="det_time_end">09:00</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom required small" for="company"><strong>Tasklist</strong></label>
                            <div class="input-group border-custom">
                                <span id="det_tasklist">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nostrum fugit aliquam aperiam at inventore dolore accusantium commodi temporibus, neque quos deserunt.</span>
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
                        <div class="col-md-6 mb-3 div-photo d-none">
                            <label class="form-label-custom required small" for="department"><strong>Foto</strong></label>
                            <br>
                            <img id="preview_photo" width="300px" alt="foto_sc">
                            <input type="hidden" id="is_photo" readonly>
                            <div class="input-group border-custom mt-2">
                                <input type="file" name="photo" id="photo" class="form-control">
                                <!-- <input type="text" class="required" id="photo_input" value=""> -->
                            </div>
                            <!-- test -->
                            <!-- <input type="file" accept="image/*" id="foto_test" onchange="input_file('#foto_test')">
                            <input type="text" class="required" name="foto_test" id="foto_test_input" value=""> -->
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