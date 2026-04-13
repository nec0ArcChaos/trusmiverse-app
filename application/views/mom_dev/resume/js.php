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

<script type="text/javascript">
  $(document).ready(function() {

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

    $('.waktu').datetimepicker({
      format: 'H:i',
      datepicker: false,
      timepicker: true,
      minDate: 0,
    });

    peserta = new SlimSelect({
      select: "#peserta"
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

    pic_draft = new SlimSelect({
      select: ".pic_draft"
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
    get_list_rekap('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');

    /*Range*/
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
      $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="start"]').val(start.format('YYYY-MM-DD'));
      $('input[name="end"]').val(end.format('YYYY-MM-DD'));
      // get_list_mom(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
      get_list_rekap(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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

    $("#peserta").change(function() {
      user = $("#peserta").val().toString().split(",");
      $("#user").val(user);
    });

    $("#smartwizard2").on("leaveStep", function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
      // console.log(currentStepIndex, nextStepIndex, stepDirection);
      // Save Data Detail
      if (nextStepIndex == 1 && stepDirection == "forward") {
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
        } else if ($("#agenda").val() == "") {
          $(".agenda").removeClass('is-valid');
          $(".agenda").addClass('is-invalid');
          $("#agenda").focus();
          return false;
        } else if ($("#user").val() == "") {
          $(".peserta").removeClass('is-valid');
          $(".peserta").addClass('is-invalid');
          peserta.open();
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
              $("#dt_list_mom").DataTable().ajax.reload();
              // $('.sw-btn-next').removeAttr("disabled");
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
        $("#btn_finish").show();
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
      if (input[0] == 'deadline' && $('#val_kategori_' + input[1] + '_' + input[2]).val() == 1) {
        $('#val_date_' + id).show().focus();
        $('#val_' + id).hide();
      } else if (input[0] == 'deadline' && $('#val_kategori_' + input[1] + '_' + input[2]).val() == 6) {
        $('#val_date_' + id).show().focus();
        $('#val_' + id).hide();
      } else {
        $('#val_' + id).show().focus();
        $('#val_date_' + id).hide();
      }
    });

    $('#dt_mom_result_draft').on('click', '.kolom_modif', function() {
      id = $(this).data("id");
      input = id.split('_');
      $('#td_' + id).addClass('padding_0');
      $('#' + id).hide();
      if (input[0] == 'deadline' && $('#val_kategori_draft_' + input[2] + '_' + input[3]).val() == 1) {
        $('#val_date_' + id).show().focus();
        $('#val_' + id).hide();
      } else if (input[0] == 'deadline' && $('#val_kategori_draft_' + input[2] + '_' + input[3]).val() == 6) {
        $('#val_date_' + id).show().focus();
        $('#val_' + id).hide();
      } else {
        $('#val_' + id).show().focus();
        $('#val_date_' + id).hide();
      }
    });
    // End Tab Result

    // Draft
    $("#peserta_draft").change(function() {
      user_e = $("#peserta_draft").val().toString().split(",");
      $("#user_draft").val(user_e);
    });

    $("#smartwizard3").on("leaveStep", function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
      // console.log(currentStepIndex, nextStepIndex, stepDirection);
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
              // get_issue_result($("#id_mom_global_draft").val());
              $("#dt_list_draft").DataTable().ajax.reload();
              // $('.sw-btn-next').removeAttr("disabled");
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

  });

  function add_mom() {
    $("#modal_add_mom").modal("show");
    $("#btn_finish").hide();
    $('#pembahasan').summernote('reset');
    $('#closing').summernote('reset');
    peserta.setSelected([]);
    $("#form_detail")[0].reset();
    $("#smartwizard2").smartWizard("reset");
    $('.check-valid').removeClass('is-valid');
    $('.check-valid').removeClass('is-invalid');

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

        pic = new SlimSelect({
          select: ".pic"
        });

        console.log(res);
      },
      error: function(xhr) {
        console.log(xhr.responseText);
      }
    });
  }

  function get_list_mom(start, end) {
    // console.log(`start : ${start}, end : ${end}`);
    var tabel_mom =
      $('#dt_list_mom').DataTable({
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
          "url": "<?= base_url("mom/get_list_mom") ?>",
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
              return `<a href="<?= base_url('pr/mom/'); ?>${row['id_link']}" target="_blank" class="btn btn-sm btn-primary"><i class="bi bi-printer"></i></a>
              <button type="button" class="btn btn-sm btn-success" onclick="reminder_whatsapp('${data}')"><i class="bi bi-whatsapp"></i></button>`;
            },
            'className': 'text-center'
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
          swal("Cancel!!", "Add Notulen is canceled!", "info");
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
    $("#closed").val(closed);

    if (closing == '' || closing == '<p><br></p>' || closing == '<br>') {
      $(".closing").removeClass('is-valid');
      $(".closing").addClass('is-invalid');
      swal("Warning", "Closing Statement belum terisi", "info");
      return false;
    } else {
      $.ajax({
        url: "<?= base_url("mom/save_closing") ?>",
        method: "POST",
        dataType: "JSON",
        data: {
          id_mom: id_mom,
          closing: closing,
          closed: closed // Finish
        },
        beforeSend: function(res) {
          $('#btn_finish').attr("disabled", true);
        },
        success: function(res) {
          // console.log(res);
          // console.log(res.send);
          if ($("#id_mom_global").val() == "") {
            $('#id_mom').val(res.data.id_mom);
            $('#id_mom_global').val(res.data.id_mom);
          }
          $("#id_mom_global").val("");
          $("#dt_list_mom").DataTable().ajax.reload();
          $('#btn_finish').removeAttr("disabled");
          swal("Success!!", "Data has been saved!", "success");
          $("#modal_add_mom").modal("hide");
          return true;
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
        }
      });
    }
  }

  // Start Tab Result  
  function submit_update(id) {
    id_mom = $('#id_mom_global').val();
    input = id.split('_');
    $('#td_' + id).removeClass('padding_0');
    if (input[0] == "kategori" || input[0] == "pic") {
      inp_value = $('#val_' + id).val();
    } else {
      if (input[0] == 'deadline' && $('#val_kategori_' + input[1] + '_' + input[2]).val() == 1) {
        // console.log("Tgl Deadline");
        inp_value = $('#val_date_' + id).val();
        $('#' + id).show().text(inp_value);
        $('#val_date_' + id).hide();
      } else if (input[0] == 'deadline' && $('#val_kategori_' + input[1] + '_' + input[2]).val() == 6) {
        // console.log("Tgl Strategy Deadline");
        inp_value = $('#val_date_' + id).val();
        $('#' + id).show().text(inp_value);
        $('#val_date_' + id).hide();
      } else {
        // console.log("Tanpa Tgl");
        inp_value = $('#val_' + id).val();
        $('#' + id).show().text(inp_value);
        $('#val_' + id).hide();
      }
    }


    console.log(input)

    if (input[0] == "issue") {
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
    no = $('#total_action_' + issue_no).val();
    next_no = parseInt(no) + 1;
    rowspan = next_no + 1;


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
    <td class="kolom_modif" id="td_deadline_${issue_no}_${next_no}" data-id="deadline_${issue_no}_${next_no}">
    <span id="deadline_${issue_no}_${next_no}">&nbsp;</span>
    <textarea class="form-control" id="val_deadline_${issue_no}_${next_no}" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea('val_deadline_${issue_no}_${next_no}')" onfocusout="submit_update('deadline_${issue_no}_${next_no}')"></textarea>
    <input type="text" class="form-control tanggal" id="val_date_deadline_${issue_no}_${next_no}" style="display: none;" onfocusout="submit_update('deadline_${issue_no}_${next_no}')">
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
  }

  function add_issue() {
    no = $('#total_issue').val();
    next_no = parseInt(no) + 1;


    data_action = `
    <tr id="div_issue_${next_no}">
    <td class="kolom_modif" id="td_issue_${next_no}" data-id="issue_${next_no}_1" rowspan="2">
    <input type="hidden" id="total_action_${next_no}" value="1">
    <span id="issue_${next_no}_1">&nbsp;</span>
    <textarea class="form-control" id="val_issue_${next_no}_1" style="display: none;" class="excel" rows="${next_no}_1" onfocusin="expandTextarea('val_issue_${next_no}_1')" onfocusout="submit_update('issue_${next_no}_1')"></textarea>
    </td>
    <td width="${next_no}_1%" id="no_${next_no}_1">1.</td>
    <td class="kolom_modif" id="td_action_${next_no}_1" data-id="action_${next_no}_1">
    <span id="action_${next_no}_1">&nbsp;</span>
    <textarea class="form-control" id="val_action_${next_no}_1" style="display: none;" class="excel" rows="${next_no}_1" onfocusin="expandTextarea('val_action_${next_no}_1')" onfocusout="submit_update('action_${next_no}_1')"></textarea>
    </td>
    <td class="kolom_modif" id="td_kategori_${next_no}_1" data-id="kategori_${next_no}_1">
    <select class="form-control" id="val_kategori_${next_no}_1" onchange="submit_update('kategori_${next_no}_1')">
    <option>- Choose -</option>
    <?php foreach ($kategori as $ktg) : ?>
      <option value="<?php echo $ktg->id ?>"><?php echo $ktg->kategori ?></option>
    <?php endforeach ?>
    </select>
    </td>
    <td class="kolom_modif" id="td_deadline_${next_no}_1" data-id="deadline_${next_no}_1">
    <span id="deadline_${next_no}_1">&nbsp;</span>
    <textarea class="form-control" id="val_deadline_${next_no}_1" style="display: none;" class="excel" rows="${next_no}_1" onfocusin="expandTextarea('val_deadline_${next_no}_1')" onfocusout="submit_update('deadline_${next_no}_1')"></textarea>
    <input type="text" class="form-control tanggal" id="val_date_deadline_${next_no}_1" style="display: none;" onfocusout="submit_update('deadline_${next_no}_1')">
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
    <td style="cursor: pointer;" colspan="5">
    <span class="btn btn-md btn-outline-success" onclick="add_action(${next_no})"><i class="bi bi-list-ol"></i> Add Action</span>
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
  }
  // End Tab Result

  // Start Tab Result  Draft
  function submit_update_draft(id) {
    id_mom = $('#id_mom_global_draft').val();
    // console.log('Testing IT',id_mom);
    input = id.split('_');
    $('#td_' + id).removeClass('padding_0');
    if (input[0] == "kategori" || input[0] == "pic") {
      inp_value = $('#val_' + id).val();
    } else {
      if (input[0] == 'deadline' && $('#val_kategori_draft_' + input[2] + '_' + input[3]).val() == 1) {
        // console.log("Tgl Deadline");
        inp_value = $('#val_date_' + id).val();
        $('#' + id).show().text(inp_value);
        $('#val_date_' + id).hide();
      } else if (input[0] == 'deadline' && $('#val_kategori_draft_' + input[2] + '_' + input[3]).val() == 6) {
        // console.log("Tgl Strategy Deadline");
        inp_value = $('#val_date_' + id).val();
        $('#' + id).show().text(inp_value);
        $('#val_date_' + id).hide();
      } else {
        // console.log("Tanpa Tgl");
        inp_value = $('#val_' + id).val();
        $('#' + id).show().text(inp_value);
        $('#val_' + id).hide();
      }
    }


    console.log(input)

    if (input[0] == "issue") {
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
    <td class="kolom_modif" id="td_deadline_draft_${issue_no}_${next_no}" data-id="deadline_draft_${issue_no}_${next_no}">
    <span id="deadline_draft_${issue_no}_${next_no}">&nbsp;</span>
    <textarea class="form-control" id="val_deadline_draft_${issue_no}_${next_no}" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea_draft('val_deadline_draft_${issue_no}_${next_no}')" onfocusout="submit_update_draft('deadline_draft_${issue_no}_${next_no}')"></textarea>
    <input type="text" class="form-control tanggal" id="val_date_deadline_draft_${issue_no}_${next_no}" style="display: none;" onfocusout="submit_update_draft('deadline_draft_${issue_no}_${next_no}')">
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

    $('#td_issue_draft_' + issue_no).attr('rowspan', rowspan);
    console.log(rowspan)
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
  }

  function add_issue_draft() {
    no = $('#total_issue_draft').val();
    next_no = parseInt(no) + 1;


    data_action = `
    <tr id="div_issue_draft_${next_no}">
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
    <td class="kolom_modif" id="td_deadline_draft_${next_no}_1" data-id="deadline_draft_${next_no}_1">
    <span id="deadline_draft_${next_no}_1">&nbsp;</span>
    <textarea class="form-control" id="val_deadline_draft_${next_no}_1" style="display: none;" class="excel" rows="${next_no}_1" onfocusin="expandTextarea_draft('val_deadline_draft_${next_no}_1')" onfocusout="submit_update_draft('deadline_draft_${next_no}_1')"></textarea>
    <input type="text" class="form-control tanggal" id="val_date_deadline_draft_${next_no}_1" style="display: none;" onfocusout="submit_update_draft('deadline_draft_${next_no}_1')">
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
    <td style="cursor: pointer;" colspan="5">
    <span class="btn btn-md btn-outline-success" onclick="add_action_draft(${next_no})"><i class="bi bi-list-ol"></i> Add Action</span>
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
          "url": "<?= base_url("mom/get_list_rekap") ?>"
          // "success": function (res){
          //   console.log(res);
          // },
          // "error": function (jqXHR){
          //   console.log(jqXHR.responseText);
          // }
        },
        "columns": [
          {
            'data': 'employee_name',
            'render': function(data, type, row) {
              return `${data}`;
            }
          },
          {
            'data': 'jabatan',
            'render': function(data,type,row){
              return `${data}`;
            }
          },
          {
            'data': 'tasklist',
            'render': function(data,type,row){
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
            'render': function(data,type,row){
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-info" onclick="detail_rekap('${row['user_id']}','2')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'konsep',
            'render': function(data,type,row){
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-info" onclick="detail_rekap('${row['user_id']}','3')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'statement',
            'render': function(data,type,row){
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-info" onclick="detail_rekap('${row['user_id']}','4')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'instruksi',
            'render': function(data,type,row){
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-info" onclick="detail_rekap('${row['user_id']}','5')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'strategi',
            'render': function(data,type,row){
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-info" onclick="detail_rekap('${row['user_id']}','6')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'brainstorming',
            'render': function(data,type,row){
              if (data == 0) {
                return `<u class="text-secondary">${data}</u>`;
              } else {
                return `<span class="btn btn-sm btn-outline-info" onclick="detail_rekap('${row['user_id']}','7')">${data}</span>`;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'daily',
            'render': function(data,type,row){
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
            'render': function(data,type,row){
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
            'render': function(data,type,row){
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
        ]
      });
  }

  function detail_rekap(user_id, tipe) {
    $("#modal_detail_rekap").modal('show');
    tipe_deadline = ['1','6','8','9','10','30','40','50','60'];

    // $.inArray( tipe, tipe_deadline ) != -1
    if ($.inArray( tipe, tipe_deadline ) == -1) { // Jika tidak masuk list yang ada Deadlinenya maka tidak muncul
      hide_column = [
        {
            targets: [6,7,8,9,10,11,12],
            visible: false
        }
      ];
    } else {
      hide_column = [
        {
            targets: [6,7,8,9,10,11,12],
            visible: true
        }
      ];
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
          'data': 'tgl_meeting'
        },
        {
          'data': 'employee_name'
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
            if (data == '') {
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
          'render': function(data,type,row){
            if (data != "") {
              return `<a href="<?= base_url(); ?>uploads/monday/history_sub_task/${data}" target="_blank" class="badge bg-success"><i class="bi bi-file-earmark-medical"></i></a>`;
            } else {
              return ``;
            }
          },
          'className': 'text-center'
        },
        {
          'data': 'link',
          'render': function(data,type,row){
            if (data != "") {
              return `<a href="${data}" target="_blank" class="badge bg-primary"><i class="bi bi-door-open"></i></a>`;
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
          'data': 'deadline',
          'render': function(data, type, row, meta) {
            no = meta.row + 1;
            return `<input type="text" class="form-control ${(row['id_kategori'] == 1 || row['id_kategori'] == 6) ? 'tanggal' : '' }" id="e_deadline_${no}" name="e_deadline_${no}" value="${data}" onfocusout="update_result('${row['id_mom']}','${row['id_issue']}','${row['id_issue_item']}','${row['id_task']}','${row['id_sub_task']}','e_deadline_${no}')">`;
          }
        },
        {
          'data': 'list_pic',
          'render': function(data, type, row) {
            return `${data}`;
          }
        },
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
    val_new = $(`#${val}`).val();
    res = val.split('_');
    title = res[1].substr(0, 1).toUpperCase() + res[1].substr(1);
    // console.log(deadline);
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
          swal("Success", "Data has been drafted!", "info");
          return true;
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
          return false;
        }
      });
    } else {
      closing = $("#closing").val();

      $.ajax({
        url: "<?= base_url("mom/save_closing") ?>",
        method: "POST",
        dataType: "JSON",
        data: {
          id_mom: id_mom,
          closing: closing,
          closed: 0 //Draft
        },
        beforeSend: function(res) {
          $('#btn_draft').attr("disabled", true);
        },
        success: function(res) {
          // console.log(res);
          // console.log(res.send);
          $("#modal_add_mom").modal("hide");
          $("#dt_list_mom").DataTable().ajax.reload();
          $('#btn_draft').removeAttr("disabled");
          swal("Success", "Data has been drafted!", "info");
          return true;
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
        }
      });
    }
  }

  function list_draft() {
    $("#modal_list_draft").modal("show");
    $('#dt_list_draft').DataTable({
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
        "url": "<?= base_url("mom/get_list_mom") ?>",
        "data": {
          datestart: null,
          dateend: null,
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
            return `<a href="javascript:void(0);" class="btn btn-sm btn-warning" onclick="proses_draft('${data}')"><i class="bi bi-box-arrow-in-right"></i></a>`;
          }
        },
        {
          'data': 'judul'
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
    $.ajax({
      url: "<?= base_url("mom/get_draft_header/") ?>" + id,
      method: "GET",
      dataType: "JSON",
      beforeSend: function(res) {
        $('#btn_draft').attr("disabled", true);
      },
      success: function(dt) {
        console.log(dt);
        $("#id_mom_draft").val(dt.id_mom);
        $("#id_mom_global_draft").val(dt.id_mom);
        $("#judul_draft").val(dt.judul);
        $("#tempat_draft").val(dt.tempat);
        $("#tanggal_draft").val(dt.tgl);
        $("#start_time_draft").val(dt.start_time);
        $("#end_time_draft").val(dt.end_time);
        $("#agenda_draft").val(dt.agenda);
        peserta_draft.setSelected(dt.peserta.split(','));
        $("#user_draft").val(dt.peserta);
        $('#pembahasan_draft').summernote('code', dt.pembahasan);
        $("#pembahasan_draft").text(dt.pembahasan);
        $('#closing_draft').summernote('code', dt.closing_statement);
        $("#closing_draft").text(dt.closing_statement);
        get_issue_result($("#id_mom_global_draft").val());
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
          swal("Success", "Data has been drafted!", "info");
          return true;
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
          return false;
        }
      });
    } else {
      closing = $("#closing_draft").val();

      $.ajax({
        url: "<?= base_url("mom/save_closing_draft") ?>",
        method: "POST",
        dataType: "JSON",
        data: {
          id_mom: id_mom,
          closing: closing,
          closed: 0 //Draft
        },
        beforeSend: function(res) {
          $('#btn_draft_e').attr("disabled", true);
        },
        success: function(res) {
          // console.log(res);
          // console.log(res.send);
          $("#modal_proses_draft").modal("hide");
          $("#dt_list_draft").DataTable().ajax.reload();
          $("#dt_list_mom").DataTable().ajax.reload();
          $('#btn_draft_e').removeAttr("disabled");
          swal("Success", "Data has been drafted!", "info");
          return true;
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
        }
      });
    }
  }

  function finish_draft(closed) {
    id_mom = $("#id_mom_global_draft").val();
    closing = $("#closing_draft").val();
    $("#closed").val(closed);

    if (closing == '' || closing == '<p><br></p>' || closing == '<br>') {
      $(".closing_draft").removeClass('is-valid');
      $(".closing_draft").addClass('is-invalid');
      swal("Warning", "Closing Statement belum terisi", "info");
      return false;
    } else {
      $.ajax({
        url: "<?= base_url("mom/save_closing_draft") ?>",
        method: "POST",
        dataType: "JSON",
        data: {
          id_mom: id_mom,
          closing: closing,
          closed: closed // Finish
        },
        beforeSend: function(res) {
          $('#btn_finish_e').attr("disabled", true);
        },
        success: function(res) {
          // console.log(res);
          $("#dt_list_draft").DataTable().ajax.reload();
          $("#dt_list_mom").DataTable().ajax.reload();
          $('#btn_finish_e').removeAttr("disabled");
          swal("Success!!", "Data has been saved!", "success");
          $("#modal_proses_draft").modal("hide");
          return true;
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
        }
      });
    }
  }

  // Result Draft
  function get_issue_result(id_mom) {
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
            dataType: 'json'
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
</script>