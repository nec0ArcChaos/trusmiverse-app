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
<script type="text/javascript"
  src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript"
  src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>

<!-- Datetimepicker Full -->
<script type="text/javascript"
  src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<!-- Jquery Confirm -->
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>

<!-- Fomantic Or Semantic Ui -->
<script type="text/javascript" src="https://trusmiverse.com/apps/assets/semantic/components/dropdown.js"></script>
<script type="text/javascript" src="https://trusmiverse.com/apps/assets/semantic/components/form.js"></script>
<script type="text/javascript" src="https://trusmiverse.com/apps/assets/semantic/components/transition.js"></script>
<script type="text/javascript" src="https://trusmiverse.com/apps/assets/semantic/components/popup.js"></script>
<script type="text/javascript" src="https://trusmiverse.com/apps/assets/semantic/components/toast.js"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>

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
    dokumen = new SlimSelect({
      select: "#dokumen"
    });
    employee = new SlimSelect({
      select: ".employee"
    });

    $('#tgl_plan').datetimepicker({
      format: 'Y-m-d',
      timepicker: false,
      minDate: 0,
    });

  });

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
  // addnew by Ade
  // console.log($('#addition').is(':checked'));
  $('#addition').change(function() {
    if ($(this).is(':checked')) {
      console.log('Checkbox dicentang!');
      $('.div_addition').show();
    } else {
      console.log('Checkbox tidak dicentang!');
      $('.div_addition').hide();
    }
  });

  $('#project').on('change', function() {
    id_project = $(this).val();

    $.ajax({
      url: '<?= base_url('gemba/get_pekerjaan_by_project') ?>',
      type: 'POST',
      dataType: 'json',
      data: {
        id_project: id_project
      },
      beforeSend: function() {
        $('#pekerjaan').empty().append(
            '<option value=""><i class="fa fa-spinner fa-spin"></i> Loading..</option>')
          .prop('disabled', true);
      },
    }).done(function(response) {
      $('#pekerjaan').prop('disabled', false)
      list_pekerjaan = '<option value="#" disabled selected>Pilih SO</option>';
      if (response != null) {
        for (let index = 0; index < response.length; index++) {
          list_pekerjaan +=
            `<option value="${response[index].id}" data-id_pekerjaan="${response[index].id}">${response[index].pekerjaan} ${response[index].periode}</option>`;
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
      url: '<?= base_url('gemba/get_sub_pekerjaan_by_pekerjaan') ?>',
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
            `<option value="${response[index].id}" data-id_sub_pekerjaan="${response[index].id}">${response[index].sub_pekerjaan}</option>`;
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
      url: '<?= base_url('gemba/get_detail_pekerjaan_by_sub_pekerjaan') ?>',
      type: 'POST',
      dataType: 'json',
      data: {
        id_sub_pekerjaan: id_sub_pekerjaan
      },
      beforeSend: function() {
        $('#detail_pekerjaan').empty().append(
            '<option value=""><i class="fa fa-spinner fa-spin"></i> Loading..</option>')
          .prop('disabled', true);
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


  $('#tipe_gemba').change(function(e) {
    e.preventDefault();
    var department_id = $(this).find(':selected').data('department_id');
    if (department_id == null) {
      return;
    }
    $.ajax({
      url: '<?= base_url('gemba/get_dokumen'); ?>', // Endpoint yang Anda minta
      type: 'POST', // Metode POST
      data: {
        department_id: department_id
      },
      dataType: 'json', // Mengharapkan balasan berupa JSON

      beforeSend: function() {
        dokumen.disable();
        dokumen.setData([{
          text: 'Loading...',
          value: ''
        }]);
      },
      success: function(response) {
        var placeholder = [{
          text: '-- Pilih Dokumen --',
          value: '',
          placeholder: true
        }];
        var newData;

        if (response && response.length > 0) {
          newData = $.map(response, function(item) {
            return {
              text: item.nama_dokumen + ' | ' + item.no_doc, // Label yang tampil
              value: item.no_doc // Value dari option
            };
          });
          newData = placeholder.concat(newData);

        } else {
          // Jika tidak ada data
          newData = [{
              text: '-- Pilih Dokumen --',
              value: '',
              placeholder: true
            },
            {
              text: 'Dokumen tidak ditemukan',
              value: '',
              disabled: true
            }
          ];
        }
        dokumen.setData(newData);
        dokumen.enable();
      },
      error: function(xhr, status, error) {
        // Opsi: Tampilkan error jika AJAX gagal
        console.error("AJAX Error:", status, error);
        dokumen.setData([{
          text: 'Gagal memuat data',
          value: ''
        }]);
        // Biarkan disabled
      }
    });

  });


  function save_gemba() {
    // addnew by Ade
    if ($('#addition').is(':checked') && $("#project :selected").val() == "#") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Project is empty!',
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
        content: 'Pekerjaan is empty!',
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
        content: 'Sub Pekerjaan is empty!',
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
        content: 'Detail Pekerjaan is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
      // end by Ade
    } else if ($("#tgl_plan").val() == "") {
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
            beforeSend: function(res) {
              $("#btn_save").attr("disabled", true);
            },
            success: function(res) {
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
                $("#dt_list_gemba").DataTable().ajax.reload();

                proses_gemba(res.id_gemba);
              }
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

  function list_proses() {
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
      "columns": [{
          'data': 'id_gemba',
          'render': function(data, type, row) {
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

  function list_verifikasi() {
    $("#modal_list_verifikasi").modal("show");
    $('#dt_list_verifikasi').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List Verifikasi Perbaikan Gemba',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('gemba/list_verifikasi') ?>",
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
      "columns": [{
          data: 'id_gemba',
          render: function(data, type, row) {
            return `
            <a href="javascript:void(0);" 
              class="badge bg-sm bg-info"
              onclick="verifikasi_gemba('${data}')">
              ${data}
            </a>
          `;
          },
          className: 'text-center'
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

  function list_perbaikan() {
    $("#modal_list_perbaikan").modal("show");
    $('#dt_list_perbaikan').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List Perbaikan Gemba',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('gemba/list_perbaikan') ?>",
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
      "columns": [{
          data: 'id_gemba',
          render: function(data, type, row) {
            return `
            <a href="javascript:void(0);" 
              class="badge bg-sm bg-info"
              onclick="perbaikan_gemba('${data}')">
              ${data}
            </a>
          `;
          },
          className: 'text-center'
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

  function list_deadline() {
    $("#modal_list_deadline").modal("show");
    $('#dt_list_deadline').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List Deadline Gemba',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('gemba/list_deadline') ?>",
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
      "columns": [{
          data: 'id_gemba',
          render: function(data, type, row) {
            return `
            <a href="javascript:void(0);" 
              class="badge bg-sm bg-info"
              onclick="deadline_gemba('${data}')">
              ${data}
            </a>
          `;
          },
          className: 'text-center'
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

  function verifikasi_gemba(id_gemba) {
    $.ajax({
      type: "POST",
      url: "<?= base_url('gemba/detail_verifikasi') ?>",
      data: {
        id_gemba: id_gemba
      },
      dataType: "json",
      success: function(res) {
        if (res.status === true) {
          let html = '';

          res.data.forEach((item, index) => {

            // ===== Evidence =====
            // ===== Evidence =====
            let evidenceHtml = '';
            if (item.file && item.file !== '-' && item.file !== '') {
              evidenceHtml = `
    <a href="https://trusmiverse.com/apps/uploads/gemba/${item.file}"
       data-fancybox="evidence_${item.id_gemba}_${item.id_gemba_ceklis}"
       data-caption="Evidence Gemba"
       class="text-primary">
      <i class="fa fa-image fa-lg"></i> Evidence
    </a>
  `;
            }


            // ===== Link Perbaikan =====
            let linkHtml = '';
            if (item.link && item.link !== '-' && item.link !== '') {
              linkHtml = `
      <a href="${item.link}"
         target="_blank"
         class="btn btn-sm btn-outline-info">
        Link
      </a>
    `;
            }

            html += `
    <div class="col-xl-4 col-lg-6 col-md-12">
      <div class="card h-100 shadow-sm">

        <div class="card-header gemba-card-header">
          <span class="badge bg-primary me-2">Item ${index + 1}</span>
          <strong>${item.ceklis}</strong>
        </div>

        <div class="card-body">
          <input type="hidden" name="id_gemba[]" value="${item.id_gemba}">
          <input type="hidden" name="id_gemba_ceklis[]" value="${item.id_gemba_ceklis}">

          <div class="mb-2">
            <label class="small text-muted">Lokasi Temuan</label>
            <input type="text" class="form-control form-control-sm" value="${item.lokasi_temuan}" readonly>
          </div>

          <div class="mb-2">
            <label class="small text-muted">Ekspektasi</label>
            <textarea class="form-control form-control-sm" rows="2" readonly>${item.ekspetasi}</textarea>
          </div>

          <div class="mb-3">
            <label class="small text-muted">Deadline</label>
            <input type="date" class="form-control form-control-sm" value="${item.deadline}" readonly>
          </div>

          ${(evidenceHtml || linkHtml) ? `
          <div class="d-flex justify-content-between align-items-center mb-2">
            ${evidenceHtml}
            ${linkHtml}
          </div>
          ` : ''}

          <div class="mb-3">
            <label class="small text-muted">Note</label>
            <textarea class="form-control form-control-sm" rows="2" readonly>${item.note ?? '-'}</textarea>
          </div>

          <hr class="my-2">

          <div class="mb-2">
            <label class="small fw-semibold">Status Verifikasi</label>
            <select
              name="status_${item.id_gemba}_${item.id_gemba_ceklis}"
              class="form-control form-control-sm border border-secondary-subtle status-select">
              <option value="">-- pilih --</option>
              <option value="oke">Oke</option>
              <option value="tidak oke">Tidak Oke</option>
            </select>
          </div>

          <div class="alasan-deadline-container"
               id="container_${item.id_gemba}_${item.id_gemba_ceklis}"
               style="display:none;">
            <div class="mb-2">
              <label class="small">Alasan Tidak Sesuai</label>
              <textarea
                name="alasan_verifikasi_${item.id_gemba}_${item.id_gemba_ceklis}"
                class="form-control form-control-sm border border-secondary-subtle"
                rows="2"></textarea>
            </div>

          </div>

          <div class="d-grid mt-auto">
            <button
              type="button"
              class="btn btn-primary btn-sm mt-3"
              onclick="btnSimpanVerifikasiItem('${item.id_gemba}', '${item.id_gemba_ceklis}')">
              <i class="fa fa-save me-1"></i> Simpan Verifikasi
            </button>
          </div>

        </div>
      </div>
    </div>
  `;
          });


          $('#listVerifikasiContainer').html(html);
          $('#modalVerifikasiGemba').modal('show');

          // Tambahkan event listener untuk select status
          $('.status-select').on('change', function() {
            let selectVal = $(this).val();
            let containerId = $(this).attr('name').replace('status', 'container');
            if (selectVal === 'tidak oke') {
              $('#' + containerId).show();
            } else {
              $('#' + containerId).hide();
            }
          });

        } else {
          swal('Oops!', res.message, 'warning');
        }
      }
    });
  }


  function btnSimpanVerifikasiItem(id_gemba, id_gemba_ceklis) {

    const key = id_gemba + '_' + id_gemba_ceklis;

    const status = $(`[name="status_${key}"]`).val();
    const alasan = $(`[name="alasan_verifikasi_${key}"]`).val();
    const deadline = $(`[name="deadline_baru_${key}"]`).val();

    if (!status) {
      swal('Oops!', 'Status verifikasi wajib dipilih', 'warning');
      return;
    }

    if (
      status === 'tidak oke' &&
      (alasan.trim() === '' || deadline === '')
    ) {
      swal(
        'Oops!',
        'Alasan dan deadline wajib diisi jika status Tidak Oke',
        'warning'
      );
      return;
    }


    $.ajax({
      type: "POST",
      url: "<?= base_url('gemba/simpan_verifikasi_item') ?>",
      data: {
        id_gemba: id_gemba,
        id_gemba_ceklis: id_gemba_ceklis,
        status: status,
        alasan: alasan,
        deadline_baru: deadline
      },
      dataType: "json",
      success: function(res) {
        if (res.status === true) {
          $('#modalVerifikasiGemba').modal('hide');
          $('#modal_list_verifikasi').modal('hide');
          swal('Berhasil!', res.message, 'success');
        } else {
          swal('Oops!', res.message, 'warning');
        }
      },
      error: function() {
        swal('Error!', 'Gagal menyimpan verifikasi', 'error');
      }
    });
  }



  $('#btnSimpanVerifikasi').click(function() {

    let formData = new FormData($('#formVerifikasiGemba')[0]);

    $.ajax({
      type: "POST",
      url: "<?= base_url('gemba/simpan_verifikasi') ?>",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function(res) {
        if (res.status === true) {
          swal('Berhasil!', res.message, 'success');
          $('#modalVerifikasiGemba').modal('hide');
        } else {
          swal('Oops!', res.message, 'warning');
        }
      },
      error: function() {
        swal('Error!', 'Gagal menyimpan data', 'error');
      }
    });
  });

  function deadline_gemba(id_gemba) {
    $.ajax({
      type: "POST",
      url: "<?= base_url('gemba/detail_deadline') ?>",
      data: {
        id_gemba: id_gemba
      },
      dataType: "json",
      success: function(res) {
        if (res.status === true) {

          let html = '';

          res.data.forEach((item, index) => {

  const key = item.id_gemba + '_' + item.id_gemba_ceklis;

  // 🔥 SECTION STATUS VERIFIKASI (opsional)
  let verifikasiHtml = '';

  if (item.status_verifikasi) {
    verifikasiHtml = `
      <div class="mb-2">
        <label class="small text-muted">Status Verifikasi</label>
        <input
          type="text"
          class="form-control form-control-sm"
          value="${item.status_verifikasi}"
          readonly
        >
      </div>

      <div class="mb-2">
        <label class="small text-muted">Alasan Verifikasi</label>
        <textarea
          class="form-control form-control-sm"
          rows="2"
          readonly
        >${item.alasan_verifikasi ?? '-'}</textarea>
      </div>

      <div class="mb-2">
        <label class="small text-muted">Deadline Lama</label>
        <input
          type="text"
          class="form-control form-control-sm"
          value="${item.deadline_lama}"
          readonly
        >
      </div>

      <hr>
    `;
  }

  html += `
    <div class="col-xl-4 col-lg-6 col-md-12">
      <div class="card gemba-card h-100">

        <div class="card-header gemba-card-header">
          <span class="badge bg-primary me-2">Item ${index + 1}</span>
          <strong>${item.ceklis}</strong>
        </div>

        <div class="card-body d-flex flex-column">

          <input type="hidden" id="id_gemba_${key}" value="${item.id_gemba}">
          <input type="hidden" id="id_gemba_ceklis_${key}" value="${item.id_gemba_ceklis}">

          <div class="mb-2">
            <label class="small text-muted">Lokasi Temuan</label>
            <input type="text" class="form-control form-control-sm" value="${item.lokasi_temuan}" readonly>
          </div>

          <div class="mb-2">
            <label class="small text-muted">Ekspektasi</label>
            <textarea class="form-control form-control-sm" rows="2" readonly>${item.ekspetasi}</textarea>
          </div>

          <hr>

          ${verifikasiHtml}

          <!-- 🔥 DEADLINE SELALU MUNCUL -->
          <div class="mb-3">
          <label class="small fw-semibold">Deadline Baru</label>
          <input
            type="date"
            id="deadline_${key}"
            min="<?php echo date('Y-m-d'); ?>"
            class="form-control form-control-sm border border-secondary-subtle bg-light"
          >
        </div>


          <div class="d-grid mt-auto">
            <button
              type="button"
              class="btn btn-primary btn-sm"
              onclick="btnSimpanDeadline('${item.id_gemba}', '${item.id_gemba_ceklis}')"
            >
              <i class="fa fa-save me-1"></i> Simpan Perbaikan
            </button>
          </div>

        </div>
      </div>
    </div>
  `;

          });

          $('#listDeadlineContainer').html(html);
          $('#modalDeadlineGemba').modal('show');

        } else {
          swal('Oops!', res.message, 'warning');
        }
      }
    });
  }


  function perbaikan_gemba(id_gemba) {
    $.ajax({
      type: "POST",
      url: "<?= base_url('gemba/detail_perbaikan') ?>",
      data: {
        id_gemba: id_gemba
      },
      dataType: "json",
      success: function(res) {
        if (res.status === true) {

          let html = '';

          res.data.forEach((item, index) => {

  const key = item.id_gemba + '_' + item.id_gemba_ceklis;

  // 🔥 SECTION VERIFIKASI (HANYA JIKA TIDAK OKE)
  let verifikasiHtml = '';

  if (item.status_verifikasi === 'tidak oke') {
    verifikasiHtml = `
      <div class="mb-2">
        <label class="small text-muted">Status Verifikasi</label>
        <input
          type="text"
          class="form-control form-control-sm text-danger fw-semibold"
          value="Tidak Oke"
          readonly
        >
      </div>

      <div class="mb-3">
        <label class="small text-muted">Alasan Verifikasi</label>
        <textarea
          class="form-control form-control-sm"
          rows="2"
          readonly
        >${item.alasan_verifikasi ?? '-'}</textarea>
      </div>

      <hr>
    `;
  }

  html += `
    <div class="col-xl-4 col-lg-6 col-md-12">
      <div class="card gemba-card h-100">

        <div class="card-header gemba-card-header">
          <span class="badge bg-primary me-2">Item ${index + 1}</span>
          <strong>${item.ceklis}</strong>
        </div>

        <div class="card-body d-flex flex-column">

          <input type="hidden" id="id_gemba_${key}" value="${item.id_gemba}">
          <input type="hidden" id="id_gemba_ceklis_${key}" value="${item.id_gemba_ceklis}">

          <div class="mb-2">
            <label class="small text-muted">Lokasi Temuan</label>
            <input type="text" class="form-control form-control-sm" value="${item.lokasi_temuan}" readonly>
          </div>

          <div class="mb-2">
            <label class="small text-muted">Ekspektasi</label>
            <textarea class="form-control form-control-sm" rows="2" readonly>${item.ekspetasi}</textarea>
          </div>

          <div class="mb-3">
            <label class="small text-muted">Deadline</label>
            <input type="date" class="form-control form-control-sm" value="${item.deadline}" readonly>
          </div>

          <hr>

          ${verifikasiHtml}

          <div class="mb-2">
            <label class="small fw-semibold">Evidence</label>
            <input type="file" id="evidence_${key}" class="form-control form-control-sm">
          </div>

          <div class="mb-2">
            <label class="small fw-semibold">Link</label>
            <input
              type="url"
              id="link_${key}"
              class="form-control form-control-sm border border-secondary-subtle bg-light">
          </div>

          <div class="mb-3">
            <label class="small fw-semibold">Note</label>
            <textarea
              id="note_${key}"
              class="form-control form-control-sm border border-secondary-subtle bg-light"
              rows="2"></textarea>
          </div>

          <div class="d-grid mt-auto">
            <button
              type="button"
              class="btn btn-primary btn-sm"
              onclick="btnSimpanPerbaikanItem('${item.id_gemba}', '${item.id_gemba_ceklis}')">
              <i class="fa fa-save me-1"></i> Simpan Perbaikan
            </button>
          </div>

        </div>
      </div>
    </div>
  `;

          });

          $('#listPerbaikanContainer').html(html);
          $('#modalPerbaikanGemba').modal('show');

        } else {
          swal('Oops!', res.message, 'warning');
        }
      }
    });
  }

  function btnSimpanPerbaikanItem(id_gemba, id_gemba_ceklis) {

    const key = id_gemba + '_' + id_gemba_ceklis;

    const file = $(`#evidence_${key}`)[0].files[0];
    const link = $(`#link_${key}`).val();
    const note = $(`#note_${key}`).val();

    if (!file && !link) {
      swal('Oops!', 'Evidence atau link wajib diisi', 'warning');
      return;
    }

    if (note.trim() === '') {
      swal('Oops!', 'Note wajib diisi', 'warning');
      return;
    }

    let formData = new FormData();
    formData.append('id_gemba', id_gemba);
    formData.append('id_gemba_ceklis', id_gemba_ceklis);
    formData.append('note', note);
    formData.append('link', link);

    if (file) {
      formData.append('evidence', file);
    }

    $.ajax({
      type: "POST",
      url: "<?= base_url('gemba/simpan_perbaikan_item') ?>",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function(res) {
        if (res.status === true) {
          $('#modalPerbaikanGemba').modal('hide');
          $('#modal_list_perbaikan').modal('hide');
          swal('Berhasil!', res.message, 'success');
        } else {
          swal('Oops!', res.message, 'warning');
        }
      },
      error: function() {
        swal('Error!', 'Gagal menyimpan perbaikan', 'error');
      }
    });
  }

  function btnSimpanDeadline(id_gemba, id_gemba_ceklis) {

    const key = id_gemba + '_' + id_gemba_ceklis;

    const deadline = $(`#deadline_${key}`).val();

    if (deadline.trim() === '') {
      swal('Oops!', 'Deadline wajib diisi', 'warning');
      return;
    }

    let formData = new FormData();
    formData.append('id_gemba', id_gemba);
    formData.append('id_gemba_ceklis', id_gemba_ceklis);
    formData.append('deadline', deadline);

    $.ajax({
      type: "POST",
      url: "<?= base_url('gemba/simpan_deadline') ?>",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function(res) {
        if (res.status === true) {
          $('#modalDeadlineGemba').modal('hide');
          $('#modal_list_deadline').modal('hide');
          swal('Berhasil!', res.message, 'success');
        } else {
          swal('Oops!', res.message, 'warning');
        }
      },
      error: function() {
        swal('Error!', 'Gagal menyimpan perbaikan', 'error');
      }
    });
  }




  $('#btnSimpanPerbaikan').click(function() {

    let formData = new FormData();
    formData.append('id_gemba', $('#id_gemba').val());
    formData.append('evidence', $('#evidence')[0].files[0]);
    formData.append('note', $('#note').val());
    formData.append('link', $('#link').val());

    $.ajax({
      type: "POST",
      url: "<?= base_url('gemba/simpan_perbaikan') ?>",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function(res) {
        if (res.status === true) {
          swal('Berhasil!', res.message, 'success');
          $('#modalPerbaikanGemba').modal('hide');

          // kalau pakai datatable
          // $('#datatable').DataTable().ajax.reload(null, false);

        } else {
          swal('Oops!', res.message, 'warning');
        }
      },
      error: function() {
        swal('Error!', 'Gagal menyimpan data', 'error');
      }
    });

  });

  function initEmployeeSelect() {
    document.querySelectorAll(".employee").forEach((el) => {
      if (!el.slim) {
        el.slim = new SlimSelect({
          select: el
        });
      }
    });
  }



  function proses_gemba(id_gemba) {

    $("#modal_proses_gemba").modal("show");

    $.ajax({
      url: "<?php echo base_url("gemba/get_detail_gemba/") ?>" + id_gemba,
      method: "GET",
      dataType: "JSON",
      success: function(res) {
        $("#list_detail_gemba").html(res);
        initEmployeeSelect();
      },
      error: function(jqXHR) {
        console.log(jqXHR.responseText);
      }
    });


    $.ajax({
      url: "<?php echo base_url("gemba/get_detail_evaluasi/") ?>" + id_gemba,
      method: "GET",
      dataType: "JSON",
      success: function(res) {
        // console.log(res);
        $("#id_gemba").val(res.id_gemba);
        $("#detail_tipe_gemba").text(res.tipe_gemba);
        $("#detail_plan_date").text(res.tgl_plan);
        $("#detail_location").text(res.lokasi);
        $("#peserta").val(res.peserta);
        $("#evaluasi").val(res.evaluasi);
        $("#status_akhir").val(res.status);
      },
      error: function(jqXHR) {
        console.log(jqXHR.responseText);
      }
    });
  }

  function save_proses_gemba(id_gemba_ceklis) {
    id_gemba = $(`#id_gemba_${id_gemba_ceklis}`).val();
    status = $(`#status_item_${id_gemba_ceklis}`).val();
    file = $(`#file_item_${id_gemba_ceklis}`).val();
    link = $(`#link_item_${id_gemba_ceklis}`).val();
    note = $(`#note_item_${id_gemba_ceklis}`).val();
    pic = $(`#pic_item_${id_gemba_ceklis}`).val();
    deadline = $(`#deadline_item_${id_gemba_ceklis}`).val();
    lokasi_temuan = $(`#lokasi_temuan_item_${id_gemba_ceklis}`).val();
    ekspetasi_penyelesaian = $(`#ekspetasi_penyelesaian_item_${id_gemba_ceklis}`).val();

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
    } else if (status != "ya" && $(`#file_item_${id_gemba_ceklis}`).val() == "" && $(`#link_item_${id_gemba_ceklis}`).val() == "") {
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
    } else if (status != "ya" && $(`#lokasi_temuan_item_${id_gemba_ceklis}`).val() == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Lokasi Temuan is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
      return false;
    } else if (status != "ya" && $(`#ekspetasi_penyelesaian_item_${id_gemba_ceklis}`).val() == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Ekspetasi Penyelesaian is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
      return false;
    // } else if (status != "ya" && $(`#deadline_item_${id_gemba_ceklis}`).val() == "") {
    //   $.confirm({
    //     icon: 'fa fa-times-circle',
    //     title: 'Warning',
    //     theme: 'material',
    //     type: 'red',
    //     content: 'Deadline is empty!',
    //     buttons: {
    //       close: {
    //         actions: function() {}
    //       },
    //     },
    //   });
    //   return false;
    } else if (status != "ya" && $(`#note_item_${id_gemba_ceklis}`).val() == "") {
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
    } else if (
        status != "ya" && 
        (
            $(`#pic_item_${id_gemba_ceklis}`).val() == null ||
            $(`#pic_item_${id_gemba_ceklis}`).val().trim() == "" ||
            $(`#pic_item_${id_gemba_ceklis}`).val() == "0"
        )
    ) {
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
      return false;
    } else {
      $(`#btn_save_proses_gemba_${id_gemba_ceklis}`).attr("disabled", true);
      let file_item = $(`#file_item_${id_gemba_ceklis}`).prop("files")[0];
      let form_file = new FormData();
      form_file.append("id_gemba", id_gemba);
      form_file.append("id_gemba_ceklis", id_gemba_ceklis);
      form_file.append("status", status);
      form_file.append("file_item", file_item);
      form_file.append("link", link);
      form_file.append("note", note);
      form_file.append("pic", pic);
      form_file.append("deadline", deadline);
      form_file.append("lokasi_temuan", lokasi_temuan);
      form_file.append("ekspetasi_penyelesaian", ekspetasi_penyelesaian);
      $.ajax({
        url: "<?php echo base_url("gemba/save_proses_gemba") ?>",
        method: "POST",
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,
        data: form_file,
        success: function(res) {
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
          // $("#dt_list_proses").DataTable().ajax.reload();

          $(`#card_${id_gemba_ceklis}`).fadeOut(300, function () {
              $(this).remove();

              // 🔥 Cek apakah masih ada card
              let sisaCard = $('#modal_proses_gemba')
                  .find('.card-item').length;

              if (sisaCard === 0) {
                  setTimeout(function () {
                      $('#modal_proses_gemba').modal('hide');
                  }, 500);
              }
          });

          $("#dt_list_gemba").DataTable().ajax.reload();
        },
        error: function(jqXHR) {
          console.log(jqXHR.responseText);
          $(`#btn_save_proses_gemba_${id_gemba_ceklis}`).removeAttr("disabled");
        }
      });
    }
  }

  function save_proses_evaluasi() {
    id_gemba = $('#id_gemba').val();
    peserta = $('#peserta').val();
    evaluasi = $('#evaluasi').val();
    status_akhir = $('#status_akhir :checked').val();

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
        beforeSend: function(res) {
          $("#btn_save_proses_evaluasi").attr("disabled", true);
          $("#list_detail_gemba").show();
          $("#btn_save_proses_evaluasi").hide();
        },
        success: function(res) {
          proses_gemba(id_gemba); //komen
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
          // if (evaluasi != "") {
          //   $("#modal_proses_gemba").modal("hide");
          // }

          // hilang evaluasi
          // $('#modal_proses_gemba')
          //   .find('input[type=text], input[type=number], textarea')
          //   .val('');

          // $('#modal_proses_gemba')
          //   .find('select')
          //   .prop('selectedIndex', 0);

          // $("#dt_list_proses").DataTable().ajax.reload();
          $("#dt_list_gemba").DataTable().ajax.reload();
        },
        error: function(jqXHR) {
          console.log(jqXHR.responseText);
        }
      });
    }
  }

  function list_gemba(start, end) {
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
      "columns": [{
          'data': 'id_gemba',
          'render': function(data, type, row) {
            return `<a href="javascript:void(0);" class="badge bg-sm bg-primary" onclick="result_gemba('${data}')">${data}</a><a class="badge bg-secondary" href="<?= base_url('gemba/print/'); ?>${data}" target="_blank"><i class="bi bi-printer"></i></a>`;
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
          'render': function(data, type, row) {
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

  function result_gemba(id_gemba) {
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
      "columns": [{
          'data': 'concern'
        },
        {
          'data': 'monitoring'
        },
        {
          'data': 'status'
        },
        {
          'data': 'pic'
        },
        {
          'data': 'file',
          'render': function(data, type, row) {
            if (data != "") {
              return `<a href="<?= base_url('uploads/gemba/') ?>${data}" class="btn btn-sm btn-info text-white" target="_blank"><i class="bi bi-file-earmark-medical"></i></a>`;
            } else {
              return ``;
            }
          }
        },
        {
          'data': 'link',
          'render': function(data, type, row) {
            if (data != "") {
              return `<a href="${data}" class="btn btn-sm btn-primary text-white" target="_blank"><i class="bi bi-link"></i></a>`;
            } else {
              return ``;
            }
          }
        },
        {
          'data': 'status_item',
          'render': function(data, type, row) {
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


  generate_head_resume_v3()

  function generate_head_resume_v3() {
    // let start = $('#start').val();
    // let end = $('#end').val();
    $.ajax({
      url: '<?= base_url() ?>gemba/generate_head_resume_v3',
      type: 'POST',
      dataType: 'json',
      // data: {
      //     start: start,
      //     end: end
      // },
      beforeSend: function() {

      },
      success: function(response) {

      },
      error: function(xhr) { // if error occured

      },
      complete: function() {

      },
    }).done(function(response) {
      console.log(response)
      thead = '';
      thead = `<tr>
                      <th>Nama</th>
                      <th>Company</th>
                      <th>Jabatan</th>
                      `;
      for (let index = 0; index < response.data.length; index++) {
        const element = response.data[index];
        thead += `<th class="small text-center">${response.data[index].week_number} <br><span class="small">${response.data[index].f_tgl_awal}</span> s/d <span class="small">${response.data[index].f_tgl_akhir}</span></th>`;
      }
      thead += `</tr>`;

      tbody = '';
      for (let index = 0; index < response.body_resume.length; index++) {
        // console.log(response.data.length);
        tbody_td = '';
        if (response.data.length == 6) {
          tbody_td = `<td>${response.body_resume[index].w1 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${(response.body_resume[index].w2 > 0) ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w3 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w4 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w5 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w6 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          `
        } else if (response.data.length == 5) {
          tbody_td = `<td>${response.body_resume[index].w1 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${(response.body_resume[index].w2 > 0) ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
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
      $('#dt_resume_head_3').empty().append(thead);
      $('#dt_resume_body_3').empty().append(tbody);
      setTimeout(() => {
        $('#dt_resume_pembelajar_3').DataTable({
          "searching": true,
          "info": true,
          "paging": true,
          "destroy": true,
          "autoWidth": false,
          "dom": 'Bfrtip',
          buttons: [{
            extend: 'excelHtml5',
            text: 'Export to Excel',
            footer: true
          }],
        });
      }, 1000);
    }).fail(function(jqXhr, textStatus) {

    });
  }
</script>