<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/node_modules/compressorjs/dist/compressor.min.js"></script>

<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script src="
https://cdn.jsdelivr.net/npm/slim-select@2.8.2/dist/slimselect.umd.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/slim-select@2.8.2/dist/slimselect.min.css
" rel="stylesheet">

<!-- Memuat script Dropzone.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>

<script>
  $(document).ready(function() {
    company_id = new SlimSelect({
      select: '#company_id',
    });

    akun = new SlimSelect({
      select: '#akun',

    });

    budget = new SlimSelect({
      select: '#budget'
    });

    tipe_biaya = new SlimSelect({
      select: '#tipe_biaya'
    });

    user_approval1 = new SlimSelect({
      select: '#user_approval1'
    });
    user_approval2 = new SlimSelect({
      select: '#user_approval2'
    });

    tabel_jenis_biaya();

    $('#dt_list_jenis_biaya').on('click', '.edit_jenis_biaya', function() {
      $('#modal_jenis_biaya').modal('show');
      $('#tipe_crud').val('update');

      console.info("mdl edit_jenis_biaya");
      console.info("id_jenis : " + $(this).data('id_jenis'));
      console.info("jenis : " + $(this).data('jenis'));
      console.info("budget : " + $(this).data('budget'));
      console.info("id_user " + $(this).data('id_user'));
      // console.info("id_budget " + $(this).data('id_budget'));

      $('#update_jenis_biaya').show();
      $('#insert_jenis_biaya').hide();
      jenis = $('#jenis_biaya');
      id_jenis = $(this).data('id_jenis');
      $('#id_jenis').val(id_jenis);
      tpb = $(this).data('id_tipe_biaya');
      jenis.val($(this).data('jenis'));
      // budget.setSelected($(this).data('id_budget'));
      // console.log($(this).data('id_tipe_biaya'));
      // tipe_biaya.setSelected($(this).data('id_tipe_biaya'));
      // setTimeout(function() {
      //   console.log("Masuk");
      // $("#tipe_biaya").val($(this).data('id_tipe_biaya'));
      // $("#tipe_biaya").val().change();
      $('#tipe_biaya').val(tpb).prop('selected', true);
      // }, 2000);

      var_id_user_approval = $(this).data('id_user_approval');
      var_id_user_approval2 = $(this).data('id_user_approval2');
      max_approve = $(this).data('max_approve');
      nominal_app_2 = $(this).data('nominal_app_2');
      $('#max_nominal').val(max_approve);
      $('#nominal_app').val(nominal_app_2);
      var_jb_company_id = $(this).data('jb_company_id');
      var_id_budget = $(this).data('id_budget');
      console.info("var_id_user_approval " + var_id_user_approval);
      console.info("var_id_budget " + var_id_budget);
      user_approval1.setSelected(var_id_user_approval.toString());
      if (var_id_user_approval2 != null) {
        user_approval2.setSelected(var_id_user_approval2.toString());
      } else {
        user_approval2.setSelected("-- Pilih User Approval 2 --");
      }
      company_id.setSelected(var_jb_company_id.toString());
      company_id.disable();
      $('#company_id_hidden').val(var_jb_company_id);
      $.ajax({
        url: "<?= base_url('eaf/master_jenis_biaya/get_lVwfiYHslXSBboCV_duit') ?>",
        method: "POST",
        dataType: "JSON",
        data: {
          company_id: var_jb_company_id
        },
        success: function(res) {
          let budgets = '<option data-placeholder="true">-- Pilih Budget --</option>';
          // console.info(res);
          res.budget.forEach((value, index) => {
            budgets += `<option value = "${value.id_budget}"> ${value.budget} </option>`;
          })
          $('#budget').html(budgets);
          budget.destroy(); // Hapus instansi sebelumnya
          budget = new SlimSelect({
            select: '#budget'
          });

          budget.setSelected(var_id_budget.toString());
          // console.info("id_budget : " + var_id_budget.toString());


        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
      })

    });

    $('#update_jenis_biaya').on('click', function() {
      inp_company_id = $('#company_id').val();
      console.info("inp_company_id : " + inp_company_id);
      if (jenis.val() == "") {
        jenis.addClass('is-invalid');
        jenis.focus();
      } else if ($('#company_id').val() == "-- Pilih Company --") {
        swal("Success!", "Company Belum Di pilih", "success");
      } else if ($('#budget').val() == "-- Pilih Budget --") {
        budget.open();
      } else if ($('#tipe_biaya').val() == "-- Pilih Tipe Biaya --") {
        tipe_biaya.open();
      } else if ($('#user_approval1').val() == "-- Pilih User Approval 1 --") {
        user_approval1.open();
      } else if ($('#user_approval2').val() == "-- Pilih User Approval 2 --") {
        user_approval2.open();
      } else if ($('#nominal_app').val() == "" || $('#nominal_app').val() == null) {
        $('#nominal_app').addClass('is-invalid');
        $('#nominal_app').focus();
      } else if ($('#max_nominal').val() == "" || $('#max_nominal').val() == null) {
        $('#max_nominal').addClass('is-invalid');
        $('#max_nominal').focus();
      } else {
        $('#update_jenis_biaya').prop('disabled', true);
        $.ajax({
          url: '<?php echo base_url() ?>eaf/master_jenis_biaya/insert_jenis_biaya',
          type: 'POST',
          dataType: 'json',
          data: $('#form_jenis_biaya').serialize(),
          success: function(response) {
            $('#update_jenis_biaya').prop('disabled', false);
            console.log(response);
            swal("Success!", "Data Has been Updated", "success");
            $('#form_jenis_biaya')[0].reset();
            $('#dt_list_jenis_biaya').DataTable().ajax.reload();
            $('#modal_jenis_biaya').modal('hide');
          }
        });
      }

      jenis.keyup(function(e) {
        jenis.removeClass('is-invalid');
      });
    });

  });
  // End of document ready

  function mdl_add_jenis_biaya() {
    $('#insert_jenis_biaya').show();
    $('#update_jenis_biaya').hide();
    $('#id_jenis').val(0);
    $('#modal_jenis_biaya').modal('show');
    company_id.enable();
    $('#tipe_crud').val('new');


    company_id.setSelected();
    akun.disable();
    budget.disable();
    var selectBoxcompanyid = document.getElementById('company_id');

    var div_akun = document.getElementById('div_akun');
    var selectBoxakun = document.getElementById('akun');
    // selectBoxakun.disabled = true;
    // var selectBoxbudget = document.getElementById('budget');
    // var selectBoxtipe_biaya = document.getElementById('tipe_biaya');

    selectBoxcompanyid.addEventListener('change', function() {
      budget.setSelected();
      div_akun.style.display = 'none';
      budget.enable();
      $.ajax({
        url: "<?= base_url('eaf/master_jenis_biaya/get_lVwfiYHslXSBboCV_duit') ?>",
        method: "POST",
        dataType: "JSON",
        data: {
          company_id: selectBoxcompanyid.value
        },
        success: function(res) {
          let budgets = '<option data-placeholder="true">-- Pilih Budget --</option>';
          // console.info(res);
          res.budget.forEach((value, index) => {
            budgets += `<option value = "${value.id_budget}"> ${value.budget} </option>`;
          })
          $('#budget').html(budgets);
          // Inisialisasi ulang Slim Select jika sudah di-inisialisasi sebelumnya
          budget.destroy(); // Hapus instansi sebelumnya
          budget = new SlimSelect({
            select: '#budget'
          });
        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
      })
    });
  }

  function mdl_tbh_budget() {
    var selectBoxcompanyid = document.getElementById('company_id');
    const selectedOptionText = document.querySelector(`#company_id option[value="${selectBoxcompanyid.value}"]`).textContent;

    // console.info("selectBoxcompanyid " + selectBoxcompanyid);
    // console.info("selectBoxcompanyid " + selectedOptionText);
    if (selectBoxcompanyid.value == '-- Pilih Company --') {
      swal("Warning", "Pilih Company Dulu !", "error")
    } else {
      $('#modal_budget').modal('show');
      $('#company_budget').val(selectedOptionText);
      $('#company_budgetid').val(selectBoxcompanyid.value);

    }
  }

  function tabel_jenis_biaya() {
    // IT, Pak Hendra, Bu Yeyen, Noni, Ade
    var arr = [1, 61, 162, 495, 344, 1161];
    var id_ = <?= $this->session->userdata('user_id') ?>;
    // console.log(arr);
    // console.log(id_);
    $('#dt_list_jenis_biaya').DataTable({
      'destroy': true,
      'lengthChange': false,
      'searching': true,
      'info': true,
      'paging': true,
      "autoWidth": false,
      "dataSrc": "",
      "dom": 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        text: 'Export to Excel',
        title: "<?= $pageTitle ?>",
        footer: true,
        customize: function(xlsx) {
          var sheet = xlsx.xl.worksheets['sheet1.xml'];
          $('row:first c', sheet).attr('s', '2');
        }
      }],
      "ajax": {
        "dataType": 'json',
        "type": "POST",
        "url": "<?= base_url('eaf/master_jenis_biaya/get_list_jenis_biaya') ?>",
      },
      "columns": [{
          "data": "id_jenis",
          "className": "text-center"
        },
        {
          "data": "company_name"
        },
        {
          "data": "jenis"
        },
        {
          "data": "nama_akun"
        },
        {
          "data": "budget"
        },
        {
          "data": "nama_tipe_biaya"
        },
        {
          "data": "employee_name"
        },
        {
          "data": "employee_name2"
        },
        {
          "data": "nominal_app_2",
          "render": function(data, type, row, meta) {
            if (data == null) {
              return '';
            } else {
              return 'Rp. ' + formatRupiahInput(data);
            }
          }
        },
        {
          "data": "max_approve",
          "render": function(data, type, row, meta) {
            if (data == null) {
              return '';
            } else {
              return 'Rp. ' + formatRupiahInput(data);
            }
          }
        },
        {
          "data": "verifikator"
        },
        {
          "data": "created"
        },
        {
          "data": "id_jenis",
          // "visible": (jQuery.inArray(id_, arr) == -1) ? false : true,
          "render": function(data, type, row) {

            // if(id_ == 1){
            return '<span class="btn btn-warning btn-sm edit_jenis_biaya" data-id_jenis="' + data + '" data-jb_company_id="' + row['jb_company_id'] + '" data-jenis="' + row['jenis'] + '" data-id_akun="' + row['id_akun'] + '" data-akun="' + row['nama_akun'] + '" data-id_budget="' + row['id_budget'] + '" data-budget="' + row['budget'] + '" data-id_tipe_biaya="' + row['id_tipe_biaya'] + '" data-tipe_biaya="' + row['nama_tipe_biaya'] + '" data-id_user="' + row['id_user'] + '" data-user="' + row['employee_name'] + '" data-id_user_approval="' + row['id_user_approval'] + '" data-id_user_approval2="' + row['id_user_approval2'] + '" data-nominal_app_2 ="' + row['nominal_app_2'] + '" data-max_approve ="' + row['max_approve'] + '" style="cursor : pointer;">' +
              '<i class="bi bi-pencil"></i></span> <span class="btn btn-danger btn-sm delete_jenis_biaya" data-id_jenis="' + data + '"  style="cursor : pointer;"><i class="bi bi-trash"></i></span>'
            // } else {
            // return '<span class="btn btn-warning btn-sm edit_jenis_biaya" data-id_jenis="' + data + '" data-jenis="' + row['jenis'] + '" data-id_akun="' + row['id_akun'] + '" data-akun="' + row['nama_akun'] + '" data-id_budget="' + row['id_budget'] + '" data-budget="' + row['budget'] + '" data-id_tipe_biaya="' + row['id_tipe_biaya'] + '" data-tipe_biaya="' + row['nama_tipe_biaya'] + '" data-id_user="' + row['id_user'] + '" data-user="' + row['employee_name'] + '"  style="cursor : pointer;">'+
            // '<i class="bi bi-pencil"></i></span> <span class="btn btn-danger btn-sm delete_jenis_biaya" data-id_jenis="' + data + '"  style="cursor : pointer;"><i class="bi bi-trash"></i></span>'

            // return '</span> <span class="btn btn-danger btn-sm delete_jenis_biaya" data-id_jenis="' + data + '"  style="cursor : pointer;"><i class="bi bi-trash"></i></span>'
            // }          
          },
          "className": "text-center"
        }
      ]
    });
  }

  function insert_budget() {
    add_budget = $('#add_budget');
    company_budgetid = $('#company_budgetid');

    if (add_budget.val() == "") {
      add_budget.addClass('is-invalid');
      add_budget.focus();
    } else if (company_budgetid.val() == "") {
      company_budgetid.addClass('is-invalid');
      company_budgetid.focus();
    } else {
      $('#insert_budget').prop('disabled', true);
      $.ajax({
        url: '<?php echo base_url() ?>eaf/master_jenis_biaya/insert_budget',
        type: 'post',
        dataType: 'json',
        data: $('#form_budget').serialize(),
        success: function(response) {
          $('#form_budget')[0].reset();
          swal("Success", "Data Has Been Saved", "success")
          $('#insert_budget').prop('disabled', false);
          $('#modal_budget').modal('hide');
          // console.log($('#add_budget').val());
          // console.log(response);
          // reload_budget(company_budgetid.val(), response);
          // budget.setSelected(response);
          location.reload();
        },
        error: function(xhr, textStatus, errorThrown) {
          console.log(xhr.responseText);
        }
      });
    }

    add_budget.keyup(function(e) {
      add_budget.removeClass('is-invalid');
    });
  }

  function reload_budget(company_budgetid, new_budget_id) {
    // console.info("reload_budget call " + company_budgetid);
    $.ajax({
      url: "<?= base_url('eaf/master_jenis_biaya/get_lVwfiYHslXSBboCV_duit') ?>",
      method: "POST",
      dataType: "JSON",
      data: {
        company_id: company_budgetid
      },
      success: function(res) {
        let budgets = '<option data-placeholder="true">-- Pilih Tipe Biaya --</option>';
        res.budget.forEach((value, index) => {
          budgets += `<option value = "${value.id_budget}"> ${value.budget} </option>`;
        })
        budget.destroy(); // Hapus instansi sebelumnya
        $('#budget').html(budgets);
        budget = new SlimSelect({
          select: '#budget'
        });
        budget.setSelected(new_budget_id);
      },
      error: function(xhr) {
        console.log(xhr.responseText);
      }
    })
  }

  function insert_jenis_biaya() {
    console.info("insert_jenis_biaya call");
    jenis = $('#jenis_biaya');

    if (jenis.val() == "") {
      jenis.addClass('is-invalid');
      jenis.focus();
    } else if ($('#company_id').val() == "-- Pilih Company --") {
      company_id.open();
    } else if ($('#budget').val() == "-- Pilih Budget --") {
      budget.open();
    } else if ($('#tipe_biaya').val() == "-- Pilih Tipe Biaya --") {
      tipe_biaya.open();
    } else if ($('#user_approval1').val() == "-- Pilih User Approval 1 --") {
      user_approval1.open();
    } else if ($('#user_approval2').val() == "-- Pilih User Approval 2 --") {
      user_approval2.open();
    } else if ($('#nominal_app').val() == "" || $('#nominal_app').val() == null) {
      $('#nominal_app').addClass('is-invalid');
      $('#nominal_app').focus();
    } else if ($('#max_nominal').val() == "" || $('#max_nominal').val() == null) {
      $('#max_nominal').addClass('is-invalid');
      $('#max_nominal').focus();
    } else {
      $('#insert_jenis_biaya').prop('disabled', true);
      $.ajax({
        url: '<?php echo base_url() ?>eaf/master_jenis_biaya/insert_jenis_biaya',
        type: 'post',
        dataType: 'json',
        data: $('#form_jenis_biaya').serialize(),
        success: function(response) {
          $('#modal_jenis_biaya').modal('hide');
          $('#insert_jenis_biaya').prop('disabled', false);
          $('#form_jenis_biaya')[0].reset();
          swal("Success", "Data Jenis Biaya Has Been Saved", "success")
          $('#dt_list_jenis_biaya').DataTable().ajax.reload();

          budget.setSelected('-- Pilih Budget --');
          tipe_biaya.setSelected('-- Pilih Tipe Biaya --');
          user_approval1.setSelected('-- Pilih User Approval --');
          user_approval2.setSelected('-- Pilih User Approval --');
          company_id.setSelected('-- Pilih Company --');

        },
        error: function(xhr, textStatus, errorThrown) {
          console.log(xhr.responseText);
        }
      });
    }
  }

  function updateRupiah(id) {
    let inputField = document.getElementById(id);
    let formattedValue = formatRupiahInput(inputField.value);
    inputField.value = formattedValue;
  }

  function formatRupiahInput(input) {
    let numberString = input.replace(/[^,\d]/g, '').toString(),
      split = numberString.split(','),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
      let separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
    return rupiah;
  }
</script>