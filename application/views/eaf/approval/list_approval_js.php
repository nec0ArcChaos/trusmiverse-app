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

   


  });


    function formatNumber(num) {
        if (num == null) {
            return 0;
        } else {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        }
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
      "dom": 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        text: 'Export to Excel',
        footer: true,
        className: 'exportExcel',
        // customize: function (xlsx) {
            
        //     var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            
        // //         // Hapus titik pemisah ribuan di kolom kedua (Price)
        //         $('row c[r^="E"] t', sheet).each(function () {
        //             var cellValue = $(this).text();
        //             if (cellValue && !isNaN(cellValue.replace(/\./g, '').replace(/,/g, '.'))) {
        //                 // Ganti titik menjadi koma
        //                 $(this).text(cellValue.replace(/\./g, ','));
        //             }
        //         });
        // }
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
          "data": "company_kode"
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
          "data": "nominal_uang",
          "render": function(data, type, row) {
              return formatNumber(data);
           
          }
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

  function approval(id, tgl, name, adm_cn, adm_dn, adm_dsn, divisi, kategori, tipe, penerima, jenis, sisa, keperluan, note, nominal, id_appr, photo, biaya, id_biaya, id_user_verified, note_verified) {

    tabel_history(id_biaya);
    $('#modal_approval').modal('show');
    $('#id_pengajuan').val('ID : ' + id);
    $('#id_pengajuan_hide').val(id);
    $('#id_approval_hide').val(id_appr);
    $('#tgl_input').val(tgl);
    $('#nama_pembuat').val(name);
    $('#divisi').val(divisi);
    $('#kategori').val(kategori);
    $('#tipe').val(tipe);
    $('#penerima').val(penerima);
    $('#keperluan').val(keperluan);
    $('#note').val(note);
    $('#note_verified').val(note_verified);
    $('#get_sisa').val(sisa);
    $('#nominal_old').val(formatRupiah(nominal));
    $('#rupiah').val(formatRupiah(nominal));
    if (biaya == 2 || biaya == 3) {
      $('#akun').text(jenis);
      $('#sisa').text(`Sisa Budget : Rp. ${formatRupiah(sisa)}`);
    } else {
      $('#akun_hide').empty();
      $('#sisa_hide').empty();
    }
    if (photo == 'null') {
      $('#bukti').empty();
      $('#bukti').append('<a href="void:javacript(0)"><i class="bi-close"></i></a>');
    } else if (photo == 'ba') {
      $('#bukti').empty();
      $('#bukti').append('<a href="<?php echo base_url() ?>eaf/finance/print_ba_reimburse?id=' + id + '" target="_blank" title="Print BA"><i class="bi-printer"></i></a>');
    } else {
      $('#bukti').empty();
      $('#bukti').append('<a data-fancybox="gallery" href="<?= base_url('uploads/eaf/'); ?>' + photo + '"> <i class="bi-image"></i></a>');
    }
    console.log(id_user_verified);
    if (id_user_verified != null) {
      $("#status option[value='9']").hide();
    } else {
      $("#status option[value='9']").show();
    }

    $('#admin_company_name').val(adm_cn);
    $('#admin_department_name').val(adm_dn);
    $('#admin_designation_name').val(adm_dsn);

  }

  function tabel_history(id) {
    $('#dt_history').DataTable({
      'destroy': true,
      'lengthChange': false,
      'searching': true,
      'info': true,
      'paging': true,
      "autoWidth": false,
      "dataSrc": "",
      "order": [
        [0, "asc"]
      ],
      "ajax": {
        "dataType": 'json',
        "type": "POST",
        "data": {
          id_biaya: id
        },
        "url": "<?= base_url('eaf/approval/get_history') ?>",
        // "success": function(data) {
        //   console.log(data);
        // },
        // "error": function(xhr, error, code) {
        //   console.log(xhr.responseText);
        // }
      },
      "columns": [{
          "data": "id_pengajuan"
        },
        {
          "data": "nama_kategori"
        },
        {
          "data": "nama_penerima"
        },
        {
          "data": "nama_keperluan"
        },
        {
          "data": "tgl_approve"
        },
        {
          "data": "status_lpj",
          'render': function(data, type, row) {
            if (data == 'Tidak LPJ') {
              return `<span class=" badge bg-primary">${data}</span>`
            } else if (data == 'Sudah LPJ') {
              return `<span class=" badge bg-success">${data}</span>`
            } else {
              return `<span class=" badge bg-danger">${data}</span>`
            }
          }
        },
        {
          "data": "total_pengajuan"
        },
      ]

    });
  }
</script>