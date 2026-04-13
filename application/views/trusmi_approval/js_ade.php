<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>


<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>


<script>
    $(document).ready(function() {
        $('#dt_trusmi_approval').DataTable();
        dt_trusmi_approval('#dt_trusmi_approval', 'all', '<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');
        get_approve_to();

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
            dt_trusmi_approval('#dt_trusmi_approval', 'all', start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'))
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

    });

    $(window).on('load', function() {
        modal_waiting_open = $('#modal_open_waiting').val();
        no_app_waiting = $('#no_app_waiting').val();
        // console.log(modal_waiting_open);
        if (modal_waiting_open == 'open') {
            modal_approve_waiting(no_app_waiting);
        }
    });


    function compress(file_upload, string, submit, wait, done) {

        $(wait).show();
        $(done).hide();
        $(submit).prop('disabled', true);

        const file = document.querySelector(file_upload).files[0];

        extension = file.name.substr((file.name.lastIndexOf('.') + 1));

        if (!file) return;

        const reader = new FileReader();

        reader.readAsDataURL(file);

        reader.onload = function(event) {
            const imgElement = document.createElement("img");
            imgElement.src = event.target.result;

            if (extension == "jpg" || extension == "jpeg" || extension == "png" || extension == "gif") {

                extension = 'png,';

                imgElement.onload = function(e) {
                    const canvas = document.createElement("canvas");

                    if (e.target.width > e.target.height) {
                        const MAX_WIDTH = 1024;
                        const scaleSize = MAX_WIDTH / e.target.width;
                        canvas.width = MAX_WIDTH;
                        canvas.height = e.target.height * scaleSize;
                    } else {
                        const MAX_HEIGHT = 1024;
                        const scaleSize = MAX_HEIGHT / e.target.height;
                        canvas.height = MAX_HEIGHT;
                        canvas.width = e.target.width * scaleSize;
                    }

                    const ctx = canvas.getContext("2d");

                    ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);

                    const srcEncoded = ctx.canvas.toDataURL(e.target, "image/jpeg");

                    var g_string = extension + srcEncoded.substr(srcEncoded.indexOf(',') + 1);
                    // document.querySelector(string).value = g_string;
                    saveFile(g_string, wait, done, string, submit);
                }
            } else {
                var g_string = extension + ',' + event.target.result.substr(event.target.result.indexOf(',') + 1);
                // document.querySelector(string).value = g_string;
                saveFile(g_string, wait, done, string, submit);
            }

        }
    }

    function saveFile(string, wait, done, str, submit) {

        $.ajax({
            'url': '<?php echo base_url() ?>trusmi_approval/upload_file',
            'type': 'POST',
            'data': {
                string: string
            },
            'success': function(response) {
                document.querySelector(str).value = response;
                $(submit).prop('disabled', false);
                $(wait).hide();
                $(done).show();
            }
        });
    }


    function dt_trusmi_approval(id_tabel, id_status, start, end, modal = '') {
        url = "<?= base_url(); ?>trusmi_approval/dt_trusmi_approval";
        $(id_tabel).DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [5, 'desc']
            ],
            // rowReorder: {
            //     selector: 'td:nth-child(2)'
            // },
            // responsive: true,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": url,
                "data": {
                    start: start,
                    end: end,
                    id_status: id_status
                }
            },
            "columns": [{
                    "data": "no_app",
                    "render": function(data, type, row) {
                        var old = ``;
                        if (row.old_no_app != null) {
                            old = `<span class="badge bg-secondary small">Old : ${row['old_no_app']}</span>`;
                        }
                        return `<div class="align-items-center">
                                    <div class="col-auto ps-0">
                                        <p>${row['no_app']}</p>
                                        ${old}
                                    </div>
                                </div>`;
                    },
                    "className": "text-center",
                }, {
                    "data": "subject",
                    "render": function(data, type, row) {
                        // var old = ``;
                        // if (row.old_no_app != null) {
                        //     old = `<span class="badge bg-secondary small">Old : ${row['old_no_app']}</span>`;
                        // }
                        // return `<div class="align-items-center">
                        //             <div class="col-auto ps-0">
                        //                 <p class="mb-0 small">${row['subject']}</p>
                        //                 <hr style="margin-top:3px;margin-bottom:3px;">
                        //                 <p class="text-secondary small">${row['no_app']}</p>
                        //                 ${old}
                        //             </div>
                        //         </div>`;
                        return `<div class="align-items-center">
                                    <div class="col-auto ps-0">
                                        <p class="mb-0 small">${row['subject']}</p>
                                    </div>
                                </div>`;
                    }
                },
                {
                    "data": "description",
                    "render": function(data, type, row) {
                        if (data == null) {
                            return '';
                        } else {
                            return `<p class="mb-0 small">${data}</p>`;
                        }
                    },
                },
                {
                    "data": "created_by",
                    "render": function(data, type, row) {
                        return `${data} <p class="text-secondary small">${row['created_at']} | ${row['created_hour']}</p>`;
                    },
                },
                {
                    "data": "approve_to",
                    "render": function(data, type, row) {
                        // if (data == null) {
                        //     return '';
                        // } else {
                        //     if (row['approve_by'] == null) {
                        //         return `<div class="row align-items-center">
                        //                     <div class="col-auto ps-0">
                        //                         <span class="text-muted small">Req By : ${row['created_by']}</span>
                        //                         <p class="text-secondary small">${row['created_at']} | ${row['created_hour']}</p>
                        //                         <hr style="margin-top:3px;margin-bottom:3px;">
                        //                         <span class="text-muted small">Approve To : ${data}</span>                                                
                        //                     </div>
                        //                 </div>`;

                        //     } else {
                        //         return `<div class="row align-items-center">
                        //                 <div class="col-auto ps-0">
                        //                     <span class="text-muted small">Req By : ${row['created_by']}</span>
                        //                     <p class="text-secondary small">${row['created_at']} | ${row['created_hour']}</p>
                        //                     <hr style="margin-top:3px;margin-bottom:3px;">
                        //                     <span class="text-muted small">Approve To : ${row['approve_by']}</span>
                        //                 </div>
                        //             </div>`;
                        //     }
                        // }
                        if (data == null) {
                            return ``
                        } else {
                            if (row['approve_by'] == null) {
                                return `${data}`;

                            } else {
                                return `${row['approve_by']}`;
                            }
                        }
                    },
                },
                {
                    "data": "approve_by",
                    "render": function(data, type, row) {
                        if (row['approve_by'] == null) {
                            return '';
                        } else {
                            return `${data}
                                    <p class="mb-0 text-secondary small">${row['approve_at']} | ${row['approve_hour']}</p>
                                    `;
                        }
                    },
                },
                {
                    "data": "id_status",
                    "render": function(data, type, row) {
                        link_integrate = ``; // addnew
                        if (data == 1) {
                            if (modal == '1') {
                                status = `<a type="button" onclick="modal_approve('${sanitize(row['no_app'])}', '${sanitize(row['subject'])}', '${sanitize(row['approve_to'])}', '${sanitize(row['description'])}', '${sanitize(row['file_1'])}', '${sanitize(row['file_2'])}', '${sanitize(row['created_by'])}')"><span class="badge badge-sm bg-yellow">${row['status']}</span></a>`;
                            } else {
                                status = `<span class="badge badge-sm small bg-yellow">${row['status']}</span>`;
                            }
                        } else if (data == 2) { // ACC
                            status = `<span class="badge badge-sm small bg-green">${row['status']}</span>`;

                            // addnew
                            if (row['approve_by'] == 'Ibnu Riyanto') {
                                link_integrate = `<a href="https://trusmiverse.com/apps/login/integrate?u=${row.id_approve_by}&id=${row.no_app}" class="btn btn-sm btn-link"><i class="bi bi-link"></i> Integrate</a>`;
                            }

                        } else if (data == 3) {
                            status = `<span class="badge badge-sm small bg-red">${row['status']}</span>`;
                        } else if (data == 4) {
                            if (modal == '1') {
                                status = `<a type="button" onclick="modal_approve('${sanitize(row['no_app'])}', '${sanitize(row['subject'])}', '${sanitize(row['approve_to'])}', '${sanitize(row['description'])}', '${sanitize(row['file_1'])}', '${sanitize(row['file_2'])}', '${sanitize(row['created_by'])}')"><span class="badge badge-sm bg-yellow">${row['status']}</span></a>`;
                            } else {
                                status = `<span class="badge badge-sm small bg-red">${row['status']}</span>`;
                            }
                        } else if (data == 5) {
                            if (modal == '1') {
                                status = `<a type="button" onclick="modal_approve('${sanitize(row['no_app'])}', '${sanitize(row['subject'])}', '${sanitize(row['approve_to'])}', '${sanitize(row['description'])}', '${sanitize(row['file_1'])}', '${sanitize(row['file_2'])}', '${sanitize(row['created_by'])}')"><span class="badge badge-sm bg-yellow">${row['status']}</span></a>`;
                            } else {
                                status = `<span class="badge badge-sm small bg-red">${row['status']}</span>`;
                            }
                        } else if (data == 6) {
                            if (modal == '1') {
                                status = `<a type="button" onclick="modal_approve('${sanitize(row['no_app'])}', '${sanitize(row['subject'])}', '${sanitize(row['approve_to'])}', '${sanitize(row['description'])}', '${sanitize(row['file_1'])}', '${sanitize(row['file_2'])}', '${sanitize(row['created_by'])}')"><span class="badge badge-sm bg-yellow">${row['status']}</span></a>`;
                            } else {
                                status = `<span class="badge badge-sm small bg-red">${row['status']}</span>`;
                            }
                        } else if (data == 7) {
                            status = `<span class="badge badge-sm small bg-dark">${row['status']}</span>`;
                        }


                        if (row['leadtime'] == null) {
                            keterangan = '';
                            leadtime = '';
                        } else {
                            if (row['keterangan'] == 'Ontime') {
                                keterangan = `<span class="badge badge-sm bg-green">${row['keterangan']}</span>`;
                                leadtime = `<span class="badge badge-sm bg-green">${row['leadtime']} Jam</span>`;
                            } else if (row['keterangan'] == 'Late') {
                                keterangan = `<span class="badge badge-sm bg-red">${row['keterangan']}</span>`;
                                leadtime = `<span class="badge badge-sm bg-red">${row['leadtime']} Jam</span>`;
                            } else {
                                keterangan = `<span class="badge badge-sm bg-dark">${row['keterangan']}</span>`;
                                leadtime = `<span class="badge badge-sm bg-dark">${row['leadtime']} Jam</span>`;
                            }
                        }

                        if (row['approve_by'] == null) {
                            approve_by = '';
                        } else {
                            approve_by = `<p class="mb-0 text-muted small">Aprv By : ${row['approve_by']}</p>
                                    <p class="mb-0 text-secondary small">${row['approve_at']} | ${row['approve_hour']}</p>
                                    <hr style="margin-top:3px;margin-bottom:3px;">
                                    `;
                        }

                        if (row['approve_note'] == null) {
                            approve_note = ``
                        } else {
                            approve_note = `<hr style="margin-top:3px;margin-bottom:3px;">
                            <p class="mb-0 small">${row['approve_note']}</p>`
                        }
                        if (row['id_status'] == 7 || row['id_status'] == 2 || row['id_status'] == 3) {
                            resend = ``;
                        } else {
                            resend = `<hr style="margin-top:3px;margin-bottom:3px;">
                                            <button type="button" onclick="resend_wa_modal('${row['no_app']}')" class="btn btn-outline-success btn-sm" style="cursor:pointer;"><i class="bi bi-whatsapp"></i> Resend Request WA</button>`;
                        }
                        link_resubmit = ``;
                        if (row['id_status'] == 3 || row['id_status'] == 7) {
                            link_resubmit = `<a href="https://trusmiverse.com/apps/login/verify?u=${row.id_approve_by}&id=${row.no_app}" class="btn btn-sm btn-link"><i class="bi bi-link"></i> Resubmit</a>`;
                        }

                        // return `<div class="row align-items-center">
                        //             <div class="col-auto ps-0">
                        //                 ${approve_by}
                        //                 ${status}
                        //                 ${keterangan}
                        //                 ${leadtime}
                        //                 ${approve_note}
                        //                 ${resend}
                        //                 ${link_resubmit}
                        //             </div>
                        //         </div>`;
                        return `<div class="row align-items-center">
                                    <div class="col-auto ps-0">
                                        ${status}
                                        ${keterangan}
                                        ${leadtime}
                                        ${resend}
                                        ${link_resubmit}
                                        ${link_integrate}
                                        ${data} : ${row['status']}
                                    </div>
                                </div>`;
                    },
                    "className": "text-center",
                },
                {
                    "data": "approve_note",
                    "render": function(data, type, row) {
                        if (data == null) {
                            return '';
                        } else {
                            return `${data}`;
                        }
                    },
                },
                {
                    "data": "file_1",
                    "render": function(data, type, row) {
                        if (row['file_1'] != null) {
                            filename = row['file_1'];
                            ext = filename.split('.').pop();
                            if (ext == 'doc' || ext == 'docx') {
                                file_1 = `<a href="<?= base_url('uploads/trusmi_approval/'); ?>${row['file_1']}"> <span class="bi bi-file-earmark-word label label-primary"></span></a> `
                            } else if (ext == 'xls' || ext == 'xlsx') {
                                file_1 = `<a href="<?= base_url('uploads/trusmi_approval/'); ?>${row['file_1']}"> <span class="bi bi-file-earmark-excel label label-success"></span></a> `
                            } else {
                                file_1 = `<a data-fancybox="gallery" href="<?= base_url('uploads/trusmi_approval/'); ?>${row['file_1']}" class="gallery"> <span class="bi bi-image label label-primary"></span></a> `
                            }
                        } else {
                            file_1 = ''
                        }

                        if (row['file_2'] != null) {
                            filename = row['file_2'];
                            ext = filename.split('.').pop();
                            if (ext == 'doc' || ext == 'docx') {
                                file_2 = `<a href="<?= base_url('uploads/trusmi_approval/'); ?>${row['file_2']}"> <span class="bi bi-file-earmark-word label label-primary"></span></a> `
                            } else if (ext == 'xls' || ext == 'xlsx') {
                                file_2 = `<a href="<?= base_url('uploads/trusmi_approval/'); ?>${row['file_2']}"> <span class="bi bi-file-earmark-excel label label-success"></span></a> `
                            } else {
                                file_2 = `<a data-fancybox="gallery" href="<?= base_url('uploads/trusmi_approval/'); ?>${row['file_2']}" class="gallery"> <span class="bi bi-image label label-primary"></span></a>`
                            }
                        } else {
                            file_2 = ''
                        }
                        return `${file_1} ${file_2}`
                    },
                    "className": "text-center"
                },
                {
                    "data": "created_at_hour",
                    "render": function(data, type, row) {
                        return `<span class="small">${data}</span>`
                    }
                }
            ]
        });
    }

    function save() {
        if ($('#subject').val() == '') {
            new PNotify({
                title: `Oopss`,
                text: `Anda belum mengisi Subject`,
                icon: 'icofont icofont-info-circle',
                type: 'error',
                delay: 1500,
            });
            $('#subject').focus();
        } else if ($('#approve_to').val() == '') {
            new PNotify({
                title: `Oopss`,
                text: `Anda belum memilih Approve to`,
                icon: 'icofont icofont-info-circle',
                type: 'error',
                delay: 1500,
            });
            $('#approve_to').focus();
        } else if ($('#description').val() == '') {
            new PNotify({
                title: `Oopss`,
                text: `Anda belum mengisi Description`,
                icon: 'icofont icofont-info-circle',
                type: 'error',
                delay: 1500,
            });
            $('#description').focus();
        } else {
            $('#btn_save').prop('disabled', true);
            $.ajax({
                url: '<?php echo base_url() ?>trusmi_approval/save',
                type: 'POST',
                dataType: 'JSON',
                data: $('#form_add').serialize(),
                success: function(response) {
                    $('.fa_wait_1').hide();
                    $('.fa_done_1').hide();
                    $('.fa_wait_2').hide();
                    $('.fa_done_2').hide();
                    $('#form_add')[0].reset();
                    $('#btn_save').prop('disabled', false);
                    $('#modalAdd').modal('hide');
                    dt_trusmi_approval('#dt_trusmi_approval', 'all', '<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');
                    new PNotify({
                        title: `Success`,
                        text: `Request Saved`,
                        icon: 'icofont icofont-check',
                        type: 'success',
                        delay: 1500,
                    });
                    no_app = response.no_app;
                    contact = $('#contact_approve_to').val();
                    username = $('#username').val();
                    user_id_approve_to = response.user_id_approve_to;
                    approve_to = response.approve_to;
                    requested_by = "<?= $this->session->userdata('nama'); ?>";
                    requested_at = response.created_at;
                    requested_hour = response.created_hour;
                    leadtime = response.leadtime;
                    subject = response.subject;
                    description = response.description;
                    array_contact = [
                        contact
                    ];
                    msg = `📣 Alert!!!
*There is New Request Approval*
📝 Approve To : ${approve_to}
👤 Requested By : ${requested_by}
🕐 Requested At : ${requested_at} | ${requested_hour}

No. App : ${no_app}
Subject : *${subject}*
Description : ${description}
🌐 Link Approve : 
                    
https://trusmiverse.com/apps/login/verify?u=${user_id_approve_to}&id=${no_app}`;
                    send_wa(array_contact, msg);
                }
            });

        }

        $('#subject').change(function(e) {
            $('#subject').removeClass('is-invalid');
        });

        $('#description').change(function(e) {
            $('#description').removeClass('is-invalid');
        });
    }


    function reject() {
        $('#btn_reject').prop('disabled', true);
        $('#btn_approve').prop('disabled', true);
        $.ajax({
            url: '<?php echo base_url() ?>trusmi_approval/reject',
            type: 'POST',
            dataType: 'JSON',
            data: $('#formApprove').serialize(),
            success: function(response) {
                $('#formApprove')[0].reset();
                $('#btn_approve').prop('disabled', false);
                $('#btn_reject').prop('disabled', false);
                $('#modalApprove').modal('hide');
                $('#modalWaitingApproval').modal('hide');
                approve_to = response.approve_to;
                requested_by = response.created_by;
                requested_at = response.created_at;
                requested_hour = response.created_hour;
                approve_to_user_id = response.approve_to_user_id;
                no_app = response.no_app;
                subject = response.subject;
                description = response.description;
                note = response.approve_note;
                nomorHp = response.created_by_contact;
                created_by_contact = [
                    nomorHp
                ];
                msg = `📣 Alert!!!
Your Request Has Been Reject ❌
📝 Approve To : ${approve_to}
👤 Requested By : ${requested_by}
🕐 Requested At : ${requested_at} | ${requested_hour}

No. App : ${no_app}
Subject : *${subject}*
Description : ${description}

Status : Rejected ❌
Note : ${note}

🌐 Anda Bisa Melakukan Pengajuan Ulang melalui link:    
https://trusmiverse.com/apps/login/verify?u=${approve_to_user_id}&id=${no_app}
`;
                send_wa(created_by_contact, msg);

                dt_trusmi_waiting_approval();
                dt_trusmi_approval('#dt_trusmi_approval', 'all', '<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');
                new PNotify({
                    title: `Success`,
                    text: `Request Rejected`,
                    icon: 'icofont icofont-check',
                    type: 'success',
                    delay: 1500,
                });
            }
        });
    }

    function approve() {
        $('#btn_reject').prop('disabled', true);
        $('#btn_approve').prop('disabled', true);
        $.ajax({
            url: '<?php echo base_url() ?>trusmi_approval/approve',
            type: 'POST',
            dataType: 'JSON',
            data: $('#formApprove').serialize(),
            success: function(response) {
                $('#formApprove')[0].reset();
                $('#btn_approve').prop('disabled', false);
                $('#btn_reject').prop('disabled', false);
                $('#modalApprove').modal('hide');
                $('#modalWaitingApproval').modal('hide');
                approve_to = response.approve_to;
                requested_by = response.created_by;
                requested_at = response.created_at;
                requested_hour = response.created_hour;
                no_app = response.no_app;
                subject = response.subject;
                description = response.description;
                note = response.approve_note;
                nomorHp = response.created_by_contact;
                created_by_contact = [
                    nomorHp
                ];
                msg = `📣 Alert!!!
Your Request Has Been Processed
📝 Approve To : ${approve_to}
👤 Requested By : ${requested_by}
🕐 Requested At : ${requested_at} | ${requested_hour}

No. App : ${no_app}
Subject : *${subject}*
Description : ${description}

Status : Approved ✅
Note : ${note}`;
                send_wa(created_by_contact, msg);
                dt_trusmi_waiting_approval();
                dt_trusmi_approval('#dt_trusmi_approval', 'all', '<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');
                new PNotify({
                    title: `Success`,
                    text: `Request Approved`,
                    icon: 'icofont icofont-check',
                    type: 'success',
                    delay: 1500
                });
            }
        });
    }


    function get_approve_to() {
        array = [];
        item = `<option data-placeholder="true"></option>`;
        $.ajax({
            'url': '<?= site_url('trusmi_approval/get_approve_to') ?>',
            'type': 'GET',
            'dataType': 'json',
            'success': function(response) {
                // console.log(response[i].username);
                for (i = 0; i < response.length; i++) {
                    item += `<option value="` + response[i].user_id + `" data-contact="` + response[i].contact_no + `" data-username="` + response[i].username + `">` + response[i].full_name + `</option>`;
                    array.push({
                        text: 'Value 1'
                    }, )
                }
                // console.log(item);
                $('#approve_to').empty();
                $('#approve_to').append(item);
                new SlimSelect({
                    select: '#approve_to',
                    settings: {
                        placeholderText: 'Approve To ?',
                    }
                })
            }
        })
    }

    function passContact() {
        contact = $('#approve_to').find(':selected').attr('data-contact');
        username = $('#approve_to').find(':selected').attr('data-username');
        console.log(contact);
        $('#contact_approve_to').val(contact);
        $('#username').val(username);
    }

    function modal_approve(no_app_a, subject_a, approve_to_a, description_a, file_1_a, file_2_a, created_by_a) {
        $("#modalApprove").modal("show");
        const decodedSubject = subject_a.replace(/\\n/g, "\n");
        const decodedDescription = description_a.replace(/\\n/g, "\n");
        $("#no_app_a").val(no_app_a);
        $("#subject_a").val(decodedSubject);
        $("#approve_to_a").val(approve_to_a);
        $("#created_by_a").val(created_by_a);
        $("#description_a").val(decodedDescription);
        if (file_1_a != null || file_1_a != '') {
            file_1 = `<a data-fancybox="gallery" href="<?= base_url('uploads/trusmi_approval/'); ?>${file_1_a}" class="gallery"> <span class="bi bi-image label label-primary" style="font-size:20pt;"></span></a> `
        } else {
            file_1 = ''
        }

        if (file_2_a != null || file_2_a != '') {
            file_2 = `<a data-fancybox="gallery" href="<?= base_url('uploads/trusmi_approval/'); ?>${file_2_a}" class="gallery"> <span class="bi bi-image label label-primary" style="font-size:20pt;"></span></a>`
        } else {
            file_2 = ''
        }
        $("#file_a").html(file_1 + " " + file_2);
    }


    function modal_approve_waiting(no_app_a) {
        $.ajax({
            'url': '<?= site_url('trusmi_approval/get_trusmi_approval_by_no_app') ?>',
            'type': 'POST',
            'dataType': 'json',
            'data': {
                no_app: no_app_a
            },
            'success': function(response) {
                $("#modalApprove").modal("show");
                $("#no_app_a").val(response.no_app);
                $("#subject_a").val(response.subject);
                $("#approve_to_a").val(response.approve_to);
                $("#created_by_a").val(response.created_by);
                $("#description_a").val(response.description);
                if (response.file_1 != null || response.file_1 != '') {
                    file_1 = `<a data-fancybox="gallery" href="<?= base_url('uploads/trusmi_approval/'); ?>${response.file_1}" class="gallery"> <span class="bi bi-image label label-primary" style="font-size:20pt;"></span></a> `
                } else {
                    file_1 = ''
                }

                if (response.file_2 != null || response.file_2 != '') {
                    file_2 = `<a data-fancybox="gallery" href="<?= base_url('uploads/trusmi_approval/'); ?>${response.file_2}" class="gallery"> <span class="bi bi-image label label-primary" style="font-size:20pt;"></span></a>`
                } else {
                    file_2 = ''
                }
                $("#file_a").html(file_1 + " " + file_2);
            }
        })
    }

    function dt_trusmi_waiting_approval() {
        // 1 = waiting
        dt_trusmi_approval('#dt_trusmi_waiting_approval', '1', '', '', '1')
    }

    function alertDiluarJamOperasional() {
        new PNotify({
            title: `Oopss`,
            text: `Tidak Bisa Request Di Luar Jam Operasional IT <br> Jam Operasional 07:00 - 20:00 WIB`,
            icon: 'icofont icofont-info-circle',
            type: 'error',
            delay: 3000,
        });
    }

    function resend_wa_modal(no_app) {
        $("#no_app_resend_wa").val(no_app);
        $("#modalResendWa").modal("show");
    }

    function resend_wa() {
        $("#modalResendWa").modal("hide");
        no_app_val = $("#no_app_resend_wa").val();
        $.ajax({
            url: '<?php echo base_url() ?>trusmi_approval/resend_wa',
            type: 'POST',
            dataType: 'JSON',
            data: {
                no_app: no_app_val
            },
            success: function(response) {
                no_app = response.no_app;
                contact = response.approve_to_contact;
                username = response.approve_to_username;
                approve_to_user_id = response.approve_to_user_id;
                approve_to = response.approve_to;
                requested_by = response.created_by;
                requested_at = response.created_at;
                requested_hour = response.created_hour;
                leadtime = response.leadtime;
                subject = response.subject;
                description = response.description;

                id_status = response.id_status;
                keterangan = response.keterangan;
                array_contact = [
                    contact
                ];

                if (approve_to_user_id == 803) { // jika approval ke pa i maka cc juga ke mba lintang
                    array_contact.push('62895422833253');

                }

                if (id_status == 1) {
                    msg = `📣 Alert!!!
*There is New Request Approval*
📝 Approve To : ${approve_to}
👤 Requested By : ${requested_by}
🕐 Requested At : ${requested_at} | ${requested_hour}

No. App : ${no_app}
Subject : *${subject}*
Description : ${description}
🌐 Link Approve : 
                    
https://trusmiverse.com/apps/login/verify?u=${approve_to_user_id}&id=${no_app}`;
                } else if (id_status == 4) {
                    msg = `Alert!!! 🚨
*1st follow-up ( ${keterangan} )*
📝 Approve To : ${approve_to}
👤 Requested By : ${requested_by}
🕐 Requested At : ${requested_at} | ${requested_hour}
⌛ Leadtime : ${leadtime}

No. App : ${no_app}
Subject : *${subject}*
Description : ${description}
🌐 Link Approve :

https://trusmiverse.com/apps/login/verify?u=${approve_to_user_id}&id=${no_app}`;

                } else if (id_status == 5) {
                    msg = `Alert!!! 🚨🚨
*2nd follow-up ( ${keterangan} )*
📝 Approve To : ${approve_to}
👤 Requested By : ${requested_by}
🕐 Requested At : ${requested_at} | ${requested_hour}
⌛ Leadtime : ${leadtime}

No. App : ${no_app}
Subject : *${subject}*
Description : ${description}
🌐 Link Approve :

https://trusmiverse.com/apps/login/verify?u=${approve_to_user_id}&id=${no_app}`;

                } else if (id_status == 6) {
                    msg = `Alert!!! 🚨🚨🚨
*3rd follow-up ( ${keterangan} )*
📝 Approve To : ${approve_to}
👤 Requested By : ${requested_by}
🕐 Requested At : ${requested_at} | ${requested_hour}
⌛ Leadtime : ${leadtime}

No. App : ${no_app}
Subject : *${subject}*
Description : ${description}
🌐 Link Approve :

https://trusmiverse.com/apps/login/verify?u=${approve_to_user_id}&id=${no_app}`;
                }

                send_wa(array_contact, msg);
            }
        });
    }

    function sanitize(str) {
        if (typeof str !== 'string') return str;
        return str
            .replace(/\r?\n/g, "\\n") // Ganti line break dengan literal \n
            .replace(/'/g, "\\'") // Escape single quote
            .replace(/"/g, '\\"'); // Escape double quote     // Escape double quote
    }
</script>