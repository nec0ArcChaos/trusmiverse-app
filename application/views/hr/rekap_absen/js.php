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
            url: '<?php echo base_url(); ?>hr/rekap_absen/get_rekap_absen',
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
                    "searching": true,
                    "info": true,
                    "paging": true,
                    "destroy": true,
                    "pageLength": 5,
                    "dom": 'Bfrtip',
                    "order": [
                        [0, 'asc']
                    ],
                    buttons: [{
                            text: 'Export to Excel',
                            className: '',
                            action: function(e, dt, node, config) {
                                url_excel = "<?php echo base_url() ?>hr/rekap_absen/excel/" + company_id + "/" + department_id + "/" + employee_id + "/" + periode + "/" + cutoff; // addnew cutoff
                                window.open(url_excel, '_blank');
                            }
                        },
                        <?php if ($this->session->userdata('user_id') == 1 || $this->session->userdata('user_id') == 778 || $this->session->userdata('user_id') == 979): ?> {
                                text: 'Download Harus Hadir',
                                className: 'biru',
                                action: function(e, dt, node, config) {
                                    company_id = $('#company').val();
                                    department_id = $('#department').val();
                                    employee_id = $('#employee').val();
                                    periode = $('#periode').val();
                                    cutoff = $('#cutoff').val();

                                    $.ajax({
                                            url: `<?php echo base_url() ?>hr/rekap_absen/harus_hadir/${company_id}/${department_id}/${employee_id}/${periode}/${cutoff}`,
                                            type: 'GET',
                                            dataType: 'json',
                                        })
                                        .done(function(response) {
                                            console.log("success");
                                            var data = response;

                                            // Membuat worksheet
                                            var ws = XLSX.utils.aoa_to_sheet(data);

                                            // Membuat workbook
                                            var wb = XLSX.utils.book_new();
                                            XLSX.utils.book_append_sheet(wb, ws, "Harus Hadir");

                                            // Menghasilkan file XLSX
                                            XLSX.writeFile(wb, "harus_hadir.xlsx");
                                        })
                                        .fail(function() {
                                            console.log("error");
                                        })
                                        .always(function() {
                                            console.log("complete");
                                        });

                                }
                            },
                            {
                                text: 'Import Harus Hadir',
                                className: 'hijau',
                                attr: {
                                    id: 'buttonID'
                                },
                                action: function(e, dt, node, config) {
                                    $('#modal_import_harus_hadir').modal('show');
                                }
                            }
                        <?php endif ?>
                    ],
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