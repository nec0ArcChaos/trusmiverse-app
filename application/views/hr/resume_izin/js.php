<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
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

        resume_izin($('#company').val(), $('#department').val(), $('#employee').val(), $('#start').val(), $('#end').val());

        
    });

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
            url: '<?php echo base_url(); ?>hr/resume_izin/get_department',
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
            url: '<?php echo base_url(); ?>hr/resume_izin/get_employees',
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

    $('#btn_filter').click(function() {
        resume_izin($('#company').val(), $('#department').val(), $('#employee').val(), $('#start').val(), $('#end').val());
    });

    function wordWrap(str, maxWidth) {
        var newLineStr = "<br>"; done = false; res = '';
        while (str.length > maxWidth) {                 
            found = false;
            // Inserts new line at first whitespace of the line
            for (i = maxWidth - 1; i >= 0; i--) {
                if (testWhite(str.charAt(i))) {
                    res = res + [str.slice(0, i), newLineStr].join('');
                    str = str.slice(i + 1);
                    found = true;
                    break;
                }
            }
            // Inserts new line at maxWidth position, the word is too long to wrap
            if (!found) {
                res += [str.slice(0, maxWidth), newLineStr].join('');
                str = str.slice(maxWidth);
            }

        }

        return res + str;
    }

    function testWhite(x) {
        var white = new RegExp(/^\s$/);
        return white.test(x.charAt(0));
    };

    function resume_izin(company_id, department_id, employee_id, start, end) {
        $('#dt_resume_izin').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            // "responsive": true,
            "dom": 'Bfrtip',
            "order": [
                [0, 'asc']
                ],
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    company_id      : company_id,
                    department_id   : department_id,
                    employee_id     : employee_id,
                    start           : start,
                    end             : end
                },
                "url": "<?php echo base_url() ?>hr/resume_izin/get_resume_izin",
            },
            "columns": [
            {
                "data": "leave_type",
            },
            {
                "data": "reason",
                "render": function (data) {
                    return wordWrap(data, 40);
                }
            },
            {
                "data": "remarks",
                "render": function (data) {
                    return wordWrap(data, 40);
                }
            },
            {
                "data": "status",
                "render": function (data, type, row) {
                    if (data == "Pending") {
                        return '<span class="btn btn-warning btn-sm" style="color: white;">'+data+'</span>';
                    } else if (data == "Approve") {
                        return '<span class="btn btn-success btn-sm" style="color: white;">'+data+'</span>';
                    } else if (data == "Reject") {
                        return '<span class="btn btn-danger btn-sm" style="color: white;">'+data+'</span>';
                    }
                },
            },
            {
                "data": "attachment",
                "render": function (data) {
                    return `<a data-fancybox="gallery" href="http://trusmiverse.com/hr/uploads/leave/${data}"><span class="btn btn-info btn-sm"><i class="bi bi-card-image" style="color: white;"></i></span></a>`;
                },
            },
            {
                "data": "employee",
            },
            {
                "data": "department",
            },
            {
                "data": "company",
            },
            {
                "data": "request_duration",
            },
            {
                "data": "total",
            },
            {
                "data": "applied_on",
            },
            {
                "data": "approved_at",
            },
            {
                "data": "approved",
            },
            {
                "data": "verified_at",
            },
            {
                "data": "verified",
            },
            ],
        });
    }
</script>