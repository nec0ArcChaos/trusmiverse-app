<main class="main mainheight">

    <div class="container-fluid mb-4">
        <nav class="breadcrumb-theme">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">Trusmiverse</li>
                <li class="breadcrumb-item active"><?= $pageTitle ?></li>
            </ol>
        </nav>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card trusmi-card shadow-sm border-0">

                    <div class="card-body budget-card-header">
                        <div class="budget-header">
                            <div class="budget-left">
                                <div class="avatar avatar-40 bg-light-theme rounded me-2">
                                    <i class="bi bi-bar-chart-line"></i>
                                </div>
                                <div>
                                    <h6 class="fw-medium mb-1">Budget Performance Overview</h6>
                                    <div class="budget-legend">
                                        <span>
											<i class="legend-dot red"></i>
											Merah: Actual &gt; 100% dari MTD (Over Budget)
										</span>

										<span>
											<i class="legend-dot yellow"></i>
											Kuning: Actual 60%–100% dari MTD (Mendekati Limit)
										</span>

										<span>
											<i class="legend-dot green"></i>
											Hijau: Actual &lt; 60% dari MTD (Aman)
										</span>
                                    </div>
                                </div>
                            </div>

                            <div class="budget-filter">
                                <select id="bulan" class="filter-select">
                                    <?php for($i=1;$i<=12;$i++){ ?>
                                        <option value="<?= $i ?>" <?= ($bulan==$i)?'selected':'' ?>>
                                            <?= date('F', mktime(0,0,0,$i,1)) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <select id="tahun" class="filter-select">
                                    <?php for($y=date('Y')-2;$y<=date('Y')+1;$y++){ ?>
                                        <option value="<?= $y ?>" <?= ($tahun==$y)?'selected':'' ?>>
                                            <?= $y ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="table_budget_overview" class="table trusmi-table align-middle mb-0 nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">Budget YTD</th>
                                    <th class="text-center">Budget MTD</th>
                                    <th class="text-center">Actual</th>
                                    <th class="text-center">% MTD</th>
                                    <th class="text-center">Alert</th>
                                    <th class="text-center">Sisa Budget</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <div id="overbudget_container" class="mt-4 p-3"></div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="modal fade" id="modalDetailBudget" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-budget-wide">
        <div class="modal-content budget-modal">

            <div class="modal-header budget-modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-bar-chart-line me-2"></i>
                    Detail Budget - <span id="modal_company"></span>
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div id="modal_detail_content"></div>
            </div>

        </div>
    </div>
</div>