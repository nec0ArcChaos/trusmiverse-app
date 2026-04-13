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

    company = new SlimSelect({
      select: '#company'
    });

    keperluan = new SlimSelect({
      select: '#keperluan'
    });

    pengaju = new SlimSelect({
      select: '#pengaju'
    });

    $('#btn_add_pengajuan').click(function() {
      $('#modal_add_pengajuan').modal('show');
      console.info("btn_add_pengajuan clicked");

      $("#dd_tipe").change(function() {
        if ($(this).val() == 'Transfer Bank') {
          $("#txtbank").removeAttr("disabled");
          $("#txtbank").focus();
          $("#txtbank").prop('required', true);
          $("#txtrek").removeAttr("disabled");
          $("#txtrek").prop('required', true);
        } else if ($(this).val() == 'Giro') {
          $("#txtbank").removeAttr("disabled");
          $("#txtbank").focus();
          $("#txtbank").prop('required', true);
          $("#txtrek").removeAttr("disabled");
          $("#txtrek").prop('required', true);
        } else {
          $("#txtbank").attr("disabled", "disabled");
          $("#txtbank").prop('required', false);
          $("#txtrek").attr("disabled", "disabled");
          $("#txtrek").prop('required', false);
        }
      });

      $('#kategori').on('change', function() {
        ktg = $('#kategori').val();
        dvs = $('#id_divisi').val();

        if (ktg == 17) {
          $('#attch').text('Bukti Nota');
          $('.tgl_hide').show();
        } else if (ktg == 18) {
          $('#attch').text('Lampiran');
          $('.tgl_hide').hide();
        }

        if (ktg == 20) {
          $('#attch').text('Lampiran');
          $('.pinjaman_karyawan').show();
          $('.tgl_hide').hide();
        } else {
          $('.pinjaman_karyawan').hide();
        }
      });

      $('#company').on('change', function get_keperluan() {
        //   console.info("company change");
        companyId = $(this).val();
        // b_nominal = ($('#rupiah').val()).replace('.', '');
        b_nominal = ($('#rupiah').val()).replace(/[^0-9]/g, '');

        console.info("company change");
        console.info("company change selected company value: " + companyId);
        console.info("company change selected nominal value: " + b_nominal);


        $('#keperluan').prop('disabled', false);

        var options = [];
        var options2 = [];
        // if (id_hr != null && id_hr != '-- Pilih Yang Mengajukan --') {
        // new validasi jika nominal kosong
        if (id_hr != null && id_hr != '-- Pilih Yang Mengajukan --' && b_nominal != '' && companyId != '-- Pilih Company --') {
          $.ajax({
            url: '<?php echo base_url() ?>eaf/pengajuan/jenis_biaya_by_company/',
            type: 'POST',
            data: {
              company_id: companyId,
              b_nominal: b_nominal
            },
            dataType: 'json',
            success: function(response) {

              options.push({
                text: '-- Pilih Keperluan --',
                value: '', // Use an empty string or a placeholder value
                placeholder: true
              });
              response.forEach(function(value) {
                options.push({
                  text: `${value.jenis} (${value.employee})`,
                  // value: value.id_jenis
                  value: `${value.id_jenis}|${value.id_biaya}|${value.jenis}|${value.id_user_approval}|${value.id_tipe_biaya}|${value.budget}|${value.project}|${value.blok}|${value.id_user_verified}|${value.ba}`
                });
              });
              // Clear existing options
              // keperluan.setData([]);

              // Add new options
              // keperluan.setData(options);
              // Gabungkan data jika kedua permintaan AJAX selesai
              // console.log("options2.length : " + options2.length);

              // if (options2.length) {
              $('#keperluan').empty(); // Kosongkan dropdown sebelum menambah opsi baru
              var combinedOptions = options.concat(options2);
              keperluan.setData(combinedOptions);
              // }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(jqXHR.responseText);
            }
          });

          $('.dlk_makan').remove();
          $.ajax({
            url: '<?php echo base_url(); ?>eaf/pengajuan/cek_dlk/' + id_hr,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
              // $('#keperluan').append(response);
              // $('#keperluan').html(response);

              response.forEach(function(value) {
                options2.push({
                  text: `${value.dtext}`,
                  value: `${value.dvalue}`,
                });
              });

              // keperluan.setData(options2);
              // console.log("options.length : " + options.length);

              // Gabungkan data jika kedua permintaan AJAX selesai
              if (options.length) {
                // $('#keperluan').empty(); // Kosongkan dropdown sebelum menambah opsi baru
                var combinedOptions = options.concat(options2);
                keperluan.setData(combinedOptions);
              }
            }
          });
        }
      });

      $('.tanggal').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        autoclose: true
      });

      // DLK Uang Makan
      $('#pengaju').change(function() {
        id_hr = $(this).val();
        console.log('pengaju change selected value : ', id_hr);

        var selectedOption = this.options[this.selectedIndex];
        var companyId = selectedOption.getAttribute('data-company_id_user'); // Mendapatkan data tambahan
        var companyName = selectedOption.getAttribute('data-company_name_user'); // Mendapatkan data tambahan
        if ($('#rupiah').val() != '' && $('#rupiah').val() != null) {
          $('#company').prop('disabled', false);
        }
        $('#rupiah').val('');
        company.setSelected('-- Pilih Company --');
      })

      $('#keperluan').change(function() {
        console.log('keperluan change :' + $('#keperluan').val());
        console.log('keperluan breakdown :');


        // console.log('selectedValue 1 : ', selectedValue);
        let selectElement = document.getElementById('keperluan');
        // if ($('#keperluan').val() != null ) {
        if (selectElement.selectedIndex > 0) {
          data = $('#keperluan').val().split("|");

          console.log('id_jenis : ', data[0]);
          console.log('id_biaya : ', data[1]);
          console.log('jenis : ', data[2]);
          console.log('user_approval : ', data[3]);
          console.log('id_tipe_biaya : ', data[4]);
          console.log('budget : ', data[5]);
          console.log('project : ', data[6]);
          console.log('blok : ', data[7]);
          console.log('id_user_verified : ', data[8]);
          console.log('uang_makan ba : ', data[9]);
          console.log('end breakdown :');
          nominal_dlk = data[9].split("-");
          if (data[0] == 81) { // auto count nominal for dlk
            $('#rupiah').val(nominal_dlk[1]);
          }
          // console.log(nominal[1]);
          $("#kondisi_pilihan_ba").val(0);
          $("#pilihan_ba_hide").hide();
          if (data[9] == 1) {
            $("#pilihan_ba_hide").show();
            $("#kondisi_pilihan_ba").val(1);
          }

          $('#tipe_budget').val(data[4]);
          $('#sisa_budget').val(data[5]);

          $('#get_jenis').val(data[0]);

          id_user_verified = data[8];

          console.log("data value: " + data);
          console.log("id_user_verified: " + id_user_verified);

          uang_makan = data[9];

          $('#leave_id').val('');

          // console.log('uang_makan : ',uang_makan);

          if (uang_makan != "undefined" && uang_makan != 'null') {
            total_uang_makan = uang_makan.split("-");
            $('#leave_id').val(total_uang_makan[0]);
            // $('#rupiah').val(formatNumber(total_uang_makan[1])); || Windu | 2024-11-07
            $('#note').val(formatNumber(total_uang_makan[2]));
          } else {
            $('#leave_id').val('');
            // $('#rupiah').val(''); || Windu | 2024-11-07
            $('#note').val('');

          }
        }
      });

      // Tambahan Pilihan BA
      $('#pilihan_ba').change(function() {
        resul = $('#pilihan_ba').val();
        console.log(resul);
        // Pilihan BA - Faisal
        if (resul == 'ba') {
          $(".pilihan_ba_hide").hide();
        } else {
          $(".pilihan_ba_hide").show();
        }
      });

      $('#save_eaf').on('click', function() {
        nama_penerima = $('#nama_penerima');
        pgj = $('#pengaju');
        kategori = $('#kategori');
        dd_tipe = $('#dd_tipe');
        txtbank = $('#txtbank');
        txtrek = $('#txtrek');
        rupiah = $('#rupiah');
        kpl = $('#keperluan');
        tanggal = $('#tanggal');
        nota = $('#nota');
        tipe_budget = $('#tipe_budget');
        sisa_budget = $('#sisa_budget');

        jumlah_termin = $('#jumlah_termin');
        nominal_termin = $('#nominal_termin');

        // Pilihan BA - Faisal
        kondisi_pilihan_ba = $("#kondisi_pilihan_ba").val();
        pilihan_ba = 'file';
        if ($("#kondisi_pilihan_ba").val() == 1) {
          pilihan_ba = $('#pilihan_ba').val();
        }

        // console.log(sisa_budget.val() + ' ' + rupiah.val().replace(/\D/g, ''));
        console.log(sisa_budget.val() + ' ' + rupiah.val().replace(/\D/g, ''));
        id_jenis = $('#get_jenis').val();

        // alert(pgj.val())
        console.log("kpl.val() " + kpl.val());


        if (nama_penerima.val() == "") {
          nama_penerima.addClass('is-invalid');
          nama_penerima.focus();
          console.log("nama_penerima kosong");
        } else if (pgj.val() == "-- Pilih Yang Mengajukan --") {
          // pengaju.open();
          swal("Perhatian!", "Yang Mengajukan Belum Di pilih.", "error");
          console.log("pengaju kosong");
        } else if (kategori.val() == "") {
          kategori.addClass('is-invalid');
          kategori.focus();
          console.log("kategori kosong");
        } else if (dd_tipe.val() == "") {
          dd_tipe.addClass('is-invalid');
          dd_tipe.focus();
          console.log("tipe bayar kosong");
        } else if (dd_tipe.val() != "Tunai" && txtbank.val() == "") {
          txtbank.addClass('is-invalid');
          txtbank.focus();
          console.log("tipe bayar tf kosong dan bank kosong");
        } else if (dd_tipe.val() != "Tunai" && txtrek.val() == "") {
          txtrek.addClass('is-invalid');
          txtrek.focus();
          console.log("tipe bayar tf kosong dan rek kosong");
        } else if (kategori.val() != "" && (kpl.val() == "-- Pilih Keperluan --" || kpl.val() == null || kpl.val() == '')) {
          // keperluan.enable();
          // keperluan.open();
          // kpl.addClass('is-invalid');
          // kpl.focus();
          // console.log("kpl.val() kosong");
          swal("Perhatian!", "Keperluan Belum Di pilih.", "error");
          console.log("keperluan kosong");
        } else if (kategori.val() != "" && rupiah.val() == "") {
          rupiah.addClass('is-invalid');
          rupiah.focus();
          console.log("kategori kosong & rupiah kosong");
        } else if (kategori.val() == "17" && tanggal.val() == "" && pilihan_ba == 'file') {
          tanggal.addClass('is-invalid');
          tanggal.focus();
          console.log("tanggal kosong");
        } else if (kategori.val() == "17" && nota.val() == "" && pilihan_ba == 'file') {
          nota.addClass('is-invalid');
          nota.focus();
          console.log("nota kosong");
        } else if ((tipe_budget.val() == 2 || tipe_budget.val() == 3) && parseInt(sisa_budget.val()) < parseInt(rupiah.val().replace(/\D/g, ''))) {
          swal("Perhatian!", "Sisa Budget Kurang dari Nominal Pengajuan.", "error");
        } else if (tipe_budget.val() == 4 && parseInt(sisa_budget.val()) < parseInt(rupiah.val().replace(/\D/g, ''))) {
          swal("Perhatian!", "Maksimal Sebesar Rp. " + formatNumber(sisa_budget.val()) + " per Pengajuan.", "error");
        } else if (kategori.val() == "20" && jumlah_termin.val() == "") {
          jumlah_termin.addClass('is-invalid');
          jumlah_termin.focus();
          console.log("kategori 20 && jumlah_termin kosong");
        } else if (kategori.val() == "20" && nominal_termin.val() == "") {
          nominal_termin.addClass('is-invalid');
          nominal_termin.focus();
          console.log("nominal_termin kosong && kategori kosong");
        } else {
          $('#save_eaf').prop('disabled', true);

          swal({
              title: "Anda yakin mengajukan data ini?",
              text: "Data tidak bisa ubah lagi",
              icon: "warning",
              buttons: true,
              successMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                $.ajax({
                  url: '<?php echo base_url() ?>eaf/pengajuan/insert_pengajuan',
                  type: 'post',
                  dataType: 'json',
                  data: $('#form_keperluan').serialize(),
                  success: function(response) {
                    if (response.warning == "") {
                      swal("Success", "Has Been Saved", "success");
                      $('#save_eaf').prop('disabled', false);
                      $('#dt_list_eaf').DataTable().ajax.reload();
                      $('#modal_add_pengajuan').modal('hide');
                      $('#form_keperluan')[0].reset();

                      // keperluan.setSelected('-- Pilih Yang Mengajukan --');
                      // keperluan.setSelected('');
                      keperluan.setSelected('-- Pilih Keperluan --');
                      $('#keperluan').prop('disabled', true);
                      $('#company').prop('disabled', true);
                      company.setSelected('-- Pilih Company --');
                      pengaju.setSelected('-- Pilih Yang Mengajukan --');
                      $("#string").val("");
                      // console.log(response.pengajuan);
                      // console.log(response.id_pengajuan.id_pengajuan);
                      notif_pengajuan(response.id_pengajuan.id_pengajuan);

                      $('.tgl_hide').hide();
                      $('.nota_hide').hide();
                      $('.fa_wait').hide();
                      $('.fa_done').hide();
                    } else {
                      // console.log(response.warning);
                      swal("Warning", response.warning, "warning");
                      $('#save_eaf').prop('disabled', false);
                    }
                  }
                });
              } else {
                $('#save_eaf').prop('disabled', false);
              }
            });
        }

        nama_penerima.keyup(function(e) {
          nama_penerima.removeClass('is-invalid');
        });

        kategori.change(function(e) {
          kategori.removeClass('is-invalid');
        });

        dd_tipe.change(function(e) {
          dd_tipe.removeClass('is-invalid');
        });

        txtbank.keyup(function(e) {
          txtbank.removeClass('is-invalid');
        });

        txtrek.keyup(function(e) {
          txtrek.removeClass('is-invalid');
        });

        rupiah.keyup(function(e) {
          rupiah.removeClass('is-invalid');
        });

        tanggal.change(function(e) {
          tanggal.removeClass('is-invalid');
        });

        nota.change(function(e) {
          nota.removeClass('is-invalid');
        });
      });
    });

    $('#dt_list_eaf').on('click', '.detail_pengajuan', function() {
      id_pengajuan = $(this).data('id_pengajuan');

      $('#modal_detail_pengajuan').modal('show');

      $.ajax({
        url: '<?php echo base_url() ?>eaf/pengajuan/data_detail_pengajuan',
        type: 'POST',
        dataType: 'html',
        data: {
          id_pengajuan: id_pengajuan
        },
        success: function(data) {
          $('#data_detail_pengajuan').empty().append(data);
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
            datestart: start,
            dateend: end,
            tipe: <?php echo $tipe ?>
          },
          "url": "<?= base_url('eaf/pengajuan/get_list_eaf') ?>",
        },
        "columns": [{
            "data": "id_pengajuan",
            "render": function(data, type, row) {
              if (row['id_kategori'] == 19) {
                id_pengajuan = '<span class="btn btn-outline-warning btn-sm detail_pengajuan" data-id_pengajuan="' + data + '" style="cursor : pointer;">' + data + '</span>'
              } else {
                id_pengajuan = '<span class="btn btn-outline-primary btn-sm detail_pengajuan" data-id_pengajuan="' + data + '" style="cursor : pointer;">' + data + '</span>'
              }

              // if (row['status'] == 3 || row['status'] == 7) {
              //   print = '<a target="_blank" href="<?php echo base_url() ?>eaf/pengajuan/save_pengajuan/' + data + '/' + row['id_kategori'] + '/' + row['flag'] + '" class="label label-info"><i class="ti-printer"></i></a>'
              // } else {
              //   print = ''
              // }

              return id_pengajuan
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
              if (row['status'] == 1 || row['status'] == 2 || row['status'] == 6) {
                return `<span class="${row['warna']}">${data}</span>`
              } else if (row['status'] == 4 || row['status'] == 5) {
                return `<span class="${row['warna']}">${data}</span>`
              } else {
                if ((row['temp'] != null || row['temp'] == '') && row['temp'].slice(0, 3) == "LPJ") {
                  return `<span class="${row['warna']}">${data}</span>&nbsp<span class="badge rounded-pill bg-primary">` + row['temp'] + `</span>`
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
                return `<span class="text-danger f-w-600"> ${data} </span>`
                // <a href="<?php echo base_url() ?>print_ba/data_print_ba/${row['id_pengajuan']}" target="_blank" class="label label-danger" style="cursor : pointer;"><i class="icofont icofont-printer"></i></a>
              } else {
                return data
              }
            }
          },
          // {
          //   "data": "nama_keperluan"
          // },
          {
            "data": "nama_keperluan",
            "render": function(data, type, row) {
              // console.log(row['status']);
              return data;
            }
          },
          {
            "data": "nama_divisi",
            "render": function(data, type, row) {
              return '';
            }
          },
          {
            "data": "designation_name"
          },
          {
            "data": "department_name"
          },
          {
            "data": "company_name"
          },
          {
            "data": "name"
          },
        ]

      });
    }

    // $('#rupiah').on('input', function() {
    //   nominal($(this).val(), '#rupiah');
    // });
  });

  // function add_lock() {
  //   $('#modal_add_lock').modal('show');
  // }

  function notif_pengajuan(id) {
    $.ajax({
      url: '<?php echo base_url() ?>eaf/pengajuan/get_pengajuan_for_wa/' + id,
      type: 'GET',
      dataType: 'json',
      success: function(res) {
        // console.log(id_user);        
        // console.log("res :  " + res); 
        if (res.data) {
          // console.log(res.data);              
          // if (id_user == 1) {
          // list_phone = ['08993036965'];
          // fuji it
          // list_phone = ['087829828061'];

          // } else {
          list_phone = [res.data.approve_contact];
          var user_id = res.data.id_user_approval;
          // fuji it
          // list_phone = ['087829828061'];

          // Kondisi untuk Send Notif Verified ke Cindy sesuai id_jenis tertentu
          // list_jenis_for_cindy = ['87', '803', '84', '804'];
          // if ($.inArray(res.data.jenis, list_jenis_for_cindy)  != -1) {
          //   // list_phone.push('6285322416606');
          //   list_phone.push('6287829828061');
          // }

          // Kondisi untuk Send Notif cc ke Farid Ardhyansyah jika User Approval Angga Prabowo
          // if (res.data.id_user_approval == 238) {
          //   // list_phone.push('6287743621456');            
          //   list_phone.push('6287829828061');
          // }
          // }

          // console.log(list_phone);
          // list_phone  = ['08993036965','081214926060'];
          // console.log('Testing IT');
          // console.log(res.level);
          // console.log(res.data);
          // console.log(res.data.approve_contact);
          // console.log(res.data.remaining_budget);
          // console.log(res.data.id_user_approval);
          if (res.level == 10) {
            verif = 'Verification';
            link = '';
          } else {
            verif = 'Approval';
            // link = `\n🔗Link Approve : https://trusmiverse.com/apps/login?id=1&key=${res.data.no_eaf}`;
            link = `\n🔗Link Approve : https://trusmiverse.com/apps/eaf/approval?id_pengajuan=${res.data.no_eaf}`;

          }
          sisa_budget = (res.data.remaining_budget == '~') ? 'Unlimited' : `Rp. ${formatRupiah(res.data.remaining_budget)},-`;
          // \n🧮Remaining Budget After Approval : *${sisa_budget_after}*
          after = parseInt(res.data.remaining_budget) - parseInt(res.data.amount);
          sisa_budget_after = (res.data.remaining_budget == '~') ? 'Unlimited' : `Rp. ${formatRupiah(after.toString())}`;
          // console.log(sisa_budget_after);
          jns = "";
          if (res.data.jenis == 711) {
            jns = `\nKota : ${res.data.city}`;
          }
          msg = `💸 Trusmiverse Alert!!! \n*There is New Request EAF Trusmiverse ${verif}* \n\nNo.EAF : ${res.data.no_eaf} \nType : ${res.data.type} \nNeed : *${$.trim(res.data.need)}* ${jns} \nDescription : ${$.trim(res.data.description)} \n💵 Amount : *Rp. ${formatRupiah(res.data.amount,'')},-* \n\n🧮Remaining Budget : *${sisa_budget}* \n🧮Remaining Budget After Approval : *${sisa_budget_after}* \n\n📝${verif} To : ${res.data.approve_to} \n👤Requested By : ${res.data.requested_by} \n🕐Requested At : ${res.data.requested_at} ${link}`;
          // console.log(msg);
          // console.log(res.data.pengaju);
          // send_wa_trusmi(list_phone, msg, "2308388562");
          // send_wa_trusmi('087829828061', msg, "2308388562");
          //send_wa_internal(['087829828061'], msg, 1161); // Fuji IT
          send_wa_internal(list_phone, msg, user_id);
        } else {
          console.log('Data tidak ditemukan');
          // swal("Success", "EAF Tersimpan Tapi Notif Wa Tidak Terkirim", "success");
        }

      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
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
    if (company_value == '-- Pilih Company --') {
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

  // function nominal_per_termin() {
  //   nom_pengajuan = $("#rupiah").val().replace(/\D/g, '');
  //   termin = $("#jumlah_termin").val();
  //   nom_termin = Math.round(parseInt(nom_pengajuan) / parseInt(termin));
  //   $("#nominal_termin").val(formatRupiah(nom_termin.toString(), ''));
  // }

  function nominal_per_termin(termin) {
    // alert(termin);
    nom_pengajuan = $("#rupiah").val().replace(/\D/g, '');
    // termin = $("#jumlah_termin").val();
    nom_termin = Math.round(parseInt(nom_pengajuan) / parseInt(termin));
    $("#nominal_termin").val(formatRupiah(nom_termin.toString(), ''));
  }
</script>