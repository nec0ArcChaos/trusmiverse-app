<main class="main mainheight">
    <!-- <div class="container-fluid" style="background-color: #e6ecf9;"> -->
    <div class="container-fluid">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <!-- <p class="text-secondary">Dashboard Timeline Project</p> -->
            </div>
            <div class="col col-sm-auto">
                <select class="form-control form-control-lg border-custom" id="select_project">
                    <option value="" selected disabled>-- Pilih Project --</option>
                    <?php foreach ($project as $item) : ?>
                        <option value="<?= $item->id_project ?>"><?= $item->project ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col col-1">
                <div class="input-group input-group-sm border-custom">
                    <input type="text" class="form-control form-control-lg range px-2 border-custom" style="cursor: pointer;" id="select_year" placeholder="<?= date('Y') ?>" value="<?= date('Y') ?>">
                    <span class="input-group-text bg-transparent border-0">
                        <i class="bi bi-calendar-event"></i>
                    </span>
                </div>
            </div>
            <div class="col col-sm-auto">
            <button class="btn bg-warning" onclick="approval()">
                    <i class="bi bi-journal-check"></i>
                    Approval
                </button>
                <button class="btn bg-purple" onclick="add_new_task()" style="border-radius: 5px; color: white;">
                    <i class="bi bi-plus"></i>
                    Pekerjaan
                </button>
                
                <!-- <button class="btn btn-sm btn-primary" onclick="add()" style="border-radius: 5px; color: white;">
                    <i class="bi bi-plus"></i>
                    Pekerjaan
                </button> -->
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">

            <!-- card_resume_pekerjaan -->
            <?php $this->load->view('timeline_project/_content/card_resume_pekerjaan'); ?>
            <!-- // card_resume_pekerjaan -->

            <!-- card_pekerjaan_minggu_ini -->
            <?php $this->load->view('timeline_project/_content/card_pekerjaan_minggu_ini'); ?>
            <!-- // card_pekerjaan_minggu_ini -->

            <!-- card_resume_data -->
            <?php $this->load->view('timeline_project/_content/card_resume_data'); ?>
            <!-- // card_resume_data -->

            <!-- card_aktivitas -->
            <?php $this->load->view('timeline_project/_content/card_aktivitas'); ?>
            <!-- // card_aktivitas -->

        </div>
        <div class="row">
            <?php $this->load->view('timeline_project/_content/card_resume_head'); ?>
            <?php $this->load->view('timeline_project/_content/card_resume_hr'); ?>
            <?php $this->load->view('timeline_project/_content/card_resume_marcom'); ?>
        </div>
        <div class="row">

            <!-- card_list_pekerjaan -->
            <?php $this->load->view('timeline_project/_content/card_list_pekerjaan'); ?>
            <!-- // card_list_pekerjaan -->

        </div>
    </div>
    <footer class="footer m-0 p-0">
        <div class="container-fluid">
            <div class="row">

                <div class="col-6 py-2 align-self-center">
                    <p class="small text-dark m-0" style="font-size: 6pt;">
                        <i class="bi bi-circle-fill text-red"></i>
                        <span class="text-dark">
                            &lt; 60<span class="text-secondary small">%
                            </span></span>
                        &nbsp;&nbsp;&nbsp;
                        <i class="bi bi-circle-fill text-yellow"></i>
                        <span class="text-dark"> 60<span class="text-secondary small">%</span> - 75<span class="text-secondary small">%</span></span>
                        &nbsp;&nbsp;&nbsp;
                        <i class="bi bi-circle-fill text-green"></i>
                        <span class="text-dark"> &gt; 75<span class="text-secondary small">%</span></span>
                        &nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;
                        <span class="text-secondary" style="font-size: 6pt;"><i>Angka</i></span>
                        &nbsp;
                        <span class="text-dark" style="font-size: 7pt;">7 / 10 (70%)</span>
                        &nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;
                        <span class="text-secondary" style="font-size: 6pt;"><i>Cara Baca</i></span>
                        &nbsp;
                        <span class="text-dark" style="font-size: 7pt;">Actual / Target (Achieve)</span>
                    </p>
                </div>
                <div class="col-6 py-2 text-right">
                    <span class="text-secondary float-end " style="font-size: 8pt">Copyright @2024, IT Trusmi Group</span>
                </div>
            </div>
        </div>
    </footer>
</main>


<!-- Modal Add Task -->
<div class="modal fade" id="modal_add">
    <div class="modal-dialog modal modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-primary">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light text-primary rounded"></i>
                </div>
                <div class="col">
                    <h5 class="fw-bold mb-0 text-white" id="modal-list-waiting-resignationLabel">Tambah Pekerjaan</h5>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-white dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <form id="form_pekerjaan">


                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6 mb-2">
                            <label class="required">Project</label>
                            <input type="text" name="id_project" class="form-control border-custom" value="" required="required" readonly>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 mb-2">
                            <label class="required">Department</label>
                            <input type="text" name="id_department" class="form-control border-custom" value="" required="required" readonly>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col">
                            <label class="required">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control border-custom" value="" required="required">
                        </div>
                    </div>
                    <div class="row mt-1" id="row_sub_pekerjaan_container">
                        <div class="row mt-1 sub-pekerjaan">
                            <div class="col-10">
                                <label class="required">Sub Pekerjaan 1</label>
                                <input type="text" name="pekerjaan[]" class="form-control border-custom" value="" required="required">
                            </div>
                            <div class="col-2 d-flex align-items-center">
                                <button type="button" class="btn btn-success btn-sm btn-add"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="m-1 btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="m-1 btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Add Task -->
<div class="modal fade" id="modal_add_task" aria-labelledby="modal_add_task_label" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-soft-purple">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light text-purple rounded"></i>
                </div>
                <div class="col">
                    <h5 class="fw-bold mb-0 text-white" id="modal-list-waiting-resignationLabel">Tambah Detail Pekerjaan</h5>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-white dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Project</label>
                        <select name="id_project" id="id_project" class="form-control form-control-lg border-custom">
                        </select>
                        <!-- <div class="ui form">
                            <div class="field">
                            </div>
                        </div> -->
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Department</label>
                        <select name="id_department" id="id_department" class="form-control form-control-lg border-custom">
                        </select>
                        <!-- <div class="ui form">
                            <div class="field">
                            </div>
                        </div> -->
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Pekerjaan</label>
                        <select name="id_pekerjaan" id="id_pekerjaan" class="form-control form-control-lg border-custom">
                        </select>
                        <!-- <div class="ui form">
                            <div class="field">
                            </div>
                        </div> -->
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Sub Pekerjaan</label>
                        <select name="id_sub_pekerjaan" id="id_sub_pekerjaan" class="form-control form-control-lg border-custom">
                        </select>
                        <!-- <div class="ui form">
                            <div class="field">
                            </div>
                        </div> -->
                    </div>
                    <!-- <div class="col-12 d-none" id="link_add">
                        <center><a onclick="add()" class="btn btn-sm btn-link"><i class="bi bi-plus"></i> Tidak menemukan pekerjaan yang dimaksud? Tambahkan disini</a></center>
                    </div> -->
                    <div class="col-12 col-md-12 col-lg-12 mb-2">
                        <label class="required">PIC</label>
                        <select name="id_pic" id="id_pic" class="form-control form-control-lg border-custom" multiple="">
                        </select>
                        <!-- <div class="ui form">
                            <div class="field">
                            </div>
                        </div> -->
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Tanggal Mulai</label>
                        <input type="date" min="<?= date('Y-m-d') ?>" class="form-control border-custom" name="start" id="start">
                        
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Deadline</label>
                        <input type="date" min="<?= date('Y-m-d') ?>" class="form-control border-custom" name="end" id="end">
                        
                    </div>
                </div>
                <div class="row">
                    <div class="mb-2 col-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <label class="form-label-custom required small mb-1" for="detail">Detail Pekerjaan</label>
                                <div class="input-group border-custom mb-3">
                                    <span class="input-group-text bi bi-file-earmark-font"></span>
                                    <input type="text" class="form-control border-custom" name="detail" id="detail" placeholder="Detail Pekerjaan">
                                </div>

                                <label class="form-label-custom required small mb-1" for="output">Output</label>
                                <div class="input-group mb-3 border-custom">
                                    <span class="input-group-text bi bi-award"></span>
                                    <input type="text" class="form-control border-custom" name="output" id="output" placeholder="Output Pekerjaan">
                                </div>

                                <label class="form-label-custom small mb-1" for="target">Target</label>
                                <div class="input-group mb-3 border-custom">
                                    <span class="input-group-text bi bi-pin"></span>
                                    <input type="number" class="form-control border-custom" name="target" id="target" placeholder="Target Pencapaian Pekerjaan, contoh: 100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="m-1 btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="m-1 btn bg-soft-purple" onclick="save_task()">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_approval" tabindex="-1" aria-labelledby="modal_change" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-light-yellow">
                <div class="col-auto">
                    <i class="bi bi-journal-check h5 avatar avatar-40 bg-light text-purple rounded"></i>
                </div>
                <div class="col">
                    <h5 class="fw-bold mb-0" id="modal-list-waiting-resignationLabel">Approval Request Change</h5>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-responsive table-striped table-hover" id="table_approval">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pekerjaan</th>
                                    <th>Last Start</th>
                                    <th>Last End</th>
                                    <th>Req. Start</th>
                                    <th>Req. End</th>
                                    <th>Note</th>
                                    <th>Request By</th>
                                    <th>Request At</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="col-12">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="m-1 btn btn-default" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="update_approve" tabindex="-1" aria-labelledby="modal_change" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-light-red">
                <div class="col-auto">
                    <i class="bi bi-journal-arrow-up h5 avatar avatar-40 bg-light text-purple rounded"></i>
                </div>
                <div class="col">
                    <h5 class="fw-bold mb-0" id="modal-list-waiting-resignationLabel">Feedback Approval</h5>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <form id="form_update_approve">
                <div class="modal-body">
                    <!-- <div class="row">
                        <div class="col-12 mb-2">
                            <input type="hidden" value="" name="id_detail">
                            <label for="">Project</label>
                            <input type="text" name="project" class="form-control" value="" readonly>
                        </div>
                        <div class="col-6 mb-2">
                            <label for="">Pekerjaan</label>
                            <input type="text" name="nama_pekerjaan" class="form-control" value="" readonly>
                        </div>
                        <div class="col-6 mb-2">
                            <label for="">Sub Pekerjaan</label>
                            <input type="text" name="sub_pekerjaan" class="form-control" value="" readonly>
                        </div>
                        <div class="col-12 mb-2">
                            <label for="">Detail Pekerjaan</label>
                            <input type="text" name="detail_pekerjaan" class="form-control" value="" readonly>
                        </div>
                    </div> -->
                    <!-- <div class="row">
                        <div class="col-12 col-md-6 col-lg-6 mb-2">
                            <label class="required">Start</label>
                            <input type="date" name="start" class="form-control border-custom" value="" required="required">
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 mb-2">
                            <label class="required">End</label>
                            <input type="date" name="end" class="form-control border-custom" value="" required="required">
                        </div>
                    </div> -->
                    <input type="hidden" name="id_req" id="id_req" value="">
                    <input type="hidden" name="id_detail" id="id_detail_req" value="">
                    <div class="row">
                        <div class="col">
                            <label for="">Status Approve</label>
                            <select name="status" class="form-control border-custom">
                                <option value="2">Approve</option>
                                <option value="3">Reject</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <label class="required">Note</label>
                            <textarea name="note" class="form-control border-custom" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="m-1 btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="m-1 btn btn-danger text-white">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>