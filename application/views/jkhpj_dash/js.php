<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/dragula/dragula.js"></script>


<script>
    $(document).ready(function() {
        var curent = moment().format('YYYY-MM');

        new SlimSelect({
            select: '#department_id'
        })

        $("#periode").datepicker({
            format: 'yyyy-mm',
            viewMode: "months",
            startView: "months",
            minViewMode: "months",
            // autoClose: true
            dateFormat: 'yy-mm',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
        });

        $('input[name="periode"]').attr('value', curent);
        dt_dashboard(curent);
    });

    // $('#periode').change(function(e) {
    //     e.preventDefault();

    //     var periode = $(this).val();
    //     var department_id = $('select[name="department_id"]').val();
    //     dt_dashboard(periode);
    // });

    function filter() {
        var periode = $('input[name="periode"]').val();
        var department_id = $('select[name="department_id"]').val();
        dt_dashboard(periode, department_id);
    }

    function createPersenTask(persen) {
        if (parseFloat(persen) < 10) {
            return `<div class="d-block badge text-bg-danger mb-1">${persen}%</div>`
        } else if (parseFloat(persen) > 10 && parseFloat(persen) < 80) {
            return `<div class="d-block badge text-bg-warning mb-1">${persen}%</div>`
        } else {
            return `<div class="d-block badge text-bg-success mb-1">${persen}%</div>`
        }
    }

    function createStatusFb(status) {
        if (status == 'Tidak Berjalan') {
            return `<div class="d-block badge text-bg-danger">${status}</div>`
        } else if (status == 'Jalan Tidak Berhasil') {
            return `<div class="d-block badge text-bg-warning">${status}</div>`
        } else if (status == 'Jalan Berhasil') {
            return `<div class="d-block badge text-bg-info">${status}</div>`
        } else if (status == 'Progress') {
            return `<div class="d-block badge text-bg-primary">${status}</div>`
        } else {
            return ``
        }
    }

    function dt_dashboard(periode, department_id = null) {
        let tglColumns = [];
        for (let i = 1; i <= 31; i++) {
            tglColumns.push({
                "data": `tgl${i}`,
                "render": function(data, type, row, meta) {
                    let persenTask = createPersenTask(data)
                    let statusFb = createStatusFb(row[`tgl${i}_fb`])
                    return `${persenTask}\n${statusFb}`
                }
            });
        }

        $('#dt_dashboard').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "lengthChange": false,
            "responsive": false,
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "url": "<?= base_url(); ?>jkhpj_dash/get_data_dashboard",
                "type": "POST",
                "data": {
                    periode: periode,
                    department_id: department_id
                },
                "dataType": 'json'
            },
            "columns": [{
                    "data": null,
                    "render": function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    "data": "nama"
                },
                {
                    "data": "department_name"
                },
                {
                    "data": "designation_name"
                },
                ...tglColumns,
                {
                    "data": null,
                    "render": function(data, type, row, meta) {
                        let jumlahAvg = 0
                        for (let i = 1; i <= 31; i++) {
                            if (row['tgl' + i]) {
                                jumlahAvg += parseInt(row['tgl' + i])
                            }
                        }
                        return (jumlahAvg / 31).toFixed(1) + '%'
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row, meta) {
                        let jumlahAvg = 0
                        for (let i = 1; i <= 31; i++) {
                            if (row['tgl' + i] && row['tgl' + i + '_fb'] == 'Jalan Berhasil') {
                                jumlahAvg += parseInt(row['tgl' + i])
                            }
                        }
                        return (jumlahAvg / 31).toFixed(1) + '%'
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row, meta) {
                        let jumlahAvg = 0
                        for (let i = 1; i <= 31; i++) {
                            let fb = row['tgl' + i + '_fb'];
                            if (row['tgl' + i] && fb !== 'Jalan Berhasil' && fb !== null) {
                                jumlahAvg += parseInt(row['tgl' + i])
                            }
                        }
                        return (jumlahAvg / 31).toFixed(1) + '%'
                    }
                }
            ]
        })
    }
</script>