<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
    $(document).ready(function() {

        var divisi = $('#select_divisi').val();

        var startCalendar = $("#startCalendar").val();
        var endCalendar = $("#endCalendar").val();
        if (!startCalendar || !endCalendar) {
            var date = new Date();
            var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
            firstDay.setDate(firstDay.getDate() + 1);
            var currentDay = date;
            startCalendar = firstDay.toISOString().split('T')[0];
            endCalendar = currentDay.toISOString().split('T')[0];
        }

        // console.log('Content 2 : ', divisi, startCalendar, endCalendar);

        pie_one(divisi, startCalendar, endCalendar);
        pie_operasional(divisi, startCalendar, endCalendar);
        pie_produksi(divisi, startCalendar, endCalendar);
        pie_hr(divisi, startCalendar, endCalendar);
        pie_ecommerce(divisi, startCalendar, endCalendar);
        pie_marcomm(divisi, startCalendar, endCalendar);
        pie_mini(divisi, startCalendar, endCalendar);
        pie_riset(divisi, startCalendar, endCalendar);

        get_data_poin_check_bt(divisi, startCalendar, endCalendar);
        get_data_prs_bt(divisi, startCalendar, endCalendar);

        data_support(divisi, startCalendar, endCalendar);
        if (<?= $id_company ?> == 5) {
            get_data_warning_manpower(divisi, startCalendar, endCalendar);
        }
    });


    function get_data_prs_bt(divisi, start,end) {
        $.ajax({
            type: "POST",
            url: base_url + "/data_persen_bt",
            data: {
                divisi: divisi,
                start: start,
                end: end
            },
            dataType: "json",
            success: function(response) {
                pie_operasional(response.prs_bt);
                pie_produksi(response.prs_bt);
                pie_riset(response.prs_bt);
            }
        });
    }

    
    function get_color_pie(progress) {
        if (progress < 70) return '#FD97A4'; // Red
        if (progress >= 70 && progress < 85) return '#FFEC8F'; // Yellow
        return '#C9EE8F'; // Green
    }

    function pie_operasional(data_prs_bt) {
        $('#chart_pie_operasional').empty().append(`
            <canvas id="pie_operasional" style="width: 75px;"></canvas>`);
        const ctx = document.getElementById('pie_operasional');

        var pie_color = get_color_pie(data_prs_bt.prs_ops);
        const doughnutPointer = {
            id: 'doughnutPointer',
            afterDatasetsDraw(chart, args, plugins) {
                const {
                    ctx,
                    data
                } = chart;

                ctx.save();

                const xCenter           = chart.getDatasetMeta(0).data[0].x;
                const yCenter           = chart.getDatasetMeta(0).data[0].y;
                const innerRadius       = chart.getDatasetMeta(0).data[0].innerRadius;
                const outerRadius       = chart.getDatasetMeta(0).data[0].outerRadius;
                const doughnutThickness = outerRadius - innerRadius;
                const angle             = Math.PI / 180;

                // achieve
                ctx.font            = 'bold 20px sans-serif';
                ctx.fillStyle       = '#8D8D8D';
                ctx.textAlign       = 'center';
                ctx.textBaseline    = 'middle';
                ctx.fillText(data_prs_bt.prs_ops + '%', xCenter, yCenter - 5);
            }
        }

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Achieved',
                    'Sisa'
                ],
                datasets: [{
                        data: [
                            data_prs_bt.prs_ops,
                            100-data_prs_bt.prs_ops,
                        ],
                        // data: [
                        //     80,
                        //     20
                        // ],
                        borderColor: [pie_color, '#F3F2F2'],
                        backgroundColor: [pie_color, '#F3F2F2'],
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

    function pie_produksi(data_prs_bt) {
        $('#chart_pie_produksi').empty().append(`
            <canvas id="pie_produksi" style="width: 75px;"></canvas>`);
        const ctx = document.getElementById('pie_produksi');

        var pie_color = get_color_pie(data_prs_bt.prs_pro);
        
        const doughnutPointer = {
            id: 'doughnutPointer',
            afterDatasetsDraw(chart, args, plugins) {
                const {
                    ctx,
                    data
                } = chart;

                ctx.save();

                const xCenter           = chart.getDatasetMeta(0).data[0].x;
                const yCenter           = chart.getDatasetMeta(0).data[0].y;
                const innerRadius       = chart.getDatasetMeta(0).data[0].innerRadius;
                const outerRadius       = chart.getDatasetMeta(0).data[0].outerRadius;
                const doughnutThickness = outerRadius - innerRadius;
                const angle             = Math.PI / 180;

                // achieve
                ctx.font            = 'bold 20px sans-serif';
                ctx.fillStyle       = '#8D8D8D';
                ctx.textAlign       = 'center';
                ctx.textBaseline    = 'middle';
                // ctx.fillText(data_prs_bt.prs_pro + '%', xCenter, yCenter);
                ctx.fillText(0 + '%', xCenter, yCenter);
            }
        }

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Done',
                    'Not Start',
                ],
                datasets: [{
                        // data: [
                        //     data_prs_bt.prs_pro,
                        //     100-data_prs_bt.prs_pro,
                        // ],
                        data: [
                            0,
                            0
                        ],
                        borderColor: [pie_color, '#F3F2F2'],
                        backgroundColor: [pie_color, '#F3F2F2'],
                        cutout: '75%',
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

    function pie_hr(data_hr) {
        $('#chart_pie_hr').empty().append(`
            <canvas id="pie_hr" style="width: 75px;"></canvas>`);
        const ctx = document.getElementById('pie_hr');

        var pie_color = get_color_pie(data_hr.prs_hr);
        const doughnutPointer = {
            id: 'doughnutPointer',
            afterDatasetsDraw(chart, args, plugins) {
                const {
                    ctx,
                    data
                } = chart;

                ctx.save();

                const xCenter           = chart.getDatasetMeta(0).data[0].x;
                const yCenter           = chart.getDatasetMeta(0).data[0].y;
                const innerRadius       = chart.getDatasetMeta(0).data[0].innerRadius;
                const outerRadius       = chart.getDatasetMeta(0).data[0].outerRadius;
                const doughnutThickness = outerRadius - innerRadius;
                const angle             = Math.PI / 180;

                // achieve
                ctx.font            = 'bold 20px sans-serif';
                ctx.fillStyle       = '#8D8D8D';
                ctx.textAlign       = 'center';
                ctx.textBaseline    = 'middle';
                ctx.fillText('0%', xCenter, yCenter);
            }
        }

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Done',
                    'Not Start',
                ],
                datasets: [{
                        // data: [
                        //     data_operasional.sales,
                        //     data_operasional.basket,
                        // ],
                        data: [
                            data_hr.prs_hr,
                            100-data_hr.prs_hr,
                        ],
                        borderColor: [pie_color, '#F3F2F2'],
                        backgroundColor: [pie_color, '#F3F2F2'],
                        cutout: '75%',
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

    function pie_ecommerce(data_ecommerce) {
        $('#chart_pie_ecommerce').empty().append(`
            <canvas id="pie_ecommerce" style="width: 75px;"></canvas>`);
        const ctx = document.getElementById('pie_ecommerce');

        var pie_color = get_color_pie(data_ecommerce.prs_ecom);
        const doughnutPointer = {
            id: 'doughnutPointer',
            afterDatasetsDraw(chart, args, plugins) {
                const {
                    ctx,
                    data
                } = chart;

                ctx.save();

                const xCenter           = chart.getDatasetMeta(0).data[0].x;
                const yCenter           = chart.getDatasetMeta(0).data[0].y;
                const innerRadius       = chart.getDatasetMeta(0).data[0].innerRadius;
                const outerRadius       = chart.getDatasetMeta(0).data[0].outerRadius;
                const doughnutThickness = outerRadius - innerRadius;
                const angle             = Math.PI / 180;

                // achieve
                ctx.font            = 'bold 20px sans-serif';
                ctx.fillStyle       = '#8D8D8D';
                ctx.textAlign       = 'center';
                ctx.textBaseline    = 'middle';
                ctx.fillText('0%', xCenter, yCenter);
            }
        }

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Done',
                    'Not Start',
                ],
                datasets: [{
                        // data: [
                        //     data_operasional.sales,
                        //     data_operasional.basket,
                        // ],
                        data: [
                            data_ecommerce.prs_ecom,
                            100-data_ecommerce.prs_ecom,
                        ],
                        borderColor: [pie_color, '#F3F2F2'],
                        backgroundColor: [pie_color, '#F3F2F2'],
                        cutout: '75%',
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

    function pie_marcomm(data_marcomm) {
        $('#chart_pie_marcomm').empty().append(`
            <canvas id="pie_marcomm" style="width: 75px;"></canvas>`);
        const ctx = document.getElementById('pie_marcomm');

        var pie_color = get_color_pie(data_marcomm.prs_marcomm);

        const doughnutPointer = {
            id: 'doughnutPointer',
            afterDatasetsDraw(chart, args, plugins) {
                const {
                    ctx,
                    data
                } = chart;

                ctx.save();

                const xCenter           = chart.getDatasetMeta(0).data[0].x;
                const yCenter           = chart.getDatasetMeta(0).data[0].y;
                const innerRadius       = chart.getDatasetMeta(0).data[0].innerRadius;
                const outerRadius       = chart.getDatasetMeta(0).data[0].outerRadius;
                const doughnutThickness = outerRadius - innerRadius;
                const angle             = Math.PI / 180;

                // achieve
                ctx.font            = 'bold 20px sans-serif';
                ctx.fillStyle       = '#8D8D8D';
                ctx.textAlign       = 'center';
                ctx.textBaseline    = 'middle';
                ctx.fillText('0%', xCenter, yCenter);
            }
        }

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Done',
                    'Not Start',
                ],
                datasets: [{
                        // data: [
                        //     data_operasional.sales,
                        //     data_operasional.basket,
                        // ],
                        data: [
                            data_marcomm.prs_marcomm,
                            100-data_marcomm.prs_marcomm,
                        ],
                        borderColor: [pie_color, '#F3F2F2'],
                        backgroundColor: [pie_color, '#F3F2F2'],
                        cutout: '75%',
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

    function pie_mini(data_mini) {
        $('#chart_pie_mini').empty().append(`
            <canvas id="pie_mini" style="width: 75px;"></canvas>`);
        const ctx = document.getElementById('pie_mini');

        var pie_color = get_color_pie(data_mini.prs_mini);

        const doughnutPointer = {
            id: 'doughnutPointer',
            afterDatasetsDraw(chart, args, plugins) {
                const {
                    ctx,
                    data
                } = chart;

                ctx.save();

                const xCenter           = chart.getDatasetMeta(0).data[0].x;
                const yCenter           = chart.getDatasetMeta(0).data[0].y;
                const innerRadius       = chart.getDatasetMeta(0).data[0].innerRadius;
                const outerRadius       = chart.getDatasetMeta(0).data[0].outerRadius;
                const doughnutThickness = outerRadius - innerRadius;
                const angle             = Math.PI / 180;

                // achieve
                ctx.font            = 'bold 20px sans-serif';
                ctx.fillStyle       = '#8D8D8D';
                ctx.textAlign       = 'center';
                ctx.textBaseline    = 'middle';
                ctx.fillText('0%', xCenter, yCenter);
            }
        }

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Done',
                    'Not Start',
                ],
                datasets: [{
                        // data: [
                        //     data_operasional.sales,
                        //     data_operasional.basket,
                        // ],
                        data: [
                            data_mini.prs_mini,
                            100-data_mini.prs_mini,
                        ],
                        borderColor: [pie_color, '#F3F2F2'],
                        backgroundColor: [pie_color, '#F3F2F2'],
                        cutout: '75%',
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

    function pie_riset(data_prs_bt) {
        $('#chart_pie_riset').empty().append(`
            <canvas id="pie_riset" style="width: 75px;"></canvas>`);
        const ctx = document.getElementById('pie_riset');

        var pie_color = get_color_pie(data_prs_bt.prs_rs);
        
        const doughnutPointer = {
            id: 'doughnutPointer',
            afterDatasetsDraw(chart, args, plugins) {
                const {
                    ctx,
                    data
                } = chart;

                ctx.save();

                const xCenter           = chart.getDatasetMeta(0).data[0].x;
                const yCenter           = chart.getDatasetMeta(0).data[0].y;
                const innerRadius       = chart.getDatasetMeta(0).data[0].innerRadius;
                const outerRadius       = chart.getDatasetMeta(0).data[0].outerRadius;
                const doughnutThickness = outerRadius - innerRadius;
                const angle             = Math.PI / 180;

                // achieve
                ctx.font            = 'bold 20px sans-serif';
                ctx.fillStyle       = '#8D8D8D';
                ctx.textAlign       = 'center';
                ctx.textBaseline    = 'middle';
                // ctx.fillText(data_prs_bt.prs_rs + '%', xCenter, yCenter);
                ctx.fillText(0 + '%', xCenter, yCenter);
            }
        }

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Done',
                    'Not Start',
                ],
                datasets: [{
                        // data: [
                        //     data_prs_bt.prs_rs,
                        //     100-data_prs_bt.prs_rs,
                        // ],
                        data: [
                            0,
                            0
                        ],
                        borderColor: [pie_color, '#F3F2F2'],
                        backgroundColor: [pie_color, '#F3F2F2'],
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


    function pie_mom(jumlah, persen) {
        $('#chart_pie_mom').empty().append(`
            <canvas id="pie_mom" style="width: 50px;"></canvas>`);
        const ctx = document.getElementById('pie_mom');

        var pie_color = get_color_pie(persen);

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
                ctx.font = 'bold 16px sans-serif';
                ctx.fillStyle = '#626262';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(jumlah, xCenter, yCenter);

                ctx.font = 'bold 9px sans-serif';
                ctx.fillText('0%', xCenter, yCenter + 13);

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
                        // data: [
                        //     data_mom.done,
                        //     data_mom.waiting,

                        // ],
                        data: [
                            persen,
                            100-persen,

                        ],
                        borderColor: [pie_color, '#F3F2F2'],
                        backgroundColor: [pie_color, '#F3F2F2'],
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

    function pie_problem(jumlah, persen) {
        console.log(jumlah);
        
        $('#chart_pie_problem').empty().append(`
            <canvas id="pie_problem" style="width: 50px;"></canvas>`);
        const ctx = document.getElementById('pie_problem');

        var pie_color = get_color_pie(persen);

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
                ctx.font = 'bold 16px sans-serif';
                ctx.fillStyle = '#626262';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(jumlah, xCenter, yCenter);

                ctx.font = 'bold 9px sans-serif';
                ctx.fillText('0%', xCenter, yCenter + 13);

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
                        // data: [
                        //     data_mom.done,
                        //     data_mom.waiting,

                        // ],
                        data: [
                            persen,
                            100-persen,

                        ],
                        borderColor: [pie_color, '#F3F2F2'],
                        backgroundColor: [pie_color, '#F3F2F2'],
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

    function pie_one(jumlah, persen) {
        $('#chart_pie_one').empty().append(`
            <canvas id="pie_one" style="width: 50px;"></canvas>`);
        const ctx = document.getElementById('pie_one');

        var pie_color = get_color_pie(persen);

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
                ctx.font = 'bold 16px sans-serif';
                ctx.fillStyle = '#626262';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(jumlah, xCenter, yCenter);

                ctx.font = 'bold 9px sans-serif';
                ctx.fillText('0%', xCenter, yCenter + 13);

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
                        // data: [
                        //     data_mom.done,
                        //     data_mom.waiting,

                        // ],
                        data: [
                            persen,
                            100-persen,

                        ],
                        borderColor: [pie_color, '#F3F2F2'],
                        backgroundColor: [pie_color, '#F3F2F2'],
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


    // content 2
    function formatAngka(angka) {
        // Jika angka null atau undefined, kembalikan "0" sebagai string
        if (angka == null || isNaN(angka)) {
            angka = "0";
        }

        // Pastikan angka dikonversi ke number terlebih dahulu
        // let angka = Number(angka);

        // // Jika hasil konversi bukan angka (NaN), kembalikan "0"
        // if (isNaN(angka)) {
        //     angka = "0";
        // }

        if (angka >= 1_000_000_000_000) {
            return (angka / 1_000_000_000_000).toFixed(2) + 'T'; // Triliun
        } else if (angka >= 1_000_000_000) {
            return (angka / 1_000_000_000).toFixed(2) + 'M'; // Miliar
        } else if (angka >= 1_000_000) {
            return (angka / 1_000_000).toFixed(2) + 'J'; // Jutaan
        } else if (angka >= 100_000) {
            return (angka / 1_000).toFixed(0) + 'Rb'; // Ratusan Ribu
        } else if (angka >= 10_000) {
            return (angka / 1_000).toFixed(1) + 'Rb'; // Puluhan Ribu
        } else {
            // Return angka dalam format ribuan biasa, misal 123456 akan menjadi 123.456
            return angka.toLocaleString(); // Format ribuan biasa
        }
    }

    function get_color_progress(prs) {
        if (prs < 70) {
            return 'bg-soft-red';
        } else if (prs >= 70 && prs < 85) {
            return 'bg-soft-yellow';
        } else {
            return 'bg-soft-green';
        }
    }

    function get_data_poin_check_bt(divisi, start,end)
    {
        $.ajax({
            type: "POST",
            url: base_url + "data_poin_check_bt",
            data: {
                divisi: divisi,
                start: start,
                end: end
            },
            dataType: "json",
            // beforeSend: function(response){
            //     $('#list_content2').empty().append(`
            //         <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            //             <div class="spinner-border text-primary" role="status">
            //                 <span class="visually-hidden">Loading...</span>
            //             </div>
            //         </div>
            //     `);
            // },
            success: function(response) {

                // $('#list_content2').empty();

                console.log(response);
            
                // operasional
                // $('#sales').text(response.bt.act_sales + ' / '+response.bt.tgt_sales);
                $('#sales').text(formatAngka(response.bt.act_sales) + ' / ' + formatAngka(response.bt.tgt_sales));
                $('#sales').css('width', response.bt.prs_sales + '%');
                $('#sales').addClass(get_color_progress(response.bt.prs_sales));
                $('#basket_size').text(response.bt.act_basket + ' / '+response.bt.tgt_basket);
                $('#basket_size').css('width', response.bt.prs_basket + '%');
                $('#basket_size').addClass(get_color_progress(response.bt.prs_basket));
                $('#transaksi').text(response.bt.act_transaksi + ' / '+response.bt.tgt_transaksi);
                $('#transaksi').css('width', response.bt.prs_transaksi + '%');
                $('#transaksi').addClass(get_color_progress(response.bt.prs_transaksi));
                // $('#sales_s').text(response.bt.m_act_sales + ' / '+response.bt.m_tgt_sales);
                $('#sales_m').text(formatAngka(response.bt.act_m_sales) + ' / ' + formatAngka(response.bt.tgt_m_sales));
                $('#sales_m').css('width', response.bt.prs_m_sales + '%');
                $('#sales_m').addClass(get_color_progress(response.bt.prs_m_sales));
                $('#sales_l').text(formatAngka(response.bt.act_l_sales) + ' / ' + formatAngka(response.bt.tgt_l_sales));
                $('#sales_l').css('width', response.bt.prs_l_sales + '%');
                $('#sales_l').addClass(get_color_progress(response.bt.prs_l_sales));
                $('#sales_y').text(formatAngka(response.bt.act_y_sales) + ' / ' + formatAngka(response.bt.tgt_y_sales));
                $('#sales_y').css('width', response.bt.prs_y_sales + '%');
                $('#sales_y').addClass(get_color_progress(response.bt.prs_y_sales));

                // produksi
                // $('#keamanan_stok').text(response.bt.act_keamanan + '%' + ' / '+response.bt.tgt_keamanan + '%');
                // $('#keamanan_stok').css('width', response.bt.prs_keamanan + '%');
                // $('#keamanan_stok').addClass(get_color_progress(response.bt.prs_keamanan));
                // $('#leadtime_po').text(response.bt.act_leadtime_po + '%' + ' / '+response.bt.tgt_leadtime_po + '%');    
                // $('#leadtime_po').css('width', response.bt.prs_leadtime_po + '%');  
                // $('#leadtime_po').addClass(get_color_progress(response.bt.prs_leadtime_po));
                // $('#tingkat_reject').text(response.bt.act_tingkat_reject + '%' + ' / '+response.bt.tgt_tingkat_reject + '%');
                // $('#tingkat_reject').css('width', response.bt.prs_tingkat_reject + '%');
                // $('#tingkat_reject').addClass(get_color_progress(response.bt.prs_tingkat_reject));
                // $('#produk_baru').text(response.bt.act_produk_baru + '%' + ' / '+response.bt.tgt_produk_baru + '%');
                // $('#produk_baru').css('width', response.bt.prs_produk_baru + '%');
                // $('#produk_baru').addClass(get_color_progress(response.bt.prs_produk_baru));

                $('#keamanan_stok').text(0 + '%' + ' / '+ 0 + '%');
                $('#keamanan_stok').css('width', 0 + '%');
                $('#keamanan_stok').addClass(get_color_progress(0));
                $('#leadtime_po').text(0 + '%' + ' / '+ 0 + '%');    
                $('#leadtime_po').css('width', 0 + '%');  
                $('#leadtime_po').addClass(get_color_progress(0));
                $('#tingkat_reject').text(0 + '%' + ' / '+ 0 + '%');
                $('#tingkat_reject').css('width', 0 + '%');
                $('#tingkat_reject').addClass(get_color_progress(0));
                $('#produk_baru').text(0 + '%' + ' / '+ 0 + '%');
                $('#produk_baru').css('width', 0 + '%');
                $('#produk_baru').addClass(get_color_progress(0));

                // hr
                $('#recruitment').text(0);
                $('#recruitment').css('width', '0%');
                $('#recruitment').addClass(get_color_progress(0));
                $('#training').text(0);
                $('#training').css('width', '0%');
                $('#training').addClass(get_color_progress(0));
                $('#od').text(0);
                $('#od').css('width', '0%');
                $('#od').addClass(get_color_progress(0));

                // ecomm
                $('#sales_e').text(0);
                $('#sales_e').css('width', '0%');
                $('#sales_e').addClass(get_color_progress(0));
                $('#transaksi_e').text(0);
                $('#transaksi_e').css('width', '0%');
                $('#transaksi_e').addClass(get_color_progress(0));
                $('#basket_size_e').text(0);
                $('#basket_size_e').css('width', '0%');
                $('#basket_size_e').addClass(get_color_progress(0));

                // marcom
                $('#awarness').text(0);
                $('#awarness').css('width', '0%');
                $('#awarness').addClass(get_color_progress(0));
                $('#traffic').text(0);
                $('#traffic').css('width', '0%');
                $('#traffic').addClass(get_color_progress(0));
                $('#lead').text(0);
                $('#lead').css('width', '0%');
                $('#lead').addClass(get_color_progress(0));
                $('#cost').text(0);
                $('#cost').css('width', '0%');
                $('#cost').addClass(get_color_progress(0));

                // mini factory
                $('#jml_produksi').text(0); 
                $('#jml_produksi').css('width', '0%');
                $('#jml_produksi').addClass(get_color_progress(0));
                $('#leadtime_po_m').text(0);
                $('#leadtime_po_m').css('width', '0%');
                $('#leadtime_po_m').addClass(get_color_progress(0));
                $('#tingkat_reject_m').text(0);
                $('#tingkat_reject_m').css('width', '0%');
                $('#tingkat_reject_m').addClass(get_color_progress(0));

                // riset
                // $('#leadtime').text(response.bt.act_leadtime + '%' + ' / '+response.bt.tgt_leadtime + '%'); 
                // $('#leadtime').css('width', response.bt.prs_leadtime + '%');
                // $('#leadtime').addClass(get_color_progress(response.bt.prs_leadtime));
                // $('#keberhasilan').text(response.bt.act_keberhasilan + '%' + ' / '+ response.bt.tgt_keberhasilan + '%');
                // $('#keberhasilan').css('width', response.bt.prs_keberhasilan + '%');
                // $('#keberhasilan').addClass(get_color_progress(response.bt.prs_keberhasilan));

                $('#leadtime').text(0 + '%' + ' / '+ 0 + '%'); 
                $('#leadtime').css('width', 0 + '%');
                $('#leadtime').addClass(get_color_progress(0));
                $('#keberhasilan').text(0 + '%' + ' / '+ 0 + '%');
                $('#keberhasilan').css('width', 0 + '%');
                $('#keberhasilan').addClass(get_color_progress(0));

                // operasional
                $('#prs_sales').text('Sales | ' + response.bt.prs_sales + '%');
                $('#prs_basket').text('Basket Size | ' + response.bt.prs_basket + '%');
                $('#prs_transaksi').text('Transaksi | ' + response.bt.prs_transaksi + '%');
                $('#prs_sales_l').text('Sales Last Month | ' + response.bt.prs_l_sales + '%');
                $('#prs_sales_y').text('Sales Last Year | ' + response.bt.prs_y_sales + '%');
                $('#prs_sales_m').text('Sales This Year | ' + response.bt.prs_m_sales + '%');
                
                // produksi
                // $('#prs_keamanan').text('Safety Stock | ' + response.bt.prs_keamanan + '%');
                // $('#prs_leadtime_po').text('Leadtime PO | ' + response.bt.prs_leadtime_po + '%');
                // $('#prs_tingkat_reject').text('Tingkat Reject | ' + response.bt.prs_tingkat_reject + '%');
                // $('#prs_produk_baru').text('Produk Baru | ' + response.bt.prs_produk_baru + '%');

                $('#prs_keamanan').text('Safety Stock | ' + 0 + '%');
                $('#prs_leadtime_po').text('Leadtime PO | ' + 0 + '%');
                $('#prs_tingkat_reject').text('Tingkat Reject | ' + 0 + '%');
                $('#prs_produk_baru').text('Produk Baru | ' + 0 + '%');

                // hr
                $('#prs_recruitment').text('Recruitment | ' + 0 + '%');
                $('#prs_training').text('Training | ' + 0 + '%');
                $('#prs_od').text('Dokumen / OD | ' + 0 + '%');

                // ecomm
                $('#prs_sales_e').text('Sales | ' + 0 + '%');
                $('#prs_transaksi_e').text('Transaksi | ' + 0 + '%');
                $('#prs_basket_e').text('Basket Size | ' + 0 + '%');

                // marcom
                $('#prs_awarness').text('Awarness | ' + 0 + '%');
                $('#prs_traffic').text('Traffic | ' + 0 + '%');
                $('#prs_lead').text('Lead | ' + 0 + '%');
                $('#prs_cost').text('Cost | ' + 0 + '%');

                // mini factory
                $('#prs_jml_produksi').text('Jumlah Produksi | ' + 0 + '%');
                $('#prs_leadtime_po_m').text('Leadtime PO | ' + 0 + '%');
                $('#prs_tingkat_reject_m').text('Tingkat Reject | ' + 0 + '%');

                // riset
                // $('#prs_leadtime').text('Leadtime | ' + response.bt.prs_leadtime + '%');
                // $('#prs_keberhasilan').text('Keberhasilan | ' + response.bt.prs_keberhasilan + '%');

                $('#prs_leadtime').text('Leadtime | ' + 0 + '%');
                $('#prs_keberhasilan').text('Keberhasilan | ' + 0 + '%');

            }
        });
    }

    function data_support(divisi, start,end){
        $.ajax({
            type: "POST",
            url: base_url+'data_support',
            data: {
                divisi:divisi,
                start:start,
                end:end
            },
            dataType: "json",
            success: function (response) {
                // console.log(response);
                $('#t_ibr').text(response.ibr_jumlah);
                $('#t_tt').text(response.tt_jumlah);
                $('#t_sharing').text(response.sharing_jumlah);
                $('#t_genba').text(response.gen_jumlah);
                $('#t_brief').text(response.brief_jumlah);
                pie_mom(response.mom_jumlah,response.mom_jumlah);
                pie_problem(response.solving_jumlah,response.solving_jumlah);
                pie_one(response.oneby_jumlah,response.oneby_jumlah);
                // $('#t_t_brief').text(response.brief_jumlah);
                $('#prs_ibr_jln_berhasil').text(response.persen_jln_berhasil);
                $('#prs_ibr_tdk_berhasil').text(response.persen_tdk_berhasil);
                $('#prs_ibr_tdk_jalan').text(response.persen_tdk_jalan);
                $('#prs_ibr_progres').text(response.persen_progres);
                $('#prs_ibr_belum').text(response.persen_belum);
                $('#prs_genba_jln_berhasil').text(response.gen_persen_jln_berhasil);
                $('#prs_genba_tdk_berhasil').text(response.gen_persen_tdk_berhasil);
                $('#prs_genba_tdk_jalan').text(response.gen_persen_tdk_jalan);
                $('#prs_genba_progres').text(response.gen_persen_progres);
                $('#prs_genba_belum').text(response.gen_persen_belum);
                $('#d_ibr_jln_berhasil').text(response.ibr_jln_berhasil);
                $('#d_ibr_tdk_berhasil').text(response.ibr_tdk_berhasil);
                $('#d_ibr_tdk_jalan').text(response.ibr_tdk_jalan);
                $('#d_ibr_progres').text(response.ibr_progres);
                $('#d_ibr_belum').text(response.ibr_belum);
                $('#d_gen_jln_berhasil').text(response.gen_jln_berhasil);
                $('#d_gen_tdk_berhasil').text(response.gen_tdk_berhasil);
                $('#d_gen_tdk_jalan').text(response.gen_tdk_jalan);
                $('#d_gen_progres').text(response.gen_progres);
                $('#d_gen_belum').text(response.gen_belum);
            }
        });
    }




</script>