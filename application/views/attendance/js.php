<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>


<script>
    $(document).ready(function() {

        //Datepicker
        // var start = moment().startOf('month');
        // var end = moment().endOf('month');
        var start = moment();
        var end = moment();

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

        slc_company = new SlimSelect({
            select: '#company',
        });

        slc_department = new SlimSelect({
            select: '#department',
        });

        slc_employee = new SlimSelect({
            select: '#employee',
        });

        $('#company').change(function() {
            company_id = $(this).val();

            $.ajax({
                url: '<?php echo base_url(); ?>hr/rekap_absen/get_department',
                type: 'POST',
                dataType: 'json',
                data: {
                    company_id: company_id
                },
                success: function (response) {
                    slc_department.setData(response);
                    slc_employee.setData([{text: 'All Employees', value: '0'}])
                }
            });
        });

        $('#department').change(function() {
            company_id      = $('#company').val();
            department_id   = $(this).val();

            $.ajax({
                url: '<?php echo base_url(); ?>hr/rekap_absen/get_employees',
                type: 'POST',
                dataType: 'json',
                data: {
                    company_id: company_id,
                    department_id: department_id
                },
                success: function (response) {
                    slc_employee.setData(response);
                }
            });
        });

        // $("#periode").datepicker( {
        //     format: "yyyy-mm",
        //     startView: "months", 
        //     minViewMode: "months",
        //     autoclose: true,
        // });

        filter_attendance();

    }); // END :: Ready Function


    function filter_attendance(){
        company = $('#company :selected').val();
        department = $('#department :selected').val();
        employee = $('#employee :selected').val();
        start = $('#start').val();
        end = $('#end').val();

        dt_attendance(company, department, employee, start, end);
        dt_pembatalan_absensi(company, department, employee, start, end);
    }


    function dt_attendance(company_id, department_id, employee_id, start, $end) {
        $('#dt_attendance').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                // [0, 'asc'],
                [1, 'asc']
            ],
            responsive: true,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "url": "<?= base_url(); ?>attendance/dt_attendance",
                "type": "POST",
                "dataType": 'json',
                "data" :{
                    company_id: company_id,
                    department_id: department_id,
                    employee_id: employee_id,
                    start: start,
                    end: end,
                },
            },
            "columns": [
                
                {
                    'data': 'time_attendance_id',
                    'render': function(data, type, row) {
                        if (<?= $this->session->userdata('user_id') ?> == 8446 || <?= $this->session->userdata('user_id') ?> == 7477 || <?= $this->session->userdata('user_id') ?> == 118) {
                            return ''
                        }
                        return `<a href="javascript:void(0);" onclick="batalkan_absen(${data}, '${row['username']}')">
                                    <span class="badge bg-danger">
                                        <i class="bi bi-trash"></i>
                                    </span>
                                </a>`
                    }
                },
                {
                    'data': 'attendance_date'
                },
                {
                    'data': 'username'
                },
                {
                    'data': 'designation_name'
                },
                {
                    'data': 'clock_in',
                    'className': 'text-center'
                },
                {
                    'data': 'clock_in',
                    'render': function(data, type, row) {
                        clok_in = data || ''
                        foto = row['photo_in']
                        if (foto != null) {
                            foto_absen = `<a data-fancybox="gallery" href="https://trusmiverse.com/hr_upload/${foto}"><img src="https://trusmiverse.com/hr_upload/${foto}" class="img-radius" alt="User-Profile-Image" width="30px"></a>`
                        } else {
                            foto_absen = ''
                        }

                        
                        return `${foto_absen}`

                    },
                    'className': 'text-center'
                },
                {
                    'data': 'clock_out',
                    'className': 'text-center'
                },
                {
                    'data': 'clock_out',
                    'render': function(data, type, row) {
                        foto = row['photo_out']
                        if (foto != null) {
                            foto_absen = `<a data-fancybox="gallery" href="https://trusmiverse.com/hr_upload/${foto}"><img src="https://trusmiverse.com/hr_upload/${foto}" class="img-radius" alt="User-Profile-Image" width="30px"></a>`
                        } else {
                            foto_absen = ''
                        }

                        
                        return `${foto_absen}`
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'late',
                    render: function(data, type, row) {
                        if (data > '00:01') {
                            if (<?php echo $this->session->userdata('user_id'); ?> == 7477) {
                                return ``
                            } else {
                                return `<span class="label label-danger">${(data.substring(0, 5))}</span>`
                            }
                        } else {
                            return ``
                        }
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'total_work',
                    'className': 'text-center'
                },

            ],
        });
    }
    
    
    function dt_pembatalan_absensi(company_id, department_id, employee_id, start, $end) {
        $('#dt_pembatalan_absensi').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                // [0, 'asc'],
                [1, 'asc']
            ],
            responsive: true,
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "url": "<?= base_url(); ?>attendance/dt_pembatalan_absensi",
                "type": "POST",
                "dataType": 'json',
                "data" :{
                    company_id: company_id,
                    department_id: department_id,
                    employee_id: employee_id,
                    start: start,
                    end: end,
                },
            },
            "columns": [
                
                {
                    'data': 'attendance_date',
                },
                {
                    'data': 'username'
                },
                {
                    'data': 'designation_name'
                },
                {
                    'data': 'clock_in',
                    'render': function(data, type, row) {
                        clok_in = data || ''
                        foto = row['photo_in']
                        if (foto != null) {
                            foto_absen = `<a data-fancybox="gallery" href="https://trusmiverse.com/hr_upload/${foto}"><img src="https://trusmiverse.com/hr_upload/${foto}" class="img-radius" alt="User-Profile-Image" width="30px"></a>`
                        } else {
                            foto_absen = ''
                        }

                        if (<?php echo $this->session->userdata('user_id'); ?> == 7477) {
                            return `${clok_in}`
                        } else {
                            return `${clok_in} | ${foto_absen}`
                        }
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'clock_out',
                    'render': function(data, type, row) {
                        clok_out = data || ''
                        foto = row['photo_out']
                        if (foto != null) {
                            foto_absen = `<a data-fancybox="gallery" href="https://trusmiverse.com/hr_upload/${foto}"><img src="https://trusmiverse.com/hr_upload/${foto}" class="img-radius" alt="User-Profile-Image" width="30px"></a>`
                        } else {
                            foto_absen = ''
                        }

                        if (<?php echo $this->session->userdata('user_id'); ?> == 7477) {
                            return `${clok_out}`
                        } else {
                            return `${clok_out} | ${foto_absen}`
                        }
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'late',
                    render: function(data, type, row) {
                        if (data > '00:01') {
                            return `<span class="label label-danger">${(data.substring(0, 5))}</span>`
                        } else {
                            return ``
                        }
                    },
                    'className': 'text-center'
                },
                {
                    'data': 'total_work',
                    'className': 'text-center'
                },
                {
                    'data': 'tgl_hapus'
                },
                {
                    'data': 'user_hapus'
                },

            ],
        });
    }


    function batalkan_absen(time_attendance_id, username){
        console.info(time_attendance_id);
        console.info(username);
        $('#nama_hapus').html(username);
        $('#time_attendance_id').val(time_attendance_id);
        $('#modalConfirm').modal('show');
    }


    function hapus_absen(){
        time_attendance_id = $('#time_attendance_id').val();

        $.ajax({
            'url': "<?= site_url('attendance/hapus_absen') ?>",
            'type': 'POST',
            'data': {
                time_attendance_id: time_attendance_id
            },
            'success': function(response) {
                $('#modalConfirm').modal('hide');
                success_alert('Berhasil menghapus absen!');
                filter_attendance();
            }
        });
    }

    // NOTIFY
    function success_alert(text) {
        textMsg = text == null ? '' : text;
        new PNotify({
            title: `Success`,
            text: `${textMsg}`,
            icon: 'icofont icofont-checked',
            type: 'success',
            delay: 1500,
        });
    }

    function error_alert(text) {
        new PNotify({
            title: `Oopss`,
            text: `${text}`,
            icon: 'icofont icofont-info-circle',
            type: 'error',
            delay: 1500,
        });
    }

</script>