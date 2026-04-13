window.LoadInit = window.LoadInit || {};
window.LoadInit["tabs"] = window.LoadInit["tabs"] || {};
window.LoadInit["tabs"]["optimization"] = function (container) {
  if (
    typeof campaignData !== "undefined" &&
    campaignData.campaign_status == 4
  ) {
    $(".action-restricted").addClass("d-none");
  } else {
    $(".action-restricted").removeClass("d-none");
  }
  function formatRibuan(number) {
    if (number == 0) {
      return "0";
    }
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }
  $(".tanggal").mask("00-00-0000 00:00:00");
  $(".tanggal").datetimepicker({
    format: "Y-m-d H:i:00",
    timepicker: true,
    scrollMonth: false,
    scrollInput: false,
    minDate: 0,
  });

  [view_optimization_desc_instance] = new OverType("#view_optimization_desc", {
    theme: {
      name: "custom-theme",
      colors: {
        bgPrimary: "#015EC2",
        bgSecondary: "#ffffff",
        text: "#0d3b66",
        h1: "#f95738",
        h2: "#ee964b",
        h3: "#3d8a51",
        strong: "#ee964b",
        em: "#f95738",
        link: "#0d3b66",
        code: "#0d3b66",
        codeBg: "rgba(244, 211, 94, 0.2)",
        blockquote: "#5a7a9b",
        hr: "#5a7a9b",
        syntaxMarker: "rgba(13, 59, 102, 0.52)",
        cursor: "#f95738",
        selection: "rgba(1, 94, 194, 0.8)",
      },
    },
    toolbar: false,
    placeholder: "",
    value: "",
  });

  /**
   * Optimization Tab Javascript
   */
  let currentIncomingPage = 1;

  // Load Approved Contents / Strategy
  loadApprovedContents();

  // Event Listener for Plan Content Select
  $("#plan_content_id").on("change", function () {
    let contentId = $(this).val();
    let container = $("#content_detail_container");
    let body = $("#content_detail_body");

    if (contentId) {
      // Show loading or skeleton
      container.removeClass("d-none");
      body.html(
        '<div class="col-12 text-center my-3"><span class="spinner-border spinner-border-sm text-primary"></span> Loading details...</div>',
      );

      $.ajax({
        url: BASE_URL + "compas/distribution/get_content_detail",
        type: "GET",
        data: { id: contentId },
        dataType: "json",
        success: function (response) {
          if (response.status && response.data && response.data.content) {
            let content = response.data.content;

            let html = `
                            <div class="col-md-6 mb-2">
                                <label class="d-block text-muted text-uppercase fw-bold" style="font-size: 10px;">Platform</label>
                                <span class="text-dark fw-bold fs-14">${content.platform_name || "-"}</span>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="d-block text-muted text-uppercase fw-bold" style="font-size: 10px;">Content Format</label>
                                <span class="text-dark fw-bold fs-14">${content.format_name || "-"}</span>
                            </div>
                            
                            <div class="col-12 mt-2">
                                <div class="p-3 bg-white rounded-3 border border-light shadow-sm">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="d-block text-primary text-uppercase fw-bold mb-1" style="font-size: 10px;">Pain Point</label>
                                            <p class="mb-0 text-secondary fs-13">${content.pain_point || "-"}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="d-block text-primary text-uppercase fw-bold mb-1" style="font-size: 10px;">Trigger Emotion</label>
                                            <p class="mb-0 text-secondary fs-13">${content.trigger_emotion || "-"}</p>
                                        </div>
                                        <div class="col-12 border-top pt-2">
                                            <label class="d-block text-success text-uppercase fw-bold mb-1" style="font-size: 10px;">Hook</label>
                                            <p class="mb-0 text-secondary fs-13 fst-italic">"${content.hook || "-"}"</p>
                                        </div>
                                        <div class="col-12 border-top pt-2">
                                            <label class="d-block text-info text-uppercase fw-bold mb-1" style="font-size: 10px;">Script</label>
                                            <div class="text-dark fs-13" style="max-height: 250px; overflow-y: auto;">
                                                ${content.script_content || "-"}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
            body.html(html);
          } else {
            body.html(
              '<div class="col-12 text-center text-muted">No details found.</div>',
            );
          }
        },
        error: function () {
          body.html(
            '<div class="col-12 text-center text-danger">Failed to load details.</div>',
          );
        },
      });
    } else {
      container.addClass("d-none");
      body.empty();
    }
  });

  // Load Optimization Team
  loadOptimizationTeam();

  // Load Optimization Plan Table
  loadOptimizationPlanTable();

  // Load Optimization Log
  loadOptimizationLogs();

  // Load Team Performance
  loadTeamPerformance();

  // Init Comments
  initComments();

  function loadTeamPerformance() {
    let campaignId = $("#detail_id").val();
    $.ajax({
      url: BASE_URL + "compas/optimization/get_team_performance_stats",
      type: "GET",
      data: { campaign_id: campaignId },
      dataType: "json",
      success: function (response) {
        if (response.status) {
          $("#team_efficiency").text(response.data.efficiency + "%");
          $("#team_done").text(
            response.data.total_approved + "/" + response.data.target,
          );
          // Or user asked for: "distribusi yang sudah approved / optimization_target"
          // response.data has { total_approved, target }
        }
      },
    });
  }

  function loadOptimizationPlanTable() {
    $("#dt_optimization_plan").DataTable({
      processing: true,
      searching: true,
      info: true,
      paging: true,
      destroy: true,
      serverSide: false,
      ajax: {
        url: BASE_URL + "compas/optimization/get_optimization_plan",
        type: "POST",
        data: function (d) {
          d.campaign_id = $("#detail_id").val();
        },
      },
      columns: [
        {
          data: "optimization_id",
          render: function (data, type, row) {
            return `${data}`;
          },
        },
        {
          data: "optimization_name",
          render: function (data, type, row) {
            return `
                        <div class="d-flex flex-column">
                            <span class="fs-12 text-dark title mb-1 pb-0 mt-0 pt-0 fw-bold">${row.content_title || "-"}</span>
                            <span class="fs-12 text-dark">${data}</span>
                            <span class="fs-12 text-muted"><i class="bi bi-calendar3 me-1"></i>${row.deadline_optimization || "-"}</span>
                        </div>`;
          },
        },
        {
          data: "created_by_name",
          render: function (data, type, row) {
            let pic = row.profile_picture_team
              ? `${row.profile_picture_team}`
              : `${BASE_URL}hr/uploads/profile/anonim.jpg`;
            return `
                            <div class="avatar avatar-30 rounded-circle border border-white" 
                                 style="width:30px; height:30px;" 
                                 data-bs-toggle="tooltip" 
                                 title="${row.team_name}">
                                <img src="${pic}" class="rounded-circle w-100 h-100" alt="${row.created_by_name}">
                            </div>`;
          },
          className: "text-center",
        },
        {
          data: "sub_status_name",
          render: function (data, type, row) {
            // let badgeClass = 'bg-secondary';
            let statusName = data ? data.toUpperCase() : "";

            let statusBadge = "";

            if (statusName === "APPROVED") {
              statusBadge = `<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2">${statusName}</span>`;
            } else if (statusName === "WAITING") {
              statusBadge = `<span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-2">${statusName}</span>`;
            } else if (statusName === "ON REVIEW") {
              statusBadge = `<span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-2">${statusName}</span>`;
            } else if (statusName === "REJECTED") {
              statusBadge = `<span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2">${statusName}</span>`;
            } else {
              statusBadge = `<span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-2">${statusName}</span>`;
            }
            return statusBadge;
            // return `<span class="badge ${badgeClass}">${data || 'Pending'}</span>`;
          },
          className: "text-center",
        },
        {
          data: "viability_score",
          render: function (data, type, row) {
            let badgeClass = "bg-secondary";
            let status = data ? data.toLowerCase() : "";

            // HIGH >= 80
            // MEDIUM >= 60
            // LOW < 60

            if (data >= 80)
              badgeClass =
                "badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2";
            else if (data >= 60)
              badgeClass =
                "badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-2";
            else
              badgeClass =
                "badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2";

            return `<span class="badge ${badgeClass}">${data || "-"}</span>`;
          },
          className: "text-center",
        },
        {
          data: "optimization_id",
          className: "text-end pe-4",
          orderable: false,
          render: function (data, type, row) {
            // jika sudah approve tidak bisa edit dan delete
            let editBtn = "";
            let deleteBtn = "";
            // Status: 3 = Approved, 4 = Rejected.
            // Allow edit for Draft (1), Review (2), Revision (5).
            // Block edit for Approved (3) and Rejected (4).
            if (row.status != 3 && row.status != 4) {
              editBtn = `<button class="btn btn-sm btn-link text-muted shadow-none btn-edit-plan" data-id="${row.optimization_id}" data-bs-toggle="tooltip" title="Edit Plan">
                                <i class="bi bi-pencil-square"></i>
                            </button>`;
              deleteBtn = `<button class="btn btn-sm btn-link text-danger shadow-none btn-delete-plan" data-id="${row.optimization_id}" data-bs-toggle="tooltip" title="Delete Plan">
                                <i class="bi bi-trash"></i>
                            </button>`;
            }
            return `
                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn btn-sm btn-link text-muted shadow-none btn-view-plan-optimization" data-id="${row.optimization_id}" data-bs-toggle="tooltip" title="View Detail">
                                <i class="bi bi-eye"></i>
                            </button>
                            ${editBtn}
                        </div>`;
          },
        },
      ],
      language: {
        emptyTable: "No optimization plans found",
        zeroRecords: "No matching records found",
      },
      dom: "t",
      paging: false,
      info: false,
    });

    $("#dt_optimization_plan").on("draw.dt", function () {
      var tooltipTriggerList = [].slice.call(
        document.querySelectorAll(
          '#dt_optimization_plan [data-bs-toggle="tooltip"]',
        ),
      );
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });
  }

  // View Plan Detail Logic
  $(document)
    .off("click", ".btn-view-plan-optimization")
    .on("click", ".btn-view-plan-optimization", function () {
      let id = $(this).data("id");

      console.log(id);
      // Reset Modal
      $("#ai_analysis_empty").removeClass("d-none");
      $("#ai_analysis_content").addClass("d-none");
      $("#view_plan_assigned .avatar-group").empty();
      $("#btnOptimizationApprovePlan")
        .prop("disabled", true)
        .data("id", id)
        .html('<i class="bi bi-check-circle me-2"></i>Approve Plan');

      // Reset/Dummy loader
      $("#view_plan_id").text("Loading...");

      $.ajax({
        url: BASE_URL + "compas/optimization/get_optimization_detail/" + id,
        type: "GET",
        dataType: "json",
        success: function (response) {
          if (response.status) {
            let data = response.data;

            // Populate basic fields
            $("#view_optimization_id").text("#TASK-" + data.optimization_id);
            $("#view_category").text("Optimization Content");
            $("#view_plan_duedate").text(
              data.deadline_publish_formatted || "-",
            );
            $("#view_detail_content").text(
              data.content_title || "No title available.",
            );
            $("#view_optimization_name").text(
              data.optimization_name || "No name available.",
            );

            // OverType Preview
            if (typeof view_optimization_desc_instance !== "undefined") {
              view_optimization_desc_instance.setValue(
                data.optimization_desc || "",
              );
            }

            // Priority Badge
            let statusName = data.sub_status_name
              ? data.sub_status_name.toUpperCase()
              : "PENDING";
            let badgeClass = "bg-warning-soft text-warning";
            if (statusName.includes("HIGH") || statusName.includes("URGENT"))
              badgeClass = "bg-danger-soft text-danger";
            else if (statusName.includes("LOW") || statusName.includes("DONE"))
              badgeClass = "bg-success-soft text-success";
            else if (statusName.includes("APPROVED"))
              badgeClass = "bg-success-soft text-success";

            $("#view_plan_priority")
              .attr("class", `badge ${badgeClass} px-3 rounded-pill`)
              .text(statusName);

            // Additional Details
            $("#view_plan_opt_budget_allocation").text(
              formatRibuan(data.opt_budget_allocation) || "-",
            );
            $("#view_plan_deadline").text(data.deadline_optimization || "-");

            // Populate Assigned Team
            if (data.profile_picture_team) {
              let pics = data.profile_picture_team;
              let names = data.team_name ? data.team_name.split(",") : [];
              let html = "";

              pics.forEach((pic, index) => {
                let name = names[index] || "User";
                let src = pic;
                if (pic.indexOf("http") === -1)
                  src = `${BASE_URL}uploads/users/${pic}`;

                html += `<div class="col-auto me-2 mb-2 badge bg-light text-dark rounded-pill d-flex align-items-center gap-2">
                            <div class="avatar avatar-30 rounded-circle border border-white" data-bs-toggle="tooltip" title="${name}">
                                <img src="${src}" class="rounded-circle w-100 h-100" alt="${name}">
                            </div> <span class="me-2">${name}</span></div>`;
              });

              $("#view_plan_assigned .avatar-group").html(html);
              // Re-init tooltips inside modal
              $(
                '#viewPlanOptimizationModal [data-bs-toggle="tooltip"]',
              ).tooltip();
            } else {
              $("#view_plan_assigned .avatar-group").html(
                '<span class="text-muted small">Unassigned</span>',
              );
            }

            // Populate Activity Log
            if (response.logs && response.logs.length > 0) {
              let logsHtml = "";
              response.logs.forEach((log) => {
                let color = "primary";
                if (log.action_type === "STATUS_CHANGE") color = "info";
                else if (log.action_type === "CREATED") color = "success";
                else if (log.action_type === "UPDATED")
                  color = "warning text-dark";

                logsHtml += `
                            <div class="position-relative ps-4 mb-3">
                                <div class="position-absolute top-0 start-0 translate-middle-x bg-${color} rounded-circle border border-white"
                                    style="width: 12px; height: 12px; margin-top: 6px; margin-left: -1px;"></div>
                                <p class="mb-1 small text-dark"><span class="fw-bold">${log.user_name}</span> ${log.description}</p>
                                <span class="text-muted small" style="font-size: 11px;">${log.time_ago}</span>
                            </div>`;
              });
              // Add container if not exists or replace content
              $(".timeline-sm").html(logsHtml);
            } else {
              $(".timeline-sm").html(
                '<p class="text-muted small fst-italic ps-3">No activity yet.</p>',
              );
            }

            // Button Visibility Logic
            $("#btnCancelApprove").addClass("d-none");
            $("#btnOptimizationRejectPlan").removeClass("d-none");
            $("#btnOptimizationApprovePlan")
              .removeClass("d-none")
              .prop("disabled", true)
              .html('<i class="bi bi-check-circle me-2"></i>Approve Plan');

            // Check if already approved (status == 3)
            if (data.status == 3) {
              $("#btnOptimizationApprovePlan").addClass("d-none");
              $("#btnOptimizationRejectPlan").addClass("d-none");
              $("#btnCancelApprove").removeClass("d-none");
            } else {
              // Pending / Draft
              $("#btnOptimizationApprovePlan").prop("disabled", true);
            }

            // Populate AI Analysis if exists
            if (response.analysis) {
              let analysis = response.analysis;
              // Support both formats if backend sends mixed (object vs string wrapper)
              if (analysis.analysis_json) {
                if (typeof analysis.analysis_json === "string") {
                  analysis = JSON.parse(analysis.analysis_json);
                } else {
                  analysis = analysis.analysis_json;
                }
              }

              // Handle array wrap from n8n
              if (Array.isArray(analysis)) analysis = analysis[0];

              // 1. Viability Score
              let score = 0;
              if (
                analysis.viability_analysis &&
                analysis.viability_analysis.score
              ) {
                score = analysis.viability_analysis.score;
              }
              $("#ai_score").text(score);

              // Colorize score
              $("#ai_score").removeClass(
                "text-success text-warning text-danger",
              );
              if (score >= 80) $("#ai_score").addClass("text-success");
              else if (score >= 60) $("#ai_score").addClass("text-warning");
              else $("#ai_score").addClass("text-danger");

              // Justification
              if (
                analysis.viability_analysis &&
                analysis.viability_analysis.justification
              ) {
                $("#ai_justification").text(
                  analysis.viability_analysis.justification,
                );
              } else {
                $("#ai_justification").text("No justification provided.");
              }

              // 2. Pros / Strengths
              let strengthsHtml = "";
              if (
                analysis.pros_strengths &&
                Array.isArray(analysis.pros_strengths)
              ) {
                analysis.pros_strengths.forEach((item) => {
                  strengthsHtml += `<li class="mb-1"><i class="bi bi-check-circle-fill text-success me-2"></i>${item}</li>`;
                });
              }
              $("#ai_strengths_list").html(
                strengthsHtml ||
                  '<li class="text-muted">No specific strengths detected.</li>',
              );

              // 3. Risks / Bottlenecks
              let risksHtml = "";
              if (
                analysis.risks_bottlenecks &&
                Array.isArray(analysis.risks_bottlenecks)
              ) {
                analysis.risks_bottlenecks.forEach((item) => {
                  risksHtml += `<li class="mb-1"><i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>${item}</li>`;
                });
              }
              $("#ai_risks_list").html(
                risksHtml ||
                  '<li class="text-muted">No specific risks detected.</li>',
              );

              // 4. Recommendations
              let recHtml = "";
              if (
                analysis.recommendations &&
                Array.isArray(analysis.recommendations)
              ) {
                analysis.recommendations.forEach((item) => {
                  recHtml += `<li class="mb-1"><i class="bi bi-lightbulb-fill text-success me-2"></i>${item}</li>`;
                });
                $("#ai_rec").html(
                  recHtml ||
                    '<li class="text-muted">No specific recommendations detected.</li>',
                );
              }

              // 5. Optimization Example
              if (analysis.optimization_example) {
                $("#ai_opt_before").text(
                  analysis.optimization_example.before || "-",
                );
                $("#ai_opt_after").text(
                  analysis.optimization_example.after || "-",
                );
                $("#ai_opt_reason").text(
                  analysis.optimization_example.reason || "-",
                );
              }

              // Show Content
              $("#ai_analysis_empty").addClass("d-none");
              $("#ai_analysis_content").removeClass("d-none");

              // Button State -> Re-Analyze
              $("#btn_optimization_run_analysis")
                .html('<i class="bi bi-arrow-repeat me-2"></i>Re-Analyze')
                .data("reanalyze", true)
                .removeClass("btn-primary")
                .addClass("btn-outline-primary");
            } else {
              // Reset if no analysis
              $("#ai_analysis_empty").removeClass("d-none");
              $("#ai_analysis_content").addClass("d-none");
              $("#btn_optimization_run_analysis")
                .html('<i class="bi bi-cpu me-2"></i>Run AI Analysis')
                .data("reanalyze", false)
                .removeClass("btn-outline-primary")
                .addClass("btn-primary");
            }

            $("#btnOptimizationApprovePlan").prop("disabled", false);

            // Show Modal
            $("#viewPlanOptimizationModal").modal("show");
          } else {
            Swal.fire("Error", "Failed to fetch plan details", "error");
          }
        },
        error: function () {
          Swal.fire("Error", "Server Error", "error");
        },
      });
    });

  // Run AI Analysis
  $(document)
    .off("click", "#btn_optimization_run_analysis,#btn_optimization_reanalyze")
    .on(
      "click",
      "#btn_optimization_run_analysis,#btn_optimization_reanalyze",
      function () {
        let btn = $(this);
        let id = $("#btnOptimizationApprovePlan").data("id"); // Get optimization ID from the approve button
        let originalText = btn.html();
        let isReAnalyze =
          btn.data("reanalyze") === true ||
          btn.attr("id") === "btn_optimization_reanalyze";

        btn
          .prop("disabled", true)
          .html(
            '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Analyzing...',
          );

        $.ajax({
          url: BASE_URL + "compas/optimization/analysis_ai",
          type: "POST",
          data: { optimization_id: id, re_analyze: isReAnalyze },
          dataType: "json",
          success: function (response) {
            btn.prop("disabled", false).html(originalText);

            if (response.status === true) {
              let data = response.data;
              let analysis = data.analysis_json || data; // Handle if wrapped or direct

              // If backend sends it as string inside data.data (due to my previous controller logic), parse it
              // But controller now sends `data` as the object.
              // The object structure from n8n matches:
              // { viability_analysis: {...}, pros_strengths: [...], ... }

              // 1. Viability Score
              let score = 0;
              if (
                analysis.viability_analysis &&
                analysis.viability_analysis.score
              ) {
                score = analysis.viability_analysis.score;
              }
              $("#ai_score").text(score);

              // Colorize score
              $("#ai_score").removeClass(
                "text-success text-warning text-danger",
              );
              if (score >= 80) $("#ai_score").addClass("text-success");
              else if (score >= 60) $("#ai_score").addClass("text-warning");
              else $("#ai_score").addClass("text-danger");

              // Justification
              if (
                analysis.viability_analysis &&
                analysis.viability_analysis.justification
              ) {
                $("#ai_justification").text(
                  analysis.viability_analysis.justification,
                );
              } else {
                $("#ai_justification").text("No justification provided.");
              }

              // 2. Pros / Strengths
              let strengthsHtml = "";
              if (
                analysis.pros_strengths &&
                Array.isArray(analysis.pros_strengths)
              ) {
                analysis.pros_strengths.forEach((item) => {
                  strengthsHtml += `<li class="mb-1"><i class="bi bi-check-circle-fill text-success me-2"></i>${item}</li>`;
                });
              }
              $("#ai_strengths_list").html(
                strengthsHtml ||
                  '<li class="text-muted">No specific strengths detected.</li>',
              );

              // 3. Risks / Bottlenecks
              let risksHtml = "";
              if (
                analysis.risks_bottlenecks &&
                Array.isArray(analysis.risks_bottlenecks)
              ) {
                analysis.risks_bottlenecks.forEach((item) => {
                  risksHtml += `<li class="mb-1"><i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>${item}</li>`;
                });
              }
              $("#ai_risks_list").html(
                risksHtml ||
                  '<li class="text-muted">No specific risks detected.</li>',
              );

              // 4. Recommendations
              let recHtml = "";
              if (
                analysis.recommendations &&
                Array.isArray(analysis.recommendations)
              ) {
                analysis.recommendations.forEach((recomen) => {
                  recHtml += `<li class="mb-1"><i class="bi bi-lightbulb-fill text-success me-2"></i>${recomen}</li>`;
                });
                $("#ai_rec").html(
                  recHtml ||
                    '<li class="text-muted">No specific recommendations detected.</li>',
                );
              }

              // 5. Optimization Example
              if (analysis.optimization_example) {
                $("#ai_opt_before").text(
                  analysis.optimization_example.before || "-",
                );
                $("#ai_opt_after").text(
                  analysis.optimization_example.after || "-",
                );
                $("#ai_opt_reason").text(
                  analysis.optimization_example.reason || "-",
                );
              }

              // Show Content
              $("#ai_analysis_empty").addClass("d-none");
              $("#ai_analysis_content")
                .removeClass("d-none")
                .addClass("fade-in");

              // Enable Approve Plan if not already approved
              if (data.status != 3) {
                $("#btnOptimizationApprovePlan").prop("disabled", false);
              }

              // Change button to Re-Analyze
              btn.html('<i class="bi bi-arrow-repeat me-2"></i>Re-Analyze');
              btn.data("reanalyze", true);
              btn.removeClass("btn-primary").addClass("btn-outline-primary");

              // Enable Approve Button if not approved
              let isApproved = $("#btnOptimizationApprovePlan")
                .text()
                .includes("Approved");
              if (!isApproved) {
                $("#btnOptimizationApprovePlan").prop("disabled", false);
              }
            } else {
              Swal.fire(
                "Error",
                response.message || "Failed to analyze.",
                "error",
              );
            }
          },
          error: function () {
            btn.prop("disabled", false).html(originalText);
            Swal.fire("Error", "Server Error", "error");
          },
        });
      },
    );

  // Approve Plan Logic
  $(document)
    .off("click", "#btnOptimizationApprovePlan")
    .on("click", "#btnOptimizationApprovePlan", function () {
      let id = $(this).data("id");
      let target = campaignData.optimization_target;
      let btn = $(this);

      Swal.fire({
        title: "Approve Optimization Plan?",
        text: "This action will update the status to Approved.",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, approve it!",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: BASE_URL + "compas/optimization/approve_optimization_plan",
            type: "POST",
            data: { id: id, target: target },
            dataType: "json",
            beforeSend: function () {},
            success: function (response) {
              if (response.status) {
                Swal.fire(
                  "Approved!",
                  "The optimization plan has been approved.",
                  "success",
                ).then(() => {
                  $("#viewPlanOptimizationModal").modal("hide");
                  loadOptimizationPlanTable(); // Reload table
                  loadTeamPerformance();
                  loadOptimizationLogs();
                });
              } else {
                Swal.fire("Error", response.message, "error");
                btn
                  .prop("disabled", false)
                  .html('<i class="bi bi-check-circle me-2"></i>Approve Plan');
              }
            },
            error: function () {
              Swal.fire("Error", "Server Error", "error");
              btn
                .prop("disabled", false)
                .html('<i class="bi bi-check-circle me-2"></i>Approve Plan');
            },
          });
        }
      });
    });

  // Cancel Approval
  $(document)
    .off("click", "#btnCancelApprove")
    .on("click", "#btnCancelApprove", function () {
      let id = $("#btnOptimizationApprovePlan").data("id");
      let target = campaignData.optimization_target;
      Swal.fire({
        title: "Are you sure?",
        text: "This will revert the plan status to Draft/In Progress.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, cancel approval!",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: BASE_URL + "compas/optimization/cancel_approve_plan",
            type: "POST",
            data: { id: id, target: target },
            dataType: "json",
            success: function (response) {
              if (response.status) {
                Swal.fire(
                  "Success",
                  "Approval cancelled successfully",
                  "success",
                );
                $("#viewPlanOptimizationModal").modal("hide");
                loadOptimizationPlanTable();
                loadTeamPerformance();
                loadApprovedContents();
                loadTeamPerformance();
              } else {
                Swal.fire("Error", response.message, "error");
              }
            },
          });
        }
      });
    });

  // Revise / Reject Plan
  $(document)
    .off("click", "#btnOptimizationRejectPlan")
    .on("click", "#btnOptimizationRejectPlan", function () {
      let id = $("#btnOptimizationApprovePlan").data("id");
      let target = campaignData.optimization_target;
      Swal.fire({
        title: "Revise / Reject Plan",
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
        confirmButtonText: "Submit",
        showLoaderOnConfirm: true,
        preConfirm: () => {
          const status = document.querySelector(
            'input[name="reject_action"]:checked',
          ).value;
          const note = document.getElementById("reject_note").value;

          return $.ajax({
            url: BASE_URL + "compas/optimization/reject_plan",
            type: "POST",
            data: { id: id, note: note, status: status, target: target },
            dataType: "json",
          })
            .then((response) => {
              if (!response.status) {
                throw new Error(response.message || "Request failed");
              }
              return response;
            })
            .catch((error) => {
              Swal.showValidationMessage(`Request failed: ${error}`);
            });
        },
        allowOutsideClick: () => !Swal.isLoading(),
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire(
            "Success",
            result.value.message || "Plan updated successfully",
            "success",
          );
          $("#viewPlanOptimizationModal").modal("hide");
          loadOptimizationPlanTable();
          loadTeamPerformance();
          loadOptimizationLogs();
          if (typeof loadTeamPerformance === "function") {
            loadTeamPerformance();
          }
        }
      });
    });

  // Invite Team Modal Logic
  $("#inviteTeamOptimizationModal").on("show.bs.modal", function () {
    loadEmployeesForInvite();
  });

  $("#btnSaveTeam").on("click", function () {
    saveOptimizationTeam();
  });

  // Initialize tooltips if any
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]'),
  );
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Initialize Chosen JS
  if ($(".chosen-select").length > 0) {
    $(".chosen-select").chosen({
      width: "100%",
      placeholder_text_single: "Select an option",
      no_results_text: "Oops, nothing found!",
    });
  }

  // Re-init Chosen when modal is shown (fix for Select width 0)
  $("#addOptimizationPlanModal, #inviteTeamOptimizationModal").on(
    "shown.bs.modal",
    function () {
      $(".chosen-select", this).chosen("destroy").chosen({
        width: "100%",
        placeholder_text_single: "Select an option",
        placeholder_text_multiple: "Choose options",
        no_results_text: "Oops, nothing found!",
      });
    },
  );

  // Strategy Pagination
  $(document)
    .off("click", ".strategy-page-link")
    .on("click", ".strategy-page-link", function (e) {
      e.preventDefault();
      const page = $(this).data("page");
      if (page) {
        currentIncomingPage = page;
        loadApprovedContents(currentIncomingPage);
      }
    });

  // View Strategy Details
  $(document)
    .off("click", ".view-strategy-btn")
    .on("click", ".view-strategy-btn", function () {
      const id = $(this).data("id");
      viewStrategyDetail(id);
    });

  // Dummy Handler for Add Task
  $(document)
    .off("click", ".btn-add-task")
    .on("click", ".btn-add-task", function () {
      alert("Add Task Modal would open here.");
    });

  // Dummy Chat Send Handler
  $(document)
    .off("click", ".btn-send-message")
    .on("click", ".btn-send-message", function () {
      const input = $(this).closest(".input-group").find("input");
      const message = input.val().trim();
      if (message) {
        // Append message logic would go here
        // console.log("Sending: " + message);
        input.val("");

        // Scroll to bottom
        const chatContainer = $(".chat-container");
        chatContainer.scrollTop(chatContainer.prop("scrollHeight"));
      }
    });

  // Make chat container scroll to bottom on load
  const chatContainer = $(".chat-container");
  if (chatContainer.length) {
    chatContainer.scrollTop(chatContainer.prop("scrollHeight"));
  }

  function loadApprovedContents(page = 1) {
    const campaignId = $("#detail_id").val();

    // Show skeleton/loading state
    $("#incoming-briefs-container").html(`
                        <div class="d-flex align-items-center justify-content-center p-4">
                            <div class="spinner-border text-purple" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    `);

    $.ajax({
      url: BASE_URL + "compas/Optimization/get_approved_contents",
      type: "GET",
      data: { campaign_id: campaignId, page: page },
      dataType: "json",
      success: function (response) {
        if (response.status && response.data.length > 0) {
          let html = "";
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
                                                        <span class="badge bg-light-purple text-purple border-purple">${item.platform_name || "N/A"}</span>
                                                        <span class="badge bg-light-purple text-purple border-purple">${item.placement_name || "N/A"}</span>
                                                        <span class="badge bg-light-purple text-purple border-purple">${item.content_pillar_name || "N/A"}</span>
                                                        <small class="text-secondary opacity-75">${item.deadline_publish_formatted || ""}</small>
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

            const prevDisabled =
              response.pagination.current_page == 1 ? "disabled" : "";
            html += `<li class="page-item ${prevDisabled}">
                                <a class="page-link strategy-page-link" href="#" data-page="${response.pagination.current_page - 1}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>`;

            for (let i = 1; i <= response.pagination.total_pages; i++) {
              const active =
                i == response.pagination.current_page ? "active" : "";
              html += `<li class="page-item ${active}"><a class="page-link strategy-page-link" href="#" data-page="${i}">${i}</a></li>`;
            }

            const nextDisabled =
              response.pagination.current_page ==
              response.pagination.total_pages
                ? "disabled"
                : "";
            html += `<li class="page-item ${nextDisabled}">
                                <a class="page-link strategy-page-link" href="#" data-page="${response.pagination.current_page + 1}" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>`;

            html += `   </ul>
                                </nav>
                            </div>`;
          }

          $("#incoming-briefs-container").html(html);

          // Show the parent card if hidden
          $("#incoming-briefs-card").show();
        } else {
          $("#incoming-briefs-container").html(
            '<p class="text-muted text-center small my-3">No approved strategies found for this campaign.</p>',
          );
        }
      },
      error: function (xhr, status, error) {
        console.error("Error loading strategies:", error);
        $("#incoming-briefs-container").html(
          '<p class="text-danger text-center small my-3">Failed to load strategies.</p>',
        );
      },
    });
  }

  function viewStrategyDetail(id) {
    // Show modal
    var modal = new bootstrap.Modal(
      document.getElementById("approvedContentOptimizationDetailModal"),
    );
    modal.show();

    // Show loading
    $("#approvedContentOptimizationDetailContent").html(`
                        <div class="text-center py-5">
                            <div class="spinner-border text-purple" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 text-purple small">Loading details...</p>
                        </div>
                    `);

    $.ajax({
      url: BASE_URL + "compas/Optimization/get_content_detail",
      type: "GET",
      data: { id: id },
      dataType: "json",
      success: function (response) {
        if (response.status) {
          const data = response.data;
          const camp = data.campaign;
          const cont = data.content;

          // check platform_name if there is comma then explode and create ordered list
          if (cont.platform_name.includes(",")) {
            const platform_name = cont.platform_name.split(",");
            let platform_name_html = "<ol>";
            platform_name.forEach(function (item) {
              platform_name_html += `<li class="text-dark mb-0 text-justify fs-14">${item}</li>`;
            });
            platform_name_html += "</ol>";
            cont.platform_name = platform_name_html;
          }

          const html = `
                                <p class="title fw-medium">Campaign Info</p>
                                <div class="row">
                                    <div class="col-8">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Campaign Name</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${camp.campaign_name || "-"}</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Periode Campaign</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${camp.campaign_period || "-"}</p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Campaign Description</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${camp.campaign_desc || "-"}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Target Audience</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${camp.target_audience || "-"}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Key Message</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${camp.key_message || "-"}</p>
                                        </div>
                                    </div>
                                    </div>

                                    <p class="title fw-medium">Event Activation</p>
                                    <div class="row">
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Strategy Title</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.activation_title || "-"}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Strategy Description</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.activation_description || "-"}</p>
                                        </div>
                                    </div>
                                </div>

                                <p class="title fw-medium">Content</p>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Content Title</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.title || "-"}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Content Pillar</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.content_pillar_name || "-"}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Content Hook</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.hook || "-"}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Content Format</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.format_name || "-"}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Deadline Publish</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.deadline_publish_formatted || "-"}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Pain Point</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.pain_point || "-"}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Trigger Emotion</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.trigger_emotion || "-"}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Consumption Behavior</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.consumption_behavior || "-"}</p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="py-2">
                                            <label class="fw-bold text-muted d-block mb-1 fs-10 text-uppercase">Script Content</label>
                                            <p class="text-dark mb-0 text-justify fs-14">${cont.script_content || "-"}</p>
                                        </div>
                                    </div>
                                </div>
                            `;
          $("#approvedContentOptimizationDetailContent").html(html);
        } else {
          $("#approvedContentOptimizationDetailContent").html(
            '<div class="alert alert-danger border-0 shadow-sm text-center">Failed to load details.</div>',
          );
        }
      },
      error: function () {
        $("#approvedContentOptimizationDetailContent").html(
          '<div class="alert alert-danger border-0 shadow-sm text-center">Error communicating with server.</div>',
        );
      },
    });
  }

  function loadOptimizationTeam() {
    const campaignId = $("#detail_id").val();
    $.ajax({
      url: BASE_URL + "compas/optimization/get_optimization_team",
      type: "GET",
      data: { campaign_id: campaignId },
      dataType: "json",
      success: function (response) {
        if (response.status) {
          const team = response.data;
          let html = "";
          if (team.profile_picture_team) {
            const pics = team.profile_picture_team;
            // check if there is , in team_name
            if (team.team_name !== null) {
              if (team.team_name.includes(",")) {
                const names = team.team_name.split(",");
              } else {
                const names = team.team_name;
              }
            } else {
              const names = [];
            }
            pics.forEach((pic, index) => {
              html += `
                            <figure class="avatar avatar-40 rounded-circle coverimg overlay-ms-15" data-bs-toggle="tooltip" data-bs-placement="top" title="${names[index] || "-"}" style="background-image: url('${BASE_URL}uploads/users/${pic}');">
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
            $("#avatar-optimization-team").empty().append(html);

            // Re-init tooltips
            var tooltipTriggerList = [].slice.call(
              document.querySelectorAll('[data-bs-toggle="tooltip"]'),
            );
            var tooltipList = tooltipTriggerList.map(
              function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
              },
            );
          }
        }
      },
    });
  }

  function loadEmployeesForInvite() {
    const campaignId = $("#detail_id").val();
    // First get current team to pre-select
    $.ajax({
      url: BASE_URL + "compas/optimization/get_optimization_team",
      type: "GET",
      data: { campaign_id: campaignId },
      dataType: "json",
      success: function (teamResponse) {
        let currentTeamIds = [];
        if (
          teamResponse.status &&
          teamResponse.data &&
          teamResponse.data.optimization_team
        ) {
          currentTeamIds = teamResponse.data.optimization_team.split(",");
        }

        // Then get all employees
        $.ajax({
          url: BASE_URL + "compas/optimization/get_employees",
          type: "GET",
          dataType: "json",
          success: function (response) {
            if (response.status) {
              let options = "";
              response.data.forEach((user) => {
                const selected = currentTeamIds.includes(user.user_id)
                  ? "selected"
                  : "";
                options += `<option value="${user.user_id}" ${selected}>${user.full_name}</option>`;
              });
              $("#invite_team_select").html(options);
              $("#invite_team_select").trigger("chosen:updated");
            }
          },
        });
      },
    });
  }

  function saveOptimizationTeam() {
    const campaignId = $("#detail_id").val();
    const selectedTeam = $("#invite_team_select").val();

    $.ajax({
      url: BASE_URL + "compas/optimization/save_optimization_team",
      type: "POST",
      data: {
        campaign_id: campaignId,
        team: selectedTeam,
      },
      dataType: "json",
      success: function (response) {
        if (response.status) {
          // Close modal
          const modalEl = document.getElementById(
            "inviteTeamOptimizationModal",
          );
          const modal = bootstrap.Modal.getInstance(modalEl);
          modal.hide();

          // Reload team display
          loadOptimizationTeam();
          loadOptimizationLogs();
        } else {
          alert("Failed to update team: " + response.message);
        }
      },
      error: function () {
        alert("Error processing request");
      },
    });
  }

  // Plan Modal Logic
  // Plan Modal Logic
  // $('#addOptimizationPlanModal').on('show.bs.modal', function () {
  //    loadPlanOptions();
  // });
  // Removed to allow manual control over when options are loaded (specifically for Edit)

  $("#btnSavePlan").on("click", function () {
    saveOptimizationPlan();
  });

  // Surprise Me Logic (AI Generated)
  $(document)
    .off("click", "#btnSurpriseMe")
    .on("click", "#btnSurpriseMe", function () {
      // Collect Context
      let selectedContentId = $("#plan_content_id").val();
      let selectedContentText = "";

      if (!selectedContentId) {
        Swal.fire({
          icon: "warning",
          title: "No Content Selected",
          text: "Please select a content first to generate an optimization plan.",
          timer: 2000,
          showConfirmButton: false,
        });
        return;
      }

      if (selectedContentId) {
        selectedContentText = $("#plan_content_id option:selected").text();
      }

      Swal.fire({
        title: "Generate Optimization Plan with AI",
        input: "text",
        inputLabel: "Goal / Focus / Constraint (Optional)",
        inputPlaceholder:
          "e.g., Fokus ke peningkatan engagement, Budget di bawah 500rb",
        showCancelButton: true,
        confirmButtonText: "Generate",
        showLoaderOnConfirm: true,
        preConfirm: (prompt) => {
          return $.ajax({
            url: BASE_URL + "compas/optimization/generate_ai_optimization_plan",
            type: "POST",
            data: {
              user_prompt: prompt,
              content_context: selectedContentText,
              content_id: $("#plan_content_id").val(),
            },
            dataType: "json",
          })
            .then((response) => {
              if (!response.status) {
                throw new Error(response.message || "AI Generation failed");
              }
              return response.data;
            })
            .catch((error) => {
              Swal.showValidationMessage(`Request failed: ${error}`);
            });
        },
        allowOutsideClick: () => !Swal.isLoading(),
      }).then((result) => {
        if (result.isConfirmed) {
          const data = result.value;

          // 1. Inputs
          $("#plan_optimization_name")
            .val(data.optimization_name || "")
            .trigger("chosen:updated");
          $("#plan_cost").val(formatRibuan(data.opt_budget_allocation || 0));
          $("#plan_deadline").val(
            data.deadline_optimization ||
              moment().add(3, "days").format("YYYY-MM-DD HH:mm:00"),
          );

          $("#optimization_desc_val").val("");

          Swal.fire({
            icon: "success",
            title: "Generated!",
            text: "Optimization plan has been generated with AI.",
            timer: 1500,
            showConfirmButton: false,
          });
        }
      });
    });

  function loadPlanOptions() {
    const campaignId = $("#detail_id").val();
    $("#plan_campaign_id").val(campaignId);

    return $.ajax({
      url: BASE_URL + "compas/optimization/get_plan_options",
      type: "GET",
      data: { campaign_id: campaignId },
      dataType: "json",
      success: function (response) {
        console.log(response);
        if (response.status == true) {
          const contents = response.data.contents;

          console.log(contents);
          // Contents
          let contentOptions = '<option value=""></option>';
          contents.forEach((content) => {
            contentOptions += `<option value="${content.content_id}">${content.title}</option>`;
          });
          $("#plan_content_id").html(contentOptions);

          // Trigger Chosen update
          $("#plan_content_id").trigger("chosen:updated");
        }
      },
    });
  }

  function saveOptimizationPlan() {
    // Validation
    let requiredFields = [
      { id: "plan_content_id", name: "Content" },
      { id: "plan_optimization_name", name: "Optimization Name" },
      { id: "plan_cost", name: "Ads Budget Allocation" },
      { id: "plan_deadline", name: "Deadline Optimization" },
    ];

    for (let field of requiredFields) {
      let val = $("#" + field.id).val();
      // Handle array for chosen multiple or simple string
      if (
        !val ||
        (Array.isArray(val) && val.length === 0) ||
        (typeof val === "string" && val.trim() === "")
      ) {
        Swal.fire({
          icon: "warning",
          title: "Incomplete Form",
          text: "Please fill in the " + field.name + " field.",
          confirmButtonColor: "#3085d6",
        });
        return;
      }
    }

    const formData = $("#formAddPlan").serialize();

    $.ajax({
      url: BASE_URL + "compas/optimization/save_optimization_plan",
      type: "POST",
      data: formData,
      dataType: "json",
      success: function (response) {
        if (response.status) {
          Swal.fire({
            icon: "success",
            title: "Success",
            text: response.message,
            showConfirmButton: false,
            timer: 1500,
          }).then(() => {
            $("#addOptimizationPlanModal").modal("hide");
            $("#formAddPlan")[0].reset();
            $("#plan_activation_id").val("").trigger("chosen:updated");
            loadOptimizationPlanTable();
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: response.message,
          });
        }
      },
      error: function () {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "An error occurred while saving the plan.",
        });
      },
    });
  }

  // Helper for currency format (global scope or attached to window if needed by onkeyup)
  window.formatRupiah = function (element) {
    let value = element.value.replace(/[^,\d]/g, "").toString();
    let split = value.split(",");
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
      let separator = sisa ? "." : "";
      rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    element.value = rupiah;
  };

  // Add Plan Button Logic
  $("#btnAddPlanOptimization").on("click", function () {
    loadPlanOptions();
    $("#formAddPlan")[0].reset();
    $("#plan_optimization_id").val("");
    $("#addOptimizationPlanModalLabel").text("Add Optimization Plan");
    $("#btnSavePlan").html("Create Plan");
    $("#content_detail_container").addClass("d-none");

    // Reset Chosen & OverType
    $("#plan_content_id").val("").trigger("chosen:updated");
    if (typeof optimization_desc !== "undefined") {
      optimization_desc.setValue("");
      $("#optimization_desc_val").val("");
    }
  });

  // Edit Plan Logic
  $(document)
    .off("click", ".btn-edit-plan")
    .on("click", ".btn-edit-plan", function () {
      let id = $(this).data("id");

      $.ajax({
        url: BASE_URL + "compas/optimization/get_optimization_detail/" + id,
        type: "GET",
        dataType: "json",
        success: function (response) {
          if (response.status) {
            // Load plan options explicitly before populating
            loadPlanOptions().then(() => {
              let data = response.data;

              // Populate Form
              $("#plan_optimization_id").val(data.optimization_id);
              $("#plan_campaign_id").val(data.campaign_id);
              $("#plan_content_id")
                .val(data.content_id)
                .trigger("chosen:updated");

              $("#plan_optimization_name")
                .val(data.optimization_name)
                .trigger("chosen:updated");
              $("#optimization_desc_val").val("");

              $("#plan_cost").val(formatRibuan(data.opt_budget_allocation));
              $("#plan_deadline").val(data.deadline_optimization);

              // Change Modal UI
              $("#addOptimizationPlanModalLabel").text(
                "Edit Optimization Plan",
              );
              $("#btnSavePlan").html("Update Plan");

              // Show Modal
              $("#addOptimizationPlanModal").modal("show");
            });
          } else {
            Swal.fire("Error", "Failed to fetch plan data", "error");
          }
        },
        error: function () {
          Swal.fire("Error", "Server Error", "error");
        },
      });
    });

  // Delete Plan Logic
  $(document)
    .off("click", ".btn-delete-plan")
    .on("click", ".btn-delete-plan", function () {
      let id = $(this).data("id");

      Swal.fire({
        title: "Delete Optimization Plan?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: BASE_URL + "compas/optimization/delete_optimization_plan",
            type: "POST",
            data: { id: id },
            dataType: "json",
            success: function (response) {
              if (response.status) {
                Swal.fire("Deleted!", response.message, "success").then(() => {
                  loadOptimizationPlanTable();
                });
              } else {
                Swal.fire("Error", response.message, "error");
              }
            },
            error: function () {
              Swal.fire("Error", "Server Error", "error");
            },
          });
        }
      });
    });

  function loadOptimizationLogs() {
    let campaign_id = $("#detail_id").val();
    if (!campaign_id) return;

    $.ajax({
      url: BASE_URL + "compas/optimization/get_optimization_logs",
      type: "GET",
      data: { campaign_id: campaign_id },
      dataType: "json",
      success: function (response) {
        if (response.status) {
          let logsHtml = "";
          if (response.data.length > 0) {
            response.data.forEach((log) => {
              let color = "primary";
              if (log.action_type === "STATUS_CHANGE") color = "info";
              else if (log.action_type === "CREATED") color = "success";
              else if (log.action_type === "UPDATED")
                color = "warning text-dark";

              logsHtml += `
                            <div class="timeline-item pb-4">
                                <div class="timeline-dot bg-${color}"></div>
                                <p class="mb-1 text-dark small">
                                    <span class="fw-bold">${log.user_name}</span> ${log.description}
                                </p>
                                <small class="text-muted xx-small">${log.time_ago}</small>
                            </div>`;
            });
            $(".activity-timeline").html(logsHtml);
          } else {
            $(".activity-timeline").html(
              '<p class="text-muted small fst-italic ps-3">No activity yet.</p>',
            );
          }
        }
      },
    });
  }

  function initComments() {
    if ($("#comments-container").length > 0) {
      $("#comments-container").comments({
        profile_picture_url:
          typeof CURRENT_USER_PROFILE_URL !== "undefined"
            ? CURRENT_USER_PROFILE_URL
            : "",
        current_user_id:
          typeof CURRENT_USER_ID !== "undefined" ? CURRENT_USER_ID : 1,
        user_has_upvoted: false,
        enableAttachments: true,
        enableHashtags: true,
        enablePinging: true,

        getComments: function (success, error) {
          $.ajax({
            type: "GET",
            url: BASE_URL + "compas/optimization/get_comments",
            data: { campaign_id: $("#detail_id").val() },
            dataType: "json",
            success: function (commentsArray) {
              success(commentsArray);
            },
            error: error,
          });
        },

        postComment: function (commentJSON, success, error) {
          var formData = new FormData();

          // Append scalar fields
          formData.append("campaign_id", $("#detail_id").val());
          formData.append("content", commentJSON.content || "");
          formData.append("parent", commentJSON.parent || "");
          formData.append("pings", JSON.stringify(commentJSON.pings || []));

          // Append new file attachments (those without an id yet)
          var newAttachments = (commentJSON.attachments || []).filter(
            function (a) {
              return !a.id && a.file instanceof File;
            },
          );
          $.each(newAttachments, function (i, att) {
            formData.append(
              "attachments_to_be_created[]",
              att.file,
              att.file.name,
            );
          });

          $.ajax({
            type: "POST",
            url: BASE_URL + "compas/optimization/post_comment",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (comment) {
              success(comment);
            },
            error: error,
          });
        },

        putComment: function (commentJSON, success, error) {
          var formData = new FormData();

          formData.append("id", commentJSON.id);
          formData.append("content", commentJSON.content || "");
          formData.append("pings", JSON.stringify(commentJSON.pings || []));

          // Existing attachment IDs to keep
          var existingIds = (commentJSON.attachments || [])
            .filter(function (a) {
              return a.id;
            })
            .map(function (a) {
              return a.id;
            });
          if (existingIds.length) {
            formData.append("existing_attachment_ids", existingIds.join(","));
          }

          // New file attachments
          var newAttachments = (commentJSON.attachments || []).filter(
            function (a) {
              return !a.id && a.file instanceof File;
            },
          );
          $.each(newAttachments, function (i, att) {
            formData.append(
              "attachments_to_be_created[]",
              att.file,
              att.file.name,
            );
          });

          $.ajax({
            type: "POST",
            url: BASE_URL + "compas/optimization/put_comment",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (comment) {
              success(comment);
            },
            error: error,
          });
        },

        upvoteComment: function (commentJSON, success, error) {
          $.ajax({
            type: "POST",
            url: BASE_URL + "compas/optimization/upvote_comment",
            data: JSON.stringify(commentJSON),
            contentType: "application/json",
            dataType: "json",
            success: function () {
              success(commentJSON);
            },
            error: error,
          });
        },

        deleteComment: function (commentJSON, success, error) {
          Swal.fire({
            title: "Delete Comment?",
            text: "This will also delete any associated attachments and replies. You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                type: "POST",
                url: BASE_URL + "compas/optimization/delete_comment",
                data: JSON.stringify({ id: commentJSON.id }),
                contentType: "application/json",
                dataType: "json",
                success: function (response) {
                  success(response);
                  Swal.fire({
                    icon: "success",
                    title: "Deleted!",
                    text: "Comment and attachments have been deleted.",
                    timer: 1500,
                    showConfirmButton: false,
                  });
                },
                error: error,
              });
            }
          });
        },

        getUsers: function (success, error) {
          $.ajax({
            type: "GET",
            url: BASE_URL + "compas/optimization/get_users_for_comments",
            dataType: "json",
            success: function (userArray) {
              success(userArray);
            },
            error: error,
          });
        },
      });
    }
  }
};
