<!-- Required jquery and libraries -->
<script src="<?= base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
<script src="<?= base_url(); ?>assets/js/popper.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/bootstrap-5/dist/js/bootstrap.bundle.js"></script>


<!-- Customized jquery file  -->
<script src="<?= base_url(); ?>assets/js/main.js"></script>
<script src="<?= base_url(); ?>assets/js/color-scheme.js"></script>

<!-- date range picker -->
<script src="<?= base_url(); ?>assets/js/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/daterangepicker/daterangepicker.js"></script>

<!-- chosen script -->
<script src="<?= base_url(); ?>assets/vendor/chosen_v1.8.7/chosen.jquery.min.js"></script>

<!-- Chart js script -->
<script src="<?= base_url(); ?>assets/vendor/chart-js-3.3.1/chart.min.js"></script>

<!-- Progress circle js script -->
<script src="<?= base_url(); ?>assets/vendor/progressbar-js/progressbar.min.js"></script>

<!-- swiper js script -->
<script src="<?= base_url(); ?>assets/vendor/swiper-7.3.1/swiper-bundle.min.js"></script>

<!-- Simple lightbox script -->
<script src="<?= base_url(); ?>assets/js/simple-lightbox.jquery.min.js"></script>

<!-- app tour script-->
<script src="<?= base_url(); ?>assets/js/lib.js"></script>

<!-- data-table js -->
<script src="<?= base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.3.1/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/js/dataTables.bootstrap5.min.js"></script>

<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>

<!-- fancybox -->
<script src="<?php echo base_url() ?>assets/fancybox/jquery.fancybox.min.js"></script>

<!-- Pnotify -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/pnotify/js/pnotify.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/pnotify/js/pnotify.buttons.js"></script>

<!-- page level script -->
<script src="<?= base_url(); ?>assets/vendor/smartWizard/jquery.smartWizard.min.js"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/filepond/filepond-plugin-file-encode.min.js"></script>
<script src="<?= base_url(); ?>assets/filepond/filepond-plugin-file-validate-size.min.js"></script>
<script src="<?= base_url(); ?>assets/filepond/filepond-plugin-image-exif-orientation.min.js"></script>
<script src="<?= base_url(); ?>assets/filepond/filepond-plugin-image-preview.min.js"></script>
<script src="<?= base_url(); ?>assets/filepond/filepond.min.js"></script>
<script src="<?= base_url(); ?>assets/filepond/filepond-plugin-image-edit.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>

<!-- Include Bootstrap Timepicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>

<script>
    (function($) {
        $.fn.inputFilter = function(callback, errMsg) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop focusout", function(e) {
                if (callback(this.value)) {
                    // Accepted value
                    if (["keydown", "mousedown", "focusout"].indexOf(e.type) >= 0) {
                        $(this).removeClass("input-error");
                        this.setCustomValidity("");
                    }
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    // Rejected value - restore the previous one
                    $(this).addClass("input-error");
                    this.setCustomValidity(errMsg);
                    this.reportValidity();
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    // Rejected value - nothing to restore
                    this.value = "";
                }
            });
        };
    }(jQuery));

    function toggleSetuju() {
      var radioValue = document.querySelector('input[name="rd_status_user"]:checked').value;

      var selectedRadio = $('input[name="rd_status_user"]:checked');
      var application_id = selectedRadio.data('application_id');

      console.log(application_id);

      if (radioValue === '1') {
        $('#application_id_e').val(application_id);

        $('#modal_status_user').modal('show');
      } else {
        // $('#modal_status_user').modal('hide');
      }
    }

    function toggleTidak() {
      var radioValue = document.querySelector('input[name="rd_status_user"]:checked').value;

      var selectedRadio = $('input[name="rd_status_user"]:checked');
      var application_id = selectedRadio.data('application_id');

      console.log(application_id);

      if (radioValue === '0') {
        $('#application_id_e2').val(application_id);

        $('#modal_reject_user').modal('show');
      } else {
        // $('#modal_reject_user').modal('hide');
      }
    }

    function toggleHasil() {
        var radioValue = document.querySelector('input[name="rd_hasil_int"]:checked').value;

        var selectedRadio = $('input[name="rd_hasil_int"]:checked');
        var application_id = selectedRadio.data('application_id');

        console.log(application_id);

        $('#is_lolos_int').val(radioValue);
        $('#application_id_e3').val(application_id);

        var modalHeader = $('#modal_header');
        var confirmHeader = $('#confirm_header');

        modalHeader.removeClass('bg-primary bg-danger'); // Remove any existing classes
        confirmHeader.removeClass('bg-primary bg-danger'); // Remove any existing classes

        if (radioValue == 1) {
            modalHeader.addClass('bg-primary');
            confirmHeader.addClass('bg-primary');
        } else {
            modalHeader.addClass('bg-danger');
            confirmHeader.addClass('bg-danger');
        }

        var btn_hasil = $('#btn_hasil');
        var btn_confirm = $('#confirm_hasil');

        btn_hasil.removeClass('btn-primary btn-danger'); // Remove any existing classes
        btn_confirm.removeClass('btn-primary btn-danger'); // Remove any existing classes

        if (radioValue == 1) {
            btn_hasil.addClass('btn-primary');
            btn_confirm.addClass('btn-primary');
        } else {
            btn_hasil.addClass('btn-danger');
            btn_confirm.addClass('btn-danger');
        }

        $('#modal_alasan').modal('show');
    }


    // Running Datepicker
    $('.tanggal').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });


    $('#sama_dengan_ktp').on('change', function() {
        if ($(this).is(":checked")) {
            $('#alamat_saat_ini').val($('#alamat_ktp').val());
        } else {
            $('#alamat_saat_ini').val('');
        }
    });


    $(document).ready(function() {
        $(".only-nummber").inputFilter(function(value) {
            return /^\d*$/.test(value); // Allow digits only, using a RegExp
        }, "Hanya Boleh Angka");

        $('.only-alphabet').bind('keyup blur', function() {
            var node = $(this);
            node.val(node.val().replace(/[^a-z]/g, ''));
        });


        status = $('#status_interview').val();
        console.log('status=' + status);
        is_lolos = $('#is_lolos').val();

        $('.rejected').hide();
        $('.approved').hide();
        $('.hasil_interview').hide();

        if(status == null || status === undefined || status === ""){
            $('.rejected').hide();
            $('.approved').hide();
            $('.input_status').show();
            $('.input_hasil').hide();
        } else if(status == 1){
            $('.rejected').hide();
            $('.approved').show();
            $('.input_status').hide();
            $('.input_hasil').show();
        } else if(status == 0){
            $('.rejected').show();
            $('.approved').hide();
            $('.input_status').hide();
            $('.input_hasil').show();
        } else {
            $('.rejected').hide();
            $('.approved').hide();
            $('.input_status').show();
            $('.input_hasil').hide();
        }

        if(is_lolos == null || is_lolos === undefined || is_lolos === ""){
            $('.hasil_interview').hide();
        } else {
            $('.input_hasil').hide();
            $('.hasil_interview').show();
        } 

        // Running Datepicker
        $('#tgl_interview').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

        $('#jam_interview').timepicker({
            showInputs: false,
            minuteStep: 1,
            showMeridian: false,
            icons: 
            {
                up: 'fa fa-angle-up',
                down: 'fa fa-angle-down'
            }
        });

        $('#btn_setuju').on('click', function(){
            tgl_interview = $('input[name="tgl_interview"]').val();
            jam_interview = $('input[name="jam_interview"]').val();
            lokasi_interview = $('input[name="lokasi_interview"]').val();

            if (tgl_interview == ''){
                $('input[name="tgl_interview"]').focus();
            } else if (jam_interview == ''){
                $('input[name="jam_interview"]').focus();
            } else if (lokasi_interview == '') {
                $('input[name="lokasi_interview"]').focus();
            } else {
                $('#modal_confirm').modal('show');
            }
        });

        $('#btn_confirm').on('click', function(){
            form = $('#form_setuju_int');

            console.log(form.serialize());

            $.ajax({
                url: "<?= site_url('recruitment/interview/approve_status') ?>",
                type : "POST",
                data : form.serialize(),
                success : function(response){
                    $('#modal_confirm').modal('hide');

                    $('#modal_status_user').modal('hide');

                    // location.reload();
                    window.location.href = "https://trusmiverse.com/apps/recruitment/permintaan_karyawan";

                },
                error : function(response){
                    console.log('Error save data = '+response);
                }
            });
        });

        $('#btn_reject').on('click', function(){
            alasan = $('input[name="alasan"]').val();

            if (alasan == ''){
                $('input[name="alasan"]').focus();
            } else {
                $('#modal_reject').modal('show');
            }
        });

        $('#confirm_reject').on('click', function(){
            form = $('#form_reject_int');

            console.log(form.serialize());

            $.ajax({
                url: "<?= site_url('recruitment/interview/reject_status') ?>",
                type : "POST",
                data : form.serialize(),
                success : function(response){
                    $('#modal_reject').modal('hide');

                    $('#modal_reject_user').modal('hide');

                    // location.reload();
                    window.location.href = "https://trusmiverse.com/apps/recruitment/permintaan_karyawan";

                },
                error : function(response){
                    console.log('Error save data = '+response);
                }
            });
        });

        $('#btn_hasil').on('click', function(){
            alasan = $('input[name="alasan_hasil"]').val();

            if (alasan == ''){
                $('input[name="alasan_hasil"]').focus();
            } else {
                $('#modal_confirm_hasil').modal('show');
            }
        });

        $('#confirm_hasil').on('click', function(){
            form = $('#form_alasan');

            console.log(form.serialize());

            $.ajax({
                url: "<?= site_url('recruitment/interview/hasil_status') ?>",
                type : "POST",
                data : form.serialize(),
                success : function(response){
                    $('#modal_alasan').modal('hide');

                    $('#modal_confirm_hasil').modal('hide');

                    // location.reload();
                    window.location.href = "https://trusmiverse.com/apps/recruitment/permintaan_karyawan";

                },
                error : function(response){
                    console.log('Error save data = '+response);
                }
            });
        });

        employee_name = $('#employee_name').val();

        $('#dt_history').DataTable({
            "searching": false,
            "info": true,
            "paging": false,
            "destroy": true,
            // "dom": 'Bfrtip',
            "order": [
                [0, 'desc']
            ],
            // buttons: [{
            //     title: 'List Job Candidates',
            //     extend: 'excelHtml5',
            //     text: 'Export to Excel',
            //     footer: true
            // }],
            "ajax": {
                // "dataType": 'json',
                "method": "POST",
                "url": "<?= base_url(); ?>recruitment/interview/get_history",
                "data": {
                    name: employee_name
                },
                "dataSrc": "",
            },
            "columns": [
                {
                    'data': 'apply_at',
                },
                {
                    'data': 'job_title',
                },
                {
                    'data': 'application_status',
                    'render': function(data, type, row) {
                        status = '';
                        if (data == 3) {
                            status = '<span class="badge bg-primary">' + row['status_hasil'] + '</span>';
                        } else if (data == 6) {
                            status = '<span class="badge bg-danger">' + row['status_hasil'] + '</span>';
                        } else if (data == 5) {
                            status = '<span class="badge bg-warning">' + row['status_hasil'] + '</span>';
                        }
                        return status
                    },
                    'className': 'text-center'
                },
            ],
        });


    });


    $(".tgl").mask('0000-00-00')

    $("#file").on("change", function() {
        console.log($(this).val())
    });



    let options = {
        searchable: true
    }
    // let niceAgama = NiceSelect.bind(document.getElementById('nice-select-agama'), options);
    let niceKewarganegaraan = NiceSelect.bind(document.getElementById('nice-select-kewarganegaraan'), options);
    let niceStatus = NiceSelect.bind(document.getElementById('nice-select-status'), options);
    // let niceGender = NiceSelect.bind(document.getElementById('nice-select-gender'), options);

    $('.kondisi-status-menikah').hide();
    $('.kondisi-status-cerai').hide();
    $('#nice-select-status').on('change', function() {
        if ($(this).val() == "Married") {
            $('.kondisi-status-menikah').fadeIn();
            $('.kondisi-status-cerai').hide();
            $('#label_tempat_status').text('Tempat (Menikah)');
            $('#label_tgl_status').text('Tgl (Menikah)');
        } else if ($(this).val() == "Widowed" || $(this).val() == "Divorced or Separated") {
            $('.kondisi-status-menikah').hide();
            $('.kondisi-status-cerai').fadeIn();
        } else {
            $('.kondisi-status-cerai').hide();
            $('.kondisi-status-menikah').hide();
            $('#label_tempat_status').text('Tempat');
            $('#label_tgl_status').text('Tgl');
        }

        // adjust height tab
        $(".tab-content").height('100%');
    })
</script>
<script>
    $('#btn-finish-wizard').hide();
    'use strict'
    $(window).on('load', function() {
        $('#smartwizard').smartWizard({
            // selected: '0',
            justified: true,
            enableURLhash: true,
            transition: {
                animation: 'none', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
            },
            toolbarSettings: {
                toolbarPosition: 'bottom', // none, top, bottom, both
                toolbarButtonPosition: 'right', // left, right, center
                showNextButton: false, // show/hide a Next button
                showPreviousButton: false, // show/hide a Previous button
                toolbarExtraButtons: [] // Extra buttons to show on toolbar, array of jQuery input/buttons elements
            },
            lang: { // Language variables for button
                next: 'Next',
                previous: 'Previous'
            },
        });

        // Initialize the leaveStep event
        $("#smartwizard").on("leaveStep", function(e, anchorObject, stepIndex, nextStepIndex, stepDirection) {
            // navigate to next step
            // console.log('Navigated to stepIndex ' + stepIndex + ' moving in stepDirection ' + stepDirection);

            console.log($('.sw-next-btn').hasClass('disabled'))

            // check if current form step is valid
            var elmForm = $('#form-step-' + stepIndex);

            $(".tab-content").height('100%');
            return true;
        });
    });
</script>

<script>
    daftar_keluarga();

    function daftar_keluarga() {
        let apl_id = '<?= $ck['application_id']; ?>'
        var table = $('#dt_daftar_keluarga').DataTable({
            orderCellsTop: false,
            // fixedHeader: true,
            "searching": false,
            "info": false,
            "paging": false,
            "destroy": true,
            "ordering": false,
            "autoWidth": false,
            "order": [
                [0, 'desc']
            ],
            responsive: true,
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    application_id: apl_id
                },
                "url": "<?= base_url(); ?>fack/dt_daftar_keluarga",
            },
            "columns": [{
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                {
                    "data": "status",
                },
                {
                    "data": "nama",
                },
                {
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        return ``
                    },
                },
                {
                    "data": "jenis_kelamin",
                    "className": "d-none"
                },
                {
                    "data": "tempat_lahir",
                    "render": function(data, type, row, meta) {
                        return `${data}, ${row['tgl_lahir']}`
                    },
                    "className": "d-none"
                },
                {
                    "data": "pendidikan",
                    "className": "d-none"
                },
                {
                    "data": "pekerjaan",
                    "className": "d-none"
                },
                {
                    "data": "no_hp",
                    "className": "d-none"
                },
            ],
        });
    }

    // Add event listener for opening and closing details
    $('#dt_daftar_keluarga tbody').on('click', 'td.dt-control', function() {
        var tr = $(this).closest('tr');
        var row = $('#dt_daftar_keluarga').DataTable().row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(detail_keluarga(row.data())).show();
            tr.addClass('shown');
            $(".tab-content").height('100%');
        }
    });

    function detail_keluarga(d) {
        // `d` is the original data object for the row
        return (
            `<table class="table table-sm">
				<tr>
					<td><b>Jenis Kelamin</b></td>
					<td>${d.jenis_kelamin}</td>
				</tr>
				<tr>
					<td><b>Tempat, Tgl Lahir</b></td>
					<td>${d.tempat_lahir}, ${d.tgl_lahir}</td>
					</tr>
				<tr>
					<td><b>Pendidikan</b></td>
					<td>${d.pendidikan}</td>
				</tr>
				<tr>
					<td><b>Pekerjaan</b></td>
					<td>${d.pekerjaan}</td>
				</tr>
				<tr>
					<td><b>No. Telp</b></td>
					<td>${d.no_hp}</td>
				</tr>
       		 </table>`
        );
    }



    dt_daftar_pendidikan();

    function dt_daftar_pendidikan() {
        let apl_id = '<?= $ck['application_id']; ?>'
        var table = $('#dt_daftar_pendidikan').DataTable({
            orderCellsTop: false,
            // fixedHeader: true,
            "searching": false,
            "info": false,
            "paging": false,
            "destroy": true,
            "ordering": false,
            "autoWidth": false,
            "order": [
                [0, 'desc']
            ],
            responsive: true,
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    application_id: apl_id
                },
                "url": "<?= base_url(); ?>fack/dt_daftar_pendidikan",
            },
            "columns": [{
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                {
                    "data": "tingkat_pendidikan",
                },
                {
                    "data": "nama_instansi",
                },
                {
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        return ``
                    },
                },
                {
                    "data": "tempat",
                    "className": "d-none"
                },
                {
                    "data": "jurusan",
                    "render": function(data, type, row, meta) {
                        return `${row['jurusan']}`
                    },
                    "className": "d-none"
                },
                {
                    "data": "status_pendidikan",
                    "className": "d-none"
                },
                {
                    "data": "keterangan_nilai",
                    "className": "d-none"
                },
                {
                    "data": "tahun_masuk_keluar",
                    "className": "d-none"
                },
            ],
        });
    }

    // Add event listener for opening and closing details
    $('#dt_daftar_pendidikan tbody').on('click', 'td.dt-control', function() {
        var tr = $(this).closest('tr');
        var row = $('#dt_daftar_pendidikan').DataTable().row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(detail_pendidikan(row.data())).show();
            tr.addClass('shown');
            $(".tab-content").height('100%');
        }
    });

    function detail_pendidikan(d) {
        // `d` is the original data object for the row
        return (
            `<table class="table table-sm">
				<tr>
					<td><b>Tempat</b></td>
					<td>${d.tempat}</td>
				</tr>
				<tr>
					<td><b>Jurusan</b></td>
					<td>${d.jurusan}</td>
					</tr>
				<tr>
					<td><b>Status Pendidikan</b></td>
					<td>${d.status_pendidikan}</td>
				</tr>
				<tr>
					<td><b>Keterangan Nilai</b></td>
					<td>${d.keterangan_nilai}</td>
				</tr>
				<tr>
					<td><b>Tahun Masuk s/d Keluar</b></td>
					<td>${d.tahun_masuk_keluar}</td>
				</tr>
       		 </table>`
        );
    }



    dt_daftar_pengalaman_kerja();

    function dt_daftar_pengalaman_kerja() {
        let apl_id = '<?= $ck['application_id']; ?>'
        var table = $('#dt_daftar_pengalaman_kerja').DataTable({
            orderCellsTop: false,
            // fixedHeader: true,
            "searching": false,
            "info": false,
            "paging": false,
            "destroy": true,
            "ordering": false,
            "autoWidth": false,
            "order": [
                [0, 'desc']
            ],
            responsive: true,
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    application_id: apl_id
                },
                "url": "<?= base_url(); ?>fack/dt_daftar_pengalaman_kerja",
            },
            "columns": [{
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                {
                    "data": "nama_perusahaan",
                },
                {
                    "data": "posisi",
                },
                {
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        return ``
                    },
                },
                {
                    "data": "lokasi",
                    "className": "d-none"
                },
                {
                    "data": "tahun_masuk",
                    "render": function(data, type, row, meta) {
                        return `${row['tahun_masuk']} s/d ${row['tahun_keluar']}`
                    },
                    "className": "d-none"
                },
                {
                    "data": "salary_awal",
                    "className": "d-none"
                },
                {
                    "data": "salary_akhir",
                    "className": "d-none"
                },
                {
                    "data": "alasan_keluar",
                    "className": "d-none"
                },
            ],
        });
    }

    // Add event listener for opening and closing details
    $('#dt_daftar_pengalaman_kerja tbody').on('click', 'td.dt-control', function() {
        var tr = $(this).closest('tr');
        var row = $('#dt_daftar_pengalaman_kerja').DataTable().row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(detail_pengalaman_kerja(row.data())).show();
            tr.addClass('shown');
            $(".tab-content").height('100%');
        }
    });

    function detail_pengalaman_kerja(d) {
        // `d` is the original data object for the row
        return (
            `<table class="table table-sm">
            <tr>
                <td><b>Lokasi</b></td>
                <td>${d.lokasi}</td>
            </tr>
            <tr>
                <td><b>Tahun Masuk/Keluar</b></td>
                <td>${d.tahun_masuk} s/d ${d.tahun_keluar}</td>
                </tr>
            <tr>
                <td><b>Salary Awal</b></td>
                <td>${formatNumber(d.salary_awal)}</td>
            </tr>
            <tr>
                <td><b>Salary Akhir</b></td>
                <td>${formatNumber(d.salary_akhir)}</td>
            </tr>
            </table>`
        );
    }



    dt_daftar_pengalaman_organisasi();

    function dt_daftar_pengalaman_organisasi() {
        let apl_id = '<?= $ck['application_id']; ?>'
        var table = $('#dt_daftar_pengalaman_organisasi').DataTable({
            orderCellsTop: false,
            // fixedHeader: true,
            "searching": false,
            "info": false,
            "paging": false,
            "destroy": true,
            "ordering": false,
            "autoWidth": false,
            "order": [
                [0, 'desc']
            ],
            responsive: true,
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    application_id: apl_id
                },
                "url": "<?= base_url(); ?>fack/dt_daftar_pengalaman_organisasi",
            },
            "columns": [{
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                {
                    "data": "nama_organisasi",
                },
                {
                    "data": "posisi",
                },
                {
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        return ``
                    },
                },
                {
                    "data": "jenis_kegiatan",
                    "className": "d-none"
                },
                {
                    "data": "lokasi",
                    "className": "d-none"
                },
                {
                    "data": "masa_aktif",
                    "render": function(data, type, row, meta) {
                        return `${row['masa_aktif']}`
                    },
                    "className": "d-none"
                },
            ],
        });
    }

    // Add event listener for opening and closing details
    $('#dt_daftar_pengalaman_organisasi tbody').on('click', 'td.dt-control', function() {
        var tr = $(this).closest('tr');
        var row = $('#dt_daftar_pengalaman_organisasi').DataTable().row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(detail_pengalaman_organisasi(row.data())).show();
            tr.addClass('shown');
            $(".tab-content").height('100%');
        }
    });

    function detail_pengalaman_organisasi(d) {
        // `d` is the original data object for the row
        return (
            `<table class="table table-sm">
                <tr>
                    <td><b>Jenis Kegiatan</b></td>
                    <td>${d.jenis_kegiatan}</td>
                </tr>
                <tr>
                    <td><b>Masa Aktif</b></td>
                    <td>${d.lokasi}</td>
                    </tr>
                <tr>
                <tr>
                    <td><b>Masa Aktif</b></td>
                    <td>${d.masa_aktif}</td>
                </tr>
            </table>`
        );
    }



    dt_daftar_bahasa();

    function dt_daftar_bahasa() {
        let apl_id = '<?= $ck['application_id']; ?>'
        var table = $('#dt_daftar_bahasa').DataTable({
            orderCellsTop: false,
            // fixedHeader: true,
            "searching": false,
            "info": false,
            "paging": false,
            "destroy": true,
            "ordering": false,
            "autoWidth": false,
            "order": [
                [0, 'desc']
            ],
            responsive: true,
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    application_id: apl_id
                },
                "url": "<?= base_url(); ?>fack/dt_daftar_bahasa",
            },
            "columns": [{
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                {
                    "data": "bahasa",
                },
                {
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        return ``
                    },
                },
                {
                    "data": "lisan",
                    "className": "d-none"
                },
                {
                    "data": "tulisan",
                    "className": "d-none"
                },
            ],
        });
    }

    // Add event listener for opening and closing details
    $('#dt_daftar_bahasa tbody').on('click', 'td.dt-control', function() {
        var tr = $(this).closest('tr');
        var row = $('#dt_daftar_bahasa').DataTable().row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(detail_bahasa(row.data())).show();
            tr.addClass('shown');
            $(".tab-content").height('100%');
        }
    });

    function detail_bahasa(d) {
        // `d` is the original data object for the row
        return (
            `<table class="table table-sm">
                <tr>
                    <td><b>Lisan</b></td>
                    <td>${d.lisan}</td>
                </tr>
                <tr>
                    <td><b>Tulisan</b></td>
                    <td>${d.tulisan}</td>
                    </tr>
                <tr>
            </table>`
        );
    }

    $('#btn-add-bahasa').on('click', function() {
        let application_id = "<?= $ck['application_id'] ?? "" ?>"
        let employee_id = "<?= $ck['employee_id'] ?? "" ?>"
        $.confirm({
            title: 'Input Data Pengalaman Bahasa',
            type: 'blue',
            theme: 'material',
            columnClass: 'col-12 col-md-8 col-lg-8',
            content: `<form action="" id="form-fack-bahasa" class="formName">
                        <div class="row col-12 mb-3">
                            <div class="mb-3 col-12">
                                <input type="hidden" name="application_id_pengalaman_bahasa" id="application_id_pengalaman_bahasa" value="${application_id}" readonly>
                                <input type="hidden" name="employee_id_pengalaman_bahasa" id="employee_id_pengalaman_bahasa" value="${employee_id}" readonly>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="bahasa" class="form-label-custom required">Bahasa</label>
                                <input type="text" class="form-control border-custom bahasa" name="bahasa" id="bahasa" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="lisan" class="form-label-custom required">Lisan</label>
                                <select id="lisan" name="lisan" class="wide mb-3 lisan">
                                    <option value="1">Kurang</option>
                                    <option value="2">Cukup</option>
                                    <option value="3">Baik</option>
                                    <option value="4">Baik Sekali</option>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="tulisan" class="form-label-custom required">Tulisan</label>
                                <select id="tulisan" name="tulisan" class="wide mb-3 tulisan">
                                    <option value="1">Kurang</option>
                                    <option value="2">Cukup</option>
                                    <option value="3">Baik</option>
                                    <option value="4">Baik Sekali</option>
                                </select>                                
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                        </div>
					</form>`,
            buttons: {
                cancel: function() {
                    //close
                },
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function() {
                        let bahasa = this.$content.find('#bahasa').val();
                        if (!bahasa) {
                            $.alert('Anda belum mengisi bahasa');
                            return false;
                        }
                        let lisan = this.$content.find('#lisan').val();
                        if (!lisan) {
                            $.alert('Anda belum mengisi kolom lisan');
                            return false;
                        }
                        let tulisan = this.$content.find('#tulisan').val();
                        if (!tulisan) {
                            $.alert('Anda belum mengisi kolom tulisan');
                            return false;
                        }

                        $.confirm({
                            icon: 'fa fa-spinner fa-spin',
                            title: 'Mohon Tunggu!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Sedang memproses...',
                            buttons: {
                                close: {
                                    isHidden: true,
                                    actions: function() {}
                                },
                            },
                            onOpen: function() {
                                $.ajax({
                                    url: '<?= base_url() ?>fack/store_bahasa',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        application_id_bahasa: application_id,
                                        employee_id_bahasa: employee_id,
                                        bahasa: bahasa,
                                        lisan: lisan,
                                        tulisan: tulisan,
                                    },
                                    beforeSend: function() {

                                    },
                                    success: function(response) {},
                                    error: function(xhr) {},
                                    complete: function() {},
                                }).done(function(response) {
                                    console.log(response);
                                    if (response.status == true) {
                                        dt_daftar_bahasa();
                                        setTimeout(() => {
                                            $(".tab-content").height('100%');
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-check',
                                                title: 'Done!',
                                                theme: 'material',
                                                type: 'blue',
                                                content: 'Berhasil menyimpan bahasa!',
                                                buttons: {
                                                    close: {
                                                        actions: function() {}
                                                    },
                                                },
                                            });
                                        }, 250);
                                    } else {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-close',
                                            title: 'Oops!',
                                            theme: 'material',
                                            type: 'red',
                                            content: 'Gagal menyimpan bahasa!',
                                            buttons: {
                                                close: {
                                                    actions: function() {}
                                                },
                                            },
                                        });
                                    }
                                }).fail(function(jqXHR, textStatus) {
                                    setTimeout(() => {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-close',
                                            title: 'Oops!',
                                            theme: 'material',
                                            type: 'red',
                                            content: 'Gagal menyimpan bahasa!' + textStatus,
                                            buttons: {
                                                close: {
                                                    actions: function() {}
                                                },
                                            },
                                        });
                                    }, 250);
                                });
                            },

                        });
                    }
                },
            },
            onContentReady: function() {
                $(".tahun").mask('0000');
                let niceLisan = NiceSelect.bind(document.getElementById('lisan'), options);
                let niceTulisan = NiceSelect.bind(document.getElementById('tulisan'), options);
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function(e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    });



    dt_daftar_training();

    function dt_daftar_training() {
        let apl_id = '<?= $ck['application_id']; ?>'
        var table = $('#dt_daftar_training').DataTable({
            orderCellsTop: false,
            // fixedHeader: true,
            "searching": false,
            "info": false,
            "paging": false,
            "destroy": true,
            "ordering": false,
            "autoWidth": false,
            "order": [
                [0, 'desc']
            ],
            responsive: true,
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    application_id: apl_id
                },
                "url": "<?= base_url(); ?>fack/dt_daftar_training",
            },
            "columns": [{
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                {
                    "data": "jenis",
                },
                {
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        return ``
                    },
                },
                {
                    "data": "penyelenggara",
                    "className": "d-none"
                },
                {
                    "data": "tempat",
                    "className": "d-none"
                },
                {
                    "data": "tahun",
                    "className": "d-none"
                },
                {
                    "data": "dibiayai_oleh",
                    "className": "d-none"
                },
            ],
        });
    }

    // Add event listener for opening and closing details
    $('#dt_daftar_training tbody').on('click', 'td.dt-control', function() {
        var tr = $(this).closest('tr');
        var row = $('#dt_daftar_training').DataTable().row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(detail_training(row.data())).show();
            tr.addClass('shown');
            $(".tab-content").height('100%');
        }
    });

    function detail_training(d) {
        // `d` is the original data object for the row
        return (
            `<table class="table table-sm">
            <tr>
                <td><b>Penyelenggara</b></td>
                <td>${d.penyelenggara}</td>
            </tr>
            <tr>
                <td><b>Tempat</b></td>
                <td>${d.tempat}</td>
            </tr>
            <tr>
                <td><b>Tahun</b></td>
                <td>${d.tahun}</td>
             </tr>
            <tr>
                <td><b>Dibiayai Oleh</b></td>
                <td>${d.dibiayai_oleh}</td>
             </tr>
        </table>`
        );
    }



    dt_daftar_pekerjaan_favorit();

    function dt_daftar_pekerjaan_favorit() {
        let apl_id = '<?= $ck['application_id']; ?>'
        var table = $('#dt_daftar_pekerjaan_favorit').DataTable({
            orderCellsTop: false,
            // fixedHeader: true,
            "searching": false,
            "info": false,
            "paging": false,
            "destroy": true,
            "ordering": false,
            "autoWidth": false,
            "order": [
                [0, 'desc']
            ],
            responsive: true,
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    application_id: apl_id
                },
                "url": "<?= base_url(); ?>fack/dt_daftar_pekerjaan_favorit",
            },
            "columns": [{
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                {
                    "data": "posisi",
                },
                {
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        return ``
                    },
                },
                {
                    "data": "ekspektasi_gaji",
                    "className": "d-none"
                },
            ],
        });
    }

    // Add event listener for opening and closing details
    $('#dt_daftar_pekerjaan_favorit tbody').on('click', 'td.dt-control', function() {
        var tr = $(this).closest('tr');
        var row = $('#dt_daftar_pekerjaan_favorit').DataTable().row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(detail_pekerjaan_favorit(row.data())).show();
            tr.addClass('shown');
            $(".tab-content").height('100%');
        }
    });

    function detail_pekerjaan_favorit(d) {
        // `d` is the original data object for the row
        return (
            `<table class="table table-sm">
            <tr>
                <td><b>Ekspektasi Gaji</b></td>
                <td>${formatNumber(d.ekspektasi_gaji)}</td>
            </tr>
        </table>`
        );
    }



    dt_daftar_referensi();

    function dt_daftar_referensi() {
        let apl_id = '<?= $ck['application_id']; ?>'
        var table = $('#dt_daftar_referensi').DataTable({
            orderCellsTop: false,
            // fixedHeader: true,
            "searching": false,
            "info": false,
            "paging": false,
            "destroy": true,
            "ordering": false,
            "autoWidth": false,
            "order": [
                [0, 'desc']
            ],
            responsive: true,
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    application_id: apl_id
                },
                "url": "<?= base_url(); ?>fack/dt_daftar_referensi",
            },
            "columns": [{
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                {
                    "data": "nama",
                },
                {
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        return ``
                    },
                },
                {
                    "data": "jabatan",
                    "className": "d-none"
                },
                {
                    "data": "hubungan",
                    "className": "d-none"
                },
                {
                    "data": "no_hp",
                    "className": "d-none"
                },
            ],
        });
    }

    // Add event listener for opening and closing details
    $('#dt_daftar_referensi tbody').on('click', 'td.dt-control', function() {
        var tr = $(this).closest('tr');
        var row = $('#dt_daftar_referensi').DataTable().row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(detail_referensi(row.data())).show();
            tr.addClass('shown');
            $(".tab-content").height('100%');
        }
    });

    function detail_referensi(d) {
        // `d` is the original data object for the row
        return (
            `<table class="table table-sm">
            <tr>
                <td><b>Jabatan & Perusahaan</b></td>
                <td>${d.jabatan}</td>
            </tr>
            <tr>
                <td><b>Hubungan dgn Anda</b></td>
                <td>${d.hubungan}</td>
            </tr>
            <tr>
                <td><b>No. Telp/Hp</b></td>
                <td>${d.no_hp}</td>
            </tr>
        </table>`
        );
    }



    function formatNumber(num) {
        if (num == null) {
            return 0;
        } else {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        }
    }
</script>