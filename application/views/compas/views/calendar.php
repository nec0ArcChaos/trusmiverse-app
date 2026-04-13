<!-- Calendar View -->
<div class="row">
    <div class="col-12">
        <!-- Navigation Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0 text-dark" id="calendar-month-title">Loading...</h5>
            <div class="btn-group gap-2">
                <button type="button" class="btn btn-light btn-sm border text-secondary shadow-sm" id="cal-prev-btn">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button type="button" class="btn btn-light btn-sm border text-secondary shadow-sm" id="cal-next-btn">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>

        <!-- Calendar Container -->
        <div class="calendar-wrapper shadow-sm">
            <!-- Header Row -->
            <div class="calendar-header-row bg-light border-bottom">
                <div class="calendar-header-cell text-muted text-uppercase small py-3">Sun</div>
                <div class="calendar-header-cell text-muted text-uppercase small py-3">Mon</div>
                <div class="calendar-header-cell text-muted text-uppercase small py-3">Tue</div>
                <div class="calendar-header-cell text-muted text-uppercase small py-3">Wed</div>
                <div class="calendar-header-cell text-muted text-uppercase small py-3">Thu</div>
                <div class="calendar-header-cell text-muted text-uppercase small py-3">Fri</div>
                <div class="calendar-header-cell text-muted text-uppercase small py-3">Sat</div>
            </div>

            <!-- Calendar Days – populated by loadActivationCalendar() -->
            <div class="calendar-body bg-light gap-px" id="calendar-body">
                <!-- Loading state -->
                <div style="grid-column: span 7;" class="text-center py-5 text-muted bg-white">
                    <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                    Loading calendar...
                </div>
            </div>
        </div>

        <!-- Footer / Legend -->
        <div class="d-flex align-items-center justify-content-between mt-3 px-2">
            <div class="d-flex align-items-center gap-4">
                <div class="d-flex align-items-center small text-secondary">
                    <span class="bg-warning rounded-circle me-2" style="width: 10px; height: 10px;"></span>
                    Waiting
                </div>
                <div class="d-flex align-items-center small text-secondary">
                    <span class="bg-primary rounded-circle me-2" style="width: 10px; height: 10px;"></span>
                    On Review
                </div>
                <div class="d-flex align-items-center small text-secondary">
                    <span class="bg-success rounded-circle me-2" style="width: 10px; height: 10px;"></span>
                    Approved
                </div>
                <div class="d-flex align-items-center small text-secondary">
                    <span class="bg-danger rounded-circle me-2" style="width: 10px; height: 10px;"></span>
                    Rejected
                </div>
            </div>
            <div class="small text-muted">
                Events this month: <span class="fw-bold text-dark" id="calendar-event-count">0</span>
            </div>
        </div>
    </div>
</div>

<!-- Event Popup Card (hidden by default, shown on event click) -->
<div class="card border-0 shadow calendar-details-card animate__animated animate__fadeInUp d-none"
    id="calendar-popup-card">
    <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <span class="badge text-uppercase" id="popup-status-badge" style="font-size: 10px;">Status</span>
            <button type="button" class="btn-close btn-sm" id="popup-close-btn" aria-label="Close"></button>
        </div>
        <h6 class="fw-bold mb-3 text-dark" id="popup-campaign-name">Campaign Name</h6>
        <div class="d-flex align-items-center text-muted small mb-2">
            <i class="bi bi-calendar3 me-2 text-secondary"></i>
            <span id="popup-date-range">-</span>
        </div>
        <div class="d-flex align-items-center text-muted small mb-2">
            <i class="bi bi-tag me-2 text-secondary"></i>
            <span id="popup-brand">-</span>
        </div>
        <div class="d-flex align-items-center text-muted small mb-3">
            <i class="bi bi-currency-dollar me-2 text-secondary"></i>
            <span class="fw-medium text-dark" id="popup-budget">-</span>
        </div>
        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
            <div class="d-flex align-items-center" id="popup-team-info">
                <span class="small text-muted fst-italic">No team assigned</span>
            </div>
            <a href="#" class="text-primary fw-bold text-decoration-none small" id="popup-view-link"
                style="font-size: 11px;">View Details</a>
        </div>
    </div>
</div>