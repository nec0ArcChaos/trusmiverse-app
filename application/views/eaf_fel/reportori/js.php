<!-- Required Jquery -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap/js/bootstrap.min.js"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<!-- data-table js -->
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- i18next.min.js -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/advance-elements/moment-with-locales.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- Date-range picker js -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap-daterangepicker/js/daterangepicker.js"></script>
<!-- Datepicker -->
<script src="<?php echo base_url(); ?>assets/datepicker/js/bootstrap-datepicker.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/pcoded.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/demo-12.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/script.js"></script>

<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/dataTables.fixedColumns.min.js"></script>


<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/sweetalert/sweetalert.min.js"></script>

<!-- ckeditor -->
<script src="<?php echo base_url(); ?>assets/pages/ckeditor/ckeditor.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/pages/wysiwyg-editor/wysiwyg-editor.js"></script> -->

<script type="text/javascript" src="<?= base_url('assets/fancybox/jquery.fancybox.min.js') ?>"></script>

<!-- jspdf -->
<script src="<?php echo base_url(); ?>assets/jspdf/jspdf.umd.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jspdf/html2canvas.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jspdf/jspdf.plugin.autotable.js"></script>

<!-- slim select js -->
<script src="<?php echo base_url(); ?>assets/js/slimselect.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('#reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="datestart"]').val(start.format('YYYY-MM-DD'));
            $('input[name="dateend"]').val(end.format('YYYY-MM-DD'));
            // data_report_budget(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        }

        $('#range').daterangepicker({
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

        start = $('#datestart').val();
        end = $('#dateend').val();

        start_now = '<?= date('Y-m-d') ?>';
        end_now = '<?= date('Y-m-d') ?>';

        // datepicker month
        $("#periode").datepicker({
            format: "yyyy-mm",
            viewMode: "year",
            minViewMode: "months",
            autoclose: true,
            orientation: "bottom",
        });

        $('#periode').on('change', function() {
            $('input[name="period"]').attr('value', this.value)
        });
        //  end date picker month

        year = '<?= date('Y') ?>';
        month = '<?= date('m') ?>';

        data_report_budget(year, month);
        data_rb_user(year, month);

        $('#filter_period').on('click', function() {

            period = $('#period').val();
            // untuk export excel berdasarkan filter date
            // $('#datestart').val(datestart);
            // $('#dateend').val(dateend);

            year = period.substr(0, 4);
            month = period.substr(5, 2);

            data_report_budget(year, month);
            data_rb_user(year, month);


        });

        $('#status').on('change', function() {
            if ($(this).val() == '4') {
                $(this).css('border-color', 'green');
                $('#btn_save').removeClass();
                $('#btn_save').addClass('btn btn-success');
                $('#btn_save').text('Approve');
            } else if ($(this).val() == '6') {
                $(this).css('border-color', 'red');
                $('#btn_save').removeClass();
                $('#btn_save').addClass('btn btn-danger');
                $('#btn_save').text('Reject');
            } else if ($(this).val() == '13') {
                $(this).css('border-color', 'orange');
                $('#btn_save').removeClass();
                $('#btn_save').addClass('btn btn-warning');
                $('#btn_save').text('Revisi');
            }
        });

        $('#dt_rb_user').on('click', '.detail_penambahan_biaya', function() {
            console.log('detail penambahan biaya..');
            //dt_list_member.ajax.reload();
            id_biaya = $(this).data('id_biaya');
            sisa_budget = $(this).data('sisa_budget');
            bulan = $(this).data('bulan');
            tahun_budgets = $(this).data('tahun_nih');
            nama_text = $(this).data('nama_biaya');

            if (sisa_budget == null) {
                console.log(`Null yaa`);
                swal({
                    title: "Warning",
                    text: "\nBudget Unlimited, tidak bisa dilakukan penambahan budget\n",
                    icon: "warning",
                    timer: 2000,
                    buttons: false
                });
            } else {
                console.log(`Tidak Null`);
                $('#modal_detail_penambahan').modal('show');
                $('#id_biaya_tam').val(id_biaya);
                //$('#text_nama_biaya').val(nama_biaya);
                document.getElementById("text_nama_biaya").innerHTML = nama_text;
                $('#bulan_tam').val(bulan);
                $('#tahun_tam').val(tahun_budgets);
                $('#nama_biaya_tam').val(nama_text);
                $('#sisa_budget').val(sisa_budget);
                reload_table_penambahan();
            }
        });

    });

    function formatNumber(num) {
        if (num == null) {
            return 0;
        } else {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        }
    }

    function data_report_budget(year, month) {
        $('#dt_report_budget').DataTable({
            'destroy': true,
            'lengthChange': false,
            'searching': true,
            'info': true,
            'paging': true,
            "autoWidth": false,
            "dataSrc": "",
            "order": [
                [0, "asc"]
            ],
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                title: "Rekap Budget",
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    year: year,
                    month: month
                },
                "url": "<?= base_url('eaf/report/data_report_budget') ?>"
                // "success": function(data) {
                //   console.log(data.data);
                // },
                // "error": function(xhr, error, code) {
                //   console.log(xhr.responseText);
                // }
            },
            "columns": [{
                    "data": "id_budget",
                    "sortable": true,
                    "render": function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "data": "nama_biaya",
                    "render": function(data, type, row, meta) {
                        return `<a href="javascript:void(0);" onclick="detailBudget(${row['id_biaya']}, '${year}', '${month}')" class="label label-primary">${data}</a>`
                    }
                },
                {
                    "data": "user",
                    classname: 'text-center'
                },
                {
                    "data": "minggu",
                    classname: 'text-center'
                },
                {
                    "data": "budget_awal",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge badge-success">Unlimited</span>`
                        } else {
                            return 'Rp. ' + formatNumber(data)
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "nominal_tambah",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge badge-default">0</span>`
                        } else {
                            return 'Rp. ' + formatNumber(data)
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "actual_m0",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge badge-default">0</span>`
                        } else {
                            return 'Rp. ' + formatNumber(data)
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "act_budget",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge badge-default">0</span>`
                        } else {
                            return 'Rp. ' + formatNumber(data)
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "presentase",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge badge-default">0</span>`
                        } else if (data > 100) {
                            return '<span class="badge badge-danger">' + data + '%</span>'
                        } else {
                            return formatNumber(data) + '%'
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "sudah_lpj",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge badge-default">0</span>`
                        } else {
                            return 'Rp. ' + formatNumber(data)
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "belum_lpj",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge badge-default">0</span>`
                        } else {
                            return 'Rp. ' + formatNumber(data)
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "rembers",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge badge-default">0</span>`
                        } else {
                            return 'Rp. ' + formatNumber(data)
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "sisa",
                    "render": function(data, type) {
                        if (data == null || data < 0) {
                            return `<span class="badge badge-default">0</span>`
                        } else {
                            return 'Rp. ' + formatNumber(data)
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "total_over_budget",
                    "render": function(data, type) {
                        if (data == null || data < 0) {
                            return `<span class="badge badge-default">0</span>`
                        } else {
                            return 'Rp. ' + formatNumber(data)
                        }
                    },
                    className: 'text-right'
                }
            ],
            "initComplete": function(settings, json) {

                // Total budget
                budget_awal = 0;
                for (i = 0; i < json.data.length; i++) {
                    if (json.data[i].budget_awal == null) {
                        json.data[i].budget_awal = 0;
                    }
                    budget_awal += parseInt(json.data[i].budget_awal)
                }

                $('#total_budget').text('Rp. ' + formatNumber(budget_awal));

                // Total penambahan
                nominal_tambah = 0;
                for (i = 0; i < json.data.length; i++) {
                    if (json.data[i].nominal_tambah == null) {
                        json.data[i].nominal_tambah = 0;
                    }
                    nominal_tambah += parseInt(json.data[i].nominal_tambah)
                }

                $('#total_penambahan').text('Rp. ' + formatNumber(nominal_tambah));

                // Total act_budget
                act_budget = 0;
                for (i = 0; i < json.data.length; i++) {
                    if (json.data[i].act_budget == null) {
                        json.data[i].act_budget = 0;
                    }
                    act_budget += parseInt(json.data[i].act_budget)
                }

                $('#total_act_budget').text('Rp. ' + formatNumber(act_budget));

                sudah_lpj = 0;
                for (i = 0; i < json.data.length; i++) {
                    if (json.data[i].sudah_lpj == null) {
                        json.data[i].sudah_lpj = 0;
                    }
                    sudah_lpj += parseInt(json.data[i].sudah_lpj)
                }

                $('#total_sudah_lpj').text('Rp. ' + formatNumber(sudah_lpj));

                belum_lpj = 0;
                for (i = 0; i < json.data.length; i++) {
                    if (json.data[i].belum_lpj == null) {
                        json.data[i].belum_lpj = 0;
                    }
                    belum_lpj += parseInt(json.data[i].belum_lpj)
                }

                $('#total_belum_lpj').text('Rp. ' + formatNumber(belum_lpj));

                rembers = 0;
                for (i = 0; i < json.data.length; i++) {
                    if (json.data[i].rembers == null) {
                        json.data[i].rembers = 0;
                    }
                    rembers += parseInt(json.data[i].rembers)
                }

                $('#total_reimburse').text('Rp. ' + formatNumber(rembers));

                actual_m0 = 0;
                for (i = 0; i < json.data.length; i++) {
                    if (json.data[i].actual_m0 == null) {
                        json.data[i].actual_m0 = 0;
                    }
                    actual_m0 += parseInt(json.data[i].actual_m0)
                }

                $('#total_pengeluaran').text('Rp. ' + formatNumber(actual_m0));

                // actual_m1 = 0;
                // for (i = 0; i < json.data.length; i++) {
                //   if (json.data[i].actual_m1 == null) {
                //     json.data[i].actual_m1 = 0;
                //   }
                //   actual_m1 += parseInt(json.data[i].actual_m1)
                // }

                // $('#total_budget_m1').text('Rp. ' + formatNumber(actual_m1));

                // actual_m2 = 0;
                // for (i = 0; i < json.data.length; i++) {
                //   if (json.data[i].actual_m2 == null) {
                //     json.data[i].actual_m2 = 0;
                //   }
                //   actual_m2 += parseInt(json.data[i].actual_m2)
                // }

                // $('#total_budget_m2').text('Rp. ' + formatNumber(actual_m2));

                // actual_m3 = 0;
                // for (i = 0; i < json.data.length; i++) {
                //   if (json.data[i].actual_m3 == null) {
                //     json.data[i].actual_m3 = 0;
                //   }
                //   actual_m3 += parseInt(json.data[i].actual_m3)
                // }

                // $('#total_budget_m3').text('Rp. ' + formatNumber(actual_m3));

                sisa = 0;
                for (i = 0; i < json.data.length; i++) {
                    if (json.data[i].sisa == null) {
                        json.data[i].sisa = 0;
                    }
                    sisa += parseInt(json.data[i].sisa)
                }

                if (json.data[0] == undefined) {
                    total_over_budget = 0
                } else {
                    total_over_budget = Math.abs(json.data[0].total_over_budget) || 0
                }

                $('#total_sisa_budget').text('Rp. ' + formatNumber(sisa));

                $('#total_over_budget').text('Rp. ' + formatNumber(total_over_budget));
            }

        });
    }

    //   detail budget

    function detailBudget(id_biaya, y, m) {
        $('#modal_detail_budget').modal('show');
        $('#dt_detail_budget').DataTable({
            'destroy': true,
            'lengthChange': false,
            'searching': true,
            'info': true,
            'paging': true,
            "autoWidth": false,
            "order": [
                [0, "asc"]
            ],
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                title: "Detail Budget",
                footer: true,
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    $('row:first c', sheet).attr('s', '2');
                }
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                'data': {
                    id_biaya: id_biaya,
                    year: y,
                    month: m,
                },
                "url": "<?php echo site_url(); ?>eaf/report/detail_budget",
            },
            "columns": [{
                    "data": "id_pengajuan"
                },
                {
                    "data": "username"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "tgl_approve"
                },
                {
                    "data": "nama_penerima"
                },
                {
                    "data": "pengaju"
                },
                {
                    "data": "department"
                },
                {
                    "data": "nama_kategori"
                },
                {
                    "data": "nama_tipe"
                },
                {
                    "data": "nominal_uang",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge badge-default">0</span>`
                        } else {
                            // return 'Rp. ' + formatNumber(data)
                            return data;
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "keperluan"
                },
                {
                    "data": "budget"
                },
                {
                    "data": "note_user"
                },
                {
                    "data": "note_fnc"
                },
                {
                    "data": "nama_status"
                },
                {
                    "data": "status_lpj"
                },
                {
                    "data": "tanggal_lpj"
                },
                {
                    "data": "nominal_lpj",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge badge-default">0</span>`
                        } else {
                            // return 'Rp. ' + formatNumber(data)
                            return data;
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "deviasi",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge badge-default">0</span>`
                        } else {
                            // return 'Rp. ' + formatNumber(data)
                            return data;
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "cash_out",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge badge-default">0</span>`
                        } else {
                            // return 'Rp. ' + formatNumber(data)
                            return data;
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "actual_budget",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge badge-default">0</span>`
                        } else {
                            // return 'Rp. ' + formatNumber(data)
                            return data;
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "approval_lpj"
                },
            ],
            'footerCallback': function(row, data, start, end, display) {
                var api = this.api(),
                    data;

                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\Rp.]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                col_9 = api
                    .column(9, {
                        search: 'applied'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                $(api.column(9).footer()).html(
                    formatNumber(col_9)
                );

                col_16 = api
                    .column(16, {
                        search: 'applied'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                $(api.column(16).footer()).html(
                    formatNumber(col_16)
                );

                col_17 = api
                    .column(17, {
                        search: 'applied'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                $(api.column(17).footer()).html(
                    formatNumber(col_17)
                );

                col_18 = api
                    .column(18, {
                        search: 'applied'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                $(api.column(18).footer()).html(
                    formatNumber(col_18)
                );

                col_19 = api
                    .column(19, {
                        search: 'applied'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                $(api.column(19).footer()).html(
                    formatNumber(col_19)
                );

            },
        });
    }

    function data_rb_user(year, month, id_user) {
        $('#dt_rb_user').DataTable({
            'destroy': true,
            'lengthChange': false,
            'searching': true,
            'info': true,
            'paging': true,
            "autoWidth": false,
            "dataSrc": "",
            "order": [
                [0, "asc"]
            ],
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                title: "Rekap Budget",
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    year: year,
                    month: month,
                    id_user: id_user
                },
                "url": "<?= base_url('eaf/report/data_rb_user') ?>"
                // "success": function(data) {
                //   console.log(data.data);
                // },
                // "error": function(xhr, error, code) {
                //   console.log(xhr.responseText);
                // }
            },
            "columns": [{
                    "data": "id_budget",
                    "sortable": true,
                    "render": function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "data": "nama_biaya",
                    "render": function(data, type, row, meta) {
                        return `<a href="javascript:void(0);" onclick="detailBudget(${row['id_biaya']}, '${year}', '${month}')" class="label label-primary">${data}</a>`
                    }
                },
                // {
                // 	"data": "user",
                // 	classname: 'text-center'
                // },
                {
                    "data": "minggu",
                    classname: 'text-center'
                },
                {
                    "data": "budget_awal",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge badge-default">0</span>`
                        } else {
                            return 'Rp. ' + formatNumber(data)
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "nominal_tambah",
                    "render": function(data, type, row) {
                        if (data == null) {
                            return `<span class="badge badge-default">0</span>`
                            // add by Ade
                        } else if (data == 0) {
                            return 'Rp. ' + formatNumber(data)
                        } else {
                            // edit by Ade
                            return '<a href="javascript:void(0)" class="label label-success detail_penambahan_biaya" data-id_biaya="' + row['id_biaya'] + '" data-sisa_budget="' + row['sisa'] + '" data-bulan="' + month + '" data-tahun_nih="' + year + '" data-nama_biaya="' + row['nama_biaya'] + '">Rp. ' + formatNumber(data) + '</a>';
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "actual_m0",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge badge-default">0</span>`
                        } else {
                            return 'Rp. ' + formatNumber(data)
                        }
                    },
                    className: 'text-right'
                },
                // 	{
                // 		"data": "act_budget",
                // 		"render": function(data, type) {
                // 			if (data == null) {
                // 				return `<span class="badge badge-default">0</span>`
                // 			} else {
                // 				return 'Rp. ' + formatNumber(data)
                // 			}
                // 		},
                // 		className: 'text-right'
                // 	},
                // 	{
                // 		"data": "presentase",
                // 		"render": function(data, type) {
                // 			if (data == null) {
                // 				return `<span class="badge badge-default">0</span>`
                // 			}
                // else if(data>100){
                //   return '<span class="badge badge-danger">'+data+'%</span>'
                // } else {
                // 				return formatNumber(data) + '%'
                // 			}
                // 		},
                // 		className: 'text-right'
                // 	},
                {
                    "data": "sudah_lpj",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge badge-default">0</span>`
                        } else {
                            return 'Rp. ' + formatNumber(data)
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "belum_lpj",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge badge-default">0</span>`
                        } else {
                            return 'Rp. ' + formatNumber(data)
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "rembers",
                    "render": function(data, type) {
                        if (data == null) {
                            return `<span class="badge badge-default">0</span>`
                        } else {
                            return 'Rp. ' + formatNumber(data)
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "sisa",
                    "render": function(data, type) {
                        if (data == null || data < 0) {
                            return `<span class="badge badge-default">0</span>`
                        } else {
                            return 'Rp. ' + formatNumber(data)
                        }
                    },
                    className: 'text-right'
                },
                {
                    "data": "total_over_budget",
                    "render": function(data, type) {
                        if (data == null || data < 0) {
                            return `<span class="badge badge-default">0</span>`
                        } else {
                            return 'Rp. ' + formatNumber(data)
                        }
                    },
                    className: 'text-right'
                }
            ],
            "initComplete": function(settings, json) {

                // Total budget
                budget_awal = 0;
                for (i = 0; i < json.data.length; i++) {
                    if (json.data[i].budget_awal == null) {
                        json.data[i].budget_awal = 0;
                    }
                    budget_awal += parseInt(json.data[i].budget_awal)
                }

                $('#total_budget').text('Rp. ' + formatNumber(budget_awal));

                // Total penambahan
                nominal_tambah = 0;
                for (i = 0; i < json.data.length; i++) {
                    if (json.data[i].nominal_tambah == null) {
                        json.data[i].nominal_tambah = 0;
                    }
                    nominal_tambah += parseInt(json.data[i].nominal_tambah)
                }

                $('#total_penambahan').text('Rp. ' + formatNumber(nominal_tambah));

                // Total act_budget
                act_budget = 0;
                for (i = 0; i < json.data.length; i++) {
                    if (json.data[i].act_budget == null) {
                        json.data[i].act_budget = 0;
                    }
                    act_budget += parseInt(json.data[i].act_budget)
                }

                $('#total_act_budget').text('Rp. ' + formatNumber(act_budget));

                sudah_lpj = 0;
                for (i = 0; i < json.data.length; i++) {
                    if (json.data[i].sudah_lpj == null) {
                        json.data[i].sudah_lpj = 0;
                    }
                    sudah_lpj += parseInt(json.data[i].sudah_lpj)
                }

                $('#total_sudah_lpj').text('Rp. ' + formatNumber(sudah_lpj));

                belum_lpj = 0;
                for (i = 0; i < json.data.length; i++) {
                    if (json.data[i].belum_lpj == null) {
                        json.data[i].belum_lpj = 0;
                    }
                    belum_lpj += parseInt(json.data[i].belum_lpj)
                }

                $('#total_belum_lpj').text('Rp. ' + formatNumber(belum_lpj));

                rembers = 0;
                for (i = 0; i < json.data.length; i++) {
                    if (json.data[i].rembers == null) {
                        json.data[i].rembers = 0;
                    }
                    rembers += parseInt(json.data[i].rembers)
                }

                $('#total_reimburse').text('Rp. ' + formatNumber(rembers));

                actual_m0 = 0;
                for (i = 0; i < json.data.length; i++) {
                    if (json.data[i].actual_m0 == null) {
                        json.data[i].actual_m0 = 0;
                    }
                    actual_m0 += parseInt(json.data[i].actual_m0)
                }

                $('#total_pengeluaran').text('Rp. ' + formatNumber(actual_m0));

                // actual_m1 = 0;
                // for (i = 0; i < json.data.length; i++) {
                //   if (json.data[i].actual_m1 == null) {
                //     json.data[i].actual_m1 = 0;
                //   }
                //   actual_m1 += parseInt(json.data[i].actual_m1)
                // }

                // $('#total_budget_m1').text('Rp. ' + formatNumber(actual_m1));

                // actual_m2 = 0;
                // for (i = 0; i < json.data.length; i++) {
                //   if (json.data[i].actual_m2 == null) {
                //     json.data[i].actual_m2 = 0;
                //   }
                //   actual_m2 += parseInt(json.data[i].actual_m2)
                // }

                // $('#total_budget_m2').text('Rp. ' + formatNumber(actual_m2));

                // actual_m3 = 0;
                // for (i = 0; i < json.data.length; i++) {
                //   if (json.data[i].actual_m3 == null) {
                //     json.data[i].actual_m3 = 0;
                //   }
                //   actual_m3 += parseInt(json.data[i].actual_m3)
                // }

                // $('#total_budget_m3').text('Rp. ' + formatNumber(actual_m3));

                sisa = 0;
                for (i = 0; i < json.data.length; i++) {
                    if (json.data[i].sisa == null) {
                        json.data[i].sisa = 0;
                    }
                    sisa += parseInt(json.data[i].sisa)
                }

                if (json.data[0] == undefined) {
                    total_over_budget = 0
                } else {
                    total_over_budget = Math.abs(json.data[0].total_over_budget) || 0
                }

                $('#total_sisa_budget').text('Rp. ' + formatNumber(sisa));

                $('#total_over_budget').text('Rp. ' + formatNumber(total_over_budget));
            }

        });
    }

    function reload_table_penambahan() {
        id_biayaa_s = $("#id_biaya_tam").val();
        //id_biaya_tam = $('#id_biaya_tam').val();
        sisa_budget_s = $('#sisa_budget').val();
        minggu_s = $('#minggu_tam').val();
        bulan_s = $('#bulan_tam').val();
        tahun_s = $('#tahun_tam').val();

        url_2 = "<?php echo site_url(); ?>eaf/budget/data_budget_tambah";
        $('#dt_list_penambahan').DataTable({
            'destroy': true,
            'lengthChange': false,
            'searching': true,
            'info': true,
            'paging': true,
            "autoWidth": false,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": url_2,
                "data": {
                    id_biayaa_s: id_biayaa_s,
                    sisa_budget_s: sisa_budget_s,
                    minggu_s: minggu_s,
                    bulan_s: bulan_s,
                    tahun_s: tahun_s
                }
            },
            "columns": [{
                    "data": "nominal_tambah",
                    'render': $.fn.dataTable.render.number('.', ',', 0, 'Rp ')
                },
                {
                    "data": "bulan"
                },
                {
                    "data": "tahun"
                },
                {
                    "data": "updated_at"
                },
                {
                    "data": "employee_name"
                },
                {
                    "data": "note_penambahan"
                },
                {
                    "data": "ba",
                    "render": function(data, type, row) {
                        return '<a href="<?= base_url() ?>assets/uploads/eaf/' + data + '" class="label label-success penambahan_biaya">' + data + '</a>'
                    }
                }
            ]
        });
    }
</script>