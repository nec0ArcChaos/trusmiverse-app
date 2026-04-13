<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>


<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>



<script>
    $(document).ready(function() {
        dt_monitoring_absen_mkt();
        dt_monitoring_absen_mkt_nonaktif();

        // //Datepicker
        // var start = moment().startOf('month');
        // var end = moment().endOf('month');

        // function cb(start, end) {
        //     $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        //     $('input[name="start"]').val(start.format('YYYY-MM-DD'));
        //     $('input[name="end"]').val(end.format('YYYY-MM-DD'));
        //     dt_monitoring_absen_mkt();
        //     dt_monitoring_absen_mkt_nonaktif();
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

    });


    function dt_monitoring_absen_mkt() {
        url = "<?= base_url(); ?>monitoring_absen_mkt/dt_monitoring_absen_mkt";
        $('#dt_monitoring_absen_mkt').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [4, 'desc']
            ],
            responsive: true,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": url,
            },
            "columns": [{
                    "data": "employee_name",
                },
                {
                    "data": "spv",
                },
                {
                    "data": "manager",
                },
                {
                    "data": "gm",
                },
                {
                    "data": "harus_absen",
                    "className": "text-center",
                },
                {
                    "data": "absen",
                    "className": "text-center",
                },
                {
                    "data": "tdk_absen",
                    "className": "text-center",
                    "render": function(data, type, row) {
                        return `<a role="button" class="badge bg-primary text-white" onclick="detail_absen('<?= date("Y-m") ?>', '${row['user_id']}')">${row['tdk_absen']}</a>`
                    }
                },
            ]
        });
    }


    function dt_monitoring_absen_mkt_nonaktif() {
        url = "<?= base_url(); ?>monitoring_absen_mkt/dt_monitoring_absen_mkt_nonaktif";
        $('#dt_monitoring_absen_mkt_nonaktif').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [4, 'desc']
            ],
            responsive: true,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": url,
            },
            "columns": [{
                    "data": "employee_name",
                },
                {
                    "data": "spv",
                },
                {
                    "data": "manager",
                },
                {
                    "data": "gm",
                },
                {
                    "data": "auto_non_active",
                    "render": function(data, type, row) {
                        if (row['auto_non_active'] == 1) {
                            return `<span class="badge bg-red text-white" onclick="modal_update_is_active('${row['user_id']}')" style="cursor:pointer;">Non Active</span>`
                        } else {
                            return `<span class="badge bg-green text-white">Active</span>`
                        }
                    }
                },
                {
                    "data": "auto_non_active_at",
                    "className": "text-center",
                    "render": function(data, type, row) {
                        return `${row['auto_non_active_at']}`
                    }
                },
            ]
        });
    }

    function modal_update_is_active(user_id) {
        $.confirm({
            icon: 'bi bi-exclamation-diamond',
            title: 'Konfirmasi',
            type: 'green',
            content: 'Apakah anda yakin aktifkan kembali akun ini?',
            columnClass: 'col-12 col-md-6 col-lg-4',
            closeIcon: true,
            closeIconClass: 'mdi mdi-close-box',
            draggable: true,
            dragWindowGap: 10,
            theme: 'bootstrap',
            animateFromElement: false,
            buttons: {
                tutup: {
                    btnClass: 'btn btn-secondary',
                    action: function() {}
                },
                simpan: {
                    text: 'Ya, simpan!',
                    btnClass: 'btn btn-primary',
                    action: function() {
                        $.ajax({
                            url: '<?= base_url() ?>Monitoring_absen_mkt/activated_user',
                            type: 'POST',
                            data: {
                                user_id: user_id,
                            },
                            success: function(response) {
                                if (response == 'true') {

                                    $.alert({
                                        type: 'green',
                                        theme: 'bootstrap',
                                        animateFromElement: false,
                                        columnClass: 'col-12 col-md-6 col-lg-4',
                                        icon: 'bi bi-check-circle',
                                        title: 'Sukses!',
                                        content: 'Akun User berhasil diaktifkan',
                                        buttons: {
                                            ok: function() {
                                                dt_monitoring_absen_mkt_nonaktif();
                                            }
                                        }
                                    });
                                } else {
                                    $.alert({
                                        type: 'red',
                                        theme: 'bootstrap',
                                        animateFromElement: false,
                                        columnClass: 'col-12 col-md-6 col-lg-4',
                                        icon: 'bi bi-exclamation-octagon',
                                        title: 'Gagal!',
                                        content: 'Akun User gagal diaktifkan, silahkan refresh dahulu dan coba lagi.',
                                        buttons: {
                                            ok: function() {
                                                dt_monitoring_absen_mkt_nonaktif();
                                            }
                                        }
                                    });
                                }
                            },
                            error: function() {
                                $.alert({
                                    type: 'red',
                                    theme: 'bootstrap',
                                    animateFromElement: false,
                                    columnClass: 'col-12 col-md-6 col-lg-4',
                                    icon: 'bi bi-exclamation-octagon',
                                    title: 'Error!',
                                    content: 'Terjadi kesalahan saat mengaktifkan akun user, coba lagi/ coba lagi nanti.',
                                });
                            }
                        });
                    }
                },
            }
        });
    }

    function detail_absen(periode, employee_id) {
        $.ajax({
            url: '<?= base_url('monitoring_absen_mkt/detail_absen') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                periode: periode,
                employee_id: employee_id
            },
            beforeSend: function() {

            },
            success: function(response) {
                $('#modal_detail_absen').modal('show');
                // console.log(response);
                item_detail_absen = ``;
                for (let index = 0; index < response.data.length; index++) {

                    if (response.data[index].photo_in != null) {
                        photo_in = `<a data-fancybox="gallery" href="https://trusmiverse.com/hr_upload/${response.data[index].photo_in}">
                        <figure class="avatar avatar-20 rounded-circle coverimg vm" style="background-image: url(&quot;https://trusmiverse.com/hr_upload/${response.data[index].photo_in}&quot;);">
                            <img src="https://trusmiverse.com/hr_upload/${response.data[index].photo_in}" alt="" id="userphotoonboarding2" style="display: none;">
                        </figure></a>`;
                    } else {
                        photo_in = '<h5 class="fw-medium small">No Photo<small></small></h5>';
                    }
                    if (response.data[index].photo_out != null) {
                        photo_out = `<a data-fancybox="gallery" href="https://trusmiverse.com/hr_upload/${response.data[index].photo_out}">
                        <figure class="avatar avatar-20 rounded-circle coverimg vm" style="background-image: url(&quot;https://trusmiverse.com/hr_upload/${response.data[index].photo_out}&quot;);">
                            <img src="https://trusmiverse.com/hr_upload/${response.data[index].photo_out}" alt="" id="userphotoonboarding2" style="display: none;">
                        </figure></a>`;
                    } else {
                        photo_out = '<h5 class="fw-medium small">No Photo<small></small></h5>';
                    }

                    border_late = '';
                    if (response.data[index].diff_in > 0) {
                        border_late = 'border-late';
                    }
                    late = '';
                    if (response.data[index].diff_in > 0) {
                        late = `(Late ${response.data[index].diff_in} mnt)`;
                    }
                    pulang = '';
                    if (response.data[index].diff_out < 0) {
                        pulang = `(Early ${response.data[index].diff_out} mnt)`;
                    }
                    if (response.data[index].diff_out > 0) {
                        pulang = `(Over ${response.data[index].diff_out} mnt)`;
                    }
                    item_detail_absen += `
                        <div class="card mb-1 mt-1">
                            <div class="card-body ${border_late}">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="circle-small">
                                            <div id="circleprogressblue"></div>
                                            <div class="avatar h5 bg-light-blue rounded-circle">
                                                <i class="bi bi-calendar2-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="row">
                                            <p class="text-dark small mb-1 col-12 col-md-6" style="font-weight: bold;">Tgl : ${response.data[index].attendance_date}</p>
                                            <p class="text-dark small mb-1 col-12 col-md-6">Shift : <span>${response.data[index].shift_in}</span> s/d <span>${response.data[index].shift_out}</span> </p>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                                <p class="text-secondary small mb-1">Clock In</p>
                                                <h5 class="fw-medium small">${response.data[index].clock_in}<small> ${late}</small></h5>
                                            </div>
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                                <p class="text-secondary small mb-1">Photo In</p>
                                                ${photo_in}
                                            </div>
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                                <p class="text-secondary small mb-1">Clock Out</p>
                                                <h5 class="fw-medium small">${response.data[index].clock_out ?? '-'}<small> ${pulang}</small></h5>
                                            </div>
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                                                <p class="text-secondary small mb-1">Photo Out</p>
                                                ${photo_out}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                }
                $("#body_detail_absen").empty().append(item_detail_absen);
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        });
    }
</script>