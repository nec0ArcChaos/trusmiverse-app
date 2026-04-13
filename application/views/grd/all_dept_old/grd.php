<main class="main mainheight">
    <div class="container-fluid">
        <div class="row justify-content-end page-title">
            <div class="col-lg-auto mb-2 col-sm-auto">
                <button class="btn btn-sm bg-blue_1" onclick="add_new_task_milestone()" style="border-radius: 5px; color: white;" onmouseover="this.style.color='black'" onmouseout="this.style.color='white'">
                    <i class="bi bi-plus"></i>
                    Tasklist Milestone
                </button>        
            </div>
            <div class="col-lg-auto mb-2 col-sm-auto">
                <button class="btn btn-sm bg-blue_2" onclick="add_new_task()" style="border-radius: 5px; color: white;" onmouseover="this.style.color='black'" onmouseout="this.style.color='white'">
                    <i class="bi bi-plus"></i>
                    Tasklist GRD
                </button>        
            </div>
            <div class="col-lg-auto mb-2 col-sm-auto">
                <button class="btn btn-sm bg-blue_3" onclick="add_new_so()" style="border-radius: 5px; color: white;" onmouseover="this.style.color='black'" onmouseout="this.style.color='white'">
                    <i class="bi bi-plus"></i>
                    SO GRD
                </button>        
            </div>
            <div class="col-lg-auto mb-2 col-sm-auto">
                <button class="btn btn-sm bg-blue_4" onclick="add_new_si()" style="border-radius: 5px; color: white;" onmouseover="this.style.color='black'" onmouseout="this.style.color='white'">
                    <i class="bi bi-plus"></i>
                    SI GRD
                </button>        
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <?php $this->load->view('grd/all/_content/content_1'); ?>
    </div>
    <div class="container-fluid">
        <?php $this->load->view('grd/all/_content/content_2'); ?>    
    </div>

    <footer class="footer m-0 p-0">
        <div class="container-fluid">
            <div class="row">

                <div class="col-6 py-2 align-self-center">
                   
                </div>
                <div class="col-6 py-2 text-right">
                    <span class="text-secondary float-end " style="font-size: 8pt">Copyright @2024, IT Trusmi Group</span>
                </div>
            </div>
        </div>
    </footer>
</main>


<!-- Modal Add Task -->
<div class="modal fade" id="modal_add_task" aria-labelledby="modal_add_task" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-blue_2">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light text-purple rounded"></i>
                </div>
                <div class="col">
                    <h5 class="fw-bold mb-0 text-white" id="modal-list-waiting-resignationLabel">Tambah Tasklist GRD</h5>
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
                        <label class="required">Company</label>
                        <select name="id_company" id="add_id_company" class="form-control form-control-lg border-custom">
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Divisi</label>
                        <select name="id_divisi" id="add_id_divisi" class="form-control form-control-lg border-custom">
                            <option value="" selected disabled>- Pilih Divisi -</option>                                
                            <?php foreach ($divisi as $d) : ?>
                            <option value="<?= $d->divisi ?>"><?= $d->divisi ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Goals</label>
                        <select name="id_goal" id="add_id_goal" class="form-control form-control-lg border-custom">
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">SO</label>
                        <select name="id_so" id="add_id_so" class="form-control form-control-lg border-custom">
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">SI</label>
                        <select name="id_si" id="add_id_si" class="form-control form-control-lg border-custom">
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">PIC</label>
                        <select name="id_pic" id="add_id_pic" class="form-control form-control-lg border-custom" multiple="">
                        </select>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12 mb-2" id="add_id_jenis_div">
                        <label class="required">Jenis Tasklist</label>
                        <select name="id_jenis" id="add_id_jenis" class="form-control form-control-lg border-custom">
                            <option value="" selected disabled>- Pilih Jenis Tasklist -</option>    
                            <option value="Daily">Daily</option>
                            <option value="Weekly">Weekly</option>
                            <option value="Monthly">Monthly</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2" style="display: none;" id="add_id_week_div">
                        <label class="required">Jumlah Minggu</label>
                        <select name="id_week" id="add_id_week" class="form-control form-control-lg border-custom">
                            <option value="" selected disabled>- Pilih Jumlah Minggu -</option>    
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Tanggal Mulai</label>
                        <input type="text" class="form-control datepicker border-custom" name="start" id="start" />
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Deadline</label>
                        <input type="text" class="form-control datepicker border-custom" name="end" id="end" />
                    </div>
                </div>
                <div class="row" id="add_id_detail_row">
                    <div class="mb-2 col-12 col-md-12"id="add_id_detail_div0">
                        <div class="card">
                            <div class="card-body">
                                <label class="form-label-custom required small mb-1" for="detail" id="label_detail">Detail Pekerjaan</label>
                                <div class="input-group border-custom mb-3">
                                    <span class="input-group-text bi bi-file-earmark-font"></span>
                                    <input type="text" class="form-control border-custom" name="detail[]" id="detail" placeholder="Detail Pekerjaan">
                                </div>

                                <label class="form-label-custom required small mb-1" for="output">Output</label>
                                <div class="input-group mb-3 border-custom">
                                    <span class="input-group-text bi bi-award"></span>
                                    <input type="text" class="form-control border-custom" name="output[]" id="output" placeholder="Output Pekerjaan">
                                </div>

                                <label class="form-label-custom small mb-1" for="target">Target</label>
                                <div class="input-group mb-3 border-custom">
                                    <span class="input-group-text bi bi-pin"></span>
                                    <input type="number" class="form-control border-custom" name="target[]" id="target" placeholder="Target Pencapaian Pekerjaan, contoh: 100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="mfoot_div">
                <button type="button" class="m-1 btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="m-1 btn bg-blue_2" onclick="save_task()" style="border-radius: 5px; color: white;" onmouseover="this.style.color='black'" onmouseout="this.style.color='white'">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Task Milestone -->
<div class="modal fade" id="modal_add_task_milestone" aria-labelledby="modal_add_task_milestone" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-blue_1">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light text-purple rounded"></i>
                </div>
                <div class="col">
                    <h5 class="fw-bold mb-0 text-white" id="modal-list-waiting-resignationLabel">Tambah Tasklist Milestone</h5>
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
                        <label class="required">Company</label>
                        <select name="id_company" id="mile_id_company" class="form-control form-control-lg border-custom">
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Divisi</label>
                        <select name="id_divisi" id="mile_id_divisi" class="form-control form-control-lg border-custom">
                            <option value="" selected disabled>- Pilih Divisi -</option> 
                            <?php foreach ($divisi as $d) : ?>
                            <option value="<?= $d->divisi ?>"><?= $d->divisi ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12 mb-2">
                        <label class="required">Milestone</label>
                        <select name="id_milestone" id="mile_id_milestone" class="form-control form-control-lg border-custom">
                        </select>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12 mb-2">
                        <label class="required">PIC</label>
                        <select name="id_pic" id="mile_id_pic" class="form-control form-control-lg border-custom" multiple="">
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Tanggal Mulai</label>
                        <input type="date" min="<?= date('Y-m-d') ?>" class="form-control border-custom" name="start" id="mile_start">
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Deadline</label>
                        <input type="date" min="<?= date('Y-m-d') ?>" class="form-control border-custom" name="end" id="mile_end">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-2 col-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <label class="form-label-custom required small mb-1" for="detail">Detail Pekerjaan</label>
                                <div class="input-group border-custom mb-3">
                                    <span class="input-group-text bi bi-file-earmark-font"></span>
                                    <input type="text" class="form-control border-custom" name="detail" id="mile_detail" placeholder="Detail Pekerjaan">
                                </div>

                                <label class="form-label-custom required small mb-1" for="output">Output</label>
                                <div class="input-group mb-3 border-custom">
                                    <span class="input-group-text bi bi-award"></span>
                                    <input type="text" class="form-control border-custom" name="output" id="mile_output" placeholder="Output Pekerjaan">
                                </div>

                                <label class="form-label-custom small mb-1" for="target">Target</label>
                                <div class="input-group mb-3 border-custom">
                                    <span class="input-group-text bi bi-pin"></span>
                                    <input type="number" class="form-control border-custom" name="target" id="mile_target" placeholder="Target Pencapaian Pekerjaan, contoh: 100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="m-1 btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="m-1 btn bg-blue_1" onclick="save_task_milestone()" style="border-radius: 5px; color: white;" onmouseover="this.style.color='black'" onmouseout="this.style.color='white'">Save</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Add SO -->
<div class="modal fade" id="modal_add_so" aria-labelledby="modal_add_so" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-blue_3">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light text-purple rounded"></i>
                </div>
                <div class="col">
                    <h5 class="fw-bold mb-0 text-white" id="modal-list-waiting-resignationLabel">Tambah SO GRD</h5>
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
                        <label class="required">Company</label>
                        <select name="so_id_company" id="so_id_company" class="form-control form-control-lg border-custom">
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Divisi</label>
                        <select name="so_id_divisi" id="so_id_divisi" class="form-control form-control-lg border-custom">
                            <option value="" selected disabled>- Pilih Divisi -</option>    
                            
                            <?php foreach ($divisi as $d) : ?>
                            <option value="<?= $d->divisi ?>"><?= $d->divisi ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Goals</label>
                        <select name="so_id_goal" id="so_id_goal" class="form-control form-control-lg border-custom">
                        </select>
                    </div>
                    <!-- <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">SO</label>
                        <select name="id_so" id="so_add_id_so" class="form-control form-control-lg border-custom">
                        </select>
                    </div> -->
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">PIC</label>
                        <select name="so_id_pic" id="so_id_pic" class="form-control form-control-lg border-custom" multiple="">
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Tanggal Mulai</label>
                        <input type="date" min="<?= date('Y-m-d') ?>" class="form-control border-custom" name="so_start" id="so_start">
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Deadline</label>
                        <input type="date" min="<?= date('Y-m-d') ?>" class="form-control border-custom" name="so_end" id="so_end">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-2 col-12 col-md-12">
                        <div class="card">
                            <div class="card-body">

                                <label class="form-label-custom small mb-1" for="so">SO</label>
                                <div class="input-group mb-3 border-custom">
                                    <span class="input-group-text bi bi-pin"></span>
                                    <input type="text" class="form-control border-custom" name="so_id_so" id="so_id_so" placeholder="Basket Size">
                                </div>

                                <label class="form-label-custom required small mb-1" for="detail">Tipe Target SO</label>
                                <div class="input-group border-custom mb-3">
                                    <span class="input-group-text bi bi-file-earmark-font"></span>
                                    <select name="so_target_so_type" id="so_target_so_type" class="form-control form-control-lg border-custom">
                                        <option value="" selected disabled>- Tipe Target SO -</option>    
                                        <option value="nominal">Nominal</option>
                                        <option value="rupiah">Rupiah</option>
                                        <option value="persentase">Persentase</option>
                                    </select>
                                </div>

                                <label class="form-label-custom small mb-1" for="target">Target</label>
                                <div class="input-group mb-3 border-custom">
                                    <span class="input-group-text bi bi-pin"></span>
                                    <input type="number" class="form-control border-custom" name="so_target" id="so_target" placeholder="Target Pencapaian Pekerjaan, contoh: 100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="m-1 btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="m-1 btn bg-blue_2" onclick="save_so()" style="border-radius: 5px; color: white;" onmouseover="this.style.color='black'" onmouseout="this.style.color='white'">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add SI -->
<div class="modal fade" id="modal_add_si" aria-labelledby="modal_add_si" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-blue_4">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light text-purple rounded"></i>
                </div>
                <div class="col">
                    <h5 class="fw-bold mb-0 text-white" id="modal-list-waiting-resignationLabel">Tambah SI GRD</h5>
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
                        <label class="required">Company</label>
                        <select name="si_id_company" id="si_id_company" class="form-control form-control-lg border-custom">
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Divisi</label>
                        <select name="si_id_divisi" id="si_id_divisi" class="form-control form-control-lg border-custom">
                            <option value="" selected disabled>- Pilih Divisi -</option>    
                            
                            <?php foreach ($divisi as $d) : ?>
                            <option value="<?= $d->divisi ?>"><?= $d->divisi ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Goals</label>
                        <select name="si_id_goal" id="si_id_goal" class="form-control form-control-lg border-custom">
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">SO</label>
                        <select name="si_id_so" id="si_id_so" class="form-control form-control-lg border-custom">
                        </select>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12 mb-2">
                        <label class="required">PIC</label>
                        <select name="si_id_pic" id="si_id_pic" class="form-control form-control-lg border-custom" multiple="">
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Tanggal Mulai</label>
                        <input type="date" min="<?= date('Y-m-d') ?>" class="form-control border-custom" name="si_start" id="si_start">
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label class="required">Deadline</label>
                        <input type="date" min="<?= date('Y-m-d') ?>" class="form-control border-custom" name="si_end" id="si_end">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-2 col-12 col-md-12">
                        <div class="card">
                            <div class="card-body">

                                <label class="form-label-custom small mb-1" for="s1">SI</label>
                                <div class="input-group mb-3 border-custom">
                                    <span class="input-group-text bi bi-pin"></span>
                                    <input type="text" class="form-control border-custom" name="si_id_si" id="si_id_si" placeholder="Basket Size">
                                </div>

                                <label class="form-label-custom required small mb-1" for="detail">Tipe Target SI</label>
                                <div class="input-group border-custom mb-3">
                                    <span class="input-group-text bi bi-file-earmark-font"></span>
                                    <select name="si_target_si_type" id="si_target_si_type" class="form-control form-control-lg border-custom">
                                        <option value="" selected disabled>- Tipe Target SI -</option>    
                                        <option value="nominal">Nominal</option>
                                        <option value="rupiah">Rupiah</option>
                                        <option value="persentase">Persentase</option>
                                    </select>
                                </div>

                                <label class="form-label-custom small mb-1" for="target">Target</label>
                                <div class="input-group mb-3 border-custom">
                                    <span class="input-group-text bi bi-pin"></span>
                                    <input type="number" class="form-control border-custom" name="si_target" id="si_target" placeholder="Target Pencapaian Pekerjaan, contoh: 100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="m-1 btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="m-1 btn bg-blue_2" onclick="save_si()" style="border-radius: 5px; color: white;" onmouseover="this.style.color='black'" onmouseout="this.style.color='white'">Save</button>
            </div>
        </div>
    </div>
</div>