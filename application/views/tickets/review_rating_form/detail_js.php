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

<script type="text/javascript" src="<?= base_url(); ?>assets/semantic/components/dropdown.js"></script>

<!-- script state awal -->
<script>

    $(document).ready(function() {
        // global uri
        id     = "<?= $id; ?>";

        detail_task(id);

        ip = new SlimSelect({
          select: "#impact"
        });

        $('.deadline').datetimepicker({
            format: 'Y-m-d',
            timepicker: false,
            scrollMonth: false,
            scrollInput: false,
            minDate: 0
        });

        $('#impact').change(function() {
            $('#list_impact').val($('#impact').val().join());
        });

        // $(".tanggal").mask('0000-00-00');

        // Stars
        /* 1. Visualizing things on Hover - See next part for action on click */
        $('#stars li').on('mouseover', function(){
            var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
        
            // Now highlight all the stars that's not after the current hovered star
            $(this).parent().children('li.star').each(function(e){
                if (e < onStar) {
                    $(this).addClass('hover');
                }
                else {
                    $(this).removeClass('hover');
                }
            });
        }).on('mouseout', function(){
            $(this).parent().children('li.star').each(function(e){
                $(this).removeClass('hover');
            });
        });        
        /* 2. Action to perform on click */
        $('#stars li').on('click', function(){
            var onStar = parseInt($(this).data('value'), 10); // The star currently selected
            var stars = $(this).parent().children('li.star');
            
            for (i = 0; i < stars.length; i++) {
                $(stars[i]).removeClass('selected');
            }
            
            for (i = 0; i < onStar; i++) {
                $(stars[i]).addClass('selected');
            }
        
            // JUST RESPONSE (Not needed)
            var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
            $('#rating_kesesuaian').val(ratingValue);            
        });
        // End Stars

        // Stars
        /* 1. Visualizing things on Hover - See next part for action on click */
        $('#stars_uiux li').on('mouseover', function(){
            var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
        
            // Now highlight all the stars that's not after the current hovered star
            $(this).parent().children('li.star').each(function(e){
                if (e < onStar) {
                    $(this).addClass('hover');
                }
                else {
                    $(this).removeClass('hover');
                }
            });
        }).on('mouseout', function(){
            $(this).parent().children('li.star').each(function(e){
                $(this).removeClass('hover');
            });
        });        
        /* 2. Action to perform on click */
        $('#stars_uiux li').on('click', function(){
            var onStar = parseInt($(this).data('value'), 10); // The star currently selected
            var stars = $(this).parent().children('li.star');
            
            for (i = 0; i < stars.length; i++) {
                $(stars[i]).removeClass('selected');
            }
            
            for (i = 0; i < onStar; i++) {
                $(stars[i]).addClass('selected');
            }
        
            // JUST RESPONSE (Not needed)
            var ratingValue = parseInt($('#stars_uiux li.selected').last().data('value'), 10);
            $('#rating_uiux').val(ratingValue);            
        });
        // End Stars


    });
</script>
<!-- /script state awal -->

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
                    url: `<?= base_url() ?>tickets/review_rating_form/get_detail_feedback`,
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        id: id,
                    },
                    beforeSend: function() {

                    },
                    success: function(res) {
                        console.log(res);

                        $("#status").text(res.status_review);
                        if (res.status_review == 'Done') {
                            $("#status").removeClass('badge bg-warning');
                            $("#status").addClass('badge bg-success');
                            $("#footer-update").hide();
                        } else {
                            $("#status").removeClass('badge bg-success');
                            $("#status").addClass('badge bg-warning');
                            $("#footer-update").show();
                        }

                        $("#id_task").val(res.id_task);

                        $("#usere").text(res.created_by);
                        $("#company").text(res.company);
                        $("#department").text(res.department);
                        $("#designation").text(res.designation);

                        $("#note_uat").text(res.note);

                        if (res.status == 0) {
                            sts = `<span class="small badge bg-danger text-white">Tidak Sesuai</span>`;
                        } else {
                            sts = `<span class="small badge bg-success text-white">Sesuai</span>`;
                        }

                        $("#status_uat").empty().append(sts);

                        $("#tgl_uat").text(res.created_at);

                        if (res.files != null) {
                            lampiran = `<a target="_blank" href="<?= base_url('uploads/tickets/'); ?>${res.files}" class="badge bg-green"><i class="bi bi-file-earmark-medical"></i></a> `;
                            // console.log(lampiran);
                            $("#lampiran_uat").empty().html(lampiran);                            
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

    function save_feedback() {

        ekspektasi          = $(`input[name="ekspektasi"]:checked`).length;
        rating_kesesuaian   = $('#rating_kesesuaian').val();
        rating_uiux         = $('#rating_uiux').val();
        saran               = $('#saran').val();
        kelengkapan_fitur   = $('#kelengkapan_fitur').val();
        kecepatan_akses     = $(`input[name="kecepatan_akses"]:checked`).length;
        impact              = $('#impact').val();

        // console.log(status_feedback);

        if (ekspektasi < 1) {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Ekspektasi is empty !!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (rating_kesesuaian == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Kesesuaian Data is empty !!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (rating_uiux == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, UI UX is empty !!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (saran == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Saran is empty !!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (kelengkapan_fitur == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Kelengkapan Fitur is empty !!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (kecepatan_akses == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Kecepatan Akses is empty !!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                },
            });
        } else if (impact == "") {
            $.confirm({
                icon: 'fa fa-close',
                title: 'Oops!',
                theme: 'material',
                type: 'red',
                content: 'Oops, Impact is empty !!',
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
                        url: `<?= base_url() ?>tickets/review_rating_form/save_feedback`,
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
    } // End

    // Compress File
	// function compress(file_upload, string, submit, wait, done) {

    //     $(wait).show();
    //     $(done).hide();
    //     $(submit).prop('disabled', true);

    //     const file = document.querySelector(file_upload).files[0];
    //     extension = file.name.substr((file.name.lastIndexOf('.') + 1));
    //     if (!file) return;
    //     const reader = new FileReader();
    //     reader.readAsDataURL(file);
    //     reader.onload = function(event) {
    //         const imgElement = document.createElement("img");
    //         imgElement.src = event.target.result;

    //         // if (extension == "jpg" || extension == "jpeg" || extension == "png" || extension == "gif") {
    //         //     imgElement.onload = function(e) {
    //         //         const canvas = document.createElement("canvas");

    //         //         if (e.target.width > e.target.height) {
    //         //             const MAX_WIDTH = 600;
    //         //             const scaleSize = MAX_WIDTH / e.target.width;
    //         //             canvas.width = MAX_WIDTH;
    //         //             canvas.height = e.target.height * scaleSize;
    //         //         } else {
    //         //             const MAX_HEIGHT = 600;
    //         //             const scaleSize = MAX_HEIGHT / e.target.height;
    //         //             canvas.height = MAX_HEIGHT;
    //         //             canvas.width = e.target.width * scaleSize;
    //         //         }

    //         //         const ctx = canvas.getContext("2d");
    //         //         ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);
    //         //         const srcEncoded = ctx.canvas.toDataURL(e.target, "image/jpeg");
    //         //         var g_string = extension + srcEncoded.substr(srcEncoded.indexOf(',') + 1);
    //         //         upload_foto(string, g_string, submit, wait, done);
    //         //     }
    //         // } else {
    //             var g_string = extension + ',' + event.target.result.substr(event.target.result.indexOf(',') + 1);
    //             upload_foto(string, g_string, submit, wait, done);
    //         // }
    //     }
    // }

    // function upload_foto(string, file, submit, wait, done) {
    //     $.ajax({
    //         url: '<?php echo base_url() ?>audit/feedback_temuan/file_upload',
    //         type: 'POST',
    //         dataType: 'json',
    //         data: {
    //             file: file
    //         },
    //     })
    //     .done(function(response) {
    //         console.log("success");
    //         $(string).val(response.file);
    //         $(wait).hide();
    //         $(done).show();
    //         $(submit).prop('disabled', false);

    //         class_img = string.replace('#attachment', '.img');
    //         $(class_img).empty().append('<i class="bi bi-card-image avatar avatar-40 bg-light-theme rounded"></i>');
    //         $(class_img).attr('href',`<?= base_url('/uploads/audit_temuan/'); ?>${response.file}`);
    //     })
    //     .fail(function() {
    //         console.log("error");
    //     })
    //     .always(function() {
    //         console.log("complete");
    //     });
    // }
</script>
<!-- /Detail Task Start -->