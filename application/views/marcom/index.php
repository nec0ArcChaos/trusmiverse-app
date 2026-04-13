<main class="main mainheight">
    <div class="container-fluid py-3" style="min-height: 100vh;">
        <!-- <?php var_dump($this->session->userdata()) ?> -->

        <!-- Tabs -->
        <nav>
            <div class="nav nav-tabs windoor-tabs" id="taskTab" role="tablist">
                <?php if ($show_campaign): ?>
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabCampaign" type="button">Campaign</button>
                <?php endif; ?>

                <?php
                $is_first = true;
                foreach ($menu_tabs as $id => $label) {
                    $active_class = (!$show_campaign && $is_first) ? 'active' : '';
                ?>
                    <button class="nav-link <?= $active_class ?>" data-bs-toggle="tab" data-bs-target="#tab<?= $id ?>" type="button">
                        <?= $label ?>
                    </button>
                <?php
                    $is_first = false;
                }
                ?>
            </div>
        </nav>

        <!-- Tab Content -->
        <div class="tab-content mt-4" id="taskTabContent">
            <?php if ($show_campaign): ?>
                <div class="tab-pane fade show active" id="tabCampaign">

                    <div class="card mb-3 border-0 shadow-sm bg-light">
                        <div class="card-body p-3">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-3">
                                    <label class="small fw-bold text-muted mb-1">Tanggal Buat</label>
                                    <input type="text" id="filter_date_campaign" class="form-control form-control-sm bg-white" readonly>
                                    <input type="hidden" id="f_start_date">
                                    <input type="hidden" id="f_end_date">
                                </div>

                                <div class="col-md-2">
                                    <label class="small fw-bold text-muted mb-1">Company</label>
                                    <select id="filter_company" class="form-select form-select-sm">
                                        <option value="">Semua Company</option>
                                        <?php foreach ($companies as $c) { ?>
                                            <option value="<?= $c->company_id ?>"><?= $c->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="small fw-bold text-muted mb-1">PIC</label>
                                    <select id="filter_pic" class="">
                                        <option value="">Semua PIC</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="small fw-bold text-muted mb-1">Cari</label>
                                    <input type="text" id="search_campaign" class="form-control form-control-sm" placeholder="Nama Campaign / Goals...">
                                </div>

                                <div class="col-md-2">
                                    <button class="btn btn-primary btn-sm w-100" id="btnFilterCampaign">
                                        <i class="bi bi-funnel-fill me-1"></i> Terapkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#campaignModal">
                            <i class="bi bi-plus-lg me-1"></i> Buat Campaign
                        </button>
                        <span class="small text-muted" id="total_campaign_show">Menampilkan data...</span>
                    </div>

                    <div class="campaignList" id="campaignList"></div>

                </div>
            <?php endif; ?>

            <?php
            $is_first_content = true;
            foreach ($menu_tabs as $id => $label) {
                // Logic class active/show untuk content pane
                $pane_active = (!$show_campaign && $is_first_content) ? 'show active' : '';
            ?>
                <div class="tab-pane fade <?= $pane_active ?>" id="tab<?= $id ?>">

                    <div class="card mb-3 border-0 shadow-sm bg-light">
                        <div class="card-body p-2">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-3">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-calendar-range"></i></span>
                                        <input type="text" id="filter_date_<?= $id ?>" class="form-control bg-white" placeholder="Filter Tanggal" readonly>
                                        <input type="hidden" id="f_start_date_<?= $id ?>">
                                        <input type="hidden" id="f_end_date_<?= $id ?>">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                                        <input type="text" id="search_<?= $id ?>" class="form-control" placeholder="Cari <?= $label ?>...">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <button class="btn btn-primary btn-sm w-100 btn-filter-kanban" data-tab="<?= $id ?>">
                                        Terapkan
                                    </button>
                                </div>

                                <?php if ($id == 3) { ?>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary btn-sm w-100 btn-filter-kanban" id="btnAddKol2">
                                            Add Master KOL
                                        </button>
                                    </div>
                                <?php } ?>

                                <div class="col-md-1">
                                    <button class="btn btn-outline-secondary btn-sm w-100 btn-reset-kanban" data-tab="<?= $id ?>" title="Reset Filter">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="kanban-wrapper d-flex gap-3">
                        <div class="kanban-col">
                            <div class="kanban-title bg-light-pending">
                                🔴 Pending <span class="kanban-count" id="count_pending_<?= $id ?>">0</span>
                            </div>
                            <div class="kanban-body" id="pending_<?= $id ?>"></div>
                        </div>

                        <div class="kanban-col">
                            <div class="kanban-title bg-light-progress">
                                🟡 In Progress <span class="kanban-count" id="count_progress_<?= $id ?>">0</span>
                            </div>
                            <div class="kanban-body" id="progress_<?= $id ?>"></div>
                        </div>

                        <div class="kanban-col">
                            <div class="kanban-title bg-light-review">
                                🟠 Review <span class="kanban-count" id="count_review_<?= $id ?>">0</span>
                            </div>
                            <div class="kanban-body" id="review_<?= $id ?>"></div>
                        </div>

                        <div class="kanban-col">
                            <div class="kanban-title bg-light-complete">
                                🔵 Completed <span class="kanban-count" id="count_done_<?= $id ?>">0</span>
                            </div>
                            <div class="kanban-body" id="done_<?= $id ?>"></div>
                        </div>
                    </div>

                </div>
            <?php
                $is_first_content = false;
            }
            ?>
        </div>

</main>

<?php $this->load->view('marcom/modal/riset_campaign/modal'); ?>

<?php $this->load->view('marcom/modal/content_script/modal'); ?>

<?php $this->load->view('marcom/modal/riset_kol/modal'); ?>

<?php $this->load->view('marcom/modal/budgeting/modal'); ?>

<?php $this->load->view('marcom/modal/shooting/modal'); ?>

<?php $this->load->view('marcom/modal/editing/modal'); ?>

<div class="modal fade" id="modalAddKol" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <form id="formAddKol" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Master KOL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- PLACEMENT -->
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Placement</label>
                    <select name="kategory" id="kolPlacement" class="form-select form-select-sm" required>
                        <option value="">-- Pilih Placement --</option>
                        <option value="1">Instagram</option>
                        <option value="2">TikTok</option>
                        <option value="3">Influencer</option>
                        <option value="4">Mediagram</option>
                    </select>
                </div>

                <!-- NAMA -->
                <div class="mb-2">
                    <label class="form-label small">Nama KOL</label>
                    <input type="hidden" id="master_kol_id" name="id">
                    <input type="text" name="nama" class="form-control form-control-sm" required placeholder="Contoh: Sule">
                </div>


                <div class="mb-2">
                    <label class="form-label small">Area</label>
                    <input type="text" name="area" class="form-control form-control-sm" required placeholder="Contoh: Jakarta">
                </div>

                <div class="mb-2">
                    <label class="form-label small">No WA</label>
                    <input type="text" name="no_wa" class="form-control form-control-sm" placeholder="Contoh: 628123456789">
                </div>

                <div class="mb-2">
                    <label class="form-label small">Email</label>
                    <input type="email" name="email" class="form-control form-control-sm" placeholder="Contoh: 6Tt9N@example.com">
                </div>

                <div class="mb-2">
                    <label class="form-label small">Niche</label>
                    <input type="text" name="niche" class="form-control form-control-sm" required placeholder="Contoh: Fashion">
                </div>

                <!-- PLATFORM FIELDS -->
                <div class="row">
                    <div class="col-md-6">
                        <label class="small fw-semibold">Instagram</label>
                        <input type="text" name="username_ig" class="form-control form-control-sm mb-1" placeholder="Username IG">
                        <input type="text" name="link_ig" class="form-control form-control-sm mb-1" placeholder="Link IG">
                        <input type="text" name="follower_ig" class="form-control form-control-sm mb-1" oninput="formatInputNumber(this)" placeholder="Follower IG">
                        <input type="text" name="last_rate_card_ig" class="form-control form-control-sm mb-1" oninput="formatInputCurrency(this)" placeholder="Last Rate Card IG">
                        <input type="text" name="last_konten_1_ig" class="form-control form-control-sm mb-1" oninput="formatInputNumber(this)" placeholder="Last Konten IG 1">
                        <input type="text" name="last_konten_2_ig" class="form-control form-control-sm mb-1" oninput="formatInputNumber(this)" placeholder="Last Konten IG 2">
                        <input type="text" name="last_konten_3_ig" class="form-control form-control-sm mb-1" oninput="formatInputNumber(this)" placeholder="Last Konten IG 3">
                        <input type="text" name="last_konten_4_ig" class="form-control form-control-sm mb-1" oninput="formatInputNumber(this)" placeholder="Last Konten IG 4">
                        <input type="text" name="last_konten_5_ig" class="form-control form-control-sm mb-1" oninput="formatInputNumber(this)" placeholder="Last Konten IG 5">
                        <input type="text" name="cpv_ig" id="cpv_ig" class="form-control form-control-sm mb-1 bg-light" placeholder="CPV IG" readonly>

                    </div>

                    <div class="col-md-6">
                        <label class="small fw-semibold">TikTok</label>
                        <input type="text" name="username_tt" class="form-control form-control-sm mb-1" placeholder="Username TT">
                        <input type="text" name="link_tt" class="form-control form-control-sm mb-1" placeholder="Link TT">
                        <input type="text" name="follower_tt" class="form-control form-control-sm mb-1" oninput="formatInputNumber(this)" placeholder="Follower TT">
                        <input type="text" name="last_rate_card_tt" class="form-control form-control-sm mb-1" oninput="formatInputCurrency(this)" placeholder="Last Rate Card TT">
                        <input type="text" name="last_konten_1_tt" class="form-control form-control-sm mb-1" oninput="formatInputNumber(this)" placeholder="Last Konten TT 1">
                        <input type="text" name="last_konten_2_tt" class="form-control form-control-sm mb-1" oninput="formatInputNumber(this)" placeholder="Last Konten TT 2">
                        <input type="text" name="last_konten_3_tt" class="form-control form-control-sm mb-1" oninput="formatInputNumber(this)" placeholder="Last Konten TT 3">
                        <input type="text" name="last_konten_4_tt" class="form-control form-control-sm mb-1" oninput="formatInputNumber(this)" placeholder="Last Konten TT 4">
                        <input type="text" name="last_konten_5_tt" class="form-control form-control-sm mb-1" oninput="formatInputNumber(this)" placeholder="Last Konten TT 5">
                        <input type="text" name="cpv_tt" id="cpv_tt" class="form-control form-control-sm mb-1 bg-light" placeholder="CPV TT" readonly>

                    </div>
                </div>

                <!-- RATECARD UMUM -->
                <div class="mt-2">
                    <label class="form-label small">Ratecard</label>
                    <input type="text" name="ratecard" class="form-control form-control-sm" oninput="formatInputCurrency(this)" placeholder="Rp. 100.000">
                </div>

                <hr>

                <!-- LIST MASTER KOL -->
                <h6 class="fw-semibold mb-2">Daftar Master KOL</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered" id="tableMasterKol" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Placement</th>
                                <th>IG</th>
                                <th>Tiktok</th>
                                <th>Ratecard</th>
                                <th>Views Last Konten IG</th>
                                <th>Views Last Konten TT</th>
                                <th>Area</th>
                                <th>No WA</th>
                                <th>Email</th>
                                <th>Niche</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary btn-sm" type="submit">Simpan KOL</button>
            </div>
        </form>
    </div>
</div>