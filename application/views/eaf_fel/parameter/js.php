<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/node_modules/compressorjs/dist/compressor.min.js"></script>

<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script src="
https://cdn.jsdelivr.net/npm/slim-select@2.8.2/dist/slimselect.umd.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/slim-select@2.8.2/dist/slimselect.min.css
" rel="stylesheet">

<!-- Memuat script Dropzone.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>

<script>
    $(document).ready(function() {
       menu_id = new SlimSelect({
        select: '#menu_id',
       });

       user = new SlimSelect({
        select: '#user',
        
      });

      fitur_id = new SlimSelect({
        select: '#fitur_id',
       });

       user2 = new SlimSelect({
        select: '#user2',
        
      });

      tbl_menu();
      tbl_fitur();

    });
    // End of document ready

    function tbl_menu() {
      // IT, Pak Hendra, Bu Yeyen, Noni, Ade
      var id_ = <?= $this->session->userdata('user_id') ?>;
      // console.log(arr);
      // console.log(id_);
      $('#dt_menu').DataTable({
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
          "url": "<?= base_url('eaf/parameter/dt_akses_menu') ?>",
        },
        "columns": 
        [
          {
            "data": "menu_id",
            "className": "text-center"
          },
          {
            "data": "menu_nm",
            "render": function(data, type, row) {
              return `<span class="badge bg-primary">` + data + `</span>`
            }
          },  
          {
            "data": "employee_name",
            "className": "text-right"
          }, 
          // {
          //   "data": "id_user",
          //   "render": function(data, type, row) {
          //     return `<span class="btn btn-danger btn-sm" onclick="delete_akses_menu(`+data+`,`+ row['menu_id']+`)" style="cursor : pointer;"><i class="bi bi-trash"></i></span>`
              
          //   }
          // },                 
        ]
      });
    }

    function open_mdl_akses_menu(menu_id) {     
        $('#mdl_add_akses').modal('show');      
    }

    function add_akses_menu() {  
      user_var = $('#user').val();
      menu_id_var = $('#menu_id').val();
      $('#btn_add_akses_menu').prop('disabled', true);
      if (menu_id_var == "-- Pilih Menu --") {
          menu_id.open();
      } else if (user_var == "-- Pilih User --") {
          user.open();      
      } else {
          $('#update_jenis_biaya').prop('disabled', true);
          $.ajax({
            url: '<?php echo base_url() ?>eaf/parameter/insert_akses_menu',
            type: 'POST',
            dataType: 'json',
            data: $('#form_tambah_akses').serialize(),
            success: function(response) {
              $('#btn_add_akses_menu').prop('disabled', false);
              console.log(response);
              if(response.status == true){

                swal("Success!", "Data Has been Updated", "success");

                $('#form_tambah_akses')[0].reset();
                $('#dt_menu').DataTable().ajax.reload();
                $('#mdl_add_akses').modal('hide');
                location.reload()
              } else {

                swal("Failed!", response.msg, "error");

              }
            }
          });
        }

    }

    function delete_akses_menu(id_user, menu_id) {     
    }

    function tbl_fitur() {
      // IT, Pak Hendra, Bu Yeyen, Noni, Ade
      var id_ = <?= $this->session->userdata('user_id') ?>;
      // console.log(arr);
      // console.log(id_);
      $('#tbl_fitur').DataTable({
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
          "url": "<?= base_url('eaf/parameter/dt_akses_fitur') ?>",
        },
        "columns": 
        [
          {
            "data": "fitur_id",
            "className": "text-center"
          },
          {
            "data": "fitur_nm",
            "render": function(data, type, row) {
              return `<span class="badge bg-primary">` + data + `</span>`
            }
          },  
          {
            "data": "employee_name",
            "className": "text-right"
          }, 
          {
            "data": "fitur_ket",
            "className": "text-right"
          }, 
          // {
          //   "data": "id_user",
          //   "render": function(data, type, row) {
          //     return `<span class="btn btn-danger btn-sm" onclick="delete_akses_menu(`+data+`,`+ row['menu_id']+`)" style="cursor : pointer;"><i class="bi bi-trash"></i></span>`
              
          //   }
          // },                 
        ]
      });
    }

    function open_mdl_akses_fitur(menu_id) {     
        $('#mdl_add_akses_fitur').modal('show');      
    }

    function add_akses_fitur() {  
      user2_var = $('#user2').val();
      fitur_id_var = $('#fitur_id').val();
      $('#btn_add_akses_fitur').prop('disabled', true);
      if (fitur_id_var == "-- Pilih Menu --") {
          fitur_id.open();
      } else if (user2_var == "-- Pilih User --") {
        user2.open();      
      } else {
          $('#update_jenis_biaya').prop('disabled', true);
          $.ajax({
            url: '<?php echo base_url() ?>eaf/parameter/insert_akses_fitur',
            type: 'POST',
            dataType: 'json',
            data: $('#form_tambah_akses_fitur').serialize(),
            success: function(response) {
              $('#btn_add_akses_fitur').prop('disabled', false);
              console.log(response);
              if(response.status == true){

                swal("Success!", "Data Has been Updated", "success");

                $('#form_tambah_akses_fitur')[0].reset();
                $('#tbl_fitur').DataTable().ajax.reload();
                $('#mdl_add_akses_fitur').modal('hide');
                location.reload()
              } else {

                swal("Failed!", response.msg, "error");
                user2.setSelected('-- Pilih User --');
                fitur_id.setSelected('-- Pilih Menu --');

              }
            }
          });
        }

    }


</script>