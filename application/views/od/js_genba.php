<!-- Datatable Buttons (core DataTable already loaded in main layout) -->
<script src="<?php echo base_url() ?>assets/data-table/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo base_url() ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fancybox/jquery.fancybox.min.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
        let isAllTime = true;

        function cb(start, end, label) {
            if (label === 'All Time' || isAllTime) {
                $('#range').val('All Time');
                $('input[name="datestart"]').val('');
                $('input[name="dateend"]').val('');
                isAllTime = true;
            } else {
                $('#range').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                $('input[name="datestart"]').val(start.format('YYYY-MM-DD'));
                $('input[name="dateend"]').val(end.format('YYYY-MM-DD'));
                isAllTime = false;
            }
        }

        $('#range').daterangepicker({
            startDate: moment().startOf('month'),
            endDate: moment().endOf('month'),
            "drops": "down",
            ranges: {
                'All Time': [moment('2000-01-01'), moment()],
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        // Event listener untuk Apply button
        $('#range').on('apply.daterangepicker', function(ev, picker) {
            let label = picker.chosenLabel;
            if (label === 'All Time') {
                isAllTime = true;
            } else {
                isAllTime = false;
            }
            cb(picker.startDate, picker.endDate, label);
            show_filter();
        });

        // Default: All Time
        $('#range').val('All Time');
        $('input[name="datestart"]').val('');
        $('input[name="dateend"]').val('');

        listGenba('', '');
    });

    function listGenba(start, end) {
        $('#list_dokumen_genba').DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "autoWidth": false,
            "destroy": true,
            "responsive": true,
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-sm btn-success',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": { start: start, end: end },
                "url": `<?= base_url("od_dokumen_genba/listGenba") ?>`,
            },
            "columns": [
                { 'data': 'id_genba' },
                { 'data': 'pic' },
                { 'data': 'tanggal' },
                { 'data': 'divisi' },
                { 'data': 'nama_company' },
                { 'data': 'nama_department' },
                {
                    'data': 'narasumber',
                    "createdCell": function(td) {
                        $(td).css({ "word-wrap": "break-word", "white-space": "normal" });
                    }
                },
                {
                    'data': 'nama_dokumen',
                    "createdCell": function(td) {
                        $(td).css({ "word-wrap": "break-word", "white-space": "normal" });
                    }
                },
                {
                    'data': 'tgl_terbit',
                    "render": function(data) {
                        return data || '-';
                    }
                },
                {
                    'data': 'penjelasan',
                    "render": function(data) {
                        return data ? '<small>' + data.substring(0, 50) + (data.length > 50 ? '...' : '') + '</small>' : '-';
                    },
                    "createdCell": function(td) {
                        $(td).css({ "word-wrap": "break-word", "white-space": "normal" });
                    }
                },
                {
                    'data': 'designation_name',
                    "render": function(data) {
                        return data || '-';
                    }
                },
                { 'data': 'temuan' },
                { 'data': 'analisa' },
                { 'data': 'solusi' },
                {
                    'data': 'rekomendasi',
                    "render": function(data, type, row) {
                        if (data == null) {
                            return (row.other ? row.other : '');
                        } else {
                            return data;
                        }
                    }
                },
                { 'data': 'masalah' },
                { 'data': 'keluhan' },
                { 'data': 'keinginan' },
                {
                    'data': 'file',
                    "render": function(data) {
                        if (data == null || data == '') {
                            return '';
                        } else {
                            return '<a data-fancybox="gallery" href="<?= base_url() ?>assets/files/' + data + '" class="label label-info gallery"><i class="ti-image"></i></a>';
                        }
                    },
                    className: 'text-center'
                },
                { 'data': 'evaluasi' },
                { 'data': 'created_at' },
                { 'data': 'created_by' }
            ]
        });
    }

    function show_filter() {
        var start = $('#datestart').val();
        var end = $('#dateend').val();
        listGenba(start, end);
    }
</script>
