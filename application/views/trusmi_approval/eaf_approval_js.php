<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- slim select js -->
<script src="<?php echo base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<script>
    keperluan = new SlimSelect({
      select: '#keperluan'
    });

    pengaju = new SlimSelect({
      select: '#pengaju'
    });

    project = new SlimSelect({
      select: '#project'
    });

    function formatNumber(num) {
      if (num == null) {
        return 0;
      } else {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
      }
    }

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
        if (id_hr != '-- Pilih Yang Mengajukan --') {
          $('.dlk_makan').remove();
          $.ajax({
            url: '<?php echo base_url(); ?>trusmi_approval_handika/cek_dlk_new_eaf/' + id_hr,
            type: 'GET',
            dataType: 'html',
            success: function (response) {
              console.log('Cek DLK : '+response);
              $('#keperluan').append(response);
            }
          });
        }
      })

      $('#keperluan').change(function() {
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
            // $('#rupiah').val(formatNumber(total_uang_makan[1]));
            // $('#note').val(formatNumber(total_uang_makan[2]));
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
        if ($('#project').val() != '-- Pilih Project --') {
          $.ajax({
            url: '<?php echo base_url() ?>trusmi_approval_handika/get_blok_new_eaf/',
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
        }
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

    function approve() {
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
        id_jenis = $('#get_jenis').val();

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
          new PNotify({
                    title: `Perhatian!`,
                    text: `Sisa Budget Kurang dari Nominal Pengajuan.`,
                    type: 'error',
                    delay: 1500
                });
        } else if (tipe_budget.val() == 4 && parseInt(sisa_budget.val()) < parseInt(rupiah.val().replace(/\D/g, ''))) {
          new PNotify({
                    title: `Perhatian!`,
                    text: "Maksimal Sebesar Rp. " + formatNumber(sisa_budget.val()) + " per Pengajuan.",
                    type: 'error',
                    delay: 1500
                });
        } else if (kategori.val() == "20" && jumlah_termin.val() == "") {
          jumlah_termin.addClass('is-invalid');
          jumlah_termin.focus();
        } else if (kategori.val() == "20" && nominal_termin.val() == "") {
          nominal_termin.addClass('is-invalid');
          nominal_termin.focus();
        } else {

        $.ajax({
            url: '<?php echo base_url() ?>trusmi_approval/pengajuan_eaf',
            type: 'POST',
            dataType: 'JSON',
            data: $('#form_keperluan').serialize(),
            success: function(response) {
              new PNotify({
                title: 'Success!',
                text: 'Pengajuan berhasil',
                type: 'success',
                delay: 1500
              });

              setTimeout(function() {
                window.location.href = '<?= base_url(); ?>trusmi_approval';
              }, 2000);
            }
        });

        // nama_penerima.keyup(function(e) {
        //   nama_penerima.removeClass('is-invalid');
        // });

        // kategori.change(function(e) {
        //   kategori.removeClass('is-invalid');
        // });

        // dd_tipe.change(function(e) {
        //   dd_tipe.removeClass('is-invalid');
        // });

        // txtbank.keyup(function(e) {
        //   txtbank.removeClass('is-invalid');
        // });

        // txtrek.keyup(function(e) {
        //   txtrek.removeClass('is-invalid');
        // });

        // rupiah.keyup(function(e) {
        //   rupiah.removeClass('is-invalid');
        // });

        // tanggal.change(function(e) {
        //   tanggal.removeClass('is-invalid');
        // });

        // nota.change(function(e) {
        //   nota.removeClass('is-invalid');
        // });

    }
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
        url: "<?= base_url('trusmi_approval_handika/get_blok_new_eaf') ?>",
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

    function nominal(angka, id)
    {
        $(id).val(formatRupiah(angka, ''));
    }

    function compress(file_upload, string, submit, wait, done) {

        $(wait).show();
        $(done).hide();
        $(submit).prop('disabled', true);

        const file = document.querySelector(file_upload).files[0];

        extension = file.name.substr((file.name.lastIndexOf('.') + 1));

        if (!file) return;

        const reader = new FileReader();

        reader.readAsDataURL(file);

        reader.onload = function(event) {
            const imgElement = document.createElement("img");
            imgElement.src = event.target.result;

            if (extension == "jpg" || extension == "jpeg" || extension == "png" || extension == "gif") {

                extension = 'png,';

                imgElement.onload = function(e) {
                    const canvas = document.createElement("canvas");

                    if (e.target.width > e.target.height) {
                        const MAX_WIDTH = 1024;
                        const scaleSize = MAX_WIDTH / e.target.width;
                        canvas.width = MAX_WIDTH;
                        canvas.height = e.target.height * scaleSize;
                    } else {
                        const MAX_HEIGHT = 1024;
                        const scaleSize = MAX_HEIGHT / e.target.height;
                        canvas.height = MAX_HEIGHT;
                        canvas.width = e.target.width * scaleSize;
                    }

                    const ctx = canvas.getContext("2d");

                    ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);

                    const srcEncoded = ctx.canvas.toDataURL(e.target, "image/jpeg");

                    var g_string = extension + srcEncoded.substr(srcEncoded.indexOf(',') + 1);
                    document.querySelector(string).value = g_string;
                    // saveFile(g_string, wait, done, string, submit);
                }
            } else {
                var g_string = extension + ',' + event.target.result.substr(event.target.result.indexOf(',') + 1);
                document.querySelector(string).value = g_string;
                // saveFile(g_string, wait, done, string, submit);
            }


        }

        function saveFile(string, wait, done, str, submit) {

            $.ajax({
                'url': '<?php echo base_url() ?>trusmi_approval_handika/upload_file',
                'type': 'POST',
                'data': {
                    string: string
                },
                'success': function(response) {
                    document.querySelector(str).value = response;
                    $(submit).prop('disabled', false);
                    $(wait).hide();
                    $(done).show();
                }
            });
        }
    }
</script>