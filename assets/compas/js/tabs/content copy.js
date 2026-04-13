
window.LoadInit = window.LoadInit || {};
window.LoadInit['tabs'] = window.LoadInit['tabs'] || {};
window.LoadInit['tabs']['content'] = function (container) {
    loadContentDetail();
    loadGlobalActivityLog('content');
};

async function loadContentDetail() {
    showLoader({ target: `#tabs-content`, overlay: false });

    const formData = new FormData();
    formData.append('campaign_id', $detailId.value);

    try {
        const response = await fetch(`${BASE_URL}compas/content/detail`, {
            method: 'POST',
            body: formData,
        });

        const data = await response.json();
        let contents = data.contents;
        let campaign = campaignData;

        if (campaign) {
            $('#form-content-campaign-id').val(campaign.campaign_id);
            $('#form-content-campaign-name').val(campaign.campaign_name);
        } else {
            $('#form-content-campaign-id').val('');
            $('#form-content-campaign-name').val('');
        }

        if (contents && contents.length > 0) {
            $(`#content-content-section`).fadeIn(250);
            $(`#content-empty-state`).hide();
            await renderContent(contents);
        } else {
            $('#content-table-body').empty();
            $(`#content-content-section`).hide();
            $(`#content-empty-state`).fadeIn(250);
        }
    } catch (e) {
        console.error(e);
    } finally {
        hideLoader();
    }
}

async function renderContent(contents) {
    const rowsHtml = await renderContentRows(contents);
    $('#content-table-body').html(rowsHtml);
    initHoverableTooltips('#content-table-body [data-bs-toggle="tooltip"]');
}

async function renderContentRows(contents) {
    let rows = '';

    await contents.forEach(content => {
        let statusBadge = '';
        const status = content.status; // ENUM: Draft, In Production, Ready, Published
        
        if (status === 'Published') {
            statusBadge = `<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2">Published</span>`;
        } else if (status === 'Ready') {
             statusBadge = `<span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-2">Ready</span>`;
        } else if (status === 'In Production') {
             statusBadge = `<span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-2">In Production</span>`;
        } else {
            statusBadge = `<span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-2">Draft</span>`;
        }

        const title = content.title || 'Untitled';
        const format = content.format || '-';
        const platform = content.platform_name || (content.platform || '-');

        // Logic for pics if available (using campaign pics or specific logic?)
        // Assuming we rely on a generic pic handler or fallback. 
        // For now, since `t_cmp_content` has no PIC column, I will show 'Unassigned' or maybe check if we join with employees via Log or Campaign Team.
        // Let's use `model_content` left join logic if present, currently it has nothing reliable for per-row PIC in schema.
        
        rows += `
            <tr>
                <td class="px-4 py-3 border-bottom-0">
                    <div class="fw-bold small">${title}</div>
                    <div class="text-muted" style="font-size: 10px;">${format} &bull; ${platform}</div>
                </td>
                <td class="px-4 py-3 border-bottom-0">
                    <span class="text-muted small">${content.publish_date || '-'}</span>
                </td>
                <td class="px-4 py-3 border-bottom-0 text-center">
                    ${statusBadge}
                </td>
                <td class="px-4 py-3 border-bottom-0 text-end">
                     <button class="btn btn-link text-muted p-0 hover-primary me-2" 
                        data-bs-toggle="modal"
                        onclick="loadSubDetail('${content.content_id}', 'content')"
                        title="View Details">
                        <i class="bi bi-file-text"></i>
                    </button>
                    <button class="btn btn-link text-success p-0 hover-primary me-2" 
                        onclick="editContent('${content.content_id}')"
                        title="Edit Content">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                </td>
            </tr>
        `;
    });

    return rows;
}

window.showContentForm = function () {
    const modal = new bootstrap.Modal(document.getElementById('modal-content-form'));
    
    $('#content-form')[0].reset();
    $('#form-content-id').val(''); 
    $('#content-modal-title').text('Add Content Plan');
    
    $('#form-content-campaign-id').val(campaignData.campaign_id);
    $('#form-content-campaign-name').val(campaignData.campaign_name);
    
    // Clear OverType
    ['script', 'storyboard'].forEach(id => {
         const instanceName = `content${capitalize(id)}Editor`;
         if (window[instanceName]) window[instanceName].setValue('');
    });

    modal.show();
    setTimeout(() => initializeContentPlugins(), 200);
    return false;
};

window.hideContentForm = function () {
    const modalEl = document.getElementById('modal-content-form');
    const modal = bootstrap.Modal.getInstance(modalEl);
    if (modal) modal.hide();
};

window.editContent = async function(contentId) {
     showLoader({ target: `#tabs-content`, overlay: true });
     try {
        const formData = new FormData();
        formData.append('content_id', contentId);

        const response = await fetch(`${BASE_URL}compas/content/get_content_detail`, {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        if (result.status === 'success') {
            const data = result.data;
            
            $('#form-content-id').val(data.content_id);
            $('#form-content-campaign-id').val(data.campaign_id);
            $('#form-content-campaign-name').val(campaignData.campaign_name);
            
            $('#form-title').val(data.title);
            $('#form-format').val(data.format);
            $('#form-platform').val(data.platform);
            $('#form-publish-date').val(data.publish_date);
            $('#form-content-pillar').val(data.content_pillar);
            
            $('#form-pain-point').val(data.pain_point);
            $('#form-trigger-emotion').val(data.trigger_emotion);
            $('#form-consumption-behavior').val(data.consumption_behavior);
            $('#form-reference-link').val(data.reference_link);
            $('#form-hook').val(data.hook);
            
             // OverType editors
             if(window.contentScriptEditor) window.contentScriptEditor.setValue(data.script_content || '');
             if(window.contentStoryboardEditor) window.contentStoryboardEditor.setValue(data.storyboard || '');
             
            // Audio Notes, etc.
            $('#form-audio-notes').val(data.audio_notes);
            $('#form-duration-desc').val(data.duration_desc);
            
            $('#form-talent-type').val(data.talent_type);
            $('#form-talent-persona').val(data.talent_persona);
            $('#form-talent-cost').val(formatRibuanContent(data.talent_cost));
            $('#form-deadline-publish').val(data.deadline_publish ? data.deadline_publish.substring(0,10) : '');

            const modal = new bootstrap.Modal(document.getElementById('modal-content-form'));
            $('#content-modal-title').text('Edit Content Plan');
            modal.show();
            
            setTimeout(() => initializeContentPlugins(), 200);

        } else {
            Swal.fire('Error', 'Failed to fetch content details', 'error');
        }
    } catch (error) {
        console.error(error);
        Swal.fire('Error', 'An error occurred', 'error');
    } finally {
        hideLoader();
    }
}

// Helper
function capitalize(s) { return s && s[0].toUpperCase() + s.slice(1); }

window.contentScriptEditor = null;
window.contentStoryboardEditor = null;

function initializeContentPlugins() {
    let contentCurrentStep = 1;
    const contentTotalSteps = 4; // 1:Identity, 2:Strategy, 3:Production, 4:Talent&Deadline
    const overtypeColors = { bgPrimary: '#015EC2', bgSecondary: '#ffffff', text: '#0d3b66', h1: '#f95738', h2: '#ee964b' };

    function showContentStep(step) {
        $('#content-form .wizard-step').hide();
        $(`#content-form .wizard-step[data-step="${step}"]`).fadeIn();

        $('#modal-content-form .btn-prev').prop('disabled', step === 1);
        
        if (step === contentTotalSteps) {
            $('#modal-content-form .btn-next').hide();
            $('#modal-content-form .btn-finish').show();
        } else {
            $('#modal-content-form .btn-next').show();
            $('#modal-content-form .btn-finish').hide();
        }

        const progress = (step / contentTotalSteps) * 100;
        $('.wizard-progress .progress-bar').css('width', `${progress}%`).attr('aria-valuenow', progress);
    }
    
    // Initialize OverType
    if (document.getElementById('overtype-script') && !window.contentScriptEditor) {
        let initVal = $('#form-script-content').val() || '';
        [window.contentScriptEditor] = new OverType('#overtype-script', {
            theme: { name: 'custom-theme', colors: overtypeColors },
            toolbar: true,
            placeholder: 'Write script content...',
            value: initVal,
            onChange: (val) => $('#form-script-content').val(val)
        });
    }
    
    if (document.getElementById('overtype-storyboard') && !window.contentStoryboardEditor) {
        let initVal = $('#form-storyboard').val() || '';
         [window.contentStoryboardEditor] = new OverType('#overtype-storyboard', {
            theme: { name: 'custom-theme', colors: overtypeColors },
            toolbar: true,
            placeholder: 'Describe storyboard...',
            value: initVal,
            onChange: (val) => $('#form-storyboard').val(val)
        });
    }

    // Format Ribuan
    $('#form-talent-cost').off('keyup').on('keyup', function () {
        $(this).val(formatRibuanContent($(this).val().replace(/\./g, '')));
    });

    $('#modal-content-form .btn-prev').off('click').on('click', function () {
        if (contentCurrentStep > 1) {
            contentCurrentStep--;
            showContentStep(contentCurrentStep);
        }
    });

    $('#modal-content-form .btn-next').off('click').on('click', function () {
        if (validateContentStep(contentCurrentStep)) {
            if (contentCurrentStep < contentTotalSteps) {
                contentCurrentStep++;
                showContentStep(contentCurrentStep);
            }
        }
    });

    showContentStep(1);
}

function validateContentStep(step) {
    let isValid = true;
    const stepContainer = $(`#content-form .wizard-step[data-step="${step}"]`);

    stepContainer.find('input[required], select[required], textarea[required]').each(function () {
        if (!$(this).val() || $(this).val().length === 0) {
            isValid = false;
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    if (!isValid) {
        Swal.fire({
            icon: 'warning',
            title: 'Incomplete Step',
            text: 'Please fill in required fields.'
        });
    }
    return isValid;
}

function formatRibuanContent(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

window.submitContentForm = async function () {
    const $form = $('#content-form');
    if (!$form[0].checkValidity()) {
        $form[0].reportValidity();
        return;
    }

    const formData = new FormData($form[0]);
    const contentId = formData.get('content_id');
    const url = contentId ? `${BASE_URL}compas/content/update` : `${BASE_URL}compas/content/add`;

    showLoader({text: 'Saving...'});

    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
        });

        const result = await response.json();

        if (result.status === 'success') {
            await loadContentDetail();
            hideContentForm();
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

window.chatSimulation = window.chatSimulation || function() { /* Generic */ };
window.handleChatKeyPress = window.handleChatKeyPress || function(e) { if(e.key === 'Enter') chatSimulation(); };
