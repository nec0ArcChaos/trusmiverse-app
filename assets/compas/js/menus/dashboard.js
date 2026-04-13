

// Campaign Tab Script
if (!window.LoadInit) {
    window.LoadInit = {};
}

window.LoadInit["menus"] = window.LoadInit["menus"] || {};
window.LoadInit["menus"]["dashboard"] = function (container) {
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
        $('#start_date').val(start.format('YYYY-MM-DD'));
        $('#end_date').val(end.format('YYYY-MM-DD'));
        $('#rangecalendar').val(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));

        loadPerformanceOverview(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        loadPipelineOverview(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));

        if (typeof dtCampaignStageList !== 'undefined') {
            dtCampaignStageList.ajax.reload();
        }
    }

    function animateCountUp($el, toValue, decimals = 0) {
        $({ countNum: parseFloat($el.text()) || 0 }).animate(
            { countNum: parseFloat(toValue) },
            {
                duration: 2000,
                easing: 'swing',
                step: function () {
                    $el.text(parseFloat(this.countNum).toFixed(decimals));
                },
                complete: function () {
                    $el.text(parseFloat(this.countNum).toFixed(decimals));
                }
            }
        );
    }

    function animateSlamCountUp($el, toMins) {
        let currentMins = parseFloat($el.attr('data-current-mins')) || 0;
        $({ countNum: currentMins }).animate(
            { countNum: parseFloat(toMins) || 0 },
            {
                duration: 2000,
                easing: 'swing',
                step: function () {
                    $el.text(formatSlam(this.countNum));
                },
                complete: function () {
                    $el.text(formatSlam(this.countNum));
                    $el.attr('data-current-mins', toMins);
                }
            }
        );
    }

    function loadPerformanceOverview(start, end) {
        $.ajax({
            url: BASE_URL + 'compas/dashboard/get_performance_overview',
            type: 'POST',
            dataType: 'json',
            data: {
                start_date: start,
                end_date: end
            },
            success: function (response) {
                if (response.status === 'success') {
                    animateCountUp($('#val-all-campaign'), response.data.all_campaign, 0);
                    let changeSymbol = response.data.all_campaign_change >= 0 ? "▲ +" : "▼ ";
                    let changeTagClass = response.data.all_campaign_change >= 0 ? "tag-g" : "tag-r";
                    $('#val-all-campaign-change').text(changeSymbol + response.data.all_campaign_change);
                    $('#val-all-campaign-change').parent().removeClass("tag-g tag-r tag-y tag-b").addClass(changeTagClass);

                    animateCountUp($('#val-completed'), response.data.completed, 0);
                    animateCountUp($('#val-completed-on-time'), response.data.completed_on_time, 0);
                    animateCountUp($('#val-completed-delayed'), response.data.completed_delayed, 0);

                    animateCountUp($('#val-on-progress'), response.data.on_progress, 0);
                    animateCountUp($('#val-on-progress-on-track'), response.data.on_progress_on_track, 0);
                    animateCountUp($('#val-on-progress-at-risk'), response.data.on_progress_at_risk, 0);

                    animateCountUp($('#val-avg-ai'), response.data.avg_ai_score, 1);

                    let aiText = "Under Perform";
                    let aiTagClass = "tag-r";
                    let aiTextClass = "text-danger";

                    if (response.data.avg_ai_score >= 80) {
                        aiText = "Excellence";
                        aiTagClass = "tag-g";
                        aiTextClass = "text-success";
                    } else if (response.data.avg_ai_score >= 70) {
                        aiText = "Good";
                        aiTagClass = "tag-y";
                        aiTextClass = "text-warning";
                    }

                    $('#val-avg-ai-text').text(aiText).removeClass("text-success text-warning text-danger").addClass(aiTextClass);
                    $('#val-avg-ai-text').parent().removeClass("tag-g tag-y tag-r tag-b").addClass(aiTagClass);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching performance overview data", error);
            }
        });
    }

    $('.range').daterangepicker({
        startDate: start,
        endDate: end,
        "drops": "down",
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'Last 60 Days': [moment().subtract(59, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                .endOf('month')
            ]
        }
    }, cb);

    cb(start, end);

    function formatSlam(mins) {
        if (!mins || mins <= 0) return "0j 0m";
        let d = Math.floor(mins / 1440);
        let h = Math.floor((mins % 1440) / 60);
        let m = Math.floor(mins % 60);
        return (d > 0 ? d + "h " : "") + h + "j " + m + "m";
    }

    /* circular progress */
    const circleConfig = {
        color: '#015EC2',
        strokeWidth: 10,
        trailWidth: 10,
        easing: 'easeInOut',
        trailColor: 'rgba(66, 157, 255, 0.15)',
        duration: 1400,
        text: { autoStyleContainer: false },
        from: { color: '#015EC2', width: 10 },
        to: { color: '#015EC2', width: 10 },
        step: function (state, circle) {
            circle.path.setAttribute('stroke', state.color);
            circle.path.setAttribute('stroke-width', state.width);
            var value = Math.round(circle.value() * 100);
            if (value === 0) {
                circle.setText('0<small>%<small>');
            } else {
                circle.setText(value + "<small>%<small>");
            }
        }
    };

    var circleActivation = new ProgressBar.Circle(document.getElementById('divCircleActivationAvgAiScore'), circleConfig);
    var circleContent = new ProgressBar.Circle(document.getElementById('divCircleContentAvgAiScore'), circleConfig);
    var circleTalent = new ProgressBar.Circle(document.getElementById('divCircleTalentAvgAiScore'), circleConfig);
    var circleDistribution = new ProgressBar.Circle(document.getElementById('divCircleDistributionAvgAiScore'), circleConfig);
    var circleOptimization = new ProgressBar.Circle(document.getElementById('divCircleOptimizationAvgAiScore'), circleConfig);

    function loadPipelineOverview(start, end) {
        $.ajax({
            url: BASE_URL + 'compas/dashboard/get_pipeline_overview',
            type: 'POST',
            dataType: 'json',
            data: { start_date: start, end_date: end },
            success: function (response) {
                if (response.status === 'success') {
                    let d = response.data;

                    // Activation
                    animateCountUp($('#val-act-approved-actual'), d.activation.approved, 0);
                    animateCountUp($('#val-act-approved-target'), d.activation.target, 0);
                    animateSlamCountUp($('#val-act-sla'), d.activation.avg_sla_minutes);
                    animateCountUp($('#val-act-cpr'), d.activation.completion_rate, 1);
                    circleActivation.animate(d.activation.avg_ai_score / 100);

                    // Content
                    animateCountUp($('#val-cnt-approved-actual'), d.content.approved, 0);
                    animateCountUp($('#val-cnt-approved-target'), d.content.target, 0);
                    animateSlamCountUp($('#val-cnt-sla'), d.content.avg_sla_minutes);
                    animateCountUp($('#val-cnt-cpr'), d.content.completion_rate, 1);
                    circleContent.animate(d.content.avg_ai_score / 100);

                    // Talent
                    animateCountUp($('#val-tln-approved-actual'), d.talent.approved, 0);
                    animateCountUp($('#val-tln-approved-target'), d.talent.target, 0);
                    animateSlamCountUp($('#val-tln-sla'), d.talent.avg_sla_minutes);
                    animateCountUp($('#val-tln-cpr'), d.talent.completion_rate, 1);
                    circleTalent.animate(d.talent.avg_ai_score / 100);

                    // Distribution
                    animateCountUp($('#val-dst-approved-actual'), d.distribution.approved, 0);
                    animateCountUp($('#val-dst-approved-target'), d.distribution.target, 0);
                    animateSlamCountUp($('#val-dst-sla'), d.distribution.avg_sla_minutes);
                    animateCountUp($('#val-dst-cpr'), d.distribution.completion_rate, 1);
                    circleDistribution.animate(d.distribution.avg_ai_score / 100);

                    // Optimization
                    animateCountUp($('#val-opt-approved-actual'), d.optimization.approved, 0);
                    animateCountUp($('#val-opt-approved-target'), d.optimization.target, 0);
                    animateSlamCountUp($('#val-opt-sla'), d.optimization.avg_sla_minutes);
                    animateCountUp($('#val-opt-cpr'), d.optimization.completion_rate, 1);
                    circleOptimization.animate(d.optimization.avg_ai_score / 100);
                }
            }
        });
    }

    var dtCampaignStageList = $('#dt_campaign_stage_list').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": BASE_URL + "compas/dashboard/get_campaign_stage_list",
            "type": "POST",
            "data": function (d) {
                d.start_date = $('#start_date').val() || start.format('YYYY-MM-DD');
                d.end_date = $('#end_date').val() || end.format('YYYY-MM-DD');
                d.status = $('.period-select').val();
            }
        },
        "columnDefs": [
            { "orderable": false, "targets": [1, 2, 3, 4, 5, 6, 7, 8] }
        ]
    });

    var dtPicActivationList = $('#dt_pic_activation_list').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": false,
        "lengthChange": false,
        "info": false,
        "paging": false,
        "ajax": {
            "url": BASE_URL + "compas/dashboard/get_pic_activation_list",
            "type": "POST",
            "data": function (d) {
                d.start_date = $('#start_date').val() || start.format('YYYY-MM-DD');
                d.end_date = $('#end_date').val() || end.format('YYYY-MM-DD');
            }
        },
        "columnDefs": [
            { "orderable": false, "targets": [1, 2, 3, 4] }
        ]
    });

    var dtPicContentList = $('#dt_pic_content_list').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": false,
        "lengthChange": false,
        "info": false,
        "paging": false,
        "ajax": {
            "url": BASE_URL + "compas/dashboard/get_pic_content_list",
            "type": "POST",
            "data": function (d) {
                d.start_date = $('#start_date').val() || start.format('YYYY-MM-DD');
                d.end_date = $('#end_date').val() || end.format('YYYY-MM-DD');
            }
        },
        "columnDefs": [
            { "orderable": false, "targets": [1, 2, 3, 4] }
        ]
    });

    var dtPicTalentList = $('#dt_pic_talent_list').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": false,
        "lengthChange": false,
        "info": false,
        "paging": false,
        "ajax": {
            "url": BASE_URL + "compas/dashboard/get_pic_talent_list",
            "type": "POST",
            "data": function (d) {
                d.start_date = $('#start_date').val() || start.format('YYYY-MM-DD');
                d.end_date = $('#end_date').val() || end.format('YYYY-MM-DD');
            }
        },
        "columnDefs": [
            { "orderable": false, "targets": [1, 2, 3, 4] }
        ]
    });

    var dtPicDistributionList = $('#dt_pic_distribution_list').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": false,
        "lengthChange": false,
        "info": false,
        "paging": false,
        "ajax": {
            "url": BASE_URL + "compas/dashboard/get_pic_distribution_list",
            "type": "POST",
            "data": function (d) {
                d.start_date = $('#start_date').val() || start.format('YYYY-MM-DD');
                d.end_date = $('#end_date').val() || end.format('YYYY-MM-DD');
            }
        },
        "columnDefs": [
            { "orderable": false, "targets": [1, 2, 3, 4] }
        ]
    });

    var dtPicOptimizationList = $('#dt_pic_optimization_list').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": false,
        "lengthChange": false,
        "info": false,
        "paging": false,
        "ajax": {
            "url": BASE_URL + "compas/dashboard/get_pic_optimization_list",
            "type": "POST",
            "data": function (d) {
                d.start_date = $('#start_date').val() || start.format('YYYY-MM-DD');
                d.end_date = $('#end_date').val() || end.format('YYYY-MM-DD');
            }
        },
        "columnDefs": [
            { "orderable": false, "targets": [1, 2, 3, 4] }
        ]
    });

    $('.period-select').change(function () {
        dtCampaignStageList.ajax.reload();
        dtPicActivationList.ajax.reload();
        dtPicContentList.ajax.reload();
        dtPicTalentList.ajax.reload();
        dtPicDistributionList.ajax.reload();
        dtPicOptimizationList.ajax.reload();
    });

    $('style').append('.progressbar-text small { font-size: 10px; } .progressbar-text { font-size: 16px; color: #015EC2 !important; position: absolute; left: 50%; top: 50%; padding: 0px; margin: 0px; transform: translate(-50%, -50%); }');
}