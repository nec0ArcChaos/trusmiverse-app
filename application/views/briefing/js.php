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

<!-- Fomantic Or Semantic Ui -->
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/dropdown.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/transition.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/form.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/popup.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/toast.js"></script>
<!-- Exif -->
<script src="https://cdn.jsdelivr.net/npm/exif-js"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>


<script type="text/javascript">
  // $('#review').summernote({
  //   placeholder: 'Review Kemarin',
  //   tabsize: 2,
  //   height: 120,
  //   toolbar: [
  //     ['font', ['bold', 'underline', 'clear']],
  //     ['para', ['ul', 'ol', 'paragraph']],
  //   ],
  //   callbacks: {
  //     onPaste: function(e) {
  //       var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
  //       e.preventDefault();
  //       document.execCommand('insertText', false, bufferText);
  //     },
  //     onImageUpload: function(data) {
  //       data.pop();
  //       $.toast({
  //         class: 'warning',
  //         title: 'Alert',
  //         message: 'Tidak Boleh Paste Image'
  //       });
  //     }
  //   }
  // });


  // var table_ajax;
  // project = new SlimSelect({
  //   select: "#project"
  // });

  // $('#detail_pekerjaan').dropdown_se();
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

    list_briefing('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');
    // dt_lock_brif_d_v1(null, null);
    dt_lock_brif_w_v1(null, null);
    dt_resume_ketercapaian(null, null);

    /*Range*/
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
      $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="start"]').val(start.format('YYYY-MM-DD'));
      $('input[name="end"]').val(end.format('YYYY-MM-DD'));
      list_briefing(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
      // dt_lock_brif_d_v1(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
      dt_lock_brif_w_v1(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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

    $('#peserta').dropdown_se();
    get_peserta();



    function cb_detail(start, end) {
      $('.reportrange_detail input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="start_detail"]').val(start.format('YYYY-MM-DD'));
      $('input[name="end_detail"]').val(end.format('YYYY-MM-DD'));
      detail_briefing(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
    }

    $('.range_detail').daterangepicker({
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
    }, cb_detail);

    cb_detail(start, end);

  });

  function save_briefing_old() {
    review = $(`#review`).val();
    plan = $(`#plan`).val();
    informasi = $(`#informasi`).val();
    motivasi = $(`#motivasi`).val();
    peserta = $(`#peserta`).val();
    sanksi = $(`#sanksi`).val();

    if (peserta.length == 0) {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Peserta belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });

    } else if ($("#review").val() == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Review Kemarin belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if ($("#plan").val() == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Plan hari ini belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if ($("#informasi").val() == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Informasi atau SOP belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if ($("#motivasi").val() == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Motivasi belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if ($("#foto").val() == "") {
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
    } else {
      // Please waiting      
      let foto = $(`#foto`).prop("files")[0];
      let form_file = new FormData();
      form_file.append("review", review);
      form_file.append("plan", plan);
      form_file.append("informasi", informasi);
      form_file.append("motivasi", motivasi);
      form_file.append("foto", foto);
      form_file.append("peserta", peserta);
      form_file.append("sanksi", sanksi);

      swal({
          title: "Kamu yakin?",
          text: "Simpan form  Briefing!",
          icon: "info",
          buttons: true,
        })
        .then((next) => {
          if (next) {
            $.ajax({
              method: "POST",
              url: "<?= base_url("briefing/save_briefing") ?>",
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
                  content: 'Briefing has been saved!',
                  buttons: {
                    close: {
                      actions: function() {}
                    },
                  },
                });
                $("#dt_list_briefing").DataTable().ajax.reload();
                $("#modal_add_briefing").modal("hide");
                $("#form_briefing")[0].reset();
                $("#btn_save").removeAttr("disabled");
                $('#peserta').dropdown_se("clear");
                // jconfirm.instances[0].close();
              },
              error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
                // jconfirm.instances[0].close();
              }
            });

          }
        });

      // $.confirm({
      //   icon: 'fa fa-spinner fa-spin',
      //   title: 'Please wait!',
      //   theme: 'material',
      //   type: 'blue',
      //   content: 'Processing...',
      //   buttons: {
      //       close: {
      //           isHidden: true,
      //           actions: function() {}
      //       },
      //   },
      //   onOpen: function() {

      //   }
      // });
    }
  }

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
      url: '<?= base_url('briefing/get_pekerjaan') ?>',
      type: 'POST',
      dataType: 'json',
      data: {
        id_project
      },
      beforeSend: function() {
        $('#pekerjaan').empty().prop('disabled', true);
      },
    }).done(function(response) {
      $('#pekerjaan').prop('disabled', false)
      list_pekerjaan = '<option value="#" disabled selected>-- Pilih SO --</option>';
      if (response != null) {
        for (let index = 0; index < response.length; index++) {
          list_pekerjaan +=
            `<option value="${response[index].id}" >${response[index].pekerjaan} ${response[index].periode}</option>`;
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
      url: '<?= base_url('briefing/get_sub_pekerjaan') ?>',
      type: 'POST',
      dataType: 'json',
      data: {
        id_pekerjaan
      },
      beforeSend: function() {
        $('#sub_pekerjaan').empty().prop('disabled', true);
      },
    }).done(function(response) {
      $('#sub_pekerjaan').prop('disabled', false)
      list_sub_pekerjaan = '<option value="#" disabled selected>Pilih SI</option>';
      if (response != null) {
        for (let index = 0; index < response.length; index++) {
          list_sub_pekerjaan +=
            `<option value="${response[index].id}" >${response[index].sub_pekerjaan}</option>`;
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
      url: '<?= base_url('briefing/get_det_pekerjaan') ?>',
      type: 'POST',
      dataType: 'json',
      data: {
        id_sub_pekerjaan
      },
      beforeSend: function() {
        $('#detail_pekerjaan').empty().prop('disabled', true);
      },
    }).done(function(response) {
      $('#detail_pekerjaan').prop('disabled', false)
      list_detail_pekerjaan = '';
      if (response != null) {
        for (let index = 0; index < response.length; index++) {
          list_detail_pekerjaan +=
            `<option value="${response[index].id}" >${response[index].detail}</option>`;
        }
      }
      $("#detail_pekerjaan").empty().append(list_detail_pekerjaan).prop('disabled', false);
      id_detail_pekerjaan.update();
    }).fail(function(jqXhr, textStatus) {
      console.log("Failed Get Detail Pekerjaan")
    });
  });

  function save_briefing() {
    review = $(`#review`).val();
    plan = $(`#plan`).val();
    informasi = $(`#informasi`).val();
    motivasi = $(`#motivasi`).val();
    peserta = $(`#peserta`).val();
    sanksi = $(`#sanksi`).val();

    if ($('#addition').is(':checked') && $("#project :selected").val() == "#") {
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
    } else if (peserta.length == 0) {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Peserta belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });

    } else if ($("#review").val() == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Review Kemarin belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if ($("#plan").val() == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Plan hari ini belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if ($("#informasi").val() == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Informasi atau SOP belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if ($("#motivasi").val() == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Motivasi belum terisi!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if ($("#foto").val() == "") {
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
    } else {
      // Please waiting      
      let foto = $(`#foto`).prop("files")[0];
      let form_file = new FormData();
      form_file.append("review", review);
      form_file.append("plan", plan);
      form_file.append("informasi", informasi);
      form_file.append("motivasi", motivasi);
      form_file.append("foto", foto);
      form_file.append("peserta", peserta);
      form_file.append("sanksi", sanksi);

      let id_user = document.querySelectorAll('input[name="id_user[]"]');
      if (id_user.length > 0) {
        // Tambahkan setiap nilai review ke FormData
        id_user.forEach(input => {
          form_file.append('id_user[]', input.value);
        });
      }
      let id_hr = document.querySelectorAll('input[name="id_hr[]"]');
      if (id_hr.length > 0) {
        id_hr.forEach(input => {
          form_file.append('id_hr[]', input.value);
        });
      }
      let target_db = document.querySelectorAll('input[name="target_db[]"]');
      if (target_db.length > 0) {
        target_db.forEach(input => {
          form_file.append('target_db[]', input.value);
        });
      }

      // Cek apakah checkbox "addition" dalam keadaan checked
      let additionCheckbox = document.querySelector('input[name="addition"]');
      if (additionCheckbox && additionCheckbox.checked) {
        // Ambil nilai dari inputan di dalam div_addition
        let addition = document.querySelector('input[name="addition"]').value;
        let idProject = document.querySelector('select[name="id_project"]').value;
        let idPekerjaan = document.querySelector('select[name="id_pekerjaan"]').value;
        let idSubPekerjaan = document.querySelector('select[name="id_sub_pekerjaan"]').value;
        let idDetailPekerjaan = document.querySelectorAll('select[name="id_detail_pekerjaan[]"] option:checked');

        // Tambahkan nilai-nilai tersebut ke FormData
        form_file.append('addition', addition);
        form_file.append('id_project', idProject);
        form_file.append('id_pekerjaan', idPekerjaan);
        form_file.append('id_sub_pekerjaan', idSubPekerjaan);

        idDetailPekerjaan.forEach(option => {
          form_file.append('id_detail_pekerjaan[]', option.value);
        });
      }

      swal({
          title: "Kamu yakin?",
          text: "Simpan form  Briefing!",
          icon: "info",
          buttons: true,
        })
        .then((next) => {
          if (next) {
            $.ajax({
              method: "POST",
              url: "<?= base_url("briefing/save_briefing") ?>",
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
                  content: 'Briefing has been saved!',
                  buttons: {
                    close: {
                      actions: function() {}
                    },
                  },
                });
                $("#dt_list_briefing").DataTable().ajax.reload();
                $("#modal_add_briefing").modal("hide");
                $("#form_briefing")[0].reset();
                $("#btn_save").removeAttr("disabled");
                $('#peserta').dropdown_se("clear");
                // jconfirm.instances[0].close();
              },
              error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
                // jconfirm.instances[0].close();
              }
            });

          }
        });

      // $.confirm({
      //   icon: 'fa fa-spinner fa-spin',
      //   title: 'Please wait!',
      //   theme: 'material',
      //   type: 'blue',
      //   content: 'Processing...',
      //   buttons: {
      //       close: {
      //           isHidden: true,
      //           actions: function() {}
      //       },
      //   },
      //   onOpen: function() {

      //   }
      // });
    }
  }

  function list_briefing(start, end) {
    $('#dt_list_briefing').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List Briefing',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('briefing/list_briefing') ?>",
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
          'data': 'id_briefing',
          // 'render': function(data,type,row){
          //   return `<a href="javascript:void(0);" class="badge bg-sm bg-primary" onclick="result_gemba('${data}')">${data}</a>`;
          // },
          // 'className': 'text-center'
        },
        {
          'data': 'review'
        },
        {
          'data': 'plan'
        },
        {
          'data': 'informasi'
        },
        {
          'data': 'motivasi'
        },
        {
          'data': 'peserta',
          render: function(data, type, row, meta) {
            return data
          }
        },
        {
          'data': 'sanksi'
        },
        {
          'data': 'foto',
          'render': function(data, type, row) {
            if (data != "") {
              return `<a href="<?= base_url('uploads/briefing/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>`;
            } else {
              return ``;
            }
          }
        },
        {
          'data': 'id_briefing',
          'render': function(data, type, row) {
            if (row['feedback_bm_at'] == '') {
              return `<a href="javascript:void(0);" class="badge bg-sm bg-warning" onclick="feedback_bm('${data}')">Waiting</a>`;
            } else {
              return `<span href="javascript:void(0);" class="badge bg-sm bg-success">Done</span>
              <br>
              <span class="small text-secondary"><i class="bi bi-person-check">&nbsp;</i> ${row['feedback_bm_by']}</span>
              <br>
              <span class="small text-secondary"><i class="bi bi-clock-history">&nbsp;</i>${row['feedback_bm_at']}</span>`;
            }
          }
        },
        {
          'data': 'review_bm',
        },
        {
          'data': 'keputusan_bm',
        },
        {
          'data': 'feedback',
          render: function(data, type, row, meta) {
            if (data == '') {
              id_briefing = row['id_briefing'];
              return `<textarea class="form-control feedback" name="feedback" id="feedback_${id_briefing}" cols="2" rows="1" placeholder="input feedback"></textarea> 
                      &nbsp; <button type="button" class="btn btn-sm btn-theme" onclick="simpan_feedback('${id_briefing}')">Simpan</button>
                      <input type="hidden" id="no_user_${id_briefing}" value="${row['no_user']}">`
            } else {
              return data
            }
          }
        },
        {
          'data': 'created_by',
        },
        {
          'data': 'company_name'
        },
        {
          'data': 'department_name'
        },
        {
          'data': 'designation_name'
        },
        {
          'data': 'created_at'
        },
      ]
    });
  }

  function dt_lock_brif_d_v1(start, end) {
    $('#tbl_lock_brif_d_3').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List briefing daily',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('briefing/dt_lock_brif_d_v1') ?>",
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
          'data': 'total_lock',
          'render': function(data, type, row) {
            if (data > 0) {
              return `<span class="text-primary">` + data + `</span><br>`;
            } else {
              return `<span class="text-danger">` + data + `</span><br>`;

            }

          },
        },
        {
          'data': 'lock_t',
          'render': function(data, type, row) {
            // console.info(data);
            if (parseInt(data) > 0) {
              return `<span class="text-danger">Locked</span><br>`;
            } else {
              return `<span class="text-primary">Unlock</span><br>`;

            }

          },
        },
      ]
    });
  }

  function dt_lock_brif_w_v1(start, end) {
    $.ajax({
      url: '<?= base_url() ?>Briefing/generate_head_resume_v3',
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
      // console.log('f_tgl_awal b ' + response.data[0].f_tgl_awal);
      // console.log('length b ' + response.data.length);
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
      // $('#dt_resume_pembelajar_3').DataTable({
      //     "searching": true,
      //     "info": true,
      //     "paging": true,
      //     "destroy": true,
      //     "autoWidth": false,
      //     "dom": 'Bfrtip',                 
      //     buttons: [{
      //       extend: 'excelHtml5',
      //       title: 'Data List briefing weekly',
      //       text: '<i class="bi bi-download text-white"></i>',
      //       footer: true
      //     }],
      // });
      // }, 10000);
    }).fail(function(jqXhr, textStatus) {

    });
  }

  function get_peserta() {
    $.getJSON("<?= base_url('briefing/get_peserta') ?>", function(result) {
      list_peserta = ``;
      $.each(result, function(i, field) {
        list_peserta += `<option value="${field.user_id}">${field.employee_name}</option>`
      });
      $('#peserta').html(list_peserta);
    });
  }

  function simpan_feedback(id_briefing) {
    feedback = $(`#feedback_${id_briefing}`).val();
    no_user = $(`#no_user_${id_briefing}`).val();

    if (feedback == '') {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Feedback belum terisi!',
        buttons: {
          close: {
            actions: function() {
              $(`#feedback_${id_briefing}`).focus();
            }
          },
        },
      });
    } else {
      swal({
          title: "Kamu yakin?",
          text: "Simpan form  Briefing!",
          icon: "info",
          buttons: true,
        })
        .then((next) => {
          if (next) {
            $.ajax({
              method: "POST",
              url: "<?= base_url("briefing/simpan_feedback") ?>",
              dataType: "JSON",
              data: {
                id_briefing: id_briefing,
                feedback: feedback,
                no_user: no_user,
              },
              success: function(res) {
                console.log(res);
                $.confirm({
                  icon: 'fa fa-check',
                  title: 'Success',
                  theme: 'material',
                  type: 'green',
                  content: 'Feedback Tersimpan!',
                  buttons: {
                    close: {
                      actions: function() {}
                    },
                  },
                });
                $("#dt_list_briefing").DataTable().ajax.reload();
                // jconfirm.instances[0].close();
              },
              error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
                // jconfirm.instances[0].close();
              }
            });

          }
        });
    }
  }

  function feedback_bm(id_briefing) {
    $("#id_briefing_bm").val(id_briefing);
    $('#modal_feedback_bm').modal('show');
  }

  function simpan_feedback_bm() {
    id_briefing = $('#id_briefing_bm').val();
    review = $('#review_bm').val();
    keputusan = $('#keputusan_bm').val();

    if (review == '') {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Review belum terisi!',
        buttons: {
          close: {
            actions: function() {
              $(`#review_bm`).focus();
            }
          },
        },
      });
    } else if (keputusan == '') {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Keputusan belum terisi!',
        buttons: {
          close: {
            actions: function() {
              $(`#keputusan_bm`).focus();
            }
          },
        },
      });
    } else {
      swal({
          title: "Kamu yakin?",
          text: "Simpan Form Feedback BM!",
          icon: "info",
          buttons: true,
        })
        .then((next) => {
          if (next) {
            $.ajax({
              method: "POST",
              url: "<?= base_url("briefing/simpan_feedback_bm") ?>",
              dataType: "JSON",
              data: {
                id_briefing: id_briefing,
                review: review,
                keputusan: keputusan
              },
              beforeSend: function() {
                $("#btn_simpan_feedback_bm").attr("disabled", true);
              },
              success: function(res) {
                console.log(res);
                $.confirm({
                  icon: 'fa fa-check',
                  title: 'Success',
                  theme: 'material',
                  type: 'green',
                  content: 'Feedback BM Tersimpan!',
                  buttons: {
                    close: {
                      actions: function() {}
                    },
                  },
                });
                $("#dt_list_briefing").DataTable().ajax.reload();
                $("#btn_simpan_feedback_bm").removeAttr("disabled");
                $('#modal_feedback_bm').modal('hide');
                // jconfirm.instances[0].close();
              },
              error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
                // jconfirm.instances[0].close();
              }
            });

          }
        });
    }
  }

  async function modal_add_briefing() {
    try {
      $('#div_sales_preview').removeClass('d-none');
      $('#sales_preview').empty().append('<div class="d-flex align-items-center justify-content-center"><div class="loader"></div></div>').removeClass('d-none');

      const response = await $.ajax({
        url: '<?= base_url() ?>Briefing/get_sales_by_id_atasan',
        type: 'POST',
        dataType: 'json',
        data: {}
      });

      $('#modal_add_briefing').modal('show');
      if (response.sales.length > 0) {
        let idSalesSet = new Set(
          response.sales
          .filter(item => item.clock_in !== "") // Filter only those with non-empty clock_in
          .map(item => item.id_hr_sales)
        );

        $('#peserta option').each(function() {
          if (idSalesSet.has($(this).val())) {
            $(this).prop('selected', true);
            $('#peserta').dropdown_se('set selected', $(this).val());
          }
        });

        let yesterday = new Date(Date.now() - 864e5);
        let monthName = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        let tgl_bln = `${yesterday.getDate()} ${monthName[yesterday.getMonth()]}`;
        let html = `<table class="small table table-hover text-nowrap" style="width:100%">`;

        let map = response.sales_preview[0].latitude && response.sales_preview[0].latitude !== 'null' && response.sales_preview[0].latitude !== 'undefined' ?
          `<a href="https://www.google.com/maps/place/${response.sales_preview[0].latitude},${response.sales_preview[0].longitude}" target="_blank"><i class="ti-location-pin text-primary"></i></a>` : '';

        html += `
                <thead>
                    <tr>
                        <th style="padding:0" colspan="12" class="text-start">Data Akumulasi Pencapaian Sales</th>
                    </tr>
                    <tr>
                        <th style="padding:0" colspan="12" class="text-start">Note : <i class="bi bi-check-circle avatar avatar-20 bg-light-green text-green rounded-circle"></i> Sudah Absen, <i class="bi bi-x-circle avatar avatar-20 bg-light-red text-red rounded-circle"></i> Belum Absen, <i class="bi bi-fire avatar avatar-20 text-blue rounded-circle"></i> Jumlah Api = Jumlah Booking</th>
                    </tr>
                    <tr>
                        <th style="padding:0" colspan="12" class="text-start">Lokasi : ${map}</th>
                    </tr>
                    <tr>
                        <th style="padding:0" rowspan="2">No.</th>
                        <th style="padding:0" rowspan="2">Absensi</th>
                        <th style="padding:0" rowspan="2">Sales</th>
                        <th style="padding:0" class="text-center">Plan Hari Ini</th>
                        <th style="padding:0" rowspan="2" class="text-center">DB</th>
                        <th style="padding:0" colspan="2" class="text-center">Follow Up</th>
                        <th style="padding:0" rowspan="2" class="text-center">Ceklok</th>
                        <th style="padding:0" rowspan="2" class="text-center">Booking</th>
                        <th style="padding:0" rowspan="2" class="text-center">Tgl Kemarin</th>
                    </tr>
                    <tr>
                        <th style="padding:0" class="text-center">Input Target DB</th>
                        <th style="padding:0" class="text-center">Ke-1</th>
                        <th style="padding:0" class="text-center">Ke-2</th>
                    </tr>
                </thead>`;
        let no = 1;
        response.sales_preview.forEach(sales => {
          let persen_badge = parseInt(sales.persen_aktual) >= 75 ? `<span class="badge bg-success">${sales.persen_aktual}%</span>` :
            parseInt(sales.persen_aktual) < 75 && parseInt(sales.persen_aktual) >= 50 ? `<span class="badge bg-warning">${sales.persen_aktual}%</span>` :
            `<span class="badge bg-danger">${sales.persen_aktual}%</span>`;

          let absen_badge = sales.clock_in ? `<i class="bi bi-check-circle avatar avatar-20 bg-light-green text-green rounded-circle"></i>` :
            `<i class="bi bi-x-circle avatar avatar-20 bg-light-red text-red rounded-circle"></i>`;
          let sales_name = sales.clock_in ? `${sales.sales}` : `<s>${sales.sales}</s>`;

          let booking_badge = sales.booking > 0 ? Array(sales.booking).fill('<i class="bi bi-fire text-blue"></i>').join('') : sales.booking;

          html += `<tbody>
                    <tr>
                        <td class="text-center">${no++}.</td>
                        <td class="text-center">${absen_badge}</td>
                        <td>${sales_name}</td>
                        <td class="text-center d-flex justify-content-center">
                            <input type="hidden" name="id_user[]" style="max-width: 80px" class="border form-control form-control-sm text-center" value="${sales.id_sales}">
                            <input type="hidden" name="id_hr[]" style="max-width: 80px" class="border form-control form-control-sm text-center" value="${sales.id_hr_sales}">
                            <input type="number" name="target_db[]" style="max-width: 80px" class="border form-control form-control-sm text-center" value="${sales.target_db_today}">
                        </td>
                        <td class="text-center">${sales.db}</td>
                        <td class="text-center">${sales.fu1}</td>
                        <td class="text-center">${sales.fu2}</td>
                        <td class="text-center">${sales.ceklok}</td>
                        <td class="text-center">${booking_badge}</td>
                        <td class="text-center">${sales.db_aktual}/${sales.target_db} ${persen_badge}</td>
                    </tr>
                </tbody>`;
        });
        html += `</table>`;
        $('#btn_show_sop').removeClass('d-none');
        $('#btn_show_memo').removeClass('d-none');
        $('#div_sales_preview').removeClass('d-none');
        $('#sales_preview').empty().append(html).removeClass('d-none');
      } else {
        $('#btn_show_sop').addClass('d-none');
        $('#btn_show_memo').addClass('d-none');
        $('#div_sales_preview').addClass('d-none');
        $('#sales_preview').empty().append(``).addClass('d-none');
      }
    } catch (error) {
      console.error("Error:", error);
    }
  }

  function detail_briefing(start, end) {
    $.ajax({
      url: '<?= base_url() ?>Briefing/get_sales_by_id_atasan_resume',
      type: 'POST',
      dataType: 'json',
      data: {
        start: start,
        end: end
      },
      beforeSend: function() {
        $('#div_detail_briefing').removeClass('d-none');
        $('#detail_briefing').empty().append('<div class="d-flex align-items-center justify-content-center"><div class="loader"></div></div>').removeClass('d-none');
      },
      success: function(response) {

      },
      error: function(xhr) { // if error occured

      },
      complete: function() {

      },
    }).done(function(response) {
      if (response.sales.length > 0) {

        if (response.sales_preview.length > 0) {
          $('#div_detail_briefing').removeClass('d-none');
        } else {
          $('#div_detail_briefing').addClass('d-none');
        }

        // Buat set dari id_hr_sales untuk pencarian cepat
        let idSalesSet = new Set(
          response.sales
          .filter(item => item.clock_in !== "") // Filter hanya yang clock_in tidak kosong
          .map(item => item.id_hr_sales)
        );

        // Iterasi langsung dan pilih elemen yang sesuai
        $('#peserta option').each(function() {
          if (idSalesSet.has($(this).val())) {
            $(this).prop('selected', true);
            $('#peserta').dropdown_se('set selected', $(this).val());
          }
        });
        let yesterday = new Date(Date.now() - 864e5);
        let monthName = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        let tgl_bln = `${yesterday.getDate()} ${monthName[yesterday.getMonth()]}`;
        let html = `<table id="dt_detail_briefing" class="small table table-hover text-nowrap" style="width:100%">`;

        html += `
                  <thead>
                    <tr>
                      <th class="text-center">No.</th>
                      <th class="text-center">Tgl Briefing</th>
                      <th class="text-center">Absensi</th>
                      <th class="text-center">Hadir</th>
                      <th class="text-start">Sales</th>
                      <th class="text-center">DB</th>
                      <th class="text-center">FU 1</th>
                      <th class="text-center">FU 2</th>
                      <th class="text-center">Ceklok</th>
                      <th class="text-center">Booking</th>
                      <th class="text-center">Act/Target</th>
                    </tr>
                  </thead>`;
        no = 1;
        response.sales_preview.forEach(sales => {
          if (parseInt(sales.persen_aktual) >= 75) {
            persen_badge = `<span class="badge bg-success">${sales.persen_aktual}%</span>`
          } else if (parseInt(sales.persen_aktual) < 75 && parseInt(sales.persen_aktual) >= 50) {
            persen_badge = `<span class="badge bg-warning">${sales.persen_aktual}%</span>`
          } else {
            persen_badge = `<span class="badge bg-danger">${sales.persen_aktual}%</span>`
          }
          if (sales.clock_in != '') {
            absen_badge = `<i class="bi bi-check-circle avatar avatar-20 bg-light-green text-green rounded-circle"></i>`
          } else {
            absen_badge = `<i class="bi bi-x-circle avatar avatar-20 bg-light-red text-red rounded-circle"></i>`
          }
          if (sales.clock_in != '' || sales.hadir == 1) {
            sales_name = `${sales.sales}`
          } else {
            sales_name = `<s>${sales.sales}</s>`
          }
          if (sales.hadir == 1) {
            hadir_badge = `<i class="bi bi-check-circle avatar avatar-20 bg-light-green text-green rounded-circle"></i>`
          } else {
            hadir_badge = `<i class="bi bi-x-circle avatar avatar-20 bg-light-red text-red rounded-circle"></i>`
          }

          if (sales.booking > 0) {
            booking_badge = '';
            for (let index = 0; index < sales.booking; index++) {
              booking_badge += `<i class="bi bi-fire text-blue"></i>`
            }
          } else {
            booking_badge = sales.booking;
          }

          html += `<tbody>
                    <tr>
                      <td class="text-center">${no++}.</td>
                      <td class="text-center">${sales.tgl_briefing}</td>
                      <td class="text-center">${absen_badge}</td>
                      <td class="text-center">${hadir_badge}</td>
                      <td>${sales_name}</td>
                      <td class="text-center">${sales.db}</td>
                      <td class="text-center">${sales.fu1}</td>
                      <td class="text-center">${sales.fu2}</td>
                      <td class="text-center">${sales.ceklok}</td>
                      <td class="text-center">${booking_badge}</td>
                      <td class="text-center">${sales.db_aktual}/${sales.target_db} ${persen_badge}</td>
                    </tr>
                  </tbody>`;
        });
        html += `</table>`;
        $('#div_detail_briefing').removeClass('d-none');
        $('#detail_briefing').empty().append(html).removeClass('d-none');
        $('#dt_detail_briefing').DataTable({
          "lengthChange": true,
          scrollCollapse: true,
          scrollY: '50vh',
          "searching": true,
          "info": true,
          "paging": false,
          "autoWidth": true,
          "destroy": true,
          dom: 'Bfrtip',
          buttons: [{
            extend: 'excelHtml5',
            title: 'Data List briefing daily',
            text: '<i class="bi bi-download text-white"></i>',
            footer: true
          }],
        });
      } else {
        $('#div_detail_briefing').addClass('d-none');
        $('#detail_briefing').empty().append(``).addClass('d-none');
      }

    }).fail(function(jqXhr, textStatus) {

    });
  }

  function modal_list_memo() {
    $('#modal_list_memo').modal('show');
    $('#dt_list_memo').DataTable({
      'lengthChange': false,
      'searching': true,
      'destroy': true,
      "info": true,
      "paging": true,
      "order": [
        [7, "desc"]
      ],
      "autoWidth": false,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        text: 'Export to Excel',
        footer: true
      }],
      "ajax": {
        "dataType": 'json',
        "type": "POST",
        "url": "<?= site_url('briefing/dt_list_memo') ?>",
      },
      "columns": [{
          "data": "id_memo",
          "render": function(data, type, row, meta) {
            var dateCreated = new Date(row['created_at']);
            var now = new Date();
            var diffTime = Math.abs(now - dateCreated);
            var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            if (diffDays <= 30) {
              return `<label class = 'badge bg-success'>${data}</label> <span class="badge bg-red"><i class="bi bi-fire"></i> New</span>`;
            } else {
              return `<label class = 'badge bg-success'>${data}</label>`;
            }
          },
          "className": "text-start"
        },
        {
          "data": "status_memo",
          "render": function(data, type, row, meta) {
            if (data == 0 || data == null) {
              status = "<label class = 'badge bg-warning'>Waiting</label>";
            } else if (data == 1) {
              status = "<label class = 'badge bg-primary'>Approve</label>";
            } else if (data == 2) {
              status = "<label class = 'badge bg-danger'>Reject</label>";
            }
            return status;
          },
          "className": "text-center"
        },
        {
          "data": 'tipe_memo',
          "className": 'text-center'
        },
        {
          "data": 'note'
        },
        {
          "data": 'files_memo',
          "render": function(data, type, row, meta) {
            return `<a href="<?= base_url("assets/uploads/files_memo/") ?>${data}" target="_blank" title="File BA"><i class="ti-printer text-primary"></i></a>`
          },
          "className": 'text-center'
        },
        {
          "data": 'divisi',
          "className": 'text-center'
        },
        {
          "data": 'jabatan',
          "render": function(data, type, row, meta) {
            return data.replace(/,/g, ' ');
          },
          "className": 'text-start'
        },
        {
          "data": 'created_at',
          "className": 'text-center text-nowrap'
        },
        {
          "data": 'created_by',
          "className": 'text-start'
        },
        {
          "data": 'updated_by',
          "className": 'text-start'
        },
        {
          "data": 'note_update',
          "className": 'text-start'
        }
      ],
    });
  }

  function modal_list_sop() {
    $('#modal_list_sop').modal('show');
    $('#dt_list_sop').DataTable({
      'destroy': true,
      'lengthChange': false,
      'searching': true,
      'info': false,
      'responsive': true,
      'paging': true,
      "autoWidth": true,
      "ajax": {
        "dataType": 'json',
        "type": "POST",
        "url": "<?= site_url('briefing/dt_list_sop') ?>",
      },
      "columns": [{
        "data": "jenis_doc",
        "render": function(data, type, row) {
          if (data == 'Instruksi Kerja') {
            return `<span class="badge bg-primary">${data}</span>`
          } else if (data == 'Standar') {
            return `<span class="badge bg-warning">${data}</span>`
          } else if (data == 'SOP') {
            return `<span class="badge bg-success">${data}</span>`
          } else if (data == 'Form') {
            return `<span class="badge bg-info">${data}</span>`
          } else if (data == 'Memo') {
            return `<span class="badge bg-danger">${data}</span>`
          } else if (data == 'Job Profile') {
            return `<span class="badge" style="background-color:#03B486;color:white;">${data}</span>`
          } else {
            return `<span class="badge" style="background-color:#292929;color:white;">${data}</span>`
          }
        },
        "className": "text-center"
      }, {
        "data": "nama_dokumen"
      }, {
        "data": "department_name"
      }, {
        "data": "designation_name"
      }, {
        "data": "no_doc"
      }, {
        "data": "tgl_terbit"
      }, {
        "data": "file",
        "render": function(data, type, row, meta) {
          if (data) {
            return `<a href="javascript:void(0)" onclick="dtl('${row['file']}')"><span class="btn btn-outline-primary btn-sm">Lihat</span></a>`
          } else {
            return `<a href="javascript:void(0)" onclick="dtr('${row.no_jp}')"><span class="btn btn-outline-primary btn-sm">Lihat</span></a>`
          }
        },
        "className": "text-center"
      }, ],
      initComplete: function(setting, json) {

      },
    });
  }

  /* Storing user's device details in a variable*/
  let details = navigator.userAgent;
  /* Creating a regular expression 
  containing some mobile devices keywords 
  to search it in details string*/
  let regexp = /android|iphone|kindle|ipad/i;
  /* Using test() method to search regexp in details
  it returns boolean value*/
  let isMobileDevice = regexp.test(details);

  function dtl(file) {
    src = "https://drive.google.com/viewerng/viewer?embedded=true&url=https://www.trusmicorp.com/od/assets/files/" + file;

    if (isMobileDevice) {
      embed = '<p style="padding:10px;margin-top:50px !important;">Mohon Maaf untuk sementara File ini tidak bisa dilihat melalui HP, silahkan gunakan Dekstop</p>'
    } else {
      embed = '<embed  type="application/pdf" id="file" style="width: 100%; height: 640px" src="https://www.trusmicorp.com/od/assets/files/' + file + '"></embed><div style="width: 200px; height: 80px; position: absolute; opacity: 0; right: 5px; top: 0px; background-color: blue;"></div>'
    }
    $('#file').attr('src', src);
    $("#embed").append(embed);
    $('#modal_pdf').modal('show');
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