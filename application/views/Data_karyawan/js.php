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

        var column = [{
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
                    if (row.profile_picture) {
                        var foto = `<a style="cursos: pointer;" data-fancybox data-src="http://trusmiverse.com/hr/uploads/profile/${row.profile_picture}" data-lightbox="1" data-caption="${row.employee_name} - ${row.job_title} - ${row.company_name}" class="foto_progres"><img style="width:40px; height:40px; border-radius: 50%; object-fit:cover"  src="http://trusmiverse.com/hr/uploads/profile/${row.profile_picture}" alt="" class="img-fluid img-thumbnail" /> </a>`;
                    } else {
                        var foto = '<div style="margin-left:15px"><i class="fa fa-question"></i></div>';
                    }

                    return foto
                },
            },
        ];


        var tabel = $('#dt_fack').DataTable({
            "searching": false,
            "info": true,
            "paging": true,
            "destroy": true,
            // "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
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
            "columns": column
        });
    }


    // function cekImage(image, nama) {
    //     var data = `
    //     <div width="100%" class="text-right  p-4">
    //     <a class="btn btn-sm float-end" onclick="tutup()"><i class="fa fa-times"></i></a>
    //     <h6 style="margin-top:5px">${nama.substring(0,20)} ${nama.length > 20 ? '...' : ''}</h6>
    //     </div>
    //     <div width="100%" class="text-center">
    //     <img style="width:250px;margin-bottom:20px" src="http://trusmiverse.com/hr/uploads/profile/${image}" alt="" />
    //     </div>
    //     `;
    //     $('#modalContainer').html(data);
    //     $('#thisModal').modal('show');
    // $.ajax({
    //     type: 'GET',
    //     url: '<?= base_url('Fack/DownloadIDCard') ?>/' + id,
    //     success: function(response) {
    //         $('#modalContainer').html(response);
    //         $('#thisModal').modal('show');

    //         setTimeout(() => {
    //             var targetElement = document.getElementById("cekrek");
    //             takeScreenshot(targetElement, id)
    //         }, 1000)
    //         setTimeout(() => {
    //             tutup()
    //         }, 2000)
    //     },
    //     error: function(e) {
    //         alert('Error')
    //     }
    // });
    // }


    function cari() {
        var user = $('#id_user').val();
        var start = $('#start').val();
        var end = $('#end').val();
        dt_fack(start, end, user);
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


    $(document).ready(function() {
        $('form input').keypress(function(e) {
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