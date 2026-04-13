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
    const baseUrl = '<?= base_url('/trusmi_wb_ade') ?>';

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

    // wbdev
    pic_escalation_ns = NiceSelect.bind(document.getElementById('pic_escalation'), {
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

         // wbdev
         resume_monitoring_progres_wb();

        //  revnew
        $('#status_progres').on('change', function() {
            console.log($(this).val());
            if ($(this).val() != 4) { // jika status bukan Reject
                $('.inputan-reject').addClass('d-none');
                $('.inputan-approve').removeClass('d-none');
                $('#btn_reject').hide();
                $('#btn_update').show();
            } else {
                $('.inputan-reject').removeClass('d-none');
                $('.inputan-approve').addClass('d-none');
                $('#btn_reject').show();
                $('#btn_update').hide();
            }
        });

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
            console.log('akv ' + $("#kronologi").val().trim().split(/\s+/).length)
            if ($("#laporan").val() == "") {
                $(".laporan").removeClass('is-valid');
                $(".laporan").addClass('is-invalid');
                $("#laporan").focus();
                swal('Perhatian!!!', 'Judul Laporan Wajib Diisi.','error');
                return false;
            } else if ($("#department_id :selected").val() == "") {
                $(".department_id").removeClass('is-valid');
                $(".department_id").addClass('is-invalid');
                $("#department_id").focus();
                swal('Perhatian!!!', 'Department Wajib Diisi.','error');
                return false;
            } else if ($("#employee_id :selected").val() == "") {
                $(".employee_id").removeClass('is-valid');
                $(".employee_id").addClass('is-invalid');
                $("#employee_id").focus();
                swal('Perhatian!!!', 'Employee Wajib Diisi.','error');
                return false;
            } else if ($("#tgl_temuan").val() == "") {
                $(".tgl_temuan").removeClass('is-valid');
                $(".tgl_temuan").addClass('is-invalid');
                $("#tgl_temuan").focus();
                swal('Perhatian!!!', 'Tanggal Temuan Wajib Diisi.','error');
                return false;
            } else if ($("#id_aktivitas").val() == "-- Choose Activity --") {
                $(".id_aktivitas").removeClass('is-valid');
                $(".id_aktivitas").addClass('is-invalid');
                $("#id_aktivitas").focus();
                swal('Perhatian!!!', 'Aktivitas Wajib Diisi.','error');
                return false;
            } else if ($("#id_aktivitas").val() == 13 && $("#note_other").val() == '') {
                $(".note_other").removeClass('is-valid');
                $(".note_other").addClass('is-invalid');
                $("#note_other").focus();
                swal('Perhatian!!!', 'Note Lainnya Wajib Diisi.','error');
                return false;
            } else if ($("#kronologi").val() == "") {
                $(".kronologi").removeClass('is-valid');
                $(".kronologi").addClass('is-invalid');
                $("#kronologi").focus();
                swal('Perhatian!!!', 'Kronoligi Wajib Diisi.','error');
                return false;
            } else if ($("#kronologi").val() != "" && $("#kronologi").val().trim().split(/\s+/).length < 10) {
                $(".kronologi").removeClass('is-valid');
                $(".kronologi").addClass('is-invalid');
                $("#kronologi").focus();
                swal('Perhatian!!!', 'Kronoligi Wajib Terdiri dari 10 Kata.','error');
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
                swal('Perhatian!!!', 'Lokasi Wajib Diisi.','error');
                return false;
            } else if ($("#kota").val() == "") {
                $(".kota").removeClass('is-valid');
                $(".kota").addClass('is-invalid');
                $("#kota").focus();
                swal('Perhatian!!!', 'Kota Wajib Diisi.','error');
                return false;
            } else if ($("#hubungan").val() == "1" && $("#company_terkait").val() == "") {
                $(".company_terkait").removeClass('is-valid');
                $(".company_terkait").addClass('is-invalid');
                $("#company_terkait").focus();
                swal('Perhatian!!!', 'Hubungan Wajib Diisi.','error');
                return false;
            } else if ($("#informasi").val() == "") {
                $(".informasi").removeClass('is-valid');
                $(".informasi").addClass('is-invalid');
                $("#informasi").focus();
                swal('Perhatian!!!', 'Informasi Wajib Diisi.','error');
                return false;
            } else if ($("#informasi").val() != "" && $("#informasi").val().trim().split(/\s+/).length < 10) {
                $(".informasi").removeClass('is-valid');
                $(".informasi").addClass('is-invalid');
                $("#informasi").focus();
                swal('Perhatian!!!', 'Informasi Wajib Terdiri dari 10 Kata.','error');
                return false;
            } else if ($("#bukti").val() == "") {
                $(".bukti").removeClass('is-valid');
                $(".bukti").addClass('is-invalid');
                $("#bukti").focus();
                swal('Perhatian!!!', 'Bukti Wajib Diisi.','error');
                return false;
            } else if ($("#ekspektasi_akhir").val() == "") { // revnew
                $(".ekspektasi_akhir").removeClass('is-valid');
                $(".ekspektasi_akhir").addClass('is-invalid');
                $("#ekspektasi_akhir").focus();
                swal('Perhatian!!!', 'Ekspektasi akhir Wajib di isi.','error');
                return false;
            } else if ($("#keterkaitan_dampak").val() == "") { // revnew
                $(".keterkaitan_dampak").removeClass('is-valid');
                $(".keterkaitan_dampak").addClass('is-invalid');
                $("#keterkaitan_dampak").focus();
                swal('Perhatian!!!', 'Keterkaitan & Dampak Wajib di isi.','error');
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
                $('#dt_list_wb').DataTable().ajax.reload();
                clearForm();
                resume_monitoring_progres_wb();
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
                    "render": function(data, type, row, meta) {
                        return `<a role="button" class="badge bg-primary" style="cursor:pointer; margin-left:10px;" onclick="show_history_wb('${row['id_wb']}')">
                                    ${data}
                                </a>`;
                    },
                    "className": "text-center"
                },
                {
                    "data": "id_wb", // addnew
                    "render": function(data, type, row, meta) {
                        kategori = ''
                        if (row['id_created_by'] == 8636) {
                            kategori = 'Eksternal';
                        } else {
                            kategori = 'Internal';
                        }
                        return kategori;
                    },
                },
                {
                    "data": "laporan",
                    "className": "text-center"
                },
                {
                    "data": "nama_department",
                    "render": function(data, type, row, meta) {
                        if (row['id_created_by'] == 8636) {
                            return row['department_ext'];
                        } else {
                            return data;
                        }
                    },
                    "className": "text-center"
                },
                {
                    "data": "nama_employee",
                    "render": function(data, type, row, meta) {

                        employee_name = (row['id_created_by'] == 8636) ? row['employee_ext'] : data; // updtnew
                        profile_picture = (row['id_created_by'] == 8636) ? 'anonim.jpg' : row['profile_picture']; // updtnew

                        // return `<div class="row">
                        //     <div class="col-auto align-self-center">
                        //         <figure class="avatar avatar-30 rounded-circle coverimg vm" style="background-image: url(&quot;http://trusmiverse.com/hr/uploads/profile/${profile_picture}&quot;);">
                        //             <img src="http://trusmiverse.com/hr/uploads/profile/${profile_picture}" alt="" style="display: none;">
                        //         </figure>
                        //     </div>
                        //     <div class="col px-0 align-self-center">
                        //         <p class="mb-0 small">${employee_name}.</p>
                        //         <p class="small text-secondary small">${row['created_at']}</p>
                        //     </div>
                        // </div>`;

                        // addnew update
                        return `<a role="button" class="badge bg-blue" style="cursor:pointer; margin-left:10px;" onclick="show_detail_employee('${employee_name}', '${row['username']}', '${profile_picture}')">
                                    <i class="bi bi-eye"></i> Detail
                                </a>`;
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
                        if (data != "" && data != null) {
                            if (data.includes(".jpg") || data.includes(".jpeg") || data.includes(".png") || data.includes(".gif")) {
                                return `<a href="<?= base_url('uploads/wb_files/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>`;
                            } else {
                                return `<a href="<?= base_url('uploads/wb_files/') ?>${data}" class="text-success" download><i class="bi bi-file-earmark-arrow-down"></i></a>`;
                            }
                        } else {
                            return ``;
                        }
                    },
                    'className': 'text-center'
                },
                {
                    "data": "ekspektasi_akhir" // revnew
                },
                {
                    "data": "keterkaitan_dampak"
                },
                {
                    "data": "jawaban",
                    "render": function(data, type, row, meta) {
                        return data
                    }
                },
                {
                    "data": "status", // wbdev status_progres
                    "render": function(data, type, row, meta) {
                        // status_progres = "";
                        color = "";
                        if (data == "Waiting") {
                            // status_progres = "Waiting";
                            color = "yellow";
                        } else if (data == "Working On") {
                            // status_progres = "Working On";
                            color = "blue";
                        } else if (data == "Done") {
                            // status_progres = "Done";
                            color = "green";
                        } else if (data == "Reject") {
                            // status_progres = "Done";
                            color = "red";
                        }
                        return `<span class="badge bg-${color}" style="margin-left:10px;" >
                                    ${data}
                                </span>`;
                    },
                    "className": "text-center"
                },
                {
                    "data": "kategori_aduan"
                },
                {
                    "data": "status_fu"
                },
                {
                    "data": "pic_eskalasi_wb"
                },
                {
                    "data": "keterangan"
                },
                {
                    "data": "dokumen_penyelesaian", // updev
                    "render": function(data, type, row) {
                        if (data != "" && data != null) {
                            if (data.includes(".jpg") || data.includes(".jpeg") || data.includes(".png") || data.includes(".gif")) {
                                return `<a href="<?= base_url('uploads/wb_files/dokumen/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>`;
                            } else {
                                return `<a href="<?= base_url('uploads/wb_files/dokumen/') ?>${data}" class="text-success" download><i class="bi bi-file-earmark-arrow-down"></i></a>`;
                            }
                        } else {
                            return ``;
                        }
                    },
                },
                {
                    "data": "alasan_reject",
                    "render": function(data, type, row, meta) {
                        if (row['alasan_reject'] !== null ) {
                            return `<div class="col px-0 align-self-center">
                                    <p class="mb-0">${data}</p>
                                    <p class="small text-secondary small">${row['deskripsi_reject']}</p>
                                </div>`;
                        } else {
                            return '-';
                        }
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

    // addnew by Ade
    function show_detail_employee(employee_name, username, profile_picture) {
        $('.title-form-emp').text("Input Password to Show");
        $('#show-form-pass').removeClass('d-none');
        $('#show-detail-emp').addClass('d-none');
        $('#emp_name').text(employee_name);
        $('#emp_username').text(username);
        $('#emp_foto').attr("src", "http://trusmiverse.com/hr/uploads/profile/" + profile_picture);
        
        $('#modal_detail_employee').modal('show');
        $('#btn_submit').show();
    }

    // $('#form_pass').submit()

    function submit_pass() {

        password = $('#password').val();

        $.ajax({
            type: "POST",
            url: `${baseUrl}/checkPassIT`,
            data: {
                password: password
            },
            dataType: "JSON",
            success: function(response) {
                console.log(response);
                if (response.access == true) {
                    $('#show-form-pass').addClass('d-none');
                    $('#password').val("");
                    $('.title-form-emp').text("Detail");
                    $('#show-detail-emp').removeClass('d-none');
                    $('#btn_submit').hide();
                } else {
                    swal("Oops!", "Password tidak sesuai!", "error");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error :", error);
            }
        });

        // if (password == '@jawara') {
        //     $('#show-form-pass').addClass('d-none');
        //     $('#password').val("");
        //     $('.title-form-emp').text("Detail");
        //     $('#show-detail-emp').removeClass('d-none');
        //     $('#btn_submit').hide();
        // } else {
        //     swal("Oops!", "Password tidak sesuai!", "error");
        // }
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

    // wbdev
    function show_update_progres_wb(id_wb, status, kategori_aduan, status_fu, pic_eskalasi) {
        $('#modal_update_progres_wb').modal('show');
        // $('#modal_verifikasi').modal('show');
        $('#status_progres').val(status).change();
        $('#kategori_aduan').val(kategori_aduan).change();
        $('#status_fu').val(status_fu).change();
        $('#id_wb_up').val(id_wb);
        $('#list_wb_status').val(status);
        getPicEscalation();
    }

    function getPicEscalation() {
        $.ajax({
            type: "GET",
            url: `${baseUrl}/getPicEscalation`,
            // data: {
            //     department_id: 68
            // },
            dataType: "json",
            success: function(response) {
                let options = ``;
                $.each(response, function(index, value) {
                    options += `<option value="${value.value}">${value.text}</option>`;
                });

                // Clear existing options and append new ones
                $('#pic_escalation').empty().append(options);

                // Reinitialize nice-select2 after updating the options
                pic_escalation_ns.update();
            },
            error: function(xhr, status, error) {
                console.error("Error fetching employees:", error);
            }
        });
    }

    function update_progres_wb() { // wbdev
        // let form = $('#form_update_progres_wb');

        // updev
        const form = $('#form_update_progres_wb')[0];
        const formData = new FormData(form);

        if ($('#kategori_aduan').val() == "") {
            swal("Oops!", "Pilih kategori aduan!", "warning");
            // $(".kategori_aduan").removeClass('is-valid');
            // $(".kategori_aduan").addClass('is-invalid');
            // $('#kategori_aduan').focus();
        } else if ($('#status_fu').val() == "") {
            swal("Oops!", "Pilih status FU!", "warning");
        } else if ($('#keterangan').val() == "") {
            swal("Oops!", "Input keterangan!", "warning");
        } else {
            
            $.ajax({
                type: "POST",
                url: `${baseUrl}/update_progres_wb`,
                // data: form.serialize(),
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    // $('#btn_finish').attr('disabled', 'disabled');
                },
                success: function(response) {
                    console.log('Success:', response);
                    $("#modal_update_progres_wb").modal("hide");

                    if ($('#list_wb_status').val() == 1) {
                        $('#dt_list_wb_waiting').DataTable().ajax.reload();
                    } else if ($('#list_wb_status').val() == 2) {
                        $('#dt_list_wb_progres').DataTable().ajax.reload();
                    }
                    $('#dt_list_wb').DataTable().ajax.reload();
                    resume_monitoring_progres_wb();
                    // clearForm()
                    $('#form_update_progres_wb')[0].reset();
                    swal("Sukses", "Progres Whistleblower berhasil di update!", "success", {
                        buttons: false,
                        timer: 3000
                    });
                },
                complete: function() {
                    // $('#btn_finish').removeAttr('disabled');
                },
                error: function(error) {
                    // Handle error response
                    console.log('Error:', error);
                }
            });

        }
    }

    // revnew
    function reject_progres_wb() { // wbdev
        // let form = $('#form_update_progres_wb');
        if ($('#alasan_reject').val() == "") {
            swal("Oops!", "Pilih alasan reject!", "warning");
        } else {
            
            $.ajax({
                type: "POST",
                url: `${baseUrl}/reject_progres_wb`,
                data: {
                    id_wb: $('#id_wb_up').val(),
                    status_progres: $('#status_progres').val(),
                    alasan_reject: $('#alasan_reject').val()
                },
                dataType: "json",
                beforeSend: function() {
                    // $('#btn_finish').attr('disabled', 'disabled');
                },
                success: function(response) {
                    console.log('Success:', response);
                    $("#modal_update_progres_wb").modal("hide");

                    if ($('#list_wb_status').val() == 1) {
                        $('#dt_list_wb_waiting').DataTable().ajax.reload();
                    } else if ($('#list_wb_status').val() == 2) {
                        $('#dt_list_wb_progres').DataTable().ajax.reload();
                    }
                    $('#dt_list_wb').DataTable().ajax.reload();
                    resume_monitoring_progres_wb();
                    // clearForm()
                    $('#form_update_progres_wb')[0].reset();
                    swal("Sukses", "Progres Whistleblower berhasil di reject!", "success", {
                        buttons: false,
                        timer: 3000
                    });
                },
                complete: function() {
                    // $('#btn_finish').removeAttr('disabled');
                },
                error: function(error) {
                    // Handle error response
                    console.log('Error:', error);
                }
            });

        }
    }

    function resume_monitoring_progres_wb() {
        $.ajax({
            type: "GET",
            url: `${baseUrl}/resume_monitoring_progres_wb`,
            // data: form.serialize(),
            dataType: "json",
            beforeSend: function() {
                // $('#btn_finish').attr('disabled', 'disabled');
            },
            success: function(response) {
                console.log('Resume:', response);
                data = response.data[0];
                $('#total_aduan').text(data.total_aduan);
                $('#total_aduan_waiting').text(data.total_waiting);
                $('#total_aduan_progres').text(data.total_progres);
                $('#total_aduan_done').text(data.total_done);
                $('#total_aduan_reject').text(data.total_reject); // revnew
                avg_lt_done = (data.avg_lt_done != null) ? data.avg_lt_done : 0;
                $('#avg_lt_done').text(avg_lt_done);
            },
            complete: function() {
                // $('#btn_finish').removeAttr('disabled');
            },
            error: function(error) {
                // Handle error response
                console.log('Error:', error);
            }
        });
    }

    function list_wb_waiting() {
        $("#modal_list_wb_waiting").modal("show");

        $('#dt_list_wb_waiting').DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "autoWidth": false,
            "destroy": true,
            "responsive": true,
            "dom": 'Bfrtip',
            buttons: [{
                title: 'Data List Whistleblower Waiting',
                extend: 'excelHtml5',
                text: '<i class="bi bi-download text-white"></i>',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": `${baseUrl}/dt_list_wb_by_status`,
                "data": {
                    status: 1
                    // start: '2025-04-01',
                    // end: '2025-04-30'
                },
            },
            "columns": [{
                    "data": "id_wb",
                    "render": function(data, type, row, meta) {
                        return `<a role="button" class="badge bg-yellow" style="cursor:pointer; margin-left:10px;" onclick="show_update_progres_wb('${row['id_wb']}', '${row['id_status']}', '', '', '')">
                                    ${data}
                                </a>`;
                    },
                    "className": "text-center"
                },
                {
                    "data": "status",
                    "className": "text-center"
                },
                {
                    "data": "id_wb", // addnew
                    "render": function(data, type, row, meta) {
                        kategori = ''
                        if (row['id_created_by'] == 8636) {
                            kategori = 'Eksternal';
                        } else {
                            kategori = 'Internal';
                        }
                        return kategori;
                    },
                },
                {
                    "data": "laporan",
                    "className": "text-center"
                },
                {
                    "data": "nama_department",
                    "render": function(data, type, row, meta) {
                        if (row['id_created_by'] == 8636) {
                            return row['department_ext'];
                        } else {
                            return data;
                        }
                    },
                    "className": "text-center"
                },
                {
                    "data": "nama_employee",
                    "render": function(data, type, row, meta) {

                        employee_name = (row['id_created_by'] == 8636) ? row['employee_ext'] : data; // updtnew
                        profile_picture = (row['id_created_by'] == 8636) ? 'anonim.jpg' : row['profile_picture']; // updtnew

                        // addnew update
                        return `<a role="button" class="badge bg-blue" style="cursor:pointer; margin-left:10px;" onclick="show_detail_employee('${employee_name}', '${row['username']}', '${profile_picture}')">
                                    <i class="bi bi-eye"></i> Detail
                                </a>`;
                    }
                },
                {
                    "data": "bukti",
                    'render': function(data, type, row) {
                        if (data != "" && data != null) {
                            if (data.includes(".jpg") || data.includes(".jpeg") || data.includes(".png") || data.includes(".gif")) {
                                return `<a href="<?= base_url('uploads/wb_files/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>`;
                            } else {
                                return `<a href="<?= base_url('uploads/wb_files/') ?>${data}" class="text-success" download><i class="bi bi-file-earmark-arrow-down"></i></a>`;
                            }
                        } else {
                            return ``;
                        }
                    },
                    'className': 'text-center'
                },
                // {
                //     "data": "nama_employee",
                //     "render": function(data, type, row, meta) {

                //         employee_name = (row['id_created_by'] == 8636) ? row['employee_ext'] : data; // updtnew
                //         profile_picture = (row['id_created_by'] == 8636) ? 'anonim.jpg' : row['profile_picture']; // updtnew

                //         // addnew update
                //         return `<a role="button" class="badge bg-blue" style="cursor:pointer; margin-left:10px;" onclick="show_detail_employee('${employee_name}', '${row['username']}', '${profile_picture}')">
                //                     <i class="bi bi-eye"></i> Detail
                //                 </a>`;
                //     }
                // },
                {
                    "data": "keterangan",
                    "className": "text-center"
                },
                {
                    "data": "proses_at",
                    "className": "text-center"
                },
                {
                    "data": "proses_by",
                    "className": "text-center"
                },
            ]
        });
    }

    function list_wb_progres() {
        $("#modal_list_wb_progres").modal("show");

        $('#dt_list_wb_progres').DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "autoWidth": false,
            "destroy": true,
            "responsive": true,
            "dom": 'Bfrtip',
            buttons: [{
                title: 'Data List Whistleblower Progress',
                extend: 'excelHtml5',
                text: '<i class="bi bi-download text-white"></i>',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": `${baseUrl}/dt_list_wb_by_status`,
                "data": {
                    status: 2
                    // start: '2025-04-01',
                    // end: '2025-04-30'
                },
            },
            "columns": [{
                    "data": "id_wb",
                    "render": function(data, type, row, meta) {
                        return `<a role="button" class="badge bg-primary" style="cursor:pointer; margin-left:10px;" onclick="show_update_progres_wb('${row['id_wb']}', '${row['id_status']}', '${row['id_kategori_aduan']}', '${row['id_status_fu']}', '${row['pic_eskalasi']}')">
                                    ${data}
                                </a>`;
                    },
                    "className": "text-center"
                },
                {
                    "data": "status",
                    "className": "text-center"
                },
                {
                    "data": "id_wb", // addnew
                    "render": function(data, type, row, meta) {
                        kategori = ''
                        if (row['id_created_by'] == 8636) {
                            kategori = 'Eksternal';
                        } else {
                            kategori = 'Internal';
                        }
                        return kategori;
                    },
                },
                {
                    "data": "laporan",
                    "className": "text-center"
                },
                {
                    "data": "nama_department",
                    "render": function(data, type, row, meta) {
                        if (row['id_created_by'] == 8636) {
                            return row['department_ext'];
                        } else {
                            return data;
                        }
                    },
                    "className": "text-center"
                },
                {
                    "data": "nama_employee",
                    "render": function(data, type, row, meta) {

                        employee_name = (row['id_created_by'] == 8636) ? row['employee_ext'] : data; // updtnew
                        profile_picture = (row['id_created_by'] == 8636) ? 'anonim.jpg' : row['profile_picture']; // updtnew

                        // addnew update
                        return `<a role="button" class="badge bg-blue" style="cursor:pointer; margin-left:10px;" onclick="show_detail_employee('${employee_name}', '${row['username']}', '${profile_picture}')">
                                    <i class="bi bi-eye"></i> Detail
                                </a>`;
                    }
                },
                {
                    "data": "bukti",
                    'render': function(data, type, row) {
                        if (data != "" && data != null) {
                            if (data.includes(".jpg") || data.includes(".jpeg") || data.includes(".png") || data.includes(".gif")) {
                                return `<a href="<?= base_url('uploads/wb_files/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>`;
                            } else {
                                return `<a href="<?= base_url('uploads/wb_files/') ?>${data}" class="text-success" download><i class="bi bi-file-earmark-arrow-down"></i></a>`;
                            }
                        } else {
                            return ``;
                        }
                    },
                    'className': 'text-center'
                },
                {
                    "data": "kategori_aduan",
                    "className": "text-center"
                },
                {
                    "data": "status_fu",
                    "className": "text-center"
                },
                {
                    "data": "pic_eskalasi_wb",
                    "className": "text-center"
                },
                {
                    "data": "keterangan",
                    "className": "text-center"
                },
                {
                    "data": "dokumen_penyelesaian", // updev
                    "render": function(data, type, row) {
                        if (data != "" && data != null) {
                            if (data.includes(".jpg") || data.includes(".jpeg") || data.includes(".png") || data.includes(".gif")) {
                                return `<a href="<?= base_url('uploads/wb_files/dokumen/') ?>${data}" class="text-success" data-fancybox data-lightbox="1" data-caption="${data}"><i class="bi bi-file-earmark-image"></i></a>`;
                            } else {
                                return `<a href="<?= base_url('uploads/wb_files/dokumen') ?>${data}" class="text-success" download><i class="bi bi-file-earmark-arrow-down"></i></a>`;
                            }
                        } else {
                            return ``;
                        }
                    },
                    "className": "text-center"
                },
                {
                    "data": "proses_at",
                    "className": "text-center"
                },
                {
                    "data": "proses_by",
                    "className": "text-center"
                },
            ]
        });
    }

    // history
    function show_history_wb(id_wb) {
        $("#modal_history_wb").modal("show");
        // console.log(id_wb);
        // return;
        $('#dt_history_wb').DataTable({
            "lengthChange": false,
            "searching": true,
            "info": true,
            "paging": true,
            "autoWidth": false,
            "destroy": true,
            "responsive": true,
            "dom": 'Bfrtip',
            buttons: [{
                title: 'Data History Whistleblower',
                extend: 'excelHtml5',
                text: '<i class="bi bi-download text-white"></i>',
                footer: true
            }],
            "ajax": {
                "dataType": 'json',
                "type": "POST",
                "url": `${baseUrl}/dt_history_wb`,
                "data": {
                    id_wb: id_wb
                    // start: '2025-04-01',
                    // end: '2025-04-30'
                },
            },
            "columns": [{
                    "data": "id_wb",
                    // "render": function(data, type, row, meta) {
                    //     return `<a role="button" class="badge bg-primary" style="cursor:pointer; margin-left:10px;" onclick="show_update_progres_wb('${row['id_wb']}', '${row['id_status']}', '${row['id_kategori_aduan']}', '${row['id_status_fu']}', '${row['pic_eskalasi']}')">
                    //                 ${data}
                    //             </a>`;
                    // },
                    "className": "text-center"
                },
                {
                    "data": "status",
                    "className": "text-center"
                },
                {
                    "data": "kategori_aduan",
                    "className": "text-center"
                },
                {
                    "data": "status_fu",
                    "className": "text-center"
                },
                {
                    "data": "pic_eskalasi",
                },
                {
                    "data": "keterangan",
                    "className": "text-center"
                },
                {
                    "data": "proses_at",
                    "className": "text-center"
                },
                {
                    "data": "proses_by",
                    "render": function(data, type, row, meta) {
                        if (row['status'] == 'Waiting' && row['keterangan'] == 'Pengaduan Whistleblower') {
                            return 'Anonim';
                        } else {
                            return data;
                        }
                    },
                    "className": "text-center"
                },
            ]
        });
    }

    // Event ketika modal ditutup
    // $('#myModal').on('hidden.bs.modal', function () {
    //     table.ajax.reload(); // Reload data datatable
    // });
</script>