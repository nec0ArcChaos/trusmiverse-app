window.LoadInit = window.LoadInit || {};
window.LoadInit['tabs'] = window.LoadInit['tabs'] || {};
window.LoadInit['tabs']['content'] = function (container) {
    if (typeof campaignData !== 'undefined' && campaignData.campaign_status == 4) {
        $('.action-restricted').addClass('d-none');
    } else {
        $('.action-restricted').removeClass('d-none');
    }
    loadCampaignData();

    function formatRibuan(number) {
        if (number == 0) {
            return "0";
        }
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
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

    // Initialize OverType for Script Content
    [script_content_editor] = new OverType('#content_plan_script_content', {
        theme: editorTheme,
        toolbar: true,
        placeholder: 'Write script content...',
        value: '',
        onChange: (value, instance) => {
            $('#content_plan_script_content_val').val(value);
        }
    });

    // Initialize OverType for Storyboard
    [storyboard_editor] = new OverType('#content_plan_storyboard', {
        theme: editorTheme,
        toolbar: true,
        placeholder: 'Draw/Write storyboard...',
        value: '',
        onChange: (value, instance) => {
            $('#content_plan_storyboard_val').val(value);
        }
    });

    [talent_persona_editor] = new OverType('#content_overtype_talent_persona', {
        theme: editorTheme,
        toolbar: true,
        placeholder: 'Enter Talent Persona...',
        value: '',
        onChange: (value) => { $('#content_plan_talent_persona').val(value); }
    });

    [pain_point_editor] = new OverType('#content_overtype_pain_point', {
        theme: editorTheme,
        toolbar: true,
        placeholder: 'Enter Pain Point...',
        value: '',
        onChange: (value) => { $('#content_plan_pain_point').val(value); }
    });

    [trigger_emotion_editor] = new OverType('#content_overtype_trigger_emotion', {
        theme: editorTheme,
        toolbar: true,
        placeholder: 'Enter Trigger Emotion...',
        value: '',
        onChange: (value) => { $('#content_plan_trigger_emotion').val(value); }
    });

    [consumption_behavior_editor] = new OverType('#content_overtype_consumption_behavior', {
        theme: editorTheme,
        toolbar: true,
        placeholder: 'Enter Consumption Behavior...',
        value: '',
        onChange: (value) => { $('#content_plan_consumption_behavior').val(value); }
    });

    [hook_editor] = new OverType('#content_overtype_hook', {
        theme: editorTheme,
        toolbar: true,
        placeholder: 'Enter Hook...',
        value: '',
        onChange: (value) => { $('#content_plan_hook').val(value); }
    });

    [audio_notes_editor] = new OverType('#content_overtype_audio_notes', {
        theme: editorTheme,
        toolbar: true,
        placeholder: 'Enter Audio Notes...',
        value: '',
        onChange: (value) => { $('#content_plan_audio_notes').val(value); }
    });

    [reference_link_editor] = new OverType('#content_overtype_reference_link', {
        theme: editorTheme,
        toolbar: true,
        placeholder: 'Enter Reference Link...',
        value: '',
        onChange: (value) => { $('#content_plan_reference_link').val(value); }
    });


    /**
     * Content Tab Javascript
     */
    let currentIncomingPage = 1;


    // Load Approved Activations / Strategy
    loadApprovedActivations();

    // Load Content Team
    loadContentTeam();

    // Load Content Plan Table
    loadContentPlanTable();

    // Load Content Log
    loadContentLogs();

    // Load Team Performance
    loadTeamPerformance();

    // Init Comments
    initComments();

    function loadTeamPerformance() {
        let campaignId = $('#detail_id').val();
        $.ajax({
            url: BASE_URL + 'compas/content/get_team_performance_stats',
            type: 'GET',
            data: { campaign_id: campaignId },
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    $('#team_efficiency_content').text(response.data.efficiency + '%');
                    $('#team_done_content').text(response.data.total_approved + '/' + response.data.target);
                }
            }
        });
    }

    function loadContentPlanTable() {
        $('#dt_content_plan').DataTable({
            "processing": true,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "serverSide": false,
            "ajax": {
                "url": BASE_URL + "compas/content/get_content_plan",
                "type": "POST",
                "data": function (d) {
                    d.campaign_id = $('#detail_id').val();
                }
            },
            "columns": [
                {
                    "data": "title",
                    "render": function (data, type, row) {
                        return `
                        <div class="d-flex flex-column">
                            <span class="fs-14 text-dark title mb-2 pb-0 mt-0 pt-0">${data}</span>
                            <span class="fs-14 text-dark">${row.format_name || row.format || '-'} | ${row.publish_date_fmt || row.deadline_publish || '-'}</span>
                        </div>`;
                    }
                },
                {
                    "data": "team_name",
                    "render": function (data, type, row) {
                        if (!row.profile_picture_team) return '-';
                        let pics = row.profile_picture_team; // It is already an array from backend
                        let names = row.team_name ? row.team_name.split(',') : [];

                        let html = '<div class="avatar-group">';

                        pics.forEach((pic, index) => {
                            let name = names[index] || 'User';
                            html += `
                            <div class="avatar avatar-30 rounded-circle border border-white" 
                                 style="width:30px; height:30px;" 
                                 data-bs-toggle="tooltip" 
                                 title="${name}">
                                <img src="${pic}" class="rounded-circle w-100 h-100" alt="${name}">
                            </div>`;
                        });

                        // Use server-provided more_users count
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
                    "data": "content_id",
                    "className": "text-end pe-4",
                    "orderable": false,
                    "render": function (data, type, row) {
                        // jika sudah approve tidak bisa edit dan delete
                        let editBtn = '';
                        let deleteBtn = '';
                        if (row.sub_status_name.toLowerCase() !== 'approved') {
                            editBtn = `<button class="btn btn-sm btn-link text-success shadow-none btn-content-edit-plan" data-id="${row.content_id}" data-bs-toggle="tooltip" title="Edit Plan">
                                <i class="bi bi-pencil-square"></i>
                            </button>`;
                            deleteBtn = `<button class="btn btn-sm btn-link text-danger shadow-none btn-content-delete-plan" data-id="${row.content_id}" data-bs-toggle="tooltip" title="Delete Plan">
                                <i class="bi bi-trash"></i>
                            </button>`;
                        }
                        return `
                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn btn-sm btn-link text-muted shadow-none btn-content-view-plan" data-id="${row.content_id}" data-bs-toggle="tooltip" title="View Detail">
                                <i class="bi bi-eye"></i>
                            </button>
                            ${editBtn}
                        </div>`;
                    }
                }
            ],
            "language": {
                "emptyTable": "No content plans found",
                "zeroRecords": "No matching records found"
            },
            "dom": 't', // Only show table, no search/paging controls unless needed
            "paging": false,
            "info": false
        });

        // Initialize tooltips after draw
        $('#dt_content_plan').on('draw.dt', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('#dt_content_plan [data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    }

    // View Plan Detail Logic
    $(document).off('click', '.btn-content-view-plan').on('click', '.btn-content-view-plan', function () {
        let id = $(this).data('id');

        // Reset Modal
        $('#content_ai_analysis_empty').removeClass('d-none');
        $('#content_ai_analysis_content').addClass('d-none');
        $('#view_content_plan_assigned .avatar-group').empty();
        $('#btnApproveContentPlan').prop('disabled', true).data('id', id).html('<i class="bi bi-check-circle me-2"></i>Approve Plan');


        // Reset/Dummy loader
        $('#view_content_plan_id').text('Loading...');

        $.ajax({
            url: BASE_URL + 'compas/content/get_content_detail?content_id=' + id,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    let data = response.data;

                    // Populate basic fields
                    $('#view_content_plan_id').text('#TASK-' + id);
                    $('#view_content_plan_category').text(data.activation_title || 'Content Content');
                    $('#view_content_plan_duedate').text(data.deadline_publish_formatted || '-');
                    $('#view_content_plan_activation_desc').text(data.activation_description || 'No description available.');

                    // Priority Badge
                    let statusName = data.sub_status_name ? data.sub_status_name.toUpperCase() : 'PENDING';
                    let badgeClass = 'bg-warning-soft text-warning';
                    if (statusName.includes('HIGH') || statusName.includes('URGENT')) badgeClass = 'bg-danger-soft text-danger';
                    else if (statusName.includes('LOW') || statusName.includes('DONE')) badgeClass = 'bg-success-soft text-success';
                    else if (statusName.includes('APPROVED')) badgeClass = 'bg-success-soft text-success';


                    $('#view_content_plan_priority').attr('class', `badge ${badgeClass} px-3 rounded-pill`).text(statusName);

                    // Additional Details
                    // Additional Details - General
                    $('#view_content_plan_title').text(data.title || '-');
                    $('#view_content_plan_status').text(data.sub_status_name || '-');
                    $('#view_content_plan_publish_date').text(data.publish_date || '-');
                    $('#view_content_plan_deadline').text(data.deadline_publish_formatted || '-');

                    // Platform & Spec
                    $('#view_content_plan_platform').text(data.platform_name || '-'); // Using looked up names if available, or data.platform
                    $('#view_content_plan_placement').text(data.placement_name || '-');
                    $('#view_content_plan_format').text(data.format_name || '-'); // Assuming backend joins or returns readable names
                    $('#view_content_plan_content_pillar').text(data.content_pillar_name || '-');

                    // Talent & Details
                    $('#view_content_plan_talent_type').text(data.talent_type_name || data.talent_type || '-');
                    $('#view_content_plan_talent_cost').text(data.talent_cost ? formatRibuan(data.talent_cost) : '-');
                    $('#view_content_plan_duration').text(data.duration_desc || '-');
                    $('#view_content_plan_talent_persona').html(data.talent_persona || '-'); // Use .html() to render potential rich text or newlines

                    // Content Strategy
                    $('#view_content_plan_pain_point').html(data.pain_point || '-');
                    $('#view_content_plan_trigger_emotion').html(data.trigger_emotion || '-');
                    $('#view_content_plan_consumption_behavior').html(data.consumption_behavior || '-');
                    $('#view_content_plan_hook').html(data.hook || '-');

                    // Creative Assets
                    $('#view_content_plan_script_content').html(data.script_content || '-');
                    $('#view_content_plan_storyboard').html(data.storyboard || '-');
                    $('#view_content_plan_audio_notes').html(data.audio_notes || '-');
                    $('#view_content_plan_reference_link').html(data.reference_link ? `<a href="${data.reference_link}" target="_blank">${data.reference_link}</a>` : '-');

                    // Populate Assigned Team
                    if (data.profile_picture_team.length > 0) {
                        let pics = data.profile_picture_team;
                        let names = data.team_name ? data.team_name.split(',') : [];
                        let html = '';

                        pics.forEach((pic, index) => {
                            let name = names[index] || 'User';
                            let src = pic;
                            if (pic.indexOf('http') === -1) src = `${BASE_URL}uploads/users/${pic}`;

                            html += `<div class="col-auto me-2 mb-2 badge bg-light text-dark rounded-pill d-flex align-items-center gap-2">
                            <div class="avatar avatar-30 rounded-circle border border-white" data-bs-toggle="tooltip" title="${name}">
                                <img src="${src}" class="rounded-circle w-100 h-100" alt="${name}">
                            </div> <span class="me-2">${name}</span></div>`;
                        });

                        $('#view_content_plan_assigned .avatar-group').html(html);
                        // Re-init tooltips inside modal
                        reinitTooltips('#view_content_plan_assigned');
                    } else {
                        $('#view_content_plan_assigned .avatar-group').html('<span class="text-muted small">Unassigned</span>');
                    }

                    // Populate Activity Log
                    if (response.logs && response.logs.length > 0) {
                        let logsHtml = '';
                        response.logs.forEach(log => {
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
                        $('.timeline-sm').html(logsHtml);
                    } else {
                        $('.timeline-sm').html('<p class="text-muted small fst-italic ps-3">No activity yet.</p>');
                    }

                    // Button Visibility Logic
                    $('#btnCancelApproveContent').addClass('d-none');
                    $('#btnRejectContentPlan').removeClass('d-none');
                    $('#btnApproveContentPlan').removeClass('d-none').prop('disabled', false).html('<i class="bi bi-check-circle me-2"></i>Approve Plan');

                    // Check if already approved (status == 3)
                    if (data.status == 3) {
                        $('#btnApproveContentPlan').addClass('d-none');
                        $('#btnRejectContentPlan').addClass('d-none');
                        $('#btnCancelApproveContent').removeClass('d-none');
                    } else {
                        // Pending / Draft
                        $('#btnApproveContentPlan').prop('disabled', true); // Can approve anytime? Or need logic?
                    }

                    // Show Modal
                    $('#viewContentPlanModal').modal('show');
                    if (response.analysis) {
                        displayAIAnalysis(response.analysis?.output || null);
                        $('#btnApproveContentPlan').prop('disabled', false);
                    } else {
                        $('#content_ai_analysis_empty').removeClass('d-none');
                        $('#content_ai_analysis_content').addClass('d-none');
                        $('#btnApproveContentPlan').prop('disabled', true);
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

    // AI Analysis Logic
    $(document).off('click', '#btn_run_content_analysis, #btn_reanalyze_content').on('click', '#btn_run_content_analysis, #btn_reanalyze_content', function () {
        const id = $('#btnApproveContentPlan').data('id');
        const btn = $(this);
        let originalText = btn.html();
        let isReAnalyze = btn.data('reanalyze') === true || btn.attr('id') === 'btn_reanalyze_content';

        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Analyzing...');

        $.ajax({
            url: BASE_URL + 'compas/content/analysis_ai',
            type: 'POST',
            data: { content_id: id, re_analyze: isReAnalyze },
            dataType: 'json',
            // beforeSend: function () {
            //     btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Analyzing...');
            // },
            success: function (response) {
                btn.prop('disabled', false).html(originalText);

                if (response.status === 'success') {
                    displayAIAnalysis(response.data?.output || null);
                    $('#btnApproveContentPlan').prop('disabled', false);
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'Server Error', 'error');
            },
            complete: function () {
                btn.prop('disabled', false).html('<i class="bi bi-cpu me-2"></i> Run AI Analysis');
            }
        });
    });

    function displayAIAnalysis(data) {
        if (!data) return;

        $('#content_ai_analysis_empty').addClass('d-none');
        $('#content_ai_analysis_content').removeClass('d-none');
        // console.log(data);


        // Check for New Data Structure (based on user request)
        if (data.skor_keseluruhan !== undefined || data.ringkasan_eksekutif !== undefined) {
            // Overall Score
            let overallScore = 0;
            let overallReason = '';
            if (typeof data.skor_keseluruhan === 'object') {
                overallScore = data.skor_keseluruhan.nilai || 0;
                overallReason = data.skor_keseluruhan.alasan_skor || '';
            } else {
                overallScore = data.skor_keseluruhan || 0;
            }
            $('#content_ai_score').text(overallScore);
            $('#content_ai_score').text(overallScore);
            if (overallReason) {
                var el = document.getElementById('content_ai_score_container');
                el.setAttribute('title', overallReason);
                el.setAttribute('data-bs-original-title', overallReason);
                // Dispose existing if any
                var existing = bootstrap.Tooltip.getInstance(el);
                if (existing) existing.dispose();
                // Re-init
                new bootstrap.Tooltip(el);
            }

            // Executive Summary
            let execSum = '';
            if (Array.isArray(data.ringkasan_eksekutif)) {
                data.ringkasan_eksekutif.forEach(pt => execSum += `<li class="mb-1">${pt}</li>`);
            }
            $('#content_ai_executive_summary').html(execSum);

            // Helper for Progress Bars with Tooltip
            const renderProgress = (label, obj, color = 'primary') => {
                let val = 0;
                let reason = '';
                if (typeof obj === 'object' && obj !== null) {
                    val = obj.nilai || 0;
                    reason = obj.alasan_skor || '';
                } else {
                    val = obj || 0;
                }

                // If undefined or 0, maybe hide? or show 0

                return `
                <div class="mb-2" data-bs-toggle="tooltip" data-bs-placement="top" title="${reason}">
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="text-white-50">${label}</span>
                        <span class="text-${color} fw-bold">${val}%</span>
                    </div>
                    <div class="progress" style="height: 4px; background: rgba(255,255,255,0.1);">
                        <div class="progress-bar bg-${color}" role="progressbar" style="width: ${val}%" aria-valuenow="${val}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>`;
            };

            // Strategy & Funnel Stats
            let stratHtml = '';
            if (data.kesinambungan_strategis) {
                stratHtml += renderProgress('Campaign Alignment', data.kesinambungan_strategis.alignment_dengan_campaign, 'info');
                stratHtml += renderProgress('Activation Alignment', data.kesinambungan_strategis.alignment_dengan_activation, 'info');
                stratHtml += renderProgress('Message Consistency', data.kesinambungan_strategis.konsistensi_pesan, 'info');
                stratHtml += renderProgress('Audience Match', data.kesinambungan_strategis.kesesuaian_target_audiens, 'info');
            }
            if (data.dampak_funnel) {
                stratHtml += '<div class="my-2 border-top border-white border-opacity-10"></div>';
                stratHtml += renderProgress('Awareness', data.dampak_funnel.awareness, 'success');
                stratHtml += renderProgress('Consideration', data.dampak_funnel.consideration, 'success');
                stratHtml += renderProgress('Conversion', data.dampak_funnel.conversion, 'success');
                stratHtml += renderProgress('Loyalty', data.dampak_funnel.loyalty, 'success');
            }
            $('#content_ai_strategy_funnel_stats').html(stratHtml);

            // Hook & Script Stats
            let hookHtml = '';
            if (data.analisis_hook_dan_scroll_stopping) {
                hookHtml += renderProgress('Hook Strength', data.analisis_hook_dan_scroll_stopping.kekuatan_hook, 'warning');
                hookHtml += renderProgress('Hook Relevance', data.analisis_hook_dan_scroll_stopping.relevansi_hook, 'warning');
                hookHtml += renderProgress('Scroll Stop Pot.', data.analisis_hook_dan_scroll_stopping.potensi_scroll_stop, 'warning');
            }
            if (data.analisis_script_dan_persuasi) {
                hookHtml += '<div class="my-2 border-top border-white border-opacity-10"></div>';
                hookHtml += renderProgress('Prob. Clarity', data.analisis_script_dan_persuasi.kejelasan_problem, 'danger');
                hookHtml += renderProgress('Agitation', data.analisis_script_dan_persuasi.kekuatan_agitasi, 'danger');
                hookHtml += renderProgress('Solution', data.analisis_script_dan_persuasi.kekuatan_solusi, 'danger');
                hookHtml += renderProgress('CTA Strength', data.analisis_script_dan_persuasi.kekuatan_cta, 'danger');
            }
            $('#content_ai_hook_script_stats').html(hookHtml);


            // SWOT
            const renderListIdentified = (items) => {
                if (!items || items.length === 0) return '<li class="text-muted fst-italic">None identified</li>';
                return items.map(i => `<li class="d-flex gap-2"><i class="bi bi-dot mt-1"></i> <span>${i}</span></li>`).join('');
            }

            if (data.analisis_swot_konten) {
                $('#content_ai_swot_strengths').html(renderListIdentified(data.analisis_swot_konten.strengths));
                $('#content_ai_swot_weaknesses').html(renderListIdentified(data.analisis_swot_konten.weaknesses));
                $('#content_ai_swot_opportunities').html(renderListIdentified(data.analisis_swot_konten.opportunities));
                $('#content_ai_swot_threats').html(renderListIdentified(data.analisis_swot_konten.threats));
            }

            // Performance
            let perfHtml = '';
            if (data.estimasi_performa) {
                perfHtml += `<div class="d-flex justify-content-between mb-2"><span>CTR Est.</span> <span class="text-white fw-bold">${data.estimasi_performa.estimasi_ctr_persen}%</span></div>`;
                perfHtml += `<div class="d-flex justify-content-between mb-2"><span>Leads Est.</span> <span class="text-white fw-bold">${data.estimasi_performa.estimasi_leads_dari_konten}</span></div>`;
                perfHtml += `<div class="d-flex justify-content-between mb-2"><span>Lead Conv.</span> <span class="text-white fw-bold">${data.estimasi_performa.estimasi_konversi_dari_leads_persen}%</span></div>`;
                perfHtml += `<div class="d-flex justify-content-between mb-2"><span>Eng. Multiplier</span> <span class="text-white fw-bold">${data.estimasi_performa.estimasi_multiplier_engagement}x</span></div>`;
            }
            $('#content_ai_performance_stats').html(perfHtml);

            // Cost Stats
            let costHtml = '';
            if (data.analisis_biaya) {
                costHtml += renderProgress('Cost Efficiency', data.analisis_biaya.efisiensi_biaya, 'success');
                costHtml += renderProgress('Hidden Cost Risk', data.analisis_biaya.risiko_hidden_cost, 'warning');
                if (data.analisis_biaya.komentar_biaya) {
                    costHtml += `<p class="mt-2 mb-0 fst-italic opacity-75" style="font-size:11px;">"${data.analisis_biaya.komentar_biaya}"</p>`;
                }
            }
            $('#content_ai_cost_stats').html(costHtml);

            // Risk Stats
            let riskHtml = '';
            if (data.analisis_risiko) {
                riskHtml += renderProgress('Overclaim Risk', data.analisis_risiko.risiko_overclaim, 'danger');
                riskHtml += renderProgress('Misleading Risk', data.analisis_risiko.risiko_misleading_finansial, 'danger');
                riskHtml += renderProgress('Reputation Risk', data.analisis_risiko.risiko_reputasi, 'danger');
                riskHtml += renderProgress('Saturation Risk', data.analisis_risiko.risiko_kejenuhan_konten, 'warning');
            }
            $('#content_ai_risk_stats').html(riskHtml);


            // Recommendations
            let recHtml = '';
            if (data.rekomendasi_strategis) {
                const createRecCol = (title, items, icon) => {
                    let list = items.map(x => `<li class="mb-1">${x}</li>`).join('');
                    return `
                    <div class="col-md-6">
                        <h6 class="text-white-50 text-uppercase small fw-bold mb-2"><i class="bi ${icon} me-2"></i>${title}</h6>
                        <ul class="small text-white ps-3 mb-0">${list}</ul>
                    </div>`;
                }

                if (data.rekomendasi_strategis.optimasi_hook) recHtml += createRecCol('Hook Optimization', data.rekomendasi_strategis.optimasi_hook, 'bi-magnet');
                if (data.rekomendasi_strategis.optimasi_script) recHtml += createRecCol('Script Optimization', data.rekomendasi_strategis.optimasi_script, 'bi-file-text');
                if (data.rekomendasi_strategis.optimasi_visual) recHtml += createRecCol('Visual Optimization', data.rekomendasi_strategis.optimasi_visual, 'bi-image');
                if (data.rekomendasi_strategis.ide_scaling) recHtml += createRecCol('Scaling Ideas', data.rekomendasi_strategis.ide_scaling, 'bi-rocket');
            }
            $('#content_ai_recommendations_grid').html(recHtml);

            // Activate Tooltips
            // Activate Tooltips
            reinitTooltips('#content_ai_analysis_content');

        } else {
            // Fallback for Old Data Structure
            $('#content_ai_score').text(data.viability_analysis?.score || 0);

            // Pros -> Strengths
            let prosHtml = '';
            if (data.viability_analysis && data.viability_analysis.pros_strengths) {
                data.viability_analysis.pros_strengths.forEach(item => {
                    prosHtml += `<li class="d-flex gap-2"><i class="bi bi-check-circle text-success mt-1"></i> <span>${item}</span></li>`;
                });
            }
            $('#content_ai_swot_strengths').html(prosHtml || '<li>No data</li>');

            // Risks -> Threats
            let risksHtml = '';
            if (data.viability_analysis && data.viability_analysis.risks_bottlenecks) {
                data.viability_analysis.risks_bottlenecks.forEach(item => {
                    risksHtml += `<li class="d-flex gap-2"><i class="bi bi-x-circle text-warning mt-1"></i> <span>${item}</span></li>`;
                });
            }
            $('#content_ai_swot_threats').html(risksHtml || '<li>No data</li>');

            // Recommendation
            if (data.recommendations) {
                let rec = `<strong>Creative Recommendation:</strong> ${data.recommendations.creative}<br>`;
                rec += `<strong>Tactical Recommendation:</strong> ${data.recommendations.tactical}`;
                $('#content_ai_recommendations_grid').html(`<div class="col-12"><p class="small text-white-50 mb-0">${rec}</p></div>`);
            }
        }
    }

    // Approve Plan Logic
    $(document).off('click', '#btnApproveContentPlan').on('click', '#btnApproveContentPlan', function () {
        let id = $(this).data('id');
        let target = campaignData.content_target;
        let btn = $(this);

        Swal.fire({
            title: 'Approve Content Plan?',
            text: "This action will update the status to Approved.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: BASE_URL + 'compas/content/approve_content_plan',
                    type: 'POST',
                    data: { id: id, target: target },
                    dataType: 'json',
                    beforeSend: function () {
                        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Processing...');
                    },
                    success: function (response) {
                        if (response.status) {
                            Swal.fire(
                                'Approved!',
                                'The content plan has been approved.',
                                'success'
                            ).then(() => {
                                $('#viewContentPlanModal').modal('hide');
                                loadContentPlanTable(); // Reload table
                                loadTeamPerformance();
                                loadCampaignData();
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                            btn.prop('disabled', false).html('<i class="bi bi-check-circle me-2"></i>Approve Plan');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Server Error', 'error');
                        btn.prop('disabled', false).html('<i class="bi bi-check-circle me-2"></i>Approve Plan');
                    }
                });
            }
        });
    });

    // Cancel Approval
    $(document).off('click', '#btnCancelApproveContent').on('click', '#btnCancelApproveContent', function () {
        let id = $('#btnApproveContentPlan').data('id');
        let target = campaignData.content_target;
        Swal.fire({
            title: 'Are you sure?',
            text: "This will revert the plan status to Draft/In Progress.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, cancel approval!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: BASE_URL + 'compas/content/cancel_approve_plan',
                    type: 'POST',
                    data: { id: id, target: target },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status) {
                            Swal.fire('Success', 'Approval cancelled successfully', 'success');
                            $('#viewContentPlanModal').modal('hide');
                            loadContentPlanTable();
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

    // Revise / Reject Plan
    $(document).off('click', '#btnRejectContentPlan').on('click', '#btnRejectContentPlan', function () {
        let id = $('#btnApproveContentPlan').data('id');
        let target = campaignData.content_target;
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
                    url: BASE_URL + 'compas/content/reject_content_plan',
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
                Swal.fire('Success', 'Plan rejected/revised successfully', 'success');
                $('#viewContentPlanModal').modal('hide');
                loadContentPlanTable();
                loadTeamPerformance();
                loadCampaignData();
            }
        });
    });

    // Invite Team Modal Logic
    $('#inviteContentTeamModal').on('show.bs.modal', function () {
        loadEmployeesForInvite();
    });

    $('#btnSaveContentTeam').on('click', function () {
        saveContentTeam();
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
    }

    // Re-init Chosen when modal is shown (fix for Select width 0)
    $('#inviteContentTeamModal').on('shown.bs.modal', function () {
        $('.chosen-select', this).chosen('destroy').chosen({
            width: "100%",
            placeholder_text_single: "Select an option",
            placeholder_text_multiple: "Choose options",
            no_results_text: "Oops, nothing found!"
        });
    });

    // Content Plan Wizard: init on modal shown
    $('#addContentPlanModal').on('shown.bs.modal', function () {
        initContentPlanWizard();
    });

    // Content Plan Wizard: reset to step 1 on modal hidden
    $('#addContentPlanModal').on('hidden.bs.modal', function () {
        // Reset form
        $('#formAddContentPlan')[0].reset();
        // Reset to step 1
        contentPlanCurrentStep = 1;
        showContentPlanStep(1);
    });

    // Strategy Pagination
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

    function loadApprovedActivations(page = 1) {
        const campaignId = $('#detail_id').val();

        // Show skeleton/loading state
        $('#incoming-briefs-container').html(`
        <div class="d-flex align-items-center justify-content-center p-4">
            <div class="spinner-border text-purple" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `);

        $.ajax({
            url: BASE_URL + 'compas/content/get_approved_activations',
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
                                        <h6 class="fw-bold text-dark mb-1">${item.title}</h6>
                                        <div class="d-flex gap-2">
                                            <span class="badge bg-purple-soft text-purple border-purple">${item.platform_name || 'N/A'}</span>
                                            <small class="text-secondary opacity-75">${item.activation_period || ''}</small>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-outline-purple rounded-3 px-3 view-strategy-btn" data-id="${item.activation_id}">View Details</button>
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

                    $('#incoming-briefs-container').html(html);

                    // Show the parent card if hidden
                    $('#incoming-briefs-card').show();
                } else {
                    $('#incoming-briefs-container').html('<p class="text-muted text-center small my-3">No approved strategies found for this campaign.</p>');
                }
            },
            error: function (xhr, status, error) {
                console.error("Error loading strategies:", error);
                $('#incoming-briefs-container').html('<p class="text-danger text-center small my-3">Failed to load strategies.</p>');
            }
        });
    }

    function viewStrategyDetail(id) {
        // Show modal
        var modal = new bootstrap.Modal(document.getElementById('strategyContentDetailModal'));
        modal.show();

        // Show loading
        $('#strategyContentDetailContent').html(`
        <div class="text-center py-5">
            <div class="spinner-border text-purple" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-purple small">Loading details...</p>
        </div>
    `);

        $.ajax({
            url: BASE_URL + 'compas/content/get_activation_detail',
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    const data = response.data;
                    const camp = data.campaign;
                    const act = data.activation;

                    // check cg_name if there is comma then explode and create ordered list
                    if (act.cg_name?.includes(',')) {
                        const cg_name = act.cg_name.split(',');
                        let cg_name_html = '<ol>';
                        cg_name.forEach(function (item) {
                            cg_name_html += `<li class="text-dark mb-0 text-justify fs-14">${item}</li>`;
                        });
                        cg_name_html += '</ol>';
                        act.cg_name = cg_name_html;
                    }

                    // check cg_desc if there is comma then explode and create ordered list
                    if (act.cg_desc?.includes(',')) {
                        const cg_desc = act.cg_desc.split(',');
                        let cg_desc_html = '<ol>';
                        cg_desc.forEach(function (item) {
                            cg_desc_html += `<li class="text-dark mb-0 text-justify fs-14">${item}</li>`;
                        });
                        cg_desc_html += '</ol>';
                        act.cg_desc = cg_desc_html;
                    }

                    // check platform_name if there is comma then explode and create ordered list
                    if (act.platform_name?.includes(',')) {
                        const platform_name = act.platform_name.split(',');
                        let platform_name_html = '<ol>';
                        platform_name.forEach(function (item) {
                            platform_name_html += `<li class="text-dark mb-0 text-justify fs-14">${item}</li>`;
                        });
                        platform_name_html += '</ol>';
                        act.platform_name = platform_name_html;
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
                        <div class="col-12">
                            <div class="py-2">
                                <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Strategy Title</label>
                                <p class="text-dark mb-0 text-justify fs-14">${act.title || '-'}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="py-2">
                                <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Strategy Description</label>
                                <p class="text-dark mb-0 text-justify fs-14">${act.description || '-'}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="py-2">
                                <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Periode Event</label>
                                <p class="text-dark mb-0 text-justify fs-14">${act.activation_period || '-'}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="py-2">
                                <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Strategy Budget</label>
                                <p class="text-dark mb-0 text-justify fs-14">${formatRibuan(act.budget) || '-'}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="py-2">
                                <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Content Type</label>
                                <p class="text-dark mb-0 text-justify fs-14">${act.cg_name || '-'}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="py-2">
                                <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Platform Name</label>
                                <p class="text-dark mb-0 text-justify fs-14">${act.platform_name || '-'}</p>
                            </div>
                        </div>
                    </div>
                `;
                    $('#strategyContentDetailContent').html(html);
                } else {
                    $('#strategyContentDetailContent').html('<div class="alert alert-danger border-0 shadow-sm text-center">Failed to load details.</div>');
                }
            },
            error: function () {
                $('#strategyContentDetailContent').html('<div class="alert alert-danger border-0 shadow-sm text-center">Error communicating with server.</div>');
            }
        });
    }

    function loadContentTeam() {
        const campaignId = $('#detail_id').val();
        $.ajax({
            url: BASE_URL + 'compas/content/get_content_team',
            type: 'GET',
            data: { campaign_id: campaignId },
            dataType: 'json',
            success: function (response) {
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
                        $('#avatar-content-team').empty().append(html);

                        // Re-init tooltips
                        reinitTooltips('#avatar-content-team');
                    }
                }
            }
        });
    }

    function loadEmployeesForInvite() {
        const campaignId = $('#detail_id').val();
        // First get current team to pre-select
        $.ajax({
            url: BASE_URL + 'compas/content/get_content_team',
            type: 'GET',
            data: { campaign_id: campaignId },
            dataType: 'json',
            success: function (teamResponse) {
                let currentTeamIds = [];
                if (teamResponse.status && teamResponse.data && teamResponse.data.content_team) {
                    currentTeamIds = teamResponse.data.content_team.split(',');
                }

                // Then get all employees
                $.ajax({
                    url: BASE_URL + 'compas/content/get_employees',
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status) {
                            let options = '';
                            response.data.forEach(user => {
                                const selected = currentTeamIds.includes(user.user_id) ? 'selected' : '';
                                options += `<option value="${user.user_id}" ${selected}>${user.full_name}</option>`;
                            });
                            $('#invite_content_team_select').html(options);
                            $('#invite_content_team_select').trigger('chosen:updated');
                        }
                    }
                });
            }
        });
    }

    function saveContentTeam() {
        const campaignId = $('#detail_id').val();
        const selectedTeam = $('#invite_content_team_select').val();

        $.ajax({
            url: BASE_URL + 'compas/content/save_content_team',
            type: 'POST',
            data: {
                campaign_id: campaignId,
                team: selectedTeam
            },
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    // Close modal
                    const modalEl = document.getElementById('inviteContentTeamModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    modal.hide();

                    // Reload team display
                    loadContentTeam();
                } else {
                    alert('Failed to update team: ' + response.message);
                }
            },
            error: function () {
                alert('Error processing request');
            }
        });
    }

    // Plan Modal Logic - Wizard Navigation
    var contentPlanCurrentStep = 1;
    var contentPlanTotalSteps = 5;

    function showContentPlanStep(step) {
        // Hide all steps
        $('#formAddContentPlan .content-wizard-step').hide();
        // Show current step
        $('#formAddContentPlan .content-wizard-step[data-step="' + step + '"]').fadeIn();

        // Update Prev button
        if (step === 1) {
            $('#addContentPlanModal .content-btn-prev').prop('disabled', true);
        } else {
            $('#addContentPlanModal .content-btn-prev').prop('disabled', false);
        }

        // Update Next/Finish buttons
        if (step === contentPlanTotalSteps) {
            $('#addContentPlanModal .content-btn-next').hide();
            $('#addContentPlanModal .content-btn-finish').show();
        } else {
            $('#addContentPlanModal .content-btn-next').show();
            $('#addContentPlanModal .content-btn-finish').hide();
        }

        // Update progress bar
        var progress = (step / contentPlanTotalSteps) * 100;
        $('#addContentPlanModal .content-wizard-progress .progress-bar').css('width', progress + '%').attr('aria-valuenow', progress);
    }

    function validateContentPlanStep(step) {
        var isValid = true;
        var stepContainer = $('#formAddContentPlan .content-wizard-step[data-step="' + step + '"]');

        stepContainer.find('input[required], select[required], textarea[required]').each(function () {
            if (!$(this).val() || $(this).val().length === 0) {
                isValid = false;
                $(this).addClass('is-invalid');
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

    function initContentPlanWizard() {
        // Re-init Chosen inside modal
        $('.chosen-select', '#addContentPlanModal').chosen('destroy').chosen({
            width: "100%",
            placeholder_text_single: "Select an option",
            placeholder_text_multiple: "Choose options",
            no_results_text: "Oops, nothing found!"
        });

        // Reset to step 1
        contentPlanCurrentStep = 1;
        showContentPlanStep(1);

        // Previous button
        $('#addContentPlanModal .content-btn-prev').off('click').on('click', function () {
            if (contentPlanCurrentStep > 1) {
                contentPlanCurrentStep--;
                showContentPlanStep(contentPlanCurrentStep);
            }
        });

        // Next button
        $('#addContentPlanModal .content-btn-next').off('click').on('click', function () {
            if (validateContentPlanStep(contentPlanCurrentStep)) {
                if (contentPlanCurrentStep < contentPlanTotalSteps) {
                    contentPlanCurrentStep++;
                    showContentPlanStep(contentPlanCurrentStep);
                }
            }
        });

        // Finish/Save button
        $('#addContentPlanModal .content-btn-finish').off('click').on('click', function () {
            saveContentPlan();
        });
    }

    // Surprise Me Logic
    $(document).off('click', '#btnSurpriseMeContent').on('click', '#btnSurpriseMeContent', function () {
        const $btn = $(this);
        const campaignId = $('#detail_id').val() || $('#content_plan_campaign_id').val() || '';
        const activationId = $('#content_plan_activation_id').val() || '';
        const userPrompt = '';

        if (!activationId) {
            Swal.fire({
                icon: 'warning',
                title: 'Activation Required',
                text: 'Silakan pilih Activation Strategy terlebih dahulu sebelum mencoba Surprise Me!',
                confirmButtonColor: '#3085d6',
            });
            return;
        }

        // Loading state
        const originalHtml = $btn.html();
        $btn.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Generating...'
        );

        const formData = new FormData();
        formData.append('campaign_id', campaignId);
        formData.append('activation_id', activationId);
        formData.append('user_prompt', userPrompt);

        fetch(`${BASE_URL}compas/content/generate_ai_content`, {
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

                // ── Helper: random pick from Chosen select ────────────────────────
                const pickRandomOption = (selector, multiple = false) => {
                    const options = $(selector + ' option').map(function () { return $(this).val(); }).get().filter(v => v !== '');
                    if (options.length === 0) return;
                    if (multiple) {
                        const count = Math.floor(Math.random() * Math.min(3, options.length)) + 1;
                        const selected = [...new Set(options.sort(() => 0.5 - Math.random()).slice(0, count))];
                        $(selector).val(selected).trigger('chosen:updated');
                    } else {
                        $(selector).val(options[Math.floor(Math.random() * options.length)]).trigger('chosen:updated');
                    }
                };

                // ── Helper: set OverType editor value ─────────────────────────────
                const setEditor = (editor, val) => {
                    if (!val) return;
                    try {
                        if (editor && typeof editor.setValue === 'function') editor.setValue(val);
                    } catch (e) { console.warn('OverType setValue failed', e); }
                };

                // ── Populate Selects ──────────────────────────────────────────────
                // Activation ID – keep existing selection or pick random
                if (!activationId) pickRandomOption('#content_plan_activation_id');

                // Multi-selects: use AI data if provided, else random
                const setMultiSelect = (selector, ids) => {
                    if (ids && Array.isArray(ids) && ids.length > 0) {
                        $(selector).val(ids.map(String)).trigger('chosen:updated');
                    } else {
                        pickRandomOption(selector, true);
                    }
                };

                setMultiSelect('#content_plan_platform', d.platform_ids);
                setMultiSelect('#content_plan_placement', d.placement_ids);
                setMultiSelect('#content_plan_format', d.format_ids);
                setMultiSelect('#content_plan_content_pillar', d.content_pillar_ids);
                setMultiSelect('#content_plan_talent_type', d.talent_type_ids);

                // ── Title ─────────────────────────────────────────────────────────
                if (d.title) $('#content_plan_title').val(d.title);

                // ── Duration ─────────────────────────────────────────────────────
                if (d.duration_desc) $('#content_plan_duration_desc').val(d.duration_desc);

                // ── Dates ─────────────────────────────────────────────────────────
                if (d.publish_date) $('#content_plan_publish_date').val(d.publish_date);
                if (d.deadline_publish) $('#content_plan_deadline').val(d.deadline_publish);

                // ── Cost & Target ─────────────────────────────────────────────────
                if (d.talent_cost) $('#content_plan_talent_cost').val(formatRibuan(d.talent_cost));
                if (d.talent_target) $('#content_plan_talent_target').val(d.talent_target);

                // ── Hidden values + OverType editors ─────────────────────────────
                if (d.talent_persona) {
                    $('#content_plan_talent_persona').val(d.talent_persona);
                    setEditor(talent_persona_editor, d.talent_persona);
                }
                if (d.pain_point) {
                    $('#content_plan_pain_point').val(d.pain_point);
                    setEditor(pain_point_editor, d.pain_point);
                }
                if (d.trigger_emotion) {
                    $('#content_plan_trigger_emotion').val(d.trigger_emotion);
                    setEditor(trigger_emotion_editor, d.trigger_emotion);
                }
                if (d.consumption_behavior) {
                    $('#content_plan_consumption_behavior').val(d.consumption_behavior);
                    setEditor(consumption_behavior_editor, d.consumption_behavior);
                }
                if (d.hook) {
                    $('#content_plan_hook').val(d.hook);
                    setEditor(hook_editor, d.hook);
                }
                if (d.script_content) {
                    $('#content_plan_script_content_val').val(d.script_content);
                    setEditor(script_content_editor, d.script_content);
                }
                if (d.storyboard) {
                    $('#content_plan_storyboard_val').val(d.storyboard);
                    setEditor(storyboard_editor, d.storyboard);
                }
                if (d.audio_notes) {
                    $('#content_plan_audio_notes').val(d.audio_notes);
                    setEditor(audio_notes_editor, d.audio_notes);
                }
                if (d.reference_link) {
                    $('#content_plan_reference_link').val(d.reference_link);
                    setEditor(reference_link_editor, d.reference_link);
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
                console.error('generate_ai_content error:', err);
                Swal.fire('Error', 'Terjadi kesalahan saat menghubungi AI. Silakan coba lagi.', 'error');
            })
            .finally(() => {
                $btn.prop('disabled', false).html(originalHtml);
            });
    });


    function loadPlanOptions() {

        const campaignId = $('#detail_id').val();
        $('#content_plan_campaign_id').val(campaignId);

        return $.ajax({
            url: BASE_URL + 'compas/content/get_plan_options',
            type: 'GET',
            data: { campaign_id: campaignId },
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    const data = response.data;

                    // Activations
                    let actOptions = '<option value=""></option>';
                    data.activations.forEach(act => {
                        actOptions += `<option value="${act.activation_id}">${act.title}</option>`;
                    });
                    $('#content_plan_activation_id').html(actOptions);

                    // Platforms
                    let platOptions = '<option value=""></option>';
                    data.platforms.forEach(plat => {
                        platOptions += `<option value="${plat.platform_id}">${plat.platform_name}</option>`;
                    });
                    $('#content_plan_platform').html(platOptions);

                    // Content Pillars
                    let pillarOptions = '<option value=""></option>';
                    data.pillars.forEach(pil => {
                        pillarOptions += `<option value="${pil.cp_id}">${pil.cp_name}</option>`;
                    });
                    $('#content_plan_content_pillar').html(pillarOptions);

                    // Formats
                    let formatOptions = '<option value=""></option>';
                    data.formats.forEach(fmt => {
                        formatOptions += `<option value="${fmt.cf_id}">${fmt.cf_name}</option>`;
                    });
                    $('#content_plan_format').html(formatOptions);

                    // Placements
                    let placeOptions = '<option value=""></option>';
                    data.placement_types.forEach(place => {
                        placeOptions += `<option value="${place.placement_id}">${place.placement_name}</option>`;
                    });
                    $('#content_plan_placement').html(placeOptions);

                    // Talent Types
                    let talentOptions = '<option value=""></option>';
                    if (data.talent_types) {
                        data.talent_types.forEach(type => {
                            talentOptions += `<option value="${type.talent_type_id}">${type.talent_type_name}</option>`;
                        });
                    }
                    $('#content_plan_talent_type').html(talentOptions);

                    // Trigger Chosen update
                    $('#content_plan_activation_id, #content_plan_platform, #content_plan_content_pillar, #content_plan_format, #content_plan_placement, #content_plan_talent_type').trigger('chosen:updated');
                }
            }
        });
    }

    function saveContentPlan() {
        // Validation
        let requiredFields = [
            { id: 'content_plan_title', name: 'Title' },
            { id: 'content_plan_activation_id', name: 'Activation Strategy' }
        ];

        for (let field of requiredFields) {
            let val = $('#' + field.id).val();
            // Handle array for chosen multiple or simple string
            if (!val || (Array.isArray(val) && val.length === 0) || (typeof val === 'string' && val.trim() === '')) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Form',
                    text: 'Please fill in the ' + field.name + ' field.',
                    confirmButtonColor: '#3085d6',
                });
                return;
            }
        }

        const formData = $('#formAddContentPlan').serialize();

        $.ajax({
            url: BASE_URL + 'compas/content/save_content_plan',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        $('#addContentPlanModal').modal('hide');
                        $('#formAddContentPlan')[0].reset();
                        $('#content_plan_activation_id, #content_plan_platform, #content_plan_placement').val('').trigger('chosen:updated');
                        $('#content_plan_script_content_val, #content_plan_storyboard_val').val('');
                        if (script_content_editor && script_content_editor.setValue) script_content_editor.setValue('');
                        if (storyboard_editor && storyboard_editor.setValue) storyboard_editor.setValue('');

                        // // Reload table
                        // if ($.fn.DataTable.isDataTable('#dt_content_plan')) {
                        //     $('#dt_content_plan').DataTable().ajax.reload();
                        // } else {
                        loadContentPlanTable();
                        // }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while saving the plan.',
                });
            }
        });
    }

    // Helper for currency format (global scope or attached to window if needed by onkeyup)
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

    // Add Plan Button Logic
    $('#btnAddPlanContent').on('click', function () {
        // Load options
        $('#formAddContentPlan')[0].reset();
        $('#content_plan_content_id').val('');
        $('#addContentPlanModalLabel').text('Add Content Plan');
        $('#btnSaveContentPlan').html('Create Plan');
        loadPlanOptions().then(function () {

            // Reset Chosen
            $('#content_plan_activation_id, #content_plan_platform, #content_plan_format, #content_plan_placement, #content_plan_talent_type').val('');
            $('#content_plan_content_pillar').val(campaignData.cp_id);
            $('#content_plan_activation_id').trigger('change');
            $('#content_plan_platform, #content_plan_content_pillar, #content_plan_format, #content_plan_placement, #content_plan_talent_type').trigger('chosen:updated');
        });
        // Reset OverType
        try {
            if (script_content_editor && script_content_editor.setValue) script_content_editor.setValue('');
            if (storyboard_editor && storyboard_editor.setValue) storyboard_editor.setValue('');
            if (talent_persona_editor && talent_persona_editor.setValue) talent_persona_editor.setValue('');
            if (pain_point_editor && pain_point_editor.setValue) pain_point_editor.setValue('');
            if (trigger_emotion_editor && trigger_emotion_editor.setValue) trigger_emotion_editor.setValue('');
            if (consumption_behavior_editor && consumption_behavior_editor.setValue) consumption_behavior_editor.setValue('');
            if (hook_editor && hook_editor.setValue) hook_editor.setValue('');
            if (audio_notes_editor && audio_notes_editor.setValue) audio_notes_editor.setValue('');
            if (reference_link_editor && reference_link_editor.setValue) reference_link_editor.setValue('');
        } catch (e) {
            console.log("OverType reset failed", e);
        }
    });

    // Edit Plan Logic
    $(document).off('click', '.btn-content-edit-plan').on('click', '.btn-content-edit-plan', function () {
        let id = $(this).data('id');

        // Load options first
        loadPlanOptions().then(function () {
            $.ajax({
                url: BASE_URL + 'compas/content/get_content_detail?content_id=' + id,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        let data = response.data;

                        // Populate Form
                        $('#content_plan_content_id').val(data.content_id);
                        $('#content_plan_campaign_id').val(data.campaign_id);
                        $('#content_plan_activation_id').val(data.activation_id).trigger('chosen:updated').trigger('change');

                        $('#content_plan_title').val(data.title);

                        // Helper for Multi-Selects
                        const setMultiSelect = (id, val) => {
                            let values = [];
                            if (val !== null && val !== undefined) {
                                if (Array.isArray(val)) {
                                    values = val.map(String);
                                } else {
                                    let stringVal = String(val);
                                    if (stringVal.includes(',')) {
                                        values = stringVal.split(',').map(s => s.trim());
                                    } else {
                                        values = [stringVal.trim()];
                                    }
                                }
                            }
                            $(id).val(values).trigger('chosen:updated');
                        };

                        setMultiSelect('#content_plan_format', data.format);
                        setMultiSelect('#content_plan_platform', data.platform);
                        setMultiSelect('#content_plan_placement', data.placement_type);
                        setMultiSelect('#content_plan_content_pillar', data.content_pillar);
                        setMultiSelect('#content_plan_talent_type', data.talent_type);

                        $('#content_plan_publish_date').val(data.publish_date);
                        $('#content_plan_team_involved').val(data.team_involved);
                        $('#content_plan_duration_desc').val(data.duration_desc);
                        $('#content_plan_talent_cost').val(formatRibuan(data.talent_cost));

                        // Change Modal UI
                        $('#addContentPlanModalLabel').text('Edit Content Plan');
                        $('#btnSaveContentPlan').html('Update Plan');

                        // Show Modal and Wait for it to be fully shown before setting editors
                        $('#addContentPlanModal').one('shown.bs.modal', function () {
                            // Reset OverType Editors
                            const updateEditor = (editor, val) => {
                                if (editor) {
                                    if (typeof editor.setValue === 'function') editor.setValue(val);
                                    else if (typeof editor.setData === 'function') editor.setData(val);
                                }
                            };

                            try {
                                updateEditor(script_content_editor, data.script_content || '');
                                updateEditor(storyboard_editor, data.storyboard || '');
                                updateEditor(talent_persona_editor, data.talent_persona || '');
                                updateEditor(pain_point_editor, data.pain_point || '');
                                updateEditor(trigger_emotion_editor, data.trigger_emotion || '');
                                updateEditor(consumption_behavior_editor, data.consumption_behavior || '');
                                updateEditor(hook_editor, data.hook || '');
                                updateEditor(audio_notes_editor, data.audio_notes || '');
                                updateEditor(reference_link_editor, data.reference_link || '');
                            } catch (e) {
                                console.log("Error updating editors in edit mode", e);
                            }
                        }).modal('show');
                    } else {
                        Swal.fire('Error', 'Failed to fetch plan data', 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Server Error', 'error');
                }
            });
        });
    });


    // Delete Plan Logic
    $(document).off('click', '.btn-delete-plan').on('click', '.btn-delete-plan', function () {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Delete Content Plan?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: BASE_URL + 'compas/content/delete_content_plan',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status) {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            ).then(() => {
                                loadContentPlanTable();
                            });
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

    // Fetch and display activation info when an activation is selected
    $(document).off('change', '#content_plan_activation_id').on('change', '#content_plan_activation_id', function () {
        const activationId = $(this).val();
        const infoCard = $('#content_activation_info');

        if (!activationId) {
            infoCard.addClass('d-none');
            return;
        }

        // Show a loading state
        $('#info-content-activation-title').text('Loading...');
        $('#info-content-activation-period').text('Loading...');
        $('#info-content-activation-budget').text('Loading...');
        $('#info-content-activation-content-type').text('Loading...');
        $('#info-content-activation-platform').text('Loading...');
        $('#info-content-activation-desc').text('Loading...');
        infoCard.removeClass('d-none');

        const formData = new FormData();
        formData.append('activation_id', activationId);

        fetch(`${BASE_URL}compas/activation/get_activation_detail`, {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(result => {
                if (result.status === 'success' && result.data) {
                    const data = result.data;
                    const formatRupiahLocal = (num) => num ? num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") : "0";

                    $('#info-content-activation-title').text(data.title || '-');
                    const pStart = data.period_start || '';
                    const pEnd = data.period_end || '';
                    $('#info-content-activation-period').text((pStart && pEnd) ? `${pStart} s/d ${pEnd}` : '-');
                    $('#info-content-activation-budget').html(data.budget ? `<b>Rp </b>${formatRupiahLocal(data.budget)}` : '-');
                    $('#info-content-activation-content-type').text(data.content_produced_names || '-');
                    $('#info-content-activation-platform').text(data.platform_names || '-');
                    $('#info-content-activation-desc').text(data.description || '-');
                } else {
                    infoCard.addClass('d-none');
                }
            })
            .catch(err => {
                console.error('Failed to fetch activation detail:', err);
                infoCard.addClass('d-none');
            });
    });

    function loadContentLogs() {
        let campaign_id = $('#detail_id').val();
        if (!campaign_id) return;

        $.ajax({
            url: BASE_URL + 'compas/content/get_content_logs',
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
                            else if (log.action_type === 'UPDATED') color = 'warning text-dark';

                            logsHtml += `
                            <div class="timeline-item pb-4">
                                <div class="timeline-dot bg-${color}"></div>
                                <p class="mb-1 text-dark small">
                                    <span class="fw-bold">${log.user_name}</span> ${log.description}
                                </p>
                                <small class="text-muted xx-small">${log.time_ago}</small>
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
        if ($('#comments-container-content').length > 0) {
            $('#comments-container-content').comments({
                profile_picture_url: typeof CURRENT_USER_PROFILE_URL !== 'undefined' ? CURRENT_USER_PROFILE_URL : '',
                current_user_id: typeof CURRENT_USER_ID !== 'undefined' ? CURRENT_USER_ID : 1,
                user_has_upvoted: false,
                enableAttachments: true,
                enableHashtags: true,
                enablePinging: true,

                getComments: function (success, error) {
                    $.ajax({
                        type: 'GET',
                        url: BASE_URL + 'compas/content/get_comments',
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
                        url: BASE_URL + 'compas/content/post_comment',
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
                        url: BASE_URL + 'compas/content/put_comment',
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
                        url: BASE_URL + 'compas/content/upvote_comment',
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
                                url: BASE_URL + 'compas/content/delete_comment',
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
                        url: BASE_URL + 'compas/content/get_users_for_comments',
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
}