<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.1/viewer.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.1/viewer.min.js"></script>

<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip()




        // Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="startdate"]').val(start.format('YYYY-MM-DD'));
            $('input[name="enddate"]').val(end.format('YYYY-MM-DD'));
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
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                    .endOf('month')
                ]
            }
        }, cb);

        cb(start, end);


        dt_fdk('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>');


        $('#btn_filter').on('click', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            dt_fdk(start, end);

        });


    });

    var type_list = 0;

    function dt_fdk(start, end) {

        $('#dt_fdk').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'asc']
            ],
            buttons: [{
                    title: 'Data Dokumen Karyawan ' + start,
                    extend: 'excelHtml5',
                    text: 'Export to Excel',
                    footer: true
                },
                // {
                //     text: '<i class="bi bi-file-earmark-lock2"></i> Lock hari ini',
                //     action: function(e, dt, node, config) {
                //         if (type_list == 0) {
                //             var btn_s = $('.switch').contents();
                //             type_list = 1;
                //             console.log(btn_s);
                //         } else {
                //             type_list = 0;
                //             console.log('lock hari ini');
                //         }
                //     },
                //     className: 'switch'
                // }
            ],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": "<?= base_url(); ?>fdk/get_data",
                "data": {
                    start: start,
                    end: end,
                }
            },
            "columns": [{
                    "data": "user_id",
                    "render": function(data, type, row, meta) {
                        return meta.row + 1
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'nama',
                    'render': function(data, type, row) {
                        if (row['date_of_joining']) {
                            var createdAt = new Date(row['date_of_joining']);
                            var today = new Date();

                            // Mengatur waktu pada objek tanggal ke tengah malam
                            createdAt.setHours(0, 0, 0, 0);
                            today.setHours(0, 0, 0, 0);

                            // Menghitung selisih hari tanpa memperhitungkan waktu
                            var timeDifference = today.getTime() - createdAt.getTime();
                            var dayDifference = timeDifference / (1000 * 3600 * 24);

                            // Memeriksa apakah ada hari Minggu dalam 3 hari terakhir
                            var containsSunday = false;
                            for (var i = 1; i <= 2; i++) {
                                var day = new Date(today);
                                day.setDate(today.getDate() - i);
                                if (day.getDay() === 0) { // 0 adalah Minggu
                                    containsSunday = true;
                                    break;
                                }
                            }
                            // Tambahkan kondisi jika hari kemarin adalah Minggu
                            var adjustedDayDifference = containsSunday ? 3 : 2;
                            if (dayDifference === adjustedDayDifference && row['fdk_status'] != 'Complete') {
                                return `<span>${data} </span><span class="badge bg-danger" data-html="true" data-toggle="tooltip" data-placement="bottom" title="Hanya status complete yang lolos lock absen. | Tips: resend notif jika status pending"><i class="fa fa-lock"></i> Hari ini</span>`;
                            }
                        }
                        return data;
                    }
                },

                {
                    'data': 'company',
                },
                {
                    'data': 'designation_name',
                    "render": function(data, type, row, meta) {
                        if (row['type_sales'] == '-') {
                            return data;
                        } else if (row['type_sales'] == 'Inhouse') {
                            return `${data} <span class="badge bg-light-red text-red">${row['type_sales']}<span>`
                        } else {
                            return `${data} <span class="badge bg-light-teal text-teal">${row['type_sales']}<span>`

                        }
                    }
                },

                {
                    'data': 'fdk_status',
                    "render": function(data, type, row, meta) {
                        if (data == 'Pending') {
                            return `<span class="badge bg-secondary">${data}</span> <a role="button" onclick="send_ulang('${row['user_id']}')" class="badge bg-secondary" style="cursor:pointer;"><i class="bi bi-send"></i></a> <span onclick="copy_link(${row['user_id']})" class="badge bg-green" style="cursor:pointer;"><i class="fa fa-copy"></i></span>`;
                        } else if (data == 'Progres') {
                            return `<span class="badge bg-yellow">${data}</span> <a role="button" onclick="send_ulang('${row['user_id']}')" class="badge bg-secondary" style="cursor:pointer;"><i class="bi bi-send"></i></a> <span onclick="copy_link(${row['user_id']})" class="badge bg-green" style="cursor:pointer;"><i class="fa fa-copy"></i></span>`;

                        } else if (data == 'Submitted') {
                            return `<span class="badge bg-green" style="cursor:pointer;" onclick="konfirmasi('${row['user_id']}','${row['ktp_status']}','${row['kk_status']}','${row['lamaran_status']}','${row['cv_status']}','${row['ijazah_status']}','${row.transkip_status}','${row['npwp_status']}','${row['surat_lulus_status']}','${row['verklaring_status']}','${row['sertifikat_status']}','${row['dokumen_lain_status']}','${row['type_sales']}')">${data}</span> <a role="button" onclick="send_ulang('${row['user_id']}')" class="badge bg-secondary" style="cursor:pointer;"><i class="bi bi-send"></i></a> <span onclick="copy_link(${row['user_id']})" class="badge bg-green" style="cursor:pointer;"><i class="fa fa-copy"></i></span> <a href="<?= base_url('fdk/print_view/'); ?>${row['user_id']}" target="_blank" class="badge bg-info" style="cursor:pointer;"><i class="fa fa-print"></i></a>`;
                        } else {
                            return `<span class="badge bg-blue" >${data}</span> <a role="button" onclick="send_ulang('${row['user_id']}')" class="badge bg-secondary" style="cursor:pointer;"><i class="bi bi-send"></i></a> <span onclick="copy_link(${row['user_id']})" class="badge bg-green" style="cursor:pointer;"><i class="fa fa-copy"></i></span> <a href="<?= base_url('fdk/print_view/'); ?>${row['user_id']}" target="_blank" class="badge bg-info" style="cursor:pointer;"><i class="fa fa-print"></i></a>`;

                        }
                    }
                },
                {
                    'data': 'date_of_joining',

                },
                {
                    'data': 'pic_nama',

                },
                {
                    'data': 'updated_at',

                },
                {
                    'data': 'ktp_status',
                    'className': 'text-center bg-light-yellow',
                    "render": function(data, type, row, meta) {
                        if (data == 'Approved') {
                            return `<a href="<?= base_url('uploads/fdk/'); ?>${row['ktp']}" data-fancybox data-lightbox="1" data-caption="" class="badge bg-primary" style="cursor:pointer"><i class="fa fa-image"></></a>`;
                        } else {
                            return `${data}`;
                        }
                    }

                },
                
                {
                    'data': 'kk_status',
                    'className': 'text-center bg-light-yellow',
                    "render": function(data, type, row, meta) {
                        if (data == 'Approved') {
                            return `<a href="<?= base_url('uploads/fdk/'); ?>${row['kk']}" data-fancybox data-lightbox="1" data-caption="" class="badge bg-primary" style="cursor:pointer"><i class="fa fa-image"></></a>`;
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    'data': 'lamaran_status',
                    'className': 'text-center bg-light-yellow',
                    "render": function(data, type, row, meta) {
                        if (data == 'Approved') {
                            return `<a href="<?= base_url('uploads/fdk/'); ?>${row['lamaran']}" data-fancybox data-lightbox="1" data-caption="" class="badge bg-primary" style="cursor:pointer"><i class="fa fa-image"></></a>`;
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    'data': 'cv_status',
                    'className': 'text-center bg-light-yellow',
                    "render": function(data, type, row, meta) {
                        if (data == 'Approved') {
                            return `<a href="<?= base_url('uploads/fdk/'); ?>${row['cv']}" data-fancybox data-lightbox="1" data-caption="" class="badge bg-primary" style="cursor:pointer"><i class="fa fa-image"></></a>`;
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    'data': 'ijazah_status',
                    'className': 'text-center bg-light-yellow',
                    "render": function(data, type, row, meta) {
                        if (data == 'Approved') {
                            return `<a href="<?= base_url('uploads/fdk/'); ?>${row['ijazah']}" data-fancybox data-lightbox="1" data-caption="" class="badge bg-primary" style="cursor:pointer"><i class="fa fa-image"></></a>`;
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    'data': 'transkip_status',
                    'className': 'text-center',
                    "render": function(data, type, row, meta) {
                        if (data == 'Approved') {
                            return `<a href="<?= base_url('uploads/fdk/'); ?>${row['transkip']}" data-fancybox data-lightbox="1" data-caption="" class="badge bg-primary" style="cursor:pointer"><i class="fa fa-image"></></a>`;
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    'data': 'npwp_status',
                    'className': 'text-center',
                    "render": function(data, type, row, meta) {
                        if (data == 'Approved') {
                            return `<a href="<?= base_url('uploads/fdk/'); ?>${row['npwp']}" data-fancybox data-lightbox="1" data-caption="" class="badge bg-primary" style="cursor:pointer"><i class="fa fa-image"></></a>`;
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    'data': 'surat_lulus_status',
                    'className': 'text-center',
                    "render": function(data, type, row, meta) {
                        if (data == 'Approved') {
                            return `<a href="<?= base_url('uploads/fdk/'); ?>${row['surat_lulus']}" data-fancybox data-lightbox="1" data-caption="" class="badge bg-primary" style="cursor:pointer"><i class="fa fa-image"></></a>`;
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    'data': 'verklaring_status',
                    'className': 'text-center',
                    "render": function(data, type, row, meta) {
                        if (data == 'Approved') {
                            return `<a href="<?= base_url('uploads/fdk/'); ?>${row['verklaring']}" data-fancybox data-lightbox="1" data-caption="" class="badge bg-primary" style="cursor:pointer"><i class="fa fa-image"></></a>`;
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    'data': 'sertifikat_status',
                    'className': 'text-center',
                    "render": function(data, type, row, meta) {
                        if (data == 'Approved') {
                            return `<a href="<?= base_url('uploads/fdk/'); ?>${row['sertifikat']}" data-fancybox data-lightbox="1" data-caption="" class="badge bg-primary" style="cursor:pointer"><i class="fa fa-image"></></a>`;
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    'data': 'dokumen_lain_status',
                    'className': 'text-center',
                    "render": function(data, type, row, meta) {
                        if (data == 'Approved') {
                            return `<a href="<?= base_url('uploads/fdk/'); ?>${row['dokumen_lain']}" data-fancybox data-lightbox="1" data-caption="" class="badge bg-primary" style="cursor:pointer"><i class="fa fa-image"></></a>`;
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    'data':'contact',
                    'className': 'text-center',
                    'render':function(data,type,row){
                        return `<span class="badge bg-info" style='cursor:pointer' onclick="lihat_contact('${row['user_id']}')">${data}</span>`;
                    }
                }


            ],
            // "createdRow": function(row, data, dataIndex) {
            //     // 
            // }
        });
    }

    function input_dokumen() {
        $('#modal_input').modal('show');
        get_karyawan();
    }
    let karyawan_select = NiceSelect.bind(document.getElementById('karyawan'), {
        searchable: true
    });

    function get_karyawan() {
        url = "<?= base_url('fdk/karyawan') ?>";
        $.getJSON(url, function(result) {
            karyawan = '<option value="" disabled selected>Pilih Karyawan</option>';
            $.each(result, function(index, value) {
                karyawan +=
                    `<option value="${value['user_id']},${value['username']},${value['nama_karyawan']},${value['designation_name']},${value['company']} ,${value['application_id']}" >${value['nama_karyawan']}</option>`;
            })

            $("#karyawan").html(karyawan)
            karyawan_select.update();
        });
    }
    $('#karyawan').change(function(e) {
        var data = $('#karyawan').val()
        var karyawan = data.split(',');
        $('#id_employee').val(karyawan[0]);
        $('#username').val(karyawan[1]);
        $('#nama').val(karyawan[2]);
        $('#posisi').val(karyawan[3]);
        $('#company').val(karyawan[4]);
        $('#app_id').val(karyawan[5]);

    });

    function list_approve() {
        $('#modal_approval').modal('show');
        $('#dt_approval').DataTable({
            "searching": true,
            "info": true,
            "language": {
                "info": "Showing _START_ to _END_ of _TOTAL_ entries,  P : Pending | R : Re-Submission | A : Approved",
            },
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'asc']
            ],
            "buttons": [{
                title: 'Data Dokumen Karyawan ',
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "url": "<?= base_url(''); ?>fdk/get_data_appl",
                "type": "GET",
                "dataType": 'json',
            },
            "columns": [{
                    "data": "user_id",
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'nama',

                },
                {
                    'data': 'company',
                    "render": function(data, type, row, meta) {
                        if (row['type_sales'] == '-') {
                            return `${row['company']} | ${row['designation_name']}`;
                        } else if (row['type_sales'] == 'Inhouse') {
                            return `${row['company']} | ${row['designation_name']} <span class="badge bg-light-red text-red">${row['type_sales']}<span>`
                        } else {
                            return `${row['company']} | ${row['designation_name']} <span class="badge bg-light-teal text-teal">${row['type_sales']}<span>`

                        }
                    }

                },
                {
                    'data': 'date_of_joining',

                },
                {
                    'data': 'pic_nama',

                },

                {
                    'data': 'ktp_status',
                    'className': 'text-center bg-light-yellow',
                    "render": function(data, type, row, meta) {
                        if (data == 'Pending') {
                            return `<span class="text-secondary"><i class="fa fa-clock"></i> P</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['ktp']}','ktp','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Re-Submission') {
                            return `<span class="text-danger"><i class="fa fa-rotate-right"></i> R</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['ktp']}','ktp','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Approved') {
                            return `<span class="text-success"><i class="fa fa-check-circle"></i> A</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['ktp']}','ktp','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    'data': 'kk_status',
                    'className': 'text-center bg-light-yellow',
                    "render": function(data, type, row, meta) {
                        if (data == 'Pending') {
                            return `<span class="text-secondary"><i class="fa fa-clock"></i> P</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['kk']}','kk','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Re-Submission') {
                            return `<span class="text-danger"><i class="fa fa-rotate-right"></i> R</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['kk']}','kk','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Approved') {
                            return `<span class="text-success"><i class="fa fa-check-circle"></i> A</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['kk']}','kk','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    'data': 'lamaran_status',
                    'className': 'text-center bg-light-yellow',
                    "render": function(data, type, row, meta) {
                        if (data == 'Pending') {
                            return `<span class="text-secondary"><i class="fa fa-clock"></i> P</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['lamaran']}','lamaran','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Re-Submission') {
                            return `<span class="text-danger"><i class="fa fa-rotate-right"></i> R</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['lamaran']}','lamaran','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Approved') {
                            return `<span class="text-success"><i class="fa fa-check-circle"></i> A</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['lamaran']}','lamaran','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    'data': 'cv_status',
                    'className': 'text-center bg-light-yellow',
                    "render": function(data, type, row, meta) {
                        if (data == 'Pending') {
                            return `<span class="text-secondary"><i class="fa fa-clock"></i> P</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['cv']}','cv','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Re-Submission') {
                            return `<span class="text-danger"><i class="fa fa-rotate-right"></i> R</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['cv']}','cv','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Approved') {
                            return `<span class="text-success"><i class="fa fa-check-circle"></i> A</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['cv']}','cv','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    'data': 'ijazah_status',
                    'className': 'text-center bg-light-yellow',
                    "render": function(data, type, row, meta) {
                        if (data == 'Pending') {
                            return `<span class="text-secondary"><i class="fa fa-clock"></i> P</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['ijazah']}','ijazah','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Re-Submission') {
                            return `<span class="text-danger"><i class="fa fa-rotate-right"></i> R</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['ijazah']}','ijazah','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Approved') {
                            return `<span class="text-success"><i class="fa fa-check-circle"></i> A</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['ijazah']}','ijazah','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    'data': 'transkip_status',
                    'className': 'text-center',
                    "render": function(data, type, row, meta) {
                        if (data == 'Pending') {
                            return `<span class="text-secondary"><i class="fa fa-clock"></i> P</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['transkip']}','transkip','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Re-Submission') {
                            return `<span class="text-danger"><i class="fa fa-rotate-right"></i> R</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['transkip']}','transkip','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Approved') {
                            return `<span class="text-success"><i class="fa fa-check-circle"></i> A</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['transkip']}','transkip','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    'data': 'npwp_status',
                    'className': 'text-center',
                    "render": function(data, type, row, meta) {
                        if (data == 'Pending') {
                            return `<span class="text-secondary"><i class="fa fa-clock"></i> P</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['npwp']}','npwp','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Re-Submission') {
                            return `<span class="text-danger"><i class="fa fa-rotate-right"></i> R</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['npwp']}','npwp','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Approved') {
                            return `<span class="text-success"><i class="fa fa-check-circle"></i> A</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['npwp']}','npwp','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    'data': 'surat_lulus_status',
                    'className': 'text-center',
                    "render": function(data, type, row, meta) {
                        if (data == 'Pending') {
                            return `<span class="text-secondary"><i class="fa fa-clock"></i> P</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['surat_lulus']}','surat_lulus','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Re-Submission') {
                            return `<span class="text-danger"><i class="fa fa-rotate-right"></i> R</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['surat_lulus']}','surat_lulus','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Approved') {
                            return `<span class="text-success"><i class="fa fa-check-circle"></i> A</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['surat_lulus']}','surat_lulus','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    'data': 'verklaring_status',
                    'className': 'text-center',
                    "render": function(data, type, row, meta) {
                        if (data == 'Pending') {
                            return `<span class="text-secondary"><i class="fa fa-clock"></i> P</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['verklaring']}','verklaring','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Re-Submission') {
                            return `<span class="text-danger"><i class="fa fa-rotate-right"></i> R</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['verklaring']}','verklaring','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Approved') {
                            return `<span class="text-success"><i class="fa fa-check-circle"></i> A</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['verklaring']}','verklaring','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    'data': 'sertifikat_status',
                    'className': 'text-center',
                    "render": function(data, type, row, meta) {
                        if (data == 'Pending') {
                            return `<span class="text-secondary"><i class="fa fa-clock"></i> P</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['sertifikat']}','sertifikat','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Re-Submission') {
                            return `<span class="text-danger"><i class="fa fa-rotate-right"></i> R</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['sertifikat']}','sertifikat','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Approved') {
                            return `<span class="text-success"><i class="fa fa-check-circle"></i> A</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['sertifikat']}','sertifikat','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else {
                            return `${data}`;
                        }
                    }
                },
                {
                    'data': 'dokumen_lain_status',
                    'className': 'text-center',
                    "render": function(data, type, row, meta) {
                        if (data == 'Pending') {
                            return `<span class="text-secondary"><i class="fa fa-clock"></i> P</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['dokumen_lain']}','dokumen_lain','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Re-Submission') {
                            return `<span class="text-danger"><i class="fa fa-rotate-right"></i> R</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['dokumen_lain']}','dokumen_lain','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else if (data == 'Approved') {
                            return `<span class="text-success"><i class="fa fa-check-circle"></i> A</span> <span class="badge bg-primary" style="cursor:pointer" onclick="view_dokumen('${row['dokumen_lain']}','dokumen_lain','${row['user_id']}')"><i class="fa fa-image"></></span>`
                        } else {
                            return `${data}`;
                        }
                    }
                }
            ],
        });
    }

    let viewer;

    function view_dokumen(data, dokumen, user_id) {
        $('.dokumen').val(dokumen);
        $('.user_id').val(user_id);
        var base_url = '<?= base_url('uploads/fdk/'); ?>';
        let modalBody = $('#preview_body');

        modalBody.empty(); // Clear previous content

        let fileExtension = data.split('.').pop().toLowerCase();
        let content;

        if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
            content = `<small class="text-secondary text-center">Klik Untuk Zoom Image</small><img src="${base_url}${data}" width="100%" style='cursor:pointer'>`;
        } else {
            content = `<p>Preview not available for this file type.</p>`;
        }

        modalBody.append(content);
        $('#modal_preview').modal('show');
        // Initialize viewer.js for images
        if (viewer) {
            viewer.destroy();
        }

        // Initialize viewer.js for images
        viewer = new Viewer(document.getElementById('preview_body'), {
            inline: false,
            navbar: false,
            toolbar: true,
        });

    }

    function update(type) {
        var user_id = $('.user_id').val();
        var dokumen = $('.dokumen').val();
        if (type == 1) { //approve
            $.confirm({
                title: 'Alert!',
                content: 'Apakah anda yakin ?',
                type: 'blue',
                theme: 'material',
                typeAnimated: true,
                closeIcon: false, // explicitly show the close icon
                animation: 'opacity',
                buttons: {
                    close: function() {},
                    confirm: {
                        text: 'Yakin',
                        btnClass: 'btn-blue',
                        action: function() {
                            update_dokumen(type, dokumen, user_id);

                            $.alert({
                                title: 'Success',
                                content: 'Berhasil di update!',
                                type: 'blue',
                                theme: 'material',
                                autoClose: 'ok|3000',
                            });
                            $('#modal_preview').modal('hide');
                            $("#dt_approval").DataTable().ajax.reload();
                            $("#dt_fdk").DataTable().ajax.reload();
                        }
                    },
                }
            });
        } else { //reject
            $.confirm({
                title: 'Alert!',
                content: 'Apakah anda yakin ?',
                type: 'red',
                theme: 'material',
                typeAnimated: true,
                closeIcon: false, // explicitly show the close icon
                animation: 'opacity',
                buttons: {
                    close: function() {},
                    confirm: {
                        text: 'Yakin',
                        btnClass: 'btn-red',
                        action: function() {
                            update_dokumen(type, dokumen, user_id);
                            $.alert({
                                title: 'Success',
                                content: 'Berhasil di update!',
                                type: 'blue',
                                theme: 'material',
                                autoClose: 'ok|3000',
                            });
                            $('#modal_preview').modal('hide');
                            $("#dt_approval").DataTable().ajax.reload();
                            $("#dt_fdk").DataTable().ajax.reload();
                        }
                    },
                }
            });
        }
    }

    function update_dokumen(type, dokumen, user_id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('fdk/update_dokumen'); ?>",
            data: {
                type: type,
                dokumen: dokumen,
                user_id: user_id,
            },
            dataType: "json",
            success: function(response) {

            }
        });
    }

    function konfirmasi(user_id, ktp, kk, lamaran, cv, ijazah, transkip, npwp, surat_lulus, verklaring, sertifikat, dokumen_lain, type_sales) {
        
        console.log(lamaran);
        console.log(kk);
        const isPendingOrResubmission = status => ['Pending', 'Re-Submission'].includes(status);
        const documents = {
            ktp,
            kk,
            lamaran,
            cv,
            ijazah
        };

        const getPendingDocuments = () => {
            let pendingDocs = [];
            for (const [key, value] of Object.entries(documents)) {
                if (isPendingOrResubmission(value)) {
                    pendingDocs.push(key.toUpperCase());
                }
            }
            return pendingDocs;
        };

        const showAlert = (pendingDocs) => {
            $.alert({
                title: 'Opps!',
                content: `Beberapa Dokumen wajib <b>belum di approve atau belum clear</b> yaitu: <br>${pendingDocs.join(', ')}`,
                type: 'red',
                theme: 'material',
                autoClose: 'ok|5000',
            });
        };

        let pendingDocs;
        if (type_sales === 'Freelance') {
            pendingDocs = getPendingDocuments().filter(doc => ['KTP', 'KK'].includes(doc));
            if (pendingDocs.length > 0) {
                showAlert(pendingDocs);
                return;
            }
        } else {
            pendingDocs = getPendingDocuments();
            if (pendingDocs.length > 0) {
                showAlert(pendingDocs);
                return;
            }
        }

        $.confirm({
            title: 'Konfirmasi!',
            type: 'blue',
            theme: 'material',
            content: 'Jika sudah di verifikasi, maka akan di kirimkan <b>Notif untuk karyawan</b>',
            buttons: {
                cancel: function() {
                    // close
                },
                formSubmit: {
                    text: 'Yes',
                    btnClass: 'btn-blue',
                    action: function() {
                        $.confirm({
                            icon: 'fa fa-spinner fa-spin',
                            title: 'Mohon Tunggu!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Sedang memproses...',
                            buttons: {
                                close: {
                                    isHidden: true,
                                    action: function() {}
                                },
                            },
                            onOpen: function() {
                                $.ajax({
                                    url: `<?= base_url() ?>fdk/konfirmasi/${user_id}`,
                                    type: 'GET',
                                    dataType: 'json',
                                    beforeSend: function() {},
                                    success: function(response) {},
                                    error: function(xhr) {},
                                    complete: function() {},
                                }).done(function(response) {
                                    $("#dt_fdk").DataTable().ajax.reload();
                                    setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-check',
                                            title: 'Done!',
                                            theme: 'material',
                                            type: 'blue',
                                            content: 'Status Berhasil di rubah dan Notifikasi sudah di kirim!',
                                            autoClose: 'ok|3000',
                                        });
                                    }, 250);
                                }).fail(function(jqXHR, textStatus) {
                                    setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-close',
                                            title: 'Oops!',
                                            theme: 'material',
                                            type: 'red',
                                            content: 'Gagal verifikasi! ' + textStatus,
                                            autoClose: 'ok|3000',
                                        });
                                    }, 250);
                                });
                            },
                        });
                    }
                },
            },
        });

    }


    function submit_dokumen() {
        var validate = [];
        // validate.push(validation_input('#karyawan','karyawan','select'));
        validate.push(validation_input('#ktp', 'ktp', 'file'));
        validate.push(validation_input('#kk', 'kk', 'file'));
        validate.push(validation_input('#lamaran', 'lamaran', 'file'));
        validate.push(validation_input('#cv', 'cv', 'file'));
        validate.push(validation_input('#ijazah', 'ijazah', 'file'));
        if (containsAllFalse(validate) == true) {
            var form_data = new FormData();
            var application_id = $('#app_id').val();
            var employee_id = $('#id_employee').val();
            var ktp = $('#ktp')[0].files[0];
            var kk = $('#kk')[0].files[0];
            var lamaran = $('#lamaran')[0].files[0];
            var cv = $('#cv')[0].files[0];
            var ijazah = $('#ijazah')[0].files[0];
            form_data.append('application_id', application_id);
            form_data.append('employee_id', employee_id);
            form_data.append('ktp', ktp);
            form_data.append('kk', kk);
            form_data.append('lamaran', lamaran);
            form_data.append('cv', cv);
            form_data.append('ijazah', ijazah);
            console.info(form_data);
            $.ajax({

                url: '<?= base_url() ?>fdk/insert_dokumen',
                type: 'POST',
                dataType: 'json',
                data: form_data,
                processData: false,
                contentType: false,

            }).done(function(data) {
                new PNotify({
                    title: `Success`,
                    text: `Document Updated`,
                    icon: 'icofont icofont-check',
                    delay: 2000,
                    type: 'success'
                });
            }).fail(function(jqXHR, textStatus) {
                new PNotify({
                    title: `Failed`,
                    text: `Failed to Update Document`,
                    icon: 'icofont icofont-info-circle',
                    type: 'error',
                    delay: 2000,
                });
            });
        }

    }

    function send_ulang(id) {
        $.confirm({
            title: 'Kirim Ulang!',
            type: 'blue',
            theme: 'material',
            content: 'Apakah anda yakin resend notif FDK ?',
            buttons: {
                cancel: function() {
                    //close
                },
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function() {
                        $.confirm({
                            icon: 'fa fa-spinner fa-spin',
                            title: 'Mohon Tunggu!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Sedang memproses...',
                            buttons: {
                                close: {
                                    isHidden: true,
                                    actions: function() {}
                                },
                            },
                            onOpen: function() {
                                $.ajax({
                                    url: `<?= base_url() ?>fdk/send_to/${id}`,
                                    type: 'GET',
                                    dataType: 'json',
                                    beforeSend: function() {

                                    },
                                    success: function(response) {},
                                    error: function(xhr) {},
                                    complete: function() {},
                                }).done(function(response) {
                                    console.log(response);
                                    // dt_fack();
                                    setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-check',
                                            title: 'Done!',
                                            theme: 'material',
                                            type: 'blue',
                                            content: 'Resend notif!',
                                            buttons: {
                                                close: {
                                                    actions: function() {}
                                                },
                                            },
                                        });
                                    }, 250);
                                }).fail(function(jqXHR, textStatus) {
                                    setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-close',
                                            title: 'Oops!',
                                            theme: 'material',
                                            type: 'red',
                                            content: 'Gagal Resend Notif!' + textStatus,
                                            buttons: {
                                                close: {
                                                    actions: function() {}
                                                },
                                            },
                                        });
                                    }, 250);
                                });
                            },

                        });
                    }
                },
            },
        });
    }

    function uploadPhoto(directoryUrl, inputId) {
        var fileInput = document.getElementById(inputId);
        var file = fileInput.files[0];
        var fileName = file.name;
        var fileSize = file.size;

        // Set nama file ke input foto
        // $('#' + inputId).val(fileName);

        // Tambahkan tag small "Uploading..." setelah input foto
        var upload_status = $('<small class="uploadStatus"><i class="fa fa-spinner fa-pulse"></i> Uploading...</small>');
        $('#' + inputId).after(upload_status);
        var formData = new FormData();
        formData.append('photo', file);
        formData.append('url', directoryUrl);
        var controller = window.location.origin + '/ClassUpload/upload_file';
        // Kirim data gambar ke server menggunakan AJAX
        $.ajax({
            url: controller,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                var data = JSON.parse(res);
                $('#' + inputId + '_value').val(data.upload_data.file_name); //set ke input text file name
                upload_status.html('<i class="fa fa-check-circle text-success"></i> File has been Uploaded').delay(4000).fadeOut();
            },
            error: function(xhr, status, error) {
                // Proses unggah gagal
                console.error('Upload failed. Status:', status, 'Error:', error);
                upload_status.html('<i class="fa fa-times-circle text-danger"></i> Upload failed. Please try again.').delay(4000).fadeOut();
            }
        });
        // Kompress gambar dan lakukan unggah

    }

    function copy_link(user_id) {
        $.ajax({
            type: "GET",
            url: '<?= base_url('fdk/hashUser/'); ?>' + user_id,

            dataType: "json",
            success: function(response) {
                var link = '<?= base_url('fdk/form/'); ?>' + response;
                var tempInput = document.createElement('input');
                tempInput.value = link;
                document.body.appendChild(tempInput);
                tempInput.select();
                tempInput.setSelectionRange(0, 99999); // For mobile devices
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                $.alert({
                    title: 'Success',
                    content: 'Berhasil di copas! : <br>' + link,
                    type: 'blue',
                    theme: 'material',
                    autoClose: 'ok|3000',
                });
            }
        });
    }

    function lihat_contact(id){
        $('#modal_lihat_contact').modal('show');
        $('#dt_contact').DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "order": [
                [0, "asc"]
            ],
            "destroy": true,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    id:id
                },
                "url": "<?= site_url('fdk/get_contact') ?>",
            },
            "columns": [{
                    "data": "id",
                    "render": function(data, type, row, meta) {
						return meta.row + 1
					},
					'className': 'text-center'
                    
                },
                {
                    "data": "name",
                   
                },
                {
                    "data": "phone"
                },
                {
                    "data": "email"
                },
                {
                    "data": "contact"
                },
                {
                    "data": "created_at"
                },
            ]
        });
    }



    function containsAllFalse(array) {
        for (let i = 0; i < array.length; i++) {
            if (array[i] !== false) {
                return false;
            }
        }
        return true;
    }

    function validation_input(id, input, type) {

        if (type == 'select') {
            if ($('[name="' + input + '"]').val() == null || $('[name="' + input + '"]').val() == '') {
                $(id).after(
                    '<small class="text-danger ' + input +
                    '-invalid"><li class="fa fa-info-circle"></li> Please provide a valid select.</small>'
                );
                $('.' + input + '-invalid').delay(4000);
                $('.' + input + '-invalid').fadeOut();

                return true;

            } else {
                $('.' + input + '-invalid').remove();
                return false;
            }

        } else if (type == 'text') {
            if ($('[name="' + input + '"]').val() == null || $('[name="' + input + '"]').val() == '') {
                $(id).after(
                    '<small class="text-danger ' + input +
                    '-invalid"><li class="fa fa-info-circle"></li> Please provide a valid input.</small>'
                ).fadeIn();
                $('.' + input + '-invalid').delay(4000);
                $('.' + input + '-invalid').fadeOut();

                return true;
            } else {
                $('.' + input + '-invalid').remove();
                return false;
            }
        } else if (type == 'file') {
            if ($('[name="' + input + '"]').val() == null || $('[name="' + input + '"]').val() == '' || $('[name="' +
                    input + '"]').val() < 1) {
                $(id).after(
                    '<small class="text-danger ' + input +
                    '-invalid"><li class="fa fa-info-circle"></li> Please provide a valid file.</small>'
                ).fadeIn();
                $('.' + input + '-invalid').delay(4000);
                $('.' + input + '-invalid').fadeOut();

                return true;
            } else {
                $('.' + input + '-invalid').remove();
                return false;
            }
        } else {
            return false;

        }
    }
</script>