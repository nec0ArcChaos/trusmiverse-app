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
        <div class="row mt-4">
            <div class="col-12 col-md-4 col-lg-4 col-xl-4 mb-4">
                <div class="card border-0 overflow-hidden">
                    <div class="coverimg h-110 w-100 top-0 start-0 position-absolute" style="background-image: url(&quot;<?= base_url(); ?>assets/img/bg-14.jpg&quot;);">
                        <img src="<?= base_url(); ?>assets/img/bg-14.jpg" alt="" style="display: none;">
                    </div>
                    <div class="row text-white mt-2 h-110">
                        <div class="col"></div>
                        <div class="col-auto text-end" style="margin-right: 10px;">
                            <p class="mb-1" style="font-size: 12pt;">
                                <img src="<?= base_url(); ?>assets/img/openweather-icon/light/04n@2x.png" alt="" class="vm me-0 tempimage" id="tempimage" style="max-width: 50px;margin-right: 10px !important;">
                                <span id="temperature" style="font-size: 12pt;">2.47</span><span class="text-uppercase" style="font-size: 12pt;"> <sup>0</sup>C</span>
                                <br>
                                <span class="fw-normal" id="city" style="font-size: 12pt;">Cirebon</span>
                            </p>
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="row align-items-start">
                            <div class="col-auto position-relative">
                                <figure class="avatar avatar-80 coverimg rounded-circle top-60 shadow-md" style="background-image: url(&quot;<?= base_url(); ?>assets/img/user-1.jpg&quot;);">
                                    <img src="<?= base_url(); ?>assets/img/user-1.jpg" alt="" style="display: none;">
                                </figure>
                            </div>
                            <div class="col">
                                <h5 class="m-0">Abdul Goffar</h5>
                                <p class="m-0"><span class="text-secondary small">General Manager Marketing</span></p>
                            </div>
                            <div class="row mt-3">
                                <div class="d-grid col-6">
                                    <button class="btn btn-outline-theme me-2"><i class="bi bi-telephone vm me-2"></i> Call</button>
                                </div>
                                <div class="d-grid col-6">
                                    <button class="btn btn-outline-theme"><i class="bi bi-chat-right-text vm me-2"></i> Chat</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-top-dashed">
                        <div class="row gx-2 justify-content-center align-items-center mb-2">
                            <p class="text-center" id="today"></p>
                            <div class="col-auto">
                                <small class="text-secondary">Hours</small>
                                <br>
                                <span id="hrs" class="display-6 fw-medium">14</span>
                            </div>
                            <div class="col-auto fw-medium">:</div>
                            <div class="col-auto">
                                <small class="text-secondary">Minutes</small>
                                <br>
                                <span id="min" class="display-6 fw-medium">19</span>
                            </div>
                            <div class="col-auto fw-medium">:</div>
                            <div class="col-auto">
                                <small class="text-secondary">seconds</small>
                                <br>
                                <span id="sec" class="display-6 fw-medium">5</span>
                            </div>

                            <div class="col-12 text-center">
                                <div class="tag bg-light-theme text-white theme-green mb-2 mt-2">Present</div>
                            </div>
                        </div>
                        <div class="row align-items-center">

                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 text-center">
                                <div class="card border-0 mb-3">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a data-fancybox="gallery" href="<?= base_url(); ?>assets/img/bg-14.jpg">
                                                    <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;<?= base_url(); ?>assets/img/bg-14.jpg&quot;);">
                                                        <img src="<?= base_url(); ?>assets/img/bg-14.jpg" alt="" id="userphotoonboarding2" style="display: none;">
                                                    </figure>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <p class="mb-0 small">Clock In</p>
                                                <p class="small text-secondary ">08:19</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 text-center">
                                <div class="card border-0 mb-3">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-auto">
                                                <a data-fancybox="gallery" href="<?= base_url(); ?>assets/img/bg-14.jpg">
                                                    <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;<?= base_url(); ?>assets/img/bg-14.jpg&quot;);">
                                                        <img src="<?= base_url(); ?>assets/img/bg-14.jpg" alt="" id="userphotoonboarding2" style="display: none;">
                                                    </figure>
                                                </a>
                                            </div>
                                            <div class="col-12 col-md">
                                                <p class="mb-0 small">Clock Out</p>
                                                <p class="small text-secondary ">17:19</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-top-dashed text-center">
                        <h4 class="text-start fw-bold mt-2">Performance :</h4>
                        <div class="d-flex justify-content-center mt-4 mb-4">
                            <div class="circle-medium">
                                <div id="circleprogressgreen">
                                    <svg viewBox="0 0 100 100" style="display: block; width: 100%;">
                                        <path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="rgba(120, 195, 0, 0.15)" stroke-width="10" fill-opacity="0"></path>
                                        <path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="rgb(145,195,0)" stroke-width="10" fill-opacity="0" style="stroke-dasharray: 282.783, 282.783; stroke-dashoffset: 42.4175;"></path>
                                    </svg>
                                </div>
                                <div class="avatar h4 bg-light-green rounded-circle">
                                    <b class="small">85%</b>
                                </div>
                            </div>
                        </div>
                        <p class="text-secondary">Your Grade :</p>
                        <p class="text-secondary">
                            <i class="text-success h3 bi bi-star-fill"></i>
                            <i class="text-success h3 bi bi-star-fill"></i>
                            <i class="text-success h3 bi bi-star-fill"></i>
                            <i class="text-success h3 bi bi-star-fill"></i>
                            <i class="h3 bi bi-star"></i>
                        </p>
                        <div class="tag bg-light-theme text-white theme-green mb-2">Excellence</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8 col-lg-8 col-xl-8">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                        <!-- Tambahan untuk KPI -->
                        <div class="card border-0 mb-4 card status-start border-card-status border-primary w-100" style="padding: 5px;">
                            <div class="card-header" style="padding: 5px;">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="bi bi-person-circle h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                                    </div>
                                    <div class="col ps-0">
                                        <h6 class="fw-medium mb-0">Key Performance Indicator</h6>
                                        <p class="text-secondary small">"If you can't measure it, you can't improve it."</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="padding: 5px;">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-4">
                                        <div class="card-body text-center">
                                            <div class="d-flex justify-content-center">
                                                <div class="circle-medium">
                                                    <div id="circleprogressgreen">
                                                        <svg viewBox="0 0 100 100" style="display: block; width: 100%;">
                                                            <path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="rgba(120, 195, 0, 0.15)" stroke-width="10" fill-opacity="0"></path>
                                                            <path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="rgb(145,195,0)" stroke-width="10" fill-opacity="0" style="stroke-dasharray: 282.783, 282.783; stroke-dashoffset: 42.4175;"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="avatar h4 bg-light-green rounded-circle">
                                                        <b class="small">85%</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-8">
                                        <div class="row align-items-center mb-1">
                                            <div class="col">
                                                <h6 class="title">Sasaran Kinerja</h6>
                                            </div>
                                        </div>
                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingOne">
                                                    <button class="accordion-button collapsed" style="padding: 5px;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                        #1 Revenue Booking - 45%
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        <p class="title m-0 p-0"><i class="bi bi-trophy text-muted"></i> Pemenuhan Target Booking</p>
                                                        <ul class="list-group list-group-flush bg-none">
                                                            <li class="list-group-item text-secondary">
                                                                <div class="row">
                                                                    <div class="col-auto">
                                                                        Target
                                                                    </div>
                                                                    <div class="col text-end ps-0">
                                                                        4000
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item text-secondary">
                                                                <div class="row">
                                                                    <div class="col-auto">
                                                                        Actual
                                                                    </div>
                                                                    <div class="col text-end ps-0">
                                                                        1800
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item text-secondary">
                                                                <div class="row">
                                                                    <div class="col-auto">
                                                                        Bobot
                                                                    </div>
                                                                    <div class="col text-end ps-0">
                                                                        45%
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item text-secondary">
                                                                <div class="row">
                                                                    <div class="col-auto">
                                                                        Nilai
                                                                    </div>
                                                                    <div class="col text-end ps-0">
                                                                        45%
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingTwo">
                                                    <button class="accordion-button collapsed" style="padding: 5px;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                                        #2 Revenue Akad - 40%
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingThree">
                                                    <button class="accordion-button collapsed" style="padding: 5px;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                                        #3 Revenue SDM - 5%
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="card border-0 mb-4 card status-start border-card-status border-warning w-100" style="padding: 5px;">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="bi bi-person-circle h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                                    </div>
                                    <div class="col ps-0">
                                        <h6 class="fw-medium mb-0">Konsistensi</h6>
                                        <p class="text-secondary small">"If you can't measure it, you can't improve it."</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="padding: 5px;">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-4">
                                        <div class="card-body text-center">
                                            <div class="d-flex justify-content-center mt-4 mb-4">
                                                <div class="circle-medium">
                                                    <div id="circleprogressgreen">
                                                        <svg viewBox="0 0 100 100" style="display: block; width: 100%;">
                                                            <path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="rgba(120, 195, 0, 0.15)" stroke-width="10" fill-opacity="0"></path>
                                                            <path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="rgb(145,195,0)" stroke-width="10" fill-opacity="0" style="stroke-dasharray: 282.783, 282.783; stroke-dashoffset: 42.4175;"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="avatar h4 bg-light-green rounded-circle">
                                                        <b class="small">85%</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-8">
                                        <div class="row align-items-center mb-1">
                                            <div class="col">
                                                <h6 class="title">Sasaran Kinerja</h6>
                                            </div>
                                        </div>
                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingOne">
                                                    <button class="accordion-button collapsed" style="padding: 5px;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                        #1 Revenue Booking - 45%
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        <p class="title m-0 p-0"><i class="bi bi-trophy text-muted"></i> Pemenuhan Target Booking</p>
                                                        <ul class="list-group list-group-flush bg-none">
                                                            <li class="list-group-item text-secondary">
                                                                <div class="row">
                                                                    <div class="col-auto">
                                                                        Target
                                                                    </div>
                                                                    <div class="col text-end ps-0">
                                                                        4000
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item text-secondary">
                                                                <div class="row">
                                                                    <div class="col-auto">
                                                                        Actual
                                                                    </div>
                                                                    <div class="col text-end ps-0">
                                                                        1800
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item text-secondary">
                                                                <div class="row">
                                                                    <div class="col-auto">
                                                                        Bobot
                                                                    </div>
                                                                    <div class="col text-end ps-0">
                                                                        45%
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item text-secondary">
                                                                <div class="row">
                                                                    <div class="col-auto">
                                                                        Nilai
                                                                    </div>
                                                                    <div class="col text-end ps-0">
                                                                        45%
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingTwo">
                                                    <button class="accordion-button collapsed" style="padding: 5px;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                                        #2 Revenue Akad - 40%
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingThree">
                                                    <button class="accordion-button collapsed" style="padding: 5px;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                                        #3 Revenue SDM - 5%
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="card border-0 mb-4 card status-start border-card-status border-danger w-100" style="padding: 5px;">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="bi bi-person-circle h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                                    </div>
                                    <div class="col ps-0">
                                        <h6 class="fw-medium mb-0">Standar</h6>
                                        <p class="text-secondary small">"If you can't measure it, you can't improve it."</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="padding: 5px;">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-4">
                                        <div class="card-body text-center">
                                            <div class="d-flex justify-content-center mt-4 mb-4">
                                                <div class="circle-medium">
                                                    <div id="circleprogressgreen">
                                                        <svg viewBox="0 0 100 100" style="display: block; width: 100%;">
                                                            <path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="rgba(120, 195, 0, 0.15)" stroke-width="10" fill-opacity="0"></path>
                                                            <path d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90" stroke="rgb(145,195,0)" stroke-width="10" fill-opacity="0" style="stroke-dasharray: 282.783, 282.783; stroke-dashoffset: 42.4175;"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="avatar h4 bg-light-green rounded-circle">
                                                        <b class="small">85%</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-8">
                                        <div class="row align-items-center mb-1">
                                            <div class="col">
                                                <h6 class="title">Sasaran Kinerja</h6>
                                            </div>
                                        </div>
                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingOne">
                                                    <button class="accordion-button collapsed" style="padding: 5px;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                        #1 Revenue Booking - 45%
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        <p class="title m-0 p-0"><i class="bi bi-trophy text-muted"></i> Pemenuhan Target Booking</p>
                                                        <ul class="list-group list-group-flush bg-none">
                                                            <li class="list-group-item text-secondary">
                                                                <div class="row">
                                                                    <div class="col-auto">
                                                                        Target
                                                                    </div>
                                                                    <div class="col text-end ps-0">
                                                                        4000
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item text-secondary">
                                                                <div class="row">
                                                                    <div class="col-auto">
                                                                        Actual
                                                                    </div>
                                                                    <div class="col text-end ps-0">
                                                                        1800
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item text-secondary">
                                                                <div class="row">
                                                                    <div class="col-auto">
                                                                        Bobot
                                                                    </div>
                                                                    <div class="col text-end ps-0">
                                                                        45%
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item text-secondary">
                                                                <div class="row">
                                                                    <div class="col-auto">
                                                                        Nilai
                                                                    </div>
                                                                    <div class="col text-end ps-0">
                                                                        45%
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingTwo">
                                                    <button class="accordion-button collapsed" style="padding: 5px;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                                        #2 Revenue Akad - 40%
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingThree">
                                                    <button class="accordion-button collapsed" style="padding: 5px;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                                        #3 Revenue SDM - 5%
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>










            </div>



            <!-- <div class="col-12 col-md-6 col-lg-6 col-xl-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center text-center mx-0">
                            <div class="col-auto">
                                <button class="btn btn-sm btn-square btn-link">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                            </div>
                            <div class="col">
                                <h6>June 2022</h6>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-sm btn-square btn-link">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                        <div class="swiper swiperauto dateselect my-1">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Sun</p>
                                    <div class="avatar avatar-30 rounded-circle">1</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Mon</p>
                                    <div class="avatar avatar-30 rounded-circle">2</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Tue</p>
                                    <div class="avatar avatar-30 rounded-circle">3</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Wed</p>
                                    <div class="avatar avatar-30 rounded-circle">4</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Thu</p>
                                    <div class="avatar avatar-30 rounded-circle">5</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Fri</p>
                                    <div class="avatar avatar-30 rounded-circle">6</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Sat</p>
                                    <div class="avatar avatar-30 rounded-circle">7</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Sun</p>
                                    <div class="avatar avatar-30 rounded-circle">8</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Mon</p>
                                    <div class="avatar avatar-30 rounded-circle">9</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Tue</p>
                                    <div class="avatar avatar-30 rounded-circle">10</div>
                                </div>
                                <div class="swiper-slide text-center active">
                                    <p class="small text-secondary text-uppercase">Wed</p>
                                    <div class="avatar avatar-30 rounded-circle">11</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Thu</p>
                                    <div class="avatar avatar-30 rounded-circle">12</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Fri</p>
                                    <div class="avatar avatar-30 rounded-circle">13</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Sat</p>
                                    <div class="avatar avatar-30 rounded-circle">14</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Sun</p>
                                    <div class="avatar avatar-30 rounded-circle">15</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Mon</p>
                                    <div class="avatar avatar-30 rounded-circle">16</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Tue</p>
                                    <div class="avatar avatar-30 rounded-circle">17</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Wed</p>
                                    <div class="avatar avatar-30 rounded-circle">18</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Thu</p>
                                    <div class="avatar avatar-30 rounded-circle">19</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Fri</p>
                                    <div class="avatar avatar-30 rounded-circle">20</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Sat</p>
                                    <div class="avatar avatar-30 rounded-circle">21</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Sun</p>
                                    <div class="avatar avatar-30 rounded-circle">22</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Mon</p>
                                    <div class="avatar avatar-30 rounded-circle">23</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Tue</p>
                                    <div class="avatar avatar-30 rounded-circle">24</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Wed</p>
                                    <div class="avatar avatar-30 rounded-circle">25</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Thu</p>
                                    <div class="avatar avatar-30 rounded-circle">26</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Fri</p>
                                    <div class="avatar avatar-30 rounded-circle">27</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Sat</p>
                                    <div class="avatar avatar-30 rounded-circle">28</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Sun</p>
                                    <div class="avatar avatar-30 rounded-circle">29</div>
                                </div>
                                <div class="swiper-slide text-center">
                                    <p class="small text-secondary text-uppercase">Mon</p>
                                    <div class="avatar avatar-30 rounded-circle">30</div>
                                </div>

                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gx-2 justify-content-center align-items-center mb-2">
                            <p class="text-center" id="today"></p>
                            <div class="col-auto">
                                <small class="text-secondary">Hours</small>
                                <br>
                                <span id="hrs" class="display-6 fw-medium">14</span>
                            </div>
                            <div class="col-auto fw-medium">:</div>
                            <div class="col-auto">
                                <small class="text-secondary">Minutes</small>
                                <br>
                                <span id="min" class="display-6 fw-medium">19</span>
                            </div>
                            <div class="col-auto fw-medium">:</div>
                            <div class="col-auto">
                                <small class="text-secondary">seconds</small>
                                <br>
                                <span id="sec" class="display-6 fw-medium">5</span>
                            </div>

                            <div class="col-12 text-center">
                                <div class="tag bg-light-theme text-white theme-green mb-2 mt-2">Present</div>
                            </div>
                        </div>
                        <div class="row align-items-center">

                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 text-center">
                                <div class="card border-0 mb-3">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a data-fancybox="gallery" href="<?= base_url(); ?>assets/img/bg-14.jpg">
                                                    <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;<?= base_url(); ?>assets/img/bg-14.jpg&quot;);">
                                                        <img src="<?= base_url(); ?>assets/img/bg-14.jpg" alt="" id="userphotoonboarding2" style="display: none;">
                                                    </figure>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <p class="mb-0 small">Clock In</p>
                                                <p class="small text-secondary ">08:19</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 text-center">
                                <div class="card border-0 mb-3">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-auto">
                                                <a data-fancybox="gallery" href="<?= base_url(); ?>assets/img/bg-14.jpg">
                                                    <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;<?= base_url(); ?>assets/img/bg-14.jpg&quot;);">
                                                        <img src="<?= base_url(); ?>assets/img/bg-14.jpg" alt="" id="userphotoonboarding2" style="display: none;">
                                                    </figure>
                                                </a>
                                            </div>
                                            <div class="col-12 col-md">
                                                <p class="mb-0 small">Clock Out</p>
                                                <p class="small text-secondary ">17:19</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> -->
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border-0 mb-4 status-start border-card-status border-primary w-100">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-calendar-week h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                            </div>
                            <div class="col ps-0">
                                <h6 class="fw-medium mb-0">Calendar</h6>
                                <p class="text-secondary small">"The calendar is a roadmap, and your goals are the destination."</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <!-- Start -->
                        <div class="inner-sidebar-wrap border-bottom">
                            <div class="inner-sidebar-content">
                                <div id="calendarNew" class="fc fc-media-screen fc-direction-ltr fc-theme-standard">
                                    <div class="fc-header-toolbar fc-toolbar fc-toolbar-ltr">
                                        <div class="fc-toolbar-chunk">
                                            <div class="fc-button-group"><button type="button" title="Previous month" aria-pressed="false" class="fc-prev-button fc-button fc-button-primary"><span class="fc-icon fc-icon-chevron-left"></span></button><button type="button" title="Next month" aria-pressed="false" class="fc-next-button fc-button fc-button-primary"><span class="fc-icon fc-icon-chevron-right"></span></button></div>
                                        </div>
                                        <div class="fc-toolbar-chunk">
                                            <h2 class="fc-toolbar-title" id="fc-dom-1">January 2024</h2>
                                        </div>
                                        <div class="fc-toolbar-chunk"><button type="button" title="This month" disabled="" aria-pressed="false" class="fc-today-button fc-button fc-button-primary">today</button>
                                            <div class="fc-button-group"><button type="button" title="month view" aria-pressed="true" class="fc-dayGridMonth-button fc-button fc-button-primary fc-button-active">month</button><button type="button" title="week view" aria-pressed="false" class="fc-timeGridWeek-button fc-button fc-button-primary">week</button><button type="button" title="day view" aria-pressed="false" class="fc-timeGridDay-button fc-button fc-button-primary">day</button></div>
                                        </div>
                                    </div>
                                    <div aria-labelledby="fc-dom-1" class="fc-view-harness fc-view-harness-active" style="height: 321.481px;">
                                        <div class="fc-daygrid fc-dayGridMonth-view fc-view">
                                            <table role="grid" class="fc-scrollgrid  fc-scrollgrid-liquid">
                                                <thead role="rowgroup">
                                                    <tr role="presentation" class="fc-scrollgrid-section fc-scrollgrid-section-header ">
                                                        <th role="presentation">
                                                            <div class="fc-scroller-harness">
                                                                <div class="fc-scroller" style="overflow: hidden scroll;">
                                                                    <table role="presentation" class="fc-col-header " style="width: 428px;">
                                                                        <colgroup></colgroup>
                                                                        <thead role="presentation">
                                                                            <tr role="row">
                                                                                <th role="columnheader" class="fc-col-header-cell fc-day fc-day-sun">
                                                                                    <div class="fc-scrollgrid-sync-inner"><a aria-label="Sunday" class="fc-col-header-cell-cushion ">Sun</a></div>
                                                                                </th>
                                                                                <th role="columnheader" class="fc-col-header-cell fc-day fc-day-mon">
                                                                                    <div class="fc-scrollgrid-sync-inner"><a aria-label="Monday" class="fc-col-header-cell-cushion ">Mon</a></div>
                                                                                </th>
                                                                                <th role="columnheader" class="fc-col-header-cell fc-day fc-day-tue">
                                                                                    <div class="fc-scrollgrid-sync-inner"><a aria-label="Tuesday" class="fc-col-header-cell-cushion ">Tue</a></div>
                                                                                </th>
                                                                                <th role="columnheader" class="fc-col-header-cell fc-day fc-day-wed">
                                                                                    <div class="fc-scrollgrid-sync-inner"><a aria-label="Wednesday" class="fc-col-header-cell-cushion ">Wed</a></div>
                                                                                </th>
                                                                                <th role="columnheader" class="fc-col-header-cell fc-day fc-day-thu">
                                                                                    <div class="fc-scrollgrid-sync-inner"><a aria-label="Thursday" class="fc-col-header-cell-cushion ">Thu</a></div>
                                                                                </th>
                                                                                <th role="columnheader" class="fc-col-header-cell fc-day fc-day-fri">
                                                                                    <div class="fc-scrollgrid-sync-inner"><a aria-label="Friday" class="fc-col-header-cell-cushion ">Fri</a></div>
                                                                                </th>
                                                                                <th role="columnheader" class="fc-col-header-cell fc-day fc-day-sat">
                                                                                    <div class="fc-scrollgrid-sync-inner"><a aria-label="Saturday" class="fc-col-header-cell-cushion ">Sat</a></div>
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody role="rowgroup">
                                                    <tr role="presentation" class="fc-scrollgrid-section fc-scrollgrid-section-body  fc-scrollgrid-section-liquid">
                                                        <td role="presentation">
                                                            <div class="fc-scroller-harness fc-scroller-harness-liquid">
                                                                <div class="fc-scroller fc-scroller-liquid-absolute" style="overflow: hidden scroll;">
                                                                    <div class="fc-daygrid-body fc-daygrid-body-unbalanced " style="width: 428px;">
                                                                        <table role="presentation" class="fc-scrollgrid-sync-table" style="width: 428px; height: 257px;">
                                                                            <colgroup></colgroup>
                                                                            <tbody role="presentation">
                                                                                <tr role="row">
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-past fc-day-other" data-date="2023-12-31" aria-labelledby="fc-dom-2">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-2" class="fc-daygrid-day-number" aria-label="December 31, 2023">31</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a class="fc-daygrid-event fc-daygrid-block-event fc-h-event fc-event fc-event-start fc-event-end fc-event-past task-event cursor-pointer" tabindex="0">
                                                                                                        <div class="fc-event-main">
                                                                                                            <div class="fc-event-main-frame">
                                                                                                                <div class="fc-event-title-container">
                                                                                                                    <div class="fc-event-title fc-sticky">10 Act</div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </a></div>
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-past" data-date="2024-01-01" aria-labelledby="fc-dom-4">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-4" class="fc-daygrid-day-number" aria-label="January 1, 2024">1</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a class="fc-daygrid-event fc-daygrid-block-event fc-h-event fc-event fc-event-start fc-event-end fc-event-past task-event cursor-pointer" tabindex="0">
                                                                                                        <div class="fc-event-main">
                                                                                                            <div class="fc-event-main-frame">
                                                                                                                <div class="fc-event-title-container">
                                                                                                                    <div class="fc-event-title fc-sticky">10 Act</div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </a></div>
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-past" data-date="2024-01-02" aria-labelledby="fc-dom-6">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-6" class="fc-daygrid-day-number" aria-label="January 2, 2024">2</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a class="fc-daygrid-event fc-daygrid-block-event fc-h-event fc-event fc-event-start fc-event-end fc-event-past task-event cursor-pointer" tabindex="0">
                                                                                                        <div class="fc-event-main">
                                                                                                            <div class="fc-event-main-frame">
                                                                                                                <div class="fc-event-title-container">
                                                                                                                    <div class="fc-event-title fc-sticky">10 Act</div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </a></div>
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-past" data-date="2024-01-03" aria-labelledby="fc-dom-8">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-8" class="fc-daygrid-day-number" aria-label="January 3, 2024">3</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a class="fc-daygrid-event fc-daygrid-block-event fc-h-event fc-event fc-event-start fc-event-end fc-event-past task-event cursor-pointer" tabindex="0">
                                                                                                        <div class="fc-event-main">
                                                                                                            <div class="fc-event-main-frame">
                                                                                                                <div class="fc-event-title-container">
                                                                                                                    <div class="fc-event-title fc-sticky">10 Act</div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </a></div>
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-past" data-date="2024-01-04" aria-labelledby="fc-dom-10">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-10" class="fc-daygrid-day-number" aria-label="January 4, 2024">4</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a class="fc-daygrid-event fc-daygrid-block-event fc-h-event fc-event fc-event-start fc-event-end fc-event-past task-event cursor-pointer" tabindex="0">
                                                                                                        <div class="fc-event-main">
                                                                                                            <div class="fc-event-main-frame">
                                                                                                                <div class="fc-event-title-container">
                                                                                                                    <div class="fc-event-title fc-sticky">10 Act</div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </a></div>
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-past" data-date="2024-01-05" aria-labelledby="fc-dom-12">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-12" class="fc-daygrid-day-number" aria-label="January 5, 2024">5</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a class="fc-daygrid-event fc-daygrid-block-event fc-h-event fc-event fc-event-start fc-event-end fc-event-past task-event cursor-pointer" tabindex="0">
                                                                                                        <div class="fc-event-main">
                                                                                                            <div class="fc-event-main-frame">
                                                                                                                <div class="fc-event-title-container">
                                                                                                                    <div class="fc-event-title fc-sticky">10 Act</div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </a></div>
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-past" data-date="2024-01-06" aria-labelledby="fc-dom-14">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-14" class="fc-daygrid-day-number" aria-label="January 6, 2024">6</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a class="fc-daygrid-event fc-daygrid-block-event fc-h-event fc-event fc-event-start fc-event-end fc-event-past task-event cursor-pointer" tabindex="0">
                                                                                                        <div class="fc-event-main">
                                                                                                            <div class="fc-event-main-frame">
                                                                                                                <div class="fc-event-title-container">
                                                                                                                    <div class="fc-event-title fc-sticky">10 Act</div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </a></div>
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr role="row">
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-past" data-date="2024-01-07" aria-labelledby="fc-dom-16">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-16" class="fc-daygrid-day-number" aria-label="January 7, 2024">7</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a class="fc-daygrid-event fc-daygrid-block-event fc-h-event fc-event fc-event-start fc-event-end fc-event-past task-event cursor-pointer" tabindex="0">
                                                                                                        <div class="fc-event-main">
                                                                                                            <div class="fc-event-main-frame">
                                                                                                                <div class="fc-event-title-container">
                                                                                                                    <div class="fc-event-title fc-sticky">10 Act</div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </a></div>
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-past" data-date="2024-01-08" aria-labelledby="fc-dom-18">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-18" class="fc-daygrid-day-number" aria-label="January 8, 2024">8</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a class="fc-daygrid-event fc-daygrid-block-event fc-h-event fc-event fc-event-start fc-event-end fc-event-past task-event cursor-pointer" tabindex="0">
                                                                                                        <div class="fc-event-main">
                                                                                                            <div class="fc-event-main-frame">
                                                                                                                <div class="fc-event-title-container">
                                                                                                                    <div class="fc-event-title fc-sticky">10 Act</div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </a></div>
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-past" data-date="2024-01-09" aria-labelledby="fc-dom-20">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-20" class="fc-daygrid-day-number" aria-label="January 9, 2024">9</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a class="fc-daygrid-event fc-daygrid-block-event fc-h-event fc-event fc-event-start fc-event-end task-event cursor-pointer" tabindex="0">
                                                                                                        <div class="fc-event-main">
                                                                                                            <div class="fc-event-main-frame">
                                                                                                                <div class="fc-event-title-container">
                                                                                                                    <div class="fc-event-title fc-sticky">10 Act</div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </a></div>
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-today " data-date="2024-01-10" aria-labelledby="fc-dom-22">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-22" class="fc-daygrid-day-number" aria-label="January 10, 2024">10</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a class="fc-daygrid-event fc-daygrid-block-event fc-h-event fc-event fc-event-start fc-event-end fc-event-today task-event cursor-pointer" tabindex="0">
                                                                                                        <div class="fc-event-main">
                                                                                                            <div class="fc-event-main-frame">
                                                                                                                <div class="fc-event-title-container">
                                                                                                                    <div class="fc-event-title fc-sticky">10 Act</div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </a></div>
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-future" data-date="2024-01-11" aria-labelledby="fc-dom-24">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-24" class="fc-daygrid-day-number" aria-label="January 11, 2024">11</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a class="fc-daygrid-event fc-daygrid-block-event fc-h-event fc-event fc-event-start fc-event-end fc-event-future task-event cursor-pointer" tabindex="0">
                                                                                                        <div class="fc-event-main">
                                                                                                            <div class="fc-event-main-frame">
                                                                                                                <div class="fc-event-title-container">
                                                                                                                    <div class="fc-event-title fc-sticky">10 Act</div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </a></div>
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-future" data-date="2024-01-12" aria-labelledby="fc-dom-26">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-26" class="fc-daygrid-day-number" aria-label="January 12, 2024">12</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a class="fc-daygrid-event fc-daygrid-block-event fc-h-event fc-event fc-event-start fc-event-end fc-event-future task-event cursor-pointer" tabindex="0">
                                                                                                        <div class="fc-event-main">
                                                                                                            <div class="fc-event-main-frame">
                                                                                                                <div class="fc-event-title-container">
                                                                                                                    <div class="fc-event-title fc-sticky">10 Act</div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </a></div>
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-future" data-date="2024-01-13" aria-labelledby="fc-dom-28">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-28" class="fc-daygrid-day-number" aria-label="January 13, 2024">13</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a class="fc-daygrid-event fc-daygrid-block-event fc-h-event fc-event fc-event-start fc-event-end fc-event-future task-event cursor-pointer" tabindex="0">
                                                                                                        <div class="fc-event-main">
                                                                                                            <div class="fc-event-main-frame">
                                                                                                                <div class="fc-event-title-container">
                                                                                                                    <div class="fc-event-title fc-sticky">10 Act</div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </a></div>
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr role="row">
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-future" data-date="2024-01-14" aria-labelledby="fc-dom-30">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-30" class="fc-daygrid-day-number" aria-label="January 14, 2024">14</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-future" data-date="2024-01-15" aria-labelledby="fc-dom-32">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-32" class="fc-daygrid-day-number" aria-label="January 15, 2024">15</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-future" data-date="2024-01-16" aria-labelledby="fc-dom-34">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-34" class="fc-daygrid-day-number" aria-label="January 16, 2024">16</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-future" data-date="2024-01-17" aria-labelledby="fc-dom-36">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-36" class="fc-daygrid-day-number" aria-label="January 17, 2024">17</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-future" data-date="2024-01-18" aria-labelledby="fc-dom-38">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-38" class="fc-daygrid-day-number" aria-label="January 18, 2024">18</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-future" data-date="2024-01-19" aria-labelledby="fc-dom-40">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-40" class="fc-daygrid-day-number" aria-label="January 19, 2024">19</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-future" data-date="2024-01-20" aria-labelledby="fc-dom-42">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-42" class="fc-daygrid-day-number" aria-label="January 20, 2024">20</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr role="row">
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-future" data-date="2024-01-21" aria-labelledby="fc-dom-44">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-44" class="fc-daygrid-day-number" aria-label="January 21, 2024">21</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-future" data-date="2024-01-22" aria-labelledby="fc-dom-46">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-46" class="fc-daygrid-day-number" aria-label="January 22, 2024">22</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-future" data-date="2024-01-23" aria-labelledby="fc-dom-48">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-48" class="fc-daygrid-day-number" aria-label="January 23, 2024">23</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-future" data-date="2024-01-24" aria-labelledby="fc-dom-50">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-50" class="fc-daygrid-day-number" aria-label="January 24, 2024">24</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-future" data-date="2024-01-25" aria-labelledby="fc-dom-52">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-52" class="fc-daygrid-day-number" aria-label="January 25, 2024">25</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-future" data-date="2024-01-26" aria-labelledby="fc-dom-54">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-54" class="fc-daygrid-day-number" aria-label="January 26, 2024">26</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-future" data-date="2024-01-27" aria-labelledby="fc-dom-56">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-56" class="fc-daygrid-day-number" aria-label="January 27, 2024">27</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr role="row">
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-future" data-date="2024-01-28" aria-labelledby="fc-dom-58">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-58" class="fc-daygrid-day-number" aria-label="January 28, 2024">28</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-future" data-date="2024-01-29" aria-labelledby="fc-dom-60">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-60" class="fc-daygrid-day-number" aria-label="January 29, 2024">29</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-future" data-date="2024-01-30" aria-labelledby="fc-dom-62">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-62" class="fc-daygrid-day-number" aria-label="January 30, 2024">30</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-future" data-date="2024-01-31" aria-labelledby="fc-dom-64">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-64" class="fc-daygrid-day-number" aria-label="January 31, 2024">31</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-future fc-day-other" data-date="2024-02-01" aria-labelledby="fc-dom-66">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-66" class="fc-daygrid-day-number" aria-label="February 1, 2024">1</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-future fc-day-other" data-date="2024-02-02" aria-labelledby="fc-dom-68">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-68" class="fc-daygrid-day-number" aria-label="February 2, 2024">2</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-future fc-day-other" data-date="2024-02-03" aria-labelledby="fc-dom-70">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-70" class="fc-daygrid-day-number" aria-label="February 3, 2024">3</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr role="row">
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-future fc-day-other" data-date="2024-02-04" aria-labelledby="fc-dom-72">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-72" class="fc-daygrid-day-number" aria-label="February 4, 2024">4</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-future fc-day-other" data-date="2024-02-05" aria-labelledby="fc-dom-74">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-74" class="fc-daygrid-day-number" aria-label="February 5, 2024">5</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-future fc-day-other" data-date="2024-02-06" aria-labelledby="fc-dom-76">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-76" class="fc-daygrid-day-number" aria-label="February 6, 2024">6</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-future fc-day-other" data-date="2024-02-07" aria-labelledby="fc-dom-78">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-78" class="fc-daygrid-day-number" aria-label="February 7, 2024">7</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-future fc-day-other" data-date="2024-02-08" aria-labelledby="fc-dom-80">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-80" class="fc-daygrid-day-number" aria-label="February 8, 2024">8</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-future fc-day-other" data-date="2024-02-09" aria-labelledby="fc-dom-82">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-82" class="fc-daygrid-day-number" aria-label="February 9, 2024">9</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-future fc-day-other" data-date="2024-02-10" aria-labelledby="fc-dom-84">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a id="fc-dom-84" class="fc-daygrid-day-number" aria-label="February 10, 2024">10</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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