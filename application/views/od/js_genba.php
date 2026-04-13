<!-- Datatable -->
<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/data-table/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo base_url() ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fancybox/jquery.fancybox.min.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
        let start = moment().startOf('month');
        let end = moment().endOf('month');

        function cb(start, end) {
            $('#reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="datestart"]').attr('value', start.format('YYYY-MM-DD'));
            $('input[name="dateend"]').attr('value', end.format('YYYY-MM-DD'));
        }

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

        listGenba('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>');
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
        start = $('#datestart').val();
        end = $('#dateend').val();
        listGenba(start, end);
    }
</script>
