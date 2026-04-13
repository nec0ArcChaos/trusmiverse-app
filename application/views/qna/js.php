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

<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script type="text/javascript">
  // var table_ajax;

  // Start Ready Function
  $(document).ready(function() {

    // list_result_qna('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');
    // resume_qna_by_sub('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');
    // resume_qna_by_question('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');
    filter_list_qna();
    
    /*Range*/
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
      $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="start"]').val(start.format('YYYY-MM-DD'));
      $('input[name="end"]').val(end.format('YYYY-MM-DD'));
      list_result_qna(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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
    
    function cb_sub(start, end) {
      $('.reportrange_sub input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="start_sub"]').val(start.format('YYYY-MM-DD'));
      $('input[name="end_sub"]').val(end.format('YYYY-MM-DD'));
      resume_qna_by_sub(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
    }

    $('.range_sub').daterangepicker({
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
    }, cb_sub);

    cb_sub(start, end);
    
    function cb_question(start, end) {
      $('.reportrange_question input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="start_question"]').val(start.format('YYYY-MM-DD'));
      $('input[name="end_question"]').val(end.format('YYYY-MM-DD'));
      resume_qna_by_question(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
    }

    $('.range_question').daterangepicker({
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
    }, cb_question);

    cb_question(start, end);

    $("#periode").datepicker( {
      format: "yyyy-mm",
      startView: "months", 
      minViewMode: "months",
      autoclose: true,
    });
    
    // tipe = new SlimSelect({
    //   select: "#tipe_gemba"
    // });

    // $('#tgl_plan').datetimepicker({
    //     format: 'Y-m-d',
    //     timepicker: false,
    //     minDate: 0,
    // });

  });
  // End Ready Function

  function filter_list_qna()
  {
    periode = $("#periode").val();
    list_qna(periode);
  }

  function list_qna(periode)
  {
    $('#dt_list_qna').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "ordering": true,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List QnA',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('qna/qna/list_qna/') ?>"+periode,
        "dataType": 'JSON',
        "type": "GET",
        // "success": function (res){
        //   console.log(res);
        // },
        // "error": function (jqXHR){
        //   console.log(jqXHR.responseText);
        // }
      },
      "columns": [
        {
          'data': 'id_question',
          'render': function(data,type,row){
            if (row['text_qna'] == "Complete") {
              return `<a href="javascript:void(0);" class="btn btn-md btn-outline-${row['color_qna']}">${row['text_qna']}</a>`;
            } else {
              return `<a href="<?= base_url(); ?>frm-qna/${row['encrypt']}" class="btn btn-md btn-outline-${row['color_qna']}" target="_blank">${row['text_qna']}</a>`;
            }
          },
          'className': 'text-center'
        },
        {
          'data': 'judul'
        },
        {
          'data': 'pengantar'
        },
        {
          'data': 'category'
        },
        {
          'data': 'company_name'
        },
        {
          'data': 'department_name'
        },
        {
          'data': 'role_name'
        },
        {
          'data': 'employees'
        },
        {
          'data': 'total_question'
        }
      ]
    });
  }

  function list_result_qna(start,end)
  {
    $('#dt_list_result_qna').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "ordering": true,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List Result QnA',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('qna/qna/list_result_qna') ?>",
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
          'data': 'id_answer',
          'render': function(data,type,row){
            return `<a href="javascript:void(0);" class="badge bg-sm bg-primary" onclick="result_qna('${data}')">${data}</a>`;
          },
          'className': 'text-center'
        },
        {
          'data': 'judul'
        },
        {
          'data': 'nilai'
        },
        {
          'data': 'indikator',
          'render': function(data,type,row){
            if (data == 'Istimewa') {
              return `<span class="badge bg-sm bg-info">${data}</span>`;
            } else if (data == 'Baik') {
              return `<span class="badge bg-sm bg-success">${data}</span>`;
            } else if (data == 'Cukup') {
              return `<span class="badge bg-sm bg-warning">${data}</span>`;
            } else {
              return `<span class="badge bg-sm bg-danger">${data}</span>`;
            }
          }
        },
        {
          'data': 'week'
        },
        {
          'data': 'periode'
        },
        {
          'data': 'created_at'
        },
        {
          'data': 'created_by',
          'render': function(data,type,row){
            return `<span>${data}</span><br>`;
          },
        },
        // {
        //   'data': 'created_by',
        //   'render': function(data,type,row){
        //     return `<span>${data}</span><br>
        //     <hr style="margin-top:3px;margin-bottom:3px;">
        //     <p class="mb-0 text-muted small"><i class="bi bi-buildings"></i> ${row['company_name']}</p>
        //     <hr style="margin-top:3px;margin-bottom:3px;">
        //     <p class="mb-0 text-muted small"><i class="bi bi-building-check"></i> ${row['department_name']}</p>
        //     <hr style="margin-top:3px;margin-bottom:3px;">
        //     <p class="mb-0 text-muted small"><i class="bi bi-person-badge"></i> ${row['role_name']}</p>`;
        //   },
        // },
        {
          'data': 'company_name'
        },
        {
          'data': 'department_name'
        },
        {
          'data': 'role_name'
        }
      ]
    });
  }
  
  function result_qna(id_answer)
  {
    $("#modal_result_qna").modal("show");
    $('#dt_result_qna').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List Detail Result QnA',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('qna/qna/get_result_qna') ?>",
        "dataType": 'JSON',
        "type": "POST",
        "data": {
          id_answer: id_answer
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
          'data': 'id_answer'
        },
        {
          'data': 'question'
        },
        {
          'data': 'answer'
        },
        {
          'data': 'bobot'
        }
      ]
    });
    
  }

  function resume_qna_by_sub(start,end)
  {
    $('#dt_resume_qna_by_sub').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "ordering": true,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data Resume QnA by Sub',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('qna/qna/get_resume_by_sub') ?>",
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
          'data': 'judul'
        },
        {
          'data': 'question'
        },
        {
          'data': 'nilai'
        },
        {
          'data': 'indikator',
          'render': function(data,type,row){
            if (data == 'Istimewa') {
              return `<span class="badge bg-sm bg-info">${data}</span>`;
            } else if (data == 'Baik') {
              return `<span class="badge bg-sm bg-success">${data}</span>`;
            } else if (data == 'Cukup') {
              return `<span class="badge bg-sm bg-warning">${data}</span>`;
            } else {
              return `<span class="badge bg-sm bg-danger">${data}</span>`;
            }
          }
        },
        {
          'data': 'a1'
        },
        {
          'data': 'a2'
        },
        {
          'data': 'a3'
        },
        {
          'data': 'a4'
        },
        {
          'data': 'a5'
        }
      ]
    });
  }

  function resume_qna_by_question(start,end)
  {
    $('#dt_resume_qna_by_question').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "ordering": true,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data Resume QnA by Question',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('qna/qna/get_resume_by_question') ?>",
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
          'data': 'judul'
        },
        {
          'data': 'sub'
        },
        {
          'data': 'question'
        },
        {
          'data': 'nilai'
        },
        {
          'data': 'indikator',
          'render': function(data,type,row){
            if (data == 'Istimewa') {
              return `<span class="badge bg-sm bg-info">${data}</span>`;
            } else if (data == 'Baik') {
              return `<span class="badge bg-sm bg-success">${data}</span>`;
            } else if (data == 'Cukup') {
              return `<span class="badge bg-sm bg-warning">${data}</span>`;
            } else {
              return `<span class="badge bg-sm bg-danger">${data}</span>`;
            }
          }
        },
        {
          'data': 'a1'
        },
        {
          'data': 'a2'
        },
        {
          'data': 'a3'
        },
        {
          'data': 'a4'
        },
        {
          'data': 'a5'
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