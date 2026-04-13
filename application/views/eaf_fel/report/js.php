<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>

<!-- view images -->
<!-- <script type="text/javascript" src="<?= base_url('assets/fancybox/jquery.fancybox.min.js') ?>"></script> -->

<!-- slim select js -->

<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>

<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>


<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<link href="<?= base_url(); ?>assets/jquery-timepicker/jquery.timepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/jquery-timepicker/jquery.timepicker.min.js" type="text/javascript"></script>

<!-- Datetimepicker Full -->
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript">
    // var table_ajax;

    $(document).ready(function() {
        id_user = <?= $this->session->userdata('user_id'); ?>;

        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('#reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="datestart"]').val(start.format('YYYY-MM-DD'));
            $('input[name="dateend"]').val(end.format('YYYY-MM-DD'));
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
                    "data": "company_kode",
                    "sortable": true,
                    "render": function(data, type, row, meta) {
                        return data
                    }
                },
                {
                    "data": "nama_biaya",
                    "render": function(data, type, row, meta) {
                        return `<a href="javascript:void(0);" onclick="detailBudget(${row['id_biaya']}, '${year}', '${month}')" class="btn btn-primary btn-sm">${data}</a>`
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
                            return `<span class="badge bg-success">Unlimited</span>`
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
                            return `<span class="badge bg-default">0</span>`
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
                            return `<span class="badge bg-default">0</span>`
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
                            return `<span class="badge bg-default">0</span>`
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
                            return `<span class="badge bg-default">0</span>`
                        } else if (data > 100) {
                            return '<span class="badge bg-danger">' + data + '%</span>'
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
                            return `<span class="badge bg-default">0</span>`
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
                            return `<span class="badge bg-default">0</span>`
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
                            return `<span class="badge bg-default">0</span>`
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
                            return `<span class="badge bg-default">0</span>`
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
                            return `<span class="badge bg-default">0</span>`
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
                            return `<span class="badge bg-default">0</span>`
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
                            return `<span class="badge bg-default">0</span>`
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
                            return `<span class="badge bg-default">0</span>`
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
                            return `<span class="badge bg-default">0</span>`
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
                            return `<span class="badge bg-default">0</span>`
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

                col_20 = api
                    .column(20, {
                        search: 'applied'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                $(api.column(20).footer()).html(
                    formatNumber(col_20)
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
                        return `<a href="javascript:void(0);" onclick="detailBudget(${row['id_biaya']}, '${year}', '${month}')" class="btn btn-primary btn-sm">${data}</a>`
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
                            return `<span class="badge bg-default">0</span>`
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
                            return `<span class="badge bg-default">0</span>`
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
                            return `<span class="badge bg-default">0</span>`
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
                            return `<span class="badge bg-default">0</span>`
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
                            return `<span class="badge bg-default">0</span>`
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
                            return `<span class="badge bg-default">0</span>`
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
                            return `<span class="badge babgdge-default">0</span>`
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
                            return `<span class="badge bg-default">0</span>`
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

    function tabel_list_eaf(start, end) {
        $('#dt_list_eaf').DataTable({
            'destroy': true,
            'lengthChange': false,
            'searching': true,
            'info': true,
            'paging': true,
            "autoWidth": false,
            "dataSrc": "",
            "order": [
                [1, "desc"]
            ],
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                title: "List Approval Finance",
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    datestart: start,
                    dateend: end,
                    status: 'Reject'
                },
                "url": "<?= base_url('eaf/finance/get_list_approval') ?>"
                // "success": function(data) {
                //   console.log(data.data);
                // },
                // "error": function(xhr, error, code) {
                //   console.log(xhr.responseText);
                // }
            },
            "columns": [{
                    "data": "id_pengajuan",
                    "render": function(data, type, row) {

                        if (data.slice(0, 3) == 'EAF') {
                            return `<a href="javascript:void(0)" class="badge bg-primary" onclick="approval('${data}','${row['tgl_input']}','${row['name']}','${row['admin_company_name']}','${row['admin_dept_name']}','${row['admin_desg_name']}','${row['nama_divisi']}','${row['nama_kategori']}','${row['nama_penerima']}')">${data}</a><a target="_blank" href="<?= base_url() ?>eaf/finance/save_pengajuan/${data}/${row['id_kategori']}/${row['flag']}" class="label label-info"><i class="ti-printer"></i></a>`
                        } else {
                            return `<a href="javascript:void(0)" class="badge custom-bg-outline-primary" onclick="approval_lpj('${data}','${row['tgl_input']}','${row['admin_company_name']}','${row['admin_dept_name']}','${row['admin_desg_name']}','${row['name']}','${row['nama_divisi']}','${row['nama_kategori']}','${row['nama_penerima']}')">${data}</a><a target="_blank" href="<?= base_url() ?>eaf/finance/save_pengajuan/${data}/${row['id_kategori']}/${row['flag']}" class="label label-info"><i class="ti-printer"></i></a>`
                        }
                    }
                },
                {
                    "data": "tgl_input"
                },
                {
                    "data": "nama_status",
                    'render': function(data, type, row) {

                        if ((row['temp'] != null || row['temp'] == '') && row['temp'].slice(0, 3) == "LPJ") {
                            return `<span class="${row['warna']}">${data}</span>&nbsp<span class="badge custom-bg-outline-primary">` + row['temp'] + `</span>`
                        } else {
                            return `<span class="${row['warna']}">${data}</span>`
                        }
                    }
                },
                {
                    "data": "nama_penerima"
                },
                {
                    "data": "pengaju"
                },
                {
                    "data": "nama_kategori"
                },
                {
                    "data": "pengaju_comp_name"
                },
                {
                    "data": "pengaju_dept_name"
                },
                {
                    "data": "pengaju_desg_name"
                },
                // Persiapan untuk Edit Blok
                {
                    "data": "nama_keperluan",
                    "render": function(data, type, row) {
                        // if (((row['temp'] != null || row['temp'] == '') && row['temp'].slice(0, 3) == "LPJ") || row['blok'] == ''){
                        return data;
                        // } else {
                        // return `<span class="label label-warning edit_blok" data-id_pengajuan="${row['id_pengajuan']}" style="cursor:pointer;" title="Edit Blok"><i class="fa fa-pencil"></i></span>${data}`;
                        // }
                    }
                },

                // {
                //   "data": "nama_divisi"
                // },
                {
                    "data": "name"
                },
            ]

        });
    }
</script>