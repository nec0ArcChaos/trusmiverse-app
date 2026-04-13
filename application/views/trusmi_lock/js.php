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

    // data_lock_absen('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');

    /*Range*/
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
      $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="start"]').val(start.format('YYYY-MM-DD'));
      $('input[name="end"]').val(end.format('YYYY-MM-DD'));
      data_lock_absen(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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

    // $('#btn_filter').on('click', function() {
    //   start = $('#start').val();
    //   end = $('#end').val();
    //   // data_lock_absen(start, end);
    // });

    $("#karyawan").change(function() {
      user = $("#karyawan").val().toString().split(",");
      $("#user").val(user);
    })

    $("#btn_save").click(function() {
      if ($("#lock_type :selected").val() == "#") {
        swal("Warning", "Please choose type lock!!", "error");
      } else if ($("#user").val() == "") {
        swal("Warning", "Please choose employee name!!", "error");
      } else if ($("#alasan").val() == "") {
        swal("Warning", "Please enter your reason!!", "error");
      } else if ($("#activity").val() == "") {
        swal("Warning", "Please enter activity!!", "error");
      } else {
        $.ajax({
          method: "POST",
          url: "<?= base_url("trusmi_lock/save_lock") ?>",
          dataType: "JSON",
          data: $("form").serialize(),
          beforeSend: function(res) {
            $("#btn_save").attr("disabled", true);
            $('#spinner').modal('show');
          },
          success: function(res) {
            $("#modal_add_lock").modal("hide");
            console.log(res);
            swal("Success!!", "Data has been saved", "success");
            $("#dt_lock_absen").DataTable().ajax.reload();
            $("#btn_save").removeAttr("disabled");
            $("#form_lock")[0].reset();
            // untuk set default slim select
            kary.setSelected([]);
            setTimeout(() => {
              $('#spinner').modal('hide');
            }, 1000);
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
          }
        })
      }
    })

  });


  function add_lock() {
    $('#modal_add_lock').modal('show');
  }

  function data_lock_absen(start, end) {
    console.log(`start : ${start}, end : ${end}`);
    var tabel_lock_absen =
      $('#dt_lock_absen').DataTable({
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
          "url": "<?= base_url('trusmi_lock/get_lock_absen') ?>"
          // "success": function (res){
          //   console.log(res);
          // },
          // "error": function (jqXHR){
          //   console.log(jqXHR.responseText);
          // }
        },
        "columns": [{
            'data': 'nomor',
            'className': 'text-center'
          },
          {
            'data': 'employee_name'
          },
          {
            'data': 'type_lock',
            'render': function(data, type, row) {
              return `${data}`;
            }
          },
          {
            'data': 'alasan_lock',
            'render': function(data, type, row) {
              return `${data}`;
            }
          },
          {
            'data': 'status',
            'render': function(data, type, row) {
              if (data == 0) {
                status = "Unlocked";
                color = "success";
              } else if (data == 1) {
                status = "Locked";
                color = "danger";
              }

              id_user = <?= $this->session->userdata('user_id') ?>;
              console.log(id_user);
              if (id_user == row['id_user_locked'] && row['status'] == 1) {
                return `
  <span class="badge text-bg-${color} get_data_karyawan"
    data-id="${row['id']}"
    data-karyawan="${row['employee_name']}"
    data-alasan="${row['alasan_lock']}"
    data-activity="${row['activity']}"
    style="cursor:pointer; color:#fff !important;"
    onclick="unlocked(this)">
    ${status}
  </span>`;

              } else {
                return status;
              }
            },
            'className': 'text-center'
          },
          {
            'data': 'locked_at'
          },
          {
            'data': 'locked_by'
          },
          // {
          //     'data': 'activity',
          //     'visible': false,
          //     'searchable': false
          // },
          {
            'data': 'unlocked_at'
          },
        ]
      });
  }

function unlocked(el) {
  let id = el.dataset.id;
  let karyawan = el.dataset.karyawan;
  let alasan = el.dataset.alasan;
  let activity = el.dataset.activity;

  console.log('karyawan: ' + karyawan + ', alasan: ' + alasan + ', activity: ' + activity);

  $("#e_karyawan").val(karyawan);
  $("#e_alasan").val(alasan);
  $("#e_activity").val(activity);
  $("#e_id").val(id);
  $("#modal_unlock").modal("show");
}


  function save_unlock() {
    $.ajax({
      method: "POST",
      url: "<?php echo base_url("trusmi_lock/update_lock") ?>",
      dataType: "JSON",
      data: $("#form_unlock").serialize(),
      beforeSend: function(res) {
        $("#btn_unlock").attr("disabled", true);
      },
      success: function(res) {
        console.log(res);
        swal("Success!!", "Employee has been unlocked", "success");
        $("#modal_unlock").modal("hide");
        $("#btn_unlock").removeAttr("disabled");
        $("#dt_lock_absen").DataTable().ajax.reload();
      },
      error: function(jqXHR) {
        console.log(jqXHR.responseText);
      }
    })
  }
</script>