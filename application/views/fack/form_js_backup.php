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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>

<!-- fancybox -->
<script src="<?php echo base_url() ?>assets/fancybox/jquery.fancybox.min.js"></script>

<!-- Pnotify -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/pnotify/js/pnotify.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/bower_components/pnotify/js/pnotify.buttons.js"></script>

<!-- page level script -->
<script src="<?= base_url(); ?>assets/vendor/smartWizard/jquery.smartWizard.min.js"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script src="<?= base_url(); ?>assets/filepond/filepond-plugin-file-encode.min.js"></script>
<script src="<?= base_url(); ?>assets/filepond/filepond-plugin-file-validate-size.min.js"></script>
<script src="<?= base_url(); ?>assets/filepond/filepond-plugin-image-exif-orientation.min.js"></script>
<script src="<?= base_url(); ?>assets/filepond/filepond-plugin-image-preview.min.js"></script>
<script src="<?= base_url(); ?>assets/filepond/filepond.min.js"></script>
<script src="<?= base_url(); ?>assets/filepond/filepond-plugin-image-edit.js"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>

<?php if ($ck['is_link_expired'] == 1) { ?>
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
<?php } else { ?>
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


        // Running Datepicker
        $('.tanggal').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });


        $('#sama_dengan_ktp').on('change', function() {
            if ($(this).is(":checked")) {
                $('#alamat_saat_ini').val($('#alamat_ktp').val());
            } else {
                $('#alamat_saat_ini').val('');
            }
        });


        $(document).ready(function() {
            $(".only-nummber").inputFilter(function(value) {
                return /^\d*$/.test(value); // Allow digits only, using a RegExp
            }, "Hanya Boleh Angka");

            $('.only-alphabet').bind('keyup blur', function() {
                var node = $(this);
                node.val(node.val().replace(/[^a-z]/g, ''));
            });
        });

        $(".tgl").mask('0000-00-00')

        $("#file").on("change", function() {
            console.log($(this).val())
        });



        let options = {
            searchable: true
        }
        let niceAgama = NiceSelect.bind(document.getElementById('nice-select-agama'), options);
        let niceKewarganegaraan = NiceSelect.bind(document.getElementById('nice-select-kewarganegaraan'), options);
        let niceStatus = NiceSelect.bind(document.getElementById('nice-select-status'), options);
        let niceGender = NiceSelect.bind(document.getElementById('nice-select-gender'), options);

        $('.kondisi-status-menikah').hide();
        $('.kondisi-status-cerai').hide();
        $('#nice-select-status').on('change', function() {
            if ($(this).val() == "Married") {
                $('.kondisi-status-menikah').fadeIn();
                $('.kondisi-status-cerai').hide();
                $('#label_tempat_status').text('Tempat (Menikah)');
                $('#label_tgl_status').text('Tgl (Menikah)');
            } else if ($(this).val() == "Widowed" || $(this).val() == "Divorced or Separated") {
                $('.kondisi-status-menikah').hide();
                $('.kondisi-status-cerai').fadeIn();
            } else {
                $('.kondisi-status-cerai').hide();
                $('.kondisi-status-menikah').hide();
                $('#label_tempat_status').text('Tempat');
                $('#label_tgl_status').text('Tgl');
            }

            // adjust height tab
            $(".tab-content").height('100%');
        })

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
            $('#smartwizard').smartWizard({
                // selected: '0',
                justified: true,
                enableURLhash: true,
                transition: {
                    animation: 'none', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
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

                console.log($('.sw-next-btn').hasClass('disabled'))

                // check if current form step is valid
                var elmForm = $('#form-step-' + stepIndex);

                if (stepIndex == 1) {
                    if (stepDirection == 'forward' && elmForm) {
                        if ($('#employee_name').val() == "") {
                            alert_validation('Anda belum mengisi Nama Lengkap', 'employee_name')
                            return false;
                        } else {
                            $('#employee_name').removeClass('is-invalid')
                            // $('#employee_name').addClass('is-valid')
                        }

                        if ($('#no_ktp').val() == "") {
                            alert_validation('Anda belum mengisi Nomor KTP', 'no_ktp')
                            return false;
                        } else {
                            $('#no_ktp').removeClass('is-invalid')
                            // $('#no_ktp').addClass('is-valid')
                        }

                        if ($('#no_kk').val() == "") {
                            alert_validation('Anda belum mengisi Nomor KK', 'no_kk')
                            return false;
                        } else {
                            $('#no_kk').removeClass('is-invalid')
                            // $('#no_ktp').addClass('is-valid')
                        }

                        if ($('#tempat_lahir').val() == "") {
                            alert_validation('Anda belum mengisi Tempat Lahir', 'tempat_lahir')
                            return false;
                        } else {
                            $('#tempat_lahir').removeClass('is-invalid')
                            // $('#tempat_lahir').addClass('is-valid')
                        }

                        if ($('#tgl_lahir').val() == "") {
                            alert_validation('Anda belum mengisi Tanggal Lahir', 'tgl_lahir')
                            return false;
                        } else {
                            $('#tgl_lahir').removeClass('is-invalid')
                            // $('#tgl_lahir').addClass('is-valid')
                        }

                        if ($('#alamat_ktp').val() == "") {
                            alert_validation('Anda belum mengisi Alamat Sesuai KTP', 'alamat_ktp')
                            return false;
                        } else {
                            $('#alamat_ktp').removeClass('is-invalid')
                            // $('#alamat_ktp').addClass('is-valid')
                        }

                        if ($('#alamat_saat_ini').val() == "") {
                            alert_validation('Anda belum mengisi Alamat saat ini', 'alamat_saat_ini')
                            return false;
                        } else {
                            $('#alamat_saat_ini').removeClass('is-invalid')
                            // $('#alamat_saat_ini').addClass('is-valid')
                        }

                        if ($('#no_hp').val() == "") {
                            alert_validation('Anda belum mengisi Nomor Handphone', 'no_hp')
                            return false;
                        } else {
                            $('#no_hp').removeClass('is-invalid')
                            // $('#no_hp').addClass('is-valid')
                        }

                        if ($('#email').val() == "") {
                            alert_validation('Anda belum mengisi Alamat Email', 'email')
                            return false;
                        } else {
                            $('#email').removeClass('is-invalid')
                            // $('#email').addClass('is-valid')
                        }

                        if ($('#nice-select-agama').val() == "") {
                            alert_validation('Anda belum mengisi Agama', 'agama')
                            return false;
                        } else {
                            $('#nice-select-agama').removeClass('is-invalid')
                            // $('#agama').addClass('is-valid')
                        }

                        if ($('#kewarganegaraan').val() == "") {
                            alert_validation('Anda belum mengisi Kewarganegaraan', 'kewarganegaraan')
                            return false;
                        } else {
                            $('#kewarganegaraan').removeClass('is-invalid')
                            // $('#kewarganegaraan').addClass('is-valid')
                        }

                        if ($('#status').val() == "") {
                            alert_validation('Anda belum mengisi status', 'status')
                            return false;
                        } else {
                            $('#status').removeClass('is-invalid')
                            // $('#status').addClass('is-valid')
                        }

                        console.log($('#pas_foto').val());
                        console.log($('#pas_foto_temp').val());
                        if ($('#pas_foto_temp').val() == "") {
                            alert_validation('Anda belum mengupload foto', 'pas_foto')
                            return false;
                        }


                        $.ajax({
                            url: '<?= base_url() ?>fack/update_personal_details',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                application_id: '<?= $ck['application_id']; ?>',
                                employee_name: $('#employee_name').val(),
                                no_ktp: $('#no_ktp').val(),
                                no_kk: $('#no_kk').val(),
                                no_npwp: $('#no_npwp').val(),
                                tempat_lahir: $('#tempat_lahir').val(),
                                tgl_lahir: $('#tgl_lahir').val(),
                                alamat_ktp: $('#alamat_ktp').val(),
                                alamat_saat_ini: $('#alamat_saat_ini').val(),
                                no_hp: $('#no_hp').val(),
                                email: $('#email').val(),
                                agama: $('#nice-select-agama').val(),
                                kewarganegaraan: $('#nice-select-kewarganegaraan').val(),
                                status: $('#nice-select-status').val(),
                            },
                            beforeSend: function() {},
                            success: function(response) {},
                            error: function(xhr) {},
                            complete: function() {},
                        }).done(function(data) {
                            console.log(data);
                            console.log(data.update);
                            new PNotify({
                                title: `Success`,
                                text: `Personal Details Updated`,
                                icon: 'icofont icofont-check',
                                delay: 2000,
                                type: 'success'
                            });
                        }).fail(function(jqXHR, textStatus) {
                            new PNotify({
                                title: `Failed`,
                                text: `Failed to Update Personal Details`,
                                icon: 'icofont icofont-info-circle',
                                type: 'error',
                                delay: 2000,
                            });
                        });

                    }
                    // console.log('Form on Step ' + stepIndex + ' is valid');
                    $(".tab-content").height('100%');
                    return true;
                }


                if (stepIndex == 2) {
                    if (stepDirection == 'forward' && elmForm) {
                        let table_dt_daftar_keluarga = $('#dt_daftar_keluarga').DataTable();

                        if (!table_dt_daftar_keluarga.data().any()) {
                            $.confirm({
                                title: 'Alert!',
                                content: 'Anda belum mengisi daftar keluarga',
                                type: 'red',
                                theme: 'material',
                                typeAnimated: true,
                                closeIcon: false,
                                animateFromElement: false,
                                animation: 'RotateXR',
                                closeAnimation: 'RotateXR',
                                buttons: {
                                    close: function() {
                                        setTimeout(() => {
                                            $(".tab-content").height('100%');
                                        }, 250);
                                    },
                                }
                            });
                            return false;
                        }

                    }
                    // console.log('Form on Step ' + stepIndex + ' is valid');
                    $(".tab-content").height('100%');
                    return true;
                }


                if (stepIndex == 3) {
                    if (stepDirection == 'forward' && elmForm) {
                        let table_dt_daftar_pendidikan = $('#dt_daftar_pendidikan').DataTable();

                        if (!table_dt_daftar_pendidikan.data().any()) {
                            $.confirm({
                                title: 'Alert!',
                                content: 'Anda belum mengisi daftar pendidikan',
                                type: 'red',
                                theme: 'material',
                                typeAnimated: true,
                                closeIcon: false,
                                animateFromElement: false,
                                animation: 'RotateXR',
                                closeAnimation: 'RotateXR',
                                buttons: {
                                    close: function() {
                                        setTimeout(() => {
                                            $(".tab-content").height('100%');
                                        }, 250);
                                    },
                                }
                            });
                            return false;
                        }

                    }
                    // console.log('Form on Step ' + stepIndex + ' is valid');
                    $(".tab-content").height('100%');
                    return true;
                }



                if (stepIndex == 5) {
                    if (stepDirection == 'forward' && elmForm) {

                        let table_dt_daftar_pekerjaan_favorit = $('#dt_daftar_pekerjaan_favorit').DataTable();

                        if (!table_dt_daftar_pekerjaan_favorit.data().any()) {
                            $.confirm({
                                title: 'Alert!',
                                content: 'Anda belum mengisi daftar pekerjaan yang diminati',
                                type: 'red',
                                theme: 'material',
                                typeAnimated: true,
                                closeIcon: false,
                                animateFromElement: false,
                                animation: 'RotateXR',
                                closeAnimation: 'RotateXR',
                                buttons: {
                                    close: function() {
                                        setTimeout(() => {
                                            $(".tab-content").height('100%');
                                        }, 250);
                                    },
                                }
                            });
                            return false;
                        }



                        if ($('#motivasi').val() == "") {
                            alert_validation('Anda belum mengisi motivasi', 'motivasi')
                            return false;
                        } else {
                            $('#motivasi').removeClass('is-invalid')
                        }

                        if ($('#kesediaan_1').val() == "") {
                            alert_validation('Anda belum menjawab Kapan Anda dapat memulai pekerjaan baru ?', 'kesediaan_1')
                            return false;
                        } else {
                            $('#kesediaan_1').removeClass('is-invalid')
                        }

                        if ($('#kesediaan_2').val() == "") {
                            alert_validation('Anda belum menjawab Bersediakah Anda menitipkan Ijazah di perusahaan ini ?', 'kesediaan_2')
                            return false;
                        } else {
                            $('#kesediaan_2').removeClass('is-invalid')
                        }

                        if ($('#kesediaan_3').val() == "") {
                            alert_validation('Anda belum menjawab Bersediakah membawa kendaraan pribadi/ motor untuk kepentingan pekerjaan ?', 'kesediaan_3')
                            return false;
                        } else {
                            $('#kesediaan_3').removeClass('is-invalid')
                        }

                        if ($('#kesediaan_4').val() == "") {
                            alert_validation('Anda belum menjawab Bersediakah membawa laptop pribadi untuk kebutuhan pekerjaan ?', 'kesediaan_4')
                            return false;
                        } else {
                            $('#kesediaan_4').removeClass('is-invalid')
                        }

                        if ($('#kesediaan_5').val() == "") {
                            alert_validation('Anda belum menjawab Bersediakah Anda ditempatkan di luar kota ?', 'kesediaan_5')
                            return false;
                        } else {
                            $('#kesediaan_5').removeClass('is-invalid')
                        }

                        if ($('#hobi').val() == "") {
                            alert_validation('Anda belum mengisi hobi', 'hobi')
                            return false;
                        } else {
                            $('#hobi').removeClass('is-invalid')
                        }

                        let table_dt_daftar_referensi = $('#dt_daftar_referensi').DataTable();

                        if (!table_dt_daftar_referensi.data().any()) {
                            $.confirm({
                                title: 'Alert!',
                                content: 'Anda belum mengisi daftar referensi',
                                type: 'red',
                                theme: 'material',
                                typeAnimated: true,
                                closeIcon: false,
                                animateFromElement: false,
                                animation: 'RotateXR',
                                closeAnimation: 'RotateXR',
                                buttons: {
                                    close: function() {
                                        setTimeout(() => {
                                            $(".tab-content").height('100%');
                                        }, 250);
                                    },
                                }
                            });
                            return false;
                        }


                        $.ajax({
                            url: '<?= base_url() ?>fack/update_lain_lain',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                application_id: '<?= $ck['application_id']; ?>',
                                motivasi: $('#motivasi').val(),
                                kesediaan_1: $('#kesediaan_1').val(),
                                kesediaan_2: $('#kesediaan_2').val(),
                                kesediaan_3: $('#kesediaan_3').val(),
                                kesediaan_4: $('#kesediaan_4').val(),
                                kesediaan_5: $('#kesediaan_5').val(),
                                hobi: $('#hobi').val(),
                            },
                            beforeSend: function() {},
                            success: function(response) {},
                            error: function(xhr) {},
                            complete: function() {},
                        }).done(function(data) {
                            console.log(data);
                            console.log(data.update);
                            new PNotify({
                                title: `Success`,
                                text: `Lain-lain Updated`,
                                icon: 'icofont icofont-check',
                                delay: 2000,
                                type: 'success'
                            });
                        }).fail(function(jqXHR, textStatus) {
                            new PNotify({
                                title: `Failed`,
                                text: `Failed to Update Lain-lain`,
                                icon: 'icofont icofont-info-circle',
                                type: 'error',
                                delay: 2000,
                            });
                        });

                    }
                    // console.log('Form on Step ' + stepIndex + ' is valid');
                    $(".tab-content").height('100%');
                    return true;
                }

                $(".tab-content").height('100%');
                return true;
            });
        });

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

                    $.ajax({
                        url: '<?= base_url() ?>fack/done',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            application_id: '<?= $ck['application_id'] ?>'
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
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginImageExifOrientation,
            FilePondPluginFileValidateSize,
            FilePondPluginImageEdit
        );

        // Select the file input and use 
        // create() to turn it into a pond

        // get a reference to the input element
        const inputElementFoto = document.getElementById('pas_foto');

        // create a FilePond instance at the input element location
        const pond = FilePond.create(inputElementFoto, {
            name: 'filepond',
            maxFiles: 1,
            allowBrowse: true,
            credits: false,
            acceptedFileTypes: ['image/*'],
            // server
            server: {
                load: (uniqueFileId, load, error, progress, abort, headers) => {
                    console.log('attempting to load', uniqueFileId);
                    // implement logic to load file from server here
                    // https://pqina.nl/filepond/docs/patterns/api/server/#load-1

                    let controller = new AbortController();
                    let signal = controller.signal;

                    fetch(`<?= base_url() ?>fack/filepond_load/${uniqueFileId}`, {
                            method: "GET",
                            signal,
                        })
                        .then(res => {
                            window.c = res
                            console.log(res)
                            return res.blob()
                        })
                        .then(blob => {
                            console.log(blob)
                            console.log(blob.size)
                            // const imageFileObj = new File([blob], `${uniqueFileId}.${blob.type.split('/')[1]}`, {
                            //   type: blob.type
                            // }) 
                            // console.log(imageFileObj)
                            // progress(true, size, size);
                            if (blob.size > 0) {
                                load(blob);
                                $('#pas_foto_temp').val(blob.size);
                            } else {
                                abort();
                            }
                        })
                        .catch(err => {
                            console.log(err)
                            error(err.message);
                        })

                    return {
                        abort: () => {
                            // User tapped cancel, abort our ongoing actions here
                            controller.abort();
                            // Let FilePond know the request has been cancelled
                            abort();
                        }
                    };
                },
                // remove: 
            },
            //files array
            files: [
                // display existing campaign images from the server here
                {
                    // the server file reference
                    source: '<?= $ck['application_id'] ?>',
                    // set type to local to indicate an already uploaded file
                    options: {
                        type: 'local',
                    }
                },
            ],
        });

        document.addEventListener('FilePond:loaded', e => {
            // adjust height tab
            // console.log('FilePond ready for use', e.detail);
            setTimeout(() => {
                $(".tab-content").height('100%');
            }, 250);
        });

        FilePond.setOptions({
            maxFiles: 1,
            credits: false,
            server: {
                process: {
                    url: '<?= base_url() ?>fack/filepond_process',
                    method: 'POST',
                    headers: {
                        'x-customheader': 'Processing File'
                    },
                    onload: (response) => {
                        // console.log("raw", response)
                        response = JSON.parse(response);
                        // console.log(response);
                        return response.key;
                    },
                    onerror: (response) => {
                        // console.log("raw", response)
                        response = JSON.parse(response);
                        // console.log(response);
                        return response.msg
                    },
                    ondata: (formData) => {
                        $('#pas_foto_temp').val('done')
                        formData.append('application_id', '<?= $ck['application_id'] ?? "" ?>');
                        window.h = formData;
                        // console.log(formData)
                        return formData;
                    }
                },
                revert: (uniqueFileId, load, error) => {
                    const formData = new FormData();
                    formData.append("key", uniqueFileId);

                    // console.log(uniqueFileId);

                    fetch(`<?= base_url() ?>fack/filepond_revert/${uniqueFileId}`, {
                            method: "DELETE",
                            body: formData,
                        })
                        .then(res => res.json())
                        .then(json => {
                            // console.log(json);
                            if (json.status == "success") {
                                // Should call the load method when done, no parameters required
                                load();
                            } else {
                                // Can call the error method if something is wrong, should exit after
                                console.log(err.msg);
                            }
                        })
                        .catch(err => {
                            // console.log(err)
                            // Can call the error method if something is wrong, should exit after
                            console.log(err.message);
                        })
                },
                remove: (uniqueFileId, load, error) => {
                    const formData = new FormData();
                    formData.append("key", uniqueFileId);

                    // console.log(uniqueFileId);

                    fetch(`<?= base_url() ?>fack/filepond_revert/${uniqueFileId}`, {
                            method: "DELETE",
                            body: formData,
                        })
                        .then(res => res.json())
                        .then(json => {
                            // console.log(json);
                            if (json.status == "success") {
                                $('#pas_foto_temp').val('')
                                // Should call the load method when done, no parameters required
                                load();
                            } else {
                                // Can call the error method if something is wrong, should exit after
                                console.log(err.msg);
                            }
                        })
                        .catch(err => {
                            // console.log(err)
                            // Can call the error method if something is wrong, should exit after
                            console.log(err.message);
                        })
                },
                restore: (uniqueFileId, load, error, progress, abort, headers) => {
                    let controller = new AbortController();
                    let signal = controller.signal;

                    fetch(`<?= base_url() ?>fack/filepond_load/${uniqueFileId}`, {
                            method: "GET",
                            signal,
                        })
                        .then(res => {
                            window.c = res
                            // console.log(res)
                            const headers = res.headers;
                            const contentLength = +headers.get("content-length");
                            const contentDisposition = headers.get("content-disposition");
                            let fileName = contentDisposition.split("filename=")[1];
                            fileName = fileName.slice(1, fileName.length - 1)
                            progress(true, contentLength, contentLength);
                            return {
                                blob: res.blob(),
                                size: contentLength,
                            }
                        })
                        .then(({
                            blob,
                            size
                        }) => {
                            // console.log(blob)
                            // headersString = 'Content-Disposition: inline; filename="my-file.jpg"'
                            // headers(headersString);

                            const imageFileObj = new File([blob], `${uniqueFileId}.${blob.type.split('/')[1]}`, {
                                type: blob.type
                            })
                            // console.log(imageFileObj)
                            progress(true, size, size);
                            load(imageFileObj);
                        })
                        .catch(err => {
                            // console.log(err)
                            console.log(err.message);
                        })

                    return {
                        abort: () => {
                            // User tapped cancel, abort our ongoing actions here
                            controller.abort();
                            // Let FilePond know the request has been cancelled
                            abort();
                        }
                    };
                },
                load: (source, load, error, progress, abort, headers) => {
                    let controller = new AbortController();
                    let signal = controller.signal;

                    fetch(`<?= base_url() ?>fack/filepond_load/${uniqueFileId}`, {
                            method: "GET",
                            signal,
                        })
                        .then(res => {
                            window.c = res
                            console.log(res)
                            const headers = res.headers;
                            const contentLength = +headers.get("content-length");
                            const contentDisposition = headers.get("content-disposition");
                            let fileName = contentDisposition.split("filename=")[1];
                            fileName = fileName.slice(1, fileName.length - 1)
                            progress(true, contentLength, contentLength);
                            return {
                                blob: res.blob(),
                                size: contentLength,
                            }
                        })
                        .then(({
                            blob,
                            size
                        }) => {
                            console.log(blob)
                            // headersString = 'Content-Disposition: inline; filename="my-file.jpg"'
                            // headers(headersString);

                            const imageFileObj = new File([blob], `${uniqueFileId}.${blob.type.split('/')[1]}`, {
                                type: blob.type
                            })
                            console.log(imageFileObj)
                            progress(true, size, size);
                            $('#pas_foto_temp').val(size);

                            load(imageFileObj);
                        })
                        .catch(err => {
                            console.log(err)
                            error(err.message);
                        })

                    return {
                        abort: () => {
                            // User tapped cancel, abort our ongoing actions here
                            controller.abort();
                            // Let FilePond know the request has been cancelled
                            abort();
                        }
                    };
                },
            },
            allowImagePreview: false
        });
    </script>


    <script>
        daftar_keluarga();

        function daftar_keluarga() {
            let apl_id = '<?= $ck['application_id']; ?>'
            var table = $('#dt_daftar_keluarga').DataTable({
                orderCellsTop: false,
                // fixedHeader: true,
                "searching": false,
                "info": false,
                "paging": false,
                "destroy": true,
                "ordering": false,
                "autoWidth": false,
                "order": [
                    [0, 'desc']
                ],
                responsive: true,
                "ajax": {
                    "dataType": 'json',
                    "type": "POST",
                    "data": {
                        application_id: apl_id
                    },
                    "url": "<?= base_url(); ?>fack/dt_daftar_keluarga",
                },
                "columns": [{
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        defaultContent: '',
                    },
                    {
                        "data": "status",
                    },
                    {
                        "data": "nama",
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row, meta) {
                            return `<a role="button" class="button-4-icon" onclick="hapus_keluarga('${row['id']}','${row['application_id']}')"><i class="bi bi-trash"></i><a>`
                        },
                    },
                    {
                        "data": "jenis_kelamin",
                        "className": "d-none"
                    },
                    {
                        "data": "tempat_lahir",
                        "render": function(data, type, row, meta) {
                            return `${data}, ${row['tgl_lahir']}`
                        },
                        "className": "d-none"
                    },
                    {
                        "data": "pendidikan",
                        "className": "d-none"
                    },
                    {
                        "data": "pekerjaan",
                        "className": "d-none"
                    },
                    {
                        "data": "no_hp",
                        "className": "d-none"
                    },
                ],
            });
        }

        // Add event listener for opening and closing details
        $('#dt_daftar_keluarga tbody').on('click', 'td.dt-control', function() {
            var tr = $(this).closest('tr');
            var row = $('#dt_daftar_keluarga').DataTable().row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(detail_keluarga(row.data())).show();
                tr.addClass('shown');
                $(".tab-content").height('100%');
            }
        });

        function detail_keluarga(d) {
            // `d` is the original data object for the row
            return (
                `<table class="table table-sm">
				<tr>
					<td><b>Jenis Kelamin</b></td>
					<td>${d.jenis_kelamin}</td>
				</tr>
				<tr>
					<td><b>Tempat, Tgl Lahir</b></td>
					<td>${d.tempat_lahir}, ${d.tgl_lahir}</td>
					</tr>
				<tr>
					<td><b>Pendidikan</b></td>
					<td>${d.pendidikan}</td>
				</tr>
				<tr>
					<td><b>Pekerjaan</b></td>
					<td>${d.pekerjaan}</td>
				</tr>
				<tr>
					<td><b>No. Telp</b></td>
					<td>${d.no_hp}</td>
				</tr>
       		 </table>`
            );
        }


        function hapus_keluarga(id, application_id) {
            $.confirm({
                title: 'Alert!',
                theme: 'material',
                type: 'red',
                content: 'Apakah anda yakin hapus data keluarga ini!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                    hapus: {
                        text: 'Ya, Hapus!',
                        btnClass: 'btn-red',
                        action: function() {

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

                                    $.ajax({
                                        url: '<?= base_url() ?>fack/hapus_keluarga',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            id: id,
                                            application_id: application_id
                                        },
                                    }).done(function(response) {
                                        console.log(response);
                                        if (response.hapus == true) {
                                            daftar_keluarga();
                                            setTimeout(() => {
                                                $(".tab-content").height('100%');
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Berhasil hapus data keluarga!',
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                        } else {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-close',
                                                title: 'Oops!',
                                                theme: 'material',
                                                type: 'red',
                                                content: 'Gagal hapus data keluarga!',
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
                                                content: 'Gagal menyimpan data keluarga!' + textStatus,
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
                        }
                    }
                },
            });
        }


        $('#btn-add-keluarga').on('click', function() {
            let application_id = "<?= $ck['application_id'] ?? "" ?>"
            let employee_id = "<?= $ck['employee_id'] ?? "" ?>"
            $.confirm({
                title: 'Prompt!',
                type: 'blue',
                theme: 'material',
                columnClass: 'col-12 col-md-6',
                content: function() {
                    var self = this;
                    return $.ajax({
                        url: '<?= base_url() ?>fack/dt_pendidikan',
                        dataType: 'json',
                        method: 'POST',
                        data: {
                            application_id: application_id
                        }
                    }).done(function(response) {


                        console.log(response);
                        console.log(response.status_keluarga_sudah_input);

                        array_status_keluarga = [];
                        if (response.status_keluarga_sudah_input.length > 0) {
                            for (let index = 0; index < response.status_keluarga_sudah_input.length; index++) {
                                array_status_keluarga.push(response.status_keluarga_sudah_input[index].status_ada);
                            }
                            console.log(array_status_keluarga)
                        }

                        // let status_pernikahan = $('#nice-select-status').val();

                        opt_custom = '';
                        // if (status_pernikahan == "Single") {
                        opt_custom += `${array_status_keluarga.includes('Ayah') ? '' : '<option value="Ayah">Ayah</option>'}`
                        opt_custom += `${array_status_keluarga.includes('Ibu') ? '' : '<option value="Ibu">Ibu</option>'}`
                        // } else {
                        opt_custom += `${array_status_keluarga.includes('Istri') ? '' : '<option value="Istri">Istri</option>'}`
                        // }

                        opt_custom += `${array_status_keluarga.includes('Anak ke-1') ? '' : '<option value="Anak ke-1">Anak ke-1</option>'}`
                        opt_custom += `${array_status_keluarga.includes('Anak ke-2') ? '' : '<option value="Anak ke-2">Anak ke-2</option>'}`
                        opt_custom += `${array_status_keluarga.includes('Anak ke-3') ? '' : '<option value="Anak ke-3">Anak ke-3</option>'}`
                        opt_custom += `${array_status_keluarga.includes('Anak ke-4') ? '' : '<option value="Anak ke-4">Anak ke-4</option>'}`
                        opt_custom += `${array_status_keluarga.includes('Anak ke-5') ? '' : '<option value="Anak ke-5">Anak ke-5</option>'}`
                        opt_custom += `${array_status_keluarga.includes('Anak ke-6') ? '' : '<option value="Anak ke-6">Anak ke-6</option>'}`
                        opt_custom += `${array_status_keluarga.includes('Anak ke-7') ? '' : '<option value="Anak ke-7">Anak ke-7</option>'}`
                        opt_custom += `${array_status_keluarga.includes('Anak ke-8') ? '' : '<option value="Anak ke-8">Anak ke-8</option>'}`


                        opt_pendidikan = '';
                        for (let index = 0; index < response.data.length; index++) {
                            opt_pendidikan += `<option value="${response.data[index].id_pendidikan}">${response.data[index].pendidikan}</option>`
                        }



                        self.setContent(`
					<form action="" id="form-fack-keluarga" class="formName">
						<div class="mb-3 col-12">
                            <input type="hidden" name="application_id_keluarga" id="application_id_keluarga" value="${application_id}" readonly>
                            <input type="hidden" name="employee_id_keluarga" id="employee_id_keluarga" value="${employee_id}" readonly>
                        </div>
						<div class="mb-3 col-12">
							<label for="status" class="form-label-custom required">Status Keluarga</label>
							<select id="nice-select-status-keluarga" name="status_keluarga" class="wide mb-3 status_keluarga">
                                ${opt_custom}
							</select>
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please provide a valid data.
							</div>
						</div>
						<div class="mb-3 col-12">
							<label for="nama" class="form-label-custom required">Nama</label>
							<input type="text" class="form-control border-custom nama_keluarga" name="nama_keluarga" id="nama_keluarga" value="">
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please provide a valid data.
							</div>
						</div>
						<div class="mb-3 col-12">
							<label for="jenis_kelamin_keluarga" class="form-label-custom required">Jenis Kelamin</label>
							<select id="nice-select-jk-keluarga" name="jenis_kelamin_keluarga" class="wide mb-3 jenis_kelamin_keluarga">
								<option value="Pria">Pria</option>
								<option value="Wanita">Wanita</option>
							</select>
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please provide a valid data.
							</div>
						</div>
						<div class="mb-3 col-12">
							<label for="tempat_lahir_keluarga" class="form-label-custom required">Tempat Lahir</label>
							<input type="text" class="form-control border-custom tempat_lahir_keluarga" name="tempat_lahir_keluarga" id="tempat_lahir_keluarga" value="">
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please provide a valid data.
							</div>
						</div>
						<div class="mb-3 col-12">
							<label for="tgl_lahir_keluarga" class="form-label-custom required">Tanggal Lahir</label>
							<input type="tel" pattern="\d*" class="form-control border-custom tgl tgl_lahir_keluarga" placeholder="____-__-__" name="tgl_lahir_keluarga" id="tgl_lahir_keluarga" value="">
							<span class="badge text-dark small">Contoh (thn-bln-tgl): 1993-01-28</span>
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please provide a valid data.
							</div>
						</div>
						<div class="mb-3 col-12">
							<label for="pendidikan_keluarga" class="form-label-custom required">Pendidikan Terakhir</label>
							<select id="nice-select-pendidikan-keluarga" name="pendidikan_keluarga" class="wide mb-3 pendidikan_keluarga">
								${opt_pendidikan}
							</select>
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please provide a valid data.
							</div>
						</div>
						<div class="mb-3 col-12">
							<label for="pekerjaan_keluarga" class="form-label-custom required">Pekerjaan</label>
                            <select id="nice-select-pekerjaan-keluarga" name="pekerjaan_keluarga" class="wide mb-3 pekerjaan_keluarga">
								<option value="Pegawai Negeri">Pegawai Negeri</option>
								<option value="Pegawai Swasta">Pegawai Swasta</option>
								<option value="Wirausaha">Wirausaha</option>
								<option value="Pelajar">Pelajar</option>
								<option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
								<option value="Lain-lain">Lain-lain</option>
							</select>
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please provide a valid data.
							</div>
						</div>
						<div class="mb-3 col-12">
							<label for="no_hp_keluarga" class="form-label-custom">Nomor Telepon/Hp</label>
							<input type="text" class="form-control border-custom" name="no_hp_keluarga" id="no_hp_keluarga" value="">
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please provide a valid data.
							</div>
						</div>
					</form>`);
                        self.setTitle('Input Data Keluarga');
                    }).fail(function() {
                        self.setContent('Something went wrong.');
                    });
                },
                buttons: {
                    cancel: function() {
                        //close
                    },
                    formSubmit: {
                        text: 'Submit',
                        btnClass: 'btn-blue',
                        action: function() {
                            let status_keluarga = this.$content.find('.status_keluarga').val();
                            if (!status_keluarga) {
                                $.alert('Anda belum memilih status keluarga');
                                return false;
                            }
                            let nama_keluarga = this.$content.find('.nama_keluarga').val();
                            if (!nama_keluarga) {
                                $.alert('Anda belum mengisi nama');
                                return false;
                            }
                            let jenis_kelamin_keluarga = this.$content.find('.jenis_kelamin_keluarga').val();
                            if (!jenis_kelamin_keluarga) {
                                $.alert('Anda belum mengisi jenis kelamin');
                                return false;
                            }
                            let tempat_lahir_keluarga = this.$content.find('.tempat_lahir_keluarga').val();
                            if (!tempat_lahir_keluarga) {
                                $.alert('Anda belum mengisi tempat lahir keluarga');
                                return false;
                            }
                            let tgl_lahir_keluarga = this.$content.find('.tgl_lahir_keluarga').val();
                            if (!tgl_lahir_keluarga) {
                                $.alert('Anda belum mengisi tgl lahir keluarga');
                                return false;
                            }
                            let pekerjaan_keluarga = this.$content.find('.pekerjaan_keluarga').val();
                            if (!pekerjaan_keluarga) {
                                $.alert('Anda belum mengisi pekerjaan keluarga');
                                return false;
                            }
                            let pendidikan_keluarga = this.$content.find('.pendidikan_keluarga').val();
                            if (!pendidikan_keluarga) {
                                $.alert('Anda belum mengisi pendidikan keluarga');
                                return false;
                            }

                            no_hp_keluarga = $('#no_hp_keluarga').val();

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
                                    $.ajax({
                                        url: '<?= base_url() ?>fack/store_keluarga',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            application_id_keluarga: application_id,
                                            employee_id_keluarga: employee_id,
                                            nama_keluarga: nama_keluarga,
                                            status_keluarga: status_keluarga,
                                            jenis_kelamin_keluarga: jenis_kelamin_keluarga,
                                            tempat_lahir_keluarga: tempat_lahir_keluarga,
                                            tgl_lahir_keluarga: tgl_lahir_keluarga,
                                            pekerjaan_keluarga: pekerjaan_keluarga,
                                            pendidikan_keluarga: pendidikan_keluarga,
                                            no_hp: no_hp_keluarga
                                        },
                                        beforeSend: function() {

                                        },
                                        success: function(response) {},
                                        error: function(xhr) {},
                                        complete: function() {},
                                    }).done(function(response) {
                                        console.log(response);
                                        if (response.status == true) {
                                            daftar_keluarga();
                                            setTimeout(() => {
                                                $(".tab-content").height('100%');
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Berhasil menyimpan data keluarga!',
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                        } else {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-close',
                                                title: 'Oops!',
                                                theme: 'material',
                                                type: 'red',
                                                content: 'Gagal menyimpan data keluarga!',
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
                                                content: 'Gagal menyimpan data keluarga!' + textStatus,
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
                onContentReady: function() {
                    $(".tgl").mask('0000-00-00');

                    let niceStatusKeluarga = NiceSelect.bind(document.getElementById('nice-select-status-keluarga'), options);
                    let niceJkKeluarga = NiceSelect.bind(document.getElementById('nice-select-jk-keluarga'), options);
                    let nicePendidikanKeluarga = NiceSelect.bind(document.getElementById('nice-select-pendidikan-keluarga'), options);
                    let nicePekerjaanKeluarga = NiceSelect.bind(document.getElementById('nice-select-pekerjaan-keluarga'), options);

                    let stat_kel_before = $('#nice-select-status-keluarga').val();
                    if (stat_kel_before == "Ibu") {
                        $('#nice-select-jk-keluarga').val('Wanita').trigger("change");
                    }
                    if (stat_kel_before == "Istri") {
                        $('#nice-select-jk-keluarga').val('Wanita').trigger("change");
                    }
                    niceJkKeluarga.update()


                    $('#nice-select-status-keluarga').on('change', function() {
                        let stat_kel = $(this).val();
                        $('#nice-select-jk-keluarga').val('Pria').trigger("change");
                        if (stat_kel == "Ibu") {
                            $('#nice-select-jk-keluarga').val('Wanita').trigger("change");
                        }
                        if (stat_kel == "Istri") {
                            $('#nice-select-jk-keluarga').val('Wanita').trigger("change");
                        }
                        console.log(stat_kel)
                        niceJkKeluarga.update()
                    });
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function(e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });
        });



        dt_daftar_pendidikan();

        function dt_daftar_pendidikan() {
            let apl_id = '<?= $ck['application_id']; ?>'
            var table = $('#dt_daftar_pendidikan').DataTable({
                orderCellsTop: false,
                // fixedHeader: true,
                "searching": false,
                "info": false,
                "paging": false,
                "destroy": true,
                "ordering": false,
                "autoWidth": false,
                "order": [
                    [0, 'desc']
                ],
                responsive: true,
                "ajax": {
                    "dataType": 'json',
                    "type": "POST",
                    "data": {
                        application_id: apl_id
                    },
                    "url": "<?= base_url(); ?>fack/dt_daftar_pendidikan",
                },
                "columns": [{
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        defaultContent: '',
                    },
                    {
                        "data": "tingkat_pendidikan",
                    },
                    {
                        "data": "nama_instansi",
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row, meta) {
                            return `<a role="button" class="button-4-icon" onclick="hapus_pendidikan('${row['id']}','${row['application_id']}')"><i class="bi bi-trash"></i><a>`
                        },
                    },
                    {
                        "data": "tempat",
                        "className": "d-none"
                    },
                    {
                        "data": "jurusan",
                        "render": function(data, type, row, meta) {
                            return `${row['jurusan']}`
                        },
                        "className": "d-none"
                    },
                    {
                        "data": "status_pendidikan",
                        "className": "d-none"
                    },
                    {
                        "data": "keterangan_nilai",
                        "className": "d-none"
                    },
                    {
                        "data": "tahun_masuk_keluar",
                        "className": "d-none"
                    },
                ],
            });
        }

        // Add event listener for opening and closing details
        $('#dt_daftar_pendidikan tbody').on('click', 'td.dt-control', function() {
            var tr = $(this).closest('tr');
            var row = $('#dt_daftar_pendidikan').DataTable().row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(detail_pendidikan(row.data())).show();
                tr.addClass('shown');
                $(".tab-content").height('100%');
            }
        });

        function detail_pendidikan(d) {
            // `d` is the original data object for the row
            return (
                `<table class="table table-sm">
				<tr>
					<td><b>Tempat</b></td>
					<td>${d.tempat}</td>
				</tr>
				<tr>
					<td><b>Jurusan</b></td>
					<td>${d.jurusan}</td>
					</tr>
				<tr>
					<td><b>Status Pendidikan</b></td>
					<td>${d.status_pendidikan}</td>
				</tr>
				<tr>
					<td><b>Keterangan Nilai</b></td>
					<td>${d.keterangan_nilai}</td>
				</tr>
				<tr>
					<td><b>Tahun Masuk s/d Keluar</b></td>
					<td>${d.tahun_masuk_keluar}</td>
				</tr>
       		 </table>`
            );
        }

        $('#btn-add-pendidikan').on('click', function() {
            let application_id = "<?= $ck['application_id'] ?? "" ?>"
            let employee_id = "<?= $ck['employee_id'] ?? "" ?>"
            $.confirm({
                title: 'Prompt!',
                type: 'blue',
                theme: 'material',
                columnClass: 'col-12 col-md-8 col-lg-8',
                content: function() {
                    var self = this;
                    return $.ajax({
                        url: '<?= base_url() ?>fack/dt_add_pendidikan',
                        dataType: 'json',
                        method: 'POST',
                        data: {
                            application_id: application_id
                        }
                    }).done(function(response) {


                        console.log(response.tingkat_pendidikan_sudah_input);

                        array_tingkat_pendidikan = [];
                        if (response.tingkat_pendidikan_sudah_input.length > 0) {
                            for (let index = 0; index < response.tingkat_pendidikan_sudah_input.length; index++) {
                                array_tingkat_pendidikan.push(response.tingkat_pendidikan_sudah_input[index].tingkat_pendidikan_ada);
                            }
                            console.log(array_tingkat_pendidikan)
                        }


                        opt_custom = '';
                        opt_custom += `${array_tingkat_pendidikan.includes('SD') ? '' : '<option value="SD">SD</option>'}`
                        opt_custom += `${array_tingkat_pendidikan.includes('SLTP') ? '' : '<option value="SLTP">SLTP</option>'}`
                        opt_custom += `${array_tingkat_pendidikan.includes('SLTA') ? '' : '<option value="SLTA">SLTA</option>'}`
                        opt_custom += `${array_tingkat_pendidikan.includes('AKADEMI') ? '' : '<option value="AKADEMI">AKADEMI</option>'}`
                        opt_custom += `${array_tingkat_pendidikan.includes('S1') ? '' : '<option value="S1">S1</option>'}`
                        opt_custom += `${array_tingkat_pendidikan.includes('S2') ? '' : '<option value="S2">S2</option>'}`

                        self.setContent(`
					<form action="" id="form-fack-pendidikan" class="formName">
						<div class="mb-3 col-12">
                            <input type="hidden" name="application_id_pendidikan" id="application_id_pendidikan" value="${application_id}" readonly>
                            <input type="hidden" name="employee_id_pendidikan" id="employee_id_pendidikan" value="${employee_id}" readonly>
                        </div>
						<div class="mb-3 col-12">
							<label for="tingkat_pendidikan" class="form-label-custom required">Tingkat Pendidikan</label>
							<select id="nice-select-tingkat-pendidikan" name="tingkat_pendidikan" class="wide mb-3 tingkat_pendidikan">
                                ${opt_custom}
							</select>
						</div>
						<div class="mb-3 col-12">
							<label for="nama_instansi" class="form-label-custom required">Nama Instansi</label>
							<input type="text" class="form-control border-custom nama_instansi" name="nama_instansi" id="nama_instansi" value="">
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please provide a valid data.
							</div>
						</div>
						<div class="mb-3 col-12">
							<label for="tempat_instansi" class="form-label-custom">Tempat Instansi</label>
							<input type="text" class="form-control border-custom tempat_instansi" name="tempat_instansi" id="tempat_instansi" value="">
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please provide a valid data.
							</div>
						</div>
						<div class="mb-3 col-12">
							<label for="jurusan" class="form-label-custom">Jurusan</label>
							<input type="text" class="form-control border-custom jurusan" name="jurusan" id="jurusan" value="">
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please provide a valid data.
							</div>
						</div>
						<div class="mb-3 col-12">
							<label for="status_pendidikan" class="form-label-custom required">Status Pendidikan</label>
							<select id="nice-select-status-pendidikan" name="status_pendidikan" class="wide mb-3 status_pendidikan">
								<option value="LULUS">LULUS</option>
								<option value="BELUM LULUS">BELUM LULUS</option>
							</select>
						</div>
						<div class="mb-3 col-12">
							<label for="keterangan_nilai" class="form-label-custom">Keterangan Nilai (IPK atau sejenisnya)</label>
							<input type="text" class="form-control border-custom keterangan_nilai" name="keterangan_nilai" id="keterangan_nilai" value="">
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please provide a valid data.
							</div>
						</div>
						<div class="mb-3 col-12">
							<label for="tahun_masuk" class="form-label-custom required">Tahun Masuk</label>
							<input type="text" class="form-control border-custom tahun tahun_masuk" placeholder="____" name="tahun_masuk" id="tahun_masuk" value="">
							<span class="badge text-dark small">Contoh (thn): 2018</span>
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please provide a valid data.
							</div>
						</div>
						<div class="mb-3 col-12">
							<label for="tahun_keluar" class="form-label-custom required">Tahun Keluar</label>
							<input type="text" class="form-control border-custom tahun tahun_keluar" placeholder="____" name="tahun_keluar" id="tahun_keluar" value="">
							<span class="badge text-dark small">Contoh (thn): 2023</span>
							<div class="valid-feedback">
								Looks good!
							</div>
							<div class="invalid-feedback">
								Please provide a valid data.
							</div>
						</div>
					</form>`);
                        self.setTitle('Input Data Pendidikan');
                    }).fail(function() {
                        self.setContent('Something went wrong.');
                    });
                },
                buttons: {
                    cancel: function() {
                        //close
                    },
                    formSubmit: {
                        text: 'Submit',
                        btnClass: 'btn-blue',
                        action: function() {
                            let tingkat_pendidikan = this.$content.find('.tingkat_pendidikan').val();
                            if (!tingkat_pendidikan) {
                                $.alert('Anda belum memilih tingkat pendidikan');
                                return false;
                            }
                            let nama_instansi = this.$content.find('.nama_instansi').val();
                            if (!nama_instansi) {
                                $.alert('Anda belum mengisi nama instansi');
                                return false;
                            }
                            let status_pendidikan = this.$content.find('.status_pendidikan').val();
                            if (!status_pendidikan) {
                                $.alert('Anda belum mengisi status pendidikan');
                                return false;
                            }
                            let tahun_masuk = this.$content.find('.tahun_masuk').val();
                            if (!tahun_masuk) {
                                $.alert('Anda belum mengisi tahun masuk');
                                return false;
                            }
                            let tahun_keluar = this.$content.find('.tahun_keluar').val();
                            if (!tahun_keluar) {
                                $.alert('Anda belum mengisi tahun keluar');
                                return false;
                            }

                            keterangan_nilai = $('#keterangan_nilai').val();
                            status_pendidikan = $('#nice-select-status-pendidikan').val()
                            jurusan = $('#jurusan').val()
                            tempat_instansi = $('#tempat_instansi').val()
                            employee_id_pendidikan = $('#employee_id_pendidikan').val()
                            application_id_pendidikan = $('#application_id_pendidikan').val()

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
                                    $.ajax({
                                        url: '<?= base_url() ?>fack/store_pendidikan',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            application_id_pendidikan: application_id_pendidikan,
                                            employee_id_pendidikan: employee_id_pendidikan,
                                            tingkat_pendidikan: tingkat_pendidikan,
                                            nama_instansi: nama_instansi,
                                            tempat_instansi: tempat_instansi,
                                            jurusan: jurusan,
                                            status_pendidikan: status_pendidikan,
                                            keterangan_nilai: keterangan_nilai,
                                            tahun_masuk: tahun_masuk,
                                            tahun_keluar: tahun_keluar
                                        },
                                        beforeSend: function() {

                                        },
                                        success: function(response) {},
                                        error: function(xhr) {},
                                        complete: function() {},
                                    }).done(function(response) {
                                        console.log(response);
                                        if (response.status == true) {
                                            dt_daftar_pendidikan();
                                            setTimeout(() => {
                                                $(".tab-content").height('100%');
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Berhasil menyimpan data pendidikan!',
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                        } else {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-close',
                                                title: 'Oops!',
                                                theme: 'material',
                                                type: 'red',
                                                content: 'Gagal menyimpan data pendidikan!',
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
                                                content: 'Gagal menyimpan data pendidikan!' + textStatus,
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
                onContentReady: function() {
                    $(".tahun").mask('0000');

                    let niceTingkatPendidikan = NiceSelect.bind(document.getElementById('nice-select-tingkat-pendidikan'), options);
                    let niceStatusPendidikan = NiceSelect.bind(document.getElementById('nice-select-status-pendidikan'), options);

                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function(e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });
        });

        function hapus_pendidikan(id, application_id) {
            $.confirm({
                title: 'Alert!',
                theme: 'material',
                type: 'red',
                content: 'Apakah anda yakin hapus data pendidikan ini!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                    hapus: {
                        text: 'Ya, Hapus!',
                        btnClass: 'btn-red',
                        action: function() {

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

                                    $.ajax({
                                        url: '<?= base_url() ?>fack/hapus_pendidikan',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            id: id,
                                            application_id: application_id
                                        },
                                    }).done(function(response) {
                                        console.log(response);
                                        if (response.hapus == true) {
                                            dt_daftar_pendidikan();
                                            setTimeout(() => {
                                                $(".tab-content").height('100%');
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Berhasil hapus data pendidikan!',
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                        } else {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-close',
                                                title: 'Oops!',
                                                theme: 'material',
                                                type: 'red',
                                                content: 'Gagal hapus data pendidikan!',
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
                                                content: 'Gagal menyimpan data pendidikan!' + textStatus,
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
                        }
                    }
                },
            });
        }


        dt_daftar_pengalaman_kerja();

        function dt_daftar_pengalaman_kerja() {
            let apl_id = '<?= $ck['application_id']; ?>'
            var table = $('#dt_daftar_pengalaman_kerja').DataTable({
                orderCellsTop: false,
                // fixedHeader: true,
                "searching": false,
                "info": false,
                "paging": false,
                "destroy": true,
                "ordering": false,
                "autoWidth": false,
                "order": [
                    [0, 'desc']
                ],
                responsive: true,
                "ajax": {
                    "dataType": 'json',
                    "type": "POST",
                    "data": {
                        application_id: apl_id
                    },
                    "url": "<?= base_url(); ?>fack/dt_daftar_pengalaman_kerja",
                },
                "columns": [{
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        defaultContent: '',
                    },
                    {
                        "data": "nama_perusahaan",
                    },
                    {
                        "data": "posisi",
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row, meta) {
                            return `<a role="button" class="button-4-icon" onclick="hapus_pengalaman_kerja('${row['id']}','${row['application_id']}')"><i class="bi bi-trash"></i><a>`
                        },
                    },
                    {
                        "data": "lokasi",
                        "className": "d-none"
                    },
                    {
                        "data": "tahun_masuk",
                        "render": function(data, type, row, meta) {
                            return `${row['tahun_masuk']} s/d ${row['tahun_keluar']}`
                        },
                        "className": "d-none"
                    },
                    {
                        "data": "salary_awal",
                        "className": "d-none"
                    },
                    {
                        "data": "salary_akhir",
                        "className": "d-none"
                    },
                    {
                        "data": "alasan_keluar",
                        "className": "d-none"
                    },
                ],
            });
        }

        // Add event listener for opening and closing details
        $('#dt_daftar_pengalaman_kerja tbody').on('click', 'td.dt-control', function() {
            var tr = $(this).closest('tr');
            var row = $('#dt_daftar_pengalaman_kerja').DataTable().row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(detail_pengalaman_kerja(row.data())).show();
                tr.addClass('shown');
                $(".tab-content").height('100%');
            }
        });

        function detail_pengalaman_kerja(d) {
            // `d` is the original data object for the row
            return (
                `<table class="table table-sm">
            <tr>
                <td><b>Lokasi</b></td>
                <td>${d.lokasi}</td>
            </tr>
            <tr>
                <td><b>Tahun Masuk/Keluar</b></td>
                <td>${d.tahun_masuk} s/d ${d.tahun_keluar}</td>
                </tr>
            <tr>
                <td><b>Salary Awal</b></td>
                <td>${formatNumber(d.salary_awal)}</td>
            </tr>
            <tr>
                <td><b>Salary Akhir</b></td>
                <td>${formatNumber(d.salary_akhir)}</td>
            </tr>
            </table>`
            );
        }


        $('#btn-add-pengalaman-kerja').on('click', function() {
            let application_id = "<?= $ck['application_id'] ?? "" ?>"
            let employee_id = "<?= $ck['employee_id'] ?? "" ?>"
            $.confirm({
                title: 'Input Data Pengalaman Kerja',
                type: 'blue',
                theme: 'material',
                columnClass: 'col-12 col-md-8 col-lg-8',
                content: `
					<form action="" id="form-fack-pengalaman-kerja" class="formName">
                        <div class="row col-12">

                            <div class="mb-3 col-12">
                                <input type="hidden" name="application_id_pengalaman_kerja" id="application_id_pengalaman_kerja" value="${application_id}" readonly>
                                <input type="hidden" name="employee_id_pengalaman_kerja" id="employee_id_pengalaman_kerja" value="${employee_id}" readonly>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="nama_perusahaan" class="form-label-custom required">Nama Perusahaan</label>
                                <input type="text" class="form-control border-custom nama_perusahaan" name="nama_perusahaan" id="nama_perusahaan" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="lokasi_perusahaan" class="form-label-custom required">Lokasi Perusahaan</label>
                                <textarea name="lokasi_perusahaan" id="lokasi_perusahaan" class="form-control border-custom" cols="30" rows="2"></textarea>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="posisi" class="form-label-custom">Posisi Sebagai</label>
                                <input type="text" class="form-control border-custom posisi" name="posisi" id="posisi" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-6">
                                <label for="tahun_masuk_bekerja" class="form-label-custom required">Tahun Masuk</label>
                                <input type="tel" pattern="\d*"" class="form-control border-custom tahun tahun_masuk_bekerja" placeholder="____" name="tahun_masuk_bekerja" id="tahun_masuk_bekerja" value="">
                                <span class="badge text-dark small">Contoh (thn): 2018</span>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-6">
                                <label for="tahun_keluar_bekerja" class="form-label-custom required">Tahun Keluar</label>
                                <input type="tel" pattern="\d*" class="form-control border-custom tahun tahun_keluar_bekerja" placeholder="____" name="tahun_keluar_bekerja" id="tahun_keluar_bekerja" value="">
                                <span class="badge text-dark small">Contoh (thn): 2023</span>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-6">
                                <label for="salary_awal_bekerja" class="form-label-custom">Salary Awal</label>
                                <input type="tel" pattern="\d*" class="form-control border-custom salary_awal_bekerja" placeholder="Salary Awal Masuk Kerja" name="salary_awal_bekerja" id="salary_awal_bekerja" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-6">
                                <label for="salary_akhir_bekerja" class="form-label-custom">Salary Akhir</label>
                                <input type="tel" pattern="\d*" class="form-control border-custom salary_akhir_bekerja" placeholder="Salary Akhir Keluar Kerja" name="salary_akhir_bekerja" id="salary_akhir_bekerja" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="alasan_keluar_bekerja" class="form-label-custom required">Alasan Keluar</label>
                                <textarea name="alasan_keluar_bekerja" id="alasan_keluar_bekerja" class="form-control border-custom" cols="30" rows="5"></textarea>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                        </div>
					</form>`,
                buttons: {
                    cancel: function() {
                        //close
                    },
                    formSubmit: {
                        text: 'Submit',
                        btnClass: 'btn-blue',
                        action: function() {
                            let nama_perusahaan = this.$content.find('#nama_perusahaan').val();
                            if (!nama_perusahaan) {
                                $.alert('Anda belum mengisi nama perusahaan');
                                return false;
                            }
                            let lokasi_perusahaan = this.$content.find('#lokasi_perusahaan').val();
                            if (!lokasi_perusahaan) {
                                $.alert('Anda belum mengisi lokasi perusahaan');
                                return false;
                            }
                            let posisi = this.$content.find('#posisi').val();
                            if (!posisi) {
                                $.alert('Anda belum mengisi posisi');
                                return false;
                            }
                            let tahun_masuk_bekerja = this.$content.find('#tahun_masuk_bekerja').val();
                            if (!tahun_masuk_bekerja) {
                                $.alert('Anda belum mengisi tahun masuk');
                                return false;
                            }
                            let tahun_keluar_bekerja = this.$content.find('#tahun_keluar_bekerja').val();
                            if (!tahun_keluar_bekerja) {
                                $.alert('Anda belum mengisi tahun keluar');
                                return false;
                            }
                            let alasan_keluar = this.$content.find('#alasan_keluar_bekerja').val();
                            if (!alasan_keluar) {
                                $.alert('Anda belum mengisi alasan keluar bekerja');
                                return false;
                            }

                            salary_awal_bekerja = $('#salary_awal_bekerja').val();
                            salary_akhir_bekerja = $('#salary_akhir_bekerja').val()

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
                                    $.ajax({
                                        url: '<?= base_url() ?>fack/store_pengalaman_kerja',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            application_id_pengalaman_kerja: application_id,
                                            employee_id_pengalaman_kerja: employee_id,
                                            nama_perusahaan: nama_perusahaan,
                                            lokasi_perusahaan: lokasi_perusahaan,
                                            posisi: posisi,
                                            tahun_masuk_bekerja: tahun_masuk_bekerja,
                                            tahun_keluar_bekerja: tahun_keluar_bekerja,
                                            alasan_keluar: alasan_keluar,
                                            salary_awal_bekerja: salary_awal_bekerja,
                                            salary_akhir_bekerja: salary_akhir_bekerja
                                        },
                                        beforeSend: function() {

                                        },
                                        success: function(response) {},
                                        error: function(xhr) {},
                                        complete: function() {},
                                    }).done(function(response) {
                                        console.log(response);
                                        if (response.status == true) {
                                            dt_daftar_pengalaman_kerja();
                                            setTimeout(() => {
                                                $(".tab-content").height('100%');
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Berhasil menyimpan pengalaman kerja!',
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                        } else {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-close',
                                                title: 'Oops!',
                                                theme: 'material',
                                                type: 'red',
                                                content: 'Gagal menyimpan pengalaman kerja!',
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
                                                content: 'Gagal menyimpan pengalaman kerja!' + textStatus,
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
                onContentReady: function() {
                    $(".tahun").mask('0000');
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function(e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });
        });


        function hapus_pengalaman_kerja(id, application_id) {
            $.confirm({
                title: 'Alert!',
                theme: 'material',
                type: 'red',
                content: 'Apakah anda yakin hapus data pengalaman kerja ini!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                    hapus: {
                        text: 'Ya, Hapus!',
                        btnClass: 'btn-red',
                        action: function() {

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

                                    $.ajax({
                                        url: '<?= base_url() ?>fack/hapus_pengalaman_kerja',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            id: id,
                                            application_id: application_id
                                        },
                                    }).done(function(response) {
                                        console.log(response);
                                        if (response.hapus == true) {
                                            dt_daftar_pengalaman_kerja();
                                            setTimeout(() => {
                                                $(".tab-content").height('100%');
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Berhasil hapus data pengalaman kerja!',
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                        } else {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-close',
                                                title: 'Oops!',
                                                theme: 'material',
                                                type: 'red',
                                                content: 'Gagal hapus data pengalaman kerja!',
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
                                                content: 'Gagal menyimpan data pengalaman kerja!' + textStatus,
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
                        }
                    }
                },
            });
        }



        // Pengalaman Organisasi

        dt_daftar_pengalaman_organisasi();

        function dt_daftar_pengalaman_organisasi() {
            let apl_id = '<?= $ck['application_id']; ?>'
            var table = $('#dt_daftar_pengalaman_organisasi').DataTable({
                orderCellsTop: false,
                // fixedHeader: true,
                "searching": false,
                "info": false,
                "paging": false,
                "destroy": true,
                "ordering": false,
                "autoWidth": false,
                "order": [
                    [0, 'desc']
                ],
                responsive: true,
                "ajax": {
                    "dataType": 'json',
                    "type": "POST",
                    "data": {
                        application_id: apl_id
                    },
                    "url": "<?= base_url(); ?>fack/dt_daftar_pengalaman_organisasi",
                },
                "columns": [{
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        defaultContent: '',
                    },
                    {
                        "data": "nama_organisasi",
                    },
                    {
                        "data": "posisi",
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row, meta) {
                            return `<a role="button" class="button-4-icon" onclick="hapus_pengalaman_organisasi('${row['id']}','${row['application_id']}')"><i class="bi bi-trash"></i><a>`
                        },
                    },
                    {
                        "data": "jenis_kegiatan",
                        "className": "d-none"
                    },
                    {
                        "data": "lokasi",
                        "className": "d-none"
                    },
                    {
                        "data": "masa_aktif",
                        "render": function(data, type, row, meta) {
                            return `${row['masa_aktif']}`
                        },
                        "className": "d-none"
                    },
                ],
            });
        }

        // Add event listener for opening and closing details
        $('#dt_daftar_pengalaman_organisasi tbody').on('click', 'td.dt-control', function() {
            var tr = $(this).closest('tr');
            var row = $('#dt_daftar_pengalaman_organisasi').DataTable().row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(detail_pengalaman_organisasi(row.data())).show();
                tr.addClass('shown');
                $(".tab-content").height('100%');
            }
        });

        function detail_pengalaman_organisasi(d) {
            // `d` is the original data object for the row
            return (
                `<table class="table table-sm">
                <tr>
                    <td><b>Jenis Kegiatan</b></td>
                    <td>${d.jenis_kegiatan}</td>
                </tr>
                <tr>
                    <td><b>Masa Aktif</b></td>
                    <td>${d.lokasi}</td>
                    </tr>
                <tr>
                <tr>
                    <td><b>Masa Aktif</b></td>
                    <td>${d.masa_aktif}</td>
                </tr>
            </table>`
            );
        }


        $('#btn-add-pengalaman-organisasi').on('click', function() {
            let application_id = "<?= $ck['application_id'] ?? "" ?>"
            let employee_id = "<?= $ck['employee_id'] ?? "" ?>"
            $.confirm({
                title: 'Input Data Pengalaman Organisasi',
                type: 'blue',
                theme: 'material',
                columnClass: 'col-12 col-md-8 col-lg-8',
                content: `<form action="" id="form-fack-pengalaman-organisasi" class="formName">
                        <div class="row col-12 mb-3">
                            <div class="mb-3 col-12">
                                <input type="hidden" name="application_id_pengalaman_organisasi" id="application_id_pengalaman_organisasi" value="${application_id}" readonly>
                                <input type="hidden" name="employee_id_pengalaman_organisasi" id="employee_id_pengalaman_organisasi" value="${employee_id}" readonly>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="nama_organisasi" class="form-label-custom required">Nama Organisasi</label>
                                <input type="text" class="form-control border-custom nama_organisasi" name="nama_organisasi" id="nama_organisasi" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="lokasi_organisasi" class="form-label-custom required">Lokasi Organisasi</label>
                                <textarea name="lokasi_organisasi" id="lokasi_organisasi" class="form-control border-custom" cols="30" rows="2"></textarea>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="posisi_organisasi" class="form-label-custom required">Peran/Posisi/Jabatan</label>
                                <input type="text" class="form-control border-custom posisi_organisasi" name="posisi_organisasi" id="posisi_organisasi" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="jenis_kegiatan" class="form-label-custom required">Jenis Kegiatan</label>
                                <input type="text" class="form-control border-custom jenis_kegiatan" name="jenis_kegiatan" id="jenis_kegiatan" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-12">
                                <label for="tahun_masuk_bekerja" class="form-label-custom required">Masa Aktif</label>
                                <input type="text" class="form-control border-custom"  name="masa_aktif" id="masa_aktif" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                        </div>
					</form>`,
                buttons: {
                    cancel: function() {
                        //close
                    },
                    formSubmit: {
                        text: 'Submit',
                        btnClass: 'btn-blue',
                        action: function() {
                            let nama_organisasi = this.$content.find('#nama_organisasi').val();
                            if (!nama_organisasi) {
                                $.alert('Anda belum mengisi nama organisasi');
                                return false;
                            }
                            let lokasi_organisasi = this.$content.find('#lokasi_organisasi').val();
                            if (!lokasi_organisasi) {
                                $.alert('Anda belum mengisi lokasi organisasi');
                                return false;
                            }
                            let posisi_organisasi = this.$content.find('#posisi_organisasi').val();
                            if (!posisi_organisasi) {
                                $.alert('Anda belum mengisi posisi organisasi');
                                return false;
                            }
                            let jenis_kegiatan = this.$content.find('#jenis_kegiatan').val();
                            if (!jenis_kegiatan) {
                                $.alert('Anda belum mengisi jenis kegiatan');
                                return false;
                            }
                            let masa_aktif = this.$content.find('#masa_aktif').val();
                            if (!masa_aktif) {
                                $.alert('Anda belum mengisi masa aktif');
                                return false;
                            }

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
                                    $.ajax({
                                        url: '<?= base_url() ?>fack/store_pengalaman_organisasi',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            application_id_pengalaman_organisasi: application_id,
                                            employee_id_pengalaman_organisasi: employee_id,
                                            nama_organisasi: nama_organisasi,
                                            lokasi_organisasi: lokasi_organisasi,
                                            posisi_organisasi: posisi_organisasi,
                                            jenis_kegiatan: jenis_kegiatan,
                                            masa_aktif: masa_aktif,
                                        },
                                        beforeSend: function() {

                                        },
                                        success: function(response) {},
                                        error: function(xhr) {},
                                        complete: function() {},
                                    }).done(function(response) {
                                        console.log(response);
                                        if (response.status == true) {
                                            dt_daftar_pengalaman_organisasi();
                                            setTimeout(() => {
                                                $(".tab-content").height('100%');
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Berhasil menyimpan pengalaman organisasi!',
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                        } else {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-close',
                                                title: 'Oops!',
                                                theme: 'material',
                                                type: 'red',
                                                content: 'Gagal menyimpan pengalaman organisasi!',
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
                                                content: 'Gagal menyimpan pengalaman organisasi!' + textStatus,
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
                onContentReady: function() {
                    $(".tahun").mask('0000');
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function(e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });
        });




        function hapus_pengalaman_organisasi(id, application_id) {
            $.confirm({
                title: 'Alert!',
                theme: 'material',
                type: 'red',
                content: 'Apakah anda yakin hapus data pengalaman organisasi ini!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                    hapus: {
                        text: 'Ya, Hapus!',
                        btnClass: 'btn-red',
                        action: function() {

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

                                    $.ajax({
                                        url: '<?= base_url() ?>fack/hapus_pengalaman_organisasi',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            id: id,
                                            application_id: application_id
                                        },
                                    }).done(function(response) {
                                        console.log(response);
                                        if (response.hapus == true) {
                                            dt_daftar_pengalaman_organisasi();
                                            setTimeout(() => {
                                                $(".tab-content").height('100%');
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Berhasil hapus data pengalaman organisasi!',
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                        } else {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-close',
                                                title: 'Oops!',
                                                theme: 'material',
                                                type: 'red',
                                                content: 'Gagal hapus data pengalaman organisasi!',
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
                                                content: 'Gagal menyimpan data pengalaman organisasi!' + textStatus,
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
                        }
                    }
                },
            });
        }


        // Penguasaan Bahasa Asing

        dt_daftar_bahasa();

        function dt_daftar_bahasa() {
            let apl_id = '<?= $ck['application_id']; ?>'
            var table = $('#dt_daftar_bahasa').DataTable({
                orderCellsTop: false,
                // fixedHeader: true,
                "searching": false,
                "info": false,
                "paging": false,
                "destroy": true,
                "ordering": false,
                "autoWidth": false,
                "order": [
                    [0, 'desc']
                ],
                responsive: true,
                "ajax": {
                    "dataType": 'json',
                    "type": "POST",
                    "data": {
                        application_id: apl_id
                    },
                    "url": "<?= base_url(); ?>fack/dt_daftar_bahasa",
                },
                "columns": [{
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        defaultContent: '',
                    },
                    {
                        "data": "bahasa",
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row, meta) {
                            return `<a role="button" class="button-4-icon" onclick="hapus_bahasa('${row['id']}','${row['application_id']}')"><i class="bi bi-trash"></i><a>`
                        },
                    },
                    {
                        "data": "lisan",
                        "className": "d-none"
                    },
                    {
                        "data": "tulisan",
                        "className": "d-none"
                    },
                ],
            });
        }

        // Add event listener for opening and closing details
        $('#dt_daftar_bahasa tbody').on('click', 'td.dt-control', function() {
            var tr = $(this).closest('tr');
            var row = $('#dt_daftar_bahasa').DataTable().row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(detail_bahasa(row.data())).show();
                tr.addClass('shown');
                $(".tab-content").height('100%');
            }
        });

        function detail_bahasa(d) {
            // `d` is the original data object for the row
            return (
                `<table class="table table-sm">
                <tr>
                    <td><b>Lisan</b></td>
                    <td>${d.lisan}</td>
                </tr>
                <tr>
                    <td><b>Tulisan</b></td>
                    <td>${d.tulisan}</td>
                    </tr>
                <tr>
            </table>`
            );
        }


        $('#btn-add-bahasa').on('click', function() {
            let application_id = "<?= $ck['application_id'] ?? "" ?>"
            let employee_id = "<?= $ck['employee_id'] ?? "" ?>"
            $.confirm({
                title: 'Input Data Pengalaman Bahasa',
                type: 'blue',
                theme: 'material',
                columnClass: 'col-12 col-md-8 col-lg-8',
                content: `<form action="" id="form-fack-bahasa" class="formName">
                        <div class="row col-12 mb-3">
                            <div class="mb-3 col-12">
                                <input type="hidden" name="application_id_pengalaman_bahasa" id="application_id_pengalaman_bahasa" value="${application_id}" readonly>
                                <input type="hidden" name="employee_id_pengalaman_bahasa" id="employee_id_pengalaman_bahasa" value="${employee_id}" readonly>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="bahasa" class="form-label-custom required">Bahasa</label>
                                <input type="text" class="form-control border-custom bahasa" name="bahasa" id="bahasa" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="lisan" class="form-label-custom required">Lisan</label>
                                <select id="lisan" name="lisan" class="wide mb-3 lisan">
                                    <option value="1">Kurang</option>
                                    <option value="2">Cukup</option>
                                    <option value="3">Baik</option>
                                    <option value="4">Baik Sekali</option>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="tulisan" class="form-label-custom required">Tulisan</label>
                                <select id="tulisan" name="tulisan" class="wide mb-3 tulisan">
                                    <option value="1">Kurang</option>
                                    <option value="2">Cukup</option>
                                    <option value="3">Baik</option>
                                    <option value="4">Baik Sekali</option>
                                </select>                                
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                        </div>
					</form>`,
                buttons: {
                    cancel: function() {
                        //close
                    },
                    formSubmit: {
                        text: 'Submit',
                        btnClass: 'btn-blue',
                        action: function() {
                            let bahasa = this.$content.find('#bahasa').val();
                            if (!bahasa) {
                                $.alert('Anda belum mengisi bahasa');
                                return false;
                            }
                            let lisan = this.$content.find('#lisan').val();
                            if (!lisan) {
                                $.alert('Anda belum mengisi kolom lisan');
                                return false;
                            }
                            let tulisan = this.$content.find('#tulisan').val();
                            if (!tulisan) {
                                $.alert('Anda belum mengisi kolom tulisan');
                                return false;
                            }

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
                                    $.ajax({
                                        url: '<?= base_url() ?>fack/store_bahasa',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            application_id_bahasa: application_id,
                                            employee_id_bahasa: employee_id,
                                            bahasa: bahasa,
                                            lisan: lisan,
                                            tulisan: tulisan,
                                        },
                                        beforeSend: function() {

                                        },
                                        success: function(response) {},
                                        error: function(xhr) {},
                                        complete: function() {},
                                    }).done(function(response) {
                                        console.log(response);
                                        if (response.status == true) {
                                            dt_daftar_bahasa();
                                            setTimeout(() => {
                                                $(".tab-content").height('100%');
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Berhasil menyimpan bahasa!',
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                        } else {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-close',
                                                title: 'Oops!',
                                                theme: 'material',
                                                type: 'red',
                                                content: 'Gagal menyimpan bahasa!',
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
                                                content: 'Gagal menyimpan bahasa!' + textStatus,
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
                onContentReady: function() {
                    $(".tahun").mask('0000');
                    let niceLisan = NiceSelect.bind(document.getElementById('lisan'), options);
                    let niceTulisan = NiceSelect.bind(document.getElementById('tulisan'), options);
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function(e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });
        });

        function hapus_bahasa(id, application_id) {
            $.confirm({
                title: 'Alert!',
                theme: 'material',
                type: 'red',
                content: 'Apakah anda yakin hapus data bahasa ini!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                    hapus: {
                        text: 'Ya, Hapus!',
                        btnClass: 'btn-red',
                        action: function() {

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

                                    $.ajax({
                                        url: '<?= base_url() ?>fack/hapus_bahasa',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            id: id,
                                            application_id: application_id
                                        },
                                    }).done(function(response) {
                                        console.log(response);
                                        if (response.hapus == true) {
                                            dt_daftar_bahasa();
                                            setTimeout(() => {
                                                $(".tab-content").height('100%');
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Berhasil hapus data bahasa!',
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                        } else {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-close',
                                                title: 'Oops!',
                                                theme: 'material',
                                                type: 'red',
                                                content: 'Gagal hapus data bahasa!',
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
                                                content: 'Gagal menyimpan data bahasa!' + textStatus,
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
                        }
                    }
                },
            });
        }


        // Kursus Training
        dt_daftar_training();

        function dt_daftar_training() {
            let apl_id = '<?= $ck['application_id']; ?>'
            var table = $('#dt_daftar_training').DataTable({
                orderCellsTop: false,
                // fixedHeader: true,
                "searching": false,
                "info": false,
                "paging": false,
                "destroy": true,
                "ordering": false,
                "autoWidth": false,
                "order": [
                    [0, 'desc']
                ],
                responsive: true,
                "ajax": {
                    "dataType": 'json',
                    "type": "POST",
                    "data": {
                        application_id: apl_id
                    },
                    "url": "<?= base_url(); ?>fack/dt_daftar_training",
                },
                "columns": [{
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        defaultContent: '',
                    },
                    {
                        "data": "jenis",
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row, meta) {
                            return `<a role="button" class="button-4-icon" onclick="hapus_training('${row['id']}','${row['application_id']}')"><i class="bi bi-trash"></i><a>`
                        },
                    },
                    {
                        "data": "penyelenggara",
                        "className": "d-none"
                    },
                    {
                        "data": "tempat",
                        "className": "d-none"
                    },
                    {
                        "data": "tahun",
                        "className": "d-none"
                    },
                    {
                        "data": "dibiayai_oleh",
                        "className": "d-none"
                    },
                ],
            });
        }

        // Add event listener for opening and closing details
        $('#dt_daftar_training tbody').on('click', 'td.dt-control', function() {
            var tr = $(this).closest('tr');
            var row = $('#dt_daftar_training').DataTable().row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(detail_training(row.data())).show();
                tr.addClass('shown');
                $(".tab-content").height('100%');
            }
        });

        function detail_training(d) {
            // `d` is the original data object for the row
            return (
                `<table class="table table-sm">
            <tr>
                <td><b>Penyelenggara</b></td>
                <td>${d.penyelenggara}</td>
            </tr>
            <tr>
                <td><b>Tempat</b></td>
                <td>${d.tempat}</td>
            </tr>
            <tr>
                <td><b>Tahun</b></td>
                <td>${d.tahun}</td>
             </tr>
            <tr>
                <td><b>Dibiayai Oleh</b></td>
                <td>${d.dibiayai_oleh}</td>
             </tr>
        </table>`
            );
        }


        $('#btn-add-training').on('click', function() {
            let application_id = "<?= $ck['application_id'] ?? "" ?>"
            let employee_id = "<?= $ck['employee_id'] ?? "" ?>"
            $.confirm({
                title: 'Input Data Training / Kursus',
                type: 'blue',
                theme: 'material',
                columnClass: 'col-12 col-md-8 col-lg-8',
                content: `<form action="" id="form-fack-bahasa" class="formName">
                        <div class="row col-12 mb-3">
                            <div class="mb-3 col-12">
                                <input type="hidden" name="application_id_training" id="application_id_training" value="${application_id}" readonly>
                                <input type="hidden" name="employee_id_training" id="employee_id_training" value="${employee_id}" readonly>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="jenis_training" class="form-label-custom required">Jenis Training/Kursus</label>
                                <input type="text" class="form-control border-custom jenis_training" name="jenis_training" id="jenis_training" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="penyelenggara" class="form-label-custom required">Penyelenggara</label>
                                <input type="text" class="form-control border-custom penyelenggara" name="penyelenggara" id="penyelenggara" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="tempat_training" class="form-label-custom required">Tempat</label>
                                <input type="text" class="form-control border-custom tempat_training" name="tempat_training" id="tempat_training" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="tahun_training" class="form-label-custom required">Tahun</label>
                                <input type="text" class="form-control border-custom tahun tahun_training" name="tahun_training" id="tahun_training" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="dibiayai_oleh" class="form-label-custom required">Dibiayai Oleh</label>
                                <input type="text" class="form-control border-custom dibiayai_oleh" name="dibiayai_oleh" id="dibiayai_oleh" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            
                        </div>
					</form>`,
                buttons: {
                    cancel: function() {
                        //close
                    },
                    formSubmit: {
                        text: 'Submit',
                        btnClass: 'btn-blue',
                        action: function() {
                            let jenis_training = this.$content.find('#jenis_training').val();
                            if (!jenis_training) {
                                $.alert('Anda belum mengisi jenis training');
                                return false;
                            }
                            let penyelenggara = this.$content.find('#penyelenggara').val();
                            if (!penyelenggara) {
                                $.alert('Anda belum mengisi kolom penyelenggara');
                                return false;
                            }
                            let tempat_training = this.$content.find('#tempat_training').val();
                            if (!tempat_training) {
                                $.alert('Anda belum mengisi kolom tempat training');
                                return false;
                            }
                            let tahun_training = this.$content.find('#tahun_training').val();
                            if (!tahun_training) {
                                $.alert('Anda belum mengisi kolom tahun training');
                                return false;
                            }
                            let dibiayai_oleh = this.$content.find('#dibiayai_oleh').val();
                            if (!dibiayai_oleh) {
                                $.alert('Anda belum mengisi kolom dibiayai oleh');
                                return false;
                            }

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
                                    $.ajax({
                                        url: '<?= base_url() ?>fack/store_training',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            application_id_training: application_id,
                                            employee_id_training: employee_id,
                                            jenis_training: jenis_training,
                                            penyelenggara: penyelenggara,
                                            tempat_training: tempat_training,
                                            tahun_training: tahun_training,
                                            dibiayai_oleh: dibiayai_oleh,
                                        },
                                        beforeSend: function() {

                                        },
                                        success: function(response) {},
                                        error: function(xhr) {},
                                        complete: function() {},
                                    }).done(function(response) {
                                        console.log(response);
                                        if (response.status == true) {
                                            dt_daftar_training();
                                            setTimeout(() => {
                                                $(".tab-content").height('100%');
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Berhasil menyimpan training!',
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                        } else {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-close',
                                                title: 'Oops!',
                                                theme: 'material',
                                                type: 'red',
                                                content: 'Gagal menyimpan training!',
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
                                                content: 'Gagal menyimpan training!' + textStatus,
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
                onContentReady: function() {
                    $(".tahun").mask('0000');
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function(e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });
        });


        function hapus_training(id, application_id) {
            $.confirm({
                title: 'Alert!',
                theme: 'material',
                type: 'red',
                content: 'Apakah anda yakin hapus data training ini!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                    hapus: {
                        text: 'Ya, Hapus!',
                        btnClass: 'btn-red',
                        action: function() {

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

                                    $.ajax({
                                        url: '<?= base_url() ?>fack/hapus_training',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            id: id,
                                            application_id: application_id
                                        },
                                    }).done(function(response) {
                                        console.log(response);
                                        if (response.hapus == true) {
                                            dt_daftar_training();
                                            setTimeout(() => {
                                                $(".tab-content").height('100%');
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Berhasil hapus data training!',
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                        } else {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-close',
                                                title: 'Oops!',
                                                theme: 'material',
                                                type: 'red',
                                                content: 'Gagal hapus data training!',
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
                                                content: 'Gagal menyimpan data training!' + textStatus,
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
                        }
                    }
                },
            });
        }



        // Kursus Training
        dt_daftar_pekerjaan_favorit();

        function dt_daftar_pekerjaan_favorit() {
            let apl_id = '<?= $ck['application_id']; ?>'
            var table = $('#dt_daftar_pekerjaan_favorit').DataTable({
                orderCellsTop: false,
                // fixedHeader: true,
                "searching": false,
                "info": false,
                "paging": false,
                "destroy": true,
                "ordering": false,
                "autoWidth": false,
                "order": [
                    [0, 'desc']
                ],
                responsive: true,
                "ajax": {
                    "dataType": 'json',
                    "type": "POST",
                    "data": {
                        application_id: apl_id
                    },
                    "url": "<?= base_url(); ?>fack/dt_daftar_pekerjaan_favorit",
                },
                "columns": [{
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        defaultContent: '',
                    },
                    {
                        "data": "posisi",
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row, meta) {
                            return `<a role="button" class="button-4-icon" onclick="hapus_pekerjaan_favorit('${row['id']}','${row['application_id']}')"><i class="bi bi-trash"></i><a>`
                        },
                    },
                    {
                        "data": "ekspektasi_gaji",
                        "className": "d-none"
                    },
                ],
            });
        }

        // Add event listener for opening and closing details
        $('#dt_daftar_pekerjaan_favorit tbody').on('click', 'td.dt-control', function() {
            var tr = $(this).closest('tr');
            var row = $('#dt_daftar_pekerjaan_favorit').DataTable().row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(detail_pekerjaan_favorit(row.data())).show();
                tr.addClass('shown');
                $(".tab-content").height('100%');
            }
        });

        function detail_pekerjaan_favorit(d) {
            // `d` is the original data object for the row
            return (
                `<table class="table table-sm">
            <tr>
                <td><b>Ekspektasi Gaji</b></td>
                <td>${formatNumber(d.ekspektasi_gaji)}</td>
            </tr>
        </table>`
            );
        }


        $('#btn-add-pekerjaan-favorit').on('click', function() {
            let application_id = "<?= $ck['application_id'] ?? "" ?>"
            let employee_id = "<?= $ck['employee_id'] ?? "" ?>"
            $.confirm({
                title: 'Input Data Pekerjaan yang diminati',
                type: 'blue',
                theme: 'material',
                columnClass: 'col-12 col-md-8 col-lg-8',
                content: `<form action="" id="form-fack-bahasa" class="formName">
                        <div class="row col-12 mb-3">
                            <div class="mb-3 col-12">
                                <input type="hidden" name="application_id_pekerjaan_favorit" id="application_id_pekerjaan_favorit" value="${application_id}" readonly>
                                <input type="hidden" name="employee_id_pekerjaan_favorit" id="employee_id_pekerjaan_favorit" value="${employee_id}" readonly>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="posisi_pekerjaan_favorit" class="form-label-custom required">Bidang/Posisi yang paling diminati</label>
                                <input type="text" class="form-control border-custom posisi_pekerjaan_favorit" name="posisi_pekerjaan_favorit" id="posisi_pekerjaan_favorit" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="ekspektasi_gaji" class="form-label-custom required">Gaji yang Diharapkan</label>
                                <input type="tel" pattern="\d*" class="form-control border-custom ekspektasi_gaji" name="ekspektasi_gaji" id="ekspektasi_gaji" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                        </div>
					</form>`,
                buttons: {
                    cancel: function() {
                        //close
                    },
                    formSubmit: {
                        text: 'Submit',
                        btnClass: 'btn-blue',
                        action: function() {
                            let posisi_pekerjaan_favorit = this.$content.find('#posisi_pekerjaan_favorit').val();
                            if (!posisi_pekerjaan_favorit) {
                                $.alert('Anda belum mengisi Bidang/Posisi Pekerjaan');
                                return false;
                            }
                            let ekspektasi_gaji = this.$content.find('#ekspektasi_gaji').val();
                            if (!ekspektasi_gaji) {
                                $.alert('Anda belum mengisi kolom ekspektasi gaji');
                                return false;
                            }

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
                                    $.ajax({
                                        url: '<?= base_url() ?>fack/store_pekerjaan_favorit',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            application_id_pekerjaan_favorit: application_id,
                                            employee_id_pekerjaan_favorit: employee_id,
                                            posisi_pekerjaan_favorit: posisi_pekerjaan_favorit,
                                            ekspektasi_gaji: ekspektasi_gaji,
                                        },
                                        beforeSend: function() {

                                        },
                                        success: function(response) {},
                                        error: function(xhr) {},
                                        complete: function() {},
                                    }).done(function(response) {
                                        console.log(response);
                                        if (response.status == true) {
                                            dt_daftar_pekerjaan_favorit();
                                            setTimeout(() => {
                                                $(".tab-content").height('100%');
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Berhasil menyimpan pekerjaan paling diminati!',
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                        } else {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-close',
                                                title: 'Oops!',
                                                theme: 'material',
                                                type: 'red',
                                                content: 'Gagal menyimpan pekerjaan paling diminati!',
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
                                                content: 'Gagal menyimpan pekerjaan paling diminati!' + textStatus,
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
                onContentReady: function() {
                    $(".tahun").mask('0000');
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function(e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });
        });


        function hapus_pekerjaan_favorit(id, application_id) {
            $.confirm({
                title: 'Alert!',
                theme: 'material',
                type: 'red',
                content: 'Apakah anda yakin hapus data pekerjaan yang diminati ini!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                    hapus: {
                        text: 'Ya, Hapus!',
                        btnClass: 'btn-red',
                        action: function() {

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

                                    $.ajax({
                                        url: '<?= base_url() ?>fack/hapus_pekerjaan_favorit',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            id: id,
                                            application_id: application_id
                                        },
                                    }).done(function(response) {
                                        console.log(response);
                                        if (response.hapus == true) {
                                            dt_daftar_pekerjaan_favorit();
                                            setTimeout(() => {
                                                $(".tab-content").height('100%');
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Berhasil hapus data pekerjaan yang diminati!',
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                        } else {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-close',
                                                title: 'Oops!',
                                                theme: 'material',
                                                type: 'red',
                                                content: 'Gagal hapus data pekerjaan yang diminati!',
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
                                                content: 'Gagal menyimpan data pekerjaan yang diminati!' + textStatus,
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
                        }
                    }
                },
            });
        }




        dt_daftar_referensi();

        function dt_daftar_referensi() {
            let apl_id = '<?= $ck['application_id']; ?>'
            var table = $('#dt_daftar_referensi').DataTable({
                orderCellsTop: false,
                // fixedHeader: true,
                "searching": false,
                "info": false,
                "paging": false,
                "destroy": true,
                "ordering": false,
                "autoWidth": false,
                "order": [
                    [0, 'desc']
                ],
                responsive: true,
                "ajax": {
                    "dataType": 'json',
                    "type": "POST",
                    "data": {
                        application_id: apl_id
                    },
                    "url": "<?= base_url(); ?>fack/dt_daftar_referensi",
                },
                "columns": [{
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        defaultContent: '',
                    },
                    {
                        "data": "nama",
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row, meta) {
                            return `<a role="button" class="button-4-icon" onclick="hapus_referensi('${row['id']}','${row['application_id']}')"><i class="bi bi-trash"></i><a>`
                        },
                    },
                    {
                        "data": "jabatan",
                        "className": "d-none"
                    },
                    {
                        "data": "hubungan",
                        "className": "d-none"
                    },
                    {
                        "data": "no_hp",
                        "className": "d-none"
                    },
                ],
            });
        }

        // Add event listener for opening and closing details
        $('#dt_daftar_referensi tbody').on('click', 'td.dt-control', function() {
            var tr = $(this).closest('tr');
            var row = $('#dt_daftar_referensi').DataTable().row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(detail_referensi(row.data())).show();
                tr.addClass('shown');
                $(".tab-content").height('100%');
            }
        });

        function detail_referensi(d) {
            // `d` is the original data object for the row
            return (
                `<table class="table table-sm">
            <tr>
                <td><b>Jabatan & Perusahaan</b></td>
                <td>${d.jabatan}</td>
            </tr>
            <tr>
                <td><b>Hubungan dgn Anda</b></td>
                <td>${d.hubungan}</td>
            </tr>
            <tr>
                <td><b>No. Telp/Hp</b></td>
                <td>${d.no_hp}</td>
            </tr>
        </table>`
            );
        }


        $('#btn-add-referensi').on('click', function() {
            let application_id = "<?= $ck['application_id'] ?? "" ?>"
            let employee_id = "<?= $ck['employee_id'] ?? "" ?>"
            $.confirm({
                title: 'Input Data Referensi',
                type: 'blue',
                theme: 'material',
                columnClass: 'col-12 col-md-8 col-lg-8',
                content: `<form action="" id="form-fack-bahasa" class="formName">
                        <div class="row col-12 mb-3">
                            <div class="mb-3 col-12">
                                <input type="hidden" name="application_id_referensi" id="application_id_referensi" value="${application_id}" readonly>
                                <input type="hidden" name="employee_id_referensi" id="employee_id_referensi" value="${employee_id}" readonly>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="nama_referensi" class="form-label-custom required">Nama</label>
                                <input type="text" class="form-control border-custom nama_referensi" name="nama_referensi" id="nama_referensi" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="jabatan_referensi" class="form-label-custom required">Jabatan (Perusahaan)</label>
                                <input type="text" class="form-control border-custom jabatan_referensi" name="jabatan_referensi" id="jabatan_referensi" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="hubungan_referensi" class="form-label-custom required">Hubungan dgn Anda</label>
                                <input type="text" class="form-control border-custom hubungan_referensi" name="hubungan_referensi" id="hubungan_referensi" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label for="no_hp_referensi" class="form-label-custom required">No. Telp/Hp</label>
                                <input type="tel" pattern="\d*" class="form-control border-custom no_hp_referensi" name="no_hp_referensi" id="no_hp_referensi" value="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide a valid data.
                                </div>
                            </div>
                        </div>
					</form>`,
                buttons: {
                    cancel: function() {
                        //close
                    },
                    formSubmit: {
                        text: 'Submit',
                        btnClass: 'btn-blue',
                        action: function() {
                            let nama_referensi = this.$content.find('#nama_referensi').val();
                            if (!nama_referensi) {
                                $.alert('Anda belum mengisi Nama Referensi');
                                return false;
                            }

                            let jabatan_referensi = this.$content.find('#jabatan_referensi').val();
                            if (!jabatan_referensi) {
                                $.alert('Anda belum mengisi kolom jabatan referensi (perusahaan)');
                                return false;
                            }

                            let hubungan_referensi = this.$content.find('#hubungan_referensi').val();
                            if (!hubungan_referensi) {
                                $.alert('Anda belum mengisi kolom hubungan dgn anda');
                                return false;
                            }

                            let no_hp_referensi = this.$content.find('#no_hp_referensi').val();
                            if (!no_hp_referensi) {
                                $.alert('Anda belum mengisi kolom no. telp/hp');
                                return false;
                            }

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
                                    $.ajax({
                                        url: '<?= base_url() ?>fack/store_referensi',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            application_id_referensi: application_id,
                                            employee_id_referensi: employee_id,
                                            nama_referensi: nama_referensi,
                                            jabatan_referensi: jabatan_referensi,
                                            hubungan_referensi: hubungan_referensi,
                                            no_hp_referensi: no_hp_referensi,
                                        },
                                        beforeSend: function() {

                                        },
                                        success: function(response) {},
                                        error: function(xhr) {},
                                        complete: function() {},
                                    }).done(function(response) {
                                        console.log(response);
                                        if (response.status == true) {
                                            dt_daftar_referensi();
                                            setTimeout(() => {
                                                $(".tab-content").height('100%');
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Berhasil menyimpan referensi!',
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                        } else {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-close',
                                                title: 'Oops!',
                                                theme: 'material',
                                                type: 'red',
                                                content: 'Gagal menyimpan referensi!',
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
                                                content: 'Gagal menyimpan referensi!' + textStatus,
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
                onContentReady: function() {
                    $(".tahun").mask('0000');
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function(e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });
        });


        function hapus_referensi(id, application_id) {
            $.confirm({
                title: 'Alert!',
                theme: 'material',
                type: 'red',
                content: 'Apakah anda yakin hapus data referensi ini!',
                buttons: {
                    close: {
                        actions: function() {}
                    },
                    hapus: {
                        text: 'Ya, Hapus!',
                        btnClass: 'btn-red',
                        action: function() {

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

                                    $.ajax({
                                        url: '<?= base_url() ?>fack/hapus_referensi',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            id: id,
                                            application_id: application_id
                                        },
                                    }).done(function(response) {
                                        console.log(response);
                                        if (response.hapus == true) {
                                            dt_daftar_referensi();
                                            setTimeout(() => {
                                                $(".tab-content").height('100%');
                                                jconfirm.instances[0].close();
                                                $.confirm({
                                                    icon: 'fa fa-check',
                                                    title: 'Done!',
                                                    theme: 'material',
                                                    type: 'blue',
                                                    content: 'Berhasil hapus data referensi!',
                                                    buttons: {
                                                        close: {
                                                            actions: function() {}
                                                        },
                                                    },
                                                });
                                            }, 250);
                                        } else {
                                            jconfirm.instances[0].close();
                                            $.confirm({
                                                icon: 'fa fa-close',
                                                title: 'Oops!',
                                                theme: 'material',
                                                type: 'red',
                                                content: 'Gagal hapus data referensi!',
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
                                                content: 'Gagal menyimpan data referensi!' + textStatus,
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
                        }
                    }
                },
            });
        }

        function formatNumber(num) {
            if (num == null) {
                return 0;
            } else {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
            }
        }
    </script>

<?php } ?>