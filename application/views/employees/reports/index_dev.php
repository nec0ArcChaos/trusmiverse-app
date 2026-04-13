<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
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

    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                    <div class="row mb-2">
                        <div class="col-auto">
                            <i class="bi bi-person-workspace h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">Employee Reports</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto ms-auto ps-0">
                            <div style="display: flex;justify-content: space-between;">
                                <div class="me-2">
                                    <select class="form-select" aria-label="Default select example"
                                        style="border-width: 2px; height:44px" id="company">
                                        <option value="#" selected disabled>-- Pilih Perusahaan --</option>
                                        <option value="">All Company</option>
                                        <?php foreach ($companies as $row): ?>
                                            <option value="<?= $row->company_id ?>"><?= $row->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="me-2">
                                    <select class="form-select" aria-label="Default select example"
                                        style="border-width: 2px; height:44px" id="department">
                                    </select>
                                </div>
                                <div class="me-2">
                                    <select class="form-select" aria-label="Default select example"
                                        style="border-width: 2px; height:44px" id="designation">
                                    </select>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary" onclick="show_report();"><i
                                            class="bi bi-search"></i><span id="text_btn_find">Find</span></button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <br>
                    <div id="btn-download-report" class="d-none">
                        <button type="button" class="btn btn-primary" onclick="download_report();"><i
                                class="bi bi-file-earmark-spreadsheet"></i> Download Excel </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_employees_report" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>NIP</th>
                                    <th>Nama Karyawan</th>
                                    <th>Nama Pengguna</th>
                                    <th>Perusahaan</th>
                                    <th>Departemen</th>
                                    <th>Designation</th>
                                    <th>Role</th>
                                    <th>Shift</th>
                                    <th>Masa Kerja</th>
                                    <th>Status</th>
                                    <th>Status Pernikahan</th>
                                    <th>Email</th>
                                    <th>Tgl Bergabung</th>
                                    <th>Tgl Terakhir Absen</th>
                                    <th>Tgl Resign</th>
                                    <th>Gender</th>
                                    <th>No Kontak</th>
                                    <th>Alamat</th>
                                    <th>Kota</th>
                                    <th>Provinsi</th>
                                    <th>Kode Pos</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tgl Lahir</th>
                                    <th>Ayah</th>
                                    <th>Ibu</th>
                                    <th>Suami</th>
                                    <th>Istri</th>
                                    <th>Jumlah Anak</th>
                                    <th>Anak</th>
                                    <th>No. KK</th>
                                    <th>No. KTP</th>
                                    <th>Agama</th>
                                    <th>No. JKN</th>
                                    <th>No. KPJ</th>
                                    <th>No. NPWP</th>
                                    <th>No. Rekening</th>
                                    <th>Kontrak</th>
                                    <th>Pendidikan 1</th>
                                    <th>Pendidikan 2</th>
                                    <th>Pendidikan 3</th>
                                    <th>Pendidikan 4</th>
                                    <th>Pendidikan 5</th>
                                    <th>Pengalaman Kerja 1</th>
                                    <th>Pengalaman Kerja 2</th>
                                    <th>Pengalaman Kerja 3</th>
                                    <th>Pengalaman Kerja 4</th>
                                    <th>Pengalaman Kerja 5</th>
                                    <th>Dokumen</th>
                                    <th>Lokasi Karyawan</th>
                                    <th>Atasan</th>
                                    <th>Status Nomor</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
</main>