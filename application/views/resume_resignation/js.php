<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>


<script>
    const baseurl = `<?= base_url('resume_resignation'); ?>`
    const roleUser = <?= json_encode($this->session->userdata('user_role_id')) ?>;
    var totalSeluruhDashboard_2 = 0;
    $(document).ready(function() {

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');
        
        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
            var selectedCompanyId = $('#company').val();
            dashboard_1(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'), selectedCompanyId);
            dashboard_2(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'), selectedCompanyId);
            dashboard_3(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'), selectedCompanyId);
            dashboard_4(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'), selectedCompanyId);
            totalSeluruhDashboard_2 = 0;
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
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

        $('#company').on('change', function() {
            var selectedCompanyId = $(this).val();
            var start = $('#start').val();
            var end = $('#end').val();
            dashboard_1(start, end, selectedCompanyId);
            dashboard_2(start, end, selectedCompanyId);
            dashboard_3(start, end, selectedCompanyId);
            dashboard_4(start, end, selectedCompanyId);
            totalSeluruhDashboard_2 = 0;
        });
    });

    function dashboard_1(start,end,company_id) {
        $.ajax({
            url: `${baseurl}/dashboard_1`,
            type: 'POST',
            dataType: 'json',
            data: {
                start: start,
                end: end,
                company_id: company_id
            },
            beforeSend: function() {

            },
            success: function(response) {
                var html = ``;

                if (response.length > 0) {
                    response.forEach(masaKerjaItem => {
                        if (masaKerjaItem.masa_kerja == '1') {
                            masa_kerja = '< 3 bulan'
                        } else if (masaKerjaItem.masa_kerja == '2') {
                            masa_kerja = '= 3 bulan'
                        } else {
                            masa_kerja = '> 3 bulan'
                        }
                        let totalRowsMasaKerja = 0;

                        // Hitung total baris dalam kelompok masa kerja ini
                        masaKerjaItem.data.forEach(companyItem => {
                            companyItem.data.forEach(departmentItem => {
                                totalRowsMasaKerja++;
                            });
                        });

                        let firstRow = true; // Menandai baris pertama untuk rowspan
                        masaKerjaItem.data.forEach(companyItem => {
                            companyItem.data.forEach((departmentItem, index) => {
                                var row = `<tr>`;

                                // Jika ini adalah baris pertama dalam kelompok masa kerja, tambahkan rowspan
                                if (firstRow) {
                                    row += `<td rowspan="${totalRowsMasaKerja}" class="text-center" style="vertical-align: middle !important;">${masa_kerja}</td>`;
                                    firstRow = false; // Setelah ini, jangan tambahkan lagi rowspan
                                }

                                row += `
                                    <td>${companyItem.company_name}</td>
                                    <td>${departmentItem.department_name}</td>
                                    <td>${departmentItem.mp}</td>
                                </tr>`;

                                html += row;
                            });
                        });
                    });
                } else {
                    html += `<tr><td colspan="4" class="text-center">Tidak ada data</td></tr>`
                }
                

                $("#dashboard_1").html(html);
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    function dashboard_2(start,end,company_id) {
        $.ajax({
            url: `${baseurl}/dashboard_2`,
            type: 'POST',
            dataType: 'json',
            data: {
                start: start,
                end: end,
                company_id: company_id
            },
            beforeSend: function() {

            },
            success: function(response) {
                var html = ``;

                if (response.length > 0) {
                    var total_diputus_perusahaan = 0;
                    var total_habis_perusahaan = 0;
                    var total_habis_pribadi = 0;
                    var total_resign = 0;
                    response.forEach(item => {
                        total_diputus_perusahaan += parseInt(item.diputus_perusahaan)
                        total_habis_perusahaan += parseInt(item.habis_perusahaan)
                        total_habis_pribadi += parseInt(item.habis_pribadi)
                        total_resign += parseInt(item.resign)

                        var totalDepart = parseInt(item.diputus_perusahaan) + parseInt(item.habis_perusahaan) + parseInt(item.habis_pribadi) + parseInt(item.resign);
                        totalSeluruhDashboard_2 += totalDepart;
                        html += `<tr>
                            <td>${item.department}</td>
                            <td>${item.diputus_perusahaan}</td>
                            <td>${item.habis_perusahaan}</td>
                            <td>${item.habis_pribadi}</td>
                            <td>${item.resign}</td>
                            <td>${totalDepart}</td>
                        </tr>`
                    });
                } else {
                    html += `<tr><td colspan="6" class="text-center">Tidak ada data</td></tr>`
                }
                
                $("#dashboard_2").html(html);
                $('#foot_dashboard_2').html(`<tr>
                                    <th>Total</th>
                                    <th>${total_diputus_perusahaan || 0}</th>
                                    <th>${total_habis_perusahaan || 0}</th>
                                    <th>${total_habis_pribadi || 0}</th>
                                    <th>${total_resign || 0}</th>
                                    <th>${totalSeluruhDashboard_2}</th>
                                </tr>`);
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    function dashboard_3(start,end,company_id) {
        $.ajax({
            url: `${baseurl}/dashboard_3`,
            type: 'POST',
            dataType: 'json',
            data: {
                start: start,
                end: end,
                company_id: company_id
            },
            beforeSend: function() {

            },
            success: function(response) {
                var persen_diputus_perusahaan = (response.diputus_perusahaan / totalSeluruhDashboard_2) * 100;
                var persen_habis_perusahaan = (response.habis_perusahaan / totalSeluruhDashboard_2) * 100;
                var persen_habis_pribadi = (response.habis_pribadi / totalSeluruhDashboard_2) * 100;
                var persen_resign = (response.resign / totalSeluruhDashboard_2) * 100;
                var html = `<tr>
                                <td>Contract - Perusahaan</td>
                                <td>${response.diputus_perusahaan || 0}</td>
                                <td>${Math.round(persen_diputus_perusahaan || 0)}%</td>
                            </tr>
                            <tr>
                                <td>End Contract - Perusahaan</td>
                                <td>${response.habis_perusahaan || 0}</td>
                                <td>${Math.round(persen_habis_perusahaan || 0)}%</td>
                            </tr>
                            <tr>
                                <td>End Contract - Pribadi</td>
                                <td>${response.habis_pribadi || 0}</td>
                                <td>${Math.round(persen_habis_pribadi || 0)}%</td>
                            </tr>
                            <tr>
                                <td>Resign</td>
                                <td>${response.resign || 0}</td>
                                <td>${Math.round(persen_resign || 0)}%</td>
                            </tr>`;
                
                $("#dashboard_3").html(html);
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }

    function dashboard_4(start,end,company_id) {
        $.ajax({
            url: `${baseurl}/dashboard_4`,
            type: 'POST',
            dataType: 'json',
            data: {
                start: start,
                end: end,
                company_id: company_id
            },
            beforeSend: function() {

            },
            success: function(response) {
                var html = ``;

                if (response.length > 0) {
                    var total = 0;
                    response.forEach(item => {
                        total += parseInt(item.mp)
                    });
                    response.forEach(item => {
                        var persen = (item.mp/total) * 100
                        html += `<tr>
                            <td>${item.category}</td>
                            <td>${item.reason}</td>
                            <td>${item.mp}</td>
                            <td>${Math.round(persen || 0)}%</td>
                        </tr>`
                    });
                } else {
                    html += `<tr><td colspan="4" class="text-center">Tidak ada data</td></tr>`
                }
                
                $("#dashboard_4").html(html);
                $('#foot_dashboard_4').html(`<tr>
                                    <th colspan="2" class="text-end">Total</th>
                                    <th>${total || 0}</th>
                                </tr>`);
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }
</script>