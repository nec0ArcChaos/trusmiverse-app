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

    tabel_list_eaf();

    $('#status').on('change', function() {
      if ($(this).val() == '3') {
        $(this).css('border-color', 'green');
        $('#btn_save').removeClass();
        $('#btn_save').addClass('btn btn-success');
        $('#btn_save').text('Approve');
      } else if ($(this).val() == '5') {
        $(this).css('border-color', 'red');
        $('#btn_save').removeClass();
        $('#btn_save').addClass('btn btn-danger');
        $('#btn_save').text('Reject');
      }
    });

    $('#status_lpj').on('change', function() {
      if ($(this).val() == '7') {
        $(this).css('border-color', 'green');
        $('#btn_save_lpj').removeClass();
        $('#btn_save_lpj').addClass('btn btn-success');
        $('#btn_save_lpj').text('Approve');
      } else if ($(this).val() == '5') {
        $(this).css('border-color', 'red');
        $('#btn_save_lpj').removeClass();
        $('#btn_save_lpj').addClass('btn btn-danger');
        $('#btn_save_lpj').text('Reject');
      }
    });

    $('#biaya').on('change', function() {
      value = ($(this).val() == null ? '2|2|' : $(this).val());
      data = value.split('|');
      console.log(data[0] + ',' + data[1] + ',' + data[2]);
      tabel_history(data[0]);
      // get_subbiaya(data[1]);
      if (data[2] == '') {
        budget = '~';
      } else {
        budget = formatRupiah(data[2]);
        if (data[2].charAt(0) == '-') {
          budget = `-${formatRupiah(data[2],'')}`;
        }
      }
      $('#budget').val(budget);
      pengajuan = $('#get_nominal').val();
      $('#pengajuan').val(formatRupiah(pengajuan));
      if (budget == '~') {
        sisa_new = '~';
      } else {
        sisa = parseInt(data[2]) - parseInt(pengajuan);
        sisa_new = formatRupiah(sisa.toString());
      }
      $('#sisa_new').val(sisa_new);
      $('#get_id_biaya').val(data[0]);
      $('#get_id_budget').val(data[1]);
    });

    $('#subbiaya').on('change', function() {
      $('#get_id_subbiaya').val($('#subbiaya').val());
    });

    urie = <?php echo $this->uri->segment(4); ?>;
    console.log('Urie : ' + urie);
    if (urie == 3) {
      $("#status_lpj option[value='13']").hide();
    } else {
      $("#status_lpj option[value='13']").show();
    }

  });

  // Integrasi ECES
  // var slim_coa = new SlimSelect({
  //   select: '#coa_id'
  // });

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
        "url": "<?= base_url('eaf/finance/get_history') ?>"
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
      ],
      "initComplete": function(settings, json) {
        // Aktifkan btn_save Ketika Load Sudah Sempurna
        $("#btn_save").removeAttr("disabled");
        $('#btn_save').removeClass();
        $('#btn_save').addClass('btn btn-success');
        $('#btn_save').text('Approve');
      }

    });
  }

  // function get_subbiaya(id) {
  //   $.ajax({
  //     url: '<?php echo base_url() ?>eaf/finance/get_subbiaya/',
  //     type: 'POST',
  //     data: {
  //       id_jenis: id
  //     },
  //     dataType: 'json',
  //     success: function(response) {
  //       var _options = '<option value="0" selected disabled>-- Pilih Sub Biaya --</option>';
  //       $('#subbiaya').empty();
  //       $.each(response, function(i, value) {
  //         _options += '<option value="' + value.id_jenis + '">' + value.jenis + '</option>';
  //       });
  //       $('#subbiaya').append(_options);
  //     },
  //     error: function(jqXHR, textStatus, errorThrown) {
  //       console.log(jqXHR.responseText);
  //     }
  //   });
  // }

  function escapeForOnclick(val) {
    if (val === null || val === undefined) return '';
    let s = String(val);
    // HTML-escape dasar
    s = s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    // Escape backslash untuk JS
    s = s.replace(/\\/g, '\\\\');
    // Escape single quote untuk string JS yang kita bungkus dengan '
    s = s.replace(/'/g, '\\\'');
    // Convert double quote ke entity supaya tidak menutup atribut HTML yang dibungkus dengan "
    s = s.replace(/"/g, '&quot;');
    // Hilangkan newline supaya tidak memecah attribute
    s = s.replace(/[\r\n]+/g, ' ');
    return s;
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
        title: "My Approval Finance",
        footer: true
      }],
      "ajax": {
        "dataType": 'json',
        "type": "POST",
        "data": {
          datestart: null,
          dateend: null,
          status: '2,6'
        },
        "url": "<?= base_url() ?>eaf/finance/get_list_eaf_my_approval/<?php echo $this->uri->segment(4); ?>"
        // "success": function(data) {
        //   console.log(data.data);
        // },
        // "error": function(xhr, error, code) {
        //   console.log(xhr.responseText);
        // }
      },
      "columnDefs": [{
        "targets": [0],
        "visible": hideColumn(),
        "searchable": false
      }],
      "columns": [{
          "data": "lpj_pertama",
          "render": function(data, type, row) {
            if (data == '' || data == null) {
              return ``
            } else {
              return `<span class="btn btn-outline-danger">${data}</span></br>
            <small>tgl reject : ${row['reject_lpj']}</small>`
            }
          }
        },
        {
          "data": "id_pengajuan",
          "render": function(data, type, row) {
            if (row['status'] == 2) {
              return `<a href="javascript:void(0)" class="badge bg-primary" onclick="approval('${data}','${row['company_kode']}','${row['tgl_input']}','${row['name']}','${row['admin_comp_name']}','${row['admin_dept_name']}','${row['admin_desg_name']}','${row['nama_divisi']}','${row['nama_kategori']}','${row['nama_tipe']}','${row['rekening']}','${row['nama_penerima']}','${row['nama_biaya']}','${row['budget']}','${row['nama_keperluan']}','${row['note']}','${row['nominal_uang']}','${row['id_approval']}','${row['photo_acc']}','${row['id_tipe_biaya']}','${row['id_biaya']}','${row['id_budget']}','${row['id_jenis']}','${row['id_project_eces']}','${row['nama_approval']}','${row['note_approve']}','${row['note_verify']}','${row['note_fnc']}','${row['jumlah_termin']}','${row['nominal_termin']}','${row['periode_awal_termin']}','${row['tgl_jtp']}')">${data}</a>`
            } else {
              return `<a href="javascript:void(0)" class="badge custom-bg-outline-warning" onclick="approval_lpj('${data}','${row['company_kode']}','${row['tgl_input']}','${row['name']}','${row['admin_comp_name']}','${row['admin_dept_name']}','${row['admin_desg_name']}','${row['nama_divisi']}','${row['nama_kategori']}','${row['nama_penerima']}','${row['nama_biaya']}','${row['budget']}','${row['nama_keperluan']}','${escapeForOnclick(row['note'])}','${row['nominal_uang']}','${row['id_approval']}','${row['photo_acc']}','${row['id_tipe_biaya']}','${row['note_peng']}','${row['lpj_pertama']}')">${data}</a>`
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
          "data": "update_approve"
        },
        {
          "data": "nama_status",
          'render': function(data, type, row) {
            if (row['status'] == 1 || row['status'] == 2 || row['status'] == 9) {
              return `<span class="custom-bg-outline-warning">${data}</span>`
            } else if (row['status'] == 6) {
              return `<span class=" badge bg-primary">${data}</span>`
            } else if (row['status'] == 4 || row['status'] == 5) {
              return `<span class=" badge bg-danger">${data}</span>`
            } else {
              if ((row['temp'] != null || row['temp'] == '') && row['temp'].slice(0, 3) == "LPJ") {
                return `<span class=" badge bg-success">${data}</span>&nbsp<span class="custom-bg-outline-primary">` + row['temp'] + `</span>`
              } else {
                return `<span class=" badge bg-success">${data}</span>`
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
          "data": "nama_kategori"
        },
        {
          "data": "nominal_uang"
        },
        {
          data: "photo_acc",
          render: (data, type, row) => {

            if (!data || data == 'null')
              return `<a href="javascript:void(0)"><i class="ti-close"></i></a>`;

            if (data == 'ba')
              return `<a href="<?= base_url() ?>eaf/finance/print_ba_reimburse?id=${row.id_pengajuan}"
                            target="_blank" title="Print BA">
                            <i class="ti-printer"></i>
                        </a>`;

            return `<a data-fancybox="gallery"
                        href="<?= base_url('uploads/eaf/') ?>${data}">
                        <i class="bi-image"></i>
                        </a>`;
          },
          className: 'text-center'
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
        {
          "data": "nama_keperluan"
        },
        {
          "data": "admin_comp_name"
        },
        {
          "data": "admin_dept_name"
        },
        {
          "data": "admin_desg_name"
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

  function hideColumn() {
    tipe = <?php echo $this->uri->segment(4); ?>;
    if (tipe == 1) {
      return false;
    } else {
      return true;
    }
  }

  $('#subbiaya_new').change(function() {
    console.log('subbiaya_new change val: ' + $(this).val());
    
    var textJenis = $(this).find('option:selected').text();
    if(textJenis && textJenis != '- Pilih Jenis Biaya -') {
        var cleanText = textJenis.split(' (')[0];
        $('#keperluan').val(cleanText);
    }

    $.ajax({
      url: '<?php echo base_url() ?>eaf/finance/get_biaya_json',
      type: 'POST',
      // dataType: 'html',
      dataType: 'json',
      data: {
        id_jenis: $(this).val()
      },
      success: function(response) {
        var options = [];
        response.forEach(function(value) {
          options.push({
            text: `${value.dtext}`,
            value: `${value.dvalue}`,
            // disabled: true         
          });

        });

        $('#biaya_new').empty(); // Kosongkan dropdown sebelum menambah opsi baru
        // var combinedOptions = options.concat(options2);
        slim_biaya_new.setData(options);

        console.info("options val : " + options);
        console.info("biaya_new val : " + $('#biaya_new').val());
        // $('#biaya_new').empty().append(response);


        value = ($('#biaya_new').val() == null ? '2|2|' : $('#biaya_new').val());
        data = value.split('|');
        console.log("idbiaya : " + data[0] + ', idbudget: ' + data[1] + ',' + data[2]);
        tabel_history(data[0]);
        // get_subbiaya(data[1]);
        if (data[2] == '') {
          budget = '~';
        } else {
          budget = formatRupiah(data[2]);
        }
        $('#budget').val(budget);
        pengajuan = $('#get_nominal').val();
        $('#pengajuan').val(formatRupiah(pengajuan));
        if (budget == '~') {
          sisa_new = '~';
        } else {
          sisa = parseInt(data[2]) - parseInt(pengajuan);
          sisa_new = formatRupiah(sisa.toString());
        }
        $('#sisa_new').val(sisa_new);
        $('#get_id_biaya').val(data[0]);
        console.info("==== Start ======");
        console.info("get_id_biaya | id_biaya: " + data[0]);
        console.info("get_id_budget | id budget : " + data[1]);
        console.info("budget nominal: " + data[2]);
        console.info("==== END ======");

        $('#get_id_budget').val(data[1]);
      },
      error: function(xhr) {
        console.log(xhr.responseText);
      }
    });
  });

  var slim_biaya_new = new SlimSelect({
    select: '#biaya_new',
  });

  var slim_subbiaya_new = new SlimSelect({
    select: '#subbiaya_new',
  });

  function approval(id, company_kode, tgl, name, admin_comp_name, admin_dept_name, admin_desg_name, divisi, kategori, tipe, rekening, penerima, jenis, sisa, keperluan, note, nominal, id_appr, photo, biaya, id_b, id_bud, id_jen, id_pro, nama_approval, note_user_approval, note_verifikatur, note_finance, jumlah_termin, nominal_termin, periode_awal_termin, tgl_jtp) {
    // console.log(`approval : ${nama_approval}`);

    if (tgl_jtp && tgl_jtp.trim() !== '' && tgl_jtp != '0000-00-00') {
      $('#tgl_jtp').val(tgl_jtp);
      $('.tgl_jtp_col').show();
    } else {
      $('.tgl_jtp_col').hide();
    }
    $('#modal_approval').modal('show');
    $('#id_pengajuan').val('ID : ' + id);
    $('#nama_approval').val('Approval : ' + nama_approval);
    $('#id_pengajuan_hide').val(id);
    $('#id_approval_hide').val(id_appr);
    $('#company_code').val('Company : ' + company_kode);
    $('#tgl_input').val(tgl);
    $('#nama_pembuat').val(name);
    $('#divisi').val(divisi);
    $('#kategori').val(kategori);
    $('#tipe').val(tipe);
    $('#penerima').val(penerima);
    $('#keperluan').val(keperluan);
    $('#note').val(note);
    $('#note_user_approval').val(note_user_approval);
    $('#note_verifikatur').val(note_verifikatur);
    $('#get_nominal').val(nominal);
    $('#nominal_old').val(formatRupiah(nominal));
    $('#rupiah').val(formatRupiah(nominal));
    $('#id_project_eces').val(id_pro);
    $('#norek_penerima').val(rekening);

    if (note_finance != '') {
      $('#note_approval').val(note_finance);
    } else {
      $('#note_approval').empty();
    };

    // Disable btn_save Ketika Load Belum Sempurna
    $("#btn_save").attr("disabled", true);
    $('#btn_save').removeClass();
    $('#btn_save').addClass('btn btn-default');
    $('#btn_save').text('Loading..');

    if (biaya == 2 || biaya == 3) {
      $('#akun').text(jenis);
      $('#sisa').text(`Sisa Budget : Rp. ${formatRupiah(sisa)}`);
    } else {
      $('#akun_hide').empty();
      $('#sisa_hide').empty();
    }

    if (photo == 'null') {
      $('#bukti_nota').empty();
      $('#bukti_nota').append('<a href="void:javacript(0)"><i class="ti-close"></i></a>');
    } else if (photo == 'ba') {
      $('#bukti_nota').empty();
      $('#bukti_nota').append('<a href="<?php echo base_url() ?>eaf/finance/print_ba_reimburse?id=' + id + '" target="_blank" title="Print BA"><i class="ti-printer"></i></a>');
    } else {
      $('#bukti_nota').empty();
      $('#bukti_nota').append('<a data-fancybox="gallery" href="<?= base_url('uploads/eaf/'); ?>' + photo + '"> <i class="bi-image"></i></a>');
    }

    if (tipe == 'Tunai') {
      $('#bukti').hide();
    } else {
      $('#bukti').show();
    }

    if (sisa == 'null') {
      sisa = '';
    }



    // console.log(`${id_b}|${id_bud}|${sisa}`);
    // var slim_biaya = new SlimSelect({
    //   select: '#biaya',
    // });
    // slim_biaya.setSelected('0');
    // slim_biaya.setSelected(`${id_b}|${id_bud}|${sisa}`);

    $('#get_id_subbiaya').val(id_jen);
    // get_rekening();

    // console.log(`${id_jen}`);    
    // var slim_subbiaya = new SlimSelect({
    //   select: '#subbiaya',
    // });

    console.info("slim_subbiaya_new : " + id_jen);
    // slim_subbiaya_new.setSelected(id_jen);
    setTimeout(function() {
      // slim_subbiaya_new.setSelected(`${id_jen}`);
      slim_subbiaya_new.setSelected(id_jen);

    }, 1500);

    if (kategori == "Pinjaman Karyawan (CR)") {
      // $("#id_kategori").val(20);
      $(".pinjaman_karyawan").show();
      $('#jumlah_termin').val(jumlah_termin);
      $('#nominal_termin').val(formatRupiah(nominal_termin));
      $('#periode_termin').val(periode_awal_termin);
      $("#rupiah").attr('readonly', true);
    } else {
      $(".pinjaman_karyawan").hide();
      $("#rupiah").removeAttr('readonly');
    }
  }

  function simpan_approve() {
    budget = $('#budget').val().split('.').join('');
    pengajuan = $('#pengajuan').val().split('.').join('');

    if ($('#subbiaya_new').val() == "0" || $('#subbiaya_new').val() == "" || $('#subbiaya_new').val() == null) {
      swal("Warning", "Option Subbiaya belum terpilih!", "warning");
    } else if ($('#status').val() == "0" || $('#status').val() == "" || $('#status').val() == null) {
      swal("Warning", "Option Approval belum terpilih!", "warning");
    } else if (parseInt(pengajuan) > parseInt(budget) && $('#status').val() == "3") {
      swal("Warning", "Nominal Pengajuan melebihi Sisa Budget!", "warning");
      // } else if($('#status').val() == 3 && ($('#coa_id').val() == "" || $('#coa_id').val() == null)){
      //   swal("Warning", "Option Coa belum dipilih!", "warning");
      // }else if($('#status').val() == 3 && ($('#penerima_eces').val() == "" || $('#penerima_eces').val() == null)){
      //   swal("Warning", "Penerima ECES belum dipilih!", "warning");
      // }else if($('#status').val() == 3 && ($('#rek_eces').val() == "" || $('#rek_eces').val() == null)){
      // swal("Warning", "Rekening ECES belum dipilih!", "warning");
      // }else if($('#status').val() == 3 && ($('#note_approval_eces').val() == "" || $('#note_approval_eces').val() == null)){
      //   swal("Warning", "Note ECES harus diisi!", "warning");
    } else {
      swal({
          title: "Anda yakin approve pengajuan ini?",
          // text: "Data akan langsung terintegrasi ke ECES",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: '<?php echo base_url() ?>eaf/finance/insert_approval_finance',
              type: 'post',
              dataType: 'json',
              data: $('#form_approval').serialize(),
              beforeSend: function(res) {
                $("#btn_save").attr("disabled", true);
              },
              success: function(response) {
                // console.log(response);
                // console.log(response.data);
                // console.log(response.data.no_eaf);
                // console.log(response.data.requested_contact);
                // console.log("test ", response.data.jenis);
                icon_status = (response.data.status == 'Approve') ? '✅' : '❌';
                msg = `💸 Trusmiverse EAF Alert!!! \n*Your Request EAF Has Been Cashed Out* \n\nNo.EAF : ${response.data.no_eaf} \nType : ${response.data.type} \nNeed : *${$.trim(response.data.need)}* \nDescription : ${$.trim(response.data.description)} \n💵 Amount : *Rp. ${formatRupiah(response.data.amount,'')},-* \n\nStatus : *${response.data.status}* ${icon_status} \nNote : ${response.data.note} \n\n📝Approve To : ${response.data.approve_to} \n👤Requested By : ${response.data.requested_by} \n🕐Approved At : ${response.data.approved_at} \n\n*Note Lock : Jika dalam waktu 48 Jam sejak Cashout belum melakukan Input LPJ maka akan di Lock System.`;
                // console.log(msg);
                // if (id_user == 1) {
                // list_phone = ['083824786861','628993036965']; //Kania,Faisal
                //   list_phone = ['087829828061']; //fuji
                // } else {
                list_phone = [response.data.requested_contact.toString()];
                var user_id = response.data.pengaju;
                // let contact_coo = ['08986997966'];
                let contact_coo = [response.data.contact_user_biaya.toString()];
                let id_user_biaya = response.data.id_user_biaya;
                // list_phone = ['087829828061']; //fuji
                // }

                // if(response.data.jenis == 1366){
                // list_phone.push('081224479617');
                // list_phone = ['087829828061']; //fuji

                // }
                // send_wa_trusmi(list_phone, msg);

                // Kirim ke Nomor Collect Trusmiland
                // send_wa_trusmi(list_phone, msg, "2308388562");
                // permintaan pak Andyka
                if (id_user_biaya == 118) {
                  send_wa_internal(contact_coo, msg, id_user_biaya);
                }

                send_wa_internal(list_phone, msg, user_id);
                $('#form_approval')[0].reset();
                swal("Success", "Has Been Saved", "success")
                  .then((value) => {
                    $('#dt_list_eaf').DataTable().ajax.reload();
                    // $('#coa_id').prop('selectedIndex',0);
                    // $('#penerima_eces').prop('selectedIndex',0);
                    // $('#rek_eces').prop('selectedIndex',0);
                    $('#modal_approval').modal('hide');
                  });
                $("#btn_save").removeAttr("disabled");
              },
              error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
                swal("error", "An error occurred. The page will reload automatically", "error");
                location.reload();
              }
            });
          }
        });
    }
  }

  function approval_lpj(id, company_kode, tgl, name, admin_comp_name, admin_dept_name, admin_desg_name, divisi, kategori, penerima, jenis, sisa, keperluan, note, nominal, id_appr, photo, biaya, note_peng, lpj_pertama) {
    console.info("modal_approval_lpj show");
    $('#modal_approval_lpj').modal('show');
    $('#id_pengajuan_lpj').val('ID : ' + id);
    $('#id_pengajuan_lpj_hide').val(id);
    $('#id_approval_lpj_hide').val(id_appr);

    $('#tgl_input_lpj').val(tgl);
    $('#nama_pembuat_lpj').val(name);
    $('#company_code_lpj').val('Company : ' + company_kode);
    $('#divisi_lpj').val(divisi);
    $('#kategori_lpj').val(kategori);
    $('#penerima_lpj').val(penerima);
    $('#get_id_tipe_biaya').val(biaya);
    $('#keterangan').val(note_peng);

    if (biaya == 2 || biaya == 3) {
      // console.log(sisa);
      sisa_new = formatRupiah(sisa);
      if (sisa.charAt(0) == '-') {
        sisa_new = `-${formatRupiah(sisa,'')}`;
      }
    } else {
      sisa_new = '~';
    }
    $('#budget_lpj').val(formatRupiah(nominal));
    $('#sisa_lpj').val(sisa_new);

    if (photo == 'null') {
      $('#bukti_lpj').empty();
      $('#bukti_lpj').append('<a href="<?= base_url('eaf/finance/print_ba?id='); ?>' + id + '" target="_blank" title="Print BA"><i class="bi-printer"></i></a>');
    } else {
      $('#bukti_lpj').empty();
      $('#bukti_lpj').append('<a data-fancybox="gallery" href="<?= base_url('uploads/eaf/'); ?>' + photo + '"> <i class="bi-image"></i></a>');
    }

    // Hilangkan Reject di Finance ketika LPJ Pertama sudah pernah di reject
    if (lpj_pertama != "") {
      $("#status_lpj option[value='5']").hide();
      // $("#status_lpj option[value='13']").hide();
      $("#budget_lpj").prop("readonly", false);
    } else {
      $("#status_lpj option[value='5']").show();
      // $("#status_lpj option[value='13']").show();
      $("#budget_lpj").prop("readonly", true);
    }

    if (urie == 3) {
      $("#status_lpj option[value='13']").hide();
    } else {
      $("#status_lpj option[value='13']").show();
    }

    tabel_lpj(id);
    $('#admin_comp_name_lpj').val(admin_comp_name);
    $('#admin_dept_name_lpj').val(admin_dept_name);
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
        "url": "<?= base_url('eaf/finance/get_lpj') ?>"
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

  function simpan_approve_lpj() {
    budget = $('#total_lpj').val().replace(/\./g, '');
    sisa = $('#sisa_lpj').val().replace(/\./g, '');
    budget_lpj = $('#budget_lpj').val().replace(/\./g, '');
    pengajuan = $('#total_kep').val().replace(/\./g, '');
    if (parseInt(budget_lpj) < parseInt(pengajuan)) {
      budget = parseInt(budget) * -1;
    }

    console.log('budget ', budget);
    console.log('sisa ', sisa);
    console.log('budget_lpj ', budget_lpj);
    console.log('pengajuan ', pengajuan);
    console.log(parseInt(pengajuan) > parseInt(budget_lpj), parseInt(budget) > parseInt(sisa), $('#status_lpj').val() == "7");

    if ($('#status_lpj').val() == "0" || $('#status_lpj').val() == "" || $('#status_lpj').val() == null) {
      swal("Warning", "Option Approval belum terpilih!", "warning");
    } else if ($('#budget_lpj').val() == "" || $('#budget_lpj').val() == null) {
      swal("Warning", "Masukkan Nominal LPJ!", "warning");
    } else if ((parseInt(pengajuan) > parseInt(budget_lpj) && parseInt(budget) > parseInt(sisa)) && $('#status_lpj').val() == "7") {
      swal("Warning", "Selisih Nominal LPJ melebihi sisa budget!", "warning");
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
              url: '<?php echo base_url() ?>eaf/finance/insert_approval_lpj',
              type: 'post',
              dataType: 'json',
              data: $('#form_approval_lpj').serialize(),
              beforeSend: function(res) {
                $("#btn_save_lpj").attr("disabled", true);
              },
              success: function(res) {
                console.log(res);
                if (res.eksekusi && res.update_pengajuan) {
                  icon_status = (res.data.status == 'Approve') ? '✅' : '❌';
                  msg = `💸 Trusmiverse EAF Alert!!! \n*Your LPJ EAF Has Been Processed Finance* \n\nNo.LPJ : ${res.data.no_lpj} \nType : ${res.data.type} \nNeed : *${$.trim(res.data.need)}* \nDescription : ${$.trim(res.data.description)} \n💵 Amount : *Rp. ${formatRupiah(res.data.amount,'')},-* \n\nStatus : *${res.data.status}* ${icon_status} \nNote : ${res.data.note} \nNote Pengajuan : ${res.data.note_peng} \n\n📝Approve To : ${res.data.approve_to} \n👤Requested By : ${res.det.pengaju} \n🕐Approved At : ${res.data.approved_at}`;
                  console.log(msg);
                  // if (res.det.id_pengaju == '2041') {
                  // list_phone = ['08993036965'];
                  // list_phone = ['087829828061'];
                  // } else {
                  list_phone = [res.det.contact_pengaju.toString()];
                  var user_id = res.det.id_pengaju;
                  // list_phone = ['087829828061'];
                  // }
                  // list_phone  = ['08993036965','081214926060'];
                  // send_wa_trusmi(list_phone, msg);

                  // Kirim ke Nomor Collect Trusmiland
                  // send_wa_trusmi(list_phone, msg, "2308388562");
                  send_wa_internal(list_phone, msg, user_id);
                  $('#form_approval_lpj')[0].reset();
                  swal("Success", "Has Been Saved", "success")
                  $('#dt_list_eaf').DataTable().ajax.reload();
                  $('#modal_approval_lpj').modal('hide');
                  $("#btn_save_lpj").removeAttr("disabled");
                } else {
                  swal("Warning", `${res.warning}`, "warning");
                  $("#btn_save_lpj").removeAttr("disabled");
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
</script>