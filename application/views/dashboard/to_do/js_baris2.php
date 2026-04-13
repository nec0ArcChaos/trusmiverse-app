<script>
    $(document).ready(function() {
        var yearMonth = $('#select_month').val();
        var user_id = $('#filter_pic').val();
        fetchTaskData(yearMonth, user_id);
        fetchTaskPie(yearMonth, user_id);
    });

    function pie_task(done, undone) {
        let donee = parseInt(done) || 0;
        let undonee = parseInt(undone) || 0;

        // Hitung persentase aktual task
        let total = donee + undonee;
        let persentase_act_task = total > 0 ? ((donee / total) * 100).toFixed(1) : "0.0";

        // console.log('%=' + persentase_act_task);
        // Kosongkan dan tambahkan canvas baru
        $('#chart_pie_task').empty().append(`
            <canvas id="pie_task" style="width: 105px;"></canvas>
        `);
        const ctx = document.getElementById('pie_task');

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

                // Tampilkan persentase aktual task
                ctx.font = 'bold 20px sans-serif';
                ctx.fillStyle = '#7D89B3';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(`${persentase_act_task}%`, xCenter, yCenter);

                ctx.font = 'bold 14px sans-serif';
                ctx.fillText('Done', xCenter, yCenter + 15);
            }
        };

        // Buat chart
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Done', 'Undone'],
                datasets: [{
                    data: [done, undone],
                    borderColor: ['#7D89B3', '#D3D3D3'],
                    backgroundColor: ['#7D89B3', '#D3D3D3'],
                    cutout: '70%',
                    borderRadius: 10,
                    spacing: 5
                }]
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
                            return value + '%';
                        }
                    }
                }
            },
            plugins: [doughnutPointer]
        });
    }

    function line_task(label, data, undone) {
        $('#chart_line_task').empty().append(`
        <canvas id="line_task" style="width: 100%; max-height: 150px;"></canvas>
        `);
        var ctx = document.getElementById('line_task').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            plugins: [ChartDataLabels],
            data: {
                labels: label,
                datasets: [{
                        label: 'Done',
                        data: data,
                        borderColor: ['#7D89B3'],
                        backgroundColor: ['#7D89B3'],
                    },
                    {
                        label: 'Undone',
                        data: undone,
                        borderColor: [ 'rgb(201, 203, 207)' ],
                        backgroundColor: [ 'rgba(201, 203, 207, 0.4)' ],
                    },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // 🚀 Hides the legend
                    },
                    datalabels: {
                        anchor: 'end', // 🔥 Moves labels inside the bars to avoid getting cut off
                        align: 'top', // 🔥 Positions labels at the top of bars
                        offset: 1, // 🔥 Adds space above labels to prevent overlap
                        formatter: function(value) {
                            return formatNumber(value);
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        });
    }

    $(".range").datepicker({
        format: "yyyy-mm",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true
    });

    $('#select_month').change(function(e) {
        e.preventDefault();
        var yearMonth = $(this).val();
        var user_id = $('#filter_pic').val();
        console.log(user_id);

        fetchTaskData(yearMonth, user_id);
        fetchTaskPie(yearMonth, user_id);
    });

    function fetchTaskData(yearMonth, user_id) {
        $.ajax({
            url: "<?= base_url(); ?>dashboard_todo/get_task_resume",
            type: "POST", // Change to POST
            data: {
                yearMonth: yearMonth,
                user_id: user_id
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    
                    const labels = [];
                    const doneData = [];
                    const undoneData = [];
                    
                    response.data.forEach(item => {
                        console.log('data' + item.undone);

                        labels.push(item.nama);
                        doneData.push(parseInt(item.total) - parseInt(item.undone));
                        undoneData.push(parseInt(item.undone));
                    });

                    line_task(labels, doneData, undoneData);
                } else {
                    console.error("Error:", response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
            }
        });
    }

    function fetchTaskPie(yearMonth, user_id) {
        $.ajax({
            url: "<?= base_url(); ?>dashboard_todo/get_task_pie",
            type: "POST", // Change to POST
            data: {
                yearMonth: yearMonth,
                user_id: user_id
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {

                    const totalData = [];
                    const undoneData = [];

                    response.data.forEach(item => {
                        totalData.push(parseInt(item.total));
                        undoneData.push(parseInt(item.undone));
                    });
                    // console.log('data' + totalData);

                    pie_task(totalData - undoneData, undoneData);
                } else {
                    console.error("Error:", response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
            }
        });
    }
</script>