window.LoadInit = window.LoadInit || {};
window.LoadInit["tabs"] = window.LoadInit["tabs"] || {};
window.LoadInit["tabs"]["overview"] = function (container) {
	const base_url = $("body").data("base_url");
	const $container = $(container);

	// ECharts initialization
	var chartDomTaskByStatus = document.getElementById("task-by-status-chart");
	var myChartTaskByStatus = echarts.init(chartDomTaskByStatus);
	var optionTaskByStatus = {
		tooltip: {
			trigger: "item",
		},
		legend: {
			show: false,
		},
		series: [
			{
				name: "Task Status",
				type: "pie",
				radius: ["60%", "70%"],
				avoidLabelOverlap: false,
				padAngle: 5,
				itemStyle: {
					borderRadius: 100,
				},
				left: 0,
				top: 0,
				right: 0,
				bottom: 0,
				label: {
					show: true,
					position: "outside",
				},
				emphasis: {
					label: {
						show: true,
						fontSize: 16,
						fontWeight: "bold",
					},
				},
				labelLine: {
					show: false,
				},
				data: [], // Will be populated from AJAX
			},
		],
	};

	/**
	 * Set skeleton loading state
	 */
	function setSkeleton() {
		const skeletonHtmlSmall =
			'<span class="skeleton-box" style="width: 40px;"></span>';
		const skeletonHtmlLarge =
			'<span class="skeleton-box" style="width: 80px;"></span>';

		// Card 1
		$container.find("#avg-week-percent").html(skeletonHtmlSmall);
		$container
			.find("#weekly-progress-container")
			.html(
				'<div class="skeleton-box" style="width: 100%; height: 20px; margin-bottom: 10px;"></div>' +
					'<div class="skeleton-box" style="width: 100%; height: 20px; margin-bottom: 10px;"></div>' +
					'<div class="skeleton-box" style="width: 100%; height: 20px; margin-bottom: 10px;"></div>',
			);

		// Card 2
		$container
			.find("#summary-overall-percent")
			.html(
				'<span class="skeleton-box" style="width: 100px; height: 50px;"></span>',
			);
		$container.find("#summary-ontime-total").html(skeletonHtmlSmall);
		$container.find("#summary-ontime-percent").html(skeletonHtmlSmall);
		$container.find("#summary-late-total").html(skeletonHtmlSmall);
		$container.find("#summary-late-percent").html(skeletonHtmlSmall);

		// Reset progress bars
		$container.find(".progress-bar").css({
			width: "0%",
			transition: "none",
		});

		// Chart
		myChartTaskByStatus.showLoading();
	}

	/**
	 * Animate progress bar width
	 */
	function animateProgressBar($element, targetWidth) {
		setTimeout(() => {
			$element.css({
				transition: "width 1s cubic-bezier(0.4, 0, 0.2, 1)",
				width: targetWidth + "%",
			});
		}, 50);
	}

	/**
	 * Get color class based on percentage
	 */
	function getProgressColorClass(percentage) {
		if (percentage >= 100) return "text-success";
		if (percentage >= 80) return "text-warning";
		return "text-danger";
	}

	/**
	 * Populate Overview Data
	 */
	function populateData(data) {
		// Populate Card 1: Weekly Progress
		if (data.weekly_progress) {
			$container
				.find("#avg-week-percent")
				.text(data.weekly_progress.avg_percentage + "%");
			animateProgressBar(
				$container.find("#avg-week-progress"),
				data.weekly_progress.avg_percentage,
			);

			let weeklyHtml = "";
			data.weekly_progress.weeks.forEach((week) => {
				const colorClass = getProgressColorClass(week.percentage);
				weeklyHtml += `
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<div class="fw-bold text-dark mb-1" style="font-size: 0.825rem;">Week ${week.week}</div>
						</div>
						<div class="d-flex gap-2">
							<span class="badge bg-light text-secondary border px-2 py-1 fw-medium" style="font-size: 0.65rem;">Total: ${week.total}</span>
							<span class="badge bg-dark text-white px-2 py-1 fw-medium" style="font-size: 0.65rem;">Selesai: ${week.finished}</span>
							<div class="${colorClass} fw-bold" style="font-size: 0.9rem;">${week.percentage}%</div>
						</div>
					</div>
				`;
			});
			$container.find("#weekly-progress-container").html(weeklyHtml);
		}

		// Populate Card 2: Task Summary
		if (data.task_summary) {
			$container
				.find("#summary-overall-percent")
				.text(data.task_summary.overall_percentage + "%");
			$container.find("#summary-ontime-total").text(data.task_summary.ontime);
			$container
				.find("#summary-ontime-percent")
				.text(data.task_summary.ontime_percentage + "%");
			animateProgressBar(
				$container.find("#summary-ontime-progress"),
				data.task_summary.ontime_percentage,
			);

			$container.find("#summary-late-total").text(data.task_summary.late);
			$container
				.find("#summary-late-percent")
				.text(data.task_summary.late_percentage + "%");
			animateProgressBar(
				$container.find("#summary-late-progress"),
				data.task_summary.late_percentage,
			);
		}

		// Populate Card 3: Task by Status Chart
		if (data.task_by_status) {
			myChartTaskByStatus.hideLoading();
			optionTaskByStatus.series[0].data = data.task_by_status;
			myChartTaskByStatus.setOption(optionTaskByStatus);
		}
	}

	/**
	 * Fetch overview data via AJAX
	 */
	function fetchOverviewData() {
		setSkeleton();

		$.ajax({
			url: base_url + "project_management/overview/get_overview_data",
			method: "POST",
			dataType: "json",
			success: function (response) {
				if (response.status === "success" && response.data) {
					populateData(response.data);
				} else {
					console.error("Data not found or invalid response");
					myChartTaskByStatus.hideLoading();
				}
			},
			error: function (xhr, status, error) {
				console.error("Failed to load overview data:", error);
				myChartTaskByStatus.hideLoading();
			},
		});
	}

	// Make ECharts responsive
	$(window).on("resize", function () {
		if (myChartTaskByStatus) {
			myChartTaskByStatus.resize();
		}
	});

	// Initialize fetching data
	fetchOverviewData();
};
