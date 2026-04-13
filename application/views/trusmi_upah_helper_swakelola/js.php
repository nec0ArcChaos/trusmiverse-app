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

    data_tukang();

  });

  function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split = number_string.split(','),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
  }

  function data_tukang() {
    var tabel_lock_absen =
      $('#dt_upah').DataTable({
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
          // "data": {
          //   datestart: start,
          //   dateend: end
          // },
          "url": "<?= base_url('Trusmi_upah_helper_swakelola/get_data_karyawan') ?>"
          // "success": function (res){
          //   console.log(res);
          // },
          // "error": function (jqXHR){
          //   console.log(jqXHR.responseText);
          // }
        },
        "columns": [
          {
            render: function(data, type, row, meta) {
              return meta.row + meta.settings._iDisplayStart + 1;
            }
          },
          {
            'data': 'name'
          },
          {
            'data': 'department_name'
          },
          {
            'data': 'designation_name'
          },
          {
            'data': 'upah',
            'render': function(data, type, row) {
              return formatRupiah(row.upah, 'Rp. ');
            }
          },
          {
            'data': 'user_id',
            'render': function(data, type, row) {
              return `<span class="badge text-bg-primary" style="cursor: pointer;" onclick="modal_log('${row.user_id}')">Log</span>`;
            }
          },
          {
            'data': 'user_id',
            'render': function(data, type, row) {
              return `<span class="badge text-bg-warning" style="cursor: pointer;" data-user_id="${row.user_id}" data-name="${row.name}" data-upah="${row.upah}" onclick="modal_upah(this)">Edit Upah</span>`;
            }
          }
        ]
      });
  }

function modal_upah(el) {
  let user_id = el.dataset.user_id;
  let upah = el.dataset.upah;
  let name = el.dataset.name;

  $("#user_id").val(user_id);
  $("#nama_karyawan").val(name);
  $("#upah").val(upah);
  $("#modal_upah").modal("show");
}

function modal_log(user_id)
{
   $("#modal_log").modal("show");
   $('#dt_log').DataTable({
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
          "type": "GET",
          "url": "<?= base_url('Trusmi_upah_helper_swakelola/get_log_upah') ?>/"+user_id
        },
        "columns": [
          {
            render: function(data, type, row, meta) {
              return meta.row + meta.settings._iDisplayStart + 1;
            }
          },
          {
            'data': 'name'
          },
          {
            'data': 'department_name'
          },
          {
            'data': 'designation_name'
          },
          {
            'data': 'upah',
            'render': function(data, type, row) {
              return formatRupiah(row.upah, 'Rp. ');
            }
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

  function save_upah() {
    $.ajax({
      method: "POST",
      url: "<?php echo base_url("trusmi_upah_helper_swakelola/save_upah") ?>",
      dataType: "JSON",
      data: $("#form_upah").serialize(),
      beforeSend: function(res) {
        $("#btn_upah").attr("disabled", true);
      },
      success: function(res) {
        swal("Success!!", "Data berhasil disimpan", "success");
        $("#modal_upah").modal("hide");
        $("#btn_upah").removeAttr("disabled");
        $("#dt_upah").DataTable().ajax.reload();
      },
      error: function(jqXHR) {
        console.log(jqXHR.responseText);
      }
    })
  }
</script>