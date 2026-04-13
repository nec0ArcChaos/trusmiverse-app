// Campaign Tab Script
if (!window.LoadInit) {
    window.LoadInit = {};
}

window.LoadInit['menus'] = window.LoadInit['menus'] || {};

window.LoadInit['menus']['settings'] = function (container) {
    console.log("Settings tab initialized");

    // Initialize Chosen JS for company name
    if ($(".chosen-select").length > 0) {
        $(".chosen-select").chosen({
            width: "100%",
            placeholder_text_multiple: "Select Options"
        });
    }

    // Initialize OverType
    initOverType('brand_desc', 'brand_desc_val', 'Description');
    initOverType('cp_desc', 'cp_desc_val', 'Description');
    initOverType('objective_desc', 'objective_desc_val', 'Description');
    initOverType('cg_desc', 'cg_desc_val', 'Description');
    initOverType('cf_desc', 'cf_desc_val', 'Description');

    // Load initial data
    loadBrands();
    loadContentPillars();
    loadObjectives();
    loadGeneratedContents();
    loadContentFormats();

    // Load Select Options
    loadCompanyOptions();
    loadBrandOptions();


    // --- BRAND ---
    $('#addBrandModal').on('click', function () {
        $('#brandModal').modal('show');
        $('#addBrandForm')[0].reset();
        $('#brand_id').val('');
        $('#company_id').val('').trigger('chosen:updated');
        // Clear OverType
        if (window.overTypeInstances && window.overTypeInstances['brand_desc']) {
            window.overTypeInstances['brand_desc'].setValue('');
        }
        $('#is_active').prop('checked', true);
        $('#brandModalLabel').text('Add Brand');
    });

    handleFormSubmit('#addBrandForm', 'compas/settings/save_brand', '#brandModal', loadBrands);

    // --- CONTENT PILLAR ---
    $('#addContentPillarModal').on('click', function () {
        $('#contentPillarModal').modal('show');
        $('#addContentPillarForm')[0].reset();
        $('#cp_id').val('');
        $('#cp_brand_id').val('').trigger('chosen:updated');
        // Clear OverType
        if (window.overTypeInstances && window.overTypeInstances['cp_desc']) {
            window.overTypeInstances['cp_desc'].setValue('');
        }
        $('#cp_is_active').prop('checked', true);
        $('#contentPillarModalLabel').text('Add Content Pillar');
    });

    handleFormSubmit('#addContentPillarForm', 'compas/settings/save_content_pillar', '#contentPillarModal', loadContentPillars);

    // --- OBJECTIVE ---
    $('#addObjectiveModal').on('click', function () {
        $('#objectiveModal').modal('show');
        $('#addObjectiveForm')[0].reset();
        $('#objective_id').val('');
        $('#obj_brand_id').val('').trigger('chosen:updated');
        if (window.overTypeInstances && window.overTypeInstances['objective_desc']) {
            window.overTypeInstances['objective_desc'].setValue('');
        }
        $('#obj_is_active').prop('checked', true);
        $('#objectiveModalLabel').text('Add Objective');
    });

    handleFormSubmit('#addObjectiveForm', 'compas/settings/save_objective', '#objectiveModal', loadObjectives);

    // --- GENERATED CONTENT ---
    $('#addGeneratedContentModal').on('click', function () {
        $('#generatedContentModal').modal('show');
        $('#addGeneratedContentForm')[0].reset();
        $('#cg_id').val('');
        $('#gen_brand_id').val('').trigger('chosen:updated');
        if (window.overTypeInstances && window.overTypeInstances['cg_desc']) {
            window.overTypeInstances['cg_desc'].setValue('');
        }
        $('#gen_is_active').prop('checked', true);
        $('#generatedContentModalLabel').text('Add Generated Content');
    });

    handleFormSubmit('#addGeneratedContentForm', 'compas/settings/save_generated_content', '#generatedContentModal', loadGeneratedContents);

    // --- CONTENT FORMAT ---
    $('#addContentFormatModal').on('click', function () {
        $('#contentFormatModal').modal('show');
        $('#addContentFormatForm')[0].reset();
        $('#cf_id').val('');
        $('#fmt_brand_id').val('').trigger('chosen:updated');
        if (window.overTypeInstances && window.overTypeInstances['cf_desc']) {
            window.overTypeInstances['cf_desc'].setValue('');
        }
        $('#fmt_is_active').prop('checked', true);
        $('#contentFormatModalLabel').text('Add Content Format');
    });

    handleFormSubmit('#addContentFormatForm', 'compas/settings/save_content_format', '#contentFormatModal', loadContentFormats);

};

// --- HELPER FUNCTIONS ---

function initOverType(elementId, hiddenInputId, placeholder) {
    if (!window.overTypeInstances) {
        window.overTypeInstances = {};
    }

    // Check if element exists before init
    if ($('#' + elementId).length) {
        [window.overTypeInstances[elementId]] = new OverType('#' + elementId, {
            theme: {
                name: 'custom-theme',
                colors: {
                    bgPrimary: '#015EC2',
                    bgSecondary: '#ffffff',
                    text: '#0d3b66',
                    h1: '#f95738',
                    h2: '#ee964b',
                    h3: '#3d8a51',
                    strong: '#ee964b',
                    em: '#f95738',
                    link: '#0d3b66',
                    code: '#0d3b66',
                    codeBg: 'rgba(244, 211, 94, 0.2)',
                    blockquote: '#5a7a9b',
                    hr: '#5a7a9b',
                    syntaxMarker: 'rgba(13, 59, 102, 0.52)',
                    cursor: '#f95738',
                    selection: 'rgba(1, 94, 194, 0.8)'
                }
            },
            toolbar: true,
            placeholder: placeholder,
            value: '',
            onChange: (value, instance) => {
                $('#' + hiddenInputId).val(value);
            }
        });
    }
}

function handleFormSubmit(formId, url, modalId, reloadCallback) {
    $(formId).off('submit').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        // Handle checkbox manually for 'is_active'
        var checkbox = $(this).find('input[name="is_active"]');
        if (!checkbox.is(':checked')) {
            formData.append('is_active', 0);
        } else {
            formData.set('is_active', 1);
        }

        $.ajax({
            url: BASE_URL + url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (response.status == 'success') {
                    Swal.fire('Success', response.message, 'success');
                    $(modalId).modal('hide');
                    reloadCallback();
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                Swal.fire('Error', 'An error occurred. Check console for details.', 'error');
            }
        });
    });
}

function loadCompanyOptions() {
    $.ajax({
        url: BASE_URL + 'compas/settings/get_company',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var html = '';
            if (response.data && response.data.length > 0) {
                $.each(response.data, function (index, company) {
                    html += '<option value="' + company.company_id + '">' + company.company_name + '</option>';
                });
            }
            $('#company_id').html(html);
            $('#company_id').trigger('chosen:updated');
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    })
}

function loadBrandOptions() {
    $.ajax({
        url: BASE_URL + 'compas/settings/get_brands', // Use get_brands to populate options
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var html = '';
            if (response.data && response.data.length > 0) {
                $.each(response.data, function (index, brand) {
                    html += '<option value="' + brand.brand_id + '">' + brand.brand_name + '</option>';
                });
            }
            $('#cp_brand_id, #obj_brand_id, #gen_brand_id, #fmt_brand_id').html(html);
            $('#cp_brand_id, #obj_brand_id, #gen_brand_id, #fmt_brand_id').trigger('chosen:updated');
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    })
}


// --- LOAD DATA & CRUD ACTIONS ---
let converter = new showdown.Converter();

// BRAND
function loadBrands() {
    $.ajax({
        url: BASE_URL + 'compas/settings/get_brands',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var html = '';
            if (response.data && response.data.length > 0) {
                $.each(response.data, function (index, item) {
                    var statusBadge = item.is_active == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>';
                    var companyNames = item.company_name ? item.company_name.split(',').join(', ') : '-';
                    var safeName = item.brand_name.replace(/'/g, "\\'");
                    var safeDesc = item.brand_desc ? encodeURIComponent(item.brand_desc) : '';
                    var safeCompanies = item.company_id ? item.company_id.replace(/'/g, "\\'") : '';
                    // potong text desc jika lebih dari 250 karakter
                    var desc = item.brand_desc ? item.brand_desc.substring(0, 250) : '';

                    html += `<tr>
                        <td>${index + 1}</td>
                        <td class="fw-bold">${item.brand_name}</td>
                        <td>${desc}</td>
                        <td>${companyNames}</td>
                        <td>${statusBadge}</td>
                        <td>
                            <button class="btn btn-sm btn-warning me-1 text-white" onclick="editBrand(${item.brand_id}, '${safeName}', '${safeDesc}', '${safeCompanies}', ${item.is_active})"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-danger text-white" onclick="deleteBrand(${item.brand_id})"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>`;
                });
            } else {
                html = '<tr><td colspan="5" class="text-center text-muted py-3">No brands found.</td></tr>';
            }
            $('#brandTable tbody').html(html);
        },
        error: function () { $('#brandTable tbody').html('<tr><td colspan="5" class="text-center text-danger">Failed to load data.</td></tr>'); }
    });
}
window.editBrand = function (id, name, desc, companies, isActive) {
    $('#brand_id').val(id);
    $('#brand_name').val(name);
    if (companies) $('#company_id').val(companies.split(',')).trigger('chosen:updated');
    else $('#company_id').val([]).trigger('chosen:updated');
    // Set OverType
    var decodedDesc = decodeURIComponent(desc);
    if (window.overTypeInstances['brand_desc']) window.overTypeInstances['brand_desc'].setValue(decodedDesc);
    $('#brand_desc_val').val(decodedDesc);
    $('#is_active').prop('checked', isActive == 1);
    $('#brandModalLabel').text('Edit Brand');
    $('#brandModal').modal('show');
}
window.deleteBrand = function (id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(BASE_URL + 'compas/settings/delete_brand', { brand_id: id }, function (res) {
                if (res.status == 'success') { Swal.fire('Deleted!', 'Brand has been deleted.', 'success'); loadBrands(); }
                else { Swal.fire('Error!', res.message, 'error'); }
            }, 'json');
        }
    })
}

// CONTENT PILLAR
function loadContentPillars() {
    $.ajax({
        url: BASE_URL + 'compas/settings/get_content_pillars',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var html = '';
            if (response.data && response.data.length > 0) {
                $.each(response.data, function (index, item) {
                    var statusBadge = item.is_active == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>';
                    var brandNames = item.brand_names ? item.brand_names.split(',').join(', ') : '-';
                    // Descriptions might contain HTML from OverType, strip or truncate
                    var desc = item.cp_desc ? item.cp_desc.substring(0, 50) + '...' : '-';
                    var safeName = item.cp_name.replace(/'/g, "\\'");
                    var safeDesc = item.cp_desc ? encodeURIComponent(item.cp_desc) : ''; // Encode for safe passing
                    var safeBrands = item.brand_id ? item.brand_id.replace(/'/g, "\\'") : '';

                    html += `<tr>
                        <td>${index + 1}</td>
                        <td class="fw-bold">${item.cp_name}</td>
                        <td>${brandNames}</td>
                        <td>${desc}</td>
                        <td>${statusBadge}</td>
                        <td>
                            <button class="btn btn-sm btn-warning me-1 text-white" onclick="editContentPillar(${item.cp_id}, '${safeName}', '${safeBrands}', '${safeDesc}', ${item.is_active})"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-danger text-white" onclick="deleteContentPillar(${item.cp_id})"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>`;
                });
            } else {
                html = '<tr><td colspan="6" class="text-center text-muted py-3">No content pillars found.</td></tr>';
            }
            $('#contentPillarTable tbody').html(html);
        },
        error: function () { $('#contentPillarTable tbody').html('<tr><td colspan="6" class="text-center text-danger">Failed to load data.</td></tr>'); }
    });
}
window.editContentPillar = function (id, name, brands, desc, isActive) {
    $('#cp_id').val(id);
    $('#cp_name').val(name);
    if (brands) $('#cp_brand_id').val(brands.split(',')).trigger('chosen:updated');
    else $('#cp_brand_id').val([]).trigger('chosen:updated');

    // Set OverType
    var decodedDesc = decodeURIComponent(desc);
    if (window.overTypeInstances['cp_desc']) window.overTypeInstances['cp_desc'].setValue(decodedDesc);
    $('#cp_desc_val').val(decodedDesc);

    $('#cp_is_active').prop('checked', isActive == 1);
    $('#contentPillarModalLabel').text('Edit Content Pillar');
    $('#contentPillarModal').modal('show');
}
window.deleteContentPillar = function (id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(BASE_URL + 'compas/settings/delete_content_pillar', { cp_id: id }, function (res) {
                if (res.status == 'success') { Swal.fire('Deleted!', 'Pillar has been deleted.', 'success'); loadContentPillars(); }
                else { Swal.fire('Error!', res.message, 'error'); }
            }, 'json');
        }
    })
}

// OBJECTIVE
function loadObjectives() {
    $.ajax({
        url: BASE_URL + 'compas/settings/get_objectives',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var html = '';
            if (response.data && response.data.length > 0) {
                $.each(response.data, function (index, item) {
                    var statusBadge = item.is_active == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>';
                    var brandNames = item.brand_names ? item.brand_names.split(',').join(', ') : '-';
                    var desc = item.objective_desc ? item.objective_desc.substring(0, 50) + '...' : '-';
                    var safeName = item.objective_name.replace(/'/g, "\\'");
                    var safeDesc = item.objective_desc ? encodeURIComponent(item.objective_desc) : '';
                    var safeBrands = item.brand_id ? item.brand_id.replace(/'/g, "\\'") : '';

                    html += `<tr>
                        <td>${index + 1}</td>
                        <td class="fw-bold">${item.objective_name}</td>
                        <td>${brandNames}</td>
                        <td>${desc}</td>
                        <td>${statusBadge}</td>
                        <td>
                            <button class="btn btn-sm btn-warning me-1 text-white" onclick="editObjective(${item.objective_id}, '${safeName}', '${safeBrands}', '${safeDesc}', ${item.is_active})"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-danger text-white" onclick="deleteObjective(${item.objective_id})"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>`;
                });
            } else {
                html = '<tr><td colspan="6" class="text-center text-muted py-3">No objectives found.</td></tr>';
            }
            $('#objectiveTable tbody').html(html);
        },
        error: function () { $('#objectiveTable tbody').html('<tr><td colspan="6" class="text-center text-danger">Failed to load data.</td></tr>'); }
    });
}
window.editObjective = function (id, name, brands, desc, isActive) {
    $('#objective_id').val(id);
    $('#objective_name').val(name);
    if (brands) $('#obj_brand_id').val(brands.split(',')).trigger('chosen:updated');
    else $('#obj_brand_id').val([]).trigger('chosen:updated');

    var decodedDesc = decodeURIComponent(desc);
    if (window.overTypeInstances['objective_desc']) window.overTypeInstances['objective_desc'].setValue(decodedDesc);
    $('#objective_desc_val').val(decodedDesc);

    $('#obj_is_active').prop('checked', isActive == 1);
    $('#objectiveModalLabel').text('Edit Objective');
    $('#objectiveModal').modal('show');
}
window.deleteObjective = function (id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(BASE_URL + 'compas/settings/delete_objective', { objective_id: id }, function (res) {
                if (res.status == 'success') { Swal.fire('Deleted!', 'Objective has been deleted.', 'success'); loadObjectives(); }
                else { Swal.fire('Error!', res.message, 'error'); }
            }, 'json');
        }
    })
}


// GENERATED CONTENT
function loadGeneratedContents() {
    $.ajax({
        url: BASE_URL + 'compas/settings/get_generated_contents',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var html = '';
            if (response.data && response.data.length > 0) {
                $.each(response.data, function (index, item) {
                    var statusBadge = item.is_active == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>';
                    var brandNames = item.brand_names ? item.brand_names.split(',').join(', ') : '-';
                    var desc = item.cg_desc ? item.cg_desc.substring(0, 50) + '...' : '-';
                    var safeName = item.cg_name.replace(/'/g, "\\'");
                    var safeDesc = item.cg_desc ? encodeURIComponent(item.cg_desc) : '';
                    var safeBrands = item.brand_id ? item.brand_id.replace(/'/g, "\\'") : '';

                    html += `<tr>
                        <td>${index + 1}</td>
                        <td class="fw-bold">${item.cg_name}</td>
                        <td>${brandNames}</td>
                        <td>${desc}</td>
                        <td>${statusBadge}</td>
                        <td>
                            <button class="btn btn-sm btn-warning me-1 text-white" onclick="editGeneratedContent(${item.cg_id}, '${safeName}', '${safeBrands}', '${safeDesc}', ${item.is_active})"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-danger text-white" onclick="deleteGeneratedContent(${item.cg_id})"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>`;
                });
            } else {
                html = '<tr><td colspan="6" class="text-center text-muted py-3">No generated contents found.</td></tr>';
            }
            $('#generatedContentTable tbody').html(html);
        },
        error: function () { $('#generatedContentTable tbody').html('<tr><td colspan="6" class="text-center text-danger">Failed to load data.</td></tr>'); }
    });
}
window.editGeneratedContent = function (id, name, brands, desc, isActive) {
    $('#cg_id').val(id);
    $('#cg_name').val(name);
    if (brands) $('#gen_brand_id').val(brands.split(',')).trigger('chosen:updated');
    else $('#gen_brand_id').val([]).trigger('chosen:updated');

    var decodedDesc = decodeURIComponent(desc);
    if (window.overTypeInstances['cg_desc']) window.overTypeInstances['cg_desc'].setValue(decodedDesc);
    $('#cg_desc_val').val(decodedDesc);

    $('#gen_is_active').prop('checked', isActive == 1);
    $('#generatedContentModalLabel').text('Edit Generated Content');
    $('#generatedContentModal').modal('show');
}
window.deleteGeneratedContent = function (id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(BASE_URL + 'compas/settings/delete_generated_content', { cg_id: id }, function (res) {
                if (res.status == 'success') { Swal.fire('Deleted!', 'Content has been deleted.', 'success'); loadGeneratedContents(); }
                else { Swal.fire('Error!', res.message, 'error'); }
            }, 'json');
        }
    })
}

// CONTENT FORMAT
function loadContentFormats() {
    $.ajax({
        url: BASE_URL + 'compas/settings/get_content_formats',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var html = '';
            if (response.data && response.data.length > 0) {
                $.each(response.data, function (index, item) {
                    var statusBadge = item.is_active == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>';
                    var brandNames = item.brand_names ? item.brand_names.split(',').join(', ') : '-';
                    var desc = item.cf_desc ? item.cf_desc.substring(0, 50) + '...' : '-';
                    var safeName = item.cf_name.replace(/'/g, "\\'");
                    var safeDesc = item.cf_desc ? encodeURIComponent(item.cf_desc) : '';
                    var safeBrands = item.brand_id ? item.brand_id.replace(/'/g, "\\'") : '';

                    html += `<tr>
                        <td>${index + 1}</td>
                        <td class="fw-bold">${item.cf_name}</td>
                        <td>${brandNames}</td>
                        <td>${desc}</td>
                        <td>${statusBadge}</td>
                        <td>
                            <button class="btn btn-sm btn-warning me-1 text-white" onclick="editContentFormat(${item.cf_id}, '${safeName}', '${safeBrands}', '${safeDesc}', ${item.is_active})"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-danger text-white" onclick="deleteContentFormat(${item.cf_id})"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>`;
                });
            } else {
                html = '<tr><td colspan="6" class="text-center text-muted py-3">No content formats found.</td></tr>';
            }
            $('#contentFormatTable tbody').html(html);
        },
        error: function () { $('#contentFormatTable tbody').html('<tr><td colspan="6" class="text-center text-danger">Failed to load data.</td></tr>'); }
    });
}
window.editContentFormat = function (id, name, brands, desc, isActive) {
    $('#cf_id').val(id);
    $('#cf_name').val(name);
    if (brands) $('#fmt_brand_id').val(brands.split(',')).trigger('chosen:updated');
    else $('#fmt_brand_id').val([]).trigger('chosen:updated');

    var decodedDesc = decodeURIComponent(desc);
    if (window.overTypeInstances['cf_desc']) window.overTypeInstances['cf_desc'].setValue(decodedDesc);
    $('#cf_desc_val').val(decodedDesc);

    $('#fmt_is_active').prop('checked', isActive == 1);
    $('#contentFormatModalLabel').text('Edit Content Format');
    $('#contentFormatModal').modal('show');
}
window.deleteContentFormat = function (id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(BASE_URL + 'compas/settings/delete_content_format', { cf_id: id }, function (res) {
                if (res.status == 'success') { Swal.fire('Deleted!', 'Format has been updated.', 'success'); loadContentFormats(); }
                else { Swal.fire('Error!', res.message, 'error'); }
            }, 'json');
        }
    })
}