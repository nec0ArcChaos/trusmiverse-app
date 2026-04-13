<main class="main mainheight">
    <?php $this->load->view('monday/header') ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 col-xl-12 mb-4">
                <div class="card border-0 h-100">
                    <!-- <div class="card-header">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <nav aria-label="breadcrumb" class="breadcrumb-theme bg-white">
                                    <ol class="breadcrumb">
                                        <li class="monday-breadcrumb-item active dropdown" aria-current="page">
                                            <a class="monday-item text-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                All Group </a>
                                            <ul class="dropdown-menu animate slideIn mt-lg-4" aria-labelledby="dropdownMenuButton1">
                                                <li>
                                                    <div class="d-flex justify-content-around">
                                                        <span class="small text-secondary">Group</span>
                                                        <a role="button"><i class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Choose Type"></i></a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item active" href="<?= base_url(); ?>monday/0">All Group</a></li>
                                                <li><a class="dropdown-item" href="<?= base_url(); ?>monday/1">Goals</a></li>
                                                <li><a class="dropdown-item" href="<?= base_url(); ?>monday/2">Task</a></li>
                                                <li><a class="dropdown-item" href="<?= base_url(); ?>monday/3">Request</a></li>
                                                <li><a class="dropdown-item" href="<?= base_url(); ?>monday/4">Mom</a></li>
                                            </ul>
                                        </li>
                                        <li class="monday-breadcrumb-item active dropdown" aria-current="page">
                                            <a class="monday-item text-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                All Category </a>
                                            <ul class="dropdown-menu animate slideIn mt-lg-4" aria-labelledby="dropdownMenuButton1">
                                                <li>
                                                    <div class="d-flex justify-content-around">
                                                        <span class="small text-secondary">Group</span>
                                                        <a role="button"><i class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Choose Type"></i></a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item" href="<?= base_url(); ?>monday/1">Goals</a></li>
                                                <li><a class="dropdown-item" href="<?= base_url(); ?>monday/2">Task</a></li>
                                                <li><a class="dropdown-item" href="<?= base_url(); ?>monday/3">Request</a></li>
                                                <li><a class="dropdown-item" href="<?= base_url(); ?>monday/4">Mom</a></li>
                                            </ul>
                                        </li>
                                        <li class="monday-breadcrumb-item active dropdown" aria-current="page">
                                            <a class="monday-item text-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                All Object </a>
                                            <ul class="dropdown-menu animate slideIn mt-lg-4" aria-labelledby="dropdownMenuButton1">
                                                <li>
                                                    <div class="d-flex justify-content-around">
                                                        <span class="small text-secondary">Group</span>
                                                        <a role="button"><i class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="Choose Type"></i></a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item" href="<?= base_url(); ?>monday/1">Goals</a></li>
                                                <li><a class="dropdown-item" href="<?= base_url(); ?>monday/2">Task</a></li>
                                                <li><a class="dropdown-item" href="<?= base_url(); ?>monday/3">Request</a></li>
                                                <li><a class="dropdown-item" href="<?= base_url(); ?>monday/4">Mom</a></li>
                                            </ul>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div> -->
                    <div class="card-body bg-none">
                        <div class="table-responsive">
                            <table id="dt_task" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap d-table-cell d-md-none">#</th>
                                        <th class="text-nowrap th-goals">Goals</th>
                                        <th class="text-nowrap" style="min-width: 150px;">PIC</th>
                                        <th class="text-nowrap">Type</th>
                                        <th class="text-nowrap" style="min-width: 150px;">Due Date</th>
                                        <!-- <th class="text-nowrap" style="min-width: 90px;">Priority</th> -->
                                        <th class="text-nowrap" style="min-width: 90px;">Status</th>
                                        <!-- <th class="text-nowrap" style="min-width: 150px;">Indicator</th> -->
                                        <th class="text-nowrap" style="min-width: 160px;">Strategy</th>
                                        <th class="text-nowrap">Jenis Strategy</th>
                                        <th class="text-nowrap">Progress</th>
                                        <th class="text-nowrap" style="min-width: 150px;">Timeline</th>
                                        <th class="text-nowrap" style="min-width: 150px;">Evaluation</th>
                                        <th class="text-nowrap" style="min-width: 150px;">By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Footer -->
    <div class="container-fluid footer-page mt-4 py-5">

    </div>
</main>

<!-- Modal -->
<div class="modal right modal-right fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>



<?php $this->load->view('monday_dev/details/detail_page'); ?>