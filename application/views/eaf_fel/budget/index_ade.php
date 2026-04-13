<link rel="stylesheet" href="<?php echo base_url(); ?>assets/datepicker/css/bootstrap-datepicker.css" />

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block">

                    <div class="row">
                        <div class="col-sm-9">
                            <h4 class="sub-title" style="font-size: 12pt;"><strong>Budgeting</strong></h4>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="col-sm-12 input-group date" id="datetimepicker9">
                                    <input type="text" class="form-control" value="<?= date('Y') ?>-<?= date('m') ?>" name="periode" id="periode">
                                    <input type="hidden" name="period" id="period" value="<?= date('Y') ?>-<?= date('m') ?>" />
                                    <button type="button" id="filter_period" class="btn btn-primary btn-outline-primary input-group-addon ">
                                        <span class="ti-search"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <a href="javascript:void(0)" class="btn btn-info btn-square" id="list_budget" style="width: 100%">Add Budget</a>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-12 col-sm-12">
                            <div class="table-responsive dt-responsive">
                                <table id="dt_budget" class="table table-striped table-bordered dt-responsive display">
                                    <thead>
                                        <tr>
                                            <th>Nama Biaya</th>
                                            <th>User</th>
                                            <th>Sisa Budget</th>
                                            <th>Minggu</th>
                                            <th>Bulan</th>
                                            <th>Tahun Budget</th>
                                            <th>Note</th>
                                            <th>Created at</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modal_add_budget" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Budget</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="form_budget">
                                        <div class="form-group">
                                            <label for="sel1">Nama Biaya:</label>
                                            <select class="form-control" id="nama_biaya" name="nama_biaya">
                                                <option value="default">-- Pilih Biaya --</option>
                                                <?php foreach ($budget as $row) : ?>
                                                    <option value="<?php echo $row->id_budget . '|' . $row->budget ?>"><?php echo $row->budget ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label for="sel1">Bulan:</label>
                                                    <select class="form-control" id="bulan_biaya" name="bulan_biaya">
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
                                                <input type="hidden" name="tahun_budget" value="<?php echo date('Y') ?>" id="tahun_budget">
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="sel1">Minggu:</label>
                                                    <select class="form-control" id="minggu_biaya" name="minggu_biaya">
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
                                        <div class="form-group">
                                            <label for="sel1">Nominal Budget :</label>
                                            <input type="text" class="form-control numbers" id="nominal_budget" name="nominal_budget">
                                        </div>
                                        <div class="form-group">
                                            <label for="sel1">Note :</label>
                                            <input type="text" class="form-control" id="note_budget" name="note_budget">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <div class="progress" style="width: 100%" id="hide">
                                        <div class="progress-bar" id="bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                            <span id="status"></span>
                                        </div>
                                    </div>
                                    <button class="btn" data-dismiss="modal" id="close_budget">Close</button>
                                    <button class="btn btn-primary" id="save_budget">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Member -->
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
                <!-- add by Ade -->
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
                <button class="btn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Add Member -->

<div class="modal fade" id="modal_penambahan" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg center" role="document" style="max-width: 75%;position:relative;top:0;bottom:0;left:0;right:0;margin:auto;">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#448aff">
                <h4 class="modal-title" style="color:white">Penambahan Budget <p id="text_nama_biaya2"></p>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <div class="modal-body" style="max-height: calc(100vh - 230px);overflow-y: auto;"> -->
            <div class="modal-body">

                <form id="form_penambahan">
                    <input type="hidden" name="id_biaya_tambah" id="id_biaya_tambah">
                    <input type="hidden" name="minggu_tambah" id="minggu_tambah">
                    <input type="hidden" name="bulan_tambah" id="bulan_tambah">
                    <input type="hidden" name="tahun_tambah" id="tahun_tambah">
                    <!-- add by Ade -->
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
                <button class="btn btn-primary" id="btn_penambahan">Savex</button>
            </div>
        </div>
    </div>
</div>
<!-- End Edit Member -->

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