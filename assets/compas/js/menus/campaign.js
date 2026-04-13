
// Campaign Tab Script
if (!window.LoadInit) {
	window.LoadInit = {};
}

window.LoadInit["menus"] = window.LoadInit["menus"] || {};
window.LoadInit["menus"]["campaign"] = function (container) {
	// console.log("Campaign tab initialized");

	// Load Campaign Stats
	loadCampaignStats();
	// Wizard Logic
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

	// Form Submission
	$('#addCampaignForm').off('submit').on('submit', function (e) {
		e.preventDefault();

		if (!validateStep(currentStep)) {
			return;
		}

		// Collect form data
		var formData = new FormData(this);

		// Add OverType valus manually if they are not picked up (usually textarea hidden inputs are sufficient if updated correctly)
		// Since OverType updates hidden inputs on change, formData should have them.

		// Append chosen values properly if needed (usually FormData handles select multiple)

		$.ajax({
			url: BASE_URL + 'compas/campaign/save_campaign',
			type: 'POST',
			data: formData,
			contentType: false,
			processData: false,
			dataType: 'json',
			beforeSend: function () {
				$('.btn-finish').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...').prop('disabled', true);
			},
			success: function (response) {
				if (response.status === 'success') {
					// Show success message
					Swal.fire({
						icon: 'success',
						title: 'Success!',
						text: response.message,
						showConfirmButton: false,
						timer: 1500
					}).then(() => {
						// Close modal and reset form
						$('#addCampaignModal').modal('hide');
						$('#addCampaignForm')[0].reset();
						// Reset wizard
						currentStep = 1;
						showStep(1);
						// Reload data
						loadDraftCampaigns(1);
						$('.btn-finish').html('Submit').prop('disabled', false);
					});
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Error!',
						text: response.message
					});
					$('.btn-finish').html('Submit').prop('disabled', false);
				}
			},
			error: function (xhr, status, error) {
				Swal.fire({
					icon: 'error',
					title: 'Error!',
					text: 'Something went wrong. Please try again.'
				});
				$('.btn-finish').html('Submit').prop('disabled', false);
				console.error(error);
			}
		});
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

	// =========================================================
	// VIEW TOGGLE: Kanban <-> Table
	// =========================================================
	var currentCampaignView = 'kanban';

	$(document).off('click', '.campaign-view-toggle').on('click', '.campaign-view-toggle', function () {
		var view = $(this).data('view');
		var icon = $(this).data('icon') || 'bi-kanban';

		// Update dropdown active state
		$('.campaign-view-toggle').removeClass('active');
		$(this).addClass('active');

		// Update icon
		$('#campaign_view_icon').removeClass().addClass('bi ' + icon);

		currentCampaignView = view;

		if (view === 'table') {
			$('#campaign_view_kanban').addClass('d-none');
			$('#campaign_view_table').removeClass('d-none');
			$('#campaign_table_search_wrap').removeClass('d-none');
			loadCampaignTable(1);
		} else {
			$('#campaign_view_table').addClass('d-none');
			$('#campaign_view_kanban').removeClass('d-none');
			$('#campaign_table_search_wrap').addClass('d-none');
		}
	});

	// =========================================================
	// TABLE VIEW: Load Campaigns
	// =========================================================
	var campaignTablePage = 1;
	var campaignTableSort = 'created_at';
	var campaignTableDir = 'desc';

	function loadCampaignTable(page) {
		page = page || 1;
		campaignTablePage = page;

		var search = $('#campaign_table_search').val();
		var startDate = $('#start_date').val();
		var endDate = $('#end_date').val();

		// Skeleton rows
		var skeletonRows = '';
		for (var s = 0; s < 5; s++) {
			skeletonRows += `<tr>
				<td><div class="skeleton skeleton-text w-50"></div></td>
				<td><div class="skeleton skeleton-text"></div><div class="skeleton skeleton-text w-50 mt-1"></div></td>
				<td><div class="skeleton skeleton-text w-75"></div></td>
				<td><div class="skeleton skeleton-text"></div></td>
				<td><div class="skeleton skeleton-tag w-50"></div></td>
				<td><div class="skeleton skeleton-text"></div></td>
				<td><div class="skeleton skeleton-avatar"></div></td>
				<td></td>
			</tr>`;
		}
		$('#campaign_table_body').html(skeletonRows);
		$('#campaign_table_pagination').html('');
		$('#campaign_table_info').text('Loading...');

		$.ajax({
			url: BASE_URL + 'compas/sub_campaign/kanban/get_all_campaigns',
			type: 'POST',
			dataType: 'json',
			data: {
				page: page,
				search: search,
				sort: campaignTableSort,
				dir: campaignTableDir,
				start_date: startDate,
				end_date: endDate
			},
			success: function (response) {
				if (!response || !response.items) {
					$('#campaign_table_body').html(`<tr><td colspan="8" class="text-center text-muted py-5">No campaigns found.</td></tr>`);
					$('#campaign_table_info').text('');
					return;
				}

				var items = response.items;
				var totalRows = response.total || 0;
				var totalPages = response.total_pages || 1;
				var currentPage = response.current_page || 1;
				var perPage = response.per_page || 10;
				var from = totalRows > 0 ? ((currentPage - 1) * perPage + 1) : 0;
				var to = Math.min(currentPage * perPage, totalRows);

				$('#campaign_table_info').text(`Showing ${from}–${to} of ${totalRows} campaigns`);

				if (items.length === 0) {
					$('#campaign_table_body').html(`<tr><td colspan="8" class="text-center text-muted py-5">No campaigns found.</td></tr>`);
					return;
				}

				// Status badge map
				var statusMap = {
					'1': { label: 'Draft', cls: 'bg-light-yellow text-yellow' },
					'2': { label: 'In Progress', cls: 'bg-light-blue text-blue' },
					'3': { label: 'Pre Production', cls: 'bg-light-green text-green' },
					'4': { label: 'Archived', cls: 'bg-secondary text-white' },
				};

				var html = '';
				$.each(items, function (idx, item) {
					var rowNum = from + idx;
					var status = statusMap[item.campaign_status] || { label: item.campaign_status || '-', cls: 'bg-secondary text-white' };

					// Priority badge
					var priorityCls = 'bg-light-green text-green';
					if (item.priority === 'At Risk') priorityCls = 'bg-light-yellow text-yellow';
					if (item.priority === 'Late') priorityCls = 'bg-light-orange text-orange';

					// Avatars
					var avatarsHtml = '';
					if (item.avatars && item.avatars.length) {
						$.each(item.avatars.slice(0, 3), function (i, av) {
							avatarsHtml += `<div class="avatar avatar-30 coverimg rounded-circle" style="background-image:url('${av}');"><img src="${av}" alt="" style="display:none;"></div>`;
						});
					}
					if (!avatarsHtml) avatarsHtml = '<span class="text-muted small">-</span>';

					// Progress bar (activation)
					var actTarget = parseInt(item.activation_target) || 0;
					var actActual = parseInt(item.activation_actual) || 0;
					var actPct = actTarget > 0 ? Math.round((actActual / actTarget) * 100) : 0;
					var progressHtml = actTarget > 0
						? `<div class="d-flex align-items-center gap-2">
							<div class="progress flex-grow-1" style="height:6px;min-width:60px;">
								<div class="progress-bar" role="progressbar" style="width:${actPct}%"></div>
							</div>
							<small class="text-muted">${actActual}/${actTarget}</small>
						</div>`
						: '<span class="text-muted small">-</span>';

					html += `<tr>
						<td class="px-4 text-muted small">${rowNum}</td>
						<td class="px-3">
							<div class="fw-semibold">${item.title || '-'}</div>
							<div class="text-muted small">${item.campaign_period || ''}</div>
						</td>
						<td class="px-3 small">${item.brand_name || '-'}</td>
						<td class="px-3 small text-muted">${item.campaign_period || '-'}</td>
						<td class="px-3"><span class="badge ${status.cls}">${status.label}</span></td>
						<td class="px-3" style="min-width:120px;">${progressHtml}</td>
						<td class="px-3"><div class="avatar-group d-flex">${avatarsHtml}</div></td>
						<td class="px-3 text-center">
							<a href="javascript:void(0)" onclick="loadDetails('${item.id}')" class="btn btn-sm btn-primary">
								<i class="bi bi-arrow-right"></i>
							</a>
						</td>
					</tr>`;
				});
				$('#campaign_table_body').html(html);

				// Build pagination
				if (totalPages > 1) {
					var pHtml = '';
					pHtml += `<li class="page-item ${currentPage == 1 ? 'disabled' : ''}">
						<a class="page-link" href="javascript:void(0)" data-tblpage="${currentPage - 1}">&#8249;</a></li>`;
					var startP = Math.max(1, currentPage - 2);
					var endP = Math.min(totalPages, currentPage + 2);
					for (var p = startP; p <= endP; p++) {
						pHtml += `<li class="page-item ${p == currentPage ? 'active' : ''}">
							<a class="page-link" href="javascript:void(0)" data-tblpage="${p}">${p}</a></li>`;
					}
					pHtml += `<li class="page-item ${currentPage == totalPages ? 'disabled' : ''}">
						<a class="page-link" href="javascript:void(0)" data-tblpage="${currentPage + 1}">&#8250;</a></li>`;
					$('#campaign_table_pagination').html(pHtml);
				} else {
					$('#campaign_table_pagination').html('');
				}
			},
			error: function () {
				$('#campaign_table_body').html(`<tr><td colspan="8" class="text-center text-danger py-5">Failed to load campaigns.</td></tr>`);
				$('#campaign_table_info').text('');
			}
		});
	}

	// Table pagination click
	$(document).off('click', '#campaign_table_pagination .page-link').on('click', '#campaign_table_pagination .page-link', function (e) {
		e.preventDefault();
		var p = $(this).data('tblpage');
		if (!$(this).parent().hasClass('disabled') && p > 0) {
			loadCampaignTable(p);
		}
	});

	// Table search
	var tableSearchTimer;
	$('#campaign_table_search').off('keyup').on('keyup', function () {
		clearTimeout(tableSearchTimer);
		tableSearchTimer = setTimeout(function () {
			if (currentCampaignView === 'table') loadCampaignTable(1);
		}, 500);
	});

	// Filter events
	var typingTimer;
	$('#draft_filter_title').on('keyup', function () {
		clearTimeout(typingTimer);
		typingTimer = setTimeout(function () {
			loadDraftCampaigns(1); // Reset to page 1 on filter
		}, 500);
	});

	function loadDraftCampaigns(page, priority = '') {
		var title = $('#draft_filter_title').val();

		// Skeleton Loading HTML
		var skeletonHtml = '';
		for (let i = 0; i < 3; i++) {
			skeletonHtml += `
		<div class="card border-0 mb-4">
			<div class="card-body">
				<div class="row align-items-center gx-2">
					<div class="col">
						<div class="skeleton skeleton-text w-25"></div>
						<div class="skeleton skeleton-img"></div>
						<div class="skeleton skeleton-tag"></div>
						<div class="skeleton skeleton-title"></div>
						<div class="skeleton skeleton-text"></div>
						<div class="skeleton skeleton-text w-75"></div>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<div class="row align-items-center gx-2">
					<div class="col-auto avatar-group">
						<div class="skeleton skeleton-avatar"></div>
						<div class="skeleton skeleton-avatar"></div>
					</div>
					<div class="col">
						<div class="skeleton skeleton-text w-50"></div>
					</div>
				</div>
			</div>
		</div>`;
		}

		// Show Skeleton before Ajax
		$('#draft_items_container').html(skeletonHtml);
		$('#draft_pagination_container').hide();

		$.ajax({
			url: `${BASE_URL}compas/sub_campaign/kanban/get_draft_campaigns`,
			type: "POST",
			data: {
				title: title,
				priority: priority,
				page: page,
				start_date: $('#start_date').val(),
				end_date: $('#end_date').val()
			},
			dataType: "json",
			success: function (response) {
				if (!response.items) {
					$('#draft_items_container').html('<div class="text-center text-muted p-3">No campaigns found</div>');
					return;
				}
				var items = response.items;
				var html = '';

				if (items.length > 0) {
					$.each(items, function (index, item) {
						var priorityClass = 'bg-light-green text-green';
						if (item.priority == 'At Risk') priorityClass = 'bg-light-yellow text-yellow';
						if (item.priority == 'Late') priorityClass = 'bg-light-orange text-orange';

						var avatarsHtml = '';
						$.each(item.avatars, function (i, avatar) {
							avatarsHtml += `<div class="avatar avatar-30 coverimg rounded-circle" style="background-image: url('${avatar}');">
											<img src="${avatar}" alt="" style="display: none;">
										</div>`;
						});

						let campaign_thumbnail = '';
						if (item.image != '') {
							campaign_thumbnail = `<div class="coverimg rounded h-110 overflow-hidden mb-3">
											<img src="${item.image}" class="w-100" alt="" />
										</div>`;
						}
						html += `
					<div class="card border-0 mb-4" id="${item.id}">
						<div class="card-body">
							<div class="row align-items-center gx-2">
								<div class="col">
									<div class="d-flex justify-content-between mb-3">
										<p class="text-secondary small mb-0">${item.time}</p>
										<span class="badge ${priorityClass}">${item.priority}</span>
									</div>
									${campaign_thumbnail}
									<h6 class="mb-2">${item.title}</h6>
									<p class="text-secondary small mb-3">${item.description}</p>
									<p class="text-secondary small mb-0"><i class="bi bi-person"></i> ${item.author}</p>
									<p class="text-secondary small mb-0"><i class="bi bi-calendar"></i> ${item.campaign_period}</p>
									<p class="text-secondary small mb-0"><i class="bi bi-tag"></i> ${item.content_pilar}</p>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<div class="row align-items-center gx-2">
								<div class="col-auto avatar-group">
									${avatarsHtml}
								</div>
								<div class="col">
									<p class="text-secondary small mb-0">${item.more_users} more</p>
									<p class="small">Working</p>
								</div>
								<div class="col-auto">
									<a href="javascript:void(0)" onclick="loadDetails('${item.id}')" class="btn btn-sm btn-primary d-flex align-items-center gap-2">Detail <i class="bi bi-arrow-right"></i></a>
								</div>
							</div>
						</div>
					</div>`;
					});
				} else {
					html = '<div class="text-center text-muted p-3">No campaigns found</div>';
				}

				$('#draft_items_container').html(html);

				// Pagination logic
				if (response.total_pages > 1) {
					$('#draft_pagination_container').show();
					var paginationHtml = '';

					// Previous
					var prevDisabled = (response.current_page == 1) ? 'disabled' : '';
					paginationHtml += `<li class="page-item ${prevDisabled}">
									<a class="page-link" href="javascript:void(0)" data-page="${response.current_page - 1}">Previous</a>
									</li>`;

					// Pages
					for (var i = 1; i <= response.total_pages; i++) {
						var active = (i == response.current_page) ? 'active' : '';
						paginationHtml += `<li class="page-item ${active}">
										<a class="page-link" href="javascript:void(0)" data-page="${i}">${i}</a>
										</li>`;
					}

					// Next
					var nextDisabled = (response.current_page == response.total_pages) ? 'disabled' : '';
					paginationHtml += `<li class="page-item ${nextDisabled}">
									<a class="page-link" href="javascript:void(0)" data-page="${response.current_page + 1}">Next</a>
									</li>`;

					$('#draft_pagination').html(paginationHtml);
				} else {
					$('#draft_pagination_container').hide();
				}
			},
			error: function (xhr, status, error) {
				console.error("Error fetching drafts:", error);
				$('#draft_items_container').html('<div class="text-center text-danger p-3">Error loading campaigns</div>');
			}
		});
	}

	// Pagination Click
	$(document).off('click', '#draft_pagination .page-link').on('click', '#draft_pagination .page-link', function (e) {
		e.preventDefault();
		var page = $(this).data('page');
		// Check if disabled
		if (!$(this).parent().hasClass('disabled') && page > 0) {
			loadDraftCampaigns(page);
		}
	});

	var start = moment().startOf('month');
	var end = moment().endOf('month');

	function cb(start, end) {
		$('#start_date').val(start.format('YYYY-MM-DD'));
		$('#end_date').val(end.format('YYYY-MM-DD'));
		$('#rangecalendar').val(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));

		loadDraftCampaigns(1);
		loadActivationsCampaigns(1);
		loadPreProductionCampaigns(1);
		loadArchivedCampaigns(1);
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

	$('.tanggal').datetimepicker({
		format: 'Y-m-d H:i:00',
		timepicker: true,
		scrollMonth: false,
		scrollInput: false,
		minDate: 0,
		allowTimes: [
			'08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00', '23:30', '24:00'
		]
	});

	$("#brand_id").chosen({ disable_search_threshold: 10 });
	$("#cp_id").chosen({ disable_search_threshold: 10 });
	$("#objective_id").chosen({ disable_search_threshold: 10 });
	$("#cg_id").chosen({ disable_search_threshold: 10 });
	$("#cf_id").chosen({ disable_search_threshold: 10 });

	$("#activation_team").chosen({ disable_search_threshold: 10 });
	$("#content_team").chosen({ disable_search_threshold: 10 });
	$("#talent_team").chosen({ disable_search_threshold: 10 });
	$("#distribution_team").chosen({ disable_search_threshold: 10 });
	$("#optimization_team").chosen({ disable_search_threshold: 10 });

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
					html += '<option value="">Pilih Brand</option>';
					$.each(response.data, function (index, brand) {
						html += '<option value="' + brand.brand_id + '">' + brand.brand_name + '</option>';
					});
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

	// Surprise Me Logic (AI Generated)
	$(document).off('click', '#btnCampaignSurpriseMe').on('click', '#btnCampaignSurpriseMe', function () {
		Swal.fire({
			title: 'Generate Campaign with AI',
			input: 'text',
			inputLabel: 'Topic / Keyword (Optional)',
			inputPlaceholder: 'e.g., Summer Sale, Tech Launch (Leave empty for random)',
			showCancelButton: true,
			confirmButtonText: 'Generate',
			showLoaderOnConfirm: true,
			preConfirm: (prompt) => {
				return $.ajax({
					url: BASE_URL + 'compas/campaign/generate_ai_campaign',
					type: 'POST',
					data: { user_prompt: prompt },
					dataType: 'json'
				}).then(response => {
					if (!response.status) {
						throw new Error(response.message || 'AI Generation failed');
					}
					return response.data;
				}).catch(error => {
					Swal.showValidationMessage(
						`Request failed: ${error}`
					);
				});
			},
			allowOutsideClick: () => !Swal.isLoading()
		}).then((result) => {
			if (result.isConfirmed) {
				const data = result.value;

				// 1. Text Inputs
				$('#campaign_name').val(data.campaign_name || '');
				$('#start_date').val(data.start_date || moment().format('YYYY-MM-DD HH:mm:ss'));
				$('#end_date').val(data.end_date || moment().add(30, 'days').format('YYYY-MM-DD HH:mm:ss'));

				$('#jumlah_konten_internal').val(data.internal_content_target || 0);
				// $('#link_referensi_internal').val(data.internal_reference_url || ''); // Handled by OverType
				$('#jumlah_konten_eksternal').val(data.external_content_target || 0);
				// $('#link_referensi_eksternal').val(data.external_reference_url || ''); // Handled by OverType

				// 2. Formatted Numbers
				$('#views').val(formatRibuan(data.target_views || 0));
				$('#leads').val(formatRibuan(data.target_leads || 0));
				$('#transaction').val(formatRibuan(data.target_transactions || 0));
				$('#cost_production').val(formatRibuan(data.production_cost || 0));
				$('#cost_placement').val(formatRibuan(data.placement_cost || 0));

				$('#activation_target').val(data.activation_target || 0);
				$('#content_target').val(data.content_target || 0);
				$('#distribution_target').val(data.distribution_target || 0);
				$('#optimization_target').val(data.optimization_target || 0);

				// 3. OverType Fields
				campaign_desc.setValue(data.campaign_desc || '');
				angle.setValue(data.content_angle || '');
				target_audiens.setValue(data.target_audience || '');
				problem.setValue(data.audience_problem || '');
				key_message.setValue(data.key_message || '');
				reason_to_believe.setValue(data.reason_to_believe || '');
				cta.setValue(data.call_to_action || '');
				link_referensi_internal.setValue(data.internal_reference_url || '');
				link_referensi_eksternal.setValue(data.external_reference_url || '');

				// Update hidden vals
				$('#campaign_desc_val').val(data.campaign_desc || '');
				$('#angle_val').val(data.content_angle || '');
				$('#target_audiens_val').val(data.target_audience || '');
				$('#problem_val').val(data.audience_problem || '');
				$('#key_message_val').val(data.key_message || '');
				$('#reason_to_believe_val').val(data.reason_to_believe || '');
				$('#cta_val').val(data.call_to_action || '');
				$('#link_referensi_internal_val').val(data.internal_reference_url || '');
				$('#link_referensi_eksternal_val').val(data.external_reference_url || '');

				// 4. Selects (Brand, etc) - Try to match if ID provided or perform improved matching later
				// For now assuming AI returns IDs if possible, or we just skip complex matching without IDs.
				// Or AI returns text and we try to match? 
				// Let's assume AI returns brand_id if it can, effectively we might need to prompt user to select brand first? 
				// The user request implies full generation. 
				// Let's assume response might have `brand_id` if we pass context, but here we just leave selects manually or random if data has it.

				if (data.brand_id) {
					$('#brand_id').val(data.brand_id).trigger('chosen:updated');

					const fetchAndSelect = (url, targetId, valueKey, textKey, selectedValues) => {
						return $.ajax({
							url: BASE_URL + url,
							type: 'POST',
							data: { brand_id: data.brand_id },
							dataType: 'json'
						}).then(response => {
							let html = '';
							if (response.data && response.data.length > 0) {
								$.each(response.data, function (index, item) {
									html += '<option value="' + item[valueKey] + '">' + item[textKey] + '</option>';
								});
							}
							$(targetId).html(html);

							if (selectedValues) {
								$(targetId).val(selectedValues);
							}
							$(targetId).trigger("chosen:updated");
						}).catch(err => console.error("Error loading " + targetId, err));
					};

					// Fetch all dependent options and set values
					Promise.all([
						fetchAndSelect('compas/campaign/get_content_pillars', '#cp_id', 'cp_id', 'cp_name', data.cp_id),
						fetchAndSelect('compas/campaign/get_objectives', '#objective_id', 'objective_id', 'objective_name', data.objective_id),
						fetchAndSelect('compas/campaign/get_generated_contents', '#cg_id', 'cg_id', 'cg_name', data.cg_id),
						fetchAndSelect('compas/campaign/get_content_formats', '#cf_id', 'cf_id', 'cf_name', data.cf_id),
						// Load teams options (no selection from AI for now)
						fetchAndSelect('compas/campaign/get_employees', '#activation_team', 'user_id', 'employee_name', null),
						fetchAndSelect('compas/campaign/get_employees', '#content_team', 'user_id', 'employee_name', null),
						fetchAndSelect('compas/campaign/get_employees', '#talent_team', 'user_id', 'employee_name', null),
						fetchAndSelect('compas/campaign/get_employees', '#distribution_team', 'user_id', 'employee_name', null),
						fetchAndSelect('compas/campaign/get_employees', '#optimization_team', 'user_id', 'employee_name', null)
					]).then(() => {
						Swal.fire({
							icon: 'success',
							title: 'Generated!',
							text: 'Campaign data generated by AI.',
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 2000
						});
					});

				} else {
					Swal.fire({
						icon: 'success',
						title: 'Generated!',
						text: 'Campaign data generated by AI (No Brand selected).',
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 2000
					});
				}
			}
		});
	});

	$('#addCampaignModal').on('hidden.bs.modal', function () {
		// reset form
		$('#addCampaignModal form')[0].reset();
		// reset chosen
		$('#brand_id').val('').trigger('chosen:updated');
		$('#cp_id').val('').trigger('chosen:updated');
		$('#objective_id').val('').trigger('chosen:updated');
		$('#cf_id').val('').trigger('chosen:updated');
		$('#cg_id').val('').trigger('chosen:updated');

		$('#activation_team').val('').trigger('chosen:updated');
		$('#content_team').val('').trigger('chosen:updated');
		$('#talent_team').val('').trigger('chosen:updated');
		$('#distribution_team').val('').trigger('chosen:updated');
		$('#optimization_team').val('').trigger('chosen:updated'); // Fixed optimasi -> optimization based on previous steps

		// reset overtype
		campaign_desc.setValue('');
		angle.setValue('');
		target_audiens.setValue('');
		problem.setValue('');
		key_message.setValue('');
		reason_to_believe.setValue('');
		cta.setValue('');
	});

	function loadCampaignsColumn(type, urlEndpoint, page = 1, priority = '') {
		var containerId = `#${type}_items_container`;
		var paginationId = `#${type}_pagination`;
		var paginationContainerId = `#${type}_pagination_container`;
		var title = $('#draft_filter_title').val(); // Assuming filter applies to all for now or should handle per column? User said "filter sama saja".

		// Correct endpoint
		var url = `${BASE_URL}compas/sub_campaign/kanban/${urlEndpoint}`;

		// Skeleton Loading HTML
		var skeletonHtml = '';
		for (let i = 0; i < 3; i++) {
			skeletonHtml += `
        <div class="card border-0 mb-4">
            <div class="card-body">
                <div class="row align-items-center gx-2">
                    <div class="col">
                        <div class="skeleton skeleton-text w-25"></div>
                        <div class="skeleton skeleton-img"></div>
                        <div class="skeleton skeleton-tag"></div>
                        <div class="skeleton skeleton-title"></div>
                        <div class="skeleton skeleton-text"></div>
                        <div class="skeleton skeleton-text w-75"></div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row align-items-center gx-2">
                    <div class="col-auto avatar-group">
                        <div class="skeleton skeleton-avatar"></div>
                        <div class="skeleton skeleton-avatar"></div>
                    </div>
                    <div class="col">
                        <div class="skeleton skeleton-text w-50"></div>
                    </div>
                </div>
            </div>
        </div>`;
		}

		// Show Skeleton before Ajax
		$(containerId).html(skeletonHtml);
		$(paginationContainerId).hide();

		$.ajax({
			url: url,
			type: "POST",
			data: {
				title: title,
				priority: priority,
				page: page,
				start_date: $('#start_date').val(),
				end_date: $('#end_date').val()
			},
			dataType: "json",
			success: function (response) {
				if (!response.items) {
					$(containerId).html('<div class="text-center text-muted p-3">No campaigns found</div>');
					return;
				}
				var items = response.items;
				var html = '';

				if (items.length > 0) {
					$.each(items, function (index, item) {
						var priorityClass = 'bg-light-green text-green';
						if (item.priority == 'At Risk') priorityClass = 'bg-light-yellow text-yellow';
						if (item.priority == 'Late') priorityClass = 'bg-light-orange text-orange';

						var avatarsHtml = '';
						$.each(item.avatars, function (i, avatar) {
							avatarsHtml += `<div class="avatar avatar-30 coverimg rounded-circle" style="background-image: url('${avatar}');">
                                            <img src="${avatar}" alt="" style="display: none;">
                                        </div>`;
						});

						let campaign_thumbnail = '';
						if (item.image != '') {
							campaign_thumbnail = `<div class="coverimg rounded h-110 overflow-hidden mb-3">
											<img src="${item.image}" class="w-100" alt="" />
										</div>`;
						}

						let progressHtml = '';
						if (type == 'activation') {
							// progress bar with percentage
							progressHtml = `
							<div class="progress mb-0 mt-3" style="height: 7px;">
								<div class="progress-bar-striped progress-bar-animated" role="progressbar" style="width: ${item.activation_actual / item.activation_target * 100}%;" aria-valuenow="${item.activation_actual / item.activation_target * 100}" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
							<p class="text-secondary text-end small mb-0 me-2">${item.activation_actual}/${item.activation_target}</p>
							`;
						}
						html += `
                    <div class="card border-0 mb-4" id="${item.id}">
                        <div class="card-body">
                            <div class="row align-items-center gx-2">
                                <div class="col">
                                    <div class="d-flex justify-content-between mb-3">
                                        <p class="text-secondary small mb-0">${item.time}</p>
                                        <span class="badge ${priorityClass}">${item.priority}</span>
                                    </div>
                                    ${campaign_thumbnail}
                                    <h6 class="mb-2">${item.title}</h6>
                                    <p class="text-secondary small mb-3">${item.description}</p>
                                    <p class="text-secondary small mb-0"><i class="bi bi-person"></i> ${item.author}</p>
                                    <p class="text-secondary small mb-0"><i class="bi bi-calendar"></i> ${item.campaign_period}</p>
                                    <p class="text-secondary small mb-0"><i class="bi bi-tag"></i> ${item.content_pilar}</p>
                                    ${progressHtml}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row align-items-center gx-2">
                                <div class="col-auto avatar-group">
                                    ${avatarsHtml}
                                </div>
                                <div class="col">
                                    <p class="text-secondary small mb-0">${item.more_users} more</p>
                                    <p class="small">Working</p>
                                </div>
                                <div class="col-auto">
                                    <a href="javascript:void(0)" onclick="loadDetails('${item.id}')" class="btn btn-sm btn-primary d-flex align-items-center gap-2">Detail <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>`;
					});
				} else {
					html = '<div class="text-center text-muted p-3">No campaigns found</div>';
				}

				$(containerId).html(html);

				// Pagination logic
				if (response.total_pages > 1) {
					$(paginationContainerId).show();
					var paginationHtml = '';

					// Previous
					var prevDisabled = (response.current_page == 1) ? 'disabled' : '';
					paginationHtml += `<li class="page-item ${prevDisabled}">
                                    <a class="page-link" href="javascript:void(0)" data-page="${response.current_page - 1}" data-type="${type}">Previous</a>
                                    </li>`;

					// Pages
					for (var i = 1; i <= response.total_pages; i++) {
						var active = (i == response.current_page) ? 'active' : '';
						paginationHtml += `<li class="page-item ${active}">
                                        <a class="page-link" href="javascript:void(0)" data-page="${i}" data-type="${type}">${i}</a>
                                        </li>`;
					}

					// Next
					var nextDisabled = (response.current_page == response.total_pages) ? 'disabled' : '';
					paginationHtml += `<li class="page-item ${nextDisabled}">
                                    <a class="page-link" href="javascript:void(0)" data-page="${response.current_page + 1}" data-type="${type}">Next</a>
                                    </li>`;

					$(paginationId).html(paginationHtml);
				} else {
					$(paginationContainerId).hide();
				}
			},
			error: function (xhr, status, error) {
				console.error("Error fetching " + type + " campaigns:", error);
				$(containerId).html('<div class="text-center text-danger p-3">Error loading campaigns</div>');
			}
		});
	}

	// Specific Load Functions
	function loadActivationsCampaigns(page, priority = '') {
		loadCampaignsColumn('activation', 'get_activations_campaigns', page, priority);
	}

	function loadPreProductionCampaigns(page, priority = '') {
		loadCampaignsColumn('preproduction', 'get_pre_production_campaigns', page, priority);
	}

	function loadArchivedCampaigns(page, priority = '') {
		loadCampaignsColumn('archived', 'get_archived_campaigns', page, priority);
	}

	// Generic Pagination Click Handler
	$(document).off('click', '.pagination .page-link').on('click', '.pagination .page-link', function (e) {
		e.preventDefault();
		var page = $(this).data('page');
		var type = $(this).data('type'); // activation, preproduction, archived
		if (!type && $(this).closest('#draft_pagination').length) return; // ignore drafts here as handled separately

		if (!$(this).parent().hasClass('disabled') && page > 0 && type) {
			if (type === 'activation') loadActivationsCampaigns(page);
			if (type === 'preproduction') loadPreProductionCampaigns(page);
			if (type === 'archived') loadArchivedCampaigns(page);
		}
	});

};

// ── Campaign Stat Cards ───────────────────────────────────────────────────
function loadCampaignStats() {

	// Show skeleton dashes while loading
	['#stat-avg-sla', '#stat-avg-ai', '#stat-total-submissions', '#stat-approved-plans'].forEach(id => $(id).text('—'));

	const formData = new FormData();

	fetch(`${BASE_URL}compas/campaign/get_campaign_stats`, {
		method: 'POST',
		body: formData,
	})
		.then(r => r.json())
		.then(result => {
			if (!result.status || !result.data) return;
			const d = result.data;

			// ── Count-up helper ──
			function countUp(selector, target, duration = 800) {
				const $el = $(selector);
				const start = 0;
				const step = target / (duration / 16);
				let cur = start;
				const tick = () => {
					cur += step;
					if (cur >= target) {
						$el.text(target);
					} else {
						$el.text(Math.floor(cur));
						requestAnimationFrame(tick);
					}
				};
				requestAnimationFrame(tick);
			}

			// AVG SLA TIME — format as "Xd Yh"
			const totalDays = d.avg_sla_days || 0;
			const wDays = Math.floor(totalDays);
			const wHours = Math.round((totalDays - wDays) * 24);
			const slaText = totalDays > 0
				? `${wDays}d${wHours > 0 ? ' ' + wHours + 'h' : ''}`
				: '0d';
			$('#stat-avg-sla').text(slaText);

			// AVG AI SCORE — count up
			countUp('#stat-avg-ai', d.avg_ai_score || 0);

			// TOTAL SUBMISSIONS — count up
			countUp('#stat-total-submissions', d.total_submissions || 0);

			// APPROVED PLANS — count up
			countUp('#stat-approved-plans', d.approved_plans || 0);
		})
		.catch(err => {
			console.warn('loadCampaignStats error:', err);
		});
}
// ── / Campaign Stat Cards ─────────────────────────────────────────────────