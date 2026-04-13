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

            dragable = dragula([$('not_started_column'), $('working_on_column'), $('done_column'), $('stuck_column')])
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

    const stuck_column = document.querySelector('#stuck_column');
    stuck_column.addEventListener('mouseenter', () => {
        stuck_column.classList.add('is-hovered');
    });
    stuck_column.addEventListener('mouseleave', () => {
        stuck_column.classList.remove('is-hovered');
    });

    $(document).ready(function() {

        kanban_data()

    }); // END :: Ready Function


    function kanban_data(user_id = null) {

        filter_category = $("#filter_category :selected").val();
        if (filter_category == undefined) {
            filter_category = 'all';
        }
        pic = $("#filter_pic :selected").val();
        start = $("#start").val();
        end = $("#end").val();

        $.ajax({
            url: "<?= base_url('complaints/kanban/kanban_data') ?>",
            type: "POST",
            dataType: 'json',
            data: {
                user_id: user_id,
                category: filter_category,
                pic: pic,
                start: start,
                end: end,
            },
            beforeSend: function() {
                $('.kanban-body').empty();
            },
            success: function(response) {

                waiting_column = '';
                working_on = '';
                done = '';
                stuck = '';

                kanban_status_count_not_started = 0;
                kanban_status_count_working_on = 0;
                kanban_status_count_done = 0;
                kanban_status_count_stuck = 0;

                response.kanban.forEach((value, index) => {
                    kanban = '';

                    if (value.progress > 80) {
                        theme_color = 'theme-green';
                    } else if (value.progress > 45) {
                        theme_color = 'theme-yellow';
                    } else {
                        theme_color = 'theme-red';
                    }

                    kanban += `<div class="dragzonecard" data-id_task="${value.id_task}" onclick="detail_task('${value.id_task}')">
                                    <div class="card border-0 mb-2">
                                        <div class="card-body">
                                            <div class="row gx-2">
                                                <div class="col">

                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <div class="float-start">
                                                                <p class="text-secondary small">${calculate_created_at_hour(value.created_at)} ${calculate_created_at_time(value.created_at)}</p>
                                                                <span class="badge badge-sm badge-link me-1 bg-light-grey text-white tippy mt-1" data-tippy-content="${value.category.trim()}">
                                                                    <small class="small">${truncateString(value.category.trim(), 15)}</small>
                                                                </span>
                                                            </div>
                                                            <div class="float-end">
                                                                ${generate_priority_badge(value.level)}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" style="margin-top:-10px">
                                                        <div class="col">
                                                            <span>${value.task}</span>
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

                                                            <span class="badge badge-sm badge-link  me-1 bg-light-cyan tippy text-cyan" data-tippy-content="${value.category.trim()}">
                                                                <small class="small">${truncateString(value.category.trim(), 15)}</small>
                                                            </span>
                                                            <span class="badge badge-sm badge-link me-1  bg-light-green text-green tippy mt-1" data-tippy-content="${value.category.trim()}">
                                                                <small class="small">${truncateString(value.category.trim(), 15)}</small>
                                                            </span>

                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <div class="progress h-5 mb-1 bg-light-theme">
                                                                <div class="progress-bar bg-theme ${theme_color}" role="progressbar" style="width: ${value.progress}%" aria-valuenow="${value.progress}" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>

                                                            ${generate_leadtime(value.id_status, value.start, value.done)}
                                                            
                                                            <div class="float-end">
                                                                <small class="text-muted">${value.progress}%</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-secondary small mb-3" style="display: flex; justify-content: space-between;">
                                                        <span class="kanban_due_date"><i class="bi bi-calendar"></i> Due Date</span>
                                                        <span class="kanban_due_date">
                                                            ${generate_duedate_icon(value.due_date)}
                                                            ${convert_duedate(value.due_date)}
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="card-footer">
                                            <div class="row align-items-center gx-2">
                                                ${generate_foto(value.id_pic, value.pic, value.profile_picture)}
                                                <div class="col-auto">
                                                    ${generate_is_file_exist(value.attachment)}
                                                    <i class="bi bi-chat-right-dots avatar avatar-36 bg-light-gray rounded"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;



                    if (value.id_status == '1') { // 1 : not started
                        waiting_column += kanban;
                        kanban_status_count_not_started++;

                    } else if (value.id_status == '2') { // 2 : working on
                        working_on += kanban;
                        kanban_status_count_working_on++;

                    } else if (value.id_status == '3') { // 3 : done
                        done += kanban;
                        kanban_status_count_done++;

                    } else if (value.id_status == '4') { // 4 : stuck
                        stuck += kanban;
                        kanban_status_count_stuck++;

                    }

                });

                $('#waiting_column').html(waiting_column);
                $('#working_on_column').html(working_on);
                $('#done_column').html(done);
                $('#stuck_column').html(stuck);

                $('#kanban_status_count_not_started').html(kanban_status_count_not_started);
                $('#kanban_status_count_working_on').html(kanban_status_count_working_on);
                $('#kanban_status_count_done').html(kanban_status_count_done);
                $('#kanban_status_count_stuck').html(kanban_status_count_stuck);


                generate_progress_bar(kanban_status_count_not_started, kanban_status_count_working_on, kanban_status_count_done, kanban_status_count_stuck)

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

            }
        })
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

    function generate_leadtime(status, start, done) {
        if (status == '1') { // 1 : not started
            return ``
        } else if (status == '2') { // 2: working on

            return `<div class="float-start">
                        <small class="bi bi-clock text-muted"> <small>${calculate_created_at_time(start).replace('| ','')}</small></small>
                    </div>`

        } else if (status == '3' || status == '4') { // 3 : done, 4 : stuck
            return `<div class="float-start">
                        <small class="bi bi-clock text-muted"> <small>${calculate_created_at_time(start, done).replace('| ','')}</small></small>
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

    function generate_priority_badge(priority) {
        if (priority == '1') { // 1 : Sangat Mudah
            return `<img src="<?= base_url() ?>assets/badges/1.png" alt="-" height="50px">`
        } else if (priority == '2') { // 2 : Mudah
            return `<img src="<?= base_url() ?>assets/badges/2.png" alt="-" height="50px">`
        } else if (priority == '3') { // 3 : Sedang
            return `<img src="<?= base_url() ?>assets/badges/3.png" alt="-" height="50px">`
        } else if (priority == '4') { // 4 : Sulit
            return `<img src="<?= base_url() ?>assets/badges/4.png" alt="-" height="50px">`
        } else if (priority == '5') { // 5 : Sangat Sulit
            return `<img src="<?= base_url() ?>assets/badges/5.png" alt="-" height="50px">`
        } else {
            return ``
        }
    }

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

        if (!list_id_pic && !list_pic_name && !list_pic_name) {

            if (list_id_pic.indexOf(',') > -1) {
                array_id_pic = list_id_pic.split(',');
            } else {
                array_id_pic = list_id_pic;
            }
            if (list_pic_name.indexOf(',') > -1) {
                array_pic_name = list_pic_name.split(',');
            } else {
                array_pic_name = list_pic_name;
            }



            base_url = "http://trusmiverse.com/hr/uploads/profile";
            if (list_photo.indexOf(',') > -1) {
                array_photo = list_photo.split(',');
                array_photo.forEach((value, index) => {
                    if (index < '2') {
                        // photos += `<div class="avatar avatar-30 coverimg rounded-circle me-1"
                        //             data-bs-toggle="tooltip" data-bs-placement="top" title="${array_pic_name[index]}">
                        //             <img src="${base_url}/${array_photo[index]}" alt="">
                        //            </div>`;
                        photos += `<div class="avatar avatar-30 coverimg rounded-circle me-1 tippy"
                                data-tippy-content="${array_pic_name[index]}">
                            <img src="${base_url}/${array_photo[index]}" alt="">
                           </div>`;
                    }
                    if (array_photo.length > 2) {
                        more_photos += `<div
                                class="avatar avatar-30 bg-light-theme rounded-circle me-1">
                                <p class="small">2+</p>
                            </div>`;
                    }
                });
            } else {
                photos = ``;
                more_photos = ``;
            }
            generated_foto = `<div class="col">
                                ${photos}
                                ${more_photos}
                            </div>`;

            return generated_foto;
        }
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
        // console.info(id_task);

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
        } else if (source_id == 'stuck_column') {
            status_before = 4;
        }

        if (target_id == 'not_started_column') {
            status_after = 1;
        } else if (target_id == 'working_on_column') {
            status_after = 2;
        } else if (target_id == 'done_column') {
            status_after = 3;
        } else if (target_id == 'stuck_column') {
            status_after = 4;
        }

        // console.info(`status_after: ${status_after}`)
        // console.info(`status_before: ${status_before}`)

        // console.info(id_status)
        $('#detail_task_btn').click();

        $('#detail_id_task').val(id_task);
        $('#detail_status_before').val(status_before);
        $('#detail_status_after').val(status_after);

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
            detail_task(id_task);
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