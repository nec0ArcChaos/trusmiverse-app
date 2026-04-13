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

<script type="text/javascript">

  $(document).ready(function() {
    id_user = <?= $this->session->userdata('id_user') ?>;
    console.log(id_user);
    function formatNumber(num) {
      if (num == null) {
        return 0;
      } else {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
      }
    }


    /*Range*/
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
      $('#reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="datestart"]').val(start.format('YYYY-MM-DD'));
      $('input[name="dateend"]').val(end.format('YYYY-MM-DD'));
    }

    tabel_list_eaf(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'))

    $('#range').daterangepicker({
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

    $('#btn_filter').click(function() {
      tabel_list_eaf($('input[name="datestart"]').val(), $('input[name="dateend"]').val())
    });


    $('#dt_list_eaf').on('click', '.detail_pengajuan', function() {
      id_pengajuan = $(this).data('id_pengajuan');

      $('#modal_detail_pengajuan').modal('show');

      $.ajax({
        url: '<?php echo base_url() ?>eaf/pengajuan/data_detail_revisi',
        type: 'POST',
        dataType: 'html',
        data: {
          id_pengajuan : id_pengajuan
        },
        success : function (data) {
          $('#data_detail_revisi').empty().append(data);
        }
      });
    });

    $('#btn_save_revisi').click(function() {
      $('#btn_save_revisi').prop('disabled', true);
      $.ajax({
        url: '<?php echo base_url() ?>eaf/pengajuan/save_revisi',
        type: 'POST',
        dataType: 'json',
        data: $('#form_revisi').serialize(),
        success: function (response) {
          console.log(response.data);
          console.log(response.no_eaf);
          console.log(response.id_user_verified);
          sisa_budget = (response.remaining_budget == '~') ? 'Unlimited' : `Rp. ${formatRupiah(response.remaining_budget)},-`;
          msg = `💸 Alert!!! \n*There is New Revision EAF Approval* \n\nNo.EAF : ${response.no_eaf} \nType : ${response.type} \nNeed : *${$.trim(response.need)}* \nDescription : ${$.trim(response.description)} \n💵 Amount : *Rp. ${formatRupiah(response.amount,'')},-* \n\n🧮Remaining Budget : *${sisa_budget}* \n\n📝Approve To : ${response.approve_to} \n👤Requested By : ${response.requested_by} \n🕐Requested At : ${response.requested_at} \n🔗Link Approve : https://trusmicorp.com/rspproject/login?id=1&key=${response.no_eaf}`;
          console.log(msg);
          console.log(response.pengaju);
          if (id_user == 1) {
            list_phone = ['08993036965'];
          } else {
            list_phone = [response.approve_contact.toString()];
          }
          // list_phone  = ['08993036965','081214926060'];
        
          // Jika tidak perlu verifikasi maka send to Approval User
          if (response.id_user_verified == null) {
            send_wa_trusmi(list_phone, msg);
          }
          $('#btn_save_revisi').prop('disabled', false);
          $('#modal_detail_pengajuan').modal('hide');
          $('#dt_list_eaf').DataTable().ajax.reload();
          swal("Success", "Has Been Revised", "success")
        }
      });
      
    });

    function tabel_list_eaf(start, end) {
      $('#dt_list_eaf').DataTable({
        'destroy': true,
        'lengthChange': false,
        'searching': true,
        'info': true,
        'paging': true,
        "autoWidth": false,
        "dataSrc": "",
        "order": [
          [1, "desc"]
          ],
        "ajax": {
          "dataType": 'json',
          "type": "POST",
          "data": {
            datestart: start,
            dateend: end,
            tipe: <?php echo $tipe ?>
          },
          "url": "<?= base_url('eaf/pengajuan/get_list_eaf') ?>",
        },
        "columns": [{
          "data": "id_pengajuan",
          "render": function(data, type, row) {
            return '<span class="label label-primary detail_pengajuan" data-id_pengajuan="'+ data +'" style="cursor : pointer;">'+ data +'</span>'
            // <a target="_blank" href="<?php echo base_url() ?>eaf/pengajuan/save_pengajuan/'+ data +'/'+row['id_kategori']+'/'+row['flag']+'" class="label label-info"><i class="ti-printer"></i></a>'
          }
        },
        {
          "data": "tgl_input"
        },
        {
          "data": "nama_status",
          'render': function(data, type, row) {
            if (row['status'] == 1 || row['status'] == 2 || row['status'] == 6) {
              return `<span class="${row['warna']}">${data}</span>`
            } else if (row['status'] == 4 || row['status'] == 5) {
              return `<span class="${row['warna']}">${data}</span>`
            } else {
              if ((row['temp'] != null || row['temp'] == '') && row['temp'].slice(0, 3) == "LPJ") {
                return `<span class="${row['warna']}">${data}</span>&nbsp<span class="label label-inverse-primary">` + row['temp'] + `</span>`
              } else {
                return `<span class="${row['warna']}">${data}</span>`
              }
            }
          }
        },
        {
          "data": "nama_penerima"
        },
        {
          "data": "pengaju"
        },
        {
          "data": "nama_kategori",
          render: function(data, type, row) {
            if (row['stt_bawa'] == 1) {
              return `<span class="text-danger f-w-600"> ${data} </span> <a href="<?php echo base_url() ?>print_ba/data_print_ba/${row['id_pengajuan']}" target="_blank" class="label label-danger" style="cursor : pointer;"><i class="icofont icofont-printer"></i></a>`
            } else {
              return data
            }
          }
        },
        {
          "data": "nama_keperluan"
        },
        {
          "data": "nama_divisi"
        },
        {
          "data": "name"
        },
        ]

      });
    }

  });
</script>