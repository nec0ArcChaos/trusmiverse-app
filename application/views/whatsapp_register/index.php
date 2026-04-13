<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <!-- <p class="text-secondary">Perintah Kerja di Hari Libur</p> -->
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

    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <?php if ($personal_info->registered == 0) { ?>
                        <h5 class="text-center">
                            Anda belum terdaftar untuk notifikasi Whatsapp Trusmiverse
                        </h5>
                        <div class="text-center">
                            Silahkan klik tombol dibawah ini untuk mendaftar<br>
                            <a target="_blank" href="https://api.whatsapp.com/send/?phone=6288971936684&amp;text=/TG" class="btn btn-success"><i class="bi bi-whatsapp"></i> Daftar</a><br>
                            atau copy link dibawah ini<br>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col">
                                    <div class="input-group input-group">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-link"></i></span>
                                        <input type="text" id="whatsapp_url" class="form-control" readonly value="https://api.whatsapp.com/send/?phone=6288971936684&amp;text=/TG">
                                        <button class="btn btn-theme btn-copy-url" type="button" onclick="copyUrl('whatsapp_url')">Copy URL</button>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <br>
                            atau scan QR dibawah ini<br><br>
                            <div class="text-center">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://trusmiverse.com/apps/api/send_wa/redirect_to_whatsapp" alt="QR Code" class="img-fluid">
                            </div>
                            <br>
                            atau chat manual ke nomor dibawah ini, lalu kirim pesan <code>/TG</code><br>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="input-group input-group">
                                        <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-link"></i></span>
                                        <input type="text" id="no_whatsapp" class="form-control" readonly value="6288971936684">
                                        <button class="btn btn-theme btn-copy-url" type="button" onclick="copyUrl('no_whatsapp')">Copy Nomor</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <h3 class="text-center"><i class="bi bi-check-circle text-success"></i></h3>
                        <h3 class="text-center">
                            Anda telah terdaftar untuk notifikasi Whatsapp Trusmiverse
                        </h3>
                    <?php } ?>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
</main>