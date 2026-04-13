<!-- Required Jquery -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery/js/jquery.min.js"></script> -->
<!-- Autocomplete -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/autocomplete.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap/js/bootstrap.min.js"></script> -->
<!-- jquery slimscroll js -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script> -->
<!-- data-table js -->
<!-- <script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script> -->
<!-- i18next.min.js -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/advance-elements/moment-with-locales.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script> -->
<!-- Date-range picker js -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap-daterangepicker/js/daterangepicker.js"></script>

<script src="<?php echo base_url(); ?>assets/js/pcoded.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/demo-12.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/script.js"></script> -->
<!-- Datatable Button -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script> -->

<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>

<!-- view images -->
<!-- <script type="text/javascript" src="<?= base_url('assets/fancybox/jquery.fancybox.min.js') ?>"></script> -->

<!-- slim select js -->
<!-- <script src="<?php echo base_url(); ?>assets/js/slimselect.min.js"></script> -->
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>

<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>

<!-- Datetimepicker Full -->
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>

<!-- Summer Note css/js -->
<link href="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.css" rel="stylesheet">
<script src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>

<!-- SmartWizard css/js -->
<!-- <link href="<?= base_url(); ?>assets/vendor/smartWizard5/smart_wizard_all.min.css" rel="stylesheet"> -->
<!-- <script src="<?= base_url(); ?>assets/vendor/smartWizard/jquery.smartWizard.min.js"></script>  -->

<!-- SmartWizard6 -->
<!-- <link href="<?= base_url(); ?>assets/vendor/smartWizard6/css/smart_wizard_all.min.css" rel="stylesheet"> -->
<script src="<?= base_url(); ?>assets/vendor/smartWizard6/js/jquery.smartWizard.min.js"></script>

<!-- Jquery Confirm -->
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>

<!-- Font Awesome -->
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script type="text/javascript">
  let id_project = NiceSelect.bind(document.getElementById('project'), {
    searchable: true
  });
  let id_pekerjaan = NiceSelect.bind(document.getElementById('pekerjaan'), {
    searchable: true
  });
  let id_sub_pekerjaan = NiceSelect.bind(document.getElementById('sub_pekerjaan'), {
    searchable: true
  });
  let id_detail_pekerjaan = NiceSelect.bind(document.getElementById('detail_pekerjaan'), {
    searchable: true
  });
  $(document).ready(function() {

    // Disable Scroll in Date
    $('#tanggal').bind("mousewheel", function() {
      return false;
    });
    $('#tanggal_draft').bind("mousewheel", function() {
      return false;
    });

    // Kategori yang muncul deadline
    var kat_deadline = [1, 5, 6, 8, 9, 10, 11, 12];

    // Level yang disable deadline
    var lvl_deadline = [1, 2, 3, 4];



    // Untuk Add Notulen
    $('#smartwizard2').smartWizard({
      // selected: '3',
      theme: "default",
      enableURLhash: true,
      transition: {
        animation: 'none', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
      },
      toolbar: {
        showNextButton: true, // show/hide a Next button
        showPreviousButton: true, // show/hide a Previous button
        position: 'top', // none|top|bottom|both
        extraHtml: ''
      },
      keyboard: {
        keyNavigation: false // Enable/Disable keyboard navigation(left and right keys are used if enabled)
      },
      lang: { // Language variables for button
        next: 'Next',
        previous: 'Previous'
      },
    });

    $('.tanggal').datetimepicker({
      format: 'Y-m-d',
      timepicker: false,
      minDate: 0,
    });

    $('.tanggal_plan').datetimepicker({
      format: 'Y-m-d H:i',
      minDate: 0,
    });

    // $('#tanggal').datetimepicker({
    //     format: 'Y-m-d',
    //     timepicker: false,
    //     maxDate: 0,
    // });

    // $('#tanggal_draft').datetimepicker({
    //     format: 'Y-m-d',
    //     timepicker: false,
    //     maxDate: 0,
    // });

    $('.waktu').datetimepicker({
      format: 'H:i',
      datepicker: false,
      timepicker: true,
      minDate: 0,
    });

    peserta = new SlimSelect({
      select: "#peserta"
    });

    peserta_plan = new SlimSelect({
      select: "#peserta_plan"
    });

    department = new SlimSelect({
      select: "#department"
    });

    department_plan = new SlimSelect({
      select: "#department_plan"
    });

    // project = new SlimSelect({
    //   select: "#project",
    //   dropdownParent: document.getElementById('modal_add_mom')
    // });

    // pekerjaan = new SlimSelect({
    //   select: "#pekerjaan",
    //   dropdownParent: document.getElementById('modal_add_mom')
    // });

    // sub_pekerjaan = new SlimSelect({
    //   select: "#sub_pekerjaan",
    //   dropdownParent: document.getElementById('modal_add_mom')
    // });

    // detail_pekerjaan = new SlimSelect({
    //   select: "#detail_pekerjaan",
    //   dropdownParent: document.getElementById('modal_add_mom')
    // });
    // e_project = new SlimSelect({
    //   select: "#e_project",
    //   dropdownParent: document.getElementById('modal_add_mom')
    // });

    // e_pekerjaan = new SlimSelect({
    //   select: "#e_pekerjaan",
    //   dropdownParent: document.getElementById('modal_add_mom')
    // });

    // e_sub_pekerjaan = new SlimSelect({
    //   select: "#e_sub_pekerjaan",
    //   dropdownParent: document.getElementById('modal_add_mom')
    // });

    // e_detail_pekerjaan = new SlimSelect({
    //   select: "#e_detail_pekerjaan",
    //   dropdownParent: document.getElementById('modal_add_mom')
    // });

    $("#department").change(function() {
      dp = $("#department").val().toString().split(",");
      $("#list_department").val(dp);
    });

    $("#department_plan").change(function() {
      dp = $("#department_plan").val().toString().split(",");
      $("#list_department_plan").val(dp);
    });

    $("#meeting_plan").change(function() {
      jenis_meeting_plan = $("#meeting_plan").val();
      // console.log(jenis_meeting_plan);
      if (jenis_meeting_plan == "Owner") {
        $(".hidden_department_plan").addClass('d-none');
      } else {
        $(".hidden_department_plan").removeClass('d-none');
      }
    });

    $("#peserta_plan").change(function() {
      user = $("#peserta_plan").val().toString().split(",");
      $("#user_plan").val(user);
    });
    $("#detail_pekerjaan").change(function() {
      dp = $("#detail_pekerjaan").val().toString().split(",");
      $("#list_det_pekerjaan").val(dp);
    });
    $("#e_detail_pekerjaan").change(function() {
      dp = $("#e_detail_pekerjaan").val().toString().split(",");
      $("#e_list_det_pekerjaan").val(dp);
    });

    pic = new SlimSelect({
      select: ".pic"
    });

    $('#pembahasan').summernote({
      placeholder: '...',
      tabsize: 2,
      height: 150,
      toolbar: [
        ['font', ['bold', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
      ]
    });

    $('#closing').summernote({
      placeholder: '...',
      tabsize: 2,
      height: 150,
      toolbar: [
        ['font', ['bold', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
      ]
    });

    // Draft
    $('#smartwizard3').smartWizard({
      // selected: '3',
      theme: "default",
      enableURLhash: true,
      transition: {
        animation: 'none', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
      },
      toolbar: {
        showNextButton: true, // show/hide a Next button
        showPreviousButton: true, // show/hide a Previous button
        position: 'top', // none|top|bottom|both
        extraHtml: ''
      },
      lang: { // Language variables for button
        next: 'Next',
        previous: 'Previous'
      },
    });

    peserta_draft = new SlimSelect({
      select: "#peserta_draft"
    });

    pic_draft = new SlimSelect({
      select: ".pic_draft"
    });

    department_draft = new SlimSelect({
      select: "#department_draft"
    });

    $("#department_draft").change(function() {
      dp = $("#department_draft").val().toString().split(",");
      $("#list_department_draft").val(dp);
    });

    $('#pembahasan_draft').summernote({
      placeholder: '...',
      tabsize: 2,
      height: 150,
      toolbar: [
        ['font', ['bold', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
      ]
    });

    $('#closing_draft').summernote({
      placeholder: '...',
      tabsize: 2,
      height: 150,
      toolbar: [
        ['font', ['bold', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
      ]
    });
    // End Draft

    // get_list_mom('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');
    // get_list_rekap('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');

    /*Range*/
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
      $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="start"]').val(start.format('YYYY-MM-DD'));
      $('input[name="end"]').val(end.format('YYYY-MM-DD'));
      get_list_mom(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
      get_list_rekap(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
      generate_head_resume_v3(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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

    // function cb_draft(start, end) {
    //   $('.reportrange_draft input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    //   $('input[name="start_draft"]').val(start.format('YYYY-MM-DD'));
    //   $('input[name="end_draft"]').val(end.format('YYYY-MM-DD'));
    //   list_draft(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
    // }

    // $('.range_draft').daterangepicker({
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
    // }, cb_draft);

    // cb_draft(start, end);

    $("#meeting").change(function() {
      jenis_meeting = $("#meeting").val();
      // console.log(jenis_meeting);
      if (jenis_meeting == "Owner") {
        $(".hidden_department").addClass('d-none');
      } else {
        $(".hidden_department").removeClass('d-none');
      }
    });

    $("#peserta").change(function() {
      user = $("#peserta").val().toString().split(",");
      $("#user").val(user);
    });

    $("#smartwizard2").on("leaveStep", function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
      // console.log(e.key, anchorObject, currentStepIndex, nextStepIndex, stepDirection);
      // Save Data Detail
      console.log(nextStepIndex);
      if (nextStepIndex == 1 && stepDirection == "forward") {
        console.log('di smart wizard2');


        var list_dep = [];
        if ($("#list_department").val() != "") {
          list_dep = $("#list_department").val().split(",");
        }
        // console.log(list_dep);

        if ($("#judul").val() == "") {
          $(".judul").removeClass('is-valid');
          $(".judul").addClass('is-invalid');
          $("#judul").focus();
          return false;
        } else if ($("#tempat").val() == "") {
          $(".tempat").removeClass('is-valid');
          $(".tempat").addClass('is-invalid');
          $("#tempat").focus();
          return false;
        } else if ($("#tanggal").val() == "") {
          $(".tgl").removeClass('is-valid');
          $(".tgl").addClass('is-invalid');
          $("#tanggal").focus();
          return false;
        } else if ($("#start_time").val() == "") {
          $(".start").removeClass('is-valid');
          $(".start").addClass('is-invalid');
          $("#start_time").focus();
          return false;
        } else if ($("#end_time").val() == "") {
          $(".end").removeClass('is-valid');
          $(".end").addClass('is-invalid');
          $("#end_time").focus();
          return false;
        } else if ($("#meeting :selected").val() == "") {
          $(".meeting").removeClass('is-valid');
          $(".meeting").addClass('is-invalid');
          $("#meeting").focus();
          return false;
        } else if ($("#list_department").val() == "" && ($("#meeting :selected").val() == "Internal" || $("#meeting :selected").val() == "Koordinasi")) {
          $(".department").removeClass('is-valid');
          $(".department").addClass('is-invalid');
          department.open();
          return false;
        } else if ($("#user").val() == "") {
          $(".peserta").removeClass('is-valid');
          $(".peserta").addClass('is-invalid');
          peserta.open();
          return false;
        } else if ($('#btn_show_pekerjaan').hasClass('bi-check-square') && $('#project').val() == '-- Choose Project --') {
          $(".project").removeClass('is-valid');
          $(".project").addClass('is-invalid');
          project.open();
          return false;
        } else if ($('#btn_show_pekerjaan').hasClass('bi-check-square') && ($('#pekerjaan').val() == '-- Choose Pekerjaan --' || $('#pekerjaan').val() == '')) {
          $(".pekerjaan").removeClass('is-valid');
          $(".pekerjaan").addClass('is-invalid');
          pekerjaan.open();
          return false;
        } else if ($('#btn_show_pekerjaan').hasClass('bi-check-square') && ($('#sub_pekerjaan').val() == null || $('#sub_pekerjaan').val() == '')) {
          $(".sub_pekerjaan").removeClass('is-valid');
          $(".sub_pekerjaan").addClass('is-invalid');
          sub_pekerjaan.open();
          return false;
        } else if ($('#btn_show_pekerjaan').hasClass('bi-check-square') && $('#list_det_pekerjaan').val() == '') {
          $(".detail_pekerjaan").removeClass('is-valid');
          $(".detail_pekerjaan").addClass('is-invalid');
          detail_pekerjaan.open();
          return false;
        } else if ($("#agenda").val() == "") {
          $(".agenda").removeClass('is-valid');
          $(".agenda").addClass('is-invalid');
          $("#agenda").focus();
          return false;
        } else if ($("#pembahasan").val() == "" || $("#pembahasan").val() == '<p><br></p>' || $("#pembahasan").val() == '<br>') {
          $(".pembahasan").removeClass('is-valid');
          $(".pembahasan").addClass('is-invalid');
          swal("Warning", "Pembahasan belum terisi", "info");
          return false;
        } else {
          $.ajax({
            method: "POST",
            url: "<?= base_url("mom/save_mom") ?>",
            dataType: "JSON",
            data: $("#form_detail").serialize(),
            beforeSend: function(res) {
              // $('.sw-btn-next').attr("disabled",true);  
            },
            success: function(res) {
              // console.log(res);
              if ($("#id_mom_global").val() == "") {
                $('#id_mom').val(res.data.id_mom);
                $('#id_mom_global').val(res.data.id_mom);
              }

              $('.div_ekspektasi').show();

              // DIV EKSPEKTASI
              // $('#id_meeting').val(res.data.meeting);
              // console.log(res.data.meeting);
              // if (res.data.meeting == "Owner") {
              //   $('.div_ekspektasi').show();
              // } else {
              //   $('.div_ekspektasi').hide();
              // }
              // DIV EKSPEKTASI


              $("#dt_list_mom").DataTable().ajax.reload();
              return true;
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(jqXHR.responseText);
              return false;
            }
          });
        }
      }

      if (nextStepIndex == 2 && stepDirection == "forward") {
        $("#btn_finish").show();
        $.ajax({
          "url": "<?= base_url('mom/check_validasi_result/') ?>" + $("#id_mom_global").val(),
          "type": "GET",
          "dataType": 'JSON',
          "success": function(res) {
            // console.log(res);    
            if (!res.eksekusi) {
              $("#btn_finish").hide();
              swal("Warning", `${res.warning}`, "error");
              $('#smartwizard2').smartWizard("prev");
            }
          },
          "error": function(jqXHR) {
            console.log(jqXHR);
            console.log(jqXHR.responseText);
          }
        });
      } else {
        $("#btn_finish").hide();
      }
    });

    $("#judul").keyup(function() {
      $(".judul").removeClass('is-invalid');
      $(".judul").addClass('is-valid');
    });

    $("#tempat").keyup(function() {
      $(".tempat").removeClass('is-invalid');
      $(".tempat").addClass('is-valid');
    });

    $("#tanggal").change(function() {
      $(".tgl").removeClass('is-invalid');
      $(".tgl").addClass('is-valid');
    });

    $("#start_time").change(function() {
      $(".start").removeClass('is-invalid');
      $(".start").addClass('is-valid');
    });

    $("#end_time").change(function() {
      $(".end").removeClass('is-invalid');
      $(".end").addClass('is-valid');
    });

    $("#meeting").change(function() {
      $(".meeting").removeClass('is-invalid');
      $(".meeting").addClass('is-valid');
    });

    $("#department").change(function() {
      $(".department").removeClass('is-invalid');
      $(".department").addClass('is-valid');
    });

    $("#agenda").keyup(function() {
      $(".agenda").removeClass('is-invalid');
      $(".agenda").addClass('is-valid');
    });

    $("#peserta").change(function() {
      $(".peserta").removeClass('is-invalid');
      $(".peserta").addClass('is-valid');
    });

    $("#pembahasan").change(function() {
      $(".pembahasan").removeClass('is-invalid');
      $(".pembahasan").addClass('is-valid');
    });

    $("#closing").change(function() {
      $(".closing").removeClass('is-invalid');
      $(".closing").addClass('is-valid');
    });

    // Tab Result
    $('#dt_mom_result').on('click', '.kolom_modif', function() {
      id = $(this).data("id");
      input = id.split('_');
      $('#td_' + id).addClass('padding_0');
      $('#' + id).hide();

      if (input[0] == 'deadline' && $.inArray(parseInt($('#val_kategori_' + input[1] + '_' + input[2]).val()), kat_deadline) != -1) {
        if ($.inArray(parseInt($('#val_level_' + input[1] + '_' + input[2]).val()), lvl_deadline) != -1) {
          $('#val_' + id).hide();
          $('#val_date_' + id).hide();
          $('#' + id).show();
        } else {
          $('#val_date_' + id).show().focus();
          $('#val_' + id).hide();
        }
      } else if (input[0] == 'level' && $.inArray(parseInt($('#val_kategori_' + input[1] + '_' + input[2]).val()), kat_deadline) != -1) {
        $('#val_' + id).show().focus();
      } else if (input[0] == 'ekspektasi') {
        // if ($('#val_kategori_' + input[1] + '_' + input[2]).val() == 1) {
        $('#val_' + id).show().focus();
        // } else {
        //   $('#val_' + id).hide();
        // }
      } else if ($('#val_kategori_' + input[1] + '_' + input[2]).val() == 12) {
        $('#val_grdsi_' + input[1] + '_' + input[2]).show();
      } else {
        $('#val_' + id).show().focus();
        $('#val_date_' + id).hide();
        if ($.inArray(parseInt($('#val_kategori_' + input[1] + '_' + input[2]).val()), kat_deadline) == -1) {
          $('#val_level_' + input[1] + '_' + input[2]).hide();
          $('#val_date_deadline_' + input[1] + '_' + input[2]).val("");
          // $('#'+input[1]+'_'+input[2]).val("");
          $('#deadline_' + input[1] + '_' + input[2]).text("");
          $('#val_level_' + input[1] + '_' + input[2]).val("");
        } else {
          $('#val_level_' + input[1] + '_' + input[2]).show();
        }

        // Selain Tasklist GRD Maka Sembunyikan
        if ($('#val_kategori_' + input[1] + '_' + input[2]).val() != 12) {
          $('#val_grdsi_' + input[1] + '_' + input[2]).hide();
        }
      }

      // Tasklist GRD
      if ($('#val_kategori_' + input[1] + '_' + input[2]).val() == 12) {
        $('#val_' + id).show().focus();
      } else if ($('#val_kategori_' + input[1] + '_' + input[2]).val() == 1) {
        $('#val_grdsi_' + input[1] + '_' + input[2]).hide();
      }
    });

    $('#dt_mom_result_draft').on('click', '.kolom_modif', function() {
      id = $(this).data("id");
      input = id.split('_');
      $('#td_' + id).addClass('padding_0');
      $('#' + id).hide();

      // if (input[0] == 'deadline' && $('#val_kategori_draft_'+input[2]+'_'+input[3]).val() == 1) {
      if (input[0] == 'deadline' && $.inArray(parseInt($('#val_kategori_draft_' + input[2] + '_' + input[3]).val()), kat_deadline) != -1) {
        if ($.inArray(parseInt($('#val_level_draft_' + input[2] + '_' + input[3]).val()), lvl_deadline) != -1) {
          $('#val_' + id).hide();
          $('#val_date_' + id).hide();
          $('#' + id).show();
        } else {
          $('#val_date_' + id).show().focus();
          $('#val_' + id).hide();
        }
      } else if (input[0] == 'level' && $.inArray(parseInt($('#val_kategori_draft_' + input[2] + '_' + input[3]).val()), kat_deadline) != -1) {
        $('#val_' + id).show().focus();
      } else if (input[0] == 'ekspektasi') {
        // if ($('#val_kategori_draft_' + input[2] + '_' + input[3]).val() == 1) {
        $('#val_' + id).show().focus();
        // } else {
        // $('#val_' + id).hide();
        // }
      } else if ($('#val_kategori_draft_' + input[2] + '_' + input[3]).val() == 12) {
        $('#val_grdsi_draft_' + input[2] + '_' + input[3]).show();
      } else {
        $('#val_' + id).show().focus();
        $('#val_date_' + id).hide();
        if ($.inArray(parseInt($('#val_kategori_draft_' + input[2] + '_' + input[3]).val()), kat_deadline) == -1) {
          $('#val_level_draft_' + input[2] + '_' + input[3]).hide();
          $('#val_date_deadline_draft_' + input[2] + '_' + input[3]).val("");
          // $('#'+input[2]+'_'+input[3]).val("");
          $('#deadline_draft_' + input[2] + '_' + input[3]).text("");
          $('#val_level_draft_' + input[2] + '_' + input[3]).val("");
        } else {
          $('#val_level_draft_' + input[2] + '_' + input[3]).show();
        }

        // Selain Tasklist GRD Maka Sembunyikan
        if ($('#val_kategori_draft_' + input[2] + '_' + input[3]).val() != 12) {
          $('#val_grdsi_draft_' + input[2] + '_' + input[3]).hide();
        }
      }

      // Tasklist GRD
      if ($('#val_kategori_draft_' + input[2] + '_' + input[3]).val() == 12) {
        $('#val_' + id).show().focus();
      } else if ($('#val_kategori_draft_' + input[2] + '_' + input[3]).val() == 1) {
        $('#val_grdsi_draft_' + input[2] + '_' + input[3]).hide();
      }
    });
    // End Tab Result

    // Draft

    $("#meeting_draft").change(function() {
      jenis_meeting_draft = $("#meeting_draft").val();
      if (jenis_meeting_draft == "Owner") {
        $(".hidden_department_draft").addClass('d-none');
      } else {
        $(".hidden_department_draft").removeClass('d-none');
      }
    });

    $("#peserta_draft").change(function() {
      user_e = $("#peserta_draft").val().toString().split(",");
      $("#user_draft").val(user_e);
    });

    $("#smartwizard3").on("leaveStep", function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
      // console.log(currentStepIndex, nextStepIndex, stepDirection);  

      var list_dep_draft = [];
      if ($("#list_department_draft").val() != "") {
        list_dep_draft = $("#list_department_draft").val().split(",");
      }
      // console.log(list_dep_draft);

      // Save Data Detail
      if (nextStepIndex == 1 && stepDirection == "forward") {
        if ($("#judul_draft").val() == "") {
          $(".judul_draft").removeClass('is-valid');
          $(".judul_draft").addClass('is-invalid');
          $("#judul_draft").focus();
          return false;
        } else if ($("#tempat_draft").val() == "") {
          $(".tempat_draft").removeClass('is-valid');
          $(".tempat_draft").addClass('is-invalid');
          $("#tempat_draft").focus();
          return false;
        } else if ($("#tanggal_draft").val() == "" || $("#tanggal_draft").val() == "0000-00-00") {
          $(".tgl_draft").removeClass('is-valid');
          $(".tgl_draft").addClass('is-invalid');
          $("#tanggal_draft").focus();
          return false;
        } else if ($("#start_time_draft").val() == "" || $("#start_time_draft").val() == "00:00") {
          $(".start_draft").removeClass('is-valid');
          $(".start_draft").addClass('is-invalid');
          $("#start_time_draft").focus();
          return false;
        } else if ($("#end_time_draft").val() == "" || $("#end_time_draft").val() == "00:00") {
          $(".end_draft").removeClass('is-valid');
          $(".end_draft").addClass('is-invalid');
          $("#end_time_draft").focus();
          return false;
        } else if ($("#meeting_draft :selected").val() == "") {
          $(".meeting_draft").removeClass('is-valid');
          $(".meeting_draft").addClass('is-invalid');
          $("#meeting_draft").focus();
          return false;
        } else if ($("#list_department_draft").val() == "" && ($("#meeting_draft :selected").val() == "Internal" || $("#meeting_draft :selected").val() == "Koordinasi")) {
          $(".department_draft").removeClass('is-valid');
          $(".department_draft").addClass('is-invalid');
          department_draft.open();
          return false;
        } else if (list_dep_draft.length > 1 && $("#meeting_draft :selected").val() == "Internal") {
          $(".department_draft").removeClass('is-valid');
          $(".department_draft").addClass('is-invalid');
          swal("Warning", "Meeting Internal untuk 1 Department", "info");
          department_draft.open();
          return false;
        } else if (list_dep_draft.length < 2 && $("#meeting_draft :selected").val() == "Koordinasi") {
          $(".department_draft").removeClass('is-valid');
          $(".department_draft").addClass('is-invalid');
          swal("Warning", "Meeting Koordinasi minimal 2 Department", "info");
          department_draft.open();
          return false;
        } else if ($("#agenda_draft").val() == "") {
          $(".agenda_draft").removeClass('is-valid');
          $(".agenda_draft").addClass('is-invalid');
          $("#agenda_draft").focus();
          return false;
        } else if ($("#user_draft").val() == "") {
          $(".peserta_draft").removeClass('is-valid');
          $(".peserta_draft").addClass('is-invalid');
          peserta_draft.open();
          return false;
        } else if ($("#pembahasan_draft").val() == "" || $("#pembahasan_draft").val() == '<p><br></p>' || $("#pembahasan_draft").val() == '<br>') {
          $(".pembahasan_draft").removeClass('is-valid');
          $(".pembahasan_draft").addClass('is-invalid');
          swal("Warning", "Pembahasan belum terisi", "info");
          return false;
        } else {
          $.ajax({
            method: "POST",
            url: "<?= base_url("mom/save_mom_draft") ?>",
            dataType: "JSON",
            data: $("#form_detail_draft").serialize(),
            beforeSend: function(res) {
              // $('.sw-btn-next').attr("disabled",true);  
            },
            success: function(res) {
              console.log(res);
              console.log($("#id_mom_global_draft").val());
              get_issue_result($("#id_mom_global_draft").val());
              $("#dt_list_draft").DataTable().ajax.reload();
              // $('.sw-btn-next').removeAttr("disabled");
              $('.div_ekspektasi').show();
              return true;
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(jqXHR.responseText);
              return false;
            }
          })
        }
      }

      if (nextStepIndex == 2 && stepDirection == "forward") {
        $("#btn_finish_e").show();
        $.ajax({
          "url": "<?= base_url('mom/check_validasi_result/') ?>" + $("#id_mom_global_draft").val(),
          "type": "GET",
          "dataType": 'JSON',
          "success": function(res) {
            // console.log(res);    
            if (!res.eksekusi) {
              $("#btn_finish_e").hide();
              swal("Warning", `${res.warning}`, "error");
              $('#smartwizard3').smartWizard("prev");
            }
          },
          "error": function(jqXHR) {
            console.log(jqXHR);
            console.log(jqXHR.responseText);
          }
        });
      } else {
        $("#btn_finish_e").hide();
      }
    });

    $("#judul_draft").keyup(function() {
      $(".judul_draft").removeClass('is-invalid');
      $(".judul_draft").addClass('is-valid');
    });

    $("#tempat_draft").keyup(function() {
      $(".tempat_draft").removeClass('is-invalid');
      $(".tempat_draft").addClass('is-valid');
    });

    $("#tanggal_draft").change(function() {
      $(".tgl_draft").removeClass('is-invalid');
      $(".tgl_draft").addClass('is-valid');
    });

    $("#start_time_draft").change(function() {
      $(".start_draft").removeClass('is-invalid');
      $(".start_draft").addClass('is-valid');
    });

    $("#end_time_draft").change(function() {
      $(".end_draft").removeClass('is-invalid');
      $(".end_draft").addClass('is-valid');
    });

    $("#meeting_draft").change(function() {
      $(".meeting_draft").removeClass('is-invalid');
      $(".meeting_draft").addClass('is-valid');
    });

    $("#department_draft").change(function() {
      $(".department_draft").removeClass('is-invalid');
      $(".department_draft").addClass('is-valid');
    });

    $("#agenda_draft").keyup(function() {
      $(".agenda_draft").removeClass('is-invalid');
      $(".agenda_draft").addClass('is-valid');
    });

    $("#peserta_draft").change(function() {
      $(".peserta_draft").removeClass('is-invalid');
      $(".peserta_draft").addClass('is-valid');
    });

    $("#pembahasan_draft").change(function() {
      $(".pembahasan_draft").removeClass('is-invalid');
      $(".pembahasan_draft").addClass('is-valid');
    });

    $("#closing_draft").change(function() {
      $(".closing_draft").removeClass('is-invalid');
      $(".closing_draft").addClass('is-valid');
    });
    // End Draft

    // Clear Validasi Plan
    $("#judul_plan").keyup(function() {
      $(".judul_plan").removeClass('is-invalid');
      $(".judul_plan").addClass('is-valid');
    });

    $("#tempat_plan").keyup(function() {
      $(".tempat_plan").removeClass('is-invalid');
      $(".tempat_plan").addClass('is-valid');
    });

    $("#tanggal_plan").change(function() {
      $(".tgl_plan").removeClass('is-invalid');
      $(".tgl_plan").addClass('is-valid');
    });

    $("#peserta_plan").change(function() {
      $(".peserta_plan").removeClass('is-invalid');
      $(".peserta_plan").addClass('is-valid');
    });

    $("#meeting_plan").change(function() {
      $(".meeting_plan").removeClass('is-invalid');
      $(".meeting_plan").addClass('is-valid');
    });

    $("#department_plan").change(function() {
      $(".department_plan").removeClass('is-invalid');
      $(".department_plan").addClass('is-valid');
    });
    // End Plan

  });

  function add_mom() {
    $("#modal_add_mom").modal("show");
    $("#btn_finish").hide();
    $('#pembahasan').summernote('reset');
    $('#closing').summernote('reset');
    peserta.setSelected([]);
    $("#id_mom").val("");
    $("#id_plan").val("");
    $("#id_plan_global").val("");
    $("#form_detail")[0].reset();
    $("#smartwizard2").smartWizard("reset");
    $('.check-valid').removeClass('is-valid');
    $('.check-valid').removeClass('is-invalid');

    curdate = (new Date()).toISOString().split('T')[0];
    $("#tanggal").val(curdate);

    $.ajax({
      url: "<?= base_url('mom/clear_result'); ?>",
      method: "GET",
      dataType: "JSON",
      success: function(res) {
        $('#data_result').empty().html(res);

        $('.tanggal').datetimepicker({
          format: 'Y-m-d',
          timepicker: false,
          minDate: 0,
        });

        // grdsi = new SlimSelect({
        //   select: ".grdsi"
        // });

        pic = new SlimSelect({
          select: ".pic"
        });

        // console.log(res);
      },
      error: function(xhr) {
        console.log(xhr.responseText);
      }
    });
  }

  function get_list_mom(start, end) {
    // console.log(`start : ${start}, end : ${end}`);
    var tabel_mom = $('#dt_list_mom').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
          extend: 'excelHtml5',
          text: '<i class="bi bi-download text-white"></i>',
          footer: true
        },
        {
          text: 'Export Detail',
          className: 'btn btn-md btn-danger excel_detail mb-4',
          action: function(e, dt, node, settings) {
            url = `<?= base_url() ?>mom/excel_detail/${start}/${end}`;
            window.open(url, '_blank');
          },
          footer: true
        },
      ],
      "drawCallback": function() {
        $('.excel_detail').attr('href', `<?= base_url() ?>mom/excel_detail/${start}/${end}`);
      },
      "ajax": {
        "dataType": 'json',
        "type": "POST",
        "url": "<?= base_url("mom_handika/get_list_mom") ?>",
        "data": {
          datestart: start,
          dateend: end,
          closed: 1
        },

        // "success": function (res){
        //   console.log(res);
        // },
        // "error": function (jqXHR){
        //   console.log(jqXHR.responseText);
        // }
      },
      "columns": [{
          'data': 'id_mom',
          'render': function(data, type, row) {
            // if (<?= $_SESSION['user_id']; ?> == 1 ) {
            return `<a href="<?= base_url('pr/mom/'); ?>${row['id_link']}" target="_blank" class="btn btn-sm btn-primary mb-1"><i class="bi bi-printer"></i></a>
                <a href="<?= base_url('mom/excel/'); ?>${row['id_link']}" target="_blank" class="btn btn-sm btn-success mb-1"><i class="bi bi-filetype-xls"></i></a>
                <button type="button" class="btn btn-sm btn-info mb-1" onclick="reminder_whatsapp('${data}')"><i class="bi bi-whatsapp"></i></button>`;
            // } else {
            //   return `<a href="<?= base_url('pr/mom/'); ?>${row['id_link']}" target="_blank" class="btn btn-sm btn-primary mb-1"><i class="bi bi-printer"></i></a>
            //   <button type="button" class="btn btn-sm btn-info mb-1" onclick="reminder_whatsapp('${data}')"><i class="bi bi-whatsapp"></i></button>`;
            // }
          },
          'className': 'text-center'
        },
        {
          'data': 'id_mom'
        },
        {
          'data': 'judul',
          'render': function(data, type, row, meta) {
            user_id = <?= $_SESSION['user_id']; ?>;
            // console.log(user_id);
            if (row['user_id'] == user_id || user_id == 1) {
              return `<span>${data} 
                            <a role="button" class="badge bg-light-blue float-end" style="cursor:pointer;" onclick="detail_mom('${row['id_mom']}')">
                              <i class="bi bi-info-circle"></i>
                            </a>
                          </span>`;
            }
            return `<span>${data}</span>`;
          }
        },
        {
          'data': 'meeting'
        },
        {
          'data': 'department'
        },
        {
          'data': 'peserta',
          'render': function(data, type, row, meta) {
            avatar_pic = ``;
            avatar_pic_plus = ``;
            if (row['pp_peserta'].indexOf(',') > -1) {
              array_pic = row['pp_peserta'].split(',');
              for (let index = 0; index < array_pic.length; index++) {
                if (index < 2) {
                  avatar_pic += `<div class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${array_pic[index]}&quot;);">
                            <img src="http://trusmiverse.com/hr/uploads/profile/${array_pic[index]}" alt="" style="display: none;">
                            </div>`;
                }
              }
              if (array_pic.length > 2) {
                avatar_pic_plus = `<div class="avatar avatar-30 bg-light-theme rounded-circle me-1">
                                <p class="small">${parseInt(array_pic.length)-2}+</p>
                            </div>`;
              } else {
                avatar_pic_plus = '';
              }
              return `<div class="d-flex justify-content-center" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${row['peserta']}">
                                ${avatar_pic}${avatar_pic_plus}  
                            </div>`;
            } else {
              return `
                        <div class="row">
                            <div class="col-auto align-self-center">
                                <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${row['pp_peserta']}&quot;);">
                                    <img src="http://trusmiverse.com/hr/uploads/profile/${row['pp_peserta']}" alt="" style="display: none;">
                                </figure>
                            </div>
                            <div class="col px-0 align-self-center">
                                <p class="mb-0 small">${row['peserta']}</p>
                            </div>
                        </div>`;
            }
          },
          "className": "d-none d-md-table-cell text-left"
        },
        {
          'data': 'agenda'
        },
        {
          'data': 'pembahasan',
          'render': function(data, type, row) {
            return `${data}`;
          }
        },
        {
          'data': 'tempat'
        },
        {
          'data': 'tgl'
        },
        {
          'data': 'waktu'
        },
        {
          'data': 'peserta', // addnew
          'render': function(data, type, row, meta) {
            if (!data) return "";
            return `<ul>` + data.split(",").map(item => `<li>${item}</li>`).join("") + `</ul>`;
          }
        },
        {
          'data': 'created_by',
          'render': function(data, type, row, meta) {
            return `<div class="row">
                            <div class="col-auto align-self-center">
                                <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${row['profile_picture']}&quot;);">
                                    <img src="http://trusmiverse.com/hr/uploads/profile/${row['profile_picture']}" alt="" style="display: none;">
                                </figure>
                            </div>
                            <div class="col px-0 align-self-center">
                                <p class="mb-0 small">${row['username']}</p>
                                <p class="small text-secondary small">${row['created_at']}</p>
                            </div>
                        </div>`;
          },
          "className": "d-none d-md-table-cell text-left"
        }
      ]
    });
  }

  function cancel() {
    id_mom = $("#id_mom_global").val();
    // console.log(id_mom);
    if (id_mom != "") {
      $.ajax({
        method: "GET",
        url: "<?= base_url("mom/cancel_mom/") ?>" + id_mom,
        dataType: "JSON",
        beforeSend: function(res) {
          $("#btn_cancel").attr("disabled", true);
        },
        success: function(res) {
          // console.log(res);
          // swal("Cancel!!", "Add Notulen is canceled!", "info");
          $.confirm({
            icon: 'fa fa-times-circle',
            title: 'Cancel',
            theme: 'material',
            type: 'red',
            content: 'Add Notulen is canceled!',
            buttons: {
              close: {
                actions: function() {}
              },
            },
          });
          $("#modal_add_mom").modal("hide");
          $("#id_mom_global").val("");
          $("#dt_list_mom").DataTable().ajax.reload();
          $('#pembahasan').summernote('reset');
          $('#closing').summernote('reset');
          peserta.setSelected([]);
          $("#form_detail")[0].reset();
          $("#smartwizard2").smartWizard("reset");
          $("#btn_cancel").removeAttr("disabled");
        },
        error: function(jqXHR) {
          console.log(jqXHR.responseText);
        }
      });
    } else {
      $("#modal_add_mom").modal("hide");
    }
  }

  function finish(closed) {
    id_mom = $("#id_mom_global").val();
    closing = $("#closing").val();
    project = $('#project').val();
    pekerjaan = $('#pekerjaan').val();
    sub_pekerjaan = $('#sub_pekerjaan').val();
    detail_pekerjaan = $('#list_det_pekerjaan').val();
    $("#closed").val(closed);

    if (closing == '' || closing == '<p><br></p>' || closing == '<br>') {
      $(".closing").removeClass('is-valid');
      $(".closing").addClass('is-invalid');
      swal("Warning", "Closing Statement belum terisi", "info");
      $("#closed").val(0);
      return false;
    } else {
      // Start
      $.confirm({
        icon: 'fa fa-spinner fa-spin',
        title: 'Please wait!',
        theme: 'material',
        type: 'blue',
        content: 'Processing...',
        buttons: {
          close: {
            isHidden: true,
            actions: function() {}
          },
        },
        onOpen: function() {
          // Start
          $.ajax({
            url: "<?= base_url("mom/save_closing") ?>",
            method: "POST",
            dataType: "JSON",
            data: {
              id_mom: id_mom,
              closing: closing,
              closed: closed, // Finish
              project: project,
              pekerjaan: pekerjaan,
              sub_pekerjaan: sub_pekerjaan,
              detail_pekerjaan: detail_pekerjaan,
            },
            beforeSend: function(res) {
              $('#btn_finish').attr("disabled", true);
            },
            success: function(res) {
              // console.log(res);
              // console.log(res.send);
              $("#closed").val("");
              $("#id_plan").val("");
              $("#id_plan_global").val("");
              $("#id_mom").val("");
              $("#id_mom_global").val("");
              $("#dt_list_mom").DataTable().ajax.reload();
              $('#btn_finish').removeAttr("disabled");
              // swal("Success!!", "Data has been saved!", "success");
              $("#modal_add_mom").modal("hide");
              $.confirm({
                icon: 'fa fa-check',
                title: 'Success',
                theme: 'material',
                type: 'green',
                content: 'Data has been saved!',
                buttons: {
                  close: function() {
                    window.location.reload();
                  },
                },
              });
              jconfirm.instances[0].close();
              return true;
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(jqXHR.responseText);
              jconfirm.instances[0].close();
            }
          });
          // End
        }
      });
      // End      
    }
  }

  // Start Tab Result  
  function submit_update(id) {
    // Kategori yang muncul deadline
    var kat_deadline = [1, 5, 6, 8, 9, 10, 11, 12];
    // Level yang disable deadline
    var lvl_deadline = [1, 2, 3, 4];

    id_mom = $('#id_mom_global').val();
    input = id.split('_');
    $('#td_' + id).removeClass('padding_0');
    if (input[0] == "kategori" && $.inArray(parseInt($('#val_' + id).val()), kat_deadline) == -1) {
      inp_value = $('#val_' + id).val();
      console.log('di if 1');

      // Clear Level
      $.ajax({
        url: '<?php echo base_url() ?>mom/save_issue_item',
        type: 'POST',
        dataType: 'JSON',
        data: {
          id_mom: id_mom,
          id_issue: input[1],
          id_issue_item: input[2],
          input: 'deadline',
          value: null
        },
        success: function(res) {
          console.log(res);
        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
      });
      // Clear Level
      $.ajax({
        url: '<?php echo base_url() ?>mom/save_issue_item',
        type: 'POST',
        dataType: 'JSON',
        data: {
          id_mom: id_mom,
          id_issue: input[1],
          id_issue_item: input[2],
          input: 'level',
          value: null
        },
        success: function(res) {
          console.log(res);
        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
      });
    } else if (input[0] == "kategori" && parseInt($('#val_kategori_' + input[1] + '_' + input[2]).val()) != 12) {
      inp_value = $('#val_' + id).val();
      // Clear Level
      $.ajax({
        url: '<?php echo base_url() ?>mom/save_issue_item',
        type: 'POST',
        dataType: 'JSON',
        data: {
          id_mom: id_mom,
          id_issue: input[1],
          id_issue_item: input[2],
          input: 'grdsi',
          value: null
        },
        success: function(res) {
          console.log(res);
        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
      });
    } else if (input[0] == "kategori" || input[0] == "pic" || input[0] == "grdsi") {
      inp_value = $('#val_' + id).val();
    } else {
      if (input[0] == 'deadline' && $.inArray(parseInt($('#val_kategori_' + input[1] + '_' + input[2]).val()), kat_deadline) != -1) {
        inp_value = $('#val_date_' + id).val();
        $('#' + id).show().text(inp_value);
        $('#val_date_' + id).hide();
      } else if (input[0] == 'level' && $.inArray(parseInt($('#val_kategori_' + input[1] + '_' + input[2]).val()), kat_deadline) != -1) {
        value = $('#val_' + id).val().split('|');
        console.log('di if level 2', value);

        inp_value = value[0]; // Value id Level
        day_value = value[1]; // Value day Level
        console.log('day value : ' + day_value);


        // Specific date
        var date = new Date();
        date.setDate(date.getDate() + parseInt(day_value));
        deadline_set = date.toISOString().slice(0, 10);
        console.log('deadline set : ' + deadline_set);


        $('#val_date_deadline_' + input[1] + '_' + input[2]).val(deadline_set);
        $('#deadline_' + input[1] + '_' + input[2]).show().text(deadline_set);

        $.ajax({
          url: '<?php echo base_url() ?>mom/save_issue_item',
          type: 'POST',
          dataType: 'JSON',
          data: {
            id_mom: id_mom,
            id_issue: input[1],
            id_issue_item: input[2],
            input: 'deadline',
            value: deadline_set
          },
          success: function(res) {
            console.log(res);
          },
          error: function(xhr) {
            console.log(xhr.responseText);
          }
        });
      } else {
        console.log("Tanpa Tgl");
        inp_value = $('#val_' + id).val();
        $('#' + id).show().text(inp_value);
        $('#val_' + id).hide();
      }
    }


    console.log(input)

    if (input[0] == "topik") {
      $.ajax({
          url: '<?php echo base_url() ?>mom/save_topik',
          type: 'POST',
          dataType: 'json',
          data: {
            id_mom: id_mom,
            id_issue: input[1],
            topik: inp_value
          },
        })
        .done(function() {
          console.log("success");
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
    } else if (input[0] == "issue") {
      $.ajax({
          url: '<?php echo base_url() ?>mom/save_issue',
          type: 'POST',
          dataType: 'json',
          data: {
            id_mom: id_mom,
            id_issue: input[1],
            issue: inp_value
          },
        })
        .done(function() {
          console.log("success");
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
    } else {
      $.ajax({
          url: '<?php echo base_url() ?>mom/save_issue_item',
          type: 'POST',
          dataType: 'json',
          data: {
            id_mom: id_mom,
            id_issue: input[1],
            id_issue_item: input[2],
            input: input[0],
            value: inp_value
          },
        })
        .done(function() {
          console.log("success");
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
    }


  }

  function expandTextarea(id) {
    document.getElementById(id).addEventListener('keyup', function() {
      this.style.overflow = 'hidden';
      this.style.height = 0;
      this.style.height = this.scrollHeight + 'px';
    }, false);
  }

  function add_action(issue_no) {
    meeting = $('#id_meeting').val();
    no = $('#total_action_' + issue_no).val();
    next_no = parseInt(no) + 1;
    rowspan = next_no + 1;

    // if (meeting == "Owner") {
    data_action = `<tr>
      <td width="1%" id="no_${issue_no}_${next_no}">${next_no}.</td>
      <td class="kolom_modif" id="td_action_${issue_no}_${next_no}" data-id="action_${issue_no}_${next_no}">
      <span id="action_${issue_no}_${next_no}">&nbsp;</span>
      <textarea class="form-control" id="val_action_${issue_no}_${next_no}" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea('val_action_${issue_no}_${next_no}')" onfocusout="submit_update('action_${issue_no}_${next_no}')"></textarea>
      </td>
      <td class="kolom_modif" id="td_kategori_${issue_no}_${next_no}" data-id="kategori_${issue_no}_${next_no}">
      <select class="form-control" id="val_kategori_${issue_no}_${next_no}" onchange="submit_update('kategori_${issue_no}_${next_no}')">
      <option>- Choose -</option>
      <?php foreach ($kategori as $ktg) : ?>
        <option value="<?php echo $ktg->id ?>"><?php echo $ktg->kategori ?></option>
      <?php endforeach ?>
      </select>
      </td>
      <td class="kolom_modif" id="td_grdsi_${issue_no}_${next_no}" data-id="grdsi_${issue_no}_${next_no}">
      <select class="form-control" id="val_grdsi_${issue_no}_${next_no}" onchange="submit_update('grdsi_${issue_no}_${next_no}')">
      <option>- Choose -</option>
      <?php foreach ($grdsi as $si) : ?>
        <option value="<?php echo $si->id_si ?>"><?php echo $si->grdsi ?></option>
      <?php endforeach ?>
      </select>
      </td>
      <td class="kolom_modif" id="td_level_${issue_no}_${next_no}" data-id="level_${issue_no}_${next_no}">
      <select class="form-control" id="val_level_${issue_no}_${next_no}" onchange="submit_update('level_${issue_no}_${next_no}')">
      <option>- Choose -</option>
      <?php foreach ($level as $lvl) : ?>
        <option value="<?= $lvl->id ?>|<?= $lvl->day ?>"><?php echo $lvl->leveling ?></option>
      <?php endforeach ?>
      </select>
      </td>
      <td class="kolom_modif" id="td_deadline_${issue_no}_${next_no}" data-id="deadline_${issue_no}_${next_no}">
      <span id="deadline_${issue_no}_${next_no}">&nbsp;</span>
      <textarea class="form-control" id="val_deadline_${issue_no}_${next_no}" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea('val_deadline_${issue_no}_${next_no}')" onfocusout="submit_update('deadline_${issue_no}_${next_no}')"></textarea>
      <input type="text" class="form-control tanggal" id="val_date_deadline_${issue_no}_${next_no}" style="display: none;" onfocusout="submit_update('deadline_${issue_no}_${next_no}')">
      </td>
      <td class="kolom_modif" id="td_ekspektasi_${issue_no}_${next_no}" data-id="ekspektasi_${issue_no}_${next_no}">
      <span id="ekspektasi_${issue_no}_${next_no}">&nbsp;</span>
      <textarea class="form-control" id="val_ekspektasi_${issue_no}_${next_no}" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea('val_ekspektasi_${issue_no}_${next_no}')" onfocusout="submit_update('ekspektasi_${issue_no}_${next_no}')"></textarea>
      </td>
      <td id="td_pic_${issue_no}_${next_no}">
      <select id="val_pic_${issue_no}_${next_no}" class="form-control pic" multiple onchange="submit_update('pic_${issue_no}_${next_no}')">
      <option data-placeholder="true">-- Choose Employee --</option>
      <?php foreach ($pic as $row) : ?>
        <option value="<?= $row->user_id ?>"><?= $row->employee_name ?></option>
      <?php endforeach; ?>
      </select>
      </td>
      </tr>`;
    // } else {
    //   data_action = `<tr>
    //     <td width="1%" id="no_${issue_no}_${next_no}">${next_no}.</td>
    //     <td class="kolom_modif" id="td_action_${issue_no}_${next_no}" data-id="action_${issue_no}_${next_no}">
    //     <span id="action_${issue_no}_${next_no}">&nbsp;</span>
    //     <textarea class="form-control" id="val_action_${issue_no}_${next_no}" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea('val_action_${issue_no}_${next_no}')" onfocusout="submit_update('action_${issue_no}_${next_no}')"></textarea>
    //     </td>
    //     <td class="kolom_modif" id="td_kategori_${issue_no}_${next_no}" data-id="kategori_${issue_no}_${next_no}">
    //     <select class="form-control" id="val_kategori_${issue_no}_${next_no}" onchange="submit_update('kategori_${issue_no}_${next_no}')">
    //     <option>- Choose -</option>
    //     <?php foreach ($kategori as $ktg) : ?>
    //       <option value="<?php echo $ktg->id ?>"><?php echo $ktg->kategori ?></option>
    //     <?php endforeach ?>
    //     </select>
    //     </td>
    //     <td class="kolom_modif" id="td_level_${issue_no}_${next_no}" data-id="level_${issue_no}_${next_no}">
    //     <select class="form-control" id="val_level_${issue_no}_${next_no}" onchange="submit_update('level_${issue_no}_${next_no}')">
    //     <option>- Choose -</option>
    //     <?php foreach ($level as $lvl) : ?>
    //       <option value="<?= $lvl->id ?>|<?= $lvl->day ?>"><?php echo $lvl->leveling ?></option>
    //     <?php endforeach ?>
    //     </select>
    //     </td>
    //     <td class="kolom_modif" id="td_deadline_${issue_no}_${next_no}" data-id="deadline_${issue_no}_${next_no}">
    //     <span id="deadline_${issue_no}_${next_no}">&nbsp;</span>
    //     <textarea class="form-control" id="val_deadline_${issue_no}_${next_no}" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea('val_deadline_${issue_no}_${next_no}')" onfocusout="submit_update('deadline_${issue_no}_${next_no}')"></textarea>
    //     <input type="text" class="form-control tanggal" id="val_date_deadline_${issue_no}_${next_no}" style="display: none;" onfocusout="submit_update('deadline_${issue_no}_${next_no}')">
    //     </td>
    //     <td id="td_pic_${issue_no}_${next_no}">
    //     <select id="val_pic_${issue_no}_${next_no}" class="form-control pic" multiple onchange="submit_update('pic_${issue_no}_${next_no}')">
    //     <option data-placeholder="true">-- Choose Employee --</option>
    //     <?php foreach ($pic as $row) : ?>
    //       <option value="<?= $row->user_id ?>"><?= $row->employee_name ?></option>
    //     <?php endforeach; ?>
    //     </select>
    //     </td>
    //     </tr>`;
    // }


    $('#td_topik_' + issue_no).attr('rowspan', rowspan);
    $('#td_issue_' + issue_no).attr('rowspan', rowspan);
    console.log(rowspan)
    $('#div_issue_action_' + issue_no).before(data_action);
    $('#total_action_' + issue_no).val(next_no);

    $('.tanggal').datetimepicker({
      format: 'Y-m-d',
      timepicker: false,
      minDate: 0,
    });

    pic = new SlimSelect({
      select: "#val_pic_" + issue_no + "_" + next_no
    });

    $(`#btn_remove_action_${issue_no}`).show();

    total = $("#total_issue").val();
    if (issue_no > 1 && issue_no == total) {
      $(".btn_remove_issue").hide();
    }
  }

  function remove_action(issue_no) {
    // console.log(no, issue_no);
    no = $('#total_action_' + issue_no).val();
    if (no > 1) {
      next_no = parseInt(no) - 1;
      rowspan = no;

      $('#td_topik_' + issue_no).attr('rowspan', rowspan);
      $('#td_issue_' + issue_no).attr('rowspan', rowspan);
      $('#div_issue_action_' + issue_no).prev().remove();
      $('#total_action_' + issue_no).val(next_no);

      if (no == 2) {
        $(`#btn_remove_action_${issue_no}`).hide();
        total = $("#total_issue").val();
        if (issue_no > 1 && issue_no == total) {
          $(".btn_remove_issue").show();
        }
      }


      id_mom = $("#id_mom_global").val();
      id_issue = issue_no;
      id_issue_item = no;
      console.log('-Remove Action-');
      console.log(id_mom, id_issue, id_issue_item);
      $.ajax({
          url: '<?php echo base_url() ?>mom/delete_issue_item',
          type: 'POST',
          dataType: 'JSON',
          data: {
            id_mom: id_mom,
            id_issue: id_issue,
            id_issue_item: id_issue_item
          },
          success: function(res) {
            console.log(res);
          }
        })
        .done(function() {
          console.log("success");
        })
        .fail(function(xhr) {
          console.log("error");
          console.log(xhr.responseText);
        })
        .always(function() {
          console.log("complete");
        });
    }
  }

  function add_issue() {
    let no = $('#total_issue').val();
    let tipe_meeting = $('#meeting').val();
    let next_no = parseInt(no) + 1;
    console.log(no);
    console.log(tipe_meeting);
    console.log(next_no);


    let data_action = `
    <tr id="div_issue_${next_no}">
    <td class="kolom_modif" id="td_topik_${next_no}" data-id="topik_${next_no}_1" rowspan="2">
    <input type="hidden" id="total_action_${next_no}" value="1">
    <span id="topik_${next_no}_1">&nbsp;</span>
            <textarea class="form-control excel" id="val_topik_${next_no}_1" rows="1" 
                onfocusin="expandTextarea('val_topik_${next_no}_1')" 
                onfocusout="submit_update('topik_${next_no}_1')"></textarea>
    </td>
    <td class="kolom_modif" id="td_issue_${next_no}" data-id="issue_${next_no}_1" rowspan="2">
    <span id="issue_${next_no}_1">&nbsp;</span>
            <textarea class="form-control excel" id="val_issue_${next_no}_1" rows="1"
                onfocusin="expandTextarea('val_issue_${next_no}_1')" 
                onfocusout="submit_update('issue_${next_no}_1')"></textarea>
    </td>
        <td width="1%" id="no_${next_no}_1">1.</td>
    <td class="kolom_modif" id="td_action_${next_no}_1" data-id="action_${next_no}_1">
    <span id="action_${next_no}_1">&nbsp;</span>
            <textarea class="form-control excel" id="val_action_${next_no}_1" rows="1"
                onfocusin="expandTextarea('val_action_${next_no}_1')" 
                onfocusout="submit_update('action_${next_no}_1')"></textarea>
    </td>
    <td class="kolom_modif" id="td_kategori_${next_no}_1" data-id="kategori_${next_no}_1">
    <select class="form-control" id="val_kategori_${next_no}_1" onchange="submit_update('kategori_${next_no}_1')">
    <option>- Choose -</option>
    <?php foreach ($kategori as $ktg) : ?>
      <option value="<?php echo $ktg->id ?>"><?php echo $ktg->kategori ?></option>
    <?php endforeach ?>
    </select>
    </td>
    <td class="kolom_modif" id="td_grdsi_${next_no}_1" data-id="grdsi_${next_no}_1">
    <select class="form-control" id="val_grdsi_${next_no}_1" onchange="submit_update('grdsi_${next_no}_1')">
    <option>- Choose -</option>
    <?php foreach ($grdsi as $si) : ?>
      <option value="<?php echo $si->id_si ?>"><?php echo $si->grdsi ?></option>
    <?php endforeach ?>
    </select>
    </td>
    <td class="kolom_modif" id="td_level_${next_no}_1" data-id="level_${next_no}_1">
    <select class="form-control" id="val_level_${next_no}_1" onchange="submit_update('level_${next_no}_1')">
    <option>- Choose -</option>
    <?php foreach ($level as $lvl) : ?>
      <option value="<?= $lvl->id ?>|<?= $lvl->day ?>"><?php echo $lvl->leveling ?></option>
    <?php endforeach ?>
    </select>
    </td>
    <td class="kolom_modif" id="td_deadline_${next_no}_1" data-id="deadline_${next_no}_1">
      <span id="deadline_${next_no}_1">&nbsp;</span>
      <input type="text" class="form-control tanggal" id="val_date_deadline_${next_no}_1" 
          onfocusout="submit_update('deadline_${next_no}_1')" style="display: none;">
    </td>
    <td class="kolom_modif" id="td_ekspektasi_${next_no}_1" data-id="ekspektasi_${next_no}_1">
      <span id="ekspektasi_${next_no}_1">&nbsp;</span>
      <textarea class="form-control excel" id="val_ekspektasi_${next_no}_1" rows="1"
          onfocusin="expandTextarea('val_ekspektasi_${next_no}_1')" 
          onfocusout="submit_update('ekspektasi_${next_no}_1')" ></textarea>
    </td>
    <td id="td_pic_${next_no}_1">
    <select id="val_pic_${next_no}_1" class="form-control pic" multiple onchange="submit_update('pic_${next_no}_1')">
    <option data-placeholder="true">-- Choose Employee --</option>
    <?php foreach ($pic as $row) : ?>
      <option value="<?= $row->user_id ?>"><?= $row->employee_name ?></option>
    <?php endforeach; ?>
    </select>
    </td>
    </tr>
    <tr id="div_issue_action_${next_no}">
    <td style="cursor: pointer;" colspan="8">
            <span class="btn btn-md btn-outline-success" onclick="add_action(${next_no})">
                <i class="bi bi-plus-square"></i> Strategy
            </span>
            <span class="btn btn-md btn-outline-danger" id="btn_remove_action_${next_no}" onclick="remove_action(${next_no})" style="display:none;">
                <i class="bi bi-dash-square"></i> Strategy
            </span>
    </td>
    </tr>`;

    $('#div_issue').before(data_action);
    $('#total_issue').val(next_no);

    $('.tanggal').datetimepicker({
      format: 'Y-m-d',
      timepicker: false,
      minDate: 0,
    });

    pic = new SlimSelect({
      select: "#val_pic_" + next_no + '_1'
    });

    $('.btn_remove_issue').show();
  }

  function remove_issue() {
    no = $('#total_issue').val();
    if (no > 1) {
      next_no = parseInt(no) - 1;

      tot_action_before = $(`#total_action_${next_no}`).val();

      $('#div_issue_' + no).remove();
      $('#div_issue_action_' + no).remove();
      $('#total_issue').val(next_no);
      if (no == 2 || tot_action_before > 1) {
        $('.btn_remove_issue').hide();
      }

      id_mom = $("#id_mom_global").val();
      id_issue = no;
      console.log('-Remove Issue-');
      console.log(id_mom, id_issue);
      $.ajax({
          url: '<?php echo base_url() ?>mom/delete_issue',
          type: 'POST',
          dataType: 'JSON',
          data: {
            id_mom: id_mom,
            id_issue: id_issue
          },
          success: function(res) {
            console.log(res);
          }
        })
        .done(function() {
          console.log("success");
        })
        .fail(function(xhe) {
          console.log("error");
          console.log(xhr.responseText);
        })
        .always(function() {
          console.log("complete");
        });

      $.ajax({
          url: '<?php echo base_url() ?>mom/delete_issue_item',
          type: 'POST',
          dataType: 'JSON',
          data: {
            id_mom: id_mom,
            id_issue: id_issue,
            id_issue_item: 1
          },
          success: function(res) {
            console.log(res);
          }
        })
        .done(function() {
          console.log("success");
        })
        .fail(function(xhe) {
          console.log("error");
          console.log(xhr.responseText);
        })
        .always(function() {
          console.log("complete");
        });
    }
  }
  // End Tab Result

  // Start Tab Result  Draft
  function submit_update_draft(id) {
    // Kategori yang muncul deadline
    var kat_deadline = [1, 5, 6, 8, 9, 10, 11, 12];
    // Level yang disable deadline
    var lvl_deadline = [1, 2, 3, 4];

    id_mom = $('#id_mom_global_draft').val();
    input = id.split('_');
    $('#td_' + id).removeClass('padding_0');
    console.log(parseInt($('#val_kategori_draft_' + input[2] + '_' + input[3]).val()));
    if (input[0] == "kategori" && $.inArray(parseInt($('#val_' + id).val()), kat_deadline) == -1) {
      inp_value = $('#val_' + id).val();
      // Clear Level
      $.ajax({
        url: '<?php echo base_url() ?>mom/save_issue_item',
        type: 'POST',
        dataType: 'JSON',
        data: {
          id_mom: id_mom,
          id_issue: input[2],
          id_issue_item: input[3],
          input: 'deadline',
          value: null
        },
        success: function(res) {
          console.log(res);
        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
      });
      // Clear Level
      $.ajax({
        url: '<?php echo base_url() ?>mom/save_issue_item',
        type: 'POST',
        dataType: 'JSON',
        data: {
          id_mom: id_mom,
          id_issue: input[2],
          id_issue_item: input[3],
          input: 'level',
          value: null
        },
        success: function(res) {
          console.log(res);
        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
      });
    } else if (input[0] == "kategori" && parseInt($('#val_kategori_draft_' + input[2] + '_' + input[3]).val()) != 12) {
      inp_value = $('#val_' + id).val();
      // Clear Level
      $.ajax({
        url: '<?php echo base_url() ?>mom/save_issue_item',
        type: 'POST',
        dataType: 'JSON',
        data: {
          id_mom: id_mom,
          id_issue: input[2],
          id_issue_item: input[3],
          input: 'grdsi',
          value: 0
        },
        success: function(res) {
          console.log(res);
        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
      });
    } else if (input[0] == "kategori" || input[0] == "pic" || input[0] == "grdsi") {
      inp_value = $('#val_' + id).val();
    } else {
      if (input[0] == 'deadline' && $.inArray(parseInt($('#val_kategori_draft_' + input[2] + '_' + input[3]).val()), kat_deadline) != -1) {
        inp_value = $('#val_date_' + id).val();
        $('#' + id).show().text(inp_value);
        $('#val_date_' + id).hide();
      } else if (input[0] == 'level' && $.inArray(parseInt($('#val_kategori_draft_' + input[2] + '_' + input[3]).val()), kat_deadline) != -1) {
        value = $('#val_' + id).val().split('|');
        inp_value = value[0]; // Value id Level
        day_value = value[1]; // Value day Level

        // Specific date
        var date = new Date();
        date.setDate(date.getDate() + parseInt(day_value));
        deadline_set = date.toISOString().slice(0, 10);

        $('#val_date_deadline_draft_' + input[2] + '_' + input[3]).val(deadline_set);
        $('#deadline_draft_' + input[2] + '_' + input[3]).show().text(deadline_set);
        $.ajax({
          url: '<?php echo base_url() ?>mom/save_issue_item',
          type: 'POST',
          dataType: 'JSON',
          data: {
            id_mom: id_mom,
            id_issue: input[2],
            id_issue_item: input[3],
            input: 'deadline',
            value: deadline_set
          },
          success: function(res) {
            console.log(res);
          },
          error: function(xhr) {
            console.log(xhr.responseText);
          }
        });
      } else {
        // console.log("Tanpa Tgl");
        inp_value = $('#val_' + id).val();
        $('#' + id).show().text(inp_value);
        $('#val_' + id).hide();
      }
    }


    console.log(input)

    if (input[0] == "topik") {
      $.ajax({
          url: '<?php echo base_url() ?>mom/save_topik',
          type: 'POST',
          dataType: 'json',
          data: {
            id_mom: id_mom,
            id_issue: input[2],
            topik: inp_value
          },
        })
        .done(function() {
          console.log("success");
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
    } else if (input[0] == "issue") {
      $.ajax({
          url: '<?php echo base_url() ?>mom/save_issue',
          type: 'POST',
          dataType: 'json',
          data: {
            id_mom: id_mom,
            id_issue: input[2],
            issue: inp_value
          },
        })
        .done(function() {
          console.log("success");
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
    } else {
      data = {
        id_mom: id_mom,
        id_issue: input[2],
        id_issue_item: input[3],
        input: input[0],
        value: inp_value
      };
      console.log(data);
      $.ajax({
          url: '<?php echo base_url() ?>mom/save_issue_item',
          type: 'POST',
          dataType: 'json',
          data: {
            id_mom: id_mom,
            id_issue: input[2],
            id_issue_item: input[3],
            input: input[0],
            value: inp_value
          },
        })
        .done(function() {
          console.log("success");
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
    }


  }

  function expandTextarea_draft(id) {
    document.getElementById(id).addEventListener('keyup', function() {
      this.style.overflow = 'hidden';
      this.style.height = 0;
      this.style.height = this.scrollHeight + 'px';
    }, false);
  }

  function add_action_draft(issue_no) {
    no = $('#total_action_draft_' + issue_no).val();
    next_no = parseInt(no) + 1;
    rowspan = next_no + 1;

    data_action = `<tr>
    <td width="1%" id="no_draft_${issue_no}_${next_no}">${next_no}.</td>
    <td class="kolom_modif" id="td_action_draft_${issue_no}_${next_no}" data-id="action_draft_${issue_no}_${next_no}">
    <span id="action_draft_${issue_no}_${next_no}">&nbsp;</span>
    <textarea class="form-control" id="val_action_draft_${issue_no}_${next_no}" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea_draft('val_action_draft_${issue_no}_${next_no}')" onfocusout="submit_update_draft('action_draft_${issue_no}_${next_no}')"></textarea>
    </td>
    <td class="kolom_modif" id="td_kategori_draft_${issue_no}_${next_no}" data-id="kategori_draft_${issue_no}_${next_no}">
    <select class="form-control" id="val_kategori_draft_${issue_no}_${next_no}" onchange="submit_update_draft('kategori_draft_${issue_no}_${next_no}')">
    <option>- Choose -</option>
    <?php foreach ($kategori as $ktg) : ?>
      <option value="<?php echo $ktg->id ?>"><?php echo $ktg->kategori ?></option>
    <?php endforeach ?>
    </select>
    </td>
    <td class="kolom_modif" id="td_grdsi_draft_${issue_no}_${next_no}" data-id="grdsi_draft_${issue_no}_${next_no}">
    <select class="form-control" id="val_grdsi_draft_${issue_no}_${next_no}" onchange="submit_update_draft('grdsi_draft_${issue_no}_${next_no}')">
    <option>- Choose -</option>
    <?php foreach ($grdsi as $si) : ?>
      <option value="<?php echo $si->id_si ?>"><?php echo $si->grdsi ?></option>
    <?php endforeach ?>
    </select>
    </td>
    <td class="kolom_modif" id="td_level_draft_${issue_no}_${next_no}" data-id="level_draft_${issue_no}_${next_no}">
    <select class="form-control" id="val_level_draft_${issue_no}_${next_no}" onchange="submit_update_draft('level_draft_${issue_no}_${next_no}')">
    <option>- Choose -</option>
    <?php foreach ($level as $lvl) : ?>
      <option value="<?= $lvl->id ?>|<?= $lvl->day ?>"><?= $lvl->leveling ?></option>
    <?php endforeach ?>
    </select>
    </td>
    <td class="kolom_modif" id="td_deadline_draft_${issue_no}_${next_no}" data-id="deadline_draft_${issue_no}_${next_no}">
    <span id="deadline_draft_${issue_no}_${next_no}">&nbsp;</span>
    <textarea class="form-control" id="val_deadline_draft_${issue_no}_${next_no}" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea_draft('val_deadline_draft_${issue_no}_${next_no}')" onfocusout="submit_update_draft('deadline_draft_${issue_no}_${next_no}')"></textarea>
    <input type="text" class="form-control tanggal" id="val_date_deadline_draft_${issue_no}_${next_no}" style="display: none;" onfocusout="submit_update_draft('deadline_draft_${issue_no}_${next_no}')">
    </td>
    <td class="kolom_modif" id="td_ekspektasi_draft_${issue_no}_${next_no}" data-id="ekspektasi_draft_${issue_no}_${next_no}">
        <span id="ekspektasi_${issue_no}_${next_no}">&nbsp;</span>
        <textarea class="form-control" id="val_ekspektasi_draft_${issue_no}_${next_no}" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea_draft('val_ekspektasi_draft_${issue_no}_${next_no}')" onfocusout="submit_update_draft('ekspektasi_draft_${issue_no}_${next_no}')"></textarea>
    </td>
    <td id="td_pic_draft_${issue_no}_${next_no}">
    <select id="val_pic_draft_${issue_no}_${next_no}" class="form-control pic" multiple onchange="submit_update_draft('pic_draft_${issue_no}_${next_no}')">
    <option data-placeholder="true">-- Choose Employee --</option>
    <?php foreach ($pic as $row) : ?>
      <option value="<?= $row->user_id ?>"><?= $row->employee_name ?></option>
    <?php endforeach; ?>
    </select>
    </td>
    </tr>`;

    $('#td_topik_draft_' + issue_no).attr('rowspan', rowspan);
    $('#td_issue_draft_' + issue_no).attr('rowspan', rowspan);
    // console.log(rowspan);
    $('#div_issue_action_draft_' + issue_no).before(data_action);
    $('#total_action_draft_' + issue_no).val(next_no);

    $('.tanggal').datetimepicker({
      format: 'Y-m-d',
      timepicker: false,
      minDate: 0,
    });

    pic_draft = new SlimSelect({
      select: "#val_pic_draft_" + issue_no + "_" + next_no
    });

    $(`#btn_remove_action_draft_${issue_no}`).show();

    total = $("#total_issue_draft").val();
    console.log(issue_no, total);
    if (issue_no > 1 && issue_no == total) {
      $(".btn_remove_issue_draft").hide();
    }
  }

  function remove_action_draft(issue_no) {
    // console.log(no, issue_no);
    no = $('#total_action_draft_' + issue_no).val();
    if (no > 1) {
      next_no = parseInt(no) - 1;
      rowspan = no;

      $('#td_topik_draft_' + issue_no).attr('rowspan', rowspan);
      $('#td_issue_draft_' + issue_no).attr('rowspan', rowspan);
      $('#div_issue_action_draft_' + issue_no).prev().remove();
      $('#total_action_draft_' + issue_no).val(next_no);

      if (no == 2) {
        $(`#btn_remove_action_draft_${issue_no}`).hide();

        total = $("#total_issue_draft").val();
        if (issue_no > 1 && issue_no == total) {
          $(".btn_remove_issue_draft").show();
        }
      }

      id_mom = $("#id_mom_global_draft").val();
      id_issue = issue_no;
      id_issue_item = no;
      console.log('-Remove Action-');
      console.log(id_mom, id_issue, id_issue_item);
      $.ajax({
          url: '<?php echo base_url() ?>mom/delete_issue_item',
          type: 'POST',
          dataType: 'JSON',
          data: {
            id_mom: id_mom,
            id_issue: id_issue,
            id_issue_item: id_issue_item
          },
          success: function(res) {
            console.log(res);
          }
        })
        .done(function() {
          console.log("success");
        })
        .fail(function(xhr) {
          console.log("error");
          console.log(xhr.responseText);
        })
        .always(function() {
          console.log("complete");
        });
    }
  }

  function add_issue_draft() {
    no = $('#total_issue_draft').val();
    let tipe_meeting = $('#meeting_draft').val();
    // console.log('Jumlah Issue : ', no);
    next_no = parseInt(no) + 1;
    // let showEkspektasi = (tipe_meeting === 'Owner') ? '' : 'style="display: none;"';
    let showEkspektasi = '';

    data_action = `
    <tr id="div_issue_draft_${next_no}">
    <td class="kolom_modif" id="td_topik_draft_${next_no}" data-id="topik_draft_${next_no}_1" rowspan="2">
    <input type="hidden" id="total_action_draft_${next_no}" value="1">
    <span id="topik_draft_${next_no}_1">&nbsp;</span>
    <textarea class="form-control" id="val_topik_draft_${next_no}_1" style="display: none;" class="excel" rows="${next_no}_1" onfocusin="expandTextarea_draft('val_topik_draft_${next_no}_1')" onfocusout="submit_update_draft('topik_draft_${next_no}_1')"></textarea>
    </td>
    <td class="kolom_modif" id="td_issue_draft_${next_no}" data-id="issue_draft_${next_no}_1" rowspan="2">
    <input type="hidden" id="total_action_draft_${next_no}" value="1">
    <span id="issue_draft_${next_no}_1">&nbsp;</span>
    <textarea class="form-control" id="val_issue_draft_${next_no}_1" style="display: none;" class="excel" rows="${next_no}_1" onfocusin="expandTextarea_draft('val_issue_draft_${next_no}_1')" onfocusout="submit_update_draft('issue_draft_${next_no}_1')"></textarea>
    </td>
    <td width="${next_no}_1%" id="no_draft_${next_no}_1">1.</td>
    <td class="kolom_modif" id="td_action_draft_${next_no}_1" data-id="action_draft_${next_no}_1">
    <span id="action_draft_${next_no}_1">&nbsp;</span>
    <textarea class="form-control" id="val_action_draft_${next_no}_1" style="display: none;" class="excel" rows="${next_no}_1" onfocusin="expandTextarea_draft('val_action_draft_${next_no}_1')" onfocusout="submit_update_draft('action_draft_${next_no}_1')"></textarea>
    </td>
    <td class="kolom_modif" id="td_kategori_draft_${next_no}_1" data-id="kategori_draft_${next_no}_1">
    <select class="form-control" id="val_kategori_draft_${next_no}_1" onchange="submit_update_draft('kategori_draft_${next_no}_1')">
    <option>- Choose -</option>
    <?php foreach ($kategori as $ktg) : ?>
      <option value="<?php echo $ktg->id ?>"><?php echo $ktg->kategori ?></option>
    <?php endforeach ?>
    </select>
    </td>
    <td class="kolom_modif" id="td_grdsi_draft_${next_no}_1" data-id="grdsi_draft_${next_no}_1">
    <select class="form-control" id="val_grdsi_draft_${next_no}_1" onchange="submit_update_draft('grdsi_draft_${next_no}_1')">
    <option>- Choose -</option>
    <?php foreach ($grdsi as $si) : ?>
      <option value="<?php echo $si->id_si ?>"><?php echo $si->grdsi ?></option>
    <?php endforeach ?>
    </select>
    </td>
    <td class="kolom_modif" id="td_level_draft_${next_no}_1" data-id="level_draft_${next_no}_1">
    <select class="form-control" id="val_level_draft_${next_no}_1" onchange="submit_update_draft('level_draft_${next_no}_1')">
    <option>- Choose -</option>
    <?php foreach ($level as $lvl) : ?>
      <option value="<?= $lvl->id ?>|<?= $lvl->day ?>"><?php echo $lvl->leveling ?></option>
    <?php endforeach ?>
    </select>
    </td>
    <td class="kolom_modif" id="td_deadline_draft_${next_no}_1" data-id="deadline_draft_${next_no}_1">
    <span id="deadline_draft_${next_no}_1">&nbsp;</span>
    <textarea class="form-control" id="val_deadline_draft_${next_no}_1" style="display: none;" class="excel" rows="${next_no}_1" onfocusin="expandTextarea_draft('val_deadline_draft_${next_no}_1')" onfocusout="submit_update_draft('deadline_draft_${next_no}_1')"></textarea>
    <input type="text" class="form-control tanggal" id="val_date_deadline_draft_${next_no}_1" style="display: none;" onfocusout="submit_update_draft('deadline_draft_${next_no}_1')">
    </td>
    <td class="kolom_modif" id="td_ekspektasi_${next_no}_1" data-id="ekspektasi_${next_no}_1" ${showEkspektasi}>
            <span id="ekspektasi_${next_no}_1">&nbsp;</span>
            <textarea class="form-control excel" id="val_ekspektasi_${next_no}_1" rows="1"
                onfocusin="expandTextarea('val_ekspektasi_${next_no}_1')" 
                onfocusout="submit_update('ekspektasi_${next_no}_1')"></textarea>
    </td>
    <td id="td_pic_draft_${next_no}_1">
    <select id="val_pic_draft_${next_no}_1" class="form-control pic" multiple onchange="submit_update_draft('pic_draft_${next_no}_1')">
    <option data-placeholder="true">-- Choose Employee --</option>
    <?php foreach ($pic as $row) : ?>
      <option value="<?= $row->user_id ?>"><?= $row->employee_name ?></option>
    <?php endforeach; ?>
    </select>
    </td>
    </tr>
    <tr id="div_issue_action_draft_${next_no}">
    <td style="cursor: pointer;" colspan="8">
    <span class="btn btn-md btn-outline-success" onclick="add_action_draft(${next_no})"><i class="bi bi-plus-square"></i> Strategy</span>
    <span class="btn btn-md btn-outline-danger" id="btn_remove_action_draft_${next_no}" style="display:none;" onclick="remove_action_draft(${next_no})"><i class="bi bi-dash-square"></i> Strategy</span>
    </td>
    </tr>`;

    $('#div_issue_draft').before(data_action);
    $('#total_issue_draft').val(next_no);

    $('.tanggal').datetimepicker({
      format: 'Y-m-d',
      timepicker: false,
      minDate: 0,
    });

    pic_draft = new SlimSelect({
      select: "#val_pic_draft_" + next_no + '_1'
    });

    $('.btn_remove_issue_draft').show();
  }

  function remove_issue_draft() {
    no = $('#total_issue_draft').val();
    if (no > 1) {
      next_no = parseInt(no) - 1;

      tot_action_before = $(`#total_action_draft_${next_no}`).val();

      $('#div_issue_draft_' + no).remove();
      $('#div_issue_action_draft_' + no).remove();
      $('#total_issue_draft').val(next_no);
      if (no == 2 || tot_action_before > 1) {
        $('.btn_remove_issue_draft').hide();
      }

      id_mom = $("#id_mom_global_draft").val();
      id_issue = no;
      console.log('-Remove Issue-');
      console.log(id_mom, id_issue);
      $.ajax({
          url: '<?php echo base_url() ?>mom/delete_issue',
          type: 'POST',
          dataType: 'JSON',
          data: {
            id_mom: id_mom,
            id_issue: id_issue
          },
          success: function(res) {
            console.log(res);
          }
        })
        .done(function() {
          console.log("success");
        })
        .fail(function(xhe) {
          console.log("error");
          console.log(xhr.responseText);
        })
        .always(function() {
          console.log("complete");
        });

      $.ajax({
          url: '<?php echo base_url() ?>mom/delete_issue_item',
          type: 'POST',
          dataType: 'JSON',
          data: {
            id_mom: id_mom,
            id_issue: id_issue,
            id_issue_item: 1
          },
          success: function(res) {
            console.log(res);
          }
        })
        .done(function() {
          console.log("success");
        })
        .fail(function(xhe) {
          console.log("error");
          console.log(xhr.responseText);
        })
        .always(function() {
          console.log("complete");
        });
    }
  }
  // End Tab Result Draft

  // List Rekap
  function get_list_rekap(start, end) {
    // console.log(`start : ${start}, end : ${end}`);
    var tabel_rekap =
      $('#dt_list_rekap').DataTable({
        "lengthChange": false,
        "searching": true,
        "info": true,
        "paging": true,
        "autoWidth": false,
        "destroy": true,
        dom: 'Bfrtip',
        buttons: [{
          extend: 'excelHtml5',
          text: '<i class="bi bi-download text-white"></i>',
          footer: true
        }],
        "ajax": {
          "dataType": 'json',
          "type": "POST",
          "data": {
            datestart: start,
            dateend: end
          },
          "url": "<?= base_url("mom_handika/get_list_rekap") ?>"
          // "success": function (res){
          //   console.log(res);
          // },
          // "error": function (jqXHR){
          //   console.log(jqXHR.responseText);
          // }
        },
        "columns": [{
            'data': 'employee_name',
            'render': function(data, type, row) {
              return `${data}`;
            }
          },
          {
            'data': 'jabatan',
            'render': function(data, type, row) {
              return `${data}`;
            }
          },
          {
            'data': 'w1',
            'render': function(data, type, row) {
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-theme" onclick="detail_rekap('${row['user_id']}','w1')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'w2',
            'render': function(data, type, row) {
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-theme" onclick="detail_rekap('${row['user_id']}','w2')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'w3',
            'render': function(data, type, row) {
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-theme" onclick="detail_rekap('${row['user_id']}','w3')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'w4',
            'render': function(data, type, row) {
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-theme" onclick="detail_rekap('${row['user_id']}','w4')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'w5',
            'render': function(data, type, row) {
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-theme" onclick="detail_rekap('${row['user_id']}','w5')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'tasklist',
            'render': function(data, type, row) {
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-theme" onclick="detail_rekap('${row['user_id']}','1')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'keputusan',
            'render': function(data, type, row) {
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-info" onclick="detail_rekap('${row['user_id']}','2')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          // {
          //   'data': 'konsep',
          //   'render': function(data, type, row) {
          //     if (data == 0) {
          //       return `<u class="text-secondary">${data}</u>`;
          //     } else {
          //       return `<span class="btn btn-sm btn-outline-info" onclick="detail_rekap('${row['user_id']}','3')">${data}</span>`;
          //     }
          //   },
          //   'className': 'text-center'
          // },
          // {
          //   'data': 'statement',
          //   'render': function(data, type, row) {
          //     if (data == 0) {
          //       return `<u class="text-secondary">${data}</u>`;
          //     } else {
          //       return `<span class="btn btn-sm btn-outline-info" onclick="detail_rekap('${row['user_id']}','4')">${data}</span>`;
          //     }
          //   },
          //   'className': 'text-center'
          // },
          // {
          //   'data': 'instruksi',
          //   'render': function(data, type, row) {
          //     if (data == 0) {
          //       return `<u class="text-secondary">${data}</u>`;
          //     } else {
          //       return `<span class="btn btn-sm btn-outline-info" onclick="detail_rekap('${row['user_id']}','5')">${data}</span>`;
          //     }
          //   },
          //   'className': 'text-center'
          // },
          // {
          //   'data': 'strategi',
          //   'render': function(data, type, row) {
          //     if (data == 0) {
          //       return `<u class="text-secondary">${data}</u>`;
          //     } else {
          //       return `<span class="btn btn-sm btn-outline-info" onclick="detail_rekap('${row['user_id']}','6')">${data}</span>`;
          //     }
          //   },
          //   'className': 'text-center'
          // },
          // {
          //   'data': 'brainstorming',
          //   'render': function(data, type, row) {
          //     if (data == 0) {
          //       return `<u class="text-secondary">${data}</u>`;
          //     } else {
          //       return `<span class="btn btn-sm btn-outline-info" onclick="detail_rekap('${row['user_id']}','7')">${data}</span>`;
          //     }
          //   },
          //   'className': 'text-center'
          // },
          {
            'data': 'daily',
            'render': function(data, type, row) {
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-info" onclick="detail_rekap('${row['user_id']}','8')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'weekly',
            'render': function(data, type, row) {
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-info" onclick="detail_rekap('${row['user_id']}','9')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'monthly',
            'render': function(data, type, row) {
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-info" onclick="detail_rekap('${row['user_id']}','10')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'progres',
            'render': function(data, type, row) {
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-warning" onclick="detail_rekap('${row['user_id']}','30')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'revisi',
            'render': function(data, type, row) {
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-danger" onclick="detail_rekap('${row['user_id']}','70')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'done',
            'render': function(data, type, row) {
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-success" onclick="detail_rekap('${row['user_id']}','40')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'ontime',
            'render': function(data, type, row) {
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-success" onclick="detail_rekap('${row['user_id']}','50')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'late',
            'render': function(data, type, row) {
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-danger" onclick="detail_rekap('${row['user_id']}','60')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'freq_revisi',
            'render': function(data, type, row) {
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-danger" onclick="detail_rekap('${row['user_id']}','70')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'total_lock',
            'render': function(data, type, row) {
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-danger" onclick="detail_rekap('${row['user_id']}','80')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
        ]
      });
  }

  function detail_rekap(user_id, tipe) {
    $("#modal_detail_rekap").modal('show');
    // Disini Ada Deadlinenya
    tipe_deadline = ['1', '5', '6', '8', '9', '10', '30', '40', '50', '60', 'w1', 'w2', 'w3', 'w4', 'w5'];

    // $.inArray( tipe, tipe_deadline ) != -1
    if ($.inArray(tipe, tipe_deadline) == -1) { // Jika tidak masuk list yang ada Deadlinenya maka tidak muncul
      hide_column = [{
        targets: [7, 8, 9, 10, 11, 12, 13],
        visible: false
      }];
    } else {
      hide_column = [{
        targets: [7, 8, 9, 10, 11, 12, 13],
        visible: true
      }];
    }
    $('#dt_detail_rekap').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        text: '<i class="bi bi-download text-white"></i>',
        name: 'List Rekap Point',
        footer: true
      }],
      columnDefs: hide_column,
      "ajax": {
        "url": "<?= base_url("mom/get_detail_rekap") ?>",
        "type": "POST",
        "dataType": 'JSON',
        "data": {
          datestart: $("#start").val(),
          dateend: $("#end").val(),
          user_id: user_id,
          tipe: tipe
        },
        // "success": function (res){
        //   console.log(res);
        // },
        // "error": function (jqXHR){
        //   console.log(jqXHR.responseText);
        // }
      },
      "columns": [{
          'data': 'locked',
          'render': function(data, type, row) {
            if (data == 'Locked') {
              return `<span class="badge bg-danger">${data}</span>`;
            } else {
              return `<span class="badge bg-success">${data}</span>`;
            }
          }
        },
        {
          'data': 'id_mom'
        },
        {
          'data': 'tgl_meeting'
        },

        {
          'data': 'employee_name'
        },
        {
          'data': 'topik'
        },
        {
          'data': 'issue'
        },
        {
          'data': 'action'
        },
        {
          'data': 'kategori'
        },
        {
          'data': 'level'
        },
        {
          'data': 'due_date'
        },
        {
          'data': 'deadline'
        },
        {
          'data': 'done_date'
        },
        {
          'data': 'leadtime'
        },
        {
          'data': 'status',
          'render': function(data, type, row) {
            id_user = <?= $_SESSION['user_id'] ?>;
            if (row['id_status'] == 2) {
              return `<a href="https://trusmiverse.com/apps/ibr_update?id=${row['id_sub_task']}&u=${id_user}" target="_blank" class="badge bg-sm" style="background-color:${row['color']}">${data}</a>`;
            } else if (data == '') {
              return data;
            } else {
              return `<span class="badge bg-sm" style="background-color:${row['color']}">${data}</span>`;
            }
          }
        },
        {
          'data': 'progres'
        },
        {
          'data': 'evaluasi'
        },
        {
          'data': 'file',
          'render': function(data, type, row) {
            if (data != "") {
              return `<a href="<?= base_url(); ?>uploads/monday/history_sub_task/${data}" target="_blank" class="text-success"><i class="bi bi-file-earmark-medical"></i></a>`;
            } else {
              return ``;
            }
          },
          'className': 'text-center'
        },
        {
          'data': 'link',
          'render': function(data, type, row) {
            if (data != "") {
              return `<a href="${data}" target="_blank" class="text-primary"><i class="bi bi-door-open"></i></a>`;
            } else {
              return ``;
            }
          },
          'className': 'text-center'
        },
        {
          'data': 'created_at'
        },
        {
          'data': 'created_by'
        },
        {
          'data': 'verified_note'
        },
      ]
    });
  }
  // End List Rekap

  function detail_mom(id) {
    $("#modal_detail_mom").modal("show");
    list_result_e(id);
  }

  function list_result_e(id) {
    $('#dt_mom_result_e').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": false,
      "paging": false,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
          extend: 'excelHtml5',
          text: '<i class="bi bi-download text-white"></i>',
          footer: true
        },
        // {
        //   text: 'Refresh',
        //   action: function(e,dt,node,settings){
        //     $("#dt_mom_result_e").DataTable().ajax.reload();
        //   },
        //   footer: true
        // }
      ],
      "ajax": {
        "dataType": 'JSON',
        "type": "GET",
        "url": "<?= base_url("mom/get_result_meeting/") ?>" + id,
        // "success": function (res){
        //   console.log(res);
        // },
        // "error": function (jqXHR){
        //   console.log(jqXHR.responseText);
        // }
      },
      "columns": [{
          'data': 'topik',
          'render': function(data, type, row) {
            return `${data}`;
          }
        },
        {
          'data': 'issue',
          'render': function(data, type, row) {
            return `${data}`;
          }
        },
        {
          'data': 'action',
          'render': function(data, type, row) {
            return `${data}`;
          }
        },
        {
          'data': 'kategori',
          'render': function(data, type, row, meta) {
            no = meta.row + 1;
            if (row['id_kategori'] == "") {
              return `<select class="form-control" id="e_kategori_${no}" name="e_kategori_${no}" onfocusout="update_result('${row['id_mom']}','${row['id_issue']}','${row['id_issue_item']}','${row['id_task']}','${row['id_sub_task']}','e_kategori_${no}')">
                      <option>- Choose -</option>
                      <?php foreach ($kategori as $ktg) : ?>
                          <option value="<?= $ktg->id ?>"><?php echo $ktg->kategori ?></option>
                      <?php endforeach ?>
                    </select>`;
            } else {
              return data;
            }
          }
        },
        {
          'data': 'level',
          'render': function(data, type, row) {
            return `${data}`;
          }
        },
        {
          'data': 'deadline',
          'render': function(data, type, row, meta) {
            no = meta.row + 1;
            return `<input type="text" class="form-control ${(row['id_kategori'] == '1' || row['id_kategori'] == '5' || row['id_kategori'] == '6' || row['id_kategori'] == '8' || row['id_kategori'] == '9' || row['id_kategori'] == '10'  || row['id_kategori'] == '11') ? 'tanggal' : '' }" id="e_deadline_${no}" name="e_deadline_${no}" value="${data}" onfocusout="update_result('${row['id_mom']}','${row['id_issue']}','${row['id_issue_item']}','${row['id_task']}','${row['id_sub_task']}','e_deadline_${no}')">`;
          }
        },
        {
          'data': 'list_pic',
          'render': function(data, type, row) {
            return `${data}`;
          }
        },
        {
          'data': 'ekspektasi',
        },
        {
          'data': 'verified_status',
          'render': function(data, type, row) {
            return `${data}<br><small>${row['verified_note']}</small>`;
          }
        },
        {
          'data': 'verified_by'
        }

      ],
      "initComplete": function(settings, json) {
        aktifkan_datepicker();
      }
    });
  }

  // Reminder Whatsapp
  function reminder_whatsapp(id) {
    $.confirm({
      title: 'Prompt!',
      type: 'blue',
      theme: 'material',
      content: 'Are you sure for send Reminder ?',
      buttons: {
        cancel: function() {
          //close
        },
        formSubmit: {
          text: 'Submit',
          btnClass: 'btn-blue',
          action: function() {
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
                  "url": "<?= base_url("mom/send_wa_mom/") ?>" + id + "/reminder",
                  "type": "GET",
                  "dataType": 'TEXT',
                  "success": function(res) {
                    console.log(res);
                    new PNotify({
                      title: `Success`,
                      text: `Reminder has been sent`,
                      icon: 'icofont icofont-brand-whatsapp',
                      type: 'success',
                      delay: 3000,
                    });
                  },
                  "error": function(jqXHR) {
                    console.log(jqXHR);
                    console.log(jqXHR.responseText);
                  }
                }).done(function(response) {
                  setTimeout(() => {
                    jconfirm.instances[0].close();
                    $.confirm({
                      icon: 'fa fa-check',
                      title: 'Done!',
                      theme: 'material',
                      type: 'blue',
                      content: 'Resend notif!',
                      buttons: {
                        close: {
                          actions: function() {}
                        },
                      },
                    });
                  }, 250);
                }).fail(function(jqXHR, textStatus) {
                  setTimeout(() => {
                    jconfirm.instances[0].close();
                    $.confirm({
                      icon: 'fa fa-close',
                      title: 'Oops!',
                      theme: 'material',
                      type: 'red',
                      content: 'Gagal Resend Notif!' + textStatus,
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
    });
    // $.ajax({
    //   "url": "<?= base_url("mom/send_wa_mom") ?>"+id+"/reminder",
    //   "type": "GET",
    //   "dataType": 'TEXT',
    //   "success": function (res){
    //     console.log(res);       
    //     new PNotify({
    //         title: `Success`,
    //         text: `Reminder has been sent`,
    //         icon: 'icofont icofont-brand-whatsapp',
    //         type: 'success',
    //         delay: 3000,
    //     });
    //   },
    //   "error": function (jqXHR){
    //     console.log(jqXHR);
    //     console.log(jqXHR.responseText);
    //   }
    // });
  }

  // Tambahan untuk Edit Deadline di Result Meeting
  function aktifkan_datepicker() {
    $('.tanggal').datetimepicker({
      format: 'Y-m-d',
      timepicker: false,
      minDate: 0,
    });
  }

  function update_result(id, issue, item, id_task, id_sub_task, val) {
    // console.log(id,issue,item,id_task,id_sub_task,val);
    val_new = $(`#${val}`).val();
    res = val.split('_');
    title = res[1].substr(0, 1).toUpperCase() + res[1].substr(1);
    $.ajax({
      "url": "<?= base_url("mom/update_result") ?>",
      "type": "POST",
      "dataType": 'JSON',
      "data": {
        id_mom: id,
        id_issue: issue,
        id_issue_item: item,
        val: val_new,
        id_task: id_task,
        id_sub_task: id_sub_task,
        tipe: res[1]
      },
      "success": function(res) {
        // console.log(res);
        new PNotify({
          title: `Success`,
          text: `${title} has been updated`,
          icon: 'icofont icofont-checked',
          type: 'success',
          delay: 3000,
        });
        $("#dt_mom_result_e").DataTable().ajax.reload();
        list_result_e(id);
      },
      "error": function(jqXHR) {
        console.log(jqXHR.responseText);
      }
    });
  }
  // End Edit Deadline

  // Fitur Tambahan Draft
  function draft(closed) {
    id_mom = $("#id_mom_global").val();
    $("#closed").val(closed);

    if (id_mom == "") {
      $.ajax({
        method: "POST",
        url: "<?= base_url("mom/save_mom") ?>",
        dataType: "JSON",
        data: $("#form_detail").serialize(),
        beforeSend: function(res) {
          $('#btn_draft').attr("disabled", true);
        },
        success: function(res) {
          // console.log(res);
          $("#modal_add_mom").modal("hide");
          $("#dt_list_mom").DataTable().ajax.reload();
          $('#btn_draft').removeAttr("disabled");
          // swal("Success", "Data has been drafted!", "info");
          $.confirm({
            icon: 'fa fa-check',
            title: 'Success',
            theme: 'material',
            type: 'green',
            content: 'Data has been drafted!',
            buttons: {
              close: {
                actions: function() {}
              },
            },
          });

          if ($("#id_plan_global").val() != "") {
            $("#dt_list_plan").DataTable().ajax.reload();
            $("#id_plan").val("");
            $("#id_plan_global").val("");
          }

          return true;
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
          return false;
        }
      });
    } else {
      closing = $("#closing").val();

      // Start Closing Draft
      $.confirm({
        icon: 'fa fa-spinner fa-spin',
        title: 'Please wait!',
        theme: 'material',
        type: 'blue',
        content: 'Processing...',
        buttons: {
          close: {
            isHidden: true,
            actions: function() {}
          },
        },
        onOpen: function() {
          // Start Closing Draft
          $.ajax({
            url: "<?= base_url("mom/save_closing") ?>",
            method: "POST",
            dataType: "JSON",
            data: {
              id_mom: id_mom,
              closing: closing,
              closed: 0 // Draft
            },
            beforeSend: function(res) {
              $('#btn_draft').attr("disabled", true);
            },
            success: function(res) {
              // console.log(res);
              $("#modal_add_mom").modal("hide");
              $("#dt_list_mom").DataTable().ajax.reload();
              $('#btn_draft').removeAttr("disabled");
              $.confirm({
                icon: 'fa fa-check',
                title: 'Success',
                theme: 'material',
                type: 'green',
                content: 'Data has been drafted!',
                buttons: {
                  close: {
                    actions: function() {}
                  },
                },
              });

              if ($("#id_plan_global").val() != "") {
                $("#dt_list_plan").DataTable().ajax.reload();
                $("#id_plan").val("");
                $("#id_plan_global").val("");
              }

              jconfirm.instances[0].close();
              return true;
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(jqXHR.responseText);
              jconfirm.instances[0].close();
            }
          });
          // End
        }
      });
      // End
    }
  }

  function open_list_draft(start, end) {
    $("#modal_list_draft").modal("show");
    list_draft(start, end);
  }

  function list_draft(start, end) {
    $('#dt_list_draft').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      "ordering": false,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "dataType": 'JSON',
        "type": "POST",
        "url": "<?= base_url("mom_handika/get_list_mom") ?>",
        "data": {
          datestart: start,
          dateend: end,
          closed: 0
        },
        // "success": function (res){
        //   console.log(res);
        // },
        // "error": function (jqXHR){
        //   console.log(jqXHR.responseText);
        // }
      },
      "columns": [{
          'data': 'id_mom',
          'render': function(data, type, row) {
            if (<?php echo $_SESSION['user_id']; ?> == row['user_id']) {
              return `<a href="javascript:void(0);" class="btn btn-sm btn-warning mb-2 text-white" onclick="proses_draft('${data}')"><i class="bi bi-box-arrow-in-right"></i></a>
              <a href="javascript:void(0);" class="btn btn-sm btn-danger mb-2 text-white" onclick="hapus_draft('${data}')"><i class="bi bi-trash"></i></a>`;
            } else {
              return `<a href="javascript:void(0);" class="btn btn-sm btn-warning text-white" onclick="proses_draft('${data}')"><i class="bi bi-box-arrow-in-right"></i></a>`;
            }
          }
        },
        {
          'data': 'judul'
        },
        {
          'data': 'meeting'
        },
        {
          'data': 'department'
        },
        {
          'data': 'peserta',
          'render': function(data, type, row, meta) {
            avatar_pic = ``;
            avatar_pic_plus = ``;
            if (row['pp_peserta'].indexOf(',') > -1) {
              array_pic = row['pp_peserta'].split(',');
              for (let index = 0; index < array_pic.length; index++) {
                if (index < 2) {
                  avatar_pic += `<div class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${array_pic[index]}&quot;);">
                          <img src="http://trusmiverse.com/hr/uploads/profile/${array_pic[index]}" alt="" style="display: none;">
                          </div>`;
                }
              }
              if (array_pic.length > 2) {
                avatar_pic_plus = `<div class="avatar avatar-30 bg-light-theme rounded-circle me-1">
                              <p class="small">${parseInt(array_pic.length)-2}+</p>
                          </div>`;
              } else {
                avatar_pic_plus = '';
              }
              return `<div class="d-flex justify-content-center" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${row['peserta']}">
                              ${avatar_pic}${avatar_pic_plus}  
                          </div>`;
            } else {
              return `
                      <div class="row">
                          <div class="col-auto align-self-center">
                              <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${row['pp_peserta']}&quot;);">
                                  <img src="http://trusmiverse.com/hr/uploads/profile/${row['pp_peserta']}" alt="" style="display: none;">
                              </figure>
                          </div>
                          <div class="col px-0 align-self-center">
                              <p class="mb-0 small">${row['peserta']}</p>
                          </div>
                      </div>`;
            }
          },
          "className": "d-none d-md-table-cell text-left"
        },
        {
          'data': 'agenda'
        },
        {
          'data': 'tempat'
        },
        {
          'data': 'tgl'
        },
        {
          'data': 'waktu'
        },
        {
          'data': 'created_by',
          'render': function(data, type, row, meta) {
            return `<div class="row">
                          <div class="col-auto align-self-center">
                              <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${row['profile_picture']}&quot;);">
                                  <img src="http://trusmiverse.com/hr/uploads/profile/${row['profile_picture']}" alt="" style="display: none;">
                              </figure>
                          </div>
                          <div class="col px-0 align-self-center">
                              <p class="mb-0 small">${row['username']}</p>
                              <p class="small text-secondary small">${row['created_at']}</p>
                          </div>
                      </div>`;
          },
          "className": "d-none d-md-table-cell text-left"
        }
      ]
    });
  }

  function proses_draft(id) {
    $("#btn_finish_e").hide();
    $("#modal_proses_draft").modal("show");
    $("#smartwizard3").smartWizard("reset");
    $('.check-valid').removeClass('is-valid');
    $('.check-valid').removeClass('is-invalid');
    $.ajax({
      url: "<?= base_url("mom/get_draft_header/") ?>" + id,
      method: "GET",
      dataType: "JSON",
      beforeSend: function(res) {
        $('#btn_draft').attr("disabled", true);
      },
      success: function(dt) {
        // console.log(dt);
        $("#id_mom_draft").val(dt.id_mom);
        $("#id_mom_global_draft").val(dt.id_mom);
        $("#judul_draft").val(dt.judul);
        $("#tempat_draft").val(dt.tempat);
        $("#tanggal_draft").val(dt.tgl);
        $("#start_time_draft").val(dt.start_time);
        $("#end_time_draft").val(dt.end_time);
        $("#meeting_draft").val(dt.meeting);
        if (dt.meeting == "Owner") {
          $(".hidden_department_draft").addClass('d-none');
        } else {
          $(".hidden_department_draft").removeClass('d-none');
        }
        if (dt.department != null) {
          department_draft.setSelected(dt.department.split(','));
        }
        $("#agenda_draft").val(dt.agenda);
        peserta_draft.setSelected(dt.peserta.split(','));
        $("#user_draft").val(dt.peserta);
        $('#pembahasan_draft').summernote('code', dt.pembahasan);
        $("#pembahasan_draft").text(dt.pembahasan);
        $('#closing_draft').summernote('code', dt.closing_statement);
        $("#closing_draft").text(dt.closing_statement);
        if (dt.id_project != null && dt.id_project != 0) {
          $('#e_pekerjaan').val(dt.nama_pekerjaan);
          $('#e_sub_pekerjaan').val(dt.nama_sub_pekerjaan);
          $('#e_detail_pekerjaan').val(dt.nama_detail_pekerjaan);
          $('#e_project').val(dt.nama_project);
          $('#e_btn_show_pekerjaan').removeClass('bi-square');
          $('#e_btn_show_pekerjaan').addClass('bi-check-square');
          $('#e_pekerjaan_row').removeClass('d-none');
          $('#draft_project').val(dt.id_project);
          $('#draft_pekerjaan').val(dt.id_pekerjaan);
          $('#draft_sub_pekerjaan').val(dt.id_sub_pekerjaan);
          $('#draft_detail_pekerjaan').val(dt.id_detail_pekerjaan);
        } else {
          $('#e_btn_show_pekerjaan').addClass('bi-square');
          $('#e_btn_show_pekerjaan').removeClass('bi-check-square');
          $('#e_pekerjaan_row').addClass('d-none');
          $('#draft_project').val(null);
          $('#draft_pekerjaan').val(null);
          $('#draft_sub_pekerjaan').val(null);
          $('#draft_detail_pekerjaan').val(null);
        }
        // Pindah prosesnya tidak dari sini 
        // get_issue_result($("#id_mom_global_draft").val());
        // console.log(res.send);
        // return true;              
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });
  }

  function draft_e(closed) {
    id_mom = $("#id_mom_global_draft").val();
    $("#closed_draft").val(closed);

    if (id_mom == "") {
      $.ajax({
        method: "POST",
        url: "<?= base_url("mom/save_mom_draft") ?>",
        dataType: "JSON",
        data: $("#form_detail").serialize(),
        beforeSend: function(res) {
          $('#btn_draft_e').attr("disabled", true);
        },
        success: function(res) {
          // console.log(res);
          $("#modal_proses_draft").modal("hide");
          $("#dt_list_draft").DataTable().ajax.reload();
          $('#btn_draft_e').removeAttr("disabled");
          // swal("Success", "Data has been drafted!", "info");
          $.confirm({
            icon: 'fa fa-check',
            title: 'Success',
            theme: 'material',
            type: 'green',
            content: 'Data has been drafted!',
            buttons: {
              close: {
                actions: function() {}
              },
            },
          });
          return true;
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
          return false;
        }
      });
    } else {
      closing = $("#closing_draft").val();

      // Start Closing Draft
      $.confirm({
        icon: 'fa fa-spinner fa-spin',
        title: 'Please wait!',
        theme: 'material',
        type: 'blue',
        content: 'Processing...',
        buttons: {
          close: {
            isHidden: true,
            actions: function() {}
          },
        },
        onOpen: function() {
          // Start Closing Draft
          $.ajax({
            url: "<?= base_url("mom/save_closing") ?>",
            method: "POST",
            dataType: "JSON",
            data: {
              id_mom: id_mom,
              closing: closing,
              closed: 0 // Draft
            },
            beforeSend: function(res) {
              $('#btn_draft_e').attr("disabled", true);
            },
            success: function(res) {
              // console.log(res);
              $("#modal_proses_draft").modal("hide");
              $("#dt_list_draft").DataTable().ajax.reload();
              $("#dt_list_mom").DataTable().ajax.reload();
              $('#btn_draft_e').removeAttr("disabled");
              $.confirm({
                icon: 'fa fa-check',
                title: 'Success',
                theme: 'material',
                type: 'green',
                content: 'Data has been drafted!',
                buttons: {
                  close: {
                    actions: function() {}
                  },
                },
              });

              jconfirm.instances[0].close();
              return true;
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(jqXHR.responseText);
              jconfirm.instances[0].close();
            }
          });
          // End
        }
      });
      // End
    }
  }

  function finish_draft(closed) {
    id_mom = $("#id_mom_global_draft").val();
    closing = $("#closing_draft").val();
    project = $('#draft_project').val();
    pekerjaan = $('#draft_pekerjaan').val();
    sub_pekerjaan = $('#draft_sub_pekerjaan').val();
    detail_pekerjaan = $('#draft_detail_pekerjaan').val();
    console.log(detail_pekerjaan);

    $("#closed_draft").val(closed);

    if (closing == '' || closing == '<p><br></p>' || closing == '<br>') {
      $(".closing_draft").removeClass('is-valid');
      $(".closing_draft").addClass('is-invalid');
      swal("Warning", "Closing Statement belum terisi", "info");
      $("#closed_draft").val(0);
      return false;
    } else {

      // Start
      $.confirm({
        icon: 'fa fa-spinner fa-spin',
        title: 'Please wait!',
        theme: 'material',
        type: 'blue',
        content: 'Processing...',
        buttons: {
          close: {
            isHidden: true,
            actions: function() {}
          },
        },
        onOpen: function() {
          // Start
          $.ajax({
            url: "<?= base_url("mom/save_closing") ?>",
            method: "POST",
            dataType: "JSON",
            data: {
              id_mom: id_mom,
              closing: closing,
              closed: closed, // Finish
              project: project,
              pekerjaan: pekerjaan,
              sub_pekerjaan: sub_pekerjaan,
              detail_pekerjaan: detail_pekerjaan
            },
            beforeSend: function(res) {
              $('#btn_finish_e').attr("disabled", true);
            },
            success: function(res) {
              // console.log(res);    
              $("#dt_list_draft").DataTable().ajax.reload();
              $("#dt_list_mom").DataTable().ajax.reload();
              $('#btn_finish_e').removeAttr("disabled");
              // swal("Success!!", "Data has been saved!", "success");
              $("#modal_proses_draft").modal("hide");
              $.confirm({
                icon: 'fa fa-check',
                title: 'Success',
                theme: 'material',
                type: 'green',
                content: 'Data has been saved!',
                buttons: {
                  close: function() {
                    console.log('Disabled Reload Finish Draft');
                    // window.location.reload();
                  },
                },
              });
              jconfirm.instances[0].close();
              return true;
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(jqXHR.responseText);
              jconfirm.instances[0].close();
            }
          });
          // End
        }
      });
      // End  
    }
  }

  // Result Draft
  function get_issue_result(id_mom) {
    var tipe_meeting = $('#meeting_draft').val();
    // if(tipe_meeting == 'Owner'){
    //     $('#draf_ekspektasi').show();
    //   }else{
    //   $('#draf_ekspektasi').hide();

    // }
    $.confirm({
      icon: 'fa fa-spinner fa-spin',
      title: 'Please waiting..!',
      theme: 'material',
      type: 'blue',
      content: 'Processing...',
      buttons: {
        close: {
          isHidden: true,
          actions: function() {}
        },
      },
      onOpen: function() {
        $.ajax({
            url: '<?php echo base_url() ?>mom/get_issue_result/' + id_mom,
            type: 'GET',
            dataType: 'JSON',
            cache: false,
          })
          .done(function(data) {
            $('#data_issue').empty().html(data.table);

            $('.tanggal').datetimepicker({
              format: 'Y-m-d',
              timepicker: false,
              minDate: 0,
            });

            // Kondisi Data Resultnya
            console.log('Data : ', data);
            if (data.result > 0) {
              $("#total_issue_draft").val(data.result);
              $.each(data.pic, function(index, val) {
                console.log(val.id)
                pic_draft = new SlimSelect({
                  select: "#" + val.id
                });

                pic_draft.setSelected(val.pic)
              });
            } else {
              pic_draft = new SlimSelect({
                select: "#val_pic_draft_1_1"
              });
            }


            jconfirm.instances[0].close();
          })
          .fail(function(xhr) {
            console.log("error", xhr.responseText);
            jconfirm.instances[0].close();
          })
          .always(function() {
            console.log("complete");
            jconfirm.instances[0].close();
          });
      }
    });
    // $.confirm({
    //   icon: 'fa fa-spinner fa-spin',
    //   title: 'Mohon Tunggu!',
    //   theme: 'material',
    //   type: 'blue',
    //   content: 'Sedang memproses...',
    //   buttons: {
    //       close: {
    //           isHidden: true,
    //           actions: function() {}
    //       },
    //   },
    //   onOpen: function() {
    //     $.ajax({                    
    //       "url": "<?= base_url("mom/send_wa_mom") ?>"+id+"/reminder",
    //       "type": "GET",
    //       "dataType": 'TEXT',
    //       "success": function (res){
    //         console.log(res);       
    //         new PNotify({
    //             title: `Success`,
    //             text: `Reminder has been sent`,
    //             icon: 'icofont icofont-brand-whatsapp',
    //             type: 'success',
    //             delay: 3000,
    //         });
    //       },
    //       "error": function (jqXHR){
    //         console.log(jqXHR);
    //         console.log(jqXHR.responseText);
    //       }
    //     }).done(function(response) {
    //         setTimeout(() => {
    //             jconfirm.instances[0].close();
    //             $.confirm({
    //                 icon: 'fa fa-check',
    //                 title: 'Done!',
    //                 theme: 'material',
    //                 type: 'blue',
    //                 content: 'Resend notif!',
    //                 buttons: {
    //                     close: {
    //                         actions: function() {}
    //                     },
    //                 },
    //             });
    //         }, 250);
    //     }).fail(function(jqXHR, textStatus) {
    //         setTimeout(() => {
    //             jconfirm.instances[0].close();
    //             $.confirm({
    //                 icon: 'fa fa-close',
    //                 title: 'Oops!',
    //                 theme: 'material',
    //                 type: 'red',
    //                 content: 'Gagal Resend Notif!' + textStatus,
    //                 buttons: {
    //                     close: {
    //                         actions: function() {}
    //                     },
    //                 },
    //             });
    //         }, 250);
    //     });
    //   },
    // });
    // End Spinner
  }
  // End Result Draft
  // End Fitur Draft

  function add_plan_mom() {
    $("#modal_add_plan_mom").modal("show");
  }

  function save_plan() {
    if ($("#judul_plan").val() == "") {
      $(".judul_plan").removeClass('is-valid');
      $(".judul_plan").addClass('is-invalid');
      $("#judul_plan").focus();
    } else if ($("#tempat_plan").val() == "") {
      $(".tempat_plan").removeClass('is-valid');
      $(".tempat_plan").addClass('is-invalid');
      $("#tempat_plan").focus();
    } else if ($("#tanggal_plan").val() == "") {
      $(".tgl_plan").removeClass('is-valid');
      $(".tgl_plan").addClass('is-invalid');
      $("#tanggal_plan").focus();
    } else if ($("#meeting_plan :selected").val() == "") {
      $(".meeting_plan").removeClass('is-valid');
      $(".meeting_plan").addClass('is-invalid');
      $("#meeting_plan").focus();
    } else if ($("#list_department_plan").val() == "" && ($("#meeting_plan :selected").val() == "Internal" || $("#meeting_plan :selected").val() == "Koordinasi")) {
      $(".department_plan").removeClass('is-valid');
      $(".department_plan").addClass('is-invalid');
      department_plan.open();
    } else if ($("#user_plan").val() == "") {
      $(".peserta_plan").removeClass('is-valid');
      $(".peserta_plan").addClass('is-invalid');
      peserta_plan.open();
    } else {
      $.ajax({
        url: "<?= base_url("mom/save_plan") ?>",
        method: "POST",
        dataType: "JSON",
        data: $("#form_plan").serialize(),
        beforeSend: function(res) {
          $("#btn_save_plan").attr("disabled", true);
        },
        success: function(res) {
          $.confirm({
            icon: 'fa fa-check',
            title: 'Success',
            theme: 'material',
            type: 'green',
            content: 'Plan has been saved!',
            buttons: {
              close: {
                actions: function() {}
              },
            },
          });

          new PNotify({
            title: `Success`,
            text: `Autonotif has been sent`,
            icon: 'icofont icofont-brand-whatsapp',
            type: 'success',
            delay: 1000,
          });
          $("#modal_add_plan_mom").modal("hide");
          // $("#dt_list_mom").DataTable().ajax.reload();
          peserta_plan.setSelected([]);
          $("#form_plan")[0].reset();
          $("#btn_save_plan").removeAttr("disabled");
        },
        error: function(jqXHR) {
          console.log(jqXHR.responseText);
        }
      });
    }
  }

  function list_plan_mom() {
    $("#modal_list_plan").modal("show");
    $('#dt_list_plan').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "dataType": 'JSON',
        "type": "POST",
        "url": "<?= base_url("mom/get_list_plan") ?>",
        // "data": {
        //   datestart: null,
        //   dateend: null,
        //   closed: 0
        // },        
        // "success": function (res){
        //   console.log(res);
        // },
        // "error": function (jqXHR){
        //   console.log(jqXHR.responseText);
        // }
      },
      "columns": [{
          'data': 'id_plan',
          'render': function(data, type, row) {
            if (row['status_plan'] == 'Done') {
              return `<span class="badge bg-success">${row['status_plan']}</span>`;
            } else {
              return `<a href="javascript:void(0);" class="btn btn-sm btn-warning" onclick="proses_plan('${data}')"><i class="bi bi-box-arrow-in-right"></i></a>`;
            }
          }
        },
        {
          'data': 'judul'
        },
        {
          'data': 'tempat'
        },
        {
          'data': 'tgl'
        },
        {
          'data': 'waktu'
        },
        {
          'data': 'meeting'
        },
        {
          'data': 'department'
        },
        {
          'data': 'peserta',
          // 'render': function(data, type, row, meta) {
          //     avatar_pic = ``;
          //     avatar_pic_plus = ``;
          //     if (row['pp_peserta'].indexOf(',') > -1) {
          //         array_pic = row['pp_peserta'].split(',');
          //         for (let index = 0; index < array_pic.length; index++) {
          //             if (index < 2) {
          //                 avatar_pic += `<div class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${array_pic[index]}&quot;);">
          //                 <img src="http://trusmiverse.com/hr/uploads/profile/${array_pic[index]}" alt="" style="display: none;">
          //                 </div>`;
          //             }
          //         }
          //         if (array_pic.length > 2) {
          //             avatar_pic_plus = `<div class="avatar avatar-30 bg-light-theme rounded-circle me-1">
          //                     <p class="small">${parseInt(array_pic.length)-2}+</p>
          //                 </div>`;
          //         } else {
          //             avatar_pic_plus = '';
          //         }
          //         return `<div class="d-flex justify-content-center" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${row['peserta']}">
          //                     ${avatar_pic}${avatar_pic_plus}  
          //                 </div>`;
          //     } else {
          //         return `
          //             <div class="row">
          //                 <div class="col-auto align-self-center">
          //                     <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${row['pp_peserta']}&quot;);">
          //                         <img src="http://trusmiverse.com/hr/uploads/profile/${row['pp_peserta']}" alt="" style="display: none;">
          //                     </figure>
          //                 </div>
          //                 <div class="col px-0 align-self-center">
          //                     <p class="mb-0 small">${row['peserta']}</p>
          //                 </div>
          //             </div>`;
          //     }
          // },
          "className": "d-none d-md-table-cell text-left"
        },
        {
          'data': 'note'
        },
        {
          'data': 'created_by',
          // 'render': function(data, type, row, meta) {
          //     return `<div class="row">
          //                 <div class="col-auto align-self-center">
          //                     <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${row['profile_picture']}&quot;);">
          //                         <img src="http://trusmiverse.com/hr/uploads/profile/${row['profile_picture']}" alt="" style="display: none;">
          //                     </figure>
          //                 </div>
          //                 <div class="col px-0 align-self-center">
          //                     <p class="mb-0 small">${row['username']}</p>
          //                     <p class="small text-secondary small">${row['created_at']}</p>
          //                 </div>
          //             </div>`;
          // },
          "className": "d-none d-md-table-cell text-left"
        },
        {
          'data': 'deadline'
        },
        {
          'data': 'status_bahan',
          'render': function(data, type, row) {
            if (data == "Completed") {
              color = "success";
            } else {
              color = "warning";
            }
            return `<a href="javascript:void(0);" onclick="list_plan_bahan('${row['id_plan']}')" class="badge bg-${color}">${data}</a>`;
          }
        },
      ]
    });
  }

  function list_plan_bahan(id_plan) {
    $("#modal_list_plan_bahan").modal("show");
    $('#dt_list_plan_bahan').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "dataType": 'JSON',
        "type": "POST",
        "url": "<?= base_url("mom/get_list_plan_bahan") ?>",
        "data": {
          id_plan: id_plan
        },
        // "success": function (res){
        //   console.log(res);
        // },
        // "error": function (jqXHR){
        //   console.log(jqXHR.responseText);
        // }
      },
      "columns": [{
          'data': 'id_plan',
          'render': function(data, type, row) {
            // Link ini pakai Route di Config
            return `<a href="https://trusmiverse.com/apps/bahan_mom/${row['id']}" target="_blank" class="btn btn-sm btn-info"><i class="bi bi-box-arrow-up"></i></a>`;
          }
        },
        {
          'data': 'pic_name'
        },
        {
          'data': 'attachment',
          'render': function(data, type, row) {
            // console.log(data);
            if (data == "") {
              return data;
            } else {
              return `<a href="<?= base_url(); ?>uploads/mom/${data}" class="text-success" target="_blank"><i class="bi bi-file-medical"></i></a>`;
            }
          },
          'className': 'text-center'
        },
        {
          'data': 'link',
          'render': function(data, type, row) {
            if (data == "") {
              return data;
            } else {
              return `<a href="${data}" target="_blank" class="text-primary"><i class="bi bi-door-open"></i></a>`;
            }
          },
          'className': 'text-center'
        },
        {
          'data': 'note'
        },
        {
          'data': 'updated_by',
          // 'render': function(data, type, row, meta) {
          //     return `<div class="row">
          //                 <div class="col-auto align-self-center">
          //                     <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${row['profile_picture']}&quot;);">
          //                         <img src="http://trusmiverse.com/hr/uploads/profile/${row['profile_picture']}" alt="" style="display: none;">
          //                     </figure>
          //                 </div>
          //                 <div class="col px-0 align-self-center">
          //                     <p class="mb-0 small">${row['username']}</p>
          //                     <p class="small text-secondary small">${row['created_at']}</p>
          //                 </div>
          //             </div>`;
          // },
          "className": "d-none d-md-table-cell text-left"
        }
      ]
    });
  }

  function proses_plan(id_plan) {
    $("#btn_finish").hide();
    $('#pembahasan').summernote('reset');
    $('#closing').summernote('reset');
    peserta.setSelected([]);
    $("#id_mom").val("");
    $("#form_detail")[0].reset();
    $("#smartwizard2").smartWizard("reset");
    $('.check-valid').removeClass('is-valid');
    $('.check-valid').removeClass('is-invalid');

    // curdate = (new Date()).toISOString().split('T')[0];
    // $("#tanggal").val(curdate);

    $.ajax({
      url: "<?= base_url('mom/clear_result'); ?>",
      method: "GET",
      dataType: "JSON",
      cache: false,
      success: function(res) {
        $('#data_result').empty().html(res);

        $('.tanggal').datetimepicker({
          format: 'Y-m-d',
          timepicker: false,
          minDate: 0,
        });

        pic = new SlimSelect({
          select: ".pic"
        });

        // console.log(res);
      },
      error: function(xhr) {
        console.log(xhr.responseText);
      }
    });

    // Get Data Plan
    $.ajax({
      url: "<?= base_url('mom/get_data_plan/'); ?>" + id_plan,
      method: "GET",
      dataType: "JSON",
      success: function(res) {
        // console.log(res);
        $("#id_plan").val(id_plan);
        $("#id_plan_global").val(id_plan);
        $("#judul").val(res.judul);
        $("#tempat").val(res.tempat);
        $("#tanggal").val(res.tgl);
        $("#start_time").val(res.start_time);
        $("#meeting").val(res.meeting);
        // console.log(res.meeting);
        if (res.meeting == "Owner") {
          $(".hidden_department").addClass('d-none');
        } else {
          $(".hidden_department").removeClass('d-none');
        }
        if (res.department != null || res.department != "") {
          department.setSelected(res.department.split(','));
        }
        peserta.setSelected(res.peserta.split(','));
      },
      error: function(xhr) {
        console.log(xhr.responseText);
      }
    });

    $("#modal_add_mom").modal("show");
    $("#modal_add_mom").css("z-index", "1500");
  }

  function hapus_draft(id_mom) {
    $.confirm({
      title: 'Confirm!',
      type: 'red',
      theme: 'material',
      content: 'Are you sure for deleted this? Draft can`t be restore.',
      buttons: {
        cancel: function() {
          //close
        },
        formSubmit: {
          text: 'Delete',
          btnClass: 'btn-red',
          action: function() {
            $.confirm({
              icon: 'fa fa-spinner fa-spin',
              title: 'Mohon Tunggu!',
              theme: 'material',
              type: 'red',
              content: 'Sedang memproses...',
              buttons: {
                close: {
                  isHidden: true,
                  actions: function() {}
                },
              },
              onOpen: function() {
                $.ajax({
                  url: "<?= base_url('mom/hapus_draft/'); ?>" + id_mom,
                  method: "GET",
                  dataType: "JSON",
                  success: function(res) {
                    console.log(res);
                    $("#dt_list_draft").DataTable().ajax.reload();
                    jconfirm.instances[0].close();
                    $.confirm({
                      icon: 'fa fa-check',
                      title: 'Done!',
                      theme: 'material',
                      type: 'red',
                      content: 'Draft has been deleted!',
                      buttons: {
                        close: {
                          actions: function() {}
                        },
                      },
                    });
                  },
                  error: function(xhr) {
                    console.log(xhr.responseText);
                    jconfirm.instances[0].close();
                  }
                });
              },
            });
          }
        },
      },
    });
  }

  function list_verif(tipe) {
    $('#modal_list_verif').modal('show');
    var title = $('#modal_title_list_verif');
    if(tipe == 1){
      title.text('List Verified PDCA');
      url = 'list_verif_pdca';
      form = 'verif-form-pdca';
    }else{
      title.text('List Verified Owner');
      url = 'list_verif_owner';
      form = 'verif-form-owner';
    }
    var tabel_mom = $('#dt_list_verif').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
          extend: 'excelHtml5',
          text: '<i class="bi bi-download text-white"></i>',
          footer: true
        },
       
      ],
      "drawCallback": function() {
        $('.excel_detail').attr('href', `<?= base_url() ?>mom/excel_detail/${start}/${end}`);
      },
      "ajax": {
        "dataType": 'json',
        "type": "POST",
        "url": "<?= base_url("mom_handika/") ?>"+url,
        "dataSrc": ""

        // "success": function (res){
        //   console.log(res);
        // },
        // "error": function (jqXHR){
        //   console.log(jqXHR.responseText);
        // }
      },
      "columns": [{
          'data': 'topik',
          'render': function(data, type, row) {
            return `${data}`;
          }
        },
        {
          'data': 'issue',
          'render': function(data, type, row) {
            return `${data}`;
          }
        },
        {
          'data': 'action',
          'render': function(data, type, row) {
            return `${data}`;
          }
        },
        {
          'data': 'kategori',
          'render': function(data, type, row, meta) {
            no = meta.row + 1;
            if (row['id_kategori'] == "") {
              return `<select class="form-control" id="e_kategori_${no}" name="e_kategori_${no}" >
                      <option>- Choose -</option>
                      <?php foreach ($kategori as $ktg) : ?>
                          <option value="<?= $ktg->id ?>"><?php echo $ktg->kategori ?></option>
                      <?php endforeach ?>
                    </select>`;
            } else {
              return data;
            }
          }
        },
        {
          'data': 'level',
          'render': function(data, type, row) {
            return `${data}`;
          }
        },
        {
          'data': 'deadline',
          'render': function(data, type, row, meta) {
            no = meta.row + 1;
            // return `<input type="text" class="form-control ${(row['id_kategori'] == '1' || row['id_kategori'] == '5' || row['id_kategori'] == '6' || row['id_kategori'] == '8' || row['id_kategori'] == '9' || row['id_kategori'] == '10'  || row['id_kategori'] == '11') ? 'tanggal' : '' }" id="e_deadline_${no}" name="e_deadline_${no}" value="${data}" onfocusout="update_result('${row['id_mom']}','${row['id_issue']}','${row['id_issue_item']}','${row['id_task']}','${row['id_sub_task']}','e_deadline_${no}')">`;
            return `<input type="text" class="form-control ${(row['id_kategori'] == '1' || row['id_kategori'] == '5' || row['id_kategori'] == '6' || row['id_kategori'] == '8' || row['id_kategori'] == '9' || row['id_kategori'] == '10'  || row['id_kategori'] == '11') ? 'tanggal' : '' }" id="e_deadline_${no}" name="e_deadline_${no}" value="${data}" >`;
          }
        },
        {
          'data': 'pic',
          'render': function(data, type, row) {
            return `${data}`;
          }
        },
        {
          'data': 'ekspektasi',
        },
        {
          'data': 'evaluasi',
          'render': function(data, type, row) {
            let fileLink = '';
            let linkTag = '';

            if (row.file) {
              fileLink = `<a href="https://trusmiverse.com/apps/uploads/monday/history_sub_task/${row.file}" target="_blank" class="btn btn-sm btn-outline-primary">File</a>`;
            }
            if (row.link) {
              linkTag = `<a href="${row.link}" target="_blank" class="btn btn-sm btn-outline-primary">Link</a>`;
            }

            return `${data}<br>${fileLink} ${linkTag}`;
          }
        },
        {
          'data': 'created_by'
        },
        {
          'data': 'pdca_status',
          'render': function(data, type, row) {
            return `${data}<br><small>${row['pdca_note']}</small>`;
          }
        },
        {
          'data': 'pdca_by'
        },
        {
          'data': 'id_mom',
          'render': function(data, type, row) {
            if (row.id_owner_verified_status == null) {

              return `<div id="form_verif_owner_${row.id_item_issue}">
              <form class="${form}" data-id="${row.id_item_issue}">
                <input type="hidden" name="id_item_issue" value="${row.id_item_issue}">
                <input type="hidden" name="id_task" value="${row.id_task}">
                <input type="hidden" name="id_sub_task" value="${row.id_sub_task}">
                <select class="form-control" name="verified_status" style="min-width:200px" required>
                  <option value="" selected disabled>- Status -</option>
                  <option value="1">Oke</option>
                  <option value="2">Not Oke</option>
                </select>
                <textarea class="form-control" name="verified_note" rows="3" placeholder="Note Here.." required></textarea>
                <!-- Hapus atribut onclick -->
                <button type="submit" class="btn btn-sm btn-primary" id="save_verif_owner_${row.id_item_issue}">Save</button>
              </form>
            </div>
            `;
            } else {
              return `${row.owner_verified_status}<br><small>${row['owner_verified_note']}</small>`;
            }
          }
        }
      ]
    });
  }
  function list_eskalasi() {
    $('#modal_list_eskalasi').modal('show');
    var tabel_mom = $('#dt_list_eskalasi').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
          extend: 'excelHtml5',
          text: '<i class="bi bi-download text-white"></i>',
          footer: true
        },
       
      ],
      "drawCallback": function() {
        $('.excel_detail').attr('href', `<?= base_url() ?>mom/excel_detail/${start}/${end}`);
      },
      "ajax": {
        "dataType": 'json',
        "type": "POST",
        "url": "<?= base_url("mom_handika/list_eskalasi") ?>",
        "dataSrc": ""

        // "success": function (res){
        //   console.log(res);
        // },
        // "error": function (jqXHR){
        //   console.log(jqXHR.responseText);
        // }
      },
      "columns": [
       
        {
          'data': 'issue',
          'render': function(data, type, row) {
            return `${data}`;
          }
        },
        {
          'data': 'action',
          'render': function(data, type, row) {
            return `${data}`;
          }
        },
        
        {
          'data': 'deadline',
          
        },
        {
          'data': 'pic_name',
          'render': function(data, type, row) {
            return `${data}`;
          }
        },
        {
          'data': 'status',
          'render': function(data, type, row) {
            return `<span class="btn btn-sm text-white" style="background-color:${row.color}">${data}</span>`;
          }
        },
        {
          'data': 'progress',
          'render': function(data, type, row) {
            return `${data}`;
          }
        },
        {
          'data': 'evaluasi',
          'render': function(data, type, row) {
            let fileLink = '';
            let linkTag = '';

            if (row.file) {
              fileLink = `<a href="https://trusmiverse.com/apps/uploads/monday/history_sub_task/${row.file}" target="_blank" class="btn btn-sm btn-outline-primary">File</a>`;
            }
            if (row.link) {
              linkTag = `<a href="${row.link}" target="_blank" class="btn btn-sm btn-outline-primary">Link</a>`;
            }

            return `${data}<br>${fileLink} ${linkTag}`;
          }
        },
        
      ]
    });
  }

  $(document).on('submit', '.verif-form-owner', function(event) {
    event.preventDefault(); // Mencegah reload halaman

    let form = $(this);
    let itemId = form.data("id"); // Ambil item ID dari data-id
    let formData = form.serialize(); // Ambil data form

    $.ajax({
      url: "<?= base_url('mom/save_verified_owner'); ?>", // Ganti dengan URL untuk proses backend
      type: "POST",
      data: formData,
      success: function(response) {
        swal("Berhasil!", "Data Berhasil di update!", "info");
        $('#dt_list_verif').DataTable().ajax.reload();
      },
      error: function() {
        alert("Terjadi kesalahan, coba lagi.");
      }
    });
  });
  $(document).on('submit', '.verif-form-pdca', function(event) {
    event.preventDefault(); // Mencegah reload halaman

    let form = $(this);
    let itemId = form.data("id"); // Ambil item ID dari data-id
    let formData = form.serialize(); // Ambil data form

    $.ajax({
      url: "<?= base_url('mom/save_verified'); ?>", // Ganti dengan URL untuk proses backend
      type: "POST",
      data: formData,
      success: function(response) {
        swal("Berhasil!", "Data Berhasil di update!", "info");
        $('#dt_list_verif').DataTable().ajax.reload();
      },
      error: function() {
        alert("Terjadi kesalahan, coba lagi.");
      }
    });
  });



  // generate_head_resume_v3()

  function generate_head_resume_v3() {
    // let start = $('#start').val();
    // let end = $('#end').val();
    $.ajax({
      url: '<?= base_url() ?>mom_handika/generate_head_resume_v3',
      type: 'POST',
      dataType: 'json',
      // data: {
      //     start: start,
      //     end: end
      // },
      beforeSend: function() {

      },
      success: function(response) {

      },
      error: function(xhr) { // if error occured

      },
      complete: function() {

      },
    }).done(function(response) {
      // console.log(response)

      thead = '';
      thead = `<tr>
                      <th>Nama</th>
                      <th>Company</th>
                      <th>Jabatan</th>
                      `;
      for (let index = 0; index < response.data.length; index++) {
        const element = response.data[index];
        thead += `<th class="small text-center">${response.data[index].week_number} <br><span class="small">${response.data[index].f_tgl_awal}</span> s/d <span class="small">${response.data[index].f_tgl_akhir}</span></th>`;
      }
      thead += `</tr>`;

      tbody = '';
      for (let index = 0; index < response.body_resume.length; index++) {
        // console.log(response.data.length);
        tbody_td = '';
        if (response.data.length == 6) {
          tbody_td = `<td>${response.body_resume[index].w1 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${(response.body_resume[index].w2 > 0) ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w3 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w4 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w5 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w6 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          `
        } else if (response.data.length == 5) {
          tbody_td = `<td>${response.body_resume[index].w1 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${(response.body_resume[index].w2 > 0) ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w3 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w4 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w5 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          `
        } else if (response.data.length == 4) {
          tbody_td = `<td>${response.body_resume[index].w1 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${(response.body_resume[index].w2 > 0) ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w3 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w4 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w5 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          `
        }
        tbody += `<tr>
                          <td>${response.body_resume[index].employee_name}</td>
                          <td>${response.body_resume[index].company_name}</td>
                          <td>${response.body_resume[index].jabatan}</td>
                          ${tbody_td}
                      </tr>`
      }

      $('#dt_resume_pembelajar_3').empty().append(
        `<thead id="dt_resume_head_3"></thead>
              <tbody id="dt_resume_body_3"></tbody>`
      );
      $('#dt_resume_head_3').empty().append(thead);
      $('#dt_resume_body_3').empty().append(tbody);
      setTimeout(() => {
        $('#dt_resume_pembelajar_3').DataTable({
          "searching": true,
          "info": true,
          "paging": true,
          "destroy": true,
          "autoWidth": false,
          "dom": 'Bfrtip',
          buttons: [{
            extend: 'excelHtml5',
            text: 'Export to Excel',
            footer: true
          }],
        });
      }, 1000);
    }).fail(function(jqXhr, textStatus) {

    });
  }

  function get_pekerjaan(tipe = null, nilai = null) {
    if (tipe == 1) {
      id_project = $('#e_project').val();
      id_department = $('#list_department_draft').val();
    } else {
      id_project = $('#project').val();
      id_department = $('#list_department').val();
    }
    console.log(id_department);

    $.ajax({
      url: "<?= base_url('mom/get_pekerjaan') ?>",
      method: "POST",
      dataType: "JSON",
      data: {
        'id_project': id_project,
      },
      beforeSend: function() {
        $('#pekerjaan').empty().append(
          '<option value=""><i class="fa fa-spinner fa-spin"></i> Loading..</option>'
        ).prop('disabled', true);
      },
      success: function(res) {
        let newOptions = '<option value="#" disabled selected>-- Pilih SO --</option>';
        if (res.pekerjaan != null) {
          res.pekerjaan.forEach(element => {
            newOptions += `<option value="${element.id}">${element.pekerjaan} ${element.periode}</option>`;
          });
        }
        $('#pekerjaan').empty().append(newOptions).prop('disabled', false);
        id_pekerjaan.update();
        if (tipe == 1) {
          e_pekerjaan.setData(newOptions);
          if (nilai != null) {
            e_pekerjaan.setSelected(nilai);
          }
        } else {
          $('#pekerjaan').empty().append(newOptions).prop('disabled', false);
        }
      },
      fail: function(jqXhr, textStatus) {
        console.log("Failed to get Pekerjaan");
      }
    });
  }

  function get_sub_pekerjaan(tipe = null, nilai = null) {
    if (tipe == 1) {
      id_pekerjaan = $('#e_pekerjaan').val();
    } else {
      id_pekerjaan = $('#pekerjaan').val();
    }

    $.ajax({
      url: "<?= base_url('mom/get_sub_pekerjaan') ?>",
      method: "POST",
      dataType: "JSON",
      data: {
        'id_pekerjaan': id_pekerjaan
      },
      beforeSend: function() {
        $('#sub_pekerjaan').empty().append(
          '<option value=""><i class="fa fa-spinner fa-spin"></i> Loading..</option>'
        ).prop('disabled', true);
      },
      success: function(res) {
        let newOptions = '<option value="#" disabled selected>-- Pilih SI --</option>';
        if (res.sub_pekerjaan != null) {
          res.sub_pekerjaan.forEach(element => {
            newOptions += `<option value="${element.id}">${element.sub_pekerjaan}</option>`;
          });
        }
        $('#sub_pekerjaan').empty().append(newOptions).prop('disabled', false);
        id_sub_pekerjaan.update();
        if (tipe == 1) {
          e_sub_pekerjaan.setData(newOptions);
          if (nilai != null) {
            e_sub_pekerjaan.setSelected(nilai);
          }
        } else {
          $('#sub_pekerjaan').empty().append(newOptions).prop('disabled', false);
        }
      },
      fail: function(jqXhr, textStatus) {
        console.log("Failed to get Sub Pekerjaan");
      }
    });
  }

  function get_detail_pekerjaan(tipe = null, nilai = null) {
    if (tipe == 1) {
      id_sub_pekerjaan = $('#e_sub_pekerjaan').val();
    } else {
      id_sub_pekerjaan = $('#sub_pekerjaan').val();
    }

    $.ajax({
      url: "<?= base_url('mom/get_detail_pekerjaan') ?>",
      method: "POST",
      dataType: "JSON",
      data: {
        'id_sub_pekerjaan': id_sub_pekerjaan
      },
      beforeSend: function() {
        $('#detail_pekerjaan').empty().append(
          '<option value=""><i class="fa fa-spinner fa-spin"></i> Loading..</option>'
        ).prop('disabled', true);
      },
      success: function(res) {
        let newOptions = '<option value="#">-- Pilih Tasklist --</option>';
        if (res.detail_pekerjaan != null) {
          res.detail_pekerjaan.forEach(element => {
            newOptions += `<option value="${element.id}">${element.detail}</option>`;
          });
        }
        $('#detail_pekerjaan').empty().append(newOptions).prop('disabled', false);
        id_detail_pekerjaan.update();
        if (tipe == 1) {
          e_detail_pekerjaan.setData(newOptions);
          if (nilai != null) {
            e_detail_pekerjaan.setSelected(nilai);
          }
        } else {
          $('#detail_pekerjaan').empty().append(newOptions).prop('disabled', false);
        }
      },
      fail: function(jqXhr, textStatus) {
        console.log("Failed to get Detail Pekerjaan");
      }
    });
  }
  $('#btn_show_pekerjaan').on('click', function() {
    if ($('#btn_show_pekerjaan').hasClass('bi-square')) {
      $('#btn_show_pekerjaan').removeClass('bi-square');
      $('#btn_show_pekerjaan').addClass('bi-check-square');
      $('#pekerjaan_row').removeClass('d-none');
    } else {
      $('#btn_show_pekerjaan').removeClass('bi-check-square');
      $('#btn_show_pekerjaan').addClass('bi-square');
      $('#pekerjaan_row').addClass('d-none');
    }
  })
  $('#e_btn_show_pekerjaan').on('click', function() {
    if ($('#e_btn_show_pekerjaan').hasClass('bi-square')) {
      $('#e_btn_show_pekerjaan').removeClass('bi-square');
      $('#e_btn_show_pekerjaan').addClass('bi-check-square');
      $('#e_pekerjaan_row').removeClass('d-none');
    } else {
      $('#e_btn_show_pekerjaan').removeClass('bi-check-square');
      $('#e_btn_show_pekerjaan').addClass('bi-square');
      $('#e_pekerjaan_row').addClass('d-none');
    }
  })
</script>