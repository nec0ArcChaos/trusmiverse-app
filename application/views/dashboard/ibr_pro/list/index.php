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

    <div class="container-fluid">
        <div class="row mt-4" id="ibr_pro_list">
            
        </div>
    </div>

    <!-- Footer -->
    <?php $this->load->view('layout/_footer'); ?>
</main>


<div class="modal fade" id="modal_profile_to" tabindex="-1" aria-labelledby="modal_detail_taskLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_detail_taskLabel">Show</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="user_id">
                    <div class="col">
                        <button class="btn btn-theme" onclick="go_to('dashboard')">Dashboard</button>
                    </div>
                    <div class="col">
                        <button class="btn btn-success" onclick="go_to('kanban')">Kanban</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-link m-1" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-link btn-monday m-1" onclick="save_object()">Save</button> -->
            </div>
        </div>
    </div>
</div>