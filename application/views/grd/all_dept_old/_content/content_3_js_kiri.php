<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
    $(document).ready(function() {

        //Start Daterangepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DDDD') + ' - ' + end.format('YY-MM-DDDD'));
            $('#startCalendar').val(start.format('YYYY-MM-DD'));
            $('#endCalendar').val(end.format('YYYY-MM-DD'));
            reload_data();

            var divisi = $('#select_divisi').val();
            get_data_poin_check_bt(divisi, start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            get_data_prs_bt(divisi, start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            // Kondisikan hanya untuk Batik Group
            data_support(divisi, start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            if (<?= $id_company ?> == 5) {
                get_data_warning_manpower(divisi, start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            }


            // console.log('Daterange : ',start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            // console.log('Start : ', $('#startCalendar').val(), 'End : ', $('#endCalendar').val());
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
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);
        // End Daterangepicker

        // $(".monthpicker").datepicker({
        //     format: "dd-mm-yyyy",
        //     viewMode: "months",
        //     minViewMode: "months",
        //     autoclose: true
        // });

        $('#select_divisi').change(function(e) {
            e.preventDefault();
            reload_data();
        });

        // get_all_list_grd('Operasional', '02-2025');

    });

    function reload_data() {
        var divisi = $('#select_divisi').val();
        // var month = $('#select_month').val();

        var start = $('#startCalendar').val();
        var end = $('#endCalendar').val();

        get_all_list_grd(divisi, start, end);

        $.ajax({
            url: base_url + 'reload',
            type: "POST",
            data: {
                divisi: divisi,
                start: start,
                end: end
            },
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
    $('.progress-tab').on('click', function() {
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

<!-- GET LIST GRD -->
<script>
    function get_all_list_grd(divisi, start, end) {
        $.ajax({
            url: base_url + 'data_grd',
            method: 'POST',
            data: {
                divisi: divisi,
                start: start,
                end: end
            },
            dataType: 'json',
            beforeSend: function(response){
                $('#list_grd').empty().append(`
                    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `);
            },
            success: function(response) {
                console.log(response);

                $('#list_grd').empty();
                response.forEach((dt_goal, goalindex) => {
                    let grdContent = '';
                    dt_goal.sos.forEach((so, index) => {

                        let tableContent = `
                        <table class="table table-hover" style="white-space:nowrap;">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Strategi</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">PIC</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Jenis</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Status</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Status</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Target</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Actual</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Ach(%)</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Start</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">End</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Done at</th>
                                    <th rowspan="2" style="vertical-align : middle;" class="small">Leadtime</th>
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
                                <td class="fw-bold">${Number(subtask.target).toLocaleString()}</td>
                                
                                <td class="fw-bold"><span class="badge bg-success" onclick="detail_si('${subtask.id_si}','${subtask.id_so}')" style='cursor:pointer'>${Number(subtask.actual).toLocaleString()}</span></td>
                                <td class="fw-bold">${subtask.progress_si_satuan}%</td>
                                <td class="fw-bold"></td>
                                <td class="fw-bold"></td>
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
                                    <td><small>${detail.jenis_tasklist}</small></td>
                                    <td>
                                        <span class="badge ${detail.warna}" onclick="detail_tasklist('${detail.id_tasklist}','${detail.id_si}','${detail.id_so}','${detail.divisi}')" style='cursor:pointer'>${detail.nama_status}</span>
                                    </td>
                                    <td>
                                        <span class="badge ${detail.status_leadtime == 'Late' ? 'bg-danger' : 'bg-success'}">${detail.status_leadtime}</span>
                                    </td>
                                    <td><small>${detail.target}</small></td>
                                    <td><small>${detail.actual}</small></td>
                                    <td><small>${detail.progress_tasklist}%</small></td>
                                    <td><small>${detail.start.substring(0, 10)}</small></td>
                                    <td><small>${detail.end.substring(0, 10)}</td>
                                    <td><small>${detail.done_at}</small></td>
                                    <td><small>${detail.leadtime}</small></td>
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
                                                <div class="col">
                                                <p style="font-size: 14px; font-weight: bold;">
                                                    
                                                    Target ${Number(so.target).toLocaleString()} <br>
                                                    <span class="text-grey small fw-bold mt-0 ml-4">Actual <span class="badge bg-success" onclick="detail_so('${so.id_so}')" style='cursor:pointer'>${Number(so.actual).toLocaleString()}</span></span>
                                                </p>
                                            
                                                </div>
                                                <div class="col">
                                                <p style="font-size: 14px; font-weight: bold;">
                                                    
                                                    Progress ${so.progress_so_satuan} %<br>
                                                    <span class="text-grey small fw-bold mt-0 ml-4"></span>
                                                </p>
                                            
                                                </div>
                                                <div class="col" align="right">
                                                    <span class="badge fs-6 bg-${so.warna}">Overall ${so.progress_so}% </span>
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
                                    <div class="col-md-4 col-sm-12">
                                        <h6 class="mt-3 fw-bold"><i class="bi bi-substack"></i>Goals  ${goalindex +1}</h6>
                                        <h6 class="fw-bold"><i class="bi bi-substack"></i> ${dt_goal.nama_goal}</h6>
                                        
                                        <div class="row">
                                            <div class="col">
                                                <div class="progress position-relative" style="height: 30px; width: 100%;">
                                                    <span class="position-absolute w-100 text-start fs-6 mt-1 ms-2 text-white"> ${dt_goal.nama_goal == 'Revenue' ? formatAngka(dt_goal.actual_goal) : Number(dt_goal.actual_goal).toLocaleString()} / ${dt_goal.nama_goal == 'Revenue' ? formatAngka(dt_goal.target_goal) : Number(dt_goal.target_goal).toLocaleString()}</span>
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
                                    <div class="col-md-8 col-sm-12" style="text-align: right;">
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
                console.log(xhr.responseText);
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
                            100 - so.progress_so,
                        ],
                        borderColor: [getProgressColor(so.progress_so), '#F3F2F2'],
                        backgroundColor: [getProgressColor(so.progress_so), '#F3F2F2'],
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
                            100 - si.progress_si,
                        ],
                        borderColor: [getProgressColor(si.progress_si), '#F3F2F2'],
                        backgroundColor: [getProgressColor(si.progress_si), '#F3F2F2'],
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
                            100 - tasklist.progress_tasklist,
                        ],
                        borderColor: [getProgressColor(tasklist.progress_tasklist), '#F3F2F2'],
                        backgroundColor: [getProgressColor(tasklist.progress_tasklist), '#F3F2F2'],
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
        if (progress < 70) return '#FD97A4'; // Red
        if (progress >= 70 && progress < 85) return '#FFEC8F'; // Yellow
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

        // var month = $('#select_month').val();
        var start = $('#startCalendar').val();
        var end = $('#endCalendar').val();



        $.ajax({
            type: "POST",
            url: base_url + 'get_detail_task',
            data: {
                id_tasklist: id_tasklist,
                id_si: id_si,
                id_so: id_so,
                divisi: divisi,
                start: start,
                end: end
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
                datatable_mom(response.mom);
                datatable_ibr(response.ibr);
                datatable_gen(response.genba);
                datatable_conco(response.conco);
                datatable_comp(response.complaint);
                datatable_teamtalk(response.teamtalk);
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

        var evidence = $('#evidence').val();
        var evidence_link = $('#evidence_link').val();
        if ((evidence == '' || evidence == null) && (evidence_link == '' || evidence_link == null)) {
            $.confirm({
                icon: 'fa fa-exclamation',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Evidence atau Evidence Link wajib diisi salah satu!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
            return false;
        }

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

    // get data all tabs by khael
    function load_data_tabs(type) {
        if (type == 1) {
            var id = $('#form_update_si').find('[name="id_si"]').val();
            var tab_activity = $('#tabel_activity_si')
            var tab_files = $('#tabel_files_si')
        } else {
            var id = $('#form_update_so').find('[name="id_so"]').val();
            var tab_activity = $('#tabel_activity_so')
            var tab_files = $('#tabel_files_so')
        }

        $.ajax({
            type: "POST",
            url: base_url + "/load_data_tabs",
            data: {
                id,
                type
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
                                        <td class="small">${value.progress}</td>
                                        <td class="small"><i class="bi bi-chat-quote text-primary"></i>Note</td>
                                        <td class="small">${value.note}</td>
                                    </tr>
                                    `;
                    } else {

                        history += `<tr class="mb-2">
                                        <td class="small text-secondary">${value.created_at}</td>
                                        <td class="small">${value.progress}</td>
                                        <td class="small"><i class="bi bi-bookmark text-primary"></i>Status</td>
                                        <td class="small"><span class="badge ${value.st_before_warna}">${value.st_before}</span> > <span class="badge ${value.st_warna}">${value.st}</span></td>
                                    </tr>
                                    <tr class="mb-2">
                                        <td class="small text-secondary">${value.created_at}</td>
                                        <td class="small">${value.progress}</td>
                                        <td class="small"><i class="bi bi-chat-quote text-primary"></i>Note</td>
                                        <td class="small">${value.note}</td>
                                    </tr>
                                    `;
                    }
                });
                tab_activity.empty().append(history);
                if (response.file.length == 0) {
                    tab_files.empty();
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
                    tab_files.empty().append(file);
                }
            }
        });
    }

    // details SI by khael
    function detail_si(id_si,id_so) {
        var loadingDialog = $.confirm({
            icon: 'fa fa-spinner fa-spin',
            title: 'Loading',
            theme: 'material',
            type: 'blue',
            content: 'Please wait, processing...',
            buttons: false, // Disable buttons
            closeIcon: false, // Disable close icon
        });
        var divisi = $('#select_divisi').val();
        var start = $('#startCalendar').val();
        var end = $('#endCalendar').val();


        $.ajax({
            type: "POST",
            url: base_url + 'get_detail_si',
            data: {
                id_so: id_so,
                id_si: id_si,
                divisi: divisi,
                start: start,
                end: end
            },
            dataType: "json",
            success: function(response) {
                updateTextWithPrefix("t_nama_si", "NAMA SI: ", response.data.si);
                updateTextWithPrefix("t_so_si", "SO: ", response.data.so);
                updateTextWithPrefix("t_si_si", "SI: ", response.data.si);
                $('#t_status_si').text(response.data.nama_status);
                $('#t_status_si').removeClass().addClass(`badge fs-6 ${response.data.warna}`);
                $('#t_target_si').text(response.data.target);
                $('#t_detail_si').text(response.data.detail);
                $('#t_pic_si').text(response.data.pic);
                $('#t_output_si').text(response.data.output);
                $('#t_start_si').text(response.data.start);
                $('#t_deadline_si').text(response.data.end);
                $('#t_company_si').text(`${response.data.company_name}`);
                $('#t_status_si').val(response.data.status);
                $('#status_si').val(response.data.status);
                $('#status_si_before').val(response.data.status);
                $('#actual_si').val(response.data.actual);
                $('#target_si').val(response.data.target);
                $('#actual_tipe_si').val(response.data.actual_tipe);
                $('#target_tipe_si').val(response.data.target_tipe);
                $('#t_divisi_si').text(response.data.divisi);
                $('#note_si').val('');
                $('#evidence_si').val('');
                $('#evidence_link_si').val('');
                loadingDialog.close();                
                datatable_mom(response.mom,'_si');
                datatable_ibr(response.ibr,'_si');
                datatable_gen(response.genba,'_si');
                datatable_conco(response.conco,'_si');
                datatable_comp(response.complaint,'_si');
                datatable_teamtalk(response.teamtalk,'_si');
                $('#modal_detail_si').appendTo('body').modal('show');
                $('#modal_detail_si').find('[name="id_si"]').val(id_si);
                load_data_tabs(1)
            }
        });
    }

    // update details SI by khael
    $('#form_update_si').submit(function(e) {
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
                        url: base_url + `/update_si`,
                        data: formData,
                        processData: false, // Jangan proses data, karena kita mengirim FormData
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            loadingDialog.close();
                            form[0].reset();
                            $('#modal_detail_si').modal('hide');
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

    // details SO by khael
    function detail_so(id_so) {
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
            url: base_url + 'get_detail_so',
            data: {
                id_so
            },
            dataType: "json",
            success: function(response) {
                updateTextWithPrefix("t_nama_so", "NAMA SO: ", response.data.so);
                updateTextWithPrefix("t_so_so", "SO: ", response.data.so);
                $('#t_status_so').text(response.data.nama_status);
                $('#t_status_so').removeClass().addClass(`badge fs-6 ${response.data.warna}`);
                $('#t_target_so').text(response.data.target);
                $('#t_detail_so').text(response.data.detail);
                $('#t_pic_so').text(response.data.pic);
                $('#t_output_so').text(response.data.output);
                $('#t_start_so').text(response.data.start);
                $('#t_deadline_so').text(response.data.end);
                $('#t_company_so').text(`${response.data.company_name}`);
                $('#t_status_so').val(response.data.status);
                $('#status_so').val(response.data.status);
                $('#status_so_before').val(response.data.status);
                $('#actual_so').val(response.data.actual);
                $('#target_so').val(response.data.target);
                $('#actual_tipe_so').val(response.data.actual_tipe);
                $('#target_tipe_so').val(response.data.target_tipe);
                $('#t_divisi_so').text(response.data.divisi);
                $('#note_so').val('');
                $('#evidence_so').val('');
                $('#evidence_link_so').val('');
                loadingDialog.close();
                $('#modal_detail_so').appendTo('body').modal('show');
                $('#modal_detail_so').find('[name="id_so"]').val(id_so);
                load_data_tabs(2)
            }
        });
    }

    // update SO by khael
    $('#form_update_so').submit(function(e) {
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
                        url: base_url + `/update_so`,
                        data: formData,
                        processData: false, // Jangan proses data, karena kita mengirim FormData
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            loadingDialog.close();
                            form[0].reset();
                            $('#modal_detail_so').modal('hide');
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

    function change_deadline(nama_goal, id_tasklist, divisi, so, si, detail, start, end) {
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


<!-- INTEGRASI SUPPORT DATATABLE -->
<script>
    function datatable_mom(data_mom, id = '') {
        $(`#table_mom${id}`).DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "autoWidth": false,
            "destroy": true,
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "data": data_mom,
            "columns": [{
                    data: 'id_mom',
                    'render': function(data, type, row) {
                        return `<a href="<?= base_url('pr/mom/'); ?>${row['id_link']}" target="_blank" class="btn btn-sm btn-primary mb-1"><i class="bi bi-printer"></i></a>
                <a href="<?= base_url('mom/excel/'); ?>${row['id_link']}" target="_blank" class="btn btn-sm btn-success mb-1"><i class="bi bi-filetype-xls"></i></a>
               `;
                    },
                    'className': 'text-center'
                },
                {
                    data: 'judul',
                    'render': function(data, type, row, meta) {

                        return `<span>${data} 
                            <a role="button" class="badge bg-light-blue float-end" style="cursor:pointer;" onclick="detail_mom('${row['id_mom']}')">
                              <i class="bi bi-info-circle"></i>
                            </a>
                          </span>`;

                    }
                },
                {
                    data: 'meeting'
                },
                {
                    data: 'department'
                },
                {
                    data: 'peserta',
                    'render': function(data, type, row, meta) {
                        avatar_pic = ``;
                        avatar_pic_plus = ``;
                        if (row['pp_peserta'].indexOf(',') > -1) {
                            array_pic = row['pp_peserta'].split(',');
                            for (let index = 0; index < array_pic.length; index++) {
                                if (index < 2) {
                                    avatar_pic += `<div class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${array_pic[index]}&quot;);">
                            <img src="http://trusmiverse.com/hr/uploads/profile/${array_pic[index]}" alt="" style="display: none;">
                            </div>`;
                                }
                            }
                            if (array_pic.length > 2) {
                                avatar_pic_plus = `<div class="avatar avatar-30 bg-light-theme rounded-circle me-1">
                                <p class="small">${parseInt(array_pic.length)-2}+</p>
                            </div>`;
                            } else {
                                avatar_pic_plus = '';
                            }
                            return `<div class="d-flex justify-content-center" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${row['peserta']}">
                                ${avatar_pic}${avatar_pic_plus}  
                            </div>`;
                        } else {
                            return `
                        <div class="row">
                            <div class="col-auto align-self-center">
                                <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${row['pp_peserta']}&quot;);">
                                    <img src="http://trusmiverse.com/hr/uploads/profile/${row['pp_peserta']}" alt="" style="display: none;">
                                </figure>
                            </div>
                            <div class="col px-0 align-self-center">
                                <p class="mb-0 small">${row['peserta']}</p>
                            </div>
                        </div>`;
                        }
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    data: 'agenda'
                },
                {
                    data: 'pembahasan',
                    'render': function(data, type, row) {
                        return `${data}`;
                    }
                },
                {
                    data: 'tempat'
                },
                {
                    data: 'tgl'
                },
                {
                    data: 'waktu'
                },
                {
                    data: 'created_by',
                    'render': function(data, type, row, meta) {
                        return `<div class="row">
                            <div class="col-auto align-self-center">
                                <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${row['profile_picture']}&quot;);">
                                    <img src="http://trusmiverse.com/hr/uploads/profile/${row['profile_picture']}" alt="" style="display: none;">
                                </figure>
                            </div>
                            <div class="col px-0 align-self-center">
                                <p class="mb-0 small">${row['username']}</p>
                                <p class="small text-secondary small">${row['created_at']}</p>
                            </div>
                        </div>`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                }
            ]
        });
    }

    function datatable_ibr(data_ibr, id = '') {
        $(`#table_ibr${id}`).DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "autoWidth": false,
            "destroy": true,
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "data": data_ibr,
            "columns": [

                {
                    data: 'task',
                    "render": function(data, type, row, meta) {
                        return `<div class="row">
                                    <div class="col-8 order-2 order-md-1">
                                        <div id="ellipsis-ex" class="d-inline-block text-truncate text-turncate-custom" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <span data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${row['task']}">${row['task']}</span><br>
                                        </div>
                                    </div>
                                    
                                </div>`
                    },
                    'width': '20%',
                },

                {
                    data: 'id_pic',
                    "render": function(data, type, row, meta) {
                        avatar_pic = ``;
                        avatar_pic_plus = ``;
                        if (row['profile_picture_pic'].indexOf(',') > -1) {
                            array_pic = row['profile_picture_pic'].split(',');
                            for (let index = 0; index < array_pic.length; index++) {
                                if (index < 2) {
                                    avatar_pic += `<div class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${array_pic[index]}&quot;);">
                                    <img src="http://trusmiverse.com/hr/uploads/profile/${array_pic[index]}" alt="" style="display: none;">
                                    </div>`;
                                }
                            }
                            if (array_pic.length > 2) {
                                avatar_pic_plus = `<div class="avatar avatar-30 bg-light-theme rounded-circle me-1">
                                        <p class="small">${parseInt(array_pic.length)-2}+</p>
                                    </div>`;
                            } else {
                                avatar_pic_plus = '';
                            }
                        } else {
                            avatar_pic += `<div class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${row['profile_picture_pic']}&quot;);">
                                        <img src="http://trusmiverse.com/hr/uploads/profile/${row['profile_picture_pic']}" alt="" style="display: none;">
                                    </div>`;
                            avatar_pic_plus = '';
                        }
                        return `
                                <div class="d-flex justify-content-center" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${row['team_name']}">
                                    ${avatar_pic}${avatar_pic_plus}  
                                </div>
                            `
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    data: 'type',
                    "render": function(data, type, row, meta) {
                        if (row['id_type'] == 1) {

                            return `<span class="badge bg-light-green text-dark">${row['type']}</span>`
                        } else {
                            return `<span class="badge bg-light-yellow text-dark">${row['type']}</span>`

                        }
                    },
                    "className": "d-none d-md-table-cell"
                },
                {
                    data: 'due_date',
                    "render": function(data, type, row, meta) {
                        return `<div class="d-flex justify-content-center">
                       
                         <span class="">${row['due_date']}</span>
                        </div>`
                    },
                    "className": "d-none d-md-table-cell"
                },

                {
                    data: 'status',
                    "render": function(data, type, row, meta) {
                        return `<a role="button" onclick="detail_task('${row['id_task']}')" class="btn btn-sm btn-link text-white" style="cursor:pointer;background-color:${row['status_color']}">${row['status']}</a>`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },

                {
                    data: 'strategy',
                    "render": function(data, type, row, meta) {
                        if (row['strategy'].indexOf(',') != -1) {
                            element_strategy = `<ol>`
                            var segments = row['strategy'].split(',');
                            for (let index = 0; index < segments.length; index++) {
                                element_strategy += `<li>${segments[index]}</li>`
                            }
                            element_strategy += `</ol>`
                        } else {
                            element_strategy = `${row['strategy']}`
                        }
                        return `<div class="row">
                                    <div class="col">
                                        <div id="ellipsis-ex" class="d-inline-block text-truncate" style="max-width: 250px;">
                                            <span data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${row['strategy']}">${element_strategy}</span><br>
                                        </div>
                                    </div>
                                </div>`
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    data: 'jenis_strategy',
                    "render": function(data, type, row, meta) {
                        if (row['jenis_strategy'] == "Once") {
                            jenis_strategy_class = ` bg-light-green text-green`
                        } else {
                            jenis_strategy_class = `bg-light-red text-red`
                        }
                        return `<a role="button" class="btn btn-sm btn-link ${jenis_strategy_class}" style="cursor:pointer;" style="cursor:pointer;">${row['jenis_strategy']}</a>`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    data: 'progress',
                    "className": "d-none d-md-table-cell text-end"
                },
                {
                    data: 'timeline',
                    "render": function(data, type, row, meta) {
                        if (row['start'] == "" || row['end'] == "" || row['start'] == "0000-00-00" || row['end'] == "0000-00-00") {
                            return `-`
                        } else {
                            return `<span class="badge bg-light-blue text-blue small">${row['timeline']}</span>`;
                        }
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    data: 'evaluation',
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    data: 'created_by',
                    "render": function(data, type, row, meta) {
                        return `<div class="align-items-center">
                                <div class="col-auto ps-0">
                                    <p class="text-secondary m-0 small">${row['tgl_dibuat']} | <span class="text-secondary m-0 small">${row['owner_username']} </span></p>                                    
                                </div>
                            </div>`
                    },
                    "className": "d-none d-md-table-cell text-left"
                },

            ]
        });
    }

    function datatable_gen(data_gen, id = '') {
        $(`#table_gen${id}`).DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "autoWidth": false,
            "destroy": true,
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "data": data_gen,
            "columns": [

                {
                    data: 'id_gemba',
                    'render': function(data, type, row) {
                        return `<a href="javascript:void(0);" class="badge bg-sm bg-primary" onclick="result_gemba('${data}')">${data}</a>`;
                    },
                    'className': 'text-center',

                },
                {
                    data: 'tgl_plan'
                },
                {
                    data: 'tipe_gemba'
                },
                {
                    data: 'lokasi'
                },
                {
                    data: 'evaluasi'
                },
                {
                    data: 'peserta'
                },
                {
                    data: 'status',
                    'render': function(data, type, row) {
                        return `<span class="badge bg-sm bg-${row['color']}">${data}</span>
            <span class="badge bg-sm bg-${row['color_akhir']}">${row['status_akhir']}</span>`;
                    }
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'created_by'
                },


            ]
        });
    }

    function datatable_conco(data_conco,id='') {
        $(`#table_conco${id}`).DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "autoWidth": false,
            "destroy": true,
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "data": data_conco,
            "columns": [

                {
                    'data': 'id_coaching',
                    // 'render': function(data,type,row){
                    //   return `<a href="javascript:void(0);" class="badge bg-sm bg-primary" onclick="result_gemba('${data}')">${data}</a>`;
                    // },
                    // 'className': 'text-center'
                },
                {
                    'data': 'karyawan',
                    'render': function(data, type, row) {
                        return `<span>${data}</span><br>
            <hr style="margin-top:3px;margin-bottom:3px;">
            <p class="mb-0 text-muted small"><i class="bi bi-buildings"></i> ${row['company_name']}</p>
            <hr style="margin-top:3px;margin-bottom:3px;">
            <p class="mb-0 text-muted small"><i class="bi bi-building-check"></i> ${row['department_name']}</p>
            <hr style="margin-top:3px;margin-bottom:3px;">
            <p class="mb-0 text-muted small"><i class="bi bi-person-badge"></i> ${row['designation_name']}</p>`;
                    },
                    'width': '20%'
                },
                {
                    'data': 'tempat'
                },
                {
                    'data': 'tanggal'
                },
                {
                    'data': 'atasan'
                },
                {
                    'data': 'review'
                },
                {
                    'data': 'goals'
                },
                {
                    'data': 'reality'
                },
                {
                    'data': 'option'
                },
                {
                    'data': 'will'
                },
                {
                    'data': 'komitmen'
                },
                {
                    'data': 'foto',
                    'render': function(data, type, row) {
                        if (data != "") {
                            return `<a href="<?= base_url('uploads/coaching/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>`;
                        } else {
                            return ``;
                        }
                    }
                },
                {
                    'data': 'created_by',
                    'render': function(data, type, row) {
                        return `<span>${data}</span><br>
            <hr style="margin-top:3px;margin-bottom:3px;">
            <p class="mb-0 text-muted small"><i class="bi bi-clock"></i> ${row['created_at']}</p>`;
                    },
                    'width': '10%'
                }
            ]
        });
    }

    function datatable_comp(data_comp,id='') {
        $(`#table_comp${id}`).DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "autoWidth": false,
            "destroy": true,
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "data": data_comp,
            "columns": [

                {
                    "data": "task",
                    'width': '20%', // Tentukan lebar yang lebih proporsional
                    "render": function(data, type, row, meta) {
                        print = `<br><a href="<?= base_url(); ?>complaints/table/print_complaint/${row['id_task']}" target="_blank" role="button" class="badge bg-green" title="Print Form Complaint?">
                            <i class="bi bi-printer"></i>
                        </a>`;

                        return `<div class="row">
                    <div class="col-8 order-2 order-md-1">
                        <div id="ellipsis-ex" class="d-inline-block text-truncate text-turncate-custom" 
                             style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <strong><span data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${row['task']}">${row['task']}</span></strong><br>
                            <span class="text-nowrap small">${row['description']}</span>
                        </div>
                    </div>
                    <div class="col-4 order-1 order-md-2 text-center text-md-end">
                        <a role="button" class="badge bg-light-blue" style="cursor:pointer;" onclick="detail_task('${row['id_task']}')">
                            <i class="bi bi-info-circle"></i>
                        </a>
                        ${print}       
                    </div>
                </div>`;
                    }
                },

                {
                    "data": "category",
                    "render": function(data, type, row, meta) {
                        return `<span class="text-nowrap small">${row['category']}</span>`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "project",
                    "render": function(data, type, row, meta) {
                        return `${row['project']}`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "blok",
                    "render": function(data, type, row, meta) {
                        return `${row['blok']}`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "status",
                    "render": function(data, type, row, meta) {
                        return `<a role="button" class="badge ${row['status_color']}" style="cursor:pointer;">${row['status']}</a>`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "priority",
                    "render": function(data, type, row, meta) {
                        if (row['priority'] != '') {
                            return `<span class="badge ${row['priority_color']}">${row['priority']}</span> `
                        } else {
                            return `<span class="badge bg-light text-dark">not specified</span> `
                        }
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "created_by",
                    "render": function(data, type, row, meta) {
                        return `
                                <div class="d-flex">
                                    <div class="col-auto align-self-center" style="margin-right:8px;">
                                        <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;https://trusmiverse.com/hr/uploads/profile/${row['owner_photo']}&quot;);">
                                            <img src="https://trusmiverse.com/hr/uploads/profile/${row['owner_photo']}" alt="" style="display: none;">
                                        </figure>
                                    </div>
                                    <div class="col align-self-center">
                                        <p class="mb-0 small" style="font-size:8pt;">${row['owner_name']}</p>
                                        <hr class="m-0 p-0">
                                        <p class="small text-secondary small" style="font-size:7pt;">${row['created_at']}</p>
                                    </div>
                                </div>
                        `
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "verified_by",
                    "render": function(data, type, row, meta) {
                        return `
                                <div class="d-flex">
                                    <div class="col-auto align-self-center" style="margin-right:8px;">
                                        <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;https://trusmiverse.com/hr/uploads/profile/${row['verified_photo']}&quot;);">
                                            <img src="https://trusmiverse.com/hr/uploads/profile/${row['verified_photo']}" alt="" style="display: none;">
                                        </figure>
                                    </div>
                                    <div class="col align-self-center text-start">
                                        <p class="mb-0 small" style="font-size:8pt;">${row['verified_name']}</p>
                                        <hr class="m-0 p-0">
                                        <p class="small text-secondary small" style="font-size:7pt;">${row['verified_at']}</p>
                                    </div>
                                </div>
                        `
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    "data": "escalation_by",
                    "render": function(data, type, row, meta) {
                        return `
                                <div class="d-flex">
                                    <div class="col-auto align-self-center" style="margin-right:8px;">
                                        <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;https://trusmiverse.com/hr/uploads/profile/${row['escalation_photo']}&quot;);">
                                            <img src="https://trusmiverse.com/hr/uploads/profile/${row['escalation_photo']}" alt="" style="display: none;">
                                        </figure>
                                    </div>
                                    <div class="col align-self-center text-start">
                                        <p class="mb-0 small" style="font-size:8pt;">${row['escalation_name']}</p>
                                        <hr class="m-0 p-0">
                                        <p class="small text-secondary small" style="font-size:7pt;">${row['escalation_at']}</p>
                                    </div>
                                </div>
                        `
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    "data": "id_pic",
                    "render": function(data, type, row, meta) {
                        avatar_pic = ``;
                        avatar_pic_plus = ``;
                        if (row['profile_picture_pic'].indexOf(',') > -1) {
                            array_pic = row['profile_picture_pic'].split(',');
                            for (let index = 0; index < array_pic.length; index++) {
                                if (index < 2) {
                                    avatar_pic += `<div class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;https://trusmiverse.com/hr/uploads/profile/${array_pic[index]}&quot;);">
                                    <img src="https://trusmiverse.com/hr/uploads/profile/${array_pic[index]}" alt="" style="display: none;">
                                    </div>`;
                                }
                            }
                            if (array_pic.length > 2) {
                                avatar_pic_plus = `<div class="avatar avatar-30 bg-light-theme rounded-circle me-1">
                                        <p class="small">${parseInt(array_pic.length)-2}+</p>
                                    </div>`;
                            } else {
                                avatar_pic_plus = '';
                            }
                            return `
                                    <div class="d-flex justify-content-center" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${row['team_name']}">
                                        ${avatar_pic}${avatar_pic_plus}  
                                    </div>
                                `
                        } else {
                            if (row['id_pic'] != '') {
                                return `
                                <div class="d-flex">
                                    <div class="col-auto align-self-center text-start" style="margin-right:8px;">
                                        <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;https://trusmiverse.com/hr/uploads/profile/${row['profile_picture_pic']}&quot;);">
                                            <img src="https://trusmiverse.com/hr/uploads/profile/${row['profile_picture_pic']}" alt="" style="display: none;">
                                        </figure>
                                    </div>
                                    <div class="col align-self-center text-start">
                                        <p class="mb-0 small" style="font-size:8pt;">${row['team_name']}</p>
                                        <hr class="m-0 p-0">
                                        <p class="small text-secondary small" style="font-size:7pt;">${row['solver_at']}</p>
                                    </div>
                                </div>
                                `;
                            }

                            return `<span class="badge bg-light text-dark">not yet selected</span> `

                        }
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    "data": "due_date",
                    "render": function(data, type, row, meta) {
                        if (row['due_date'] == "") {
                            return `<span class="badge bg-light text-dark">not yet estimated</span> `
                        } else {
                            return `<span class="badge bg-light-red text-dark small" data-bs-toggle="tooltip" data-bs-placement="top" title="${row['due_date_text']}">${row['due_date']}</span>`;
                        }
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    "data": "progress",
                    "render": function(data, type, row, meta) {
                        if (row['progress'] == "") {
                            return `-`
                        } else {
                            return `<span class="badge bg-light-green text-dark small">${row['progress']}%</span>`;
                        }
                    },
                    "className": "d-none d-md-table-cell text-end"
                },
                {
                    "data": "timeline",
                    "render": function(data, type, row, meta) {
                        if (row['start'] == "" || row['end'] == "" || row['start'] == "0000-00-00" || row['end'] == "0000-00-00") {
                            return `-`
                        } else {
                            return `<span class="badge bg-light-red text-dark small">${row['timeline']}</span>`;
                        }
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    "data": "leadtime_process",
                    "render": function(data, type, row, meta) {
                        if (row['start'] == "" || row['end'] == "" || row['start'] == "0000-00-00" || row['end'] == "0000-00-00") {
                            return `-`
                        } else {
                            return `<span class="badge bg-light-yellow text-dark small">${row['leadtime_process']}</span>`;
                        }
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    "data": "leadtime_progress",
                    "render": function(data, type, row, meta) {
                        if (row['start'] == "" || row['end'] == "" || row['start'] == "0000-00-00" || row['end'] == "0000-00-00") {
                            return `-`
                        } else {
                            return `<span class="badge bg-light-blue text-dark small">${row['leadtime_progress']}</span>`;
                        }
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
            ]
        });
    }

    function datatable_teamtalk(data_teamtalk,id='') {
        $(`#table_teamtalk${id}`).DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "autoWidth": false,
            "destroy": true,
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "data": data_teamtalk,
            "columns": [


                {
                    "data": "id_chat",
                    "render": function(data, type, row, meta) {
                        return `<a class = "label label-primary" href = "https://trusmicorp.com/rspproject/chat_sales_bm/detail_ht_chat/${data}" target="_blank">${data}</a>`;
                    },
                    "className": "text-center"
                },
                {
                    "data": "sd"
                },
                {
                    "data": "rv"
                },

                {
                    "data": "rate_informasi",
                    "render": function(data, type, row, meya) {
                        stars = '';
                        for (let i = 0; i < data; i++) {
                            stars += `<span class = "stars-list">★</span>`;
                        }
                        return stars;
                    },
                    "className": ` text-center`
                },
                {
                    "data": "rate_masalah",
                    "render": function(data, type, row, meya) {
                        stars = '';
                        for (let i = 0; i < data; i++) {
                            stars += `<span class = "stars">★</span>`;
                        }
                        return stars;
                    },
                    "className": ` text-center`
                },
                {
                    "data": "rate_pelayanan",
                    "render": function(data, type, row, meya) {
                        stars = '';
                        for (let i = 0; i < data; i++) {
                            stars += `<span class = "stars">★</span>`;
                        }
                        return stars;
                    },
                    "className": ` text-center`
                },

                {
                    "data": "created_at",
                    "className": "text-center"
                },

            ]
        });
    }
</script>

<!-- 8-3-25 Edit Detail Tasklist -->
<script>

    document.addEventListener("DOMContentLoaded", function() {
        var idTasklist  = document.getElementById("id_tasklist").value;
        var editIcon    = document.getElementById("edit_icon");

        // Set onclick langsung dengan parameter yang benar
        editIcon.setAttribute("onclick", "edit_tasklist('" + idTasklist + "')");
    });

    function edit_tasklist(id) {
        alert("ID Tasklist: " + id);
    }

    $("#edit_tgl_start").datepicker({
        startDate: new Date(),
        autoclose: true,
        format: "yyyy-mm-dd",
    });

    var nextDate = new Date();
    nextDate.setDate(nextDate.getDate() + 1);

    $("#edit_tgl_end").datepicker({
        startDate: nextDate,
        autoclose: true,
        format: "yyyy-mm-dd",
    });

    function edit_tasklist(id_tasklist) {

        var id_tasklist = $('#id_tasklist').val();

        $.ajax({
            type: "POST",
            url: base_url + 'get_edit_detail_tasklist',
            data: {
                id_tasklist: id_tasklist
            },
            dataType: "json",
            success: function(response) {
                $('#edit_id_tasklist').val(id_tasklist);
                edit_id_pic.setSelected(response.edit_detail.pic.split(','));
                $('#user_edit_pic').val(response.edit_detail.pic);
                $('#edit_tgl_start').val(response.edit_detail.start);
                $('#edit_tgl_end').val(response.edit_detail.end);
                $('#edit_tgl_start_pic').val(response.edit_detail.start);
                $('#edit_tgl_end_pic').val(response.edit_detail.end);
                $('#edit_detail').val(response.edit_detail.detail);
                $('#before_detail').val(response.edit_detail.detail);
                $('#edit_output').val(response.edit_detail.output);
                $('#edit_target').val(response.edit_detail.target);
                // loadingDialog.close();
                $('#modal_edit_detail_tasklist').appendTo('body').modal('show');
                $('#modal_edit_detail_tasklist').find('[name="id_tasklist"]').val(id_tasklist);
                load_all_tab();
            }
        });
    }

    edit_id_pic = new SlimSelect({
      select: "#edit_id_pic"
    });

    $("#edit_id_pic").change(function() {
      user_e = $("#edit_id_pic").val().toString().split(",");
      $("#user_edit_pic").val(user_e);
    });

    $('#form_edit_tasklist').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        // var divisi = $('#select_divisi').val();
        // var month = $('#select_month').val();
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
                        url: base_url + `/update_tasklist_grd`,
                        data: formData,
                        processData: false, // Jangan proses data, karena kita mengirim FormData
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            loadingDialog.close();
                            $('#modal_edit_detail_tasklist').modal('hide');
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

</script>