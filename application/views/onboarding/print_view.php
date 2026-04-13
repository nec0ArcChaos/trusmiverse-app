<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FDK <?= $nama ?></title>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/fontawesome/css/all.min.css" />
    <link rel="apple-touch-icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="180x180">
    <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="32x32" type="image/png">
    <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="16x16" type="image/png">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.min.css">
</head>

<body>
    <header class="py-4">
        <div style="width: 100%;">
            <center>
                <div style="margin-left: 26px; display: flex; justify-content: center;" align="center">
                    <img src="<?= base_url(); ?>assets/img/logo_trusmiverse.png" alt="Gambar" width="50">
                    &nbsp;
                    &nbsp;
                    <h4 class="header-logo">Formulir Dokumen Karyawan</h4>
                </div>
            </center>
        </div>
    </header>
    <main>
        <section class="content">
            <div class="meeting-info">
                <table width="100%" class="table table-borderless" border="0" cellpadding="4px">
                    <tr align="center">
                        <td width="33%">
                            <div class="info-label">Submitted at:</div>
                        </td>
                        <td width="1%" rowspan="2">
                            <div style="background-color: #9E9E9E; height: 50px; border-radius: 7px; width: 2px;">&nbsp;</div>
                        </td>
                        <td width="33%">
                            <div class="info-label">Printed at : </div>
                        </td>
                        <td width="1%" rowspan="2">
                            <div style="background-color: #9E9E9E; height: 50px; border-radius: 7px; width: 2px;">&nbsp;</div>
                        </td>
                        <td width="33%">
                            <div class="info-label">Status : </div>
                        </td>
                    </tr>
                    <tr align="center">
                        <td class="info-data text-primary font-weight-bold">
                            <?= $created_at ?>
                        </td>
                        <td class="info-data text-primary font-weight-bold">
                            <?= date('Y-m-d H:i:s') ?>
                        </td>
                        <td class="info-data text-primary font-weight-bold">
                            <?= $fdk_status ?>
                        </td>
                    </tr>
                </table>
            </div>
        </section>

        <section class="content">
            <div class="meeting-info">
                <table width="100%" border="0" cellpadding="4px">
                    <tr align="center">
                        <td colspan="3">
                            <h6 class="info-label text-uppercase">Data Karyawan</h6>
                            <h6><?= $nama ?> | <?= $designation_name ?> | <?= $company ?></h6>
                        </td>
                    </tr>
                    <!-- <tr align="center">
                        <td colspan="3">
                            <div style="background-color: #9E9E9E; height: 2px; width: 90%; border-radius: 7px;">&nbsp;</div>
                            
                        </td>
                    </tr> -->

                </table>
            </div>
        </section>
        <section class="content">
            <div>
                <table class="table table-bordered">
                    <tr align="center" style="background-color: aliceblue">
                        <td colspan="1" width="50%">
                            <h6 class="info-label text-uppercase">KTP</h6>
                            <small class="text-secondary">Approved By : <?= $ap_ktp ?> | Approved At : <?= $ktp_approve_at ?></small>
                        </td>
                        <td colspan="1">
                            <h6 class="info-label text-uppercase">KK</h6>
                            <small class="text-secondary">Approved By : <?= $ap_kk ?> | Approved At : <?= $kk_approve_at ?></small>
                        </td>
                    </tr>
                    <tr align="center">
                        <td colspan="1" width="50%">
                            <?php if ($ktp != null) : ?>
                                <img src="https://trusmiverse.com/apps/uploads/fdk/<?= $ktp ?>" alt="" style="max-width: 100%;">
                            <?php else : ?>
                                <small class="text-secondary"> Tidak ada foto</small>
                            <?php endif; ?>
                        </td>
                        <td colspan="1">
                            <?php if ($kk != null) : ?>
                                <img src="https://trusmiverse.com/apps/uploads/fdk/<?= $kk ?>" alt="" style="max-width: 100%;">
                            <?php else : ?>
                                <small class="text-secondary"> Tidak ada foto</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </section>
        <section class="content">
            <div>
                <table class="table table-bordered">
                    <tr align="center" style="background-color: aliceblue">
                        <td colspan="1" width="50%">
                            <h6 class="info-label text-uppercase">Surat Lamaran</h6>
                            <small class="text-secondary">Approved By : <?= $ap_lamaran ?> | Approved At : <?= $lamaran_approve_at ?></small>
                        </td>
                        <td colspan="1">
                            <h6 class="info-label text-uppercase">CV</h6>
                            <small class="text-secondary">Approved By : <?= $ap_cv ?> | Approved At : <?= $cv_approve_at ?></small>
                        </td>
                    </tr>
                    <tr align="center">
                        <td colspan="1" width="50%">
                            <?php if ($lamaran != null) : ?>
                                <img src="https://trusmiverse.com/apps/uploads/fdk/<?= $lamaran ?>" alt="" style="max-width: 100%;">
                            <?php else : ?>
                                <small class="text-secondary"> Tidak ada foto</small>
                            <?php endif; ?>
                        </td>
                        <td colspan="1">
                            <?php if ($cv != null) : ?>
                                <img src="https://trusmiverse.com/apps/uploads/fdk/<?= $cv ?>" alt="" style="max-width: 100%;">
                            <?php else : ?>
                                <small class="text-secondary"> Tidak ada foto</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </section>
        <section class="content">
            <div>
                <table class="table table-bordered">
                    <tr align="center" style="background-color: aliceblue">
                        <td colspan="1" width="50%">
                            <h6 class="info-label text-uppercase">Ijazah</h6>
                            <small class="text-secondary">Approved By : <?= $ap_ijazah ?> | Approved At : <?= $ijazah_approve_at ?></small>
                        </td>
                        <td colspan="1">
                            <h6 class="info-label text-uppercase">Transkip</h6>
                            <small class="text-secondary">Approved By : <?= $ap_transkip ?> | Approved At : <?= $transkip_approve_at ?></small>
                        </td>
                    </tr>
                    <tr align="center">
                        <td colspan="1" width="50%">
                        <?php if ($ijazah != null) : ?>
                                <img src="https://trusmiverse.com/apps/uploads/fdk/<?= $ijazah ?>" alt="" style="max-width: 100%;">
                            <?php else : ?>
                                <small class="text-secondary"> Tidak ada foto</small>
                            <?php endif; ?>
                        </td>
                        <td colspan="1">
                        <?php if ($transkip != null) : ?>
                                <img src="https://trusmiverse.com/apps/uploads/fdk/<?= $transkip ?>" alt="" style="max-width: 100%;">
                            <?php else : ?>
                                <small class="text-secondary"> Tidak ada foto</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </section>
        <section class="content">
            <div>
                <table class="table table-bordered">
                    <tr align="center" style="background-color: aliceblue">
                        <td colspan="1" width="50%">
                            <h6 class="info-label text-uppercase">NPWP</h6>
                            <small class="text-secondary">Approved By : <?= $ap_npwp ?> | Approved At : <?= $npwp_approve_at ?></small>
                        </td>
                        <td colspan="1">
                            <h6 class="info-label text-uppercase">Surat Lulus</h6>
                            <small class="text-secondary">Approved By : <?= $ap_surat_lulus ?> | Approved At : <?= $surat_lulus_approve_at ?></small>
                        </td>
                    </tr>
                    <tr align="center">
                        <td colspan="1" width="50%">
                        <?php if ($npwp != null) : ?>
                                <img src="https://trusmiverse.com/apps/uploads/fdk/<?= $npwp ?>" alt="" style="max-width: 100%;">
                            <?php else : ?>
                                <small class="text-secondary"> Tidak ada foto</small>
                            <?php endif; ?>
                        </td>
                        <td colspan="1">
                        <?php if ($surat_lulus != null) : ?>
                                <img src="https://trusmiverse.com/apps/uploads/fdk/<?= $surat_lulus ?>" alt="" style="max-width: 100%;">
                            <?php else : ?>
                                <small class="text-secondary"> Tidak ada foto</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </section>
        <section class="content">
            <div>
                <table class="table table-bordered">
                    <tr align="center" style="background-color: aliceblue">
                        <td colspan="1" width="50%">
                            <h6 class="info-label text-uppercase">Paklaring</h6>
                            <small class="text-secondary">Approved By : <?= $ap_verklaring ?> | Approved At : <?= $verklaring_approve_at ?></small>
                        </td>
                        <td colspan="1">
                            <h6 class="info-label text-uppercase">Sertifikat</h6>
                            <small class="text-secondary">Approved By : <?= $ap_sertifikat ?> | Approved At : <?= $sertifikat_approve_at ?></small>
                        </td>
                    </tr>
                    <tr align="center">
                        <td colspan="1" width="50%">
                        <?php if ($verklaring != null) : ?>
                                <img src="https://trusmiverse.com/apps/uploads/fdk/<?= $verklaring ?>" alt="" style="max-width: 100%;">
                            <?php else : ?>
                                <small class="text-secondary"> Tidak ada foto</small>
                            <?php endif; ?>
                        </td>
                        <td colspan="1">
                        <?php if ($sertifikat != null) : ?>
                                <img src="https://trusmiverse.com/apps/uploads/fdk/<?= $sertifikat ?>" alt="" style="max-width: 100%;">
                            <?php else : ?>
                                <small class="text-secondary"> Tidak ada foto</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </section>
        <section class="content">
            <div>
                <table class="table table-bordered">
                    <tr align="center" style="background-color: aliceblue">
                        <td colspan="1" width="50%">
                            <h6 class="info-label text-uppercase">Dokumen Lain</h6>
                            <small class="text-secondary">Approved By : <?= $ap_dokumen_lain ?> | Approved At : <?= $dokumen_lain_approve_at ?></small>
                        </td>
                        <!-- <td colspan="1">
                            <h6 class="info-label text-uppercase">Dokumen Lain</h6>
                            <small class="text-secondary">Approved By : <?= $ap_sertifikat ?> | Approved At : <?= $sertifikat_approve_at ?></small>
                        </td> -->
                    </tr>
                    <tr align="center">
                        <td colspan="1" width="50%">
                        <?php if ($dokumen_lain != null) : ?>
                                <img src="https://trusmiverse.com/apps/uploads/fdk/<?= $dokumen_lain ?>" alt="" style="max-width: 100%;">
                            <?php else : ?>
                                <small class="text-secondary"> Tidak ada foto</small>
                            <?php endif; ?>
                        </td>
                        <!-- <td colspan="1">
                            <img src="https://trusmiverse.com/apps/uploads/fdk/req/17191934476.jpg" alt="" style="max-width: 100%;">
                        </td> -->
                    </tr>
                </table>
            </div>
        </section>

        <!-- <section class="content" style="padding-left: 0px; padding-right: 0px;">
            <div class="meeting-info">

                <table width="100%" class="table table-striped" style="margin-top: 8px;">
                    <tr align="center">
                        <th colspan="5" style="background-color: #337ab7; color: #fff;"><span class="info-label">Feedback Apps IBR Pro</span></th>
                    </tr>
                    <tr>
                        <td colspan="2"><span class="info-label">ACTION</span></td>
                        <td width="15%" align="center"><span class="info-label">KATEGORISASI</span></td>
                        <td width="15%" align="center"><span class="info-label">DEADLINE</span></td>
                        <td width="15%" align="center"><span class="info-label">PIC</span></td>
                    </tr>
                    <tr>
                        <td><span class="info-data">1</span></td>
                        <td><span class="info-data">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span></td>
                        <td align="center"><span class="info-data"><span class="label label-warning">Tasklist</span></span></td>
                        <td align="center"><span class="info-data">23 Dec 2023</span></td>
                        <td align="center"><span class="info-data">Aris, Fuji, Faisal</span></td>
                    </tr>
                    <tr>
                        <td><span class="info-data">2</span></td>
                        <td><span class="info-data">Tampilkan Target vs Actual di dashboard</span></td>
                        <td align="center"><span class="info-data"><span class="label label-primary">Statement</span></span></td>
                        <td align="center"><span class="info-data">Selesaikan segera</span></td>
                        <td align="center"><span class="info-data">Aris, Fuji, Faisal</span></td>
                    </tr>
                </table>
            </div>
        </section> -->
    </main>
    <script src="<?= base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/bootstrap-5/dist/js/bootstrap.bundle.js"></script>
</body>

</html>