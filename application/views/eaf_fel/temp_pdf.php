<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Detail Pengajuan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">

    <link href="<?php echo base_url(); ?>assets/css/paper.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/dataTables.bootstrap5.min.css">


    <script src="<?= base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/dataTables.bootstrap5.min.js"></script>

    <style type="text/css">
        table.listItem tr th,
        table.listItem tr td {
            padding: 1mm 3mm;
        }

        .table1 {
            font-family: sans-serif;
            color: #444;
            border-collapse: collapse;
            width: 20%;
            border: 1px solid #f2f5f7;
        }

        .logo {
            width: 80mm;
            float: left;
            position: absolute;
        }

        .logo img {
            width: 80mm;
        }

        .logo-text {
            /*float: left;*/
            width: 100%;
        }

        .logo-text p {
            margin: 0px;
        }

        .LeftBox {
            width: 100%;
            height: 18mm;
            float: left;
            text-align: center;
        }

        .LeftBoxInfo {
            width: 65mm;
            float: left;
        }

        .RightBox {
            width: 145mm;
            float: right;
        }

        .table1 tr th {
            background: #35A9DB;
            color: #fff;
            font-weight: normal;
        }

        .table1,
        th,
        td {
            padding: 5px 15px;
            text-align: left;
            font-size: 8pt;
        }

        .table1 tr:hover {
            background-color: #f5f5f5;
        }

        .table1 tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .line {
            /* background-color: #000000;
            padding: 0.2mm; */
            border-top: 3px solid #bbb;
            clear: both;
        }
    </style>

</head>

<body class="A4">
    <section class="sheet padding-10mm" style="padding: 3mm;">
        <header>
            <div class="col-sm-12">
                <table>
                    <tr>
                        <td style="width: 25%;"> <img src="<?= base_url() ?>assets/img/logo_trusmiverse.png" width="70" height="auto"></td>
                        <td style="text-align:center;width: 50%;">
                            <?php if ($flag == 'Pengajuan' || $flag == 'Reject') { ?>

                                <p style="font-size: 12px;margin-bottom: 0; text-transform: uppercase; font-weight: bold;text-align: center;">
                                    FINANCE & ACCOUNTING</p>
                                <p style="font-size: 12px;margin-bottom: 0;font-weight: bold;text-align: center;margin-top:0 !important">Expenses Approval Finance (EAF)</p>

                            <?php } else if ($flag == 'LPJ' || $flag == 'Reject-LPJ') { ?>

                                <p style="font-size: 12px;margin-bottom: 0; text-transform: uppercase; font-weight: bold;text-align: center;">TRUSMI GROUP</p><br>
                                <p style="font-size: 12px;margin-bottom: 0;font-weight: bold;text-align: center;">LPJ Expenses Approval Finance (EAF) </p>

                            <?php } ?>
                        </td>
                        <td style="width: 25%;">
                            <?php if ($flag == 'Pengajuan' || $flag == 'Reject') { ?>
                                <?php foreach ($detail_eaf as $row) { ?>
                                    <table style="text-align: left;">
                                        <tbody>
                                            <tr>
                                                <td><?= $row->id_pengajuan ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= $row->tgl_input ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <?php } ?>
                            <?php } else if ($flag == 'LPJ' || $flag == 'Reject-LPJ') { ?>
                                <?php foreach ($detail_lpj as $rows) { ?>
                                    <table style="text-align: left;">
                                        <tbody>
                                            <tr>
                                                <td> <?= $rows->id_pengajuan ?></td>
                                            </tr>
                                            <tr>
                                                <td> <?= $rows->tgl_input ?></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
                <!-- <div class="row">
                    <div class="col-sm-3">
                        <img src="<?= base_url() ?>assets/images/logo-trusmi.png" width="70" height="auto" style="margin-bottom: -15px;">
                    </div>
                    <div class="col-sm-6">
                        <?php if ($flag == 'Pengajuan' || $flag == 'Reject') { ?>

                            <p style="font-size: 12px; text-transform: uppercase; font-weight: bold;text-align: center;">
                                FINANCE & ACCOUNTING</p>
                            <p style="font-size: 12px;font-weight: bold;text-align: center;margin-top:0 !important">Expenses Approval Finance (EAF)</p>

                        <?php } else if ($flag == 'LPJ' || $flag == 'Reject-LPJ') { ?>

                            <p style="font-size: 12px; text-transform: uppercase; font-weight: bold;text-align: center;">TRUSMI GROUP</p><br>
                            <p style="font-size: 12px;font-weight: bold;text-align: center;">LPJ Expenses Approval Finance (EAF) </p>

                        <?php } ?>
                    </div>
                    <div class="col-sm-3"></div>
                </div> -->
            </div>
        </header>
        <div class="line"></div>
        <br>
        <article style="margin-top: -5mm;">
            <?php if ($flag == 'Pengajuan' || $flag == 'Reject') { ?>

                <div class="row">
                    <div class="LeftBoxInfo">
                        <?php foreach ($detail_eaf as $key) { ?>
                            <table style="text-align: left;">
                                <tbody>
                                    <!-- <tr>
                                        <td style="font-weight: bold;">No EAF </td>
                                        <td> : <?= $key->id_pengajuan ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Tanggal Input </td>
                                        <td> : <?= $key->tgl_input ?></td>
                                    </tr> -->
                                    <!-- <tr>
											<td style="font-weight: bold;">Jam Input </td>
											<td> :    <//?= date("H:i",strtotime($key->tgl_input))?></td>
									</tr> -->

                                    <tr>
                                        <td style="font-weight: bold;">Divisi </td>
                                        <td> : <?= $key->nama_divisi ?></td>
                                    </tr>

                                    <tr>
                                        <td style="font-weight: bold;">Kategori </td>
                                        <td> : <?= $key->nama_kategori ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Tipe pembayaran </td>
                                        <td> : <?php echo $key->nama_tipe; ?>
                                            <?php if ($key->nama_tipe == 'Transfer Bank') { ?>
                                                <br><?php echo $key->nama_bank; ?> | <?php echo $key->no_rek; ?>
                                            <?php } else if ($key->nama_tipe == 'Giro') { ?>
                                                &nbsp;&nbsp;&nbsp;# NAMA BANK : <?php echo $key->nama_bank; ?>&nbsp;&nbsp;&nbsp; # NO. REK : <?php echo $key->no_rek; ?>
                                            <?php } ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Penerima </td>
                                        <td> : <?= $key->nama_penerima ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Pengaju </td>
                                        <td> : <?= $key->pengaju ?></td>
                                    </tr>

                                    <tr>
                                        <td style="font-weight: bold;">Note Finance </td>
                                        <td> : <?= $note_finance ?></td>
                                    </tr>

                                </tbody>
                            </table>
                        <?php } ?>
                    </div>
                    <div class="RightBox">

                        <table class="table table-striped table-bordered" style="width: 99%;margin-top:5px;margin-bottom: 5px;">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Remark</th>
                                    <th style=" text-align: center;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($detail_keperluan as $key) {
                                    $nominal = $key->nominal_uang;
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $key->nama_keperluan; ?>
                                            <!-- Sementara Disable untuk Aktifkan ubah 21 ke 20 | Faisal -->
                                            <?php if ($key->id_kategori == "21") { ?> 
                                                <br> Rp. <?= number_format($key->nominal_termin, 0, ',', '.') ?>/termin, Periode <?= $key->periode_termin ?>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $key->note ?></td>
                                        <td style="text-align: right;"><?php echo "Rp. " . number_format($key->nominal_uang, 2, ',', '.'); ?></td>
                                    <?php } ?>
                                    </tr>

                            </tbody>
                        </table>

                        <div class="row">
                            <table>
                                <tbody>
                                    <tr>
                                        <!-- <td style="font-weight: bold;"> </td> -->
                                        <td style=" text-align: right;"> <i style="font-weight: bold;">Terbilang</i> : 
                                        <!-- <//?php echo   "Rp. " . number_format($sub_total->sub_total, 2, ',', '.'); ?> -->
                                        <i>
                                            <?php
                                            function penyebut($nilai)
                                            {
                                                $nilai = abs($nilai);
                                                $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
                                                $temp = "";
                                                if ($nilai < 12) {
                                                    $temp = " " . $huruf[$nilai];
                                                } else if ($nilai < 20) {
                                                    $temp = penyebut($nilai - 10) . " Belas";
                                                } else if ($nilai < 100) {
                                                    $temp = penyebut($nilai / 10) . " Puluh" . penyebut($nilai % 10);
                                                } else if ($nilai < 200) {
                                                    $temp = " seratus" . penyebut($nilai - 100);
                                                } else if ($nilai < 1000) {
                                                    $temp = penyebut($nilai / 100) . " Ratus" . penyebut($nilai % 100);
                                                } else if ($nilai < 2000) {
                                                    $temp = " seribu" . penyebut($nilai - 1000);
                                                } else if ($nilai < 1000000) {
                                                    $temp = penyebut($nilai / 1000) . " Ribu" . penyebut($nilai % 1000);
                                                } else if ($nilai < 1000000000) {
                                                    $temp = penyebut($nilai / 1000000) . " Juta" . penyebut($nilai % 1000000);
                                                } else if ($nilai < 1000000000000) {
                                                    $temp = penyebut($nilai / 1000000000) . " Milyar" . penyebut(fmod($nilai, 1000000000));
                                                } else if ($nilai < 1000000000000000) {
                                                    $temp = penyebut($nilai / 1000000000000) . " Trilyun" . penyebut(fmod($nilai, 1000000000000));
                                                }
                                                return $temp;
                                            }

                                            function terbilang($nilai)
                                            {
                                                if ($nilai < 0) {
                                                    $hasil = "minus " . trim(penyebut($nilai));
                                                } else {
                                                    $hasil = trim(penyebut($nilai));
                                                }
                                                return $hasil;
                                            }


                                            $angka = $sub_total->sub_total;
                                            echo " " . terbilang($angka) . " Rupiah  ";
                                            ?>
                                        </i>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <!-- <//?php foreach ($detail_eaf as $key_app) { ?>
                            <table style="text-align: left;">
                                <tbody>
                                    <tr>
                                        <td style="font-weight: bold;">Tipe pembayaran </td>
                                        <td> : <?php echo $key_app->nama_tipe; ?>
                                            <?php if ($key_app->nama_tipe == 'Transfer Bank') { ?>
                                                &nbsp;&nbsp;# NAMA BANK : <?php echo $key_app->nama_bank; ?>&nbsp;&nbsp;&nbsp; # NO. REK : <?php echo $key->no_rek; ?>
                                            <?php } else if ($key_app->nama_tipe == 'Giro') { ?>
                                                &nbsp;&nbsp;&nbsp;# NAMA BANK : <?php echo $key_app->nama_bank; ?>&nbsp;&nbsp;&nbsp; # NO. REK : <?php echo $key_app->no_rek; ?>
                                            <?php } ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Penerima </td>
                                        <td> : <?= $key_app->nama_penerima ?></td>
                                    </tr>

                                    <tr>
                                        <td style="font-weight: bold;"> <?php if ($key_app->nama_biaya) { ?> Nama Biaya <?php } ?> </td>
                                        <td> <?php if ($key_app->nama_biaya) { ?> :
                                                <?= $key_app->nama_biaya ?>
                                            <?php } ?>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        <//?php } ?> -->
                    </div>
                </div>


            <?php } else if ($flag == 'LPJ' || $flag == 'Reject-LPJ') { ?>

                <div class="row">
                    <div class="LeftBoxInfo">
                        <?php foreach ($detail_lpj as $keyss) { ?>
                            <table style="text-align: left;">
                                <tbody>
                                    <tr>
                                        <td>No LPJ </td>
                                        <td> : <?= $keyss->id_pengajuan ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Input </td>
                                        <td> : <?= $keyss->tgl_input ?></td>
                                    </tr>
                                    <!-- <tr>
                                        <td>Jam Input </td>
                                        <td> : <?= date("H:i", strtotime($keyss->tgl_input)) ?></td>
                                    </tr> -->
                                    <tr>
                                        <td>User Pembuat </td>
                                        <td> : <?= $keyss->name ?></td>
                                    </tr>

                                </tbody>
                            </table>

                        <?php } ?>
                    </div>
                    <div class="RightBox">
                        <?php foreach ($detail_lpj as $keyss) { ?>
                            <table style="text-align: left;">
                                <tbody>

                                    <tr>
                                        <td>Divisi </td>
                                        <td> : <?= $keyss->nama_divisi ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kategori </td>
                                        <td> : <?= $keyss->nama_kategori ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama LPJ </td>
                                        <td> : <?= $keyss->name ?></td>
                                    </tr>
                                </tbody>
                            </table>

                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <br>


            <?php if ($flag == 'Pengajuan' || $flag == 'Reject') { ?>



            <?php } else if ($flag == 'LPJ' || $flag == 'Reject-LPJ') { ?>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Pengajuan</th>
                            <th>Nama LPJ</th>
                            <th>Note</th>
                            <th style=" text-align: right;">Nominal Uang</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $i = 1;
                        foreach ($detail_kep_lpj as $key_lpj) {
                            $nominal_lpj = $key_lpj->nominal_lpj ?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><?php echo $key_lpj->id_pengajuan ?></td>
                                <td><?php echo $key_lpj->nama_lpj ?></td>
                                <td><?php echo $key_lpj->note_lpj ?></td>
                                <td style=" text-align: right;">
                                    <?php echo   "Rp. " . number_format($nominal_lpj, 2, ',', '.'); ?>
                                </td>

                            <?php } ?>
                            </tr>

                    </tbody>

                </table>

                <div class="row">
                    <table>
                        <tbody>
                            <tr>
                                <td style="font-weight: bold;">Nominal LPJ </td>
                                <td style=" text-align: right;">: <?php echo   "Rp. " . number_format($sub_total_2->sub_total_2, 2, ',', '.'); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php } ?>

            <div style="width: 70mm; float: left;">
                <table border="0" style="width: 100%;text-align: center;">
                    <tbody>
                        <tr>
                            <td style="font-weight: bold;">Prepared By</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>____________________, 
                                <br>
                                <?= $tgl_pembuat ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 11px;font-weight: bold;text-transform: uppercase;"><?php echo $pembuat; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="width: 61mm; float: left;">
                <table style="width: 100%;text-align: center;">
                    <tbody>
                        <tr>
                            <td style="font-weight: bold;">Approved By</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="font-size: 11px;">____________________
                                <br>
                                <?= $tgl_approve ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 11px;font-weight: bold;text-transform: uppercase;"><?php echo $approve; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="width: 70mm; float: right;">
                <table border="0" style="width: 100%; text-align: center;">
                    <tbody>
                        <tr>
                            <td style="font-weight: bold;">Finance By</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>____________________, 
                                <br>
                                <?= $tgl_finance ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 11px;font-weight: bold;text-transform: uppercase;"><?php echo $finance; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </article>
    </section>

</body>
<script>
    window.print();
    // window.close();
</script>

</html>