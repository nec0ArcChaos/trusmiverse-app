<!-- <style>
    .container {
        position: relative;
        text-align: center;
        color: white;
    }

    .top-right {
        position: absolute;
        top: 8px;
        right: 16px;
    }

    .rotate_image {
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style> -->
<main class="main mainheight">
    <div class="container-fluid">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0">My Dashboard</h5>
                <p class="text-secondary">This is your personal dashboard</p>
            </div>
        </div>
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="https://trusmiverse.com">Trusmiverse</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">
        <div class="row mt-4">
            <div class="col-12 col-md-12 col-lg-5 col-xl-4">
                <!-- intro -->
                <div class="card border-0 mb-4">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-person-circle h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                            </div>
                            <div class="col ps-0">
                                <h6 class="fw-medium mb-0">Profile</h6>
                                <p class="text-secondary small" id="quotes">"Merangkul Resiko & Mencapai Keberhasilan"</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <!-- <div class="container">
                                <img src="img_snow_wide.jpg" alt="Snow" style="width:100%;">
                                <div class="bottom-left">Bottom Left</div>
                                <div class="top-left">Top Left</div>
                                <div class="top-right">Top Right</div>
                                <div class="bottom-right">Bottom Right</div>
                                <div class="centered">Centered</div>
                            </div> -->
                            <img id="consistency_status" src="" alt="" width="100px;">
                            <!-- <figure > -->
                            <img class="avatar avatar-150 coverimg mb-3 rounded-circle" id="photo_profile" src="" alt="" />
                            <!-- </figure> -->

                            <h5 class="text-truncate mb-0" id="employee_name"></h5>
                            <p class="text-secondary small mb-1" id="jabatan"></p>
                            <ul class="nav justify-content-center">
                                <li class="nav-item">
                                    <img class="cols avatar avatar-20 coverimg rounded-circle" src="<?= base_url(); ?>assets/img/logo_rumah_ningrat.png" alt="">
                                </li>
                                <li class="nav-item">
                                    <img class="cols avatar avatar-20 coverimg rounded-circle" src="<?= base_url(); ?>assets/img/logo_bt.png" alt="">
                                </li>
                                <li class="nav-item">
                                    <img class="cols avatar avatar-20 coverimg rounded-circle" src="<?= base_url(); ?>assets/img/logo_tkb.png" alt="">
                                </li>
                                <li class="nav-item">
                                    <img class="cols avatar avatar-20 coverimg rounded-circle" src="<?= base_url(); ?>assets/img/fbtlogo.png" alt="">
                                </li>
                            </ul>
                        </div>
                        <hr>
                        <div class="row align-items-center mb-3" id="row_goals">
                            <div class="col-6">
                                <h6>Goals <span class="float-end badge badge-sm bg-blue" id="goal"></span></h6>
                            </div>
                            <div class="col-6">
                                <h6>Strategy <span class="float-end badge badge-sm bg-purple" id="strategy"></span></h6>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3" id="row_no_goals" style="display:none">
                            <div class="col-12 text-center">
                                <h6><i class="text-muted">No Goals</i></h6>
                            </div>
                        </div>
                        <hr>
                        <div class="row align-items-center mb-1" id="row_consistency">
                            <div class="col">
                                <h4 class="fw-medium mb-0">Consistency</h4>
                                <!-- <span id="status_consistency"></span> -->
                            </div>
                            <div class="col-auto">
                                <div class="circle-medium">
                                    <div id="consistency">
                                        <!-- <svg viewBox="0 0 100 100" style="display: block; width: 100%;">
                                            <path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="rgba(120, 195, 0, 0.15)" stroke-width="10" fill-opacity="0"></path>
                                            <path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="rgb(145,195,0)" stroke-width="10" fill-opacity="0" style="stroke-dasharray: 282.783, 282.783; stroke-dashoffset: 42.4175;"></path>
                                        </svg> -->
                                    </div>
                                    <div class="avatar h4 bg-light-green rounded-circle">
                                        <b class="small" id="consistency_percent"></b>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pertama -->
                        <hr>
                        <div id="goals_card">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-7 col-xl-8">
                <!-- Experience -->
                <div class="card border-0 mb-4">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-calendar-week h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                            </div>
                            <div class="col ps-0">
                                <h6 class="fw-medium mb-0">Calendar</h6>
                                <p class="text-secondary small">"The calendar is a roadmap, and your goals are the destination."</p>
                            </div>
                            <div class="col-auto">
                                <a href="<?= base_url(); ?>dashboard/ibr_pro_list" class="btn btn-link bg-light-blue"><i class="bi bi-people"></i> Dashboard Team</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <!-- Start -->
                        <div class="inner-sidebar-wrap border-bottom">
                            <div class="inner-sidebar-content">
                                <div id="calendarNew"></div>
                            </div>
                        </div>
                        <!-- End -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php $this->load->view('layout/_footer'); ?>
</main>



<!-- Modal Update Sub Task -->
<div class="modal fade" id="modal_detail_sub_task" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modal_detail_sub_taskLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-none">
                <div class="col-auto">
                    <i class="bi bi-list-task h5 avatar avatar-40 bg-blue text-white rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0">To-Do list</h6>
                    <p class="text-secondary small">Pickup a task</p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-dark dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row wrapper">
                    <div class="col-12 col-md-12 col-lg-12 mb-3">
                        <div id="todo-list">

                        </div>
                    </div>
                </div>
                <!-- <div class="d-flex align-items-center">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="title">Activity Today</h6>
                                <table id="dt_log_history_sub_task" class="table table-sm table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_log_hitory_sub_task">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link m-1" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>