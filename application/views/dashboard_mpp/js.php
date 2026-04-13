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

        $("#periode").datepicker({
            format: "yyyy-mm",
            startView: "months",
            minViewMode: "months",
            autoclose: true,
        });

        $("#dt_karyawan").DataTable();

    });

    slc_company = new SlimSelect({
        select: '#company',
    });

    slc_department = new SlimSelect({
        select: '#department',
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
            success: function(response) {
                slc_department.setData(response);
            }
        });
    });

    $('#department').change(function() {
        company_id = $('#company').val();
        department_id = $(this).val();

        $.ajax({
            url: '<?php echo base_url(); ?>hr/rekap_absen/get_employees',
            type: 'POST',
            dataType: 'json',
            data: {
                company_id: company_id,
                department_id: department_id
            },
            success: function(response) {
                // slc_employee.setData(response);
            }
        });
    });

    function dt_karyawan(contract_type, category_level, level, company_id, department_id) {
        console.log(contract_type, category_level, level, company_id, department_id);
        $('#dt_karyawan').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="bi bi-download text-white"></i>',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    contract_type: contract_type,
                    category_level: category_level,
                    level: level,
                    company_id: company_id,
                    department_id: department_id,
                },
                "url": "<?= base_url(); ?>dashboard_mpp/dt_karyawan",
            },
            "columns": [{
                    "data": "company",
                    // "className": "d-none d-md-table-cell text-left"
                },
                {
                    "data": "full_name",
                },
                {
                    "data": "designation_name",
                },
                {
                    "data": "gender",
                },
                {
                    "data": "marital_status",
                },
                {
                    "data": "date_of_joining",
                },
            ],
        });
    }

    function list_karyawan(contract_type, category_level, level, company_id, department_id) {
        dt_karyawan(contract_type, category_level, level, company_id, department_id);
        $('#modal_list_karyawan').modal('show');
    }
</script>