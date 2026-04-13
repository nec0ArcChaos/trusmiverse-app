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
<script type="text/javascript" src="<?= base_url() ?>assets/slimselect/slimselect.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<!-- script state awal -->
<script>

    $(document).ready(function() {
        // global uri
        id     = "<?= $id; ?>";

        detail_task(id);

        // console.log(id_task);

        // activateTab('ticket')

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


    });
</script>
<!-- /script state awal -->

<script>
    function timer(countDownDate) {
        var countDownDate = new Date(countDownDate).getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById("days").innerHTML = days;
            document.getElementById("hrs").innerHTML = hours
            document.getElementById("min").innerHTML = minutes
            document.getElementById("sec").innerHTML = seconds

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("timer").innerHTML = "Your Plan MoM is Overdue.";
            }
        }, 1000);
    }
</script>

<!-- Detail Task Start -->
<script>

    function detail_task(id) {
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
                    url: `<?= base_url() ?>mom_plan_bahan/get_detail_plan`,
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        id: id,
                    },
                    beforeSend: function() {

                    },
                    success: function(res) {
                        console.log(res);
                        $("#judul_plan").text(res.judul);
                        $("#tempat_plan").text(res.tempat);
                        $("#tanggal_plan").text(res.tgl);
                        $("#waktu_plan").text(res.waktu);
                        $("#peserta_plan").text(res.peserta);
                        $("#note_plan").text(res.note);
                        $("#created_by").text(res.created_by);
                        $("#created_at").text(res.created_at);
                        $("#created_location").text(res.created_location);
                        $("#created_company").text(res.created_company);
                        $("#created_department").text(res.created_department);
                        $("#created_designation").text(res.created_designation);
                        
                        $("#uploaded_by").text(res.uploaded_by);
                        $("#uploaded_at").text(res.uploaded_at);
                        $("#uploaded_designation").text(res.uploaded_designation);

                        $("#uploaded_status").text(res.uploaded_status);
                        $("#uploaded_status").addClass(res.uploaded_color);
                        $("#uploaded_progres").html(`<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated ${res.uploaded_color} text-white" role="progressbar" style="width: ${res.uploaded_progres}%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">${res.uploaded_progres}</div></div>`);
                        
                        $("#id_plan").val(res.id_plan);
                        $("#id_pic").val(res.pic);

                        timer(res.due_date_new);

                        $("#footer-update").show();
                        if (res.uploaded_progres == 100) {
                            $("#footer-update").hide();
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    },
                    complete: function() {
                        jconfirm.instances[0].close();
                    },
                });
            },

        });
    }

    function update_bahan() {
        let file = $('#file_bahan').val();
        let link = $('#link_bahan').val();
        
        let id_plan = $('#id_plan').val();
        let id_pic  = $('#id_pic').val();
        let note    = $('#note_bahan').val();

        if (file == "" && link == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, File and Link is empty !!',
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
                    let file_data = $("#file_bahan").prop("files")[0];
                    let form_bahan = new FormData();                    
                    form_bahan.append("id_plan", id_plan);
                    form_bahan.append("id_pic", id_pic);
                    form_bahan.append("file_bahan", file_data);
                    form_bahan.append("link_bahan", link);
                    form_bahan.append("note_bahan", note);

                    $.ajax({
                        url: `<?= base_url() ?>mom_plan_bahan/update_bahan`,
                        type: 'POST',
                        dataType: 'JSON',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_bahan,
                        beforeSend: function() {
                            $("#btn_update_bahan").attr("disabled","disabled");
                        },
                        success: function(res){
                            jconfirm.instances[0].close();
                            $.confirm({
                                icon: 'fa fa-check',
                                title: 'Done!',
                                theme: 'material',
                                type: 'blue',
                                content: 'Success!',
                                buttons: {
                                    close: function() {
                                        location.reload();
                                    }
                                },
                            });
                            console.log(res);
                            $("#btn_update_bahan").removeAttr("disabled");
                        },
                        error: function(xhr){
                            jconfirm.instances[0].close();
                            // $.confirm({
                            //     icon: 'fa fa-close',
                            //     title: 'Oops!',
                            //     theme: 'material',
                            //     type: 'red',
                            //     content: 'Failed!' + textStatus,
                            //     buttons: {
                            //         close: {
                            //             actions: function() {}
                            //         },
                            //     },
                            // });
                            console.log(xhr.responseText);
                        },
                        complete: function(){},
                    });
                },
            });
        }

    }
</script>
<!-- /Detail Task Start -->