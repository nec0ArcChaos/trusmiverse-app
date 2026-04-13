<?php
$this->load->view('template/format_bulan');
$this->load->view('template/romawi');
$this->load->view('template/terbilang');
$this->load->view('template/hari_indo');

$tahun = substr(date('Y-m-d'), 0, 4);
$bulan = substr(date('Y-m-d'), 5, 2);
$tanggal = substr(date('Y-m-d'), 8, 2);
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Form Pengajuan Web Complain</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">
        <!-- <link href="<?php echo base_url(); ?>assets/css/paper.css" rel="stylesheet" type="text/css" /> -->
        <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="32x32" type="image/png">
        <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="16x16" type="image/png">
        <!-- Google font-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link rel="stylesheet" href="<?= base_url(); ?>assets/node_modules/bootstrap-icons/font/bootstrap-icons.css">

        <!-- chosen css -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/chosen_v1.8.7/chosen.min.css">

        <!-- date range picker -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/daterangepicker/daterangepicker.css">

        <!-- swiper carousel css -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/swiper-7.3.1/swiper-bundle.min.css">

        <!-- simple lightbox css -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/simplelightbox/simple-lightbox.min.css">

        <!-- app tour css -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/Product-Tour-Plugin-jQuery/lib.css">

        <!-- Data Table Css -->
        <!-- https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.min.css">
        <!-- https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/dataTables.bootstrap5.min.css">
        <!-- https://cdn.datatables.net/rowreorder/1.3.1/css/rowReorder.dataTables.min.css -->
        <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.1/css/rowReorder.dataTables.min.css">
        <!-- https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css -->
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
        
        <style type="text/css">
            section {
                /* font-size: 11px; */
                font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            }

            @page {
                size: A4;
                margin: 10mm;
            }

            .header, .header-space {
                height: 160px;
            }
            .footer,  .footer-space {
                height: 80px;
                /* display: flex;
                justify-content: center;
                align-items: center; */
            }

            .header  {
                position: fixed;
                top: 0;
            }
            .footer  {
                position: fixed;
                bottom: 0;
            }

            #data_konsumen tr, th{
                /* font-size: 6pt; */
                padding-left: 3px;
                padding-right: 3px;
            }
            #data_konsumen tr, td{
                /* font-size: 6pt; */
            }
            #data_konsumen td{
                vertical-align: middle; 
                width:10px; 
                white-space: normal;
                padding-left: 3px;
                padding-right: 3px;
            }
            @media print {
                * {margin:0;padding:0}
                @page {size: A4; margin:0mm;}
                html, body {
                    height: 100%;
                    font-family: "Times New Roman" !important;
                }
            }

            th, td, span{
                font-weight: normal !important;
            }
            

            .justify{
                /* display: flex; */
                justify-content: space-evenly;
            }

            .print_complaint {
                width: 100%;
            }

            .print_complaint td {
                padding-left: 5px;
                padding-right: 5px;
                /* padding-top: 1px;
                padding-bottom: 1px; */
                font-size: 9pt;
            }

            .attach_table{
                width: 100%;
            }
            .attach_table tr, 
            .attach_table td{
                padding: 5px;
                border: 1px solid black;
            }

            .attach{
                height : 150px;
                /* justify content: center  */
                text-align: center;
                vertical-align: middle;
            }

            .desc{
                vertical-align: top;
                padding-left: 25px !important;
            }

            .border-outside {
                border: 2px solid black; /* Adjust the width and color as needed */
                padding: 10px; /* Optional: add padding if you want space between the content and the border */
            }

        </style>
    </head>

    <?php $attach = explode(",", $complaint->attachment); ?>


    <body class="A4">
        <!-- <section class="sheet" style="height: auto;"> -->
            <div class="header" style="margin-top:-30px">
                <img src="<?php echo base_url('assets/logo/header-ba.png') ?>" style="width: 100%;height: auto;">
            </div>
            <div class="header-space"></div>

            <div class="row" style="margin-top: -40px !important;">
                <!-- <div class="col text-center" style="margin: 20px 0;"> -->
                <div class="col text-center">
                    <h5><u><strong>Form Pengajuan Web Complain<strong></u></h5>
                </div>
            </div>

            <div class="row" style="margin-top: 5px; margin-left: 30px; margin-right: 30px;">
                <div class="col-sm-6">
                    <table class="print_complaint" style="width:100%">
                        <tr>
                            <td style="width: 35%">Nama Konsumen</td>
                            <td style="width: 3%">:</td>
                            <td><?= $complaint->nama_konsumen ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Pengajuan</td>
                            <td style="width: 3%">:</td>
                            <td><?= $complaint->tanggal_pengajuan ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal QC Passed</td>
                            <td style="width: 3%">:</td>
                            <td><?= $complaint->tgl_qc_passed ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal After sales</td>
                            <td style="width: 3%">:</td>
                            <td><?= $complaint->tgl_after_sales ?></td>
                        </tr>
                        <tr>
                            <td>Requested Divisi</td>
                            <td style="width: 3%">:</td>
                            <td>Marketing</td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-6">
                    <table class="print_complaint">
                        <tr>
                            <td style="width: 35%">Project</td>
                            <td style="width: 3%">:</td>
                            <td><?= $complaint->project ?></td>
                        </tr>
                        <tr>
                            <td>Blok</td>
                            <td style="width: 3%">:</td>
                            <td><?= $complaint->blok ?></td>
                        </tr>
                        <tr>
                            <td>Verified By</td>
                            <td style="width: 3%">:</td>
                            <td><?= $complaint->verified_by ?></td>
                        </tr>
                        <tr>
                            <td>Escalation to</td>
                            <td style="width: 3%">:</td>
                            <td><?= $complaint->escalation_to ?></td>
                        </tr>
                        <tr>
                            <td>Priority</td>
                            <td style="width: 3%">:</td>
                            <td><?= $complaint->priority ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>

            <div class="row" style="margin-top: 10px; margin-left: 50px; margin-right: 50px;">
                <div class="col border-outside">
                    <table class="print_complaint">
                        <thead>
                            <tr>
                                <th><strong>Deskripsi Kerusakan</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="height: 150px">
                                <td class="desc">
                                    <p><?= $complaint->description ?></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-1"></div>
                <div class="col-10">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5><strong>Dokumentasi Kerusakan</strong></h5>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <?php

                                    foreach ($attach as $key => $value) { 

                                        $ext = pathinfo($value, PATHINFO_EXTENSION);
                                        
                                        if($key < 9){ ?>

                                            <div class="col-4 text-center" style="border: 1px solid black; padding: 5px; align-items: center; justify-content: center; display: flex;">
                                                <?php if($ext == 'pdf'){ ?>
                                                    <i class="bi bi-file-pdf"></i>

                                                <?php }else if($ext == 'mp4' || $ext == 'mov' || $ext == 'avi' || $ext == 'mkv' || $ext == 'webm' || $ext == 'flv' || $ext == 'wmv' || $ext == 'mpeg' || $ext == 'mpg' || $ext == 'm4v' || $ext == '3gp'){ ?>
                                                    <i class="bi bi-film" style="font-size:20pt"></i>
                                                
                                                <?php }else{ ?>
                                                    <img src="<?php echo base_url('uploads/complaints/'.$value) ?>" style="height: 120px;">
                                                
                                                <?php } ?>
                                            </div>
                                            
                                        <?php }
                                    } ?>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
            </div>

            <div class="row">
                <div class="col">
                    <tfoot>
                        <tr>
                            <td>
                                <div class="footer-space">&nbsp;</div>
                            </td>
                        </tr>
                    </tfoot>
                </div>
            </div>

            
            <div class="footer">
                <img src="<?php echo base_url('assets/logo/footer-ba.png') ?>" style="width: 100%;height: auto;">
            </div>

        <!-- </section> -->
    </body>


    <script type="text/javascript">
        window.print();
        // window.onfocus=function(){ window.close();}
    </script>

</html>


<?php if(count($attach) > 9){ ?>
    <html>

    <head>
        <meta charset="utf-8">
        <title>Form Pengajuan Web Complain</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">
        <!-- <link href="<?php echo base_url(); ?>assets/css/paper.css" rel="stylesheet" type="text/css" /> -->
        <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="32x32" type="image/png">
        <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="16x16" type="image/png">
        <!-- Google font-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link rel="stylesheet" href="<?= base_url(); ?>assets/node_modules/bootstrap-icons/font/bootstrap-icons.css">

        <!-- chosen css -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/chosen_v1.8.7/chosen.min.css">

        <!-- date range picker -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/daterangepicker/daterangepicker.css">

        <!-- swiper carousel css -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/swiper-7.3.1/swiper-bundle.min.css">

        <!-- simple lightbox css -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/simplelightbox/simple-lightbox.min.css">

        <!-- app tour css -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/Product-Tour-Plugin-jQuery/lib.css">

        <!-- Data Table Css -->
        <!-- https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.min.css">
        <!-- https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/dataTables.bootstrap5.min.css">
        <!-- https://cdn.datatables.net/rowreorder/1.3.1/css/rowReorder.dataTables.min.css -->
        <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.1/css/rowReorder.dataTables.min.css">
        <!-- https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css -->
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
        
        <style type="text/css">
            section {
                /* font-size: 11px; */
                font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            }

            @page {
                size: A4;
                margin: 10mm;
            }

            .header, .header-space {
                height: 160px;
            }
            .footer,  .footer-space {
                height: 80px;
                /* display: flex;
                justify-content: center;
                align-items: center; */
            }

            .header  {
                position: fixed;
                top: 0;
            }
            .footer  {
                position: fixed;
                bottom: 0;
            }

            #data_konsumen tr, th{
                /* font-size: 6pt; */
                padding-left: 3px;
                padding-right: 3px;
            }
            #data_konsumen tr, td{
                /* font-size: 6pt; */
            }
            #data_konsumen td{
                vertical-align: middle; 
                width:10px; 
                white-space: normal;
                padding-left: 3px;
                padding-right: 3px;
            }
            @media print {
                * {margin:0;padding:0}
                @page {size: A4; margin:0mm;}
                html, body {
                    height: 100%;
                    font-family: "Times New Roman" !important;
                }
            }

            th, td, span{
                font-weight: normal !important;
            }
            

            .justify{
                /* display: flex; */
                justify-content: space-evenly;
            }

            .print_complaint {
                width: 100%;
            }

            .print_complaint td {
                padding-left: 5px;
                padding-right: 5px;
                /* padding-top: 1px;
                padding-bottom: 1px; */
                font-size: 9pt;
            }

            .attach_table{
                width: 100%;
            }
            .attach_table tr, 
            .attach_table td{
                padding: 5px;
                border: 1px solid black;
            }

            .attach{
                height : 150px;
                /* justify content: center  */
                text-align: center;
                vertical-align: middle;
            }

            .desc{
                padding-left: 25px !important;
            }

            .border-outside {
                border: 2px solid black; /* Adjust the width and color as needed */
                padding: 10px; /* Optional: add padding if you want space between the content and the border */
            }

        </style>
    </head>

    <?php $attach = explode(",", $complaint->attachment); ?>


    <body class="A4">
        <!-- <section class="sheet" style="height: auto;"> -->
            <div class="header" style="margin-top:-30px">
                <img src="<?php echo base_url('assets/logo/header-ba.png') ?>" style="width: 100%;height: auto;">
            </div>
            <div class="header-space"></div>


            <div class="row" style="margin-top:50px">
                <div class="col-1"></div>
                <div class="col-10">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5><strong>Dokumentasi Kerusakan</strong></h5>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <?php
                                    foreach ($attach as $key => $value) {    
                                        if($key >= 9 && $key < 27){ ?>

                                            <div class="col-4 text-center" style="border: 1px solid black; padding: 5px">
                                                <img src="<?php echo base_url('uploads/complaints/'.$value) ?>" style="height: 120px;">
                                            </div>
                                            
                                        <?php }
                                    } ?>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
            </div>

            <div class="row">
                <div class="col">
                    <tfoot>
                        <tr>
                            <td>
                                <div class="footer-space">&nbsp;</div>
                            </td>
                        </tr>
                    </tfoot>
                </div>
            </div>

            
            <div class="footer">
                <img src="<?php echo base_url('assets/logo/footer-ba.png') ?>" style="width: 100%;height: auto;">
            </div>

        <!-- </section> -->
    </body>


    <script type="text/javascript">
        window.print();
        // window.close();
    </script>

    </html>
<?php } ?>


<?php if(count($attach) > 27){ ?>
    <html>

    <head>
        <meta charset="utf-8">
        <title>Form Pengajuan Web Complain</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">
        <!-- <link href="<?php echo base_url(); ?>assets/css/paper.css" rel="stylesheet" type="text/css" /> -->
        <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="32x32" type="image/png">
        <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="16x16" type="image/png">
        <!-- Google font-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link rel="stylesheet" href="<?= base_url(); ?>assets/node_modules/bootstrap-icons/font/bootstrap-icons.css">

        <!-- chosen css -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/chosen_v1.8.7/chosen.min.css">

        <!-- date range picker -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/daterangepicker/daterangepicker.css">

        <!-- swiper carousel css -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/swiper-7.3.1/swiper-bundle.min.css">

        <!-- simple lightbox css -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/simplelightbox/simple-lightbox.min.css">

        <!-- app tour css -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/Product-Tour-Plugin-jQuery/lib.css">

        <!-- Data Table Css -->
        <!-- https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.min.css">
        <!-- https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css -->
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/dataTables.bootstrap5.min.css">
        <!-- https://cdn.datatables.net/rowreorder/1.3.1/css/rowReorder.dataTables.min.css -->
        <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.1/css/rowReorder.dataTables.min.css">
        <!-- https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css -->
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
        
        <style type="text/css">
            section {
                /* font-size: 11px; */
                font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            }

            @page {
                size: A4;
                margin: 10mm;
            }

            .header, .header-space {
                height: 160px;
            }
            .footer,  .footer-space {
                height: 80px;
                /* display: flex;
                justify-content: center;
                align-items: center; */
            }

            .header  {
                position: fixed;
                top: 0;
            }
            .footer  {
                position: fixed;
                bottom: 0;
            }

            #data_konsumen tr, th{
                /* font-size: 6pt; */
                padding-left: 3px;
                padding-right: 3px;
            }
            #data_konsumen tr, td{
                /* font-size: 6pt; */
            }
            #data_konsumen td{
                vertical-align: middle; 
                width:10px; 
                white-space: normal;
                padding-left: 3px;
                padding-right: 3px;
            }
            @media print {
                * {margin:0;padding:0}
                @page {size: A4; margin:0mm;}
                html, body {
                    height: 100%;
                    font-family: "Times New Roman" !important;
                }
            }

            th, td, span{
                font-weight: normal !important;
            }
            

            .justify{
                /* display: flex; */
                justify-content: space-evenly;
            }

            .print_complaint {
                width: 100%;
            }

            .print_complaint td {
                padding-left: 5px;
                padding-right: 5px;
                /* padding-top: 1px;
                padding-bottom: 1px; */
                font-size: 9pt;
            }

            .attach_table{
                width: 100%;
            }
            .attach_table tr, 
            .attach_table td{
                padding: 5px;
                border: 1px solid black;
            }

            .attach{
                height : 150px;
                /* justify content: center  */
                text-align: center;
                vertical-align: middle;
            }

            .desc{
                padding-left: 25px !important;
            }

            .border-outside {
                border: 2px solid black; /* Adjust the width and color as needed */
                padding: 10px; /* Optional: add padding if you want space between the content and the border */
            }

        </style>
    </head>

    <?php $attach = explode(",", $complaint->attachment); ?>


    <body class="A4">
        <!-- <section class="sheet" style="height: auto;"> -->
            <div class="header" style="margin-top:-30px">
                <img src="<?php echo base_url('assets/logo/header-ba.png') ?>" style="width: 100%;height: auto;">
            </div>
            <div class="header-space"></div>


            <div class="row" style="margin-top: 50px">
                <div class="col-1"></div>
                <div class="col-10">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5><strong>Dokumentasi Kerusakan</strong></h5>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <?php
                                    foreach ($attach as $key => $value) {    
                                        if($key >= 27){ ?>

                                            <div class="col-4 text-center" style="border: 1px solid black; padding: 5px">
                                                <img src="<?php echo base_url('uploads/complaints/'.$value) ?>" style="height: 120px;">
                                            </div>
                                            
                                        <?php }
                                    } ?>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
            </div>

            <div class="row">
                <div class="col">
                    <tfoot>
                        <tr>
                            <td>
                                <div class="footer-space">&nbsp;</div>
                            </td>
                        </tr>
                    </tfoot>
                </div>
            </div>

            
            <div class="footer">
                <img src="<?php echo base_url('assets/logo/footer-ba.png') ?>" style="width: 100%;height: auto;">
            </div>

        <!-- </section> -->
    </body>


    <script type="text/javascript">
        window.print();
        // window.close();
    </script>

    </html>
<?php } ?>