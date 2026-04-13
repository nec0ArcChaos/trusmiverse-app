<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>


<script>
    $(document).ready(function() {

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

        dt_list_department();
        dt_list_employees();
        dt_list_companies();
        dt_list_working_locations();

        $('#check_all_company').on('click', function() {
            var rows = $('#dt_list_companies').DataTable().rows({
                'search': 'applied'
            }).nodes();
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });

        $('#check_all_location').on('click', function() {
            var rows = $('#dt_list_working_locations').DataTable().rows({
                'search': 'applied'
            }).nodes();
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });

    }); // END :: Ready Function


    function select_status() {
        status = $('#status :selected').val();
        dt_list_department(status);
    }


    // DEPARTMENT
    function dt_list_department(status = null) {
        $('#dt_list_department').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'asc'],
                [1, 'asc']
            ],
            responsive: false,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "url": "<?= base_url(); ?>absent_public/dt_list_department",
                "type": "POST",
                "dataType": 'json',
                "data": {
                    status: status
                },
            },
            "columns": [{
                    "data": "department_name",
                },
                {
                    "data": "company_name",
                },
                {
                    "data": "publik",
                    "render": function(data, type, row, meta) {
                        if (data == '0') {
                            status = `<span class="badge bg-danger">Deny</span>`
                        } else {
                            status = `<span class="badge bg-primary">Allow</span>`
                        }
                        department_id = row['department_id'];
                        return `<div id="department_publik_${department_id}">
                                    ${status} <a href="javascript:void(0)" class="badge bg-success" onclick="edit_publik(${department_id}, ${data})">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                </div>`

                    },
                },

            ],
        });
    }

    function edit_publik(department_id, status) {
        select = `<select id="publik_${department_id}">
                    <option value="0" ${status=='0'?'selected':''}>Deny</option>
                    <option value="1" ${status=='1'?'selected':''}>Allow</option>
                </select> <a href="javascript:void(0)" class="badge bg-success" onclick="save_publik(${department_id})">
                    Save
                </a>`;
        $(`#department_publik_${department_id}`).html(select);
    }

    function save_publik(department_id) {

        status = $(`#publik_${department_id} :selected`).val();

        $.ajax({
            'url': '<?= base_url('absent_public/save_publik') ?>',
            'type': 'POST',
            'dataType': 'json',
            'data': {
                department_id: department_id,
                status: status,
            },
            'success': function(response) {
                dt_list_department();
                $('#status').val('');
            }
        })

    }


    // EMPLOYEES
    function select_status_employee() {
        status = $('#status_employee :selected').val();
        dt_list_employees(status);
    }

    function dt_list_employees(status = null) {
        $('#dt_list_employees').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'asc'],
                [1, 'asc']
            ],
            responsive: false,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "url": "<?= base_url(); ?>absent_public/dt_list_employees",
                "type": "POST",
                "dataType": 'json',
                "data": {
                    status: status
                },
            },
            "columns": [{
                    "data": "employee_name",
                },
                {
                    "data": "designation",
                },
                {
                    "data": "department",
                },
                {
                    "data": "company",
                },
                {
                    "data": "publik",
                    "render": function(data, type, row, meta) {
                        if (data == '0') {
                            status = `<span class="badge bg-danger">Deny</span>`
                        } else {
                            status = `<span class="badge bg-primary">Allow</span>`
                        }
                        user_id = row['user_id'];
                        return `<div id="employee_publik_${user_id}">
                                    ${status} <a href="javascript:void(0)" class="badge bg-success" onclick="edit_employee_publik(${user_id}, ${data})">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                </div>`

                    },
                },

            ],
        });
    }

    function edit_employee_publik(user_id, status) {
        select = `<select id="publik_employee_${user_id}">
                    <option value="0" ${status=='0'?'selected':''}>Deny</option>
                    <option value="1" ${status=='1'?'selected':''}>Allow</option>
                </select> <a href="javascript:void(0)" class="badge bg-success" onclick="save_publik_employee(${user_id})">
                    Save
                </a>`;
        $(`#employee_publik_${user_id}`).html(select);
    }

    function save_publik_employee(user_id) {

        status = $(`#publik_employee_${user_id} :selected`).val();

        $.ajax({
            'url': '<?= base_url('absent_public/save_publik_employee') ?>',
            'type': 'POST',
            'dataType': 'json',
            'data': {
                user_id: user_id,
                status: status,
            },
            'success': function(response) {
                dt_list_employees();
                $('#status_employee').val('');
            }
        })

    }

    function dt_list_companies() {
        $('#dt_list_companies').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [1, 'asc']
            ], // Order by Name
            responsive: false,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "url": "<?= base_url(); ?>absent_public/dt_list_companies",
                "type": "POST",
                "dataType": 'json',
            },
            "columns": [{
                    "data": "company_id",
                    "orderable": false,
                    "render": function(data, type, row) {
                        // Checkbox per row
                        return `<div class="form-check">
                                    <input class="form-check-input chk_company" type="checkbox" value="${data}">
                                </div>`;
                    }
                },
                {
                    "data": "name",
                },
                {
                    "data": "total_departments",
                },
                {
                    "data": "total_employees",
                },
                {
                    "data": "is_public",
                    "render": function(data, type, row) {
                        if (data == '1') {
                            return `<span class="badge bg-primary">Allow</span>`;
                        } else {
                            // Menangani 0 atau default 2 atau null
                            return `<span class="badge bg-danger">Deny</span>`;
                        }
                    },
                },
            ],
        });
    }

    // TAMBAHAN: LOGIC BATCH UPDATE DENGAN JQUERY CONFIRM
    function bulk_update_company(status) {
        // 1. Ambil semua ID yang dicentang
        var ids = [];
        $('.chk_company:checked').each(function(i) {
            ids[i] = $(this).val();
        });

        // 2. Validasi jika tidak ada yang dipilih
        if (ids.length === 0) {
            $.alert({
                title: 'Peringatan!',
                content: 'Pilih minimal satu perusahaan!',
                icon: 'bi bi-exclamation-triangle',
                type: 'orange',
                theme: 'material'
            });
            return;
        }

        // 3. Konfirmasi Awal (Sebelum Loading)
        $.confirm({
            title: 'Konfirmasi Update',
            content: 'Apakah Anda yakin ingin mengubah status <b>' + ids.length + '</b> perusahaan yang dipilih?',
            icon: 'bi bi-question-circle',
            theme: 'material',
            type: 'orange',
            buttons: {
                ya: {
                    text: 'Ya, Lanjutkan',
                    btnClass: 'btn-blue',
                    action: function() {
                        // Panggil fungsi proses (Kode Loading Anda)
                        execute_batch_update(ids, status);
                    }
                },
                batal: {
                    text: 'Batal',
                    action: function() {}
                }
            }
        });
    }

    // 4. Fungsi Eksekusi (Loading Spinner -> Ajax -> Success/Fail)
    function execute_batch_update(ids, status) {
        $.confirm({
            icon: 'fa fa-spinner fa-spin',
            title: 'Mohon Tunggu!',
            theme: 'material',
            type: 'blue',
            content: 'Sedang memproses data...',
            buttons: {
                close: {
                    isHidden: true, // Sembunyikan tombol close saat loading
                    actions: function() {}
                },
            },
            onOpen: function() {
                var self = this; // Simpan referensi confirm instance

                $.ajax({
                    url: '<?= base_url("absent_public/save_company_batch") ?>', // URL Updated
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        ids: ids,
                        status: status
                    },
                    beforeSend: function() {
                        // Bisa dikosongkan karena sudah ada spinner
                    },
                    success: function(response) {},
                    error: function(xhr) {},
                    complete: function() {}
                }).done(function(response) {

                    if (response.status == true) {

                        // Refresh Tabel Company
                        dt_list_companies();
                        // Uncheck "Select All"
                        $('#check_all_company').prop('checked', false);

                        setTimeout(() => {
                            self.close(); // Tutup modal loading

                            // Tampilkan Sukses
                            $.confirm({
                                icon: 'bi bi-check-lg',
                                title: 'Berhasil!',
                                theme: 'material',
                                type: 'blue',
                                content: response.message || 'Data berhasil diperbarui!',
                                buttons: {
                                    close: {
                                        text: 'OK',
                                        actions: function() {}
                                    },
                                },
                            });
                        }, 500); // Delay sedikit agar transisi halus

                    } else {
                        self.close(); // Tutup modal loading

                        // Tampilkan Gagal (Logic Server mereturn false)
                        $.confirm({
                            icon: 'bi bi-x-square',
                            title: 'Gagal!',
                            theme: 'material',
                            type: 'red',
                            content: response.message || 'Gagal mengupdate data.',
                            buttons: {
                                close: {
                                    actions: function() {}
                                },
                            },
                        });
                    }
                }).fail(function(jqXHR, textStatus) {
                    setTimeout(() => {
                        self.close(); // Tutup modal loading

                        // Tampilkan Error AJAX (Server Error/500)
                        $.confirm({
                            icon: 'bi bi-x-square',
                            title: 'Oops!',
                            theme: 'material',
                            type: 'red',
                            content: 'Terjadi kesalahan sistem: ' + textStatus,
                            buttons: {
                                close: {
                                    actions: function() {}
                                },
                            },
                        });
                    }, 500);
                });
            },
        });
    }

    function dt_list_working_locations() {
        $('#dt_list_working_locations').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [1, 'asc']
            ],
            responsive: false,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export',
                footer: true
            }],
            "ajax": {
                "url": "<?= base_url(); ?>absent_public/dt_list_working_locations",
                "type": "POST",
                "dataType": 'json',
            },
            "columns": [{
                    "data": "id",
                    "orderable": false,
                    "render": function(data, type, row) {
                        return `<div class="form-check">
                                    <input class="form-check-input chk_location" type="checkbox" value="${data}">
                                </div>`;
                    }
                },
                {
                    "data": "lokasi"
                },
                {
                    "data": "total_employees",
                    "render": function(data, type, row) {
                        return `<span class="badge bg-info text-dark">${data} Active</span>`;
                    }
                },
                {
                    "data": "is_public",
                    "render": function(data, type, row) {
                        if (data == '1') {
                            return `<span class="badge bg-primary">Allow</span>`;
                        } else {
                            return `<span class="badge bg-danger">Deny</span>`;
                        }
                    },
                },
            ],
        });
    }

    function bulk_update_location(status) {
        // 1. Ambil ID
        var ids = [];
        $('.chk_location:checked').each(function(i) {
            ids[i] = $(this).val();
        });

        // 2. Validasi
        if (ids.length === 0) {
            $.alert({
                title: 'Peringatan!',
                content: 'Pilih minimal satu lokasi!',
                icon: 'bi bi-exclamation-triangle',
                type: 'orange',
                theme: 'material'
            });
            return;
        }

        // 3. Konfirmasi
        $.confirm({
            title: 'Konfirmasi Update Lokasi',
            content: 'Apakah Anda yakin ingin mengubah status <b>' + ids.length + '</b> lokasi yang dipilih?',
            icon: 'bi bi-question-circle',
            theme: 'material',
            type: 'orange',
            buttons: {
                ya: {
                    text: 'Ya, Lanjutkan',
                    btnClass: 'btn-blue',
                    action: function() {
                        execute_batch_update_location(ids, status);
                    }
                },
                batal: {
                    text: 'Batal'
                }
            }
        });
    }

    function execute_batch_update_location(ids, status) {
        $.confirm({
            icon: 'fa fa-spinner fa-spin',
            title: 'Mohon Tunggu!',
            theme: 'material',
            type: 'blue',
            content: 'Sedang memproses data...',
            buttons: {
                close: {
                    isHidden: true
                }
            },
            onOpen: function() {
                var self = this;
                $.ajax({
                    url: '<?= base_url("absent_public/save_working_location_batch") ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        ids: ids,
                        status: status
                    },
                    success: function(response) {},
                }).done(function(response) {
                    if (response.status == true) {
                        dt_list_working_locations(); // Refresh tabel lokasi
                        $('#check_all_location').prop('checked', false);

                        setTimeout(() => {
                            self.close();
                            $.confirm({
                                icon: 'bi bi-check-lg',
                                title: 'Berhasil!',
                                theme: 'material',
                                type: 'blue',
                                content: response.message,
                                buttons: {
                                    close: {
                                        text: 'OK'
                                    }
                                }
                            });
                        }, 500);
                    } else {
                        self.close();
                        $.confirm({
                            icon: 'bi bi-x-square',
                            title: 'Gagal!',
                            theme: 'material',
                            type: 'red',
                            content: response.message,
                            buttons: {
                                close: {}
                            }
                        });
                    }
                }).fail(function(jqXHR, textStatus) {
                    self.close();
                    $.confirm({
                        icon: 'bi bi-x-square',
                        title: 'Oops!',
                        theme: 'material',
                        type: 'red',
                        content: 'Error: ' + textStatus,
                        buttons: {
                            close: {}
                        }
                    });
                });
            },
        });
    }
</script>