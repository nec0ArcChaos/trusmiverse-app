<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
            </div>
            <div class="col col-sm-auto">
                <div class="input-group input-group-md reportrange">
                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;">
                    <input type="hidden" name="startdate" value="" id="start" />
                    <input type="hidden" name="enddate" value="" id="end" />
                    <span class="input-group-text text-secondary bg-none" id="btn_filter"><i class="bi bi-calendar-event"></i></span>
                </div>
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

    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-card-list h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List <?= $pageTitle ?></h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">

                            <div style="display: flex;justify-content: space-between;">
                                <div>
                                    <?php if (in_array($this->session->userdata('user_id'), [1, 3388, 6183])): ?>
                                        <button type="button" class="btn btn-primary" onclick="input_review()">
                                            Input Review</button>
                                    <?php endif ?>
                                    <button type="button" class="btn btn-success" onclick="review_head()">Review Head</button>
                                    <button type="button" class="btn btn-info" onclick="pic_check()">Check Review</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_review_all" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>ID Review</th>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <th>Head</th>
                                    <th>PIC</th>
                                    <th>Aplikasi</th>
                                    <th>Navigation</th>
                                    <th>Deadline Head</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th>Head At</th>
                                    <th>Lock Pic</th>
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
            <div class="card border-0 mt-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-card-list h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Detail PIC Check</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_list_detail" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-nowrap small text-center">ID Review</th>
                                    <th class="text-nowrap small text-center">Company</th>
                                    <th class="text-nowrap small text-center">Department</th>
                                    <th class="text-nowrap small text-center">Head</th>
                                    <th class="text-nowrap small text-center">PIC</th>
                                    <th class="text-nowrap small text-center">Deadline PIC</th>
                                    <th class="text-nowrap small text-center">Aplikasi</th>
                                    <th class="text-nowrap small text-center">Link</th>
                                    <th class="text-nowrap small text-center">Menu</th>
                                    <th class="text-warp small text-center" style="width: 121px;">Impact Category</th>
                                    <th class="text-nowrap small text-center">Impact</th>
                                    <th class="text-nowrap small text-center">Status</th>
                                    <th class="text-nowrap small text-center">Kepuasan Aplikasi</th>
                                    <th class="text-nowrap small text-center">Kesesuain Request Fitur</th>
                                    <th class="text-nowrap small text-center">Impact System</th>
                                    <th class="text-nowrap small text-center">Kesesuain UI/UX</th>
                                    <th class="text-nowrap small text-center">Improve UI</th>
                                    <th class="text-nowrap small text-center">Improve UX</th>
                                    <th class="text-nowrap small text-center">Note</th>
                                    <th class="text-nowrap small text-center">improvement</th>
                                    <th>Attachment</th>
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

<!-- Modal Add review-->
<div class="modal fade" id="modal_input" aria-labelledby="modal_input_dokumen" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_add_review">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-person-workspace h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_input_dokumen">Input <?= $pageTitle ?></h6>
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

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label-custom required small" for="company">Company</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-bank"></i></span>
                                <select name="company" id="company" class="form-control border-custom">

                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom required small" for="department">Department</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-bank2"></i></span>

                                <select name="department" id="department" class="form-control border-custom">
                                    <option data-placeholder="true" value="#">-- Pilih Department --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label-custom required small" for="head">Head</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-person-check-fill"></i></span>
                                <select name="head" id="head" class="form-control border-custom">
                                    <option data-placeholder="true" value="#">-- Pilih Head --</option>
                                </select>
                                <!-- <input type="text" class="form-control border-custom" name="head_name" id="head_name" readonly>
                                <input type="hidden" class="form-control border-custom" name="head" id="head"> -->
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom required small" for="aplikasi">Aplikasi</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-app"></i></span>

                                <select name="aplikasi" id="aplikasi" class="form-control border-custom">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label-custom required small" for="deadline_head">Tanggal Deadline</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                <input type="date" class="form-control border-custom" name="deadline_head" id="deadline_head">
                            </div>
                        </div>
                        <div class="col-6 d-flex align-items-center">
                            <button type="button" class="btn btn-sm btn-info" onclick="listNavigation()"><i class="bi bi-card-list"></i> List Navigation</button>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="table-responsive">
                            <table id="dt_list_nav_temp" class="table nowrap table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Aplikasi</th>
                                        <th>Link</th>
                                        <th>Menu</th>
                                        <th>Sub Menu</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-md btn-primary" id="btn_save_review" onclick="save_review()" hidden>Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Modal Add -->
<!-- modal list navigation -->
<div class="modal fade" id="modal_list" aria-labelledby="modal_list_navigation" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add_pembelajar">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_list_navigation">List Navigation</h6>
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
                    <div class="table-responsive">
                        <table id="dt_list_nav" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Aplikasi</th>
                                    <th>Link</th>
                                    <th>Menu</th>
                                    <th>Sub Menu</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal list navigation -->
<!-- Modal add temp -->
<div class="modal fade" id="modal_add_temp" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add_temp" enctype="multipart/form-data">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Form add navigation</h6>
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
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label-custom required small" for="apl">Aplikasi</label>
                            <div class="input-group border-custom">
                                <input type="text" class="form-control" name="apl" id="apl" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom required small" for="menu">Menu</label>
                            <div class="input-group border-custom">
                                <input type="text" class="form-control" name="menu" id="menu" readonly>
                                <input type="hidden" class="form-control" name="id_navigation" id="id_navigation">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label-custom required small" for="sub_menu">Sub Menu</label>
                            <div class="input-group border-custom">
                                <input type="text" class="form-control" name="sub_menu" id="sub_menu" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom small" for="attachment">Attachment (Opsional)</label>
                            <div class="input-group border-custom">
                                <input type="file" class="form-control" name="attachment" id="attachment">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-md btn-primary" id="btn_save_temp" onclick="save_temp()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal add temp -->
<!-- modal list review head -->
<div class="modal fade" id="modal_list_head" aria-labelledby="modal_list_head" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add_pembelajar">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">List Review Head</h6>
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
                    <div class="table-responsive">
                        <table id="dt_list_review_head" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID Review</th>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <th>Head</th>
                                    <th>Deadline Head</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal list review head -->
<!-- Modal list item review head -->
<div class="modal fade" id="modal_add_pic" aria-labelledby="modal_add_pic_head" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_add_head">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-person-workspace h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Add PIC Review</h6>
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
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label-custom required small" for="id_review">ID Review</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-card-list"></i></span>
                                <input name="id_review" id="id_review" class="form-control border-custom" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom required small" for="head_pic">Head</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input name="head_pic" id="head_pic" class="form-control border-custom" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label-custom required small" for="deadline_h">Deadline</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                <input name="deadline_h" id="deadline_h" class="form-control border-custom" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="table-responsive">
                            <table id="dt_list_item_review_head" class="table nowrap table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="width: 300px;">PIC</th>
                                        <th>Deadline PIC</th>
                                        <th>Aplikasi</th>
                                        <th>Link</th>
                                        <th>Menu</th>
                                        <th>Sub Menu</th>
                                        <th>Attachment</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-md btn-primary" id="btn_save_head" onclick="save_review_head()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal list item review head -->
<!-- modal add pic & deadline -->
<div class="modal fade" id="modal_form_pic" aria-labelledby="modal_form_pic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add_pic">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Form add PIC</h6>
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
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label-custom required small" for="apl_pic">Aplikasi</label>
                            <div class="input-group border-custom">
                                <input type="text" class="form-control" name="apl_pic" id="apl_pic" readonly>
                                <input type="hidden" class="form-control" name="id_item" id="id_item">
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom required small" for="menu_pic">Menu</label>
                            <div class="input-group border-custom">
                                <input type="text" class="form-control" name="menu_pic" id="menu_pic" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label-custom required small" for="pic">PIC</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-people"></i></span>
                                <select name="pic" id="pic" class="form-control border-custom">

                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom required small" for="deadline_pic">Deadline</label>
                            <div class="input-group border-custom">
                                <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                <select name="deadline_pic" id="deadline_pic" class="form-control border-custom">
                                    <option value="#" disabled>-- Pilih Deadline --</option>
                                    <option value="1">1 hari</option>
                                    <option value="2">2 hari</option>
                                    <option value="3">3 hari</option>
                                    <option value="4">4 hari</option>
                                    <option value="5">5 hari</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-md btn-primary" id="btn_save_pic" onclick="save_pic()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal add pic & deadline -->
<!-- modal check review pic -->
<div class="modal fade" id="modal_list_pic" aria-labelledby="modal_list_pic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add_pembelajar">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">List Review PIC</h6>
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
                    <div class="table-responsive">
                        <table id="dt_list_pic" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID Review</th>
                                    <th>PIC</th>
                                    <th>Deadline PIC</th>
                                    <th>Aplikasi</th>
                                    <th>Link</th>
                                    <th>Menu</th>
                                    <th>Attachment</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal check review pic -->
<!-- modal add check pic -->
<div class="modal fade" id="modal_input_check_pic" aria-labelledby="modal_input_check_pic" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_check_pic">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-person-workspace h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Input PIC</h6> <span id="link_pic"></span>
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

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label-custom required small" for="id_review_check">ID Review</label>
                            <input type="text" class="form-control border-custom" name="id_review_check" id="id_review_check" readonly>
                            <input type="hidden" class="form-control border-custom" name="id_item_check" id="id_item_check">
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom required small" for="aplikasi_check">Aplikasi</label>

                            <input type="text" class="form-control border-custom" name="aplikasi_check" id="aplikasi_check" readonly>

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label-custom required small" for="menu_check">Menu</label>
                            <input type="text" class="form-control border-custom" name="menu_check" id="menu_check" readonly>

                        </div>
                        <div class="col-6">
                            <label class="form-label-custom required small" for="sub_menu_check">Sub Menu</label>
                            <input type="text" class="form-control border-custom" name="sub_menu_check" id="sub_menu_check" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label-custom required small" for="status">Status</label>
                            <select name="status" id="status" class="form-control border-custom">

                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom required small" for="kesesuaian_aplikasi">Kesesuain Request Fitur</label>
                            <select name="kesesuaian_aplikasi" id="kesesuaian_aplikasi" class="form-control border-custom">
                                <option data-placeholder="true" value="#">-- Pilih Kesesuaian --</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label-custom required small" for="impact_category">Impact Category</label>
                            <select name="impact_category[]" id="impact_category" class="form-control border-custom" multiple>
                                <option data-placeholder="true" value="#">-- Pilih Impact Category --</option>
                            </select>

                        </div>
                        <div class="col-6">
                            <label class="form-label-custom required small" for="kepuasan_aplikasi">Kepuasan Fitur</label>
                            <div class="input-group">
                                <div class="stars">
                                    <input type="radio" id="star5_quality" name="kepuasan_aplikasi" value="5" />
                                    <label for="star5_quality" title="5 stars">★</label>
                                    <input type="radio" id="star4_quality" name="kepuasan_aplikasi" value="4" />
                                    <label for="star4_quality" title="4 stars">★</label>
                                    <input type="radio" id="star3_quality" name="kepuasan_aplikasi" value="3" />
                                    <label for="star3_quality" title="3 stars">★</label>
                                    <input type="radio" id="star2_quality" name="kepuasan_aplikasi" value="2" />
                                    <label for="star2_quality" title="2 stars">★</label>
                                    <input type="radio" id="star1_quality" name="kepuasan_aplikasi" value="1" />
                                    <label for="star1_quality" title="1 star">★</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label-custom required small" for="status_sistem">Impact System</label>
                            <select name="status_sistem" id="status_sistem" class="form-control border-custom">
                                <option data-placeholder="true" value="#">-- Pilih Status --</option>
                                <option value="Sangat Berimpact">Sangat Berimpact</option>
                                <option value="Kurang Berimpact">Kurang Berimpact</option>
                                <option value="Tidak Berimpact">Tidak Berimpact</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label-custom required small" for="kesesuaian_uiux">Kesesuaian UI/UX?</label>
                            <select name="kesesuaian_uiux" id="kesesuaian_uiux" class="form-control border-custom">
                                <option data-placeholder="true" value="#">-- Pilih Kesesuaian --</option>
                                <option value="Sesuai">Sesuai</option>
                                <option value="Tidak Sesuai">Tidak Sesuai</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3" id="div_uiux" style="display: none;">
                        <div class="col-6">
                            <label class="form-label-custom required small" for="ui">Improve UI</label>
                            <textarea name="ui" id="ui" rows="2" val="Layout/Struktur : 
                                    Teks & Data : ">

                                </textarea>
                        </div>

                        <div class="col-6">
                            <label class="form-label-custom required small" for="ux">Improve UX</label>
                            <textarea name="ux" id="ux" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label required small" for="impact">Impact</label>
                            <textarea name="impact" id="impact" rows="2"></textarea>
                        </div>
                        <div class="col-6">
                            <label class="form-label required small" for="improvement">Improvement</label>
                            <textarea name="improvement" id="improvement" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label required small" for="note">Note</label>
                            <textarea name="note" id="note" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-md btn-primary" id="btn_save_check_pic" onclick="save_check_pic()">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal add check pic -->
<!-- modal detail review -->
<div class="modal fade" id="modal_detail" aria-labelledby="modal_detail" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add_pembelajar">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Detail Review</h6>
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
                    <div class="table-responsive">
                        <table id="dt_detail" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <th>Head</th>
                                    <th>PIC</th>
                                    <th>Deadline PIC</th>
                                    <th>Status</th>
                                    <th>Kepuasan Aplikasi</th>
                                    <th>Kesesuain Request Fitur</th>
                                    <th>Note</th>
                                    <th>Impact</th>
                                    <th>Impact Category</th>
                                    <th>Attachment</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal detail review -->