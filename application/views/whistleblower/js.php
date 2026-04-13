<!-- sweetalert -->
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>

<!-- view images -->
<!-- <script type="text/javascript" src="<?= base_url('assets/fancybox/jquery.fancybox.min.js') ?>"></script> -->

<!-- slim select js -->
<!-- <script src="<?php echo base_url(); ?>assets/js/slimselect.min.js"></script> -->
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<script src="<?= base_url(); ?>assets/js/whatsapp_api.js"></script>

<!-- Datatable Button -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables.net/js/dataTables.fixedColumns.min.js"></script>

<!-- Datetimepicker Full -->
<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>

<!-- Summer Note css/js -->
<link href="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.css" rel="stylesheet">
<script src="<?= base_url(); ?>assets/vendor/summernote/summernote-lite.js"></script>

<!-- SmartWizard6 -->
<script src="<?= base_url(); ?>assets/vendor/smartWizard6/js/jquery.smartWizard.min.js"></script>

<!-- Jquery Confirm -->
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>

<!-- Font Awesome -->
<script src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>
<script src="<?= base_url(); ?>assets/nice-select2/js/nice-select2.js"></script>
<script>
    const baseUrl = '<?= base_url('/trusmi_wb') ?>';

    department_id_ns = NiceSelect.bind(document.getElementById('department_id'), {
        searchable: true
    });

    employee_id_ns = NiceSelect.bind(document.getElementById('employee_id'), {
        searchable: true
    });

    id_aktivitas_ns = NiceSelect.bind(document.getElementById('id_aktivitas'), {
        searchable: true
    });

    company_terkait_ns = NiceSelect.bind(document.getElementById('company_terkait'), {
        searchable: true
    });

    department_terkait_ns = NiceSelect.bind(document.getElementById('department_terkait'), {
        searchable: true
    });

    $(document).ready(function() {
        var start = moment().startOf('month');
        var end = moment().endOf('month');

        function cb(start, end) {
            $('.reportrange input').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="start"]').val(start.format('YYYY-MM-DD'));
            $('input[name="end"]').val(end.format('YYYY-MM-DD'));
            dtListWb(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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


        $('#smartwizard2').smartWizard({
            // selected: '3',
            theme: "default",
            enableURLhash: true,
            transition: {
                animation: 'none', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
            },
            toolbar: {
                showNextButton: true, // show/hide a Next button
                showPreviousButton: true, // show/hide a Previous button
                position: 'top', // none|top|bottom|both
                extraHtml: ''
            },
            keyboard: {
                keyNavigation: false // Enable/Disable keyboard navigation(left and right keys are used if enabled)
            },
            lang: { // Language variables for button
                next: 'Next',
                previous: 'Previous'
            },
        });

        $('#kronologi').summernote({
            placeholder: '...',
            tabsize: 2,
            height: 150,
            toolbar: [
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
            ]
        });

        // $("#modal_add_wb").modal("show");

        function fetchPertanyaan() {
            $.get(`${baseUrl}/getWbPertanyaan`, function(data) {
                if (data && data.length > 0) {
                    data.forEach(function(pertanyaan) {
                        const container = $("#container-pertanyaan");
                        const questionDiv = $("<div>").addClass("d-flex gap-4 flex-column");

                        // Tambahkan input tersembunyi untuk id_pertanyaan dan pertanyaan
                        const hiddenIdPertanyaan = $("<input>")
                            .attr({
                                type: "hidden",
                                name: `id_pertanyaan_${pertanyaan.id_pertanyaan}`,
                                value: pertanyaan.id_pertanyaan,
                            });
                        const hiddenPertanyaan = $("<input>")
                            .attr({
                                type: "hidden",
                                name: `pertanyaan_${pertanyaan.id_pertanyaan}`,
                                value: pertanyaan.pertanyaan,
                            });

                        // Tambahkan label pertanyaan
                        const label = $("<label>").text(pertanyaan.pertanyaan);
                        questionDiv.append(label);

                        if (pertanyaan.radio_btn === "1") {
                            // Buat radio button jika radio_btn = 1
                            const radio1 = createRadioButton(pertanyaan.id_pertanyaan, pertanyaan.value_1, 1);
                            const radio2 = createRadioButton(pertanyaan.id_pertanyaan, pertanyaan.value_2, 2);
                            const radio3 = createRadioButton(pertanyaan.id_pertanyaan, pertanyaan.value_3, 3);

                            questionDiv.append(radio1, radio2, radio3);
                        } else {
                            // Buat input teks jika radio_btn = 0
                            const inputText = $("<input>")
                                .attr({
                                    type: "text",
                                    class: "form-control border border-dark",
                                    name: `jawaban_${pertanyaan.id_pertanyaan}`,
                                });
                            const inputWrapper = $("<div>").addClass("col-12 col-md-5").append(inputText);
                            questionDiv.append(inputWrapper);
                        }

                        // Tambahkan input tersembunyi dan pertanyaan ke container
                        questionDiv.append(hiddenIdPertanyaan, hiddenPertanyaan);
                        container.append(questionDiv);
                    });
                } else {
                    console.log("Tidak ada data pertanyaan.");
                }
            }).fail(function(error) {
                console.error("Gagal mengambil data pertanyaan:", error);
            });
        }

        // Fungsi untuk membuat radio button
        function createRadioButton(idPertanyaan, value, index) {
            const radioGroup = $("<div>").addClass("form-check form-check-inline");
            const radioInput = $("<input>")
                .attr({
                    type: "radio",
                    class: "form-check-input",
                    name: `jawaban_${idPertanyaan}`,
                    id: `jawaban_${idPertanyaan}_${index}`,
                    value: value,
                });
            const radioLabel = $("<label>")
                .attr({
                    class: "form-check-label",
                    for: `jawaban_${idPertanyaan}_${index}`,
                })
                .text(value);

            radioGroup.append(radioInput, radioLabel);
            return radioGroup;
        }

        // Panggil fungsi untuk mengambil dan menampilkan pertanyaan
        fetchPertanyaan();
    });

    function add_wb() {
        $("#modal_add_wb").modal("show");
        $("#btn_finish").hide();
    }

    $('#id_aktivitas').change(function(e) {
        e.preventDefault();
        let id_aktivitas = $(this).val();
        console.log(id_aktivitas);
        if (id_aktivitas == 13) {
            $('#row_aktivitas_lainnya').removeClass('d-none');
        } else {
            $('#row_aktivitas_lainnya').addClass('d-none');
        }
    });

    $('#department_id').change(function(e) {
        e.preventDefault();
        let department_id = $(this).val();
        employee_id_ns.clear();
        $.ajax({
            type: "POST",
            url: `${baseUrl}/getEmployee`,
            data: {
                department_id
            },
            dataType: "json",
            success: function(response) {
                let options = ``;
                $.each(response, function(index, value) {
                    options += `<option value="${value.value}">${value.text}</option>`;
                });

                // Clear existing options and append new ones
                $('#employee_id').empty().append(options);

                // Reinitialize nice-select2 after updating the options
                employee_id_ns.update();
            },
            error: function(xhr, status, error) {
                console.error("Error fetching employees:", error);
            }
        });
    });

    $('#company_terkait').change(function(e) {
        e.preventDefault();
        let company_id = $(this).val();
        department_terkait_ns.clear();
        $.ajax({
            type: "POST",
            url: `${baseUrl}/getDepartmentByCompany`,
            data: {
                company_id
            },
            dataType: "json",
            success: function(response) {
                let options = `<option data-placeholder="true" value="">-- Choose Department --</option>`;
                $.each(response, function(index, value) {
                    options += `<option value="${value.department_id}">${value.nama_dep}</option>`;
                });

                // Clear existing options and append new ones
                $('#department_terkait').empty().append(options);

                // Reinitialize nice-select2 after updating the options
                department_terkait_ns.update();
            },
            error: function(xhr, status, error) {
                console.error("Error fetching departments:", error);
            }
        });
    });


    $("#smartwizard2").on("leaveStep", function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
        // console.log(nextStepIndex);
        if (nextStepIndex == 1 && stepDirection == "forward") {
            if ($("#laporan").val() == "") {
                $(".laporan").removeClass('is-valid');
                $(".laporan").addClass('is-invalid');
                $("#laporan").focus();
                return false;
            } else if ($("#department_id :selected").val() == "") {
                $(".department_id").removeClass('is-valid');
                $(".department_id").addClass('is-invalid');
                $("#department_id").focus();
                return false;
            } else if ($("#employee_id :selected").val() == "") {
                $(".employee_id").removeClass('is-valid');
                $(".employee_id").addClass('is-invalid');
                $("#employee_id").focus();
                return false;
            } else if ($("#tgl_temuan").val() == "") {
                $(".tgl_temuan").removeClass('is-valid');
                $(".tgl_temuan").addClass('is-invalid');
                $("#tgl_temuan").focus();
                return false;
            } else if ($("#id_aktivitas").val() == "") {
                $(".id_aktivitas").removeClass('is-valid');
                $(".id_aktivitas").addClass('is-invalid');
                $("#id_aktivitas").focus();
                return false;
            } else if ($("#id_aktivitas").val() == 13 && $("#note_other").val() == '') {
                $(".note_other").removeClass('is-valid');
                $(".note_other").addClass('is-invalid');
                $("#note_other").focus();
                return false;
            } else if ($("#kronologi").val() == "") {
                $(".kronologi").removeClass('is-valid');
                $(".kronologi").addClass('is-invalid');
                $("#kronologi").focus();
                return false;
            } else {
                $.ajax({
                    type: "POST",
                    url: `${baseUrl}/add_wb`,
                    data: $("#form_tahap_1").serialize(),
                    dataType: "json",
                    success: function(response) {
                        $('#id_wb').val(response.id_wb);
                        $('#id_wb_2').val(response.id_wb);
                        $('#id_wb_3').val(response.id_wb);
                        $('#id_wb_4').val(response.id_wb);
                        $("#btn_cancel").hide();
                        return true;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR.responseText);
                        return false;
                    }
                });
            }
        } else if (nextStepIndex == 2 && stepDirection == "forward") {
            if ($("#lokasi").val() == "") {
                $(".lokasi").removeClass('is-valid');
                $(".lokasi").addClass('is-invalid');
                $("#lokasi").focus();
                return false;
            } else if ($("#kota").val() == "") {
                $(".kota").removeClass('is-valid');
                $(".kota").addClass('is-invalid');
                $("#kota").focus();
                return false;
            } else if ($("#hubungan").val() == "1" && $("#company_terkait").val() == "") {
                $(".company_terkait").removeClass('is-valid');
                $(".company_terkait").addClass('is-invalid');
                $("#company_terkait").focus();
                return false;
            } else if ($("#informasi").val() == "") {
                $(".informasi").removeClass('is-valid');
                $(".informasi").addClass('is-invalid');
                $("#informasi").focus();
                return false;
            } else if ($("#bukti").val() == "") {
                $(".bukti").removeClass('is-valid');
                $(".bukti").addClass('is-invalid');
                $("#bukti").focus();
                return false;
            } else {
                const form = $('#form_tahap_2')[0];
                const formData = new FormData(form);
                $.ajax({
                    type: "POST",
                    url: `${baseUrl}/add_wb_2`,
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        return true;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR.responseText);
                        return false;
                    }
                });
            }
        } else if (nextStepIndex == 3 && stepDirection == "forward") {
            let isValid = true; // Flag untuk menandai apakah semua pertanyaan sudah diisi

            // Validasi setiap pertanyaan
            $("div[id^='container-pertanyaan'] > div").each(function() {
                const idPertanyaan = $(this).find("input[type='hidden'][name^='id_pertanyaan']").val();

                // Cek apakah pertanyaan menggunakan radio button atau input teks
                if ($(this).find("input[type='radio']").length > 0) {
                    // Validasi radio button
                    if ($(this).find("input[type='radio']:checked").length === 0) {
                        $(this).find("label").css("color", "red"); // Tandai pertanyaan yang belum dijawab
                        isValid = false; // Set flag ke false
                    } else {
                        $(this).find("label").css("color", ""); // Hapus tanda error jika sudah dijawab
                    }
                } else {
                    // Validasi input teks
                    const inputText = $(this).find("input[type='text']");
                    if (inputText.val().trim() === "") {
                        inputText.removeClass('is-valid');
                        inputText.addClass('is-invalid');
                        inputText.focus();
                        isValid = false; // Set flag ke false
                    } else {
                        inputText.removeClass('is-invalid');
                        inputText.addClass('is-valid');
                    }
                }
            });

            // Jika ada pertanyaan yang belum dijawab, tampilkan pesan error dan return false
            if (!isValid) {
                return false; // Mencegah wizard lanjut ke step berikutnya
            } else {
                // Jika semua pertanyaan sudah dijawab, lanjutkan proses submit form
                submitForm();
                $("#btn_finish").show();
                return true; // Izinkan wizard lanjut ke step berikutnya
            }
        }
    });

    function finish() {
        var persetujuanValue = $('#persetujuan').is(':checked') ? 1 : 0;
        var id_wb = $('#id_wb_4').val();
        if (id_wb == '' || id_wb == null) {
            swal("Oops!", "Form belum terisi!", "warning");
            return false
        }
        $.ajax({
            type: "POST",
            url: `${baseUrl}/finish`,
            data: {
                id_wb: id_wb,
                persetujuan: persetujuanValue
            },
            dataType: "json",
            beforeSend: function() {
                $('#btn_finish').attr('disabled', 'disabled');
            },
            success: function(response) {
                console.log('Success:', response);
                $("#modal_add_wb").modal("hide");
                $('#dt_list_wb').DataTable().ajax.reload()
                clearForm()
                swal("Sukses", "Add Whistleblower berhasil disimpan!", "success", {
                    buttons: false,
                    timer: 1000
                });
            },
            complete: function() {
                $('#btn_finish').removeAttr('disabled');
            },
            error: function(error) {
                // Handle error response
                console.log('Error:', error);
            }
        });
    }

    function submitForm() {
        const formData = [];

        // Ambil id_wb dari form
        const idWb = $("#id_wb_3").val();

        // Iterasi setiap pertanyaan
        $("div[id^='container-pertanyaan'] > div").each(function() {
            const idPertanyaan = $(this).find("input[type='hidden'][name^='id_pertanyaan']").val();
            const pertanyaan = $(this).find("input[type='hidden'][name^='pertanyaan']").val();
            let jawaban;

            // Cek apakah pertanyaan menggunakan radio button atau input teks
            if ($(this).find("input[type='radio']").length > 0) {
                jawaban = $(this).find("input[type='radio']:checked").val();
            } else {
                jawaban = $(this).find("input[type='text']").val();
            }

            // Tambahkan data ke array
            formData.push({
                id_wb: idWb,
                id_pertanyaan: idPertanyaan,
                jawaban: jawaban,
                pertanyaan: pertanyaan,
            });
        });

        // Kirim data ke server
        $.ajax({
            url: `${baseUrl}/savePertanyaan`, // Ganti dengan endpoint yang sesuai
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify(formData),
            success: function(response) {
                console.log("Data berhasil disimpan:", response);
                return true;
            },
            error: function(error) {
                console.error("Gagal menyimpan data:", error);
                return false;
            },
        });
    }

    $('#btn_show_hubungan').on('click', function() {
        if ($('#btn_show_hubungan').hasClass('bi-square')) {
            $('#btn_show_hubungan').removeClass('bi-square');
            $('#btn_show_hubungan').addClass('bi-check-square');
            $('#row_hubungan').removeClass('d-none');
            $('#hubungan').val(1);
        } else {
            $('#btn_show_hubungan').removeClass('bi-check-square');
            $('#btn_show_hubungan').addClass('bi-square');
            $('#row_hubungan').addClass('d-none');
            $('#hubungan').val(0);
        }
    })

    function dtListWb(start, end) {
        $('#dt_list_wb').DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "autoWidth": false,
            "destroy": true,
            "responsive": true,
            "dom": 'Bfrtip',
            buttons: [{
                title: 'Data List Whistleblower',
                extend: 'excelHtml5',
                text: '<i class="bi bi-download text-white"></i>',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": `${baseUrl}/getListWb`,
                "data": {
                    start,
                    end
                },
            },
            "columns": [{
                    "data": "id_wb",
                    "className": "text-center"
                },
                {
                    "data": "laporan",
                    "className": "text-center"
                },
                {
                    "data": "nama_department",
                    "className": "text-center"
                },
                {
                    "data": "nama_employee",
                    "render": function(data, type, row, meta) {
                        return `<div class="row">
                            <div class="col-auto align-self-center">
                                <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${row['profile_picture']}&quot;);">
                                    <img src="http://trusmiverse.com/hr/uploads/profile/${row['profile_picture']}" alt="" style="display: none;">
                                </figure>
                            </div>
                            <div class="col px-0 align-self-center">
                                <p class="mb-0 small">${row['nama_employee']}</p>
                                <p class="small text-secondary small">${row['created_at']}</p>
                            </div>
                        </div>`
                    }
                },
                {
                    "data": "tgl_temuan",
                    "className": "text-center"
                },
                {
                    "data": "id_aktivitas",
                    "render": function(data, type, row, meta) {
                        if (data == 13) {
                            return `${row['aktivitas']} ${row['note_other']}`
                        } else {
                            return `${row['aktivitas']}`
                        }
                    },
                    "className": "text-center"
                },
                {
                    "data": "kronologi",
                    "render": function(data, type, row, meta) {
                        return `${data}`
                    }
                },
                {
                    "data": "lokasi",
                    "render": function(data, type, row, meta) {
                        return `${data} ${row['kota']}`
                    },
                    "className": "text-center"
                },
                {
                    "data": "hubungan",
                    "render": function(data, type, row, meta) {
                        let hubungan = ''
                        if (row['nama_department_terkait'] == `null`) {
                            hubungan = `${row['nama_company_terkait']} ${row['nama_department_terkait']}`
                        } else {
                            hubungan = `${row['nama_company_terkait']}`
                        }
                        return data == 1 ? hubungan : "Tidak Berhubungan";
                    },
                    "className": "text-center"
                },
                {
                    "data": "informasi"
                },
                {
                    "data": "bukti",
                    'render': function(data, type, row) {
                        if (data != "") {
                            return `<a href="<?= base_url('uploads/wb_files/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>`;
                        } else {
                            return ``;
                        }
                    },
                    'className': 'text-center'
                },
                {
                    "data": "jawaban",
                    "render": function(data, type, row, meta) {
                        return data
                    }
                },
                {
                    "data": "persetujuan",
                    "render": function(data, type, row, meta) {
                        return data == 0 ? `<div class="row">
                            <div class="col-auto align-self-center">
                                <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${row['created_profile_picture']}&quot;);">
                                    <img src="http://trusmiverse.com/hr/uploads/profile/${row['created_profile_picture']}" alt="" style="display: none;">
                                </figure>
                            </div>
                            <div class="col px-0 align-self-center">
                                <p class="mb-0 small">${row['created_username']}</p>
                                <p class="small text-secondary small">${row['created_at']}</p>
                            </div>
                        </div>` : `<div class="row">
                            <div class="col-auto align-self-center">
                                <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/anonim.jpg&quot;);">
                                    <img src="http://trusmiverse.com/hr/uploads/profile/anonim.jpg" alt="" style="display: none;">
                                </figure>
                            </div>
                            <div class="col px-0 align-self-center">
                                <p class="mb-0 small"> Anonim </p>
                                <p class="small text-secondary small">${row['created_at']}</p>
                            </div>
                        </div>`
                    }
                }
            ]
        });
    }

    function clearForm() {
        $('#form_tahap_1')[0].reset();
        $('#form_tahap_2')[0].reset();
        $('#form_tahap_3')[0].reset();
        $('#form_tahap_4')[0].reset();
        $('#department_id').empty()
        department_id_ns.clear();
        $('#employee_id').empty()
        employee_id_ns.clear();
        id_aktivitas_ns.clear();
        company_terkait_ns.clear();
        department_terkait_ns.clear();
        $('#smartwizard2').smartWizard("reset");
    }
</script>