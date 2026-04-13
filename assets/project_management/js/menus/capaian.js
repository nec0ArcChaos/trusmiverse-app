window.LoadInit = window.LoadInit || {};
window.LoadInit["menus"] = window.LoadInit["menus"] || {};
window.LoadInit["menus"]["capaian"] = function (container) {
	const base_url = $("body").data("base_url");

	switchTab("tabs", STATE.tabs.activeTab);

	const $container = $(container);

	/**
	 * Set skeleton loading state
	 */
	function setSkeleton() {
		const skeletonHtml =
			'<span class="skeleton-box" style="width: 80%;"></span>';
		const skeletonHtmlSmall =
			'<span class="skeleton-box" style="width: 60%;"></span>';

		$container.find(".employee-name").html(skeletonHtml);
		$container.find(".employee-position").html(skeletonHtmlSmall);
		$container.find(".employee-overall-kpi").html(skeletonHtmlSmall);

		$container.find("#overall-kpi").html(skeletonHtml);
		$container.find("#total-tasklist").html(skeletonHtml);
		$container.find("#total-kehadiran").html(skeletonHtml);
		$container.find("#total-alfa").html(skeletonHtml);
		$container.find("#total-telat").html(skeletonHtml);
		$container.find("#total-ijin").html(skeletonHtml);

		// Hide avatar and companies while loading
		$container.find(".employee-photo figure").css("opacity", "0.5");
		$container.find(".employee-companies").html("");
	}

	/**
	 * Populate data into DOM
	 */
	function populateData(data) {
		$container
			.find(".employee-avatar-figure")
			.css("background-image", `url("${data.avatar_url}")`);
		$container.find("#employee-avatar").attr("src", data.avatar_url);
		$container.find(".employee-name").text(data.name);
		$container.find(".employee-position").text(data.position);
		$container.find(".employee-overall-kpi").text(data.overall_kpi_desc);

		$container.find("#overall-kpi").text(data.overall_kpi);
		$container.find("#total-tasklist").text(data.total_tasklist);
		$container.find("#total-kehadiran").text(data.total_kehadiran);
		$container.find("#total-alfa").text(data.total_alfa);
		$container.find("#total-telat").text(data.total_telat);
		$container.find("#total-ijin").text(data.total_ijin);

		// Populate avatar
		if (data.avatar_url) {
			$container.find(".employee-photo figure").css({
				"background-image": `url("${data.avatar_url}")`,
				opacity: "1",
			});
		}

		// Populate companies badges
		if (data.companies && data.companies.length > 0) {
			let companiesHtml = "";
			data.companies.forEach((company) => {
				const bgStyle = company.icon_bg
					? `class="badge-logo me-2 ${company.icon_bg}" style="width: 20px; height: 20px;"`
					: 'class="badge-logo me-2"';
				companiesHtml += `
                    <div class="company-badge rounded-pill d-flex align-items-center bg-white border px-3 py-1 shadow-sm">
                        <div ${bgStyle}>${company.icon}</div>
                        <span class="small fw-semibold text-dark text-nowrap">${company.name}</span>
                    </div>
                `;
			});
			$container.find(".d-flex.gap-2.mb-3").html(companiesHtml);
		}
	}

	/**
	 * Fetch user capaian data
	 */
	function fetchUserCapaian() {
		setSkeleton(); // Show skeleton loader first
		const filterMonth = $("#filter_month").val();
		const userId = $("#user_id").val();

		$.ajax({
			url: base_url + "project_management/capaian/get_user_capaian",
			method: "POST", // Menggunakan POST
			dataType: "json",
			data: { periode: filterMonth, user_id: userId },
			success: function (response) {
				if (response.status === "success" && response.data) {
					populateData(response.data);
				} else {
					console.error("Data not found or invalid response");
				}
			},
			error: function (xhr, status, error) {
				console.error("Failed to load user capaian data:", error);
			},
		});
	}

	/**
	 * Set skeleton loading state for progress cards
	 */
	function setProgressSkeleton() {
		const skeletonHtmlSmall =
			'<span class="skeleton-box" style="width: 40px;"></span>';
		const skeletonHtmlLarge =
			'<span class="skeleton-box" style="width: 80px;"></span>';

		$container.find("#leadtime-percent").html(skeletonHtmlSmall);
		$container.find("#achievement-percent").html(skeletonHtmlSmall);
		$container.find("#tasklist-summary").html(skeletonHtmlLarge);
		$container.find("#ticket-summary").html(skeletonHtmlLarge);

		// Reset progress bars to 0 with no animation initially
		$container.find(".progress-bar-fill").css({
			width: "0%",
			transition: "none",
		});
	}

	/**
	 * Animate progress bar width
	 */
	function animateProgressBar($element, targetWidth) {
		// Set transition after resetting with a slight delay
		setTimeout(() => {
			$element.css({
				transition: "width 1s cubic-bezier(0.4, 0, 0.2, 1)",
				width: targetWidth + "%",
			});
		}, 50);
	}

	/**
	 * Populate and animate progress cards
	 */
	function populateProgressCards(data) {
		// Update text values
		$container.find("#leadtime-percent").text(data.leadtime_percent + "%");
		$container
			.find("#achievement-percent")
			.text(data.achievement_percent + "%");

		// Update html for sub-metrics
		$container
			.find("#tasklist-summary")
			.html(
				`<span id="tasklist-done">${data.tasklist_done}</span><span class="text-muted fw-normal fs-xs">/<span id="tasklist-total">${data.tasklist_total}</span> Total</span>`,
			);
		$container
			.find("#ticket-summary")
			.html(
				`<span id="ticket-done">${data.ticket_done}</span><span class="text-muted fw-normal fs-xs">/<span id="ticket-total">${data.ticket_total}</span> Total</span>`,
			);

		// Calculate progress values for metrics that are fractions
		const tasklistPercent =
			data.tasklist_total > 0
				? (data.tasklist_done / data.tasklist_total) * 100
				: 0;
		const ticketPercent =
			data.ticket_total > 0 ? (data.ticket_done / data.ticket_total) * 100 : 0;

		// Animate progress bars to actual value
		animateProgressBar(
			$container.find("#leadtime-progress"),
			data.leadtime_percent,
		);
		animateProgressBar(
			$container.find("#achievement-progress"),
			data.achievement_percent,
		);
		animateProgressBar($container.find("#tasklist-progress"), tasklistPercent);
		animateProgressBar($container.find("#ticket-progress"), ticketPercent);
	}

	/**
	 * Fetch progress cards data via AJAX
	 */
	function fetchProgressCards() {
		setProgressSkeleton();
		const filterMonth = $("#filter_month").val();
		const userId = $("#user_id").val();

		$.ajax({
			url: base_url + "project_management/capaian/get_progress_cards",
			method: "POST",
			dataType: "json",
			data: { periode: filterMonth, user_id: userId },
			success: function (response) {
				if (response.status === "success" && response.data) {
					populateProgressCards(response.data);
				} else {
					console.error("Data not found or invalid response");
				}
			},
			error: function (xhr, status, error) {
				console.error("Failed to load progress cards data:", error);
			},
		});
	}

	// ═══════════════════════════════════════════════
	//  STATE
	// ═══════════════════════════════════════════════
	const MONTHS_ID = [
		"Januari",
		"Februari",
		"Maret",
		"April",
		"Mei",
		"Juni",
		"Juli",
		"Agustus",
		"September",
		"Oktober",
		"November",
		"Desember",
	];
	const DAYS_ID = ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"];

	// ═══════════════════════════════════════════════
	//  HELPERS
	// ═══════════════════════════════════════════════
	function daysInMonth(y, m) {
		return new Date(y, m + 1, 0).getDate();
	}
	function dayOfWeek(y, m, d) {
		return new Date(y, m, d).getDay();
	}
	function isWeekend(y, m, d) {
		const w = dayOfWeek(y, m, d);
		return w === 0 || w === 6;
	}

	function parseDay(dateStr, year, month) {
		if (!dateStr) return null;
		const d = new Date(dateStr);
		if (d.getFullYear() === year && d.getMonth() === month) return d.getDate();
		if (
			d.getFullYear() < year ||
			(d.getFullYear() === year && d.getMonth() < month)
		)
			return 0;
		if (
			d.getFullYear() > year ||
			(d.getFullYear() === year && d.getMonth() > month)
		)
			return 32;
		return null;
	}

	let state = {
		year: new Date().getFullYear(),
		month: new Date().getMonth(),
	};

	$container.find("#prevMonth").on("click", () => changeMonth(-1));
	$container.find("#nextMonth").on("click", () => changeMonth(1));

	function changeMonth(delta) {
		state.month += delta;
		if (state.month > 11) {
			state.month = 0;
			state.year++;
		}
		if (state.month < 0) {
			state.month = 11;
			state.year--;
		}
		render();

		const y = state.year;
		const m = String(state.month + 1).padStart(2, "0");
		$("#filter_month").val(`${y}-${m}`).trigger("change");

		fetchUserCapaian();
		fetchProgressCards();
		switchTab("tabs", STATE.tabs.activeTab);
	}

	function render() {
		const { year, month } = state;
		const days = daysInMonth(year, month);
		const today = new Date();
		const todayDay =
			today.getFullYear() === year && today.getMonth() === month
				? today.getDate()
				: -1;

		document.getElementById("monthLabel").textContent =
			`${MONTHS_ID[month]} ${year}`;
	}

	// Initialize datetimepicker for month selection
	$("#monthLabel").datetimepicker({
		timepicker: false,
		format: "Y-m",
		viewMode: "months",
		scrollMonth: false,
		scrollInput: false,
		onChangeDateTime: function (dp, $input) {
			if (dp) {
				const y = dp.getFullYear();
				const m = dp.getMonth();
				state.year = y;
				state.month = m;
				render();

				const mStr = String(m + 1).padStart(2, "0");
				$("#filter_month").val(`${y}-${mStr}`).trigger("change");

				fetchUserCapaian();
				fetchProgressCards();
			}
		},
	});

	// select2 integration
	const defaultUser = $("#user_id option:eq(1)").val();
	$("#user_id").val(defaultUser);
	$("#user_id")
		.select2({
			theme: "bootstrap-5",
			placeholder: "Pilih Karyawan",
			allowClear: true,
			minimumInputLength: 4,
			ajax: {
				url: base_url + "project_management/capaian/get_employees",
				type: "POST",
				dataType: "json",
				delay: 500,
				data: function (params) {
					return {
						search: params.term,
					};
				},
				processResults: function (response) {
					return {
						results: response.results,
					};
				},
				cache: true,
			},
		})
		.on("change", function () {
			fetchUserCapaian();
			fetchProgressCards();
			switchTab("tabs", STATE.tabs.activeTab);
		});

	// Initialize fetching data
	fetchUserCapaian();
	fetchProgressCards();
};
