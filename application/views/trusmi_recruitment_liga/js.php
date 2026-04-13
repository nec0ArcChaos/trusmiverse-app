<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    /* ── DATA (from PHP) ── */
    const picData = <?= json_encode($pic_js) ?>;
    const kebutuhanDetail = <?= json_encode($kebutuhan_detail_js) ?>;
    const pemenuhanDetail = <?= json_encode($pemenuhan_detail_js) ?>;
    const openPositions = <?= json_encode($open_js) ?>;
    const unitsData = <?= json_encode($units_data) ?>;
    const rejLabels = <?= json_encode($rej_labels) ?>;
    const rejValues = <?= json_encode($rej_values) ?>;

    /* ── HELPERS ── */
    function getStatusPill(status) {
        const map = {
            'Kritis':    { cls: 'rc-pill-red',    label: '⚠ Kritis' },
            'Perhatian': { cls: 'rc-pill-yellow', label: '! Perhatian' },
            'Monitor':   { cls: 'rc-pill-blue',   label: '· Monitor' },
            'Aman':      { cls: 'rc-pill-green',  label: '✓ Aman' },
        };
        const s = map[status] || map['Monitor'];
        return '<span class="rc-pill ' + s.cls + '">' + s.label + '</span>';
    }

    function getPctPill(pct) {
        let cls = pct >= 80 ? 'rc-pill-green' : pct >= 50 ? 'rc-pill-yellow' : 'rc-pill-red';
        return '<span class="rc-pill ' + cls + '" style="font-size:13px;font-weight:800;padding:3px 10px;">' + pct + '%</span>';
    }

    function getUnitBadge(unit) {
        const map = {
            'TKB': { bg: 'var(--rc-green-bg)', color: 'var(--rc-green)' },
            'BT':  { bg: 'var(--rc-orange-bg)', color: 'var(--rc-orange)' },
            'RSP': { bg: 'var(--rc-blue-bg)', color: 'var(--rc-blue)' },
        };
        const s = map[unit] || { bg: 'var(--rc-surface-alt)', color: 'var(--rc-text-sec)' };
        return '<span class="rc-unit-badge" style="background:' + s.bg + ';color:' + s.color + ';">' + unit + '</span>';
    }

    function getAgeColor(usia) {
        if (usia >= 45) return 'var(--rc-red)';
        if (usia >= 30) return 'var(--rc-yellow)';
        return 'var(--rc-blue)';
    }

    /* ── PIC TABLE ── */
    function buildKebutuhanTooltip(picId, kebutuhan) {
        var details = kebutuhanDetail[picId];
        if (!details || details.length === 0) {
            return '<td class="text-center" style="color:var(--rc-text-sec);">' + kebutuhan + '</td>';
        }
        // Group by job_title + department + position, sum vacancy
        var grouped = {};
        details.forEach(function(d) {
            var key = d.job_title + '||' + d.department + '||' + d.position;
            if (!grouped[key]) {
                grouped[key] = { job_title: d.job_title, department: d.department, position: d.position, vacancy: 0 };
            }
            grouped[key].vacancy += d.vacancy;
        });
        // Sort: by position then job_title
        var groupedArr = Object.values(grouped).sort(function(a, b) {
            var cmp = a.position.localeCompare(b.position);
            return cmp !== 0 ? cmp : a.job_title.localeCompare(b.job_title);
        });

        var tooltip = '<div class="rc-tooltip-detail">'
            + '<div class="rc-tooltip-title">Detail Kebutuhan</div>';
        var totalVacancy = 0;
        groupedArr.forEach(function(d) {
            totalVacancy += d.vacancy;
            tooltip += '<div class="rc-tooltip-row">'
                + '<div style="flex:1;">'
                + '<div class="rc-tooltip-job">' + d.job_title + '</div>'
                + '<div class="rc-tooltip-dept">' + d.department + ' · ' + d.position + '</div>'
                + '</div>'
                + '<div class="rc-tooltip-vacancy">' + d.vacancy + '</div>'
                + '</div>';
        });
        tooltip += '<div class="rc-tooltip-total">'
            + '<span>Total Kebutuhan</span>'
            + '<span>' + totalVacancy + '</span>'
            + '</div>';
        tooltip += '</div>';
        return '<td class="text-center rc-kebutuhan-cell" style="color:var(--rc-text-sec);">'
            + '<span style="border-bottom:1px dashed var(--rc-text-muted);cursor:pointer;">' + kebutuhan + '</span>'
            + tooltip + '</td>';
    }

    function buildPemenuhanTooltip(picId, pemenuhan) {
        var details = pemenuhanDetail[picId];
        if (!details || details.length === 0) {
            return '<td class="text-center" style="color:var(--rc-text-sec);">' + pemenuhan + '</td>';
        }
        var grouped = {};
        details.forEach(function(d) {
            var key = d.job_title + '||' + d.department + '||' + d.position;
            if (!grouped[key]) {
                grouped[key] = { job_title: d.job_title, department: d.department, position: d.position, pemenuhan: 0 };
            }
            grouped[key].pemenuhan += d.pemenuhan;
        });
        var groupedArr = Object.values(grouped).sort(function(a, b) {
            var cmp = a.position.localeCompare(b.position);
            return cmp !== 0 ? cmp : a.job_title.localeCompare(b.job_title);
        });

        var tooltip = '<div class="rc-tooltip-detail rc-tooltip-pemenuhan">'
            + '<div class="rc-tooltip-title">Detail Pemenuhan</div>';
        var totalPemenuhan = 0;
        groupedArr.forEach(function(d) {
            totalPemenuhan += d.pemenuhan;
            tooltip += '<div class="rc-tooltip-row">'
                + '<div style="flex:1;">'
                + '<div class="rc-tooltip-job">' + d.job_title + '</div>'
                + '<div class="rc-tooltip-dept">' + d.department + ' · ' + d.position + '</div>'
                + '</div>'
                + '<div class="rc-tooltip-vacancy" style="background:var(--rc-green-bg);color:var(--rc-green);">' + d.pemenuhan + '</div>'
                + '</div>';
        });
        tooltip += '<div class="rc-tooltip-total" style="border-top:2px solid var(--rc-green);color:var(--rc-green);">'
            + '<span>Total Pemenuhan</span>'
            + '<span>' + totalPemenuhan + '</span>'
            + '</div>';
        tooltip += '</div>';
        return '<td class="text-center rc-pemenuhan-cell" style="color:var(--rc-text-sec);">'
            + '<span style="border-bottom:1px dashed var(--rc-green);cursor:pointer;color:var(--rc-green);font-weight:700;">' + pemenuhan + '</span>'
            + tooltip + '</td>';
    }

    function renderPICTable() {
        let html = '';
        picData.forEach(function(p) {
            const gap = p.kebutuhan - p.pemenuhan;
            const gapColor = gap > 0 ? 'var(--rc-red)' : 'var(--rc-green)';
            const gapText = gap > 0 ? '-' + gap : '✓';
            const statusLabel = p.pct >= 80 ? 'Aman' : p.pct >= 50 ? 'Monitor' : 'Kritis';
            const note = p.pct === 100 ? 'Excellent — semua posisi terpenuhi'
                : p.pct >= 70 ? 'Progres baik, perlu sedikit dorongan'
                : p.pct >= 50 ? 'Beberapa posisi sulit terpenuhi'
                : 'Butuh support & review strategi sourcing';
            html += '<tr>'
                + '<td style="font-weight:700;">' + p.pic + '</td>'
                + buildKebutuhanTooltip(p.id_pic, p.kebutuhan)
                + buildPemenuhanTooltip(p.id_pic, p.pemenuhan)
                + '<td>' + getPctPill(p.pct) + '</td>'
                + '<td class="text-center" style="color:' + gapColor + ';font-weight:700;">' + gapText + '</td>'
                + '<td>' + getStatusPill(statusLabel) + '</td>'
                + '<td style="color:var(--rc-text-muted);font-size:11px;">' + note + '</td>'
                + '</tr>';
        });
        document.getElementById('picTableBody').innerHTML = html;

        // Attach hover events for tooltip positioning (kebutuhan + pemenuhan)
        document.querySelectorAll('.rc-kebutuhan-cell, .rc-pemenuhan-cell').forEach(function(cell) {
            var tooltip = cell.querySelector('.rc-tooltip-detail');
            if (!tooltip) return;
            cell.addEventListener('mouseenter', function(e) {
                var rect = cell.getBoundingClientRect();
                tooltip.style.display = 'block';
                var top = rect.bottom + 8;
                var left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2);
                if (top + tooltip.offsetHeight > window.innerHeight) {
                    top = rect.top - tooltip.offsetHeight - 8;
                }
                if (left < 8) left = 8;
                if (left + tooltip.offsetWidth > window.innerWidth - 8) {
                    left = window.innerWidth - tooltip.offsetWidth - 8;
                }
                tooltip.style.top = top + 'px';
                tooltip.style.left = left + 'px';
            });
            cell.addEventListener('mouseleave', function() {
                tooltip.style.display = 'none';
            });
        });
    }
    renderPICTable();

    /* ── OPEN POSITIONS TABLE ── */
    let currentSort = 'usia';
    function renderOpenPosTable() {
        const sorted = [...openPositions].sort(function(a, b) {
            return currentSort === 'usia' ? b.usia - a.usia : a.posisi.localeCompare(b.posisi);
        });
        let html = '';
        sorted.forEach(function(p) {
            html += '<tr>'
                + '<td style="font-weight:600;">' + p.no_fpk + '</td>'
                + '<td style="text-align:center;">' + p.target + '</td>'
                + '<td style="font-weight:600;">' + p.posisi + '</td>'
                + '<td>' + getUnitBadge(p.unit) + '</td>'
                + '<td style="color:var(--rc-text-sec);">' + p.pic + '</td>'
                + '<td style="color:var(--rc-text-sec);">' + p.creator + '</td>'
                + '<td><span style="font-size:14px;font-weight:900;color:' + getAgeColor(p.usia) + ';">' + p.usia + '</span> <span style="font-size:10px;color:var(--rc-text-muted);">hari</span></td>'
                + '<td style="color:var(--rc-text-muted);font-size:11px;">Gap: ' + p.gap + ' posisi</td>'
                + '<td>' + getStatusPill(p.status) + '</td>'
                + '</tr>';
        });
        document.getElementById('openPosTableBody').innerHTML = html;
    }
    renderOpenPosTable();

    window.sortOpenPos = function(by) {
        currentSort = by;
        renderOpenPosTable();
        document.querySelectorAll('.rc-sort-btn').forEach(function(btn) {
            btn.classList.toggle('active', btn.textContent.includes(by === 'usia' ? 'Usia' : 'Nama'));
        });
    };

    /* ── CHART: Unit Bisnis (Overview) ── */
    new Chart(document.getElementById('chartUnitBisnis'), {
        type: 'bar',
        data: {
            labels: unitsData.map(function(u){ return u.unit; }),
            datasets: [
                {
                    label: 'Kebutuhan',
                    data: unitsData.map(function(u){ return u.kebutuhan; }),
                    backgroundColor: 'rgba(37, 99, 235, 0.2)',
                    borderColor: '#2563eb',
                    borderWidth: 1,
                    borderRadius: 4,
                    barPercentage: 0.6,
                    categoryPercentage: 0.7
                },
                {
                    label: 'Pemenuhan',
                    data: unitsData.map(function(u){ return u.pemenuhan; }),
                    backgroundColor: '#2563eb',
                    borderColor: '#1d4ed8',
                    borderWidth: 1,
                    borderRadius: 4,
                    barPercentage: 0.6,
                    categoryPercentage: 0.7
                },
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 11 }, color: '#64748b', usePointStyle: true, pointStyle: 'rectRounded', padding: 16 } },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#1e293b',
                    bodyColor: '#64748b',
                    borderColor: '#e2e8f0',
                    borderWidth: 1,
                    cornerRadius: 8,
                    padding: 10,
                    callbacks: {
                        afterBody: function(context) {
                            var idx = context[0].dataIndex;
                            var keb = unitsData[idx].kebutuhan;
                            var pem = unitsData[idx].pemenuhan;
                            return 'Pemenuhan: ' + (keb > 0 ? (pem/keb*100).toFixed(2) : '0.00') + '%';
                        }
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 12, weight: '600' } } },
                y: { beginAtZero: true, grid: { color: '#f1f5f9', drawBorder: false }, ticks: { color: '#94a3b8', font: { size: 11 } } }
            }
        }
    });

    /* ── CHART: PIC Performance ── */
    new Chart(document.getElementById('chartPIC'), {
        type: 'bar',
        data: {
            labels: picData.map(function(p){ return p.pic; }),
            datasets: [{
                label: 'Pemenuhan %',
                data: picData.map(function(p){ return p.pct; }),
                backgroundColor: picData.map(function(p){
                    return p.pct >= 80 ? 'rgba(5, 150, 105, 0.8)' : p.pct >= 50 ? 'rgba(217, 119, 6, 0.8)' : 'rgba(220, 38, 38, 0.8)';
                }),
                borderColor: picData.map(function(p){
                    return p.pct >= 80 ? '#059669' : p.pct >= 50 ? '#d97706' : '#dc2626';
                }),
                borderWidth: 1,
                borderRadius: 6,
                barPercentage: 0.7,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#1e293b',
                    bodyColor: '#64748b',
                    borderColor: '#e2e8f0',
                    borderWidth: 1,
                    cornerRadius: 8,
                    padding: 10,
                    callbacks: {
                        label: function(ctx) {
                            var p = picData[ctx.dataIndex];
                            return p.pic + ': ' + p.pct + '% (' + p.pemenuhan + '/' + p.kebutuhan + ')';
                        }
                    }
                }
            },
            scales: {
                x: { max: 110, beginAtZero: true, grid: { color: '#f1f5f9', drawBorder: false }, ticks: { color: '#94a3b8', font: { size: 11 }, callback: function(v){ return v + '%'; } } },
                y: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 12, weight: '600' } } }
            }
        }
    });

    /* ── CHART: PIC Pie ── */
    new Chart(document.getElementById('chartPIEpic'), {
        type: 'doughnut',
        data: {
            labels: ['On Track (≥80%)', 'Perlu Perhatian (50–79%)', 'Kritis (<50%)'],
            datasets: [{
                data: [<?= $pic_on_track ?>, <?= $pic_perhatian ?>, <?= $pic_kritis ?>],
                backgroundColor: ['rgba(5, 150, 105, 0.85)', 'rgba(217, 119, 6, 0.85)', 'rgba(220, 38, 38, 0.85)'],
                borderWidth: 3,
                borderColor: '#ffffff',
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#1e293b',
                    bodyColor: '#64748b',
                    borderColor: '#e2e8f0',
                    borderWidth: 1,
                    cornerRadius: 8,
                    padding: 10,
                    callbacks: {
                        label: function(ctx) {
                            return ctx.label + ': ' + ctx.raw + ' PIC';
                        }
                    }
                }
            }
        }
    });

    /* ── Header Pct Color ── */
    const headerPct = document.getElementById('headerPctTotal');
    if (headerPct) {
        var pctVal = <?= $grand_frck_pct ?>;
        headerPct.style.color = pctVal >= 80 ? '#059669' : pctVal >= 50 ? '#d97706' : '#dc2626';
    }

});
</script>
