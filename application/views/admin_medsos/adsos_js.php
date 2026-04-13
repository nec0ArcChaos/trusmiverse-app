<link rel="stylesheet"
    href="<?= base_url(); ?>assets/compas/main_theme/vendor/datetimepicker/jquery.datetimepicker.min.css" />
<script
    src="<?= base_url(); ?>assets/compas/main_theme/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function() {
        // Adding staggered animations for table rows
        $('.custom-table tbody tr').each(function(index) {
            $(this).css({
                'opacity': 0,
                'transform': 'translateY(10px)',
                'animation': `fadeInUp 0.4s ease forwards ${0.5 + (index * 0.1)}s`
            });
        });

        // Tab click interactions for table filters
        $('.table-nav-tabs .btn').click(function() {
            // Reset all buttons to light variant
            $('.table-nav-tabs .btn').removeClass('btn-primary text-white border-0 shadow-none').addClass('btn-light text-muted fw-semibold');
            $('.table-nav-tabs .btn .badge').removeClass('bg-white text-primary').addClass('bg-secondary-subtle text-muted');

            // Set clicked button to primary active state
            $(this).removeClass('btn-light text-muted fw-semibold').addClass('btn-primary text-white border-0 shadow-none');
            $(this).find('.badge').removeClass('bg-secondary-subtle text-muted').addClass('bg-white text-primary');
        });

        // Tab Admin Sosial Media Interaction
        $('#admin-sosmed-tab').on('shown.bs.tab', function(e) {
            console.log('Tab Admin Sosial Media aktif');
            // Tambahkan fungsi atau ajax call khusus untuk tab Admin Sosial Media di sini
        });

        // Tab Engage Instagram Interaction
        $('#engage-tab').on('shown.bs.tab', function(e) {
            console.log('Tab Engage Instagram aktif');
            // Tambahkan fungsi atau ajax call khusus untuk tab Engage Instagram di sini
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        fetchAdminSosialMetrics();
    });

    // change to today
    var start = moment();
    var end = moment();

    function cb(start, end) {
        $('#start_date').val(start.format('YYYY-MM-DD'));
        $('#end_date').val(end.format('YYYY-MM-DD'));
        $('#rangecalendar').val(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));
        reinitiate_data();
    }

    $('#company_id').on('change', function() {
        reinitiate_data();
    });

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

    function reinitiate_data() {
        let type = $('#adsosTab .nav-link.active').data('type');
        console.log('Reinitiate data for type:', type);
        if (type === 'admin_sosial_media') {
            fetchAdminSosialMetrics();
        } else if (type === 'engage_instagram') {
            fetchEngageInstagramMetrics();
        }
    }

    function fetchEngageInstagramMetrics() {
        const container = document.getElementById('admin-sosmed-metrics-container');
        const company_id = $('#company_id').val();
        const owner_id = $('#company_id').find(':selected').data('owner_id')
        const account_id = $('#company_id').find(':selected').data('account_id')
        const start_date = $('#start_date').val();
        const end_date = $('#end_date').val();
        // get li adsosTab where active
        let type = $('#adsosTab .nav-link.active').data('type');

        // Memberikan sedikit delay 500ms untuk efek skeleton loading
        setTimeout(() => {
            // POST Fetch Data
            $.ajax({
                    url: '<?= base_url("admin_medsos/engage_instagram") ?>',
                    method: 'POST',
                    data: {
                        company_id: company_id,
                        owner_id: owner_id,
                        account_id: account_id,
                        type: type,
                        start_date: start_date,
                        end_date: end_date
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status === 'success') {
                            currentAdsosCategories = response.categories;
                            renderEngageInstagramTopMetrics(response.top_metrics);
                            renderEngageInstagramActivities(response.activities);
                            renderTotalCapaianEngage(response.activities);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error fetching metrics:', error);
                    container.innerHTML = '<div class="col-12 py-3 text-center text-muted">Gagal memuat data.</div>';
                });
        }, 500);
    }

    function renderEngageInstagramTopMetrics(data) {
        const container = document.getElementById('engage-top-metrics-container');
        container.innerHTML = '';

        data.forEach(item => {
            const card = document.createElement('div');
            card.className = 'col';
            card.innerHTML = `
                <div class="card h-100 border border-light-subtle rounded-3 shadow-none metric-card bg-white">
                    <div class="card-body p-4 d-flex flex-column justify-content-between rounded-3">
                        <div class="mb-3">
                            <h6 class="fw-semibold mb-3 fs-6 text-dark">${item.title}</h6>
                            <h1 class="display-6 fw-bold text-dark mb-0" style="font-weight: 700 !important; font-size: 2.25rem;">
                                ${item.actual}
                            </h1>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between align-items-end mb-2">
                                <span class="text-muted fw-medium" style="font-size: 0.75rem;">Actual vs Target</span>
                                <span class="fw-semibold small text-dark" style="font-size: 0.8rem;">
                                    ${item.actual}/${item.target}
                                    <span class="text-primary fw-semibold">(${item.percent})</span>
                                </span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-primary rounded-3 progress-animate"
                                    role="progressbar" data-width="${item.percent}%"
                                    aria-valuenow="${item.percent}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(card);
        });

        // Jalankan animasi untuk masing-masing progress bar & number
        setTimeout(() => {
            document.querySelectorAll('#engage-top-metrics-container .progress-animate').forEach(el => {
                el.style.width = el.getAttribute('data-width');
            });
            animateCountUp();
        }, 50);
    }

    function renderEngageInstagramActivities(data) {
        const container = document.getElementById('engage-activities-container');
        container.innerHTML = '';

        const styles = [{
                icon: 'bi-person-add',
                color: 'text-success',
                bg: 'bg-success-subtle'
            },
            {
                icon: 'bi-chat-left-text',
                color: 'text-primary',
                bg: 'bg-primary-subtle'
            },
            {
                icon: 'bi-chat-square-text',
                color: 'text-warning',
                bg: 'bg-warning-subtle'
            },
            {
                icon: 'bi-bar-chart-line',
                color: 'text-purple',
                bg: 'bg-purple-subtle'
            },
            {
                icon: 'bi-hash',
                color: 'text-danger',
                bg: 'bg-danger-subtle'
            }
        ];

        data.forEach((item, index) => {
            const style = styles[index % styles.length];
            const target = parseFloat(item.target) || 0;
            const actual = parseFloat(item.actual) || 0;
            const percent = target > 0 ? Math.round((actual / target) * 100) : 0;
            const card = document.createElement('div');
            card.className = 'col';
            card.innerHTML = `
                <div class="card h-100 border border-light-subtle rounded-3 shadow-none metric-card bg-white">
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div>
                            <div class="mb-3 d-flex align-items-center justify-content-center border rounded-circle text-muted" style="width:28px; height:28px;">
                                <i class="bi ${style.icon} ${style.color}" style="font-size: 0.85rem;"></i>
                            </div>
                            <h6 class="fw-semibold mb-3 text-dark d-flex align-items-start gap-1" style="font-size: 0.9rem;">
                                ${item.title}
                                <i class="bi bi-info-circle text-muted opacity-50" style="font-size: 0.75rem; margin-top:2px;"></i>
                            </h6>
                        </div>
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-end mb-2">
                                <span class="text-muted fw-medium" style="font-size: 0.75rem;">Actual vs Target</span>
                                <span class="fw-bold text-dark" style="font-size: 0.75rem;">
                                    ${actual}/${target}
                                    <span class="text-primary fw-semibold">(${percent}%)</span>
                                </span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-primary rounded-3 progress-animate"
                                    role="progressbar" data-width="${percent}%"
                                    aria-valuenow="${percent}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(card);
        });

        // Jalankan animasi untuk masing-masing progress bar & number
        setTimeout(() => {
            document.querySelectorAll('#engage-activities-container .progress-animate').forEach(el => {
                el.style.width = el.getAttribute('data-width');
            });
            animateCountUp();
        }, 50);
    }

    function fetchAdminSosialMetrics() {
        const container = document.getElementById('admin-sosmed-metrics-container');
        const company_id = $('#company_id').val();
        const owner_id = $('#company_id').find(':selected').data('owner_id')
        const account_id = $('#company_id').find(':selected').data('account_id')
        const start_date = $('#start_date').val();
        const end_date = $('#end_date').val();
        // get li adsosTab where active
        let type = $('#adsosTab .nav-link.active').data('type');

        // Memberikan sedikit delay 500ms untuk efek skeleton loading
        // setTimeout(() => {
        // POST Fetch Data
        $.ajax({
                url: '<?= base_url("admin_medsos/admin_sosial_media") ?>',
                method: 'POST',
                data: {
                    company_id: company_id,
                    owner_id: owner_id,
                    account_id: account_id,
                    type: type,
                    start_date: start_date,
                    end_date: end_date
                },
                success: function(response) {
                    if (response.status === 'success') {
                        renderAdminSosialMetrics(response.data);
                        renderTableAdminSosial(response.data, response.table_data);
                        console.log(response);
                        if (response.resume) {
                            renderBannerData(response.resume);
                        }
                        renderTotalCapaian(response.data);
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching metrics:', error);
                container.innerHTML = '<div class="col-12 py-3 text-center text-muted">Gagal memuat data.</div>';
            });
        // }, 500);
    }

    let currentAdsosTableData = [];
    let currentAdsosCategories = [];
    let activeAdsosCategory = 'All';

    function renderTableAdminSosial(categories, table_data) {
        currentAdsosCategories = categories || [];
        currentAdsosTableData = table_data || [];

        const tabsContainer = document.querySelector('.table-nav-tabs');
        tabsContainer.innerHTML = '';

        let allCount = currentAdsosTableData.length;

        // Add "All" tab as default
        let allBtn = document.createElement('button');
        allBtn.className = 'btn btn-primary rounded-3 px-3 py-1 d-flex align-items-center gap-2 border-0 shadow-none text-white fs-6 filter-tab';
        allBtn.dataset.category = 'All';
        allBtn.innerHTML = `Semua <span class="badge bg-white text-primary rounded-3 ms-1 border border-white">${allCount}</span>`;
        tabsContainer.appendChild(allBtn);

        // Add dynamically generated category tabs
        if (categories && Array.isArray(categories)) {
            categories.forEach(cat => {
                let catCount = currentAdsosTableData.filter(row => row.adsos_category_name === cat.category).length;
                let btn = document.createElement('button');
                btn.className = 'btn btn-light rounded-3 px-3 py-1 d-flex align-items-center gap-2 text-muted fw-semibold fs-6 border-light-subtle filter-tab';
                btn.dataset.category = cat.category;
                btn.innerHTML = `${cat.category} <span class="badge bg-secondary-subtle text-muted rounded-3 ms-1">${catCount}</span>`;
                tabsContainer.appendChild(btn);
            });
        }

        // Add event listener to tabs
        document.querySelectorAll('.table-nav-tabs .filter-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Reset all tabs
                document.querySelectorAll('.table-nav-tabs .filter-tab').forEach(t => {
                    t.className = 'btn btn-light rounded-3 px-3 py-1 d-flex align-items-center gap-2 text-muted fw-semibold fs-6 border-light-subtle filter-tab';
                    let badge = t.querySelector('.badge');
                    if (badge) badge.className = 'badge bg-secondary-subtle text-muted rounded-3 ms-1';
                });

                // Set active class
                this.className = 'btn btn-primary rounded-3 px-3 py-1 d-flex align-items-center gap-2 border-0 shadow-none text-white fs-6 filter-tab';
                let activeBadge = this.querySelector('.badge');
                if (activeBadge) activeBadge.className = 'badge bg-white text-primary rounded-3 ms-1 border border-white';

                activeAdsosCategory = this.dataset.category;
                renderAdsosTableRows();
            });
        });

        // Initialize table
        activeAdsosCategory = 'All';
        renderAdsosTableRows();
    }

    function renderAdsosTableRows() {
        const tbody = document.querySelector('#table-adsos tbody');
        const searchTerm = document.getElementById('adsos_search').value.toLowerCase();
        tbody.innerHTML = '';

        let filteredData = currentAdsosTableData;
        console.log(currentAdsosTableData);

        // Filter by tab
        if (activeAdsosCategory !== 'All') {
            filteredData = filteredData.filter(row => row.adsos_category_name === activeAdsosCategory);
        }

        // Filter by search
        if (searchTerm) {
            filteredData = filteredData.filter(row => {
                return (row.account_name && row.account_name.toLowerCase().includes(searchTerm)) ||
                    (row.profile_link && row.profile_link.toLowerCase().includes(searchTerm)) ||
                    (row.date && row.date.toLowerCase().includes(searchTerm)) ||
                    (row.adsos_category_name && row.adsos_category_name.toLowerCase().includes(searchTerm));
            });
        }

        if (filteredData.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-4">Data tidak ditemukan</td></tr>';
            return;
        }

        filteredData.forEach((row, index) => {
            const tr = document.createElement('tr');
            tr.style.opacity = '0';
            tr.style.transform = 'translateY(10px)';
            tr.style.animation = `fadeInUp 0.4s ease forwards ${0.1 + (index * 0.05)}s`;

            tr.innerHTML = `
                <td class="fw-semibold text-dark fs-6 text-nowrap text-center">${row.date || ''}</td>
                <td class="fw-semibold text-dark fs-6 text-nowrap text-center">${row.employee_name || ''}</td>
                <td class="fw-semibold text-dark fs-6 text-nowrap text-center">${row.adsos_category_name || ''}</td>
                <td class="fw-semibold text-dark fs-6 text-nowrap">${row.account_name || ''}</td>
                <td>
                    <a href="${row.profile_link || '#'}" target="_blank"
                        class="text-decoration-none text-muted d-flex align-items-center gap-2">
                        ${row.profile_link || ''}
                        <i class="bi bi-box-arrow-up-right text-primary"></i>
                    </a>
                </td>
                <td class="text-center">
                    <div class="form-check ms-0 ps-0 pe-0 me-0 mb-0">
                        <input class="form-check-input border-secondary-subtle fs-5 m-0 cursor-pointer shadow-none"
                            type="checkbox" value="${row.is_dm}" style="cursor: pointer;" ${row.is_dm == '1' ? 'checked' : ''} disabled>
                    </div>
                </td>
                <td class="text-end text-nowrap">
                    <button class="btn btn-link text-dark me-3 p-0 custom-action-btn border-0" onclick="editAdsos('${row.adsos_id}')"><i
                            class="bi bi-pencil fs-5"></i></button>
                    <button class="btn btn-link text-danger p-0 custom-action-btn border-0" onclick="deleteAdsos('${row.adsos_id}')"><i
                            class="bi bi-trash fs-5"></i></button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    // Bind search event
    document.getElementById('adsos_search').addEventListener('input', function() {
        renderAdsosTableRows();
    });

    function renderBannerData(resume) {
        // Render Profile Picture
        const profileImg = document.getElementById('profile_picture_banner');
        const profileSkeleton = document.getElementById('profile_picture_skeleton');
        const profileLink = document.getElementById('profile_link_banner');

        if (resume.owner) {
            profileImg.src = `https://trusmiverse.com/dashboard_mm/assets/instagram/profile-${resume.owner.id}.jpg`;
            profileImg.onload = function() {
                profileImg.classList.remove('d-opacity-0');
                profileSkeleton.classList.add('d-none');
            };
            profileLink.href = `https://www.instagram.com/${resume.owner.username}`;

            document.getElementById('profile_name_banner').innerText = resume.owner.fullName || 'N/A';
            document.getElementById('profile_username_banner').innerText = `@${resume.owner.username}` || '@n/a';
        }

        // Render Metrics with Number Formatting
        const formatNumber = (num) => new Intl.NumberFormat('id-ID').format(num);

        document.getElementById('total_konten').innerText = formatNumber(resume.totalKonten);
        document.getElementById('total_views').innerText = formatNumber(resume.totalViews);
        document.getElementById('total_followers').innerText = formatNumber(resume.totalFollowers);

        // Helper for diff indicators
        const renderDiff = (elId, diff) => {
            const el = document.getElementById(elId);
            if (!el) return;
            el.classList.remove('d-opacity-0');
            if (diff >= 0) {
                el.className = 'progress-text text-green';
                el.innerHTML = `<i class="bi bi-arrow-up"></i><span>${formatNumber(diff)}</span> Last Mo.`;
            } else {
                el.className = 'progress-text text-red';
                el.innerHTML = `<i class="bi bi-arrow-down"></i><span>${formatNumber(Math.abs(diff))}</span> Last Mo.`;
            }
        };

        renderDiff('totalKontenDiff', resume.totalKontenDiff);
        renderDiff('totalViewsDiff', resume.totalViewsDiff);
        renderDiff('totalFollowersDiff', resume.totalFollowersDiff);
    }

    function renderTotalCapaian(data) {
        if (!data || data.length === 0) return;

        let totalActual = 0;
        let totalTarget = 0;

        data.forEach(m => {
            totalActual += parseFloat(m.actual) || 0;
            totalTarget += parseFloat(m.target) || 0;
        });

        const percent = totalTarget > 0 ? Math.round((totalActual / totalTarget) * 100) : 0;
        const remaining = totalTarget - totalActual;

        const descEl = document.getElementById('total_capaian_desc');
        const pctEl = document.getElementById('total_capaian_pct');

        if (remaining > 0) {
            descEl.innerHTML = `<b>${remaining}</b> Aktifitas lagi dari total <b>${totalTarget}</b> Target Aktifitas Harian untuk mencapai target.`;
        } else {
            descEl.innerHTML = `Selamat! Semua Target Aktifitas Harian (${totalTarget}) telah tercapai.`;
        }

        pctEl.innerText = `${percent}%`;
    }

    function renderTotalCapaianEngage(data) {
        if (!data || data.length === 0) return;

        let totalActual = 0;
        let totalTarget = 0;

        data.forEach(m => {
            totalActual += parseFloat(m.actual) || 0;
            totalTarget += parseFloat(m.target) || 0;
        });

        const percent = totalTarget > 0 ? Math.round((totalActual / totalTarget) * 100) : 0;
        const remaining = totalTarget - totalActual;

        const descEl = document.getElementById('total_capaian_engage_desc');
        const pctEl = document.getElementById('total_capaian_engage_pct');

        if (remaining > 0) {
            descEl.innerHTML = `<b>${remaining}</b> Aktifitas lagi dari total <b>${totalTarget}</b> Target Aktifitas Harian untuk mencapai target.`;
        } else {
            descEl.innerHTML = `Selamat! Semua Target Aktifitas Harian (${totalTarget}) telah tercapai.`;
        }

        pctEl.innerText = `${percent}%`;
    }

    function renderAdminSosialMetrics(data) {
        const container = document.getElementById('admin-sosmed-metrics-container');
        container.innerHTML = '';

        // Dummy icon styling (colors/BG) untuk membedakan
        const styles = [{
                icon: 'bi-hearts',
                color: 'text-success',
                bg: 'bg-success-subtle'
            },
            {
                icon: 'bi-chat-dots',
                color: 'text-primary',
                bg: 'bg-primary-subtle'
            },
            {
                icon: 'bi-arrow-left-right',
                color: 'text-warning',
                bg: 'bg-warning-subtle'
            },
            {
                icon: 'bi-graph-up-arrow',
                color: 'text-purple',
                bg: 'bg-purple-subtle'
            },
            {
                icon: 'bi-heart',
                color: 'text-danger',
                bg: 'bg-danger-subtle'
            }
        ];

        data.forEach((m, index) => {
            const style = styles[index % styles.length];
            const target = parseFloat(m.target) || 0;
            const actual = parseFloat(m.actual) || 0;
            const percent = target > 0 ? Math.round((actual / target) * 100) : 0;

            const cardHtml = `
            <div class="col">
                <div class="card h-100 border border-light-subtle rounded-3 shadow-none metric-card bg-white">
                    <div class="card-body p-3 d-flex flex-column justify-content-between rounded-3">
                        <div>
                            <div class="icon-square rounded-circle mb-3 d-flex align-items-center justify-content-center ${style.bg}"
                                style="width:44px;height:44px;">
                                <i class="bi ${style.icon} ${style.color} fs-5"></i>
                            </div>
                            <h6 class="fw-bold mb-1 fs-6 text-dark text-truncate" title="${m.title}">
                                ${m.title}
                            </h6>
                            <p class="text-muted small mb-3 text-truncate" style="font-size: 0.75rem;"
                                title="${m.short_desc}">${m.short_desc}</p>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between align-items-end mb-2">
                                <span class="text-muted small" style="font-size: 0.75rem;">Actual vs Target</span>
                                <span class="fw-bold small text-dark" style="font-size: 0.85rem;">
                                    <span class="count-up" data-value="${actual}">0</span>/<span class="count-up" data-value="${target}">0</span> 
                                    <span class="text-primary fw-bold">(<span class="count-up" data-value="${percent}">0</span>%)</span>
                                </span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-primary rounded-3 progress-animate" role="progressbar"
                                    style="width: 0%; transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);" data-width="${percent}%" aria-valuenow="${percent}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
            container.insertAdjacentHTML('beforeend', cardHtml);
        });

        // Jalankan animasi untuk masing-masing progress bar & number
        setTimeout(() => {
            document.querySelectorAll('#admin-sosmed-metrics-container .progress-animate').forEach(el => {
                el.style.width = el.getAttribute('data-width');
            });
            animateCountUp();
        }, 50);
    }

    function animateCountUp() {
        const elements = document.querySelectorAll('#admin-sosmed-metrics-container .count-up');
        const duration = 1500;

        elements.forEach(el => {
            const targetValue = parseInt(el.getAttribute('data-value'), 10);
            if (isNaN(targetValue) || targetValue === 0) {
                el.innerText = targetValue || 0;
                return;
            }

            const startTime = performance.now();

            function updateCount(currentTime) {
                const elapsedTime = currentTime - startTime;
                if (elapsedTime < duration) {
                    // easeOutQuart curve untuk menghaluskan akhir hitungan
                    const progress = 1 - Math.pow(1 - elapsedTime / duration, 4);
                    const currentVal = Math.floor(progress * targetValue);
                    el.innerText = currentVal;
                    requestAnimationFrame(updateCount);
                } else {
                    el.innerText = targetValue;
                }
            }
            requestAnimationFrame(updateCount);
        });
    }

    // -- Modal logic -- //

    function populateAdsosCategories(selectedCategoryId = '', selector = '#engage_category') {
        const select = $(selector);
        select.empty();
        select.append('<option value="">Pilih Kategori</option>');

        currentAdsosCategories.forEach(cat => {
            select.append(`<option value="${cat.id}" ${selectedCategoryId == cat.id ? 'selected' : ''}>${cat.category}</option>`);
        });

        console.log(currentAdsosCategories);

        // if "All" is not active, select the active category by default for new entry
        if (!selectedCategoryId && activeAdsosCategory !== 'All') {
            const cat = currentAdsosCategories.find(c => c.category === activeAdsosCategory);
            if (cat) {
                select.val(cat.id);
            }
        }
    }

    window.editAdsos = function(id) {
        const row = currentAdsosTableData.find(r => r.adsos_id == id);
        if (!row) return;

        $('#adsos_id').val(row.adsos_id);

        $('#adsos_date').val(moment().format('YYYY-MM-DDTHH:mm'));
        company_id = $('#company_id').find(':selected').val();
        owner_id = $('#company_id').find(':selected').data('owner_id');
        account_id = $('#company_id').find(':selected').data('account_id');
        account_name = $('#company_id').find(':selected').text();
        $('#adsos_account_id').val(account_id);
        $('#adsos_account_name').val(account_name.trim());
        populateAdsosCategories(row.adsos_category_id, '#adsos_category');
        $('#adsos_profile_link').val(row.profile_link);
        $('#adsos_is_dm').prop('checked', row.is_dm == '1');

        // Extracting date assuming model returns '%d-%m-%Y %H:%i'
        const dateParts = row.date.split(' ');
        const dayParts = dateParts[0].split('-');
        if (dayParts.length === 3) {
            $('#adsos_date').val(`${dayParts[2]}-${dayParts[1]}-${dayParts[0]}T${dateParts[1]}`);
        }

        const modal = new bootstrap.Modal(document.getElementById('modal-form-adsos'));
        modal.show();
    };

    $('#btn-add-engage').click(function() {
        $('#form-engage')[0].reset();
        $('#engage_category, #engage_date, #engage_account_name, #engage_evidence_link').removeClass('is-invalid is-valid');
        $('#engage_id').val('');
        $('#engage_date').val(moment().format('YYYY-MM-DDTHH:mm'));
        company_id = $('#company_id').find(':selected').val();
        owner_id = $('#company_id').find(':selected').data('owner_id');
        account_id = $('#company_id').find(':selected').data('account_id');
        account_name = $('#company_id').find(':selected').text();
        $('#engage_account_id').val(account_id);
        $('#engage_account_name').val(account_name);
        populateAdsosCategories('', '#engage_category');

        const modalAddEngage = new bootstrap.Modal(document.getElementById('modal-form-engage'));
        modalAddEngage.show();
    });

    $('#form-adsos').submit(function(e) {
        e.preventDefault();
        saveAdsosData('adsos');
    });

    $('#form-engage').submit(function(e) {
        e.preventDefault();
        if (!validateFormEngage()) return;
        saveAdsosData('engage');
    });

    function saveAdsosData(type) {
        const modalId = type === 'adsos' ? 'modal-form-adsos' : 'modal-form-engage';
        const formId = type === 'adsos' ? 'form-adsos' : 'form-engage';
        const saveBtn = type === 'adsos' ? $('#btn-save-adsos') : $('#btn-save-engage');
        const prefix = type === 'adsos' ? 'adsos_' : 'engage_';

        const originalText = saveBtn.html();
        saveBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...');
        saveBtn.prop('disabled', true);

        let fd = new FormData();
        let idKey = type === 'adsos' ? 'adsos_id' : 'engage_id';
        fd.append(idKey, $(`#${prefix}id`).val());
        fd.append('adsos_category_id', $(`#${prefix}category`).val());
        fd.append('date', $(`#${prefix}date`).val());
        fd.append('account_name', $(`#${prefix}account_name`).val());
        let profileLinkField = type === 'adsos' ? 'profile_link' : 'evidence_link';
        fd.append('company_id', $('#company_id').val());

        if (type === 'adsos') {
            const is_dm = $(`#${prefix}is_dm`).is(':checked') ? 1 : 0;
            fd.append('is_dm', is_dm);
            fd.append('profile_link', $(`#${prefix}${profileLinkField}`).val());
            fd.append('adsos_account_id', $('#adsos_account_id').val());
        } else {
            fd.append('note', $('#engage_note').val());
            fd.append('evidence_link', $(`#${prefix}${profileLinkField}`).val());
            fd.append('engage_account_id', $('#engage_account_id').val());
        }

        let url = type === 'adsos' ? '<?= base_url("admin_medsos/save_adsos_media") ?>' : '<?= base_url("admin_medsos/save_adsos_engage") ?>';

        fetch(url, {
                method: 'POST',
                body: fd
            })
            .then(res => res.json())
            .then(res => {
                saveBtn.html(originalText);
                saveBtn.prop('disabled', false);
                if (res.status === 'success') {
                    bootstrap.Modal.getInstance(document.getElementById(modalId)).hide();
                    reinitiate_data();
                    if (type === 'engage') loadTimelineActivities(); // Refresh timeline

                    Toastify({
                        text: 'Data berhasil disimpan!',
                        duration: 2000,
                        gravity: "top",
                        position: "right",
                        style: {
                            "background": "#28a745"
                        }
                    }).showToast();
                } else {
                    alert(res.message || 'Gagal menyimpan data');
                }
            })
            .catch(err => {
                console.error(err);
                saveBtn.html(originalText);
                saveBtn.prop('disabled', false);
            });
    }

    let deleteId = null;
    window.deleteAdsos = function(id) {
        deleteId = id;
        const modal = new bootstrap.Modal(document.getElementById('modal-delete-adsos'));
        modal.show();
    };

    $('#btn-confirm-delete-adsos').click(function() {
        if (!deleteId) return;

        const btn = $(this);
        const originalText = btn.html();
        btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menghapus...');
        btn.prop('disabled', true);

        let fd = new FormData();
        fd.append('adsos_id', deleteId);

        fetch('<?= base_url("admin_medsos/delete_adsos_media") ?>', {
                method: 'POST',
                body: fd
            })
            .then(res => res.json())
            .then(res => {
                btn.html(originalText);
                btn.prop('disabled', false);
                if (res.status === 'success') {
                    bootstrap.Modal.getInstance(document.getElementById('modal-delete-adsos')).hide();
                    fetchAdminSosialMetrics();
                    Toastify({
                        text: 'Data berhasil dihapus!',
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        style: {
                            "background": "#28a745"
                        }
                    }).showToast();
                } else {
                    alert(res.message || 'Gagal menghapus data');
                }
            })
            .catch(err => {
                console.error(err);
                btn.html(originalText);
                btn.prop('disabled', false);
            });
    });

    // --- Timeline Activity Logic ---
    let currentTimelineYear = moment().year();
    let currentTimelineMonth = moment().month(); // 0-11
    let activeTimelineDate = '<?= date('Y-m-d') ?>';
    let currentTimelineView = 'day'; // day, week, month
    let currentTeamId = 'all';

    function initTimeline() {
        populateMonthDropdown();
        renderTimelineHeader();
        generateDateCards();
        loadTimelineActivities();
    }

    function populateMonthDropdown() {
        const dropdownMenu = document.getElementById('month_dropdown_menu');
        if (!dropdownMenu) return;
        dropdownMenu.innerHTML = '';

        const months = moment.months();
        const now = moment();

        // Generate months for current year and previous year
        const years = [now.year(), now.year() - 1];

        years.forEach(year => {
            const labelYear = document.createElement('li');
            labelYear.innerHTML = `<h6 class="dropdown-header fw-bold text-dark bg-light py-2 px-3 mb-1 mt-1">${year}</h6>`;
            dropdownMenu.appendChild(labelYear);

            months.forEach((month, index) => {
                const li = document.createElement('li');
                const activeClass = (year === currentTimelineYear && index === currentTimelineMonth) ? 'bg-primary-subtle text-primary fw-bold' : '';
                li.innerHTML = `
                    <a class="dropdown-item rounded-3 py-2 px-3 mb-1 ${activeClass}" href="#" data-month="${index}" data-year="${year}">
                        ${month}
                    </a>
                `;
                dropdownMenu.appendChild(li);
            });
        });

        $('#month_dropdown_menu .dropdown-item').click(function(e) {
            e.preventDefault();
            currentTimelineYear = parseInt($(this).data('year'));
            currentTimelineMonth = parseInt($(this).data('month'));

            // Set active date to 1st of that month
            activeTimelineDate = moment([currentTimelineYear, currentTimelineMonth, 1]).format('YYYY-MM-DD');

            renderTimelineHeader();
            populateMonthDropdown(); // Refresh active state
            generateDateCards();
            loadTimelineActivities();
        });

        // Team Filter Interaction
        $(document).on('click', '.team-filter', function() {
            $('.team-filter').removeClass('btn-primary active').addClass('btn-outline-light text-dark bg-white');
            $(this).removeClass('btn-outline-light text-dark bg-white').addClass('btn-primary active');

            currentTeamId = $(this).data('user-id');
            // Re-render activities with filter
            loadTimelineActivities();
        });
    }

    function renderTimelineHeader() {
        const monthYearStr = moment([currentTimelineYear, currentTimelineMonth]).format('MMMM YYYY');
        $('#display_month_year').text(monthYearStr);
    }

    function generateDateCards() {
        const container = document.getElementById('timeline_date_cards');
        if (!container) return;
        container.innerHTML = '';

        let startDate, endDate;
        const baseDate = moment(activeTimelineDate);

        if (currentTimelineView === 'day') {
            // Show 7 days centered around active date
            startDate = moment(baseDate).subtract(3, 'days');
            endDate = moment(baseDate).add(3, 'days');
        } else if (currentTimelineView === 'week') {
            // Show current week
            startDate = moment(baseDate).startOf('week');
            endDate = moment(baseDate).endOf('week');
        } else if (currentTimelineView === 'month') {
            // Show all days in current month
            startDate = moment([currentTimelineYear, currentTimelineMonth, 1]);
            endDate = moment(startDate).endOf('month');
        }

        let curr = moment(startDate);
        while (curr <= endDate) {
            const dateStr = curr.format('YYYY-MM-DD');
            const isActive = dateStr === activeTimelineDate;
            const isToday = dateStr === moment().format('YYYY-MM-DD');

            const cardBg = isActive ? 'bg-primary text-white shadow-lg' : 'bg-white border border-light-subtle text-dark';
            const dayName = curr.format('ddd').toUpperCase();
            const dateNum = curr.format('D MMM');

            const card = document.createElement('div');
            card.className = `flex-fill date-card rounded-4 d-flex flex-column align-items-center justify-content-center py-3 text-center transition-all ${cardBg}`;
            card.style.minWidth = '125px';
            card.style.cursor = 'pointer';
            card.dataset.date = dateStr;

            if (isToday && !isActive) {
                card.style.borderColor = 'var(--bs-primary)';
            }

            card.innerHTML = `
                <span class="small fw-semibold text-uppercase opacity-75 mb-1" style="font-size: 0.7rem;">${dayName}</span>
                <span class="fs-4 fw-bold">${dateNum}</span>
            `;

            card.addEventListener('click', function() {
                activeTimelineDate = this.dataset.date;
                const mDate = moment(activeTimelineDate);
                currentTimelineYear = mDate.year();
                currentTimelineMonth = mDate.month();

                renderTimelineHeader();
                generateDateCards();
                loadTimelineActivities();
            });

            container.appendChild(card);
            curr.add(1, 'days');
        }

        // Scroll active card into view
        const activeCard = container.querySelector('.bg-primary');
        if (activeCard) {
            activeCard.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest',
                inline: 'center'
            });
        }
    }

    function loadTimelineActivities() {
        const body = document.getElementById('timeline_content_body');
        if (!body) return;

        // Show Skeleton
        renderTimelineSkeleton();

        $.ajax({
            url: '<?= base_url("admin_medsos/get_timeline_activities") ?>',
            method: 'POST',
            data: {
                date: activeTimelineDate,
                view_type: currentTimelineView,
                team_id: currentTeamId
            },
            success: function(response) {
                if (response.status === 'success') {
                    renderActivities(response.data);
                }
            },
            error: function() {
                body.innerHTML = '<div class="p-5 text-center text-muted">Gagal memuat data aktifitas.</div>';
            }
        });
    }

    function renderTimelineSkeleton() {
        const body = document.getElementById('timeline_content_body');
        let html = '';
        for (let i = 0; i < 4; i++) {
            html += `
                <div class="timeline-row d-flex border-bottom border-light-subtle">
                    <div class="time-col p-4 text-center border-end border-light-subtle d-flex flex-column justify-content-center" style="width: 100px; background-color: #fcfcfc;">
                        <div class="skeleton mb-2" style="height: 20px; width: 50px; margin: 0 auto;"></div>
                        <div class="skeleton" style="height: 10px; width: 30px; margin: 0 auto;"></div>
                    </div>
                    <div class="activity-col p-4 flex-grow-1">
                        <div class="skeleton rounded-3 mb-2" style="height: 60px; width: 80%; max-width: 400px;"></div>
                    </div>
                </div>
            `;
        }
        body.innerHTML = html;
    }

    function renderActivities(activities) {
        const body = document.getElementById('timeline_content_body');
        body.innerHTML = '';

        const hours = [
            '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'
        ];

        hours.forEach(h => {
            const hInt = parseInt(h.split(':')[0]);
            let period = 'Pagi';
            if (hInt >= 11 && hInt < 14) period = 'Siang';
            else if (hInt >= 14 && hInt < 18) period = 'Sore';
            else if (hInt >= 18) period = 'Malam';

            const filteredActivities = activities.filter(a => {
                const matchTeam = currentTeamId === 'all' || a.created_by == currentTeamId;
                const aHour = parseInt(a.time.split(':')[0]);
                return aHour === hInt && matchTeam;
            });

            const row = document.createElement('div');
            row.className = 'timeline-row d-flex border-bottom border-light-subtle last-child-no-border';

            // const colors = {
            //     'primary': '#198754',
            //     'secondary': '#F8E231',
            //     'tertiary': '#F2C464',
            //     'quaternary': '#EFF6FF'
            // };

            // const colorClass = `timeline-${currentTimelineView}-color-${colors[currentTimelineView]}`;

            let activitiesHtml = '';
            filteredActivities.forEach(a => {
                note = '';
                if (a.note != '') {
                    note = `<span class="badge bg-white text-dark"><span class="badge badge-sm bg-light-blue text-blue rounded-pill me-1"><i class="bi bi-sticky"></i></span>${a.note}</span>`;
                }

                if (a.adsos_category_id == '6') {
                    border_start_color = 'border-blue';
                } else if (a.adsos_category_id == '7') {
                    border_start_color = 'border-orange';
                } else if (a.adsos_category_id == '8') {
                    border_start_color = 'border-yellow';
                } else if (a.adsos_category_id == '9') {
                    border_start_color = 'border-teal';
                } else {
                    border_start_color = 'border-primary';
                }
                activitiesHtml += `
                    <div class="col-12 mb-3">
                        <div class="border-0 border-5 border-start ${border_start_color} px-3 py-2 rounded-start shadow-sm flex-1" style="background-color: ${a.badge_color};">
                            <div class="row">
                                <div class="col d-flex align-items-center gap-2 mb-1">
                                    <p class="fs-6 text-dark mb-0">
                                    <span class="badge bg-white text-dark"><span class="badge badge-sm bg-light-blue text-blue rounded-pill me-1"><i class="bi bi-clock"></i></span>${a.time}</span> 
                                        <span class="badge bg-white text-dark"><span class="badge badge-sm bg-light-blue text-blue rounded-pill me-1"><i class="bi bi-user"></i></span>${a.employee_name}</span>
                                        <span class="badge bg-white text-dark"><span class="badge badge-sm bg-light-blue text-blue rounded-pill me-1"><i class="bi bi-tag"></i></span>${a.type}</span> 
                                        <a href="${a.evidence_link}" target="_blank" class="text-decoration-none"><span class="badge bg-white text-dark"><span class="badge badge-sm bg-light-blue text-blue rounded-pill me-1"><i class="bi bi-link"></i></span>${a.evidence_link}</span></a>
                                        ${note || ''}
                                    </p>
                                </div>
                                <div class="col-auto d-flex align-items-center gap-2">
                                     <button class="btn btn-sm btn-link text-dark p-0 custom-action-btn border-0 edit-activity-btn" data-id="${a.engage_id}"><i class="bi bi-pencil fs-5"></i></button>
                                     <button class="btn btn-sm btn-link text-danger p-0 custom-action-btn border-0 delete-activity-btn" data-id="${a.engage_id}"><i class="bi bi-trash fs-5"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            row.innerHTML = `
                <div class="time-col p-4 text-center border-end border-light-subtle d-flex flex-column justify-content-center position-relative" style="width: 100px; background-color: #fcfcfc;">
                    <div class="time-marker-dot"></div>
                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 1.1rem; letter-spacing: -0.5px;">${h}</h6>
                    <span class="text-muted fw-bold text-uppercase opacity-50" style="font-size: 0.55rem; letter-spacing: 0.5px;">${period}</span>
                </div>
                <div class="activity-col p-4 flex-grow-1 position-relative d-flex align-items-center justify-content-between" style="min-height: 100px; background-color: #fff;">
                    <div class="activity-container w-100">
                        ${activitiesHtml || `
                            <div class="d-flex align-items-center h-100 opacity-25">
                                <span class="text-muted small fw-medium">Tidak ada aktivitas terjadwal</span>
                            </div>
                        `}
                    </div>
                    <button class="btn btn-primary btn-sm rounded-circle shadow-sm btn-add-timeline-activity ms-3 flex-shrink-0" 
                            data-hour="${h}" 
                            style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>
            `;
            body.appendChild(row);
        });

        // Add handler for timeline add button
        $('.btn-add-timeline-activity').click(function() {
            const hour = $(this).data('hour');
            const dateTime = `${activeTimelineDate}T${hour}`;
            $('#adsos_date').val(dateTime);
            $('#form-engage')[0].reset();
            $('#engage_category, #engage_date, #engage_account_name, #engage_evidence_link').removeClass('is-invalid is-valid');
            $('#engage_id').val('');
            $('#engage_date').val(moment().format('YYYY-MM-DDTHH:mm'));
            company_id = $('#company_id').find(':selected').val();
            owner_id = $('#company_id').find(':selected').data('owner_id');
            account_id = $('#company_id').find(':selected').data('account_id');
            account_name = $('#company_id').find(':selected').text();
            $('#engage_account_id').val(account_id);
            $('#engage_account_name').val(account_name);
            populateAdsosCategories('', '#engage_category');

            const modalAddEngage = new bootstrap.Modal(document.getElementById('modal-form-engage'));
            modalAddEngage.show();
        });
    }

    // View Toggle
    $('#timeline_view_toggle button').click(function() {
        $('#timeline_view_toggle button').removeClass('btn-white shadow-sm fw-bold text-primary').addClass('btn-transparent text-muted fw-semibold');
        $(this).removeClass('btn-transparent text-muted fw-semibold').addClass('btn-white shadow-sm fw-bold text-primary');

        currentTimelineView = $(this).data('view');
        generateDateCards();
        loadTimelineActivities();
    });

    // Navigation
    $('.prev-date-nav').click(function() {
        const m = moment(activeTimelineDate);
        if (currentTimelineView === 'day') m.subtract(1, 'days');
        else if (currentTimelineView === 'week') m.subtract(1, 'weeks');
        else if (currentTimelineView === 'month') m.subtract(1, 'months');

        activeTimelineDate = m.format('YYYY-MM-DD');
        currentTimelineYear = m.year();
        currentTimelineMonth = m.month();

        renderTimelineHeader();
        generateDateCards();
        loadTimelineActivities();
    });

    $('.next-date-nav').click(function() {
        const m = moment(activeTimelineDate);
        if (currentTimelineView === 'day') m.add(1, 'days');
        else if (currentTimelineView === 'week') m.add(1, 'weeks');
        else if (currentTimelineView === 'month') m.add(1, 'months');

        activeTimelineDate = m.format('YYYY-MM-DD');
        currentTimelineYear = m.year();
        currentTimelineMonth = m.month();

        renderTimelineHeader();
        generateDateCards();
        loadTimelineActivities();
    });

    $('#btn-add-adsos').click(function() {
        $('#form-adsos')[0].reset();
        $('#adsos_id').val('');
        $('#adsos_date').val(moment().format('YYYY-MM-DDTHH:mm'));
        company_id = $('#company_id').find(':selected').val();
        owner_id = $('#company_id').find(':selected').data('owner_id');
        account_id = $('#company_id').find(':selected').data('account_id');
        account_name = $('#company_id').find(':selected').text();
        $('#adsos_account_id').val(account_id);
        $('#adsos_account_name').val(account_name.trim());
        populateAdsosCategories('', '#adsos_category');
        $('#modal-form-adsos').modal('show');
        $('#modalFormAdsosLabel').text('Tambah Data Adsos');
    });

    // Initialize
    initTimeline();

    function validateFormEngage() {
        let isValid = true;

        // Fields to validate
        const fields = [{
                id: 'engage_category',
                name: 'Kategori'
            },
            {
                id: 'engage_date',
                name: 'Tanggal Selesai'
            },
            {
                id: 'engage_account_name',
                name: 'Nama Akun'
            },
            {
                id: 'engage_evidence_link',
                name: 'Evidence Link'
            }
        ];

        fields.forEach(field => {
            const element = $(`#${field.id}`);
            const value = element.val().trim();

            // Remove previous validation classes
            element.removeClass('is-invalid is-valid');

            if (!value) {
                element.addClass('is-invalid');
                isValid = false;
            } else {
                element.addClass('is-valid');
            }
        });

        return isValid;
    }

    // Event handlers for timeline activity buttons
    $(document).on('click', '.edit-activity-btn', function() {
        const id = $(this).data('id');
        $.ajax({
            url: '<?= base_url("admin_medsos/get_engage_by_id") ?>',
            method: 'POST',
            data: {
                engage_id: id
            },
            success: function(res) {
                if (res.status === 'success') {
                    const data = res.data;
                    $('#engage_id').val(data.engage_id);
                    populateAdsosCategories(data.adsos_category_id);
                    $('#engage_category').val(data.adsos_category_id);
                    $('#engage_date').val(moment(data.date).format('YYYY-MM-DDTHH:mm'));
                    $('#engage_account_id').val(data.engage_account_id);
                    $('#engage_account_name').val(data.account_name);
                    $('#engage_evidence_link').val(data.evidence_link);
                    $('#engage_note').val(data.note);
                    $('#modalFormEngageIgLabel').text('Edit Data Engage IG');
                    $('#engage_category, #engage_date, #engage_account_name, #engage_evidence_link').removeClass('is-invalid is-valid');
                    const modal = new bootstrap.Modal(document.getElementById('modal-form-engage'));
                    modal.show();
                } else {
                    alert(res.message);
                }
            }
        });
    });

    $(document).on('click', '.delete-activity-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data akan dihapus secara permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url("admin_medsos/delete_adsos_engage") ?>',
                    method: 'POST',
                    data: {
                        engage_id: id
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            loadTimelineActivities();
                            Toastify({
                                text: 'Data berhasil dihapus!',
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                style: {
                                    "background": "#dc3545"
                                }
                            }).showToast();
                        } else {
                            alert(res.message);
                        }
                    }
                });
            }
        });
    });
</script>