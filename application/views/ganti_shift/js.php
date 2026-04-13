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
<!-- sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    const baseUrl = "<?= base_url('Ganti_shift') ?>"

    $(document).ready(function() {

        const slimShift = new SlimSelect({
            select: '#shift'
        });

        $(document).ready(function() {
            $('#table_shift').dataTable({
                "bDestroy": true,
                "order": [
                    [1, "asc"]
                ],
                "ajax": {
                    url: baseUrl + '/data_shift',
                    type: 'GET'
                },
                "lengthChange": false,
                "columns": [{
                        data: "shift_name",
                        render: function(data, type, row) {
                            return `<span class="badge badge-primary ganti_shift" data-user_id="${row['user_id']}" data-shift="${row['office_shift_id']}" style="background-color : #1565C0; cursor : pointer;">${data}</span>`
                        },
                        // className: "text-center"
                    },
                    {
                        data: "nama",
                        // className: "text-center"
                    },
                    {
                        data: "department_name",
                        className: "text-center"
                    },
                    {
                        data: "designation_name",
                        // className: "text-center"
                    }
                ],
                "fnDrawCallback": function(settings) {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

            $('#table_shift').on('click', '.ganti_shift', function() {
                const userId = $(this).data('user_id');
                const shiftId = $(this).data('shift');

                $('#user_id').val(userId);
                $('#modal_shift').modal('show');

            });

            $('#simpan_shift').on('click', function() {
                form = $('#form_shift');
                // console.log(form.serialize());
                $.ajax({
                    url: `${baseUrl}/update_shift`,
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {

                        $('#table_shift').DataTable().ajax.reload();
                        $('#modal_shift').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            text: 'Berhasil diupdate!',
                            title: 'Success!',
                            showConfirmButton: false,
                            timer: 1500
                        });

                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            });
        });

    });
</script>