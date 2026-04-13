
window.LoadInit = window.LoadInit || {};
window.LoadInit['tabs'] = window.LoadInit['tabs'] || {};
window.LoadInit['tabs']['activation'] = function (container) {
    loadActivationDetail();
    loadGlobalActivityLog('activation');
};

async function loadActivationDetail() {
    showLoader({ target: `#tabs-content`, overlay: false });

    // Changed to FormData so CodeIgniter's $this->input->post() can read it
    const formData = new FormData();
    formData.append('campaign_id', $detailId.value);

    try {
        const response = await fetch(`${BASE_URL}compas/activation/detail`, {
            method: 'POST',
            body: formData,
        });

        const data = await response.json();
        let activations = data.activations;
        let campaign = campaignData;

        if (campaign) {
            // Populate form fields
            $('#form-campaign-id').val(campaign.campaign_id);
            $('#form-activation-target').val(campaign.activation_target);
            $('#form-campaign-name').val(campaign.campaign_name);
            // Set OverType editor for Target Audience
            let targetAudience = campaign.target_audience || '';
            $('#form-target-audience').val(targetAudience);
        } else {
            // Clear form fields
            $('#form-campaign-id').val('');
            $('#form-activation-target').val('');
            $('#form-campaign-name').val('');
            $('#form-target-audience').val('');
        }

        if (activations && activations.length > 0) {
            $(`#activation-content-section`).fadeIn(250);
            $(`#activation-empty-state`).hide();
            await renderActivation(activations);
        } else {
            $('#activation-table-body').empty();
            $(`#activation-content-section`).hide();
            $(`#activation-empty-state`).fadeIn(250);
        }
    } catch (e) {
        console.error(e);
    } finally {
        hideLoader();
    }
}

async function renderActivation(activations) {
    // Render rows into the table body
    const rowsHtml = await renderActivationRows(activations);
    $('#activation-table-body').html(rowsHtml);
    
    // Initialize tooltips for new elements
    initHoverableTooltips('#activation-table-body [data-bs-toggle="tooltip"]');
}

// Update renderActivationRows to use editActivation
async function renderActivationRows(activations) {
    let rows = '';

    await activations.forEach(activation => {
        let statusBadge = '';
        
        const status = SUB_STATUS[activation.status].name; 
        
        if (status === 'APPROVED') {
            statusBadge = `<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2">${status}</span>`;
        } else if (status === 'WAITING') {
             statusBadge = `<span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-2">${status}</span>`;
        } else if (status === 'ON REVIEW') {
             statusBadge = `<span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-2">${status}</span>`;
        } else if (status === 'REJECTED') {
             statusBadge = `<span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2">${status}</span>`;
        } else {
            statusBadge = `<span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-2">${status}</span>`;
        }

        const taskName = activation.title || 'Untitled Task';
        const taskDesc = activation.description || 'No description'; 
        
        let picIds = activation.pic_ids ? activation.pic_ids.split(',') : [];
        let picNames = activation.pic_names ? activation.pic_names.split(',') : [];
        let picPictures = activation.pic_pictures ? activation.pic_pictures.split(',') : [];

        if (picIds.length === 0 && activation.pic) {
             picIds = activation.pic.split(',');
        }

        let assignedPics = picIds.map((id, index) => {
            return {
                id: id,
                name: picNames[index] || 'User',
                picture: picPictures[index] || ''
            };
        });

        const defaultAvatarUrl = 'https://trusmiverse.com/hr/uploads/profile/anonim.jpg'; 
        
    // Generate PIC HTML
        let picHtml = '';
        if (assignedPics.length > 0) {
            picHtml = '<div class="d-flex align-items-center">';
            const displayLimit = 2;
            const visiblePics = assignedPics.slice(0, displayLimit);
            const remainingCount = assignedPics.length - displayLimit;
            
            visiblePics.forEach((pic, index) => {
                let name = pic.name;
                let src = pic.picture ? `https://trusmiverse.com/hr/uploads/profile/${pic.picture}` : defaultAvatarUrl;
                
                const marginStyle = index > 0 ? 'margin-left: -8px;' : '';
                picHtml += `<img alt="${name}" class="rounded-circle border border-2 border-white"
                            src="${src}"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="${name}"
                            width="28" height="28" style="${marginStyle}" 
                            onerror="this.src='${defaultAvatarUrl}'"/>`;
            });

            if (remainingCount > 0) {
                picHtml += `<div class="rounded-circle border border-2 border-white bg-light d-flex align-items-center justify-content-center fw-bold text-secondary"
                            style="width: 28px; height: 28px; font-size: 10px; margin-left: -8px; cursor: help;"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="${assignedPics.slice(displayLimit).map(p => p.name).join(', ')}">
                            +${remainingCount}
                        </div>`;
            }
            picHtml += '</div>';
        } else {
            picHtml = '<span class="text-muted small">Unassigned</span>';
        }

        rows += `
            <tr>
                <td class="px-4 py-3 border-bottom-0">
                    <div class="fw-bold small">${taskName}</div>
                    <div class="text-muted text-truncate" style="font-size: 10px; max-width: 150px;">${taskDesc}</div>
                </td>
                <td class="px-4 py-3 border-bottom-0">
                    ${picHtml}
                </td>
                <td class="px-4 py-3 border-bottom-0 text-center">
                    ${statusBadge}
                </td>
                <td class="px-4 py-3 border-bottom-0 text-end">
                     <button class="btn btn-link text-muted p-0 hover-primary me-2" 
                        data-bs-toggle="modal" data-bs-target="#modal-sub-detail" 
                        onclick="loadSubDetail('${activation.activation_id}', 'activation')"
                        title="View Details">
                        <i class="bi bi-file-text"></i>
                    </button>
                    ${(status !== 'APPROVED' && status !== 'REJECTED') ? 
                    `<button class="btn btn-link text-success p-0 hover-primary me-2" 
                        onclick="editActivation('${activation.activation_id}')"
                        title="Edit Task">
                        <i class="bi bi-pencil-square"></i>
                    </button>` : ''}
                    <button class="btn btn-link text-primary p-0 hover-primary" 
                        onclick="viewActivationAnalysis('${activation.activation_id}')" 
                        data-bs-toggle="tooltip" title="View AI Analysis">
                        <i class="bi bi-bar-chart-line-fill"></i>
                    </button>
                </td>
            </tr>
        `;
    });

    return rows;
}

// Global toggle functions for activation tab
window.showActivationForm = function () {
    const modal = new bootstrap.Modal(document.getElementById('modal-activation-form'));
    
    // Clear form for "Add"
    $('#activation-form')[0].reset();
    $('#form-activation-id').val(''); // Clear ID
    $('#activation-modal-title').text('Add Activation');
    
    // Reset plugins if needed (clear OverType, Chosen)
    // Re-populate campaign data
    $('#form-campaign-id').val(campaignData.campaign_id);
    $('#form-activation-target').val(campaignData.activation_target);
    $('#form-campaign-name').val(campaignData.campaign_name);
    
    // Use OverType to set value
    if (window.activationTargetAudienceEditor) {
         window.activationTargetAudienceEditor.setValue(campaignData.target_audience || '');
    } else {
         $('#form-target-audience').val(campaignData.target_audience || '');
    }
    
    if (window.activationDescriptionEditor) {
         window.activationDescriptionEditor.setValue('');
    }

    // Reset Chosen
    $('.chosen-select').val('').trigger('chosen:updated');

    modal.show();

    // Initialize plugins when modal is shown (using event listener preferably, but calling here works if elements exist)
    setTimeout(() => {
        initializeActivationPlugins();
    }, 200);
    
    return false;
};

window.hideActivationForm = function () {
    const modalEl = document.getElementById('modal-activation-form');
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) {
        modal.hide();
    }
};

window.editActivation = async function(activationId) {
     showLoader({ target: `#tabs-content`, overlay: true });
     try {
        const formData = new FormData();
        formData.append('activation_id', activationId);

        const response = await fetch(`${BASE_URL}compas/activation/get_activation_detail`, {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        if (result.status === 'success') {
            const data = result.data;
            
            // Populate Form
            $('#form-activation-id').val(data.activation_id);
            $('#form-campaign-id').val(data.campaign_id);
            $('#form-activation-target').val(campaignData.activation_target); // From global
            $('#form-campaign-name').val(campaignData.campaign_name);
            $('#form-activation-title').val(data.title);
            $('#form-activation-period-start').val(data.period_start);
            $('#form-activation-period-end').val(data.period_end);
            $('#form-budget').val(formatRibuanActivation(data.budget));
            
            // Populate OverType
            if (window.activationTargetAudienceEditor) {
                window.activationTargetAudienceEditor.setValue(data.target_audience || '');
            } else {
                 $('#form-target-audience').val(data.target_audience);
            }

            if (window.activationDescriptionEditor) {
                window.activationDescriptionEditor.setValue(data.description || ''); // description mapped to logic
            } else {
                 $('#form-current-activation').val(data.description);
            }
            
            // Populate Chosen logic moved to initializeActivationPlugins to ensure options exist
            const selectedValues = {
                pic: data.pic ? data.pic.split(',') : [],
                platform: data.platforms ? data.platforms.split(',') : [],
                content: data.content_produced ? data.content_produced.split(',') : []
            };

            // Open Modal
            const modal = new bootstrap.Modal(document.getElementById('modal-activation-form'));
            $('#activation-modal-title').text('Edit Activation');
            modal.show();
            
            setTimeout(() => {
                 initializeActivationPlugins(selectedValues);
            }, 200);

        } else {
            Swal.fire('Error', 'Failed to fetch activation details', 'error');
        }
    } catch (error) {
        console.error(error);
        Swal.fire('Error', 'An error occurred', 'error');
    } finally {
        hideLoader();
    }
}

// Global variables for editors need to be accessible
window.activationTargetAudienceEditor = null;
window.activationDescriptionEditor = null;

function initializeActivationPlugins(selectedValues = {}) {
    // If PIC is not set (create mode), default to current user
    if (typeof CURRENT_USER_ID !== 'undefined') {
        if(!selectedValues.pic){
            selectedValues.pic = [];
        }
        selectedValues.pic.push(CURRENT_USER_ID);
    }
    
    //initialize Variables
    // Wizard Logic
    let activationCurrentStep = 1;
    const activationTotalSteps = 3;
    const overtypeColors = { bgPrimary: '#015EC2', bgSecondary: '#ffffff', text: '#0d3b66', h1: '#f95738', h2: '#ee964b', h3: '#3d8a51', strong: '#ee964b', em: '#f95738', link: '#0d3b66', code: '#0d3b66', codeBg: 'rgba(244, 211, 94, 0.2)', blockquote: '#5a7a9b', hr: '#5a7a9b', syntaxMarker: 'rgba(13, 59, 102, 0.52)', cursor: '#f95738', selection: 'rgba(1, 94, 194, 0.8)' }


    //initialize Functions
    function showActivationStep(step) {
        // Hide all steps
        $('#activation-form .wizard-step').hide();
        // Show current step
        $(`#activation-form .wizard-step[data-step="${step}"]`).fadeIn();

        // Update buttons (Targeting modal footer buttons)
        if (step === 1) {
            $('#modal-activation-form .btn-prev').prop('disabled', true);
        } else {
            $('#modal-activation-form .btn-prev').prop('disabled', false);
        }

        if (step === activationTotalSteps) {
            $('#modal-activation-form .btn-next').hide();
            $('#modal-activation-form .btn-finish').show();
        } else {
            $('#modal-activation-form .btn-next').show();
            $('#modal-activation-form .btn-finish').hide();
        }

        // Update progress bar
        const progress = (step / activationTotalSteps) * 100;
        $('.wizard-progress .progress-bar').css('width', `${progress}%`).attr('aria-valuenow', progress);
    }

    // Only fetch dependent data if options are empty (to avoid re-fetching on every modal open if not needed, or force fetch?)
    // Actually, force fetch to ensure fresh data is better.
    if ($.fn.chosen) {
        $('.chosen-select').chosen({ width: "100%" });
        
        // Helper to check if we should fetch or just set value
        const handleChosenData = (selectId, fetchUrl, postData, valueKey, textKey, label, selected) => {
            if ($(selectId + ' option').length <= 1) {
                // Fetch and then select
                fetchDependentData(fetchUrl, postData, selectId, valueKey, textKey, selected || [], label);
            } else if (selected && selected.length > 0) {
                // Already populated, just select
                $(selectId).val(selected).trigger('chosen:updated');
            }
        };

        handleChosenData('#form-pic', 'compas/activation/get_pics', { id: campaignData.campaign_id }, 'pic_id', 'pic_name', 'PIC', selectedValues.pic);
        handleChosenData('#platform-tujuan', 'compas/activation/get_platforms', { id: campaignData.brand_id }, 'platform_id', 'platform_name', 'Platform Tujuan', selectedValues.platform);
        handleChosenData('#content-result', 'compas/campaign/get_generated_contents', { brand_id: campaignData.brand_id }, 'cg_id', 'cg_name', 'Content Generated', selectedValues.content);
    }

    // Initialize Datepicker
    if ($.fn.datetimepicker) {
        $('.tanggal').datetimepicker({
            format: 'Y-m-d',
            timepicker: false,
            scrollMonth: false,
            scrollInput: false
        });
    }
    
    // Format Ribuan for Budget
    $('#form-budget').off('keyup').on('keyup', function () {
        $(this).val(formatRibuanActivation($(this).val().replace(/\./g, '')));
    });

    // Initialize OverType Editors
    // Target Audience Editor
    if (document.getElementById('overtype-target-audience')) {
        let initialValue = $('#form-target-audience').val() || '';
        
        // Check if instance already exists on this element
        if (!window.activationTargetAudienceEditor) { 
            [window.activationTargetAudienceEditor] = new OverType('#overtype-target-audience', {
                theme: {
                    name: 'custom-theme',
                    colors: overtypeColors
                },
                toolbar: true,
                placeholder: 'Target Audiens',
                value: initialValue,
                onChange: (value, instance) => {
                    $('#form-target-audience').val(value);
                }
            });
        }
    }

    // Description (Aktivasi yang Berjalan) Editor
    if (document.getElementById('overtype-current-activation')) {
        let initialDesc = $('#form-current-activation').val() || '';
         if (!window.activationDescriptionEditor) { 
            [window.activationDescriptionEditor] = new OverType('#overtype-current-activation', {
                theme: {
                    name: 'custom-theme',
                    colors: overtypeColors
                },
                toolbar: true,
                placeholder: 'Aktivasi yang Berjalan',
                value: initialDesc,
                onChange: (value, instance) => {
                    $('#form-current-activation').val(value);
                }
            });
         }
    }

    // Wizard Button Handlers
    $('#modal-activation-form .btn-prev').off('click').on('click', function () {
        if (activationCurrentStep > 1) {
            activationCurrentStep--;
            showActivationStep(activationCurrentStep);
        }
    });

    $('#modal-activation-form .btn-next').off('click').on('click', function () {
        if (validateActivationStep(activationCurrentStep)) {
            if (activationCurrentStep < activationTotalSteps) {
                activationCurrentStep++;
                showActivationStep(activationCurrentStep);
            }
        }
    });
    showActivationStep(1);
    
    // Helper function for fetching (reuse existing if available or redefine)
     function fetchDependentData(url, postData, targetId, valueKey, textKey, selected, label) {
        $.ajax({
            url: BASE_URL + url,
            type: 'POST',
            data: postData,
            dataType: 'json',
            success: function (response) {
                var html = '';
                if (response.data && response.data.length > 0) {
                    $.each(response.data, function (index, item) {
                        html += `<option value="${item[valueKey]}">${item[textKey]}</option>`;
                    });
                    $(targetId).html(html).trigger("chosen:updated");
                    
                    // Apply selected values if provided
                    if (selected && selected.length > 0) {
                        $(targetId).val(selected).trigger('chosen:updated');
                    }
                } 
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }
}

function validateActivationStep(step) {
    let isValid = true;
    const stepContainer = $(`#activation-form .wizard-step[data-step="${step}"]`);

    stepContainer.find('input[required], select[required], textarea[required]').each(function () {
        if (!$(this).val() || $(this).val().length === 0) {
            isValid = false;
            $(this).addClass('is-invalid');
            // For Chosen selects
            if ($(this).hasClass('chosen-select')) {
                $(this).next('.chosen-container').addClass('border border-danger rounded');
            }
        } else {
            $(this).removeClass('is-invalid');
            if ($(this).hasClass('chosen-select')) {
                $(this).next('.chosen-container').removeClass('border border-danger rounded');
            }
        }
    });

    if (!isValid) {
        Swal.fire({
            icon: 'warning',
            title: 'Incomplete Step',
            text: 'Please fill in all required fields before proceeding.'
        });
    }

    return isValid;
}

function formatRibuanActivation(number) {
    // if (number === 0) return "0";
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// --- New Features ---

// window.openViewFullLog = function() {
//     var myModal = new bootstrap.Modal(document.getElementById('modal-full-log'));
//     myModal.show();
// };

window.chatSimulation = function() {
    const input = document.getElementById('chat-input');
    const container = document.getElementById('chat-container');
    const message = input.value.trim();
    
    if (message) {
        // current time
        const now = new Date();
        const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        // User Message HTML
        const userMsgHTML = `
            <div class="d-flex gap-3 flex-row-reverse animate-slide-in-right">
                <img alt="Avatar" class="rounded-circle"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuD0QrFaDvNO5ek-f5zTSrRhw2kEpCPslAnlLL9tYVNrjkFih2IS8g7d2UTnj2jMeIMinilpvaFR7fpVu64VvcpcFjrvnefmRiwFFwmkeha-OjsLXwJWrkomAccDGakcGHIesdbZ9UJSfDRKjabp03xwHv4j7rXctc5KEA2PJfHJ11RZRRTNL09aUMqcBRk8mwoDu3tKewW5DKfQGBEtr2gxIpbrbHkK38P7TQVahkwItdmDVC87BAdJ6IhJCtVnbaHKnTwTX0H4RBae"
                    width="32" height="32" />
                <div class="d-flex flex-column align-items-end gap-1 text-end" style="max-width: 80%;">
                    <div class="d-flex align-items-baseline gap-2 flex-row-reverse">
                        <span class="fw-bold small">You</span>
                        <span class="text-muted" style="font-size: 10px;">${timeString}</span>
                    </div>
                    <div class="bg-primary text-white p-3 rounded-3 rounded-top-0 small shadow-sm">
                        ${message}
                    </div>
                </div>
            </div>
        `;
        
        // Append and scroll
        container.insertAdjacentHTML('beforeend', userMsgHTML);
        input.value = '';
        container.scrollTop = container.scrollHeight;
        
        // Simulate Reply
        setTimeout(() => {
            const replyMsgHTML = `
                <div class="d-flex gap-3 animate-slide-in-left">
                    <img alt="Avatar" class="rounded-circle"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBUW6hnNf3OSX_JQVBmRHzEKoWecHXDn-nDsdmxjENdcNscPTcvFw4SoZUCsJ_GsKOf3aO1onNgay4IPwbLgD6bMWZGIE-vnjwA5_P9T5Z5W6MuiXl9oQpVsjA1NByFgYEjuceIOMYJ0ZoeYp0nXEmmmi1eSsK7Uab6G4-TgSSlJAaEAhn_kJkk_SIpbcj60nJnE-bNPltPVLfz4oZDj_O2TyRh85QBveOpINIkDnOorJA_ZMzHLXL9CtmWVRxVG1NBhRW7W5_7w0ng"
                        width="32" height="32" />
                    <div class="d-flex flex-column gap-1" style="max-width: 80%;">
                        <div class="d-flex align-items-baseline gap-2">
                            <span class="fw-bold small">Sarah Jenkins</span>
                            <span class="text-muted" style="font-size: 10px;">Just now</span>
                        </div>
                        <div class="bg-light p-3 rounded-3 rounded-top-0 small shadow-sm">
                            Got it! I'll take a look shortly. 👍
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', replyMsgHTML);
            container.scrollTop = container.scrollHeight;
        }, 2000);
    }
};

window.handleChatKeyPress = function(event) {
    if (event.key === 'Enter') {
        window.chatSimulation();
    }
};



window.animateEfficiency = function() {
    const el = document.querySelector('.fs-4.fw-bolder');
    if (el && el.innerText.includes('%')) {
        let target = parseInt(el.innerText);
        let current = 0;
        const interval = setInterval(() => {
            current += 2;
            if (current >= target) {
                current = target;
                clearInterval(interval);
            }
            el.innerText = current + '%';
        }, 20);
    }
}

window.submitActivationForm = async function () {
    const $form = $('#activation-form');
    // Basic Validation
    if (!$form[0].checkValidity()) {
        $form[0].reportValidity();
        return;
    }

    const formData = new FormData($form[0]);
    const activationId = formData.get('activation_id');
    const url = activationId ? `${BASE_URL}compas/activation/update` : `${BASE_URL}compas/activation/add`;

    // Target the modal content for loader since form section is gone
    showLoader({text: 'Saving and Analyzing...'});

    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
        });

        const result = await response.json();

        if (result.status === 'success') {
            await loadActivationDetail();
            hideActivationForm();
             Swal.fire({
                icon: 'success',
                title: 'Success',
                text: result.message,
                timer: 1500,
                showConfirmButton: false
            });
            $form[0].reset();
        } else {
             Swal.fire({
                icon: 'error',
                title: 'Error',
                text: result.message
            });
        }
    } catch (error) {
        console.error('Error submitting form:', error);
         Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while saving.'
        });
    } finally {
        hideLoader();
    }
};

window.initHoverableTooltips = function(selector) {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll(selector));
    
    // Cleanup existing instances first if needed, though usually new DOM elements are clean
    
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        let tooltip = bootstrap.Tooltip.getInstance(tooltipTriggerEl);
        if (tooltip) {
            tooltip.dispose();
        }

        // Initialize new tooltip with manual trigger
        tooltip = new bootstrap.Tooltip(tooltipTriggerEl, {
            trigger: 'manual',
            html: true // Allow HTML content
        });

        let hideTimeout;

        // Ensure we remove previous listeners to avoid duplicates
        $(tooltipTriggerEl).off('mouseenter mouseleave');

        $(tooltipTriggerEl).on('mouseenter', function () {
            if (hideTimeout) clearTimeout(hideTimeout);
            tooltip.show();

            // Wait for tooltip element to exist in DOM
            setTimeout(() => {
                const tip = document.querySelector('.tooltip.show'); // Find active tooltip
                if (tip) {
                    // Make tooltip interactive
                    tip.style.pointerEvents = 'auto';

                    $(tip).off('mouseenter mouseleave');
                    
                    $(tip).on('mouseenter', function () {
                        if (hideTimeout) clearTimeout(hideTimeout);
                    });

                    $(tip).on('mouseleave', function () {
                        hideTimeout = setTimeout(() => tooltip.hide(), 200);
                    });
                }
            }, 50); // Small delay to ensure render
        });

        $(tooltipTriggerEl).on('mouseleave', function () {
            hideTimeout = setTimeout(() => tooltip.hide(), 200);
        });
    });
};

// function loadActivationSubDetail moved to detail.js (loadSubDetail)

window.viewActivationAnalysis = async function (activationId) {
    const modal = new bootstrap.Modal(document.getElementById('modal-activation-analysis'));
    modal.show();

    // Show loading state
    const modalBody = document.getElementById('analysis-modal-body');
    modalBody.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 text-muted">Analyzing Activation Data...</p>
        </div>
    `;

    try {
        const formData = new FormData();
        formData.append('activation_id', activationId);

        const response = await fetch(`${BASE_URL}compas/activation/get_analysis`, {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.status === 'success') {
            const data = result.data;
            renderAnalysisData(data);
        } else {
            modalBody.innerHTML = `
                <div class="text-center py-5">
                    <i class="bi bi-exclamation-circle display-4 text-warning"></i>
                    <p class="mt-3 fw-bold">Analysis Not Found</p>
                    <p class="text-muted small">No AI analysis data is available for this activation yet.</p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error fetching analysis:', error);
        modalBody.innerHTML = `
            <div class="text-center py-5">
                <i class="bi bi-x-circle display-4 text-danger"></i>
                <p class="mt-3 fw-bold">Error Loading Analysis</p>
                <p class="text-muted small">An error occurred while retrieving the data.</p>
            </div>
        `;
    }
};

function renderAnalysisData(data) {
    // Helper for safe access
    const getScore = (val) => val || 0;
    const safeJson = (val) => val || {};

    const overallScore = getScore(data.overall_score);
    const strategicScore = getScore(data.strategic_score);
    const date = data.analysis_date || '-';
    const eventName = data.event_name || 'Unnamed Event';

    // Scores Color Function
    const getScoreColor = (score) => {
        if (score >= 80) return '#10b981'; // Green
        if (score >= 60) return '#3b82f6'; // Blue
        if (score >= 40) return '#f59e0b'; // Orange
        return '#ef4444'; // Red
    };

    const overallColor = getScoreColor(overallScore);
    const strategicColor = getScoreColor(strategicScore);

    // Detail Alignment
    const detailAlignment = safeJson(data.detail_alignment);
    let detailHtml = '';
    for (const [key, value] of Object.entries(detailAlignment)) {
        const label = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        const width = value + '%';
        const color = getScoreColor(value);
        detailHtml += `
            <div class="radar-bar-container">
                <div class="radar-bar-label d-flex justify-content-between mb-1">
                    <span class="text-secondary small fw-bold">${label}</span>
                    <span class="small fw-bold" style="color:${color}">${value}%</span>
                </div>
                <div class="radar-bar-bg bg-light rounded-pill overflow-hidden" style="height: 6px;">
                    <div class="radar-bar-fill rounded-pill" style="height: 100%; width: ${width}; background-color: ${color}; transition: width 1s ease-out;"></div>
                </div>
            </div>
        `;
    }

    // SWOT Data Processing
    const swot = {
        strengths: safeJson(data.swot_strengths),
        weaknesses: safeJson(data.swot_weaknesses),
        opportunities: safeJson(data.swot_opportunities),
        threats: safeJson(data.swot_threats)
    };

    const renderSwotList = (items) => {
        if (!items || !items.length) return '<li class="text-muted small fst-italic">No points listed</li>';
        return items.map(item => `<li>${item}</li>`).join('');
    };

    // Funnel Impact Processing
    const funnel = safeJson(data.funnel_impact);
    let funnelHtml = '';
    const funnelOrder = ['skor_awareness', 'skor_consideration', 'skor_conversion', 'skor_loyalty'];
    
    funnelOrder.forEach(key => {
        if (funnel[key] !== undefined) {
             const label = key.replace('skor_', '').replace(/\b\w/g, l => l.toUpperCase());
             const val = funnel[key];
             if(val !== null){
                 funnelHtml += `
                    <div class="d-flex align-items-center mb-2 p-2 bg-light rounded-3 border border-light">
                        <span class="fw-bold small text-secondary text-uppercase" style="width: 100px;">${label}</span>
                        <div class="flex-grow-1 mx-3 bg-white rounded-pill overflow-hidden" style="height: 8px;">
                            <div class="h-100 rounded-pill bg-primary" style="width: ${val}%;"></div>
                        </div>
                        <span class="fw-bold text-primary small" style="width: 30px; text-align: right;">${val}</span>
                    </div>
                 `;
             }
        }
    });

    // Recommendations Processing
    const recommendations = safeJson(data.recommendations);
    let recsHtml = '';
     if (recommendations.jangka_pendek && recommendations.jangka_pendek.length > 0) {
        recsHtml += `<div class="mb-3">
                        <h6 class="fw-bold text-primary small text-uppercase mb-2"><i class="bi bi-stopwatch"></i> Short Term</h6>
                        ${recommendations.jangka_pendek.map(r => `<div class="recommendation-item small bg-light p-2 mb-1 border-start border-3 border-primary rounded-end">${r}</div>`).join('')}
                    </div>`;
    }
    if (recommendations.jangka_panjang && recommendations.jangka_panjang.length > 0) {
         recsHtml += `<div class="mb-3">
                        <h6 class="fw-bold text-info small text-uppercase mb-2"><i class="bi bi-calendar-check"></i> Long Term</h6>
                        ${recommendations.jangka_panjang.map(r => `<div class="recommendation-item small bg-light p-2 mb-1 border-start border-3 border-info rounded-end">${r}</div>`).join('')}
                     </div>`;
    }
     if (recommendations.ide_scaling && recommendations.ide_scaling.length > 0) {
         recsHtml += `<div class="mb-0">
                        <h6 class="fw-bold text-success small text-uppercase mb-2"><i class="bi bi-graph-up-arrow"></i> Scaling Ideas</h6>
                        ${recommendations.ide_scaling.map(r => `<div class="recommendation-item small bg-light p-2 mb-1 border-start border-3 border-success rounded-end">${r}</div>`).join('')}
                     </div>`;
    }

    // Executive Summary Processing
    const summary = safeJson(data.executive_summary);
    let summaryText = Array.isArray(summary) ? summary.join(' ') : (summary || 'No summary available.');

    // Constructing the HTML
    const html = `
        <div class="container-fluid px-0">
            <div class="row g-4">
                <!-- Left Column: Scores & Metrics -->
                <div class="col-lg-4">
                    <div class="d-flex flex-column gap-4 h-100">
                        <!-- Score Card -->
                        <div class="analysis-card bg-white p-4 rounded-4 shadow-sm text-center border">
                            <h6 class="fw-bold text-secondary text-uppercase small mb-4">Overall Performance</h6>
                            <div class="position-relative mx-auto mb-3" style="width: 140px; height: 140px; background: conic-gradient(${overallColor} ${overallScore * 3.6}deg, #f3f4f6 0deg); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <div class="bg-white rounded-circle d-flex flex-column align-items-center justify-content-center" style="width: 110px; height: 110px;">
                                    <span class="display-4 fw-bold" style="color: ${overallColor}; line-height: 1;">${overallScore}</span>
                                    <span class="small text-muted fw-bold text-uppercase" style="font-size: 0.65rem;">Score</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center gap-2 mt-2">
                                <div class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                    <span class="fw-bold" style="color: ${strategicColor}">${strategicScore}</span> 
                                    <span class="text-muted small ms-1">STRATEGIC</span>
                                </div>
                            </div>
                        </div>

                        <!-- Alignment Card -->
                        <div class="analysis-card bg-white p-4 rounded-4 shadow-sm border flex-grow-1">
                            <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2 border-bottom pb-2">
                                <i class="bi bi-sliders text-primary"></i> Detail Alignment
                            </h6>
                            <div class="d-flex flex-column gap-3">
                                ${detailHtml}
                            </div>
                        </div>
                        
                        <!-- Funnel Card -->
                        <div class="analysis-card bg-white p-4 rounded-4 shadow-sm border">
                            <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2 border-bottom pb-2">
                                <i class="bi bi-funnel text-primary"></i> Funnel Impact
                            </h6>
                            ${funnelHtml}
                        </div>
                    </div>
                </div>

                <!-- Right Column: Qualitative Analysis -->
                <div class="col-lg-8">
                    <div class="d-flex flex-column gap-4 h-100">
                        <!-- Executive Summary -->
                        <div class="analysis-card bg-white p-4 rounded-4 shadow-sm border">
                            <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2 border-bottom pb-2">
                                <i class="bi bi-file-earmark-text text-primary"></i> Executive Summary
                            </h6>
                            <div class="bg-light p-4 rounded-3 position-relative">
                                <i class="bi bi-quote text-primary opacity-25 display-3 position-absolute top-0 start-0 ms-3 mt-n2"></i>
                                <p class="mb-0 text-secondary position-relative z-1" style="line-height: 1.7; text-indent: 3rem;">${summaryText}</p>
                            </div>
                        </div>

                        <!-- SWOT Grid -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="h-100 p-3 rounded-3 border" style="background-color: #ecfdf5; border-color: #a7f3d0 !important;">
                                    <div class="fw-bold text-success mb-2 d-flex align-items-center gap-2"><i class="bi bi-lightning-charge-fill"></i> STRENGTHS</div>
                                    <ul class="ps-3 mb-0 small text-secondary" style="list-style-type: disc;">${renderSwotList(swot.strengths)}</ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="h-100 p-3 rounded-3 border" style="background-color: #fef2f2; border-color: #fecaca !important;">
                                    <div class="fw-bold text-danger mb-2 d-flex align-items-center gap-2"><i class="bi bi-exclamation-triangle-fill"></i> WEAKNESSES</div>
                                    <ul class="ps-3 mb-0 small text-secondary" style="list-style-type: disc;">${renderSwotList(swot.weaknesses)}</ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="h-100 p-3 rounded-3 border" style="background-color: #eff6ff; border-color: #bfdbfe !important;">
                                    <div class="fw-bold text-primary mb-2 d-flex align-items-center gap-2"><i class="bi bi-lightbulb-fill"></i> OPPORTUNITIES</div>
                                    <ul class="ps-3 mb-0 small text-secondary" style="list-style-type: disc;">${renderSwotList(swot.opportunities)}</ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="h-100 p-3 rounded-3 border" style="background-color: #fff7ed; border-color: #fed7aa !important;">
                                    <div class="fw-bold text-warning mb-2 d-flex align-items-center gap-2"><i class="bi bi-shield-exclamation"></i> THREATS</div>
                                    <ul class="ps-3 mb-0 small text-secondary" style="list-style-type: disc;">${renderSwotList(swot.threats)}</ul>
                                </div>
                            </div>
                        </div>

                        <!-- Recommendations -->
                        <div class="analysis-card bg-white p-4 rounded-4 shadow-sm border flex-grow-1">
                             <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2 border-bottom pb-2">
                                <i class="bi bi-signpost-split text-primary"></i> Strategic Recommendations
                            </h6>
                            <div class="row g-3">
                                <div class="col-12">
                                    ${recsHtml}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.getElementById('analysis-modal-body').innerHTML = html;
    document.getElementById('analysis-modal-title').innerText = eventName;
    document.getElementById('analysis-date').innerText = new Date(date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
}

// initializeSubDetailPlugins moved to detail.js

// Functions moved to detail.js (updateTask, loadActivityLog, etc.)