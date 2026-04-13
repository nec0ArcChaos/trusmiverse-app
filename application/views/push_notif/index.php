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

    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-start">
                                <div class="row">
                                    <div class="col-auto">
                                        <i class="bi bi-app-indicator h5 avatar avatar-40 bg-light-theme rounded"></i>
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <h6 class="fw-medium mb-0"><?= $pageTitle ?></h6>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>

                </div>
                
                

                <div class="card-body">

                    <div class="row">
                        
                        <!-- MULTIPLE -->
                        <div class="col-lg-4">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-heading"></i></span>
                                            <div class="form-floating">
                                                <input type="text" name="title" id="title" class="form-control border-start-0" placeholder="Notification title">
                                                <label>Title</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-chat-right-text"></i></span>
                                            <div class="form-floating">
                                                <input type="text" name="body" id="body" class="form-control border-start-0" placeholder="Notification body">
                                                <label>Message</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person"></i></span>
                                            <div class="form-floating">
                                                <select name="employees" id="employees" class="form-control" multiple>
                                                    <!-- <option value="" selected disabled>Select Employee</option> -->
                                                    <?php foreach ($list_employees as $emp) : ?>
                                                        <option value="<?php echo $emp->fcm_token ?>" data-user_id="<?= $emp->user_id ?>"><?php echo $emp->name ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                                <label>Send To</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="float-end">
                                    <button type="button" class="btn btn-sm btn-outline-theme" onclick="send_to_multiple()">Push Notification <i class="bi bi-send"></i></button>
                                </div>
                            </div>  
                        </div>


                        <!-- TOPIC -->
                        <div class="col-lg-4">

                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-heading"></i></span>
                                            <div class="form-floating">
                                                <input type="text" name="title" id="topic_title" class="form-control border-start-0" placeholder="Notification title">
                                                <label>Title</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-chat-right-text"></i></span>
                                            <div class="form-floating">
                                                <input type="text" name="body" id="topic_body" class="form-control border-start-0" placeholder="Notification body">
                                                <label>Message</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-buildings"></i></span>
                                            <div class="form-floating">
                                                <select name="department" id="department" class="form-control" multiple>
                                                    <!-- <option value="" selected disabled>Select Employee</option> -->
                                                    <?php
                                                    $pattern = '/[!@#$%^&*()_+={}|\[\]:;"<>,.?\/~` \t\n\r\f\v]/';
                                                    foreach ($list_departments as $dept) : ?>
                                                        <option value="<?php echo preg_replace($pattern, '', $dept->department_name) ?>" data-department_id="<?= $dept->department_id ?>"><?php echo $dept->department_name ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                                <label>Send To</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="float-end">
                                    <button type="button" class="btn btn-sm btn-outline-theme" onclick="send_to_topic()">Push To Deparment <i class="bi bi-send"></i></button>
                                </div>
                            </div>  

                        </div>
                        <div class="col-lg-4">

                        </div>
                    </div>
                
                </div>
                
            </div>
        </div>
    </div>
</main>

<!-- Modal Add -->
<div class="modal fade" id="modal_add_request"  aria-labelledby="modal_add_request_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add_request">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_add_request_label">Form</h6>
                        <p class="text-secondary small">Overtime Request For </p>
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
                    <div class="col-12 col-lg-12 col-xl-12 mb-4">
                        <h6 class="title">Detail Request</h6>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-event-fill"></i></span>
                                        <div class="form-floating">
                                            <input type="text" placeholder="Date" name="request_date" id="request_date" value="<?= date('Y-m-d') ?>" required class="form-control border-start-0">
                                            <label>Date</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg clockpicker">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-hourglass-top"></i></span>
                                        <div class="form-floating">
                                            <input type="text" name="in_time" id="in_time" class="form-control border-start-0" required placeholder="--:--">
                                            <label>In Time</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg clockpicker">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-hourglass-bottom"></i></span>
                                        <div class="form-floating">
                                            <input type="text" name="out_time" id="out_time" class="form-control border-start-0" required placeholder="--:--">
                                            <label>Out Time</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-12 mb-2">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                        <div class="form-floating">
                                            <textarea name="reason" id="reason" class="form-control border-start-0" cols="30" rows="5" style="min-height: 80px;" required></textarea>
                                            <label>Reason</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback mb-3">Add valid data </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-md btn-primary" id="btn_save" onclick="save()">Save Request <i class="bi bi-floppy"></i></button>
                    <button type="button" style="display:none" class="btn btn-md btn-success" id="btn_update" onclick="update_request()">Update Request <i class="bi bi-floppy"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add -->




<!-- Modal Add Confirm-->
<div class="modal fade" id="modalAddConfirm" tabindex="-1" aria-labelledby="modalAddConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddConfirmLabel">Form</h6>
                    <p class="text-secondary small">Overtime Request </p>
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
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">Are you sure ?</h6>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-outline-theme" id="btn_save_confirm" onclick="save_request()">Yes, Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add Confirm -->


<!-- Modal Update Confirm-->
<div class="modal fade" id="modalUpdateConfirm" tabindex="-1" aria-labelledby="modalUpdateConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalUpdateConfirmLabel">Form</h6>
                    <p class="text-secondary small">Overtime Request </p>
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
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">Are you sure ?</h6>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-outline-theme" id="btn_udpate_confirm" onclick="confirm_update_request()">Yes, Update</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Update Confirm -->

<!-- Modal Delete Confirm-->
<div class="modal fade" id="modalDeleteConfirm" tabindex="-1" aria-labelledby="modalDeleteConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalDeleteConfirmLabel">Form</h6>
                    <p class="text-secondary small">Delete Request </p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-danger dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">Are you sure ?</h6>
                    <input type="hidden" id="d_time_request_id">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-danger" id="btn_udpate_confirm" onclick="confirm_delete_request()">Yes, Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete Confirm -->



<!-- Modal Request List -->
<div class="modal fade" id="modal_list_request"  aria-labelledby="modal_list_request_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_list_request">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modal_list_request_label">List</h6>
                        <p class="text-secondary small">Overtime Request</p>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="dropdown d-inline-block">
                            <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">

                    <div class="row mt-3">
                        <div class="col col-sm-auto">
                            <div class="input-group input-group-md reportrange">
                                <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;">
                                <input type="hidden" name="start" value="" id="start_list" />
                                <input type="hidden" name="end" value="" id="end_list" />
                                <a href="javascript:void(0)" class="input-group-text text-secondary bg-none" onclick="dt_overtime_request_list(1)"><i class="bi bi-search"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" style="padding: 10px;">
                                <table id="dt_overtime_request_list" class="table table-sm table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Overtime Requests</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Request List -->


<!-- Modal Approve Confirm-->
<div class="modal fade" id="modalApproveConfirm" tabindex="-1" aria-labelledby="modalApproveConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalApproveConfirmLabel">Form</h6>
                    <p class="text-secondary small">Approve Request </p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-danger dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">Are you sure ?</h6>
                    <input type="hidden" id="d_time_request_id">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-danger" id="btn_udpate_confirm" onclick="confirm_approve_request()">Yes, Approve</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Approve Confirm -->