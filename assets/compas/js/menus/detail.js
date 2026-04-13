window.LoadInit = window.LoadInit || {};
window.LoadInit['menus'] = window.LoadInit['menus'] || {};
window.LoadInit['menus']['detail'] = function (container) {
    activeMenu = document.querySelector('.menus-btn.active').dataset.value;
    switchTab(activeMenu);
    loadCampaignData();
};
if (typeof campaignData === 'undefined') { var campaignData; }

async function loadCampaignData() {
    const formData = new FormData();
    formData.append('campaign_id', $detailId.value);
    const response = await fetch(`${BASE_URL}compas/detail/load`, {
        method: 'POST',
        body: formData,
    });
    const data = await response.json();
    campaignData = data.campaign;

    if (campaignData) {
        $(`#campaign-title`).removeClass('placeholder').text(campaignData.campaign_name);
        $(`#campaign-id`).removeClass('placeholder').text(campaignData.campaign_id);
        $(`#campaign-author`).removeClass('placeholder').text(campaignData.created_by_name);

        applyTabRestrictions(campaignData.campaign_status, campaignData.jml_content_approved);
    } else {
        $(`#campaign-title`).removeClass('placeholder').text('Untitled Campaign');
        $(`#campaign-id`).removeClass('placeholder').text('No Campaign ID');
        $(`#campaign-author`).removeClass('placeholder').text('No Author');
    }
}

function applyTabRestrictions(status, jml_content_approved) {
    // Reset all tabs first
    $('.nav-link.tab-btn').removeClass('disabled').find('.bi-lock').remove();
    $('.nav-link.tab-btn').css('pointer-events', 'auto');

    // Define tabs
    const tabs = {
        'activation': $('a[data-tab-value="activation"]'),
        'content': $('a[data-tab-value="content"]'),
        'talent': $('a[data-tab-value="talent"]'),
        'distribution': $('a[data-tab-value="distribution"]'),
        'optimization': $('a[data-tab-value="optimization"]')
    };

    // Helper to lock a tab
    const lockTab = (tab) => {
        tab.addClass('disabled').css('pointer-events', 'none');
        if (tab.find('.bi-lock').length === 0) {
            tab.prepend('<i class="bi bi-lock me-1"></i>');
        }
    };

    console.log(status, jml_content_approved);

    // Status 1: Only Campaign unlocked (others locked)
    if (status == 1) {
        lockTab(tabs.activation);
        lockTab(tabs.content);
        lockTab(tabs.distribution);
        lockTab(tabs.talent);
        lockTab(tabs.optimization);
    }
    // Status 2: Campaign & Activation unlocked (others locked)
    else if (status == 2) {
        lockTab(tabs.content);
        lockTab(tabs.talent);
        lockTab(tabs.distribution);
        lockTab(tabs.optimization);
    } else if (status == 3 && jml_content_approved == 0) {
        lockTab(tabs.talent);
        lockTab(tabs.distribution);
        lockTab(tabs.optimization);
    }
    // Status 3: All unlocked (default, do nothing)

    // Redirect if current tab is locked
    const currentTab = $('.nav-link.tab-btn.active');
    if (currentTab.hasClass('disabled')) {
        // If locked, switch back to Campaign and notify
        switchTab('Campaign');
        Swal.fire({
            icon: 'info',
            title: 'Access Restricted',
            text: 'This section is not available in the current campaign status.',
            timer: 3000,
            showConfirmButton: false
        });
    }
}

// ==========================================
// SHARED TASK FUNCTIONS (Moved from activation.js)
// ==========================================

window.updateTask = async function () {
    // Determine phase from active tab, default to activation if not found
    // activeTab is global in this file
    const phase = $activeTab.value || 'activation';
    const taskId = $('#sub-detail-task-code').text();

    // Check Dropzone queue (Assuming window.subDetailDropzone is shared or re-assigned by tab scripts)
    if (window.subDetailDropzone && window.subDetailDropzone.getQueuedFiles().length > 0) {
        window.subDetailDropzone.processQueue();
    } else {
        // Manual Fetch
        showLoader({ text: 'Updating...' });
        try {
            const formData = new FormData();
            formData.append("phase", phase);
            formData.append("task_id", taskId);
            formData.append("status", $('#sub-detail-status-select').val());
            formData.append("progress", $('#sub-detail-progress').val());
            formData.append("note", $('#sub-detail-note').val());
            formData.append("target", $('#sub-detail-target').val());

            const response = await fetch(BASE_URL + "compas/detail/update_task_detail", {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            handleUpdateSuccess(result, phase);

        } catch (e) {
            console.error(e);
            Swal.fire('Error', 'Failed to update task', 'error');
        } finally {
            hideLoader();
        }
    }
};

window.handleUpdateSuccess = function (response, phase) {
    if (typeof response === 'string') response = JSON.parse(response);

    if (response.status === 'success') {
        Swal.fire({
            icon: 'success',
            title: 'Updated!',
            text: 'Task updated successfully',
            timer: 1500,
            showConfirmButton: false
        });

        // Refresh Log
        const taskId = $('#sub-detail-task-code').text();
        loadTaskActivityLog(taskId, phase);

        // Clear Note
        if (window.activationNoteEditor) { // TODO: generalized editor name?
            // For now, check specific editors or assuming shared ID usage
            // If we use specific editor instances per tab, we need to know valid one.
            // Or simpler: check if element exists and gets instance
            window.activationNoteEditor.setValue('');
        }
        // Generic clear
        $('#sub-detail-note').val('');
        $('#overtype-sub-detail-note').html(''); // Clear overtype content

        // Clear Dropzone
        if (window.subDetailDropzone) {
            window.subDetailDropzone.removeAllFiles();
        }

        // Refresh Tab Data
        // Call specific refresh function if exists, e.g. loadActivationDetail()
        const refreshFunctionName = 'load' + phase.charAt(0).toUpperCase() + phase.slice(1) + 'Detail';
        if (typeof window[refreshFunctionName] === 'function') {
            window[refreshFunctionName]();
        } else {
            // Fallback: reload tab content
            // loadTab('tabs', phase); // Might be too heavy, resets view
        }

        // Reload sub-detail to show new files
        // Assuming load{Phase}SubDetail exists
        loadSubDetail(taskId, phase);

        // Refresh Global Activity Log
        loadGlobalActivityLog(phase);
    } else {
        Swal.fire('Error', response.message || 'Update failed', 'error');
    }
};

window.loadTaskActivityLog = async function (taskId, phase) {
    phase = phase || $activeTab.value || 'activation';

    $('#sub-detail-activity-log').html('<div class="text-center py-2"><div class="spinner-border spinner-border-sm text-secondary" role="status"></div></div>');

    try {
        const formData = new FormData();
        formData.append('task_id', taskId);
        formData.append('phase', phase);

        const response = await fetch(BASE_URL + "compas/detail/get_activity_log", {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.status === 'success' && result.data.length > 0) {
            let html = renderLogItems(result.data);
            $('#sub-detail-activity-log').html(html);
        } else {
            $('#sub-detail-activity-log').html('<p class="text-muted small ps-3">No recent activity.</p>');
        }
    } catch (e) {
        console.error(e);
        $('#sub-detail-activity-log').html('<p class="text-danger small ps-3">Failed to load log.</p>');
    }
};

window.loadGlobalActivityLog = async function (phase) {

    const container = $('#global-activity-log-container');
    if (container.length === 0) return;
    console.log(container);

    try {
        const formData = new FormData();
        if (phase) formData.append('phase', phase);

        const response = await fetch(BASE_URL + "compas/detail/get_all_activity_logs", {
            method: 'POST',
            body: formData
        });
        const result = await response.json();

        if (result.status === 'success') {
            window.allActivityLogs = result.data; // Store for modal

            // Limit to 5 for main view
            const recentLogs = result.data.slice(0, 5);

            if (recentLogs.length > 0) {
                let html = `<!-- Vertical line --><div class="position-absolute top-0 start-0 h-100 bg-light" style="width: 2px; margin-left: 9px;"></div>`;
                html += renderLogItems(recentLogs);
                container.html(html);
            } else {
                container.html(`<div class="position-absolute top-0 start-0 h-100 bg-light" style="width: 2px; margin-left: 9px;"></div><p class="text-center text-muted small py-3 ps-3">No recent activities found.</p>`);
            }
        }
    } catch (e) {
        console.error("Error loading global log:", e);
        container.html('<p class="text-center text-danger small py-3">Failed to load activities.</p>');
    }
};

window.renderLogItems = function (logs) {
    let html = '';
    logs.forEach(log => {
        const timeAgo = moment(log.created_at).fromNow();
        const userName = log.user_name || 'System';
        // Note: logs might not have task title if not joined properly in generic query. 
        // We fallback to "a task" if missing.
        const taskTitle = log.activation_title ? `<span class="fw-bold text-dark">"${log.activation_title}"</span>` : 'a task';

        let iconClass = 'bi-circle';
        let colorClass = 'text-secondary bg-secondary';

        if (log.action_type === 'STATUS_CHANGE') {
            colorClass = 'bg-primary';
            iconClass = 'bi-arrow-left-right';
        } else if (log.action_type === 'FILE_UPLOADED') {
            colorClass = 'bg-warning';
            iconClass = 'bi-paperclip';
        } else if (log.action_type === 'NOTE_ADDED') {
            colorClass = 'bg-success';
            iconClass = 'bi-chat-left-text';
        } else if (log.action_type === 'CREATED') {
            colorClass = 'bg-info';
            iconClass = 'bi-plus-lg';
        }

        // Details Parsing
        let details = '';

        if (log.details) {
            // Try parse
            try {
                const det = JSON.parse(log.details);
                console.log(det);
                const statusMap = {
                    '1': 'WAITING',
                    '2': 'ON REVIEW',
                    '3': 'APPROVED',
                    '4': 'REJECTED',
                    '5': 'REVISION'
                };
                const fromStatus = statusMap[det.status_from] || det.status_from;
                const toStatus = statusMap[det.status_to] || det.status_to;

                if (det.status_from && det.status_to) {
                    details = `Updated status from <b>${fromStatus}</b> to <b>${toStatus}</b>`;
                } else if (det.file_count) {
                    details = `Uploaded ${det.file_count} files`;
                    if (det.files && Array.isArray(det.files) && det.files.length > 0) {
                        details += `<div class="mt-1 d-flex flex-column gap-1">`;
                        det.files.forEach((f) => {
                            details += `<a href="${BASE_URL}uploads/activation_files/${f.file_name}" target="_blank" class="text-primary text-decoration-underline small"><i class="bi bi-file-earmark me-1"></i>${f.client_name || f.file_name}</a>`;
                        });
                        details += `</div>`;
                    }
                }
            } catch (e) { }
        }

        const desc = details || log.description || 'Activity recorded';

        html += `
            <div class="position-relative mb-4 ps-3">
                <span
                    class="position-absolute top-0 start-0 translate-middle ${colorClass} border border-4 border-white rounded-circle d-flex align-items-center justify-content-center text-white"
                    style="width: 20px; height: 20px; left: 0px !important; margin-top: 4px; font-size: 10px;">
                        <i class="bi ${iconClass}"></i>
                </span>
                <div>
                    <p class="mb-1 small text-dark" style="font-size: 0.75rem; line-height: 1.4;">
                        <span class="fw-bold">${userName}</span>: ${desc}
                    </p>
                    <small class="text-muted" style="font-size: 0.65rem;">${timeAgo}</small>
                </div>
            </div>
            `;
    });
    return html;
};

window.openViewFullLog = function () {
    // Populate modal container
    console.log('test');

    const container = $('#modal-full-log .modal-body .position-relative.ps-3');
    if (window.allActivityLogs && window.allActivityLogs.length > 0) {
        let html = `<!-- Vertical line --><div class="position-absolute top-0 start-0 h-100 bg-light" style="width: 2px; margin-left: 9px;"></div>`;
        html += renderLogItems(window.allActivityLogs);
        container.html(html);
    } else {
        container.html(`<p class="text-center text-muted small py-3">No activities found.</p>`);
    }

    var myModal = new bootstrap.Modal(document.getElementById('modal-full-log'));
    myModal.show();
};

window.renderAttachments = function (files, phase) {
    phase = phase || $activeTab.value || 'activation';
    let html = '';
    if (files && files.length > 0) {
        files.forEach(file => {
            // Determine icon class based on extension
            const ext = file.file_name.split('.').pop().toLowerCase();
            let iconClass = 'bi-file-earmark text-secondary';
            if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) iconClass = 'bi-file-earmark-image text-primary';
            else if (['pdf'].includes(ext)) iconClass = 'bi-file-earmark-pdf text-danger';
            else if (['doc', 'docx'].includes(ext)) iconClass = 'bi-file-earmark-word text-primary';
            else if (['xls', 'xlsx'].includes(ext)) iconClass = 'bi-file-earmark-excel text-success';

            html += `
                <div class="col-sm-6">
                    <div class="d-flex justify-content-between align-items-center p-2 bg-white rounded border shadow-sm">
                        <div class="d-flex align-items-center gap-2 overflow-hidden">
                            <span class="bi ${iconClass} fs-5"></span>
                            <a href="${BASE_URL}uploads/${phase}_files/${file.file_name}" target="_blank" class="text-truncate fw-medium text-dark text-decoration-none" style="font-size: 0.7rem; max-width: 150px;">${file.client_name || file.file_name}</a>
                        </div>
                        <!-- Optional: Delete button -->
                        <!-- <button class="btn btn-link text-secondary p-0" style="text-decoration: none;"><span class="bi bi-trash fs-6"></span></button> -->
                    </div>
                </div>
            `;
        });
    }
    $('#sub-detail-attachments-container').html(html);
};

// ==========================================
// GENERIC SUB-DETAIL LOADER (Moved from activation.js)
// ==========================================

window.loadSubDetail = async function (taskId, phase) {
    if (!taskId) return;
    phase = phase || $activeTab.value || 'activation';

    // Show spinner or loading state
    $('#sub-detail-title').text('Loading...');
    $('#sub-detail-type').text(phase.charAt(0).toUpperCase() + phase.slice(1));
    $('#sub-detail-task-code').text(taskId);
    $('#sub-detail-description').text('Loading...');
    $('#sub-detail-due-date').text('...');
    $('#sub-detail-assigned-container').html('<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');
    $('#sub-detail-activity-log').html('<div class="text-center py-3"><div class="spinner-border spinner-border-sm text-secondary" role="status"></div></div>');

    try {
        const formData = new FormData();
        formData.append('task_id', taskId);
        formData.append('phase', phase);

        const response = await fetch(`${BASE_URL}compas/detail/get_task_detail`, {
            method: 'POST',
            body: formData
        });

        if (!response.ok) throw new Error('Network response was not ok');

        const result = await response.json();

        if (result.status === 'success') {
            const task = result.data;

            // Determine Title field (might differ by table)
            const title = task.title || task.content_title || 'Untitled Task';

            $('#sub-detail-title').text(title);
            // Target is usually campaign level, not task level, unless passed or fetched separately.
            // campaignData is global.
            if (typeof campaignData !== 'undefined') {
                const targetKey = phase + '_target';
                $('#sub-detail-target').val(campaignData[targetKey] || 0);
            }

            $('#sub-detail-type').text(phase.charAt(0).toUpperCase() + phase.slice(1));
            const idKey = (phase === 'activation') ? 'activation_id' : (phase === 'content' ? 'content_id' : 'id');
            // Or just use taskId passed
            $('#sub-detail-task-code').text(task[idKey] || taskId);

            $('#sub-detail-description').html((task.description || 'No description available.').replace(/\n/g, '<br>'));

            // Date formatting
            const dateStr = task.due_date || task.period_end || task.deadline;
            if (dateStr) {
                $('#sub-detail-due-date').text(moment(dateStr).format('MMM D, YYYY'));
            } else {
                $('#sub-detail-due-date').text('-');
            }

            // Status
            const statusSelect = document.getElementById('sub-detail-status-select');
            if (statusSelect) {
                statusSelect.value = task.status || '1'; // Default Waiting
            }

            // Assigned To handles comma separated
            let assignedHtml = '';
            // task.pic_ids, task.pic_names, task.pic_pictures come from get_task_detail_with_pics join
            if (task.pic_ids) {
                const ids = task.pic_ids.split(',');
                const names = task.pic_names ? task.pic_names.split(',') : [];
                const pics = task.pic_pictures ? task.pic_pictures.split(',') : [];

                if (ids.length === 1) {
                    // Single User - Detailed View
                    const name = names[0] || 'Unknown';
                    const pic = pics[0] || '';
                    const avatarUrl = pic ? `https://trusmiverse.com/hr/uploads/profile/${pic}` : 'https://trusmiverse.com/hr/uploads/profile/anonim.jpg';

                    assignedHtml = `
                        <div class="d-flex align-items-center gap-2">
                             <img src="${avatarUrl}" alt="${name}" class="rounded-circle border shadow-sm object-fit-cover" width="36" height="36">
                             <div class="d-flex flex-column" style="line-height: 1.2;">
                                 <span class="fw-bold small text-dark">${name}</span>
                                 <span class="text-muted" style="font-size: 0.7rem;">Assigned PIC</span>
                             </div>
                        </div>
                    `;
                } else {
                    // Multiple Users - Stacked Avatar Group
                    assignedHtml = '<div class="d-flex ps-2">'; // Add padding start

                    ids.forEach((id, index) => {
                        const name = names[index] || 'Unknown';
                        const pic = pics[index] || '';
                        const avatarUrl = pic ? `https://trusmiverse.com/hr/uploads/profile/${pic}` : 'https://trusmiverse.com/hr/uploads/profile/anonim.jpg';

                        const marginClass = index > 0 ? 'ms-n2' : '';
                        const zIndex = 10 - index;

                        assignedHtml += `
                            <div class="position-relative ${marginClass}" style="z-index: ${zIndex};" 
                                 data-bs-toggle="tooltip" data-bs-placement="top" title="${name}">
                                <img src="${avatarUrl}" alt="${name}" 
                                     class="rounded-circle border border-2 border-white shadow-sm object-fit-cover user-select-none" 
                                     width="36" height="36"
                                     style="transition: transform 0.2s;"
                                     onmouseover="this.style.zIndex='20'; this.style.transform='scale(1.1) translateY(-2px)'" 
                                     onmouseout="this.style.zIndex=''; this.style.transform=''"
                                     >
                            </div>
                        `;
                    });
                    assignedHtml += '</div>';
                }
            } else {
                assignedHtml = '<span class="text-muted small fst-italic">Unassigned</span>';
            }
            $('#sub-detail-assigned-container').html(assignedHtml);

            // Re-initialize tooltips
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('#sub-detail-assigned-container [data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }

            // Init Sub-Detail Plugins
            initializeSubDetailPlugins(taskId, task.status, task.progress || 0, phase);

            // Load Activity Log (Generic)
            loadTaskActivityLog(taskId, phase);

        } else {
            console.error('Failed to load task detail:', result.message);
            $('#sub-detail-description').text('Error loading details.');
        }

    } catch (error) {
        console.error('Error fetching task detail:', error);
        $('#sub-detail-description').text('Error loading details.');
    }
};

// Global Variables for Sub Detail (Shared)
window.activationNoteEditor = null; // Can rename to taskNoteEditor but keep for compatibility
window.subDetailDropzone = null;

window.initializeSubDetailPlugins = function (taskId, currentStatus, currentProgress, phase) {
    phase = phase || $activeTab.value || 'activation';
    // 1. Chosen for Status
    if ($('#sub-detail-status-select').next('.chosen-container').length > 0) {
        $('#sub-detail-status-select').chosen('destroy');
    }

    $('#sub-detail-status-select').val(currentStatus || '1').chosen({ width: "100%", disable_search_threshold: 10 });

    // 2. OverType for Note
    $('#sub-detail-note').val('');

    if (document.getElementById('overtype-sub-detail-note')) {
        if (window.activationNoteEditor) {
            window.activationNoteEditor.setValue('');
        } else {
            document.getElementById('overtype-sub-detail-note').innerHTML = '';

            [window.activationNoteEditor] = new OverType('#overtype-sub-detail-note', {
                theme: {
                    name: 'custom-theme',
                    colors: { bgPrimary: '#015EC2', bgSecondary: '#ffffff', text: '#0d3b66', h1: '#f95738', h2: '#ee964b', h3: '#3d8a51', strong: '#ee964b', em: '#f95738', link: '#0d3b66', code: '#0d3b66', codeBg: 'rgba(244, 211, 94, 0.2)', blockquote: '#5a7a9b', hr: '#5a7a9b', syntaxMarker: 'rgba(13, 59, 102, 0.52)', cursor: '#f95738', selection: 'rgba(1, 94, 194, 0.8)' }
                },
                toolbar: true,
                placeholder: 'Type your progress update here...',
                value: '',
                onChange: (value, instance) => {
                    $('#sub-detail-note').val(value);
                }
            });
        }
    }

    // 3. Dropzone
    if (typeof Dropzone !== 'undefined') {
        Dropzone.autoDiscover = false;

        const dzElement = document.querySelector("#sub-detail-dropzone");
        if (dzElement && dzElement.dropzone) {
            dzElement.dropzone.destroy();
        }

        if (window.subDetailDropzone) {
            try { window.subDetailDropzone.destroy(); } catch (e) { }
        }

        window.subDetailDropzone = new Dropzone("#sub-detail-dropzone", {
            url: BASE_URL + "compas/detail/update_task_detail", // Generic Endpoint
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 5,
            maxFiles: 5,
            addRemoveLinks: true,
            dictDefaultMessage: "",
            previewsContainer: "#sub-detail-dropzone",
            clickable: "#sub-detail-dropzone",
            init: function () {
                this.on("sendingmultiple", function (file, xhr, formData) {
                    formData.append("task_id", taskId); // Generic ID
                    formData.append("phase", phase); // Pass phase
                    formData.append("status", $('#sub-detail-status-select').val());
                    formData.append("progress", $('#sub-detail-progress').val());
                    formData.append("note", $('#sub-detail-note').val());
                });

                this.on("successmultiple", function (files, response) {
                    handleUpdateSuccess(response, phase);
                });

                this.on("errormultiple", function (files, response) {
                    Swal.fire('Error', 'Failed to upload files', 'error');
                });

                this.on("addedfile", function (file) {
                    $('.dz-message').hide();
                });

                this.on("removedfile", function (file) {
                    if (this.files.length === 0) {
                        $('.dz-message').show();
                    }
                });
            }
        });
    }

    // 4. Progress Slider
    $('#sub-detail-progress').val(currentProgress || 0);
    $('#sub-detail-progress-val').text((currentProgress || 0) + '%');

    if (currentStatus === '3') {
        $('#sub-detail-progress').val(100);
        $('#sub-detail-progress-val').text('100%');
    }

    $('#sub-detail-progress').off('items').on('input', function () {
        $('#sub-detail-progress-val').text($(this).val() + '%');
    });

    // LOCK INPUTS IF APPROVED (3) OR REJECTED (4)
    const isLocked = (currentStatus === '3' || currentStatus === '4');

    $('#sub-detail-status-select').prop('disabled', isLocked).trigger('chosen:updated');

    if (window.activationNoteEditor) {
        if (isLocked) {
            $('#overtype-sub-detail-note').css({ 'pointer-events': 'none', 'opacity': '0.7', 'background-color': '#e9ecef' });
            $('#sub-detail-note').prop('disabled', true);
        } else {
            $('#overtype-sub-detail-note').css({ 'pointer-events': 'auto', 'opacity': '1', 'background-color': '#fff' });
            $('#sub-detail-note').prop('disabled', false);
        }
    }

    if (isLocked) {
        $('#sub-detail-dropzone').css({ 'pointer-events': 'none', 'opacity': '0.6', 'background-color': '#e9ecef' });
    } else {
        $('#sub-detail-dropzone').css({ 'pointer-events': 'auto', 'opacity': '1', 'background-color': '#fff' });
    }

    $('#sub-detail-progress').prop('disabled', isLocked);

    const updateBtn = document.querySelector('#btn-update-task');
    if (updateBtn) {
        if (isLocked) {
            updateBtn.disabled = true;
            updateBtn.innerHTML = (currentStatus === '3') ? '<i class="bi bi-check-circle-fill"></i> Approved' : '<i class="bi bi-x-circle-fill"></i> Rejected';
            updateBtn.classList.remove('btn-primary');
            updateBtn.classList.add(currentStatus === '3' ? 'btn-success' : 'btn-danger');

        } else {
            updateBtn.disabled = false;
            updateBtn.innerHTML = 'Update Task';
            updateBtn.classList.add('btn-primary');
            updateBtn.classList.remove('btn-success', 'btn-danger');
        }
    }
};
