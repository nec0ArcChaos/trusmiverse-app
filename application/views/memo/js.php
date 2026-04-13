<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>


<script>
    $(document).ready(function() {

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');
        
        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
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
        dt_memo('dt_memo','<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>', 1);
        // $('#btn_filter').on('click', function() {
        //     start = $('input[name="startdate"]').val();
        //     end = $('input[name="enddate"]').val();
        //     dt_memo('dt_memo',start, end, 1);
        // });
        $('.range').on('change', function() {
            start = $('input[name="start"]').val();
            end = $('input[name="end"]').val();
            dt_memo('dt_memo',start, end, 1);
        })
        // Text_Area
        $('textarea.input_permintaan').each(function() {
            $(this).summernote({
                tabsize: 2,
                height: 70,
                toolbar: [
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                ]
            });
        })

        initType = new SlimSelect({
            select: "#tipe_memo"
        });

        initCompany = new SlimSelect({
            select: "#company_id"
        });

        initRole = new SlimSelect({
            select: "#role_id"
        });

        initDepartment = new SlimSelect({
            select: "#department_id"
        });
    });

    function list_memo_waiting() {
        $('#modal_waiting_memo').modal('show');
        dt_memo('waiting_memo', null, null, 0);
    }

    function list_memo_reject() {
        $('#modal_reject_memo').modal('show');
        dt_memo('reject_memo', null, null, 2);
    }

    function list_memo_feedback() {
        $('#modal_feedback_memo').modal('show');
        dt_memo('feedback_memo',null,null, 'feedback');
    }

    function get_department() {
        company_id = $('#company_id').val();
        if (company_id != null && company_id != '#' && company_id.length != 0) {
            $.ajax({
            url: "<?= base_url('memo/get_department') ?>",
            method: "POST",
            data: {
                company_id: company_id
            },
            dataType: "JSON",
            beforeSend: function(){
                initDepartment.destroy()
            },
            success: function(res) {
                var data = res.department 
                var selectOption = ``;
                $.each(data, function(i, val){
                    selectOption += `<option value="${val.department_id}">${val.department_name}</option>`
                })
                $('#department_id').html(selectOption)

                
                initDepartment = new SlimSelect({
                    select: "#department_id"
                });
            }
            })
        } else {
            initDepartment.destroy()
            $('#department_id').html('')
        }
    }

    function add_memo() {
        $('#form_memo')[0].reset();
        initType.setSelected('#');
        $('#tipe_memo').val('#');
        initCompany.setSelected('');
        $('#company_id').val('');
        initDepartment.setSelected('');
        $('#department_id').val('');
        initRole.setSelected('');
        $('#role_id').val('');
        $('#file_memo').val('');
        $('#note').summernote('code', '');
        $("#modal_add_memo").modal("show");
    }

    function isStrictUrl(string) {
        const pattern = /^https?:\/\/[^\s/$.?#].[^\s]*$/i;
        return pattern.test(string);
    }

    function dt_memo(table, start, end, status_memo) {
        user_id = $('#user_id').val();
        access_edit = (user_id == 1 || user_id == 2516 || user_id == 2729 || user_id == 803) ? true : false;
        $('#'+table).DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
            ],
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "method": "POST",
                "url": "<?= base_url(); ?>memo/dt_memo",
                "data": {
                    start: start,
                    end: end,
                    status_memo: status_memo
                }
            },
            "columns": [{
                "data": "id_memo",
                "render": function(data, type, row, meta) {
                    if (status_memo != 'feedback') {
                        return `<span class="badge text-bg-success" onclick='show_history_feedback("${data}")' style="cursor:pointer;">${data}</span>`;
                    } else {
                        return `<span class="badge text-bg-success" onclick='add_feedback("${data}")' style="cursor:pointer;">${data}</span>`;
                    }
                    
                },
                
                },
                {
                "data": "status_memo",
                "render": function(data, type, row, meta) {
                    if (data == 0 || data == null) {
                    if (access_edit) {
                        status = `<span class="badge text-bg-warning" style="cursor:pointer;" data-id_memo='${row['id_memo']}' data-note='${row['note']}' data-role='${row['role']}' data-department='${row['department']}' data-company='${row['company']}' onclick='change_status(this)'>Waiting</span>`;
                    } else {
                        status = "<span class='badge text-bg-warning'>Waiting</span>";
                    }
                    } else if (data == 1) {
                    status = "<span class='badge text-bg-primary'>Approve</span>";
                    } else if (data == 2) {
                    status = "<span class='badge text-bg-danger'>Reject</span>";
                    }
                    return status;
                },
                
                },
                {
                "data": 'tipe_memo',
                
                },
                {
                "data": 'note'
                },
                {
                "data": 'files_memo',
                "render": function(data, type, row, meta) {
                    if (data != null) {
                        btn_file = ``;
                        if (row['id_approval'] == 1) {
                            if (isStrictUrl(data)) {
                                btn_file = `<a href="${data}" target="_blank" title="File BA"><i class="bi bi-printer text-primary"></i></a>`
                            } else {
                                btn_file = `<a href="<?= base_url("uploads/files_memo/") ?>${data}" target="_blank" title="File BA"><i class="bi bi-printer text-primary"></i></a>`
                            }
                        } else {
                            btn_file = `<a href="<?= base_url("uploads/files_memo/") ?>${data}" target="_blank" title="File BA"><i class="bi bi-printer text-primary"></i></a>`
                        }
                        if (status_memo == 1 && access_edit) {
                            btn_file += `<span class="badge text-bg-primary" style="cursor:pointer;" onclick='change_file_memo("${row['id_memo']}")'>Edit</span>`;
                        }
                        return btn_file;
                    } else {
                        return '';
                    }
                },
                
                },
                {
                "data": 'company',
                
                },
                {
                "data": 'department',
                
                },
                {
                "data": 'role',
                
                },
                {
                "data": 'created_at',
                
                },
                {
                "data": 'created_by',
                
                },
                {
                "data": 'updated_by',
                
                },
                {
                "data": 'note_update',
                
                }
            ],
        });
    }

    function simpan_memo() {
        let form_data = new FormData();
        tipe_memo = $('#tipe_memo').val();
        note = $('#note').val();
        file_memo = $('#file_memo').val();
        company_id = $('#company_id').val();
        department_id = $("#department_id").val().toString().split(",");
        role_id = $("#role_id").val().toString().split(",");
        files = $("#file_memo").prop("files")[0];
        form_data.append("files", files);
        form_data.append("tipe_memo", tipe_memo);
        form_data.append("note", note);
        form_data.append("company_id", company_id);
        form_data.append("department_id", department_id);
        form_data.append("role_id", role_id);
        if (tipe_memo == null) {
        swal('Warning!', 'Harap memilih tipe memo', 'error');
        } else if (note == '') {
        swal('Warning!', 'Harap mengisi note', 'error');
        }  else if (company_id == '') {
        swal('Warning!', 'Harap memilih Company', 'error');
        } else if (department_id == '') {
        swal('Warning!', 'Harap memilih Department', 'error');
        } else if (role_id == '') {
        swal('Warning!', 'Harap memilih Role/Jabatan', 'error');
        } else if (file_memo == '') {
        swal('Warning!', 'Harap mengupload file memo', 'error');
        } else {
        swal({
            title: "Simpan Memo?",
            icon: "info",
            buttons: true,
            dangerMode: false,
            })
            .then((simpan) => {
            if (simpan) {
                $.ajax({
                'url': "<?= base_url('memo/simpan_memo') ?>",
                'type': "POST",
                'data': form_data,
                'dataType': "JSON",
                'processData': false, // Prevent jQuery from processing the data
                'contentType': false, // Prevent jQuery from setting the content type
                'beforeSend': function() {
                    // $('#spinner').modal('show');
                    $("#btn_save").attr("disabled", true);
                },
                'success': function(response) {
                    console.log(response);
                    if (response.insert_memo) {
                        // $('#spinner').modal('hide');
                        $('#modal_add_memo').modal('hide');
                        $("#btn_save").removeAttr("disabled");
                        $('#dt_memo').DataTable().ajax.reload();
                        swal('Success!', 'Berhasil menambah memo', 'success');
                    } else {
                        $("#btn_save").removeAttr("disabled");
                        swal('Warning!', 'Gagal menambah memo ', 'error');
                    }
                    
                }
                })
            }
            });
        }
    }

    function change_status(memo) {
        id = $(memo).data('id_memo');
        note = $(memo).data('note');
        role = $(memo).data('role');
        department = $(memo).data('department');
        company = $(memo).data('company');
        $('#edit_id_memo').val(id);
        $('#edit_note').val(note);
        $('#edit_role').val(role);
        $('#edit_department').val(department);
        $('#edit_company').val(company);
        $('#note_update').val('');
        $('#status_memo').val('#');
        $('#modal_edit_memo').modal('show');
    }

    function edit_memo() {
        note = $('#note_update').val();
        status = $('#status_memo').val();
        id = $('#edit_id_memo').val();

        if (status == null) {
        swal('Warning!', 'Harap memilih status', 'error');
        } else if (note == '') {
        swal('Warning!', 'Harap mengisi note update', 'error');
        } else {
        $.ajax({
            url: "<?= base_url('memo/edit_memo') ?>",
            method: "POST",
            data: {
                note: note,
                status: status,
                id: id
            },
            dataType: "JSON",
            beforeSend: function() {
            // $('#spinner').modal('show');
            $("#btn_edit_memo").attr("disabled", true);
            },
            success: function(res) {
            console.log(res);
            // $('#spinner').modal('hide');
            $('#modal_edit_memo').modal('hide');
            $('#modal_waiting_memo').modal('hide');
            $("#btn_edit_memo").removeAttr("disabled");
            swal('Success!', 'Berhasil mengubah status memo', 'success');
            $('#dt_memo').DataTable().ajax.reload();
            $('#list_waiting').DataTable().ajax.reload();
            }
        })
        }
    }

    const formatDate = (dateString) => {
            const options = {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            };
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', options);
        };

    function add_feedback(id) {
        $('#id_memo_feedback').val(id);
        $('#feedback').summernote('code', '');
        $('#form_feedback')[0].reset();
        $('#modal_add_feedback_memo').modal('show');
        $.ajax({
            url: "<?= base_url('memo/feedback_memo_history') ?>",
            method: "POST",
            data: {
                id: id
            },
            dataType: "JSON",
            beforeSend: function(){
                $('#history_feedback').html('')
            },
            success: function(res) {
                var data = res.histories 
                var history = ``;
                $.each(data, function(i, val){
                    history += `<tr>
                        <td>
                            ${formatDate(val.feedback_at)}
                        </td>
                        <td>
                            ${val.feedback}
                        </td>
                        <td>${val.file_feedback != null ? `<a href="<?= base_url("uploads/files_memo/feedback/") ?>${val.file_feedback}" target="_blank">Download File</a>` : ''}</td>
                        <td>${val.link_feedback != null ? `<a href="${val.link_feedback}" target="_blank">Go to Link</a>` : ''}</td>
                        <td>${val.status_feedback}</td>
                        <td>${val.feedback_by}</td>
                    </tr>`
                })
                $('#history_feedback').html(history)
            }
        })
    }

    function show_history_feedback(id) {
        $('#modal_history_feedback_memo').modal('show');
        $.ajax({
            url: "<?= base_url('memo/feedback_memo_history') ?>",
            method: "POST",
            data: {
                id: id
            },
            dataType: "JSON",
            beforeSend: function(){
                $('#history_feedback_memo').html('')
            },
            success: function(res) {
                var data = res.histories 
                var history = ``;
                $.each(data, function(i, val){
                    history += `<tr>
                        <td>
                            ${formatDate(val.feedback_at)}
                        </td>
                        <td>
                            ${val.feedback}
                        </td>
                        <td>${val.file_feedback != null ? `<a href="<?= base_url("uploads/files_memo/feedback/") ?>${val.file_feedback}" target="_blank">Download File</a>` : ''}</td>
                        <td>${val.link_feedback != null ? `<a href="${val.link_feedback}" target="_blank">Go to Link</a>` : ''}</td>
                        <td>${val.status_feedback}</td>
                        <td>${val.feedback_by}</td>
                    </tr>`
                })
                $('#history_feedback_memo').html(history)
            }
        })
    }

    function simpan_feedback() {
        let form_data = new FormData();
        id = $('#id_memo_feedback').val();
        feedback = $('#feedback').val();
        file_feedback = $('#file_feedback').val();
        files = $("#file_feedback").prop("files")[0];
        link_feedback = $('#link_feedback').val();
        status_feedback = $('#status_feedback').val();
        
        form_data.append("files", file_feedback != '' ? files : null);
        form_data.append("id", id);
        form_data.append("feedback", feedback);
        form_data.append("link_feedback", link_feedback);
        form_data.append("status_feedback", status_feedback);
        if (feedback == '') {
        swal('Warning!', 'Harap mengisi feedback', 'error');
        }  else if (status_feedback == null) {
        swal('Warning!', 'Harap memilih Status', 'error');
        } else if (file_feedback == '' && link_feedback == '') {
        swal('Warning!', 'Harap Upload File atau mengisi Link', 'error');
        } else {
        swal({
            title: "Simpan Feedback?",
            icon: "info",
            buttons: true,
            dangerMode: false,
            })
            .then((simpan) => {
            if (simpan) {
                $.ajax({
                'url': "<?= base_url('memo/feedback_memo') ?>",
                'type': "POST",
                'data': form_data,
                'dataType': "JSON",
                'processData': false, // Prevent jQuery from processing the data
                'contentType': false, // Prevent jQuery from setting the content type
                'beforeSend': function() {
                    // $('#spinner').modal('show');
                    $("#btn_save_feedback").attr("disabled", true);
                },
                'success': function(response) {
                    console.log(response);
                    if (response.update) {
                        // $('#spinner').modal('hide');
                        $('#modal_add_feedback_memo').modal('hide');
                        $("#btn_save_feedback").removeAttr("disabled");
                        $('#feedback_memo').DataTable().ajax.reload();
                        swal('Success!', 'Berhasil menambah feedback', 'success');
                    } else {
                        $("#btn_save_feedback").removeAttr("disabled");
                        swal('Warning!', 'Gagal menambah feedback ', 'error');
                    }
                    
                }
                })
            }
            });
        }
    }

    function change_file_memo(id) {
        $('#id_memo_file').val(id);
        $('#change_file_memo').val('');
        $('#form_change_file_memo')[0].reset();
        $('#modal_change_file_memo').modal('show');
    }

    function edit_file_memo(){
        let form_data = new FormData();
        id = $('#id_memo_file').val();
        file_memo = $('#change_file_memo').val();
        files = $("#change_file_memo").prop("files")[0];
        form_data.append("files", files);
        form_data.append("id", id);
        if (file_memo == '') {
            swal('Warning!', 'Harap mengupload file memo', 'error');
        } else {
            swal({
                title: "Simpan File Memo?",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((simpan) => {
                if (simpan) {
                    $.ajax({
                        'url': "<?= base_url('memo/edit_file_memo') ?>",
                        'type': "POST",
                        'data': form_data,
                        'dataType': "JSON",
                        'processData': false, // Prevent jQuery from processing the data
                        'contentType': false, // Prevent jQuery from setting the content type
                        'beforeSend': function() {
                            // $('#spinner').modal('show');
                            $("#btn_save_file").attr("disabled", true);
                        },
                        'success': function(response) {
                            console.log(response);
                            if (response.update) {
                                // $('#spinner').modal('hide');
                                $('#modal_change_file_memo').modal('hide');
                                $("#btn_save_file").removeAttr("disabled");
                                $('#dt_memo').DataTable().ajax.reload();
                                swal('Success!', 'Berhasil mengubah file memo', 'success');
                            } else {
                                $("#btn_save_file").removeAttr("disabled");
                                swal('Warning!', 'Gagal mengubah file memo ', 'error');
                            }
                            
                        }
                    })
                }
            });
        }
    }
</script>