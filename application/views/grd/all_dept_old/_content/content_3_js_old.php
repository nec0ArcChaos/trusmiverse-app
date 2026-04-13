<script>
    $(document).ready(function() {
        $(".monthpicker").datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months",
            autoclose: true
        });

        $('#select_divisi, #select_month').change(function(e) {
            e.preventDefault();
            reload_data();
        });

        get_resume_head(36,2025);
        get_all_list_grd('Operasional','02-2025');
    });

    function reload_data() {
        var divisi = $('#select_divisi').val();
        var month = $('#select_month').val();

        get_all_list_grd(divisi, month);

        $.ajax({
            url: base_url + 'reload',
            type: "POST",
            data: { divisi: divisi, month: month },
            dataType: "json",
            success: function(response) {
                if (response.goals) {
                    updateProgressBar(response.goals);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });
    }

    function updateProgressBar(goals) {
        var progressBarContainer = $("#progressBarContainer"); // Target the progress container
        progressBarContainer.html(''); // Clear old content

        let index = 1;
        let totalNotStarted = 0;

        let progressBarHTML = `<div class="progress" style="height: 35px; width: 100%;">`;

        // Loop through each goal and create a progress bar
        goals.forEach(function(goal) {
            progressBarHTML += `
                <div class="progress-bar bg-blue_${index}" 
                    style="width:${goal.done_prs}%;" 
                    role="progressbar">
                    <span style="font-size: 12px; font-weight: bold;" class="text-white">
                        ${goal.nama_goal} (${goal.done_prs}%)
                    </span>
                </div>
            `;
            totalNotStarted += parseFloat(goal.not_started_prs); // Accumulate "Not Started" percentage
            index++;
        });

        // Add the "Not Started" progress bar if there is remaining percentage
        if (totalNotStarted > 0) {
            progressBarHTML += `
                <div class="progress-bar" 
                    style="width:${totalNotStarted}%; background-color: #D4D4D8;" 
                    role="progressbar">
                    <span style="font-size: 12px; font-weight: bold;" class="text-grey">
                        Not Started (${totalNotStarted}%)
                    </span>
                </div>
            `;
        }

        progressBarHTML += `</div>`; // Close the progress div
        progressBarContainer.html(progressBarHTML); // Update the container with new content
    }
</script>

<!-- CUSTOM PANE -->
<script>
    // Define active colors for each section
    const sectionColors = {
        progress_list: '#081226',
        progress_kanban: '#081226',
        progress_calendar: '#081226'
    };

    // Handle progress-tab click events
    $('.progress-tab').on('click', function () {
        $('.progress-tab').css('background-color', '#ffffff').removeClass('selected');
        $(this).css('background-color', sectionColors[this.id]).addClass('selected');
        const target = $(this).data('target');
        $('.custom-pane').hide(); // Hide all tab content
        $(target).show(); // Show the selected tab content
    });

    // Set initial state (optional, to ensure correct initial visibility)
    $('.custom-pane').hide(); // Hide all tab content
    $('#section_list').show(); // Show the first section by default
</script>


<!-- PELANGGARAN MANPOWER -->
<script>
    function get_resume_head(project,year) {
        $('#table_resume_head').DataTable({
            "pageLength": 5,
            "lengthChange": false,
            "searching": false,
            "info": false,
            "paging": true,
            "autoWidth": false,
            "ordering": false,
            "destroy": true,
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                'dataSrc': '',
                "data": {
                    project: project,
                    year: year,
                    
                },
                "url": 'https://trusmiverse.com/apps/timeline_project/get_resume_head',
            },
            "columns": [
                // {
                //     "data": "employee_name",
                //     "render": function(data, type, row, meta) {
                //         return meta.row + 1;
                //     },
                //     "className": "text-center small"
                // },
                {
                    "data": "employee_name",
                    "render": function(data, type, row, meta) {
                        if (row['achieve_status'] == 'Sloth') {
                            achieve_status = `<span class = "badge bg-light-red text-danger">Sloth</span>`;
                            emoji = `🦥`;
                        } else if (row['achieve_status'] == 'Horse') {
                            achieve_status = `<span class = "badge bg-light-yellow text-warning">Horse</span>`
                            emoji = `🐎`;
                        } else if (row['achieve_status'] == 'Cheetah') {
                            achieve_status = `<span class = "badge bg-light-green text-success">Cheetah</span>`
                            emoji = `🐅`;
                        } else {
                            achieve_status = `<span class = "badge bg-light-blue text-primary">Falcon</span>`
                            emoji = `🦅`;
                        }
                        let content = `
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-30 coverimg rounded-circle d-flex justify-content-center align-items-center" 
                                    data-division="${row['achieve_label']}" 
                                    style="background-color: ${row['achieve_color']}; color: white;">
                                    ${emoji}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">${data}</div>
                                    <div><span class="text-muted">${row['department_name']}</span></div>
                                </div>
                            </div>
                        `;
                        return content;
                    },
                    "className": "small",
                    'width': '50%'
                },
                {
                    "data": "achieve",
                    "render": function(data, type, row, meta) {
                        return `${data}%`;
                    },
                    "className": "text-center small"
                },
                {
                    "data": "mom",
                    "render": function(data, type, row, meta) {
                        return `<span class="badge ${row['warna_mom']}">${data}</span>`;
                    },
                    "className": "text-center small"
                }, {
                    "data": "comp",
                    "render": function(data, type, row, meta) {
                        return `<span class="badge ${row['warna_comp']}">${data}</span>`;
                    },
                    "className": "text-center small"
                }, {
                    "data": "gen",
                    "render": function(data, type, row, meta) {
                        return `<span class="badge ${row['warna_gen']}">${data}</span>`;
                    },
                    "className": "text-center small"
                }, {
                    "data": "coac",
                    "render": function(data, type, row, meta) {
                        return `<span class="badge ${row['warna_coac']}">${data}</span>`;
                    },
                    "className": "text-center small"
                }, {
                    "data": "ibr",
                    "render": function(data, type, row, meta) {
                        return `<span class="badge ${row['warna_ibr']}">${data}</span>`;
                    },
                    "className": "text-center small"
                },
            ]
        });
    }

</script>

<!-- GET LIST GRD -->
<script>
    function get_all_list_grd(divisi, month) {
        $.ajax({
            url: base_url + 'data_grd',
            method: 'POST',
            data: {
                divisi: divisi,
                month: month
            },
            dataType: 'json',
            success: function(response) {

                $('#list_grd').empty();
                response.forEach((dt_goal,goalindex)=>{
                    let grdContent = '';
                    dt_goal.sos.forEach((so, index) => {
    
                        let tableContent = `
                        <table class="table table-hover" style="white-space:nowrap;">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Strategi</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">PIC</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Actual</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Target</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Start</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">End</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Done at</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Leadtime</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Status</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Evidence</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">TeamTalk</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Meeting</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Complain</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Genba</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Co & Co</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">IBR Pro</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Training</th>
                                    
                            </thead>
                            <tbody>`;
                
                                    so.data_si.forEach((subtask, index) => {
                                        tableContent += `
                            <tr class="bg-light-yellow">
                                <td class="fw-bold"><i class="bi bi-circle-fill"></i> SI ${index +1}. ${subtask.si}</td>
                                <td class="fw-bold"></td>
                                <td class="fw-bold"></td>
                                <td class="fw-bold"></td>
                                <td class="fw-bold">${subtask.start}</td>
                                <td class="fw-bold">${subtask.end}</td>
                                <td class="fw-bold"></td>
                                <td class="fw-bold"></td>
                                <td class="fw-bold"></td>
                                <td class="fw-bold"></td>
                                <td class="text-center">
                                    <span class="badge bg-${subtask.warna_teamtalk}">${subtask.teamtalk}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-${subtask.warna_meeting}">${subtask.meeting}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-${subtask.warna_complain}">${subtask.complain}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-${subtask.warna_genba}">${subtask.genba}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-${subtask.warna_conco}">${subtask.conco}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-${subtask.warna_ibr}">${subtask.ibr}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">${subtask.training}</span>
                                </td>`;
                                
                                        tableContent += `</tr>`;
                
                                        // Menambahkan detail subtask jika ada
                                        subtask.tasklist.forEach(detail => {
                                            tableContent += `
                                <tr>
                                    <td><div class="d-flex justify-content-between"><small>&emsp;<i class="bi bi-dash"></i> ${detail.detail}</small> <span class="badge bg-light-blue text-right" style='cursor:pointer' onclick="detail_tasklist('${detail.id_tasklist}','${detail.id_si}','${detail.id_so}','${detail.divisi}')"><i class="bi bi-newspaper fs-6"></i></span></div></td>
                                    <td><small>${detail.pic}</small></td>
                                    <td><small>${detail.actual}</small></td>
                                    <td><small>${detail.target}</small></td>
                                    <td><small>${detail.start}</small></td>
                                    <td><small>${detail.end}</td>
                                    <td><small>${detail.done_at}</small></td>
                                    <td><small>${detail.leadtime}</small></td>
                                    <td>
                                        <span class="badge ${detail.warna}" onclick="detail_tasklist('${detail.id_tasklist}','${detail.id_si}','${detail.id_so}','${detail.divisi}')" style='cursor:pointer'>${detail.nama_status}</span>
                                    </td>
                                    <td class="text-center"><span class="badge bg-light-blue text-black" style='cursor:pointer'><a href="<?= base_url(''); ?>/uploads/grd/evidence/${detail.evidence}" target="_blank">
                                            <i class="bi bi-file-earmark"></i>${detail.evidence}
                                        </a></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-${detail.warna_teamtalk}">${detail.teamtalk}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-${detail.warna_meeting}">${detail.meeting}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-${detail.warna_complain}">${detail.complain}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-${detail.warna_genba}">${detail.genba}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-${detail.warna_conco}">${detail.conco}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-${detail.warna_ibr}">${detail.ibr}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-${detail.warna_training}">${detail.training}</span>
                                    </td>`;

                                            tableContent += `</tr>`;
                                        });
                                    });
                
                                    tableContent += `
                            </tbody>
                        </table>`;
                
                            // Membuat card dengan tabel
                            grdContent += `
                                <div class="card bg-light mb-3 rounded">
                                    <div class="card-header p-0 mb-3">
                                        <div class="progress-bar bg-${so.warna} rounded-top" style="width: ${so.progress_so}%; height: 5pt; position: absolute; top: 0; left: 0;"></div>
                                            
                                    </div>
                                    <div class="card-body" style="margin-top: -10px;">
                                    
                                        <div id="accordion-${so.id_so}" class="mb-2">
                                            <div class="row" id="heading-${so.id_so}">
                                                <div class="col-auto">
                                                    <button class="btn btn-outline-primary btn-sm" data-toggle="collapse" data-target="#collapse-${so.id_so}" aria-expanded="true" aria-controls="collapse-${so.id_so}">
                                                        <i class="bi bi-chevron-down"></i>
                                                    </button>
                                                </div>
                                                <div class="col">
                                                <p style="font-size: 14px; font-weight: bold;">
                                                    
                                                    SO ${index + 1}. ${so.so} <br>
                                                    <span class="text-grey small fw-bold mt-0 ml-4"><i class="bi bi-stopwatch"></i> ${so.start} <i class="bi bi-arrow-right-short"></i> ${so.end}</span>
                                                </p>
                                            
                                                </div>
                                                <div class="col" align="right">
                                                    <span class="badge fs-6 bg-${so.warna}">${so.progress_so}% </span>
                                                </div>
                                                </div>
                                                <div class="row">
                                                <div class="col">
                                                    <div id="collapse-${so.id_so}" class="collapse ${index === 0 ? 'show' : ''}" aria-labelledby="heading-${so.id_so}" data-parent="#accordion-${so.id_so}">
                                                    <div class="table-responsive">
                                                        ${tableContent}
                                                    </div>
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                            });
                                const goalscard = `
   
                        <div class="card mt-3" style="border-radius: 25px; margin-right: -10px;">
                            <div class="card-header bg-super-soft-grey d-flex flex-column text-start" style="border-radius: 25px 25px 0 0;">
                                <div class="row">
                                    <div class="col-4">
                                        <h6 class="mt-3 fw-bold"><i class="bi bi-substack"></i>Goals  ${goalindex +1}</h6>
                                        <h6 class="fw-bold"><i class="bi bi-substack"></i> ${dt_goal.nama_goal}</h6>
                                        
                                        <div class="row">
                                            <div class="col">
                                                <div class="progress position-relative" style="height: 30px; width: 100%;">
                                                    <span class="position-absolute w-100 text-start fs-6 mt-1 ms-2 text-white"> ${dt_goal.actual_goal} / ${dt_goal.target_goal}</span>
                                                    <div class="progress-bar bg-blue_${goalindex +1}" style="width:${dt_goal.actual_goal}%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                    <div class="progress-bar bg-soft-grey" style="width:0%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
        
                                            </div>
                                            <div class="col-auto d-flex align-items-center">
                                                <h6 class="fw-bold">${dt_goal.progress_goal}%</h6>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-8" style="text-align: right;">
                                        <div class="row mt-3 me-3" style="display: flex; justify-content: flex-end;">
                                            <div class="col-auto" style="text-align: center;">
                                                <h6 class="fw-bold">SO</h6>
                                                <div class="" id="div_so_pie_${goalindex}" style="width: 65px;"></div>
                                            </div>

                                            <div class="col-auto" style="text-align: center;">
                                                <h6 class="fw-bold">SI</h6>
                                                <div class="" id="div_si_pie_${goalindex}" style="width: 65px;"></div>
                                            </div>

                                            <div class="col-auto" style="text-align: center;">
                                                <h6 class="fw-bold">Tasklist</h6>
                                                <div class="" id="div_tasklist_pie_${goalindex}" style="width: 65px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body bg-super-soft-grey" style="border-radius: 0 0 25px 25px;">
                            
                                ${grdContent}
                                
                            
                            </div>
                        </div>

                    `;

                    // Append ke container
                    $('#list_grd').append(goalscard);

                    console.log(dt_goal);

                    so_pie(dt_goal, `div_so_pie_${goalindex}`);
                    si_pie(dt_goal, `div_si_pie_${goalindex}`);
                    tasklist_pie(dt_goal, `div_tasklist_pie_${goalindex}`);
                });

            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    function so_pie(so, elementId) {
        $(`#${elementId}`).empty().append(`
            <canvas id="so_pie_${elementId}" style="width: 60px;"></canvas>`);
        const ctx = document.getElementById(`so_pie_${elementId}`);

        const doughnutPointer = {
            id: 'doughnutPointer',
            afterDatasetsDraw(chart, args, plugins) {
                const {
                    ctx,
                    data
                } = chart;

                ctx.save();

                const xCenter = chart.getDatasetMeta(0).data[0].x;
                const yCenter = chart.getDatasetMeta(0).data[0].y;
                const innerRadius = chart.getDatasetMeta(0).data[0].innerRadius;
                const outerRadius = chart.getDatasetMeta(0).data[0].outerRadius;
                const doughnutThickness = outerRadius - innerRadius;
                const angle = Math.PI / 180;

                // achieve
                ctx.font = 'bold 20px sans-serif';
                ctx.fillStyle = '#353535';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(so.progress_so + '%', xCenter, yCenter);

                // ctx.font = 'bold 12px sans-serif';
                // ctx.fillText('Total', xCenter, yCenter + 10);

            }
        }

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Done',
                    'Not Start'
                ],
                datasets: [{
                        data: [
                            so.progress_so,
                            100-so.progress_so,
                        ],
                        borderColor: [getProgressColor(so.progress_so),'#F3F2F2'],
                        backgroundColor: [getProgressColor(so.progress_so),'#F3F2F2'],
                        cutout: '80%',
                    },

                ],
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                        position: 'bottom',
                    },
                    title: {
                        display: false,
                        text: ''
                    },
                    doughnutPointer: {
                        pointerColorText: 'white',
                        pointerRadius: 5
                    },
                    datalabels: {
                        color: 'white',
                        formatter: (value, ctx) => {
                            // return value + '%';
                            return value;
                        }
                    }
                },
            },
            // plugins: [doughnutPointer, ChartDataLabels]
            plugins: [doughnutPointer]
        });
    }

    function si_pie(si, elementId) {
        $(`#${elementId}`).empty().append(`
            <canvas id="si_pie_${elementId}" style="width: 60px;"></canvas>`);
        const ctx = document.getElementById(`si_pie_${elementId}`);

        const doughnutPointer = {
            id: 'doughnutPointer',
            afterDatasetsDraw(chart, args, plugins) {
                const {
                    ctx,
                    data
                } = chart;

                ctx.save();

                const xCenter = chart.getDatasetMeta(0).data[0].x;
                const yCenter = chart.getDatasetMeta(0).data[0].y;
                const innerRadius = chart.getDatasetMeta(0).data[0].innerRadius;
                const outerRadius = chart.getDatasetMeta(0).data[0].outerRadius;
                const doughnutThickness = outerRadius - innerRadius;
                const angle = Math.PI / 180;

                // achieve
                ctx.font = 'bold 20px sans-serif';
                ctx.fillStyle = '#353535';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(si.progress_si + '%', xCenter, yCenter);

                // ctx.font = 'bold 12px sans-serif';
                // ctx.fillText('Total', xCenter, yCenter + 10);

            }
        }

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Done',
                    'Not Start'
                ],
                datasets: [{
                        data: [
                            si.progress_si,
                            100-si.progress_si,
                        ],
                        borderColor: [getProgressColor(si.progress_si),'#F3F2F2'],
                        backgroundColor: [getProgressColor(si.progress_si),'#F3F2F2'],
                        cutout: '80%',
                    },

                ],
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                        position: 'bottom',
                    },
                    title: {
                        display: false,
                        text: ''
                    },
                    doughnutPointer: {
                        pointerColorText: 'white',
                        pointerRadius: 5
                    },
                    datalabels: {
                        color: 'white',
                        formatter: (value, ctx) => {
                            // return value + '%';
                            return value;
                        }
                    }
                },
            },
            // plugins: [doughnutPointer, ChartDataLabels]
            plugins: [doughnutPointer]
        });
    }

    function tasklist_pie(tasklist, elementId) {
        $(`#${elementId}`).empty().append(`
            <canvas id="tasklist_pie_${elementId}" style="width: 60px;"></canvas>`);
        const ctx = document.getElementById(`tasklist_pie_${elementId}`);

        const doughnutPointer = {
            id: 'doughnutPointer',
            afterDatasetsDraw(chart, args, plugins) {
                const {
                    ctx,
                    data
                } = chart;

                ctx.save();

                const xCenter = chart.getDatasetMeta(0).data[0].x;
                const yCenter = chart.getDatasetMeta(0).data[0].y;
                const innerRadius = chart.getDatasetMeta(0).data[0].innerRadius;
                const outerRadius = chart.getDatasetMeta(0).data[0].outerRadius;
                const doughnutThickness = outerRadius - innerRadius;
                const angle = Math.PI / 180;

                // achieve
                ctx.font = 'bold 20px sans-serif';
                ctx.fillStyle = '#353535';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(tasklist.progress_tasklist + '%', xCenter, yCenter);

                // ctx.font = 'bold 12px sans-serif';
                // ctx.fillText('Total', xCenter, yCenter + 10);

            }
        }

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Done',
                    'Not Start'
                ],
                datasets: [{
                        data: [
                            tasklist.progress_tasklist,
                            100-tasklist.progress_tasklist,
                        ],
                        borderColor: [getProgressColor(tasklist.progress_tasklist),'#F3F2F2'],
                        backgroundColor: [getProgressColor(tasklist.progress_tasklist),'#F3F2F2'],
                        cutout: '80%',
                    },

                ],
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                        position: 'bottom',
                    },
                    title: {
                        display: false,
                        text: ''
                    },
                    doughnutPointer: {
                        pointerColorText: 'white',
                        pointerRadius: 5
                    },
                    datalabels: {
                        color: 'white',
                        formatter: (value, ctx) => {
                            // return value + '%';
                            return value;
                        }
                    }
                },
            },
            // plugins: [doughnutPointer, ChartDataLabels]
            plugins: [doughnutPointer]
        });
    }

    function getProgressColor(progress) {
        if (progress < 60) return '#FD97A4'; // Red
        if (progress >= 60 && progress <= 74) return '#FFEC8F'; // Yellow
        return '#C9EE8F'; // Green
    }

    function detail_tasklist(id_tasklist, id_si, id_so, divisi) {
        activateTab('update');
        var loadingDialog = $.confirm({
            icon: 'fa fa-spinner fa-spin',
            title: 'Loading',
            theme: 'material',
            type: 'blue',
            content: 'Please wait, processing...',
            buttons: false, // Disable buttons
            closeIcon: false, // Disable close icon
        });
        var month = $('#select_month').val();


        $.ajax({
            type: "POST",
            url: base_url + 'get_detail_task',
            data: {
                id_tasklist: id_tasklist,
                id_si: id_si,
                id_so: id_so,
                divisi: divisi,
                month: month,
            },
            dataType: "json",
            success: function(response) {
                updateTextWithPrefix("t_nama_goal", "Goals: ", response.header.nama_goal);
                updateTextWithPrefix("t_so", "SO: ", response.header.so);
                updateTextWithPrefix("t_si", "SI: ", response.header.si);
                $('#t_status').text(response.header.nama_status);
                $('#t_status').removeClass().addClass(`badge fs-6 ${response.header.warna}`);
                $('#t_target').text(response.header.target);
                $('#t_detail').text(response.header.detail);
                $('#t_pic').text(response.header.pic);
                $('#t_output').text(response.header.output);
                $('#t_start').text(response.header.start);
                $('#t_deadline').text(response.header.end);
                $('#t_company').text(`${response.header.company_name}`);
                $('#status').val(response.header.status);
                $('#status_before').val(response.header.status);
                $('#actual').val(response.header.actual);
                $('#t_divisi').text(response.header.divisi);
                $('#note').val('');
                $('#evidence').val('');
                // datatable_mom(response.mom);
                // datatable_ibr(response.ibr);
                // datatable_gen(response.genba);
                // datatable_conco(response.conco);
                // datatable_comp(response.complaint);
                // datatable_teamtalk(response.teamtalk);
                loadingDialog.close();
                $('#modal_detail_tasklist').appendTo('body').modal('show');
                $('#modal_detail_tasklist').find('[name="id_tasklist"]').val(id_tasklist);
                load_all_tab();
            }
        });
    }

    $('#form_update').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var divisi = $('#select_divisi').val();
        var month = $('#select_month').val();
        $.confirm({
            icon: 'fa fa-check',
            title: 'Warning',
            theme: 'material',
            type: 'blue',
            content: 'Apakah anda yakin?',
            buttons: {
                confirm: function() {
                    var loadingDialog = $.confirm({
                        icon: 'fa fa-spinner fa-spin',
                        title: 'Loading',
                        theme: 'material',
                        type: 'blue',
                        content: 'Please wait, processing...',
                        buttons: false, // Disable buttons
                        closeIcon: false, // Disable close icon
                    });
                    var formData = new FormData(form[0]);
                    $.ajax({
                        type: "POST",
                        url: base_url + `/update_task`,
                        data: formData,
                        processData: false, // Jangan proses data, karena kita mengirim FormData
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            loadingDialog.close();
                            $('#modal_detail_tasklist').modal('hide');
                            $.confirm({
                                icon: 'fa fa-check',
                                title: 'Success',
                                theme: 'material',
                                type: 'green',
                                content: 'Data has been saved!',
                                buttons: {
                                    close: {
                                        actions: function() {}
                                    },
                                },
                            });
                            reload_data();
                        }
                    });
                },
                close: {
                    actions: function() {
                        // $('#modal_input').modal('hide');
                        // $("#dt-pk").DataTable().ajax.reload();
                        jconfirm.instances[0].close();
                    }
                },
            },

        });
    });

    function activateTab(tabId) {
        if (tabId == 'activity') {
            load_all_tab();
        }

        // Menghapus class 'active' dari semua tab dan konten
        $(".nav-link").removeClass("active");
        $(".tab-pane").removeClass("show active");

        // Menambahkan class 'active' ke tab yang dipilih
        $("#nav_" + tabId).addClass("active");

        // Menampilkan konten yang sesuai
        $("#tab_" + tabId).addClass("show active");

    }

    function load_all_tab() {
        var id_tasklist = $('#form_update').find('[name="id_tasklist"]').val();

        $.ajax({
            type: "POST",
            url: base_url + "/load_all_tab",
            data: {
                'id_tasklist': id_tasklist
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                var history = ``;
                var file = ``;
                response.history.forEach((value) => {
                    if (value.status == value.status_before) {

                        history += `
                                    <tr class="mb-2">
                                        <td class="small text-secondary">${value.created_at}</td>
                                        <td class="small">${value.progress}%</td>
                                        <td class="small"><i class="bi bi-chat-quote text-primary"></i>Note</td>
                                        <td class="small">${value.note}</td>
                                    </tr>
                                    `;
                    } else {

                        history += `<tr class="mb-2">
                                        <td class="small text-secondary">${value.created_at}</td>
                                        <td class="small">${value.progress}%</td>
                                        <td class="small"><i class="bi bi-bookmark text-primary"></i>Status</td>
                                        <td class="small"><span class="badge ${value.st_before_warna}">${value.st_before}</span> > <span class="badge ${value.st_warna}">${value.st}</span></td>
                                    </tr>
                                    <tr class="mb-2">
                                        <td class="small text-secondary">${value.created_at}</td>
                                        <td class="small">${value.progress}%</td>
                                        <td class="small"><i class="bi bi-chat-quote text-primary"></i>Note</td>
                                        <td class="small">${value.note}</td>
                                    </tr>
                                    `;
                    }
                });
                $('#tabel_activity').empty().append(history);
                if (response.file.length == 0) {
                    $('#tabel_files').empty();
                } else {
                    response.file.forEach((value) => {
                        file += `<div class="card border-0 overflow-hidden">
                                    <div class="h-130 bg-red text-white d-flex align-items-center">
                                        <h1 class="col-12 text-center"><i class="bi bi-file-earmark-pdf"></i> PDF</h1>
                                    </div>
                                    <div class="card-footer bg-none">
                                        <div class="row gx-3 align-items-center">
                                            <div class="col-12">
                                                <a href="<?= base_url(''); ?>/uploads/grd/evidence/${value.evidence}" target="_blank" class="avatar avatar-30 rounded text-red mr-3 w-100">
                                                    <i class="bi bi-download h5 vm"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                    });
                    $('#tabel_files').empty().append(file);
                }
            }
        });
    }

    function change_deadline(nama_goal, id_tasklist, divisi, so, si, detail, start, end){
        var modal = $('#modal_change');
        $(modal).modal('show').appendTo('body');
        $(modal).find('[name="id_tasklist"]').val(id_tasklist);
        $(modal).find('[name="divisi"]').val(divisi);
        $(modal).find('[name="nama_goal"]').val(nama_goal);
        $(modal).find('[name="so"]').val(so);
        $(modal).find('[name="si"]').val(si);
        $(modal).find('[name="detail"]').val(detail);
        // $(modal).find('[name="start"]').val(start);
        // $(modal).find('[name="end"]').val(end);
        $(modal).find('[name="start"]').val(formatDateSlash(start));
        $(modal).find('[name="end"]').val(formatDateSlash(end));

        console.log(formatDateSlash(start));
    }

    function updateTextWithPrefix(id, prefix, newText) {
        let element = document.getElementById(id);
        if (element) {
            element.innerHTML = prefix + newText;
        }
    }

    function formatDateSlash(dateTimeString) {
        if (!dateTimeString) return ""; 

        // Pisahkan tanggal dan waktu
        let [datePart, timePart] = dateTimeString.split(" ");

        let dateParts = datePart.split("-"); 
        return `${dateParts[0]}/${dateParts[1]}/${dateParts[2]}`; 
    }
</script>