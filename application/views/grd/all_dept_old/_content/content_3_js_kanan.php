<script>

</script>

<!-- PELANGGARAN MANPOWER -->
<script>
    function get_data_warning_manpower(month) {
        $.ajax({
            type: "POST",
            url: base_url+'data_warning_manpower',
            data: {
                month:month,
                id_company: <?= $id_company ?>
            },
            dataType: "json",
            success: function(response) {
                $('#total_lock').text(response.header.lk);
                $('#total_st').text(response.header.st);
                $('#total_sp').text(response.header.sp);
                $('#total_denda').text(response.header.denda);
                $('#total_nominal').text(response.header.nominal);

                div_kehadiran = `<span class="position-absolute w-100 text-center fw-bold h6 mt-1 text-${response.kehadiran.warna}">${response.kehadiran.persen_hadir}%</span>
                        <div class="progress-bar bg-soft-${response.kehadiran.warna}" style="width:${response.kehadiran.persen_hadir}%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                        <div class="progress-bar bg-soft-grey" style="width:0%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>`;
                $('#div_kehadiran').empty().append(div_kehadiran);


                div_undone = `<span class="position-absolute w-100 text-center fw-bold h6 mt-1 text-${response.task_undone.warna}">${response.task_undone.persen}%</span>
                        <div class="progress-bar bg-soft-${response.task_undone.warna}" style="width:${response.task_undone.persen}%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                        <div class="progress-bar bg-soft-grey" style="width:0%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>`;
                $('#div_undone').empty().append(div_undone);
                get_detail_warning(response.detail);
            }
        });
    }

    function get_detail_warning(data) {
        $('#table_detail_warning').DataTable({
            "pageLength": 5,
            "lengthChange": false,
            "searching": false,
            "info": false,
            "paging": true,
            "autoWidth": false,
            "ordering": false,
            "destroy": true,
            "data": data,
            "columns": [
                // {
                //     "data": "foto_profile",
                //     "render": function(data, type, row, meta) {
                //         return `<img src="https://trusmiverse.com/hr/uploads/profile/${data ? data : 'default_female.jpg'}" class="rounded-circle" width="40" height="40">`;
                //     },
                //     "className": "text-center small"
                // },
                {
                    "data": "employee",
                    "className": "text-left small",
                    'render': function(data, type, row) {
                        return `${data} <br> ${row['department']}`;
                    }
                },
                {
                    "data": "persen",
                    "render": function(data) {
                        return `<span class="fw-bold">${data}%</span>`;
                    },
                    "className": "text-center small"
                },
                {
                    "data": "temuan",
                    "render": function(data) {
                        let badgeClass = data > 0 ? "bg-danger" : "bg-secondary";
                        return `<span class="badge ${badgeClass}">${data}</span>`;
                    },
                    "className": "text-center small"
                },
                {
                    "data": "jumlah_st",
                    "render": function(data) {
                        let badgeClass = data > 0 ? "bg-danger" : "bg-secondary";
                        return `<span class="badge ${badgeClass}">${data}</span>`;
                    },
                    "className": "text-center small"
                },
                {
                    "data": "jumlah_sp",
                    "render": function(data) {
                        let badgeClass = data > 0 ? "bg-danger" : "bg-secondary";
                        return `<span class="badge ${badgeClass}">${data}</span>`;
                    },
                    "className": "text-center small"
                },
                {
                    "data": "jumlah_lk",
                    "render": function(data) {
                        let badgeClass = data > 0 ? "bg-danger" : "bg-secondary";
                        return `<span class="badge ${badgeClass}">${data}</span>`;
                    },
                    "className": "text-center small"
                },
                {
                    "data": "denda",
                    "render": function(data) {
                        let badgeClass = data > 0 ? "bg-danger" : "bg-secondary";
                        return `<span class="badge ${badgeClass}">${data}</span>`;
                    },
                    "className": "text-center small"
                }

            ]
        });
    }
</script>