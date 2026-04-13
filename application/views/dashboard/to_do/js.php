<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<!-- app tour script-->
<script src="<?= base_url(); ?>assets/vendor/Product-Tour-jQuery/lib.js"></script>

<!-- chart js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<!-- Datepicker -->
<script type="text/javascript" src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>

<!-- Fomantic Or Semantic Ui -->
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/dropdown.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/transition.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/form.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/popup.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/toast.js"></script>

<script>
    const baseUrl = "<?= base_url('dashboard_todo'); ?>";

    $(document).ready(function() {

    });

    function formatNumber(num, locale = 'id-ID', decimals = 2) {

        return parseFloat(num).toLocaleString(locale, {
            maximumFractionDigits: decimals
        });
    }

    $('#filter_pic').dropdown_se();
    $('#filter_category').dropdown_se();
</script>

<!-- Filter Pic -->
<script>
    get_filter_pic()

    function get_filter_pic() {
        $.ajax({
            url: '<?= base_url() ?>dashboard_todo/get_pic',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            list_pic_ticket = '';
            my_ticket_id = "<?= $this->session->userdata('user_id'); ?>";

            if (response.length < 1) {
                list_pic_ticket +=
                    `<option value="${parseInt(my_ticket_id)}" selected>My Task</option>`;

            } else {

                list_pic_ticket +=
                    `<option value="${parseInt(my_ticket_id)}" selected>My Task</option>`;

                for (let index = 0; index < response.length; index++) {
                    if (parseInt(response[index].user_id) != parseInt(my_ticket_id)) {
                        list_pic_ticket +=
                            `<option value="${response[index].user_id}">${response[index].full_name}</option>`;
                    }
                }
            }
            $("#filter_pic").empty().append(list_pic_ticket)
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get PIC Task")
        });
    }


    let filter_pic_element = document.getElementById("filter_pic");
    filter_pic_element.addEventListener("change", function() {
        // generate_progress_bar()
    });

    $('#filter_pic').change(function (e) { 
        e.preventDefault();
        var user_id = $(this).val();
        var category = $('#filter_category').val();
        const dateRanges = get_range();
        var yearMonth = $('#select_month :selected').val();
        load_data_todo(category, dateRanges.start_today, dateRanges.end_today, user_id, '#row_today');
        load_data_todo(category, dateRanges.start_besok, dateRanges.end_besok, user_id, '#row_besok');
        load_data_todo(category, dateRanges.start_coming, dateRanges.end_coming, user_id, '#row_coming');
        today_progress(user_id);
        lock_running(user_id);
        lock_history(user_id);
        fetchTaskData(yearMonth, user_id);
        fetchTaskPie(yearMonth, user_id);
    });
    $('#filter_category').change(function (e) { 
        e.preventDefault();
        var category = $(this).val();
        var user_id = $('#filter_pic').val();
        const dateRanges = get_range();
        load_data_todo(category, dateRanges.start_today, dateRanges.end_today, user_id, '#row_today');
        load_data_todo(category, dateRanges.start_besok, dateRanges.end_besok, user_id, '#row_besok');
        load_data_todo(category, dateRanges.start_coming, dateRanges.end_coming, user_id, '#row_coming');
    });
</script>
<!-- /Filter Pic -->

<?php $this->load->view('dashboard/to_do/js_baris1'); ?>
<?php $this->load->view('dashboard/to_do/js_nira_ai'); ?>
<?php $this->load->view('dashboard/to_do/js_baris2'); ?>
<?php $this->load->view('dashboard/to_do/js_baris3'); ?>