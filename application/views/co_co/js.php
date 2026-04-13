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

    list_coaching('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');
    generate_head_resume_v3(null, null);
    generate_head_resume_m_v3(null, null);
    dt_resume_ketercapaian(null, null);

    /*Range*/
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
      $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="start"]').val(start.format('YYYY-MM-DD'));
      $('input[name="end"]').val(end.format('YYYY-MM-DD'));
      list_coaching(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
      generate_head_resume_v3(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
      generate_head_resume_m_v3(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
      dt_resume_ketercapaian(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));

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

    kary = new SlimSelect({
      select: "#karyawan"
    });
    kary_ai = new SlimSelect({
      select: "#karyawan_ai"
    });

    ats = new SlimSelect({
      select: "#atasan"
    });
    ats_ai = new SlimSelect({
      select: "#atasan_ai"
    });

    // $('#tanggal').datetimepicker({
    //     format: 'Y-m-d',
    //     timepicker: false,
    //     minDate: 0,
    // });

    $('#review').summernote({
      placeholder: '...',
      tabsize: 2,
      height: 150,
      toolbar: [
        ['font', ['bold', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
      ]
    });

    $('#goals').summernote({
      placeholder: '...',
      tabsize: 2,
      height: 150,
      toolbar: [
        ['font', ['bold', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
      ]
    });

    $('#reality').summernote({
      placeholder: '...',
      tabsize: 2,
      height: 150,
      toolbar: [
        ['font', ['bold', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
      ]
    });

    $('#option').summernote({
      placeholder: '...',
      tabsize: 2,
      height: 150,
      toolbar: [
        ['font', ['bold', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
      ]
    });

    $('#will').summernote({
      placeholder: '...',
      tabsize: 2,
      height: 150,
      toolbar: [
        ['font', ['bold', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
      ]
    });

    $('#komitmen').summernote({
      placeholder: '...',
      tabsize: 2,
      height: 150,
      toolbar: [
        ['font', ['bold', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
      ]
    });

    //add pekerjaan by umam
    $('#ceklis_pekerjaan').change(function(e) {
      e.preventDefault();
      if ($(this).is(':checked')) {
        $('.row_pekerjaan').show();
      } else {
        $('.row_pekerjaan').hide();
      }
    });

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

  // $('#id_project').change(function(e) {
  //   e.preventDefault();
  //   var pekerjaan = $(this).val();
  //   $.ajax({
  //     type: "GET",
  //     url: "<?= base_url('co_co_dev/get_pekerjaan'); ?>/" + pekerjaan,
  //     dataType: "json",
  //     success: function(response) {
  //       let list_sub = '<option value="" selected disabled>Pilih Pekerjaan</option>';
  //       if (response != null) {
  //         response.forEach(item => {
  //           list_sub += `<option value="${item.id}">${item.pekerjaan}</option>`;
  //         });
  //       }
  //       $("#id_pekerjaan").empty().append(list_sub).prop('disabled', false);
  //       id_pekerjaan.update();
  //     }
  //   });
  // });

  $('#id_pekerjaan').change(function(e) {
    e.preventDefault();
    var pekerjaan = $(this).val();
    $.ajax({
      type: "GET",
      url: "<?= base_url('co_co_dev/get_sub_pekerjaan'); ?>/" + pekerjaan,
      dataType: "json",
      success: function(response) {
        let list_sub = '<option value="" selected disabled>Pilih Sub Pekerjaan</option>';
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
      url: "<?= base_url('co_co_dev/get_det_pekerjaan'); ?>/" + pekerjaan,
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

    $("#modal_add_coaching").modal("show");
  }

  function add_coaching_ai() {
    // Auto Get Date Today
    curdate = (new Date()).toISOString().split('T')[0];
    $("#tanggal_ai").val(curdate);

    upper = <?= $_SESSION['user_id'] ?>;

    // Set Otomatis yg input
    ats_ai.setSelected(upper.toString());
    kary_ai.setSelected("-Choose Employee-");

    // $('#review').summernote('code', "Testing IT Review");
    // $('#goals').summernote('code', "Testing IT Goals Auto");

    $("#modal_add_coaching_ai").modal("show");
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

  function change_karyawan_ai() {
    // Change Karyawan to Get Detail Data
    karyawan_ai = $("#karyawan_ai").val().split("|");

    if ($("#karyawan_ai").val() != "#" && karyawan_ai[1] == "mkt_rsp") {
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
            url: "<?= base_url("co_co/get_detail_mkt_rsp/") ?>" + karyawan_ai[0],
            method: "GET",
            dataType: "JSON",
            success: function(res) {
              console.log(res);
              text_review = `<b>Pencapaian Target KPI Marketing Berdasarkan usia join ${res.kategori_umur}</b>
<ul><li>Pencapaian Booking : ${res.booking}</li>
<li>Pencapaian Akad : ${res.akad}<br></li></ul>`;

              // $('review_ai').summernote('code', '');
              $('#div_review_ai').html(text_review);
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

  function save_coaching() {
    karyawan = $("#karyawan").val();
    tempat = $(`#tempat`).val();
    tanggal = $(`#tanggal`).val();
    atasan = $(`#atasan`).val();
    review = $(`#review`).val();
    goals = $(`#goals`).val();
    reality = $(`#reality`).val();
    option = $(`#option`).val();
    will = $(`#will`).val();
    komitmen = $(`#komitmen`).val();
    foto = $(`#foto`).val();
    link_video = $(`#link_video`).val();
    if ($('#ceklis_pekerjaan').is(':checked')) {
      val_project = $('#id_project').val()
      val_pekerjaan = $('#id_pekerjaan').val()
      val_sub_pekerjaan = $('#id_sub_pekerjaan').val()
      val_detail_pekerjaan = $('#id_detail_pekerjaan').val()
    } else {
      val_project = ""
      val_pekerjaan = ""
      val_sub_pekerjaan = ""
      val_detail_pekerjaan = ""
    }
    // console.log(val_detail_pekerjaan)
    // console.log(karyawan);



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
    } else if (review == "" || review == '<p><br></p>' || review == '<br>') {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Review belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (goals == "" || goals == '<p><br></p>' || goals == '<br>') {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Goals belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (reality == "" || reality == '<p><br></p>' || reality == '<br>') {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Reality belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (option == "" || option == '<p><br></p>' || option == '<br>') {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Option belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (will == "" || will == '<p><br></p>' || will == '<br>') {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Will belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (komitmen == "" || komitmen == '<p><br></p>' || komitmen == '<br>') {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Komitmen belum terisi!',
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
    } else if (link_video == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Link Video belum terisi!',
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
        content: 'Input Project, Pekerjaan, Sub Pekerjaan, dan Detail harus di pilih!',
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
      form_file.append("karyawan", new_karyawan[0]);
      form_file.append("tempat", tempat);
      form_file.append("tanggal", tanggal);
      form_file.append("atasan", atasan);
      form_file.append("review", review);
      form_file.append("goals", goals);
      form_file.append("reality", reality);
      form_file.append("option", option);
      form_file.append("will", will);
      form_file.append("komitmen", komitmen);
      form_file.append("foto", foto);
      form_file.append("id_project", val_project);
      form_file.append("id_pekerjaan", val_pekerjaan);
      form_file.append("id_sub_pekerjaan", val_sub_pekerjaan);
      form_file.append("id_detail_pekerjaan", val_detail_pekerjaan);
      form_file.append("link_video", link_video);

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
            url: "<?= base_url("co_co/save_coaching") ?>",
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,
            data: form_file,
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
              $("#dt_list_coaching").DataTable().ajax.reload();
              $("#modal_add_coaching").modal("hide");
              $("#form_coaching")[0].reset();
              $("#btn_save").removeAttr("disabled");
              $('#review').summernote('reset');
              $('#goals').summernote('reset');
              $('#reality').summernote('reset');
              $('#option').summernote('reset');
              $('#will').summernote('reset');
              $('#komitmen').summernote('reset');
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

  function save_coaching_ai() {
    karyawan_ai = $("#karyawan_ai").val();
    tempat_ai = $(`#tempat_ai`).val();
    tanggal_ai = $(`#tanggal_ai`).val();
    atasan_ai = $(`#atasan_ai`).val();
    review_ai = $(`#review_ai`).val();

    // if ($('#ceklis_pekerjaan').is(':checked')) {
    //   val_project = $('#id_project').val()
    //   val_pekerjaan = $('#id_pekerjaan').val()
    //   val_sub_pekerjaan = $('#id_sub_pekerjaan').val()
    //   val_detail_pekerjaan = $('#id_detail_pekerjaan').val()
    // } else {
    val_project = ""
    val_pekerjaan = ""
    val_sub_pekerjaan = ""
    val_detail_pekerjaan = ""
    // }
    // console.log(val_detail_pekerjaan)
    // console.log(karyawan);



    if (karyawan_ai == "#") {
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
    } else if (atasan_ai == "#") {
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
    } else if (tempat_ai == "") {
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
    } else if (review_ai == "" || review_ai == '<p><br></p>' || review_ai == '<br>') {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Tema Pembahasan belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else {
      // Please waiting      
      // let foto = $(`#foto`).prop("files")[0];
      let form_file = new FormData();
      new_karyawan = karyawan_ai.split("|");
      form_file.append("karyawan", new_karyawan[0]);
      form_file.append("tempat", tempat_ai);
      form_file.append("tanggal", tanggal_ai);
      form_file.append("atasan", atasan_ai);
      form_file.append("review", review_ai);
      // form_file.append("goals", goals);
      // form_file.append("reality", reality);
      // form_file.append("option", option);
      // form_file.append("will", will);
      // form_file.append("komitmen", komitmen);
      // form_file.append("foto", foto);
      // form_file.append("id_project", val_project);
      // form_file.append("id_pekerjaan", val_pekerjaan);
      // form_file.append("id_sub_pekerjaan", val_sub_pekerjaan);
      // form_file.append("id_detail_pekerjaan", val_detail_pekerjaan);
      // form_file.append("link_video", link_video);

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
            url: "<?= base_url("ai_counseling/save_coaching") ?>",
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,
            data: form_file,
            beforeSend: function(res) {
              $("#btn_save_ai").attr("disabled", true);
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
              $("#dt_list_coaching").DataTable().ajax.reload();
              $("#modal_add_coaching_ai").modal("hide");
              $("#form_coaching_ai")[0].reset();
              $("#btn_save_ai").removeAttr("disabled");
              $('#review_ai').val('');
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

  function list_coaching(start, end) {
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
        "url": "<?= base_url('co_co/list_coaching') ?>",
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
          'data': 'id_coaching',
          'render': function(data, type, row) {
            return `${data}<a class="btn btn-secondary btn-sm" href="<?= base_url('co_co/print/'); ?>${data}" target="_blank"><i class="bi bi-printer"></i></a>`;
          },
          'className': 'text-center'
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
          'data': 'review',
          'render': function(data, type, row) {
            if (row['review_problem'] != '') {
              return `<p>${row['review']}</p> <br> <span class="text-muted small fw-bold">Review Problem :</span><br>${row['review_problem']}`;
            }
            return `${row['review']}`;
          }
        },
        {
          'data': 'goals',
        },
        {
          'data': 'reality'
        },
        {
          'data': 'option'
        },
        {
          'data': 'will'
        },
        {
          'data': 'komitmen'
        },
        {
          'data': 'foto',
          'render': function(data, type, row) {
            if (data != "") {
              return `<a href="<?= base_url('uploads/coaching/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>`;
            } else {
              return ``;
            }
          }
        },
        {
          'data': 'key_takeaways'
        },
        {
          'data': 'main_issue_highlight'
        },
        {
          'data': 'percentage_burnout',
          'render': function(data, type, row) {
            if (row['percentage_burnout'] == null) return '';

            if (row['percentage_burnout'] == '') return '';
            int_burnout = data.replace(/%/g, '') ?? 0;
            return `<p><span class="badge ${int_burnout >= 50 ? 'bg-danger' : 'bg-secondary'}">${row['percentage_burnout']}</span></p><br><span class="text-muted small fw-bold">Reasoning :</span><br>${row['reasoning_burnout']}`;
          }
        },
        {
          'data': 'root_cause_hypothesis'
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


  function generate_head_resume_v3(start, end) {
    // let start = $('#start').val();
    // let end = $('#end').val();

    $.ajax({
      url: '<?= base_url() ?>Co_co/generate_head_resume_v3',
      type: 'POST',
      dataType: 'json',
      data: {
        start: start,
        end: end
      },
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
      thead_th = '';
      // thead = `<tr>
      //             <th>Nama</th>
      //             <th>Company</th>
      //             <th>Jabatan</th>
      //             `;
      // for (let indexa = 0; indexa < response.data.length; indexa++) {
      //     const element = response.data[indexa];
      //     console.log('f_tgl_awal a ' + response.data[indexa].f_tgl_awal);
      console.log('f_tgl_awal b ' + response.data[0].f_tgl_awal);
      console.log('length b ' + response.data.length);
      totalminggu = response.data.length;
      // thead += `<th class="small text-center">${response.data[indexa].week_number} <br><span class="small">${response.data[indexa].f_tgl_awal}</span> s/d <span class="small">${response.data[indexa].f_tgl_akhir}</span></th>`;
      if (response.data.length == 6) {
        thead_th = `<th  class="small text-center">W1 <br><span class="small">${response.data[0].f_tgl_awal}</span> s/d <span class="small">${response.data[0].f_tgl_akhir}</span></th>
                  <th class="small text-center">W2 <br><span class="small">${response.data[1].f_tgl_awal}</span> s/d <span class="small">${response.data[1].f_tgl_akhir}</span></th>
                  <th class="small text-center">W3 <br><span class="small">${response.data[2].f_tgl_awal}</span> s/d <span class="small">${response.data[2].f_tgl_akhir}</span></th>
                  <th class="small text-center">W4 <br><span class="small">${response.data[3].f_tgl_awal}</span> s/d <span class="small">${response.data[3].f_tgl_akhir}</span></th>
                  <th class="small text-center">W5 <br><span class="small">${response.data[4].f_tgl_awal}</span> s/d <span class="small">${response.data[4].f_tgl_akhir}</span></th>
                  <th id="thead_th6" class="small text-center">W6 <br><span class="small">${response.data[5].f_tgl_awal}</span> s/d <span class="small">${response.data[5].f_tgl_akhir}</span></th>
                  `
        console.log('666');

      } else if (response.data.length == 5) {
        thead_th = `<th class="small text-center">W1 <br><span class="small">${response.data[0].f_tgl_awal}</span> s/d <span class="small">${response.data[0].f_tgl_akhir}</span></th>
                  <th class="small text-center">W2 <br><span class="small">${response.data[1].f_tgl_awal}</span> s/d <span class="small">${response.data[1].f_tgl_akhir}</span></th>
                  <th class="small text-center">W3 <br><span class="small">${response.data[2].f_tgl_awal}</span> s/d <span class="small">${response.data[2].f_tgl_akhir}</span></th>
                  <th class="small text-center">W4 <br><span class="small">${response.data[3].f_tgl_awal}</span> s/d <span class="small">${response.data[3].f_tgl_akhir}</span></th>
                  <th id="thead_th5" class="small text-center">W5 <br><span class="small">${response.data[4].f_tgl_awal}</span> s/d <span class="small">${response.data[4].f_tgl_akhir}</span></th>
                  `
        console.log('555');

      } else if (response.data.length == 4) {
        thead_th = `<th class="small text-center">W1 <br><span class="small">${response.data[0].f_tgl_awal}</span> s/d <span class="small">${response.data[0].f_tgl_akhir}</span></th>
                  <th class="small text-center">W2 <br><span class="small">${response.data[1].f_tgl_awal}</span> s/d <span class="small">${response.data[1].f_tgl_akhir}</span></th>
                  <th class="small text-center">W3 <br><span class="small">${response.data[2].f_tgl_awal}</span> s/d <span class="small">${response.data[2].f_tgl_akhir}</span></th>
                  <th class="small text-center">W4 <br><span class="small">${response.data[3].f_tgl_awal}</span> s/d <span class="small">${response.data[3].f_tgl_akhir}</span></th>
                  `
      }


      // }
      // if(totalminggu == 6){
      //   console.log('totalminggu 6');
      // } else if(totalminggu == 5){
      //   console.log('totalminggu 5');
      //   // $("#thead_th6").remove();
      //   document.getElementById("thead_th6").remove();
      // }
      thead = `<tr>
                      <th>Nama</th>
                      <th>Company</th>
                      <th>Jabatan</th>
                      ${thead_th}
                      `;
      thead += `</tr>`;

      tbody = '';
      for (let index = 0; index < response.body_resume.length; index++) {
        // console.log('length ' + response.data.length);
        // console.log('index b ' + index);

        tbody_td = '';
        if (response.data.length == 6) {
          tbody_td = `<td>${response.body_resume[index].w1 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w2 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w3 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w4 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w5 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w6 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          `
        } else if (response.data.length == 5) {
          tbody_td = `<td>${response.body_resume[index].w1 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w2 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
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
      $('#dt_resume_head_3').empty();
      $('#dt_resume_head_3').append(thead);

      $('#dt_resume_body_3').empty().append(tbody);
      // setTimeout(() => {
      //     $('#dt_resume_pembelajar_3').DataTable({
      //         "searching": true,
      //         "info": true,
      //         "paging": true,
      //         "destroy": true,
      //         "autoWidth": false,
      //         "dom": 'Bfrtip',
      //         buttons: [{
      //             extend: 'excelHtml5',
      //             text: 'Export to Excel',
      //             footer: true
      //         }],
      //     });
      // }, 10000);
    }).fail(function(jqXhr, textStatus) {

    });
  }

  function generate_head_resume_m_v3(start, end) {
    $('#dt_resume_pembelajar_m_3').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List coaching monthly',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('co_co/generate_body_resume_m_v3') ?>",
        "dataType": 'JSON',
        "type": "POST",
        "data": {
          start: start,
          end: end
        },
      },
      "columns": [{
          'data': 'employee_name',
          'render': function(data, type, row) {
            return data
          },
          'width': '20%'
        },
        {
          'data': 'company_name'
        },
        {
          'data': 'jabatan'
        },
        {
          'data': 'w1',
          'render': function(data, type, row) {
            if (data > 0) {
              return `<span class="text-primary">Unlocked</span><br>`;
            } else {
              return `<span class="text-danger">Locked</span><br>`;

            }

          },
        },
      ]
    });
  }

  function dt_resume_ketercapaian(start, end) {
    $.ajax({
      url: '<?= base_url() ?>Briefing/resume_ketercapaian',
      type: 'POST',
      dataType: 'json',
      data: {
        start: start,
        end: end
      },
      beforeSend: function() {

      },
      success: function(response) {

      },
      error: function(xhr) { // if error occured

      },
      complete: function() {

      },
    }).done(function(response) {
      thead = '';
      thead_th = '';
      totalminggu = response.data.length;

      if (response.data.length == 6) {
        thead_th = `<th  class="small text-center">W1 <br><span class="small">${response.data[0].f_tgl_awal}</span> s/d <span class="small">${response.data[0].f_tgl_akhir}</span></th>
                  <th class="small text-center">W2 <br><span class="small">${response.data[1].f_tgl_awal}</span> s/d <span class="small">${response.data[1].f_tgl_akhir}</span></th>
                  <th class="small text-center">W3 <br><span class="small">${response.data[2].f_tgl_awal}</span> s/d <span class="small">${response.data[2].f_tgl_akhir}</span></th>
                  <th class="small text-center">W4 <br><span class="small">${response.data[3].f_tgl_awal}</span> s/d <span class="small">${response.data[3].f_tgl_akhir}</span></th>
                  <th class="small text-center">W5 <br><span class="small">${response.data[4].f_tgl_awal}</span> s/d <span class="small">${response.data[4].f_tgl_akhir}</span></th>
                  <th id="thead_th6" class="small text-center">W6 <br><span class="small">${response.data[5].f_tgl_awal}</span> s/d <span class="small">${response.data[5].f_tgl_akhir}</span></th>
                  `
        // console.log('666');

      } else if (response.data.length == 5) {
        thead_th = `<th class="small text-center">W1 <br><span class="small">${response.data[0].f_tgl_awal}</span> s/d <span class="small">${response.data[0].f_tgl_akhir}</span></th>
                  <th class="small text-center">W2 <br><span class="small">${response.data[1].f_tgl_awal}</span> s/d <span class="small">${response.data[1].f_tgl_akhir}</span></th>
                  <th class="small text-center">W3 <br><span class="small">${response.data[2].f_tgl_awal}</span> s/d <span class="small">${response.data[2].f_tgl_akhir}</span></th>
                  <th class="small text-center">W4 <br><span class="small">${response.data[3].f_tgl_awal}</span> s/d <span class="small">${response.data[3].f_tgl_akhir}</span></th>
                  <th id="thead_th5" class="small text-center">W5 <br><span class="small">${response.data[4].f_tgl_awal}</span> s/d <span class="small">${response.data[4].f_tgl_akhir}</span></th>
                  `
        // console.log('555');

      } else if (response.data.length == 4) {
        thead_th = `<th class="small text-center">W1 <br><span class="small">${response.data[0].f_tgl_awal}</span> s/d <span class="small">${response.data[0].f_tgl_akhir}</span></th>
                  <th class="small text-center">W2 <br><span class="small">${response.data[1].f_tgl_awal}</span> s/d <span class="small">${response.data[1].f_tgl_akhir}</span></th>
                  <th class="small text-center">W3 <br><span class="small">${response.data[2].f_tgl_awal}</span> s/d <span class="small">${response.data[2].f_tgl_akhir}</span></th>
                  <th class="small text-center">W4 <br><span class="small">${response.data[3].f_tgl_awal}</span> s/d <span class="small">${response.data[3].f_tgl_akhir}</span></th>
                  `
      }

      thead = `<tr>
                      <th>Nama</th>
                      <th>Department</th>
                      <th>Jabatan</th>
                      ${thead_th}
                      `;
      thead += `</tr>`;

      tbody = '';
      for (let index = 0; index < response.body_resume.length; index++) {

        tbody_td = '';
        if (response.data.length == 6) {
          tbody_td = `<td>${response.body_resume[index].w1 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'} (${response.body_resume[index].input_w1})</td>
                          <td>${response.body_resume[index].w2 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'} (${response.body_resume[index].input_w2})</td>
                          <td>${response.body_resume[index].w3 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'} (${response.body_resume[index].input_w3})</td>
                          <td>${response.body_resume[index].w4 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}(${response.body_resume[index].input_w4})</td>
                          <td>${response.body_resume[index].w5 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'} (${response.body_resume[index].input_w5})</td>
                          <td>${response.body_resume[index].w6 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'} (${response.body_resume[index].input_w6})</td>
                          `
        } else if (response.data.length == 5) {
          tbody_td = `<td>${response.body_resume[index].w1 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'} (${response.body_resume[index].input_w1})</td>
                          <td>${response.body_resume[index].w2 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'} (${response.body_resume[index].input_w2})</td>
                          <td>${response.body_resume[index].w3 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'} (${response.body_resume[index].input_w3})</td>
                          <td>${response.body_resume[index].w4 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}(${response.body_resume[index].input_w4})</td>
                          <td>${response.body_resume[index].w5 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'} (${response.body_resume[index].input_w5})</td>
                          `
        } else if (response.data.length == 4) {
          tbody_td = `<td>${response.body_resume[index].w1 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'} (${response.body_resume[index].input_w1})</td>
                          <td>${response.body_resume[index].w2 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'} (${response.body_resume[index].input_w2})</td>
                          <td>${response.body_resume[index].w3 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'} (${response.body_resume[index].input_w3})</td>
                          <td>${response.body_resume[index].w4 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}(${response.body_resume[index].input_w4})</td>
                          `
        }
        tbody += `<tr>
                          <td>${response.body_resume[index].employee_name}</td>
                          <td>${response.body_resume[index].department_name}</td>
                          <td>${response.body_resume[index].jabatan}</td>
                          ${tbody_td}
                      </tr>`
      }

      $('#dt_resume_ketercapaian').empty().append(
        `<thead id="dt_resume_ketercapaian_head"></thead>
              <tbody id="dt_resume_ketercapaian_body"></tbody>`
      );
      $('#dt_resume_ketercapaian_head').empty();
      $('#dt_resume_ketercapaian_head').append(thead);

      $('#dt_resume_ketercapaian_body').empty().append(tbody);
    }).fail(function(jqXhr, textStatus) {

    });
  }
</script>