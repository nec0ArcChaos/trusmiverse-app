<!-- Required Jquery -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery/js/jquery.min.js"></script> -->
<!-- Autocomplete -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/autocomplete.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap/js/bootstrap.min.js"></script> -->
<!-- jquery slimscroll js -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script> -->
<!-- data-table js -->
<!-- <script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script> -->
<!-- i18next.min.js -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/advance-elements/moment-with-locales.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script> -->
<!-- Date-range picker js -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/bootstrap-daterangepicker/js/daterangepicker.js"></script>

<script src="<?php echo base_url(); ?>assets/js/pcoded.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/demo-12.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/script.js"></script> -->
<!-- Datatable Button -->
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script> -->

<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>

<!-- view images -->
<!-- <script type="text/javascript" src="<?= base_url('assets/fancybox/jquery.fancybox.min.js') ?>"></script> -->

<!-- slim select js -->
<!-- <script src="<?php echo base_url(); ?>assets/js/slimselect.min.js"></script> -->

<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>

<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>

<!-- Datetimepicker Full -->
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<!-- Jquery Confirm -->
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>

<script type="text/javascript">
  // var table_ajax;

  $(document).ready(function() {

    list_briefing('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');
    dt_lock_brif_d_v1(null, null);
    dt_lock_brif_w_v1(null, null);

    /*Range*/
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
      $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="start"]').val(start.format('YYYY-MM-DD'));
      $('input[name="end"]').val(end.format('YYYY-MM-DD'));
      list_briefing(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
      dt_lock_brif_d_v1(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
      dt_lock_brif_w_v1(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));

    }

    $('.range').daterangepicker({
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

  });

  function save_briefing()
  {
    review    = $(`#review`).val();
    plan      = $(`#plan`).val();
    informasi = $(`#informasi`).val();
    motivasi  = $(`#motivasi`).val();

    if ($("#review").val() == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Review Kemarin belum terisi!',
        buttons: {
            close: {
                actions: function() {}
            },
        },
      });
    } else if ($("#plan").val() == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Plan hari ini belum terisi!',
        buttons: {
            close: {
                actions: function() {}
            },
        },
      });
    } else if ($("#informasi").val() == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Informasi atau SOP belum terisi!',
        buttons: {
            close: {
                actions: function() {}
            },
        },
      });
    } else if ($("#motivasi").val() == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Motivasi belum terisi!',
        buttons: {
            close: {
                actions: function() {}
            },
        },
      });
    } else if ($("#foto").val() == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Foto belum terisi!',
        buttons: {
            close: {
                actions: function() {}
            },
        },
      });
    } else {
      // Please waiting      
      let foto = $(`#foto`).prop("files")[0];
      let form_file = new FormData();         
      form_file.append("review", review);
      form_file.append("plan", plan);
      form_file.append("informasi", informasi);
      form_file.append("motivasi", motivasi);
      form_file.append("foto", foto);

      $.confirm({
        icon: 'fa fa-spinner fa-spin',
        title: 'Please wait!',
        theme: 'material',
        type: 'blue',
        content: 'Processing...',
        buttons: {
            close: {
                isHidden: true,
                actions: function() {}
            },
        },
        onOpen: function() {
          $.ajax({
            method: "POST",
            url: "<?= base_url("briefing/save_briefing") ?>",
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,
            data: form_file,
            beforeSend: function (res){
              $("#btn_save").attr("disabled",true);
            },
            success: function (res){
              console.log(res);
              $.confirm({
                icon: 'fa fa-check',
                title: 'Success',
                theme: 'material',
                type: 'green',
                content: 'Briefing has been saved!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
              });
              $("#dt_list_briefing").DataTable().ajax.reload();
              $("#modal_add_briefing").modal("hide");
              $("#form_briefing")[0].reset();
              $("#btn_save").removeAttr("disabled");
              jconfirm.instances[0].close();
            },
            error: function (jqXHR, textStatus, errorThrown){
              console.log(jqXHR.responseText);
              jconfirm.instances[0].close();
            }
          });
        }
      });
    }
  }

  function list_briefing(start,end)
  {
    $('#dt_list_briefing').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List Briefing',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('briefing/list_briefing') ?>",
        "dataType": 'JSON',
        "type": "POST",
        "data": {
          start: start,
          end: end
        },
        // "success": function (res){
        //   console.log(res);
        // },
        // "error": function (jqXHR){
        //   console.log(jqXHR.responseText);
        // }
      },
      "columns": [
        {
          'data': 'id_briefing',
          // 'render': function(data,type,row){
          //   return `<a href="javascript:void(0);" class="badge bg-sm bg-primary" onclick="result_gemba('${data}')">${data}</a>`;
          // },
          // 'className': 'text-center'
        },
        {
          'data': 'review'
        },
        {
          'data': 'plan'
        },
        {
          'data': 'informasi'
        },
        {
          'data': 'motivasi'
        },
        {
          'data': 'foto',
          'render': function(data,type,row){
            if (data != "") {
              return `<a href="<?= base_url('uploads/briefing/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>`;
            } else {
              return ``;
            }
          }
        },
        {
          'data': 'created_by',
        },
        {
          'data': 'company_name'
        },
        {
          'data': 'department_name'
        },
        {
          'data': 'designation_name'
        },
        {
          'data': 'created_at'
        },
      ]
    });
  }

  function dt_lock_brif_d_v1(start, end) {
    $('#tbl_lock_brif_d_3').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List briefing daily',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('briefing/dt_lock_brif_d_v1') ?>",
        "dataType": 'JSON',
        "type": "POST",
        "data": {
          start: start,
          end: end
        },       
      },
      "columns": [       
        {
          'data': 'employee_name',
          'render': function(data,type,row){
            return data
          },
          'width':'20%'
        },
        {
          'data': 'company_name'
        },
        {
          'data': 'jabatan'
        },
        {
          'data': 'total_lock',
          'render': function(data,type,row){
            if(data > 0){
            return `<span class="text-primary">`+data+`</span><br>`;
            } else {
              return `<span class="text-danger">`+data+`</span><br>`;

            }
            
          },
        },       
        {
          'data': 'lock_t',
          'render': function(data,type,row){
            // console.info(data);
            if(parseInt(data) > 0){
              return `<span class="text-danger">Locked</span><br>`;
            } else {
              return `<span class="text-primary">Unlock</span><br>`;

            }
            
          },
        },        
      ]
    });
  }

  function dt_lock_brif_w_v1(start, end) {
      $.ajax({
          url: '<?= base_url() ?>Briefing/generate_head_resume_v3',
          type: 'POST',
          dataType: 'json',
          data: {
              start: start,
              end: end
          },
          beforeSend: function() {

          },
          success: function(response) {

          },
          error: function(xhr) { // if error occured

          },
          complete: function() {

          },
      }).done(function(response) {
          // console.log(response)
          thead = '';
          thead_th = '';
          // thead = `<tr>
          //             <th>Nama</th>
          //             <th>Company</th>
          //             <th>Jabatan</th>
          //             `;
          // for (let indexa = 0; indexa < response.data.length; indexa++) {
          //     const element = response.data[indexa];
          //     console.log('f_tgl_awal a ' + response.data[indexa].f_tgl_awal);
              // console.log('f_tgl_awal b ' + response.data[0].f_tgl_awal);
              // console.log('length b ' + response.data.length);
              totalminggu = response.data.length;
              // thead += `<th class="small text-center">${response.data[indexa].week_number} <br><span class="small">${response.data[indexa].f_tgl_awal}</span> s/d <span class="small">${response.data[indexa].f_tgl_akhir}</span></th>`;
              if (response.data.length == 6) {
                  thead_th = `<th  class="small text-center">W1 <br><span class="small">${response.data[0].f_tgl_awal}</span> s/d <span class="small">${response.data[0].f_tgl_akhir}</span></th>
                  <th class="small text-center">W2 <br><span class="small">${response.data[1].f_tgl_awal}</span> s/d <span class="small">${response.data[1].f_tgl_akhir}</span></th>
                  <th class="small text-center">W3 <br><span class="small">${response.data[2].f_tgl_awal}</span> s/d <span class="small">${response.data[2].f_tgl_akhir}</span></th>
                  <th class="small text-center">W4 <br><span class="small">${response.data[3].f_tgl_awal}</span> s/d <span class="small">${response.data[3].f_tgl_akhir}</span></th>
                  <th class="small text-center">W5 <br><span class="small">${response.data[4].f_tgl_awal}</span> s/d <span class="small">${response.data[4].f_tgl_akhir}</span></th>
                  <th id="thead_th6" class="small text-center">W6 <br><span class="small">${response.data[5].f_tgl_awal}</span> s/d <span class="small">${response.data[5].f_tgl_akhir}</span></th>
                  `
                  // console.log('666');

              } else if (response.data.length == 5) {
                thead_th = `<th class="small text-center">W1 <br><span class="small">${response.data[0].f_tgl_awal}</span> s/d <span class="small">${response.data[0].f_tgl_akhir}</span></th>
                  <th class="small text-center">W2 <br><span class="small">${response.data[1].f_tgl_awal}</span> s/d <span class="small">${response.data[1].f_tgl_akhir}</span></th>
                  <th class="small text-center">W3 <br><span class="small">${response.data[2].f_tgl_awal}</span> s/d <span class="small">${response.data[2].f_tgl_akhir}</span></th>
                  <th class="small text-center">W4 <br><span class="small">${response.data[3].f_tgl_awal}</span> s/d <span class="small">${response.data[3].f_tgl_akhir}</span></th>
                  <th id="thead_th5" class="small text-center">W5 <br><span class="small">${response.data[4].f_tgl_awal}</span> s/d <span class="small">${response.data[4].f_tgl_akhir}</span></th>
                  `
                  // console.log('555');

              } else if (response.data.length == 4) {
                thead_th = `<th class="small text-center">W1 <br><span class="small">${response.data[0].f_tgl_awal}</span> s/d <span class="small">${response.data[0].f_tgl_akhir}</span></th>
                  <th class="small text-center">W2 <br><span class="small">${response.data[1].f_tgl_awal}</span> s/d <span class="small">${response.data[1].f_tgl_akhir}</span></th>
                  <th class="small text-center">W3 <br><span class="small">${response.data[2].f_tgl_awal}</span> s/d <span class="small">${response.data[2].f_tgl_akhir}</span></th>
                  <th class="small text-center">W4 <br><span class="small">${response.data[3].f_tgl_awal}</span> s/d <span class="small">${response.data[3].f_tgl_akhir}</span></th>
                  `
              }

          thead = `<tr>
                      <th>Nama</th>
                      <th>Company</th>
                      <th>Jabatan</th>
                      ${thead_th}
                      `;
          thead += `</tr>`;

          tbody = '';
          for (let index = 0; index < response.body_resume.length; index++) {
              // console.log('length ' + response.data.length);
              // console.log('index b ' + index);
             
              tbody_td = '';
              if (response.data.length == 6) {
                  tbody_td = `<td>${response.body_resume[index].w1 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w2 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w3 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w4 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w5 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w6 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          `
              } else if (response.data.length == 5) {
                  tbody_td = `<td>${response.body_resume[index].w1 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w2 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w3 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w4 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w5 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          `
              } else if (response.data.length == 4) {
                  tbody_td = `<td>${response.body_resume[index].w1 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${(response.body_resume[index].w2 > 0) ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w3 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w4 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          <td>${response.body_resume[index].w5 > 0 ? '<span class="bi bi-check-lg text-green"></span> Yes' : '<span class="bi bi-x text-red"></span> No'}</td>
                          `
              }
              tbody += `<tr>
                          <td>${response.body_resume[index].employee_name}</td>
                          <td>${response.body_resume[index].company_name}</td>
                          <td>${response.body_resume[index].jabatan}</td>
                          ${tbody_td}
                      </tr>`
          }

          $('#dt_resume_pembelajar_3').empty().append(
              `<thead id="dt_resume_head_3"></thead>
              <tbody id="dt_resume_body_3"></tbody>`
          );
          $('#dt_resume_head_3').empty();
          $('#dt_resume_head_3').append(thead);

          $('#dt_resume_body_3').empty().append(tbody);
          // setTimeout(() => {
              // $('#dt_resume_pembelajar_3').DataTable({
              //     "searching": true,
              //     "info": true,
              //     "paging": true,
              //     "destroy": true,
              //     "autoWidth": false,
              //     "dom": 'Bfrtip',                 
              //     buttons: [{
              //       extend: 'excelHtml5',
              //       title: 'Data List briefing weekly',
              //       text: '<i class="bi bi-download text-white"></i>',
              //       footer: true
              //     }],
              // });
          // }, 10000);
      }).fail(function(jqXhr, textStatus) {

      });
  }
</script>