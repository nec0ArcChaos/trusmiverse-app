<!-- <style>
    /* .input-field {
    width: 100%;
    padding: 8px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.input-field:focus {
    outline: none;
    border-color: #66afe9;
    box-shadow: 0 0 5px #66afe9;
} */

</style> -->

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
                    <form id="form_add_goals">
                        <div class="row mb-2">
                            <div class="col-12 col-md-12 col-lg-12 mb-2">
                            </div>
                            <div class="col col-md mb-2 mb-sm-0">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <?php $accessable = array(1,1161,118,2729,117,179); ?>
                                            <?php if (in_array($this->session->userdata('user_id'), $accessable)) { ?>
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-building"></i></span>
                                                <div class="form-floating">
                                                    <select name="company" id="company" class="form-control border-start-0">
                                                        <option value="0" selected>All Companies</option>
                                                        <?php foreach ($get_company as $cmp) : ?>
                                                            <option value="<?php echo $cmp->company_id ?>"><?php echo $cmp->company ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                    <label>Company</label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-md mb-2 mb-sm-0">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <?php if (in_array($this->session->userdata('user_id'), $accessable)) { ?>
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-rolodex"></i></span>
                                                <div class="form-floating">
                                                    <select name="department" id="department" class="form-control border-start-0">
                                                        <option value="0" selected>All Departments</option>
                                                    </select>
                                                    <label>Department</label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col col-md mb-2 mb-sm-0">                               
                                </div> -->
                                <div class="col-lg-2 col-md mb-2 mb-sm-0">
                                    <div class="form-group mb-3 position-relative check-valid">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar3"></i></span>
                                            <div class="form-floating bg-white">
                                                <input type="text" class="form-control" name="periode" id="periode" value="<?php echo date('Y-m') ?>"/>

                                                <label>Goals & Target :</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-1 col-md mb-2 mb-sm-0">
                                    <!-- <span class="btn btn-primary" id="btn_filter" style="width: 100%;" data-toggle="tooltip" data-placement="top" title="Tooltip on top" onclick="filter_company_department()">
                                        Filter <i class="bi bi-search"></i>
                                    </span> -->
                                </div>
                            <div class="col text-end">
                            </div>
                        </div>
                        <br><label for=""><h5>Goals</h5></label><br>

                        <div id="data_place">
                        </div>
                        
                        <div class="table-responsive" style="padding: 10px;">

                            <table id="tbl_goal_m" class="table table-sm table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Perspektive</th>
                                        <th>Sub<br>Perspektive</th>
                                        <th>Goal</th>
                                        <th>Target</th>  
                                        <th>Bobot</th>                                                            
                                        <th>Tipe</th>                                  
                                        <th>Spend</th>    
                                        <th>Project</th>                                  
                                        <th>PM</th>                                  
                              
                                    </tr>
                                </thead>
                                <tbody></tbody>

                            </table>
                        </div>
					</form>

                    <div class="row mb-2">
                        <div class="col-12 col-md-12 col-lg-12 mb-2">
                        </div>
                        <div class="col col-md mb-2 mb-sm-0">
                        <div class="col text-end">
                            <button type="button" class="btn btn-disabled is-invalid" id="btn_save_goals" onclick="save_goals()"
                            disabled="disabled">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
