<?php
$this->load->view('library/format_bulan');
$this->load->view('library/romawi');
$this->load->view('library/terbilang');
$this->load->view('library/hari_indo');

// $tahun = substr($data['created_at'], 0, 4);
// $bulan = substr($data['created_at'], 5, 2);
// $tanggal = substr($data['created_at'], 8, 2);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Print Paklaring</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">

    <link rel="apple-touch-icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="180x180">
    <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="32x32" type="image/png">
    <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="16x16" type="image/png">

    <!-- style css for this template -->
    <link href="<?= base_url(); ?>assets/scss/style.css" rel="stylesheet">

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
            }

            body {
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

        table {
            page-break-inside: auto
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto
        }

        .underline_text {
            border-bottom: solid 2px #000000;
            display: inline;
            padding-bottom: 2px;
            margin-bottom: 2px;
        }

        p {
            font-weight: 400;
            text-align: justify;
        }
    </style>
</head>

<body class="A4">
    <!-- <section class="sheet" style="height: auto;"> -->
    <div class="header" style="margin-top:-30px">
                 <div style="width:100%; height:180px; overflow:hidden; position:relative;">
                         <img src="<?= $data->header_memo ?>" 
                  style="width: 100%; height: auto; display: block;" 
                  alt="Header Memo">
         </div>
     </div>
    <div class="header-space"></div>

    <div id="contain" style="font-family:'Times New Roman' !important;">
        <div class="row">
            <div class="col text-center" style="margin: 20px 0;">
                <h5 class="underline_text" style="font-family:'Times New Roman' !important;"><strong><?= isset($title_letter) ? $title_letter : ""; ?><strong></h5>
                <h5 class="small" style="margin-top: 10px;font-family:'Times New Roman' !important;">Nomor : <?= $no_surat ?></h5>
            </div>

            <div class="col" style="text-align: justify;">
                <p style="margin-top: 20px;margin-bottom: 20px;">Yang bertanda tangan dibawah ini :</p>
                <table style="margin-top: 20px;margin-bottom: 20px;width: 100%;">
                    <tbody>
                        <tr>
                            <td style="width: 20%;">Nama</td>
                            <td style="width: 10px;">:</td>
                            <td>Fafricony Ristiara Devi</td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td>Compensation & Benefit Supervisor</td>
                        </tr>
                    </tbody>
                </table>
                <p style="margin-top: 20px;margin-bottom: 20px;">Menerangkan dengan sesungguhnya bahwa yang bersangkutan di bawah ini :</p>
                <table style="margin-top: 20px;margin-bottom: 20px;width: 100%;">
                    <tbody>
                        <tr>
                            <td style="width: 20%;">Nama</td>
                            <td style="width: 10px;">:</td>
                            <td><?= $data->employee_name ?? ''; ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td><?= $data->address ?? ''; ?></td>
                        </tr>
                        <tr>
                            <td>Jabatan Terakhir</td>
                            <td>:</td>
                            <td><?= $data->designation_name ?? ''; ?></td>
                        </tr>
                        <tr>
                            <td>Masa Kerja</td>
                            <td>:</td>
                            <td><?= date("d M Y", strtotime($data->date_of_joining)) ?? ''; ?> – <?= date("d M Y", strtotime($data->resignation_date)) ?? ''; ?></td>
                        </tr>
                    </tbody>
                </table>
                <?php if ($data->diff_date ?? 1 >= 30 || $data->reason == "Habis Kontrak") { ?>
                    <p style="margin-top: 20px;margin-bottom: 10px;">
                        Benar telah bekerja pada perusahaan yang kami pimpin dan selama menjadi karyawan kami, Sdr/i. <b><?= $data->employee_name ?? ''; ?></b> telah menunjukan dedikasi dan loyalitas yang tinggi terhadap perusahaan.</p>
                    <p style="margin-top: 10px;margin-bottom: 10px;">Kami berterimakasih dan berharap semoga yang bersangkutan dapat lebih sukses di masa yang akan datang.</p>
                    <p style="margin-top: 10px;margin-bottom: 10px;">Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
                <?php } else { ?>
                    <p style="margin-top: 20px;margin-bottom: 10px;">
                        Benar telah bekerja pada perusahaan yang kami pimpin dan selama menjadi karyawan kami, Sdr/i. <b><?= $data->employee_name ?? ''; ?></b> mengundurkan diri tidak sesuai dengan peraturan perusahaan yang berlaku.
                    </p>
                    <p style="margin-top: 10px;margin-bottom: 10px;">Kami berterimakasih dan berharap semoga yang bersangkutan dapat lebih sukses di masa yang akan datang.</p>
                    <p style="margin-top: 10px;margin-bottom: 10px;">Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
                <?php } ?>

                <table style="margin-top: 20px;margin-bottom: 20px;">
                    <tbody>
                        <tr>
                            <td>Cirebon, <?= date("d M Y"); ?></td>
                        </tr>
                        <tr>
                            <td><b>Dibuat oleh,</b></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><b class="underline_text">Fafricony Ristiara Devi</b></td>
                        </tr>
                        <tr>
                            <td>Compensation & Benefit Supervisor</td>
                        </tr>
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


    <!-- <div class="footer">
        <img src="<?php echo base_url('assets/print/footer-ba.png') ?>" style="width: 100%;height: auto;">
    </div> -->

    <!-- </section> -->
</body>
<script type="text/javascript">
    window.print();
    // window.close();
</script>

</html>