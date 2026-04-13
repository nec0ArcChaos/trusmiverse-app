<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Deskripsi Page</p>
            </div>
            <div class="col col-sm-auto">
                <form method="POST" id="form_filter">
                    <div class="input-group input-group-md reportrange">
                        <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                        <input type="hidden" name="start" value="" id="start" />
                        <input type="hidden" name="end" value="" id="end" />
                        <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </form>
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
                            <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List History</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <div class="row">

                            <div class="col-12 col-md-12 col-lg-12 mb-2">
                                <label for="">Search</label>
                            </div>
                            <div class="col-12 col-md-3 col-lg-2 mb-2">
                                <select id="search-tanggal" multiple>
                                </select>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3 mb-2">
                                <select id="search-nama" multiple>
                                </select>
                            </div>
                            <div class="col-12 col-md-3 col-lg-2 mb-2">
                                <select id="search-perusahaan" multiple>
                                </select>
                            </div>
                            <div class="col-12 col-md-3 col-lg-2 mb-2">
                                <select id="search-department" multiple>
                                </select>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3 mb-2">
                                <select id="search-type-lock" multiple>
                                </select>
                            </div>
                        </div>
                        <table id="dt_trusmi_history" class="table table-sm table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Tgl</th>
                                    <th>Nama</th>
                                    <th>Perusahaan</th>
                                    <th>Department</th>
                                    <th>Type Lock</th>
                                    <th>Reason</th>
                                    <th>Attempt</th>
                                    <th>Jam Pulang</th>
                                </tr>
                            </thead>
                            <tbody></tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>