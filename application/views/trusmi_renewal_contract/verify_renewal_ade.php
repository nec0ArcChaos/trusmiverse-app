<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Deskripsi Page</p>
            </div>
            <div class="col col-sm-auto">
            </div>
            <div class="col-auto ps-0">

            </div>
        </div>
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <style>
        .star {
            /* font-size: 24px; */
            cursor: pointer;
            /* color: gray; /* Default warna bintang */
        }
        
        .star.selected {
            color: gold; /* Warna bintang ketika dipilih */
        }
    </style>

    <?php if (isset($_GET['id'])) { ?>
        <div class="m-3">
            <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
                <div class="card border-0">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-auto">
                                <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                            </div>
                            <div class="col-auto align-self-center">
                                <h6 class="fw-medium mb-0">Feedback Renewal Contract</h6>
                            </div>
                            <div class="col-auto ms-auto ps-0">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="form_renewal">
                            <input type="hidden" name="id" value="<?= $data['id'] ?>">
                            <input type="hidden" id="approval" value="<?= $_SESSION['nama'] ?>">
                            <input type="hidden" id="no_hp" value="<?= $data['no_hp'] ?>">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12">

                                    <div class="card">
                                        <div class="card-body">

                                            <div class="row align-items-center mb-3">
                                                <div class="col-auto">
                                                    <i class="bi bi-person h5 text-theme mb-0"></i>
                                                </div>
                                                <div class="col">
                                                    <p class="text-secondary small mb-1">Nama</p>
                                                    <p id="nama_karyawan"><?= $data['nama'] ?></p>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-3">
                                                <div class="col-auto">
                                                    <i class="bi bi-diagram-3 h5 text-theme mb-0"></i>
                                                </div>
                                                <div class="col">
                                                    <p class="text-secondary small mb-1">Jabatan</p>
                                                    <p id="jabatan"><?= $data['jabatan'] ?></p>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-3">
                                                <div class="col-auto">
                                                    <i class="bi bi-building h5 text-theme mb-0"></i>
                                                </div>
                                                <div class="col">
                                                    <p class="text-secondary small mb-1">Depatemen</p>
                                                    <p id="departemen"><?= $data['departemen'] ?></p>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-3">
                                                <div class="col-auto">
                                                    <i class="bi bi-buildings h5 text-theme mb-0"></i>
                                                </div>
                                                <div class="col">
                                                    <p class="text-secondary small mb-1">Perusahaan</p>
                                                    <p id="company"><?= $data['company'] ?></p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row align-items-center mb-3">
                                                <div class="col-auto">
                                                    <i class="bi bi-calendar-range h5 text-theme mb-0"></i>
                                                </div>
                                                <div class="col">
                                                    <p class="text-secondary small mb-1">Masa Kerja</p>
                                                    <?php $masa_kerja = explode(".", $data['masa_kerja']); ?>
                                                    <p><?= (count($masa_kerja) > 1 ? $masa_kerja[0] . " Tahun " . $masa_kerja[1] . " Bulan" : $masa_kerja[1] . " Bulan"); ?></p>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-3">
                                                <div class="col-auto">
                                                    <i class="bi bi-calendar-x h5 text-theme mb-0"></i>
                                                </div>
                                                <div class="col">
                                                    <p class="text-secondary small mb-1">Kontrak Berakhir</p>
                                                    <p id="habis_kontrak"><?= $data['habis_kontrak'] ?></p>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-3">
                                                <div class="col-auto">
                                                    <i class="bi bi-hourglass-split h5 text-theme mb-0"></i>
                                                </div>
                                                <div class="col">
                                                    <p class="text-secondary small mb-1">Sisa Kontrak</p>
                                                    <p><?= $data['sisa_kontrak'] ?> Hari</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 text-right">

                                    <!-- addnew -->
                                    <div class="row">
                                        <?php if ($data['company_id'] == 2) { // Jika company RSP tampilkan Form Penilaian Subjektif Renewal ?>
                                        <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                                            <div class="form-floating">
                                                                <select name="masih_sesuai" class="form-select border-0" id="masih_sesuai" <?= $data['masih_sesuai'] == '' ? '' : 'disabled'; ?>>
                                                                    <option value="#" selected>- Pilih -</option>
                                                                    <option value="1" <?= ($data['masih_sesuai'] == 1) ? 'selected' : ''; ?>>Ya</option>
                                                                    <option value="2" <?= ($data['masih_sesuai'] == 2) ? 'selected' : ''; ?>>Tidak</option>
                                                                </select>
                                                                <label for="status">Posisi masih sesuai dengan kebutuhan strategi perusahaan?</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if ($data['file_kpi'] == '') { ?>
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0" id="i_feedback"><i class="bi bi-card-checklist"></i></span>
                                                            <div class="form-floating">
                                                                <input type="file" name="file_kpi" id="file_kpi" class="form-control m-2">
                                                                <label id="feedback_label">Performa Kerja Karyawan (KPI)</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } else { ?>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                                <!-- <i class="bi bi-hourglass-split h5 text-theme mb-0"></i> -->
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">Performa Kerja Karyawan (KPI)</p>
                                                                <a href="<?= base_url('uploads/trusmi_renewal/'.$data['file_kpi']); ?>">
                                                                    <p><i class="bi bi-download h5 text-theme mb-0"></i> &nbsp;Download File KPI</p>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <!-- <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar2-check"></i></span>
                                                            <div class="form-floating">
                                                                <label for="lama_kontrak">Karakteristik Sikap Proaktif</label>
                                                            </div>
                                                        </div>
                                                    </div> -->

                                                    <!-- Rating -->

                                                    <div class="div_penilaian"></div>
                                                    <?php if ($dt_penilaian_subjektif == null) { ?>
                                                        <!-- Proaktif -->
                                                        <div class="row align-items-centerx mb-3">
                                                            <div class="col-auto">
                                                                <div style="margin-left:10px;">
                                                                    <p class="pl-3">Karakteristik Sikap Proaktif</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                                <!-- <i class="bi bi-calendar-range h5 text-theme mb-0"></i>
                                                                <span>a</span> -->
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">a. Memiliki kemauan untuk terus belajar</p>
                                                                <input type="hidden" name="rating_proaktif_belajar" value="<?= $dt_penilaian_subjektif['proaktif_belajar'] ?>">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi bi-star h6 text-yellow star group_star_1" data-index="<?= $i ?>"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">b. Melakukan evaluasi dari setiap yang sudah dilakukan</p>
                                                                <input type="hidden" name="rating_proaktif_evaluasi" value="0">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi bi-star h6 text-yellow star group_star_2" data-index="<?= $i ?>"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">c. Mampu beradaptasi dengan budaya perusahaan dan menunjukan performa kerja yang baik</p>
                                                                <input type="hidden" name="rating_proaktif_adaptasi" value="0">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi bi-star h6 text-yellow star group_star_3" data-index="<?= $i ?>"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <!-- End proaktif -->

                                                        <!-- Pembelajar -->
                                                        <div class="row mb-3 mt-3">
                                                            <div class="col-auto">
                                                                <div style="margin-left:10px;">
                                                                    <p class="pl-3">Karakteristik Sikap Pembelajar</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">a. Berani untuk mengambil suatu keputusan/tanggung jawab
                                                                </p>
                                                                <input type="hidden" name="rating_pembelajar_berani" value="0">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi bi-star h6 text-yellow star g_star_pembelajar_a" data-index="<?= $i ?>"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">b. Berjuang untuk menyelesaikan pekerjaan
                                                                </p>
                                                                <input type="hidden" name="rating_pembelajar_berjuang" value="0">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi bi-star h6 text-yellow star g_star_pembelajar_b" data-index="<?= $i ?>"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">c. Melakukan suatu hal baik tanpa perlu diminta
                                                                </p>
                                                                <input type="hidden" name="rating_pembelajar_melakukan" value="0">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi bi-star h6 text-yellow star g_star_pembelajar_c" data-index="<?= $i ?>"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <!-- End pembelajar -->

                                                        <!-- Energi positif -->
                                                        <div class="row mb-3 mt-3">
                                                            <div class="col-auto">
                                                                <div style="margin-left:10px;">
                                                                    <p class="pl-3">Karakteristik Sikap Penebar Energi Positif</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">a. membangun iklim kerja yang harmonis
                                                                </p>
                                                                <input type="hidden" name="rating_energi_harmonis" value="0">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi bi-star h6 text-yellow star g_star_energi_a" data-index="<?= $i ?>"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">b. Memberikan motivasi kepada rekan kerja
                                                                </p>
                                                                <input type="hidden" name="rating_energi_motivasi" value="0">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi bi-star h6 text-yellow star g_star_energi_b" data-index="<?= $i ?>"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">c. Berusaha menjadi tauladan bagi karyawan lain
                                                                </p>
                                                                <input type="hidden" name="rating_energi_tauladan" value="0">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi bi-star h6 text-yellow star g_star_energi_c" data-index="<?= $i ?>"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <!-- End energi positif -->

                                                        <!-- Penilaian user -->
                                                        <div class="row mb-3 mt-3">
                                                            <div class="col-auto">
                                                                <div style="margin-left:10px;">
                                                                    <p class="pl-3">Score Penilaian User (Internal)</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">a. Sikap Percepatan
                                                                </p>
                                                                <input type="hidden" name="rating_internal_percepatan" value="0">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi bi-star h6 text-yellow star g_star_internal_a" data-index="<?= $i ?>"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">b. Sikap Disiplin
                                                                </p>
                                                                <input type="hidden" name="rating_internal_disiplin" value="0">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi bi-star h6 text-yellow star g_star_internal_b" data-index="<?= $i ?>"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End penilaian user -->

                                                    <?php } else { ?>
                                                            <!-- Proaktif -->
                                                            <div class="row align-items-centerx mb-3">
                                                            <div class="col-auto">
                                                                <div style="margin-left:10px;">
                                                                    <p class="pl-3">Karakteristik Sikap Proaktif</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">a. Memiliki kemauan untuk terus belajarxx</p>
                                                                <input type="hidden" name="rating_proaktif_belajar" value="<?= $dt_penilaian_subjektif['proaktif_belajar'] ?>">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi <?= ($dt_penilaian_subjektif['proaktif_belajar'] >= $i) ? 'bi-star-fill' : 'bi-star'; ?> h6 text-yellow star"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">b. Melakukan evaluasi dari setiap yang sudah dilakukan</p>
                                                                <input type="hidden" name="rating_proaktif_evaluasi" value="0">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi <?= ($dt_penilaian_subjektif['proaktif_evaluasi'] >= $i) ? 'bi-star-fill' : 'bi-star'; ?> h6 text-yellow star"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">c. Mampu beradaptasi dengan budaya perusahaan dan menunjukan performa kerja yang baik</p>
                                                                <input type="hidden" name="rating_proaktif_adaptasi" value="0">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi <?= ($dt_penilaian_subjektif['proaktif_adaptasi'] >= $i) ? 'bi-star-fill' : 'bi-star'; ?> h6 text-yellow star"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <!-- End proaktif -->

                                                        <!-- Pembelajar -->
                                                        <div class="row mb-3 mt-3">
                                                            <div class="col-auto">
                                                                <div style="margin-left:10px;">
                                                                    <p class="pl-3">Karakteristik Sikap Pembelajar</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">a. Berani untuk mengambil suatu keputusan/tanggung jawab
                                                                </p>
                                                                <input type="hidden" name="rating_pembelajar_berani" value="0">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi <?= ($dt_penilaian_subjektif['pembelajar_berani'] >= $i) ? 'bi-star-fill' : 'bi-star'; ?> h6 text-yellow star"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">b. Berjuang untuk menyelesaikan pekerjaan
                                                                </p>
                                                                <input type="hidden" name="rating_pembelajar_berjuang" value="0">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi <?= ($dt_penilaian_subjektif['pembelajar_berjuang'] >= $i) ? 'bi-star-fill' : 'bi-star'; ?> h6 text-yellow star"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">c. Melakukan suatu hal baik tanpa perlu diminta
                                                                </p>
                                                                <input type="hidden" name="rating_pembelajar_melakukan" value="0">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi <?= ($dt_penilaian_subjektif['pembelajar_melakukan'] >= $i) ? 'bi-star-fill' : 'bi-star'; ?> h6 text-yellow star"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <!-- End pembelajar -->

                                                        <!-- Energi positif -->
                                                        <div class="row mb-3 mt-3">
                                                            <div class="col-auto">
                                                                <div style="margin-left:10px;">
                                                                    <p class="pl-3">Karakteristik Sikap Penebar Energi Positif</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">a. membangun iklim kerja yang harmonis
                                                                </p>
                                                                <input type="hidden" name="rating_energi_harmonis" value="0">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi <?= ($dt_penilaian_subjektif['energi_harmonis'] >= $i) ? 'bi-star-fill' : 'bi-star'; ?> h6 text-yellow star"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">b. Memberikan motivasi kepada rekan kerja
                                                                </p>
                                                                <input type="hidden" name="rating_energi_motivasi" value="0">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi <?= ($dt_penilaian_subjektif['energi_motivasi'] >= $i) ? 'bi-star-fill' : 'bi-star'; ?> h6 text-yellow star"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">c. Berusaha menjadi tauladan bagi karyawan lain
                                                        
                                                                </p>
                                                                <input type="hidden" name="rating_energi_tauladan" value="0">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi <?= ($dt_penilaian_subjektif['energi_tauladan'] >= $i) ? 'bi-star-fill' : 'bi-star'; ?> h6 text-yellow star"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <!-- End energi positif -->

                                                        <!-- Penilaian user -->
                                                        <div class="row mb-3 mt-3">
                                                            <div class="col-auto">
                                                                <div style="margin-left:10px;">
                                                                    <p class="pl-3">Score Penilaian User (Internal)</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">a. Sikap Percepatan
                                                                </p>
                                                                <input type="hidden" name="rating_internal_percepatan" value="0">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi <?= ($dt_penilaian_subjektif['internal_percepatan'] >= $i) ? 'bi-star-fill' : 'bi-star'; ?> h6 text-yellow star"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-3">
                                                            <div class="col-auto">
                                                            </div>
                                                            <div class="col">
                                                                <p class="text-secondary small mb-1">b. Sikap Disiplin
                                                                </p>
                                                                <input type="hidden" name="rating_internal_disiplin" value="0">
                                                                <div class="row mt-2" style="padding-left:30px;">
                                                                    <?php for ($i=1; $i <= 5 ; $i++) { ?>
                                                                        <div class="col-auto text-center" style="padding-right:50px;">
                                                                            <span><?= $i ?></span><br>
                                                                            <i class="bi <?= ($dt_penilaian_subjektif['internal_disiplin'] >= $i) ? 'bi-star-fill' : 'bi-star'; ?> h6 text-yellow star"></i>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End penilaian user -->
                                                    <?php } ?>
                    
                                                     <!-- end Rating -->
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="col-lg-12 col-md-12 col-sm-12 text-right <?= ($data['company_id'] == 2) ? 'mt-2' : '' ?>">
                                            <div class="card">
                                                <div class="card-body">
                                                    <input type="hidden" name="company_id" value="<?= $data['company_id'] ?>">
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-pencil-square"></i></span>
                                                            <div class="form-floating">
                                                                <select name="status" class="form-select border-0" id="status" onchange="pilih_status()" <?= $data['status'] != '' ? 'disabled' : ''; ?>>
                                                                    <?php if ($data['status'] == "1") {
                                                                        $selected_1 = "selected";
                                                                        $selected_2 = "";
                                                                    } else if ($data['status'] == "2") {
                                                                        $selected_1 = "";
                                                                        $selected_2 = "selected";
                                                                    } else {
                                                                        $selected_1 = "";
                                                                        $selected_2 = "";
                                                                    } ?>
                                                                    <option value="1" <?= $selected_1 ?>>Perpanjang Kontrak</option>
                                                                    <option value="2" <?= $selected_2 ?>>Tidak Perpanjang</option>
                                                                </select>
                                                                <label for="status">Status</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3 position-relative check-valid">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0" id="i_feedback"><i class="bi bi-card-checklist"></i></span>
                                                            <div class="form-floating">
                                                                <textarea name="feedback" id="feedback" cols="1" rows="4" style="height:90px" class="form-control border-start-0" oninput="input_feedback()" <?= $data['status'] != '' ? 'readonly' : ''; ?>><?= $data['status'] != '' ? $data['feedback'] : ''; ?></textarea>
                                                                <label id="feedback_label">Feedback Pekerjaan</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3 position-relative check-valid" id="input_lama_kontrak">
                                                        <div class="input-group input-group-lg">
                                                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar2-check"></i></span>
                                                            <div class="form-floating">
                                                                <select name="lama_kontrak" class="form-select border-0" id="lama_kontrak" onchange="select_lama_kontrak()" <?= $data['renewal'] != '' ? 'disabled' : ''; ?>>
                                                                    <option value="" <?= $data['renewal'] == '' ? 'selected' : ''; ?>>-- Pilih Lama Kontrak --</option>
                                                                    <option value="3" <?= $data['renewal'] == '3' ? 'selected' : ''; ?>>3 Bulan</option>
                                                                    <option value="6" <?= $data['renewal'] == '6' ? 'selected' : ''; ?>>6 Bulan</option>
                                                                    <option value="12" <?= $data['renewal'] == '12' ? 'selected' : ''; ?>>1 Tahun</option>
                                                                    <option value="24" <?= $data['renewal'] == '24' ? 'selected' : ''; ?>>2 Tahun</option>
                                                                </select>
                                                                <label for="lama_kontrak">Lama Kontrak</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="mt-3 mr-auto">
                                                        <?php if ($data['status'] == '') { ?>
                                                            <button type="button" class="btn btn-primary float-end" id="btn_save" onclick="save_renewal()"><i class="ti-check"></i> Save</button>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- endnew -->

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="col-12 align-self-center py-4 text-center">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-7 col-xl-6 col-xxl-4">
                    <!-- <?php if ($data->id_status == 2) { ?> -->
                    <p class="h4 fw-light mb-4">Thank you.</p>
                    <h1 class="display-5">Already Approved</h1>
                    <i class="bi bi-check-square text-success" style="font-size: 100pt;"></i>
                    <!-- <?php } else if ($data->id_status == 7) { ?> -->
                    <h1 class="display-5">Already End</h1>
                    <i class="bi bi-emoji-smile-upside-down" style="font-size: 100pt;"></i>
                    <!-- <?php } else if ($data->id_status == 3) { ?> -->
                    <h1 class="display-5">Already Rejected</h1>
                    <i class="bi bi-emoji-smile-upside-down" style="font-size: 100pt;"></i>
                    <!-- <?php } ?> -->
                    <br>
                </div>
            </div>
        </div>
    <?php } ?>
</main>
<!-- Modal Add Confirm-->
<div class="modal fade" id="modalAddConfirm" tabindex="-1" aria-labelledby="modalAddConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddConfirmLabel">Form</h6>
                    <p class="text-secondary small">Save Contract Renewal?</p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="col-12 col-lg-12 col-xl-12 mb-4">
                    <h6 class="title">Are you sure ?</h6>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="u_id_exit_clearance" name="id_exit_clearance" readonly>
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md" id="btn_save_confirm" onclick="updateContractRenewal()">Yes, Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add Confirm -->