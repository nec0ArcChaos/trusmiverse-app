<script>
    /* circular progress */
    var progressCirclesblue1 = new ProgressBar.Circle(document.getElementById('circleHealthScore'), {
        color: '#015EC2',
        // This has to be the same size as the maximum width to
        // prevent clipping
        strokeWidth: 10,
        trailWidth: 10,
        easing: 'easeInOut',
        trailColor: 'rgba(66, 157, 255, 0.15)',
        duration: 1400,
        text: {
            autoStyleContainer: false,
            style: {
                // Text color.
                // Default: same as stroke color (options.color)
                color: '#015EC2',
                position: 'absolute',
                left: '50%',
                top: '50%',
                padding: 0,
                margin: 0,
                // You can specify styles which will be browser prefixed
                transform: {
                    prefix: true,
                    value: 'translate(-50%, -50%)'
                }
            },
        },
        from: { color: '#015EC2', width: 10 },
        to: { color: '#015EC2', width: 10 },
        // Set default step function for all animate calls
        step: function (state, circle) {
            circle.path.setAttribute('stroke', state.color);
            circle.path.setAttribute('stroke-width', state.width);

            var value = Math.round(circle.value() * 100);
            if (value === 0) {
                circle.setText('');
            } else {
                circle.setText('<div class="text-center">' + value + "%" + "<br><small>HealthScore</small></br></div>");
            }

        }
    });
    progressCirclesblue1.animate(0.85);  // Number from 0.0 to 1.0
</script>