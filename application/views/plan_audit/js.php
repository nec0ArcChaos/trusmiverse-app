<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
<!-- Datepicker -->
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;
        // Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="startdate"]').val(start.format('YYYY-MM-DD'));
            $('input[name="enddate"]').val(end.format('YYYY-MM-DD'));
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
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                    .endOf('month')
                ]
            }
        }, cb);

        cb(start, end);
        get_dt_plan_audit('<?= date('Y-m-01') ?>', '<?= date('Y-m-t') ?>');
        $('#btn_filter').on('click', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            get_dt_plan_audit(start, end);
        });
        $('.range').on('change', function() {
            start = $('input[name="startdate"]').val();
            end = $('input[name="enddate"]').val();
            get_dt_plan_audit(start, end);
        })
        // Text_Area
        $('textarea.input_permintaan').each(function() {
            $(this).summernote({
                tabsize: 2,
                height: 70,
                toolbar: [
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                ]
            });
        })
        $("#periode").datepicker({
            format: "yyyy-mm",
            startView: "months",
            minViewMode: "months",
            autoclose: true,
        });
    });

    function get_dt_plan_audit(start, end) {
        // status = $('#status_permintaan').val();
        // console.log(status);
        $('#dt_pa').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [1, 'desc']
            ],
            buttons: [{
                title: 'List Plan Audit',
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "method": "POST",
                "url": "<?= base_url(); ?>plan_audit/get_plan_audit",
                "data": {
                    start: start,
                    end: end
                }
            },
            "columns": [{
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                    "data": "id_plan",
                    'render': function(data, type, row, meta) {
                        return `<span class="badge bg-primary">${data}</span>`
                    }
                },
                {
                    'data': 'auditor'
                },
                {
                    'data': 'no_dok'
                },
                {
                    'data': 'subject'
                },
                {
                    'data': 'object',
                },
                {
                    'data': 'pics',
                    'render': function(data, type, row, meta) {
                        avatar_pic = ``;
                        avatar_pic_plus = ``;
                        if (row['pp_pic'].indexOf(',') > -1) {
                            array_pic = row['pp_pic'].split(',');
                            for (let index = 0; index < array_pic.length; index++) {
                                if (index < 2) {
                                    avatar_pic += `<div class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${array_pic[index]}&quot;);">
                            <img src="http://trusmiverse.com/hr/uploads/profile/${array_pic[index]}" alt="" style="display: none;">
                            </div>`;
                                }
                            }
                            if (array_pic.length > 2) {
                                avatar_pic_plus = `<div class="avatar avatar-30 bg-light-theme rounded-circle me-1">
                                <p class="small">${parseInt(array_pic.length)-2}+</p>
                            </div>`;
                            } else {
                                avatar_pic_plus = '';
                            }
                            return `<div class="d-flex justify-content-center" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${row['pics']}">
                                ${avatar_pic}${avatar_pic_plus}  
                            </div>`;
                        } else {
                            return `
                            <div class="d-flex justify-content-center" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" title="${row['pics']}">
                                <div class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${row['pp_pic']}&quot;);">
                            <img src="http://trusmiverse.com/hr/uploads/profile/${row['pp_pic']}" alt="" style="display: none;">
                            </div>  
                            </div>
                        `;
                        }
                    },
                    "className": "d-none d-md-table-cell text-left",
                    exportOptions: {
                        format: {
                            body: function(value, row, cell, settings) {
                                let picString = '';
                                if (row['pp_pic'].indexOf(',') > -1) {
                                    let array_pic = row['pp_pic'].split(',');
                                    picString = array_pic.slice(0, 2).join(', ');
                                    if (array_pic.length > 2) {
                                        picString += ` and ${array_pic.length - 2} more`;
                                    }
                                } else {
                                    picString = row['pp_pic'];
                                }
                                return picString;
                            }
                        }
                    }
                },
                {
                    'data': 'company',
                },
                {
                    'data': 'department',
                },
                {
                    'data': 'designation',
                },
                {
                    'data': 'target',
                },
                {
                    'data': 'plan_start',
                },
                {
                    'data': 'plan_end',
                },
                {
                    'data': 'bobot',
                    'render': function(data, type, row) {
                        return `${data}%`;
                    }
                },
                {
                    'data': 'tool',
                    'className': 'd-none'
                },
                {
                    'data': 'pemeriksaan',
                    'className': 'd-none'
                },
                {
                    'data': 'pics',
                    'className': 'd-none'
                }
            ],
        });
    }
    // Add event listener
    // for opening and closing details
    $('#dt_pa tbody').on('click', 'td.dt-control', function() {
        // console.log('test')
        var tr = $(this).closest('tr');
        var row = $('#dt_pa').DataTable().row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });

    function format(d) {
        // `d` is the original data object for the row
        return (
            `<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">
                <tr><td><b>Tools</b></td><td>${d.tool}</td></tr>
                <tr><td><b>Pemeriksaan</b></td><td>${d.pemeriksaan}</td></tr>
        </table>`
        );
    }
    $('#btn_add_audit').on('click', function() {
        $('#dokumen_hidden').val('');
        $("#form_add_audit")[0].reset();
        $('#department').val('').trigger('change');
        department_select.update();
        $('#posisi').val('').trigger('change');
        posisi_select.update();
        $('#dokumen').val('').trigger('change');
        dokumen_select.update();
        $('#pic').val('').trigger('change');
        pic_select.update();
        $('#target').val('').trigger('change');
        target_select.update();
        $('#posisi_hidden').val('');
        $('#department_hidden').val('');
        $('#dokumen_hidden').val('');
        $('#pic_hidden').val('');
        $('#subject').summernote('code', '');
        $('#object').summernote('code', '');
        $('#tools').summernote('code', '');
        $('#pemeriksaan').summernote('code', '');
        $('#modal_add_audit').modal('show');
        get_audit_employees();
        get_company();
    })
    $("#pic").change(function() {
        pic = $("#pic").val().toString().split(",");
        $('#pic_hidden').val(pic);
        console.log(pic);
    });
    $("#dokumen").change(function() {
        dokumen = $("#dokumen").val().toString().split(",");
        $('#dokumen_hidden').val(dokumen + ','+$('#nama_dokumen').val());
        console.log(dokumen);
    });
    $("#posisi").change(function() {
        posisi = $("#posisi").val().toString().split(",");
        $('#posisi_hidden').val(posisi);
        console.log(posisi);
        get_pic();
        get_dokumen_audit();
    });
    $("#department").change(function() {
        department = $("#department").val().toString().split(",");
        $('#department_hidden').val(department);
        console.log(department);
        get_posisi();
    });

    function get_audit_employees() {
        $.ajax({
            url: "<?= base_url('plan_audit/get_audit_employees') ?>",
            method: "POST",
            dataType: "JSON",
            success: function(res) {
                let employees = '<option value = "" selected disabled>--Pilih Auditor--</option>';
                res.employees.forEach((value, index) => {
                    employees += `<option value = "${value.user_id}">${value.first_name}` + ` ${value.last_name}</option>`
                })
                $('#auditor').html(employees);
                auditor_select.update();
            }
        })
    }

    function get_pic() {
        posisi = $('#posisi_hidden').val();
        if (posisi != '') {
            $.ajax({
                url: "<?= base_url('plan_audit/get_pic') ?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    posisi: posisi
                },
                success: function(res) {
                    let employees = '';
                    res.employees.forEach((value, index) => {
                        employees += `<option value = "${value.user_id}">${value.first_name}` + ` ${value.last_name}</option>`
                    })
                    $('#pic').html(employees);
                    pic_select.update();
                }
            })
        }
    }

    function get_dokumen_audit() {
        id = $('#posisi_hidden').val();
        $.ajax({
            url: "<?= base_url('plan_audit/get_dokumen_audit') ?>",
            method: "POST",
            dataType: "JSON",
            data: {
                id: id
            },
            success: function(res) {
                let dokumen = '';
                res.dokumen.forEach((value, index) => {
                    dokumen += `<option value = "${value.no_dok} | ${value.jabatan} | ${value.tipe}">${value.no_dok } - ${value.nama}</option>`
                })
                $('#dokumen').html(dokumen);
                dokumen_select.update();
            }
        })
    }

    function get_company() {
        $.ajax({
            url: "<?= base_url('plan_audit/get_company') ?>",
            method: "POST",
            dataType: "JSON",
            success: function(res) {
                let company = '<option value = "" selected disabled>--Pilih Perusahaan--</option>';
                res.company.forEach((value, index) => {
                    company += `<option value = "${value.company_id}">${value.name}</option>`
                })
                $('#company').html(company);
                company_select.update();
            }
        })
    }

    function get_department() {
        company = $('#company').val();
        if (company != '') {
            $.ajax({
                url: "<?= base_url('plan_audit/get_department') ?>",
                method: "POST",
                data: {
                    company: company
                },
                dataType: "JSON",
                success: function(res) {
                    let department = ' '
                    res.department.forEach((value, index) => {
                        department += `<option value = "${value.department_id}">${value.department_name}</option>`
                    })
                    $('#department').html(department);
                    department_select.update();
                }
            })
        }
    }

    function get_posisi() {
        company = $('#company').val();
        department = $('#department_hidden').val();
        if (company != '' && department != '') {
            $.ajax({
                url: "<?= base_url('plan_audit/get_designations') ?>",
                method: "POST",
                data: {
                    company: company,
                    department: department
                },
                dataType: "JSON",
                success: function(res) {
                    let designation = ' '
                    res.designation.forEach((value, index) => {
                        designation += `<option value = "${value.designation_id}">${value.designation_name}</option>`
                    })
                    $('#posisi').html(designation);
                    posisi_select.update();
                }
            })
        }
    }

    function save_audit() {
        form = $('#form_add_audit');
        if (is_valid_audit()) {
            return;
        } else {
            // success_alert('Form is valid');
            $.confirm({
                title: 'Save Form',
                content: 'Plan Audit form will be saved',
                icon: 'fa fa-question',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm': {
                        text: 'Yes',
                        btnClass: 'btn-blue',
                        action: function() {
                            $.confirm({
                                icon: 'fa fa-spinner fa-spin',
                                title: 'Please Wait!',
                                theme: 'material',
                                type: 'blue',
                                content: 'Loading...',
                                buttons: {
                                    close: {
                                        isHidden: true,
                                        actions: function() {}
                                    },
                                },
                                onOpen: function() {
                                    $.ajax({
                                        url: "<?= base_url('plan_audit/save_audit') ?>",
                                        method: "POST",
                                        data: form.serialize(),
                                        dataType: "JSON",
                                        beforeSend: function() {},
                                        success: function(response) {},
                                        error: function(xhr) {},
                                        complete: function() {},
                                    }).done(function(response) {
                                        if (response.insert == true) {
                                            setTimeout(() => {
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Success!',
                                                    buttons: {
                                                        close: function() {},
                                                    },
                                                });
                                                $('#modal_add_audit').modal('hide');
                                                $('#dt_pa').DataTable().ajax.reload();
                                                // success_alert("Berhasil menambah Plan Audit!");
                                            }, 250);
                                        } else {
                                            setTimeout(() => {
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Oops!',
                                                    theme: 'material',
                                                    type: 'red',
                                                    content: response.message,
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                        }
                                    }).fail(function(jqXHR, textStatus) {
                                        setTimeout(() => {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-close',
                                                title: 'Oops!',
                                                theme: 'material',
                                                type: 'red',
                                                content: 'Failed!' + textStatus,
                                                buttons: {
                                                    close: {
                                                        actions: function() {}
                                                    },
                                                },
                                            });
                                        }, 250);
                                    });
                                },

                            });
                        }
                    },
                    cancel: function() {}
                }
            });
        }
    }

    function is_valid_audit() {
        let isEmptyField = false;
        if ($('#periode').val() == null || $('#periode').val() == '') {
            error_alert("Periode is required!");
            return true;
        }
        if ($('#auditor').val() == '' || $('#auditor').val() == null || $('#auditor').val() == '--Pilih Auditor--') {
            error_alert("Auditor is required!");
            return true;
        }
        if ($('#company').val() == '' || $('#company').val() == null || $('#company').val() == '--Pilih Perusahaan--') {
            error_alert("Perusahaan is required!");
            return true;
        }
        if ($('#department').val() == '' || $('#department').val() == null || $('#department').val() == '--Pilih Departemen--') {
            error_alert("Departemen is required!");
            return true;
        }
        if ($('#target').val() == '' || $('#target').val() == null || $('#target').val() == '--Pilih Target--') {
            error_alert("Target is required!");
            return true;
        }
        if ($('#posisi').val() == '' || $('#posisi').val() == null || $('#posisi').val() == '--Pilih Posisi--') {
            error_alert("Posisi is required!");
            return true;
        }
        if ($('#pic').val() == '' || $('#pic').val() == null || $('#pic').val() == '--Pilih PIC--') {
            error_alert("Pic is required!");
            return true;
        }
        // if ($('#dokumen').val() == null || $('#dokumen').val() == '') {
        //     error_alert("Dokumen is required!");
        //     return true;
        // }
        if ($('#bobot').val() == '' || $('#bobot').val() == null) {
            error_alert("Bobot is required!");
            return true;
        } else {
            if ($('#bobot').val() > 100 || $('#bobot').val() < 0) {
                error_alert("Bobot tidak boleh lebih dari 100 atau kurang dari 0!");
                return true;
            }
        }
        if ($('#subject').val() == '' || $('#subject').val() == null) {
            error_alert("Subject is required!");
            return true;
        }
        if ($('#object').val() == '' || $('#object').val() == null) {
            error_alert("Object is required!");
            return true;
        }
        if ($('#tools').val() == '' || $('#tools').val() == null) {
            error_alert("Tools is required!");
            return true;
        }
        if ($('#pemeriksaan').val() == '' || $('#pemeriksaan').val() == null) {
            error_alert("Pemeriksaan is required!");
            return true;
        }
        return false;
    }

    // Fungsi untuk mendekodekan entitas HTML
    function decodeHtmlEntities(str) {
        let textarea = document.createElement("textarea");
        textarea.innerHTML = str;
        return textarea.value;
    }
    // NiceSelect
    let company_select = NiceSelect.bind(document.getElementById('company'), {
        searchable: true,
        isAjax: false,
    });
    let department_select = NiceSelect.bind(document.getElementById('department'), {
        searchable: true,
        isAjax: false,
        placeholder: '--Pilih Departemen--'
    });
    let posisi_select = NiceSelect.bind(document.getElementById('posisi'), {
        searchable: true,
        isAjax: false,
        placeholder: '--Pilih Posisi--'
    });
    let dokumen_select = NiceSelect.bind(document.getElementById('dokumen'), {
        searchable: true,
        isAjax: false,
        placeholder: '--Pilih Dokumen--'
    });
    let auditor_select = NiceSelect.bind(document.getElementById('auditor'), {
        searchable: true,
        isAjax: false,
        placeholder: '--Pilih Auditor--'
    });
    let pic_select = NiceSelect.bind(document.getElementById('pic'), {
        searchable: true,
        isAjax: false,
        placeholder: '--Pilih PIC--'
    });
    let target_select = NiceSelect.bind(document.getElementById('target'), {
        searchable: true,
        isAjax: false
    });
    //End Nice Select 
    function error_alert(text) {
        new PNotify({
            title: `Oopss`,
            text: `${text}`,
            icon: 'icofont icofont-info-circle',
            type: 'error',
            delay: 1500,
        });
    }

    function success_alert(text) {
        textMsg = text == null ? '' : text;
        new PNotify({
            title: `Success`,
            text: `${textMsg}`,
            icon: 'icofont icofont-checked',
            type: 'success',
            delay: 2000,
        });
    }
    $('#btn_send_wa').on('click', function() {
        $.ajax({
            url: "<?= base_url('plan_audit/send_wa') ?>",
            dataType: "JSON",
            method: "POST",
            success: function(res) {
                console.log(res);
            }
        })
    })
</script>