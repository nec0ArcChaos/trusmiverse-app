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

        // $('.tanggal').datetimepicker({
        //     format: 'Y-m-d',
        //     timepicker: false,
        //     scrollMonth: false,
        //     scrollInput: false,
        //     minDate: 0
        // });

        // $('.tanggal-menit').datetimepicker({
        //     format: 'Y-m-d H:i:s',
        //     timepicker: true,
        //     scrollMonth: false,
        //     scrollInput: false,
        //     minDate: 0
        // });

        $('.deadline').datetimepicker({
            format: 'Y-m-d',
            timepicker: false,
            scrollMonth: false,
            scrollInput: false,
            minDate: 0
        });

        // $(".tanggal").mask('0000-00-00');


    });
</script>
<!-- /script state awal -->

<script>
    // function timer(countDownDate) {
    //     var countDownDate = new Date(countDownDate).getTime();

    //     // Update the count down every 1 second
    //     var x = setInterval(function() {

    //         // Get today's date and time
    //         var now = new Date().getTime();

    //         // Find the distance between now and the count down date
    //         var distance = countDownDate - now;

    //         // Time calculations for days, hours, minutes and seconds
    //         var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    //         var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    //         var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    //         var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    //         // Display the result in the element with id="demo"
    //         document.getElementById("days").innerHTML = days;
    //         document.getElementById("hrs").innerHTML = hours
    //         document.getElementById("min").innerHTML = minutes
    //         document.getElementById("sec").innerHTML = seconds

    //         // If the count down is finished, write some text
    //         if (distance < 0) {
    //             clearInterval(x);
    //             document.getElementById("timer").innerHTML = "Your Plan MoM is Overdue.";
    //         }
    //     }, 1000);
    // }
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
                    url: `<?= base_url() ?>audit/feedback_temuan/get_detail_feedback`,
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        id: id,
                    },
                    beforeSend: function() {

                    },
                    success: function(res) {
                        // console.log(res);
                        $("#auditee").text(res.employee_name);
                        $("#company").text(res.company_name);
                        $("#department").text(res.department_name);
                        $("#designation").text(res.designation_name);

                        $("#temuan").text(res.temuan);
                        $("#category").text(res.category);
                        $("#level_temuan").text(res.level_temuan);
                        
                        $("#tanggal_kejadian").text(res.tanggal_kejadian);
                        $("#alat_bukti").text(res.alat_bukti);

                        if (res.lampiran != null) {
                            lpr = res.lampiran.split(', ');
                            lampiran = "";
                            for (let i = 0; i < lpr.length; i++) {
                                const element = lpr[i];
                                lampiran += `<a target="_blank" href="<?= base_url('uploads/audit_temuan/'); ?>${element}" class="badge bg-green"><i class="bi bi-file-earmark-medical"></i></a> `;
                            }
                            // console.log(lampiran);
                            $("#lampiran").empty().html(lampiran);                            
                        }

                        $("#auditor_by").text(res.auditor);
                        $("#auditor_at").text(res.auditor_at);
                        $("#auditor_designation").text(res.auditor_designation);

                        $("#status").text(res.status);
                        $("#status").addClass(`bg-${res.status_color}`);
                        if (res.id_status == 1) { // Waiting Feedback
                            $("#progres").html(`<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-warning text-white" role="progressbar" style="width: 0%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">0</div></div>`);
                            $("#status_feedback").val('#');
                        } else {
                            $("#progres").html(`<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-success text-white" role="progressbar" style="width: 100%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">100</div></div>`);
                            $("#status_feedback").val(res.id_status);
                            
                            $('.img_feedback').empty().append('<i class="bi bi-file-earmark-text avatar avatar-40 bg-light-theme rounded"></i>');
                            $('.img_feedback').attr('href',`<?= base_url('/uploads/audit_temuan/'); ?>${res.lampiran_feedback}`);

                            $('.img_corrective').empty().append('<i class="bi bi-file-break avatar avatar-40 bg-light-theme rounded"></i>');
                            $('.img_corrective').attr('href',`<?= base_url('/uploads/audit_temuan/'); ?>${res.lampiran_corrective}`);

                            $('.img_preventive').empty().append('<i class="bi bi-file-earmark-zip avatar avatar-40 bg-light-theme rounded"></i>');
                            $('.img_preventive').attr('href',`<?= base_url('/uploads/audit_temuan/'); ?>${res.lampiran_preventif}`);
                        }
                        
                        $("#id_temuan").val(res.id_temuan);

                        if (res.id_status == 6) { // Banding
                            $("#hidden_banding").hide();
                        } else {
                            $("#hidden_banding").show();
                        }

                        $("#feedback").val(res.feedback);
                        
                        $("#status_corrective").val(res.status_corrective);
                        $("#action_corrective").val(res.corrective);
                        $("#deadline_corrective").val(res.deadline_corrective);
                        
                        $("#status_preventive").val(res.status_preventif);
                        $("#action_preventive").val(res.preventif);
                        $("#deadline_preventive").val(res.deadline_preventif);

                        // Jika Sudah di Feedback dan Leadtime lebih dari 1 hari maka Tidak bisa edit Feedback
                        // atau Sudah di Feedback dan Auditor sudah beri keterangan maka Tidak bisa edit Feedback
                        if ((res.leadtime_feedback > 1 && res.id_status != 1) || res.keterangan_pic != "") {
                            $("#btn_save_feedback").hide();
                            $(".change_disabled").attr('disabled',true);
                        } else {
                            $("#btn_save_feedback").show();
                            $(".change_disabled").removeAttr('disabled');
                        }


                        // timer(res.due_date_new);

                        // $("#footer-update").show();
                        // if (res.uploaded_progres == 100) {
                        //     $("#footer-update").hide();
                        // }
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

    function change_status()
    {
        sts = $("#status_feedback").val();
        if (sts == 6) { // Banding
            $("#hidden_banding").hide();
        } else {
            $("#hidden_banding").show();
        }
    }

    function save_feedback() {
        let feedback                = $('#feedback').val();
        let status_feedback         = $('#status_feedback').val();
        let attachment_feedback     = $('#attachment_feedback').val();
        let status_corrective       = $('#status_corrective').val();
        let action_corrective       = $('#action_corrective').val();
        let deadline_corrective     = $('#deadline_corrective').val();
        let attachment_corrective   = $('#attachment_corrective').val();
        let status_preventive       = $('#status_preventive').val();
        let action_preventive       = $('#action_preventive').val();
        let deadline_preventive     = $('#deadline_preventive').val();
        let attachment_preventive   = $('#attachment_preventive').val();

        // console.log(status_feedback);

        if (feedback == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Feedback is empty !!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (status_feedback == null) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Status Feedback is empty !!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        // Attachment Disable Semua, 25/04/2024 | Faisal
        // } else if (attachment_feedback == "") {
        //     $.confirm({
        //         icon: 'fa fa-close',
        //         title: 'Oops!',
        //         theme: 'material',
        //         type: 'red',
        //         content: 'Oops, Attachment Feedback is empty !!',
        //         buttons: {
        //             close: {
        //                 actions: function() {}
        //             },
        //         },
        //     });
        } else if (status_corrective == null && status_feedback != "6") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Status Corrective is empty !!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (action_corrective == "" && status_feedback != "6") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Action Corrective is empty !!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (deadline_corrective == "" && status_feedback != "6") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Deadline Corrective is empty !!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        // } else if (attachment_corrective == "" && status_feedback != "6") {
        //     $.confirm({
        //         icon: 'fa fa-close',
        //         title: 'Oops!',
        //         theme: 'material',
        //         type: 'red',
        //         content: 'Oops, Attachment Corrective is empty !!',
        //         buttons: {
        //             close: {
        //                 actions: function() {}
        //             },
        //         },
        //     });
        } else if (status_preventive == null && status_feedback != "6") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Status Preventive is empty !!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (action_preventive == "" && status_feedback != "6") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Action Preventive is empty !!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (deadline_preventive == "" && status_feedback != "6") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Deadline Preventive is empty !!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        // } else if (attachment_preventive == "" && status_feedback != "6") {
        //     $.confirm({
        //         icon: 'fa fa-close',
        //         title: 'Oops!',
        //         theme: 'material',
        //         type: 'red',
        //         content: 'Oops, Attachment Preventive is empty !!',
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
                        url: `<?= base_url() ?>audit/feedback_temuan/save_feedback`,
                        type: 'POST',
                        dataType: 'JSON',
                        data: $("#form_feedback").serialize(),
                        beforeSend: function() {
                            $("#btn_save_feedback").attr("disabled","disabled");
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
                            $("#btn_save_feedback").removeAttr("disabled");
                        },
                        error: function(xhr){
                            jconfirm.instances[0].close();
                            console.log(xhr.responseText);
                        },
                        complete: function(){},
                    });
                },
            });
        }

    }    

    // Compress File
	function compress(file_upload, string, submit, wait, done) {

        $(wait).show();
        $(done).hide();
        $(submit).prop('disabled', true);

        const file = document.querySelector(file_upload).files[0];
        extension = file.name.substr((file.name.lastIndexOf('.') + 1));
        if (!file) return;
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function(event) {
            const imgElement = document.createElement("img");
            imgElement.src = event.target.result;

            // if (extension == "jpg" || extension == "jpeg" || extension == "png" || extension == "gif") {
            //     imgElement.onload = function(e) {
            //         const canvas = document.createElement("canvas");

            //         if (e.target.width > e.target.height) {
            //             const MAX_WIDTH = 600;
            //             const scaleSize = MAX_WIDTH / e.target.width;
            //             canvas.width = MAX_WIDTH;
            //             canvas.height = e.target.height * scaleSize;
            //         } else {
            //             const MAX_HEIGHT = 600;
            //             const scaleSize = MAX_HEIGHT / e.target.height;
            //             canvas.height = MAX_HEIGHT;
            //             canvas.width = e.target.width * scaleSize;
            //         }

            //         const ctx = canvas.getContext("2d");
            //         ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);
            //         const srcEncoded = ctx.canvas.toDataURL(e.target, "image/jpeg");
            //         var g_string = extension + srcEncoded.substr(srcEncoded.indexOf(',') + 1);
            //         upload_foto(string, g_string, submit, wait, done);
            //     }
            // } else {
                var g_string = extension + ',' + event.target.result.substr(event.target.result.indexOf(',') + 1);
                upload_foto(string, g_string, submit, wait, done);
            // }
        }
    }

    function upload_foto(string, file, submit, wait, done) {
        $.ajax({
            url: '<?php echo base_url() ?>audit/feedback_temuan/file_upload',
            type: 'POST',
            dataType: 'json',
            data: {
                file: file
            },
        })
        .done(function(response) {
            console.log("success");
            $(string).val(response.file);
            $(wait).hide();
            $(done).show();
            $(submit).prop('disabled', false);

            class_img = string.replace('#attachment', '.img');
            $(class_img).empty().append('<i class="bi bi-card-image avatar avatar-40 bg-light-theme rounded"></i>');
            $(class_img).attr('href',`<?= base_url('/uploads/audit_temuan/'); ?>${response.file}`);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }
</script>
<!-- /Detail Task Start -->