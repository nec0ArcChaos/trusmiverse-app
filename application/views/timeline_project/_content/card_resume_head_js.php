<!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->
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
                "url": base_url + `/get_resume_head`,
            },
            "columns": [{
                    "data": "employee_name",
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    },
                    "className": "text-center small"
                },
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
                    <div>${achieve_status} <span class="text-muted">${row['department_name']}</span></div>
                </div>
            </div>
        `;
                        return content;
                    },
                    "className": "small",
                    'width': '50%'
                },

                {
                    "data": "actual_leadtime",
                    "render": function(data, type, row, meta) {
                        return `${data}%<br>${row['avg_leadtime']}`;
                    },
                    "className": "text-center small"
                },
                {
                    "data": "actual_rating",
                    "render": function(data, type, row, meta) {
                        star = '';
                        for (i = 0; i < Number(row['avg_rating']); i++) {
                            star += '<i class="bi bi-star-fill text-warning small"></i>';
                        }
                        content = `<div class = "row d-flex justify-content-center"><div class = "col-12 text-center">${Number(data)}%</div><div class="col-12 text-center d-inline">${star}</div></div>`
                        return content;
                    },
                    "className": "text-center small w-100"
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