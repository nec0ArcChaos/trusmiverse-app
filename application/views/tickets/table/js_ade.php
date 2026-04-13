<script>
    var id_user = '<?= $this->session->userdata('user_id'); ?>';

    function dt_tickets() {
        start = $('#start').val()
        end = $('#end').val()
        filter_type = $('#filter_type').val()
        filter_pic = $('#filter_pic').val()
        filter_status = $('#filter_status').val()
        console.log(filter_type);
        console.log(filter_pic);
        $('#dt_tickets').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="bi bi-download text-white"></i>',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    start: start,
                    end: end,
                    filter_type: filter_type,
                    filter_pic: filter_pic,
                    filter_status: filter_status.toString(),
                },
                "url": "<?= base_url(); ?>tickets/table/dt_tickets",
            },
            "columns": [{
                    className: 'dt-control text-center d-table-cell d-md-none',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                {
                    "data": "task",
                    "render": function(data, type, row, meta) {
                        return `<div class="row">
                                    <div class="col-8 order-2 order-md-1">
                                        <div id="ellipsis-ex" class="d-inline-block text-truncate text-turncate-custom">
                                            <span data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${row['task']}">${row['task']}</span><br>
                                        </div>
                                    </div>
                                    <div class="col-4 order-1 order-md-2 text-center text-md-end">
                                        <a role="button" class="badge bg-light-blue" style="cursor:pointer;" onclick="detail_task('${row['id_task']}')">
                                            <i class="bi bi-info-circle"></i>
                                        </a>
                                    </div>
                                </div>`
                    }
                },
                {
                    "data": "created_by",
                    "render": function(data, type, row, meta) {
                        return `
                                <div class="row">
                                    <div class="col-auto align-self-center">
                                        <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;https://trusmiverse.com/hr/uploads/profile/${row['owner_photo']}&quot;);">
                                            <img src="https://trusmiverse.com/hr/uploads/profile/${row['owner_photo']}" alt="" style="display: none;">
                                        </figure>
                                    </div>
                                    <div class="col px-0 align-self-center">
                                        <p class="mb-0 small">${row['owner_name']}</p>
                                    </div>
                                </div>
                        `
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "id_task",
                    "render": function(data, type, row, meta) {
                        // tikdev
                        users_it_spv_up = [1, 61, 64, 1161];

                        if (users_it_spv_up.includes(parseInt(id_user))) {

                            class_star = '';

                            if (row['development'] == null) {
                                class_star = 'bi-star';
                            } else {
                                class_star = 'bi-star-fill text-yellow';
                            }

                            return `<span class="small">${row['id_task']}</span>
                            <a role="button" class="badge bg-light-blue tikdev" style="cursor:pointer; margin-leftx:10px;" onclick="add_development('${row['id_task']}')">
                            <i class="bi ${class_star}"></i>
                            </a>`;
                        } else {
                            return `<span class="small">${row['id_task']}</span>`;
                        }

                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "tgl_dibuat",
                    "render": function(data, type, row, meta) {
                        return `<span class="text-nowrap small">${row['tgl_dibuat']}</span>`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "priority",
                    "render": function(data, type, row, meta) {
                        return `<span class="badge ${row['priority_color']}">${row['priority']}</span> `
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "impact",
                    "render": function(data, type, row, meta) {
                        if (row['impact'].indexOf(',') > -1) {
                            array_impact = row['impact'].split(',');
                            badge_impact = '';
                            for (let index = 0; index < array_impact.length; index++) {
                                badge_impact +=
                                    `<span class="badge bg-light-orange text-dark">${array_impact[index]}</span>`
                            }
                            return badge_impact;
                        } else {
                            if (row['impact'] == "") {
                                return ``
                            } else {
                                return `<span class="badge bg-light-orange text-dark">${row['impact']}</span>`
                            }
                        }
                    },
                    "className": "d-none d-md-table-cell text-left"
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
                            return `
                                <div class="row">
                                    <div class="col-auto align-self-center">
                                        <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;https://trusmiverse.com/hr/uploads/profile/${row['profile_picture_pic']}&quot;);">
                                            <img src="https://trusmiverse.com/hr/uploads/profile/${row['profile_picture_pic']}" alt="" style="display: none;">
                                        </figure>
                                    </div>
                                    <div class="col px-0 align-self-center">
                                        <p class="mb-0 small">${row['team_name']}</p>
                                    </div>
                                </div>`;
                        }
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "status",
                    "render": function(data, type, row, meta) {
                        return `<a role="button" class="badge ${row['status_color']}" style="cursor:pointer;">${row['status']}</a>`;
                    },
                    "className": "d-none d-md-table-cell text-right"
                },
                {
                    "data": "tgl_diproses",
                    "render": function(data, type, row, meta) {
                        users_it = [1, 61, 62, 64, 1161, 2041, 2063, 2070, 2969, 5203, 5397, 5840, 5963, 7111, 7651];
                        if (users_it.includes(parseInt(id_user))) {
                            return `<span class="badge bg-light-blue text-dark small">${row['tgl_diproses']}</span>
                                <a role="button" class="badge bg-light-blue tikdev" style="cursor:pointer; margin-left:10px;" onclick="edit_ticket_date('${row['id_task']}')">
                                    <i class="bi bi-pencil"></i>
                                </a>`;
                        } else {
                            return `<span class="badge bg-light-blue text-dark small">${row['tgl_diproses']}</span>`;
                        }
                        // return `<span class="badge bg-light-blue text-dark small">${row['tgl_diproses']}</span>
                        //         <a role="button" class="badge bg-light-blue tikdev" style="cursor:pointer; margin-left:10px;" onclick="edit_ticket_date('${row['id_task']}')">
                        //             <i class="bi bi-pencil"></i>
                        //         </a>`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "due_date",
                    "render": function(data, type, row, meta) {
                        if (row['due_date'] == "") {
                            return `-`
                        } else {
                            return `<span class="badge bg-light-red text-dark small" data-bs-toggle="tooltip" data-bs-placement="top" title="${row['due_date_text']}">${row['due_date']}</span>`;
                        }
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    "data": "tgl_selesai",
                    "render": function(data, type, row, meta) {
                        return `<span class="badge bg-light-blue text-dark small">${row['tgl_selesai']}</span>`;
                    },
                    "className": "d-none d-md-table-cell text-left"
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
                        if (row['start'] == "" || row['end'] == "" || row['start'] == "0000-00-00" || row[
                                'end'] == "0000-00-00") {
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
                        if (row['start'] == "" || row['end'] == "" || row['start'] == "0000-00-00" || row[
                                'end'] == "0000-00-00") {
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
                        if (row['start'] == "" || row['end'] == "" || row['start'] == "0000-00-00" || row[
                                'end'] == "0000-00-00") {
                            return `-`
                        } else {
                            return `<span class="badge bg-light-blue text-dark small">${row['leadtime_progress']}</span>`;
                        }
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    "data": "type",
                    "render": function(data, type, row, meta) {
                        return `<span class="text-nowrap small">${row['type']}</span>`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "sub_type",
                    "render": function(data, type, row, meta) {
                        return `<span class="text-nowrap small">${row['sub_type']}</span>`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "category",
                    "render": function(data, type, row, meta) {
                        return `<span class="text-nowrap small">${row['category']}</span>`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "object",
                    "render": function(data, type, row, meta) {
                        return `<span class="text-nowrap small">${row['object']}</span>`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "note",
                    "render": function(data, type, row, meta) {
                        return `<span class="small">${row['note']}</span>`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "deadline_uat",
                    "render": function(data, type, row, meta) {
                        if (data != null) {
                            uat =
                                `${data}<br><small><a class ="fst-italic link-underline-primary" style = "text-decoration : underline;" href="https://trusmiverse.com/apps/uat_form/index/${row['id_task']}" target="_blank">Form UAT</a></small>`
                            return uat;
                        } else {
                            return '';
                        }
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    "data": "id_uat",
                    "render": function(data, type, row, meta) {
                        if (data != null) {
                            if (row['status_uat'] == 'Sesuai') {
                                uat =
                                    `<span class = "badge bg-primary text-white">Sesuai</span><br><small>${row['note_uat']}</small><br><small class="text-muted">${row['tgl_uat']}</small>`;
                            } else {
                                if (row['files'] != null && row['files'].trim() != '') {
                                    files =
                                        `<small><a href="https://trusmiverse.com/apps/uploads/tickets/${row['files']}" target="_blank"> <i class="bi bi-cloud-arrow-down-fill"></i></a></small>`;
                                } else {
                                    files = '';
                                }
                                uat =
                                    `<span class = "badge bg-danger text-white">Tidak Sesuai</span>${files}<br><small>${row['note_uat']}</small><br><small class="text-muted">${row['tgl_uat']}</small>`;
                            }
                            return uat;
                        } else {
                            return '';
                        }
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    "data": "ekspektasi"
                },
                {
                    "data": "rating_kesesuaian",
                    "render": function(data, type, row, meta) {
                        if (data == 5) {
                            res = `<span class="small">
                                    <p class="text-secondary">
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                    </p></span>`;
                        } else if (data == 4) {
                            res = `<span class="small">
                                    <p class="text-secondary">
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                    </p></span>`;
                        } else if (data == 3) {
                            res = `<span class="small">
                                    <p class="text-secondary">
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                    </p></span>`;
                        } else if (data == 2) {
                            res = `<span class="small">
                                    <p class="text-secondary">
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                    </p></span>`;
                        } else if (data == 1) {
                            res = `<span class="small">
                                    <p class="text-secondary">
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                    </p></span>`;
                        } else {
                            res = `<span class="small"></span>`;
                        }
                        return res;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "rating_uiux",
                    "render": function(data, type, row, meta) {
                        if (data == 5) {
                            res = `<span class="small">
                                    <p class="text-secondary">
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                    </p></span>`;
                        } else if (data == 4) {
                            res = `<span class="small">
                                    <p class="text-secondary">
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                    </p></span>`;
                        } else if (data == 3) {
                            res = `<span class="small">
                                    <p class="text-secondary">
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                    </p></span>`;
                        } else if (data == 2) {
                            res = `<span class="small">
                                    <p class="text-secondary">
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                    </p></span>`;
                        } else if (data == 1) {
                            res = `<span class="small">
                                    <p class="text-secondary">
                                        <i class="text-yellow h6 bi bi-star-fill"></i>
                                    </p></span>`;
                        } else {
                            res = `<span class="small"></span>`;
                        }
                        return res;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "kecepatan_akses",
                    "render": function(data, type, row, meta) {
                        return `<span class="small">${data}</span>`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "impact_review",
                    "render": function(data, type, row, meta) {
                        return `<span class="small">${data}</span>`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                }
            ],
        });
    }

    // Add event listener for opening and closing details
    $('#dt_tickets tbody').on('click', 'td.dt-control', function() {
        var tr = $(this).closest('tr');
        var row = $('#dt_tickets').DataTable().row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(dt_detail_task(row.data())).show();
            tr.addClass('shown');
        }
    });

    function dt_detail_task(d) {
        // `d` is the original data object for the row
        return (
            `
            <table class="table table-sm table-striped" style="table-layout:fixed;">
                <tbody>
                    <tr><td style="width:30%;"><b>Id</b></td><td>${d.id_task}</td></tr>
                    <tr><td style="width:30%;"><b>Title</b></td><td>${d.task}</td></tr>
                    <tr><td style="width:30%;"><b>Description</b></td><td>${d.description}</td></tr>
                    <tr><td style="width:30%;"><b>Type</b></td><td>${d.type}</td></tr>
                    <tr><td style="width:30%;"><b>Category</b></td><td>${d.category}</td></tr>
                    <tr><td style="width:30%;"><b>Object</b></td><td>${d.object}</td></tr>
                    <tr><td style="width:30%;"><b>Due Date</b></td><td>${d.due_date}</td></tr>
                    <tr><td style="width:30%;"><b>Priority</b></td><td>${d.priority}</td></tr>
                    <tr><td style="width:30%;"><b>Status</b></td><td>${d.status}</td></tr>
                    <tr><td style="width:30%;"><b>Progress</b></td><td>${d.progress}</td></tr>
                    <tr><td style="width:30%;"><b>Timeline</b></td><td>${d.timeline}</td></tr>
                    <tr><td style="width:30%;"><b>Lt. Process</b></td><td>${d.leadtime_process}</td></tr>
                    <tr><td style="width:30%;"><b>Lt. Progress</b></td><td>${d.leadtime_progress}</td></tr>
                    <tr><td style="width:30%;"><b>Created At</b></td><td>${d.tgl_dibuat}</td></tr>
                    <tr><td style="width:30%;"><b>Created By</b></td><td>${d.owner_name}</td></tr>
                </tbody>
            </table>
            `
        );
    }
</script>