<script type="text/javascript" src="<?= base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>

<!-- include summernote css/js -->
<link href="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.css" rel="stylesheet">
<script src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>

<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<?php $this->load->view('monday_dev/details/js'); ?>

<script>
    $(document).ready(function() {

        $('.tanggal').datetimepicker({
            format: 'Y-m-d',
            timepicker: false,
            scrollMonth: false,
            scrollInput: false

        });

        $(".tanggal").mask('0000-00-00')

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));
            $('#start').val(start.format('YYYY-MM-DD'));
            $('#end').val(end.format('YYYY-MM-DD'));
            dt_task();
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

        // $('#description').summernote({
        //     placeholder: 'Description',
        //     tabsize: 2,
        //     height: 120,
        //     toolbar: [
        //         ['font', ['bold', 'underline', 'clear']],
        //         ['para', ['ul', 'ol', 'paragraph']],
        //     ]
        // });

        // $('#indicator').summernote({
        //     placeholder: 'Indicator',
        //     tabsize: 2,
        //     height: 150,
        //     toolbar: [
        //         ['font', ['bold', 'underline', 'clear']],
        //         ['para', ['ul', 'ol', 'paragraph']],
        //     ]
        // });
        // $('#strategy').summernote({
        //     placeholder: 'Strategy',
        //     tabsize: 2,
        //     height: 150,
        //     toolbar: [
        //         ['font', ['bold', 'underline', 'clear']],
        //         ['para', ['ul', 'ol', 'paragraph']],
        //     ]
        // });
    });

    $('#ceklis_pekerjaan').change(function(e) {
        e.preventDefault();
        if ($(this).is(':checked')) {
            $('.row_pekerjaan').show();
        } else {
            $('.row_pekerjaan').hide();
        }
    });

    $('#id_project').change(function(e) {
        e.preventDefault();
        var pekerjaan = $(this).val();
        $.ajax({
            type: "GET",
            url: "<?= base_url('monday_dev/get_pekerjaan'); ?>/" + pekerjaan,
            dataType: "json",
            success: function(response) {
                let list_sub = '<option value="" selected disabled>Pilih Pekerjaan</option>';
                if (response != null) {
                    response.forEach(item => {
                        list_sub += `<option value="${item.id}">${item.pekerjaan}</option>`;
                    });
                }
                $("#id_pekerjaan").empty().append(list_sub).prop('disabled', false);
                id_pekerjaan.update();
            }
        });
    });
    $('#id_pekerjaan').change(function(e) {
        e.preventDefault();
        var pekerjaan = $(this).val();
        $.ajax({
            type: "GET",
            url: "<?= base_url('monday_dev/get_sub_pekerjaan'); ?>/" + pekerjaan,
            dataType: "json",
            success: function(response) {
                let list_sub = '<option value="" selected disabled>Pilih Sub Pekerjaan</option>';
                if (response != null) {
                    response.forEach(item => {
                        list_sub += `<option value="${item.id}">${item.sub_pekerjaan}</option>`;
                    });
                }
                $("#id_sub_pekerjaan").empty().append(list_sub).prop('disabled', false);
                id_sub_pekerjaan.update();
            }
        });
    });
    $('#id_sub_pekerjaan').change(function(e) {
        e.preventDefault();
        var pekerjaan = $(this).val();
        $.ajax({
            type: "GET",
            url: "<?= base_url('monday_dev/get_det_pekerjaan'); ?>/" + pekerjaan,
            dataType: "json",
            success: function(response) {
                let list_sub = '';
                if (response != null) {
                    response.forEach(item => {
                        list_sub += `<option value="${item.id}">${item.detail}</option>`;
                    });
                }
                $("#id_detail_pekerjaan").empty().append(list_sub).prop('disabled', false);
                id_detail_pekerjaan.update();
            }
        });
    });

    function dt_task() {
        start = $('#start').val()
        end = $('#end').val()
        $('#dt_task').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="bi bi-download text-white"></i>',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    start: start,
                    end: end
                },
                "url": "<?= base_url(); ?>monday/dt_task",
            },
            "columns": [{
                    className: 'dt-control text-center d-table-cell d-md-none',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                {
                    "data": "task",
                    "render": function(data, type, row, meta) {
                        return `<div class="row">
                                    <div class="col-8 order-2 order-md-1">
                                        <div id="ellipsis-ex" class="d-inline-block text-truncate text-turncate-custom">
                                            <span data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${row['task']}">${row['task']}</span><br>
                                        </div>
                                    </div>
                                    <div class="col-4 order-1 order-md-2 text-center text-md-end">
                                        <a role="button" class="badge bg-light-blue" style="cursor:pointer;" onclick="detail_task('${row['id_task']}')">
                                            <i class="bi bi-info-circle"></i>
                                        </a>
                                    </div>
                                </div>`
                    }
                },
                // {
                //     "data": "created_by",
                //     "render": function(data, type, row, meta) {
                //         return `
                //         <a role="button" rel="popover" class="badge bg-light-blue" style="cursor:pointer;"
                //                 tabindex="0"
                //                 data-bs-container="body" 
                //                 data-bs-toggle="popover" 
                //                 data-bs-placement="top" 
                //                 data-bs-content='
                //                     <div class="card-body">
                //                         <div class="row align-items-center">
                //                             <div class="col-auto">
                //                                 <div class="avatar avatar-50 rounded-circle coverimg" style="background-image: url(&quot;https://trusmiverse.com/hr/uploads/profile/${row['owner_photo']}&quot;);">
                //                                     <img src="https://trusmiverse.com/hr/uploads/profile/${row['owner_photo']}" alt="" style="display: none;">
                //                                 </div>
                //                             </div>
                //                             <div class="col">
                //                                 <h6 class="fw-medium mb-0 small">${row[`owner_name`]}</h6>
                //                                 <p class="small text-secondary m-0">${row['owner_company']}</p>
                //                                 <p class="small text-secondary m-0">${row['owner_department']}</p>
                //                             </div>
                //                             <div class="col-auto">
                //                             </div>
                //                         </div>
                //                     </div>' 
                //         >
                //             <i class="bi bi-person-circle"></i>
                //         </a>
                //             `
                //     },
                //     "className": "text-center"
                // },
                {
                    "data": "id_pic",
                    "render": function(data, type, row, meta) {
                        avatar_pic = ``;
                        avatar_pic_plus = ``;
                        if (row['profile_picture_pic'].indexOf(',') > -1) {
                            array_pic = row['profile_picture_pic'].split(',');
                            for (let index = 0; index < array_pic.length; index++) {
                                if (index < 2) {
                                    avatar_pic += `<div class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${array_pic[index]}&quot;);">
                                    <img src="http://trusmiverse.com/hr/uploads/profile/${array_pic[index]}" alt="" style="display: none;">
                                    </div>`;
                                }
                            }
                            if (array_pic.length > 2) {
                                avatar_pic_plus = `<div class="avatar avatar-30 bg-light-theme rounded-circle me-1">
                                        <p class="small">${parseInt(array_pic.length)-2}+</p>
                                    </div>`;
                            } else {
                                avatar_pic_plus = '';
                            }
                        } else {
                            avatar_pic += `<div class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${row['profile_picture_pic']}&quot;);">
                                        <img src="http://trusmiverse.com/hr/uploads/profile/${row['profile_picture_pic']}" alt="" style="display: none;">
                                    </div>`;
                            avatar_pic_plus = '';
                        }
                        return `
                                <div class="d-flex justify-content-center" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${row['team_name']}">
                                    ${avatar_pic}${avatar_pic_plus}  
                                </div>
                            `
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    "data": "type",
                    "render": function(data, type, row, meta) {
                        if (row['id_type'] == 1) {

                            return `<span class="badge bg-light-green text-dark">${row['type']}</span>`
                        } else {
                            return `<span class="badge bg-light-yellow text-dark">${row['type']}</span>`

                        }
                    },
                    "className": "d-none d-md-table-cell"
                },
                {
                    "data": "due_date",
                    "render": function(data, type, row, meta) {
                        return `<div class="d-flex justify-content-center">
                        <a role="button" data-bs-toggle="tooltip" data-bs-placement="top" title="${row['due_date_text']}" style="margin-right:10px;">
                        <span class="badge ${row['due_date_style']} text-white"><i class="bi bi-clock-history"></i></a></span> <span class="">${row['due_date']}</span>
                        </div>`
                    },
                    "className": "d-none d-md-table-cell"
                },
                // {
                //     "data": "priority",
                //     "render": function(data, type, row, meta) {
                //         if (row['id_priority'] == 1) {
                //             prior_class = ` bg-light-blue text-blue`
                //         } else if (row['id_priority'] == 2) {
                //             prior_class = `bg-light-purple text-purple`
                //         } else if (row['id_priority'] == 3) {
                //             prior_class = `bg-light-cyan text-cyan`
                //         } else if (row['id_priority'] == 3) {
                //             prior_class = `bg-light-cyan text-cyan`
                //         } else if (row['id_priority'] == 4) {
                //             prior_class = `bg-light-green text-green`
                //         } else {
                //             prior_class = `bg-light text-light`
                //         }
                //         return `<a role="button" class="btn btn-sm btn-link ${prior_class}" style="cursor:pointer;"
                //         rel="popover" style="cursor:pointer;"
                //         tabindex="0"
                //         data-bs-container="body" 
                //         data-bs-toggle="popover-priority" 
                //         data-bs-placement="top" 
                //         onclick="generate_button_priority('${row['id_task']}')"


                //         >${row['priority']}</a>`;
                //     },
                //     "className": "d-none d-md-table-cell text-left"
                // },
                {
                    "data": "status",
                    "render": function(data, type, row, meta) {
                        return `<a role="button" onclick="detail_task('${row['id_task']}')" class="btn btn-sm btn-link text-white" style="cursor:pointer;background-color:${row['status_color']}">${row['status']}</a>`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                // {
                //     "data": "indicator",
                //     "render": function(data, type, row, meta) {
                //         return `<div class="row">
                //                     <div class="col">
                //                         <div id="ellipsis-ex" class="d-inline-block text-truncate" style="max-width: 150px;">
                //                             <span data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${row['indicator']}">${row['indicator']}</span><br>
                //                         </div>
                //                     </div>
                //                 </div>`
                //     },
                //     "className": "d-none d-md-table-cell text-left"
                // },
                {
                    "data": "strategy",
                    "render": function(data, type, row, meta) {
                        if (row['strategy'].indexOf(',') != -1) {
                            element_strategy = `<ol>`
                            var segments = row['strategy'].split(',');
                            for (let index = 0; index < segments.length; index++) {
                                element_strategy += `<li>${segments[index]}</li>`
                            }
                            element_strategy += `</ol>`
                        } else {
                            element_strategy = `${row['strategy']}`
                        }
                        return `<div class="row">
                                    <div class="col">
                                        <div id="ellipsis-ex" class="d-inline-block text-truncate" style="max-width: 150px;">
                                            <span data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${row['strategy']}">${element_strategy}</span><br>
                                        </div>
                                    </div>
                                </div>`
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "jenis_strategy",
                    "render": function(data, type, row, meta) {
                        if (row['jenis_strategy'] == "Once") {
                            jenis_strategy_class = ` bg-light-green text-green`
                        } else {
                            jenis_strategy_class = `bg-light-red text-red`
                        }
                        return `<a role="button" class="btn btn-sm btn-link ${jenis_strategy_class}" style="cursor:pointer;" style="cursor:pointer;">${row['jenis_strategy']}</a>`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "progress",
                    "className": "d-none d-md-table-cell text-end"
                },
                {
                    "data": "timeline",
                    "render": function(data, type, row, meta) {
                        if (row['start'] == "" || row['end'] == "" || row['start'] == "0000-00-00" || row['end'] == "0000-00-00") {
                            return `-`
                        } else {
                            return `<span class="badge bg-light-blue text-blue small">${row['timeline']}</span>`;
                        }
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    "data": "evaluation",
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "created_by",
                    "render": function(data, type, row, meta) {
                        return `<div class="align-items-center">
                                <div class="col-auto ps-0">
                                    <p class="text-secondary m-0 small">${row['tgl_dibuat']} | <span class="text-secondary m-0 small">${row['owner_username']} </span></p>                                    
                                </div>
                            </div>`
                    },
                    "className": "d-none d-md-table-cell text-left"
                },

            ],
            // "createdRow": function(row, data, dataIndex) {
            //     console.log(data['priority']);
            //     if (data['priority'] == "Critical") {
            //         $('td:eq(4)', row).addClass('table-critical');
            //     }

            // }
        });
    }

    // Add event listener for opening and closing details
    $('#dt_task tbody').on('click', 'td.dt-control', function() {
        var tr = $(this).closest('tr');
        var row = $('#dt_task').DataTable().row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(dt_detail_task(row.data())).show();
            tr.addClass('shown');
        }
    });

    function dt_detail_task(d) {
        // `d` is the original data object for the row
        // <tr><td style="width:30%;"><b>Indicator</b></td><td>${d.indicator}</td></tr>

        return (
            `
            <table class="table table-sm table-striped" style="table-layout:fixed;">
                <tbody>
                    <tr><td style="width:30%;"><b>Id</b></td><td>${d.id_task}</td></tr>
                    <tr><td style="width:30%;"><b>Goals</b></td><td>${d.task}</td></tr>
                    <tr><td style="width:30%;"><b>Strategy</b></td><td>${d.strategy}</td></tr>
                    <tr><td style="width:30%;"><b>Jenis Strategy</b></td><td>${d.jenis_strategy}</td></tr>
                    <tr><td style="width:30%;"><b>Team</b></td><td>${d.team_name}</td></tr>
                    <tr><td style="width:30%;"><b>Due Date</b></td><td>${d.due_date}</td></tr>
                    <tr><td style="width:30%;"><b>Priority</b></td><td>${d.priority}</td></tr>
                    <tr><td style="width:30%;"><b>Status</b></td><td>${d.status}</td></tr>
                    <tr><td style="width:30%;"><b>Progress</b></td><td>${d.progress}</td></tr>
                    <tr><td style="width:30%;"><b>Timeline</b></td><td>${d.timeline}</td></tr>
                    <tr><td style="width:30%;"><b>Evaluation</b></td><td>${d.evaluation}</td></tr>
                    <tr><td style="width:30%;"><b>Created At</b></td><td>${d.tgl_dibuat}</td></tr>
                    <tr><td style="width:30%;"><b>Created By</b></td><td>${d.owner_name}</td></tr>
                </tbody>
            </table>
            `
        );
    }



    $(window).on("load", function() {
        // tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        // popover
        var popoverTriggerList = [].slice.call(
            document.querySelectorAll('[rel="popover"]')
        );
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl, {
                html: true,
                trigger: 'click'
            });
        });

        $('body')
            .on('mousedown', '.popover', function(e) {
                console.log("clicked inside popover")
                e.preventDefault()
            });
    });


    // function generate_button_priority(id_task) {
    //     console.log(id_task);
    //     bsPopover = new bootstrap.Popover(document.querySelector('[data-bs-toggle="popover-priority"]'), {
    //         placement: 'top',
    //         trigger: 'focus',
    //         html: true,
    //         animation: false,
    //     });
    //     bsPopover._config.content = `<div class="col">
    //                                         <div class="card-body">
    //                                             <div class="align-items-center">
    //                                                 <div class="col-auto m-1">
    //                                                     test
    //                                                     <input type="text" name="id_task_priority">
    //                                                 </div>
    //                                                 <div class="col-auto m-1">
    //                                                     <a role="button" class="badge-4 badge text-white High" id="update_priority_1"  data-id_task_priority="test">High</a>
    //                                                 </div>
    //                                                 <div class="col-auto m-1">
    //                                                     <a role="button" class="badge-4 badge text-white High" id="update_priority_2">High</a>
    //                                                 </div>
    //                                                 <div class="col-auto m-1">
    //                                                     <a role="button" class="badge-4 badge text-white Medium" id="update_priority_3">Medium</a>
    //                                                 </div>
    //                                                 <div class="col-auto m-1">
    //                                                     <a role="button" class="badge-4 badge text-white Low" id="update_priority_4">Low</a>
    //                                                 </div>
    //                                             </div>
    //                                         </div>
    //                                     </div>`;
    // }


    // function update_priority(id_task, id_priority) {
    //     $.ajax({
    //         url: '<?= base_url() ?>monday/update_priority',
    //         type: 'POST',
    //         dataType: 'json',
    //         data: {
    //             id_task: id_task,
    //             id_priority: id_priority,
    //         },
    //         beforeSend: function() {

    //         },
    //         success: function(response) {

    //         },
    //         error: function(xhr) { // if error occured

    //         },
    //         complete: function() {

    //         },
    //     }).done(function(response) {
    //         if (response == true) {
    //             dt_task();
    //         }
    //     }).fail(function(jqXhr, textStatus) {

    //     });
    // }

    // let e_sel_id_type = NiceSelect.bind(document.getElementById('e_id_type'), {
    //     searchable: true
    // });

    // let e_sel_id_category = NiceSelect.bind(document.getElementById('e_id_category'), {
    //     searchable: true
    // });

    // let e_sel_id_object = NiceSelect.bind(document.getElementById('e_id_object'), {
    //     searchable: true
    // });

    // let e_sel_id_priority = NiceSelect.bind(document.getElementById('e_id_priority'), {
    //     searchable: true
    // });


    // let e_sel_id_pic = NiceSelect.bind(document.getElementById('e_id_pic'), {
    //     searchable: true
    // });

    // $('#e_description').summernote({
    //     placeholder: 'Description',
    //     tabsize: 2,
    //     height: 120,
    //     toolbar: [],
    // });


    // $('#e_description').summernote('disable');



    // $('#e_indicator').summernote({
    //     placeholder: 'Indicator',
    //     tabsize: 2,
    //     height: 150,
    //     toolbar: []
    // });

    // $('#e_indicator').summernote('disable');

    // $('#e_strategy').summernote({
    //     placeholder: 'Strategy',
    //     tabsize: 2,
    //     height: 150,
    //     toolbar: []
    // });

    // $('#e_strategy').summernote('disable');

    // $('#e_evaluation').summernote({
    //     placeholder: 'Evaluation',
    //     tabsize: 2,
    //     height: 150,
    //     toolbar: []
    // });

    function generate_foto(list_id_pic, list_pic_name, list_photo) {

        array_id_pic = list_id_pic.split(',');
        array_pic_name = list_pic_name.split(',');
        array_photo = list_photo.split(',');

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
</script>

<?php $this->load->view('monday/details/js_detail'); ?>
<?php $this->load->view('kanban/details/js'); ?>