<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<!-- Tambahin ini di <head> atau sebelum </body> -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet">
</link>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    $(document).ready(function () {

        // definisiin baseurl2 dulu
        var baseurl2 = "<?= site_url(); ?>";

        var tableMasuk = $('#dt_absen_masuk').DataTable({
            processing: true,
            serverSide: false, // ubah true kalau backend lo server-side
            searching: true,
            info: true,
            lengthChange: false,
            paging: true,
            responsive: true,
            order: [[1, 'asc']], // timestamp lebih masuk akal

            dom: 'Bfrtip',
            buttons: [{
                title: 'Data Absen Manual',
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],

            ajax: {
                url: baseurl2 + "/resume_absen_manual/get_data_masuk",
                type: "POST",
                dataType: "json",
                data: function (d) {
                    d.startdate = $('#start').val();
                    d.enddate   = $('#end').val();
                }
            },

            columns: [
                { data: "id", className: "text-center" },
                { data: "timestamp" },
                {
                    data: "nama",
                    render: function (data, type, row) {
                        return `
                            <a href="javascript:void(0)"
                            class="badge bg-primary btn-detail"
                            data-id="${row.id}">
                            ${data}
                            </a>`;
                    }
                },
                { data: "username" },
                { data: "lokasi_kerja" },
                { data: "tipe_absen", className: "text-uppercase fw-bold" },
                { data: "email" },
                { data: "no_hp" },
                { data: "ip_access" }
            ]
        });

        // $('.reportrange .range').daterangepicker({
        //     autoUpdateInput: false,
        //     locale: {
        //         format: 'YYYY-MM-DD',
        //         cancelLabel: 'Clear'
        //     }
        // });

        // $('.reportrange .range').on('apply.daterangepicker', function (ev, picker) {
        //     let start = picker.startDate.format('YYYY-MM-DD');
        //     let end   = picker.endDate.format('YYYY-MM-DD');

        //     $('#start').val(start);
        //     $('#end').val(end);

        //     $(this).val(start + ' - ' + end);

        //     tableMasuk.ajax.reload(); // 🔄 reload data
        // });

        // $('.reportrange .range').on('cancel.daterangepicker', function () {
        //     $(this).val('');
        //     $('#start').val('');
        //     $('#end').val('');
        //     tableMasuk.ajax.reload();
        // });

        // Klik nama → buka modal & load dropdown
        $('#dt_absen_masuk tbody').on('click', '.btn-detail', function (e) {
            e.preventDefault();

            var data = tableMasuk.row($(this).closest('tr')).data();
            $('#detail_id').val(data.id);

            // Load semua karyawan ke select
            $.ajax({
                url: baseurl2 + '/resume_absen_manual/get_all_karyawan_null_ajax',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    var option = '<option value="">-- Pilih Karyawan --</option>';
                    data.forEach(function (r) {
                        option += '<option value="' + r.user_id + '">'
                            + r.first_name + ' ' + r.last_name
                            + ' - ' + r.role_name
                            + ' - ' + r.department_name
                            + ' - ' + r.company_name
                            + '</option>';
                    });
                    $('#selectKaryawan').html(option);

                    // Inisialisasi Select2
                    $('#selectKaryawan').select2({
                        placeholder: "Pilih karyawan",
                        allowClear: true,
                        width: '100%',
                        dropdownParent: $('#modalDetail')
                    });
                }
            });

            // Tampilkan modal
            var modal = new bootstrap.Modal(document.getElementById('modalDetail'));
            modal.show();
        });

        // Ganti dropdown → update username
        $('#selectKaryawan').on('change', function () {
            var selectedId = $(this).val();
            if (!selectedId) {
                $('#detail_username').val('');
                return;
            }

            $.ajax({
                url: baseurl2 + '/resume_absen_manual/get_detail_karyawan_ajax',
                type: 'POST',
                data: { id: selectedId },
                dataType: 'json',
                success: function (res) {
                    $('#detail_username').val(res.username || '');
                }
            });
        });



        // save usn masuk
        // save username masuk
        $('#btnSaveUsername').on('click', function () {
            $.ajax({
                url: baseurl2 + "/resume_absen_manual/update_username_masuk",
                type: "POST",
                data: $('#formUpdateUsername_masuk').serialize(),
                dataType: "json",
                success: function (res) {
                    if (res.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Username berhasil diupdate!',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        $('#modalDetail').modal('hide');
                        tableMasuk.ajax.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Username sudah sesuai',
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Terjadi kesalahan saat request ke server.'
                    });
                }
            });
        });

        // save username keluar
        $('#btnSaveUsernameKeluar').on('click', function () {
            $.ajax({
                url: baseurl2 + "/resume_absen_manual/update_username_keluar",
                type: "POST",
                data: $('#formUpdateUsername_keluar').serialize(),
                dataType: "json",
                success: function (res) {
                    if (res.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Username berhasil diupdate!',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        $('#modalDetailKeluar').modal('hide');
                        tableKeluar.ajax.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Username sudah sesuai',
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Terjadi kesalahan saat request ke server.'
                    });
                }
            });
        });


        // DataTable Absen Keluar
        // Load DataTable
        var tableKeluar = $('#dt_absen_keluar').DataTable({
            searching: true,
            info: true,
            lengthChange: false,
            paging: true,
            destroy: true,
            responsive: true,
            order: [[0, 'asc']],
            dom: 'Bfrtip',
            buttons: [{
                title: 'Data Absen Manual',
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            ajax: {
                url: baseurl2 + "/resume_absen_manual/get_data_keluar",
                type: "POST",
                dataType: "json",
                data: function (d) {
                    d.startdate = $('#start').val(); // ambil dari input hidden
                    d.enddate   = $('#end').val();
                }
            },
            columns: [
                { data: "id", className: "text-center" },
                { data: "timestamp" },
                {
                    data: "nama",
                    render: function (data, type, row) {
                        return `<a href="javascript:void(0)" class="badge bg-primary btn-detail-keluar" data-id="${row.id}">${data}</a>`;
                    }
                },
                { data: "username" },
                { data: "lokasi_kerja" },
                { data: "tipe_absen", className: "text-uppercase fw-bold" },
                { data: "email" },
                { data: "no_hp" },
                { data: "ip_access" }
            ]
        });

        $('.reportrange .range').daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Clear'
            }
        });

        $('.reportrange .range').on('apply.daterangepicker', function (ev, picker) {
            let start = picker.startDate.format('YYYY-MM-DD');
            let end   = picker.endDate.format('YYYY-MM-DD');

            $('#start').val(start);
            $('#end').val(end);

            $(this).val(start + ' - ' + end);

            tableMasuk.ajax.reload();
            tableKeluar.ajax.reload(); // 🔄 reload data
        });

        $('.reportrange .range').on('cancel.daterangepicker', function () {
            $(this).val('');
            $('#start').val('');
            $('#end').val('');
            tableMasuk.ajax.reload();
            tableKeluar.ajax.reload();
        });

        // daterangepicker (bisa pakai yg sama)
        // $('.reportrange .range').daterangepicker({
        //     autoUpdateInput: false,
        //     locale: {
        //         format: 'YYYY-MM-DD',
        //         cancelLabel: 'Clear'
        //     }
        // });

        // $('.reportrange .range').on('apply.daterangepicker', function (ev, picker) {
        //     let start = picker.startDate.format('YYYY-MM-DD');
        //     let end   = picker.endDate.format('YYYY-MM-DD');

        //     $('#start').val(start);
        //     $('#end').val(end);
        //     $(this).val(start + ' - ' + end);

        //     tableKeluar.ajax.reload(); // reload data keluar juga
        // });

        // $('.reportrange .range').on('cancel.daterangepicker', function () {
        //     $(this).val('');
        //     $('#start').val('');
        //     $('#end').val('');
        //     tableKeluar.ajax.reload();
        // });



        // Klik detail keluaR → modal muncul & load dropdown
        $('#dt_absen_keluar tbody').on('click', '.btn-detail-keluar', function (e) {
            e.preventDefault();

            var data = tableKeluar.row($(this).closest('tr')).data();
            $('#detail_id_keluar').val(data.id); // id absen keluar

            // Load semua karyawan ke select
            $.ajax({
                url: baseurl2 + '/resume_absen_manual/get_all_karyawan_null_ajax',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    var option = '<option value="">-- Pilih Karyawan --</option>';
                    data.forEach(function (r) {
                        option += '<option value="' + r.user_id + '">'
                            + r.first_name + ' ' + r.last_name
                            + ' - ' + r.role_name
                            + ' - ' + r.department_name
                            + ' - ' + r.company_name
                            + '</option>';
                    });
                    $('#selectKaryawan_keluar').html(option);

                    $('#selectKaryawan_keluar').select2({
                        placeholder: "Pilih karyawan",
                        allowClear: true,
                        width: '100%',
                        dropdownParent: $('#modalDetailKeluar')
                    });
                }
            });

            var modal = new bootstrap.Modal(document.getElementById('modalDetailKeluar'));
            modal.show();
        });

        // Ganti dropdown → update username
        $('#selectKaryawan_keluar').on('change', function () {
            var selectedId = $(this).val();
            if (!selectedId) {
                $('#detail_username_keluar').val('');
                return;
            }

            $.ajax({
                url: baseurl2 + '/resume_absen_manual/get_detail_karyawan_ajax',
                type: 'POST',
                data: { id: selectedId },
                dataType: 'json',
                success: function (res) {
                    $('#detail_username_keluar').val(res.username || '');
                }
            });
        });



    });
</script>