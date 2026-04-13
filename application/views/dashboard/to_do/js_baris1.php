<script>
    // Define active colors for each section
    const sectionColors = {
        progress_section_1: '#7D89B3',
        progress_section_2: '#7D89B3',
        progress_section_3: '#7D89B3'
    };

    // Handle progress-tab click events
    $('.progress-tab').on('click', function() {
        $('.progress-tab').css('background-color', '#FFFFFF').removeClass('selected');
        $(this).css('background-color', sectionColors[this.id]).addClass('selected');
        const target = $(this).data('target');
        $('.custom-pane').hide(); // Hide all tab content
        $(target).show(); // Show the selected tab content
    });

    // Set initial state (optional, to ensure correct initial visibility)
    $('.custom-pane').hide(); // Hide all tab content
    $('#section_running').show(); // Show the first section by default


    $(document).ready(function() {
        var user_id = $('#filter_pic').val();
        today_progress(user_id);
        lock_running(user_id);
        lock_history(user_id);
    });

    function lock_running(user_id) {
        // let idUser = user_id;
        $.ajax({
            type: "POST",
            url: `${baseUrl}/lock_running`,
            data: {
                id: user_id,
                status: 'Locked'
            },
            dataType: "json",
            beforeSend: function() {
                // Tampilkan loading spinner atau animasi jika diperlukan
                $('#row_running').empty().append(`<div class="text-center text-muted py-1"><i class="fa fa-spin fa-spinner"></i> Loading ...</div>`);
                $('#lock_run_count').text(`Running (0)`);
            },
            success: function(response) {
                var rowRunning = $('#row_running');
                if (response.status === 'success' && response.data.length > 0) {
                    $('#row_running').empty()
                    const dataCount = response.data.length;
                    $('#lock_run_count').text(`Running (${dataCount})`);
                    // Format tanggal dari YYYY-MM-DD ke DD MMM YYYY
                    const formatDate = (dateString) => {
                        const options = {
                            day: 'numeric',
                            month: 'short',
                            year: 'numeric'
                        };
                        const date = new Date(dateString);
                        return date.toLocaleDateString('id-ID', options);
                    };

                    // Loop melalui setiap item dalam array data
                    response.data.forEach(item => {
                        // Buat HTML card untuk setiap item
                        const newCard = `
                        <div class="card mb-2" style="border-radius: 10px;">
                            <div class="card-body bg-super-soft-grey" style="border-radius: 15px; text-align: left;">
                                <div class="row">
                                    <div class="col-6">
                                        <span class="badge rounded-pill" style="background-color:#E6EAED;color:black;">
                                            ${item.category || 'Tasklist'}
                                        </span>
                                        <span class="badge rounded-pill" style="background-color:#FFB2B2;color:#E11616;">
                                            <i class="bi bi-lock-fill text-danger"></i> ${item.status_lock || 'Locked'}
                                        </span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <span class="badge rounded-pill float-end" style="background-color:#FFFFFF; color:black; border: 0.5px solid grey;">
                                            ${formatDate(item.end_date)} <i class="bi bi-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-9">
                                        <p class="fw-bold small mb-0 mt-2">
                                            ${item.title || 'No Title'}
                                        </p>
                                        <p class="text-dark small mb-0" style="font-size:13px">
                                            ${item.description || 'No Description'}
                                        </p>
                                    </div>
                                    <div class="col-3 text-end d-flex justify-content-end align-items-end">
                                        <h5><a href="${item.link || '#'}" target="_blank"><i class="bi bi-arrow-right"></i></a></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                        // Tambahkan card ke container
                        rowRunning.append(newCard);
                    });
                } else {
                    rowRunning.html('<div class="text-center text-muted py-3">No locked tasks found</div>');
                }
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error('error:', error);
            }
        });
    }

    function lock_history(user_id) {
        const idUser = user_id;
        $.ajax({
            type: "POST",
            url: `${baseUrl}/lock_history`,
            data: {
                id: idUser
            },
            dataType: "json",
            beforeSend: function() {
                // Tampilkan loading spinner atau animasi jika diperlukan
                $('#row_history').empty().append(`<div class="text-center text-muted py-1"><i class="fa fa-spin fa-spinner"></i> Loading ...</div>`);
                $('#lock_his_count').text(`History (0)`);
            },
            success: function(response) {
                if (response.status === 'success' && response.data.length > 0) {
                    $('#row_history').empty()
                    const dataCount = response.data.length;
                    $('#lock_his_count').text(`History (${dataCount})`);
                    // Format tanggal dari YYYY-MM-DD ke DD MMM YYYY
                    const formatDate = (dateString) => {
                        const options = {
                            day: 'numeric',
                            month: 'short',
                            year: 'numeric'
                        };
                        const date = new Date(dateString);
                        // return date.toLocaleDateString('en-GB', options);
                        return date.toLocaleDateString('id-ID', options);
                    };

                    // Loop melalui setiap item dalam array data
                    response.data.forEach(item => {
                        // Buat HTML card untuk setiap item
                        const newCard = `
                        <div class="card mb-2" style="border-radius: 10px;">
                            <div class="card-body bg-super-soft-grey" style="border-radius: 15px; text-align: left;">
                                <div class="row">
                                    <div class="col-6">
                                        <span class="badge rounded-pill" style="background-color:#E6EAED;color:black;">
                                            ${item.category || 'Tasklist'}
                                        </span>
                                        <span class="badge rounded-pill" style="background-color:#FFB2B2;color:#E11616;">
                                            <i class="bi bi-lock-fill text-danger"></i> Locked
                                        </span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <span class="badge rounded-pill float-end" style="background-color:#FFFFFF; color:black; border: 0.5px solid grey;">
                                            ${item.tgl} <i class="bi bi-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-9">
                                        <p class="text-dark small mb-0" style="font-size:13px">
                                            ${item.description || 'No Description'}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                        // Tambahkan card baru ke container
                        $('#row_history').append(newCard);
                    });
                } else {
                    $('#row_history').html('<div class="text-center text-muted py-3">No history locked found</div>');
                }
            }
        });
    }

    function today_progress(user_id) {
        const idUser = user_id;
        $.ajax({
            type: "POST",
            url: `${baseUrl}/today_progress`,
            data: {
                id: idUser
            },
            dataType: "json",
            beforeSend: function() {
                // Tampilkan loading spinner atau animasi jika diperlukan
                $('#list_today_progress').empty().append(`<div class="text-center text-muted py-1"><i class="fa fa-spin fa-spinner"></i> Loading ...</div>`);
                $('#total_all_progress').text('');
                $('#total_all_progress_percent').text('');
            },
            success: function(response) {
                if (response.status === 'success' && response.data.length > 0) {
                    // Loop melalui setiap item dalam array data
                    $('#list_today_progress').empty()
                    var totalProgress = 0;
                    var totalCount = 0;
                    response.data.forEach(item => {
                        // Buat HTML card untuk setiap item
                        var colorProgress, colorPill;
                        if (item.percent >= 0 && item.percent <= 50) {
                            colorProgress = 'bg-danger'; // Red
                            colorPill = 'background-color:#FFB2B2;color:#E11616;'; // Red
                        } else if (item.percent > 50 && item.percent <= 80) {
                            colorProgress = 'bg-warning'; // Yellow
                            colorPill = 'background-color:#fbffb2;color:#dee116;'; // Red
                        } else if (item.percent > 80 && item.percent <= 100) {
                            colorProgress = 'bg-success'; // Green
                            colorPill = 'background-color:#b2ffc0;color:#16e138;'; // Red
                        } else {
                            colorProgress = 'bg-danger'; // Default to red if no condition met
                            colorPill = 'background-color:#FFB2B2;color:#E11616;'; // Red
                        }
                        totalProgress += parseInt(item.progress);
                        totalCount += parseInt(item.total);
                        const newCard = `
                            <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="progress-bar rounded-top ${colorProgress}" style="height: 5pt; position: absolute; top: 0px; left: 0px; width: ${item.percent}%;"></div>
                                            <div class="row gx-1">
                                                <div class="col-8">
                                                    <strong class="small">${item.category}</strong>
                                                </div>
                                                <div class="col-4">
                                                    <span class="badge rounded-pill float-end" style="${colorPill}">
                                                        ${item.percent}%
                                                    </span>
                                                </div>
                                                <div class="col-8 pt-2">
                                                    <h4>${item.progress}<span class="small">/${item.total}</span></h4>
                                                </div>
                                                <div class="col-4 pt-2" ${item.status_lock == 'Locked' ? '' : 'style="display:none;"'}>
                                                    <h5><i class="bi bi-lock-fill text-danger float-end"></i></h5>
                                                </div>
                                            </div>

                                            <div class="border-top mt-1" ${item.revisi != null ? '' : 'style="display:none;"'}>
                                                <div class="row pt-1 gx-1 mt-1">
                                                    <div class="col-8">
                                                        <span class="small">Revisi: ${item.revisi}x</span>
                                                    </div>
                                                    <div class="col-4">
                                                        <span class="badge rounded-pill text-bg-secondary float-end">
                                                            ${item.percent}%
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    `;

                        // Tambahkan card baru ke container
                        $('#list_today_progress').append(newCard);
                    });

                    $('#total_all_progress').text(`(${totalProgress}/${totalCount})`);
                    var percentAll = (totalProgress / totalCount) * 100;
                    var colorPercentAll;
                    if (percentAll >= 0 && percentAll <= 50) {
                        colorPercentAll = 'text-danger'; // Red
                    } else if (percentAll > 50 && percentAll <= 80) {
                        colorPercentAll = 'text-warning'; // Yellow
                    } else if (percentAll > 80 && percentAll <= 100) {
                        colorPercentAll = 'text-success'; // Green
                    } else {
                        colorPercentAll = 'text-danger'; // Default to red if no condition met
                    }
                    $('#total_all_progress_percent').removeClass('text-danger text-warning text-success').addClass(colorPercentAll);
                    $('#total_all_progress_percent').text(`${Math.round(percentAll || 0)}%`);
                } else {
                    $('#list_today_progress').html('<div class="text-center text-muted py-3">No today progress found</div>');
                }
            }
        });
    }
</script>