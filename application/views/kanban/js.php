<script src="<?= base_url(); ?>assets/vendor/dragula/dragula.js" type="text/javascript"></script>
<script>
    var dragable;

    (function e(t, n, r) { function s(o, u) { if (!n[o]) { if (!t[o]) { var a = typeof require == "function" && require; if (!u && a) return a(o, !0); if (i) return i(o, !0); var f = new Error("Cannot find module '" + o + "'"); throw f.code = "MODULE_NOT_FOUND", f } var l = n[o] = { exports: {} }; t[o][0].call(l.exports, function (e) { var n = t[o][1][e]; return s(n ? n : e) }, l, l.exports, e, t, n, r) } return n[o].exports } var i = typeof require == "function" && require; for (var o = 0; o < r.length; o++)s(r[o]); return s })({
        1: [function (require, module, exports) {
            'use strict';

            dragable = dragula([$('not_started_column'), $('working_on_column'), $('done_column'), $('stuck_column')])
                .on('drag', function (el) {
                    el.className = el.className.replace('ex-moved', '');
                }).on('drop', function (el) {
                    el.className += ' ex-moved';
                }).on('over', function (el, container) {
                    container.className += ' ex-over';
                }).on('out', function (el, container) {
                    container.className = container.className.replace('ex-over', '');
                });

            function $(id) {
                return document.getElementById(id);
            }
        }, { "crossvent": 3 }]
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

    $(document).ready(function () {
        // generate_duedate_icon('2023-11-01');

        // calculate_time_history_log('2023-09-03')

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('#titlecalendar').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
        }

        $('.range').daterangepicker({
            startDate: start,
            endDate: end,
            "drops": "down",
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

        user_id = "<?= isset($_GET['u'])==true?$_GET['u']:null; ?>";
        kanban_data(user_id);

    }); // END :: Ready Function



    // $(window).on('load', function () {

    //     /* circular progress */


    // });




    function kanban_data(user_id=null) {

        $.ajax({
            url: "<?= base_url('kanban/kanban_data') ?>",
            type: "POST",
            dataType: 'json',
            data: {
                user_id: user_id,
            },
            beforeSend: function () {
                $('.kanban-body').empty();
            },
            success: function (response) {

                not_started = '';
                working_on = '';
                done = '';
                stuck = '';

                kanban_status_count_not_started = 0;
                kanban_status_count_working_on = 0;
                kanban_status_count_done = 0;
                kanban_status_count_stuck = 0;

                response.kanban.forEach((value, index) => {
                    kanban = '';

                    // get_sub_task(value.id_task);
                    kanban += `<div class="dragzonecard" data-id_task="${value.id_task}" onclick="detail_task('${value.id_task}')">
                                    <div class="card border-0 mb-4">
                                        <div class="card-body">
                                            <div class="row align-items-center gx-2">
                                                <div class="col">
                                                    <p class="text-secondary small">${calculate_created_at_hour(value.created_at)} ${calculate_created_at_time(value.created_at)}</p>
                                                    <div class="row">
                                                        <div class="col">
                                                            <h6>${value.task}</h6>
                                                        </div>
                                                        <div class="col-auto mb-4" style="margin-top:-20px; margin-right:10px">
                                                            <div class="circle-small">
                                                                <div id="progress_goals_${value.id_task}"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- <span class="btn btn-sm btn-link ${get_priority_color(value.id_priority)}">${value.priority}</span> -->
                                                    <span class="btn btn-sm btn-link ${get_strategy_color(value.jenis_strategy)}">${value.jenis_strategy}</span>
                                                    
                                                    <p class="text-secondary small mb-3">
                                                        <table style="width:100%">
                                                            <tbody>
                                                                ${value.sub_task.length>0?generate_sub_task(value.sub_task):''}
                                                            </tbody>
                                                        </table>
                                                    </p>
                                                    <br>
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
                                                    <i
                                                        class="bi bi-chat-right-dots avatar avatar-36 bg-light-gray rounded"></i>
                                                </div>
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

                    } else if (value.id_status == '4') { // 4 : stuck
                        stuck += kanban;
                        kanban_status_count_stuck++;

                    }

                });

                $('#not_started_column').html(not_started);
                $('#working_on_column').html(working_on);
                $('#done_column').html(done);
                $('#stuck_column').html(stuck);

                $('#kanban_status_count_not_started').html(kanban_status_count_not_started);
                $('#kanban_status_count_working_on').html(kanban_status_count_working_on);
                $('#kanban_status_count_done').html(kanban_status_count_done);
                $('#kanban_status_count_stuck').html(kanban_status_count_stuck);

                
            },
            complete: function (response) {
                data = JSON.parse(response.responseText);
                data.kanban.forEach((value, index) => {
                    // percent bar
                    // console.info(value.sub_task)
                    consistency = 0;
                    value.sub_task.forEach((val, i) => {
                        consistency += parseInt(val.consistency);
                    })

                    percent = parseFloat((consistency / value.sub_task.length) / 100);

                    if(percent.toString() == 'NaN'){
                        percent = 0;
                    }

                    intialize_progres_bar(`progress_goals_${value.id_task}`).animate(percent);
                });

            }
        })
    }

    function generate_sub_task(sub_task){
        // return sub_task;
        sub_task_list = ``;
        sub_task.forEach((value, index) => {
            sub_task_list += `<tr>
                                <td style="vertical-align: top;">${generate_type_badge(value.id_type)}</td>
                                <td style="vertical-align: top;">${value.sub_task}</td>
                                <td style="vertical-align: top; text-align:right"><span class="badge badge-sm ${generate_sub_task_bg_color(value.consistency)}">${value.consistency}%</span></td>
                            </tr>`; 
        });
        return sub_task_list;
    }

    function generate_sub_task_bg_color(progress){
        if(progress == 0){
            badge = `bg-red`;
        }else if(progress > 0 && progress < 51){
            badge = `bg-yellow`;
        }else{
            badge = `bg-green`;
        }
        return badge;
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

    function calculate_created_at_time(time_string) {
        var targetDate = new Date(time_string);
        var currentDate = new Date();
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
            from: { color: '#3d99fc', width: 10 },
            to: { color: '#3d99fc', width: 10 },
            // Set default step function for all animate calls
            step: function (state, circle) {
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

    function get_strategy_color(strategy) {
        if (strategy == 'Once') {
            strategy_color = 'tag bg-light-pink theme-teal me-1 mt-1 text-pink';
        } else {
            strategy_color = 'tag bg-light-red theme-teal me-1 mt-1 text-red';
        }
        return strategy_color;
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
            return `<span class="bi bi-bi bi-exclamation-circle-fill text-danger" style="font-size: 16px;" title="${Math.abs(daysDifference)} days overdue"></span>`;
        } else if (daysDifference == 0) {
            return `<span class="bi bi-bi bi-circle-fill" style="font-size: 16px;" title="Today"></span>`;
        } else if (daysDifference == 1) {
            return `<span class="bi bi-bi bi-1-circle-fill" style="font-size: 16px;" title="${daysDifference} days left"></span>`;
        } else if (daysDifference == 2) {
            return `<span class="bi bi-bi bi-2-circle-fill" style="font-size: 16px;" title="${daysDifference} days left"></span>`;
        } else if (daysDifference == 3) {
            return `<span class="bi bi-bi bi-3-circle-fill" style="font-size: 16px;" title="${daysDifference} days left"></span>`;
        } else if (daysDifference == 4) {
            return `<span class="bi bi-bi bi-4-circle-fill" style="font-size: 16px;" title="${daysDifference} days left"></span>`;
        } else if (daysDifference == 5) {
            return `<span class="bi bi-bi bi-5-circle-fill" style="font-size: 16px;" title="${daysDifference} days left"></span>`;
        } else if (daysDifference == 6) {
            return `<span class="bi bi-bi bi-6-circle-fill" style="font-size: 16px;" title="${daysDifference} days left"></span>`;
        } else if (daysDifference == 7) {
            return `<span class="bi bi-bi bi-7-circle-fill" style="font-size: 16px;" title="${daysDifference} days left"></span>`;
        } else if (daysDifference > 7) {
            return `<span class="bi bi-bi bi-circle" style="font-size: 16px;" title="${daysDifference} days left"></span>`;
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

        base_url = "http://trusmiverse.com/hr/uploads/profile";

        photos = ``;
        array_photo.forEach((value, index) => {
            if (index < '2') {
                photos += `<div class="avatar avatar-30 coverimg rounded-circle me-1"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="${array_pic_name[index]}">
                            <img src="${base_url}/${array_photo[index]}" alt="">
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

    function generate_is_file_exist(attachment){
        if(attachment != ''){
            return `<i class="bi bi-paperclip avatar avatar-36 bg-light-gray rounded"></i>`;
        }else{
            return ``;
        }
    }



    // Add event listeners
    dragable.on('drag', function (el, source) {
        var id_task = el.dataset.id_task;
    });


    dragable.on('drop', function (el, target, source, sibling) {
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
        

        if(status_after < status_before){
            $.confirm({
                title: 'Upss...',
                content: 'You are not allowed to revert to a previous status.',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    close: function () {
                        kanban_data()
                    }
                }
            });

        }else{
            detail_task(id_task);
        }
        


    });

</script>


<?php $this->load->view('monday/details/js') ?>
<?php $this->load->view('monday/details/js_detail'); ?>
<?php $this->load->view('kanban/details/js') ?>