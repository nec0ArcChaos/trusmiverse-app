<div class="container-fluid">
    <div class="row">
        <div class="col-xxl-3 col-lg-4">
            <ul class="nav nav-tabs justify-content-center nav-WinDOORS nav-lg flex-column" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="brand-tab" data-bs-toggle="tab" data-bs-target="#brand"
                        type="button" role="tab" aria-controls="brand" aria-selected="true">Brand</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pillars-tab" data-bs-toggle="tab" data-bs-target="#pillars"
                        type="button" role="tab" aria-controls="pillars" aria-selected="false" tabindex="-1">Content
                        Pillars</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="objectives-tab" data-bs-toggle="tab" data-bs-target="#objectives"
                        type="button" role="tab" aria-controls="objectives" aria-selected="false"
                        tabindex="-1">Objectives</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="generated-tab" data-bs-toggle="tab" data-bs-target="#generated"
                        type="button" role="tab" aria-controls="generated" aria-selected="false" tabindex="-1">Generated
                        Content</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="content_format-tab" data-bs-toggle="tab"
                        data-bs-target="#content_format" type="button" role="tab" aria-controls="content_format"
                        aria-selected="false" tabindex="-1">Content Format</button>
                </li>
            </ul>
        </div>
        <div class="col-xxl-9 col-lg-8">
            <div class="card rounded-4">
                <!-- Tabs Content -->
                <div class="card-body">
                    <div class="tab-content" id="tabs-content">
                        <div class="tab-pane fade show active" id="brand" role="tabpanel" aria-labelledby="brand-tab">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">Brand Management</h4>
                                <button type="button" class="btn btn-primary btn-sm" id="addBrandModal">
                                    <i class="bi bi-plus me-1"></i> Add Brand
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table id="brandTable" class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th>Brand Name</th>
                                            <th>Description</th>
                                            <th>Associated Company</th>
                                            <th>Status</th>
                                            <th style="width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data populated by JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pillars" role="tabpanel" aria-labelledby="pillars-tab">
                            <!-- Content for Pillars -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">Content Pillars Management</h4>
                                <button type="button" class="btn btn-primary btn-sm" id="addContentPillarModal">
                                    <i class="bi bi-plus me-1"></i> Add Pillar
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table id="contentPillarTable" class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th>Name</th>
                                            <th>Associated Brand</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th style="width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="objectives" role="tabpanel" aria-labelledby="objectives-tab">
                            <!-- Content for Objectives -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">Objectives Management</h4>
                                <button type="button" class="btn btn-primary btn-sm" id="addObjectiveModal">
                                    <i class="bi bi-plus me-1"></i> Add Objective
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table id="objectiveTable" class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th>Name</th>
                                            <th>Associated Brand</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th style="width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="generated" role="tabpanel" aria-labelledby="generated-tab">
                            <!-- Content for Generated -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">Generated Content Management</h4>
                                <button type="button" class="btn btn-primary btn-sm" id="addGeneratedContentModal">
                                    <i class="bi bi-plus me-1"></i> Add Content
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table id="generatedContentTable" class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th>Name</th>
                                            <th>Associated Brand</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th style="width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="content_format" role="tabpanel"
                            aria-labelledby="content_format-tab">
                            <!-- Content for Content Format -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">Content Format Management</h4>
                                <button type="button" class="btn btn-primary btn-sm" id="addContentFormatModal">
                                    <i class="bi bi-plus me-1"></i> Add Format
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table id="contentFormatTable" class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th>Name</th>
                                            <th>Associated Brand</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th style="width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>