<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js"></script>
<!-- <script type="text/javascript" src="<?= base_url(); ?>assets/jquery-timepicker/jquery.timepicker.min.js"></script> -->

<script>
    function add_new_task() {
        $('#modal_add_task').modal('show');
        // id_type = $('#id_type').val(); // utk dinamis
        // id_category = $('#id_category').val() // utk dinamis
        id_type = 1; // sementara di set static
        id_category = 1; // sementara di set static
        $('#task').val('');
        // $('#indicator').val('');
        $('#due_date').val('');
        $('#jenis_strategy1').prop('checked', true);
        $('#jenis_strategy2').prop('checked', false);
        get_type();
        if (id_type != "" && id_type != "add_new") {
            setTimeout(() => {
                $('#id_type').val(id_type);
                sel_id_type.update();
            }, 250);
            setTimeout(() => {
                get_category();
                if (id_category != "" && id_category != "add_new") {
                    setTimeout(() => {
                        $('#id_category').val(id_category);
                        sel_id_category.update();
                        get_object();
                        setTimeout(() => {
                            $('#id_object').val(1); // set static goals
                            sel_id_object.update();
                            $('#id_status').val(1); // set static not started
                            sel_id_status.update();
                        }, 250);
                    }, 250);
                }
            }, 500);
        }
    }

    let sel_jam_notif = NiceSelect.bind(document.getElementById('jam_notif'), {
        searchable: true
    });
    let sel_u_jam_notif = NiceSelect.bind(document.getElementById('u_jam_notif'), {
        searchable: true
    });

    // Type Start
    let sel_id_type = NiceSelect.bind(document.getElementById('id_type'), {
        searchable: true
    });
    let id_project = NiceSelect.bind(document.getElementById('id_project'), {
        searchable: true
    });
    let id_pekerjaan = NiceSelect.bind(document.getElementById('id_pekerjaan'), {
        searchable: true
    });
    let id_sub_pekerjaan = NiceSelect.bind(document.getElementById('id_sub_pekerjaan'), {
        searchable: true
    });
    let id_detail_pekerjaan = NiceSelect.bind(document.getElementById('id_detail_pekerjaan'), {
        searchable: true
    });


    get_type()

    function get_type() {
        $.ajax({
            url: '<?= base_url() ?>monday/get_type',
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
            // console.log(response);
            list_type = '<option value="">Choose Group</option>';
            for (let index = 0; index < response.length; index++) {
                list_type += `<option value="${response[index].id_type}">${response[index].type}</option>`;
            }
            list_type += '<option value="add_new">+ Add Group</option>';
            $("#id_type").empty().append(list_type)
            sel_id_type.update();
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }

    let type_element = document.getElementById("id_type");
    type_element.addEventListener("change", function() {
        if (type_element.value == "add_new") {
            add_new_type();
        }
    });

    function add_new_type() {
        $('#modal_add_task').modal("hide");
        $('#modal_add_type').modal("show");
    }

    function close_type() {
        add_new_task()
        $('#modal_add_type').modal("hide");
    }

    function save_type() {
        type_name = $('#type_name').val();
        if (type_name != "") {
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
                        url: `<?= base_url() ?>monday/save_type`,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            type_name: type_name
                        },
                        beforeSend: function() {

                        },
                        success: function(response) {},
                        error: function(xhr) {},
                        complete: function() {},
                    }).done(function(response) {
                        if (response == true) {
                            close_type();
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
                        } else {
                            close_type();
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
    }
    // Type End

    // Category Start
    let sel_id_category = NiceSelect.bind(document.getElementById('id_category'), {
        searchable: true
    });

    function get_category() {
        let id_type_selected = "";
        id_type_selected = $('#id_type').val() ?? "";
        if (id_type_selected == 1) {
            $('#goals_div').removeClass('d-none')
        } else {
            $('#goals_div').addClass('d-none')
        }
        $.ajax({
            url: '<?= base_url() ?>monday/get_category',
            type: 'POST',
            dataType: 'json',
            data: {
                id_type: id_type_selected
            },
            beforeSend: function() {
                $('#id_category').empty().append('<option value=""><i class="fa fa-spinner fa-spin"></i> Loading..</option>').prop('disabled', true);
                sel_id_category.update()
            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            $('#id_category').prop('disabled', false)
            // console.log(response);
            list_category = '<option value="">Choose Category</option>';
            for (let index = 0; index < response.length; index++) {
                list_category += `<option value="${response[index].id_category}">${response[index].category}</option>`;
            }
            list_category += '<option value="add_new">+ Add Category</option>';

            $("#id_category").empty().append(list_category).prop('disabled', false);
            sel_id_category.update()
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Category")
        });
    }

    let category_element = document.getElementById("id_category");
    category_element.addEventListener("change", function() {
        if (category_element.value == "add_new") {
            add_new_category();
        }
    });

    function add_new_category() {
        $('#modal_add_task').modal("hide");
        $('#modal_add_category').modal("show");
    }

    function close_category() {
        add_new_task()
        $('#modal_add_category').modal("hide");
    }

    function save_category() {
        id_type = $('#id_type').val();
        category_name = $('#category_name').val();
        if (category_name != "") {
            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please wait..',
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
                        url: `<?= base_url() ?>monday/save_category`,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            category_name: category_name,
                            id_type: id_type
                        },
                        beforeSend: function() {

                        },
                        success: function(response) {},
                        error: function(xhr) {},
                        complete: function() {},
                    }).done(function(response) {
                        if (response == true) {
                            close_category();
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
                        } else {
                            close_category();
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
    }
    // Category End

    // Object Start
    let sel_id_object = NiceSelect.bind(document.getElementById('id_object'), {
        searchable: true
    });

    function get_object() {
        let id_category_selected = "";
        id_category_selected = $('#id_category').val() ?? "";
        $.ajax({
            url: '<?= base_url() ?>monday/get_object',
            type: 'POST',
            dataType: 'json',
            data: {
                id_category: id_category_selected
            },
            beforeSend: function() {
                $('#id_object').empty().append('<option value=""><i class="fa fa-spinner fa-spin"></i> Loading..</option>').prop('disabled', true);
                sel_id_object.update()
            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            $('#id_object').prop('disabled', false)
            // console.log(response);
            // list_object = '';
            list_object = '<option value="">Choose Object</option>';
            if (response != null) {
                for (let index = 0; index < response.length; index++) {
                    list_object += `<option value="${response[index].id_object}">${response[index].object}</option>`;
                }
            }
            list_object += '<option value="add_new">+ Add Object</option>';
            $("#id_object").empty().append(list_object).prop('disabled', false);
            sel_id_object.update()
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }

    let object_element = document.getElementById("id_object");
    object_element.addEventListener("change", function() {
        if (object_element.value == "add_new") {
            add_new_object();
        }
    });

    function add_new_object() {
        $('#modal_add_task').modal("hide");
        $('#modal_add_object').modal("show");
    }

    function close_object() {
        add_new_task()
        $('#modal_add_object').modal("hide");
    }

    function save_object() {
        id_category = $('#id_category').val();
        object_name = $('#object_name').val();
        if (object_name != "") {
            $.confirm({
                icon: 'fa fa-spinner fa-spin',
                title: 'Please wait..',
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
                        url: `<?= base_url() ?>monday/save_object`,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            object_name: object_name,
                            id_category: id_category,
                        },
                        beforeSend: function() {

                        },
                        success: function(response) {},
                        error: function(xhr) {},
                        complete: function() {},
                    }).done(function(response) {
                        if (response == true) {
                            close_object();
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
                        } else {
                            close_object();
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
    }
    // Object End

    // Status Start
    let sel_id_status = NiceSelect.bind(document.getElementById('id_status'), {
        searchable: true
    });

    get_status()

    function get_status() {
        $.ajax({
            url: '<?= base_url() ?>monday/get_status',
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
            // console.log(response);
            list_type = '<option value="">Choose Status</option>';
            for (let index = 0; index < response.length; index++) {
                list_type += `<option value="${response[index].id_status}">${response[index].status}</option>`;
            }
            $("#id_status").empty().append(list_type)
            sel_id_status.update();
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }
    // Status End

    // PIC Start
    let sel_id_pic = NiceSelect.bind(document.getElementById('id_pic'), {
        searchable: true
    });

    get_pic()

    function get_pic() {
        $.ajax({
            url: '<?= base_url() ?>monday/get_pic',
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
            // console.log(response);
            user_id = "<?= $this->session->userdata('user_id'); ?>"
            list_pic = `<option value="${user_id}">My Self</option>`;
            for (let index = 0; index < response.length; index++) {
                list_pic += `<option value="${response[index].id_pic}">${response[index].pic}</option>`;
            }
            $("#id_pic").empty().append(list_pic)
            sel_id_pic.update();
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }
    // PIC End


    // Priority Start
    // let sel_id_priority = NiceSelect.bind(document.getElementById('id_priority'), {
    //     searchable: true
    // });

    // get_priority()

    // function get_priority() {
    //     $.ajax({
    //         url: '<?= base_url() ?>monday/get_priority',
    //         type: 'POST',
    //         dataType: 'json',
    //         beforeSend: function() {

    //         },
    //         success: function(response) {

    //         },
    //         error: function(xhr) { // if error occured

    //         },
    //         complete: function() {

    //         },
    //     }).done(function(response) {
    //         // console.log(response);
    //         list_priority = '<option value="">Choose Priority</option>';
    //         for (let index = 0; index < response.length; index++) {
    //             list_priority += `<option value="${response[index].id_priority}">${response[index].priority}</option>`;
    //         }
    //         $("#id_priority").empty().append(list_priority)
    //         sel_id_priority.update();
    //     }).fail(function(jqXhr, textStatus) {
    //         console.log("Failed Get Type")
    //     });
    // }
    // Priority End


    // Task Start
    function save_task() {
        page_uri = '<?= $this->uri->segment(1); ?>';
        let val_id_type = 1;
        let val_id_category = 1;
        let val_id_object = 1;
        let val_id_status = 1;
        let val_id_pic = $('#id_pic').val();
        // let val_id_priority = $('#id_priority').val();
        let val_due_date = $('#due_date').val();
        let val_task = $('#task').val();
        // let val_description = $('#description').val();
        // let val_indicator = $('#indicator').val();
        // let val_strategy = $('#strategy').val();
        let val_jenis_strategy = $('input[name="jenis_strategy"]:checked').val();
        let val_project = $('#id_project').val() ?? "";
        let val_pekerjaan = $('#id_pekerjaan').val() ?? "";
        let val_sub_pekerjaan = $('#id_sub_pekerjaan').val() ?? "";
        let val_detail_pekerjaan = $('#id_detail_pekerjaan').val() ?? "";
        console.log(val_jenis_strategy);

        if (val_id_type == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, group must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_category == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, category must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_object == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, object must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_id_status == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, status must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_task == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Goals must be filled',
                buttons: {
                    close: {
                        actions: function(tutup) {}
                    },
                },
            });
        } else if (val_due_date == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Due Date must be filled',
                buttons: {
                    close: {
                        actions: function(tutup) {}
                    },
                },
            });
            // } else if (val_description == "") {
            //     $.confirm({
            //         icon: 'fa fa-close',
            //         title: 'Oops!',
            //         theme: 'material',
            //         type: 'red',
            //         content: 'Oops, description must be filled',
            //         buttons: {
            //             close: {
            //                 actions: function() {}
            //             },
            //         },
            //     });
            // } else if (val_id_priority == "") {
            //     $.confirm({
            //         icon: 'fa fa-close',
            //         title: 'Oops!',
            //         theme: 'material',
            //         type: 'red',
            //         content: 'Oops, priority must be filled',
            //         buttons: {
            //             close: {
            //                 actions: function() {}
            //             },
            //         },
            //     });
            // } else if (val_id_type == 1 && val_indicator == "") {
            //     $.confirm({
            //         icon: 'fa fa-close',
            //         title: 'Oops!',
            //         theme: 'material',
            //         type: 'red',
            //         content: 'Oops, indicator must be filled',
            //         buttons: {
            //             close: {
            //                 actions: function() {}
            //             },
            //         },
            //     });
            // } else if (val_id_type == 1 && val_strategy == "") {
            //     $.confirm({
            //         icon: 'fa fa-close',
            //         title: 'Oops!',
            //         theme: 'material',
            //         type: 'red',
            //         content: 'Oops, strategy must be filled',
            //         buttons: {
            //             close: {
            //                 actions: function() {}
            //             },
            //         },
            //     });
        } else if (val_id_type == 1 && val_jenis_strategy == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, jenis strategy must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (due_date == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, due date must be filled',
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
        } else if ($('#ceklis_pekerjaan').is(':checked') && val_project == "" || $('#ceklis_pekerjaan').is(':checked') && val_pekerjaan == "" || $('#ceklis_pekerjaan').is(':checked') && val_sub_pekerjaan == "" || $('#ceklis_pekerjaan').is(':checked') && val_detail_pekerjaan == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Input Project, Pekerjaan, Sub Pekerjaan, dan Detail harus di pilih!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });

        } else {
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
                        url: `<?= base_url() ?>monday_dev/save_task`,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id_type: val_id_type,
                            id_category: val_id_category,
                            id_object: val_id_object,
                            id_status: val_id_status,
                            id_pic: val_id_pic,
                            // id_priority: val_id_priority,
                            task: val_task,
                            // description: val_description,
                            due_date: val_due_date,
                            // indicator: val_indicator,
                            // strategy: val_strategy,
                            jenis_strategy: val_jenis_strategy,
                            project: val_project,
                            pekerjaan: val_pekerjaan,
                            sub_pekerjaan: val_sub_pekerjaan,
                            detail_pekerjaan: val_detail_pekerjaan,
                        },
                        beforeSend: function() {

                        },
                        success: function(response) {},
                        error: function(xhr) {},
                        complete: function() {},
                    }).done(function(response) {
                        if (response.save_task == true) {
                            $('#modal_add_task').modal('hide');
                            if (page_uri == "monday") {
                                dt_task();
                            } else {
                                kanban_data();
                            }
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                // $.confirm({
                                //     icon: 'fa fa-check',
                                //     title: 'Done!',
                                //     theme: 'material',
                                //     type: 'blue',
                                //     content: 'Success!',
                                //     buttons: {
                                //         close: {
                                //             actions: function() {}
                                //         },
                                //     },
                                // });
                            }, 250);
                            setTimeout(() => {
                                modal_sub_task(response.id_task);
                            }, 500);
                        } else {
                            $('#modal_add_task').modal('hide');
                            dt_task();
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

    }
    $(document).ready(function() {
        $('.tanggal').datetimepicker({
            format: 'Y-m-d',
            timepicker: false,
            minDate: 0,
            scrollInput: false
        });

        $(".tanggal").mask('0000-00-00')
    });

    let e_sel_id_status = NiceSelect.bind(document.getElementById('e_id_status'), {
        searchable: true
    });

    function modal_add_sub_task() {
        $('#modal_sub_task').modal('hide');
        $('#modal_add_sub_task').modal('show');
        $('#sub_task').val('');
        $('#sub_type').val('');
        $('#start_date').val('');
        $('#end_date').val('');
        $('#sub_note').val('');
        $("input[name='sub_type_check']").prop('checked', false);
    }

    function close_add_sub_task() {
        $('#modal_add_sub_task').modal('hide');
        $('#modal_sub_task').modal('show');
    }

    function set_min_date() {
        min_date = $('#start_date').val();
        console.log();
        $('#end_date').datetimepicker({
            format: 'Y-m-d',
            timepicker: false,
            minDate: min_date
        });
    }

    function set_min_date_update(id_sub_task) {
        min_date = $('#start_date_' + id_sub_task).val();
        console.log();
        $('#end_date_' + id_sub_task).datetimepicker({
            format: 'Y-m-d',
            timepicker: false,
            minDate: min_date
        });
    }

    function save_add_sub_task() {
        let val_id_task = $('#id_task').val();
        let val_sub_task = $('#sub_task').val();
        let val_sub_task_indicator = $('#sub_indicator').val();
        let val_sub_type = $('#sub_type').val();
        let val_sub_day = $('#sub_day').val();
        let val_jml_sub_day = $('#jml_sub_day').val();
        let val_start_date = $('#start_date').val();
        let val_end_date = $('#end_date').val();
        let val_note_sub = $('#sub_note').val();
        let val_jam_notif = $('#jam_notif').val();

        if (val_id_task == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, id strategy is not found',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_sub_task == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, strategy must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
            // } else if (val_sub_type == "") {
            //     $.confirm({
            //         icon: 'fa fa-close',
            //         title: 'Oops!',
            //         theme: 'material',
            //         type: 'red',
            //         content: 'Oops, type strategy must be choosed',
            //         buttons: {
            //             close: {
            //                 actions: function() {}
            //             },
            //         },
            //     });
            // } else if (val_start_date == "") {
            //     $.confirm({
            //         icon: 'fa fa-close',
            //         title: 'Oops!',
            //         theme: 'material',
            //         type: 'red',
            //         content: 'Oops, start date must be filled',
            //         buttons: {
            //             close: {
            //                 actions: function() {}
            //             },
            //         },
            //     });
            // } else if (val_end_date == "") {
            //     $.confirm({
            //         icon: 'fa fa-close',
            //         title: 'Oops!',
            //         theme: 'material',
            //         type: 'red',
            //         content: 'Oops, end date must be filled',
            //         buttons: {
            //             close: {
            //                 actions: function(tutup) {}
            //             },
            //         },
            //     });
        } else {

            let file_data = $("#file_sub").prop("files")[0];
            let form_data_sub = new FormData();
            form_data_sub.append("id_task", val_id_task);
            form_data_sub.append("sub_task", val_sub_task);
            form_data_sub.append("sub_indicator", val_sub_task_indicator);
            form_data_sub.append("sub_type", val_sub_type);
            form_data_sub.append("sub_day", val_sub_day);
            form_data_sub.append("jml_sub_day", val_jml_sub_day);
            form_data_sub.append("start_date", val_start_date);
            form_data_sub.append("end_date", val_end_date);
            form_data_sub.append("file_sub", file_data);
            form_data_sub.append("sub_note", val_note_sub);
            form_data_sub.append("jam_notif", val_jam_notif);
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
                        url: `<?= base_url() ?>monday/save_sub_task`,
                        type: 'POST',
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data_sub, // Setting the data attribute of ajax with file_data
                        type: 'post',
                        beforeSend: function() {

                        },
                        success: function(response) {},
                        error: function(xhr) {},
                        complete: function() {},
                    }).done(function(response) {
                        if (response.save_sub_task == true) {
                            $('#sub_task').val('');
                            $('#sub_type').val('');
                            $('#start_date').val('');
                            $('#end_date').val('');
                            $('#sub_note').val('');
                            // $('#modal_add_sub_task').modal('hide');
                            $("input[name='sub_type_check']").prop('checked', false);
                            $("input[name='sub_type_day']").prop('checked', false);
                            $("#choose_day_of_weeks").addClass('d-none', false);

                            dt_sub_task_card(response.id_task);
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Success!',
                                    theme: 'material',
                                    type: 'blue',
                                    content: 'Data Saved!',
                                    buttons: {
                                        close: {
                                            actions: function() {}
                                        },
                                    },
                                });
                            }, 250);
                            // setTimeout(() => {
                            //     modal_sub_task(response.id_task);
                            // }, 500);
                        } else {
                            // $('#modal_add_sub_task').modal('hide');
                            modal_sub_task(id_task)
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
    }


    function update_strategy_sub_task(id_sub_task) {
        let u_val_id_task = $(`#id_task_${id_sub_task}`).val();
        let u_val_id_sub_task = id_sub_task;
        let u_val_sub_task = $(`#sub_task_${id_sub_task}`).val();
        let u_val_sub_indicator = $(`#sub_indicator_${id_sub_task}`).val();
        let u_val_sub_type = $(`#sub_type_${id_sub_task}`).val();
        let u_val_sub_day = $(`#sub_day_${id_sub_task}`).val();
        let u_val_jml_sub_day = $(`#jml_sub_day_${id_sub_task}`).val();
        let u_val_start_date = $(`#start_date_${id_sub_task}`).val();
        let u_val_end_date = $(`#end_date_${id_sub_task}`).val();
        let u_val_note_sub = $(`#sub_note_${id_sub_task}`).val();
        let u_val_jam_notif = $(`#jam_notif_${id_sub_task}`).val();

        if (u_val_id_task == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, id strategy is not found',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (u_val_sub_task == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, strategy must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (u_val_sub_type == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, type strategy must be choosed',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (u_val_start_date == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, start date must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (u_val_end_date == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, end date must be filled',
                buttons: {
                    close: {
                        actions: function(tutup) {}
                    },
                },
            });
        } else {

            let file_data = $("#file_sub").prop("files")[0];
            let form_data_sub = new FormData();
            form_data_sub.append("id_task", u_val_id_task);
            form_data_sub.append("id_sub_task", u_val_id_sub_task);
            form_data_sub.append("sub_task", u_val_sub_task);
            form_data_sub.append("sub_indicator", u_val_sub_indicator);
            form_data_sub.append("sub_type", u_val_sub_type);
            form_data_sub.append("sub_day", u_val_sub_day);
            form_data_sub.append("jml_sub_day", u_val_jml_sub_day);
            form_data_sub.append("start_date", u_val_start_date);
            form_data_sub.append("end_date", u_val_end_date);
            form_data_sub.append("file_sub", file_data);
            form_data_sub.append("sub_note", u_val_note_sub);
            form_data_sub.append("jam_notif", u_val_jam_notif);
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
                        url: `<?= base_url() ?>monday/update_strategy_sub_task`,
                        type: 'POST',
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data_sub, // Setting the data attribute of ajax with file_data
                        type: 'post',
                        beforeSend: function() {

                        },
                        success: function(response) {},
                        error: function(xhr) {},
                        complete: function() {},
                    }).done(function(response) {
                        if (response.save_sub_task == true) {
                            $('#sub_task').val('');
                            $('#sub_type').val('');
                            $('#start_date').val('');
                            $('#end_date').val('');
                            $('#sub_note').val('');
                            // $('#modal_add_sub_task').modal('hide');
                            $("input[name='sub_type_check']").prop('checked', false);
                            $("input[name='sub_type_day']").prop('checked', false);
                            $("#choose_day_of_weeks").addClass('d-none', false);

                            dt_sub_task_card(response.id_task);
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Success!',
                                    theme: 'material',
                                    type: 'blue',
                                    content: 'Data Saved!',
                                    buttons: {
                                        close: {
                                            actions: function() {}
                                        },
                                    },
                                });
                            }, 250);
                            // setTimeout(() => {
                            //     modal_sub_task(response.id_task);
                            // }, 500);
                        } else {
                            // $('#modal_add_sub_task').modal('hide');
                            modal_sub_task(id_task)
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
    }

    function add_new_strategy() {
        $('#modal_detail_task').modal('hide');
        id_task_new_strategy = $('#id_task_new_strategy').val();
        setTimeout(() => {
            modal_sub_task(id_task_new_strategy);
        }, 250);
    }

    function modal_sub_task(id_task) {
        $('#modal_add_task').modal('hide');
        $('#modal_sub_task').modal('show');
        $('#id_task').val(id_task);
        // dt_sub_task(id_task);
        dt_sub_task_card(id_task);
    }

    function close_sub_task() {
        $('#modal_sub_task').modal('hide');
        $('#modal_add_task').modal('show');
    }

    function dt_sub_task(id_task) {
        $('#dt_sub_task').DataTable({
            "searching": true,
            "info": true,
            "paging": true,
            "destroy": true,
            "order": [
                [1, 'desc']
            ],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "data": {
                    id_task: id_task
                },
                "url": "<?= base_url(); ?>monday/dt_sub_task",
            },
            "columns": [{
                    "data": "sub_task"
                },
                {
                    "data": "sub_type"
                },
                {
                    "data": "periode"
                },
                {
                    "data": "file"
                },
            ],
        });
    }


    function dt_sub_task_card(id_task) {
        user_id_session = '<?= $this->session->userdata('user_id'); ?>'
        $.ajax({
            url: '<?= base_url(); ?>monday/dt_sub_task',
            type: 'POST',
            dataType: 'json',
            data: {
                id_task: id_task
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
            console.log(response);
            dt_sub_task_card_item = '';
            for (let index = 0; index < response.data.length; index++) {
                if (response.data[index].id_type == 1) {
                    r_type_style = ` <div class="avatar avatar-60 rounded bg-light-red text-red">
                                        D
                                    </div>`
                } else if (response.data[index].id_type == 2) {
                    r_type_style = ` <div class="avatar avatar-60 rounded bg-light-blue text-blue">
                                        W
                                    </div>`
                } else if (response.data[index].id_type == 3) {
                    r_type_style = ` <div class="avatar avatar-60 rounded bg-light-yellow text-yellow">
                                        M
                                    </div>`
                } else {
                    r_type_style = ` <div class="avatar avatar-60 rounded bg-light-purple text-purple">
                                        T
                                    </div>`

                }

                opt_jam_notif = `
                            <option value="00:00" ${'00:00'==response.data[index].jam_notif ? 'selected':''}>00:00 WIB</option>
                            <option value="00:15" ${'00:15'==response.data[index].jam_notif ? 'selected':''}>00:15 WIB</option>
                            <option value="00:30" ${'00:30'==response.data[index].jam_notif ? 'selected':''}>00:30 WIB</option>
                            <option value="00:45" ${'00:45'==response.data[index].jam_notif ? 'selected':''}>00:45 WIB</option>
                            <option value="01:00" ${'01:00'==response.data[index].jam_notif ? 'selected':''}>01:00 WIB</option>
                            <option value="01:15" ${'01:15'==response.data[index].jam_notif ? 'selected':''}>01:15 WIB</option>
                            <option value="01:30" ${'01:30'==response.data[index].jam_notif ? 'selected':''}>01:30 WIB</option>
                            <option value="01:45" ${'01:45'==response.data[index].jam_notif ? 'selected':''}>01:45 WIB</option>
                            <option value="02:00" ${'02:00'==response.data[index].jam_notif ? 'selected':''}>02:00 WIB</option>
                            <option value="02:15" ${'02:15'==response.data[index].jam_notif ? 'selected':''}>02:15 WIB</option>
                            <option value="02:30" ${'02:30'==response.data[index].jam_notif ? 'selected':''}>02:30 WIB</option>
                            <option value="02:45" ${'02:45'==response.data[index].jam_notif ? 'selected':''}>02:45 WIB</option>
                            <option value="03:00" ${'03:00'==response.data[index].jam_notif ? 'selected':''}>03:00 WIB</option>
                            <option value="03:15" ${'03:15'==response.data[index].jam_notif ? 'selected':''}>03:15 WIB</option>
                            <option value="03:30" ${'03:30'==response.data[index].jam_notif ? 'selected':''}>03:30 WIB</option>
                            <option value="03:45" ${'03:45'==response.data[index].jam_notif ? 'selected':''}>03:45 WIB</option>
                            <option value="04:00" ${'04:00'==response.data[index].jam_notif ? 'selected':''}>04:00 WIB</option>
                            <option value="04:15" ${'04:15'==response.data[index].jam_notif ? 'selected':''}>04:15 WIB</option>
                            <option value="04:30" ${'04:30'==response.data[index].jam_notif ? 'selected':''}>04:30 WIB</option>
                            <option value="04:45" ${'04:45'==response.data[index].jam_notif ? 'selected':''}>04:45 WIB</option>
                            <option value="05:00" ${'05:00'==response.data[index].jam_notif ? 'selected':''}>05:00 WIB</option>
                            <option value="05:15" ${'05:15'==response.data[index].jam_notif ? 'selected':''}>05:15 WIB</option>
                            <option value="05:30" ${'05:30'==response.data[index].jam_notif ? 'selected':''}>05:30 WIB</option>
                            <option value="05:45" ${'05:45'==response.data[index].jam_notif ? 'selected':''}>05:45 WIB</option>
                            <option value="06:00" ${'06:00'==response.data[index].jam_notif ? 'selected':''}>06:00 WIB</option>
                            <option value="06:15" ${'06:15'==response.data[index].jam_notif ? 'selected':''}>06:15 WIB</option>
                            <option value="06:30" ${'06:30'==response.data[index].jam_notif ? 'selected':''}>06:30 WIB</option>
                            <option value="06:45" ${'06:45'==response.data[index].jam_notif ? 'selected':''}>06:45 WIB</option>
                            <option value="07:00" ${'07:00'==response.data[index].jam_notif ? 'selected':''}>07:00 WIB</option>
                            <option value="07:15" ${'07:15'==response.data[index].jam_notif ? 'selected':''}>07:15 WIB</option>
                            <option value="07:30" ${'07:30'==response.data[index].jam_notif ? 'selected':''}>07:30 WIB</option>
                            <option value="07:45" ${'07:45'==response.data[index].jam_notif ? 'selected':''}>07:45 WIB</option>
                            <option value="08:00" ${'08:00'==response.data[index].jam_notif ? 'selected':''}>08:00 WIB</option>
                            <option value="08:15" ${'08:15'==response.data[index].jam_notif ? 'selected':''}>08:15 WIB</option>
                            <option value="08:30" ${'08:30'==response.data[index].jam_notif ? 'selected':''}>08:30 WIB</option>
                            <option value="08:45" ${'08:45'==response.data[index].jam_notif ? 'selected':''}>08:45 WIB</option>
                            <option value="09:00" ${'09:00'==response.data[index].jam_notif ? 'selected':''}>09:00 WIB</option>
                            <option value="09:15" ${'09:15'==response.data[index].jam_notif ? 'selected':''}>09:15 WIB</option>
                            <option value="09:30" ${'09:30'==response.data[index].jam_notif ? 'selected':''}>09:30 WIB</option>
                            <option value="09:45" ${'09:45'==response.data[index].jam_notif ? 'selected':''}>09:45 WIB</option>
                            <option value="10:00" ${'10:00'==response.data[index].jam_notif ? 'selected':''}>10:00 WIB</option>
                            <option value="10:15" ${'10:15'==response.data[index].jam_notif ? 'selected':''}>10:15 WIB</option>
                            <option value="10:30" ${'10:30'==response.data[index].jam_notif ? 'selected':''}>10:30 WIB</option>
                            <option value="10:45" ${'10:45'==response.data[index].jam_notif ? 'selected':''}>10:45 WIB</option>
                            <option value="11:00" ${'11:00'==response.data[index].jam_notif ? 'selected':''}>11:00 WIB</option>
                            <option value="11:15" ${'11:15'==response.data[index].jam_notif ? 'selected':''}>11:15 WIB</option>
                            <option value="11:30" ${'11:30'==response.data[index].jam_notif ? 'selected':''}>11:30 WIB</option>
                            <option value="11:45" ${'11:45'==response.data[index].jam_notif ? 'selected':''}>11:45 WIB</option>
                            <option value="12:00" ${'12:00'==response.data[index].jam_notif ? 'selected':''}>12:00 WIB</option>
                            <option value="12:15" ${'12:15'==response.data[index].jam_notif ? 'selected':''}>12:15 WIB</option>
                            <option value="12:30" ${'12:30'==response.data[index].jam_notif ? 'selected':''}>12:30 WIB</option>
                            <option value="12:45" ${'12:45'==response.data[index].jam_notif ? 'selected':''}>12:45 WIB</option>
                            <option value="13:00" ${'13:00'==response.data[index].jam_notif ? 'selected':''}>13:00 WIB</option>
                            <option value="13:15" ${'13:15'==response.data[index].jam_notif ? 'selected':''}>13:15 WIB</option>
                            <option value="13:30" ${'13:30'==response.data[index].jam_notif ? 'selected':''}>13:30 WIB</option>
                            <option value="13:45" ${'13:45'==response.data[index].jam_notif ? 'selected':''}>13:45 WIB</option>
                            <option value="14:00" ${'14:00'==response.data[index].jam_notif ? 'selected':''}>14:00 WIB</option>
                            <option value="14:15" ${'14:15'==response.data[index].jam_notif ? 'selected':''}>14:15 WIB</option>
                            <option value="14:30" ${'14:30'==response.data[index].jam_notif ? 'selected':''}>14:30 WIB</option>
                            <option value="14:45" ${'14:45'==response.data[index].jam_notif ? 'selected':''}>14:45 WIB</option>
                            <option value="15:00" ${'15:00'==response.data[index].jam_notif ? 'selected':''}>15:00 WIB</option>
                            <option value="15:15" ${'15:15'==response.data[index].jam_notif ? 'selected':''}>15:15 WIB</option>
                            <option value="15:30" ${'15:30'==response.data[index].jam_notif ? 'selected':''}>15:30 WIB</option>
                            <option value="15:45" ${'15:45'==response.data[index].jam_notif ? 'selected':''}>15:45 WIB</option>
                            <option value="16:00" ${'16:00'==response.data[index].jam_notif ? 'selected':''}>16:00 WIB</option>
                            <option value="16:15" ${'16:15'==response.data[index].jam_notif ? 'selected':''}>16:15 WIB</option>
                            <option value="16:30" ${'16:30'==response.data[index].jam_notif ? 'selected':''}>16:30 WIB</option>
                            <option value="16:45" ${'16:45'==response.data[index].jam_notif ? 'selected':''}>16:45 WIB</option>
                            <option value="17:00" ${'17:00'==response.data[index].jam_notif ? 'selected':''}>17:00 WIB</option>
                            <option value="17:15" ${'17:15'==response.data[index].jam_notif ? 'selected':''}>17:15 WIB</option>
                            <option value="17:30" ${'17:30'==response.data[index].jam_notif ? 'selected':''}>17:30 WIB</option>
                            <option value="17:45" ${'17:45'==response.data[index].jam_notif ? 'selected':''}>17:45 WIB</option>
                            <option value="18:00" ${'18:00'==response.data[index].jam_notif ? 'selected':''}>18:00 WIB</option>
                            <option value="18:15" ${'18:15'==response.data[index].jam_notif ? 'selected':''}>18:15 WIB</option>
                            <option value="18:30" ${'18:30'==response.data[index].jam_notif ? 'selected':''}>18:30 WIB</option>
                            <option value="18:45" ${'18:45'==response.data[index].jam_notif ? 'selected':''}>18:45 WIB</option>
                            <option value="19:00" ${'19:00'==response.data[index].jam_notif ? 'selected':''}>19:00 WIB</option>
                            <option value="19:15" ${'19:15'==response.data[index].jam_notif ? 'selected':''}>19:15 WIB</option>
                            <option value="19:30" ${'19:30'==response.data[index].jam_notif ? 'selected':''}>19:30 WIB</option>
                            <option value="19:45" ${'19:45'==response.data[index].jam_notif ? 'selected':''}>19:45 WIB</option>
                            <option value="20:00" ${'20:00'==response.data[index].jam_notif ? 'selected':''}>20:00 WIB</option>
                            <option value="20:15" ${'20:15'==response.data[index].jam_notif ? 'selected':''}>20:15 WIB</option>
                            <option value="20:30" ${'20:30'==response.data[index].jam_notif ? 'selected':''}>20:30 WIB</option>
                            <option value="20:45" ${'20:45'==response.data[index].jam_notif ? 'selected':''}>20:45 WIB</option>
                            <option value="21:00" ${'21:00'==response.data[index].jam_notif ? 'selected':''}>21:00 WIB</option>
                            <option value="21:15" ${'21:15'==response.data[index].jam_notif ? 'selected':''}>21:15 WIB</option>
                            <option value="21:30" ${'21:30'==response.data[index].jam_notif ? 'selected':''}>21:30 WIB</option>
                            <option value="21:45" ${'21:45'==response.data[index].jam_notif ? 'selected':''}>21:45 WIB</option>
                            <option value="22:00" ${'22:00'==response.data[index].jam_notif ? 'selected':''}>22:00 WIB</option>
                            <option value="22:15" ${'22:15'==response.data[index].jam_notif ? 'selected':''}>22:15 WIB</option>
                            <option value="22:30" ${'22:30'==response.data[index].jam_notif ? 'selected':''}>22:30 WIB</option>
                            <option value="22:45" ${'22:45'==response.data[index].jam_notif ? 'selected':''}>22:45 WIB</option>
                            <option value="23:00" ${'23:00'==response.data[index].jam_notif ? 'selected':''}>23:00 WIB</option>
                            <option value="23:15" ${'23:15'==response.data[index].jam_notif ? 'selected':''}>23:15 WIB</option>
                            <option value="23:30" ${'23:30'==response.data[index].jam_notif ? 'selected':''}>23:30 WIB</option>
                            <option value="23:45" ${'23:45'==response.data[index].jam_notif ? 'selected':''}>23:45 WIB</option>
                            <option value="24:00" ${'24:00'==response.data[index].jam_notif ? 'selected':''}>24:00 WIB</option>
                                `

                array_day_per_week = response.data[index].day_per_week.split(",");
                tombol_edit_hapus = '';
                if (response.data[index].created_by == user_id_session) {
                    tombol_edit_hapus = `<a role="button" class="btn btn-link bg-light-yellow text-yellow" data-bs-toggle="collapse" data-bs-target="#collapse_form_strategy_${response.data[index].id_sub_task}" aria-expanded="false" aria-controls="collapse_form_strategy_${response.data[index].id_sub_task}"><i class="bi bi-pencil-square"></i></a>

<a role="button" class="btn btn-link bg-light-red text-red" onclick="delete_strategy('${response.data[index].id_sub_task}', '${response.data[index].id_task}')"><i class="bi bi-trash"></i></a>`
                }
                console.log(array_day_per_week.includes('0'));
                dt_sub_task_card_item += `<div class="card mt-1 mb-1">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                   ${r_type_style}
                                </div>
                                <div class="col">
                                    <p class="text-secondary small mb-1">${response.data[index].sub_type}</p>
                                    <h4 class="text-dark mb-0"><span class="increamentcount">${response.data[index].sub_task}</span></h4>
                                    <p class="small">${response.data[index].periode}</p>
                                </div>
                                <div class="col-auto">
                                     ${tombol_edit_hapus}
                                </div>
                            </div>
                            <div class="collapse mt-2" id="collapse_form_strategy_${response.data[index].id_sub_task}">
                                <div class="card card-body">
                                    <form id="form-add-sub-task-${response.data[index].id_sub_task}">
                                        <div class="row text-start">
                                            <div class="col-12 col-md-12">
                                                <div class="mb-3">
                                                    <label class="small text-secondary" for="sub_task">Strategy</label>
                                                    <input type="text" name="sub_task" value="${response.data[index].sub_task}" id="sub_task_${response.data[index].id_sub_task}" class="form-control">
                                                    <input type="hidden" name="id_task" value="${response.data[index].id_task}" id="id_task_${response.data[index].id_sub_task}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <div class="mb-3">
                                                    <label class="small text-secondary" for="indicator">Indicator</label>
                                                    <textarea name="sub_indicator_${response.data[index].id_sub_task}" id="sub_indicator_${response.data[index].id_sub_task}" cols="30" rows="5">${response.data[index].indicator}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <div class="mb-3">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="small text-secondary">Type</label><br>
                                                                <div class="row col-12 mt-2 mb-2">
                                                                    <div class="col-4 col-md-12">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" ${response.data[index].id_type == 1 ? 'checked':''} id="flexSwitc1_${response.data[index].id_sub_task}" name="sub_type_check_${response.data[index].id_sub_task}" value="1" style="cursor: pointer;">
                                                                            <label class="form-check-label" for="flexSwitc1" style="cursor: pointer;">Daily</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4 col-md-12">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" ${response.data[index].id_type == 2 ? 'checked':''} id="flexSwitc2_${response.data[index].id_sub_task}" name="sub_type_check_${response.data[index].id_sub_task}" value="2" style="cursor: pointer;">
                                                                            <label class="form-check-label" for="flexSwitc2" style="cursor: pointer;">Weekly</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4 col-md-12">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" ${response.data[index].id_type == 3 ? 'checked':''} id="flexSwitc3_${response.data[index].id_sub_task}" name="sub_type_check_${response.data[index].id_sub_task}" value="3" style="cursor: pointer;">
                                                                            <label class="form-check-label" for="flexSwitc3" style="cursor: pointer;">Monthly</label>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="sub_type" value="${response.data[index].id_type}" id="sub_type_${response.data[index].id_sub_task}" readonly>
                                                                    <input type="hidden" name="sub_day" value="${response.data[index].day_per_week}" id="sub_day_${response.data[index].id_sub_task}" readonly>
                                                                    <input type="hidden" name="jml_sub_day" value="${array_day_per_week.length}" id="jml_sub_day_${response.data[index].id_sub_task}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 ${response.data[index].id_type == 2 ? '':'d-none'}" id="choose_day_of_weeks_${response.data[index].id_sub_task}">
                                                            <label class="small text-secondary">Choose Day of Weeks</label>
                                                            <div class="row col-12 mt-2 mb-2">
                                                                <div class="col-6">
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox" ${array_day_per_week.includes('0') == true ? 'checked':''} id="flexSwitcDay1_${response.data[index].id_sub_task}" name="sub_type_day_${response.data[index].id_sub_task}" value="0" style="cursor: pointer;">
                                                                        <label class="form-check-label" for="flexSwitcDay1" style="cursor: pointer;">Monday</label>
                                                                    </div>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox" ${array_day_per_week.includes('1') == true ? 'checked':''} id="flexSwitcDay2_${response.data[index].id_sub_task}" name="sub_type_day_${response.data[index].id_sub_task}" value="1" style="cursor: pointer;">
                                                                        <label class="form-check-label" for="flexSwitcDay2" style="cursor: pointer;">Tuesday</label>
                                                                    </div>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox" ${array_day_per_week.includes('2') == true ? 'checked':''} id="flexSwitcDay3_${response.data[index].id_sub_task}" name="sub_type_day_${response.data[index].id_sub_task}" value="2" style="cursor: pointer;">
                                                                        <label class="form-check-label" for="flexSwitcDay3" style="cursor: pointer;">Wednesday</label>
                                                                    </div>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox" ${array_day_per_week.includes('3') == true ? 'checked':''} id="flexSwitcDay4_${response.data[index].id_sub_task}" name="sub_type_day_${response.data[index].id_sub_task}" value="3" style="cursor: pointer;">
                                                                        <label class="form-check-label" for="flexSwitcDay4" style="cursor: pointer;">Thrusday</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox" ${array_day_per_week.includes('4') == true ? 'checked':''} id="flexSwitcDay5_${response.data[index].id_sub_task}" name="sub_type_day_${response.data[index].id_sub_task}" value="4" style="cursor: pointer;">
                                                                        <label class="form-check-label" for="flexSwitcDay5" style="cursor: pointer;">Friday</label>
                                                                    </div>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox" ${array_day_per_week.includes('5') == true ? 'checked':''} id="flexSwitcDay6_${response.data[index].id_sub_task}" name="sub_type_day_${response.data[index].id_sub_task}" value="5" style="cursor: pointer;">
                                                                        <label class="form-check-label" for="flexSwitcDay6" style="cursor: pointer;">Saturday</label>
                                                                    </div>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox" ${array_day_per_week.includes('6') == true ? 'checked':''} id="flexSwitcDay7_${response.data[index].id_sub_task}" name="sub_type_day_${response.data[index].id_sub_task}" value="6" style="cursor: pointer;">
                                                                        <label class="form-check-label" for="flexSwitcDay7" style="cursor: pointer;">Sunday</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <div class="mb-3">
                                                    <label class="small text-secondary" for="">Start Date</label>
                                                    <input type="text" name="start_date" value="${response.data[index].start}" id="start_date_${response.data[index].id_sub_task}" onchange="set_min_date_update('${response.data[index].id_sub_task}')" class="form-control tanggal" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <div class="mb-3">
                                                    <label class="small text-secondary" for="">End Date</label>
                                                    <input type="text" name="end_date" value="${response.data[index].end}" id="end_date_${response.data[index].id_sub_task}" class="form-control tanggal" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <div class="mb-3">
                                                    <label class="small text-secondary" for="">Notification Hour</label>
                                                    <select name="jam_notif" id="jam_notif_${response.data[index].id_sub_task}" class="form-control">
                                                        ${opt_jam_notif}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 d-none">
                                                <div class="mb-3">
                                                    <label class="small text-secondary" for="">File</label>
                                                    <input type="file" name="file_sub" id="file_sub_${response.data[index].id_sub_task}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <div class="mb-3">
                                                    <label class="small text-secondary" for="sub_note">Note</label>
                                                    <textarea name="sub_note" id="sub_note_${response.data[index].id_sub_task}" class="form-control" cols="30" rows="2">${response.data[index].note}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 text-end">
                                                <button type="button" class="btn btn-theme text-white m-1" onclick="update_strategy_sub_task('${response.data[index].id_sub_task}')">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>`;

            }
            $('#dt_sub_task_card').empty().append(dt_sub_task_card_item);
            setTimeout(() => {
                for (let index = 0; index < response.data.length; index++) {

                    if (response.data[index].id_type == 2 || response.data[index].id_type == 3) {
                        $(`#choose_day_of_weeks_${response.data[index].id_sub_task}`).removeClass('d-none')
                    } else {
                        $(`#choose_day_of_weeks_${response.data[index].id_sub_task}`).addClass('d-none')
                    }
                    $(`input[name='sub_type_day_${response.data[index].id_sub_task}']`).on('click', function() {
                        let sub_day = $(`input[name='sub_type_day_${response.data[index].id_sub_task}']:checked`).map(function() {
                            return $(this).val();
                        }).get();
                        let count_sub_day = $(`input[name='sub_type_day_${response.data[index].id_sub_task}']:checked`).length;
                        $(`#sub_day_${response.data[index].id_sub_task}`).val(sub_day)
                        $(`#jml_sub_day_${response.data[index].id_sub_task}`).val(count_sub_day)
                    });

                    $(`input[name='sub_type_check_${response.data[index].id_sub_task}']`).on('click', function() {
                        var $box_sub_type_check = $(this);
                        box_sub_type_check = $box_sub_type_check.val();
                        if (box_sub_type_check == 2 || box_sub_type_check == 3) {
                            $(`#choose_day_of_weeks_${response.data[index].id_sub_task}`).removeClass('d-none')
                        } else {
                            $(`#choose_day_of_weeks_${response.data[index].id_sub_task}`).addClass('d-none')
                        }
                    });
                    $(`input[name='sub_type_check_${response.data[index].id_sub_task}']`).on('click', function() {
                        // in the handler, 'this' refers to the box clicked on
                        var $box = $(this);

                        valu = $box.val();
                        $(`#sub_type_${response.data[index].id_sub_task}`).val(valu);
                        if ($box.is(":checked")) {
                            // the name of the box is retrieved using the .attr() method
                            // as it is assumed and expected to be immutable
                            var group = "input:checkbox[name='" + $box.attr("name") + "']";
                            // the checked state of the group/box on the other hand will change
                            // and the current value is retrieved using .prop() method
                            $(group).prop("checked", false);
                            $box.prop("checked", true);
                        } else {
                            $box.prop("checked", false);
                        }
                    });

                    $('#start_date_' + response.data[index].id_sub_task).datetimepicker({
                        format: 'Y-m-d',
                        timepicker: false,
                        minDate: 0,
                        scrollMonth: false,
                        scrollInput: false

                    });

                    min_date = $('#start_date_' + response.data[index].id_sub_task).val();

                    $('#end_date_' + response.data[index].id_sub_task).datetimepicker({
                        format: 'Y-m-d',
                        timepicker: false,
                        minDate: min_date,
                        scrollMonth: false,
                        scrollInput: false

                    });

                    $('#sub_indicator_' + response.data[index].id_sub_task).summernote({
                        placeholder: 'Indicator',
                        tabsize: 2,
                        height: 150,
                        toolbar: [
                            ['font', ['bold', 'underline', 'clear']],
                            ['para', ['ul', 'ol', 'paragraph']],
                        ]
                    });
                }
            }, 250);
        }).fail(function(jqXhr, textStatus) {

        });
    }


    $("input[name='sub_type_indicator']").on('click', function() {
        var $box_sub_type_indicator = $(this);
        box_sub_type_indicator = $box_sub_type_indicator.val();
        if ($box_sub_type_indicator.is(":checked")) {
            $('#div_indicator').removeClass('d-none')

        } else {
            $('#div_indicator').addClass('d-none')

        }
    });

    $("input[name='sub_type_day']").on('click', function() {
        let sub_day = $("input[name='sub_type_day']:checked").map(function() {
            return $(this).val();
        }).get();
        let count_sub_day = $("input[name='sub_type_day']:checked").length;
        $('#sub_day').val(sub_day)
        $('#jml_sub_day').val(count_sub_day)
    });
    $("input[name='sub_type_check']").on('click', function() {
        var $box_sub_type_check = $(this);
        box_sub_type_check = $box_sub_type_check.val();
        if (box_sub_type_check == 2 || box_sub_type_check == 3) {
            $('#choose_day_of_weeks').removeClass('d-none')
        } else {
            $('#choose_day_of_weeks').addClass('d-none')
        }
    });
    $("input[name='sub_type_check']").on('click', function() {
        // in the handler, 'this' refers to the box clicked on
        var $box = $(this);

        valu = $box.val();
        $('#sub_type').val(valu);
        if ($box.is(":checked")) {
            // the name of the box is retrieved using the .attr() method
            // as it is assumed and expected to be immutable
            var group = "input:checkbox[name='" + $box.attr("name") + "']";
            // the checked state of the group/box on the other hand will change
            // and the current value is retrieved using .prop() method
            $(group).prop("checked", false);
            $box.prop("checked", true);
        } else {
            $box.prop("checked", false);
        }
    });

    $('#modal_detail_task').on('hidden.bs.modal', function() {
        // do something…
        page_uri = "<?= $this->uri->segment(1); ?>";
        if (page_uri == "kanban") {
            kanban_data();
        }

    })

    function detail_task(id_task) {

        $('#id_task_new_strategy').val(id_task)
        $.confirm({
            icon: 'fa fa-spinner fa-spin',
            title: 'Please wait..',
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
                    url: `<?= base_url() ?>monday/get_detail_task`,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id_task: id_task
                    },
                    beforeSend: function() {

                    },
                    success: function(response) {},
                    error: function(xhr) {},
                    complete: function() {},
                }).done(function(response) {
                    // console.log(response.status)
                    // console.log(response.detail)
                    if (response.status == true) {
                        setTimeout(() => {
                            jconfirm.instances[0].close();
                            $('#modal_detail_task').modal('show');
                            show_detail(id_task)
                            dt_detail_sub_task(id_task);
                            get_timeline(id_task);
                            $('#modal_detail_taskLabel').text(response.detail.task);

                            // $('#start_timeline').val(response.detail.start);
                            // $('#end_timeline').val(response.detail.end);
                            if (response.detail.id_type == 2) {
                                $('#div_e_note').addClass('d-none');
                            } else {
                                $('#div_e_note').removeClass('d-none');
                            }
                            // $('#e_note').text(response.detail.note);
                            $('#e_note').val('');
                            $('#e_evaluation').val('');
                            e_evaluation = $('#e_evaluation').val();
                            console.log(e_evaluation)
                            $('#e_progress').val(response.detail.progress);
                            // console.log(Math.round(response.detail.progress * 100) / 100)

                            $('#e_valuation').text(response.detail.evaluation);

                            $('#e_id_task').val(response.detail.id_task);
                            $('#e_task').val(response.detail.task);
                            $('#e_task_text').text(response.detail.task);

                            $('#e_description_div').html(response.detail.description);
                            $('#e_indicator_div').html(response.detail.indicator);
                            $('#e_strategy_div').html(response.detail.strategy);

                            // priority
                            if (response.detail.id_priority == 1) {
                                prior_class = ` bg-light-blue text-blue`
                            } else if (response.detail.id_priority == 2) {
                                prior_class = `bg-light-purple text-purple`
                            } else if (response.detail.id_priority == 3) {
                                prior_class = `bg-light-cyan text-cyan`
                            } else if (response.detail.id_priority == 3) {
                                prior_class = `bg-light-cyan text-cyan`
                            } else if (response.detail.id_priority == 4) {
                                prior_class = `bg-light-green text-green`
                            } else {
                                prior_class = `bg-light text-light`
                            }
                            $('#e_priority_text').addClass(prior_class);
                            $('#e_priority_text').text(response.detail.priority);
                            if (response.detail.jenis_strategy == "Once") {
                                jenis_strategy_class = ` bg-light-green text-green`
                            } else {
                                jenis_strategy_class = `bg-light-red text-red`
                            }
                            $('#e_jenis_strategy_text').addClass(jenis_strategy_class);
                            $('#e_jenis_strategy_text').text(response.detail.jenis_strategy);

                            due_div_el = `
                                    <span class="btn btn-sm btn-link ${response.detail.due_date_style} ${response.detail.due_date_style_text}"><i class="text-theme bi bi-calendar-date"></i> ${response.detail.due_date}</span>
                                    <span class="btn btn-sm btn-link ${response.detail.due_date_style} ${response.detail.due_date_style_text}"><i class="bi bi-clock-history"></i> ${response.detail.due_date_text}</span>
                                    `
                            $('#e_due_date_div').html(due_div_el);
                            $('#e_pic_text').text(response.detail.team_name);
                            $('#e_id_status').val(response.detail.id_status);
                            if (response.detail.id_status > 1) {
                                $('#e_id_status option[value="' + 1 + '"]').attr("disabled", true);
                                $('#e_id_status option[value="' + 3 + '"]').attr("disabled", false);
                            } else if (response.detail.id_status == 1) {
                                $('#e_id_status').val(2);
                                $('#e_id_status option[value="' + 3 + '"]').attr("disabled", true);
                            }
                            e_sel_id_status.update();

                            page_uri = "<?= $this->uri->segment(1); ?>";
                            if (page_uri == "kanban") {
                                detail_status_after = $('#detail_status_after').val();
                                if (detail_status_after != "") {
                                    $('#e_id_status').val(detail_status_after);
                                    if (detail_status_after > 1) {
                                        $('#e_id_status option[value="' + 1 + '"]').attr("disabled", true);
                                    }
                                    e_sel_id_status.update();
                                }
                            }

                        }, 250);
                        // setTimeout(() => {
                        //     jconfirm.instances[0].close();
                        // }, 750);
                    } else {
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

    function get_timeline(id_task) {
        $.ajax({
            url: '<?= base_url() ?>monday/get_timeline',
            type: 'POST',
            dataType: 'json',
            data: {
                id_task: id_task
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
            $('#start_timeline').val(response.start_timeline)
            $('#end_timeline').val(response.end_timeline)
        }).fail(function(jqXhr, textStatus) {

        });
    }


    function delete_strategy(id_sub_task, id_task) {
        $.confirm({
            buttons: {
                close: function() {},
                heyThere: {
                    text: 'Yes, Delete!', // With spaces and symbols
                    action: function() {
                        $.ajax({
                            url: '<?= base_url() ?>monday/delete_strategy',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                id_sub_task: id_sub_task
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
                            if (response.delete == true) {
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
                            } else {
                                $.confirm({
                                    icon: 'fa fa-close',
                                    title: 'Oops!',
                                    theme: 'material',
                                    type: 'red',
                                    content: 'Oops, something wrong',
                                    buttons: {
                                        close: {
                                            actions: function() {}
                                        },
                                    },
                                });
                            }

                            setTimeout(() => {
                                dt_sub_task_card(id_task);
                            }, 250);

                        }).fail(function(jqXhr, textStatus) {

                        });
                    }
                }
            }
        });
    }


    function update_task() {
        let val_e_id_task = $('#e_id_task').val();
        let val_e_id_status = $('#e_id_status').val();
        let val_e_progress = $('#e_progress').val();
        let val_e_evaluation = $('#e_evaluation').val();
        let val_e_note = $('#e_note').val();
        let val_e_start_timeline = $('#start_timeline').val();
        let val_e_end_timeline = $('#end_timeline').val();


        if (val_e_id_task == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, id task not found',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_e_id_status == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, status must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_e_start_timeline == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, timeline must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_e_end_timeline == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, timeline must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_e_progress == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, progress must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_e_id_status == 3 && val_e_evaluation == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, evaluation must be filled if status is done',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else {
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
                        url: `<?= base_url() ?>monday/update_task`,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id_task: val_e_id_task,
                            id_status: val_e_id_status,
                            progress: val_e_progress,
                            evaluation: val_e_evaluation,
                            note: val_e_note,
                            start: val_e_start_timeline,
                            end: val_e_end_timeline,
                        },
                        beforeSend: function() {

                        },
                        success: function(response) {},
                        error: function(xhr) {},
                        complete: function() {},
                    }).done(function(response) {
                        if (response == true) {
                            $('#modal_detail_task').modal('hide');
                            segment_uri = "<?= $this->uri->segment(1); ?>";
                            if (segment_uri == "monday") {
                                dt_task();
                            } else {
                                kanban_data();
                            }
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
                        } else {
                            $('#modal_detail_task').modal('hide');
                            dt_task();
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

    }
</script>