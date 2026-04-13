<!-- Required Jquery -->
<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>

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

    var periode = moment().format('YYYY-MM');
    data_list_denda(periode);

    // function cb(periode) {      
    // }

    $('#periode').datepicker({
            format: "yyyy-mm",
            startView: "months", 
            minViewMode: "months",
            autoclose: true,            
    });

    $('#periode_denda').datepicker({
            format: "yyyy-mm",
            startView: "months", 
            minViewMode: "months",
            autoclose: true,            
    });

    // addnew
    $('#periode_denda_rekom').datepicker({
            format: "yyyy-mm",
            startView: "months", 
            minViewMode: "months",
            autoclose: true,            
    });

    $('#periode').on('changeDate', function(e) {
        var periode = $('#periode').val();
        data_list_denda(periode);
    });

    // $("#periode").datepicker( {
    //   format: "yyyy-mm",
    //   startView: "months", 
    //   minViewMode: "months",
    //   autoclose: true,
    // });

    // cb(periode);

    kary = new SlimSelect({
      select: "#karyawan"
    });

    // $('#btn_filter').on('click', function() {
    //   start = $('#start').val();
    //   end = $('#end').val();
    //   // data_lock_absen(start, end);
    // });

    $("#karyawan").change(function() {
      user = $("#karyawan").val().toString().split(",");
      $("#user").val(user);
      department_name = $('#karyawan option:selected').data('department_name');
      designation_name = $('#karyawan option:selected').data('designation_name');

      $("#department_name").val(department_name);
      $("#designation_name").val(designation_name);


    })

    $("#btn_save").click(function(){
      if ($("#tipe :selected").val() == "#") {
        swal("Warning","Please choose Type!","error");
      }else if ($("#karyawan :selected").val() == "#") {
        swal("Warning","Please choose Employee!!","error");
      } else if ($("#karyawan :selected").val() == "") {
        swal("Warning","Please choose Employee!!","error");
      } else if ($("#periode_denda").val() == "") {
        swal("Warning","Please Input Periode Denda!!","error");
      } else if ($("#nominal_denda").val() == "") {
        swal("Warning","Please Input Nominal!!","error");
      } else if ($("#alasan").val() == "") {
        swal("Warning","Please enter your reason!!","error");
      } else {
        console.info('m ' + $("#karyawan :selected").val());
        // console.log('save denda..'); return;

        // devnew
        let formData = new FormData($("#form_denda")[0]);

        $.ajax({
          method: "POST",
          url: "<?= base_url("trusmi_denda/save_denda_dev") ?>",
          dataType: "JSON",
          processData: false,
          contentType: false,
          data: formData,
          // data: $("form").serialize(),
          beforeSend: function (res){
            $("#btn_save").attr("disabled",true);
            $('#spinner').modal('show');  
          },
          success: function (res){
            $("#modal_add_lock").modal("hide");
            console.log(res);
            swal("Success!!", "Data has been saved", "success");
            $("#dt_list_denda").DataTable().ajax.reload();
            $("#btn_save").removeAttr("disabled");
            $("#form_denda")[0].reset();
            // untuk set default slim select
            kary.setSelected([]);
            setTimeout(() => {
              $('#spinner').modal('hide');
            }, 1000);
          },
          error: function (jqXHR, textStatus, errorThrown){
            console.log(jqXHR.responseText);
          }
        })
      }
    });

    // addnew
    $('#btn_rekomendasi_denda').on('click', function() {
        dt_rekomendasi_denda()
        $('#modal_list_rekomendasi').modal('show');
    });


  });

  function add_lock() {
    $('#modal_add_lock').modal('show');
  }

  function data_list_denda(periode) {
    // console.log(`start : ${start}, end : ${end}`);
    var tabel_lock_absen =
      $('#dt_list_denda').DataTable({
        "lengthChange": false,
        "searching": true,
        "info": true,
        "paging": true,
        "autoWidth": false,
        "destroy": true,
        dom: 'Bfrtip',
        buttons: [{
          extend: 'excelHtml5',
          text: 'Export to Excel',
          footer: true
        }],
        "ajax": {
          "dataType": 'json',
          "type": "POST",
          "data": {
            periode: periode,
          },
          "url": "<?= base_url('trusmi_denda/get_dt_denda') ?>"
        },
        "columns": [
          {
            'data': 'id',
            'className': 'text-center'
          },
          {
            'data': 'tipe',
            'render':function(data, type, row){
              var bg = '';
              if(data == 'Denda'){
                bg = 'danger'
              } else if(data == 'Reward'){
                bg = 'success'
              }else{
                bg = 'secondary'
              }
              return `<span class="badge bg-${bg}">${data}</span>`;
            }
          },
          {
            'data': 'employee_name'
          },
          {
            'data': 'company_name',
            'render': function (data, type, row){
              return `${data}`;
            }
          },
          {
            'data': 'department_name',
            'render': function (data, type, row){
              return `${data}`;
            }
          },
          {
            'data': 'designation_name',
            'render': function (data, type, row){
              return `${data}`;
            }
          },
          {
            'data': 'nominal',
            'render': function (data, type, row){
              return `Rp. ` + formatRupiah(data);

            }
          },          
          {
            'data': 'keterangan'
          },
          // devnew
          {
            'data': 'dokumen',
            'render': function (data, type, row) {
                if (data && data !== "") {
                    // URL file
                    let url = "<?= base_url('uploads/trusmi_denda/') ?>" + data;

                    // Tampilkan tombol preview
                    return `
                        <a href="${url}" target="_blank" class="badge bg-primary">
                            <i class="bi bi-eye"></i> View
                        </a>
                    `;
                } else {
                    return `<span class="badge bg-secondary">No File</span>`;
                }
            },
            'className': 'text-center'
          },
          {
            'data': 'id_rekomendasi',
            'render': function (data) {
              if (data > 0) {
                return '<span class="badge bg-success">Auto Denda</span>';
              } else {
                return '<span class="badge bg-danger">Input</span>';
              }
            }
          },
          {
            'data': 'periode'
          },
          {
            'data': 'denda_at'
          },
          {
            'data': 'denda_by'
          },
        ]
      });
  }

  // addnew
  function dt_rekomendasi_denda() {
      company = $('#company').val();
      department = $('#department').val();
      periode = $('#periode').val();
      // start = $('#periode').val() + "-01";
      // end = $('#periode').val() + "-31";

      $('#dt_rekomendasi_denda').DataTable({
          "searching": true,
          "info": true,
          "paging": true,
          "destroy": true,
          "dom": 'Bfrtip', // Add Buttons to the DOM
          "buttons": [{
              extend: 'excelHtml5',
              text: 'Export to Excel',
              className: 'btn btn-success'
          }],
          "ajax": {
              "dataType": 'json',
              "type": "POST",
              "data": {
                  company: company,
                  department: department,
                  periode: periode
              },
              "url": "<?= base_url('trusmi_denda/dt_rekomendasi_denda') ?>",
          },
          "columns": [
              {
                  "data": "karyawan"
              },
              {
                  "data": "status",
                  "render": function(data, type, row, meta) {
                      return `<a class="badge bg-warning text-black mb-1" style="cursor:pointer;" onclick='open_rekomendasi(${JSON.stringify(row)})' data-bs-toggle="modal" data-bs-target="#modal_form_rekom_denda"><i class="bi bi-pencil-square"></i> Waiting</a>`;
                  }
              },
              {
                  "data": "company"
              },
              {
                  "data": "department"
              },
              {
                  "data": "designation"
              },
              {
                  "data": "date_of_joining"
              },
              // {
              //     "data": "tahun",
              //     "render": function(data, type, row, meta) {
              //         return `${data} Tahun ${row['bulan']} bulan`;
              //     }
              // },
              {
                  "data": "masa_kerja"
              },
              {
                  "data": "denda"
              }
          ]
      });
  }

  // function open_rekomendasi22(data) {
  //     $('#data_rekom').addClass('d-none');
  //     $('#div_reject_note').addClass('d-none');
  //     $('#btn_save_warning_rekom').addClass('d-none');
  //     $('#form_add_warning_rekom')[0].reset();
  //     $('#penalty_id').val(data.id);
  //     $('#company_form_name').val(data.company);
  //     $('#company_form_rekom').val(data.company_id);
  //     $('#employee_name').val(data.karyawan);
  //     $('#employee_rekom').val(data.user_id);
  //     $('#warning_type_rekom').val(data.tipe);
  //     $("#warning_type_rekom option:selected").attr('disabled','disabled')
  //     $('#result_investigation_rekom').val(data.penalty);


  //     $('#text_karyawan').text(data.karyawan);
  //     $('#text_company').text(data.company);
  //     $('#text_department').text(data.department);
  //     $('#text_designation').text(data.designation);
  //     $('#text_date_of_joining').text(data.date_of_joining);
  //     $('#text_masa_kerja').text(data.masa_kerja);

  //     $('#profil').css('background-image', data.profil);
  //     $('#img_profil').attr('src', data.profil);

  // }

  // $('#status_denda_rekom22').on('change', function() {
  //     if ($(this).val() == '1') {
  //         $('#div_data_rekom').removeClass('d-none');
  //         $('#data_rekom').removeClass('d-none');
  //         $('#div_reject_note').addClass('d-none');
  //         $('#btn_save_warning_rekom').removeClass('d-none');
  //     } else if ($(this).val() == '2') {
  //         $('#div_data_rekom').addClass('d-none');
  //         $('#data_rekom').addClass('d-none');
  //         $('#div_reject_note').removeClass('d-none');
  //         $('#btn_save_warning_rekom').removeClass('d-none');
  //     } else {
  //         $('#div_data_rekom').addClass('d-none');
  //         $('#data_rekom').addClass('d-none');
  //         $('#div_reject_note').addClass('d-none');
  //         $('#btn_save_warning_rekom').addClass('d-none');
  //     }
  // });
    

  function open_rekomendasi(data) {
    $('#div_data_rekom').addClass('d-none');
      $('#form_add_denda_rekom')[0].reset();
    
    // addnew
    $('#periode_denda_rekom').val(data.periode);
    $('#reason_denda_rekom').val(data.denda);
    $('#id_user_denda_rekom').val(data.user_id);

      $('#text_karyawan').text(data.karyawan);
      $('#text_company').text(data.company);
      $('#text_department').text(data.department);
      $('#text_designation').text(data.designation);
      $('#text_date_of_joining').text(data.date_of_joining);
      $('#text_masa_kerja').text(data.masa_kerja);
    $('#alasan_rekom').text(data.denda);
    $('#id_rekomendasi').val(data.id);

    $('#profil').css('background-image', 'url("'+data.profil+'")');
      $('#img_profil').attr('src', data.profil);

    console.log('profil ' + data.profil)
  }

  $('#status_denda_rekom').on('change', function() {
        if ($(this).val() == '1') {
      $('#div_rekom').show();
      $('#btn_save_denda_rekom').show();
      $('#div_reject_note').hide();
        } else if ($(this).val() == '2') {
      $('#div_rekom').hide();
      $('#btn_save_denda_rekom').show();
      $('#div_reject_note').show();
        } else {
      $('#div_reject_note').hide();
      $('#div_rekom').hide();
      $('#btn_save_denda_rekom').hide();
    }
  });

  function save_denda_rekom() {

    if ($('#status_denda_rekom').val() == '2' && $('#reject_note').val() == '') {
      swal("Warning","Please Input Reject Note!!","error");
    } else if ($('#status_denda_rekom').val() == '1' && $("#periode_denda_rekom").val() == "") {
      swal("Warning","Please Input Periode Denda!!","error");
    } else if ($('#status_denda_rekom').val() == '1' && $("#nominal_denda_rekom").val() == "") {
      swal("Warning","Please Input Nominal!!","error");
    } else if ($('#status_denda_rekom').val() == '1' && $("#alasan_rekom").val() == "") {
      swal("Warning","Please enter your reason!!","error");
    } else {

      let form = new FormData($('#form_add_denda_rekom')[0]);
      $.ajax({
          url: "<?= base_url('trusmi_denda_ade/save_denda_rekom') ?>",
          method: "POST",
          data: form,
          dataType: "JSON",
          processData: false,
          contentType: false,
          beforeSend: function() {
              $('#btn_save_denda_rekom').attr('disabled', true);
          },
          success: function(res) {
              if (res.insert_lock == true) {
                  swal("Success",'Berhasil menambahkan data','success');
                  $('#modal_form_rekom_denda').modal('hide');
                  $('#btn_save_denda_rekom').removeAttr('disabled');
                  $('#dt_list_denda').DataTable().ajax.reload();
                  $('#div_reject_note').hide();
                  $('#div_rekom').hide();
                  $('#btn_save_denda_rekom').hide();
              } else if (res.rekomen_denda == true) {
                  swal("Success",'Berhasil menambahkan data','success');
                  $('#modal_form_rekom_denda').modal('hide');
                  $('#btn_save_denda_rekom').removeAttr('disabled');
                  $('#dt_list_denda').DataTable().ajax.reload();
                  $('#div_reject_note').hide();
                  $('#div_rekom').hide();
                  $('#btn_save_denda_rekom').hide();
              } else {
                  swal("Perhatian!",'Gagal menambahkan data','error');
                  $('#btn_save_denda_rekom').removeAttr('disabled');
              }
        }
    });
    }
  }


  // function unlocked(id){
    
  //   karyawan = $(".get_data_karyawan").data('karyawan_new');
  //   alasan = $(".get_data_karyawan").data('alasan_new');

  //   $("#e_karyawan").val(karyawan);
  //   $("#e_alasan").val(alasan);
  //   $("#e_id").val(id);
  //   $("#modal_unlock").modal("show");
  // }

  // function save_unlock(){
  //   $.ajax({
  //     method: "POST",
  //     url: "<?php echo base_url("trusmi_lock/update_lock") ?>",
  //     dataType: "JSON",
  //     data: $("#form_unlock").serialize(),
  //     beforeSend: function (res){
  //       $("#btn_unlock").attr("disabled",true);
  //     },
  //     success: function(res){
  //       console.log(res);
  //       swal("Success!!", "Employee has been unlocked", "success");
  //       $("#modal_unlock").modal("hide");
  //       $("#btn_unlock").removeAttr("disabled");
  //       $("#dt_lock_absen").DataTable().ajax.reload();
  //     },
  //     error: function(jqXHR){
  //       console.log(jqXHR.responseText);
  //     }
  //   })
  // }

  function formatRupiah(input) {
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

  function updateRupiah(id) {
        let inputField = document.getElementById(id);
       
        let formattedValue = formatRupiah(inputField.value);
        inputField.value = formattedValue;               
  }
</script>