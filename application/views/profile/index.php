<main class="main mainheight">
    <div class="container mt-4">
        <div class="card border-0 mb-4 overflow-hidden">
            <figure class="coverimg position-fixed-bg w-100 h-250 mb-0">
                <img src="assets/img/bg-3.jpg" class="mw-100" alt="" />
            </figure>
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <figure class="avatar avatar-160 coverimg rounded-circle top-80 shadow-md">
                            <img id="profile_picture" src="" alt="" />
                        </figure>
                    </div>
                    <div class="col pt-3">
                        <h2><?= $this->session->userdata('nama'); ?> <span class="badge bg-green rounded vm fw-normal fs-12"><i class="bi bi-check-circle me-1"></i>Active</span></h2>
                        <p class="text-secondary mb-3"><i class="bi bi-geo-alt me-1"></i><?= $my_profile->address; ?></p>
                        <p>
                            <a href="tel:+18358638952581" class="tag theme-green mb-2 me-2">
                                <span class="avatar avatar-30 rounded-circle me-1 vm"><i class="bi bi-telephone"></i></span> <?= $my_profile->contact_no; ?>
                            </a>
                            <a href="mailto:information@maxartkiller.com" class="tag  mb-2 me-2">
                                <span class="avatar avatar-30 rounded-circle me-1 vm"><i class="bi bi-envelope"></i></span> <?= $my_profile->email; ?>
                            </a>
                        </p>
                    </div>
                    <div class="col-auto pt-3">
                        <p class="text-secondary">Share</p>
                        <ul class="nav justify-content-center">
                            <li class="nav-item">
                                <a class="nav-link px-2" href="#" target="_blank">
                                    <i class="bi bi-facebook h5"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-2" href="#" target="_blank">
                                    <i class="bi bi-twitter h5"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-2" href="#" target="_blank">
                                    <i class="bi bi-linkedin h5"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-2" href="#" target="_blank">
                                    <i class="bi bi-instagram h5"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <ul class="nav nav-lg nav-WinDOORS justify-content-center mb-4" role="tablist">
            <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link active" id="basicdetails-tab" data-bs-toggle="tab" data-bs-target="#basicdetails" role="tab" aria-controls="basicdetails">Basic</a>
            </li>
            <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link " id="analytics-tab" data-bs-toggle="tab" data-bs-target="#analytics" role="tab" aria-controls="analytics">Analytic</a>
            </li>
            <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments" role="tab" aria-controls="payments">Payments</a>
            </li>
        </ul>

        <div class="tab-content" id="myprofileanalyticstabs">
            <div class="tab-pane fade show active" id="basicdetails" role="tabpanel" aria-labelledby="basicdetails-tab">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6 col-xxl-3 mb-4 column-set">
                        <div class="card border-0 bg-theme h-100">
                            <div class="card-header bg-none">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="fw-medium">
                                            <i class="bi bi-wallet2 h5 me-1 avatar avatar-30 rounded"></i>
                                            Working in :
                                        </h6>
                                    </div>
                                    <div class="col-auto">
                                        <div class="dropdown d-inline-block">
                                            <a class="btn btn-link btn-square text-white dd-arrow-none dropdown-toggle" role="button">
                                                <i class="bi bi-columns"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body bg-none text-white">
                                <div class="text-center mb-3">
                                    <h5 class="fw-normal mb-0 username">Holding Trusmi Group</h5>
                                    <figure class="avatar avatar-100 coverimg rounded-circle mb-3 mx-auto" style="background-image: url(&quot;assets/img/user-1.jpg&quot;);">
                                        <img src="assets/img/user-1.jpg" class="ususerphotoonboarding" alt="" style="display: none;">
                                    </figure>
                                    <h3 class="fw-medium"><?= $this->session->userdata('nama'); ?></h3>
                                    <hr style="margin-top: 0;margin-bottom: 0;width: 80%;">
                                    <h3 class="fw-medium">Business Improvement</h3>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="avatar avatar-40 rounded-circle bg-green">
                                                    <i class="bi bi-arrow-down-left"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <p class="small text-muted mb-1">Date Of Join</p>
                                                <p class="">2022-08-28 <small></small></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 text-end border-left-dashed">
                                        <div class="row align-items-center">
                                            <div class="col pe-0">
                                                <p class="small text-muted mb-1">KPI</p>
                                                <p class="">80 <small>%</small></p>
                                            </div>
                                            <div class="col-auto">
                                                <div class="avatar avatar-40 rounded-circle bg-red">
                                                    <i class="bi bi-arrow-up-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 col-xxl-3 mb-4 column-set">
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-geo-alt h5 avatar avatar-40 bg-light-theme rounded"></i>
                            </div>
                            <div class="col">
                                <h6 class="fw-medium mb-0">Alamat</h6>
                                <p class="small text-secondary">Kelola alamat anda</p>
                            </div>
                            <div class="col-auto">
                                <a href="profile-analytics.html" class="btn btn-link btn-sm"><i class="bi bi-plus me-2"></i>Edit Address</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card border-0 mb-4">
                                    <div class="card-header">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="mb-0">Address 1</h6>
                                                <p class="text-secondary small">This is default</p>
                                            </div>
                                            <div class="col-auto">
                                                <div class="dropdown d-inline-block">
                                                    <a class="btn btn-sqaure btn-link text-secondary dd-arrow-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="true" data-bs-display="static" role="button">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end" data-bs-popper="static">
                                                        <li><a class="dropdown-item" href="javascript:void(0)">Edit</a></li>
                                                        <li><a class="dropdown-item active" href="javascript:void(0)">Mark as default</a></li>
                                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)">Delete</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h6>Max Doe <br><small class="small fw-normal">+15896255A55669</small></h6>
                                        <p class="text-secondary mb-3">D25, Amalika Empire, DD Street,<br>San Jose, United States</p>
                                        <span class="tag tag-sm theme-yellow ps-1"><i class="avatar avatar-20 bi bi-house-door me-1 vm "></i>Home</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card border-0 mb-4">
                            <div class="card-body">
                                <h6 class="mb-3">Working in:</h6>
                                <div class="row">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-40 rounded-circle coverimg">
                                            <img src="https://getwindoors.com/html/assets/img/news-3.jpg" alt="" />
                                        </figure>
                                    </div>
                                    <div class="col">
                                        <p class="text-secondary"><b>2019-Present</b>, Lead Manager at <a href="profile-analytics.html">USbullscore LLP</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 col-xxl-3 mb-4 column-set">
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="bi bi-book h5 avatar avatar-40 bg-light-theme rounded"></i>
                            </div>
                            <div class="col">
                                <h6 class="fw-medium mb-0">Aktifitas Belajar</h6>
                            </div>
                            <div class="col-auto">
                                <a href="profile-analytics.html" class="btn btn-link btn-sm"><i class="bi bi-eye me-2"></i>Selengkapnya</a>
                            </div>
                        </div>
                        <div class="row" id="training-list">

                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card border-0 bg-radial-gradiant text-white mb-4">
                            <div class="card-body bg-none">
                                <h6 class="mb-3">Customize and Update</h6>
                                <div class="row">
                                    <div class="col-auto">
                                        <div class="avatar avatar-40 rounded-circle bg-light-white">
                                            <i class="bi bi-pencil"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <p class="">Stay up to date.<br><a href="profile-analytics.html" class="text-white">Edit Profile</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <i class="bi bi-geo-alt h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Addresses</h6>
                        <p class="small text-secondary">Manage your addresses for Delivery</p>
                    </div>
                    <div class="col-auto">
                        <a href="profile-analytics.html" class="btn btn-link btn-sm"><i class="bi bi-plus me-2"></i>Add Address</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card border-0 mb-4">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="mb-0">Address 1</h6>
                                        <p class="text-secondary small">This is default</p>
                                    </div>
                                    <div class="col-auto">
                                        <div class="dropdown d-inline-block">
                                            <a class="btn btn-sqaure btn-link text-secondary dd-arrow-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="true" data-bs-display="static" role="button">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end" data-bs-popper="static">
                                                <li><a class="dropdown-item" href="javascript:void(0)">Edit</a></li>
                                                <li><a class="dropdown-item active" href="javascript:void(0)">Mark as default</a></li>
                                                <li><a class="dropdown-item text-danger" href="javascript:void(0)">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6>Max Doe <br><small class="small fw-normal">+15896255A55669</small></h6>
                                <p class="text-secondary mb-3">D25, Amalika Empire, DD Street,<br>San Jose, United States</p>
                                <span class="tag tag-sm theme-yellow ps-1"><i class="avatar avatar-20 bi bi-house-door me-1 vm "></i>Home</span>
                            </div>
                        </div>
                    </div>
                    <div class=" col-12 col-md-6 col-lg-3">
                        <div class="card border-0 mb-4">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="mb-0">Address 2</h6>
                                        <p class="text-secondary small">This is secondary</p>
                                    </div>
                                    <div class="col-auto">
                                        <div class="dropdown d-inline-block">
                                            <a class="btn btn-sqaure btn-link text-secondary dd-arrow-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="true" data-bs-display="static" role="button">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end" data-bs-popper="static">
                                                <li><a class="dropdown-item" href="javascript:void(0)">Edit</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)">Mark as default</a></li>
                                                <li><a class="dropdown-item text-danger" href="javascript:void(0)">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6>Maxartkiller <br><small class="small fw-normal">+15896255A55669</small></h6>
                                <p class="text-secondary mb-3">D25, Amalika Empire, DD Street,<br>San Jose, United States</p>
                                <span class="tag tag-sm ps-1"><i class="avatar avatar-20 bi bi-building me-1 vm "></i>Office</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <i class="bi bi-bag h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Recent Orders</h6>
                        <p class="small text-secondary">Manage your recent orders</p>
                    </div>
                    <div class="col-auto">
                        <a href="profile-analytics.html" class="btn btn-link btn-sm"><i class="bi bi-shop vm me-2"></i>Visit Store</a>
                    </div>
                </div>
                <div class="card border-0 mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <figure class="avatar avatar-40 border mb-0 coverimg rounded" style="background-image: url(&quot;assets/img/product-1.jpg&quot;);">
                                    <img src="https://getwindoors.com/html/assets/img/product-1.jpg" alt="" style="display: none;">
                                </figure>
                            </div>
                            <div class="col ps-0">
                                <p class="mb-0">Shoes</p>
                                <p class="text-secondary small">1 item - SKUID: SH02521...</p>
                            </div>
                            <div class="col ps-0">
                                <p class="mb-0">80.00</p>
                                <p class="text-secondary small">USD</p>
                            </div>
                            <div class="col ps-0">
                                <p class="mb-0">Status</p>
                                <p class="text-secondary small">Shipped</p>
                            </div>
                            <div class="col ps-0">
                                <p class="mb-0">Payment</p>
                                <p class="text-green small">Paid</p>
                            </div>
                            <div class="col-auto">
                                <div class="dropdown d-inline-block">
                                    <a class="text-secondary dd-arrow-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="javascript:void(0)">Edit</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">Move</a></li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)">Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-top">
                        <ul class="progress-stepbar">
                            <li class="completed"><span>Order Placed</span></li>
                            <li class="completed"><span>Packed</span></li>
                            <li class="completed"><span>Invoiced</span></li>
                            <li class="stop"><span>Shipped</span></li>
                            <li><span>Delivered</span></li>
                        </ul>
                    </div>
                </div>
                <div class="card border-0 mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <figure class="avatar avatar-40 border mb-0 coverimg rounded" style="background-image: url(&quot;assets/img/product-2.jpg&quot;);">
                                    <img src="https://getwindoors.com/html/assets/img/product-2.jpg" alt="" style="display: none;">
                                </figure>
                            </div>
                            <div class="col ps-0">
                                <p class="mb-0">Titan Watch</p>
                                <p class="text-secondary small">1 item - SKUID: SH02631...</p>
                            </div>
                            <div class="col ps-0">
                                <p class="mb-0">43.00</p>
                                <p class="text-secondary small">USD</p>
                            </div>
                            <div class="col ps-0">
                                <p class="mb-0">Status</p>
                                <p class="text-secondary small">Invoiced</p>
                            </div>
                            <div class="col ps-0">
                                <p class="mb-0">Payment</p>
                                <p class="text-green small">Paid</p>
                            </div>
                            <div class="col-auto">
                                <div class="dropdown d-inline-block">
                                    <a class="text-secondary dd-arrow-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static" role="button">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="javascript:void(0)">Edit</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)">Move</a></li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)">Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-top">
                        <ul class="progress-stepbar">
                            <li class="completed"><span>Order Placed</span></li>
                            <li class="completed"><span>Packed</span></li>
                            <li class="stop"><span>Invoiced</span></li>
                            <li class=""><span>Shipped</span></li>
                            <li><span>Delivered</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="analytics" role="tabpanel" aria-labelledby="analytics-tab">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-6 mb-4">
                        <div class="row align-items-center mb-4">
                            <div class="col-auto">
                                <div class="doughnutchart small">
                                    <div class="countvalue text-center">
                                        <div class="text-center w-100">
                                            <h6 class="mb-0">46</h6>
                                            <p class="text-secondary small">Total</p>
                                        </div>
                                    </div>
                                    <canvas id="doughnutchart"></canvas>
                                </div>
                            </div>
                            <div class="col">
                                <p><span class="avatar avatar-10 rounded-circle bg-red me-1"></span> 12 UI/UX</p>
                                <p><span class="avatar avatar-10 rounded-circle bg-yellow me-1"></span> 20 Development </p>
                                <p><span class="avatar avatar-10 rounded-circle bg-blue me-1"></span> 14 Business Development</p>
                            </div>
                        </div>
                        <div class="mediumchart">
                            <canvas id="mediumchartgreen1"></canvas>
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-6 mb-4">
                        <div class="row align-items-center mb-4">
                            <div class="col-auto">
                                <div class="doughnutchart small">
                                    <div class="countvalue text-center">
                                        <div class="text-center w-100">
                                            <h6 class="mb-0">46</h6>
                                            <p class="text-secondary small">Total</p>
                                        </div>
                                    </div>
                                    <canvas id="doughnutchart2"></canvas>
                                </div>
                            </div>
                            <div class="col">
                                <p><span class="avatar avatar-10 rounded-circle bg-red me-1"></span> 12 UI/UX</p>
                                <p><span class="avatar avatar-10 rounded-circle bg-yellow me-1"></span> 20 Development </p>
                                <p><span class="avatar avatar-10 rounded-circle bg-blue me-1"></span> 14 Business Development</p>
                            </div>
                        </div>
                        <div class="mediumchart">
                            <canvas id="mediumchartred1"></canvas>
                        </div>
                    </div>
                </div>
                <div class="row mb-4 py-2">
                    <div class="col text-center">
                        <h4>All of your <span class="text-gradient">Budget</span> target</h4>
                        <p class="text-secondary">Keep your profile with upto date details</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <!-- targets and progress -->
                        <div class="card border-0 position-relative mb-4">
                            <div class="coverimg position-absolute end-0 top-0 h-100 w-30pct rounded">
                                <img src="https://getwindoors.com/html/assets/img/business-4.jpg" alt="">
                            </div>
                            <div class="row">
                                <div class="col-9">
                                    <div class="card border-0 bg-white shadow-none">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="rounded bg-theme text-white p-3">
                                                        <i class="bi bi-building mb-1"></i>
                                                        <p class="text-muted small mb-1">
                                                            Annual<br>Income
                                                        </p>
                                                        <p>$2542</p>
                                                    </div>
                                                </div>
                                                <div class="col ps-0 align-self-center">
                                                    <p class="text-secondary small mb-0">United States</p>
                                                    <p>New York</p>
                                                    <div class="mt-4">
                                                        <div class="progress h-5 mb-1 bg-light-theme">
                                                            <div class="progress-bar bg-theme" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <p class="small text-secondary">Targeted <span class="float-end">$ 11600</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3 position-relative">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card border-0 theme-green mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto">
                                        <div class="rounded bg-theme text-white p-3">
                                            <i class="bi bi-bank mb-1"></i>
                                            <p class="text-muted small mb-1">
                                                Assets<br>Income
                                            </p>
                                            <p>$2542</p>
                                        </div>
                                    </div>
                                    <div class="col ps-0 align-self-center">
                                        <div class="row">
                                            <div class="col">
                                                <p class="text-secondary small mb-0">United States</p>
                                                <p>New York</p>
                                            </div>
                                            <div class="col-auto text-end">
                                                <p class="text-secondary small mb-0">New Sales</p>
                                                <p>120 orders</p>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <div class="progress h-5 mb-1 bg-light-theme">
                                                <div class="progress-bar bg-theme" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <p class="small text-secondary">Targeted Orders<span class="float-end">260</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card border-0 theme-teal mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto">
                                        <div class="rounded bg-theme text-white p-3">
                                            <i class="bi bi-bank mb-1"></i>
                                            <p class="text-muted small mb-1">
                                                Assets<br>Income
                                            </p>
                                            <p>$2542</p>
                                        </div>
                                    </div>
                                    <div class="col ps-0 align-self-center">
                                        <div class="row">
                                            <div class="col">
                                                <p class="text-secondary small mb-0">United States</p>
                                                <p>New York</p>
                                            </div>
                                            <div class="col-auto text-end">
                                                <p class="text-secondary small mb-0">New Sales</p>
                                                <p>120 orders</p>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <div class="progress h-5 mb-1 bg-light-theme">
                                                <div class="progress-bar bg-theme" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <p class="small text-secondary">Targeted Orders<span class="float-end">260</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!--charts category summary-->
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card border-0 mb-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-50 rounded-circle coverimg">
                                            <img src="https://getwindoors.com/html/assets/img/company7.jpg" alt="" />
                                        </figure>
                                    </div>
                                    <div class="col ps-0">
                                        <h4 class="mb-0">1.1541 <small class="h6">ETH</small></h4>
                                        <p class="small">36.00 <span class="text-green"><i class="bi bi-arrow-up fs-10"></i>3.15%</span></p>
                                    </div>
                                    <div class="col-auto">
                                        <div class="circle-small">
                                            <div id="circleprogressblue1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="smallchart65 cut-5 mb-2">
                                    <canvas id="areachartblue1"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card border-0 mb-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-50 rounded-circle coverimg">
                                            <img src="https://getwindoors.com/html/assets/img/company10.png" alt="" />
                                        </figure>
                                    </div>
                                    <div class="col ps-0">
                                        <h4 class="mb-0">12541 <small class="h6">ETC</small></h4>
                                        <p class="small">126.00 <span class="text-green"><i class="bi bi-arrow-up fs-10"></i>3.15%</span></p>
                                    </div>
                                    <div class="col-auto">
                                        <div class="circle-small">
                                            <div id="circleprogressgreen1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="smallchart65 cut-5 mb-2">
                                    <canvas id="areachartgreen1"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card border-0 mb-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-50 rounded-circle coverimg">
                                            <img src="https://getwindoors.com/html/assets/img/company9.jpg" alt="" />
                                        </figure>
                                    </div>
                                    <div class="col ps-0">
                                        <h4 class="mb-0">25.45 <small class="h6">XMR</small></h4>
                                        <p class="small">141.00 <span class="text-green"><i class="bi bi-arrow-up fs-10"></i>4.13%</span></p>
                                    </div>
                                    <div class="col-auto">
                                        <div class="circle-small">
                                            <div id="circleprogressyellow1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="smallchart65 cut-5 mb-2">
                                    <canvas id="areachartyellow1"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card border-0 mb-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-50 rounded-circle coverimg">
                                            <img src="https://getwindoors.com/html/assets/img/company8.jpg" alt="" />
                                        </figure>
                                    </div>
                                    <div class="col ps-0">
                                        <h4 class="mb-0">1132k <small class="h6">SHIB</small></h4>
                                        <p class="small">11.00 <span class="text-green"><i class="bi bi-arrow-up fs-10"></i>3.05%</span></p>
                                    </div>
                                    <div class="col-auto">
                                        <div class="circle-small">
                                            <div id="circleprogressred1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="smallchart65 cut-5 mb-2">
                                    <canvas id="areachartred1"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Tweet stats card -->
                    <div class="col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-3">
                        <div class="card border-0 bg-radial-gradiant text-white mb-4 mb-md-0">
                            <div class="card-header bg-none">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="bi bi-binoculars h5 avatar avatar-40 bg-light-white rounded"></i>
                                    </div>
                                    <div class="col">
                                        <h6 class="mb-0">Top Attraction</h6>
                                        <p class="text-muted">This year</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body bg-none">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="bi bi-twitter h1 avatar avatar-80 bg-cyan rounded mb-0">
                                        </i>
                                    </div>
                                    <div class="col">
                                        <p class="text-muted small mb-1">Engaged Audience</p>
                                        <h5 class="fw-medium">2,545,05</h5>
                                        <p class="small">(1.83%)</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-3">
                        <div class="card border-0 mb-4 mb-md-0">
                            <div class="card-body ">
                                <div class="row align-items-center mb-2">
                                    <div class="col-4 col-md-3 col-lg-4 col-xl-4 col-xxl-5">
                                        <figure class="coverimg rounded w-100 h-80 mb-0" style="background-image: url(&quot;assets/img/business-2.jpg&quot;);">
                                            <img src="assets/img/business-2.jpg" alt="" class="mw-100" style="display: none;">
                                        </figure>
                                    </div>
                                    <div class="col">
                                        <p class="text-secondary small">Boosted Post</p>
                                        <h5 class="fw-medium mb-0">2,545,05</h5>
                                        <p class="text-secondary small">People Reached</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col py-2">
                                        <p class="text-secondary small mb-0">Likes</p>
                                        <p>65.35 k</p>
                                    </div>
                                    <div class="col py-2">
                                        <p class="text-secondary small mb-0">Retweet</p>
                                        <p>12.5 k</p>
                                    </div>
                                    <div class="col py-2">
                                        <p class="text-secondary small mb-0">Clicks</p>
                                        <p>85.01 k</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--charts category summary-->
                    <div class="col-12 col-md-6 col-lg-6 col-xxl-3">
                        <div class="card border-0 mb-4 mb-md-0">
                            <div class="card-body">
                                <div class="row align-items-center mb-2">
                                    <div class="col-auto">
                                        <i class="bi bi-linkedin h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                                    </div>
                                    <div class="col">
                                        <div class="row mb-1">
                                            <div class="col">
                                                <p class="text-secondary small">Linkedin</p>
                                            </div>
                                            <div class="col-auto">
                                                <p class="text-red small">-1.58%</p>
                                            </div>
                                        </div>
                                        <h6 class="fw-medium">1.8m <small>Connections</small></h6>
                                    </div>
                                </div>
                                <div class="row align-items-center gx-3">
                                    <div class="col-5">
                                        <div class="smallchart80 ">
                                            <canvas id="areachartblue2"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="row gx-2">
                                            <div class="col-6 py-1">
                                                <p class="text-secondary small mb-0">Likes</p>
                                                <p>65.35 k</p>
                                            </div>
                                            <div class="col-6 py-1">
                                                <p class="text-secondary small mb-0">Shares</p>
                                                <p>12.5 k</p>
                                            </div>
                                            <div class="col-6 py-1">
                                                <p class="text-secondary small mb-0">Reach</p>
                                                <p>1.75 m</p>
                                            </div>
                                            <div class="col-6 py-1">
                                                <p class="text-secondary small mb-0">Clicks</p>
                                                <p>85.01 k</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-3">
                        <div class="card border-0 mb-4 mb-md-0">
                            <div class="card-body">
                                <div class="row align-items-center mb-2">
                                    <div class="col-auto">
                                        <i class="bi bi-twitter h5 avatar avatar-40 bg-light-cyan text-cyan rounded"></i>
                                    </div>
                                    <div class="col">
                                        <div class="row mb-1">
                                            <div class="col">
                                                <p class="text-secondary small">Linkedin</p>
                                            </div>
                                            <div class="col-auto">
                                                <p class="text-green small">2.15%</p>
                                            </div>
                                        </div>
                                        <h6 class="fw-medium">1.8m <small>Connections</small></h6>
                                    </div>
                                </div>
                                <div class="row align-items-center gx-3">
                                    <div class="col-5">
                                        <div class="smallchart80">
                                            <canvas id="areachartgreen2" width="108" height="90" style="display: block; box-sizing: border-box; height: 90px; width: 108px;"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="row gx-2">
                                            <div class="col-6 py-1">
                                                <p class="text-secondary small mb-0">Likes</p>
                                                <p>65.35 k</p>
                                            </div>
                                            <div class="col-6 py-1">
                                                <p class="text-secondary small mb-0">Shares</p>
                                                <p>12.5 k</p>
                                            </div>
                                            <div class="col-6 py-1">
                                                <p class="text-secondary small mb-0">Reach</p>
                                                <p>1.75 m</p>
                                            </div>
                                            <div class="col-6 py-1">
                                                <p class="text-secondary small mb-0">Clicks</p>
                                                <p>85.01 k</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <i class="bi bi-credit-card h5 avatar avatar-40 bg-light-theme rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0">Saved Cards</h6>
                        <p class="small text-secondary">Manage your credit cards</p>
                    </div>
                    <div class="col-auto">
                        <a href="profile-analytics.html" class="btn btn-link btn-sm"><i class="bi bi-plus vm me-2"></i>Add Credit Card</a>
                    </div>
                </div>

                <div class="swiper-container creditcardss">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="card border-0 mb-3 theme-blue">
                                <div class="card-body">
                                    <div class="row align-items-center mb-4">
                                        <div class="col-auto align-self-center">
                                            <img src="https://getwindoors.com/html/assets/img/visa.png" alt="">
                                        </div>
                                        <div class="col text-end">
                                            <p class="size-12">
                                                <span class="text-muted small">City Bank</span><br>
                                                <span class="">Credit Card</span>
                                            </p>
                                        </div>
                                    </div>
                                    <p class="fw-medium h6 mb-4">
                                        000 0000 0001 546598
                                    </p>
                                    <div class="row">
                                        <div class="col-auto size-12">
                                            <p class="mb-0 text-muted small">Expiry</p>
                                            <p>09/023</p>
                                        </div>
                                        <div class="col text-end size-12">
                                            <p class="mb-0 text-muted small">Card Holder</p>
                                            <p>Maxartkiller</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row amount-data">
                                <div class="col">
                                    <p class="text-secondary small mb-1">Expense</p>
                                    <p>1500.00 <small class="text-success">18.0% <i class="bi bi-arrow-up"></i></small></p>
                                </div>
                                <div class="col-auto text-end">
                                    <p class="text-secondary small mb-1">Limit Remain</p>
                                    <p>13500.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card border-0 theme-green mb-3">
                                <div class="card-body">
                                    <div class="row align-items-center mb-4">
                                        <div class="col-auto align-self-center">
                                            <img src="https://getwindoors.com/html/assets/img/visa.png" alt="">
                                        </div>
                                        <div class="col text-end">
                                            <p class="size-12">
                                                <span class="text-muted small">City Bank</span><br>
                                                <span class="">Credit Card</span>
                                            </p>
                                        </div>
                                    </div>
                                    <p class="fw-medium h6 mb-4">
                                        000 0000 0001 546598
                                    </p>
                                    <div class="row">
                                        <div class="col-auto size-12">
                                            <p class="mb-0 text-muted small">Expiry</p>
                                            <p>09/023</p>
                                        </div>
                                        <div class="col text-end size-12">
                                            <p class="mb-0 text-muted small">Card Holder</p>
                                            <p>Maxartkiller</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row amount-data">
                                <div class="col">
                                    <p class="text-secondary small mb-1">Expense</p>
                                    <p>3650.00 <small class="text-danger">11.0% <i class="bi bi-arrow-down"></i></small></p>
                                </div>
                                <div class="col-auto text-end">
                                    <p class="text-secondary small mb-1">Limit Remain</p>
                                    <p>35500.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card border-0 theme-purple mb-3">
                                <div class="card-body">
                                    <div class="row align-items-center mb-4">
                                        <div class="col-auto align-self-center">
                                            <img src="https://getwindoors.com/html/assets/img/visa.png" alt="">
                                        </div>
                                        <div class="col text-end">
                                            <p class="size-12">
                                                <span class="text-muted small">City Bank</span><br>
                                                <span class="">Credit Card</span>
                                            </p>
                                        </div>
                                    </div>
                                    <p class="fw-medium h6 mb-4">
                                        000 0000 0001 546598
                                    </p>
                                    <div class="row">
                                        <div class="col-auto size-12">
                                            <p class="mb-0 text-muted small">Expiry</p>
                                            <p>09/023</p>
                                        </div>
                                        <div class="col text-end size-12">
                                            <p class="mb-0 text-muted small">Card Holder</p>
                                            <p>Maxartkiller</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row amount-data">
                                <div class="col">
                                    <p class="text-secondary small mb-1">Expense</p>
                                    <p>1500.00 <small class="text-success">18.0 <i class="bi bi-arrow-up"></i></small></p>
                                </div>
                                <div class="col-auto text-end">
                                    <p class="text-secondary small mb-1">Limit Remain</p>
                                    <p>13500.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card border-0 mb-3 theme-red">
                                <div class="card-body">
                                    <div class="row align-items-center mb-4">
                                        <div class="col-auto align-self-center">
                                            <img src="https://getwindoors.com/html/assets/img/visa.png" alt="">
                                        </div>
                                        <div class="col text-end">
                                            <p class="size-12">
                                                <span class="text-muted small">City Bank</span><br>
                                                <span class="">Credit Card</span>
                                            </p>
                                        </div>
                                    </div>
                                    <p class="fw-medium h6 mb-4">
                                        000 0000 0001 546598
                                    </p>
                                    <div class="row">
                                        <div class="col-auto size-12">
                                            <p class="mb-0 text-muted small">Expiry</p>
                                            <p>09/023</p>
                                        </div>
                                        <div class="col text-end size-12">
                                            <p class="mb-0 text-muted small">Card Holder</p>
                                            <p>Maxartkiller</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row amount-data">
                                <div class="col">
                                    <p class="text-secondary small mb-1">Expense</p>
                                    <p>1500.00 <small class="text-success">18.0% <i class="bi bi-arrow-up"></i></small></p>
                                </div>
                                <div class="col-auto text-end">
                                    <p class="text-secondary small mb-1">Limit Remain</p>
                                    <p>13500.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card border-0 theme-cyan mb-3">
                                <div class="card-body">
                                    <div class="row align-items-center mb-4">
                                        <div class="col-auto align-self-center">
                                            <img src="https://getwindoors.com/html/assets/img/visa.png" alt="">
                                        </div>
                                        <div class="col text-end">
                                            <p class="size-12">
                                                <span class="text-muted small">City Bank</span><br>
                                                <span class="">Credit Card</span>
                                            </p>
                                        </div>
                                    </div>
                                    <p class="fw-medium h6 mb-4">
                                        000 0000 0001 546598
                                    </p>
                                    <div class="row">
                                        <div class="col-auto size-12">
                                            <p class="mb-0 text-muted small">Expiry</p>
                                            <p>09/023</p>
                                        </div>
                                        <div class="col text-end size-12">
                                            <p class="mb-0 text-muted small">Card Holder</p>
                                            <p>Maxartkiller</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row amount-data">
                                <div class="col">
                                    <p class="text-secondary small mb-1">Expense</p>
                                    <p>3650.00 <small class="text-danger">11.0% <i class="bi bi-arrow-down"></i></small></p>
                                </div>
                                <div class="col-auto text-end">
                                    <p class="text-secondary small mb-1">Limit Remain</p>
                                    <p>35500.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card border-0 theme-amber mb-3">
                                <div class="card-body">
                                    <div class="row align-items-center mb-4">
                                        <div class="col-auto align-self-center">
                                            <img src="https://getwindoors.com/html/assets/img/visa.png" alt="">
                                        </div>
                                        <div class="col text-end">
                                            <p class="size-12">
                                                <span class="text-muted small">City Bank</span><br>
                                                <span class="">Credit Card</span>
                                            </p>
                                        </div>
                                    </div>
                                    <p class="fw-medium h6 mb-4">
                                        000 0000 0001 546598
                                    </p>
                                    <div class="row">
                                        <div class="col-auto size-12">
                                            <p class="mb-0 text-muted small">Expiry</p>
                                            <p>09/023</p>
                                        </div>
                                        <div class="col text-end size-12">
                                            <p class="mb-0 text-muted small">Card Holder</p>
                                            <p>Maxartkiller</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row amount-data">
                                <div class="col">
                                    <p class="text-secondary small mb-1">Expense</p>
                                    <p>1500.00 <small class="text-success">18.0 <i class="bi bi-arrow-up"></i></small></p>
                                </div>
                                <div class="col-auto text-end">
                                    <p class="text-secondary small mb-1">Limit Remain</p>
                                    <p>13500.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>