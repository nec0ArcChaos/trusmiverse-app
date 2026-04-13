<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

<script>
    // Inisialisasi DataTable dengan tombol ekspor
    $(document).ready(function() {

        /*Range*/
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
            console.log('filter date: ', start.format('YYYY-MM'));
            // resume_traffic_system_overview(start.format('YYYY-MM'));
        }

        // Buat daftar ranges per bulan secara otomatis
        let monthRanges = {};
        for (let i = 0; i < 12; i++) {
            let month = moment('2025-01', 'YYYY-MM').add(i, 'months');
            let label = month.format('YYYY-MM'); // contoh: 2025-01
            monthRanges[label] = [month.startOf('month'), month.endOf('month')];
        }

        $('.range').daterangepicker({
            startDate: moment().startOf('month'),
            endDate: moment().endOf('month'),
            "drops": "down",
            ranges: monthRanges,
            locale: {
                format: 'YYYY-MM' // format tampilan
            }
        }, cb);

        cb(start, end);

        // datepicker month
        $("#periode").datepicker({
            format: "yyyy-mm",
            viewMode: "year",
            minViewMode: "months",
            autoclose: true,
            orientation: "bottom"
        });

        const periodeNow = '<?= date("Y-m"); ?>';
        // resume_traffic_system_overview(periodeNow);
    });

    const ctx = document.getElementById('trendChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
            datasets: [{
                    label: 'Operational',
                    data: [0, 60, 100, 50, 20, 70, 0],
                    borderColor: '#ff4d4d',
                    borderWidth: 3,
                    fill: false,
                    borderDash: [8, 4],
                    tension: 0.4
                },
                {
                    label: 'Marketing',
                    data: [0, 85, 60, 50, 10, 60, 0],
                    borderColor: '#9b59b6',
                    borderWidth: 3,
                    fill: false,
                    borderDash: [8, 4],
                    tension: 0.4
                },
                {
                    label: 'Production',
                    data: [0, 60, 25, 30, 15, 55, 0],
                    borderColor: '#3498db',
                    borderWidth: 3,
                    fill: false,
                    borderDash: [8, 4],
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: value => value + '%'
                    }
                }
            }
        }
    });
</script>