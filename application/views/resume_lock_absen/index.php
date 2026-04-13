<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
            </div>
            <div class="col col-sm-auto">
                <div class="input-group input-group-md reportrange">
                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;">
                    <input type="hidden" name="startdate" value="" id="start" />
                    <input type="hidden" name="enddate" value="" id="end" />
                    <span class="input-group-text text-secondary bg-none" id="btn_filter"><i
                            class="bi bi-calendar-event"></i></span>
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
                            <i class="bi bi-card-list h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0"><?= $pageTitle ?></h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">

                            <!-- <div style="display: flex;justify-content: space-between;">
                                <div>
                                    <?php if (in_array($this->session->userdata('user_id'), [1, 3388, 6183])): ?>
                                        <button type="button" class="btn btn-primary" onclick="input_review()">
                                            Input Review</button>
                                    <?php endif ?>
                                    <button type="button" class="btn btn-success" onclick="review_head()">Review Head</button>
                                    <button type="button" class="btn btn-info" onclick="pic_check()">Check Review</button>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_lock_absen" class="table nowrap table-striped" width="100%">
                        <thead>
                        <tr>
                            <th style="background-color: #87CEFA; color: #000;">Nama</th>
                            <th style="background-color: #87CEFA; color: #000;">Jabatan</th>
                            <th style="background-color: #87CEFA; color: #000;">Jumlah Lock</th>
                            <th style="background-color: #87CEFA; color: #000;">Lock Tidak Absen</th>
                            <th style="background-color: #90EE90; color: #000;">Jumlah Lock MOM</th>
                            <th style="background-color: #90EE90; color: #000;">Jumlah Sesuai (MOM)</th>
                            <th style="background-color: #90EE90; color: #000;">% Sesuai (MOM)</th>
                            <th style="background-color: #90EE90; color: #000;">Tidak Sesuai (MOM)</th>
                            <th style="background-color: #90EE90; color: #000;">% Tidak Sesuai (MOM)</th>
                            <th style="background-color: #D8BFD8; color: #000;">Lock Non MOM</th>
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
            <!-- <div class="card border-0 mt-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-card-list h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Resume Absen Manual Keluar</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_absen_keluar" class="table nowrap table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Timestamp</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Lokasi Kerja</th>
                                    <th>Tipe Absen</th>
                                    <th>Email</th>
                                    <th>No Hp</th>
                                    <th>IP</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div> -->
        </div>
    </div>
</main>


<!-- Modal -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">Detail Absen Manual Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formUpdateUsername_masuk">
                    <input type="hidden" id="detail_id" name="id">

                    <select name="karyawan" id="selectKaryawan"
                        style="border:2px solid #6c63ff; border-radius:10px; padding:8px 12px; font-size:14px; min-width:280px; background:#fff;">
                    </select>

                    <br><br>

                    <div class="mb-3">
                        <label for="detail_username" class="form-label"><b>Username</b></label>
                        <input type="text" class="form-control" id="detail_username" name="username" readonly
                            style="border:2px solid #6c63ff; border-radius:10px; padding:10px 12px; font-size:14px; transition:0.3s;"
                            onfocus="this.style.borderColor='#4a3aff'; this.style.boxShadow='0 0 6px rgba(76, 61, 255, 0.5)'"
                            onblur="this.style.borderColor='#6c63ff'; this.style.boxShadow='none'">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btnSaveUsername">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Data Keluar -->
<div class="modal fade" id="modalDetailKeluar" tabindex="-1" aria-labelledby="modalDetailKeluarLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailKeluarLabel">Detail Absen Manual Keluar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formUpdateUsername_keluar">
                    <input type="hidden" id="detail_id_keluar" name="id">

                    <select name="karyawan" id="selectKaryawan_keluar"
                        style="border:2px solid #6c63ff; border-radius:10px; padding:8px 12px; font-size:14px; min-width:280px; background:#fff;">
                    </select>

                    <br><br>

                    <div class="mb-3">
                        <label for="detail_username_keluar" class="form-label"><b>Username</b></label>
                        <input type="text" class="form-control" id="detail_username_keluar" name="username" readonly
                            style="border:2px solid #6c63ff; border-radius:10px; padding:10px 12px; font-size:14px;">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btnSaveUsernameKeluar">Simpan</button>
            </div>
        </div>
    </div>
</div>