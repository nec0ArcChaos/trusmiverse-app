<main class="main mainheight">
    <div class="container-fluid">
        <div class="row align-items-center page-title">
            <div class="col-8 col-md">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
            </div>
        </div>
        <div class="row breadcrumb-theme align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Leave</li>
            </ol>
        </div>
    </div>

    <div class="m-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col">
                                <h6 class="title">Applied Ganti Hari Libur</h6>
                            </div>
                            <div class="col-auto align-items-center align-self-center">
                                <button class="btn btn-outline-primary text-dinamis" type="button" data-bs-toggle="modal" data-bs-target="#modal_add_leave"> Add Ganti Hari Libur</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-12 col-md-4 mb-1 mt-1 custom-style-sm">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar"></i></span>
                                    <div class="form-floating">
                                        <select name="month" id="month" class="form-select border-0">
                                            <option value="01" <?= date("m") == '01' ? 'selected' : ''; ?>>Januari</option>
                                            <option value="02" <?= date("m") == '02' ? 'selected' : ''; ?>>Februari</option>
                                            <option value="03" <?= date("m") == '03' ? 'selected' : ''; ?>>Maret</option>
                                            <option value="04" <?= date("m") == '04' ? 'selected' : ''; ?>>April</option>
                                            <option value="05" <?= date("m") == '05' ? 'selected' : ''; ?>>Mei</option>
                                            <option value="06" <?= date("m") == '06' ? 'selected' : ''; ?>>Juni</option>
                                            <option value="07" <?= date("m") == '07' ? 'selected' : ''; ?>>Juli</option>
                                            <option value="08" <?= date("m") == '08' ? 'selected' : ''; ?>>Agustus</option>
                                            <option value="09" <?= date("m") == '09' ? 'selected' : ''; ?>>September</option>
                                            <option value="10" <?= date("m") == '10' ? 'selected' : ''; ?>>Oktober</option>
                                            <option value="11" <?= date("m") == '11' ? 'selected' : ''; ?>>November</option>
                                            <option value="12" <?= date("m") == '12' ? 'selected' : ''; ?>>Desember</option>
                                        </select>
                                        <label>Bulan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-1 mt-1 custom-style-sm">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar"></i></span>
                                    <div class="form-floating">
                                        <select name="year" id="year" class="form-select border-0">
                                            <?php for ($i = date("Y") + 1; $i >= 2018; $i--) { ?>
                                                <option value="<?= $i ?>" <?= date("Y") ? (date("Y") == $i ? 'selected' : '') : '' ?>><?= $i ?></option>
                                            <?php } ?>
                                        </select>
                                        <label>Tahun</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 align-self-center">
                                <button class="button-4" onclick="filter_periode()" style="font-size: 8pt;">Search</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table id="dt_list_tabungan_jam" class="table table-striped text-nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Leave Type</th>
                                            <th>Periode</th>
                                            <th>Company</th>
                                            <th>Department</th>
                                            <th>Tabungan Jam</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row breadcrumb-theme mb-2 d-block d-md-none">
            <br>
        </div>
    </div>



    <!-- Footer -->
    <div class="container-fluid footer-page mt-4 py-5">

    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="modal_add_leave" tabindex="-1" aria-labelledby="modal_add_leaveLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card">
            <div class="modal-header card-header">
                <div class="col-12">
                    <div class="row">
                        <div class="col">
                            <h6 class="modal-title title">Add Leave</h6>
                        </div>
                        <div class="col-auto d-flex align-items-center align-self-center">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body card-body">
                <form id="from_add_leave" class="formName" enctype="multipart/form-data">
                    <div class="row align-items-center m-1">
                        <div class="mb-3 col-12">
                            <label for="leave_type" class="form-label-custom required">Leave Type</label>
                            <input type="text" class="form-control border-custom" name="leave_type_name" id="leave_type_name" value="Pergantian Hari Libur Driver" readonly>
                            <input type="hidden" class="form-control border-custom" name="leave_type" id="leave_type" value="24">
                        </div>
                        <div class="mb-3 col-6 col-md-6 col-lg-6" id="div_tgl_ph">
                            <label for="tgl_ph" class="form-label-custom required">Pilih Tgl Libur</label>
                            <input type="text" class="form-control border-custom tgl tanggal" name="tgl_ph" id="tgl_ph" aria-describedby="tgl_ph" placeholder="yyyy-mm-dd" autocomplete="off">
                            <span class="small" style="font-size: 7pt;">*yang seharusnya anda libur tapi masuk</span>
                        </div>
                        <div class="mb-3 col-6 col-md-6 col-lg-6">
                            <label for="start_date" class="form-label-custom required">Tgl Pengganti Libur</label>
                            <input type="text" class="form-control border-custom tgl tanggal" name="start_date" id="start_date" aria-describedby="start_date" placeholder="yyyy-mm-dd" autocomplete="off">
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label for="attachment" class="form-label-custom required">Attachment</label>
                            <input type="file" class="form-control border-custom" name="attachment" id="attachment" aria-describedby="attachment" placeholder="">
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label for="leave_reason" class="form-label-custom required">Reason</label>
                            <textarea name="leave_reason" class="form-control border-custom" id="leave_reason" cols="30" rows="5"></textarea>
                        </div>
                        <div class="mb-3 col-12 text-end">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer card-footer">
                <button type="button" class="btn btn-outline-theme m-1" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-theme m-1" onclick="add_leave()" id="add_leave" disabled>Submit Request</button>
            </div>
        </div>
    </div>
</div>

<!-- modal detail -->
<div class="modal fade" id="modal_detail" tabindex="-1" aria-labelledby="modal_detail" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card">
            <div class="modal-header card-header">
                <div class="col-12">
                    <div class="row">
                        <div class="col">
                            <h6 class="modal-title title">Detail Leave</h6>
                        </div>
                        <div class="col-auto d-flex align-items-center align-self-center">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body card-body">
                <div class="table-responsive">
                    <table id="dt_detail_leave" class="table table-striped text-nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kota</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Reason</th>
                                <th>Total Jam</th>
                                <th>Tabungan Jam</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer card-footer">
                <button type="button" class="btn btn-outline-theme m-1" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal detail -->