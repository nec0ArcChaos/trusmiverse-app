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

    $('#tgl_datang_rev').datetimepicker({
      dateFormat: 'yy-mm-dd',
      timeFormat: 'HH:mm:ss',
    });

    $("#periode_termin").datepicker({
      format: "yyyy-mm",
      startView: "months",
      minViewMode: "months"
    });

    id_user = <?= $this->session->userdata('user_id'); ?>;
    console.log(id_user);

    function formatNumber(num) {
      if (num == null) {
        return 0;
      } else {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
      }
    }
    tabel_list_eaf();
    $('#status').on('change', function() {
      if ($(this).val() == '1') {
        $(this).css('border-color', 'green');
        $('#btn_save').removeClass();
        $('#btn_save').addClass('btn btn-success');
        $('#btn_save').text('Approve');
      } else if ($(this).val() == '11') {
        $(this).css('border-color', 'red');
        $('#btn_save').removeClass();
        $('#btn_save').addClass('btn btn-danger');
        $('#btn_save').text('Reject');
      } else if ($(this).val() == '12') {
        $(this).css('border-color', 'orange');
        $('#btn_save').removeClass();
        $('#btn_save').addClass('btn btn-warning');
        $('#btn_save').text('Revisi');
      }
    });
  });

  function tabel_list_eaf() {
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
          datestart: null,
          dateend: null,
          status: 10
        },
        "url": "<?= base_url('eaf/verified/get_list_my_approval') ?>"
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
            if (row['status'] == 10) {
              return `<a href="javascript:void(0)" class="btn btn-outline-primary btn-sm" onclick="verified('${data}','${row['tgl_input']}','${row['name']}','${row['nama_divisi']}','${row['nama_kategori']}','${row['nama_tipe']}','${row['nama_penerima']}','${row['nama_keperluan']}','${row['note']}','${row['nominal_uang']}','${row['photo']}','${row['jumlah_termin']}','${row['nominal_termin']}')">${data}</a>`
            } else {
              return `<a href="javascript:void(0)" class="btn btn-outline-warning btn-sm" onclick="verified_lpj('${data}','${row['tgl_input']}','${row['name']}','${row['nama_divisi']}','${row['nama_kategori']}','${row['nama_penerima']}','${row['photo']}')">${data}</a>`
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
            return `<span class=" ${row['warna']}">${data}</span>`
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
        },
        {
          "data": "leadtime"
        },
      ]

    });
  }

  function verified(id, tgl, name, divisi, kategori, tipe, penerima, keperluan, note, nominal, photo, jumlah_termin, nominal_termin) {
    $('#modal_verified').modal('show');
    $('#id_pengajuan').val('ID : ' + id);
    $('#id_pengajuan_hide').val(id);
    $('#tgl_input').val(tgl);
    $('#nama_pembuat').val(name);
    $('#divisi').val(divisi);
    $('#kategori').val(kategori);
    $('#tipe').val(tipe);
    $('#penerima').val(penerima);
    if (photo == 'null') {
      $('#bukti').empty();
      $('#bukti').append('<a href="void:javacript(0)"><i class="ti-close"></i></a>');
    } else if (photo == 'ba') {
      $('#bukti').empty();
      $('#bukti').append('<a href="<?php echo base_url() ?>eaf/finance/print_ba_reimburse?id=' + id + '" target="_blank" title="Print BA"><i class="ti-printer"></i></a>');
    } else {
      $('#bukti').empty();
      $('#bukti').append('<a data-fancybox="gallery" href="<?= base_url('uploads/eaf/'); ?>' + photo + '"> <i class="bi-image"></i></a>');
    }

    $('#keperluan').val(keperluan);
    $('#note').val(note);
    $('#nominal_old').val(formatRupiah(nominal));
    $('#rupiah').val(formatRupiah(nominal));

    detail_verified(id);
    dlk(id);

    // console.log(jumlah_termin,nominal_termin);

    if (kategori == "Pinjaman Karyawan (CR)") {
      $("#id_kategori").val(20);
      $(".pinjaman_karyawan").show();
      $('#jumlah_termin').val(jumlah_termin);
      $('#nominal_termin').val(formatRupiah(nominal_termin));
    } else {
      $(".pinjaman_karyawan").hide();
    }
  }

  function detail_verified(id) {
    $.ajax({
      url: "<?= base_url('eaf/verified/get_detail_verified/') ?>" + id,
      method: "GET",
      dataType: "JSON",
      success: function(res) {
        console.log(res);
        data = res[0];

        // jenis, sisa, id_appr, biaya, id_biaya, id_user_approval
        $('#id_approval_hide').val(data.id_approval);
        $('#id_user_approval_hide').val(data.id_user_approval);
        $('#get_sisa').val(data.sisa_budget);
        if (data.id_tipe_biaya == 2 || data.id_tipe_biaya == 3) {
          $('#akun').text(data.jenis);
          $('#sisa').text(`Sisa Budget : Rp. ${formatRupiah(data.sisa_budget)}`);
        } else {
          $('#akun').text('');
          $('#sisa').text('');
        }

        tabel_history(data.id_biaya);
      },
      error: function(xhr) {
        console.log(xhr.responseText);
      }
    });
  }

  function dlk(id) {
    $.ajax({
      url: "<?= base_url('eaf/verified/get_detail_dlk/') ?>" + id,
      method: "GET",
      dataType: "JSON",
      success: function(res) {
        console.log(res);
        if (res.leave_id != 0) {
          $('.hidden_dlk').show();
          $('#tgl_dlk').val(res.tgl_dlk);
        } else {
          $('.hidden_dlk').hide();
          $('#tgl_dlk').val('');
        }
      },
      error: function(xhr) {
        console.log(xhr.responseText);
      }
    });
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
        "url": "<?= base_url('eaf/verified/get_history') ?>",
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
              return `<span class=" badge badge-primary">${data}</span>`
            } else if (data == 'Sudah LPJ') {
              return `<span class=" badge badge-success">${data}</span>`
            } else {
              return `<span class=" badge badge-danger">${data}</span>`
            }
          }
        },
        {
          "data": "total_pengajuan"
        },
      ]

    });
  }

  function simpan_approve() {
    sisa = $('#get_sisa').val();
    nominal = $('#rupiah').val().split('.').join('');
    status_ap = $(".modal.show").find('select[name="status"]').val();
    if (status_ap == "0" || status_ap == "" || status_ap == null) {
      swal("Warning", "Option Approval belum terpilih!", "warning");
    } else if (parseInt(nominal) > parseInt(sisa) && $('#status').val() == "2") {
      swal("Warning", "Nominal Subtotal melebihi Sisa Budget!", "warning");
    } else {
      swal({
          title: "Anda yakin approve pengajuan ini?",
          text: "Data tidak bisa ubah lagi",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: '<?php echo base_url() ?>eaf/verified/insert_approval',
              type: 'post',
              dataType: 'json',
              data: $('#form_verified').serialize(),
              success: function(response) {
                // console.log(response);
                // console.log(response.stat);
                // console.log(response.data);
                // console.log(response.wa_pengaju);
                if (response.stat == 1) {
                  // console.log(response.data.no_eaf);
                  // console.log(response.data.approve_contact);
                  jns = "";
                  // if (response.data.id_jenis == 711) {
                  //   jns = `\nKota : ${response.data.city}`;
                  // }
                  sisa_budget = (response.data.remaining_budget == '~') ? 'Unlimited' : `Rp. ${formatRupiah(response.data.remaining_budget)},-`;
                  msg = `💸 Alert Trusmiverse!!! \n*There is New Request EAF Approval, has been Verified* \n\nNo.EAF : ${response.data.no_eaf} \nType : ${response.data.type} \nNeed : *${$.trim(response.data.need)}* ${jns} \nDescription : ${$.trim(response.data.description)} \n💵 Amount : *Rp. ${formatRupiah(response.data.amount,'')},-* \n\n🧮Remaining Budget : *${sisa_budget}* \n\n📝Approve To : ${response.data.approve_to} \n👤Verified By : ${response.data.verified_by} \n👤Requested By : ${response.data.requested_by} \n🕐Requested At : ${response.data.requested_at} \n🔗Link Approve : https://trusmicorp.com/rspproject/login?id=1&key=${response.data.no_eaf}`;
                  console.log(msg);
                  if (id_user == 1) {
                    // list_phone  = ['08993036965'];
                    list_phone = ['087829828061'];
                  } else {
                    list_phone = [response.data.approve_contact];
                    // list_phone  = ['087829828061'];

                  }
                  // send_wa_trusmi(list_phone, msg);                  

                  // Kirim ke Nomor Collect Trusmiland
                  send_wa_trusmi(list_phone, msg, "2308388562");
                }
                $('#form_verified')[0].reset();
                swal("Success", "Has Been Saved", "success")
                  .then((value) => {
                    $('#dt_list_eaf').DataTable().ajax.reload();
                    $('#modal_verified').modal('hide');
                  });
                send_wa_pengaju(response.wa_pengaju);
              },
              error: function(xhr, error, code) {
                console.log(xhr.responseText);
              }
            });
          }
        });
    }
  }

  function send_wa_pengaju(dt) {
    if (dt.status == 'Approve') {
      icon_status = '✅';
    } else if (dt.status == 'Revisi') {
      icon_status = '↩️';
    } else {
      icon_status = '❌';
    }
    msg = `💸 Alert Trusmiverse!!! \n*Your Request EAF Has Been Verified*\nNo.EAF : ${dt.no_eaf} \nType : ${dt.type} \nNeed : *${$.trim(dt.need)}* \nDescription : ${$.trim(dt.description)} \n💵 Amount : *Rp. ${formatRupiah(dt.amount,'')},-* \n\nStatus : *${dt.status}* ${icon_status} \nNote : ${dt.note} \n\n📝Verified By : ${dt.verified_by} \n👤Requested By : ${dt.requested_by} \n🕐Verified At : ${dt.verified_at}`;
    console.log(msg);

    if (id_user == 1) {
      // list_phone  = ['08993036965'];
      list_phone = ['087829828061'];
    } else {
      list_phone = [dt.requested_contact];
      // list_phone  = ['087829828061'];
    }

    // send_wa_trusmi(list_phone, msg);

    // Kirim ke Nomor Collect Trusmiland
    send_wa_trusmi(list_phone, msg, "2308388562");
  }

  // Proses LPJ
  function verified_lpj(id, tgl, name, divisi, kategori, penerima, photo) {
    $('#modal_verified_lpj').modal('show');
    $('#id_pengajuan_lpj').val('ID : ' + id);
    $('#id_pengajuan_lpj_hide').val(id);

    // $('#id_approval_lpj_hide').val(id_appr);
    $('#tgl_input_lpj').val(tgl);
    $('#nama_pembuat_lpj').val(name);
    $('#divisi_lpj').val(divisi);
    $('#kategori_lpj').val(kategori);
    $('#penerima_lpj').val(penerima);

    if (photo == 'null') {
      $('#bukti_lpj').empty();
      $('#bukti_lpj').append('<a href="<?= base_url('eaf/verified/print_ba?id='); ?>' + id + '" target="_blank" title="Print BA"><i class="ti-printer"></i></a>');
    } else {
      $('#bukti_lpj').empty();
      $('#bukti_lpj').append('<a data-fancybox="gallery" href="<?= base_url('assets/uploads/eaf/'); ?>' + photo + '"> <i class="ti-image"></i></a>');
    }
    tabel_lpj(id);
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
        $("#nominal_lpj_rev").val(formatRupiah(json.data[0].nominal_lpj));
        $("#id_user_approval_lpj_hide").val(json.data[0].id_user_approval);
        $("#pengaju_lpj").val(json.data[0].employee_name);
        $("#tgl_awal").val(json.data[0].awal);
        $("#tgl_akhir").val(json.data[0].akhir);
        $("#tgl_datang_rev").val(json.data[0].akhir);
      }
    });
  }

  function simpan_verified_lpj() {
    if ($('#status_lpj').val() == "0" || $('#status_lpj').val() == "" || $('#status_lpj').val() == null) {
      swal("Warning", "Option Approval belum terpilih!", "warning");
    } else {
      swal({
        title: "Anda yakin verifikasi LPJ ini?",
        text: "Data tidak bisa ubah lagi",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: '<?php echo base_url() ?>eaf/verified/insert_verified_lpj',
            type: 'post',
            dataType: 'json',
            data: $('#form_verified_lpj').serialize(),
            success: function(response) {
              $('#form_verified_lpj')[0].reset();
              swal("Success", "Has Been Saved", "success")
              .then((value) => {
                $('#dt_list_eaf').DataTable().ajax.reload();
                $('#modal_verified_lpj').modal('hide');
              })
            },
            error: function(xhr, error, code) {
              console.log(xhr.responseText);
            }
          });
        }
      });
    }
  }
</script>