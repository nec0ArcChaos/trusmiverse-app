<main class="main mainheight">
    
    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col-auto">
                                    &nbsp;&nbsp;<i class="bi bi-whatsapp text-success" style="font-size:18pt;"></i>
                                </div>
                                <div class="col-auto align-self-center">
                                    <h6 class="fw-medium">WA Blast</h6>
                                </div>
                                <div class="col-auto align-self-center">
                                    <form method="POST" id="form_filter">
                                        <div class="input-group input-group-md reportrange">
                                            <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                                            <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                                            <input type="hidden" name="start" value="" id="start"/>
                                            <input type="hidden" name="end" value="" id="end"/>
                                            <a href="javascript:void(0)" onclick="filter_blast()" style="margin-top:2px">
                                                <span class="input-group-text text-secondary bg-none">
                                                    <i class="bi bi-search"></i>
                                                </span>
                                            </a>
                                        </div>
                                    </form>
                                </div>
                                
                                <div class="col" style="; padding-right:20px; padding-top:10px">
                                    <button class="btn btn-success" style="float:right; color:white" onclick="send_wa_blast()">
                                        Send WA
                                        <i class="bi bi-send"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_wa_blast" class="table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <!-- <th>#</th> -->
                                    <th>Content</th>
                                    <th>Message</th>
                                    <th>Send To</th>
                                    <th>Attachment</th>
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
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="form_add">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="modalAddLabel">Form</h6>
                        <p class="text-secondary small">Whatsapp Blast</p>
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
                        <h6 class="title">Content WhatsApp</h6>
                        <div class="row">

                            <form id="form_blast">

                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-whatsapp"></i></span>
                                            <div class="form-floating">
                                                <input type="text" class="form-control border-start-0" id="title_blast" name="title">
                                                <label>Title</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                    <div class="form-group row">
                                        <label class="col-1 col-form-label col-form-label-sm1">
                                            <i class="bi bi-person" style="font-size:14pt;color:blue;padding-left:17px"></i>
                                        </label>
                                        <div class="col-11" style="margin-left: -40px">
                                            <select class="form-control" name="send_to[]" id="send_to" multiple="multiple" onchange="pilih_karyawan()">       
                                            </select>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                                <div class="col-12 col-md-12 mb-2">
                                    <label class="col-1 col-form-label col-form-label-sm1">
                                        <i class="bi bi-chat" style="font-size:14pt;color:blue;padding-left:17px"></i>
                                    </label>
                                    <label class="col-11 text-muted" style="margin-left:-40px">
                                        Message
                                    </label>
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <div class="form-control">
                                                <textarea name="message" id="message" class="form-control border-start-0" cols="30" rows="5" style="min-height: 80px;"  placeholder="Type the content here!"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-2">
                                    <div class="form-group row">
                                        <label class="col-1 col-form-label col-form-label-sm1">
                                            <i class="bi bi-file-text" style="font-size:14pt;color:blue;padding-left:17px"></i>
                                        </label>
                                        <label class="col-11 text-muted" style="margin-left:-40px; margin-top:10px">
                                            Attachment
                                        </label>
                                        <div class="form-group mb-3 position-relative">
                                            <div class="input-group input-group-lg">
                                                <div class="form-control">
                                                    <div class="check-valid dropzone dropzone-floating-label" id="dropzoneServerFiles"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mb-3">Add valid data </div>
                                    <input type="hidden" name="attachment" id="attachment" value="" >                            
                                    <!-- <div id="file_uploads">
                                    </div> -->
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-theme" id="btn_submit" onclick="submit_blast()">Submit</button>
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
                    <p class="text-secondary small">Send WA Blast </p>
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
                <button type="button" class="btn btn-md btn-outline-theme" id="btn_save_confirm" onclick="confirm_wa_blast()">Yes, Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add Confirm -->



<!-- Modal Add Confirm-->
<div class="modal fade" id="modalAddConfirmDeleteFile" tabindex="-1" aria-labelledby="modalAddConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddConfirmLabel">Confirmation</h6>
                    <p class="text-secondary small">Delete Attachment? </p>
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
                <div id="temp_file"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-outline-theme" id="btn_save_confirm" onclick="delete_attachment()">Yes, Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add Confirm -->