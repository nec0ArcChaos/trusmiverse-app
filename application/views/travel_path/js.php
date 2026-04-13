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
<!-- Jquery Confirm -->
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>

<script type="text/javascript">
  // var table_ajax;

  $(document).ready(function() {

    list_path('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');
    
    /*Range*/
    // var start = moment().startOf('month');
    // var end = moment().endOf('month');
    var start = moment();
    var end = moment();

    function cb(start, end) {
      $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="start"]').val(start.format('YYYY-MM-DD'));
      $('input[name="end"]').val(end.format('YYYY-MM-DD'));
      list_path(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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
    
    // tipe = new SlimSelect({
    //   select: "#tipe_gemba"
    // });

    // $('#tgl_plan').datetimepicker({
    //     format: 'Y-m-d',
    //     timepicker: false,
    //     minDate: 0,
    // });

  });

  function save_travel_path()
  {
    tp_id         = $('#tp_id').val();
    path_id       = $('#path_id').val();
    status        = $('#status').val();
    evidence      = $('#evidence').val();
    tipe          = $('#tipe').val();
    evaluasi      = $('#evaluasi').val();
    note          = $('#note').val();

    // console.log(tp_id, path_id, status, evidence, tipe, evaluasi, note);

    if (status == "#") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Status is empty!',
        buttons: {
            close: {
                actions: function() {}
            },
        },
      });
    } else if (status == "Sesuai" && evidence == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Evidence is empty!',
        buttons: {
            close: {
                actions: function() {}
            },
        },
      });
    } else if (tipe == "#") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Tipe is empty!',
        buttons: {
            close: {
                actions: function() {}
            },
        },
      });
    } else if (evaluasi == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Evaluasi is empty!',
        buttons: {
            close: {
                actions: function() {}
            },
        },
      });
    } else if (note == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Note is empty!',
        buttons: {
            close: {
                actions: function() {}
            },
        },
      });
    } else {
      let evidence = $(`#evidence`).prop("files")[0];
      let form_file = new FormData();                    
      form_file.append("tp_id", tp_id);
      form_file.append("path_id", path_id);
      form_file.append("status", status);
      form_file.append("evidence", evidence);
      form_file.append("tipe", tipe);
      form_file.append("evaluasi", evaluasi);
      form_file.append("note", note);
      $.ajax({
        url: "<?php echo base_url("travel_path/save_travel_path") ?>",
        method: "POST",
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,
        data: form_file,
        beforeSend: function(res){
          $("#btn_save_travel_path").attr("disabled",true);
        },
        success: function(res){
          // proses_gemba(id_gemba);
          $("#btn_save_travel_path").removeAttr("disabled");
          $.confirm({
            icon: 'fa fa-check',
            title: 'Success',
            theme: 'material',
            type: 'green',
            content: 'Data has been saved!',
            buttons: {
                close: {
                    actions: function() {}
                },
            },
          });
          $("#modal_proses_path").modal("hide");
          $("#form_path")[0].reset();
        },
        error: function(jqXHR){
          console.log(jqXHR.responseText);
        }
      });
    }
  }

  function list_path(start,end)
  {
    $('#dt_list_path').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List Travel Path',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('travel_path/list_path') ?>",
        "dataType": 'JSON',
        "type": "POST",
        "data": {
          start: start,
          end: end
        },
        // "success": function (res){
        //   console.log(res);
        // },
        // "error": function (jqXHR){
        //   console.log(jqXHR.responseText);
        // }
      },
      "columns": [
        {
          'data': 'id',
          'render': function(data,type,row){
            return `<a href="javascript:void(0);" class="btn btn-sm btn-outline-primary" onclick="proses_path('${data}')">Proses</a>`;
          },
          'className': 'text-center'
        },
        {
          'data': 'point'
        },
        {
          'data': 'type'
        }
      ]
    });
  }
  
  function proses_path(id)
  {
    $("#modal_proses_path").modal("show");   
    // $("#modal_loading").modal('show'); 
    insert_path(id);
  }

  function insert_path(id)
  {
    $.ajax({
      url: "<?php echo base_url("travel_path/insert_path") ?>",
      method: "POST",
      dataType: "JSON",
      data: {
        path_id: id
      },
      beforeSend: function(res){
        $("#modal_loading").modal('show');
      },
      success: function(res){
        // console.log(res);
        // $(".progress-stepbar").html(res);
      },
      complete: function(res){
        detail_path(id);
      },
      error: function(jqXHR){
        console.log(jqXHR.responseText);
      }
    });
  }

  function detail_path(id)
  {
    $.ajax({
      url: "<?php echo base_url("travel_path/get_detail_path/") ?>"+id,
      method: "GET",
      dataType: "JSON",
      success: function(res){
        // console.log(res);
        $(".progress-stepbar").html(res.data);
      },
      complete: function(res){
        res = res.responseJSON;
        setTimeout(() => {
          $("#modal_loading").modal('hide');       
          // console.log(res);   
          show_form(res.path_id,res.tp_id,res.status[res.path_id - 1]);
          // console.log('Load',res.path_id,res.tp_id,res.status,res.status[res.path_id - 1]);
        }, 1000);
      },
      error: function(jqXHR){
        console.log(jqXHR.responseText);
      }
    });
  }

  function show_form(path_id,tp_id,status)
  {
    $("#tp_id").val(tp_id);
    $("#path_id").val(path_id);
    $.ajax({
      url: '<?= base_url("travel_path/get_detail_travel_path") ?>',
      method: "POST",
      dataType: "JSON",
      data: {
        tp_id: tp_id,
        path_id: path_id
      },
      success: function(res){
        // console.log(res);
        // console.log('Path :',path_id,tp_id,status);
        if (status == "completed" || status == "") {
          $("#status").val(res.status);
          $(".evidence_input").hide();
          $(".evidence_show").show();
          $(".evidence_show").attr("href", `<?= base_url(); ?>uploads/travel_path/${res.foto}`);
          $(".foto_standar").attr("href", `<?= base_url(); ?>uploads/travel_path/${res.standar}`);
          $("#tipe").val(res.tipe);
          $("#evaluasi").val(res.evaluasi);
          $("#note").val(res.note);

          $("#btn_save_travel_path").hide();

          $("#status").attr('disabled',true);
          $("#tipe").attr('disabled',true);
          $("#evaluasi").attr('readonly',true);
          $("#note").attr('readonly',true);
          if (status == "") {            
            $(".evidence_input").show();
            $(".evidence_show").hide();
            $(".foto_standar").attr("href", `<?= base_url(); ?>uploads/travel_path/${res.standar}`);
            $("#evidence").attr('disabled',true);
          }
        } else {          
          $("#status").removeAttr('disabled');
          $("#evidence").removeAttr('disabled');
          $("#tipe").removeAttr('disabled');
          $("#evaluasi").removeAttr('readonly');
          $("#note").removeAttr('readonly');
          
          $(".evidence_input").show();
          $(".evidence_show").hide();
          $(".foto_standar").attr("href", `<?= base_url(); ?>uploads/travel_path/${res.standar}`);

          $("#status").val('#');
          $("#evidence").val('');
          $("#tipe").val('#');
          $("#evaluasi").val('');
          $("#note").val('');

          $("#btn_save_travel_path").show();
        }
        $(".text_category").text(`${res.category} | Poin ${path_id}`);
        $(".text_path").text(res.travel_path);
        // $(".progress-stepbar").html(res);
      },
      error: function(jqXHR){
        console.log(jqXHR.responseText);
      }
    });
    // console.log(tp_id,path_id);
  }

  function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))

      return false;
    return true;
  }
</script>