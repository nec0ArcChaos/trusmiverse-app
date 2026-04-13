<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<!-- <script type="text/javascript" src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script> -->


<script>
    let baseurl = `<?= base_url('tabungan_jam'); ?>`

    // Set default start date to the current month
    var start = moment().startOf('month');

    // Callback function to update inputs and display the selected month
    function cb(start) {
        // Display selected month and year in the visible input field
        $('#titlecalendar').val(start.format('MMMM YYYY'));
        // Set the hidden input field's value to the start date
        $('#periode').val(start.format('YYYY-MM-DD'));
    }

    // Initialize the daterangepicker for month selection
    $('#titlecalendar').daterangepicker({
        startDate: start,
        autoUpdateInput: false, // Disable default automatic input update
        locale: {
            format: 'MMMM YYYY' // Display format for the picker
        },
        showDropdowns: true, // Enable year navigation dropdown
        singleDatePicker: true, // Use single date picker for months
        showCustomRangeLabel: false, // Disable custom range label
        isInvalidDate: function() {
            return false; // Allow all dates to be selected
        }
    }, function(start) {
        // Trigger callback on selection
        cb(start.startOf('month'));
    });

    cb(start);

    $('.tanggal').datetimepicker({
        format: 'Y-m-d',
        timepicker: false,
        scrollMonth: false,
        scrollInput: false
    });

    function filter_periode() {
        // let periode = $('#periode').val();
        let periode = $("#year").val() + '-' + $("#month").val() + '-01';
        getListTabungan(periode);
    }


    $(document).ready(function() {
        let dateNow = moment().startOf('month')
        getListTabungan(dateNow.format('YYYY-MM-DD'));
    });




    function getListTabungan(periode) {
        $('#dt_list_tabungan_jam').DataTable({
            // orderCellsTop: false,
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "ordering": true,
            "autoWidth": true,
            "responsive": true,
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="bi bi-file-earmark-arrow-down"></i> Excel',
                footer: true
            }],
            responsive: false,
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": `${baseurl}/list_tabungan_jam`,
                "data": {
                    periode
                }
            },
            "columns": [{
                    "data": "nama",
                    "className": "text-center",
                },
                {
                    "data": "leave_type",
                    "className": "align-middle text-dinamis",
                    "render": function(data, type, row, meta) {
                        return `<a class="badge bg-info" href="javascript:void(0)" onclick="detail('${row['employee_id']}','${row['start_periode']}','${row['end_periode']}')">${data}</a>`
                    }
                },
                {
                    "data": "periode",
                    "className": "align-middle text-dinamis"
                },
                {
                    "data": "company_name",
                    "className": "align-middle text-dinamis"
                },
                {
                    "data": "department_name",
                    "className": "align-middle text-dinamis"
                },
                {
                    "data": "grand_total",
                    "className": "align-middle text-dinamis"
                },
                {
                    "data": "keterangan",
                    "className": "align-middle text-dinamis"
                },

            ],
        });
    }

    function list_detail(id, start, end) {
        $('#dt_detail_leave').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "order": [
                [0, 'desc']
            ],
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="bi bi-file-earmark-arrow-down"></i> Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    id,
                    start,
                    end
                },
                "url": `${baseurl}/list_detail`,
            },
            "columns": [

                {
                    "data": "kota",
                    "className": "align-middle text-dinamis"
                },
                {
                    "data": "start_date",
                    "className": "align-middle text-dinamis"
                },
                {
                    "data": "end_date",
                    "className": "align-middle text-dinamis"
                },
                {
                    "data": "reason",
                    "className": "align-middle text-dinamis"
                },
                {
                    "data": "total_jam",
                    "className": "align-middle text-dinamis"
                },
                {
                    "data": "tabungan_jam",
                    "className": "align-middle text-dinamis"
                },

            ],
        });
    }

    function detail(id, start, end) {
        list_detail(id, start, end)
        $('#modal_detail').modal('show');
    }

    $('#tgl_ph').change(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: `${baseurl}/cekJumlahCuti`,
            data: {
                'periode': $(this).val()
            },
            dataType: "json",
            success: function(response) {
                let cuti = 0;
                let idLeave = null
                if (response.length > 0) {
                    cuti = response[0]['grand_total'];
                    // idLeave = response[0]['leave_ids'];
                }

                if (cuti > 11) {
                    $('#add_leave').removeAttr('disabled');
                } else {
                    $('#add_leave').attr('disabled', 'disabled');
                }
            },
            error: function() {
                console.error('Terjadi kesalahan saat menghubungi server.');
            }
        });
    });

    function add_leave() {
        let tgl_ph = $('#tgl_ph').val();
        let end_date = $('#end_date').val();
        let leave_reason = $('#leave_reason').val();

        if (tgl_ph == "") {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Tanggal libur belum diisi!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (end_date == '') {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Tanggal Pengganti libur belum diisi!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (leave_reason = "") {
            $.confirm({
                icon: 'fa fa-times-circle',
                title: 'Warning',
                theme: 'material',
                type: 'red',
                content: 'Reason belum diisi!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else {
            const form = $('#from_add_leave')[0];
            const formData = new FormData(form);

            $.ajax({
                type: "POST",
                url: `${baseurl}/save_leave`,
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#add_leave').html('Please wait...');
                    $('#add_leave').prop('disabled', true);
                },
                success: function(response) {
                    if (response.status == false) {
                        $.confirm({
                            icon: 'fa fa-times-circle',
                            title: 'Warning',
                            theme: 'material',
                            type: 'red',
                            content: response.error,
                            buttons: {
                                close: {
                                    actions: function() {}
                                },
                            },
                        });
                    }
                    $('#from_add_leave')[0].reset();
                    getListTabungan($('#periode').val())
                },
                complete: function() {
                    $('#add_leave').html('Submit Request');
                    $('#modal_add_leave').modal('hide');
                }
            });
        }
    }
</script>