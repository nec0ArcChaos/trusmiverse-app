window.LoadInit = window.LoadInit || {};
window.LoadInit['tabs'] = window.LoadInit['tabs'] || {};
window.LoadInit['tabs']['talent'] = function (container) {
    if (typeof campaignData !== 'undefined' && campaignData.campaign_status == 4) {
        $('.action-restricted').addClass('d-none');
    } else {
        $('.action-restricted').removeClass('d-none');
    }
    function formatRibuan(number) {
        if (number == 0) {
            return "0";
        }
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Global helper for talent budget/rate
    window.formatRibuanTalent = formatRibuan;
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

    $('.tanggal').mask('00-00-0000 00:00:00');
    $('.tanggal').datetimepicker({
        format: 'Y-m-d H:i:00',
        timepicker: true,
        scrollMonth: false,
        scrollInput: false,
        minDate: 0,
    });

    const editorTheme = {
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
    };

    [talent_persona_editor] = new OverType('#talent_overtype_persona', {
        theme: editorTheme,
        toolbar: true,
        placeholder: 'Topik, gaya bahasa, tone, dll...',
        value: '',
        onChange: (value) => { $('#talent_persona').val(value); }
    });

    // SLA Editor Removed as per modal structure


    /**
     * Talent Tab Javascript
     */
    let currentIncomingPage = 1;

    /**
     * Safe campaign ID getter — uses campaignData if available from parent scope,
     * otherwise falls back to the #detail_id hidden input.
     */
    function getCampaignId() {
        if (typeof campaignData !== 'undefined' && campaignData && campaignData.campaign_id) {
            return campaignData.campaign_id;
        }
        return $('#detail_id').val() || '';
    }


    // Load Incoming Briefs / Approved Strategies
    loadApprovedActivations();

    // Load Talent Team
    loadTalentTeam();

    // Load Talent List Table
    loadTalentListTable();

    // Load Talent Log
    loadTalentLogs();

    // Load Team Performance (campaign-wide initially)
    loadTeamPerformance();

    // Populate content filter dropdown for team performance
    loadTeamPerfContentFilter();

    // Init Comments
    initComments();

    /**
     * Populate the #team_perf_content_filter select with content plans for this campaign.
     * Fetches from get_contents_for_talent which returns title, format, platform per content.
     */
    function loadTeamPerfContentFilter() {
        let campaignId = getCampaignId();
        $.ajax({
            url: BASE_URL + 'compas/talent/get_contents_for_talent',
            type: 'GET',
            data: { campaign_id: campaignId },
            dataType: 'json',
            success: function (res) {
                const $sel = $('#team_perf_content_filter');
                $sel.find('option:not(:first)').remove();
                if (res.status && res.data.length > 0) {
                    res.data.forEach(function (c) {
                        const label = (c.title || 'Untitled') +
                            (c.talent_target ? ' (Target: ' + c.talent_target + ')' : '');
                        $sel.append($('<option>', { value: c.content_id, text: label }));
                    });
                }
            }
        });
    }

    // Handle content filter change → reload team performance per content
    $(document).off('change', '#team_perf_content_filter').on('change', '#team_perf_content_filter', function () {
        const contentId = $(this).val();
        loadTeamPerformance(contentId || null);
    });

    function loadTeamPerformance(contentId) {
        let campaignId = getCampaignId();
        let params = { campaign_id: campaignId };
        if (contentId) params.content_id = contentId;

        $.ajax({
            url: BASE_URL + 'compas/talent/get_team_performance_stats',
            type: 'GET',
            data: params,
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    let d = response.data;
                    $('#team_efficiency_talent').text(d.efficiency + '%');
                    $('#team_done_talent').text(d.total_approved + '/' + (d.target || '?'));

                    // Show/hide per-content indicator
                    if (contentId) {
                        $('#team_perf_content_label').text('for this content').show();
                    } else {
                        $('#team_perf_content_label').text('campaign total').show();
                    }
                }
            }
        });
    }

    function loadTalentListTable() {
        $('#dt_talent_list').DataTable({
            "processing": true,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "serverSide": false,
            "ajax": {
                "url": BASE_URL + "compas/talent/get_talent_list",
                "type": "POST",
                "data": function (d) {
                    d.campaign_id = $('#detail_id').val();
                }
            },
            "columns": [
                {
                    // Column 1: Talent Name + Niche
                    "data": "talent_name",
                    "render": function (data, type, row) {
                        let niche = row.content_niche || '-';
                        return `
                        <div class="d-flex flex-column ps-2">
                            <span class="fs-14 text-dark fw-bold mb-1">${data || 'Unknown Talent'}</span>
                            <span class="fs-12 text-muted"><i class="bi bi-tag me-1"></i>${niche}</span>
                        </div>`;
                    }
                },
                {
                    // Column 2: Linked Content (resolved names)
                    "data": "content_title",
                    "render": function (data, type, row) {
                        if (!data && !row.platform_name && !row.content_pillar_name) {
                            return '<span class="text-muted small fst-italic">No content linked</span>';
                        }
                        let title = data || 'Untitled';
                        let platform = row.platform_name || null;
                        let pillar = row.content_pillar_name || null;
                        let placement = row.placement_name || null;
                        let format = row.format_name || null;

                        let badges = '';
                        if (platform) badges += `<span class="badge bg-purple-soft text-purple border-purple me-1">${platform}</span>`;
                        if (pillar) badges += `<span class="badge bg-info-soft text-info border-info me-1">${pillar}</span>`;
                        if (placement) badges += `<span class="badge bg-light text-secondary border me-1">${placement}</span>`;

                        return `
                        <div class="d-flex flex-column">
                            <span class="fs-13 text-dark fw-semibold mb-1">
                                <i class="bi bi-file-earmark-play me-1 text-purple"></i>${title}${format ? ' <small class="text-muted">[' + format + ']</small>' : ''}
                            </span>
                            <div>${badges || '<span class="text-muted small">-</span>'}</div>
                        </div>`;
                    }
                },
                {
                    // Column 3: PIC Avatars
                    "data": "pic_name",
                    "render": function (data, type, row) {
                        if (!row.profile_picture_team) return '<span class="text-muted small">Unassigned</span>';
                        let pics = row.profile_picture_team;
                        let names = row.pic_name ? row.pic_name.split(',') : [];

                        let html = '<div class="avatar-group justify-content-center">';
                        pics.forEach((pic, index) => {
                            let name = names[index] || 'User';
                            let src = pic;
                            if (pic.indexOf('http') === -1) src = `${BASE_URL}uploads/users/${pic}`;
                            html += `
                            <div class="avatar avatar-30 rounded-circle border border-white"
                                 style="width:30px; height:30px;"
                                 data-bs-toggle="tooltip"
                                 title="${name}">
                                <img src="${src}" class="rounded-circle w-100 h-100" alt="${name}">
                            </div>`;
                        });
                        if (row.more_users > 0) {
                            html += `
                            <div class="avatar avatar-30 rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center border border-white small"
                                 style="width:30px; height:30px; font-size:10px; margin-left: -10px;">
                                +${row.more_users}
                            </div>`;
                        }
                        html += '</div>';
                        return html;
                    },
                    "className": "text-center"
                },
                {
                    // Column 4: Status badge
                    "data": "sub_status_name",
                    "render": function (data, type, row) {
                        let statusBadge = 'bg-secondary';
                        let status = data ? data.toUpperCase() : '';
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
                        return statusBadge;
                    },
                    "className": "text-center"
                },
                {
                    "data": "viability_score",
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
                    // Column 5: Actions
                    "data": "talent_id",
                    "className": "text-end pe-4",
                    "orderable": false,
                    "render": function (data, type, row) {
                        let editBtn = '';
                        let deleteBtn = '';
                        const statusName = (row.sub_status_name || '').toLowerCase();
                        if (statusName !== 'approved') {
                            editBtn = `<button class="btn btn-sm btn-link text-success shadow-none btn-edit-talent" data-id="${row.talent_id}" data-bs-toggle="tooltip" title="Edit Talent"><i class="bi bi-pencil-square"></i></button>`;
                            deleteBtn = `<button class="btn btn-sm btn-link text-danger shadow-none btn-delete-talent" data-id="${row.talent_id}" data-bs-toggle="tooltip" title="Delete Talent"><i class="bi bi-trash"></i></button>`;
                        }
                        return `
                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn btn-sm btn-link text-muted shadow-none btn-view-talent" data-id="${row.talent_id}" data-bs-toggle="tooltip" title="View Detail"><i class="bi bi-eye"></i></button>
                            ${editBtn}
                        </div>`;
                    }
                }
            ],
            "language": {
                "emptyTable": "No talents found",
                "zeroRecords": "No matching records found"
            },
            "dom": 't',
            "paging": false,
            "info": false
        });

        // Re-initialize tooltips after each draw
        $('#dt_talent_list').on('draw.dt', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('#dt_talent_list [data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });
        });
    }


    $(document).off('click', '.btn-view-talent').on('click', '.btn-view-talent', function () {
        let id = $(this).data('id');

        // Reset Modal UI
        $('#talent_ai_analysis_empty').removeClass('d-none');
        $('#talent_ai_analysis_content').addClass('d-none');
        $('#view_talent_assigned .avatar-group').empty();
        $('#btnApproveTalentPlan').prop('disabled', true).data('id', id).html('<i class="bi bi-check-circle me-2"></i>Approve Plan');

        $('#view_talent_id_meta').text('Loading...');
        $('#view_talent_name').text('Loading...');

        // Load Details
        $.ajax({
            url: BASE_URL + 'compas/talent/get_talent_detail?talent_id=' + id,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    let data = response.data;

                    // Populate fields
                    $('#view_talent_id_meta').text('#TASK-' + data.talent_id);
                    $('#view_talent_name').text(data.talent_name || 'No Name');
                    // Status Mapping

                    let statusBadge = '';
                    let statuses = {
                        1: { name: 'WAITING', class: '<span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-2">WAITING</span>' },
                        2: { name: 'ON REVIEW', class: '<span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-2">ON REVIEW</span>' },
                        3: { name: 'APPROVED', class: '<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2">APPROVED</span>' },
                        4: { name: 'REJECTED', class: '<span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2">REJECTED</span>' },
                        5: { name: 'REVISION', class: '<span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-2">REVISION</span>' }
                    };

                    $('#view_talent_status_badge').html(statuses[data.status].class);

                    // Specific fields
                    $('#view_talent_niche_meta').text(data.content_niche || '-');
                    $('#view_talent_rate').text(data.rate ? 'Rp ' + formatRibuan(data.rate) : '-');
                    $('#view_talent_tiktok').text(data.username_tiktok || '-');
                    $('#view_talent_ig').text(data.username_ig || '-');

                    $('#view_talent_persona').html(data.persona || '-');
                    $('#view_talent_style').text(data.communication_style || '-');

                    // Linked Content (resolved names from backend)
                    if (data.content_title || data.platform_name || data.content_pillar_name) {
                        let platformBadge = data.platform_name ? `<span class="badge bg-purple-soft text-purple border-purple me-1">${data.platform_name}</span>` : '';
                        let pillarBadge = data.content_pillar_name ? `<span class="badge bg-info-soft text-info border-info me-1">${data.content_pillar_name}</span>` : '';
                        let placementBadge = data.placement_name ? `<span class="badge bg-light text-secondary border me-1">${data.placement_name}</span>` : '';
                        let formatLabel = data.format_name ? ` <small class="text-muted">[${data.format_name}]</small>` : '';
                        $('#view_talent_linked_content').html(`
                            <span class="fw-semibold text-dark">${data.content_title || 'Untitled'}${formatLabel}</span>
                            <div class="mt-1">${platformBadge}${pillarBadge}${placementBadge}</div>
                        `);
                    } else {
                        $('#view_talent_linked_content').html('<span class="text-muted small fst-italic">No content linked</span>');
                    }

                    // PICs

                    if (data.profile_picture_team && data.profile_picture_team.length > 0) {
                        let html = '<div class="row avatar-group">';
                        let names = data.pic_name ? data.pic_name.split(',') : [];
                        data.profile_picture_team.forEach((pic, idx) => {
                            console.log(pic);
                            let src = pic;
                            html += `
                            <div class="col-auto me-2 mb-2 badge bg-light text-dark rounded-pill d-flex align-items-center gap-2">
                            <div class="avatar avatar-30 rounded-circle border border-white" data-bs-toggle="tooltip" title="${names[idx] || 'User'}">
                                <img src="${src}" class="rounded-circle w-100 h-100" alt="${names[idx] || 'User'}">
                            </div> <span class="me-2">${names[idx] || 'User'}</span></div>
                            `;
                        });
                        html += '</div>';
                        $('#view_talent_assigned').html(html);
                        $('[data-bs-toggle="tooltip"]').tooltip();
                    } else {
                        $('#view_talent_assigned').html('<span class="small text-muted">Unassigned</span>');
                    }

                    // Activity Log for this talent
                    if (response.logs && response.logs.length > 0) {
                        let logsHtml = '';
                        response.logs.forEach(log => {
                            let color = 'primary';
                            if (log.action_type === 'STATUS_CHANGE') color = 'info';
                            else if (log.action_type === 'CREATED') color = 'success';
                            else if (log.action_type === 'UPDATED') color = 'warning text-dark';

                            logsHtml += `
                             <div class="position-relative ps-4 mb-3">
                                <div class="position-absolute top-0 start-0 translate-middle-x bg-${color} rounded-circle border border-white"
                                    style="width: 12px; height: 12px; margin-top: 6px; margin-left: -1px;"></div>
                                <p class="mb-1 small text-dark"><span class="fw-bold">${log.user_name}</span> ${log.description}</p>
                                <span class="text-muted small" style="font-size: 11px;">${log.time_ago}</span>
                             </div>
                             `;
                        });
                        $('#talent_activity_log').html(logsHtml);
                    } else {
                        $('#talent_activity_log').html('<p class="text-muted small ps-3">No activity yet.</p>');
                    }

                    // Button Visibility Logic
                    $('#btnCancelApproveTalent').addClass('d-none');
                    $('#btnRejectTalentPlan').removeClass('d-none');
                    $('#btnApproveTalentPlan').removeClass('d-none').prop('disabled', false).html('<i class="bi bi-check-circle me-2"></i>Approve Plan');

                    // Check if already approved (status == 3)
                    if (data.status == 3) {
                        $('#btnApproveTalentPlan').addClass('d-none');
                        $('#btnRejectTalentPlan').addClass('d-none');
                        $('#btnCancelApproveTalent').removeClass('d-none');
                    } else {
                        // Pending / Draft
                        // Logic: Can only approve if status is 'Review' (2) or similar? 
                        // For now enable for all except approved
                        $('#btnApproveTalentPlan').prop('disabled', false);
                    }

                    // Show Modal
                    $('#viewTalentDetailModal').modal('show');
                    if (response.analysis) {
                        displayTalentAIAnalysis(response.analysis?.output || null);
                        $('#btnApproveTalentPlan').prop('disabled', false);
                    } else {
                        $('#talent_ai_analysis_empty').removeClass('d-none');
                        $('#talent_ai_analysis_content').addClass('d-none');
                        $('#btnApproveTalentPlan').prop('disabled', true);
                    }
                    // Check for existing AI Analysis
                    // $.ajax({
                    //     url: BASE_URL + 'compas/content/analysis_ai',
                    //     type: 'POST',
                    //     data: { content_id: id },
                    //     dataType: 'json',
                    //     success: function (aiResponse) {
                    //         if (aiResponse.status === 'success') {
                    //             displayAIAnalysis(aiResponse.data);
                    //         } else {
                    //             $('#content_ai_analysis_empty').removeClass('d-none');
                    //             $('#content_ai_analysis_content').addClass('d-none');
                    //         }
                    //     }
                    // });
                } else {
                    Swal.fire('Error', 'Failed to fetch plan details', 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'Server Error', 'error');
            }
        });
    });

    $(document).off('click', '#btn_run_talent_analysis, #btn_reanalyze_talent').on('click', '#btn_run_talent_analysis, #btn_reanalyze_talent', function () {
        // The ID is stored in the button data-id
        const id = $('#btnApproveTalentPlan').data('id');
        if (!id) return;

        const btn = $(this);
        let originalText = btn.html();
        let isReAnalyze = btn.data('reanalyze') === true || btn.attr('id') === 'btn_reanalyze_talent';

        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Analyzing...');

        $.ajax({
            url: BASE_URL + 'compas/talent/analysis_ai',
            type: 'POST',
            data: { talent_id: id, re_analyze: isReAnalyze ? 'true' : 'false' },
            dataType: 'json',
            // beforeSend: function () {
            //     btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Analyzing...');
            // },
            success: function (response) {
                btn.prop('disabled', false).html(originalText);

                if (response.status === 'success') {
                    displayTalentAIAnalysis(response.data?.output || null);
                    $('#btnApproveTalentPlan').prop('disabled', false);
                } else {
                    Swal.fire('Error', response.message || 'Analysis failed', 'error');
                }
            },
            error: function () {
                btn.prop('disabled', false).html(originalText);
                Swal.fire('Error', 'Server Error', 'error');
            },
            complete: function () {
                btn.prop('disabled', false).html('<i class="bi bi-cpu me-2"></i> Run AI Analysis');
            }
        });
    });

    function displayTalentAIAnalysis(data) {
        if (!data) return;

        $('#talent_ai_analysis_empty').addClass('d-none');
        $('#talent_ai_analysis_content').removeClass('d-none');

        // 1. Score (skor_kecocokan_keseluruhan)
        let score = 0;
        let scoreReason = '';
        if (data.skor_kecocokan_keseluruhan && typeof data.skor_kecocokan_keseluruhan === 'object') {
            score = data.skor_kecocokan_keseluruhan.nilai || 0;
            scoreReason = data.skor_kecocokan_keseluruhan.alasan_skor || '';
        } else {
            score = data.skor_kecocokan_keseluruhan || 0;
        }
        $('#talent_ai_score').text(score);
        var scoreEl = document.getElementById('talent_ai_score_container');
        if (scoreEl && scoreReason) {
            scoreEl.setAttribute('data-bs-toggle', 'tooltip');
            scoreEl.setAttribute('data-bs-placement', 'top');
            scoreEl.setAttribute('title', scoreReason);
            var existingTip = bootstrap.Tooltip.getInstance(scoreEl);
            if (existingTip) existingTip.dispose();
            new bootstrap.Tooltip(scoreEl);
        }

        // 2. Final Decision
        const keputusan = data.keputusan_akhir || '-';
        const alasan = data.alasan_keputusan || '-';
        $('#talent_ai_keputusan_akhir').text(keputusan);
        $('#talent_ai_alasan_keputusan').text(alasan);

        // Decision banner color based on verdict
        const banner = document.getElementById('talent_ai_decision_banner');
        if (banner) {
            const kLow = keputusan.toLowerCase();
            if (kLow.includes('recommended') || kLow.includes('direkomendasikan') || kLow.includes('layak')) {
                banner.style.background = 'rgba(16, 185, 129, 0.15)';
                banner.style.borderColor = 'rgba(16, 185, 129, 0.4)';
                banner.querySelector('i').className = 'bi bi-patch-check-fill fs-3 text-success flex-shrink-0 mt-1';
            } else if (kLow.includes('not') || kLow.includes('tidak') || kLow.includes('rejected')) {
                banner.style.background = 'rgba(239, 68, 68, 0.15)';
                banner.style.borderColor = 'rgba(239, 68, 68, 0.4)';
                banner.querySelector('i').className = 'bi bi-x-circle-fill fs-3 text-danger flex-shrink-0 mt-1';
            } else {
                banner.style.background = 'rgba(245, 158, 11, 0.15)';
                banner.style.borderColor = 'rgba(245, 158, 11, 0.4)';
                banner.querySelector('i').className = 'bi bi-patch-question-fill fs-3 text-warning flex-shrink-0 mt-1';
            }
        }

        // 3. Executive Summary
        let execSum = '';
        const summaryList = data.ringkasan_eksekutif;
        if (Array.isArray(summaryList)) {
            summaryList.forEach(pt => execSum += `<li class="mb-1">${pt}</li>`);
        } else if (typeof summaryList === 'string') {
            execSum = `<li class="mb-1">${summaryList}</li>`;
        }
        $('#talent_ai_executive_summary').html(execSum || '<li class="text-muted fst-italic">No summary available</li>');

        // Helper: render a progress bar metric with tooltip
        const renderProgress = (label, obj, color = 'primary') => {
            let val = 0, reason = '', recs = '';
            if (typeof obj === 'object' && obj !== null) {
                val = obj.nilai || 0;
                reason = obj.alasan_skor || '';
                recs = obj.rekomendasi_perbaikan || '';
            } else {
                val = obj || 0;
            }
            const tooltip = [reason, recs].filter(Boolean).join(' | ');
            return `
            <div class="mb-2" ${tooltip ? `data-bs-toggle="tooltip" data-bs-placement="top" title="${tooltip}"` : ''}>
                <div class="d-flex justify-content-between small mb-1">
                    <span class="text-white-50">${label}</span>
                    <span class="text-${color} fw-bold">${val}%</span>
                </div>
                <div class="progress" style="height: 4px; background: rgba(255,255,255,0.1);">
                    <div class="progress-bar bg-${color}" role="progressbar" style="width: ${val}%" aria-valuenow="${val}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>`;
        };

        // 4. Fit & Alignment metrics
        let fitHtml = '';
        fitHtml += renderProgress('Event Alignment', data.kecocokan_dengan_activation, 'info');
        fitHtml += renderProgress('Content Pillar Fit', data.kecocokan_dengan_pilar_konten, 'info');
        fitHtml += renderProgress('Script & Hook Fit', data.kecocokan_dengan_script_dan_hook, 'info');
        fitHtml += renderProgress('Communication Style', data.kecocokan_gaya_komunikasi, 'info');
        fitHtml += renderProgress('Emotional Tone Fit', data.kecocokan_dengan_emotional_tone, 'info');
        $('#talent_ai_fit_alignment_stats').html(fitHtml || '<p class="text-muted small">No alignment data.</p>');

        // 5. Audience & Impact / Delivery metrics
        let audienceHtml = '';
        audienceHtml += renderProgress('Audience Match', data.kecocokan_dengan_target_audiens, 'warning');
        audienceHtml += renderProgress('Scroll-Stopping Potential', data.potensi_scroll_stopping, 'warning');
        audienceHtml += renderProgress('Credibility & Authenticity', data.kredibilitas_dan_autentisitas, 'warning');
        audienceHtml += renderProgress('Delivery & Storytelling', data.kemampuan_delivery_dan_storytelling, 'warning');
        $('#talent_ai_audience_delivery_stats').html(audienceHtml || '<p class="text-muted small">No impact data.</p>');

        // 6. Risk Analysis (analisis_risiko_talent) — dynamic key-value grid
        const riskLabels = {
            risiko_kecocokan_audiens: 'Audience Fit Risk',
            risiko_konten_tidak_natural: 'Content Naturalness Risk',
            risiko_brand_safety: 'Brand Safety Risk',
            risiko_engagement_rendah: 'Low Engagement Risk',
            risiko_overselling: 'Overselling Risk',
            risiko_reputasi: 'Reputation Risk',
            risiko_fraud: 'Fraud Risk',
        };

        let riskHtml = '';
        const riskData = data.analisis_risiko_talent || {};
        Object.keys(riskData).forEach(key => {
            const item = riskData[key];
            if (typeof item !== 'object') return;
            const val = item.nilai || 0;
            const tooltip = [item.alasan_skor, item.rekomendasi_perbaikan].filter(Boolean).join(' | ');
            const label = riskLabels[key] || key.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
            const col = val <= 30 ? 'success' : val <= 60 ? 'warning' : 'danger';
            riskHtml += `
            <div class="col-md-6">
                <div class="p-3 rounded h-100" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);"
                     ${tooltip ? `data-bs-toggle="tooltip" data-bs-placement="top" title="${tooltip}"` : ''}>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-white-50 small">${label}</span>
                        <span class="badge bg-${col} px-2">${val}%</span>
                    </div>
                    <div class="progress" style="height: 4px; background: rgba(255,255,255,0.1);">
                        <div class="progress-bar bg-${col}" style="width: ${val}%"></div>
                    </div>
                </div>
            </div>`;
        });
        $('#talent_ai_risk_grid').html(riskHtml || '<div class="col-12"><p class="text-muted small">No risk data available.</p></div>');

        // 7. Recommendations (rekomendasi_penggunaan_talent)
        const recData = data.rekomendasi_penggunaan_talent || {};
        const recLabels = {
            catatan_eksekusi: { label: 'Execution Notes', icon: 'bi-journals' },
            penempatan_konten: { label: 'Content Placement', icon: 'bi-collection-play' },
            penyesuaian_script: { label: 'Script Adjustments', icon: 'bi-file-earmark-text' },
            format_paling_cocok: { label: 'Best Formats', icon: 'bi-layout-text-sidebar' },
            alternatif_jika_tidak_cocok: { label: 'If Not a Fit', icon: 'bi-arrow-left-right' },
            gaya_penyampaian_disarankan: { label: 'Suggested Delivery Style', icon: 'bi-mic' },
        };

        let recHtml = '';
        Object.keys(recLabels).forEach(key => {
            const items = recData[key];
            if (!items) return;
            const cfg = recLabels[key];
            let list = '';
            if (Array.isArray(items)) {
                list = items.map(x => `<li class="mb-1">${x}</li>`).join('');
            } else if (typeof items === 'string') {
                list = `<li class="mb-1">${items}</li>`;
            }
            recHtml += `
            <div class="col-md-6">
                <h6 class="text-white-50 text-uppercase small fw-bold mb-2"><i class="bi ${cfg.icon} me-2"></i>${cfg.label}</h6>
                <ul class="small text-white ps-3 mb-0">${list}</ul>
            </div>`;
        });
        $('#talent_ai_recommendations_grid').html(recHtml || '<p class="text-muted small ps-2">No recommendations available.</p>');

        // Re-init tooltips inside the analysis panel
        document.querySelectorAll('#talent_ai_analysis_content [data-bs-toggle="tooltip"]').forEach(el => {
            var existing = bootstrap.Tooltip.getInstance(el);
            if (existing) existing.dispose();
            new bootstrap.Tooltip(el);
        });
    }

    // Approve Talent Logic
    $(document).off('click', '#btnApproveTalentPlan').on('click', '#btnApproveTalentPlan', function () {
        let id = $(this).data('id');
        let target = campaignData.talent_target;
        let btn = $(this);

        Swal.fire({
            title: 'Approve Talent?',
            text: "This will mark the talent as Approved.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Yes, Approve'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: BASE_URL + 'compas/talent/approve_talent',
                    type: 'POST',
                    data: { id: id, target: target },
                    dataType: 'json',
                    beforeSend: function () {
                        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Processing...');
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.status) {
                            btn.prop('disabled', false).html('<i class="bi bi-check-circle me-2"></i>Approve');
                            Swal.fire(
                                'Approved!',
                                'The talent has been approved.',
                                'success'
                            ).then(() => {
                                $('#viewTalentDetailModal').modal('hide');
                                loadTalentListTable(); // Reload table
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                            btn.prop('disabled', false).html('<i class="bi bi-check-circle me-2"></i>Approve');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Server Error', 'error');
                        btn.prop('disabled', false).html('<i class="bi bi-check-circle me-2"></i>Approve');
                    }
                });
                // updateTalentStatus(id, 'Approved');
            }
        });
    });

    // Cancel Approval Logic
    $(document).off('click', '#btnCancelApproveTalent').on('click', '#btnCancelApproveTalent', function () {
        let id = $('#btnApproveTalentPlan').data('id');
        let target = campaignData.talent_target;
        Swal.fire({
            title: 'Cancel Approval?',
            text: "This will revert the status to Waiting.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: BASE_URL + 'compas/talent/cancel_approve_talent',
                    type: 'POST',
                    data: { id: id, target: target },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status) {
                            Swal.fire('Success', 'Approval cancelled successfully', 'success');
                            $('#viewTalentDetailModal').modal('hide');
                            loadTalentListTable();
                            loadApprovedActivations();
                            loadTeamPerformance();

                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    }
                });
            }
        });
    });

    // Reject/Revise Logic
    $(document).off('click', '#btnRejectTalentPlan').on('click', '#btnRejectTalentPlan', function () {
        let id = $('#btnApproveTalentPlan').data('id');
        let target = campaignData.talent_target;
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
                    url: BASE_URL + 'compas/talent/reject_talent_plan',
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
                Swal.fire('Success', 'Talent rejected/revised successfully', 'success');
                $('#viewTalentDetailModal').modal('hide');
                loadTalentListTable();
                loadTeamPerformance();
            }
        });
    });

    // Invite Team Modal Logic
    $('#inviteTalentTeamModal').on('show.bs.modal', function () {
        loadEmployeesForInvite();
    });

    $('#btnSaveTalentTeam').on('click', function () {
        saveTalentTeam();
    });

    // Initialize tooltips helper function (Bootstrap 5 safe)
    function reinitTooltips(selector) {
        var container = typeof selector === 'string' ? document.querySelector(selector) : selector;
        if (!container) return;

        var tooltipTriggerList = [].slice.call(container.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            var existing = bootstrap.Tooltip.getInstance(tooltipTriggerEl);
            if (existing) existing.dispose();
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Initialize tooltips globally on load
    reinitTooltips(document);

    // Initialize Chosen JS
    if ($('.chosen-select').length > 0) {
        $('.chosen-select').chosen({
            width: "100%",
            placeholder_text_single: "Select an option",
            no_results_text: "Oops, nothing found!"
        });

        handleChosenData('#talent-pic', 'compas/talent/get_pics', { id: getCampaignId() }, 'pic_id', 'pic_name', 'PIC');
    }
    // Re-init Chosen when modal is shown (fix for Select width 0)
    $('#addTalentModal, #inviteTalentTeamModal').on('shown.bs.modal', function () {
        $('.chosen-select', this).chosen('destroy').chosen({
            width: "100%",
            placeholder_text_single: "Select an option",
            placeholder_text_multiple: "Choose options",
            no_results_text: "Oops, nothing found!"
        });
    });

    // Pagination Handler
    $(document).off('click', '.strategy-page-link').on('click', '.strategy-page-link', function (e) {
        e.preventDefault();
        const page = $(this).data('page');
        if (page) {
            currentIncomingPage = page;
            loadApprovedActivations(currentIncomingPage);
        }
    });

    // View Strategy Details
    $(document).off('click', '.view-strategy-btn').on('click', '.view-strategy-btn', function () {
        const id = $(this).data('id');
        viewStrategyDetail(id);
    });



    // Incoming Briefs / Strategy Logic
    function loadApprovedActivations(page = 1) {
        const campaignId = $('#detail_id').val();

        // Show skeleton/loading state
        $('#incoming-briefs-container-talent').html(`
        <div class="d-flex align-items-center justify-content-center p-4">
            <div class="spinner-border text-purple" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `);

        $.ajax({
            url: BASE_URL + 'compas/talent/get_approved_contents', // Using compas/content endpoint as briefs are shared
            type: 'GET',
            data: { campaign_id: campaignId, page: page },
            dataType: 'json',
            success: function (response) {
                if (response.status && response.data.length > 0) {
                    let html = '';
                    response.data.forEach(function (item) {
                        html += `
                        <div class="card border-0 rounded-3 shadow-sm mb-2">
                            <div class="card-body p-3 d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="icon-box-purple flex-shrink-0">
                                        <i class="bi bi-file-earmark-text fs-4"></i>
                                    </div>
                                   <div>
                                        <h6 class="fw-bold text-dark mb-2">${item.content_title}</h6>
                                        <div class="d-flex gap-2">
                                            <span class="badge bg-light-purple text-purple border-purple">${item.platform_name || 'N/A'}</span>
                                            <span class="badge bg-light-purple text-purple border-purple">${item.placement_name || 'N/A'}</span>
                                            <span class="badge bg-light-purple text-purple border-purple">${item.content_pillar_name || 'N/A'}</span>
                                            <small class="text-secondary opacity-75">${item.deadline_publish_formatted || ''}</small>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-outline-purple rounded-3 px-3 view-strategy-btn" data-id="${item.content_id}">View Details</button>
                            </div>
                        </div>
                    `;
                    });

                    // Add Pagination
                    if (response.pagination.total_pages > 1) {
                        html += `<div class="d-flex justify-content-end mt-2">
                                <nav aria-label="Strategy pagination">
                                    <ul class="pagination pagination-sm mb-0">`;

                        const prevDisabled = response.pagination.current_page == 1 ? 'disabled' : '';
                        html += `<li class="page-item ${prevDisabled}">
                                <a class="page-link strategy-page-link" href="#" data-page="${response.pagination.current_page - 1}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>`;

                        for (let i = 1; i <= response.pagination.total_pages; i++) {
                            const active = i == response.pagination.current_page ? 'active' : '';
                            html += `<li class="page-item ${active}"><a class="page-link strategy-page-link" href="#" data-page="${i}">${i}</a></li>`;
                        }

                        const nextDisabled = response.pagination.current_page == response.pagination.total_pages ? 'disabled' : '';
                        html += `<li class="page-item ${nextDisabled}">
                                <a class="page-link strategy-page-link" href="#" data-page="${response.pagination.current_page + 1}" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>`;

                        html += `   </ul>
                                </nav>
                            </div>`;
                    }

                    $('#incoming-briefs-container-talent').html(html);
                } else {
                    $('#incoming-briefs-container-talent').html('<p class="text-muted text-center small my-3">No approved strategies found for this campaign.</p>');
                }
            },
            error: function (xhr, status, error) {
                $('#incoming-briefs-container-talent').html('<p class="text-danger text-center small my-3">Failed to load strategies.</p>');
            }
        });
    }

    // Copied viewStrategyDetail from previous implementation
    function viewStrategyDetail(id) {
        var modal = new bootstrap.Modal(document.getElementById('strategyTalentDetailModal'));
        modal.show();

        $('#strategyTalentDetailContent').html(`
        <div class="text-center py-5">
            <div class="spinner-border text-purple" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-purple small">Loading details...</p>
        </div>
    `);

        $.ajax({
            url: BASE_URL + 'compas/talent/get_content_detail',
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    const data = response.data;
                    const camp = data.campaign;
                    const cont = data.content;

                    // check platform_name if there is comma then explode and create ordered list
                    if (cont.platform_name.includes(',')) {
                        const platform_name = cont.platform_name.split(',');
                        let platform_name_html = '<ol>';
                        platform_name.forEach(function (item) {
                            platform_name_html += `<li class="text-dark mb-0 text-justify fs-14">${item}</li>`;
                        });
                        platform_name_html += '</ol>';
                        cont.platform_name = platform_name_html;
                    }

                    const html = `
                                <p class="title fw-medium">Campaign Info</p>
                                <div class="row">
                                    <div class="col-8">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Campaign Name</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${camp.campaign_name || '-'}</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Periode Campaign</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${camp.campaign_period || '-'}</p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Campaign Description</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${camp.campaign_desc || '-'}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Target Audience</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${camp.target_audience || '-'}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Key Message</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${camp.key_message || '-'}</p>
                                        </div>
                                    </div>
                                    </div>

                                    <p class="title fw-medium">Event Activation</p>
                                    <div class="row">
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Strategy Title</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.activation_title || '-'}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Strategy Description</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.activation_description || '-'}</p>
                                        </div>
                                    </div>
                                </div>

                                <p class="title fw-medium">Content</p>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Content Title</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.title || '-'}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Content Pillar</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.content_pillar_name || '-'}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Content Hook</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.hook || '-'}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Content Format</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.format_name || '-'}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Deadline Publish</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.deadline_publish_formatted || '-'}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Pain Point</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.pain_point || '-'}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Trigger Emotion</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.trigger_emotion || '-'}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Consumption Behavior</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.consumption_behavior || '-'}</p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Script Content</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.script_content || '-'}</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                    $('#strategyTalentDetailContent').html(html);
                } else {
                    $('#strategyTalentDetailContent').html('<div class="alert alert-danger border-0 shadow-sm text-center">Failed to load details.</div>');
                }
            },
            error: function () {
                $('#strategyTalentDetailContent').html('<div class="alert alert-danger border-0 shadow-sm text-center">Error communicating with server.</div>');
            }
        });
    }

    function loadTalentTeam() {
        const campaignId = $('#detail_id').val();
        $.ajax({
            url: BASE_URL + 'compas/talent/get_talent_team',
            type: 'GET',
            data: { campaign_id: campaignId },
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    const team = response.data;
                    let html = '';
                    if (team.profile_picture_team) {
                        const pics = team.profile_picture_team;
                        if(team.team_name !== null){
                            if (team.team_name.includes(',')) {
                                const names = team.team_name.split(',');
                            } else {
                                const names = team.team_name;
                            }
                        }else{
                            const names = [];
                        }
                        pics.forEach((pic, index) => {
                            let src = pic.indexOf('http') === -1 ? BASE_URL + 'uploads/users/' + pic : pic;
                            html += `
                            <figure class="avatar avatar-40 rounded-circle coverimg overlay-ms-15" data-bs-toggle="tooltip" data-bs-placement="top" title="${names[index]}" style="background-image: url('${src}');">
                                <img src="${src}" alt="">
                            </figure>
                            `;
                        });

                        html += `<div class="ms-2 col">
                                <p class="text-secondary small mb-0">${team.more_users} more</p>
                                <p class="small">Working</p>
                            </div>`;
                        $('#avatar-talent-team').html(html);

                        // Re-init tooltips
                        var tooltipTriggerList = [].slice.call(document.querySelectorAll('#avatar-talent-team [data-bs-toggle="tooltip"]'));
                        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                            return new bootstrap.Tooltip(tooltipTriggerEl);
                        });
                    }
                }
            }
        });
    }
    function loadEmployeesForInvite() {
        const campaignId = $('#detail_id').val();
        $.ajax({
            url: BASE_URL + 'compas/talent/get_talent_team',
            type: 'GET',
            data: { campaign_id: campaignId },
            dataType: 'json',
            success: function (teamResponse) {
                let currentTeamIds = [];
                if (teamResponse.status && teamResponse.data && teamResponse.data.talent_team) {
                    currentTeamIds = teamResponse.data.talent_team.split(',');
                }

                $.ajax({
                    url: BASE_URL + 'compas/talent/get_employees',
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status) {
                            let options = '';
                            response.data.forEach(user => {
                                const selected = currentTeamIds.includes(user.user_id) ? 'selected' : '';
                                options += `<option value="${user.user_id}" ${selected}>${user.full_name}</option>`;
                            });
                            $('#invite_talent_team_select').html(options);
                            $('#invite_talent_team_select').trigger('chosen:updated');
                        }
                    }
                });
            }
        });
    }

    function saveTalentTeam() {
        const campaignId = $('#detail_id').val();
        const selectedTeam = $('#invite_talent_team_select').val();

        $.ajax({
            url: BASE_URL + 'compas/talent/save_talent_team',
            type: 'POST',
            data: {
                campaign_id: campaignId,
                team: selectedTeam
            },
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    const modalEl = document.getElementById('inviteTalentTeamModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    modal.hide();
                    loadTalentTeam();
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'Server Error', 'error');
            }
        });
    }



    $('#btnSaveTalent').on('click', function () {
        saveTalent();
    });

    // Surprise Me Logic for Talent – AI powered
    $(document).off('click', '#btnSurpriseMeTalent').on('click', '#btnSurpriseMeTalent', function () {
        const $btn = $(this);
        const campaignId = getCampaignId() || $('#detail_id').val() || '';
        const contentId = $('#talent_content_id').val() || '';
        const userPrompt = '';

        // Loading state
        const originalHtml = $btn.html();
        $btn.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Generating...'
        );

        const formData = new FormData();
        formData.append('campaign_id', campaignId);
        formData.append('content_id', contentId);
        formData.append('user_prompt', userPrompt);

        fetch(`${BASE_URL}compas/talent/generate_ai_talent`, {
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

                // ── Text Inputs ───────────────────────────────────────────────────
                if (d.talent_name) $('#talent_name').val(d.talent_name);
                if (d.content_niche) $('#talent_niche').val(d.content_niche);
                if (d.communication_style) $('#talent_communication_style').val(d.communication_style);
                if (d.username_tiktok) $('#talent_tiktok').val(d.username_tiktok);
                if (d.username_ig) $('#talent_ig').val(d.username_ig);

                // ── Rate (formatted) ──────────────────────────────────────────────
                if (d.rate) {
                    $('#talent_rate').val(formatRibuan(d.rate));
                }

                // ── Persona OverType ──────────────────────────────────────────────
                if (d.persona) {
                    $('#talent_persona').val(d.persona);
                    try {
                        if (talent_persona_editor && typeof talent_persona_editor.setValue === 'function') {
                            talent_persona_editor.setValue(d.persona);
                        }
                    } catch (e) { console.warn('OverType setValue failed', e); }
                }

                // ── PIC Multi-select ──────────────────────────────────────────────
                if (d.pic_ids && Array.isArray(d.pic_ids) && d.pic_ids.length > 0) {
                    $('#talent_pic').val(d.pic_ids.map(String)).trigger('chosen:updated');
                } else {
                    // Fallback: random pick
                    const picOptions = $('#talent_pic option').map(function () { return $(this).val(); }).get().filter(v => v !== '');
                    if (picOptions.length > 0) {
                        const count = Math.floor(Math.random() * Math.min(3, picOptions.length)) + 1;
                        const selected = [...new Set(picOptions.sort(() => 0.5 - Math.random()).slice(0, count))];
                        $('#talent_pic').val(selected).trigger('chosen:updated');
                    }
                }

                // ── Success Toast ─────────────────────────────────────────────────
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
                console.error('generate_ai_talent error:', err);
                Swal.fire('Error', 'Terjadi kesalahan saat menghubungi AI. Silakan coba lagi.', 'error');
            })
            .finally(() => {
                $btn.prop('disabled', false).html(originalHtml);
            });
    });

    // Fetch and display content info when an content is selected
    $(document).off('change', '#talent_content_id').on('change', '#talent_content_id', function () {
        const contentId = $(this).val();
        const infoCard = $('#talent_content_info');

        if (!contentId) {
            infoCard.addClass('d-none');
            return;
        }

        // Show a loading state
        $('#info-content-script').text('Loading...');
        $('#info-content-storyboard').text('Loading...');
        infoCard.removeClass('d-none');

        fetch(`${BASE_URL}compas/talent/get_content_detail?id=${contentId}`, {
            method: 'GET',
        })
            .then(res => res.json())
            .then(result => {
                console.log(result);

                if (result.status && result.data) {
                    const data = result.data;
                    $('#info-content-script').text(data.content.script_content || '-');
                    $('#info-content-storyboard').text(data.content.storyboard || '-');
                } else {
                    infoCard.addClass('d-none');
                }
            })
            .catch(err => {
                console.error('Failed to fetch content detail:', err);
                infoCard.addClass('d-none');
            });
    });



    function saveTalent() {
        // Sync OverType Editors explicitly to be safe
        if (typeof talent_persona_editor !== 'undefined' && talent_persona_editor.getData) {
            $('#talent_persona').val(talent_persona_editor.getData());
        }

        // Validate Form
        if (!$('#formAddTalent')[0].checkValidity()) {
            $('#formAddTalent')[0].reportValidity();
            return;
        }

        // Validate Chosen Steps (PIC)
        if ($('#talent_pic').val().length === 0) {
            Swal.fire('Warning', 'Please select at least one PIC.', 'warning');
            return;
        }

        const campaignId = getCampaignId();
        const formData = $('#formAddTalent').serialize() + '&campaign_id=' + encodeURIComponent(campaignId);

        $.ajax({
            url: BASE_URL + 'compas/talent/save_talent',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        $('#addTalentModal').modal('hide');
                        $('#formAddTalent')[0].reset();
                        $('#formAddTalent').find('input[type="text"], input[type="number"], input[type="email"], input[type="url"], textarea, select').val('');
                        loadTalentListTable();

                    });
                } else {
                    Swal.fire('Error', response.message || 'Failed to save talent', 'error');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire('Error', 'Server Error: ' + error, 'error');
            }
        });
    }

    // Helper for currency format (global scope)
    window.formatRupiah = function (element) {
        let value = element.value.replace(/[^,\d]/g, '').toString();
        let split = value.split(',');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        element.value = rupiah;
    }

    // ─── Helpers ─────────────────────────────────────────────
    /**
     * Load content options for the talent-form content picker
     */
    function loadContentsForTalentForm(campaignId) {
        $.ajax({
            url: BASE_URL + 'compas/talent/get_contents_for_talent',
            type: 'GET',
            data: { campaign_id: campaignId },
            dataType: 'json',
            success: function (res) {
                const $sel = $('#talent_content_id');
                $sel.empty().append('<option value=""></option>');
                if (res.status && res.data.length > 0) {
                    res.data.forEach(function (c) {
                        const label = (c.title || 'Untitled') + (c.format ? ' [' + c.format + ']' : '') + (c.platform ? ' — ' + c.platform : '');
                        $sel.append($('<option>', { value: c.content_id, text: label }));
                    });
                } else {
                    $sel.append('<option value="" disabled>No contents found for this campaign</option>');
                }
                $sel.trigger('chosen:updated').trigger('change');
            }
        });
    }

    /**
     * Load master talents into the existing talent picker
     */
    function loadMasterTalentsForForm() {
        $.ajax({
            url: BASE_URL + 'compas/talent/get_master_talents',
            type: 'GET',
            dataType: 'json',
            success: function (res) {
                const $sel = $('#talent_existing_select');
                $sel.empty().append('<option value=""></option>');
                if (res.status && res.data.length > 0) {
                    res.data.forEach(function (t) {
                        const label = t.talent_name + (t.content_niche ? ' — ' + t.content_niche : '') + (t.username_tiktok ? ' (' + t.username_tiktok + ')' : '');
                        $sel.append($('<option>', {
                            value: t.talent_id,
                            text: label,
                            'data-talent': JSON.stringify(t)
                        }));
                    });
                }
                $sel.trigger('chosen:updated');
            }
        });
    }

    // ─── Talent Mode Toggle ──────────────────────────────────────
    $(document).off('change', 'input[name="talent_mode"]').on('change', 'input[name="talent_mode"]', function () {
        const mode = $(this).val();
        if (mode === 'existing') {
            $('#existing_talent_search_row').show();
            $('#btnSurpriseMeTalent').hide();
        } else {
            $('#existing_talent_search_row').hide();
            $('#btnSurpriseMeTalent').show();
            // Clear master id
            $('#talent_master_id').val('');
        }
    });

    // ─── Existing Talent Select Handler ──────────────────────────
    $(document).off('change', '#talent_existing_select').on('change', '#talent_existing_select', function () {
        const selected = $(this).find('option:selected');
        if (!selected.val()) {
            $('#talent_master_id').val('');
            return;
        }
        let talentData;
        try {
            talentData = JSON.parse(selected.attr('data-talent'));
        } catch (e) { return; }

        // Store master id
        $('#talent_master_id').val(talentData.talent_id);

        // Autofill fields
        $('#talent_name').val(talentData.talent_name || '');
        $('#talent_niche').val(talentData.content_niche || '');
        $('#talent_tiktok').val(talentData.username_tiktok || '');
        $('#talent_ig').val(talentData.username_ig || '');
        $('#talent_communication_style').val(talentData.communication_style || '');

        // Rate formatted
        if (talentData.rate) {
            const fakeInput = { value: String(talentData.rate) };
            formatRupiah(fakeInput);
            $('#talent_rate').val(fakeInput.value);
        }

        // Persona
        const persona = talentData.persona || '';
        $('#talent_persona').val(persona);
        try {
            if (talent_persona_editor && talent_persona_editor.setValue) talent_persona_editor.setValue(persona);
        } catch (e) { }
    });

    // ─── Add Talent Button ────────────────────────────────────────
    $('#btnAddTalent').on('click', function () {
        const campaignId = getCampaignId();

        // Reset form
        $('#formAddTalent')[0].reset();
        $('#talent_id').val('');
        $('#talent_master_id').val('');
        $('#talent_campaign_id').val(campaignId);  // ← set campaign_id hidden field
        $('#talent-modal-title').text('Add Talent');
        $('#btnSaveTalent').html('Save Talent');

        // Reset mode to "new"
        $('#talent_mode_new').prop('checked', true);
        $('#existing_talent_search_row').hide();
        $('#btnSurpriseMeTalent').show();

        // Reset Chosen
        $('#talent_pic').val('').trigger('chosen:updated');
        $('#talent_content_id').empty().append('<option value=""></option>').trigger('chosen:updated').trigger('change');
        $('#talent_existing_select').empty().append('<option value=""></option>').trigger('chosen:updated');

        // Populate PIC options
        handleChosenData('#talent_pic', 'compas/talent/get_pics', { id: campaignId }, 'pic_id', 'pic_name', 'PIC');

        // Load content list for this campaign
        loadContentsForTalentForm(campaignId);

        // Load master talent list
        loadMasterTalentsForForm();

        // Reset OverType
        try {
            if (talent_persona_editor && talent_persona_editor.setValue) talent_persona_editor.setValue('');
        } catch (e) {
            console.log('OverType reset failed', e);
        }
    });


    // ─── Edit Talent Logic ─────────────────────────────────────
    $(document).off('click', '.btn-edit-talent').on('click', '.btn-edit-talent', function () {
        let id = $(this).data('id');
        const campaignId = getCampaignId();

        $.ajax({
            url: BASE_URL + 'compas/talent/get_talent_detail?talent_id=' + id,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    let data = response.data;

                    $('#talent-modal-title').text('Edit Talent');
                    $('#btnSaveTalent').html('Update Talent');

                    $('#talent_id').val(data.talent_id);
                    $('#talent_campaign_id').val(data.campaign_id);
                    $('#talent_master_id').val('');

                    $('#talent_name').val(data.talent_name);
                    $('#talent_rate').val(formatRibuan(data.rate));
                    $('#talent_tiktok').val(data.username_tiktok);
                    $('#talent_ig').val(data.username_ig);
                    $('#talent_niche').val(data.content_niche);
                    $('#talent_communication_style').val(data.communication_style);

                    // Reset mode to "new" (edit always shows full form)
                    $('#talent_mode_new').prop('checked', true);
                    $('#existing_talent_search_row').hide();
                    $('#btnSurpriseMeTalent').show();

                    // Populate and select content
                    loadContentsForTalentForm(campaignId);
                    if (data.content_id) {
                        // Wait for contents to load then select
                        setTimeout(function () {
                            $('#talent_content_id').val(data.content_id).trigger('chosen:updated').trigger('change');
                        }, 500);
                    }

                    // PIC Multi-Select
                    let pics = [];
                    if (data.pic) {
                        pics = data.pic.toString().split(',').filter(p => p.trim() !== '');
                    }
                    handleChosenData('#talent_pic', 'compas/talent/get_pics', { id: campaignId }, 'pic_id', 'pic_name', 'PIC', pics);

                    if (data.status) {
                        $('#talent_status').val(data.status).trigger('chosen:updated');
                    }

                    // OverType
                    const persona = data.persona || '';
                    if (talent_persona_editor) talent_persona_editor.setValue(persona);
                    $('#talent_persona').val(persona);

                    // Show Modal
                    $('#addTalentModal').modal('show');
                } else {
                    Swal.fire('Error', 'Could not fetch talent data', 'error');
                }
            }
        });
    });


    // Delete Talent
    $(document).off('click', '.btn-delete-talent').on('click', '.btn-delete-talent', function () {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Delete Talent?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: BASE_URL + 'compas/talent/delete_talent',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status) {
                            Swal.fire('Deleted!', 'Talent has been deleted.', 'success');
                            loadTalentListTable();
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Server Error', 'error');
                    }
                });
            }
        });
    });

    function loadTalentLogs() {
        let campaign_id = $('#detail_id').val();
        if (!campaign_id) return;

        $.ajax({
            url: BASE_URL + 'compas/talent/get_talent_logs',
            type: 'GET',
            data: { campaign_id: campaign_id },
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    let logsHtml = '';
                    if (response.data.length > 0) {
                        response.data.forEach(log => {
                            let color = 'primary';
                            if (log.action_type === 'STATUS_CHANGE') color = 'info';
                            else if (log.action_type === 'CREATED') color = 'success';
                            else if (log.action_type === 'UPDATED') color = 'warning';

                            logsHtml += `
                            <div class="position-relative ps-4 mb-3">
                                <div class="position-absolute top-0 start-0 translate-middle-x bg-${color} rounded-circle border border-white"
                                    style="width: 12px; height: 12px; margin-top: 6px; margin-left: -1px;"></div>
                                <p class="mb-1 small text-dark"><span class="fw-bold">${log.user_name}</span> ${log.description}</p>
                                <span class="text-muted small" style="font-size: 11px;">${log.time_ago}</span>
                            </div>`;
                        });
                        $('.activity-timeline').html(logsHtml);
                    } else {
                        $('.activity-timeline').html('<p class="text-muted small fst-italic ps-3">No activity yet.</p>');
                    }
                }
            }
        });
    }

    function initComments() {
        if ($('#comments-container-talent').length > 0) {
            $('#comments-container-talent').comments({
                profile_picture_url: typeof CURRENT_USER_PROFILE_URL !== 'undefined' ? CURRENT_USER_PROFILE_URL : '',
                current_user_id: typeof CURRENT_USER_ID !== 'undefined' ? CURRENT_USER_ID : 1,
                user_has_upvoted: false,
                enableAttachments: true,
                enableHashtags: true,
                enablePinging: true,

                getComments: function (success, error) {
                    $.ajax({
                        type: 'GET',
                        url: BASE_URL + 'compas/talent/get_comments',
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
                        url: BASE_URL + 'compas/talent/post_comment',
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
                        url: BASE_URL + 'compas/talent/put_comment',
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
                        url: BASE_URL + 'compas/talent/upvote_comment',
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
                                url: BASE_URL + 'compas/talent/delete_comment',
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
                        url: BASE_URL + 'compas/talent/get_users_for_comments',
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

};