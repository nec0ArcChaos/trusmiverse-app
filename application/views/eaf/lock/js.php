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
  // var table_ajax;

  $(document).ready(function() {

    id_user = <?= $this->session->userdata('user_id'); ?>;

    function formatNumber(num) {
      if (num == null) {
        return 0;
      } else {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
      }
    }

    /*Range*/
    // var start = moment().startOf('month');
    // var end = moment().endOf('month');

    // function cb(start, end) {
    //   $('#reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    //   $('input[name="datestart"]').val(start.format('YYYY-MM-DD'));
    //   $('input[name="dateend"]').val(end.format('YYYY-MM-DD'));
    // }

    // $('#range').daterangepicker({
    //   startDate: start,
    //   endDate: end,
    //   "drops": "down",
    //   ranges: {
    //     'Today': [moment(), moment()],
    //     'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    //     'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    //     'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    //     'This Month': [moment().startOf('month'), moment().endOf('month')],
    //     'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    //   }
    // }, cb);
    // cb(start, end);

    tabel_list_eaf_lock_apv();
    tabel_list_eaf_lock_verif();
    tabel_list_eaf_lock_lpj1();
    tabel_list_eaf_lock_lpj2();

    // $('#btn_filter').click(function() {
    //   tabel_list_eaf($('input[name="datestart"]').val(), $('input[name="dateend"]').val())
    // });

    // $('#dt_list_eaf').on('click', '.detail_pengajuan', function() {
    //   id_pengajuan = $(this).data('id_pengajuan');

    //   $('#modal_detail_pengajuan').modal('show');

    //   $.ajax({
    //     url: '<?php echo base_url() ?>eaf/pengajuan/data_detail_pengajuan',
    //     type: 'POST',
    //     dataType: 'html',
    //     data: {
    //       id_pengajuan: id_pengajuan
    //     },
    //     success: function(data) {
    //       $('#data_detail_pengajuan').empty().append(data);
    //     }
    //   });

    // });


    
  });

  function tabel_list_eaf_lock_apv() {
      $('#tbl_list_eaf_lock_apv').DataTable({
        'destroy': true,
        'lengthChange': false,
        'searching': true,
        'info': true,
        'paging': true,
        "autoWidth": false,
        "dataSrc": "",
        "order": [
          [2, "desc"]
        ],
        "dom": 'Bfrtip',
        "buttons": [{
          extend: 'excelHtml5',
          text: 'Export to Excel',
          title: "Pengajuan EAF",
          footer: true
        }],
        "ajax": {
          "dataType": 'json',
          "type": "POST",
          "data": {

          },
          "url": "<?= base_url('eaf/lock/get_list_eaf_lock_apv') ?>",
        },
        "columns": [
          {
            "data": "name"
          },
          {
            "data": "status_lock",
            'render': function(data, type, row) {
              if (row['jumlah'] > 0) {
                return `<span class="badge bg-danger">${data}</span>`
              } else {                
                return `<span class="badge bg-success">${data}</span>`
              }
            }
          },
          {
            "data": "jumlah",
            'render': function(data, type, row) {
              if (data > 0) {
                return `<span class="badge bg-danger">${data}</span>`
              } else {                
                return `<span class="badge bg-success">${data}</span>`
              }
            }
          },
          {
            "data": "warning_lock"
          },
        ]

      });
  }

  function tabel_list_eaf_lock_verif() {
      $('#tbl_list_eaf_lock_verif').DataTable({
        'destroy': true,
        'lengthChange': false,
        'searching': true,
        'info': true,
        'paging': true,
        "autoWidth": false,
        "dataSrc": "",
        "order": [
          [2, "desc"]
        ],
        "dom": 'Bfrtip',
        "buttons": [{
          extend: 'excelHtml5',
          text: 'Export to Excel',
          title: "Pengajuan EAF",
          footer: true
        }],
        "ajax": {
          "dataType": 'json',
          "type": "POST",
          "data": {

          },
          "url": "<?= base_url('eaf/lock/get_list_eaf_lock_verif') ?>",
        },
        "columns": [
          {
            "data": "name"
          },
          {
            "data": "status_lock",
            'render': function(data, type, row) {
              if (row['jumlah'] > 0) {
                return `<span class="badge bg-danger">${data}</span>`
              } else {                
                return `<span class="badge bg-success">${data}</span>`
              }
            }
          },
          {
            "data": "jumlah",
            'render': function(data, type, row) {
              if (data > 0) {
                return `<span class="badge bg-danger">${data}</span>`
              } else {                
                return `<span class="badge bg-success">${data}</span>`
              }
            }
          },
          {
            "data": "warning_lock"
          },
        ]

      });
  }

  function tabel_list_eaf_lock_lpj1() {
      $('#tbl_list_eaf_lock_lpj1').DataTable({
        'destroy': true,
        'lengthChange': false,
        'searching': true,
        'info': true,
        'paging': true,
        "autoWidth": false,
        "dataSrc": "",
        "order": [
          [2, "desc"]
        ],
        "dom": 'Bfrtip',
        "buttons": [{
          extend: 'excelHtml5',
          text: 'Export to Excel',
          title: "Pengajuan EAF",
          footer: true
        }],
        "ajax": {
          "dataType": 'json',
          "type": "POST",
          "data": {

          },
          "url": "<?= base_url('eaf/lock/get_list_eaf_lock_lpj1') ?>",
        },
        "columns": [
          {
            "data": "name"
          },
          {
            "data": "status_lock",
            'render': function(data, type, row) {
              if (row['jumlah'] > 0) {
                return `<span class="badge bg-danger">${data}</span>`
              } else {                
                return `<span class="badge bg-success">${data}</span>`
              }
            }
          },
          {
            "data": "jumlah",
            'render': function(data, type, row) {
              if (data > 0) {
                return `<span class="badge bg-danger">${data}</span>`
              } else {                
                return `<span class="badge bg-success">${data}</span>`
              }
            }
          },
          {
            "data": "warning_lock"
          },
        ]

      });
  }

  function tabel_list_eaf_lock_lpj2() {
      $('#tbl_list_eaf_lock_lpj2').DataTable({
        'destroy': true,
        'lengthChange': false,
        'searching': true,
        'info': true,
        'paging': true,
        "autoWidth": false,
        "dataSrc": "",
        "order": [
          [2, "desc"]
        ],
        "dom": 'Bfrtip',
        "buttons": [{
          extend: 'excelHtml5',
          text: 'Export to Excel',
          title: "Pengajuan EAF",
          footer: true
        }],
        "ajax": {
          "dataType": 'json',
          "type": "POST",
          "data": {

          },
          "url": "<?= base_url('eaf/lock/get_list_eaf_lock_lpj2') ?>",
        },
        "columns": [
          {
            "data": "name"
          },
          {
            "data": "status_lock",
            'render': function(data, type, row) {
              if (row['jumlah'] > 0) {
                return `<span class="badge bg-danger">${data}</span>`
              } else {                
                return `<span class="badge bg-success">${data}</span>`
              }
            }
          },
          {
            "data": "jumlah",
            'render': function(data, type, row) {
              if (data > 0) {
                return `<span class="badge bg-danger">${data}</span>`
              } else {                
                return `<span class="badge bg-success">${data}</span>`
              }
            }
          },
          {
            "data": "warning_lock"
          },
        ]

      });
  }

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
    return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
  }

  function nominal(angka, id) {
    $(id).val(formatRupiah(angka, ''));
    company.setSelected('-- Pilih Company --');
    keperluan.setSelected('-- Pilih Keperluan --');

    console.info("nominal ubah called");
    console.info("nominal ubah called, angka value: " + angka);
    console.info("nominal ubah called, id value: " + id);

    company_value = $('#company').val();
    if(company_value == '-- Pilih Company --'){
      $('#keperluan').prop('disabled', true);
    }
    // company.val();
    console.info("nominal ubah called, company value: " + company_value);

    if ($(id).val() != '' && $(id).val() != null && $('#pengaju').val() != '-- Pilih Yang Mengajukan --') {
      $('#company').prop('disabled', false);
    } else {
      $('#company').prop('disabled', true);
    }
  }

</script>