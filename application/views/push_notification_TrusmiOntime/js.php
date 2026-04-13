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

<!-- Summer Note css/js -->
<link href="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.css" rel="stylesheet">
<script src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>

<script type="text/javascript">
  // var table_ajax;

  $(document).ready(function() {

    list_problem('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');

    /*Range*/
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
      $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="start"]').val(start.format('YYYY-MM-DD'));
      $('input[name="end"]').val(end.format('YYYY-MM-DD'));
      list_problem(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));

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

    ct = new SlimSelect({
      select: "#category"
    });
      
    // Karyawan
    ky = new SlimSelect({
      select: "#karyawan"
    });

    fc = new SlimSelect({
      select: "#factor"
    });

    pc = new SlimSelect({
      select: "#pic"
    });

    $('#deadline').datetimepicker({
        format: 'Y-m-d',
        timepicker: false,
        minDate: 0,
    });

    $('#problem').summernote({
        placeholder: '...',
        tabsize: 2,
        height: 150,
        toolbar: [
            ['font', ['bold', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
        ]
    });	

    $('#resume').summernote({
        placeholder: '...',
        tabsize: 2,
        height: 150,
        toolbar: [
            ['font', ['bold', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
        ]
    });	

  });

  function add_problem()
  {
    // Auto Get Date Today
    // curdate = (new Date()).toISOString().split('T')[0];
    // $("#tanggal").val(curdate);
    
    // upper = <?= $_SESSION['user_id'] ?>;

    // // Set Otomatis yg input
    // ats.setSelected(upper.toString());

    // $('#review').summernote('code', "Testing IT Review");
    // $('#goals').summernote('code', "Testing IT Goals Auto");

    $("#modal_add_problem").modal("show");
  }

  function change_karyawan()
  {
    // Change Karyawan to Get Detail Data
    karyawan = $("#karyawan").val().split("|");

    if ($("#karyawan").val() != "#" && karyawan[1] == "mkt_rsp") {
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
          $.ajax({
            url: "<?= base_url("co_co/get_detail_mkt_rsp/") ?>"+karyawan[0],
            method: "GET",
            dataType: "JSON",
            success: function (res){
              console.log(res);
              text_review = `<b>Pencapaian Target KPI Marketing Berdasarkan usia join ${res.kategori_umur}</b>
<ul><li>Pencapaian Booking : ${res.booking}</li>
<li>Pencapaian Akad : ${res.akad}<br></li></ul>`;

              text_goals = `<b>Target KPI Marketing Berdasarkan usia join ${res.kategori_umur}</b>
<ul><li>Pencapaian Booking : ${res.tgt_booking}</li>
<li>Pencapaian Akad : ${res.tgt_akad}<br></li></ul>`;

              text_reality = `<b>Kendala Internal :</b>
<ul><li>&nbsp;<br></li></ul>

<b>Kendala Eksternal :</b>
<ul><li><br></li></ul>`;

              text_option = `<b>Solusi dari Sales :</b>
<ul><li><br></li></ul>

<b>Solusi dari Atasan :</b>
<ul><li><br></li></ul>`;

              $('#review').summernote('code', text_review);
              $('#goals').summernote('code', text_goals);
              $('#reality').summernote('code', text_reality);
              $('#option').summernote('code', text_option);
              jconfirm.instances[0].close();
            },
            error: function (jqXHR, textStatus, errorThrown){
              console.log(jqXHR.responseText);
              jconfirm.instances[0].close();
            }
          });
        }
      });
      // End
      
    }
  }

  function save_problem()
  {
    judul   = $("#judul").val();
    pesan   = $("#pesan").val();
    pic     = $("#karyawan").val();

    // console.log(problem);

    // console.log(karyawan);

    // if (problem == "" || problem == '<p><br></p>' || problem == '<br>' || problem == '<p>&nbsp;</p>') {
    //   $.confirm({
    //     icon: 'fa fa-times-circle',
    //     title: 'Warning',
    //     theme: 'material',
    //     type: 'red',
    //     content: 'Problem is empty!',
    //     buttons: {
    //         close: {
    //             actions: function() {}
    //         },
    //     },
    //   });
    // } else if (category == "#") {
    //   $.confirm({
    //     icon: 'fa fa-times-circle',
    //     title: 'Warning',
    //     theme: 'material',
    //     type: 'red',
    //     content: 'Category is empty!',
    //     buttons: {
    //         close: {
    //             actions: function() {}
    //         },
    //     },
    //   });
    // } else if (priority == "#") {
    //   $.confirm({
    //     icon: 'fa fa-times-circle',
    //     title: 'Warning',
    //     theme: 'material',
    //     type: 'red',
    //     content: 'Priority is empty!',
    //     buttons: {
    //         close: {
    //             actions: function() {}
    //         },
    //     },
    //   });
    // } else if (deadline == "") {
    //   $.confirm({
    //     icon: 'fa fa-times-circle',
    //     title: 'Warning',
    //     theme: 'material',
    //     type: 'red',
    //     content: 'Deadline is empty!',
    //     buttons: {
    //         close: {
    //             actions: function() {}
    //         },
    //     },
    //   });
    // } else if (factor == "#") {
    //   $.confirm({
    //     icon: 'fa fa-times-circle',
    //     title: 'Warning',
    //     theme: 'material',
    //     type: 'red',
    //     content: 'Factor is empty!',
    //     buttons: {
    //         close: {
    //             actions: function() {}
    //         },
    //     },
    //   });
    // } else if (pic == "#") {
    //   $.confirm({
    //     icon: 'fa fa-times-circle',
    //     title: 'Warning',
    //     theme: 'material',
    //     type: 'red',
    //     content: 'PIC is empty!',
    //     buttons: {
    //         close: {
    //             actions: function() {}
    //         },
    //     },
    //   });
    // } else {
      // Please waiting      
      // let foto = $(`#foto`).prop("files")[0];
      // let form_file = new FormData();        
      // new_karyawan  = karyawan.split("|"); 
      // form_file.append("karyawan", new_karyawan[0]);
      // form_file.append("tempat", tempat);
      // form_file.append("tanggal", tanggal);
      // form_file.append("atasan", atasan);
      // form_file.append("review", review);
      // form_file.append("goals", goals);
      // form_file.append("reality", reality);
      // form_file.append("option", option);
      // form_file.append("will", will);
      // form_file.append("komitmen", komitmen);
      // form_file.append("foto", foto);

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
          $.ajax({
            method: "POST",
            url: "<?= base_url("Push_notification_TrusmiOntime/sendPushNotif") ?>",
            dataType: "JSON",
            // cache: false,
            // contentType: false,
            // processData: false,
            // data: form_file,
            data: $("#form_problem").serialize(),
            beforeSend: function (res){
              $("#btn_save").attr("disabled",true);
            },
            success: function (res){
              console.log('Success : ',res);
              $.confirm({
                icon: 'fa fa-check',
                title: 'Success',
                theme: 'material',
                type: 'green',
                content: 'Notification has been sent!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
              });
              $("#dt_list_problem").DataTable().ajax.reload();
              $("#modal_add_problem").modal("hide");
              $("#form_problem")[0].reset();              
              // ct.setSelected("#");
              // pt.setSelected("#");
              $("#btn_save").removeAttr("disabled");
              // $('#problem').summernote('reset');
              // $('#pembahasan_draft').summernote('code', dt.pembahasan);
              jconfirm.instances[0].close();
            },
            error: function (jqXHR, textStatus, errorThrown){
              console.log('Error : ',jqXHR.responseText);
              jconfirm.instances[0].close();
            }
          });
        }
      });
    // }
  }

  function list_problem(start,end)
  {
    $('#dt_list_problem').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List Problem Solving',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('Push_notification_TrusmiOntime/list_push_notification') ?>",
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
          // 'render': function(data,type,row){
          //   res = data;
          //   if (row['status_id'] < 3) { // 1 : Waiting, 2 : Progress
          //     res = `<a href="javascript:void(0);" class="badge bg-sm bg-primary" onclick="proses_resume('${data}')">${data}</a>`;
          //   }
          //   return res;
          // },
          'className': 'text-center'
        },
        {
          'data': 'judul'
        },
        {
          'data': 'pesan'
        },
        {
          'data': 'karyawan'
        },
        {
          'data': 'created_by',
          'render': function(data,type,row){
            return `<span>${data}</span><br>
            <hr style="margin-top:3px;margin-bottom:3px;">
            <p class="mb-0 text-muted small"><i class="bi bi-clock"></i> ${row['created_at']}</p>`;
          },
          'width':'20%'
        }
      ]
    });
  }

  function proses_resume(id)
  {
    $("#modal_proses_resume").modal("show");
    $("#id_ps").val(id);
    get_detail_problem(id);
  }

  function get_detail_problem(id){
    $.ajax({
      method: "GET",
      url: "<?= base_url("problem_solving/get_detail_problem/") ?>"+id,
      dataType: "JSON",
      success: function (res){
        // console.log(res);
        $("#detail_category").text(res.category);
        $("#detail_priority").text(res.priority);
        $("#detail_deadline").text(res.deadline);
        $("#detail_factor").text(res.factor);
        $("#detail_pic").text(res.pic);
      },
      error: function (jqXHR, textStatus, errorThrown){
        console.log(jqXHR.responseText);
        jconfirm.instances[0].close();
      }
    });
  }

  function save_proses_resume()
  {
    id_ps     = $("#id_ps").val();
    status    = $("#status_akhir ").val();
    resume    = $("#resume").val();

    // console.log(status);

    if (status == '#') {
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
    } else if (resume == "" || resume == '<p><br></p>' || resume == '<br>' || resume == '<p>&nbsp;</p>') {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Resume is empty!',
        buttons: {
            close: {
                actions: function() {}
            },
        },
      });
    } else {
      // Please waiting      
      // let foto = $(`#foto`).prop("files")[0];
      // let form_file = new FormData();        
      // new_karyawan  = karyawan.split("|"); 
      // form_file.append("karyawan", new_karyawan[0]);
      // form_file.append("tempat", tempat);
      // form_file.append("tanggal", tanggal);
      // form_file.append("atasan", atasan);
      // form_file.append("review", review);
      // form_file.append("goals", goals);
      // form_file.append("reality", reality);
      // form_file.append("option", option);
      // form_file.append("will", will);
      // form_file.append("komitmen", komitmen);
      // form_file.append("foto", foto);

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
          $.ajax({
            method: "POST",
            url: "<?= base_url("problem_solving/save_proses_resume") ?>",
            dataType: "JSON",
            // cache: false,
            // contentType: false,
            // processData: false,
            // data: form_file,
            data: $("#form_proses_resume").serialize(),
            beforeSend: function (res){
              $("#btn_save_proses_resume").attr("disabled",true);
            },
            success: function (res){
              console.log(res);
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
              $("#dt_list_problem").DataTable().ajax.reload();
              $("#modal_proses_resume").modal("hide");
              $("#form_proses_resume")[0].reset();
              $("#btn_save_proses_resume").removeAttr("disabled");
              $('#resume').summernote('reset');
              // $('#pembahasan_draft').summernote('code', dt.pembahasan);
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
</script>