<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/clockpicker/jquery-clockpicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js" type="text/javascript"></script>

<script>
document.getElementById('btnSend').addEventListener('click', function () {

   

    const fd = new FormData();
    // fd.append('token', document.getElementById('token').value);
    const selected = document.getElementById('employees').selectedOptions;

    let tokens = [];

    for (let i = 0; i < selected.length; i++) {
        let token = selected[i].getAttribute('data-token');
        if (token) tokens.push(token);
    }

    fd.append('tokens', JSON.stringify(tokens));
    
    fd.append('title', document.getElementById('title').value);
    fd.append('body', document.getElementById('body').value);
    fd.append('trx_id', document.getElementById('trx_id').value);
    fd.append('nama_menu', document.getElementById('nama_menu').value);

    const fileInput = document.getElementById('file');
    if (fileInput.files.length > 0) {
        fd.append('file', fileInput.files[0]);
    }

    fetch('<?= site_url("push/send") ?>', {
        method: 'POST',
        body: fd
    })
    .then(res => res.json())
    .then(res => {
        document.getElementById('result').innerText =
            JSON.stringify(res, null, 2);
    })
    .catch(err => alert(err));
});
</script>
<script>
    
    $(document).ready(function() {

    //     //Datepicker
    //     var start = moment().startOf('month');
    //     var end = moment().endOf('month');

    //     $('#request_date').datepicker({
    //         autoclose: true,
    //         todayHighlight: true,
    //         format: "yyyy-mm-dd",
    //         "setDate": new Date(),
    //     });


    //     $('.clockpicker').clockpicker({
    //         donetext: 'Done',
    //         placement: 'bottom',
    //         autoclose: true,
    //         'default': '17:00'
    //     });

    //     function cb(start, end) {
    //         $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    //         $('input[name="start"]').val(start.format('YYYY-MM-DD'));
    //         $('input[name="end"]').val(end.format('YYYY-MM-DD'));
    //     }

    //     $('.range').daterangepicker({
    //         startDate: start,
    //         endDate: end,
    //         "drops": "down",
    //         ranges: {
    //             'Today': [moment(), moment()],
    //             'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    //             'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    //             'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    //             'This Month': [moment().startOf('month'), moment().endOf('month')],
    //             'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    //         }
    //     }, cb);

    //     cb(start, end);



        var hlp = new SlimSelect({
            select: '#employees',
            settings: {
                placeholderText: 'Select Employees',
            }
        });

        $('#employees').on('change', function () {

            const selected = document.getElementById('employees').selectedOptions;

            let tokens = [];

            for (let i = 0; i < selected.length; i++) {
                let token = selected[i].getAttribute('data-token');
                if (token) tokens.push(token);
            }

            // tampilkan ke input token
            document.getElementById('token').value = tokens.join(', ');
        });
        
    //     var hlp = new SlimSelect({
    //         select: '#department',
    //         settings: {
    //             placeholderText: 'Select Departments',
    //         }
    //     });


    }); // END :: Ready Function


</script>