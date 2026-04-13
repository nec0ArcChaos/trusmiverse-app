window.LoadInit = window.LoadInit || {};
window.LoadInit['tabs'] = window.LoadInit['tabs'] || {};
window.LoadInit['tabs']['campaign'] = function (container) {

    let detail_id = document.getElementById('detail_id').value;
    // console.log("Detail ID:", detail_id);


    if (detail_id) {

        let currentStep = 1;
        const totalSteps = 5;

        function showStep(step) {
            // Hide all steps
            $('.wizard-step').hide();
            // Show current step
            $(`.wizard-step[data-step="${step}"]`).fadeIn();

            // Update buttons
            if (step === 1) {
                $('.btn-prev').prop('disabled', true);
            } else {
                $('.btn-prev').prop('disabled', false);
            }

            if (step === totalSteps) {
                $('.btn-next').hide();
                $('.btn-finish').show();
            } else {
                $('.btn-next').show();
                $('.btn-finish').hide();
            }

            // Update progress bar
            const progress = (step / totalSteps) * 100;
            $('.progress-bar').css('width', `${progress}%`).attr('aria-valuenow', progress);
        }

        // Previous Button
        $('.btn-prev').off('click').on('click', function () {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });

        // Next Button
        $('.btn-next').off('click').on('click', function () {
            if (validateStep(currentStep)) {
                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                }
            }
        });

        function validateStep(step) {
            let isValid = true;

            // Find inputs in current step
            const stepContainer = $(`.wizard-step[data-step="${step}"]`);

            // Check required inputs
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

        // Initial show
        showStep(currentStep);


        $("#brand_id").chosen({ disable_search_threshold: 10 });
        $("#cp_id").chosen({ disable_search_threshold: 10 });
        $("#objective_id").chosen({ disable_search_threshold: 10 });
        $("#cg_id").chosen({ disable_search_threshold: 10 });
        $("#cf_id").chosen({ disable_search_threshold: 10 });

        $("#activation_team").chosen({ disable_search_threshold: 10 });
        $("#approve_activation_team").chosen({ disable_search_threshold: 10, width: "100%" });
        $("#content_team").chosen({ disable_search_threshold: 10 });
        $("#approve_content_team").chosen({ disable_search_threshold: 10, width: "100%" });
        $("#talent_team").chosen({ disable_search_threshold: 10 });
        $("#approve_talent_team").chosen({ disable_search_threshold: 10, width: "100%" });
        $("#distribution_team").chosen({ disable_search_threshold: 10 });
        $("#approve_distribution_team").chosen({ disable_search_threshold: 10, width: "100%" });
        $("#optimization_team").chosen({ disable_search_threshold: 10 });
        $("#approve_optimization_team").chosen({ disable_search_threshold: 10, width: "100%" });

        loadBrandOptions();

        // Handle Brand Change
        $('#brand_id').on('change', function () {
            var brandId = $(this).val();

            // Clear dependent selects
            $('#cp_id').empty().trigger("chosen:updated");
            $('#objective_id').empty().trigger("chosen:updated");
            $('#cg_id').empty().trigger("chosen:updated");
            $('#cf_id').empty().trigger("chosen:updated");

            if (brandId) {
                function fetchDependentData(url, targetId, valueKey, textKey, label) {
                    $.ajax({
                        url: BASE_URL + url,
                        type: 'POST',
                        data: {
                            brand_id: brandId
                        },
                        dataType: 'json',
                        success: function (response) {
                            var html = '';
                            if (response.data && response.data.length > 0) {
                                $.each(response.data, function (index, item) {
                                    html += '<option value="' + item[valueKey] + '">' + item[textKey] + '</option>';
                                });
                                $(targetId).html(html).trigger("chosen:updated");
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Data Kosong',
                                    text: 'Tidak ada data ' + label + ' untuk brand ini.',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal mengambil data ' + label + '.',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            console.error(error);
                        }
                    });
                }

                fetchDependentData('compas/campaign/get_content_pillars', '#cp_id', 'cp_id', 'cp_name', 'Pilar Konten');
                fetchDependentData('compas/campaign/get_objectives', '#objective_id', 'objective_id', 'objective_name', 'Objective');
                fetchDependentData('compas/campaign/get_generated_contents', '#cg_id', 'cg_id', 'cg_name', 'Content Generated');
                fetchDependentData('compas/campaign/get_content_formats', '#cf_id', 'cf_id', 'cf_name', 'Content Format');
                fetchDependentData('compas/campaign/get_employees', '#activation_team', 'user_id', 'employee_name', 'Team Activation');
                fetchDependentData('compas/campaign/get_employees', '#content_team', 'user_id', 'employee_name', 'Team Content');
                fetchDependentData('compas/campaign/get_employees', '#talent_team', 'user_id', 'employee_name', 'Team Talent Acquisition');
                fetchDependentData('compas/campaign/get_employees', '#distribution_team', 'user_id', 'employee_name', 'Team Distribution');
                fetchDependentData('compas/campaign/get_employees', '#optimization_team', 'user_id', 'employee_name', 'Team Optimization');
            }
        });

        function formatRibuan(number) {
            if (number == 0) {
                return "0";
            }
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function loadBrandOptions() {
            $.ajax({
                url: BASE_URL + 'compas/campaign/get_brands', // Use get_brands to populate options
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    var html = '';
                    if (response.data && response.data.length > 0) {
                        html += '<option value="">Pilih Brand...</option>';
                        console.log(response.data.length);
                        $.each(response.data, function (index, brand) {
                            html += '<option value="' + brand.brand_id + '">' + brand.brand_name + '</option>';
                        });
                    } else {
                        html += '<option value="">Tidak ada Brand</option>';
                    }
                    $('#brand_id').html(html);
                    $('#brand_id').trigger('chosen:updated');
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            })
        }

        [campaign_desc] = new OverType('#campaign_desc', {
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
            placeholder: 'Deskripsi singkat tentang kampanye ini',
            value: '',
            onChange: (value, instance) => {
                $('#campaign_desc_val').val(value);
            }
        });

        [angle] = new OverType('#angle', {
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
            placeholder: 'Sudut pandang, fokus spesifik, atau pendekatan unik yang dipilih untuk menyampaikan sebuah cerita, berita, atau informasi agar lebih menarik dan terarah',
            value: '',
            onChange: (value, instance) => {
                $('#angle_val').val(value);
            }
        });

        [target_audiens] = new OverType('#target_audiens', {
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
            placeholder: 'Target Audiens',
            value: '',
            onChange: (value, instance) => {
                $('#target_audiens_val').val(value);
            }
        });

        [problem] = new OverType('#problem', {
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
            placeholder: 'Problem yang ingin dipecahkan',
            value: '',
            onChange: (value, instance) => {
                $('#problem_val').val(value);
            }
        });

        [key_message] = new OverType('#key_message', {
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
            placeholder: 'inti informasi, gagasan yang ingin disampaikan',
            value: '',
            onChange: (value, instance) => {
                $('#key_message_val').val(value);
            }
        });

        [reason_to_believe] = new OverType('#reason_to_believe', {
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
            placeholder: 'bukti, data, atau argumen persuasif yang mendasari janji suatu brand/produk',
            value: '',
            onChange: (value, instance) => {
                $('#reason_to_believe_val').val(value);
            }
        });

        [cta] = new OverType('#cta', {
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
            placeholder: 'Call to Action',
            value: '',
            onChange: (value, instance) => {
                $('#cta_val').val(value);
            }
        });

        [link_referensi_internal] = new OverType('#link_referensi_internal', {
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
            placeholder: 'Link Referensi Internal',
            value: '',
            onChange: (value, instance) => {
                $('#link_referensi_internal_val').val(value);
            }
        });

        [link_referensi_eksternal] = new OverType('#link_referensi_eksternal', {
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
            placeholder: 'Link Referensi Eksternal',
            value: '',
            onChange: (value, instance) => {
                $('#link_referensi_eksternal_val').val(value);
            }
        });

        // Format Ribuan Input on Keyup
        $('#views, #leads, #transaction, #cost_production, #cost_placement').on('keyup', function () {
            $(this).val(formatRibuan($(this).val().replace(/\./g, '')));
        });

        // Show Skeleton, Hide Content
        $('#campaign-detail-skeleton').show();
        $('#campaign-detail-content').hide();
        $('#swot-result-container').hide();
        $('#swot-empty-state').hide();
        $('#swot-loading-state').show();

        $.ajax({
            url: BASE_URL + 'compas/campaign/get_campaign_detail',
            type: 'POST',
            data: { campaign_id: detail_id },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    let data = response.data;
                    $('#campaign-detail-content').data('campaign', data);

                    $('#detail_campaign_status_id').val(data.campaign_status_id || '-');
                    $('#detail_campaign_status').removeClass('bg-warning bg-success bg-primary');
                    if (data.campaign_status_id == 1) {
                        $('#detail_campaign_status').text(data.campaign_status || '-').addClass('badge bg-warning');
                        $('#campaign-action').removeClass('d-none');
                        $('#btn-approve-campaign').show();
                        $('#btn-approve-done-campaign').addClass('d-none');
                    } else if (data.campaign_status_id == 4) {
                        $('#detail_campaign_status').text(data.campaign_status || '-').addClass('badge bg-primary');
                        $('#campaign-action').addClass('d-none');
                    } else {
                        $('#detail_campaign_status').text(data.campaign_status || '-').addClass('badge bg-success');
                        $('#campaign-action').removeClass('d-none');
                        $('#btn-approve-campaign').hide();

                        let isDone = true;
                        let actTarget = parseInt(data.activation_target || 0);
                        let actActual = parseInt(data.activation_actual || 0);
                        let conTarget = parseInt(data.content_target || 0);
                        let conActual = parseInt(data.content_actual || 0);
                        let disTarget = parseInt(data.distribution_target || 0);
                        let disActual = parseInt(data.distribution_actual || 0);
                        let optTarget = parseInt(data.optimization_target || 0);
                        let optActual = parseInt(data.optimization_actual || 0);

                        // Check if any target exists and it's met
                        if (actTarget > 0 && actTarget > actActual) isDone = false;
                        if (conTarget > 0 && conTarget > conActual) isDone = false;
                        if (disTarget > 0 && disTarget > disActual) isDone = false;
                        if (optTarget > 0 && optTarget > optActual) isDone = false;

                        if (isDone) {
                            $('#btn-approve-done-campaign').removeClass('d-none');
                        } else {
                            $('#btn-approve-done-campaign').addClass('d-none');
                        }
                    }
                    // Populate basic info
                    $('#detail_brand_name').text(data.brand_name || '-');
                    $('#detail_campaign_period').text(data.campaign_period || '-');
                    $('#detail_objective').text(data.objectives || '-');
                    $('#detail_content_pillar').text(data.content_pillars || '-');
                    $('#detail_content_angle').html(data.content_angle || '-');

                    // Populate Audience & Problem info
                    $('#detail_target_audience').text(data.target_audience || '-');
                    $('#detail_audience_problem').html(data.audience_problem || '-');
                    $('#detail_key_message').text(data.key_message || '-');
                    $('#detail_reason_to_believe').html(data.reason_to_believe || '-');
                    $('#detail_call_to_action').text(data.call_to_action || '-');

                    // Populate Content Formats
                    let formatsHtml = '';
                    if (data.content_formats) {
                        let formats = data.content_formats.split(', ');
                        formats.forEach(function (fmt) {
                            formatsHtml += `<span class="btn btn-sm btn-link bg-light-blue text-blue me-1 mb-1" style="cursor: default;">${fmt}</span>`;
                        });
                    } else {
                        formatsHtml = '-';
                    }
                    $('#detail_content_format').html(formatsHtml);

                    // Populate Internal/External Content
                    $('#detail_internal_content_target').text(data.internal_content_target || 0);
                    if (data.internal_reference_url) {
                        $('#detail_internal_reference_url').attr('href', data.internal_reference_url).show();
                    } else {
                        $('#detail_internal_reference_url').hide();
                    }

                    $('#detail_external_content_target').text(data.external_content_target || 0);
                    if (data.external_reference_url) {
                        $('#detail_external_reference_url').attr('href', data.external_reference_url).show();
                    } else {
                        $('#detail_external_reference_url').hide();
                    }

                    // Populate KPI & Budget
                    $('#detail_target_views').text(formatRibuan(data.target_views || 0));
                    $('#detail_target_leads').text(formatRibuan(data.target_leads || 0));
                    $('#detail_target_transactions').text(formatRibuan(data.target_transactions || 0));

                    $('#detail_production_cost').text('Rp. ' + formatRibuan(data.production_cost || 0));
                    $('#detail_placement_cost').text('Rp. ' + formatRibuan(data.placement_cost || 0));

                    let totalCost = parseFloat(data.production_cost || 0) + parseFloat(data.placement_cost || 0);
                    $('#detail_total_cost').text('Rp. ' + formatRibuan(totalCost));


                    // Hide Skeleton, Show Content
                    setTimeout(() => {
                        $('#campaign-detail-skeleton').hide();
                        $('#swot-loading-state').hide();
                        $('#campaign-detail-content').fadeIn();

                        // Check if AI analysis exists
                        if (response.ai_analysis) {
                            renderAIAnalysis(response.ai_analysis);
                            // Change button text to Re-Analyze
                            $('#btn-ai-analyze').html('<i class="fa-solid fa-rotate-right me-2"></i>Re-Analyze');
                        } else {
                            $('#swot-result-container').hide();
                            $('#swot-empty-state').show();
                        }
                    }, 500); // Small delay for smooth transition

                } else {
                    // console.log("Failed to fetch campaign details:", response.message);
                    // Handle error (maybe show error message in UI)
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal mengambil data campaign ' + response.message,
                    });
                }
            },
            error: function (xhr, status, error) {
                // console.log("AJAX Error:", error);
                // Handle error
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal mengambil data campaign ' + error,
                });
            }
        });
    }


    /* circular progress */
    let circleViabilityScore = new ProgressBar.Circle(document.getElementById('circleViabilityScore'), {
        color: '#015EC2',
        // This has to be the same size as the maximum width to
        // prevent clipping
        strokeWidth: 10,
        trailWidth: 10,
        easing: 'easeInOut',
        trailColor: 'rgba(66, 157, 255, 0.15)',
        duration: 1400,
        text: {
            autoStyleContainer: false,
            style: {
                // Text color.
                // Default: same as stroke color (options.color)
                color: '#015EC2',
                position: 'absolute',
                left: '50%',
                top: '50%',
                padding: 0,
                margin: 0,
                // You can specify styles which will be browser prefixed
                transform: {
                    prefix: true,
                    value: 'translate(-50%, -50%)'
                }
            },
        },
        from: { color: '#015EC2', width: 10 },
        to: { color: '#015EC2', width: 10 },
        // Set default step function for all animate calls
        step: function (state, circle) {
            circle.path.setAttribute('stroke', state.color);
            circle.path.setAttribute('stroke-width', state.width);

            var value = Math.round(circle.value() * 100);
            if (value === 0) {
                circle.setText('');
            } else {
                circle.setText('<div class="text-center" style="cursor:pointer">' + value + "<br><small>Viability Score</small></br></div>");
            }

        }
    });
    circleViabilityScore.animate(0.85);  // Number from 0.0 to 1.0

    function formatRibuan(number) {
        if (number == 0) {
            return "0";
        }
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Helper function to populate lists
    const populateList = (listId, items) => {
        let listHtml = '';
        if (items && items.length > 0) {
            items.forEach(item => {
                if (typeof item === 'object' && item !== null) {
                    // Handle object (e.g., recommendations with title/description)
                    let content = item.title ? `<strong>${item.title}</strong>` : '';
                    if (item.description) content += `: ${item.description}`;
                    listHtml += `<li>${content}</li>`;
                } else {
                    // Handle string
                    listHtml += `<li>${item}</li>`;
                }
            });
        } else {
            listHtml = '<li>No data available</li>';
        }
        $(listId).html(listHtml);
    };

    // Render AI Analysis Helper
    const renderAIAnalysis = (data) => {
        // UI States
        $('#swot-empty-state').hide();
        $('#swot-loading-state').hide();

        populateList('#swot_strength_list', data.swot_strengths || data.strengths);
        populateList('#swot_weakness_list', data.swot_weaknesses || data.weaknesses);
        populateList('#swot_opportunity_list', data.swot_opportunities || data.opportunities);
        populateList('#swot_threat_list', data.swot_threats || data.threats);
        populateList('#swot_recommendation_list', data.recommendations);

        if (data.overall_score !== undefined) {
            let score = parseFloat(data.overall_score) / 100;
            if (!isNaN(score)) {
                circleViabilityScore.animate(score);
            }
        }

        // Store data for modal usage
        $('#circleViabilityScore').data('analysis', data);

        $('#swot-result-container').fadeIn();
    };

    // AI SWOT Analysis Event Handler
    $(container).off('click', '#btn-ai-analyze').on('click', '#btn-ai-analyze', function (e) {
        e.preventDefault();

        let campaignId = document.getElementById('detail_id').value;

        if (!campaignId) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Campaign ID not found.',
            });
            return;
        }

        // UI States
        $('#swot-empty-state').hide();
        $('#swot-result-container').hide();
        $('#swot-loading-state').fadeIn();

        // Disable button
        let btn = $(this);
        let originalContent = btn.html();

        let isReAnalyze = btn.text().includes('Re-Analyze');
        let loadingText = isReAnalyze ? 'Re-Analyzing...' : 'Analyzing...';

        btn.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>${loadingText}`);

        // Show alert to inform user about waiting time
        Swal.fire({
            title: 'Please Wait',
            text: 'The analysis process may take 1-5 minutes. Please do not close this page.',
            icon: 'info',
            showConfirmButton: false,
            timer: 5000 // Close after 5 seconds so the user sees the spinner
        });

        $.ajax({
            url: BASE_URL + 'compas/campaign/swot_analysis',
            type: 'POST',
            data: {
                campaign_id: campaignId,
                re_analyze: isReAnalyze
            },
            timeout: 300000, // 5 minutes timeout
            dataType: 'json',
            success: function (response) {
                $('#swot-loading-state').hide();

                if (response.status === 'success') {
                    renderAIAnalysis(response.data);

                    // Remove the button or change text to "Re-Analyze" if desired
                    btn.html('<i class="fa-solid fa-rotate-right me-2"></i>Re-Analyze');

                } else {
                    $('#swot-empty-state').fadeIn();
                    Swal.fire({
                        icon: 'error',
                        title: 'Analysis Failed',
                        text: response.message || 'Unknown error occurred.',
                    });
                    btn.html(originalContent);
                }
            },
            error: function (xhr, status, error) {
                $('#swot-loading-state').hide();
                $('#swot-empty-state').fadeIn();
                console.error("AJAX Error:", error);

                let errorMsg = 'Failed to connect to the server.';
                if (status === 'timeout') {
                    errorMsg = 'Proses analisis memakan waktu lebih lama dari biasanya. Harap tunggu beberapa saat lalu refresh halaman Anda.';
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMsg,
                });
                btn.html(originalContent);
            },
            complete: function () {
                btn.prop('disabled', false);
            }
        });
    });

    // Score Detail Modal Handler
    $(container).off('click', '#circleViabilityScore').on('click', '#circleViabilityScore', function () {
        let data = $(this).data('analysis');

        if (!data || !data.scoring_breakdown) {
            return; // No data to show
            // Optionally show toast "No detailed score available"
        }

        // Populate modal
        $('#modal_overall_score').text(data.overall_score ?? 0);
        $('#modal_conclusion').text(data.conclusion ?? '-');

        let breakdownHtml = '';

        const sectionTitles = {
            'strategy_and_concept': 'Strategy & Concept',
            'message_and_audience': 'Message & Audience',
            'creative_and_execution': 'Creative & Execution',
            'kpi_and_budget': 'KPI & Budget'
        };

        // If scoring_breakdown is object, iterate
        if (typeof data.scoring_breakdown === 'object') {
            for (const [key, value] of Object.entries(data.scoring_breakdown)) {
                let title = sectionTitles[key] || key.replace(/_/g, ' ').toUpperCase();
                let score = parseFloat(value.score) || 0;
                let maxScore = parseFloat(value.max_score) || 100;
                let reasoning = value.reasoning || '-';

                // Handle details object if exists
                let detailsHtml = '';
                if (value.details && typeof value.details === 'object') {
                    detailsHtml = '<ul class="mt-2 mb-0 small text-muted ps-3 list-unstyled">';

                    if (Array.isArray(value.details)) {
                        // Old Array Structure
                        value.details.forEach(detail => {
                            detailsHtml += `<li><i class="fas fa-circle fa-xs me-2"></i>${detail}</li>`;
                        });
                    } else {
                        // New Object Structure
                        for (const detailKey in value.details) {
                            if (value.details.hasOwnProperty(detailKey)) {
                                let detailValue = value.details[detailKey];
                                let detailText = '';

                                // Format Key (e.g., brand_alignment -> Brand Alignment)
                                let label = detailKey.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());

                                if (typeof detailValue === 'object' && detailValue !== null) {
                                    let score = detailValue.score ? `<span class="badge bg-light text-dark border ms-1">${detailValue.score} pts</span>` : '';
                                    let justification = detailValue.justification ? `<div class="fs-14">"${detailValue.justification}"</div>` : '';

                                    // Check for improvement needed
                                    let improvementHtml = '';
                                    if (detailValue.improvement && detailValue.improvement.needed) {
                                        let currentState = detailValue.improvement.current_state ? `<div class="mb-1"><span class="text-dark fw-medium fs-12">Current State :</span> <span class="text-dark fs-12">${detailValue.improvement.current_state}</span></div>` : '';
                                        let exampleBefore = detailValue.improvement.example_before ? `<div class="mb-1"><span class="text-dark fw-medium fs-12">Before Example :</span> <span class="text-dark fs-12">"${detailValue.improvement.example_before}"</span></div>` : '';
                                        let exampleAfter = detailValue.improvement.example_after ? `<div class="mb-1"><span class="text-dark fw-medium fs-12">After Example :</span> <span class="text-dark fs-12">"${detailValue.improvement.example_after}"</span></div>` : '';
                                        let suggestedImprovement = detailValue.improvement.suggested_improvement ? `<figure><blockquote class="blockquote fs-12 fw-medium">${detailValue.improvement.suggested_improvement}</blockquote>
                                        <figcaption class="blockquote-footer text-dark">
                                                            Potensi Kenaikan Skor: <cite title="Source Title" class="text-success fw-bold">${detailValue.improvement.expected_score_increase}</cite>
                                                        </figcaption></figure>` : '';
                                        improvementHtml = `
                                             <div class="card border-0 bg-gradient-theme-light theme-yellow mb-2">
                                                <div class="card-body bg-none">
                                                    <div class="mb-2 title">
                                                        <span class="fw-medium fs-14"><i class="bi bi-lightbulb-fill me-2"></i>Saran Perbaikan</span>
                                                    </div>
                                                    
                                                    ${suggestedImprovement}
                                                    ${currentState}
                                                    ${exampleBefore}
                                                    ${exampleAfter}
                                                </div>
                                             </div>
                                           `;
                                    }

                                    detailText = `<div class="fw-medium text-dark mb-1 fs-16">${label} ${score}</div> ${justification} ${improvementHtml}`;

                                } else {
                                    // Simple key-value
                                    detailText = `<strong>${label}:</strong> ${detailValue}`;
                                }

                                detailsHtml += `<li class="mb-3 border-bottom pb-2 last-no-border">${detailText}</li>`;
                            }
                        }
                    }
                    detailsHtml += '</ul>';
                }

                // Score color class
                let scoreColor = 'text-muted';
                if (score >= (maxScore * 0.8)) scoreColor = 'text-success';
                else if (score >= (maxScore * 0.6)) scoreColor = 'text-warning';
                else scoreColor = 'text-danger';

                breakdownHtml += `
                    <div class="col-md-6">
                        <div class="card bg-white h-100 rounded-3 p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold small text-uppercase text-muted">${title}</span>
                                <span class="h5 fw-bold mb-0 ${scoreColor}">${score} <span class="text-muted small fs-6">/ ${maxScore}</span></span>
                            </div>
                            <p class="small text-muted mb-0">${reasoning}</p>
                            ${detailsHtml}
                        </div>
                    </div>
                  `;
            }
        }

        $('#modal_score_breakdown').html(breakdownHtml);

        // Show modal
        var myModal = new bootstrap.Modal(document.getElementById('modalScoreDetail'));
        myModal.show();
    });

    // Approve As Done Campaign Handler
    $(container).off('click', '#btn-approve-done-campaign').on('click', '#btn-approve-done-campaign', function (e) {
        e.preventDefault();
        let campaignId = document.getElementById('detail_id').value;

        Swal.fire({
            title: 'Approve as Done?',
            text: "Are you sure you want to mark this campaign as Done?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: BASE_URL + 'compas/campaign/approve_done_campaign',
                    type: 'POST',
                    data: { campaign_id: campaignId },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire('Approved!', response.message, 'success');
                            $('#btn-approve-done-campaign').addClass('d-none');
                            $('#detail_campaign_status').text('Done').removeClass('bg-warning bg-success').addClass('badge bg-primary');
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    }
                });
            }
        });
    });


    // --- Helper for dropdowns ---
    const populateDropdown = (url, targetId, selectedValues = [], placeholder = 'Select...') => {
        $.ajax({
            url: BASE_URL + url,
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                let options = `<option value="">${placeholder}</option>`;
                if (response.data) {
                    response.data.forEach(item => {
                        let id, name;
                        // Determine key names based on data structure
                        if (item.brand_id) { id = item.brand_id; name = item.brand_name; }
                        else if (item.cp_id) { id = item.cp_id; name = item.cp_name; }
                        else if (item.objective_id) { id = item.objective_id; name = item.objective_name; }
                        else if (item.cg_id) { id = item.cg_id; name = item.cg_name; }
                        else if (item.cf_id) { id = item.cf_id; name = item.cf_name; }
                        else if (item.user_id) { id = item.user_id; name = item.employee_name; }

                        let isSelected = selectedValues.includes(String(id)) ? 'selected' : '';
                        options += `<option value="${id}" ${isSelected}>${name}</option>`;
                    });
                }
                $(targetId).html(options).trigger("chosen:updated");
            }
        });
    };

    // --- Edit Campaign Handler ---
    $(container).off('click', '#btn-edit-campaign').on('click', '#btn-edit-campaign', function () {
        let campaignData = $('#campaign-detail-content').data('campaign');
        if (!campaignData) return;

        // Populate Form Fields
        $('#campaign_name').val(campaignData.campaign_name);
        $('#start_date').val(campaignData.campaign_start_date);
        $('#end_date').val(campaignData.campaign_end_date);
        $('#campaign_desc_val').val(campaignData.campaign_desc);
        $('#angle_val').val(campaignData.content_angle);

        // Populate Brand
        populateDropdown('compas/campaign/get_brands', '#brand_id', [campaignData.brand_id], 'Pilih Brand...');

        // Fetch dependent dropdowns
        if (campaignData.brand_id) {
            let dropDowns = [
                { url: 'compas/campaign/get_content_pillars', target: '#cp_id', selected: campaignData.cp_id ? campaignData.cp_id.split(',') : [] },
                { url: 'compas/campaign/get_objectives', target: '#objective_id', selected: campaignData.objective_id ? campaignData.objective_id.split(',') : [] },
                { url: 'compas/campaign/get_generated_contents', target: '#cg_id', selected: campaignData.cg_id ? campaignData.cg_id.split(',') : [] },
                { url: 'compas/campaign/get_content_formats', target: '#cf_id', selected: campaignData.cf_id ? campaignData.cf_id.split(',') : [] },
            ];

            dropDowns.forEach(dropdown => {
                populateDropdown(dropdown.url, dropdown.target, dropdown.selected, 'Pilih...');
            });

            // Populate Teams - Wait, team IDs are stored in campaignData
            // activation_team, content_team etc.
            let teams = [
                { id: 'activation_team', target: '#activation_team' },
                { id: 'content_team', target: '#content_team' },
                { id: 'talent_team', target: '#talent_team' },
                { id: 'distribution_team', target: '#distribution_team' },
                { id: 'optimization_team', target: '#optimization_team' }
            ];

            // Optimize: fetch employees ONCE
            $.ajax({
                url: BASE_URL + 'compas/campaign/get_employees',
                type: 'POST',
                data: { brand_id: campaignData.brand_id },
                dataType: 'json',
                success: function (response) {
                    if (response.data) {
                        teams.forEach(t => {
                            let selected = campaignData[t.id] ? campaignData[t.id].split(',') : [];
                            let options = '';
                            response.data.forEach(item => {
                                let isSelected = selected.includes(String(item.user_id)) ? 'selected' : '';
                                options += `<option value="${item.user_id}" ${isSelected}>${item.employee_name}</option>`;
                            });
                            $(t.target).html(options).trigger("chosen:updated");
                        });
                    }
                }
            });
        }

        // Other fields
        $('#views').val(formatRibuan(campaignData.target_views));
        $('#leads').val(formatRibuan(campaignData.target_leads));
        $('#transaction').val(formatRibuan(campaignData.target_transactions));
        $('#cost_production').val(formatRibuan(campaignData.production_cost));
        $('#cost_placement').val(formatRibuan(campaignData.placement_cost));

        $('#target_audiens_val').val(campaignData.target_audience);
        $('#problem_val').val(campaignData.audience_problem);
        $('#key_message_val').val(campaignData.key_message);
        $('#reason_to_believe_val').val(campaignData.reason_to_believe);
        $('#cta_val').val(campaignData.call_to_action);

        $('#jumlah_konten_internal').val(campaignData.internal_content_target);
        link_referensi_internal.setValue(campaignData.internal_reference_url || '');
        $('#jumlah_konten_eksternal').val(campaignData.external_content_target);
        link_referensi_eksternal.setValue(campaignData.external_reference_url || '');

        // Also update hidden values just in case
        $('#link_referensi_internal_val').val(campaignData.internal_reference_url);
        $('#link_referensi_eksternal_val').val(campaignData.external_reference_url);

        $('#activation_target').val(campaignData.activation_target || 1);
        $('#content_target').val(campaignData.content_target || 1);
        $('#distribution_target').val(campaignData.distribution_target || 1);
        $('#optimization_target').val(campaignData.optimization_target || 1);

        $('#editCampaignModal').modal('show');
    });

    // --- Approve Campaign Handler ---
    $(container).off('click', '#btn-approve-campaign').on('click', '#btn-approve-campaign', function () {
        // Validation: must have AI analysis (or swot-result-container visible)
        if ($('#swot-result-container').is(':hidden')) {
            Swal.fire({
                icon: 'warning',
                title: 'Analysis Required',
                text: 'Please perform AI Analysis before approving the campaign.',
            });
            return;
        }

        let campaignData = $('#campaign-detail-content').data('campaign');
        $('#approve_campaign_id').val(campaignData.campaign_id);

        // Populate Activation Team for Approval
        $.ajax({
            url: BASE_URL + 'compas/campaign/get_employees',
            type: 'POST',
            data: { brand_id: campaignData.brand_id },
            dataType: 'json',
            success: function (response) {
                let optionsActivation = '';
                let optionsContent = '';
                let optionsTalent = '';
                let optionsDistribution = '';
                let optionsOptimization = '';
                let selectedActivationTeam = campaignData.activation_team ? campaignData.activation_team.toString().split(',') : [];
                let selectedContentTeam = campaignData.content_team ? campaignData.content_team.toString().split(',') : [];
                let selectedTalentTeam = campaignData.talent_team ? campaignData.talent_team.toString().split(',') : [];
                let selectedDistributionTeam = campaignData.distribution_team ? campaignData.distribution_team.toString().split(',') : [];
                let selectedOptimizationTeam = campaignData.optimization_team ? campaignData.optimization_team.toString().split(',') : [];

                if (response.data) {
                    response.data.forEach(item => {
                        isSelected = selectedActivationTeam.includes(String(item.user_id)) ? 'selected' : '';
                        optionsActivation += `<option value="${item.user_id}" ${isSelected}>${item.employee_name}</option>`;
                        isSelected = selectedContentTeam.includes(String(item.user_id)) ? 'selected' : '';
                        optionsContent += `<option value="${item.user_id}" ${isSelected}>${item.employee_name}</option>`;
                        isSelected = selectedTalentTeam.includes(String(item.user_id)) ? 'selected' : '';
                        optionsTalent += `<option value="${item.user_id}" ${isSelected}>${item.employee_name}</option>`;
                        isSelected = selectedDistributionTeam.includes(String(item.user_id)) ? 'selected' : '';
                        optionsDistribution += `<option value="${item.user_id}" ${isSelected}>${item.employee_name}</option>`;
                        isSelected = selectedOptimizationTeam.includes(String(item.user_id)) ? 'selected' : '';
                        optionsOptimization += `<option value="${item.user_id}" ${isSelected}>${item.employee_name}</option>`;
                    });
                }
                $('#approve_activation_team').html(optionsActivation).trigger("chosen:updated");
                $('#approve_content_team').html(optionsContent).trigger("chosen:updated");
                $('#approve_talent_team').html(optionsTalent).trigger("chosen:updated");
                $('#approve_distribution_team').html(optionsDistribution).trigger("chosen:updated");
                $('#approve_optimization_team').html(optionsOptimization).trigger("chosen:updated");
            }
        });

        $('#approve_activation_target').val(campaignData.activation_target);

        $('#approveCampaignModal').modal('show');
    });

    // --- Handle Approve Submit ---
    $('#approveCampaignForm').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: BASE_URL + 'compas/campaign/approve_campaign',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === 'success') {
                    $('#approveCampaignModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Approved!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }
        });
    });

    // --- Wizard Logic for Edit Modal ---
    // Note: Assuming Edit Modal has identical structure to Create Wizard
    // We need to re-bind wizard buttons inside the modal if they are not bound globally
    // Since this is inside 'campaign' tab initialization, we bind to #editCampaignModal scope

    $('#editCampaignModal .btn-next').click(function () {
        let currentStep = parseInt($(this).closest('.wizard-step').data('step'));
        let nextStep = currentStep + 1;

        // TODO: Add validation if needed

        $(`#editCampaignModal .wizard-step[data-step="${currentStep}"]`).hide();
        $(`#editCampaignModal .wizard-step[data-step="${nextStep}"]`).fadeIn();

        // Update Progress
        let progress = (nextStep / 5) * 100;
        $('#editCampaignModal .progress-bar').css('width', progress + '%').attr('aria-valuenow', progress);
    });

    $('#editCampaignModal .btn-prev').click(function () {
        let currentStep = parseInt($(this).closest('.wizard-step').data('step'));
        let prevStep = currentStep - 1;

        $(`#editCampaignModal .wizard-step[data-step="${currentStep}"]`).hide();
        $(`#editCampaignModal .wizard-step[data-step="${prevStep}"]`).fadeIn();

        let progress = (prevStep / 5) * 100;
        $('#editCampaignModal .progress-bar').css('width', progress + '%').attr('aria-valuenow', progress);
    });

    // Reset wizard on modal open/close if needed
    $('#editCampaignModal').on('show.bs.modal', function () {
        $('#editCampaignModal .wizard-step').hide();
        $('#editCampaignModal .wizard-step[data-step="1"]').show();
        $('#editCampaignModal .progress-bar').css('width', '20%').attr('aria-valuenow', 20);
    });

    $('#editCampaignForm').on('submit', function (e) {
        e.preventDefault();
        // Similar to Create Campaign but update endpoint
        let formData = new FormData(this);
        let campaignData = $('#campaign-detail-content').data('campaign');
        formData.append('campaign_id', campaignData.campaign_id);

        // Clean currency fields
        let currencyFields = ['views', 'leads', 'transaction', 'cost_production', 'cost_placement'];
        currencyFields.forEach(field => {
            let val = formData.get(field);
            if (val) formData.set(field, val.replace(/\./g, ''));
        });

        $.ajax({
            url: BASE_URL + 'compas/campaign/update_campaign',
            type: 'POST',
            data: formData, // FormData automatically handles serialization with file structure if needed (though here manually appended)
            // Wait, previous Save used FormData. 
            // In Campaign.php we used $this->input->post(), which works with FormData.
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === 'success') {
                    $('#editCampaignModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }
        });
    });

}
