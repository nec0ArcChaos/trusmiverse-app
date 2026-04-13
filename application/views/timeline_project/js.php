<!-- Datetimepicker Full -->
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<!-- Jquery Confirm -->


<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<!-- Add jQuery and Bootstrap JS at the end of the body -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Fomantic Or Semantic Ui -->
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/dropdown.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/form.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/transition.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/popup.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/toast.js"></script>

<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<!-- Datepicker -->
<script type="text/javascript" src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>

<script src="<?= base_url(); ?>assets/owl_carousel/owl.carousel.min.js"></script>

<script>
    const base_url = '<?= base_url('timeline_project/'); ?>';
</script>
<?php $this->load->view('timeline_project/_content/card_resume_pekerjaan_js'); ?>
<?php $this->load->view('timeline_project/_content/card_pekerjaan_minggu_ini_js'); ?>
<?php $this->load->view('timeline_project/_content/card_resume_data_js'); ?>
<?php $this->load->view('timeline_project/_content/card_aktivitas_js'); ?>
<?php $this->load->view('timeline_project/_content/card_resume_head_js'); ?>
<?php $this->load->view('timeline_project/_content/card_resume_hr_js'); ?>
<?php $this->load->view('timeline_project/_content/card_list_pekerjaan_js'); ?>
<script src="<?= base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.3.1/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
<!-- <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script> -->
<script src="<?= base_url(); ?>assets/js/dataTables.bootstrap5.min.js"></script>


<script>
    $(document).ready(function() {
        /*Range*/
        // var start = moment().startOf('month');
        // var end = moment().endOf('month');

        // function cb(start, end) {
        //   $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        //   $('input[name="start"]').val(start.format('YYYY-MM-DD'));
        //   $('input[name="end"]').val(end.format('YYYY-MM-DD'));
        //   console.log('filter date running');
        // }

        // $('.range').daterangepicker({
        //         startDate: start,
        //         endDate: end,
        //         "drops": "down",
        //         ranges: {
        //             'Today': [moment(), moment()],
        //             'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        //             'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        //             'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        //             'This Month': [moment().startOf('month'), moment().endOf('month')],
        //             'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        //         }
        // }, cb);

        // cb(start, end);

        $(".range").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true
        });

        $(".month_aktivitas").datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months",
            autoclose: true
        });

        $('.tanggal-menit').datetimepicker({
            format: 'Y-m-d H:i:s',
            timepicker: true,
            scrollMonth: false,
            scrollInput: false,
            minDate: 0

        });


    });
</script>

<!-- add new task -->
<script>
    const id_project = new SlimSelect({
        select: "#id_project",
        settings: {
            allowDeselect: true
        }
    });
    const select_project = new SlimSelect({
        select: "#select_project",
        settings: {
            allowDeselect: true
        }
    });
    const id_department = new SlimSelect({
        select: "#id_department",
        settings: {
            allowDeselect: true
        }
    });
    const id_pekerjaan = new SlimSelect({
        select: "#id_pekerjaan",
        settings: {
            allowDeselect: true
        }
    });
    const id_sub_pekerjaan = new SlimSelect({
        select: "#id_sub_pekerjaan",
        settings: {
            allowDeselect: true
        }
    });
    const id_pic = new SlimSelect({
        select: "#id_pic",
        settings: {
            allowDeselect: true
        }
    });
    $('#select_project, #select_year').change(function(e) {
        e.preventDefault();
        reload_data();
    });

    // $('#cb_project').change(function(e) {
    //     e.preventDefault();
    //     var project = $('#select_project').val();
    //     var year = $('#select_year').val();
    //     if ($(this).is(':checked')) {
    //         get_resume_head('All', year);
    //     } else {
    //         get_resume_head(project, year);

    //     }
    // });

    function reload_data() {
        var project = $('#select_project').val();
        var year = $('#select_year').val();

        get_all_list_pekerjaan(project, year);
        get_pekerjaan_minggu_ini(project, year);
        get_resume_activity(project, year);
        get_resume_data_all(project, year);
        get_pekerjaan_status(project, year);
        get_resume_hr(project, year);
        get_resume_head(project, year);
    }


    function add_new_task() {
        $('#modal_add_task').modal('show');
        // $('#id_project').dropdown_se('clear');
        // $('#id_department').dropdown_se('clear');
        // $('#id_pekerjaan').dropdown_se('clear');
        // $('#id_sub_pekerjaan').dropdown_se('clear');
        // $('#id_pic').dropdown_se('clear');
        $('#start').val('');
        $('#end').val('');
        $('#detail').val('');
        $('#output').val('');
        $('#target').val('');

        get_project();
        get_department();
    }

    function add() {
        var modal = $('#modal_add');
        $(modal).modal('show').appendTo('body');
        var project = $('#id_project :selected').text();
        var department = $('#id_department :selected').text();
        $(modal).find('[name="id_project"]').val(project);
        $(modal).find('[name="id_department"]').val(department);
    }

    // $('#id_project, #id_department').change(function(e) {
    //     e.preventDefault();
    //     var project = $('#id_project').val();
    //     var department = $('#id_department').val();
    //     // console.log(project);
    //     // console.log(department);

    //     if (project != null && department != null) {
    //         $('#link_add').removeClass('d-none');
    //     } else if (project != "" && department != "") {
    //         $('#link_add').removeClass('d-none');
    //     } else {
    //         $('#link_add').addClass('d-none');

    //     }
    //     // get_department();
    // });

    let subPekerjaanCount = 1; // Counter untuk sub-pekerjaan

    // Fungsi untuk menambahkan baris sub pekerjaan
    $(document).on('click', '.btn-add', function() {
        subPekerjaanCount++;

        // HTML untuk baris baru
        let newRow = `
            <div class="row mt-1 sub-pekerjaan">
                <div class="col-10">
                    <label class="required">Sub Pekerjaan ${subPekerjaanCount}</label>
                    <input type="text" name="pekerjaan[]" class="form-control border-custom" value="" required="required">
                </div>
                <div class="col-2 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm btn-remove"><i class="fa fa-minus"></i></button>
                </div>
            </div>
        `;

        // Menambahkan baris baru ke dalam container
        $('#row_sub_pekerjaan_container').append(newRow);
    });

    // Fungsi untuk menghapus baris sub pekerjaan
    $(document).on('click', '.btn-remove', function() {
        $(this).closest('.sub-pekerjaan').remove();

        // Mengatur ulang label setelah penghapusan
        subPekerjaanCount = 0;
        $('.sub-pekerjaan').each(function() {
            subPekerjaanCount++;
            $(this).find('label').text(`Sub Pekerjaan ${subPekerjaanCount}`);
        });
    });

    // $('').submit(function (e) { 
    //     e.preventDefault();

    // });
</script>
<!-- /add new task -->

<!-- Project Start -->
<script>
    function get_project() {
        $.ajax({
            url: '<?= base_url() ?>timeline_project/get_project',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            id_project.setData([{
                text: '- Pilih Project -',
                value: '',
                disabled: true,
                selected: true
            }, ...response.map(pr => ({
                text: pr.project,
                value: pr.id_project
            }))]);
            // id_project.update();
            // id_project.setData(response.map(project => ({text: project.project, value: project.id_project})));

        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Project")
        });
    }

    function get_department() {
        $.ajax({
            url: '<?= base_url() ?>timeline_project/get_department',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            id_department.setData([{
                text: '- Pilih Department -',
                value: '',
                disabled: true,
                selected: true
            }, ...response.map(dep => ({
                text: dep.department_name,
                value: dep.department_id
            }))]);
            // id_department.update();


        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Department")
        });
    }

    $('#id_department').change(function(e) {
        e.preventDefault();
        var id_department = $(this).val();
        if (id_department == null) {
            return false;
        }

        $.ajax({
            url: '<?= base_url() ?>timeline_project/pekerjaan_pic',
            type: 'POST',
            dataType: 'json',
            data: {
                id_department: id_department
            },
            success: function(response) {
                id_pekerjaan.setData([]); // Reset options
                id_pic.setData([]); // Reset options
                id_sub_pekerjaan.setData([]);

                id_pekerjaan.setData([{
                    text: '- Pilih Pekerjaan -',
                    value: '',
                    disabled: true,
                    selected: true
                }, ...response.pekerjaan.map(value => ({
                    text: value.pekerjaan,
                    value: value.id
                }))]);
                id_pic.setData(response.pic.map(value => ({
                    text: value.pic_name,
                    value: value.user_id
                })));
                // id_pekerjaan.update();

            },
            error: function(xhr) { // if error occured

            },

        });


    });
    $('#id_pekerjaan').change(function(e) {
        e.preventDefault();
        var id_pekerjaan = $('#id_pekerjaan').val();

        $.ajax({
            url: '<?= base_url() ?>timeline_project/get_sub_pekerjaan_by_pekerjaan',
            type: 'POST',
            dataType: 'json',
            data: {
                id_pekerjaan: id_pekerjaan
            },

            success: function(response) {


                id_sub_pekerjaan.setData([{
                    text: '- Pilih Sub Pekerjaan -',
                    value: '',
                    disabled: true,
                    selected: true
                }, ...response.map(value => ({
                    text: value.sub_pekerjaan,
                    value: value.id
                }))]);
                // id_sub_pekerjaan.update();
            },
            error: function(xhr) { // if error occured

            },

        });
    });
</script>
<!-- Project End -->

<!-- Save Task Start -->
<script>
    function save_task() {
        let val_id_project = $('#id_project').val();
        let val_id_department = $('#id_department').val();
        let val_id_pekerjaan = $('#id_pekerjaan').val();
        let val_id_sub_pekerjaan = $('#id_sub_pekerjaan').val();
        let val_id_pic = $('#id_pic').val();
        let val_start = $('#start').val();
        let val_end = $('#end').val();
        let val_detail = $('#detail').val();
        let val_output = $('#output').val();
        let val_target = $('#target').val();
        console.log(val_id_project);



        if (val_id_project == "" || val_id_project == null) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, project must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_department == "" || val_id_department == null) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, department must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_pekerjaan == "" || val_id_pekerjaan == null) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, pekerjaan must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_sub_pekerjaan == "" || val_id_sub_pekerjaan == null) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, sub pekerjaan must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_pic == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, pic must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_start == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, tanggal mulai must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_end == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, deadline must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_detail == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, detail pekerjaan must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_output == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, output must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else {

            $.confirm({
                icon: 'fa fa-check',
                title: 'Warning',
                theme: 'material',
                type: 'blue',
                content: 'Apakah anda yakin?',
                buttons: {
                    confirm: function() {
                        let form_data_pekerjaan = new FormData();
                        form_data_pekerjaan.append("id_project", val_id_project);
                        form_data_pekerjaan.append("id_department", val_id_department);
                        form_data_pekerjaan.append("id_pekerjaan", val_id_pekerjaan);
                        form_data_pekerjaan.append("id_sub_pekerjaan", val_id_sub_pekerjaan);
                        form_data_pekerjaan.append("id_pic", val_id_pic.toString());
                        form_data_pekerjaan.append("start", val_start);
                        form_data_pekerjaan.append("end", val_end);
                        form_data_pekerjaan.append("detail", val_detail);
                        form_data_pekerjaan.append("output", val_output);
                        form_data_pekerjaan.append("target", val_target);

                        $.ajax({
                            url: `<?= base_url() ?>timeline_project/save_task`,
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data_pekerjaan, // Setting the data attribute of ajax with file_data
                            type: 'post',
                            dataType: 'json',
                            beforeSend: function() {

                            },
                            success: function(response) {},
                            error: function(xhr) {},
                            complete: function() {},
                        }).done(function(response) {
                            console.log(response.save_task);
                            if (response.save_task == true) {
                                $('#modal_add_task').modal('hide');
                                reload_data();
                                setTimeout(() => {
                                    jconfirm.instances[0].close();
                                    $.confirm({
                                        icon: 'fa fa-check',
                                        title: 'Done!',
                                        theme: 'material',
                                        type: 'blue',
                                        content: 'Success! Membuat Detail Pekerjaan',
                                        buttons: {
                                            close: {
                                                actions: function() {}
                                            },
                                        },
                                    });
                                }, 250);
                            } else {
                                $('#modal_add_task').modal('hide');

                                //reload table disini

                                setTimeout(() => {
                                    jconfirm.instances[0].close();
                                    $.confirm({
                                        icon: 'fa fa-check',
                                        title: 'Oops!',
                                        theme: 'material',
                                        type: 'red',
                                        content: 'Server Busy, Try Again Later!',
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
                                    content: 'Failed! ' + textStatus,
                                    buttons: {
                                        close: {
                                            actions: function() {}
                                        },
                                    },
                                });
                            }, 250);
                        });
                    },
                    close: {
                        actions: function() {
                            jconfirm.instances[0].close();
                        }
                    },
                },

            });
            // $.confirm({
            //     icon: 'fa fa-spinner fa-spin',
            //     title: 'Please Wait!',
            //     theme: 'material',
            //     type: 'blue',
            //     content: 'Loading...',
            //     buttons: {
            //         close: {
            //             isHidden: true,
            //             actions: function() {}
            //         },
            //     },
            //     onOpen: function() {
            //         let form_data_pekerjaan = new FormData();
            //         form_data_pekerjaan.append("id_project", val_id_project);
            //         form_data_pekerjaan.append("id_department", val_id_department);
            //         form_data_pekerjaan.append("id_pekerjaan", val_id_pekerjaan);
            //         form_data_pekerjaan.append("id_sub_pekerjaan", val_id_sub_pekerjaan);
            //         form_data_pekerjaan.append("id_pic", val_id_pic.toString());
            //         form_data_pekerjaan.append("start", val_start);
            //         form_data_pekerjaan.append("end", val_end);
            //         form_data_pekerjaan.append("detail", val_detail);
            //         form_data_pekerjaan.append("output", val_output);
            //         form_data_pekerjaan.append("target", val_target);

            //         $.ajax({
            //             url: `<?= base_url() ?>timeline_project/save_task`,
            //             cache: false,
            //             contentType: false,
            //             processData: false,
            //             data: form_data_pekerjaan, // Setting the data attribute of ajax with file_data
            //             type: 'post',
            //             dataType: 'json',
            //             beforeSend: function() {

            //             },
            //             success: function(response) {},
            //             error: function(xhr) {},
            //             complete: function() {},
            //         }).done(function(response) {
            //             console.log(response.save_task);
            //             if (response.save_task == true) {
            //                 $('#modal_add_task').modal('hide');
            //                 reload_data();
            //                 setTimeout(() => {
            //                     jconfirm.instances[0].close();
            //                     $.confirm({
            //                         icon: 'fa fa-check',
            //                         title: 'Done!',
            //                         theme: 'material',
            //                         type: 'blue',
            //                         content: 'Success! Membuat Detail Pekerjaan',
            //                         buttons: {
            //                             close: {
            //                                 actions: function() {}
            //                             },
            //                         },
            //                     });
            //                 }, 250);
            //             } else {
            //                 $('#modal_add_task').modal('hide');

            //                 //reload table disini

            //                 setTimeout(() => {
            //                     jconfirm.instances[0].close();
            //                     $.confirm({
            //                         icon: 'fa fa-check',
            //                         title: 'Oops!',
            //                         theme: 'material',
            //                         type: 'red',
            //                         content: 'Server Busy, Try Again Later!',
            //                         buttons: {
            //                             close: {
            //                                 actions: function() {}
            //                             },
            //                         },
            //                     });
            //                 }, 250);
            //             }
            //         }).fail(function(jqXHR, textStatus) {
            //             setTimeout(() => {
            //                 jconfirm.instances[0].close();
            //                 $.confirm({
            //                     icon: 'fa fa-close',
            //                     title: 'Oops!',
            //                     theme: 'material',
            //                     type: 'red',
            //                     content: 'Failed! ' + textStatus,
            //                     buttons: {
            //                         close: {
            //                             actions: function() {}
            //                         },
            //                     },
            //                 });
            //             }, 250);
            //         });
            //     },
            // });
        }
    }

    function approval() {
        $('#modal_approval').modal('show').appendTo('body');
        $('#table_approval').DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "autoWidth": false,
            "destroy": true,
            "dom": 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "GET",
                "url": base_url + `/get_request`,
                'dataSrc': ''
            },
            "columns": [{
                    "data": "sts",
                    'render': function(data, type, row) {
                        if (row['status'] == 1) {
                            return `<span class="badge bg-primary text-nowrap" style='cursor:pointer' onclick="update_approve('${row['id_req']}','${row['id_detail']}')">${data}</span>`;
                        } else if (row['status'] == 2) {
                            return `<span class="text-success small text-nowrap"><i class="bi bi-check"></i> ${data}</span>`;
                        } else {
                            return `<span class="text-danger small text-nowrap"><i class="bi bi-x-circle"></i> ${data}</span>`;

                        }
                    }

                },
                {
                    "data": "detail"
                },
                {
                    "data": "start",
                    "className": "text-nowrap"
                },
                {
                    "data": "end",
                    "className": "text-nowrap"
                },
                {
                    "data": "req_start_2",
                    "className": "text-nowrap"
                },
                {
                    "data": "req_end_2",
                    "className": "text-nowrap"
                },
                {
                    "data": "note"
                },
                {
                    "data": "created_by"
                },
                {
                    "data": "created_at"
                },
            ]
        });
    }

    function update_approve(id, detail) {
        $('#id_req').val(id);
        $('#id_detail_req').val(detail);
        $('#update_approve').modal('show').appendTo('body');
    }
    $('#form_update_approve').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        $.confirm({
            icon: 'fa fa-check',
            title: 'Warning',
            theme: 'material',
            type: 'blue',
            content: 'Apakah anda yakin?',
            buttons: {
                confirm: function() {
                    var loadingDialog = $.confirm({
                        icon: 'fa fa-spinner fa-spin',
                        title: 'Loading',
                        theme: 'material',
                        type: 'blue',
                        content: 'Please wait, processing...',
                        buttons: false, // Disable buttons
                        closeIcon: false, // Disable close icon
                    });
                    $.ajax({
                        type: "POST",
                        url: base_url + `/update_approve`,
                        data: form.serialize(),
                        dataType: "json",
                        success: function(response) {
                            loadingDialog.close();
                            $('#update_approve').modal('hide');
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
                            $('#table_approval').DataTable().ajax.reload();
                            reload_data();
                        }
                    });
                },
                close: {
                    actions: function() {
                        // $('#modal_input').modal('hide');
                        // $("#dt-pk").DataTable().ajax.reload();
                        jconfirm.instances[0].close();
                    }
                },
            },

        });
    });
</script>
<!-- Save Task End  -->