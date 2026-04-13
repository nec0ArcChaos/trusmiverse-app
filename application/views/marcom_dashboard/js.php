<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">
</link>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<!-- sweetalert -->
<script src="https://trusmiverse.com/apps/assets/js/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    const baseUrl = "<?= base_url('marcom_post'); ?>";
    let tableUser;

    $(document).ready(function() {

        setDefaultDateRange();
        loadSummary();
        renderUserPerformance();
        loadTopPIC();
        loadPeriodeChart();
        loadPlatformComparison();
        loadERChart();

        $('#btn_filter_dashboard').on('click', function() {
            loadSummary();
            renderUserPerformance();
            loadTopPIC();
            loadPeriodeChart();
            loadPlatformComparison();
            loadERChart();
        });


        // tableUser.on('draw', function() {
        //     animateCounters();
        // });
    });

    let tableUserDetail;

    $('#table_user_performance').on('click', '.btn-view-detail', function() {

        let userId = $(this).data('user');

        let start = $('#filter_start_date').val();
        let end = $('#filter_end_date').val();

        $('#modalUserDetail').modal('show');

        if ($.fn.DataTable.isDataTable('#table_user_detail')) {
            $('#table_user_detail').DataTable().destroy();
        }

        $('#table_user_detail').DataTable({

            ajax: {
                url: baseUrl + '/get_user_detail',
                type: 'GET',
                data: {
                    user_id: userId,
                    start_date: start,
                    end_date: end
                }
            },

            columns: [

                {
                    data: 'post_date'
                },

                {
                    data: 'platform_name',
                    render: function(data) {
                        if (data === 'Instagram') {
                            return `
                            <span class="platform-badge badge-ig">
                                <i class="bi bi-instagram"></i> IG
                            </span>
                        `;
                        }
                        if (data === 'Tiktok') {
                            return `
                            <span class="platform-badge badge-tt">
                                <i class="bi bi-tiktok"></i> TT
                            </span>
                        `;
                        }
                        return data;
                    }
                },

                {
                    data: 'account_name'
                },
                {
                    data: 'content_type_name'
                },
                {
                    data: 'title'
                },

                {
                    data: null,
                    render: function(data) {
                        return `
                        <div class="stats-wrapper">
                            <div class="stat-pill stat-views">
                                <i class="bi bi-eye-fill"></i> ${formatNumber(data.views)}
                            </div>
                            <div class="stat-pill stat-likes">
                                <i class="bi bi-heart-fill"></i> ${formatNumber(data.likes)}
                            </div>
                            <div class="stat-pill stat-comments">
                                <i class="bi bi-chat-fill"></i> ${formatNumber(data.comments)}
                            </div>
                            <div class="stat-pill stat-shares">
                                <i class="bi bi-share-fill"></i> ${formatNumber(data.shares)}
                            </div>
                        </div>
                    `;
                    }
                },

                {
                    data: 'post_link',
                    render: function(data) {
                        return `
                        <a href="${data}" target="_blank"
                           class="btn btn-sm btn-outline-primary">
                           <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    `;
                    }
                }

            ]

        });

    });

    function formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    function animateCounters() {

        $('.counter').each(function() {

            let $this = $(this);
            let target = parseInt($this.data('value'));
            let current = 0;
            let duration = 800;
            let stepTime = 15;
            let steps = duration / stepTime;
            let increment = target / steps;

            let interval = setInterval(function() {

                current += increment;

                if (current >= target) {
                    current = target;
                    clearInterval(interval);
                }

                $this.text(formatNumber(Math.floor(current)));

            }, stepTime);

        });
    }

    function setDefaultDateRange() {

        let start = moment().startOf('month').format('YYYY-MM-DD');
        let end = moment().format('YYYY-MM-DD');

        $('#filter_start_date').val(start);
        $('#filter_end_date').val(end);
    }

    function loadTopPIC() {

        let start = $('#filter_start_date').val();
        let end = $('#filter_end_date').val();

        $.get(baseUrl + '/get_top_pic', {
            start_date: start,
            end_date: end
        }, function(res) {

            let html = '';

            res.forEach(function(item, index) {

                html += `
                <div class="d-flex justify-content-between mb-2">
                    <div>
                        <strong>#${index+1} ${item.user_name}</strong>
                    </div>
                    <div>
                        ${formatNumber(item.total_engagement)}
                    </div>
                </div>
            `;
            });

            $('#top_pic_container').html(html);

        }, 'json');
    }

    function loadSummary() {

        let start = $('#filter_start_date').val();
        let end = $('#filter_end_date').val();

        if (!start || !end) {
            alert('Tanggal belum lengkap');
            return;
        }

        if (moment(start).isAfter(end)) {
            alert('Start date tidak boleh lebih besar dari end date');
            return;
        }

        $.ajax({
            url: baseUrl + '/get_summary',
            type: 'GET',
            data: {
                start_date: start,
                end_date: end
            },
            dataType: 'json',
            beforeSend: function() {
                $('#ig_total_views').text('...');
                $('#tt_total_views').text('...');
            },
            success: function(res) {

                // Instagram
                animateCounter('#ig_total_views', res.instagram.views);
                animateCounter('#ig_total_likes', res.instagram.likes);
                animateCounter('#ig_total_comments', res.instagram.comments);

                // TikTok
                animateCounter('#tt_total_views', res.tiktok.views);
                animateCounter('#tt_total_likes', res.tiktok.likes);
                animateCounter('#tt_total_shares', res.tiktok.shares);
                animateCounter('#tt_total_saves', res.tiktok.saves);

            }
        });
    }

    function animateCounter(element, target, duration = 1500) {

        let start = 0;
        let startTime = null;

        target = parseInt(target) || 0;

        function animation(currentTime) {

            if (!startTime) startTime = currentTime;

            let progress = currentTime - startTime;
            let percent = Math.min(progress / duration, 1);

            let value = Math.floor(percent * target);

            $(element).text(formatNumber(value));

            if (progress < duration) {
                requestAnimationFrame(animation);
            } else {
                $(element).text(formatNumber(target));
            }
        }

        requestAnimationFrame(animation);
    }


    let tableUserPerformance;

    function renderUserPerformance() {

        let start = $('#filter_start_date').val();
        let end = $('#filter_end_date').val();

        if ($.fn.DataTable.isDataTable('#table_user_performance')) {
            tableUserPerformance.destroy();
        }

        tableUserPerformance = $('#table_user_performance').DataTable({

            ajax: {
                url: baseUrl + '/get_user_performance',
                type: 'GET',
                data: {
                    start_date: start,
                    end_date: end
                }
            },

            processing: true,
            searching: true,
            paging: true,
            info: true,
            ordering: false,

            columns: [

                // USER
                {
                    data: 'user_name'
                },

                // TOTAL POSTS
                {
                    data: 'total_posts',
                    render: function(data) {
                        return `<span class="badge bg-secondary">${data}</span>`;
                    }
                },

                // INSTAGRAM
                {
                    data: null,
                    render: function(data) {

                        return `
                        <div class="user-stat-wrapper">
                            <div class="user-stat-item stat-view">
                                <i class="bi bi-eye-fill"></i>
                                ${formatNumber(data.ig_views)}
                            </div>
                            <div class="user-stat-item stat-like">
                                <i class="bi bi-heart-fill"></i>
                                ${formatNumber(data.ig_likes)}
                            </div>
                        </div>
                    `;
                    }
                },

                // TIKTOK
                {
                    data: null,
                    render: function(data) {

                        return `
                        <div class="user-stat-wrapper">
                            <div class="user-stat-item stat-view">
                                <i class="bi bi-eye-fill"></i>
                                ${formatNumber(data.tt_views)}
                            </div>
                            <div class="user-stat-item stat-like">
                                <i class="bi bi-heart-fill"></i>
                                ${formatNumber(data.tt_likes)}
                            </div>
                        </div>
                    `;
                    }
                },

                // ACTION
                {
                    data: 'created_by',
                    render: function(data) {
                        return `
                        <button class="btn btn-sm btn-primary btn-view-detail"
                                data-user="${data}">
                            <i class="bi bi-eye"></i> Detail
                        </button>
                    `;
                    }
                }

            ]

        });
    }

    let chart;

    function loadPeriodeChart() {

        let start = $('#filter_start_date').val();
        let end = $('#filter_end_date').val();

        $.get(baseUrl + '/get_summary_periode', {
            start_date: start,
            end_date: end
        }, function(res) {

            let categories = [];
            let views = [];
            let engagement = [];

            res.forEach(function(item) {
                categories.push(item.periode);
                views.push(parseInt(item.total_views));
                engagement.push(parseInt(item.total_engagement));
            });

            if (chart) chart.destroy();

            chart = new ApexCharts(document.querySelector("#chart_periode"), {
                chart: {
                    type: 'area',
                    height: 350
                },
                series: [{
                        name: 'Views',
                        data: views
                    },
                    {
                        name: 'Engagement',
                        data: engagement
                    }
                ],
                xaxis: {
                    categories: categories
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                }
            });

            chart.render();

        }, 'json');
    }

    let chartPlatform;

    function loadPlatformComparison() {

        let start = $('#filter_start_date').val();
        let end = $('#filter_end_date').val();

        $.get(baseUrl + '/get_platform_comparison', {
            start_date: start,
            end_date: end
        }, function(res) {

            let categories = [];
            let views = [];
            let engagement = [];

            res.forEach(function(item) {
                categories.push(item.platform_name);
                views.push(parseInt(item.total_views));
                engagement.push(parseInt(item.total_engagement));
            });

            if (chartPlatform) chartPlatform.destroy();

            chartPlatform = new ApexCharts(document.querySelector("#chart_platform_comparison"), {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                        name: 'Views',
                        data: views
                    },
                    {
                        name: 'Engagement',
                        data: engagement
                    }
                ],
                xaxis: {
                    categories: categories
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '50%'
                    }
                }
            });

            chartPlatform.render();

        }, 'json');
    }

    let chartER;

    function loadERChart() {

        let start = $('#filter_start_date').val();
        let end = $('#filter_end_date').val();

        $.get(baseUrl + '/get_er_per_account', {
            start_date: start,
            end_date: end
        }, function(res) {

            let categories = [];
            let erValues = [];

            res.forEach(function(item) {
                categories.push(item.account_name);
                erValues.push(parseFloat(item.er).toFixed(2));
            });

            if (chartER) chartER.destroy();

            chartER = new ApexCharts(document.querySelector("#chart_er_account"), {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: 'ER %',
                    data: erValues
                }],
                xaxis: {
                    categories: categories
                },
                dataLabels: {
                    formatter: function(val) {
                        return val + "%";
                    }
                }
            });

            chartER.render();

        }, 'json');
    }
</script>