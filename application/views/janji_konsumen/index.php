
<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-8 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <!-- <p class="text-secondary">Data Pelanggaran Terhapap Janji Konsumen</p> -->
            </div>
            <div class="col col-sm-auto">
                <div class="input-group input-group-md reportrange">
                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;"
                        id="titlecalendar">
                    <input type="hidden" name="start" value="" id="start" />
                    <input type="hidden" name="end" value="" id="end" />
                    <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i
                            class="bi bi-calendar-event"></i></span>
                </div>
            </div>
            <div class="col-auto ps-0">

            </div>
        </div>
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
                        </ol>
                    </div>

                </div>

            </nav>
        </div>
    </div>

    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto mb-2">
                            <i class="bi bi-journal-text h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center mb-2">
                            <h6 class="fw-medium">List Pelanggaran</h6>
                        </div>
                        <div class="col col-auto-right" align="right">

                            <!-- <button type="button" class="btn btn-md btn-secondary mb-2" onclick="list_approval(2)"><i
                                    class="bi bi-hourglass-split"></i> Waiting Sekdir</button> -->

                            <button type="button" class="btn btn-md btn-primary mb-2" onclick="modal_input()"><i
                                    class="bi bi-chat-square-text"></i> Input</button>

                            <!-- <div class="btn-group">
                                <button type="button" class="btn btn-md btn-primary dropdown-toggle mb-2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-bookmark-star"></i> Memo
                                </button>
                                <ul class="dropdown-menu" style="">
                                    <li><button class="dropdown-item" onclick="add_memo()">Add Memo</button></li>
                                    <li><button class="dropdown-item" onclick="list_draf()">Draf Memo</button></li>
                                </ul>
                            </div> -->

                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_janji_konsumen" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Week</th>
                                    <th>Jenis</th>
                                    <th>Komplain</th>
                                    <th>Detail Komplain</th>
                                    <th>Jumlah / Nilai</th>
                                    <th>Kompensasi</th>
                                    <th>Nominal</th>
                                    <th>Perusahaan</th>
                                    <th>Karyawan</th>
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


<div class="modal fade" id="modal_input" role="dialog">
    <div class="modal-dialog modal-lg center">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Input Form Janji Konsumen</h4>
                <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button"
                    aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <form id="form-input">
                <div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">

                    <div class="row">

                        <?php
                        // ambil tahun & bulan sekarang
                        $currentYear = date("Y");
                        $currentMonth = date("n"); // 1-12
                        $currentDay = date("j");

                        // hitung minggu ke berapa dalam bulan sekarang
                        $weekOfMonth = ceil($currentDay / 7);
                        ?>
                        <div class="col-12 col-md-4 mb-3">
                            <div class="form-group position-relative">
                                <div class="input-group input-group-lg mb-2">
                                    <span class="input-group-text text-theme bg-white border-end-0">
                                        <i class="bi bi-calendar3"></i>
                                    </span>
                                    <div class="form-floating">
                                        <select class="form-control border-start-0" name="tahun" required>
                                            <?php for ($y = 2025; $y <= 2030; $y++): ?>
                                                <option value="<?= $y ?>" <?= ($y == $currentYear) ? 'selected' : '' ?>>
                                                    <?= $y ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                        <label>Tahun <b class="text-danger small">*</b></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <div class="form-group position-relative">
                            <div class="input-group input-group-lg mb-2">
                                <span class="input-group-text text-theme bg-white border-end-0">
                                    <i class="bi bi-calendar-month"></i>
                                </span>
                                <div class="form-floating">
                                    <select class="form-control border-start-0" name="bulan" required>
                                        <?php
                                        $namaBulan = [
                                            1 => "Januari",
                                            2 => "Februari",
                                            3 => "Maret",
                                            4 => "April",
                                            5 => "Mei",
                                            6 => "Juni",
                                            7 => "Juli",
                                            8 => "Agustus",
                                            9 => "September",
                                            10 => "Oktober",
                                            11 => "November",
                                            12 => "Desember"
                                        ];
                                        foreach ($namaBulan as $num => $bln): ?>
                                            <option value="<?= $num ?>" <?= ($num == $currentMonth) ? 'selected' : '' ?>>
                                                <?= $bln ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Bulan <b class="text-danger small">*</b></label>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <div class="form-group position-relative">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text text-theme bg-white border-end-0">
                                    <i class="bi bi-calendar-week"></i>
                                </span>
                                <div class="form-floating">
                                    <select class="form-control border-start-0" name="week">
                                        <?php for ($w = 1; $w <= 5; $w++): ?>
                                            <option value="<?= $w ?>" <?= ($w == $weekOfMonth) ? 'selected' : '' ?>>
                                                Minggu <?= $w ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                    <label>Minggu <b class="text-danger small">*</b></label>
                                </div>
                            </div>
                            </div>
                        </div>

                        <!-- JENIS -->

                        <div class="col-12 col-md-6 mb-3">
                            <div class="form-group position-relative">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0">
                                        <i class="bi bi-list-check"></i>
                                    </span>
                                    <div class="form-floating">
                                        <select class="form-control border-start-0" id="jenis" name="jenis" required>
                                            <option value="" selected disabled>Pilih Jenis</option>
                                            <option value="Pelayanan">Pelayanan</option>
                                            <option value="Web Complain">Web Complain</option>
                                            <option value="After Sales">After Sales</option>
                                        </select>
                                        <label>Jenis <b class="text-danger small">*</b></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- KOMPLAIN -->
                        <div class="col-12 col-md-12 mb-3">
                            <div class="form-group position-relative">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0">
                                        <i class="bi bi-exclamation-octagon"></i>
                                    </span>
                                    <div class="form-floating">
                                        <select class="form-control border-start-0" id="komplain" name="komplain"
                                            disabled required>
                                        </select>
                                        <label>Komplain <b class="text-danger small">*</b></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="form-group position-relative">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text text-theme bg-white border-end-0">
                                        <i class="bi bi-123"></i>
                                    </span>
                                    <div class="form-floating">
                                        <input type="number" class="form-control border-start-0" name="value" required>
                                        <label>Jumlah Komplain / Nilai <b class="text-danger small">*</b></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        





                    </div>
                    <!-- == FORM SELESAI == -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary" style="margin-right:10px;"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-save"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>