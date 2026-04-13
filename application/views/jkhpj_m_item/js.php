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
<script src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>


<script>
    $(document).ready(function() {

        //Datepicker
        // var start = moment().startOf('month');
        // var end = moment().endOf('month');

        // function cb(start, end) {
        //     $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        //     $('input[name="start"]').val(start.format('YYYY-MM-DD'));
        //     $('input[name="end"]').val(end.format('YYYY-MM-DD'));
        // }

        // $('.range').daterangepicker({
        //     startDate: start,
        //     endDate: end,
        //     "drops": "down",
        //     ranges: {
        //         'Today': [moment(), moment()],
        //         'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        //         'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        //         'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        //         'This Month': [moment().startOf('month'), moment().endOf('month')],
        //         'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        //     }
        // }, cb);

        // cb(start, end);
        dt_jkhpj_m_item();
        // $('.range').on('change', function() {
        //     start = $('input[name="start"]').val();
        //     end = $('input[name="end"]').val();
        // })
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

        $('#edit_description').summernote({
            tabsize: 2,
            height: 70,
            toolbar: [
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
            ]
        });


        $('input.timepicker').datetimepicker({
            format: 'H:i',
            datepicker: false,
            timepicker: true,
            step: 30,
            minDate: 0,
        });

        $('#edit_time_start, #edit_time_end').datetimepicker({
            format: 'H:i',
            datepicker: false,
            timepicker: true,
            step: 30,
            minDate: 0,
        });

        initCompany = new SlimSelect({
            select: "#company"
        });

        initDepartment = new SlimSelect({
            select: "#department"
        });

        initDesignation = new SlimSelect({
            select: "#designation"
        });

        // Example using event delegation:
        $(document).on('focus', '.datepicker', function() {
            $(this).datepicker();
        });

        // Example using modal's show event:
        $('#modal_add_item').on('shown.bs.modal', function() {
            $('.datepicker').datepicker();
        });
    });

    function dt_jkhpj_m_item() {
        $('#dt_jkhpj_m_item').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "method": "POST",
                "url": "<?= base_url(); ?>jkhpj_m_item/dt_jkhpj_m_item",
                // "data": {
                //     start: start,
                //     end: end,
                //     status: status
                // }
            },
            "columns": [{
                    "data": "designation_name",
                },
                // {
                // "data": 'time_start',
                // "render": function(data, type, row, meta) {
                //     return `${row['time_start']} - ${row['time_end']}`
                // },
                // },
                // {
                // "data": 'tasklist'
                // },
                // {
                // "data": 'description',
                // },
                // {
                // "data": 'is_file',
                // "render": function(data, type, row, meta) {
                //     if (data == 1) {
                //         return `<span class="badge text-bg-success">Ya</span>`
                //     } else {
                //         return `<span class="badge text-bg-danger">Tidak</span>`
                //     }
                // },
                // }
                {
                    "data": "designation_id",
                    "render": function(data, type, row, meta) {
                        return `<span class="badge text-bg-primary" onclick='list_tasklist(${data})' style="cursor:pointer;">Tasklist</span>`
                    },
                },
            ],
        });
    }

    function dt_jkhpj_m_item_detail(designation_id) {
        $('#dt_jkhpj_m_item_detail').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "method": "POST",
                "url": "<?= base_url(); ?>jkhpj_m_item/dt_jkhpj_m_item_detail",
                "data": {
                    designation_id: designation_id
                }
            },
            "columns": [{
                    "data": "designation_name",
                },
                {
                    "data": 'time_start',
                    "render": function(data, type, row, meta) {
                        return `${row['time_start']} - ${row['time_end']}`
                    },
                },
                {
                    "data": 'tasklist'
                },
                {
                    "data": 'description',
                },
                {
                    "data": 'is_file',
                    "render": function(data, type, row, meta) {
                        if (data == 1) {
                            return `<span class="badge text-bg-success">Ya</span>`
                        } else {
                            return `<span class="badge text-bg-danger">Tidak</span>`
                        }
                    },
                },
                {
                    "data": null, // Kita tidak mengambil data spesifik, kita akan render tombol
                    "orderable": false,
                    "render": function(data, type, row, meta) {
                        // Kita passing seluruh 'row' object sebagai JSON string
                        // Gunakan ikon Font Awesome atau Bootstrap (bi-pencil-fill)
                        // Pastikan 'id_jkhpj_item' ada di data 'row'
                        return `<button class="btn btn-sm btn-warning" onclick='edit_tasklist(${JSON.stringify(row)})'>
                                <i class="fa fa-pencil-alt"></i>
                            </button>`;
                    },
                }
            ],
        });
    }

    function list_tasklist(designation_id) {
        $('#modal_table_tasklist').modal('show');
        dt_jkhpj_m_item_detail(designation_id)
    }

    function add_task() {
        $('#modal_add_item').modal('show');
        // $('#tasklist').val('');
        // $('#time_start').val('');
        // $('#time_end').val('');
        // $('#description').summernote('code', '');
    }

    let tasklistArray = [];

    function addTask() {
        const taskId = `task-${Date.now()}`;
        const taskHtml = `
            <div id="${taskId}" class="task-item mb-3">
            <hr>
                <div class="row">
                    <div class="col-12 col-md-6 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <label>Tasklist <i class="text-danger">*</i></label>
                                <div class="input-group">
                                    <input type="text" name="tasklist[]" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <label>Description <i class="text-danger">*</i></label>
                                <div class="input-group">
                                    <textarea class="form-control input_permintaan" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;" name="description[]" id="description-${taskId}" rows="5" required></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-6 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <label>Jam Mulai <i class="text-danger">*</i></label>
                                <div class="input-group">
                                    <input type="text" name="time_start[]" id="time_start-${taskId}" class="form-control timepicker">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <div class="form-group mb-3 position-relative check-valid">
                                <label>Jam Selesai <i class="text-danger">*</i></label>
                                <div class="input-group">
                                    <input type="text" name="time_end[]" id="time_end-${taskId}" class="form-control timepicker">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-2">
                            <label class="form-label-custom required small" for="is_file">Menggunakan File?</label>
                            <div class="input-group mb-3">
                                <select name="is_file[]" class="form-control" style="border:1px solid #ced4da;border-top-right-radius:5px;border-bottom-right-radius:5px;">
                                    <option value="0" selected>Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                        </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeTask('${taskId}')">Delete</button>
                    </div>
                </div>
                <hr>
            </div>
        `;
        document.getElementById('tasklist-container').insertAdjacentHTML('beforeend', taskHtml);
        $(document).ready(function() {
            $('#description-' + taskId).summernote({
                toolbar: [
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                ],
            });
            $('#time_start-' + taskId).datetimepicker({
                format: 'H:i',
                datepicker: false,
                timepicker: true,
                step: 30,
                minDate: 0,
            });
            $('#time_end-' + taskId).datetimepicker({
                format: 'H:i',
                datepicker: false,
                timepicker: true,
                step: 30,
                minDate: 0,
            });
        });
    }

    function removeTask(taskId) {
        const taskElement = document.getElementById(taskId);
        if (taskElement) {
            taskElement.remove();
        }
    }

    function get_department() {
        company = $('#company').val();
        if (company != null) {
            $.ajax({
                url: "<?= base_url('jkhpj_m_item/get_department') ?>",
                method: "POST",
                data: {
                    id: company
                },
                dataType: "JSON",
                beforeSend: function() {
                    initDepartment.destroy();
                },
                success: function(res) {
                    console.log(res);
                    let department = '<option selected disabled> --Pilih Department-- </option>';
                    res.department.forEach((value, index) => {
                        department += `<option value = "${value.department_id}"> ${value.department_name}</option>`;
                    })
                    $('#department').html(department);
                    setTimeout(() => {
                        initDepartment = new SlimSelect({
                            select: "#department"
                        });
                    }, 400);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            })
        }
    }

    function get_designation() {
        department = $('#department').val();
        company = $('#company').val();
        if (department != null) {
            $.ajax({
                url: "<?= base_url('jkhpj_m_item/get_designation') ?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    company_id: company,
                    department_id: department
                },
                beforeSend: function() {
                    initDesignation.destroy();
                },
                success: function(res) {
                    let posisi = '<option selected disabled> --Pilih Designation-- </option>';
                    res.designation.forEach((value, index) => {
                        posisi += `<option value="${value.designation_id}"> ${value.designation_name}</option>`;
                    })
                    $('#designation').html(posisi);
                    setTimeout(() => {
                        initDesignation = new SlimSelect({
                            select: "#designation"
                        });
                    }, 400);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            })

        }
    }

    <?php if (in_array($user_id, [1, 2, 6466, 4498, 2521, 3651, 4770, 4954, 5121, 6717, 8305, 3690, 1186, 321])): ?>

        function edit_tasklist(data) {
            // 'data' adalah objek 'row' lengkap dari DataTables

            // Isi form di modal edit
            $('#edit_id_jkhpj_item').val(data.id_jkhpj_item);
            $('#edit_tasklist').val(data.tasklist);
            $('#edit_description').summernote('code', data.description);
            $('#edit_time_start').val(data.time_start);
            $('#edit_time_end').val(data.time_end);
            $('#edit_is_file').val(data.is_file);

            // Tampilkan modal edit
            $('#modal_edit_item').modal('show');
        }

        function simpan_item() {
            company = $('#company').val();
            department = $('#department').val();
            designation = $('#designation').val();

            if (designation == null) {
                swal('Warning!', 'Harap memilih designation', 'error');
                return;
            }
            const form = document.getElementById('form_item');
            const formData = new FormData(form);
            tasklistArr = [];
            for (let i = 0; i < formData.getAll('tasklist[]').length; i++) {
                if (formData.getAll('tasklist[]')[i] == '') {
                    swal('Warning!', 'Harap mengisi tasklist', 'error');
                    return;
                } else if (formData.getAll('description[]')[i] == '') {
                    swal('Warning!', 'Harap mengisi description', 'error');
                    return;
                } else if (formData.getAll('time_start[]')[i] == '') {
                    swal('Warning!', 'Harap mengisi time start', 'error');
                    return;
                } else if (formData.getAll('time_end[]')[i] == '') {
                    swal('Warning!', 'Harap mengisi time end', 'error');
                    return;
                }
            }


            swal({
                    title: "Simpan Item?",
                    icon: "info",
                    buttons: true,
                    dangerMode: false,
                })
                .then((simpan) => {
                    if (simpan) {
                        $.ajax({
                            'url': "<?= base_url('jkhpj_m_item/simpan_item') ?>",
                            'type': "POST",
                            'data': $('#form_item').serialize(),
                            'dataType': "JSON",
                            // 'processData': false, 
                            // 'contentType': false, 
                            'beforeSend': function() {
                                $("#btn_save_item").attr("disabled", true);
                            },
                            'success': function(response) {
                                console.log(response);
                                if (response.insert) {
                                    $('#modal_add_item').modal('hide');
                                    $("#btn_save_item").removeAttr("disabled");
                                    $('#dt_jkhpj_m_item').DataTable().ajax.reload();
                                    swal('Success!', 'Berhasil menambah item', 'success').then(function() {
                                        window.location = "<?= base_url('jkhpj_m_item') ?>"
                                    });
                                } else {
                                    $("#btn_save_item").removeAttr("disabled");
                                    swal('Warning!', 'Gagal menambah item ', 'error');
                                }

                            }
                        })
                    }
                });

        }

        function update_item() {
            // Validasi sederhana
            if ($('#edit_tasklist').val() == '' || $('#edit_description').val() == '' || $('#edit_time_start').val() == '' || $('#edit_time_end').val() == '') {
                swal('Warning!', 'Harap mengisi semua field yang wajib diisi', 'error');
                return;
            }

            swal({
                    title: "Update Item?",
                    text: "Apakah kamu yakin ingin menyimpan perubahan ini?",
                    icon: "info",
                    buttons: true,
                    dangerMode: false,
                })
                .then((update) => {
                    if (update) {
                        $.ajax({
                            'url': "<?= base_url('jkhpj_m_item/update_item') ?>",
                            'type': "POST",
                            'data': $('#form_edit_item').serialize(),
                            'dataType': "JSON",
                            'beforeSend': function() {
                                $("#btn_update_item").attr("disabled", true);
                            },
                            'success': function(response) {
                                console.log(response);
                                if (response.update) {
                                    $('#modal_edit_item').modal('hide');
                                    $("#btn_update_item").removeAttr("disabled");

                                    $('#dt_jkhpj_m_item_detail').DataTable().ajax.reload();
                                    swal('Success!', 'Berhasil mengubah item', 'success');
                                } else {
                                    $("#btn_update_item").removeAttr("disabled");
                                    swal('Warning!', 'Gagal mengubah item', 'error');
                                }
                            },
                            'error': function(xhr) {
                                $("#btn_update_item").removeAttr("disabled");
                                swal('Error!', 'Terjadi kesalahan server', 'error');
                                console.log(xhr.responseText);
                            }
                        })
                    }
                });
        }
    <?php endif; ?>
</script>