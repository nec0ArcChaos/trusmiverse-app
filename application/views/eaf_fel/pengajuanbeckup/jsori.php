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

    id_user = <?= $this->session->userdata('id_user'); ?>;
    console.log(id_user);

    // Start | Tambah Edit Blok & Note, setelah Pengajuan
    var slim_blok_new = new SlimSelect({
      select: '#blok_new'
    });

    $("#dt_list_eaf").on('click', '.edit_blok', function(){   
      id = $(this).data("id_pengajuan");
      console.log(id);
      // slim_blok_new.set([]);
      $("#modal_edit_blok").modal("show");
      $.ajax({
        url: "<?= base_url('eaf/pengajuan/edit_blok/') ?>"+id,
        method: "GET",
        dataType: "JSON",
        beforeSend: function (res){
          $("#btn_edit_blok").hide();
          $("#loading_edit_blok").show();
        },
        success: function (res){
          data = res[0];
          console.log(res);

          $("#id_aju").val(data.id_pengajuan);
          $("#pro").val(data.project);
          $("#blok_old").val(data.blok);
          $("#note_pengajuan").val(data.note);
        
          blok_ = data.blok.split(',');
          get_blok(data.id_project, data.tipe_blok, data.id_jenis, blok_);
          
          console.log(blok_);
          // Agar setData berhasil setelah Show Data selesai
          setTimeout(function(){
            slim_blok_new.setSelected(blok_);
            console.log("Berhasil");
            $("#loading_edit_blok").hide();
            $("#btn_edit_blok").show();
          }, 5000);
        },
        error: function (jqXHR){
          console.log(jqXHR.responseText);
        }
      });
    });
    // End | Tambah Edit Blok & Note, setelah Pengajuan

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

    keperluan = new SlimSelect({
      select: '#keperluan'
    });

    pengaju = new SlimSelect({
      select: '#pengaju'
    });

    project = new SlimSelect({
      select: '#project'
    });

    blok = new SlimSelect({
      select: '#blok'
    });

    $('#btn_add_pengajuan').click(function() {
      $('#modal_add_pengajuan').modal('show');

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

      $('.tanggal').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        autoclose: true
      });

      // DLK Uang Makan
      $('#pengaju').change(function() {
        id_hr = $(this).val();

        $('.dlk_makan').remove();
        $.ajax({
          url: '<?php echo base_url(); ?>eaf/pengajuan/cek_dlk/' + id_hr,
          type: 'GET',
          dataType: 'html',
          success: function (response) {
            $('#keperluan').append(response);
          }
        });

      })

      $('#keperluan').change(function() {
        console.log($('#keperluan').val());
        if ($('#keperluan').val() != null) {

          data = $('#keperluan').val().split("|");

          console.log('BA : ',data[9]);

          // Pilihan BA - Faisal
          $("#kondisi_pilihan_ba").val(0);
          $("#pilihan_ba_hide").hide();
          if (data[9] == 1) {
            $("#pilihan_ba_hide").show();
            $("#kondisi_pilihan_ba").val(1);
          }

          $('#tipe_budget').val(data[4]);
          $('#sisa_budget').val(data[5]);

          type_project  = data[6];
          type_blok     = data[7];
          $('#get_jenis').val(data[0]);
          $('#type_blok').val(type_blok);

          if (type_blok != "") {
            $('#project_hide').show();
            $('#blok_hide').show();
          } else {
            if (type_project != "") {
              $('#project_hide').show();
              $('#blok_hide').hide();
              $('#list_blok').val("");
            } else {
              $('#project_hide').hide();
              $('#blok_hide').hide();
              $('#list_blok').val("");
            }
          }
          
          id_user_verified     = data[8];

          console.log(data);
          console.log(id_user_verified);

          uang_makan     = data[9];

          $('#leave_id').val('');
          
          if (uang_makan != "undefined") {
            total_uang_makan = uang_makan.split("-");
            $('#leave_id').val(total_uang_makan[0]);
            $('#rupiah').val(formatNumber(total_uang_makan[1]));
            $('#note').val(formatNumber(total_uang_makan[2]));
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

      $('#project').change(function() {
        console.log($('#project').val());
        $.ajax({
          url: '<?php echo base_url() ?>eaf/pengajuan/get_blok/',
          type: 'POST',
          data: {
            id_project: $('#project').val(),
            blok: $('#type_blok').val(),
            id_jenis : $('#get_jenis').val()
          },
          dataType: 'json',
          success: function(response) {
            console.log(response);
            var _options = '<option data-placeholder="true">-- Pilih Blok --</option>';
            $('#blok').empty();
            $.each(response, function(i, value) {
              _options += '<option value="' + value.blok + '">' + value.blok + '</option>';
            });
            $('#blok').append(_options);
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
          }
        });
      });

      $('#blok').change(function() {
        $('#list_blok').val($('#blok').val().join());
        console.log($('#blok').val().join());
        console.log($('#type_blok').val());
        // console.log(project.val());
        console.log($('#get_jenis').val());
        if ($('#get_jenis').val() == 50 || $('#get_jenis').val() == 51){
          console.log('Berhasil!');
        } else {
          console.log('Tidak');
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

        jumlah_termin   = $('#jumlah_termin');
        nominal_termin  = $('#nominal_termin');

        // Pilihan BA - Faisal
        kondisi_pilihan_ba = $("#kondisi_pilihan_ba").val();
        pilihan_ba = 'file';
        if ( $("#kondisi_pilihan_ba").val() == 1 ) {
          pilihan_ba = $('#pilihan_ba').val();
        }

        // console.log(sisa_budget.val() + ' ' + rupiah.val().replace(/\D/g, ''));
        console.log(sisa_budget.val() + ' ' + rupiah.val().replace(/\D/g, ''));
        id_jenis = $('#get_jenis').val();

        // alert(pgj.val())

        if (nama_penerima.val() == "") {
          nama_penerima.addClass('is-invalid');
          nama_penerima.focus();
        } else if (pgj.val() == "-- Pilih Yang Mengajukan --") {
          pengaju.open();
        } else if (kategori.val() == "") {
          kategori.addClass('is-invalid');
          kategori.focus();
        } else if (dd_tipe.val() == "") {
          dd_tipe.addClass('is-invalid');
          dd_tipe.focus();
        } else if (dd_tipe.val() != "Tunai" && txtbank.val() == "") {
          txtbank.addClass('is-invalid');
          txtbank.focus();
        } else if (dd_tipe.val() != "Tunai" && txtrek.val() == "") {
          txtrek.addClass('is-invalid');
          txtrek.focus();
        } else if (kategori.val() != "" && (kpl.val() == "-- Pilih Keperluan --" || kpl.val() == null)) {
          keperluan.open();
        } else if (kategori.val() != "" && rupiah.val() == "") {
          rupiah.addClass('is-invalid');
          rupiah.focus();
        // } else if ($('#type_blok').val() != "" && ($('#project').val() == "-- Pilih Project --" || $('#project').val() == '')) {
        //   project.open();
        } else if (($('#project').val() == "-- Pilih Project --" || $('#project').val() == '') && kategori.val() != "20") {
          project.open(); 
        } else if ( $('#type_blok').val() != "" && ($('#blok').val() == "-- Pilih Blok --" || $('#blok').val() == '') && id_jenis != "50" && id_jenis != "51") {
          blok.open();
        } else if (kategori.val() == "17" && tanggal.val() == "" && pilihan_ba == 'file') {
          tanggal.addClass('is-invalid');
          tanggal.focus();
        } else if (kategori.val() == "17" && nota.val() == "" && pilihan_ba == 'file') {
          nota.addClass('is-invalid');
          nota.focus();
        } else if ((tipe_budget.val() == 2 || tipe_budget.val() == 3) && parseInt(sisa_budget.val()) < parseInt(rupiah.val().replace(/\D/g, ''))) {
          swal("Perhatian!", "Sisa Budget Kurang dari Nominal Pengajuan.", "error");
        } else if (tipe_budget.val() == 4 && parseInt(sisa_budget.val()) < parseInt(rupiah.val().replace(/\D/g, ''))) {
          swal("Perhatian!", "Maksimal Sebesar Rp. " + formatNumber(sisa_budget.val()) + " per Pengajuan.", "error");
        } else if (kategori.val() == "20" && jumlah_termin.val() == "") {
          jumlah_termin.addClass('is-invalid');
          jumlah_termin.focus();
        } else if (kategori.val() == "20" && nominal_termin.val() == "") {
          nominal_termin.addClass('is-invalid');
          nominal_termin.focus();
        } else {
          $('#save_eaf').prop('disabled', true);

          // Kondisi untuk Development Fitur Pinjaman Karyawan
          // url_faisal = '<?php echo base_url() ?>eaf/pengajuan/insert_pengajuan';
          // if (id_user == 1 || id_user == 747) { // IT dan Fafricony
            // url_faisal = '<?php echo base_url() ?>eaf/pengajuan/insert_pengajuan_faisal';
          // }

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

                      keperluan.setSelected('-- Pilih Yang Mengajukan --');
                      pengaju.setSelected('-- Pilih Keperluan --');
                      project.setSelected('-- Pilih Project --');
                      blok.setSelected('-- Pilih Blok --');
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
              if (row['id_kategori'] == 19) {
                id_pengajuan = '<span class="label label-inverse-warning detail_pengajuan" data-id_pengajuan="' + data + '" style="cursor : pointer;">' + data + '</span>'
              } else {
                id_pengajuan = '<span class="label label-primary detail_pengajuan" data-id_pengajuan="' + data + '" style="cursor : pointer;">' + data + '</span>'
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
            "render": function (data, type, row){
              // console.log(row['status']);
              if (row['blok'] != null && row['status'] == 10){
                return `<span class="label label-warning edit_blok" data-id_pengajuan="${row['id_pengajuan']}" style="cursor:pointer;" title="Edit Blok"><i class="fa fa-pencil"></i></span>${data}`;
              } else {
                return data;
              }
            }
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

  function notif_pengajuan(id) {
    $.ajax({
      url: '<?php echo base_url() ?>eaf/pengajuan/get_pengajuan_for_wa/' + id,
      type: 'GET',
      dataType: 'json',
      success: function(res) {
        console.log(id_user);        

        if (id_user == 1) {
          list_phone = ['08993036965'];
        } else {
          list_phone = [res.data.approve_contact];
          
          // Kondisi untuk Send Notif Verified ke Cindy sesuai id_jenis tertentu
          list_jenis_for_cindy = ['87', '803', '84', '804'];
          if ($.inArray(res.data.jenis, list_jenis_for_cindy)  != -1) {
            list_phone.push('6285322416606');
          }

          // Kondisi untuk Send Notif cc ke Farid Ardhyansyah jika User Approval Angga Prabowo
          if (res.data.id_user_approval == 238) {
            list_phone.push('6287743621456');            
          }
        }

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
          link  = '';
        } else {
          verif = 'Approval';
          link = `\n🔗Link Approve : https://trusmicorp.com/rspproject/login?id=1&key=${res.data.no_eaf}`;
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
        msg = `💸 Alert!!! \n*There is New Request EAF ${verif}* \n\nNo.EAF : ${res.data.no_eaf} \nType : ${res.data.type} \nNeed : *${$.trim(res.data.need)}* ${jns} \nDescription : ${$.trim(res.data.description)} \n💵 Amount : *Rp. ${formatRupiah(res.data.amount,'')},-* \n\n🧮Remaining Budget : *${sisa_budget}* \n🧮Remaining Budget After Approval : *${sisa_budget_after}* \n\n📝${verif} To : ${res.data.approve_to} \n👤Requested By : ${res.data.requested_by} \n🕐Requested At : ${res.data.requested_at} ${link}`;
        // console.log(msg);
        // console.log(res.data.pengaju);
        send_wa_trusmi(list_phone, msg);
        
      },
      error: function (jqXHR, textStatus, errorThrown){
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

  // Start | Tambah Edit Blok & Note, setelah Pengajuan
  function get_blok(id, type, jenis, blok)
  {
    $.ajax({
      url: "<?= base_url('eaf/pengajuan/get_blok_new') ?>",
      method: "POST",
      dataType: "HTML",
      data: {
        id: id,
        type: type,
        jenis: jenis,
        blok: blok
      },  
      success: function (res){
        $("#blok_new").empty().append(res);
      },
      error: function (jqXHR){
        console.log(jqXHR);
      }
    });
  }

  function simpan_edit_blok()
  {
    // console.log($("#blok_new").val());
    if ($("#blok_new").val().length == 0) {
      swal("Warning","Please choose some bloks!","warning");
    } else {
      $.ajax({
        url: "<?= base_url('eaf/pengajuan/simpan_edit_blok') ?>",
        method: "POST",
        dataType: "JSON",
        data: $("#form_edit_blok").serialize(),
        beforeSend: function (res){
          $("#btn_edit_blok").prop("disabled", true);
        },
        success: function (res){
          console.log(res);
          $("#modal_edit_blok").modal("hide");
          $("#btn_edit_blok").prop("disabled", false);
          swal("Success","Data has been updated!","success");
          $("#dt_list_eaf").DataTable().ajax.reload();
        },
        error: function (jqXHR){
          console.log(jqXHR);
        }
      });
    }
  }

  function pilih_blok()
  {
    $('#list_blok_edit').val($('#blok_new').val().join());
  }
  // End | Tambah Edit Blok & Note, setelah Pengajuan

  // function nominal(angka, id)
  // {
  //   $(id).val(formatRupiah(angka, ''));
  // }

  // function formatRupiah(angka, prefix)
  // {
  //   var number_string = angka.replace(/[^,\d]/g, '').toString(),
  //   split       = number_string.split(','),
  //   sisa        = split[0].length % 3,
  //   rupiah        = split[0].substr(0, sisa),
  //   ribuan        = split[0].substr(sisa).match(/\d{3}/gi);
  //   if(ribuan){
  //     separator = sisa ? '.' : '';
  //     rupiah += separator + ribuan.join('.');
  //   }
  //   rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
  //   return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
  // }

  function nominal_per_termin()
  {
    nom_pengajuan = $("#rupiah").val().replace(/\D/g, '');
    termin        = $("#jumlah_termin").val();
    nom_termin    = Math.round(parseInt(nom_pengajuan)/parseInt(termin));
    $("#nominal_termin").val(formatRupiah(nom_termin.toString(), ''));
  }

</script>