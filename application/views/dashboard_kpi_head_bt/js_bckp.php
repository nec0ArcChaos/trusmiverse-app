<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script>
    // Plugin untuk membuat background canvas transparan
    const transparentBackgroundPlugin = {
        id: 'transparentBackground',
        beforeDraw: (chart) => {
            const ctx = chart.canvas.getContext('2d');
            ctx.save();
            ctx.globalCompositeOperation = 'destination-over';
            ctx.fillStyle = 'transparent';
            ctx.fillRect(0, 0, chart.width, chart.height);
            ctx.restore();
        }
    };

    // Gauge Chart
    const ctxGauge = document.getElementById('gaugeChart').getContext('2d');

    // Plugin untuk teks + badge di tengah gauge2
    const gaugeTextPlugin = {
        id: 'gaugeTextPlugin',
        afterDraw(chart) {
            const {
                ctx,
                chartArea: {
                    width,
                    height
                }
            } = chart;
            const centerY = height - 70; // Naikkan posisi semua teks & badge

            ctx.save();
            ctx.textAlign = 'center';

            // Badge hijau ▲ 2%
            ctx.font = 'bold 12px Arial';
            ctx.fillStyle = '#28a745';
            ctx.beginPath();
            ctx.roundRect(width / 2 - 20, centerY - 60, 40, 20, 10);
            ctx.fill();
            ctx.fillStyle = '#fff';
            ctx.fillText('▲ 2%', width / 2, centerY - 45);

            // Hitung lebar total untuk persentase + teks
            ctx.font = 'bold 24px Arial';
            const percentText = '77%';
            const percentWidth = ctx.measureText(percentText).width;

            ctx.font = '12px Arial';
            const subText = '(441/575)';
            const subWidth = ctx.measureText(subText).width;

            const totalWidth = percentWidth + 6 + subWidth; // 6px jarak antar teks
            let startX = (width / 2) - (totalWidth / 2);

            // Gambar persentase
            ctx.font = 'bold 24px Arial';
            ctx.fillStyle = '#000';
            ctx.fillText(percentText, startX + percentWidth / 2, centerY - 7);

            // Gambar teks kecil
            ctx.font = '12px Arial';
            ctx.fillStyle = '#555';
            ctx.fillText(subText, startX + percentWidth + 6 + subWidth / 2, centerY - 7);

            ctx.restore();
        }
    };
    // const gaugeTextPlugin = {
    //     id: 'gaugeTextPlugin',
    //     afterDraw(chart) {
    //         const {
    //             ctx,
    //             chartArea: {
    //                 width,
    //                 height
    //             }
    //         } = chart;
    //         const centerX = width / 2;
    //         const centerY = height - 60;

    //         ctx.save();
    //         ctx.textAlign = 'center';

    //         // Badge hijau ▲ 2%
    //         ctx.font = 'bold 12px Arial';
    //         ctx.fillStyle = '#28a745';
    //         ctx.beginPath();
    //         ctx.roundRect(centerX - 20, centerY - 60, 40, 20, 10);
    //         ctx.fill();
    //         ctx.fillStyle = '#fff';
    //         ctx.fillText('▲ 2%', centerX, centerY - 45);

    //         // Persentase
    //         ctx.font = 'bold 24px Arial';
    //         ctx.fillStyle = '#000';
    //         ctx.fillText('77%', centerX, centerY - 15);

    //         // Sub teks
    //         ctx.font = '12px Arial';
    //         ctx.fillStyle = '#555';
    //         ctx.fillText('(441/575)', centerX, centerY + 5);

    //         ctx.restore();
    //     }
    // };

    // Gradient biru → hijau
    const gradient = ctxGauge.createLinearGradient(0, 0, 200, 0);
    gradient.addColorStop(0, '#007bff'); // biru
    gradient.addColorStop(1, '#28a745'); // hijau

    new Chart(ctxGauge, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [77, 23],
                backgroundColor: [gradient, '#e9ecef'],
                borderWidth: 0
            }]
        },
        options: {
            rotation: -90,
            circumference: 180,
            cutout: '75%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: false
                }
            }
        },
        plugins: [gaugeTextPlugin]
    });

    // new Chart(ctxGauge, {
    //     type: 'doughnut',
    //     data: {
    //         datasets: [{
    //             data: [77, 23],
    //             backgroundColor: ['#28a745', '#e9ecef'],
    //             borderWidth: 0
    //         }]
    //     },
    //     options: {
    //         rotation: -90,
    //         circumference: 180,
    //         cutout: '80%',
    //         plugins: {
    //             legend: {
    //                 display: false
    //             },
    //             tooltip: {
    //                 enabled: false
    //             }
    //         }
    //     },
    //     plugins: [transparentBackgroundPlugin]
    // });

    // Create gradient color
    // const gradient = ctxGauge.createLinearGradient(0, 0, 200, 0);
    // gradient.addColorStop(0, '#00c6ff'); // biru muda
    // gradient.addColorStop(1, '#0072ff'); // biru gelap

    // new Chart(ctxGauge, {
    //     type: 'doughnut',
    //     data: {
    //         datasets: [{
    //             data: [77, 23],
    //             backgroundColor: [gradient, '#e9ecef'],
    //             borderWidth: 0
    //         }]
    //     },
    //     options: {
    //         rotation: -90,
    //         circumference: 180,
    //         cutout: '75%',
    //         plugins: {
    //             legend: {
    //                 display: false
    //             },
    //             tooltip: {
    //                 enabled: false
    //             },
    //             // Custom text in center
    //             beforeDraw: (chart) => {
    //                 const {
    //                     width
    //                 } = chart;
    //                 const {
    //                     height
    //                 } = chart;
    //                 const ctx = chart.ctx;
    //                 ctx.restore();

    //                 // Main percentage text
    //                 ctx.font = "bold 28px Arial";
    //                 ctx.fillStyle = "#333";
    //                 ctx.textBaseline = "middle";
    //                 const text = "77%";
    //                 const textX = Math.round((width - ctx.measureText(text).width) / 2);
    //                 const textY = height / 1.45;
    //                 ctx.fillText(text, textX, textY);

    //                 // Sub text
    //                 ctx.font = "14px Arial";
    //                 ctx.fillStyle = "#888";
    //                 const subText = "(441/575)";
    //                 const subTextX = Math.round((width - ctx.measureText(subText).width) / 2);
    //                 ctx.fillText(subText, subTextX, textY + 20);

    //                 ctx.save();
    //             }
    //         }
    //     },
    //     plugins: [{
    //         id: 'centerText',
    //         beforeDraw(chart) {
    //             const {
    //                 width
    //             } = chart;
    //             const {
    //                 height
    //             } = chart;
    //             const ctx = chart.ctx;
    //             ctx.restore();

    //             // Main percentage text
    //             ctx.font = "bold 28px Arial";
    //             ctx.fillStyle = "#333";
    //             ctx.textBaseline = "middle";
    //             const text = "77%";
    //             const textX = Math.round((width - ctx.measureText(text).width) / 2);
    //             const textY = height / 1.45;
    //             ctx.fillText(text, textX, textY);

    //             // Sub text
    //             ctx.font = "14px Arial";
    //             ctx.fillStyle = "#888";
    //             const subText = "(441/575)";
    //             const subTextX = Math.round((width - ctx.measureText(subText).width) / 2);
    //             ctx.fillText(subText, subTextX, textY + 20);

    //             ctx.save();
    //         }
    //     }]
    // });

    // Line Chart
    const ctxTraffic = document.getElementById('trafficChart').getContext('2d');
    new Chart(ctxTraffic, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar'],
            datasets: [{
                    label: 'Sering',
                    data: [12, 19, 15],
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0,123,255,0.1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Jarang',
                    data: [10, 14, 12],
                    borderColor: '#6c757d',
                    backgroundColor: 'rgba(108,117,125,0.1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Tidak Sama Sekali',
                    data: [6, 9, 7],
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220,53,69,0.1)',
                    fill: true,
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
                    beginAtZero: true
                }
            }
        },
        plugins: [transparentBackgroundPlugin]
    });

    // Progress review system
    const progressValue = 30; // persen

    // Plugin untuk teks di tengah
    const centerText = {
        id: 'centerText',
        beforeDraw(chart) {
            const {
                ctx,
                chartArea: {
                    width,
                    height
                }
            } = chart;
            ctx.save();

            // Teks persentase
            ctx.font = 'bold 22px Arial';
            ctx.fillStyle = '#000';
            ctx.textBaseline = 'middle';
            const text = progressValue + '%';
            ctx.fillText(text, width / 2 - ctx.measureText(text).width / 2, height / 2 - 8);

            // Teks bawah
            ctx.font = '14px Arial';
            ctx.fillStyle = '#555';
            const subText = 'Progress Review';
            ctx.fillText(subText, width / 2 - ctx.measureText(subText).width / 2, height / 2 + 10);

            ctx.restore();
        }
    };

    const ctx2 = document.getElementById('progressChart').getContext('2d');

    // Buat gradien biru
    const gradient3 = ctx2.createLinearGradient(0, 0, 0, 150);
    gradient3.addColorStop(0, '#4facfe'); // biru muda
    gradient3.addColorStop(1, '#00f2fe'); // biru kehijauan

    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [progressValue, 100 - progressValue],
                backgroundColor: [
                    gradient3, // pakai gradien
                    'rgba(230, 230, 230, 0.3)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: false, // penting agar ukuran canvas dipakai
            cutout: '80%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: false
                }
            }
        },
        plugins: [centerText]
    });

    // Gauge Chart with gradient
    // const ctx = document.getElementById('progressGauge').getContext('2d');
    // const gradient2 = ctx.createLinearGradient(0, 0, 0, 200);
    // gradient2.addColorStop(0, '#4facfe'); // Biru muda
    // gradient2.addColorStop(1, '#005bea'); // Biru tua

    // new Chart(ctx, {
    //     type: 'doughnut',
    //     data: {
    //         datasets: [{
    //             data: [30, 70],
    //             backgroundColor: [gradient2, 'rgba(255,255,255,0.1)'],
    //             borderWidth: 0
    //         }]
    //     },
    //     options: {
    //         cutout: '80%',
    //         rotation: -90,
    //         circumference: 180,
    //         responsive: true,
    //         plugins: {
    //             legend: {
    //                 display: false
    //             },
    //             tooltip: {
    //                 enabled: false
    //             },
    //             beforeDraw: chart => {
    //                 const {
    //                     ctx,
    //                     chartArea: {
    //                         width,
    //                         height
    //                     }
    //                 } = chart;
    //                 ctx.save();
    //                 ctx.font = 'bold 24px Arial';
    //                 ctx.fillStyle = '#fff';
    //                 ctx.textAlign = 'center';
    //                 ctx.textBaseline = 'middle';
    //                 ctx.fillText('30%', width / 2, height / 2 - 10);
    //                 ctx.font = '14px Arial';
    //                 ctx.fillText('Done', width / 2, height / 2 + 10);
    //             }
    //         }
    //     },
    //     plugins: [{
    //         id: 'centerText',
    //         beforeDraw(chart) {
    //             const {
    //                 ctx,
    //                 chartArea: {
    //                     width,
    //                     height
    //                 }
    //             } = chart;
    //             ctx.save();
    //             ctx.font = 'bold 24px Arial';
    //             ctx.fillStyle = '#000';
    //             ctx.textAlign = 'center';
    //             ctx.textBaseline = 'middle';
    //             ctx.fillText('30%', width / 2, height / 2 - 10);
    //             ctx.font = '14px Arial';
    //             ctx.fillText('Done', width / 2, height / 2 + 10);
    //         }
    //     }]
    // });

    // Statistik Progres Tiket
    const progressValuex = 30; // persen

    // Plugin untuk teks di tengah
    const centerTextx = {
        id: 'centerText',
        beforeDraw(chart) {
            const {
                ctx,
                chartArea: {
                    width,
                    height
                }
            } = chart;
            ctx.save();

            // Teks persentase
            ctx.font = 'bold 22px Arial';
            ctx.fillStyle = '#000';
            ctx.textBaseline = 'middle';
            const text = progressValuex + '%';
            ctx.fillText(text, width / 2 - ctx.measureText(text).width / 2, height / 2 - 8);

            // Teks bawah
            ctx.font = '14px Arial';
            ctx.fillStyle = '#555';
            const subText = 'Done';
            ctx.fillText(subText, width / 2 - ctx.measureText(subText).width / 2, height / 2 + 10);

            ctx.restore();
        }
    };

    const ctx3 = document.getElementById('progressChartTicket').getContext('2d');

    // Buat gradien biru
    const gradientx = ctx3.createLinearGradient(0, 0, 0, 150);
    gradientx.addColorStop(0, '#4facfe'); // biru muda
    gradientx.addColorStop(1, '#00f2fe'); // biru kehijauan

    new Chart(ctx3, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [progressValuex, 100 - progressValuex],
                backgroundColor: [
                    gradientx, // pakai gradien
                    'rgba(230, 230, 230, 0.3)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: false, // penting agar ukuran canvas dipakai
            cutout: '80%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: false
                }
            }
        },
        plugins: [centerTextx]
    });
</script>