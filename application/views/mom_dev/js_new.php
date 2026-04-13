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

<script type="text/javascript">

  $(document).ready(function() {

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

    get_list_mom('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');
    
    /*Range*/
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
      $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="start"]').val(start.format('YYYY-MM-DD'));
      $('input[name="end"]').val(end.format('YYYY-MM-DD'));
      get_list_mom(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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
        } else if ($("#pembahasan").val() == "") {
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
            beforeSend: function (res){
              // $('.sw-btn-next').attr("disabled",true);  
            },
            success: function (res){
              // console.log(res);
              if($("#id_mom_global").val() == ""){
                $('#id_mom').val(res.data.id_mom);
                $('#id_mom_global').val(res.data.id_mom);
              }
              $("#dt_list_mom").DataTable().ajax.reload();              
              // $('.sw-btn-next').removeAttr("disabled");
              return true;              
            },
            error: function (jqXHR, textStatus, errorThrown){
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

      $('#td_'+id).addClass('padding_0');

      $('#'+id).hide();
      if (input[0] == 'deadline' && $('#val_kategori_'+input[1]+'_'+input[2]).val() == 1) {
        $('#val_date_'+id).show().focus();
        $('#val_'+id).hide();
      } else {
        $('#val_'+id).show().focus();
        $('#val_date_'+id).hide();
      }
    });

  });

  function add_mom()
  {
    $("#modal_add_mom").modal("show");
    $("#btn_finish").hide();
    $('#pembahasan').summernote('reset');
    $('#closing').summernote('reset');
    peserta.setSelected([]);
    $("#form_detail")[0].reset();    
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
        buttons: [
          {
            extend: 'excelHtml5',
            text: '<i class="bi bi-download text-white"></i>',
            footer: true
          }
        ],
        "ajax": {
          "dataType": 'json',
          "type": "POST",
          "data": {
            datestart: start,
            dateend: end
          },
          "url": "<?= base_url('mom/get_list_mom') ?>"
          // "success": function (res){
          //   console.log(res);
          // },
          // "error": function (jqXHR){
          //   console.log(jqXHR.responseText);
          // }
        },
        "columns": [
          {
            'data': 'id_mom',
            'className': 'text-center'
          },
          {
            'data': 'judul'
          },
          {
            'data': 'peserta'
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
            'data': 'created_by'
          }
        ]
      });
  }

  function cancel()
  {
    id_mom = $("#id_mom_global").val();
    // console.log(id_mom);
    if (id_mom != "") {
      $.ajax({
        method: "GET",
        url: "<?= base_url('mom/cancel_mom/') ?>"+id_mom,
        dataType: "JSON",
        beforeSend: function (res){
          $("#btn_cancel").attr("disabled",true);
        },
        success: function(res){
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
        error: function(jqXHR){
          console.log(jqXHR.responseText);
        }
      });
    } else {
      $("#modal_add_mom").modal("hide");
    }
  }

  function finish()
  {
    id_mom  = $("#id_mom_global").val();
    closing = $("#closing").val();
    console.log(closing);
    if (closing == '' || closing == '<p><br></p>') {
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
          closing: closing
        },
        beforeSend: function (res){
          $('#btn_finish').attr("disabled",true);  
        },
        success: function (res){
          // console.log(res);
          if($("#id_mom_global").val() == ""){
            $('#id_mom').val(res.data.id_mom);
            $('#id_mom_global').val(res.data.id_mom);
          }
          $("#dt_list_mom").DataTable().ajax.reload();              
          $('#btn_finish').removeAttr("disabled");
          swal("Success!!", "Data has been saved!", "success");
          $("#modal_add_mom").modal("hide");
          return true;              
        },
        error: function (jqXHR, textStatus, errorThrown){
          console.log(jqXHR.responseText);   
        }
      });
    }
  }

  // Start Tab Result  
  function submit_update(id) {
    id_mom  = $('#id_mom_global').val();
    input   = id.split('_');
    $('#td_'+id).removeClass('padding_0');
    if (input[0] == "kategori" || input[0] == "pic") {
      inp_value = $('#val_'+id).val();
    } else {
      if (input[0] == 'deadline' && $('#val_kategori_'+input[1]+'_'+input[2]).val() == 1) {
        inp_value = $('#val_date_'+id).val();
        $('#'+id).show().text(inp_value);
        $('#val_date_'+id).hide();
      } else {
        inp_value = $('#val_'+id).val();
        $('#'+id).show().text(inp_value);
        $('#val_'+id).hide();
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
    no = $('#total_action_'+issue_no).val();
    next_no = parseInt(no)+1;
    rowspan = next_no+1;


    data_action = `<tr>
    <td width="1%" id="no_${issue_no}_${next_no}">${next_no}.</td>
    <td class="kolom_modif" id="td_action_${issue_no}_${next_no}" data-id="action_${issue_no}_${next_no}">
    <span id="action_${issue_no}_${next_no}">&nbsp;</span>
    <textarea class="form-control" id="val_action_${issue_no}_${next_no}" style="display: none;" class="excel" rows="1" onfocusin="expandTextarea('val_action_${issue_no}_${next_no}')" onfocusout="submit_update('action_${issue_no}_${next_no}')"></textarea>
    </td>
    <td class="kolom_modif" id="td_kategori_${issue_no}_${next_no}" data-id="kategori_${issue_no}_${next_no}">
    <select class="form-control" id="val_kategori_${issue_no}_${next_no}" onchange="submit_update('kategori_${issue_no}_${next_no}')">
    <option>- Choose -</option>
    <?php foreach ($kategori as $ktg): ?>
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

    $('#td_issue_'+issue_no).attr('rowspan', rowspan);
    console.log(rowspan)
    $('#div_issue_action_'+issue_no).before(data_action);
    $('#total_action_'+issue_no).val(next_no);
    
    $('.tanggal').datetimepicker({
      format: 'Y-m-d',
      timepicker: false,
      minDate: 0,
    });

    pic = new SlimSelect({
      select: "#val_pic_"+issue_no+"_"+next_no
    });
  }

  function add_issue() {
    no = $('#total_issue').val();
    next_no = parseInt(no)+1;


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
    <?php foreach ($kategori as $ktg): ?>
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
      select: "#val_pic_"+next_no+'_1'
    });
  }
  // End Tab Result

</script>