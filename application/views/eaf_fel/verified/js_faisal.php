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

<!-- Datetime Picker -->
<!-- <script src="<?php echo base_url(); ?>assets/datetimepicker/datetimepicker.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/datetimepicker/jquery.js"></script> -->

<script type="text/javascript">
  $(document).ready(function() {

    $('.tanggal').datetimepicker({
      format: "Y-m-d H:i:s"
    });

    id_user = <?= $this->session->userdata('id_user'); ?>;
    console.log(id_user);

    function formatNumber(num) {
      if (num == null) {
        return 0;
      } else {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
      }
    }

    // $('.tanggal').datepicker({
    //   format: 'yyyy-mm-dd H:i:s',
    //   autoclose: true,
    //   todayHighlight: true,
    // });

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
          if (row['status'] == 10){
            return `<a href="javascript:void(0)" class="label label-primary" onclick="verified('${data}','${row['tgl_input']}','${row['name']}','${row['nama_divisi']}','${row['nama_kategori']}','${row['nama_tipe']}','${row['nama_penerima']}','${row['nama_keperluan']}','${row['note']}','${row['nominal_uang']}','${row['photo']}')">${data}</a>`
          } else {
            return `<a href="javascript:void(0)" class="label label-inverse-warning" onclick="verified_lpj('${data}','${row['tgl_input']}','${row['name']}','${row['nama_divisi']}','${row['nama_kategori']}','${row['nama_penerima']}','${row['photo']}')">${data}</a>`
          }
        }
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

  function verified(id, tgl, name, divisi, kategori, tipe, penerima, keperluan, note, nominal, photo) 
  {
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
    } else {
      $('#bukti').empty();
      $('#bukti').append('<a data-fancybox="gallery" href="<?= base_url('assets/uploads/eaf/'); ?>' + photo + '"> <i class="ti-image"></i></a>');
    }

    $('#keperluan').val(keperluan);
    $('#note').val(note);
    $('#nominal_old').val(formatRupiah(nominal));
    $('#rupiah').val(formatRupiah(nominal));

    detail_verified(id);
  }

  function detail_verified(id)
  {
    $.ajax({
      url: "<?= base_url('eaf/verified/get_detail_verified/') ?>"+id,
      method: "GET",
      dataType: "JSON",
      success: function (res){
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
      error: function (xhr){
        console.log(xhr.responseText);
      }
    });
  }

  function simpan_approve() {
    sisa = $('#get_sisa').val();
    nominal = $('#rupiah').val().split('.').join('');
    if ($('#status').val() == "0" || $('#status').val() == "" || $('#status').val() == null) {
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
              console.log(response);
              console.log(response.stat);
              console.log(response.data);
              if (response.stat == 1) {
                console.log(response.data.no_eaf);
                console.log(response.data.approve_contact);
                sisa_budget = (response.data.remaining_budget == '~') ? 'Unlimited' : `Rp. ${formatRupiah(response.data.remaining_budget)},-`;
                msg = `💸 Alert!!! \n*There is New Request EAF Approval, has been Verified* \n\nNo.EAF : ${response.data.no_eaf} \nType : ${response.data.type} \nNeed : *${$.trim(response.data.need)}* \nDescription : ${$.trim(response.data.description)} \n💵 Amount : *Rp. ${formatRupiah(response.data.amount,'')},-* \n\n🧮Remaining Budget : *${sisa_budget}* \n\n📝Approve To : ${response.data.approve_to} \n👤Verified By : ${response.data.verified_by} \n👤Requested By : ${response.data.requested_by} \n🕐Requested At : ${response.data.requested_at} \n🔗Link Approve : https://trusmicorp.com/rspproject/login?id=1&key=${response.data.no_eaf}`;
                console.log(msg);
                // if (response.data.pengaju == '2041') {
                if (id_user == 1) {
                  list_phone  = ['08993036965'];
                } else {
                  list_phone  = ['08993036965', response.data.approve_contact.toString()];
                }
                // list_phone  = ['08993036965','081214926060'];
                send_wa(list_phone,msg);
              }
              $('#form_verified')[0].reset();
              swal("Success", "Has Been Saved", "success")
              .then((value) => {
                $('#dt_list_eaf').DataTable().ajax.reload();
                $('#modal_verified').modal('hide');
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

    if (photo == 'null'){
      $('#bukti_lpj').empty();
      $('#bukti_lpj').append('<a href="<?= base_url('eaf/verified/print_ba?id='); ?>'+id+'" target="_blank" title="Print BA"><i class="ti-printer"></i></a>');
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
        "render": function (data, type, row) {
          return formatRupiah(data);
        }
      },
      {
        "data": "nominal_lpj",
        "render": function (data, type, row) {
          return formatRupiah(data);
        }
      },
      {
        "data": "sisa_lpj",
        "render": function (data, type, row) {
          return formatRupiah(data);
        }
      },
      ],
      "footerCallback": function (row, data, start, end, display) {
        var api = this.api();

            // Remove the formatting to get integer data for summation
        var intVal = function (i) {
          return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
        };

            // Total over all pages
        total = api
        .column(4)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b);
        }, 0);

            // Update footer
        $(api.column(4).footer()).html(formatRupiah(total.toString()));


      },
      "initComplete": function (settings, json){
        $("#nominal_lpj_rev").val(formatRupiah(json.data[0].nominal_lpj));
        $("#id_user_approval_lpj_hide").val(formatRupiah(json.data[0].id_user_approval));
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
            url: '<?php echo base_url() ?>eaf/verified/insert_verified_lpj_faisal',
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