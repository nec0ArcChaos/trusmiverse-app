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
    

    tabel_list_eaf();
    id_pengajuan = "<?php echo (isset($_GET['id_pengajuan'])) ? $_GET['id_pengajuan'] : '' ?>";
    if (id_pengajuan != "") {
      $.ajax({
        url: '<?php echo base_url() ?>eaf/approval/get_detail_approval/' + id_pengajuan,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          console.log(response)
          if (response.status == 1) {
            approval(response.id_pengajuan, response.tgl_input, response.name, response.admin_company_name, response.admin_dept_name, response.admin_desg_name, response.nama_divisi, response.nama_kategori, response.nama_tipe, response.nama_penerima, response.nama_biaya, response.budget, response.nama_keperluan, response.note, response.nominal_uang, response.id_approval, response.photo_acc, response.id_tipe_biaya, response.id_biaya)
          } else {
            approval_lpj(response.id_pengajuan, response.tgl_input, response.name, response.admin_company_name, response.admin_dept_name, response.admin_desg_name, response.nama_divisi, response.nama_kategori, response.nama_tipe, response.nama_penerima, response.nama_biaya, response.budget, response.nama_keperluan, response.note, response.nominal_uang, response.id_approval, response.photo_acc, response.id_tipe_biaya, response.id_biaya)
          }
        }
      });

    }
    $('#status').on('change', function() {
      if ($(this).val() == '2') {
        $(this).css('border-color', 'green');
        $('#btn_save').removeClass();
        $('#btn_save').addClass('btn btn-success');
        $('#btn_save').text('Approve');
      } else if ($(this).val() == '4') {
        $(this).css('border-color', 'red');
        $('#btn_save').removeClass();
        $('#btn_save').addClass('btn btn-danger');
        $('#btn_save').text('Reject');
      } else if ($(this).val() == '9') {
        $(this).css('border-color', 'orange');
        $('#btn_save').removeClass();
        $('#btn_save').addClass('btn btn-warning');
        $('#btn_save').text('Revisi');
      }
    });

    $('#status_lpj').on('change', function() {
      if ($(this).val() == '6') {
        $(this).css('border-color', 'green');
        $('#btn_save_lpj').removeClass();
        $('#btn_save_lpj').addClass('btn btn-success');
        $('#btn_save_lpj').text('Approve');
      } else if ($(this).val() == '4') {
        $(this).css('border-color', 'red');
        $('#btn_save_lpj').removeClass();
        $('#btn_save_lpj').addClass('btn btn-danger');
        $('#btn_save_lpj').text('Reject');
      }
    });

  });

  function formatNumber(num) {
      if (num == null) {
        return 0;
      } else {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
      }
  }

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
          datestart: null,
          dateend: null,
          status: "1,6"
        },
        "url": "<?= base_url('eaf/approval/get_list_eaf_my_approval') ?>"
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
            if (row['status'] == 1) {
              return `<a href="javascript:void(0)" class="btn btn-outline-primary btn-sm" onclick="approval('${data}','${row['tgl_input']}','${row['name']}','${row['adm_comp_name']}','${row['adm_dept_name']}','${row['adm_desg_name']}','${row['nama_divisi']}','${row['nama_kategori']}','${row['nama_tipe']}','${row['nama_penerima']}','${row['nama_biaya']}','${row['budget']}','${row['nama_keperluan']}','${row['note']}','${row['nominal_uang']}','${row['id_approval']}','${row['photo_acc']}','${row['id_tipe_biaya']}',${row['id_biaya']},'${row['id_user_verified']}','${row['note_approve']}')">${data}</a>`
            } else {
              return `<a href="javascript:void(0)" class="btn btn-outline-warning btn-sm" onclick="approval_lpj('${data}','${row['tgl_input']}','${row['name']}','${row['adm_comp_name']}','${row['adm_dept_name']}','${row['adm_desg_name']}','${row['nama_divisi']}','${row['nama_kategori']}','${row['nama_penerima']}','${row['nama_biaya']}','${row['budget']}','${row['nama_keperluan']}','${row['note']}','${row['nominal_uang']}','${row['id_approval']}','${row['photo_acc']}','${row['id_tipe_biaya']}')">${data}</a>`
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
            if (row['status'] == 1 || row['status'] == 2 || row['status'] == 9) {
              return `<span class=" badge bg-warning">${data}</span>`
            } else if (row['status'] == 6) {
              return `<span class=" badge bg-primary">${data}</span>`
            } else if (row['status'] == 4 || row['status'] == 5) {
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
              return formatRupiah(data);
           
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
    console.log("id_biaya : " +id_biaya);

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
    console.log(note,note_verified);
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

  function simpan_approve_lpj() {
    if ($('#status_lpj').val() == "0" || $('#status_lpj').val() == "" || $('#status_lpj').val() == null) {
      swal("Warning", "Option Approval belum terpilih!", "warning");
    } else {
      swal({
          title: "Anda yakin approve LPJ ini?",
          text: "Data tidak bisa ubah lagi",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: '<?php echo base_url() ?>eaf/approval/insert_approval_lpj',
              type: 'post',
              dataType: 'json',
              data: $('#form_approval_lpj').serialize(),
              success: function(response) {
                $('#form_approval_lpj')[0].reset();
                swal("Success", "Has Been Saved", "success")
                  .then((value) => {
                    $('#dt_list_eaf').DataTable().ajax.reload();
                    $('#modal_approval_lpj').modal('hide');
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

  function simpan_approve() {
    sisa    = $('#get_sisa').val();
    nominal = $('#rupiah').val().split('.').join('');
    if(parseInt(parseInt(nominal) > parseInt(sisa) && $('#status').val() == "2")){
      console.log("budget kurang")
    } else {
      console.log("budget cukup")
    }

    console.log(parseInt(nominal), parseInt(sisa));
    // console.log("id_pengajuan_hide : " + $('#id_pengajuan_hide').val());
    if ($('#status').val() == "0" || $('#status').val() == "" || $('#status').val() == null) {
      swal("Warning", "Option Approval belum terpilih!", "warning");
    } else if (parseInt(nominal) > parseInt(sisa) && $('#status').val() == "2") {
      swal({
        title: "Warning",
        text: "Budget tidak mencukupi, Hubungi Finance untuk penambahan budget.",
        icon: "warning",
        className : "text-center"
      });
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
              url: '<?php echo base_url() ?>eaf/approval/insert_approval',
              type: 'post',
              dataType: 'json',
              data: $('#form_approval').serialize(),
              success: function(response) {
                console.log(response);
                if (response.update_pengajuan == true) {
                  console.log(response.data);
                  console.log(response.data.no_eaf);
                  console.log(response.data.requested_contact);
                  icon_status = (response.data.status == 'Approve') ? '✅' : '❌';
                  msg = `💸 Alert!!! \n*Your Request EAF Has Been Processed* \n\nNo.EAF : ${response.data.no_eaf} \nType : ${response.data.type} \nNeed : *${$.trim(response.data.need)}* \nDescription : ${$.trim(response.data.description)} \n💵 Amount : *Rp. ${formatRupiah(response.data.amount,'')},-* \n\nStatus : *${response.data.status}* ${icon_status} \nNote : ${response.data.note} \n\n📝Approve To : ${response.data.approve_to} \n👤Requested By : ${response.data.requested_by} \n🕐Approved At : ${response.data.approved_at}`;
                  console.log(msg);
                  // if (id_user == 1) {
                    // list_phone = ['08993036965'];
                  //   list_phone = ['087829828061'];
                  // } else {
                    list_phone = [response.data.requested_contact.toString()];
                    // list_phone = ['087829828061'];

                  // }
                  // list_phone  = ['08993036965','081214926060'];
                  // send_wa_trusmi(list_phone, msg);

                  // Kirim ke Nomor Collect Trusmiland
                  send_wa_trusmi(list_phone, msg, "2308388562");
                  $('#form_approval')[0].reset();
                  swal("Success", "Has Been Saved", "success")
                  .then((value) => {
                    $('#dt_list_eaf').DataTable().ajax.reload();
                    $('#modal_approval').modal('hide');
                  });                  
                } else {
                  console.log("warning : ",response.warning);
                  swal("Warning", `${response.warning}`, "warning");
                }
              },
              error: function(xhr, error, code) {
                console.log(xhr.responseText);
              }
            });
          }
        });
    }
  }

  // onclick="approval_lpj('${data}','${row['tgl_input']}','${row['name']}','${row['adm_comp_name']}','${row['adm_dept_name']}','${row['adm_desg_name']}','${row['nama_divisi']}','${row['nama_kategori']}','${row['nama_penerima']}','${row['nama_biaya']}','${row['budget']}','${row['nama_keperluan']}','${row['note']}','${row['nominal_uang']}','${row['id_approval']}','${row['photo_acc']}','${row['id_tipe_biaya']}')">${data}</a>`

  function approval_lpj(id, tgl, name, adm_comp_name, adm_dept_name, adm_desg_name, divisi, kategori, penerima, jenis, sisa, keperluan, note, nominal, id_appr, photo, biaya) {
    console.info("== START mdl approval_lpj call");


    console.info("tgl : " + tgl);
    console.info("name : " + name);
    console.info("divisi : " + divisi);

    console.info("kategori : " + kategori);
    console.info("penerima : " + penerima);
    console.info("jenis : " + jenis);
    console.info("sisa : " + sisa);
    console.info("keperluan : " + keperluan);
    console.info("note : " + note);

    console.info("nominal : " + nominal);
    console.info("id_appr : " + id_appr);

    console.info("photo : " + photo);
    console.info("biaya : " + biaya);

    console.info("== END mdl approval_lpj call");
    


    $('#modal_approval_lpj').modal('show');
    $('#id_pengajuan_lpj').val('ID : ' + id);
    $('#id_pengajuan_lpj_hide').val(id);
    $('#id_approval_lpj_hide').val(id_appr);

    $('#tgl_input_lpj').val(tgl);
    $('#nama_pembuat_lpj').val(name);
    $('#divisi_lpj').val(adm_dept_name);
    $('#kategori_lpj').val(kategori);
    $('#penerima_lpj').val(penerima);
    if (photo == 'null') {
      $('#bukti_lpj').empty();
      $('#bukti_lpj').append('<a href="<?= base_url('eaf/approval/print_ba?id='); ?>' + id + '" target="_blank" title="Print BA"><i class="bi-printer"></i></a>');
    } else {
      $('#bukti_lpj').empty();
      $('#bukti_lpj').append('<a data-fancybox="gallery" href="<?= base_url('uploads/eaf/'); ?>' + photo + '"> <i class="bi-image"></i></a>');
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
        "url": "<?= base_url('eaf/approval/get_lpj') ?>"
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
    });
  }
</script>