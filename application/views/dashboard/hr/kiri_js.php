<script>

	var chart = JSC.chart('chartDiv', { 
		debug: true, 
		type: 'gauge ', 
		legend_visible: false, 
		chartArea_boxVisible: false, 
		xAxis: { 
    /*Used to position marker on top of axis line.*/
			scale: { range: [0, 1], invert: true } 
		}, 
		palette: { 
			pointValue: '%yValue', 
			ranges: [ 
				{ value: 0, color: '#6C757D' }, 
				{ value: 30, color: '#FF5353' }, 
				{ value: 60, color: '#FFD221' }, 
				{ value: 80, color: '#77E6B4' }, 
				{ value: 100, color: '#21D683' } 
				] 
		}, 
		yAxis: { 
			defaultTick: { padding: 10, enabled: false }, 
			customTicks: [0, 30, 60, 80, 100], 
			line: { 
				width: 10, 
				breaks_gap: 0.03, 
				color: 'smartPalette'
			}, 
			scale: { range: [0, 100] } 
		}, 
		defaultSeries: { 
			opacity: 1, 
			shape: { 
				label: { 
					align: 'center', 
					verticalAlign: 'middle'
				} 
			} 
		}, 
		series: [ 
		{ 
			type: 'marker', 
			name: 'Score', 
			shape_label: { 
				text: 
				"<span style='fontSize: 23; color: #FF5353; font-family: var(--fontFamilyHGroup);'>48%</span><br/> <span style='fontSize: 23; color: #FF5353; font-family: var(--fontFamilyHGroup); font-weight: 600;'>Problem!</span>", 
				style: { fontSize: 23 } 
			}, 
			defaultPoint: { 
				tooltip: '%yValue', 
				marker: { 
					outline: { 
						width: 10, 
						color: 'currentColor'
					}, 
					fill: 'white', 
					type: 'circle', 
					visible: true, 
					size: 20 
				} 
			}, 
			points: [[1, 48]] 
		} 
		] 
	}); 


	$('#chart_bulanan').empty();
	const ctx_bulanan = document.getElementById('chart_bulanan');

	new Chart(ctx_bulanan, {
		type: 'bar',
		data: {
			labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'],
			datasets: [
			{
				label: 'Actual',
				data: [67, 83, 75, 88, 93],
				borderColor: ['#91C300'],
				backgroundColor: ['#91C300'],
				categoryPercentage : 0.5,
				datalabels: {
					color: '#6C91B4',
					anchor: 'start',
					align: 'bottom',
					clamp: true,
					offset: 1,
					font: {
						size: 10
					},
				}
			},
			{
				label: 'Target',
				data: [100, 100, 100, 100, 100],
				borderColor: ['#6C757D'],
				backgroundColor: ['#6C757D'],
				categoryPercentage : 0.8,
				grouped : false,
				datalabels: {
					color: 'rgba(34, 36, 38, 0.15)',
					anchor: 'start',
					align: 'bottom',
					clamp: false,
					offset: 1,
					font: {
						size: 6
					}
				}
			},
			]
		},
		plugins: [ChartDataLabels],
		options: {
			borderRadius: 1,
			scales: {
				y: {
					beginAtZero: true,
					ticks: {
						display: false
					}
				},
				x: {
					ticks: {
						padding: 15
					}
				},
			},
			plugins: {
				legend: {
					display: false,
					position: 'bottom',
				},


			},
		},

	});
</script>