<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Problem | Thinking with AI | Solution</p>
            </div>
            <div class="col col-sm-auto">
                <form method="POST" id="form_filter">
                    <div class="input-group input-group-md reportrange">
                        <input type="text" class="form-control range bg-none px-0" style="cursor: pointer;" id="titlecalendar">
                        <input type="hidden" name="start" value="" id="start" readonly />
                        <input type="hidden" name="end" value="" id="end" readonly />
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
                            <i class="bi bi-lightbulb-fill h5 avatar avatar-40 bg-red text-white rounded"></i>
                        </div>
                        <div class="col-auto align-self-center">
                            <h6 class="fw-medium mb-0">List Problem Solving</h6>
                        </div>
                        <div class="col-auto ms-auto ps-0">
                            <button type="button" class="btn btn-md btn-danger rounded text-white custom-bg-red" onclick="add_problem()"><i class="bi bi-plus"></i> Problem Solving</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" style="padding: 10px;">
                        <table id="dt_list_problem" class="table table-striped dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No PS</th>
                                    <th>Problem</th>
                                    <th>Answer AI</th>
                                    <th>Why 1</th>
                                    <th>Answer AI</th>
                                    <th>Why 2</th>
                                    <th>Answer AI</th>
                                    <th>Why 3</th>
                                    <th>Answer AI</th>
                                    <th>Why 4</th>
                                    <th>Answer AI</th>
                                    <th>Why 5</th>
                                    <th>Answer AI</th>
                                    <th>Solving</th>
                                    <th>Created By</th>
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

<!-- Modal Add -->
<div class="modal fade" id="modal_add_problem" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">            
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-lightbulb-fill h5 avatar avatar-40 bg-red text-white rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="modalAddLabel">AI 5 Why Analysis</h6>
                    <p class="text-secondary small">Proses Problem Solving</p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form id="form_problem">
                    <input type="hidden" name="id_mom" id="id_mom">
                    <input type="hidden" name="id_issue" id="id_issue">
                    <input type="hidden" name="no_ps" id="no_ps">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4">
                            <div class="card border-0 mb-4">
                                <div class="card-body">
                                    <h6 class="fw-medium">Problem</h6>
                                    <p class="text-secondary" id="side_problem">...</p>
                                    <hr />
                                    <h6 class="fw-medium">Why 1</h6>
                                    <p class="text-secondary" id="side_why1">...</p>
                                    <hr />
                                    <h6 class="fw-medium">Why 2</h6>
                                    <p class="text-secondary" id="side_why2">...</p>
                                    <hr />
                                    <h6 class="fw-medium">Why 3</h6>
                                    <p class="text-secondary" id="side_why3">...</p>
                                    <hr />
                                    <h6 class="fw-medium">Why 4</h6>
                                    <p class="text-secondary" id="side_why4">...</p>
                                    <hr />
                                    <h6 class="fw-medium">Why 5</h6>
                                    <p class="text-secondary" id="side_why5">...</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8 mb-4">
                            <div class="row">
                                <div class="col-12">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="problem-tab" data-step="1" data-bs-toggle="tab" data-bs-target="#problem" type="button" role="tab" aria-controls="problem" aria-selected="true">Problem</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="why1-tab" data-step="2" data-bs-toggle="tab" data-bs-target="#why1" type="button" role="tab" aria-controls="why1" aria-selected="false">Why 1</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="why2-tab" data-step="3" data-bs-toggle="tab" data-bs-target="#why2" type="button" role="tab" aria-controls="why2" aria-selected="false">Why 2</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="why3-tab" data-step="4" data-bs-toggle="tab" data-bs-target="#why3" type="button" role="tab" aria-controls="why3" aria-selected="false">Why 3</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="why4-tab" data-step="5" data-bs-toggle="tab" data-bs-target="#why4" type="button" role="tab" aria-controls="why4" aria-selected="false">Why 4</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="why5-tab" data-step="6" data-bs-toggle="tab" data-bs-target="#why5" type="button" role="tab" aria-controls="why5" aria-selected="false">Why 5</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="solving-tab" data-step="7" data-bs-toggle="tab" data-bs-target="#solving" type="button" role="tab" aria-controls="solving" aria-selected="false">Solving</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="problem" role="tabpanel" aria-labelledby="problem-tab">
                                            <div class="row">
                                                <div class="col-12 mt-4">
                                                    <div class="form-group">
                                                        <h6 class="fw-medium">Step 1 - Problem</h6>
                                                        <div class="d-flex justify-content-center">
                                                            <img src="<?= base_url('assets/img/asking-question.png') ?>" alt="Orang Sedang Berpikir" class="img-fluid mb-3">
                                                        </div>
                                                        <p class="text-center">Tuliskan permasalahan yang sedang Anda hadapi, dan mari kita analisis bersama dengan pendekatan coaching dan analitical thingking yang terstruktur</p>
                                                        <div class="row justify-content-between mt-5">
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 mb-3">
                                                                <textarea class="form-control" id="input_problem" name="input_problem" placeholder="Tuliskan masalah yang ingin anda selesaikan!" rows="2"></textarea>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 text-md-end">
                                                                <button type="button" class="btn btn-danger rounded text-white custom-bg-red w-100 w-md-auto btn-next" onclick="next_problem('1')">Selanjutnya <i class="bi bi-arrow-right"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="why1" role="tabpanel" aria-labelledby="why1-tab">
                                            <div class="row">
                                                <div class="col-12 mt-4">
                                                    <div class="form-group">
                                                        <h6 class="fw-medium">Step 2</h6>
                                                        <div class="d-flex justify-content-start mb-3">
                                                            <div class="rounded p-2" style="background-color: #e5e5e5;">
                                                                <p class="text-center mb-0" id="why1_text">...</p>
                                                            </div>
                                                        </div>
                                                        <p class="text-start">Sebelum kita membedah masalah lebih jauh, penting untuk memahami situasi secara obyektif. Kita akan mulai dengan mengidentifikasi fakta-fakta yang relevan</p>
                                                        <br>
                                                        <div id="why1_jawaban" class="h5 fw-bold"></div>
                                                        <br>
                                                        <div class="row justify-content-between mt-5">
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 mb-3">
                                                                <textarea class="form-control" id="input_why1" name="input_why1" placeholder="Tuliskan akar masalah dari analisa yang dihasilkan!" rows="2"></textarea>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 text-md-end">
                                                                <button type="button" class="btn btn-danger rounded text-white custom-bg-red w-100 w-md-auto btn-next" onclick="next_problem('2')">Selanjutnya <i class="bi bi-arrow-right"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="why2" role="tabpanel" aria-labelledby="why2-tab">
                                            <div class="row">
                                                <div class="col-12 mt-4">
                                                    <div class="form-group">
                                                        <h6 class="fw-medium">Step 3</h6>
                                                        <div class="d-flex justify-content-start mb-3">
                                                            <div class="rounded p-2" style="background-color: #e5e5e5;">
                                                                <p class="text-center mb-0" id="why2_text">...</p>
                                                            </div>
                                                        </div>
                                                        <p class="text-start">Bagus! Kita lanjutkan ke langkah berikutnya.
                                                        Sekarang mari kita pecah masalah ini ke bagian-bagian penyusunnya untuk melihat lebih jelas penyebab utamanya!</p>
                                                        <br>
                                                        <div id="why2_jawaban" class="h5 fw-bold"></div>
                                                        <br>
                                                        <div class="row justify-content-between mt-5">
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 mb-3">
                                                                <textarea class="form-control" id="input_why2" name="input_why2" placeholder="Tuliskan akar masalah dari analisa yang dihasilkan!" rows="2"></textarea>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 text-md-end">
                                                                <button type="button" class="btn btn-danger rounded text-white custom-bg-red w-100 w-md-auto btn-next" onclick="next_problem('3')">Selanjutnya <i class="bi bi-arrow-right"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="why3" role="tabpanel" aria-labelledby="why3-tab">
                                            <div class="row">
                                                <div class="col-12 mt-4">
                                                    <div class="form-group">
                                                        <h6 class="fw-medium">Step 4</h6>
                                                        <div class="d-flex justify-content-start mb-3">
                                                            <div class="rounded p-2" style="background-color: #e5e5e5;">
                                                                <p class="text-center mb-0" id="why3_text">...</p>
                                                            </div>
                                                        </div>
                                                        <p class="text-start">Baik, sekarang kita lanjutkan.
                                                        Setelah melihat penyebab, kita analisis dampaknya secara menyeluruh dan lihat apakah ada pola berulang yang muncul!</p>
                                                        <br>
                                                        <div id="why3_jawaban" class="h5 fw-bold"></div>
                                                        <br>
                                                        <div class="row justify-content-between mt-5">
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 mb-3">
                                                                <textarea class="form-control" id="input_why3" name="input_why3" placeholder="Tuliskan akar masalah dari analisa yang dihasilkan!" rows="2"></textarea>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 text-md-end">
                                                                <button type="button" class="btn btn-danger rounded text-white custom-bg-red w-100 w-md-auto btn-next" onclick="next_problem('4')">Selanjutnya <i class="bi bi-arrow-right"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="why4" role="tabpanel" aria-labelledby="why4-tab">
                                            <div class="row">
                                                <div class="col-12 mt-4">
                                                    <div class="form-group">
                                                        <h6 class="fw-medium">Step 5</h6>
                                                        <div class="d-flex justify-content-start mb-3">
                                                            <div class="rounded p-2" style="background-color: #e5e5e5;">
                                                                <p class="text-center mb-0" id="why4_text">...</p>
                                                            </div>
                                                        </div>
                                                        <p class="text-start">Oke, kita hampir sampai ke akar masalahnya.
                                                        Kita akan fokus lebih tajam untuk menyusun hipotesis tentang akar masalah utama yang memicu semua gejala ini!</p>
                                                        <br>
                                                        <div id="why4_jawaban" class="h5 fw-bold"></div>
                                                        <br>
                                                        <div class="row justify-content-between mt-5">
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 mb-3">
                                                                <textarea class="form-control" id="input_why4" name="input_why4" placeholder="Tuliskan akar masalah dari analisa yang dihasilkan!" rows="2"></textarea>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 text-md-end">
                                                                <button type="button" class="btn btn-danger rounded text-white custom-bg-red w-100 w-md-auto btn-next" onclick="next_problem('5')">Selanjutnya <i class="bi bi-arrow-right"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="why5" role="tabpanel" aria-labelledby="why5-tab">
                                            <div class="row">
                                                <div class="col-12 mt-4">
                                                    <div class="form-group">
                                                        <h6 class="fw-medium">Step 6</h6>
                                                        <div class="d-flex justify-content-start mb-3">
                                                            <div class="rounded p-2" style="background-color: #e5e5e5;">
                                                                <p class="text-center mb-0" id="why5_text">...</p>
                                                            </div>
                                                        </div>
                                                        <p class="text-start">Bagus, kita sudah makin dekat ke penyelesaian masalah. 
                                                        Setelah menemukan akar masalah, kita bisa mulai menyusun strategi solusi yang logis, efisien, dan bisa diuji!</p>
                                                        <br>
                                                        <div id="why5_jawaban" class="h5 fw-bold"></div>
                                                        <br>
                                                        <div class="row justify-content-between mt-5">
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9 mb-3">
                                                                <textarea class="form-control" id="input_why5" name="input_why5" placeholder="Tuliskan akar masalah dari analisa yang dihasilkan!" rows="2"></textarea>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 text-md-end">
                                                                <button type="button" class="btn btn-danger rounded text-white custom-bg-red w-100 w-md-auto btn-next" onclick="next_problem('6')">Selanjutnya <i class="bi bi-arrow-right"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="solving" role="tabpanel" aria-labelledby="solving-tab">
                                            <div class="row">
                                                <div class="col-12 mt-4">
                                                    <div class="form-group">
                                                        <h6 class="fw-medium">Step 7 - Solving</h6>
                                                        <img src="<?php echo base_url('assets/img/manager-desk.png'); ?>" class="img-fluid d-block mx-auto" alt="manager-desk">
                                                        <!-- <p class="text-center"><b>Akar dari masalahmu adalah :</b></p> -->
                                                        <div class="d-flex justify-content-start mb-3">
                                                            <div class="rounded p-2" style="background-color: #e5e5e5;">
                                                                <p class="text-center mb-0" id="solving_text">...</p>
                                                            </div>
                                                        </div>
                                                        <p class="text-start">Terima kasih! Kita telah menyelesaikan proses analisis menggunakan pendekatan coaching.
                                                            Sekarang, kita telah mencapai tahap akhir—saatnya menyimpulkan temuan utama dan menyusun langkah konkret untuk menguji serta memvalidasi solusi yang telah Anda rumuskan.!</p>
                                                        <br>
                                                        <div id="solving_jawaban" class="h5 fw-bold"></div>
                                                        <br>
                                                        <div class="row justify-content-between mt-5">
                                                            <div class="col-auto mb-3" style="flex: 1;">
                                                                <textarea class="form-control" id="input_solving" name="input_solving" placeholder="Tuliskan solusi yang akan kamu lakukan untuk masalah ini!" rows="2" style="width: 100%;"></textarea>
                                                            </div>
                                                            <div class="col-auto mb-3 pilihan_status d-none" style="flex: 0.5;">
                                                                <select class="form-control" id="status_solving" name="status_solving">
                                                                    <option value="" disabled selected>-Pilih Status-</option>
                                                                    <option value="solved">Solved</option>
                                                                    <option value="unsolved">Unsolved</option>
                                                                    <!-- <option value="tasklist">Tasklist</option> -->
                                                                </select>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 text-md-end" style="flex: 1;">
                                                                <button type="button" class="btn btn-danger rounded text-white custom-bg-red w-100 w-md-auto btn-next" onclick="next_problem('7')">Selesai</button>
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
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add -->