<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript"
    src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.1/viewer.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.1/viewer.min.js"></script>

<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script>

    $(function () { // Ini adalah shorthand untuk $(document).ready()
        $('#modal_welcome').modal('show');
        $('.day-trigger').on('click', function () {
            var targetDay = $(this).data('day');
            $('.day-trigger').removeClass('active');
            $(this).addClass('active');
            $('.day-content').hide();
            $('#day-' + targetDay + '-content').show();
        });
        $('.collapsible-trigger').on('click', function () {

            // 1. Cari konten yang berhubungan (yaitu .collapsible-content yang berada di dalam .custom-collapsible yang sama)
            //    lalu tampilkan/sembunyikan dengan animasi slide.
            $(this).closest('.custom-collapsible').find('.collapsible-content').slideToggle(300); // 300ms durasi animasi

            // 2. Cari ikon panah di dalam trigger yang diklik, lalu putar 180 derajat.
            $(this).find('.bi-chevron-down').toggleClass('rotated');

        });
    });

    

</script>
<?php 
    // $this->load->view('timeline_onboarding_lutfi/js_chat.php');
    $this->load->view('timeline_onboarding_lutfi/js_chat_lutfi.php');
?>