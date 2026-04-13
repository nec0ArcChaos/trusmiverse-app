<!DOCTYPE html>
<html>

<head>
    <title>Review <?= $sop->nama_dokumen ?></title>
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

    <link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" /> -->
    <!-- Daterange picker -->
    <link href="<?php echo base_url() ?>assets/vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
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
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <center>

                    <h2 class="mt-2 text-success">Review SOP</h2>
                    <h5><?= $sop->no_doc ?> | <?= $sop->nama_dokumen ?></h5>
                </center>
            </div>
        </div>
    </div>
    <div>
        <object data='https://trusmicorp.com/od/assets/files/<?= $sop->file ?>' type="application/pdf" width="100%"
            height="678">

            <iframe src='https://trusmicorp.com/od/assets/files/<?= $sop->file ?>' width="100%" height="678">
                <p>This browser does not support PDF!</p>
            </iframe>
        </object>
    </div>
    <div id="main-wrapper">
        <div class="content-body">

            <div class="container-fluid">
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
                                        <input type="hidden" value="<?= $id_sop ?>" name="id_sop">
                                        <input type="hidden" value="<?= $user['user_id'] ?>" name="user_id">
                                        <input type="hidden" id="company_id" value="<?= $user['company'] ?>">
                                        <input type="hidden" value="<?= $sop->no_doc ?>" name="no_dok">
                                        <input type="hidden" value="<?= $sop->nama_dokumen ?>" name="nama_dokumen">
                                        <input type="hidden" value="<?= $sop->designation_name ?>" name="jabatan">
                                        <input type="hidden" value="<?= $sop->department_name ?>" name="departement_name">


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
                                        <div class="col-6"><label class="me-sm-2">Catatan</label></div>
                                        <div class="col-6">
                                            <small style="float:right"><a style="color:blue" href="#note"
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