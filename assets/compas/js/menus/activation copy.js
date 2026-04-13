window.LoadInit = window.LoadInit || {};
window.LoadInit['menus'] = window.LoadInit['menus'] || {};
window.LoadInit['menus']['activation'] = function (container) {
    loadTab('views', 'kanban'); 
};

async function loadActivation(view) {
    $.ajax({
			url: `${BASE_URL}compas/activation/load`,
			type: "POST",
			data: {
			},
			dataType: "json",
			success: function (response) {
                switch (view) {
                    case 'kanban':
                        loadActivationKanban(response.data);
                        break;
                    case 'list':
                        loadActivationList(response.data);
                        break;
                    case 'calendar':
                        loadActivationCalendar(response.data);
                        break;
                    default:
                        loadActivationKanban(response.data);
                        break;
                }
                
            },
        error: function (xhr, status, error) {
            console.error("Error fetching drafts:", error);
            $('#waitingcolumn').html('<div class="text-center text-danger p-3">Error loading campaigns</div>');
        }
    });
}

function loadActivationKanban(data){
    // console.log(KANBAN_STATUS);
    if(data){
        $('#waitingcolumn').empty();
        $('#reviewcolumn').empty();
        $('#approvedcolumn').find('.card:not(.border-dashed)').remove();

        data.forEach(item => {
            let card = `
            <div class="card border-0 mb-4" onclick="loadDetails('${item.campaign_id}')">
                <div class="card-body">
                    <div class="row align-items-center gx-2">
                        <div class="col">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-light-warning text-warning">Medium Priority</span>
                                <i class="bi bi-grip-vertical text-muted cursor-grab"></i>
                            </div>
                            <h6>${item.campaign_name || 'Untitled Campaign'}</h6>
                            <div class="text-secondary small mb-2">
                                <i class="bi bi-calendar me-1"></i> ${item.campaign_start_date || '-'}
                            </div>
                            <div class="text-secondary small mb-2">
                                <i class="bi bi-geo-alt me-1"></i> ${item.brand_name || '-'}
                            </div>
                            <div class="text-secondary small mb-3">
                                <i class="bi bi-currency-dollar me-1"></i> $${item.production_cost ? Number(item.production_cost).toLocaleString() : '0'} Budget
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row align-items-center gx-2">
                        <div class="col">
                            <div class="d-flex align-items-center">
                                <span class="small text-muted me-2">PIC: ${item.team_event || 'Vacant'}</span>
                                <div class="avatar avatar-30 bg-light-primary rounded-circle text-primary fw-bold">
                                    ${(item.team_event || 'VC').substring(0, 2).toUpperCase()}
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="avatar-group">
                                <div class="avatar avatar-30 coverimg rounded-circle border border-white">
                                    <img src="${BASE_URL}assets/compas/main_theme/img/user-1.jpg" alt="">
                                </div>
                                <div class="avatar avatar-30 coverimg rounded-circle border border-white">
                                    <img src="${BASE_URL}assets/compas/main_theme/img/user-2.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
            $(`#${KANBAN_STATUS[item.activation_status].kanban_status_name.toLowerCase()}column`).append(card);
        });
    }
}

function loadActivationList(data){
    
}
function loadActivationCalendar(data){
    
}


