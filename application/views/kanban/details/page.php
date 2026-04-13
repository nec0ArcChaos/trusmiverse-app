
<div class="col-lg-6 col-md-12 col-sm-12">

    <div class="row">
        <div class="col">

            <ul class="nav detail_tabs nav-WinDOORS">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0)" id="nav_activity"
                        onclick="activateTab('activity')">
                        Activity Log
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0)" id="nav_evaluasi" onclick="activateTab('evaluasi')">
                        Evaluasi
                    </a>
                </li>
                <li class=" nav-item">
                    <a class="nav-link" href="javascript:void(0)" id="nav_files" onclick="activateTab('files')">
                        Files
                    </a>
                </li>
                
            </ul>

        </div>
    </div>
    <hr>

    <input type="hidden" id="detail_id_task">
    <input type="hidden" id="detail_status_before">
    <input type="hidden" id="detail_status_after">

    <div class="row" style="display:none" id="spinner_loading">
        <div class="col text-center center-spinner">
            <div class="spinner-border text-primary mt-3" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- ACTIVITY LOG PAGE -->
    <div class="row detail_pages" id="activity_page">
        <div class="col">
            <div class="table-responsive" style="padding: 10px;">
                <table id="dt_log_history" class="table table-borderless" style="width:100%" data-filtering="false">
                    <thead>
                        <tr class="text-muted">
                            <th></th>                            
                            <th></th>                            
                            <th></th>                            
                            <th></th>                            
                        </tr>
                    </thead>
                    <tbody id="body_log_history">

                    </tbody>
                </table>
            </div>
            <div class="row align-items-center mx-0 detail_pages">
                <!-- <div class="col-6">
                    <span class="hide-if-no-paging">
                        Showing <span class="footablestot"></span> page
                    </span>
                </div>
                <div class="col-6 footable-pagination"></div> -->
            </div>
        </div>
    </div>
    <!-- ACTIVITY LOG PAGE -->

    <!-- EVALUASI PAGE -->
    <div class="row detail_pages" id="evaluasi_page">
        <div class="col">
            <!-- <div class="row">
                <div class="col-auto ms-auto">
                    <div class="input-group border">
                        <span class="input-group-text text-theme"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                </div>
            </div> -->
            <div class="table-responsive" style="padding: 10px;">
                <table id="dt_get_evaluasi" class="table table-borderless" style="width:100%">
                    <tr class="text-muted">
                            <th></th>                            
                            <th></th>                            
                            <th></th>                            
                    </tr>
                    <tbody id="body_get_evaluasi">

                    </tbody>
                </table>
                <div class="row align-items-center mx-0 detail_pages">
                    <div class="col-6">
                        <span class="hide-if-no-paging">
                            Showing <span class="footablestot"></span> page
                        </span>
                    </div>
                    <div class="col-6" class="footable-pagination"></div>
                </div>
            </div>

        </div>
    </div>
    <!-- EVALUASI PAGE -->

    <!-- FILES PAGE -->
    <div class="row detail_pages" id="files_page" style="display:none">
        <div class="col p-3">
            <div class="row mb-3" id="body_files_page" style="flex-grow: 1">
            </div>
            <div class="row mb-3" style="margin-top: auto;">
                <div class="col">
                    <form id="fileForm">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                <div class="form-floating">
                                    <input type="text" name="nama_file" id="nama_file" placeholder="File Name" value="" required="" class="form-control border-start-0" onchange="remove_invalid('nama_file')" oninput="remove_invalid('nama_file')">
                                    <label>File Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-upload"></i></span>
                                <div class="form-floating">
                                    <input type="file" name="file" id="fileInput" capture="environment" hidden onchange="file_selected()">
                                    <input type="text" id="file_string" placeholder="Click to select file" class="form-control border-start-0" onclick="addFileInput()" onchange="remove_invalid('file_string')" oninput="remove_invalid('file_string')">
                                    <label>Click to select file</label>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-theme" id="btn_save_upload" onclick="upload_file()">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- FILES PAGE -->


    <div class="position-fixed right-0 bottom-0 end-0 p-3" style="z-index: 99999999">
        <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bi bi-check-circle-fill text-success" id="upload_check" style="display:none"></i>
                <div class="spinner-border spinner_upload text-success" id="spinner_upload" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                &nbsp;
                <strong class="me-auto" id="uploaded_status">Uploaded 1 file</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"
                    onclick="hide_upload_toast()"></button>
            </div>
            <div class="toast-body">
                <div class="row">
                    <div class="col-auto" id="col_preview">
                        <img class="coverimg" id="uploaded_preview" src="" alt="" width="70">
                    </div>
                    <div class="col ps-0">
                        <h6 class="fw-medium mb-0" id="uploaded_name"></h6>
                        <p class="text-secondary small" id="uploaded_date"></p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="progress h-5 mb-1 bg-light-green">
                        <div id="myProgressBar" class="progress-bar bg-green" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
