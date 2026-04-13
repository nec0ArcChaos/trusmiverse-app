<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?= base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script src="<?= base_url() ?>assets/js/html2canvas.min.js"></script>
<script src="<?= base_url() ?>assets/js/html2canvas.js"></script>






<script>
    $(document).ready(function() {

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
            dt_fack(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'), '');
            $('#id_user').val('');
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



    });




    $('#resignation_date').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        autoclose: true
        // uiLibrary: 'bootstrap4'
    });

    function dt_fack(start, end, name) {
        let user_id = "<?= $this->session->userdata("user_id"); ?>";
        let user_role_id = "<?= $this->session->userdata("user_role_id"); ?>";

        // var table = $('#dt_trusmi_resignation').DataTable();


        var tabel = $('#dt_fack').DataTable({
            "searching": false,
            "info": true,
            "paging": true,
            "destroy": true,
            // "dom": 'Bfrtip',
            "order": [
                [1, 'desc']
            ],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": "<?= base_url(); ?>fack/dt_fack_card",
                "data": {
                    start: start,
                    end: end,
                    id_user: name,
                }
            },
            "columns": [{
                    "render": function(data, type, row, meta) {
                        status = `<input type="checkbox" name="id_user[]" id="id-${row.user_id}" value="${row.user_id}">`
                        status += `<label for="id-${row.id}"></label>`
                        return status
                    },
                },
                {
                    "data": "date_of_joining",
                    // "render": function(data, type, row) {
                    //     return `<?= date('d-m-Y', strtotime('${row.date_of_joining}')) ?>`
                    // },
                },
                {
                    "data": "job_title",
                },
                {
                    "data": "employee_name",
                },

                {
                    "data": "company_name",
                },
                {
                    "render": function(data, type, row, meta) {
                        var status = '';
                        if (row.user_id) {
                            if (!row.profile_picture) {
                                status = `<span class="badge bg-danger">No Image</span> `
                            } else if (row.is_printed == 1) {
                                status = `<span class="badge bg-success">Done</span> `
                            } else if (row.is_printed == 2) {
                                status = `<span class="badge bg-danger">Perlu Revisi</span> `
                            } else if (row.is_printed == 3) {
                                status = `<span class="badge bg-info">Direvisi</span> `
                            } else {
                                status = `<span class="badge bg-info">Waiting</span> `
                            }
                            status += ``

                            if (row.is_printed != 2) {
                                status += `
                                <a role="button" onclick="printID('${row.user_id}')" class="badge bg-success" style="cursor:pointer;"><i class="bi bi-printer"></i></a>

                                <a role="button"  onclick="downloadID('${row.user_id}')" class="badge bg-primary" style="cursor:pointer;"><i class="bi bi-download"></i></a>

                                <a role="button" onclick="revisiID('${row.user_id}')" class="badge bg-danger" alt="test" style="cursor:pointer;"><i class="bi bi-clipboard-x"></i></a>`
                            } else {
                                status += `
                                <a role="button" onclick="unrevisiID('${row.user_id}')" class="badge bg-success" style="cursor:pointer;"><i class="bi bi-clipboard-check"></i></a>`
                            }
                        } else {
                            status = `<span class="badge bg-danger">Non Active</span> `
                        }

                        return status
                    },
                },
            ],
            "createdRow": function(row, data, dataIndex) {
                // 
            }
        });
    }




    function printID(id) {
        var url = '<?= base_url('Fack/printIDCard') ?>/' + id;
        var windowName = 'popupWindow';
        var windowFeatures = 'width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes';

        var popupWindow = window.open(url, windowName, windowFeatures);
        // popupWindow.focus();
        setTimeout(() => {
            reloade();
        }, 2000)
    }

    // $('#form_id').on('submit', function(e) {
    //     e.preventDefault();
    //     var formData = $('#form_id').serializeArray();

    //     var url = '<?= base_url('Fack/printBatch') ?>';

    //     fetch(url, {
    //             method: 'POST',
    //             body: formData
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             var windowName = 'popupWindow';
    //             var windowFeatures = 'width=600,height=400,toolbar=no,location=no,menubar=no,scrollbars=yes,resizable=yes';

    //             var popupWindow = window.open('about:blank', windowName, windowFeatures);

    //             popupWindow.document.write('Response from server: ' + JSON.stringify(data));
    //             popupWindow.focus();
    //         })
    //         .catch(error => {
    //             console.error('Error:', error);
    //         });
    // })


    function cari() {
        var user = $('#id_user').val();
        var start = $('#start').val();
        var end = $('#end').val();
        dt_fack(start, end, user);
    }

    function downloadID(id) {
        $.ajax({
            type: 'GET',
            url: '<?= base_url('Fack/DownloadIDCard') ?>/' + id,
            success: function(response) {
                $('#modalContainer').html(response);
                $('#thisModal').modal('show');

                setTimeout(() => {
                    var targetElement = document.getElementById("cekrek");
                    takeScreenshot(targetElement, id)
                }, 1000)
                setTimeout(() => {
                    tutup()
                }, 2000)
            },
            error: function(e) {
                alert('Error')
            }
        });
    }

    function revisiID(id) {
        $.ajax({
            type: 'GET',
            url: '<?= base_url('Fack/isRevisi') ?>/' + id,
            success: function(response) {
                var a = JSON.parse(response)
                if (a.status == true) {
                    reloade()
                }
            },
            error: function(e) {
                alert('Error')

            }
        });
    }

    function unrevisiID(id) {
        $.ajax({
            type: 'GET',
            url: '<?= base_url('Fack/unRevisi') ?>/' + id,
            success: function(response) {
                var a = JSON.parse(response)
                if (a.status == true) {
                    reloade()
                }
            },
            error: function(e) {
                alert('Error')

            }
        });
    }

    function tutup() {
        $('#thisModal').modal('hide')
    }

    function reloade() {
        var user = $('#id_user').val();
        var start = $('#start').val();
        var end = $('#end').val();
        dt_fack(start, end, user);
    }

    function takeScreenshot(element, id) {
        html2canvas(element).then(function(canvas) {
            var screenshot = canvas.toDataURL("image/jpeg");
            // console.log(screenshot)
            var link = document.createElement("a");
            link.href = screenshot;
            link.download = "Foto-" + id + ".jpg";
            link.click();
        });
    }


    $(document).ready(function() {
        $('input').keypress(function(e) {
            if (e.which === 13) {
                e.preventDefault();
                var currentIndex = $('input').index(this);
                var totalInputs = $('input').length;
                var nextIndex = (currentIndex + 1) % totalInputs;
                $('input').eq(nextIndex).focus();
            }
        });
    });
</script>