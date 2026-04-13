<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Deskripsi Page</p>
            </div>
            <div class="col col-sm-auto">
                <div class="input-group input-group-md reportrange">
                    <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                    <input type="hidden" name="start" value="" id="start" />
                    <input type="hidden" name="end" value="" id="end" />
                    <span class="input-group-text text-secondary bg-none" id="titlecalandershow"><i class="bi bi-calendar-event"></i></span>
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
                <!-- <form action="<?= base_url('Fack/printBatch') ?>" method="post" id="form_id" target="_blank"> -->
                <div class="card-header">
                    <div class="row">
                        <div class="col-auto">
                            <i class="bi bi-person-badge h5 avatar avatar-40 bg-light-theme rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Karyawan</h6>
                        </div>
                        <div class="col-12">&nbsp;
                        </div>

                        <div class="col-12 ">
                            <div style="display: flex;justify-content: space-between;">
                                <div style="padding: 5px;">
                                    <!--     <label for=""></label>
                                        <button type="submit" class="btn btn-md btn-warning" style="border-radius: 0px;"><i class="fa fa-print"></i> Print Selected</button>-->
                                </div>
                                <div style="padding: 5px;">
                                    <label for="">Name :</label>
                                    <input type="search" class="form-control with-border" placeholder="Search by Name" name="id_user" id="id_user" style="min-width: 100px; border-width: 1px;" onchange="cari()">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dt_fack" class="table table-striped" width="100%">
                            <thead>
                                <tr>
                                    <!-- <th>#</th> -->
                                    <th>Tgl Join</th>
                                    <th>Posisi</th>
                                    <th>Nama</th>
                                    <th>Company</th>
                                    <th>Foto</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                </div>
                <!-- </form> -->
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="thisModal" tabindex="-1">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div id="modalContainer"></div>
            <!-- <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-12">
                     
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>