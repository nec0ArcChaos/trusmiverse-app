<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>



<script>
    $(document).ready(function() {

        $("#periode").datepicker({
            format: "yyyy-mm",
            startView: "months",
            minViewMode: "months",
            autoclose: true,
        });

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

    // addnew
    slc_cutoff = new SlimSelect({
        select: '#cutoff',
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
                slc_employee.setData([{
                    text: 'All Employees',
                    value: '0'
                }])
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
                slc_employee.setData(response);
            }
        });
    });

    $('#btn_filter').click(function() {
        rekap_data();

    });

    function rekap_data() {
        company_id = $('#company').val();
        department_id = $('#department').val();
        employee_id = $('#employee').val();
        periode = $('#periode').val();
        cutoff = $('#cutoff').val(); // addnew

        $('#table_rekap_absen').empty().append('<div class="row"><div class="col-12 text-center"><div class="spinner-border text-primary mt-3" role="status"><span class="visually-hidden">Loading...</span></div><h4>Loading</h4></div></div>');

        $.ajax({
            url: '<?php echo base_url(); ?>hr/rekap_absen/get_rekap_absen_resume',
            type: 'POST',
            dataType: 'html',
            data: {
                company_id: company_id,
                department_id: department_id,
                employee_id: employee_id,
                periode: periode,
                cutoff: cutoff, // addnew
            },
            success: function(response) {
                $('#table_rekap_absen').empty().append(response);

                $('#dt_rekap_absen').DataTable({
                    searching: true,
                    info: true,
                    paging: true,
                    destroy: true,
                    pageLength: 5,
                    dom: 'Bfrtip',
                    order: [
                        [0, 'asc']
                    ],
                    buttons: [{
                        extend: 'excelHtml5',
                        text: 'Export to Excel',
                        title: 'Rekap Absen',
                        exportOptions: {
                            columns: ':visible' // export hanya kolom yang terlihat
                        }
                    }]
                });

                $('#dt_rekap_absen').on('click', '.btn_detail', function() {
                    user_id = $(this).data('user_id');
                    periode = $(this).data('periode');
                    ctm_cutoff = $(this).data('ctm_cutoff');

                    $('#modal_detail').modal('show');

                    $('#dt_rekap_absen_detail').DataTable({
                        "lengthChange": false,
                        "pageLength": 30,
                        // "order": [
                        //     [2, 'asc']
                        // ],
                        "searching": true,
                        "info": true,
                        "paging": true,
                        "autoWidth": false,
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
                                periode: periode,
                                employee_id: user_id,
                                cutoff: ctm_cutoff
                            },
                            "url": "<?php echo base_url(); ?>dashboard/detail_absen"
                        },
                        "columns": [{
                                'data': 'user_id',
                                render: function(data, type, row, meta) {
                                    return meta.row + 1;
                                }
                            },
                            {
                                'data': 'employee_name'
                            },
                            {
                                'data': 'attendance_date'
                            },
                            {
                                'data': 'shift_in'
                            },
                            {
                                'data': 'clock_in'
                            },
                            {
                                'data': 'shift_out'
                            },
                            {
                                'data': 'clock_out'
                            },
                        ]
                    });
                });
            }
        });
    }

    $('#btn_save_confirm').click(function() {
        let attachment = $("#attachment").prop("files")[0];

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
                let form_data = new FormData();
                form_data.append("attachment", attachment);
                $.ajax({
                    url: "<?php echo base_url() ?>hr/rekap_absen/import_harus_hadir",
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    beforeSend: function() {},
                    success: function(data) {},
                }).done(function(response) {
                    // console.log(response);
                    if (response.status == true) {
                        setTimeout(() => {
                            jconfirm.instances[0].close();
                            $.confirm({
                                icon: 'fa fa-check',
                                title: 'Done!',
                                theme: 'material',
                                type: 'blue',
                                content: 'Berhasil mengimport data harus hadir!',
                                buttons: {
                                    close: function() {
                                        rekap_data();
                                        $('#modal_import_harus_hadir').modal('hide');
                                        $('#form_harus_hadir')[0].reset();
                                    },
                                },
                            });
                        }, 250);
                    } else {
                        jconfirm.instances[0].close();
                        $.confirm({
                            icon: 'fa fa-close',
                            title: 'Oops!',
                            theme: 'material',
                            type: 'red',
                            content: 'Gagal mengimport data harus hadir! <br>' + response.error,
                            buttons: {
                                close: {
                                    actions: function() {}
                                },
                            },
                        });
                    }
                }).fail(function(jqXHR, textStatus) {
                    console.log(jqXHR)
                    console.log(textStatus)
                    setTimeout(() => {
                        jconfirm.instances[0].close();
                        $.confirm({
                            icon: 'fa fa-close',
                            title: 'Oops!',
                            theme: 'material',
                            type: 'red',
                            content: 'Gagal mengimport data harus hadir!' + textStatus,
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
    });
</script>