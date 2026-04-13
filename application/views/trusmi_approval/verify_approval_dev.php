<style>
    .container-custom {
        background: rgba(255, 255, 255, 0.95);
        width: 90%;
        max-width: 600px;
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .title {
        text-align: center;
        color: #333;
        margin-bottom: 2rem;
        font-size: 1.8rem;
    }

    .voice-indicator {
        background: #f0f0f0;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        position: relative;
        transition: all 0.3s ease;
    }

    .sound-icon {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .sound-wave {
        width: 250px;
        height: 100px;
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    .sound-wave .bar {
        display: block;
        width: 10px;
        margin-right: 1px;
        height: 10px;
        background: #7C93BF;
        animation: sound 0ms -800ms linear infinite alternate;
        transition: height 0.8s;
    }

    .sound-wave .bar-idle {
        display: block;
        width: 20px;
        margin-right: 1px;
        height: 5px;
        background: #7C93BF;
    }

    .sound-wave .bar2 {
        display: block;
        width: 2px;
        margin-right: 1px;
        height: 120px;
        background: #7C93BF;
        animation: sound2 0ms -800ms linear infinite alternate;
        transition: height 0.8s;
    }

    @keyframes sound {
        0% {
            opacity: .35;
            height: 6px;
        }

        100% {
            opacity: 1;
            height: 46px;
        }
    }

    @keyframes sound2 {
        0% {
            opacity: .35;
            height: 6px;
        }

        100% {
            opacity: 1;
            height: 120px;
        }
    }

    .bar:nth-child(1) {
        height: 2px;
        animation-duration: 474ms;
    }

    .bar:nth-child(2) {
        height: 10px;
        animation-duration: 433ms;
    }

    .bar:nth-child(3) {
        height: 18px;
        animation-duration: 407ms;
    }

    .bar:nth-child(4) {
        height: 26px;
        animation-duration: 458ms;
    }

    .bar:nth-child(5) {
        height: 30px;
        animation-duration: 400ms;
    }

    .bar:nth-child(6) {
        height: 32px;
        animation-duration: 427ms;
    }

    .bar:nth-child(7) {
        height: 34px;
        animation-duration: 441ms;
    }

    .bar:nth-child(8) {
        height: 36px;
        animation-duration: 419ms;
    }

    .bar:nth-child(9) {
        height: 40px;
        animation-duration: 487ms;
    }

    .bar:nth-child(10) {
        height: 46px;
        animation-duration: 442ms;
    }

    .bar:nth-child(11) {
        height: 2px;
        animation-duration: 474ms;
    }

    .bar:nth-child(12) {
        height: 10px;
        animation-duration: 433ms;
    }

    .bar:nth-child(13) {
        height: 18px;
        animation-duration: 407ms;
    }

    .bar:nth-child(14) {
        height: 26px;
        animation-duration: 458ms;
    }

    .bar:nth-child(15) {
        height: 30px;
        animation-duration: 400ms;
    }

    .bar:nth-child(16) {
        height: 32px;
        animation-duration: 427ms;
    }

    .bar:nth-child(17) {
        height: 34px;
        animation-duration: 441ms;
    }

    .bar:nth-child(18) {
        height: 36px;
        animation-duration: 419ms;
    }

    .bar:nth-child(19) {
        height: 40px;
        animation-duration: 487ms;
    }

    .bar:nth-child(20) {
        height: 46px;
        animation-duration: 442ms;
    }




    .bar-idle:nth-child(1) {
        height: 5px;
        animation-duration: 474ms;
    }

    .bar-idle:nth-child(2) {
        height: 5px;
        animation-duration: 433ms;
    }

    .bar-idle:nth-child(3) {
        height: 5px;
        animation-duration: 407ms;
    }

    .bar-idle:nth-child(4) {
        height: 5px;
        animation-duration: 458ms;
    }

    .bar-idle:nth-child(5) {
        height: 5px;
        animation-duration: 400ms;
    }

    .bar-idle:nth-child(6) {
        height: 5px;
        animation-duration: 427ms;
    }

    .bar-idle:nth-child(7) {
        height: 5px;
        animation-duration: 441ms;
    }

    .bar-idle:nth-child(8) {
        height: 5px;
        animation-duration: 419ms;
    }

    .bar-idle:nth-child(9) {
        height: 5px;
        animation-duration: 487ms;
    }

    .bar-idle:nth-child(10) {
        height: 5px;
        animation-duration: 442ms;
    }

    .bar-idle:nth-child(11) {
        height: 5px;
        animation-duration: 474ms;
    }

    .bar-idle:nth-child(12) {
        height: 5px;
        animation-duration: 433ms;
    }

    .bar-idle:nth-child(13) {
        height: 5px;
        animation-duration: 407ms;
    }

    .bar-idle:nth-child(14) {
        height: 5px;
        animation-duration: 458ms;
    }

    .bar-idle:nth-child(15) {
        height: 5px;
        animation-duration: 400ms;
    }

    .bar-idle:nth-child(16) {
        height: 5px;
        animation-duration: 427ms;
    }

    .bar-idle:nth-child(17) {
        height: 5px;
        animation-duration: 441ms;
    }

    .bar-idle:nth-child(18) {
        height: 5px;
        animation-duration: 419ms;
    }

    .bar-idle:nth-child(19) {
        height: 5px;
        animation-duration: 487ms;
    }

    .bar-idle:nth-child(20) {
        height: 5px;
        animation-duration: 442ms;
    }





    .voice-indicator.active {
        background: #e3f2fd;
    }

    .result-display {
        background: white;
        min-height: 150px;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border: 2px solid #eee;
        overflow-y: auto;
        max-height: 300px;
    }

    .record-btn {
        background: #4a90e2;
        color: white;
        border: none;
        padding: 1rem 2rem;
        font-size: 1.1rem;
        border-radius: 30px;
        cursor: pointer;
        display: block;
        margin: 0 auto;
        transition: all 0.3s ease;
        position: relative;
    }

    .record-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
    }

    .record-btn.recording {
        background: #ff4757;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 1rem;
    }

    .action-btn {
        padding: 0.8rem 1.5rem;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        background: #f0f0f0;
        transition: all 0.3s ease;
    }

    .action-btn:hover {
        background: #4a90e2;
        color: white;
    }
</style>

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

    <?php if (isset($_GET['id'])) { ?>
        <?php if ($data->id_status == 1 || $data->id_status == 4 || $data->id_status == 5 || $data->id_status == 6) { ?>
            <div class="m-3">
                <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
                    <div class="card border-0">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                                </div>
                                <div class="col-auto align-self-center">
                                    <h6 class="fw-medium mb-0">Detail Request</h6>
                                </div>
                                <div class="col-auto ms-auto ps-0">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-12 col-lg-12 col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-12 col-md-12 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-info-square"></i></span>
                                                <div class="form-floating">
                                                    <textarea name="subject" id="subject_a" class="form-control border-start-0" cols="30" rows="10" readonly style="min-height: 100px;"><?= $data->subject; ?></textarea>
                                                    <!-- <input type="text" placeholder="Subject" name="subject" id="subject_a" value="" required class="form-control border-start-0" readonly> -->
                                                    <label>Subject</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-down"></i></span>
                                                <div class="form-floating">
                                                    <input type="text" placeholder="Requested By" name="created_by" id="created_by_a" value="<?= $data->created_by; ?>" required class="form-control border-start-0" readonly>
                                                    <label>Requested By</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-up"></i></span>
                                                <div class="form-floating">
                                                    <input type="text" placeholder="Approve To" name="approve_to" id="approve_to_a" value="<?= $data->approve_to; ?>" required class="form-control border-start-0" readonly>
                                                    <label>Approve To</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-tag-fill"></i></span>
                                                <div class="form-floating">
                                                    <input type="text" placeholder="Kategori" name="kategori" id="kategori" value="<?= $data->kategori; ?>" required class="form-control border-start-0" readonly>
                                                    <label>Kategori</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                    <?php if ($data->kategori == 'Eaf') : ?>
                                        <div class="col-12 col-md-6 mb-2">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="input-group input-group-lg">
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-123"></i></span>
                                                    <div class="form-floating">
                                                        <input type="text" placeholder="Nominal" name="nominal" id="nominal" value="<?= $data->nominal; ?>" required class="form-control border-start-0" readonly>
                                                        <label>Nominal</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback mb-3">Add valid data </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="col-12 col-md-12 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                                <div class="form-floating">
                                                    <textarea name="description" id="description_a" class="form-control border-start-0" cols="30" rows="5" style="min-height: 80px;" required readonly><?= $data->description; ?></textarea>
                                                    <label>Description</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-4 col-lg-4">
                                        <h6 class="title">Related Documents</h6>
                                        <div id="file_a">
                                            <?php if ($data->file_1 != null || $data->file_1 != '') { ?>
                                                <?php $ext = pathinfo($data->file_1, PATHINFO_EXTENSION); ?>
                                                <?php if ($ext == 'docx' || $ext == 'doc') { ?>
                                                    <a href="<?= base_url('uploads/trusmi_approval/') . $data->file_1; ?>"> <span class="bi bi-file-earmark-word label label-primary" style="font-size:20pt;"></span></a>
                                                <?php } else if ($ext == 'xls' || $ext == 'xlsx') { ?>
                                                    <a href="<?= base_url('uploads/trusmi_approval/') . $data->file_1; ?>"> <span class="bi bi-file-earmark-excel label label-success" style="font-size:20pt;"></span></a>
                                                <?php } else { ?>
                                                    <a data-fancybox="gallery" href="<?= base_url('uploads/trusmi_approval/') . $data->file_1; ?>" class="gallery"> <span class="bi bi-image label label-primary" style="font-size:20pt;"></span></a>
                                                <?php } ?>
                                            <?php  } else { ?>
                                                <br>
                                            <?php    } ?>
                                            <?php if ($data->file_2 != null || $data->file_2 != '') { ?>
                                                <a data-fancybox="gallery" href="<?= base_url('uploads/trusmi_approval/') . $data->file_2; ?>" class="gallery"> <span class="bi bi-image label label-primary" style="font-size:20pt;"></span></a>
                                            <?php } else { ?>

                                            <?php  } ?>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-8 col-lg-8">
                                        <h6 class="title">Action</h6>
                                        <div class="row">
                                            <div class="col-12">
                                                <style>
                                                    .bar-container {
                                                        width: 200px;
                                                        height: 50px;
                                                        display: flex;
                                                        align-items: flex-end;
                                                        gap: 5px;
                                                    }

                                                    .bar {
                                                        width: 10px;
                                                        height: 5px;
                                                        background: #4ade80;
                                                        transition: height 0.1s linear;
                                                        border-radius: 4px;
                                                    }
                                                </style>

                                                <div class="bar-container" id="bars">
                                                    <!-- Akan diisi bar lewat JS -->
                                                </div>
                                                <br>
                                                <button onclick="startMic()">Start Listening</button>

                                            </div>

                                            <div class="col-12">
                                                <button id="record">🎤 Start Recording</button>
                                                <p id="status">Status: idle</p>
                                                <p id="text"></p>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <p class="text-center fw-bold" id="txt_speech">Fitur Speech to Text</p>
                                                <div class='sound-icon disabled'>
                                                    <div class='sound-wave'>
                                                        <i class='bar-idle'></i>
                                                        <i class='bar-idle'></i>
                                                        <i class='bar-idle'></i>
                                                        <i class='bar-idle'></i>
                                                        <i class='bar-idle'></i>
                                                        <i class='bar-idle'></i>
                                                        <i class='bar-idle'></i>
                                                        <i class='bar-idle'></i>
                                                        <i class='bar-idle'></i>
                                                        <i class='bar-idle'></i>
                                                        <i class='bar-idle'></i>
                                                        <i class='bar-idle'></i>
                                                        <i class='bar-idle'></i>
                                                        <i class='bar-idle'></i>
                                                        <i class='bar-idle'></i>
                                                        <i class='bar-idle'></i>
                                                        <i class='bar-idle'></i>
                                                        <i class='bar-idle'></i>
                                                        <i class='bar-idle'></i>
                                                        <i class='bar-idle'></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 d-flex alig-items-center justify-content-center">
                                                <div class="d-flex align-items-center">
                                                    <button type="button" class="record-btn" id="startRecord"><i class="bi bi-mic"></i></button>
                                                    <div class="action-buttons ms-2">
                                                        <button type="button" class="action-btn" id="cancelBtn">Cancel</button>
                                                        <button type="button" class="action-btn" id="clearBtn">Clear</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <form action="" id="formApprove">
                                            <div class="form-group mb-3 position-relative check-valid">
                                                <div class="input-group input-group-lg">
                                                    <input type="hidden" name="no_app" id="no_app_a" readonly>
                                                    <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                                    <div class="form-floating">
                                                        <textarea name="approve_note" id="approve_note" class="form-control border-start-0" cols="30" rows="5" style="min-height: 100px;" required autofocus></textarea>
                                                        <label>Note Approve</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12" style="text-align: right;">
                                                <?php if (isset($_GET['id'])) { ?>
                                                    <input type="hidden" name="no_app" value="<?= $_GET['id']; ?>" readonly>
                                                <?php } else { ?>
                                                <?php } ?>
                                                <button type="button" class="btn btn-md text-white btn-danger" id="btn_reject" onclick="reject()">Reject</button>
                                                <button type="button" class="btn btn-md text-white btn-success" id="btn_approve" onclick="approve()">Approve</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else if ($data->id_status == 2) { ?>
            <div class="col-12 align-self-center py-4 text-center">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-7 col-xl-6 col-xxl-4">
                        <?php if ($data->id_status == 2) { ?>
                            <p class="h4 fw-light mb-4">Thank you.</p>
                            <h1 class="display-5">Already Approved</h1>
                            <i class="bi bi-check-square text-success" style="font-size: 100pt;"></i>
                        <?php } else if ($data->id_status == 7) { ?>
                            <h1 class="display-5">Already End</h1>
                            <i class="bi bi-emoji-smile-upside-down" style="font-size: 100pt;"></i>
                            <br>
                        <?php } ?>
                    </div>
                </div>
            </div>

        <?php } else if ($data->id_status == 7 || $data->id_status == 3) { ?>
            <!-- section resubmit -->
            <div class="m-3">
                <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
                    <div class="card border-0">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                                </div>
                                <div class="col-auto align-self-center">
                                    <h6 class="fw-medium mb-0">Form Re-Submit Approval</h6>
                                </div>
                                <div class="col-auto ms-auto ps-0">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="form_resubmit">
                                <input type="hidden" name="old_no_app" value="<?= $data->no_app ?>">

                                <div class="row">
                                    <div class="col-2 col-xl-2 col-md-2 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-info-square"></i></span>
                                                <div class="form-floating">
                                                    <textarea name="tipe" class="form-control border-start-0" cols="30" rows="10" style="min-height: 100px;" readonly>Resubmit</textarea>
                                                    <label>Tipe</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                    <div class="col-10 col-xl-10 col-md-10 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-info-square"></i></span>
                                                <div class="form-floating">
                                                    <textarea name="subject" class="form-control border-start-0" cols="30" rows="10" style="min-height: 100px;"><?= $data->subject; ?></textarea>
                                                    <label>Subject</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-down"></i></span>
                                                <div class="form-floating">
                                                    <input type="text" placeholder="Requested By" name="created_by" value="<?= $data->created_by; ?>" required class="form-control border-start-0" readonly>
                                                    <label>Requested By</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-person-fill-up"></i></span>
                                                <div class="form-floating">
                                                    <input type="hidden" name="id_approve_to" value="<?= $data->user_id_approve_to ?>">
                                                    <input type="text" placeholder="Approve To" name="approve_to" value="<?= $data->approve_to; ?>" id="approve_to_reject" class="form-control border-start-0" readonly>
                                                    <label>Approve To</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-tag-fill"></i></span>
                                                <div class="form-floating">
                                                    <select name="kategori" id="kategori" class="form-control border-start-0" onchange="is_eaf()">
                                                        <option value="Approval" <?= $data->kategori == 'Approval' ? 'selected' : '' ?>>Approval</option>
                                                        <option value="Memo" <?= $data->kategori == 'Memo' ? 'selected' : '' ?>>Memo</option>
                                                        <option value="BA" <?= $data->kategori == 'BA' ? 'selected' : '' ?>>BA</option>
                                                        <option value="Eaf" <?= $data->kategori == 'Eaf' ? 'selected' : '' ?>>Eaf</option>
                                                        <option value="Other" <?= $data->kategori == 'Other' ? 'selected' : '' ?>>Other</option>
                                                    </select>
                                                    <label>Kategori</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <div id="field_nominal" class="form-group mb-3 position-relative check-valid <?= $data->kategori == 'Eaf' ? '' : 'd-none' ?>">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-123"></i></span>
                                                <div class="form-floating">
                                                    <input type="number" placeholder="Nominal" name="nominal" id="nominal" class="form-control border-start-0" value="<?= $data->nominal; ?>">
                                                    <label>Nominal</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                    <div class="col-12 col-md-12 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                                                <div class="form-floating">
                                                    <textarea name="description" class="form-control border-start-0" cols="30" rows="5" style="min-height: 80px;"><?= $data->description; ?></textarea>
                                                    <label>Description</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                </div>


                                <h6 class="title">Related Documents <span class="text-secondary" style="font-size: 9pt;">(*Optional)</span></h6>
                                <div class="row">
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class="card border-0 mb-4">
                                            <div class="card-body">
                                                <div class="row gx-3 align-items-center">
                                                    <div class="col-auto">
                                                        <!-- <div class="col-auto">
                                                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                                                </div> -->
                                                        <div class="avatar avatar-40 rounded bg-light-blue text-white">
                                                            <i class="bi bi-file-earmark-text h5 vm"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <h6 class="fw-medium mb-1">Allowed File</h6>
                                                        <p class="text-secondary">.pdf, .jpg, .png, .jpeg</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-cloud-upload"></i></span>
                                                <div class="form-floating">
                                                    <input type="file" placeholder="Related Documents 1" name="file_1" id="file_1" class="form-control" onchange="compress('#file_1', '#string_file_1', '#btn_save', '.fa_wait_1', '.fa_done_1')" accept="gambar/*" capture="">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" name="string_file_1" id="string_file_1">
                                        <div class="fa_wait_1" style="display: none;"><i class="fa fa-spinner fa-pulse"></i> <label>Copressing File ...</label></div>
                                        <div class="fa_done_1" style="display: none;"><i class="fa fa-check-circle" style="color: #689f38;"></i> <label>Copressing Complete.</label></div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-cloud-upload"></i></span>
                                                <div class="form-floating">
                                                    <input type="file" placeholder="Related Documents 1" name="file_2" id="file_2" class="form-control" onchange="compress('#file_2', '#string_file_2', '#btn_save', '.fa_wait_2', '.fa_done_2')" accept="gambar/*" capture="">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" name="string_file_2" id="string_file_2">
                                        <div class="fa_wait_2" style="display: none;"><i class="fa fa-spinner fa-pulse"></i> <label>Copressing File ...</label></div>
                                        <div class="fa_done_2" style="display: none;"><i class="fa fa-check-circle" style="color: #689f38;"></i> <label>Copressing Complete.</label></div>
                                        <div class="invalid-feedback mb-3">Add valid data </div>
                                    </div>
                                    <div class="col-12" align="right">
                                        <button type="submit" id="btn_resubmit" class="btn btn-md text-white btn-primary">Resubmit</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>
    <?php } ?>
</main>