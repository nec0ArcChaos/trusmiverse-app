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
                            <i class="bi bi-card-list h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List <?= $pageTitle ?></h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">

                            <div style="display: flex; gap:10px; align-items:center;">

                                <!-- DROPDOWN MASTER DATA -->
                                <div class="dropdown">
                                    <button class="btn btn-outline-dark dropdown-toggle"
                                        type="button"
                                        data-bs-toggle="dropdown">
                                        Master Data
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item"
                                                href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalPlatform">
                                                + Tambah Platform
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalContentType">
                                                + Tambah Jenis Konten
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalAccount">
                                                + Tambah Akun
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalWeek">
                                                + Tambah Week
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <!-- INPUT POSTING -->
                                <button class="btn btn-success"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalContent">
                                    + Input Posting
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_marcom" class="table table-bordered table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Platform</th>
                                    <th>Akun</th>
                                    <th>Week</th>
                                    <th>Jenis</th>
                                    <th>Link</th>
                                    <th>Target Views</th>
                                    <th>Views</th>
                                    <th>Target Engagement</th>
                                    <th>Engagement</th>
                                    <th>ER %</th>
                                    <th>Ach %</th>
                                    <th>Created by</th>
                                    <th width="150">Action</th>
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

<div class="modal fade" id="modalContent" aria-labelledby="modalContentLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <form class="modal-content" id="contentForm">
            <input type="hidden" id="content_id" name="id">

            <div class="modal-header">
                <h5 class="modal-title">Input Posting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="card mb-4">
                    <div class="card-header bg-light fw-semibold">Informasi Posting</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label>Platform</label>
                                <select name="platform" id="platform_select">
                                    <option value="">Pilih Platform</option>
                                    <?php foreach ($platform as $p): ?>
                                        <option value="<?= $p->id ?>"><?= $p->platform_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Akun</label>
                                <select name="account" id="account_select">
                                    <option value="">Pilih Akun</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label>Week</label>
                                <select name="week" id="week_select">
                                    <option value="">Pilih Week</option>
                                    <?php foreach ($week as $w): ?>
                                        <option value="<?= $w->id ?>">Week <?= $w->week_number ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Jenis Konten</label>
                                <select name="content_type" id="content_type_select">
                                    <option value="">Pilih Konten</option>
                                    <?php foreach ($content_type as $c): ?>
                                        <option value="<?= $c->id ?>"><?= $c->content_type_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Tanggal</label>
                                <input type="date" name="post_date" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>Judul</label>
                                <input type="text" name="title" class="form-control" placeholder="Masukkan judul postingan">
                            </div>

                            <div class="col-md-5">
                                <label>Link Posting</label>
                                <input type="url" name="post_link" class="form-control" placeholder="https://...">
                            </div>
                            <div class="col-md-5">
                                <label>Caption Posting</label>
                                <textarea name="caption" id="caption" class="form-control" placeholder="Masukkan caption postingan"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-light fw-semibold">Target Posting</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label>Target View</label>
                                <input type="number" name="target_view" class="form-control" placeholder="0">
                            </div>
                            <div class="col-md-4">
                                <label>Target Engagement</label>
                                <input type="number" name="target_engagement" class="form-control" placeholder="0">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-light fw-semibold">Scrap Posting (Actual Data)</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label>Views</label>
                                <input type="number" name="views" class="form-control" placeholder="0">
                            </div>
                            <div class="col-md-2">
                                <label>Reach</label>
                                <input type="number" name="reach" class="form-control" placeholder="0">
                            </div>
                            <div class="col-md-2">
                                <label>Likes</label>
                                <input type="number" name="likes" class="form-control" placeholder="0">
                            </div>
                            <div class="col-md-2">
                                <label>Comments</label>
                                <input type="number" name="comments" class="form-control" placeholder="0">
                            </div>
                            <div class="col-md-2">
                                <label>Saves</label>
                                <input type="number" name="saves" class="form-control" placeholder="0">
                            </div>
                            <div class="col-md-2">
                                <label>Shares</label>
                                <input type="number" name="shares" class="form-control" placeholder="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>

                <button type="submit" class="btn btn-primary">Save</button>
            </div>

        </form>

    </div>
</div>


<div class="modal fade" id="modalPlatform">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Master Platform</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- FORM -->
                <div class="row g-3 mb-4">
                    <div class="col-md-9">
                        <input type="text"
                            id="platform_name"
                            class="form-control"
                            placeholder="Nama Platform">
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary w-100"
                            onclick="save_platform()">
                            Simpan
                        </button>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="table-responsive">
                    <table id="table_platform"
                        class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>Nama Platform</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalContentType">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Master Jenis Konten</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- FORM -->
                <div class="row g-3 mb-4">
                    <div class="col-md-9">
                        <input type="text"
                            id="content_type_name"
                            class="form-control"
                            placeholder="Nama Jenis Konten">
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary w-100"
                            onclick="save_content_type()">
                            Simpan
                        </button>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="table-responsive">
                    <table id="table_content_type"
                        class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>Nama Jenis Konten</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAccount">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Master Akun</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- FORM -->
                <div class="row g-3 mb-4">

                    <div class="col-md-4">
                        <select id="account_platform"
                            class="form-select">
                            <option value="">Pilih Platform</option>
                            <?php foreach ($platform as $p): ?>
                                <option value="<?= $p->id ?>">
                                    <?= $p->platform_name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <input type="text"
                            id="account_name"
                            class="form-control"
                            placeholder="Nama Akun">
                    </div>

                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light" id="addon-username">@</span>
                            <input type="text"
                                id="account_username"
                                class="form-control"
                                placeholder="Username"
                                aria-describedby="addon-username">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary w-100"
                            onclick="save_account()">
                            Simpan
                        </button>
                    </div>

                </div>

                <!-- TABLE -->
                <div class="table-responsive">
                    <table id="table_account"
                        class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>Platform</th>
                                <th>Nama Akun</th>
                                <th>Username</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalWeek">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Master Week</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- FORM -->
                <div class="row g-3 align-items-end overflow-auto mb-4">

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            Nomor Week
                        </label>
                        <input type="number"
                            id="week_number"
                            class="form-control"
                            placeholder="Contoh: 1">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            Periode
                        </label>
                        <input type="month"
                            id="week_period"
                            class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            Start Date
                        </label>
                        <input type="date"
                            id="week_start_date"
                            class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            End Date
                        </label>
                        <input type="date"
                            id="week_end_date"
                            class="form-control">
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary w-100"
                            onclick="save_week()">
                            Simpan
                        </button>
                    </div>

                </div>

                <!-- TABLE -->
                <div class="table-responsive">
                    <table id="table_week"
                        class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>Week</th>
                                <th>Periode</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRescrap">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Update Data Scrap</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="rescrap_id">

                <div class="mb-2">
                    <label>Views</label>
                    <input type="number" id="rescrap_views" class="form-control">
                </div>

                <div class="mb-2">
                    <label>Reach</label>
                    <input type="number" id="rescrap_reach" class="form-control">
                </div>

                <div class="mb-2">
                    <label>Likes</label>
                    <input type="number" id="rescrap_likes" class="form-control">
                </div>

                <div class="mb-2">
                    <label>Comments</label>
                    <input type="number" id="rescrap_comments" class="form-control">
                </div>

                <div class="mb-2">
                    <label>Saves</label>
                    <input type="number" id="rescrap_saves" class="form-control">
                </div>

                <div class="mb-2">
                    <label>Shares</label>
                    <input type="number" id="rescrap_shares" class="form-control">
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="update_scrap()">
                    Update Scrap
                </button>
            </div>

        </div>
    </div>
</div>