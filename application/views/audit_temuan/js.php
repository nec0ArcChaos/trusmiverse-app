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

    list_findings('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');

    /*Range*/
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
      $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="start"]').val(start.format('YYYY-MM-DD'));
      $('input[name="end"]').val(end.format('YYYY-MM-DD'));
      list_findings(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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

    dep = new SlimSelect({
      select: "#department"
    });

    kary = new SlimSelect({
      select: "#karyawan"
    });

    atr = new SlimSelect({
      select: "#aturan"
    });
    plan = new SlimSelect({
      select: "#plan"
    });


    $('#tanggal_kejadian').datetimepicker({
      format: 'Y-m-d H:i:s',
      timepicker: true
    });

  });

  function add_findings() {
    // Auto Get Date Today
    curdate = (new Date()).toISOString().split('T')[0];
    $("#tanggal").val(curdate);

    // Set Otomatis yg input
    dep.setSelected("-Choose Department-");
    // plan.setSelected("-Choose Plan-");
    // kary.setSelected("-Choose User-");

    $("#modal_add_findings").modal("show");
  }

  function change_department() {
    if ($('#department').val() != null) {
      dt = $('#department').val().split("|");
      // console.log(dt);
      dep_id = dt[0];
      comp_id = dt[1];
      $("#department_id").val(dep_id);
      $("#company_id").val(comp_id);

      // Get Karyawan/User
      $.ajax({
        url: "<?= base_url("audit/audit_temuan/get_karyawan/") ?>" + dep_id,
        method: "GET",
        dataType: "JSON",
        success: function(res) {
          // console.log(res);
          kary.destroy();
          $("#karyawan").empty().html(res);
          kary = new SlimSelect({
            select: "#karyawan"
          });
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
        }
      });

      // Get Aturan SOP
      $.ajax({
        url: "<?= base_url("audit/audit_temuan/get_aturan/") ?>" + dep_id,
        method: "GET",
        dataType: "JSON",
        success: function(res) {
          // console.log(res);
          atr.destroy();
          $("#aturan").empty().html(res);
          atr = new SlimSelect({
            select: "#aturan"
          });
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
        }
      });
    }
  }

  function save_findings() {
    department = $("#department").val();
    karyawan = $("#karyawan").val();
    proses_kerja = $("#proses_kerja").val();
    sub_proses_kerja = $("#sub_proses_kerja").val();
    temuan = $("#temuan").val();
    root_cause = $("#root_cause").val();
    kategori_temuan = $("#kategori_temuan").val();
    level_temuan = $("#level_temuan").val();
    tanggal_kejadian = $("#tanggal_kejadian").val();
    plan = $("#plan").val();
    // aturan            = $("#aturan").val();

    // console.log(department);
    // console.log($("#form_findings").serialize());

    alat_buktis = [];
    $("input[name='alat_bukti[]']").each(function() {
      var value = $(this).val();
      if (value) {
        alat_buktis.push(value);
      }
    });

    lampirans = [];
    $("input[name='lampiran[]']").each(function() {
      var value = $(this).val();
      if (value) {
        lampirans.push(value);
      }
    });
    if (plan == null || plan == '#') {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Plan is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (department == null) {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Department is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (karyawan == null) {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'User is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (proses_kerja == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Proses Kerja is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (sub_proses_kerja == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Sub Proses Kerja is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (temuan == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Temuan is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (root_cause == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Root Cause is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (kategori_temuan == null) {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Kategori Temuan is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (level_temuan == null && kategori_temuan == "Temuan Audit") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Level Temuan is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (tanggal_kejadian == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Tanggal Kejadian is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (alat_buktis.length != $('.alat_bukti').length) {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Alat Bukti is not complete!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (lampirans.length != $('.lampiran').length) {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Lampiran is not complete!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else {
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
            url: "<?= base_url("audit/audit_temuan/save_findings") ?>",
            method: "POST",
            dataType: "JSON",
            // cache: false,
            // contentType: false,
            // processData: false,
            // data: form_file,
            data: $("#form_findings").serialize(),
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
              $("#dt_list_findings").DataTable().ajax.reload();
              $("#modal_add_findings").modal("hide");
              $("#form_findings")[0].reset();
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

  function list_findings(start, end) {
    $('#dt_list_findings').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List findings',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('audit/audit_temuan/list_findings') ?>",
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
          "data": "id_temuan",
          'render': function(data, type, row, meta) {
            if (row['status'] == 1) {
              return data;
            } else {
              return `<span style="cursor:pointer" class="badge bg-primary" onclick="detail_tanggapan('${data}')" title="Tampilkan tanggapan user">${data}</span>`
            }
          }
        },
        {
          "data": "id_plan",
          'render': function(data, type, row, meta) {
            if (data != null) {
              return `<span class="badge bg-success">${data}</span>`;
            } else {
              return '';
            }
          }
        },
        {
          "data": "category",
          "render": function(data, type, row, meta) {
            if (data == 'Konfirmasi Audit') {
              return `<span class="badge bg-warning">${data}</span>`
            } else {
              return `<span class="badge bg-danger">${data}</span>`
            }
          }
        },
        {
          "data": "employee_name"
        },
        {
          "data": "company_name"
        },
        {
          "data": "divisi"
        },
        {
          "data": "proses_kerja"
        },
        {
          "data": "sub_proses_kerja"
        },
        {
          "data": "temuan",
          'render': function(data, type, row, meta) {
            return data;
          }
        },
        {
          "data": "level_temuan",
          "render": function(data, type, row, meta) {
            if (data == 'Minor') {
              return `<span class="badge bg-warning">${data}</span>`
            } else {
              return `<span class="badge bg-danger">${data}</span>`
            }
          }
        },
        {
          "data": "root_cause",
          'render': function(data, type, row, meta) {
            return data;
          }
        },
        {
          "data": "tanggal_kejadian"
        },
        {
          "data": "nama_dokumen"
        },
        {
          "data": "status",
          'render': function(data, type, row, meta) {

            icon_wa = '<?= base_url('assets/icon/whatsapp.png') ?>';

            // console.log(response);

            if (data == 1) { // 1 : Waitin Feedback
              resend_wa = `<a href="javascript:void(0)" title="Kirim Ulang Notifikasi Temuan"
                            onclick="resend_notifikasi_temuan('${row['id_temuan']}')">
                            <img src="${icon_wa}" width="20px" height="20px"></img>
                          </a>
                          <a href="<?= base_url('audit/audit_temuan/send_wa_temuan_manual/') ?>${row['id_temuan']}" target="_blank" title="Kirim Ulang Notifikasi Temuan Manual">
                            <span class="badge bg-warning">Kirim Manual</span>
                          </a>`
            } else {
              resend_wa = ``;
            }

            // console.log(data);
            if (data == 4 || data == 3 || data == 10) { // 4 : 
              url = `<?= base_url('audit/audit_temuan/print_ba') ?>/${row['id_temuan']}`;
              ba = `<a target="_blank" href="${url}" title="Tampilkan BA" class="label label-danger">
                      <i class="bi bi-printer"></i>
                    </a>`;
            } else {
              ba = ``;
            }

            return `<span class="badge bg-${row['color_status']}">${row['status_temuan']}</span> ${resend_wa} ${ba}`
          }
        },
        {
          "data": "alat_bukti"
        },
        {
          "data": "lampiran",
          "render": function(data, type, row, meta) {
            if (data != null) {
              lampirans = data.replace(/ /g, '').split(',');
              files = ``;
              base_url = '<?= base_url() ?>uploads/audit_temuan';
              $.each(lampirans, function(index, value) {
                ext = value.substr((value.lastIndexOf('.') + 1));
                if (ext == 'pdf') {
                  files += `<a data-fancybox="gallery" href="${base_url}/${value}" class="gallery" title="Lihat PDF">
                              <i class="bi bi-filetype-pdf"></i>
                            </a>
                            &nbsp;
                            `
                } else if (ext == 'xls' || ext == 'xlsx' || ext == 'csv') {
                  files += `<a href="${base_url}/${value}" title="Lihat Excel">
                            <i class="bi bi-filetype-xlsx"></i>
                            </a>
                            &nbsp;
                            `
                } else {
                  files += `<a data-fancybox="gallery" href="${base_url}/${value}" class="gallery" title="Lihat Foto">
                              <i class="bi bi-filetype-jpg"></i>
                            </a>
                            &nbsp;
                            `
                }
              });

              return files
            } else {
              return ''
            }

          }
        },
        {
          "data": "auditor"
        },
        {
          "data": "waktu_input"
        },
        {
          "data": "feedback"
        },
        {
          "data": "lampiran_feedback",
          "render": function(data, type, row, meta) {
            if (data == "") {
              return '';
            } else {
              return `<a data-fancybox="gallery" href="<?= base_url() ?>uploads/audit_temuan/${data}" class="gallery" title="Lihat Foto">
                          <i class="bi bi-filetype-jpg"></i>
                        </a>`;
            }
          }
        },
        {
          "data": "status_corrective"
        },
        {
          "data": "deadline_corrective"
        },
        {
          "data": "corrective"
        },
        {
          "data": "lampiran_corrective",
          "render": function(data, type, row, meta) {
            if (data == "" || data == null) {
              return '';
            } else {
              return `<a data-fancybox="gallery" href="<?= base_url() ?>uploads/audit_temuan/${data}" class="gallery" title="Lihat Foto">
                          <i class="bi bi-filetype-jpg"></i>
                        </a>`;
            }
          }
        },
        {
          "data": "status_preventif"
        },
        {
          "data": "deadline_preventif"
        },
        {
          "data": "preventif"
        },
        {
          "data": "lampiran_preventif",
          "render": function(data, type, row, meta) {
            if (data == "" || data == null) {
              return '';
            } else {
              return `<a data-fancybox="gallery" href="<?= base_url() ?>uploads/audit_temuan/${data}" class="gallery" title="Lihat Foto">
                          <i class="bi bi-filetype-jpg"></i>
                        </a>`;
            }
          }
        }
      ]
    });
  }

  function tambah_alat_bukti() {
    jml_alat_bukti = $('.alat_bukti').length;
    input = `<div class="row row_alat_bukti" id="row_alat_bukti_${parseInt(jml_alat_bukti)+1}">
                <div class="col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-columns-gap"></i></span>
                            <div class="form-floating">
                                <input type="text" class="form-control border-start-0 alat_bukti" name="alat_bukti[]" id="input_alat_bukti_${parseInt(jml_alat_bukti)+1}" placeholder="Alat Bukti">
                                <label>Alat Bukti <i class="text-danger">*</i></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
    $('#jml_alat_bukti').val(parseInt(jml_alat_bukti) + 1);
    $('#tempat_alat_bukti').append(input);
    setTimeout(() => {
      $(`#input_alat_bukti_${parseInt(jml_alat_bukti)+1}`).focus();
    }, 100);
  }

  function hapus_alat_bukti() {
    jml_alat_bukti = $('.alat_bukti').length;
    $(`#row_alat_bukti_${jml_alat_bukti}`).remove();
  }

  function tambah_lampiran() {
    jml_lampiran = $('.lampiran').length;
    input = `<div class="row row_lampiran" id="row_lampiran_${parseInt(jml_lampiran)+1}">
                <div class="col">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-folder"></i></span>
                            <div class="form-floating">
                                <input type="file" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="lampiran_${parseInt(jml_lampiran)+1}" class="form-control lampiran" onchange="input_lampiran('#lampiran_${parseInt(jml_lampiran)+1}')">
                            </div>
                            <input type="hidden" name="lampiran[]" id="input_lampiran_${parseInt(jml_lampiran)+1}" value="">
                            <input type="hidden" id="jml_lampiran" value="1">
                        </div>
                    </div>
                  </div>
                  <div class="col-auto">
                    <a data-fancybox="gallery" id="a_preview_lampiran_${parseInt(jml_lampiran)+1}" class="gallery a_lampiran">
                        <i class="fa fa-spinner fa-spin fa-2x mt-2" id="loading_lampiran_${parseInt(jml_lampiran)+1}" hidden></i>
                        <img class="preview" src="" alt=" " id="preview_lampiran_${parseInt(jml_lampiran)+1}" width="50" height="50">
                    </a>
                  </div>
            </div>`;
    $('#jml_lampiran').val(parseInt(jml_lampiran) + 1);
    $('#tempat_lampiran').append(input);
    setTimeout(() => {
      $(`#input_lampiran_${parseInt(jml_lampiran)+1}`).focus();
    }, 100);
  }

  function hapus_lampiran() {
    jml_lampiran = $('.lampiran').length;
    $(`#row_lampiran_${jml_lampiran}`).remove();
    if (jml_lampiran > 1) {
      $('#jml_lampiran').val(parseInt(jml_lampiran) - 1);
    }
  }

  function input_lampiran(id) {
    fileName = $(id).val();
    ext = fileName.substr((fileName.lastIndexOf('.') + 1));
    $(`#success_pdf_${id.replace('#','')}`).remove();
    if (ext == 'jpeg' || ext == 'png' || ext == 'jpg' || ext == 'JPEG' || ext == 'JPG' || ext == 'PNG') {
      compress_foto(id);
      preview_foto(id);
    } else {
      upload_lampiran_file(id);
      preview_foto(id);
    }
  }

  function preview_foto(id) {
    id_file = id.replace('#', '');
    id_preview = id.replace('#', 'preview_');
    a_id_preview = id.replace('#', 'a_preview_');
    $('#' + a_id_preview).removeAttr('hidden');
    file = document.getElementById(id_file).files[0];
    document.getElementById(id_preview).src = window.URL.createObjectURL(file);
    document.getElementById(a_id_preview).href = window.URL.createObjectURL(file);
  }

  function compress_foto(id) {
    $(`#loading_${id.replace('#','')}`).removeAttr('hidden');
    $(`#preview_${id.replace('#','')}`).attr('hidden', true);
    const file = document.querySelector(id).files[0];
    extension = file.name.substr((file.name.lastIndexOf('.') + 1));
    if (!file) return;
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function(event) {
      const imgElement = document.createElement("img");
      imgElement.src = event.target.result;
      extension = 'jpg,';
      imgElement.onload = function(e) {
        const canvas = document.createElement("canvas");
        if (e.target.width > e.target.height) {
          const MAX_HEIGHT = 400;
          const scaleSize = MAX_HEIGHT / e.target.height;
          canvas.height = MAX_HEIGHT;
          canvas.width = e.target.width * scaleSize;
        } else {
          const MAX_HEIGHT = 400;
          const scaleSize = MAX_HEIGHT / e.target.height;
          canvas.height = MAX_HEIGHT;
          canvas.width = e.target.width * scaleSize;
        }
        const ctx = canvas.getContext("2d");
        ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);
        const srcEncoded = ctx.canvas.toDataURL(e.target, "image/jpeg");
        var g_string = extension + srcEncoded.substr(srcEncoded.indexOf(',') + 1);
        upload_foto(id, g_string);
      }
    }
  }

  function upload_foto(id, g_string) {
    var formdata = new FormData();
    formdata.append('file', g_string);
    formdata.append('file_name', id);

    url = "<?= base_url('audit/audit_temuan/upload_lampiran') ?>";

    var ajax = new XMLHttpRequest();
    ajax.open("POST", url, true);
    ajax.send(formdata);
    ajax.onload = function(response) {
      $('#spinner').modal('hide');
      console.log('DONE: ', ajax.status);
      console.log('DONE: ', ajax.responseText);
      if (ajax.status == 200) {
        setTimeout(() => {
          $(`#loading_${id.replace('#','')}`).attr('hidden', true);
          $(`#preview_${id.replace('#','')}`).removeAttr('hidden');
          $(`#input_${id.replace('#','')}`).val(ajax.responseText);
          // $('#warning_foto').attr('hidden', true);
        }, 250);
      }
    }
  }

  function upload_lampiran_file(id) {
    $(`#loading_${id.replace('#','')}`).removeAttr('hidden');
    $(`#preview_${id.replace('#','')}`).attr('hidden', true);

    var formdata = new FormData();
    // formdata.append('file', g_string);
    formdata.append('file', $(id)[0].files[0]);
    formdata.append('file_name', id);

    url = "<?= base_url('audit/audit_temuan/upload_lampiran_file') ?>";

    var ajax = new XMLHttpRequest();
    ajax.open("POST", url, true);
    ajax.send(formdata);
    ajax.onload = function(response) {
      $('#spinner').modal('hide');
      console.log('DONE: ', ajax.status);
      console.log('DONE: ', ajax.responseText);
      if (ajax.status == 200) {
        setTimeout(() => {
          $(`#loading_${id.replace('#','')}`).attr('hidden', true);
          $(`#preview_${id.replace('#','')}`).removeAttr('hidden');
          $(`#input_${id.replace('#','')}`).val(ajax.responseText);
          success_pdf = `<i id="success_pdf_${id.replace('#','')}" class="ti ti-check text-success success_pdf" style="font-size:15pt; margin-left:15px; margin-right:15px"></i>`;
          $(`#preview_${id.replace('#','')}`).append(success_pdf);
          // $('#warning_foto').attr('hidden', true);
        }, 250);
      }
    }
  }

  function detail_tanggapan(id_temuan) {
    // console.log('Masuk Gas!!', id_temuan);
    $('#modal_keterangan_audit').modal('show');
    $('#keterangan_audit').val("");
    $('#status_audit').val("#");

    $("#id_temuan").val(id_temuan);

    $.ajax({
      url: '<?= base_url('audit/audit_temuan/get_detail_keterangan_audit/') ?>' + id_temuan,
      type: 'GET',
      dataType: 'JSON',
      success: function(res) {
        // console.log(res);
        $('#employee_name').text(res.employee_name);
        $('#company').text(res.company_name);
        $('#department_name').text(res.department_name);
        $('#designation').text(res.designation_name);

        $(".style_status_feedback").removeClass("badge bg-light-green text-dark small");
        $(".style_status_feedback").removeClass("badge bg-light-red text-dark small");
        $(".style_status_feedback").removeClass("badge bg-light-blue text-dark small");
        $(".bi-distribute-vertical").removeClass("bg-success");
        $(".bi-distribute-vertical").removeClass("bg-danger");
        $(".bi-distribute-vertical").removeClass("bg-primary");

        if (res.id_status == 3) {
          $(".style_status_feedback").addClass("badge bg-light-green text-dark small");
          $(".bi-distribute-vertical").addClass("bg-success");
          $("#keterangan_audit").attr("disabled", true);
          $("#status_audit").attr("disabled", true);
        } else if (res.id_status == 4) {
          $(".style_status_feedback").addClass("badge bg-light-red text-dark small");
          $(".bi-distribute-vertical").addClass("bg-danger");
          $("#keterangan_audit").removeAttr("disabled");
          $("#status_audit").removeAttr("disabled");
        } else {
          $(".style_status_feedback").addClass("badge bg-light-blue text-dark small");
          $(".bi-distribute-vertical").addClass("bg-primary");
          $("#keterangan_audit").removeAttr("disabled");
          $("#status_audit").removeAttr("disabled");
        }

        $('#status_feedback').text(res.status);
        $('#feedback').text(res.feedback);
        // $('#attachment_feedback').text(res.lampiran_feedback);

        if (res.lampiran_feedback == "") {
          $('#attachment_feedback').empty().append(`<span class="badge bg-red small">No File</span>`);
        } else {
          $('#attachment_feedback').empty().append('<a class="file_feedback" href="" target="_blank"><span class="badge bg-light-theme small">Feedback</span></a>');
          $('.file_feedback').attr('href', `<?= base_url('/uploads/audit_temuan/'); ?>${res.lampiran_feedback}`);
        }

        if (res.id_status == 6 || res.status_corrective == "#") { // Banding atau Status Corrective Kosong karena Banding
          $('#status_corrective').text("...");
          $('#deadline_corrective').text("...");
          $('#action_corrective').text("...");
          $('#attachment_corrective').text("...");

          $('#status_preventive').text("...");
          $('#deadline_preventive').text("...");
          $('#action_preventive').text("...");
          $('#attachment_preventive').text("...");
        } else {
          $('#status_corrective').text(res.sts_corrective);
          $('#deadline_corrective').text(res.deadline_corrective);
          $('#action_corrective').text(res.corrective);
          // $('#attachment_corrective').text(res.lampiran_corrective);
          if (res.lampiran_corrective == "") {
            $('#attachment_corrective').empty().append(`<span class="badge bg-red small">No File</span>`);
          } else {
            $('#attachment_corrective').empty().append('<a class="file_corrective" href="" target="_blank"><span class="badge bg-light-theme small">Corrective</span></a>');
            $('.file_corrective').attr('href', `<?= base_url('/uploads/audit_temuan/'); ?>${res.lampiran_corrective}`);
          }

          $('#status_preventive').text(res.sts_preventif);
          $('#deadline_preventive').text(res.deadline_preventif);
          $('#action_preventive').text(res.preventif);
          // $('#attachment_preventive').text(res.lampiran_preventif);
          if (res.lampiran_preventif == "") {
            $('#attachment_preventive').empty().append(`<span class="badge bg-red small">No File</span>`);
          } else {
            $('#attachment_preventive').empty().append('<a class="file_preventive" href="" target="_blank"><span class="badge bg-light-theme small">Preventive</span></a>');
            $('.file_preventive').attr('href', `<?= base_url('/uploads/audit_temuan/'); ?>${res.lampiran_preventif}`);
          }
        }

        $("#keterangan_audit").val(res.keterangan_pic);
        if (res.keterangan_pic != "") {
          $("#status_audit").val(res.id_status);
        }




        // if(response.data[0].status == '3'){
        //   $('#keterangan_pic').text(response.data[0].keterangan_pic);
        //   $('#status_audit').val(response.data[0].status);
        //   $('#keterangan_pic').attr('readonly', true);
        // }else if (response.data[0].status == '4'){
        //   $('#keterangan_pic').text(response.data[0].keterangan_pic);
        //   $('#status_audit').val(response.data[0].status);
        //   $('#keterangan_pic').attr('readonly', false);
        // }else{
        //   $('#keterangan_pic').attr('readonly', false);
        // }

        // if(response.data[0].status == '3'){ // 3 : Solved 
        //   $('#row_status').hide();
        //   $('#btn_save_status').hide();
        // }else{
        //   $('#row_status').show();
        //   $('#btn_save_status').show();
        // }
      },
      error: function(xhr) {
        console.log(xhr.responseText);
      }

    });

  }

  function save_keterangan_audit() {
    id_temuan = $("#id_temuan").val();
    keterangan_audit = $("#keterangan_audit").val();
    status_audit = $("#status_audit").val();

    if (keterangan_audit == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Keterangan is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (status_audit == null) {
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
            url: "<?= base_url("audit/audit_temuan/save_keterangan_audit") ?>",
            method: "POST",
            dataType: "JSON",
            data: {
              id_temuan: id_temuan,
              keterangan_audit: keterangan_audit,
              status_audit: status_audit
            },
            beforeSend: function(res) {
              $("#btn_save_keterangan_audit").attr("disabled", true);
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
              $("#dt_list_findings").DataTable().ajax.reload();
              $("#modal_keterangan_audit").modal("hide");
              $("#btn_save_keterangan_audit").removeAttr("disabled");
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

  function resend_notifikasi_temuan(id_temuan) {
    $.confirm({
      title: 'Prompt!',
      type: 'blue',
      theme: 'material',
      content: 'Are you sure for send Reminder ?',
      buttons: {
        cancel: function() {
          //close
        },
        formSubmit: {
          text: 'Submit',
          btnClass: 'btn-blue',
          action: function() {
            $.confirm({
              icon: 'fa fa-spinner fa-spin',
              title: 'Mohon Tunggu!',
              theme: 'material',
              type: 'blue',
              content: 'Sedang memproses...',
              buttons: {
                close: {
                  isHidden: true,
                  actions: function() {}
                },
              },
              onOpen: function() {
                $.ajax({
                  "url": "<?= base_url("audit/audit_temuan/send_wa_temuan/") ?>" + id_temuan,
                  "type": "GET",
                  "dataType": 'TEXT',
                  "success": function(res) {
                    console.log(res);
                    new PNotify({
                      title: `Success`,
                      text: `Reminder has been sent`,
                      icon: 'icofont icofont-brand-whatsapp',
                      type: 'success',
                      delay: 3000,
                    });
                  },
                  "error": function(jqXHR) {
                    console.log(jqXHR);
                    console.log(jqXHR.responseText);
                  }
                }).done(function(response) {
                  setTimeout(() => {
                    jconfirm.instances[0].close();
                    $.confirm({
                      icon: 'fa fa-check',
                      title: 'Done!',
                      theme: 'material',
                      type: 'blue',
                      content: 'Resend notif!',
                      buttons: {
                        close: {
                          actions: function() {}
                        },
                      },
                    });
                  }, 250);
                }).fail(function(jqXHR, textStatus) {
                  setTimeout(() => {
                    jconfirm.instances[0].close();
                    $.confirm({
                      icon: 'fa fa-close',
                      title: 'Oops!',
                      theme: 'material',
                      type: 'red',
                      content: 'Gagal Resend Notif!' + textStatus,
                      buttons: {
                        close: {
                          actions: function() {}
                        },
                      },
                    });
                  }, 250);
                });
              },
            });
          }
        },
      },
    });
  }

  function change_kategori() {
    val_kat = $("#kategori_temuan").val();
    user_id = <?= $_SESSION['user_id'] ?>;
    // console.log(user_id);
    if (val_kat == "Konfirmasi Audit") {
      $(".hidden_level_temuan").hide();
      $(".change_kategori").removeClass("col-md-6 col-lg-6 col-xl-6 col-xxl-6");
      $(".change_kategori").addClass("col-md-12 col-lg-12 col-xl-12 col-xxl-12");
    } else {
      $(".hidden_level_temuan").show();
      $(".change_kategori").removeClass("col-md-12 col-lg-12 col-xl-12 col-xxl-12");
      $(".change_kategori").addClass("col-md-6 col-lg-6 col-xl-6 col-xxl-6");
    }
  }

  function get_periode() {
    plan = $('#plan').val();
    if (plan != null && plan != '#') {
      if (plan == 'Special Case') {
        $('#periode').val('');
        return;
      } else {
        $.ajax({
          url: "<?= base_url('audit/audit_temuan/get_plan') ?>",
          method: "POST",
          data: {
            plan: plan
          },
          dataType: "JSON",
          success: function(res) {
            $('#periode').val(res.plan[0]['periode']);
          }
        })
      }
    }
  }
</script>