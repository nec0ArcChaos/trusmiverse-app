<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <!-- <p class="text-secondary">Perintah Kerja di Hari Libur</p> -->
            </div>
            <div class="col col-sm-auto">
                <div class="input-group input-group-md reportrange">
                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;">
                    <input type="hidden" name="startdate" value="" id="start" />
                    <input type="hidden" name="enddate" value="" id="end" />
                    <span class="input-group-text text-secondary bg-none" id="btn_filter"><i class="bi bi-calendar-event"></i></span>
                </div>
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
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-person-workspace h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List <?= $pageTitle ?></h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_jc" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Candidate Name</th>
                                    <th>Gender</th>
                                    <th>No Telp</th>
                                    <th>Email</th>
                                    <th>Usia</th>
                                    <th>Domisili</th>
                                    <th>Edu</th>
                                    <th>Jurusan</th>
                                    <th>Tempat Pendidikan</th>
                                    <th>Kerja Terakhir</th>
                                    <th>Tempat Kerja</th>
                                    <th>Masa Kerja</th>
                                    <th>Gaji Diharapkan</th>
                                    <th>Status</th>
                                    <th>Resume</th>
                                    <th>Apply Date</th>
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
<!-- Modal Add Permintaan Karyawan -->
<div class="modal" id="modal_add_permintaan" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Permintaan Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_add_permintaan">
                    <div class="col-lg-12 d-lg-flex d-sm-block justify-content-between">
                        <div class="col-lg-3 ">
                            <label class="form-label-custom required small" for="perusahaan">Perusahaan</label>
                            <div class="input-group mb-3">
                                <select name="perusahaan" id="perusahaan" class="select_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" onchange="get_department();get_location();">
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label-custom required small" for="department">Department</label>
                            <div class="input-group mb-3">
                                <select name="department" id="department" class=" select_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" onchange="get_posisi()">
                                    <option selected disable> --Pilih Department-- </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label-custom required small" for="posisi">Jabatan / Posisi</label>
                            <div class="input-group mb-3">
                                <select name="posisi" id="posisi" class=" select_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                    <option selected disable> --Pilih Jabatan / Posisi-- </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label-custom required small" for="jumlah">Jumlah Kebutuhan</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control input_permintaan" name="jumlah" id="jumlah" placeholder="jumlah" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 d-lg-flex d-sm-block justify-content-between">
                        <div class="col-lg-2">
                            <label class="form-label-custom required small" for="location">Location</label>
                            <div class="input-group mb-3">
                                <select name="location" id="location" class=" select_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                    <option selected disable>--Pilih Lokasi--</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label-custom required small" for="kel_posisi">Kelompok Posisi</label>
                            <div class="input-group mb-3">
                                <select name="kel_posisi" id="kel_posisi" class=" select_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                    <option selected disable> --Pilih Kelompok Posisi-- </option>

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label-custom required small" for="status_karyawan">Status Karyawan</label>
                            <div class="d-lg-flex d-sm-block justify-content-between col-lg-12">
                                <div class="input-group mb-3 me-1">
                                    <select name="status_karyawan" id="status_karyawan" class=" select_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                        <option selected disable> --Pilih Status Karyawan-- </option>

                                    </select>
                                </div>
                                <div class="input-group mb-3 ">
                                    <select name="tipe_kontrak" id="tipe_kontrak" class=" select_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                        <option selected disable> --Pilih Tipe Kontrak-- </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label-custom required small" for="gender">Gender</label>
                            <div class="input-group mb-3">
                                <select name="gender" id="gender" class=" select_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                    <option selected disabled>--Pilih Gender--</option>
                                    <option value="0">Male</option>
                                    <option value="1">Female</option>
                                    <option value="2">No Preference</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 d-lg-flex d-sm-block justify-content-between">
                        <div class="col-lg-2">
                            <label class="form-label-custom required small" for="perencanaan">Perencanaan</label>
                            <div class="input-group mb-3">
                                <select name="perencanaan" id="perencanaan" class=" select_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                    <option selected disabled>--Pilih Perencanaan--</option>
                                    <option value="Sesuai MPP">Sesuai MPP</option>
                                    <option value="Tidak Sesuai MPP">Tidak Sesuai MPP</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label-custom required small" for="permohonan">Dasar Permohonan</label>
                            <div class="input-group mb-3">
                                <select name="permohonan" id="permohonan" class="select_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" onchange="get_pengganti()">
                                    <option selected disabled>--Pilih Dasar Permohonan--</option>
                                    <option value="Posisi Baru">Posisi Baru</option>
                                    <option value="Tambahan">Tambahan</option>
                                    <option value="Penggantian Untuk">Penggantian Untuk</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label-custom required small" for="pengganti">Pengganti</label>
                            <div class="input-group mb-3 me-1">
                                <select name="pengganti" id="pengganti" class="" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" disabled onchange="send_pengganti()">
                                    <option selected disabled>--Pilih Pengganti--</option>
                                </select>
                            </div>
                            <input type="hidden" id="pengganti_hidden" name="pengganti_hidden" value="none">
                        </div>
                        <div class="col-lg-2">
                            <label class="form-label-custom required small" for="salary">Salary</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control input_permintaan" name="salary" id="salary" placeholder="Salary" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label-custom required small" for="latar_belakang">Latar Belakang Kebutuhan</label>
                            <div class="input-group mb-3 me-1">
                                <input type="text" class="form-control input_permintaan" name="latar_belakang" id="latar_belakang" placeholder="latar belakang" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 d-lg-flex d-sm-block">
                        <div class="col-lg-5 me-2">
                            <label class="form-label-custom required small" for="job_desc">Job Description</label>
                            <div class="input-group mb-3">
                                <textarea class="form-control input_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" name="job_desc" id="job_desc"></textarea>
                            </div>
                        </div>
                        <div class=" col-lg-7 d-lg-flex d-sm-block justify-content-around">
                            <div class="col-lg-5">
                                <div class="col-lg-12">
                                    <label class="form-label-custom required small" for="kpi">KPI</label>
                                    <div class="input-group mb-3">
                                        <textarea class="form-control input_permintaan textarea" rows=5 style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" id="kpi" name="kpi" autocomplete="off"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <label class="form-label-custom required small" for="bawahan_lgsg">Jml bawahan langsung</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control input_permintaan" name="bawahan_lgsg" id="bawahan_lgsg" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <label class="form-label-custom required small" for="pendidikan">Pendidikan / Jurusan</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control input_permintaan" name="pendidikan" id="pendidikan" placeholder="latar belakang" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="col-lg-12">
                                    <label class="form-label-custom required small" for="financial">Financial Impact</label>
                                    <div class="input-group mb-3">
                                        <textarea class="form-control input_permintaan textarea" rows=5 style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" id="financial" name="financial"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <label class="form-label-custom required small" for="bawahan_tidak_lgsg">Jml bawahan tidak langsung</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control input_permintaan" name="bawahan_tidak_lgsg" id="bawahan_tidak_lgsg" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <label class="form-label-custom required small" for="pengalaman">Pengalaman Kerja</label>
                                    <div class="input-group mb-3">
                                        <select name="pengalaman" id="pengalaman" class=" select_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                            <option selected disabled>--Pilih Pengalaman Kerja--</option>
                                            <option value="0">Fresh</option>
                                            <option value="1">1 Year</option>
                                            <option value="2">2 Years</option>
                                            <option value="3">3 Years</option>
                                            <option value="4">4 Years</option>
                                            <option value="5">5 Years</option>
                                            <option value="6">6 Years</option>
                                            <option value="7">7 Years</option>
                                            <option value="8">8 Years</option>
                                            <option value="9">9 Years</option>
                                            <option value="10">10 Years</option>
                                            <option value="11">+10 Years</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 d-lg-flex d-sm-block justify-content-between">
                        <div class="col-lg-4">
                            <label class="form-label-custom required small" for="kemampuan">Kemampuan Teknis & Pengetahuan yang Harus Dimiliki</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control input_permintaan" name="kemampuan" id="kemampuan" placeholder="kemampuan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label-custom required small" for="key_kompetensi">Kompetensi Kunci & Pengetahuan yang Harus Dimiliki</label>
                            <div class="input-group mb-3">
                                <textarea class="form-control input_permintaan textarea" rows=1 style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" name="key_kompetensi" id="key_kompetensi"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label-custom required small" for="leader_komp">Kompetensi Kepemimpinan</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control input_permintaan" name="leader_komp" id="leader_komp" placeholder="Kompetensi Kepemimpinan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 d-lg-flex d-sm-block justify-content-end">
                        <div class="col-lg-3">
                            <input type="hidden" id="job_id" name="job_id">
                            <select name="status_approve" id="status_approve" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" hidden>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class=" modal-footer">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="proses_permintaan">Simpan</button>
            </div>
        </div>
    </div>
</div>