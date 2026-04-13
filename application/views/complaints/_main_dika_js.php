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


<!-- Fomantic Or Semantic Ui -->
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/dropdown.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/transition.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/form.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/popup.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/toast.js"></script>
<script src="<?= base_url(); ?>assets/vendor/chart-js-3.3.1/chart.min.js"></script>

<!-- DROPZONE -->
<script type="text/javascript" src="<?= base_url(); ?>assets/dropzone/dropzone.min.js"></script>


<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<!-- script state awal -->
<script>
    Dropzone.autoDiscover = false;
    $('#input_foto').empty();
    $('#foto').dropzone('destroy');


    var user_role_id = "<?= $this->session->userdata('user_id'); ?>"
    var user_id = "<?= $this->session->userdata('user_id'); ?>"
    $(window).on("load", function() {
        // global uri
        uri_segment_view = "<?= $this->uri->segment(4); ?>";

        // console.log(uri_segment_view);

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
                setTimeout(() => {
                    dt_complaints();
                }, 250);
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
                'Last 60 Days': [moment().subtract(59, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);

        initializeDropzone();

    });
    $('#ceklis_pekerjaan').change(function(e) {
        e.preventDefault();
        if ($(this).is(':checked')) {
            $('.row_pekerjaan').show();
        } else {
            $('.row_pekerjaan').hide();
        }
    });


    // semantic ui dropdown
    $('#id_project').dropdown_se();
    $('#pekerjaan').dropdown_se();
    $('#sub_pekerjaan').dropdown_se();
    $('#detail_pekerjaan').dropdown_se({
        allowAdditions: true,
        clearable: true
    });
    $('#id_category').dropdown_se();
    $('#blok').dropdown_se();

    $('#id_project_detail').dropdown_se();
    $('#blok_detail').dropdown_se();


    $('#id_priority').dropdown_se();
    $('#id_pic').dropdown_se();
    $('#id_requester').dropdown_se();

    $('#e_id_type').dropdown_se();
    $('#e_id_category').dropdown_se();
    $('#e_id_object').dropdown_se();
    $('#e_id_priority').dropdown_se();
    $('#e_id_level').dropdown_se();
    $('#e_id_pic').dropdown_se();
    $('#e_id_status').dropdown_se();

    $('#filter_category').dropdown_se();
    $('#filter_pic').dropdown_se();

    $('#id_category_detail').dropdown_se();
</script>
<!-- /script state awal -->


<!-- generate progress -->
<script>
    function generate_progress_bar() {
        start = $('#start').val()
        end = $('#end').val()
        category = $('#filter_category').val()
        pic = $('#filter_pic').val()
        $.ajax({
            url: '<?= base_url() ?>complaints/main/generate_progress_bar',
            type: 'POST',
            dataType: 'json',
            data: {
                start: start,
                end: end,
                category: category,
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
            waiting = parseInt(response.data.waiting);
            verified = parseInt(response.data.verified);
            reject = parseInt(response.data.reject);
            working_on = parseInt(response.data.working_on);
            reject_2 = parseInt(response.data.reject_2);
            unsolved = parseInt(response.data.unsolved);
            done = parseInt(response.data.done);
            header_total_verification = waiting + verified + reject;
            header_total_escalation = working_on + reject_2 + unsolved + done;

            grand_total = waiting + verified + reject + working_on + reject_2 + unsolved + done;

            $('#header_total_verification').html(`${header_total_verification}`);
            $('#header_total_escalation').html(`${header_total_escalation}`);
            $('#header_waiting').html(`${waiting}`);
            $('#header_waiting_2').html(`${verified}`);
            $('#header_verified').html(`${verified}`);
            $('#header_reject').html(`${reject}`);
            $('#header_working_on').html(`${working_on}`);
            $('#header_reject_2').html(`${reject_2}`);
            $('#header_unsolved').html(`${unsolved}`);
            $('#header_done').html(`${done}`);

            bar_waiting = (waiting / grand_total) * 100;
            bar_verified = (verified / grand_total) * 100;
            bar_reject = (reject + reject_2 / grand_total) * 100;
            bar_working_on = (working_on / grand_total) * 100;
            bar_done = (done / grand_total) * 100;
            bar_unsolved = (unsolved / grand_total) * 100;

            // $("#total_team_solver").html(response.team_solver.total_solver + " People")
            // $("#task_in_progress").html(response.data.working_on + " - " + response.lt_progress.lt_hour + " hrs")
            // $("#total_done").html(response.data.done + "")
            // $("#total_late").html(response.lt_late.late + " - " + response.lt_late.persen_late + "%")
            // $("#total_task_card").html(response.data.total_task)

            $('#progres_bar_waiting').css('width', `${bar_waiting==0?1:bar_waiting}%`)
            $('#progres_bar_verified').css('width', `${bar_verified==0?1:bar_verified}%`)
            $('#progres_bar_reject').css('width', `${bar_reject==0?1:bar_reject}%`)
            $('#progres_bar_working_on').css('width', `${bar_working_on==0?1:bar_working_on}%`)
            $('#progres_bar_done').css('width', `${bar_done==0?1:bar_done}%`)
            $('#progres_bar_unsolved').css('width', `${bar_unsolved==0?1:bar_unsolved}%`)


            tippy('#progres_bar_waiting', {
                content: `Waiting / ${waiting}`,
                placement: 'top',
                animation: 'scale',
                theme: 'material',
            });
            tippy('#progres_bar_verified', {
                content: `Verified / ${verified}`,
                placement: 'top',
                animation: 'scale',
                theme: 'material',
            });
            tippy('#progres_bar_reject', {
                content: `Reject (1 & 2) / ${reject + reject_2}`,
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
            tippy('#progres_bar_unsolved', {
                content: `Unsolved / ${unsolved}`,
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
        $('#id_project').dropdown_se('clear');
        $('#blok').dropdown_se('clear');
        $('#id_priority').dropdown_se('clear');
        $('#id_pic').dropdown_se('clear');


        $('#task').val('');
        $('#file_complaints').val('');
        $('#description').val('');
        $('#description').summernote("code", "");
        get_project();
        get_category();
        initializeDropzone();
    }
</script>
<!-- /add new task -->


<!-- Initialize Dropzone -->
<script>
    function initializeDropzone() {

        $('#input_foto').empty();
        $('#foto').dropzone('destroy');

        setTimeout(() => {

            $('#input_foto').append(`<div class="dropzone dropzone-floating-label" id="foto"></div> 
            <div id="file_uploads"></div>`);

            var dZUpload = $("#foto") && new Dropzone("#foto", {
                url: `<?= base_url('complaints/main/upload_file_complaint') ?>`,
                // maxFilesize: 500,
                // thumbnailWidth: 160, 
                // previewTemplate: DropzoneTemplates.previewTemplate, 
                init: function() {
                    this.on("success", (function(e, t) {
                        // console.log(`success: ${t}`)
                        data = JSON.parse(t);
                        // console.log(`data: ${data.data}`)
                        id = data.data.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '-').replace(".", "-").replace(/ /g, "");
                        uploaded_file = `<input type="hidden" name="file[]" class="uploaded_file file_${id}" value="${data.data}" >
                                    <input type="hidden" name="size[]" class="uploaded_file file_${id}" value="${data.size}" >
                                    <input type="hidden" name="ext[]" class="uploaded_file file_${id}" value="${data.ext}" >
                                    `;
                        $('#file_uploads').append(uploaded_file)
                    }))
                    // , this.on("addedfile", (e => { 
                    // 	e.type 
                    // 	&& !e.type.match(/image.*/) 
                    // 	&& (e.documentPrev || 
                    // 		(e.previewTemplate.classList.remove("dz-image-preview"), 
                    // 			e.previewTemplate.classList.add("dz-file-preview"), 
                    // 			e.previewTemplate.classList.add("dz-complete"), 
                    // 			e.documentPrev = !0, this.emit("addedfile", e), 
                    // 			this.removeFile(e)
                    // 		)
                    // 	) 
                    // }))
                },
                addRemoveLinks: true,
                removedfile: function(file) {
                    var name = file.name;

                    $.ajax({
                        type: 'POST',
                        url: `<?= base_url('complaints/main/remove_file_complaint') ?>`,
                        data: {
                            name: name,
                            request: 2
                        },
                        sucess: function(data) {
                            console.info('success: ' + data);
                        },
                        error: function(err) {
                            console.info(err)
                        }
                    });
                    id = name.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '-').replace(".", "-").replace(/ /g, "");
                    $(`.file_${id}`).remove();

                    var _ref;
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                }
            });

        }, 100);

    }
</script>

<!-- Description Sumernote -->
<script>
    $('#description').summernote({
        placeholder: 'Complaints Description',
        tabsize: 2,
        height: 120,
        toolbar: [
            ['font', ['bold', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
        ],
        callbacks: {
            onPaste: function(e) {
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();
                document.execCommand('insertText', false, bufferText);
            },
            onImageUpload: function(data) {
                data.pop();
                $.toast({
                    class: 'warning',
                    title: 'Alert',
                    message: 'Tidak Boleh Paste Image'
                });
            }
        }
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
    get_filter_category()

    function get_filter_category() {
        $.ajax({
            url: '<?= base_url() ?>complaints/main/get_category',
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
            list_category = '';
            list_category += '<option value="all" selected>All Category</option>';
            for (let index = 0; index < response.length; index++) {
                list_category += `<option value="${response[index].id_category}">${response[index].category}</option>`;
            }
            $("#filter_category").empty().append(list_category)
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }

    let filter_category_element = document.getElementById("filter_category");
    filter_category_element.addEventListener("change", function() {
        if (uri_segment_view == "table") {
            dt_complaints();
        } else if (uri_segment_view == "kanban") {
            kanban_data();
        }
        generate_progress_bar()
    });
</script>

<!-- /Type Filter -->


<!-- Filter Pic -->
<script>
    get_filter_pic()

    function get_filter_pic() {
        $.ajax({
            url: '<?= base_url() ?>complaints/main/get_pic_ticket',
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
            my_ticket_id = "<?= $this->session->userdata('user_id'); ?>";
            list_pic_ticket += '<option value="all">All Complaints</option>';
            for (let index_t = 0; index_t < response.length; index_t++) {
                if (parseInt(response[index_t].id_pic) == parseInt(my_ticket_id) && parseInt(my_ticket_id) != 4138 && parseInt(my_ticket_id) != 9189) {
                    list_pic_ticket += `<option value="${response[index_t].id_pic}" selected>${response[index_t].pic} (${response[index_t].ticket})</option>`;
                }
            }
            for (let index = 0; index < response.length; index++) {
                if (parseInt(response[index].id_pic) != parseInt(my_ticket_id)) {
                    list_pic_ticket += `<option value="${response[index].id_pic}">${response[index].pic} (${response[index].ticket})</option>`;
                }
            }
            $("#filter_pic").empty().append(list_pic_ticket)
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get PIC Ticket")
        });
    }


    let filter_pic_element = document.getElementById("filter_pic");
    filter_pic_element.addEventListener("change", function() {
        if (uri_segment_view == "table") {
            dt_complaints();
        } else if (uri_segment_view == "kanban") {
            kanban_data();
        }
        generate_progress_bar()
    });
</script>
<!-- /Filter Pic -->


<!-- Type Start -->
<script>
    get_project()

    function get_project() {
        $.ajax({
            url: '<?= base_url() ?>complaints/main/get_project',
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
            list_project = '<option value="">Pilih Project</option>';
            for (let index = 0; index < response.length; index++) {
                list_project += `<option value="${response[index].id_project}">${response[index].project}</option>`;
            }
            $("#id_project").empty().append(list_project)
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }

    let id_project_element = document.getElementById("id_project");
    id_project_element.addEventListener("change", function() {
        id_project = $('#id_project').val();
        $.ajax({
            url: '<?= base_url() ?>complaints/main/get_blok_by_id_project',
            type: 'POST',
            dataType: 'json',
            data: {
                id_project: id_project
            },
            beforeSend: function() {
                $('#blok').empty().val('')
                $('#blok').dropdown_se('clear')
                $('#blok').closest('.ui .dropdown').addClass('loading disabled');
                $('#konsumen').prop('disabled', true).val('')
            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            $('#blok').closest('.ui .dropdown').removeClass('disabled loading')
            let list_blok = '<option value="">Pilih Blok</option>';
            if (response.blok != null) {
                response.blok.forEach(item => {
                    list_blok += `<option value="${item.blok}">${item.blok}</option>`;
                });
            }

            if (response.blok.length >= 0) {
                head_requester_id = response.blok[0].user_id;
                head_requester_name = response.blok[0].head_name;
                $('#head_requester_id').val(head_requester_id)
                $('#head_requester_name').val(head_requester_name)
            }

            $("#blok").empty().append(list_blok).prop('disabled', false);

            let list_pekerjaan = '<option value="">Pilih Pekerjaan</option>';
            if (response.pekerjaan != null) {
                response.pekerjaan.forEach(item => {
                    list_pekerjaan += `<option value="${item.id}">${item.pekerjaan}</option>`;
                });
            }

            $('#id_category').val('');
            $('#id_category').dropdown_se('clear');
            get_category();

            $("#pekerjaan").empty().append(list_pekerjaan).prop('disabled', false);
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Project")
        });
    });

    function get_project_detail() {
        $.ajax({
            url: '<?= base_url() ?>complaints/main/get_project',
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
            list_project = '<option value="">Pilih Project</option>';
            for (let index = 0; index < response.length; index++) {
                list_project += `<option value="${response[index].id_project}">${response[index].project}</option>`;
            }
            $("#id_project_detail").empty().append(list_project)
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }

    let id_project_detail_element = document.getElementById("id_project_detail");
    id_project_detail_element.addEventListener("change", function() {
        id_project = $('#id_project_detail').val();
        $.ajax({
            url: '<?= base_url() ?>complaints/main/get_blok_by_id_project',
            type: 'POST',
            dataType: 'json',
            data: {
                id_project: id_project
            },
            beforeSend: function() {
                $('#blok_detail').empty().val('')
                $('#blok_detail').dropdown_se('clear')
                // $('#blok_detail').closest('.ui .dropdown').addClass('loading disabled');
            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            $('#blok_detail').closest('.ui .dropdown').removeClass('disabled')
            let list_blok = '<option value="">Pilih Blok</option>';
            if (response.blok != null) {
                response.blok.forEach(item => {
                    list_blok += `<option value="${item.blok}">${item.blok}</option>`;
                });
            }

            $("#blok_detail").empty().append(list_blok).prop('disabled', false);
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Project")
        });
    });

    $('#pekerjaan').change(function(e) {
        e.preventDefault();
        var pekerjaan = $(this).val();
        $.ajax({
            type: "GET",
            url: "<?= base_url('complaints/main/get_sub_pekerjaan'); ?>/" + pekerjaan,
            dataType: "json",
            success: function(response) {
                let list_sub = '<option value="">Pilih Sub Pekerjaan</option>';
                if (response != null) {
                    response.forEach(item => {
                        list_sub += `<option value="${item.id}">${item.sub_pekerjaan}</option>`;
                    });
                }
                $("#sub_pekerjaan").empty().append(list_sub).prop('disabled', false);
            }
        });
    });
    $('#sub_pekerjaan').change(function(e) {
        e.preventDefault();
        var pekerjaan = $(this).val();
        $.ajax({
            type: "GET",
            url: "<?= base_url('complaints/main_dev/get_det_pekerjaan'); ?>/" + pekerjaan,
            dataType: "json",
            success: function(response) {
                let list_sub = '<option value="">Pilih Detail Pekerjaan</option>';
                if (response != null) {
                    response.forEach(item => {
                        list_sub += `<option value="${item.id}">${item.detail}</option>`;
                    });
                }
                $("#detail_pekerjaan").empty().append(list_sub).prop('disabled', false);
            }
        });
    });


    let blok_element = document.getElementById("blok");
    blok_element.addEventListener("change", function() {
        id_project = $('#id_project').val();
        blok = $('#blok').val() ?? '';
        // console.log(blok);
        $.ajax({
            url: '<?= base_url() ?>complaints/main/get_konsumen',
            type: 'POST',
            dataType: 'json',
            data: {
                id_project: id_project,
                blok: blok
            },
            beforeSend: function() {
                if (blok != '') {
                    $('#konsumen').closest('.ui .input').addClass('loading')
                    $('#konsumen').prop('disabled', true)
                    $('#konsumen').val('')
                }
            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            $('#konsumen').prop('disabled', false).closest('.ui .input').removeClass('loading')
            if (response != '') {
                $('#id_konsumen').val(response.id_konsumen)
                $('#konsumen').val(response.nama_konsumen)
            } else {
                let name_project = $('#id_project option:selected').text();
                let blok = $('#blok').val() ?? '';
                console.log(blok)
                if (blok != '') {
                    $('#konsumen').attr("placeholder", `Blok ${blok} - ${name_project} belum ada customer, silahkan input manual`).focus();
                }
            }
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Blok")
        });
    });

    function e_get_category(id_type = '', id_category = '') {
        $.ajax({
            url: '<?= base_url() ?>complaints/main/e_get_category',
            type: 'POST',
            dataType: 'json',
            data: {
                id_type: id_type
            },
            beforeSend: function() {
                $('#e_id_category').empty().append('<option value=""><i class="fa fa-spinner fa-spin"></i> Loading..</option>');
            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            e_list_category = '<option value="">Choose Category</option>';
            for (let index = 0; index < response.length; index++) {
                e_list_category += `<option value="${response[index].id_category}" ${response[index].id_category == id_category ? 'selected':''} data-id_type="${response[index].id_type}" data-id_sub_type="${response[index].id_sub_type}">${response[index].category}</option>`;
            }

            $("#e_id_category").empty().append(e_list_category);
            $('#e_id_category').dropdown_se('set selected', id_category);
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Category")
        });
    }

    function e_get_status(id_status = '', reschedule = 0,status_input) {
        // console.log(status_input)
        $.ajax({
            url: '<?= base_url() ?>complaints/main/get_status',
            data:{
                status_input:status_input
            },
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {
                $('#e_id_status').empty().append('<option value=""><i class="fa fa-spinner fa-spin"></i> Loading..</option>').prop('disabled', true);
            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            // console.log(response);
            $('#e_id_status').prop('disabled', false)
            e_list_status = '<option value="">Choose Object</option>';
            if (response != null) {
                for (let index = 0; index < response.length; index++) {
                    if (parseInt(id_status) == 1) {
                        if (parseInt(response[index].id_status) < 4) {
                            e_list_status += `<option value="${response[index].id_status}" ${response[index].id_status == id_status ? 'selected':''}>${response[index].status}</option>`;
                        }
                    } else if (parseInt(id_status) == 2) {
                        status_eskalasi = ['4', '5'];
                        if (status_eskalasi.includes(response[index].id_status)) {
                            e_list_status += `<option value="${response[index].id_status}" ${response[index].id_status == id_status ? 'selected':''}>${response[index].status}</option>`;
                        }
                    } else if (parseInt(id_status) == 4 || parseInt(id_status) == 8 || parseInt(id_status) == 9) {
                        if (reschedule == 0) {
                            status_eskalasi = ['4', '6', '7', '8'];
                        } else if (reschedule == 1) {
                            status_eskalasi = ['4', '6', '7', '9'];
                        } else {
                            status_eskalasi = ['4', '6', '7'];
                        }
                        if (status_eskalasi.includes(response[index].id_status)) {
                            e_list_status += `<option value="${response[index].id_status}" ${response[index].id_status == id_status ? 'selected':''}>${response[index].status}</option>`;
                        }
                    } else {
                        e_list_status += `<option value="${response[index].id_status}" ${response[index].id_status == id_status ? 'selected':''}>${response[index].status}</option>`;
                    }
                }
            }
            $("#e_id_status").empty().append(e_list_status);
            $('#e_id_status').val(id_status);
            $('#e_id_status').dropdown_se('set selected', id_status);
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Object")
        });
    }
</script>
<!-- Type End -->


<!-- Category Start -->
<script>
    function get_category() {
        let id_type_selected = "";
        id_type_selected = $('#id_type').val() ?? "";
        let id_project_selected = "";
        id_project_selected = $('#id_project option:selected').val() ?? "";
        if (id_type_selected == 1) {
            $('#goals_div').removeClass('d-none')
        } else {
            $('#goals_div').addClass('d-none')
        }
        $.ajax({
            url: '<?= base_url() ?>complaints/main/get_category',
            type: 'POST',
            data: {
                id_project: id_project_selected
            },
            dataType: 'json',
            beforeSend: function() {
                $('#id_category').closest('.ui .dropdown').addClass('loading disabled');
            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            $('#id_category').closest('.ui .dropdown').removeClass('loading disabled');
            list_category = '<option value="">Choose Category</option>';
            for (let index = 0; index < response.length; index++) {
                list_category += `<option value="${response[index].id_category}" data-escalation_by="${response[index].escalation_by}" data-escalation_name="${response[index].escalation_name}">${response[index].category}</option>`;
            }
            $("#id_category").empty().append(list_category);
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Category")
        });
    }

    let category_element = document.getElementById("id_category");
    category_element.addEventListener("change", function() {

        id_type = $('#id_type').val();
        id_category = $('#id_category').val();
        escalation_by = $("#id_category").find("option:selected").attr('data-escalation_by') ?? '';
        escalation_name = $("#id_category").find("option:selected").attr('data-escalation_name') ?? '';
        $('#escalation_by').val(escalation_by);
        $('#escalation_name').val(escalation_name);
    });

    function get_category_detail() {
        $.ajax({
            url: '<?= base_url() ?>complaints/main/get_category',
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {
                $('#id_category_detail').closest('.ui .dropdown').addClass('loading disabled');
            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            $('#id_category_detail').closest('.ui .dropdown').removeClass('loading disabled');
            list_category = '<option value="">Choose Category</option>';
            for (let index = 0; index < response.length; index++) {
                list_category += `<option value="${response[index].id_category}" data-escalation_by="${response[index].escalation_by}" data-escalation_name="${response[index].escalation_name}">${response[index].category}</option>`;
            }
            $("#id_category_detail").empty().append(list_category);
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Category")
        });
    }

    let category_element_detail = document.getElementById("id_category_detail");
    category_element_detail.addEventListener("change", function() {

        escalation_by = $("#id_category_detail").find("option:selected").attr('data-escalation_by') ?? '';
        escalation_name = $("#id_category_detail").find("option:selected").attr('data-escalation_name') ?? '';
        $('#escalation_by_detail').val(escalation_by);
        $('#escalation_name_detail').val(escalation_name);
    });
</script>
<!-- Category End -->

<!-- Requester Start -->
<script>
    get_requester();

    function get_requester() {
        let user_id = "<?= $this->session->userdata('user_id'); ?>";
        let designation_id = "<?= $this->session->userdata('designation_id'); ?>";
        $.ajax({
            url: '<?= base_url() ?>complaints/main/get_requester',
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
            // console.log(designation_id)
            if (array_designation_id.includes(designation_id)) {
                // console.log('true')
                $('#div_id_requester').removeClass('d-none');
            } else {
                // console.log('false')
                $('#div_id_requester').addClass('d-none');
            }
            // sel_id_requester.update();
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Requester")
        });
    }
</script>
<!-- /Requester End -->

<!-- PIC Start -->
<script>
    // let sel_id_pic = new SlimSelect({
    //     select: '#id_pic'
    // });


    function get_pic(id_type) {
        $.ajax({
            url: '<?= base_url() ?>complaints/main/get_pic',
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
            // array_list_pic = [];
            // for (let index = 0; index < response.length; index++) {
            //     array_list_pic.push({
            //         text: response[index].pic,
            //         value: response[index].id_pic
            //     })
            // }
            // sel_id_pic.setData(array_list_pic);
            list_pic = '<option value="">Choose PIC</option>';
            if (response != null) {
                for (let index = 0; index < response.length; index++) {
                    if (response[index].ticket == 0) {
                        ticket_onprogress = '';
                    } else {
                        ticket_onprogress = '(' + response[index].ticket + ' progress)';
                    }
                    list_pic += `<option value="${response[index].id_pic}">${response[index].pic} ${ticket_onprogress}</option>`;
                }
            }
            $('#id_pic').empty().append(list_pic);
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }

    // let e_sel_id_pic = new SlimSelect({
    //     select: '#e_id_pic'
    // });

    function e_get_pic(e_id_category = '', e_id_pic = '') {
        $.ajax({
            url: '<?= base_url() ?>complaints/main/get_pic',
            type: 'POST',
            dataType: 'json',
            data: {
                id_category: e_id_category
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
            user_id = "<?= $this->session->userdata('user_id'); ?>"
            list_pic = '<option value="">Choose PIC</option>';
            if (response != null) {
                for (let index = 0; index < response.length; index++) {
                    if (response[index].ticket == 0) {
                        ticket_onprogress = '';
                    } else {
                        ticket_onprogress = '(' + response[index].ticket + ' ticket)';

                    }
                    list_pic += `<option value="${response[index].id_pic}">${response[index].pic} ${ticket_onprogress}</option>`;
                }
            }
            $("#e_id_pic").empty().append(list_pic);
            $("#e_id_pic").dropdown_se('clear');
            if (e_id_pic != '') {
                $.each(e_id_pic.split(","), function(i, e) {
                    $("#e_id_pic option[value='" + e + "']").prop("selected", true);
                    $("#e_id_pic").dropdown_se('set selected', e);
                });
            }
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }
</script>
<!-- PIC End -->



<!-- Priority Start -->
<script>
    get_priority()

    function get_priority() {
        $.ajax({
            url: '<?= base_url() ?>complaints/main/get_priority',
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
            list_priority = '<option value="">Choose Priority</option>';
            for (let index = 0; index < response.length; index++) {
                list_priority += `<option value="${response[index].id_priority}">${response[index].priority}</option>`;
            }
            $("#id_priority").empty().append(list_priority);
            $("#id_priority").val(4)
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }


    // let e_sel_id_priority = NiceSelect.bind(document.getElementById('e_id_priority'), {
    //     searchable: false
    // });

    function e_get_priority(id_priority = '') {
        $.ajax({
            url: '<?= base_url() ?>complaints/main/get_priority',
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
                list_priority += `<option value="${response[index].id_priority}" ${response[index].id_priority == id_priority ? 'selected':''}>${response[index].priority}</option>`;
            }
            $("#e_id_priority").empty().append(list_priority)
            $('#e_id_priority').dropdown_se('set selected', id_priority);
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }
</script>
<!-- Priority End -->


<!-- Level Start -->
<script>
    e_get_level()

    function e_get_level(id_level = '') {
        $.ajax({
            url: '<?= base_url() ?>complaints/main/get_level',
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
                list_level += `<option value="${response[index].id_level}" ${response[index].id_level == id_level ? 'selected':''}>${response[index].level}</option>`;
            }
            $("#e_id_level").empty().append(list_level)
            $('#e_id_level').dropdown_se('set selected', id_level);
        }).fail(function(jqXhr, textStatus) {
            console.log("Failed Get Type")
        });
    }
</script>
<!-- Level End -->

<!-- On Select Project Set Project Name -->
<script>
    function select_project() {
        project = $('#id_project option:selected').text();
        $('#project').val(project);
    }
    function select_project_detail() {
        project = $('#id_project_detail option:selected').text();
        $('#project_detail').val(project);
    }
</script>
<!-- On Select Project Set Project Name -->


<!-- Task Start -->
<script>
    function save_task() {
        page_uri = '<?= $this->uri->segment(4); ?>';
        let val_id_project = $('#id_project').val() ?? "";
        let val_project = $('#id_project option:selected').text();
        let val_id_category = $('#id_category').val() ?? "";
        let val_blok = $('#blok').val() ?? "";
        let val_konsumen = $('#konsumen').val() ?? "";
        let val_head_requester_id = $('#head_requester_id').val() ?? "";
        let val_head_requester_name = $('#head_requester_name').val() ?? "";
        let val_escalation_by = $('#escalation_by').val() ?? "";
        let val_escalation_name = $('#escalation_name').val() ?? "";
        let val_task = $('#task').val() ?? "";
        let val_description = $('#description').val() ?? "";
        let val_pekerjaan = $('#pekerjaan').val() ?? "";
        let val_sub_pekerjaan = $('#sub_pekerjaan').val() ?? "";
        let val_detail_pekerjaan = $('#detail_pekerjaan').val() ?? "";

        let val_foto = $("input[name='file[]']");

        if (val_id_project == "" || val_project == "") {
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
                content: 'Oops, category complaints must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_blok == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, blok must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_escalation_by == "") {
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
        } else if (val_escalation_name == "") {
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
        } else if (val_konsumen == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Konsumen must be filled',
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
        } else if (val_foto.length == 0) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, file complain must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if ($('#ceklis_pekerjaan').is(':checked') && val_pekerjaan == "" || $('#ceklis_pekerjaan').is(':checked') && val_sub_pekerjaan == "" || $('#ceklis_pekerjaan').is(':checked') && val_detail_pekerjaan == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Input Pekerjaan, Sub Pekerjaan, dan Detail harus di pilih!',
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
                    // let file_data = $("#file_complaints").prop("files")[0];
                    // let form_data_ticket = new FormData();
                    // form_data_ticket.append("id_project", val_id_project);
                    // form_data_ticket.append("project", val_project);
                    // form_data_ticket.append("blok", val_blok);
                    // form_data_ticket.append("konsumen", val_konsumen);
                    // form_data_ticket.append("id_category", val_id_category);
                    // form_data_ticket.append("head_requester_id", val_head_requester_id);
                    // form_data_ticket.append("head_requester_name", val_head_requester_name);
                    // form_data_ticket.append("escalation_by", val_escalation_by);
                    // form_data_ticket.append("escalation_name", val_escalation_name);
                    // form_data_ticket.append("task", val_task);
                    // form_data_ticket.append("description", val_description);
                    // form_data_ticket.append("file_complaints", file_data);
                    form = $('#form_complaint');
                    $.ajax({
                        url: `<?= base_url() ?>complaints/main/save_task`,
                        // cache: false,
                        // contentType: false,
                        // processData: false,
                        // data: form_data_ticket, // Setting the data attribute of ajax with file_data
                        data: form.serialize(), // Setting the data attribute of ajax with file_data
                        type: 'POST',
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
                                dt_complaints();
                            } else if (uri_segment_view == "kanban") {
                                kanban_data();
                            }

                            generate_progress_bar()
                            setTimeout(() => {
                                jconfirm.instances[0].close();
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan verifikasi ke <b>${response.head_request_name}</b>`
                                });
                            }, 250);
                        } else {
                            $('#modal_add_task').modal('hide');
                            if (uri_segment_view == "table") {
                                dt_complaints();
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
    // let e_sel_id_status = NiceSelect.bind(document.getElementById('e_id_status'), {
    //     searchable: true
    // });

    $('#e_id_status').change(function() {
        let statusVal = $(this).val();
        var status_old = $('#e_id_status_old').val();
        console.log(statusVal + ' ' + status_old);

        $('#div_e_evidence').addClass('d-none');
        if (statusVal == "1" || statusVal == "2") {

        } else if (statusVal == "4" && status_old == "4") {
            $('#div_e_evidence').removeClass('d-none');
        } else if (statusVal == "4" && status_old == "8") {
            $('#div_e_evidence').removeClass('d-none');
            // $('#div_e_timeline').addClass('d-none');
        } else if (statusVal == "6") {
            $('#div_e_evidence').removeClass('d-none');
            $('#e_progress').val(100);
            $('#div_e_timeline').addClass('d-none');
        } else if (statusVal == "8" || statusVal == "9") {
            $('#div_e_timeline').removeClass('d-none');
            $('#div_e_evidence').removeClass('d-none');
        } else {
            // $('#e_progress').val(0);
        }
    });


    $('#modal_detail_task').on('hidden.bs.modal', function() {
        // do something…
        page_uri = "<?= $this->uri->segment(4); ?>";
        if (page_uri == "kanban") {
            kanban_data();
        }

    })



    function get_attachment_detail_page(id_task) {
        body_files_page = '';
        base_url = "https://trusmiverse.com/apps/uploads/complaints";
        $.ajax({
            url: "<?= base_url('complaints/main/get_attachment') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                id_task: id_task,
            },
            beforeSend: function() {},
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
                            img_file_div = `<div class="h-150 coverimg" style="background-image: url(&quot;<?= base_url() ?>uploads/complaints/${value.file}&quot;);">
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
                                                    <a href="<?= base_url() ?>uploads/complaints/${value.file}" target="_blank" class="avatar avatar-30 rounded text-red mr-3">
                                                        <i class="bi bi-download h5 vm"></i>
                                                    </a>
                                                </div>
                                                <div class="col-12 col-md-10 text-start">
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
                $('#body_files_page_detail').html(body_files_page)
            },
            complete: function() {}
        })

    }

    function detail_task(id_task) {
        $('#id_task_new_strategy').val(id_task);
        $('#e_id_status').dropdown_se('clear');
        $('#e_id_level').dropdown_se('clear');
        $('#e_id_pic').dropdown_se('set selected', '');
        $('#e_pic_note').val('');
        $('#e_escalation_note').val('');
        $('#e_verified_note').val('');
        $('#id_project_detail').dropdown_se('clear');
        $('#blok_detail').dropdown_se('clear');
        $.confirm({
            icon: 'fa fa-spinner fa-spin',
            title: 'Please wait..',
            theme: 'material',
            type: 'blue',
            content: 'Loading...',
            animateFromElement: false,
            animation: 'RotateXR',
            closeAnimation: 'RotateXR',
            buttons: {
                close: {
                    isHidden: true,
                    actions: function() {}
                },
            },
            onOpen: function() {
                $.ajax({
                    url: `<?= base_url() ?>complaints/main/get_detail_task_new`,
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
                    console.log(response.detail)
                    if (response.status == true) {
                        jconfirm.instances[0].close();
                        $('#modal_detail_task').modal('show');
                        $('#e_id_status_old').val(response.detail.id_status);

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
                        if (response.detail.id_status == 4) {
                            $('#div_e_evidence').removeClass('d-none');
                        } else {
                            $('#div_e_evidence').addClass('d-none');
                        }

                        // if (response.detail.id_pic.includes(user_id)) {
                        //     $('#footer-update').removeClass('d-none');
                        // } else {
                        //     $('#footer-update').addClass('d-none');
                        // }



                        // Text Info
                        $('#e_object_text').text(response.detail.object);
                        $('#e_due_date_text').html(response.detail.due_date_2);
                        $('#e_timeline_text').text(response.detail.timeline);
                        $('#e_description_text').html(response.detail.description);
                        $('#e_type_text').html(response.detail.type).removeClass().addClass('badge bg-light-pink text-dark');
                        $('#e_category_second_title').html(response.detail.category);
                        $('#e_project_text').html(response.detail.project).removeClass().addClass('badge bg-light-yellow text-dark');
                        $('#e_blok_text').html(response.detail.blok).removeClass().addClass('badge bg-light-yellow text-dark');
                        $('#e_category_text').html(response.detail.category).removeClass().addClass('badge bg-light-yellow text-dark');
                        if (response.detail.tgl_aftersales != '-') {
                            $('#e_tgl_aftersales').html(`${response.detail.tgl_aftersales} (${response.detail.id_after_sales})`).removeClass().addClass('badge bg-light-yellow text-dark');
                        } else {
                            $('#e_tgl_aftersales').html(`${response.detail.tgl_aftersales}`).removeClass().addClass('badge bg-light-yellow text-dark');
                        }
                        $('#e_priority_text').html(response.detail.priority).removeClass().addClass('badge ' + response.detail.priority_color);
                        $('#e_level_text').html(response.detail.level).removeClass().addClass('badge ' + response.detail.level_color);
                        $('#e_status_text').html(response.detail.status).removeClass().addClass('badge ' + response.detail.status_color);
                        $('#e_requested_by_text').html(`<span class="badge bg-light-purple text-dark" style="margin-bottom: 3px;">${response.detail.requested_by}</span><br><span class="badge bg-light-yellow text-dark">${response.detail.requested_contact_no}</span> <a class="badge bg-light-green text-green" href="https://api.whatsapp.com/send?phone=${response.detail.requested_contact_no}" onclick="follow_up('${id_task}');" target="_blank"><i class="bi bi-whatsapp text-success"></i> Chat</a>`);
                        $('#e_requested_at_text').html(`<span class="badge bg-light-red text-dark">${response.detail.tgl_dibuat} | ${response.detail.jam_dibuat} WIB</span>`);

                        $('#e_verified_by_text').html(`<span class="badge bg-light-purple text-dark" style="margin-bottom: 3px;">${response.detail.verified_by}</span><br><span class="badge bg-light-yellow text-dark">${response.detail.verified_contact_no}</span> <a class="badge bg-light-green text-green" href="https://api.whatsapp.com/send?phone=${response.detail.verified_contact_no}" target="_blank"><i class="bi bi-whatsapp text-success"></i> Chat</a>`);

                        if (response.detail.tgl_verified != '') {
                            $('#e_verified_at_text').html(`<span class="badge bg-light-red text-dark" style="margin-bottom: 3px;">${response.detail.tgl_verified} | ${response.detail.jam_verified} WIB</span>`);
                        } else {
                            $('#e_verified_at_text').html('<span class="badge bg-light-yellow text-dark">waiting</span>');
                        }
                        if (response.detail.tgl_escalation != '') {
                            $('#e_escalation_at_text').html(`<span class="badge bg-light-red text-dark">${response.detail.tgl_escalation} | ${response.detail.jam_escalation} WIB</span>`);
                        } else {
                            $('#e_escalation_at_text').html('<span class="badge bg-light-yellow text-dark">waiting</span>');
                        }
                        $('#e_escalation_by_text').html(`<span class="badge bg-light-purple text-dark" style="margin-bottom: 3px;">${response.detail.escalation_by}</span><br><span class="badge bg-light-yellow text-dark">${response.detail.escalation_contact_no}</span> <a class="badge bg-light-green text-green" href="https://api.whatsapp.com/send?phone=${response.detail.escalation_contact_no}" target="_blank"><i class="bi bi-whatsapp text-success"></i> Chat</a>`);

                        $('#e_requested_company_text').html(response.detail.requested_company);
                        $('#e_requested_department_text').html(response.detail.requested_department);
                        $('#e_requested_designation_text').html(response.detail.requested_designation);
                        $('#div_e_progress_text').empty().append(`
                            <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated ${response.detail.status_color}" role="progressbar" style="width: ${Math.round(response.detail.progress * 1) / 1}%;" aria-valuenow="${Math.round(response.detail.progress * 1) / 1}" aria-valuemin="0" aria-valuemax="100">${Math.round(response.detail.progress * 1) / 1}%</div>
                            </div>`);

                        // dt_detail_sub_task(id_task);
                        // get_timeline(id_task);

                        $('#detail_id_task').val(response.detail.id_task);
                        $('#modal_detail_task_label').text(response.detail.task);

                        $('#e_start_timeline').val(response.detail.start);
                        $('#e_end_timeline').val(response.detail.end);
                        $('#e_verified_note').val(response.detail.verified_note);
                        $('#e_escalation_note').val(response.detail.escalation_note);
                        $('#e_note').val('');
                        $('#e_progress').val(response.detail.progress);
                        // console.log(Math.round(response.detail.progress * 100) / 100);


                        $('#e_id_task').val(response.detail.id_task);
                        $('#e_task').val(response.detail.task);
                        $('#e_task_text').text(response.detail.task);

                        $('#e_description_div').html(response.detail.description);

                        if (response.detail.due_date != '') {
                            $('#e_due_date').val(response.detail.due_date);
                            $('#e_start_timeline').val(response.detail.start);
                            $('#e_end_timeline').val(response.detail.end);
                        }

                        // e_get_category(response.detail.id_type, response.detail.id_category);
                        e_get_priority(response.detail.id_priority);
                        e_get_pic(response.detail.id_category, response.detail.id_pic);
                        // e_get_level(response.detail.id_level);

                        $('#e_pic_text').text(response.detail.team_name);
                        console.log(response.detail.status_input);

                        // $('#e_id_status').val(response.detail.id_status);
                        // $('#e_id_status').dropdown_se('set selected', response.detail.id_status);
                        if (response.detail.id_status > 1) {
                            $('#e_id_status option[value="' + 1 + '"]').attr("disabled", true);
                        }
                        // e_sel_id_status.update();

                        page_uri = "<?= $this->uri->segment(4); ?>";
                        if (page_uri == "kanban") {
                            detail_status_after = $('#detail_status_after').val();
                            if (detail_status_after != "") {
                                $('#e_id_status').val(detail_status_after);
                                if (detail_status_after > 1) {
                                    $('#e_id_status option[value="' + 1 + '"]').attr("disabled", true);
                                }
                                // e_sel_id_status.update();
                            }
                        }

                        e_get_status(response.detail.id_status, response.detail.reschedule,response.detail.status_input);
                        // e_get_status(response.detail.id_status, response.detail.reschedule);

                        user_id = '<?= $this->session->userdata('user_id'); ?>';
                        console.log(user_id,response.detail.verified_user_id);
                        console.log('ini di detail');
                        if (
                            response.detail.id_status == 1 
                            // && user_id == response.detail.verified_user_id
                            && (user_id == '9189' || user_id == '4138') // Salma / Farhan
                        ) {
                            
                            $('#footer-update').removeClass('d-none')
                            $('#title_update').empty().text('Verifikasi')
                            $('#div_e_verified_note').removeClass('d-none')
                            $('#btn_update_task').removeAttr('onclick');
                            $('#btn_update_task').attr('onclick', 'update_verifikasi()');
                            $('#btn_update_task').text('Save Verifikasi');
                            $('#div_e_level').addClass('d-none')
                            $('#div_e_id_pic').addClass('d-none')
                            $('#div_e_timeline').addClass('d-none')
                            $('#div_e_escalation_note').addClass('d-none')
                            $('#div_e_progress').addClass('d-none')
                            $('#div_e_pic_note').addClass('d-none')
                            $('#div_e_id_category_detail').removeClass('d-none')
                            get_category_detail();

                        } else if (response.detail.id_status == 2 && user_id == response.detail.escalation_user_id || response.detail.escalation_user_id == null) {
                            $('#footer-update').removeClass('d-none')
                            $('#title_update').empty().text('Eskalasi')
                            $('#btn_update_task').removeAttr('onclick');
                            $('#btn_update_task').attr('onclick', 'update_eskalasi()');
                            $('#btn_update_task').text('Save Eskalasi');
                            $('#div_e_level').removeClass('d-none')
                            $('#div_e_id_pic').removeClass('d-none')
                            $('#div_e_timeline').removeClass('d-none')
                            $('#div_e_verified_note').addClass('d-none')
                            $('#div_e_escalation_note').removeClass('d-none')
                            $('#e_verified_note').attr('readonly', 'readonly')
                            $('#div_e_progress').addClass('d-none')
                            $('#div_e_id_status').removeClass('d-none')
                            $('#div_e_pic_note').addClass('d-none')

                            $('#div_e_id_category_detail').addClass('d-none')
                            $('#div_e_id_project_detail').addClass('d-none')
                            $('#div_e_blok_detail').addClass('d-none')


                        } else if ((response.detail.id_status == 4 || response.detail.id_status == 8 || response.detail.id_status == 9) && response.detail.id_pic.includes(user_id)) {
                            $('#footer-update').removeClass('d-none')
                            $('#title_update').empty().text('Pengerjaan')
                            $('#btn_update_task').removeAttr('onclick');
                            $('#btn_update_task').attr('onclick', 'update_pengerjaan()');
                            $('#btn_update_task').text('Save Pengerjaan');
                            $('#div_e_id_priority').addClass('d-none')
                            $('#div_e_level').addClass('d-none')
                            $('#div_e_id_pic').addClass('d-none')
                            $('#div_e_timeline').addClass('d-none')
                            $('#div_e_verified_note').addClass('d-none')
                            $('#div_e_escalation_note').addClass('d-none')
                            $('#e_verified_note').attr('readonly', 'readonly')
                            $('#e_escalation_note').attr('readonly', 'readonly')
                            $('#div_e_progress').removeClass('d-none')
                            $('#div_e_id_status').removeClass('d-none')
                            $('#div_e_pic_note').removeClass('d-none')

                            $('#div_e_id_category_detail').addClass('d-none')
                            $('#div_e_id_project_detail').addClass('d-none')
                            $('#div_e_blok_detail').addClass('d-none')
                        } else {
                            $('#footer-update').addClass('d-none')
                            $('#div_e_id_status').addClass('d-none')
                            $('#div_e_id_priority').addClass('d-none')
                            $('#div_e_progress').addClass('d-none')
                            $('#div_e_level').addClass('d-none')
                            $('#div_e_id_pic').addClass('d-none')
                            $('#div_e_timeline').addClass('d-none')
                            $('#div_e_verified_note').addClass('d-none')
                            $('#div_e_escalation_note').addClass('d-none')
                            $('#div_e_pic_note').addClass('d-none')

                            $('#div_e_id_category_detail').addClass('d-none')
                            $('#div_e_id_project_detail').addClass('d-none')
                            $('#div_e_blok_detail').addClass('d-none')
                        }
                        activateTab('comment');

                        get_attachment_detail_page(id_task);
                        // $('#id_category_detail').val('');
                        // $('#id_category_detail').dropdown('set selected', '');
                        if (
                            // user_id == 7804 
                            (user_id == '9189' || user_id == '4138') // Salma / Farhan
                            && response.detail.id_category == 18 && response.detail.id_status == 1) {
                            setTimeout(() => {
                                $('#id_category_detail').val(response.detail.id_category);
                                $('#id_category_detail').dropdown_se('set selected', response.detail.id_category);
                                escalation_by = $("#id_category_detail").find("option:selected").attr('data-escalation_by') ?? '';
                                escalation_name = $("#id_category_detail").find("option:selected").attr('data-escalation_name') ?? '';
                                $('#escalation_by_detail').val(escalation_by);
                                $('#escalation_name_detail').val(escalation_name);
                            }, 500);
                            $('#id_project_detail').val('');
                            $('#blok_detail').val('');

                            $('#div_e_id_project_detail').removeClass('d-none')
                            $('#div_e_blok_detail').removeClass('d-none')

                            get_project_detail();

                        } else {
                            $('#div_e_id_project_detail').addClass('d-none')
                            $('#div_e_blok_detail').addClass('d-none')
                        }
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

    function follow_up(id_task){
        $.ajax({
            url: 'https://trusmiverse.com/apps/complaints/main/follow_up',
            type: 'POST',
            dataType: 'json',
            data: { id_task: id_task },
            success: function(response) {
                console.log('follow up', response)
                // jconfirm.instances[0].close();
                // if (response.success) {
                //     $.toast({
                //         title: 'Success',
                //         showProgress: 'top',
                //         classProgress: 'blue',
                //         message: 'Follow up sent successfully.'
                //     });
                // } else {
                //     $.confirm({
                //         icon: 'fa fa-close',
                //         title: 'Oops!',
                //         theme: 'material',
                //         type: 'red',
                //         content: response.message || 'Failed to send follow up.',
                //         buttons: {
                //             close: {
                //                 actions: function() {}
                //             },
                //         },
                //     });
                // }
                $('#dt_complaints').DataTable().ajax.reload();
            }
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
            url: "<?= base_url('complaints/main/get_log_history') ?>",
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
        base_url = "https://trusmiverse.com/apps/uploads/complaints";
        $.ajax({
            url: "<?= base_url('complaints/main/get_attachment') ?>",
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
                            img_file_div = `<div class="h-150 coverimg" style="background-image: url(&quot;<?= base_url() ?>uploads/complaints/${value.file}&quot;);">
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
                                                    <a href="<?= base_url() ?>uploads/complaints/${value.file}" target="_blank" class="avatar avatar-30 rounded text-red mr-3">
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
            ajax.open("POST", "<?= base_url('complaints/main/upload_file') ?>", true);
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
            url: "<?= base_url('complaints/main/get_comment') ?>",
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
                url: `<?= base_url() ?>complaints/main/save_reply`,
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


    function hitung_lsa() {
        let lsa_id_pic = $("#e_id_pic").val();
        let lsa_id_sub_type = $("#e_id_category").find("option:selected").attr('data-id_sub_type');
        let lsa_id_priority = $("#e_id_priority").val();
        let lsa_id_level = $("#e_id_level").val();
        $.ajax({
            url: '<?= base_url() ?>complaints/main/check_lsa',
            type: 'POST',
            dataType: 'json',
            data: {
                id_pic: lsa_id_pic.toString(),
                id_sub_type: lsa_id_sub_type,
                id_priority: lsa_id_priority,
                id_level: lsa_id_level,
            },
            beforeSend: function() {
                $('#div_lsa').empty()
            },
            success: function(response) {

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            },
        }).done(function(response) {
            console.log(response)
            if (response.eskalasi_time != 0 && response.eksekusi_time != 0) {
                let eskalasi_convert_hour = SplitTime(response.eskalasi_time);
                let eksekusi_convert_hour = SplitTime(response.eksekusi_time);
                $('#div_lsa').empty().append(`
                                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                                        <div>
                                            <p>Eskalasi Time : ${eskalasi_convert_hour.Days + ' Hari ' + eskalasi_convert_hour.Hours + ' jam ' + eskalasi_convert_hour.Minutes + ' Menit'}</p>
                                            <p>Eksekusi Time : ${eksekusi_convert_hour.Days + ' Hari ' + eksekusi_convert_hour.Hours + ' jam ' + eksekusi_convert_hour.Minutes + ' Menit'}</p>
                                        </div>
                                    </div>`).hide().fadeIn();
                $('#e_due_date').val(response.due_date);
                $('#e_start_timeline').val(response.eksekusi_start);
                $('#e_end_timeline').val(response.eksekusi_end);
            }
        }).fail(function(jqXhr, textStatus) {

        });
    }

    function SplitTime(numberOfMinutes) {
        let Hours = numberOfMinutes % (24 * 60);
        let Days = Math.floor((numberOfMinutes / 60) / 24);
        let Minutes = numberOfMinutes % 60;
        return ({
            "Days": Days,
            "Hours": Hours,
            "Minutes": Minutes
        })
    }


    function update_verifikasi() {
        let val_e_id_task = $('#e_id_task').val() ?? "";
        let val_e_id_status = $('#e_id_status').val() ?? "";
        let val_e_id_priority = $('#e_id_priority').val() ?? "";
        let val_e_verified_note = $('#e_verified_note').val() ?? "";
        let val_category = $('#id_category_detail').val() ?? "";
        let val_id_project = $('#id_project_detail').val() ?? "";
        let val_project = $('#project_detail').val() ?? "";
        let val_blok = $('#blok_detail').val() ?? "";
        let user_id = "<?= $this->session->userdata('user_id'); ?>";
        let val_escalation_by = $('#escalation_by_detail').val() ?? "";
        let val_escalation_name = $('#escalation_name_detail').val() ?? "";

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
        } else if (val_e_id_priority == "" && val_e_id_status != '3') {
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
        } else if (val_e_verified_note == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, note must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } 
        else if (
            // user_id = 7804 
            user_id == '9189' // Salma
            && val_category == 18 && val_id_project == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, note must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (
            // user_id = 7804 
            user_id == '9189' // Salma
            && val_category == 18 && val_id_project == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, note must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } 
        else {
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
                        url: `<?= base_url() ?>complaints/main/update_verifikasi_new`,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id_task: val_e_id_task,
                            id_status: val_e_id_status,
                            id_priority: val_e_id_priority,
                            verified_note: val_e_verified_note,
                            id_category: val_category,
                            id_project: val_id_project,
                            project: val_project,
                            blok: val_blok,
                            escalation_by: val_escalation_by,
                            escalation_name: val_escalation_name
                        },
                        beforeSend: function() {

                        },
                        success: function(response) {},
                        error: function(xhr) {},
                        complete: function() {},
                    }).done(function(response) {
                        if (response.update_verifikasi == true) {
                            jconfirm.instances[0].close();
                            $('#modal_detail_task').modal('hide');
                            segment_uri = "<?= $this->uri->segment(4); ?>";
                            if (segment_uri == "table") {
                                dt_complaints();
                            } else {
                                kanban_data();
                            }
                            generate_progress_bar();
                            if (response.status == 2) {
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan approve verifikasi ke <b>${response.requester_name}</b>`
                                });
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan eskalasi ke <b>${response.escalation_name}</b>`
                                });
                            }

                            if (response.status == 3) {
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan reject ke <b>${response.requester_name}</b>`
                                });
                            }
                        } else {
                            jconfirm.instances[0].close();
                            $('#modal_detail_task').modal('hide');
                            segment_uri = "<?= $this->uri->segment(4); ?>";
                            if (segment_uri == "table") {
                                dt_complaints();
                            } else {
                                kanban_data();
                            }
                            generate_progress_bar();
                            setTimeout(() => {
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

        let val_e_id_type = '';
        let val_e_id_category = '';
        let val_e_id_object = '';
        console.log('status ' + val_e_id_status);
        if (val_e_id_status == '1') {
            val_e_id_type = $('#e_id_type').val();
            val_e_id_category = $('#e_id_category').val();
            val_e_id_object = $('#e_id_object').val();
        }

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
        } else if (val_e_id_pic.toString() == "") {
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
                        url: `<?= base_url() ?>complaints/main/update_task`,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id_task: val_e_id_task,
                            id_type: val_e_id_type,
                            id_category: val_e_id_category,
                            id_object: val_e_id_object,
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
                            $('#e_id_level').dropdown_se('set selected', '');
                            $('#e_id_priority').dropdown_se('set selected', '');
                            segment_uri = "<?= $this->uri->segment(4); ?>";
                            if (segment_uri == "table") {
                                dt_complaints();
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
                            dt_complaints();
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


    $('#e_due_date').on('change', function() {
        let due_date = $('#e_due_date').val();
        $('#e_end_timeline').val(due_date + ' 23:00:00');
    });




    function update_eskalasi() {
        let val_e_id_task = $('#e_id_task').val() ?? "";
        let val_e_id_status = $('#e_id_status').val() ?? "";
        let val_e_id_priority = $('#e_id_priority').val() ?? "";
        let val_e_id_level = $('#e_id_level').val() ?? "";
        let val_e_id_pic = $('#e_id_pic').val() ?? "";
        let val_e_escalation_note = $('#e_escalation_note').val() ?? "";
        let val_e_due_date = $('#e_due_date').val() ?? "";
        let val_e_start_timeline = $('#e_start_timeline').val() ?? "";
        let val_e_end_timeline = $('#e_end_timeline').val() ?? "";


        console.log(val_e_id_status);

        if (val_e_id_task == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, id task must be filled',
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
        } else if (val_e_id_priority == "" && val_e_id_status != 5) {
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
        } else if (val_e_id_level == "" && val_e_id_status != 5) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, level must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (val_e_id_pic.toString() == "" && val_e_id_status != 5) {
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
        } else if (val_e_due_date == "" && val_e_id_status != 5) {
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
        } else if (val_e_start_timeline == "" && val_e_id_status != 5) {
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
        } else if (val_e_end_timeline == "" && val_e_id_status != 5) {
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
        } else if (val_e_id_priority == "" && val_e_id_status != 5) {
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
        } else if (val_e_id_level == "" && val_e_id_status != 5) {
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
        } else if (val_e_escalation_note == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Escalation Note must be filled',
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
                        url: `<?= base_url() ?>complaints/main/update_eskalasi`,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id_task: val_e_id_task,
                            id_status: val_e_id_status,
                            id_priority: val_e_id_priority,
                            id_level: val_e_id_level,
                            id_pic: val_e_id_pic.toString(),
                            escalation_note: val_e_escalation_note,
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
                        if (response.update_eskalasi == true) {
                            jconfirm.instances[0].close();
                            $('#modal_detail_task').modal('hide');
                            $('#e_id_level').dropdown_se('set selected', '');
                            $('#e_id_priority').dropdown_se('set selected', '');
                            segment_uri = "<?= $this->uri->segment(4); ?>";
                            if (segment_uri == "table") {
                                dt_complaints();
                            } else {
                                kanban_data();
                            }
                            if (response.status == 4) {
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan eskalasi ke <b>${response.requester_name}</b>`
                                });
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan eskalasi ke <b>${response.pic_name}</b>`
                                });
                            }

                            if (response.status == 5) {
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan reject ke <b>${response.requester_name}</b>`
                                });
                            }
                        } else {
                            jconfirm.instances[0].close();
                            $('#modal_detail_task').modal('hide');
                            $('#e_id_level').dropdown_se('set selected', '');
                            $('#e_id_priority').dropdown_se('set selected', '');
                            segment_uri = "<?= $this->uri->segment(4); ?>";
                            if (segment_uri == "table") {
                                dt_complaints();
                            } else {
                                kanban_data();
                            }
                            setTimeout(() => {
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


    function update_pengerjaan() {
        let val_e_id_task = $('#e_id_task').val();
        let val_e_id_status = $('#e_id_status').val();
        let val_e_progress = $('#e_progress').val();
        let val_e_pic_note = $('#e_pic_note').val();
        let val_evidence = $('#evidence')[0].files[0];
        
        let show_evidence = ['4', '6', '8'];
        let formData = new FormData();
        formData.append('id_task', val_e_id_task);
        formData.append('id_status', val_e_id_status);
        formData.append('progress', val_e_progress);
        formData.append('pic_note', val_e_pic_note);

        // cek status apakah perlu reschedule
        if (parseInt(val_e_id_status) === 8 || parseInt(val_e_id_status) === 9) {
            formData.append('due_date', $('#e_due_date').val());
            formData.append('start_timeline', $('#e_start_timeline').val());
            formData.append('end_timeline', $('#e_end_timeline').val());
        }

        if ($('#evidence').val() != "") {
            formData.append('evidence', val_evidence);
        }


        if (val_e_id_task == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, id task must be filled',
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
        } else if (val_e_pic_note == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Note must be filled',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (show_evidence.includes(val_e_id_status) == true && $('#evidence').val() == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Evidence must be filled',
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
                        url: `<?= base_url() ?>complaints/main/update_pengerjaan`,
                        type: 'POST',
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        data: formData,
                        beforeSend: function() {

                        },
                        success: function(response) {},
                        error: function(xhr) {
                            console.log(xhr);

                        },
                        complete: function() {},
                    }).done(function(response) {
                        if (response.update_eskalasi == true) {
                            jconfirm.instances[0].close();
                            $('#modal_detail_task').modal('hide');
                            segment_uri = "<?= $this->uri->segment(4); ?>";
                            if (segment_uri == "table") {
                                dt_complaints();
                            } else {
                                kanban_data();
                            }
                            generate_progress_bar();
                            if (response.status == 6) {
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan done ke <b>${response.requester_name}</b>`
                                });
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan done ke <b>${response.escalation_name}</b>`
                                });
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan done ke <b>${response.head_pic_name}</b>`
                                });
                            }

                            if (response.status == 4) {
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Berhasil Update Complaints`
                                });
                            }

                            if (response.status == 7) {
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan unsolved ke <b>${response.requester_name}</b>`
                                });
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan unsolved ke <b>${response.escalation_name}</b>`
                                });
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan unsolved ke <b>${response.head_pic_name}</b>`
                                });
                            }


                            if (response.status == 8 || response.status == 9) {
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan reschedule ke <b>${response.requester_name}</b>`
                                });
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan reschedule ke <b>${response.escalation_name}</b>`
                                });
                                $.toast({
                                    title: 'success',
                                    showProgress: 'top',
                                    classProgress: 'blue',
                                    message: `Mengirim pesan reschedule ke <b>${response.head_pic_name}</b>`
                                });
                            }
                        } else {
                            jconfirm.instances[0].close();
                            $('#modal_detail_task').modal('hide');
                            segment_uri = "<?= $this->uri->segment(4); ?>";
                            if (segment_uri == "table") {
                                dt_complaints();
                            } else {
                                kanban_data();
                            }
                            generate_progress_bar();
                            setTimeout(() => {
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
                        url: `<?= base_url() ?>complaints/main/save_comment`,
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
                                    url: `<?= base_url() ?>complaints/main/resend_notif_request`,
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


<script>
    // main_header

    window.randomScalingFactor = function() {
        return Math.round(Math.random() * 20);
    }


    /* pink bar chart */
    var barchartblue2 = document.getElementById('barchartblue2').getContext('2d');
    var barchartpink2 = document.getElementById('barchartpink2').getContext('2d');
    var mybarchartpinkCofig = {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                    label: '',
                    data: [
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                    ],
                    backgroundColor: '#E50A8E',
                    borderWidth: 0,
                    borderRadius: 8,
                    borderSkipped: false,
                    barThickness: 6,
                },
                {
                    label: '',
                    data: [
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                    ],
                    backgroundColor: 'rgba(229, 10, 142, 0.15)',
                    borderWidth: 0,
                    borderRadius: 8,
                    borderSkipped: false,
                    barThickness: 6,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                },
            },
            scales: {
                y: {
                    display: false,
                    ticks: {
                        display: false,
                    },
                    drawBorder: false,
                    label: false,
                    grid: {
                        display: false,
                    }
                },
                x: {
                    display: false,
                    ticks: {
                        beginAtZero: false,
                        display: false,
                        color: '#999999',
                        font: {
                            size: 12,
                        },
                    },
                    grid: {
                        display: false,
                    },
                }
            }
        }
    }
    var mybarchartblueCofig = {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                    label: '',
                    data: [
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                    ],
                    backgroundColor: '#015ec2',
                    borderWidth: 0,
                    borderRadius: 8,
                    borderSkipped: false,
                    barThickness: 6,
                },
                {
                    label: '',
                    data: [
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                        randomScalingFactor(),
                    ],
                    backgroundColor: 'rgba(219,219,219,0.3)',
                    borderWidth: 0,
                    borderRadius: 8,
                    borderSkipped: false,
                    barThickness: 6,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                },
            },
            scales: {
                y: {
                    display: false,
                    ticks: {
                        display: false,
                    },
                    drawBorder: false,
                    label: false,
                    grid: {
                        display: false,
                    }
                },
                x: {
                    display: false,
                    ticks: {
                        beginAtZero: false,
                        display: false,
                        color: '#999999',
                        font: {
                            size: 12,
                        },
                    },
                    grid: {
                        display: false,
                    },
                }
            }
        }
    }
    var myBarChartblue2 = new Chart(barchartblue2, mybarchartblueCofig);
    var myBarChartpink2 = new Chart(barchartpink2, mybarchartpinkCofig);

    /* my area chart randomize */
    setInterval(function() {
        mybarchartpinkCofig.data.datasets.forEach(function(dataset) {
            dataset.data = dataset.data.map(function() {
                return randomScalingFactor();
            });
        });
        mybarchartblueCofig.data.datasets.forEach(function(dataset) {
            dataset.data = dataset.data.map(function() {
                return randomScalingFactor();
            });
        });
        myBarChartblue2.update();
        myBarChartpink2.update();
    }, 2000);
</script>



<!-- Js View Table  -->
<?php if ($this->uri->segment(4) != "") {
    $this->load->view('complaints/' . $this->uri->segment(4) . '/js');
} ?>