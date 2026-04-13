<script>
    function get_all_list_pekerjaan(project, year) {
        $.ajax({
            url: base_url + '/get_list_task',
            method: 'POST',
            data: {
                project: project,
                year: year
            },
            dataType: 'json',
            success: function(response) {

                $('#list_pekerjaan').empty();
                response.forEach((department,depindex)=>{
                    let departmentContent = '';
                    department.tasks.forEach((task, index) => {
    
                        let tableContent = `
            <table class="table table-hover" style="white-space:nowrap;">
                <thead>
                    <tr>
                        <th rowspan="2" style="vertical-align : middle;" class="small">Sub Pekerjaan</th>
                        <th rowspan="2" style="vertical-align : middle;" class="small">Output</th>
                        <th rowspan="2" style="vertical-align : middle;" class="small">Start</th>
                        <th rowspan="2" style="vertical-align : middle;" class="small">End</th>
                        <th rowspan="2" style="vertical-align : middle;" class="small">Lt.</th>
                        <th rowspan="2" style="vertical-align : middle;" class="small">Dep.</th>
                        <th rowspan="2" style="vertical-align : middle;" class="small">PIC</th>
                        <th rowspan="2" style="vertical-align : middle;" class="small">Target</th>
                        <th rowspan="2" style="vertical-align : middle;" class="small">Actual</th>
                        <th rowspan="2" style="vertical-align : middle;" class="small">Done at</th>
                        <th rowspan="2" style="vertical-align : middle;" class="small">Status</th>
                        <th rowspan="2" style="vertical-align : middle;" class="small">Evidence</th>
                        <th rowspan="2" style="vertical-align : middle;" class="small">TeamTalk</th>
                        <th rowspan="2" style="vertical-align : middle;" class="small">Meeting</th>
                        <th rowspan="2" style="vertical-align : middle;" class="small">Complain</th>
                        <th rowspan="2" style="vertical-align : middle;" class="small">Genba</th>
                        <th rowspan="2" style="vertical-align : middle;" class="small">Co & Co</th>
                        <th rowspan="2" style="vertical-align : middle;" class="small">IBR Pro</th>
                        <th rowspan="2" style="vertical-align : middle;" class="small">Training</th>
                        
                    ${generateTableHeader()}
                </thead>
                <tbody>`;
    
                        task.sub_task.forEach(subtask => {
                            tableContent += `
                <tr class="bg-light-yellow">
                    <td class="fw-bold"><i class="bi bi-circle-fill"></i> ${subtask.sub_pekerjaan}</td>
                    <td class="fw-bold"></td>
                    <td class="fw-bold">${subtask.start}</td>
                    <td class="fw-bold">${subtask.end}</td>
                    <td class="fw-bold"></td>
                    <td class="fw-bold"></td>
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
    
                            // Menambahkan kolom mingguan
                            for (let month = 1; month <= 12; month++) {
                                for (let week = 1; week <= 4; week++) {
                                    tableContent += `
                                    <td class="text-center "><div class="row"><div class="col px-1"><span class="${isInWeek(subtask.start, subtask.end, 2024, month, week) ? 'bg-primary text-white' : ''} d-block" style="height: 20px;"></span></div></div></td>
                        `;
    
                                }
                            }
    
                            tableContent += `</tr>`;
    
                            // Menambahkan detail subtask jika ada
                            subtask.details.forEach(detail => {
                                tableContent += `
                    <tr>
                        <td><div class="d-flex justify-content-between"><small>&emsp;<i class="bi bi-dash"></i> ${detail.detail}</small> <span class="badge bg-light-blue text-right" style='cursor:pointer' onclick="detail_pekerjaan('${detail.id_detail_pekerjaan}','${detail.id_detail}','${detail.id_sub_pekerjaan}','${detail.id_pekerjaan}','${detail.id_project}')"><i class="bi bi-newspaper fs-6"></i></span></div></td>
                        <td><small>${detail.output}</small></td>
                        <td><small>${detail.start}</small></td>
                        <td><small>${detail.end} <span class="badge bg-light-red text-dark" style='cursor:pointer' onclick="change_deadline('${detail.id_detail}','${detail.project}','${detail.nama_pekerjaan}','${detail.nama_sub_pekerjaan}','${detail.detail}','${detail.start}','${detail.end}')"><i class="bi bi-journal-arrow-up"></i> Change</span></small></td>
                        <td><small>${detail.leadtime}</small></td>
                        <td><small>${detail.kode}</small></td>
                        <td><small>${detail.pic}</small></td>
                        <td><small>${detail.target}</small></td>
                        <td><small>${detail.actual}</small></td>
                        <td><small>${detail.done_at}</small></td>
                        <td>
                            <span class="badge ${detail.warna}" onclick="detail_pekerjaan('${detail.id_detail_pekerjaan}','${detail.id_detail}','${detail.id_sub_pekerjaan}','${detail.id_pekerjaan}','${detail.id_project}')" style='cursor:pointer'>${detail.nama_status}</span>
                        </td>
                        <td class="text-center"><span class="badge bg-light-blue text-black" style='cursor:pointer'><i class="bi bi-file-earmark"></i>${detail.evidence}</span></td>
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
    
                                // Menambahkan kolom mingguan
                                for (let month = 1; month <= 12; month++) {
                                    for (let week = 1; week <= 4; week++) {
                                        tableContent += `
                            <td class="text-center "><div class="row"><div class="col px-1"><span class="${isInWeek(detail.start, detail.end, 2024, month, week) ? 'bg-primary text-white' : ''} d-block" style="height: 20px;"></span></div></div></td>`;
                                    }
                                }
    
                                tableContent += `</tr>`;
                            });
                        });
    
                        tableContent += `
                </tbody>
            </table>`;
    
                        // Membuat card dengan tabel
                        departmentContent += `<div id="accordion-${task.id_pekerjaan}" class="mb-2">
                        <div class="row" id="heading-${task.id_pekerjaan}">
                        <div class="col-auto">
                            <button class="btn btn-outline-primary btn-sm" data-toggle="collapse" data-target="#collapse-${task.id_pekerjaan}" aria-expanded="true" aria-controls="collapse-${task.id_pekerjaan}">
                                <i class="bi bi-chevron-down"></i>
                            </button>
                        </div>
                        <div class="col">
                        <p style="font-size: 14px; font-weight: bold;">
                            
                            ${index + 1}. ${task.pekerjaan} <br>
                            <span class="text-grey small fw-bold mt-0 ml-4"><i class="bi bi-stopwatch"></i> ${task.start} <i class="bi bi-arrow-right-short"></i> ${task.end}</span>
                        </p>
                       
                        </div>
                        <div class="col" align="right">
                            <span class="badge fs-6 bg-${task.warna}">${task.persen}% </span>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col">
                            <div id="collapse-${task.id_pekerjaan}" class="collapse ${index === 0 ? 'show' : ''}" aria-labelledby="heading-${task.id_pekerjaan}" data-parent="#accordion-${task.id_pekerjaan}">
                            <div class="table-responsive">
                                ${tableContent}
                            </div>
                               
                            </div>
                        </div>
                        </div>
                    </div>`;
                });
                        const departmentcard = `
                        
            <div class="card bg-light mb-4 rounded">
                <div class="card-header p-0 mb-3">
                    <div class="progress-bar bg-${department.warna} rounded-top" style="width: ${department.progres}%; height: 5pt; position: absolute; top: 0; left: 0;"></div>
                </div>
                <div class="card-body" style="margin-top: -10px;">
                    <h5 class="text-primary"><i class="bi bi-substack"></i> ${department.department_name}</h5>
                    ${departmentContent}
                </div>
            </div>
        `;
                

                    // Append ke container
                    $('#list_pekerjaan').append(departmentcard);
                });

            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    function isInWeek(start, end, year, month, week) {
        const dateStart = new Date(start);
        const dateEnd = new Date(end);
        const firstDayOfMonth = new Date(year, month - 1, 1);
        const weekStart = new Date(
            firstDayOfMonth.setDate((week - 1) * 7 + 1)
        );
        const weekEnd = new Date(
            firstDayOfMonth.setDate(weekStart.getDate() + 6)
        );
        return dateStart <= weekEnd && dateEnd >= weekStart;
    }

    function generateTableHeader() {
        var year = $('#year').val();
        let months = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
        let headerRow1 = "";
        months.forEach((month) => {
            headerRow1 += `<th colspan="4" class="small py-0">${month}</th>`;
        });
        let headerRow2 = "";
        months.forEach(() => {
            for (let week = 1; week <= 4; week++) {
                headerRow2 += `<td class="small py-0">W${week}</td>`;
            }
        });
        return `
        ${headerRow1}
        </tr>
        <tr>
            ${headerRow2}
        </tr>
    `;
    }
    function generateWeeksForYear() {
        
        let weeks = [];
        for (let month = 0; month < 12; month++) {
            let firstDay = new Date(year, month, 1);
            let lastDay = new Date(year, month + 1, 0);
            let startDate = firstDay;
            while (startDate <= lastDay) {
                let endDate = new Date(startDate);
                endDate.setDate(startDate.getDate() + 6);
                if (endDate > lastDay) {
                    endDate = lastDay;
                }
                weeks.push({
                    month: month + 1,
                    weekStart: startDate.toISOString().split('T')[0],
                    weekEnd: endDate.toISOString().split('T')[0]
                });
                startDate.setDate(startDate.getDate() + 7);
            }
        }
        return weeks;
    }

    function detail_pekerjaan(id,id_detail,id_sub,id_pekerjaan,id_project) {
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
        var year = $('#select_year').val();


        $.ajax({
            type: "POST",
            url: "<?= base_url('timeline_project/get_detail_task'); ?>",
            data: {
                id: id,
                id_detail: id_detail,
                id_sub: id_sub,
                id_pekerjaan: id_pekerjaan,
                id_project: id_project,
                year: year,
            },
            dataType: "json",
            success: function(response) {
                $('#t_pekerjaan').text(response.header.pekerjaan);
                $('#t_sub_pekerjaan').text(response.header.sub_pekerjaan);
                $('#t_status').text(response.header.nama_status);
                $('#t_status').removeClass().addClass(`badge fs-6 ${response.header.warna}`);
                $('#t_target').text(response.header.target);
                $('#t_detail').text(response.header.detail);
                $('#t_pic').text(response.header.pic);
                $('#t_output').text(response.header.output);
                $('#t_start').text(response.header.start);
                $('#t_deadline').text(response.header.end);
                $('#t_department').text(`${response.header.department_name}`);
                $('#status').val(response.header.status);
                $('#status_before').val(response.header.status);
                $('#actual').val(response.header.actual);
                $('#t_project').text(response.header.project);
                $('#note').val('');
                $('#evidence').val('');
                datatable_mom(response.mom);
                datatable_ibr(response.ibr);
                datatable_gen(response.genba);
                datatable_conco(response.conco);
                datatable_comp(response.complaint);
                datatable_teamtalk(response.teamtalk);
                loadingDialog.close();
                $('#modal_detail_pekerjaan').appendTo('body').modal('show');
                $('#modal_detail_pekerjaan').find('[name="id_detail_pekerjaan"]').val(id);
                load_all_tab();
            }
        });
    }

    function datatable_mom(data_mom) {
        $('#table_mom').DataTable({
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

    function datatable_ibr(data_ibr) {
        $('#table_ibr').DataTable({
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

    function datatable_gen(data_gen) {
        $('#table_gen').DataTable({
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

    function datatable_conco(data_conco) {
        $('#table_conco').DataTable({
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

    function datatable_comp(data_comp) {
        $('#table_comp').DataTable({
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

    function datatable_teamtalk(data_teamtalk) {
        $('#table_teamtalk').DataTable({
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
    $('#form_update').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var project = $('#select_project').val();
        var year = $('#select_year').val();
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
                            $('#modal_detail_pekerjaan').modal('hide');
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
        var id_detail_pekerjaan = $('#form_update').find('[name="id_detail_pekerjaan"]').val();

        $.ajax({
            type: "POST",
            url: base_url + "/load_all_tab",
            data: {
                'id_detail_pekerjaan': id_detail_pekerjaan
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                var history = ``;
                var file = ``;
                response.history.forEach((value) => {
                    if (value.status == value.status_before) {

                        history += `
                                    <tr>
                                        <td class="small text-secondary">${value.created_at}</td>
                                        <td class="small">${value.progress}%</td>
                                        <td class="small"><i class="bi bi-chat-quote text-primary"></i>Note</td>
                                        <td class="small">${value.note}</td>
                                    </tr>
                                    `;
                    } else {

                        history += `<tr>
                                        <td class="small text-secondary">${value.created_at}</td>
                                        <td class="small">${value.progress}%</td>
                                        <td class="small"><i class="bi bi-bookmark text-primary"></i>Status</td>
                                        <td class="small"><span class="badge ${value.st_before_warna}">${value.st_before}</span> > <span class="badge ${value.st_warna}">${value.st}</span></td>
                                    </tr>
                                    <tr>
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
                                                <a href="<?= base_url(''); ?>/uploads/evidence/${value.evidence}" target="_blank" class="avatar avatar-30 rounded text-red mr-3 w-100">
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
    function change_deadline(id,project, pekerjaan,sub,detail,start,end){
        var modal = $('#modal_change');
        $(modal).modal('show').appendTo('body');
        $(modal).find('[name="id_detail"]').val(id);
        $(modal).find('[name="project"]').val(project);
        $(modal).find('[name="nama_pekerjaan"]').val(pekerjaan);
        $(modal).find('[name="sub_pekerjaan"]').val(sub);
        $(modal).find('[name="detail_pekerjaan"]').val(detail);
        $(modal).find('[name="start"]').val(start);
        $(modal).find('[name="end"]').val(end);
    }
    $('#status').change(function(e) {
        e.preventDefault();
        if ($(this).val() == 3) {
            $('#actual').val(100);
        } else {

        }
    });
    $('#request_change').submit(function (e) { 
        e.preventDefault();
        var form = $(this);
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
                    $.ajax({
                        type: "POST",
                        url: base_url + `/request_change`,
                        data: form.serialize(),
                        dataType: "json",
                        success: function(response) {
                            loadingDialog.close();
                            $('#modal_change').modal('hide');
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
    
</script>