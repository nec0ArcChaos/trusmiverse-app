<!-- Empty State -->
<!-- Empty State -->
<div class="row" id="activation-empty-state" style="display: none;">
    <div class="col-12" id="activation-empty-state">
        <div class="card rounded-4 shadow-1 border-0">
            <div class="card-body rounded-4 d-flex flex-column align-items-center justify-content-center text-center py-5"
                style="min-height: 400px;">
                <div class="rounded-circle bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center mb-3"
                    style="width: 72px; height: 72px;">
                    <i class="bi bi-calendar-event display-6 text-secondary"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Event Activation</h5>
                <p class="text-muted small mb-4" style="max-width: 320px;">
                    Manage offline events, booth setups, and on-ground activation details here.
                </p>
                <button class="btn btn-primary border-0 rounded-3 px-4 py-2 fw-bold shadow-sm small"
                    onclick="showActivationForm()">
                    + Add Event
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Active State -->
<div class="row" id="activation-content-section" style="display: none;">
    <div class="col-8">
        <!-- Operational Tasks -->
        <div class="card rounded-4 mb-4 shadow-1 border-0">
            <div
                class="card-header rounded-4 px-4 py-3 bg-white border-bottom d-flex justify-content-between align-items-center">
                <p class="text-uppercase fw-bold mb-0">Operational Tasks</p>
                <button class="btn btn-primary btn-sm rounded-pill px-3 d-flex align-items-center gap-1"
                    onclick="showActivationForm()">
                    <i class="bi bi-plus-lg"></i>
                    Add Task
                </button>
            </div>
            <div class="card-body rounded-4 p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3 text-uppercase text-muted small fw-bold border-0">Task Name</th>
                                <th class="px-4 py-3 text-uppercase text-muted small fw-bold border-0">Assigned</th>
                                <th class="px-4 py-3 text-uppercase text-muted small fw-bold border-0 text-center">
                                    Status</th>
                                <th class="px-4 py-3 text-uppercase text-muted small fw-bold border-0 text-end">Action
                                </th>
                            </tr>
                        </thead>
                        <tbody id="activation-table-body">
                            <tr>
                                <td class="px-4 py-3 border-bottom-0">
                                    <div class="fw-bold small">Script Drafting - Series B</div>
                                    <div class="text-muted" style="font-size: 10px;">Video Content</div>
                                </td>
                                <td class="px-4 py-3 border-bottom-0">
                                    <div class="d-flex position-relative">
                                        <img alt="Avatar" class="rounded-circle border border-2 border-white"
                                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBXbWmvXIq0zgos00HR_6QZpRZPiM9gtTXl-R5i2m_iQUzNOdaM2w8PBVI_ykmHIXrzEmXOYfEw9LonI_Z70sEm8zXcsw-QYLPSiuvrNi1g8jMeQw9eyxePPzG5t2JhvFVkrTC6ze8ZI2zbz3SKYJDgrfC_mPMC_GGQH8VZNoX22K4XYerEAH4t87cEVgJOx3Yljz-zln2K6x16Bi_TjSnEixoe5t4SmkAjJukex8PGlfvtLXFPmKIfHr853ulW2O0BxRVtXGewwmoD"
                                            width="28" height="28" />
                                        <div class="rounded-circle bg-light border border-2 border-white d-flex align-items-center justify-content-center fw-bold ms-n2"
                                            style="width: 28px; height: 28px; font-size: 8px; margin-left: -8px;">+2
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 border-bottom-0 text-center">
                                    <span
                                        class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-2"
                                        style="cursor: pointer;" onclick="window.toggleTaskStatus(this)">In
                                        Progress</span>
                                </td>
                                <td class="px-4 py-3 border-bottom-0 text-end">
                                    <button class="btn btn-link text-muted p-0 hover-primary" data-bs-toggle="modal"
                                        data-bs-target="#modal-sub-detail">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 border-bottom-0">
                                    <div class="fw-bold small">Influencer Outreach</div>
                                    <div class="text-muted" style="font-size: 10px;">Marketing</div>
                                </td>
                                <td class="px-4 py-3 border-bottom-0">
                                    <img alt="Avatar" class="rounded-circle border border-2 border-white"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuDuvXamLfCo4ghXYXQWobODaexecJn9rLtLSBtLH46x8taKCqsSh9hkHaIV_h2whzxB2NdMT8Kyo1p2pDBKY70MahrXQ6BYpL2W7fz6LWFcJZHEPrOTKZr6c5IEm0kw8oo09M3DdksqE22YWV67MqPlWOSdzGytDCccEYE8sfXTuOBw_YVNt2DOjKoooKOWYMycfo85t_BCNbXCTgRG9E2vVhKQRRLxmkn3nB4U2Pa-SVStLpeTaP1WO0wjb5iGYremGs_ar5tCMzNr"
                                        width="28" height="28" />
                                </td>
                                <td class="px-4 py-3 border-bottom-0 text-center">
                                    <span
                                        class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2"
                                        style="cursor: pointer;"
                                        onclick="window.toggleTaskStatus(this)">Completed</span>
                                </td>
                                <td class="px-4 py-3 border-bottom-0 text-end">
                                    <button class="btn btn-link text-muted p-0 hover-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Discussion -->
        <div class="card rounded-4 mb-4 shadow-1 border-0" style="height: 500px;">
            <div
                class="card-header rounded-4 px-4 py-3 bg-white border-bottom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-chat-left-text text-primary fs-5"></i>
                    <p class="text-uppercase fw-bold mb-0">Discussion</p>
                </div>
                <span class="badge bg-light text-secondary text-uppercase">4 Participants</span>
            </div>
            <div class="card-body rounded-4 px-4 overflow-auto d-flex flex-column gap-3" id="chat-container">
                <div class="d-flex gap-3">
                    <img alt="Avatar" class="rounded-circle"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBUW6hnNf3OSX_JQVBmRHzEKoWecHXDn-nDsdmxjENdcNscPTcvFw4SoZUCsJ_GsKOf3aO1onNgay4IPwbLgD6bMWZGIE-vnjwA5_P9T5Z5W6MuiXl9oQpVsjA1NByFgYEjuceIOMYJ0ZoeYp0nXEmmmi1eSsK7Uab6G4-TgSSlJAaEAhn_kJkk_SIpbcj60nJnE-bNPltPVLfz4oZDj_O2TyRh85QBveOpINIkDnOorJA_ZMzHLXL9CtmWVRxVG1NBhRW7W5_7w0ng"
                        width="32" height="32" />
                    <div class="d-flex flex-column gap-1" style="max-width: 80%;">
                        <div class="d-flex align-items-baseline gap-2">
                            <span class="fw-bold small">Sarah Jenkins</span>
                            <span class="text-muted" style="font-size: 10px;">10:42 AM</span>
                        </div>
                        <div class="bg-light p-3 rounded-3 rounded-top-0 small">
                            Hey team, I've just uploaded the final script for the Series B video.
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-3 flex-row-reverse">
                    <img alt="Avatar" class="rounded-circle"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuD0QrFaDvNO5ek-f5zTSrRhw2kEpCPslAnlLL9tYVNrjkFih2IS8g7d2UTnj2jMeIMinilpvaFR7fpVu64VvcpcFjrvnefmRiwFFwmkeha-OjsLXwJWrkomAccDGakcGHIesdbZ9UJSfDRKjabp03xwHv4j7rXctc5KEA2PJfHJ11RZRRTNL09aUMqcBRk8mwoDu3tKewW5DKfQGBEtr2gxIpbrbHkK38P7TQVahkwItdmDVC87BAdJ6IhJCtVnbaHKnTwTX0H4RBae"
                        width="32" height="32" />
                    <div class="d-flex flex-column align-items-end gap-1 text-end" style="max-width: 80%;">
                        <div class="d-flex align-items-baseline gap-2 flex-row-reverse">
                            <span class="fw-bold small">Mike Ross</span>
                            <span class="text-muted" style="font-size: 10px;">10:55 AM</span>
                        </div>
                        <div class="bg-primary text-white p-3 rounded-3 rounded-top-0 small">
                            Looks great, Sarah! I'll have the editors start on the B-roll selection.
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top px-4 py-3">
                <div class="position-relative">
                    <input type="text" class="form-control bg-light border-0 rounded-3 ps-3 pe-5 py-2 small"
                        id="chat-input" placeholder="Write a message..."
                        onkeypress="window.handleChatKeyPress(event)" />
                    <button
                        class="btn btn-link text-primary position-absolute top-50 end-0 translate-middle-y text-decoration-none p-2"
                        onclick="window.chatSimulation()">
                        <i class="bi bi-send"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-4">
        <!-- Activity Log -->
        <div class="card rounded-4 mb-4 shadow-1 border-0">
            <div class="card-header rounded-4 px-4 py-3 bg-white border-bottom d-flex align-items-center gap-2">
                <i class="bi bi-clock-history text-primary fs-5"></i>
                <p class="text-uppercase fw-bold mb-0">Activity Log</p>
            </div>
            <div class="card-body rounded-4 px-4">
                <div class="position-relative ps-3 my-2" id="global-activity-log-container">
                    <!-- Vertical line -->
                    <div class="position-absolute top-0 start-0 h-100 bg-light" style="width: 2px; margin-left: 9px;">
                    </div>
                    <!-- Logs will be loaded here -->
                    <div class="text-center py-3">
                        <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
                    </div>
                </div>
                <button class="btn btn-outline-secondary w-100 btn-sm text-uppercase fw-bold mt-3"
                    style="font-size: 10px; letter-spacing: 1px;" onclick="openViewFullLog()">
                    View Full Log
                </button>
            </div>
        </div>

        <!-- Team Performance -->
        <div class="card rounded-4 mb-4 shadow-1 border-0 text-white"
            style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
            <div class="card-body rounded-4 p-4">
                <h6 class="text-uppercase fw-bold opacity-75 mb-3" style="font-size: 12px; letter-spacing: 1px;">Team
                    Performance</h6>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3">
                            <div class="fs-4 fw-bolder">84%</div>
                            <div class="text-uppercase fw-bold opacity-75" style="font-size: 9px;">Efficiency</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3">
                            <div class="fs-4 fw-bolder">12</div>
                            <div class="text-uppercase fw-bold opacity-75" style="font-size: 9px;">Done</div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-flex align-items-center gap-2">
                    <div class="d-flex position-relative">
                        <img alt="Avatar" class="rounded-circle border border-white border-opacity-25"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuB2wbGk24utCbv6DxojQb16JRnFae1wfacZ8Qtqqu66ojxS15slxihkB9H93guAY20TTwUK3mp92sz5dLezNBW4uUIHD8jO8j3RD7jLGhXZrkREEOU4ZOOpUws3IMBxgE1SvyYesQm39YPz-TIMuAGontFqlBm3qxCWdUNS84NpV1_6kFqH_jpCr0X6Wf9aL6vYvUs49BIqFX1guswPBnaeKJ8-pvMFlYodQbJ6aJDBh9AuudWQ_n2kaPkbaB32V4jZjG5VvKAG34fW"
                            width="20" height="20" />
                        <img alt="Avatar" class="rounded-circle border border-white border-opacity-25 ms-n1"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuACOL4ijQVr2j4r66PBIaGu1-K6T-KDOOG7L3P7eaw0vsMRteswV8TzO2KOHgOa7mdwzhiwEXc1qk9-VBfjOJkzD9Ylj-Cg8YqbekCQN7ejPxjYPzR_aL6qyVNVxObNP3S9b1Dy_pUkLQefAKE8HuH8mkzQSpZ-s681wxfGMfNtyRGlnQx9bK_32ronG4Q5X-LjAovlURJUX9ZAbqBapG3LGCUZ0hdKfYQZIrl88Qn-JTX7t83pJBisyKsK7OjoM-etvdIzd4j2-ue5"
                            width="20" height="20" style="margin-left: -6px;" />
                    </div>
                    <span class="small fw-medium opacity-75 fst-italic" style="font-size: 10px;">Rising stars</span>
                </div>
            </div>
        </div>
    </div>
</div>