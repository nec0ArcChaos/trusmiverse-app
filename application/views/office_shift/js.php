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
<script src="<?= base_url(); ?>assets/clockpicker/jquery-clockpicker.min.js" type="text/javascript"></script>
<!-- sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    const baseUrl = "<?= base_url('office_shift') ?>"

    const slimShift = new SlimSelect({
        select: '#shift'
    });


    $(document).ready(function() {

        $('.timepicker').clockpicker({
            placement: 'bottom',
            align: 'left',
            autoclose: true,
            'default': 'now'
        });

        $('#table_shift').dataTable({
            "bDestroy": true,
            "ajax": {
                url: baseUrl + '/data_shift_office',
                type: 'GET'
            },
            "lengthChange": false,
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "columns": [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return `
                                <button type="button" 
                                        class="btn btn-sm btn-outline-primary edit-data" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editModal" 
                                        data-office_shift_id="${row.office_shift_id}">
                                    <i class="fa fa-pencil"></i>
                                </button>

                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger delete-data" 
                                        data-record-id="${row.office_shift_id}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            `
                    }
                },
                {
                    data: "company"
                },
                {
                    data: "shift_name"
                },
                {
                    data: null,
                    title: 'Monday',
                    render: function(data, type, row) {
                        return formatShift(row.monday_in_time, row.monday_out_time);
                    }
                },
                {
                    data: null,
                    title: 'Tuesday',
                    render: function(data, type, row) {
                        return formatShift(row.tuesday_in_time, row.tuesday_out_time);
                    }
                },
                {
                    data: null,
                    title: 'Wednesday',
                    render: function(data, type, row) {
                        return formatShift(row.wednesday_in_time, row.wednesday_out_time);
                    }
                },
                {
                    data: null,
                    title: 'Thursday',
                    render: function(data, type, row) {
                        return formatShift(row.thursday_in_time, row.thursday_out_time);
                    }
                },
                {
                    data: null,
                    title: 'Friday',
                    render: function(data, type, row) {
                        return formatShift(row.friday_in_time, row.friday_out_time);
                    }
                },
                {
                    data: null,
                    title: 'Saturday',
                    render: function(data, type, row) {
                        return formatShift(row.saturday_in_time, row.saturday_out_time);
                    }
                },
                {
                    data: null,
                    title: 'Sunday',
                    render: function(data, type, row) {
                        return formatShift(row.sunday_in_time, row.sunday_out_time);
                    }
                }

            ],
            "fnDrawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });


    });

    function showError(msg) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: msg,
            showConfirmButton: false,
            timer: 1500
        });
    }

    function showSuccess(msg) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: msg,
            showConfirmButton: false,
            timer: 1500
        });
    }

    function convertTo12Hour(time24) {
        if (!time24) return '-';
        const [hourStr, minute] = time24.split(':');
        let hour = parseInt(hourStr);
        const ampm = hour >= 12 ? 'PM' : 'AM';
        hour = hour % 12;
        if (hour === 0) hour = 12;
        return `${hour.toString().padStart(2, '0')}:${minute} ${ampm}`;
    }

    function formatShift(inTime, outTime) {
        if (!inTime || !outTime) return '-';
        return convertTo12Hour(inTime) + ' to ' + convertTo12Hour(outTime);
    }

    $(document).on('click', '.clear-time', function() {
        const clearId = $(this).data('clear-id');

        $(`.clear-${clearId}`).val('');
    });

    $('#table_shift').on('click', '.edit-data', function() {
        const id = $(this).data('office_shift_id');
        $('#formUpdateShift #office_shift_id').val(id);

        $.ajax({
            url: baseUrl + '/get_shift/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                // Isi hanya form update
                const form = $('#formUpdateShift');

                form.find('#aj_company').val(res.company_id).trigger('change');
                form.find('#name').val(res.shift_name);

                form.find('[name="monday_in_time"]').val(res.monday_in_time);
                form.find('[name="monday_out_time"]').val(res.monday_out_time);

                form.find('[name="tuesday_in_time"]').val(res.tuesday_in_time);
                form.find('[name="tuesday_out_time"]').val(res.tuesday_out_time);

                form.find('[name="wednesday_in_time"]').val(res.wednesday_in_time);
                form.find('[name="wednesday_out_time"]').val(res.wednesday_out_time);

                form.find('[name="thursday_in_time"]').val(res.thursday_in_time);
                form.find('[name="thursday_out_time"]').val(res.thursday_out_time);

                form.find('[name="friday_in_time"]').val(res.friday_in_time);
                form.find('[name="friday_out_time"]').val(res.friday_out_time);

                form.find('[name="saturday_in_time"]').val(res.saturday_in_time);
                form.find('[name="saturday_out_time"]').val(res.saturday_out_time);

                form.find('[name="sunday_in_time"]').val(res.sunday_in_time);
                form.find('[name="sunday_out_time"]').val(res.sunday_out_time);
            }
        });
    });



    $('#formUpdateShift').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const data = form.serialize();
        const id = $('#office_shift_id').val(); // input hidden

        // Client-side validation (harus konsisten dengan server-side logic)
        const companyId = $('#aj_company').val();
        const shiftName = $('#name').val();
        const mondayIn = $('[name="monday_in_time"]').val();
        const mondayOut = $('[name="monday_out_time"]').val();
        const tuesdayIn = $('[name="tuesday_in_time"]').val();
        const tuesdayOut = $('[name="tuesday_out_time"]').val();
        const wednesdayIn = $('[name="wednesday_in_time"]').val();
        const wednesdayOut = $('[name="wednesday_out_time"]').val();
        const thursdayIn = $('[name="thursday_in_time"]').val();
        const thursdayOut = $('[name="thursday_out_time"]').val();
        const fridayIn = $('[name="friday_in_time"]').val();
        const fridayOut = $('[name="friday_out_time"]').val();
        const saturdayIn = $('[name="saturday_in_time"]').val();
        const saturdayOut = $('[name="saturday_out_time"]').val();
        const sundayIn = $('[name="sunday_in_time"]').val();
        const sundayOut = $('[name="sunday_out_time"]').val();

        if (!companyId) return showError("Company is required.");
        if (!shiftName) return showError("Shift name is required.");
        if (mondayIn && !mondayOut) return showError("Monday out time is required.");
        if (tuesdayIn && !tuesdayOut) return showError("Tuesday out time is required.");
        if (wednesdayIn && !wednesdayOut) return showError("Wednesday out time is required.");
        if (thursdayIn && !thursdayOut) return showError("Thursday out time is required.");
        if (fridayIn && !fridayOut) return showError("Friday out time is required.");
        if (saturdayIn && !saturdayOut) return showError("Saturday out time is required.");
        if (sundayIn && !sundayOut) return showError("Sunday out time is required.");

        $.ajax({
            url: baseUrl + '/update_shift/' + id,
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    showError(response.error);
                } else {
                    $('#editModal').modal('hide');
                    $('#table_shift').DataTable().ajax.reload(null, false);
                    showSuccess(response.result);
                }
            }
        });
    });

    $('#table_shift').on('click', '.delete-data', function() {
        const id = $(this).data('record-id');

        Swal.fire({
            title: 'Yakin ingin menghapus shift ini?',
            text: 'Data tidak bisa dikembalikan setelah dihapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: baseUrl + '/delete_shift',
                    method: 'POST',
                    data: {
                        office_shift_id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.error && res.error !== '') {
                            showError(res.error)
                        } else {
                            showSuccess(res.result)
                            $('#table_shift').DataTable().ajax.reload(null, false);
                        }
                    },
                    error: function() {
                        showError('Tidak dapat terhubung ke server.')
                    }
                });
            }
        });
    });



    $('#formAddShift').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const formData = form.serialize();

        let shiftName = $('#add_shift_name').val();
        let company = $('#comp_add_shift').val();

        if (shiftName == '') {
            return showError("Shift name is required.");
        }

        if (company == '') {
            return showError("Company is required.");
        }

        $.ajax({
            url: baseUrl + '/add_shift',
            type: 'POST',
            data: formData,
            success: function(res) {

                if (res.error && res.error !== '') {
                    showError(res.error)
                } else {
                    showSuccess(res.result)
                    $('#modalAddShift').modal('hide');
                    $('#formAddShift')[0].reset();
                    $('#table_shift').DataTable().ajax.reload();
                }
            },
            error: function() {
                showError('Tidak dapat terhubung ke server.')
            }
        });
    });
</script>