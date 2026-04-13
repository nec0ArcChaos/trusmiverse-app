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

<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/dataTables.fixedColumns.min.js"></script>

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

    id_user = <?= $_SESSION['id_user'] ?>;

    var slim_blok_new = new SlimSelect({
      select: '#blok_new'
    });

    $("#dt_list_eaf").on('click', '.edit_blok', function(){   
      id = $(this).data("id_pengajuan");
      console.log(id);
      slim_blok_new.set([]);
      $("#modal_edit_blok").modal("show");
      $.ajax({
        url: "<?= base_url('eaf/finance/edit_blok/') ?>"+id,
        method: "GET",
        dataType: "JSON",
        success: function (res){
          data = res[0];
          console.log(data);

          $("#id_aju").val(data.id_pengajuan);
          $("#pro").val(data.project);
          $("#blok_old").val(data.blok);
        
          blok_ = data.blok.split(',');
          get_blok(data.id_project, data.tipe_blok, data.id_jenis, blok_);
          
          // Agar setData berhasil setelah Show Data selesai
          setTimeout(function(){
            slim_blok_new.setSelected(blok_);
            console.log("Berhasil");
          }, 1500);
        },
        error: function (jqXHR){
          console.log(jqXHR.responseText);
        }
      });
    });
    // if (<?= $_SESSION['id_user']; ?> == 1) {  
    // }

    /*Range*/
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
      $('#reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="datestart"]').val(start.format('YYYY-MM-DD'));
      $('input[name="dateend"]').val(end.format('YYYY-MM-DD'));
      tabel_list_eaf(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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

    $('#status').on('change', function() {
      if ($(this).val() == '4') {
        $(this).css('border-color', 'green');
        $('#btn_save').removeClass();
        $('#btn_save').addClass('btn btn-success');
        $('#btn_save').text('Approve');
      } else if ($(this).val() == '6') {
        $(this).css('border-color', 'red');
        $('#btn_save').removeClass();
        $('#btn_save').addClass('btn btn-danger');
        $('#btn_save').text('Reject');
      } else if ($(this).val() == '13') {
        $(this).css('border-color', 'orange');
        $('#btn_save').removeClass();
        $('#btn_save').addClass('btn btn-warning');
        $('#btn_save').text('Revisi');
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
          status: 'Approve'
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
            if (row['status'] == 3) {
              if(row['ju_id_eces'] != ''){
                return `<a href="javascript:void(0)" class="label label-primary" onclick="approval('${data}','${row['tgl_input']}','${row['name']}','${row['nama_divisi']}','${row['nama_kategori']}','${row['nama_penerima']}','${row['status']}')">${data}</a><a target="_blank" href="<?= base_url() ?>eaf/finance/save_pengajuan/${data}/${row['id_kategori']}/${row['flag']}" class="label label-info"><i class="ti-printer"></i></a><a target="_blank" href="<?= base_url() ?>eaf/finance/print_nota_eces/${row['ju_id_eces']}" class="label label-warning"><i class="ti-printer"></i></a>`
              } else {
                return `<a href="javascript:void(0)" class="label label-primary" onclick="approval('${data}','${row['tgl_input']}','${row['name']}','${row['nama_divisi']}','${row['nama_kategori']}','${row['nama_penerima']}','${row['status']}')">${data}</a><a target="_blank" href="<?= base_url() ?>eaf/finance/save_pengajuan/${data}/${row['id_kategori']}/${row['flag']}" class="label label-info"><i class="ti-printer"></i></a>`
              }
            } else {
              return `<a href="javascript:void(0)" class="label label-inverse-primary" onclick="approval_lpj('${data}','${row['tgl_input']}','${row['name']}','${row['nama_divisi']}','${row['nama_kategori']}','${row['nama_penerima']}')">${data}</a><a target="_blank" href="<?= base_url() ?>eaf/finance/save_pengajuan/${data}/${row['id_kategori']}/${row['flag']}" class="label label-info"><i class="ti-printer"></i></a>`
            }
          }
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
        //   "data": "nama_keperluan"
        // },
        {
          "data": "nama_divisi"
        },
        {
          "data": "name"
        },
      ]

    });
  }

  function approval(id, tgl, name, divisi, kategori, penerima, status) {
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
          $('#bukti').append('<a href="void:javacript(0)"><i class="ti-close"></i></a>');
        } else {
          $('#bukti').empty();
          $('#bukti').append('<a data-fancybox="gallery" href="<?= base_url('assets/uploads/eaf/'); ?>' + res.photo_acc + '"> <i class="ti-image"></i></a>');
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
  }

  function approval_lpj(id, tgl, name, divisi, kategori, penerima) {
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
          $('#bukti_lpj').append('<a href="<?= base_url('eaf/finance/print_ba?id='); ?>' + id + '" target="_blank" title="Print BA"><i class="ti-printer"></i></a>');
        } else {
          $('#bukti_lpj').empty();
          $('#bukti_lpj').append('<a data-fancybox="gallery" href="<?= base_url('assets/uploads/eaf/'); ?>' + res.photo_acc + '"> <i class="ti-image"></i></a>');
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
              return `<span class=" badge badge-success">${data}</span>`
            } else if (data == 'Reject') {
              return `<span class=" badge badge-danger">${data}</span>`
            } else if (data == 'Revisi') {
              return `<span class=" badge badge-warning">${data}</span>`
            } else if (data == 'Konfirmasi') {
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

  // function edit_blok(id)
  // {
  //   console.log(id);
  //   var slim_blok_new = new SlimSelect({
  //     select: '#blok_new'
  //   });
  //   slim_blok_new.set([]);

  //   if (<?= $_SESSION['id_user']; ?> == 1) {      

  //     $("#modal_edit_blok").modal("show");
  //     $.ajax({
  //       url: "<?= base_url('eaf/finance/edit_blok/') ?>"+id,
  //       method: "GET",
  //       dataType: "JSON",
  //       success: function (res){
  //         data = res[0];
  //         console.log(data);

  //         $("#id_aju").val(data.id_pengajuan);
  //         $("#pro").val(data.project);
  //         $("#blok_old").val(data.blok);
        
  //         blok_ = data.blok.split(',');
  //         get_blok(data.id_project, data.tipe_blok, data.id_jenis, blok_);
          
  //         // Agar setData berhasil setelah Show Data selesai
  //         setTimeout(function(){
  //           slim_blok_new.setSelected(blok_);
  //           console.log("Berhasil");
  //         }, 1500);
  //       },
  //       error: function (jqXHR){
  //         console.log(jqXHR.responseText);
  //       }
  //     });
  //   } else {
  //     swal("Info","Fitur Sedang dalam Pengembangan !!","info");
  //   }
  // }

  function get_blok(id, type, jenis, blok)
  {
    $.ajax({
      url: "<?= base_url('eaf/finance/get_blok') ?>",
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
    $.ajax({
      url: "<?= base_url('eaf/finance/simpan_edit_blok') ?>",
      method: "POST",
      dataType: "JSON",
      data: $("#form_edit_blok").serialize(),
      success: function (res){
        console.log(res);
        $("#modal_edit_blok").modal("hide");
        swal("Success","Data has been updated!","success");
        $("#dt_list_eaf").DataTable().ajax.reload();
      },
      error: function (jqXHR){
        console.log(jqXHR);
      }
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