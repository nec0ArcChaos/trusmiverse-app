<!-- third party js -->
<script src="<?= base_url() ?>assets/vendor/ckeditor/ckeditor.js"></script>
<!-- third party js ends -->

<!-- Datatable Buttons (core already loaded in main layout) -->
<script src="<?php echo base_url() ?>assets/data-table/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo base_url() ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/daterangepicker.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        let start = moment().startOf('month');
        let end = moment().endOf('month');

        function cb(start, end) {
            $('#reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="datestart"]').attr('value', start.format('YYYY-MM-DD'));
            $('input[name="dateend"]').attr('value', end.format('YYYY-MM-DD'));
        }

        $('#sel_dept').select2({
            theme: 'bootstrap-5',
        });

        $('#range').daterangepicker({
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

        show_job_profile('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>', 0);
    });

    function show_data() {
        let sel_dept = $('#sel_dept').val();
        let start = $('#datestart').val();
        let end = $('#dateend').val();
        show_job_profile(start, end, sel_dept);
    }

    function show_job_profile(start, end, sel_dept) {
        $('#dt_job_profile').DataTable({
            searching: true,
            info: true,
            paging: true,
            autoWidth: false,
            destroy: true,
            order: [[9, "desc"]],
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-sm btn-success',
                filename: 'Dokumen OD',
                footer: true
            }],
            ajax: {
                url: '<?= base_url("od_dokumen/data_od/") ?>' + start + '/' + end + '/' + sel_dept,
                type: 'GET',
                dataType: 'json',
            },
            columns: [
                {
                    data: 'id_od',
                    render: function(data, type, row) {
                        let uid = '<?php echo $this->session->userdata('user_id') ?>';
                        let allowed = ['2774', '2843', '2903', '1'];
                        if (allowed.includes(uid)) {
                            return `<a href="javascript:void(0);" onclick="delete_od('${data}')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>`;
                        }
                        return '';
                    },
                    className: 'text-center',
                    orderable: false,
                },
                { data: 'id_od' },
                { data: 'judul' },
                {
                    data: 'jenis_label',
                    render: function(data) {
                        return data ? `<span class="badge badge-info">${data}</span>` : '-';
                    },
                    className: 'text-center',
                },
                { data: 'category' },
                {
                    data: 'priority',
                    render: function(data) {
                        if (!data) return '-';
                        let color = 'secondary';
                        if (data === 'Critical') color = 'danger';
                        else if (data === 'High') color = 'warning';
                        else if (data === 'Medium') color = 'primary';
                        else if (data === 'Low') color = 'success';
                        return `<span class="badge badge-${color}">${data}</span>`;
                    },
                    className: 'text-center',
                },
                { data: 'department_name' },
                { data: 'company_name' },
                {
                    data: 'status_label',
                    render: function(data, type, row) {
                        let color = row.color_status ? row.color_status : 'secondary';
                        return data ? `<span class="badge light" style="background-color:${color};color:#fff;">${data}</span>` : '-';
                    },
                    className: 'text-center',
                },
                { data: 'created_at' },
                { data: 'note' },
            ],
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            }
        });
    }

    function delete_od(id_od) {
        Swal.fire({
            title: "Hapus data ini?",
            text: "Data tidak dapat dikembalikan setelah dihapus.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url() ?>od_dokumen/delete_od',
                    type: 'POST',
                    data: { 'id_od': id_od },
                    dataType: 'JSON',
                    success: function() {
                        Swal.fire({ icon: "success", title: "Berhasil", text: "Data telah dihapus." });
                        $('#dt_job_profile').DataTable().ajax.reload();
                    }
                });
            }
        });
    }
</script>
