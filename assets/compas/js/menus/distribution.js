window.LoadInit = window.LoadInit || {};
window.LoadInit['menus'] = window.LoadInit['menus'] || {};
window.LoadInit['menus']['distribution'] = function (container) {
    loadTab('views', 'kanban'); 
    // Load Distribution Stats
    loadDistributionStats();
};



function initDateRange(view){
    var start = $('#start_date').val() ? moment($('#start_date').val()) : moment().startOf('month');
	var end = $('#end_date').val() ? moment($('#end_date').val()) : moment().endOf('month');

	function cb(start, end) {
		$('#start_date').val(start.format('YYYY-MM-DD'));
		$('#end_date').val(end.format('YYYY-MM-DD'));
		$('#rangecalendar').val(start.format('MM/DD/YYYY') + ' - ' + end.format('MM/DD/YYYY'));

		loadDistribution(view, start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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
}

async function loadDistribution(view, start, end) {
    $.ajax({
			url: `${BASE_URL}compas/distribution/load`,
			type: "POST",
			data: {
            start: start,
            end: end
			},
			dataType: "json",
			success: function (response) {
                switch (view) {
                    case 'kanban':
                        loadDistributionKanban(response.data);
                        break;
                    case 'list':
                        loadDistributionList(response.data);
                        break;
                    case 'calendar':
                        loadDistributionCalendar(response.data);
                        break;
                    default:
                        loadDistributionKanban(response.data);
                        break;
                }
            },
        error: function (xhr, status, error) {
            console.error("Error fetching drafts:", error);
            $('#waitingcolumn').html('<div class="text-center text-danger p-3">Error loading campaigns</div>');
        }
    });
}



function loadDistributionKanban(data){
    // console.log(KANBAN_STATUS);
    if(data){
        $('#waitingcolumn').empty();
        $('#onreviewcolumn').empty();
        $('#approvedcolumn').find('.card:not(.border-dashed)').remove();

        data.forEach(item => {
            // Generate Priority Class from status_leadtime
            let priorityText = item.status_leadtime || 'On Track';
            let priorityClass = 'bg-light-green text-success';
            if (priorityText === 'At Risk') priorityClass = 'bg-light-yellow text-warning';
            if (priorityText === 'Late') priorityClass = 'bg-light-orange text-danger';

            // Generate Avatars HTML from team_pictures
            let avatarsHtml = '';
            if (item.team_pictures) {
                let pics = item.team_pictures.split(',');
                console.log(pics);
                
                pics.slice(0, 3).forEach(pic => {
                    let avatarUrl = pic && pic !== '' ? 'https://trusmiverse.com/hr/uploads/profile/' + pic : 'https://trusmiverse.com/hr/uploads/profile/anonim.jpg';
                    avatarsHtml += `<div class="avatar avatar-30 coverimg rounded-circle border border-white" style="background-image: url('${avatarUrl}');">
                                        <img src="${avatarUrl}" alt="" style="display: none;">
                                    </div>`;
                });
                if (pics.length > 3) {
                    avatarsHtml += `<div class="avatar avatar-30 rounded-circle bg-light-secondary text-secondary fw-bold border border-white" style="font-size: 0.70rem; display: flex; align-items: center; justify-content: center;">+${pics.length - 3}</div>`;
                }
            } else {
                avatarsHtml = `<div class="avatar avatar-30 rounded-circle border border-white bg-light-secondary text-secondary" style="font-size: 0.70rem; display: flex; align-items: center; justify-content: center;"><i class="bi bi-person"></i></div>`;
            }

            // Format dates
            let startDate = item.campaign_start_date ? new Date(item.campaign_start_date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }) : '-';
            let endDate = item.campaign_end_date ? new Date(item.campaign_end_date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }) : '-';
            let dateDisplay = (startDate === endDate || endDate === '-') ? startDate : `${startDate} - ${endDate}`;

            // Format budget
            let budgetFormatted = item.production_cost ? new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.production_cost) : 'Rp 0';

            // Calculate Progress
            let actual = parseFloat(item.distribution_actual) || 0;
            let target = parseFloat(item.distribution_target) || 1;
            let progressPercent = Math.min((actual / target) * 100, 100);
            
            let progressBarColor = 'bg-primary'; 
            if (progressPercent >= 100) progressBarColor = 'bg-success';
            else if (progressPercent >= 50) progressBarColor = 'bg-info';
            else if (progressPercent > 0) progressBarColor = 'bg-warning';

            let priorityScore = 3;
            if (priorityText === 'Late') priorityScore = 1;
            else if (priorityText === 'At Risk') priorityScore = 2;

            let unixDate = item.campaign_start_date ? new Date(item.campaign_start_date).getTime() : 0;

            let card = `
            <div class="card border-0 mb-4 shadow-sm" data-date="${unixDate}" data-priority="${priorityScore}" style="cursor: pointer;" onclick="loadDetails('${item.campaign_id}')" onmouseover="this.classList.add('shadow')" onmouseout="this.classList.remove('shadow')">
                <div class="card-body">
                    <div class="row align-items-center gx-2">
                        <div class="col">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="d-flex align-items-center" style="min-width: 0;">
                                    <h6 class="fw-bold text-dark text-truncate mb-0 me-2" title="${item.campaign_name || 'Untitled Campaign'}">${item.campaign_name || 'Untitled Campaign'}</h6>
                                    <span class="badge ${priorityClass} flex-shrink-0">${priorityText}</span>
                                </div>
                                <i class="bi bi-grip-vertical text-muted cursor-grab ms-2 flex-shrink-0"></i>
                            </div>
                            
                            
                            <div class="text-secondary small mb-2 d-flex align-items-center">
                                <i class="bi bi-calendar-event me-2 text-primary"></i> 
                                <span class="text-truncate">${dateDisplay}</span>
                            </div>
                            <div class="text-secondary small mb-2 d-flex align-items-center">
                                <i class="bi bi-building me-2 text-info"></i> 
                                <span class="text-truncate" title="${item.brand_name || 'No Brand'}">${item.brand_name || 'No Brand'}</span>
                            </div>
                            <div class="text-secondary small mb-3 d-flex align-items-center">
                                <i class="bi bi-cash-stack me-2 text-success"></i> 
                                <span class="fw-medium">${budgetFormatted}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="progress mb-0 flex-grow-1" style="height: 7px;">
                                    <div class="progress-bar ${progressBarColor} progress-bar-striped progress-bar-animated" role="progressbar" style="width: ${progressPercent}%;" aria-valuenow="${progressPercent}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="text-secondary small mb-0 ms-3">${actual}/${target}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-dashed pt-3 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="avatar-group me-2">
                                ${avatarsHtml}
                            </div>
                            <div class="d-flex flex-column">
                                <span class="small text-muted" style="font-size: 0.70rem;">Assigned to</span>
                                <span class="small fw-medium text-dark text-truncate" style="max-width: 100px;">${item.team_count ? item.team_count + ' Members' : 'Unassigned'}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="col-auto me-3">
                                <div class="d-flex align-items-center text-secondary small">
                                    <i class="bi bi-chat-dots me-1"></i> ${item.comment_count || 0}
                                </div>
                            </div>
                            <div class="text-muted small" title="Distribution">
                                <i class="bi bi-calendar-check text-primary fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
            $(`#${KANBAN_STATUS[item.distribution_status].kanban_status_name.toLowerCase().replace(' ', '')}column`).append(card);
        });
    }
}


function loadDistributionList(data){
    const $table = $('#menus-list-table');
    
    // Initialize or Clear DataTable
    let dt;
    if ($.fn.DataTable.isDataTable($table)) {
        dt = $table.DataTable();
        dt.clear();
    } else {
        dt = $table.DataTable({
            pageLength: 10,
            responsive: true,
            language: {
                searchPlaceholder: 'Search events...'
            },
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            columns: [
                { data: 'col1' },
                { data: 'col2' },
                { data: 'colPriority' },
                { data: 'colPeriod' },
                { data: 'colBrand' },
                { data: 'colBudget' },
                { data: 'colProgress' },
                { data: 'teamHtml', orderable: false },
                { data: 'colComments' }
            ],
            createdRow: function(row, dtData, dataIndex) {
                $(row).css('cursor', 'pointer').attr('onclick', `loadDetails('${dtData.campaign_id}')`);
            }
        });
    }

    if (!data || data.length === 0) {
        dt.draw();
        return;
    }

    // Status config: maps distribution_status int → badge config
    const STATUS_CONFIG = {
        1: { label: 'Waiting',   badgeClass: 'bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-2' },
        2: { label: 'On Review', badgeClass: 'bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-2' },
        3: { label: 'Approved',  badgeClass: 'bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2' },
        4: { label: 'Rejected',  badgeClass: 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2' },
        5: { label: 'Revision',  badgeClass: 'bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-2' },
    };

    const rowsData = data.map(item => {
        const statusKey  = item.distribution_status || 1;
        const statusConf = STATUS_CONFIG[statusKey] || STATUS_CONFIG[1];

        // Format start date
        let startDateStr = item.campaign_start_date ? new Date(item.campaign_start_date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }) : '-';
        let endDateStr = item.campaign_end_date ? new Date(item.campaign_end_date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }) : '-';
        let dateDisplay = (startDateStr === endDateStr || endDateStr === '-') ? startDateStr : `${startDateStr} - ${endDateStr}`;

        // Format budget
        let budgetFormatted = item.production_cost ? new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.production_cost) : 'Rp 0';

        // Priorities
        let priorityText = item.status_leadtime || 'On Track';
        let priorityClass = 'bg-light-green text-success';
        let priorityScore = 3;
        if (priorityText === 'Late') {
            priorityClass = 'bg-light-red text-danger';
            priorityScore = 1;
        } else if (priorityText === 'At Risk') {
            priorityClass = 'bg-light-yellow text-warning';
            priorityScore = 2;
        }

        // Calculate Progress
        let actual = parseFloat(item.distribution_actual) || 0;
        let target = parseFloat(item.distribution_target) || 1;
        let progressPercent = Math.min((actual / target) * 100, 100);
        
        let progressBarColor = 'bg-primary'; 
        if (progressPercent >= 100) progressBarColor = 'bg-success';
        else if (progressPercent >= 50) progressBarColor = 'bg-info';
        else if (progressPercent > 0) progressBarColor = 'bg-warning';

        // Brand name
        const brandDisplay = item.brand_name || '-';

        // Build team avatars
        let teamHtml = '';
        const teamCount = parseInt(item.team_count) || 0;
        if (teamCount > 0) {
            const pictures = item.team_pictures ? item.team_pictures.split(',') : [];
            const names    = item.team_names    ? item.team_names.split(', ')  : [];
            const maxShow  = 3;
            let avatarGroup = '<div class="avatar-group me-2" style="display:inline-flex;">';
            const showCount = Math.min(pictures.length, maxShow);
            for (let i = 0; i < showCount; i++) {
                const pic  = pictures[i] ? pictures[i].trim() : '';
                const name = names[i] ? names[i].trim() : '';
                const initials = name ? name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase() : '?';
                if (pic) {
                    avatarGroup += `
                        <div class="avatar avatar-30 coverimg rounded-circle border border-white" style="${i > 0 ? 'margin-left:-8px;' : ''}" title="${name}">
                            <img src="https://trusmiverse.com/hr/uploads/profile/${pic}" alt="${name}" onerror="this.parentElement.innerHTML='<span class=\\'d-flex align-items-center justify-content-center h-100 small fw-bold\\'>${initials}</span>'">
                        </div>`;
                } else {
                    avatarGroup += `
                        <div class="avatar avatar-30 rounded-circle border border-white bg-light-primary d-flex align-items-center justify-content-center fw-bold text-primary" style="font-size:10px;${i > 0 ? 'margin-left:-8px;' : ''}" title="${name}">
                            ${initials}
                        </div>`;
                }
            }
            if (teamCount > maxShow) {
                avatarGroup += `
                    <div class="avatar avatar-30 rounded-circle border border-white bg-secondary d-flex align-items-center justify-content-center text-white" style="font-size:9px; margin-left:-8px;">
                        +${teamCount - maxShow}
                    </div>`;
            }
            avatarGroup += '</div>';
            const firstName = names[0] || 'Team';
            teamHtml = `
                <div class="d-flex align-items-center">
                    ${avatarGroup}
                    <span class="small text-muted fw-medium">${firstName}${teamCount > 1 ? ` +${teamCount - 1}` : ''}</span>
                </div>`;
        } else {
            teamHtml = `<span class="small text-muted fst-italic">No team</span>`;
        }

        return {
            campaign_id: item.campaign_id,
            col1: `
                <div class="d-flex flex-column" data-sort="${unixDate(item.campaign_start_date)}">
                    <span class="fw-bold text-dark text-truncate" style="max-width: 15rem;" title="${item.campaign_name || 'Untitled Campaign'}">${item.campaign_name || 'Untitled Campaign'}</span>
                </div>`,
            col2: `
                <span class="badge ${statusConf.badgeClass} rounded-pill px-3">
                    <i class="bi bi-circle-fill me-1" style="font-size:6px; vertical-align:middle;"></i>
                    ${statusConf.label}
                </span>`,
            colPriority: `
                <span class="badge ${priorityClass}" data-order="${priorityScore}">
                    ${priorityText}
                </span>`,
            colPeriod: `<span class="text-secondary small text-truncate d-block" style="max-width: 12rem;" data-order="${unixDate(item.campaign_start_date)}">${dateDisplay}</span>`,
            colBrand: `<span class="text-secondary small text-truncate d-block" style="max-width: 8rem;">${brandDisplay}</span>`,
            colBudget: `<span class="fw-semibold text-dark small" data-order="${item.production_cost || 0}">${budgetFormatted}</span>`,
            colProgress: `
                <div class="d-flex align-items-center" data-order="${progressPercent}">
                    <div class="progress flex-grow-1" style="height: 5px; width: 60px;">
                        <div class="progress-bar ${progressBarColor} progress-bar-striped progress-bar-animated" role="progressbar" style="width: ${progressPercent}%;" aria-valuenow="${progressPercent}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <span class="ms-2 small text-secondary">${actual}/${target}</span>
                </div>`,
            teamHtml: teamHtml,
            colComments: `<div class="text-secondary small fw-medium" data-order="${item.comment_count || 0}">${item.comment_count || 0}</div>`
        };
    });

    dt.rows.add(rowsData).draw();
}

function loadDistributionCalendar(data) {
    // ── Status config ──────────────────────────────────────────────────────────
    const STATUS_CONFIG = {
        1: { label: 'Waiting',   cssClass: 'event-waiting',  badgeClass: 'bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-2' },
        2: { label: 'On Review', cssClass: 'event-review',   badgeClass: 'bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-2' },
        3: { label: 'Approved',  cssClass: 'event-approved', badgeClass: 'bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2' },
        4: { label: 'Rejected',  cssClass: 'event-rejected', badgeClass: 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2' },
        5: { label: 'Revision',  cssClass: 'event-waiting',  badgeClass: 'bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-2' },
    };

    const MONTH_NAMES = [
        'January','February','March','April','May','June',
        'July','August','September','October','November','December'
    ];

    // ── State ──────────────────────────────────────────────────────────────────
    const today   = new Date();
    let viewYear  = today.getFullYear();
    let viewMonth = today.getMonth(); // 0-indexed

    // ── Helpers ────────────────────────────────────────────────────────────────
    function buildEventMap(campaigns) {
        // Map: "YYYY-MM-DD" → [campaign, …]
        const map = {};
        (campaigns || []).forEach(item => {
            if (!item.campaign_start_date) return;
            const key = item.campaign_start_date.substring(0, 10); // "YYYY-MM-DD"
            if (!map[key]) map[key] = [];
            map[key].push(item);
        });
        return map;
    }

    function formatDateKey(y, m, d) {
        return `${y}-${String(m + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
    }

    // ── Popup logic ────────────────────────────────────────────────────────────
    function showPopup(item) {
        const statusKey  = item.distribution_status || 1;
        const statusConf = STATUS_CONFIG[statusKey] || STATUS_CONFIG[1];

        // Status badge
        const $badge = $('#popup-status-badge');
        $badge.attr('class', `badge text-uppercase ${statusConf.badgeClass}`).text(statusConf.label);
        $badge.css('font-size', '10px');

        // Campaign name
        $('#popup-campaign-name').text(item.campaign_name || 'Untitled Campaign');

        // Date range
        let dateStr = '-';
        if (item.campaign_start_date) {
            const sd = new Date(item.campaign_start_date);
            const opts = { day: '2-digit', month: 'long', year: 'numeric' };
            dateStr = sd.toLocaleDateString('en-GB', opts);
            if (item.campaign_end_date) {
                const ed = new Date(item.campaign_end_date);
                dateStr += ' – ' + ed.toLocaleDateString('en-GB', opts);
            }
        }
        $('#popup-date-range').text(dateStr);

        // Brand
        $('#popup-brand').text(item.brand_name || '-');

        // Budget
        const budget = (parseFloat(item.production_cost) || 0) + (parseFloat(item.placement_cost) || 0);
        $('#popup-budget').text(budget > 0 ? '$' + budget.toLocaleString('en-US') + ' Budget' : 'No budget set');

        // Team info
        const teamCount = parseInt(item.team_count) || 0;
        let teamHtml = '<span class="small text-muted fst-italic">No team assigned</span>';
        if (teamCount > 0) {
            const names    = item.team_names ? item.team_names.split(', ') : [];
            const pictures = item.team_pictures ? item.team_pictures.split(',') : [];
            const pic      = pictures[0] ? pictures[0].trim() : '';
            const name     = names[0] ? names[0].trim() : 'Team';
            const initials = name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
            if (pic) {
                teamHtml = `<img src="https://trusmiverse.com/hr/uploads/profile/${pic}" class="rounded-circle border border-white me-2" width="24" height="24" alt="${name}" onerror="this.style.display='none'">
                            <span class="small text-muted fw-medium" style="font-size:11px;">${name}${teamCount > 1 ? ` +${teamCount - 1}` : ''}</span>`;
            } else {
                teamHtml = `<div class="avatar-30 rounded-circle bg-light-primary text-primary d-inline-flex align-items-center justify-content-center fw-bold me-2" style="width:24px;height:24px;font-size:9px;">${initials}</div>
                            <span class="small text-muted fw-medium" style="font-size:11px;">${name}${teamCount > 1 ? ` +${teamCount - 1}` : ''}</span>`;
            }
        }
        $('#popup-team-info').html(teamHtml);

        // View link
        $('#popup-view-link').off('click').on('click', function(e) {
            e.preventDefault();
            loadDetails(item.campaign_id);
        });

        $('#calendar-popup-card').removeClass('d-none');
    }

    // ── Grid renderer ──────────────────────────────────────────────────────────
    function renderCalendar(year, month, eventMap) {
        // Title
        $('#calendar-month-title').text(`${MONTH_NAMES[month]} ${year}`);

        const $body = $('#calendar-body');
        $body.empty();

        const firstDay      = new Date(year, month, 1).getDay(); // 0=Sun
        const daysInMonth   = new Date(year, month + 1, 0).getDate();
        const daysInPrevMonth = new Date(year, month, 0).getDate();

        const todayKey = formatDateKey(today.getFullYear(), today.getMonth(), today.getDate());

        let cellsRendered = 0;
        let monthEventCount = 0;

        // ── Previous month filler cells ──
        for (let i = 0; i < firstDay; i++) {
            const d = daysInPrevMonth - firstDay + 1 + i;
            $body.append(`<div class="calendar-day other-month"><span class="calendar-date text-muted">${d}</span></div>`);
            cellsRendered++;
        }

        // ── Current month cells ──
        for (let d = 1; d <= daysInMonth; d++) {
            const dateKey  = formatDateKey(year, month, d);
            const isToday  = (dateKey === todayKey);
            const events   = eventMap[dateKey] || [];
            monthEventCount += events.length;

            let eventsHtml = '';
            events.forEach(item => {
                const statusKey  = item.distribution_status || 1;
                const statusConf = STATUS_CONFIG[statusKey] || STATUS_CONFIG[1];
                const campId     = item.campaign_id;
                const name       = (item.campaign_name || 'Campaign').substring(0, 22);
                eventsHtml += `
                    <div class="calendar-event ${statusConf.cssClass}" 
                         onclick="(function(e){ e.stopPropagation(); window.__calShowPopup_${campId.replace(/[^a-z0-9]/gi,'_')}(); })(event)"
                         title="${item.campaign_name || ''}">
                        <div class="fw-bold text-truncate text-uppercase" style="font-size:10px;">${name}</div>
                    </div>`;
                // Store popup handler globally (avoids inline JSON escaping issues)
                window[`__calShowPopup_${campId.replace(/[^a-z0-9]/gi,'_')}`] = () => showPopup(item);
            });

            let dateHtml;
            if (isToday && events.length > 0) {
                dateHtml = `<div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="calendar-date mb-0 text-primary fw-bold">${d}</span>
                                <span class="badge bg-primary rounded-circle p-1" style="width:6px;height:6px;"></span>
                            </div>`;
            } else if (isToday) {
                dateHtml = `<span class="calendar-date text-primary fw-bold">${d}</span>`;
            } else if (events.length > 0) {
                dateHtml = `<div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="calendar-date mb-0">${d}</span>
                            </div>`;
            } else {
                dateHtml = `<span class="calendar-date">${d}</span>`;
            }

            $body.append(`
                <div class="calendar-day${isToday ? ' today' : ''}">
                    ${dateHtml}
                    ${eventsHtml}
                </div>`);
            cellsRendered++;
        }

        // ── Next month filler cells (fill to complete row of 7) ──
        const remaining = (7 - (cellsRendered % 7)) % 7;
        for (let d = 1; d <= remaining; d++) {
            $body.append(`<div class="calendar-day other-month"><span class="calendar-date text-muted">${d}</span></div>`);
        }

        // ── Event count ──
        $('#calendar-event-count').text(monthEventCount);
    }

    // ── Init ───────────────────────────────────────────────────────────────────
    const eventMap = buildEventMap(data);
    renderCalendar(viewYear, viewMonth, eventMap);

    // ── Navigation buttons ─────────────────────────────────────────────────────
    $('#cal-prev-btn').off('click').on('click', function () {
        viewMonth--;
        if (viewMonth < 0) { viewMonth = 11; viewYear--; }
        renderCalendar(viewYear, viewMonth, eventMap);
        $('#calendar-popup-card').addClass('d-none');
    });
    $('#cal-next-btn').off('click').on('click', function () {
        viewMonth++;
        if (viewMonth > 11) { viewMonth = 0; viewYear++; }
        renderCalendar(viewYear, viewMonth, eventMap);
        $('#calendar-popup-card').addClass('d-none');
    });

    // ── Close popup ────────────────────────────────────────────────────────────
    $('#popup-close-btn').off('click').on('click', function () {
        $('#calendar-popup-card').addClass('d-none');
    });
}

function loadDistributionStats() {
    ['#dist-stat-efficiency','#dist-stat-avg-ai','#dist-stat-total','#dist-stat-approved'].forEach(id => $(id).text('—'));
    const fd = new FormData();
    fetch(`${BASE_URL}compas/distribution/get_distribution_stats`, { method: 'POST', body: fd })
    .then(r => r.json())
    .then(result => {
        if (!result.status || !result.data) return;
        const d = result.data;
        function countUp(sel, val, dur = 800) {
            const $el = $(sel);
            const step = val / (dur / 16); let cur = 0;
            const tick = () => { cur += step; if (cur >= val) { $el.text(val); } else { $el.text(Math.floor(cur)); requestAnimationFrame(tick); } };
            requestAnimationFrame(tick);
        }
        
        const lead = d.avg_lead_days || 0;
        $('#dist-stat-avg-lead').text(lead > 0 ? lead + 'd' : '0d');
        countUp('#dist-stat-avg-ai', d.avg_ai_score || 0);
        countUp('#dist-stat-total', d.total_submissions || 0);
        countUp('#dist-stat-approved', d.approved_plans || 0);
    })
    .catch(err => console.warn('loadDistributionStats error:', err));
}
