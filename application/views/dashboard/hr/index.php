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
            <?php 
            $this->load->view('dashboard/hr/kiri');
            $this->load->view('dashboard/hr/kanan');
            ?>
            
            
        </div>
    </div>

    <!-- Footer -->
    <?php $this->load->view('layout/_footer'); ?>
</main>


<!-- Modal Update Sub Task -->
<div class="modal fade" id="modal_detail_sub_task" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modal_detail_sub_taskLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header row align-items-center bg-theme">
                <div class="col-auto">
                    <i class="bi bi-clipboard-check h5 avatar avatar-40 bg-light text-theme rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="detail_title_sub_task">Detail Strategy</h6>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-white dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="title">Activity Log</h6>
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
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link m-1" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>