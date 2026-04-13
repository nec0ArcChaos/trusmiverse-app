<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<!-- <script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script> -->
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>


<script>
    $(document).ready(function () {
        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
        }

        $('.range').daterangepicker({
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
        data('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>');
        // $('#btn_filter').on('click', function() {
        //     start = $('input[name="startdate"]').val();
        //     end = $('input[name="enddate"]').val();
        //     dt_memo(tart, end);
        // });
        $('.range').on('change', function () {
            start = $('input[name="start"]').val();
            end = $('input[name="end"]').val();
            data(start, end);
        })
        // initCompany = new SlimSelect({
        //     select: "#company_id",
        //     dropdownParent: "#modal_add_memo"
        // });




    });

    function data(start,end){
        $('#dt_janji_konsumen').DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "autoWidth": false,
            "destroy": true,
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data":{
                    start:start,
                    end:end
                },
                "url": `<?= base_url("janji_konsumen/data") ?>`,
                "dataSrc":''
            },
            "columns": [
                { "data": "periode" },
                { "data": "week" },
                { "data": "jenis" },
                { "data": "komplain" },
                { "data": "detail_komplain" },
                { "data": "value" },
                { "data": "kompensasi" },
                { "data": "nominal" },
                { "data": "persen_company" },
                { "data": "persen_employee" },
                { "data": "created_name" },
                { "data": "created_at" },
                // Tambahkan kolom lainnya sesuai kebutuhan
            ]
        });
    }

    function modal_input() {
        $('#form-input').trigger('reset')
        $('#modal_input').modal('show');
    }

    function loadKomplain() {
        let tahun  = $("select[name='tahun']").val();
        let bulan  = $("select[name='bulan']").val();
        let week   = $("select[name='week']").val();
        let jenis  = $("#jenis").val();

        if (!tahun || !bulan || !week || !jenis) {
            $("#komplain").html('<option value="">Pilih semua input di atas terlebih dahulu</option>');
            return;
        }

        $.ajax({
            url: "<?= base_url('janji_konsumen/get_komplain') ?>",
            type: "POST",
            data: {
                periode: tahun+'-'+bulan,
                week: week,
                jenis: jenis
            },
            dataType: "json",
            beforeSend: function () {
                $("#komplain").html('<option value="">Loading...</option>');
            },
            success: function (res) {
                if (res.length > 0) {
                    let options = '<option value="">Pilih Komplain</option>';
                    $.each(res, function (i, item) {
                        let text = item.komplain + ' - ' + item.kompensasi;
                        if (item.detail_komplain && item.detail_komplain !== '-') {
                            text += ' - ' + item.detail_komplain + item.kompensasi;
                        }
                        options += `<option value="${item.id_komplain}">${text}</option>`;
                    });
                    $("#komplain").html(options).prop("disabled", false);
                } else {
                    $("#komplain").html('<option value="">Tidak ada data komplain</option>').prop("disabled", true);
                }
            },
            error: function () {
                $("#komplain").html('<option value="">Gagal memuat data</option>').prop("disabled", true);
            }
        });
    }
    

    // Trigger saat ada perubahan input
    $("select[name='tahun'], select[name='bulan'], select[name='week'], #jenis").on("change", loadKomplain);
    // $("#jenis").on("change", function () {
    //     const jenisVal = $(this).val();

    //     // reset komplain
    //     $("#komplain").val("").prop("disabled", true);

    //     // hide semua option kecuali default
    //     $("#komplain option").hide();
    //     $("#komplain option:first").show();

    //     if (jenisVal) {
    //         // tampilkan komplain yg sesuai jenis
    //         $("#komplain option[data-jenis='" + jenisVal + "']").show();
    //         $("#komplain").prop("disabled", false);
    //     }
    // });

    $('#form-input').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '<?= base_url("janji_konsumen/insert") ?>', // Ganti dengan URL controller Anda
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response) {
                    $('#dt_janji_konsumen').DataTable().ajax.reload();
                    swal('Success!', 'Berhasil Update data!', 'success');
                    $('#modal_input').modal('hide');
                }

            },
            error: function () {
                alert('Terjadi kesalahan saat menghubungi server.');
            }
        });

    });

</script>