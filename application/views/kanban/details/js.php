<script src="<?= base_url(); ?>assets/vendor/dropzone5-9-3/dropzone.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/js/paging.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/vendor/progressbar-js/progressbar.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/vendor/footable/footable.min.js" type="text/javascript"></script>

<script>

    function show_detail(id_task) {

        $.ajax({
            url: "<?= base_url('kanban/kanban_data') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                id_task: id_task,
            },
            success: function (response) {
                $('#detail_task_btn').click();
                $('#detail_id_task').val(id_task);
                // show_log_history(id_task)
            }
        })

        activateTab('activity', id_task);

    }

    function show_log_history(id_task) {
        base_url = "http://trusmiverse.com/hr/uploads/profile";
        body_log_history = '';
        $('#body_log_history').html('');
        // $('#dt_log_history').paging('destroy');
        
        
        $.ajax({
            url: "<?= base_url('kanban/log_history') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                id_task: id_task,
            },
            beforeSend: function () {
                $('#spinner_loading').show();
                // $('#activity_page').hide();
                // $('#files_page').hide();
                $('.detail_pages').hide();

            },
            success: function (response) {
                // console.info(response)
                body_log_history = '';
                setTimeout(() => {
                    response.log.forEach((value, index) => {
                        body_log_history += `<tr>
                            <td><small><small>${calculate_time_history_log(value.datetime)}</small></small></td>
                            <td>
                                <div class="avatar avatar-30 coverimg rounded-circle me-1"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="${value.employee}">
                                    <img src="${base_url}/${value.photo}" alt="">
                                </div>
                            </td>
                            <td><small>${get_jenis_log(value.jenis)}</small></td>
                            <td><small>${generate_history_change(value)}<small></td>
                        </tr>`
                    });
                }, 500);

            },
            complete: function () {
                setTimeout(() => {
                    $('#spinner_loading').hide();
                    $('.detail_pages').hide();
                    $('#activity_page').show();
                    $('#body_log_history').html(body_log_history);

                    // activate_footable();

                    body_log_history = '';
                }, 500);
            }
        })
    }



    // EVALUASI
    function show_get_evaluasi(id_task) {
        base_url = "http://trusmiverse.com/hr/uploads/profile";
        body_get_evaluasi = '';
        $('#body_get_evaluasi').html('');
        $.ajax({
            url: "<?= base_url('kanban/get_evaluasi') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                id_task: id_task,
            },
            beforeSend: function () {
                $('#spinner_loading').show();
                // $('#activity_page').hide();
                // $('#files_page').hide();
                $('.detail_pages').hide();

            },
            success: function (response) {
                // console.info(response)
                body_get_evaluasi = '';
                setTimeout(() => {
                    response.log.forEach((value, index) => {
                        body_get_evaluasi += `<tr>
                            <td><small>${calculate_time_history_log(value.datetime)}</small></td>
                            <td>
                                <div class="avatar avatar-30 coverimg rounded-circle me-1"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="${value.employee}">
                                    <img src="${base_url}/${value.photo}" alt="">
                                </div>
                            </td>
                            <!-- <td><small>${get_jenis_log(value.jenis)}</small></td> -->
                            <td><small>${generate_history_change(value)}<small></td>
                        </tr>`
                    });
                }, 500);

            },
            complete: function () {
                setTimeout(() => {
                    $('#spinner_loading').hide();
                    $('.detail_pages').hide();
                    $('#evaluasi_page').show();
                    $('#body_get_evaluasi').html(body_get_evaluasi);
                    body_get_evaluasi = '';
                    // activate_footable()
                }, 500);
            }
        })
    }


    function activate_footable(){
        $('.footable').footable({
            "paging": {
                "enabled": true,
                "container": '.footable-pagination',
                "countFormat": "{CP} of {TP}",
                "limit": 10,
                "position": "right",
                // "size": 4
            },
            "sorting": {
                "enabled": true
            },
        }, function (ft) {
            $('.footablestot').html($('.footable-pagination-wrapper .label').html())

            $('.footable-pagination-wrapper ul.pagination li').on('click', function () {
                setTimeout(function () {
                    $('.footablestot').html($('.footable-pagination-wrapper .label').html());
                }, 200);
            });

        });
    }


    function calculate_time_history_log(time_string) {
        var targetDate = new Date(time_string);
        var currentDate = new Date();
        var timeDifference = currentDate - targetDate;
        var daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
        var hoursDifference = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var monthDifference = (currentDate.getMonth() + 1) - (targetDate.getMonth() + 1);
        var yearDifference = currentDate.getFullYear() - targetDate.getFullYear();

        if (yearDifference > 0) {
            // return `<i class="bi bi-clock"></i> ${yearDifference}y`
            return `<small>${convert_duedate(time_string)}</small>`
        } else if (monthDifference > 0) {
            // return `<i class="bi bi-clock"></i> ${monthDifference}m`
            return `<small>${convert_duedate(time_string)}</small>`
        } else if (daysDifference > 0) {
            // return `<i class="bi bi-clock"></i> ${daysDifference}d`
            return `<small>${convert_duedate(time_string)}</small>`
        } else if (hoursDifference > 0) {
            return `<i class="bi bi-clock"></i> ${hoursDifference}h`
            // return `<small>${convert_duedate(time_string)}</small>`
        } else {
            timeOnly = time_string.split(' ')[1].substring(0, 5);
            // const hours = parseInt(timeOnly.split(':')[0]);
            // let meridiem = 'am';
            // if (hours >= 12) {
            //     meridiem = 'pm';
            // }
            // return `${timeOnly} ${meridiem}`
            return convertTo12HourFormat(timeOnly);
        }
    }

    function convertTo12HourFormat(time24) {
        // Extract hours and minutes from the time string
        const [hours, minutes] = time24.split(':');

        // Convert hours to 12-hour format
        const hours12 = hours % 12 || 12; // If hours is 0, convert to 12

        // Determine if it's AM or PM
        const period = hours < 12 ? 'am' : 'pm';

        // Create the 12-hour time string
        const time12 = `${String(hours12).padStart(2, '0')}:${minutes} ${period}`;

        return time12;
    }

    function get_jenis_log(jenis) {
        if (jenis == 'created') {
            jenis_log = `<small><i class="bi bi-pen"></i> Created</small>`
        } else if (jenis == 'progress') {
            jenis_log = `<small><i class="bi bi-percent text-success"></i> Progress</small>`
        } else if (jenis == 'status') {
            jenis_log = `<small><img class="status_img" src="<?= base_url() ?>/assets/img/color_status.png" style="max-width:8%; height:auto"> Status</small>`
        } else if (jenis == 'evaluasi') {
            jenis_log = `<small><i class="bi bi-clipboard-data"></i> Evaluasi</small>`
        } else if (jenis == 'note') {
            jenis_log = `<small><i class="bi bi-chat-right-text"></i> Note</small>`
        } else {
            jenis_log = ``
        }
        return jenis_log;
    }

    function generate_history_change(value) {
        if (value.jenis == 'created') {
            history_change = `<small>${value.history}</small>`
        } else if (value.jenis == 'progress') {
            history_change = `<small>
                                <table>
                                    <tr>
                                        <td rowspan="2">${generate_type_badge(value.status.trim())}</td> 
                                        <td rowspan="2">${generate_progres_badge_log(value.progress, value.status.trim())}</td> 
                                        <td><i class="text-muted">strategy: </i>${value.history}</td>
                                    </tr> 
                                    <tr>
                                        <td><i class="text-muted">note: </i>${value.note}</td>
                                    </tr> 
                                </table>
                                </small>`
        } else if (value.jenis == 'status') {
            history_change = `<small>${generate_status_history(value.status_before)} <i class="bi bi-chevron-right text-muted" style="font-size:8pt"></i> ${generate_status_history(value.status)}<small>`
        } else if (value.jenis == 'evaluasi') {
            history_change = `<small>
                                <table>
                                    <tr>
                                        <td rowspan="2">${generate_type_badge(value.status.trim())}</td> 
                                        <td rowspan="2">${generate_progres_badge_log(value.progress, value.status.trim())}</td> 
                                        <td><i class="text-muted">strategy: </i>${value.sub_task}</td>
                                    </tr> 
                                    <tr>
                                        <td><i class="text-muted">Evaluasi: </i>${value.history}</td>
                                    </tr> 
                                </table>
                                </small>`
        } else if (value.jenis == 'note') {
            history_change = `<small>${value.history}</small>`
        } else {
            history_change = ``
        }
        return history_change;
    }

    function generate_type_badge(id){
        if(id=='1' || id=='Daily'){ // 1: Daily
            return `<span class="btn btn-sm btn-link bg-light-theme theme-cyan"><small>D</small></span>`
        }else if(id=='2' || id=='Weekly'){ // 2: Weekly
            return `<span class="btn btn-sm btn-link bg-light-theme theme-yellow"><small>W</small></span>`
        }else if(id=='3' || id=='Montly'){ // 3: Montly
            return `<span class="btn btn-sm btn-link bg-light-theme theme-red"><small>M</small></span>`
        }else if(id=='4' || id=='Twice'){ // 4: Twice
            return `<span class="btn btn-sm btn-link bg-light-theme theme-green"><small>T</small></span>`
        }else{
            return ``
        }
    }

    function generate_progres_badge_log(progress, status=null) {

        if(status=='1' || status=='Daily'){ // 1: Daily
            return `<span class="btn btn-sm btn-link bg-light-theme theme-cyan"><small>${progress}%</small></span>`
        }else if(status=='2' || status=='Weekly'){ // 2: Weekly
            return `<span class="btn btn-sm btn-link bg-light-theme theme-yellow"><small>${progress}%</small></span>`
        }else if(status=='3' || status=='Montly'){ // 3: Montly
            return `<span class="btn btn-sm btn-link bg-light-theme theme-red"><small>${progress}%</small></span>`
        }else if(status=='4' || status=='Twice'){ // 4: Twice
            return `<span class="btn btn-sm btn-link bg-light-theme theme-green"><small>${progress}%</small></span>`
        }else{
            return ``
        }

        // if (progress >= 100) {
        //     return `<span class="btn btn-sm btn-link bg-light-green text-dark"><small>${progress}%</small></span>`
        // } else if (progress > 75) {
        //     return `<span class="btn btn-sm btn-link bg-light-cyan text-dark"><small>${progress}%</small></span>`
        // } else if (progress > 35) {
        //     return `<span class="btn btn-sm btn-link bg-light-blue text-dark"><small>${progress}%</small></span>`
        // } else if (progress >= 0) {
        //     return `<span class="btn btn-sm btn-link bg-light-red text-dark"><small>${progress}%</small></span>`
        // } else {
        //     return ``
        // }
    }

    function generate_status_history(status) {
        if (status == 'Not Started') {
            badge = `<span class="p-1 kanban-header-not-started">${status}</span>`
        } else if (status == 'Working On') {
            badge = `<span class="p-1 kanban-header-working-on">${status}</span>`
        } else if (status == 'Done') {
            badge = `<span class="p-1 kanban-header-done">${status}</span>`
        } else if (status == 'Stuck') {
            badge = `<span class="p-1 kanban-header-stuck">${status}</span>`
        } else {
            badge = ``
        }
        return badge;
    }

    function truncateString(str, maxLength) {
        if (str == null) {
            str = '';
        }
        if (str.length > maxLength) {
            return str.substring(0, maxLength - 3) + '...';
        } else {
            return str;
        }
    }


    function activateTab(id, id_task=null) {
        $('.detail_pages').hide();
        var tabs = document.querySelectorAll('.nav-link');
        tabs.forEach(function (tab) {
            tab.classList.remove('active');
        });
        var clickedTab = document.querySelector(`#nav_${id}`);
        clickedTab.classList.add('active');

        $('.detail_pages').hide();
        $(`#${id}_page`).show();

        if(id_task == null){
            id_task = $('#detail_id_task').val();
        }

        if (id == "activity") {
            show_log_history(id_task);
        } else if (id == "evaluasi") {
            show_get_evaluasi(id_task);
        } else if (id == "files") {
            get_attachment(id_task);
        }
    }

    function get_attachment(id_task) {
        body_files_page = '';
        base_url = "http://trusmiverse.com/apps/assets/attachment";
        $.ajax({
            url: "<?= base_url('kanban/get_attachment') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                id_task: id_task,
            },
            beforeSend: function () {
                $('#spinner_loading').show();
                // $('#files_page').hide();
                // $('#body_files_page').empty();
                $('.detail_pages').hide();
                $('#nama_file').val('');
                $('#fileInput').val('');
                $('#file_string').val('');
            },
            success: function (response) {
                // console.info(response)
                response.attachment.forEach((value, index) => {


                    body_files_page += `<div class="col-12 col-md-4 col-lg-6 col-xl-4 mb-4">
                                    <div class="card border-0 overflow-hidden">
                                        <div class="h-150 w-100 coverimg">
                                            ${generate_file_attachment(base_url, value.file)}
                                        </div>
                                        <div class="card-footer bg-none">
                                            <div class="row gx-3 align-items-center">
                                                <div class="col-auto">
                                                    <p class="mb-0">${value.filename}</p>
                                                    <p class="small text-secondary">${value.created_at}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`
                });
                $('#body_files_page').html(body_files_page)
            },
            complete: function () {
                setTimeout(() => {
                    $('#spinner_loading').hide();
                    $('.detail_pages').hide();
                    $('#files_page').show();
                }, 500);
            }
        })

    }

    function generate_file_attachment(base_url, filename) {
        ext = filename.split('.').pop();

        imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
        if (imageExtensions.includes(ext)) {
            return `<img src="${base_url}/${filename}" class="mw-100" alt="" />`
        } else if (ext == "pdf") {
            return `<center><a href="${base_url}/${filename}" target="_blank" class="avatar avatar-100 rounded bg-red text-white">
                        <i class="bi bi-file-earmark-pdf vm" style="font-size: 50px"></i>
                    </a></center>`
        } else if (ext == "ppt" || ext == "pptx") {
            return `<center><a href="${base_url}/${filename}" target="_blank" class="avatar avatar-100 rounded bg-red text-white">
                        <i class="bi bi-filetype-ppt vm" style="font-size: 50px"></i>
                    </a></center>`
        } else if (ext == "doc" || ext == "docx") {
            return `<center><a href="${base_url}/${filename}" target="_blank" class="avatar avatar-100 rounded bg-red text-white">
                        <i class="bi bi-file-earmark-word-fill vm" style="font-size: 50px"></i>
                    </a></center>`
        } else if (ext == "xls" || ext == "xlsx") {
            return `<center><a href="${base_url}/${filename}" target="_blank" class="avatar avatar-100 rounded bg-red text-white">
                        <i class="bi bi-file-earmark-x-fill vm" style="font-size: 50px"></i>
                    </a></center>`
        } else {
            return `<img src="${base_url}/${filename}" class="mw-100" alt="" />`
        }

        // return ''
    }

    function addFileInput() {
        $('#fileInput').trigger('click');

    }

    function hide_upload_toast() {
        $('#liveToast').hide()
    }

    function file_selected() {
        var fileInput = document.getElementById('fileInput');
        var file = fileInput.files[0];
        $('#file_string').val(file.name);
        // console.info(`file.name ${file.name}`)

        document.getElementById('uploaded_preview').src = window.URL.createObjectURL(file);

    }

    function upload_file() {
        id_task = $('#detail_id_task').val();

        file_name = $('#nama_file').val();
        file_string = $('#file_string').val();

        if (file_name == '') {
            $('#nama_file').addClass('is-invalid')
        } else if (file_string == '') {
            $('#file_string').addClass('is-invalid')
        } else {

            var form = $('#fileForm')[0];
            var formData = new FormData(form);
            formData.append('id_task', id_task);

            $('#liveToast').show();
            $('#upload_check').hide();
            $('#spinner_upload').show();

            document.getElementById('myProgressBar').setAttribute('aria-valuenow', 0);
            document.getElementById('myProgressBar').style.width = 0 + '%';

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressUpload, false);
            ajax.open("POST", "<?= site_url('kanban/upload_file') ?>", true);
            ajax.send(formData);
            ajax.onload = function () {
                // console.log('DONE: ', ajax.status);
                // console.log(ajax.status);
                // console.info(JSON.parse(ajax.responseText));
                if (ajax.status == 200) {

                    response = JSON.parse(ajax.responseText);
                    // console.info(response)
                    get_attachment(id_task);

                    setTimeout(() => {
                        hide_upload_toast();
                        console.info('hide toast')
                    }, 5000);

                }
            }

        }

    }

    function remove_invalid(id) {
        $(`#${id}`).removeClass('is-invalid')
    }

    function progressUpload(event) {
        var percent = (event.loaded / event.total) * 100;
        // document.getElementsByClassName("progress_bar")[0].style.width = Math.round(percent) + '%';
        // document.getElementsByClassName("status_bar")[0].innerHTML = Math.round(percent) + "% completed";
        document.getElementById('myProgressBar').setAttribute('aria-valuenow', Math.round(percent));
        document.getElementById('myProgressBar').style.width = Math.round(percent) + '%';

        $('#btn_save_upload').hide();

        $("#uploaded_status").html('Uploading ...');
        var fileInput = document.getElementById('fileInput');
        var preview = document.getElementById('uploaded_preview');
        var file = fileInput.files[0];
        var reader = new FileReader();
        reader.onloadend = function () {
            preview.src = reader.result;
        }
        $('#uploaded_preview').attr('src', )
        nama_file = $('#nama_file').val();
        $('#uploaded_name').html(nama_file);
        current_datetime = "<?= date('Y-m-d H:i:s') ?>";
        $('#uploaded_date').html(current_datetime);

        if (Math.round(percent) == 100) {
            setTimeout(() => {
                $('#spinner_upload').hide();
                $('#upload_check').show();
                $("#uploaded_status").html('Upload Success');
                $('#btn_save_upload').show();
            }, 500);
        }
    }

    function convert_duedate(dateString) {
        var dateObject = new Date(dateString);
        var monthNames = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];
        var day = dateObject.getDate();
        var month = monthNames[dateObject.getMonth()];
        var formattedDate = day + ' ' + month;
        return formattedDate;
    }


</script>
