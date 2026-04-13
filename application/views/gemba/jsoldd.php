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

    list_gemba('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');
    
    /*Range*/
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
      $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="start"]').val(start.format('YYYY-MM-DD'));
      $('input[name="end"]').val(end.format('YYYY-MM-DD'));
      list_gemba(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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
    
    tipe = new SlimSelect({
      select: "#tipe_gemba"
    });

    $('#tgl_plan').datetimepicker({
        format: 'Y-m-d',
        timepicker: false,
        minDate: 0,
    });

  });

  function save_gemba(){
    if ($("#tgl_plan").val() == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Plan Date is empty!',
        buttons: {
            close: {
                actions: function() {}
            },
        },
      });
    } else if ($("#tipe_gemba :selected").val() == "#") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Tipe Gemba is empty!',
        buttons: {
            close: {
                actions: function() {}
            },
        },
      });
    } else if ($("#lokasi").val() == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Location is empty!',
        buttons: {
            close: {
                actions: function() {}
            },
        },
      });
    } else {
      // Please waiting
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
            method: "POST",
            url: "<?= base_url("gemba/save_gemba") ?>",
            dataType: "JSON",
            data: $("#form_plan").serialize(),
            beforeSend: function (res){
              $("#btn_save").attr("disabled",true);
            },
            success: function (res){
              console.log(res);
              if (res.warning != "") {
                $.confirm({
                  icon: 'fa fa-times-circle',
                  title: 'Warning',
                  theme: 'material',
                  type: 'red',
                  content: `${res.warning}`,
                  buttons: {
                      close: {
                          actions: function() {}
                      },
                  },
                });
              } else {
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
                $("#dt_list_gemba").DataTable().ajax.reload();
                $("#modal_add_plan").modal("hide");
                $("#form_plan")[0].reset();
              }
              $("#btn_save").removeAttr("disabled");
              jconfirm.instances[0].close();
            },
            error: function (jqXHR, textStatus, errorThrown){
              console.log(jqXHR.responseText);
              jconfirm.instances[0].close();
            }
          });
        }
      });
    }
  }

  function list_proses()
  {
    $("#modal_list_proses").modal("show");
    $('#dt_list_proses').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List Proses Gemba',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('gemba/list_proses') ?>",
        "dataType": 'JSON',
        "type": "GET",
        // "data": {
        //   datestart: start,
        //   dateend: end
        // },
        // "success": function (res){
        //   console.log(res);
        // },
        // "error": function (jqXHR){
        //   console.log(jqXHR.responseText);
        // }
      },
      "columns": [
        {
          'data': 'id_gemba',
          'render': function(data,type,row){
            return `<a href="javascript:void(0);" class="badge bg-sm bg-info" onclick="proses_gemba('${data}')">${data}</a>`;
          },
          'className': 'text-center'
        },
        {
          'data': 'tgl_plan'
        },
        {
          'data': 'tipe_gemba'
        },
        {
          'data': 'lokasi'
        },
        {
          'data': 'evaluasi'
        },
        {
          'data': 'peserta'
        },
        {
          'data': 'created_at'
        },
        {
          'data': 'created_by'
        }
      ]
    });
  }

  function proses_gemba(id_gemba)
  {
    $("#modal_proses_gemba").modal("show");
    $.ajax({
      url: "<?php echo base_url("gemba/get_detail_gemba/") ?>"+id_gemba,
      method: "GET",
      dataType: "JSON",
      success: function(res){
        // console.log(res);
        $("#list_detail_gemba").html(res);
      },
      error: function(jqXHR){
        console.log(jqXHR.responseText);
      }
    });

    $.ajax({
      url: "<?php echo base_url("gemba/get_detail_evaluasi/") ?>"+id_gemba,
      method: "GET",
      dataType: "JSON",
      success: function(res){
        // console.log(res);
        $("#id_gemba").val(res.id_gemba);
        $("#detail_tipe_gemba").text(res.tipe_gemba);
        $("#detail_plan_date").text(res.tgl_plan);
        $("#detail_location").text(res.lokasi);
        $("#peserta").val(res.peserta);
        $("#evaluasi").val(res.evaluasi);
        $("#status_akhir").val(res.status);
      },
      error: function(jqXHR){
        console.log(jqXHR.responseText);
      }
    });
  }

  function save_proses_gemba(id_gemba_ceklis)
  {
    id_gemba  = $(`#id_gemba_${id_gemba_ceklis}`).val();
    status    = $(`#status_item_${id_gemba_ceklis}`).val();
    file      = $(`#file_item_${id_gemba_ceklis}`).val();
    link      = $(`#link_item_${id_gemba_ceklis}`).val();
    note      = $(`#note_item_${id_gemba_ceklis}`).val();

    if ($(`#status_item_${id_gemba_ceklis} :selected`).val() == "#") {
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
      return false;
    } else if ($(`#file_item_${id_gemba_ceklis}`).val() == "" && $(`#link_item_${id_gemba_ceklis}`).val() == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'File or Link is empty!',
        buttons: {
            close: {
                actions: function() {}
            },
        },
      });
      return false;
    } else if ($(`#note_item_${id_gemba_ceklis}`).val() == "") {
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
      return false;
    } else {
      $(`#btn_save_proses_gemba_${id_gemba_ceklis}`).attr("disabled",true);
      let file_item = $(`#file_item_${id_gemba_ceklis}`).prop("files")[0];
      let form_file = new FormData();                    
      form_file.append("id_gemba", id_gemba);
      form_file.append("id_gemba_ceklis", id_gemba_ceklis);
      form_file.append("status", status);
      form_file.append("file_item", file_item);
      form_file.append("link", link);
      form_file.append("note", note);
      $.ajax({
        url: "<?php echo base_url("gemba/save_proses_gemba") ?>",
        method: "POST",
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,
        data: form_file,
        success: function(res){
          proses_gemba(id_gemba);
          $(`#btn_save_proses_gemba_${id_gemba_ceklis}`).removeAttr("disabled");
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
          $("#dt_list_proses").DataTable().ajax.reload();
          $("#dt_list_gemba").DataTable().ajax.reload();
        },
        error: function(jqXHR){
          console.log(jqXHR.responseText);
          $(`#btn_save_proses_gemba_${id_gemba_ceklis}`).removeAttr("disabled");
        }
      });
    }
  }

  function save_proses_evaluasi()
  {
    id_gemba      = $('#id_gemba').val();
    peserta       = $('#peserta').val();
    evaluasi      = $('#evaluasi').val();
    status_akhir  = $('#status_akhir :checked').val();

    if (peserta == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Jumlah Peserta is empty!',
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
        content: 'Evaluation is empty!',
        buttons: {
            close: {
                actions: function() {}
            },
        },
      });
    } else if (status_akhir == "#") {
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
    } else {
      $.ajax({
        url: "<?php echo base_url("gemba/save_proses_evaluasi") ?>",
        method: "POST",
        dataType: "JSON",
        data: {
          id_gemba: id_gemba,
          peserta: peserta,
          evaluasi: evaluasi,
          status_akhir: status_akhir
        },
        beforeSend: function(res){
          $("#btn_save_proses_evaluasi").attr("disabled",true);
        },
        success: function(res){
          proses_gemba(id_gemba);
          $("#btn_save_proses_evaluasi").removeAttr("disabled");
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
          if (evaluasi != "") {
            $("#modal_proses_gemba").modal("hide");
          }
          $("#dt_list_proses").DataTable().ajax.reload();
          $("#dt_list_gemba").DataTable().ajax.reload();
        },
        error: function(jqXHR){
          console.log(jqXHR.responseText);
        }
      });
    }
  }

  function list_gemba(start,end)
  {
    $('#dt_list_gemba').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List Gemba',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('gemba/list_gemba') ?>",
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
          'data': 'id_gemba',
          'render': function(data,type,row){
            return `<a href="javascript:void(0);" class="badge bg-sm bg-primary" onclick="result_gemba('${data}')">${data}</a>`;
          },
          'className': 'text-center'
        },
        {
          'data': 'tgl_plan'
        },
        {
          'data': 'tipe_gemba'
        },
        {
          'data': 'lokasi'
        },
        {
          'data': 'evaluasi'
        },
        {
          'data': 'peserta'
        },
        {
          'data': 'status',
          'render': function(data,type,row){
            return `<span class="badge bg-sm bg-${row['color']}">${data}</span>
            <span class="badge bg-sm bg-${row['color_akhir']}">${row['status_akhir']}</span>`;
          }
        },
        {
          'data': 'created_at'
        },
        {
          'data': 'created_by'
        },
        // {
        //   'data': 'updated_at'
        // },
        // {
        //   'data': 'updated_by'
        // }
      ]
    });
  }
  
  function result_gemba(id_gemba)
  {
    $("#modal_result_gemba").modal("show");
    $('#dt_result_gemba').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List Detail Result Gemba',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('gemba/get_result_gemba') ?>",
        "dataType": 'JSON',
        "type": "POST",
        "data": {
          id_gemba: id_gemba
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
          'data': 'concern'
        },
        {
          'data': 'monitoring'
        },
        {
          'data': 'status'
        },
        {
          'data': 'file',
          'render': function(data,type,row){
            if (data != "") {
              return `<a href="<?= base_url('uploads/gemba/') ?>${data}" class="btn btn-sm btn-info text-white" target="_blank"><i class="bi bi-file-earmark-medical"></i></a>`;
            } else {
              return ``;
            }
          }
        },
        {
          'data': 'link',
          'render': function(data,type,row){
            if (data != "") {
              return `<a href="${data}" class="btn btn-sm btn-primary text-white" target="_blank"><i class="bi bi-link"></i></a>`;
            } else {
              return ``;
            }
          }
        },
        {
          'data': 'status_item',
          'render': function(data,type,row){
            return `<span class="badge bg-sm bg-${row['warna_item']}">${data}</span>`;
          }
        },
        {
          'data': 'updated_at'
        },
        {
          'data': 'updated_by'
        }
      ]
    });
    
  }

  function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))

      return false;
    return true;
  }

</script>