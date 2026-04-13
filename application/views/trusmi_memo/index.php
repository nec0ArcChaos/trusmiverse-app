<!-- <style>
    .ss-multi-selected {
            height: auto !important;
            max-height: none !important;
            padding-bottom: 5px;
            overflow-y: visible !important;
        }
</style> -->
<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-8 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Sistem Trusmi Memo, SK, BA Terpusat</p>
            </div>
            <div class="col col-sm-auto">
                <div class="input-group input-group-md reportrange">
                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;"
                        id="titlecalendar">
                    <input type="hidden" name="start" value="" id="start" />
                    <input type="hidden" name="end" value="" id="end" />
                    <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i
                            class="bi bi-calendar-event"></i></span>
                </div>
            </div>
            <div class="col-auto ps-0">

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
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto mb-2">
                            <i class="bi bi-journal-text h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center mb-2">
                            <h6 class="fw-medium">List Data</h6>
                        </div>
                        <div class="col col-auto-right" align="right">
                            <?php
                            $department = $this->session->userdata('department_id');
                            $user_allow = [1, 5203];
                            $user_allow_pic= [1, 5203,1139];
                            $user_id = $this->session->userdata('user_id');

                            ?>
                            <?php if ($department == 5 || in_array($user_id, $user_allow)): ?>
                                <button type="button" class="btn btn-md btn-secondary mb-2" onclick="list_approval(2)"><i
                                        class="bi bi-hourglass-split"></i> Waiting Sekdir</button>
                            <?php endif; ?>
                            <?php if (in_array($user_id, $user_allow_pic)): ?>
                                <button type="button" class="btn btn-md btn-info mb-2" onclick="show_pic()"><i
                                        class="bi bi-people"></i> Pilih PIC</button>
                            <?php endif; ?>
                            <?php if (!($department == 5 || in_array($user_id, $user_allow))): ?>
                            <?php endif; ?>
                            <button type="button" class="btn btn-md btn-warning mb-2" onclick="list_approval(1)"><i
                                    class="bi bi-hourglass-split"></i> Waiting</button>
                            <?php if ($is_admin == true): ?>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-md btn-primary dropdown-toggle mb-2"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-bookmark-star"></i> Input
                                    </button>
                                    <ul class="dropdown-menu" style="">
                                        <li><button class="dropdown-item" onclick="add_memo()">Add Memo</button></li>
                                        <li><button class="dropdown-item" onclick="list_draf()">Draf Memo</button></li>
                                        <!-- <li><button class="dropdown-item" onclick="my_memo()">My Memo</button></li> -->
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_memo" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID Memo</th>
                                    <th>Nomer</th>
                                    <th>Jenis</th>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <th>Judul</th>
                                    <th>Category</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Role/Jabatan</th>
                                    <th>Content</th>
                                    <th>Personal</th>
                                    <th>Tujuan</th>
                                    <th>Lampiran</th>
                                    <th>Approval</th>
                                    <th>CC</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    


                </div>
            </div>
        </div>
    </div>
</main>


<!-- Modal Add -->
<div class="modal fade" id="modal_add_memo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-blockquote-left h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Add Memo</p>
                    </div>
                    
                </div> -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-auto d-flex align-items-center">
                        <h6><i class="bi bi-blockquote-left h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                            <span id="label_form_memo">Form Memo</span></h6>
                    </div>
                    <div class="col">
                        <ul class="nav nav-tabs" id="memoTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="detail-tab" data-bs-toggle="tab"
                                    data-bs-target="#detail-pane" type="button" role="tab" aria-controls="detail-pane"
                                    aria-selected="true">
                                    Detail Memo
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="content-tab" data-bs-toggle="tab"
                                    data-bs-target="#content-pane" type="button" role="tab" aria-controls="content-pane"
                                    aria-selected="false">
                                    Isi Memo
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="approval-tab" data-bs-toggle="tab"
                                    data-bs-target="#approval-pane" type="button" role="tab"
                                    aria-controls="approval-pane" aria-selected="false">
                                    Approval
                                </button>
                            </li>
                            <!-- <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="final-tab" data-bs-toggle="tab"
                                        data-bs-target="#final-pane" type="button" role="tab" aria-controls="final-pane"
                                        aria-selected="false">
                                        Final
                                    </button>
                                </li> -->
                        </ul>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="dropdown d-inline-block">
                            <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle"
                                role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>



                <div class="tab-content pt-3" id="memoTabContent">

                    <div class="tab-pane fade show active" id="detail-pane" role="tabpanel" aria-labelledby="detail-tab"
                        tabindex="0">
                        <div class="row">
                            <div class="col-12 col-md-12 mb-2 row_revisi" style="display:none">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <label>Note Revisi <b class="text-danger small">*</b></label>
                                    <input type="hidden" name="id_revisi" value="" id="id_revisi">
                                    <textarea name="note_revisi" class="form-control border-custom" id="note_revisi" rows="2"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Semua Note Revisi akan muncul disini" readonly></textarea>
                                    <!-- <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-align-top"></i></span>
                                        <div class="form-floating">
                                            
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-1 position-relative check-valid judul">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Masukkan judul utama untuk memo ini. ini akan di gunakan di header memo"><i
                                                class="bi bi-align-top"></i></span>
                                        <div class="form-floating">
                                            <input type="text" class="form-control border-start-0" name="judul"
                                                id="judul" placeholder="Judul">
                                            <input type="hidden" name="id_memo" value="null" id="id_memo">
                                            <label>Judul <b class="text-danger small">*</b></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 mb-2">
                                <div class="form-group mb-1 position-relative check-valid judul">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Pilih jenis memo berdasarkan tujuannya"><i
                                                class="bi bi-broadcast"></i></span>
                                        <div class="form-floating">
                                            <select name="jenis" id="jenis" class="form-control">
                                                <option value="" selected disabled>-Choose-</option>
                                                <?php foreach ($master as $item): ?>
                                                    <?php if ($item->jenis !== null): ?>
                                                        <option value="<?= $item->id ?>"><?= $item->jenis ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Jenis <b class="text-danger small">*</b></label>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-6 col-md-4 mb-2">
                                <div class="form-group mb-1 position-relative check-valid judul">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"
                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                            title="Pilih Kategori memo"><i class="bi bi-broadcast"></i></span>
                                        <div class="form-floating">
                                            <select name="category" id="category" class="form-control">
                                                <option value="" selected disabled>-Choose-</option>
                                                <?php foreach ($master as $item): ?>
                                                    <?php if ($item->category !== null): ?>
                                                        <option value="<?= $item->id ?>"><?= $item->category ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Categori <b class="text-danger small">*</b></label>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-6 col-md-4 mb-2">
                                <div class="form-group mb-1 position-relative check-valid judul">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"
                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                            title="Pilih Prioritas memo dan akan menentukan deadline approval"><i
                                                class="bi bi-subtract"></i></span>
                                        <div class="form-floating">
                                            <select name="priority" id="priority" class="form-control">
                                                <option value="" selected disabled>-Choose-</option>
                                                <?php foreach ($master as $item): ?>
                                                    <?php if ($item->priority !== null): ?>
                                                        <option value="<?= $item->id ?>"><?= $item->priority ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Priority <b class="text-danger small">*</b></label>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-12 col-md-4 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"
                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                            title="Pilih Company yang akan menerima memo ini"><i
                                                class="bi bi-building"></i></span>
                                        <div class="form-floating">
                                            <select id="company_id" name="company_id" class="form-control" required>
                                                <option value="#" selected disabled>--Choose Company--</option>
                                                <!-- <option value="null">All Company</option> -->
                                                <?php foreach ($companies as $company) { ?>
                                                    <option value="<?= $company->company_id; ?>"
                                                        data-header="<?= $company->header_memo ?>"><?= $company->name; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <label>Company
                                                <i class="text-danger">*</i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-8 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"
                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                            title="Pilih Spesifik Department yang akan menerima memo ini"><i
                                                class="bi bi-person-bounding-box"></i></span>
                                        <div class="form-floating">
                                            <select id="department_id" name="department_id[]" class="form-control"
                                                multiple required>
                                            </select>
                                            <label>Department
                                                <i class="text-danger">*</i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"
                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                            title="Pilih Spesifik Employee yang akan menerima memo ini dari department yang di pilih"><i
                                                class="bi bi-person-bounding-box"></i></span>
                                        <div class="form-floating">
                                            <select id="to_person" name="to_person[]" class="form-control" multiple
                                                required>
                                            </select>
                                            <label>Spesific Employee
                                                <!-- <i class="text-danger">*</i> -->
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"
                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                            title="Pilih Spesifik Role atau level jabatan yang akan menerima memo ini dari department yang di pilih"><i
                                                class="bi bi-person-bounding-box"></i></span>
                                        <div class="form-floating">
                                            <select id="role_id" name="role_id[]" class="form-control" multiple
                                                required>
                                                <?php foreach ($roles as $role) { ?>
                                                    <option value="<?= $role->role_id; ?>"><?= $role->role_name; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <label>Role/Jabatan
                                                <!-- <i class="text-danger">*</i> -->
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-1 position-relative check-valid judul">
                                    <label>Expected outcome <b class="text-danger small">*</b></label>
                                    <textarea name="tujuan" class="form-control border-custom" id="tujuan" rows="4"
                                        data-bs-toggle="tooltip" data-bs-placement="left"
                                        title="Isikan tujuan atau expected outcome dari memo ini"></textarea>
                                    <!-- <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i
                                                class="bi bi-align-top"></i></span>
                                        <div class="form-floating">
                                            
                                        </div>
                                    </div> -->
                                </div>
                                
                            </div>
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-1 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"
                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                            title="Pilih Employee untuk mengirimkan salinan atau CC"><i
                                                class="bi bi-people"></i></span>
                                        <div class="form-floating">
                                            <select id="cc" name="cc[]" class="form-control" multiple
                                                required>
                                            </select>
                                            <label>CC
                                                <!-- <i class="text-danger">*</i> -->
                                            </label>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="content-pane" role="tabpanel" aria-labelledby="content-tab"
                        tabindex="0">
                        <div class="row">
                            <div class="col-12">
                                <textarea id="memo-editor"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="approval-pane" role="tabpanel" aria-labelledby="approval-tab"
                        tabindex="0">
                        <div class="row">
                            <div class="col-12 col-md-6 mb-2">
                                <div class="form-group mb-1 position-relative check-valid judul">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="Pilih Master Approval yang sudah ada"><i
                                                class="bi bi-person-rolodex"></i></span>
                                        <div class="form-floating">
                                            <select name="approval" id="approval" class="form-control border-start-0">

                                            </select>
                                            <label>Approval <i class="text-danger">*</i></label>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-6 mb-2 d-flex align-items-center">
                                <button class="btn btn-link mb-1" onclick="add_approval()" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Jika tidak ada mana tambahkan manual dan pilih PIC Approval terkait"><i
                                        class="bi bi-patch-plus"></i> Baru Master Approval</button>
                            </div>
                        </div>
                        <div class="row">
                            <!-- <div class="col-12 col-md-3">
                                <div class="form-group mb-3 position-relative check-valid judul">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" name="dibuat" id="dibuat"
                                                class="form-control border-start-0" readonly>
                                            <label>Dibuat</label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-12 col-md-4">
                                <div class="form-group mb-1 position-relative check-valid judul">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" name="diverifikasi" id="diverifikasi"
                                                class="form-control border-start-0" readonly>
                                            <label>Diverifikasi</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-group mb-1 position-relative check-valid judul">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" name="disetujui" id="disetujui"
                                                class="form-control border-start-0" readonly>
                                            <label>Disetujui</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group mb-1 position-relative check-valid judul">
                                    <div class="input-group input-group-lg">
                                        <div class="form-floating">
                                            <input type="text" name="mengetahui" id="mengetahui"
                                                class="form-control border-start-0" readonly>
                                            <label>Mengetahui</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 mb-2">
                                <div class="form-group mb-1 position-relative check-valid judul">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"
                                            data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="Tambahkan lampiran jika di perlukan yang akan di simpan di akhir memo"><i
                                                class="bi bi-file-arrow-up-fill"></i></span>
                                        <div class="form-floating">

                                            <input type="file" accept="application/pdf, .pdf, .png, .jpg, .jpeg"
                                                id="file_memo" class="form-control lampiran" name="file_memo">
                                            <input type="hidden" name="existing_file" id="existing_file">
                                            <div id="file-info" class="mt-2" style="display: none;">
                                                <p class="mb-1">
                                                    <strong>Lampiran saat ini:</strong>
                                                    <a href="#" id="current-file-link" target="_blank"></a>
                                                </p>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    id="remove-file-btn">
                                                    <i class="bi bi-trash"></i> Hapus & Ganti File
                                                </button>
                                            </div>
                                            <label>Lampiran (optional) </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="final-pane" role="tabpanel" aria-labelledby="final-tab" tabindex="0">
                        <div class="row">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_draf" class="btn btn-sm btn-warning me-auto" onclick="submit_memo('draf')"><i
                        class="bi bi-archive"></i> Draf</button>

                <button type="button" class="btn btn-sm btn-secondary d-none me-1" id="btn-back">Back</button>
                <button type="button" class="btn btn-sm btn-primary" id="btn-next">
                    <i class="bi bi-arrow-right"></i> Next
                </button>
                <button type="button" class="btn btn-sm btn-primary d-none" id="btn_save" onclick="submit_memo('save')">
                    <i class="bi bi-save"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add -->

<!-- Waiting MEMO -->
<div class="modal fade" id="modal_data_memo" role="dialog">
    <div class="modal-dialog modal-xl center">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="label_modal">Draf</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button"
                    aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                <div class="table-responsive">
                    <table id="dt_memo_modal" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID Memo</th>
                                <th>Nomer</th>
                                <th>Jenis</th>
                                <th>Company</th>
                                <th>Department</th>
                                <th>Judul</th>
                                <th>Category</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Role/Jabatan</th>
                                <th>Content</th>
                                <th>Personal</th>
                                <th>Tujuan</th>
                                <th>Lampiran</th>
                                <th>Approval</th>
                                <th>CC</th>
                                <th>Created By</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Waiting MEMO -->

<div class="modal fade" id="modal_approve" role="dialog">
    <div class="modal-dialog modal-lg center">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="label_modal_approve">Approve Memo</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button"
                    aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <form id="form-approval">
                <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">

                    <!-- Hidden input untuk ID Memo -->
                    <input type="hidden" name="id_memo_approve" id="id_memo_approve">

                    <div class="row">

                        <!-- Kolom Status Approval -->
                        <div class="col-6 mb-3">
                            <div class="form-group position-relative">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0">
                                        <i class="bi bi-check2-circle"></i>
                                    </span>
                                    <div class="form-floating">
                                        <input class="form-control border-start-0 app_judul" readonly value="">
                                        <input type="hidden" name="id_memo"
                                            class="form-control border-start-0 app_id_memo">
                                        <input type="hidden" name="id_approval"
                                            class="form-control border-start-0 app_id_approval">
                                        <input type="hidden" name="ttd_digital"
                                            class="form-control border-start-0 app_ttd_digital">
                                        <label>Judul <b class="text-danger small">*</b></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="form-group position-relative">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0">
                                        <i class="bi bi-check2-circle"></i>
                                    </span>
                                    <div class="form-floating">
                                        <input class="form-control border-start-0 app_category" readonly>
                                        <label>Category <b class="text-danger small">*</b></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group position-relative">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0">
                                        <i class="bi bi-check2-circle"></i>
                                    </span>
                                    <div class="form-floating">
                                        <select name="status_approve" class="form-select border-start-0"
                                            id="approval_status">
                                            <option value="1" selected>Approve</option>
                                            <option value="2">Revisi</option>
                                            <option value="5">Reject</option>
                                        </select>
                                        <label>Status <b class="text-danger small">*</b></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Catatan Revisi (Tersembunyi Awalnya) -->
                        <div class="col-12 mb-3">
                            <div class="form-group position-relative">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0">
                                        <i class="bi bi-pencil-square"></i>
                                    </span>
                                    <div class="form-floating">
                                        <textarea class="form-control border-start-0" rows="3" name="note"
                                            placeholder="Catatan"></textarea>
                                        <label>Catatan <b class="text-danger small">*</b></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- == FORM SELESAI == -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary" style="margin-right:10px;"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-save"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_approve_sekdir" role="dialog">
    <div class="modal-dialog modal-lg center">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="label_modal_approve">Approve Memo Sekdir</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button"
                    aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <form id="form-approval-sekdir">
                <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">

                    <div class="row">

                        <!-- Kolom Status Approval -->
                        <div class="col-6 mb-3">
                            <div class="form-group position-relative">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0">
                                        <i class="bi bi-check2-circle"></i>
                                    </span>
                                    <div class="form-floating">
                                        <input class="form-control border-start-0 app_judul" readonly value="">
                                        <input type="hidden" name="id_memo"
                                            class="form-control border-start-0 app_id_memo">
                                        <input type="hidden" name="id_approval"
                                            class="form-control border-start-0 app_id_approval">
                                        <input type="hidden" name="ttd_digital"
                                            class="form-control border-start-0 app_ttd_digital">
                                        <label>Judul <b class="text-danger small">*</b></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="form-group position-relative">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0">
                                        <i class="bi bi-check2-circle"></i>
                                    </span>
                                    <div class="form-floating">
                                        <input class="form-control border-start-0 app_category" readonly>
                                        <label>Category <b class="text-danger small">*</b></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group position-relative">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0">
                                        <i class="bi bi-check2-circle"></i>
                                    </span>
                                    <div class="form-floating">
                                        <select name="status_approve" class="form-select border-start-0"
                                            id="approval_status_sekdir">
                                            <option value="4" selected>Approve</option>
                                            <!-- <option value="1">Revisi</option> -->
                                            <option value="5">Reject</option>
                                        </select>
                                        <label>Status <b class="text-danger small">*</b></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Catatan Revisi (Tersembunyi Awalnya) -->
                        <div class="col-12 mb-3">
                            <div class="form-group position-relative">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0">
                                        <i class="bi bi-pencil-square"></i>
                                    </span>
                                    <div class="form-floating">
                                        <textarea class="form-control border-start-0" name="note" placeholder="Catatan Revisi"
                                            style="height: 90x;"></textarea>
                                        <label>Note <b class="text-danger small">*</b></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Jadwal Publish -->
                        <div class="col-12 mb-2">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="publish_sekarang"
                                    name="publish_sekarang" checked>
                                <label class="form-check-label" for="publish_sekarang">Publish Sekarang</label>
                            </div>

                            <div id="kolom_jadwal_publish" style="display: none;">
                                <div class="form-group position-relative">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0">
                                            <i class="bi bi-calendar-event"></i>
                                        </span>
                                        <div class="form-floating">
                                            <input type="datetime-local" class="form-control border-start-0"
                                                name="publish_datetime" id="publish_datetime"
                                                placeholder="Jadwal Publish">
                                            <label>Pilih Tanggal & Waktu Publish</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- == FORM SELESAI == -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary" style="margin-right:10px;"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-save"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_history" role="dialog">
    <div class="modal-dialog modal-xl center">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">History Revisi</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button"
                    aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                <div class="table-responsive">
                    <table id="dt_memo_history" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID Memo</th>
                                <th>Judul</th>
                                <th>Feedback</th>
                                <th>Feedback At</th>
                                <th>Feedback By</th>
                                <th>Status</th>
                                <th>Revisi Note</th>
                                <th>Revisi At</th>
                                <th>Revisi By</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right:10px;"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal PIC Admin -->
<div class="modal fade" id="modal_pic_admin" role="dialog">
    <div class="modal-dialog modal-lg center">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Data PIC Admin Memo</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button"
                    aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <button type="button" class="btn btn-sm btn-success" id="btn_export_pic_excel">
                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                    </button>
                    <button type="button" class="btn btn-sm btn-primary" id="btn_show_tambah_pic">
                        <i class="bi bi-plus-circle"></i> Tambah PIC
                    </button>
                </div>
                <div id="form_tambah_pic" class="mb-3 d-none">
                    <div class="d-flex gap-2 align-items-center flex-wrap">
                        <select id="sel_new_pic" style="min-width:300px;">
                            <option value="">-- Pilih Karyawan --</option>
                        </select>
                        <button type="button" class="btn btn-sm btn-success" id="btn_simpan_tambah_pic">
                            <i class="bi bi-check-lg"></i> Simpan
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary" id="btn_batal_tambah_pic">
                            <i class="bi bi-x-lg"></i> Batal
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="dt_admin_pic" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Department</th>
                                <th>Action</th>
                                <th>Updated At</th>
                                <th>Updated By</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal PIC Admin -->

<div class="modal fade" id="modal_add_approval" tabindex="-1" aria-labelledby="modalApprovalLabel" aria-hidden="true"
    data-bs-focus="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalApprovalLabel">Tambah Master Approval Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_add_approval">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="namaApproval" class="form-label">Nama Approval <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control border-custom" id="namaApproval" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="diverifikasiOleh" class="form-label">Diverifikasi Oleh</label>
                        <select id="diverifikasiOleh" name="diverifikasi[]" multiple></select>
                    </div>
                    <div class="mb-3">
                        <label for="disetujuiOleh" class="form-label">Disetujui Oleh</label>
                        <select id="disetujuiOleh" name="disetujui[]" multiple></select>
                    </div>
                    <div class="mb-3">
                        <label for="mengetahuiOleh" class="form-label">Mengetahui Oleh</label>
                        <select id="mengetahuiOleh" name="mengetahui[]" multiple></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary me-1" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>