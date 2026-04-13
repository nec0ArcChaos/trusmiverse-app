<script>
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
                "url": "<?= base_url(); ?>tickets/table_dev/dt_tickets",
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
                                        <p class="small text-secondary small">${row['tgl_dibuat']}</p>
                                        <p class="mb-0 small">#${row['id_task']}</p>
                                    </div>
                                </div>
                        `
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
                                        <p class="small text-secondary small">${row['tgl_diproses']}</p>
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
                    "data": "id_uat",
                    "render": function(data, type, row, meta) {
                        if (data != null) {
                            if (row['status_uat'] == 'Sesuai') {
                                uat = `<span class = "badge bg-primary text-white">Sesuai</span><br><small class="text-muted">${row['note_uat']}</small>`;
                            } else {
                                uat = `<span class = "badge bg-danger text-white">Tidak Sesuai</span><br><small class="text-muted">${row['note_uat']}</small><br><small><a href="https://trusmiverse.com/apps/uploads/tickets/${row['files']}" target="_blank"> <i class="bi bi-cloud-arrow-down-fill"></i></a></small>`;
                            }
                            return uat;
                        } else {
                            return '';
                        }
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    "data": "id_task",
                    "render": function(data, type, row, meta) {
                        return `<span class="small">${row['id_task']}</span>`;
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