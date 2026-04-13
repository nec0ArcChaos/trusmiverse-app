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
      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
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
			buttons: [
        {
          extend: 'excelHtml5',
          text: 'Export to Excel',
          title: "List Approval Finance",
          footer: true
        }
      ],
      "ajax": {
        "dataType": 'json',
        "type": "POST",
        "data": {
          datestart: start,
          dateend: end,
          status: 'Reject'
        },
        "url": "<?= base_url('eaf/finance/get_list_approval') ?>"
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

            if (data.slice(0,3) == 'EAF') {
              return `<a href="javascript:void(0)" class="badge bg-primary" onclick="approval('${data}','${row['tgl_input']}','${row['name']}','${row['admin_company_name']}','${row['admin_dept_name']}','${row['admin_desg_name']}','${row['nama_divisi']}','${row['nama_kategori']}','${row['nama_penerima']}')">${data}</a><a target="_blank" href="<?= base_url() ?>eaf/finance/save_pengajuan/${data}/${row['id_kategori']}/${row['flag']}" class="label label-info"><i class="ti-printer"></i></a>`
            } else {
              return `<a href="javascript:void(0)" class="badge custom-bg-outline-primary" onclick="approval_lpj('${data}','${row['tgl_input']}','${row['admin_company_name']}','${row['admin_dept_name']}','${row['admin_desg_name']}','${row['name']}','${row['nama_divisi']}','${row['nama_kategori']}','${row['nama_penerima']}')">${data}</a><a target="_blank" href="<?= base_url() ?>eaf/finance/save_pengajuan/${data}/${row['id_kategori']}/${row['flag']}" class="label label-info"><i class="ti-printer"></i></a>`
            }
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

            if ((row['temp'] != null || row['temp'] == '') && row['temp'].slice(0, 3) == "LPJ") {
              return `<span class="${row['warna']}">${data}</span>&nbsp<span class="badge custom-bg-outline-primary">` + row['temp'] + `</span>`
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
          "data": "pengaju_comp_name"
        },
        {
          "data": "pengaju_dept_name"
        },
        {
          "data": "pengaju_desg_name"
        },
        // Persiapan untuk Edit Blok
        {
          "data": "nama_keperluan",
          "render": function (data, type, row){
            // if (((row['temp'] != null || row['temp'] == '') && row['temp'].slice(0, 3) == "LPJ") || row['blok'] == ''){
              return data;
            // } else {
              // return `<span class="label label-warning edit_blok" data-id_pengajuan="${row['id_pengajuan']}" style="cursor:pointer;" title="Edit Blok"><i class="fa fa-pencil"></i></span>${data}`;
            // }
          }
        },

        // {
        //   "data": "nama_divisi"
        // },
        {
          "data": "name"
        },
      ]

    });
  }

  function approval(id, tgl, name, admin_company_name, admin_dept_name, admin_desg_name, divisi, kategori, penerima, status) {
    // ,tipe, jenis, sisa, keperluan, note, nominal, id_appr, photo, biaya

    $.ajax ({
      method: "GET",
      url: "<?= base_url('eaf/finance/get_detail_list_approval/') ?>"+ id + "/" + 1,
      dataType: "JSON",
      success: function(res){
        console.log(res);
        $('#tipe').val(res.nama_tipe);
        $('#akun').text(res.nama_biaya);
        $('#keperluan').val(res.nama_keperluan);
        $('#note').val(res.note);
        $('#nominal_old').val(formatRupiah(res.nominal_uang));
        $('#rupiah').val(res.nominal_uang);
        $('#id_biaya').val(res.id_biaya);
        if (res.id_tipe_biaya == 2 || res.id_tipe_biaya == 3) {
          $('#akun').text(res.nama_biaya);
          $('#sisa').text(`Sisa Budget : Rp. ${formatRupiah(res.budget)}`);
        } else {
          $('#akun_hide').empty();
          $('#sisa_hide').empty();
        }
        console.log(res.photo_acc);
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
    if((id_user == 1 || id_user == 162 || id_user == 188) && status == 3){
      const form_reject = document.getElementById('form_reject');
      form_reject.style.display = 'block';
    } else {
      form_reject.style.display = 'none';
    }
    $('#id_pengajuan').val('ID : ' + id);
    $('#id_pengajuan_hide').val(id);
    $('#tgl_input').val(tgl);
    $('#nama_pembuat').val(name);
    $('#divisi').val(divisi);
    $('#kategori').val(kategori);
    $('#penerima').val(penerima);
    
    tabel_tracking(id,'');

    $('#admin_company_name').val(admin_company_name);
    $('#admin_dept_name').val(admin_dept_name);

  }

  function approval_lpj(id, tgl, name, admin_company_name, admin_dept_name, admin_desg_name, divisi, kategori, penerima) {
    // jenis, sisa, keperluan, note, nominal, id_appr, photo, biaya, flag_photo

    $.ajax ({
      method: "GET",
      url: "<?= base_url("eaf/finance/get_detail_list_approval/") ?>"+ id + "/" + 2,
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

        console.log(res.photo_acc);
        if (res.photo_acc == null) {
          $('#bukti_lpj').empty();
          $('#bukti_lpj').append('<a href="<?= base_url('eaf/finance/print_ba?id='); ?>' + id + '" target="_blank" title="Print BA"><i class="bi-printer"></i></a>');
        } else {
          $('#bukti_lpj').empty();
          $('#bukti_lpj').append('<a data-fancybox="gallery" href="<?= base_url('uploads/eaf/'); ?>' + res.photo_acc + '"> <i class="bi-image"></i></a>');
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

    $('#admin_company_name_lpj').val(admin_company_name);
    $('#admin_dept_name_lpj').val(admin_dept_name);
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
        "url": "<?= base_url('eaf/finance/get_tracking') ?>"
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
              return `<span class=" badge bg-success">${data}</span>`
            } else if (data == 'Reject') {
              return `<span class=" badge bg-danger">${data}</span>`
            } else if (data == 'Revisi') {
              return `<span class=" badge bg-warning">${data}</span>`
            } else if (data == 'Konfirmasi') {
              return `<span class=" badge bg-warning">${data}</span>`
            }
          }
        },
        {
          "data": "note_approve"
        }
      ]
    });
  }

  function reject() {
      swal({
        title: "Anda yakin cancel pengajuan ini?",
        text: "Data tidak bisa ubah lagi",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: '<?php echo base_url() ?>eaf/finance/insert_app_reject',
            type: 'post',
            dataType: 'json',
            data: $('#form_approval').serialize(),
            success: function(response) {
              console.log(response);
              // console.log(response.data);
              // console.log(response.data.no_eaf);
              // console.log(response.data.requested_contact);
              // msg = `💸 Alert!!! \n*Your Request EAF Has Been Cancelled* \n\nNo.EAF : ${response.data.no_eaf} \nType : ${response.data.type} \nNeed : *${$.trim(response.data.need)}* \nDescription : ${$.trim(response.data.description)} \n💵 Amount : *Rp. ${formatRupiah(response.data.amount,'')},-* \n\nStatus : *Cancel by Finance* \nNote : ${response.data.note} \n\n👤Requested By : ${response.data.requested_by} \n🕐Cancel At : ${response.data.approved_at}`;
              // console.log(msg);
              // if (id_user == 1) {
              //   list_phone  = ['08993036965'];
              // } else {
              //   list_phone  = ['08993036965', response.data.requested_contact.toString()];
              // }
              //   // list_phone  = ['08993036965','081214926060'];
              // send_wa_trusmi(list_phone,msg);
              swal("Success", "Has Been Cancelled", "success")
              .then((value) => {
                $('#modal_approval').modal('hide');
                $('#dt_list_eaf').DataTable().ajax.reload();
              })
            },
            error: function(xhr, error, code) {
              console.log(xhr.responseText);
            }
          });
        }
      });
  }
</script>