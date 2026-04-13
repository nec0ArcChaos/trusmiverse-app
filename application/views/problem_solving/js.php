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
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/dropdown.js"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script type="text/javascript">
  // var table_ajax;
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

    // project = new SlimSelect({
    //   select: "#project"
    // });

    ct = new SlimSelect({
      select: "#category"
    });

    pt = new SlimSelect({
      select: "#priority"
    });

    fc = new SlimSelect({
      select: "#factor"
    });

    pc = new SlimSelect({
      select: "#pic"
    });

    // tasklist = new SlimSelect({
    //   select: "#detail_pekerjaan"
    // });

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

  $('#addition').change(function() {
    if ($(this).is(':checked')) {
      $('.div_addition').show();
    } else {
      $('.div_addition').hide();
    }
  });

  $('#project').on('change', function() {
    id_project = $(this).val();

    $.ajax({
      url: '<?= base_url('problem_solving/get_pekerjaan') ?>',
      type: 'POST',
      dataType: 'json',
      data: {
        id_project: id_project
      },
      beforeSend: function() {
        // $('#pekerjaan').empty().append(
        //     '<option value=""><i class="fa fa-spinner fa-spin"></i> Loading..</option>')
        //   .prop('disabled', true);
      },
    }).done(function(response) {
      $('#pekerjaan').prop('disabled', false)
      list_pekerjaan = '<option value="#" disabled selected>Pilih SO</option>';
      if (response != null) {
        for (let index = 0; index < response.length; index++) {
          list_pekerjaan +=
            `<option value="${response[index].id}" >${response[index].pekerjaan} | ${response[index].periode}</option>`;
        }
      }
      $("#pekerjaan").empty().append(list_pekerjaan).prop('disabled', false);
      id_pekerjaan.update();
    }).fail(function(jqXhr, textStatus) {
      console.log("Failed Get Pekerjaan")
    });
  });

  $('#pekerjaan').on('change', function() {
    id_pekerjaan = $(this).val();

    $.ajax({
      url: '<?= base_url('problem_solving/get_sub_pekerjaan') ?>',
      type: 'POST',
      dataType: 'json',
      data: {
        id_pekerjaan: id_pekerjaan
      },
      beforeSend: function() {
        $('#sub_pekerjaan').empty().append(
            '<option value=""><i class="fa fa-spinner fa-spin"></i> Loading..</option>')
          .prop('disabled', true);
      },
    }).done(function(response) {
      $('#sub_pekerjaan').prop('disabled', false)
      list_sub_pekerjaan = '<option value="#" disabled selected>Pilih SI</option>';
      if (response != null) {
        for (let index = 0; index < response.length; index++) {
          list_sub_pekerjaan +=
            `<option value="${response[index].id}">${response[index].sub_pekerjaan}</option>`;
        }
      }
      $("#sub_pekerjaan").empty().append(list_sub_pekerjaan).prop('disabled', false);
      id_sub_pekerjaan.update();
    }).fail(function(jqXhr, textStatus) {
      console.log("Failed Get sub Pekerjaan")
    });
  });

  $('#sub_pekerjaan').on('change', function() {
    id_sub_pekerjaan = $(this).val();

    $.ajax({
      url: '<?= base_url('problem_solving/get_det_pekerjaan') ?>',
      type: 'POST',
      dataType: 'json',
      data: {
        id_sub_pekerjaan: id_sub_pekerjaan
      },
      beforeSend: function() {
        $('#detail_pekerjaan').empty().append(
          '<option value=""><i class="fa fa-spinner fa-spin"></i> Loading..</option>'
        ).prop('disabled', true);
      },
    }).done(function(response) {
      let newOptions = '';
      if (response != null) {
        response.forEach(item => {
          newOptions += `<option value="${item.id}">${item.detail}</option>`;
        });
      }
      $('#detail_pekerjaan').empty().append(newOptions).prop('disabled', false);
      id_detail_pekerjaan.update();
    }).fail(function(jqXhr, textStatus) {
      console.log("Failed Get Detail Pekerjaan");
    });
  });

  function add_problem() {
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

  function change_karyawan() {
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
            url: "<?= base_url("co_co/get_detail_mkt_rsp/") ?>" + karyawan[0],
            method: "GET",
            dataType: "JSON",
            success: function(res) {
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
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(jqXHR.responseText);
              jconfirm.instances[0].close();
            }
          });
        }
      });
      // End

    }
  }

  function save_problem() {
    problem = $("#problem").val();
    category = $("#category").val();
    priority = $("#priority").val();
    deadline = $("#deadline").val();
    factor = $("#factor").val();
    pic = $("#pic").val();

    console.log(problem);

    // console.log(karyawan);

    if (problem == "" || problem == '<p><br></p>' || problem == '<br>' || problem == '<p>&nbsp;</p>') {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Problem is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (category == "#") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Category is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (priority == "#") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Priority is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (deadline == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Deadline is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (factor == "#") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Factor is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (pic == "#") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'PIC is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if ($('#addition').is(':checked') && $("#project :selected").val() == "#") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Divisi is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if ($('#addition').is(':checked') && $("#pekerjaan :selected").val() == "#") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'SO is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if ($('#addition').is(':checked') && $("#sub_pekerjaan :selected").val() == "#") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'SI is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if ($('#addition').is(':checked') && $("#detail_pekerjaan :selected").text() == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Tasklist is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
      // end by Ade
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
            url: "<?= base_url("problem_solving/save_problem") ?>",
            dataType: "JSON",
            // cache: false,
            // contentType: false,
            // processData: false,
            // data: form_file,
            data: $("#form_problem").serialize(),
            beforeSend: function(res) {
              $("#btn_save").attr("disabled", true);
            },
            success: function(res) {
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
              $("#modal_add_problem").modal("hide");
              $("#form_problem")[0].reset();
              ct.setSelected("#");
              pt.setSelected("#");
              $("#btn_save").removeAttr("disabled");
              $('#problem').summernote('reset');
              // $('#pembahasan_draft').summernote('code', dt.pembahasan);
              jconfirm.instances[0].close();
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(jqXHR.responseText);
              jconfirm.instances[0].close();
            }
          });
        }
      });
    }
  }

  function list_problem(start, end) {
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
        "url": "<?= base_url('problem_solving/list_problem') ?>",
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
      "columns": [{
          'data': 'id_ps',
          'render': function(data, type, row) {
            res = data;
            if (row['status_id'] < 3) { // 1 : Waiting, 2 : Progress
              res = `<a href="javascript:void(0);" class="badge bg-sm bg-primary" onclick="proses_resume('${data}')">${data}</a>`;
            }
            return res;
          },
          'className': 'text-center'
        },
        // {
        //   'data': 'karyawan',
        //   'render': function(data,type,row){
        //     return `<span>${data}</span><br>
        //     <hr style="margin-top:3px;margin-bottom:3px;">
        //     <p class="mb-0 text-muted small"><i class="bi bi-buildings"></i> ${row['company_name']}</p>
        //     <hr style="margin-top:3px;margin-bottom:3px;">
        //     <p class="mb-0 text-muted small"><i class="bi bi-building-check"></i> ${row['department_name']}</p>
        //     <hr style="margin-top:3px;margin-bottom:3px;">
        //     <p class="mb-0 text-muted small"><i class="bi bi-person-badge"></i> ${row['designation_name']}</p>`;
        //   },
        //   'width':'20%'
        // },
        {
          'data': 'problem'
        },
        {
          'data': 'category'
        },
        {
          'data': 'priority'
        },
        {
          'data': 'deadline'
        },
        {
          'data': 'factor'
        },
        {
          'data': 'pic'
        },
        {
          'data': 'status',
          'render': function(data, type, row) {
            if (row['status_id'] == 1) {
              color = 'bg-warning';
            } else if (row['status_id'] == 2) {
              color = 'bg-info';
            } else if (row['status_id'] == 3) {
              color = 'bg-success';
            } else if (row['status_id'] == 4) {
              color = 'bg-danger';
            } else {
              color = 'bg-secondary';
            }
            return `<span class="badge bg-sm ${color}">${data}</span>`;
          }
        },
        {
          'data': 'resume'
        },
        {
          'data': 'created_by',
          'render': function(data, type, row) {
            return `<span>${data}</span><br>
            <hr style="margin-top:3px;margin-bottom:3px;">
            <p class="mb-0 text-muted small"><i class="bi bi-clock"></i> ${row['created_at']}</p>`;
          },
          'width': '20%'
        }
      ]
    });
  }

  function proses_resume(id) {
    $("#modal_proses_resume").modal("show");
    $("#id_ps").val(id);
    get_detail_problem(id);
  }

  function get_detail_problem(id) {
    $.ajax({
      method: "GET",
      url: "<?= base_url("problem_solving/get_detail_problem/") ?>" + id,
      dataType: "JSON",
      success: function(res) {
        // console.log(res);
        $("#detail_category").text(res.category);
        $("#detail_priority").text(res.priority);
        $("#detail_deadline").text(res.deadline);
        $("#detail_factor").text(res.factor);
        $("#detail_pic").text(res.pic);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
        jconfirm.instances[0].close();
      }
    });
  }

  function save_proses_resume() {
    id_ps = $("#id_ps").val();
    status = $("#status_akhir ").val();
    resume = $("#resume").val();

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
            beforeSend: function(res) {
              $("#btn_save_proses_resume").attr("disabled", true);
            },
            success: function(res) {
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
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(jqXHR.responseText);
              jconfirm.instances[0].close();
            }
          });
        }
      });
    }
  }
</script>