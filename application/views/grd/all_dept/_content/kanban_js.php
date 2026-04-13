<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/dragula/dragula.js"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script>
    $(document).ready(function() {
        kanban_data()
    });

    function reload_data() {
        console.info("=== START kanban reload_data call ===");

        var divisi = $('#select_divisi').val();
        // var month = $('#select_month').val();
        var start = $('#startCalendar').val();
        var end = $('#endCalendar').val();

        get_all_list_grd(divisi, start, end);
        kanban_data();
        $.ajax({
            url: base_url + 'reload',
            type: "POST",
            data: {
                divisi: divisi,
                start: start,
                end: end
            },
            dataType: "json",
            success: function(response) {
                if (response.goals) {
                    updateProgressBar(response.goals);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });

        console.info("=== END kanban reload_data call ===");

    }

    function updateProgressBar(goals) {
        console.info("=== START kanban updateProgressBar call ===");
        var progressBarContainer = $("#progressBarContainer"); // Target the progress container
        progressBarContainer.html(''); // Clear old content

        let index = 1;
        let totalNotStarted = 0;

        let progressBarHTML = `<div class="progress" style="height: 35px; width: 100%;">`;

        // Loop through each goal and create a progress bar
        goals.forEach(function(goal) {
            progressBarHTML += `
                <div class="progress-bar bg-blue_${index}" 
                    style="width:${goal.done_prs}%;" 
                    role="progressbar">
                    <span style="font-size: 12px; font-weight: bold;" class="text-white">
                        ${goal.nama_goal} (${goal.done_prs}%)
                    </span>
                </div>
            `;
            totalNotStarted += parseFloat(goal.not_started_prs); // Accumulate "Not Started" percentage
            index++;

            // console.info("nama_goal : " + goal.nama_goal + " | done_prs : " +goal.done_prs + " | not_started_prs : " +goal.not_started_prs);
            // console.info("totalNotStarted : " + totalNotStarted);


        });

        // Add the "Not Started" progress bar if there is remaining percentage
        if (totalNotStarted > 0) {
            progressBarHTML += `
                <div class="progress-bar" 
                    style="width:${totalNotStarted}%; background-color: #D4D4D8;" 
                    role="progressbar">
                    <span style="font-size: 12px; font-weight: bold;" class="text-grey">
                        Not Started (${totalNotStarted}%)
                    </span>
                </div>
            `;
        }

        progressBarHTML += `</div>`; // Close the progress div
        // console.info("progressBarHTML : " + progressBarHTML);

        progressBarContainer.html(progressBarHTML); // Update the container with new content
        console.info("=== END kanban updateProgressBar call ===");

    }
</script>


<!-- KANBANNNNNNNNN -->
<script>
    var dragable;

    (function e(t, n, r) {
        function s(o, u) {
            if (!n[o]) {
                if (!t[o]) {
                    var a = typeof require == "function" && require;
                    if (!u && a) return a(o, !0);
                    if (i) return i(o, !0);
                    var f = new Error("Cannot find module '" + o + "'");
                    throw f.code = "MODULE_NOT_FOUND", f
                }
                var l = n[o] = {
                    exports: {}
                };
                t[o][0].call(l.exports, function(e) {
                    var n = t[o][1][e];
                    return s(n ? n : e)
                }, l, l.exports, e, t, n, r)
            }
            return n[o].exports
        }
        var i = typeof require == "function" && require;
        for (var o = 0; o < r.length; o++) s(r[o]);
        return s
    })({
        1: [function(require, module, exports) {
            'use strict';

            dragable = dragula([$('not_started_column'), $('working_on_column'), $('done_column'), $('feedback_column'), $('revisi_column')])
                .on('drag', function(el) {
                    el.className = el.className.replace('ex-moved', '');
                }).on('drop', function(el) {
                    el.className += ' ex-moved';
                }).on('over', function(el, container) {
                    container.className += ' ex-over';
                }).on('out', function(el, container) {
                    container.className = container.className.replace('ex-over', '');
                });

            function $(id) {
                return document.getElementById(id);
            }
        }, {
            "crossvent": 3
        }]
    }, {}, [1])

    const not_started_column = document.querySelector('#not_started_column');
    not_started_column.addEventListener('mouseenter', () => {
        not_started_column.classList.add('is-hovered');
    });
    not_started_column.addEventListener('mouseleave', () => {
        not_started_column.classList.remove('is-hovered');
    });

    const working_on_column = document.querySelector('#working_on_column');
    working_on_column.addEventListener('mouseenter', () => {
        working_on_column.classList.add('is-hovered');
    });
    working_on_column.addEventListener('mouseleave', () => {
        working_on_column.classList.remove('is-hovered');
    });

    const done_column = document.querySelector('#done_column');
    done_column.addEventListener('mouseenter', () => {
        done_column.classList.add('is-hovered');
    });
    done_column.addEventListener('mouseleave', () => {
        done_column.classList.remove('is-hovered');
    });

    const feedback_column = document.querySelector('#feedback_column');
    feedback_column.addEventListener('mouseenter', () => {
        feedback_column.classList.add('is-hovered');
    });
    feedback_column.addEventListener('mouseleave', () => {
        feedback_column.classList.remove('is-hovered');
    });

    const revisi_column = document.querySelector('#revisi_column');
    revisi_column.addEventListener('mouseenter', () => {
        revisi_column.classList.add('is-hovered');
    });
    revisi_column.addEventListener('mouseleave', () => {
        revisi_column.classList.remove('is-hovered');
    });

    function kanban_data() {
        console.info("=== START kanban kanban_data call ===");

        var divisi = $('#select_divisi').val();
        // var month = $('#select_month').val();
        var start = $('#startCalendar').val();
        var end = $('#endCalendar').val();

        // console.log('divisi : ', divisi);
        // console.log('start : ', start);
        // console.log('end : ', end);

        $.ajax({
            url: `${base_url}/kanban_data`,
            type: "POST",
            dataType: 'json',
            data: {
                divisi: divisi,
                start: start,
                end: end
            },
            beforeSend: function() {
                $('.kanban-body').empty();
            },
            success: function(response) {

                // console.log('Kanban Data : ', response);

                not_started = '';
                working_on = '';
                done = '';
                feedback = '';
                revisi = '';

                kanban_status_count_not_started = 0;
                kanban_status_count_working_on = 0;
                kanban_status_count_done = 0;
                kanban_status_count_feedback = 0;
                kanban_status_count_revisi = 0;

                response.kanban.forEach((value, index) => {
                    kanban = '';

                    if (value.progress > 80) {
                        theme_color = 'theme-green';
                    } else if (value.progress > 45) {
                        theme_color = 'theme-yellow';
                    } else {
                        theme_color = 'theme-red';
                    }

                    // console.info("=== START kanban kanban_data call ===");

                    kanban += `<div class="dragzonecard" data-id_task="${value.id_task}" data-id_si="${value.id_si}" data-id_so="${value.id_so}" data-divisi="${divisi}" onclick="detail_tasklist('${value.id_task}', '${value.id_si}', '${value.id_so}', '${divisi}')">
                                    <div class="card border-0 mb-2">
                                        <div class="card-body">
                                            <div class="row gx-2">
                                                <div class="col">

                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <div class="float-start">
                                                                <p class="text-secondary small">${value.type.trim()}</p>
                                                            </div>
                                                            <div class="float-end">
                                                                <span class="badge ${value.status_color}">${value.status}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" style="margin-top:-10px">
                                                        <div class="col">
                                                            <div class="description_task"><small>${value.task}</small></div>
                                                            <div class="description_task"><small>${value.description}</small></div>
                                                        </div>
                                                        <!-- <div class="col-auto text-center" style="margin-top:15px">
                                                            <div class="circle-small">
                                                                <div id="progress_goals_${value.id_task}"></div>
                                                            </div>  
                                                        </div> -->
                                                    </div>


                                                    
                                                    <div class="row mb-3 mt-3">
                                                        <div class="col">

                                                           ${generate_leadtime(value.id_status, value.start, value.end)}

                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col-10">
                                                            <div class="progress h-5 mb-1 py-2 bg-light-theme">
                                                                <div class="progress-bar bg-theme ${theme_color}" role="progressbar" style="width: ${value.progress}%" aria-valuenow="${value.progress}" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>                                                            
                                                            
                                                        </div>
                                                        <div class="col-2">
                                                            <div>
                                                                <small class="text-muted">${value.progress}%</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="card-footer">
                                            <div class="row align-items-center gx-2">
                                                ${generate_foto(value.id_pic, value.pic, value.profile_picture)}
                                            </div>
                                        </div>
                                    </div>
                                </div>`;



                    if (value.id_status == '1') { // 1 : not started
                        not_started += kanban;
                        kanban_status_count_not_started++;

                    } else if (value.id_status == '2') { // 2 : working on
                        working_on += kanban;
                        kanban_status_count_working_on++;

                    } else if (value.id_status == '3') { // 3 : done
                        done += kanban;
                        kanban_status_count_done++;

                    } else if (value.id_status == '4') { // 4 : feedback
                        feedback += kanban;
                        kanban_status_count_feedback++;

                    } else { // 4 : revisi
                        revisi += kanban;
                        kanban_status_count_revisi++;

                    }

                });

                $('#not_started_column').html(not_started);
                $('#working_on_column').html(working_on);
                $('#done_column').html(done);
                $('#feedback_column').html(feedback);
                $('#revisi_column').html(revisi);

                $('#kanban_status_count_not_started').html(kanban_status_count_not_started);
                $('#kanban_status_count_working_on').html(kanban_status_count_working_on);
                $('#kanban_status_count_done').html(kanban_status_count_done);
                $('#kanban_status_count_feedback').html(kanban_status_count_feedback);
                $('#kanban_status_count_revisi').html(kanban_status_count_revisi);


                // generate_progress_bar(kanban_status_count_not_started, kanban_status_count_working_on, kanban_status_count_done, kanban_status_count_stuck)

                // console.info(`grand_total: ${grand_total}`)
                // console.info(`bar_not_started: ${bar_not_started}`)
                // console.info(`bar_working_on: ${bar_working_on}`)
                // console.info(`bar_done: ${bar_done}`)
                // console.info(`bar_stuck: ${bar_stuck}`)


            },
            complete: function(response) {
                data = JSON.parse(response.responseText);
                data.kanban.forEach((value, index) => {
                    // percent bar
                    // consistency = 0;
                    // value.sub_task.forEach((val, i) => {
                    //     consistency += parseInt(val.consistency);
                    // })

                    progress = parseFloat(value.progress / 100);

                    if (progress.toString() == 'NaN') {
                        progress = 0;
                    }

                    // intialize_progres_bar(`progress_goals_${value.id_task}`).animate(progress);
                });

                setTimeout(() => {
                    tippy(document.querySelectorAll('.tippy'), {
                        animation: 'scale',
                    });
                }, 500);

            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })

        console.info("=== END kanban kanban_data call ===");
    }


    function calculate_created_at_hour(time_string) {
        timeOnly = time_string.split(' ')[1].substring(0, 5);
        const hours = parseInt(timeOnly.split(':')[0]);
        let meridiem = 'am';
        if (hours >= 12) {
            meridiem = 'pm';
        }
        return `${timeOnly} ${meridiem}`
    }

    function calculate_created_at_time(time_string, time_end = null) {
        var targetDate = new Date(time_string);
        if (time_end == null) {
            var currentDate = new Date();
        } else {
            var currentDate = new Date(time_end);
        }
        var timeDifference = currentDate - targetDate;
        var daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
        var hoursDifference = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutesDifference = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
        if (daysDifference > 0) {
            return `| ${daysDifference} day ago`
        } else if (hoursDifference > 0) {
            return `| ${hoursDifference} hrs ago`
        } else if (minutesDifference > 0) {
            return `| ${minutesDifference} mnt ago`
        } else {
            return `| just now`
        }
    }

    function generate_leadtime(status, start, end) {
        if (status == '1') { // 1 : not started
            return `<div class="float-start">
                        <small class="bi bi-calendar-week"> <small>${start} <i class="bi bi-arrow-right-short"></i> ${end}</small></small>
                    </div>`
        } else if (status == '2') { // 2: working on

            return `<div class="float-start">
                        <small class="bi bi-calendar-week"> <small>${start} <i class="bi bi-arrow-right-short"></i> ${end}</small></small>
                    </div>`

        } else if (status == '3' || status == '4') { // 3 : done, 4 : stuck
            return `<div class="float-start">
                        <small class="bi bi-calendar-week"> <small>${start} <i class="bi bi-arrow-right-short"></i> ${end}</small></small>
                    </div>`
        }

    }

    function intialize_progres_bar(id) {
        return new ProgressBar.Circle(`#${id}`, {
            color: '#3d99fc',
            // This has to be the same size as the maximum width to
            // prevent clipping
            strokeWidth: 10,
            trailWidth: 10,
            easing: 'easeInOut',
            trailColor: 'rgba(66, 157, 255, 0.15)',
            duration: 1400,
            text: {
                autoStyleContainer: false
            },
            from: {
                color: '#3d99fc',
                width: 10
            },
            to: {
                color: '#3d99fc',
                width: 10
            },
            // Set default step function for all animate calls
            step: function(state, circle) {
                circle.path.setAttribute('stroke', state.color);
                circle.path.setAttribute('stroke-width', state.width);

                var value = Math.round(circle.value() * 100);
                // if (value === 0) {
                //      circle.setText('');
                // } else {
                circle.setText(value + "<small>%<small>");
                // }

            }
        });
        // progressCircles2.text.style.fontSize = '20px';

    }

    function get_priority_color(id_priority) {
        if (id_priority == '1') { // 1: Critical
            priority_color = 'bg-light-blue text-blue';

        } else if (id_priority == '2') { // 2: High
            priority_color = 'bg-light-cyan text-cyan';

        } else if (id_priority == '3') { // 3: Medium
            priority_color = 'bg-light-purple text-purple';

        } else if (id_priority == '4') { // 4: Low
            priority_color = 'bg-light-green text-green';

        } else {
            priority_color = '';
        }
        return priority_color;
    }

    // function get_strategy_color(strategy) {
    //     if (strategy == 'Once') {
    //         strategy_color = 'tag bg-light-pink theme-teal me-1 mt-1 text-pink';
    //     } else {
    //         strategy_color = 'tag bg-light-red theme-teal me-1 mt-1 text-red';
    //     }
    //     return strategy_color;
    // }

    // function generate_priority_badge(priority) {
    //     if (priority == '1') { // 1 : Sangat Mudah
    //         return `<img src="<?= base_url() ?>assets/badges/1.png" alt="-" height="50px">`
    //     } else if (priority == '2') { // 2 : Mudah
    //         return `<img src="<?= base_url() ?>assets/badges/2.png" alt="-" height="50px">`
    //     } else if (priority == '3') { // 3 : Sedang
    //         return `<img src="<?= base_url() ?>assets/badges/3.png" alt="-" height="50px">`
    //     } else if (priority == '4') { // 4 : Sulit
    //         return `<img src="<?= base_url() ?>assets/badges/4.png" alt="-" height="50px">`
    //     } else if (priority == '5') { // 5 : Sangat Sulit
    //         return `<img src="<?= base_url() ?>assets/badges/5.png" alt="-" height="50px">`
    //     } else {
    //         return ``
    //     }
    // }

    function generate_duedate_icon(due_date) {

        // Specify the target date as a string
        var targetDate = new Date(due_date);

        // Get the current date
        var currentDate = new Date();

        // Calculate the difference in milliseconds
        var dateDifference = targetDate - currentDate;

        // Convert the difference to days
        var daysDifference = Math.floor(dateDifference / (1000 * 60 * 60 * 24));
        daysDifference = daysDifference + 1;

        // console.log('Date difference in days:', daysDifference);

        if (daysDifference < 0) {
            return `<span class="tippy bi bi-bi bi-exclamation-circle-fill text-danger" style="font-size: 16px;" data-tippy-content="${Math.abs(daysDifference)} days overdue"></span>`;
        } else if (daysDifference == 0) {
            return `<span class="tippy bi bi-bi bi-circle-fill" style="font-size: 16px;" data-tippy-content="Today"></span>`;
        } else if (daysDifference == 1) {
            return `<span class="tippy bi bi-bi bi-1-circle-fill" style="font-size: 16px;" data-tippy-content="${daysDifference} days left"></span>`;
        } else if (daysDifference == 2) {
            return `<span class="tippy bi bi-bi bi-2-circle-fill" style="font-size: 16px;" data-tippy-content="${daysDifference} days left"></span>`;
        } else if (daysDifference == 3) {
            return `<span class="tippy bi bi-bi bi-3-circle-fill" style="font-size: 16px;" data-tippy-content="${daysDifference} days left"></span>`;
        } else if (daysDifference == 4) {
            return `<span class="tippy bi bi-bi bi-4-circle-fill" style="font-size: 16px;" data-tippy-content="${daysDifference} days left"></span>`;
        } else if (daysDifference == 5) {
            return `<span class="tippy bi bi-bi bi-5-circle-fill" style="font-size: 16px;" data-tippy-content="${daysDifference} days left"></span>`;
        } else if (daysDifference == 6) {
            return `<span class="tippy bi bi-bi bi-6-circle-fill" style="font-size: 16px;" data-tippy-content="${daysDifference} days left"></span>`;
        } else if (daysDifference == 7) {
            return `<span class="tippy bi bi-bi bi-7-circle-fill" style="font-size: 16px;" data-tippy-content="${daysDifference} days left"></span>`;
        } else if (daysDifference > 7) {
            return `<span class="tippy bi bi-bi bi-circle" style="font-size: 16px;" data-tippy-content="${daysDifference} days left"></span>`;
        } else {
            return ``;
        }


    }

    function generate_foto(list_id_pic, list_pic_name, list_photo) {

        array_id_pic = list_id_pic.split(',');
        array_pic_name = list_pic_name.split(',');
        array_photo = list_photo.split(',');

        // console.info(list_pic_name)
        // console.info(list_photo)

        url_foto = "http://trusmiverse.com/hr/uploads/profile";

        photos = ``;
        array_photo.forEach((value, index) => {
            if (index < '2') {
                // photos += `<div class="avatar avatar-30 coverimg rounded-circle me-1"
                //             data-bs-toggle="tooltip" data-bs-placement="top" title="${array_pic_name[index]}">
                //             <img src="${base_url}/${array_photo[index]}" alt="">
                //            </div>`;
                photos += `<div class="avatar avatar-30 coverimg rounded-circle me-1 tippy"
                                data-tippy-content="${array_pic_name[index]}">
                            <img src="${url_foto}/${array_photo[index]}" alt="">
                           </div>`;
            }
        });


        more_photos = ``;
        if (array_photo.length > 2) {
            more_photos += `<div
                                class="avatar avatar-30 bg-light-theme rounded-circle me-1">
                                <p class="small">2+</p>
                            </div>`;
        }

        generated_foto = `<div class="col">
                                ${photos}
                                ${more_photos}
                            </div>`;

        return generated_foto;

    }

    function generate_is_file_exist(attachment) {
        if (attachment != '') {
            return `<i class="bi bi-paperclip avatar avatar-36 bg-light-gray rounded"></i>`;
        } else {
            return ``;
        }
    }



    // Add event listeners
    dragable.on('drag', function(el, source) {
        var id_task = el.dataset.id_task;
        $('.dragzonecard>div').css('cursor', 'grabbing');
    });


    dragable.on('drop', function(el, target, source, sibling) {

        var id_task = el.dataset.id_task;
        var id_si = el.dataset.id_si;
        var id_so = el.dataset.id_so;
        var divisi = el.dataset.divisi;

        var source_id = source.id;
        var target_id = target.id;
        // console.log('Dragged from container with ID:', source_id);
        // console.log('Dropped into container with ID:', target_id);

        if (source_id == 'not_started_column') {
            status_before = 1;
        } else if (source_id == 'working_on_column') {
            status_before = 2;
        } else if (source_id == 'done_column') {
            status_before = 3;
        } else if (source_id == 'feedback_column') {
            status_before = 4;
        } else if (source_id == 'revisi_column') {
            status_before = 5;
        }

        if (target_id == 'not_started_column') {
            status_after = 1;
        } else if (target_id == 'working_on_column') {
            status_after = 2;
        } else if (target_id == 'done_column') {
            status_after = 3;
        } else if (target_id == 'feedback_column') {
            status_after = 4;
        } else if (target_id == 'revisi_column') {
            status_after = 5;
        }

        // console.info(`status_after: ${status_after}`)
        // console.info(`status_before: ${status_before}`)

        // console.info(id_status)
        $('#detail_task_btn').click();

        $('#modal_detail_tasklist').find('[name="id_tasklist"]').val(id_task);
        $('#status_before').val(status_before);
        $('#status').val(status_after);

        // show_log_history(id_task)


        if (status_after < status_before) {
            $.confirm({
                title: 'Upss...',
                content: 'You are not allowed to revert to a previous status.',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    close: function() {
                        user_id = "<?= isset($_GET['u']) == true ? $_GET['u'] : null; ?>";
                        kanban_data(user_id);
                    }
                }
            });

        } else {
            detail_tasklist(id_task, id_si, id_so, divisi);
        }

    });

    $(document).on('mouseup', function() {
        $('.dragzonecard>div').css('cursor', 'pointer');
    });


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


    function calculate_time_history_log(time_string, time_end = null) {
        var targetDate = new Date(time_string);
        if (time_end == null) {
            var currentDate = new Date();
        } else {
            var currentDate = new Date(time_end);
        }

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
</script>