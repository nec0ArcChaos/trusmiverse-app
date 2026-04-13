<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                    <li class="breadcrumb-item active">Push Notification</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="m-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                
                <!-- HEADER -->
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-bell h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col align-self-center">
                            <h6 class="fw-medium mb-0">Kirim Push Notification</h6>
                        </div>
                    </div>
                </div>

                <!-- BODY -->
                <div class="card-body">
                    <div class="row g-4">

                        <!-- LEFT FORM -->
                        <div class="col-lg-6">

                            <!-- USER -->
                            <div class="form-group mb-3">
                                <label class="mb-1">Pilih Karyawan</label>
                                <select name="employees" id="employees" class="form-control" multiple>
                                    <!-- <option value="" selected disabled>Select Employee</option> -->
                                    <?php foreach ($list_employees as $emp) : ?>
                                        <option value="<?php echo $emp->user_id ?>" data-token="<?= $emp->fcm_token ?>"><?php echo $emp->name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <!-- TOKEN -->
                            <div class="form-group mb-3">
                                <label class="mb-1">FCM Token</label>
                                <input type="text" id="token" class="form-control"
                                       placeholder="FCM Token" readonly>
                            </div>

                            <!-- TITLE -->
                            <div class="form-group mb-3">
                                <label class="mb-1">Judul Notif</label>
                                <input type="text" id="title" class="form-control"
                                       placeholder="Judul Notifikasi">
                            </div>

                            <!-- BODY -->
                            <div class="form-group mb-3">
                                <label class="mb-1">Pesan Notif</label>
                                <textarea type="text" id="body" class="form-control"
                                       placeholder="Isi Pesan"></textarea>
                            </div>

                            <!-- MENU -->
                            <div class="form-group mb-3">
                                <label class="mb-1">Menu</label>
                                <select id="nama_menu" class="form-control">
                                    <option value="push" selected>Push Notif</option>
                                    <!-- <option value="blast">Trusmi Blast</option>
                                    <option value="mom">Mom</option> -->
                                </select>
                            </div>

                            <!-- TRX -->
                            <div class="form-group mb-3">
                                <label class="mb-1">No Transaksi</label>
                                <input type="text" id="trx_id" class="form-control"
                                       placeholder="Transaction ID" readonly>
                            </div>

                            <!-- FILE -->
                            <div class="form-group mb-3">
                                <label class="mb-1">Upload File (optional)</label>
                                <input type="file" id="file" class="form-control">
                            </div>

                            <!-- BUTTON -->
                            <div class="text-end">
                                <button id="btnSend" class="btn btn-theme">
                                    Kirim Notifikasi <i class="bi bi-send"></i>
                                </button>
                            </div>

                        </div>

                        <!-- RIGHT RESULT -->
                        <div class="col-lg-6">
                            <label class="mb-2">Response</label>
                            <pre id="result" style="height:400px; overflow:auto; background:#111; color:#0f0; padding:15px; border-radius:10px;"></pre>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</main>