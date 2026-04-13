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
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/nice-select2/css/nice-select2.css" />
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>

<!-- Summer Note css/js -->
<link href="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.css" rel="stylesheet">
<script src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>

<script type="text/javascript">
  // var table_ajax;
  
  $(document).ready(function() {

    list_one('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');
    list_resume('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');
    list_resume_sales('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');

    /*Range*/
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
      $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="start"]').val(start.format('YYYY-MM-DD'));
      $('input[name="end"]').val(end.format('YYYY-MM-DD'));
      list_one(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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

    function cb_resume(start, end) {
      $('.reportrange_resume input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="start_resume"]').val(start.format('YYYY-MM-DD'));
      $('input[name="end_resume"]').val(end.format('YYYY-MM-DD'));
      list_resume(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
    }

    $('.range_resume').daterangepicker({
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
    }, cb_resume);

    cb_resume(start, end);

    function cb_resume_sales(start, end) {
      $('.reportrange_resume_sales input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="start_resume_sales"]').val(start.format('YYYY-MM-DD'));
      $('input[name="end_resume_sales"]').val(end.format('YYYY-MM-DD'));
      list_resume_sales(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
    }

    $('.range_resume_sales').daterangepicker({
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
    }, cb_resume_sales);

    cb_resume_sales(start, end);

    kary = new SlimSelect({
      select: "#karyawan"
    });

    ats = new SlimSelect({
      select: "#atasan"
    });

    $('.tanggal').datetimepicker({
        format: 'Y-m-d',
        timepicker: false,
        minDate: 0,
    });

    let id_project = NiceSelect.bind(document.getElementById('id_project'), {
        searchable: true
    });
  let id_pekerjaan = NiceSelect.bind(document.getElementById('id_pekerjaan'), {
        searchable: true
    });
    let id_sub_pekerjaan = NiceSelect.bind(document.getElementById('id_sub_pekerjaan'), {
        searchable: true
    });
    let id_detail_pekerjaan = NiceSelect.bind(document.getElementById('id_detail_pekerjaan'), {
        searchable: true
    });

    $('#ceklis_pekerjaan').change(function(e) {
        e.preventDefault();
        if ($(this).is(':checked')) {
            $('.row_pekerjaan').show();
        } else {
            $('.row_pekerjaan').hide();
        }
    });

    $('#id_project').change(function(e) {
        e.preventDefault();
        var pekerjaan = $(this).val();
        $.ajax({
            type: "GET",
            url: "<?= base_url('one_on_one/get_pekerjaan'); ?>/" + pekerjaan,
            dataType: "json",
            success: function(response) {
                let list_sub = '<option value="" selected disabled>Pilih SO</option>';
                if (response != null) {
                    response.forEach(item => {
                        list_sub += `<option value="${item.id}">${item.pekerjaan} ${item.periode}</option>`;
                    });
                }
                $("#id_pekerjaan").empty().append(list_sub).prop('disabled', false);
                id_pekerjaan.update();
            }
        });
    });
    $('#id_pekerjaan').change(function(e) {
        e.preventDefault();
        var pekerjaan = $(this).val();
        $.ajax({
            type: "GET",
            url: "<?= base_url('one_on_one/get_sub_pekerjaan'); ?>/" + pekerjaan,
            dataType: "json",
            success: function(response) {
                let list_sub = '<option value="" selected disabled>Pilih SI</option>';
                if (response != null) {
                    response.forEach(item => {
                        list_sub += `<option value="${item.id}">${item.sub_pekerjaan}</option>`;
                    });
                }
                $("#id_sub_pekerjaan").empty().append(list_sub).prop('disabled', false);
                id_sub_pekerjaan.update();
            }
        });
    });
    $('#id_sub_pekerjaan').change(function(e) {
        e.preventDefault();
        var pekerjaan = $(this).val();
        $.ajax({
            type: "GET",
            url: "<?= base_url('one_on_one/get_det_pekerjaan'); ?>/" + pekerjaan,
            dataType: "json",
            success: function(response) {
                let list_sub = '';
                if (response != null) {
                    response.forEach(item => {
                        list_sub += `<option value="${item.id}">${item.detail}</option>`;
                    });
                }
                $("#id_detail_pekerjaan").empty().append(list_sub).prop('disabled', false);
                id_detail_pekerjaan.update();
            }
        });
    });

  });

  function add_coaching() {
    // Auto Get Date Today
    curdate = (new Date()).toISOString().split('T')[0];
    $("#tanggal").val(curdate);

    upper = <?= $_SESSION['user_id'] ?>;

    // Set Otomatis yg input
    ats.setSelected(upper.toString());
    kary.setSelected("-Choose Employee-");

    // $('#review').summernote('code', "Testing IT Review");
    // $('#goals').summernote('code', "Testing IT Goals Auto");

    resetListIndikator();

    $("#modal_add_coaching").modal("show");
  }

  function resetListIndikator() {
    $("#list_indikator").empty().append(`<p>1. Booking | 0/0 &nbsp;<i class="bi bi-plus-square text-success text-end" onclick="add_identifikasi(1)" style="cursor:pointer;"></i></p>
                                        <div class="row" id="list_feedback_1"></div>
                                        <p>2. Database | 0/0 &nbsp;<i class="bi bi-plus-square text-success" onclick="add_identifikasi(2)" style="cursor:pointer;"></i></p>
                                        <div class="row" id="list_feedback_2"></div>
                                        <p>3. FU | 0%/0% &nbsp;<i class="bi bi-plus-square text-success" onclick="add_identifikasi(3)" style="cursor:pointer;"></i></p>
                                        <div class="row" id="list_feedback_3"></div>
                                        <p>4. Ceklok | 0%/0% &nbsp;<i class="bi bi-plus-square text-success" onclick="add_identifikasi(4)" style="cursor:pointer;"></i></p>
                                        <div class="row" id="list_feedback_4"></div>`);
    for (let i = 1; i <= 4; i++) {
      $(`#target_${i}`).val("");
      $(`#actual_${i}`).val("");  
    }
  }

  function change_karyawan() {
    // Change Karyawan to Get Detail Data
    karyawan = $("#karyawan").val().split("|");
    user_id = karyawan[0];
    kode = karyawan[1];
    designation_id = karyawan[2];
    id_user = karyawan[3];

    if ($("#karyawan").val() != "#" && kode == "mkt_rsp") {
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
            url: "<?= base_url("one_on_one/get_indikator_sales") ?>",
            method: "POST",
            data: {
              user_id: user_id,
              id_user: id_user,
              designation_id: designation_id
            },
            dataType: "JSON",
            success: function(res) {
              console.log(`Indikator Sales : ${id_user}`,res);
              data = ``;
              no = 1;
              for (let i = 0; i < res.length; i++) {
                data += `<p>${no}. ${res[i].indikator} | ${res[i].actual}/${res[i].target} &nbsp;<i class="bi bi-plus-square text-success text-end" onclick="add_identifikasi(${no})" style="cursor:pointer;"></i></p>
                          <div class="row" id="list_feedback_${no}"></div>`;
                $(`#target_${no}`).val(res[i].target);
                $(`#actual_${no}`).val(res[i].actual);
                no++;
              }
              $("#list_indikator").empty().append(data);
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
    } else if ($("#karyawan").val() != "#") {
      resetListIndikator();
    }
  }

  function save_one() 
  {
    id_one = $("#id_one_header").val();
    karyawan = $("#karyawan").val();
    atasan = $(`#atasan`).val();
    tempat = $(`#tempat`).val();
    tanggal = $(`#tanggal`).val();
    foto = $(`#foto`).val();

    target_1 = $(`#target_1`).val();
    actual_1 = $(`#actual_1`).val();
    target_2 = $(`#target_2`).val();
    actual_2 = $(`#actual_2`).val();
    target_3 = $(`#target_3`).val();
    actual_3 = $(`#actual_3`).val();
    target_4 = $(`#target_4`).val();
    actual_4 = $(`#actual_4`).val();
    let val_project = $('#id_project').val() ?? "";
        let val_pekerjaan = $('#id_pekerjaan').val() ?? "";
        let val_sub_pekerjaan = $('#id_sub_pekerjaan').val() ?? "";
        let val_detail_pekerjaan = $('#id_detail_pekerjaan').val() ?? "";

    if (karyawan == "#") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Karyawan belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (atasan == "#") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Atasan belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (tempat == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Tempat belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (id_one == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Indikator belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (foto == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Foto belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if ($('#ceklis_pekerjaan').is(':checked') && val_project == "" || $('#ceklis_pekerjaan').is(':checked') && val_pekerjaan == "" || $('#ceklis_pekerjaan').is(':checked') && val_sub_pekerjaan == "" || $('#ceklis_pekerjaan').is(':checked') && val_detail_pekerjaan == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Input Divisi, SO, SI, dan Tasklist harus di pilih!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
    } else {
      // Please waiting      
      let foto = $(`#foto`).prop("files")[0];
      let form_file = new FormData();
      new_karyawan = karyawan.split("|");
      form_file.append("id_one_header", id_one);
      form_file.append("karyawan", new_karyawan[0]);
      form_file.append("atasan", atasan);
      form_file.append("tempat", tempat);
      form_file.append("tanggal", tanggal);
      form_file.append("foto", foto);

      form_file.append("target_1", target_1);
      form_file.append("actual_1", actual_1);
      form_file.append("target_2", target_2);
      form_file.append("actual_2", actual_2);
      form_file.append("target_3", target_3);
      form_file.append("actual_3", actual_3);
      form_file.append("target_4", target_4);
      form_file.append("actual_4", actual_4);
      form_file.append("divisi", val_project);
      form_file.append("so", val_pekerjaan);
      form_file.append("si", val_sub_pekerjaan);
      form_file.append("tasklist", val_detail_pekerjaan);

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
            url: "<?= base_url("one_on_one/save_one") ?>",
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,
            data: form_file,
            beforeSend: function(res) {
              $("#btn_save").attr("disabled", true);
            },
            success: function(res) {
              // console.log(res);
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
              $("#dt_list_coaching").DataTable().ajax.reload();
              $("#modal_add_coaching").modal("hide");
              $("#form_coaching")[0].reset();
              $("#btn_save").removeAttr("disabled");
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

  function list_one(start, end) {
    $('#dt_list_coaching').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List coaching',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('one_on_one/list_one') ?>",
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
          'data': 'id_one',
          // 'render': function(data,type,row){
          //   return `<a href="javascript:void(0);" class="badge bg-sm bg-primary" onclick="detail_one('${data}')">${data}</a>`;
          // },
          // 'className': 'text-center'
        },
        {
          'data': 'karyawan',
          'render': function(data, type, row) {
            return `<span>${data}</span><br>
            <hr style="margin-top:3px;margin-bottom:3px;">
            <p class="mb-0 text-muted small"><i class="bi bi-buildings"></i> ${row['company_name']}</p>
            <hr style="margin-top:3px;margin-bottom:3px;">
            <p class="mb-0 text-muted small"><i class="bi bi-building-check"></i> ${row['department_name']}</p>
            <hr style="margin-top:3px;margin-bottom:3px;">
            <p class="mb-0 text-muted small"><i class="bi bi-person-badge"></i> ${row['designation_name']}</p>`;
          },
          'width': '20%'
        },
        {
          'data': 'tempat'
        },
        {
          'data': 'tanggal'
        },
        {
          'data': 'atasan'
        },
        {
          'data': 'indikator',
          'render': function(data,type,row){
            return `<span>${data}</span>`;
          }
        },
        {
          'data': 'foto',
          'render': function(data, type, row) {
            if (data != "") {
              return `<a href="<?= base_url('uploads/one_on_one/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>`;
            } else {
              return ``;
            }
          }
        },
        {
          'data': 'created_by',
          'render': function(data, type, row) {
            return `<span>${data}</span><br>
            <hr style="margin-top:3px;margin-bottom:3px;">
            <p class="mb-0 text-muted small"><i class="bi bi-clock"></i> ${row['created_at']}</p>`;
          },
          'width': '10%'
        }
      ]
    });
  }

  function add_identifikasi(id)
  {
    if ($("#karyawan").val() != "#" && $(`#target_${id}`).val() != "") {
      $("#modal_add_identifikasi").modal('show');
      id_one = $("#id_one_header").val();
  
      if (id_one != '') {
        $("#id_one_feedback").val(id_one);
      }
  
      $("#indikator_feedback").val(id);
  
      if (id == 1) {
        $("#txt_indikator").text('BOOKING');
        $("#target_indikator").val($("#target_1").val());
        $("#actual_indikator").val($("#actual_1").val());
      } else if (id == 2) {
        $("#txt_indikator").text('DATABASE');
        $("#target_indikator").val($("#target_2").val());
        $("#actual_indikator").val($("#actual_2").val());
      } else if (id == 3) {
        $("#txt_indikator").text('FOLLOW UP');
        $("#target_indikator").val($("#target_3").val());
        $("#actual_indikator").val($("#actual_3").val());
      } else if (id == 4) {
        $("#txt_indikator").text('CEKLOK');
        $("#target_indikator").val($("#target_4").val());
        $("#actual_indikator").val($("#actual_4").val());
      }
      
      for (let i = 0; i < 10; i++) {
        minus_identifikasi();      
      }
    } else {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Karyawan belum terisi atau Karyawan bukan level Staff Sales & Marketing RSP!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    }
  }

  function plus_identifikasi()
  {
    total = parseInt($("#total_feedback").val());
    new_total = total + 1;    
    data = `<div class="col-12 col-lg-12 col-xl-12 mb-4" id="feedback_${new_total}">
              <h6 class="title">${new_total}. Detail Feedback <span class="text-danger" style="font-size: 9pt;">(*Wajib diisi)</span></h6>
              <div class="row">
                  <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                      <div class="form-group mb-3 position-relative check-valid">
                          <div class="input-group input-group-lg">
                              <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-card-text"></i></span>
                              <div class="form-floating">
                                  <input type="text" id="identifikasi_${new_total}" name="identifikasi[]" class="form-control border-start-0" placeholder="Identifikasi">
                                  <label>Identifikasi <i class="text-danger">*</i></label>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                      <div class="form-group mb-3 position-relative check-valid">
                          <div class="input-group input-group-lg">
                              <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-lightbulb"></i></span>
                              <div class="form-floating">
                                  <input type="text" id="solusi_${new_total}" name="solusi[]" class="form-control border-start-0" placeholder="Solusi">
                                  <label>Solusi <i class="text-danger">*</i></label>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                      <div class="form-group mb-3 position-relative check-valid">
                          <div class="input-group input-group-lg">
                              <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-app-indicator"></i></span>
                              <div class="form-floating">
                                  <input type="text" id="target_solusi_${new_total}" name="target_solusi[]" class="form-control border-start-0" placeholder="Target">
                                  <label>Target <i class="text-danger">*</i></label>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                      <div class="form-group mb-3 position-relative check-valid">
                          <div class="input-group input-group-lg">
                              <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-calendar-date"></i></span>
                              <div class="form-floating">
                                  <input type="text" id="deadline_solusi_${new_total}" name="deadline_solusi[]" class="form-control border-start-0 tanggal" placeholder="Deadline">
                                  <label>Deadline <i class="text-danger">*</i></label>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4 mb-2">
                      <div class="form-group mb-3 position-relative check-valid">
                          <div class="input-group input-group-lg">
                              <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-text"></i></span>
                              <div class="form-floating">
                                  <input type="text" id="komitmen_${new_total}" name="komitmen[]" class="form-control border-start-0" placeholder="Komitmen">
                                  <label>Komitmen <i class="text-danger">*</i></label>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>`;
    $("#list_identifikasi").before(data);
    $("#total_feedback").val(new_total);
    if (new_total > 1) {
      $("#btn_minus_identifikasi").show();
    }

    $('.tanggal').datetimepicker({
      format: 'Y-m-d',
      timepicker: false,
      minDate: 0,
    });
  }

  function minus_identifikasi()
  {
    total = parseInt($("#total_feedback").val());
    if (total > 1) {
      $(`#feedback_${total}`).remove();
      new_total = total - 1;
      $("#total_feedback").val(new_total);

      if (new_total < 2) {
        $("#btn_minus_identifikasi").hide();
      }
    }
    
  }
  
  function save_indikator()
  {
    total_feedback = $("#total_feedback").val();
    indikator_feedback = $("#indikator_feedback").val();

    var identifikasi = [];
    var solusi = [];
    var target = [];
    var deadline = [];
    var komitmen = [];

    for (let i = 0; i < total_feedback; i++) 
    {
      no = i+1;
      identifikasi[i] = $(`#identifikasi_${no}`).val();
      solusi[i] = $(`#solusi_${no}`).val();
      target[i] = $(`#target_solusi_${no}`).val();
      deadline[i] = $(`#deadline_solusi_${no}`).val();
      komitmen[i] = $(`#komitmen_${no}`).val();
      
      no = i+1;
      if (identifikasi[i] == "") {
        alert(`Silahkan isi data identifikasi ke-${no}`);
        return false;
      }

      if (solusi[i] == "") {
        alert(`Silahkan isi data solusi ke-${no}`);
        return false;
      }

      if (target[i] == "") {
        alert(`Silahkan isi data target ke-${no}`);
        return false;
      }

      if (deadline[i] == "") {
        alert(`Silahkan isi data deadline ke-${no}`);
        return false;
      }

      if (komitmen[i] == "") {
        alert(`Silahkan isi data komitmen ke-${no}`);
        return false;
      }

      if (no == total_feedback) {
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
              url: "<?= base_url("one_on_one/save_indikator") ?>",
              method: "POST",
              dataType: "JSON",
              data: $("#form_indikator").serialize(),
              beforeSend: function(res) {
                $("#btn_save_indikator").attr("disabled", true);
              },
              success: function(res) {
                // console.log(res);
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
                // $("#dt_list_coaching").DataTable().ajax.reload();
                for (let i = 0; i < 10; i++) {
                  minus_identifikasi();      
                }
                $("#modal_add_identifikasi").modal("hide");
                $("#form_indikator")[0].reset();
                $("#btn_save_indikator").removeAttr("disabled");

                $("#id_one_header").val(res.id_one);
                list_feedback(res.id_one,res.id_indikator);

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
  }

  function list_feedback(id_one,id_indikator)
  {
    $.ajax({
      url: "<?= base_url('one_on_one/get_list_feedback') ?>",
      method: "POST",
      dataType: "JSON",
      data: {
        id_one: id_one,
        id_indikator: id_indikator
      },
      success: function(res) {
        // console.log(res);
        let data = "";
        $.each(res, function(key, val) {
          data += `<div class="col-12 col-md-6 col-lg-4">
                      <ul style="list-style: none; padding-left: 17px;">
                          <li><b>Identifikasi</b> <span>${val.identifikasi}</span></li>
                          <li><b>Solusi</b> <span>${val.solusi}</span></li>
                          <li><b>Target</b> <span>${val.target_solusi}</span></li>
                          <li><b>Deadline</b> <span>${val.deadline_solusi}</span></li>
                          <li><b>Komitmen</b> <span>${val.komitmen}</span></li>
                      </ul>
                  </div>`;
        });
        $(`#list_feedback_${id_indikator}`).empty().append(data);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });
  }

  function cancel_one()
  {
    id_one = $("#id_one_header").val();
    // console.log(id_one);
    if (id_one != "") {
      $.ajax({
        url: "<?= base_url('one_on_one/cancel_one') ?>",
        method: "POST",
        dataType: "JSON",
        data: {
          id_one: id_one
        },
        success: function(res) {
          console.log(res);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
        }
      });      
    }
    
  }

  function list_resume(start, end) {
    $('#dt_list_resume').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List coaching',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('one_on_one/get_resume') ?>",
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
          'data': 'id_one'
        },
        {
          'data': 'karyawan'
        },
        {
          'data': 'tanggal'
        },
        {
          'data': 'indikator',
          'render': function(data, type, row) {
            // 3:FU, 4:Ceklok
            if (row['id_indikator'] == '3' || row['id_indikator'] == '4') {
              return `<span>${data} (${row['actual']}%/${row['target']}%)</span>`;
            } else {
              return `<span>${data} (${row['actual']}/${row['target']})</span>`;
            }
          },
          'width': '50%'
        },
        {
          'data': 'identifikasi'
        },
        {
          'data': 'solusi'
        },
        {
          'data': 'target_solusi'
        },
        {
          'data': 'deadline_solusi'
        },
        {
          'data': 'komitmen'
        },
      ]
    });
  }

  function list_resume_sales(start, end) {
    $('#dt_list_resume_sales').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List coaching',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('one_on_one/get_resume_sales') ?>",
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
          'data': 'sales',
          'render': function(data,type,row){
            return data.replace(/\b\w+\b/g, function(txt) {
              return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
          }
        },
        {
          'data': 'spv'
        },
        {
          'data': 'bm'
        },
        {
          'data': 'booking'
        },
        {
          'data': 'db'
        },
        {
          'data': 'fu'
        },
        {
          'data': 'ceklok'
        },
        {
          'data': 'one'
        },
      ]
    });
  }
</script>