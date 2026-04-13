<?php
$this->load->view('template/format_bulan');
$this->load->view('template/romawi');
$this->load->view('template/terbilang');
$this->load->view('template/hari_indo');

$tahun = substr(date('Y-m-d'), 0, 4);
$bulan = substr(date('Y-m-d'), 5, 2);
$tanggal = substr(date('Y-m-d'), 8, 2);

$tahun_input    = substr(date($eaf['tgl_input']), 0, 4);
$bulan_input    = substr(date($eaf['tgl_input']), 5, 2);
$tanggal_input  = substr(date($eaf['tgl_input']), 8, 2);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Print BA EAF</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">
    <link href="<?php echo base_url(); ?>assets/css/paper.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon" />
    <!-- Google font-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/fonts/font-google.css">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/bower_components/bootstrap/css/bootstrap.min.css">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/icon/themify-icons/themify-icons.css">
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery.mCustomScrollbar.css">
    <!-- line icon css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/icon/simple-line-icons/css/simple-line-icons.css">

    <style type="text/css">
        section {
            /* font-size: 11px; */
            font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        @page {
            size: A4;
            margin: 10mm;
        }

        .header,
        .header-space {
            height: 160px;
        }

        .footer,
        .footer-space {
            height: 100px;
            /* display: flex;
            justify-content: center;
            align-items: center; */
        }

        .header {
            position: fixed;
            top: 0;
        }

        .footer {
            position: fixed;
            bottom: 0;
        }

        #data_konsumen tr,
        th {
            /* font-size: 6pt; */
            padding-left: 3px;
            padding-right: 3px;
        }

        #data_konsumen tr,
        td {
            /* font-size: 6pt; */
        }

        #data_konsumen td {
            vertical-align: middle;
            width: 10px;
            white-space: normal;
            padding-left: 3px;
            padding-right: 3px;
        }

        @media print {
            * {
                margin: 0;
                padding: 0
            }

            @page {
                size: A4;
                margin: 0mm;
            }

            html,
            body {
                height: 100%;
                font-family: "Times New Roman" !important;
            }
        }

        th,
        td,
        span {
            font-weight: normal !important;
        }

        #contain {
            padding-left: 1.5cm;
            padding-right: 1cm;
        }

        .justify {
            /* display: flex; */
            justify-content: space-evenly;
        }
    </style>
</head>

<body class="A4">
    <!-- <section class="sheet" style="height: auto;"> -->
    <div class="header" style="margin-top:-30px">
        <img src="<?php echo base_url('assets/uploads/header-ba.png') ?>" style="width: 100%;height: auto;">
    </div>
    <div class="header-space"></div>

    <div id="contain">

        <hr>
        <hr>
        <div class="row">
            <div class="col text-center">
                <h5><u><strong>BERITA ACARA<strong></u></h5>
            </div>
        </div>

        <hr>
        <div class="row" style="">
            <div class="col">
                <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saya yang bernama <?= $eaf['nama_penerima'] ?></span>
                <span>selaku karyawan Trusmi Group telah menggunakan uang kantor tanpa bukti pengeluaran sebesar Rp. <?= number_format($eaf['nominal_lpj'], 0, '.', '.') ?> untuk biaya <?= $eaf['nama_lpj'] ?> keterangan <?= $eaf['note'] ?> pada tanggal <?= $tanggal_input ?> <?= formatBulan($bulan_input) ?> <?= $tahun_input ?>.</span>
            </div>
        </div>
        <div class="row" style="margin-top: 20px;">
            <div class="col">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Demikian berita acara ini dibuat agar dapat dipergunakan sebagaimana mestinya.</span>
            </div>
        </div>

        <hr>

        <div class="row" style="margin-top: 50px; margin-left:20px; margin-right:20px;">
            <div class="col text-center">
                <table>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="col text-center">
                <table>
                    <tbody>
                        <tr>
                            <td colspan="4">&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align: center">Diketahui oleh,</td>
                        </tr>
                        <tr height="50">
                            <td></td>
                        </tr>
                        <tr>
                            <?php if ($eaf['employee_name'] == '') {
                                $user = '<span>&nbsp;</span>';
                            } else {
                                $user = '<u>' . $eaf['employee_name'] . '</u>';
                            } ?>
                            <th style="text-align: center"><?= substr($user, 0, 20) ?></th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col text-center">
                <table>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="col text-center">
                <table>
                    <tbody>
                        <tr>
                            <td>Cirebon, <?= $tanggal_input ?> <?= formatBulan($bulan_input) ?> <?= $tahun_input ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: center">Pemohon,</td>
                        </tr>
                        <tr height="50">
                            <td></td>
                        </tr>
                        <tr>
                            <?php if ($eaf['nama_penerima'] == '') {
                                $finance_by = '<span>&nbsp;</span>';
                            } else {
                                $finance_by = '<u>' . $eaf['nama_penerima'] . '</u>';
                            } ?>
                            <th style="text-align: center"><?= substr($finance_by, 0, 20) ?></th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col text-center">
                <table>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

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
        <img src="<?php echo base_url('assets/uploads/footer-ba.png') ?>" style="width: 100%;height: auto;">
    </div>

    <!-- </section> -->
</body>
<script type="text/javascript">
    window.print();
    window.close();
</script>

</html>