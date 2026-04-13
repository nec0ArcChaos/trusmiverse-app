window.LoadInit = window.LoadInit || {};
window.LoadInit["menus"] = window.LoadInit["menus"] || {};
window.LoadInit["menus"]["beranda"] = function (container) {
	function animateCountUp($el, toValue, decimals = 0) {
		$({ countNum: parseFloat($el.text()) || 0 }).animate(
			{ countNum: parseFloat(toValue) },
			{
				duration: 2000,
				easing: "swing",
				step: function () {
					$el.text(parseFloat(this.countNum).toFixed(decimals));
				},
				complete: function () {
					$el.text(parseFloat(this.countNum).toFixed(decimals));
				},
			},
		);
	}

	function animateSlamCountUp($el, toMins) {
		let currentMins = parseFloat($el.attr("data-current-mins")) || 0;
		$({ countNum: currentMins }).animate(
			{ countNum: parseFloat(toMins) || 0 },
			{
				duration: 2000,
				easing: "swing",
				step: function () {
					$el.text(formatSlam(this.countNum));
				},
				complete: function () {
					$el.text(formatSlam(this.countNum));
					$el.attr("data-current-mins", toMins);
				},
			},
		);
	}

	function formatSlam(mins) {
		if (!mins || mins <= 0) return "0j 0m";
		let d = Math.floor(mins / 1440);
		let h = Math.floor((mins % 1440) / 60);
		let m = Math.floor(mins % 60);
		return (d > 0 ? d + "h " : "") + h + "j " + m + "m";
	}
	/* ───── Task by Status — Chart.js doughnut ───── */
	var _chartTaskByStatus = null;
	var _displayTotal = 0; // driven by jQuery count-up, read in afterDraw each frame

	function renderTaskByStatusChart(data) {
		var ds = [
			data.not_started || 0,
			data.progress || 0,
			data.done || 0,
			data.qa || 0,
			data.need_data || 0,
			data.cancelled || 0,
		];
		var total = ds.reduce(function (a, b) {
			return a + b;
		}, 0);

		var ctx = document.getElementById("chartTaskByStatus");
		if (!ctx) return;

		// Destroy previous instance if any
		if (_chartTaskByStatus) {
			_chartTaskByStatus.destroy();
		}

		// ── Count-up: runs in parallel with Chart.js animation (same 1400ms) ──
		_displayTotal = 0;
		$({ n: 0 }).animate(
			{ n: total },
			{
				duration: 1400,
				easing: "swing",
				step: function () {
					_displayTotal = Math.round(this.n);
				},
				complete: function () {
					_displayTotal = total;
				},
			},
		);

		_chartTaskByStatus = new Chart(ctx, {
			type: "doughnut",
			data: {
				labels: [
					"Not Started",
					"Progress",
					"Done",
					"QA",
					"Need Data",
					"Cancelled",
				],
				datasets: [
					{
						data: ds,
						backgroundColor: [
							"#9ca3af",
							"#3b82f6",
							"#10b981",
							"#a855f7",
							"#eab308",
							"#ef4444",
						],
						borderWidth: 2,
						borderColor: "#ffffff",
						hoverOffset: 6,
					},
				],
			},
			options: {
				cutout: "68%",
				animation: { duration: 1400, easing: "easeInOutQuart" },
				plugins: {
					legend: { display: false },
					tooltip: {
						callbacks: {
							label: function (ctx) {
								return " " + ctx.label + ": " + ctx.parsed;
							},
						},
					},
				},
			},
			plugins: [
				{
					// Center text plugin — inline, reads _displayTotal each frame
					id: "centerText",
					afterDraw: function (chart) {
						var ctx2 = chart.ctx;
						var cx =
							chart.chartArea.left +
							(chart.chartArea.right - chart.chartArea.left) / 2;
						var cy =
							chart.chartArea.top +
							(chart.chartArea.bottom - chart.chartArea.top) / 2;
						ctx2.save();
						ctx2.textAlign = "center";
						ctx2.textBaseline = "middle";
						ctx2.fillStyle = "#7a93b0";
						ctx2.font = "600 8px Inter, sans-serif";
						ctx2.letterSpacing = "1px";
						ctx2.fillText("Total Task", cx, cy - 10);
						ctx2.fillStyle = "#0d1f3c";
						ctx2.font = "900 26px Orbitron, sans-serif";
						ctx2.fillText(_displayTotal, cx, cy + 14); // ← live count value
						ctx2.restore();
					},
				},
			],
		});
	}

	/* ───── Task Overview Dummy Data ───── */
	function loadTaskOverview(d) {
		// d.weeks = [{ total, done }, ...]   d.ontime, d.late
		var weeks = d.weeks;
		var totalTasks = d.ontime + d.late;
		var avgPct =
			weeks.reduce(function (sum, w) {
				return sum + (w.total > 0 ? (w.done / w.total) * 100 : 0);
			}, 0) / weeks.length;

		// ── Weekly avg bar & color ──
		var avgColor =
			avgPct >= 80 ? "var(--green)" : avgPct >= 50 ? "#f59e0b" : "#ef4444";
		var avgBar =
			avgPct >= 80
				? "linear-gradient(90deg,#22c55e,#16a34a)"
				: avgPct >= 50
					? "linear-gradient(90deg,#f59e0b,#d97706)"
					: "linear-gradient(90deg,#ef4444,#dc2626)";

		setTimeout(function () {
			$("#bar-weekly-avg").css({
				width: avgPct.toFixed(1) + "%",
				background: avgBar,
			});
		}, 50);

		$({ n: 0 }).animate(
			{ n: avgPct },
			{
				duration: 1400,
				easing: "swing",
				step: function () {
					$("#val-weekly-avg")
						.text(parseFloat(this.n).toFixed(1) + "%")
						.css("color", avgColor);
				},
				complete: function () {
					$("#val-weekly-avg").text(avgPct.toFixed(1) + "%");
				},
			},
		);

		// ── Per-week rows ──
		var weekHtml = "";
		weeks.forEach(function (w, i) {
			var pctVal = w.total > 0 ? (w.done / w.total) * 100 : 0;
			var rowColor =
				pctVal === 100 ? "var(--green)" : pctVal >= 50 ? "#f59e0b" : "#ef4444";
			var key = w.name;

			weekHtml +=
				'<div class="d-flex align-items-center justify-content-between" style="font-size:11px; line-height:1.2; padding: 1px 0;">' +
				'<span class="sm-label mb-0" style="width:52px; font-weight:600;">' +
				key +
				"</span>" +
				'<span style="display: inline-block; width: 65px; background:#f1f3f5; color:#555; padding: 2px 6px; border-radius: 4px; font-size: 10px; margin-right: 4px;">Total: <strong>' +
				w.total +
				"</strong></span>" +
				'<span style="display: inline-block; width: 65px; background:#1a1a1a; color:#fff; padding: 2px 6px; border-radius: 4px; font-size: 10px;">Done: <strong>' +
				w.done +
				"</strong></span>" +
				'<span class="cpr-value animate-pct-val" data-val="' +
				pctVal +
				'" id="val-' +
				key.toLowerCase() +
				'-pct" style="min-width:48px; text-align:right; font-weight:700; color:' +
				rowColor +
				';">0%</span>' +
				"</div>";
		});
		$("#weekly-breakdown").html(weekHtml);

		$(".animate-pct-val").each(function () {
			var $el = $(this);
			var toVal = parseFloat($el.attr("data-val"));
			$({ n: 0 }).animate(
				{ n: toVal },
				{
					duration: 1400,
					easing: "swing",
					step: function () {
						$el.text(parseFloat(this.n).toFixed(1) + "%");
					},
					complete: function () {
						$el.text(toVal.toFixed(1) + "%");
					},
				},
			);
		});

		// ── Ringkasan Pekerjaan ──
		var ontimePct =
			totalTasks > 0 ? ((d.ontime / totalTasks) * 100).toFixed(1) : "0.0";
		var latePct =
			totalTasks > 0 ? ((d.late / totalTasks) * 100).toFixed(1) : "0.0";

		setTimeout(function () {
			$("#bar-task-ontime").css("width", ontimePct + "%");
			$("#bar-task-late").css("width", latePct + "%");
		}, 50);

		$({ n: 0 }).animate(
			{ n: parseFloat(ontimePct) },
			{
				duration: 1400,
				easing: "swing",
				step: function () {
					$("#val-ontime-pct").text(parseFloat(this.n).toFixed(0) + "%");
					$("#val-task-ontime-pct").text(parseFloat(this.n).toFixed(1) + "%");
				},
				complete: function () {
					$("#val-ontime-pct").text(Math.round(ontimePct) + "%");
					$("#val-task-ontime-pct").text(ontimePct + "%");
				},
			},
		);

		$({ n: 0 }).animate(
			{ n: d.ontime },
			{
				duration: 1400,
				easing: "swing",
				step: function () {
					$("#val-task-ontime").text(Math.round(this.n));
				},
				complete: function () {
					$("#val-task-ontime").text(d.ontime);
				},
			},
		);

		$({ n: 0 }).animate(
			{ n: d.late },
			{
				duration: 1400,
				easing: "swing",
				step: function () {
					$("#val-task-late").text(Math.round(this.n));
					$("#val-task-late-pct").text(
						parseFloat(latePct * (this.n / d.late)).toFixed(1) + "%",
					);
				},
				complete: function () {
					$("#val-task-late").text(d.late);
					$("#val-task-late-pct").text(latePct + "%");
				},
			},
		);
	}

	$(".period-select").change(function () {
		// dtCampaignStageList.ajax.reload();
		// dtPicActivationList.ajax.reload();
		// dtPicContentList.ajax.reload();
		// dtPicTalentList.ajax.reload();
		// dtPicDistributionList.ajax.reload();
		// dtPicOptimizationList.ajax.reload();
	});

	$("style").append(
		".progressbar-text small { font-size: 10px; } .progressbar-text { font-size: 16px; color: #015EC2 !important; position: absolute; left: 50%; top: 50%; padding: 0px; margin: 0px; transform: translate(-50%, -50%); }",
	);

	$(".tanggal-menit").datetimepicker({
		format: "Y-m-d H:i",
		timepicker: true,
		scrollMonth: false,
		scrollInput: false,
		minDate: 0,
	});

	$(".tanggal-menit").mask("0000-00-00 00:00");
	var start = moment().startOf("month");
	var end = moment().endOf("month");

	function cb(start, end) {
		$("#start_date").val(start.format("YYYY-MM-DD"));
		$("#end_date").val(end.format("YYYY-MM-DD"));
		$(".range").val(
			start.format("DD-MM-YYYY") + " - " + end.format("DD-MM-YYYY"),
		);

		$.post(
			BASE_URL + "project_management/beranda/ajax_dashboard_stats",
			{
				start_date: start.format("YYYY-MM-DD"),
				end_date: end.format("YYYY-MM-DD"),
			},
			function (res) {
				if (res) {
					if (window.Chart) {
						renderTaskByStatusChart(res.statuses);
					} else {
						var s = document.createElement("script");
						s.src =
							"https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js";
						s.onload = function () {
							renderTaskByStatusChart(res.statuses);
						};
						document.head.appendChild(s);
					}
					loadTaskOverview(res);
				}
			},
			"json",
		);

		if (window.loadGanttDataWithDates) {
			$("#gantt-grid-rows").empty();
			$("#gantt-timeline-rows").empty();
			window.loadGanttDataWithDates(
				start.format("YYYY-MM-DD"),
				end.format("YYYY-MM-DD"),
			);

			if (window.setGanttViewProps) {
				var diffDays = end.diff(start, "days");
				var vMode = "1m";
				if (diffDays <= 15) vMode = "2w";
				else if (diffDays <= 45) vMode = "1m";
				else if (diffDays <= 75) vMode = "2m";
				else vMode = "3m";
				window.setGanttViewProps(start.toDate(), vMode);
			}
		}
	}

	$(".range").daterangepicker(
		{
			startDate: start,
			endDate: end,
			drops: "down",
			ranges: {
				Today: [moment(), moment()],
				Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
				"Last 7 Days": [moment().subtract(6, "days"), moment()],
				"Last 30 Days": [moment().subtract(29, "days"), moment()],
				"Last 60 Days": [moment().subtract(59, "days"), moment()],
				"This Month": [moment().startOf("month"), moment().endOf("month")],
				"Last Month": [
					moment().subtract(1, "month").startOf("month"),
					moment().subtract(1, "month").endOf("month"),
				],
			},
		},
		cb,
	);

	// cb(start, end); // Moved to end of Gantt init

	window.ssFilters = window.ssFilters || {};
	/* ───── Gantt Chart ───── */
	(function initGantt() {
		/* ══════════════════════════════════════════════════════════════════
        DATA STORE
        ══════════════════════════════════════════════════════════════════ */
		var nextId = 50;
		var projects = [];
		var ganttLookups = {
			companies: [],
			statuses: [],
			categories: [],
			employees: [],
		};
		var _dragFromIdxInSettings; // Track settings panel dragging

		/* ══════════════════════════════════════════════════════════════════
        COLUMN DEFINITIONS
        ══════════════════════════════════════════════════════════════════ */
		var GANTT_COLS_DEFAULT = [
			{
				key: "text",
				label: "Project / Task Name",
				width: 250,
				minWidth: 250,
				maxWidth: 300,
				sortField: "text",
				fixed: true,
				frozen: true,
				visible: true,
				align: "left",
			},
			{
				key: "company",
				label: "Company",
				width: 100,
				minWidth: 60,
				sortField: "company",
				frozen: false,
				visible: true,
				align: "center",
			},
			{
				key: "pic",
				label: "PIC",
				width: 120,
				minWidth: 60,
				sortField: "pic",
				frozen: false,
				visible: true,
				align: "center",
			},
			{
				key: "requester",
				label: "Requester / PO",
				width: 120,
				minWidth: 80,
				sortField: "requester",
				frozen: false,
				visible: true,
				align: "center",
			},
			{
				key: "evidence",
				label: "Evidences",
				width: 100,
				minWidth: 70,
				sortField: null,
				frozen: false,
				visible: true,
				align: "center",
			},
			{
				key: "status",
				label: "Status",
				width: 100,
				minWidth: 70,
				sortField: "status",
				frozen: false,
				visible: true,
				align: "center",
			},
			{
				key: "category",
				label: "Category",
				width: 120,
				minWidth: 70,
				sortField: "category",
				frozen: false,
				visible: true,
				align: "center",
			},
			{
				key: "week",
				label: "Week",
				width: 70,
				minWidth: 50,
				sortField: "week",
				frozen: false,
				visible: true,
				align: "center",
			},
			{
				key: "progress",
				label: "Progress",
				width: 90,
				minWidth: 60,
				sortField: "progress",
				frozen: false,
				visible: true,
				align: "center",
			},
			{
				key: "start",
				label: "Tgl Mulai",
				width: 140,
				minWidth: 100,
				sortField: "start",
				frozen: false,
				visible: true,
				align: "center",
			},
			{
				key: "estimasi",
				label: "Estimasi",
				width: 70,
				minWidth: 50,
				sortField: "estimasi",
				frozen: false,
				visible: true,
				align: "center",
			},
			{
				key: "end",
				label: "Tgl Deadline",
				width: 140,
				minWidth: 100,
				sortField: "end",
				frozen: false,
				visible: true,
				align: "center",
			},
			{
				key: "tglSelesai",
				label: "Tgl Selesai",
				width: 140,
				minWidth: 100,
				sortField: "tglSelesai",
				frozen: false,
				visible: true,
				align: "center",
			},
			{
				key: "leadtime_pct",
				label: "Leadtime (%)",
				width: 90,
				minWidth: 60,
				sortField: "leadtime_pct",
				frozen: false,
				visible: true,
				align: "center",
			},
			{
				key: "leadtime_status",
				label: "Status Leadtime",
				width: 110,
				minWidth: 80,
				sortField: "leadtime_status",
				frozen: false,
				visible: true,
				align: "center",
			},
			{
				key: "leadtime_diff",
				label: "Diff LT",
				width: 70,
				minWidth: 50,
				sortField: "leadtime_diff",
				frozen: false,
				visible: true,
				align: "center",
			},
			{
				key: "leadtime_days",
				label: "LT Days",
				width: 60,
				minWidth: 40,
				sortField: "leadtime_days",
				frozen: false,
				visible: true,
				align: "center",
			},
		];

		// Deep clone helper
		function cloneCols(arr) {
			return arr.map(function (c) {
				return $.extend({}, c);
			});
		}
		var ganttColumns = cloneCols(GANTT_COLS_DEFAULT);

		window.loadGanttDataWithDates = function (start_str, end_str) {
			$("#gantt-loader").show().css("opacity", "1");
			$("#gantt-grid-rows").empty();
			$("#gantt-timeline-rows").empty();
			projects = [];
			$.when(
				$.getJSON(BASE_URL + "project_management/beranda/get_lookup_options"),
				$.getJSON(BASE_URL + "project_management/beranda/get_gantt_data", {
					start_date: start_str,
					end_date: end_str,
				}),
				$.getJSON(BASE_URL + "project_management/beranda/get_gantt_view"),
			)
				.done(function (lookupRes, dataRes, viewRes) {
					ganttLookups = lookupRes[0];
					projects = dataRes[0];
					applyViewConfig(viewRes[0] || {});
					populateFilters();
					preprocessData();
					// Explicitly sort with the loaded field before rendering
					sortGanttData(ganttSort.field, true);
					$("#gantt-loader").fadeOut(200);
				})
				.fail(function (err) {
					console.error("Error fetching Gantt data:", err);
					$("#gantt-loader").hide();
				});
		};

		function loadGanttData() {
			var start =
				$("#start_date").val() ||
				moment().startOf("month").format("YYYY-MM-DD");
			var end =
				$("#end_date").val() || moment().endOf("month").format("YYYY-MM-DD");
			window.loadGanttDataWithDates(start, end);
		}

		/* ══════════════════════════════════════════════════════════════════
        SORTING
        ══════════════════════════════════════════════════════════════════ */
		var ganttSort = { field: "start", dir: "asc" };

		function calcLeadtimeForItem(item) {
			var startM = item.start ? moment(item.start) : null;
			var endM = item.end ? moment(item.end) : null;
			var finishM = item.tglSelesai ? moment(item.tglSelesai) : null;
			var todayM = moment().startOf("day");
			var pct = parseInt(item.progress || 0, 10);

			if (startM && endM && startM.isValid() && endM.isValid()) {
				var compareDate = finishM && finishM.isValid() ? finishM : todayM;
				var totalDays = Math.max(1, endM.diff(startM, "days"));
				var elapsedDays = compareDate.diff(startM, "days");

				item._lt_days = Math.max(0, elapsedDays);
				if (elapsedDays < 0) {
					item._lt_pct = 0;
					item._lt_diff = pct;
					item._lt_status = pct > 0 ? "Ontime" : "Pending";
				} else {
					item._lt_pct = Math.round((elapsedDays / totalDays) * 100);
					item._lt_diff = pct - item._lt_pct;
					item._lt_status = item._lt_diff < 0 ? "Late" : "Ontime";
				}
			} else {
				item._lt_pct = 0;
				item._lt_diff = 0;
				item._lt_days = 0;
				item._lt_status = pct > 0 ? "Ontime" : "Pending";
			}
		}

		function sortGanttData(field, skipToggle) {
			if (!skipToggle) {
				if (ganttSort.field === field) {
					ganttSort.dir = ganttSort.dir === "asc" ? "desc" : "asc";
				} else {
					ganttSort.field = field;
					ganttSort.dir = "asc";
				}
			}

			// Map header data-sort keys to actual item properties
			var ltFieldMap = {
				leadtime_pct: "_lt_pct",
				leadtime_diff: "_lt_diff",
				leadtime_days: "_lt_days",
				leadtime_status: "_lt_status",
			};
			var resolvedField = ltFieldMap[field] || field;
			var isLtField = !!ltFieldMap[field];

			// For leadtime fields, pre-calculate values on every item first
			if (isLtField) {
				projects.forEach(function (p) {
					calcLeadtimeForItem(p);
					if (p.tasks) p.tasks.forEach(calcLeadtimeForItem);
				});
			}

			var dir = ganttSort.dir === "asc" ? 1 : -1;

			function gCompare(a, b) {
				var valA = a[resolvedField];
				var valB = b[resolvedField];
				if (valA === undefined || valA === null) valA = "";
				if (valB === undefined || valB === null) valB = "";

				// Date handling
				if (["start", "end", "tglSelesai"].indexOf(field) !== -1) {
					valA = valA ? new Date(valA).getTime() : 0;
					valB = valB ? new Date(valB).getTime() : 0;
				}

				// String handling
				if (typeof valA === "string" && typeof valB === "string") {
					return valA.localeCompare(valB) * dir;
				}

				// Numeric handling
				if (valA < valB) return -1 * dir;
				if (valA > valB) return 1 * dir;
				return 0;
			}

			// Sort projects
			projects.sort(gCompare);

			// Sort tasks within projects
			projects.forEach(function (p) {
				if (p.tasks) p.tasks.sort(gCompare);
			});

			updateSortIcons();
			render();
			saveView();
		}

		function updateSortIcons() {
			$("#gantt-col-header .sort-icon").html("");
			var iconClass = ganttSort.dir === "asc" ? "bi-sort-down" : "bi-sort-up";
			$(
				'#gantt-col-header [data-sort="' + ganttSort.field + '"] .sort-icon',
			).html(
				'<i class="bi ' +
					iconClass +
					'" style="margin-left:4px; font-size:12px; color:var(--accent);"></i>',
			);
		}

		$(document).on("click", ".g-sortable", function (e) {
			if ($(e.target).closest(".gcol-resize-handle, .gcol-freeze-btn").length)
				return;
			var field = $(this).data("sort");
			if (field) sortGanttData(field);
		});

		/* ══════════════════════════════════════════════════════════════════
        VIEW CONFIG (persist per-user)
        ══════════════════════════════════════════════════════════════════ */
		var _saveViewTimer = null;

		function applyViewConfig(cfg) {
			if (!cfg || !cfg.column_order) return;

			var order =
				typeof cfg.column_order === "string"
					? JSON.parse(cfg.column_order)
					: cfg.column_order;
			var hidden =
				typeof cfg.hidden_columns === "string"
					? JSON.parse(cfg.hidden_columns)
					: cfg.hidden_columns || [];
			var widths =
				typeof cfg.column_widths === "string"
					? JSON.parse(cfg.column_widths)
					: cfg.column_widths || {};
			var frozen =
				typeof cfg.frozen_columns === "string"
					? JSON.parse(cfg.frozen_columns)
					: cfg.frozen_columns || [];

			if (cfg.sort_field) {
				ganttSort.field = cfg.sort_field;
				ganttSort.dir = cfg.sort_dir || "asc";
			}
			if (cfg.grid_width) {
				$("#gantt-grid").css("width", cfg.grid_width + "px");
			}

			// Re-order by saved order
			var ordered = [];
			order.forEach(function (key) {
				var col = ganttColumns.find(function (c) {
					return c.key === key;
				});
				if (col) ordered.push(col);
			});
			// Append any unsaved new columns that weren't in saved order
			ganttColumns.forEach(function (c) {
				if (
					!ordered.find(function (o) {
						return o.key === c.key;
					})
				)
					ordered.push(c);
			});
			ganttColumns = ordered;

			// Apply visibility, widths, frozen
			ganttColumns.forEach(function (col) {
				col.visible = hidden.indexOf(col.key) === -1;
				if (widths[col.key]) col.width = widths[col.key];
				col.frozen = col.fixed ? true : frozen.indexOf(col.key) !== -1;
			});
		}

		function getViewState() {
			var widths = {},
				frozen = [];
			var order = ganttColumns.map(function (c) {
				return c.key;
			});
			var hidden = ganttColumns
				.filter(function (c) {
					return !c.visible;
				})
				.map(function (c) {
					return c.key;
				});
			ganttColumns.forEach(function (c) {
				widths[c.key] = c.width;
				if (c.frozen && !c.fixed) frozen.push(c.key);
			});
			return {
				column_order: order,
				hidden_columns: hidden,
				column_widths: widths,
				frozen_columns: frozen,
				sort_field: ganttSort.field,
				sort_dir: ganttSort.dir,
				grid_width: $("#gantt-grid").width(),
			};
		}

		function saveView() {
			clearTimeout(_saveViewTimer);
			_saveViewTimer = setTimeout(function () {
				$.ajax({
					url: BASE_URL + "project_management/beranda/save_gantt_view",
					method: "POST",
					contentType: "application/json",
					data: JSON.stringify(getViewState()),
				});
			}, 600);
		}

		/* ══════════════════════════════════════════════════════════════════
        DYNAMIC COLUMN HEADER RENDERING
        ══════════════════════════════════════════════════════════════════ */
		var _dragCol = null,
			_dragFromIdx = -1;

		function renderColHeader() {
			var $hdr = $("#gantt-col-header");
			$hdr.empty();

			var stickyLeft = 0;
			var visibleCols = ganttColumns.filter(function (c) {
				return c.visible;
			});

			visibleCols.forEach(function (col, idx) {
				var isSortable = !!col.sortField;
				var isFixed = !!col.fixed;
				var isFrozen = !!col.frozen;

				var w = col.key === "text" ? col.width : col.width;
				// console.log(w);

				var stickyStyle = isFrozen
					? "position:sticky; left:" +
						stickyLeft +
						"px; z-index:3; background:#f8fafc;"
					: "";
				if (isFrozen) stickyLeft += w;

				var sortAttr = isSortable ? ' data-sort="' + col.sortField + '"' : "";
				var sortCls = isSortable ? " g-sortable" : "";
				var nameCls = col.key === "text" ? " gcol-name" : "";
				var textStyle =
					col.key === "text" && !isFrozen
						? "min-width:" +
							col.minWidth +
							"px; max-width:" +
							col.maxWidth +
							"px; flex:1;"
						: "width:" + w + "px;";
				var alignStyle =
					col.align === "center" ? "justify-content:center;" : "";
				var freezeIcon = !isFixed
					? '<button class="gcol-freeze-btn" title="' +
						(isFrozen ? "Unfreeze" : "Freeze") +
						' column" data-key="' +
						col.key +
						'" style="background:none;border:none;padding:0;cursor:pointer;color:' +
						(isFrozen ? "var(--accent)" : "#d1d5db") +
						';font-size:11px; flex-shrink:0;"><i class="bi bi-pin' +
						(isFrozen ? "-fill" : "") +
						'"></i></button>'
					: "";

				var $col = $("<div>")
					.addClass("gcol" + nameCls + sortCls)
					.attr("data-col-key", col.key)
					.attr(isSortable ? "data-sort" : "x", isSortable ? col.sortField : "")
					.css({
						width: col.key === "text" && !isFrozen ? "" : w + "px",
						"min-width":
							col.key === "text" && !isFrozen ? col.minWidth + "px" : w + "px",
						flex: col.key === "text" && !isFrozen ? "1" : "0 0 " + w + "px",
						cursor: isSortable ? "pointer" : "default",
						position: isFrozen ? "sticky" : "",
						left: isFrozen ? stickyLeft - w + "px" : "",
						"z-index": isFrozen ? 3 : "",
						background: isFrozen ? "#f8fafc" : "",
						"justify-content": col.align === "center" ? "center" : "flex-start",
						"border-right": isFrozen ? "2px solid #cbd5e1" : "",
					})
					.html(
						'<span class="gcol-label" style="flex:1; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">' +
							col.label +
							'</span><span class="sort-icon"></span>' +
							freezeIcon +
							(!isFixed
								? '<span class="gcol-resize-handle" data-key="' +
									col.key +
									'" style="width:5px;cursor:col-resize;position:absolute;right:0;top:0;height:100%;z-index:4;background:transparent;"></span>'
								: ""),
					);

				// Drag to reorder
				if (!isFixed) {
					$col
						.attr("draggable", true)
						.on("dragstart", function (e) {
							_dragFromIdx = idx;
							_dragCol = col.key;
							e.originalEvent.dataTransfer.effectAllowed = "move";
							$(this).css("opacity", "0.5");
						})
						.on("dragend", function () {
							$(this).css("opacity", "");
							$("#gantt-col-header .gcol").css("border-left", "");
						})
						.on("dragover", function (e) {
							e.preventDefault();
							$("#gantt-col-header .gcol").css("border-left", "");
							$(this).css("border-left", "2px solid var(--accent)");
						})
						.on("drop", function (e) {
							e.preventDefault();
							var toKey = $(this).data("col-key");
							if (!toKey || toKey === _dragCol) return;
							var fromIdx = ganttColumns.findIndex(function (c) {
								return c.key === _dragCol;
							});
							var toIdx = ganttColumns.findIndex(function (c) {
								return c.key === toKey;
							});
							if (fromIdx === -1 || toIdx === -1) return;
							var moved = ganttColumns.splice(fromIdx, 1)[0];
							ganttColumns.splice(toIdx, 0, moved);
							renderColHeader();
							render();
							saveView();
						});
				}

				$hdr.append($col);
			});

			// Column resize via handle
			$hdr.find(".gcol-resize-handle").on("mousedown", function (e) {
				e.stopPropagation();
				e.preventDefault();
				var key = $(this).data("key");
				var col = ganttColumns.find(function (c) {
					return c.key === key;
				});
				var startX = e.clientX;
				var startW = col.width;
				$(document).on("mousemove.colresize", function (ev) {
					col.width = Math.max(col.minWidth, startW + ev.clientX - startX);
					renderColHeader();
				});
				$(document).on("mouseup.colresize", function () {
					$(document).off("mousemove.colresize mouseup.colresize");
					render();
					saveView();
				});
			});

			// Freeze toggle via pin button
			$hdr.find(".gcol-freeze-btn").on("click", function (e) {
				e.stopPropagation();
				var key = $(this).data("key");
				var col = ganttColumns.find(function (c) {
					return c.key === key;
				});
				if (!col) return;
				col.frozen = !col.frozen;
				// Move frozen columns to front (after fixed), non-frozen back
				var fixed = ganttColumns.filter(function (c) {
					return c.fixed;
				});
				var frozen = ganttColumns.filter(function (c) {
					return c.frozen && !c.fixed;
				});
				var rest = ganttColumns.filter(function (c) {
					return !c.frozen && !c.fixed;
				});
				ganttColumns = fixed.concat(frozen).concat(rest);
				renderColHeader();
				render();
				saveView();
			});

			updateSortIcons();
		}

		/* ══════════════════════════════════════════════════════════════════
        SETTINGS PANEL
        ══════════════════════════════════════════════════════════════════ */
		function renderSettingsPanel() {
			var $list = $("#g-col-settings-list").empty();

			// Bulk toggle row
			var configurableCols = ganttColumns.filter(function (c) {
				return !c.fixed;
			});
			var visibleConfigurable = configurableCols.filter(function (c) {
				return c.visible;
			});
			var isAllChecked =
				visibleConfigurable.length === configurableCols.length &&
				configurableCols.length > 0;

			var $bulkRow = $("<div>").css({
				display: "flex",
				alignItems: "center",
				gap: "12px",
				padding: "10px 16px",
				background: "#f8fafc",
				borderBottom: "1px solid #e2e8f0",
				marginBottom: "4px",
				cursor: "pointer",
			});
			var $bulkChk = $('<input type="checkbox">')
				.prop("checked", isAllChecked)
				.css({ cursor: "pointer", width: "15px", height: "15px" });
			var $bulkLbl = $("<span>")
				.text(isAllChecked ? "Unselect All" : "Select All")
				.css({
					fontSize: "11px",
					fontWeight: "800",
					textTransform: "uppercase",
					letterSpacing: "0.5px",
					color: "#64748b",
					flex: 1,
				});

			$bulkRow.on("click", function (e) {
				if (e.target !== $bulkChk[0]) {
					$bulkChk.prop("checked", !$bulkChk.prop("checked")).trigger("change");
				}
			});
			$bulkChk.on("change", function (e) {
				e.stopPropagation();
				var checked = this.checked;
				ganttColumns.forEach(function (c) {
					if (!c.fixed) c.visible = checked;
				});
				renderColHeader();
				render();
				renderSettingsPanel();
			});
			$bulkRow.append($bulkChk, $bulkLbl);
			$list.append($bulkRow);

			ganttColumns.forEach(function (col, idx) {
				if (col.fixed) return; // text column cannot be configured
				var $row = $("<div>")
					.attr("draggable", true) // Enable dragging
					.css({
						display: "flex",
						alignItems: "center",
						gap: "10px",
						padding: "8px 16px",
						cursor: "grab",
						borderBottom: "1px solid #f8fafc",
						background: "#fff",
						transition: "background 0.1s",
					});

				var $drag = $("<i>").addClass("bi bi-grip-vertical").css({
					color: "#d1d5db",
					fontSize: "14px",
					cursor: "grab",
					flexShrink: 0,
				});
				var $chk = $('<input type="checkbox">')
					.prop("checked", col.visible)
					.css({
						cursor: "pointer",
						width: "15px",
						height: "15px",
						flexShrink: 0,
					});
				var $pin = $("<i>")
					.addClass("bi bi-pin" + (col.frozen ? "-fill" : ""))
					.css({
						color: col.frozen ? "var(--accent)" : "#d1d5db",
						fontSize: "13px",
						cursor: "pointer",
						flexShrink: 0,
						marginLeft: "auto",
					})
					.attr("title", col.frozen ? "Unfreeze" : "Freeze");
				var $label = $("<span>").text(col.label).css({
					fontSize: "12px",
					flex: 1,
					color: "#374151",
					userSelect: "none",
				});

				$chk.on("change", function () {
					col.visible = this.checked;
					renderColHeader();
					render();
					renderSettingsPanel();
				});
				$pin.on("click", function () {
					col.frozen = !col.frozen;
					var fixed = ganttColumns.filter(function (c) {
						return c.fixed;
					});
					var frozen = ganttColumns.filter(function (c) {
						return c.frozen && !c.fixed;
					});
					var rest = ganttColumns.filter(function (c) {
						return !c.frozen && !c.fixed;
					});
					ganttColumns = fixed.concat(frozen).concat(rest);
					renderColHeader();
					render();
					renderSettingsPanel();
				});

				// Drag & Drop for reordering
				$row.on("dragstart", function (e) {
					_dragFromIdxInSettings = idx;
					$(this).css("opacity", "0.4");
					e.originalEvent.dataTransfer.effectAllowed = "move";
				});
				$row.on("dragend", function () {
					$(this).css("opacity", "1");
					$list.find("div").css("border-top", "");
				});
				$row.on("dragover", function (e) {
					e.preventDefault();
					if (_dragFromIdxInSettings === idx) return;
					$(this).css("border-top", "2px solid var(--accent)");
				});
				$row.on("dragleave", function () {
					$(this).css("border-top", "");
				});
				$row.on("drop", function (e) {
					e.preventDefault();
					$(this).css("border-top", "");
					if (
						_dragFromIdxInSettings === undefined ||
						_dragFromIdxInSettings === idx
					)
						return;

					var moved = ganttColumns.splice(_dragFromIdxInSettings, 1)[0];
					ganttColumns.splice(idx, 0, moved);

					// Re-sort to maintain frozen order: Fixed -> Frozen -> Others
					var fixed = ganttColumns.filter(function (c) {
						return c.fixed;
					});
					var frozen = ganttColumns.filter(function (c) {
						return c.frozen && !c.fixed;
					});
					var rest = ganttColumns.filter(function (c) {
						return !c.frozen && !c.fixed;
					});
					ganttColumns = fixed.concat(frozen).concat(rest);

					renderColHeader();
					render();
					renderSettingsPanel();
				});

				$row.append($drag, $chk, $label, $pin);
				$list.append($row);
			});
		}

		$("#g-view-settings-btn").on("click", function () {
			renderSettingsPanel();
			$("#gantt-view-settings").addClass("is-open");
			$("#gantt-view-settings-overlay").show();
		});
		$("#g-settings-close, #gantt-view-settings-overlay").on(
			"click",
			function () {
				$("#gantt-view-settings").removeClass("is-open");
				$("#gantt-view-settings-overlay").hide();
				saveView();
			},
		);
		$("#g-save-view").on("click", function () {
			saveView();
			$(this)
				.html('<i class="bi bi-check-lg"></i> Saved!')
				.css("background", "#10b981");
			setTimeout(function () {
				$("#g-save-view")
					.html('<i class="bi bi-floppy"></i> Save')
					.css("background", "");
			}, 1500);
		});
		$("#g-reset-view").on("click", function () {
			if (!confirm("Reset columns to default layout?")) return;
			ganttColumns = cloneCols(GANTT_COLS_DEFAULT);
			ganttSort = { field: "start", dir: "asc" };
			renderColHeader();
			renderSettingsPanel();
			render();
			saveView();
		});

		window.setGanttViewProps = function (dStart, mode) {
			viewStart = dStart;
			viewMode = mode;
			$("#g-view-mode").val(mode);
			applyViewMode(mode);
		};

		var isInitializingFilters = false;
		function populateFilters() {
			isInitializingFilters = true;
			var filterIds = [
				"#g-filter-company",
				"#g-filter-status",
				"#g-filter-category",
				"#g-filter-pic",
			];
			var dataSets = {
				"#g-filter-company": [{ text: "All Companies", value: "all" }],
				"#g-filter-status": [{ text: "All Status", value: "all" }],
				"#g-filter-category": [{ text: "All Categories", value: "all" }],
				"#g-filter-pic": [{ text: "All PIC", value: "all" }],
			};

			// Build data sets from lookups
			if (ganttLookups.companies) {
				ganttLookups.companies.forEach(function (c) {
					if (c.alias)
						dataSets["#g-filter-company"].push({
							text: c.alias,
							value: c.alias,
						});
				});
			}
			if (ganttLookups.statuses) {
				ganttLookups.statuses.forEach(function (s) {
					if (s.status_name)
						dataSets["#g-filter-status"].push({
							text: s.status_name,
							value: s.status_name,
						});
				});
			}
			if (ganttLookups.categories) {
				ganttLookups.categories.forEach(function (c) {
					if (c.category)
						dataSets["#g-filter-category"].push({
							text: c.category,
							value: c.category,
						});
				});
			}
			if (ganttLookups.employees) {
				ganttLookups.employees.forEach(function (e) {
					var name = ((e.first_name || "") + " " + (e.last_name || "")).trim();
					dataSets["#g-filter-pic"].push({
						text: name,
						value: String(e.user_id),
					});
				});
			}

			filterIds.forEach(function (id) {
				var $el = $(id);
				if (!$el.length) return;
				var data = dataSets[id];

				if (window.SlimSelect && window.ssFilters[id]) {
					// Method 1: Use setData if instance already exists
					try {
						window.ssFilters[id].setData(data);
					} catch (e) {
						console.error("Error updating SlimSelect data for " + id + ":", e);
						// Fallback: Destroy and re-create if setData fails
						try {
							window.ssFilters[id].destroy();
						} catch (err) {}
						delete window.ssFilters[id];
						initNewSlimSelect(id, data);
					}
				} else {
					// Method 2: Initial HTML update and SlimSelect init
					var html = "";
					data.forEach(function (d) {
						html += '<option value="' + d.value + '">' + d.text + "</option>";
					});
					$el.html(html);

					if (window.SlimSelect) {
						initNewSlimSelect(id, data);
					}
				}
			});

			function initNewSlimSelect(id, data) {
				window.ssFilters[id] = new SlimSelect({
					select: id,
					settings: {
						showSearch: true,
						placeholderText: data[0].text,
					},
					events: {
						afterChange: function () {
							render();
						},
					},
				});
			}
			isInitializingFilters = false;
		}

		// Cache preprocessed results to avoid re-calculation in every render
		function preprocessData() {
			projects.forEach(function (proj) {
				if (proj.tasks && proj.tasks.length > 0) {
					var totalPct = 0;
					var picSet = {};
					var picIdSet = {};
					proj.tasks.forEach(function (t) {
						totalPct += parseInt(t.progress || 0, 10);
						var pics = (t.pic || "")
							.split(",")
							.map(function (s) {
								return s.trim();
							})
							.filter(Boolean);
						pics.forEach(function (p) {
							picSet[p] = true;
						});

						var picIds = (t.pic_id || "")
							.toString()
							.split(",")
							.map(function (s) {
								return s.trim();
							})
							.filter(Boolean);
						picIds.forEach(function (pid) {
							picIdSet[pid] = true;
						});
					});
					proj.progress = Math.round(totalPct / proj.tasks.length);
					proj.pic = Object.keys(picSet).join(", ");
					proj.pic_id = Object.keys(picIdSet).join(", ");
				}
			});
		}

		/* ══════════════════════════════════════════════════════════════════
        CONFIG & STATE
        ══════════════════════════════════════════════════════════════════ */
		var DAY_W = 40; // px per day
		var ROW_H = 44; // px per row

		var today = new Date();
		today.setHours(0, 0, 0, 0);

		// View start & length (in days)
		var viewStart = new Date(today.getFullYear(), today.getMonth(), 1);
		var viewDays = 31;

		var viewMode = "1m"; // '2w' | '1m' | '3m'

		var ctxItemId = null;
		var ctxItemType = null;
		var dragState = null;
		var activePopId = null;
		var activePopType = null;

		var DAY_NAMES = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
		var MONTH_SHORT = [
			"Jan",
			"Feb",
			"Mar",
			"Apr",
			"May",
			"Jun",
			"Jul",
			"Aug",
			"Sep",
			"Oct",
			"Nov",
			"Dec",
		];
		var MONTH_LONG = [
			"January",
			"February",
			"March",
			"April",
			"May",
			"June",
			"July",
			"August",
			"September",
			"October",
			"November",
			"December",
		];

		/* ══════════════════════════════════════════════════════════════════
        DATE HELPERS
        ══════════════════════════════════════════════════════════════════ */
		function addDays(d, n) {
			var r = new Date(d);
			r.setDate(r.getDate() + n);
			return r;
		}

		function parseDate(str) {
			if (!str) return null;
			var parts = str.split(" ");
			var ds = parts[0].split("-");
			var yr = parseInt(ds[0], 10),
				mo = parseInt(ds[1] || 1, 10) - 1,
				dy = parseInt(ds[2] || 1, 10);
			var d = new Date(yr, mo, dy);
			if (parts[1]) {
				var ts = parts[1].split(":");
				d.setHours(
					parseInt(ts[0] || 0, 10),
					parseInt(ts[1] || 0, 10),
					parseInt(ts[2] || 0, 10),
					0,
				);
			} else {
				d.setHours(0, 0, 0, 0);
			}
			return d;
		}

		function isoDate(d) {
			return (
				d.getFullYear() +
				"-" +
				String(d.getMonth() + 1).padStart(2, "0") +
				"-" +
				String(d.getDate()).padStart(2, "0") +
				" " +
				String(d.getHours()).padStart(2, "0") +
				":" +
				String(d.getMinutes()).padStart(2, "0") +
				":" +
				String(d.getSeconds()).padStart(2, "0")
			);
		}

		function fmtShort(str) {
			if (!str) return "-";
			var d = parseDate(str);
			return MONTH_SHORT[d.getMonth()] + " " + d.getDate();
		}

		function fmtFull(str) {
			if (!str) return "-";
			var d = parseDate(str);
			return (
				d.getDate() +
				" " +
				MONTH_SHORT[d.getMonth()] +
				" " +
				d.getFullYear() +
				" " +
				String(d.getHours()).padStart(2, "0") +
				":" +
				String(d.getMinutes()).padStart(2, "0")
			);
		}
		function weekNum(d) {
			if (!d) return 1;
			var year = d.getFullYear();
			var month = d.getMonth();
			var calcW = function (dateObj) {
				var firstDay = new Date(year, month, 1);
				return Math.ceil((dateObj.getDate() + firstDay.getDay()) / 7);
			};

			var lastDay = new Date(year, month + 1, 0);
			var totalWeeks = calcW(lastDay);
			var rawW = calcW(d);

			if (totalWeeks <= 4) return rawW;

			var getWorkDays = function (w) {
				var count = 0;
				for (var i = 1; i <= lastDay.getDate(); i++) {
					var curr = new Date(year, month, i);
					if (calcW(curr) === w && curr.getDay() !== 0) {
						// 0 is Sunday
						count++;
					}
				}
				return count;
			};

			if (totalWeeks === 5) {
				var wd1 = getWorkDays(1);
				var wd5 = getWorkDays(5);
				if (wd1 < wd5) {
					if (rawW <= 2) return 1;
					if (rawW === 3) return 2;
					if (rawW === 4) return 3;
					if (rawW === 5) return 4;
				} else {
					if (rawW === 1) return 1;
					if (rawW === 2) return 2;
					if (rawW === 3) return 3;
					if (rawW >= 4) return 4;
				}
			} else {
				if (rawW <= 2) return 1;
				if (rawW === 3) return 2;
				if (rawW === 4) return 3;
				if (rawW >= 5) return 4;
			}
			return Math.min(4, Math.max(1, rawW));
		}

		// X position from date string (px offset from viewStart)
		function dateToX(str) {
			var d = parseDate(str);
			if (!d) return -9999;
			return Math.round((d - viewStart) / 86400000) * DAY_W;
		}

		/* ══════════════════════════════════════════════════════════════════
        VIEW RANGE
        ══════════════════════════════════════════════════════════════════ */
		function applyViewMode(mode) {
			viewMode = mode;
			var t = new Date(viewStart);
			if (mode === "2w") {
				viewDays = 14;
			} else if (mode === "2m") {
				viewDays = 61;
			} else if (mode === "3m") {
				viewDays = 92;
			} else {
				// 1m: number of days in the current month
				viewDays = new Date(t.getFullYear(), t.getMonth() + 1, 0).getDate();
			}
		}

		function updateWeekLabel() {
			var end = addDays(viewStart, viewDays - 1);
			var mS = MONTH_LONG[viewStart.getMonth()];
			var yS = viewStart.getFullYear();
			var mE = MONTH_LONG[end.getMonth()];
			var yE = end.getFullYear();

			var title = mS;
			if (mS !== mE || yS !== yE) {
				if (yS === yE) {
					title = mS + " – " + mE + " " + yS;
				} else {
					title = mS + " " + yS + " – " + mE + " " + yE;
				}
			} else {
				title = mS + " " + yS;
			}

			$("#g-week-num").text(title);
			$("#g-week-range").text(
				fmtShort(isoDate(viewStart)) + " – " + fmtShort(isoDate(end)),
			);
		}

		/* ══════════════════════════════════════════════════════════════════
        FIND ITEM
        ══════════════════════════════════════════════════════════════════ */
		function findItem(id, type) {
			for (var i = 0; i < projects.length; i++) {
				// If searching for project specifically OR searching generally (no type)
				if ((!type || type === "project") && projects[i].id === id) {
					return { item: projects[i], parent: null, idx: i };
				}

				var tasks = projects[i].tasks || [];
				for (var j = 0; j < tasks.length; j++) {
					// If searching for task specifically OR searching generally (no type)
					if ((!type || type === "task") && tasks[j].id === id) {
						return { item: tasks[j], parent: projects[i], idx: j };
					}
				}
			}
			return null;
		}

		/* ══════════════════════════════════════════════════════════════════
        AVATAR TOOLTIP JS HANDLERS
        ══════════════════════════════════════════════════════════════════ */
		window.ganttShowAvTip = function (e, name) {
			var $tt = $("#gantt-av-tooltip");
			$("#gantt-av-tooltip-text").text(name);
			var rect = e.target.getBoundingClientRect();
			$tt.css({
				top: rect.top - $tt.outerHeight() - 6 + "px",
				left: rect.left + rect.width / 2 + "px",
				display: "block",
			});
		};

		window.ganttHideAvTip = function () {
			$("#gantt-av-tooltip").hide();
		};

		/* ══════════════════════════════════════════════════════════════════
        HTML HELPERS
        ══════════════════════════════════════════════════════════════════ */

		function avHtml(idStr, size, id, fieldType, itemType, hasTasks) {
			size = size || 22;
			fieldType = fieldType || "pic";
			var canEdit =
				id !== null &&
				id !== undefined &&
				itemType &&
				(fieldType != "pic" || !hasTasks);
			if (!idStr) {
				if (!canEdit)
					return '<span style="color:#a1a1aa;font-size:11px;">—</span>';
				return (
					'<div onclick="openGanttDropdown(event, ' +
					id +
					", '" +
					itemType +
					"', '" +
					fieldType +
					'\')" style="width:' +
					size +
					"px;height:" +
					size +
					'px;border-radius:50%;border:1px dashed #cbd5e1;display:flex;align-items:center;justify-content:center;color:#94a3b8;cursor:pointer;font-size:10px;"><i class="bi bi-plus"></i></div>'
				);
			}
			var uids = idStr
				.toString()
				.split(",")
				.map(function (s) {
					return s.trim();
				})
				.filter(function (s) {
					return s;
				});
			var clickAttrs = canEdit
				? 'onclick="openGanttDropdown(event, ' +
					id +
					", '" +
					itemType +
					"', '" +
					fieldType +
					'\')" style="cursor:pointer; padding:2px; margin:-2px; border-radius:12px; transition:background 0.2s;" onmouseover="this.style.background=\'#f1f5f9\'" onmouseout="this.style.background=\'transparent\'"'
				: 'style="padding:2px; margin:-2px; border-radius:12px;"';
			var h = '<div class="av-group" ' + clickAttrs + ">";
			var extraNames = [];
			uids.forEach(function (uid, i) {
				var allUsers = [].concat(
					ganttLookups.employees || [],
					ganttLookups.product_owners || [],
				);
				var emp = allUsers.find(function (e) {
					return e.user_id.toString() === uid;
				});
				var name = emp
					? ((emp.first_name || "") + " " + (emp.last_name || "")).trim()
					: "Unknown";
				if (i > 2) {
					extraNames.push(name);
					return;
				}
				var margin = i > 0 ? "margin-left:-5px;" : "";
				var imgSrc = "";
				var uiAv =
					"https://ui-avatars.com/api/?name=" +
					encodeURIComponent(name) +
					"&background=random&color=fff&size=" +
					size +
					"&rounded=true&bold=true";
				if (emp && emp.profile_picture) {
					imgSrc =
						"https://trusmiverse.com/hr/uploads/profile/" + emp.profile_picture;
				} else {
					imgSrc = uiAv;
				}
				var safeName = name.replace(/'/g, "\\'");
				h +=
					'<div class="av-img" style="width:' +
					size +
					"px;height:" +
					size +
					"px;" +
					margin +
					'">' +
					'<img src="' +
					imgSrc +
					'" onmouseenter="ganttShowAvTip(event, \'' +
					safeName +
					'\')" onmouseleave="ganttHideAvTip()" onerror="this.onerror=null; this.src=\'' +
					uiAv +
					'\';" style="object-fit:cover; cursor:pointer;">' +
					"</div>";
			});
			if (uids.length > 3) {
				var extraStr = extraNames.join(", ").replace(/'/g, "\\'");
				h +=
					'<div class="av-more" style="width:' +
					size +
					"px;height:" +
					size +
					'px;margin-left:-5px;cursor:pointer;" onmouseenter="ganttShowAvTip(event, \'' +
					extraStr +
					'\')" onmouseleave="ganttHideAvTip()">+' +
					(uids.length - 3) +
					"</div>";
			}
			h += "</div>";
			return h;
		}

		function avBarHtml(idStr) {
			if (!idStr) return "";
			var uids = idStr
				.toString()
				.split(",")
				.map(function (s) {
					return s.trim();
				})
				.filter(function (s) {
					return s;
				});
			var h = '<div class="gantt-bar-avatars">';
			var extraNames = [];
			uids.forEach(function (uid, i) {
				var allUsers = [].concat(
					ganttLookups.employees || [],
					ganttLookups.product_owners || [],
				);
				var emp = allUsers.find(function (e) {
					return e.user_id.toString() === uid;
				});
				var name = emp
					? ((emp.first_name || "") + " " + (emp.last_name || "")).trim()
					: "Unknown";
				if (i > 2) {
					extraNames.push(name);
					return;
				}
				var ml = i > 0 ? "margin-left:-4px;" : "";
				var uiAv =
					"https://ui-avatars.com/api/?name=" +
					encodeURIComponent(name) +
					"&background=random&color=fff&size=20&rounded=true&bold=true";
				var imgSrc =
					emp && emp.profile_picture
						? "https://trusmiverse.com/hr/uploads/profile/" +
							emp.profile_picture
						: uiAv;
				var safeName = name.replace(/'/g, "\\'");

				h +=
					'<div class="av-img" style="width:20px;height:20px;border-width:1.5px;' +
					ml +
					'">' +
					'<img src="' +
					imgSrc +
					'" onmouseenter="ganttShowAvTip(event, \'' +
					safeName +
					'\')" onmouseleave="ganttHideAvTip()" onerror="this.onerror=null; this.src=\'' +
					uiAv +
					'\';" style="object-fit:cover; cursor:pointer;">' +
					"</div>";
			});
			if (uids.length > 3) {
				var extraStr = extraNames.join(", ").replace(/'/g, "\\'");
				h +=
					'<div class="av-more" style="width:20px;height:20px;font-size:9px;border-width:1.5px;margin-left:-4px;cursor:pointer;" onmouseenter="ganttShowAvTip(event, \'' +
					extraStr +
					'\')" onmouseleave="ganttHideAvTip()">+' +
					(uids.length - 3) +
					"</div>";
			}
			h += "</div>";
			return h;
		}

		function coHtml(company, id, isProject, style) {
			if (!isProject)
				return '<span style="color:#a1a1aa;font-size:11px;">—</span>';
			var itemType = isProject ? "project" : "task";
			var txt = company || "—";
			var st =
				style ||
				"background-color:#f8fafc; color:#64748b; border-color:#e2e8f0;";
			return (
				'<button type="button" class="chip-btn" style="' +
				st +
				'" onclick="openGanttDropdown(event, ' +
				id +
				", '" +
				itemType +
				"', 'company')\">" +
				'<i class="bi bi-building"></i>' +
				"<span>" +
				txt +
				"</span>" +
				"</button>"
			);
		}

		function stHtml(status, id, icon, style, itemType) {
			var txt = status || "—";
			var st =
				style ||
				"background-color:#f8fafc; color:#64748b; border-color:#e2e8f0;";
			var iconCls = icon || "bi-circle";
			return (
				'<button type="button" class="chip-btn" style="' +
				st +
				'" onclick="openGanttDropdown(event, ' +
				id +
				", '" +
				itemType +
				"', 'status')\">" +
				'<i class="bi ' +
				iconCls +
				'"></i>' +
				"<span>" +
				txt +
				"</span>" +
				"</button>"
			);
		}

		function catHtml(category, id, style, itemType) {
			var txt = category || "—";
			var st =
				style ||
				"background-color:#f0f9ff; color:#0369a1; border-color:#bae6fd;";
			return (
				'<button type="button" class="chip-btn" style="' +
				st +
				'" onclick="openGanttDropdown(event, ' +
				id +
				", '" +
				itemType +
				"', 'category')\">" +
				'<i class="bi bi-tag"></i>' +
				"<span>" +
				txt +
				"</span>" +
				"</button>"
			);
		}

		/* ══════════════════════════════════════════════════════════════════
        RENDER HEADER
        ══════════════════════════════════════════════════════════════════ */
		function renderHeader() {
			applyViewMode(viewMode);
			updateWeekLabel();

			// ── Week bands ──
			var weeksH = "";
			var wGroupStart = new Date(viewStart);
			var wGroupWidth = 0;
			var prevWeek = -1;
			var wGroups = [];

			for (var di = 0; di < viewDays; di++) {
				var d = addDays(viewStart, di);
				var wn = weekNum(d);
				if (wn !== prevWeek) {
					if (prevWeek !== -1)
						wGroups.push({
							wn: prevWeek,
							w: wGroupWidth,
							label:
								"W" +
								prevWeek +
								" · " +
								fmtShort(isoDate(wGroupStart)) +
								" – " +
								fmtShort(isoDate(addDays(d, -1))),
						});
					wGroupStart = d;
					wGroupWidth = 0;
					prevWeek = wn;
				}
				wGroupWidth += DAY_W;
			}
			wGroups.push({
				wn: prevWeek,
				w: wGroupWidth,
				label:
					"W" +
					prevWeek +
					" · " +
					fmtShort(isoDate(wGroupStart)) +
					" – " +
					fmtShort(isoDate(addDays(viewStart, viewDays - 1))),
			});

			wGroups.forEach(function (g) {
				weeksH +=
					'<div class="gantt-th-week-band" style="width:' +
					g.w +
					'px;">' +
					g.label +
					"</div>";
			});
			$("#gantt-th-weeks").html(weeksH);

			// ── Day cells ──
			var daysH = "";
			for (var di2 = 0; di2 < viewDays; di2++) {
				var d2 = addDays(viewStart, di2);
				var dow = d2.getDay();
				var isWE = dow === 0 || dow === 6;
				var isTo = d2.getTime() === today.getTime();
				var cls = (isWE ? " is-weekend" : "") + (isTo ? " is-today" : "");
				daysH +=
					'<div class="gantt-day-cell' +
					cls +
					'" style="width:' +
					DAY_W +
					'px;">' +
					'<span class="dn">' +
					d2.getDate() +
					"</span>" +
					'<span class="dd">' +
					DAY_NAMES[dow].slice(0, 2) +
					"</span>" +
					"</div>";
			}
			$("#gantt-th-days").html(daysH);
		}

		/* ══════════════════════════════════════════════════════════════════
        RENDER GRID ROW
        ══════════════════════════════════════════════════════════════════ */
		function gridRowHtml(item, isTask, parentItem, isHidden) {
			var hasTasks = !isTask && item.tasks && item.tasks.length > 0;
			var pId = hasTasks ? undefined : item.id;
			var pct = item.progress || 0;

			var expandBtn = "";
			if (!isTask) {
				var rotateStyle = item.expanded && hasTasks ? " open" : "";
				expandBtn =
					'<button class="expand-btn' +
					rotateStyle +
					'" data-id="' +
					item.id +
					'" data-type="' +
					item.type +
					'" onclick="ganttToggle(this)"><i class="bi bi-chevron-right"></i></button>';
			} else {
				expandBtn =
					'<span style="width:14px;flex-shrink:0;color:#d1d5db;font-size:12px;text-align:center;">&middot;</span>';
			}
			var dotColor = item.status_style
				? (item.status_style.split(" color:")[1] || "").split(";")[0]
				: "#94a3b8";
			var dot =
				'<span class="status-dot" style="flex-shrink:0; background:' +
				dotColor +
				';"></span>';
			var indent = isTask
				? parentItem
					? "padding-left:45px;"
					: "padding-left:25px;"
				: "font-weight:700;";

			var dateHtmlFn = function (field) {
				var val = item[field] ? item[field].split(" ")[0] : "";
				var hl =
					field === "tglSelesai" && !val
						? "background:#fff1f2;border:1px solid #fda4af;color:#e11d48;"
						: "";
				return (
					'<input type="text" class="due-input gantt-datetimepicker" style="width:90px;text-align:center;' +
					hl +
					'" value="' +
					val +
					'" data-id="' +
					item.id +
					'" data-type="' +
					item.type +
					'" data-field="' +
					field +
					'" autocomplete="off">'
				);
			};
			var numHtmlFn = function (field, w, ph) {
				return (
					'<input type="number" class="due-input" style="width:' +
					w +
					'px;text-align:center;" placeholder="' +
					ph +
					'" value="' +
					(item[field] || "") +
					'" data-id="' +
					item.id +
					'" data-type="' +
					item.type +
					'" data-field="' +
					field +
					'" onchange="ganttUpdateField(this)">'
				);
			};

			var week = '<span style="color:#a1a1aa;font-size:11px;">&#8212;</span>';
			if (isTask && item.end) {
				var sD = parseDate(item.end);
				if (sD) week = "W" + weekNum(sD);
			}

			// KPI
			var leadtimePctStr =
				'<span style="color:#a1a1aa;font-size:11px;">&#8212;</span>';
			var statusLtStr =
				'<span style="color:#a1a1aa;font-size:11px;">&#8212;</span>';
			var diffLtStr =
				'<span style="color:#a1a1aa;font-size:11px;">&#8212;</span>';
			var ltDaysStr =
				'<span style="color:#a1a1aa;font-size:11px;">&#8212;</span>';
			var startM = item.start ? moment(item.start) : null;
			var endM = item.end ? moment(item.end) : null;
			var finishM = item.tglSelesai ? moment(item.tglSelesai) : null;
			var todayM = moment().startOf("day");
			if (startM && endM && startM.isValid() && endM.isValid()) {
				var compareDate = finishM && finishM.isValid() ? finishM : todayM;
				var totalDays = Math.max(1, endM.diff(startM, "days"));
				var elapsedDays = compareDate.diff(startM, "days");
				if (elapsedDays < 0) {
					leadtimePctStr =
						'<span style="font-weight:600;font-size:11px;">0%</span>';
					ltDaysStr = '<span style="font-weight:600;font-size:11px;">0</span>';
					statusLtStr =
						pct === 0
							? '<span class="sbadge" style="background:#f1f5f9;color:#64748b;border:1px solid #e2e8f0;">Pending</span>'
							: '<span class="sbadge" style="background:#ecfdf5;color:#059669;border:1px solid #a7f3d0;">Ontime</span>';
					diffLtStr =
						pct === 0
							? '<span style="font-weight:600;font-size:11px;">0</span>'
							: '<span style="font-weight:600;font-size:11px;color:#10b981;">+' +
								pct +
								"</span>";
				} else {
					var ltPct = Math.round((elapsedDays / totalDays) * 100);
					var diffVal = pct - ltPct;
					var diffColor =
						diffVal < 0 ? "#ef4444" : diffVal > 0 ? "#10b981" : "#64748b";
					leadtimePctStr =
						'<span style="font-weight:600;font-size:11px;">' +
						ltPct +
						"%</span>";
					ltDaysStr =
						'<span style="font-weight:600;font-size:11px;">' +
						elapsedDays +
						"</span>";
					diffLtStr =
						'<span style="font-weight:600;font-size:11px;color:' +
						diffColor +
						';">' +
						(diffVal > 0 ? "+" : "") +
						diffVal +
						"</span>";
					statusLtStr =
						diffVal < 0
							? '<span class="sbadge" style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;">Late</span>'
							: '<span class="sbadge" style="background:#ecfdf5;color:#059669;border:1px solid #a7f3d0;">Ontime</span>';
				}
			} else if (pct > 0) {
				statusLtStr =
					'<span class="sbadge" style="background:#ecfdf5;color:#059669;border:1px solid #a7f3d0;">Ontime</span>';
			}

			var prgFillClr =
				pct === 100 ? "rgba(16,185,129,.15)" : "rgba(59,130,246,.15)";
			var prgTextClr = pct === 100 ? "#047857" : "#1d4ed8";
			var prgHtml = hasTasks
				? '<div style="position:relative;width:75px;height:26px;background:#fff;border:1px solid #e4e4e7;border-radius:6px;overflow:hidden;display:flex;align-items:center;justify-content:center;"><div style="position:absolute;left:0;top:0;height:100%;background:' +
					prgFillClr +
					";width:" +
					pct +
					'%;transition:width .3s;"></div><span style="position:relative;z-index:2;font-weight:600;font-size:11px;color:' +
					prgTextClr +
					';">' +
					pct +
					'<small style="margin-left:2px;font-size:9px;">%</small></span></div>'
				: '<div class="grid-prg-row" style="cursor:pointer;position:relative;width:75px;height:26px;background:#fff;border:1px solid #e4e4e7;border-radius:6px;overflow:hidden;display:flex;align-items:center;justify-content:center;" onclick="window.ganttOpenPop(' +
					item.id +
					", '" +
					item.type +
					"', event)\">" +
					'<div class="grid-prg-fill" style="position:absolute;left:0;top:0;height:100%;background:' +
					prgFillClr +
					";width:" +
					pct +
					'%;transition:width .3s;"></div>' +
					'<span class="grid-prg-text" style="position:relative;z-index:2;font-weight:600;font-size:11px;color:' +
					prgTextClr +
					';">' +
					pct +
					'<small style="margin-left:2px;font-size:9px;">%</small></span></div>';

			var noteVal = (item.note || "").replace(/"/g, "&quot;");
			var noteH =
				'<button title="Update Progress & Note Log" class="gantt-note-btn" style="background:none;border:none;cursor:pointer;color:' +
				(noteVal ? "var(--blue)" : "#cbd5e1") +
				';font-size:14px;position:relative;" onclick="window.ganttOpenPop(' +
				item.id +
				", '" +
				item.type +
				'\', event)"><i class="bi bi-chat-text' +
				(noteVal ? "-fill" : "") +
				'"></i></button>';
			var evCount = item.evidence_count || 0;
			var evH =
				'<button style="background:' +
				(evCount > 0 ? "#eff6ff" : "transparent") +
				";border:" +
				(evCount > 0 ? "1px solid #bfdbfe" : "1px solid transparent") +
				";border-radius:12px;font-size:11px;font-weight:600;color:" +
				(evCount > 0 ? "var(--blue)" : "#cbd5e1") +
				';padding:2px 8px;cursor:pointer;" onclick="window.ganttOpenEvidence(' +
				item.id +
				",'" +
				(isTask ? "task" : "project") +
				'\')"><i class="bi bi-paperclip"></i> ' +
				evCount +
				"</button>";

			var cellMap = {
				text: null,
				company: coHtml(item.company, item.id, !isTask, item.company_style),
				pic: avHtml(item.pic_id, 24, item.id, "pic", item.type, hasTasks),
				requester:
					item.type === "project"
						? avHtml(
								item.requester_id,
								24,
								item.id,
								"requester",
								"project",
								hasTasks,
							)
						: '<span style="color:#a1a1aa;font-size:11px;">&#8212;</span>',
				evidence: evH,
				status: stHtml(
					item.status,
					item.id,
					item.status_icon,
					item.status_style,
					item.type,
				),
				category:
					item.type === "task"
						? catHtml(item.category, item.id, item.category_style, "task")
						: '<span style="color:#a1a1aa;font-size:11px;">&#8212;</span>',
				week: week,
				progress: prgHtml,
				start: dateHtmlFn("start"),
				estimasi: numHtmlFn("estimasi", 45, "d"),
				end: dateHtmlFn("end"),
				tglSelesai: dateHtmlFn("tglSelesai"),
				leadtime_pct: leadtimePctStr,
				leadtime_status: statusLtStr,
				leadtime_diff: diffLtStr,
				leadtime_days: ltDaysStr,
			};

			var parentAttr =
				isTask && parentItem ? ' data-parent="' + parentItem.id + '"' : "";
			var hiddenAttr = isHidden ? ' style="display:none;"' : "";
			var cells = "";
			var stickyLeft = 0;

			ganttColumns.forEach(function (col) {
				if (!col.visible) return;
				var isFrozen = !!col.frozen;
				var w = col.width;
				var stickyStyle = isFrozen
					? "position:sticky;left:" +
						stickyLeft +
						"px;z-index:2;border-right:2px solid #cbd5e1;"
					: "";
				if (isFrozen) stickyLeft += w;

				if (col.key === "text") {
					var cellStyle = isFrozen
						? "width:" + w + "px; flex:0 0 " + w + "px;" + indent + stickyStyle
						: "min-width:" +
							col.minWidth +
							"px; flex:1;" +
							indent +
							stickyStyle;
					cells +=
						'<div class="gcell gcell-name" style="' +
						cellStyle +
						'">' +
						expandBtn +
						dot +
						'<span class="row-name" contenteditable="true" spellcheck="false" ' +
						'onblur="ganttUpdateName(' +
						item.id +
						", '" +
						item.type +
						"', this.innerText)\" " +
						"onkeydown=\"if(event.key==='Enter'){event.preventDefault();this.blur();}\">" +
						item.text +
						"</span>" +
						"</div>";
				} else {
					var flexCols = ["pic", "requester"];
					var flexStyle =
						flexCols.indexOf(col.key) !== -1 ? "display:flex;" : "";
					cells +=
						'<div class="gcell" style="width:' +
						w +
						"px; flex:0 0 " +
						w +
						"px; justify-content:" +
						(col.align === "center" ? "center" : "flex-start") +
						";" +
						flexStyle +
						stickyStyle +
						'">' +
						cellMap[col.key] +
						"</div>";
				}
			});

			return (
				'<div class="gantt-row ' +
				(isTask ? "is-task" : "is-project") +
				'" data-id="' +
				item.id +
				'"' +
				parentAttr +
				hiddenAttr +
				' oncontextmenu="ganttCtxMenu(event, ' +
				item.id +
				", '" +
				item.type +
				"')\">" +
				cells +
				"</div>"
			);
		}

		/* ══════════════════════════════════════════════════════════════════
        RENDER TIMELINE ROW
        ══════════════════════════════════════════════════════════════════ */
		function tlRowHtml(item, isTask, parentItem, isHidden) {
			// Day column backgrounds
			var cols = "";
			for (var di = 0; di < viewDays; di++) {
				var d = addDays(viewStart, di);
				var dow = d.getDay();
				var isWE = dow === 0 || dow === 6;
				var isTo = d.getTime() === today.getTime();
				cols +=
					'<div class="day-col' +
					(isWE ? " is-weekend" : "") +
					(isTo ? " is-today" : "") +
					'" style="width:' +
					DAY_W +
					'px;"></div>';
			}

			// Task bar
			var bar = "";
			var sD = parseDate(item.start);
			var eD = parseDate(item.end);
			if (sD && eD && eD >= sD) {
				var x = dateToX(item.start);
				var dur = Math.max(1, Math.round((eD - sD) / 86400000) + 1);
				var barW = Math.max(DAY_W, dur * DAY_W - 4);
				var pct = Math.min(100, Math.max(0, item.progress || 0));
				var bCls = item.color || "bar-blue";
				var today_d = today;
				var isLate = eD < today_d && pct < 100;

				bar =
					'<div class="gantt-bar-wrap" style="left:' +
					(x + 2) +
					"px;width:" +
					barW +
					'px;">' +
					'<div class="gantt-bar ' +
					bCls +
					(isLate ? " is-late" : "") +
					'" data-id="' +
					item.id +
					'" data-type="' +
					item.type +
					'" ' +
					'onmouseenter="ganttShowTip(event, ' +
					item.id +
					", '" +
					item.type +
					"')\" " +
					'onmouseleave="ganttHideTip()" ' +
					'ondblclick="ganttOpenPop(' +
					item.id +
					", '" +
					item.type +
					"', event)\">" +
					'<div class="gantt-bar-fill" style="width:' +
					pct +
					'%;"></div>' +
					'<span class="gantt-bar-text">' +
					item.text +
					"</span>" +
					'<span class="bar-pct">' +
					pct +
					"%</span>" +
					avBarHtml(item.pic_id) +
					'<div class="resize-handle" data-id="' +
					item.id +
					'" data-type="' +
					item.type +
					'"></div>' +
					"</div>" +
					"</div>";
			}

			var trowClass = "gantt-trow " + (isTask ? "is-task" : "is-project");
			var parentAttr =
				isTask && parentItem ? ' data-parent="' + parentItem.id + '"' : "";
			var hiddenAttr = isHidden ? ' style="display:none;"' : "";
			return (
				'<div class="' +
				trowClass +
				'" data-id="' +
				item.id +
				'"' +
				parentAttr +
				hiddenAttr +
				">" +
				cols +
				bar +
				"</div>"
			);
		}

		/* ══════════════════════════════════════════════════════════════════
        RENDER (main)
        ══════════════════════════════════════════════════════════════════ */
		function renderDescription() {
			renderColHeader();
			renderHeader();

			var search = ($("#g-search").val() || "").toLowerCase();
			var fCompany = $("#g-filter-company").val() || "all";
			var fStatus = $("#g-filter-status").val() || "all";
			var fCategory = $("#g-filter-category").val() || "all";
			var fPic = $("#g-filter-pic").val() || "all";

			var gridH = "";
			var tlH = "";

			projects.forEach(function (proj) {
				var projMatchC =
					fCompany === "all" || (proj.company && proj.company === fCompany);
				var projMatchS =
					fStatus === "all" || (proj.status && proj.status === fStatus);
				var projMatchCat =
					fCategory === "all" || (proj.category && proj.category === fCategory);
				var projMatchPic =
					fPic === "all" ||
					(proj.pic_id &&
						proj.pic_id
							.toString()
							.split(",")
							.map(function (s) {
								return s.trim();
							})
							.includes(fPic.toString()));
				var projMatchQ =
					!search || (proj.text && proj.text.toLowerCase().includes(search));

				var projMatchesDirectly =
					projMatchC &&
					projMatchS &&
					projMatchCat &&
					projMatchPic &&
					projMatchQ;

				var matchingTasks = [];
				if (proj.tasks && proj.tasks.length) {
					proj.tasks.forEach(function (task) {
						var tMatchC =
							fCompany === "all" || (task.company && task.company === fCompany);
						var tMatchS =
							fStatus === "all" || (task.status && task.status === fStatus);
						var tMatchCat =
							fCategory === "all" ||
							(task.category && task.category === fCategory);
						var tMatchPic =
							fPic === "all" ||
							(task.pic_id &&
								task.pic_id
									.toString()
									.split(",")
									.map(function (s) {
										return s.trim();
									})
									.includes(fPic.toString()));

						// Task satisfies search if task matches, OR if parent project matches text
						var tMatchQ =
							!search ||
							(task.text && task.text.toLowerCase().includes(search)) ||
							projMatchQ;

						if (tMatchC && tMatchS && tMatchCat && tMatchPic && tMatchQ) {
							matchingTasks.push(task);
						}
					});
				}

				// Skip project if it doesn't match and has no matching sub-tasks
				if (!projMatchesDirectly && matchingTasks.length === 0) return;

				// Auto-expand if the project is visible ONLY because of a matching task
				if (!projMatchesDirectly && matchingTasks.length > 0) {
					proj.expanded = true;
				}

				gridH += gridRowHtml(proj, false);
				tlH += tlRowHtml(proj, false);

				matchingTasks.forEach(function (task) {
					var isHidden = !proj.expanded;
					gridH += gridRowHtml(task, true, proj, isHidden);
					tlH += tlRowHtml(task, true, proj, isHidden);
				});
			});

			$("#gantt-grid-rows").html(gridH);
			$("#gantt-timeline-rows").html(tlH);
		}

		function render() {
			if (isInitializingFilters) return;
			renderDescription();

			// Today vertical bar
			var todayX = dateToX(isoDate(today));
			if (todayX >= 0 && todayX <= viewDays * DAY_W) {
				var lineHtml =
					'<div class="today-vline" style="left:' +
					(todayX + DAY_W / 2 - 1) +
					'px;">' +
					'<div class="today-vline-header"></div></div>';
				$("#gantt-timeline-rows").prepend(lineHtml);
			}

			bindDrag();
			syncScroll();
			$("#gantt-loader").fadeOut(400);
		}

		// Lazy-init DateTimePicker for better performance
		$(document).on("focus", ".gantt-datetimepicker", function () {
			var $this = $(this);
			if (!$this.hasClass("xdan-initialized")) {
				$this
					.datetimepicker({
						format: "Y-m-d",
						timepicker: true,
						scrollMonth: false,
						scrollInput: false,
						onSelectDate: function (ct, $i) {
							ganttUpdateDate(
								$i.data("id"),
								$i.data("type"),
								$i.data("field"),
								$i.val(),
							);
						},
						onSelectTime: function (ct, $i) {
							ganttUpdateDate(
								$i.data("id"),
								$i.data("type"),
								$i.data("field"),
								$i.val(),
							);
						},
					})
					.addClass("xdan-initialized")
					.datetimepicker("show");
			}
		});

		function hideAllOverlays() {
			$("#gantt-tooltip").hide().css("visibility", "visible");
			$("#gantt-ctx-menu").hide();
			$("#gantt-inline-dropdown").hide();
			activeDdState = null;

			if ($("#gantt-progress-pop").is(":visible")) {
				window.ganttClosePop();
			}
			if ($("#gantt-note-pop").is(":visible")) {
				window.ganttCloseNotePop();
			}
		}

		/* ══════════════════════════════════════════════════════════════════
        SYNC SCROLL (vertical)
        ══════════════════════════════════════════════════════════════════ */
		function syncScroll() {
			var $gs = $("#gantt-grid-scroll");
			var $tls = $("#gantt-tl-scroll");

			$gs.off("scroll.gsync").on("scroll.gsync", function () {
				$tls.scrollTop($(this).scrollTop());
				hideAllOverlays();
			});
			$tls.off("scroll.gsync").on("scroll.gsync", function () {
				$gs.scrollTop($(this).scrollTop());
				hideAllOverlays();
			});

			// Also hide on overall window view scroll
			$(window)
				.off("scroll.gmain")
				.on("scroll.gmain", function () {
					hideAllOverlays();
				});
		}

		// FIX: debounce registry — mencegah spam request saat user mengetik
		var _debounceTimers = {};
		// FIX: request lock — satu item hanya boleh punya 1 request aktif pada satu waktu
		var _pendingRequests = {};

		/**
		 * persistUpdate — update 1 field dengan debounce 400ms.
		 * Jika ada request sebelumnya untuk (id+field) yang sama, dibatalkan dulu.
		 */
		function persistUpdate(id, type, field, value, cb, note) {
			var key = type + "_" + id + "_" + field;

			// Cancel debounce yang belum jalan
			if (_debounceTimers[key]) {
				clearTimeout(_debounceTimers[key]);
				delete _debounceTimers[key];
			}

			_debounceTimers[key] = setTimeout(function () {
				delete _debounceTimers[key];

				var f = findItem(id, type);
				var updated_at = f ? f.item.updated_at || "" : "";

				var jqxhr = $.post(
					BASE_URL + "project_management/beranda/ajax_update_item",
					{
						id: id,
						type: type,
						field: field,
						value: value,
						note: note || "",
						updated_at: updated_at, // FIX: kirim snapshot untuk conflict check
					},
					function (res) {
						delete _pendingRequests[type + "_" + id];

						var data;
						try {
							data = typeof res === "string" ? JSON.parse(res) : res;
						} catch (e) {
							data = { status: "error" };
						}

						// FIX: tangani konflik — data sudah diubah user lain
						if (data.status === "conflict") {
							Swal.fire({
								toast: true,
								position: "top-end",
								icon: "warning",
								title: "Konflik Update",
								text:
									data.message ||
									"Data telah diubah pengguna lain. Refresh untuk sinkronisasi.",
								showConfirmButton: true,
								confirmButtonText: "Refresh",
								timer: 8000,
								timerProgressBar: true,
							}).then(function (result) {
								if (result.isConfirmed) loadGanttData();
							});
							return;
						}

						// FIX: update snapshot updated_at di item lokal supaya request berikutnya valid
						if (data.updated_at) {
							var ff = findItem(id, type);
							if (ff) ff.item.updated_at = data.updated_at;
						}

						if (cb) cb(res);
					},
				);

				// Simpan reference request aktif (untuk informasi saja, bukan abort)
				_pendingRequests[type + "_" + id] = jqxhr;
			}, 400); // debounce 400ms
		}

		/**
		 * persistBatch — update banyak field sekaligus dalam 1 request (atomic).
		 * Dipakai untuk drag (start+end+week) dan completion (progress+status+tglSelesai).
		 *
		 * @param {number}   id
		 * @param {string}   type      'project' | 'task'
		 * @param {Array}    fields    [{field, value}, ...]
		 * @param {Function} cb        callback(res)
		 * @param {string}   note      catatan progress (opsional)
		 */
		function persistBatch(id, type, fields, cb, note) {
			// Cancel debounce individual yang mungkin masih pending untuk fields ini
			fields.forEach(function (f) {
				var key = type + "_" + id + "_" + f.field;
				if (_debounceTimers[key]) {
					clearTimeout(_debounceTimers[key]);
					delete _debounceTimers[key];
				}
			});

			var itemRef = findItem(id, type);
			var updated_at = itemRef ? itemRef.item.updated_at || "" : "";

			$.ajax({
				url: BASE_URL + "project_management/beranda/ajax_update_batch",
				type: "POST",
				contentType: "application/json",
				data: JSON.stringify({
					id: id,
					type: type,
					fields: fields,
					updated_at: updated_at,
					note: note || "",
				}),
				success: function (res) {
					var data;
					try {
						data = typeof res === "string" ? JSON.parse(res) : res;
					} catch (e) {
						data = { status: "error" };
					}

					if (data.status === "conflict") {
						Swal.fire({
							toast: true,
							position: "top-end",
							icon: "warning",
							title: "Konflik Update",
							text:
								data.message ||
								"Data telah diubah pengguna lain. Refresh untuk sinkronisasi.",
							showConfirmButton: true,
							confirmButtonText: "Refresh",
							timer: 8000,
							timerProgressBar: true,
						}).then(function (result) {
							if (result.isConfirmed) loadGanttData();
						});
						return;
					}

					// FIX: update snapshot updated_at di item lokal
					if (data.updated_at) {
						var ff = findItem(id, type);
						if (ff) ff.item.updated_at = data.updated_at;
					}

					if (cb) cb(res);
				},
			});
		}

		function bindDrag() {
			$("#gantt-timeline-rows")
				.find(".gantt-bar")
				.each(function () {
					var $bar = $(this);
					var id = +$bar.data("id"),
						type = $bar.data("type");
					var $wrap = $bar.closest(".gantt-bar-wrap");

					$bar.off("mousedown.gmove").on("mousedown.gmove", function (e) {
						if ($(e.target).hasClass("resize-handle")) return;
						e.preventDefault();
						var startX = e.clientX;
						var origL = parseInt($wrap.css("left"));
						var origW = $wrap.width();

						$(document).on("mousemove.gmove", function (ev) {
							$wrap.css("left", origL + ev.clientX - startX + "px");
						});
						$(document).one("mouseup.gmove", function (ev) {
							$(document).off("mousemove.gmove");
							var delta = Math.round((ev.clientX - startX) / DAY_W);
							if (delta) {
								var f = findItem(id, type);
								if (f) {
									f.item.start = isoDate(
										addDays(parseDate(f.item.start), delta),
									);
									f.item.end = isoDate(addDays(parseDate(f.item.end), delta));

									persistBatch(id, f.item.type, [
										{ field: "start", value: f.item.start },
										{ field: "end", value: f.item.end },
										{ field: "week", value: f.item.week },
									]);
								}
								render();
							} else {
								$wrap.css("left", origL + "px");
							}
						});
					});
				});

			$("#gantt-timeline-rows")
				.find(".resize-handle")
				.each(function () {
					var $rh = $(this);
					var id = +$rh.data("id"),
						type = $rh.data("type");
					var $wrap = $rh.closest(".gantt-bar-wrap");

					$rh.off("mousedown.gresize").on("mousedown.gresize", function (e) {
						e.preventDefault();
						e.stopPropagation();
						var startX = e.clientX;
						var origW = $wrap.width();

						$(document).on("mousemove.gresize", function (ev) {
							$wrap.css(
								"width",
								Math.max(DAY_W, origW + ev.clientX - startX) + "px",
							);
						});
						$(document).one("mouseup.gresize", function (ev) {
							$(document).off("mousemove.gresize");
							var delta = Math.round((ev.clientX - startX) / DAY_W);
							if (delta) {
								var f = findItem(id, type);
								if (f) {
									f.item.end = isoDate(addDays(parseDate(f.item.end), delta));
									persistUpdate(id, f.item.type, "end", f.item.end);

									if (f.item.start && f.item.end) {
										var startDate = parseDate(f.item.start);
										var endDate = parseDate(f.item.end);
										if (startDate && endDate) {
											var diffTime = endDate - startDate;
											var diffDays = Math.ceil(
												diffTime / (1000 * 60 * 60 * 24),
											);
											f.item.estimasi = diffDays;
											persistUpdate(
												id,
												f.item.type,
												"estimasi",
												f.item.estimasi,
											);
										}
									}
								}
								render();
							} else {
								$wrap.css("width", origW + "px");
							}
						});
					});
				});
		}

		/* ══════════════════════════════════════════════════════════════════
        GLOBAL CALLBACKS (window scope for inline handlers)
        ══════════════════════════════════════════════════════════════════ */
		window.ganttToggle = function (btn) {
			var id = +$(btn).data("id");
			var type = $(btn).data("type");
			var f = findItem(id, type);
			if (f && f.item.type === "project") {
				var isExpanding = !f.item.expanded;
				f.item.expanded = isExpanding;

				var $btn = $(btn);
				if (isExpanding) {
					$btn.addClass("open");
				} else {
					$btn.removeClass("open");
				}

				var $gridRows = $(
					'#gantt-grid-rows .gantt-row.is-task[data-parent="' + id + '"]',
				);
				var $tlRows = $(
					'#gantt-timeline-rows .gantt-trow.is-task[data-parent="' + id + '"]',
				);

				if (isExpanding) {
					$gridRows
						.css("display", "flex")
						.hide()
						.slideDown(250, function () {
							$(this).css("display", ""); // clear inline styles
						});
					$tlRows
						.css("display", "flex")
						.hide()
						.slideDown(250, function () {
							$(this).css("display", "");
						});
				} else {
					$gridRows.slideUp(250);
					$tlRows.slideUp(250);
				}
			}
		};

		window.ganttUpdateName = function (id, type, val) {
			val = val.trim();
			if (!val) return;
			var f = findItem(id, type);
			if (f && f.item.text !== val) {
				f.item.text = val;
				persistUpdate(id, f.item.type, "text", val);
			}
		};

		window.ganttUpdateDate = function (id, type, field, val) {
			var f = findItem(id, type);
			if (!f) return;

			var oldTgl = f.item.tglSelesai;
			var oldStatus = f.item.status;
			var oldProgress = f.item.progress;
			var oldSStyle = f.item.status_style;
			var oldSIcon = f.item.status_icon;

			f.item[field] = val;

			// Completion Trigger: tglSelesai filled when previously empty
			if (field === "tglSelesai" && !oldTgl && val) {
				// Snapshot for rollback
				f.item._origTglSelesai = oldTgl;
				f.item._origStatus = oldStatus;
				f.item._origProgress = oldProgress;
				f.item._origSStyle = oldSStyle;
				f.item._origSIcon = oldSIcon;

				f.item.progress = 100;
				f.item.status = "Done";
				var sFound = (ganttLookups.statuses || []).find(function (v) {
					return v.status_name === "Done";
				});
				if (sFound) {
					f.item.status_icon = sFound.status_icon;
					f.item.status_style = sFound.style;
				}

				render();
				// Trigger note, passing mock event for positioning near cell
				var eventMock = {
					stopPropagation: function () {},
					clientX: window.innerWidth / 2,
					clientY: window.innerHeight / 2,
				};
				window.ganttOpenPop(id, type, eventMock, true);
				return;
			}

			if (field === "start" && f.item.estimasi && val) {
				var startDate = parseDate(val);
				if (startDate) {
					let estimasi =
						parseInt(f.item.estimasi, 10) - (f.item.estimasi > 0 ? 1 : 0);
					var newEndDate = addDays(startDate, estimasi);
					f.item.end = isoDate(newEndDate);
					persistUpdate(id, f.item.type, "end", f.item.end);
				}
			} else if (field === "end" && f.item.start && val) {
				var startDate = parseDate(f.item.start);
				var endDate = parseDate(val);
				if (startDate && endDate) {
					var diffTime = endDate - startDate;
					var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
					f.item.estimasi = diffDays;
					persistUpdate(id, f.item.type, "estimasi", f.item.estimasi);
				}
			}

			// keep start <= end
			if (
				f.item.start &&
				f.item.end &&
				parseDate(f.item.end) < parseDate(f.item.start)
			) {
				f.item.start = val;
			}
			persistUpdate(id, f.item.type, field, val);

			if (field === "start" && f.item.type === "task") {
				var wNode = weekNum(parseDate(f.item.start));
				f.item.week = "W" + wNode;
				persistUpdate(id, f.item.type, "week", f.item.week);
			}

			if (f.item.type === "task") preprocessData();
			render();
		};

		window.ganttUpdateField = function (sel) {
			var id = +$(sel).data("id"),
				field = $(sel).data("field"),
				type = $(sel).data("type"),
				val = $(sel).val();
			var f = findItem(id, type);
			if (f) {
				f.item[field] = val;
				persistUpdate(id, f.item.type, field, val);

				if (field === "estimasi" && val && f.item.start) {
					var startDate = parseDate(f.item.start);
					if (startDate) {
						let estimasi = parseInt(val, 10) - (val > 0 ? 1 : 0);
						var newEndDate = addDays(startDate, estimasi);
						f.item.end = isoDate(newEndDate);
						persistUpdate(id, f.item.type, "end", f.item.end);
					}
				}

				if (f.item.type === "task") preprocessData();
				render();
			}
		};

		/* Custom Dropdown handlers */
		var activeDdState = null;

		window.openGanttDropdown = function (e, id, itemType, type) {
			e.stopPropagation();
			var rect = e.currentTarget.getBoundingClientRect();
			var $dd = $("#gantt-inline-dropdown");

			$dd.css({
				top: rect.bottom + 4 + "px",
				left: rect.left + "px",
				display: "block",
			});

			activeDdState = { id: id, itemType: itemType, type: type };
			$("#gantt-dd-search").val("");
			renderGanttDropdownOptions("");
			$("#gantt-dd-search").focus();
		};

		$(document).on("click", function (e) {
			if (
				!$(e.target).closest("#gantt-inline-dropdown").length &&
				!$(e.target).closest(".chip-btn").length
			) {
				$("#gantt-inline-dropdown").hide();
				activeDdState = null;
			}
		});

		$("#gantt-dd-search").on("input", function () {
			renderGanttDropdownOptions($(this).val());
		});

		function renderGanttDropdownOptions(filter) {
			// console.log(ganttLookups);

			if (!activeDdState) return;
			var f = findItem(activeDdState.id, activeDdState.itemType);
			if (!f) return;
			var search = (filter || "").toLowerCase();

			var opts = [];
			var selectedVals = [];

			if (activeDdState.type === "company") {
				opts = ganttLookups.companies.map(function (c) {
					return { v: c.alias, i: "bi-building", s: c.style };
				});
				selectedVals = [f.item.company];
			} else if (activeDdState.type === "status") {
				opts = ganttLookups.statuses.map(function (s) {
					return {
						v: s.status_name,
						i: s.status_icon || "bi-circle",
						s: s.style,
					};
				});
				selectedVals = [f.item.status];
			} else if (activeDdState.type === "category") {
				opts = ganttLookups.categories.map(function (c) {
					return { v: c.category, i: "bi-tag", s: c.style };
				});
				selectedVals = [f.item.category];
			} else if (activeDdState.type === "requester") {
				opts = (ganttLookups.product_owners || []).map(function (e) {
					var name = ((e.first_name || "") + " " + (e.last_name || "")).trim();
					return {
						v: e.user_id.toString(),
						i: "bi-person-circle",
						label: name,
					};
				});
				var cur = (f.item.requester_id || "").toString();
				selectedVals = cur
					.split(",")
					.map(function (p) {
						return p.trim();
					})
					.filter(function (s) {
						return s;
					});
			} else if (
				activeDdState.type === "pic" ||
				activeDdState.type === "spv" ||
				activeDdState.type === "pm"
			) {
				opts = (ganttLookups.employees || []).map(function (e) {
					var name = ((e.first_name || "") + " " + (e.last_name || "")).trim();
					return {
						v: e.user_id.toString(),
						i: "bi-person-circle",
						label: name,
					};
				});
				var cur = (f.item[activeDdState.type + "_id"] || "").toString();
				selectedVals = cur
					.split(",")
					.map(function (p) {
						return p.trim();
					})
					.filter(function (s) {
						return s;
					});
			}

			var html = "";
			opts.forEach(function (o) {
				if (
					search &&
					!o.v.toLowerCase().includes(search) &&
					!(o.label && o.label.toLowerCase().includes(search))
				)
					return;
				var isSel = selectedVals.includes(o.v);
				var dotStyle = o.s
					? "background:" + o.s.split("background-color:")[1].split(";")[0]
					: "";
				html +=
					'<div class="gdd-item ' +
					(isSel ? "selected" : "") +
					'" onclick="selectGanttDropdownVal(\'' +
					o.v +
					"', event)\">" +
					"<div>" +
					(o.s
						? '<span class="status-dot" style="' + dotStyle + '"></span>'
						: o.imgHtml
							? o.imgHtml
							: '<i class="bi ' + o.i + '"></i>') +
					(o.label || o.v) +
					"</div>" +
					(isSel
						? '<i class="bi bi-check2 text-primary" style="margin-right:0;"></i>'
						: "") +
					"</div>";
			});
			$("#gantt-dd-list").html(html);
		}

		window.selectGanttDropdownVal = function (val, e) {
			if (!activeDdState) return;
			var f = findItem(activeDdState.id, activeDdState.itemType);
			if (!f) return;

			if (
				activeDdState.type === "pic" ||
				activeDdState.type === "requester" ||
				activeDdState.type === "spv" ||
				activeDdState.type === "pm"
			) {
				var isSingle =
					activeDdState.type === "spv" || activeDdState.type === "pm";

				if (isSingle) {
					var newIds = val.toString();
					f.item[activeDdState.type + "_id"] = newIds;

					var newInitials = [];
					var emp = ganttLookups.employees.find(function (e) {
						return e.user_id.toString() === val.toString();
					});
					if (emp) {
						newInitials.push(
							(
								(emp.first_name || "").slice(0, 1) +
								(emp.last_name || "").slice(0, 1)
							).toUpperCase(),
						);
					}
					f.item[activeDdState.type] = newInitials.join("");

					persistUpdate(
						activeDdState.id,
						f.item.type,
						activeDdState.type,
						newIds,
					);
					$("#gantt-inline-dropdown").hide();
					activeDdState = null;
					if (f.item.type === "task") preprocessData();
					render();
				} else {
					var curIds = (f.item[activeDdState.type + "_id"] || "")
						.toString()
						.split(",")
						.map(function (s) {
							return s.trim();
						})
						.filter(function (s) {
							return s;
						});
					var idx = curIds.indexOf(val.toString());
					if (idx > -1) curIds.splice(idx, 1);
					else curIds.push(val.toString());
					var newIds = curIds.join(", ");

					f.item[activeDdState.type + "_id"] = newIds;

					var newInitials = [];
					curIds.forEach(function (idStr) {
						var emp = ganttLookups.employees.find(function (e) {
							return e.user_id.toString() === idStr;
						});
						if (emp) {
							newInitials.push(
								(
									(emp.first_name || "").slice(0, 1) +
									(emp.last_name || "").slice(0, 1)
								).toUpperCase(),
							);
						}
					});
					f.item[activeDdState.type] = newInitials.join(", ");

					persistUpdate(
						activeDdState.id,
						f.item.type,
						activeDdState.type,
						newIds,
					);
					renderGanttDropdownOptions($("#gantt-dd-search").val());
					if (f.item.type === "task") preprocessData();
					render();
				}
			} else {
				var oldTglSelesai = f.item.tglSelesai || "";
				var oldStatus = f.item.status;
				var oldProgress = f.item.progress || 0;
				var oldSStyle = f.item.status_style;
				var oldSIcon = f.item.status_icon;
				var oldColor = f.item.color;

				f.item[activeDdState.type] = val;

				// Sync Styles & Icons Dynamically
				var syncMap = {
					status: {
						list: "statuses",
						match: "status_name",
						props: {
							status_style: "style",
							status_icon: "status_icon",
							color: "color",
						},
					},
					company: {
						list: "companies",
						match: "alias",
						props: { company_style: "style" },
					},
					category: {
						list: "categories",
						match: "category",
						props: { category_style: "style" },
					},
				};

				var cfg = syncMap[activeDdState.type];
				if (cfg) {
					var itemFound = ganttLookups[cfg.list].find(function (x) {
						return x[cfg.match] === val;
					});
					if (itemFound) {
						Object.keys(cfg.props).forEach(function (target) {
							f.item[target] = itemFound[cfg.props[target]];
						});
					}
				}

				// SPECIAL LOGIC: Done -> 100% + Note
				if (
					activeDdState.type === "status" &&
					val === "Done" &&
					oldStatus !== "Done"
				) {
					f.item.progress = 100;
					f.item.tglSelesai = isoDate(new Date());

					var dId = activeDdState.id,
						dType = activeDdState.itemType;
					$("#gantt-inline-dropdown").hide();
					activeDdState = null;
					render();

					// Snapshot before transition to enable rollback
					f.item._origProgress = oldProgress;
					f.item._origStatus = oldStatus;
					f.item._origTglSelesai = oldTglSelesai;
					f.item._origSStyle = oldSStyle;
					f.item._origSIcon = oldSIcon;

					// Trigger note popover with skipRefresh (we already snapshotted above)
					window.ganttOpenPop(dId, dType, e, true);
					return;
				}

				persistUpdate(activeDdState.id, f.item.type, activeDdState.type, val);
				$("#gantt-inline-dropdown").hide();
				activeDdState = null;
				render();
			}
		};

		/* Tooltip */
		window.ganttShowTip = function (e, id, type) {
			// if (activePopId !== null || $('#gantt-ctx-menu').is(':visible') || $('#gantt-inline-dropdown').is(':visible')) return;
			var f = findItem(id, type);
			if (!f) return;
			var item = f.item;
			$("#gtt-title").text(item.text);
			$("#gtt-company").text(item.company || "—");
			$("#gtt-category").text(item.category || "—");
			$("#gtt-status").text(item.status || "—");
			$("#gtt-pic").html(avBarHtml(item.pic_id) || "—");
			$("#gtt-start").text(fmtFull(item.start));
			$("#gtt-end").text(fmtFull(item.end));
			$("#gtt-progress").text((item.progress || 0) + "%");

			var $tt = $("#gantt-tooltip");
			$tt.css({ display: "block", visibility: "hidden" }); // Show hidden to get dimensions

			var tw = $tt.outerWidth(),
				th = $tt.outerHeight();
			var x = e.clientX + 14,
				y = e.clientY + 14;

			// Flip horizontal
			if (x + tw > window.innerWidth) x = e.clientX - tw - 14;
			// Flip vertical
			if (y + th > window.innerHeight) y = e.clientY - th - 14;

			$tt.css({ top: y, left: x, visibility: "visible" });
		};
		window.ganttHideTip = function () {
			$("#gantt-tooltip").hide().css("visibility", "visible");
		};

		/* Progress popover */
		window.ganttOpenPop = function (id, type, e, skipRefresh) {
			e.stopPropagation();
			ganttHideTip();
			activePopId = id;
			activePopType = type;
			var f = findItem(id, type);
			if (!f) return;

			// Snapshot for rollback/dirty check
			if (!skipRefresh) {
				f.item._origProgress = f.item.progress || 0;
				f.item._origStatus = f.item.status;
				f.item._origTglSelesai = f.item.tglSelesai || "";
				f.item._origSStyle = f.item.status_style;
				f.item._origSIcon = f.item.status_icon;
				f.item._origColor = f.item.color;
			}

			var pct = f.item.progress || 0;
			$("#gp-slider").val(pct);
			$("#gp-val").text(pct);
			$("#gp-note").val("");
			$("#gp-msg").hide();
			$("#gp-word-count").text("0 / 3 words").css("color", "#94a3b8");
			$("#gantt-progress-pop").css({
				display: "block",
				top: e.clientY - 10,
				left: e.clientX + 10,
				zIndex: 9999,
			});
		};

		/* Context menu */
		window.ganttCtxMenu = function (e, id, type) {
			e.preventDefault();
			ganttHideTip();
			ctxItemId = id;
			ctxItemType = type;

			// Check if any project is collapsed to toggle button text
			var anyCollapsed = projects.some(function (p) {
				return !p.expanded;
			});
			var $toggle = $("#gctx-toggle-all");
			if (anyCollapsed) {
				$toggle.html('<i class="bi bi-arrows-expand"></i> Expand All Projects');
			} else {
				$toggle.html(
					'<i class="bi bi-arrows-collapse"></i> Collapse All Projects',
				);
			}

			$("#gantt-ctx-menu").css({
				display: "block",
				top: e.clientY - 10,
				left: e.clientX + 10,
				zIndex: 9999,
			});
		};

		/* ══════════════════════════════════════════════════════════════════
        EVENT LISTENERS
        ══════════════════════════════════════════════════════════════════ */
		// Week/month navigation
		$("#g-prev-week").on("click", function () {
			viewStart = addDays(viewStart, -viewDays);
			render();
		});
		$("#g-next-week").on("click", function () {
			viewStart = addDays(viewStart, viewDays);
			render();
		});
		$("#g-today-btn").on("click", function () {
			var tx = dateToX(isoDate(today));
			var $sc = $("#gantt-tl-scroll");
			var cw = $sc.width();

			if (tx >= 0 && tx <= viewDays * DAY_W) {
				// If in range, just scroll
				$sc.animate({ scrollLeft: tx - cw / 2 + DAY_W / 2 }, 400);
			} else {
				// If not in range, jump to today and center it
				viewStart = new Date(
					today.getFullYear(),
					today.getMonth(),
					today.getDate(),
				);
				viewStart = addDays(viewStart, -7); // Center approx
				render();
				setTimeout(function () {
					var ntx = dateToX(isoDate(today));
					$sc.scrollLeft(ntx - cw / 2 + DAY_W / 2);
				}, 100);
			}
		});

		$("#g-refresh-btn").on("click", function () {
			loadGanttData();
		});

		// Filters
		$(
			"#g-search, #g-filter-company, #g-filter-status, #g-filter-category, #g-filter-pic",
		).on("input change", function () {
			render();
		});
		window.resetGanttFilters = function (skipRender) {
			isInitializingFilters = true;
			$("#g-search").val("");
			var filterIds = [
				"#g-filter-company",
				"#g-filter-status",
				"#g-filter-category",
				"#g-filter-pic",
			];
			filterIds.forEach(function (id) {
				if (window.ssFilters && window.ssFilters[id]) {
					window.ssFilters[id].setSelected("all");
				} else {
					$(id).val("all");
				}
			});
			isInitializingFilters = false;
			if (!skipRender) render();
		};

		$("#g-reset-filters").on("click", function () {
			window.resetGanttFilters();
		});

		// Add project
		function doAddProject() {
			var BAR_COLORS = ["bar-gray"];
			var color = BAR_COLORS[Math.floor(Math.random() * BAR_COLORS.length)];
			var start = isoDate(today);
			var end = isoDate(today);

			$.post(
				BASE_URL + "project_management/beranda/ajax_add_project",
				{
					text: "New Project",
					start: start,
					end: end,
					color: color,
					status: "Not Started",
				},
				function (res) {
					var data = JSON.parse(res);
					if (data.status === "success") {
						window.resetGanttFilters(true); // Don't render yet
						var sFound = (ganttLookups.statuses || []).find(function (v) {
							return v.status_name === "Not Started";
						});
						projects.push({
							id: data.id,
							type: "project",
							text: "New Project",
							company: "-",
							company_style: "",
							pic: "",
							pic_id: "",
							requester: "-",
							requester_id: "",
							status: "Not Started",
							status_icon: sFound ? sFound.status_icon : "bi-search",
							status_style: sFound ? sFound.style : "",
							category: "-",
							progress: 0,
							start: start,
							end: end,
							tglSelesai: "",
							estimasi: 1,
							leadtime: 0,
							diffLt: 0,
							hours: 0,
							statusLt: "Pending",
							expanded: false,
							tasks: [],
							color: color,
							note: "",
							evidence_count: 0,
						});
						preprocessData();
						render();

						var newId = data.id;
						$(
							'.gantt-row[data-id="' +
								newId +
								'"], .gantt-trow[data-id="' +
								newId +
								'"]',
						).addClass("highlight-flash");
						setTimeout(function () {
							$(".highlight-flash").removeClass("highlight-flash");
						}, 3000);
						setTimeout(function () {
							$("#gantt-grid-scroll").animate(
								{ scrollTop: $("#gantt-grid-scroll").prop("scrollHeight") },
								400,
							);
							$("#gantt-tl-scroll").animate(
								{ scrollTop: $("#gantt-tl-scroll").prop("scrollHeight") },
								400,
							);
						}, 50);
					}
				},
			);
		}
		$("#g-add-project, #g-add-project-btn2").on("click", doAddProject);

		// Global Context menu actions
		$("#gctx-toggle-all").on("click", function () {
			$("#gantt-ctx-menu").hide();
			var anyCollapsed = projects.some(function (p) {
				return !p.expanded;
			});
			projects.forEach(function (p) {
				p.expanded = anyCollapsed;
			});
			render();
		});
		$("#gctx-details").on("click", function () {
			$("#gantt-ctx-menu").hide();
			if (!ctxItemId) return;
			var f = findItem(ctxItemId, ctxItemType);
			if (!f) return;
			var item = f.item;

			$("#det-text").text(item.text);
			$("#det-company").text(item.company || "-");
			$("#det-category").text(item.category || "-");
			$("#det-status-badge")
				.text(item.status || "-")
				.attr("class", "badge-status " + (item.status_style || ""));
			$("#det-start").text(fmtFull(item.start));
			$("#det-end").text(fmtFull(item.end));

			var pct = item.progress || 0;
			$("#det-progress-bar").css("width", pct + "%");
			$("#det-progress-text").text(pct + "%");

			// PIC handling
			var picHtml = avBarHtml(item.pic_id) || "-";
			$("#det-pic-container").html(picHtml);

			$("#modal-details").modal("show");
		});

		// Context menu item actions
		$("#gctx-add-task").on("click", function () {
			$("#gantt-ctx-menu").hide();
			if (!ctxItemId) return;
			var f = findItem(ctxItemId, ctxItemType);
			if (!f) return;
			var proj = f.item.type === "project" ? f.item : f.parent;
			if (!proj) return;

			var taskStart = isoDate(today);
			var taskEnd = isoDate(today);
			var wNode = weekNum(parseDate(taskEnd));

			// Auto-extend project deadline if it's already past
			if (parseDate(proj.end) < today) {
				proj.end = taskEnd;
				persistUpdate(proj.id, "project", "end", proj.end);
			}

			$.post(
				BASE_URL + "project_management/beranda/ajax_add_task",
				{
					project_id: proj.id,
					text: "New Task",
					start: taskStart,
					end: taskEnd,
					status: "Not Started",
					progress: 0,
					week: "W" + wNode,
					menu: "beranda",
				},
				function (res) {
					var data = JSON.parse(res);
					if (data.status === "success") {
						window.resetGanttFilters(true); // Clear filters so task is visible
						proj.expanded = true;
						proj.tasks = proj.tasks || [];
						var sFound = (ganttLookups.statuses || []).find(function (v) {
							return v.status_name === "Not Started";
						});
						proj.tasks.push({
							id: data.id,
							type: "task",
							text: "New Task",
							pic: "",
							pic_id: "",
							status: "Not Started",
							status_icon: sFound ? sFound.status_icon : "bi-search",
							status_style: sFound ? sFound.style : "",
							category: "-",
							category_style: "",
							progress: 0,
							start: taskStart,
							end: taskEnd,
							tglSelesai: "",
							estimasi: 1,
							leadtime: 0,
							diffLt: 0,
							hours: 0,
							statusLt: "Pending",
							week: "W" + wNode,
							note: "",
							evidence_count: 0,
							color: proj.color,
						});
						preprocessData();
						render();

						var newId = data.id;
						$(
							'.gantt-row[data-id="' +
								newId +
								'"], .gantt-trow[data-id="' +
								newId +
								'"]',
						).addClass("highlight-flash");
						setTimeout(function () {
							$(".highlight-flash").removeClass("highlight-flash");
						}, 3000);
					}
				},
			);
		});
		$("#gctx-delete").on("click", function () {
			$("#gantt-ctx-menu").hide();
			if (!ctxItemId) return;

			if (!confirm("Are you sure you want to delete this item?")) return;

			var f = findItem(ctxItemId, ctxItemType);
			if (!f) return;
			var type = f.item.type;

			$.post(
				BASE_URL + "project_management/beranda/ajax_delete",
				{
					id: f.item.id,
					type: type,
				},
				function (res) {
					var data = JSON.parse(res);
					if (data.status === "success") {
						if (f.parent) f.parent.tasks.splice(f.idx, 1);
						else projects.splice(f.idx, 1);
						ctxItemId = null;
						render();
					} else {
						alert("Error deleting item");
					}
				},
			);
		});
		$("#gctx-duplicate").on("click", function () {
			$("#gantt-ctx-menu").hide();
			if (!ctxItemId) return;
			var f = findItem(ctxItemId, ctxItemType);
			if (!f) return;
			var item = f.item;

			var url = item.type === "project" ? "ajax_add_project" : "ajax_add_task";
			var payload = {
				text: item.text + " (Copy)",
				start: item.start,
				end: item.end,
				status: item.status,
				color: item.color,
			};
			if (item.type === "task") {
				payload.project_id = f.parent.id;
			}

			$.post(
				BASE_URL + "project_management/beranda/" + url,
				payload,
				function (res) {
					var data = JSON.parse(res);
					if (data.status === "success") {
						var newItem = Object.assign({}, item, {
							id: data.id,
							text: item.text + " (Copy)",
						});
						if (item.type === "project") {
							newItem.tasks = []; // Shallow copy
							projects.splice(f.idx + 1, 0, newItem);
						} else {
							f.parent.tasks.splice(f.idx + 1, 0, newItem);
						}
						render();

						var newId = data.id;
						$(
							'.gantt-row[data-id="' +
								newId +
								'"], .gantt-trow[data-id="' +
								newId +
								'"]',
						).addClass("highlight-flash");
						setTimeout(function () {
							$(".highlight-flash").removeClass("highlight-flash");
						}, 3000);
					}
				},
			);
		});

		$("#gctx-input-problem").on("click", function () {
			$("#gantt-ctx-menu").hide();
			if (!ctxItemId) return;
			var f = findItem(ctxItemId, ctxItemType);
			if (!f) return;
			var item = f.item;

			$("#formAddProblem")[0].reset();
			$("#taskSelectorGroup").addClass("d-none");
			$("#taskNameGroup").removeClass("d-none");

			$("#task_id_hidden").val(item.id);
			$("#displayTaskName").val(item.text);

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
				url: BASE_URL + "project_management/Tasklist_problem/add_problem",
				type: "POST",
				dataType: "json",
				data: $(this).serialize(),
				success: function (res) {
					if (res.status === "success") {
						$("#modalAddProblem").modal("hide");
						Swal.fire({
							title: "Berhasil",
							text: res.message,
							icon: "success",
							showCancelButton: true,
							confirmButtonText: "Lihat List Kendala",
							cancelButtonText: "Ok",
						}).then((result) => {
							if (result.isConfirmed) {
								STATE.tabs.activeTab = "tasklist_problem";
								switchTab("menus", "capaian");
							}
						});
						render();
					}
				},
				complete: function () {
					$btn.prop("disabled", false);
					$spinner.addClass("d-none");
					$text.text("Simpan Kendala");
				},
			});
		});

		// Progress slider
		$("#gp-slider").on("input", function () {
			var v = +$(this).val();
			$("#gp-val").text(v);
			if (activePopId !== null) {
				var f = findItem(activePopId, activePopType);
				if (f) {
					// DO NOT update f.item.progress here.
					// This is only a visual preview in the DOM.

					// grid update
					var fillClr =
						v === 100 ? "rgba(16,185,129,.15)" : "rgba(59,130,246,.15)";
					var textClr = v === 100 ? "#047857" : "#1d4ed8";
					var $g = $(
						'#gantt-grid-rows .gantt-row[data-id="' + activePopId + '"]',
					);
					$g.find(".grid-prg-fill").css({
						width: v + "%",
						background: fillClr,
					});
					$g.find(".grid-prg-text")
						.css({ color: textClr })
						.html(
							v + '<small style="margin-left:2px;font-size:9px;">%</small>',
						);

					// If 100%, show Done icon preview
					if (v === 100) {
						$g.find(".status-chip i").attr("class", "bi bi-check-circle-fill");
						$g.find(".status-chip").attr("class", "status-chip st-done");
					} else if (f.item._origStatus !== "Done") {
						// Restore old icon/style if not 100
						$g.find(".status-chip i").attr("class", "bi " + f.item._origSIcon);
						$g.find(".status-chip").attr(
							"class",
							"status-chip " + f.item._origSStyle,
						);
					}
				}
			}
		});
		$("#gp-slider").on("change", function () {
			// Do nothing on change, wait for Save button
		});

		$("#gp-note").on("input", function () {
			var n = $(this).val().trim();
			var words = n ? n.split(/\s+/).filter(Boolean).length : 0;
			var $wc = $("#gp-word-count");
			$wc.text(words + " / 3 words");
			if (words < 3) $wc.css("color", "#94a3b8");
			else $wc.css("color", "#10b981");

			$(this).css({ "border-color": "#e2e8f0", background: "#fff" });
		});

		window.ganttClosePop = function (force) {
			if (!force && activePopId !== null) {
				var f = findItem(activePopId, activePopType);
				if (f) {
					var currentV = +$("#gp-slider").val();
					var origV = f.item._origProgress || 0;
					var n = $("#gp-note").val().trim();
					var words = n.split(/\s+/).filter(Boolean);

					var statusChanged = f.item.status !== f.item._origStatus;
					var progressChanged = currentV !== origV;

					// AUTO-SAVE if valid
					if (words.length >= 3 && (statusChanged || progressChanged)) {
						$("#gp-save").trigger("click");
						return; // gp-save will call ClosePop(true)
					}

					// DISCARD with toast if dirty but not auto-saveable
					if (statusChanged || progressChanged || words.length > 0) {
						Swal.fire({
							toast: true,
							position: "top-end",
							icon: "warning",
							title: "Changes not saved",
							text: "Your progress update was discarded.",
							showConfirmButton: false,
							timer: 3000,
							timerProgressBar: true,
						});

						// Revert local state
						f.item.progress = f.item._origProgress;
						f.item.status = f.item._origStatus;
						f.item.status_style = f.item._origSStyle;
						f.item.status_icon = f.item._origSIcon;
						f.item.tglSelesai = f.item._origTglSelesai;
						f.item.color = f.item._origColor;
					}
				}
			}
			$("#gantt-progress-pop").hide();
			activePopId = null;
			preprocessData();
			render(); // Revert any unsaved preview changes
		};

		$("#gp-save").on("click", function () {
			if (activePopId === null) return;
			var f = findItem(activePopId, activePopType);
			if (!f) return;

			var v = +$("#gp-slider").val();
			var n = $("#gp-note").val().trim();
			var $btn = $(this);

			var words = n.split(/\s+/).filter(Boolean);
			if (words.length < 3) {
				$("#gp-note")
					.css({ "border-color": "#ef4444", background: "#fff1f2" })
					.focus();
				Swal.fire({
					icon: "warning",
					title: "Note too short",
					text: "Please provide at least 3 words for the progress note.",
					timer: 3000,
					showConfirmButton: false,
				});
				return;
			}
			$("#gp-note").css({ "border-color": "#e2e8f0", background: "#f9fafb" });

			f.item.progress = v;

			// Sync side-effects if we just hit 100%
			var isCompletion = v === 100;
			if (isCompletion) {
				f.item.status = "Done";
				if (!f.item.tglSelesai) f.item.tglSelesai = isoDate(new Date());

				var sFound = (ganttLookups.statuses || []).find(function (v) {
					return v.status_name === "Done";
				});
				if (sFound) {
					f.item.status_icon = sFound.status_icon;
					f.item.status_style = sFound.style;
				}
			}

			$btn
				.prop("disabled", true)
				.html('<i class="bi bi-hourglass-split"></i> Saving...');
			preprocessData();

			// FIX: batch semua field completion dalam 1 request
			var batchFields = [{ field: "progress", value: v }];
			if (isCompletion) {
				batchFields.push({ field: "status", value: "Done" });
				batchFields.push({ field: "tglSelesai", value: f.item.tglSelesai });
			}

			persistBatch(
				activePopId,
				f.item.type,
				batchFields,
				function (res) {
					$btn.prop("disabled", false).text("Save Progress");

					Swal.fire({
						toast: true,
						position: "top-end",
						icon: "success",
						title: "Progress updated",
						showConfirmButton: false,
						timer: 2000,
						timerProgressBar: true,
					});

					setTimeout(function () {
						window.ganttClosePop(true);
					}, 300);
				},
				n,
			);
		});

		// Close overlays on outside click
		$(document).on("click.gantt", function (e) {
			if (!$(e.target).closest("#gantt-ctx-menu").length)
				$("#gantt-ctx-menu").hide();
			if (
				!$(e.target).closest("#gantt-progress-pop,.gantt-bar").length &&
				$("#gantt-progress-pop").is(":visible")
			) {
				window.ganttClosePop();
			}
		});

		/* =========================================================
        NOTE POPOVER & EVIDENCE MODAL LOGIC
        ========================================================= */

		window.ganttActiveNoteId = null;
		window.ganttActiveNoteType = null;

		window.ganttOpenNotePop = function (btn, id, type, e) {
			var $btn = $(btn);
			var fullNote = $btn.attr("data-full-note") || "";

			window.ganttActiveNoteId = id;
			window.ganttActiveNoteType = type;

			$("#gnp-text").val(fullNote);
			$("#gnp-status").css("opacity", "0");

			$("#gantt-note-pop").css({
				top: e.clientY - 20 + "px",
				left: e.clientX + 20 + "px",
				display: "block",
				opacity: "1",
			});

			$("#gnp-text").focus();
		};

		window.ganttCloseNotePop = function () {
			var id = window.ganttActiveNoteId;
			var type = window.ganttActiveNoteType;
			var rawText = $("#gnp-text").val();

			// FIX: hanya simpan jika ada perubahan
			if (id) {
				var f = findItem(id, type);
				var oldNote = f ? f.item.note || "" : "";

				if (rawText !== oldNote) {
					persistUpdate(id, type, "note", rawText, function (res) {
						var data;
						try {
							data = typeof res === "string" ? JSON.parse(res) : res;
						} catch (e) {
							data = { status: "error" };
						}
						if (data.status === "success") {
							var ff = findItem(id, type);
							if (ff) ff.item.note = rawText;
							render();
						}
					});
				}
			}

			$("#gantt-note-pop").fadeOut(150);
			window.ganttActiveNoteId = null;
			window.ganttActiveNoteType = null;
		};

		// Auto close note popup when clicking outside
		$(document).on("mousedown", function (e) {
			if (
				$("#gantt-note-pop").is(":visible") &&
				!$(e.target).closest("#gantt-note-pop, .gantt-note-btn").length
			) {
				window.ganttCloseNotePop();
			}
		});

		// Save note
		$(document).on("click", "#gnp-save", function () {
			window.ganttCloseNotePop();
		});

		/* Evidence Logic */
		window.ganttOpenEvidence = function (id, type) {
			$("#modal-evidence").modal("show");
			$("#ev-task-id").val(type === "task" ? id : "");
			$("#ev-project-id").val(type === "project" ? id : "");

			// reset form
			$("#ev-file").val("");
			$("#ev-url").val("");
			$("#ev-upload-progress").hide();

			loadEvidenceList(id, type);
		};

		window.toggleEvType = function () {
			var type = $("#ev-type").val();
			if (type === "file") {
				$("#ev-file").show();
				$("#ev-url").hide();
			} else {
				$("#ev-file").hide();
				$("#ev-url").show();
			}
		};

		function loadEvidenceList(id, itemType) {
			id = +id; // Coerce to number for findItem lookup
			var $con = $("#ev-list-container");
			$con.html(
				'<div style="padding:40px; text-align:center; color:#94a3b8; font-size:12px; font-weight:500;"><div class="spinner-border spinner-border-sm" role="status" style="color:var(--accent);"></div> Loading evidence...</div>',
			);

			$.post(
				BASE_URL + "project_management/beranda/ajax_get_evidence",
				{
					id: id,
					type: itemType,
				},
				function (res) {
					var data = JSON.parse(res);
					if (data.status === "success") {
						var evs = data.data;
						$("#ev-count-label").text(evs.length);

						// Sync local state count and re-render grid cell
						var f = findItem(id, itemType);
						if (f) {
							f.item.evidence_count = evs.length;
							render();
						}

						if (evs.length === 0) {
							$con.html(
								'<div style="padding:30px; text-align:center; color:#a1a1aa; font-size:12px;"><i class="bi bi-folder-x" style="font-size:24px; color:#e2e8f0; display:block; margin-bottom:8px;"></i> No evidence attached yet</div>',
							);
							return;
						}

						var html = '<ul style="list-style:none; padding:0; margin:0;">';
						for (var i = 0; i < evs.length; i++) {
							var e = evs[i];
							var icon =
								e.type === "url"
									? '<i class="bi bi-link-45deg"></i>'
									: '<i class="bi bi-file-earmark-text"></i>';
							var path = e.evidence_path;
							var fileName = path;
							var link = e.type === "url" ? path : BASE_URL + path;

							if (e.type === "file") {
								var parts = path.split("/");
								fileName = parts[parts.length - 1];
							}

							var date = e.created_at ? e.created_at.substring(0, 10) : "";

							html +=
								'<li style="padding:12px 16px; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center;">' +
								'<div style="display:flex; align-items:center; gap:12px; overflow:hidden;">' +
								'<div style="width:32px; height:32px; border-radius:6px; background:#f0f9ff; color:#0284c7; display:flex; justify-content:center; align-items:center; flex-shrink:0; font-size:14px;">' +
								icon +
								"</div>" +
								'<div style="min-width:0;">' +
								'<a href="' +
								link +
								'" target="_blank" style="font-size:12px; font-weight:600; color:#0f172a; text-decoration:none; display:block; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">' +
								fileName +
								"</a>" +
								'<span style="font-size:10px; color:#94a3b8;">' +
								date +
								"</span>" +
								"</div>" +
								"</div>" +
								'<button class="btn-delete-evidence" data-id="' +
								e.id +
								'" data-item-id="' +
								id +
								'" data-item-type="' +
								itemType +
								'" style="background:none; border:none; color:#ef4444; font-size:12px; cursor:pointer; padding:8px; flex-shrink:0; border-radius:4px;" onmouseover="this.style.background=\'#fef2f2\'" onmouseout="this.style.background=\'none\'"><i class="bi bi-trash3"></i></button>' +
								"</li>";
						}
						html += "</ul>";
						$con.html(html);
					} else {
						$con.html(
							'<div style="padding:20px; color:red; font-size:12px;">Failed to load evidence.</div>',
						);
					}
				},
			);
		}

		$(document).on("click", ".btn-delete-evidence", function () {
			var evId = $(this).data("id");
			var itemId = $(this).data("item-id");
			var itemType = $(this).data("item-type");

			if (!confirm("Delete this evidence?")) return;
			$.post(
				BASE_URL + "project_management/beranda/ajax_delete_evidence",
				{ id: evId },
				function (res) {
					var data = JSON.parse(res);
					if (data.status === "success") {
						loadEvidenceList(itemId, itemType);
					} else {
						alert("Delete failed.");
					}
				},
			);
		});

		// Upload AJAX
		$(document).on("submit", "#form-evidence", function (e) {
			e.preventDefault();
			var formData = new FormData(this);
			var taskId = $("#ev-task-id").val();
			var projId = $("#ev-project-id").val();
			var itemType = taskId ? "task" : "project";
			var itemId = taskId || projId;

			$("#btn-save-evidence").prop("disabled", true);
			$("#ev-upload-progress").show();
			$("#ev-progress-bar").css("width", "50%");

			$.ajax({
				url: BASE_URL + "project_management/beranda/ajax_upload_evidence",
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function (res) {
					$("#btn-save-evidence").prop("disabled", false);
					$("#ev-progress-bar").css("width", "100%");

					var data = JSON.parse(res);
					if (data.status === "success") {
						$("#ev-upload-progress").hide();
						$("#ev-progress-bar").css("width", "0%");
						$("#ev-file").val("");
						$("#ev-url").val("");
						loadEvidenceList(itemId, itemType);
					} else {
						$("#ev-upload-progress").hide();
						alert(data.message || "Error uploading evidence");
					}
				},
				error: function () {
					$("#btn-save-evidence").prop("disabled", false);
					$("#ev-upload-progress").hide();
					alert("Upload failed due to connection error.");
				},
			});
		});

		/* ══════════════════════════════════════════════════════════════════
        SPLITTER
        ══════════════════════════════════════════════════════════════════ */
		function bindSplitter() {
			var isResizing = false;
			var startX = 0;
			var startWidth = 0;
			var $grid = $("#gantt-grid");
			var $splitter = $("#gantt-splitter");
			var $body = $("#gantt-body");

			$splitter.off("mousedown.gsplit").on("mousedown.gsplit", function (e) {
				e.preventDefault();
				isResizing = true;
				startX = e.clientX;
				startWidth = $grid.width();
				$splitter.addClass("active");
				$("body").css("cursor", "col-resize");
			});

			$(document)
				.off("mousemove.gsplit")
				.on("mousemove.gsplit", function (e) {
					if (!isResizing) return;
					var newWidth = startWidth + (e.clientX - startX);
					// limits
					var minW = 350;
					var maxW = $body.width() - 100; // Leave space for timeline
					if (newWidth < minW) newWidth = minW;
					if (newWidth > maxW) newWidth = maxW;

					$grid.css("width", newWidth + "px");
				});

			$(document)
				.off("mouseup.gsplit")
				.on("mouseup.gsplit", function (e) {
					if (isResizing) {
						isResizing = false;
						$splitter.removeClass("active");
						$("body").css("cursor", "");
					}
				});
		}

		// Clear potential stale data immediately and show loader
		$("#gantt-grid-rows, #gantt-timeline-rows").empty();
		$("#gantt-loader").show().css("opacity", "1");

		setTimeout(function () {
			cb(start, end);
			bindSplitter();
		}, 100);
	})();
};
