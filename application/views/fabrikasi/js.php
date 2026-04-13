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

<script type="text/javascript" src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>



<script>
    const baseUrl = `<?php echo base_url('/fabrikasi'); ?>`
    $(document).ready(function() {
        getDataUpah();
    });

    select_employee = new SlimSelect({
        select: '#employee_id'
    })

    function validasiUpah(input) {
        let value = input.value.replace(/\D/g, '');
        value = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(value);
        input.value = value;
    }

    function getDataUpah() {
        $('#dt_upah_helper').DataTable({
            searching: true,
            info: true,
            paging: true,
            destroy: true,
            ordering: true,
            autoWidth: true,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            ajax: {
                dataType: 'json',
                type: 'GET',
                url: baseUrl + '/getDataUpah',
            },
            columns: [{
                    data: 'nama'
                },
                {
                    data: 'company_name',
                    className: 'text-center'
                },
                {
                    data: 'department_name',
                    className: 'text-center'
                },
                {
                    data: 'designation_name',
                    className: 'text-center'
                },
                {
                    data: 'nominal',
                    render: function(data) {
                        return toCurrency(data);
                    },
                    className: 'text-right'
                },
                {
                    data: 'lembur',
                    render: function(data, row, meta) {
                        return toCurrency(data)
                    },
                    className: 'text-right'
                },
                {
                    data: 'user_id',
                    render: function(data) {
                        return `<button type="button" class="btn btn-sm btn-primary" onclick="deleteUpah(${data})"><i class="bi bi-trash"></i></button>`;
                    },
                    className: 'text-center'
                }
            ],
        });
    }

    function deleteUpah(id) {
        $.confirm({
            title: 'Hapus Upah',
            icon: 'fa fa-warning',
            content: 'Yakin ingin menghapus upah?',
            theme: 'bootstrap',
            type: 'blue',
            buttons: {
                confirm: function() {
                    $.ajax({
                        url: baseUrl + '/destroyUpah',
                        type: 'POST',
                        data: {
                            employee_id: id
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response == true) {
                                $.alert({
                                    title: 'Berhasil',
                                    content: 'Upah berhasil dihapus',
                                    autoClose: 'ok|2000',
                                    theme: 'bootstrap',
                                    type: 'green'
                                });
                                getDataUpah();
                            } else {
                                $.alert({
                                    title: 'Gagal',
                                    content: 'Upah gagal dihapus',
                                    autoClose: 'ok|2000',
                                    theme: 'bootstrap',
                                    type: 'red'
                                });
                            }
                        }
                    });
                },
                cancel: function() {

                }
            }
        });
    }

    function add_upah() {
        let employee_id = $('#employee_id').val();
        let upah = $('#upah').val().replace(/\D/g, '');
        let lembur = $('#lembur').val().replace(/\D/g, '');

        if (employee_id == '') {
            $.alert({
                title: 'Oops!',
                content: 'Pilih employee terlebih dahulu',
                autoClose: 'ok|2000',
                theme: 'bootstrap',
                type: 'red'
            })
            return;
        } else if (upah == '' || upah == 0) {
            $.alert({
                title: 'Oops!',
                content: 'Upah tidak boleh kosong',
                autoClose: 'ok|2000',
                theme: 'bootstrap',
                type: 'red'
            })
            return;
        } else if (lembur == '' || lembur == 0) {
            $.alert({
                title: 'Oops!',
                content: 'Lembur tidak boleh kosong',
                autoClose: 'ok|2000',
                theme: 'bootstrap',
                type: 'red'
            })
            return;
        } else {
            $.ajax({
                url: baseUrl + '/saveUpah',
                type: 'POST',
                data: {
                    employee_id: employee_id,
                    upah: upah,
                    lembur: lembur
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#btn-addUpah').attr('disabled', true);
                },
                success: function(response) {
                    // console.log(response.status);
                    if (response.status == true) {
                        $.alert({
                            title: 'Berhasil',
                            content: response.message,
                            autoClose: 'ok|2000',
                            theme: 'bootstrap',
                            type: 'green'
                        });
                        $('#modal_add_upah').modal('hide');
                        getDataUpah();
                        $('#employee_id').val('');
                        $('#upah').val('');
                        $('#lembur').val('');
                    } else {
                        $.alert({
                            title: 'Gagal',
                            content: response.message,
                            autoClose: 'ok|2000',
                            theme: 'bootstrap',
                            type: 'red'
                        });
                    }
                },
                complete: function() {
                    $('#btn-addUpah').attr('disabled', false);
                }
            });
        }
    }
</script>