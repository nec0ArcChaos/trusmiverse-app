<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>
<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>


<script>
    $(document).ready(function() {

        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
            dt_promotion($('#company').val(), $('#department').val(), start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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

    slc_company = new SlimSelect({
        select: '#company',
    });

    slc_department = new SlimSelect({
        select: '#department',
    });



    $('#company').change(function() {
        company_id = $(this).val();

        $.ajax({
            url: '<?php echo base_url(); ?>hr/rekap_absen/get_department',
            type: 'POST',
            dataType: 'json',
            data: {
                company_id: company_id
            },
            success: function(response) {
                slc_department.setData(response);
                slc_employee.setData([{
                    text: 'All Employees',
                    value: '0'
                }])
            }
        });
    });


    $('#btn_filter').click(function() {
        dt_promotion($('#company').val(), $('#department').val(), $('#start').val(), $('#end').val());
    });

    slc_from_company = new SlimSelect({
        select: '#from_company',
    });

    slc_employee = new SlimSelect({
        select: '#employee',
    });

    slc_type = new SlimSelect({
        select: '#type',
    });

    slc_to_company = new SlimSelect({
        select: '#to_company',
    });

    slc_designation = new SlimSelect({
        select: '#designation',
    });

    $('#from_company').change(function() {
        company_id = $(this).val();

        if (company_id > 0) {
            $.ajax({
                url: '<?php echo base_url(); ?>hr/promotion/get_employees',
                type: 'POST',
                dataType: 'json',
                data: {
                    company_id: company_id,
                },
                success: function(response) {
                    slc_employee.setData(response);
                }
            });
        }
    });

    $('#to_company').change(function() {
        company_id = $(this).val();

        if (company_id > 0) {
            $.ajax({
                url: '<?php echo base_url(); ?>hr/promotion/get_designation',
                type: 'POST',
                dataType: 'json',
                data: {
                    company_id: company_id,
                },
                success: function(response) {
                    slc_designation.setData(response);
                }
            });
        }
    });
    $('#com_id').change(function() {
        company_id = $(this).val();

        if (company_id > 0) {
            $.ajax({
                url: '<?php echo base_url(); ?>hr/promotion/get_department',
                type: 'POST',
                dataType: 'json',
                data: {
                    company_id: company_id,
                },
                success: function(response) {
                    var option = '';
                    option = '<option selected disabled>Choose..</option>';
                    $.each(response, function(index, value) {

                        option += `<option value="${value.value}">${value.text}</option>`;
                    });
                    $('#dep_id').empty().html(option);
                    $('#des_id').empty();
                    $('#loc_id option').each(function() {
                        if ($(this).data('company') != company_id && $(this).val() != '0') {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });
                }
            });
        }
    });
    $('#dep_id').change(function() {
        dep_id = $(this).val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>hr/promotion/get_designation_by_dep",
            data: {
                dep_id: dep_id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                var option = '';
                option = '<option selected disabled>Choose..</option>';
                $.each(response, function(index, value) {

                    option += `<option value="${value.id}">${value.text}</option>`;

                });
                $('#des_id').empty().html(option);
            }
        });

    });

    $('#promotion_date').daterangepicker({
        autoUpdateInput: false,
        locale: {
            format: 'YYYY-MM-DD',
        },
        singleDatePicker: true,
        autoApply: true,
    });

    $('#promotion_date').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD'));
        $('.promotion_date').removeClass('is-invalid');
        $('.promotion_date').addClass('is-valid');
    });

    $('#promotion_date').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    $('#edit_date').daterangepicker({
        autoUpdateInput: true,
        locale: {
            format: 'YYYY-MM-DD',
        },
        singleDatePicker: true,
        autoApply: true,
    });

    $('#val_tanggal').daterangepicker({
        autoUpdateInput: false,
        locale: {
            format: 'D MMMM YYYY',
        },
        singleDatePicker: true,
        autoApply: true,
    });

    $('#val_tanggal').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('D MMMM YYYY'));
    });

    $('#approval_tanggal').daterangepicker({
        autoUpdateInput: false,
        locale: {
            format: 'D MMMM YYYY',
        },
        singleDatePicker: true,
        autoApply: true,
    });

    $('#approval_tanggal').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('D MMMM YYYY'));
        $('.approval_tanggal').removeClass('is-invalid');
        $('.approval_tanggal').addClass('is-valid');
    });

    $('#add_promotion').click(function() {
        $('#modal_add_promotion').modal('show');

        $('.from_company').removeClass('is-valid');
        $('.from_company').removeClass('is-invalid');
        $('.promotion_title').removeClass('is-valid');
        $('.promotion_title').removeClass('is-invalid');
        $('.promotion_date').removeClass('is-valid');
        $('.promotion_date').removeClass('is-invalid');
        $('.employee').removeClass('is-valid')
        $('.employee').removeClass('is-invalid')
        $('.type').removeClass('is-valid')
        $('.type').removeClass('is-invalid')
        $('.to_company').removeClass('is-valid')
        $('.to_company').removeClass('is-invalid')
        $('.designation').removeClass('is-valid')
        $('.designation').removeClass('is-invalid')
        $('.description').removeClass('is-valid');
        $('.description').removeClass('is-invalid');

        $('#from_company').change(function() {
            if ($(this).val() != "") {
                $('.from_company').removeClass('is-invalid')
                $('.from_company').addClass('is-valid')
            } else {
                $('.from_company').removeClass('is-valid')
                $('.from_company').addClass('is-invalid')
            }
        });

        $('#promotion_title').keyup(function() {
            if ($(this).val() != "") {
                $('.promotion_title').removeClass('is-invalid');
                $('.promotion_title').addClass('is-valid');
            } else {
                $('.promotion_title').removeClass('is-valid');
                $('.promotion_title').addClass('is-invalid');

            }
        });

        $('#employee').change(function() {
            if ($(this).val() != "") {
                $('.employee').removeClass('is-invalid')
                $('.employee').addClass('is-valid')
            } else {
                $('.employee').removeClass('is-valid')
                $('.employee').addClass('is-invalid')
            }
        });

        $('#type').change(function() {
            if ($(this).val() != "") {
                $('.type').removeClass('is-invalid')
                $('.type').addClass('is-valid')
            } else {
                $('.type').removeClass('is-valid')
                $('.type').addClass('is-invalid')
            }
        });

        $('#to_company').change(function() {
            if ($(this).val() != "") {
                $('.to_company').removeClass('is-invalid')
                $('.to_company').addClass('is-valid')
            } else {
                $('.to_company').removeClass('is-valid')
                $('.to_company').addClass('is-invalid')
            }
        });

        $('#designation').change(function() {
            if ($(this).val() != "") {
                $('.designation').removeClass('is-invalid')
                $('.designation').addClass('is-valid')
            } else {
                $('.designation').removeClass('is-valid')
                $('.designation').addClass('is-invalid')
            }
        });

        $('#description').keyup(function() {
            if ($(this).val() != "") {
                $('.description').removeClass('is-invalid');
                $('.description').addClass('is-valid');
            } else {
                $('.description').removeClass('is-valid');
                $('.description').addClass('is-invalid');

            }
        });
    });

    $('#btn_save_promotion').click(function() {
        if ($('#from_company').val() == 0) {
            error_alert("From Company belum dipilih");
            $('.from_company').addClass('is-invalid');
            $('#from_company').focus();
        } else if ($('#promotion_title').val() == "") {
            error_alert("Promotion Title belum diisi");
            $('.promotion_title').addClass('is-invalid');
            $('#promotion_title').focus();
        } else if ($('#promotion_date').val() == "") {
            error_alert("Promotion Date belum diisi");
            $('.promotion_date').addClass('is-invalid');
            $('#promotion_date').focus();
        } else if ($('#employee').val() == 0) {
            error_alert("Promotion For belum dipilih");
            $('.employee').addClass('is-invalid');
            $('#employee').focus();
        } else if ($('#type').val() == 0) {
            error_alert("Type belum dipilih");
            $('.type').addClass('is-invalid');
            $('#type').focus();
        } else if ($('#to_company').val() == 0) {
            error_alert("To Company belum dipilih");
            $('.to_company').addClass('is-invalid');
            $('#to_company').focus();
        } else if ($('#designation').val() == 0) {
            error_alert("Designation belum dipilih");
            $('.designation').addClass('is-invalid');
            $('#designation').focus();
        } else if ($('#description').val() == "") {
            error_alert("Description belum diisi");
            $('.description').addClass('is-invalid');
            $('#description').focus();
        } else {
            $('#btn_save_promotion').prop('disabled', true);
            $.ajax({
                    url: '<?php echo base_url() ?>hr/promotion/add_promotion',
                    type: 'POST',
                    dataType: 'json',
                    data: $('#form_add_promotion').serialize(),
                })
                .done(function() {
                    console.log("success");
                    $('#form_add_promotion')[0].reset();

                    slc_from_company.setSelected(0);
                    slc_employee.setSelected(0);
                    slc_type.setSelected(0);
                    slc_to_company.setSelected(0);
                    slc_designation.setSelected(0);

                    $('#dt_promotion').DataTable().ajax.reload();
                    $('#modal_add_promotion').modal('hide');

                    success_alert("Promotion telah berhasil disimpan.")
                })
                .fail(function() {
                    $('#btn_save_promotion').prop('disabled', false);
                    console.log("error");
                })
                .always(function() {
                    $('#btn_save_promotion').prop('disabled', false);
                    console.log("complete");
                });

        }
    });

    $('#dt_promotion').on('click', '.view', function() {
        $('#modal_view_promotion').modal('show');

        $('#view_company').val($(this).data('company'));
        $('#view_employee').val($(this).data('employee'));
        $('#view_title').val($(this).data('title'));
        $('#view_designation').val($(this).data('designation'));
        $('#view_date').val($(this).data('date'));
        $('#view_description').val($(this).data('description'));
    });

    $('#dt_promotion').on('click', '.delete', function() {
        $('#modal_delete_promotion').modal('show');

        $('#promotion_id').val($(this).data('promotion_id'));

        text = "Anda yakin ingin hapus <strong>" + $(this).data('employee') + ' <i><small>' + $(this).data('to') + '</small></i><strong> ?';
        $('#text_delete_promotion').empty().append(text)
    });

    $('#btn_delete_promotion').click(function() {
        $.ajax({
                url: '<?php echo base_url() ?>hr/promotion/delete_promotion',
                type: 'POST',
                dataType: 'json',
                data: {
                    promotion_id: $('#promotion_id').val()
                },
            })
            .done(function() {
                $('#dt_promotion').DataTable().ajax.reload();
                $('#modal_delete_promotion').modal('hide');
                success_alert("Data telah berhasil dihapus.");
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });

    });

    $('#dt_promotion').on('click', '.edit', function() {
        $('#modal_edit_promotion').modal('show');

        $('#edit_promotion_id').val($(this).data('promotion_id'));
        $('#edit_employee').val($(this).data('employee'));
        $('#edit_title').val($(this).data('title'));
        $('#edit_date').val($(this).data('date'));
        $('#edit_description').val($(this).data('description'));
    });

    $('#btn_edit_promotion').click(function() {
        $.ajax({
                url: '<?php echo base_url() ?>hr/promotion/edit_promotion',
                type: 'POST',
                dataType: 'json',
                data: $('#form_edit_promotion').serialize(),
            })
            .done(function() {
                $('#dt_promotion').DataTable().ajax.reload();
                $('#modal_edit_promotion').modal('hide');
                success_alert("Data telah berhasil diubah");
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });

    });

    $('#dt_promotion').on('click', '.print', function() {
        $('#modal_print_promotion').modal('show');

        $('#val_nama').val($(this).data('val_nama'));
        $('#val_nik').val($(this).data('val_nik'));
        $('#val_jabatan').val($(this).data('val_jabatan'));
        $('#val_divisi').val($(this).data('val_divisi'));
        $('#val_jabatan_lalu').val($(this).data('val_jabatan_lalu'));
        $('#val_divisi_lalu').val($(this).data('val_divisi_lalu'));
        $('#val_tanggal_promosi').val($(this).data('val_tanggal_promosi'));
    });

    $('#dt_promotion').on('click', '.approval', function() {
        $('#modal_approval_promotion').modal('show');

        $('#approval_promotion_id').val($(this).data('promotion_id'));
        $('#approval_no_kontak').val($(this).data('no_kontak'));
        $('#approval_nama').val($(this).data('nama'));
        $('#approval_nik').val($(this).data('nik'));
        $('#approval_jabatan').val($(this).data('jabatan'));
        $('#approval_divisi').val($(this).data('divisi'));
        $('#approval_jabatan_lalu').val($(this).data('jabatan_lalu'));
        $('#approval_divisi_lalu').val($(this).data('divisi_lalu'));
        $('#approval_tanggal_promosi').val($(this).data('tanggal_promosi'));
        $('#approval_user_id').val($(this).data('user_id'));
        $('#approval_company_id').val($(this).data('company_id'));
        $('#approval_department_id').val($(this).data('department_id'));
        $('#approval_designation_id').val($(this).data('designation_id'));
        $('#approval_location_id').val($(this).data('location_id'));
        $('#approval_id_type').val($(this).data('id_type'));
        $('[name="target_before"]').val($(this).data('last_target'));
        // $('#actual_target_ap').val($(this).data('last_target'));

        text = "Apakah sudah sesuai <strong>" + $(this).data('nama') + ' <i><small>' + $(this).data('to') + '</small></i><strong> ?';
        $('#text_approval_promotion').empty().append(text);

        $('#com_id').val($(this).data('company_id'));
        var com_id = $(this).data('company_id');
        var dep_id = $(this).data('department_id');
        var des_id = $(this).data('designation_id');
        $('#loc_id').val($(this).data('location_id'));
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>hr/promotion/get_department",
            data: {
                company_id: com_id
            },
            dataType: "json",
            success: function(response) {
                var option = '';
                option = '<option selected disabled>Choose..</option>';
                $.each(response, function(index, value) {
                    if (value.value == dep_id) {
                        option += `<option value="${value.value}" selected>${value.text}</option>`;
                    } else {
                        option += `<option value="${value.value}">${value.text}</option>`;
                    }
                });
                $('#dep_id').empty().html(option);
            }
        });
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>hr/promotion/get_designation",
            data: {
                company_id: com_id
            },
            dataType: "json",
            success: function(response) {
                var option = '';
                option = '<option selected disabled>Choose..</option>';
                $.each(response, function(index, value) {
                    if (value.id == des_id) {
                        option += `<option value="${value.id}" selected>${value.text}</option>`;
                    } else {
                        option += `<option value="${value.id}">${value.text}</option>`;
                    }
                });
                $('#des_id').empty().html(option);
            }
        });
    });

    $('#approval_status').change(function() {
        if ($(this).val() != "") {
            $('.approval_status').removeClass('is-invalid')
            $('.approval_status').addClass('is-valid')
        } else {
            $('.approval_status').removeClass('is-valid')
            $('.approval_status').addClass('is-invalid')
        }

        if ($(this).val() == 1) {
            $('.div_tgl_loc').show();
            $('.div_com').show();
            $('.div_target').show();
        } else {
            $('.div_target').hide();
            $('.div_com').hide();
            $('.div_tgl_loc').hide();
        }
    });

    $('#user_role_id').change(function() {
        role = $("#user_role_id option:selected").text();
        $('#ctm_posisi').val(role);

        if ($(this).val() != "0") {
            $('.user_role_id').removeClass('is-invalid')
            $('.user_role_id').addClass('is-valid')
        } else {
            $('.user_role_id').removeClass('is-valid')
            $('.user_role_id').addClass('is-invalid')
        }
    });

    $('#btn_approval_promotion').click(function() {
        if ($('#approval_status').val() == 0) {
            $('.approval_status').addClass('is-invalid');
        } else if ($('#user_role_id').val() == 0) {
            $('.user_role_id').addClass('is-invalid');
        } else if ($('#approval_status').val() == 1 && $('#approval_tanggal').val() == "") {
            $('.approval_tanggal').addClass('is-invalid');
        } else {
            $.ajax({
                    url: '<?php echo base_url() ?>hr/promotion/approval_promotion',
                    type: 'POST',
                    dataType: 'json',
                    data: $('#form_approval_promotion').serialize(),
                })
                .done(function(response) {
                    console.log(response);
                    $('#dt_promotion').DataTable().ajax.reload();
                    $('#modal_approval_promotion').modal('hide');
                    $('.approval_status').removeClass('is-invalid');
                    $('.approval_tanggal').removeClass('is-invalid');

                    if ($('#approval_status').val() == 1) {
                        success_alert("Promotion telah berhasil diapprove");
                        $('.approval_status').removeClass('is-valid');
                        $('.approval_status').removeClass('is-invalid');
                        $('.approval_tanggal').removeClass('is-valid');
                        $('.approval_tanggal').removeClass('is-invalid');

                        if (response.no_kontak === null || response.no_kontak == "") {
                            error_alert("Notif tidak terkirim karena nomor kontak tidak valid.")
                        } else {

                            nama = $('#approval_nama').val();
                            nik = $('#approval_nik').val();
                            // jabatan = $('#approval_jabatan').val();
                            jabatan = $('#des_id option:selected').text();
                            // divisi = $('#approval_divisi').val();
                            divisi = $('#dep_id option:selected').text();
                            jabatan_lalu = $('#approval_jabatan_lalu').val();
                            divisi_lalu = $('#approval_divisi_lalu').val();
                            tanggal_promosi = $('#approval_tanggal_promosi').val();
                            tanggal = $('#approval_tanggal').val();

                            array_contact = [];
                            array_contact.push(response.no_kontak);
                            // array_contact.push('085860428016');
                            msg = `SURAT KEPUTUSAN
No. : TRS/0001/09-32/PRM

Tentang : PROMOSI

Dalam rangka efektifitas, efesiensi dan mengoptimalkan potensi tenaga kerja yang ada. Sesuai dengan kebutuhan dan perkembangan perusahaan, maka dengan ini kami selaku:

*MANAGEMENT RAJA TRUSMI GROUP MEMUTUSKAN*

Nama    :   ${nama}
NIK     :   ${nik}
Jabatan :   ${jabatan_lalu}
Divisi  :   ${divisi_lalu}

Untuk selanjutnya Saudara terhitung ${tanggal_promosi} ditugaskan di :

Jabatan :   ${jabatan}
Divisi  :   ${divisi}

Dengan ketentuan apabila dikemudian hari terjadi perubahan atau kekeliruan akan diperbaharui dan ditinjau kembali.

Cirebon, ${tanggal}`;

                            send_wa_trusmi(array_contact, msg, '2507194023');

                        }
                    } else {
                        success_alert("Promotion telah berhasil direject");
                    }

                    $('#form_approval_promotion')[0].reset();


                    console.log("success");
                })
                .fail(function(response) {
                    console.log(response);
                    console.log("error");
                })
                .always(function(response) {
                    console.log(response);
                    console.log("complete");
                });

        }

        $('#approval_tanggal').keyup(function() {
            if ($(this).val() != "") {
                $('.approval_tanggal').removeClass('is-invalid');
                $('.approval_tanggal').addClass('is-valid');
            } else {
                $('.approval_tanggal').removeClass('is-valid');
                $('.approval_tanggal').addClass('is-invalid');
            }
        });


    });

    function dt_promotion(company_id, department_id, start, end) {
        $('#dt_promotion').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "dom": 'Bfrtip',
            "order": [
                [1, 'desc']
            ],
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": "<?= base_url(); ?>hr/promotion/get_promotion_list",
                "data": {
                    company_id: company_id,
                    department_id: department_id,
                    start: start,
                    end: end,
                }
            },
            "columns": [{
                    "data": "promotion_id",
                    "render": function(data, type, row) {
                        edit = '<button class="btn btn-sm btn-outline-info edit" data-promotion_id="' + data + '" data-employee="' + row['employee'] + '" data-title="' + row['title'] + '" data-date="' + row['date'] + '" data-description="' + row['description'] + '"><i class="bi bi-pencil" style="font-size: 12px"></i></button>';
                        view = '<button class="btn btn-sm btn-outline-success view" data-company="' + row['company'] + '" data-employee="' + row['employee'] + '" data-title="' + row['title'] + '" data-designation="' + row['designation'] + '" data-date="' + row['date'] + '" data-description="' + row['description'] + '"><i class="bi bi-eye" style="font-size: 12px"></i></button>';
                        print = '<button class="btn btn-sm btn-outline-primary print" data-val_nama="' + row['employee'] + '" data-val_nik="' + row['employee_id'] + '" data-val_jabatan="' + row['designation'] + '" data-val_divisi="' + row['department'] + '" data-val_jabatan_lalu="' + row['last_designation'] + '" data-val_divisi_lalu="' + row['last_department'] + '" data-val_tanggal_promosi="' + row['date'] + '"><i class="bi bi-printer-fill" style="font-size: 12px"></i></button>';
                        hapus = '<button class="btn btn-sm btn-outline-danger delete" data-promotion_id="' + data + '" data-employee="' + row['employee'] + '" data-to="' + row['to'] + '"><i class="bi bi-trash" style="font-size: 12px"></i></button>';

                        role_id = <?php echo $this->session->userdata('user_role_id'); ?>;
                        if (row['status'] == "Approve") {
                            if (role_id == 1) {
                                return edit + view + print + hapus;
                            } else {
                                return edit + view + print;
                            }
                        } else {
                            if (role_id == 1) {
                                return edit + view + hapus;
                            } else {
                                return edit + view;
                            }
                        }
                    }
                },
                {
                    "data": "employee",
                },
                {
                    "data": "description",
                },
                {
                    "data": "company",
                },
                {
                    "data": "status",
                    "render": function(data, type, row) {
                        if (data == "Approve") {
                            return '<button class="btn btn-primary btn-sm">' + data + '</button>';
                        } else if (data == "Reject") {
                            return '<button class="btn btn-danger btn-sm">' + data + '</button>';
                        } else {
                            user_id = "<?php echo $this->session->userdata('user_id'); ?>";
                            user_approve = ["1", "61", "62", "323", "979", "63", "64", "1161", "2041", "2063", "2969", "2969", "2070", "2903"];
                            // alert($.inArray(user_id, user_approve));
                            if ($.inArray(user_id, user_approve) < 0) {
                                cls = "";
                            } else {
                                cls = "approval";
                            }
                            return '<button class="btn btn-warning btn-sm ' + cls + '" ' +
                                'data-promotion_id="' + row['promotion_id'] + '" ' +
                                'data-no_kontak="' + row['no_kontak'] + '" ' +
                                'data-nama="' + row['employee'] + '" ' +
                                'data-nik="' + row['employee_id'] + '" ' +
                                'data-jabatan="' + row['designation'] + '" ' +
                                'data-divisi="' + row['department'] + '" ' +
                                'data-jabatan_lalu="' + row['last_designation'] + '" ' +
                                'data-divisi_lalu="' + row['last_department'] + '" ' +
                                'data-tanggal_promosi="' + row['date'] + '" ' +
                                'data-to="' + row['to'] + '" ' +
                                'data-user_id="' + row['user_id'] + '" ' +
                                'data-company_id="' + row['company_id'] + '" ' +
                                'data-department_id="' + row['department_id'] + '" ' +
                                'data-designation_id="' + row['designation_id'] + '" ' +
                                'data-location_id="' + row['location_id'] + '" ' +
                                'data-id_type="' + row['id_type'] + '" ' +
                                'data-last_target="' + row['last_target'] + '">' + data + '</button>';

                        }
                    }
                },
                {
                    "data": "type",
                },
                {
                    "data": "title",
                },
                {
                    "data": "last_designation",
                },
                {
                    "data": "to",
                },
                {
                    "data": "last_target",
                },
                {
                    "data": "target",
                },
                {
                    "data": "date",
                },
                {
                    "data": "added_by",
                },
                {
                    "data": "created_at",
                },
                {
                    "data": "approved_by",
                },
                {
                    "data": "approve_at",
                },
            ],
        });
    }

    function success_alert(text) {
        textMsg = text == null ? '' : text;
        new PNotify({
            title: `Success`,
            text: `${textMsg}`,
            icon: 'icofont icofont-checked',
            type: 'success',
            delay: 3000,
        });
    }

    function error_alert(text) {
        new PNotify({
            title: `Oopss`,
            text: `${text}`,
            icon: 'icofont icofont-info-circle',
            type: 'error',
            delay: 3000,
        });
    }
</script>