<script>
    $(document).ready(function() {

        var user_id = $('#filter_pic').val();
        var category = $('#filter_category').val();

        const dateRanges = get_range();
        load_data_todo(category,dateRanges.start_today, dateRanges.end_today, user_id, '#row_today');
        load_data_todo(category,dateRanges.start_besok, dateRanges.end_besok, user_id, '#row_besok');
        load_data_todo(category,dateRanges.start_coming, dateRanges.end_coming, user_id, '#row_coming');
    });


    function load_data_todo(category, start, end, user_id, type) {
        var row = $(type);
        row.empty().append(`<div class="text-center text-muted py-1"><i class="fa fa-spin fa-spinner"></i> Loading ...</div>`);
        $.ajax({
            type: "POST",
            url: "<?= base_url('dashboard_todo/data_todo'); ?>",
            data: {
                start: start,
                end: end,
                user_id: user_id,
                category: category,
            },
            dataType: "json",
            success: function(response) {
                
                row.empty();
                if (response.length == 0) {
                    row.empty().append(`<div class="text-center text-muted py-1">No data found</div>`);
                }
                response.forEach((item, index) => {
                    if (item.status_lock == 'Locked') {
                        style_lock = `<span class="badge rounded-pill bg-light-red text-danger">
                                            <i class="bi bi-lock-fill text-danger"></i> ${item.status_lock}
                                        </span>`;
                    } else {

                        style_lock = `<span class="badge rounded-pill bg-light-green text-green">
                                            <i class="bi bi-unlock-fill text-green"></i> ${item.status_lock}
                                        </span>`;
                    }
                    if (item.progress != "") {
                        if(item.progress >= 100){
                            style_progres = 'success'
                        }else{
                            style_progres = 'danger';
                        }
                        progres = `<div class="col-10">
                                        <div class="progress position-relative" style="height: 10px;">
                                            <div class="progress-bar bg-${style_progres}" style="width:${Math.round(item.progress || 0)}%;" role="progressbar" aria-valuenow="${Math.round(item.progress || 0)}" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-soft-grey" style="width:0%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <p class="fw-bold small mb-0 text-${style_progres} text-end">
                                            ${Math.round(item.progress || 0)}%
                                        </p>
                                    </div>`;
                    } else {
                        progres = ``;
                    }
                    let card = `<div class="card mb-2" style="border-radius: 10px;">
                            <div class="card-body bg-super-soft-grey" style="border-radius: 15px; text-align: left;">
                                <div class="row">
                                    <div class="col-8">
                                        <span class="badge rounded-pill" style="background-color:#E6EAED;color:black;">
                                            ${item.category}
                                        </span>
                ${style_lock}
                                    </div>
                                    <div class="col-4 text-end">
                                        <span class="badge rounded-pill float-end" style="background-color:#FFFFFF; color:black; border: 0.5px solid grey;">
                                            ${item.end_date} <i class="bi bi-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-9">
                                        <p class="fw-bold small mb-0 mt-2">
                                            ${item.title}
                                        </p>
                                        <p class="text-dark small mb-0" style="font-size:13px">
                                            ${item.description}
                                        </p>
                                    </div>
                                    <div class="col-3 text-end d-flex justify-content-end align-items-end">
                                        
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center">
                                    ${progres}
                                </div>
                                <div class="border-top mt-1">
                                    <div class="row pt-1 gx-1 mt-1">
                                        <div class="col-9">
                                            <span class="small">Created by</span>
    
                                            <div class="d-flex align-items-center gap-2">
                                                <figure 
                                                    class="rounded-circle mb-0" 
                                                    style="
                                                        width: 25px;
                                                        height: 25px;
                                                        background-image: url('${item.employee_photo}');
                                                        background-size: cover;
                                                        background-position: center;
                                                        background-repeat: no-repeat;
                                                        border-radius: 50%;
                                                        flex-shrink: 0;">
                                                </figure>
                                                <div class="flex-grow-1">
                                                    <div class="fw-bold ms-1">${item.employee_name}</div>
                                                    <span class="badge rounded-pill" style="background-color:#E6EAED;color:black;">
                                                        ${item.department_name}
                                                    </span>
                                                    <!-- <span class="badge rounded-pill" style="background-color:#E6EAED;color:black;">
                                                        ${item.designation_name}
                                                    </span> -->
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-3 text-end d-flex justify-content-end align-items-end">
                                            <h5><a href="${item.link}"><i class="bi bi-arrow-right"></i></a></h5>
                                        </div>
                                    </div>
                                </div>
    
                            </div>
                        </div>`;
                    row.append(card);
                    // card.fadeIn(300);
                });

            }
        });
    }

    function get_range() {
        const today = new Date();
        const besok = new Date();
        besok.setDate(today.getDate() + 1);

        const day = today.getDay(); // 0 = Minggu, 1 = Senin, ..., 6 = Sabtu
        const diffToMonday = today.getDate() - day + (day === 0 ? -6 : 1);

        const monday = new Date(today);
        monday.setDate(diffToMonday);

        const endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0); // hari ke-0 bulan berikutnya = hari terakhir bulan ini

        const start_coming_date = (day === 0) ? monday : besok;

        return {
            start_today: formatDate(today),
            end_today: formatDate(today),
            start_besok: formatDate(besok),
            end_besok: formatDate(besok),
            start_coming: formatDate(start_coming_date),
            end_coming: formatDate(endOfMonth), // diubah ke akhir bulan
        };
    }


    function formatDate(date) {
        let d = new Date(date);
        let month = '' + (d.getMonth() + 1);
        let day = '' + d.getDate();
        let year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }
</script>