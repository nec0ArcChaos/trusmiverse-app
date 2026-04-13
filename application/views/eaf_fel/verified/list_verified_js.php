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

    /*Range*/
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

    console.log(id_user);
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
      // "dom": 'Bfrtip',
			// buttons: [{
			// 	extend: 'excelHtml5',
			// 	text: 'Export to Excel',
			// 	title: "List Approval Finance",
			// 	footer: true
			// }],
      "ajax": {
        "dataType": 'json',
        "type": "POST",
        "data": {
          datestart: start,
          dateend: end,
          status: 'Approve'
        },
        "url": "<?= base_url('eaf/verified/get_list_approval') ?>"
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
            if (data.slice(0, 3) == 'EAF') {
              return `<a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="approval('${data}','${row['tgl_input']}','${row['name']}','${row['nama_divisi']}','${row['nama_kategori']}','${row['nama_penerima']}')">${data}</a>`
            } else {
              return `<a href="javascript:void(0)" class="btn btn-outline-primary btn-sm" onclick="approval_lpj('${data}','${row['tgl_input']}','${row['name']}','${row['nama_divisi']}','${row['nama_kategori']}','${row['nama_penerima']}')">${data}</a>`
            }
          }
        },
        {
          "data": "bud_company_name"
        },
        {
          "data": "tgl_input"
        },
        {
          "data": "nama_status",
          'render': function(data, type, row) {
            if ((row['temp'] != null || row['temp'] == '') && row['temp'].slice(0, 3) == "LPJ") {
              return `<span class="${row['warna']}">${data}</span>&nbsp<span class="label label-inverse-primary">` + row['temp'] + `</span>`
            } else {
              return `<span class="${row['warna']}">${data}</span>`
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
        }
      ]

    });
  }

  function approval(id, tgl, name, divisi, kategori, penerima) {
    // ,tipe, jenis, sisa, keperluan, note, nominal, id_appr, photo, biaya

    $.ajax ({
      method: "GET",
      url: "<?= base_url('eaf/verified/get_detail_list_approval/') ?>"+ id + "/" + 1,
      dataType: "JSON",
      success: function(res){
        console.log(res);
        $('#tipe').val(res.nama_tipe);
        $('#akun').text(res.nama_biaya);
        $('#keperluan').val(res.nama_keperluan);
        $('#note').val(res.note);
        $('#nominal_old').val(formatRupiah(res.nominal_uang));
        $('#rupiah').val(res.nominal_uang);
        if (res.id_tipe_biaya == 2 || res.id_tipe_biaya == 3) {
          $('#akun').text(res.nama_biaya);
          $('#sisa').text(`Sisa Budget : Rp. ${formatRupiah(res.budget)}`);
        } else {
          $('#akun_hide').empty();
          $('#sisa_hide').empty();
        }
        if (res.photo_acc == null) {
          $('#bukti').empty();
          $('#bukti').append('<a href="void:javacript(0)"><i class="bi-close"></i></a>');
        } else {
          $('#bukti').empty();
          $('#bukti').append('<a data-fancybox="gallery" href="<?= base_url('uploads/eaf/'); ?>' + res.photo_acc + '"> <i class="bi-image"></i></a>');
        }
      },
      error: function (jqXHR){
        console.log(jqXHR.responseText);
      }
    });

    $('#modal_approval').modal('show');
    $('#id_pengajuan').val('ID : ' + id);
    $('#id_pengajuan_hide').val(id);
    $('#tgl_input').val(tgl);
    $('#nama_pembuat').val(name);
    $('#divisi').val(divisi);
    $('#kategori').val(kategori);
    $('#penerima').val(penerima);
    
    tabel_tracking(id,'');
  }

  function approval_lpj(id, tgl, name, divisi, kategori, penerima) {
    // jenis, sisa, keperluan, note, nominal, id_appr, photo, biaya, flag_photo

    $.ajax ({
      method: "GET",
      url: "<?= base_url("eaf/verified/get_detail_list_approval/") ?>"+ id + "/" + 2,
      dataType: "JSON",
      success: function (res){
        console.log(res);
        if (res.id_tipe_biaya == 2 || res.id_tipe_biaya == 3) {
          sisa_new = formatRupiah(res.budget.toString());
        } else {
          sisa_new = '~';
        }
        $('#budget_lpj').val(formatRupiah(res.nominal_uang.toString()));
        $('#sisa_lpj').val(sisa_new);

        if (res.photo_acc == null) {
          $('#bukti_lpj').empty();
          $('#bukti_lpj').append('<a href="<?= base_url('eaf/verified/print_ba?id='); ?>' + id + '" target="_blank" title="Print BA"><i class="bi-printer"></i></a>');
        } else {
          $('#bukti_lpj').empty();
          $('#bukti_lpj').append('<a data-fancybox="gallery" href="<?= base_url('assets/uploads/eaf/'); ?>' + res.photo_acc + '"> <i class="bi-image"></i></a>');
        }
      },
      error: function (jqXHR){
        console.log(jqXHR.responseText);
      }
    });

    $('#modal_approval_lpj').modal('show');
    $('#id_pengajuan_lpj').val('ID : ' + id);
    $('#id_pengajuan_lpj_hide').val(id);

    $('#tgl_input_lpj').val(tgl);
    $('#nama_pembuat_lpj').val(name);
    $('#divisi_lpj').val(divisi);
    $('#kategori_lpj').val(kategori);
    $('#penerima_lpj').val(penerima);

    tabel_lpj(id);
    tabel_tracking(id,'_lpj');
  }

  function tabel_lpj(id) {
    $('#dt_lpj').DataTable({
      'destroy': true,
      'lengthChange': false,
      'searching': false,
      'info': false,
      'paging': false,
      "autoWidth": false,
      "dataSrc": "",
      "order": [
        [1, "desc"]
      ],
      "ajax": {
        "dataType": 'json',
        "type": "POST",
        "data": {
          id: id
        },
        "url": "<?= base_url('eaf/verified/get_lpj') ?>"
        // "success": function(data) {
        //   console.log(data.data);
        // },
        // "error": function(xhr, error, code) {
        //   console.log(xhr.responseText);
        // }
      },
      "columns": [{
          "data": "id_pengajuan"
        },
        {
          "data": "nama_lpj"
        },
        {
          "data": "note_lpj"
        },
        {
          "data": "total_pengajuan",
          "render": function(data, type, row) {
            return formatRupiah(data);
          }
        },
        {
          "data": "nominal_lpj",
          "render": function(data, type, row) {
            return formatRupiah(data);
          }
        },
        {
          "data": "sisa_lpj",
          "render": function(data, type, row) {
            return formatRupiah(data);
          }
        },
      ],
      "footerCallback": function(row, data, start, end, display) {
        var api = this.api();

        // Remove the formatting to get integer data for summation
        var intVal = function(i) {
          return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
        };

        // Total over all pages
        total = api
          .column(4)
          .data()
          .reduce(function(a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        // Update footer
        $(api.column(4).footer()).html(formatRupiah(total.toString()));
      },
      "initComplete": function(settings, json) {
        // console.log(json.data[0].sisa_lpj);
        $('#total_lpj').val(formatRupiah(json.data[0].sisa_lpj));
        $('#total_kep').val(formatRupiah(json.data[0].total_pengajuan));
      }
    });
  }

  function tabel_tracking(id,lpj) {
    id_dt = `#dt_tracking${lpj}`;
    $(id_dt).DataTable({
      'destroy': true,
      'lengthChange': false,
      'searching': false,
      'info': false,
      'paging': false,
      "autoWidth": false,
      "dataSrc": "",
      "order": [
        [1, "asc"]
      ],
      "ajax": {
        "dataType": 'json',
        "type": "POST",
        "data": {
          id: id
        },
        "url": "<?= base_url('eaf/verified/get_tracking') ?>"
        // "success": function(data) {
        //   console.log(data.data);
        // },
        // "error": function(xhr, error, code) {
        //   console.log(xhr.responseText);
        // }
      },
      "columns": [{
          "data": "employee_name"
        },
        {
          "data": "update_approve"
        },
        {
          "data": "status",
          'render': function(data, type, row) {
            if (data == 'Approve') {
              return `<span class=" badge badge-success">${data}</span>`
            } else if (data == 'Reject') {
              return `<span class=" badge badge-danger">${data}</span>`
            } else if (data == 'Revisi') {
              return `<span class=" badge badge-warning">${data}</span>`
            }
          }
        },
        {
          "data": "note_approve"
        }
      ]
    });
  }
</script>