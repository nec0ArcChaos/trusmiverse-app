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

<!-- Summer Note css/js -->
<link href="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.css" rel="stylesheet">
<script src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/dropdown.js"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>

<script type="text/javascript">
  const tabButtons = document.querySelectorAll('#myTab .nav-link');

  function updateSteps() {
    let currentFound = false;
    tabButtons.forEach((btn, index) => {
      btn.classList.remove('step-completed', 'step-current', 'step-upcoming');

      if (!currentFound) {
        if (btn.classList.contains('active')) {
          btn.classList.add('step-current');
          btn.setAttribute('data-step', (index + 1)); // angka step
          currentFound = true;
        } else {
          btn.classList.add('step-completed');
          btn.setAttribute('data-step', '✔'); // ganti jadi centang
        }
      } else {
        btn.classList.add('step-upcoming');
        btn.setAttribute('data-step', (index + 1)); // angka step
      }
    });
  }


  // Initial state
  updateSteps();

  // Update after tab change
  tabButtons.forEach(btn => {
    btn.addEventListener('shown.bs.tab', updateSteps);
  });
</script>

<script type="text/javascript">

  $(document).ready(function() {
    list_problem('<?= date("Y-m-01"); ?>', '<?= date("Y-m-t"); ?>');

    /*Range*/
    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
      $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      $('input[name="start"]').val(start.format('YYYY-MM-DD'));
      $('input[name="end"]').val(end.format('YYYY-MM-DD'));
      list_problem(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));

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

    momId = '<?= $this->uri->segment(3); ?>';

    // if (momId) {
    //   add_problem();
    //   $("#id_mom").val(momId);
    //   // $(".pilihan_status").removeClass('d-none');
    // }

  });

  function add_problem() {
    $("#modal_add_problem").modal("show");

    $("#why1-tab").addClass("disabled").attr("disabled", true);
    $("#why2-tab").addClass("disabled").attr("disabled", true);
    $("#why3-tab").addClass("disabled").attr("disabled", true);
    $("#why4-tab").addClass("disabled").attr("disabled", true);
    $("#why5-tab").addClass("disabled").attr("disabled", true);
    $("#solving-tab").addClass("disabled").attr("disabled", true);
  }

  function reconscructSentences(step, sentences)
  {
    return fix = sentences.map((sentence) => {
      if (sentence.trim()) {
        // Tambahkan titik jika tidak ada (karena mungkin dihapus saat pemrosesan sebelumnya)
        if (!sentence.trim().endsWith('.')) sentence += '.';

        // Pisahkan nomor di awal (misalnya "1.") dan isi kalimat
        let match = sentence.match(/^(\d+\.)\s*(.+)/);
        if (match) {
          let number = match[1];    // Contoh: "1."
          let content = match[2];   // Contoh: "Kabel daya tidak terhubung ke stop kontak."

          // Escape karakter yang bisa rusak di HTML/JS
          let escapedContent = content
            .replace(/'/g, "\\'")
            .replace(/"/g, '&quot;')
            .replace(/\n/g, '\\n');

          return `${number} ${content} <i class="fa fa-copy" style="cursor: pointer;" onclick="copyText(${step},'${escapedContent}')"></i>`;
        } else {
          // Tidak ada nomor, langsung tampilkan dengan ikon copy
          let escapedSentence = sentence
            .replace(/'/g, "\\'")
            .replace(/"/g, '&quot;')
            .replace(/\n/g, '\\n');

          return `${sentence} <i class="fa fa-copy" style="cursor: pointer;" onclick="copyText(${step},'${escapedSentence}')"></i>`;
        }
      }
      return '';
    }).join('<br>');
  }

  function next_problem(step) 
  {
    no_ps = $("#no_ps").val();
    problem = $("#input_problem").val();
    why1 = $("#input_why1").val();
    why2 = $("#input_why2").val();
    why3 = $("#input_why3").val();
    why4 = $("#input_why4").val();
    why5 = $("#input_why5").val();
    solving = $("#input_solving").val();

    if (step == "1" && problem != "") {
      $.ajax({
        url: '<?= base_url('ai_problem_solving/next_problem_why') ?>',
        type: 'POST',
        dataType: 'json',
        data: {
          step: step,
          no_ps: no_ps,
          problem: problem
        },
        beforeSend: function() {
          $(".btn-next").prop('disabled', true).html('Loading <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>');
        },
        success: function(res) {
          $(".btn-next").prop('disabled', false).html('Selanjutnya <i class="bi bi-arrow-right"></i>');

          console.log(res);
          $("#no_ps").val(res.data.no_ps);
          console.log(res.openai);
          
          $("#problem-tab").removeClass("active").addClass("disabled").attr("disabled", true);
          $("#why1-tab").addClass("active");
          $("#problem").removeClass("show active");
          $("#why1").addClass("show active");

          updateSteps();

          $("#why1_text").empty().text("Mengapa "+problem+"?");
          $("#side_problem").empty().text(problem);

          // Bagi berdasarkan baris agar lebih presisi (daripada berdasarkan titik)
          let sentences = res.openai.split(/\r?\n/);
          let reconstructedText = reconscructSentences(step,sentences);
          $("#why1_jawaban").empty().html(reconstructedText);

        }
      });
    } else if (step == "2" && why1 != "") {
      $.ajax({
        url: '<?= base_url('ai_problem_solving/next_problem_why') ?>',
        type: 'POST',
        dataType: 'json',
        data: {
          step: step,
          no_ps: no_ps,
          problem: why1
        },
        beforeSend: function() {
          $(".btn-next").prop('disabled', true).html('Loading <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>');
        },
        success: function(res) {
          $(".btn-next").prop('disabled', false).html('Selanjutnya <i class="bi bi-arrow-right"></i>');

          console.log(res);
          // $("#no_ps").val(res.data.no_ps);
          console.log(res.openai);
          
          $("#why1-tab").removeClass("active").addClass("disabled").attr("disabled", true);
          $("#why2-tab").addClass("active");
          $("#why1").removeClass("show active");
          $("#why2").addClass("show active");

          updateSteps();

          $("#why2_text").empty().text("Mengapa "+why1.substring(0, why1.length-1)+"?");
          $("#side_why1").empty().text(why1);

          // Bagi berdasarkan baris agar lebih presisi (daripada berdasarkan titik)
          let sentences = res.openai.split(/\r?\n/);
          let reconstructedText = reconscructSentences(step,sentences);
          $("#why2_jawaban").empty().html(reconstructedText);
        }
      });
    } else if (step == "3" && why2 != "") {
      $.ajax({
        url: '<?= base_url('ai_problem_solving/next_problem_why') ?>',
        type: 'POST',
        dataType: 'json',
        data: {
          step: step,
          no_ps: no_ps,
          problem: why2
        },
        beforeSend: function() {
          $(".btn-next").prop('disabled', true).html('Loading <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>');
        },
        success: function(res) {
          $(".btn-next").prop('disabled', false).html('Selanjutnya <i class="bi bi-arrow-right"></i>');
          console.log(res);
          // $("#no_ps").val(res.data.no_ps);
          console.log(res.openai);
          
          $("#why2-tab").removeClass("active").addClass("disabled").attr("disabled", true);
          $("#why3-tab").addClass("active");
          $("#why2").removeClass("show active");
          $("#why3").addClass("show active");

          updateSteps();

          $("#why3_text").empty().text("Mengapa "+why2.substring(0, why2.length-1)+"?");
          $("#side_why2").empty().text(why2);

          // Bagi berdasarkan baris agar lebih presisi (daripada berdasarkan titik)
          let sentences = res.openai.split(/\r?\n/);
          let reconstructedText = reconscructSentences(step,sentences);
          $("#why3_jawaban").empty().html(reconstructedText);
        }
      });
    } else if (step == "4" && why3 != "") {
      $.ajax({
        url: '<?= base_url('ai_problem_solving/next_problem_why') ?>',
        type: 'POST',
        dataType: 'json',
        data: {
          step: step,
          no_ps: no_ps,
          problem: why3
        },
        beforeSend: function() {
          $(".btn-next").prop('disabled', true).html('Loading <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>');
        },
        success: function(res) {
          $(".btn-next").prop('disabled', false).html('Selanjutnya <i class="bi bi-arrow-right"></i>');
          console.log(res);
          // $("#no_ps").val(res.data.no_ps);
          console.log(res.openai);
          
          $("#why3-tab").removeClass("active").addClass("disabled").attr("disabled", true);
          $("#why4-tab").addClass("active");
          $("#why3").removeClass("show active");
          $("#why4").addClass("show active");

          updateSteps();

          $("#why4_text").empty().text("Mengapa "+why3.substring(0, why3.length-1)+"?");
          $("#side_why3").empty().text(why3);

          // Bagi berdasarkan baris agar lebih presisi (daripada berdasarkan titik)
          let sentences = res.openai.split(/\r?\n/);
          let reconstructedText = reconscructSentences(step,sentences);
          $("#why4_jawaban").empty().html(reconstructedText);
        }
      });
    } else if (step == "5" && why4 != "") {
      $.ajax({
        url: '<?= base_url('ai_problem_solving/next_problem_why') ?>',
        type: 'POST',
        dataType: 'json',
        data: {
          step: step,
          no_ps: no_ps,
          problem: why4
        },
        beforeSend: function() {
          $(".btn-next").prop('disabled', true).html('Loading <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>');
        },
        success: function(res) {
          $(".btn-next").prop('disabled', false).html('Selanjutnya <i class="bi bi-arrow-right"></i>');
          console.log(res);
          // $("#no_ps").val(res.data.no_ps);
          console.log(res.openai);

          console.log(typeof res.openai, 'Type : ');
          
          $("#why4-tab").removeClass("active").addClass("disabled").attr("disabled", true);
          $("#why5-tab").addClass("active");
          $("#why4").removeClass("show active");
          $("#why5").addClass("show active");

          updateSteps();

          $("#why5_text").empty().text("Mengapa "+why4.substring(0, why4.length-1)+"?");
          $("#side_why4").empty().text(why4);

          // Bagi berdasarkan baris agar lebih presisi (daripada berdasarkan titik)
          let sentences = res.openai.split(/\r?\n/);
          let reconstructedText = reconscructSentences(step,sentences);
          $("#why5_jawaban").empty().html(reconstructedText);
        }
      });
    } else if (step == "6" && why5 != "") {
      $.ajax({
        url: '<?= base_url('ai_problem_solving/next_problem_why') ?>',
        type: 'POST',
        dataType: 'json',
        data: {
          step: step,
          no_ps: no_ps,
          problem: why5
        },
        beforeSend: function() {
          $(".btn-next").prop('disabled', true).html('Loading <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>');
        },
        success: function(res) {
          $(".btn-next").prop('disabled', false).html('Selesai <i class="bi bi-arrow-right"></i>');
          console.log(res);
          // $("#no_ps").val(res.data.no_ps);
          console.log(res.openai);

          console.log(typeof res.openai, 'Type : ');
          
          $("#why5-tab").removeClass("active").addClass("disabled").attr("disabled", true);
          $("#solving-tab").addClass("active");
          $("#why5").removeClass("show active");
          $("#solving").addClass("show active");

          updateSteps();

          $("#solving_text").empty().text(why5);
          $("#side_why5").empty().text(why5);

          // Bagi berdasarkan baris agar lebih presisi (daripada berdasarkan titik)
          let sentences = res.openai.split(/\r?\n/);
          // let reconstructedText = reconscructSentences(step,sentences);
          let reconstructedText = res.openai.replace(/(?:\r\n|\r|\n)/g, '<br>');
          reconstructedText = reconstructedText.replace(/\*\*(.*?)\*\*/g, '<b>$1</b>');
          $("#solving_jawaban").empty().html(reconstructedText);
        }
      });
    } else if (step == "7" && solving != "") {
      $.ajax({
        url: '<?= base_url('ai_problem_solving/next_problem_why') ?>',
        type: 'POST',
        dataType: 'json',
        data: {
          step: step,
          no_ps: no_ps,
          problem: solving,
          id_mom: id_mom
        },
        beforeSend: function() {
          $(".btn-next").prop('disabled', true).html('Loading <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>');
        },
        success: function(res) {
          $(".btn-next").prop('disabled', false).html('Selesai <i class="bi bi-arrow-right"></i>');
          console.log(res);

          updateSteps();          

          $("#modal_add_problem").modal('hide');
          // $("#dt_list_problem").DataTable().ajax.reload();          
          location.reload();          

          swal({
            icon: 'success',
            title: 'Terima kasih!',
            text: 'Masalah Anda berhasil di simpan!',
            buttons: {
              confirm: {
                text: 'OK',
                value: true,
                visible: true,
                className: '',
                closeModal: true
              }
            },
            timer: 3000
          });
        }
      });
    }
  }

  function copyText(id, teks) 
  {
    console.log(id,teks);
    if (id == 6) {
      $(`#input_solving`).val(teks);
    } else {
      $(`#input_why${id}`).val(teks);
    }
  }

  function list_problem(start, end) {
    $('#dt_list_problem').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      "order": [[ 0, "desc" ]],
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List Problem Solving',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('ai_problem_solving/list_problem') ?>",
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
      "columns": [{
          'data': 'no_ps',
          'render': function(data, type, row) {
            res = data;
            if (row['status_id'] < 3) { // 1 : Waiting, 2 : Progress
              res = `<a href="javascript:void(0);" class="badge bg-sm bg-primary" onclick="proses_resume('${data}')">${data}</a>`;
            }
            return res;
          },
          'className': 'text-center'
        },
        {
          'data': 'problem'
        },
        {
          'data': 'rekom_why_1'
        },
        {
          'data': 'why_1',
          'render': function(data, type, row) {
            return (data == null) ? '' : data;
          },
          'className': 'text-center'
        },
        {
          'data': 'rekom_why_2'
        },
        {
          'data': 'why_2',
          'render': function(data, type, row) {
            return (data == null) ? '' : data;
          },
          'className': 'text-center'
        },
        {
          'data': 'rekom_why_3'
        },
        {
          'data': 'why_3',
          'render': function(data, type, row) {
            return (data == null) ? '' : data;
          },
          'className': 'text-center'
        },
        {
          'data': 'rekom_why_4'
        },
        {
          'data': 'why_4',
          'render': function(data, type, row) {
            return (data == null) ? '' : data;
          },
          'className': 'text-center'
        },
        {
          'data': 'rekom_why_5'
        },
        {
          'data': 'why_5',
          'render': function(data, type, row) {
            return (data == null) ? '' : data;
          },
          'className': 'text-center'
        },
        {
          'data': 'rekom_solving'
        },
        {
          'data': 'solving',
          'render': function(data, type, row) {
            return (data == null) ? '' : data;
          },
          'className': 'text-center'
        },
        {
          'data': 'created_by',
          'render': function(data, type, row) {
            return `<span>${data}</span><br>
            <hr style="margin-top:3px;margin-bottom:3px;">
            <p class="mb-0 text-muted small"><i class="bi bi-clock"></i> ${row['created_at']}</p>`;
          },
          'width': '20%'
        }
      ]
    });
  }

</script>