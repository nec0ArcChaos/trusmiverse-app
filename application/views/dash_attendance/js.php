<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
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

<script type="text/javascript">
    const baseUrl = "<?= base_url('Dash_attendance') ?>"

    $(document).ready(function() {

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


        dt_dash_attendance_all('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>');
        dt_dash_attendance_dept('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>');


        $('#btn_filter').on('click', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            dt_dash_attendance_all(start, end)
            dt_dash_attendance_dept(start, end)

        });

        $('.range').on('change', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            dt_dash_attendance_all(start, end)
            dt_dash_attendance_dept(start, end)
        })


    });

    function dt_dash_attendance_all(start, end) {
        $('#dt_dash_attendance_all').dataTable({
            "bDestroy": true,
            "ajax": {
                url: `${baseUrl}/dt_dash_attendance_all`,
                type: 'POST',
                data: {
                    start,
                    end
                }
            },
            dom: 'lBfrtip',
            "buttons": ['csv', 'excel', 'pdf'],
            "lengthChange": false,
            "columns": [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: "company",
                    render: function(data, type, row, meta) {
                        let start = $('input[name="startdate"]').val();
                        let end = $('input[name="enddate"]').val();
                        return `<a class="detail_company badge badge-success" style="background-color: #0177bc;" 
								data-company_id="${row['company_id']}" 
								data-startdate="${start}"
								data-enddate="${end}"
								href="javascript:void(0)">
                                ${data}
							</a>`
                    }
                },
                {
                    data: "jumlah",
                    render: function(data, type, row, meta) {
                        if (data > 0) {
                            return `<span class="text-center badge badge-success" style="background-color: #1b945a;">${data}</span>`
                        } else {
                            return ``
                        }
                    }
                },
                {
                    data: "employee"
                },
                {
                    data: "persen",
                    render: function(data, type, row, meta) {
                        if (data > 0) {
                            return `<span class="text-center badge badge-success" style="background-color: #e65100a1;">${data} %</span>`
                        } else {
                            return ``
                        }
                    }
                }
            ],
            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        })
    }


    $('#dt_dash_attendance_all').on('click', '.detail_company', function() {
        $('#modal_detail').modal('show');

        company_id = $(this).data('company_id');
        startdate = $(this).data('startdate');
        enddate = $(this).data('enddate');



        $('#dt_detail_company').dataTable({
            "bDestroy": true,
            "ajax": {
                url: `${baseUrl}/dt_detail_attendance`,
                type: 'POST',
                data: {
                    start: startdate,
                    end: enddate,
                    company_id: company_id
                }
            },
            dom: 'lBfrtip',
            "buttons": ['csv', 'excel', 'pdf'],
            "lengthChange": false,
            "columns": [{
                    data: "attendance_date"
                },
                {
                    data: "attendance_date",
                    render: function(data, type, row) {
                        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                        const date = new Date(data);
                        const dayName = days[date.getDay()];
                        return dayName;
                    }
                },
                {
                    data: "username"
                },
                {
                    data: "department_name"
                },
                {
                    data: "designation_name"
                },
                {
                    data: "clock_in"
                },
                {
                    data: "shift_in"
                },
                {
                    data: "clock_out"
                },
                {
                    data: "shift_out"
                },
                {
                    data: "break_out"
                },
                {
                    data: "break_in"
                },
                {
                    data: "total_break"
                },
                {
                    data: "late",
                    render: function(data, type, row) {
                        if (data > '00:01') {
                            return data.substring(0, 5); // ambil format hh:mm
                        } else {
                            return '';
                        }
                    }
                },
                {
                    data: "total_work"
                }
            ],
            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    });



    function dt_dash_attendance_dept(start, end) {
        $('#dt_dash_attendance_dept').dataTable({
            "bDestroy": true,
            "ajax": {
                url: `${baseUrl}/dt_dash_attendance_dept`,
                type: 'POST',
                data: {
                    start,
                    end
                }
            },
            dom: 'lBfrtip',
            "buttons": ['csv', 'excel', 'pdf'],
            "lengthChange": false,
            "columns": [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: "department",
                    render: function(data, type, row, meta) {
                        let start = $('input[name="startdate"]').val();
                        let end = $('input[name="enddate"]').val();
                        return `<a class="detail_department badge badge-success" style="background-color: #0177bc;" 
								data-department_id="${row['department_id']}" 
								data-startdate="${start}"
								data-enddate="${end}"
								href="javascript:void(0)">
                                ${data}
							</a>`
                    }
                },
                {
                    data: "company",

                },
                {
                    data: "jumlah",
                    render: function(data, type, row, meta) {
                        if (data > 0) {
                            return `<span class="text-center badge badge-success" style="background-color: #1b945a;">${data}</span>`
                        } else {
                            return ``
                        }
                    }
                },
                {
                    data: "employee"
                },
                {
                    data: "persen",
                    render: function(data, type, row, meta) {
                        if (data > 0) {
                            return `<span class="text-center badge badge-success" style="background-color: #e65100a1;">${data} %</span>`
                        } else {
                            return ``
                        }
                    }
                }
            ],
            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        })
    }

    $('#dt_dash_attendance_dept').on('click', '.detail_department', function() {
        $('#modal_detail_dept').modal('show');

        department_id = $(this).data('department_id');
        startdate = $(this).data('startdate');
        enddate = $(this).data('enddate');



        $('#dt_detail_dept').dataTable({
            "bDestroy": true,
            "ajax": {
                url: `${baseUrl}/dt_detail_dept`,
                type: 'POST',
                data: {
                    start: startdate,
                    end: enddate,
                    department_id: department_id
                }
            },
            dom: 'lBfrtip',
            "buttons": ['csv', 'excel', 'pdf'],
            "lengthChange": false,
            "columns": [{
                    data: "attendance_date"
                },
                {
                    data: "attendance_date",
                    render: function(data, type, row) {
                        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                        const date = new Date(data);
                        const dayName = days[date.getDay()];
                        return dayName;
                    }
                },
                {
                    data: "username"
                },
                {
                    data: "designation_name"
                },
                {
                    data: "clock_in"
                },
                {
                    data: "clock_out"
                },
                {
                    data: "late",
                    render: function(data, type, row) {
                        if (data > '00:01') {
                            return data.substring(0, 5); // ambil format hh:mm
                        } else {
                            return '';
                        }
                    }
                },
                {
                    data: "total_work"
                }
            ],
            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    });
</script>