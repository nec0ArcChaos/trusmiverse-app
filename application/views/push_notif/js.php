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
    $(document).ready(function() {

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        $('#request_date').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: "yyyy-mm-dd",
            "setDate": new Date(),
        });


        $('.clockpicker').clockpicker({
            donetext: 'Done',
            placement: 'bottom',
            autoclose: true,
            'default': '17:00'
        });

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

        let selectReason = new SlimSelect({
            select: '#reason',
            settings: {
                placeholderText: 'Reason ?',
            }
        });

        
        $('#resignation_date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            // uiLibrary: 'bootstrap4'
        });


        var hlp = new SlimSelect({
            select: '#employees',
            settings: {
                placeholderText: 'Select Employees',
            }
        });
        
        var hlp = new SlimSelect({
            select: '#department',
            settings: {
                placeholderText: 'Select Departments',
            }
        });


    }); // END :: Ready Function

    
    function send_to_multiple(){
        title = $('#title').val();
        body = $('#body').val();
        fcmToken = $('#employees').val();
        created_at = "<?= date('Y-m-d H:i:s') ?>";
        created_by = "<?= $_SESSION['user_id'] ?>";
        
        user_ids = [];
        var employees = $('#employees option:selected');
        employees.each(function(index, option) {
        var dataValue = $(option).data('user_id');
            user_ids.push(dataValue);
        });

        user_id = user_ids.join(",");

        data_notif = {
            // 'name': name,
            // 'userId': userId,
            'title': title,
            'body': body,
            'fcmToken' : fcmToken,
            'user_id' : user_id,
            'created_at' : created_at,
            'created_by' : created_by,
        };

        $.ajax({
            'url' : 'http://192.168.23.23:3000/send_to_multiple',
            'type' : 'POST',
            'contentType': "application/json; charset=utf-8",
            'data' : JSON.stringify(data_notif),
            success : function(response){
                console.info(`success`)
                console.info(response)
                success_alert(`${response.message}`)
            },
            error : function(err){
                console.info(`error`)
                console.info(err.responseText)
                error_alert(`${err.responseText}`)
            }
        })
    }
    
    function send_to_topic(){
        title = $('#topic_title').val();
        body = $('#topic_body').val();
        topic = $('#department').val();

        department_ids = [];
        var department = $('#department option:selected');
        department.each(function(index, option) {
        var dataValue = $(option).data('department_id');
            department_ids.push(dataValue);
        });

        department_ids = department_ids.join(",");

        
        created_at = "<?= date('Y-m-d H:i:s') ?>";
        created_by = "<?= $_SESSION['user_id'] ?>";

        // console.info(title);
        // console.info(body);
        // console.info(topic);


        data_notif = {
            'title': title,
            'body': body,
            'topic' : topic,
            'deptId' : department_ids,
            'created_at' : created_at,
            'created_by' : created_by,
        };

        $.ajax({
            'url' : 'http://192.168.23.23:3000/send_to_topic',
            'type' : 'POST',
            'contentType': "application/json; charset=utf-8",
            'data' : JSON.stringify(data_notif),
            success : function(response){
                console.info(`success`)
                console.info(response)
                success_alert(`${response.message}`)
            },
            error : function(err){
                console.info(`error`)
                console.info(err.responseText)
                error_alert(`${err.responseText}`)
            }
        })
    }



    function success_alert(text) {
        textMsg = text == null ? '' : text;
        new PNotify({
            title: `Success`,
            text: `${textMsg}`,
            icon: 'icofont icofont-checked',
            type: 'success',
            delay: 1500,
        });
    }

    function error_alert(text) {
        new PNotify({
            title: `Oopss`,
            text: `${text}`,
            icon: 'icofont icofont-info-circle',
            type: 'error',
            delay: 1500,
        });
    }
</script>