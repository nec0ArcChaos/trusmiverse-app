<?php
    $tahun = substr(date('Y-m-d'), 0, 4);
    $bulan = substr(date('Y-m-d'), 5, 2);
    $tanggal = substr(date('Y-m-d'), 8, 2);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Print Out BA Temuan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon" />
    <link href="<?php echo base_url(); ?>assets/css/paper.css" rel="stylesheet" type="text/css" />
    <!-- Google font-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/fonts/font-google.css">
    <!-- Required Fremwork -->
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/icon/themify-icons/themify-icons.css">
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery.mCustomScrollbar.css">
    <!-- line icon css -->
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/icon/simple-line-icons/css/simple-line-icons.css"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/icon/font-awesome/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.1/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
    <script src="<?= base_url(); ?>assets/js/dataTables.bootstrap5.min.js"></script>

    <!-- <link rel="stylesheet" href="<?= base_url(); ?>assets/node_modules/bootstrap-icons/font/bootstrap-icons.css"> -->


    <style type="text/css">
        /* #table-inv td {
            font-size: 8pt;
        }

        #table-inv th {
            font-size: 10pt;
        }

        #logo {
            border-style: inset;
        }

        .profile td {
            font-size: 8pt;
        }

        .profile th {
            font-size: 10pt;
        } */


        /*i{
            font-size: 8pt;
            }*/
    </style>
    <style type="text/css">
        section {
            font-size: 8pt;
            font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        /* .row {
            display: block;
            clear: both;
        } */

        @media print {
            * {margin:0;padding:0}
            @page {size: A4; margin:200mm;}
            html, body {
                height: 100%;
                font-family: "Times New Roman" !important;
                /* margin: 20px !important; */
            }
        }

        .titimangsa{
            border: 1px solid black;
        }
    </style>

    <?php
    function formatBulan($bln)
    {
        $bulan = '';
        switch ($bln) {
            case "01":
                $bulan = "Januari";
                break;
            case "02":
                $bulan = "Februari";
                break;
            case "03":
                $bulan = "Maret";
                break;
            case "04":
                $bulan = "April";
                break;
            case "05":
                $bulan = "Mei";
                break;
            case "06":
                $bulan = "Juni";
                break;
            case "07":
                $bulan = "Juli";
                break;
            case "08":
                $bulan = "Agustus";
                break;
            case "09":
                $bulan = "September";
                break;
            case "10":
                $bulan = "Oktober";
                break;
            case "11":
                $bulan = "November";
                break;
            case "12":
                $bulan = "Desember";
                break;
            default:
                $bulan = "";
        }
        return $bulan;
    }

    function romawi($bln)
    {
        $romawi = '';
        switch ($bln) {
            case "01":
                $romawi = 'I';
                break;
            case "02":
                $romawi = 'II';
                break;
            case "03":
                $romawi = 'III';
                break;
            case "04":
                $romawi = 'IV';
                break;
            case "05":
                $romawi = 'V';
                break;
            case "06":
                $romawi = 'VI';
                break;
            case "07":
                $romawi = 'VII';
                break;
            case "08":
                $romawi = 'VIII';
                break;
            case "09":
                $romawi = 'IX';
                break;
            case "10":
                $romawi = 'X';
                break;
            case "11":
                $romawi = 'XI';
                break;
            case "12":
                $romawi = 'XII';
                break;
            default:
                $romawi = '-';
        }
        return $romawi;
    }
    ?>

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
            $temp = " Seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai / 100) . " Ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " Seribu" . penyebut($nilai - 1000);
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
    ?>

    <?php
    function bulan_indo($tanggal)
    {
        if ($tanggal != null) {
            $bulan = array(
                1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
            $pecahkan = explode('-', $tanggal);

            // variabel pecahkan 0 = tanggal
            // variabel pecahkan 1 = bulan
            // variabel pecahkan 2 = tahun

            return $bulan[(int) $pecahkan[1]];
        } else {
            return null;
        }
    }

    ?>
</head>

<body class="A4">
    <section class="sheet padding-10mm" style="height: auto;">

        <div class="row">
            <div class="col">
                <div class="card-header" style="padding-bottom:0; padding-top:2px">
                    <div class="row">
                        <table border="1px solid black" style="width:100%">
                            <tr>
                                <td rowspan="4" style="width:33%;padding-left:20px">
                                    <img src="<?php echo base_url('assets/icon/logo-trusmi.png') ?>" height="40" style="vertical-align:unset!important; ">
                                </td>
                                <td rowspan="4" style="width:33%; padding-right:50px; padding-left:50px;" align="center">
                                    <h6><b>Berita Acara</b></h6>
                                    <h6><b><?= $data[0]->category ?></b></h6>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="width:7%; padding-left:5px">Divisi</td>
                                <td class="text-center" style="padding-left:5px;padding-right:5px;"><?= $data[0]->divisi ?> - <?= $data[0]->company_name ?></td>
                            </tr>
                            <tr>
                                <td style="width:7%; padding-left:5px">No</td>
                                <td class="text-center" style="padding-left:5px;padding-right:5px;"><?= $data[0]->id_temuan ?></td>
                            </tr>
                            <tr>
                                <td style="width:7%; padding-left:5px">Tgl</td>
                                <td class="text-center" style="padding-left:5px;padding-right:5px;"><?= date('d', strtotime($data[0]->waktu_input)) ?> <?= bulan_indo($data[0]->waktu_input) ?> <?= date('Y', strtotime($data[0]->waktu_input)) ?></td>
                            </tr>
                            <tr>
                                <td style="border:none"></td>
                                <td style="border:none"></td>
                                <td colspan="2" style="padding:5px">Diterima tgl : <?= date('d', strtotime($data[0]->tanggal_tanggapan)) ?> <?= bulan_indo($data[0]->tanggal_tanggapan) ?> <?= date('Y', strtotime($data[0]->tanggal_tanggapan)) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-12">
                            <table border="0">
                                <!-- <tr>
                                    <td colspan="12">&nbsp;</td>
                                </tr> -->
                                <tr>
                                    <td>Area Pemeriksaan</td>
                                    <td style="padding-left:10px; padding-right:10px">:</td>
                                    <td><?= $data[0]->divisi ?></td>
                                </tr>
                                <tr>
                                    <td>Proses Kerja</td>
                                    <td style="padding-left:10px; padding-right:10px">:</td>
                                    <td><?= $data[0]->proses_kerja ?></td>
                                </tr>
                                <tr>
                                    <td>Detail Sub Proses Kerja</td>
                                    <td style="padding-left:10px; padding-right:10px">:</td>
                                    <td><?= $data[0]->sub_proses_kerja ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row" style="margin-top:20px">
                        <div class="col-sm-12">
                            Temuan Audit : 
                            <div class="card" style="background: transparent;border-style: solid;border-width: 1px;border-color: black;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <table style="margin:2px;">
                                                <tr>
                                                    <td style="padding:10px;">
                                                        <div class="">
                                                            <?php 
                                                                $show = '';
                                                                if ($data[0]->lampiran != null) {
                                                                    $lampirans =  explode(",",$data[0]->lampiran); 
                                                                    foreach ($lampirans as $key => $value) {
                                                                        $ext = pathinfo($value, PATHINFO_EXTENSION);
                                                                        if($ext=='jpg' || $ext=='png' || $ext=='JPEG' || $ext=='JPG'){
                                                                            $show .= '<img src="'.base_url('uploads/audit_temuan') .'/'. trim($value).'" width="150" style="vertical-align:unset!important;padding:5px;">';
                                                                        }else{
                                                                            $show .= '<br>Link : '. base_url('uploads/audit_temuan/') . $value . '<br>';
                                                                        }
                                                                        if(fmod(($key+1), 2) == 0){
                                                                            $show .= '<br>';
                                                                        }
                                                                    }
                                                                }
                                                                echo $show;
                                                            ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-left:10px;">Alat Bukti :</td>
                                                </tr>
                                                <?php 
                                                    $list = '';
                                                    $alat_buktis =  explode(",",$data[0]->alat_bukti); 
                                                    foreach ($alat_buktis as $key => $value) {
                                                        $list .= '<tr>
                                                                    <td style="padding-left:10px;">'.($key+1).'.'.$value.' </td>
                                                                <tr>';
                                                    }
                                                    echo $list;
                                                ?>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </table>  
                                        </div>
                                        <div class="col-6">
                                            Detail : 
                                            <p style="text-align:justify; font-size:8pt;"><?= $data[0]->temuan ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                    
                    <div class="row" style="margin-top:20px">
                        <div class="col-sm-12">
                            Keterangan Auditor : 
                            <div class="card" style="background: transparent;border-style: solid;border-width: 1px;border-color: black;">
                                <div class="card-body">
                                    <?= $data[0]->keterangan_pic ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top:10px">
                        <div class="col">
                            <table style="width:100%">
                                <tr>
                                    <td style="width:50%">Tanggapan Auditee :</td>
                                    <td>
                                        <table style="width:100%" border="1">
                                            <tr>
                                                <td style="padding:5px;">Verifikasi Bersama :</td>
                                                <td style="padding:5px;" class="text-center">S</td>
                                                <td style="padding:5px;" class="text-center">T</td>
                                                <td style="padding:5px;" class="text-center">Ya / Tidak</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <div class="card" style="background: transparent;border-style: solid;border-width: 1px;border-color: black;">
                                <div class="card-body">
                                    <?= $data[0]->feedback ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row" style="margin-top:10px">
                        <div class="col">
                            Target Perbaikan Auditee:
                            <div class="card" style="background: transparent;border-style: solid;border-width: 1px;border-color: black;">
                                <div class="card-body">
                                    <b><u>Corrective</u></b> (<?= $data[0]->status_corrective ?>) : <?= $data[0]->corrective ?>. <b><u>Deadline <?= $data[0]->deadline_corrective ?></u></b> 
                                    <br>
                                    <b><u>Preventif</u></b> (<?= $data[0]->status_preventif ?>) : <?= $data[0]->preventif ?>. <b><u>Deadline <?= $data[0]->deadline_preventif ?></u></b> 
                                </div>
                            </div>
                            <!-- <table style="width:100%">
                                <tr>
                                    <td style="width:50%">Target Perbaikan :</td>
                                </tr>
                                <tr>
                                    <td style="word-break:break-all;">
                                        <div class="card" style="background: transparent;border-style: solid;border-width: 1px;border-color: black;">
                                            <div class="card-body">
                                                Corrective : <?php //echo $data[0]->corrective ?>
                                                <br>
                                                Preventif : <?php //echo $data[0]->preventif ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table> -->
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        

        <div class="row" style="margin-top: 20px; margin-left:10px; margin-right:10px;">
            <div class="col">
                <table width="100%" id="titimangsa">
                    <tfoot>
                        <tr>
                            <td class="text-center titimangsa">Diserahkan Oleh,</td>
                            <td class="text-center titimangsa">Diterima Oleh,</td>
                            <td style="width:10%;"></td>
                            <td class="text-center titimangsa">Diserahkan Kembali Oleh,</td>
                            <td class="text-center titimangsa">Auditor Penerima,</td>
                        </tr>
                        <tr>
                            <th height="50px" class="titimangsa"></th>
                            <th height="50px" class="titimangsa"></th>
                            <th height="50px"></th>
                            <th height="50px" class="titimangsa"></th>
                            <th height="50px" class="titimangsa"></th>
                        </tr>
                        <tr>
                            <th class="text-center titimangsa"><?= $data[0]->auditor ?></th>
                            <th class="text-center titimangsa"><?= $data[0]->employee_name ?></th>
                            <td></td>
                            <th class="text-center titimangsa"><?= $data[0]->employee_name ?></th>
                            <th class="text-center titimangsa"><?= $data[0]->auditor ?></th>
                        </tr>
                        <tr>
                            <td class="text-center titimangsa pl-1">Tgl. <?= date('d', strtotime($data[0]->waktu_input)) ?> <?= bulan_indo($data[0]->waktu_input) ?> <?= date('Y', strtotime($data[0]->waktu_input)) ?></td>
                            <td class="text-center titimangsa pl-1">Tgl. <?= date('d', strtotime($data[0]->waktu_input)) ?> <?= bulan_indo($data[0]->waktu_input) ?> <?= date('Y', strtotime($data[0]->waktu_input)) ?></td>
                            <td></td>
                            <td class="text-center titimangsa pl-1">Tgl. <?= date('d', strtotime($data[0]->tanggal_tanggapan)) ?> <?= bulan_indo($data[0]->tanggal_tanggapan) ?> <?= date('Y', strtotime($data[0]->tanggal_tanggapan)) ?></td>
                            <td class="text-center titimangsa pl-1">Tgl. <?= date('d', strtotime($data[0]->tanggal_keterangan_pic)) ?> <?= bulan_indo($data[0]->tanggal_keterangan_pic) ?> <?= date('Y', strtotime($data[0]->tanggal_keterangan_pic)) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </section>


</body>
<script type="text/javascript">
    window.print();
    window.close();
</script>

</html>