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
                            <button type="button" class="btn btn-success"><a href="<?= base_url() ?>bsc_so/add_list_goals" style="color: white; text-decoration: none;"><i class="bi bi-upload"></i> Add List Goals</a></button>
                        </div>
                    </div>
                    <br><label for=""><h5>Goals</h5></label><br>

                    <div class="table-responsive" style="padding: 10px;">

                        <table id="tbl_goals_master" class="table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Company</th>                                   
                                    <th>Department</th>                                   
                                    <th>Periode</th>                                   
                                    <th>Perspektive</th>
                                    <th>Sub<br>Perspektive</th>
                                    <th>Goal</th>
                                    <th>Target</th>
                                    <th>Tipe</th>                                  
                                    <th>Spend</th> 
                                    <th>Project</th>                                  
                                    <th>PM</th>
                                    <th>Created at</th>                                  
                                    <th>Created by</th>                                  

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
                        <table id="tbl_so_master" class="table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Company</th>    
                                    <th>Department</th>    
                                    <th>Periode</th>    
                                    <th>Perspective</th>      
                                    <th>Goal</th>                                                        
                                    <th>Strategy</th>                                  
                                    <th>Target</th>
                                   
                                    <th>Tipe</th>                                  
                                    <th>Spend</th>
                                    <th>Created at</th>
                                    <th>Created by</th>

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
                        <table id="tbl_si_master" class="table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Company</th>
                                    <th>Department</th>    
                                    <th>Periode</th>    
                                    <th>Perspective</th>      
                                    <th>Goal</th>                                                        
                                    <th>Strategy</th>                                  
                                    <th>Target</th>
                                   
                                    <th>Tipe</th>                                  
                                    <th>Spend</th>
                                    <th>Created at</th>
                                    <th>Created by</th>

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

<!--  ================ SSSSSSSSSSSSIIIIIIIIIII -->
<div class="modal fade" id="mdl_input_so_master" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-block bg-light-purple">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-purple rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Input Master Target SO</h6>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form id="form_a_so">
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="" class="small">Company</label>
                                <input type="text" name="a_so_company" id="a_so_company" class="form-control" readonly>
                                <input type="hidden" name="a_so_company_id" id="a_so_company_id" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="" class="small">Periode</label>
                                <input type="text" name="a_so_periode" id="a_so_periode" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="" class="small">Goals</label>
                                <input class="form-control border" name="a_so_category_view" id="a_so_category_view" type="text" readonly>
                                <input class="form-control border" name="a_so_category" id="a_so_category" type="hidden" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="" class="small">Strategy Objektif</label>
                                <textarea class="form-control border" type="text" name="a_so_so" id="a_so_so" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="" class="small">Department</label>
                                    <input type="text" name="a_so_department" id="a_so_department" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="small">Perspektive</label>
                                    <input type="text" name="a_so_perspektif" id="a_so_perspektif" class="form-control" readonly>
                                </div>                           
                                <div class="mb-3">
                                    <label for="" class="small">Target</label>
                                    <input class="form-control border" type="text" name="a_so_target" id="a_so_target" onkeyup="updateRupiah('a_so_target')">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="small">Spend</label>
                                    <select name="a_so_spend" id="a_so_spend" class="form-control border-start-0">
                                        <option value="0">-Belum Dipilih-</option>
                                        <option value="over">over (lebih besar lebih baik)</option>
                                        <option value="under">under (lebih kecil lebih baik)</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="small">Tipe</label>
                                    <select name="a_so_tipe" id="a_so_tipe" class="form-control border-start-0">
                                        <option value="0">-Belum Dipilih-</option>
                                        <option value="qty">Qty</option>
                                        <option value="nominal">Nominal</option>
                                        <option value="persen">Persen</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>          
                </form>      
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal" style="margin-right:10px;">Back</button> 
                <button type="button" class="btn btn-success" style="margin-right:10px;color:white" onclick="btn_save_target_so()">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdl_input_si_master" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-block bg-light-purple">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-arrow-up-right h5 avatar avatar-40 bg-light-purple rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Input Master Target SI</h6>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form id="form_a_si">
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="" class="small">Company</label>
                                <input type="text" name="a_si_company" id="a_si_company" class="form-control" readonly>
                                <input type="hidden" name="a_si_company_id" id="a_si_company_id" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="" class="small">Periode</label>
                                <input type="text" name="a_si_periode" id="a_si_periode" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="" class="small">Goals</label>
                                <input class="form-control border" name="a_si_category_view" id="a_si_category_view" type="text" readonly>
                                <input class="form-control border" name="a_si_category" id="a_si_category" type="hidden" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="" class="small">Strategy Inisiatif</label>
                                <textarea class="form-control border" type="text" name="a_si_si" id="a_si_si" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="" class="small">Department</label>
                                    <input type="text" name="a_si_department" id="a_si_department" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="small">Perspektive</label>
                                    <input type="text" name="a_si_perspektif" id="a_si_perspektif" class="form-control" readonly>
                                </div> 
                                <div class="mb-3">
                                    <label for="" class="small">SO</label>
                                    <input type="text" name="a_si_so" id="a_si_so" class="form-control" readonly>
                                    <input type="text" name="a_si_id_so" id="a_si_id_so" class="form-control" readonly>

                                </div>                          
                                <div class="mb-3">
                                    <label for="" class="small">Target</label>
                                    <input class="form-control border" type="text" name="a_si_target" id="a_si_target" onkeyup="updateRupiah('a_si_target')">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="small">Spend</label>
                                    <select name="a_si_spend" id="a_si_spend" class="form-control border-start-0">
                                        <option value="0">-Belum Dipilih-</option>
                                        <option value="over">over (lebih besar lebih baik)</option>
                                        <option value="under">under (lebih kecil lebih baik)</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="small">Tipe</label>
                                    <select name="a_si_tipe" id="a_si_tipe" class="form-control border-start-0">
                                        <option value="0">-Belum Dipilih-</option>
                                        <option value="qty">Qty</option>
                                        <option value="nominal">Nominal</option>
                                        <option value="persen">Persen</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>          
                </form>      
            </div>
            <div class="modal-footer text-end">
                <button type="button" class="btn btn-theme" data-bs-dismiss="modal" style="margin-right:10px;">Back</button> 
                <button type="button" class="btn btn-success" style="margin-right:10px;color:white" onclick="btn_save_target_si()">Save</button>
            </div>
        </div>
    </div>
</div>