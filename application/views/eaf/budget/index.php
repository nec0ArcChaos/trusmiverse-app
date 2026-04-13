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
                                        <i class="bi bi-wallet h5 avatar avatar-40 bg-light-theme rounded"></i>
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <h6 class="fw-medium mb-0"><?= $pageTitle; ?></h6>
                                    </div>
                                </div>

                            </div>


                            <div class="col-sm-12 col-md-12 col-lg-3 float-lg-end">
                                <!-- <button type="button" class="btn btn-md btn-primary mt-2" onclick="add_pembelajar()" style="width:100%">
                                    <i class="bi bi-plus"></i> Add New
                                </button> -->
                                <a href="javascript:void(0)" class="btn btn-info btn-square" id="list_budget" style="width: 100%">Add Budget</a>
                            </div>

                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col col-sm-auto">
                            <form method="POST" id="form_filter">
                                <!-- <div class="input-group input-group-md reportrange">
                                    <input type="text" class="form-control bg-none px-0" style="cursor: pointer;" id="periode" value="<?= date('Y') ?>-<?= date('m') ?>">
                                    <a href="javascript:void(0)" class="input-group-text text-secondary bg-none" id="titlecalandershow" onclick="filter_data()"><i class="bi bi-search"></i></a>
                                </div> -->
                                <div class="input-group input-group-md border rounded reportrange">
                                    <span class="input-group-text text-secondary bg-none"><i class="bi bi-calendar-event"></i></span>
                                    <input type="text" class="form-control" name="periode" id="periode" value="<?php echo date('Y-m') ?>" />
                                    <a href="javascript:void(0);" class="btn btn-primary" onclick="filter_report()"><i class="ti-search"></i>Filter</a>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_budget" class="table table-striped table-bordered dt-responsive display">
                            <thead>
                                <tr>
                                    <th>Company</th>
                                    <th>Nama Biaya</th>
                                    <th>User</th>
                                    <!-- <th>Max Approve 1</th> -->
                                    <th>Sisa Budget</th>
                                    <th>Minggu</th>
                                    <th>Bulan</th>
                                    <th>Tahun Budget</th>
                                    <th>Note</th>
                                    <th>Created at</th>
                                    <th>Id Budget</th>
                                    <th>Company ID</th>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<div class="modal fade" id="modal_add_penambahan" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg center" role="document" style="max-width: 95%;position:relative;top:0;bottom:0;left:0;right:0;margin:auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">List Penambahan <p id="text_nama_biaya"></p>
                </h4>


                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>


            </div>

            <div class="modal-body" style="max-height: calc(100vh - 230px);overflow-y: auto;">
                <input type="hidden" name="id_biaya_tam" class="form-control" id="id_biaya_tam" readonly>
                <input type="hidden" name="id_minggu_tam" class="form-control" id="minggu_tam" readonly>
                <input type="hidden" name="id_bulan_tam" class="form-control" id="bulan_tam" readonly>
                <input type="hidden" name="tahun_tam" class="form-control" id="tahun_tam" readonly>
                <input type="hidden" name="nama_biaya_tam" id="nama_biaya_tam"><br>
                <input type="hidden" name="no_hp_user" id="no_hp_user"><br>
                <a href="javascript:void(0)" class="btn btn-info" id="list_tambah">Add Budget Penambahan</a><br><br>
                <div class="table-responsive dt-responsive">
                    <table id="dt_list_penambahan" class="table table-striped nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>Nominal Tambah</th>
                                <th>Bulan</th>
                                <th>Tahun</th>
                                <th>Update at</th>
                                <th>Update by</th>
                                <th>Note</th>
                                <th>Attachment BA</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_add_budget" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <!-- <h6 class="fw-medium mb-0" id="modal_add_pembelajar_label">Form</h6>
                    <p class="text-secondary small">Sharing Leader </p> -->
                    <h5 class="modal-title">Add Budget</h5>

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
                <form id="form_budget">
                    <div class="row">
                        <div class="col-12 col-lg-12 col-xl-12 mb-4">
                            <label class="form-label-custom required small" for="sel1">Company:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text bi bi-people-fill" style="background-color: #F5F5F5;border: 1px solid #ddd;"></span>
                                <select class="form-control selectpicker" id="company_id" name="company_id" data-live-search="true" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                    <option value="default">-- Pilih Company --</option>
                                    <?php foreach ($company as $row) : ?>
                                        <option value="<?php echo $row->company_id ?>"><?php echo $row->name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <label class="form-label-custom required small" for="sel1">Nama Biaya:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text bi bi-file-earmark-font" style="background-color: #F5F5F5;border: 1px solid #ddd;"></span>
                                <select class="form-control selectpicker" data-live-search="true" id="nama_biaya" name="nama_biaya" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                    <option value="default">-- Pilih Biaya --</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="form-group">

                                <label class="form-label-custom" for="bulan">Bulan:</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bi bi-calendar3" style="background-color: #F5F5F5;border: 1px solid #ddd;"></span>
                                    <select class="form-control" id="bulan_biaya" name="bulan_biaya" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                        <option value="default_biaya">-- Pilih Bulan --</option>
                                        <option value="01" <?= (date('m') == '01') ? "selected" : ""; ?>>Januari</option>
                                        <option value="02" <?= (date('m') == '02') ? "selected" : ""; ?>>Februari</option>
                                        <option value="03" <?= (date('m') == '03') ? "selected" : ""; ?>>Maret</option>
                                        <option value="04" <?= (date('m') == '04') ? "selected" : ""; ?>>April</option>
                                        <option value="05" <?= (date('m') == '05') ? "selected" : ""; ?>>Mei</option>
                                        <option value="06" <?= (date('m') == '06') ? "selected" : ""; ?>>Juni</option>
                                        <option value="07" <?= (date('m') == '07') ? "selected" : ""; ?>>Juli</option>
                                        <option value="08" <?= (date('m') == '08') ? "selected" : ""; ?>>Agustus</option>
                                        <option value="09" <?= (date('m') == '09') ? "selected" : ""; ?>>September</option>
                                        <option value="10" <?= (date('m') == '10') ? "selected" : ""; ?>>Oktober</option>
                                        <option value="11" <?= (date('m') == '11') ? "selected" : ""; ?>>November</option>
                                        <option value="12" <?= (date('m') == '12') ? "selected" : ""; ?>>Desember</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="tahun_budget" value="<?php echo date('Y') ?>" id="tahun_budget">
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label-custom" for="minggu">Minggu:</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bi bi-calendar2-week-fill" style="background-color: #F5F5F5;border: 1px solid #ddd;"></span>
                                    <select class="form-control" id="minggu_biaya" name="minggu_biaya" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                        <option value="">-- Pilih Minggu --</option>
                                        <option value="1">Minggu ke 1</option>
                                        <option value="2">Minggu ke 2</option>
                                        <option value="3">Minggu ke 3</option>
                                        <option value="4">Minggu ke 4</option>
                                        <option value="5">Minggu ke 5</option>
                                        <option value="6">Minggu ke 6</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-12 col-xl-12 mb-4">
                            <label class="form-label-custom" for="nominal_budget1">Nominal Budget :</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text bi bi-cash" style="background-color: #F5F5F5;border: 1px solid #ddd;"></span>
                                <input type="text" class="form-control" name="nominal_budget1" id="nominal_budget1" placeholder="1000" onkeyup="updateRupiah('nominal_budget1')" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                            </div>
                            <!-- <label class="form-label-custom" for="nominal_budget2">Maksimal Approve 1 :</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text bi bi-cash" style="background-color: #F5F5F5;border: 1px solid #ddd;"></span>
                                <input type="text" class="form-control" name="nominal_budget2" id="nominal_budget2" placeholder="1000" onkeyup="updateRupiah('nominal_budget2')" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                            </div> -->
                            <label class="form-label-custom" for="klasifikasi">Note :</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text bi bi-stickies" style="background-color: #F5F5F5;border: 1px solid #ddd;"></span>
                                <!-- <input type="text" class="form-control" name="note_budget" id="note_budget" placeholder="1000" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;"> -->
                                <textarea name="note_budget" id="note_budget" class="form-control" style="border:1px solid #ced4da; height: 100px;" placeholder="Input Keterangan"></textarea>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="progress" style="width: 100%" id="hide">
                    <div class="progress-bar" id="bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                        <span id="status"></span>
                    </div>
                </div>
                <button class="btn" data-bs-dismiss="modal" id="close_budget">Close</button>
                <button class="btn btn-primary" id="save_budget">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_penambahan" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <!-- <h6 class="fw-medium mb-0" id="modal_add_pembelajar_label">Form</h6>
                    <p class="text-secondary small">Sharing Leader </p> -->
                    <h5 class="modal-title">Penambahan Budget <p id="text_nama_biaya2">
                    </h5>

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
                <form id="form_penambahan">
                    <input type="hidden" name="id_biaya_tambah" id="id_biaya_tambah">
                    <input type="hidden" name="minggu_tambah" id="minggu_tambah">
                    <input type="hidden" name="bulan_tambah" id="bulan_tambah">
                    <input type="hidden" name="tahun_tambah" id="tahun_tambah">
                    <input type="hidden" name="no_hp_tambah" id="no_hp_tambah">
                    <div class="form-group">
                        <label for="sel1">Nama Biaya :</label>
                        <input type="text" class="form-control" id="nama_biaya_tambah" name="nama_biaya_tambah" readonly>
                    </div>
                    <div class="form-group">
                        <label for="sel1">Sisa Budget :</label>
                        <input type="text" class="form-control" id="sisa_budget" name="sisa_budget" readonly>
                    </div>
                    <div class="form-group">
                        <label for="sel1">Nominal Tambah :</label>
                        <input type="text" class="form-control" id="nominal_tambah" name="nominal_tambah">
                    </div>
                    <div class="form-group">
                        <label for="sel1">Berita Acara :</label>
                        <input type="file" class="form-control" id="berita_acara" name="file_ba" onchange="compress('#berita_acara', '#string', '.fa_wait', '.fa_done')" accept="image/*" capture="camera">
                        <input type="hidden" class="form-control" name="berita_acara" id="string">
                        <div class="fa_wait" style="display: none;"><i class="fa fa-spinner fa-pulse"></i> <label>Compressing File ...</label></div>
                        <div class="fa_done" style="display: none;"><i class="fa fa-check-circle" style="color: #689f38;"></i> <label>Compressing Complete.</label></div>
                    </div>
                    <div class="form-group">
                        <label for="sel1">Note :</label>
                        <input type="text" class="form-control" id="note_penambahan" name="note_penambahan">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="btn_penambahan">Save</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function compress(file_upload, string, submit, wait, done) {

        $(wait).show();
        $(done).hide();
        $(submit).prop('disabled', true);

        const file = document.querySelector(file_upload).files[0];

        extension = file.name.substr((file.name.lastIndexOf('.') + 1));

        if (!file) return;

        const reader = new FileReader();

        reader.readAsDataURL(file);

        reader.onload = function(event) {
            const imgElement = document.createElement("img");
            imgElement.src = event.target.result;

            if (extension == "jpg" || extension == "jpeg" || extension == "png" || extension == "gif") {

                extension = 'png,';

                imgElement.onload = function(e) {
                    const canvas = document.createElement("canvas");

                    if (e.target.width > e.target.height) {
                        const MAX_WIDTH = 400;
                        const scaleSize = MAX_WIDTH / e.target.width;
                        canvas.width = MAX_WIDTH;
                        canvas.height = e.target.height * scaleSize;
                    } else {
                        const MAX_HEIGHT = 400;
                        const scaleSize = MAX_HEIGHT / e.target.height;
                        canvas.height = MAX_HEIGHT;
                        canvas.width = e.target.width * scaleSize;
                    }

                    const ctx = canvas.getContext("2d");

                    ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);

                    const srcEncoded = ctx.canvas.toDataURL(e.target, "image/jpeg");

                    var g_string = extension + srcEncoded.substr(srcEncoded.indexOf(',') + 1);
                    document.querySelector(string).value = g_string;
                }
            } else {
                var g_string = extension + ',' + event.target.result.substr(event.target.result.indexOf(',') + 1);
                document.querySelector(string).value = g_string;
            }

        }
    }
</script>