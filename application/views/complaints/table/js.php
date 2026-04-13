<script>
    function dt_complaints() {
        start = $('#start').val()
        end = $('#end').val()
        filter_category = $('#filter_category').val()
        filter_pic = $('#filter_pic').val()
        $('#dt_complaints').DataTable({
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
                    end: end,
                    filter_category: filter_category,
                    filter_pic: filter_pic,
                },
                "url": "<?= base_url(); ?>complaints/table/dt_complaints",
            },
            "columns": [{
                    className: 'dt-control text-center d-table-cell d-md-none',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                {
                    "data": "id_task",
                    "className": "d-md-table-cell text-left",
                    "render": function(data, type, row, meta) {
                        // user_id = "<?= $_SESSION['user_id'] ?>";
                        // if(user_id == '1'){
                        print = `<br><a href="<?= base_url(); ?>complaints/table/print_complaint/${row['id_task']}" target="_blank" role="button" class="badge bg-green" title="Print Form Complaint?">
                                            <i class="bi bi-printer"></i>
                                        </a>`
                        // }else{
                        //     print = ``;
                        // }
                        // tracking_konsumen = '';
                        // if(row['status'] == 'Done'){
                        tracking_konsumen = `<br><a href="<?= base_url(); ?>customer-complaints/${row['id_task_encrypted']}" target="_blank" role="button" class="badge bg-pink" title="Tracking Complain Konsumen">
                                        <i class="bi bi-arrow-up-right"></i> Tracking Status
                                    </a>`
                        // }
                        resend_notif = '';
                        if (row['id_status'] == 6) {
                            resend_notif = `<a href="javascript:void(0);" onclick="resend_notif_done('${row['id_task']}','${row['project']}','${row['blok']}','${row['owner_name']}')" class="badge bg-warning text-white"><i class="bi bi-whatsapp"></i> Resend Notif Done</a>`;
                        }
                        return `<div class="row">
                                    <div class="col-6 order-2 order-md-1">
                                        <div id="ellipsis-ex" class="d-inline-block text-truncate text-turncate-custom">
                                            <span class="text-nowrap small">${row['id_task']}</span>
                                            ${tracking_konsumen}
                                        </div>
                                    </div>
                                    <div class="col-6 order-1 order-md-2 text-center text-md-end">
                                        <a role="button" class="badge bg-light-blue" style="cursor:pointer;" onclick="detail_task('${row['id_task']}')">
                                            <i class="bi bi-info-circle"></i>
                                        </a>
                                        ${print}
                                        <a href="https://wa.me/${row['no_hp_konsumen']}" class="badge bg-green text-white" target="_blank"><i class="bi bi-whatsapp"></i> Chat</a>
                                        ${resend_notif}     
                                    </div>
                                </div>`
                    }
                },
                {
                    "data": "task",
                    "render": function(data, type, row, meta) {
                        return `${row['description']}`
                    }
                },
                {
                    "data": "category",
                    "render": function(data, type, row, meta) {
                        user_id = "<?= $_SESSION['user_id'] ?>";
                        btn_change_category = '';
                        if (user_id == '1' || user_id == '7972' || user_id == '8257' || user_id == '2951') {
                            btn_change_category = `<a href="javascript:void(0);" onclick="change_category('${row['id_task']}','${row['id_category']}')" class="badge bg-light-blue text-dark" title="Change Category"><i class="bi bi-pencil-square"></i></a>`;
                        }
                        return `<span class="text-nowrap small">${row['category']}</span> ${btn_change_category}`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "sumber_task",
                    "className": "d-none d-md-table-cell text-left text-nowrap"
                },
                {
                    "data": "ket_category",
                    "render": function(data, type, row, meta) {
                        return `${row['ket_category']}`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "project",
                    "render": function(data, type, row, meta) {
                        return `${row['project']}`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "blok",
                    "render": function(data, type, row, meta) {
                        return `${row['blok']}`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "status",
                    "render": function(data, type, row, meta) {
                        return `<a role="button" class="badge ${row['status_color']}" style="cursor:pointer;">${row['status']}</a>`;
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "priority",
                    "render": function(data, type, row, meta) {
                        if (row['priority'] != '') {
                            return `<span class="badge ${row['priority_color']}">${row['priority']}</span> `
                        } else {
                            return `<span class="badge bg-light text-dark">not specified</span> `
                        }
                    },
                    "className": "d-none d-md-table-cell text-left"
                },
                // {
                //     "data": "created_by",
                //     "render": function(data, type, row, meta) {
                //         resend_notif = '';
                //         konsumen = ` <p class="small text-secondary small" style="font-size:7pt;">${row['owner_contact_no']}</p>
                //             <a href="https://wa.me/${row['owner_contact_no']}" class="badge bg-green text-white" target="_blank"><i class="bi bi-whatsapp"></i> Chat</a>`;
                //         if (row['id_status'] == 6) {
                //             resend_notif = `<a href="javascript:void(0);" onclick="resend_notif_done('${row['id_task']}','${row['project']}','${row['blok']}','${row['owner_name']}')" class="badge bg-warning text-white"><i class="bi bi-whatsapp"></i> Resend Notif Done</a>`;
                //         }
                //         if ((row['nama_konsumen'] != '' || row['nama_konsumen'] != null) && row['created_by'] == '5428') {
                //             konsumen = `
                //             <div class="row p-0 m-0">
                //             <div class="col-6 d-flex align-items-center justify-content-center">
                //                 <a href="https://wa.me/${row['no_hp_konsumen']}" class="badge bg-green text-white" target="_blank"><i class="bi bi-whatsapp"></i> Chat</a>
                //             </div>
                //             <div class="col-6">
                //                 <p class="small text-secondary small" style="font-size:7pt;">${row['nama_konsumen']}</p>
                //                 <p class="small text-secondary small" style="font-size:7pt;">${row['no_hp_konsumen']}</p>
                //             </div>
                //             </div>
                //             `
                //             if (row['id_status'] == 6) {
                //                 resend_notif = `<a href="javascript:void(0);" onclick="resend_notif_done('${row['id_task']}','${row['project']}','${row['blok']}','${row['nama_konsumen']}')" class="badge bg-warning text-white"><i class="bi bi-whatsapp"></i> Resend Notif Done</a>`;
                //             }
                //         }
                //         return `
                //                 <div class="d-flex">
                //                     <div class="col-auto align-self-center" style="margin-right:8px;">
                //                         <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;https://trusmiverse.com/hr/uploads/profile/${row['owner_photo']}&quot;);">
                //                             <img src="https://trusmiverse.com/hr/uploads/profile/${row['owner_photo']}" alt="" style="display: none;">
                //                         </figure>
                //                     </div>
                //                     <div class="col align-self-center">
                //                         <p class="mb-0 small" style="font-size:8pt;">${row['owner_name']} | <span class="small text-secondary small" style="font-size:7pt;">${row['created_at']}</span></p>
                //                         <hr class="mt-1 mb-1 p-0">
                //                         ${konsumen}
                //                         ${resend_notif}
                //                     </div>
                //                 </div>
                //         `
                //     },
                //     "className": "d-none d-md-table-cell text-left text-nowrap"
                // },
                {
                    "data": "nama_konsumen",
                    "render": function(data, type, row, meta) {
                        return `${row['nama_konsumen']}`;
                    },
                    "className": "d-none d-md-table-cell text-left text-nowrap"
                },
                {
                    "data": "no_hp_konsumen",
                    "render": function(data, type, row, meta) {
                        return `${row['no_hp_konsumen']}`;
                    },
                    "className": "d-none d-md-table-cell text-left text-nowrap"
                },

                {
                    "data": "tgl_kunci",
                    "className": "d-none d-md-table-cell text-left text-nowrap"
                },

                {
                    "data": "tgl_pemasangan_kwh",
                    "className": "d-none d-md-table-cell text-left text-nowrap"
                },

                {
                    "data": "tgl_selesai_qc",
                    "className": "d-none d-md-table-cell text-left text-nowrap"
                },

                {
                    "data": "usia_bangunan",
                    "render": function(data, type, row, meta) {
                        return `${row['usia_bangunan']} Hari`
                    },
                    "className": "d-none d-md-table-cell text-left text-nowrap"
                },

                {
                    "data": "nama_vendor",
                    "className": "d-none d-md-table-cell text-left text-nowrap"
                },

                {
                    "data": "tgl_after_sales",
                    "className": "d-none d-md-table-cell text-left text-nowrap"
                },

                {
                    "data": "created_at",
                    "render": function(data, type, row, meta) {
                        return `${row['created_at']}`;
                    },
                    "className": "d-none d-md-table-cell text-left text-nowrap"
                },
                {
                    "data": "follow_up_at",
                    "className": "d-none d-md-table-cell text-left text-nowrap"
                },
                {
                    "data": "leadtime_follow_up",
                    "className": "d-none d-md-table-cell text-left text-nowrap"
                },
                // {
                //     "data": "verified_by",
                //     "render": function(data, type, row, meta) {
                //         return `
                //                 <div class="d-flex">
                //                     <div class="col-auto align-self-center" style="margin-right:8px;">
                //                         <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;https://trusmiverse.com/hr/uploads/profile/${row['verified_photo']}&quot;);">
                //                             <img src="https://trusmiverse.com/hr/uploads/profile/${row['verified_photo']}" alt="" style="display: none;">
                //                         </figure>
                //                     </div>
                //                     <div class="col align-self-center text-start">
                //                         <p class="mb-0 small" style="font-size:8pt;">${row['verified_name']}</p>
                //                         <hr class="m-0 p-0">
                //                         <p class="small text-secondary small" style="font-size:7pt;">${row['verified_at']}</p>
                //                     </div>
                //                 </div>
                //         `
                //     },
                //     "className": "d-none d-md-table-cell text-center"
                // },
                // {
                //     "data": "escalation_by",
                //     "render": function(data, type, row, meta) {
                //         return `
                //                 <div class="d-flex">
                //                     <div class="col-auto align-self-center" style="margin-right:8px;">
                //                         <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;https://trusmiverse.com/hr/uploads/profile/${row['escalation_photo']}&quot;);">
                //                             <img src="https://trusmiverse.com/hr/uploads/profile/${row['escalation_photo']}" alt="" style="display: none;">
                //                         </figure>
                //                     </div>
                //                     <div class="col align-self-center text-start">
                //                         <p class="mb-0 small" style="font-size:8pt;">${row['escalation_name']}</p>
                //                         <hr class="m-0 p-0">
                //                         <p class="small text-secondary small" style="font-size:7pt;">${row['escalation_at']}</p>
                //                     </div>
                //                 </div>
                //         `
                //     },
                //     "className": "d-none d-md-table-cell text-center"
                // },
                {
                    "data": "escalation_name",
                    "render": function(data, type, row, meta) {
                        return `${row['escalation_name']}`;
                    },
                    "className": "d-none d-md-table-cell text-left text-nowrap"
                },
                {
                    "data": "escalation_at",
                    "render": function(data, type, row, meta) {
                        return `${row['escalation_at']}`;
                    },
                    "className": "d-none d-md-table-cell text-left text-nowrap"
                },
                // {
                //     "data": "id_pic",
                //     "render": function(data, type, row, meta) {
                //         avatar_pic = ``;
                //         avatar_pic_plus = ``;
                //         if (row['profile_picture_pic'].indexOf(',') > -1) {
                //             array_pic = row['profile_picture_pic'].split(',');
                //             for (let index = 0; index < array_pic.length; index++) {
                //                 if (index < 2) {
                //                     avatar_pic += `<div class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;https://trusmiverse.com/hr/uploads/profile/${array_pic[index]}&quot;);">
                //                     <img src="https://trusmiverse.com/hr/uploads/profile/${array_pic[index]}" alt="" style="display: none;">
                //                     </div>`;
                //                 }
                //             }
                //             if (array_pic.length > 2) {
                //                 avatar_pic_plus = `<div class="avatar avatar-30 bg-light-theme rounded-circle me-1">
                //                         <p class="small">${parseInt(array_pic.length)-2}+</p>
                //                     </div>`;
                //             } else {
                //                 avatar_pic_plus = '';
                //             }
                //             return `
                //                     <div class="d-flex justify-content-center" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${row['team_name']}">
                //                         ${avatar_pic}${avatar_pic_plus}  
                //                     </div>
                //                 `
                //         } else {
                //             if (row['id_pic'] != '') {
                //                 return `
                //                 <div class="d-flex">
                //                     <div class="col-auto align-self-center text-start" style="margin-right:8px;">
                //                         <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;https://trusmiverse.com/hr/uploads/profile/${row['profile_picture_pic']}&quot;);">
                //                             <img src="https://trusmiverse.com/hr/uploads/profile/${row['profile_picture_pic']}" alt="" style="display: none;">
                //                         </figure>
                //                     </div>
                //                     <div class="col align-self-center text-start">
                //                         <p class="mb-0 small" style="font-size:8pt;">${row['team_name']}</p>
                //                         <hr class="m-0 p-0">
                //                         <p class="small text-secondary small" style="font-size:7pt;">${row['solver_at']}</p>
                //                     </div>
                //                 </div>
                //                 `;
                //             }

                //             return `<span class="badge bg-light text-dark">not yet selected</span>`

                //         }
                //     },
                //     "className": "d-none d-md-table-cell text-center"
                // },
                {
                    "data": "team_name",
                    "render": function(data, type, row, meta) {
                        return `${row['team_name'] == null ? '' : row['team_name']}`;
                    },
                    "className": "d-none d-md-table-cell text-left text-nowrap"
                },
                {
                    "data": "start",
                    "render": function(data, type, row, meta) {
                        if (row['start'] == "" || row['end'] == "" || row['start'] == "0000-00-00" || row['end'] == "0000-00-00") {
                            return `-`
                        } else {
                            // return `<span class="badge bg-light-red text-dark small">${row['start']}</span>`;
                            return `${row['start']}`;
                        }
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    "data": "tgl_due_date",
                    "render": function(data, type, row, meta) {
                        if (row['tgl_due_date'] == "" || row['tgl_due_date'] == '0000-00-00') {
                            return `<span class="badge bg-light text-dark">not yet estimated</span> `
                        } else {
                            // return `<span class="badge bg-light-red text-dark small" data-bs-toggle="tooltip" data-bs-placement="top" title="${row['due_date_text']}">${row['due_date']}</span>`;
                            return `${row['tgl_due_date']}`;
                        }
                    },
                    "className": "d-none d-md-table-cell text-center text-nowrap"
                },
                {
                    "data": "solver_at",
                    "render": function(data, type, row, meta) {
                        return `${row['solver_at']}`;
                    },
                    "className": "d-none d-md-table-cell text-left text-nowrap"
                },
                // {
                //     "data": "solver_at",
                //     "render": function(data, type, row, meta) {
                //         if (row['solver_at'] == "") {
                //             return `<span class="badge bg-light text-dark">${row['solver_at']}</span> `
                //         } else {
                //             return `<span class="badge bg-light-red text-dark small" data-bs-toggle="tooltip" data-bs-placement="top" title="${row['solver_at']}">${row['solver_at']}</span>`;
                //         }
                //     },
                //     "className": "d-none d-md-table-cell text-center"
                // },
                {
                    "data": "progress",
                    "render": function(data, type, row, meta) {
                        if (row['progress'] == "") {
                            return `-`
                        } else {
                            return `<span class="badge bg-light-green text-dark small">${row['progress']}%</span>`;
                        }
                    },
                    "className": "d-none d-md-table-cell text-end"
                },
                {
                    "data": "leadtime_process",
                    "render": function(data, type, row, meta) {
                        if (row['start'] == "" || row['end'] == "" || row['start'] == "0000-00-00" || row['end'] == "0000-00-00") {
                            return `-`
                        } else {
                            return `<span class="badge bg-light-yellow text-dark small">${row['leadtime_process']}</span>`;
                        }
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    "data": "leadtime_progress",
                    "render": function(data, type, row, meta) {
                        if (row['start'] == "" || row['end'] == "" || row['start'] == "0000-00-00" || row['end'] == "0000-00-00") {
                            return `-`
                        } else {
                            return `<span class="badge bg-light-blue text-dark small">${row['leadtime_progress']}</span>`;
                        }
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                // {
                //     "data": "rating_pelayanan",
                //     "render": function(data, type, row, meta) {
                //         return row['rating_pelayanan'];
                //     },
                //     "className": "d-none d-md-table-cell text-center"
                // },
                {
                    "data": "tgl_input_rating",
                    "render": function(data, type, row, meta) {
                        return `${row['tgl_input_rating']}`;
                    },
                    "className": "d-none d-md-table-cell text-center text-nowrap"
                },
                {
                    "data": "rating_kualitas",
                    "render": function(data, type, row, meta) {
                        return row['rating_kualitas'];
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    "data": "rating_respons",
                    "render": function(data, type, row, meta) {
                        return row['rating_respons'];
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    "data": "avg_rating",
                    "render": function(data, type, row, meta) {
                        return row['avg_rating'];
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    "data": "rating_rekomendasi",
                    "render": function(data, type, row, meta) {
                        return row['rating_rekomendasi'];
                    },
                    "className": "d-none d-md-table-cell text-center"
                },
                {
                    "data": "rating_feedback",
                    "render": function(data, type, row, meta) {
                        return row['rating_feedback'];
                    },
                    "className": "d-none d-md-table-cell text-left text-nowrap"
                },

            ],
        });
    }

    function change_category(id_task, category) {
        $('#modal_change_category').modal('show');
        $('#modal_change_category_label').text(`Change Category ${id_task}`);
        $('#id_task_category').val(id_task);
        $('#category_change').val(category);
    }

    function save_change_category() {
        var formData = $('#form_change_category').serialize();
        $.ajax({
            'url': "<?= base_url(); ?>complaints/main/change_category",
            'type': 'POST',
            'data': formData,
            'dataType': 'JSON',
            'success': function(response) {
                console.info(response);
                if (response.status == true) {
                    $('#modal_change_category').modal('hide');
                    dt_complaints();
                    $.toast({
                        title: 'success',
                        showProgress: 'top',
                        classProgress: 'blue',
                        message: `Category changed successfully`
                    });
                } else {
                    $.toast({
                        title: 'error',
                        showProgress: 'top',
                        classProgress: 'red',
                        message: `Failed to change category`
                    });
                }
            }
        })
    }

    // Add event listener for opening and closing details
    $('#dt_complaints tbody').on('click', 'td.dt-control', function() {
        var tr = $(this).closest('tr');
        var row = $('#dt_complaints').DataTable().row(tr);

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
        konsumen = '';
        if ((d.nama_konsumen != '' || d.nama_konsumen != null) && d.created_by == '5428') {
            konsumen = `<p class="small text-secondary small" style="font-size:7pt;">${d.nama_konsumen}</p>
            <p class="small text-secondary small" style="font-size:7pt;">${d.no_hp_konsumen}</p>
            <a href="https://wa.me/${d.no_hp_konsumen}" class="badge bg-green text-white" target="_blank"><i class="bi bi-whatsapp"></i> Chat</a>
            `
        }
        // `d` is the original data object for the row
        return (
            `
            <table class="table table-sm table-striped" style="table-layout:fixed;">
                <tbody>
                    <tr><td style="width:30%;"><b>Id</b></td><td>${d.id_task}</td></tr>
                    <tr><td style="width:30%;"><b>Title</b></td><td>${d.task}</td></tr>
                    <tr><td style="width:30%;"><b>Description</b></td><td>${d.description}</td></tr>
                    <tr><td style="width:30%;"><b>Type</b></td><td>${d.type}</td></tr>
                    <tr><td style="width:30%;"><b>Category</b></td><td>${d.category}</td></tr>
                    <tr><td style="width:30%;"><b>Object</b></td><td>${d.object}</td></tr>
                    <tr><td style="width:30%;"><b>Due Date</b></td><td>${d.due_date}</td></tr>
                    <tr><td style="width:30%;"><b>Priority</b></td><td>${d.priority}</td></tr>
                    <tr><td style="width:30%;"><b>Status</b></td><td>${d.status}</td></tr>
                    <tr><td style="width:30%;"><b>Progress</b></td><td>${d.progress}</td></tr>
                    <tr><td style="width:30%;"><b>Timeline</b></td><td>${d.timeline}</td></tr>
                    <tr><td style="width:30%;"><b>Lt. Process</b></td><td>${d.leadtime_process}</td></tr>
                    <tr><td style="width:30%;"><b>Lt. Progress</b></td><td>${d.leadtime_progress}</td></tr>
                    <tr><td style="width:30%;"><b>Created At</b></td><td>${d.tgl_dibuat}</td></tr>
                    <tr><td style="width:30%;"><b>Created By</b></td><td>${d.owner_name}</td></tr>
                    <tr><td style="width:30%;"><b>Created By</b></td><td>${konsumen}</td></tr>
                </tbody>
            </table>
            `
        );
    }

    function show_print_complaint(id_task) {
        console.info(id_task);
        $.ajax({
            'url': "<?= base_url(); ?>complaints/table/get_complaints_by_id",
            'type': 'POST',
            'data': {
                'id_task': id_task
            },
            'dataType': 'JSON',
            'success': function(response) {
                console.info(response);
                // $('#modal_print_complaint').modal('show');
                // $('#modal_print_complaint .modal-body').html(data);
            }
        })
    }


    function resend_notif_done(id_task, project, blok, nama) {
        $('#modal_confirm_resend_notif').modal('show');
        $('#modal_confirm_resend_notif .modal-body').html(`Are you sure want to resend notification for task id ${id_task}
        project : ${project}
        blok : ${blok}
        nama : ${nama}
        ?`);
        $('#btn_resend_notif').off().click(function() {
            var $btn = $(this);
            // $btn.prop('disabled', true).html('<i class="spinner-border spinner-border-sm"></i> Loading...');
            $.ajax({
                'url': "<?= base_url(); ?>complaints/main/resend_notif_done",
                'type': 'POST',
                'data': {
                    'id_task': id_task
                },
                'dataType': 'JSON',
                'success': function(response) {
                    console.info(response);
                    if (response.status == 'success') {
                        $.toast({
                            title: 'success',
                            showProgress: 'top',
                            classProgress: 'blue',
                            message: `Mengirim pesan notifikasi`
                        });
                    } else {
                        $.toast({
                            title: 'error',
                            showProgress: 'top',
                            classProgress: 'red',
                            message: `Mengirim pesan notifikasi`
                        });
                    }
                },
                'complete': function() {
                    // $btn.prop('disabled', false).html('Confirm');
                }
            });
            $('#modal_confirm_resend_notif').modal('hide');
        });
    }
</script>