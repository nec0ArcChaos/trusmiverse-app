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

<link href="<?= base_url(); ?>assets/jquery-timepicker/jquery.timepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/jquery-timepicker/jquery.timepicker.min.js" type="text/javascript"></script>

<!-- Datetimepicker Full -->
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript">
  // var table_ajax;

  $(document).ready(function() {
    id_user = <?= $this->session->userdata('user_id'); ?>;

    var start = moment().startOf('month');
    var end = moment().endOf('month');
    function cb(start, end) {
      $('#reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="datestart"]').val(start.format('YYYY-MM-DD'));
      $('input[name="dateend"]').val(end.format('YYYY-MM-DD'));
    }

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
    tabel_list_eaf(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
    
    $('#btn_filter').click(function() {
      tabel_list_eaf($('input[name="datestart"]').val(), $('input[name="dateend"]').val())
    });

    function formatNumber(num) {
      if (num == null) {
        return 0;
      } else {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
      }
    }


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
      "dom": 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        text: 'Export to Excel',
        footer: true
      }],
      "ajax": {
        "dataType": 'json',
        "type": "POST",
        "data": {
          datestart : start,
          dateend : end,
          status: "2"
        },
        "url": "<?= base_url('eaf/approval/get_list_eaf_all') ?>"
        // "success": function(data) {
        //   console.log(data.data);
        // },
        // "error": function(xhr, error, code) {
        //   console.log(xhr.responseText);
        // }
      },
      "columns": [{
          "data": "id_pengajuan",
          "render": function(data, type, row) {
              return `<a href="javascript:void(0)" class="btn btn-outline-primary btn-sm" onclick="approval('${data}','${row['tgl_input']}','${row['name']}','${row['adm_comp_name']}','${row['adm_dept_name']}','${row['adm_desg_name']}','${row['nama_divisi']}','${row['nama_kategori']}','${row['nama_tipe']}','${row['nama_penerima']}','${row['nama_biaya']}','${row['budget']}','${row['nama_keperluan']}','${row['note']}','${row['nominal_uang']}','${row['id_approval']}','${row['photo_acc']}','${row['id_tipe_biaya']}',${row['id_biaya']},'${row['id_user_verified']}','${row['note_approve']}')">${data}</a>`
          }
        },
        {
          "data": "tgl_input"
        },
        {
          "data": "nama_status",
          'render': function(data, type, row) {


            if (row['status'] == 1 || row['status'] == 2 || row['status'] == 6 || row['status'] == 9 ) {
              return `<span class=" badge bg-warning">${data}</span>`
            } else if (row['status'] == 4 || row['status'] == 5 ) {
              return `<span class=" badge bg-danger">${data}</span>`
            } else {
              if ((row['temp'] != null || row['temp'] == '') && row['temp'].slice(0, 3) == "LPJ") {
                return `<span class=" badge bg-success">${data}</span>&nbsp<span class="badge custom-bg-outline-primary">` + row['temp'] + `</span>`
              } else {
                return `<span class=" badge bg-success">${data}</span>`
              }
            }
          }
        },
        {
          "data": "user_approval"
        },
        {
          "data": "nama_penerima"
        },
        {
          "data": "pengaju"
        },
        {
          "data": "company_name"
        },
        {
          "data": "department_name"
        },
        {
          "data": "designation_name"
        },
        {
          "data": "nama_kategori"
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
        {
          "data": "leadtime"
        },
      ]

    });
  }

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
            return '<span class="btn btn-outline-primary btn-sm detail_pengajuan" data-id_pengajuan="'+ data +'" style="cursor : pointer;">'+ data +'</span>'
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
                return `<span class="${row['warna']}">${data}</span>&nbsp<span class="badge custom-bg-outline-primary">` + row['temp'] + `</span>`
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
              return `<span class="text-danger f-w-600"> ${data} </span> <a href="<?php echo base_url() ?>print_ba/data_print_ba/${row['id_pengajuan']}" target="_blank" class="badge bg-danger" style="cursor : pointer;"><i class="icofont icofont-printer"></i></a>`
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
</script>