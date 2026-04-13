window.kpiWeeklyData = window.kpiWeeklyData || {};
window.LoadInit = window.LoadInit || {};
window.LoadInit["tabs"] = window.LoadInit["tabs"] || {};
window.LoadInit["tabs"]["kpi"] = function (container) {
	let userId = $("#user_id").val() || window.userId;
	let periode = $("#filter_month").val() || window.periode;
	if (!userId) {
		let segments = window.location.pathname.split("/");
		userId = segments[segments.length - 1];
	}

	window.periode = periode;
	window.currentUserId = userId;

	for (let w = 1; w <= 4; w++) {
		loadKpiWeeklyData(userId, periode, "W" + w);
	}

	$("#saveKpiReviewBtn")
		.off("click")
		.on("click", function () {
			saveKpiReview(window.currentUserId);
		});
};

function loadKpiWeeklyData(user_id, periode, week) {
	$.ajax({
		url: BASE_URL + "project_management/Kpi/get_weekly_kpi",
		type: "POST",
		data: {
			user_id: user_id,
			periode: periode,
			week: week,
		},
		dataType: "json",
		success: function (response) {
			let tbody = $("#kpi-tbody-" + week.replace("W", ""));
			tbody.empty();

			if (response.status && response.data.length > 0) {
				window.kpiWeeklyData[week] = response.data;
				let html = "";
				let totalAch = 0;
				let totalFinalScore = 0;
				let kpiMet = 0;

				response.data.forEach(function (item) {
					totalAch += parseFloat(item.final_ach) || 0;
					totalFinalScore += parseFloat(item.final_score) || 0;
					if (parseFloat(item.final_ach) >= parseFloat(item.weight)) kpiMet++;

					let finalScore = item.final_score
						? parseFloat(item.final_score).toFixed(2)
						: "-";

					html += `<tr class="border-bottom">
                                <td class="py-4 px-3">
                                    <div class="fw-bold text-dark" style="font-size: 0.9rem;">${item.kpi_item_name || "-"}</div>
									<div class="badge bg-primary">${item.type || "-"}</div>
                                </td>
                                <td class="text-center fw-bold text-dark">${item.target_percent || 0} ${item.unit == "percentage" ? "%" : ""}</td>
                                <td class="text-center fw-bold text-dark">${item.actual_value || 0} / ${item.target_value || 0}</td>
                                <td class="text-center">
                                    <span class="badge ${parseFloat(item.ach_value) >= parseFloat(item.target_percent) ? "bg-success-soft text-success" : "bg-danger-soft text-danger"} rounded-pill px-3 py-1 fs-6">${item.ach_value || 0}%</span>
                                </td>
								<td class="text-center fw-bold text-warning">${item.weight || 0}%</td>
								<td class="text-center fw-bold ${parseFloat(item.final_ach) >= parseFloat(item.weight) ? "bg-success-soft text-success" : "bg-danger-soft text-danger"}">${item.final_ach || 0}%</td>
                                <td class="text-center">${item.score || 0}</td>
                                <td class="text-center fw-bold text-dark">${finalScore}</td>
								<td class="text-center fw-bold text-dark">${parseFloat(item.final_ach) >= parseFloat(item.weight) ? "<i class='bi bi-check-circle-fill text-success'></i>" : "<i class='bi bi-x-circle-fill text-danger'></i>"}</td>
                            </tr>`;
				});
				tbody.html(html);

				let wNum = week.replace("W", "");
				$(`#kpi-total-ach-${wNum}`).text(totalAch.toFixed(0));
				$(`#kpi-total-final-score-${wNum}`).text(totalFinalScore.toFixed(2));
				$(`#kpi-total-met-${wNum}`).text(`${kpiMet} / ${response.data.length}`);
			} else {
				tbody.html(
					'<tr><td colspan="9" class="text-center py-4 text-muted">Belum ada data KPI untuk minggu ini</td></tr>',
				);
				let wNum = week.replace("W", "");
				$(`#kpi-total-ach-${wNum}`).text("0");
				$(`#kpi-total-final-score-${wNum}`).text("0.00");
				$(`#kpi-total-met-${wNum}`).text("0 / 0");
			}
		},
		error: function () {
			console.error("Failed to load KPI data for week " + week);
		},
	});
}

window.openKpiReviewModal = function (
	employeeId,
	kpiId,
	periode,
	week,
	kpiName,
	achievement,
	weight,
	target,
) {
	$.ajax({
		url: BASE_URL + "project_management/Kpi/get_kpi_review",
		type: "POST",
		data: {
			employee_id: employeeId,
			kpi_id: kpiId,
			periode: periode,
			week: week,
		},
		dataType: "json",
		success: function (response) {
			if (response.status && response.data) {
				let data = response.data;

				// Header / Profile
				$("#view_employee_name").text(data.employee_name || "-");
				$("#view_department_name").text(data.department_name || "-");
				$("#view_badge1").text(data.badge1 || "-");
				$("#view_badge2").text(data.badge2 || "-");

				// Review Summary
				$("#view_review_title").text(data.review_title || "Review Atasan");
				$("#view_review_subtitle").text(data.review_subtitle || "-");
				$("#view_rating_text").text(data.rating_text || "-");

				// Generating stars based on rating
				let rating = parseInt(data.rating) || 0;
				let starsHtml = "";
				for (let i = 1; i <= 5; i++) {
					if (i <= rating) {
						starsHtml += '<i class="bi bi-star-fill"></i>';
					} else {
						starsHtml +=
							'<i class="bi bi-star-fill" style="color: #e4e5e9;"></i>';
					}
				}
				$("#view_rating_stars").html(starsHtml);

				// Calculate and Render Metrics & KPI Items
				let totalAchievement = 0;
				let totalFinalScore = 0;
				let kpiMetCount = 0;
				let kpiTotalCount = 0;
				let kpiItemsHtml = "";

				if (data.kpi_scores && data.kpi_scores.length > 0) {
					kpiTotalCount = data.kpi_scores.length;
					data.kpi_scores.forEach((scoreObj, index) => {
						totalAchievement +=
							parseFloat(scoreObj.snapshot_achievement_weight) || 0;
						totalFinalScore += parseFloat(scoreObj.snapshot_final_score) || 0;
						if (parseInt(scoreObj.snapshot_kpi_met) === 1) kpiMetCount++;

						// Custom Card for each KPI Item
						kpiItemsHtml += `
						<div class="border rounded-3 p-3 bg-white shadow-sm" style="border-color: #e5e7eb !important;">
							<div class="d-flex justify-content-between align-items-start mb-2 gap-2">
								<div class="fw-bold text-dark" style="font-size: 0.85rem;">${scoreObj.kpi_item_name || "-"}</div>
								<span class="badge ${parseInt(scoreObj.snapshot_kpi_met) === 1 ? "bg-success-soft text-success" : "bg-danger-soft text-danger"} rounded-pill text-nowrap" style="font-size: 0.70rem;">
									${parseInt(scoreObj.snapshot_kpi_met) === 1 ? '<i class="bi bi-check-circle-fill me-1"></i>Tercapai' : '<i class="bi bi-x-circle-fill me-1"></i>Missed'}
								</span>
							</div>
							
							<div class="row g-2 mt-2">
								<div class="col-6 col-md-3">
									<div class="bg-light rounded p-2 text-center h-100">
										<div class="text-secondary mb-1 text-truncate" style="font-size: 0.65rem;">Actual / Target</div>
										<div class="fw-bold text-dark text-nowrap" style="font-size: 0.8rem;">${scoreObj.snapshot_actual_value || 0} <span class="text-muted fw-normal mx-1">/</span> ${scoreObj.snapshot_target_value || 0}</div>
									</div>
								</div>
								<div class="col-6 col-md-3">
									<div class="bg-light rounded p-2 text-center h-100">
										<div class="text-secondary mb-1 text-truncate" style="font-size: 0.65rem;">Final Ach</div>
										<div class="fw-bold text-dark text-nowrap" style="font-size: 0.8rem;">${scoreObj.snapshot_achievement_weight || 0}%</div>
									</div>
								</div>
								<div class="col-6 col-md-3">
									<div class="bg-light rounded p-2 text-center h-100">
										<div class="text-secondary mb-1 text-truncate" style="font-size: 0.65rem;">Bobot</div>
										<div class="fw-bold text-warning text-nowrap" style="font-size: 0.8rem;">${scoreObj.snapshot_weight || 0}%</div>
									</div>
								</div>
								<div class="col-6 col-md-3">
									<div class="bg-light rounded p-2 text-center h-100">
										<div class="text-secondary mb-1 text-truncate" style="font-size: 0.65rem;">Final Score</div>
										<div class="fw-bold text-primary text-nowrap" style="font-size: 0.8rem;">${scoreObj.snapshot_final_score || 0}</div>
									</div>
								</div>
							</div>
						</div>
						`;
					});
				} else {
					kpiItemsHtml = `<div class="text-center py-4 text-muted small border rounded-3 bg-light">Belum ada detail item KPI yang tersimpan.</div>`;
				}

				$("#view_total_achievement").text(totalAchievement.toFixed(0) + "%");
				$("#view_total_final_score").text(totalFinalScore.toFixed(2));
				$("#view_total_kpi_met").text(`${kpiMetCount} / ${kpiTotalCount}`);
				$("#view_kpi_items_container").html(kpiItemsHtml);

				// Feedback
				$("#view_header_week").text(week.replace("W", ""));
				let feedbackText = data.feedback || "-";
				let feedbackHtml = feedbackText
					.split("\n")
					.filter((p) => p.trim() !== "")
					.map((p) => `<p class="mb-3">${p}</p>`)
					.join("");
				$("#view_feedback").html(feedbackHtml);

				// Gap Utama
				let gapText = data.gap_utama || "";
				let gapHtml = "";
				gapText.split("\n").forEach((g, index) => {
					if (g.trim() !== "") {
						gapHtml += `
                            <div class="d-flex gap-3 align-items-start">
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 22px; height: 22px; font-weight: 600; font-size: 0.75rem; background-color: #ffe5e5; color: #dc3545;">${index + 1}</div>
                                <div class="text-dark small text-justify">${g}</div>
                            </div>
                        `;
					}
				});
				$("#view_gap_utama").html(gapHtml || "-");

				// Kendala
				let kendalaText = data.kendala_saat_ini || "";
				let kendalaHtml = "";
				kendalaText.split("\n").forEach((k) => {
					if (k.trim() !== "") {
						let parts = k.split(":");
						let title = parts[0] ? parts[0].trim() : "Kendala";
						let desc = parts.slice(1).join(":").trim() || "";
						if (!desc) {
							desc = title;
							title = "Info";
						}
						kendalaHtml += `
                            <div class="col-md-6">
                                <div class="border rounded-2 p-3 h-100 bg-white" style="border-color: #fd7e14 !important; border-width: 1px;">
                                    <h6 class="fw-bold mb-2 text-dark small text-justify">${title}</h6>
                                    <div class="text-secondary small text-justify">${desc}</div>
                                </div>
                            </div>
                        `;
					}
				});
				$("#view_kendala").html(kendalaHtml || "-");

				// Plan
				let planText = data.plan_perbaikan || "";
				let planHtml = "";
				planText.split("\n").forEach((p) => {
					if (p.trim() !== "") {
						planHtml += `
                            <div class="d-flex gap-2 align-items-start">
                                <div class="text-danger small" style="margin-top: 1px;"><i class="bi bi-bullseye"></i></div>
                                <div class="text-secondary small text-justify">${p}</div>
                            </div>
                        `;
					}
				});
				$("#view_plan").html(planHtml || "-");

				// Target Next Week
				let targetText = data.target_week_berikutnya || "";
				let targetHtml = "";
				targetText.split("\n").forEach((t) => {
					if (t.trim() !== "") {
						targetHtml += `
                            <div class="border rounded-2 p-2 px-3 d-flex gap-2 align-items-center bg-white" style="border-color: #0d6efd !important; border-width: 1px; background-color: #f8fbff !important;">
                                <div class="text-primary small"><i class="bi bi-bullseye"></i></div>
                                <div class="text-secondary mb-0 small text-justify">${t}</div>
                            </div>
                        `;
					}
				});
				$("#view_target").html(targetHtml || "-");

				// Signature
				$("#view_user_avatar").attr("src", data.user_avatar || "");
				$("#view_signature_img").attr("src", data.signature_img || "");
				$("#view_signature_name").text(data.signature_name || "-");
				$("#view_signature_role").text(data.signature_role || "-");
				$("#view_signature_date").text(data.signature_date || "-");

				$("#modalDetailKpi").modal("show");
			}
		},
	});
};

function toggleReviewEditMode(isEdit) {
	if (isEdit) {
		$(".review-display").addClass("d-none");
		$(".review-edit").removeClass("d-none");
	} else {
		$(".review-edit").addClass("d-none");
		$(".review-display").removeClass("d-none");
	}
}

// Ensure the form doesn't submit normally
$(document).ready(function () {
	$("#formKpiFeedback").on("submit", function (e) {
		e.preventDefault();
		saveKpiFeedback();
	});

	// Rating selector UI logic for Feedback modal
	$(document).on("click", ".rating-select-btn", function () {
		$(".rating-select-btn")
			.removeClass("btn-warning text-white")
			.addClass("btn-outline-warning");
		$(this)
			.removeClass("btn-outline-warning")
			.addClass("btn-warning text-white");
		$(this).find("input").prop("checked", true);
	});
});

window.openKpiFeedbackModal = function (
	employeeId,
	kpiId,
	periode,
	week,
	kpiName,
	target,
	targetValue,
	actualValue,
	achievement,
	weight,
	score,
	finalScore,
) {
	// Reset inputs
	$("#formKpiFeedback")[0].reset();
	$(".rating-select-btn")
		.removeClass("btn-warning text-white")
		.addClass("btn-outline-warning");

	$("#input_employee_id").val(employeeId);
	$("#input_kpi_id").val(kpiId);
	$("#input_periode").val(periode);
	$("#input_week").val(week);

	$("#input_kpi_scores_table").empty();

	// Init Summernote if not already initialized
	if (!$(".summernote-editor").hasClass("note-editor-initialized")) {
		$(".summernote-editor")
			.summernote({
				height: 150,
				toolbar: [
					["style", ["bold", "italic", "underline", "clear"]],
					// ['para', ['ul', 'ol', 'paragraph']],
					// ['insert', ['link']],
				],
				placeholder: "Ketik disini...",
			})
			.addClass("note-editor-initialized");
	}

	// Fetch existing data
	$.ajax({
		url: BASE_URL + "project_management/Kpi/get_kpi_review",
		type: "POST",
		data: {
			employee_id: employeeId,
			kpi_id: kpiId,
			periode: periode,
			week: week,
		},
		dataType: "json",
		beforeSend: function () {
			// Set empty content initially
			$(".summernote-editor").each(function () {
				$(this).summernote("code", "");
			});
		},
		success: function (response) {
			if (response.status && response.data) {
				let data = response.data;
				if (data.rating) {
					$(`.rating-select-btn[data-val="${data.rating}"]`)
						.addClass("btn-warning text-white")
						.removeClass("btn-outline-warning")
						.find("input")
						.prop("checked", true);
				}

				$("#input_kpi_name").val(data.kpi_name);
				$("#input_kpi_name_display").text(data.kpi_name || "-");
				$("#input_employee_name_display").text(data.employee_name || "-");
				$("#input_week_display").text(data.review_subtitle || "-");

				let scoresHtml = "";
				let totalAchievement = 0;
				let totalFinalScore = 0;
				let kpiMetCount = 0;
				let kpiTotalCount = 0;

				if (data.kpi_scores && data.kpi_scores.length > 0) {
					kpiTotalCount = data.kpi_scores.length;
					data.kpi_scores.forEach((scoreObj, index) => {
						totalAchievement +=
							parseFloat(scoreObj.snapshot_achievement_weight) || 0;
						totalFinalScore += parseFloat(scoreObj.snapshot_final_score) || 0;
						if (parseInt(scoreObj.snapshot_kpi_met) === 1) kpiMetCount++;

						scoresHtml += `
                            <tr>
                                <td>
                                    ${scoreObj.kpi_item_name || "-"}
                                    <input type="hidden" name="kpi_scores[${index}][employee_id]" value="${scoreObj.employee_id}">
                                    <input type="hidden" name="kpi_scores[${index}][kpi_id]" value="${scoreObj.kpi_id}">
                                    <input type="hidden" name="kpi_scores[${index}][kpi_item_id]" value="${scoreObj.kpi_item_id}">
                                    <input type="hidden" name="kpi_scores[${index}][kpi_item_name]" value="${scoreObj.kpi_item_name}">
                                    <input type="hidden" name="kpi_scores[${index}][reviewer_id]" value="${scoreObj.reviewer_id}">
                                    <input type="hidden" name="kpi_scores[${index}][periode]" value="${scoreObj.periode}">
                                    <input type="hidden" name="kpi_scores[${index}][week]" value="${scoreObj.week}">
                                    <input type="hidden" name="kpi_scores[${index}][snapshot_target_percent]" value="${scoreObj.snapshot_target_percent}">
                                    <input type="hidden" name="kpi_scores[${index}][snapshot_weight]" value="${scoreObj.snapshot_weight}">
                                    <input type="hidden" name="kpi_scores[${index}][snapshot_target_value]" value="${scoreObj.snapshot_target_value}">
                                    <input type="hidden" name="kpi_scores[${index}][snapshot_actual_value]" value="${scoreObj.snapshot_actual_value}">
                                    <input type="hidden" name="kpi_scores[${index}][snapshot_achievement]" value="${scoreObj.snapshot_achievement}">
                                    <input type="hidden" name="kpi_scores[${index}][snapshot_achievement_weight]" value="${scoreObj.snapshot_achievement_weight}">
                                    <input type="hidden" name="kpi_scores[${index}][snapshot_score]" value="${scoreObj.snapshot_score}">
                                    <input type="hidden" name="kpi_scores[${index}][snapshot_final_score]" value="${scoreObj.snapshot_final_score}">
                                    <input type="hidden" name="kpi_scores[${index}][snapshot_kpi_met]" value="${scoreObj.snapshot_kpi_met}">
                                </td>
                                <td class="text-center">${scoreObj.snapshot_target_percent}${scoreObj.unit || "" == "percentage" ? "%" : ""}</td>
                                <td class="text-center">${scoreObj.snapshot_actual_value} / ${scoreObj.snapshot_target_value}</td>
                                <td class="text-center">${scoreObj.snapshot_achievement}</td>
                                <td class="text-center">${scoreObj.snapshot_weight}%</td>
                                <td class="text-center">${scoreObj.snapshot_achievement_weight}%</td>
                                <td class="text-center">${scoreObj.snapshot_score || 0}</td>
                                <td class="text-center">${scoreObj.snapshot_final_score || 0}</td>
                                <td class="text-center">${(scoreObj.snapshot_kpi_met || 0) == 1 ? "<i class='bi bi-check-circle-fill text-success'></i>" : "<i class='bi bi-x-circle-fill text-danger'></i>"}</td>
                            </tr>
                        `;
					});
				}
				$("#input_kpi_scores_table").html(scoresHtml);
				$("#input_kpi_total_achievement_display").text(
					totalAchievement.toFixed(0) + "%",
				);
				$("#input_kpi_total_final_score_display").text(
					totalFinalScore.toFixed(2),
				);
				$("#input_kpi_total_met_display").text(
					kpiMetCount + " / " + kpiTotalCount,
				);
				$("#input_snapshot_achievement").val(totalAchievement.toFixed(0));
				$("#input_snapshot_final_score").val(totalFinalScore.toFixed(2));
				$("#input_snapshot_kpi_met").val(kpiMetCount + " / " + kpiTotalCount);

				let toHtml = (text) => {
					if (!text) return "";
					if (text.includes("<p>") || text.includes("<br")) return text;
					return text.split("\n").join("<br>"); // Simple fallback
				};

				$("#input_feedback").summernote("code", toHtml(data.feedback));
				$("#input_gap_utama").summernote("code", toHtml(data.gap_utama));
				$("#input_kendala_saat_ini").summernote(
					"code",
					toHtml(data.kendala_saat_ini),
				);
				$("#input_plan_perbaikan").summernote(
					"code",
					toHtml(data.plan_perbaikan),
				);
				$("#input_target_week_berikutnya").summernote(
					"code",
					toHtml(data.target_week_berikutnya),
				);
			}
		},
		complete: function () {
			$("#modalInputKpiFeedback").modal("show");
		},
	});
};

window.saveKpiFeedback = function () {
	let form = $("#formKpiFeedback")[0];
	if (!form.checkValidity()) {
		form.reportValidity();
		return;
	}

	// validate summernote
	if ($("#input_feedback").summernote("isEmpty")) {
		Swal.fire({
			icon: "warning",
			title: "Peringatan",
			text: "Feedback tidak boleh kosong!",
		});
		return;
	}

	if ($("#input_kendala_saat_ini").summernote("isEmpty")) {
		Swal.fire({
			icon: "warning",
			title: "Peringatan",
			text: "Kendala saat ini tidak boleh kosong!",
		});
		return;
	}

	if ($("#input_plan_perbaikan").summernote("isEmpty")) {
		Swal.fire({
			icon: "warning",
			title: "Peringatan",
			text: "Plan perbaikan tidak boleh kosong!",
		});
		return;
	}

	if ($("#input_target_week_berikutnya").summernote("isEmpty")) {
		Swal.fire({
			icon: "warning",
			title: "Peringatan",
			text: "Target minggu berikutnya tidak boleh kosong!",
		});
		return;
	}

	let formData = new FormData(form);

	let btn = $("#btnSaveKpiFeedback");
	let originalText = btn.html();
	btn
		.html(
			'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...',
		)
		.prop("disabled", true);

	$.ajax({
		url: BASE_URL + "project_management/Kpi/save_kpi_review",
		type: "POST",
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		success: function (response) {
			if (response.status) {
				Swal.fire({
					icon: "success",
					title: "Berhasil!",
					text: response.message,
					confirmButtonColor: "#0d6efd",
					timer: 1500,
				}).then(() => {
					$("#modalInputKpiFeedback").modal("hide");
				});
			} else {
				Swal.fire({
					icon: "error",
					title: "Gagal",
					text: response.message || "Terjadi kesalahan",
				});
			}
		},
		error: function () {
			Swal.fire({
				icon: "error",
				title: "Error",
				text: "Gagal terhubung ke server",
			});
		},
		complete: function () {
			btn.html(originalText).prop("disabled", false);
		},
	});
};

function toggleReviewEditMode(isEdit) {
	if (isEdit) {
		$(".review-view-only").hide();
		$(".review-edit-only").show();
		$("#btn-edit-review").hide();
		$("#btn-cancel-review, #btn-save-review").show();
	} else {
		$(".review-view-only").show();
		$(".review-edit-only").hide();
		$("#btn-edit-review").show();
		$("#btn-cancel-review, #btn-save-review").hide();
	}
}

// Add event listeners for review modal
$(document).ready(function () {
	$("#btn-edit-review").click(function () {
		toggleReviewEditMode(true);
	});
	$("#btn-cancel-review").click(function () {
		toggleReviewEditMode(false);
	});

	// Rating selection
	$(".rating-btn").click(function () {
		if (!$(this).closest(".review-edit-only").is(":visible")) return;

		$(".rating-btn")
			.removeClass("active btn-primary")
			.addClass("btn-outline-secondary");
		$(this).removeClass("btn-outline-secondary").addClass("active btn-primary");
		$("#rating").val($(this).data("val"));

		// Update score based on rating
		updateScoreDisplay(
			parseFloat($("#detail_achievement").text()),
			parseFloat($("#detail_weight").text()),
		);
	});

	$("#btn-save-review").click(function () {
		saveKpiReview(window.currentUserId);
	});
});

function updateScoreDisplay(achievement, weight) {
	let rating = parseFloat($("#rating").val()) || 0;
	$("#detail_score").text(rating);

	// final score = weight% * achivement% + score ? Depends on business logic, assuming rating * (weight/100) or just sum
	let ach = parseFloat(achievement) || 0;
	let w = parseFloat(weight) || 0;

	// Let's assume standard score formula (like achievement * weight / 100)
	// Wait, the table used finalScore. We'll just display a dummy for now.
	let finalScore = ((rating * w) / 100).toFixed(2);
	$("#detail_final_score").text(finalScore);
}

function saveKpiReview(userId) {
	let formData = $("#kpiReviewForm").serialize();
	formData += "&user_id=" + userId;
	formData += "&periode=" + window.periode;

	let btn = $("#btn-save-review");
	let originalText = btn.html();
	btn
		.html(
			'<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...',
		)
		.prop("disabled", true);

	$.ajax({
		url: BASE_URL + "project_management/Kpi/save_kpi_review",
		type: "POST",
		data: formData,
		dataType: "json",
		success: function (response) {
			btn.html(originalText).prop("disabled", false);
			if (response.status) {
				// Update view mode texts
				$("#view_gap").text($("#gap_utama").val() || "-");
				$("#view_kendala").text($("#kendala_saat_ini").val() || "-");
				$("#view_plan").text($("#plan_perbaikan").val() || "-");
				$("#view_target_next").text($("#target_week_berikutnya").val() || "-");

				toggleReviewEditMode(false); // return to view mode

				if (typeof Swal !== "undefined") {
					Swal.fire({
						icon: "success",
						title: "Berhasil",
						text: "Review KPI berhasil disimpan",
						timer: 1500,
						showConfirmButton: false,
					});
				} else {
					alert("Review KPI berhasil disimpan");
				}
				let weekHtml = $("#kpi_week").val();
				loadKpiWeeklyData(userId, window.periode, weekHtml);
			} else {
				if (typeof Swal !== "undefined") {
					Swal.fire({
						icon: "error",
						title: "Gagal",
						text: response.message || "Terjadi kesalahan saat menyimpan data",
					});
				} else {
					alert("Terjadi kesalahan saat menyimpan data");
				}
			}
		},
		error: function () {
			btn.html(originalText).prop("disabled", false);
			if (typeof Swal !== "undefined") {
				Swal.fire({
					icon: "error",
					title: "Error",
					text: "Terjadi kesalahan koneksi",
				});
			} else {
				alert("Terjadi kesalahan koneksi");
			}
		},
	});
}

// Global buttons logic
function setUpGlobalKpiReviewButtons() {
	$(document)
		.off("click", "#showKpiReviewBtn, #editKpiReviewBtn")
		.on("click", "#showKpiReviewBtn, #editKpiReviewBtn", function () {
			console.log("clicked");
			let isEdit = $(this).attr("id") === "editKpiReviewBtn";
			let activeWeekTab = $("#kpiWeeksTabs .nav-link.active").attr(
				"data-bs-target",
			);
			let week = activeWeekTab ? activeWeekTab.replace("#week", "W") : null;

			if (!week) {
				if (typeof Swal !== "undefined")
					Swal.fire(
						"Peringatan",
						"Pilih minggu yang aktif terlebih dahulu.",
						"warning",
					);
				else alert("Pilih minggu yang aktif terlebih dahulu.");
				return;
			}

			let weekData = window.kpiWeeklyData ? window.kpiWeeklyData[week] : null;
			if (!weekData || weekData.length === 0) {
				if (typeof Swal !== "undefined")
					Swal.fire(
						"Peringatan",
						"Tidak ada data KPI pada minggu ini.",
						"warning",
					);
				else alert("Tidak ada data KPI pada minggu ini.");
				return;
			}

			console.log(week);
			console.log(isEdit);

			let kpiId = weekData[0].kpi_id;
			let empId = window.currentUserId;
			let per = window.periode;

			let weightSum = 0;
			let achSum = 0;
			let finalScoreSum = 0;

			weekData.forEach((item) => {
				let w = parseFloat(item.weight) || 0;
				weightSum += w;
				achSum += (parseFloat(item.ach_value) || 0) * (w / 100);
				finalScoreSum += parseFloat(item.final_score) || 0;
			});

			let targetSum = 100;
			let kpiName = "Review Mingguan: " + week.replace("W", "Week ");

			if (isEdit) {
				window.openKpiFeedbackModal(
					empId,
					kpiId,
					per,
					week,
					kpiName,
					targetSum,
					"-",
					"-",
					achSum.toFixed(2),
					weightSum,
					"-",
					finalScoreSum.toFixed(2),
				);
			} else {
				console.log(
					empId,
					kpiId,
					per,
					week,
					kpiName,
					achSum.toFixed(2),
					weightSum,
					targetSum,
				);
				window.openKpiReviewModal(
					empId,
					kpiId,
					per,
					week,
					kpiName,
					achSum.toFixed(2),
					weightSum,
					targetSum,
				);
			}
		});
}

$(document).ready(function () {
	setUpGlobalKpiReviewButtons();
});

// Print PDF for KPI Modal
window.printKpiModal = function () {
	let modalContent = document.querySelector(
		"#modalDetailKpi .modal-content",
	).outerHTML;

	let iframe = document.createElement("iframe");
	iframe.style.position = "absolute";
	iframe.style.width = "0px";
	iframe.style.height = "0px";
	iframe.style.border = "none";
	document.body.appendChild(iframe);

	let doc = iframe.contentWindow.document;
	doc.open();

	let styles = "";
	document.querySelectorAll('link[rel="stylesheet"], style').forEach((el) => {
		styles += el.outerHTML;
	});

	doc.write(`
        <html>
        <head>
            <title>Capaian KPI - Print PDF</title>
            ${styles}
            <style>
                @media print {
                    @page { size: auto; margin: 5mm; }
                    body { 
                        -webkit-print-color-adjust: exact !important; 
                        print-color-adjust: exact !important; 
                        background: white !important; 
                    }
                    .btn-close, .btn-print-pdf { display: none !important; }
                    .modal-content { border: none !important; box-shadow: none !important; padding: 0 !important; }
                    /* Make sure background gradient in header prints */
                    div[style*="background"] {
                        -webkit-print-color-adjust: exact !important; 
                        print-color-adjust: exact !important; 
                    }
                }
            </style>
        </head>
        <body class="bg-white">
            ${modalContent}
        </body>
        </html>
    `);
	doc.close();

	setTimeout(() => {
		iframe.contentWindow.focus();
		iframe.contentWindow.print();
		setTimeout(() => document.body.removeChild(iframe), 1500);
	}, 1000);
};
