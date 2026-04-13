<!DOCTYPE html>
<html>

<head>
    <title><?= $jp['jabatan'] ?> JP</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url() ?>assets/images/favicon.png" />
    <!-- <link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet"> -->
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url() ?>assets/images/favicon.png" />
    <link href="<?php echo base_url() ?>assets/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/vendor/select2/css/select2.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <!-- Datatable -->
    <link href="<?php echo base_url() ?>assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/icon/icofont/css/icofont.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/bower_components/pnotify/css/pnotify.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/bower_components/pnotify/css/pnotify.brighttheme.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/bower_components/pnotify/css/pnotify.buttons.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/pages/pnotify/notify.css">

    <link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet">
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" /> -->
    <!-- Daterange picker -->
    <link href="<?php echo base_url() ?>assets/vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="<?php echo base_url() ?>assets/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <style>
    .header_row {
        background-color: #000;
        color: #f4f401;
        font-weight: 600;
    }

    li {
        list-style: inherit;
    }

    ul {
        padding: 0;
        margin: 1rem;
    }

    .content-body {
        width: 100%;
        margin-left: 0px;
    }

    #main-wrapper {
        opacity: 1;
        background: #EAEEF1;
    }
    </style>

</head>

<body>
    <div id="main-wrapper">
        <div class="content-body">

            <div class="container-fluid">
                <div class="row">
                    <div class="card">
                        <table class="table table-bordered">
                            <tr>
                                <td rowspan="2" width=30% style="vertical-align: center;">
                                    <div class="text-center">
                                        <img src="<?php echo base_url('assets/images/logo-trusmi.png') ?>" style=""
                                            height="30" width="auto">
                                    </div>
                                </td>
                                <td rowspan="2" style="vertical-align: center;">
                                    <h2>JOB PROFILE</h2>
                                    <?php if($od_status->status == null) :?>

                                    Status : <span class="badge badge-primary">Wating Review</span>
                                    <?php elseif($od_status->status == 2): ?>
                                    Status : <span class="badge badge-success">Sesuai</span>
                                    <?php elseif($od_status->status == 3): ?>
                                    Status : <span class="badge badge-danger">Sudah Tidak Relevan</span>
                                    <?php elseif($od_status->status == 4): ?>
                                    Status : <span class="badge badge-danger">Revisi</span>
                                    <?php else: ?>
                                    Status : <span class="badge badge-danger">Error</span>
                                    <?php endif; ?>
                                </td>
                                <td>No. Doc : <?= $jp['no_dok'] ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Terbit : <?= date('d F Y', strtotime($jp['release_date'])) ?></td>
                            </tr>

                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="card">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td width="35%"></td>
                                    <td width="5%"></td>
                                    <td width="60%"></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="background-color: #E4CD82">
                                    <td colspan="3">
                                        <h4 style="display:inline">
                                            <li class="fas fa-arrow-alt-circle-right text-primary"></li> 1. IDENTITAS
                                            JABATAN
                                        </h4>
                                        <a href="#catatan" style="display:inline;float:right;"
                                            onclick="tandai('Indentitas Jabatan : ')">
                                            <li class="fa fa-check"></li> Mark
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nama Jabatan</td>
                                    <td class="text-center">:</td>
                                    <td><strong><?= $jp['jabatan'] ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Divisi / Department</td>
                                    <td class="text-center">:</td>
                                    <td><strong><?= $jp['department_name'] ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Golongan</td>
                                    <td class="text-center">:</td>
                                    <td><strong><?= $jp['level_romawi'] ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Melapor Kepada</td>
                                    <td class="text-center">:</td>
                                    <td><strong><?= $jp['report_to'] ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Lokasi kerja</td>
                                    <td class="text-center">:</td>
                                    <td><strong>Cirebon</strong></td>
                                </tr>

                                <tr style="background-color: #E4CD82">
                                    <td colspan="3">
                                        <h4 style="display:inline">
                                            <li class="fas fa-arrow-alt-circle-right text-primary"></li> 2. TUJUAN
                                            JABATAN
                                        </h4>
                                        <a href="#catatan" style="display:inline;float:right;"
                                            onclick="tandai('Tujuan Jabatan : ')">
                                            <li class="fa fa-check"></li> Mark
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><?= $jp['tujuan'] ?></td>
                                </tr>

                                <tr style="background-color: #E4CD82">
                                    <td colspan="3">
                                        <h4 style="display:inline">
                                            <li class="fas fa-arrow-alt-circle-right text-primary"></li> 3. DIMENSI
                                            JABATAN
                                        </h4>
                                        <a href="#catatan" style="display:inline;float:right;"
                                            onclick="tandai('Dimensi Jabatan : ')">
                                            <li class="fa fa-check"></li> Mark
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Jumlah Bawahan</td>
                                    <td class="text-center">:</td>
                                    <td><strong><?= $jp['bawahan'] ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Area Coverage</td>
                                    <td class="text-center">:</td>
                                    <td><strong><?= $jp['area'] ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered pagebreak">
                            <thead>
                                <tr style="background-color: #E4CD82">
                                    <td colspan="2">
                                        <h4 style="display:inline">
                                            <li class="fas fa-arrow-alt-circle-right text-primary"></li> 4. TANGGUNG
                                            JAWAB UTAMA
                                        </h4>
                                        <a href="#catatan" style="display:inline;float:right;"
                                            onclick="tandai('Tanggung Jawab Utama : ')">
                                            <li class="fa fa-check"></li> Mark
                                        </a>
                                    </td>
                                </tr>
                                <tr style="background: #d9d6d6a3;">
                                    <td class="text-center"><strong>Tugas Pokok</strong></td>
                                    <td class="text-center" width="60%"><strong>Aktifitas</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($jt as $row) { ?>
                                <tr>
                                    <td style="word-wrap: break-word;"><?= $row->tugas ?></td>
                                    <td style="word-wrap: break-word;"><?= $row->aktifitas ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <table class="table table-bordered">
                            <thead>
                                <tr style="background-color: #E4CD82">
                                    <td colspan="2">
                                        <h4 style="display:inline">
                                            <li class="fas fa-arrow-alt-circle-right text-primary"></li> 5. KEY
                                            PERFORMANCE INDICATOR
                                        </h4>
                                        <a href="#catatan" style="display:inline;float:right;"
                                            onclick="tandai('Key Performance Indicator : ')">
                                            <li class="fa fa-check"></li> Mark
                                        </a>
                                    </td>
                                </tr>
                                <tr style="background: #d9d6d6a3;">
                                    <td class="text-center"><strong>Nama KPI</strong></td>
                                    <td class="text-center" width="10%"><strong>Bobot</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($kpi as $row) { ?>
                                <tr>
                                    <td><?= $row->kpi ?></td>
                                    <td align="center"><?= $row->bobot ?> %</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <table class="table table-bordered">
                            <thead>
                                <tr style="background-color: #E4CD82">
                                    <td colspan="2">
                                        <h4 style="display:inline">
                                            <li class="fas fa-arrow-alt-circle-right text-primary"></li> 6. HUBUNGAN
                                            KERJA
                                        </h4>
                                        <a href="#catatan" style="display:inline;float:right;"
                                            onclick="tandai('Hubungan Kerja : ')">
                                            <li class="fa fa-check"></li> Mark
                                        </a>
                                    </td>
                                </tr>
                                <tr style="background: #d9d6d6a3;">
                                    <td class="text-center" width="30%"><strong>HUBUNGAN INTERNAL</strong></td>
                                    <td class="text-center"><strong>TUJUAN</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($internal as $row) { ?>
                                <tr>
                                    <td><?= $row->tugas ?></td>
                                    <td><?= $row->tujuan ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <thead>
                                <tr style="background: #d9d6d6a3;">
                                    <td class="text-center" width="30%"><strong>HUBUNGAN EKSTERNAL</strong></td>
                                    <td class="text-center"><strong>TUJUAN</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($external as $row) { ?>
                                <tr>
                                    <td><?= $row->tugas ?></td>
                                    <td><?= $row->tujuan ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <table class="table table-bordered">
                            <thead>
                                <tr style="background-color: #E4CD82">
                                    <td>
                                        <h4 style="display:inline">
                                            <li class="fas fa-arrow-alt-circle-right text-primary"></li> 7. KUALIFIKASI
                                        </h4>
                                        <a href="#catatan" style="display:inline;float:right;"
                                            onclick="tandai('Kualifikasi : ')">
                                            <li class="fa fa-check"></li> Mark
                                        </a>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>1. <u>Pendidikan Formal Minimal: </u></strong></td>
                                </tr>
                                <tr>
                                    <td><?= $jp['pendidikan'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>2. <u>Pengalaman Bekerja:</u></strong></td>
                                </tr>
                                <tr>
                                    <td nowrap><?= html_entity_decode($jp['pengalaman']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>3. <u>Kompetensi:</u></strong></td>
                                </tr>
                                <tr>
                                    <td><?= html_entity_decode($jp['kompetensi']) ?></td>
                                </tr>
                            </tbody>
                        </table>


                        <table class="table table-bordered">
                            <thead>
                                <tr style="background-color: #E4CD82">
                                    <td colspan="3">
                                        <h4 style="display:inline">
                                            <li class="fas fa-arrow-alt-circle-right text-primary"></li> 8. KEWENANGAN
                                        </h4>
                                        <a href="#catatan" style="display:inline;float:right;"
                                            onclick="tandai('Kewenangan : ')">
                                            <li class="fa fa-check"></li> Mark
                                        </a>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3"><?= html_entity_decode($jp['authority']) ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered">
                            <thead>
                                <tr style="background-color: #E4CD82">
                                    <td colspan="3">
                                        <h4 style="display:inline">
                                            <li class="fas fa-arrow-alt-circle-right text-primary"></li> 9. STRUKTUR
                                            ORGANISASI
                                        </h4>
                                        <a href="#catatan" style="display:inline;float:right;"
                                            onclick="tandai('Struktur Organisasi : ')">
                                            <li class="fa fa-check"></li> Mark
                                        </a>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3">-</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered">
                            <thead>
                                <tr style="background-color: #E4CD82">
                                    <td colspan="3">
                                        <h4 style="display:inline">
                                            <li class="fas fa-arrow-alt-circle-right text-primary"></li> 10. PERSETUJUAN
                                        </h4>
                                        <a href="#catatan" style="display:inline;float:right;"
                                            onclick="tandai('Persetujuan : ')">
                                            <li class="fa fa-check"></li> Mark
                                        </a>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"> Disiapkan Oleh :</td>
                                    <td colspan="2" class="text-center"> Disetujui Oleh :</td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="padding-bottom: 100px;">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                    <td class="text-center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="text-center"><strong><?= $jp['preparedBy']; ?></strong></td>
                                    <td class="text-center"><strong>Ali Yasin</strong></td>
                                    <td class="text-center"><strong><?= $jp['head']; ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><?= $jp['preparedDep']; ?> </td>
                                    <td class="text-center" width="30%">Head of Human Resource </td>
                                    <td class="text-center" width="30%">Head of <?= $jp['department_name']; ?> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="card">
                        <h4 class="header-title mt-3 text-success">
                            <li class="fa fa-star"></li> Review
                        </h4>
                        <p>Mohon di review dengan sebaik-baiknya</p>
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- <form> -->
                                <div class="row">

                                    <div class="col-6 mt-3">
                                        <label class="me-sm-2">Nama</label>
                                        <input class="form-control select2" name="employee"
                                            value="<?= $user['employee'] ?>" readonly required>
                                            <input type="hidden" id="company_id" value="<?= $user['company'] ?>">
                                        <input type="hidden" value="<?= $jp['no_jp'] ?>" name="no_jp">
                                        <input type="hidden" value="<?= $user['user_id'] ?>" name="user_id">
                                        <input type="hidden" value="<?= $jp['no_dok'] ?>" name="no_dok">
                                        <input type="hidden" value="<?= $jp['jabatan'] ?>" name="jabatan">
                                        <input type="hidden" value="<?= $jp['department_name'] ?>" name="departement_name">


                                    </div>
                                    <div class="col-6 mt-3">
                                        <label class="me-sm-2">Designation</label>
                                        <input class="form-control select2" name="doc_type_id"
                                            value="<?= $user['designation_name'] ?>" readonly required>

                                    </div>
                                </div>
                                <div class="col-sm-12 mt-3">
                                    <label class="me-sm-2">Status</label>
                                    <select class="form-control select2" name="status" required>
                                        <option value="" disabled selected>Select Status</option>
                                        <option value="2">Sesuai</option>
                                        <option value="3">Sudah tidak relevan</option>
                                        <option value="4">Revisi</option>

                                    </select>

                                </div>
                                <div class="col-sm-12 mt-3">
                                    <div class="row">
                                        <div class="col-6"><label class="me-sm-2" id="catatan">Catatan</label></div>
                                        <div class="col-6">
                                            <small style="float:right"><a style="color:blue" href="#catatan"
                                                    onclick="hapus()">x clear</a></small>
                                        </div>
                                    </div>

                                    <textarea class="form-control ck" id="note" name="note"></textarea>

                                </div>
                                <div class="col-sm-12 mt-3 mb-2">
                                    <button class="btn btn-lg btn-block btn-success" id="btn_submit"
                                        onclick="submit_review()">Submit</button>
                                </div>

                                <!-- </form> -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php
    if (isset($js)) {
        $this->load->view($js);
    }
    ?>
</body>

</html>