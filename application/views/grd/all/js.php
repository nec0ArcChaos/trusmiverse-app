<!-- Datetimepicker Full -->
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<!-- Jquery Confirm -->

<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<!-- Add jQuery and Bootstrap JS at the end of the body -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Fomantic Or Semantic Ui -->
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/dropdown.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/form.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/transition.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/popup.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/toast.js"></script>

<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>

<!-- Datepicker -->
<script type="text/javascript" src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>

<script src="<?= base_url(); ?>assets/owl_carousel/owl.carousel.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    const base_url = '<?= base_url('grd/all/grd/'); ?>';
</script>

<?php $this->load->view('grd/all/_content/content_1_js'); ?>
<?php $this->load->view('grd/all/_content/content_2_js'); ?>
<?php $this->load->view('grd/all/_content/content_3_js_kiri'); ?>
<?php $this->load->view('grd/all/_content/content_3_js_kanan'); ?>
<?php $this->load->view('grd/all/_content/kanban_js'); ?>

<script src="<?= base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.3.1/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/js/dataTables.bootstrap5.min.js"></script>


<script>
    $(document).ready(function() {
        $("#start").datepicker({
            startDate: new Date(),
            autoclose: true,
            format: "yyyy-mm-dd",
        });
        var nextDate = new Date();
        nextDate.setDate(nextDate.getDate() + 1);
        $("#end").datepicker({
            startDate: nextDate,
            autoclose: true,
            format: "yyyy-mm-dd",
        });
    });

    function formatRupiahInput(input) {
        let numberString = input.replace(/[^,\d]/g, '').toString(),
            split = numberString.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }

    function hanyaAngka(inputId,no) {
        let inputField = document.getElementById(inputId);
       
        let formattedValue = formatRupiahInput(inputField.value);
        inputField.value = formattedValue;
       
        // console.info("meta_row " + meta_row);
        $("#"+inputId).val(inputField.value);
        
    }
</script>