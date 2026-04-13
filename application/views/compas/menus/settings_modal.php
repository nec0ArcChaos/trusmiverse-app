<!-- Modal Add Campaign -->
<div class="modal sub_modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="brandModal" tabindex="-1"
    aria-labelledby="brandModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="brandModalLabel">Add Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="addBrandForm">
                        <input type="hidden" name="brand_id" id="brand_id">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Brand Name <sup
                                            class="text-danger">*</sup></label>
                                    <input type="text" placeholder="e.g. Rumah Ningrat" value="" required
                                        name="brand_name" id="brand_name" class="form-control form-control-lg">
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Associated Company <sup
                                            class="text-danger">*</sup></label>
                                    <select class="form-select form-select-lg chosen-select" multiple
                                        name="company_id[]" id="company_id" required
                                        data-placeholder="Choose Companies...">
                                        <option value="PT. Trusmi Group">PT. Trusmi Group</option>
                                        <option value="PT. Raja Sukses Propertindo">PT. Raja Sukses Propertindo</option>
                                        <option value="PT. Tiga Raja Propertindo">PT. Tiga Raja Propertindo</option>
                                        <option value="Yayasan Trusmi">Yayasan Trusmi</option>
                                        <!-- Add more options as needed -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-check form-switch ps-0">
                                    <label class="form-check-label fw-bold mb-2 d-block" for="is_active">Active
                                        Status</label>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2 text-muted small">Inactive</span>
                                        <div class="form-check form-switch ms-2">
                                            <input class="form-check-input" type="checkbox" id="is_active"
                                                name="is_active" checked style="width: 3em; height: 1.5em;">
                                        </div>
                                        <span class="ms-2 text-success fw-bold small">Active</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <textarea placeholder="Description" value="" required="" name="brand_desc"
                                        id="brand_desc_val" class="form-control d-none rounded-4"></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Description <sup class="text-danger">*</sup></p>
                                        </div>
                                        <div id="brand_desc" style="height: 400px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary ms-2"><i class="fas fa-save me-1"></i> Save
                                Brand</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Content Pillar -->
<div class="modal sub_modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="contentPillarModal"
    tabindex="-1" aria-labelledby="contentPillarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contentPillarModalLabel">Add Content Pillar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="addContentPillarForm">
                        <input type="hidden" name="cp_id" id="cp_id">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Pillar Name <sup
                                            class="text-danger">*</sup></label>
                                    <input type="text" placeholder="e.g. Edukasi & Process" value="" required
                                        name="cp_name" id="cp_name" class="form-control form-control-lg">
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Associated Brand <sup
                                            class="text-danger">*</sup></label>
                                    <select class="form-select form-select-lg chosen-select" multiple name="brand_id[]"
                                        id="cp_brand_id" required data-placeholder="Choose Brands...">
                                        <!-- Options populated by JS -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <textarea placeholder="Description" value="" required="" name="cp_desc"
                                        id="cp_desc_val" class="form-control d-none rounded-4"></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Description <sup class="text-danger">*</sup></p>
                                        </div>
                                        <div id="cp_desc" style="height: 200px;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-check form-switch ps-0">
                                    <label class="form-check-label fw-bold mb-2 d-block" for="cp_is_active">Active
                                        Status</label>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2 text-muted small">Inactive</span>
                                        <div class="form-check form-switch ms-2">
                                            <input class="form-check-input" type="checkbox" id="cp_is_active"
                                                name="is_active" checked style="width: 3em; height: 1.5em;">
                                        </div>
                                        <span class="ms-2 text-success fw-bold small">Active</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary ms-2"><i class="fas fa-save me-1"></i> Save
                                Pillar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Objective -->
<div class="modal sub_modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="objectiveModal" tabindex="-1"
    aria-labelledby="objectiveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="objectiveModalLabel">Add Objective</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="addObjectiveForm">
                        <input type="hidden" name="objective_id" id="objective_id">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Objective Name <sup
                                            class="text-danger">*</sup></label>
                                    <input type="text" placeholder="e.g. Awareness" value="" required
                                        name="objective_name" id="objective_name" class="form-control form-control-lg">
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Associated Brand <sup
                                            class="text-danger">*</sup></label>
                                    <select class="form-select form-select-lg chosen-select" multiple name="brand_id[]"
                                        id="obj_brand_id" required data-placeholder="Choose Brands...">
                                        <!-- Options populated by JS -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <textarea placeholder="Description" value="" required="" name="objective_desc"
                                        id="objective_desc_val" class="form-control d-none rounded-4"></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Description <sup class="text-danger">*</sup></p>
                                        </div>
                                        <div id="objective_desc" style="height: 200px;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-check form-switch ps-0">
                                    <label class="form-check-label fw-bold mb-2 d-block" for="obj_is_active">Active
                                        Status</label>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2 text-muted small">Inactive</span>
                                        <div class="form-check form-switch ms-2">
                                            <input class="form-check-input" type="checkbox" id="obj_is_active"
                                                name="is_active" checked style="width: 3em; height: 1.5em;">
                                        </div>
                                        <span class="ms-2 text-success fw-bold small">Active</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary ms-2"><i class="fas fa-save me-1"></i> Save
                                Objective</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Generated Content -->
<div class="modal sub_modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="generatedContentModal"
    tabindex="-1" aria-labelledby="generatedContentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generatedContentModalLabel">Add Generated Content</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="addGeneratedContentForm">
                        <input type="hidden" name="cg_id" id="cg_id">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Content Name <sup
                                            class="text-danger">*</sup></label>
                                    <input type="text" placeholder="e.g. Content UGC" value="" required name="cg_name"
                                        id="cg_name" class="form-control form-control-lg">
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Associated Brand <sup
                                            class="text-danger">*</sup></label>
                                    <select class="form-select form-select-lg chosen-select" multiple name="brand_id[]"
                                        id="gen_brand_id" required data-placeholder="Choose Brands...">
                                        <!-- Options populated by JS -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <textarea placeholder="Description" value="" required="" name="cg_desc"
                                        id="cg_desc_val" class="form-control d-none rounded-4"></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Description <sup class="text-danger">*</sup></p>
                                        </div>
                                        <div id="cg_desc" style="height: 200px;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-check form-switch ps-0">
                                    <label class="form-check-label fw-bold mb-2 d-block" for="gen_is_active">Active
                                        Status</label>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2 text-muted small">Inactive</span>
                                        <div class="form-check form-switch ms-2">
                                            <input class="form-check-input" type="checkbox" id="gen_is_active"
                                                name="is_active" checked style="width: 3em; height: 1.5em;">
                                        </div>
                                        <span class="ms-2 text-success fw-bold small">Active</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary ms-2"><i class="fas fa-save me-1"></i> Save
                                Content</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Content Format -->
<div class="modal sub_modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="contentFormatModal"
    tabindex="-1" aria-labelledby="contentFormatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contentFormatModalLabel">Add Content Format</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="addContentFormatForm">
                        <input type="hidden" name="cf_id" id="cf_id">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Format Name <sup
                                            class="text-danger">*</sup></label>
                                    <input type="text" placeholder="e.g. Video" value="" required name="cf_name"
                                        id="cf_name" class="form-control form-control-lg">
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Associated Brand <sup
                                            class="text-danger">*</sup></label>
                                    <select class="form-select form-select-lg chosen-select" multiple name="brand_id[]"
                                        id="fmt_brand_id" required data-placeholder="Choose Brands...">
                                        <!-- Options populated by JS -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group position-relative check-valid">
                                    <textarea placeholder="Description" value="" required="" name="cf_desc"
                                        id="cf_desc_val" class="form-control d-none rounded-4"></textarea>
                                    <div class="overtype-section">
                                        <div class="overtype-header">
                                            <p class="fw-medium mb-0">Description <sup class="text-danger">*</sup></p>
                                        </div>
                                        <div id="cf_desc" style="height: 200px;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-check form-switch ps-0">
                                    <label class="form-check-label fw-bold mb-2 d-block" for="fmt_is_active">Active
                                        Status</label>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2 text-muted small">Inactive</span>
                                        <div class="form-check form-switch ms-2">
                                            <input class="form-check-input" type="checkbox" id="fmt_is_active"
                                                name="is_active" checked style="width: 3em; height: 1.5em;">
                                        </div>
                                        <span class="ms-2 text-success fw-bold small">Active</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary ms-2"><i class="fas fa-save me-1"></i> Save
                                Format</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>