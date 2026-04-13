<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>

<!-- view images -->
<!-- <script type="text/javascript" src="<?= base_url('assets/fancybox/jquery.fancybox.min.js') ?>"></script> -->

<!-- slim select js -->

<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>

<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>


<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script type="text/javascript">

  $(document).ready(function() {
    id_user = <?= $this->session->userdata('user_id') ?>;
    console.log(id_user);

    function formatNumber(num) {
      if (num == null) {
        return 0;
      } else {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
      }
    }

    $('#dt_list_lpj').DataTable({
      'destroy': true,
      'lengthChange': false,
      'searching': true,
      'info': true,
      'paging': true,
      "autoWidth": false,
      "ajax": {
        "dataType": 'json',
        "type": "GET",
        "url": "<?= base_url('eaf/pengajuan/get_list_lpj') ?>",
      },
      "columns": [{
        "data": "id_pengajuan",
        "render": function(data, type, row) {
          return '<span class="btn btn-primary btn-sm detail_lpj" data-id_pengajuan="'+ data +'" data-id_biaya="'+ row['id_biaya'] +'" style="cursor : pointer;">'+ data +'</span>'
        }
      },
      {
        "data": "nama_penerima"
      },

     

      // {
      //   "data": "nama_divisi"
      // },
      {
        "data": "nama_biaya"
      },
      {
        "data": "note"
      },
      {
        "data": "employee_name"
      },

      {
        "data": "admin_company_name"
      },
      {
        "data": "admin_dept_name"
      },
      {
        "data": "admin_desg_name"
      },

      {
        "data": "leadtime",
        "render": function (data,type,row) {
          // di Running Hari Senin 23 Okt 2023
          // if (row['id_jenis'] == 711 && data < 25) {
          //   return '<span class="label label-inverse-warning">Belum Membuat LPJ</span>';
          // } else if (row['id_jenis'] != 711 && data < 49) {
          if (data < 49) {
            return '<span class="badge custom-bg-outline-warning">Belum Membuat LPJ</span>';
          } else {
            return '<span class="badge custom-bg-outline-danger">Tidak Bisa Absen</span>';
          }
        }
      },
      {
        "data": "tgl_input"
      },
      {
        "data": "leadtime",
        "render": function (data) {
          // return (data / 24).toFixed(0) + ' Hari';
          return data + ' Jam';
        }
      },
      ]

    });

    $('#dt_list_lpj').on('click', '.detail_lpj', function(event) {
      $('#modal_detail_lpj').modal('show');
      $.ajax({
        url: '<?php echo base_url() ?>eaf/pengajuan/detail_lpj',
        type: 'POST',
        dataType: 'html',
        data: {
          id_pengajuan : $(this).data('id_pengajuan'),
          id_biaya : $(this).data('id_biaya'),
        },
        success: function (data) {
          $('#detail_lpj').empty().append(data);
        }
      });
    });

    $('#save_lpj').click(function() {
      kategori          = $('#kategori');
      nominal_pengajuan = $('#nominal_pengajuan');
      nominal_lpj       = $('#nominal_lpj');
      foto              = $('#foto');
      attachment        = $('#attachment');

      if (kategori.val() == "") {
        kategori.addClass('is-invalid').focus();
      } else if (nominal_lpj.val() == "") {
        nominal_lpj.addClass('is-invalid').focus();
      } else if (attachment.val() == 1 && foto.val() == "") {
        foto.addClass('is-invalid').focus();
      } else {
        $('#save_lpj').prop('disabled', true);

        $.ajax({
          url: '<?php echo base_url() ?>eaf/pengajuan/save_lpj',
          type: 'POST',
          dataType: 'json',
          data: $('#form_lpj').serialize(),
          success: function (response) {
            console.log(response.data);
            console.log(response.data.no_eaf);
            sisa_budget = (response.data.remaining_budget == '~') ? 'Unlimited' : `Rp. ${formatRupiah(response.data.remaining_budget)},-`;
            msg = `💸 Alert!!! \n*There is New LPJ EAF Approval* \n\nNo.EAF : ${response.data.no_eaf} \nType : ${response.data.type} \nNeed : *${$.trim(response.data.need)}* \nDescription : ${$.trim(response.data.description)} \n💵 Amount : *Rp. ${formatRupiah(response.data.amount,'')},-* \n\n🧮Remaining Budget : *${sisa_budget}* \n\n📝Approve To : ${response.data.approve_to} \n👤Requested By : ${response.data.requested_by} \n🕐Requested At : ${response.data.requested_at} \n🔗Link Approve : https://trusmicorp.com/rspproject/login?id=1&key=${response.data.no_eaf}`;
            console.log(msg);
            console.log(response.data.pengaju);
            if (response.data.pengaju == '2041') {
              // list_phone = ['08993036965'];
              list_phone = ['087829828061'];
            } else {
              // list_phone = [response.data.approve_contact.toString()];
              list_phone = ['087829828061'];
            }
            $('#save_lpj').prop('disabled', false);
            console.log(response);
            swal("Success!", "LPJ Telah Disimpan.", "success");
            $('#form_lpj')[0].reset();
            $('#dt_list_lpj').DataTable().ajax.reload();
            $('#modal_detail_lpj').modal('hide');
            // if (id_user == 1) {
            // // list_phone  = ['08993036965','081214926060'];
            console.log('Pengajuan : '+response.data.nominal_pengajuan);
            console.log('LPJ : '+response.data.amount);
            console.log('BA : '+response.data.used_ba);
            if (parseInt(response.data.amount) > parseInt(response.data.nominal_pengajuan) || response.data.used_ba == 'LPJ-BA') {
              send_wa_trusmi(list_phone, msg);
            }              
            // }
          }
        });
        
      }

      kategori.change(function() {
        kategori.removeClass('is-invalid');
      });

      nominal_lpj.keyup(function() {
        nominal_lpj.removeClass('is-invalid');
      });

      foto.change(function() {
        foto.removeClass('is-invalid');
      });
    });

    $('#modal_detail_lpj').on('hidden.bs.modal', function () {
      $.ajax({
        url: '<?php echo base_url() ?>eaf/pengajuan/remove_temp',
        type: 'POST',
        dataType: 'json',
        data: {
          id_temp: $('#id_temp').val()
        },
        success: function (response) {
          console.log(response);
          $('#detail_lpj').empty();
        }
      });
      
    });
  });
</script>