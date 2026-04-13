
window.LoadInit = window.LoadInit || {};
window.LoadInit['tabs'] = window.LoadInit['tabs'] || {};
window.LoadInit['tabs']['activation'] = function (container) {
    loadActivationDetail();
    loadActivationTeam();
    loadTeamPerformance();
    loadActivationLogs();

    // Init Comments
    initComments();

    // Surprise Me Logic for Activation
    $(document).off('click', '#btnSurpriseMeActivation').on('click', '#btnSurpriseMeActivation', function () {
        const $btn = $(this);
        const campaignId = $('#form-campaign-id').val() || $('#detail_id').val() || '';
        const userPrompt = '';   // kosong = biarkan AI bebas berkreasi

        // ── Loading state ──────────────────────────────────────────────────────
        const originalHtml = $btn.html();
        $btn.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Generating...'
        );

        // 1. Selects (Chosen JS)
        const getRandomItem = (arr) => arr[Math.floor(Math.random() * arr.length)];
        const getRandomInt = (min, max) => Math.floor(Math.random() * (max - min + 1)) + min;
        const pickRandomOption = (selector, multiple = false) => {
            const options = $(selector + ' option').map(function () { return $(this).val(); }).get().filter(v => v !== "");
            if (options.length > 0) {
                if (multiple) {
                    const count = getRandomInt(1, Math.min(3, options.length));
                    const selected = [];
                    for (let i = 0; i < count; i++) {
                        const item = getRandomItem(options);
                        if (!selected.includes(item)) selected.push(item);
                    }
                    $(selector).val(selected).trigger('chosen:updated');
                } else {
                    $(selector).val(getRandomItem(options)).trigger('chosen:updated');
                }
            }
        };

        const formData = new FormData();
        formData.append('campaign_id', campaignId);
        formData.append('user_prompt', userPrompt);

        fetch(`${BASE_URL}compas/activation/generate_ai_activation`, {
            method: 'POST',
            body: formData,
        })
            .then(res => res.json())
            .then(result => {
                if (!result.status || !result.data) {
                    Swal.fire('Oops!', 'AI gagal menghasilkan data. Silakan coba lagi.', 'warning');
                    return;
                }

                const d = result.data;

                // 1. Title
                if (d.title) {
                    $('#form-activation-title').val(d.title);
                }

                // 2. Period Dates
                if (d.period_start) $('#form-activation-period-start').val(d.period_start);
                if (d.period_end) $('#form-activation-period-end').val(d.period_end);

                // 3. Target Audience (plain input + OverType editor)
                if (d.target_audience) {
                    $('#form-target-audience').val(d.target_audience);
                    if (window.activationTargetAudienceEditor) {
                        window.activationTargetAudienceEditor.setValue(d.target_audience);
                    }
                }

                // 4. Description / Aktivasi yang Berjalan (plain input + OverType editor)
                if (d.description) {
                    $('#form-current-activation').val(d.description);
                    if (window.activationDescriptionEditor) {
                        window.activationDescriptionEditor.setValue(d.description);
                    }
                }

                // 5. Budget — convert to formatted Rupiah
                if (d.budget) {
                    const rawBudget = parseInt(d.budget) || 0;
                    $('#form-budget').val(typeof formatRibuanActivation === 'function'
                        ? formatRibuanActivation(rawBudget)
                        : rawBudget.toLocaleString('id-ID'));
                }

                // 6. PIC — set Chosen multi-select by array of user_ids
                // if (Array.isArray(d.pic_ids) && d.pic_ids.length > 0) {
                //     const picVals = d.pic_ids.map(v => String(v));
                //     $('#form-pic').val(picVals).trigger('chosen:updated');
                // }

                // $('#form-pic').val($('#form-pic option').val()).trigger('chosen:updated');

                if ($("#form-pic option:selected").length == 0) {
                    pickRandomOption('#form-pic', true);
                }
                // 7. Content Produced — set Chosen multi-select by array of cg_ids
                // if (Array.isArray(d.content_produced_ids) && d.content_produced_ids.length > 0) {
                //     const cgVals = d.content_produced_ids.map(v => String(v));
                //     $('#content-result').val(cgVals).trigger('chosen:updated');
                // }

                // 8. Platform — set Chosen multi-select by array of platform_ids
                // if (Array.isArray(d.platform_ids) && d.platform_ids.length > 0) {
                //     const platformVals = d.platform_ids.map(v => String(v));
                //     $('#platform-tujuan').val(platformVals).trigger('chosen:updated');
                // }

                // // 9. SLA Description
                // if (d.sla_desc) {
                //     $('#form-sla-desc').val(d.sla_desc);
                //     if (window.activationSlaDescEditor) {
                //         window.activationSlaDescEditor.setValue(d.sla_desc);
                //     }
                // }

                // // 10. AI Scoring Rules
                // if (d.ai_scoring_rules) {
                //     $('#form-ai-scoring-rules').val(d.ai_scoring_rules);
                //     if (window.activationAiScoringEditor) {
                //         window.activationAiScoringEditor.setValue(d.ai_scoring_rules);
                //     }
                // }

                // // 11. Trigger Consequence
                // if (d.trigger_consequence) {
                //     $('#form-trigger-consequence').val(d.trigger_consequence);
                //     if (window.activationTriggerEditor) {
                //         window.activationTriggerEditor.setValue(d.trigger_consequence);
                //     }
                // }

                // // 12. Consequence Action
                // if (d.consequence_action) {
                //     $('#form-consequence-action').val(d.consequence_action);
                //     if (window.activationConsequenceEditor) {
                //         window.activationConsequenceEditor.setValue(d.consequence_action);
                //     }
                // }

                // ── Success toast ──────────────────────────────────────────────────
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Form diisi oleh AI ✨',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });
            })
            .catch(err => {
                console.error('generate_ai_activation error:', err);
                Swal.fire('Error', 'Terjadi kesalahan saat menghubungi AI. Silakan coba lagi.', 'error');
            })
            .finally(() => {
                // ── Restore button ─────────────────────────────────────────────────
                $btn.prop('disabled', false).html(originalHtml);
            });
    });

    function loadActivationLogs() {
        let campaignId = $('#detail_id').val();
        $.ajax({
            url: BASE_URL + 'compas/activation/get_all_activity_logs', // Using the controller method that likely fetches relevant logs
            type: 'POST',
            data: { campaign_id: campaignId, limit: 10 },
            dataType: 'json',
            success: function (response) {
                const container = $('#global-activity-log-container');
                // Remove existing logs but keep the vertical line if implemented in HTML
                // But HTML has "Logs will be loaded here", spinner etc.
                // Best to replace container content but preserve the vertical line if it's inside?
                // The PHP has: <div ... id="global-activity-log-container"> <div class="vertical-line"></div> ... </div>
                // So we should append.

                // Let's clear and rebuild for simplicity or just replace the content div.
                // The HTML provided earlier:
                /* 
                <div class="position-relative ps-3 my-2" id="global-activity-log-container">
                    <div class="position-absolute top-0 start-0 h-100 bg-light" style="width: 2px; margin-left: 9px;"></div>
                    <div class="text-center py-3">...spinner...</div>
                </div>
                */

                if (response.status && response.data && response.data.length > 0) {
                    let logsHtml = '<div class="position-absolute top-0 start-0 h-100 bg-light" style="width: 2px; margin-left: 9px;"></div>';

                    response.data.forEach(log => {
                        let icon = 'bi-circle-fill';
                        let colorClass = 'text-primary';
                        let bgClass = 'bg-primary';

                        if (log.action_type === 'STATUS_CHANGE') {
                            icon = 'bi-arrow-left-right';
                            colorClass = 'text-info';
                            bgClass = 'bg-info';
                        } else if (log.action_type === 'CREATED') {
                            icon = 'bi-plus-lg';
                            colorClass = 'text-success';
                            bgClass = 'bg-success';
                        } else if (log.action_type === 'UPDATED') {
                            icon = 'bi-pencil';
                            colorClass = 'text-warning';
                            bgClass = 'bg-warning';
                        }

                        // Time formatting (assume format 'Y-m-d H:i:s')
                        // Calculate time ago or just display
                        // Simplistic time display or rely on backend 'time_ago' if present
                        let timeDisplay = log.created_at;

                        logsHtml += `
                        <div class="d-flex gap-3 mb-4 position-relative">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle ${bgClass} bg-opacity-10 d-flex align-items-center justify-content-center" 
                                    style="width: 20px; height: 20px; border: 2px solid white; z-index: 2; position: relative;">
                                    <div class="rounded-circle ${bgClass}" style="width: 8px; height: 8px;"></div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-0 small text-dark">
                                    <span class="fw-bold">${log.user_name || 'User'}</span> 
                                    ${log.description}
                                </p>
                                <span class="text-muted xx-small">${timeDisplay}</span>
                            </div>
                        </div>`;
                    });

                    container.html(logsHtml);
                } else {
                    container.html('<div class="position-absolute top-0 start-0 h-100 bg-light" style="width: 2px; margin-left: 9px;"></div><div class="text-center py-3"><p class="text-muted small mb-0">No recent activity</p></div>');
                }
            },
            error: function () {
                $('#global-activity-log-container').html('<div class="text-center py-3"><p class="text-danger small mb-0">Failed to load logs</p></div>');
            }
        });
    }


    // Event Listeners for Team
    $('#inviteActivationTeamModal').on('show.bs.modal', function () {
        loadEmployeesForInviteActivation();
    });

    $('#btnSaveActivationTeam').on('click', function () {
        saveActivationTeam();
    });

    function loadTeamPerformance() {
        let campaignId = $('#detail_id').val();
        $.ajax({
            url: BASE_URL + 'compas/activation/get_team_performance_stats',
            type: 'GET',
            data: { campaign_id: campaignId },
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    $('#team_efficiency_activation').text(response.data.efficiency + '%');
                    $('#team_done_activation').text(response.data.total_approved + '/' + response.data.target);
                }
            }
        });

        // Load Rising Stars Avatars
        const formData = new FormData();
        formData.append('campaign_id', campaignId);
        fetch(`${BASE_URL}compas/activation/get_activation_team`, {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(result => {
                if (result.status && result.data) {
                    const team = result.data;
                    const container = $('.avatar-group-performance-activation');
                    container.empty();

                    if (team.profile_picture_team && team.profile_picture_team.length > 0) {
                        team.profile_picture_team.slice(0, 3).forEach((pic, index) => {
                            const picUrl = pic ? pic : `${BASE_URL}assets/compas/main_theme/img/user-1.jpg`;
                            container.append(`
                            <div class="avatar avatar-30 rounded-circle border border-white"
                                style="width:30px; height:30px; ${index > 0 ? 'margin-left: -10px;' : ''} z-index: ${10 - index};">
                                <img src="${picUrl}" class="rounded-circle w-100 h-100" alt="">
                            </div>
                        `);
                        });
                    }
                }
            });
    }

    function initComments() {
        if ($('#comments-container-activation').length > 0) {
            $('#comments-container-activation').comments({
                profile_picture_url: typeof CURRENT_USER_PROFILE_URL !== 'undefined' ? CURRENT_USER_PROFILE_URL : '',
                current_user_id: typeof CURRENT_USER_ID !== 'undefined' ? CURRENT_USER_ID : 1,
                user_has_upvoted: false,
                enableAttachments: true,
                enableHashtags: true,
                enablePinging: true,

                getComments: function (success, error) {
                    $.ajax({
                        type: 'GET',
                        url: BASE_URL + 'compas/activation/get_comments',
                        data: { campaign_id: $('#detail_id').val() },
                        dataType: 'json',
                        success: function (commentsArray) {
                            success(commentsArray);
                        },
                        error: error
                    });
                },

                postComment: function (commentJSON, success, error) {
                    var formData = new FormData();

                    // Append scalar fields
                    formData.append('campaign_id', $('#detail_id').val());
                    formData.append('content', commentJSON.content || '');
                    formData.append('parent', commentJSON.parent || '');
                    formData.append('pings', JSON.stringify(commentJSON.pings || []));

                    // Append new file attachments (those without an id yet)
                    var newAttachments = (commentJSON.attachments || []).filter(function (a) {
                        return !a.id && a.file instanceof File;
                    });
                    $.each(newAttachments, function (i, att) {
                        formData.append('attachments_to_be_created[]', att.file, att.file.name);
                    });

                    $.ajax({
                        type: 'POST',
                        url: BASE_URL + 'compas/activation/post_comment',
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function (comment) {
                            success(comment);
                        },
                        error: error
                    });
                },

                putComment: function (commentJSON, success, error) {
                    var formData = new FormData();

                    formData.append('id', commentJSON.id);
                    formData.append('content', commentJSON.content || '');
                    formData.append('pings', JSON.stringify(commentJSON.pings || []));

                    // Existing attachment IDs to keep
                    var existingIds = (commentJSON.attachments || [])
                        .filter(function (a) { return a.id; })
                        .map(function (a) { return a.id; });
                    if (existingIds.length) {
                        formData.append('existing_attachment_ids', existingIds.join(','));
                    }

                    // New file attachments
                    var newAttachments = (commentJSON.attachments || []).filter(function (a) {
                        return !a.id && a.file instanceof File;
                    });
                    $.each(newAttachments, function (i, att) {
                        formData.append('attachments_to_be_created[]', att.file, att.file.name);
                    });

                    $.ajax({
                        type: 'POST',
                        url: BASE_URL + 'compas/activation/put_comment',
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function (comment) {
                            success(comment);
                        },
                        error: error
                    });
                },

                upvoteComment: function (commentJSON, success, error) {
                    $.ajax({
                        type: 'POST',
                        url: BASE_URL + 'compas/activation/upvote_comment',
                        data: JSON.stringify(commentJSON),
                        contentType: 'application/json',
                        dataType: 'json',
                        success: function () {
                            success(commentJSON);
                        },
                        error: error
                    });
                },

                deleteComment: function (commentJSON, success, error) {
                    Swal.fire({
                        title: 'Delete Comment?',
                        text: "This will also delete any associated attachments and replies. You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST',
                                url: BASE_URL + 'compas/activation/delete_comment',
                                data: JSON.stringify({ id: commentJSON.id }),
                                contentType: 'application/json',
                                dataType: 'json',
                                success: function (response) {
                                    success(response);
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: 'Comment and attachments have been deleted.',
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                },
                                error: error
                            });
                        }
                    });
                },

                getUsers: function (success, error) {
                    $.ajax({
                        type: 'GET',
                        url: BASE_URL + 'compas/activation/get_users_for_comments',
                        dataType: 'json',
                        success: function (userArray) {
                            success(userArray);
                        },
                        error: error
                    });
                }
            });
        }
    }


    async function loadActivationTeam() {
        const campaignId = $detailId.value;
        $.ajax({
            url: BASE_URL + 'compas/activation/get_activation_team',
            type: 'GET',
            data: { campaign_id: campaignId },
            dataType: 'json',
            success: function (response) {
                // console.log(response);

                if (response.status) {
                    const team = response.data;
                    let html = '';
                    if (team.profile_picture_team) {
                        const pics = team.profile_picture_team
                        const names = team.team_name.split(',');
                        pics.forEach((pic, index) => {
                            html += `
                        <figure class="avatar avatar-40 rounded-circle coverimg overlay-ms-15" data-bs-toggle="tooltip" data-bs-placement="top" title="${names[index]}" style="background-image: url('${BASE_URL}uploads/users/${pic}');">
                            <img src="${pic}" alt="">
                        </figure>
                        `;
                        });

                        html += `<div class="ms-2 col">
                            <p class="text-secondary small mb-0">${team.more_users} more</p>
                            <p class="small">Working</p>
                        </div>`;
                        // If more than 3, show +X counter (optional, for now show all or limit by CSS)
                        // Using existing structure
                        $('#avatar-activation-team').empty().append(html);

                        // Re-init tooltips
                        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                            return new bootstrap.Tooltip(tooltipTriggerEl);
                        });
                    }
                }
            }
        });
    }

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

            if (campaign && campaign.campaign_status == 4) {
                $('.action-restricted').addClass('d-none');
            } else {
                $('.action-restricted').removeClass('d-none');
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


    function renderActivation(activations) {
        if ($.fn.DataTable.isDataTable('#dt_activation')) {
            $('#dt_activation').DataTable().destroy();
        }

        $('#dt_activation').DataTable({
            data: activations,
            columns: [
                {
                    data: 'title',
                    render: function (data, type, row) {
                        const desc = row.description || 'No description';
                        return `
                        <div class="fw-bold small">${data || 'Untitled Task'}</div>
                        <div class="text-muted text-truncate" style="font-size: 10px; max-width: 150px;">${desc}</div>
                    `;
                    }
                },
                {
                    data: 'pic_ids',
                    render: function (data, type, row) {
                        let picIds = row.pic_ids ? row.pic_ids.split(',') : [];
                        let picNames = row.pic_names ? row.pic_names.split(',') : [];
                        let picPictures = row.pic_pictures ? row.pic_pictures.split(',') : [];

                        if (picIds.length === 0 && row.pic) {
                            picIds = row.pic.split(',');
                        }

                        // Map to object array
                        let assignedPics = picIds.map((id, index) => {
                            return {
                                id: id,
                                name: picNames[index] || 'User',
                                picture: picPictures[index] || ''
                            };
                        });

                        const defaultAvatarUrl = 'https://trusmiverse.com/hr/uploads/profile/anonim.jpg';

                        if (assignedPics.length > 0) {
                            let html = '<div class="d-flex align-items-center justify-content-center">';
                            const displayLimit = 2;
                            const visiblePics = assignedPics.slice(0, displayLimit);
                            const remainingCount = assignedPics.length - displayLimit;

                            visiblePics.forEach((pic, index) => {
                                let name = pic.name;
                                // Basic path check
                                let src = defaultAvatarUrl;
                                if (pic.picture && pic.picture.indexOf('http') === 0) src = pic.picture;
                                else if (pic.picture) src = `https://trusmiverse.com/hr/uploads/profile/${pic.picture}`;

                                const marginStyle = index > 0 ? 'margin-left: -8px;' : '';
                                html += `<img alt="${pic.name}" class="rounded-circle border border-2 border-white"
                                        src="${src}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="${pic.name}"
                                        width="28" height="28" style="${marginStyle}" 
                                        onerror="this.src='${defaultAvatarUrl}'"/>`;
                            });

                            if (remainingCount > 0) {
                                html += `<div class="rounded-circle border border-2 border-white bg-light d-flex align-items-center justify-content-center fw-bold text-secondary"
                                        style="width: 28px; height: 28px; font-size: 10px; margin-left: -8px; cursor: help;"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="${assignedPics.slice(displayLimit).map(p => p.name).join(', ')}">
                                        +${remainingCount}
                                    </div>`;
                            }
                            html += '</div>';
                            return html;
                        } else {
                            return '<span class="text-muted small">Unassigned</span>';
                        }
                    },
                    className: 'text-center'
                },
                {
                    data: 'status',
                    render: function (data, type, row) {
                        const statusName = SUB_STATUS[data] ? SUB_STATUS[data].name : 'UNKNOWN';
                        let statusBadge = '';

                        if (statusName === 'APPROVED') {
                            statusBadge = `<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2">${statusName}</span>`;
                        } else if (statusName === 'WAITING') {
                            statusBadge = `<span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-2">${statusName}</span>`;
                        } else if (statusName === 'ON REVIEW') {
                            statusBadge = `<span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-2">${statusName}</span>`;
                        } else if (statusName === 'REJECTED') {
                            statusBadge = `<span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2">${statusName}</span>`;
                        } else {
                            statusBadge = `<span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-2">${statusName}</span>`;
                        }
                        return statusBadge;
                    },
                    className: 'text-center'
                },
                {
                    "data": "overall_score",
                    "render": function (data, type, row) {
                        let badgeClass = 'bg-secondary';
                        let status = data ? data.toLowerCase() : '';

                        // HIGH >= 80
                        // MEDIUM >= 60
                        // LOW < 60

                        if (data >= 80) badgeClass = 'badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2';
                        else if (data >= 60) badgeClass = 'badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-2';
                        else badgeClass = 'badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2';

                        return `<span class="badge ${badgeClass}">${data || '-'}</span>`;
                    },
                    "className": "text-center"
                },
                {
                    data: 'activation_id',
                    render: function (data, type, row) {
                        const statusName = SUB_STATUS[row.status] ? SUB_STATUS[row.status].name : '';
                        let editBtn = '';

                        if (statusName !== 'APPROVED' && statusName !== 'REJECTED') {
                            editBtn = `<button class="btn btn-link text-success p-0 hover-primary me-2" 
                            onclick="editActivation('${data}')"
                            title="Edit Task">
                            <i class="bi bi-pencil-square"></i>
                        </button>`;
                        }

                        return `
                    <div class="d-flex justify-content-end align-items-center">
                        <button class="btn btn-link text-muted p-0 hover-primary me-2" 
                            onclick="viewActivationDetail('${data}')"
                            title="View Details">
                            <i class="bi bi-eye"></i>
                        </button>
                        ${editBtn}
                    </div>
                    `;
                    },
                    className: 'text-end'
                }
            ],
            drawCallback: function () {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('#dt_activation [data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        });

    }

    window.viewActivationDetail = async function (activationId) {
        // Show Modal immediately and loader inside
        const modal = new bootstrap.Modal(document.getElementById('viewActivationDetailModal'));
        modal.show();

        // Set loading state in modal fields if needed or a global overlay
        // For now, assume values update quickly

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
                const analysis = result.analysis;

                // Populate Fields
                $('#view_activation_id').text('#ACT-' + data.activation_id);
                $('#view_activation_title').text(data.title || '-');
                // Assuming campaign name is global or can be fetched. 
                // In activation tab we often have campaignData available if passed. 
                // If not available, leave as '-'
                if (typeof campaignData !== 'undefined') {
                    $('#view_activation_category').text(campaignData.campaign_name || 'Activation Task');
                }

                // Status
                const statusName = SUB_STATUS[data.status] ? SUB_STATUS[data.status].name : 'UNKNOWN';
                $('#view_activation_status').text(statusName);
                $('#view_activation_priority').addClass('d-none');

                // Dates
                $('#view_activation_period_start').text(data.period_start || '-');
                $('#view_activation_period_end').text(data.period_end || '-');

                // Details
                $('#view_activation_budget').text('Rp ' + formatRibuanActivation(data.budget));
                $('#view_activation_platform').text(data.platform_names || '-');
                $('#view_activation_content_generated').text(data.content_produced_names || '-');

                // Text Areas
                $('#view_activation_target_audience').html(data.target_audience || '-');
                $('#view_activation_description').html(data.description || '-');

                // PIC (Sidebar)
                let picIds = data.pic_ids ? data.pic_ids.split(',') : (data.pic ? data.pic.split(',') : []);

                $('#view_activation_assigned').empty();
                if (picIds.length > 0) {
                    // If we have access to user data locally or need to fetch?
                    // Usually get_activation_detail fetches raw row?
                    // If we don't have user details, we might need a separate call or rely on what's available.
                    // Ideally the model joins employees.
                    // Let's assume for now we list IDs or if names available. 
                    // If data.pic_names exists (from join)
                    let assignedHtml = '<div class="row avatar-group">';
                    if (data.pic_names) {
                        let names = data.pic_names.split(',');
                        let pics = data.pic_pictures ? data.pic_pictures.split(',') : [];
                        names.forEach((name, i) => {
                            let src = pics[i] ? `https://trusmiverse.com/hr/uploads/profile/${pics[i]}` : 'https://trusmiverse.com/hr/uploads/profile/anonim.jpg';
                            assignedHtml += `<div class="col-auto me-2 mb-2 badge bg-light text-dark rounded-pill d-flex align-items-center gap-2">
                            <div class="avatar avatar-30 rounded-circle border border-white" data-bs-toggle="tooltip" title="${name}">
                                <img src="${src}" class="rounded-circle w-100 h-100" alt="${name}">
                            </div> <span class="me-2">${name}</span></div>`;
                        });
                    } else {
                        assignedHtml += `<span class="small text-muted">${picIds.length} Assigned</span>`;
                    }
                    assignedHtml += '</div>';
                    $('#view_activation_assigned').html(assignedHtml);
                } else {
                    $('#view_activation_assigned').text('Unassigned');
                }

                // Load AI Analysis
                if (analysis) {
                    displayActivationAIAnalysis(analysis);
                }

                // Button Visibility Logic
                $('#btnApproveActivation').data('id', data.activation_id);
                $('#btnRejectActivation').data('id', data.activation_id);
                $('#btnCancelApproveActivation').data('id', data.activation_id);

                $('#btnCancelApproveActivation').addClass('d-none');
                $('#btnRejectActivation').removeClass('d-none');
                $('#btnApproveActivation').removeClass('d-none').prop('disabled', false).html('<i class="bi bi-check-circle me-2"></i>Approve Activation');

                if (data.status == 3) {
                    $('#btnApproveActivation').addClass('d-none');
                    $('#btnRejectActivation').addClass('d-none');
                    $('#btnCancelApproveActivation').removeClass('d-none');
                }

                // Bind Re-analyze button
                $('#btn_run_activation_analysis').off('click').on('click', function () {
                    runActivationAnalysis(activationId);
                });
                $('#btn_reanalyze_activation').off('click').on('click', function () {
                    // This button forces a re-analysis
                    runActivationAnalysis(activationId);
                });

                // Load Logs
                loadActivationDetailLogs(data.activation_id);

            } else {
                Swal.fire('Error', 'Failed to fetch activation details', 'error');
            }
        } catch (e) {
            console.error(e);
            // Swal.fire('Error', 'An error occurred', 'error'); 
        }
    }

    function loadActivationAnalysis(activationId) {
        // Show loader in empty state area, hide content
        $('#activation_ai_analysis_empty').removeClass('d-none').html(`
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 text-muted">Running AI Analysis...</p>
        </div>
    `);
        $('#activation_ai_analysis_content').addClass('d-none');

        const formData = new FormData();
        formData.append('activation_id', activationId);

        fetch(`${BASE_URL}compas/activation/get_analysis`, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    displayActivationAIAnalysis(result.data);
                } else {
                    $('#activation_ai_analysis_empty').html(`
                <div class="text-center py-5">
                    <img src="${BASE_URL}assets/images/compas/ai-analysis.svg" class="mb-3" width="150" alt="AI Analysis">
                    <h5 class="fw-bold">AI Analysis Available</h5>
                    <p class="text-muted small mb-4">Get instant insights, SWOT analysis, and strategic recommendations for this activation.</p>
                    <button class="btn btn-primary" id="btn_run_start_analysis">
                        <i class="bi bi-cpu me-2"></i> Run AI Analysis
                    </button>
                </div>
             `);
                    $('#btn_run_start_analysis').off('click').on('click', function () {
                        runActivationAnalysis(activationId);
                    });
                }
            })
            .catch(error => {
                console.error('Error loading analysis:', error);
                $('#activation_ai_analysis_empty').html(`
            <div class="text-center py-5 text-danger">
                <i class="bi bi-exclamation-triangle display-4"></i>
                <p class="mt-2">Failed to load analysis.</p>
                <button class="btn btn-sm btn-outline-danger" onclick="loadActivationAnalysis('${activationId}')">Try Again</button>
            </div>
        `);
            });
    }


    function runActivationAnalysis(activationId) {
        $('#btn_run_activation_analysis').prop('disabled', true).html('<i class="spinner-border spinner-border-sm me-2"></i> Analyzing...');
        $('#btn_reanalyze_activation').prop('disabled', true).html('<i class="spinner-border spinner-border-sm me-2"></i> Analyzing...');

        const formData = new FormData();
        formData.append('activation_id', activationId);

        fetch(`${BASE_URL}compas/activation/reanalyze`, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success' || result.data) { // Accommodate n8n result structure if needed
                    // After re-analysis, reload the detailed analysis view
                    loadActivationAnalysis(activationId);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Analysis Failed',
                        text: result.message || 'Unable to complete AI analysis.'
                    });
                }
            })
            .catch(error => {
                console.error('Error running analysis:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred during analysis.'
                });
            })
            .finally(() => {
                $('#btn_run_activation_analysis').prop('disabled', false).html('<i class="bi bi-cpu me-2"></i> Run AI Analysis');
                $('#btn_reanalyze_activation').prop('disabled', false).html('<i class="bi bi-arrow-repeat me-1"></i> Re-Analyze');
            });
    }


    function displayActivationAIAnalysis(data) {
        $('#activation_ai_analysis_empty').addClass('d-none');
        $('#activation_ai_analysis_content').removeClass('d-none');

        // Helper function to safely parse JSON strings
        const safeJsonParse = (jsonString, defaultVal = {}) => {
            if (typeof jsonString === 'string') {
                try {
                    return JSON.parse(jsonString);
                } catch (e) {
                    console.warn("Failed to parse JSON string:", jsonString, e);
                    return defaultVal;
                }
            }
            return jsonString;
        };

        // 1. Scores
        $('#activation_ai_score').text(data.overall_score || 0);

        // 2. Executive Summary (Array handling)
        if (data.executive_summary) {
            let summaryHtml = '';
            let summaryData = data.executive_summary;

            if (typeof summaryData === 'string') {
                try { summaryData = JSON.parse(summaryData); } catch (e) { summaryData = [summaryData]; }
            }

            if (Array.isArray(summaryData)) {
                summaryHtml = summaryData.map(item => `<li>${item}</li>`).join('');
            } else {
                // Clean string if needed (remove quotes if start/end)
                if (typeof summaryData === 'string' && summaryData.startsWith('"') && summaryData.endsWith('"')) {
                    summaryData = summaryData.slice(1, -1);
                }
                summaryHtml = `<li>${summaryData}</li>`;
            }
            $('#activation_ai_executive_summary').html(summaryHtml);
        }

        // Helper for Progress Bars
        const createProgress = (label, score, colorClass = 'bg-primary') => `
        <div class="mb-2">
            <div class="d-flex justify-content-between small mb-1">
                <span class="text-white-50">${label}</span>
                <span class="text-white fw-bold">${score}</span>
            </div>
            <div class="progress" style="height: 4px; background-color: rgba(255,255,255,0.1);">
                <div class="progress-bar ${colorClass}" role="progressbar" style="width: ${score}%" aria-valuenow="${score}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    `;

        // 3. Strategy & Funnel Stats (detail_alignment)
        // Keys: kesesuaian_cta, kesesuaian_pesan, kesesuaian_funnel, kesesuaian_target_audiens, kesesuaian_penyelesaian_problem
        let strategyHtml = '';
        let align = data.detail_alignment;
        if (typeof align === 'string') try { align = JSON.parse(align); } catch (e) { }

        if (align && typeof align === 'object') {
            if (align.kesesuaian_target_audiens) strategyHtml += createProgress('Audience Match', align.kesesuaian_target_audiens, 'bg-info');
            if (align.kesesuaian_penyelesaian_problem) strategyHtml += createProgress('Problem Solution', align.kesesuaian_penyelesaian_problem, 'bg-info');
            if (align.kesesuaian_pesan) strategyHtml += createProgress('Message Fit', align.kesesuaian_pesan, 'bg-info');
            if (align.kesesuaian_cta) strategyHtml += createProgress('CTA Clarity', align.kesesuaian_cta, 'bg-info');
            if (align.kesesuaian_funnel) strategyHtml += createProgress('Funnel Fit', align.kesesuaian_funnel, 'bg-info');
        }
        $('#activation_ai_strategy_funnel_stats').html(strategyHtml || '<span class="text-muted small">No strategy data</span>');


        // 4. Engagement & Impact (funnel_impact)
        // Keys: skor_loyalty, skor_awareness, skor_conversion, skor_consideration
        let engagementHtml = '';
        let funnel = data.funnel_impact;
        if (typeof funnel === 'string') try { funnel = JSON.parse(funnel); } catch (e) { }

        if (funnel && typeof funnel === 'object') {
            if (funnel.skor_awareness) engagementHtml += createProgress('Awareness', funnel.skor_awareness, 'bg-warning');
            if (funnel.skor_consideration) engagementHtml += createProgress('Consideration', funnel.skor_consideration, 'bg-warning');
            if (funnel.skor_conversion) engagementHtml += createProgress('Conversion', funnel.skor_conversion, 'bg-warning');
            if (funnel.skor_loyalty) engagementHtml += createProgress('Loyalty', funnel.skor_loyalty, 'bg-warning');
        }
        $('#activation_ai_engagement_stats').html(engagementHtml || '<span class="text-muted small">No engagement data</span>');


        // 5. SWOT
        const renderList = (items, targetId) => {
            let list = items || [];
            if (typeof list === 'string') {
                try { list = JSON.parse(list); } catch (e) { list = [list]; }
            }
            if (!Array.isArray(list)) list = [list];

            const html = list.map(item => `<li class="d-flex align-items-start gap-2"><i class="bi bi-dot mt-1 text-white-50"></i> <span class="text-white-50">${item}</span></li>`).join('');
            $(targetId).html(html || '<li>No data</li>');
        };

        renderList(data.swot_strengths, '#activation_ai_swot_strengths');
        renderList(data.swot_weaknesses, '#activation_ai_swot_weaknesses');
        renderList(data.swot_opportunities, '#activation_ai_swot_opportunities');
        renderList(data.swot_threats, '#activation_ai_swot_threats');


        // 6. Performance Estimation
        let perfHtml = '';
        let perf = data.performance_estimation;
        if (typeof perf === 'string') try { perf = JSON.parse(perf); } catch (e) { }

        if (perf && typeof perf === 'object') {
            if (perf.estimasi_leads_tambahan) perfHtml += `<div class="d-flex justify-content-between mb-2 small"><span class="text-white-50">Add. Leads</span> <span class="text-success fw-bold">+${perf.estimasi_leads_tambahan}</span></div>`;
            if (perf.estimasi_multiplier_engagement) perfHtml += `<div class="d-flex justify-content-between mb-2 small"><span class="text-white-50">Eng. Multiplier</span> <span class="text-success fw-bold">${perf.estimasi_multiplier_engagement}x</span></div>`;
            if (perf.estimasi_peningkatan_konversi_persen) perfHtml += `<div class="d-flex justify-content-between mb-2 small"><span class="text-white-50">Conv. Increase</span> <span class="text-success fw-bold">${perf.estimasi_peningkatan_konversi_persen}%</span></div>`;
        }
        $('#activation_ai_performance_stats').html(perfHtml || '<span class="text-muted small">-</span>');

        // 7. Budget Analysis
        let costHtml = '';
        let bud = data.budget_analysis;
        if (typeof bud === 'string') try { bud = JSON.parse(bud); } catch (e) { }

        if (bud && typeof bud === 'object') {
            if (bud.skor_realistis_anggaran) costHtml += createProgress('Realistic', bud.skor_realistis_anggaran, 'bg-success');
            if (bud.skor_opportunity_cost) costHtml += createProgress('Opp. Cost', bud.skor_opportunity_cost, 'bg-success');
            if (bud.skor_risiko_hidden_cost) costHtml += createProgress('Hidden Cost Risk', bud.skor_risiko_hidden_cost, 'bg-danger');

            if (bud.komentar_anggaran) {
                costHtml += `<div class="mt-2 text-white-50 fst-italic xx-small border-top border-secondary pt-2">${bud.komentar_anggaran}</div>`;
            }
        }
        $('#activation_ai_cost_stats').html(costHtml || '<span class="text-muted small">-</span>');

        // 8. Risk Assessment
        let riskHtml = '';
        let risk = data.risk_analysis;
        if (typeof risk === 'string') try { risk = JSON.parse(risk); } catch (e) { }

        if (risk && typeof risk === 'object') {
            if (risk.skor_risiko_branding) riskHtml += createProgress('Branding Risk', risk.skor_risiko_branding, 'bg-danger');
            if (risk.skor_risiko_eksekusi) riskHtml += createProgress('Execution Risk', risk.skor_risiko_eksekusi, 'bg-danger');
            if (risk.skor_risiko_operasional) riskHtml += createProgress('Ops Risk', risk.skor_risiko_operasional, 'bg-danger');
            if (risk.skor_risiko_ketidakkonsistenan_pesan) riskHtml += createProgress('Inconsistency', risk.skor_risiko_ketidakkonsistenan_pesan, 'bg-danger');
        }
        $('#activation_ai_risk_stats').html(riskHtml || '<span class="text-muted small">-</span>');


        // 9. Recommendations
        let recs = data.recommendations;
        if (typeof recs === 'string') try { recs = JSON.parse(recs); } catch (e) { }
        let recHtml = '';

        const renderRecCategory = (title, items, icon, color) => {
            if (!items || items.length === 0) return '';
            let itemsHtml = items.map(i => `
            <div class="d-flex gap-2 mb-2">
                 <i class="bi bi-check-circle-fill ${color} mt-1 flex-shrink-0" style="font-size: 0.8rem;"></i>
                 <span class="small text-white-50">${i}</span>
            </div>
         `).join('');

            return `
            <div class="col-md-4">
                <div class="p-2 border border-secondary rounded-3 h-100">
                    <h6 class="${color} fw-bold text-uppercase xx-small mb-2 d-flex align-items-center gap-2">
                        <i class="bi ${icon}"></i> ${title}
                    </h6>
                    ${itemsHtml}
                </div>
            </div>
         `;
        };

        if (recs) {
            if (Array.isArray(recs)) {
                recHtml = recs.map(rec => `<div class="col-12"><p class="small text-white-50 mb-1"><i class="bi bi-dot"></i> ${rec}</p></div>`).join('');
            } else if (typeof recs === 'object') {
                recHtml += renderRecCategory('Short Term', recs.jangka_pendek, 'bi-hourglass-split', 'text-warning');
                recHtml += renderRecCategory('Long Term', recs.jangka_panjang, 'bi-graph-up-arrow', 'text-success');
                recHtml += renderRecCategory('Scaling Idea', recs.ide_scaling, 'bi-rocket-takeoff', 'text-info');
            }
        }
        $('#activation_ai_recommendations_grid').html(recHtml);

        if (typeof reinitTooltips === 'function') {
            reinitTooltips('#activation_ai_analysis_content');
        } else if (typeof initHoverableTooltips === 'function') {
            initHoverableTooltips('#activation_ai_analysis_content [data-bs-toggle="tooltip"]');
        }
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

        // Populate extra campaign info
        $('#info-campaign-name').text(campaignData.campaign_name || '-');
        $('#info-campaign-period').text(campaignData.campaign_period || (campaignData.campaign_start_date + ' s/d ' + campaignData.campaign_end_date));
        $('#info-campaign-objective').text(campaignData.objectives || '-');
        $('#info-campaign-pillar').text(campaignData.content_pillars || '-');
        $('#info-campaign-angle').text(campaignData.content_angle || '-');

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

    window.editActivation = async function (activationId) {
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

                // Populate extra campaign info
                $('#info-campaign-name').text(campaignData.campaign_name || '-');
                $('#info-campaign-period').text(campaignData.campaign_period || (campaignData.campaign_start_date + ' s/d ' + campaignData.campaign_end_date));
                $('#info-campaign-objective').text(campaignData.objectives || '-');
                $('#info-campaign-pillar').text(campaignData.content_pillars || '-');
                $('#info-campaign-angle').text(campaignData.content_angle || '-');

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
            if (!selectedValues.pic) {
                selectedValues.pic = [];
            }
            selectedValues.pic.push(CURRENT_USER_ID);
        }

        //initialize Variables
        // Wizard Logic
        let activationCurrentStep = 1;
        const activationTotalSteps = 2;
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
            // handleChosenData('#platform-tujuan', 'compas/activation/get_platforms', { id: campaignData.brand_id }, 'platform_id', 'platform_name', 'Platform Tujuan', selectedValues.platform);
            // handleChosenData('#content-result', 'compas/campaign/get_generated_contents', { brand_id: campaignData.brand_id }, 'cg_id', 'cg_name', 'Content Generated', selectedValues.content);
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

    window.chatSimulation = function () {
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

    window.handleChatKeyPress = function (event) {
        if (event.key === 'Enter') {
            window.chatSimulation();
        }
    };



    window.animateEfficiency = function () {
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
        showLoader({ text: 'Saving and Analyzing...' });

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

    window.initHoverableTooltips = function (selector) {
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



    async function loadEmployeesForInviteActivation() {
        try {
            const response = await fetch(`${BASE_URL}compas/activation/get_employees`);
            const result = await response.json();

            if (result.status) {
                const select = $('#invite_activation_team_select');
                select.empty();

                // Get current team to pre-select
                const campaignId = $detailId.value;
                const teamFormData = new FormData();
                teamFormData.append('campaign_id', campaignId);

                const teamResponse = await fetch(`${BASE_URL}compas/activation/get_activation_team`, {
                    method: 'POST',
                    body: teamFormData
                });
                const teamResult = await teamResponse.json();
                const currentTeamIds = teamResult.data && teamResult.data.activation_team ? teamResult.data.activation_team.split(',') : [];

                result.data.forEach(employee => {
                    const selected = currentTeamIds.includes(employee.user_id.toString()) ? 'selected' : '';
                    select.append(`<option value="${employee.user_id}" ${selected}>${employee.full_name}</option>`);
                });

                // Initialize or update Chosen
                if (select.hasClass("chosen-select")) {
                    select.chosen('destroy').chosen({
                        width: '100%',
                        no_results_text: "No employee found",
                        placeholder_text_multiple: "Select team members..."
                    });
                }
            }
        } catch (error) {
            console.error('Error loading employees:', error);
        }
    }

    async function saveActivationTeam() {
        const campaignId = $detailId.value;
        const team = $('#invite_activation_team_select').val();

        const formData = new FormData();
        formData.append('campaign_id', campaignId);
        if (team) {
            team.forEach(id => formData.append('team[]', id));
        }

        showLoader({ text: 'Saving Team...' });

        try {
            const response = await fetch(`${BASE_URL}compas/activation/save_activation_team`, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: result.message,
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#inviteActivationTeamModal').modal('hide');
                loadActivationTeam();
            } else {
                Swal.fire('Error', result.message, 'error');
            }
        } catch (error) {
            console.error('Error saving activation team:', error);
            Swal.fire('Error', 'An error occurred while saving the team.', 'error');
        } finally {
            hideLoader();
        }
    }

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
                if (val !== null) {
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

    /* -------------------------------------------------------------------------- */
    /*                          Approval Workflow Logic                           */
    /* -------------------------------------------------------------------------- */

    // Approve Activation
    $(document).off('click', '#btnApproveActivation').on('click', '#btnApproveActivation', function () {
        let id = $(this).data('id');
        let target = campaignData.activation_target;
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to approve this activation plan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: BASE_URL + 'compas/activation/approve_activation',
                    type: 'POST',
                    data: { id: id, target: target },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status) {
                            loadActivationDetail();
                            loadTeamPerformance();
                            loadCampaignData();
                            Swal.fire('Approved!', 'The activation plan has been approved.', 'success').then(() => {
                                $('#viewActivationDetailModal').modal('hide');
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Failed to approve activation', 'error');
                    }
                });
            }
        });
    });

    // Cancel Approval
    $(document).off('click', '#btnCancelApproveActivation').on('click', '#btnCancelApproveActivation', function () {
        let id = $('#btnApproveActivation').data('id');
        let target = campaignData.activation_target;
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to cancel the approval for this activation. It will revert to draft.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel approval!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: BASE_URL + 'compas/activation/cancel_approve_activation',
                    type: 'POST',
                    data: { id: id, target: target },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status) {
                            Swal.fire('Cancelled!', 'Approval has been cancelled.', 'success').then(() => {
                                $('#viewActivationDetailModal').modal('hide');
                                loadActivationDetail();
                                loadTeamPerformance();
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Failed to cancel approval', 'error');
                    }
                });
            }
        });
    });

    // Revise / Reject Activation
    $(document).off('click', '#btnRejectActivation').on('click', '#btnRejectActivation', function () {
        let id = $('#btnApproveActivation').data('id');
        let target = campaignData.activation_target;
        Swal.fire({
            title: 'Revise / Reject Plan',
            html: `
                        <div class="text-start">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Action</label>
                                <div class="d-flex gap-2">
                                    <input type="radio" class="btn-check" name="reject_action" id="action_revise" value="5" autocomplete="off" checked>
                                    <label class="btn btn-outline-warning w-50" for="action_revise"><i class="bi bi-pencil-square me-1"></i> Revise</label>

                                    <input type="radio" class="btn-check" name="reject_action" id="action_reject" value="4" autocomplete="off">
                                    <label class="btn btn-outline-danger w-50" for="action_reject"><i class="bi bi-x-circle me-1"></i> Reject</label>
                                </div>
                            </div>
                            <div class="mb-0">
                                <label class="form-label fw-bold">Note / Reason</label>
                                <textarea id="reject_note" class="form-control" rows="3" placeholder="Type your reason here..."></textarea>
                            </div>
                        </div>
                    `,
            showCancelButton: true,
            confirmButtonText: 'Submit',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                const status = document.querySelector('input[name="reject_action"]:checked').value;
                const note = document.getElementById('reject_note').value;

                return $.ajax({
                    url: BASE_URL + 'compas/activation/reject_activation',
                    type: 'POST',
                    data: { id: id, note: note, status: status, target: target },
                    dataType: 'json'
                }).then(response => {
                    if (!response.status) {
                        throw new Error(response.message || 'Request failed');
                    }
                    return response;
                }).catch(error => {
                    Swal.showValidationMessage(
                        `Request failed: ${error}`
                    )
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire('Success', 'Activation rejected/revised successfully', 'success');
                $('#viewActivationDetailModal').modal('hide');
                loadActivationDetail();
                loadTeamPerformance();
                loadCampaignData();
            }
        });
    });

    function loadActivationDetailLogs(activationId) {
        const container = $('#activation-activity-log-container');
        container.html('<div class="text-center py-3"><div class="spinner-border spinner-border-sm text-primary" role="status"></div></div>');

        $.ajax({
            url: BASE_URL + 'compas/activation/get_activity_log',
            type: 'POST',
            data: { activation_id: activationId },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success' && response.data && response.data.length > 0) {
                    let logsHtml = '';
                    response.data.forEach(log => {
                        let color = 'primary';
                        if (log.action_type === 'STATUS_CHANGE') color = 'info';
                        else if (log.action_type === 'CREATED') color = 'success';
                        else if (log.action_type === 'UPDATED') color = 'warning';
                        else if (log.action_type === 'NOTE_ADDED') color = 'secondary';

                        logsHtml += `
                    <div class="position-relative ps-4 mb-3">
                        <div class="position-absolute top-0 start-0 translate-middle-x bg-${color} rounded-circle border border-white"
                            style="width: 12px; height: 12px; margin-top: 6px; margin-left: -1px;"></div>
                        <p class="mb-1 small text-dark"><span class="fw-bold">${log.user_name || 'User'}</span> ${log.description}</p>
                        <span class="text-muted small" style="font-size: 11px;">${log.time_ago || log.created_at}</span>
                    </div>`;
                    });
                    container.html(logsHtml);
                } else {
                    container.html('<p class="text-muted small fst-italic ps-3">No activity logs yet.</p>');
                }
            },
            error: function () {
                container.html('<p class="text-danger small ps-3">Failed to load logs.</p>');
            }
        });
    }
};
