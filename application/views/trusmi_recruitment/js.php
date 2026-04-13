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

<script type="text/javascript">
  // var table_ajax;

  $(document).ready(function() {

    data_recruitment('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');
    
    /*Range*/
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
      $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="start"]').val(start.format('YYYY-MM-DD'));
      $('input[name="start_target"]').val(start.format('YYYY-MM-DD'));
      $('input[name="end"]').val(end.format('YYYY-MM-DD'));
      data_recruitment(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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
    
    // Start Target Marketing
    prd = new SlimSelect({
      select: "#period"
    });
    
    pc = new SlimSelect({
      select: "#pic"
    });
    
    epc = new SlimSelect({
      select: "#e_pic"
    });
    
    jb = new SlimSelect({
      select: "#jobs"
    });

    $("#btn_save_target_marketing").click(function()
    { 
      if ($("#period").val() == "-- Choose Period --") {
        prd.open();
      } else if ($("#pic").val() == "-- Choose Employee --") {
        pc.open();
      } else if ($("#target").val() == "") {
        $("#target").addClass("is-invalid");
        $("#target").focus();
      } else if ($("#jobs").val() == "-- Choose Job --") {
        jb.open();
      } else {
        $("#target").removeClass("is-invalid");
        $.ajax({
          method: "POST",
          url: "<?= base_url("trusmi_recruitment/save_target") ?>",
          dataType: "JSON",
          data: $("form").serialize(),
          beforeSend: function (res){
            $("#btn_save_target_marketing").attr("disabled",true);
            $('#spinner').modal('show');
          },
          success: function (res){
            swal("Success!!", "Data has been saved", "success");
            $("#btn_save_target_marketing").removeAttr("disabled");
            $("#modal_target_marketing").modal("hide");
            $("#form_target_marketing")[0].reset();
            prd.setSelected("-- Choose Period --");
            pc.setSelected("-- Choose Employee --");
            jb.setSelected("-- Choose Job --");
            $("#dt_recruitment").DataTable().ajax.reload();
            setTimeout(() => {
              $('#spinner').modal('hide');
            }, 1000);
          },
          error: function (jqXHR, textStatus, errorThrown){
            console.log(jqXHR.responseText);
          }
        });
      }
    });

    $("#target").keyup(function(){
      $("#target").removeClass("is-invalid");
    });
    // End Target Marketing

    // Update PIC
    $("#dt_recruitment").on("click",".edit_pic",function(){
      trusmi_request_id = $(this).data("tri");
      job_id            = $(this).data("job_id");
      tipe              = $(this).data("tipe");
      id_pic            = $(this).data("id_pic");
      id_target_mkt     = $(this).data("id_target_mkt");
      $('#modal_pic').modal('show');

      $('#trusmi_request_id_pic').val(trusmi_request_id);
      $('#job_id_pic').val(job_id);
      $('#tipe_pic').val(tipe);
      $('#id_target_mkt').val(id_target_mkt);
      if (id_pic != null) {
        epc.setSelected(id_pic.toString());
      } else {
        epc.setSelected("-- Choose Employee --");
      }
    });
    // End Update PIC

    $("#period").change(function(){
      jb.setSelected("-- Choose Job --");
      get_jobs($("#period").val());
    });

  });

  // Untuk Penambahan Filter Get Job Target Marketing
  function get_jobs(period)
  {
    $.ajax({
      url: "<?= base_url('trusmi_recruitment/get_jobs/') ?>"+period,
      method: "GET",
      dataType: "HTML",
      success: function (res){
        console.log(res);
        $("#jobs").empty().append(res);
      },
      error: function (xhr){
        console.log(xhr.responseText);
      }
    });
  }

  function data_recruitment(start, end) {
    console.log(`start : ${start}, end : ${end}`);
    var tabel_recruitment =
      $('#dt_recruitment').DataTable({
        "lengthChange": false,
        "searching": true,
        "info": true,
        "paging": true,
        "autoWidth": false,
        "destroy": true,
        dom: 'Bfrtip',
        buttons: [{
          extend: 'excelHtml5',
          text: 'Export to Excel',
          footer: true
        }],
        "ajax": {
          "dataType": 'json',
          "type": "POST",
          "data": {
            datestart: start,
            dateend: end
          },
          "url": "<?= base_url('trusmi_recruitment/get_recruitment') ?>"
          // "success": function (res){
          //   console.log(res);
          // },
          // "error": function (jqXHR){
          //   console.log(jqXHR.responseText);
          // }
        },
        "columns": [
          {
            "data": "job_id",
            "render": function (data,type,row,meta){
              return meta.row + 1;
            },
            "className": "text-center"
          },
          {
            "data": "job_title"
          },
          {
            "data": "role_name"
          },
          {
            "data": "company"
          },
          {
            "data": "leadtime_tgt",
            "render": function (data,type,row){
              return `<span class="badge bg-primary">${data}</span>`;
            }
          },
          {
            "data": "pic",
            "render": function (data,type,row){
              if (data == null) {
                return `<a href="javascript:void(0)" class="edit_pic" data-tri="${row['trusmi_request_id']}" data-job_id="${row['job_id']}" data-id_pic="${row['id_pic']}" data-tipe="${row['tipe']}" data-id_target_mkt="${row['id_target_mkt']}"><span class="bi bi-pencil-square" style="color:orange;"></span></a>`;
              } else {
                return `<a href="javascript:void(0)" class="edit_pic" data-tri="${row['trusmi_request_id']}" data-job_id="${row['job_id']}" data-id_pic="${row['id_pic']}" data-tipe="${row['tipe']}" data-id_target_mkt="${row['id_target_mkt']}"><span class="badge bg-primary">${data}</span></a>`;
              }
            }
          },
          {
            "data": "total_lamar",
            "render": function (data,type,row){
              if (data == null){
                return `<a href="javascript:void(0)" onclick="detail_lamar('${row['job_id']}')"><span class="badge bg-danger">0</span></a>`;
              } else {
                return `<a href="javascript:void(0)" onclick="detail_lamar('${row['job_id']}')"><span class="badge bg-dark">${data}</span></a>`;
              }
            }
          },
          {
            "data": "total_psikotes",
            "render": function (data,type,row){
              if (data == null){
                return `<a href="javascript:void(0)" onclick="detail_psikotes('${row['job_id']}','${row['tipe']}','${row['id_pic']}')"><span class="badge bg-danger">0</span></a>`;
              } else {
                return `<a href="javascript:void(0)" onclick="detail_psikotes('${row['job_id']}','${row['tipe']}','${row['id_pic']}')"><span class="badge bg-dark">${data}</span></a>`;
              }
            }
          },
          {
            "data": "total_interview",
            "render": function (data,type,row){
              if (data == null){
                return `<a href="javascript:void(0)" onclick="detail_interview('${row['job_id']}','${row['tipe']}','${row['id_pic']}')"><span class="badge bg-danger">0</span></a>`;
              } else {
                return `<a href="javascript:void(0)" onclick="detail_interview('${row['job_id']}','${row['tipe']}','${row['id_pic']}')"><span class="badge bg-dark">${data}</span></a>`;
              }
            }
          },
          {
            "data": "total_administrasi",
            "render": function (data,type,row){
              if (data == null){
                return `<a href="javascript:void(0)" onclick="detail_administrasi('${row['job_id']}','${row['tipe']}','${row['id_pic']}')"><span class="badge bg-danger">0</span></a>`;
              } else {
                return `<a href="javascript:void(0)" onclick="detail_administrasi('${row['job_id']}','${row['tipe']}','${row['id_pic']}')"><span class="badge bg-dark">${data}</span></a>`;
              }
            }
          },
          {
            "data": "target",
            "render": function (data,type,row){
                return `<a href="javascript:void(0)" onclick="edit_target('${row['job_id']}','${data}','${row['tipe']}','${row['id_target_mkt']}')"><span class="badge bg-success">${data}</span></a>`;
            }
          },
          {
            "data": "total_karyawan",
            "render": function (data,type,row){
              if (parseInt(row['total_karyawan']) >= parseInt(row['target'])) {
                color = "success";
              } else {
                color = "danger";
              }

              if (data == null){
                return `<a href="javascript:void(0)" onclick="detail_karyawan('${row['job_id']}','${row['tipe']}','${row['id_pic']}')"><span class="badge bg-danger">0</span></a>`;
              } else {
                return `<a href="javascript:void(0)" onclick="detail_karyawan('${row['job_id']}','${row['tipe']}','${row['id_pic']}')"><span class="badge bg-${color}">${data}</span></a>`;
              }
            }
          },
          {
            "data": "ach",
            "render": function (data,type,row){
              if (data == null){
                return `<span class="badge bg-danger">0 %</span>`;
              } else {
                return `${data} %`;
              }
            }
          },
          {
            "data": "tgl_posting"
          }
        ]
      });
  }

  function detail_lamar(job_id)
  {
    $('#modal_lamar').modal('show');

    url = "<?= site_url() ?>trusmi_recruitment/data_lamar/" + job_id;
    $('#dt_lamar').DataTable({
      'destroy'       : true,
      'lengthChange'  : false,
      'searching'     : true,
      'info'          : true,
      'paging'        : true,
      "autoWidth"     : false,
      "ajax" : {
        "dataType"  : 'JSON',
        "type"      : "GET",
        "url"       : url
      },
      "columns" : [
        {
          "data" : "full_name"
        },
        {
          "data" : "contact"
        },
        {
          "data" : "email"
        },
        {
          "data" : "message"
        }
      ]
		});
  }

  function detail_psikotes(job_id,tipe,id_pic)
  {
    $('#modal_psikotes').modal('show');

    url = "<?= site_url() ?>trusmi_recruitment/data_psikotes/" + job_id + "/" + tipe + "/" + id_pic;
    $('#dt_psikotes').DataTable({
      'destroy'       : true,
      'lengthChange'  : false,
      'searching'     : true,
      'info'          : true,
      'paging'        : true,
      "autoWidth"     : false,
      "ajax" : {
        "dataType"  : 'json',
        "type"      : "GET",
        "url"       : url
      },
      "columns" : [
				{
          "data" : "full_name"
        },
				{
          "data" : "iq"
        },
				{
          "data" : "disc"
        },
				{
          "data" : "keterangan"
        }
      ]
		});
  }

  function detail_interview(job_id,tipe,id_pic)
  {
    $('#modal_interview').modal('show');

    url = "<?= site_url() ?>trusmi_recruitment/data_interview/" + job_id + "/" + tipe + "/" + id_pic;
    $('#dt_interview').DataTable({
      'destroy'       : true,
      'lengthChange'  : false,
      'searching'     : true,
      'info'          : true,
      'paging'        : true,
      "autoWidth"     : false,
      "ajax" : {
        "dataType"  : 'json',
        "type"      : "GET",
        "url"       : url
      },
      "columns" : [
				{
          "data" : "full_name"
        },
				{
          "data" : "keterangan"
        }
      ]
		});
  }

  function detail_administrasi(job_id,tipe,id_pic)
  {
    $('#modal_administrasi').modal('show');

    url = "<?= site_url() ?>trusmi_recruitment/data_administrasi/" + job_id + "/" + tipe + "/" + id_pic;
    $('#dt_administrasi').DataTable({
      'destroy'       : true,
      'lengthChange'  : false,
      'searching'     : true,
      'info'          : true,
      'paging'        : true,
      "autoWidth"     : false,
      "ajax" : {
        "dataType"  : 'json',
        "type"      : "GET",
        "url"       : url
      },
      "columns" : [
				{
          "data" : "full_name"
        },
				{
          "data" : "keterangan"
        }
      ]
		});
  }

  function detail_karyawan(job_id,tipe,id_pic){
    console.log(job_id);
    $('#modal_karyawan').modal('show');

    url = "<?= site_url() ?>trusmi_recruitment/data_karyawan/" + job_id + "/" + tipe + "/" + id_pic;
    $('#dt_karyawan').DataTable({
      'destroy'       : true,
      'lengthChange'  : false,
      'searching'     : true,
      'info'          : true,
      'paging'        : true,
      "autoWidth"     : false,
      "ajax" : {
        "dataType"  : 'json',
        "type"      : "GET",
        "url"       : url
      },
      "columns" : [
				{
          "data" : "full_name"
        },
				{
          "data" : "leadtime"
        }
      ]
		});
  }

  function edit_target(job_id,target,tipe,id_target_mkt){
    $('#modal_target_sdm').modal('show');

    $('#target_job_id').val(job_id);
    $('#target_sdm').val(target);
    $('#target_tipe').val(tipe);
    $('#e_id_target_mkt').val(id_target_mkt);
  }

  function update_target()
  {
    $.ajax({
      url: '<?= site_url() ?>trusmi_recruitment/edit_target_sdm',
      type: 'POST',
      dataType: 'JSON',
      data: $("#form_target").serialize(),
      beforeSend: function (res){
        $("#btn_save_target").prop("disabled", true);
      },
      success: function (res) {
        console.log(res);
        swal("Success","Target has been updated","success");
        $("#btn_save_target").prop("disabled", false);
        $("#dt_recruitment").DataTable().ajax.reload();
        $('#modal_target_sdm').modal('hide');
      },
      error: function(xhr){
        console.log(xhr.responseText);
      }
    });
  }

  function update_pic()
  {
    $.ajax({
      url: '<?= site_url() ?>trusmi_recruitment/edit_pic',
      type: 'POST',
      dataType: 'JSON',
      data: $("#form_pic").serialize(),
      beforeSend: function (res){
        $("#btn_save_pic").prop("disabled", true);
      },
      success: function (res) {
        console.log(res);
        swal("Success","PIC has been updated","success");
        $("#btn_save_pic").prop("disabled", false);
        $("#dt_recruitment").DataTable().ajax.reload();
        $('#modal_pic').modal('hide');
      },
      error: function(xhr){
        console.log(xhr.responseText);
      }
    });
  }

</script>