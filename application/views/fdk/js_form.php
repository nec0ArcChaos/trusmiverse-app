<!-- Required jquery and libraries -->
<script src="<?= base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
<script src="<?= base_url(); ?>assets/js/popper.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/bootstrap-5/dist/js/bootstrap.bundle.js"></script>


<!-- Customized jquery file  -->
<script src="<?= base_url(); ?>assets/js/main.js"></script>
<script src="<?= base_url(); ?>assets/js/color-scheme.js"></script>

<!-- date range picker -->
<script src="<?= base_url(); ?>assets/js/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/daterangepicker/daterangepicker.js"></script>

<!-- chosen script -->
<script src="<?= base_url(); ?>assets/vendor/chosen_v1.8.7/chosen.jquery.min.js"></script>

<!-- Chart js script -->
<script src="<?= base_url(); ?>assets/vendor/chart-js-3.3.1/chart.min.js"></script>

<!-- Progress circle js script -->
<script src="<?= base_url(); ?>assets/vendor/progressbar-js/progressbar.min.js"></script>

<!-- swiper js script -->
<script src="<?= base_url(); ?>assets/vendor/swiper-7.3.1/swiper-bundle.min.js"></script>

<!-- Simple lightbox script -->
<script src="<?= base_url(); ?>assets/js/simple-lightbox.jquery.min.js"></script>

<!-- app tour script-->
<script src="<?= base_url(); ?>assets/js/lib.js"></script>

<!-- data-table js -->
<script src="<?= base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.3.1/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/js/dataTables.bootstrap5.min.js"></script>

<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>

<!-- fancybox -->
<script src="<?php echo base_url() ?>assets/fancybox/jquery.fancybox.min.js"></script>

<!-- Pnotify -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/pnotify/js/pnotify.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/pnotify/js/pnotify.buttons.js">
</script>

<!-- page level script -->
<script src="<?= base_url(); ?>assets/vendor/smartWizard/jquery.smartWizard.min.js"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>



<script>
    //* swiper slider *//
    var swiper2 = new Swiper(".swiperauto", {
        loop: true,
        freeMode: true,
        spaceBetween: 0,
        grabCursor: true,
        slidesPerView: 1,
        loop: true,
        autoplay: {
            delay: 1,
            disableOnInteraction: true,
        },
        freeMode: true,
        speed: 5000,
        freeModeMomentum: false,
    });
</script>
<script>
    (function($) {
        $.fn.inputFilter = function(callback, errMsg) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop focusout", function(e) {
                if (callback(this.value)) {
                    // Accepted value
                    if (["keydown", "mousedown", "focusout"].indexOf(e.type) >= 0) {
                        $(this).removeClass("input-error");
                        this.setCustomValidity("");
                    }
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    // Rejected value - restore the previous one
                    $(this).addClass("input-error");
                    this.setCustomValidity(errMsg);
                    this.reportValidity();
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    // Rejected value - nothing to restore
                    this.value = "";
                }
            });
        };
    }(jQuery));

    $(document).ready(function() {
        
        // $('.example-popover').popover({
        //     container: 'body'
        // })
    });


    // Running Datepicker
    $('.tanggal').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
    document.addEventListener('DOMContentLoaded', function () {
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl, {
                html: true // Enable HTML content in popover
            })
        })
    });






    $(".tgl").mask('0000-00-00')

    $("#file").on("change", function() {
        console.log($(this).val())
    });



    let options = {
        searchable: true
    }


    $('#button-4').on('click', function() {
        $.confirm({
            title: 'Alert!',
            content: 'Apakah anda yakin ?',
            type: 'red',
            theme: 'supervan',
            typeAnimated: true,
            closeIcon: false, // explicitly show the close icon
            animation: 'opacity',
            // closeAnimation: 'scale',
            // animationBounce: 1.5,
            buttons: {
                close: function() {},
                tryAgain: {
                    text: 'Try again',
                    btnClass: 'btn-red',
                    action: function() {
                        $.confirm({
                            icon: 'fa fa-spinner fa-spin',
                            title: 'Mohon Tunggu!',
                            theme: 'supervan',
                            content: 'Kami sedang memproses permintaan Anda!',
                            buttons: {
                                close: {
                                    isHidden: true,
                                    actions: function() {}
                                },
                            },
                            onOpen: function() {
                                setTimeout(() => {
                                    jconfirm.instances[0].close();
                                    $.confirm({
                                        icon: 'fa fa-check',
                                        title: 'Done!',
                                        theme: 'supervan',
                                        content: 'Terima kasih sudah menunggu!',
                                        buttons: {
                                            close: {
                                                actions: function() {}
                                            },
                                        },
                                    });
                                }, 2000);
                            },

                        });
                    }
                },
            }
        });
    });
</script>
<script>
    $('#btn-finish-wizard').hide();
    
    'use strict'
    $(window).on('load', function() {
        // $('[data-toggle="popover"]').popover();
        $('#smartwizard').smartWizard({
            // selected: '0',
            justified: true,
            enableURLhash: true,
            transition: {
                animation: 'fade', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
            },
            toolbarSettings: {
                toolbarPosition: 'bottom', // none, top, bottom, both
                toolbarButtonPosition: 'right', // left, right, center
                showNextButton: true, // show/hide a Next button
                showPreviousButton: true, // show/hide a Previous button
                toolbarExtraButtons: [] // Extra buttons to show on toolbar, array of jQuery input/buttons elements
            },
            lang: { // Language variables for button
                next: 'Next',
                previous: 'Previous'
            },
        });

        // Initialize the leaveStep event
        $("#smartwizard").on("leaveStep", function(e, anchorObject, stepIndex, nextStepIndex, stepDirection) {
            // navigate to next step
            // console.log('Navigated to stepIndex ' + stepIndex + ' moving in stepDirection ' + stepDirection);

            // console.log($('.sw-next-btn').hasClass('disabled'))

            // check if current form step is valid
            var sales = $('#type_sales').val();
            var elmForm = $('#form-step-' + stepIndex);
            if (stepIndex == 1) {
                if (stepDirection == 'forward' && elmForm) {
                    if (sales == 'Sales Freelance') {
                        if ($('#ktp').val() == "" && $('#label_ktp').text() == '') {
                            alert_validation('Anda belum upload dokumen ktp', 'ktp')
                            return false;
                        } else {
                            $('#ktp').removeClass('is-invalid')
                        }
                        if ($('#kk').val() == "" && $('#label_kk').text() == '') {
                            alert_validation('Anda belum upload dokumen kartu keluarga', 'kk')
                            return false;
                        } else {
                            $('#kk').removeClass('is-invalid')
                        }
                        var form_data = new FormData();
                        var user_id = '<?= $karyawan['user_id'] ?>';
                        var ktp = $('#ktp')[0].files[0];
                        var kk = $('#kk')[0].files[0];
                        var lamaran = $('#lamaran')[0].files[0];
                        var cv = $('#cv')[0].files[0];
                        var ijazah = $('#ijazah')[0].files[0];
                        var kontak = $('#kontak')[0].files[0];
                        form_data.append('user_id', user_id);
                        form_data.append('ktp', ktp);
                        form_data.append('kk', kk);
                        form_data.append('lamaran', lamaran);
                        form_data.append('cv', cv);
                        form_data.append('ijazah', ijazah);
                        form_data.append('kontak', kontak);

                        var loadingDialog = $.alert({
                            icon: 'fa fa-spinner fa-spin',
                            title: 'Mohon Tunggu!',
                            theme: 'supervan',
                            content: 'Please wait while we are updating the document...',
                            closeIcon: false,
                            backgroundDismiss: false,
                            buttons: {
                                ok: {
                                    isHidden: true,
                                }
                            }
                        });

                        $.ajax({
                            url: '<?= base_url() ?>fdk/update_dokumen_wajib',
                            type: 'POST',
                            dataType: 'json',
                            data: form_data,
                            processData: false,
                            contentType: false,

                        }).done(function(data) {
                            loadingDialog.close();
                            console.log(data);
                            console.log(data.update);
                            new PNotify({
                                title: `Success`,
                                text: `Document Updated`,
                                icon: 'icofont icofont-check',
                                delay: 2000,
                                type: 'success'
                            });
                        }).fail(function(jqXHR, textStatus) {
                            loadingDialog.close();
                            new PNotify({
                                title: `Success`,
                                text: `Document Updated`,
                                icon: 'icofont icofont-check',
                                delay: 2000,
                                type: 'success'
                            });
                        });
                    } else {
                        if ($('#ktp').val() == "" && $('#label_ktp').text() == '') {
                            alert_validation('Anda belum upload dokumen ktp', 'ktp')
                            return false;
                        } else {
                            $('#ktp').removeClass('is-invalid')
                        }
                        if ($('#kk').val() == "" && $('#label_kk').text() == '') {
                            alert_validation('Anda belum upload dokumen kartu keluarga', 'kk')
                            return false;
                        } else {
                            $('#kk').removeClass('is-invalid')
                        }
                        if ($('#ktp').val() == "" && $('#label_ktp').text() == '') {
                            alert_validation('Anda belum upload dokumen ktp', 'ktp')
                            return false;
                        } else {
                            $('#ktp').removeClass('is-invalid')
                        }
                        if ($('#kk').val() == "" && $('#label_kk').text() == '') {
                            alert_validation('Anda belum upload dokumen kartu keluarga', 'kk')
                            return false;
                        } else {
                            $('#kk').removeClass('is-invalid')
                        }
                        if ($('#lamaran').val() == "" && $('#label_lamaran').text() == '') {
                            alert_validation('Anda belum upload dokumen Surat Lamaran', 'lamaran')
                            return false;
                        } else {
                            $('#lamaran').removeClass('is-invalid')
                        }

                        if ($('#cv').val() == "" && $('#label_cv').text() == '') {
                            alert_validation('Anda belum upload dokumen CV', 'cv')
                            return false;
                        } else {
                            $('#cv').removeClass('is-invalid')
                        }

                        if ($('#ijazah').val() == "" && $('#label_ijazah').text() == '') {
                            alert_validation('Anda belum upload dokumen Ijazah', 'ijazah')
                            return false;
                        } else {
                            $('#ijazah').removeClass('is-invalid')
                        }
                        var designation = '<?= $karyawan['designation_id'] ?>';
                        if (designation == 731) { //sales
                            if ($('#kontak').val() == "" && $('#label_kontak').text() == '') {
                                alert_validation('Anda belum upload daftar kontak!', 'kontak')
                                return false;
                            } else {
                                $('#kontak').removeClass('is-invalid')
                            }
                        }
                        var form_data = new FormData();
                        
                        if(designation == 731){
                            var user_id = '<?= $karyawan['user_id'] ?>';
                            var ktp = $('#ktp')[0].files[0];
                            var kk = $('#kk')[0].files[0];
                            var lamaran = $('#lamaran')[0].files[0];
                            var cv = $('#cv')[0].files[0];
                            var ijazah = $('#ijazah')[0].files[0];
                            var kontak = $('#kontak')[0].files[0];
                            form_data.append('user_id', user_id);
                            form_data.append('ktp', ktp);
                            form_data.append('kk', kk);
                            form_data.append('lamaran', lamaran);
                            form_data.append('cv', cv);
                            form_data.append('ijazah', ijazah);
                            form_data.append('kontak', kontak);
                        }else{
                            var user_id = '<?= $karyawan['user_id'] ?>';
                            var ktp = $('#ktp')[0].files[0];
                            var kk = $('#kk')[0].files[0];
                            var lamaran = $('#lamaran')[0].files[0];
                            var cv = $('#cv')[0].files[0];
                            var ijazah = $('#ijazah')[0].files[0];
                            form_data.append('user_id', user_id);
                            form_data.append('ktp', ktp);
                            form_data.append('kk', kk);
                            form_data.append('lamaran', lamaran);
                            form_data.append('cv', cv);
                            form_data.append('ijazah', ijazah);

                        }

                        var loadingDialog = $.alert({
                            icon: 'fa fa-spinner fa-spin',
                            title: 'Mohon Tunggu!',
                            theme: 'supervan',
                            content: 'Please wait while we are updating the document...',
                            closeIcon: false,
                            backgroundDismiss: false,
                            buttons: {
                                ok: {
                                    isHidden: true,
                                }
                            }
                        });

                        $.ajax({
                            url: '<?= base_url() ?>fdk/update_dokumen_wajib',
                            type: 'POST',
                            dataType: 'json',
                            data: form_data,
                            processData: false,
                            contentType: false,

                        }).done(function(data) {
                            loadingDialog.close();
                            console.log(data);
                            console.log(data.update);
                            new PNotify({
                                title: `Success`,
                                text: `Document Updated`,
                                icon: 'icofont icofont-check',
                                delay: 2000,
                                type: 'success'
                            });
                        }).fail(function(jqXHR, textStatus) {
                            loadingDialog.close();
                            new PNotify({
                                title: `Success`,
                                text: `Document Updated`,
                                icon: 'icofont icofont-check',
                                delay: 2000,
                                type: 'success'
                            });
                        });
                    }


                }
                // console.log('Form on Step ' + stepIndex + ' is valid');
                $(".tab-content").height('100%');
                return true;
            }


            if (stepIndex == 2) {
                if (stepDirection == 'forward' && elmForm) {
                    var form_data2 = new FormData();
                    var user_id = '<?= $karyawan['user_id'] ?>';
                    var transkip = $('#transkip')[0].files[0];
                    var npwp = $('#npwp')[0].files[0];
                    var surat_lulus = $('#surat_lulus')[0].files[0];
                    var verklaring = $('#verklaring')[0].files[0];
                    var sertifikat = $('#sertifikat')[0].files[0];
                    var dokumen_lain = $('#dokumen_lain')[0].files[0];
                    form_data2.append('user_id', user_id);
                    form_data2.append('transkip', transkip);
                    form_data2.append('npwp', npwp);
                    form_data2.append('surat_lulus', surat_lulus);
                    form_data2.append('verklaring', verklaring);
                    form_data2.append('sertifikat', sertifikat);
                    form_data2.append('dokumen_lain', dokumen_lain);
                    // form_data2.append('status', '<?= $karyawan['status'] ?>');
                    var loadingDialog = $.alert({
                        icon: 'fa fa-spinner fa-spin',
                        title: 'Mohon Tunggu!',
                        theme: 'supervan',
                        content: 'Please wait while we are updating the document...',
                        closeIcon: false,
                        backgroundDismiss: false,
                        buttons: {
                            ok: {
                                isHidden: true,
                            }
                        }
                    });
                    $.ajax({
                        url: '<?= base_url() ?>fdk/update_dokumen_optional',
                        type: 'POST',
                        dataType: 'json',
                        data: form_data2,
                        processData: false,
                        contentType: false,
                    }).done(function(data) {
                        loadingDialog.close();
                        // console.log(data);
                        // console.log(data.update);
                        new PNotify({
                            title: `Success`,
                            text: `Document optional updated!`,
                            icon: 'icofont icofont-check',
                            delay: 2000,
                            type: 'success'
                        });
                    }).fail(function(jqXHR, textStatus) {
                        loadingDialog.close();
                        new PNotify({
                            title: `Success`,
                            text: `Document optional updated!`,
                            icon: 'icofont icofont-check',
                            delay: 2000,
                            type: 'success'
                        });
                    });
                }
                // console.log('Form on Step ' + stepIndex + ' is valid');
                $(".tab-content").height('100%');
                return true;
            }


            if (stepIndex == 3) {
                if (stepDirection == 'forward' && elmForm) {


                }
                // console.log('Form on Step ' + stepIndex + ' is valid');
                $(".tab-content").height('100%');
                return true;
            }







            $(".tab-content").height('100%');
            return true;
        });
    });

    $('#btn-submit-form').click(function(e) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('fdk/submit_form'); ?>",
            data: {
                user_id: '<?= $karyawan['user_id'] ?>'
            },
            dataType: "json",
            success: function(response) {
                if (response == true) {
                    setTimeout(() => {
                        $(".tab-content").height('100%');
                        jconfirm.instances[0].close();
                        $.confirm({
                            icon: 'fa fa-check',
                            title: 'Terima Kasih!',
                            theme: 'material',
                            type: 'blue',
                            content: 'Berhasil Submit Formulir!',
                            buttons: {
                                close: {
                                    actions: function() {}
                                },
                            },
                        });
                    }, 250);
                    $('.confirm').fadeOut();

                    // setTimeout(() => {
                    //     location.reload();
                    // }, 1000);
                }
            }
        });

    });

    function reset_file(input) {
        $('#' + input).fadeOut(500);
        $('#' + input).fadeIn(500);
        $('#' + input).attr('disabled', false);
    }

    function validation_step1(id, name) {
        //validation
        if ($('#' + id).val() == "") {
            alert_validation('Anda belum upload dokumen ' + name, id)
            return false;
        } else {
            $('#' + id).removeClass('is-invalid')
            return true;
        }
    }

    function alert_validation(msg, id_input_element) {
        $.confirm({
            title: 'Alert!',
            content: msg,
            type: 'red',
            theme: 'material',
            typeAnimated: true,
            closeIcon: false,
            animation: 'opacity',
            buttons: {
                close: function() {
                    setTimeout(() => {
                        $('#' + id_input_element).focus();
                        $('#' + id_input_element).addClass('is-invalid');
                        $(".tab-content").height('100%');
                    }, 250);
                },
            }
        });
    }


    $("#checkSyarat").change(function() {
        if (this.checked) {
            $('#btn-submit-form').prop("disabled", false);
        } else {
            $('#btn-submit-form').prop("disabled", true);
        }
    });

    function reload_page() {

    }

    $('#btn-submit-form').click(function() {
        $.confirm({
            icon: 'fa fa-spinner fa-spin',
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
                // $(".tab-content").height('100%');
                // jconfirm.instances[0].close();
                // alert('berhasil upload');
                $.ajax({
                    url: '<?= base_url() ?>fdk/done',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        user_id: ''
                    },
                }).done(function(response) {
                    console.log(response);
                    if (response.done == true) {
                        setTimeout(() => {
                            $(".tab-content").height('100%');
                            jconfirm.instances[0].close();
                            $.confirm({
                                icon: 'fa fa-check',
                                title: 'Terima Kasih!',
                                theme: 'material',
                                type: 'blue',
                                content: 'Berhasil Submit Formulir!',
                                buttons: {
                                    close: {
                                        actions: function() {}
                                    },
                                },
                            });
                        }, 250);

                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                }).fail(function(jqXHR, textStatus) {
                    setTimeout(() => {
                        jconfirm.instances[0].close();
                        $.confirm({
                            icon: 'fa fa-close',
                            title: 'Oops!',
                            theme: 'material',
                            type: 'red',
                            content: 'Gagal submit formulir!' + textStatus,
                            buttons: {
                                close: {
                                    actions: function() {}
                                },
                            },
                        });
                    }, 250);
                });
            }
        });
    });
</script>
<script type="module">
    // We want to preview images, so we register
    // the Image Preview plugin, We also register 
    // exif orientation (to correct mobile image
    // orientation) and size validation, to prevent
    // large files from being added


    // Select the file input and use 
    // create() to turn it into a pond

    // get a reference to the input element
</script>


<script>
    function cek_file_image(id) {
        var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
        var fileInput = $('#' + id)[0]; // Use [0] to access the DOM element
        var filePath = fileInput.value;

        if (!allowedExtensions.exec(filePath)) {
            $.alert({
                title: 'Oops!',
                content: 'Mohon Upload file .jpeg/.jpg/.png saja.',
                type: 'red',
                theme: 'material',
            });
            fileInput.value = '';
            return false;
        }

        // Check file size
        var file = fileInput.files[0];
        if (file && file.size > 6 * 1024 * 1024) { // 5 MB = 5 * 1024 * 1024 bytes
            $.alert({
                title: 'Oops!',
                content: 'Ukuran file terlalu besar. <b>Maksimal 6 MB.</b><br>Harap Compress Foto terlebih dahulu',
                type: 'red',
                theme: 'material',
            });
            fileInput.value = '';
            return false;
        }

        return true;
    }


    function formatNumber(num) {
        if (num == null) {
            return 0;
        } else {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        }
    }
</script>