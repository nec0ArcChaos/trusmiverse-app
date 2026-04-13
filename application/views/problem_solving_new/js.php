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
  // var table_ajax;
  // let id_project = NiceSelect.bind(document.getElementById('project'), {
  //   searchable: true
  // });
  // let id_pekerjaan = NiceSelect.bind(document.getElementById('pekerjaan'), {
  //   searchable: true
  // });
  // let id_sub_pekerjaan = NiceSelect.bind(document.getElementById('sub_pekerjaan'), {
  //   searchable: true
  // });
  // let id_detail_pekerjaan = NiceSelect.bind(document.getElementById('detail_pekerjaan'), {
  //   searchable: true
  // });

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

    depa = new SlimSelect({
      select: "#department_id"
    });

    ct = new SlimSelect({
      select: "#category"
    });

    ctn = new SlimSelect({
      select: "#category_new"
    });

    pt = new SlimSelect({
      select: "#priority"
    });

    fc = new SlimSelect({
      select: "#factor"
    });

    pc = new SlimSelect({
      select: "#pic"
    });

    id_project = new SlimSelect({
      select: "#id_project"
    });

    delegate = new SlimSelect({
      select: "#delegate_escalate_to"
    });

    $('#deadline').datetimepicker({
      format: 'Y-m-d',
      timepicker: false,
      minDate: 0,
    });

    $('#deadline_solution').datetimepicker({
      format: 'Y-m-d',
      timepicker: false,
      minDate: 0,
    });

    $('#problem').summernote({
      placeholder: '...',
      tabsize: 2,
      height: 150,
      toolbar: [
        ['font', ['bold', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
      ]
    });

    $('#solving').summernote({
      placeholder: '...',
      tabsize: 2,
      height: 150,
      toolbar: [
        ['font', ['bold', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
      ]
    });

    $('#resume').summernote({
      placeholder: '...',
      tabsize: 2,
      height: 150,
      toolbar: [
        ['font', ['bold', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
      ]
    });

    $('#tasklist').summernote({
      placeholder: '...',
      tabsize: 2,
      height: 150,
      toolbar: [
        ['font', ['bold', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
      ]
    });

    $('#note_review').summernote({
      placeholder: '...',
      tabsize: 2,
      height: 150,
      toolbar: [
        ['font', ['bold', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
      ]
    });

  });

  function get_pic() {
        department_id = $('#department_id').val();
        if (department_id == '#') {
          return false;
        }
        if (department_id != null) {
            $.ajax({
                url: "<?= base_url('problem_solving_new/get_pic') ?>",
                method: "POST",
                data: {
                    department_id: department_id
                },
                dataType: "JSON",
                beforeSend: function(){
                    pc.destroy();
                },
                success: function(res) {
                    console.log(res);
                    let pic = '<option selected disabled>-Choose PIC-</option>';
                    res.pic.forEach((value, index) => {
                        pic += `<option value = "${value.user_id}"> ${value.employee_name}</option>`;
                    })
                    $('#pic').html(pic);
                    setTimeout(() => {
                        pc = new SlimSelect({
                            select: "#pic"
                        });
                    }, 400);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            })
        }
    }

    function get_pic_delegate() {
        department_id = $('#department_id_proses').val();
        if (department_id != null) {
            $.ajax({
                url: "<?= base_url('problem_solving_new/get_pic') ?>",
                method: "POST",
                data: {
                    department_id: department_id
                },
                dataType: "JSON",
                beforeSend: function(){
                    delegate.destroy();
                },
                success: function(res) {
                    console.log(res);
                    let pic = '<option selected disabled>-Choose PIC-</option>';
                    res.pic.forEach((value, index) => {
                        pic += `<option value = "${value.user_id}"> ${value.employee_name}</option>`;
                    })
                    $('#delegate_escalate_to').html(pic);
                    setTimeout(() => {
                        delegate = new SlimSelect({
                            select: "#delegate_escalate_to"
                        });
                    }, 400);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            })
        }
    }

  $('#addition_area').val(0);
  $('#addition_area').change(function() {
    if ($(this).is(':checked')) {
      $('.div_addition_area').show();
      $(this).val('1');
    } else {
      $('.div_addition_area').hide();
      $(this).val('0');
    }
  });

  $('#check_tindakan').val(0);
  $('#check_tindakan').change(function() {
    if ($(this).is(':checked')) {
      $('.div_check_tindakan').show();
      $(this).val('1');
    } else {
      $('.div_check_tindakan').hide();
      $(this).val('0');
    }
  });

  function add_problem() {
    $("#modal_add_problem").modal("show");
  }

  function save_problem() {
    problem = $("#problem").val();
    solving = $("#solving").val();
    category = $("#category").val();
    category_new = $("#category_new").val();
    priority = $("#priority").val();
    deadline = $("#deadline").val();
    pic = $("#pic").val();
    addition_area = $("#addition_area").val();
    department_id = $("#department_id").val();

    if (problem == "" || problem == '<p><br></p>' || problem == '<br>' || problem == '<p>&nbsp;</p>') {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Problem is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (solving == "" || solving == '<p><br></p>' || solving == '<br>' || solving == '<p>&nbsp;</p>') {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Solving is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (department_id == "#") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Divisi is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (category_new == "#") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Category is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (category == "#") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Factor is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (priority == "#") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Priority is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (deadline == "") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Deadline is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (pic == "#") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'PIC is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if ($('#addition_area').is(':checked') && $("#project :selected").val() == "#") {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Project is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else {
      // Please waiting      
      let file_problem = $(`#file_problem`).prop("files")[0];
      link_problem = $("#link_problem").val();
      let form_file = new FormData();      
      form_file.append("problem", problem);
      form_file.append("solving", solving);
      form_file.append("department_id", $("#department_id").val());
      form_file.append("category_new", category_new);
      form_file.append("category", category);
      form_file.append("priority", priority);
      form_file.append("pic", pic);
      form_file.append("deadline", deadline);
      form_file.append("link_problem", link_problem);
      form_file.append("files", file_problem);
      form_file.append("addition_area", addition_area);
      form_file.append("repetisi", $("#repetisi").val());
      if (addition_area == 1) {
        form_file.append("id_project", $("#id_project").val());
      }

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
            url: "<?= base_url("problem_solving_new/save_problem") ?>",
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,
            data: form_file,
            // data: $("#form_problem").serialize(),
            beforeSend: function(res) {
              $("#btn_save").attr("disabled", true);
            },
            success: function(res) {
              $.confirm({
                icon: 'fa fa-check',
                title: 'Success',
                theme: 'material',
                type: 'green',
                content: 'Data has been saved!',
                buttons: {
                  close: {
                    actions: function() {}
                  },
                },
              });
              jconfirm.instances[0].close();
              $("#dt_list_problem").DataTable().ajax.reload();
              $("#modal_add_problem").modal("hide");
              $("#form_problem")[0].reset();
              ct.setSelected("#");
              ctn.setSelected("#");
              id_project.setSelected("#");
              depa.setSelected("#");
              pt.setSelected("#");
              fc.setSelected("#");
              pc.setSelected("#");
              $("#btn_save").removeAttr("disabled");
              $('#problem').summernote('reset');
              
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(jqXHR.responseText);
              jconfirm.instances[0].close();
            }
          });
        }
      });
    }
  }

  function list_problem(start, end) {
    user_id = "<?= $this->session->userdata('user_id') ?>";
    $('#dt_list_problem').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List Problem Solving',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('problem_solving_new/list_problem') ?>",
        "dataType": 'JSON',
        "type": "POST",
        "data": {
          start: start,
          end: end
        },
      },
      "columns": [{
          'data': 'id_ps',
          'render': function(data, type, row) {
            res = data;
            if (row['status_id'] < 3 && ( row['pic_id'] == user_id || row['delegate_escalate_to'] == user_id )) { // 1 : Waiting, 2 : Progress
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
          'data': 'solving'
        },
        {
          'data': 'file_problem',
          'render': function(data, type, row) {
            if (data != null) {
              return `<a href="<?= base_url('uploads/files_ps/') ?>${data}" target="_blank"><i class="bi bi-printer text-primary"></i></a>`;
            } else {
              return `<span></span>`;
            }
          }
        },
        {
          'data': 'link_problem',
          'render': function(data, type, row) {
            if (data != "") {
              return `<a href="${data}" target="_blank" class="badge bg-sm bg-primary">Link</a>`;
            } else {
              return `<span></span>`;
            }
          }
        },
        {
          'data': 'department_name'
        },
        {
          'data': 'category_new'
        },
        {
          'data': 'category'
        },
        {
          'data': 'priority',
          'render': function(data, type, row) {
            if (row['priority_id'] == 1) {
              color = 'bg-success';
            } else if (row['priority_id'] == 2) {
              color = 'bg-warning';
            } else if (row['priority_id'] == 3) {
              color = 'bg-danger';
            } else if (row['priority_id'] == 4) {
              color = 'bg-danger';
            } 
            return `<span class="badge bg-sm ${color}">${data}</span>`;
          }
        },
        {
          'data': 'pic'
        },
        {
          'data': 'deadline'
        },
        {
          'data': 'project'
        },
        {
          'data': 'tindakan'
        },
        {
          'data': 'resume'
        },
        {
          'data': 'delegate_escalate_name',
          'render': function(data, type, row) {
            return `<span class="badge bg-sm bg-primary" style="cursor:pointer;" onclick='get_history_delegate("${row['id_ps']}")'>${data || ''}</span>`
          }
        },
        {
          'data': 'tasklist'
        },
        {
          'data': 'deadline_solution'
        },
        {
          'data': 'status',
          'render': function(data, type, row) {
            if (row['status_id'] == 1) {
              color = 'bg-warning';
            } else if (row['status_id'] == 2) {
              color = 'bg-info';
            } else if (row['status_id'] == 3) {
              color = 'bg-success';
            } else if (row['status_id'] == 4) {
              color = 'bg-danger';
            } else {
              color = 'bg-secondary';
            }
            return `<span class="badge bg-sm ${color}">${data}</span>`;
          }
        },
        {
          'data': 'repetisi'
        },
        {
          'data': 'rating_feedback',
          'render': function(data, type, row) {
            if (data != null) {
              if (data == 5) {
                color = 'bg-success';
              } else if (data == 4) {
                color = 'bg-info';
              } else if (data == 3) {
                color = 'bg-warning';
              } else {
                color = 'bg-danger';
              }
              return `<span class="badge bg-sm ${color}">${row['rating_feedback']}</span>`;
            } else {
              return `<span></span>`;
            }
          }
        },
        {
          'data': 'feedback'
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

  function get_history_delegate(id_ps) {
    $("#modal_history_delegate").modal("show");

    $('#dt_list_history_delegate').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List Problem Solving',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url("problem_solving_new/get_history_delegate/") ?>" + id_ps,
        "dataType": 'JSON',
        "type": "GET",
      },
      "columns": [{
          'data': 'id_ps',
          'className': 'text-center'
        },
        {
          'data': 'delegate_name',
        },
        {
          'data': 'created_by'
        },
        {
          'data': 'created_at'
        },
      ]
    });
  }

  function list_problem_feedback() {
    user_id = "<?= $this->session->userdata('user_id') ?>";
    $('#dt_list_problem_feedback').DataTable({
      "lengthChange": false,
      "searching": true,
      "info": true,
      "paging": true,
      "autoWidth": false,
      "destroy": true,
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        title: 'Data List Problem Solving',
        text: '<i class="bi bi-download text-white"></i>',
        footer: true
      }],
      "ajax": {
        "url": "<?= base_url('problem_solving_new/list_problem_feedback') ?>",
        "dataType": 'JSON',
        "type": "POST",
      },
      "columns": [{
          'data': 'id_ps',
          'render': function(data, type, row) {
            res = data;
            if (row['tindakan'] == 'solving') {
              res = `<a href="javascript:void(0);" class="badge bg-sm bg-success" onclick="proses_feedback('${data}')">${data}</a>`;
            } else {
              if (row['status_id'] >= 3 && row['feedback'] == null && row['created_by_id'] == user_id) {
                res = `<a href="javascript:void(0);" class="badge bg-sm bg-success" onclick="proses_feedback('${data}')">${data}</a>`;
              }
            }
            return res;
          },
          'className': 'text-center'
        },
        {
          'data': 'problem'
        },
        {
          'data': 'solving'
        },
        {
          'data': 'file_problem',
          'render': function(data, type, row) {
            if (data != "") {
              return `<a href="<?= base_url('uploads/files_ps/') ?>${data}" target="_blank"><i class="bi bi-printer text-primary"></i></a>`;
            } else {
              return `<span></span>`;
            }
          }
        },
        {
          'data': 'link_problem',
          'render': function(data, type, row) {
            if (data != "") {
              return `<a href="${data}" target="_blank" class="badge bg-sm bg-primary">Link</a>`;
            } else {
              return `<span></span>`;
            }
          }
        },
        {
          'data': 'department_name'
        },
        {
          'data': 'category_new'
        },
        {
          'data': 'category'
        },
        {
          'data': 'priority',
          'render': function(data, type, row) {
            if (row['priority_id'] == 1) {
              color = 'bg-success';
            } else if (row['priority_id'] == 2) {
              color = 'bg-warning';
            } else if (row['priority_id'] == 3) {
              color = 'bg-danger';
            } else if (row['priority_id'] == 4) {
              color = 'bg-danger';
            } 
            return `<span class="badge bg-sm ${color}">${data}</span>`;
          }
        },
        {
          'data': 'pic'
        },
        {
          'data': 'deadline'
        },
        {
          'data': 'project'
        },
        {
          'data': 'tindakan'
        },
        {
          'data': 'resume'
        },
        {
          'data': 'delegate_escalate_name'
        },
        {
          'data': 'tasklist'
        },
        {
          'data': 'deadline_solution'
        },
        {
          'data': 'status',
          'render': function(data, type, row) {
            if (row['status_id'] == 1) {
              color = 'bg-warning';
            } else if (row['status_id'] == 2) {
              color = 'bg-info';
            } else if (row['status_id'] == 3) {
              color = 'bg-success';
            } else if (row['status_id'] == 4) {
              color = 'bg-danger';
            } else {
              color = 'bg-secondary';
            }
            return `<span class="badge bg-sm ${color}">${data}</span>`;
          }
        },
        {
          'data': 'repetisi'
        },
        {
          'data': 'rating_feedback',
          'render': function(data, type, row) {
            if (data != null) {
              if (data == 5) {
                color = 'bg-success';
              } else if (data == 4) {
                color = 'bg-info';
              } else if (data == 3) {
                color = 'bg-warning';
              } else {
                color = 'bg-danger';
              }
              return `<span class="badge bg-sm ${color}">${row['rating_feedback']}</span>`;
            } else {
              return `<span></span>`;
            }
          }
        },
        {
          'data': 'feedback'
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

  function list_feedback() {
    $("#modal_list_feedback").modal("show");
    list_problem_feedback();
  }

  function proses_resume(id) {
    $("#modal_proses_resume").modal("show");
    $("#id_ps").val(id);
    get_detail_problem(id);
    setTimeout(() => {
      get_pic_delegate();
    }, 300);
  }

  function proses_feedback(id) {
    $("#modal_proses_feedback").modal("show");
    $("#modal_list_feedback").modal("hide");
    $("#id_ps_feedback").val(id);
    get_detail_problem(id, 'feedback');
  }

  function get_detail_problem(id, type = 'resume') {
    $.ajax({
      method: "GET",
      url: "<?= base_url("problem_solving_new/get_detail_problem/") ?>" + id,
      dataType: "JSON",
      success: function(res) {
        if (type == 'resume') {
          $("#detail_category_new").text(res.category_new);
          $("#detail_category").text(res.category);
          $("#detail_priority").text(res.priority);
          $("#detail_deadline").text(res.deadline);
          $("#detail_department").text(res.department_name);
          $("#detail_pic").text(res.created_by);
          $("#problem_desc").html(res.problem);
          $("#solving_desc").html(res.solving);
          $('#detail_project').text(res.project);
          if (res.id_project != null) {
            $("#div_project").removeClass("d-none");
          } else {
            $("#div_project").addClass("d-none");
          }
          $("#department_id_proses").val(res.department_id);
        } else {
          $("#detail_category_new_feedback").text(res.category_new);
          $("#detail_category_feedback").text(res.category);
          $("#detail_priority_feedback").text(res.priority);
          $("#detail_deadline_feedback").text(res.deadline);
          $("#detail_department_feedback").text(res.department_name);
          $("#detail_pic_feedback").text(res.created_by);
          $("#problem_desc_feedback").html(res.problem);
          $("#solving_desc_feedback").html(res.solving);
          $("#solution_desc_feedback").html(res.resume);
          $('#detail_project_feedback').text(res.project);
          $('#detail_project_feedback').text(res.project);
          if (res.id_project != null) {
            $("#div_project_feedback").removeClass("d-none");
          } else {
            $("#div_project_feedback").addClass("d-none");
          }
          $('#lampiran_feedback').attr('href', '<?= base_url('uploads/files_ps/') ?>' + res.lampiran);
          if (res.lampiran != null) {
            $("#div_lampiran_feedback").removeClass("d-none");
          } else {
            $("#div_lampiran_feedback").addClass("d-none");
          }
          $('#link_feedback').attr('href', res.link_solution);
          $('#link_feedback').text(res.link_solution);
          if (res.link_solution != null) {
            $("#div_link_feedback").removeClass("d-none");
          } else {
            $("#div_link_feedback").addClass("d-none");
          }
          if (res.delegate_escalate_to != null) {
            $("#is_escalate").val(1);
            $('#div_status_feedback').addClass('d-none');
          } else {
            $("#is_escalate").val(0);
            $('#div_status_feedback').removeClass('d-none');
          }

        }
        
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
        jconfirm.instances[0].close();
      }
    });
  }

  function show_tindakan()
  {
    if ($('#status_akhir').val() < 3) {
      $('#show_tindakan').removeClass('d-none');
    } else {
      $('#show_tindakan').addClass('d-none');
    }
  }

  function save_proses_resume() {
    id_ps = $("#id_ps").val();
    
    resume = $("#resume").val();
    check_tindakan = $("#check_tindakan").val();
 
    if (resume == "" || resume == '<p><br></p>' || resume == '<br>' || resume == '<p>&nbsp;</p>') {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Solution is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if ($('#check_tindakan').is(':checked') && ($("#tasklist").val() == "" || $("#tasklist").val() == '<p><br></p>' || $("#tasklist").val() == '<br>' || $("#tasklist").val() == '<p>&nbsp;</p>')) {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Tasklist is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else {
      let lampiran = $(`#lampiran`).prop("files")[0];
      link_solution = $("#link_solution").val();
      let form_proses = new FormData();      
      form_proses.append("id_ps", id_ps);
      form_proses.append("resume", resume);
      form_proses.append("link_solution", link_solution);
      form_proses.append("files", lampiran);
      form_proses.append("check_tindakan", check_tindakan);
      if (check_tindakan == 1) {
        form_proses.append("tindakan", $("#tindakan").val());
        form_proses.append("tasklist", $("#tasklist").val());
        form_proses.append("delegate_escalate_to", $("#delegate_escalate_to").val());
        form_proses.append("deadline_solution", $("#deadline_solution").val());
      }

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
            url: "<?= base_url("problem_solving_new/save_proses_resume") ?>",
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,
            data: form_proses,
            // data: $("#form_proses_resume").serialize(),
            beforeSend: function(res) {
              $("#btn_save_proses_resume").attr("disabled", true);
            },
            success: function(res) {
              console.log(res);
              $.confirm({
                icon: 'fa fa-check',
                title: 'Success',
                theme: 'material',
                type: 'green',
                content: 'Data has been saved!',
                buttons: {
                  close: {
                    actions: function() {}
                  },
                },
              });
              jconfirm.instances[0].close();
              $("#dt_list_problem").DataTable().ajax.reload();
              $("#modal_proses_resume").modal("hide");
              $("#form_proses_resume")[0].reset();
              $("#btn_save_proses_resume").removeAttr("disabled");
              $('#resume').summernote('reset');
              $('#tasklist').summernote('reset');
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(jqXHR.responseText);
              jconfirm.instances[0].close();
            }
          });
        }
      });
    }
  }

  function save_proses_feedback() {
    id_ps = $("#id_ps_feedback").val();
    rating = $("input[name='hasil_review']:checked").val();
    note_review = $("#note_review").val();
    status = $("#status_akhir").val();
    is_escalate = $("#is_escalate").val();

    if (is_escalate == '0') {
      if (status == '#') {
        $.confirm({
          icon: 'fa fa-times-circle',
          title: 'Warning',
          theme: 'material',
          type: 'red',
          content: 'Status is empty!',
          buttons: {
            close: {
              actions: function() {}
            },
          },
        });
      }
    }

    if (rating == undefined) {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Choose rating!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else if (note_review == "" || note_review == '<p><br></p>' || note_review == '<br>' || note_review == '<p>&nbsp;</p>') {
      $.confirm({
        icon: 'fa fa-times-circle',
        title: 'Warning',
        theme: 'material',
        type: 'red',
        content: 'Feedback is empty!',
        buttons: {
          close: {
            actions: function() {}
          },
        },
      });
    } else {

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
            url: "<?= base_url("problem_solving_new/save_proses_feedback") ?>",
            dataType: "JSON",
            // cache: false,
            // contentType: false,
            // processData: false,
            // data: form_proses,
            data: $("#form_proses_feedback").serialize(),
            beforeSend: function(res) {
              $("#btn_save_feedback").attr("disabled", true);
            },
            success: function(res) {
              console.log(res);
              $.confirm({
                icon: 'fa fa-check',
                title: 'Success',
                theme: 'material',
                type: 'green',
                content: 'Data has been saved!',
                buttons: {
                  close: {
                    actions: function() {}
                  },
                },
              });
              jconfirm.instances[0].close();
              $("#dt_list_problem").DataTable().ajax.reload();
              $("#dt_list_problem_feedback").DataTable().ajax.reload();
              $("#modal_proses_feedback").modal("hide");
              $("#modal_list_feedback").modal("show");
              $("#form_proses_feedback")[0].reset();
              $("#btn_save_feedback").removeAttr("disabled");
              $('#note_review').summernote('reset');
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(jqXHR.responseText);
              jconfirm.instances[0].close();
            }
          });
        }
      });
    }
  }
</script>