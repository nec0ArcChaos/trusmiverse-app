<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
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
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <label for="">Filter Tanggal</label>
                        </div>
                        <div class="col col-sm-auto">
                            <div class="input-group input-group-md border rounded reportrange">
                                <span class="input-group-text text-secondary bg-none"><i class="bi bi-calendar-event"></i></span>
                                <input type="text" class="form-control" name="periode" id="periode" value="<?php echo date('Y-m') ?>"/>
                                <a href="javascript:void(0);" class="btn btn-primary" onclick="filter_report()"><i class="ti-search"></i>Filter</a>

                            </div>

                        </div>
                        <div class="col text-end">
                            <!-- <button type="button" class="btn btn-success" onclick="mdl_list_goal_target()"><i class="bi bi-bullseye"></i> Target Goal</button> -->
                            <button type="button" class="btn btn-success"><a href="<?= base_url() ?>bsc_so/master_goals" style="color: white; text-decoration: none;"><i class="bi bi-bullseye"></i>Target Goals</a></button>
                            <button type="button" class="btn btn-success" onclick="mdl_list_goal()"><i class="bi bi-upload"></i> Update Goal</button>
                            <button type="button" class="btn btn-primary" onclick="mdl_list_so()"><i class="bi bi-bookmark-star"></i> Update SO</button>                             
                            <button type="button" class="btn btn-warning" onclick="mdl_list_si()"><i class="bi bi-bookmark"></i> Update SI</button>

                        </div>
                    </div>
                    <br><label for=""><h5>Goals</h5></label><br>

                    <div class="table-responsive" style="padding: 10px;">

                        <table id="tbl_goal_h" class="table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Company</th>                                   
                                    <th>Department</th>                                   
                                    <th>Periode</th>                                   
                                    <th>Perspektive</th>
                                    <th>Sub<br>Perspektive</th>
                                    <th>Goal</th>
                                    <th>Target</th>
                                    <th>Actual</th>
                                    <th>Deviasi</th>
                                    <th>Persentase</th>   
                                    <th>Lampiran</th>                                  
                                    <th>Link</th>                                  

                                    <th>Tipe</th>                                  
                                    <th>Spend</th>                                  
                                    <th>Created at</th>                                  
                                    <th>Created by</th>                                  
                                    <th>Resume</th>                                  

                                </tr>
                            </thead>
                            <tbody></tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <label for=""><h5>Strategy Objective</h5></label>
                        </div>
                        <div class="col col-sm-auto">
                        </div>
                        <div class="col text-end">
                        </div>
                    </div>
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="tbl_so_h" class="table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Company</th>    
                                    <th>Department</th>    
                                    <th>Periode</th>    
                                    <th>Perspective</th>      
                                    <th>Goal</th>                                                        
                                    <th>Strategy</th>                                  
                                    <th>Target</th>
                                    <th>Actual</th>
                                    <th>Acv</th>   
                                    
                                    <th>Status</th>
                                    <th>Lampiran</th>
                                    <th>Link</th>
                                    <th>Tipe</th>                                  
                                    <th>Spend</th>
                                    <th>Created at</th>
                                    <th>Created by</th>
                                    <th>Resume</th>                                  

                                </tr>
                            </thead>
                            <tbody></tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                            <label for=""><h5>Strategy Inisiatif<h5></label>
                        </div>
                        <div class="col col-sm-auto">
                        </div>
                        <div class="col text-end">
                        </div>
                    </div>
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="tbl_si_h" class="table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Company</th>
                                    <th>Department</th>    
                                    <th>Periode</th>    
                                    <th>Perspective</th>      
                                    <th>Goal</th>                                                        
                                    <th>Strategy</th>                                  
                                    <th>Target</th>
                                    <th>Actual</th>
                                    <th>Acv</th>   
                                    
                                    <th>Status</th>
                                    <th>Lampiran</th>
                                    <th>Link</th>
                                    <th>Tipe</th>                                  
                                    <th>Spend</th>
                                    <th>Created at</th>
                                    <th>Created by</th>
                                    <th>Resume</th>                                  

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

<!-- Modal Strategi Objektif -->
<!-- <div class="modal fade" id="mdl_strategi_objektif" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-block bg-light-theme">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Daftar Strategi Objektif</h6>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-sm" id="dt_strategi_objektif">
                        <thead>
                            <tr>
                                <th>Strategi</th>
                                <th>Objektif</th>
                                <th>Inisiatif</th>
                                <th>Actual</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_strategi_objektif">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> -->
<!-- Modal Strategi Objektif -->
<div class="modal fade" id="mdl_strategi_objektif" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header d-block bg-light-theme">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Daftar Strategi Objektif</h6>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="tbl_so" class="table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Company</th>    
                                    <th>Department</th>    
                                    <th>Periode</th>    
                                    <th>Perspective</th>      
                                    <th>Goal</th>                                                        
                                    <th>Strategy</th>                                  
                                    <th>Target</th>
                                    <th>Actual</th>
                                    <th>Acv</th>   
                                    <th>Tipe</th>                                  
                                    <th>Spend</th>
                                    <th>Status</th>
                                    <th>Lampiran</th>
                                    <th>Link</th>

                                </tr>
                            </thead>
                            <tbody></tbody>

                        </table>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Strategi Inisiatif -->
<div class="modal fade" id="modal_strategi_inisiatif" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-block bg-light-orange">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-orange rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Daftar Strategi Inisiatif</h6>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">

                    <table class="table table-hover table-striped" id="dt_strategi_inisiatif">
                        <thead>
                            <tr>
                                <th>Inisiatif</th>
                                <th>Task</th>
                                <th>Actual</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_strategi_inisiatif">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Back</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Strategi Task -->
<div class="modal fade" id="modal_strategi_task" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-block bg-light-purple">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-purple rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Daftar Task</h6>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="dt_strategi_task">
                        <thead>
                            <tr>
                                <th>Task</th>
                                <th>Ketercapaian</th>
                                <th>Actual</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_strategi_task">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Back</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Strategi Ketercapaian -->
<div class="modal fade" id="modal_strategi_ketercapaian" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-block bg-light-theme">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Daftar Ketercapaian</h6>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="dt_strategi_ketercapaian">
                        <thead>
                            <tr>
                                <th>Ketercapaian</th>
                                <th>Target</th>
                                <th>Actual</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_strategi_ketercapaian">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Back</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Input Ketercapaian -->
<!-- <div class="modal fade" id="modal_input_ketercapaian" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-block bg-light-purple">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-purple rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Input Pencapaian</h6>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="" class="small">Target :</label>
                            <input type="text" name="i_target" id="i_target" class="form-control" readonly>
                            <p id="ketercapaian_text"></p>
                        </div>
                        <div class="mb-3">
                            <label for="" class="small">Tipe :</label> 
                            <input type="text" name="i_tipe" id="i_tipe" class="form-control" readonly>
                           
                        </div>
                        <div class="mb-3">
                            <label for="" class="small">Periode :</label> 
                            <input type="text" name="i_periode" id="i_periode" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="mb-3">
                            <label for="" class="small">Actual:</label>
                            <input class="form-control border" type="number" name="i_actual" id="i_actual">
                        </div>
                        <div class="mb-2">
                        <label for="" class="small">Spend :</label> 
                            <input type="text" name="i_spend" id="i_spend" class="form-control" readonly>
                        </div>
                        <div class="mb-2">
                           
                        </div>
                        <div class="mb-2 text-end">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="dt_detail_ketercapaian" width="100%">
                        <thead>
                            <tr>
                                <th width="15%">SO</th>
                                <th width="10%">Target</th>
                                <th width="10%">Actual</th>
                                <th width="10%">Status<br>SO</th>
                                <th width="15%">SI</th>
                                <th width="10%">Target</th>
                                <th width="10%">Actual</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody id="data_so">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Back</button>
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Save</button>

            </div>
        </div>
    </div>
</div> -->

<!-- Modal Input Ketercapaian -->
<div class="modal fade" id="mdl_input_so" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-block bg-light-purple">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-purple rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Input Actual SO</h6>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="" class="small">Objectif :</label>
                            <textarea type="text" name="so_strategy" id="so_strategy" class="form-control border" cols="30" rows="5" readonly></textarea>
                            <!-- <input type="text" name="so_strategy" id="so_strategy" class="form-control" readonly> -->

                            <input type="hidden" name="so_id_so" id="so_id_so" class="form-control" readonly>
                            <input type="hidden" name="so_category" id="so_category" class="form-control" readonly>
                            <input type="hidden" name="so_company_id_so" id="so_company_id_so" class="form-control" readonly>


                            <input type="hidden" name="so_periode" id="so_periode" class="form-control" readonly>
                            <input type="hidden" name="so_target" id="so_target" class="form-control" readonly>

                            <p id="ketercapaian_text"></p>
                        </div>
                        <div class="mb-3">
                            <label for="" class="small">Status</label>
                            <div class="col-12 mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="so_status" id="so_status_inline_radio_1" value="Berhasil" checked>
                                    <label class="form-check-label" for="status_inline_radio_1">Berhasil</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="so_status" id="so_status_inline_radio_2" value="Tidak Berhasil">
                                    <label class="form-check-label" for="status_inline_radio_2">Tidak Berhasil</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="small">Resume</label>
                            <textarea class="form-control border" type="text" name="so_resume" id="so_resume" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="small">Target</label>
                                    <input class="form-control border" type="text" id="so_target_text" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="small">Actual</label>
                                    <input class="form-control border" type="text" name="so_actual" id="so_actual" onkeyup="updateRupiah('so_actual')">
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="" class="small">File</label>
                            <input class="form-control border" type="file" name="so_file" id="so_file">
                        </div>
                        <div class="mb-2">
                            <label for="" class="small">Link</label>
                            <input class="form-control border" type="text" name="so_link" id="so_link">
                        </div>
                        <div class="mb-2 text-end">
                            <button class="btn btn-primary" onclick="save_actual_so()">Simpan</button>

                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="tbl_det_so" width="100%">
                        <thead>
                            <tr>
                                <th>Periode</th>
                                <th>Created By</th>
                                <th>Status</th>
                                <th>Actual</th>
                                <th>Resume</th>
                                <th>File</th>
                                <th>Link</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Back</button>
            </div>
        </div>
    </div>
</div>


<!--  ================ SSSSSSSSSSSSIIIIIIIIIII -->
<div class="modal fade" id="mdl_strategi_inisiatid" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header d-block bg-light-theme">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Daftar Strategi Inisiatif</h6>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="tbl_si" class="table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Company</th>    
                                    <th>Department</th>    
                                    <th>Periode</th>    
                                    <th>Perspective</th>      
                                    <th>Goal</th>                                                        
                                    <th>Strategy</th>                                  
                                    <th>Target</th>
                                    <th>Actual</th>
                                    <th>Acv</th>   
                                    <th>Tipe</th>                                  
                                    <th>Spend</th>
                                    <th>Status</th>
                                    <th>Lampiran</th>
                                    <th>Link</th>

                                </tr>
                            </thead>
                            <tbody></tbody>

                        </table>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_input_si" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-block bg-light-purple">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-purple rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Input Actual SI</h6>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="mb-3">
                        <label for="" class="small">Inisiatif :</label>
                            <textarea type="text" name="si_strategy" id="si_strategy" class="form-control border" cols="30" rows="5" readonly></textarea>

                            <input type="hidden" name="si_id_so" id="si_id_so" class="form-control" readonly>
                            <input type="hidden" name="si_id_si" id="si_id_si" class="form-control" readonly>

                            <input type="hidden" name="si_category" id="si_category" class="form-control" readonly>
                           

                            <input type="hidden" name="si_periode" id="si_periode" class="form-control" readonly>
                            <input type="hidden" name="si_target" id="si_target" class="form-control" readonly>

                            <p id="ketercapaian_text"></p>
                        </div>
                        <div class="mb-3">
                            <label for="" class="small">Status</label>
                            <div class="col-12 mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="si_status" id="si_status_inline_radio_1" value="Berhasil" checked>
                                    <label class="form-check-label" for="status_inline_radio_1">Berhasil</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="si_status" id="si_status_inline_radio_2" value="Jalan Tdk Berhasil">
                                    <label class="form-check-label" for="status_inline_radio_2">Jalan Tdk Berhasil</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="si_status" id="si_status_inline_radio_3" value="Tdk Berhasil">
                                    <label class="form-check-label" for="status_inline_radio_3">Tdk Berhasil</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="si_status" id="si_status_inline_radio_4" value="Progress">
                                    <label class="form-check-label" for="status_inline_radio_4">Progress</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="small">Resume</label>
                            <textarea class="form-control border" type="text" name="si_resume" id="si_resume" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="small">Target</label>
                                    <input class="form-control border" type="text" id="si_target_text" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="small">Actual</label>
                                    <input class="form-control border" type="number" name="si_actual" id="si_actual" onkeyup="updateRupiah('si_actual')">
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="" class="small">File</label>
                            <input class="form-control border" type="file" name="si_file" id="si_file">
                        </div>
                        <div class="mb-2">
                            <label for="" class="small">Link</label>
                            <input class="form-control border" type="text" name="si_link" id="si_link">
                        </div>
                        <div class="mb-2 text-end">
                            <button class="btn btn-primary" onclick="save_actual_si()">Simpan</button>

                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="tbl_det_si" width="100%">
                        <thead>
                            <tr>
                                <th>Periode</th>
                                <th>Created By</th>
                                <th>Status</th>
                                <th>Actual</th>
                                <th>Resume</th>
                                <th>File</th>
                                <th>Link</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Back</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="mdl_goal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header d-block bg-light-theme">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Daftar Goal</h6>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">

                    <table id="tbl_goal" class="table table-sm table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Company</th>                                   
                                <th>Department</th>                                   
                                <th>Periode</th>                                   
                                <th>Perspektive</th>
                                <th>Sub Perspektive</th>
                                <th>Goal</th>
                                <th>Target</th>
                                <th>Actual</th>
                                <th>Deviasi</th>
                                <th>Persentase</th>   
                                <th>Tipe</th>                                  
                                <th>Spend</th>                                  

                            </tr>
                        </thead>
                        <tbody></tbody>

                    </table>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_input_goal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-block bg-light-purple">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-purple rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Input Actual Goal</h6>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="" class="small">Goals</label>
                            <input type="hidden" name="goal_id" id="goal_id" class="form-control" readonly>
                            <input type="text" name="goal_category" id="goal_category" class="form-control" readonly>
                            <input type="hidden" name="goal_perspektive" id="goal_perspektive" class="form-control" readonly>

                            <input type="hidden" name="goal_sub" id="goal_sub" class="form-control" readonly>
                            <input type="hidden" name="goal_id_company" id="goal_id_company" class="form-control" readonly>


                            <input type="hidden" name="goal_target" id="goal_target" class="form-control" readonly>
                            <input type="hidden" name="goal_periode" id="goal_periode" class="form-control" readonly>

                            <p id="ketercapaian_text"></p>
                        </div>
                        <div class="mb-3">
                            
                        </div>
                        <div class="mb-3">
                            <label for="" class="small">Resume</label>
                            <textarea class="form-control border" type="text" name="goal_resume" id="goal_resume" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="small">Target</label>
                                    <input class="form-control border" type="text" id="goal_target_text" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="small">Actual</label>
                                    <input class="form-control border" type="text" name="goal_actual" id="goal_actual" onkeyup="updateRupiah('goal_actual')">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-2">
                            <label for="" class="small">File</label>
                            <input class="form-control border" type="file" name="goal_file" id="goal_file">
                        </div>
                        <div class="mb-2">
                            <label for="" class="small">Link</label>
                            <input class="form-control border" type="text" name="goal_link" id="goal_link">
                        </div>
                        <div class="mb-2 text-end">
                            <button class="btn btn-primary" onclick="save_actual_goal()">Simpan</button>

                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="tbl_det_goal" width="100%">
                        <thead>
                            <tr>
                                <th>Periode</th>
                                <th>Created By</th>
                                <th>Actual</th>
                                <th>Resume</th>
                                <th>File</th>
                                <th>Link</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal">Back</button>
            </div>
        </div>
    </div>
</div>