window.LoadInit = window.LoadInit || {};
window.LoadInit["tabs"] = window.LoadInit["tabs"] || {};
window.LoadInit["tabs"]["tasklist_problem"] = function (container) {
	$(".tanggal-menit").datetimepicker({
		format: "Y-m-d H:i",
		timepicker: true,
		scrollMonth: false,
		scrollInput: false,
		minDate: 0,
	});

	$(".tanggal-menit").mask("0000-00-00 00:00");

	const base_url = $("body").data("base_url");
	const $container = $(container);

	// DOM Elements
	const $metricPastDeadline = $container.find("#metric-past-deadline");
	const $metricPotentialLate = $container.find("#metric-potential-late");
	const $metricUnsolvedProblem = $container.find("#metric-unsolved-problem");
	const $metricProcessingProblem = $container.find(
		"#metric-processing-problem",
	);
	const $metricSolvedProblem = $container.find("#metric-solved-problem");

	const $tbodyLate = $container.find("#tbody-late-tasks");
	const $tbodyProjection = $container.find("#tbody-projection-tasks");
	const $badgeLateCount = $container.find("#badge-late-count");
	const $badgeProjectionCount = $container.find("#badge-projection-count");

	// Skeleton helper
	const renderSkeletonTable = (rowCount) => {
		let html = "";
		for (let i = 0; i < rowCount; i++) {
			html += `
				<tr>
					<td><div class="skeleton-box" style="height:20px;width:80%;margin-bottom:4px;"></div><div class="skeleton-box" style="height:12px;width:50%;"></div></td>
					<td><div class="skeleton-box" style="height:20px;width:80%;"></div></td>
					<td><div class="skeleton-box" style="height:24px;width:60%;margin-bottom:4px;"></div><div class="skeleton-box" style="height:12px;width:40%;"></div></td>
					<td><div class="skeleton-box" style="height:14px;width:30%;margin-bottom:4px;"></div><div class="skeleton-box" style="height:8px;width:100%;"></div></td>
					<td><div class="skeleton-box" style="height:16px;width:90%;margin-bottom:4px;"></div><div class="skeleton-box" style="height:14px;width:50%;"></div></td>
					<td><div class="skeleton-box" style="height:24px;width:80%;"></div></td>
					<td><div class="skeleton-box" style="height:20px;width:60%;margin-bottom:4px;"></div><div class="skeleton-box" style="height:12px;width:40%;"></div></td>
				</tr>
			`;
		}
		return html;
	};

	const showSkeleton = () => {
		const skeletonMetric =
			'<div class="skeleton-box" style="height:28px; width:60px;"></div>';
		$metricPastDeadline.html(skeletonMetric);
		$metricPotentialLate.html(skeletonMetric);
		$metricUnsolvedProblem.html(skeletonMetric);
		$metricProcessingProblem.html(skeletonMetric);
		$metricSolvedProblem.html(skeletonMetric);

		$badgeLateCount.html(
			'<div class="skeleton-box" style="height:14px; width:40px;"></div>',
		);
		$badgeProjectionCount.html(
			'<div class="skeleton-box" style="height:14px; width:40px;"></div>',
		);

		$tbodyLate.html(renderSkeletonTable(3));
		$tbodyProjection.html(renderSkeletonTable(3));
	};

	// 1. Render Metrics
	const renderMetrics = (metrics) => {
		$metricPastDeadline.text(`${metrics.past_deadline} Task`);
		$metricPotentialLate.text(`${metrics.potential_late} Task`);
		$metricUnsolvedProblem.text(`${metrics.unsolved_problem} Task`);
		$metricProcessingProblem.text(`${metrics.processing_problem} Task`);
		$metricSolvedProblem.text(`${metrics.solved_problem} Task`);
	};

	// Helper for table rows
	const buildTableRow = (task) => {
		const popoverContent = `
			<div class='small text-dark'>
				<div class='mb-2'><strong>Deskripsi:</strong><br>${task.problem_detail.desc}</div>
				<div class='mb-2'><strong>Update Terakhir:</strong><br>${task.problem_detail.update}</div>
				<div class='mb-0 text-muted'><em>Dilaporkan oleh: ${task.problem_detail.reporter}</em></div>
			</div>
		`;

		const statusIcon =
			task.status_type === "danger"
				? "bi-exclamation-circle-fill"
				: "bi-circle-half";

		return `
			<tr>
				<td>
					<div class="fw-bold text-dark mb-0">${task.task_name}</div>
					<div class="text-muted small">${task.task_code}</div>
				</td>
				<td><span class="badge badge-divisi">${task.category}</span></td>
				<td>${task.pic_name}</td>
				<td>
					<div class="deadline-badge text-danger border-danger">${task.deadline_req}</div>
					<div class="text-muted small mt-1">${task.deadline_hint}</div>
				</td>
				<td>
					<div class="text-danger small mb-1">${task.progress_text}</div>
					<div class="progress-mini">
						<div class="progress-bar ${task.progress > 0 && task.progress < 100 ? "bg-warning" : ""}" style="width: ${task.progress}%"></div>
					</div>
				</td>
				<td>
					<div class="text-muted small text-truncate" style="max-width: 150px;">${task.problem_desc}</div>
					<a href="javascript:void(0)"
						class="text-primary small text-decoration-underline enable-popover"
						data-bs-toggle="popover"
						data-bs-trigger="click"
						data-bs-html="true"
						data-bs-placement="top"
						data-bs-title="Detail Kendala"
						data-bs-content="${escapeHtml(popoverContent)}">
						lihat detail
					</a>
				</td>
				<td>
                ${
									task.need_input_problem == 1
										? `
					<button class="btn btn-sm btn-outline-danger btn-input-problem" data-taskid="${task.id}" data-taskname="${task.task_name}"><i class="bi bi-plus-circle"></i> Input Kendala</button>
                `
										: `
					<div class="dropdown">
						<span class="badge rounded-2 badge-status bs-${task.status_type} cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
							<i class="bi ${statusIcon} me-1"></i> ${task.status}
						</span>
						<ul class="dropdown-menu shadow-lg">
							<li><h6 class="dropdown-header">Update Status</h6></li>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item btn-update-status" href="#" data-taskId="${task.id}" data-est-date="${task.est_completion}" data-status="Belum Solved"><i class="bi bi-x-circle me-1 text-danger"></i> Belum Solved</a></li>
							<li><a class="dropdown-item btn-update-status" href="#" data-taskId="${task.id}" data-est-date="${task.est_completion}" data-status="Diproses"><i class="bi bi-hourglass-split me-1 text-warning"></i> Diproses</a></li>
							<li><a class="dropdown-item btn-update-status" href="#" data-taskId="${task.id}" data-est-date="${task.est_completion}" data-status="Solved"><i class="bi bi-check-circle me-1 text-success"></i> Solved</a></li>
							<li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item btn-edit-problem" href="#" data-taskid="${task.id}" data-taskname="${task.task_name}" data-desc="${escapeHtml(task.problem_detail.desc)}" data-note="${escapeHtml(task.problem_detail.update)}" data-status="${task.status}" data-est-date="${task.est_completion}">
                                <i class="bi bi-pencil me-1 text-primary"></i> Edit Kendala
                            </a></li>
							<li><a class="dropdown-item text-danger btn-delete-problem" href="#" data-taskId="${task.id}"><i class="bi bi-trash me-1 text-danger"></i> Hapus Kendala</a></li>
						</ul>
					</div>
                `
								}
				</td>
				<td>
					<div class="text-danger fw-bold"><i class="bi bi-arrow-repeat me-1"></i> ${task.est_completion}</div>
					<div class="text-muted small mt-1">${task.est_completion_hint}</div>
				</td>
			</tr>
		`;
	};

	const escapeHtml = (unsafe) => {
		return unsafe
			.replace(/&/g, "&amp;")
			.replace(/</g, "&lt;")
			.replace(/>/g, "&gt;")
			.replace(/"/g, "&quot;")
			.replace(/'/g, "&#039;");
	};

	// 2. Render Sudah Telat
	const renderSudahTelat = (tasks) => {
		$badgeLateCount.text(`${tasks.length} Task`);
		if (tasks.length === 0) {
			$tbodyLate.html(
				'<tr><td colspan="7" class="text-center py-4 text-muted">Tidak ada task telat</td></tr>',
			);
			return;
		}

		let html = tasks.map(buildTableRow).join("");
		$tbodyLate.html(html);
	};

	// 3. Render Proyeksi Telat
	const renderProyeksiTelat = (tasks) => {
		$badgeProjectionCount.text(`${tasks.length} Task`);
		if (tasks.length === 0) {
			$tbodyProjection.html(
				'<tr><td colspan="7" class="text-center py-4 text-muted">Tidak ada proyeksi telat</td></tr>',
			);
			return;
		}

		let html = tasks.map(buildTableRow).join("");
		$tbodyProjection.html(html);
	};

	const initPopovers = () => {
		const popoverTriggerList = [].slice.call(
			$container.find('[data-bs-toggle="popover"]'),
		);
		popoverTriggerList.map(function (popoverTriggerEl) {
			return new bootstrap.Popover(popoverTriggerEl);
		});
	};

	// Add a body click listener to dismiss popovers
	document.body.addEventListener("click", function (e) {
		// Check if the click target is not the popover trigger or within the popover
		if (
			!e.target.matches('[data-bs-toggle="popover"]') &&
			!e.target.closest(".popover")
		) {
			var popoverTriggerList = [].slice.call(
				document.querySelectorAll('[data-bs-toggle="popover"]'),
			);
			popoverTriggerList.forEach(function (popoverTriggerEl) {
				// Use the Popover instance's hide method
				var popoverInstance = bootstrap.Popover.getInstance(popoverTriggerEl);
				if (popoverInstance) {
					popoverInstance.hide();
				}
			});
		}
	});

	const loadData = () => {
		showSkeleton();

		let periode = $("#filter_month").val() || window.periode;
		let userId = $("#user_id").val() || window.currentUserId;

		$.ajax({
			url: base_url + "project_management/Tasklist_problem/get_problem_data",
			type: "POST",
			data: {
				periode: periode,
				user_id: userId,
			},
			dataType: "json",
			success: function (response) {
				if (response.status === "success") {
					renderMetrics(response.data.metrics);
					renderSudahTelat(response.data.late_tasks);
					renderProyeksiTelat(response.data.projection_tasks);

					// Re-init popovers
					initPopovers();
				}
			},
			error: function (err) {
				console.error("Failed to fetch tasklist problem data", err);
				$tbodyLate.html(
					'<tr><td colspan="7" class="text-center text-danger">Gagal memuat data</td></tr>',
				);
				$tbodyProjection.html(
					'<tr><td colspan="7" class="text-center text-danger">Gagal memuat data</td></tr>',
				);
			},
		});
	};

	// Start fetching data
	loadData();

	// Init Select2 for Task Search
	if ($.fn.select2) {
		$(".select2-task-search").select2({
			theme: "bootstrap-5",
			dropdownParent: $("#modalAddProblem"),
			placeholder: "Ketik ID / Nama Task atau Project...",
			allowClear: true,
			minimumInputLength: 3, // Validasi empty & minimum karakter pencarian
			ajax: {
				url: base_url + "project_management/Tasklist_problem/search_tasks",
				dataType: "json",
				delay: 500, // Tambahan jeda debouncing
				data: function (params) {
					return {
						q: params.term, // search term
					};
				},
				processResults: function (data) {
					return {
						results: data.results,
					};
				},
				cache: true,
			},
		});
	}

	// Event Listeners for Adding Problem
	$container.find("#btn-add-problem").on("click", function () {
		$("#formAddProblem")[0].reset();
		$("#taskSelectorGroup").removeClass("d-none");
		$("#taskNameGroup").addClass("d-none");
		if ($.fn.select2) {
			$(".select2-task-search").val(null).trigger("change");
		}
		$("#modalAddProblem").modal("show");
	});

	$container.on("click", ".btn-input-problem", function (e) {
		e.preventDefault();
		const taskId = $(this).attr("data-taskid");
		const taskName = $(this).attr("data-taskname");

		$("#formAddProblem")[0].reset();
		$("#taskSelectorGroup").addClass("d-none");
		$("#taskNameGroup").removeClass("d-none");

		$("#task_id_hidden").val(taskId);
		$("#displayTaskName").val(taskName);

		$("#modalAddProblem").modal("show");
	});

	$container.on("click", ".btn-edit-problem", function (e) {
		e.preventDefault();
		const taskId = $(this).attr("data-taskid");
		const taskName = $(this).attr("data-taskname");
		const desc = $(this).attr("data-desc");
		const note = $(this).attr("data-note");
		const status = $(this).attr("data-status");
		const estDate = $(this).attr("data-est-date");

		$("#formAddProblem")[0].reset();
		$("#taskSelectorGroup").addClass("d-none");
		$("#taskNameGroup").removeClass("d-none");

		$("#task_id_hidden").val(taskId);
		$("#displayTaskName").val(taskName);
		$("#problem_desc").val(desc);
		$("#problem_note").val(note);
		$("#problem_status").val(status);
		$("#est_date").val(estDate);

		$("#modalAddProblem").modal("show");
	});

	$("#formAddProblem").on("submit", function (e) {
		e.preventDefault();
		const $btn = $("#btnSaveProblem");
		const $spinner = $btn.find(".spinner-border");
		const $text = $btn.find("span:not(.spinner-border)");

		$btn.prop("disabled", true);
		$spinner.removeClass("d-none");
		$text.text("Menyimpan...");

		$.ajax({
			url: base_url + "project_management/Tasklist_problem/add_problem",
			type: "POST",
			dataType: "json",
			data: $(this).serialize(),
			success: function (res) {
				if (res.status === "success") {
					$("#modalAddProblem").modal("hide");
					Swal.fire("Berhasil", res.message, "success");
					loadData();
				}
			},
			complete: function () {
				$btn.prop("disabled", false);
				$spinner.addClass("d-none");
				$text.text("Simpan Kendala");
			},
		});
	});

	// Handle dropdown update status
	$container.on("click", ".btn-update-status", function (e) {
		e.preventDefault();
		const taskId = $(this).attr("data-taskId");
		const status = $(this).attr("data-status");
		const estDate = $(this).attr("data-est-date");

		$("#formUpdateStatus")[0].reset();
		$("#updateTaskId").val(taskId);
		$("#updateProblemStatus").val(status);
		$("#editEstDate").val(estDate);

		$("#modalUpdateStatus").modal("show");
	});

	// Handle save status
	$("#formUpdateStatus").on("submit", function (e) {
		e.preventDefault();
		const $btn = $("#btnSaveStatus");
		const $spinner = $btn.find(".spinner-border");
		const $text = $btn.find("span:not(.spinner-border)");

		$btn.prop("disabled", true);
		$spinner.removeClass("d-none");
		$text.text("Menyimpan...");

		$.ajax({
			url: base_url + "project_management/Tasklist_problem/update_status",
			type: "POST",
			dataType: "json",
			data: $(this).serialize(),
			success: function (res) {
				if (res.status === "success") {
					$("#modalUpdateStatus").modal("hide");
					Swal.fire("Berhasil", res.message, "success");
					loadData();
				}
			},
			complete: function () {
				$btn.prop("disabled", false);
				$spinner.addClass("d-none");
				$text.text("Simpan Status");
			},
		});
	});

	// Handle delete
	$container.on("click", ".btn-delete-problem", function (e) {
		e.preventDefault();
		const taskId = $(this).attr("data-taskId");

		Swal.fire({
			title: "Apakah Anda yakin?",
			text: "Anda akan menghapus kendala ini!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#d33",
			cancelButtonColor: "#3085d6",
			confirmButtonText: "Ya, hapus!",
			cancelButtonText: "Batal",
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: base_url + "project_management/Tasklist_problem/delete_problem",
					type: "POST",
					dataType: "json",
					data: { task_id: taskId },
					success: function (res) {
						if (res.status === "success") {
							Swal.fire("Terhapus!", res.message, "success");
							loadData();
						}
					},
					error: function (err) {
						console.error(err);
						Swal.fire("Kesalahan", "Gagal menghapus kendala.", "error");
					},
				});
			}
		});
	});
};
