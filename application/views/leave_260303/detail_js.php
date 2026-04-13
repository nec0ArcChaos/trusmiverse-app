<script type="text/javascript" src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>

<script>
    // Running Datepicker
    // $('.tanggal').datepicker({
    //     format: 'yyyy-mm-dd',
    //     autoclose: true,
    //     todayHighlight: true
    // });

    $('.tanggal').datetimepicker({
        format: 'Y-m-d H:i'
    });


    $(".tgl").mask('0000-00-00 00:00')
    let options = {
        searchable: true
    }
    let leave_type = NiceSelect.bind(document.getElementById('leave_type'), options);
    get_leave_type()

    function get_leave_type() {
        employee_id = "<?= $detail_leave['employee_id'] ?>";
        leave_type_id = "<?= $detail_leave['leave_type_id'] ?>";
        $.ajax({
            url: '<?= base_url() ?>leave/get_leave_type_detail',
            dataType: 'json',
            method: 'POST',
            data: {
                user_id: employee_id
            }
        }).done(function(response) {
            opt_leave_type = '';
            // 5 Karyawan sakit 
            // 6 Pergantian shift
            // 7 Pergantian hari libur
            // 10 Izin pulang cepat
            // 11 Izin datang terlambat
            // 13 Dinas luar kota
            // 23 Dinas luar kota driver



            // 8 Istri bersalin (2 hari dalam 1 periode) 
            // 9 Kematian keluarga kandung (2 hari dalam 1 periode)

            date_now = '<?= strtotime(date("Y-m-d")) ?>'
            bali_cut_off = '<?= strtotime(date("Y-04-15")) ?>'
            crb_cut_off = '<?= strtotime(date("Y-04-20")) ?>'
            console.log((date_now));
            console.log((bali_cut_off));
            console.log((crb_cut_off));
            // tgl 15 dan 20 Maret  company  bali, 20
            array_change_remaining = ['8', '9'];
            array_hide_remaining = ['5', '6', '7', '10', '11', '13', '23'];
            for (let index = 0; index < response.leave_type.length; index++) {
                if (array_hide_remaining.includes(response.leave_type[index].leave_type_id)) {
                    remaining = '';
                } else {
                    if (array_change_remaining.includes(response.leave_type[index].leave_type_id)) {
                        remaining = `(2 hari dalam 1 periode)`;
                    } else {
                        remaining = `(${response.leave_type[index].sisa_izin} Remaining)`;
                    }
                }
                if (date_now > bali_cut_off && response.leave_type[index].leave_type_id == 19) {
                    console.log(response.leave_type[index].leave_type_id)
                } else {
                    opt_leave_type += `<option value="${response.leave_type[index].leave_type_id}" data-warning="${response.leave_type[index].warning}" ${response.leave_type[index].leave_type_id == leave_type_id ? 'selected' : ''}>${response.leave_type[index].type_name} ${remaining}</option>`
                }
            }
            $('#leave_type').empty().append(opt_leave_type);
            leave_type.update();
            // opt_kota = '<option value="">Pilih Kota</option>';
            // for (let index = 0; index < response.kota.length; index++) {
            //     opt_kota += `<option value="${response.kota[index].id}">${response.kota[index].city}, ${response.kota[index].state}</option>`
            // }
            // $('#kota').empty().append(opt_kota);
            // kota.update();
        }).fail(function() {});
    }

    get_available_leave()

    function get_available_leave() {
        employee_id = "<?= $detail_leave['employee_id'] ?>";
        $.ajax({
            url: '<?= base_url() ?>leave/statistic_leave',
            type: 'POST',
            dataType: 'json',
            data: {
                employee_id: employee_id
            },
            beforeSend: function() {},
        }).done(function(response) {
            list_available_leave = `<div class="collapse" id="collapse_available_leave">`
            list_available_leave += `<li class="list-group-item border-start-0 border-end-0">
                                        <div class="row">
                                            <div class="col align-self-center">
                                                <p  class="text-dinamis text-color-theme mb-0">Leave Type</p>
                                            </div>
                                            <div class="col-2 align-self-center text-end">
                                                <p  class="text-dinamis mb-0">Available</p>
                                            </div>
                                            <div class="col-2 align-self-center text-end">
                                                <p  class="text-dinamis mb-0">Taken</p>
                                            </div>
                                        </div>
                                    </li>`
            for (let index = 0; index < response.length; index++) {
                list_available_leave += `<li class="list-group-item border-start-0 border-end-0">
                                            <div class="row">
                                                <div class="col align-self-center">
                                                    <p  class="text-dinamis text-color-theme mb-0">${response[index].type_name}</p>
                                                </div>
                                                <div class="col-2 align-self-center text-end">
                                                    <p  class="text-dinamis mb-0">${response[index].sisa_izin}</p>
                                                </div>
                                                <div class="col-2 align-self-center text-end">
                                                    <p  class="text-dinamis mb-0">${response[index].jml_hari}</p>
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar ${response[index].style}" role="progressbar" aria-valuenow="${response[index].jml_hari}" style="width: ${response[index].persen}%;" aria-valuemin="0" aria-valuemax="${response[index].days_per_year}">${response[index].jml_hari}</div>
                                            </div>
                                        </li>`
            }

            list_available_leave += ` </div>`
            console.log(response);

            $('#available_leave').empty().append(list_available_leave);
        }).fail(function(jqXhr, textStatus) {

        });
    }


    function update_leave_hr(leave_id) {
        let user_id = '<?= $this->session->userdata('user_id') ?>';
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        let remarks = $('#remarks').val();
        let leave_type_id = $('#leave_type_id').val();
        let leave_type = $('#leave_type').val() ?? '';
        let id_status = $('#id_status').val();
        $.confirm({
            title: 'Alert!',
            type: 'blue',
            theme: 'material',
            content: `Apakah anda yakin approve request leave ini ?`,
            buttons: {
                cancel: function() {
                    //close
                },
                formSubmit: {
                    text: 'Approve',
                    btnClass: 'btn-blue',
                    action: function() {
                        $.confirm({
                            icon: `fa fa-spinner fa-spin`,
                            title: 'Mohon Tunggu!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Sedang memproses...',
                            buttons: {
                                close: {
                                    isHidden: true,
                                    actions: function() {}
                                },
                            },
                            onOpen: function() {
                                $.ajax({
                                    url: '<?= base_url() ?>leave/update_leave_hr',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        leave_id: leave_id,
                                        start_date: start_date,
                                        end_date: end_date,
                                        leave_type_id: leave_type_id,
                                        leave_type: leave_type,
                                        id_status: id_status,
                                    },
                                    beforeSend: function() {

                                    },
                                    success: function(response) {},
                                    error: function(xhr) {},
                                    complete: function() {},
                                }).done(function(response) {
                                    console.log(response);
                                    if (response.status == true) {

                                        setTimeout(() => {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-check',
                                                title: 'Done!',
                                                theme: 'material',
                                                type: 'blue',
                                                content: 'Success!',
                                                buttons: {
                                                    close: {
                                                        actions: function() {}
                                                    },
                                                },
                                            });
                                        }, 250);

                                        setTimeout(() => {
                                            window.location = "<?= base_url() ?>leave/detail/" + leave_id;
                                        }, 1500);
                                    } else {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-close',
                                            title: 'Oops!',
                                            theme: 'material',
                                            type: 'red',
                                            content: 'Failed!',
                                            buttons: {
                                                close: {
                                                    actions: function() {}
                                                },
                                            },
                                        });
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
            },
        });
    }

    function approve_leave(leave_id) {
        let user_id = '<?= $this->session->userdata('user_id') ?>';
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        let remarks = $('#remarks').val();
        let leave_type_id = $('#leave_type_id').val();
        let leave_type = $('#leave_type').val() ?? '';
        let id_status = $('#id_status').val();
        $.confirm({
            title: 'Alert!',
            type: 'blue',
            theme: 'material',
            content: `Apakah anda yakin approve request leave ini ?`,
            buttons: {
                cancel: function() {
                    //close
                },
                formSubmit: {
                    text: 'Approve',
                    btnClass: 'btn-blue',
                    action: function() {
                        $.confirm({
                            icon: `fa fa-spinner fa-spin`,
                            title: 'Mohon Tunggu!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Sedang memproses...',
                            buttons: {
                                close: {
                                    isHidden: true,
                                    actions: function() {}
                                },
                            },
                            onOpen: function() {
                                $.ajax({
                                    url: '<?= base_url() ?>leave/approve_leave',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        leave_id: leave_id,
                                        start_date: start_date,
                                        end_date: end_date,
                                        remarks: remarks,
                                        leave_type_id: leave_type_id,
                                        leave_type: leave_type,
                                        id_status: id_status,
                                    },
                                    beforeSend: function() {

                                    },
                                    success: function(response) {},
                                    error: function(xhr) {},
                                    complete: function() {},
                                }).done(function(response) {
                                    console.log(response);
                                    if (response.status == true) {

                                        setTimeout(() => {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-check',
                                                title: 'Done!',
                                                theme: 'material',
                                                type: 'blue',
                                                content: 'Success!',
                                                buttons: {
                                                    close: {
                                                        actions: function() {}
                                                    },
                                                },
                                            });
                                        }, 250);

                                        setTimeout(() => {
                                            window.location = "<?= base_url() ?>leave";
                                        }, 1500);
                                    } else {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-close',
                                            title: 'Oops!',
                                            theme: 'material',
                                            type: 'red',
                                            content: 'Failed!',
                                            buttons: {
                                                close: {
                                                    actions: function() {}
                                                },
                                            },
                                        });
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
            },
        });
    }

    function reject_leave(leave_id) {
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        let remarks = $('#remarks').val();
        let leave_type_id = $('#leave_type_id').val();
        let id_status = $('#id_status').val();
        $.confirm({
            title: 'Alert!',
            type: 'blue',
            theme: 'material',
            content: `Apakah anda yakin reject request leave ini ?`,
            buttons: {
                cancel: function() {
                    //close
                },
                formSubmit: {
                    text: 'Reject',
                    btnClass: 'btn-red',
                    action: function() {
                        $.confirm({
                            icon: `fa fa-spinner fa-spin`,
                            title: 'Mohon Tunggu!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Sedang memproses...',
                            buttons: {
                                close: {
                                    isHidden: true,
                                    actions: function() {}
                                },
                            },
                            onOpen: function() {
                                $.ajax({
                                    url: '<?= base_url() ?>leave/reject_leave',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        leave_id: leave_id,
                                        start_date: start_date,
                                        end_date: end_date,
                                        remarks: remarks,
                                        leave_type_id: leave_type_id,
                                        id_status: id_status,
                                    },
                                    beforeSend: function() {

                                    },
                                    success: function(response) {},
                                    error: function(xhr) {},
                                    complete: function() {},
                                }).done(function(response) {
                                    if (response.status == true) {

                                        setTimeout(() => {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-check',
                                                title: 'Done!',
                                                theme: 'material',
                                                type: 'blue',
                                                content: 'Success!',
                                                buttons: {
                                                    close: {
                                                        actions: function() {}
                                                    },
                                                },
                                            });
                                        }, 250);

                                        setTimeout(() => {
                                            window.location = "<?= base_url() ?>leave";
                                        }, 1500);
                                    } else {
                                        jconfirm.instances[0].close();
                                        $.confirm({
                                            icon: 'fa fa-close',
                                            title: 'Oops!',
                                            theme: 'material',
                                            type: 'red',
                                            content: 'Failed!',
                                            buttons: {
                                                close: {
                                                    actions: function() {}
                                                },
                                            },
                                        });
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
            },
        });
    }

    function redirect_to_leave() {
        setTimeout(() => {
            window.location.href = "<?= base_url() ?>leave";
            console.log("clicked")
        }, 1000);
    }
</script>