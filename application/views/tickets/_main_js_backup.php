<!-- <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery.autocomplete.js"></script> -->
<script type="text/javascript" src="<?= base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/dragula/dragula.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/dropzone5-9-3/dropzone.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/paging.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/progressbar-js/progressbar.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/slimselect/slimselect.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/footable/footable.min.js"></script>
<!-- <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script> -->
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<!-- script state awal -->
<script>
    var user_role_id = "<?= $this->session->userdata('user_id'); ?>"
    var user_id = "<?= $this->session->userdata('user_id'); ?>"
    $(document).ready(function() {
        // global uri
        uri_segment_view = "<?= $this->uri->segment(4); ?>";

        console.log(uri_segment_view);

        $('.tanggal').datetimepicker({
            format: 'Y-m-d',
            timepicker: false,
            scrollMonth: false,
            scrollInput: false,
            minDate: 0

        });

        $('.tanggal-menit').datetimepicker({
            format: 'Y-m-d H:i:s',
            timepicker: true,
            scrollMonth: false,
            scrollInput: false,
            minDate: 0

        });

        $(".tanggal").mask('0000-00-00');


        //Datepicker
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));
            $('#start').val(start.format('YYYY-MM-DD'));
            $('#end').val(end.format('YYYY-MM-DD'));
            if (uri_segment_view == "table") {
                dt_tickets();
            } else if (uri_segment_view == "kanban") {
                kanban_data();
            }
            generate_progress_bar()
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
</script>
<!-- /script state awal -->


<!-- generate progress -->
<script>
    function generate_progress_bar() {
        start = $('#start').val()
        end = $('#end').val()
        type = $('#filter_type').val()
        pic = $('#filter_pic').val()
        $.ajax({
            url: '<?= base_url() ?>tickets/main/generate_progress_bar',
            type: 'POST',
            dataType: 'json',
            data: {
                start: start,
                end: end,
                type: type,
                pic: pic,
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
            not_started = parseInt(response.data.not_started);
            working_on = parseInt(response.data.working_on);
            done = parseInt(response.data.done);
            stuck = parseInt(response.data.cancel);
            grand_total = not_started + working_on + done + stuck;
            bar_not_started = (not_started / grand_total) * 100;
            bar_working_on = (working_on / grand_total) * 100;
            bar_done = (done / grand_total) * 100;
            bar_stuck = (stuck / grand_total) * 100;

            $("#total_team_solver").html(response.team_solver.total_solver + " People")
            $("#task_in_progress").html(response.data.working_on + " - " + response.lt_progress.lt_hour + " hrs")
            $("#total_done").html(response.data.done + "")
            $("#total_late").html(response.lt_late.late + " - " + response.lt_late.persen_late + "%")
            $("#total_task_card").html(response.data.total_task)

            $('#progres_bar_not_started').css('width', `${bar_not_started==0?1:bar_not_started}%`)
            $('#progres_bar_working_on').css('width', `${bar_working_on==0?1:bar_working_on}%`)
            $('#progres_bar_done').css('width', `${bar_done==0?1:bar_done}%`)
            $('#progres_bar_stuck').css('width', `${bar_stuck==0?1:bar_stuck}%`)


            tippy('#progres_bar_not_started', {
                content: `Not Started / ${not_started}`,
                placement: 'top',
                animation: 'scale',
                theme: 'material',
            });
            tippy('#progres_bar_working_on', {
                content: `Working On / ${working_on}`,
                placement: 'top',
                animation: 'scale',
                theme: 'material',
            });
            tippy('#progres_bar_done', {
                content: `Done / ${done}`,
                placement: 'top',
                animation: 'scale',
                theme: 'material',
            });
            tippy('#progres_bar_stuck', {
                content: `Cancel / ${stuck}`,
                placement: 'top',
                animation: 'scale',
                theme: 'material',
            });
        }).fail(function(jqXhr, textStatus) {

        });
    }
</script>
<!-- /generate progress -->



<!-- add new task -->
<script>
    function add_new_task() {
        $('#modal_add_task').modal('show');
        $('#task').val('');
        $('#file_ticket').val('');
        $('#description').val('');
        sel_id_pic.setData({
            value: '',
            text: ''
        });
        get_type();
        get_category();
        get_object();
    }
</script>
<!-- /add new task -->


<!-- Description Sumernote -->
<script>
    $('#description').summernote({
        placeholder: 'Tickets Description',
        tabsize: 2,
        height: 120,
        toolbar: [
            ['font', ['bold', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
        ]
    });

    let sum_e_comment = $('#e_comment').summernote({
        placeholder: 'Input here...',
        tabsize: 2,
        height: 100,
        toolbar: false
    });
    sum_e_comment.summernote('code', '');
</script>
<!-- /Description Sumernote -->






<!-- Type Filter -->
<script>
    let sel_filter_type = NiceSelect.bind(document.getElementById('filter_type'), {
        searchable: true
    });

    get_filter_type()

    function get_filter_type() {
        $.ajax({
            url: '<?= base_url() ?>tickets/main/get_type',
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
            list_type = '';
            list_type += '<option value="all" selected>All Type</option>';
            for (let index = 0; index < response.length; index++) {
                list_type += `<option value="${response[index].id_type}">${response[index].type}</option>`;
            }
            $("#filter_type").empty().append(list_type)
            sel_filter_type.update();
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }

    let filter_type_element = document.getElementById("filter_type");
    filter_type_element.addEventListener("change", function() {
        if (uri_segment_view == "table") {
            dt_tickets();
        } else if (uri_segment_view == "kanban") {
            kanban_data();
        }
        generate_progress_bar()
    });
</script>

<!-- /Type Filter -->


<!-- Filter Pic -->
<script>
    let sel_filter_pic = NiceSelect.bind(document.getElementById('filter_pic'), {
        searchable: true
    });


    get_filter_pic()

    function get_filter_pic() {
        $.ajax({
            url: '<?= base_url() ?>tickets/main/get_pic_ticket',
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
            list_pic_ticket = '';
            list_pic_ticket += '<option value="all">All Tickets</option>';
            list_pic_ticket += '<option value="<?= $this->session->userdata('user_id'); ?>" selected>My Tickets</option>';
            for (let index = 0; index < response.length; index++) {
                list_pic_ticket += `<option value="${response[index].id_pic}">${response[index].pic}</option>`;
            }
            $("#filter_pic").empty().append(list_pic_ticket)
            sel_filter_pic.update();
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get PIC Ticket")
        });
    }


    let filter_pic_element = document.getElementById("filter_pic");
    filter_pic_element.addEventListener("change", function() {
        if (uri_segment_view == "table") {
            dt_tickets();
        } else if (uri_segment_view == "kanban") {
            kanban_data();
        }
        generate_progress_bar()
    });
</script>
<!-- /Filter Pic -->

<!-- Filter Pic -->
<!-- <script>
    let sel_filter_pic = NiceSelect.bind(document.getElementById('filter_pic'), {
        searchable: true
    });

    let filter_pic_element = document.getElementById("filter_pic");
    filter_pic_element.addEventListener("change", function() {
        if (uri_segment_view == "table") {
            dt_tickets();
        } else if (uri_segment_view == "kanban") {
            kanban_data();
        }
        generate_progress_bar()
    });
</script> -->
<!-- /Filter Pic -->


<!-- Type Start -->
<script>
    let sel_id_type = NiceSelect.bind(document.getElementById('id_type'), {
        searchable: true
    });


    get_type()

    function get_type() {
        $.ajax({
            url: '<?= base_url() ?>tickets/main/get_type',
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
            list_type = '<option value="">Choose Type</option>';
            for (let index = 0; index < response.length; index++) {
                list_type += `<option value="${response[index].id_type}">${response[index].type}</option>`;
            }
            if (user_role_id == 1) {
                // list_type += '<option value="add_new">+ Add Type</option>';
            }
            $("#id_type").empty().append(list_type)
            sel_id_type.update();
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }

    let type_element = document.getElementById("id_type");
    type_element.addEventListener("change", function() {
        let current_date = new Date();
        current_hour = current_date.getHours();
        console.log(current_hour);

        if (type_element.value == "add_new") {
            add_new_type();
        } else if (type_element.value == "") {

        } else {
            id_type = $('#id_type').val();
            id_category = $('#id_category').val();

            $.ajax({
                url: '<?= base_url() ?>tickets/main/get_category_by_type',
                type: 'POST',
                dataType: 'json',
                data: {
                    id_type: id_type
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
                // list_category = '';
                list_category = '<option value="">Choose category</option>';
                if (response != null) {
                    let disabled_opt_type = '';
                    let disabled_opt_text = '';

                    for (let index = 0; index < response.length; index++) {
                        if (parseInt(current_hour) > 17) {
                            $('#alert-div').removeClass('d-none');
                            if (['2', '3', '6'].includes(response[index].id_category)) {
                                disabled_opt_type = '';
                                disabled_opt_text = '';
                            } else {
                                disabled_opt_type = 'disabled';
                                disabled_opt_text = '(Maaf diluar Jam Kerja)';
                            }
                        }
                        list_category += `<option value="${response[index].id_category}" data-id_category="${response[index].id_category}" data-id_type="${response[index].id_type}" ${disabled_opt_type}>${response[index].category} ${disabled_opt_text}</option>`;
                    }
                }
                if (user_role_id == 1) {
                    // list_category += '<option value="add_new">+ Add category</option>';
                }
                $("#id_category").empty().append(list_category).prop('disabled', false);
                sel_id_category.update()
            }).fail(function(jqXhr, textStatus) {
                console.log("Failed Get Type")
            });

            $.ajax({
                url: '<?= base_url() ?>tickets/main/get_object_by_type',
                type: 'POST',
                dataType: 'json',
                data: {
                    id_type: id_type,
                    id_category: id_category
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
                        list_object += `<option value="${response[index].id_object}" data-id_category="${response[index].id_category}" data-id_type="${response[index].id_type}">${response[index].object}</option>`;
                    }
                }
                if (user_role_id == 1) {
                    // list_object += '<option value="add_new">+ Add Object</option>';
                }
                $("#id_object").empty().append(list_object).prop('disabled', false);
                sel_id_object.update()
            }).fail(function(jqXhr, textStatus) {
                console.log("Failed Get Type")
            });
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
                        url: `<?= base_url() ?>tickets/main/save_type`,
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
</script>
<!-- Type End -->


<!-- Category Start -->
<script>
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
            url: '<?= base_url() ?>tickets/main/get_category',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {
                $('#id_category').empty().append('<option value=""><i class="fa fa-spinner fa-spin"></i> Loading..</option>');
                sel_id_category.update()
            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            list_category = '<option value="">Choose Category</option>';
            for (let index = 0; index < response.length; index++) {
                list_category += `<option value="${response[index].id_category}" data-id_type="${response[index].id_type}">${response[index].category}</option>`;
            }
            if (user_role_id == 1) {
                // list_category += '<option value="add_new">+ Add Category</option>';
            }
            $("#id_category").empty().append(list_category);
            sel_id_category.update()
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Category")
        });
    }

    let category_element = document.getElementById("id_category");
    category_element.addEventListener("change", function() {
        if (category_element.value == "add_new") {
            add_new_category();
        } else if (category_element.value == "") {

        } else {
            id_type = $('#id_type').val();
            id_category = $('#id_category').val();
            id_type_selected = $("#id_category").find("option:selected").attr('data-id_type') ?? '';
            id_object_type_selected = $("#id_object").find("option:selected").attr('data-id_type') ?? '';
            $('#id_type').val(id_type_selected);
            sel_id_type.update();
            console.log(id_object_type_selected)
            console.log(id_type_selected)
            if (id_object_type_selected != id_type_selected) {
                $.ajax({
                    url: '<?= base_url() ?>tickets/main/get_object_by_type',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id_type: id_type_selected
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
                            list_object += `<option value="${response[index].id_object}" data-id_category="${response[index].id_category}" data-id_type="${response[index].id_type}">${response[index].object}</option>`;
                        }
                    }
                    if (user_role_id == 1) {
                        // list_object += '<option value="add_new">+ Add Object</option>';
                    }
                    $("#id_object").empty().append(list_object).prop('disabled', false);
                    sel_id_object.update()
                }).fail(function(jqXhr, textStatus) {
                    console.log("Failed Get Type")
                });
            }
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
                        url: `<?= base_url() ?>tickets/main/save_category`,
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
</script>
<!-- Category End -->


<!-- Object Start -->
<script>
    let sel_id_object = NiceSelect.bind(document.getElementById('id_object'), {
        searchable: true
    });

    function get_object() {
        let id_category_selected = "";
        id_category_selected = $('#id_category').val() ?? "";
        $.ajax({
            url: '<?= base_url() ?>tickets/main/get_object',
            type: 'POST',
            dataType: 'json',
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
                    list_object += `<option value="${response[index].id_object}" data-id_category="${response[index].id_category}" data-id_type="${response[index].id_type}">${response[index].object}</option>`;
                }
            }
            if (user_role_id == 1) {
                // list_object += '<option value="add_new">+ Add Object</option>';
            }
            $("#id_object").empty().append(list_object).prop('disabled', false);
            sel_id_object.update()
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }

    let object_element = document.getElementById("id_object");
    object_element.addEventListener("change", function(event) {
        console.log(object_element.value)
        if (object_element.value == "add_new") {
            add_new_object();
        } else if (object_element.value == "") {

        } else {
            id_type_selected = $("#id_object").find("option:selected").attr('data-id_type');
            id_category_selected = $("#id_object").find("option:selected").attr('data-id_category');
            console.log(id_type_selected)
            console.log(id_category_selected)
            if (id_type_selected != "") {
                $("#id_type").val(id_type_selected);
            }
            if (id_category_selected != "") {
                $("#id_category").val(id_category_selected);
            }
            // $("#id_priority").val(4); // priority low
            sel_id_type.update();
            sel_id_category.update();
            // sel_id_priority.update();
            get_pic(id_type_selected);
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
                        url: `<?= base_url() ?>tickets/main/save_object`,
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
</script>
<!-- Object End -->



<!-- Requester Start -->
<script>
    let sel_id_requester = NiceSelect.bind(document.getElementById('id_requester'), {
        searchable: true
    });

    get_requester();

    function get_requester() {
        let user_id = "<?= $this->session->userdata('user_id'); ?>";
        let designation_id = "<?= $this->session->userdata('designation_id'); ?>";
        $.ajax({
            url: '<?= base_url() ?>tickets/main/get_requester',
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
            array_list_requester = [];
            // console.log(response);
            list_requester = '<option value="">Choose Priority</option>';
            for (let index = 0; index < response.length; index++) {
                list_requester += `<option value="${response[index].id_requester}">${response[index].requester}</option>`;
            }
            $("#id_requester").empty().append(list_requester);
            $("#id_requester").val(user_id);
            let array_designation_id = ["307", "308", "309", "886", "1167", "405", "459", "570", "984"];
            console.log(designation_id)
            if (array_designation_id.includes(designation_id)) {
                console.log('true')
                $('#div_id_requester').removeClass('d-none');
            } else {
                console.log('false')
                $('#div_id_requester').addClass('d-none');
            }
            sel_id_requester.update();
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Requester")
        });
    }
</script>
<!-- /Requester End -->

<!-- PIC Start -->
<script>
    let sel_id_pic = new SlimSelect({
        select: '#id_pic'
    });


    function get_pic(id_type) {
        $.ajax({
            url: '<?= base_url() ?>tickets/main/get_pic',
            type: 'POST',
            dataType: 'json',
            data: {
                id_type: id_type
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
            array_list_pic = [];
            for (let index = 0; index < response.length; index++) {
                array_list_pic.push({
                    text: response[index].pic,
                    value: response[index].id_pic
                })
            }
            sel_id_pic.setData(array_list_pic);
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }

    let e_sel_id_pic = new SlimSelect({
        select: '#e_id_pic'
    });

    function e_get_pic(e_id_type) {
        $.ajax({
            url: '<?= base_url() ?>tickets/main/get_pic',
            type: 'POST',
            dataType: 'json',
            data: {
                id_type: e_id_type
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
            // console.log(response);
            user_id = "<?= $this->session->userdata('user_id'); ?>"
            // list_pic = `<option value="${user_id}">My Self</option>`;
            e_array_list_pic = [];
            for (let index = 0; index < response.length; index++) {
                e_array_list_pic.push({
                    text: response[index].pic,
                    value: response[index].id_pic
                })
                // list_pic += `<option value="${response[index].id_pic}">${response[index].pic}</option>`;
            }
            // $("#id_pic").empty().append(list_pic);
            e_sel_id_pic.setData(e_array_list_pic);
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }
</script>
<!-- PIC End -->



<!-- Priority Start -->
<script>
    let sel_id_priority = NiceSelect.bind(document.getElementById('id_priority'), {
        searchable: true
    });

    get_priority()

    function get_priority() {
        $.ajax({
            url: '<?= base_url() ?>tickets/main/get_priority',
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
            list_priority = '<option value="">Choose Priority</option>';
            for (let index = 0; index < response.length; index++) {
                list_priority += `<option value="${response[index].id_priority}">${response[index].priority}</option>`;
            }
            $("#id_priority").empty().append(list_priority);
            $("#id_priority").val(4)
            sel_id_priority.update();
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }


    let e_sel_id_priority = NiceSelect.bind(document.getElementById('e_id_priority'), {
        searchable: false
    });

    e_get_priority()

    function e_get_priority() {
        $.ajax({
            url: '<?= base_url() ?>tickets/main/get_priority',
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
            list_priority = '<option value="">Choose Priority</option>';
            for (let index = 0; index < response.length; index++) {
                list_priority += `<option value="${response[index].id_priority}">${response[index].priority}</option>`;
            }
            $("#e_id_priority").empty().append(list_priority)
            e_sel_id_priority.update();
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }
</script>
<!-- Priority End -->


<!-- Level Start -->
<script>
    let e_sel_id_level = NiceSelect.bind(document.getElementById('e_id_level'), {
        searchable: false
    });

    e_get_level()

    function e_get_level() {
        $.ajax({
            url: '<?= base_url() ?>tickets/main/get_level',
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
            list_level = '<option value="">Choose level</option>';
            for (let index = 0; index < response.length; index++) {
                list_level += `<option value="${response[index].id_level}">${response[index].level}</option>`;
            }
            $("#e_id_level").empty().append(list_level)
            e_sel_id_level.update();
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }
</script>
<!-- Level End -->


<!-- Task Start -->
<script>
    function save_task() {
        jam_server = "<?= date("H:i") ?>";
        console.log(jam_server);
        page_uri = '<?= $this->uri->segment(4); ?>';
        let val_id_type = $('#id_type').val();
        let val_id_category = $('#id_category').val();
        let val_id_object = $('#id_object').val();
        let val_id_pic = $('#id_pic').val();
        let val_id_requester = $('#id_requester').val();
        let val_id_priority = $('#id_priority').val();
        let val_task = $('#task').val();
        let val_location = "";
        let val_description = $('#description').val();

        if (val_id_object == "") {
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
        } else if (val_id_type == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, type must be filled',
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
        } else if (val_id_priority == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, priority must be filled',
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
        } else if (val_id_requester == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, requester is empty must be filled',
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
                content: 'Oops, ticket must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
            // } else if (val_location == "") {
            //     $.confirm({
            //         icon: 'fa fa-close',
            //         title: 'Oops!',
            //         theme: 'material',
            //         type: 'red',
            //         content: 'Oops, location must be filled',
            //         buttons: {
            //             close: {
            //                 actions: function(tutup) {}
            //             },
            //         },
            //     });
        } else if (val_description == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, description must be filled',
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
                    let file_data = $("#file_ticket").prop("files")[0];
                    let form_data_ticket = new FormData();
                    form_data_ticket.append("id_object", val_id_object);
                    form_data_ticket.append("id_type", val_id_type);
                    form_data_ticket.append("id_category", val_id_category);
                    form_data_ticket.append("id_priority", val_id_priority);
                    form_data_ticket.append("id_requester", val_id_requester);
                    form_data_ticket.append("id_pic", val_id_pic.toString());
                    form_data_ticket.append("task", val_task);
                    form_data_ticket.append("location", val_location);
                    form_data_ticket.append("file_ticket", file_data);
                    form_data_ticket.append("description", val_description);
                    $.ajax({
                        url: `<?= base_url() ?>tickets/main/save_task`,
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data_ticket, // Setting the data attribute of ajax with file_data
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
                            if (uri_segment_view == "table") {
                                dt_tickets();
                            } else if (uri_segment_view == "kanban") {
                                kanban_data();
                            }

                            generate_progress_bar()
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.confirm({
                                    icon: 'fa fa-check',
                                    title: 'Done!',
                                    theme: 'material',
                                    type: 'blue',
                                    content: 'Success! Mengirim Notifikasi ke PIC',
                                    buttons: {
                                        close: {
                                            actions: function() {}
                                        },
                                    },
                                });
                            }, 250);
                        } else {
                            $('#modal_add_task').modal('hide');
                            if (uri_segment_view == "table") {
                                dt_tickets();
                            } else if (uri_segment_view == "kanban") {
                                kanban_data();
                            }
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
<!-- Task End  -->


<!-- Detail Task Start -->
<script>
    let e_sel_id_status = NiceSelect.bind(document.getElementById('e_id_status'), {
        searchable: true
    });


    let type_e_id_status = document.getElementById("e_id_status");
    type_e_id_status.addEventListener("change", function() {
        if (type_e_id_status.value == "1" || type_e_id_status.value == "2") {
            $('#e_progress').val(0)
        } else if (type_e_id_status.value == "3") {
            $('#e_progress').val(100)
        } else {
            $('#e_progress').val(0)
        }
    });

    $('#modal_detail_task').on('hidden.bs.modal', function() {
        // do something…
        page_uri = "<?= $this->uri->segment(4); ?>";
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
                    url: `<?= base_url() ?>tickets/main/get_detail_task`,
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

                            if (response.detail.id_status == 3 || response.detail.id_status == 4) {
                                $('#div_resend_notif').addClass('d-none');
                            } else {
                                $('#div_resend_notif').removeClass('d-none');
                            }

                            if (response.detail.id_status > 1) {
                                $('#div_not_started').addClass('d-none');
                            } else {
                                $('#div_not_started').removeClass('d-none');
                            }

                            if (response.detail.id_pic.includes(user_id)) {
                                $('#footer-update').removeClass('d-none');
                            } else {
                                $('#footer-update').addClass('d-none');
                            }



                            // Text Info
                            $('#e_object_text').text(response.detail.object);
                            $('#e_due_date_text').html(response.detail.due_date_2);
                            $('#e_timeline_text').text(response.detail.timeline);
                            $('#e_description_text').html(response.detail.description);
                            $('#e_type_text').html(response.detail.type).removeClass().addClass('badge bg-light-pink text-dark');
                            $('#e_category_text').html(response.detail.category).removeClass().addClass('badge bg-light-yellow text-dark');
                            $('#e_priority_text').html(response.detail.priority).removeClass().addClass('badge ' + response.detail.priority_color);
                            $('#e_level_text').html(response.detail.level).removeClass().addClass('badge ' + response.detail.level_color);
                            $('#e_status_text').html(response.detail.status).removeClass().addClass('badge ' + response.detail.status_color);
                            $('#e_requested_at_text').html(response.detail.tgl_dibuat + ' | ' + response.detail.jam_dibuat + ' WIB');
                            $('#e_requested_by_text').html(response.detail.requested_by);
                            $('#e_requested_location_text').html(response.detail.location);
                            $('#e_requested_company_text').html(response.detail.requested_company);
                            $('#e_requested_department_text').html(response.detail.requested_department);
                            $('#e_requested_designation_text').html(response.detail.requested_designation);
                            $('#div_e_progress').empty().append(`
                            <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated ${response.detail.status_color}" role="progressbar" style="width: ${Math.round(response.detail.progress * 1) / 1}%;" aria-valuenow="${Math.round(response.detail.progress * 1) / 1}" aria-valuemin="0" aria-valuemax="100">${Math.round(response.detail.progress * 1) / 1}%</div>
                            </div>`);

                            // dt_detail_sub_task(id_task);
                            // get_timeline(id_task);

                            $('#detail_id_task').val(response.detail.id_task);
                            $('#modal_detail_task_label').text(response.detail.task);

                            $('#e_start_timeline').val(response.detail.start);
                            $('#e_end_timeline').val(response.detail.end);
                            $('#e_note').val('');
                            $('#e_progress').val(response.detail.progress);
                            // console.log(Math.round(response.detail.progress * 100) / 100);


                            $('#e_id_task').val(response.detail.id_task);
                            $('#e_task').val(response.detail.task);
                            $('#e_task_text').text(response.detail.task);

                            $('#e_description_div').html(response.detail.description);

                            // priority
                            // if (response.detail.id_priority == 1) {
                            //     prior_class = ` bg-light-blue text-blue`
                            // } else if (response.detail.id_priority == 2) {
                            //     prior_class = `bg-light-purple text-purple`
                            // } else if (response.detail.id_priority == 3) {
                            //     prior_class = `bg-light-cyan text-cyan`
                            // } else if (response.detail.id_priority == 3) {
                            //     prior_class = `bg-light-cyan text-cyan`
                            // } else if (response.detail.id_priority == 4) {
                            //     prior_class = `bg-light-green text-green`
                            // } else {
                            //     prior_class = `bg-light text-light`
                            // }


                            if (response.detail.due_date != '') {
                                due_div_el = `<span class="btn btn-sm btn-link ${response.detail.due_date_style} ${response.detail.due_date_style_text}"><i class="bi bi-clock-history"></i> ${response.detail.due_date_text}</span>
                                `
                                $('#e_due_date_div').html(due_div_el);
                                $('#e_due_date').val(response.detail.due_date);
                                $('#e_start_timeline').val(response.detail.start);
                                $('#e_end_timeline').val(response.detail.end);
                            }


                            e_get_priority();
                            e_get_pic(response.detail.id_type);
                            setTimeout(() => {
                                e_sel_id_pic.setSelected(response.detail.id_pic.split(","));
                                $('#e_id_priority').val(response.detail.id_priority);
                                e_sel_id_priority.update();
                                $('#e_id_level').val(response.detail.id_level);
                                e_sel_id_level.update();
                            }, 250);


                            $('#e_pic_text').text(response.detail.team_name);
                            $('#e_id_status').val(response.detail.id_status);
                            if (response.detail.id_status > 1) {
                                $('#e_id_status option[value="' + 1 + '"]').attr("disabled", true);
                            }
                            e_sel_id_status.update();

                            page_uri = "<?= $this->uri->segment(4); ?>";
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

                            activateTab('comment');


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

    function activateTab(id) {
        id_task = $('#detail_id_task').val();
        $('.detail_pages').hide();
        var tabs = document.querySelectorAll('.nav-link');
        tabs.forEach(function(tab) {
            tab.classList.remove('active');
        });
        var clickedTab = document.querySelector(`#nav_${id}`);
        clickedTab.classList.add('active');

        $('.detail_pages').hide();
        $(`#${id}_page`).show();

        console.log(id);
        console.log(id_task);
        if (id == "activity") {
            show_log_history(id_task);
        } else if (id == "comment") {
            show_get_comment(id_task);
        } else if (id == "files") {
            get_attachment(id_task);
        }
    }


    function show_log_history(id_task) {
        base_url = "http://trusmiverse.com/hr/uploads/profile";
        body_log_history = '';
        $('#body_log_history').html('');
        // $('#dt_log_history').paging('destroy');


        $.ajax({
            url: "<?= base_url('tickets/main/get_log_history') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                id_task: id_task,
            },
            beforeSend: function() {
                $('#spinner_loading').show();
                // $('#activity_page').hide();
                // $('#files_page').hide();
                $('#activity_page').fadeOut();

            },
            success: function(response) {
                // console.info(response)
                body_log_history = '';
                setTimeout(() => {
                    response.log.forEach((value, index) => {
                        body_log_history += `<tr>
                            <td><small><small>${calculate_time_history_log_detail(value.datetime)}</small></small></td>
                            <td>
                                <div class="avatar avatar-30 coverimg rounded-circle me-1"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="${value.employee}">
                                    <img src="${base_url}/${value.photo}" alt="">
                                </div>
                            </td>
                            <td><small>${get_jenis_log_detail(value.jenis)}</small></td>
                            <td><small>${generate_history_change_detail(value)}<small></td>
                        </tr>`
                    });
                }, 500);

            },
            complete: function() {
                setTimeout(() => {
                    $('#spinner_loading').fadeOut();
                    $('#activity_page').fadeIn();
                    $('#body_log_history').html(body_log_history);

                    // activate_footable();

                    body_log_history = '';
                }, 500);
            }
        })
    }

    function activate_footable() {
        $('.footable').footable({
            "paging": {
                "enabled": true,
                "container": '.footable-pagination',
                "countFormat": "{CP} of {TP}",
                "limit": 10,
                "position": "right",
                // "size": 4
            },
            "sorting": {
                "enabled": true
            },
        }, function(ft) {
            $('.footablestot').html($('.footable-pagination-wrapper .label').html())

            $('.footable-pagination-wrapper ul.pagination li').on('click', function() {
                setTimeout(function() {
                    $('.footablestot').html($('.footable-pagination-wrapper .label').html());
                }, 200);
            });

        });
    }

    function calculate_time_history_log_detail(time_string) {
        var targetDate = new Date(time_string);
        var currentDate = new Date();
        var timeDifference = currentDate - targetDate;
        var daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
        var hoursDifference = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var monthDifference = (currentDate.getMonth() + 1) - (targetDate.getMonth() + 1);
        var yearDifference = currentDate.getFullYear() - targetDate.getFullYear();

        if (yearDifference > 0) {
            // return `<i class="bi bi-clock"></i> ${yearDifference}y`
            return `<small>${convert_duedate_detail(time_string)}</small>`
        } else if (monthDifference > 0) {
            // return `<i class="bi bi-clock"></i> ${monthDifference}m`
            return `<small>${convert_duedate_detail(time_string)}</small>`
        } else if (daysDifference > 0) {
            // return `<i class="bi bi-clock"></i> ${daysDifference}d`
            return `<small>${convert_duedate_detail(time_string)}</small>`
        } else if (hoursDifference > 0) {
            return `<i class="bi bi-clock"></i> ${hoursDifference}h`
            // return `<small>${convert_duedate_detail(time_string)}</small>`
        } else {
            timeOnly = time_string.split(' ')[1].substring(0, 5);
            // const hours = parseInt(timeOnly.split(':')[0]);
            // let meridiem = 'am';
            // if (hours >= 12) {
            //     meridiem = 'pm';
            // }
            // return `${timeOnly} ${meridiem}`
            return convertTo12HourFormatDetail(timeOnly);
        }
    }

    function convertTo12HourFormatDetail(time24) {
        // Extract hours and minutes from the time string
        const [hours, minutes] = time24.split(':');

        // Convert hours to 12-hour format
        const hours12 = hours % 12 || 12; // If hours is 0, convert to 12

        // Determine if it's AM or PM
        const period = hours < 12 ? 'am' : 'pm';

        // Create the 12-hour time string
        const time12 = `${String(hours12).padStart(2, '0')}:${minutes} ${period}`;

        return time12;
    }

    function get_jenis_log_detail(jenis) {
        if (jenis == 'created') {
            jenis_log = `<small><i class="bi bi-pen"></i> Created</small>`
        } else if (jenis == 'progress') {
            jenis_log = `<small><i class="bi bi-percent text-success"></i> Progress</small>`
        } else if (jenis == 'status') {
            jenis_log = `<small><img class="status_img" src="<?= base_url() ?>/assets/img/color_status.png" style="max-width:8%; height:auto"> Status</small>`
        } else if (jenis == 'evaluasi') {
            jenis_log = `<small><i class="bi bi-clipboard-data"></i> Evaluasi</small>`
        } else if (jenis == 'note') {
            jenis_log = `<small><i class="bi bi-chat-right-text"></i> Note</small>`
        } else {
            jenis_log = ``
        }
        return jenis_log;
    }

    function generate_history_change_detail(value) {
        if (value.jenis == 'created') {
            history_change = `<small>${value.history}</small>`
        } else if (value.jenis == 'progress') {
            history_change = `<small>
                                <table>
                                    <tr>
                                        <td rowspan="2">${generate_type_badge(value.status.trim())}</td> 
                                        <td rowspan="2">${generate_progres_badge_log(value.progress, value.status.trim())}</td> 
                                        <td><i class="text-muted">strategy: </i>${value.history}</td>
                                    </tr> 
                                    <tr>
                                        <td><i class="text-muted">note: </i>${value.note}</td>
                                    </tr> 
                                </table>
                                </small>`
        } else if (value.jenis == 'status') {
            history_change = `<small>${generate_status_history(value.status_before)} <i class="bi bi-chevron-right text-muted" style="font-size:8pt"></i> ${generate_status_history(value.status)}<small>`
        } else if (value.jenis == 'evaluasi') {
            history_change = `<small>
                                <table>
                                    <tr>
                                        <td rowspan="2">${generate_type_badge(value.status.trim())}</td> 
                                        <td rowspan="2">${generate_progres_badge_log(value.progress, value.status.trim())}</td> 
                                        <td><i class="text-muted">strategy: </i>${value.sub_task}</td>
                                    </tr> 
                                    <tr>
                                        <td><i class="text-muted">Evaluasi: </i>${value.history}</td>
                                    </tr> 
                                </table>
                                </small>`
        } else if (value.jenis == 'note') {
            history_change = `<small>${value.history}</small>`
        } else {
            history_change = ``
        }
        return history_change;
    }

    function generate_type_badge(id) {
        if (id == '1' || id == 'Daily') { // 1: Daily
            return `<span class="btn btn-sm btn-link bg-light-theme theme-cyan"><small>D</small></span>`
        } else if (id == '2' || id == 'Weekly') { // 2: Weekly
            return `<span class="btn btn-sm btn-link bg-light-theme theme-yellow"><small>W</small></span>`
        } else if (id == '3' || id == 'Montly') { // 3: Montly
            return `<span class="btn btn-sm btn-link bg-light-theme theme-red"><small>M</small></span>`
        } else if (id == '4' || id == 'Twice') { // 4: Twice
            return `<span class="btn btn-sm btn-link bg-light-theme theme-green"><small>T</small></span>`
        } else {
            return ``
        }
    }

    function generate_progres_badge_log(progress, status = null) {

        if (status == '1' || status == 'Daily') { // 1: Daily
            return `<span class="btn btn-sm btn-link bg-light-theme theme-cyan"><small>${progress}%</small></span>`
        } else if (status == '2' || status == 'Weekly') { // 2: Weekly
            return `<span class="btn btn-sm btn-link bg-light-theme theme-yellow"><small>${progress}%</small></span>`
        } else if (status == '3' || status == 'Montly') { // 3: Montly
            return `<span class="btn btn-sm btn-link bg-light-theme theme-red"><small>${progress}%</small></span>`
        } else if (status == '4' || status == 'Twice') { // 4: Twice
            return `<span class="btn btn-sm btn-link bg-light-theme theme-green"><small>${progress}%</small></span>`
        } else {
            return ``
        }

        // if (progress >= 100) {
        //     return `<span class="btn btn-sm btn-link bg-light-green text-dark"><small>${progress}%</small></span>`
        // } else if (progress > 75) {
        //     return `<span class="btn btn-sm btn-link bg-light-cyan text-dark"><small>${progress}%</small></span>`
        // } else if (progress > 35) {
        //     return `<span class="btn btn-sm btn-link bg-light-blue text-dark"><small>${progress}%</small></span>`
        // } else if (progress >= 0) {
        //     return `<span class="btn btn-sm btn-link bg-light-red text-dark"><small>${progress}%</small></span>`
        // } else {
        //     return ``
        // }
    }

    function generate_status_history(status) {
        if (status == 'Not Started') {
            badge = `<span class="btn btn-link btn-sm bg-secondary text-white">${status}</span>`
        } else if (status == 'Working On') {
            badge = `<span class="btn btn-link btn-sm bg-yellow text-white">${status}</span>`
        } else if (status == 'Done') {
            badge = `<span class="btn btn-link btn-sm bg-green text-white">${status}</span>`
        } else if (status == 'Stuck') {
            badge = `<span class="btn btn-link btn-sm bg-red text-white">${status}</span>`
        } else {
            badge = ``
        }
        return badge;
    }

    function truncateString(str, maxLength) {
        if (str == null) {
            str = '';
        }
        if (str.length > maxLength) {
            return str.substring(0, maxLength - 3) + '...';
        } else {
            return str;
        }
    }

    function get_attachment(id_task) {
        body_files_page = '';
        base_url = "https://trusmiverse.com/apps/uploads/tickets";
        $.ajax({
            url: "<?= base_url('tickets/main/get_attachment') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                id_task: id_task,
            },
            beforeSend: function() {
                $('#spinner_loading').show();
                // $('#files_page').hide();
                // $('#body_files_page').empty();
                $('.detail_pages').hide();
                $('#nama_file').val('');
                $('#fileInput').val('');
                $('#file_string').val('');
            },
            success: function(response) {
                // console.info(response)
                if (response.attachment.length > 0) {
                    response.attachment.forEach((value, index) => {

                        // ${generate_file_attachment(base_url, value.file)}
                        imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
                        if (value.type_file == 'pdf') {
                            img_file_div = `<div class="h-150 bg-red text-white d-flex align-items-center">
                                            <h1 class="col-12 text-center"><i class="bi bi-file-earmark-pdf"></i> PDF</h1>
                                        </div>`
                        } else if (value.type_file == 'xls' || value.type_file == "xlsx") {
                            img_file_div = `<div class="h-150 bg-green text-white d-flex align-items-center">
                                            <h1 class="col-12 text-center"><i class="bi bi-file-earmark-spreadsheet"></i> EXCEL</h1>
                                        </div>`
                        } else if (value.type_file == 'doc' || value.type_file == "docx") {
                            img_file_div = `<div class="h-150 bg-blue text-white d-flex align-items-center">
                                            <h1 class="col-12 text-center"><i class="bi bi-file-earmark-word"></i> WORD</h1>
                                        </div>`
                        } else if (value.type_file == 'ppt' || value.type_file == "pptx") {
                            img_file_div = `<div class="h-150 bg-yellow text-white d-flex align-items-center">
                                            <h1 class="col-12 text-center"><i class="bi bi-filetype-ppt"></i> PPT</h1>
                                        </div>`
                        } else if (imageExtensions.includes(value.type_file)) {
                            img_file_div = `<div class="h-150 coverimg" style="background-image: url(&quot;<?= base_url() ?>uploads/tickets/${value.file}&quot;);">
                                        </div>`
                        } else {
                            img_file_div = `<div class="h-150">
                                        </div>`
                        }
                        body_files_page +=
                            `<div class="col-12 col-md-6 col-lg-6 col-xl-6 mb-4">
                                    <div class="card border-0 overflow-hidden">
                                        ${img_file_div}
                                        <div class="card-footer bg-none">
                                            <div class="row gx-3 align-items-center">
                                                <div class="col-12 col-md-2">
                                                    <a href="<?= base_url() ?>uploads/tickets/${value.file}" target="_blank" class="avatar avatar-30 rounded text-red mr-3">
                                                        <i class="bi bi-download h5 vm"></i>
                                                    </a>
                                                </div>
                                                <div class="col-12 col-md-10">
                                                    <p class="mb-0 small">${value.created_by}</p>
                                                    <p style="font-size:8pt;" class="text-secondary">${value.times}</p>
                                                    <p style="font-size:8pt;" class="text-secondary text-turncate">${value.filename}</p>
                                                </div>
                                                <div class="col-12">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                    });
                } else {
                    body_files_page = `
                                <div class="col-12">
                                    <div class="card border-0 overflow-hidden">
                                        <div class="card-footer bg-none">
                                            <div class="row gx-3 align-items-center">
                                                <div class="col-12 col-md-10">
                                                    <p class="mb-0 small">No Files</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    `;
                }
                $('#body_files_page').html(body_files_page)
            },
            complete: function() {
                setTimeout(() => {
                    $('#spinner_loading').hide();
                    $('.detail_pages').hide();
                    $('#files_page').show();
                }, 500);
            }
        })

    }

    function generate_file_attachment(base_url, filename) {
        ext = filename.split('.').pop();

        imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
        if (imageExtensions.includes(ext)) {
            return `<img src="${base_url}/${filename}" class="h-150" alt="" />`
        } else if (ext == "pdf") {
            return `<center><a href="${base_url}/${filename}" target="_blank" class="avatar avatar-100 rounded bg-red text-white">
                        <i class="bi bi-file-earmark-pdf vm" style="font-size: 50px"></i>
                    </a></center>`
        } else if (ext == "ppt" || ext == "pptx") {
            return `<center><a href="${base_url}/${filename}" target="_blank" class="avatar avatar-100 rounded bg-red text-white">
                        <i class="bi bi-filetype-ppt vm" style="font-size: 50px"></i>
                    </a></center>`
        } else if (ext == "doc" || ext == "docx") {
            return `<center><a href="${base_url}/${filename}" target="_blank" class="avatar avatar-100 rounded bg-red text-white">
                        <i class="bi bi-file-earmark-word-fill vm" style="font-size: 50px"></i>
                    </a></center>`
        } else if (ext == "xls" || ext == "xlsx") {
            return `<center><a href="${base_url}/${filename}" target="_blank" class="avatar avatar-100 rounded bg-red text-white">
                        <i class="bi bi-file-earmark-x-fill vm" style="font-size: 50px"></i>
                    </a></center>`
        } else {
            return `<img src="${base_url}/${filename}" class="h-150" alt="" />`
        }

        // return ''
    }

    function addFileInput() {
        $('#fileInput').trigger('click');

    }

    function hide_upload_toast() {
        $('#liveToast').hide()
    }

    function file_selected() {
        var fileInput = document.getElementById('fileInput');
        var file = fileInput.files[0];
        $('#file_string').val(file.name);
        // console.info(`file.name ${file.name}`)

        document.getElementById('uploaded_preview').src = window.URL.createObjectURL(file);

    }

    function upload_file() {
        id_task = $('#detail_id_task').val();

        file_name = $('#nama_file').val();
        file_string = $('#file_string').val();

        if (file_name == '') {
            $('#nama_file').addClass('is-invalid')
        } else if (file_string == '') {
            $('#file_string').addClass('is-invalid')
        } else {

            var form = $('#fileForm')[0];
            var formData = new FormData(form);
            formData.append('id_task', id_task);

            $('#liveToast').show();
            $('#upload_check').hide();
            $('#spinner_upload').show();

            document.getElementById('myProgressBar').setAttribute('aria-valuenow', 0);
            document.getElementById('myProgressBar').style.width = 0 + '%';

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressUpload, false);
            ajax.open("POST", "<?= base_url('tickets/main/upload_file') ?>", true);
            ajax.send(formData);
            ajax.onload = function() {
                // console.log('DONE: ', ajax.status);
                // console.log(ajax.status);
                // console.info(JSON.parse(ajax.responseText));
                if (ajax.status == 200) {

                    response = JSON.parse(ajax.responseText);
                    // console.info(response)
                    get_attachment(id_task);

                    setTimeout(() => {
                        hide_upload_toast();
                        console.info('hide toast')
                    }, 5000);

                }
            }

        }

    }

    function remove_invalid(id) {
        $(`#${id}`).removeClass('is-invalid')
    }

    function progressUpload(event) {
        var percent = (event.loaded / event.total) * 100;
        // document.getElementsByClassName("progress_bar")[0].style.width = Math.round(percent) + '%';
        // document.getElementsByClassName("status_bar")[0].innerHTML = Math.round(percent) + "% completed";
        document.getElementById('myProgressBar').setAttribute('aria-valuenow', Math.round(percent));
        document.getElementById('myProgressBar').style.width = Math.round(percent) + '%';

        $('#btn_save_upload').hide();

        $("#uploaded_status").html('Uploading ...');
        var fileInput = document.getElementById('fileInput');
        var preview = document.getElementById('uploaded_preview');
        var file = fileInput.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            preview.src = reader.result;
        }
        $('#uploaded_preview').attr('src', )
        nama_file = $('#nama_file').val();
        $('#uploaded_name').html(nama_file);
        current_datetime = "<?= date('Y-m-d H:i:s') ?>";
        $('#uploaded_date').html(current_datetime);

        if (Math.round(percent) == 100) {
            setTimeout(() => {
                $('#spinner_upload').hide();
                $('#upload_check').show();
                $("#uploaded_status").html('Upload Success');
                $('#btn_save_upload').show();
            }, 500);
        }
    }

    function convert_duedate_detail(dateString) {
        var dateObject = new Date(dateString);
        var monthNames = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];
        var day = dateObject.getDate();
        var month = monthNames[dateObject.getMonth()];
        var formattedDate = day + ' ' + month;
        return formattedDate;
    }

    // COMMENT
    function show_get_comment(id_task) {
        base_url = "http://trusmiverse.com/hr/uploads/profile";
        body_get_comment = '';
        $('#body_get_comment').html('');
        $.ajax({
            url: "<?= base_url('tickets/main/get_comment') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                id_task: id_task,
            },
            beforeSend: function() {
                $('#spinner_loading').show();
                $('#body_get_comment').fadeOut();
            },
            success: function(response) {
                // console.info(response)
                body_get_comment = '';
                setTimeout(() => {
                    response.comment.forEach((value_comment, index) => {
                        if (value_comment.reply_to == '') {
                            body_get_reply = '';
                            response.reply.forEach((value_reply, index) => {
                                if (value_reply.reply_to == value_comment.id_comment) {
                                    body_get_reply += `
                                            <div class="border-0 mb-2 mt-2">
                                                <div class="">
                                                    <div class="row">
                                                        <div class="col-auto">
                                                            <figure class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;${base_url}/${value_reply.profile_picture}&quot;);">
                                                                <img src="${base_url}/${value_reply.profile_picture}" alt="" style="display: none;">
                                                            </figure>
                                                        </div>
                                                        <div class="col align-self-center ps-1">
                                                            <div class="row g-0">
                                                                <div class="col-12">
                                                                    <p class="text-truncate mb-0 small">${value_reply.employee_name}</p>
                                                                    <div class="text-dark text-wrap m-0 mt-2 small" style="font-size: small !important;">${value_reply.comment}</div>
                                                                </div>
                                                                <div class="col-12 mt-1">
                                                                    <p class="text-secondary small mb-0">${value_reply.times}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>`
                                }
                            });
                            body_get_comment +=
                                `<div class="card border-0 mb-2">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-auto">
                                                <figure class="avatar avatar-30 coverimg rounded-circle" style="background-image: url(&quot;${base_url}/${value_comment.profile_picture}&quot;);">
                                                    <img src="${base_url}/${value_comment.profile_picture}" alt="" style="display: none;">
                                                </figure>
                                            </div>
                                            <div class="col align-self-center ps-2 border-start">
                                                <div class="row g-0">
                                                    <div class="col-12">
                                                        <p class="text-truncate mb-0 small">${value_comment.employee_name}</p>
                                                        <div class="text-dark text-wrap m-0 mt-2 small" style="font-size: small !important;">${value_comment.comment}</div>
                                                    </div>
                                                    <div class="col-12 mt-1">
                                                        <p class="text-secondary small mb-0">${value_comment.times} | <a role="button" class="text-primary" onclick="create_comment_section('${value_comment.id_task}','${value_comment.id_comment}')">Reply</a></p>
                                                    </div>
                                                </div>
                                                <div class="row g-0">
                                                    <div id="reply_section_${value_comment.id_comment}" class="col-12"></div>
                                                    <div id="reply_content_${value_comment.id_comment}" class="col-12 mt-2">
                                                        ${body_get_reply}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`
                        }
                    });
                }, 500);

            },
            complete: function() {
                setTimeout(() => {
                    $('#spinner_loading').hide();
                    $('#body_get_comment').fadeIn();
                    $('#comment_page').show();
                    $('#body_get_comment').html(body_get_comment);
                    body_get_comment = '';
                    // activate_footable()
                }, 500);
            }
        })
    }


    // Create Reply Section
    function create_comment_section(id_task, id_comment) {
        $(`#reply_section_${id_comment}`).fadeOut()
        reply_content = `<div class="border-0 mb-2">
                            <div class="">
                                <div class="row">
                                    <div class="col-12 mt-2">
                                        <textarea name="e_reply_${id_comment}" id="e_reply_${id_comment}" cols="30" rows="5"></textarea>
                                    </div>
                                    <div class="col text-end mt-2">
                                        <button class="btn btn-sm btn-link" onclick="clear_comment_section('${id_task}','${id_comment}')"><i class="bi bi-close"></i> Cancel</button>
                                        <button class="btn btn-sm btn-theme" onclick="save_reply('${id_task}','${id_comment}')"><i class="bi bi-send"></i> Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>`
        setTimeout(() => {
            $(`#reply_section_${id_comment}`).empty().append($(reply_content).hide().fadeIn(1500)).fadeIn(1000);
            let sum_e_reply = $(`#e_reply_${id_comment}`).summernote({
                placeholder: 'Input here...',
                tabsize: 2,
                height: 100,
                toolbar: false
            });
            sum_e_reply.summernote('code', '');
        }, 250);
    }

    function save_reply(id_task, id_comment) {
        let val_e_id_task = $('#e_id_task').val();
        let val_e_reply = $(`#e_reply_${id_comment}`).val();
        if (val_e_reply == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, cannot send empty reply',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else {
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
            $.ajax({
                url: `<?= base_url() ?>tickets/main/save_reply`,
                type: 'POST',
                dataType: 'json',
                data: {
                    id_comment: id_comment,
                    id_task: val_e_id_task,
                    comment: val_e_reply
                },
                beforeSend: function() {

                },
                success: function(response) {},
                error: function(xhr) {},
                complete: function() {},
            }).done(function(response) {
                if (response == true) {
                    setTimeout(() => {
                        // $('#e_comment').text('');
                        sum_e_comment.summernote('code', '');
                        show_get_comment(val_e_id_task);
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
                    setTimeout(() => {
                        jconfirm.instances[0].close();
                        show_get_comment(val_e_id_task);
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
                    show_get_comment(val_e_id_task);
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
            //         },
            //     });
        }

    }
    // /Create Reply Section


    // Clear Reply Section
    function clear_comment_section(id_task, id_comment) {
        $(`#reply_section_${id_comment}`).fadeOut(1000).empty();
    }
    // /Clear Reply Section


    function update_task() {
        let val_e_id_task = $('#e_id_task').val();
        let val_e_id_status = $('#e_id_status').val();
        let val_e_id_priority = $('#e_id_priority').val();
        let val_e_id_level = $('#e_id_level').val();
        let val_e_id_pic = $('#e_id_pic').val();
        let val_e_progress = $('#e_progress').val();
        let val_e_note = $('#e_note').val();
        let val_e_due_date = $('#e_due_date').val();
        let val_e_start_timeline = $('#e_start_timeline').val();
        let val_e_end_timeline = $('#e_end_timeline').val();

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
        } else if (val_e_due_date == "") {
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
        } else if (val_e_id_pic == "") {
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
        } else if (val_e_start_timeline == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, start timeline must be filled',
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
                content: 'Oops, end timeline must be filled',
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
        } else if (val_e_id_priority == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, priority must be choosen',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_e_id_level == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, level must be choosen',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
            // } else if (val_e_note == "") {
            //     $.confirm({
            //         icon: 'fa fa-close',
            //         title: 'Oops!',
            //         theme: 'material',
            //         type: 'red',
            //         content: 'Oops, note must be filled',
            //         buttons: {
            //             close: {
            //                 actions: function() {}
            //             },
            //         },
            //     });
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
                        url: `<?= base_url() ?>tickets/main/update_task`,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id_task: val_e_id_task,
                            id_status: val_e_id_status,
                            id_priority: val_e_id_priority,
                            id_level: val_e_id_level,
                            id_pic: val_e_id_pic.toString(),
                            progress: val_e_progress,
                            note: val_e_note,
                            due_date: val_e_due_date,
                            start_timeline: val_e_start_timeline,
                            end_timeline: val_e_end_timeline,
                        },
                        beforeSend: function() {

                        },
                        success: function(response) {},
                        error: function(xhr) {},
                        complete: function() {},
                    }).done(function(response) {
                        if (response == true) {
                            $('#modal_detail_task').modal('hide');
                            segment_uri = "<?= $this->uri->segment(4); ?>";
                            if (segment_uri == "table") {
                                dt_tickets();
                            } else {
                                kanban_data();
                            }
                            generate_progress_bar();
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
                            dt_tickets();
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



    function save_comment() {
        let val_e_id_task = $('#e_id_task').val();
        let val_e_comment = $('#e_comment').val();
        if (val_e_comment == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, cannot send empty comment',
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
                        url: `<?= base_url() ?>tickets/main/save_comment`,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id_task: val_e_id_task,
                            comment: val_e_comment
                        },
                        beforeSend: function() {

                        },
                        success: function(response) {},
                        error: function(xhr) {},
                        complete: function() {},
                    }).done(function(response) {
                        if (response == true) {
                            setTimeout(() => {
                                // $('#e_comment').text('');
                                sum_e_comment.summernote('code', '');
                                show_get_comment(val_e_id_task);
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
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                show_get_comment(val_e_id_task);
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
                            show_get_comment(val_e_id_task);
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


    function resend_notif() {
        id_task = $('#e_id_task').val();
        $.confirm({
            title: 'Resend Notif!',
            content: 'Are you sure, you want to resend notification ?',
            theme: 'material',
            type: 'blue',
            buttons: {
                close: function() {},
                yes: {
                    theme: 'material',
                    type: 'blue',
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
                                    url: `<?= base_url() ?>tickets/main/resend_notif_request`,
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        id_task: id_task,
                                    },
                                    beforeSend: function() {

                                    },
                                    success: function(response) {},
                                    error: function(xhr) {},
                                    complete: function() {},
                                }).done(function(response) {
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
            }
        });
    }
</script>
<!-- /Detail Task Start -->



<!-- Js View Table  -->
<?php if ($this->uri->segment(4) != "") {
    $this->load->view('tickets/' . $this->uri->segment(4) . '/js');
} ?>