<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<!-- Tambahin ini di <head> atau sebelum </body> -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
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
<script>
$(document).ready(function () {

    const baseurl = "<?= rtrim(base_url(), '/') ?>";

    $('#btn-proses').on('click', function () {
        uploadGRD();
    });

    function uploadGRD() {

        const fileInput = document.getElementById('fileInput');

        if (fileInput.files.length === 0) {
            alert('Silakan pilih file GRD terlebih dahulu');
            return;
        }

        let formData = new FormData();
        formData.append('file_grd', fileInput.files[0]);

        $('#btn-proses').prop('disabled', true).text('Memproses...');

        $.ajax({
            url: baseurl + '/input_head_event/upload_grd',
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,

            success: function (response) {
                $('#btn-proses').prop('disabled', false).text('Proses Data');

                if (response.status === 'success') {
                    alert(response.message);
                    resetUpload();
                } else {
                    alert(response.message);
                }
            },

            error: function (xhr) {
                $('#btn-proses').prop('disabled', false).text('Proses Data');
                console.log('STATUS:', xhr.status);
                console.log('RESPONSE:', xhr.responseText);
                alert('Terjadi kesalahan saat upload');
            }
        });
    }

});
</script>