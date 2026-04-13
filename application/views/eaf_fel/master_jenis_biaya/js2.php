<!-- Required Jquery -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap/js/bootstrap.min.js"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<!-- data-table js -->
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- i18next.min.js -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/advance-elements/moment-with-locales.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- Date-range picker js -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap-daterangepicker/js/daterangepicker.js"></script>

<script src="<?php echo base_url(); ?>assets/js/pcoded.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/demo-12.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/script.js"></script>

<!-- jquery slimscroll js -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>

<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/sweetalert/sweetalert.min.js"></script>

<!-- ckeditor -->
<script src="<?php echo base_url(); ?>assets/pages/ckeditor/ckeditor.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/pages/wysiwyg-editor/wysiwyg-editor.js"></script> -->

<script type="text/javascript" src="<?= base_url('assets/fancybox/jquery.fancybox.min.js') ?>"></script>

<!-- jspdf -->
<script src="<?php echo base_url(); ?>assets/jspdf/jspdf.umd.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jspdf/html2canvas.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jspdf/jspdf.plugin.autotable.js"></script>

<!-- slim select js -->
<script src="<?php echo base_url(); ?>assets/js/slimselect.min.js"></script>

<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/dataTables.fixedColumns.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {

  tabel_jenis_biaya();

  var akun = new SlimSelect({
    select: '#akun'
  });

  var budget = new SlimSelect({
    select: '#budget'
  });

  var tipe_biaya = new SlimSelect({
    select: '#tipe_biaya'
  });

  var user_approval = new SlimSelect({
    select: '#user_approval'
  });

  $('#btn_add_budget').click(function() {
    $('#modal_budget').modal('show');
  });
  
  $('#insert_budget').on('click', function() {
    add_budget = $('#add_budget');

    if (add_budget.val() == "") {
      add_budget.addClass('is-invalid');
      add_budget.focus();
    } else {
      $('#insert_budget').prop('disabled', true);
      $.ajax({
        url: '<?php echo base_url() ?>eaf/master_jenis_biaya/insert_budget',
        type: 'post',
        dataType: 'json',
        data: $('#form_budget').serialize(),
        success: function(response) {
          $('#form_budget')[0].reset();
          swal("Success", "Data Has Been Saved", "success")
          $('#insert_budget').prop('disabled', false);
          $('#modal_budget').modal('hide');
          console.log($('#add_budget').val());
          console.log(response);
          reload_budget(response);
          budget.setSelected(response);
        },
        error: function(xhr, textStatus, errorThrown) {
          console.log(xhr.responseText);
        }
      });
    }

    add_budget.keyup(function(e) {
      add_budget.removeClass('is-invalid');
    });

  });

  $('#btn_add_jenis_biaya').click(function() {
    $('#insert_jenis_biaya').show();
    $('#update_jenis_biaya').hide();
    $('#id_jenis').val(0);
    $('#modal_jenis_biaya').modal('show');    
  });

  $('#insert_jenis_biaya').on('click', function() {
    jenis = $('#jenis_biaya');

    if (jenis.val() == "") {
      jenis.addClass('is-invalid');
      jenis.focus();
    } else if ($('#akun').val() == "-- Pilih Akun --") {
      akun.open();
    } else if ($('#budget').val() == "-- Pilih Budget --") {
      budget.open();
    } else if ($('#tipe_biaya').val() == "-- Pilih Tipe Biaya --") {
      tipe_biaya.open();
    } else if ($('#user_approval').val() == "-- Pilih User Approval --") {
      user_approval.open();
    } else {
      $('#insert_jenis_biaya').prop('disabled', true);
      $.ajax({
        url: '<?php echo base_url() ?>eaf/master_jenis_biaya/insert_jenis_biaya',
        type: 'post',
        dataType: 'json',
        data: $('#form_jenis_biaya').serialize(),
        success: function(response) {
          $('#modal_jenis_biaya').modal('hide');
          $('#insert_jenis_biaya').prop('disabled', false);
          $('#form_jenis_biaya')[0].reset();
          swal("Success", "Data Has Been Saved", "success")
          $('#dt_list_jenis_biaya').DataTable().ajax.reload();

          akun.setSelected('-- Pilih Akun --');
          budget.setSelected('-- Pilih Budget --');
          tipe_biaya.setSelected('-- Pilih Tipe Biaya --');
          user_approval.setSelected('-- Pilih User Approval --');
        },
        error: function(xhr, textStatus, errorThrown) {
          console.log(xhr.responseText);
        }
      });
    }

    jenis.keyup(function(e) {
      jenis.removeClass('is-invalid');
    });

  });

  $('#dt_list_jenis_biaya').on('click', '.edit_jenis_biaya', function() {
    $('#update_jenis_biaya').show();
    $('#insert_jenis_biaya').hide();
    jenis       = $('#jenis_biaya');
    id_jenis    = $(this).data('id_jenis');
    $('#id_jenis').val(id_jenis);
    tpb         = $(this).data('id_tipe_biaya');
    jenis.val($(this).data('jenis'));
    akun.setSelected($(this).data('id_akun'));
    budget.setSelected($(this).data('id_budget'));
    // console.log($(this).data('id_tipe_biaya'));
    // tipe_biaya.setSelected($(this).data('id_tipe_biaya'));
    setTimeout(function() {
      console.log("Masuk");
      // $("#tipe_biaya").val($(this).data('id_tipe_biaya'));
      // $("#tipe_biaya").val().change();
      $('#tipe_biaya').val(tpb).prop('selected', true);
    }, 2000);
    user_approval.setSelected($(this).data('id_user'));

    $('#modal_jenis_biaya').modal('show');
  });

  $('#update_jenis_biaya').on('click', function() {
    if (jenis.val() == "") {
      jenis.addClass('is-invalid');
      jenis.focus();
    } else if ($('#akun').val() == "-- Pilih Akun --") {
      akun.open();
    } else if ($('#budget').val() == "-- Pilih Budget --") {
      budget.open();
    } else if ($('#tipe_biaya').val() == "-- Pilih Tipe Biaya --") {
      tipe_biaya.open();
    } else if ($('#user_approval').val() == "-- Pilih User Approval --") {
      user_approval.open();
    } else {
      $('#update_jenis_biaya').prop('disabled', true);
      $.ajax({
        url: '<?php echo base_url() ?>eaf/master_jenis_biaya/insert_jenis_biaya',
        type: 'POST',
        dataType: 'json',
        data: $('#form_jenis_biaya').serialize(),
        success: function(response) {
          $('#update_jenis_biaya').prop('disabled', false);
          console.log(response);
          swal("Success!", "Data Has been Updated", "success");
          $('#form_jenis_biaya')[0].reset();
          $('#dt_list_jenis_biaya').DataTable().ajax.reload();
          $('#modal_jenis_biaya').modal('hide');
        }
      });
    }

    jenis.keyup(function(e) {
      jenis.removeClass('is-invalid');
    });
  });

  $('#dt_list_jenis_biaya').on('click', '.delete_jenis_biaya', function() {
    id_jenis = $(this).data('id_jenis');
    console.log(id_jenis);
    swal({
      title: "Anda yakin delete jenis biaya ini?",
      text: "Data tidak bisa dikembalikan lagi, pastikan tidak ada data yang menggunakan jenis biaya ini",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      console.log("Apakah Delete");
      if (willDelete) {
        $.ajax({
          url: '<?php echo base_url() ?>eaf/master_jenis_biaya/delete_jenis_biaya',
          type: 'post',
          dataType: 'json',
          data: {
            id_jenis_biaya: id_jenis
          },
          success: function(response) {
            console.log(response);
            swal("Success", "Data Has Been Deleted", "success")
            $('#dt_list_jenis_biaya').DataTable().ajax.reload();
          },
          error: function(xhr, error, code) {
            console.log(xhr.responseText);
          }
        });
      }
    });

  });

  $('#modal_jenis_biaya').on('hidden.bs.modal', function() {
    $('#form_jenis_biaya')[0].reset();
    akun.setSelected('-- Pilih Akun --');
    budget.setSelected('-- Pilih Budget --');
    tipe_biaya.setSelected('-- Pilih Tipe Biaya --');
    user_approval.setSelected('-- Pilih User Approval --');
  });

  // Tambahan Faisal
  $("#budget").on('change', function() {
    bdt = $("#budget").val();
    // console.log(bdt);
    if (bdt != '-- Pilih Budget --') {
      $.ajax({
        url: "<?= base_url('eaf/master_jenis_biaya/get_tipe_biaya/') ?>"+bdt,
        method: "GET",
        dataType: "HTML",
        success: function (res){
          console.log(res);
          $("#tipe_biaya").empty();
          $("#tipe_biaya").append(res);
        },
        error: function (xhr){
          console.log(xhr.responseText);
        }
      });
    }
  });

});

function reload_budget(value) {
  $.ajax({
    method: "GET",
    url: "<?= base_url() ?>eaf/master_jenis_biaya/reload_budget/" + value,
    dataType: "html",
    success: function(response) {
      $('#budget').empty().append(response);
    }
  })
};

function tabel_jenis_biaya() {
  // IT, Pak Hendra, Bu Yeyen, Noni, Ade
  var arr = [1, 61, 162, 495, 344];
  var id_ = <?= $this->session->userdata('id_user') ?>;
  console.log(arr);
  console.log(id_);
  $('#dt_list_jenis_biaya').DataTable({
    'destroy': true,
    'lengthChange': false,
    'searching': true,
    'info': true,
    'paging': true,
    "autoWidth": false,
    "dataSrc": "",
    "dom": 'Bfrtip',
    buttons: [{
      extend: 'excelHtml5',
      text: 'Export to Excel',
      title: "<?= $pageTitle ?>",
      footer: true,
      customize: function(xlsx) {
        var sheet = xlsx.xl.worksheets['sheet1.xml'];
        $('row:first c', sheet).attr('s', '2');
      }
    }],
    "ajax": {
      "dataType": 'json',
      "type": "POST",
      "url": "<?= base_url('eaf/master_jenis_biaya/get_list_jenis_biaya') ?>",
    },
    "columns": 
    [
      {
        "data": "id_jenis",
        "className": "text-center"
      },
      {
        "data": "jenis"
      },
      {
        "data": "nama_akun"
      },
      {
        "data": "budget"
      },
      {
        "data": "nama_tipe_biaya"
      },
      {
        "data": "employee_name"
      },
      {
        "data": "verifikator"
      },
      {
        "data": "created"
      },
      {
        "data": "id_jenis",
        "visible": (jQuery.inArray(id_, arr) == -1) ? false : true,
        "render": function(data, type, row) {
          return '<span class="label label-warning edit_jenis_biaya" data-id_jenis="' + data + '" data-jenis="' + row['jenis'] + '" data-id_akun="' + row['id_akun'] + '" data-akun="' + row['nama_akun'] + '" data-id_budget="' + row['id_budget'] + '" data-budget="' + row['budget'] + '" data-id_tipe_biaya="' + row['id_tipe_biaya'] + '" data-tipe_biaya="' + row['nama_tipe_biaya'] + '" data-id_user="' + row['id_user'] + '" data-user="' + row['employee_name'] + '"  style="cursor : pointer;"><i class="ti-pencil"></i></span> <span class="label label-danger delete_jenis_biaya" data-id_jenis="' + data + '"  style="cursor : pointer;"><i class="ti-trash"></i></span>'
        },
        "className": "text-center"
      }
    ]
  });
}
</script>